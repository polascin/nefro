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

function ambulatoryPostedCodeList(mixed $posted): string
{
    if (is_array($posted)) {
        $codes = [];
        foreach ($posted as $code) {
            if (is_string($code) && $code !== '') {
                $codes[] = $code;
            }
        }

        return implode(', ', $codes);
    }

    return is_string($posted) ? $posted : '';
}

/**
 * @param list<string> $codes
 */
function ambulatoryFormatCause(array $codes, string $note): string
{
    $parts = [];
    if ($codes !== []) {
        $parts[] = implode(', ', $codes);
    }
    if ($note !== '') {
        $parts[] = $note;
    }

    return implode('; ', $parts);
}

/**
 * @return array{year: int, month: int, day: int, precision: 'year'|'month'|'day'}|null
 */
function ambulatoryParseBirthInput(string $raw): ?array
{
    $normalized = preg_replace('/[\s\x{00A0}]+/u', '', trim($raw));
    if (!is_string($normalized) || $normalized === '') {
        return null;
    }
    $normalized = str_replace(['–', '—', '\\'], '-', $normalized);

    $year = 0;
    $month = 1;
    $day = 1;
    $precision = 'year';

    if (preg_match('/^(\d{4})$/', $normalized, $match) === 1) {
        $year = (int) $match[1];
    } elseif (preg_match('/^(\d{4})[.\/-](\d{1,2})$/', $normalized, $match) === 1) {
        $year = (int) $match[1];
        $month = (int) $match[2];
        $precision = 'month';
    } elseif (preg_match('/^(\d{1,2})[.\/-](\d{4})$/', $normalized, $match) === 1) {
        $year = (int) $match[2];
        $month = (int) $match[1];
        $precision = 'month';
    } elseif (preg_match('/^(\d{4})[.\/-](\d{1,2})[.\/-](\d{1,2})$/', $normalized, $match) === 1) {
        $year = (int) $match[1];
        $month = (int) $match[2];
        $day = (int) $match[3];
        $precision = 'day';
    } elseif (preg_match('/^(\d{1,2})[.\/-](\d{1,2})[.\/-](\d{4})$/', $normalized, $match) === 1) {
        $year = (int) $match[3];
        $month = (int) $match[2];
        $day = (int) $match[1];
        $precision = 'day';
    } else {
        return null;
    }

    if ($year < 1880 || $year > 2100 || !checkdate($month, $day, $year)) {
        return null;
    }

    return [
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'precision' => $precision,
    ];
}

/**
 * @param array{year: int, month: int, day: int, precision?: string} $birth
 */
function ambulatoryAgeAtExamination(array $birth, \DateTimeImmutable $examinationDate): ?int
{
    if (!checkdate($birth['month'], $birth['day'], $birth['year'])) {
        return null;
    }

    $birthDate = \DateTimeImmutable::createFromFormat(
        '!Y-m-d',
        sprintf('%04d-%02d-%02d', $birth['year'], $birth['month'], $birth['day']),
    );
    if (!$birthDate instanceof \DateTimeImmutable) {
        return null;
    }

    $diff = $birthDate->diff($examinationDate);
    if ($diff->invert === 1) {
        return null;
    }

    return (int) $diff->y;
}

function ambulatoryYearsWord(int $years): string
{
    if ($years === 1) {
        return 'rok';
    }
    $mod100 = $years % 100;
    $mod10 = $years % 10;
    if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 12 || $mod100 > 14)) {
        return 'roky';
    }

    return 'rokov';
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
        'Pridružené Dg (MKCH-10): ' . $summary['related_diagnoses'],
        'Komplikácie CKD: ' . $summary['complications'],
        'Poznámka k eGFR: pri nesúlade eGFRcr s klinickým obrazom zvážiť eGFRcr-cys (kreatinín + cystatín C).',
    ]);
}
