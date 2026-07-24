<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny vstup = null (vyžiada chybu). Vráti null pri neplatnom/zápornom. */
function plasmicParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa PLASMIC skóre (0–7). */
function plasmicRiskClass(int $score): string
{
    if ($score >= 6) {
        return 'risk-high';
    }
    if ($score === 5) {
        return 'risk-moderate';
    }
    return 'risk-low';
}

/** Slovný opis rizikovej skupiny PLASMIC. */
function plasmicRiskLabel(int $score): string
{
    if ($score >= 6) {
        return 'vysoké riziko (≈ 62 – 82 %)';
    }
    if ($score === 5) {
        return 'stredné riziko (≈ 5 – 24 %)';
    }
    return 'nízke riziko (≈ 0 – 4 %)';
}

// Prah kreatinínu: 2,0 mg/dL ≈ 176,8 µmol/L (× 88,42).
const PLASMIC_CREA_UMOL = 176.8;

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "platelets" => (string) ($_POST["platelets"] ?? ""),
    "mcv" => (string) ($_POST["mcv"] ?? ""),
    "inr" => (string) ($_POST["inr"] ?? ""),
    "creatinine" => (string) ($_POST["creatinine"] ?? ""),
    "hemolysis" => isset($_POST["hemolysis"]) ? "1" : "",
    "active_cancer" => isset($_POST["active_cancer"]) ? "1" : "",
    "transplant" => isset($_POST["transplant"]) ? "1" : "",
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_plasmic');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $platelets = plasmicParseNonNeg($form["platelets"]);
        if ($platelets === null || $platelets > 1500.0) {
            $errors[] = "Počet trombocytov musí byť 0 – 1500 ×10⁹/L.";
        }
        $mcv = plasmicParseNonNeg($form["mcv"]);
        if ($mcv === null || $mcv < 50.0 || $mcv > 140.0) {
            $errors[] = "MCV musí byť 50 – 140 fL.";
        }
        $inr = plasmicParseNonNeg($form["inr"]);
        if ($inr === null || $inr < 0.5 || $inr > 15.0) {
            $errors[] = "INR musí byť 0,5 – 15.";
        }
        $creatinine = plasmicParseNonNeg($form["creatinine"]);
        if ($creatinine === null || $creatinine < 10.0 || $creatinine > 2000.0) {
            $errors[] = "Kreatinín musí byť 10 – 2000 µmol/L.";
        }

        $hemolysis = $form["hemolysis"] === "1";
        $activeCancer = $form["active_cancer"] === "1";
        $transplant = $form["transplant"] === "1";

        if (empty($errors)) {
            $cPlatelets = (float) $platelets < 30.0;
            $cHemolysis = $hemolysis;
            $cNoCancer = !$activeCancer;
            $cNoTransplant = !$transplant;
            $cMcv = (float) $mcv < 90.0;
            $cInr = (float) $inr < 1.5;
            $cCrea = (float) $creatinine < PLASMIC_CREA_UMOL;

            $score = ($cPlatelets ? 1 : 0) + ($cHemolysis ? 1 : 0)
                + ($cNoCancer ? 1 : 0) + ($cNoTransplant ? 1 : 0)
                + ($cMcv ? 1 : 0) + ($cInr ? 1 : 0) + ($cCrea ? 1 : 0);

            $calculated = [
                "score" => $score,
                "platelets" => round((float) $platelets, 0),
                "mcv" => round((float) $mcv, 0),
                "inr" => round((float) $inr, 2),
                "creatinine" => round((float) $creatinine, 0),
                "c_platelets" => $cPlatelets,
                "c_hemolysis" => $cHemolysis,
                "c_nocancer" => $cNoCancer,
                "c_notransplant" => $cNoTransplant,
                "c_mcv" => $cMcv,
                "c_inr" => $cInr,
                "c_crea" => $cCrea,
                "risk_class" => plasmicRiskClass($score),
                "risk_label" => plasmicRiskLabel($score),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "platelets" => round((float) $platelets, 0),
                            "mcv" => round((float) $mcv, 0),
                            "inr" => round((float) $inr, 2),
                            "creatinine" => round((float) $creatinine, 0),
                            "hemolysis" => $hemolysis,
                            "active_cancer" => $activeCancer,
                            "transplant" => $transplant,
                        ];
                        $resultPayload = [
                            "score" => $score,
                            "risk_label" => $calculated["risk_label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "plasmic_score",
                                "PLASMIC skóre (TTP / ADAMTS13)",
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
                        error_log("calculator_plasmic save error: " . $e->getMessage());
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
            "plasmic_score",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_plasmic fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "PLASMIC skóre — pravdepodobnosť ťažkého deficitu ADAMTS13 (TTP) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_plasmic.php";
  $seoDescription =
      "PLASMIC skóre (Bendapudi 2017) rýchlo odhaduje pravdepodobnosť ťažkého deficitu ADAMTS13 (TTP) u dospelých s trombotickou mikroangiopatiou. 7 komponentov (trombocyty, hemolýza, bez nádoru, bez transplantácie, MCV, INR, kreatinín): 0 – 4 nízke (≈ 0 – 4 %), 5 stredné (≈ 5 – 24 %), 6 – 7 vysoké (≈ 62 – 82 %) riziko.";
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
                  "name" => "PLASMIC skóre (TTP / ADAMTS13)",
                  "item" => $baseUrl . "calculator_plasmic.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="plasmic_score">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "PLASMIC skóre";
    $headerIntro = "Pravdepodobnosť ťažkého deficitu ADAMTS13 (TTP) pri TMA";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>PLASMIC skóre — TTP / ADAMTS13</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + 7 komponentov pre odhad pravdepodobnosti ťažkého deficitu ADAMTS13.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> u dospelého s trombotickou mikroangiopatiou
                    (TMA — trombocytopénia + mikroangiopatická hemolytická anémia) PLASMIC skóre
                    rýchlo odhaduje pravdepodobnosť <strong>ťažkého deficitu ADAMTS13 (≤ 10 %)</strong>,
                    teda trombotickej trombocytopenickej purpury (TTP). Pomáha pri rozhodovaní
                    o <strong>urgentnej výmennej plazmaferéze</strong>, kým nie je dostupný výsledok
                    aktivity ADAMTS13 (test má dlhú dobu odozvy). Akronym: <em>Platelets, Lysis
                    (hemolýza), Absence of cancer, absence of Stem-cell/Solid-organ transplant,
                    MCV, INR, Creatinine</em>.
                </div>

                <div class="info-box-yellow">
                    <strong>Pozor:</strong> skóre <strong>nenahrádza</strong> stanovenie aktivity
                    ADAMTS13 ani klinický úsudok. Pri silnom klinickom podozrení na TTP
                    <strong>nečakaj</strong> na skóre ani na ADAMTS13 — zaháj liečbu empiricky.
                    Nízke skóre nevylučuje inú TMA (STEC-HUS, atypická/komplementová HUS,
                    sekundárna TMA — lieky, malignita, gravidita, malígna hypertenzia).
                </div>

                <details open class="calc-formula-box">
                    <summary>Komponenty — PLASMIC (každý splnený = 1 bod, spolu 0 – 7)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-vars">
                            trombocyty &lt; 30 ×10⁹/L &bull;
                            hemolýza (retikulocyty &gt; 2,5 % / neprítomný haptoglobín / nepriamy bilirubín &gt; 34 µmol/L) &bull;
                            bez aktívneho nádoru (posledný rok) &bull;
                            bez transplantácie solídneho orgánu / kmeňových buniek &bull;
                            MCV &lt; 90 fL &bull;
                            INR &lt; 1,5 &bull;
                            kreatinín &lt; 176,8 µmol/L (2,0 mg/dL)
                        </div>
                        <div class="calc-formula-vars">
                            0 – 4 → nízke riziko (≈ 0 – 4 %) &bull;
                            5 → stredné (≈ 5 – 24 %) &bull;
                            6 – 7 → vysoké (≈ 62 – 82 %)
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/28259520/" target="_blank" rel="noopener noreferrer">Bendapudi P.K. et&nbsp;al., Lancet Haematol 2017;4(4):e157–64</a>
                    &ensp;&bull;&ensp;
                    <a href="https://pubmed.ncbi.nlm.nih.gov/31131442/" target="_blank" rel="noopener noreferrer">Upadhyay V.A. et&nbsp;al., Br J Haematol 2019;186(3):490–8</a>
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

                <form method="POST" action="calculator_plasmic.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Laboratórne hodnoty</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="platelets">Trombocyty (×10⁹/L) <span class="required">*</span></label>
                                <input type="text" id="platelets" name="platelets" required class="form-control" value="<?= htmlspecialchars($form["platelets"]) ?>" placeholder="napr. 18">
                                <small class="form-hint">Bod pri &lt; 30.</small>
                            </div>
                            <div class="form-group">
                                <label for="mcv">MCV (fL) <span class="required">*</span></label>
                                <input type="text" id="mcv" name="mcv" required class="form-control" value="<?= htmlspecialchars($form["mcv"]) ?>" placeholder="napr. 88">
                                <small class="form-hint">Bod pri &lt; 90.</small>
                            </div>
                            <div class="form-group">
                                <label for="inr">INR <span class="required">*</span></label>
                                <input type="text" id="inr" name="inr" required class="form-control" value="<?= htmlspecialchars($form["inr"]) ?>" placeholder="napr. 1,1">
                                <small class="form-hint">Bod pri &lt; 1,5.</small>
                            </div>
                            <div class="form-group">
                                <label for="creatinine">Kreatinín (µmol/L) <span class="required">*</span></label>
                                <input type="text" id="creatinine" name="creatinine" required class="form-control" value="<?= htmlspecialchars($form["creatinine"]) ?>" placeholder="napr. 110">
                                <small class="form-hint">Bod pri &lt; 176,8 (2,0 mg/dL).</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Klinické a hematologické kritériá</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="hemolysis" value="1" <?= $form["hemolysis"] === "1" ? "checked" : "" ?>> Hemolýza prítomná (retikulocyty &gt; 2,5 % / neprítomný haptoglobín / nepriamy bilirubín &gt; 34 µmol/L) <span class="form-check-pts">(+1)</span></label>
                                <label class="form-check"><input type="checkbox" name="active_cancer" value="1" <?= $form["active_cancer"] === "1" ? "checked" : "" ?>> Aktívny nádor (liečený v ostatnom roku) <span class="form-check-pts">(bez nádoru = +1)</span></label>
                                <label class="form-check"><input type="checkbox" name="transplant" value="1" <?= $form["transplant"] === "1" ? "checked" : "" ?>> Anamnéza transplantácie solídneho orgánu / kmeňových buniek <span class="form-check-pts">(bez transplantácie = +1)</span></label>
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
                                <span class="calc-result-big-value"><?= (int) $calculated["score"] ?></span>
                                <span class="calc-result-unit">PLASMIC bodov (z 7)</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["risk_label"]) ?>
                                <span>ťažký deficit ADAMTS13</span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (int)$calculated["score"] ?>"
                             data-risk-max="7"
                             data-risk-label="PLASMIC skóre (z 7)"></div>
                        <p class="calc-result-detail"><strong>Splnené komponenty:</strong>
                            trombocyty &lt; 30: <?= $calculated["c_platelets"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; hemolýza: <?= $calculated["c_hemolysis"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; bez nádoru: <?= $calculated["c_nocancer"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; bez transplantácie: <?= $calculated["c_notransplant"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; MCV &lt; 90: <?= $calculated["c_mcv"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; INR &lt; 1,5: <?= $calculated["c_inr"] ? "✓" : "✗" ?>
                            &ensp;&bull;&ensp; kreatinín &lt; 176,8: <?= $calculated["c_crea"] ? "✓" : "✗" ?>
                        </p>
                        <p class="calc-result-detail"><strong>Vstupy:</strong>
                            trombocyty <?= htmlspecialchars(number_format((float)$calculated["platelets"], 0, ",", " ")) ?> ×10⁹/L
                            &ensp;&bull;&ensp; MCV <?= htmlspecialchars(number_format((float)$calculated["mcv"], 0, ",", " ")) ?> fL
                            &ensp;&bull;&ensp; INR <?= htmlspecialchars(number_format((float)$calculated["inr"], 2, ",", " ")) ?>
                            &ensp;&bull;&ensp; kreatinín <?= htmlspecialchars(number_format((float)$calculated["creatinine"], 0, ",", " ")) ?> µmol/L
                        </p>
                        <?php if ($calculated["score"] >= 6): ?>
                            <p class="calc-result-detail"><strong>Vysoká pravdepodobnosť TTP.</strong> Zváž <strong>empirickú výmennú plazmaferézu</strong> a kortikosteroidy ešte pred výsledkom ADAMTS13; urýchli odber ADAMTS13 a konzultuj hematológiu. Pri iTTP zváž kaplacizumab podľa lokálnych protokolov.</p>
                        <?php elseif ($calculated["score"] === 5): ?>
                            <p class="calc-result-detail"><strong>Stredné riziko — nejednoznačné.</strong> Urýchli stanovenie ADAMTS13 a rozhodni individuálne podľa klinického obrazu a dynamiky; pri zhoršovaní neodkladaj plazmaferézu.</p>
                        <?php else: ?>
                            <p class="calc-result-detail"><strong>Nízke riziko ťažkého deficitu ADAMTS13.</strong> TTP je menej pravdepodobná — aktívne hľadaj inú príčinu TMA (STEC-HUS, atypická/komplementová HUS, sekundárna TMA). Rozhodnutie však vždy koreluj s klinikou — pri pochybnostiach over ADAMTS13.</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">PLASMIC je <strong>pomôcka pred testom ADAMTS13</strong>, validovaná u dospelých s TMA. Nepoužívaj ho ako jediný dôvod na začatie alebo nezačatie liečby.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=plasmic_score" class="btn-secondary">História PLASMIC</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_plasmic.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $score = (int) ($result['score'] ?? 0);
                    $label = (string) ($result['risk_label'] ?? '');
                    echo $score . ' bodov';
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
