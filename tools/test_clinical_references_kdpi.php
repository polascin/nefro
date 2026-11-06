<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: KDRI_Rao (donor-only; základ KDPI).
 *
 * Rao PS a kol. (Transplantation 2009;88(2):231–236, PMID 19623019). Koeficienty
 * donor-only modelu používané OPTN (Guide to Calculating and Interpreting the KDPI):
 * vek 0,0128 (+ úpravy < 18 / > 50), výška −0,0464/10 cm, hmotnosť < 80 kg −0,0199/5 kg,
 * afroamerický pôvod 0,1790, HTN 0,1260, DM 0,1300, CVA 0,0881, kreatinín 0,2200
 * (nad 1,5: −0,2090), HCV 0,2400, DCD 0,1330. Referenčný darca (vek 40, 170 cm,
 * ≥ 80 kg, Scr 1,0 mg/dL, bez AA/HTN/DM/CVA/HCV/DCD) má KDRI = 1,00.
 * OPTN stropuje Scr na 8,0 mg/dL. KDPI percentil tu netestujeme (ročná tabuľka OPTN).
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function kdpiRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function kdpiRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    kdpiRefTest(abs($expected - $actual) <= $tol, $message . ': očakávané ' . $expected . ', získané ' . $actual);
}

// Referenčný darca: xbeta = 0, KDRI = 1
$refX = kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, false);
kdpiRefApprox(0.0, $refX, 1e-12, 'Referenčný darca má xbeta = 0.');
kdpiRefApprox(1.0, kdriRao(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Referenčný darca má KDRI = 1.');
// Hmotnosť ≥ 80 kg neprispieva (hranica 80 je rovnaká ako > 80)
kdpiRefApprox(
    kdriRao(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, false),
    kdriRao(40.0, 170.0, 100.0, 1.0, false, false, false, false, false, false),
    1e-12,
    'Hmotnosť 80 a 100 kg dávajú rovnaký KDRI.',
);

// Jednotlivé koeficienty (izolované voči referencii)
kdpiRefApprox(0.0128 * 10.0, kdriXbeta(50.0, 170.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Vek 50: len lineárny člen.');
kdpiRefApprox(
    0.0128 * 15.0 + 0.0107 * 5.0,
    kdriXbeta(55.0, 170.0, 80.0, 1.0, false, false, false, false, false, false),
    1e-12,
    'Vek 55: lineárny + člen > 50.',
);
kdpiRefApprox(
    0.0128 * (10.0 - 40.0) + (-0.0194) * (10.0 - 18.0),
    kdriXbeta(10.0, 170.0, 80.0, 1.0, false, false, false, false, false, false),
    1e-12,
    'Vek 10: lineárny + člen < 18.',
);
kdpiRefApprox(-0.0464, kdriXbeta(40.0, 180.0, 80.0, 1.0, false, false, false, false, false, false), 1e-12, 'Výška +10 cm.');
kdpiRefApprox(
    -0.0199 * (70.0 - 80.0) / 5.0,
    kdriXbeta(40.0, 170.0, 70.0, 1.0, false, false, false, false, false, false),
    1e-12,
    'Hmotnosť 70 kg.',
);
kdpiRefApprox(0.1790, kdriXbeta(40.0, 170.0, 80.0, 1.0, true, false, false, false, false, false), 1e-12, 'Afroamerický pôvod.');
kdpiRefApprox(0.1260, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, true, false, false, false, false), 1e-12, 'Hypertenzia.');
kdpiRefApprox(0.1300, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, true, false, false, false), 1e-12, 'Diabetes.');
kdpiRefApprox(0.0881, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, true, false, false), 1e-12, 'CVA.');
kdpiRefApprox(0.2400, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, false, true, false), 1e-12, 'HCV.');
kdpiRefApprox(0.1330, kdriXbeta(40.0, 170.0, 80.0, 1.0, false, false, false, false, false, true), 1e-12, 'DCD.');
kdpiRefApprox(0.2200 * 0.5, kdriXbeta(40.0, 170.0, 80.0, 1.5, false, false, false, false, false, false), 1e-12, 'Kreatinín 1,5: len lineárny člen.');
kdpiRefApprox(
    0.2200 * 1.0 + (-0.2090) * 0.5,
    kdriXbeta(40.0, 170.0, 80.0, 2.0, false, false, false, false, false, false),
    1e-12,
    'Kreatinín 2,0: lineárny + korekcia nad 1,5.',
);

// OPTN strop Scr 8,0 mg/dL
$atCap = kdriXbeta(40.0, 170.0, 80.0, 8.0, false, false, false, false, false, false);
$aboveCap = kdriXbeta(40.0, 170.0, 80.0, 12.0, false, false, false, false, false, false);
kdpiRefApprox($atCap, $aboveCap, 1e-12, 'Scr nad 8,0 mg/dL sa stropuje.');

// Monotónnosť: vyšší vek (v pásme > 50) zvyšuje KDRI
kdpiRefTest(
    kdriRao(60.0, 170.0, 80.0, 1.0, false, false, false, false, false, false)
        > kdriRao(55.0, 170.0, 80.0, 1.0, false, false, false, false, false, false),
    'Vyšší vek > 50 zvyšuje KDRI.',
);

// Rizikové pásma UI
kdpiRefTest(kdriRiskClass(0.99) === 'risk-low' && kdriRiskLabel(0.99) === 'nižšie riziko než referenčný darca', 'KDRI < 1.');
kdpiRefTest(kdriRiskClass(1.0) === 'risk-moderate' && kdriRiskClass(1.44) === 'risk-moderate', 'KDRI 1 až < 1,45.');
kdpiRefTest(kdriRiskClass(1.45) === 'risk-high' && str_contains(kdriRiskLabel(1.45), 'vyššie'), 'KDRI ≥ 1,45.');

// Parser vstupov
kdpiRefTest(calculatorParseNonNegativeFloat('1,5') === 1.5 && calculatorParseNonNegativeFloat('') === null && calculatorParseNonNegativeFloat('-1') === null, 'Parser nezáporných čísel.');

// Wiring a citácia
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_kdpi.php');
kdpiRefTest(str_contains($page, 'kdriXbeta('), 'calculator_kdpi.php musí volať kdriXbeta.');
kdpiRefTest(
    !str_contains($page, 'function kdriXbeta') && !str_contains($page, 'function kdriRiskClass'),
    'calculator_kdpi.php nesmie mať vlastnú kópiu logiky.',
);
kdpiRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/19623019/')
        && str_contains($page, 'Transplantation 2009;88(2):231')
        && str_contains($page, 'optn.transplant.hrsa.gov'),
    'Citácia Rao 2009 + odkaz OPTN.',
);
kdpiRefTest(
    str_contains($page, 'KDPI percentil') && str_contains($page, 'neuvádzame'),
    'Stránka vysvetľuje, prečo KDPI percentil nepočíta.',
);

echo "Clinical references (KDRI/KDPI Rao OPTN): $checks PASS\n";
