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
unitsRefApprox(BUN_MGDL_TO_UREA_MMOLL, (float) $byName['Urea (BUN)'][3], 1e-12, 'BUN/urea faktor z konštanty');
unitsRefApprox(0.357, BUN_MGDL_TO_UREA_MMOLL, 0.0, 'BUN_MGDL_TO_UREA_MMOLL = 0,357');
unitsRefApprox(2.8, UREA_MMOLL_TO_BUN_MGDL, 0.0, 'UREA_MMOLL_TO_BUN_MGDL = 2,8');
unitsRefApprox(GLUCOSE_MGDL_TO_MMOLL, (float) $byName['Glukóza'][3], 1e-12, 'Glukóza faktor z konštanty');
unitsRefApprox(0.0555, GLUCOSE_MGDL_TO_MMOLL, 0.0, 'GLUCOSE_MGDL_TO_MMOLL = 0,0555');
unitsRefApprox(18.0182, GLUCOSE_MMOLL_TO_MGDL, 0.0, 'GLUCOSE_MMOLL_TO_MGDL = 18,0182');
unitsRefApprox(CALCIUM_MGDL_TO_MMOLL, (float) $byName['Vápnik'][3], 1e-12, 'Vápnik faktor z konštanty');
unitsRefApprox(0.2495, CALCIUM_MGDL_TO_MMOLL, 0.0, 'CALCIUM_MGDL_TO_MMOLL = 0,2495');
unitsRefApprox(4.008, CALCIUM_MMOLL_TO_MGDL, 0.0, 'CALCIUM_MMOLL_TO_MGDL = 4,008');
unitsRefApprox(PHOSPHATE_MGDL_TO_MMOLL, (float) $byName['Fosfát (P)'][3], 1e-12, 'Fosfát faktor z konštanty');
unitsRefApprox(0.3229, PHOSPHATE_MGDL_TO_MMOLL, 0.0, 'PHOSPHATE_MGDL_TO_MMOLL = 0,3229');
unitsRefApprox(3.097, PHOSPHATE_MMOLL_TO_MGDL, 0.0, 'PHOSPHATE_MMOLL_TO_MGDL = 3,097');
unitsRefApprox(MAGNESIUM_MGDL_TO_MMOLL, (float) $byName['Magnézium'][3], 1e-12, 'Magnézium faktor z konštanty');
unitsRefApprox(0.4114, MAGNESIUM_MGDL_TO_MMOLL, 0.0, 'MAGNESIUM_MGDL_TO_MMOLL = 0,4114');
unitsRefApprox(2.4305, MAGNESIUM_MMOLL_TO_MGDL, 0.0, 'MAGNESIUM_MMOLL_TO_MGDL = 2,4305');
unitsRefApprox(URIC_ACID_MGDL_TO_UMOLL, (float) $byName['Kyselina močová'][3], 1e-12, 'Kyselina močová faktor z konštanty');
unitsRefApprox(59.48, URIC_ACID_MGDL_TO_UMOLL, 0.0, 'URIC_ACID_MGDL_TO_UMOLL = 59,48');
unitsRefApprox(0.0168, URIC_ACID_UMOLL_TO_MGDL, 0.0, 'URIC_ACID_UMOLL_TO_MGDL = 0,0168');
unitsRefApprox(CHOLESTEROL_MGDL_TO_MMOLL, (float) $byName['Cholesterol'][3], 1e-12, 'Cholesterol faktor z konštanty');
unitsRefApprox(0.02586, CHOLESTEROL_MGDL_TO_MMOLL, 0.0, 'CHOLESTEROL_MGDL_TO_MMOLL = 0,02586');
unitsRefApprox(38.67, CHOLESTEROL_MMOLL_TO_MGDL, 0.0, 'CHOLESTEROL_MMOLL_TO_MGDL = 38,67');
unitsRefApprox(TRIGLYCERIDES_MGDL_TO_MMOLL, (float) $byName['Triglyceridy'][3], 1e-12, 'Triglyceridy faktor z konštanty');
unitsRefApprox(0.01129, TRIGLYCERIDES_MGDL_TO_MMOLL, 0.0, 'TRIGLYCERIDES_MGDL_TO_MMOLL = 0,01129');
unitsRefApprox(88.57, TRIGLYCERIDES_MMOLL_TO_MGDL, 0.0, 'TRIGLYCERIDES_MMOLL_TO_MGDL = 88,57');
unitsRefApprox(MASS_CONC_GDL_TO_GL, (float) $byName['Hemoglobín'][3], 1e-12, 'Hemoglobín faktor z konštanty');
unitsRefApprox(MASS_CONC_GDL_TO_GL, (float) $byName['Albumín'][3], 1e-12, 'Albumín faktor z konštanty');
unitsRefApprox(10.0, MASS_CONC_GDL_TO_GL, 0.0, 'MASS_CONC_GDL_TO_GL = 10');
unitsRefApprox(BILIRUBIN_MGDL_TO_UMOLL, (float) $byName['Bilirubín'][3], 1e-12, 'Bilirubín faktor z konštanty');
unitsRefApprox(17.1, BILIRUBIN_MGDL_TO_UMOLL, 0.0, 'BILIRUBIN_MGDL_TO_UMOLL = 17,1');
unitsRefApprox(0.0585, BILIRUBIN_UMOLL_TO_MGDL, 0.0, 'BILIRUBIN_UMOLL_TO_MGDL = 0,0585');
unitsRefApprox(EGFR_ML_MIN_TO_ML_S, (float) $byName['eGFR'][3], 1e-12, 'eGFR faktor z konštanty');
unitsRefApprox(60.0, EGFR_ML_S_PER_ML_MIN, 0.0, 'EGFR_ML_S_PER_ML_MIN = 60');
unitsRefApprox(1.0 / 60.0, EGFR_ML_MIN_TO_ML_S, 0.0, 'EGFR_ML_MIN_TO_ML_S = 1/60');
unitsRefApprox(EGFR_ML_MIN_TO_ML_S, 1.0 / EGFR_ML_S_PER_ML_MIN, 0.0, 'EGFR_ML_MIN_TO_ML_S = 1/EGFR_ML_S_PER_ML_MIN');

