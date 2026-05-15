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
    $risk = 'Velmi vysoke riziko';
    $note = 'Potrebna zvysena vigilancia a specialisticke vedenie.';

    if (($g === 'G1' || $g === 'G2') && $a === 'A1') {
        $risk = 'Nizke riziko';
        $note = 'Ak CKD trva <3 mesiace alebo bez markerov, CKD nemusi byt potvrdena.';
    } elseif (($g === 'G1' || $g === 'G2') && $a === 'A2') {
        $risk = 'Stredne riziko';
        $note = 'Odporucane pravidelne sledovanie a nefroprotektivna liecba.';
    } elseif (($g === 'G1' || $g === 'G2') && $a === 'A3') {
        $risk = 'Vysoke riziko';
        $note = 'Odporucane intenzivnejsie sledovanie a uprava terapie.';
    } elseif ($g === 'G3a' && $a === 'A1') {
        $risk = 'Stredne riziko';
        $note = 'Sledovanie funkcie obliciek a rizikovych faktorov.';
    } elseif (($g === 'G3a' && $a === 'A2') || ($g === 'G3b' && $a === 'A1')) {
        $risk = 'Vysoke riziko';
        $note = 'Vysoke riziko progresie, zvazit nefrologicku konzultaciu.';
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
    'egfr' => (string) ($_POST['egfr'] ?? ''),
    'uacr' => (string) ($_POST['uacr'] ?? ''),
    'patient_first_name' => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name' => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date' => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number' => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatny CSRF token.';
    } elseif ($action === 'delete_saved') {
        if (!isLoggedIn()) {
            $errors[] = 'Na mazanie vysledkov je potrebne prihlasenie.';
        } else {
            $resultId = (int) ($_POST['result_id'] ?? 0);
            if ($resultId <= 0) {
                $errors[] = 'Neplatne ID zaznamu.';
            } else {
                try {
                    if (calculatorDeleteSavedResult($pdo, $resultId, (int) $_SESSION['user_id'])) {
                        $messages[] = 'Ulozeny vysledok bol vymazany.';
                    } else {
                        $errors[] = 'Zaznam sa nepodarilo vymazat alebo neexistuje.';
                    }
                } catch (\PDOException $e) {
                    $errors[] = 'Databazova chyba pri mazani zaznamu.';
                    error_log('calculator_kdigo_risk delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $egfr = calculatorParsePositiveFloat($form['egfr']);
        if ($egfr === null || $egfr > 200) {
            $errors[] = 'eGFR musi byt kladne cislo v realistickom rozsahu (0-200).';
        }

        $uacr = calculatorParsePositiveFloat($form['uacr']);
        if ($uacr === null || $uacr > 10000) {
            $errors[] = 'UACR musi byt kladne cislo v mg/g.';
        }

        if (empty($errors)) {
            $egfrValue = (float) $egfr;
            $uacrValue = (float) $uacr;
            $gCategory = kdigoGCategory($egfrValue);
            $aCategory = kdigoACategory($uacrValue);
            $riskInfo = kdigoRisk($gCategory, $aCategory);

            $calculated = [
                'egfr' => round($egfrValue, 1),
                'uacr' => round($uacrValue, 1),
                'g_category' => $gCategory,
                'a_category' => $aCategory,
                'risk' => $riskInfo['risk'],
                'note' => $riskInfo['note'],
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre ulozenie vysledku sa najskor prihlaste.';
                } else {
                    try {
                        $inputPayload = [
                            'egfr' => round($egfrValue, 1),
                            'uacr' => round($uacrValue, 1),
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
                            $messages[] = 'Vysledok bol ulozeny do databazy.';
                        } else {
                            $errors[] = 'Vysledok sa nepodarilo ulozit.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databazova chyba pri ukladani vysledku.';
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
        $errors[] = 'Nepodarilo sa nacitat ulozene vysledky.';
        error_log('calculator_kdigo_risk fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KDIGO G/A riziko CKD - Kalkulacky KDIGO 2024 CKD</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskocit na hlavny obsah</a>

    <?php
    $headerTitle = 'Kalkulacka KDIGO G/A rizika';
    $headerIntro = 'Kategorizacia CKD podla eGFR a albuminurie (UACR)';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavna navigacia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulacky</a></li>
                <li><a href="calculator_egfr.php">eGFR CKD-EPI</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php">Admin panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Odhlasit sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlasenie</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>KDIGO G/A riziko CKD</h2>
                <p class="auth-subtitle">Zadanie eGFR a UACR, automaticke urcenie G/A kategorie a orientacneho rizika.</p>

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
                        <h3>Volitelne identifikacne udaje pacienta</h3>
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
                                <label for="patient_birth_date">Datum narodenia</label>
                                <input type="date" id="patient_birth_date" name="patient_birth_date" class="form-control" value="<?= htmlspecialchars($form['patient_birth_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_birth_number">Rodne cislo</label>
                                <input type="text" id="patient_birth_number" name="patient_birth_number" class="form-control" placeholder="000000/0000" value="<?= htmlspecialchars($form['patient_birth_number']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="patient_insurance_code">Kod zdravotnej poistovne</label>
                                <input type="text" id="patient_insurance_code" name="patient_insurance_code" class="form-control" placeholder="001" value="<?= htmlspecialchars($form['patient_insurance_code']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Povinne vstupy pre vypocet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73m2)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr">UACR (mg/g)</label>
                                <input type="text" id="uacr" name="uacr" required class="form-control" value="<?= htmlspecialchars($form['uacr']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypocitat</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypocitat a ulozit</button>
                        <a href="calculators.php" class="btn-secondary">Spat na prehlad</a>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Vysledok vypoctu</h3>
                        <p><strong>G kategoria:</strong> <?= htmlspecialchars($calculated['g_category']) ?></p>
                        <p><strong>A kategoria:</strong> <?= htmlspecialchars($calculated['a_category']) ?></p>
                        <p><strong>Rizikovy stupen:</strong> <?= htmlspecialchars($calculated['risk']) ?></p>
                        <p><strong>Poznamka:</strong> <?= htmlspecialchars($calculated['note']) ?></p>
                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary" onclick="window.print()">Vytlacit vypocet</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <section class="auth-container auth-container--wide">
                <h3>Ulozene vysledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie a historiu vypoctov je potrebne prihlasenie.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Zatial nemate ulozene ziadne vysledky pre tuto kalkulacku.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Pacient</th>
                                    <th>Vysledok</th>
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
                                            <?php if (!empty($input['egfr']) && !empty($input['uacr'])): ?>
                                                - eGFR <?= htmlspecialchars((string) $input['egfr']) ?>, UACR <?= htmlspecialchars((string) $input['uacr']) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlacit</a>
                                            <form method="POST" action="calculator_kdigo_risk.php" style="display:inline" onsubmit="return confirm('Naozaj vymazat zaznam?')">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row['id'] ?>">
                                                <button type="submit" class="btn-admin-action btn-admin-action--warn">Vymazat</button>
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
