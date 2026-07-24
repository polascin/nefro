<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** CSS trieda podľa elektrolytového klírensu voľnej vody (tendencia nátriémie). */
function fwcClass(float $efwc): string
{
    // EFWC > 0 → tendencia ↑ Na (vylučovanie voľnej vody); < 0 → tendencia ↓ Na.
    if ($efwc < -0.5) {
        return 'risk-high';      // retencia voľnej vody → riziko poklesu Na (SIADH)
    }
    if ($efwc > 0.5) {
        return 'risk-moderate';  // strata voľnej vody → riziko vzostupu Na
    }
    return 'risk-low';           // približne neutrálne
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "urine_volume_ml" => (string) ($_POST["urine_volume_ml"] ?? ""),
    "collection_hours" => (string) ($_POST["collection_hours"] ?? "24"),
    "p_osm" => (string) ($_POST["p_osm"] ?? ""),
    "u_osm" => (string) ($_POST["u_osm"] ?? ""),
    "p_na" => (string) ($_POST["p_na"] ?? ""),
    "u_na" => (string) ($_POST["u_na"] ?? ""),
    "u_k" => (string) ($_POST["u_k"] ?? ""),
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" => (string) ($_POST["patient_insurance_code"] ?? ""),
    "examination_date" => (string) ($_POST["examination_date"] ?? date("Y-m-d")),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_free_water');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $urineVolume = calculatorParsePositiveFloat($form["urine_volume_ml"]);
        if ($urineVolume === null) {
            $errors[] = "Objem moču musí byť kladné číslo (mL).";
        } elseif ($urineVolume < 100.0 || $urineVolume > 15000.0) {
            $errors[] = "Objem moču mimo očakávaného rozsahu (100 – 15 000 mL).";
        }

        $collectionHours = calculatorParsePositiveFloat($form["collection_hours"]);
        if ($collectionHours === null) {
            $errors[] = "Čas zberu musí byť kladné číslo (hodiny).";
        } elseif ($collectionHours < 1.0 || $collectionHours > 48.0) {
            $errors[] = "Čas zberu mimo očakávaného rozsahu (1 – 48 hodín).";
        }

        // Klasický klírens voľnej vody — osmolality (obe alebo žiadna)
        $pOsm = null;
        $uOsm = null;
        $hasClassic = trim($form["p_osm"]) !== "" || trim($form["u_osm"]) !== "";
        if ($hasClassic) {
            $pOsm = calculatorParsePositiveFloat($form["p_osm"]);
            $uOsm = calculatorParsePositiveFloat($form["u_osm"]);
            if ($pOsm === null || $uOsm === null) {
                $errors[] = "Pre klasický klírens zadajte osmolalitu plazmy aj moču.";
            } else {
                if ($pOsm < 250.0 || $pOsm > 350.0) {
                    $errors[] = "Osmolalita plazmy mimo rozsahu (250 – 350 mosm/kg).";
                }
                if ($uOsm < 30.0 || $uOsm > 1400.0) {
                    $errors[] = "Osmolalita moču mimo rozsahu (30 – 1400 mosm/kg).";
                }
            }
        }

        // Elektrolytový klírens voľnej vody — Na/K (všetky tri alebo žiadne)
        $pNa = null;
        $uNa = null;
        $uK = null;
        $hasEfwc = trim($form["p_na"]) !== "" || trim($form["u_na"]) !== "" || trim($form["u_k"]) !== "";
        if ($hasEfwc) {
            $pNa = calculatorParsePositiveFloat($form["p_na"]);
            $uNa = calculatorParsePositiveFloat($form["u_na"]);
            $uK = calculatorParsePositiveFloat($form["u_k"]);
            if ($pNa === null || $uNa === null || $uK === null) {
                $errors[] = "Pre elektrolytový klírens zadajte plazmatický Na, močový Na aj močový K.";
            } else {
                if ($pNa < 110.0 || $pNa > 175.0) {
                    $errors[] = "Plazmatický sodík mimo rozsahu (110 – 175 mmol/l).";
                }
                if ($uNa < 1.0 || $uNa > 300.0) {
                    $errors[] = "Močový sodík mimo rozsahu (1 – 300 mmol/l).";
                }
                if ($uK < 1.0 || $uK > 150.0) {
                    $errors[] = "Močový draslík mimo rozsahu (1 – 150 mmol/l).";
                }
            }
        }

        if (!$hasClassic && !$hasEfwc) {
            $errors[] = "Zadajte aspoň jednu sadu: osmolality (klasický klírens) alebo Na/K (elektrolytový klírens).";
        }

        if (empty($errors)) {
            $vMlMin = (float) $urineVolume / ((float) $collectionHours * 60.0);

            $cOsm = null;
            $cH2O = null;
            if ($pOsm !== null && $uOsm !== null) {
                $cOsm = ($uOsm * $vMlMin) / $pOsm;
                $cH2O = $vMlMin - $cOsm;
            }

            $efwc = null;
            if ($pNa !== null && $uNa !== null && $uK !== null) {
                $efwc = $vMlMin * (1.0 - ($uNa + $uK) / $pNa);
            }

            // Trieda podľa elektrolytového (preferovaného), inak klasického klírensu
            $primary = $efwc ?? $cH2O ?? 0.0;
            $doseClass = fwcClass((float) $primary);

            $calculated = [
                "v_ml_min" => round($vMlMin, 2),
                "v_l_day" => round($vMlMin * 1.44, 2),
                "c_osm" => $cOsm !== null ? round($cOsm, 2) : null,
                "c_h2o" => $cH2O !== null ? round($cH2O, 2) : null,
                "c_h2o_l_day" => $cH2O !== null ? round($cH2O * 1.44, 2) : null,
                "efwc" => $efwc !== null ? round($efwc, 2) : null,
                "efwc_l_day" => $efwc !== null ? round($efwc * 1.44, 2) : null,
                "dose_class" => $doseClass,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "urine_volume_ml" => round((float) $urineVolume, 0),
                            "collection_hours" => round((float) $collectionHours, 1),
                            "p_osm" => $pOsm !== null ? round((float) $pOsm, 0) : null,
                            "u_osm" => $uOsm !== null ? round((float) $uOsm, 0) : null,
                            "p_na" => $pNa !== null ? round((float) $pNa, 0) : null,
                            "u_na" => $uNa !== null ? round((float) $uNa, 0) : null,
                            "u_k" => $uK !== null ? round((float) $uK, 0) : null,
                        ];
                        $resultPayload = [
                            "c_h2o_l_day" => $calculated["c_h2o_l_day"],
                            "efwc_l_day" => $calculated["efwc_l_day"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "free_water_clearance",
                                "Klírens voľnej vody",
                                $patient,
                                $inputPayload,
                                $resultPayload,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený do databázy.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log("calculator_free_water save error: " . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults(
            $pdo,
            (int) $_SESSION["user_id"],
            "free_water_clearance",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_free_water fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Klírens voľnej vody (CH₂O a elektrolytový) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_free_water.php";
  $seoDescription =
      "Kalkulačka klírensu voľnej vody: klasický klírens (CH₂O) z osmolality moču a plazmy a elektrolytový klírens voľnej vody (EFWC) z Na a K. Pomáha pri manažmente hyponatrémie a hypernatrémie.";
  $baseUrl = "https://nefro.polascin.net/";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => "BreadcrumbList",
          "itemListElement" => [
              [
                  "@type" => "ListItem",
                  "position" => 1,
                  "name" => "Domov",
                  "item" => $baseUrl,
              ],
              [
                  "@type" => "ListItem",
                  "position" => 2,
                  "name" => "Kalkulačky",
                  "item" => $baseUrl . "calculators.php",
              ],
              [
                  "@type" => "ListItem",
                  "position" => 3,
                  "name" => "Klírens voľnej vody",
                  "item" => $baseUrl . "calculator_free_water.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="free_water_clearance">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Kalkulačka klírensu voľnej vody";
    $headerIntro = "Klasický (CH₂O) a elektrolytový (EFWC)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Klírens voľnej vody</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + aspoň jedna sada vstupov (osmolality alebo Na/K).</p>

                <div class="info-box">
                    <strong>Načo:</strong> klírens voľnej vody opisuje, či obličky čistú vodu
                    <em>vylučujú</em> alebo <em>zadržiavajú</em> — kľúčové pri dysnatriémiách.
                    <strong>Elektrolytový klírens (EFWC)</strong> je pri poruchách sodíka
                    výpovednejší než klasický CH₂O, lebo zohľadňuje len Na a K (nie močovinu/glukózu).
                    EFWC <strong>&gt; 0</strong> = strata voľnej vody (sodík má tendenciu stúpať);
                    EFWC <strong>&lt; 0</strong> = retencia voľnej vody (sodík má tendenciu klesať, napr. SIADH).
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorce — klírens voľnej vody</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ V = \frac{V_{moč}}{t}, \quad C_{osm} = \frac{U_{osm} \times V}{P_{osm}}, \quad C_{H_2O} = V - C_{osm} \]</div>
                        <div class="calc-formula-line">\[ \text{EFWC} = V \times \left(1 - \frac{U_{Na} + U_{K}}{P_{Na}}\right) \]</div>
                        <div class="calc-formula-vars">
                            $V = \text{prietok moču [mL/min]}$ &bull;
                            $U_{osm}, P_{osm} = \text{osmolalita moču/plazmy}$ &bull;
                            $U_{Na}, U_{K}, P_{Na} = \text{Na/K v moči, Na v plazme [mmol/l]}$
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_free_water.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Zber moču</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="urine_volume_ml">Objem moču za zber (mL) <span class="required">*</span></label>
                                <input type="text" id="urine_volume_ml" name="urine_volume_ml" required class="form-control" value="<?= htmlspecialchars($form["urine_volume_ml"]) ?>" placeholder="napr. 1800">
                            </div>
                            <div class="form-group">
                                <label for="collection_hours">Čas zberu (hodiny) <span class="required">*</span></label>
                                <input type="text" id="collection_hours" name="collection_hours" required class="form-control" value="<?= htmlspecialchars($form["collection_hours"]) ?>" placeholder="24">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Klasický klírens (osmolality) <span class="optional">— voliteľné</span></h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="p_osm">Osmolalita plazmy (mosm/kg)</label>
                                <input type="text" id="p_osm" name="p_osm" class="form-control" value="<?= htmlspecialchars($form["p_osm"]) ?>" placeholder="napr. 290">
                            </div>
                            <div class="form-group">
                                <label for="u_osm">Osmolalita moču (mosm/kg)</label>
                                <input type="text" id="u_osm" name="u_osm" class="form-control" value="<?= htmlspecialchars($form["u_osm"]) ?>" placeholder="napr. 500">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Elektrolytový klírens (Na/K) <span class="optional">— voliteľné, výpovednejší</span></h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="p_na">Plazmatický sodík P-Na (mmol/l)</label>
                                <input type="text" id="p_na" name="p_na" class="form-control" value="<?= htmlspecialchars($form["p_na"]) ?>" placeholder="napr. 130">
                            </div>
                            <div class="form-group">
                                <label for="u_na">Močový sodík U-Na (mmol/l)</label>
                                <input type="text" id="u_na" name="u_na" class="form-control" value="<?= htmlspecialchars($form["u_na"]) ?>" placeholder="napr. 70">
                            </div>
                            <div class="form-group">
                                <label for="u_k">Močový draslík U-K (mmol/l)</label>
                                <input type="text" id="u_k" name="u_k" class="form-control" value="<?= htmlspecialchars($form["u_k"]) ?>" placeholder="napr. 30">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null):
                    $doseCls = (string) $calculated["dose_class"];
                    $hasEfwcRes = $calculated["efwc"] !== null;
                    $hasClassicRes = $calculated["c_h2o"] !== null;
                    $bigVal = $hasEfwcRes ? (float) $calculated["efwc_l_day"] : (float) $calculated["c_h2o_l_day"];
                    $bigLabel = $hasEfwcRes ? "EFWC" : "CH₂O";
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($doseCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format($bigVal, 2, ",", " ")) ?></span>
                                <span class="calc-result-unit">L/deň (<?= htmlspecialchars($bigLabel) ?>)</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($doseCls) ?>">
                                <?= $bigVal > 0 ? "strata voľnej vody" : ($bigVal < 0 ? "retencia voľnej vody" : "neutrálne") ?>
                                <span><?= $bigVal > 0 ? "Na ↑ tendencia" : ($bigVal < 0 ? "Na ↓ tendencia" : "") ?></span>
                            </div>
                        </div>
                        <p class="calc-result-detail"><strong>Prietok moču:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["v_ml_min"], 2, ",", " ")) ?> mL/min
                            (<?= htmlspecialchars(number_format((float)$calculated["v_l_day"], 2, ",", " ")) ?> L/deň)
                        </p>
                        <?php if ($hasEfwcRes): ?>
                        <p class="calc-result-detail"><strong>Elektrolytový klírens (EFWC):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["efwc"], 2, ",", " ")) ?> mL/min
                            (<?= htmlspecialchars(number_format((float)$calculated["efwc_l_day"], 2, ",", " ")) ?> L/deň)
                        </p>
                        <?php endif; ?>
                        <?php if ($hasClassicRes): ?>
                        <p class="calc-result-detail"><strong>Klasický klírens (CH₂O):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["c_h2o"], 2, ",", " ")) ?> mL/min
                            (<?= htmlspecialchars(number_format((float)$calculated["c_h2o_l_day"], 2, ",", " ")) ?> L/deň)
                            &ensp;&bull;&ensp;<strong>Osmolárny klírens:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["c_osm"], 2, ",", " ")) ?> mL/min
                        </p>
                        <?php endif; ?>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=free_water_clearance" class="btn-secondary">História</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_free_water.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $efwc = $result['efwc_l_day'] ?? null;
                    $ch2o = $result['c_h2o_l_day'] ?? null;
                    if ($efwc !== null) {
                        echo 'EFWC ' . htmlspecialchars(number_format((float) $efwc, 2, ',', ' ')) . ' L/deň';
                    } elseif ($ch2o !== null) {
                        echo 'CH₂O ' . htmlspecialchars(number_format((float) $ch2o, 2, ',', ' ')) . ' L/deň';
                    } else {
                        echo '—';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
