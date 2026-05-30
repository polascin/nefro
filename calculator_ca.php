<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "calcium" => (string) ($_POST["calcium"] ?? ""),
    "albumin" => (string) ($_POST["albumin"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_ca');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $ca = calculatorParsePositiveFloat($form["calcium"]);
        if ($ca === null) {
            $errors[] = "Zadajte platnú hodnotu celkového vápnika.";
        }

        $alb = calculatorParsePositiveFloat($form["albumin"]);
        if ($alb === null) {
            $errors[] = "Zadajte platnú hodnotu sérového albumínu.";
        }

        if (empty($errors)) {
            // Vzorec: Korigovaný Ca (mmol/l) = Nameraný Ca + 0.02 * (40 - Albumín v g/l)
            $correctedCa = $ca + 0.02 * (40.0 - $alb);

            $calculated = [
                "corrected_ca" => round($correctedCa, 2),
                "measured_ca" => round($ca, 2),
                "albumin" => round($alb, 1),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "calcium" => round($ca, 2),
                            "albumin" => round($alb, 1),
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "ca_corrected",
                                "Korigovaný vápnik",
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
                            "calculator_ca save error: " . $e->getMessage(),
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
            "ca_corrected",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_ca fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Korigovaný vápnik | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_ca.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: Korigovaný vápnik. Hodnotenie kalciémie pri hypoalbuminémii. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Korigovaný vápnik pri hypoalbuminémii",
                  "item" => $baseUrl . "calculator_ca.php",
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
    $headerTitle = "Kalkulačka korigovaného Ca";
    $headerIntro = "Hodnotenie kalciémie pri hypoalbuminémii";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Korigovaný vápnik pri hypoalbuminémii</h2>
                <p class="auth-subtitle">U pacientov s CKD (a inými stavmi) spojenými s nízkou hladinou albumínu môže byť celkový vápnik falošne nízky. Ionizovaný vápnik zostáva relatívne stabilný. Táto kalkulačka prepočíta celkový vápnik vzhľadom na hladinu albumínu.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec pre výpočet</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{Ca}_{\text{korig}} = \text{Ca}_{\text{nameraný}} + 0.02 \times (40 - \text{Albumín}) \]</div>
                        <div class="calc-formula-vars">
                            $\text{Vápnik [mmol/L]}$ &bull; $\text{Albumín [g/L]}$ (norma uvažovaná $40 \text{ g/L}$)
                        </div>
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

                <form method="POST" action="calculator_ca.php">
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
                                <label for="calcium">Celkový vápnik (S-Ca v mmol/L)</label>
                                <input type="text" id="calcium" name="calcium" required class="form-control" value="<?= htmlspecialchars(
                                    $form["calcium"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="albumin">S-Albumín (g/L)</label>
                                <input type="text" id="albumin" name="albumin" required class="form-control" value="<?= htmlspecialchars(
                                    $form["albumin"],
                                ) ?>">
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
                        <p><strong>Korigovaný vápnik:</strong> <?= htmlspecialchars(
                            number_format(
                                (float) $calculated["corrected_ca"],
                                2,
                                ",",
                                " ",
                            ),
                        ) ?> mmol/L</p>

                        <div class="form-actions no-print calc-result-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=corrected_calcium" class="btn-secondary">História Vápnik</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_ca.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo htmlspecialchars(number_format((float) ($result['corrected_ca'] ?? 0), 2, ',', ' ')) . ' mmol/L';                }
            ); ?>
        </div>
    </main>

    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
