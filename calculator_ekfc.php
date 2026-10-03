<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

/*
 * ═══════════════════════════════════════════════════════════════════════════
 *  EKFC — European Kidney Function Consortium equation
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  PRINCÍP
 *  -------
 *  EKFC nepoužíva absolútnu hodnotu biomarkera, ale jeho „reškálovaný"
 *  bezrozmerný pomer  biomarker / Q,  kde  Q = medián normálnej hodnoty
 *  biomarkera v danej populácii (vek + pohlavie). Tým sa z rovnice odstráni
 *  vplyv pohlavia aj rasy a — čo je hlavná výhoda — jediná rovnica platí pre
 *  celé vekové spektrum od 2 rokov do vysokého veku (full age spectrum).
 *  CKD-EPI (len dospelí) a CKiD (len deti) sa na 18. roku života nespojito
 *  „lámu"; EKFC prechod medzi pediatriou a dospelou nefrológiou nemá skok.
 *
 *  JADRO ROVNICE (rovnaké pre kreatinín aj cystatín C)
 *  ---------------------------------------------------
 *      eGFR = 107,3 × (biomarker / Q)^α        α = −0,322  ak  pomer <  1
 *                                              α = −1,132  ak  pomer ≥ 1
 *      a navyše  × 0,990^(vek − 40)            len ak vek > 40 rokov
 *
 *  Dva rôzne exponenty sú zámer: v pásme normálnej funkcie (pomer < 1) je
 *  vzťah medzi kreatinínom a GFR plochší než pri zníženej funkcii, kde malý
 *  vzostup kreatinínu znamená veľký pokles filtrácie. Lomený exponent preto
 *  rieši systematické nadhodnocovanie GFR v hornom pásme.
 *
 *  Q PRE KREATININ (Pottel 2021, hodnoty v µmol/L)
 *  -----------------------------------------------
 *    vek 2 – 25 r.:  polynóm ln(Q) v závislosti od veku (rastúca svalová masa)
 *    vek  > 25 r.:   plateau  80 µmol/L (muž) / 62 µmol/L (žena)
 *                    = 0,90 mg/dL / 0,70 mg/dL
 *
 *  Q PRE CYSTATIN C (Pottel 2023, hodnoty v mg/L)
 *  ----------------------------------------------
 *    vek  < 50 r.:   0,83 mg/L — rovnako pre obe pohlavia aj pre deti ≥ 2 r.
 *    vek ≥ 50 r.:    0,83 + 0,005 × (vek − 50)
 *  Cystatínová verzia teda nepotrebuje ani pohlavie, ani rasu.
 *
 *  KOMBINOVANÁ VERZIA
 *  ------------------
 *  EKFC eGFR(cr-cys) = aritmetický priemer EKFC(kreatinín) a EKFC(cystatín C).
 *  Má najmenšie systematické skreslenie a najvyššiu presnosť (P30 > 90 %).
 *
 *  ZDROJE
 *  ------
 *  Pottel H, et al. Ann Intern Med 2021;174:183–191 (EKFC kreatinín)
 *  Pottel H, et al. N Engl J Med 2023;388:333–343 (EKFC cystatín C)
 *  Pottel H, et al. Pediatr Nephrol 2024 (rozšírenie EKFC-CysC na deti)
 * ═══════════════════════════════════════════════════════════════════════════
 */

/** Prepočtový faktor kreatinínu: 1 mg/dL = 88,4 µmol/L. */
const EKFC_CREATININE_UMOL_PER_MGDL = 88.4;

/**
 * Q — medián normálneho sérového kreatinínu pre daný vek a pohlavie [µmol/L].
 *
 * Do 25 rokov hodnota rastie so svalovou masou, preto polynóm; nad 25 rokov sa
 * ustáli (plateau). Polynómy sú definované pre kreatinín v µmol/L — preto
 * všetky výpočty vedieme v µmol/L a na mg/dL prepočítavame až na výstupe.
 */
function ekfcQCreatinineUmol(float $ageYears, string $sex): float
{
    if ($ageYears > 25.0) {
        // Plateau dospelého veku
        return $sex === 'female' ? 62.0 : 80.0;
    }

    // Polynóm ln(Q) pre vek 2 – 25 rokov (Pottel 2021, Fig. 1)
    $a = $ageYears;
    if ($sex === 'female') {
        $lnQ = 3.080
            + 0.177 * $a
            - 0.223 * log($a)
            - 0.00596 * ($a ** 2)
            + 0.0000686 * ($a ** 3);
    } else {
        $lnQ = 3.200
            + 0.259 * $a
            - 0.543 * log($a)
            - 0.00763 * ($a ** 2)
            + 0.0000790 * ($a ** 3);
    }

    return exp($lnQ);
}

/**
 * Q — medián normálneho cystatínu C [mg/L].
 *
 * Bez rozdielu podľa pohlavia. Od 50. roku sa mierne lineárne zvyšuje, čo
 * zohľadňuje fyziologický vzostup cystatínu C vo vyššom veku.
 */
