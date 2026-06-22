<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Renálne body podľa eGFR (mL/min/1,73 m²) — Mehran 2004. */
function mehranRenalPoints(float $egfr): int
{
    if ($egfr >= 60.0) {
        return 0;
    }
    if ($egfr >= 40.0) {
        return 2;
    }
    if ($egfr >= 20.0) {
        return 4;
    }

    return 6;
}

/**
 * Riziková kategória pre celkové Mehran skóre.
 * @return array{0:string,1:string,2:string,3:string} [trieda, popis, CIN %, dialýza %]
 */
function mehranCategory(int $score): array
{
    if ($score <= 5) {
        return ['risk-low', 'Nízke riziko', '7,5 %', '0,04 %'];
    }
    if ($score <= 10) {
        return ['risk-moderate', 'Stredné riziko', '14,0 %', '0,12 %'];
    }
    if ($score <= 15) {
        return ['risk-high', 'Vysoké riziko', '26,1 %', '1,09 %'];
    }

    return ['risk-very-high', 'Veľmi vysoké riziko', '57,3 %', '12,6 %'];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "egfr" => (string) ($_POST["egfr"] ?? ""),
    "contrast_volume_ml" => (string) ($_POST["contrast_volume_ml"] ?? ""),
    "hypotension" => ($_POST["hypotension"] ?? "") === "1" ? "1" : "0",
    "iabp" => ($_POST["iabp"] ?? "") === "1" ? "1" : "0",
    "chf" => ($_POST["chf"] ?? "") === "1" ? "1" : "0",
    "anemia" => ($_POST["anemia"] ?? "") === "1" ? "1" : "0",
    "diabetes" => ($_POST["diabetes"] ?? "") === "1" ? "1" : "0",
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" =>
        (string) ($_POST["patient_insurance_code"] ?? ""),
    "examination_date" => (string) ($_POST["examination_date"] ?? date("Y-m-d")),
];

