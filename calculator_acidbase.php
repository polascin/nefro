<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "s_na" => (string) ($_POST["s_na"] ?? ""),
    "s_cl" => (string) ($_POST["s_cl"] ?? ""),
    "s_hco3" => (string) ($_POST["s_hco3"] ?? ""),
    "albumin" => (string) ($_POST["albumin"] ?? "40"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_acidbase');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $na = calculatorParsePositiveFloat($form["s_na"]);
        $cl = calculatorParsePositiveFloat($form["s_cl"]);
        $hco3 = calculatorParsePositiveFloat($form["s_hco3"]);
        $alb = calculatorParsePositiveFloat($form["albumin"]);

        if ($na === null) {
            $errors[] = "Zadajte platnú hodnotu S-Na.";
        }
        if ($cl === null) {
            $errors[] = "Zadajte platnú hodnotu S-Cl.";
        }
        if ($hco3 === null) {
            $errors[] = "Zadajte platnú hodnotu HCO3.";
        }
        if ($alb === null) {
            $alb = 40.0;
        }

        if (empty($errors)) {
            $ag = $na - ($cl + $hco3);
            $correctedAg = $ag + 0.25 * (40.0 - $alb);
            $deltaGap = $correctedAg - 12.0;
            $deltaHco3 = 24.0 - $hco3;

            $deltaRatio = null;
            $interpretation = "";

            if (abs($deltaHco3) > 0.5) {
                $deltaRatio = $deltaGap / $deltaHco3;

                if ($deltaRatio < 0.4) {
                    $interpretation =
                        "Hyperchloremická (normálna AG) metabolická acidóza.";
                } elseif ($deltaRatio < 0.8) {
                    $interpretation =
                        "Zmiešaná high-AG a normálna-AG metabolická acidóza.";
                } elseif ($deltaRatio < 2.0) {
                    $interpretation = "Čistá high-AG metabolická acidóza.";
                } else {
                    $interpretation =
                        "High-AG metabolická acidóza + súbežná metabolická alkalóza alebo chronická respiračná acidóza.";
                }
            } else {
                $interpretation =
                    "Delta HCO3 je príliš blízko nule pre výpočet Delta pomeru.";
            }

            $calculated = [
                "ag" => round($ag, 1),
                "corrected_ag" => round($correctedAg, 1),
                "delta_ratio" =>
                    $deltaRatio !== null ? round($deltaRatio, 2) : null,
                "interpretation" => $interpretation,
                "na" => round($na, 1),
                "cl" => round($cl, 1),
                "hco3" => round($hco3, 1),
                "alb" => round($alb, 1),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "s_na" => round($na, 1),
                            "s_cl" => round($cl, 1),
                            "s_hco3" => round($hco3, 1),
                            "albumin" => round($alb, 1),
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "acidbase_ag",
                                "Acidobáza (Anion Gap)",
                                $patient,
                                $inputPayload,
                                $calculated,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log(
                            "calculator_acidbase save error: " .
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
            "acidbase_ag",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Aniónová medzera a Delta Ratio | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_acidbase.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: Aniónová medzera a Delta Ratio. Súčasť analýzy metabolickej acidózy. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Aniónová medzera a Delta-Delta pomer",
                  "item" => $baseUrl . "calculator_acidbase.php",
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
    $headerTitle = "Aniónová medzera (Anion Gap)";
    $headerIntro = "Súčasť analýzy metabolickej acidózy";
    $showLogo = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Aniónová medzera a Delta-Delta pomer</h2>
                <p class="auth-subtitle">Základný nástroj na diagnostiku zmiešaných porúch acidobázickej rovnováhy.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{AG} = \text{Na} - (\text{Cl} + \text{HCO}_3) \]</div>
                        <div class="calc-formula-line">\[ \text{AG}_{\text{korig}} = \text{AG} + 0.25 \times (40 - \text{Albumín}) \]</div>
                        <div class="calc-formula-line">\[ \Delta\text{-Ratio} = \frac{\text{AG}_{\text{korig}} - 12}{24 - \text{HCO}_3} \]</div>
                        <div class="calc-formula-vars">
                            Normálna aniónová medzera je cca 10-14 mmol/L.<br>
                            U pacientov s hypoalbuminémiou (časté pri nefrotickom syndróme, závažnom CKD) musí byť AG korigovaná, inak sa falošne podhodnotí.
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars(
                        $message,
                    ) ?></p></div>
                <?php endforeach; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error"><ul><?php foreach (
                        $errors
                        as $error
                    ): ?><li><?= htmlspecialchars(
    $error,
) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <form method="POST" action="calculator_acidbase.php">
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
                                                        <div class="form-group"><label for="s_na">S-Na (mmol/L)</label><input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_na"],
                            ) ?>"></div>
                            <div class="form-group"><label for="s_cl">S-Cl (mmol/L)</label><input type="text" id="s_cl" name="s_cl" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_cl"],
                            ) ?>"></div>
                            <div class="form-group"><label for="s_hco3">S-HCO3 (mmol/L)</label><input type="text" id="s_hco3" name="s_hco3" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_hco3"],
                            ) ?>"></div>
                            <div class="form-group"><label for="albumin">S-Albumín (g/L)</label><input type="text" id="albumin" name="albumin" class="form-control" value="<?= htmlspecialchars(
                                $form["albumin"],
                            ) ?>"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>Nekorigovaná Aniónová medzera:</strong> <?= htmlspecialchars(
                            $calculated["ag"],
                        ) ?> mmol/L</p>
                        <p><strong>Korigovaná Aniónová medzera (pri Alb. <?= $calculated[
                            "alb"
                        ] ?> g/L):</strong> <?= htmlspecialchars(
     $calculated["corrected_ag"],
 ) ?> mmol/L</p>
                        <?php if ($calculated["delta_ratio"] !== null): ?>
                            <p class="calc-result-mt16"><strong>Delta Ratio (&Delta;/&Delta; pomer):</strong> <?= htmlspecialchars(
                                $calculated["delta_ratio"],
                            ) ?></p>
                            <p class="calc-accent-text">Interpretácia: <?= htmlspecialchars(
                                $calculated["interpretation"],
                            ) ?></p>
                        <?php endif; ?>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=anion_gap" class="btn-secondary">História Anión. medzera</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_acidbase.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo 'AG: ' . number_format((float) ($result['ag'] ?? 0), 1) . ' mmol/L';
                    if (isset($result['delta_ratio'])) {
                        echo '<br>&Delta; Ratio: ' . number_format((float) $result['delta_ratio'], 2);
                    }                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
