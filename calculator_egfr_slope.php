<?php
require_once "auth.php";
require_once "db_config.php";
require_once "calculators_common.php";

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "date_1" => (string) ($_POST["date_1"] ?? ""),
    "egfr_1" => (string) ($_POST["egfr_1"] ?? ""),
    "date_2" => (string) ($_POST["date_2"] ?? ""),
    "egfr_2" => (string) ($_POST["egfr_2"] ?? ""),
    "date_3" => (string) ($_POST["date_3"] ?? ""),
    "egfr_3" => (string) ($_POST["egfr_3"] ?? ""),
    "date_4" => (string) ($_POST["date_4"] ?? ""),
    "egfr_4" => (string) ($_POST["egfr_4"] ?? ""),
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" =>
        (string) ($_POST["patient_insurance_code"] ?? ""),
];

function calculateSlope(array $x, array $y): ?float
{
    $n = count($x);
    if ($n < 2) {
        return null;
    }
    $sumX = array_sum($x);
    $sumY = array_sum($y);
    $meanX = $sumX / $n;
    $meanY = $sumY / $n;
    $num = 0;
    $den = 0;
    for ($i = 0; $i < $n; $i++) {
        $num += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $den += pow($x[$i] - $meanX, 2);
    }
    return $den == 0 ? null : $num / $den;
}

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
            foreach ($loadedRow["input_payload"] as $pKey => $pData) {
                if (preg_match('/^p(\d+)$/', $pKey, $m)) {
                    $idx = $m[1];
                    $form["date_$idx"] = $pData["date"] ?? "";
                    $form["egfr_$idx"] = $pData["egfr"] ?? "";
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
            if ($resultId > 0) {
                calculatorDeleteSavedResult(
                    $pdo,
                    $resultId,
                    (int) $_SESSION["user_id"],
                );
                $messages[] = "Výsledok bol vymazaný.";
            }
        }
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $points = [];
        for ($i = 1; $i <= 4; $i++) {
            $d = $form["date_$i"];
            $e = calculatorParsePositiveFloat($form["egfr_$i"]);
            if ($d !== "" && $e !== null) {
                $dt = \DateTime::createFromFormat("Y-m-d", $d);
                if ($dt && $dt->format("Y-m-d") === $d) {
                    $points[] = ["date" => $dt, "egfr" => $e, "d_str" => $d];
                }
            }
        }

        if (count($points) < 2) {
            $errors[] =
                "Pre výpočet rýchlosti poklesu eGFR (slope) musíte zadať aspoň 2 platné hodnoty s dátumami.";
        }

        if (empty($errors)) {
            usort($points, function ($a, $b) {
                return $a["date"] <=> $b["date"];
            });

            $firstDate = $points[0]["date"];
            $x = [];
            $y = [];
            foreach ($points as $p) {
                $diffDays = (float) $firstDate->diff($p["date"])->days;
                if ($p["date"] < $firstDate) {
                    $diffDays = -$diffDays;
                }
                $x[] = $diffDays / 365.25; // roky od prvého merania
                $y[] = $p["egfr"];
            }

            $slope = calculateSlope($x, $y);

            if ($slope !== null) {
                $interpretation = "";
                if ($slope < -5) {
                    $interpretation =
                        "Rýchla progresia CKD (> 5 ml/min/rok). Zvážte zintenzívnenie liečby (SGLT2i, RASi) a dispenzarizáciu.";
                } elseif ($slope < -2) {
                    $interpretation =
                        "Stredne rýchla progresia. Prirodzený vekový pokles je zvyčajne okolo 1 ml/min/rok.";
                } elseif ($slope > 0) {
                    $interpretation =
                        "eGFR sa v čase zlepšuje alebo je stabilné.";
                } else {
                    $interpretation =
                        "Pomalá progresia, blízka fyziologickému starnutiu.";
                }

                $calculated = [
                    "slope" => round($slope, 2),
                    "interpretation" => $interpretation,
                    "n_points" => count($points),
                    "duration_years" => round(max($x), 2),
                ];

                if ($action === "save") {
                    if (!isLoggedIn()) {
                        $errors[] = "Pre uloženie sa prihláste.";
                    } else {
                        $inPayload = [];
                        foreach ($points as $i => $p) {
                            $inPayload["p" . ($i + 1)] = [
                                "date" => $p["d_str"],
                                "egfr" => $p["egfr"],
                            ];
                        }
                        calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION["user_id"],
                            "egfr_slope",
                            "eGFR Slope",
                            $patient,
                            $inPayload,
                            $calculated,
                        );
                        $messages[] = "Výsledok uložený.";
                    }
                }
            } else {
                $errors[] =
                    "Nepodarilo sa vypočítať trend (napr. zadané rovnaké dátumy).";
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults(
        $pdo,
        (int) $_SESSION["user_id"],
        "egfr_slope",
        25,
    );
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Rýchlosť poklesu eGFR (Slope) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_egfr_slope.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: Rýchlosť poklesu eGFR (Slope). Hodnotenie progresie CKD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Rýchlosť poklesu eGFR (Slope)",
                  "item" => $baseUrl . "calculator_egfr_slope.php",
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
    $headerTitle = "eGFR Slope";
    $headerIntro = "Hodnotenie progresie CKD";
    $showLogo = false;
    include "header.php";
    ?>
    <nav class="main-nav" aria-label="Hlavná navigácia"><div class="container"><ul>
        <li><a href="index.php">Domov</a></li>
        <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
        <li><a href="search.php">Vyhľadávanie</a></li>
        <?php if (isLoggedIn()): ?>
            <?php if (
                isAdmin()
            ): ?><li><a href="admin.php">Admin panel</a></li><?php endif; ?>
            <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars(
                $_SESSION["username"] ?? "",
            ) ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php">Prihlásenie</a></li>
        <?php endif; ?>
    </ul></div></nav>
    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Rýchlosť poklesu eGFR (Slope)</h2>
                <p class="auth-subtitle">KDIGO 2024 zdôrazňuje potrebu identifikovať tzv. "fast progressors" (pokles eGFR > 5 ml/min/rok).</p>

                <details class="calc-formula-box">
                    <summary>Vzorec — rýchlosť poklesu eGFR (lineárna regresia)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{Slope} = \frac{\sum_i (x_i - \bar{x})(y_i - \bar{y})}{\sum_i (x_i - \bar{x})^2} \]</div>
                        <div class="calc-formula-vars">
                            $x_i$ = čas od prvého merania (roky) &bull;
                            $y_i$ = eGFR (ml/min/1,73 m²) &bull;
                            výstup v ml/min/1,73 m² za rok
                        </div>
                    </div>
                </details>

                <?php foreach (
                    $messages
                    as $m
                ): ?><div class="alert alert-success"><?= htmlspecialchars(
    $m,
) ?></div><?php endforeach; ?>
                <?php if (
                    !empty($errors)
                ): ?><div class="alert alert-error"><ul><?php foreach (
    $errors
    as $e
): ?><li><?= htmlspecialchars(
    $e,
) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

                <form method="POST">
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
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="form-grid calc-item-separator">
                            <div class="form-group"><label>Dátum merania <?= $i ?></label><input type="date" name="date_<?= $i ?>" class="form-control" value="<?= htmlspecialchars(
    $form["date_$i"],
) ?>"></div>
                            <div class="form-group"><label>eGFR <?= $i ?> (ml/min)</label><input type="text" name="egfr_<?= $i ?>" class="form-control" value="<?= htmlspecialchars(
    $form["egfr_$i"],
) ?>"></div>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok lineárnej regresie</h3>
                        <p><strong>Rýchlosť zmeny (Slope):</strong> <?= htmlspecialchars(
                            $calculated["slope"],
                        ) ?> ml/min/1,73m² za rok</p>
                        <p class="calc-accent-text">Interpretácia: <?= htmlspecialchars(
                            $calculated["interpretation"],
                        ) ?></p>
                        <p class="calc-note-text">Sledované obdobie: <?= $calculated[
                            "duration_years"
                        ] ?> rokov, počet bodov: <?= $calculated[
     "n_points"
 ] ?></p>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <section class="auth-container auth-container--wide calc-saved-results">
                <h3>Uložené výsledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie výsledkov sa prihláste.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Žiadne uložené výsledky.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead><tr><th>Dátum</th><th>Pacient</th><th>Výsledok</th><th>Akcie</th></tr></thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
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
                                            Slope: <?= number_format(
                                                $row["result_payload"][
                                                    "slope"
                                                ] ?? 0,
                                                2,
                                            ) ?> ml/min/rok
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row[
                                                "id"
                                            ] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row[
                                                "id"
                                            ] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_egfr_slope.php" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                                                    generateCsrfToken(),
                                                ) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row[
                                                    "id"
                                                ] ?>">
                                                <button type="submit" class="btn-admin-action btn-admin-action--warn">Zmazať</button>
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
