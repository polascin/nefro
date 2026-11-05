<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: prevodník laboratórnych jednotiek.
 *
 * SI = konvenčné × faktor. Pinuje faktory stránky a dokumentované reciproké
 * hodnoty projektu (cholesterol ÷ 38,67; glukóza ÷ 18; triglyceridy ÷ 88,57).
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function unitsRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function unitsRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    unitsRefTest(abs($expected - $actual) <= $tol, $message . " (očakávané {$expected}, získané {$actual})");
}

$rows = calculatorUnitConversionRows();
unitsRefTest(count($rows) === 13, 'Prevodník má 13 riadkov.');

$byName = [];
foreach ($rows as $row) {
    unitsRefTest(is_string($row[0]) && $row[0] !== '', 'Názov analytu musí byť neprázdny.');
    unitsRefTest((float) $row[3] > 0.0, 'Faktor ' . $row[0] . ' musí byť kladný.');
    $byName[$row[0]] = $row;
}

unitsRefTest(isset($byName['Kreatinín'], $byName['Glukóza'], $byName['eGFR']), 'Kľúčové analyty sú prítomné.');

// Pinované faktory
unitsRefApprox(CREATININE_UMOL_PER_MGDL, (float) $byName['Kreatinín'][3], 1e-12, 'Kreatinín faktor 88,4');
unitsRefApprox(CREATININE_UMOL_PER_MGDL, 88.4, 0.0, 'CREATININE_UMOL_PER_MGDL = 88,4');
unitsRefApprox(0.357, (float) $byName['Urea (BUN)'][3], 1e-12, 'BUN/urea faktor 0,357');
unitsRefApprox(0.0555, (float) $byName['Glukóza'][3], 1e-12, 'Glukóza faktor 0,0555');
unitsRefApprox(0.2495, (float) $byName['Vápnik'][3], 1e-12, 'Vápnik faktor 0,2495');
unitsRefApprox(0.3229, (float) $byName['Fosfát (P)'][3], 1e-12, 'Fosfát faktor 0,3229');
unitsRefApprox(0.4114, (float) $byName['Magnézium'][3], 1e-12, 'Magnézium faktor 0,4114');
unitsRefApprox(59.48, (float) $byName['Kyselina močová'][3], 1e-12, 'Kyselina močová faktor 59,48');
unitsRefApprox(0.02586, (float) $byName['Cholesterol'][3], 1e-12, 'Cholesterol faktor 0,02586');
unitsRefApprox(0.01129, (float) $byName['Triglyceridy'][3], 1e-12, 'Triglyceridy faktor 0,01129');
unitsRefApprox(10.0, (float) $byName['Hemoglobín'][3], 1e-12, 'Hemoglobín faktor 10');
unitsRefApprox(10.0, (float) $byName['Albumín'][3], 1e-12, 'Albumín faktor 10');
unitsRefApprox(17.1, (float) $byName['Bilirubín'][3], 1e-12, 'Bilirubín faktor 17,1');
unitsRefApprox(1 / 60, (float) $byName['eGFR'][3], 1e-12, 'eGFR faktor 1/60');

// Dokumentované reciproké hodnoty projektu
unitsRefApprox(38.67, 1.0 / (float) $byName['Cholesterol'][3], 0.01, 'Cholesterol ÷ 38,67');
unitsRefApprox(18.0, 1.0 / (float) $byName['Glukóza'][3], 0.02, 'Glukóza ÷ 18');
unitsRefApprox(88.57, 1.0 / (float) $byName['Triglyceridy'][3], 0.05, 'Triglyceridy ÷ 88,57');

// Obojsmerné konverzie (referenčné príklady)
$crSi = calculatorConvertConventionalToSi(1.0, (float) $byName['Kreatinín'][3]);
unitsRefApprox(CREATININE_UMOL_PER_MGDL, $crSi, 1e-9, 'Kreatinín 1,0 mg/dL → 88,4 µmol/L');
unitsRefApprox(1.0, calculatorConvertSiToConventional($crSi, (float) $byName['Kreatinín'][3]), 1e-9, 'Kreatinín round-trip');

