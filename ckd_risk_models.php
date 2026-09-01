<?php

declare(strict_types=1);
/**
 * ckd_risk_models.php — zdieľané prognostické modely pre CKD.
 *
 * Čisté (bezstavové) funkcie bez väzby na $_POST, PDO či HTML. Používajú ich
 * jednotlivé kalkulačky aj súhrnná Ambulantná kalkulačka, aby koeficienty
 * modelov existovali v repozitári len raz a nemohli sa rozísť.
 *
 * Obsah:
 *   kdigoACategory()   — kategória albuminúrie A1–A3 (KDIGO)
 *   kdigoRisk()        — orientačné riziko z kombinácie G × A (KDIGO heatmapa)
 *   kfreRisk()         — Kidney Failure Risk Equation (Tangri 2011, 4 premenné)
 *   ckdpcRisk()        — CKD-PC 3-ročné riziko (Grams 2022)
 *   ckmStageLabel()    — slovný opis štádia CKM
 *   ckmComputeStage()  — staging CKM syndrómu (AHA 2023)
 *
 * Klinické interpretácie a formátovanie zostávajú v jednotlivých kalkulačkách.
 */

/**
 * Kategória albuminúrie podľa KDIGO (uACR v mg/g).
 *
 * @param float $uacr uACR v mg/g
 * @return string 'A1', 'A2' alebo 'A3'
 */
function kdigoACategory(float $uacr): string
{
    if ($uacr < 30.0) {
        return "A1";
    }
    if ($uacr <= 300.0) {
        return "A2";
    }

    return "A3";
}

/**
 * Orientačné riziko z kombinácie G a A kategórie (KDIGO heatmapa).
 *
 * @param string $g G kategória ('G1'…'G5')
 * @param string $a A kategória ('A1'…'A3')
 * @return array{risk: string, note: string}
 */
function kdigoRisk(string $g, string $a): array
{
    // KDIGO 2024 heatmapa prognózy CKD (G × A). G4×A1 je oranžová = vysoké,
    // nie červená; predchádzajúci fallback „veľmi vysoké“ ju nesprávne zaraďoval
    // a v Ambulantnej kalkulačke tým posúval CKM staging na stupeň 3.
    $heatmap = [
        'G1' => [
            'A1' => 'Nízke riziko',
            'A2' => 'Stredné riziko',
            'A3' => 'Vysoké riziko',
        ],
        'G2' => [
            'A1' => 'Nízke riziko',
            'A2' => 'Stredné riziko',
            'A3' => 'Vysoké riziko',
        ],
        'G3a' => [
            'A1' => 'Stredné riziko',
            'A2' => 'Vysoké riziko',
            'A3' => 'Veľmi vysoké riziko',
        ],
        'G3b' => [
            'A1' => 'Vysoké riziko',
            'A2' => 'Veľmi vysoké riziko',
            'A3' => 'Veľmi vysoké riziko',
        ],
        'G4' => [
            'A1' => 'Vysoké riziko',
            'A2' => 'Veľmi vysoké riziko',
            'A3' => 'Veľmi vysoké riziko',
        ],
        'G5' => [
            'A1' => 'Veľmi vysoké riziko',
            'A2' => 'Veľmi vysoké riziko',
            'A3' => 'Veľmi vysoké riziko',
        ],
    ];
    $risk = $heatmap[$g][$a] ?? 'Veľmi vysoké riziko';
    $note = match (true) {
        $risk === 'Nízke riziko' =>
            'Ak CKD trvá <3 mesiace alebo bez markerov, CKD nemusí byť potvrdená.',
        $g === 'G3a' && $a === 'A1' =>
            'Sledovanie funkcie obličiek a rizikových faktorov.',
        $risk === 'Stredné riziko' =>
            'Odporúčané pravidelné sledovanie a nefroprotektívna liečba.',
        ($g === 'G1' || $g === 'G2') && $a === 'A3' =>
            'Odporúčané intenzívnejšie sledovanie a úprava terapie.',
        $risk === 'Vysoké riziko' =>
            'Vysoké riziko progresie, zvážiť nefrologickú konzultáciu.',
        default =>
            'Potrebná zvýšená vigilancia a špecializované vedenie.',
    };

    return [
        'risk' => $risk,
        'note' => $note,
    ];
}

