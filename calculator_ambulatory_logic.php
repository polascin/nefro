<?php

declare(strict_types=1);

/**
 * Čisté pomocné funkcie Ambulantnej kalkulačky.
 *
 * Sú bez väzby na HTTP, databázu a HTML, aby sa dali regresne testovať.
 */

function ambulatoryNormalizeSingleLine(string $value, int $maxLength): string
{
    $normalized = preg_replace('/\s+/u', ' ', trim($value));
    if (!is_string($normalized)) {
        return '';
    }

    return mb_substr($normalized, 0, $maxLength, 'UTF-8');
}
function ambulatoryIcd10CodeForGCategory(string $gCategory): string
{
    return match ($gCategory) {
        'G1' => 'N18.1',
        'G2' => 'N18.2',
        'G3a', 'G3b' => 'N18.3',
        'G4' => 'N18.4',
        'G5' => 'N18.5',
        default => 'N18.9',
    };
}

function ambulatoryMainDiagnosis(string $gCategory, bool $chronicityConfirmed, bool $ckdCriteriaMet): string
{
    if (!$chronicityConfirmed) {
        return 'CKD nepotvrdená – kód N18.x zatiaľ neurčený';
    }

    if (!$ckdCriteriaMet) {
        return 'kritériá CKD z uvedených údajov nesplnené – kód neurčený';
    }

    return ambulatoryIcd10CodeForGCategory($gCategory) . ' CKD ' . $gCategory;
}

/**
 * @param list<array{date: \DateTimeImmutable, egfr: float}> $points
 * @return array{slope: float, duration_years: float, count: int}|null
 */
function ambulatoryCalculateEgfrSlope(array $points): ?array
{
    if (count($points) < 2) {
        return null;
    }

    usort(
        $points,
        static fn(array $left, array $right): int =>
            $left['date']->getTimestamp() <=> $right['date']->getTimestamp(),
    );

    $firstTimestamp = $points[0]['date']->getTimestamp();
    $x = [];
    $y = [];

    foreach ($points as $point) {
        $x[] = ($point['date']->getTimestamp() - $firstTimestamp) / 86400.0 / 365.25;
        $y[] = $point['egfr'];
    }

    $count = count($x);
    $meanX = array_sum($x) / $count;
    $meanY = array_sum($y) / $count;
    $numerator = 0.0;
    $denominator = 0.0;

    for ($index = 0; $index < $count; $index++) {
        $xDiff = $x[$index] - $meanX;
        $numerator += $xDiff * ($y[$index] - $meanY);
        $denominator += $xDiff ** 2;
    }

    if ($denominator <= 0.0) {
        return null;
    }

    return [
        'slope' => $numerator / $denominator,
        'duration_years' => max($x),
        'count' => $count,
    ];
}

function ambulatoryFormatNumber(float $value, int $decimals = 1): string
{
    return number_format($value, $decimals, ',', ' ');
}

/**
 * @param array{
 *   main_diagnosis: string,
 *   cga: string,
 *   risks: string,
 *   slope: string,
 *   ga_risk: string,
 *   chronicity: string,
 *   related_diagnoses: string,
 *   complications: string
 * } $summary
 */
function ambulatoryBuildPlainText(array $summary): string
{
    return implode("\n", [
        'Hlavná Dg (MKCH-10): ' . $summary['main_diagnosis'],
        'Klasifikácia KDIGO 2024 – CGA: ' . $summary['cga'],
        $summary['risks'],
        'eGFR Slope: ' . $summary['slope'],
        'Orientačné riziko podľa kombinácie G + A: ' . $summary['ga_risk'],
        'Chronicita abnormalít (≥ 3 mesiace): ' . $summary['chronicity'],
        'Príčinné / pridružené Dg (MKCH-10): ' . $summary['related_diagnoses'],
        'Komplikácie CKD: ' . $summary['complications'],
        'Poznámka k eGFR: pri nesúlade eGFRcr s klinickým obrazom zvážiť eGFRcr-cys (kreatinín + cystatín C).',
    ]);
}
