<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: KDRI podľa Rao 2009 (len darcovské faktory).
 *
 * Rao PS a kol. (Transplantation 2009;88(2):231–236, PMID 19623019); koeficienty
 * zhodné s predhovorom OPTN/SRTR Annual Data Report 2024. Vzorový príklad z článku:
 * 45-ročný hypertonik s hmotnosťou 65 kg, inak referenčný darca → KDRI ≈ 1,28.
 * Pozor: OPTN od 31. 10. 2024 používa iný model (bez rasy a HCV); tento test pinuje
 * súčasnú implementáciu Rao 2009, nie aktuálny výpočet OPTN.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function kdriRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function kdriRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    kdriRefTest(abs($expected - $actual) <= $tol, $message . ': očakávané ' . $expected . ', získané ' . $actual);
}

// Referenčný darca: vek 40, 170 cm, 80 kg, kreatinín 1,0, bez rizikových faktorov → KDRI 1,00
kdriRefApprox(0.0, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Referenčný darca');
// Rao 2009, príklad v texte: 45 r, hypertonik, 65 kg → 0,0128·5 + 0,126 + 0,0199·3 = 0,2497; e^0,2497 = 1,2837
$x = kdriXbeta(45.0, 170.0, 65.0, 1.0, false, true, false, false, false, false);
kdriRefApprox(0.2497, $x, 1e-9, 'Rao 2009 príklad, Xβ');
kdriRefApprox(1.28, round(exp($x), 2), 1e-9, 'Rao 2009 príklad, KDRI 1,28');

// Vekové úseky: < 18 r a > 50 r majú doplnkové sklony
kdriRefApprox(0.0128 * -30 - 0.0194 * -8, kdriXbeta(10.0, 170.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Vek 10 r');
kdriRefApprox(0.0128 * 25 + 0.0107 * 15, kdriXbeta(65.0, 170.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Vek 65 r');
// Hmotnosť ≥ 80 kg nemá vplyv
kdriRefTest(
    kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, false)
        === kdriXbeta(40.0, 170.0, 110.0, 1.0, false, false, false, false, false, false),
    'Hmotnosť nad 80 kg nemení KDRI.',
);
// Kreatinín: lomená závislosť pri 1,5 mg/dL a strop 8 mg/dL podľa OPTN
kdriRefApprox(0.22 * 1.0 - 0.209 * 0.5, kdriXbeta(40.0, 170.0, 80.0, 2.0, false, false, false, false, false, false), 1e-12, 'Kreatinín 2,0');
kdriRefTest(
    kdriXbeta(40.0, 170.0, 80.0, 8.0, false, false, false, false, false, false)
        === kdriXbeta(40.0, 170.0, 80.0, 15.0, false, false, false, false, false, false),
    'Kreatinín nad 8 mg/dL sa stropuje.',
);
// Binárne faktory
$flags = [[true, false, false, false, false, false, 0.179], [false, true, false, false, false, false, 0.126], [false, false, true, false, false, false, 0.130],
    [false, false, false, true, false, false, 0.0881], [false, false, false, false, true, false, 0.240], [false, false, false, false, false, true, 0.133]];
foreach ($flags as [$aa, $htn, $dm, $cva, $hcv, $dcd, $beta]) {
    kdriRefApprox($beta, kdriXbeta(40.0, 170.0, 80.0, 1.0, $aa, $htn, $dm, $cva, $hcv, $dcd), 1e-12, "Koeficient {$beta}");
}

// Wiring
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_kdpi.php');
kdriRefTest(str_contains($page, 'kdriXbeta(') && !str_contains($page, 'function kdriXbeta'), 'calculator_kdpi.php volá spoločnú kdriXbeta.');

echo "Clinical references (KDRI Rao 2009): $checks PASS\n";
