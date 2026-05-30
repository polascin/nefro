<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

const EGFR_SLOPE_MAX_ROWS = 20;
const EGFR_SLOPE_MIN_ROWS = 4;

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

// Počet viditeľných riadkov (JS alebo históriou ovplyvnený)
$maxRow = min(EGFR_SLOPE_MAX_ROWS, max(EGFR_SLOPE_MIN_ROWS, (int)($_POST["max_row"] ?? EGFR_SLOPE_MIN_ROWS)));

$form = ["max_row" => (string)$maxRow];
for ($i = 1; $i <= EGFR_SLOPE_MAX_ROWS; $i++) {
    $form["date_$i"] = (string)($_POST["date_$i"] ?? "");
    $form["egfr_$i"] = (string)($_POST["egfr_$i"] ?? "");
}
$form["patient_first_name"]    = (string)($_POST["patient_first_name"]    ?? "");
$form["patient_last_name"]     = (string)($_POST["patient_last_name"]     ?? "");
$form["patient_birth_date"]    = (string)($_POST["patient_birth_date"]    ?? "");
$form["patient_birth_number"]  = (string)($_POST["patient_birth_number"]  ?? "");
$form["patient_insurance_code"] = (string)($_POST["patient_insurance_code"] ?? "");
$form["examination_date"]      = (string)($_POST["examination_date"]      ?? date("Y-m-d"));

function calculateSlope(array $x, array $y): ?float
{
    $n = count($x);
    if ($n < 2) return null;
    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;
    $num = $den = 0.0;
    for ($i = 0; $i < $n; $i++) {
        $num += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $den += ($x[$i] - $meanX) ** 2;
    }
    return $den == 0.0 ? null : $num / $den;
}

/** Načíta eGFR merania z uložených výsledkov pre pacienta s daným RC. */
function fetchPatientEgfrHistory(PDO $pdo, int $userId, string $birthNumber): array
{
    $stmt = $pdo->prepare(
        "SELECT input_payload, result_payload, created_at
         FROM calculator_results
         WHERE user_id = :uid
           AND calculator_key = 'egfr_ckd_epi_2021'
           AND patient_birth_number = :bn
         ORDER BY created_at ASC
         LIMIT " . EGFR_SLOPE_MAX_ROWS
    );
    $stmt->execute(["uid" => $userId, "bn" => $birthNumber]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $points = [];
    foreach ($rows as $row) {
        $inp  = is_string($row["input_payload"])  ? (json_decode($row["input_payload"],  true) ?: []) : ($row["input_payload"]  ?? []);
        $res  = is_string($row["result_payload"]) ? (json_decode($row["result_payload"], true) ?: []) : ($row["result_payload"] ?? []);
        $egfr = (float)($res["egfr"] ?? 0);
        $date = trim((string)($inp["examination_date"] ?? substr((string)($row["created_at"] ?? ""), 0, 10)));
        if ($egfr > 0 && $date !== "") {
            $points[$date] = round($egfr, 1); // deduplikácia podľa dátumu, posledná hodnota vyhráva
        }
    }

    // Zoradiť chronologicky
    ksort($points);
    $result = [];
    foreach ($points as $date => $egfr) {
        $result[] = ["date" => $date, "egfr" => $egfr];
    }
    return $result;
}

// ── load_id: načítanie uloženého slope výsledku ───────────────────────────
if (isLoggedIn() && isset($_GET["load_id"])) {
    $loadId  = (int)$_GET["load_id"];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int)$_SESSION["user_id"]);
    if ($loadedRow) {
        $form["patient_first_name"]    = (string)($loadedRow["patient_first_name"]    ?? "");
        $form["patient_last_name"]     = (string)($loadedRow["patient_last_name"]     ?? "");
        $form["patient_birth_date"]    = (string)($loadedRow["patient_birth_date"]    ?? "");
        $form["patient_birth_number"]  = (string)($loadedRow["patient_birth_number"]  ?? "");
        $form["patient_insurance_code"] = (string)($loadedRow["patient_insurance_code"] ?? "");
        $pCount = 0;
        if (is_array($loadedRow["input_payload"])) {
            $pl = $loadedRow["input_payload"];
            if (!empty($pl["examination_date"])) {
                $form["examination_date"] = (string)$pl["examination_date"];
            }
            foreach ($pl as $pKey => $pData) {
                if (preg_match('/^p(\d+)$/', $pKey, $m) && is_array($pData)) {
                    $idx = (int)$m[1];
                    $form["date_$idx"] = (string)($pData["date"] ?? "");
                    $form["egfr_$idx"] = (string)($pData["egfr"] ?? "");
                    $pCount = max($pCount, $idx);
                }
            }
        }
        $form["max_row"] = (string)max(EGFR_SLOPE_MIN_ROWS, $pCount);
        $maxRow = (int)$form["max_row"];
        $messages[] = "Údaje z histórie boli načítané do formulára.";
    }
}

