<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: Furstov pomer a frakčné exkrécie (FENa, FEurea).
 *
 * Furst H a kol. (Am J Med Sci 2000;319(4):240–244, PMID 10768609).
 * Carvounis CP a kol. (Kidney Int 2002;62(6):2223–2229, PMID 12427149).
 * Očakávané hodnoty sú vypočítané ručne; wiring asserty pinujú spoločné funkcie.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function urineIdxRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function urineIdxRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    urineIdxRefTest(abs($expected - $actual) <= $tol, $message . ': očakávané ' . $expected . ', získané ' . $actual);
}

function urineIdxRefThrows(callable $fn, string $message): void
{
    try {
        $fn();
    } catch (InvalidArgumentException) {
        urineIdxRefTest(true, $message);

        return;
    }
    urineIdxRefTest(false, $message);
}

// ─── Furstov pomer ───
// U_Na 80 + U_K 40, S_Na 125 → 0,96 (prísna reštrikcia)
urineIdxRefApprox(0.96, calculatorFurstRatio(80.0, 40.0, 125.0), 0.0001, 'Furst 0,96');
urineIdxRefTest(furstClass(0.96) === 'risk-moderate', 'Pomer 0,96 je prísna reštrikcia.');
// Hranice: < 0,5 účinná reštrikcia < 1 L; 0,5 až 1,0 prísna < 500 mL; > 1,0 neúčinná
urineIdxRefTest(furstClass(0.49) === 'risk-low', 'Pomer 0,49: reštrikcia < 1000 mL účinná.');
urineIdxRefTest(furstClass(calculatorFurstRatio(50.0, 20.0, 140.0)) === 'risk-moderate', 'Pomer presne 0,5 je prísna reštrikcia.');
urineIdxRefTest(furstClass(1.0) === 'risk-moderate', 'Pomer presne 1,0 je ešte prísna reštrikcia.');
urineIdxRefTest(furstClass(1.01) === 'risk-high', 'Pomer > 1,0: reštrikcia neúčinná.');
urineIdxRefTest(furstLabel(1.2) === 'reštrikcia tekutín neúčinná', 'Štítok pomeru > 1.');
urineIdxRefThrows(static fn () => calculatorFurstRatio(80.0, 40.0, 0.0), 'Nulový S_Na vyhodí výnimku.');

// ─── Frakčná exkrécia ───
// Prerenálne: U_Na 20, S_Na 140, U_cr 10 mmol/L, S_cr 0,2 mmol/L → (20 · 0,2) / (140 · 10) · 100 = 0,286 %
$fenaPre = calculatorFractionalExcretion(20.0, 140.0, 10.0, 0.2);
urineIdxRefApprox(0.2857, $fenaPre, 0.0005, 'FENa prerenálne');
urineIdxRefTest(str_starts_with(akiFenaInterpretation($fenaPre), 'Prerenálne'), 'FENa 0,29 % je prerenálne.');
// ATN: U_Na 60, S_Na 135, U_cr 4, S_cr 0,35 → 21 / 540 · 100 = 3,889 %
$fenaAtn = calculatorFractionalExcretion(60.0, 135.0, 4.0, 0.35);
urineIdxRefApprox(3.8889, $fenaAtn, 0.0005, 'FENa ATN');
urineIdxRefTest(str_starts_with(akiFenaInterpretation($fenaAtn), 'Akútna tubulárna'), 'FENa 3,9 % je ATN.');
urineIdxRefTest(str_starts_with(akiFenaInterpretation(1.0), 'Hraničná'), 'FENa presne 1 % je hraničná.');
urineIdxRefTest(str_starts_with(akiFenaInterpretation(2.0), 'Hraničná'), 'FENa presne 2 % je hraničná.');
// FEurea: U_urea 300, S_urea 30, U_cr 10, S_cr 0,2 → 60 / 300 · 100 = 20 %
$feurea = calculatorFractionalExcretion(300.0, 30.0, 10.0, 0.2);
urineIdxRefApprox(20.0, $feurea, 0.0001, 'FEurea prerenálne');
urineIdxRefTest(str_starts_with(akiFeureaInterpretation($feurea), 'Prerenálne'), 'FEurea 20 % je prerenálne.');
urineIdxRefTest(str_starts_with(akiFeureaInterpretation(50.1), 'Akútna tubulárna'), 'FEurea > 50 % je ATN.');
urineIdxRefTest(str_starts_with(akiFeureaInterpretation(35.0), 'Hraničná'), 'FEurea presne 35 % je v kalkulačke hraničná.');
// Prepočet U_cr z mg/dL; jednotky kreatinínu sa krátia
urineIdxRefApprox(
    calculatorFractionalExcretion(20.0, 140.0, creatinineMgDlToMmolL(100.0), 0.2),
    calculatorFractionalExcretion(20.0, 140.0, 100.0, creatinineUmolLToMgDl(0.2 * 1000.0)),
    0.0001,
    'FENa nezávisí od jednotky kreatinínu',
);
urineIdxRefThrows(static fn () => calculatorFractionalExcretion(20.0, 140.0, 0.0, 0.2), 'Nulový U_cr vyhodí výnimku.');

// ─── Wiring ───
$root = dirname(__DIR__);
$furstPage = (string) file_get_contents($root . '/calculator_furst.php');
urineIdxRefTest(str_contains($furstPage, 'calculatorFurstRatio('), 'calculator_furst.php musí volať calculatorFurstRatio.');
urineIdxRefTest(!str_contains($furstPage, 'function furstClass') && !str_contains($furstPage, 'function furstLabel'), 'Pomocné Furst funkcie patria do calculators_common.php.');
$akiPage = (string) file_get_contents($root . '/calculator_aki.php');
urineIdxRefTest(
    substr_count($akiPage, 'calculatorFractionalExcretion(') === 2
        && str_contains($akiPage, 'akiFenaInterpretation(')
        && str_contains($akiPage, 'akiFeureaInterpretation('),
    'calculator_aki.php musí volať spoločné funkcie pre FENa aj FEurea.',
);
urineIdxRefTest(!str_contains($akiPage, '* 100.0;'), 'calculator_aki.php nesmie mať vlastnú kópiu vzorca.');

echo "Clinical references (Furst, FENa, FEurea): $checks PASS\n";
