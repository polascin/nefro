<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: KFRE, EKFC, UACR, Mehran, G kategórie, PREVENT.
 *
 * Očakávané KFRE hodnoty sú zosúladené s oficiálnym nástrojom (rovnaké
 * prípady ako tools/test_ambulatory_calculator.php). EKFC/UACR/Mehran
 * chránia koeficienty a prahy pred tichou zmenou. PREVENT golden case je
 * oficiálny preventr README príklad (zhoda s ACC/AHA kalkulátorom).
 */

require_once dirname(__DIR__) . '/calculators_common.php';
require_once dirname(__DIR__) . '/calculator_ekfc_logic.php';
require_once dirname(__DIR__) . '/ckd_risk_models.php';
require_once dirname(__DIR__) . '/prevent_model.php';

$checks = 0;

function clinicalRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function clinicalRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    clinicalRefTest(
        abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . $actual,
    );
}

// ─── KFRE (Tangri 4-premenná; NA = North America, non-NA = ostatné) ───
// Referenčné riziká v %; zaokrúhlené na 0,1 ako vo verejnej kalkulačke.
$kfreCases = [
    // age, sex, eGFR, UACR mg/g, isNA, risk2yr, risk5yr
    [60, 'male', 25.0, 300.0, false, 10.0, 33.5],
    [55, 'female', 15.0, 1000.0, false, 38.2, 84.5],
    [70, 'male', 40.0, 150.0, false, 1.2, 4.4],
    [50, 'female', 30.0, 500.0, false, 7.1, 24.9],
    [60, 'male', 25.0, 300.0, true, 14.6, 38.8],
];

foreach ($kfreCases as $i => [$age, $sex, $egfr, $uacr, $isNa, $r2, $r5]) {
    $result = kfreRisk($age, $sex, $egfr, $uacr, $isNa);
    clinicalRefApprox($r2, $result['risk_2yr'], 0.05, 'KFRE #' . ($i + 1) . ' 2yr');
    clinicalRefApprox($r5, $result['risk_5yr'], 0.05, 'KFRE #' . ($i + 1) . ' 5yr');
}

// UACR vstup v mg/mmol: prevod UACR_MG_G_PER_MG_MMOL → mg/g pred modelom.
$fromMmol = kfreRisk(60, 'male', 25.0, uacrMgMmolToMgG(uacrMgGToMgMmol(300.0)), false);
clinicalRefApprox(10.0, $fromMmol['risk_2yr'], 0.05, 'KFRE UACR mg/g konzistencia');

// ─── EKFC Q plateau a polynóm ───
clinicalRefApprox(80.0, ekfcQCreatinineUmol(50.0, 'male'), 1e-9, 'EKFC Q Cr muž >25');
clinicalRefApprox(62.0, ekfcQCreatinineUmol(50.0, 'female'), 1e-9, 'EKFC Q Cr žena >25');
clinicalRefApprox(0.83, ekfcQCystatin(40.0), 1e-9, 'EKFC Q Cys <50');
clinicalRefApprox(0.855, ekfcQCystatin(55.0), 1e-9, 'EKFC Q Cys 55');

// EKFC eGFR (zaokrúhlené na 0,1) — dospelí + dieťa + cystatín
$ekfcCases = [
    // age, sex, Cr µmol/L → eGFR
    [50, 'male', CREATININE_UMOL_PER_MGDL, 86.7],
    [60, 'female', 70.0, 76.5],
    [35, 'male', 100.0, 83.3],
    [70, 'female', 150.0, 29.2],
    [10, 'male', 50.0, 100.7],
];
foreach ($ekfcCases as [$age, $sex, $cr, $expected]) {
    $q = ekfcQCreatinineUmol((float) $age, $sex);
    $got = round(ekfcCore($cr, $q, (float) $age)['egfr'], 1);
    clinicalRefApprox($expected, $got, 0.05, "EKFC Cr age=$age sex=$sex");
}

$cysNorm = round(ekfcCore(0.83, ekfcQCystatin(30.0), 30.0)['egfr'], 1);
clinicalRefApprox(107.3, $cysNorm, 0.05, 'EKFC Cys pri Q (pomer=1)');

$cys55 = round(ekfcCore(1.0, ekfcQCystatin(55.0), 55.0)['egfr'], 1);
clinicalRefApprox(77.3, $cys55, 0.05, 'EKFC Cys 55y 1.0 mg/L');

// Exponent: pomer < 1 → −0,322; ≥ 1 → −1,132
$below = ekfcCore(40.0, 80.0, 30.0);
$above = ekfcCore(100.0, 80.0, 30.0);
clinicalRefApprox(-0.322, $below['exponent'], 1e-9, 'EKFC exponent pod Q');
clinicalRefApprox(-1.132, $above['exponent'], 1e-9, 'EKFC exponent nad Q');

// ─── UACR ───
clinicalRefApprox(6.0, calculatorUacrMgMmol(30.0, 5.0), 1e-9, 'UACR 30/5 mg/mmol');
clinicalRefApprox(53.04, round(calculatorUacrMgG(30.0, 5.0), 2), 0.005, 'UACR 30/5 mg/g');