// ── POST spracovanie ──────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string)($_POST["action"] ?? "");
    $maxRow = min(EGFR_SLOPE_MAX_ROWS, max(EGFR_SLOPE_MIN_ROWS, (int)($_POST["max_row"] ?? EGFR_SLOPE_MIN_ROWS)));
    $form["max_row"] = (string)$maxRow;

    if (!validateCsrfToken((string)($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";

    } elseif ($action === "delete_saved") {
        if (!isLoggedIn()) {
            $errors[] = "Na mazanie výsledkov je potrebné prihlásenie.";
        } else {
            $resultId = (int)($_POST["result_id"] ?? 0);
            if ($resultId > 0) {
                calculatorDeleteSavedResult($pdo, $resultId, (int)$_SESSION["user_id"]);
                $messages[] = "Výsledok bol vymazaný.";
            }
        }

    } elseif ($action === "load_patient") {
        // Načítanie eGFR meraní z histórie pre identifikovaného pacienta
        if (!isLoggedIn()) {
            $errors[] = "Pre načítanie histórie pacienta je potrebné prihlásenie.";
        } else {
            $bn = preg_replace('/\s+/', '', $form["patient_birth_number"]);
            if ($bn === "") {
                $errors[] = "Pre načítanie histórie zadajte rodné číslo pacienta.";
            } else {
                try {
                    $history = fetchPatientEgfrHistory($pdo, (int)$_SESSION["user_id"], $bn);
                    if (empty($history)) {
                        $messages[] = "Pre tohto pacienta neboli nájdené žiadne uložené výsledky eGFR (CKD-EPI 2021).";
                    } else {
                        // Vymazať existujúce riadky a naplniť históriou
                        for ($i = 1; $i <= EGFR_SLOPE_MAX_ROWS; $i++) {
                            $form["date_$i"] = "";
                            $form["egfr_$i"] = "";
                        }
                        foreach ($history as $idx => $pt) {
                            $i = $idx + 1;
                            $form["date_$i"] = $pt["date"];
                            $form["egfr_$i"] = (string)$pt["egfr"];
                        }
                        $newMax = max(EGFR_SLOPE_MIN_ROWS, count($history));
                        $form["max_row"] = (string)$newMax;
                        $maxRow = $newMax;
                        $messages[] = "Načítaných " . count($history) . " meraní eGFR z histórie pacienta. Môžete pridať ďalšie hodnoty a vypočítať trend.";
                    }
                } catch (\Throwable $e) {
                    $errors[] = "Chyba pri načítaní histórie: " . htmlspecialchars($e->getMessage());
                    error_log("egfr_slope load_patient error: " . $e->getMessage());
                }
            }
        }

    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $points = [];
        for ($i = 1; $i <= $maxRow; $i++) {
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
            $errors[] = "Pre výpočet rýchlosti poklesu eGFR musíte zadať aspoň 2 platné hodnoty s dátumami.";
        }

        if (empty($errors)) {
            usort($points, fn($a, $b) => $a["date"] <=> $b["date"]);

            $firstDate = $points[0]["date"];
            $x = [];
            $y = [];
            foreach ($points as $p) {
                $diffDays = (float)$firstDate->diff($p["date"])->days;
                if ($p["date"] < $firstDate) $diffDays = -$diffDays;
                $x[] = $diffDays / 365.25;
                $y[] = $p["egfr"];
            }

            $slope = calculateSlope($x, $y);

            if ($slope !== null) {
                if ($slope < -5) {
                    $interpretation = "Rýchla progresia CKD (> 5 ml/min/rok). Zvážte zintenzívnenie liečby (SGLT2i, RASi) a dispenzarizáciu.";
                } elseif ($slope < -2) {
                    $interpretation = "Stredne rýchla progresia. Prirodzený vekový pokles je zvyčajne okolo 1 ml/min/rok.";
                } elseif ($slope > 0) {
                    $interpretation = "eGFR sa v čase zlepšuje alebo je stabilné.";
                } else {
                    $interpretation = "Pomalá progresia, blízka fyziologickému starnutiu.";
                }

                $calculated = [
                    "slope"          => round($slope, 2),
                    "interpretation" => $interpretation,
                    "n_points"       => count($points),
                    "duration_years" => round(max($x), 2),
                ];

                if ($action === "save") {
                    if (!isLoggedIn()) {
                        $errors[] = "Pre uloženie sa prihláste.";
                    } else {
                        $inPayload = ["examination_date" => $form["examination_date"]];
                        foreach ($points as $idx => $p) {
                            $inPayload["p" . ($idx + 1)] = ["date" => $p["d_str"], "egfr" => $p["egfr"]];
                        }
                        calculatorSaveResult(
                            $pdo, (int)$_SESSION["user_id"],
                            "egfr_slope", "eGFR Slope",
                            $patient, $inPayload, $calculated,
                        );
                        $messages[] = "Výsledok uložený.";
                    }
                }
            } else {
                $errors[] = "Nepodarilo sa vypočítať trend (napr. zadané rovnaké dátumy).";
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults($pdo, (int)$_SESSION["user_id"], "egfr_slope", 25);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle    = "Rýchlosť poklesu eGFR (Slope) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_egfr_slope.php";
  $seoDescription = "Nefrologická kalkulačka a nástroj: Rýchlosť poklesu eGFR (Slope). Hodnotenie progresie CKD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
  $structuredData = [[
      "@context" => "https://schema.org", "@type" => "BreadcrumbList",
      "itemListElement" => [
          ["@type" => "ListItem", "position" => 1, "name" => "Domov",       "item" => $baseUrl],
          ["@type" => "ListItem", "position" => 2, "name" => "Kalkulačky",  "item" => $baseUrl . "calculators.php"],
          ["@type" => "ListItem", "position" => 3, "name" => "eGFR Slope",  "item" => $baseUrl . "calculator_egfr_slope.php"],
      ],
  ]];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = "eGFR Slope";
    $headerIntro = "Hodnotenie progresie CKD";
    $showLogo    = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>
    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Rýchlosť poklesu eGFR (Slope)</h2>
                <p class="auth-subtitle">KDIGO 2024 zdôrazňuje potrebu identifikovať tzv. "fast progressors" (pokles eGFR &gt; 5 ml/min/rok).</p>

                <details open class="calc-formula-box">
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

                <?php foreach ($messages as $m): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($m) ?></div>
                <?php endforeach; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <form method="POST" id="egfr-slope-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <input type="hidden" name="max_row"    id="max_row" value="<?= (int)$form["max_row"] ?>">

                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                        <div id="egfr-rows">
                        <?php for ($i = 1; $i <= max(EGFR_SLOPE_MIN_ROWS, $maxRow); $i++):
                            $hasValue = $form["date_$i"] !== "" || $form["egfr_$i"] !== "";
                        ?>
                        <div class="form-grid calc-item-separator egfr-slope-row" id="row-<?= $i ?>">
                            <div class="form-group">
                                <label>Dátum merania <?= $i ?></label>
                                <input type="date" name="date_<?= $i ?>" class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form["date_$i"]) ?>">
                            </div>
                            <div class="form-group">
                                <label>eGFR <?= $i ?> (ml/min/1,73&thinsp;m²)</label>
                                <input type="text" name="egfr_<?= $i ?>" class="form-control" inputmode="decimal" placeholder="napr. 45.2" value="<?= htmlspecialchars($form["egfr_$i"]) ?>">
                            </div>
                            <?php if ($i > EGFR_SLOPE_MIN_ROWS): ?>
                            <div class="form-group" style="align-self:flex-end">
                                <button type="button" class="btn-secondary" onclick="removeEgfrRow(<?= $i ?>)" title="Odstrániť tento riadok" aria-label="Odstrániť riadok <?= $i ?>">−</button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                        </div>

                        <div class="form-actions" style="margin-top:.5rem">
                            <button type="button" id="btn-add-egfr-row" class="btn-secondary" onclick="addEgfrRow()">+ Pridať meranie</button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculator_egfr_slope.php" class="btn-secondary">Vymazať formulár</a>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block" role="status" aria-live="polite">
                        <h3>Výsledok lineárnej regresie</h3>
                        <p><strong>Rýchlosť zmeny (Slope):</strong> <?= htmlspecialchars((string)$calculated["slope"]) ?> ml/min/1,73&thinsp;m² za rok</p>
                        <p class="calc-accent-text">Interpretácia: <?= htmlspecialchars($calculated["interpretation"]) ?></p>
                        <p class="calc-note-text">Sledované obdobie: <?= $calculated["duration_years"] ?> rokov, počet bodov: <?= $calculated["n_points"] ?></p>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=egfr_slope" class="btn-secondary">História eGFR Slope</a>
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
                    <p>Zatiaľ nemáte uložené žiadne výsledky pre túto kalkulačku.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th scope="col">Vyšetrenie</th>
                                    <th scope="col">Pacient</th>
                                    <th scope="col">Výsledok</th>
                                    <th scope="col">Bodov</th>
                                    <th scope="col">Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <tr>
                                        <td>
                                            <?php $_examD = (string)($row["input_payload"]["examination_date"] ?? ""); ?>
                                            <?= $_examD ? htmlspecialchars(date("d.m.Y", strtotime($_examD))) : "—" ?>
                                            <small class="d-block" style="color:var(--text-secondary);font-size:.8em">ulo.: <?= htmlspecialchars(date("d.m.Y H:i", strtotime($row["created_at"] ?? ""))) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td><?= number_format((float)($row["result_payload"]["slope"] ?? 0), 2, ",", " ") ?> ml/min/rok</td>
                                        <td><?= (int)($row["result_payload"]["n_points"] ?? 0) ?></td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int)$row["id"] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int)$row["id"] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_egfr_slope.php" class="d-inline" data-confirm="Naozaj vymazať záznam?">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int)$row["id"] ?>">
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

    <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
    (function () {
        var maxRow    = <?= (int)$form["max_row"] ?>;
        var maxAllowed = <?= EGFR_SLOPE_MAX_ROWS ?>;
        var minRows   = <?= EGFR_SLOPE_MIN_ROWS ?>;

        function updateMaxRowInput() {
            var inp = document.getElementById('max_row');
            if (inp) inp.value = maxRow;
        }

        window.addEgfrRow = function () {
            if (maxRow >= maxAllowed) {
                alert('Maximálny počet meraní (' + maxAllowed + ') bol dosiahnutý.');
                return;
            }
            maxRow++;
            updateMaxRowInput();

            var container = document.getElementById('egfr-rows');
            var row = document.createElement('div');
            row.className = 'form-grid calc-item-separator egfr-slope-row';
            row.id = 'row-' + maxRow;
            var idx = maxRow;
            row.innerHTML =
                '<div class="form-group">' +
                    '<label>Dátum merania ' + idx + '</label>' +
                    '<input type="date" name="date_' + idx + '" class="form-control" max="<?= date('Y-m-d') ?>">' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>eGFR ' + idx + ' (ml/min/1,73 m²)</label>' +
                    '<input type="text" name="egfr_' + idx + '" class="form-control" inputmode="decimal" placeholder="napr. 45.2">' +
                '</div>' +
                '<div class="form-group" style="align-self:flex-end">' +
                    '<button type="button" class="btn-secondary" onclick="removeEgfrRow(' + idx + ')" title="Odstrániť" aria-label="Odstrániť riadok ' + idx + '">−</button>' +
                '</div>';
            container.appendChild(row);
            row.querySelector('input[type="date"]').focus();
        };

        window.removeEgfrRow = function (idx) {
            var row = document.getElementById('row-' + idx);
            if (row) {
                row.remove();
                // Nedecrementujeme maxRow — server preskočí prázdne riadky
            }
        };
    })();
    </script>

    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
