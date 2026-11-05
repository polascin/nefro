<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: CKD-EPI 2021 (kreatinín aj kreatinín–cystatín C).
 *
 * Očakávané hodnoty sú zaokrúhlené na 1 desatinné miesto rovnako ako vo
 * verejných kalkulačkách. Vzorce sú v calculatorCkdEpi2021FromCreatinineMgDl()
 * a calculatorCkdEpi2021FromCreatinineCystatinMgDl(); tento test chráni pred
 * tichou zmenou koeficientov. Citácia: Inker LA et al., N Engl J Med
 * 2021;385(19):1737–1749, PMID 34554658.
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
    'Spoločná funkcia CKD-EPI 2021 (kreatinín) musí existovať.',
);
egfrRefTest(
    function_exists('calculatorCkdEpi2021FromCreatinineCystatinMgDl'),
    'Spoločná funkcia CKD-EPI 2021 (kreatinín–cystatín C) musí existovať.',
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
        "CKD-EPI cr $sex age=$age Scr=$scr: očakávané $expected, získané $got",
    );
}

// Kreatinín–cystatín C 2021: Scr mg/dL, Scys mg/L, vek, sex → eGFR na 0,1.
// Koeficienty pinované podľa Inker 2021 (κ/α, 0,8, −0,544/−0,323/−0,778, 0,9961, 0,963).
$crCysCases = [
    ['female', 40, 0.7, 0.8, 111.2],
    ['male', 65, 1.5, 1.5, 48.6],
    ['female', 70, 1.1, 1.2, 56.4],
    ['male', 55, 0.9, 0.9, 99.4],
    ['female', 50, 1.0, 1.0, 74.0],
    ['male', 45, 1.2, 1.1, 75.6],
    ['female', 60, 0.8, 0.7, 99.8],
    ['male', 30, 1.0, 0.8, 113.4],
    ['female', 50, 0.7, 0.8, 106.9],
    ['male', 50, 0.9, 0.8, 111.0],
];

foreach ($crCysCases as [$sex, $age, $scr, $scys, $expected]) {
    $got = round(
        calculatorCkdEpi2021FromCreatinineCystatinMgDl($scr, $scys, $age, $sex),
        1,
    );
    egfrRefTest(
        abs($got - $expected) < 0.05,
        "CKD-EPI cr-cys $sex age=$age Scr=$scr Scys=$scys: očakávané $expected, získané $got",
    );
}

// Hranice G kategórie cez spoločnú funkciu (stránka už neudržiava kópiu).
egfrRefTest(ckdGCategory(111.2) === 'G1', 'eGFR 111,2 → G1');
egfrRefTest(ckdGCategory(74.0) === 'G2', 'eGFR 74 → G2');
egfrRefTest(ckdGCategory(48.6) === 'G3a', 'eGFR 48,6 → G3a');
egfrRefTest(
    ckdGCategoryDescription('G2') === 'mierne znížená filtrácia',
    'Popis G2 musí sedieť so spoločnou mapou.',
);

$egfrSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_egfr.php');
$egfrCysSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_egfr_cys.php');
$ekfcSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_ekfc.php');
$ekfcLogicSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_ekfc_logic.php');
egfrRefTest(
    str_contains($egfrSrc, 'calculatorCkdEpi2021FromCreatinineMgDl'),
    'calculator_egfr.php musí volať spoločný vzorec.',
);
egfrRefTest(
    str_contains($egfrCysSrc, 'calculatorCkdEpi2021FromCreatinineCystatinMgDl')
        && str_contains($egfrCysSrc, 'ckdGCategory(')
        && str_contains($egfrCysSrc, 'ckdGCategoryDescription(')
        && !preg_match('/function\s+egfrCysCategory\s*\(/', $egfrCysSrc)
        && !str_contains($egfrCysSrc, '$alpha = $sex === "female" ? -0.219'),
    'calculator_egfr_cys.php musí volať spoločný vzorec a G kategóriu, bez lokálnej kópie.',
);
egfrRefTest(
    str_contains($ekfcSrc, 'ekfcCompareCkdEpi2021')
        && str_contains($ekfcLogicSrc, 'calculatorCkdEpi2021FromCreatinineMgDl'),
    'EKFC porovnanie musí ísť cez ekfcCompareCkdEpi2021 → spoločný CKD-EPI 2021.',
);

// Jednotky: 88,4 µmol/L ≈ 1,0 mg/dL
$fromUmol = calculatorCkdEpi2021FromCreatinineMgDl(88.4 / 88.4, 50, 'female');
$fromMg = calculatorCkdEpi2021FromCreatinineMgDl(1.0, 50, 'female');
egfrRefTest(
    abs($fromUmol - $fromMg) < 1e-9,
    'Prevod µmol/L → mg/dL delením 88,4 musí sedieť s 1,0 mg/dL.',
);

$fromUmolCys = calculatorCkdEpi2021FromCreatinineCystatinMgDl(88.4 / 88.4, 1.0, 50, 'female');
$fromMgCys = calculatorCkdEpi2021FromCreatinineCystatinMgDl(1.0, 1.0, 50, 'female');
egfrRefTest(
    abs($fromUmolCys - $fromMgCys) < 1e-9,
    'Cr–Cys: prevod µmol/L → mg/dL delením 88,4 musí sedieť s 1,0 mg/dL.',
);

echo "Clinical eGFR reference: $checks PASS\n";
