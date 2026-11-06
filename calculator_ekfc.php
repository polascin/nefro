<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';
require_once __DIR__ . '/calculator_ekfc_logic.php';

/*
 * EKFC — European Kidney Function Consortium (Pottel 2021/2023).
 * Čisté vzorce sú v calculator_ekfc_logic.php.
 */

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    // 'cr' = len kreatinín, 'cys' = len cystatín C, 'cr_cys' = kombinovaná
    'mode' => calculatorPostString('mode', 'cr'),
    'sex' => calculatorPostString('sex', 'female'),
    'age_years' => calculatorPostString('age_years'),
    'creatinine_value' => calculatorPostString('creatinine_value'),
    'creatinine_unit' => calculatorPostString('creatinine_unit', 'umol_l'),
    'cystatin_value' => calculatorPostString('cystatin_value'),
    'patient_first_name' => calculatorPostString('patient_first_name'),
    'patient_last_name' => calculatorPostString('patient_last_name'),
    'patient_birth_date' => calculatorPostString('patient_birth_date'),
    'patient_birth_number' => calculatorPostString('patient_birth_number'),
    'patient_insurance_code' => calculatorPostString('patient_insurance_code'),
    'examination_date' => calculatorPostString('examination_date', date('Y-m-d')),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = calculatorPostString('action');

    if (!validateCsrfToken(calculatorPostString('csrf_token'))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif ($action === 'delete_saved') {
        calculatorHandleDeleteSaved($pdo, $errors, $messages, 'calculator_ekfc');
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        calculatorValidateExaminationDate($form['examination_date'], $errors);

        // Auto-doplniť vek z dátumu narodenia / rodného čísla, ak pole ostalo prázdne
        if ($form['age_years'] === '') {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form['age_years'] = (string) $derived;
            }
        }

        $mode = in_array($form['mode'], ['cr', 'cys', 'cr_cys'], true) ? $form['mode'] : '';
        if ($mode === '') {
            $errors[] = 'Vyberte variantu rovnice (kreatinín / cystatín C / kombinovaná).';
        }
        $needCreatinine = $mode === 'cr' || $mode === 'cr_cys';
        $needCystatin = $mode === 'cys' || $mode === 'cr_cys';

        // Pohlavie je potrebné len pre Q kreatinínu; cystatínová verzia ho nepoužíva.
        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '' && $needCreatinine) {
            $errors[] = 'Vyberte pohlavie (vstupuje do hodnoty Q pre kreatinín).';
        }

        // EKFC je validovaná od 2 rokov — na rozdiel od CKD-EPI (len ≥ 18 r.)
        $ageYears = filter_var($form['age_years'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 2, 'max_range' => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = 'Vek musí byť celé číslo v intervale 2 až 120 rokov.';
        }

        $creatinineValue = null;
        $creatinineUnit = '';
        if ($needCreatinine) {
            $creatinineValue = calculatorParsePositiveFloat($form['creatinine_value']);
            if ($creatinineValue === null) {
                $errors[] = 'Kreatinín musí byť kladné číslo.';
            }
            $creatinineUnit = in_array($form['creatinine_unit'], ['umol_l', 'mg_dl'], true)
                ? $form['creatinine_unit']
                : '';
            if ($creatinineUnit === '') {
                $errors[] = 'Vyberte jednotku kreatinínu.';
            }
        }

        $cystatinValue = null;
        if ($needCystatin) {
            $cystatinValue = calculatorParsePositiveFloat($form['cystatin_value']);
            if ($cystatinValue === null) {
                $errors[] = 'Cystatín C musí byť kladné číslo (mg/L).';
            } elseif ($cystatinValue < 0.3 || $cystatinValue > 10.0) {
                $errors[] = 'Cystatín C mimo očakávaného rozsahu (0,3 – 10 mg/L).';
            }
        }

        if (empty($errors)) {
            $age = (float) $ageYears;

            $crPart = null;   // medzivýsledky kreatinínovej vetvy
            $cysPart = null;  // medzivýsledky cystatínovej vetvy
            $creatinineUmol = null;
            $creatinineMgDl = null;
            $qCrUmol = null;

            if ($needCreatinine) {
                // Polynómy Q platia pre µmol/L → vstup z mg/dL najprv prepočítame
                $creatinineUmol = $creatinineUnit === 'mg_dl'
                    ? creatinineMgDlToUmolL((float) $creatinineValue)
                    : (float) $creatinineValue;
                $creatinineMgDl = creatinineUmolLToMgDl($creatinineUmol);

                $qCrUmol = ekfcQCreatinineUmol($age, $sex);
                $crPart = ekfcCore($creatinineUmol, $qCrUmol, $age);
            }

            if ($needCystatin) {
                $qCys = ekfcQCystatin($age);
                $cysPart = ekfcCore((float) $cystatinValue, $qCys, $age);
                $cysPart['q'] = $qCys;
            }

            // Kombinovaná verzia = aritmetický priemer oboch odhadov
            if ($mode === 'cr') {
                $egfr = $crPart['egfr'];
            } elseif ($mode === 'cys') {
                $egfr = $cysPart['egfr'];
            } else {
                $egfr = ($crPart['egfr'] + $cysPart['egfr']) / 2.0;
            }

            $egfrRounded = round($egfr, 1);
            $gCategory = ckdGCategory($egfrRounded);
            $gDescription = ckdGCategoryDescription($gCategory);

            // Porovnanie s CKD-EPI 2021 má zmysel len u dospelých (≥ 18 r.)
            $ckdEpi = null;
            if ($needCreatinine && $ageYears >= 18 && $sex !== '') {
                $ckdEpi = round(
                    ekfcCompareCkdEpi2021((float) $creatinineMgDl, $age, $sex),
                    1,
                );
            }

            $calculated = [
                'mode' => $mode,
                'egfr' => $egfrRounded,
                'g_category' => $gCategory,
                'g_description' => $gDescription,
                'sex' => $sex,
                'age_years' => (int) $ageYears,
                'creatinine_input' => $creatinineValue !== null ? round((float) $creatinineValue, 2) : null,
                'creatinine_unit' => $creatinineUnit,
                'creatinine_umol' => $creatinineUmol !== null ? round($creatinineUmol, 1) : null,
                'creatinine_mg_dl' => $creatinineMgDl !== null ? round($creatinineMgDl, 3) : null,
                'q_cr_umol' => $qCrUmol !== null ? round($qCrUmol, 2) : null,
                'q_cr_mg_dl' => $qCrUmol !== null ? round(creatinineUmolLToMgDl($qCrUmol), 3) : null,
                'cystatin_value' => $cystatinValue !== null ? round((float) $cystatinValue, 2) : null,
                'q_cys' => $cysPart !== null ? round((float) $cysPart['q'], 3) : null,
                'egfr_cr' => $crPart !== null ? round((float) $crPart['egfr'], 1) : null,
                'egfr_cys' => $cysPart !== null ? round((float) $cysPart['egfr'], 1) : null,
                'ratio_cr' => $crPart !== null ? round((float) $crPart['ratio'], 3) : null,
                'ratio_cys' => $cysPart !== null ? round((float) $cysPart['ratio'], 3) : null,
                'exponent_cr' => $crPart !== null ? (float) $crPart['exponent'] : null,
                'exponent_cys' => $cysPart !== null ? (float) $cysPart['exponent'] : null,
                'age_factor' => round(
                    (float) ($crPart['age_factor'] ?? $cysPart['age_factor'] ?? 1.0),
                    4,
                ),
                'q_source' => $age > 25.0 ? 'plateau' : 'polynom',
                'ckd_epi_2021' => $ckdEpi,
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            'examination_date' => $form['examination_date'],
                            'mode' => $mode,
                            'sex' => $sex,
                            'age_years' => (int) $ageYears,
                        ];
                        if ($needCreatinine) {
                            $inputPayload['creatinine_value'] = round((float) $creatinineValue, 2);
                            $inputPayload['creatinine_unit'] = $creatinineUnit;
                        }
                        if ($needCystatin) {
                            $inputPayload['cystatin_value'] = round((float) $cystatinValue, 2);
                        }

                        $resultPayload = [
                            'egfr' => $egfrRounded,
                            'g_category' => $gCategory,
                            'g_description' => $gDescription,
                            'mode' => $mode,
                            'egfr_cr' => $calculated['egfr_cr'],
                            'egfr_cys' => $calculated['egfr_cys'],
                            'q_cr_umol' => $calculated['q_cr_umol'],
                            'q_cys' => $calculated['q_cys'],
                            'creatinine_mg_dl' => $calculated['creatinine_mg_dl'],
                            'ckd_epi_2021' => $ckdEpi,
                        ];

                        if (
                            calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION['user_id'],
                                'egfr_ekfc',
                                'eGFR (EKFC)',
                                $patient,
                                $inputPayload,
                                $resultPayload,
                            )
                        ) {
                            $messages[] = 'Výsledok bol uložený do databázy.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
                        error_log('calculator_ekfc save error: ' . $e->getMessage());
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
            (int) $_SESSION['user_id'],
            'egfr_ekfc',
            25,
        );
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_ekfc fetch history error: ' . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'eGFR podľa EKFC (full age spectrum) | Kalkulačky | Nefro-projekt Slovensko';
  $canonicalUrl = 'https://nefro.polascin.net/calculator_ekfc.php';
  $seoDescription =
      'Kalkulačka eGFR podľa rovnice EKFC (European Kidney Function Consortium) z kreatinínu, cystatínu C alebo kombinovane. Jediná rovnica pre vek 2 – 120 rokov, bez rasového koeficientu, s reškálovaním na Q hodnotu. Pre lekárov na Slovensku.';
  $baseUrl = 'https://nefro.polascin.net/';
  $structuredData = [
      [
          '@context' => 'https://schema.org',
          '@type' => 'BreadcrumbList',
          'itemListElement' => [
              [
                  '@type' => 'ListItem',
                  'position' => 1,
                  'name' => 'Domov',
                  'item' => $baseUrl,
              ],
              [
                  '@type' => 'ListItem',
                  'position' => 2,
                  'name' => 'Kalkulačky',
                  'item' => $baseUrl . 'calculators.php',
              ],
              [
                  '@type' => 'ListItem',
                  'position' => 3,
                  'name' => 'eGFR podľa EKFC',
                  'item' => $baseUrl . 'calculator_ekfc.php',
              ],
          ],
      ],
  ];
  include 'head_meta.php';
  ?>
  <meta name="calculator-key" content="egfr_ekfc">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačka eGFR: EKFC';
    $headerIntro = 'European Kidney Function Consortium, vek 2 – 120 rokov';
    $showLogo = false;
    include 'header.php';
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>eGFR podľa rovnice EKFC</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + povinné vstupy pre výpočet.</p>

                <div class="info-box">
                    <strong>Kedy použiť EKFC:</strong> rovnica pracuje s reškálovaným biomarkerom
                    (pomer k mediánu normy Q), preto <em>nepotrebuje rasový koeficient</em> a platí
                    plynulo pre celé vekové spektrum od 2 rokov, bez skoku pri prechode
                    z pediatrickej do dospelej nefrológie. V hornom pásme filtrácie
                    (&gt; 60 ml/min/1,73 m²) je spravidla presnejšia než CKD-EPI 2021, ktorá tam
                    GFR systematicky nadhodnocuje; to mení zaradenie do štádia CKD aj dávkovanie
                    liekov. Kombinovaná verzia (kreatinín + cystatín C) má najmenšie skreslenie.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec: EKFC</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{eGFR} = 107{,}3 \times \left(\frac{\text{biomarker}}{Q}\right)^{\alpha} \times \begin{cases} 1 & \text{vek} \le 40 \\ 0{,}990^{(\text{vek}-40)} & \text{vek} > 40 \end{cases} \]</div>
                        <div class="calc-formula-line">\[ \alpha = \begin{cases} -0{,}322 & \text{ak } \text{biomarker}/Q < 1 \\ -1{,}132 & \text{ak } \text{biomarker}/Q \ge 1 \end{cases} \]</div>
                        <div class="calc-formula-line"><strong>Q pre kreatinín</strong> (µmol/L), vek 2 – 25 rokov:</div>
                        <div class="calc-formula-line">\[ \ln Q_{\text{muž}} = 3{,}200 + 0{,}259\,A - 0{,}543\ln A - 0{,}00763\,A^2 + 0{,}0000790\,A^3 \]</div>
                        <div class="calc-formula-line">\[ \ln Q_{\text{žena}} = 3{,}080 + 0{,}177\,A - 0{,}223\ln A - 0{,}00596\,A^2 + 0{,}0000686\,A^3 \]</div>
                        <div class="calc-formula-line">\[ \text{vek} > 25\ \text{r.:}\quad Q = 80\ \mu\text{mol/L (muž)},\ 62\ \mu\text{mol/L (žena)} \]</div>
                        <div class="calc-formula-line"><strong>Q pre cystatín C</strong> (mg/L), bez rozlíšenia pohlavia:</div>
                        <div class="calc-formula-line">\[ Q_{\text{cys}} = \begin{cases} 0{,}83 & \text{vek} < 50 \\ 0{,}83 + 0{,}005\,(\text{vek}-50) & \text{vek} \ge 50 \end{cases} \]</div>
                        <div class="calc-formula-line"><strong>Kombinovaná:</strong> \( \text{eGFR}_{\text{cr-cys}} = \tfrac{1}{2}\left(\text{eGFR}_{\text{cr}} + \text{eGFR}_{\text{cys}}\right) \)</div>
                        <div class="calc-formula-vars">
                            $A = \text{vek v rokoch}$ &bull;
                            $Q = \text{medián normálnej hodnoty biomarkera}$ &bull;
                            $1\ \text{mg/dL} = 88{,}4\ \mu\text{mol/L}$
                        </div>
                    </div>
                </details>

                <div class="info-box-green">
                    <strong>Zdroje a referenčné kalkulátory:</strong>
                    <a href="https://www.acpjournals.org/doi/10.7326/M20-4366" target="_blank" rel="noopener noreferrer">Pottel 2021 (Ann Intern Med)</a> &ensp;&bull;&ensp;
                    <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2203769" target="_blank" rel="noopener noreferrer">Pottel 2023 (NEJM, cystatín C)</a> &ensp;&bull;&ensp;
                    <a href="https://ekfccalculator.pages.dev/" target="_blank" rel="noopener noreferrer">Oficiálna EKFC kalkulačka</a> &ensp;&bull;&ensp;
                    <a href="calculator_egfr.php">eGFR CKD-EPI 2021</a> &ensp;&bull;&ensp;
                    <a href="calculator_egfr_cys.php">eGFR kreatinín–cystatín C</a>
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success" role="status"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_ekfc.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php include __DIR__ . '/calculator_patient_fields.php'; ?>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="mode">Variant rovnice</label>
                                <select id="mode" name="mode" class="form-control" required>
                                    <option value="cr" <?= $form['mode'] === 'cr' ? 'selected' : '' ?>>Kreatinín (EKFC-cr)</option>
                                    <option value="cys" <?= $form['mode'] === 'cys' ? 'selected' : '' ?>>Cystatín C (EKFC-cys)</option>
                                    <option value="cr_cys" <?= $form['mode'] === 'cr_cys' ? 'selected' : '' ?>>Kombinovaná (EKFC-cr-cys)</option>
                                </select>
                                <small class="form-hint">Kombinovaná verzia je najpresnejšia; cystatínová nepoužíva pohlavie.</small>
                            </div>
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(formatUserTimestamp(time(), 'Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group" data-ekfc-need="cr">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                                <small class="form-hint">Vstupuje len do hodnoty Q pre kreatinín.</small>
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="2" max="120" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>" placeholder="automaticky z dát. nar. / RČ">
                                <small class="form-hint">EKFC je validovaná od 2 rokov (full age spectrum).</small>
                            </div>
                            <div class="form-group" data-ekfc-need="cr">
                                <label for="creatinine_value">S-kreatinín</label>
                                <input type="text" id="creatinine_value" name="creatinine_value" class="form-control" value="<?= htmlspecialchars($form['creatinine_value']) ?>" placeholder="napr. 95">
                            </div>
                            <div class="form-group" data-ekfc-need="cr">
                                <label for="creatinine_unit">Jednotka kreatinínu</label>
                                <select id="creatinine_unit" name="creatinine_unit" class="form-control">
                                    <option value="umol_l" <?= $form['creatinine_unit'] === 'umol_l' ? 'selected' : '' ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form['creatinine_unit'] === 'mg_dl' ? 'selected' : '' ?>>mg/dL</option>
                                </select>
                            </div>
                            <div class="form-group" data-ekfc-need="cys">
                                <label for="cystatin_value">S-cystatín C (mg/L)</label>
                                <input type="text" id="cystatin_value" name="cystatin_value" class="form-control" value="<?= htmlspecialchars($form['cystatin_value']) ?>" placeholder="napr. 1,1">
                                <small class="form-hint">Potrebný pre cystatínovú a kombinovanú variantu.</small>
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
                    $riskCls = egfrRiskClass($calculated['g_category']);
                ?>
                    <div class="form-section calculator-result-block <?= htmlspecialchars($riskCls) ?>" role="status" aria-live="polite">
                        <h3>Výsledok výpočtu: <?= htmlspecialchars(calculatorEkfcModeLabel((string) $calculated['mode'])) ?></h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float) $calculated['egfr'], 1, ',', ' ')) ?></span>
                                <span class="calc-result-unit">ml/min/1,73 m²</span>
                                <span class="calc-result-unit">= <?= htmlspecialchars(number_format(egfrMlMinToMlS((float) $calculated['egfr']), 3, ',', ' ')) ?> ml/s/1,73 m²</span>
                            </div>
                            <div class="calc-result-badge <?= htmlspecialchars($riskCls) ?>">
                                <?= htmlspecialchars($calculated['g_category']) ?>
                                <span><?= htmlspecialchars($calculated['g_description']) ?></span>
                            </div>
                        </div>
                        <div class="calc-risk-bar-wrap"
                             data-risk-value="<?= (float) $calculated['egfr'] ?>"
                             data-risk-max="120"
                             data-risk-label="eGFR"></div>

                        <?php if ($calculated['mode'] === 'cr_cys'): ?>
                            <p class="calc-result-detail">
                                <strong>EKFC<sub>cr</sub>:</strong> <?= htmlspecialchars(number_format((float) $calculated['egfr_cr'], 1, ',', ' ')) ?>
                                &ensp;&bull;&ensp;<strong>EKFC<sub>cys</sub>:</strong> <?= htmlspecialchars(number_format((float) $calculated['egfr_cys'], 1, ',', ' ')) ?>
                                &ensp;&bull;&ensp;priemer = výsledok vyššie.
                                <?php
                                // Veľký rozdiel medzi biomarkermi je klinická informácia samotná:
                                // upozorňuje na atypickú svalovú masu alebo na stavy ovplyvňujúce cystatín C.
                                $gap = abs((float) $calculated['egfr_cr'] - (float) $calculated['egfr_cys']);
                                if ($gap >= 20.0):
                                ?>
                                    <br><em>Rozdiel medzi biomarkermi je <?= htmlspecialchars(number_format($gap, 1, ',', ' ')) ?> ml/min/1,73 m².
                                    Zvážte vplyv svalovej masy (sarkopénia, amputácia, kulturistika) na kreatinín alebo vplyv
                                    tyreopatie, kortikoidov, zápalu a obezity na cystatín C; pri rozhodovaní s veľkými dôsledkami
                                    uvažujte o meranej GFR.</em>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Rozpis výpočtu: každý krok rovnice s konkrétnymi číslami pacienta -->
                        <details class="calc-formula-box">
                            <summary>Rozpis výpočtu krok po kroku</summary>
                            <div class="calc-formula-content">
                                <?php if ($calculated['q_cr_umol'] !== null): ?>
                                    <p>
                                        <strong>1. Kreatinín:</strong>
                                        <?= htmlspecialchars(number_format((float) $calculated['creatinine_umol'], 1, ',', ' ')) ?> µmol/L
                                        (= <?= htmlspecialchars(number_format((float) $calculated['creatinine_mg_dl'], 3, ',', ' ')) ?> mg/dL)
                                    </p>
                                    <p>
                                        <strong>2. Q pre kreatinín</strong>
                                        (<?= $calculated['q_source'] === 'plateau'
                                            ? 'plateau dospelého veku'
                                            : 'polynóm pre vek 2 – 25 rokov' ?>,
                                        <?= $calculated['sex'] === 'female' ? 'žena' : 'muž' ?>,
                                        <?= (int) $calculated['age_years'] ?> r.):
                                        <?= htmlspecialchars(number_format((float) $calculated['q_cr_umol'], 2, ',', ' ')) ?> µmol/L
                                        (= <?= htmlspecialchars(number_format((float) $calculated['q_cr_mg_dl'], 3, ',', ' ')) ?> mg/dL)
                                    </p>
                                    <p>
                                        <strong>3. Reškálovaný kreatinín</strong> S<sub>cr</sub>/Q =
                                        <?= htmlspecialchars(number_format((float) $calculated['ratio_cr'], 3, ',', ' ')) ?>
                                        → exponent α = <?= htmlspecialchars(number_format((float) $calculated['exponent_cr'], 3, ',', ' ')) ?>
                                        (<?= (float) $calculated['ratio_cr'] < 1.0
                                            ? 'pomer &lt; 1, t. j. kreatinín pod mediánom normy'
                                            : 'pomer ≥ 1, t. j. kreatinín na úrovni mediánu normy alebo nad ním' ?>)
                                    </p>
                                    <p>
                                        <strong>4. EKFC<sub>cr</sub></strong> = 107,3 × <?= htmlspecialchars(number_format((float) $calculated['ratio_cr'], 3, ',', ' ')) ?><sup><?= htmlspecialchars(number_format((float) $calculated['exponent_cr'], 3, ',', ' ')) ?></sup>
                                        × <?= htmlspecialchars(number_format((float) $calculated['age_factor'], 4, ',', ' ')) ?>
                                        = <?= htmlspecialchars(number_format((float) $calculated['egfr_cr'], 1, ',', ' ')) ?> ml/min/1,73 m²
                                    </p>
                                <?php endif; ?>

                                <?php if ($calculated['q_cys'] !== null): ?>
                                    <p>
                                        <strong><?= $calculated['q_cr_umol'] !== null ? '5' : '1' ?>. Cystatín C:</strong>
                                        <?= htmlspecialchars(number_format((float) $calculated['cystatin_value'], 2, ',', ' ')) ?> mg/L,
                                        Q<sub>cys</sub> = <?= htmlspecialchars(number_format((float) $calculated['q_cys'], 3, ',', ' ')) ?> mg/L
                                        (<?= (int) $calculated['age_years'] < 50 ? 'vek &lt; 50 r. → konštanta 0,83' : 'vek ≥ 50 r. → 0,83 + 0,005 × (vek − 50)' ?>)
                                    </p>
                                    <p>
                                        <strong><?= $calculated['q_cr_umol'] !== null ? '6' : '2' ?>. EKFC<sub>cys</sub></strong>
                                        = 107,3 × <?= htmlspecialchars(number_format((float) $calculated['ratio_cys'], 3, ',', ' ')) ?><sup><?= htmlspecialchars(number_format((float) $calculated['exponent_cys'], 3, ',', ' ')) ?></sup>
                                        × <?= htmlspecialchars(number_format((float) $calculated['age_factor'], 4, ',', ' ')) ?>
                                        = <?= htmlspecialchars(number_format((float) $calculated['egfr_cys'], 1, ',', ' ')) ?> ml/min/1,73 m²
                                    </p>
                                <?php endif; ?>

                                <p>
                                    <strong>Veková korekcia:</strong>
                                    <?= (int) $calculated['age_years'] > 40
                                        ? '0,990<sup>(' . (int) $calculated['age_years'] . ' − 40)</sup> = ' . htmlspecialchars(number_format((float) $calculated['age_factor'], 4, ',', ' '))
                                        : 'vek ≤ 40 rokov → bez korekcie (faktor 1,0)' ?>
                                </p>
                            </div>
                        </details>

                        <?php if ($calculated['ckd_epi_2021'] !== null):
                            $delta = (float) $calculated['egfr'] - (float) $calculated['ckd_epi_2021'];
                            $ckdEpiCat = ckdGCategory((float) $calculated['ckd_epi_2021']);
                        ?>
                            <p class="calc-result-detail">
                                <strong>Porovnanie s CKD-EPI 2021 (kreatinín):</strong>
                                <?= htmlspecialchars(number_format((float) $calculated['ckd_epi_2021'], 1, ',', ' ')) ?> ml/min/1,73 m²
                                (<?= htmlspecialchars($ckdEpiCat) ?>)
                                &ensp;&bull;&ensp;rozdiel EKFC − CKD-EPI =
                                <?= htmlspecialchars(($delta >= 0 ? '+' : '−') . number_format(abs($delta), 1, ',', ' ')) ?> ml/min/1,73 m²
                                <?php if ($ckdEpiCat !== $calculated['g_category']): ?>
                                    <br><em>Pozor: obe rovnice zaraďujú pacienta do <strong>odlišnej</strong> kategórie G
                                    (<?= htmlspecialchars($ckdEpiCat) ?> vs. <?= htmlspecialchars((string) $calculated['g_category']) ?>).
                                    Pri rozhodnutiach závislých od hranice štádia (dávkovanie liekov, indikácia kontrastu,
                                    zaradenie do programu) uveďte, ktorú rovnicu ste použili.</em>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary js-print">Vytlačiť výpočet</button>
                            <a href="calculator_history.php?calc=egfr_ekfc" class="btn-secondary">História EKFC</a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="info-box">
                    <strong>Obmedzenia:</strong> hodnoty Q sú kalibrované na európske populácie;
                    mimo nich (subsaharská Afrika, východná Ázia) treba Q lokálne overiť.
                    Kreatinínová verzia zostáva, tak ako každá iná, závislá od svalovej masy:
                    pri sarkopénii, amputácii, kachexii, paraplégii alebo naopak veľkej svalovej
                    hmote použite cystatín C, kombinovanú verziu alebo meranú GFR. eGFR nie je
                    platná pri akútnom poškodení obličiek (nestabilný kreatinín) ani počas
                    gravidity. KDIGO 2024 EKFC uvádza ako akceptovateľnú alternatívu, bez
                    výhradného odporúčania jednej rovnice.
                </div>
            </div>

            <?php include 'calculator_disclaimer.php'; ?>
            <?php calculatorRenderSavedResultsTable(
                $savedResults,
                'calculator_ekfc.php',
                function (array $row): void {
                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                    $egfrValue = (float) ($result['egfr'] ?? 0);
                    $category = (string) ($result['g_category'] ?? '');
                    $mode = (string) ($result['mode'] ?? '');
                    echo htmlspecialchars(number_format($egfrValue, 1, ',', ' ')) . ' ml/min/1,73 m²';
                    if ($category !== '') {
                        echo ' (' . htmlspecialchars($category) . ')';
                    }
                    if ($mode !== '') {
                        echo '<small class="d-block saved-meta">' . htmlspecialchars(calculatorEkfcModeLabel($mode)) . '</small>';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=<?= filemtime('patient_autofill.js') ?>" defer></script>
    <script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
    // Zobrazí len vstupy, ktoré zvolený variant rovnice skutočne používa:
    // cystatínová verzia nepotrebuje kreatinín ani pohlavie, a naopak.
    (function () {
        var modeSelect = document.getElementById('mode');
        if (!modeSelect) { return; }
        var groups = document.querySelectorAll('[data-ekfc-need]');
        function sync() {
            var mode = modeSelect.value;
            var needCr = mode === 'cr' || mode === 'cr_cys';
            var needCys = mode === 'cys' || mode === 'cr_cys';
            groups.forEach(function (group) {
                var need = group.getAttribute('data-ekfc-need');
                group.hidden = (need === 'cr' && !needCr) || (need === 'cys' && !needCys);
            });
        }
        modeSelect.addEventListener('change', sync);
        sync();
    })();
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
