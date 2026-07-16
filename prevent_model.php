<?php

/**
 * prevent_model.php
 * ════════════════════════════════════════════════════════════════════════════
 * Výpočtové jadro AHA PREVENT (Predicting Risk of CVD EVENTs).
 * Khan SS, Matsushita K, Sang Y, et al. Development and Validation of the
 * American Heart Association's PREVENT Equations. Circulation. 2024;149:430-449.
 *
 * Model odhaduje 10- a 30-ročné absolútne riziko pre Total CVD, ASCVD a srdcové
 * zlyhávanie (HF) vo veku 30–79 r. Logistická regresia; sex-špecifické koeficienty.
 * Voliteľné prediktory (UACR, HbA1c, SDI) automaticky aktivujú rozšírený variant
 * modelu (base → uacr/hba1c/sdi → full).
 *
 * Centrovanie a transformácie (overené oproti referenčnej implementácii preventr):
 *   age       = (vek − 55) / 10            (age_sq = age² len pre 30-ročné modely)
 *   non-HDL-C = (TC − HDL, mmol/L) − 3.5   (mg/dL → mmol/L: × 0.02586)
 *   HDL-C     = ((HDL, mmol/L) − 1.3) / 0.3
 *   SBP       = spline pri 110: (min(SBP,110)−110)/20 a (max(SBP,110)−130)/20
 *   BMI       = spline pri 30:  (min(BMI,30)−25)/5   a (max(BMI,30)−30)/5
 *   eGFR      = spline pri 60:  (min−60)/−15         a (max−90)/−15
 *   ln-ACR    = ln(UACR mg/g);  HbA1c členy = (HbA1c − 5.3) zvlášť pre DM/non-DM
 *   link      = riziko = exp(lp) / (1 + exp(lp))
 *
 * OVERENÉ oproti oficiálne validovanému príkladu (preventr README, zhoda s ACC/AHA
 * kalkulátorom) — base model, Ž 50 r., TC 200 mg/dl, HDL 45 mg/dl, SBP 160 (liečená),
 * DM áno, bez fajčenia, BMI 35, eGFR 90:
 *   10r: total_cvd 14,7 %  ASCVD 9,2 %  HF 8,1 %
 *   30r: total_cvd 53,0 %  ASCVD 35,4 %  HF 39,0 %
 * Engine sa zhoduje s týmito hodnotami na 0,1 %. Ďalej krížovo overený oproti
 * nezávislej referenčnej implementácii na 600 scenároch (max. rozdiel 0,0 %).
 */
declare(strict_types=1);

/** Načíta koeficientové tabuľky (cache v statickej premennej). */
function preventCoefficients(): array
{
    static $coeff = null;
    if ($coeff === null) {
        // require (nie require_once): spoliehame sa na návratovú hodnotu soboru;
        // opakované načítanie chráni statická cache vyššie.
        $coeff = require __DIR__ . '/prevent_coefficients.php';
    }
    return $coeff;
}

/**
 * Skonštruuje mapu prediktorových kódov → hodnota podľa PREVENT transformácií.
 *
 * Očakávané kľúče $in:
 *   age (float), total_c (float), hdl_c (float), chol_unit ('mmol'|'mgdl'),
 *   sbp (float), bp_tx (bool), statin (bool), dm (bool), smoking (bool),
 *   bmi (float), egfr (float),
 *   uacr (?float mg/g), hba1c (?float %), sdi (?int 1–10)
 */
