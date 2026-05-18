<?php
require_once "auth.php";
require_once "db_config.php";
require_once "calculators_common.php";

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
];

if (isLoggedIn() && isset($_GET["load_id"])) {
    $loadId = (int) $_GET["load_id"];
    $loadedRow = calculatorFetchSavedResultById(
        $pdo,
        $loadId,
        (int) $_SESSION["user_id"],
    );
    if ($loadedRow) {
        $form["patient_first_name"] =
            (string) ($loadedRow["patient_first_name"] ?? "");
        $form["patient_last_name"] =
            (string) ($loadedRow["patient_last_name"] ?? "");
        $form["patient_birth_date"] =
            (string) ($loadedRow["patient_birth_date"] ?? "");
        $form["patient_birth_number"] =
            (string) ($loadedRow["patient_birth_number"] ?? "");
        $form["patient_insurance_code"] =
            (string) ($loadedRow["patient_insurance_code"] ?? "");
        if (is_array($loadedRow["input_payload"])) {
            foreach ($loadedRow["input_payload"] as $k => $v) {
                if (isset($form[$k]) || array_key_exists($k, $form)) {
                    $form[$k] = (string) $v;
                }
            }
        }
        $messages[] =
            "Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        if (!isLoggedIn()) {
            $errors[] = "Na mazanie výsledkov je potrebné prihlásenie.";
        } else {
            $resultId = (int) ($_POST["result_id"] ?? 0);
            if ($resultId <= 0) {
                $errors[] = "Neplatné ID záznamu.";
            } else {
                try {
                    if (
                        calculatorDeleteSavedResult(
                            $pdo,
                            $resultId,
                            (int) $_SESSION["user_id"],
                        )
                    ) {
                        $messages[] = "Uložený výsledok bol vymazaný.";
                    } else {
                        $errors[] =
                            "Záznam sa nepodarilo vymazať alebo neexistuje.";
                    }
                } catch (\PDOException $e) {
                    $errors[] = "Databázová chyba pri mazaní záznamu.";
                    error_log(
                        "calculator_ca delete error: " . $e->getMessage(),
                    );
                }
            }
        }
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

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <li><a href="search.php">Vyhľadávanie</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php">Admin panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars(
                        $_SESSION["username"] ?? "Profil",
                    ) ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlásenie</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Korigovaný vápnik pri hypoalbuminémii</h2>
                <p class="auth-subtitle">U pacientov s CKD (a inými stavmi) spojenými s nízkou hladinou albumínu môže byť celkový vápnik falošne nízky. Ionizovaný vápnik zostáva relatívne stabilný. Táto kalkulačka prepočíta celkový vápnik vzhľadom na hladinu albumínu.</p>

                <details class="calc-formula-box">
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
                    <div class="form-section">
                        <h3>Voliteľné identifikačné údaje pacienta</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_first_name">Meno</label>
                                <input type="text" id="patient_first_name" name="patient_first_name" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_first_name"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_last_name">Priezvisko</label>
                                <input type="text" id="patient_last_name" name="patient_last_name" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_last_name"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_date">Dátum narodenia</label>
                                <input type="date" id="patient_birth_date" name="patient_birth_date" class="form-control" value="<?= htmlspecialchars(
                                    $form["patient_birth_date"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_number">Rodné číslo</label>
                                <input type="text" id="patient_birth_number" name="patient_birth_number" class="form-control" placeholder="000000/0000" value="<?= htmlspecialchars(
                                    $form["patient_birth_number"],
                                ) ?>">
                            </div>

                            <?php include __DIR__ .
                                "/patient_insurance_select.php"; ?>


                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
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
                    <div class="form-section calculator-result-block">
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
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <section class="auth-container auth-container--wide calc-saved-results">
                <h3>Uložené výsledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie a históriu výpočtov je potrebné prihlásenie.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Zatiaľ nemáte uložené žiadne výsledky pre túto kalkulačku.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Dátum</th>
                                    <th>Pacient</th>
                                    <th>Výsledok</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <?php
                                    $result = is_array($row["result_payload"])
                                        ? $row["result_payload"]
                                        : [];
                                    $ca =
                                        (float) ($result["corrected_ca"] ?? 0);
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars(
                                            date(
                                                "d.m.Y H:i",
                                                strtotime(
                                                    $row["created_at"] ?? "",
                                                ),
                                            ),
                                        ) ?></td>
                                        <td><?= htmlspecialchars(
                                            calculatorBuildPatientDisplay($row),
                                        ) ?></td>
                                        <td>
                                            <?= htmlspecialchars(
                                                number_format($ca, 2, ",", " "),
                                            ) ?> mmol/L
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row[
                                                "id"
                                            ] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row[
                                                "id"
                                            ] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_ca.php" class="d-inline" data-confirm="Naozaj vymazať záznam?">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                                                    generateCsrfToken(),
                                                ) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row[
                                                    "id"
                                                ] ?>">
                                                <button type="submit" class="btn-admin-action btn-admin-action--warn">Vymazať</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>
