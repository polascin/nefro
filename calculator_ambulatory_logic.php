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

function ambulatoryGCategoryDescription(string $gCategory): string
{
    return match ($gCategory) {
        'G1' => 'normálna alebo vysoká filtrácia',
        'G2' => 'mierne znížená filtrácia',
        'G3a' => 'mierne až stredne znížená filtrácia',
        'G3b' => 'stredne až výrazne znížená filtrácia',
        'G4' => 'výrazne znížená filtrácia',
        'G5' => 'zlyhanie obličiek',
        default => '',
    };
}

function ambulatoryACategoryDescription(string $aCategory): string
{
    return match ($aCategory) {
        'A1' => 'norma až mierne zvýšená albuminúria',
        'A2' => 'stredne zvýšená albuminúria',
        'A3' => 'ťažko zvýšená albuminúria',
        default => '',
    };
}

function ambulatoryGaRiskText(string $riskLabel): string
{
    return match ($riskLabel) {
        'Nízke riziko' => 'nízke',
        'Stredné riziko' => 'stredné',
        'Vysoké riziko' => 'vysoké',
        'Veľmi vysoké riziko' => 'veľmi vysoké',
        default => $riskLabel,
    };
}

function ambulatoryGaRiskKey(string $riskLabel): string
{
    return match ($riskLabel) {
        'Nízke riziko' => 'low',
        'Stredné riziko' => 'moderate',
        'Vysoké riziko' => 'high',
        default => 'veryhigh',
    };
}

function ambulatoryFormatUacrDisplay(float $uacrValue, string $uacrUnit, float $uacrMgG): string
{
    $display = ambulatoryFormatNumber($uacrValue, 2) . ' ' .
        ($uacrUnit === 'mg_mmol' ? 'mg/mmol' : 'mg/g');
    if ($uacrUnit === 'mg_mmol') {
        $display .= ' = ' . ambulatoryFormatNumber($uacrMgG, 1) . ' mg/g';
    }

    return $display;
}

/**
 * @param list<string> $items
 */
function ambulatoryJoinSlovakList(array $items): string
{
    $items = array_values(array_filter($items, static fn(string $item): bool => $item !== ''));
    $count = count($items);
    if ($count === 0) {
        return '';
    }
    if ($count === 1) {
        return $items[0];
    }
    if ($count === 2) {
        return $items[0] . ' a ' . $items[1];
    }

    $last = array_pop($items);

    return implode(', ', $items) . ' a ' . $last;
}

function ambulatoryEgfrNote(): string
{
    return 'Poznámka k eGFR: pri nesúlade eGFRcr s klinickým obrazom zvážiť eGFRcr-cys (kreatinín + cystatín C).';
}

/**
 * Zostaví čistý text do ambulantnej správy. Chýbajúce sekcie a polia vynechá.
 *
 * @param array{
 *   main_diagnosis?: string,
 *   cause?: string,
 *   g_category?: string,
 *   a_category?: string,
 *   chronicity?: string,
 *   ga_risk?: string,
 *   kfre?: string,
 *   ckdpc?: string,
 *   ckm?: string,
 *   slope?: string,
 *   related_diagnoses?: string,
 *   complications?: string,
 *   egfr_note?: bool
 * } $summary
 */
