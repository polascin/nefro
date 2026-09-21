<?php

declare(strict_types=1);

require_once __DIR__ . '/../calculators_common.php';
require_once __DIR__ . '/../ckd_risk_models.php';
require_once __DIR__ . '/../calculator_ambulatory_logic.php';

$assertions = 0;

function testSame(mixed $expected, mixed $actual, string $message): void
{
    global $assertions;
    $assertions++;
    if ($expected !== $actual) {
        throw new \RuntimeException(
            $message . ': očakávané ' . var_export($expected, true) .
            ', získané ' . var_export($actual, true),
        );
    }
}

function testApprox(float $expected, float $actual, float $tolerance, string $message): void
{
    global $assertions;
    $assertions++;
    if (abs($expected - $actual) > $tolerance) {
        throw new \RuntimeException(
            $message . ': očakávané ' . $expected . ', získané ' . $actual,
        );
    }
}

// Regresné scenáre porovnané 1. 9. 2026 s oficiálnym ckdpcrisk.org/gfrdecline40.
$ckdpcScenarios = [
    [1.9, [60, 'male', 85.0, 30.0, true, 130.0, false, false, false, false, 30.0, 'never', 7.0, false, false]],
    [0.4, [45, 'female', 70.0, 10.0, false, 120.0, false, false, false, false, 24.0, 'never', 7.0, false, false]],
    [28.6, [70, 'male', 40.0, 300.0, false, 145.0, true, true, true, false, 28.0, 'former', 7.0, false, false]],
    [36.4, [55, 'female', 35.0, 500.0, true, 150.0, true, false, true, true, 32.0, 'current', 9.0, true, false]],
];

foreach ($ckdpcScenarios as $index => [$expected, $arguments]) {
    $result = ckdpcRisk(...$arguments);
    testApprox($expected, $result['risk_3yr'], 0.05, 'CKD-PC scenár ' . ($index + 1));
}

$ckdpcEgfr60 = ckdpcRisk(60, 'male', 60.0, 30.0, true, 130.0, false, false, false, false, 30.0, 'never', 7.0, false, false);
testApprox(3.3, $ckdpcEgfr60['risk_3yr'], 0.05, 'CKD-PC eGFR presne 60');
testSame(
    'DM, priemer submodelov eGFR ≥60 a <60',
    $ckdpcEgfr60['model_name'],
    'CKD-PC názov modelu pri eGFR 60'
);

$kfreCases = [
    [60, 'male', 25.0, 300.0, false, 10.0, 33.5],
    [55, 'female', 15.0, 1000.0, false, 38.2, 84.5],
    [70, 'male', 40.0, 150.0, false, 1.2, 4.4],
    [50, 'female', 30.0, 500.0, false, 7.1, 24.9],
    [60, 'male', 25.0, 300.0, true, 14.6, 38.8],
    [55, 'female', 15.0, 1000.0, true, 51.3, 89.4],
    [70, 'male', 40.0, 150.0, true, 1.7, 5.3],
    [50, 'female', 30.0, 500.0, true, 10.5, 29.2],
];
foreach ($kfreCases as $index => [$age, $sex, $egfr, $uacr, $northAmerica, $expected2, $expected5]) {
    $result = kfreRisk($age, $sex, $egfr, $uacr, $northAmerica);
    $label = 'KFRE scenár ' . ($index + 1) . ($northAmerica ? ' NA' : ' mimo NA');
    testApprox($expected2, $result['risk_2yr'], 0.05, $label . ' 2r');
    testApprox($expected5, $result['risk_5yr'], 0.05, $label . ' 5r');
    testSame($northAmerica ? 'na' : 'non_na', $result['calibration'], $label . ' kalibrácia');
}

testSame('N18.1', ambulatoryIcd10CodeForGCategory('G1'), 'MKCH G1');
testSame('N18.3', ambulatoryIcd10CodeForGCategory('G3a'), 'MKCH G3a');
testSame('N18.3', ambulatoryIcd10CodeForGCategory('G3b'), 'MKCH G3b');
testSame('N18.5', ambulatoryIcd10CodeForGCategory('G5'), 'MKCH G5');
testSame('N18.3 CKD G3b', ambulatoryMainDiagnosis('G3b', true, true), 'Potvrdená CKD G3b');
testSame(
    'CKD nepotvrdená – kód N18.x zatiaľ neurčený',
    ambulatoryMainDiagnosis('G3b', false, true),
    'Nepotvrdená chronicita'
);
testSame(
    'kritériá CKD z uvedených údajov nesplnené – kód neurčený',
    ambulatoryMainDiagnosis('G2', true, false),
    'G2A1 bez iného markera poškodenia obličiek'
);

