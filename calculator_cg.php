<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "sex" => (string) ($_POST["sex"] ?? "female"),
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "s_cr_value" => (string) ($_POST["s_cr_value"] ?? ""),
    "s_cr_unit" => (string) ($_POST["s_cr_unit"] ?? "umol_l"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_cg');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

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
            "options" => ["min_range" => 18, "max_range" => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = "Vek musí byť celé číslo v intervale 18 až 120 rokov.";
        }

        $weightKg = calculatorParsePositiveFloat($form["weight_kg"]);
        if ($weightKg === null) {
            $errors[] = "Hmotnosť musí byť platné kladné číslo (v kg).";
        }

        $sCrValue = calculatorParsePositiveFloat($form["s_cr_value"]);
        if ($sCrValue === null) {
            $errors[] = "Kreatinín musí byť platné kladné číslo.";
        }

        $sCrUnit = in_array($form["s_cr_unit"], ["umol_l", "mg_dl"], true)
            ? $form["s_cr_unit"]
            : "";
        if ($sCrUnit === "") {
            $errors[] = "Vyberte jednotku kreatinínu.";
        }

        if (empty($errors)) {
            $sCrMgDl =
                $sCrUnit === "umol_l"
                    ? (float) $sCrValue / 88.4
                    : (float) $sCrValue;

            $crcl = ((140 - $ageYears) * $weightKg) / (72 * $sCrMgDl);
            if ($sex === "female") {
                $crcl *= 0.85;
            }

            $calculated = [
                "crcl" => round($crcl, 1),
                "sex" => $sex,
                "age_years" => (int) $ageYears,
                "weight_kg" => round((float) $weightKg, 1),
                "s_cr_input" => round((float) $sCrValue, 2),
                "s_cr_unit" => $sCrUnit,
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
                            "weight_kg" => round((float) $weightKg, 1),
                            "s_cr_value" => round((float) $sCrValue, 2),
                            "s_cr_unit" => $sCrUnit,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "cg_crcl",
                                "Cockcroft-Gault",
                                $patient,
                                $inputPayload,
                                $calculated,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený do databázy.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log(
                            "calculator_cg save error: " . $e->getMessage(),
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
            "cg_crcl",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_cg fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Cockcroft-Gault (Klírens kreatinínu) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_cg.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: Cockcroft-Gault (Klírens kreatinínu). Úprava dávkovania liekov. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Cockcroft-Gault (Odhad klírensu kreatinínu)",
                  "item" => $baseUrl . "calculator_cg.php",
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
    $headerTitle = "Kalkulačka Cockcroft-Gault";
    $headerIntro = "Úprava dávkovania liekov";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Cockcroft-Gault (Odhad klírensu kreatinínu)</h2>
                <p class="auth-subtitle">Štandard pre farmakokinetickú úpravu dávkovania väčšiny liekov pri renálnej insuficiencii (napr. DOAK, antibiotiká).</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec — Cockcroft-Gault</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">
                            \[ \text{CrCl} = \frac{(140 - \text{Vek}) \times \text{Hmotnosť}}{72 \times S_{cr}} \times [0.85 \text{ ak žena}] \]
                        </div>
                        <div class="calc-formula-vars">
                            $\text{Vek [roky]}$ &bull; $\text{Hmotnosť [kg]}$ &bull; $S_{cr} = \text{sérový kreatinín [mg/dL]}$
                        </div>
                        <p class="text-secondary-sm mt-8">
                            Upozornenie: Hoci sa na zaradenie do štádií CKD používa rovnica CKD-EPI (s výstupom ml/min/1,73 m²), mnohé SPC liekov historicky vyžadujú na úpravu dávky práve tento vzorec (výstup ml/min). Pri extrémnej obezite sa niekedy odporúča použiť ideálnu alebo korigovanú telesnú hmotnosť.
                        </p>
                    </div>
                </details>

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

                <form method="POST" action="calculator_cg.php">
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
                                <label for="weight_kg">Hmotnosť (kg)</label>
                                <input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars(
                                    $form["weight_kg"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="s_cr_value">S-kreatinín</label>
                                <input type="text" id="s_cr_value" name="s_cr_value" required class="form-control" value="<?= htmlspecialchars(
                                    $form["s_cr_value"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="s_cr_unit">Jednotka kreatinínu</label>
                                <select id="s_cr_unit" name="s_cr_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form[
                                        "s_cr_unit"
                                    ] === "umol_l"
                                        ? "selected"
                                        : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form[
                                        "s_cr_unit"
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

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>Odhadovaný klírens kreatinínu (CrCl):</strong> <?= htmlspecialchars(
                            number_format(
                                (float) $calculated["crcl"],
                                1,
                                ",",
                                " ",
                            ),
                        ) ?> ml/min</p>

                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=cockcroft_gault" class="btn-secondary">História CG</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_cg.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $crcl = (float) ($result['crcl'] ?? 0);
                    echo htmlspecialchars(number_format($crcl, 1, ',', ' ')) . ' ml/min';                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime(
        "patient_autofill.js",
    ) ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