// Dokumentované reciproké hodnoty projektu
unitsRefApprox(CHOLESTEROL_MMOLL_TO_MGDL, 1.0 / (float) $byName['Cholesterol'][3], 0.01, 'Cholesterol ÷ 38,67');
unitsRefApprox(18.0, 1.0 / (float) $byName['Glukóza'][3], 0.02, 'Glukóza ÷ 18');
unitsRefApprox(TRIGLYCERIDES_MMOLL_TO_MGDL, 1.0 / (float) $byName['Triglyceridy'][3], 0.05, 'Triglyceridy ÷ 88,57');
unitsRefApprox(BILIRUBIN_UMOLL_TO_MGDL, 1.0 / (float) $byName['Bilirubín'][3], 0.0001, 'Bilirubín × 0,0585');

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
unitsRefApprox(10.0, bunMgDlToUreaMmolL(28.0), 0.01, 'bunMgDlToUreaMmolL(28)');
unitsRefApprox(70.0, ureaMmolLToBunMgDl(25.0), 1e-12, 'ureaMmolLToBunMgDl(25)');
unitsRefApprox(70.0, npcrToBunMgDl(25.0, 'mmol_l'), 1e-12, 'npcrToBunMgDl cez ureaMmolLToBunMgDl');
unitsRefApprox(
    bunMgDlToUreaMmolL(28.0),
    calculatorConvertConventionalToSi(28.0, BUN_MGDL_TO_UREA_MMOLL),
    0.0,
    'bun helper = prevodník s BUN_MGDL_TO_UREA_MMOLL',
);

$gluSi = calculatorConvertConventionalToSi(100.0, (float) $byName['Glukóza'][3]);
unitsRefApprox(5.55, $gluSi, 0.01, 'Glukóza 100 mg/dL → 5,55 mmol/L');
unitsRefApprox(5.55, glucoseMgDlToMmolL(100.0), 0.01, 'glucoseMgDlToMmolL(100)');
unitsRefApprox(600.0, glucoseMmolLToMgDl(33.3), 0.01, 'glucoseMmolLToMgDl(33,3)');
unitsRefApprox(
    glucoseMgDlToMmolL(100.0),
    calculatorConvertConventionalToSi(100.0, GLUCOSE_MGDL_TO_MMOLL),
    0.0,
    'glucose helper = prevodník s GLUCOSE_MGDL_TO_MMOLL',
);