$slope = ambulatoryCalculateEgfrSlope([
    ['date' => new \DateTimeImmutable('2025-01-01'), 'egfr' => 60.0],
    ['date' => new \DateTimeImmutable('2026-01-01'), 'egfr' => 50.0],
]);
if ($slope === null) {
    throw new \RuntimeException('eGFR slope sa nevypočítal.');
}
testApprox(-10.0, $slope['slope'], 0.02, 'eGFR slope za jeden rok');
testSame(2, $slope['count'], 'Počet bodov eGFR slope');

testSame(
    ['year' => 1965, 'month' => 1, 'day' => 1, 'precision' => 'year'],
    ambulatoryParseBirthInput('1965'),
    'Len rok narodenia'
);
testSame(
    ['year' => 1965, 'month' => 6, 'day' => 1, 'precision' => 'month'],
    ambulatoryParseBirthInput('6/1965'),
    'Mesiac a rok'
);
testSame(
    ['year' => 1965, 'month' => 6, 'day' => 1, 'precision' => 'month'],
    ambulatoryParseBirthInput('1965-06'),
    'ISO mesiac a rok'
);
testSame(
    ['year' => 1965, 'month' => 6, 'day' => 15, 'precision' => 'day'],
    ambulatoryParseBirthInput('15. 6. 1965'),
    'Celý dátum s medzerami'
);
testSame(
    ['year' => 1965, 'month' => 6, 'day' => 15, 'precision' => 'day'],
    ambulatoryParseBirthInput('1965-06-15'),
    'ISO dátum'
);
testSame(null, ambulatoryParseBirthInput('29.2.1965'), 'Neplatný prestupný deň');
testSame(
    ['year' => 1964, 'month' => 2, 'day' => 29, 'precision' => 'day'],
    ambulatoryParseBirthInput('29.2.1964'),
    'Platný prestupný deň'
);

$examDate = new \DateTimeImmutable('2026-09-01');
testSame(61, ambulatoryAgeAtExamination(
    ['year' => 1965, 'month' => 6, 'day' => 15],
    $examDate
), 'Vek z celého dátumu po narodeninách');
testSame(60, ambulatoryAgeAtExamination(
    ['year' => 1965, 'month' => 6, 'day' => 15],
    new \DateTimeImmutable('2026-06-14')
), 'Vek deň pred narodeninami');
testSame(61, ambulatoryAgeAtExamination(
    ['year' => 1965, 'month' => 1, 'day' => 1],
    $examDate
), 'Vek z roku narodenia k 1. januáru');
testSame(null, ambulatoryAgeAtExamination(
    ['year' => 2027, 'month' => 1, 'day' => 1],
    $examDate
), 'Narodenie po vyšetrení');
testSame('rok', ambulatoryYearsWord(1), '1 rok');
testSame('roky', ambulatoryYearsWord(22), '22 roky');
testSame('rokov', ambulatoryYearsWord(21), '21 rokov');
testSame('rokov', ambulatoryYearsWord(11), '11 rokov');

testSame('N18.3, I12.00', ambulatoryPostedCodeList(['N18.3', 'I12.00']), 'Kódy z poľa');
testSame('N18.3, I12.00', ambulatoryPostedCodeList('N18.3, I12.00'), 'Kódy z reťazca');
testSame(
    'E11.21, N08; diabetická choroba obličiek',
    ambulatoryFormatCause(['E11.21', 'N08'], 'diabetická choroba obličiek'),
    'Príčina kódy + text'
);
testSame('neurčená', ambulatoryFormatCause([], 'neurčená'), 'Príčina len text');
testSame('N08', ambulatoryFormatCause(['N08'], ''), 'Príčina len kód');
testSame('', ambulatoryFormatCause([], ''), 'Príčina prázdna');

testSame('vek a pohlavie', ambulatoryJoinSlovakList(['vek', 'pohlavie']), 'Spojka a pri dvoch položkách');
testSame('vek, pohlavie a uACR', ambulatoryJoinSlovakList(['vek', 'pohlavie', 'uACR']), 'Čiarka a spojka pri troch');