// Spoločné kreatinínové helpery
unitsRefApprox(88.4, creatinineMgDlToUmolL(1.0), 1e-12, 'creatinineMgDlToUmolL(1)');
unitsRefApprox(1.0, creatinineUmolLToMgDl(88.4), 1e-12, 'creatinineUmolLToMgDl(88,4)');
unitsRefApprox(0.0884, creatinineMgDlToMmolL(1.0), 1e-12, 'creatinineMgDlToMmolL(1)');
unitsRefApprox(1.0, crclCreatinineToMgDl(88.4, 'umol_l'), 1e-12, 'crclCreatinineToMgDl umol_l');
unitsRefApprox(1.0, crclCreatinineToMgDl(0.0884, 'mmol_l'), 1e-12, 'crclCreatinineToMgDl mmol_l');
unitsRefApprox(1.25, crclCreatinineToMgDl(1.25, 'mg_dl'), 0.0, 'crclCreatinineToMgDl mg_dl');
unitsRefApprox(2.0 * CREATININE_UMOL_PER_MGDL, PLASMIC_CREA_UMOL, 1e-12, 'PLASMIC prah = 2 mg/dL');

// Molárna hmotnosť kreatinínu odvodená z 88,4 (≈ 113,12 g/mol)
unitsRefApprox(
    10000.0 / CREATININE_UMOL_PER_MGDL,
    CREATININE_MOLAR_MASS_G_PER_MOL,
    0.0,
    'CREATININE_MOLAR_MASS_G_PER_MOL = 10000/88,4',
);
unitsRefApprox(113.122, CREATININE_MOLAR_MASS_G_PER_MOL, 0.001, 'MW kreatinínu ≈ 113,12');
unitsRefApprox(0.5656108597, creatinineMmolLToGL(5.0), 1e-9, 'creatinineMmolLToGL(5)');
unitsRefApprox(
    uacrMgMmolToMgG(calculatorUacrMgMmol(30.0, 5.0)),
    calculatorUacrMgG(30.0, 5.0),
    1e-12,
    'calculatorUacrMgG = mg/mmol × UACR faktor',
);

// UACR mg/mmol ↔ mg/g (odvodené z kreatinínu / 10)
unitsRefApprox(CREATININE_UMOL_PER_MGDL / 10.0, UACR_MG_G_PER_MG_MMOL, 0.0, 'UACR_MG_G_PER_MG_MMOL = 88,4/10');
unitsRefApprox(8.84, UACR_MG_G_PER_MG_MMOL, 1e-12, 'UACR_MG_G_PER_MG_MMOL = 8,84');
unitsRefApprox(88.4, uacrMgMmolToMgG(10.0), 1e-12, 'uacrMgMmolToMgG(10)');
unitsRefApprox(10.0, uacrMgGToMgMmol(88.4), 1e-12, 'uacrMgGToMgMmol(88,4)');
unitsRefApprox(300.0, uacrToMgG(300.0, 'mg_g'), 0.0, 'uacrToMgG už v mg/g');
unitsRefApprox(88.4, uacrToMgG(10.0, 'mg_mmol'), 1e-12, 'uacrToMgG z mg/mmol');
unitsRefApprox(300.0, uacrMgMmolToMgG(uacrMgGToMgMmol(300.0)), 1e-9, 'UACR round-trip 300 mg/g');

$bunSi = calculatorConvertConventionalToSi(28.0, (float) $byName['Urea (BUN)'][3]);
unitsRefApprox(10.0, $bunSi, 0.01, 'BUN 28 mg/dL → ≈ 10 mmol/L urea');

$gluSi = calculatorConvertConventionalToSi(100.0, (float) $byName['Glukóza'][3]);
unitsRefApprox(5.55, $gluSi, 0.01, 'Glukóza 100 mg/dL → 5,55 mmol/L');