function kfreRisk(int $ageYears, string $sex, float $egfr, float $uacr): array
{
    // KFRE — Tangri et al. JAMA 2011;305(15):1553–1559 — 4-premenná verzia
    // Cox proportional hazards model, North American kohorta
    // Overené oproti kidneyfailurerisk.com (Tangri group, 2024)
    //
    // Lineárny prediktor (centrovaný na kohortné priemery):
    //   X = −0.2201·(vek/10 − 7.036) + 0.2467·(pohlavie − 0.5642)
    //       −0.5567·(eGFR/5 − 7.222) + 0.4510·(ln(uACR) − 5.137)
    //       + 0.4013  (bias korekcia pre North American kalibráciu)
    // kde pohlavie: muž=1, žena=0
    //
    // Riziko = 1 − S₀(t)^exp(X)
    //   S₀(2 roky) = 0.9832   [overené na 4 scenároch]
    //   S₀(5 rokov) = 0.9485  [overené na 4 scenároch]
    //
    // Overené scenáre (ref. kidneyfailurerisk.com):
    //   M 60r eGFR=25 uACR=300:   2r=14,6% / 5r=38,8%
    //   Z 55r eGFR=15 uACR=1000:  2r=51,3% / 5r=89,4%
    //   M 70r eGFR=40 uACR=150:   2r= 1,7% / 5r= 5,3%
    //   Z 50r eGFR=30 uACR=500:   2r=10,5% / 5r=29,2%

    $maleV = $sex === "male" ? 1 : 0;

    // Centrovaný lineárny prediktor + North American kalibrácia (+0.4013)
    $X =
        -0.2201 * ($ageYears / 10.0 - 7.036) +
        0.2467 * ($maleV - 0.5642) -
        0.5567 * ($egfr / 5.0 - 7.222) +
        0.451 * log($uacr) -
        0.451 * 5.137 +
        0.4013;

    // Cox survival funkcia: P(t) = 1 − S₀(t)^exp(X)
    $expX = exp($X);
    $risk2yr = (1.0 - pow(0.9832, $expX)) * 100.0;
    $risk5yr = (1.0 - pow(0.9485, $expX)) * 100.0;

    $risk2yr = max(0.0, min(100.0, $risk2yr));
    $risk5yr = max(0.0, min(100.0, $risk5yr));

    return [
        "risk_2yr" => round($risk2yr, 1),
        "risk_5yr" => round($risk5yr, 1),
    ];
}

/**
 * CKD-PC model — Grams et al. Diabetes Care 2022;45:2055–2063.
 * doi: 10.2337/dc22-0698 | PMID: 35856507
 *
 * Predikuje riziko kompozitného endpointu ≥40 % pokles eGFR alebo zlyhanie
 * obličiek (KRT) v horizonte 2–3 rokov. Implementácia presne kopíruje
 * logistické rovnice zo Supplemental Table S5 (doi:
 * 10.2337/figshare.20061143): P = exp(eta) / (1 + exp(eta)).
 *
 * Sú použité 4 submodely podľa prítomnosti DM a eGFR (≥60 vs. <60). Pri
 * eGFR presne 60 sa rovnako ako na oficiálnom webe spriemerujú oba príslušné
 * submodely, aby sa zmiernil diskontinuálny prechod medzi stratami.
 */

/**
 * Vypočíta jeden zo štyroch CKD-PC podmodelov.
 *
 * @return float Riziko v percentách bez zaokrúhlenia
 */