$caSi = calculatorConvertConventionalToSi(10.0, (float) $byName['Vápnik'][3]);
unitsRefApprox(2.495, $caSi, 1e-9, 'Vápnik 10 mg/dL → 2,495 mmol/L');
unitsRefApprox(2.495, calciumMgDlToMmolL(10.0), 1e-9, 'calciumMgDlToMmolL(10)');
unitsRefApprox(40.08, calciumMmolLToMgDl(10.0), 1e-9, 'calciumMmolLToMgDl(10)');
unitsRefApprox(
    calciumMgDlToMmolL(10.0),
    calculatorConvertConventionalToSi(10.0, CALCIUM_MGDL_TO_MMOLL),
    0.0,
    'calcium helper = prevodník s CALCIUM_MGDL_TO_MMOLL',
);

$phosSi = calculatorConvertConventionalToSi(4.5, (float) $byName['Fosfát (P)'][3]);
unitsRefApprox(1.45305, $phosSi, 1e-9, 'Fosfát 4,5 mg/dL → 1,45305 mmol/L');
unitsRefApprox(1.45305, phosphateMgDlToMmolL(4.5), 1e-9, 'phosphateMgDlToMmolL(4,5)');
unitsRefApprox(30.97, phosphateMmolLToMgDl(10.0), 1e-9, 'phosphateMmolLToMgDl(10)');
unitsRefApprox(
    phosphateMgDlToMmolL(4.5),
    calculatorConvertConventionalToSi(4.5, PHOSPHATE_MGDL_TO_MMOLL),
    0.0,
    'phosphate helper = prevodník s PHOSPHATE_MGDL_TO_MMOLL',
);

$mgSi = calculatorConvertConventionalToSi(2.0, (float) $byName['Magnézium'][3]);
unitsRefApprox(0.8228, $mgSi, 1e-9, 'Magnézium 2,0 mg/dL → 0,8228 mmol/L');
unitsRefApprox(0.8228, magnesiumMgDlToMmolL(2.0), 1e-9, 'magnesiumMgDlToMmolL(2)');
unitsRefApprox(24.305, magnesiumMmolLToMgDl(10.0), 1e-9, 'magnesiumMmolLToMgDl(10)');
unitsRefApprox(
    magnesiumMgDlToMmolL(2.0),
    calculatorConvertConventionalToSi(2.0, MAGNESIUM_MGDL_TO_MMOLL),
    0.0,
    'magnesium helper = prevodník s MAGNESIUM_MGDL_TO_MMOLL',
);

$uaSi = calculatorConvertConventionalToSi(8.0, (float) $byName['Kyselina močová'][3]);
unitsRefApprox(475.84, $uaSi, 1e-9, 'Kyselina močová 8,0 mg/dL → 475,84 µmol/L');
unitsRefApprox(475.84, uricAcidMgDlToUmolL(8.0), 1e-9, 'uricAcidMgDlToUmolL(8)');
unitsRefApprox(1.68, uricAcidUmolLToMgDl(100.0), 1e-9, 'uricAcidUmolLToMgDl(100)');
unitsRefApprox(
    uricAcidMgDlToUmolL(8.0),
    calculatorConvertConventionalToSi(8.0, URIC_ACID_MGDL_TO_UMOLL),
    0.0,
    'uric acid helper = prevodník s URIC_ACID_MGDL_TO_UMOLL',
);

$cholSi = calculatorConvertConventionalToSi(200.0, (float) $byName['Cholesterol'][3]);
unitsRefApprox(5.172, $cholSi, 1e-9, 'Cholesterol 200 mg/dL → 5,172 mmol/L');
unitsRefApprox(5.172, cholesterolMgDlToMmolL(200.0), 1e-9, 'cholesterolMgDlToMmolL(200)');
unitsRefApprox(386.7, cholesterolMmolLToMgDl(10.0), 1e-9, 'cholesterolMmolLToMgDl(10)');
unitsRefApprox(
    cholesterolMgDlToMmolL(200.0),
    calculatorConvertConventionalToSi(200.0, CHOLESTEROL_MGDL_TO_MMOLL),
    0.0,
    'cholesterol helper = prevodník s CHOLESTEROL_MGDL_TO_MMOLL',
);

$trigSi = calculatorConvertConventionalToSi(100.0, (float) $byName['Triglyceridy'][3]);
unitsRefApprox(1.129, $trigSi, 1e-9, 'Triglyceridy 100 mg/dL → 1,129 mmol/L');
unitsRefApprox(1.129, triglyceridesMgDlToMmolL(100.0), 1e-9, 'triglyceridesMgDlToMmolL(100)');
unitsRefApprox(885.7, triglyceridesMmolLToMgDl(10.0), 1e-9, 'triglyceridesMmolLToMgDl(10)');
unitsRefApprox(
    triglyceridesMgDlToMmolL(100.0),
    calculatorConvertConventionalToSi(100.0, TRIGLYCERIDES_MGDL_TO_MMOLL),
    0.0,
    'triglycerides helper = prevodník s TRIGLYCERIDES_MGDL_TO_MMOLL',
);

