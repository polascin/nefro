<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: meraný klírens kreatinínu, Du Bois BSA a poruchy nátria.
 *
 * Adrogué HJ, Madias NE: Hypernatremia (N Engl J Med 2000;342(20):1493–1499, PMID 10816188)
 * a Hyponatremia (N Engl J Med 2000;342(21):1581–1589, PMID 10824078).
 * Katz MA (N Engl J Med 1973;289(16):843–844, PMID 4763428); Hillier TA a kol.
 * (Am J Med 1999;106(4):399–403, PMID 10225241). Du Bois D, Du Bois EF (1916).
 * Očakávané hodnoty sú vypočítané ručne z rovníc; wiring asserty pinujú,
 * že stránky nepoužívajú vlastnú kópiu vzorca.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function sodiumRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function sodiumRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    sodiumRefTest(
        abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . $actual,
    );
}

// ─── Meraný klírens kreatinínu ───
// U_cr 10 mmol/L, P_cr 100 µmol/L, 1500 mL za 24 h: (113,12 · 1500) / (1,1312 · 1440) = 104,17 mL/min
$uCr = crclCreatinineToMgDl(10.0, 'mmol_l');
$pCr = crclCreatinineToMgDl(100.0, 'umol_l');
sodiumRefApprox(113.122, $uCr, 0.001, 'U_cr 10 mmol/L → mg/dL');
sodiumRefApprox(1.13122, $pCr, 0.00001, 'P_cr 100 µmol/L → mg/dL');
sodiumRefApprox(1.0, crclCreatinineToMgDl(1.0, 'mg_dl'), 0.0, 'mg/dL bez prepočtu');
sodiumRefApprox(104.1667, calculatorMeasuredCreatinineClearance($uCr, 1500.0, $pCr, 24.0), 0.001, 'Meraný CrCl 24 h');
// Jednotky sa krátia: rovnaký výsledok priamo v mmol/L a µmol/L/1000
sodiumRefApprox(104.1667, calculatorMeasuredCreatinineClearance(10.0, 1500.0, 0.1, 24.0), 0.001, 'CrCl nezávisí od jednotky');
// Polovičný čas zberu pri rovnakom objeme zdvojnásobí klírens
sodiumRefApprox(208.3333, calculatorMeasuredCreatinineClearance(10.0, 1500.0, 0.1, 12.0), 0.001, 'CrCl 12 h');

// ─── Du Bois BSA ───
// 175 cm, 75 kg → 1,9031 m²
$bsa = calculatorBsaDuBois(175.0, 75.0);
sodiumRefApprox(1.9031, $bsa, 0.0005, 'Du Bois BSA');
// Normalizácia na 1,73 m²: 104,17 · 1,73 / 1,9031 = 94,69
sodiumRefApprox(94.69, 104.1667 * 1.73 / $bsa, 0.01, 'CrCl na 1,73 m²');

// ─── Celková telesná voda ───
sodiumRefTest(calculatorTbwFraction('male', 64) === 0.6, 'Muž < 65 r: 0,6.');
sodiumRefTest(calculatorTbwFraction('male', 65) === 0.5, 'Muž od 65 r: 0,5.');
sodiumRefTest(calculatorTbwFraction('female', 64) === 0.5, 'Žena < 65 r: 0,5.');
sodiumRefTest(calculatorTbwFraction('female', 65) === 0.45, 'Žena od 65 r: 0,45.');

// ─── Deficit voľnej vody ───
// Muž 70 kg (TBW 42 L), S-Na 160, cieľ 140: 42 · (160/140 − 1) = 6,0 L
sodiumRefApprox(6.0, calculatorFreeWaterDeficit(42.0, 160.0, 140.0), 0.0001, 'Deficit voľnej vody');
sodiumRefApprox(0.0, calculatorFreeWaterDeficit(42.0, 140.0, 140.0), 0.0001, 'Deficit pri cieľovom Na');

// ─── Adrogué–Madias ───
// S-Na 110, TBW 42 L: 0,9 % NaCl (154) → +1,02 mmol/L; 3 % NaCl (513) → +9,37 mmol/L
sodiumRefApprox(1.0233, calculatorAdrogueMadias(154.0, 0.0, 110.0, 42.0), 0.0005, 'Adrogué–Madias 0,9 % NaCl');
sodiumRefApprox(9.3721, calculatorAdrogueMadias(513.0, 0.0, 110.0, 42.0), 0.0005, 'Adrogué–Madias 3 % NaCl');
// Draslík v infúzii sa započítava ako katión: 0,9 % NaCl + 20 mmol KCl → +1,49 mmol/L
sodiumRefApprox(1.4884, calculatorAdrogueMadias(154.0, 20.0, 110.0, 42.0), 0.0005, 'Adrogué–Madias s KCl');
// Hypotonický roztok pri hypernatrémii znižuje Na: 5 % glukóza, S-Na 160 → −3,72 mmol/L
sodiumRefApprox(-3.7209, calculatorAdrogueMadias(0.0, 0.0, 160.0, 42.0), 0.0005, 'Adrogué–Madias 5 % glukóza');

// ─── Korekcia nátria na hyperglykémiu ───
// S-Na 125, glykémia 600 mg/dL: Katz 125 + 1,6 · 5 = 133; Hillier 125 + 2,4 · 5 = 137
sodiumRefApprox(133.0, calculatorSodiumGlucoseCorrection(125.0, 600.0, 1.6), 0.0001, 'Katz');
sodiumRefApprox(137.0, calculatorSodiumGlucoseCorrection(125.0, 600.0, 2.4), 0.0001, 'Hillier');
// 33,3 mmol/L glukózy · 18,0182 = 600 mg/dL
sodiumRefApprox(600.0, 33.3 * 18.0182, 0.01, 'Prepočet glykémie mmol/L → mg/dL');

// ─── Wiring ───
$root = dirname(__DIR__);
$crclPage = (string) file_get_contents($root . '/calculator_crcl_24h.php');
sodiumRefTest(
    str_contains($crclPage, 'calculatorMeasuredCreatinineClearance(') && str_contains($crclPage, 'calculatorBsaDuBois('),
    'calculator_crcl_24h.php musí volať spoločné funkcie.',
);
sodiumRefTest(!str_contains($crclPage, '0.007184') && !str_contains($crclPage, 'function crcl'), 'calculator_crcl_24h.php nesmie mať vlastnú kópiu vzorca.');
$naPage = (string) file_get_contents($root . '/calculator_na.php');
foreach (['calculatorTbwFraction(', 'calculatorFreeWaterDeficit(', 'calculatorAdrogueMadias(', 'calculatorSodiumGlucoseCorrection('] as $fn) {
    sodiumRefTest(str_contains($naPage, $fn), 'calculator_na.php musí volať ' . $fn);
}
sodiumRefTest(!str_contains($naPage, '/ ($tbw + 1)'), 'calculator_na.php nesmie mať vlastnú kópiu Adrogué–Madias.');

echo "Clinical references (CrCl 24 h, BSA, nátrium): $checks PASS\n";