$egfrSi = calculatorConvertConventionalToSi(60.0, (float) $byName['eGFR'][3]);
unitsRefApprox(1.0, $egfrSi, 1e-9, 'eGFR 60 ml/min → 1,0 ml/s');
unitsRefApprox(60.0, calculatorConvertSiToConventional(1.0, (float) $byName['eGFR'][3]), 1e-9, 'eGFR round-trip');

$lookup = calculatorUnitFactorByName('Kreatinín');
unitsRefTest(
    $lookup !== null && abs($lookup['factor'] - CREATININE_UMOL_PER_MGDL) < 1e-12,
    'Lookup Kreatinín → 88,4',
);
unitsRefTest(calculatorUnitFactorByName('Neexistuje') === null, 'Neznámy analyt → null');

$pageSrc = (string) file_get_contents(dirname(__DIR__) . '/calculator_units.php');
unitsRefTest(
    str_contains($pageSrc, 'calculatorUnitConversionRows()')
        && !preg_match('/\$unitRows\s*=\s*\[/', $pageSrc),
    'calculator_units.php musí volať calculatorUnitConversionRows()',
);

// Kalkulačky nesmú mať inline ×/÷ 88,4 (vzorce v LaTeX môžu mať \div 88.4)
$root = dirname(__DIR__);
$creatininePages = [
    'calculator_egfr.php' => 'crclCreatinineToMgDl',
    'calculator_egfr_cys.php' => 'crclCreatinineToMgDl',
    'calculator_cg.php' => 'crclCreatinineToMgDl',
    'calculator_kdpi.php' => 'crclCreatinineToMgDl',
    'calculator_aki.php' => 'creatinineMgDlToUmolL',
    'calculator_uacr.php' => 'creatinineMgDlToMmolL',
    'calculator_ekfc.php' => 'creatinineMgDlToUmolL',
];
foreach ($creatininePages as $file => $helper) {
    $src = (string) file_get_contents($root . '/' . $file);
    unitsRefTest(
        str_contains($src, $helper)
            && !preg_match('/(?:\/|\*)\s*88\.4|\*\s*0\.0884/', $src),
        $file . ' používa ' . $helper . ' bez inline 88,4',
    );
}
$ekfcLogic = (string) file_get_contents($root . '/calculator_ekfc_logic.php');
unitsRefTest(
    !preg_match('/EKFC_CREATININE_UMOL_PER_MGDL|=\s*88\.4/', $ekfcLogic),
    'calculator_ekfc_logic.php nemá vlastný faktor 88,4',
);

// Kalkulačky s UACR vstupom: helper uacrToMgG, bez inline × 8,84 vo výpočte
$uacrPages = [
    'calculator_kfre.php',
    'calculator_kdigo_risk.php',
    'calculator_ckdpc.php',
    'calculator_prevent.php',
    'calculator_ambulatory_logic.php',
];
foreach ($uacrPages as $file) {
    $src = (string) file_get_contents($root . '/' . $file);
    unitsRefTest(
        str_contains($src, 'uacrToMgG')
            && !preg_match('/\*\s*8\.84|\/\s*8\.84/', $src),
        $file . ' používa uacrToMgG bez inline 8,84',
    );
}

// Výpočty UACR / common: bez literálu molárnej hmotnosti 113.12
$mwSources = [
    'calculators_common.php' => 'creatinineMmolLToGL',
    'calculator_uacr.php' => 'calculatorUacrMgG',
];
foreach ($mwSources as $file => $helper) {
    $src = (string) file_get_contents($root . '/' . $file);
    unitsRefTest(
        str_contains($src, $helper)
            && !preg_match('/\b113\.12\b/', $src),
        $file . ' používa ' . $helper . ' bez inline 113,12',
    );
}

echo "Clinical references (units): $checks PASS\n";
