<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/**
 * IgAN — International IgA Nephropathy Prediction Tool
 * Barbour SJ et al. JAMA Intern Med. 2019;179(7):942–952. PMC7876283
 * Klinický model (bez histológie) — Cox proportional hazards
 */
function iganRisk(
    float $egfr,
    float $uprotGDay,
    float $map,
    bool $rasb,
    bool $immuno,
): float {
    $lp =
        -0.02663 * ($egfr - 66.0) +
        0.55198 * ($uprotGDay - 1.7) +
        0.00678 * ($map - 96.0) +
        -0.23079 * (($rasb ? 1 : 0) - 0.65) +
        -0.63861 * (($immuno ? 1 : 0) - 0.21);

    $risk5yr = (1.0 - pow(0.972, exp($lp))) * 100.0;
    return max(0.0, min(100.0, $risk5yr));
}

function iganInterpretation(float $risk5yr): array
{
    $interp = [];
    $warn = [];

    if ($risk5yr < 5.0) {
        $interp[] =
            "5-ročné riziko " .
            number_format($risk5yr, 1, ",", " ") .
            " % — nízke riziko progresie.";
    } elseif ($risk5yr < 15.0) {
        $interp[] =
            "5-ročné riziko " .
            number_format($risk5yr, 1, ",", " ") .
            " % — stredné riziko; zvážiť optimalizáciu RASB a proteinúrie.";
    } elseif ($risk5yr < 40.0) {
        $interp[] =
            "5-ročné riziko " .
            number_format($risk5yr, 1, ",", " ") .
            " % — vysoké riziko; odporúča sa nefrologická konzultácia a zváženie imunosupresie.";
        $warn[] =
            "Zvážiť imunosupresívnu liečbu podľa KDIGO 2021 IgAN Guidelines.";
    } else {
        $interp[] =
            "5-ročné riziko " .
            number_format($risk5yr, 1, ",", " ") .
            " % — veľmi vysoké riziko rýchlej progresie.";
        $warn[] =
            "VYSOKÉ RIZIKO: Urgentná nefrologická konzultácia. Zvážiť imunosupresiu a prípravu na náhradu funkcie obličiek.";
    }

    return ["interpretation" => $interp, "warnings" => $warn];
}

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$pageUrl = $baseUrl . "calculator_igan.php";
$pageTitle = "IgAN Prediction Tool — riziko progresie IgA nefropatie";
$pageDesc =
    "International IgA Nephropathy Prediction Tool (Barbour 2019) — odhad 5-ročného rizika poklesu eGFR o ≥50 % alebo ESKD u pacientov s IgA nefropatiou.";

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "egfr" => (string) ($_POST["egfr"] ?? ""),
    "uprot_g_day" => (string) ($_POST["uprot_g_day"] ?? ""),
    "map_mmhg" => (string) ($_POST["map_mmhg"] ?? ""),
    "rasb" => (string) ($_POST["rasb"] ?? "0"),
    "immuno" => (string) ($_POST["immuno"] ?? "0"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_igan');
    } else {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $egfr = calculatorParsePositiveFloat($form["egfr"]);
        $uprotGDay = calculatorParsePositiveFloat($form["uprot_g_day"]);
        $mapMmhg = calculatorParsePositiveFloat($form["map_mmhg"]);
        $rasbBool = $form["rasb"] === "1";
        $immunoBool = $form["immuno"] === "1";

        if ($egfr === null) {
            $errors[] = "eGFR musí byť kladné číslo (napr. 45).";
        } elseif ($egfr > 150) {
            $errors[] = "eGFR musí byť ≤ 150 mL/min/1,73 m².";
        }

        if ($uprotGDay === null) {
            $errors[] = "Proteinúria musí byť kladné číslo (napr. 1.5).";
        } elseif ($uprotGDay > 30) {
            $errors[] = "Proteinúria musí byť ≤ 30 g/deň.";
        }

        if ($mapMmhg === null) {
            $errors[] = "Stredný arteriálny tlak (MAP) musí byť kladné číslo.";
        } elseif ($mapMmhg < 50 || $mapMmhg > 200) {
            $errors[] = "MAP musí byť v rozsahu 50–200 mmHg.";
        }

        if (empty($errors)) {
            $risk5yr = iganRisk(
                $egfr,
                $uprotGDay,
                $mapMmhg,
                $rasbBool,
                $immunoBool,
            );
            $interp = iganInterpretation($risk5yr);
            $calculated = [
                "egfr" => $egfr,
                "uprot_g_day" => $uprotGDay,
                "map_mmhg" => $mapMmhg,
                "rasb" => $rasbBool,
                "immuno" => $immunoBool,
                "risk5yr" => $risk5yr,
                "interpretation" => $interp["interpretation"],
                "warnings" => $interp["warnings"],
            ];

            if (isLoggedIn()) {
                try {
                    $saved = calculatorSaveResult(
                        $pdo,
                        (int) $_SESSION["user_id"],
                        "igan",
                        "IgAN Prediction Tool",
                        $patient,
                        [
                            "examination_date" => $form["examination_date"],
                            "egfr" => $egfr,
                            "uprot_g_day" => $uprotGDay,
                            "map_mmhg" => $mapMmhg,
                            "rasb" => $rasbBool,
                            "immuno" => $immunoBool,
                        ],
                        ["risk5yr" => $risk5yr],
                    );
                    if ($saved) {
                        $messages[] = "Výsledok bol uložený.";
                    }
                } catch (\Throwable $e) {
                    $errors[] =
                        "Výsledok sa nepodarilo uložiť: " .
                        htmlspecialchars($e->getMessage());
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
            "igan",
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
      "IgAN Prediction Tool — riziko progresie IgA nefropatie | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_igan.php";
  $seoDescription =
      "International IgA Nephropathy Prediction Tool (Barbour 2019) — odhad 5-ročného rizika poklesu eGFR o ≥50 % alebo ESKD.";
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
                  "name" => "IgAN Prediction Tool",
                  "item" => $baseUrl . "calculator_igan.php",
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
    $headerTitle = "IgAN Prediction Tool";
    $headerIntro = "Predikcia progresie IgA nefropatie";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>IgAN Prediction Tool</h2>
                <p class="auth-subtitle">Odhad 5-ročného rizika poklesu eGFR o ≥&thinsp;50&thinsp;% alebo ESKD pri IgA nefropatii (Barbour et al. 2019, klinický model).</p>

                <div class="info-box-yellow">
                    <strong>⚠ Klinický model bez histológie.</strong> Pre presnejšie výsledky vrátane Oxford MEST-C skóre použite
                    <a href="https://qxcalc.app.link/igarisk" target="_blank" rel="noopener noreferrer">QxMD IgAN Tool</a>.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — IgAN Prediction Tool (Barbour 2019)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \begin{aligned} LP = &-0.02663 \cdot (\text{eGFR} - 66) + 0.55198 \cdot (\text{prot} - 1.7) \\ &+ 0.00678 \cdot (\text{MAP} - 96) - 0.23079 \cdot (\text{RASB} - 0.65) \\ &- 0.63861 \cdot (\text{IS} - 0.21) \end{aligned} \]</div>
                        <div class="calc-formula-line">\[ \text{Riziko (5 r.)} = (1 - 0.972^{\exp(LP)}) \times 100\% \]</div>
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

                <?php if ($calculated !== null): ?>
                <div class="calc-result-box" role="status" aria-label="Výsledok kalkulácie" aria-live="polite">
                    <h3>Výsledok — IgAN Prediction Tool</h3>
                    <div class="calc-result-grid">
                        <div class="calc-result-item calc-result-item--highlight">
                            <span class="calc-result-label">5-ročné riziko progresie</span>
                            <span class="calc-result-value"><?= number_format(
                                $calculated["risk5yr"],
                                1,
                                ",",
                                " ",
                            ) ?>&thinsp;%</span>
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
                        <a href="calculator_history.php?calc=igan_risk" class="btn-secondary">História IgAN</a>
                    </div>
                </div>
                <?php endif; ?>

                <form method="POST" action="calculator_igan.php" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                                                        <div class="form-group">
                                <label for="igan_egfr">eGFR (mL/min/1,73&thinsp;m²) <span class="required">*</span></label>
                                <input type="number" id="igan_egfr" name="egfr" min="1" max="150" step="0.1" required class="form-control" value="<?= htmlspecialchars(
                                    $form["egfr"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="igan_uprot">Proteinúria (g/deň) <span class="required">*</span></label>
                                <input type="number" id="igan_uprot" name="uprot_g_day" min="0.01" max="30" step="0.01" required class="form-control" value="<?= htmlspecialchars(
                                    $form["uprot_g_day"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="igan_map">MAP (mmHg) <span class="required">*</span></label>
                                <input type="number" id="igan_map" name="map_mmhg" min="50" max="200" step="1" required class="form-control" value="<?= htmlspecialchars(
                                    $form["map_mmhg"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="igan_rasb">Blokáda RAAS <span class="required">*</span></label>
                                <select id="igan_rasb" name="rasb" class="form-control">
                                    <option value="0" <?= $form["rasb"] === "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["rasb"] === "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="igan_immuno">Imunosupresívna liečba <span class="required">*</span></label>
                                <select id="igan_immuno" name="immuno" class="form-control">
                                    <option value="0" <?= $form["immuno"] ===
                                    "0"
                                        ? "selected"
                                        : "" ?>>Nie</option>
                                    <option value="1" <?= $form["immuno"] ===
                                    "1"
                                        ? "selected"
                                        : "" ?>>Áno</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" id="igan_submit">Vypočítať riziko</button>
                        <a href="calculator_igan.php" class="btn-secondary">Vymazať formulár</a>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>
            </div>

            <?php include "calculator_disclaimer.php"; ?>

            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_igan.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo number_format((float) ($result['risk5yr'] ?? 0), 1, ',', ' ') . '&thinsp;% (5-r.)';                },
                'calc-result-mt32'
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