function ekfcQCystatin(float $ageYears): float
{
    if ($ageYears < 50.0) {
        return 0.83;
    }

    return 0.83 + 0.005 * ($ageYears - 50.0);
}

/**
 * Jadro rovnice EKFC. Vracia pole s výsledkom aj s medzivýsledkami, aby sa
 * výpočet dal na stránke zobraziť krok po kroku (nie je to „čierna skrinka").
 *
 * @return array{ratio: float, exponent: float, base: float, age_factor: float, egfr: float}
 */
function ekfcCore(float $biomarker, float $q, float $ageYears): array
{
    // 1) reškálovanie: bezrozmerný pomer k mediánu normy
    $ratio = $biomarker / $q;

    // 2) voľba exponentu podľa toho, či je biomarker pod alebo nad normou
    $exponent = $ratio < 1.0 ? -0.322 : -1.132;

    // 3) základná hodnota pred vekovou korekciou
    $base = 107.3 * ($ratio ** $exponent);

    // 4) veková korekcia len nad 40 rokov (fyziologický pokles ~1 % ročne)
    $ageFactor = $ageYears > 40.0 ? 0.990 ** ($ageYears - 40.0) : 1.0;

    return [
        'ratio' => $ratio,
        'exponent' => $exponent,
        'base' => $base,
        'age_factor' => $ageFactor,
        'egfr' => $base * $ageFactor,
    ];
}

/**
 * CKD-EPI 2021 (kreatinín, bez rasy) — len na porovnanie s EKFC u dospelých.
 * Nie je súčasťou EKFC; slúži na ukázanie rozdielu medzi rovnicami.
 */
function ekfcCompareCkdEpi2021(float $creatinineMgDl, float $ageYears, string $sex): float
{
    $kappa = $sex === 'female' ? 0.7 : 0.9;
    $alpha = $sex === 'female' ? -0.241 : -0.302;
    $ratio = $creatinineMgDl / $kappa;

    $egfr = 142.0
        * (min($ratio, 1.0) ** $alpha)
        * (max($ratio, 1.0) ** -1.2)
        * (0.9938 ** $ageYears);

    if ($sex === 'female') {
        $egfr *= 1.012;
    }

    return $egfr;
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    // 'cr' = len kreatinín, 'cys' = len cystatín C, 'cr_cys' = kombinovaná
    'mode' => (string) ($_POST['mode'] ?? 'cr'),
    'sex' => (string) ($_POST['sex'] ?? 'female'),
    'age_years' => (string) ($_POST['age_years'] ?? ''),
    'creatinine_value' => (string) ($_POST['creatinine_value'] ?? ''),
    'creatinine_unit' => (string) ($_POST['creatinine_unit'] ?? 'umol_l'),
    'cystatin_value' => (string) ($_POST['cystatin_value'] ?? ''),
    'patient_first_name' => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name' => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date' => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number' => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
    'examination_date' => (string) ($_POST['examination_date'] ?? date('Y-m-d')),
];

