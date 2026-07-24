<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny/neplatný/záporný vstup = null. */
function guptaParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** Body za vek (roky). */
function guptaAgePoints(float $age): float
{
    if ($age <= 45.0) {
        return 0.0;
    }
    if ($age <= 60.0) {
        return 2.5;
    }
    if ($age <= 70.0) {
        return 3.5;
    }
    return 4.5;
}

/** Body za hemoglobín (g/dL). */
function guptaHbPoints(float $hbGdl): float
{
    if ($hbGdl >= 12.0) {
        return 0.0;
    }
    if ($hbGdl >= 11.0) {
        return 1.0;
    }
    return 1.5;
}

/** Body za albumín (g/dL). */
function guptaAlbPoints(float $albGdl): float
{
    if ($albGdl > 3.8) {
        return 0.0;
    }
    if ($albGdl >= 3.3) {
        return 1.0;
    }
    return 1.5;
}

/** Body za dávku cisplatiny (absolútne mg). */
function guptaDosePoints(float $mg): float
{
    if ($mg <= 50.0) {
        return 0.0;
    }
    if ($mg <= 75.0) {
        return 2.0;
    }
    if ($mg <= 100.0) {
        return 2.5;
    }
    if ($mg <= 125.0) {
        return 3.0;
    }
    if ($mg <= 150.0) {
        return 5.0;
    }
    if ($mg <= 200.0) {
        return 7.5;
    }
    return 9.5;
}

/**
 * Riziková kategória podľa celkového skóre.
 * @return array{code: string, label: string, risk_class: string, incidence: string}
 */
