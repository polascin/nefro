<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';
require_once __DIR__ . '/ckd_risk_models.php';

/** Nezáporné desatinné číslo; prázdny vstup = null (vyžiada chybu). Vráti null pri neplatnom/zápornom. */
function ckmParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa číselného štádia CKM (0–4). */
function ckmStageClass(int $num): string
{
    if ($num >= 3) {
        return 'risk-high';
    }
    if ($num === 2) {
        return 'risk-moderate';
    }
    return 'risk-low';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "bmi" => (string) ($_POST["bmi"] ?? ""),
    "ancestry" => (($_POST["ancestry"] ?? "") === "asian") ? "asian" : "general",
    "ckd_risk" => in_array($_POST["ckd_risk"] ?? "", ["low", "moderate", "high", "veryhigh"], true)
        ? (string) $_POST["ckd_risk"] : "none",
    "waist" => isset($_POST["waist"]) ? "1" : "",
    "prediabetes" => isset($_POST["prediabetes"]) ? "1" : "",
    "hypertension" => isset($_POST["hypertension"]) ? "1" : "",
    "diabetes" => isset($_POST["diabetes"]) ? "1" : "",
    "hypertriglyceridemia" => isset($_POST["hypertriglyceridemia"]) ? "1" : "",
    "metabolic_syndrome" => isset($_POST["metabolic_syndrome"]) ? "1" : "",
    "subclinical_cvd" => isset($_POST["subclinical_cvd"]) ? "1" : "",
    "clinical_cvd" => isset($_POST["clinical_cvd"]) ? "1" : "",
    "kidney_failure" => isset($_POST["kidney_failure"]) ? "1" : "",
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_ckm');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $bmi = ckmParseNonNeg($form["bmi"]);
        if ($bmi === null || $bmi < 10.0 || $bmi > 80.0) {
            $errors[] = "BMI musí byť 10 – 80 kg/m².";
        }

        $isAsian = $form["ancestry"] === "asian";
        $waist = $form["waist"] === "1";
        $prediabetes = $form["prediabetes"] === "1";
        $hypertension = $form["hypertension"] === "1";
        $diabetes = $form["diabetes"] === "1";
        $hypertrig = $form["hypertriglyceridemia"] === "1";
        $metSyndrome = $form["metabolic_syndrome"] === "1";
        $ckdRisk = $form["ckd_risk"];
        $subclinicalCvd = $form["subclinical_cvd"] === "1";
        $clinicalCvd = $form["clinical_cvd"] === "1";
        $kidneyFailure = $form["kidney_failure"] === "1";

        if (empty($errors)) {
            $bmiThreshold = $isAsian ? 23.0 : 25.0;
            $adiposity = (float) $bmi >= $bmiThreshold || $waist;
            $dysAdiposity = $prediabetes;
            $metabolicRF = $hypertension || $diabetes || $hypertrig || $metSyndrome;
            $ckdModHigh = in_array($ckdRisk, ["moderate", "high", "veryhigh"], true);
            // Zlyhanie obličiek (eGFR < 15 / dialýza) = veľmi vysoké riziko CKD → ekvivalent štádia 3.
            $ckdVeryHigh = $ckdRisk === "veryhigh" || $kidneyFailure;

            $stage = ckmComputeStage(
                $adiposity,
                $dysAdiposity,
                $metabolicRF,
                $ckdModHigh,
                $ckdVeryHigh,
                $subclinicalCvd,
                $clinicalCvd,
                $kidneyFailure
            );

            $anyCkmFactor = $adiposity || $dysAdiposity || $metabolicRF || $ckdModHigh || $ckdVeryHigh;

            $calculated = [
                "code" => $stage["code"],
                "num" => $stage["num"],
                "bmi" => round((float) $bmi, 1),
                "bmi_threshold" => $bmiThreshold,
                "adiposity" => $adiposity,
                "dys_adiposity" => $dysAdiposity,
                "metabolic_rf" => $metabolicRF,
                "ckd_risk" => $ckdRisk,
                "ckd_mod_high" => $ckdModHigh,
                "ckd_very_high" => $ckdVeryHigh,
                "subclinical_cvd" => $subclinicalCvd,
                "clinical_cvd" => $clinicalCvd,
                "kidney_failure" => $kidneyFailure,
                "any_ckm_factor" => $anyCkmFactor,
                "risk_class" => ckmStageClass($stage["num"]),
                "stage_label" => ckmStageLabel($stage["code"]),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "bmi" => round((float) $bmi, 1),
                            "ancestry" => $isAsian ? "asian" : "general",
                            "ckd_risk" => $ckdRisk,
                            "waist" => $waist,
                            "prediabetes" => $prediabetes,
                            "hypertension" => $hypertension,
                            "diabetes" => $diabetes,
                            "hypertriglyceridemia" => $hypertrig,
                            "metabolic_syndrome" => $metSyndrome,
                            "subclinical_cvd" => $subclinicalCvd,
                            "clinical_cvd" => $clinicalCvd,
                            "kidney_failure" => $kidneyFailure,
                        ];
                        $resultPayload = [
                            "code" => $stage["code"],
                            "num" => $stage["num"],
                            "stage_label" => $calculated["stage_label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "ckm_stage",
                                "CKM syndróm — staging (AHA 2023)",
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
                        error_log("calculator_ckm save error: " . $e->getMessage());
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
            "ckm_stage",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_ckm fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Staging CKM syndrómu (kardio-renálno-metabolický) — AHA 2023 | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_ckm.php";
  $seoDescription =
      "Staging kardiovaskulárno-renálno-metabolického (CKM) syndrómu podľa AHA 2023 (Ndumele): štádium 0 (bez RF), 1 (nadmerná/dysfunkčná adipozita), 2 (metabolické RF a/alebo CKD), 3 (subklinické KV ochorenie / veľmi vysoké riziko CKD), 4 (klinické KV ochorenie; 4a bez / 4b so zlyhaním obličiek). Hierarchická klasifikácia pre prevenciu.";
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
                  "name" => "Staging CKM syndrómu (AHA 2023)",
                  "item" => $baseUrl . "calculator_ckm.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="ckm_stage">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Staging CKM syndrómu";
    $headerIntro = "Kardio-renálno-metabolický syndróm — štádium 0–4 (AHA 2023)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Staging CKM syndrómu (AHA 2023)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + rizikové faktory pre zaradenie do štádia 0–4.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> kardiovaskulárno-renálno-metabolický (CKM)
                    syndróm zachytáva previazanosť metabolických rizikových faktorov, chronickej
                    choroby obličiek (CKD) a kardiovaskulárneho systému. Staging (0 – 4) slúži
                    na <strong>prevenciu naprieč životom</strong> a zaraďuje pacienta do
                    <em>najvyššieho</em> štádia, ktorého kritériá spĺňa. Nástroj je dôležitý pre
                    nefrológiu, keďže CKD je integrálnou súčasťou stagingu.
                </div>

                <div class="info-box-yellow">
                    <strong>Pozor:</strong> ide o <strong>zjednodušenú operacionalizáciu</strong>
                    stagingu AHA — platia plné kritériá a klinický úsudok. Riziko CKD zadaj podľa
                    KDIGO mapy (G/A) — pozri <a href="calculator_kdigo_risk.php">KDIGO kalkulačku</a>.
                    Staging nie je diagnostický test; <strong>regresia</strong> medzi štádiami je
                    pri liečbe možná a žiaduca.
                </div>

                <details open class="calc-formula-box">
                    <summary>Štádiá CKM (najvyššie splnené určuje zaradenie)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-vars">
                            <strong>0</strong> — bez rizikových faktorov CKM &bull;
                            <strong>1</strong> — nadmerná/dysfunkčná adipozita (BMI ≥ 25; ≥ 23 ázijský pôvod / zvýšený obvod pása / prediabetes) &bull;
                            <strong>2</strong> — metabolické RF (hypertenzia, diabetes, hypertriglyceridémia, metabolický syndróm) a/alebo CKD stredného–vysokého rizika &bull;
                            <strong>3</strong> — subklinické KV ochorenie alebo veľmi vysoké riziko CKD &bull;
                            <strong>4</strong> — klinické KV ochorenie (4a bez / 4b so zlyhaním obličiek)
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroj:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/37807924/" target="_blank" rel="noopener noreferrer">Ndumele C.E. et&nbsp;al., AHA Presidential Advisory, Circulation 2023;148(20):1606–35</a>
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

                <form method="POST" action="calculator_ckm.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Adipozita a obličky</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="bmi">BMI (kg/m²) <span class="required">*</span></label>
                                <input type="text" id="bmi" name="bmi" required class="form-control" value="<?= htmlspecialchars($form["bmi"]) ?>" placeholder="napr. 27,5">
                            </div>
                            <div class="form-group">
                                <label for="ancestry">Populácia (prah BMI) <span class="required">*</span></label>
                                <select id="ancestry" name="ancestry" class="form-control">
                                    <option value="general" <?= $form["ancestry"] !== "asian" ? "selected" : "" ?>>Všeobecná (BMI ≥ 25)</option>
                                    <option value="asian" <?= $form["ancestry"] === "asian" ? "selected" : "" ?>>Ázijský pôvod (BMI ≥ 23)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ckd_risk">Riziko CKD (KDIGO) <span class="required">*</span></label>
                                <select id="ckd_risk" name="ckd_risk" class="form-control">
                                    <option value="none" <?= $form["ckd_risk"] === "none" ? "selected" : "" ?>>Žiadne / neznáme</option>
                                    <option value="low" <?= $form["ckd_risk"] === "low" ? "selected" : "" ?>>Nízke (KDIGO zelená)</option>
                                    <option value="moderate" <?= $form["ckd_risk"] === "moderate" ? "selected" : "" ?>>Stredné (žltá)</option>
                                    <option value="high" <?= $form["ckd_risk"] === "high" ? "selected" : "" ?>>Vysoké (oranžová)</option>
                                    <option value="veryhigh" <?= $form["ckd_risk"] === "veryhigh" ? "selected" : "" ?>>Veľmi vysoké (červená)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Adipozita a metabolické rizikové faktory</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="waist" value="1" <?= $form["waist"] === "1" ? "checked" : "" ?>> Zvýšený obvod pása (≥ 102 cm M / ≥ 88 cm Ž; nižšie pri ázijskom pôvode) <span class="form-check-pts">(adipozita)</span></label>
                                <label class="form-check"><input type="checkbox" name="prediabetes" value="1" <?= $form["prediabetes"] === "1" ? "checked" : "" ?>> Prediabetes / porucha glukózovej tolerancie <span class="form-check-pts">(dysfunkčná adipozita)</span></label>
                                <label class="form-check"><input type="checkbox" name="hypertension" value="1" <?= $form["hypertension"] === "1" ? "checked" : "" ?>> Hypertenzia <span class="form-check-pts">(metabolický RF)</span></label>
                                <label class="form-check"><input type="checkbox" name="diabetes" value="1" <?= $form["diabetes"] === "1" ? "checked" : "" ?>> Diabetes mellitus <span class="form-check-pts">(metabolický RF)</span></label>
                                <label class="form-check"><input type="checkbox" name="hypertriglyceridemia" value="1" <?= $form["hypertriglyceridemia"] === "1" ? "checked" : "" ?>> Hypertriglyceridémia (≥ 1,5 mmol/L) <span class="form-check-pts">(metabolický RF)</span></label>
                                <label class="form-check"><input type="checkbox" name="metabolic_syndrome" value="1" <?= $form["metabolic_syndrome"] === "1" ? "checked" : "" ?>> Metabolický syndróm <span class="form-check-pts">(metabolický RF)</span></label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Kardiovaskulárne ochorenie a zlyhanie obličiek</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="subclinical_cvd" value="1" <?= $form["subclinical_cvd"] === "1" ? "checked" : "" ?>> Subklinické KV ochorenie (napr. koronárny kalcium, alebo veľmi vysoké predikované KV riziko) <span class="form-check-pts">(štádium 3)</span></label>
                                <label class="form-check"><input type="checkbox" name="clinical_cvd" value="1" <?= $form["clinical_cvd"] === "1" ? "checked" : "" ?>> Klinické KV ochorenie (ICHS, srdcové zlyhanie, NCMP, PAO, fibrilácia predsiení) <span class="form-check-pts">(štádium 4)</span></label>
                                <label class="form-check"><input type="checkbox" name="kidney_failure" value="1" <?= $form["kidney_failure"] === "1" ? "checked" : "" ?>> Zlyhanie obličiek (eGFR &lt; 15 / dialýza) <span class="form-check-pts">(4b; veľmi vysoké riziko CKD)</span></label>
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
                                <span class="calc-result-big-value"><?= htmlspecialchars((string) $calculated["code"]) ?></span>
                                <span class="calc-result-unit">štádium CKM</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["stage_label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (int)$calculated["num"] ?>"
                             data-risk-max="4"
                             data-risk-label="Štádium CKM (0–4)"></div>
                        <p class="calc-result-detail"><strong>Zachytené komponenty:</strong>
                            adipozita (BMI <?= htmlspecialchars(number_format((float)$calculated["bmi"], 1, ",", " ")) ?> ≥ <?= htmlspecialchars(number_format((float)$calculated["bmi_threshold"], 0, ",", " ")) ?> / pás): <?= $calculated["adiposity"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; prediabetes: <?= $calculated["dys_adiposity"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; metabolické RF: <?= $calculated["metabolic_rf"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; CKD stredné–vysoké: <?= $calculated["ckd_mod_high"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; CKD veľmi vysoké / zlyhanie: <?= $calculated["ckd_very_high"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; subklinické CVD: <?= $calculated["subclinical_cvd"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; klinické CVD: <?= $calculated["clinical_cvd"] ? "✓" : "✗" ?>
                        </p>
                        <?php if ($calculated["num"] === 0): ?>
                            <p class="calc-result-detail"><strong>Štádium 0.</strong> Udržiavanie zdravia naprieč životom, podpora zdravej hmotnosti a životosprávy, pravidelný skríning rizikových faktorov.</p>
                        <?php elseif ($calculated["code"] === "1"): ?>
                            <p class="calc-result-detail"><strong>Štádium 1.</strong> Cielená intervencia životným štýlom na adipozitu; skríning metabolických RF a CKD. Včasné zachytenie umožňuje regresiu.</p>
                        <?php elseif ($calculated["code"] === "2"): ?>
                            <p class="calc-result-detail"><strong>Štádium 2.</strong> Liečba metabolických RF a CKD; zváž kardio- a renoprotektívne lieky (SGLT2i, GLP-1 RA, ACEi/ARB, MRA podľa indikácie). Odhadni 10-ročné KV riziko (<a href="calculator_prevent.php">PREVENT</a>).</p>
                        <?php elseif ($calculated["code"] === "3"): ?>
                            <p class="calc-result-detail"><strong>Štádium 3.</strong> Intenzifikácia prevencie; potvrdenie subklinického ochorenia (zobrazovanie/biomarkery), agresívne cielenie RF a multidisciplinárny prístup (kardiológia + nefrológia).</p>
                        <?php else: ?>
                            <p class="calc-result-detail"><strong>Štádium <?= htmlspecialchars((string) $calculated["code"]) ?>.</strong> Manažment klinického KV ochorenia podľa platných odporúčaní spolu s liečbou CKM rizikových faktorov.
                            <?php if ($calculated["code"] === "4b"): ?>
                                Zlyhanie obličiek (4b) si vyžaduje úzku koordináciu s nefrológiou (dialýza/transplantácia) a úpravu dávkovania liekov.
                            <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($calculated["clinical_cvd"] && !$calculated["any_ckm_factor"]): ?>
                            <p class="calc-result-detail"><strong>Poznámka:</strong> nezadali ste žiadny CKM rizikový faktor. Staging CKM predpokladá súčasnú prítomnosť metabolických RF, adipozity alebo CKD — klinické KV ochorenie bez nich je mimo rámca CKM. Over zadané údaje.</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">Staging je <strong>hierarchický</strong> a slúži prevencii, nie ako diagnostický test. Pri liečbe je regresia do nižšieho štádia možná.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=ckm_stage" class="btn-secondary">História CKM</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_ckm.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $code  = (string) ($result['code'] ?? '');
                    $label = (string) ($result['stage_label'] ?? '');
                    echo 'štádium ' . htmlspecialchars($code !== '' ? $code : '?');
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