calculatorHandleLoadId($pdo, $form, $messages);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
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

        // EKFC je validovaná od 2 rokov — na rozdiel od CKD-EPI (len ≥ 18 r.)
        $ageYears = filter_var($form['age_years'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 2, 'max_range' => 120],
        ]);
        if ($ageYears === false) {
            $errors[] = 'Vek musí byť celé číslo v intervale 2 až 120 rokov.';
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
                $errors[] = 'Cystatín C mimo očakávaného rozsahu (0,3 – 10 mg/L).';
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
                    ? (float) $creatinineValue * EKFC_CREATININE_UMOL_PER_MGDL
                    : (float) $creatinineValue;
                $creatinineMgDl = $creatinineUmol / EKFC_CREATININE_UMOL_PER_MGDL;

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
                'q_cr_mg_dl' => $qCrUmol !== null ? round($qCrUmol / EKFC_CREATININE_UMOL_PER_MGDL, 3) : null,
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

/** Čitateľný názov zvolenej varianty rovnice. */
function ekfcModeLabel(string $mode): string
{
    return match ($mode) {
        'cr' => 'EKFC z kreatinínu',
        'cys' => 'EKFC z cystatínu C',
        'cr_cys' => 'EKFC kombinovaná (kreatinín + cystatín C)',
        default => 'EKFC',
    };
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'eGFR podľa EKFC (full age spectrum) | Kalkulačky | Nefro-projekt Slovensko';
  $canonicalUrl = 'https://nefro.polascin.net/calculator_ekfc.php';
  $seoDescription =
      'Kalkulačka eGFR podľa rovnice EKFC (European Kidney Function Consortium) z kreatinínu, cystatínu C alebo kombinovane. Jediná rovnica pre vek 2 – 120 rokov, bez rasového koeficientu, s reškálovaním na Q hodnotu. Pre lekárov na Slovensku.';
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
    $headerTitle = 'Kalkulačka eGFR — EKFC';
    $headerIntro = 'European Kidney Function Consortium, vek 2 – 120 rokov';
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
                    plynulo pre celé vekové spektrum od 2 rokov — bez skoku pri prechode
                    z pediatrickej do dospelej nefrológie. V hornom pásme filtrácie
                    (&gt; 60 ml/min/1,73 m²) je spravidla presnejšia než CKD-EPI 2021, ktorá tam
                    GFR systematicky nadhodnocuje; to mení zaradenie do štádia CKD aj dávkovanie
                    liekov. Kombinovaná verzia (kreatinín + cystatín C) má najmenšie skreslenie.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — EKFC</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{eGFR} = 107{,}3 \times \left(\frac{\text{biomarker}}{Q}\right)^{\alpha} \times \begin{cases} 1 & \text{vek} \le 40 \\ 0{,}990^{(\text{vek}-40)} & \text{vek} > 40 \end{cases} \]</div>
                        <div class="calc-formula-line">\[ \alpha = \begin{cases} -0{,}322 & \text{ak } \text{biomarker}/Q < 1 \\ -1{,}132 & \text{ak } \text{biomarker}/Q \ge 1 \end{cases} \]</div>
                        <div class="calc-formula-line"><strong>Q pre kreatinín</strong> (µmol/L), vek 2 – 25 rokov:</div>
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
                                <small class="form-hint">EKFC je validovaná od 2 rokov (full age spectrum).</small>
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
                        <h3>Výsledok výpočtu — <?= htmlspecialchars(ekfcModeLabel((string) $calculated['mode'])) ?></h3>
                        <div class="calc-egfr-result-main">
                            <div class="calc-result-value-block">
                                <span class="calc-result-big-value"><?= htmlspecialchars(number_format((float) $calculated['egfr'], 1, ',', ' ')) ?></span>
                                <span class="calc-result-unit">ml/min/1,73 m²</span>
                                <span class="calc-result-unit">= <?= htmlspecialchars(number_format((float) $calculated['egfr'] / EGFR_ML_S_PER_ML_MIN, 3, ',', ' ')) ?> ml/s/1,73 m²</span>
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
                                    <br><em>Rozdiel medzi biomarkermi je <?= htmlspecialchars(number_format($gap, 1, ',', ' ')) ?> ml/min/1,73 m².
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
                                            : 'polynóm pre vek 2 – 25 rokov' ?>,
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
                                        = <?= htmlspecialchars(number_format((float) $calculated['egfr_cr'], 1, ',', ' ')) ?> ml/min/1,73 m²
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
                                        = <?= htmlspecialchars(number_format((float) $calculated['egfr_cys'], 1, ',', ' ')) ?> ml/min/1,73 m²
                                    </p>
                                <?php endif; ?>

                                <p>
                                    <strong>Veková korekcia:</strong>
                                    <?= (int) $calculated['age_years'] > 40
                                        ? '0,990<sup>(' . (int) $calculated['age_years'] . ' − 40)</sup> = ' . htmlspecialchars(number_format((float) $calculated['age_factor'], 4, ',', ' '))
                                        : 'vek ≤ 40 rokov → bez korekcie (faktor 1,0)' ?>
                                </p>
                            </div>
                        </details>

                        <?php if ($calculated['ckd_epi_2021'] !== null):
                            $delta = (float) $calculated['egfr'] - (float) $calculated['ckd_epi_2021'];
                            $ckdEpiCat = ckdGCategory((float) $calculated['ckd_epi_2021']);
                        ?>
                            <p class="calc-result-detail">
                                <strong>Porovnanie s CKD-EPI 2021 (kreatinín):</strong>
                                <?= htmlspecialchars(number_format((float) $calculated['ckd_epi_2021'], 1, ',', ' ')) ?> ml/min/1,73 m²
                                (<?= htmlspecialchars($ckdEpiCat) ?>)
                                &ensp;&bull;&ensp;rozdiel EKFC − CKD-EPI =
                                <?= htmlspecialchars(($delta >= 0 ? '+' : '−') . number_format(abs($delta), 1, ',', ' ')) ?> ml/min/1,73 m²
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
                    <strong>Obmedzenia:</strong> hodnoty Q sú kalibrované na európske populácie —
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
                    echo htmlspecialchars(number_format($egfrValue, 1, ',', ' ')) . ' ml/min/1,73 m²';
                    if ($category !== '') {
                        echo ' (' . htmlspecialchars($category) . ')';
                    }
                    if ($mode !== '') {
                        echo '<small class="d-block saved-meta">' . htmlspecialchars(ekfcModeLabel($mode)) . '</small>';
                    }
                }
            ); ?>
        </div>
    </main>
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime('patient_autofill.js') ?>" defer></script>
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
