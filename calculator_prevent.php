<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';
require_once __DIR__ . '/prevent_model.php';

const PREVENT_CALC_KEY   = 'prevent_aha_2024';
const PREVENT_CALC_LABEL = 'PREVENT — AHA 2024 (KV riziko)';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'examination_date' => (string) ($_POST['examination_date'] ?? date('Y-m-d')),
    'age_years'        => (string) ($_POST['age_years'] ?? ''),
    'sex'              => (string) ($_POST['sex'] ?? 'female'),
    'total_c'          => (string) ($_POST['total_c'] ?? ''),
    'hdl_c'            => (string) ($_POST['hdl_c'] ?? ''),
    'chol_unit'        => (string) ($_POST['chol_unit'] ?? 'mmol'),
    'sbp'              => (string) ($_POST['sbp'] ?? ''),
    'bp_tx'            => (string) ($_POST['bp_tx'] ?? '0'),
    'statin'           => (string) ($_POST['statin'] ?? '0'),
    'dm'               => (string) ($_POST['dm'] ?? '0'),
    'smoking'          => (string) ($_POST['smoking'] ?? '0'),
    'bmi'              => (string) ($_POST['bmi'] ?? ''),
    'egfr'             => (string) ($_POST['egfr'] ?? ''),
    'uacr_value'       => (string) ($_POST['uacr_value'] ?? ''),
    'uacr_unit'        => (string) ($_POST['uacr_unit'] ?? 'mg_g'),
    'hba1c'            => (string) ($_POST['hba1c'] ?? ''),
    'sdi'              => (string) ($_POST['sdi'] ?? ''),
    'patient_first_name'     => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name'      => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date'     => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number'   => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif ($action === 'delete_saved') {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_prevent');
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        // Auto-doplniť vek z dát. narodenia / RČ, ak pole ostalo prázdne
        if ($form['age_years'] === '') {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form['age_years'] = (string) $derived;
            }
        }
        // Pohlavie z RČ, ak je dostupné a používateľ ho nezmenil
        if ($patient['birth_number'] !== '') {
            $sexFromBn = sexFromBirthNumber($patient['birth_number']);
            if ($sexFromBn !== null && !isset($_POST['sex'])) {
                $form['sex'] = $sexFromBn;
            }
        }

        $age = filter_var($form['age_years'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 30, 'max_range' => 79]]);
        if ($age === false) {
            $errors[] = 'Vek musí byť celé číslo v intervale 30 až 79 rokov (rozsah platnosti PREVENT).';
        }

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '') {
            $errors[] = 'Vyberte pohlavie.';
        }

        $cholUnit = in_array($form['chol_unit'], ['mmol', 'mgdl'], true) ? $form['chol_unit'] : '';
        if ($cholUnit === '') {
            $errors[] = 'Vyberte jednotku cholesterolu.';
        }

        $totalC = calculatorParsePositiveFloat($form['total_c']);
        $hdlC   = calculatorParsePositiveFloat($form['hdl_c']);
        if ($totalC === null) {
            $errors[] = 'Celkový cholesterol musí byť kladné číslo.';
        }
        if ($hdlC === null) {
            $errors[] = 'HDL cholesterol musí byť kladné číslo.';
        }
        if ($totalC !== null && $hdlC !== null) {
            if ($cholUnit === 'mmol' && ($totalC < 2.0 || $totalC > 12.0 || $hdlC < 0.3 || $hdlC > 4.0)) {
                $errors[] = 'Cholesterol mimo realistického rozsahu (TC 2–12, HDL 0,3–4 mmol/l).';
            }
            if ($cholUnit === 'mgdl' && ($totalC < 80 || $totalC > 460 || $hdlC < 10 || $hdlC > 155)) {
                $errors[] = 'Cholesterol mimo realistického rozsahu (TC 80–460, HDL 10–155 mg/dl).';
            }
            if ($hdlC >= $totalC) {
                $errors[] = 'HDL cholesterol musí byť nižší než celkový cholesterol.';
            }
        }

        $sbp = calculatorParsePositiveFloat($form['sbp']);
        if ($sbp === null || $sbp < 90 || $sbp > 180) {
            $errors[] = 'Systolický TK musí byť v rozsahu 90–180 mm Hg.';
        }

        $bmi = calculatorParsePositiveFloat($form['bmi']);
        if ($bmi === null || $bmi < 15 || $bmi > 60) {
            $errors[] = 'BMI musí byť v rozsahu 15–60 kg/m².';
        }

        $egfr = calculatorParsePositiveFloat($form['egfr']);
        if ($egfr === null || $egfr < 15 || $egfr > 140) {
            $errors[] = 'eGFR musí byť v rozsahu 15–140 ml/min/1,73 m².';
        }

        $bpTx    = $form['bp_tx'] === '1';
        $statin  = $form['statin'] === '1';
        $dm      = $form['dm'] === '1';
        $smoking = $form['smoking'] === '1';

        // Voliteľné rozšírené prediktory
        $uacrMgG = null;
        if (trim($form['uacr_value']) !== '') {
            $uacrUnit = in_array($form['uacr_unit'], ['mg_g', 'mg_mmol'], true) ? $form['uacr_unit'] : 'mg_g';
            $uacrVal  = calculatorParsePositiveFloat($form['uacr_value']);
            if ($uacrVal === null) {
                $errors[] = 'UACR musí byť kladné číslo.';
            } else {
                $uacrMgG = $uacrUnit === 'mg_mmol' ? $uacrVal * 8.84 : $uacrVal;
                if ($uacrMgG < 0.1 || $uacrMgG > 25000) {
                    $errors[] = 'UACR mimo realistického rozsahu (0,1–25000 mg/g).';
                }
            }
        }

        $hba1c = null;
        if (trim($form['hba1c']) !== '') {
            $hba1c = calculatorParsePositiveFloat($form['hba1c']);
            if ($hba1c === null || $hba1c < 4.5 || $hba1c > 15.0) {
                $errors[] = 'HbA1c musí byť v rozsahu 4,5–15 % (DCCT/NGSP).';
            }
        }

        $sdi = null;
        if (trim($form['sdi']) !== '') {
            $sdi = filter_var($form['sdi'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]]);
            if ($sdi === false) {
                $errors[] = 'SDI decil musí byť celé číslo 1–10.';
                $sdi = null;
            }
        }

        if (empty($errors)) {
            $in = [
                'age'       => (int) $age,
                'sex'       => $sex,
                'total_c'   => (float) $totalC,
                'hdl_c'     => (float) $hdlC,
                'chol_unit' => $cholUnit,
                'sbp'       => (float) $sbp,
                'bp_tx'     => $bpTx,
                'statin'    => $statin,
                'dm'        => $dm,
                'smoking'   => $smoking,
                'bmi'       => (float) $bmi,
                'egfr'      => (float) $egfr,
                'uacr'      => $uacrMgG,
                'hba1c'     => $hba1c,
                'sdi'       => $sdi,
            ];

            $computed = preventComputeAll($in);
            $ascvd10  = $computed['risks']['ascvd']['10yr'];
            $interp   = preventInterpretation($ascvd10);

            $calculated = [
                'in'        => $in,
                'model'     => $computed['model'],
                'show_30yr' => $computed['show_30yr'],
                'risks'     => $computed['risks'],
                'interp'    => $interp,
                'uacr_mg_g' => $uacrMgG,
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            'examination_date' => $form['examination_date'],
                            'age_years' => (int) $age,
                            'sex'       => $sex,
                            'total_c'   => (float) $totalC,
                            'hdl_c'     => (float) $hdlC,
                            'chol_unit' => $cholUnit,
                            'sbp'       => (float) $sbp,
                            'bp_tx'     => $bpTx ? 1 : 0,
                            'statin'    => $statin ? 1 : 0,
                            'dm'        => $dm ? 1 : 0,
                            'smoking'   => $smoking ? 1 : 0,
                            'bmi'       => (float) $bmi,
                            'egfr'      => (float) $egfr,
                            'uacr_mg_g' => $uacrMgG !== null ? round($uacrMgG, 2) : null,
                            'hba1c'     => $hba1c,
                            'sdi'       => $sdi,
                        ];
                        $r = $computed['risks'];
                        $resultPayload = [
                            'model'          => $computed['model'],
                            'total_cvd_10yr' => $r['total_cvd']['10yr'],
                            'total_cvd_30yr' => $r['total_cvd']['30yr'],
                            'ascvd_10yr'     => $r['ascvd']['10yr'],
                            'ascvd_30yr'     => $r['ascvd']['30yr'],
                            'hf_10yr'        => $r['heart_failure']['10yr'],
                            'hf_30yr'        => $r['heart_failure']['30yr'],
                            'risk_category'  => $interp['category'],
                            'ldl_target'     => $interp['ldl_target'],
                        ];

                        if (calculatorSaveResult($pdo, (int) $_SESSION['user_id'], PREVENT_CALC_KEY, PREVENT_CALC_LABEL, $patient, $inputPayload, $resultPayload)) {
                            $messages[] = 'Výsledok bol uložený do databázy.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
                        error_log('calculator_prevent save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], PREVENT_CALC_KEY, 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_prevent fetch history error: ' . $e->getMessage());
    }
}