$biliSi = calculatorConvertConventionalToSi(1.0, (float) $byName['Bilirubín'][3]);
unitsRefApprox(17.1, $biliSi, 1e-9, 'Bilirubín 1,0 mg/dL → 17,1 µmol/L');
unitsRefApprox(17.1, bilirubinMgDlToUmolL(1.0), 1e-9, 'bilirubinMgDlToUmolL(1)');
unitsRefApprox(5.85, bilirubinUmolLToMgDl(100.0), 1e-9, 'bilirubinUmolLToMgDl(100)');
unitsRefApprox(
    bilirubinMgDlToUmolL(1.0),
    calculatorConvertConventionalToSi(1.0, BILIRUBIN_MGDL_TO_UMOLL),
    0.0,
    'bilirubin helper = prevodník s BILIRUBIN_MGDL_TO_UMOLL',
);

$hbSi = calculatorConvertConventionalToSi(12.0, (float) $byName['Hemoglobín'][3]);
unitsRefApprox(120.0, $hbSi, 1e-9, 'Hemoglobín 12,0 g/dL → 120 g/L');
unitsRefApprox(120.0, massConcGdlToGl(12.0), 1e-9, 'massConcGdlToGl(12)');
unitsRefApprox(12.0, massConcGlToGdl(120.0), 1e-9, 'massConcGlToGdl(120)');
unitsRefApprox(
    massConcGdlToGl(12.0),
    calculatorConvertConventionalToSi(12.0, MASS_CONC_GDL_TO_GL),
    0.0,
    'massConc helper = prevodník s MASS_CONC_GDL_TO_GL',
);
unitsRefApprox(35.0, massConcGdlToGl(3.5), 1e-9, 'Albumín 3,5 g/dL → 35 g/L');
unitsRefApprox(3.5, massConcGlToGdl(35.0), 1e-9, 'Albumín 35 g/L → 3,5 g/dL');

$egfrSi = calculatorConvertConventionalToSi(60.0, (float) $byName['eGFR'][3]);
unitsRefApprox(1.0, $egfrSi, 1e-9, 'eGFR 60 ml/min → 1,0 ml/s');
unitsRefApprox(1.0, egfrMlMinToMlS(60.0), 1e-9, 'egfrMlMinToMlS(60)');
unitsRefApprox(60.0, egfrMlSToMlMin(1.0), 1e-9, 'egfrMlSToMlMin(1)');
unitsRefApprox(
    egfrMlMinToMlS(60.0),
    calculatorConvertConventionalToSi(60.0, EGFR_ML_MIN_TO_ML_S),
    0.0,
    'egfr helper = prevodník s EGFR_ML_MIN_TO_ML_S',
);
unitsRefApprox(60.0, calculatorConvertSiToConventional(1.0, (float) $byName['eGFR'][3]), 1e-9, 'eGFR round-trip');
unitsRefApprox(45.0, calculatorEgfrToMlMin(0.75, EGFR_UNIT_ML_S), 1e-9, 'calculatorEgfrToMlMin cez egfrMlSToMlMin');
unitsRefApprox(0.75, calculatorEgfrFromMlMin(45.0, EGFR_UNIT_ML_S), 1e-9, 'calculatorEgfrFromMlMin cez egfrMlMinToMlS');

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

// BUN ↔ urea: konštanty + helpery; bez inline 2.8 / 0.357 mimo definícií konštánt
$commonSrc = (string) file_get_contents($root . '/calculators_common.php');
unitsRefTest(
    str_contains($commonSrc, 'BUN_MGDL_TO_UREA_MMOLL')
        && str_contains($commonSrc, 'UREA_MMOLL_TO_BUN_MGDL')
        && str_contains($commonSrc, 'bunMgDlToUreaMmolL')
        && str_contains($commonSrc, 'ureaMmolLToBunMgDl')
        && str_contains($commonSrc, 'ureaMmolLToBunMgDl($value)'),
    'calculators_common má BUN/urea konštanty a helpery; npcrToBunMgDl ich volá',
);
unitsRefTest(
    !preg_match('/\*\s*2\.8\b/', $commonSrc)
        && !preg_match("/['\"]Urea \(BUN\)['\"].*0\.357/", $commonSrc),
    'calculators_common bez inline × 2,8 a literálu 0,357 v prevodníku',
);
$npcrPage = (string) file_get_contents($root . '/calculator_npcr.php');
unitsRefTest(
    str_contains($npcrPage, 'npcrToBunMgDl')
        && !preg_match('/\*\s*2\.8\b|\/\s*0\.357\b/', $npcrPage),
    'calculator_npcr.php používa npcrToBunMgDl bez inline 2,8 / 0,357',
);