$output = ambulatoryBuildPlainText([
    'main_diagnosis' => 'N18.3 CKD G3b',
    'cause' => 'test',
    'g_category' => 'G3b (eGFR 38,5 ml/min/1,73 m²) – stredne až výrazne znížená filtrácia',
    'a_category' => 'A2 (uACR 12,40 mg/mmol = 109,6 mg/g) – stredne zvýšená albuminúria',
    'chronicity' => 'potvrdená',
    'ga_risk' => 'vysoké',
    'kfre' => '2-ročné 4,2 %; 5-ročné 15,1 %',
    'ckdpc' => '3-ročné 8,4 % (≥40 % pokles eGFR alebo zlyhanie obličiek)',
    'ckm' => '2 – metabolické rizikové faktory a/alebo CKD',
    'slope' => '-2,00 ml/min/1,73 m²/rok (merania: 2; obdobie: 1,0 r.)',
    'related_diagnoses' => 'E11.2',
    'complications' => 'anémia',
    'egfr_note' => true,
]);
testSame(true, str_starts_with($output, 'Hlavná diagnóza (MKCH-10): N18.3 CKD G3b'), 'Začiatok čistého textu');
testSame(true, str_contains($output, "\n\nKDIGO 2024 – CGA\n"), 'Oddelená sekcia CGA');
testSame(true, str_contains($output, "\n\nPrognóza\nKFRE: "), 'Oddelená sekcia prognózy');
testSame(true, str_contains($output, 'Pridružené diagnózy (MKCH-10): E11.2'), 'Riadok pridružených diagnóz');
testSame(true, str_contains($output, 'Poznámka k eGFR:'), 'Povinná poznámka k eGFR');
testSame(false, str_contains($output, ' | '), 'Riziká nie sú v jednom riadku s rúrami');
testSame(5, count(preg_split("/\n\n/", $output)), 'Počet blokov čistého textu');

$partialOutput = ambulatoryBuildPlainText([
    'g_category' => 'G3b (eGFR 38,5 ml/min/1,73 m²) – stredne až výrazne znížená filtrácia',
    'egfr_note' => true,
]);
testSame(true, str_contains($partialOutput, "KDIGO 2024 – CGA\nKategória G:"), 'Čiastočný výstup má len kategóriu G');
testSame(false, str_contains($partialOutput, 'KFRE:'), 'Čiastočný výstup vynechá KFRE');
testSame(false, str_contains($partialOutput, 'Pridružené diagnózy'), 'Čiastočný výstup vynechá prázdne diagnózy');
testSame(false, str_contains($partialOutput, 'Hlavná diagnóza'), 'Čiastočný výstup bez kódu N18');

/**
 * @param array<string, mixed> $overrides
 * @return array<string, mixed>
 */
function ambulatoryTestInput(array $overrides = []): array
{
    return array_merge([
        'cause' => '',
        'age_years' => null,
        'sex' => null,
        'egfr' => null,
        'uacr_value' => null,
        'uacr_unit' => null,
        'chronicity' => 'confirmed',
        'repeat_date' => null,
        'other_kidney_marker' => false,
        'related_diagnoses' => '',
        'sbp' => null,
        'bmi' => null,
        'smoking' => null,
        'diabetes' => false,
        'hba1c' => null,
        'antihtn' => false,
        'hf' => false,
        'chd' => false,
        'afib' => false,
        'insulin' => false,
        'oral_dm' => false,
        'asian_ancestry' => false,
        'increased_waist' => false,
        'prediabetes' => false,
        'hypertension' => false,
        'hypertriglyceridemia' => false,
        'metabolic_syndrome' => false,
        'subclinical_cvd' => false,
        'other_clinical_cvd' => false,
        'slope_points' => [],
        'complications' => '',
    ], $overrides);
}

$egfrOnly = ambulatoryComputeReport(ambulatoryTestInput([
    'egfr' => 38.5,
]));
testSame('N18.3 CKD G3b', $egfrOnly['summary']['main_diagnosis'] ?? null, 'Len eGFR určí N18.3');
testSame(true, isset($egfrOnly['summary']['g_category']), 'Len eGFR vyplní kategóriu G');
testSame(false, isset($egfrOnly['summary']['a_category']), 'Len eGFR nevyplní kategóriu A');
testSame(false, isset($egfrOnly['summary']['kfre']), 'Len eGFR nespočíta KFRE');
testSame(false, isset($egfrOnly['summary']['ckdpc']), 'Len eGFR nespočíta CKD-PC');
testSame(true, isset($egfrOnly['summary']['ckm']), 'Potvrdená CKD G3b zaradí CKM');
testSame(true, in_array('Orientačné riziko G+A — chýba uACR', $egfrOnly['skipped'], true), 'Upozornenie na chýbajúce uACR');
testSame(true, in_array('eGFR slope — chýba predchádzajúce meranie', $egfrOnly['skipped'], true), 'Upozornenie na chýbajúci slope');

