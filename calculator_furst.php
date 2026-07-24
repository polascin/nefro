<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Nezáporné desatinné číslo; prázdny vstup = null (vyžiada chybu). Vráti null pri neplatnom/zápornom. */
function furstParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/** CSS trieda podľa Furstovho pomeru (U_Na+U_K)/S_Na. */
function furstClass(float $ratio): string
{
    if ($ratio < 0.5) {
        return 'risk-low';         // reštrikcia < 1000 mL/deň účinná
    }
    if ($ratio <= 1.0) {
        return 'risk-moderate';    // prísna reštrikcia < 500 mL/deň
    }
    return 'risk-high';            // reštrikcia tekutín neúčinná
}

/** Slovný opis pásma Furstovho pomeru. */
function furstLabel(float $ratio): string
{
    if ($ratio < 0.5) {
        return 'reštrikcia < 1000 mL/deň účinná';
    }
    if ($ratio <= 1.0) {
        return 'prísna reštrikcia < 500 mL/deň';
    }
    return 'reštrikcia tekutín neúčinná';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "u_na" => (string) ($_POST["u_na"] ?? ""),
    "u_k" => (string) ($_POST["u_k"] ?? ""),
    "s_na" => (string) ($_POST["s_na"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_furst');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $uNa = furstParseNonNeg($form["u_na"]);
        if ($uNa === null || $uNa > 400.0) {
            $errors[] = "Sodík v moči musí byť 0 – 400 mmol/L.";
        }
        $uK = furstParseNonNeg($form["u_k"]);
        if ($uK === null || $uK > 300.0) {
            $errors[] = "Draslík v moči musí byť 0 – 300 mmol/L.";
        }
        $sNa = calculatorParsePositiveFloat($form["s_na"]);
        if ($sNa === null) {
            $errors[] = "Sérový sodík musí byť kladné číslo (mmol/L).";
        } elseif ($sNa < 100.0 || $sNa > 180.0) {
            $errors[] = "Sérový sodík mimo očakávaného rozsahu (100 – 180 mmol/L).";
        }

        if (empty($errors)) {
            // Furstov pomer = (U_Na + U_K) / S_Na
            $ratio = ((float) $uNa + (float) $uK) / (float) $sNa;

            $furstClass = furstClass($ratio);
            $furstLabel = furstLabel($ratio);

            $calculated = [
                "ratio" => round($ratio, 2),
                "u_na" => round((float) $uNa, 0),
                "u_k" => round((float) $uK, 0),
                "s_na" => round((float) $sNa, 0),
                "furst_class" => $furstClass,
                "furst_label" => $furstLabel,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "u_na" => round((float) $uNa, 0),
                            "u_k" => round((float) $uK, 0),
                            "s_na" => round((float) $sNa, 0),
                        ];
                        $resultPayload = [
                            "ratio" => $calculated["ratio"],
                            "furst_label" => $furstLabel,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "furst_ratio",
                                "Furstov pomer (reštrikcia tekutín)",
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
                        error_log("calculator_furst save error: " . $e->getMessage());
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
            "furst_ratio",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_furst fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Furstov pomer — reštrikcia tekutín pri hyponatriémii | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_furst.php";
  $seoDescription =
      "Furstov pomer (U_Na + U_K) / S_Na predikuje účinnosť reštrikcie tekutín pri hyponatriémii (SIADH): < 0,5 reštrikcia < 1000 mL/deň, 0,5 – 1,0 prísna reštrikcia < 500 mL/deň, > 1,0 reštrikcia neúčinná. Odvodené z klírensu voľnej vody.";
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
                  "name" => "Furstov pomer (reštrikcia tekutín)",
                  "item" => $baseUrl . "calculator_furst.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="furst_ratio">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Furstov pomer";
    $headerIntro = "Predikcia účinnosti reštrikcie tekutín pri hyponatriémii";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Furstov pomer — reštrikcia tekutín</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + elektrolyty moču a séra pre predikciu reštrikcie.</p>

                <div class="info-box">
                    <strong>Načo to je:</strong> pri hyponatriémii (najmä SIADH) Furstov pomer
                    z pomeru elektrolytov v moči a sére predpovedá, či <em>samotná</em> reštrikcia
                    tekutín stačí na zvýšenie nátriémie. Vychádza z fyziológie <strong>klírensu
                    voľnej vody</strong>: ak je moč „koncentrovanejší“ elektrolytmi než sérum
                    (pomer &gt; 1), obličky nedokážu vylúčiť voľnú vodu a obmedzenie príjmu
                    tekutín nátriémiu nezvýši.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — Furstov pomer</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{pomer} = \frac{U_{Na} + U_K}{S_{Na}} \]</div>
                        <div class="calc-formula-vars">
                            $U_{Na} = \text{sodík v moči}$ &bull;
                            $U_K = \text{draslík v moči}$ &bull;
                            $S_{Na} = \text{sérový sodík}$ (mmol/L)
                        </div>
                        <div class="calc-formula-vars">
                            &lt; 0,5 → reštrikcia &lt; 1000 mL/deň &bull;
                            0,5 – 1,0 → prísna reštrikcia &lt; 500 mL/deň &bull;
                            &gt; 1,0 → reštrikcia neúčinná
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroj:</strong>
                    <a href="https://pubmed.ncbi.nlm.nih.gov/10768609/" target="_blank" rel="noopener noreferrer">Furst H. et&nbsp;al., Am J Med Sci 2000;319(4):240–4</a>
                    &ensp;&bull;&ensp; odvodené z klírensu voľnej vody bez elektrolytov
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

                <form method="POST" action="calculator_furst.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_na">Sodík v moči U<sub>Na</sub> (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="u_na" name="u_na" required class="form-control" value="<?= htmlspecialchars($form["u_na"]) ?>" placeholder="napr. 70">
                            </div>
                            <div class="form-group">
                                <label for="u_k">Draslík v moči U<sub>K</sub> (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="u_k" name="u_k" required class="form-control" value="<?= htmlspecialchars($form["u_k"]) ?>" placeholder="napr. 40">
                            </div>
                            <div class="form-group">
                                <label for="s_na">Sérový sodík S<sub>Na</sub> (mmol/L) <span class="required">*</span></label>
                                <input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars($form["s_na"]) ?>" placeholder="napr. 122">
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
                    $furstCls = (string) $calculated["furst_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($furstCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["ratio"], 2, ",", " ")) ?></span>
                                <span class="calc-result-unit">Furstov pomer</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($furstCls) ?>">
                                <?= htmlspecialchars((string) $calculated["furst_label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$calculated["ratio"] ?>"
                             data-risk-max="1.5"
                             data-risk-label="Furstov pomer"></div>
                        <p class="calc-result-detail"><strong>Vstupy:</strong>
                            U<sub>Na</sub> = <?= htmlspecialchars(number_format((float)$calculated["u_na"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; U<sub>K</sub> = <?= htmlspecialchars(number_format((float)$calculated["u_k"], 0, ",", " ")) ?>
                            &ensp;&bull;&ensp; S<sub>Na</sub> = <?= htmlspecialchars(number_format((float)$calculated["s_na"], 0, ",", " ")) ?> mmol/L
                        </p>
                        <?php if ((float)$calculated["ratio"] > 1.0): ?>
                            <p class="calc-result-detail"><strong>Reštrikcia tekutín sama o sebe neúčinná.</strong> Moč je elektrolytmi koncentrovanejší než sérum (záporný klírens voľnej vody) — zváž iný/doplnkový postup podľa príčiny (napr. slučkové diuretikum so soľou, urea, vaptan; pri ťažkej symptomatike hypertonický roztok).</p>
                        <?php elseif ((float)$calculated["ratio"] >= 0.5): ?>
                            <p class="calc-result-detail"><strong>Prísna reštrikcia (&lt; 500 mL/deň).</strong> Reštrikcia môže byť účinná, ale len výrazná; sleduj odpoveď nátriémie a zváž doplnkovú liečbu, ak je pomalá.</p>
                        <?php else: ?>
                            <p class="calc-result-detail"><strong>Reštrikcia &lt; 1000 mL/deň pravdepodobne účinná.</strong> Obličky vylučujú voľnú vodu; samotná reštrikcia tekutín by mala nátriémiu postupne zvyšovať.</p>
                        <?php endif; ?>
                        <p class="calc-result-detail">Pomer je <strong>pomôcka, nie absolútne pravidlo</strong> — koreguj rýchlosť tekutín so závažnosťou hyponatriémie a limitmi bezpečnej korekcie (riziko ODS).</p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=furst_ratio" class="btn-secondary">História Furst</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_furst.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $ratio  = (float) ($result['ratio'] ?? 0);
                    $label  = (string) ($result['furst_label'] ?? '');
                    echo 'pomer ' . htmlspecialchars(number_format($ratio, 2, ',', ' '));
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
