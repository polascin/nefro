<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "s_na" => calculatorPostString("s_na"),
    "s_cl" => calculatorPostString("s_cl"),
    "s_hco3" => calculatorPostString("s_hco3"),
    "albumin" => calculatorPostString("albumin", "40"),
    "pco2" => calculatorPostString("pco2"),
    "patient_first_name" => calculatorPostString("patient_first_name"),
    "patient_last_name" => calculatorPostString("patient_last_name"),
    "patient_birth_date" => calculatorPostString("patient_birth_date"),
    "patient_birth_number" => calculatorPostString("patient_birth_number"),
    "patient_insurance_code" =>
        calculatorPostString("patient_insurance_code"),
    "examination_date" => calculatorPostString("examination_date", date("Y-m-d")),
];
$winters = null;
$alkalosisComp = null;

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = calculatorPostString("action");

    if (!validateCsrfToken(calculatorPostString("csrf_token"))) {
        $errors[] = "Neplatný CSRF token.";
    } elseif ($action === "delete_saved") {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_acidbase');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $na = calculatorParsePositiveFloat($form["s_na"]);
        $cl = calculatorParsePositiveFloat($form["s_cl"]);
        $hco3 = calculatorParsePositiveFloat($form["s_hco3"]);
        $alb = calculatorParsePositiveFloat($form["albumin"]);
        $pco2Raw = trim($form["pco2"]);
        $pco2 = $pco2Raw === "" ? null : calculatorParsePositiveFloat($form["pco2"]);

        if ($na === null) {
            $errors[] = "Zadajte platnú hodnotu S-Na.";
        }
        if ($cl === null) {
            $errors[] = "Zadajte platnú hodnotu S-Cl.";
        }
        if ($hco3 === null) {
            $errors[] = "Zadajte platnú hodnotu HCO3.";
        }
        if ($alb === null) {
            $alb = 40.0;
        }
        if ($pco2Raw !== "" && $pco2 === null) {
            $errors[] = "Zadajte platnú hodnotu pCO₂ (mmHg), alebo pole nechajte prázdne.";
        }

        if (empty($errors)) {
            $calculated = calculatorAnionGapAnalysis($na, $cl, $hco3, $alb);
            $winters = calculatorWintersCompensation($hco3, $pco2);
            $alkalosisComp = calculatorMetabolicAlkalosisCompensation($hco3, $pco2);
            if ($winters !== null) {
                $calculated = array_merge($calculated, [
                    "expected_pco2" => $winters["expected_pco2"],
                    "expected_pco2_low" => $winters["expected_pco2_low"],
                    "expected_pco2_high" => $winters["expected_pco2_high"],
                    "measured_pco2" => $winters["measured_pco2"],
                    "winters_interpretation" => $winters["interpretation"],
                ]);
            } elseif ($alkalosisComp !== null) {
                $calculated = array_merge($calculated, [
                    "expected_pco2" => $alkalosisComp["expected_pco2"],
                    "expected_pco2_low" => $alkalosisComp["expected_pco2_low"],
                    "expected_pco2_high" => $alkalosisComp["expected_pco2_high"],
                    "measured_pco2" => $alkalosisComp["measured_pco2"],
                    "alkalosis_interpretation" => $alkalosisComp["interpretation"],
                ]);
            }

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "s_na" => round($na, 1),
                            "s_cl" => round($cl, 1),
                            "s_hco3" => round($hco3, 1),
                            "albumin" => round($alb, 1),
                        ];
                        if ($pco2 !== null) {
                            $inputPayload["pco2"] = round($pco2, 1);
                        }

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "acidbase_ag",
                                "Acidobáza (Anion Gap)",
                                $patient,
                                $inputPayload,
                                $calculated,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log(
                            "calculator_acidbase save error: " .
                                $e->getMessage(),
                        );
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
            "acidbase_ag",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Aniónová medzera, Delta Ratio a respiračná kompenzácia | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_acidbase.php";
  $seoDescription =
      "Nefrologická kalkulačka: aniónová medzera, Δ/Δ pomer a očakávané pCO₂ pri metabolickej acidóze (Winters) aj alkalóze (Javaheri). Presné klinické výpočty pre lekárov na Slovensku.";
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
                  "name" => "Aniónová medzera a Delta-Delta pomer",
                  "item" => $baseUrl . "calculator_acidbase.php",
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
    $headerTitle = "Aniónová medzera (Anion Gap)";
    $headerIntro = "Súčasť analýzy metabolickej acidózy";
    $showLogo = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Aniónová medzera, Delta-Delta pomer a respiračná kompenzácia</h2>
                <p class="auth-subtitle">Základný nástroj na diagnostiku zmiešaných porúch acidobázickej rovnováhy.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{AG} = \text{Na} - (\text{Cl} + \text{HCO}_3) \]</div>
                        <div class="calc-formula-line">\[ \text{AG}_{\text{korig}} = \text{AG} + 0.25 \times (40 - \text{Albumín}) \]</div>
                        <div class="calc-formula-line">\[ \Delta\text{-Ratio} = \frac{\text{AG}_{\text{korig}} - 12}{24 - \text{HCO}_3} \]</div>
                        <div class="calc-formula-line">\[ \text{pCO}_{2,\text{očak.}} = 1{,}5 \times \text{HCO}_3 + 8 \pm 2\ \text{mmHg}\ (\text{acidóza}) \]</div>
                        <div class="calc-formula-line">\[ \text{pCO}_{2,\text{očak.}} = 0{,}7 \times \text{HCO}_3 + 20 \pm 5\ \text{mmHg}\ (\text{alkalóza}) \]</div>
                        <div class="calc-formula-vars">
                            Normálna aniónová medzera je cca 10–14&nbsp;mmol/L.<br>
                            U pacientov s hypoalbuminémiou (časté pri nefrotickom syndróme, závažnom CKD) musí byť AG korigovaná, inak sa falošne podhodnotí.<br>
                            Wintersova rovnica odhaduje očakávané pCO₂ pri <em>primárnej metabolickej acidóze</em> (HCO₃ &lt; 24&nbsp;mmol/L); pásmo ±&nbsp;2&nbsp;mmHg.<br>
                            Pri <em>primárnej metabolickej alkalóze</em> (HCO₃ &gt; 24&nbsp;mmol/L) platí Javaheriho vzťah 0,7&nbsp;·&nbsp;HCO₃&nbsp;+&nbsp;20 s pásmom ±&nbsp;5&nbsp;mmHg.<br>
                            Voliteľné namerané pCO₂ sa porovná s príslušným pásmom.<br>
                            <a href="https://pubmed.ncbi.nlm.nih.gov/9824071/" target="_blank" rel="noopener noreferrer">Figge J. et&nbsp;al., Crit Care Med 1998;26(11):1807–10</a>
                            &ensp;&bull;&ensp;
                            <a href="https://pubmed.ncbi.nlm.nih.gov/17656477/" target="_blank" rel="noopener noreferrer">Rastegar A., J Am Soc Nephrol 2007;18(9):2429–31</a>
                            &ensp;&bull;&ensp;
                            <a href="https://pubmed.ncbi.nlm.nih.gov/6016545/" target="_blank" rel="noopener noreferrer">Albert MS, Dell RB, Winters RW, Ann Intern Med 1967;66(2):312–22</a>
                            &ensp;&bull;&ensp;
                            <a href="https://pubmed.ncbi.nlm.nih.gov/6799256/" target="_blank" rel="noopener noreferrer">Javaheri S. et&nbsp;al., Chest 1982;81(3):296–301</a>
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success" role="status"><p><?= htmlspecialchars(
                        $message,
                    ) ?></p></div>
                <?php endforeach; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error" role="alert"><ul><?php foreach (
                        $errors
                        as $error
                    ): ?><li><?= htmlspecialchars(
    $error,
) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <form method="POST" action="calculator_acidbase.php">
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
                                                        <div class="form-group"><label for="s_na">S-Na (mmol/L)</label><input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_na"],
                            ) ?>"></div>
                            <div class="form-group"><label for="s_cl">S-Cl (mmol/L)</label><input type="text" id="s_cl" name="s_cl" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_cl"],
                            ) ?>"></div>
                            <div class="form-group"><label for="s_hco3">S-HCO3 (mmol/L)</label><input type="text" id="s_hco3" name="s_hco3" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_hco3"],
                            ) ?>"></div>
                            <div class="form-group"><label for="albumin">S-Albumín (g/L)</label><input type="text" id="albumin" name="albumin" class="form-control" value="<?= htmlspecialchars(
                                $form["albumin"],
                            ) ?>"></div>
                            <div class="form-group"><label for="pco2">pCO₂ (mmHg, voliteľné)</label><input type="text" id="pco2" name="pco2" class="form-control" inputmode="decimal" value="<?= htmlspecialchars(
                                $form["pco2"],
                            ) ?>"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>Nekorigovaná Aniónová medzera:</strong> <?= htmlspecialchars(
                            (string) $calculated["ag"],
                        ) ?> mmol/L</p>
                        <p><strong>Korigovaná Aniónová medzera (pri Alb. <?= htmlspecialchars(
                            (string) $calculated["alb"],
                        ) ?> g/L):</strong> <?= htmlspecialchars(
     (string) $calculated["corrected_ag"],
 ) ?> mmol/L</p>
                        <?php if ($calculated["delta_ratio"] !== null): ?>
                            <p class="calc-result-mt16"><strong>Delta Ratio (&Delta;/&Delta; pomer):</strong> <?= htmlspecialchars(
                                (string) $calculated["delta_ratio"],
                            ) ?></p>
                            <p class="calc-accent-text">Interpretácia: <?= htmlspecialchars(
                                $calculated["interpretation"],
                            ) ?></p>
                        <?php endif; ?>
                        <?php if ($winters !== null): ?>
                            <p class="calc-result-mt16"><strong>Wintersova očakávaná pCO₂:</strong> <?= htmlspecialchars(
                                (string) $winters["expected_pco2"],
                            ) ?> mmHg
                            (pásmo <?= htmlspecialchars((string) $winters["expected_pco2_low"]) ?>
                            až <?= htmlspecialchars((string) $winters["expected_pco2_high"]) ?> mmHg)</p>
                            <?php if ($winters["measured_pco2"] !== null): ?>
                                <p><strong>Nameraná pCO₂:</strong> <?= htmlspecialchars(
                                    (string) $winters["measured_pco2"],
                                ) ?> mmHg</p>
                            <?php endif; ?>
                            <p class="calc-accent-text"><?= htmlspecialchars(
                                $winters["interpretation"],
                            ) ?></p>
                        <?php elseif ($alkalosisComp !== null): ?>
                            <p class="calc-result-mt16"><strong>Očakávaná pCO₂ pri metabolickej alkalóze:</strong> <?= htmlspecialchars(
                                (string) $alkalosisComp["expected_pco2"],
                            ) ?> mmHg
                            (pásmo <?= htmlspecialchars((string) $alkalosisComp["expected_pco2_low"]) ?>
                            až <?= htmlspecialchars((string) $alkalosisComp["expected_pco2_high"]) ?> mmHg)</p>
                            <?php if ($alkalosisComp["measured_pco2"] !== null): ?>
                                <p><strong>Nameraná pCO₂:</strong> <?= htmlspecialchars(
                                    (string) $alkalosisComp["measured_pco2"],
                                ) ?> mmHg</p>
                            <?php endif; ?>
                            <p class="calc-accent-text"><?= htmlspecialchars(
                                $alkalosisComp["interpretation"],
                            ) ?></p>
                        <?php endif; ?>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=anion_gap" class="btn-secondary">História Anión. medzera</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_acidbase.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo 'AG: ' . number_format((float) ($result['ag'] ?? 0), 1) . ' mmol/L';
                    if (isset($result['delta_ratio'])) {
                        echo '<br>&Delta; Ratio: ' . number_format((float) $result['delta_ratio'], 2);
                    }                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
