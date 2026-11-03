<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: efluentová dávka CRRT.
 *
 * Cieľ dodanej dávky 20 až 25 mL/kg/h podľa KDIGO Clinical Practice Guideline
 * for Acute Kidney Injury (2012), odporúčanie 5.8.1. Výpočet nekoriguje prediluciu.
 * Očakávané hodnoty sú vypočítané ručne; wiring asserty pinujú spoločné funkcie.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function crrtRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function crrtRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    crrtRefTest(abs($expected - $actual) <= $tol, $message . ': očakávané ' . $expected . ', získané ' . $actual);
}

// CVVHDF: dialyzát 1500 + substitúcia 500 + UF 100 = 2100 mL/h, 70 kg → 30,0 mL/kg/h;
// výpadok 15 % → dodaná 25,5 mL/kg/h
$dose = calculatorCrrtEffluentDose(1500.0, 500.0, 100.0, 70.0, 15.0);
crrtRefApprox(2100.0, $dose['effluent'], 0.0001, 'Efluent');
crrtRefApprox(30.0, $dose['prescribed'], 0.0001, 'Predpísaná dávka');
crrtRefApprox(25.5, $dose['delivered'], 0.0001, 'Dodaná dávka');
crrtRefTest(crrtDoseLabel($dose['delivered']) === 'prijateľná rezerva', 'Dodaná 25,5 je prijateľná rezerva.');
crrtRefTest(crrtDoseClass($dose['delivered']) === 'risk-low', 'Dodaná 25,5 je bez rizika poddávkovania.');
// Bez výpadku sa dodaná rovná predpísanej
$noDowntime = calculatorCrrtEffluentDose(1000.0, 0.0, 50.0, 60.0, 0.0);
crrtRefApprox(17.5, $noDowntime['delivered'], 0.0001, 'CVVHD 1050 mL/h, 60 kg');
crrtRefTest(crrtDoseClass($noDowntime['delivered']) === 'risk-high', 'Dávka 17,5 je poddávkovanie.');
// Rovnaký predpis s 20 % výpadkom klesne z 25 na 20 mL/kg/h
crrtRefApprox(20.0, calculatorCrrtEffluentDose(1750.0, 0.0, 0.0, 70.0, 20.0)['delivered'], 0.0001, '25 mL/kg/h s 20 % výpadkom');

// Hranice pásiem: < 20 pod cieľom, 20 až 25 cieľ, nad 25 do 30 rezerva, nad 30 nad cieľom
crrtRefTest(crrtDoseLabel(19.9) === 'pod cieľom KDIGO', 'Dávka 19,9 je pod cieľom.');
crrtRefTest(crrtDoseLabel(20.0) === 'cieľové pásmo KDIGO', 'Dávka 20 je v cieli.');
crrtRefTest(crrtDoseLabel(25.0) === 'cieľové pásmo KDIGO', 'Dávka 25 je v cieli.');
crrtRefTest(crrtDoseLabel(30.0) === 'prijateľná rezerva', 'Dávka 30 je rezerva.');
crrtRefTest(crrtDoseLabel(30.1) === 'nad cieľom' && crrtDoseClass(30.1) === 'risk-moderate', 'Dávka nad 30 je nad cieľom.');

try {
    calculatorCrrtEffluentDose(1500.0, 500.0, 100.0, 0.0, 0.0);
    crrtRefTest(false, 'Nulová hmotnosť musí vyhodiť výnimku.');
} catch (InvalidArgumentException) {
    crrtRefTest(true, 'Nulová hmotnosť vyhodí výnimku.');
}

// Wiring
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_crrt.php');
crrtRefTest(str_contains($page, 'calculatorCrrtEffluentDose('), 'calculator_crrt.php musí volať calculatorCrrtEffluentDose.');
crrtRefTest(
    !str_contains($page, 'function crrtDose') && !str_contains($page, '/ (float) $weight'),
    'calculator_crrt.php nesmie mať vlastnú kópiu vzorca ani pásiem.',
);

echo "Clinical references (CRRT efluentová dávka): $checks PASS\n";