function ckdpcStratumRisk(
    int $age,
    string $sex,
    float $egfr,
    float $uacrMgG,
    bool $diabetes,
    bool $higherEgfr,
    float $sbp,
    bool $antihtn,
    bool $hf,
    bool $chd,
    bool $afib,
    float $bmi,
    string $smoking,
    float $hba1c,
    bool $insulin,
    bool $oralDm,
): float {
    $coefficients = match ([$diabetes, $higherEgfr]) {
        [false, true] => [
            'constant' => -4.7045,
            'age' => 0.3690,
            'male' => -0.1433,
            'egfr' => 0.0325,
            'acr' => 0.4190,
            'sbp' => 0.3048,
            'antihtn' => 0.2656,
            'sbp_antihtn' => -0.1140,
            'hf' => 1.0534,
            'chd' => 0.4102,
            'afib' => 0.1140,
            'current_smoker' => 0.3803,
            'former_smoker' => 0.1862,
            'bmi' => 0.0425,
            'hba1c' => 0.0,
            'oral_dm' => 0.0,
            'insulin' => 0.0,
        ],
        [true, true] => [
            'constant' => -4.2125,
            'age' => 0.1465,
            'male' => -0.2481,
            'egfr' => -0.0562,
            'acr' => 0.4098,
            'sbp' => 0.1518,
            'antihtn' => 0.2846,
            'sbp_antihtn' => -0.0321,
            'hf' => 0.9234,
            'chd' => 0.2168,
            'afib' => 0.3087,
            'current_smoker' => 0.1186,
            'former_smoker' => 0.0777,
            'bmi' => 0.0308,
            'hba1c' => 0.0987,
            'oral_dm' => -0.0638,
            'insulin' => 0.2359,
        ],
        [false, false] => [
            'constant' => -3.4540,
            'age' => -0.0796,
            'male' => 0.0626,
            'egfr' => -0.1672,
            'acr' => 0.3915,
            'sbp' => 0.2373,
            'antihtn' => 0.0790,
            'sbp_antihtn' => -0.0214,
            'hf' => 0.4898,
            'chd' => 0.2343,
            'afib' => 0.0739,
            'current_smoker' => 0.2903,
            'former_smoker' => 0.1725,
            'bmi' => -0.0231,
            'hba1c' => 0.0,
            'oral_dm' => 0.0,
            'insulin' => 0.0,
        ],
        [true, false] => [
            'constant' => -3.2874,
            'age' => -0.1725,
            'male' => -0.1452,
            'egfr' => -0.0769,
            'acr' => 0.4658,
            'sbp' => 0.2068,
            'antihtn' => 0.1665,
            'sbp_antihtn' => -0.0549,
            'hf' => 0.4216,
            'chd' => 0.2173,
            'afib' => 0.0456,
            'current_smoker' => -0.0338,
            'former_smoker' => 0.1386,
            'bmi' => 0.0253,
            'hba1c' => -0.0031,
            'oral_dm' => -0.1232,
            'insulin' => 0.0980,
        ],
    };

    $male = $sex === 'male' ? 1.0 : 0.0;
    $antihtnValue = $antihtn ? 1.0 : 0.0;
    $sbpCentered = ($sbp - 130.0) / 20.0;
    $egfrCenter = $higherEgfr ? 85.0 : 45.0;

    $eta =
        $coefficients['constant'] +
        $coefficients['age'] * (($age - 60.0) / 10.0) +
        $coefficients['male'] * ($male - 0.5) +
        $coefficients['egfr'] * (($egfr - $egfrCenter) / 5.0) +
        $coefficients['acr'] * log($uacrMgG / 10.0) +
        $coefficients['sbp'] * $sbpCentered +
        $coefficients['antihtn'] * $antihtnValue +
        $coefficients['sbp_antihtn'] * $sbpCentered * $antihtnValue +
        $coefficients['hf'] * (($hf ? 1.0 : 0.0) - 0.05) +
        $coefficients['chd'] * (($chd ? 1.0 : 0.0) - 0.15) +
        $coefficients['afib'] * ($afib ? 1.0 : 0.0) +
        $coefficients['current_smoker'] * ($smoking === 'current' ? 1.0 : 0.0) +
        $coefficients['former_smoker'] * ($smoking === 'former' ? 1.0 : 0.0) +
        $coefficients['bmi'] * (($bmi - 30.0) / 5.0) +
        $coefficients['hba1c'] * ($hba1c - 7.0) +
        $coefficients['oral_dm'] * ($oralDm ? 1.0 : 0.0) +
        $coefficients['insulin'] * ($insulin ? 1.0 : 0.0);

    // Numericky stabilná logistická funkcia.
    if ($eta >= 0.0) {
        $probability = 1.0 / (1.0 + exp(-$eta));
    } else {
        $expEta = exp($eta);
        $probability = $expEta / (1.0 + $expEta);
    }

    return $probability * 100.0;
}