$kfreReady = ambulatoryComputeReport(ambulatoryTestInput([
    'age_years' => 60,
    'sex' => 'male',
    'egfr' => 25.0,
    'uacr_value' => 300.0,
    'uacr_unit' => 'mg_g',
]));
testSame('2-ročné 10,0 %; 5-ročné 33,5 %', $kfreReady['summary']['kfre'] ?? null, 'KFRE pri kompletných vstupoch');
testSame(false, isset($kfreReady['summary']['ckdpc']), 'CKD-PC bez BMI a TK sa nespočíta');
testSame(true, str_contains(implode(' ', $kfreReady['skipped']), 'CKD-PC — chýba'), 'CKD-PC nahlási chýbajúce vstupy');

$bmiOnly = ambulatoryComputeReport(ambulatoryTestInput([
    'bmi' => 29.4,
    'chronicity' => 'confirmed',
]));
testSame(false, isset($bmiOnly['summary']['main_diagnosis']), 'Samotné BMI neurčí N18');
testSame(false, isset($bmiOnly['summary']['chronicity']), 'Chronicita bez obličkových údajov sa do textu nedá');
testSame(true, str_starts_with((string) ($bmiOnly['summary']['ckm'] ?? ''), '1 –'), 'BMI ≥25 zaradí CKM stage 1');
testSame(false, str_contains(ambulatoryBuildPlainText($bmiOnly['summary']), 'KDIGO'), 'BMI-only text nemá sekciu CGA');

$kdigoHeatmap = [
    'G1' => ['A1' => 'Nízke riziko', 'A2' => 'Stredné riziko', 'A3' => 'Vysoké riziko'],
    'G2' => ['A1' => 'Nízke riziko', 'A2' => 'Stredné riziko', 'A3' => 'Vysoké riziko'],
    'G3a' => ['A1' => 'Stredné riziko', 'A2' => 'Vysoké riziko', 'A3' => 'Veľmi vysoké riziko'],
    'G3b' => ['A1' => 'Vysoké riziko', 'A2' => 'Veľmi vysoké riziko', 'A3' => 'Veľmi vysoké riziko'],
    'G4' => ['A1' => 'Vysoké riziko', 'A2' => 'Veľmi vysoké riziko', 'A3' => 'Veľmi vysoké riziko'],
    'G5' => ['A1' => 'Veľmi vysoké riziko', 'A2' => 'Veľmi vysoké riziko', 'A3' => 'Veľmi vysoké riziko'],
];
foreach ($kdigoHeatmap as $gCategory => $albuminRows) {
    foreach ($albuminRows as $aCategory => $expectedRisk) {
        $actual = kdigoRisk($gCategory, $aCategory);
        testSame($expectedRisk, $actual['risk'], 'KDIGO ' . $gCategory . '×' . $aCategory);
    }
}

// calculatorParseEgfrToMlMin: rozsah [min, max] v kanonických ml/min/1,73 m².
$egfrErrors = [];
testSame(15.0, calculatorParseEgfrToMlMin('15', EGFR_UNIT_ML_MIN, $egfrErrors, 15.0, 140.0), 'PREVENT eGFR 15 ml/min je v rozsahu');
testSame([], $egfrErrors, 'PREVENT eGFR 15 nepridá chybu');
$egfrErrors = [];
testSame(140.0, calculatorParseEgfrToMlMin('140', EGFR_UNIT_ML_MIN, $egfrErrors, 15.0, 140.0), 'PREVENT eGFR 140 ml/min je v rozsahu');
$egfrErrors = [];
testSame(null, calculatorParseEgfrToMlMin('14,9', EGFR_UNIT_ML_MIN, $egfrErrors, 15.0, 140.0), 'PREVENT eGFR 14,9 je mimo rozsahu');
testSame(true, $egfrErrors !== [], 'PREVENT eGFR 14,9 pridá chybu');
$egfrErrors = [];
// 0,25 ml/s/1,73 m² = 15 ml/min/1,73 m²
testSame(15.0, calculatorParseEgfrToMlMin('0,25', EGFR_UNIT_ML_S, $egfrErrors, 15.0, 140.0), 'PREVENT eGFR 0,25 ml/s (=15) je v rozsahu');
$egfrErrors = [];
testSame(45.0, calculatorParseEgfrToMlMin('45', EGFR_UNIT_ML_MIN, $egfrErrors, 0.0, 200.0), 'Bežné eGFR 45 pri min=0');
$egfrErrors = [];
testSame(null, calculatorParseEgfrToMlMin('0', EGFR_UNIT_ML_MIN, $egfrErrors, 0.0, 200.0), 'eGFR 0 nie je kladné číslo');

echo 'Ambulantná kalkulačka: ' . $assertions . " kontrol prešlo.\n";