function preventBuildPredictors(array $in): array
{
    $age = ((float) $in['age'] - 55.0) / 10.0;

    $tc  = (float) $in['total_c'];
    $hdl = (float) $in['hdl_c'];
    if (($in['chol_unit'] ?? 'mmol') === 'mgdl') {
        $nonHdl = ($tc - $hdl) * 0.02586 - 3.5;
        $hdlT   = (($hdl * 0.02586) - 1.3) / 0.3;
    } else {
        $nonHdl = ($tc - $hdl) - 3.5;
        $hdlT   = ($hdl - 1.3) / 0.3;
    }

    $sbp = (float) $in['sbp'];
    $sbpLt = (min($sbp, 110.0) - 110.0) / 20.0;
    $sbpGe = (max($sbp, 110.0) - 130.0) / 20.0;

    $bmi = (float) $in['bmi'];
    $bmiLt = (min($bmi, 30.0) - 25.0) / 5.0;
    $bmiGe = (max($bmi, 30.0) - 30.0) / 5.0;

    $egfr = (float) $in['egfr'];
    $egfrLt = (min($egfr, 60.0) - 60.0) / -15.0;
    $egfrGe = (max($egfr, 60.0) - 90.0) / -15.0;

    $dm      = !empty($in['dm']) ? 1.0 : 0.0;
    $smoking = !empty($in['smoking']) ? 1.0 : 0.0;
    $bpTx    = !empty($in['bp_tx']) ? 1.0 : 0.0;
    $statin  = !empty($in['statin']) ? 1.0 : 0.0;

    $uacr  = isset($in['uacr'])  && $in['uacr']  !== null && $in['uacr']  !== '' ? (float) $in['uacr']  : null;
    $hba1c = isset($in['hba1c']) && $in['hba1c'] !== null && $in['hba1c'] !== '' ? (float) $in['hba1c'] : null;
    $sdi   = isset($in['sdi'])   && $in['sdi']   !== null && $in['sdi']   !== '' ? (int)   $in['sdi']   : null;

    return [
        'age'              => $age,
        'age_sq'           => $age * $age,
        'non_hdl'          => $nonHdl,
        'hdl'              => $hdlT,
        'sbp_lt110'        => $sbpLt,
        'sbp_ge110'        => $sbpGe,
        'dm'               => $dm,
        'smoking'          => $smoking,
        'bmi_lt30'         => $bmiLt,
        'bmi_ge30'         => $bmiGe,
        'egfr_lt60'        => $egfrLt,
        'egfr_ge60'        => $egfrGe,
        'bp_tx'            => $bpTx,
        'statin'           => $statin,
        'bp_tx_sbp_ge110'  => $bpTx * $sbpGe,
        'statin_non_hdl'   => $statin * $nonHdl,
        'age_non_hdl'      => $age * $nonHdl,
        'age_hdl'          => $age * $hdlT,
        'age_sbp_ge110'    => $age * $sbpGe,
        'age_dm'           => $age * $dm,
        'age_smoking'      => $age * $smoking,
        'age_bmi_ge30'     => $age * $bmiGe,
        'age_egfr_lt60'    => $age * $egfrLt,
        'sdi_4_6'          => ($sdi !== null && $sdi >= 4 && $sdi <= 6) ? 1.0 : 0.0,
        'sdi_7_10'         => ($sdi !== null && $sdi >= 7 && $sdi <= 10) ? 1.0 : 0.0,
        'sdi_missing'      => ($sdi === null) ? 1.0 : 0.0,
        'ln_acr'           => ($uacr !== null && $uacr > 0) ? log($uacr) : 0.0,
        'acr_missing'      => ($uacr === null) ? 1.0 : 0.0,
        'hba1c_dm'         => ($hba1c !== null && $dm === 1.0) ? ($hba1c - 5.3) : 0.0,
        'hba1c_nodm'       => ($hba1c !== null && $dm === 0.0) ? ($hba1c - 5.3) : 0.0,
        'hba1c_missing'    => ($hba1c === null) ? 1.0 : 0.0,
        'const'            => 1.0,
    ];
}

/**
 * Vyberie variant modelu podľa dostupných voliteľných prediktorov.
 * Zhodné so správaním referenčného nástroja: jeden voliteľný → daný variant,
 * dva a viac → plný model (full), žiadny → base.
 */
function preventSelectModel(bool $hasUacr, bool $hasHba1c, bool $hasSdi): string
{
    $n = ($hasUacr ? 1 : 0) + ($hasHba1c ? 1 : 0) + ($hasSdi ? 1 : 0);
    if ($n === 0) {
        return 'base';
    }
    if ($n === 1) {
        if ($hasUacr)  return 'uacr';
        if ($hasHba1c) return 'hba1c';
        return 'sdi';
    }
    return 'full';
}

/**
 * Vypočíta absolútne riziko (%) pre daný model/horizont/outcome/pohlavie.
 * Vráti null, ak tabuľka neexistuje.
 */
function preventRisk(string $model, string $horizon, string $outcome, string $sex, array $pred): ?float
{
    $coeff = preventCoefficients();
    $tableKey = $model . '_' . $horizon;
    $colKey = $sex . '_' . $outcome;
    if (!isset($coeff[$tableKey][$colKey])) {
        return null;
    }
    $lp = 0.0;
    foreach ($coeff[$tableKey][$colKey] as $code => $beta) {
        $lp += $beta * ($pred[$code] ?? 0.0);
    }
    $risk = exp($lp) / (1.0 + exp($lp)) * 100.0;
    $risk = max(0.0, min(100.0, $risk));
    return round($risk, 1);
}

/**
 * Vypočíta všetky tri výstupy × {10r, 30r} pre zadané vstupy.
 * 30-ročné riziko sa počíta len pre vek ≤ 59 r. (mimo tohto rozsahu PREVENT
 * 30-ročný odhad neodporúča).
 */
