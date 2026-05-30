<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

/**
 * Mayo ADPKD klasifikácia — Irazabal et al. JASN 2015;26(8):1987–1994
 * HtTKV = TKV / výška (mL/m)
 * k = ln(HtTKV / 150) / vek  — odhadovaná ročná rýchlosť rastu obličiek
 * Triedy 1A–1E podľa k (prahové hodnoty: 1.5%, 3.0%, 4.5%, 6.0%/rok)
 * Trieda 2 = atypická ADPKD (unilaterálna, asymetrická)
 */
function adpkdClassify(float $tkv_ml, float $height_cm, float $age): array
{
    $height_m = $height_cm / 100.0;
    $httkv = $tkv_ml / $height_m; // mL/m
    $k = log($httkv / 150.0) / $age; // ročná miera rastu (log)
    $annual_pct = (exp($k) - 1.0) * 100.0; // % za rok

    if ($k < 0.015) {
        $class = "1A";
        $speed = "Pomalá (<1,5 %/rok)";
    } elseif ($k < 0.03) {
        $class = "1B";
        $speed = "Mierna (1,5–3 %/rok)";
    } elseif ($k < 0.045) {
        $class = "1C";
        $speed = "Rýchla (3–4,5 %/rok)";
    } elseif ($k < 0.06) {
        $class = "1D";
        $speed = "Veľmi rýchla (4,5–6 %/rok)";
    } else {
        $class = "1E";
        $speed = "Extrémne rýchla (>6 %/rok)";
    }

    return [
        "httkv" => round($httkv, 1),
        "k_pct" => round($annual_pct, 2),
        "class" => $class,
        "speed" => $speed,
    ];
}

function adpkdInterpretation(string $class): array
{
    $interp = [];
    $warn = [];
    switch ($class) {
        case "1A":
            $interp[] =
                "Trieda 1A — pomalá progresia. Pravidelné sledovanie, konzervatívna liečba.";
            break;
        case "1B":
            $interp[] =
                "Trieda 1B — mierna progresia. Optimalizácia krvného tlaku, hydratácia.";
            break;
        case "1C":
            $interp[] =
                "Trieda 1C — rýchla progresia. Zvážiť tolvaptan (KDIGO 2024 odporúčanie).";
            $warn[] =
                "Trieda 1C je typický kandidát na špecifickú liečbu tolvaptanom.";
            break;
        case "1D":
            $interp[] =
                "Trieda 1D — veľmi rýchla progresia. Tolvaptan indikovaný pri absencii kontraindikácií.";
            $warn[] = "Odporúčané nefrologické sledovanie každých 6 mesiacov.";
            break;
        case "1E":
            $interp[] =
                "Trieda 1E — extrémne rýchla progresia. Tolvaptan a včasné plánovanie RRT.";
            $warn[] =
                "URGENTNÉ: Zvážiť zaradenie do transplantačného programu. Tolvaptan pri absencii hepatotoxicity.";
            break;
    }
    return ["interpretation" => $interp, "warnings" => $warn];
}

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$pageUrl = $baseUrl . "calculator_adpkd.php";
$pageTitle =
    "Mayo ADPKD klasifikácia — rýchlosť progresie ADPKD | " . $siteName;
$pageDesc =
    "Mayo Clinic ADPKD klasifikácia (Irazabal 2015) — zaradenie do tried 1A–1E podľa výškou adjustovaného celkového objemu obličiek (HtTKV) a veku. Pre výber tolvaptanu a sledovanie ADPKD.";
