<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: klírens kreatinínu, recirkulácia a klírens voľnej vody.
 *
 * Cockcroft–Gault: Cockcroft DW, Gault MH (Nephron 1976;16(1):31–41, PMID 1244564).
 * Recirkulácia: metóda troch vzoriek močoviny R = (P − A) / (P − V).
 * Voľná voda: klasický C_H2O = V − U_osm·V/P_osm; elektrolytový V·(1 − (U_Na + U_K)/P_Na).
 * Očakávané hodnoty sú vypočítané ručne z rovníc, nie z implementácie;
 * wiring asserty pinujú, že stránky nepoužívajú vlastnú kópiu vzorca.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function clearanceRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function clearanceRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    clearanceRefTest(
        abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . $actual,
    );
}

function clearanceRefThrows(callable $fn, string $message): void
{
    try {
        $fn();
    } catch (InvalidArgumentException) {
        clearanceRefTest(true, $message);

        return;
    }
    clearanceRefTest(false, $message);
}

// ─── Cockcroft–Gault ───
// Muž 60 r, 72 kg, S-kreat 1,0 mg/dL: 80 · 72 / 72 = 80 mL/min
clearanceRefApprox(80.0, calculatorCockcroftGault(60, 72.0, 1.0, 'male'), 0.001, 'CG muž');
// Žena s rovnakými údajmi: 80 · 0,85 = 68 mL/min
clearanceRefApprox(68.0, calculatorCockcroftGault(60, 72.0, 1.0, 'female'), 0.001, 'CG žena');
// 85 r, 60 kg, 150 µmol/L = 1,6968 mg/dL: 55 · 60 / (72 · 1,6968) = 27,01 mL/min
clearanceRefApprox(27.01, calculatorCockcroftGault(85, 60.0, creatinineUmolLToMgDl(150.0), 'male'), 0.01, 'CG starší muž z µmol/L');
clearanceRefThrows(static fn () => calculatorCockcroftGault(60, 72.0, 0.0, 'male'), 'CG s nulovým kreatinínom vyhodí výnimku.');

// ─── Recirkulácia ───
// P 100, A 90, V 30: 10 / 70 = 14,29 %
clearanceRefApprox(14.2857, calculatorUreaRecirculationPct(100.0, 90.0, 30.0), 0.001, 'Recirkulácia 14 %');
// A = P → 0 %
clearanceRefApprox(0.0, calculatorUreaRecirculationPct(20.0, 20.0, 8.0), 0.0001, 'Recirkulácia nulová');
// A > P → záporná surová hodnota (chyba odberu), orezanie robí stránka
clearanceRefTest(calculatorUreaRecirculationPct(20.0, 21.0, 8.0) < 0.0, 'A > P dá zápornú surovú hodnotu.');
clearanceRefThrows(static fn () => calculatorUreaRecirculationPct(20.0, 18.0, 20.0), 'P = V vyhodí výnimku.');
clearanceRefTest(recircClass(5.0) === 'risk-low' && recircClass(5.1) === 'risk-moderate', 'Hranica recirkulácie 5 %.');
clearanceRefTest(recircClass(10.0) === 'risk-moderate' && recircClass(10.1) === 'risk-high', 'Hranica recirkulácie 10 %.');
clearanceRefTest(recircLabel(14.3) === 'významná recirkulácia', 'Štítok významnej recirkulácie.');

// ─── Klírens voľnej vody ───
// 2000 mL za 24 h = 1,3889 mL/min; P_osm 280, U_osm 560 → C_osm 2,7778, C_H2O −1,3889
$fw = calculatorFreeWaterClearance(2000.0 / 1440.0, 560.0, 280.0);
clearanceRefApprox(2.7778, $fw['c_osm'], 0.0005, 'C_osm');
clearanceRefApprox(-1.3889, $fw['c_h2o'], 0.0005, 'C_H2O pri koncentrovanom moči');
// Izoosmotický moč → C_H2O = 0
clearanceRefApprox(0.0, calculatorFreeWaterClearance(1.0, 290.0, 290.0)['c_h2o'], 0.0001, 'C_H2O izoosmotický');
// U_Na 60 + U_K 40, P_Na 125 → 1,3889 · (1 − 0,8) = 0,2778 mL/min = 0,40 L/deň
$efwc = calculatorElectrolyteFreeWaterClearance(2000.0 / 1440.0, 60.0, 40.0, 125.0);
clearanceRefApprox(0.2778, $efwc, 0.0005, 'EFWC');
clearanceRefApprox(0.40, $efwc * 1.44, 0.001, 'EFWC v L/deň');
// U_Na + U_K > P_Na → záporný EFWC (retencia voľnej vody, napr. SIADH)
clearanceRefTest(calculatorElectrolyteFreeWaterClearance(1.0, 120.0, 60.0, 130.0) < 0.0, 'U_Na + U_K > P_Na dá záporný EFWC.');
clearanceRefTest(fwcClass(-0.51) === 'risk-high' && fwcClass(0.51) === 'risk-moderate' && fwcClass(0.0) === 'risk-low', 'Pásma EFWC.');
clearanceRefThrows(static fn () => calculatorElectrolyteFreeWaterClearance(1.0, 60.0, 40.0, 0.0), 'Nulové P_Na vyhodí výnimku.');

// ─── Wiring ───
$root = dirname(__DIR__);
$cgPage = (string) file_get_contents($root . '/calculator_cg.php');
clearanceRefTest(str_contains($cgPage, 'calculatorCockcroftGault('), 'calculator_cg.php musí volať calculatorCockcroftGault.');
clearanceRefTest(!str_contains($cgPage, '(140 - $ageYears)'), 'calculator_cg.php nesmie mať vlastnú kópiu vzorca.');
$recPage = (string) file_get_contents($root . '/calculator_recirculation.php');
clearanceRefTest(str_contains($recPage, 'calculatorUreaRecirculationPct('), 'calculator_recirculation.php musí volať spoločnú funkciu.');
clearanceRefTest(!str_contains($recPage, 'function recirc'), 'Pomocné funkcie recirkulácie patria do calculators_common.php.');
$fwPage = (string) file_get_contents($root . '/calculator_free_water.php');
clearanceRefTest(
    str_contains($fwPage, 'calculatorFreeWaterClearance(') && str_contains($fwPage, 'calculatorElectrolyteFreeWaterClearance('),
    'calculator_free_water.php musí volať spoločné funkcie.',
);
clearanceRefTest(!str_contains($fwPage, 'function fwc'), 'fwcClass patrí do calculators_common.php.');

echo "Clinical references (CG, recirkulácia, voľná voda): $checks PASS\n";
