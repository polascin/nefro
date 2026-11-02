<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: KFRE, EKFC, UACR, Mehran, G kategórie.
 *
 * Očakávané KFRE hodnoty sú zosúladené s oficiálnym nástrojom (rovnaké
 * prípady ako tools/test_ambulatory_calculator.php). EKFC/UACR/Mehran
 * chránia koeficienty a prahy pred tichou zmenou.
 */

require_once dirname(__DIR__) . '/calculators_common.php';
require_once dirname(__DIR__) . '/calculator_ekfc_logic.php';
require_once dirname(__DIR__) . '/ckd_risk_models.php';

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

// UACR vstup v mg/mmol: prevod × 8,84 → mg/g pred modelom (rovnako ako ambulantná).
$fromMmol = kfreRisk(60, 'male', 25.0, 300.0 / 8.84 * 8.84, false);
clinicalRefApprox(10.0, $fromMmol['risk_2yr'], 0.05, 'KFRE UACR mg/g konzistencia');

// ─── EKFC Q plateau a polynóm ───
clinicalRefApprox(80.0, ekfcQCreatinineUmol(50.0, 'male'), 1e-9, 'EKFC Q Cr muž >25');
clinicalRefApprox(62.0, ekfcQCreatinineUmol(50.0, 'female'), 1e-9, 'EKFC Q Cr žena >25');
clinicalRefApprox(0.83, ekfcQCystatin(40.0), 1e-9, 'EKFC Q Cys <50');
clinicalRefApprox(0.855, ekfcQCystatin(55.0), 1e-9, 'EKFC Q Cys 55');

// EKFC eGFR (zaokrúhlené na 0,1) — dospelí + dieťa + cystatín
$ekfcCases = [
    // age, sex, Cr µmol/L → eGFR
    [50, 'male', 88.4, 86.7],
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
clinicalRefApprox(100.0, round(calculatorUacrMgG(100.0, 8.84), 2), 0.05, 'UACR ≈100 mg/g');

$a1 = calculatorUacrACategory(1.0);
$a2 = calculatorUacrACategory(6.0);
$a2b = calculatorUacrACategory(30.0);
$a3 = calculatorUacrACategory(40.0);
clinicalRefTest($a1['stage'] === 'A1', 'UACR A1');
clinicalRefTest($a2['stage'] === 'A2', 'UACR A2');
clinicalRefTest($a2b['stage'] === 'A2', 'UACR A2 na hranici 30');
clinicalRefTest($a3['stage'] === 'A3', 'UACR A3');

// Prevod mg/dL albumínu → mg/L (×10) a kreatinínu mg/dL → mmol/L (×0,0884)
$albMgL = 3.0 * 10; // 3 mg/dL
$crMmol = 100.0 * 0.0884; // 100 mg/dL
$fromUnits = calculatorUacrMgMmol($albMgL, $crMmol);
clinicalRefApprox(30.0 / 8.84, $fromUnits, 0.01, 'UACR jednotky mg/dL→základ');

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
    str_contains($mehranSrc, 'mehranRenalPoints')
        && !preg_match('/function\s+mehranRenalPoints\s*\(/', $mehranSrc),
    'calculator_mehran.php musí volať spoločný mehranRenalPoints',
);
clinicalRefTest(
    str_contains($ekfcPageSrc, 'calculator_ekfc_logic.php'),
    'calculator_ekfc.php musí načítavať calculator_ekfc_logic.php',
);

echo "Clinical references (KFRE/EKFC/UACR/Mehran/G): $checks PASS\n";