$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "tkv_ml" => (string) ($_POST["tkv_ml"] ?? ""),
    "height_cm" => (string) ($_POST["height_cm"] ?? ""),
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "typical_adpkd" => (string) ($_POST["typical_adpkd"] ?? "1"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_adpkd');
    } else {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $tkvMl = calculatorParsePositiveFloat($form["tkv_ml"]);
        $heightCm = calculatorParsePositiveFloat($form["height_cm"]);
        $ageYears = calculatorParsePositiveFloat($form["age_years"]);
        $isTypical = $form["typical_adpkd"] === "1";

        if ($tkvMl === null || $tkvMl > 10000) {
            $errors[] = "Celkový objem obličiek (TKV) musí byť 1–10 000 mL.";
        }
        if ($heightCm === null || $heightCm < 100 || $heightCm > 220) {
            $errors[] = "Výška musí byť 100–220 cm.";
        }
        if ($ageYears === null || $ageYears < 15 || $ageYears > 80) {
            $errors[] = "Vek musí byť 15–80 rokov.";
        }

        if (empty($errors)) {
            if (!$isTypical) {
                $calculated = [
                    "class" => "2",
                    "speed" => "Atypická ADPKD",
                    "httkv" => round($tkvMl / ($heightCm / 100), 1),
                    "k_pct" => null,
                    "interpretation" => [
                        "Trieda 2 — atypická ADPKD (unilaterálna alebo asymetrická). Mayo klasifikácia nie je aplikovateľná.",
                    ],
                    "warnings" => [
                        "Odporúčané individuálne genetické vyšetrenie a nefrologické sledovanie.",
                    ],
                ];
            } else {
                $res = adpkdClassify($tkvMl, $heightCm, $ageYears);
                $int = adpkdInterpretation($res["class"]);
                $calculated = array_merge($res, [
                    "interpretation" => $int["interpretation"],
                    "warnings" => $int["warnings"],
                    "tkv" => $tkvMl,
                    "height" => $heightCm,
                    "age" => $ageYears,
                ]);

                if (isLoggedIn()) {
                    try {
                        $saved = calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION["user_id"],
                            "adpkd",
                            "Mayo ADPKD klasifikácia",
                            $patient,
                            [
                                "examination_date" => $form["examination_date"],
                                "tkv_ml" => $tkvMl,
                                "height_cm" => $heightCm,
                                "age_years" => $ageYears,
                            ],
                            [
                                "class" => $res["class"],
                                "httkv" => $res["httkv"],
                                "k_pct" => $res["k_pct"],
                            ],
                        );
                        if ($saved) {
                            $messages[] = "Výsledok bol uložený.";
                        }
                    } catch (\Throwable $e) {
                        $errors[] =
                            "Uloženie zlyhalo: " .
                            htmlspecialchars($e->getMessage());
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
            "adpkd",
        );
    } catch (\Throwable $e) {
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Mayo ADPKD klasifikácia — rýchlosť progresie ADPKD | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_adpkd.php";
  $seoDescription =
      "Mayo Clinic ADPKD klasifikácia (Irazabal 2015) — zaradenie do tried 1A–1E podľa výškou adjustovaného celkového objemu obličiek (HtTKV) a veku.";
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
                  "name" => "Mayo ADPKD klasifikácia",
                  "item" => $baseUrl . "calculator_adpkd.php",
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
    $headerTitle = "Mayo ADPKD klasifikácia";
    $headerIntro = "Rýchlosť progresie polycystickej choroby obličiek";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Mayo ADPKD klasifikácia</h2>
                <p class="auth-subtitle">Zaradenie pacienta s autozomálne dominantnou polycystickou chorobou obličiek (ADPKD) do tried 1A–1E podľa Mayo klasifikácie (Irazabal 2015) na základe HtTKV a veku.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec — Mayo ADPKD klasifikácia (Irazabal 2015)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{HtTKV} = \frac{\text{TKV [mL]}}{\text{výška [m]}} \]</div>
                        <div class="calc-formula-line">\[ k = \frac{\ln(\text{HtTKV} / 150)}{\text{vek}} \]</div>
                        <div class="calc-formula-line">\[ \begin{aligned} \text{Triedy: } &1A: k \lt 0.015 \quad 1B: 0.015\text{--}0.030 \quad 1C: 0.030\text{--}0.045 \\ &1D: 0.045\text{--}0.060 \quad 1E: k \ge 0.060 \end{aligned} \]</div>
                        <div class="calc-formula-vars">
                            HtTKV = výškou adjustovaný celkový objem obličiek (mL/m) &ensp;&bull;&ensp;
                            k = odhadovaná ročná miera rastu (exponent) &ensp;&bull;&ensp;
                            Platí len pre typickú ADPKD (bilaterálna, difúzna) &ensp;&bull;&ensp;
                            Zdroj: Irazabal MV et al. <em>JASN.</em> 2015;26(8):1987–1994.
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://www.mdcalc.com/search?q=Mayo+ADPKD" target="_blank" rel="noopener noreferrer">MDCalc Mayo ADPKD</a> &ensp;&bull;&ensp;
                    <a href="https://qxmd.com/calculate" target="_blank" rel="noopener noreferrer">QxMD (vyhľadajte "ADPKD")</a>
                </div>

                <?php foreach ($messages as $msg): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars(
                        $msg,
                    ) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error"><ul>
                        <?php foreach (
                            $errors
                            as $e
                        ): ?><li><?= htmlspecialchars(
    $e,
) ?></li><?php endforeach; ?>
                    </ul></div>
                <?php endif; ?>

                <?php if ($calculated !== null):
                    $classSlug = match ($calculated["class"]) {
                        "1A"      => "adpkd-result-1a",
                        "1B"      => "adpkd-result-1b",
                        "1C"      => "adpkd-result-1c",
                        "1D"      => "adpkd-result-1d",
                        "1E", "2" => "adpkd-result-1e",
                        default   => "adpkd-result-default",
                    }; ?>
                <div class="calc-result-box <?= $classSlug ?>" role="status" aria-label="Výsledok klasifikácie" aria-live="polite">
                    <h3>Výsledok — Mayo ADPKD klasifikácia</h3>
                    <div class="calc-result-grid">
                        <div class="calc-result-item calc-result-item--highlight">
                            <span class="calc-result-label">Mayo trieda</span>
                            <span class="calc-result-value calc-result-value--class"><?= htmlspecialchars(
    $calculated["class"],
) ?></span>
                        </div>
                        <div class="calc-result-item">
                            <span class="calc-result-label">HtTKV</span>
                            <span class="calc-result-value"><?= number_format(
                                $calculated["httkv"],
                                1,
                                ",",
                                "&thinsp;",
                            ) ?>&thinsp;mL/m</span>
                        </div>
                        <?php if ($calculated["k_pct"] !== null): ?>
                        <div class="calc-result-item">
                            <span class="calc-result-label">Odh. ročný rast</span>
                            <span class="calc-result-value"><?= number_format(
                                $calculated["k_pct"],
                                1,
                                ",",
                                "&thinsp;",
                            ) ?>&thinsp;%/rok</span>
                        </div>
                        <?php endif; ?>
                        <div class="calc-result-item">
                            <span class="calc-result-label">Rýchlosť progresie</span>
                            <span class="calc-result-value"><?= htmlspecialchars(
                                $calculated["speed"],
                            ) ?></span>
                        </div>
                    </div>
                    <?php foreach ($calculated["interpretation"] as $line): ?>
                        <p class="calc-result-note"><?= htmlspecialchars(
                            $line,
                        ) ?></p>
                    <?php endforeach; ?>
                    <?php foreach ($calculated["warnings"] as $w): ?>
                        <p class="calc-result-warning">⚠ <?= htmlspecialchars(
                            $w,
                        ) ?></p>
                    <?php endforeach; ?>
                    <div class="form-actions no-print">
                        <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                        <a href="calculator_history.php?calc=adpkd_mayo" class="btn-secondary">História ADPKD</a>
                    </div>
                </div>
                <?php
                endif; ?>

                <form method="POST" action="calculator_adpkd.php" novalidate>
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
                                <label for="adpkd_tkv">Celkový objem obličiek — TKV (mL) <span class="required">*</span></label>
                                <input type="number" id="adpkd_tkv" name="tkv_ml" min="100" max="10000" step="1" required class="form-control" placeholder="napr. 800" value="<?= htmlspecialchars(
                                    $form["tkv_ml"],
                                ) ?>">
                                <small class="form-hint">Z MRI alebo CT volumetrie (súčet oboch obličiek)</small>
                            </div>
                            <div class="form-group">
                                <label for="adpkd_height">Výška (cm) <span class="required">*</span></label>
                                <input type="number" id="adpkd_height" name="height_cm" min="100" max="220" step="0.5" required class="form-control" placeholder="napr. 170" value="<?= htmlspecialchars(
                                    $form["height_cm"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="adpkd_age">Vek (roky) <span class="required">*</span></label>
                                <input type="number" id="adpkd_age" name="age_years" min="15" max="80" step="1" required class="form-control" placeholder="napr. 38" value="<?= htmlspecialchars(
                                    $form["age_years"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="adpkd_typical">Typ ADPKD <span class="required">*</span></label>
                                <select id="adpkd_typical" name="typical_adpkd" class="form-control">
                                    <option value="1" <?= $form[
                                        "typical_adpkd"
                                    ] === "1"
                                        ? "selected"
                                        : "" ?>>Typická (bilaterálna, difúzna) — trieda 1</option>
                                    <option value="0" <?= $form[
                                        "typical_adpkd"
                                    ] === "0"
                                        ? "selected"
                                        : "" ?>>Atypická (unilaterálna/asymetrická) — trieda 2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" id="adpkd_submit">Klasifikovať</button>
                        <a href="calculator_adpkd.php" class="btn-secondary">Vymazať formulár</a>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <div class="calc-formula-box calc-formula-mt24">
                    <details>
                        <summary>Referenčné HtTKV prahy podľa veku (triedy 1A–1E)</summary>
                        <div class="calc-formula-content">
                            <table class="adpkd-ref-table">
                                <thead><tr class="adpkd-ref-tr-head">
                                    <th scope="col" class="adpkd-ref-th-left">Vek</th>
                                    <th scope="col" class="adpkd-ref-th">1A (&lt;mL/m)</th>
                                    <th scope="col" class="adpkd-ref-th">1B (&lt;mL/m)</th>
                                    <th scope="col" class="adpkd-ref-th">1C (&lt;mL/m)</th>
                                    <th scope="col" class="adpkd-ref-th">1D (&lt;mL/m)</th>
                                    <th scope="col" class="adpkd-ref-th">1E (≥mL/m)</th>
                                </tr></thead>
                                <tbody>
                                <?php
                                $agesList = [
                                    20,
                                    25,
                                    30,
                                    35,
                                    40,
                                    45,
                                    50,
                                    55,
                                    60,
                                ];
                                foreach ($agesList as $a) {
                                    $t = [
                                        150 * exp(0.015 * $a),
                                        150 * exp(0.03 * $a),
                                        150 * exp(0.045 * $a),
                                        150 * exp(0.06 * $a),
                                    ];
                                    echo "<tr class='adpkd-ref-tr'>";
                                    echo "<td class='adpkd-ref-td-label'>{$a} r</td>";
                                    foreach ($t as $v) {
                                        echo "<td class='adpkd-ref-td'>" .
                                            round($v) .
                                            "</td>";
                                    }
                                    echo "<td class='adpkd-ref-td'>≥" .
                                        round($t[3]) .
                                        "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </details>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_adpkd.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo 'Trieda ' . htmlspecialchars((string) ($result['class'] ?? '—'));
                    echo ' &bull; HtTKV ' . htmlspecialchars((string) ($result['httkv'] ?? '—')) . '&thinsp;mL/m';                },
                'calc-result-mt32'
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
