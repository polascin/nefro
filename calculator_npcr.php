<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/** Watson odhad celkovej telesnej vody (TBW, L). */
function npcrWatsonTbw(string $sex, int $age, float $heightCm, float $weightKg): float
{
    if ($sex === "male") {
        return 2.447 - 0.09516 * $age + 0.1074 * $heightCm + 0.3362 * $weightKg;
    }
    // female
    return -2.097 + 0.1069 * $heightCm + 0.2466 * $weightKg;
}

/** Prepočet močoviny/BUN na BUN (urea-nitrogen) v mg/dL. */
function npcrToBunMgDl(float $value, string $unit): float
{
    // urea mmol/L → BUN mg/dL: × 2,8 ; bun_mg_dl je už BUN mg/dL
    return $unit === "mmol_l" ? $value * 2.8 : $value;
}

/**
 * Riziková kategória pre nPCR/nPNA (g/kg/deň).
 * @return array{0:string,1:string} [trieda, popis]
 */
function npcrCategory(float $npcr): array
{
    if ($npcr < 0.8) {
        return ['risk-high', 'Nízky príjem bielkovín — riziko malnutrície'];
    }
    if ($npcr < 1.0) {
        return ['risk-moderate', 'Hraničný príjem'];
    }
    if ($npcr <= 1.4) {
        return ['risk-low', 'Cieľové rozpätie (1,0 – 1,4)'];
    }

    return ['risk-moderate', 'Vysoký — hyperkatabolizmus alebo vysoký príjem'];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    "sex" => (string) ($_POST["sex"] ?? "male"),
    "age_years" => (string) ($_POST["age_years"] ?? ""),
    "height_cm" => (string) ($_POST["height_cm"] ?? ""),
    "weight_kg" => (string) ($_POST["weight_kg"] ?? ""),
    "urea_unit" => (string) ($_POST["urea_unit"] ?? "mmol_l"),
    "urea_pre" => (string) ($_POST["urea_pre"] ?? ""),
    "urea_post" => (string) ($_POST["urea_post"] ?? ""),
    "interdialytic_hours" => (string) ($_POST["interdialytic_hours"] ?? "44"),
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
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_npcr');
    } elseif ($action === "calculate" || $action === "save") {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form["examination_date"], $errors);
        if ($form["age_years"] === "") {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form["age_years"] = (string) $derived;
            }
        }

        $sex = in_array($form["sex"], ["female", "male"], true) ? $form["sex"] : "";
        if ($sex === "") {
            $errors[] = "Vyberte pohlavie.";
        }

        $ageYears = filter_var($form["age_years"], FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 18, "max_range" => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = "Vek musí byť celé číslo v intervale 18 až 120 rokov.";
        }

        $heightCm = calculatorParsePositiveFloat($form["height_cm"]);
        if ($heightCm === null || $heightCm < 100.0 || $heightCm > 230.0) {
            $errors[] = "Výška musí byť v rozsahu 100 – 230 cm.";
        }

        $weightKg = calculatorParsePositiveFloat($form["weight_kg"]);
        if ($weightKg === null || $weightKg < 20.0 || $weightKg > 300.0) {
            $errors[] = "Hmotnosť (suchá) musí byť v rozsahu 20 – 300 kg.";
        }

        $ureaUnit = in_array($form["urea_unit"], ["mmol_l", "bun_mg_dl"], true)
            ? $form["urea_unit"]
            : "";
        if ($ureaUnit === "") {
            $errors[] = "Vyberte jednotku močoviny.";
        }

        $ureaPre = calculatorParsePositiveFloat($form["urea_pre"]);
        if ($ureaPre === null) {
            $errors[] = "Močovina pred dialýzou musí byť kladné číslo.";
        }
        $ureaPost = calculatorParsePositiveFloat($form["urea_post"]);
        if ($ureaPost === null) {
            $errors[] = "Močovina po predošlej dialýze musí byť kladné číslo.";
        }
        if ($ureaPre !== null && $ureaPost !== null && $ureaPre <= $ureaPost) {
            $errors[] = "Predialyzačná močovina musí byť vyššia než postdialyzačná (urea medzi dialýzami stúpa).";
        }

        $hours = calculatorParsePositiveFloat($form["interdialytic_hours"]);
        if ($hours === null || $hours < 12.0 || $hours > 96.0) {
            $errors[] = "Interdialytický interval musí byť v rozsahu 12 – 96 hodín.";
        }

        if (empty($errors)) {
            $bunPre = npcrToBunMgDl((float) $ureaPre, $ureaUnit);
            $bunPost = npcrToBunMgDl((float) $ureaPost, $ureaUnit);
            $tbw = npcrWatsonTbw($sex, (int) $ageYears, (float) $heightCm, (float) $weightKg);
            $thetaMin = (float) $hours * 60.0;

            // Urea-nitrogen generation rate (mg/min): rozdiel koncentrácií × objem (dL) / čas
            $gMgMin = (($bunPre - $bunPost) * ($tbw * 10.0)) / $thetaMin;
            // Sargent–Gotch PNA/PCR (g/deň), anurický pacient
            $pcr = 9.35 * $gMgMin + 0.294 * $tbw;
            // Normalizácia na V/0,58 (modelová „normalizovaná" hmotnosť)
            $npcr = 0.58 * $pcr / $tbw;

            $npcrRounded = round($npcr, 2);
            [$riskCls, $riskLabel] = npcrCategory($npcrRounded);

            $calculated = [
                "npcr" => $npcrRounded,
                "pcr" => round($pcr, 1),
                "tbw" => round($tbw, 1),
                "g_mg_min" => round($gMgMin, 2),
                "risk_class" => $riskCls,
                "risk_label" => $riskLabel,
                "bun_pre" => round($bunPre, 1),
                "bun_post" => round($bunPost, 1),
                "hours" => round((float) $hours, 1),
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
                            "height_cm" => round((float) $heightCm, 1),
                            "weight_kg" => round((float) $weightKg, 1),
                            "urea_unit" => $ureaUnit,
                            "urea_pre" => round((float) $ureaPre, 2),
                            "urea_post" => round((float) $ureaPost, 2),
                            "interdialytic_hours" => round((float) $hours, 1),
                        ];
                        $resultPayload = [
                            "npcr" => $npcrRounded,
                            "pcr" => round($pcr, 1),
                            "tbw" => round($tbw, 1),
                            "risk_label" => $riskLabel,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION["user_id"],
                                "npcr_pna",
                                "nPCR / nPNA (katabolizmus bielkovín pri dialýze)",
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
                        error_log("calculator_npcr save error: " . $e->getMessage());
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
            "npcr_pna",
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = "Nepodarilo sa načítať uložené výsledky.";
        error_log("calculator_npcr fetch history error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "nPCR / nPNA — katabolizmus bielkovín pri dialýze | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_npcr.php";
  $seoDescription =
      "Nefrologická kalkulačka nPCR / nPNA (normalizovaná miera katabolizmu bielkovín) z dvoch hodnôt močoviny a Watsonovho objemu — nutričný ukazovateľ pri hemodialýze. Pre lekárov na Slovensku.";
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
                  "name" => "nPCR / nPNA",
                  "item" => $baseUrl . "calculator_npcr.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
  <meta name="calculator-key" content="npcr_pna">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "nPCR / nPNA";
    $headerIntro = "Katabolizmus bielkovín pri dialýze";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>nPCR / nPNA (katabolizmus bielkovín)</h2>
                <p class="auth-subtitle">Nutričný ukazovateľ pri hemodialýze — dopĺňa Kt/V. Z dvoch hodnôt močoviny.</p>

                <div class="info-box">
                    <strong>Kedy použiť:</strong> normalizovaná miera katabolizmu bielkovín
                    (nPCR ≈ nPNA) odhaduje denný príjem/obrat bielkovín u stabilného dialyzovaného
                    pacienta a dopĺňa adekvátnosť dialýzy (Kt/V). Cieľ KDOQI je spravidla
                    <strong>≥ 1,0 – 1,2 g/kg/deň</strong>; nízke hodnoty signalizujú riziko
                    proteínovo-energetickej malnutrície.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — interdialytická urea-kinetika (Sargent–Gotch)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ G = \frac{(C_{pred} - C_{post}) \times V \times 10}{\theta} \quad [\text{mg/min}] \]</div>
                        <div class="calc-formula-line">\[ \text{PCR} = 9{,}35 \, G + 0{,}294 \, V, \qquad \text{nPCR} = \frac{0{,}58 \times \text{PCR}}{V} \]</div>
                        <div class="calc-formula-line">\[ V_{Watson} = \begin{cases} 2{,}447 - 0{,}09516\,\text{vek} + 0{,}1074\,v + 0{,}3362\,h & \text{muž} \\ -2{,}097 + 0{,}1069\,v + 0{,}2466\,h & \text{žena} \end{cases} \]</div>
                        <div class="calc-formula-vars">
                            $C_{pred}, C_{post} = \text{urea-N (BUN) pred a po, mg/dL}$ &bull;
                            $V = \text{TBW [L]}$ &bull; $\theta = \text{interval [min]}$ &bull;
                            $v = \text{výška [cm]}$ &bull; $h = \text{suchá hmotnosť [kg]}$
                        </div>
                        <p class="calc-result-detail mb-0">Predpoklad: stabilný anurický pacient (bez reziduálnej renálnej funkcie), zjednodušená urea-kinetika.</p>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Súvisiace:</strong>
                    <a href="calculator_ktv.php">Kt/V a URR</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/3886/protein-catabolic-rate-pcr" target="_blank" rel="noopener noreferrer">MDCalc — PCR</a>
                </div>

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

                <form method="POST" action="calculator_npcr.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        generateCsrfToken(),
                    ) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="male" <?= $form["sex"] === "male" ? "selected" : "" ?>>Muž</option>
                                    <option value="female" <?= $form["sex"] === "female" ? "selected" : "" ?>>Žena</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars($form["age_years"]) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="height_cm">Výška (cm)</label>
                                <input type="text" id="height_cm" name="height_cm" required class="form-control" value="<?= htmlspecialchars($form["height_cm"]) ?>" placeholder="napr. 175">
                            </div>
                            <div class="form-group">
                                <label for="weight_kg">Suchá hmotnosť (kg)</label>
                                <input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars($form["weight_kg"]) ?>" placeholder="napr. 75">
                            </div>
                            <div class="form-group">
                                <label for="urea_unit">Jednotka močoviny</label>
                                <select id="urea_unit" name="urea_unit" class="form-control" required>
                                    <option value="mmol_l" <?= $form["urea_unit"] === "mmol_l" ? "selected" : "" ?>>mmol/L (urea)</option>
                                    <option value="bun_mg_dl" <?= $form["urea_unit"] === "bun_mg_dl" ? "selected" : "" ?>>mg/dL (BUN)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="urea_pre">Močovina pred dialýzou</label>
                                <input type="text" id="urea_pre" name="urea_pre" required class="form-control" value="<?= htmlspecialchars($form["urea_pre"]) ?>" placeholder="napr. 21">
                            </div>
                            <div class="form-group">
                                <label for="urea_post">Močovina po predošlej dialýze</label>
                                <input type="text" id="urea_post" name="urea_post" required class="form-control" value="<?= htmlspecialchars($form["urea_post"]) ?>" placeholder="napr. 8">
                            </div>
                            <div class="form-group">
                                <label for="interdialytic_hours">Interdialytický interval (h)</label>
                                <input type="text" id="interdialytic_hours" name="interdialytic_hours" required class="form-control" value="<?= htmlspecialchars($form["interdialytic_hours"]) ?>" placeholder="44 (2-dňový) / 68 (víkend)">
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
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float)$calculated["npcr"], 2, ",", " ")) ?></span>
                                <span class="calc-result-unit">g/kg/deň (nPCR)</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars((string) $calculated["risk_label"]) ?>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float)$calculated['npcr'] ?>"
                             data-risk-max="2"
                             data-risk-label="nPCR"></div>
                        <p class="calc-result-detail"><strong>PCR (celkový):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["pcr"], 1, ",", " ")) ?> g/deň
                            &ensp;&bull;&ensp;<strong>TBW (Watson):</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["tbw"], 1, ",", " ")) ?> L
                            &ensp;&bull;&ensp;<strong>G:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["g_mg_min"], 2, ",", " ")) ?> mg/min
                        </p>
                        <p class="calc-result-detail"><strong>BUN pred/po:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["bun_pre"], 1, ",", " ")) ?> /
                            <?= htmlspecialchars(number_format((float)$calculated["bun_post"], 1, ",", " ")) ?> mg/dL
                            &ensp;&bull;&ensp;<strong>interval:</strong>
                            <?= htmlspecialchars(number_format((float)$calculated["hours"], 1, ",", " ")) ?> h
                        </p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=npcr_pna" class="btn-secondary">História nPCR</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_npcr.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $npcr   = (float) ($result['npcr'] ?? 0);
                    $label  = (string) ($result['risk_label'] ?? '');
                    echo htmlspecialchars(number_format($npcr, 2, ',', ' ')) . ' g/kg/deň';
                    if ($label !== '') {
                        echo ' (' . htmlspecialchars($label) . ')';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime(
        "patient_autofill.js",
    ) ?>" defer></script>
    <?php include "footer.php"; ?>
</body>
</html>