function ambulatoryBuildPlainText(array $summary): string
{
    $blocks = [];

    $mainDiagnosis = trim((string) ($summary['main_diagnosis'] ?? ''));
    if ($mainDiagnosis !== '') {
        $blocks[] = 'Hlavná diagnóza (MKCH-10): ' . $mainDiagnosis;
    }

    $cgaLines = [];
    $cause = trim((string) ($summary['cause'] ?? ''));
    if ($cause !== '') {
        $cgaLines[] = 'Príčina (Cause): ' . $cause;
    }
    $gCategory = trim((string) ($summary['g_category'] ?? ''));
    if ($gCategory !== '') {
        $cgaLines[] = 'Kategória G: ' . $gCategory;
    }
    $aCategory = trim((string) ($summary['a_category'] ?? ''));
    if ($aCategory !== '') {
        $cgaLines[] = 'Kategória A: ' . $aCategory;
    }
    $chronicity = trim((string) ($summary['chronicity'] ?? ''));
    if ($chronicity !== '') {
        $cgaLines[] = 'Chronicita abnormalít (≥ 3 mesiace): ' . $chronicity;
    }
    $gaRisk = trim((string) ($summary['ga_risk'] ?? ''));
    if ($gaRisk !== '') {
        $cgaLines[] = 'Orientačné riziko G+A: ' . $gaRisk;
    }
    if ($cgaLines !== []) {
        $blocks[] = implode("\n", array_merge(['KDIGO 2024 – CGA'], $cgaLines));
    }

    $prognosisLines = [];
    $kfre = trim((string) ($summary['kfre'] ?? ''));
    if ($kfre !== '') {
        $prognosisLines[] = 'KFRE: ' . $kfre;
    }
    $ckdpc = trim((string) ($summary['ckdpc'] ?? ''));
    if ($ckdpc !== '') {
        $prognosisLines[] = 'CKD-PC: ' . $ckdpc;
    }
    $ckm = trim((string) ($summary['ckm'] ?? ''));
    if ($ckm !== '') {
        $prognosisLines[] = 'Štádium CKM (AHA 2023): ' . $ckm;
    }
    $slope = trim((string) ($summary['slope'] ?? ''));
    if ($slope !== '') {
        $prognosisLines[] = 'eGFR slope: ' . $slope;
    }
    if ($prognosisLines !== []) {
        $blocks[] = implode("\n", array_merge(['Prognóza'], $prognosisLines));
    }

    $otherLines = [];
    $relatedDiagnoses = trim((string) ($summary['related_diagnoses'] ?? ''));
    if ($relatedDiagnoses !== '') {
        $otherLines[] = 'Pridružené diagnózy (MKCH-10): ' . $relatedDiagnoses;
    }
    $complications = trim((string) ($summary['complications'] ?? ''));
    if ($complications !== '') {
        $otherLines[] = 'Komplikácie CKD: ' . $complications;
    }
    if ($otherLines !== []) {
        $blocks[] = implode("\n", array_merge(['Ďalšie údaje'], $otherLines));
    }

    if (!empty($summary['egfr_note'])) {
        $blocks[] = ambulatoryEgfrNote();
    }

    return implode("\n\n", $blocks);
}

/**
 * @param array<string, bool> $presentByLabel
 * @return list<string>
 */
function ambulatoryMissingLabels(array $presentByLabel): array
{
    $missing = [];
    foreach ($presentByLabel as $label => $present) {
        if (!$present) {
            $missing[] = $label;
        }
    }

    return $missing;
}

/**
 * Vypočíta len tie časti súhrnu, na ktoré stačia zadané parametre.
 *
 * @param array{
 *   cause: string,
 *   age_years: ?int,
 *   sex: ?string,
 *   egfr: ?float,
 *   uacr_value: ?float,
 *   uacr_unit: ?string,
 *   chronicity: ?string,
 *   repeat_date: ?\DateTimeImmutable,
 *   other_kidney_marker: bool,
 *   related_diagnoses: string,
 *   sbp: ?float,
 *   bmi: ?float,
 *   smoking: ?string,
 *   diabetes: bool,
 *   hba1c: ?float,
 *   antihtn: bool,
 *   hf: bool,
 *   chd: bool,
 *   afib: bool,
 *   insulin: bool,
 *   oral_dm: bool,
 *   asian_ancestry: bool,
 *   increased_waist: bool,
 *   prediabetes: bool,
 *   hypertension: bool,
 *   hypertriglyceridemia: bool,
 *   metabolic_syndrome: bool,
 *   subclinical_cvd: bool,
 *   other_clinical_cvd: bool,
 *   slope_points: list<array{date: \DateTimeImmutable, egfr: float}>,
 *   complications: string
 * } $input
 * @return array{summary: array<string, mixed>, skipped: list<string>}
 */
