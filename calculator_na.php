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
    "sex" => (string) ($_POST["sex"] ?? "female"),
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "s_na" => (string) ($_POST["s_na"] ?? ""),
    "target_na" => (string) ($_POST["target_na"] ?? "140"),
    "infusion_na" => (string) ($_POST["infusion_na"] ?? "154"), // 0.9% NaCl has 154 mmol/L
    "infusion_k" => (string) ($_POST["infusion_k"] ?? "0"),
    "s_glucose" => (string) ($_POST["s_glucose"] ?? ""),
    "glucose_unit" => (string) ($_POST["glucose_unit"] ?? "mmol_l"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_na');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        if ($form["age_years"] === "") {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form["age_years"] = (string) $derived;
            }
        }

        $sex = in_array($form["sex"], ["female", "male"], true)
            ? $form["sex"]
            : "";
        if ($sex === "") {
            $errors[] = "Vyberte pohlavie.";
        }

        $ageYears = filter_var($form["age_years"], FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 18, "max_range" => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = "Vek musí byť celé číslo v intervale 18 až 120 rokov.";
        }

        $weightKg = calculatorParsePositiveFloat($form["weight_kg"]);
        if ($weightKg === null) {
            $errors[] = "Hmotnosť musí byť kladné číslo.";
        }

        $sNa = calculatorParsePositiveFloat($form["s_na"]);
        if ($sNa === null) {
            $errors[] = "Zadajte platnú hladinu aktuálneho sérového sodíka.";
        }

        $targetNa = calculatorParsePositiveFloat($form["target_na"]);
        if ($targetNa === null) {
            $targetNa = 140.0;
        }

        $infNa = calculatorParsePositiveFloat($form["infusion_na"]);
        if ($infNa === null && $form["infusion_na"] === "0") {
            $infNa = 0.0;
        }

        $infK = calculatorParsePositiveFloat($form["infusion_k"]);
        if ($infK === null && $form["infusion_k"] === "0") {
            $infK = 0.0;
        }

        $sGlucose = null;
        if (trim($form["s_glucose"]) !== "") {
            $sGlucose = calculatorParsePositiveFloat($form["s_glucose"]);
            if ($sGlucose === null) {
                $errors[] = "Glykémia musí byť kladné číslo (mmol/L alebo mg/dL).";
            }
        }
        $glucoseUnit = in_array($form["glucose_unit"], ["mmol_l", "mg_dl"], true)
            ? $form["glucose_unit"]
            : "mmol_l";

        if (empty($errors)) {
            // Výpočet celkovej telesnej vody (TBW)
            $factor = 0.5;
            if ($sex === "male") {
                $factor = $ageYears >= 65 ? 0.5 : 0.6;
            } else {
                $factor = $ageYears >= 65 ? 0.45 : 0.5;
            }
            $tbw = $weightKg * $factor;

            // Deficit voľnej vody (iba ak hypernatrémia)
            $fwd = null;
            if ($sNa > $targetNa) {
                $fwd = $tbw * ($sNa / $targetNa - 1);
            }

            // Adrogué-Madias (Odhadovaná zmena Na po 1L infúzie)
            $changePerL = null;
            if ($infNa !== null && $infK !== null) {
                $changePerL = ($infNa + $infK - $sNa) / ($tbw + 1);
            }

            // Korekcia Na na hyperglykémiu (Katz 1973: 1,6 ; Hillier 1999: 2,4)
            $glucoseMgDl = null;
            $correctedNaKatz = null;
            $correctedNaHillier = null;
            if ($sGlucose !== null) {
                $glucoseMgDl = $glucoseUnit === "mmol_l"
                    ? (float) $sGlucose * 18.0182
                    : (float) $sGlucose;
                $correctedNaKatz = (float) $sNa + 1.6 * ($glucoseMgDl - 100.0) / 100.0;
                $correctedNaHillier = (float) $sNa + 2.4 * ($glucoseMgDl - 100.0) / 100.0;
            }

            // Bezpečná rýchlosť korekcie hyponatrémie (prevencia ODS) — strop za 24 h
            $safeNa24h = null;
            $safeNa24hHighRisk = null;
            if ((float) $sNa < 135.0) {
                $safeNa24h = (float) $sNa + 8.0;        // bežný limit ≤ 8 mmol/L/24 h
                $safeNa24hHighRisk = (float) $sNa + 6.0; // vysoké riziko ODS ≤ 6 mmol/L/24 h
            }

            $calculated = [
                "tbw" => round($tbw, 1),
                "fwd" => $fwd !== null ? round($fwd, 2) : null,
                "change_per_l" =>
                    $changePerL !== null ? round($changePerL, 2) : null,
                "s_na" => round($sNa, 1),
                "target_na" => round($targetNa, 1),
                "corrected_na_katz" =>
                    $correctedNaKatz !== null ? round($correctedNaKatz, 1) : null,
                "corrected_na_hillier" =>
                    $correctedNaHillier !== null ? round($correctedNaHillier, 1) : null,
                "glucose_mg_dl" =>
                    $glucoseMgDl !== null ? round($glucoseMgDl, 0) : null,
                "safe_na_24h" => $safeNa24h !== null ? round($safeNa24h, 1) : null,
                "safe_na_24h_high_risk" =>
                    $safeNa24hHighRisk !== null ? round($safeNa24hHighRisk, 1) : null,
            ];

            if ($action === "save") {
                if (!isLoggedIn()) {
                    $errors[] = "Pre uloženie výsledku sa najskôr prihláste.";
                } else {
                    try {
                        $inputPayload = [
                            "examination_date" => $form["examination_date"],
                            "sex" => $sex,
                            "age_years" => (int) $ageYears,
                            "weight_kg" => round($weightKg, 1),
                            "s_na" => round($sNa, 1),
                            "target_na" => round($targetNa, 1),
                            "infusion_na" => $infNa,
                            "infusion_k" => $infK,
                            "s_glucose" => $sGlucose,
                            "glucose_unit" => $glucoseUnit,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "na_water_disorders",
                                "Poruchy Na a vody",
                                $patient,
                                $inputPayload,
                                $calculated,
                            )
                        ) {
                            $messages[] = "Výsledok bol uložený do databázy.";
                        } else {
                            $errors[] = "Výsledok sa nepodarilo uložiť.";
                        }
                    } catch (\PDOException $e) {
                        $errors[] = "Databázová chyba pri ukladaní výsledku.";
                        error_log(
                            "calculator_na save error: " . $e->getMessage(),
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
            "na_water_disorders",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_na fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Poruchy sodíka a vody | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_na.php";
  $seoDescription =
      "Nefrologická kalkulačka: poruchy sodíka a vody — deficit voľnej vody, Adrogué-Madias, korekcia sodíka na hyperglykémiu (Katz/Hillier) a bezpečná rýchlosť korekcie hyponatrémie (prevencia ODS). Pre lekárov na Slovensku.";
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
                  "name" => "Poruchy sodíka a vody",
                  "item" => $baseUrl . "calculator_na.php",
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
    $headerTitle = "Kalkulačka Sodíka";
    $headerIntro = "Deficit voľnej vody a Adrogué-Madias";
    $showLogo = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Poruchy sodíka a vody</h2>
                <p class="auth-subtitle">Kalkulačka pre manažment hypernatrémie (deficit voľnej vody) a hyponatrémie (Adrogué-Madiasova rovnica).</p>

                <details open class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{TBW} = \text{Hmotnosť} \times (0.45 \text{ až } 0.6 \text{ podľa pohlavia a veku}) \]</div>
                        <div class="calc-formula-line">\[ \text{Deficit vody [L]} = \text{TBW} \times \left( \frac{\text{S-Na}}{\text{Cieľové Na}} - 1 \right) \]</div>
                        <div class="calc-formula-line">\[ \text{Adrogué-Madias} = \frac{\text{Infúzia Na} + \text{Infúzia K} - \text{S-Na}}{\text{TBW} + 1} \]</div>
                        <div class="calc-formula-line">\[ \text{Korigované Na} = \text{S-Na} + k \times \frac{\text{glykémia [mg/dL]} - 100}{100}, \quad k = 1{,}6\,(\text{Katz}) \text{ / } 2{,}4\,(\text{Hillier}) \]</div>
                        <div class="calc-formula-vars">
                            <strong>TBW:</strong> Celková telesná voda v litroch.<br>
                            <strong>Adrogué-Madias:</strong> Odhaduje, o koľko mmol/L sa zmení sérový sodík po podaní 1 litra konkrétneho infúzneho roztoku.<br>
                            <strong>Korekcia na glykémiu:</strong> hyperglykémia zrieďuje sérový sodík — korigované Na odhaduje skutočnú nátriémiu (Katz 1973 / Hillier 1999).<br>
                            <strong>Upozornenie (ODS):</strong> pri hyponatrémii nemá rýchlosť korekcie presiahnuť <strong>≤ 8 mmol/L za 24 h</strong> (pri vysokom riziku ≤ 6), inak hrozí osmotický demyelinizačný syndróm.
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

                <form method="POST" action="calculator_na.php">
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
                                                        <div class="form-group"><label for="sex">Pohlavie</label><select id="sex" name="sex" class="form-control" required><option value="female" <?= $form[
                                "sex"
                            ] === "female"
                                ? "selected"
                                : "" ?>>Žena</option><option value="male" <?= $form[
    "sex"
] === "male"
    ? "selected"
    : "" ?>>Muž</option></select></div>
                            <div class="form-group"><label for="age_years">Vek</label><input type="number" id="age_years" name="age_years" required class="form-control" value="<?= htmlspecialchars(
                                $form["age_years"],
                            ) ?>"></div>
                            <div class="form-group"><label for="weight_kg">Hmotnosť (kg)</label><input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars(
                                $form["weight_kg"],
                            ) ?>"></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Sérový sodík a korekcia</h3>
                        <div class="form-grid">
                            <div class="form-group"><label for="s_na">Aktuálny S-Na (mmol/L)</label><input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars(
                                $form["s_na"],
                            ) ?>"></div>
                            <div class="form-group"><label for="target_na">Cieľový S-Na (mmol/L) [Pre hypernatrémiu]</label><input type="text" id="target_na" name="target_na" required class="form-control" value="<?= htmlspecialchars(
                                $form["target_na"],
                            ) ?>"></div>
                            <div class="form-group"><label for="s_glucose">Glykémia <span class="optional">— korekcia Na na hyperglykémiu</span></label><input type="text" id="s_glucose" name="s_glucose" class="form-control" value="<?= htmlspecialchars(
                                $form["s_glucose"],
                            ) ?>" placeholder="voliteľné"></div>
                            <div class="form-group"><label for="glucose_unit">Jednotka glykémie</label><select id="glucose_unit" name="glucose_unit" class="form-control"><option value="mmol_l" <?= $form["glucose_unit"] === "mmol_l" ? "selected" : "" ?>>mmol/L</option><option value="mg_dl" <?= $form["glucose_unit"] === "mg_dl" ? "selected" : "" ?>>mg/dL</option></select></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre infúzie (Pre Adrogué-Madias)</h3>
                        <div class="form-grid">
                            <div class="form-group"><label for="infusion_na">Sodík v infúzii (mmol/L)</label><input type="text" id="infusion_na" name="infusion_na" class="form-control" value="<?= htmlspecialchars(
                                $form["infusion_na"],
                            ) ?>" placeholder="Napr. 154 pre 0.9% NaCl"></div>
                            <div class="form-group"><label for="infusion_k">Draslík v infúzii (mmol/L)</label><input type="text" id="infusion_k" name="infusion_k" class="form-control" value="<?= htmlspecialchars(
                                $form["infusion_k"],
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
                        <p><strong>Celková telesná voda (TBW):</strong> <?= htmlspecialchars(
                            number_format(
                                (float) $calculated["tbw"],
                                1,
                                ",",
                                " ",
                            ),
                        ) ?> L</p>
                        <?php if (
                            $calculated["fwd"] !== null &&
                            $calculated["fwd"] > 0
                        ): ?>
                            <p class="text-accent-bold-mt8">Deficit voľnej vody: <?= htmlspecialchars(
                                number_format(
                                    (float) $calculated["fwd"],
                                    2,
                                    ",",
                                    " ",
                                ),
                            ) ?> L (na zníženie Na z <?= $calculated[
     "s_na"
 ] ?> na <?= $calculated["target_na"] ?> mmol/L)</p>
                        <?php endif; ?>
                        <?php if ($calculated["change_per_l"] !== null): ?>
                            <p class="calc-result-mt8"><strong>Odhad. zmena S-Na po 1L infúzie:</strong> <?= htmlspecialchars(
                                number_format(
                                    (float) $calculated["change_per_l"],
                                    2,
                                    ",",
                                    " ",
                                ),
                            ) ?> mmol/L</p>
                            <p class="calc-note-opacity">Ak je hodnota kladná, S-Na stúpne. Ak je záporná, S-Na klesne.</p>
                        <?php endif; ?>
                        <?php if ($calculated["corrected_na_katz"] !== null): ?>
                            <p class="calc-result-mt8"><strong>Korigovaný S-Na na hyperglykémiu</strong>
                                (glykémia <?= htmlspecialchars(number_format((float) $calculated["glucose_mg_dl"], 0, ",", " ")) ?> mg/dL):
                                Katz <strong><?= htmlspecialchars(number_format((float) $calculated["corrected_na_katz"], 1, ",", " ")) ?></strong> mmol/L
                                &bull; Hillier <strong><?= htmlspecialchars(number_format((float) $calculated["corrected_na_hillier"], 1, ",", " ")) ?></strong> mmol/L</p>
                            <p class="calc-note-opacity">Hillier (faktor 2,4) býva presnejší pri výraznej hyperglykémii; Katz (1,6) je klasická korekcia.</p>
                        <?php endif; ?>
                        <?php if ($calculated["safe_na_24h"] !== null): ?>
                            <div class="info-box-green calc-result-mt8">
                                <strong>Bezpečná korekcia hyponatrémie (prevencia ODS):</strong>
                                S-Na by za 24 h nemal presiahnuť <strong>≈ <?= htmlspecialchars(number_format((float) $calculated["safe_na_24h"], 1, ",", " ")) ?> mmol/L</strong>
                                (limit ≤ 8 mmol/L/24 h). Pri vysokom riziku ODS (S-Na &lt; 105, hypokaliémia, malnutrícia,
                                alkoholizmus, pokročilé ochorenie pečene) len <strong>≈ <?= htmlspecialchars(number_format((float) $calculated["safe_na_24h_high_risk"], 1, ",", " ")) ?> mmol/L</strong>
                                (≤ 6 mmol/L/24 h).
                            </div>
                        <?php endif; ?>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=sodium_disorders" class="btn-secondary">História Sodík</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <section class="auth-container auth-container--wide calc-saved-results">
                <h3>Uložené výsledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie výsledkov sa prihláste.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Žiadne uložené výsledky.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead><tr><th scope="col">Vyšetrenie</th><th scope="col">Výsledok</th><th scope="col">Akcie</th></tr></thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <tr>
                                        <td>
                                            <?php $_examD = (string) ($row["input_payload"]["examination_date"] ?? ""); ?>
                                            <?= $_examD ? htmlspecialchars(formatUserDate($_examD, "d.m.Y")) : '—' ?>
                                            <small class="d-block saved-meta">ulo.: <?= htmlspecialchars(formatUserDateTime((string) ($row["created_at"] ?? ""), "d.m.Y H:i")) ?></small>
                                        </td>
                                        <td>
                                            TBW: <?= number_format(
                                                $row["result_payload"]["tbw"] ??
                                                    0,
                                                1,
                                            ) ?> L<br>
                                            <?php if (
                                                isset(
                                                    $row["result_payload"][
                                                        "fwd"
                                                    ],
                                                )
                                            ): ?>
                                                FWD: <?= number_format(
                                                    $row["result_payload"][
                                                        "fwd"
                                                    ],
                                                    2,
                                                ) ?> L
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row[
                                                "id"
                                            ] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row[
                                                "id"
                                            ] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_na.php" class="d-inline" data-confirm="Naozaj vymazať záznam?">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                                                    generateCsrfToken(),
                                                ) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row[
                                                    "id"
                                                ] ?>">
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
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