// Glukóza mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.0555 / 18.0182 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'GLUCOSE_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'GLUCOSE_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'glucoseMgDlToMmolL')
        && str_contains($commonSrc, 'glucoseMmolLToMgDl'),
    'calculators_common má glukózové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Glukóza['\"].*0\.0555/", $commonSrc)
        && !preg_match('/\*\s*18\.0182\b/', $commonSrc),
    'calculators_common bez literálu 0,0555 v prevodníku a bez inline × 18,0182',
);
$naPage = (string) file_get_contents($root . '/calculator_na.php');
unitsRefTest(
    str_contains($naPage, 'glucoseMmolLToMgDl')
        && !preg_match('/\*\s*18\.0182\b|\/\s*0\.0555\b/', $naPage),
    'calculator_na.php používa glucoseMmolLToMgDl bez inline 18,0182 / 0,0555',
);

// Vápnik mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.2495 / 4.008 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'CALCIUM_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'CALCIUM_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'calciumMgDlToMmolL')
        && str_contains($commonSrc, 'calciumMmolLToMgDl'),
    'calculators_common má vápnikové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Vápnik['\"].*0\.2495/", $commonSrc)
        && !preg_match('/\*\s*4\.008\b/', $commonSrc),
    'calculators_common bez literálu 0,2495 v prevodníku a bez inline × 4,008',
);

// Fosfát mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.3229 / 3.097 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'PHOSPHATE_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'PHOSPHATE_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'phosphateMgDlToMmolL')
        && str_contains($commonSrc, 'phosphateMmolLToMgDl'),
    'calculators_common má fosfátové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Fosfát \(P\)['\"].*0\.3229/", $commonSrc)
        && !preg_match('/\*\s*3\.097\b/', $commonSrc),
    'calculators_common bez literálu 0,3229 v prevodníku a bez inline × 3,097',
);

// Magnézium mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.4114 / 2.4305 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'MAGNESIUM_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'MAGNESIUM_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'magnesiumMgDlToMmolL')
        && str_contains($commonSrc, 'magnesiumMmolLToMgDl'),
    'calculators_common má magnéziové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Magnézium['\"].*0\.4114/", $commonSrc)
        && !preg_match('/\*\s*2\.4305\b/', $commonSrc),
    'calculators_common bez literálu 0,4114 v prevodníku a bez inline × 2,4305',
);

// Kyselina močová mg/dL ↔ µmol/L: konštanty + helpery; bez inline 59.48 / 0.0168 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'URIC_ACID_MGDL_TO_UMOLL')
        && str_contains($commonSrc, 'URIC_ACID_UMOLL_TO_MGDL')
        && str_contains($commonSrc, 'uricAcidMgDlToUmolL')
        && str_contains($commonSrc, 'uricAcidUmolLToMgDl'),
    'calculators_common má konštanty a helpery kyseliny močovej',
);
unitsRefTest(
    !preg_match("/['\"]Kyselina močová['\"].*59\.48/", $commonSrc)
        && !preg_match('/\*\s*0\.0168\b/', $commonSrc),
    'calculators_common bez literálu 59,48 v prevodníku a bez inline × 0,0168',
);

// Cholesterol mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.02586 / 38.67 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'CHOLESTEROL_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'CHOLESTEROL_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'cholesterolMgDlToMmolL')
        && str_contains($commonSrc, 'cholesterolMmolLToMgDl'),
    'calculators_common má cholesterolové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Cholesterol['\"].*0\.02586/", $commonSrc)
        && !preg_match('/\*\s*38\.67\b/', $commonSrc),
    'calculators_common bez literálu 0,02586 v prevodníku a bez inline × 38,67',
);

