<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny vstup = 0. Vráti null pri neplatnom/zápornom. */
function crrtParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '') {
        return 0.0;
    }
    if (!is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa dodanej efluentovej dávky voči cieľu KDIGO (20–25 mL/kg/h). */
function crrtDoseClass(float $dose): string
{
    if ($dose < 20.0) {
        return 'risk-high';        // poddávkovanie
    }
    if ($dose <= 30.0) {
        return 'risk-low';         // cieľ + bežná rezerva na výpadky
    }
    return 'risk-moderate';        // nadmerná dávka
}

/** Slovný opis pásma dávky. */
function crrtDoseLabel(float $dose): string
{
    if ($dose < 20.0) {
        return 'pod cieľom KDIGO';
    }
    if ($dose <= 25.0) {
        return 'cieľové pásmo KDIGO';
    }
    if ($dose <= 30.0) {
        return 'prijateľná rezerva';
    }
    return 'nad cieľom';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "dialysate_ml_h" => (string) ($_POST["dialysate_ml_h"] ?? ""),
    "replacement_ml_h" => (string) ($_POST["replacement_ml_h"] ?? ""),
    "net_uf_ml_h" => (string) ($_POST["net_uf_ml_h"] ?? ""),
    "target_dose" => (string) ($_POST["target_dose"] ?? "25"),
    "downtime_pct" => (string) ($_POST["downtime_pct"] ?? ""),
    "patient_first_name" => (string) ($_POST["patient_first_name"] ?? ""),
    "patient_last_name" => (string) ($_POST["patient_last_name"] ?? ""),
    "patient_birth_date" => (string) ($_POST["patient_birth_date"] ?? ""),
    "patient_birth_number" => (string) ($_POST["patient_birth_number"] ?? ""),
    "patient_insurance_code" => (string) ($_POST["patient_insurance_code"] ?? ""),
    "examination_date" => (string) ($_POST["examination_date"] ?? date("Y-m-d")),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = (string) ($_POST["action"] ?? "");

    if (!validateCsrfToken((string) ($_POST["csrf_token"] ?? ""))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_crrt');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $weight = calculatorParsePositiveFloat($form["weight_kg"]);
        if ($weight === null) {
            $errors[] = "Hmotnosť musí byť kladné číslo (kg).";
        } elseif ($weight < 20.0 || $weight > 300.0) {
            $errors[] = "Hmotnosť mimo očakávaného rozsahu (20 – 300 kg).";
        }

        $dialysate = crrtParseNonNeg($form["dialysate_ml_h"]);
        if ($dialysate === null || $dialysate > 10000.0) {
            $errors[] = "Prietok dialyzátu musí byť 0 – 10 000 mL/h.";
        }
        $replacement = crrtParseNonNeg($form["replacement_ml_h"]);
        if ($replacement === null || $replacement > 10000.0) {
            $errors[] = "Prietok substitučného roztoku musí byť 0 – 10 000 mL/h.";
        }
        $netUf = crrtParseNonNeg($form["net_uf_ml_h"]);
        if ($netUf === null || $netUf > 2000.0) {
            $errors[] = "Čistá ultrafiltrácia musí byť 0 – 2 000 mL/h.";
        }
        if ($dialysate !== null && $replacement !== null
            && $dialysate + $replacement <= 0.0) {
            $errors[] = "Zadajte aspoň prietok dialyzátu alebo substitučného roztoku (inak nedochádza k očiste).";
        }

        $targetDose = calculatorParsePositiveFloat($form["target_dose"]);
        if ($targetDose === null) {
            $targetDose = 25.0;
        } elseif ($targetDose < 10.0 || $targetDose > 50.0) {
            $errors[] = "Cieľová dávka mimo rozsahu (10 – 50 mL/kg/h).";
        }

        $downtime = crrtParseNonNeg($form["downtime_pct"]);
        if ($downtime === null || $downtime > 50.0) {
            $errors[] = "Výpadok času musí byť 0 – 50 %.";
        }

        if (empty($errors)) {
            $effluentRate = (float) $dialysate + (float) $replacement + (float) $netUf;
            $prescribedDose = $effluentRate / (float) $weight;
            $deliveredDose = $prescribedDose * (1.0 - (float) $downtime / 100.0);
            $suggestedEffluent = (float) $targetDose * (float) $weight;

            $doseClass = crrtDoseClass($deliveredDose);
            $doseLabel = crrtDoseLabel($deliveredDose);

            $calculated = [
                "effluent_rate" => round($effluentRate, 0),
                "prescribed_dose" => round($prescribedDose, 1),
                "delivered_dose" => round($deliveredDose, 1),
                "suggested_effluent" => round($suggestedEffluent, 0),
                "target_dose" => round((float) $targetDose, 1),
                "downtime_pct" => round((float) $downtime, 0),
                "dose_class" => $doseClass,
                "dose_label" => $doseLabel,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "weight_kg" => round((float) $weight, 1),
                            "dialysate_ml_h" => round((float) $dialysate, 0),
                            "replacement_ml_h" => round((float) $replacement, 0),
                            "net_uf_ml_h" => round((float) $netUf, 0),
                            "target_dose" => round((float) $targetDose, 1),
                            "downtime_pct" => round((float) $downtime, 0),
                        ];
                        $resultPayload = [
                            "effluent_rate" => $calculated["effluent_rate"],
                            "prescribed_dose" => $calculated["prescribed_dose"],
                            "delivered_dose" => $calculated["delivered_dose"],
                            "dose_label" => $doseLabel,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "crrt_dose",
                                "CRRT — efluentová dávka",
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
                        error_log("calculator_crrt save error: " . $e->getMessage());
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
            "crrt_dose",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_crrt fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "CRRT — efluentová dávka (mL/kg/h) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_crrt.php";
  $seoDescription =
      "Kalkulačka dávky kontinuálnej náhrady funkcie obličiek (CRRT): efluentová dávka v mL/kg/h z prietokov dialyzátu, substitúcie a ultrafiltrácie, cieľ KDIGO 20–25 mL/kg/h a odhad dodanej dávky pri výpadkoch.";
  $baseUrl = "https://nefro.polascin.net/";
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
                  "name" => "CRRT — efluentová dávka",
                  "item" => $baseUrl . "calculator_crrt.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="crrt_dose">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Kalkulačka dávky CRRT";
    $headerIntro = "Efluentová dávka v mL/kg/h";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>CRRT — efluentová dávka</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + prietoky okruhu pre výpočet dávky.</p>

                <div class="info-box">
                    <strong>Cieľ dávky:</strong> KDIGO odporúča dodanú efluentovú dávku
                    <strong>20 – 25 mL/kg/h</strong>. Keďže reálne dochádza k výpadkom (zrážanie
                    filtra, výmeny vakov, výkony, transport), <em>predpíš</em> spravidla
                    <strong>25 – 30 mL/kg/h</strong>, aby dodaná dávka neklesla pod cieľ. Vyššie
                    dávky nemajú dokázaný prínos a zvyšujú stratu antibiotík, fosfátu a nutrientov.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — efluentová dávka CRRT</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ Q_{ef} = Q_{dial} + Q_{subst} + Q_{UF} \]</div>
                        <div class="calc-formula-line">\[ \text{dávka} \,[\text{mL/kg/h}] = \frac{Q_{ef}}{\text{hmotnosť}} \]</div>
                        <div class="calc-formula-line">\[ \text{dodaná} = \text{predpísaná} \times \left(1 - \frac{\text{výpadok \%}}{100}\right) \]</div>
                        <div class="calc-formula-vars">
                            $Q_{dial} = \text{prietok dialyzátu}$ &bull;
                            $Q_{subst} = \text{substitučný roztok (pre+post)}$ &bull;
                            $Q_{UF} = \text{čistá ultrafiltrácia}$ (mL/h)
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje:</strong>
                    <a href="https://kdigo.org/guidelines/acute-kidney-injury/" target="_blank" rel="noopener noreferrer">KDIGO AKI 2012</a> &ensp;&bull;&ensp;
                    RENAL (NEJM 2009) &ensp;&bull;&ensp; ATN (NEJM 2008)
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
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

                <form method="POST" action="calculator_crrt.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="weight_kg">Telesná hmotnosť (kg) <span class="required">*</span></label>
                                <input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars($form["weight_kg"]) ?>" placeholder="napr. 80">
                            </div>
                            <div class="form-group">
                                <label for="dialysate_ml_h">Prietok dialyzátu Q<sub>d</sub> (mL/h)</label>
                                <input type="text" id="dialysate_ml_h" name="dialysate_ml_h" class="form-control" value="<?= htmlspecialchars($form["dialysate_ml_h"]) ?>" placeholder="napr. 1000">
                            </div>
                            <div class="form-group">
                                <label for="replacement_ml_h">Substitučný roztok Q<sub>r</sub> (mL/h)</label>
                                <input type="text" id="replacement_ml_h" name="replacement_ml_h" class="form-control" value="<?= htmlspecialchars($form["replacement_ml_h"]) ?>" placeholder="pre + post, napr. 1000">
                            </div>
                            <div class="form-group">
                                <label for="net_uf_ml_h">Čistá ultrafiltrácia (mL/h) <span class="optional">— odber pacienta</span></label>
                                <input type="text" id="net_uf_ml_h" name="net_uf_ml_h" class="form-control" value="<?= htmlspecialchars($form["net_uf_ml_h"]) ?>" placeholder="napr. 100">
                            </div>
                            <div class="form-group">
                                <label for="target_dose">Cieľová dávka (mL/kg/h) <span class="optional">— pre návrh prietoku</span></label>
                                <input type="text" id="target_dose" name="target_dose" class="form-control" value="<?= htmlspecialchars($form["target_dose"]) ?>" placeholder="25">
                            </div>
                            <div class="form-group">
                                <label for="downtime_pct">Výpadok času (%) <span class="optional">— odhad dodanej dávky</span></label>
                                <input type="text" id="downtime_pct" name="downtime_pct" class="form-control" value="<?= htmlspecialchars($form["downtime_pct"]) ?>" placeholder="napr. 15">
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
                    $doseCls = (string) $calculated["dose_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($doseCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["prescribed_dose"], 1, ",", " ")) ?></span>
                                <span class="calc-result-unit">mL/kg/h</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($doseCls) ?>">
                                <?= htmlspecialchars(number_format((float)$calculated["delivered_dose"], 1, ",", " ")) ?> dodaná
                                <span><?= htmlspecialchars((string) $calculated["dose_label"]) ?></span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$calculated["delivered_dose"] ?>"
                             data-risk-max="40"
                             data-risk-label="dodaná dávka (mL/kg/h)"></div>
                        <p class="calc-result-detail"><strong>Efluentová rýchlosť:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["effluent_rate"], 0, ",", " ")) ?> mL/h
                            &ensp;&bull;&ensp;<strong>Predpísaná dávka:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["prescribed_dose"], 1, ",", " ")) ?> mL/kg/h
                            <?php if ((float)$calculated["downtime_pct"] > 0): ?>
                            &ensp;&bull;&ensp;<strong>Dodaná (po výpadku <?= htmlspecialchars(number_format((float)$calculated["downtime_pct"], 0, ",", " ")) ?> %):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["delivered_dose"], 1, ",", " ")) ?> mL/kg/h
                            <?php endif; ?>
                        </p>
                        <p class="calc-result-detail"><strong>Návrh prietoku pre cieľ <?= htmlspecialchars(number_format((float)$calculated["target_dose"], 1, ",", " ")) ?> mL/kg/h:</strong>
                            efluent ≈ <?= htmlspecialchars(number_format((float)$calculated["suggested_effluent"], 0, ",", " ")) ?> mL/h
                            (cieľ KDIGO dodanej dávky: 20 – 25 mL/kg/h).
                        </p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=crrt_dose" class="btn-secondary">História CRRT</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_crrt.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $presc  = (float) ($result['prescribed_dose'] ?? 0);
                    $deliv  = $result['delivered_dose'] ?? null;
                    $label  = (string) ($result['dose_label'] ?? '');
                    echo htmlspecialchars(number_format($presc, 1, ',', ' ')) . ' mL/kg/h';
                    if ($deliv !== null) {
                        echo ' (dodaná ' . htmlspecialchars(number_format((float) $deliv, 1, ',', ' '));
                        if ($label !== '') {
                            echo ', ' . htmlspecialchars($label);
                        }
                        echo ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
