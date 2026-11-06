<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: CKD-PC (Tangri gfrdecline40) a CKM (AHA 2023).
 *
 * CKD-PC riziká sú zosúladené s oficiálnym ckdpcrisk.org/gfrdecline40
 * (rovnaké scenáre ako tools/test_ambulatory_calculator.php, 1. 9. 2026).
 * CKM pinuje hierarchiu ckmComputeStage a slovné štítky; prahy BMI / very-high
 * v calculator_ckm.php sú kontrolované wiring assertom.
 */

require_once dirname(__DIR__) . '/calculators_common.php';
require_once dirname(__DIR__) . '/ckd_risk_models.php';

$checks = 0;

function ckdpcCkmRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function ckdpcCkmRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    ckdpcCkmRefTest(
        abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . $actual,
    );
}

// ─── CKD-PC (ckdpcrisk.org/gfrdecline40) ───
// age, sex, eGFR, UACR mg/g, DM, SBP, antiHTN, HF, CHD, AFib, BMI, smoking, HbA1c, insulin, oralDm → risk_3yr %
$ckdpcScenarios = [
    [1.9, [60, 'male', 85.0, 30.0, true, 130.0, false, false, false, false, 30.0, 'never', 7.0, false, false]],
    [0.4, [45, 'female', 70.0, 10.0, false, 120.0, false, false, false, false, 24.0, 'never', 7.0, false, false]],
    [28.6, [70, 'male', 40.0, 300.0, false, 145.0, true, true, true, false, 28.0, 'former', 7.0, false, false]],
    [36.4, [55, 'female', 35.0, 500.0, true, 150.0, true, false, true, true, 32.0, 'current', 9.0, true, false]],
];

foreach ($ckdpcScenarios as $index => [$expected, $arguments]) {
    $result = ckdpcRisk(...$arguments);
    ckdpcCkmRefApprox($expected, (float) $result['risk_3yr'], 0.05, 'CKD-PC scenár ' . ($index + 1));
}

$ckdpcEgfr60Dm = ckdpcRisk(60, 'male', 60.0, 30.0, true, 130.0, false, false, false, false, 30.0, 'never', 7.0, false, false);
ckdpcCkmRefApprox(3.3, (float) $ckdpcEgfr60Dm['risk_3yr'], 0.05, 'CKD-PC eGFR 60 DM priemer');
ckdpcCkmRefTest(
    $ckdpcEgfr60Dm['model_name'] === 'DM, priemer submodelov eGFR ≥60 a <60',
    'CKD-PC model_name pri eGFR 60 + DM',
);

$ckdpcEgfr60NoDm = ckdpcRisk(60, 'female', 60.0, 10.0, false, 120.0, false, false, false, false, 24.0, 'never', 7.0, false, false);
ckdpcCkmRefTest(
    $ckdpcEgfr60NoDm['model_name'] === 'Bez DM, priemer submodelov eGFR ≥60 a <60',
    'CKD-PC model_name pri eGFR 60 bez DM',
);

$ckdpcHigh = ckdpcRisk(70, 'male', 40.0, 300.0, false, 145.0, true, true, true, false, 28.0, 'former', 7.0, false, false);
ckdpcCkmRefTest(
    $ckdpcHigh['model_name'] === 'Bez DM, eGFR < 60 ml/min/1,73 m²',
    'CKD-PC model_name eGFR < 60 bez DM',
);

$ckdpcLow = ckdpcRisk(45, 'female', 70.0, 10.0, false, 120.0, false, false, false, false, 24.0, 'never', 7.0, false, false);
ckdpcCkmRefTest(
    $ckdpcLow['model_name'] === 'Bez DM, eGFR ≥ 60 ml/min/1,73 m²',
    'CKD-PC model_name eGFR ≥ 60 bez DM',
);

$ckdpcDmHighEgfr = ckdpcRisk(60, 'male', 85.0, 30.0, true, 130.0, false, false, false, false, 30.0, 'never', 7.0, false, false);
ckdpcCkmRefTest(
    $ckdpcDmHighEgfr['model_name'] === 'DM, eGFR ≥ 60 ml/min/1,73 m²',
    'CKD-PC model_name eGFR ≥ 60 + DM',
);

