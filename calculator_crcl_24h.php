<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

function crclCategory(float $value): string
{
    if ($value >= 90.0) {
        return "G1";
    }
    if ($value >= 60.0) {
        return "G2";
    }
    if ($value >= 45.0) {
        return "G3a";
    }
    if ($value >= 30.0) {
        return "G3b";
    }
    if ($value >= 15.0) {
        return "G4";
    }

    return "G5";
}

function crclCategoryDescription(string $category): string
{
    $map = [
        "G1" => "normálna alebo vysoká filtrácia",
        "G2" => "mierne znížená filtrácia",
        "G3a" => "mierne až stredne znížená filtrácia",
        "G3b" => "stredne až výrazne znížená filtrácia",
        "G4" => "výrazne znížená filtrácia",
        "G5" => "zlyhanie obličiek",
    ];

    return $map[$category] ?? "";
}

/** Prepočet koncentrácie kreatinínu na mg/dL (jednotky sa vo vzorci krátia, ale konvertujeme pre istotu). */
function crclCreatinineToMgDl(float $value, string $unit): float
{
    return match ($unit) {
        "umol_l" => $value / 88.4,
        "mmol_l" => $value * 1000.0 / 88.4,
        default  => $value, // mg_dl
    };
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "p_cr_value" => (string) ($_POST["p_cr_value"] ?? ""),
    "p_cr_unit" => (string) ($_POST["p_cr_unit"] ?? "umol_l"),
    "u_cr_value" => (string) ($_POST["u_cr_value"] ?? ""),
    "u_cr_unit" => (string) ($_POST["u_cr_unit"] ?? "mmol_l"),
    "urine_volume_ml" => (string) ($_POST["urine_volume_ml"] ?? ""),
    "collection_hours" => (string) ($_POST["collection_hours"] ?? "24"),
    "height_cm" => (string) ($_POST["height_cm"] ?? ""),
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" =>
        (string) ($_POST["patient_insurance_code"] ?? ""),
    "examination_date" => (string) ($_POST["examination_date"] ?? date("Y-m-d")),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_crcl_24h');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $pCrValue = calculatorParsePositiveFloat($form["p_cr_value"]);
        if ($pCrValue === null) {
            $errors[] = "Sérový kreatinín musí byť kladné číslo.";
        }
        $pCrUnit = in_array($form["p_cr_unit"], ["umol_l", "mg_dl"], true)
            ? $form["p_cr_unit"]
            : "";
        if ($pCrUnit === "") {
            $errors[] = "Vyberte jednotku sérového kreatinínu.";
        }

        $uCrValue = calculatorParsePositiveFloat($form["u_cr_value"]);
        if ($uCrValue === null) {
            $errors[] = "Močový kreatinín musí byť kladné číslo.";
        }
        $uCrUnit = in_array($form["u_cr_unit"], ["umol_l", "mmol_l", "mg_dl"], true)
            ? $form["u_cr_unit"]
            : "";
        if ($uCrUnit === "") {
            $errors[] = "Vyberte jednotku močového kreatinínu.";
        }

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

        // Voliteľná BSA normalizácia — výška aj hmotnosť musia byť obe alebo žiadna
        $heightCm = null;
        $weightKg = null;
        $hasHeight = trim($form["height_cm"]) !== "";
        $hasWeight = trim($form["weight_kg"]) !== "";
        if ($hasHeight || $hasWeight) {
            $heightCm = calculatorParsePositiveFloat($form["height_cm"]);
            $weightKg = calculatorParsePositiveFloat($form["weight_kg"]);
            if ($heightCm === null || $weightKg === null) {
                $errors[] = "Pre normalizáciu na 1,73 m² zadajte výšku aj hmotnosť (kladné čísla).";
            } elseif ($heightCm < 100.0 || $heightCm > 230.0) {
                $errors[] = "Výška mimo očakávaného rozsahu (100 – 230 cm).";
            } elseif ($weightKg < 20.0 || $weightKg > 300.0) {
                $errors[] = "Hmotnosť mimo očakávaného rozsahu (20 – 300 kg).";
            }
        }

        if (empty($errors)) {
            $pCrMgDl = crclCreatinineToMgDl((float) $pCrValue, $pCrUnit);
            $uCrMgDl = crclCreatinineToMgDl((float) $uCrValue, $uCrUnit);
            $timeMin = (float) $collectionHours * 60.0;

            // Meraný klírens: CrCl = (U_cr × V) / (P_cr × T)
            $crcl = ($uCrMgDl * (float) $urineVolume) / ($pCrMgDl * $timeMin);
            $crclRounded = round($crcl, 1);

            $crclNorm = null;
            $bsa = null;
            $gCategory = null;
            $gDescription = null;
            if ($heightCm !== null && $weightKg !== null) {
                // Du Bois BSA
                $bsa = 0.007184 * pow((float) $heightCm, 0.725) * pow((float) $weightKg, 0.425);
                $crclNorm = round($crcl * 1.73 / $bsa, 1);
                $gCategory = crclCategory($crclNorm);
                $gDescription = crclCategoryDescription($gCategory);
            }

            $calculated = [
                "crcl" => $crclRounded,
                "crcl_norm" => $crclNorm,
                "bsa" => $bsa !== null ? round($bsa, 2) : null,
                "g_category" => $gCategory,
                "g_description" => $gDescription,
                "p_cr_mg_dl" => round($pCrMgDl, 3),
                "u_cr_mg_dl" => round($uCrMgDl, 1),
                "urine_volume_ml" => round((float) $urineVolume, 0),
                "collection_hours" => round((float) $collectionHours, 1),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "p_cr_value" => round((float) $pCrValue, 2),
                            "p_cr_unit" => $pCrUnit,
                            "u_cr_value" => round((float) $uCrValue, 2),
                            "u_cr_unit" => $uCrUnit,
                            "urine_volume_ml" => round((float) $urineVolume, 0),
                            "collection_hours" => round((float) $collectionHours, 1),
                            "height_cm" => $heightCm !== null ? round((float) $heightCm, 1) : null,
                            "weight_kg" => $weightKg !== null ? round((float) $weightKg, 1) : null,
                        ];

                        $resultPayload = [
                            "crcl" => $crclRounded,
                            "crcl_norm" => $crclNorm,
                            "bsa" => $bsa !== null ? round($bsa, 2) : null,
                            "g_category" => $gCategory,
                            "g_description" => $gDescription,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "crcl_24h_measured",
                                "24-h klírens kreatinínu (meraný)",
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
                        error_log(
                            "calculator_crcl_24h save error: " . $e->getMessage(),
                        );
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
            "crcl_24h_measured",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_crcl_24h fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "24-h klírens kreatinínu (meraný CrCl) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_crcl_24h.php";
  $seoDescription =
      "Nefrologická kalkulačka meraného 24-hodinového klírensu kreatinínu z moču a séra, s voliteľnou normalizáciou na povrch tela (1,73 m²) podľa Du Bois. Pre lekárov na Slovensku.";
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
                  "name" => "24-h klírens kreatinínu (meraný)",
                  "item" => $baseUrl . "calculator_crcl_24h.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="crcl_24h_measured">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Kalkulačka 24-h klírensu kreatinínu";
    $headerIntro = "Meraný CrCl zo zberu moču";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>24-h klírens kreatinínu (meraný)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + povinné vstupy pre výpočet.</p>

                <div class="info-box">
                    <strong>Kedy použiť meraný klírens:</strong> pri atypickej svalovej hmote
                    (kachexia, amputácie, kulturistika), v tehotenstve, pri rýchlo sa meniacej
                    funkcii obličiek alebo pred dávkovaním liekov s úzkym terapeutickým oknom,
                    keď je odhad eGFR z kreatinínu neistý. Presnosť stojí a padá so <em>správnosťou
                    zberu moču</em> — neúplný zber meraný klírens podhodnotí.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — meraný klírens kreatinínu</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{CrCl} \,[\text{mL/min}] = \frac{U_{cr} \times V_{moč}}{P_{cr} \times t} \]</div>
                        <div class="calc-formula-line">\[ \text{CrCl}_{norm} = \text{CrCl} \times \frac{1{,}73}{\text{BSA}}, \quad \text{BSA} = 0{,}007184 \times v^{0{,}725} \times h^{0{,}425} \]</div>
                        <div class="calc-formula-vars">
                            $U_{cr}, P_{cr} = \text{kreatinín v moči a sére (rovnaké jednotky)}$ &bull;
                            $V_{moč} = \text{objem moču [mL]}$ &bull;
                            $t = \text{čas zberu [min]}$ &bull;
                            $v = \text{výška [cm]}$ &bull;
                            $h = \text{hmotnosť [kg]}$
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://www.mdcalc.com/calc/43/creatinine-clearance-cockcroft-gault-equation" target="_blank" rel="noopener noreferrer">MDCalc (CrCl)</a> &ensp;&bull;&ensp;
                    <a href="https://www.kidney.org/professionals/kdoqi/gfr_calculator" target="_blank" rel="noopener noreferrer">NKF / KDOQI</a>
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars(
                        $message,
                    ) ?></p></div>
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

                <form method="POST" action="calculator_crcl_24h.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="p_cr_value">S-kreatinín (sérum)</label>
                                <input type="text" id="p_cr_value" name="p_cr_value" required class="form-control" value="<?= htmlspecialchars($form["p_cr_value"]) ?>" placeholder="napr. 95">
                            </div>
                            <div class="form-group">
                                <label for="p_cr_unit">Jednotka S-kreatinínu</label>
                                <select id="p_cr_unit" name="p_cr_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form["p_cr_unit"] === "umol_l" ? "selected" : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form["p_cr_unit"] === "mg_dl" ? "selected" : "" ?>>mg/dL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="u_cr_value">U-kreatinín (moč)</label>
                                <input type="text" id="u_cr_value" name="u_cr_value" required class="form-control" value="<?= htmlspecialchars($form["u_cr_value"]) ?>" placeholder="napr. 8,5">
                            </div>
                            <div class="form-group">
                                <label for="u_cr_unit">Jednotka U-kreatinínu</label>
                                <select id="u_cr_unit" name="u_cr_unit" class="form-control" required>
                                    <option value="mmol_l" <?= $form["u_cr_unit"] === "mmol_l" ? "selected" : "" ?>>mmol/L</option>
                                    <option value="umol_l" <?= $form["u_cr_unit"] === "umol_l" ? "selected" : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form["u_cr_unit"] === "mg_dl" ? "selected" : "" ?>>mg/dL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="urine_volume_ml">Objem moču za zber (mL)</label>
                                <input type="text" id="urine_volume_ml" name="urine_volume_ml" required class="form-control" value="<?= htmlspecialchars($form["urine_volume_ml"]) ?>" placeholder="napr. 1800">
                            </div>
                            <div class="form-group">
                                <label for="collection_hours">Čas zberu (hodiny)</label>
                                <input type="text" id="collection_hours" name="collection_hours" required class="form-control" value="<?= htmlspecialchars($form["collection_hours"]) ?>" placeholder="24">
                            </div>
                            <div class="form-group">
                                <label for="height_cm">Výška (cm) <span class="optional">— pre 1,73 m²</span></label>
                                <input type="text" id="height_cm" name="height_cm" class="form-control" value="<?= htmlspecialchars($form["height_cm"]) ?>" placeholder="voliteľné">
                            </div>
                            <div class="form-group">
                                <label for="weight_kg">Hmotnosť (kg) <span class="optional">— pre 1,73 m²</span></label>
                                <input type="text" id="weight_kg" name="weight_kg" class="form-control" value="<?= htmlspecialchars($form["weight_kg"]) ?>" placeholder="voliteľné">
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
                    $hasNorm = $calculated["crcl_norm"] !== null;
                    $riskCls = $hasNorm ? egfrRiskClass((string) $calculated["g_category"]) : "";
                    $barValue = $hasNorm ? (float) $calculated["crcl_norm"] : (float) $calculated["crcl"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["crcl"], 1, ",", " ")) ?></span>
                                <span class="calc-result-unit">mL/min</span>
                            </div>
                            <?php if ($hasNorm): ?>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["g_category"]) ?>
                                <span><?= htmlspecialchars((string) $calculated["g_description"]) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($hasNorm): ?>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$barValue ?>"
                             data-risk-max="120"
                             data-risk-label="CrCl (1,73 m²)"></div>
                        <p class="calc-result-detail"><strong>Normalizovaný klírens:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["crcl_norm"], 1, ",", " ")) ?> mL/min/1,73 m²
                            &ensp;&bull;&ensp;<strong>BSA (Du Bois):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["bsa"], 2, ",", " ")) ?> m²
                        </p>
                        <?php endif; ?>
                        <p class="calc-result-detail"><strong>Sérum (mg/dL):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["p_cr_mg_dl"], 3, ",", " ")) ?>
                            &ensp;&bull;&ensp;<strong>Moč (mg/dL):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["u_cr_mg_dl"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp;<strong>Zber:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["urine_volume_ml"], 0, ",", " ")) ?> mL /
                            <?= htmlspecialchars(number_format((float)$calculated["collection_hours"], 1, ",", " ")) ?> h
                        </p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=crcl_24h_measured" class="btn-secondary">História CrCl (24-h)</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_crcl_24h.php',
                function (array $row): void {
                    $result   = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $crcl     = (float) ($result['crcl'] ?? 0);
                    $norm     = $result['crcl_norm'] ?? null;
                    $category = (string) ($result['g_category'] ?? '');
                    echo htmlspecialchars(number_format($crcl, 1, ',', ' ')) . ' mL/min';
                    if ($norm !== null) {
                        echo ' (' . htmlspecialchars(number_format((float) $norm, 1, ',', ' ')) . ' /1,73 m²';
                        if ($category !== '') {
                            echo ', ' . htmlspecialchars($category);
                        }
                        echo ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime(
        "patient_autofill.js",
    ) ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