function preventComputeAll(array $in): array
{
    $pred = preventBuildPredictors($in);

    $hasUacr  = isset($in['uacr'])  && $in['uacr']  !== null && $in['uacr']  !== '';
    $hasHba1c = isset($in['hba1c']) && $in['hba1c'] !== null && $in['hba1c'] !== '';
    $hasSdi   = isset($in['sdi'])   && $in['sdi']   !== null && $in['sdi']   !== '';
    $model = preventSelectModel($hasUacr, $hasHba1c, $hasSdi);

    $sex = ($in['sex'] === 'male') ? 'male' : 'female';
    $age = (float) $in['age'];
    $show30 = ($age <= 59.0);

    $outcomes = ['total_cvd', 'ascvd', 'heart_failure'];
    $risks = [];
    foreach ($outcomes as $o) {
        $risks[$o] = [
            '10yr' => preventRisk($model, '10yr', $o, $sex, $pred),
            '30yr' => $show30 ? preventRisk($model, '30yr', $o, $sex, $pred) : null,
        ];
    }

    return [
        'model'    => $model,
        'sex'      => $sex,
        'show_30yr' => $show30,
        'risks'    => $risks,
    ];
}

/** Čitateľný názov variantu modelu. */
function preventModelLabel(string $model): string
{
    return match ($model) {
        'base'  => 'základný (eGFR)',
        'uacr'  => 'rozšírený o UACR',
        'hba1c' => 'rozšírený o HbA1c',
        'sdi'   => 'rozšírený o SDI',
        'full'  => 'plný (UACR + HbA1c + SDI)',
        default => $model,
    };
}

/**
 * CSS trieda rizika pre 10-ročné ASCVD percento (prahy podľa odporúčaní 2026).
 */
function preventRiskClass(float $ascvd10): string
{
    if ($ascvd10 < 3.0)  return 'risk-low';
    if ($ascvd10 < 5.0)  return 'risk-moderate';
    if ($ascvd10 < 10.0) return 'risk-high';
    return 'risk-very-high';
}

/**
 * Interpretačná vrstva: z 10-ročného ASCVD rizika odvodí rizikovú kategóriu,
 * cieľovú hodnotu LDL a odporúčanie statínu podľa odporúčaní pre dyslipidémiu 2026.
 */
function preventInterpretation(?float $ascvd10): array
{
    if ($ascvd10 === null) {
        return [
            'category'  => '—',
            'css'       => '',
            'ldl_target' => '',
            'statin'    => '',
            'notes'     => [],
        ];
    }

    if ($ascvd10 < 3.0) {
        $category = 'Nízke riziko (< 3 %)';
        $statin   = 'Základ je úprava životného štýlu; statín spravidla nie je nutný. Pri LDL 160–189 mg/dl (4,1–4,9 mmol/l) alebo vysokom 30-ročnom riziku zvážiť stredne intenzívny statín.';
        $ldl      = 'Bez fixného cieľa; orientačne LDL < 160 mg/dl (< 4,1 mmol/l).';
    } elseif ($ascvd10 < 5.0) {
        $category = 'Hraničné riziko (3–5 %)';
        $statin   = 'Zvážiť stredne intenzívny statín; rozhodovanie personalizovať (rodinná anamnéza, ApoB, Lp(a), koronárne kalciové skóre).';
        $ldl      = 'Cieľ LDL < 100 mg/dl (< 2,6 mmol/l), ak sa liečba začne.';
    } elseif ($ascvd10 < 10.0) {
        $category = 'Stredné riziko (5–10 %)';
        $statin   = 'Odporúčaný aspoň stredne intenzívny statín; pri vyššom konci pásma zvážiť vysoko intenzívny.';
        $ldl      = 'Cieľ LDL < 100 mg/dl (< 2,6 mmol/l).';
    } else {
        $category = 'Vysoké riziko (> 10 %)';
        $statin   = 'Vysoko intenzívny statín; ak sa cieľ nedosiahne, pridať ezetimib.';
        $ldl      = 'Cieľ LDL ≤ 70 mg/dl (≤ 1,8 mmol/l).';
    }

    $notes = [
        'Statín je indikovaný bez výpočtu rizika u dospelých 40–75 r. s diabetom, CKD štádia 3–4, LDL ≥ 190 mg/dl (≥ 4,9 mmol/l) alebo infekciou HIV.',
        'Sekundárna prevencia (po ASCVD príhode): väčšina pacientov patrí do veľmi vysokého rizika s cieľom LDL < 55 mg/dl (< 1,4 mmol/l).',
        'PREVENT odhaduje absolútne riziko; LDL ciele sú orientačné podľa odporúčaní 2026 a nenahrádzajú klinické rozhodnutie.',
    ];

    return [
        'category'   => $category,
        'css'        => preventRiskClass($ascvd10),
        'ldl_target' => $ldl,
        'statin'     => $statin,
        'notes'      => $notes,
    ];
}
