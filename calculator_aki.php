<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "s_cr_value" => (string) ($_POST["s_cr_value"] ?? ""),
    "s_cr_unit" => (string) ($_POST["s_cr_unit"] ?? "umol_l"),
    "u_cr_value" => (string) ($_POST["u_cr_value"] ?? ""),
    "u_cr_unit" => (string) ($_POST["u_cr_unit"] ?? "mmol_l"),
    "s_na" => (string) ($_POST["s_na"] ?? ""),
    "u_na" => (string) ($_POST["u_na"] ?? ""),
    "s_urea" => (string) ($_POST["s_urea"] ?? ""),
    "u_urea" => (string) ($_POST["u_urea"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_aki');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $sCrValue = calculatorParsePositiveFloat($form["s_cr_value"]);
        $uCrValue = calculatorParsePositiveFloat($form["u_cr_value"]);

        if ($sCrValue === null) {
            $errors[] = "Zadajte platnú hodnotu sérového kreatinínu.";
        }
        if ($uCrValue === null) {
            $errors[] = "Zadajte platnú hodnotu kreatinínu v moči.";
        }

        $sCrUnit = in_array($form["s_cr_unit"], ["umol_l", "mg_dl"], true)
            ? $form["s_cr_unit"]
            : "";
        $uCrUnit = in_array($form["u_cr_unit"], ["mmol_l", "mg_dl"], true)
            ? $form["u_cr_unit"]
            : "";

        if ($sCrUnit === "") {
            $errors[] = "Vyberte jednotku sérového kreatinínu.";
        }
        if ($uCrUnit === "") {
            $errors[] = "Vyberte jednotku kreatinínu v moči.";
        }

        $sNa = calculatorParsePositiveFloat($form["s_na"]);
        $uNa = calculatorParsePositiveFloat($form["u_na"]);
        $sUrea = calculatorParsePositiveFloat($form["s_urea"]);
        $uUrea = calculatorParsePositiveFloat($form["u_urea"]);

        $canCalcNa = $sNa !== null && $uNa !== null;
        $canCalcUrea = $sUrea !== null && $uUrea !== null;

        if (!$canCalcNa && !$canCalcUrea) {
            $errors[] =
                "Pre výpočet musíte zadať hodnoty sodíka (S-Na a U-Na) alebo urey (S-Urea a U-Urea).";
        }

        if (empty($errors)) {
            $sCrUmol =
                $sCrUnit === "mg_dl"
                    ? (float) $sCrValue * 88.4
                    : (float) $sCrValue;
            $sCrMmol = $sCrUmol / 1000.0;
            $uCrMmol =
                $uCrUnit === "mg_dl"
                    ? (float) $uCrValue * 0.0884
                    : (float) $uCrValue;

            $fena = null;
            $fenaInterpretation = "";
            if ($canCalcNa) {
                $fena = (($uNa * $sCrMmol) / ($sNa * $uCrMmol)) * 100.0;
                if ($fena < 1.0) {
                    $fenaInterpretation = "Prerenálne zlyhanie (často < 1 %)";
                } elseif ($fena > 2.0) {
                    $fenaInterpretation =
                        "Akútna tubulárna nekróza - ATN (často > 2 %)";
                } else {
                    $fenaInterpretation =
                        "Hraničná hodnota (zmiešaná etiológia)";
                }
            }

            $feurea = null;
            $feureaInterpretation = "";
            if ($canCalcUrea) {
                $feurea = (($uUrea * $sCrMmol) / ($sUrea * $uCrMmol)) * 100.0;
                if ($feurea < 35.0) {
                    $feureaInterpretation =
                        "Prerenálne zlyhanie (často < 35 %)";
                } elseif ($feurea > 50.0) {
                    $feureaInterpretation =
                        "Akútna tubulárna nekróza - ATN (často > 50 %)";
                } else {
                    $feureaInterpretation =
                        "Hraničná hodnota (zmiešaná etiológia)";
                }
            }

            $calculated = [
                "fena" => $fena !== null ? round($fena, 2) : null,
                "fena_interpretation" => $fenaInterpretation,
                "feurea" => $feurea !== null ? round($feurea, 2) : null,
                "feurea_interpretation" => $feureaInterpretation,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "s_cr_value" => round((float) $sCrValue, 2),
                            "s_cr_unit" => $sCrUnit,
                            "u_cr_value" => round((float) $uCrValue, 2),
                            "u_cr_unit" => $uCrUnit,
                            "s_na" => $sNa,
                            "u_na" => $uNa,
                            "s_urea" => $sUrea,
                            "u_urea" => $uUrea,
                        ];

                        $resultPayload = $calculated;

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "aki_fena_feurea",
                                "FENa / FEUrea",
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
                        error_log(
                            "calculator_aki save error: " . $e->getMessage(),
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
            "aki_fena_feurea",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_aki fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "FENa a FEUrea (AKI) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_aki.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: FENa a FEUrea (AKI). FENa a FEUrea (Frakčná exkrécia). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Frakčná exkrécia sodíka a urey (FENa / FEUrea)",
                  "item" => $baseUrl . "calculator_aki.php",
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
    $headerTitle = "Kalkulačka AKI";
    $headerIntro = "FENa a FEUrea (Frakčná exkrécia)";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Frakčná exkrécia sodíka a urey (FENa / FEUrea)</h2>
                <p class="auth-subtitle">Diferenciálna diagnostika akútneho poškodenia obličiek (AKI).</p>

                <details open class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{FENa} = \frac{U_{\text{Na}} \times S_{\text{Cr}}}{S_{\text{Na}} \times U_{\text{Cr}}} \times 100\% \]</div>
                        <div class="calc-formula-line">\[ \text{FEUrea} = \frac{U_{\text{urea}} \times S_{\text{Cr}}}{S_{\text{urea}} \times U_{\text{Cr}}} \times 100\% \]</div>
                        <div class="calc-formula-vars">
                            $U_{\text{Na}}$ = močový sodík, $S_{\text{Na}}$ = sérový sodík, $U_{\text{Cr}}$ = močový kreatinín, $S_{\text{Cr}}$ = sérový kreatinín.<br>
                            $U_{\text{urea}}$ = močová urea, $S_{\text{urea}}$ = sérová urea.<br>
                            <strong>FENa:</strong> &lt; 1 % typicky svedčí pre prerenálne zlyhanie (hypoperfúzia), &gt; 2 % pre renálne zlyhanie (ATN). V prípade užívania diuretík je FENa nepresná (zvýšená exkrécia Na).<br>
                            <strong>FEUrea:</strong> Výhodná pri užívaní diuretík. &lt; 35 % svedčí pre prerenálne zlyhanie, &gt; 50 % pre ATN.
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars(
                        $message,
                    ) ?></p></div>
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

                <form method="POST" action="calculator_aki.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                                                        <div class="form-group">
                                <label for="s_cr_value">S-Kreatinín</label>
                                <input type="text" id="s_cr_value" name="s_cr_value" required class="form-control" value="<?= htmlspecialchars(
                                    $form["s_cr_value"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="s_cr_unit">Jednotka S-Kreatinínu</label>
                                <select id="s_cr_unit" name="s_cr_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form[
                                        "s_cr_unit"
                                    ] === "umol_l"
                                        ? "selected"
                                        : "" ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form[
                                        "s_cr_unit"
                                    ] === "mg_dl"
                                        ? "selected"
                                        : "" ?>>mg/dL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="u_cr_value">U-Kreatinín</label>
                                <input type="text" id="u_cr_value" name="u_cr_value" required class="form-control" value="<?= htmlspecialchars(
                                    $form["u_cr_value"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_cr_unit">Jednotka U-Kreatinínu</label>
                                <select id="u_cr_unit" name="u_cr_unit" class="form-control" required>
                                    <option value="mmol_l" <?= $form[
                                        "u_cr_unit"
                                    ] === "mmol_l"
                                        ? "selected"
                                        : "" ?>>mmol/L</option>
                                    <option value="mg_dl" <?= $form[
                                        "u_cr_unit"
                                    ] === "mg_dl"
                                        ? "selected"
                                        : "" ?>>mg/dL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre pre FENa (Sodík)</h3>
                        <p class="text-secondary-sm-mb12"Vyplňte pre výpočet FENa.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="s_na">S-Sodík (mmol/L)</label>
                                <input type="text" id="s_na" name="s_na" class="form-control" value="<?= htmlspecialchars(
                                    $form["s_na"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_na">U-Sodík (mmol/L)</label>
                                <input type="text" id="u_na" name="u_na" class="form-control" value="<?= htmlspecialchars(
                                    $form["u_na"],
                                ) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre pre FEUrea (Urea)</h3>
                        <p class="text-secondary-sm-mb12"Vyplňte pre výpočet FEUrea (vhodné pri diuretikách).</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="s_urea">S-Urea (mmol/L)</label>
                                <input type="text" id="s_urea" name="s_urea" class="form-control" value="<?= htmlspecialchars(
                                    $form["s_urea"],
                                ) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_urea">U-Urea (mmol/L)</label>
                                <input type="text" id="u_urea" name="u_urea" class="form-control" value="<?= htmlspecialchars(
                                    $form["u_urea"],
                                ) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu</h3>
                        <?php if ($calculated["fena"] !== null): ?>
                            <p><strong>FENa:</strong> <?= htmlspecialchars(
                                number_format(
                                    (float) $calculated["fena"],
                                    2,
                                    ",",
                                    " ",
                                ),
                            ) ?> %</p>
                            <p class="mb-16"><strong>Interpretácia FENa:</strong> <?= htmlspecialchars(
                                $calculated["fena_interpretation"],
                            ) ?></p>
                        <?php endif; ?>

                        <?php if ($calculated["feurea"] !== null): ?>
                            <p><strong>FEUrea:</strong> <?= htmlspecialchars(
                                number_format(
                                    (float) $calculated["feurea"],
                                    2,
                                    ",",
                                    " ",
                                ),
                            ) ?> %</p>
                            <p><strong>Interpretácia FEUrea:</strong> <?= htmlspecialchars(
                                $calculated["feurea_interpretation"],
                            ) ?></p>
                        <?php endif; ?>

                        <div class="form-actions no-print calc-result-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=aki_fenafeurea" class="btn-secondary">História AKI</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_aki.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $fena   = isset($result['fena'])   ? number_format((float) $result['fena'],   2, ',', ' ') . ' %' : '-';
                    $feurea = isset($result['feurea']) ? number_format((float) $result['feurea'], 2, ',', ' ') . ' %' : '-';
                    echo 'FENa: ' . $fena . '<br>FEUrea: ' . $feurea;                }
            ); ?>
        </div>
    </main>

    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
