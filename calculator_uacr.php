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
    "u_alb" => (string) ($_POST["u_alb"] ?? ""),
    "u_alb_unit" => (string) ($_POST["u_alb_unit"] ?? "mg_l"),
    "u_cr" => (string) ($_POST["u_cr"] ?? ""),
    "u_cr_unit" => (string) ($_POST["u_cr_unit"] ?? "mmol_l"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_uacr');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $ualb = calculatorParsePositiveFloat($form["u_alb"]);
        $ucr = calculatorParsePositiveFloat($form["u_cr"]);

        if ($ualb === null || $ucr === null) {
            $errors[] = "Zadajte platné kladné čísla pre albumín aj kreatinín.";
        } else {
            $alb_mg_l = $ualb;
            if ($form["u_alb_unit"] === "mg_dl") {
                $alb_mg_l = $ualb * 10;
            } elseif ($form["u_alb_unit"] === "g_l") {
                $alb_mg_l = $ualb * 1000;
            }

            $cr_mmol_l = $ucr;
            if ($form["u_cr_unit"] === "mg_dl") {
                $cr_mmol_l = $ucr * 0.0884;
            }
            $cr_g_l = ($cr_mmol_l * 113.12) / 1000;

            if ($cr_mmol_l > 0 && $cr_g_l > 0) {
                $uacr_mg_mmol = $alb_mg_l / $cr_mmol_l;
                $uacr_mg_g = $alb_mg_l / $cr_g_l;

                $stage = "";
                $desc = "";
                if ($uacr_mg_mmol < 3) {
                    $stage = "A1";
                    $desc = "Normálna až mierne zvýšená albuminúria";
                } elseif ($uacr_mg_mmol <= 30) {
                    $stage = "A2";
                    $desc = "Stredne zvýšená albuminúria (mikroalbuminúria)";
                } else {
                    $stage = "A3";
                    $desc = "Výrazne zvýšená albuminúria (makroalbuminúria)";
                }

                $calculated = [
                    "mg_mmol" => round($uacr_mg_mmol, 2),
                    "mg_g" => round($uacr_mg_g, 2),
                    "stage" => $stage,
                    "desc" => $desc,
                ];

                if ($action === "save") {
                    if (!isLoggedIn()) {
                        $errors[] = "Pre uloženie sa prihláste.";
                    } else {
                        $inPayload = [
                            "examination_date" => $form["examination_date"],
                            "u_alb" => $ualb,
                            "u_alb_unit" => $form["u_alb_unit"],
                            "u_cr" => $ucr,
                            "u_cr_unit" => $form["u_cr_unit"],
                        ];
                        calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION["user_id"],
                            "uacr_kdigo",
                            "UACR klasifikácia",
                            $patient,
                            $inPayload,
                            $calculated,
                        );
                        $messages[] = "Výsledok uložený.";
                    }
                }
            } else {
                $errors[] = "Kreatinín musí byť väčší ako 0.";
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults(
        $pdo,
        (int) $_SESSION["user_id"],
        "uacr_kdigo",
        25,
    );
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle =
      "UACR a KDIGO klasifikácia | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_uacr.php";
  $seoDescription =
      "Nefrologická kalkulačka a nástroj: UACR a KDIGO klasifikácia. Hodnotenie albuminúrie (KDIGO). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.";
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
                  "name" =>
                      "UACR (Urine Albumin-to-Creatinine Ratio) a KDIGO A-štádium",
                  "item" => $baseUrl . "calculator_uacr.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <?php
    $headerTitle = "UACR (Albumín/Kreatinín)";
    $headerIntro = "Hodnotenie albuminúrie (KDIGO)";
    $showLogo = false;
    include "header.php";
    ?>
    <?php include 'main_nav.php'; ?>
    <main class="container main-content main-content--single-col">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>UACR (Urine Albumin-to-Creatinine Ratio) a KDIGO A-štádium</h2>

                <details open class="calc-formula-box">
                    <summary>Vzorce — UACR a KDIGO A-štádium</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{UACR} = \frac{\text{Alb}_{\text{moč}}}{\text{Cr}_{\text{moč}}} \]</div>
                        <div class="calc-formula-line">\[ \text{UACR [mg/g]} = \text{UACR [mg/mmol]} \times 8.84 \]</div>
                        <div class="calc-formula-vars">
                            A1: UACR $\lt 30$ mg/g &bull; A2: $30$–$300$ mg/g &bull; A3: $\gt 300$ mg/g
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
                                                        <div class="form-group"><label>U-Albumín</label><input type="text" name="u_alb" class="form-control" value="<?= htmlspecialchars(
                                $form["u_alb"],
                            ) ?>" required></div>
                            <div class="form-group">
                                <label>Jednotka Albumínu</label>
                                <select name="u_alb_unit" class="form-control">
                                    <option value="mg_l" <?= $form[
                                        "u_alb_unit"
                                    ] === "mg_l"
                                        ? "selected"
                                        : "" ?>>mg/L</option>
                                    <option value="mg_dl" <?= $form[
                                        "u_alb_unit"
                                    ] === "mg_dl"
                                        ? "selected"
                                        : "" ?>>mg/dL</option>
                                    <option value="g_l" <?= $form[
                                        "u_alb_unit"
                                    ] === "g_l"
                                        ? "selected"
                                        : "" ?>>g/L</option>
                                </select>
                            </div>
                            <div class="form-group"><label>U-Kreatinín</label><input type="text" name="u_cr" class="form-control" value="<?= htmlspecialchars(
                                $form["u_cr"],
                            ) ?>" required></div>
                            <div class="form-group">
                                <label>Jednotka Kreatinínu</label>
                                <select name="u_cr_unit" class="form-control">
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
                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block" role="status" aria-live="polite">
                        <h3>Výsledok KDIGO</h3>
                        <p><strong>UACR:</strong> <?= htmlspecialchars(
                            $calculated["mg_mmol"],
                        ) ?> mg/mmol (<?= htmlspecialchars(
     $calculated["mg_g"],
 ) ?> mg/g)</p>
                        <p class="text-accent-bold-lg">KDIGO Štádium: <?= htmlspecialchars(
                            $calculated["stage"],
                        ) ?></p>
                        <p><?= htmlspecialchars($calculated["desc"]) ?></p>
                        <div class="form-actions no-print calc-formula-mt24">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=uacr" class="btn-secondary">História UACR</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_uacr.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    echo number_format((float) ($result['mg_mmol'] ?? 0), 2) . ' mg/mmol<br>';
                    echo 'Štádium: ' . htmlspecialchars((string) ($result['stage'] ?? ''));                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime("patient_autofill.js") ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