function guptaRiskCategory(float $score): array
{
    if ($score <= 5.5) {
        return ['code' => 'low', 'label' => 'nízke riziko', 'risk_class' => 'risk-low',
            'incidence' => '≈ 0,9 – 1,3 % ťažkého CP-AKI'];
    }
    if ($score <= 9.5) {
        return ['code' => 'moderate', 'label' => 'stredné riziko', 'risk_class' => 'risk-moderate',
            'incidence' => 'stredná (medzi nízkym a vysokým)'];
    }
    if ($score <= 15.5) {
        return ['code' => 'high', 'label' => 'vysoké riziko', 'risk_class' => 'risk-high',
            'incidence' => 'zvýšená (medzi stredným a veľmi vysokým)'];
    }
    return ['code' => 'veryhigh', 'label' => 'veľmi vysoké riziko', 'risk_class' => 'risk-high',
        'incidence' => '≈ 16,7 – 23,5 % ťažkého CP-AKI'];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "hypertension" => isset($_POST["hypertension"]) ? "1" : "",
    "diabetes" => isset($_POST["diabetes"]) ? "1" : "",
    "hemoglobin_value" => (string) ($_POST["hemoglobin_value"] ?? ""),
    "hemoglobin_unit" => (($_POST["hemoglobin_unit"] ?? "") === "g_dl") ? "g_dl" : "g_l",
    "wbc" => (string) ($_POST["wbc"] ?? ""),
    "platelets" => (string) ($_POST["platelets"] ?? ""),
    "albumin_value" => (string) ($_POST["albumin_value"] ?? ""),
    "albumin_unit" => (($_POST["albumin_unit"] ?? "") === "g_dl") ? "g_dl" : "g_l",
    "magnesium_value" => (string) ($_POST["magnesium_value"] ?? ""),
    "magnesium_unit" => (($_POST["magnesium_unit"] ?? "") === "mg_dl") ? "mg_dl" : "mmol_l",
    "cisplatin_dose" => (string) ($_POST["cisplatin_dose"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_gupta');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $age = guptaParseNonNeg($form["age_years"]);
        if ($age === null || $age > 120.0) {
            $errors[] = "Vek musí byť 0 – 120 rokov.";
        }

        // Hemoglobín → g/dL
        $hbRaw = calculatorParsePositiveFloat($form["hemoglobin_value"]);
        $hbGdl = null;
        if ($hbRaw === null) {
            $errors[] = "Hemoglobín musí byť kladné číslo.";
        } else {
            $hbGdl = $form["hemoglobin_unit"] === "g_dl" ? (float) $hbRaw : (float) $hbRaw / 10.0;
            if ($hbGdl < 2.0 || $hbGdl > 25.0) {
                $errors[] = "Hemoglobín je mimo prijateľného rozsahu (2 – 25 g/dL).";
            }
        }

        $wbc = calculatorParsePositiveFloat($form["wbc"]);
        if ($wbc === null || $wbc > 500.0) {
            $errors[] = "Leukocyty musia byť kladné číslo (×10⁹/l).";
        }

        $platelets = calculatorParsePositiveFloat($form["platelets"]);
        if ($platelets === null || $platelets > 3000.0) {
            $errors[] = "Trombocyty musia byť kladné číslo (×10⁹/l).";
        }

        // Albumín → g/dL
        $albRaw = calculatorParsePositiveFloat($form["albumin_value"]);
        $albGdl = null;
        if ($albRaw === null) {
            $errors[] = "Albumín musí byť kladné číslo.";
        } else {
            $albGdl = $form["albumin_unit"] === "g_dl" ? (float) $albRaw : (float) $albRaw / 10.0;
            if ($albGdl < 1.0 || $albGdl > 7.0) {
                $errors[] = "Albumín je mimo prijateľného rozsahu (1 – 7 g/dL).";
            }
        }

        // Magnézium → mg/dL
        $mgRaw = calculatorParsePositiveFloat($form["magnesium_value"]);
        $mgMgdl = null;
        if ($mgRaw === null) {
            $errors[] = "Magnézium musí byť kladné číslo.";
        } else {
            $mgMgdl = $form["magnesium_unit"] === "mg_dl" ? (float) $mgRaw : (float) $mgRaw * 2.43;
            if ($mgMgdl < 0.2 || $mgMgdl > 10.0) {
                $errors[] = "Magnézium je mimo prijateľného rozsahu.";
            }
        }

        $dose = calculatorParsePositiveFloat($form["cisplatin_dose"]);
        if ($dose === null || $dose > 1000.0) {
            $errors[] = "Dávka cisplatiny musí byť kladné číslo (mg).";
        }

        if (empty($errors)) {
            $htn = $form["hypertension"] === "1";
            $dm = $form["diabetes"] === "1";

            $pAge = guptaAgePoints((float) $age);
            $pHtn = $htn ? 1.0 : 0.0;
            $pDm = $dm ? 1.0 : 0.0;
            $pHb = guptaHbPoints((float) $hbGdl);
            $pWbc = (float) $wbc > 12.0 ? 1.5 : 0.0;
            $pPlt = (float) $platelets < 150.0 ? 1.0 : 0.0;
            $pAlb = guptaAlbPoints((float) $albGdl);
            $pMg = (float) $mgMgdl < 2.0 ? 1.0 : 0.0;
            $pDose = guptaDosePoints((float) $dose);

            $score = $pAge + $pHtn + $pDm + $pHb + $pWbc + $pPlt + $pAlb + $pMg + $pDose;
            $cat = guptaRiskCategory($score);

            $calculated = [
                "score" => $score,
                "code" => $cat["code"],
                "label" => $cat["label"],
                "risk_class" => $cat["risk_class"],
                "incidence" => $cat["incidence"],
                "p_age" => $pAge,
                "p_htn" => $pHtn,
                "p_dm" => $pDm,
                "p_hb" => $pHb,
                "p_wbc" => $pWbc,
                "p_plt" => $pPlt,
                "p_alb" => $pAlb,
                "p_mg" => $pMg,
                "p_dose" => $pDose,
                "hb_gdl" => round((float) $hbGdl, 1),
                "alb_gdl" => round((float) $albGdl, 1),
                "mg_mgdl" => round((float) $mgMgdl, 2),
                "dose" => round((float) $dose, 0),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "age_years" => round((float) $age, 0),
                            "hypertension" => $htn,
                            "diabetes" => $dm,
                            "hemoglobin_gdl" => round((float) $hbGdl, 1),
                            "wbc" => round((float) $wbc, 1),
                            "platelets" => round((float) $platelets, 0),
                            "albumin_gdl" => round((float) $albGdl, 1),
                            "magnesium_mgdl" => round((float) $mgMgdl, 2),
                            "cisplatin_dose_mg" => round((float) $dose, 0),
                        ];
                        $resultPayload = [
                            "score" => $score,
                            "code" => $cat["code"],
                            "label" => $cat["label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "gupta_cisplatin",
                                "Gupta — riziko cisplatínového AKI (BMJ 2024)",
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
                        error_log("calculator_gupta save error: " . $e->getMessage());
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
            "gupta_cisplatin",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_gupta fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Gupta — riziko cisplatínom indukovaného AKI (CP-AKI) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_gupta.php";
  $seoDescription =
      "Gupta simple risk score (BMJ 2024): predikcia ťažkého cisplatínom indukovaného akútneho poškodenia obličiek (CP-AKI) z 9 faktorov — vek, hypertenzia, diabetes, hemoglobín, leukocyty, trombocyty, albumín, magnézium a dávka cisplatiny. Skóre 0–22,5 → nízke / stredné / vysoké / veľmi vysoké riziko.";
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
                  "name" => "Gupta — riziko cisplatínového AKI",
                  "item" => $baseUrl . "calculator_gupta.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="gupta_cisplatin">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Gupta — riziko cisplatínového AKI";
    $headerIntro = "Simple risk score pre ťažké CP-AKI (Gupta, BMJ 2024)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Gupta — riziko cisplatínového AKI (CP-AKI)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + 9 faktorov pred podaním cisplatiny pre odhad rizika ťažkého AKI.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> jednoduché bodové skóre predikuje riziko
                    <strong>ťažkého cisplatínom indukovaného AKI</strong> (CP-AKI) do 14 dní od
                    podania. Ťažké CP-AKI = vzostup kreatinínu na <strong>≥ 2× východisko</strong>
                    alebo potreba dialýzy (≈ KDIGO 2 – 3). Skóre 0 – 22,5 zaraďuje pacienta do
                    štyroch rizikových kategórií. Hodnoty zadávaj <strong>pred podaním</strong>
                    cisplatiny.
                </div>

                <div class="info-box-yellow">
                    <strong>Pozor:</strong> dávka cisplatiny sa zadáva ako <strong>absolútna (mg)</strong>,
                    nie mg/m². Model bol odvodený na populácii v USA — pri prenose interpretuj
                    v klinickom kontexte. Skóre <strong>nenahrádza</strong> klinický úsudok ani
                    rozhodnutie o redukcii dávky či alternatívnom režime.
                </div>

                <details open class="calc-formula-box">
                    <summary>Bodovanie (9 faktorov, súčet 0 – 22,5)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-vars">
                            <strong>Vek:</strong> ≤45 → 0 · 46–60 → 2,5 · 61–70 → 3,5 · &gt;70 → 4,5 &bull;
                            <strong>Hypertenzia:</strong> 1 &bull; <strong>Diabetes:</strong> 1 &bull;
                            <strong>Hemoglobín (g/dl):</strong> ≥12 → 0 · 11–11,9 → 1 · &lt;11 → 1,5 &bull;
                            <strong>Leukocyty (×10⁹/l):</strong> ≤12 → 0 · &gt;12 → 1,5 &bull;
                            <strong>Trombocyty (×10⁹/l):</strong> ≥150 → 0 · &lt;150 → 1 &bull;
                            <strong>Albumín (g/dl):</strong> &gt;3,8 → 0 · 3,3–3,8 → 1 · &lt;3,3 → 1,5 &bull;
                            <strong>Magnézium (mg/dl):</strong> ≥2,0 → 0 · &lt;2,0 → 1 &bull;
                            <strong>Dávka cisplatiny (mg):</strong> ≤50 → 0 · 51–75 → 2 · 76–100 → 2,5 · 101–125 → 3 · 126–150 → 5 · 151–200 → 7,5 · &gt;200 → 9,5
                        </div>
                        <div class="calc-formula-vars">
                            <strong>Kategórie:</strong> nízke 0–5,5 · stredné 6–9,5 · vysoké 10–15,5 · veľmi vysoké ≥16
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroj:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/38538052/" target="_blank" rel="noopener noreferrer">Gupta S. et&nbsp;al., BMJ 2024;385:e077169</a>
                    &ensp;&bull;&ensp; bodové hodnoty overené aj cez MDCalc (CP-AKI Risk Calculator)
                </div>

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

                <form method="POST" action="calculator_gupta.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Faktory pred podaním cisplatiny</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky) <span class="required">*</span></label>
                                <input type="text" id="age_years" name="age_years" required class="form-control" value="<?= htmlspecialchars($form["age_years"]) ?>" placeholder="napr. 62">
                            </div>
                            <div class="form-group">
                                <label for="cisplatin_dose">Dávka cisplatiny (mg, absolútna) <span class="required">*</span></label>
                                <input type="text" id="cisplatin_dose" name="cisplatin_dose" required class="form-control" value="<?= htmlspecialchars($form["cisplatin_dose"]) ?>" placeholder="napr. 120">
                            </div>
                            <div class="form-group">
                                <label for="hemoglobin_value">Hemoglobín <span class="required">*</span></label>
                                <input type="text" id="hemoglobin_value" name="hemoglobin_value" required class="form-control" value="<?= htmlspecialchars($form["hemoglobin_value"]) ?>" placeholder="napr. 125">
                            </div>
                            <div class="form-group">
                                <label for="hemoglobin_unit">Jednotka hemoglobínu <span class="required">*</span></label>
                                <select id="hemoglobin_unit" name="hemoglobin_unit" class="form-control" required>
                                    <option value="g_l" <?= $form["hemoglobin_unit"] === "g_l" ? "selected" : "" ?>>g/l</option>
                                    <option value="g_dl" <?= $form["hemoglobin_unit"] === "g_dl" ? "selected" : "" ?>>g/dl</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="wbc">Leukocyty (×10⁹/l) <span class="required">*</span></label>
                                <input type="text" id="wbc" name="wbc" required class="form-control" value="<?= htmlspecialchars($form["wbc"]) ?>" placeholder="napr. 7,5">
                            </div>
                            <div class="form-group">
                                <label for="platelets">Trombocyty (×10⁹/l) <span class="required">*</span></label>
                                <input type="text" id="platelets" name="platelets" required class="form-control" value="<?= htmlspecialchars($form["platelets"]) ?>" placeholder="napr. 220">
                            </div>
                            <div class="form-group">
                                <label for="albumin_value">Albumín <span class="required">*</span></label>
                                <input type="text" id="albumin_value" name="albumin_value" required class="form-control" value="<?= htmlspecialchars($form["albumin_value"]) ?>" placeholder="napr. 38">
                            </div>
                            <div class="form-group">
                                <label for="albumin_unit">Jednotka albumínu <span class="required">*</span></label>
                                <select id="albumin_unit" name="albumin_unit" class="form-control" required>
                                    <option value="g_l" <?= $form["albumin_unit"] === "g_l" ? "selected" : "" ?>>g/l</option>
                                    <option value="g_dl" <?= $form["albumin_unit"] === "g_dl" ? "selected" : "" ?>>g/dl</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="magnesium_value">Magnézium <span class="required">*</span></label>
                                <input type="text" id="magnesium_value" name="magnesium_value" required class="form-control" value="<?= htmlspecialchars($form["magnesium_value"]) ?>" placeholder="napr. 0,80">
                            </div>
                            <div class="form-group">
                                <label for="magnesium_unit">Jednotka magnézia <span class="required">*</span></label>
                                <select id="magnesium_unit" name="magnesium_unit" class="form-control" required>
                                    <option value="mmol_l" <?= $form["magnesium_unit"] === "mmol_l" ? "selected" : "" ?>>mmol/l</option>
                                    <option value="mg_dl" <?= $form["magnesium_unit"] === "mg_dl" ? "selected" : "" ?>>mg/dl</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Komorbidity</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="hypertension" value="1" <?= $form["hypertension"] === "1" ? "checked" : "" ?>> Hypertenzia <span class="form-check-pts">(+1)</span></label>
                                <label class="form-check"><input type="checkbox" name="diabetes" value="1" <?= $form["diabetes"] === "1" ? "checked" : "" ?>> Diabetes mellitus <span class="form-check-pts">(+1)</span></label>
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
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float) $calculated["score"], 1, ",", " ")) ?></span>
                                <span class="calc-result-unit">bodov (0 – 22,5)</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= htmlspecialchars((string) $calculated["score"]) ?>"
                             data-risk-max="22.5"
                             data-risk-label="Gupta skóre CP-AKI (0–22,5)"></div>
                        <p class="calc-result-detail"><strong>Predpokladaná incidencia:</strong> <?= htmlspecialchars((string) $calculated["incidence"]) ?>. Riziko rastie monotónne s kategóriou (OR veľmi vysoké vs. nízke ≈ 18 – 24×).</p>
                        <p class="calc-result-detail"><strong>Rozpis bodov:</strong>
                            vek <?= htmlspecialchars(number_format((float)$calculated["p_age"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; HTN <?= htmlspecialchars(number_format((float)$calculated["p_htn"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; DM <?= htmlspecialchars(number_format((float)$calculated["p_dm"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; Hb <?= htmlspecialchars(number_format((float)$calculated["p_hb"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; leuko <?= htmlspecialchars(number_format((float)$calculated["p_wbc"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; trombo <?= htmlspecialchars(number_format((float)$calculated["p_plt"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; albumín <?= htmlspecialchars(number_format((float)$calculated["p_alb"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; Mg <?= htmlspecialchars(number_format((float)$calculated["p_mg"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; dávka <?= htmlspecialchars(number_format((float)$calculated["p_dose"], 1, ",", " ")) ?>
                        </p>
                        <p class="calc-result-detail"><strong>Prepočítané hodnoty:</strong>
                            Hb <?= htmlspecialchars(number_format((float)$calculated["hb_gdl"], 1, ",", " ")) ?> g/dl,
                            albumín <?= htmlspecialchars(number_format((float)$calculated["alb_gdl"], 1, ",", " ")) ?> g/dl,
                            Mg <?= htmlspecialchars(number_format((float)$calculated["mg_mgdl"], 2, ",", " ")) ?> mg/dl,
                            dávka <?= (int)$calculated["dose"] ?> mg.
                        </p>
                        <p class="calc-result-detail"><strong>Preventívne opatrenia (pri každom riziku, intenzívnejšie pri vysokom):</strong> adekvátna i.v. hydratácia pred aj po podaní, korekcia hypomagneziémie (suplementácia Mg), revízia a vysadenie ďalších nefrotoxínov, sledovanie diurézy a kreatinínu; pri vysokom/veľmi vysokom riziku zváž redukciu dávky, rozdelené (split) dávkovanie alebo alternatívny režim a nefrologickú konzultáciu.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=gupta_cisplatin" class="btn-secondary">História Gupta</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_gupta.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $score = $result['score'] ?? null;
                    $label = (string) ($result['label'] ?? '');
                    echo 'skóre ' . htmlspecialchars($score !== null ? number_format((float) $score, 1, ',', ' ') : '?');
                    if ($label !== '') {
                        echo ' (' . htmlspecialchars($label) . ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
