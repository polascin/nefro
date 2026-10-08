<?php

declare(strict_types=1);

require_once __DIR__ . '/../calculators_common.php';
require_once __DIR__ . '/../prevent_model.php';

$checks = 0;
function preventLoadTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$preventForm = [
    'age_years' => '',
    'sex' => 'female',
    'total_c' => '',
    'hdl_c' => '',
    'chol_unit' => 'mmol',
    'sbp' => '',
    'bp_tx' => '0',
    'statin' => '0',
    'dm' => '0',
    'smoking' => '0',
    'bmi' => '',
    'egfr' => '',
    'egfr_unit' => EGFR_UNIT_ML_MIN,
    'uacr_value' => '',
    'uacr_unit' => 'mg_g',
    'hba1c' => '',
    'sdi' => '',
];

$legacyPayload = [
    'age_years' => 50,
    'sex' => 'female',
    'total_c' => 200,
    'hdl_c' => 45,
    'chol_unit' => 'mgdl',
    'sbp' => 160,
    'bp_tx' => 1,
    'statin' => 0,
    'dm' => 1,
    'smoking' => 0,
    'bmi' => 35,
    'egfr' => 90,
    'egfr_unit' => EGFR_UNIT_ML_MIN,
    'uacr_mg_g' => 300,
    'hba1c' => null,
    'sdi' => null,
];

$form = $preventForm;
calculatorApplyInputPayloadToForm($form, $legacyPayload);
preventLoadTest($form['uacr_value'] === '300', 'Starý PREVENT payload musí vyplniť uacr_value z uacr_mg_g.');
preventLoadTest($form['uacr_unit'] === 'mg_g', 'Obnovené UACR je v kanonických mg/g.');
preventLoadTest($form['age_years'] === '50', 'Ostatné polia sa skopírujú podľa kľúča.');
preventLoadTest($form['bp_tx'] === '1', 'Bool/int prediktory sa načítajú ako reťazec 1/0.');

$uacrVal = calculatorParsePositiveFloat($form['uacr_value']);
preventLoadTest($uacrVal === 300.0, 'Načítané UACR ide znova cez parser ako 300 mg/g.');

$baseIn = [
    'age' => 50,
    'sex' => 'female',
    'total_c' => 200.0,
    'hdl_c' => 45.0,
    'chol_unit' => 'mgdl',
    'sbp' => 160.0,
    'bp_tx' => true,
    'statin' => false,
    'dm' => true,
    'smoking' => false,
    'bmi' => 35.0,
    'egfr' => 90.0,
];
$without = preventComputeAll($baseIn);
$withUacr = preventComputeAll($baseIn + ['uacr' => $uacrVal]);
preventLoadTest($without['model'] === 'base', 'Bez UACR ostáva základný model.');
preventLoadTest($withUacr['model'] === 'uacr', 'S načítaným UACR ostáva rozšírený model.');
preventLoadTest($without['risks']['ascvd']['10yr'] === 9.2, 'Základný 10r ASCVD je 9,2 %.');
preventLoadTest($withUacr['risks']['ascvd']['10yr'] === 13.0, 'UACR 300 mg/g dá 10r ASCVD 13,0 %.');

$emptyUacr = $preventForm;
calculatorApplyInputPayloadToForm($emptyUacr, ['uacr_mg_g' => null, 'age_years' => 50]);
preventLoadTest($emptyUacr['uacr_value'] === '', 'Chýbajúce UACR sa nemá vymyslieť.');

$newPayload = $legacyPayload + ['uacr_value' => '33.9', 'uacr_unit' => 'mg_mmol'];
$newForm = $preventForm;
calculatorApplyInputPayloadToForm($newForm, $newPayload);
preventLoadTest($newForm['uacr_value'] === '33.9', 'Nový payload prednostne použije uacr_value.');
preventLoadTest($newForm['uacr_unit'] === 'mg_mmol', 'Nový payload zachová zadanú jednotku.');

$kdigoForm = ['uacr' => '', 'uacr_unit' => 'mg_g', 'egfr' => ''];
calculatorApplyInputPayloadToForm($kdigoForm, [
    'uacr_value' => 12.4,
    'uacr_unit' => 'mg_mmol',
    'uacr_mg_g' => 109.6,
    'egfr' => 45,
]);
preventLoadTest($kdigoForm['uacr'] === '12.4', 'KDIGO formulár obnoví pole uacr z uacr_value.');
preventLoadTest($kdigoForm['uacr_unit'] === 'mg_mmol', 'KDIGO formulár zachová jednotku vstupu.');

echo "PREVENT load: $checks PASS\n";
