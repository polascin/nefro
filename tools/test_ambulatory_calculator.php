<?php

declare(strict_types=1);

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

$output = ambulatoryBuildPlainText([
    'main_diagnosis' => 'N18.3 CKD G3b',
    'cga' => 'príčina (Cause) test, kategória G3b, kategória A2',
    'risks' => 'KFRE (...) | CKD-PC (...) | CKM Stage (AHA 2023): 2',
    'slope' => '-2,00 ml/min/1,73 m²/rok',
    'ga_risk' => 'vysoké',
    'chronicity' => 'potvrdená',
    'related_diagnoses' => 'E11.2',
    'complications' => 'anémia',
]);
testSame(true, str_starts_with($output, 'Hlavná Dg (MKCH-10): N18.3 CKD G3b'), 'Začiatok čistého textu');
testSame(true, str_contains($output, 'Poznámka k eGFR:'), 'Povinná poznámka k eGFR');
testSame(9, count(explode("\n", $output)), 'Počet riadkov čistého textu');

echo 'Ambulantná kalkulačka: ' . $assertions . " kontrol prešlo.\n";
