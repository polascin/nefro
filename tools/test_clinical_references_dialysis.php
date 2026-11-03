<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: dialyzačná dávka a príjem bielkovín.
 *
 * Kt/V: Daugirdas II (J Am Soc Nephrol 1993;4(5):1205–1213, PMID 8305648).
 * TBW: Watson PE, Watson ID, Batt RD (Am J Clin Nutr 1980;33(1):27–39, PMID 6986753).
 * nPCR: Sargent a Gotch, anurický pacient, normalizácia na V/0,58.
 * Očakávané hodnoty sú vypočítané nezávisle z publikovaných rovníc
 * (ručne/Python), nie z implementácie; wiring asserty pinujú, že stránky
 * kalkulačiek používajú tieto spoločné funkcie a nie vlastnú kópiu vzorca.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function dialysisRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function dialysisRefApprox(float $expected, ?float $actual, float $tol, string $message): void
{
    dialysisRefTest(
        $actual !== null && abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . var_export($actual, true),
    );
}

// ─── Kt/V Daugirdas II ───
// R = 0,30; t = 4 h; UF = 3 L; W = 70 kg → −ln(0,268) + 2,95 · 3/70 = 1,4432
dialysisRefApprox(1.4432, calculatorKtvDaugirdas2(0.30, 4.0, 3.0, 70.0), 0.0005, 'Kt/V s UF');
// Bez UF zostáva iba logaritmický člen: R = 0,35; t = 3,5 h → −ln(0,322) = 1,1332
dialysisRefApprox(1.1332, calculatorKtvDaugirdas2(0.35, 3.5, 0.0, 70.0), 0.0005, 'Kt/V bez UF');
// UF zvyšuje Kt/V (konvektívny člen je kladný pre R < 4/3)
dialysisRefTest(
    (float) calculatorKtvDaugirdas2(0.30, 4.0, 3.0, 70.0) > (float) calculatorKtvDaugirdas2(0.30, 4.0, 0.0, 70.0),
    'UF musí zvýšiť Kt/V.',
);
// R − 0,008·t ≤ 0 → logaritmus nedefinovaný
dialysisRefTest(calculatorKtvDaugirdas2(0.03, 4.0, 2.0, 70.0) === null, 'R − 0,008·t ≤ 0 musí vrátiť null.');
dialysisRefTest(calculatorKtvDaugirdas2(0.032, 4.0, 2.0, 70.0) === null, 'Hranica R − 0,008·t = 0 musí vrátiť null.');
dialysisRefTest(calculatorKtvDaugirdas2(0.30, 4.0, 2.0, 0.0) === null, 'Nulová hmotnosť musí vrátiť null.');

// ─── Watson TBW ───
// Muž 50 r, 175 cm, 75 kg: 2,447 − 4,758 + 18,795 + 25,215 = 41,699 L
dialysisRefApprox(41.699, npcrWatsonTbw('male', 50, 175.0, 75.0), 0.001, 'Watson TBW muž');
// Žena 165 cm, 60 kg (vek v rovnici nefiguruje): −2,097 + 17,6385 + 14,796 = 30,3375 L
dialysisRefApprox(30.3375, npcrWatsonTbw('female', 50, 165.0, 60.0), 0.001, 'Watson TBW žena');
dialysisRefTest(
    npcrWatsonTbw('female', 30, 165.0, 60.0) === npcrWatsonTbw('female', 80, 165.0, 60.0),
    'Watson TBW žena nesmie závisieť od veku.',
);

// ─── Prepočet močoviny ───
// 1 mmol/L močoviny = 2,8 mg/dL dusíka močoviny (2 × 14,007 / 10)
dialysisRefApprox(70.0, npcrToBunMgDl(25.0, 'mmol_l'), 0.0001, 'Urea 25 mmol/L → BUN');
dialysisRefApprox(70.0, npcrToBunMgDl(70.0, 'bun_mg_dl'), 0.0001, 'BUN mg/dL bez prepočtu');

// ─── nPCR Sargent–Gotch ───
// BUN 70 → po predošlej HD 25 mg/dL, V 41,699 L, 44 h: G = 7,1078 mg/min,
// PCR = 78,717 g/deň, nPCR = 0,58 · 78,717 / 41,699 = 1,0949 g/kg/deň
$npcr44 = npcrSargentGotch(70.0, 25.0, 41.699, 44.0);
dialysisRefApprox(7.1078, $npcr44['g_mg_min'], 0.0005, 'G 44 h');
dialysisRefApprox(78.717, $npcr44['pcr'], 0.001, 'PCR 44 h');
dialysisRefApprox(1.0949, $npcr44['npcr'], 0.0005, 'nPCR 44 h');
// Víkendový interval 68 h, urea 25 a 9 mmol/L, V 30,3375 L → 0,7660 g/kg/deň
dialysisRefApprox(
    0.7660,
    npcrSargentGotch(npcrToBunMgDl(25.0, 'mmol_l'), npcrToBunMgDl(9.0, 'mmol_l'), 30.3375, 68.0)['npcr'],
    0.0005,
    'nPCR 68 h z mmol/L',
);

// ─── Pásma nPCR ───
dialysisRefTest(npcrCategory(0.79)[0] === 'risk-high', 'nPCR < 0,8 je nízky príjem.');
dialysisRefTest(npcrCategory(0.80)[0] === 'risk-moderate', 'nPCR 0,8 je hraničný.');
dialysisRefTest(npcrCategory(1.00)[0] === 'risk-low', 'nPCR 1,0 je v cieli.');
dialysisRefTest(npcrCategory(1.40)[0] === 'risk-low', 'nPCR 1,4 je v cieli.');
dialysisRefTest(npcrCategory(1.41)[0] === 'risk-moderate', 'nPCR > 1,4 je vysoký.');

// ─── Wiring: stránky používajú spoločné funkcie ───
$root = dirname(__DIR__);
$ktvPage = (string) file_get_contents($root . '/calculator_ktv.php');
dialysisRefTest(str_contains($ktvPage, 'calculatorKtvDaugirdas2('), 'calculator_ktv.php musí volať calculatorKtvDaugirdas2.');
dialysisRefTest(!str_contains($ktvPage, '-log('), 'calculator_ktv.php nesmie mať vlastnú kópiu Daugirdasovej rovnice.');
$npcrPage = (string) file_get_contents($root . '/calculator_npcr.php');
dialysisRefTest(str_contains($npcrPage, 'npcrSargentGotch('), 'calculator_npcr.php musí volať npcrSargentGotch.');
dialysisRefTest(!str_contains($npcrPage, '9.35'), 'calculator_npcr.php nesmie mať vlastnú kópiu Sargent–Gotch rovnice.');
dialysisRefTest(!str_contains($npcrPage, 'function npcr'), 'Pomocné nPCR funkcie patria do calculators_common.php.');

echo "Clinical references (Kt/V, Watson, nPCR): $checks PASS\n";