calculatorHandleLoadId($pdo, $form, $messages);
// Po načítaní uloženého výpočtu môžu byť binárne polia ako 0/1 z payloadu — normalizuj
foreach (["hypotension", "iabp", "chf", "anemia", "diabetes"] as $_bin) {
    $form[$_bin] = ((string) $form[$_bin]) === "1" ? "1" : "0";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_mehran');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);
        // Auto-doplniť vek z dát. narodenia / rodného čísla, ak pole ostalo prázdne
        if ($form["age_years"] === "") {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form["age_years"] = (string) $derived;
            }
        }

        $ageYears = filter_var($form["age_years"], FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 18, "max_range" => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = "Vek musí byť celé číslo v intervale 18 až 120 rokov.";
        }

        $egfr = calculatorParsePositiveFloat($form["egfr"]);
        if ($egfr === null) {
            $errors[] = "eGFR musí byť kladné číslo (mL/min/1,73 m²).";
        } elseif ($egfr > 200.0) {
            $errors[] = "eGFR mimo očakávaného rozsahu (≤ 200 mL/min/1,73 m²).";
        }

        // Objem kontrastu je voliteľný (0, ak sa ešte nepodal / neznámy)
        $contrastVolume = 0.0;
        if (trim($form["contrast_volume_ml"]) !== "") {
            $cv = calculatorParsePositiveFloat($form["contrast_volume_ml"]);
            if ($cv === null) {
                $errors[] = "Objem kontrastnej látky musí byť kladné číslo (mL).";
            } elseif ($cv > 2000.0) {
                $errors[] = "Objem kontrastnej látky mimo očakávaného rozsahu (≤ 2000 mL).";
            } else {
                $contrastVolume = (float) $cv;
            }
        }

        if (empty($errors)) {
            $hypo = $form["hypotension"] === "1";
            $iabp = $form["iabp"] === "1";
            $chf = $form["chf"] === "1";
            $anemia = $form["anemia"] === "1";
            $diabetes = $form["diabetes"] === "1";

            $agePts = (int) $ageYears > 75 ? 4 : 0;
            $renalPts = mehranRenalPoints((float) $egfr);
            $contrastPts = (int) round($contrastVolume / 100.0); // ≈ 1 bod / 100 mL
            $score =
                ($hypo ? 5 : 0) +
                ($iabp ? 5 : 0) +
                ($chf ? 5 : 0) +
                $agePts +
                ($anemia ? 3 : 0) +
                ($diabetes ? 3 : 0) +
                $contrastPts +
                $renalPts;

            [$riskCls, $riskLabel, $cinPct, $dialysisPct] = mehranCategory($score);

            $calculated = [
                "score" => $score,
                "risk_class" => $riskCls,
                "risk_label" => $riskLabel,
                "cin_pct" => $cinPct,
                "dialysis_pct" => $dialysisPct,
                "age_pts" => $agePts,
                "renal_pts" => $renalPts,
                "contrast_pts" => $contrastPts,
                "egfr" => round((float) $egfr, 1),
                "contrast_volume_ml" => round($contrastVolume, 0),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "age_years" => (int) $ageYears,
                            "egfr" => round((float) $egfr, 1),
                            "contrast_volume_ml" => round($contrastVolume, 0),
                            "hypotension" => $hypo ? "1" : "0",
                            "iabp" => $iabp ? "1" : "0",
                            "chf" => $chf ? "1" : "0",
                            "anemia" => $anemia ? "1" : "0",
                            "diabetes" => $diabetes ? "1" : "0",
                        ];

                        $resultPayload = [
                            "score" => $score,
                            "risk_label" => $riskLabel,
                            "cin_pct" => $cinPct,
                            "dialysis_pct" => $dialysisPct,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "mehran_ci_aki",
                                "Mehran skóre (kontrastom indukované AKI)",
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
                        error_log("calculator_mehran save error: " . $e->getMessage());
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
            "mehran_ci_aki",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_mehran fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Mehran skóre — riziko kontrastom indukovaného AKI | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_mehran.php";
  $seoDescription =
      "Nefrologická kalkulačka Mehran skóre pre riziko kontrastom indukovaného akútneho poškodenia obličiek (CI-AKI/CIN) pred koronarografiou a CT s kontrastom. Pre lekárov na Slovensku.";
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
                  "name" => "Mehran skóre (CI-AKI)",
                  "item" => $baseUrl . "calculator_mehran.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="mehran_ci_aki">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Mehran skóre (CI-AKI)";
    $headerIntro = "Riziko kontrastom indukovaného AKI";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Mehran skóre (kontrastom indukované AKI)</h2>
                <p class="auth-subtitle">Predprocedurálne riziko CI-AKI pred podaním jódovej kontrastnej látky.</p>

                <div class="info-box">
                    <strong>Kedy použiť:</strong> pred elektívnou koronarografiou/PCI alebo CT
                    s jódovou kontrastnou látkou na stratifikáciu rizika kontrastom indukovaného
                    akútneho poškodenia obličiek (CI-AKI, staršie CIN) a na cielenie preventívnych
                    opatrení (hydratácia, minimalizácia objemu kontrastu, vysadenie nefrotoxínov).
                    Pôvodne validované pre PCI (Mehran 2004).
                </div>

                <details open class="calc-formula-box">
                    <summary>Bodovanie — Mehran 2004</summary>
                    <div class="calc-formula-content">
                        <ul class="mb-0">
                            <li>Hypotenzia — <strong>5</strong> &bull; intraaortálna balónová kontrapulzácia (IABP) — <strong>5</strong> &bull; kongestívne srdcové zlyhanie (NYHA III/IV alebo pľúcny edém) — <strong>5</strong></li>
                            <li>Vek &gt; 75 rokov — <strong>4</strong> &bull; anémia (Hct &lt; 39 % muži / &lt; 36 % ženy) — <strong>3</strong> &bull; diabetes mellitus — <strong>3</strong></li>
                            <li>Objem kontrastu — <strong>1 bod / 100 mL</strong></li>
                            <li>eGFR &lt; 60: 40 – 60 → <strong>2</strong>, 20 – &lt; 40 → <strong>4</strong>, &lt; 20 → <strong>6</strong></li>
                        </ul>
                        <div class="calc-formula-vars">
                            Kategórie: ≤ 5 nízke (CIN 7,5 %) &bull; 6 – 10 stredné (14,0 %) &bull;
                            11 – 15 vysoké (26,1 %) &bull; ≥ 16 veľmi vysoké (57,3 %)
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčným kalkulátorom:</strong>
                    <a href="https://www.mdcalc.com/calc/10242/mehran-score-post-pci-contrast-nephropathy" target="_blank" rel="noopener noreferrer">MDCalc — Mehran</a>
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

                <form method="POST" action="calculator_mehran.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars($form["age_years"]) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="egfr">eGFR (mL/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars($form["egfr"]) ?>" placeholder="napr. 55">
                            </div>
                            <div class="form-group">
                                <label for="contrast_volume_ml">Objem kontrastu (mL) <span class="optional">— voliteľné</span></label>
                                <input type="text" id="contrast_volume_ml" name="contrast_volume_ml" class="form-control" value="<?= htmlspecialchars($form["contrast_volume_ml"]) ?>" placeholder="napr. 150 (alebo prázdne)">
                            </div>
                        </div>

                        <fieldset class="form-fieldset">
                            <legend>Klinické rizikové faktory</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="hypotension" value="1" <?= $form["hypotension"] === "1" ? "checked" : "" ?>> Hypotenzia <span class="form-check-pts">(5)</span></label>
                                <label class="form-check"><input type="checkbox" name="iabp" value="1" <?= $form["iabp"] === "1" ? "checked" : "" ?>> IABP (balónová kontrapulzácia) <span class="form-check-pts">(5)</span></label>
                                <label class="form-check"><input type="checkbox" name="chf" value="1" <?= $form["chf"] === "1" ? "checked" : "" ?>> Kongestívne srdcové zlyhanie <span class="form-check-pts">(5)</span></label>
                                <label class="form-check"><input type="checkbox" name="anemia" value="1" <?= $form["anemia"] === "1" ? "checked" : "" ?>> Anémia (Hct &lt; 39 % M / &lt; 36 % Ž) <span class="form-check-pts">(3)</span></label>
                                <label class="form-check"><input type="checkbox" name="diabetes" value="1" <?= $form["diabetes"] === "1" ? "checked" : "" ?>> Diabetes mellitus <span class="form-check-pts">(3)</span></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null):
                    $riskCls = (string) $calculated["risk_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= (int) $calculated["score"] ?></span>
                                <span class="calc-result-unit">bodov</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["risk_label"]) ?>
                            </div>
                        </div>
                        <p class="calc-result-detail"><strong>Riziko CI-AKI:</strong>
                            <?= htmlspecialchars((string) $calculated["cin_pct"]) ?>
                            &ensp;&bull;&ensp;<strong>Riziko dialýzy:</strong>
                            <?= htmlspecialchars((string) $calculated["dialysis_pct"]) ?>
                        </p>
                        <p class="calc-result-detail"><strong>Body — vek:</strong> <?= (int) $calculated["age_pts"] ?>
                            &ensp;&bull;&ensp;<strong>renálne (eGFR <?= htmlspecialchars(number_format((float)$calculated["egfr"], 1, ",", " ")) ?>):</strong> <?= (int) $calculated["renal_pts"] ?>
                            &ensp;&bull;&ensp;<strong>kontrast (<?= htmlspecialchars(number_format((float)$calculated["contrast_volume_ml"], 0, ",", " ")) ?> mL):</strong> <?= (int) $calculated["contrast_pts"] ?>
                        </p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=mehran_ci_aki" class="btn-secondary">História Mehran</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_mehran.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $score  = (int) ($result['score'] ?? 0);
                    $label  = (string) ($result['risk_label'] ?? '');
                    echo htmlspecialchars((string) $score) . ' bodov';
                    if ($label !== '') {
                        echo ' (' . htmlspecialchars($label) . ')';
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