/** Pomocná: vykreslí jeden výstup (10r + 30r) s gauge. */
function preventRenderOutcome(string $title, array $pair, bool $show30): void
{
    $r10 = $pair['10yr'];
    $r30 = $pair['30yr'];
    ?>
    <div class="prevent-outcome">
        <div class="prevent-outcome__title"><?= htmlspecialchars($title) ?></div>
        <div class="prevent-horizons">
            <div class="prevent-horizon">
                <span class="prevent-horizon__label">10 rokov</span>
                <span class="prevent-horizon__value"><?= $r10 !== null ? htmlspecialchars(number_format((float) $r10, 1, ',', ' ')) . ' %' : '—' ?></span>
                <div class="risk-gauge" role="meter" aria-valuenow="<?= (float) ($r10 ?? 0) ?>" aria-valuemin="0" aria-valuemax="100">
                    <div class="risk-gauge__fill" data-width="<?= min(100, (float) ($r10 ?? 0)) ?>"></div>
                </div>
            </div>
            <div class="prevent-horizon">
                <span class="prevent-horizon__label">30 rokov</span>
                <?php if ($show30 && $r30 !== null): ?>
                    <span class="prevent-horizon__value"><?= htmlspecialchars(number_format((float) $r30, 1, ',', ' ')) ?> %</span>
                    <div class="risk-gauge" role="meter" aria-valuenow="<?= (float) $r30 ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="risk-gauge__fill" data-width="<?= min(100, (float) $r30) ?>"></div>
                    </div>
                <?php else: ?>
                    <span class="prevent-horizon__value prevent-horizon__value--na">N/A</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'PREVENT (AHA 2024) — kardiovaskulárne riziko | Kalkulačky | Nefro-projekt Slovensko';
  $canonicalUrl = 'https://nefro.polascin.net/calculator_prevent.php';
  $seoDescription = 'Kalkulačka AHA PREVENT (2024): 10- a 30-ročné riziko pre Total CVD, ASCVD a srdcové zlyhávanie. Zahŕňa eGFR a voliteľne UACR, HbA1c a SDI. S interpretáciou rizikovej kategórie a cieľa LDL podľa odporúčaní 2026. Pre lekárov na Slovensku.';
  $structuredData = [
      [
          '@context' => 'https://schema.org',
          '@type' => 'BreadcrumbList',
          'itemListElement' => [
              ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
              ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $baseUrl . 'calculators.php'],
              ['@type' => 'ListItem', 'position' => 3, 'name' => 'PREVENT (AHA 2024)', 'item' => $baseUrl . 'calculator_prevent.php'],
          ],
      ],
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačka PREVENT';
    $headerIntro = 'AHA PREVENT (2024) — 10- a 30-ročné kardiovaskulárne riziko (Total CVD, ASCVD, HF)';
    $showLogo = false;
    include 'header.php';
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>PREVENT — AHA 2024</h2>
                <p class="auth-subtitle">Predicting Risk of cardiovascular disease EVENTs — 10- a 30-ročné absolútne riziko pre Total CVD, ASCVD a srdcové zlyhávanie (vek 30–79 r.).</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec a model — PREVENT (Khan 2024, logistická regresia)</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{Riziko} = \dfrac{e^{\,lp}}{1 + e^{\,lp}} \times 100\% \]</div>
                        <div class="calc-formula-line">\[ lp = \beta_0 + \textstyle\sum \beta_i x_i \quad(\text{sex-špecifické koeficienty}) \]</div>
                        <div class="calc-formula-vars">
                            Centrovanie: vek 55, non-HDL-C 3,5 mmol/l, HDL-C 1,3 mmol/l, SBP 130, BMI 25, eGFR 90, HbA1c 5,3 % &bull;
                            spline uzly SBP 110 / BMI 30 / eGFR 60 &bull; voliteľné: ln(UACR), HbA1c, SDI →
                            automaticky rozširujú model (base → plný) &bull;
                            Zdroj: Khan SS et al. <em>Circulation.</em> 2024;149:430–449.
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://professional.heart.org/en/guidelines-and-statements/about-prevent-calculator" target="_blank" rel="noopener noreferrer">AHA PREVENT (oficiálny)</a> &ensp;&bull;&ensp;
                    <a href="https://tools.acc.org/CVD-Risk-Estimator-Plus/" target="_blank" rel="noopener noreferrer">ACC CVD Risk Estimator+</a>
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_prevent.php">
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
                                <label for="age_years">Vek (30–79 rokov)</label>
                                <input type="number" id="age_years" name="age_years" min="30" max="79" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="total_c">Celkový cholesterol</label>
                                <div class="flex-gap-8-end">
                                    <input type="text" id="total_c" name="total_c" required class="form-control flex-1" value="<?= htmlspecialchars($form['total_c']) ?>">
                                    <select name="chol_unit" id="chol_unit" aria-label="Jednotka cholesterolu" class="form-control flex-08">
                                        <option value="mmol" <?= $form['chol_unit'] === 'mmol' ? 'selected' : '' ?>>mmol/l</option>
                                        <option value="mgdl" <?= $form['chol_unit'] === 'mgdl' ? 'selected' : '' ?>>mg/dl</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hdl_c">HDL cholesterol <small>(jednotka podľa celkového)</small></label>
                                <input type="text" id="hdl_c" name="hdl_c" required class="form-control" value="<?= htmlspecialchars($form['hdl_c']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="sbp">Systolický TK (mm Hg)</label>
                                <input type="text" id="sbp" name="sbp" required class="form-control" value="<?= htmlspecialchars($form['sbp']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="bmi">BMI (kg/m²)</label>
                                <input type="text" id="bmi" name="bmi" required class="form-control" value="<?= htmlspecialchars($form['bmi']) ?>" placeholder="alebo dopočítaj nižšie">
                            </div>
                            <div class="form-group">
                                <label for="bp_tx">Liečba hypertenzie</label>
                                <select id="bp_tx" name="bp_tx" class="form-control">
                                    <option value="0" <?= $form['bp_tx'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['bp_tx'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statin">Užívanie statínu</label>
                                <select id="statin" name="statin" class="form-control">
                                    <option value="0" <?= $form['statin'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['statin'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dm">Diabetes mellitus</label>
                                <select id="dm" name="dm" class="form-control">
                                    <option value="0" <?= $form['dm'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['dm'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="smoking">Aktuálne fajčenie</label>
                                <select id="smoking" name="smoking" class="form-control">
                                    <option value="0" <?= $form['smoking'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['smoking'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                        </div>

                        <details class="calc-formula-box prevent-bmi-helper">
                            <summary>Pomôcka: dopočítať BMI z výšky a hmotnosti</summary>
                            <div class="form-grid calc-formula-content">
                                <div class="form-group">
                                    <label for="bmi_height">Výška (cm)</label>
                                    <input type="text" id="bmi_height" class="form-control" inputmode="decimal">
                                </div>
                                <div class="form-group">
                                    <label for="bmi_weight">Hmotnosť (kg)</label>
                                    <input type="text" id="bmi_weight" class="form-control" inputmode="decimal">
                                </div>
                                <div class="form-group prevent-bmi-helper__action">
                                    <button type="button" class="btn-secondary" id="bmi_calc_btn">Dopočítať BMI →</button>
                                </div>
                            </div>
                        </details>
                    </div>

                    <div class="form-section">
                        <h3>Voliteľné rozšírené prediktory (rozširujú model)</h3>
                        <p class="helper-text">Vyplnenie UACR, HbA1c alebo SDI automaticky aktivuje presnejší (rozšírený až plný) variant modelu. Prázdne polia = základný model. SDI (Social Deprivation Index) je US-špecifický; pre SK zvyčajne ponechajte prázdny.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="uacr_value">UACR</label>
                                <div class="flex-gap-8-end">
                                    <input type="text" id="uacr_value" name="uacr_value" class="form-control flex-1" value="<?= htmlspecialchars($form['uacr_value']) ?>" placeholder="voliteľné">
                                    <select name="uacr_unit" aria-label="Jednotka UACR" class="form-control flex-08">
                                        <option value="mg_g" <?= $form['uacr_unit'] === 'mg_g' ? 'selected' : '' ?>>mg/g</option>
                                        <option value="mg_mmol" <?= $form['uacr_unit'] === 'mg_mmol' ? 'selected' : '' ?>>mg/mmol</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hba1c">HbA1c (%)</label>
                                <input type="text" id="hba1c" name="hba1c" class="form-control" value="<?= htmlspecialchars($form['hba1c']) ?>" placeholder="voliteľné, 4,5–15">
                            </div>
                            <div class="form-group">
                                <label for="sdi">SDI decil (1–10)</label>
                                <input type="number" id="sdi" name="sdi" min="1" max="10" class="form-control" value="<?= htmlspecialchars($form['sdi']) ?>" placeholder="voliteľné (US)">
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
                    $cls = $calculated['interp']['css'];
                ?>
                    <div class="form-section calculator-result-block prevent-result <?= htmlspecialchars($cls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok PREVENT</h3>
                        <p class="prevent-model-note">Použitý variant modelu: <strong><?= htmlspecialchars(preventModelLabel($calculated['model'])) ?></strong></p>

                        <div class="prevent-grid">
                            <?php
                            preventRenderOutcome('Total CVD', $calculated['risks']['total_cvd'], $calculated['show_30yr']);
                            preventRenderOutcome('ASCVD', $calculated['risks']['ascvd'], $calculated['show_30yr']);
                            preventRenderOutcome('Srdcové zlyhávanie', $calculated['risks']['heart_failure'], $calculated['show_30yr']);
                            ?>
                        </div>

                        <?php if (!$calculated['show_30yr']): ?>
                            <p class="helper-text">30-ročné riziko sa nezobrazuje — PREVENT ho odporúča len pre vek do 59 rokov.</p>
                        <?php endif; ?>

                        <script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES) ?>">
                          document.querySelectorAll('.prevent-result .risk-gauge__fill[data-width]').forEach(function (el) {
                            el.style.width = el.getAttribute('data-width') + '%';
                          });
                        </script>

                        <div class="prevent-interpretation">
                            <h4>Interpretácia (rozhodovanie o statíne podľa odporúčaní 2026)</h4>
                            <p>Kategória rizika podľa 10-ročného <strong>ASCVD</strong>:
                                <span class="calc-result-badge <?= htmlspecialchars($cls) ?>"><?= htmlspecialchars($calculated['interp']['category']) ?></span>
                            </p>
                            <p><strong>Cieľ LDL:</strong> <?= htmlspecialchars($calculated['interp']['ldl_target']) ?></p>
                            <p><strong>Statín:</strong> <?= htmlspecialchars($calculated['interp']['statin']) ?></p>
                            <?php if (!empty($calculated['interp']['notes'])): ?>
                                <ul class="prevent-notes">
                                    <?php foreach ($calculated['interp']['notes'] as $note): ?>
                                        <li><?= htmlspecialchars($note) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=<?= PREVENT_CALC_KEY ?>" class="btn-secondary">História PREVENT</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include 'calculator_disclaimer.php'; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_prevent.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $ascvd10 = (float) ($result['ascvd_10yr'] ?? 0);
                    $cvd10   = (float) ($result['total_cvd_10yr'] ?? 0);
                    echo 'ASCVD 10r: ' . htmlspecialchars(number_format($ascvd10, 1, ',', ' ')) . ' %, ';
                    echo 'CVD 10r: ' . htmlspecialchars(number_format($cvd10, 1, ',', ' ')) . ' %';
                }
            ); ?>
        </div>
    </main>

    <script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES) ?>">
    (function () {
        var btn = document.getElementById('bmi_calc_btn');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var h = parseFloat((document.getElementById('bmi_height').value || '').replace(',', '.'));
            var w = parseFloat((document.getElementById('bmi_weight').value || '').replace(',', '.'));
            if (h > 0 && w > 0) {
                var m = h / 100.0;
                var bmi = w / (m * m);
                document.getElementById('bmi').value = (Math.round(bmi * 10) / 10).toString().replace('.', ',');
            }
        });
    })();
    </script>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime('patient_autofill.js') ?>" defer></script>
    <?php include 'footer.php'; ?>
</body>
</html>
