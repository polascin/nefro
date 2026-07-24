<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny/neplatný/záporný vstup = null. */
function kdpiParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/**
 * Lineárny prediktor KDRI (Rao 2009, model používaný OPTN — len darcovské faktory).
 * Sérový kreatinín v mg/dL, výška v cm, hmotnosť v kg, vek v rokoch.
 * KDRI_Rao = exp(xbeta); referenčný darca (xbeta = 0) má KDRI = 1,00.
 */
function kdriXbeta(
    float $ageYears,
    float $heightCm,
    float $weightKg,
    float $creatMgDl,
    bool $aaRace,
    bool $htn,
    bool $dm,
    bool $cva,
    bool $hcv,
    bool $dcd
): float {
    // OPTN: sérový kreatinín sa pri výpočte stropuje na 8,0 mg/dL.
    $cr = min($creatMgDl, 8.0);

    $x = 0.0128 * ($ageYears - 40.0);
    if ($ageYears < 18.0) {
        $x += -0.0194 * ($ageYears - 18.0);
    }
    if ($ageYears > 50.0) {
        $x += 0.0107 * ($ageYears - 50.0);
    }
    $x += -0.0464 * ($heightCm - 170.0) / 10.0;
    if ($weightKg < 80.0) {
        $x += -0.0199 * ($weightKg - 80.0) / 5.0;
    }
    if ($aaRace) {
        $x += 0.1790;
    }
    if ($htn) {
        $x += 0.1260;
    }
    if ($dm) {
        $x += 0.1300;
    }
    if ($cva) {
        $x += 0.0881;
    }
    $x += 0.2200 * ($cr - 1.0);
    if ($cr > 1.5) {
        $x += -0.2090 * ($cr - 1.5);
    }
    if ($hcv) {
        $x += 0.2400;
    }
    if ($dcd) {
        $x += 0.1330;
    }
    return $x;
}

/** CSS trieda podľa veľkosti KDRI_Rao (referenčný darca = 1,00). */
function kdriRiskClass(float $kdri): string
{
    if ($kdri < 1.0) {
        return 'risk-low';
    }
    if ($kdri < 1.45) {
        return 'risk-moderate';
    }
    return 'risk-high';
}

