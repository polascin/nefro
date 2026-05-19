<?php
require_once "auth.php";
require_once "db_config.php";
require_once "calculators_common.php";

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

calculatorSendSecurityHeaders();

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
];

if (isLoggedIn() && isset($_GET["load_id"])) {
    $loadId = (int) $_GET["load_id"];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION["user_id"]);
    if ($loadedRow) {
        $form["patient_first_name"]   = (string) ($loadedRow["patient_first_name"]   ?? "");
        $form["patient_last_name"]    = (string) ($loadedRow["patient_last_name"]    ?? "");
        $form["patient_birth_date"]   = (string) ($loadedRow["patient_birth_date"]   ?? "");
        $form["patient_birth_number"] = (string) ($loadedRow["patient_birth_number"] ?? "");
        $form["patient_insurance_code"] = (string) ($loadedRow["patient_insurance_code"] ?? "");
        if (is_array($loadedRow["input_payload"])) {
            foreach ($loadedRow["input_payload"] as $k => $v) {
                if (array_key_exists($k, $form)) $form[$k] = (string) $v;
            }
        }
        $messages[] = "Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.";
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
                } catch (\Throwable $e) {
                    $errors[] =
                        "Chyba pri mazaní: " .
                        htmlspecialchars($e->getMessage());
                }
            }
        }
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
                <div class="calc-result-box" role="region" aria-label="Výsledok kalkulácie">
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

            <section class="auth-container auth-container--wide calc-saved-results calc-result-mt32">
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
                                        <td><?= number_format(
                                            (float) ($row["result_payload"]["risk5yr"] ?? 0),
                                            1, ",", " ",
                                        ) ?>&thinsp;% (5-r.)</td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row["id"] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row["id"] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_igan.php" class="d-inline" data-confirm="Naozaj vymazať záznam?">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row["id"] ?>">
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
