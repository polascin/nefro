<?php

declare(strict_types=1);

/**
 * Čisté EKFC funkcie (bez HTTP/DB).
 *
 * Pottel H, et al. Ann Intern Med 2021;174:183–191 (kreatinín)
 * Pottel H, et al. N Engl J Med 2023;388:333–343 (cystatín C)
 */

/** Prepočtový faktor kreatinínu: 1 mg/dL = 88,4 µmol/L. */
const EKFC_CREATININE_UMOL_PER_MGDL = 88.4;

/**
 * Q — medián normálneho sérového kreatinínu pre daný vek a pohlavie [µmol/L].
 */
function ekfcQCreatinineUmol(float $ageYears, string $sex): float
{
    if ($ageYears > 25.0) {
        return $sex === 'female' ? 62.0 : 80.0;
    }

    $a = $ageYears;
    if ($sex === 'female') {
        $lnQ = 3.080
            + 0.177 * $a
            - 0.223 * log($a)
            - 0.00596 * ($a ** 2)
            + 0.0000686 * ($a ** 3);
    } else {
        $lnQ = 3.200
            + 0.259 * $a
            - 0.543 * log($a)
            - 0.00763 * ($a ** 2)
            + 0.0000790 * ($a ** 3);
    }

    return exp($lnQ);
}

/**
 * Q — medián normálneho cystatínu C [mg/L].
 */
function ekfcQCystatin(float $ageYears): float
{
    if ($ageYears < 50.0) {
        return 0.83;
    }

    return 0.83 + 0.005 * ($ageYears - 50.0);
}

/**
 * Jadro rovnice EKFC.
 *
 * @return array{ratio: float, exponent: float, base: float, age_factor: float, egfr: float}
 */
function ekfcCore(float $biomarker, float $q, float $ageYears): array
{
    $ratio = $biomarker / $q;
    $exponent = $ratio < 1.0 ? -0.322 : -1.132;
    $base = 107.3 * ($ratio ** $exponent);
    $ageFactor = $ageYears > 40.0 ? 0.990 ** ($ageYears - 40.0) : 1.0;

    return [
        'ratio' => $ratio,
        'exponent' => $exponent,
        'base' => $base,
        'age_factor' => $ageFactor,
        'egfr' => $base * $ageFactor,
    ];
}

/**
 * CKD-EPI 2021 (kreatinín) — len na porovnanie s EKFC u dospelých.
 * Vyžaduje načítané calculators_common.php.
 */
function ekfcCompareCkdEpi2021(float $creatinineMgDl, float $ageYears, string $sex): float
{
    return calculatorCkdEpi2021FromCreatinineMgDl($creatinineMgDl, (int) $ageYears, $sex);
}
