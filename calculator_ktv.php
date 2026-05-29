<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "u_pre" => (string) ($_POST["u_pre"] ?? ""),
    "u_post" => (string) ($_POST["u_post"] ?? ""),
    "weight_post" => (string) ($_POST["weight_post"] ?? ""),
    "time_hours" => (string) ($_POST["time_hours"] ?? ""),
    "uf_volume" => (string) ($_POST["uf_volume"] ?? ""),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_ktv');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $upre = calculatorParsePositiveFloat($form["u_pre"]);
        $upost = calculatorParsePositiveFloat($form["u_post"]);
        $w = calculatorParsePositiveFloat($form["weight_post"]);
        $t = calculatorParsePositiveFloat($form["time_hours"]);
        $uf = calculatorParsePositiveFloat($form["uf_volume"]);

        if (!$upre || !$upost || !$w || !$t || $uf === null) {
            $errors[] = "Vyplňte všetky hodnoty platnými číslami.";
        } else {
            $r = $upost / $upre;
            $urr = (1 - $r) * 100;

            $logTerm = $r - 0.008 * $t;
            if ($logTerm <= 0) {
                $errors[] =
                    "Zadané hodnoty neumožňujú výpočet logaritmu v Daugirdasovej rovnici (extrémne nízke U_post alebo dlhý čas).";
            } else {
                $ktv = -log($logTerm) + (4 - 3.5 * $r) * ($uf / $w);

                $calculated = [
                    "urr" => round($urr, 1),
                    "ktv" => round($ktv, 2),
                    "interpretation" =>
                        $ktv >= 1.2 && $urr >= 65
                            ? "Adekvátna dialýza podľa štandardov (Kt/V ≥ 1.2, URR ≥ 65%)."
                            : "Suboptimálna dialyzačná dávka. Zvážte predĺženie času alebo zvýšenie prietoku krvi/dialyzátu.",
                ];

                if ($action === "save") {
                    if (!isLoggedIn()) {
                        $errors[] = "Pre uloženie sa prihláste.";
                    } else {
                        $inPayload = [
                            "examination_date" => $form["examination_date"],
                            "u_pre" => $upre,
                            "u_post" => $upost,
                            "weight_post" => $w,
                            "time_hours" => $t,
                            "uf_volume" => $uf,
                        ];
                        calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION["user_id"],
                            "hd_ktv",
                            "Kt/V a URR",
                            $patient,
                            $inPayload,
                            $calculated,
                        );
                        $messages[] = "Výsledok uložený.";
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults(
        $pdo,
        (int) $_SESSION["user_id"],
        "hd_ktv",
        25,
    );
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "Hodnotenie hemodialýzy Kt/V a URR | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_ktv.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: Hodnotenie hemodialýzy Kt/V a URR. Hodnotenie adekvátnosti HD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" => "Kt/V (Daugirdas II) a Urea Reduction Ratio (URR)",
                  "item" => $baseUrl . "calculator_ktv.php",
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
    $headerTitle = "Kt/V a URR";
    $headerIntro = "Hodnotenie adekvátnosti HD";
    $showLogo = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>
    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Kt/V (Daugirdas II) a Urea Reduction Ratio (URR)</h2>

                <details open class="calc-formula-box">
                    <summary>Vzorce — Kt/V (Daugirdas II) a URR</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{URR} = \left(1 - \frac{U_{\text{post}}}{U_{\text{pre}}}\right) \times 100\% \]</div>
                        <div class="calc-formula-line">\[ \begin{aligned} r &= \frac{U_{\text{post}}}{U_{\text{pre}}} \\ \text{Kt/V} &= -\ln(r - 0.008 \cdot t) + (4 - 3.5r) \cdot \frac{UF}{W} \end{aligned} \]</div>
                        <div class="calc-formula-vars">
                            $U_{\text{pre/post}}$ = močová urea pred/po dialýze &bull;
                            $t$ = čas dialýzy (h) &bull;
                            $UF$ = ultrafiltrát (L) &bull;
                            $W$ = postdialyzačná hmotnosť (kg)
                        </div>
                    </div>
                </details>

                <?php foreach (
                    $messages
                    as $m
                ): ?><div class="alert alert-success"><?= htmlspecialchars(
    $m,
) ?></div><?php endforeach; ?>
                <?php if (
                    !empty($errors)
                ): ?><div class="alert alert-error"><ul><?php foreach (
    $errors
    as $e
): ?><li><?= htmlspecialchars(
    $e,
) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

                <form method="POST">
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
                                                        <div class="form-group"><label>S-Urea PRED dialýzou (mmol/L)</label><input type="text" name="u_pre" class="form-control" value="<?= htmlspecialchars(
                                $form["u_pre"],
                            ) ?>" required></div>
                            <div class="form-group"><label>S-Urea PO dialýze (mmol/L)</label><input type="text" name="u_post" class="form-control" value="<?= htmlspecialchars(
                                $form["u_post"],
                            ) ?>" required></div>
                            <div class="form-group"><label>Trvanie dialýzy (hodiny)</label><input type="text" name="time_hours" class="form-control" value="<?= htmlspecialchars(
                                $form["time_hours"],
                            ) ?>" required></div>
                            <div class="form-group"><label>Hmotnosť PO dialýze (kg)</label><input type="text" name="weight_post" class="form-control" value="<?= htmlspecialchars(
                                $form["weight_post"],
                            ) ?>" required></div>
                            <div class="form-group"><label>Ultrafiltrácia (L alebo kg)</label><input type="text" name="uf_volume" class="form-control" value="<?= htmlspecialchars(
                                $form["uf_volume"],
                            ) ?>" required></div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok</h3>
                        <p><strong>Kt/V (Daugirdas II):</strong> <?= htmlspecialchars(
                            $calculated["ktv"],
                        ) ?></p>
                        <p><strong>URR (Urea Reduction Ratio):</strong> <?= htmlspecialchars(
                            $calculated["urr"],
                        ) ?> %</p>
                        <p class="calc-accent-text">Interpretácia: <?= htmlspecialchars(
                            $calculated["interpretation"],
                        ) ?></p>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=ktv_urr" class="btn-secondary">História Kt/V</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_ktv.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo 'Kt/V: ' . number_format((float) ($result['ktv'] ?? 0), 2) . '<br>';
                    echo 'URR: '  . number_format((float) ($result['urr'] ?? 0), 1)  . ' %';                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
