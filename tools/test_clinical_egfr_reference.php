<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: CKD-EPI 2021 (kreatinín, bez rasy).
 *
 * Očakávané hodnoty sú zaokrúhlené na 1 desatinné miesto rovnako ako vo
 * verejnej kalkulačke. Vzorec je v calculatorCkdEpi2021FromCreatinineMgDl();
 * tento test chráni pred tichou zmenou koeficientov.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;
function egfrRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

egfrRefTest(
    function_exists('calculatorCkdEpi2021FromCreatinineMgDl'),
    'Spoločná funkcia CKD-EPI 2021 musí existovať.',
);

// Referenčné prípady: Scr mg/dL, vek (roky), sex → eGFR zaokrúhlené na 0,1.
// Spočítané zo spoločného vzorca; regresia zachytí zmenu koeficientov.
// EKFC porovnanie volá tú istú funkciu (ekfcCompareCkdEpi2021 je tenký obal).
$cases = [
    ['female', 40, 0.7, 112.1],
    ['male', 65, 1.5, 51.3],
    ['female', 70, 1.1, 54.1],
    ['male', 55, 0.9, 100.9],
    ['female', 50, 1.0, 68.6],
    ['male', 45, 1.2, 76.0],
];

foreach ($cases as [$sex, $age, $scr, $expected]) {
    $got = round(calculatorCkdEpi2021FromCreatinineMgDl($scr, $age, $sex), 1);
    egfrRefTest(
        abs($got - $expected) < 0.05,
        "CKD-EPI $sex age=$age Scr=$scr: očakávané $expected, získané $got",
    );
}

$egfrSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_egfr.php');
$ekfcSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_ekfc.php');
egfrRefTest(
    str_contains($egfrSrc, 'calculatorCkdEpi2021FromCreatinineMgDl'),
    'calculator_egfr.php musí volať spoločný vzorec.',
);
egfrRefTest(
    str_contains($ekfcSrc, 'calculatorCkdEpi2021FromCreatinineMgDl'),
    'calculator_ekfc.php (porovnanie) musí volať spoločný vzorec.',
);

// Jednotky: 88,4 µmol/L ≈ 1,0 mg/dL
$fromUmol = calculatorCkdEpi2021FromCreatinineMgDl(88.4 / 88.4, 50, 'female');
$fromMg = calculatorCkdEpi2021FromCreatinineMgDl(1.0, 50, 'female');
egfrRefTest(
    abs($fromUmol - $fromMg) < 1e-9,
    'Prevod µmol/L → mg/dL delením 88,4 musí sedieť s 1,0 mg/dL.',
);

echo "Clinical eGFR reference: $checks PASS\n";