function ambulatoryComputeReport(array $input): array
{
    $summary = [];
    $skipped = [];

    $cause = trim($input['cause']);
    $egfr = $input['egfr'];
    $uacrValue = $input['uacr_value'];
    $uacrUnit = $input['uacr_unit'];
    $uacrMgG = null;
    if ($uacrValue !== null && $uacrUnit !== null) {
        $uacrMgG = $uacrUnit === 'mg_mmol' ? $uacrValue * 8.84 : $uacrValue;
    }

    $gCategory = $egfr !== null ? ckdGCategory($egfr) : null;
    $aCategory = $uacrMgG !== null ? kdigoACategory($uacrMgG) : null;
    $chronicity = $input['chronicity'];
    $chronicityConfirmed = $chronicity === 'confirmed';

    $meetsCkdCriteria = ($egfr !== null && $egfr < 60.0)
        || ($uacrMgG !== null && $uacrMgG >= 30.0)
        || $input['other_kidney_marker'];
    $canRuleOutCkd = $egfr !== null && $egfr >= 60.0
        && $uacrMgG !== null && $uacrMgG < 30.0
        && !$input['other_kidney_marker'];
    $hasConfirmedCkd = $chronicityConfirmed && $meetsCkdCriteria;

    $hasKidneyContext = $cause !== ''
        || $egfr !== null
        || $uacrMgG !== null
        || $input['other_kidney_marker'];

    if ($gCategory !== null && $chronicity !== null) {
        if ($chronicity === 'unconfirmed') {
            $summary['main_diagnosis'] = ambulatoryMainDiagnosis($gCategory, false, $meetsCkdCriteria);
        } elseif ($meetsCkdCriteria) {
            $summary['main_diagnosis'] = ambulatoryMainDiagnosis($gCategory, true, true);
        } elseif ($canRuleOutCkd) {
            $summary['main_diagnosis'] = ambulatoryMainDiagnosis($gCategory, true, false);
        } else {
            $summary['main_diagnosis'] = 'kritériá CKD neúplné (chýba uACR alebo iný marker) – kód neurčený';
        }
    }

    if ($cause !== '') {
        $summary['cause'] = $cause;
    }

    if ($egfr !== null) {
        $resolvedGCategory = ckdGCategory($egfr);
        $gDescription = ambulatoryGCategoryDescription($resolvedGCategory);
        $gLine = $resolvedGCategory . ' (eGFR ' . ambulatoryFormatNumber($egfr, 1) . ' ml/min/1,73 m²)';
        if ($gDescription !== '') {
            $gLine .= ' – ' . $gDescription;
        }
        $summary['g_category'] = $gLine;
        $summary['egfr_note'] = true;
    }

    if ($uacrValue !== null && $uacrUnit !== null) {
        $resolvedUacrMgG = $uacrUnit === 'mg_mmol' ? $uacrValue * 8.84 : $uacrValue;
        $resolvedACategory = kdigoACategory($resolvedUacrMgG);
        $aDescription = ambulatoryACategoryDescription($resolvedACategory);
        $aLine = $resolvedACategory . ' (uACR ' . ambulatoryFormatUacrDisplay($uacrValue, $uacrUnit, $resolvedUacrMgG) . ')';
        if ($aDescription !== '') {
            $aLine .= ' – ' . $aDescription;
        }
        $summary['a_category'] = $aLine;
    }

    if ($hasKidneyContext && $chronicity === 'unconfirmed') {
        $chronicityText = 'nepotvrdená';
        if ($input['repeat_date'] instanceof \DateTimeImmutable) {
            $chronicityText .= ' – opakovať eGFR/uACR dňa ' .
                $input['repeat_date']->format('d.m.Y') . ' (pri podozrení na AKI skôr)';
        }
        $summary['chronicity'] = $chronicityText;
    } elseif ($hasKidneyContext && $chronicity === 'confirmed') {
        $summary['chronicity'] = 'potvrdená';
    }

    if ($gCategory !== null && $aCategory !== null) {
        $riskInfo = kdigoRisk($gCategory, $aCategory);
        $summary['ga_risk'] = ambulatoryGaRiskText($riskInfo['risk']);
        $gaRiskKey = ambulatoryGaRiskKey($riskInfo['risk']);
    } else {
        $gaRiskKey = null;
        if ($gCategory !== null xor $aCategory !== null) {
            $missingGa = $gCategory === null ? 'eGFR' : 'uACR';
            $skipped[] = 'Orientačné riziko G+A — chýba ' . $missingGa;
        }
    }

    $kfrePresent = [
        'vek (dátum narodenia)' => $input['age_years'] !== null,
        'pohlavie' => $input['sex'] !== null,
        'eGFR' => $egfr !== null,
        'uACR' => $uacrMgG !== null,
    ];
    $ageYears = $input['age_years'];
    $sex = $input['sex'];
    if ($ageYears !== null && $sex !== null && $egfr !== null && $uacrMgG !== null) {
        if ($egfr >= 10.0 && $egfr < 60.0 && $ageYears <= 100) {
            $kfre = kfreRisk($ageYears, $sex, $egfr, $uacrMgG);
            $summary['kfre'] = '2-ročné ' . ambulatoryFormatNumber($kfre['risk_2yr']) .
                ' %; 5-ročné ' . ambulatoryFormatNumber($kfre['risk_5yr']) . ' %';
        } elseif ($ageYears > 100) {
            $summary['kfre'] = 'nevypočítané (vek mimo rozsahu modelu)';
        } else {
            $summary['kfre'] = 'nevypočítané (eGFR mimo 10 až <60 ml/min/1,73 m²)';
        }
    } elseif (count(array_filter($kfrePresent)) >= 2) {
        $skipped[] = 'KFRE — chýba ' . ambulatoryJoinSlovakList(ambulatoryMissingLabels($kfrePresent));
    }

    $ckdpcPresent = $kfrePresent + [
        'systolický TK' => $input['sbp'] !== null,
        'BMI' => $input['bmi'] !== null,
        'fajčenie' => $input['smoking'] !== null,
    ];
    if ($input['diabetes'] && $input['hba1c'] === null) {
        $ckdpcPresent['HbA1c'] = false;
    }
    $sbp = $input['sbp'];
    $bmi = $input['bmi'];
    $smoking = $input['smoking'];
    if (
        $ageYears !== null &&
        $sex !== null &&
        $egfr !== null &&
        $uacrMgG !== null &&
        $sbp !== null &&
        $bmi !== null &&
        $smoking !== null &&
        (!$input['diabetes'] || $input['hba1c'] !== null)
    ) {
        if ($ageYears >= 20 && $ageYears <= 80) {
            $hba1c = $input['diabetes'] ? (float) $input['hba1c'] : 7.0;
            $ckdpc = ckdpcRisk(
                $ageYears,
                $sex,
                $egfr,
                $uacrMgG,
                $input['diabetes'],
                $sbp,
                $input['antihtn'],
                $input['hf'],
                $input['chd'],
                $input['afib'],
                $bmi,
                $smoking,
                $hba1c,
                $input['insulin'],
                $input['oral_dm'],
            );
            $summary['ckdpc'] = '3-ročné ' . ambulatoryFormatNumber($ckdpc['risk_3yr']) .
                ' % (≥40 % pokles eGFR alebo zlyhanie obličiek)';
        } else {
            $summary['ckdpc'] = 'nevypočítané (vek mimo 20–80 rokov)';
        }
    } elseif (count(array_filter($ckdpcPresent)) >= 2) {
        $skipped[] = 'CKD-PC — chýba ' . ambulatoryJoinSlovakList(ambulatoryMissingLabels($ckdpcPresent));
    }

    $clinicalCvd = $input['hf'] || $input['chd'] || $input['afib'] || $input['other_clinical_cvd'];
    $hasCkmInput = $input['bmi'] !== null
        || $input['increased_waist']
        || $input['prediabetes']
        || $input['hypertension']
        || $input['diabetes']
        || $input['hypertriglyceridemia']
        || $input['metabolic_syndrome']
        || $input['subclinical_cvd']
        || $clinicalCvd
        || $hasConfirmedCkd;
    if ($hasCkmInput) {
        $isAsian = $input['asian_ancestry'];
        $adiposity = ($input['bmi'] !== null && $input['bmi'] >= ($isAsian ? 23.0 : 25.0))
            || $input['increased_waist'];
        $kidneyFailure = $hasConfirmedCkd && $egfr !== null && $egfr < 15.0;
        if ($gaRiskKey !== null) {
            $ckdModerateHigh = $hasConfirmedCkd && $gaRiskKey !== 'low';
            $ckdVeryHigh = $hasConfirmedCkd && ($gaRiskKey === 'veryhigh' || $kidneyFailure);
        } else {
            $ckdModerateHigh = $hasConfirmedCkd && $egfr !== null && $egfr < 60.0;
            $ckdVeryHigh = $kidneyFailure;
        }
        $ckmStage = ckmComputeStage(
            $adiposity,
            $input['prediabetes'],
            $input['hypertension'] || $input['diabetes'] || $input['hypertriglyceridemia'] || $input['metabolic_syndrome'],
            $ckdModerateHigh,
            $ckdVeryHigh,
            $input['subclinical_cvd'],
            $clinicalCvd,
            $kidneyFailure,
        );
        $summary['ckm'] = $ckmStage['code'] . ' – ' . ckmStageLabel($ckmStage['code']);
    }

    $slopeResult = ambulatoryCalculateEgfrSlope($input['slope_points']);
    if ($slopeResult !== null) {
        $summary['slope'] = ambulatoryFormatNumber($slopeResult['slope'], 2) .
            ' ml/min/1,73 m²/rok (merania: ' . $slopeResult['count'] .
            '; obdobie: ' . ambulatoryFormatNumber($slopeResult['duration_years'], 1) . ' r.)';
    } elseif ($egfr !== null && count($input['slope_points']) < 2) {
        $skipped[] = 'eGFR slope — chýba predchádzajúce meranie';
    }

    if ($input['related_diagnoses'] !== '') {
        $summary['related_diagnoses'] = $input['related_diagnoses'];
    }
    if ($input['complications'] !== '') {
        $summary['complications'] = $input['complications'];
    }

    return [
        'summary' => $summary,
        'skipped' => array_values(array_unique($skipped)),
    ];
}
