<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

function kdigoGCategory(float $egfr): string
{
    if ($egfr >= 90.0) {
        return 'G1';
    }
    if ($egfr >= 60.0) {
        return 'G2';
    }
    if ($egfr >= 45.0) {
        return 'G3a';
    }
    if ($egfr >= 30.0) {
        return 'G3b';
    }
    if ($egfr >= 15.0) {
        return 'G4';
    }

    return 'G5';
}

function kdigoACategory(float $uacr): string
{
    if ($uacr < 30.0) {
        return 'A1';
    }
    if ($uacr <= 300.0) {
        return 'A2';
    }

    return 'A3';
}

function kdigoRisk(string $g, string $a): array
{
    $risk = 'Veľmi vysoké riziko';
    $note = 'Potrebná zvýšená vigilancia a špecializované vedenie.';

    if (($g === 'G1' || $g === 'G2') && $a === 'A1') {
        $risk = 'Nízke riziko';
        $note = 'Ak CKD trvá <3 mesiace alebo bez markerov, CKD nemusí byť potvrdená.';
    } elseif (($g === 'G1' || $g === 'G2') && $a === 'A2') {
        $risk = 'Stredné riziko';
        $note = 'Odporúčané pravidelné sledovanie a nefroprotektívna liečba.';
    } elseif (($g === 'G1' || $g === 'G2') && $a === 'A3') {
        $risk = 'Vysoké riziko';
        $note = 'Odporúčané intenzívnejšie sledovanie a úprava terapie.';
    } elseif ($g === 'G3a' && $a === 'A1') {
        $risk = 'Stredné riziko';
        $note = 'Sledovanie funkcie obličiek a rizikových faktorov.';
    } elseif (($g === 'G3a' && $a === 'A2') || ($g === 'G3b' && $a === 'A1')) {
        $risk = 'Vysoké riziko';
        $note = 'Vysoké riziko progresie, zvážiť nefrologickú konzultáciu.';
    }

    return [
        'risk' => $risk,
        'note' => $note,
    ];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'egfr'                   => (string) ($_POST['egfr'] ?? ''),
    'uacr'                   => (string) ($_POST['uacr'] ?? ''),
    'uacr_unit'              => (string) ($_POST['uacr_unit'] ?? 'mg_g'),
    'patient_first_name'     => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name'      => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date'     => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number'   => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif ($action === 'delete_saved') {
        if (!isLoggedIn()) {
            $errors[] = 'Na mazanie výsledkov je potrebné prihlásenie.';
        } else {
            $resultId = (int) ($_POST['result_id'] ?? 0);
            if ($resultId <= 0) {
                $errors[] = 'Neplatné ID záznamu.';
            } else {
                try {
                    if (calculatorDeleteSavedResult($pdo, $resultId, (int) $_SESSION['user_id'])) {
                        $messages[] = 'Uložený výsledok bol vymazaný.';
                    } else {
                        $errors[] = 'Záznam sa nepodarilo vymazať alebo neexistuje.';
                    }
                } catch (\PDOException $e) {
                    $errors[] = 'Databázová chyba pri mazaní záznamu.';
                    error_log('calculator_kdigo_risk delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $egfr = calculatorParsePositiveFloat($form['egfr']);
        if ($egfr === null || $egfr > 200) {
            $errors[] = 'eGFR musí byť kladné číslo v realistickom rozsahu (0–200).';
        }

        // Jednotka UACR
        $uacrUnit = in_array($form['uacr_unit'], ['mg_g', 'mg_mmol'], true) ? $form['uacr_unit'] : '';
        if ($uacrUnit === '') {
            $errors[] = 'Vyberte jednotku UACR.';
        }
        $uacr = calculatorParsePositiveFloat($form['uacr']);
        if ($uacr === null || $uacr > 15000) {
            $errors[] = 'UACR musí byť kladné číslo v rozumnom rozsahu.';
        }

        if (empty($errors)) {
            $egfrValue  = (float) $egfr;
            $uacrInput  = (float) $uacr;
            // Prepočet UACR: [mg/g] = [mg/mmol] × 8.84
            $uacrMgG    = ($uacrUnit === 'mg_mmol') ? ($uacrInput * 8.84) : $uacrInput;
            $gCategory  = kdigoGCategory($egfrValue);
            $aCategory  = kdigoACategory($uacrMgG);
            $riskInfo   = kdigoRisk($gCategory, $aCategory);

            $calculated = [
                'egfr'        => round($egfrValue, 1),
                'uacr_input'  => round($uacrInput, 2),
                'uacr_unit'   => $uacrUnit,
                'uacr_mg_g'   => round($uacrMgG, 1),
                'g_category'  => $gCategory,
                'a_category'  => $aCategory,
                'risk'        => $riskInfo['risk'],
                'note'        => $riskInfo['note'],
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            'egfr'       => $calculated['egfr'],
                            'uacr_value' => $calculated['uacr_input'],
                            'uacr_unit'  => $calculated['uacr_unit'],
                            'uacr_mg_g'  => $calculated['uacr_mg_g'],
                        ];

                        $resultPayload = [
                            'g_category' => $gCategory,
                            'a_category' => $aCategory,
                            'risk' => $riskInfo['risk'],
                            'note' => $riskInfo['note'],
                        ];

                        if (calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION['user_id'],
                            'kdigo_ga_risk',
                            'KDIGO G/A riziko CKD',
                            $patient,
                            $inputPayload,
                            $resultPayload
                        )) {
                            $messages[] = 'Výsledok bol uložený do databázy.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
                        error_log('calculator_kdigo_risk save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'kdigo_ga_risk', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_kdigo_risk fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KDIGO G/A riziko CKD - Kalkulačky KDIGO 2024 CKD</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačka KDIGO G/A rizika';
    $headerIntro = 'Kategoriácia CKD podľa eGFR a albuminúrie (UACR)';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <li><a href="calculator_egfr.php">eGFR CKD-EPI</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php">Admin panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlásenie</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>KDIGO G/A riziko CKD</h2>
                <p class="auth-subtitle">Zadanie eGFR a UACR, automatické určenie G/A kategórie a orientačného rizika.</p>

                <details open class="calc-formula-box">
                    <summary>Klasifikácia — KDIGO 2024 (G a A kategórie)</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">G1: eGFR &ge; 90 &nbsp;&nbsp;G2: 60&ndash;89 &nbsp;&nbsp;G3a: 45&ndash;59 &nbsp;&nbsp;G3b: 30&ndash;44 &nbsp;&nbsp;G4: 15&ndash;29 &nbsp;&nbsp;G5: &lt; 15 &nbsp;ml/min/1,73&thinsp;m&sup2;
A1: UACR &lt; 30 &nbsp;&nbsp;A2: 30&ndash;300 &nbsp;&nbsp;A3: &gt; 300 &nbsp;mg/g</code>
                        <code class="calc-formula-line">Prepočet UACR: [mg/g] = [mg/mmol] &times; 8.84</code>
                        <div class="calc-formula-vars">
                            Riziko CKD = kombinácia G &times; A kategórie podľa KDIGO heatmapy&ensp;&bull;&ensp;
                            eGFR v ml/min/1,73&thinsp;m²&ensp;&bull;&ensp;UACR v mg/g
                        </div>
                    </div>
                </details>

                <div class="alert" style="background:rgba(16,185,129,0.07);border-left:4px solid #10b981;padding:12px 16px;border-radius:6px;margin-bottom:16px;font-size:0.88rem;">
                    <strong>Porovnanie s referenčnými zdrojmi:</strong>
                    <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO 2024 Guidelines</a> &ensp;&bull;&ensp;
                    <a href="https://www.kidney.org/kidney-topics/chronic-kidney-disease-ckd" target="_blank" rel="noopener noreferrer">NKF — CKD (G/A klasifikácia)</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/3939/ckd-epi-equations-glomerular-filtration-rate-gfr" target="_blank" rel="noopener noreferrer">MDCalc CKD-EPI + KDIGO staging</a>
                </div>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_kdigo_risk.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

                    <div class="form-section">
                        <h3>Voliteľné identifikačné údaje pacienta</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_first_name">Meno</label>
                                <input type="text" id="patient_first_name" name="patient_first_name" class="form-control" value="<?= htmlspecialchars($form['patient_first_name']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_last_name">Priezvisko</label>
                                <input type="text" id="patient_last_name" name="patient_last_name" class="form-control" value="<?= htmlspecialchars($form['patient_last_name']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_date">Dátum narodenia</label>
                                <input type="date" id="patient_birth_date" name="patient_birth_date" class="form-control" value="<?= htmlspecialchars($form['patient_birth_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_number">Rodné číslo</label>
                                <input type="text" id="patient_birth_number" name="patient_birth_number" class="form-control" placeholder="000000/0000" value="<?= htmlspecialchars($form['patient_birth_number']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_insurance_code">Kód zdravotnej poisťovne</label>
                                <input type="text" id="patient_insurance_code" name="patient_insurance_code" class="form-control" placeholder="24 alebo 24-01" value="<?= htmlspecialchars($form['patient_insurance_code']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Povinné vstupy pre výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr">UACR</label>
                                <div style="display:flex;gap:8px;">
                                    <input type="text" id="uacr" name="uacr" required
                                           class="form-control" style="flex:1;"
                                           value="<?= htmlspecialchars($form['uacr']) ?>">
                                    <select name="uacr_unit" class="form-control" style="flex:0.8;">
                                        <option value="mg_g"    <?= $form['uacr_unit'] === 'mg_g'    ? 'selected' : '' ?>>mg/g</option>
                                        <option value="mg_mmol" <?= $form['uacr_unit'] === 'mg_mmol' ? 'selected' : '' ?>>mg/mmol</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>G kategória:</strong> <?= htmlspecialchars($calculated['g_category']) ?></p>
                        <p><strong>A kategória:</strong> <?= htmlspecialchars($calculated['a_category']) ?></p>
                        <p><strong>Rizikový stupeň:</strong> <?= htmlspecialchars($calculated['risk']) ?></p>
                        <p><strong>Poznámka:</strong> <?= htmlspecialchars($calculated['note']) ?></p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary" onclick="window.print()">Vytlačiť výpočet</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <section class="auth-container auth-container--wide calc-saved-results">
                <h3>Uložené výsledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie a históriu výpočtov je potrebné prihlásenie.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Zatiaľ nemáte uložené žiadne výsledky pre túto kalkulačku.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Dátum</th>
                                    <th>Pacient</th>
                                    <th>Výsledok</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <?php
                                    $input = is_array($row['input_payload']) ? $row['input_payload'] : [];
                                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) ($row['created_at'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            <?= htmlspecialchars((string) ($result['risk'] ?? '')) ?>
                                            <?php if (!empty($result['g_category']) && !empty($result['a_category'])): ?>
                                                (<?= htmlspecialchars((string) $result['g_category']) ?>/<?= htmlspecialchars((string) $result['a_category']) ?>)
                                            <?php endif; ?>
                                            <?php if (!empty($input['egfr']) && !empty($input['uacr_mg_g'])): ?>
                                                - eGFR <?= htmlspecialchars((string) $input['egfr']) ?>,
                                                UACR <?= htmlspecialchars(number_format((float) $input['uacr_value'], 2, ',', ' ')) ?>
                                                <?= $input['uacr_unit'] === 'mg_mmol' ? 'mg/mmol' : 'mg/g' ?>
                                                <?php if (($input['uacr_unit'] ?? '') === 'mg_mmol'): ?>
                                                    (= <?= htmlspecialchars(number_format((float) $input['uacr_mg_g'], 1, ',', ' ')) ?> mg/g)
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_kdigo_risk.php" style="display:inline" onsubmit="return confirm('Naozaj vymazať záznam?')">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row['id'] ?>">
                                                <button type="submit" class="btn-admin-action btn-admin-action--warn">Vymazať</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
