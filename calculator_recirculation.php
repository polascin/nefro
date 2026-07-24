<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** CSS trieda podľa miery recirkulácie (urea-based periférna/slow-flow metóda). */
function recircClass(float $pct): string
{
    if ($pct <= 5.0) {
        return 'risk-low';         // bez významnej recirkulácie
    }
    if ($pct <= 10.0) {
        return 'risk-moderate';    // hraničné — over techniku/polohu ihiel
    }
    return 'risk-high';            // významná recirkulácia
}

/** Slovný opis pásma recirkulácie. */
function recircLabel(float $pct): string
{
    if ($pct <= 5.0) {
        return 'bez významnej recirkulácie';
    }
    if ($pct <= 10.0) {
        return 'hraničná recirkulácia';
    }
    return 'významná recirkulácia';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "c_systemic" => (string) ($_POST["c_systemic"] ?? ""),
    "c_arterial" => (string) ($_POST["c_arterial"] ?? ""),
    "c_venous" => (string) ($_POST["c_venous"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_recirculation');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);

        $cP = calculatorParsePositiveFloat($form["c_systemic"]);
        if ($cP === null) {
            $errors[] = "Systémová koncentrácia (P) musí byť kladné číslo.";
        }
        $cA = calculatorParsePositiveFloat($form["c_arterial"]);
        if ($cA === null) {
            $errors[] = "Arteriálna koncentrácia (A) musí byť kladné číslo.";
        }
        $cV = calculatorParsePositiveFloat($form["c_venous"]);
        if ($cV === null) {
            $errors[] = "Venózna koncentrácia (V) musí byť kladné číslo.";
        }

        if ($cP !== null && $cV !== null && $cP - $cV <= 0.0) {
            $errors[] = "Systémová koncentrácia (P) musí byť vyššia než venózna (V) — venózna krv je vyčistená; skontroluj vzorky.";
        }

        if (empty($errors)) {
            // R% = (C_P − C_A) / (C_P − C_V) × 100
            $rawPct = (((float) $cP - (float) $cA) / ((float) $cP - (float) $cV)) * 100.0;
            // A ≥ P ⇒ žiadna detegovateľná recirkulácia (záporná hodnota = chyba odberu/laboratória)
            $recircPct = $rawPct < 0.0 ? 0.0 : $rawPct;
            $negativeRaw = $rawPct < 0.0;

            $recircClass = recircClass($recircPct);
            $recircLabel = recircLabel($recircPct);

            $calculated = [
                "recirc_pct" => round($recircPct, 1),
                "raw_negative" => $negativeRaw,
                "c_systemic" => round((float) $cP, 1),
                "c_arterial" => round((float) $cA, 1),
                "c_venous" => round((float) $cV, 1),
                "recirc_class" => $recircClass,
                "recirc_label" => $recircLabel,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "c_systemic" => round((float) $cP, 1),
                            "c_arterial" => round((float) $cA, 1),
                            "c_venous" => round((float) $cV, 1),
                        ];
                        $resultPayload = [
                            "recirc_pct" => $calculated["recirc_pct"],
                            "recirc_label" => $recircLabel,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "access_recirc",
                                "Recirkulácia cievneho prístupu",
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
                        error_log("calculator_recirculation save error: " . $e->getMessage());
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
            "access_recirc",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_recirculation fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Recirkulácia cievneho prístupu | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_recirculation.php";
  $seoDescription =
      "Kalkulačka recirkulácie cievneho prístupu pri hemodialýze: ureová trojvzorková metóda (systémová, arteriálna, venózna koncentrácia), výpočet R % a interpretácia podľa KDOQI (hranica 5 – 10 %).";
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
                  "name" => "Recirkulácia cievneho prístupu",
                  "item" => $baseUrl . "calculator_recirculation.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="access_recirc">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Recirkulácia cievneho prístupu";
    $headerIntro = "Ureová metóda — efektivita hemodialýzy";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Recirkulácia cievneho prístupu</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + tri koncentrácie urey pre výpočet recirkulácie.</p>

                <div class="info-box">
                    <strong>Čo meriame:</strong> recirkulácia znamená, že časť práve vyčistenej krvi
                    z venóznej ihly sa hneď vracia do arteriálnej ihly a dialyzuje sa znova — tým
                    klesá <em>účinná</em> dávka dialýzy (Kt/V). Najčastejšie príčiny: <strong>ihly
                    príliš blízko</strong> alebo zamenené linky (arteriálna/venózna), prípadne
                    <strong>nízky prietok prístupu</strong> (stenóza) voči nastavenému prietoku krvi.
                </div>

                <div class="info-box">
                    <strong>Technika odberu:</strong> všetky tri vzorky odoberaj v rovnakej jednotke
                    (urea mmol/L alebo BUN mg/dL — výsledok je pomer, takže jednotka sa skráti).
                    <strong>P</strong> je systémová koncentrácia (z periférnej žily druhej ruky alebo
                    technikou spomalenia pumpy / „slow-flow“), <strong>A</strong> z arteriálnej linky
                    (krv vstupujúca do dialyzátora) a <strong>V</strong> z venóznej linky (vyčistená
                    krv vracajúca sa do pacienta).
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — ureová recirkulácia</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ R\,[\%] = \frac{C_P - C_A}{C_P - C_V} \times 100 \]</div>
                        <div class="calc-formula-vars">
                            $C_P = \text{systémová (periférna / slow-flow)}$ &bull;
                            $C_A = \text{arteriálna linka}$ &bull;
                            $C_V = \text{venózna linka}$
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje:</strong>
                    <a href="https://www.ajkd.org/article/S0272-6386(19)31137-0/fulltext" target="_blank" rel="noopener noreferrer">KDOQI Vascular Access 2019</a> &ensp;&bull;&ensp;
                    ureová trojvzorková metóda &ensp;&bull;&ensp; hranica významnosti 5 – 10 %
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

                <form method="POST" action="calculator_recirculation.php">
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
                                <label for="c_systemic">Systémová koncentrácia C<sub>P</sub> <span class="required">*</span></label>
                                <input type="text" id="c_systemic" name="c_systemic" required class="form-control" value="<?= htmlspecialchars($form["c_systemic"]) ?>" placeholder="periférna žila / slow-flow">
                            </div>
                            <div class="form-group">
                                <label for="c_arterial">Arteriálna linka C<sub>A</sub> <span class="required">*</span></label>
                                <input type="text" id="c_arterial" name="c_arterial" required class="form-control" value="<?= htmlspecialchars($form["c_arterial"]) ?>" placeholder="krv do dialyzátora">
                            </div>
                            <div class="form-group">
                                <label for="c_venous">Venózna linka C<sub>V</sub> <span class="required">*</span></label>
                                <input type="text" id="c_venous" name="c_venous" required class="form-control" value="<?= htmlspecialchars($form["c_venous"]) ?>" placeholder="vyčistená krv">
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
                    $recircCls = (string) $calculated["recirc_class"];
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($recircCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["recirc_pct"], 1, ",", " ")) ?></span>
                                <span class="calc-result-unit">% recirkulácie</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($recircCls) ?>">
                                <?= htmlspecialchars((string) $calculated["recirc_label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$calculated["recirc_pct"] ?>"
                             data-risk-max="30"
                             data-risk-label="recirkulácia (%)"></div>
                        <p class="calc-result-detail"><strong>Vzorky:</strong>
                            P = <?= htmlspecialchars(number_format((float)$calculated["c_systemic"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; A = <?= htmlspecialchars(number_format((float)$calculated["c_arterial"], 1, ",", " ")) ?>
                            &ensp;&bull;&ensp; V = <?= htmlspecialchars(number_format((float)$calculated["c_venous"], 1, ",", " ")) ?>
                        </p>
                        <?php if (!empty($calculated["raw_negative"])): ?>
                            <p class="calc-result-detail">Arteriálna koncentrácia ≥ systémová ⇒ <strong>žiadna detegovateľná recirkulácia</strong> (zaokrúhlené na 0 %); ak je rozdiel výrazný, over správnosť odberu/laboratória.</p>
                        <?php elseif ((float)$calculated["recirc_pct"] > 10.0): ?>
                            <p class="calc-result-detail"><strong>Významná recirkulácia.</strong> Skontroluj polohu a vzdialenosť ihiel, vylúč zámenu arteriálnej a venóznej linky a posúď prietok prístupu (možná stenóza). Recirkulácia znižuje dodanú dávku dialýzy.</p>
                        <?php elseif ((float)$calculated["recirc_pct"] > 5.0): ?>
                            <p class="calc-result-detail"><strong>Hraničná hodnota.</strong> Over techniku odberu (správny systémový vzorok) a polohu ihiel; pri pretrvávaní zváž dilučnú metódu (ultrazvuk/teplota) na potvrdenie.</p>
                        <?php else: ?>
                            <p class="calc-result-detail">Recirkulácia v norme. Pri klesajúcej účinnosti dialýzy hľadaj príčinu inde (prietok krvi, dialyzátor, čas).</p>
                        <?php endif; ?>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=access_recirc" class="btn-secondary">História recirkulácie</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_recirculation.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $pct    = (float) ($result['recirc_pct'] ?? 0);
                    $label  = (string) ($result['recirc_label'] ?? '');
                    echo htmlspecialchars(number_format($pct, 1, ',', ' ')) . ' %';
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