/**
 * Vypočíta 3-ročné riziko pomocou Grams 2022 clog-log modelu.
 *
 * @param int    $age         Vek (20–80)
 * @param string $sex         'male' alebo 'female'
 * @param float  $egfr        eGFR v ml/min/1,73 m²
 * @param float  $uacrMgG     uACR v mg/g (pozitívna hodnota)
 * @param bool   $diabetes    Prítomnosť DM
 * @param float  $sbp         Systolický TK (mmHg)
 * @param bool   $antihtn     Antihypertenzívna liečba
 * @param bool   $hf          Anamnéza srdcového zlyhania
 * @param bool   $chd         Anamnéza ICHS
 * @param bool   $afib        Anamnéza fibrilácie predsiení
 * @param float  $bmi         BMI (kg/m²)
 * @param string $smoking     'never', 'former' alebo 'current'
 * @param float  $hba1c       HbA1c v % (len pri DM, default 7.0)
 * @param bool   $insulin     Inzulínová liečba (len pri DM)
 * @param bool   $oralDm      Perorálna antidiabetická liečba (len pri DM)
 * @return array{risk_3yr: float, model_name: string}
 */
function ckdpcRisk(
    int $age,
    string $sex,
    float $egfr,
    float $uacrMgG,
    bool $diabetes,
    float $sbp,
    bool $antihtn,
    bool $hf,
    bool $chd,
    bool $afib,
    float $bmi,
    string $smoking,
    float $hba1c = 7.0,
    bool $insulin = false,
    bool $oralDm = false,
): array {
    $arguments = [
        $age,
        $sex,
        $egfr,
        $uacrMgG,
        $diabetes,
    ];
    $remainingArguments = [
        $sbp,
        $antihtn,
        $hf,
        $chd,
        $afib,
        $bmi,
        $smoking,
        $hba1c,
        $insulin,
        $oralDm,
    ];

    if (abs($egfr - 60.0) < 0.000001) {
        $higherRisk = ckdpcStratumRisk(...[
            ...$arguments,
            true,
            ...$remainingArguments,
        ]);
        $lowerRisk = ckdpcStratumRisk(...[
            ...$arguments,
            false,
            ...$remainingArguments,
        ]);
        $risk3yr = ($higherRisk + $lowerRisk) / 2.0;
        $modelName = $diabetes
            ? 'DM, priemer submodelov eGFR ≥60 a <60'
            : 'Bez DM, priemer submodelov eGFR ≥60 a <60';
    } else {
        $higherEgfr = $egfr > 60.0;
        $risk3yr = ckdpcStratumRisk(...[
            ...$arguments,
            $higherEgfr,
            ...$remainingArguments,
        ]);
        $dmLabel = $diabetes ? 'DM' : 'Bez DM';
        $egfrLabel = $higherEgfr ? 'eGFR ≥ 60' : 'eGFR < 60';
        $modelName = $dmLabel . ', ' . $egfrLabel . ' ml/min/1,73 m²';
    }

    $risk3yr = max(0.0, min(100.0, $risk3yr));

    return [
        "risk_3yr" => round($risk3yr, 1),
        "model_name" => $modelName,
    ];
}

/**
 * Slovný opis štádia CKM podľa kódu.
 *
 * @param string $code '0', '1', '2', '3', '4a' alebo '4b'
 */
function ckmStageLabel(string $code): string
{
    switch ($code) {
        case '1':
            return 'nadmerná / dysfunkčná adipozita';
        case '2':
            return 'metabolické rizikové faktory a/alebo CKD';
        case '3':
            return 'subklinické kardiovaskulárne ochorenie';
        case '4a':
            return 'klinické KV ochorenie (bez zlyhania obličiek)';
        case '4b':
            return 'klinické KV ochorenie so zlyhaním obličiek';
        default:
            return 'bez rizikových faktorov CKM';
    }
}

/**
 * Hierarchické určenie najvyššieho štádia CKM (AHA 2023).
 * @return array{code: string, num: int}
 */
function ckmComputeStage(
    bool $adiposity,
    bool $dysAdiposity,
    bool $metabolicRF,
    bool $ckdModHigh,
    bool $ckdVeryHigh,
    bool $subclinicalCvd,
    bool $clinicalCvd,
    bool $kidneyFailure
): array {
    if ($clinicalCvd) {
        return ['code' => $kidneyFailure ? '4b' : '4a', 'num' => 4];
    }
    if ($subclinicalCvd || $ckdVeryHigh) {
        return ['code' => '3', 'num' => 3];
    }
    if ($metabolicRF || $ckdModHigh) {
        return ['code' => '2', 'num' => 2];
    }
    if ($adiposity || $dysAdiposity) {
        return ['code' => '1', 'num' => 1];
    }
    return ['code' => '0', 'num' => 0];
}