/** Slovný opis veľkosti KDRI_Rao. */
function kdriRiskLabel(float $kdri): string
{
    if ($kdri < 1.0) {
        return 'nižšie riziko než referenčný darca';
    }
    if ($kdri < 1.45) {
        return 'stredné riziko';
    }
    return 'vyššie riziko';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "height_cm" => (string) ($_POST["height_cm"] ?? ""),
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "creatinine_value" => (string) ($_POST["creatinine_value"] ?? ""),
    "creatinine_unit" => (string) ($_POST["creatinine_unit"] ?? "umol_l"),
    "aa_race" => isset($_POST["aa_race"]) ? "1" : "",
    "hypertension" => isset($_POST["hypertension"]) ? "1" : "",
    "diabetes" => isset($_POST["diabetes"]) ? "1" : "",
    "cva_death" => isset($_POST["cva_death"]) ? "1" : "",
    "hcv" => isset($_POST["hcv"]) ? "1" : "",
    "dcd" => isset($_POST["dcd"]) ? "1" : "",
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_kdpi');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $age = kdpiParseNonNeg($form["age_years"]);
        if ($age === null || $age > 100.0) {
            $errors[] = "Vek darcu musí byť 0 – 100 rokov.";
        }
        $height = calculatorParsePositiveFloat($form["height_cm"]);
        if ($height === null || $height < 20.0 || $height > 250.0) {
            $errors[] = "Výška darcu musí byť 20 – 250 cm.";
        }
        $weight = calculatorParsePositiveFloat($form["weight_kg"]);
        if ($weight === null || $weight > 300.0) {
            $errors[] = "Hmotnosť darcu musí byť kladné číslo (≤ 300 kg).";
        }
        $creatValue = calculatorParsePositiveFloat($form["creatinine_value"]);
        if ($creatValue === null) {
            $errors[] = "Sérový kreatinín musí byť kladné číslo.";
        }
        $creatUnit = in_array($form["creatinine_unit"], ["umol_l", "mg_dl"], true)
            ? $form["creatinine_unit"] : "";
        if ($creatUnit === "") {
            $errors[] = "Vyberte jednotku kreatinínu.";
        }

        if (empty($errors)) {
            $creatMgDl = $creatUnit === "umol_l"
                ? (float) $creatValue / 88.4
                : (float) $creatValue;

            $aaRace = $form["aa_race"] === "1";
            $htn = $form["hypertension"] === "1";
            $dm = $form["diabetes"] === "1";
            $cva = $form["cva_death"] === "1";
            $hcv = $form["hcv"] === "1";
            $dcd = $form["dcd"] === "1";

            $xbeta = kdriXbeta(
                (float) $age,
                (float) $height,
                (float) $weight,
                $creatMgDl,
                $aaRace,
                $htn,
                $dm,
                $cva,
                $hcv,
                $dcd
            );
            $kdri = exp($xbeta);
            $creatCapped = $creatMgDl > 8.0;

            $calculated = [
                "kdri" => round($kdri, 2),
                "age" => round((float) $age, 0),
                "height" => round((float) $height, 0),
                "weight" => round((float) $weight, 1),
                "creat_mg_dl" => round($creatMgDl, 2),
                "creat_capped" => $creatCapped,
                "aa_race" => $aaRace,
                "htn" => $htn,
                "dm" => $dm,
                "cva" => $cva,
                "hcv" => $hcv,
                "dcd" => $dcd,
                "risk_class" => kdriRiskClass($kdri),
                "risk_label" => kdriRiskLabel($kdri),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "age_years" => round((float) $age, 0),
                            "height_cm" => round((float) $height, 0),
                            "weight_kg" => round((float) $weight, 1),
                            "creatinine_mg_dl" => round($creatMgDl, 2),
                            "creatinine_unit" => $creatUnit,
                            "aa_race" => $aaRace,
                            "hypertension" => $htn,
                            "diabetes" => $dm,
                            "cva_death" => $cva,
                            "hcv" => $hcv,
                            "dcd" => $dcd,
                        ];
                        $resultPayload = [
                            "kdri" => round($kdri, 2),
                            "risk_label" => $calculated["risk_label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "kdri_kdpi",
                                "KDRI — index rizika darcu obličky (Rao 2009)",
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
                        error_log("calculator_kdpi save error: " . $e->getMessage());
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
            "kdri_kdpi",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_kdpi fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "KDRI — index rizika darcu obličky (základ KDPI) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_kdpi.php";
  $seoDescription =
      "Kidney Donor Risk Index (KDRI, Rao 2009): exaktný výpočet relatívneho rizika zlyhania štepu zomretého darcu z 10 darcovských faktorov (vek, výška, hmotnosť, kreatinín, hypertenzia, diabetes, CVA, HCV, DCD, pôvod). KDPI percentil vyžaduje ročne aktualizovanú referenčnú populáciu OPTN — odkaz na oficiálnu kalkulačku.";
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
                  "name" => "KDRI — index rizika darcu obličky",
                  "item" => $baseUrl . "calculator_kdpi.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="kdri_kdpi">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "KDRI — index rizika darcu obličky";
    $headerIntro = "Kidney Donor Risk Index (Rao 2009) — základ KDPI";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>KDRI — index rizika darcu obličky</h2>
                <p class="auth-subtitle">Voliteľné údaje + darcovské faktory pre výpočet relatívneho rizika zlyhania štepu.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> <strong>KDRI</strong> (Kidney Donor Risk Index)
                    vyčísľuje <em>relatívne</em> riziko zlyhania obličkového štepu zomretého darcu
                    z 10 darcovských charakteristík. Výsledok je <strong>pomer rizík (HR)</strong>
                    voči <strong>referenčnému darcovi</strong> (KDRI = 1,00): napr. KDRI 1,40 znamená
                    o 40 % vyššie riziko zlyhania štepu než referenčný darca. KDRI je <em>presne</em>
                    vypočítateľný z fixných koeficientov modelu Rao 2009.
                </div>

                <div class="info-box-yellow">
                    <strong>KDRI ≠ KDPI:</strong> <strong>KDPI</strong> (Kidney Donor Profile Index,
                    0 – 100 %) je <em>percentil</em> KDRI v referenčnej populácii darcov za predošlý
                    rok. Jeho výpočet vyžaduje <strong>ročne aktualizovaný škálovací faktor a mapovaciu
                    tabuľku OPTN</strong>, ktoré sa každoročne menia — preto tu KDPI percentil zámerne
                    <strong>neuvádzame</strong>. Pre oficiálny KDPI použi
                    <a href="https://optn.transplant.hrsa.gov/data/allocation-calculators/kdpi-calculator/" target="_blank" rel="noopener noreferrer">kalkulačku OPTN</a>
                    (zadaj rovnaké faktory + dátum). Model je odvodený z dát USA — pri prenose na
                    európsku populáciu interpretuj opatrne.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — KDRI_Rao (10 darcovských faktorov)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{KDRI} = \exp\!\left(\sum \beta_i x_i\right),\quad S_{cr}[\text{mg/dL}] = S_{cr}[\mu\text{mol/L}] \div 88{,}4 \]</div>
                        <div class="calc-formula-vars">
                            vek: +0,0128·(vek−40); ak &lt;18: −0,0194·(vek−18); ak &gt;50: +0,0107·(vek−50) &bull;
                            výška: −0,0464·(výška−170)/10 &bull;
                            hmotnosť (ak &lt;80 kg): −0,0199·(hmotnosť−80)/5 &bull;
                            afroamerický pôvod: +0,179 &bull; hypertenzia: +0,126 &bull;
                            diabetes: +0,130 &bull; CVA príčina smrti: +0,0881 &bull;
                            kreatinín: +0,220·(S<sub>cr</sub>−1); ak &gt;1,5: −0,209·(S<sub>cr</sub>−1,5) &bull;
                            HCV+: +0,240 &bull; DCD: +0,133
                        </div>
                        <div class="calc-formula-vars">
                            S<sub>cr</sub> sa stropuje na 8,0 mg/dL. Referenčný darca (všetky členy = 0) má KDRI = 1,00.
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroj:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/19623019/" target="_blank" rel="noopener noreferrer">Rao P.S. et&nbsp;al., Transplantation 2009;88(2):231–6</a>
                    &ensp;&bull;&ensp; operacionalizácia a KDPI mapovanie: OPTN „Guide to Calculating and Interpreting the KDPI“
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

                <form method="POST" action="calculator_kdpi.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Darcovské faktory</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum hodnotenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek darcu (roky) <span class="required">*</span></label>
                                <input type="text" id="age_years" name="age_years" required class="form-control" value="<?= htmlspecialchars($form["age_years"]) ?>" placeholder="napr. 52">
                            </div>
                            <div class="form-group">
                                <label for="height_cm">Výška (cm) <span class="required">*</span></label>
                                <input type="text" id="height_cm" name="height_cm" required class="form-control" value="<?= htmlspecialchars($form["height_cm"]) ?>" placeholder="napr. 175">
                            </div>
                            <div class="form-group">
                                <label for="weight_kg">Hmotnosť (kg) <span class="required">*</span></label>
                                <input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars($form["weight_kg"]) ?>" placeholder="napr. 78">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_value">Sérový kreatinín <span class="required">*</span></label>
                                <input type="text" id="creatinine_value" name="creatinine_value" required class="form-control" value="<?= htmlspecialchars($form["creatinine_value"]) ?>" placeholder="napr. 88">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_unit">Jednotka kreatinínu <span class="required">*</span></label>
                                <select id="creatinine_unit" name="creatinine_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form["creatinine_unit"] === "umol_l" ? "selected" : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form["creatinine_unit"] === "mg_dl" ? "selected" : "" ?>>mg/dL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <fieldset class="form-fieldset">
                            <legend>Anamnéza a okolnosti darcovstva</legend>
                            <div class="form-check-grid">
                                <label class="form-check"><input type="checkbox" name="hypertension" value="1" <?= $form["hypertension"] === "1" ? "checked" : "" ?>> Anamnéza hypertenzie <span class="form-check-pts">(+0,126)</span></label>
                                <label class="form-check"><input type="checkbox" name="diabetes" value="1" <?= $form["diabetes"] === "1" ? "checked" : "" ?>> Anamnéza diabetu <span class="form-check-pts">(+0,130)</span></label>
                                <label class="form-check"><input type="checkbox" name="cva_death" value="1" <?= $form["cva_death"] === "1" ? "checked" : "" ?>> Cerebrovaskulárna príčina smrti (CVA) <span class="form-check-pts">(+0,0881)</span></label>
                                <label class="form-check"><input type="checkbox" name="hcv" value="1" <?= $form["hcv"] === "1" ? "checked" : "" ?>> HCV pozitivita <span class="form-check-pts">(+0,240)</span></label>
                                <label class="form-check"><input type="checkbox" name="dcd" value="1" <?= $form["dcd"] === "1" ? "checked" : "" ?>> Darca po cirkulačnej smrti (DCD) <span class="form-check-pts">(+0,133)</span></label>
                                <label class="form-check"><input type="checkbox" name="aa_race" value="1" <?= $form["aa_race"] === "1" ? "checked" : "" ?>> Afroamerický pôvod darcu <span class="form-check-pts">(+0,179)</span></label>
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
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float) $calculated["kdri"], 2, ",", " ")) ?></span>
                                <span class="calc-result-unit">KDRI (HR vs. referenčný darca)</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["risk_label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= htmlspecialchars((string) $calculated["kdri"]) ?>"
                             data-risk-max="3"
                             data-risk-label="KDRI (referenčný darca = 1,00)"></div>
                        <p class="calc-result-detail"><strong>Vstupy:</strong>
                            vek <?= (int) $calculated["age"] ?> r &ensp;&bull;&ensp;
                            výška <?= (int) $calculated["height"] ?> cm &ensp;&bull;&ensp;
                            hmotnosť <?= htmlspecialchars(number_format((float) $calculated["weight"], 1, ",", " ")) ?> kg &ensp;&bull;&ensp;
                            kreatinín <?= htmlspecialchars(number_format((float) $calculated["creat_mg_dl"], 2, ",", " ")) ?> mg/dL<?php if ($calculated["creat_capped"]): ?> (stropované na 8,0)<?php endif; ?>
                        </p>
                        <p class="calc-result-detail"><strong>Rizikové faktory:</strong>
                            hypertenzia: <?= $calculated["htn"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; diabetes: <?= $calculated["dm"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; CVA: <?= $calculated["cva"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; HCV+: <?= $calculated["hcv"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; DCD: <?= $calculated["dcd"] ? "áno" : "nie" ?>
                        </p>
                        <p class="calc-result-detail"><strong>KDPI percentil:</strong> nie je vyčíslený (vyžaduje ročnú referenčnú populáciu OPTN). Pre oficiálny KDPI zadaj tie isté faktory do
                            <a href="https://optn.transplant.hrsa.gov/data/allocation-calculators/kdpi-calculator/" target="_blank" rel="noopener noreferrer">kalkulačky OPTN</a>. Nižší KDRI/KDPI = priaznivejší štep (dlhšia očakávaná funkcia); vyšší = kratšia.</p>
                        <p class="calc-result-detail">KDRI je <strong>prognostická pomôcka</strong> na úrovni darcu — rozhodnutie o akceptácii štepu zohľadňuje aj recipienta, studenú ischémiu a klinický kontext.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=kdri_kdpi" class="btn-secondary">História KDRI</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_kdpi.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $kdri  = $result['kdri'] ?? null;
                    $label = (string) ($result['risk_label'] ?? '');
                    echo 'KDRI ' . htmlspecialchars($kdri !== null ? number_format((float) $kdri, 2, ',', ' ') : '?');
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