// ─── CKM AHA 2023: hierarchia ckmComputeStage ───
// Poradie argumentov: adiposity, dysAdiposity, metabolicRF, ckdModHigh,
// ckdVeryHigh, subclinicalCvd, clinicalCvd, kidneyFailure
$ckmCases = [
    // code, num, flags...
    ['0', 0, false, false, false, false, false, false, false, false],
    ['1', 1, true, false, false, false, false, false, false, false],
    ['1', 1, false, true, false, false, false, false, false, false],
    ['2', 2, true, true, true, false, false, false, false, false],
    ['2', 2, false, false, false, true, false, false, false, false],
    ['3', 3, true, true, true, true, false, true, false, false],
    ['3', 3, false, false, false, false, true, false, false, false],
    ['3', 3, false, false, false, false, false, false, false, true], // KF samotné → very-high path cez caller; tu KF bez clinical = 0, ak ckdVeryHigh false
    ['4a', 4, false, false, false, false, false, false, true, false],
    ['4b', 4, false, false, false, false, false, false, true, true],
    // Klinické KV vyhráva nad subklinickým a CKD very-high
    ['4a', 4, true, true, true, true, true, true, true, false],
    ['4b', 4, true, true, true, true, true, true, true, true],
    // Subklinické / CKD very-high vyhráva nad metabolickými RF
    ['3', 3, true, true, true, true, true, false, false, false],
];

foreach ($ckmCases as $index => $row) {
    [$code, $num, $adip, $dys, $met, $ckdMod, $ckdVh, $sub, $clin, $kf] = $row;
    // Špeciál: samotné kidneyFailure bez clinicalCvd a bez ckdVeryHigh → stage 0
    // (kalkulačka nastaví ckdVeryHigh = veryhigh || kidneyFailure pred volaním).
    if ($index === 7) {
        $stage = ckmComputeStage(false, false, false, false, false, false, false, true);
        ckdpcCkmRefTest($stage['code'] === '0' && $stage['num'] === 0, 'CKM KF bez clinical/very-high → 0 (caller musí nastaviť very-high)');
        continue;
    }
    $stage = ckmComputeStage($adip, $dys, $met, $ckdMod, $ckdVh, $sub, $clin, $kf);
    ckdpcCkmRefTest(
        $stage['code'] === $code && $stage['num'] === $num,
        'CKM scenár ' . ($index + 1) . ': očakávané ' . $code . '/' . $num .
        ', získané ' . $stage['code'] . '/' . $stage['num'],
    );
}

// Caller kontrakt calculator_ckm: kidneyFailure ⇒ ckdVeryHigh ⇒ stage 3 (bez clinical CVD)
$kfAsVeryHigh = ckmComputeStage(false, false, false, false, true, false, false, true);
ckdpcCkmRefTest(
    $kfAsVeryHigh['code'] === '3' && $kfAsVeryHigh['num'] === 3,
    'CKM KF so ckdVeryHigh (ako calculator_ckm) → 3',
);

$labels = [
    ['0', 'bez rizikových faktorov CKM'],
    ['1', 'nadmerná / dysfunkčná adipozita'],
    ['2', 'metabolické rizikové faktory a/alebo CKD'],
    ['3', 'subklinické KV ochorenie alebo veľmi vysoké riziko CKD'],
    ['4a', 'klinické KV ochorenie (bez zlyhania obličiek)'],
    ['4b', 'klinické KV ochorenie so zlyhaním obličiek'],
];
foreach ($labels as [$code, $label]) {
    ckdpcCkmRefTest(ckmStageLabel($code) === $label, 'CKM label ' . $code);
}

ckdpcCkmRefTest(ckmStageClass(0) === 'risk-low' && ckmStageClass(1) === 'risk-low', 'CKM štádium 0–1: risk-low');
ckdpcCkmRefTest(ckmStageClass(2) === 'risk-moderate', 'CKM štádium 2: risk-moderate');
ckdpcCkmRefTest(ckmStageClass(3) === 'risk-high' && ckmStageClass(4) === 'risk-high', 'CKM štádium 3–4: risk-high');

// Wiring: BMI prahy a KF→very-high v calculator_ckm.php (AHA / AHA-asian 23)
$ckmSource = (string) file_get_contents(dirname(__DIR__) . '/calculator_ckm.php');
ckdpcCkmRefTest(
    str_contains($ckmSource, '$isAsian ? 23.0 : 25.0'),
    'calculator_ckm.php musí mať BMI prah 23 (ázijský) / 25 (všeobecný)',
);
ckdpcCkmRefTest(
    str_contains($ckmSource, '$ckdRisk === "veryhigh" || $kidneyFailure'),
    'calculator_ckm.php musí mapovať zlyhanie obličiek na ckdVeryHigh',
);
ckdpcCkmRefTest(
    str_contains($ckmSource, 'ckmStageClass(') && !str_contains($ckmSource, 'function ckmStageClass'),
    'calculator_ckm.php volá ckmStageClass z calculators_common.php',
);

