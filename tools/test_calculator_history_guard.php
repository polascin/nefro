<?php

declare(strict_types=1);

/**
 * Vlastníctvo uloženého výsledku a zákaz prepisu formulára pri POST ?load_id=.
 * Beží nad SQLite v pamäti so syntetickými údajmi, bez produkčnej databázy.
 */

require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../calculators_common.php';

$checks = 0;

function historyGuardTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$_SESSION['user_id'] = 7;
$_SESSION['_last_activity'] = time();

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(
    'CREATE TABLE calculator_results (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        calculator_key TEXT NOT NULL,
        calculator_label TEXT NOT NULL,
        patient_first_name TEXT NULL,
        patient_last_name TEXT NULL,
        patient_birth_date TEXT NULL,
        patient_birth_number TEXT NULL,
        patient_insurance_code TEXT NULL,
        input_payload TEXT NOT NULL,
        result_payload TEXT NOT NULL,
        created_at TEXT DEFAULT CURRENT_TIMESTAMP
    )'
);

$syntheticPatient = [
    'first_name' => '',
    'last_name' => '',
    'birth_date' => '',
    'birth_number' => '',
    'insurance_code' => '',
];

historyGuardTest(
    calculatorSaveResult(
        $pdo,
        7,
        'uacr_kdigo',
        'UACR klasifikácia',
        $syntheticPatient,
        ['u_alb' => '30', 'u_alb_unit' => 'mg_l', 'u_cr' => '10', 'u_cr_unit' => 'mmol_l'],
        ['stage' => 'A2', 'mg_mmol' => 3.0, 'mg_g' => 26.52],
    ),
    'Uloženie syntetického UACR výsledku.',
);
$uacrId = (int) $pdo->lastInsertId();

historyGuardTest(
    calculatorSaveResult(
        $pdo,
        7,
        'ktv_urr',
        'Kt/V a URR',
        $syntheticPatient,
        ['u_pre' => '20', 'u_post' => '6', 'weight_post' => '70', 'time_hours' => '4', 'uf_volume' => '2'],
        ['ktv' => 1.4, 'urr' => 70.0],
    ),
    'Uloženie syntetického Kt/V výsledku.',
);
$ktvId = (int) $pdo->lastInsertId();

historyGuardTest(
    calculatorSaveResult(
        $pdo,
        7,
        'egfr_slope',
        'eGFR Slope',
        $syntheticPatient,
        [
            'egfr_unit' => EGFR_UNIT_ML_MIN,
            'p1' => ['date' => '2025-01-01', 'egfr' => '60'],
            'p2' => ['date' => '2026-01-01', 'egfr' => '45'],
        ],
        ['slope' => -15.0],
    ),
    'Uloženie syntetického eGFR Slope výsledku v ml/min.',
);
$slopeId = (int) $pdo->lastInsertId();

$ownUacr = calculatorFetchSavedResultById($pdo, $uacrId, 7);
$foreignUacr = calculatorFetchSavedResultById($pdo, $uacrId, 8);
historyGuardTest(is_array($ownUacr) && ($ownUacr['result_payload']['stage'] ?? '') === 'A2', 'Vlastník načíta svoj UACR záznam.');
historyGuardTest($foreignUacr === null, 'Cudzí používateľ UACR záznam nedostane.');
historyGuardTest(calculatorFetchSavedResultById($pdo, $ktvId, 8) === null, 'Cudzí používateľ Kt/V záznam nedostane.');
historyGuardTest(calculatorFetchSavedResultById($pdo, $slopeId, 8) === null, 'Cudzí používateľ eGFR Slope záznam nedostane.');
historyGuardTest(calculatorDeleteSavedResult($pdo, $slopeId, 8) === false, 'Cudzí používateľ záznam nezmaže.');
historyGuardTest(calculatorFetchSavedResultById($pdo, $slopeId, 7) !== null, 'Pokus cudzieho mazania záznam vlastníka zachová.');

$legacyPrevent = [
    'age_years' => '',
    'sex' => 'female',
    'egfr' => '',
    'egfr_unit' => EGFR_UNIT_ML_S,
    'uacr_value' => '',
    'uacr_unit' => 'mg_mmol',
];
$pdo->prepare(
    'INSERT INTO calculator_results (
        user_id, calculator_key, calculator_label, input_payload, result_payload
    ) VALUES (7, :key, :label, :input, :result)'
)->execute([
    'key' => 'prevent',
    'label' => 'PREVENT',
    'input' => json_encode([
        'age_years' => 50,
        'sex' => 'female',
        'egfr' => 15,
        'egfr_unit' => EGFR_UNIT_ML_S,
        'uacr_mg_g' => 300,
    ], JSON_UNESCAPED_UNICODE),
    'result' => json_encode(['model' => 'uacr'], JSON_UNESCAPED_UNICODE),
]);
$preventId = (int) $pdo->lastInsertId();

