<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny vstup = null (vyžiada chybu). Vráti null pri neplatnom/zápornom. */
function mgusParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa počtu rizikových faktorov Mayo MGUS (0–3). */
function mgusRiskClass(int $factors): string
{
    if ($factors <= 0) {
        return 'risk-low';
    }
    if ($factors >= 3) {
        return 'risk-high';
    }
    return 'risk-moderate';
}

/** Slovný opis rizikovej skupiny Mayo MGUS. */
function mgusRiskLabel(int $factors): string
{
    switch ($factors) {
        case 0:
            return 'nízke riziko';
        case 1:
            return 'nízko-stredné riziko';
        case 2:
            return 'stredne-vysoké riziko';
        default:
            return 'vysoké riziko';
    }
}

/** 20-ročné absolútne riziko progresie MGUS podľa počtu faktorov (Rajkumar 2005). */
function mgusProgressionPct(int $factors): int
{
    $map = [0 => 5, 1 => 21, 2 => 37, 3 => 58];
    return $map[$factors] ?? 58;
}

// Normálne referenčné rozpätie κ/λ FLC pomeru (Mayo model, Katzmann 2002).
const MGUS_FLC_LOW = 0.26;
const MGUS_FLC_HIGH = 1.65;

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "m_protein" => (string) ($_POST["m_protein"] ?? ""),
    "isotype" => (string) ($_POST["isotype"] ?? "igg"),
    "kappa" => (string) ($_POST["kappa"] ?? ""),
    "lambda" => (string) ($_POST["lambda"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_mgus');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $mProtein = mgusParseNonNeg($form["m_protein"]);
        if ($mProtein === null || $mProtein > 100.0) {
            $errors[] = "Sérový M-proteín musí byť 0 – 100 g/L.";
        }

        $isotype = $form["isotype"] === "non_igg" ? "non_igg" : "igg";

        $kappa = calculatorParsePositiveFloat($form["kappa"]);
        if ($kappa === null || $kappa > 100000.0) {
            $errors[] = "Voľné κ reťazce musia byť kladné číslo (mg/L).";
        }
        $lambda = calculatorParsePositiveFloat($form["lambda"]);
        if ($lambda === null || $lambda > 100000.0) {
            $errors[] = "Voľné λ reťazce musia byť kladné číslo (mg/L).";
        }

        if (empty($errors)) {
            $ratio = (float) $kappa / (float) $lambda;
            $abnormalFlc = $ratio < MGUS_FLC_LOW || $ratio > MGUS_FLC_HIGH;
            $highMProtein = (float) $mProtein >= 15.0;
            $nonIgg = $isotype === "non_igg";

            $factors = ($highMProtein ? 1 : 0) + ($nonIgg ? 1 : 0) + ($abnormalFlc ? 1 : 0);

            $calculated = [
                "factors" => $factors,
                "progression_pct" => mgusProgressionPct($factors),
                "ratio" => round($ratio, 2),
                "kappa" => round((float) $kappa, 1),
                "lambda" => round((float) $lambda, 1),
                "m_protein" => round((float) $mProtein, 1),
                "isotype" => $isotype,
                "f_mprotein" => $highMProtein,
                "f_nonigg" => $nonIgg,
                "f_flc" => $abnormalFlc,
                "risk_class" => mgusRiskClass($factors),
                "risk_label" => mgusRiskLabel($factors),
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "m_protein" => round((float) $mProtein, 1),
                            "isotype" => $isotype,
                            "kappa" => round((float) $kappa, 1),
                            "lambda" => round((float) $lambda, 1),
                        ];
                        $resultPayload = [
                            "factors" => $factors,
                            "progression_pct" => $calculated["progression_pct"],
                            "ratio" => $calculated["ratio"],
                            "risk_label" => $calculated["risk_label"],
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "mgus_risk",
                                "MGUS — riziková stratifikácia (Mayo)",
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
                        error_log("calculator_mgus save error: " . $e->getMessage());
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
            "mgus_risk",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_mgus fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "MGUS — riziková stratifikácia (Mayo) a κ/λ pomer | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_mgus.php";
  $seoDescription =
      "Mayo riziková stratifikácia MGUS (Rajkumar 2005): tri faktory — M-proteín ≥ 15 g/L, non-IgG izotyp, abnormálny κ/λ pomer voľných ľahkých reťazcov — predikujú 20-ročné riziko progresie (5/21/37/58 %). S poznámkou k MGRS a renálnemu rozpätiu FLC.";
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
                  "name" => "MGUS — riziková stratifikácia",
                  "item" => $baseUrl . "calculator_mgus.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="mgus_risk">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "MGUS — riziková stratifikácia";
    $headerIntro = "Mayo model (Rajkumar 2005) + κ/λ pomer";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>MGUS — riziková stratifikácia (Mayo)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + paraproteín a voľné ľahké reťazce pre odhad rizika progresie.</p>

                <div class="info-box">
                    <strong>Čo počíta:</strong> Mayo model hodnotí riziko <em>hematologickej</em>
                    progresie monoklonálnej gamapatie nejasného významu (MGUS) na mnohopočetný
                    myelóm alebo príbuznú malignitu podľa troch faktorov: M-proteín ≥ 15 g/L,
                    iný izotyp než IgG a abnormálny pomer voľných ľahkých reťazcov (κ/λ mimo
                    <strong>0,26 – 1,65</strong>).
                </div>

                <div class="info-box-yellow">
                    <strong>MGRS ≠ riziko progresie:</strong> monoklonálna gamapatia
                    <em>renálneho</em> významu (MGRS) je definovaná obličkovým poškodením
                    nefrotoxickým paraproteínom <strong>bez ohľadu na tento skóring</strong>.
                    Aj pri nízkom skóre, ak je prítomné renálne postihnutie (proteinúria, pokles
                    eGFR, akcelerovaná CKD), je indikovaná <strong>renálna biopsia a hematologická
                    konzultácia</strong>. Použi <a href="calculator_mgrs.php">klasifikátor MGRS</a> —
                    tento nástroj odhaduje len hematologickú progresiu, nie renálny význam.
                </div>

                <details open class="calc-formula-box">
                    <summary>Model — tri rizikové faktory (každý = 1 bod)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{pomer} = \frac{\text{voľné } \kappa}{\text{voľné } \lambda} \]</div>
                        <div class="calc-formula-vars">
                            (1) M-proteín ≥ 15 g/L &bull;
                            (2) izotyp ≠ IgG &bull;
                            (3) κ/λ &lt; 0,26 alebo &gt; 1,65
                        </div>
                        <div class="calc-formula-vars">
                            20-ročné riziko progresie: 0 → 5 % &bull; 1 → 21 % &bull;
                            2 → 37 % &bull; 3 → 58 %
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/15855274/" target="_blank" rel="noopener noreferrer">Rajkumar S.V. et&nbsp;al., Blood 2005;106(3):812–7</a>
                    &ensp;&bull;&ensp; renálne rozpätie κ/λ ~0,37 – 3,1 (Hutchison, CJASN 2008) — pri CKD interpretuj hraničné hodnoty opatrne
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

                <form method="POST" action="calculator_mgus.php">
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
                                <label for="m_protein">Sérový M-proteín (g/L) <span class="required">*</span></label>
                                <input type="text" id="m_protein" name="m_protein" required class="form-control" value="<?= htmlspecialchars($form["m_protein"]) ?>" placeholder="napr. 8">
                            </div>
                            <div class="form-group">
                                <label for="isotype">Izotyp paraproteínu <span class="required">*</span></label>
                                <select id="isotype" name="isotype" class="form-control">
                                    <option value="igg" <?= $form["isotype"] !== "non_igg" ? "selected" : "" ?>>IgG</option>
                                    <option value="non_igg" <?= $form["isotype"] === "non_igg" ? "selected" : "" ?>>Iný než IgG (IgA / IgM / IgD)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kappa">Voľné κ reťazce (mg/L) <span class="required">*</span></label>
                                <input type="text" id="kappa" name="kappa" required class="form-control" value="<?= htmlspecialchars($form["kappa"]) ?>" placeholder="napr. 18,5">
                            </div>
                            <div class="form-group">
                                <label for="lambda">Voľné λ reťazce (mg/L) <span class="required">*</span></label>
                                <input type="text" id="lambda" name="lambda" required class="form-control" value="<?= htmlspecialchars($form["lambda"]) ?>" placeholder="napr. 14,0">
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
                    $riskCls = (string) $calculated["risk_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= (int) $calculated["progression_pct"] ?></span>
                                <span class="calc-result-unit">% — 20-ročné riziko progresie</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= (int) $calculated["factors"] ?> z 3 faktorov
                                <span><?= htmlspecialchars((string) $calculated["risk_label"]) ?></span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (int)$calculated["progression_pct"] ?>"
                             data-risk-max="60"
                             data-risk-label="20-ročné riziko progresie (%)"></div>
                        <p class="calc-result-detail"><strong>κ/λ pomer:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["ratio"], 2, ",", " ")) ?>
                            (κ <?= htmlspecialchars(number_format((float)$calculated["kappa"], 1, ",", " ")) ?> /
                            λ <?= htmlspecialchars(number_format((float)$calculated["lambda"], 1, ",", " ")) ?> mg/L)
                        </p>
                        <p class="calc-result-detail"><strong>Rizikové faktory:</strong>
                            M-proteín ≥ 15 g/L: <?= $calculated["f_mprotein"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; izotyp ≠ IgG: <?= $calculated["f_nonigg"] ? "áno" : "nie" ?>
                            &ensp;&bull;&ensp; abnormálny κ/λ: <?= $calculated["f_flc"] ? "áno" : "nie" ?>
                        </p>
                        <?php if ((float)$calculated["m_protein"] >= 30.0): ?>
                            <p class="calc-result-detail"><strong>Upozornenie:</strong> M-proteín ≥ 30 g/L prekračuje definíciu MGUS — zváž smoldering myelóm / mnohopočetný myelóm (potrebné CRAB kritériá, kostná dreň, zobrazenie).</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">Model odhaduje <strong>hematologickú</strong> progresiu, nie renálne riziko. Pri obličkovom postihnutí postupuj podľa <a href="calculator_mgrs.php">algoritmu MGRS</a> (biopsia, hematológ) bez ohľadu na skóre.</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=mgus_risk" class="btn-secondary">História MGUS</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_mgus.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $factors = (int) ($result['factors'] ?? 0);
                    $pct     = (int) ($result['progression_pct'] ?? 0);
                    $label   = (string) ($result['risk_label'] ?? '');
                    echo $factors . ' z 3 faktorov · ' . $pct . ' %';
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