// CKD-PC interpretácia: pásma 5 / 10 / 20 % (správanie + wiring)
$ckdpcLow = ckdpcInterpretation(4.9);
ckdpcCkmRefTest(
    $ckdpcLow['warnings'] === [] && str_contains($ckdpcLow['interpretation'][0], 'nízke riziko'),
    'CKD-PC < 5 %: nízke riziko bez varovania',
);
$ckdpcMid = ckdpcInterpretation(5.0);
ckdpcCkmRefTest(
    $ckdpcMid['warnings'] === [] && str_contains($ckdpcMid['interpretation'][0], 'stredne zvýšené'),
    'CKD-PC 5–<10 %: stredne zvýšené bez varovania',
);
$ckdpcElevated = ckdpcInterpretation(10.0);
ckdpcCkmRefTest(
    count($ckdpcElevated['warnings']) === 1
        && str_contains($ckdpcElevated['interpretation'][0], 'zvýšené riziko progresie CKD')
        && str_contains($ckdpcElevated['warnings'][0], 'Riziko ≥10 %'),
    'CKD-PC 10–<20 %: zvýšené riziko + varovanie ≥10 %',
);
$ckdpcHigh = ckdpcInterpretation(20.0);
ckdpcCkmRefTest(
    count($ckdpcHigh['warnings']) === 1
        && str_contains($ckdpcHigh['interpretation'][0], 'vysoké riziko')
        && str_contains($ckdpcHigh['warnings'][0], 'Riziko ≥20 %'),
    'CKD-PC ≥20 %: vysoké riziko + varovanie ≥20 %',
);

$ckdpcSource = (string) file_get_contents(dirname(__DIR__) . '/calculator_ckdpc.php');
$ckdpcCommonSource = (string) file_get_contents(dirname(__DIR__) . '/calculators_common.php');
ckdpcCkmRefTest(
    str_contains($ckdpcCommonSource, '$risk3yr < 5.0')
        && str_contains($ckdpcCommonSource, '$risk3yr < 10.0')
        && str_contains($ckdpcCommonSource, '$risk3yr < 20.0'),
    'calculators_common.php musí mať CKD-PC interpretačné prahy 5 / 10 / 20 %',
);
ckdpcCkmRefTest(
    str_contains($ckdpcSource, 'ckdpcInterpretation(') && !str_contains($ckdpcSource, 'function ckdpcInterpretation'),
    'calculator_ckdpc.php volá ckdpcInterpretation z calculators_common.php',
);

// ─── Label helpery (zobrazenie vstupov CKD-PC) ───
ckdpcCkmRefTest(calculatorBoolLabel(true) === 'Áno', 'calculatorBoolLabel(true) = Áno');
ckdpcCkmRefTest(calculatorBoolLabel(false) === 'Nie', 'calculatorBoolLabel(false) = Nie');
ckdpcCkmRefTest(calculatorSexLabel('male') === 'Muž', 'calculatorSexLabel(male) = Muž');
ckdpcCkmRefTest(calculatorSexLabel('female') === 'Žena', 'calculatorSexLabel(female) = Žena');
ckdpcCkmRefTest(calculatorSexLabel('other') === 'Žena', 'calculatorSexLabel(other) pinuje CKD-PC default Žena');
ckdpcCkmRefTest(calculatorSmokingLabel('current') === 'Fajčí', 'calculatorSmokingLabel(current) = Fajčí');
ckdpcCkmRefTest(calculatorSmokingLabel('former') === 'Ex-fajčiar', 'calculatorSmokingLabel(former) = Ex-fajčiar');
ckdpcCkmRefTest(calculatorSmokingLabel('never') === 'Nefajčí', 'calculatorSmokingLabel(never) = Nefajčí');
ckdpcCkmRefTest(calculatorSmokingLabel('') === 'Nefajčí', 'calculatorSmokingLabel(empty) pinuje CKD-PC default Nefajčí');
ckdpcCkmRefTest(
    str_contains($ckdpcSource, 'calculatorBoolLabel(')
        && str_contains($ckdpcSource, 'calculatorSexLabel(')
        && str_contains($ckdpcSource, 'calculatorSmokingLabel(')
        && !str_contains($ckdpcSource, 'function boolLabel')
        && !str_contains($ckdpcSource, 'function sexLabel')
        && !str_contains($ckdpcSource, 'function smokingLabel')
        && !str_contains($ckdpcSource, 'function calculatorBoolLabel')
        && !str_contains($ckdpcSource, 'function calculatorSexLabel')
        && !str_contains($ckdpcSource, 'function calculatorSmokingLabel'),
    'calculator_ckdpc.php volá label helpery z calculators_common.php',
);
ckdpcCkmRefTest(
    str_contains($ckdpcCommonSource, 'function calculatorBoolLabel')
        && str_contains($ckdpcCommonSource, 'function calculatorSexLabel')
        && str_contains($ckdpcCommonSource, 'function calculatorSmokingLabel'),
    'calculators_common.php definuje calculatorBool/Sex/SmokingLabel',
);

echo "Clinical references (CKD-PC/CKM): $checks PASS\n";