// 100 mg/g pri kreatiníne 8,84 mmol/L ≈ albumín 100 mg/L
clinicalRefApprox(100.0, round(calculatorUacrMgG(100.0, UACR_MG_G_PER_MG_MMOL), 2), 0.05, 'UACR ≈100 mg/g');

$a1 = calculatorUacrACategory(1.0);
$a2 = calculatorUacrACategory(6.0);
$a2b = calculatorUacrACategory(30.0);
$a3 = calculatorUacrACategory(40.0);
clinicalRefTest($a1['stage'] === 'A1', 'UACR A1');
clinicalRefTest($a2['stage'] === 'A2', 'UACR A2');
clinicalRefTest($a2b['stage'] === 'A2', 'UACR A2 na hranici 30');
clinicalRefTest($a3['stage'] === 'A3', 'UACR A3');

// Prevod mg/dL albumínu → mg/L (massConcGdlToGl) a kreatinínu mg/dL → mmol/L
$albMgL = massConcGdlToGl(3.0); // 3 mg/dL → 30 mg/L
$crMmol = creatinineMgDlToMmolL(100.0); // 100 mg/dL
$fromUnits = calculatorUacrMgMmol($albMgL, $crMmol);
clinicalRefApprox(uacrMgGToMgMmol(30.0), $fromUnits, 0.01, 'UACR jednotky mg/dL→základ');
clinicalRefApprox(30.0, $albMgL, 0.0, 'UACR albumín 3 mg/dL → 30 mg/L cez massConcGdlToGl');
// Prevod g/L albumínu → mg/L (massConcGlToMgl)
$albFromGl = massConcGlToMgl(0.03); // 0,03 g/L → 30 mg/L
clinicalRefApprox(30.0, $albFromGl, 0.0, 'UACR albumín 0,03 g/L → 30 mg/L cez massConcGlToMgl');
clinicalRefApprox(
    calculatorUacrMgMmol($albMgL, $crMmol),
    calculatorUacrMgMmol($albFromGl, $crMmol),
    1e-12,
    'UACR mg/dL a g/L vstupy dávajú rovnaký výsledok',
);

// ─── KDIGO G kategórie ───
// Páry [eGFR, kategória]: float kľúče v asociatívnom poli PHPStan odmieta (array.invalidKey).
$gCases = [
    [95.0, 'G1'],
    [90.0, 'G1'],
    [75.0, 'G2'],
    [60.0, 'G2'],
    [50.0, 'G3a'],
    [45.0, 'G3a'],
    [35.0, 'G3b'],
    [30.0, 'G3b'],
    [20.0, 'G4'],
    [15.0, 'G4'],
    [10.0, 'G5'],
];
foreach ($gCases as [$egfr, $cat]) {
    clinicalRefTest(
        ckdGCategory($egfr) === $cat,
        "G kategória eGFR=$egfr → $cat (získané " . ckdGCategory($egfr) . ')',
    );
}

// ─── Mehran renálne body + rizikové pásma ───
clinicalRefTest(mehranRenalPoints(60.0) === 0, 'Mehran renal ≥60 → 0');
clinicalRefTest(mehranRenalPoints(50.0) === 2, 'Mehran renal 40–59 → 2');
clinicalRefTest(mehranRenalPoints(40.0) === 2, 'Mehran renal hranica 40 → 2');
clinicalRefTest(mehranRenalPoints(30.0) === 4, 'Mehran renal 20–39 → 4');
clinicalRefTest(mehranRenalPoints(20.0) === 4, 'Mehran renal hranica 20 → 4');
clinicalRefTest(mehranRenalPoints(15.0) === 6, 'Mehran renal <20 → 6');

[$cls, $label] = mehranCategory(3);
clinicalRefTest($cls === 'risk-low' && $label === 'Nízke riziko', 'Mehran ≤5 nízke');
[$cls] = mehranCategory(8);
clinicalRefTest($cls === 'risk-moderate', 'Mehran 6–10 stredné');
[$cls] = mehranCategory(12);
clinicalRefTest($cls === 'risk-high', 'Mehran 11–15 vysoké');
[$cls] = mehranCategory(16);
clinicalRefTest($cls === 'risk-very-high', 'Mehran ≥16 veľmi vysoké');