// Triglyceridy mg/dL ↔ mmol/L: konštanty + helpery; bez inline 0.01129 / 88.57 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'TRIGLYCERIDES_MGDL_TO_MMOLL')
        && str_contains($commonSrc, 'TRIGLYCERIDES_MMOLL_TO_MGDL')
        && str_contains($commonSrc, 'triglyceridesMgDlToMmolL')
        && str_contains($commonSrc, 'triglyceridesMmolLToMgDl'),
    'calculators_common má triglyceridové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Triglyceridy['\"].*0\.01129/", $commonSrc)
        && !preg_match('/\*\s*88\.57\b/', $commonSrc),
    'calculators_common bez literálu 0,01129 v prevodníku a bez inline × 88,57',
);

// Bilirubín mg/dL ↔ µmol/L: konštanty + helpery; bez inline 17.1 / 0.0585 mimo definícií
unitsRefTest(
    str_contains($commonSrc, 'BILIRUBIN_MGDL_TO_UMOLL')
        && str_contains($commonSrc, 'BILIRUBIN_UMOLL_TO_MGDL')
        && str_contains($commonSrc, 'bilirubinMgDlToUmolL')
        && str_contains($commonSrc, 'bilirubinUmolLToMgDl'),
    'calculators_common má bilirubínové konštanty a helpery',
);
unitsRefTest(
    !preg_match("/['\"]Bilirubín['\"].*17\.1/", $commonSrc)
        && !preg_match('/\*\s*0\.0585\b/', $commonSrc),
    'calculators_common bez literálu 17,1 v prevodníku a bez inline × 0,0585',
);

// Hb/albumín g/dL ↔ g/L: spoločná konštanta + helpery; bez inline 10.0 v prevodníku a Gupta
unitsRefTest(
    str_contains($commonSrc, 'MASS_CONC_GDL_TO_GL')
        && str_contains($commonSrc, 'massConcGdlToGl')
        && str_contains($commonSrc, 'massConcGlToGdl'),
    'calculators_common má MASS_CONC_GDL_TO_GL a helpery g/dL ↔ g/L',
);
unitsRefTest(
    !preg_match("/['\"]Hemoglobín['\"].*10\.0/", $commonSrc)
        && !preg_match("/['\"]Albumín['\"].*10\.0/", $commonSrc),
    'calculators_common bez literálu 10,0 v riadkoch Hemoglobín/Albumín prevodníka',
);
$guptaPage = (string) file_get_contents($root . '/calculator_gupta.php');
unitsRefTest(
    str_contains($guptaPage, 'massConcGlToGdl')
        && !preg_match('/\/\s*10\.0\b/', $guptaPage),
    'calculator_gupta.php používa massConcGlToGdl bez inline ÷ 10,0',
);

// eGFR ml/min ↔ ml/s: konštanty + helpery; bez inline 1/60 v prevodníku a výsledkoch
unitsRefTest(
    str_contains($commonSrc, 'EGFR_ML_S_PER_ML_MIN')
        && str_contains($commonSrc, 'EGFR_ML_MIN_TO_ML_S')
        && str_contains($commonSrc, 'egfrMlMinToMlS')
        && str_contains($commonSrc, 'egfrMlSToMlMin'),
    'calculators_common má eGFR konštanty a helpery ml/min ↔ ml/s',
);
unitsRefTest(
    !preg_match("/['\"]eGFR['\"].*1\s*\/\s*60/", $commonSrc),
    'calculators_common bez literálu 1/60 v riadku eGFR prevodníka',
);
$egfrPages = [
    'calculator_egfr.php',
    'calculator_egfr_cys.php',
    'calculator_ekfc.php',
];
foreach ($egfrPages as $file) {
    $src = (string) file_get_contents($root . '/' . $file);
    unitsRefTest(
        str_contains($src, 'egfrMlMinToMlS')
            && !preg_match('/\/\s*EGFR_ML_S_PER_ML_MIN/', $src),
        $file . ' používa egfrMlMinToMlS bez priameho ÷ EGFR_ML_S_PER_ML_MIN',
    );
}

$preventSrc = (string) file_get_contents(dirname(__DIR__) . '/prevent_model.php');
unitsRefTest(
    str_contains($preventSrc, 'CHOLESTEROL_MGDL_TO_MMOLL')
        && !preg_match('/\*\s*0\.02586\b/', $preventSrc),
    'prevent_model používa CHOLESTEROL_MGDL_TO_MMOLL bez inline 0,02586',
);

echo "Clinical references (units): $checks PASS\n";