$_GET = ['load_id' => (string) $preventId];
$_SERVER['REQUEST_METHOD'] = 'GET';
$messages = [];
$loaded = $legacyPrevent;
calculatorHandleLoadId($pdo, $loaded, $messages);
historyGuardTest($loaded['uacr_value'] === '300', 'GET načíta staré UACR z uacr_mg_g.');
historyGuardTest($loaded['uacr_unit'] === 'mg_g', 'Obnovené UACR ostáva v mg/g.');
historyGuardTest($loaded['egfr'] === '15', 'Uložené eGFR 15 sa načíta ako kanonických 15 ml/min.');
historyGuardTest($loaded['egfr_unit'] === EGFR_UNIT_ML_MIN, 'Po načítaní sa jednotka vráti na ml/min, nie ml/s.');
historyGuardTest($messages !== [], 'GET oznámi načítanie histórie.');

$_SERVER['REQUEST_METHOD'] = 'POST';
$messages = [];
$posted = $legacyPrevent;
$posted['uacr_value'] = '3,2';
$posted['uacr_unit'] = 'mg_mmol';
$posted['egfr'] = '90';
$posted['egfr_unit'] = EGFR_UNIT_ML_S;
calculatorHandleLoadId($pdo, $posted, $messages);
historyGuardTest($posted['uacr_value'] === '3,2', 'POST ?load_id= nenechá staré UACR prepísať nový výpočet.');
historyGuardTest($posted['egfr'] === '90', 'POST ?load_id= nenechá staré eGFR prepísať nový výpočet.');
historyGuardTest($posted['egfr_unit'] === EGFR_UNIT_ML_S, 'POST zachová novo zvolenú jednotku ml/s.');
historyGuardTest($messages === [], 'POST nehlási načítanie histórie.');

$_SESSION['user_id'] = 8;
$_GET = ['load_id' => (string) $uacrId];
$_SERVER['REQUEST_METHOD'] = 'GET';
$messages = [];
$foreignForm = [
    'u_alb' => '',
    'u_cr' => '',
    'patient_first_name' => '',
    'patient_last_name' => '',
    'patient_birth_date' => '',
    'patient_birth_number' => '',
    'patient_insurance_code' => '',
    'examination_date' => '',
];
calculatorHandleLoadId($pdo, $foreignForm, $messages);
historyGuardTest($foreignForm['u_alb'] === '', 'GET cudzieho load_id formulár nenaplní.');
historyGuardTest($messages === [], 'Cudzie load_id nehlási úspešné načítanie.');

$mlPerMin = calculatorEgfrToMlMin(0.75, EGFR_UNIT_ML_S);
$mlLater = calculatorEgfrToMlMin(0.50, EGFR_UNIT_ML_S);
historyGuardTest(abs($mlPerMin - 45.0) < 0.0001, '0,75 ml/s je 45 ml/min.');
historyGuardTest(abs($mlLater - 30.0) < 0.0001, '0,50 ml/s je 30 ml/min.');
historyGuardTest(abs(($mlLater - $mlPerMin) - (-15.0)) < 0.0001, 'Slope po prepočte ml/s na ml/min je −15 ml/min/rok.');

$slopeSource = (string) file_get_contents(__DIR__ . '/../calculator_egfr_slope.php');
historyGuardTest(str_contains($slopeSource, 'calculatorIsHistoryLoadRequest'), 'eGFR Slope používa GET guard pre load_id.');
historyGuardTest(str_contains($slopeSource, 'action="calculator_egfr_slope.php"'), 'eGFR Slope má explicitný action formulára.');
foreach (['calculator_uacr.php', 'calculator_ktv.php'] as $file) {
    $source = (string) file_get_contents(__DIR__ . '/../' . $file);
    historyGuardTest(str_contains($source, 'calculatorHandleLoadId'), $file . ' načítava históriu cez spoločný guard.');
    historyGuardTest(str_contains($source, 'action="' . $file . '"'), $file . ' má explicitný action formulára.');
}

echo "History guard: $checks PASS\n";