// ─── Zapojenie stránok na spoločné helpery ───
$uacrSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_uacr.php');
$mehranSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_mehran.php');
$ekfcPageSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_ekfc.php');
clinicalRefTest(
    str_contains($uacrSrc, 'calculatorUacrACategory'),
    'calculator_uacr.php musí používať calculatorUacrACategory',
);
clinicalRefTest(
    str_contains($mehranSrc, 'mehranScore(')
        && !preg_match('/function\s+mehranScore\s*\(/', $mehranSrc)
        && !preg_match('/function\s+mehranRenalPoints\s*\(/', $mehranSrc),
    'calculator_mehran.php musí volať spoločný mehranScore',
);
clinicalRefTest(
    str_contains($ekfcPageSrc, 'calculator_ekfc_logic.php'),
    'calculator_ekfc.php musí načítavať calculator_ekfc_logic.php',
);
$unitsSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_units.php');
clinicalRefTest(
    str_contains($unitsSrc, 'calculatorUnitConversionRows()')
        && !preg_match('/\$unitRows\s*=\s*\[/', $unitsSrc),
    'calculator_units.php musí volať calculatorUnitConversionRows()',
);
$crFactor = calculatorUnitFactorByName('Kreatinín');
clinicalRefTest(
    $crFactor !== null && abs($crFactor['factor'] - CREATININE_UMOL_PER_MGDL) < 1e-12,
    'Prevodník: kreatinín faktor 88,4',
);
clinicalRefApprox(
    CREATININE_UMOL_PER_MGDL,
    calculatorConvertConventionalToSi(1.0, $crFactor['factor']),
    1e-9,
    'Prevodník: 1 mg/dL kreatinínu → 88,4 µmol/L',
);
clinicalRefApprox(
    CREATININE_UMOL_PER_MGDL,
    creatinineMgDlToUmolL(1.0),
    1e-12,
    'creatinineMgDlToUmolL(1)',
);

// ─── PREVENT AHA 2024 (preventr README / ACC/AHA golden case) ───
$preventBase = [
    'age' => 50,
    'sex' => 'female',
    'total_c' => 200.0,
    'hdl_c' => 45.0,
    'chol_unit' => 'mgdl',
    'sbp' => 160.0,
    'bp_tx' => true,
    'statin' => false,
    'dm' => true,
    'smoking' => false,
    'bmi' => 35.0,
    'egfr' => 90.0,
];
$preventOut = preventComputeAll($preventBase);
clinicalRefTest($preventOut['model'] === 'base', 'PREVENT bez voliteľných → base');
clinicalRefTest($preventOut['show_30yr'] === true, 'PREVENT vek 50 → 30r áno');
clinicalRefApprox(14.7, (float) $preventOut['risks']['total_cvd']['10yr'], 0.05, 'PREVENT 10r total CVD');
clinicalRefApprox(9.2, (float) $preventOut['risks']['ascvd']['10yr'], 0.05, 'PREVENT 10r ASCVD');
clinicalRefApprox(8.1, (float) $preventOut['risks']['heart_failure']['10yr'], 0.05, 'PREVENT 10r HF');
clinicalRefApprox(53.0, (float) $preventOut['risks']['total_cvd']['30yr'], 0.05, 'PREVENT 30r total CVD');
clinicalRefApprox(35.4, (float) $preventOut['risks']['ascvd']['30yr'], 0.05, 'PREVENT 30r ASCVD');
clinicalRefApprox(39.0, (float) $preventOut['risks']['heart_failure']['30yr'], 0.05, 'PREVENT 30r HF');

$preventUacr = preventComputeAll($preventBase + ['uacr' => 300.0]);
clinicalRefTest($preventUacr['model'] === 'uacr', 'PREVENT s UACR → uacr variant');
clinicalRefApprox(13.0, (float) $preventUacr['risks']['ascvd']['10yr'], 0.05, 'PREVENT UACR 300 → 10r ASCVD 13,0');

clinicalRefTest(preventSelectModel(false, false, false) === 'base', 'PREVENT select base');
clinicalRefTest(preventSelectModel(true, false, false) === 'uacr', 'PREVENT select uacr');
clinicalRefTest(preventSelectModel(false, true, false) === 'hba1c', 'PREVENT select hba1c');
clinicalRefTest(preventSelectModel(false, false, true) === 'sdi', 'PREVENT select sdi');
clinicalRefTest(preventSelectModel(true, true, false) === 'full', 'PREVENT select full');

$age60 = preventComputeAll(array_merge($preventBase, ['age' => 60]));
clinicalRefTest($age60['show_30yr'] === false, 'PREVENT vek 60 → 30r nie');
clinicalRefTest($age60['risks']['ascvd']['30yr'] === null, 'PREVENT vek 60 → 30r ASCVD null');

clinicalRefTest(preventRiskClass(2.9) === 'risk-low', 'PREVENT class <3');
clinicalRefTest(preventRiskClass(3.0) === 'risk-moderate', 'PREVENT class 3–5');
clinicalRefTest(preventRiskClass(5.0) === 'risk-high', 'PREVENT class 5–10');
clinicalRefTest(preventRiskClass(10.0) === 'risk-very-high', 'PREVENT class ≥10');

$interp = preventInterpretation(9.2);
clinicalRefTest($interp['css'] === 'risk-high', 'PREVENT interpretácia 9,2 → high');
clinicalRefTest(str_contains($interp['category'], 'Stredné riziko'), 'PREVENT interpretácia kategória 5–10');

$preventPageSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_prevent.php');
clinicalRefTest(
    str_contains($preventPageSrc, 'prevent_model.php')
        && str_contains($preventPageSrc, 'preventComputeAll'),
    'calculator_prevent.php musí používať prevent_model.php',
);

echo "Clinical references (KFRE/EKFC/UACR/Mehran/G/PREVENT): $checks PASS\n";
