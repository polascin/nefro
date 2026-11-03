<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: sklon eGFR (regresia najmenších štvorcov) a korigovaný vápnik.
 *
 * Sklon: hranica rýchlej progresie > 5 mL/min/1,73 m² za rok (KDIGO).
 * Vápnik: Ca + 0,02 · (40 − albumín [g/L]); Payne a kol. (Br Med J 1973;4(5893):643–646,
 * PMID 4758544) odvodili v mg/dL koeficient 1,0, kalkulačka používa bežný tvar 0,8 mg/dL.
 * Očakávané hodnoty sú vypočítané ručne; wiring asserty pinujú spoločné funkcie.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function trendCaRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function trendCaRefApprox(float $expected, ?float $actual, float $tol, string $message): void
{
    trendCaRefTest(
        $actual !== null && abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . var_export($actual, true),
    );
}

// ─── Sklon eGFR ───
// Presne lineárny pokles 60 → 55 → 50 za 2 roky: −5,0
trendCaRefApprox(-5.0, calculatorOlsSlope([0.0, 1.0, 2.0], [60.0, 55.0, 50.0]), 0.0001, 'Lineárny pokles');
// Štyri body (0;60) (1;57) (2;55) (3;50): Σ(x−x̄)(y−ȳ) = −16, Σ(x−x̄)² = 5 → −3,2
trendCaRefApprox(-3.2, calculatorOlsSlope([0.0, 1.0, 2.0, 3.0], [60.0, 57.0, 55.0, 50.0]), 0.0001, 'Regresia 4 bodov');
// Poradie bodov výsledok nemení
trendCaRefApprox(-3.2, calculatorOlsSlope([3.0, 0.0, 2.0, 1.0], [50.0, 60.0, 55.0, 57.0]), 0.0001, 'Nezávislosť od poradia');
// Dva body: sklon = rozdiel / čas; pol roka a pokles o 4 → −8 za rok
trendCaRefApprox(-8.0, calculatorOlsSlope([0.0, 0.5], [40.0, 36.0]), 0.0001, 'Dva body');
trendCaRefTest(calculatorOlsSlope([0.0], [60.0]) === null, 'Jeden bod nedáva sklon.');
trendCaRefTest(calculatorOlsSlope([1.0, 1.0], [60.0, 50.0]) === null, 'Rovnaký čas nedáva sklon.');
trendCaRefTest(calculatorOlsSlope([0.0, 1.0], [60.0]) === null, 'Rôzny počet x a y nedáva sklon.');

// Pásma hodnotenia
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(-5.1), 'Rýchla progresia'), 'Pokles > 5/rok je rýchla progresia.');
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(-5.0), 'Stredne rýchla'), 'Pokles presne 5/rok ešte nie je rýchly.');
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(-2.1), 'Stredne rýchla'), 'Pokles 2,1/rok je stredne rýchly.');
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(-2.0), 'Pomalá progresia'), 'Pokles 2/rok je pomalý.');
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(0.0), 'Pomalá progresia'), 'Nulový sklon je v pásme pomalej progresie.');
trendCaRefTest(str_starts_with(egfrSlopeInterpretation(0.5), 'eGFR sa v čase zlepšuje'), 'Kladný sklon je zlepšenie.');

// ─── Korigovaný vápnik ───
// Ca 2,00 mmol/L, albumín 25 g/L: 2,00 + 0,02 · 15 = 2,30
trendCaRefApprox(2.30, calculatorCorrectedCalcium(2.00, 25.0), 0.0001, 'Hypoalbuminémia');
trendCaRefApprox(2.40, calculatorCorrectedCalcium(2.40, 40.0), 0.0001, 'Albumín 40 g/L korekciu nemení');
trendCaRefApprox(2.30, calculatorCorrectedCalcium(2.40, 45.0), 0.0001, 'Hyperalbuminémia znižuje korigovanú hodnotu');
// 0,02 mmol/L na g/L = 0,8 mg/dL na g/dL (1 mmol/L Ca = 4,008 mg/dL; 1 g/dL = 10 g/L)
trendCaRefApprox(0.8, 0.02 * 10.0 * 4.008, 0.01, 'Ekvivalencia koeficientu s 0,8 mg/dL');

// ─── Wiring ───
$root = dirname(__DIR__);
$slopePage = (string) file_get_contents($root . '/calculator_egfr_slope.php');
trendCaRefTest(
    str_contains($slopePage, 'calculatorOlsSlope(') && str_contains($slopePage, 'egfrSlopeInterpretation('),
    'calculator_egfr_slope.php musí volať spoločné funkcie.',
);
trendCaRefTest(!str_contains($slopePage, 'function calculateSlope'), 'calculator_egfr_slope.php nesmie mať vlastnú regresiu.');
$caPage = (string) file_get_contents($root . '/calculator_ca.php');
trendCaRefTest(str_contains($caPage, 'calculatorCorrectedCalcium('), 'calculator_ca.php musí volať calculatorCorrectedCalcium.');
trendCaRefTest(!str_contains($caPage, '0.02 * (40'), 'calculator_ca.php nesmie mať vlastnú kópiu vzorca.');

echo "Clinical references (sklon eGFR, korigovaný vápnik): $checks PASS\n";
