<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny vstup = null (vyžiada chybu). Vráti null pri neplatnom/zápornom. */
function tlsParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa klasifikácie Cairo–Bishop. */
function tlsRiskClass(bool $ctls, bool $ltls): string
{
    if ($ctls) {
        return 'risk-high';
    }
    if ($ltls) {
        return 'risk-moderate';
    }
    return 'risk-low';
}

/** Slovný opis klasifikácie Cairo–Bishop. */
function tlsRiskLabel(bool $ctls, bool $ltls): string
{
    if ($ctls) {
        return 'klinický TLS';
    }
    if ($ltls) {
        return 'laboratórny TLS';
    }
    return 'bez TLS (Cairo–Bishop)';
}

// Absolútne prahy Cairo–Bishop (SI jednotky).
const TLS_URIC_ACID = 476.0;   // µmol/L (8 mg/dL)
const TLS_POTASSIUM = 6.0;     // mmol/L
const TLS_PHOS_ADULT = 1.45;   // mmol/L (4,5 mg/dL) — dospelí
const TLS_PHOS_CHILD = 2.1;    // mmol/L (6,5 mg/dL) — deti
const TLS_CALCIUM = 1.75;      // mmol/L (7 mg/dL) — korigovaný/ionizovaný

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "uric_acid" => (string) ($_POST["uric_acid"] ?? ""),
    "potassium" => (string) ($_POST["potassium"] ?? ""),
    "phosphate" => (string) ($_POST["phosphate"] ?? ""),
    "calcium" => (string) ($_POST["calcium"] ?? ""),
    "age_group" => (($_POST["age_group"] ?? "") === "child") ? "child" : "adult",
    "crea_high" => isset($_POST["crea_high"]) ? "1" : "",
    "arrhythmia" => isset($_POST["arrhythmia"]) ? "1" : "",
    "seizure" => isset($_POST["seizure"]) ? "1" : "",
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_tls');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $uricAcid = tlsParseNonNeg($form["uric_acid"]);
        if ($uricAcid === null || $uricAcid > 2000.0) {
            $errors[] = "Kyselina močová musí byť 0 – 2000 µmol/L.";
        }
        $potassium = tlsParseNonNeg($form["potassium"]);
        if ($potassium === null || $potassium < 1.5 || $potassium > 9.5) {
            $errors[] = "Draslík musí byť 1,5 – 9,5 mmol/L.";
        }
        $phosphate = tlsParseNonNeg($form["phosphate"]);
        if ($phosphate === null || $phosphate > 6.0) {
            $errors[] = "Fosfát musí byť 0 – 6,0 mmol/L.";
        }
        $calcium = tlsParseNonNeg($form["calcium"]);
        if ($calcium === null || $calcium < 0.5 || $calcium > 4.0) {
            $errors[] = "Vápnik musí byť 0,5 – 4,0 mmol/L.";
        }

        $isChild = $form["age_group"] === "child";
        $phosThreshold = $isChild ? TLS_PHOS_CHILD : TLS_PHOS_ADULT;

        $creaHigh = $form["crea_high"] === "1";
        $arrhythmia = $form["arrhythmia"] === "1";
        $seizure = $form["seizure"] === "1";

        if (empty($errors)) {
            $fUric = (float) $uricAcid >= TLS_URIC_ACID;
            $fPotassium = (float) $potassium >= TLS_POTASSIUM;
            $fPhosphate = (float) $phosphate >= $phosThreshold;
            $fCalcium = (float) $calcium <= TLS_CALCIUM;

            $labCount = ($fUric ? 1 : 0) + ($fPotassium ? 1 : 0)
                + ($fPhosphate ? 1 : 0) + ($fCalcium ? 1 : 0);
            $clinicalCount = ($creaHigh ? 1 : 0) + ($arrhythmia ? 1 : 0) + ($seizure ? 1 : 0);

            // Laboratórny TLS: ≥ 2 metabolické odchýlky. Klinický TLS: LTLS + ≥ 1 klinický prejav.
            $ltls = $labCount >= 2;
            $ctls = $ltls && $clinicalCount >= 1;

            $calculated = [
                "lab_count" => $labCount,
                "clinical_count" => $clinicalCount,
                "ltls" => $ltls,
                "ctls" => $ctls,
                "is_child" => $isChild,
                "phos_threshold" => $phosThreshold,
                "uric_acid" => round((float) $uricAcid, 0),
                "potassium" => round((float) $potassium, 1),
                "phosphate" => round((float) $phosphate, 2),
                "calcium" => round((float) $calcium, 2),
                "f_uric" => $fUric,
                "f_potassium" => $fPotassium,
                "f_phosphate" => $fPhosphate,
                "f_calcium" => $fCalcium,
                "crea_high" => $creaHigh,
                "arrhythmia" => $arrhythmia,
                "seizure" => $seizure,
                "risk_class" => tlsRiskClass($ctls, $ltls),
                "risk_label" => tlsRiskLabel($ctls, $ltls),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "uric_acid" => round((float) $uricAcid, 0),
                            "potassium" => round((float) $potassium, 1),
                            "phosphate" => round((float) $phosphate, 2),
                            "calcium" => round((float) $calcium, 2),
                            "age_group" => $isChild ? "child" : "adult",
                            "crea_high" => $creaHigh,
                            "arrhythmia" => $arrhythmia,
                            "seizure" => $seizure,
                        ];
                        $resultPayload = [
                            "lab_count" => $labCount,
                            "clinical_count" => $clinicalCount,
                            "ltls" => $ltls,
                            "ctls" => $ctls,
                            "risk_label" => $calculated["risk_label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "tls_cairo",
                                "TLS — Cairo–Bishop klasifikácia",
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
                        error_log("calculator_tls save error: " . $e->getMessage());
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
            "tls_cairo",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_tls fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Syndróm rozpadu nádoru (TLS) — Cairo–Bishop klasifikácia | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_tls.php";
  $seoDescription =
      "Cairo–Bishop klasifikácia syndrómu rozpadu nádoru (TLS): laboratórny TLS = ≥ 2 metabolické odchýlky (kyselina močová ≥ 476 µmol/L, draslík ≥ 6,0, fosfát ≥ 1,45 dospelí / 2,1 deti, vápnik ≤ 1,75 mmol/L); klinický TLS = laboratórny TLS + obličkové postihnutie, arytmia alebo kŕče. Riziko akútneho poškodenia obličiek.";
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
                  "name" => "TLS — Cairo–Bishop klasifikácia",
                  "item" => $baseUrl . "calculator_tls.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="tls_cairo">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Syndróm rozpadu nádoru (TLS)";
    $headerIntro = "Cairo–Bishop klasifikácia — laboratórny vs. klinický TLS";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Syndróm rozpadu nádoru — Cairo–Bishop</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + metabolické a klinické kritériá pre klasifikáciu TLS.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> Cairo–Bishop klasifikuje syndróm rozpadu
                    nádoru (TLS) — život ohrozujúce metabolické rozvraty pri masívnom rozpade
                    nádorových buniek (najčastejšie 3 dni pred až 7 dní po začatí cytotoxickej
                    liečby pri vysoko proliferatívnych nádoroch — Burkittov lymfóm, ALL).
                    <strong>Laboratórny TLS</strong> = ≥ 2 metabolické odchýlky;
                    <strong>klinický TLS</strong> = laboratórny TLS + obličkové postihnutie,
                    arytmia alebo kŕče. TLS je častou príčinou akútneho poškodenia obličiek.
                </div>

                <div class="info-box-yellow">
                    <strong>Poznámka k metodike:</strong> používame absolútne prahy Cairo–Bishop.
                    Pôvodná definícia pripúšťa aj <em>25 % zmenu oproti východisku</em>; Howard
                    (NEJM 2011) toto kritérium spochybnil (25 % zmena v rámci normy nie je
                    klinicky významná) a hypokalciémiu počíta až ako <em>symptomatickú</em>.
                    Klasifikácia <strong>nenahrádza klinické posúdenie</strong> ani dynamiku
                    laboratórnych hodnôt v čase — TLS je dynamický proces, kontroluj opakovane.
                </div>

                <details open class="calc-formula-box">
                    <summary>Kritériá — Cairo–Bishop (každá odchýlka = 1 bod)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-vars">
                            <strong>Laboratórny TLS</strong> (≥ 2 z nasledujúcich):<br>
                            kyselina močová ≥ 476 µmol/L (8 mg/dL) &bull;
                            draslík ≥ 6,0 mmol/L &bull;
                            fosfát ≥ 1,45 mmol/L (dospelí) / ≥ 2,1 mmol/L (deti) &bull;
                            vápnik ≤ 1,75 mmol/L (7 mg/dL)
                        </div>
                        <div class="calc-formula-vars">
                            <strong>Klinický TLS</strong> = laboratórny TLS + aspoň 1 z:
                            kreatinín ≥ 1,5× ULN &bull; srdcová arytmia / náhla smrť &bull; kŕče
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15384972/" target="_blank" rel="noopener noreferrer">Cairo M.S., Bishop M., Br J Haematol 2004;127(1):3–11</a>
                    &ensp;&bull;&ensp;
                    <a href="https://pubmed.ncbi.nlm.nih.gov/21561350/" target="_blank" rel="noopener noreferrer">Howard S.C. et&nbsp;al., N Engl J Med 2011;364(19):1844–54</a>
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

                <form method="POST" action="calculator_tls.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Laboratórne kritériá</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="age_group">Veková kategória (prah fosfátu) <span class="required">*</span></label>
                                <select id="age_group" name="age_group" class="form-control">
                                    <option value="adult" <?= $form["age_group"] !== "child" ? "selected" : "" ?>>Dospelý (fosfát ≥ 1,45)</option>
                                    <option value="child" <?= $form["age_group"] === "child" ? "selected" : "" ?>>Dieťa (fosfát ≥ 2,1)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="uric_acid">Kyselina močová (µmol/L) <span class="required">*</span></label>
                                <input type="text" id="uric_acid" name="uric_acid" required class="form-control" value="<?= htmlspecialchars($form["uric_acid"]) ?>" placeholder="napr. 520">
                            </div>
                            <div class="form-group">
                                <label for="potassium">Draslík (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="potassium" name="potassium" required class="form-control" value="<?= htmlspecialchars($form["potassium"]) ?>" placeholder="napr. 6,2">
                            </div>
                            <div class="form-group">
                                <label for="phosphate">Fosfát (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="phosphate" name="phosphate" required class="form-control" value="<?= htmlspecialchars($form["phosphate"]) ?>" placeholder="napr. 1,6">
                            </div>
                            <div class="form-group">
                                <label for="calcium">Vápnik (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="calcium" name="calcium" required class="form-control" value="<?= htmlspecialchars($form["calcium"]) ?>" placeholder="napr. 1,7">
                                <small class="form-hint">Korigovaný na albumín alebo ionizovaný.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Klinické kritériá (pre klinický TLS)</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="crea_high" value="1" <?= $form["crea_high"] === "1" ? "checked" : "" ?>> Kreatinín ≥ 1,5× horná hranica normy (obličkové postihnutie)</label>
                                <label class="form-check"><input type="checkbox" name="arrhythmia" value="1" <?= $form["arrhythmia"] === "1" ? "checked" : "" ?>> Srdcová arytmia alebo náhla smrť</label>
                                <label class="form-check"><input type="checkbox" name="seizure" value="1" <?= $form["seizure"] === "1" ? "checked" : "" ?>> Kŕče (epileptický záchvat)</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null):
                    $riskCls = (string) $calculated["risk_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= (int) $calculated["lab_count"] ?></span>
                                <span class="calc-result-unit">z 4 laboratórnych kritérií</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["risk_label"]) ?>
                                <span><?= (int) $calculated["clinical_count"] ?> z 3 klinických kritérií</span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (int)$calculated["lab_count"] ?>"
                             data-risk-max="4"
                             data-risk-label="Laboratórne kritériá (z 4)"></div>
                        <p class="calc-result-detail"><strong>Laboratórne kritériá:</strong>
                            kys. močová <?= htmlspecialchars(number_format((float)$calculated["uric_acid"], 0, ",", " ")) ?> µmol/L: <?= $calculated["f_uric"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; draslík <?= htmlspecialchars(number_format((float)$calculated["potassium"], 1, ",", " ")) ?> mmol/L: <?= $calculated["f_potassium"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; fosfát <?= htmlspecialchars(number_format((float)$calculated["phosphate"], 2, ",", " ")) ?> (prah <?= htmlspecialchars(number_format((float)$calculated["phos_threshold"], 2, ",", " ")) ?>) mmol/L: <?= $calculated["f_phosphate"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; vápnik <?= htmlspecialchars(number_format((float)$calculated["calcium"], 2, ",", " ")) ?> mmol/L: <?= $calculated["f_calcium"] ? "✓" : "✗" ?>
                        </p>
                        <p class="calc-result-detail"><strong>Klinické kritériá:</strong>
                            kreatinín ≥ 1,5× ULN: <?= $calculated["crea_high"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; arytmia / náhla smrť: <?= $calculated["arrhythmia"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; kŕče: <?= $calculated["seizure"] ? "áno" : "nie" ?>
                        </p>
                        <?php if ($calculated["ctls"]): ?>
                            <p class="calc-result-detail"><strong>Klinický TLS — urgentný stav.</strong> Intenzívne monitorovanie a liečba: agresívna hydratácia, rasburikáza pri hyperurikémii, korekcia hyperkaliémie a hyperfosfatémie, zváženie renálnej náhradnej liečby (RRT). Konzultuj nefrológiu a hematológiu/onkológiu.</p>
                        <?php elseif ($calculated["ltls"]): ?>
                            <p class="calc-result-detail"><strong>Laboratórny TLS.</strong> Zaveď/zintenzívni hydratáciu, urátznižujúcu liečbu (alopurinol/rasburikáza), opakuj laboratórne kontroly (kreatinín, K, fosfát, vápnik, kys. močová) v krátkych intervaloch a sleduj diurézu a EKG.</p>
                        <?php elseif ($calculated["lab_count"] === 1 && $calculated["clinical_count"] >= 1): ?>
                            <p class="calc-result-detail"><strong>Kritériá TLS zatiaľ nesplnené</strong> (laboratórny TLS vyžaduje ≥ 2 odchýlky), no klinický prejav je prítomný — zachovaj ostražitosť, hľadaj inú príčinu a opakuj laboratórne vyšetrenie. Klinický TLS je definovaný len pri súčasnom laboratórnom TLS.</p>
                        <?php else: ?>
                            <p class="calc-result-detail"><strong>Kritériá Cairo–Bishop pre TLS nie sú splnené.</strong> Pri vysokom riziku (veľká nádorová masa, vysoká proliferácia, prebiehajúca cytoredukcia) pokračuj v profylaxii a opakovanom monitorovaní — TLS sa môže rozvinúť neskôr.</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">Klasifikácia hodnotí <strong>metabolický syndróm</strong>, nie individuálne riziko jeho vzniku (na stratifikáciu rizika slúžia osobitné modely). Rozhoduj podľa celkového klinického obrazu a dynamiky hodnôt.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=tls_cairo" class="btn-secondary">História TLS</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_tls.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $labCount = (int) ($result['lab_count'] ?? 0);
                    $label    = (string) ($result['risk_label'] ?? '');
                    echo $labCount . ' z 4 lab. kritérií';
                    if ($label !== '') {
                        echo ' (' . htmlspecialchars($label) . ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
