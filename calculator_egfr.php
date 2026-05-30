<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

function egfrCategory(float $egfr): string
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

function egfrCategoryDescription(string $category): string
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

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "sex" => (string) ($_POST["sex"] ?? "female"),
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "creatinine_value" => (string) ($_POST["creatinine_value"] ?? ""),
    "creatinine_unit" => (string) ($_POST["creatinine_unit"] ?? "umol_l"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_egfr');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        // Auto-doplniť vek z dát. narodenia / rodného čísla, ak pole ostalo prázdne
        if ($form["age_years"] === "") {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form["age_years"] = (string) $derived;
            }
        }

        $sex = in_array($form["sex"], ["female", "male"], true)
            ? $form["sex"]
            : "";
        if ($sex === "") {
            $errors[] = "Vyberte pohlavie.";
        }

        $ageYears = filter_var($form["age_years"], FILTER_VALIDATE_INT, [
            "options" => [
                "min_range" => 18,
                "max_range" => 120,
            ],
        ]);
        if ($ageYears === false) {
            $errors[] = "Vek musí byť celé číslo v intervale 18 až 120 rokov.";
        }

        $creatinineValue = calculatorParsePositiveFloat(
            $form["creatinine_value"],
        );
        if ($creatinineValue === null) {
            $errors[] = "Kreatinín musí byť kladné číslo.";
        }

        $creatinineUnit = in_array(
            $form["creatinine_unit"],
            ["umol_l", "mg_dl"],
            true,
        )
            ? $form["creatinine_unit"]
            : "";
        if ($creatinineUnit === "") {
            $errors[] = "Vyberte jednotku kreatinínu.";
        }

        if (empty($errors)) {
            $creatinineMgDl =
                $creatinineUnit === "umol_l"
                    ? (float) $creatinineValue / 88.4
                    : (float) $creatinineValue;

            $kappa = $sex === "female" ? 0.7 : 0.9;
            $alpha = $sex === "female" ? -0.241 : -0.302;

            $ratio = $creatinineMgDl / $kappa;
            $egfr =
                142 *
                pow(min($ratio, 1), $alpha) *
                pow(max($ratio, 1), -1.2) *
                pow(0.9938, (int) $ageYears);

            if ($sex === "female") {
                $egfr *= 1.012;
            }

            $egfrRounded = round($egfr, 1);
            $gCategory = egfrCategory($egfrRounded);
            $gDescription = egfrCategoryDescription($gCategory);

            $calculated = [
                "egfr" => $egfrRounded,
                "g_category" => $gCategory,
                "g_description" => $gDescription,
                "sex" => $sex,
                "age_years" => (int) $ageYears,
                "creatinine_input" => round((float) $creatinineValue, 2),
                "creatinine_unit" => $creatinineUnit,
                "creatinine_mg_dl" => round($creatinineMgDl, 3),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "sex" => $sex,
                            "age_years" => (int) $ageYears,
                            "creatinine_value" => round(
                                (float) $creatinineValue,
                                2,
                            ),
                            "creatinine_unit" => $creatinineUnit,
                        ];

                        $resultPayload = [
                            "egfr" => $egfrRounded,
                            "g_category" => $gCategory,
                            "g_description" => $gDescription,
                            "creatinine_mg_dl" => round($creatinineMgDl, 3),
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "egfr_ckd_epi_2021",
                                "eGFR (CKD-EPI 2021)",
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
                            "calculator_egfr save error: " . $e->getMessage(),
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
            "egfr_ckd_epi_2021",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_egfr fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "eGFR CKD-EPI 2021 | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_egfr.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: eGFR CKD-EPI 2021. CKD-EPI 2021 podľa KDIGO 2024. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "eGFR (CKD-EPI 2021)",
                  "item" => $baseUrl . "calculator_egfr.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="egfr_ckd_epi_2021">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Kalkulačka eGFR";
    $headerIntro = "CKD-EPI 2021 podľa KDIGO 2024";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>eGFR (CKD-EPI 2021)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + povinné vstupy pre výpočet.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec — CKD-EPI 2021</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \begin{aligned} \text{eGFR} = 142 &\times \min(S_{cr}/\kappa, 1)^\alpha \times \max(S_{cr}/\kappa, 1)^{-1.200} \\ &\times 0.9938^{\text{Vek}} \times [1.012 \text{ ak žena}] \end{aligned} \]</div>
                        <div class="calc-formula-line">\[ S_{cr} [\text{mg/dL}] = S_{cr} [\mu\text{mol/L}] \div 88.4 \]</div>
                        <div class="calc-formula-vars">
                            $\kappa = 0.7 \text{ (žena)} / 0.9 \text{ (muž)}$ &bull;
                            $\alpha = -0.241 \text{ (žena)} / -0.302 \text{ (muž)}$ &bull;
                            $S_{cr} = \text{sérový kreatinín [mg/dL]}$
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://www.kidney.org/professionals/kdoqi/gfr_calculator" target="_blank" rel="noopener noreferrer">NKF / KDOQI eGFR</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/3939/ckd-epi-equations-glomerular-filtration-rate-gfr" target="_blank" rel="noopener noreferrer">MDCalc CKD-EPI</a> &ensp;&bull;&ensp;
                    <a href="https://qxmd.com/calculate/calculator_251/egfr-using-ckd-epi-2021" target="_blank" rel="noopener noreferrer">QxMD eGFR</a>
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

                <form method="POST" action="calculator_egfr.php">
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
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form["sex"] ===
                                    "female"
                                        ? "selected"
                                        : "" ?>>Žena</option>
                                    <option value="male" <?= $form["sex"] ===
                                    "male"
                                        ? "selected"
                                        : "" ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars(
                                    $form["age_years"],
                                ) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_value">S-kreatinín</label>
                                <input type="text" id="creatinine_value" name="creatinine_value" required class="form-control" value="<?= htmlspecialchars(
                                    $form["creatinine_value"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_unit">Jednotka kreatinínu</label>
                                <select id="creatinine_unit" name="creatinine_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form[
                                        "creatinine_unit"
                                    ] === "umol_l"
                                        ? "selected"
                                        : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form[
                                        "creatinine_unit"
                                    ] === "mg_dl"
                                        ? "selected"
                                        : "" ?>>mg/dL</option>
                                </select>
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
                    $riskCls = egfrRiskClass($calculated["g_category"]);
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["egfr"], 1, ",", " ")) ?></span>
                                <span class="calc-result-unit">ml/min/1,73 m²</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars($calculated["g_category"]) ?>
                                <span><?= htmlspecialchars($calculated["g_description"]) ?></span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$calculated['egfr'] ?>"
                             data-risk-max="120"
                             data-risk-label="eGFR"></div>
                        <p class="calc-result-detail"><strong>Kreatinín (mg/dL):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["creatinine_mg_dl"], 3, ",", " ")) ?>
                        </p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=egfr_ckd_epi_2021" class="btn-secondary">História eGFR</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_egfr.php',
                function (array $row): void {
                    $result    = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $egfrValue = (float) ($result['egfr'] ?? 0);
                    $category  = (string) ($result['g_category'] ?? '');
                    echo htmlspecialchars(number_format($egfrValue, 1, ',', ' ')) . ' ml/min/1,73 m²';
                    if ($category !== '') {
                        echo ' (' . htmlspecialchars($category) . ')';
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
