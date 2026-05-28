<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

function kdigoGCategory(float $egfr): string
{
    if ($egfr >= 90.0) {
        return "G1";
    }
    if ($egfr >= 60.0) {
        return "G2";
    }
    if ($egfr >= 45.0) {
        return "G3a";
    }
    if ($egfr >= 30.0) {
        return "G3b";
    }
    if ($egfr >= 15.0) {
        return "G4";
    }

    return "G5";
}

function kdigoACategory(float $uacr): string
{
    if ($uacr < 30.0) {
        return "A1";
    }
    if ($uacr <= 300.0) {
        return "A2";
    }

    return "A3";
}

function kdigoRisk(string $g, string $a): array
{
    $risk = "Veľmi vysoké riziko";
    $note = "Potrebná zvýšená vigilancia a špecializované vedenie.";

    if (($g === "G1" || $g === "G2") && $a === "A1") {
        $risk = "Nízke riziko";
        $note =
            "Ak CKD trvá <3 mesiace alebo bez markerov, CKD nemusí byť potvrdená.";
    } elseif (($g === "G1" || $g === "G2") && $a === "A2") {
        $risk = "Stredné riziko";
        $note = "Odporúčané pravidelné sledovanie a nefroprotektívna liečba.";
    } elseif (($g === "G1" || $g === "G2") && $a === "A3") {
        $risk = "Vysoké riziko";
        $note = "Odporúčané intenzívnejšie sledovanie a úprava terapie.";
    } elseif ($g === "G3a" && $a === "A1") {
        $risk = "Stredné riziko";
        $note = "Sledovanie funkcie obličiek a rizikových faktorov.";
    } elseif (($g === "G3a" && $a === "A2") || ($g === "G3b" && $a === "A1")) {
        $risk = "Vysoké riziko";
        $note = "Vysoké riziko progresie, zvážiť nefrologickú konzultáciu.";
    }

    return [
        "risk" => $risk,
        "note" => $note,
    ];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "egfr" => (string) ($_POST["egfr"] ?? ""),
    "uacr" => (string) ($_POST["uacr"] ?? ""),
    "uacr_unit" => (string) ($_POST["uacr_unit"] ?? "mg_g"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_kdigo_risk');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $egfr = calculatorParsePositiveFloat($form["egfr"]);
        if ($egfr === null || $egfr > 200) {
            $errors[] =
                "eGFR musí byť kladné číslo v realistickom rozsahu (0–200).";
        }

        // Jednotka UACR
        $uacrUnit = in_array($form["uacr_unit"], ["mg_g", "mg_mmol"], true)
            ? $form["uacr_unit"]
            : "";
        if ($uacrUnit === "") {
            $errors[] = "Vyberte jednotku UACR.";
        }
        $uacr = calculatorParsePositiveFloat($form["uacr"]);
        if ($uacr === null || $uacr > 15000) {
            $errors[] = "UACR musí byť kladné číslo v rozumnom rozsahu.";
        }

        if (empty($errors)) {
            $egfrValue = (float) $egfr;
            $uacrInput = (float) $uacr;
            // Prepočet UACR: [mg/g] = [mg/mmol] × 8.84
            $uacrMgG = $uacrUnit === "mg_mmol" ? $uacrInput * 8.84 : $uacrInput;
            $gCategory = kdigoGCategory($egfrValue);
            $aCategory = kdigoACategory($uacrMgG);
            $riskInfo = kdigoRisk($gCategory, $aCategory);

            $calculated = [
                "egfr" => round($egfrValue, 1),
                "uacr_input" => round($uacrInput, 2),
                "uacr_unit" => $uacrUnit,
                "uacr_mg_g" => round($uacrMgG, 1),
                "g_category" => $gCategory,
                "a_category" => $aCategory,
                "risk" => $riskInfo["risk"],
                "note" => $riskInfo["note"],
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "egfr" => $calculated["egfr"],
                            "uacr_value" => $calculated["uacr_input"],
                            "uacr_unit" => $calculated["uacr_unit"],
                            "uacr_mg_g" => $calculated["uacr_mg_g"],
                        ];

                        $resultPayload = [
                            "g_category" => $gCategory,
                            "a_category" => $aCategory,
                            "risk" => $riskInfo["risk"],
                            "note" => $riskInfo["note"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "kdigo_ga_risk",
                                "KDIGO G/A riziko CKD",
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
                            "calculator_kdigo_risk save error: " .
                                $e->getMessage(),
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
            "kdigo_ga_risk",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log(
            "calculator_kdigo_risk fetch history error: " . $e->getMessage(),
        );
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "KDIGO G/A riziko CKD | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_kdigo_risk.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: KDIGO G/A riziko CKD. Kategoriácia CKD podľa eGFR a albuminúrie (UACR). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "KDIGO G/A riziko CKD",
                  "item" => $baseUrl . "calculator_kdigo_risk.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Kalkulačka KDIGO G/A rizika";
    $headerIntro = "Kategoriácia CKD podľa eGFR a albuminúrie (UACR)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>KDIGO G/A riziko CKD</h2>
                <p class="auth-subtitle">Zadanie eGFR a UACR, automatické určenie G/A kategórie a orientačného rizika.</p>

                <details open class="calc-formula-box">
                    <summary>Klasifikácia — KDIGO 2024 (G a A kategórie)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \begin{aligned} &\text{G1: eGFR} \ge 90 \quad \text{G2: } 60\text{--}89 \quad \text{G3a: } 45\text{--}59 \\ &\text{G3b: } 30\text{--}44 \quad \text{G4: } 15\text{--}29 \quad \text{G5: eGFR} \lt 15 \\ &\text{(ml/min/1{,}73 m}^2\text{)} \\ &\text{A1: UACR} \lt 30 \quad \text{A2: } 30\text{--}300 \quad \text{A3: UACR} \gt 300 \quad \text{(mg/g)} \end{aligned} \]</div>
                        <div class="calc-formula-line">\[ \text{UACR [mg/g]} = \text{UACR [mg/mmol]} \times 8.84 \]</div>
                        <div class="calc-formula-vars">
                            Riziko CKD = kombinácia G &times; A kategórie podľa KDIGO heatmapy&ensp;&bull;&ensp;
                            eGFR v ml/min/1,73&thinsp;m²&ensp;&bull;&ensp;UACR v mg/g
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými zdrojmi:</strong>
                    <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO 2024 Guidelines</a> &ensp;&bull;&ensp;
                    <a href="https://www.kidney.org/kidney-topics/chronic-kidney-disease-ckd" target="_blank" rel="noopener noreferrer">NKF — CKD (G/A klasifikácia)</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/3939/ckd-epi-equations-glomerular-filtration-rate-gfr" target="_blank" rel="noopener noreferrer">MDCalc CKD-EPI + KDIGO staging</a>
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

                <form method="POST" action="calculator_kdigo_risk.php">
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
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                                                        <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars(
                                    $form["egfr"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr">UACR</label>
                                <div class="flex-gap-8">
                                    <input type="text" id="uacr" name="uacr" required
                                           class="form-control flex-1"
                                           value="<?= htmlspecialchars(
                                               $form["uacr"],
                                           ) ?>">
                                    <select name="uacr_unit" class="form-control flex-08">
                                        <option value="mg_g"    <?= $form[
                                            "uacr_unit"
                                        ] === "mg_g"
                                            ? "selected"
                                            : "" ?>>mg/g</option>
                                        <option value="mg_mmol" <?= $form[
                                            "uacr_unit"
                                        ] === "mg_mmol"
                                            ? "selected"
                                            : "" ?>>mg/mmol</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>G kategória:</strong> <?= htmlspecialchars(
                            $calculated["g_category"],
                        ) ?></p>
                        <p><strong>A kategória:</strong> <?= htmlspecialchars(
                            $calculated["a_category"],
                        ) ?></p>
                        <p><strong>Rizikový stupeň:</strong> <?= htmlspecialchars(
                            $calculated["risk"],
                        ) ?></p>
                        <p><strong>Poznámka:</strong> <?= htmlspecialchars(
                            $calculated["note"],
                        ) ?></p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=kdigo_risk" class="btn-secondary">História KDIGO</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_kdigo_risk.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $input  = is_array($row['input_payload'])  ? $row['input_payload']  : [];
                    echo htmlspecialchars((string) ($result['risk'] ?? ''));
                    if (!empty($result['g_category']) && !empty($result['a_category'])) {
                        echo ' (' . htmlspecialchars((string) $result['g_category']) . '/' . htmlspecialchars((string) $result['a_category']) . ')';
                    }
                    if (!empty($input['egfr']) && !empty($input['uacr_mg_g'])) {
                        echo ' - eGFR ' . htmlspecialchars((string) $input['egfr']);
                        echo ', UACR ' . htmlspecialchars(number_format((float) $input['uacr_value'], 2, ',', ' '));
                        echo $input['uacr_unit'] === 'mg_mmol' ? ' mg/mmol' : ' mg/g';
                    }                }
            ); ?>
        </div>
    </main>

    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
