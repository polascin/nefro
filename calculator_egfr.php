<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

function egfrCategory(float $egfr): string
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

function egfrCategoryDescription(string $category): string
{
    $map = [
        'G1' => 'normalna alebo vysoka filtracia',
        'G2' => 'mierne znizena filtracia',
        'G3a' => 'mierne az stredne znizena filtracia',
        'G3b' => 'stredne az vyrazne znizena filtracia',
        'G4' => 'vyrazne znizena filtracia',
        'G5' => 'zlyhanie obliciek',
    ];

    return $map[$category] ?? '';
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'sex' => (string) ($_POST['sex'] ?? 'female'),
    'age_years' => (string) ($_POST['age_years'] ?? ''),
    'creatinine_value' => (string) ($_POST['creatinine_value'] ?? ''),
    'creatinine_unit' => (string) ($_POST['creatinine_unit'] ?? 'umol_l'),
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
                    error_log('calculator_egfr delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '') {
            $errors[] = 'Vyberte pohlavie.';
        }

        $ageYears = filter_var($form['age_years'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 18,
                'max_range' => 120,
            ],
        ]);
        if ($ageYears === false) {
            $errors[] = 'Vek musi byt cele cislo v intervale 18 az 120 rokov.';
        }

        $creatinineValue = calculatorParsePositiveFloat($form['creatinine_value']);
        if ($creatinineValue === null) {
            $errors[] = 'Kreatinin musi byt kladne cislo.';
        }

        $creatinineUnit = in_array($form['creatinine_unit'], ['umol_l', 'mg_dl'], true)
            ? $form['creatinine_unit']
            : '';
        if ($creatinineUnit === '') {
            $errors[] = 'Vyberte jednotku kreatininu.';
        }

        if (empty($errors)) {
            $creatinineMgDl = $creatinineUnit === 'umol_l'
                ? ((float) $creatinineValue / 88.4)
                : (float) $creatinineValue;

            $kappa = $sex === 'female' ? 0.7 : 0.9;
            $alpha = $sex === 'female' ? -0.241 : -0.302;

            $ratio = $creatinineMgDl / $kappa;
            $egfr = 142
                * pow(min($ratio, 1), $alpha)
                * pow(max($ratio, 1), -1.200)
                * pow(0.9938, (int) $ageYears);

            if ($sex === 'female') {
                $egfr *= 1.012;
            }

            $egfrRounded = round($egfr, 1);
            $gCategory = egfrCategory($egfrRounded);
            $gDescription = egfrCategoryDescription($gCategory);

            $calculated = [
                'egfr' => $egfrRounded,
                'g_category' => $gCategory,
                'g_description' => $gDescription,
                'sex' => $sex,
                'age_years' => (int) $ageYears,
                'creatinine_input' => round((float) $creatinineValue, 2),
                'creatinine_unit' => $creatinineUnit,
                'creatinine_mg_dl' => round($creatinineMgDl, 3),
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre ulozenie vysledku sa najskor prihlaste.';
                } else {
                    try {
                        $inputPayload = [
                            'sex' => $sex,
                            'age_years' => (int) $ageYears,
                            'creatinine_value' => round((float) $creatinineValue, 2),
                            'creatinine_unit' => $creatinineUnit,
                        ];

                        $resultPayload = [
                            'egfr' => $egfrRounded,
                            'g_category' => $gCategory,
                            'g_description' => $gDescription,
                            'creatinine_mg_dl' => round($creatinineMgDl, 3),
                        ];

                        if (calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION['user_id'],
                            'egfr_ckd_epi_2021',
                            'eGFR (CKD-EPI 2021)',
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
                        error_log('calculator_egfr save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'egfr_ckd_epi_2021', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa nacitat ulozene vysledky.';
        error_log('calculator_egfr fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGFR CKD-EPI 2021 - Kalkulacky KDIGO 2024 CKD</title>
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
    $headerTitle = 'Kalkulacka eGFR';
    $headerIntro = 'CKD-EPI 2021 podla KDIGO 2024';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavna navigacia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulacky</a></li>
                <li><a href="calculator_kdigo_risk.php">KDIGO G/A riziko</a></li>
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
                <h2>eGFR (CKD-EPI 2021)</h2>
                <p class="auth-subtitle">Volitelne udaje pacienta + povinne vstupy pre vypocet.</p>

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

                <form method="POST" action="calculator_egfr.php">
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
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Zena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muz</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_value">S-kreatinin</label>
                                <input type="text" id="creatinine_value" name="creatinine_value" required class="form-control" value="<?= htmlspecialchars($form['creatinine_value']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_unit">Jednotka kreatininu</label>
                                <select id="creatinine_unit" name="creatinine_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form['creatinine_unit'] === 'umol_l' ? 'selected' : '' ?>>umol/l</option>
                                    <option value="mg_dl" <?= $form['creatinine_unit'] === 'mg_dl' ? 'selected' : '' ?>>mg/dl</option>
                                </select>
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
                        <p><strong>eGFR:</strong> <?= htmlspecialchars(number_format((float) $calculated['egfr'], 1, ',', ' ')) ?> ml/min/1,73m2</p>
                        <p><strong>Kategoria:</strong> <?= htmlspecialchars($calculated['g_category']) ?> (<?= htmlspecialchars($calculated['g_description']) ?>)</p>
                        <p><strong>Kreatinin prepocitany na mg/dl:</strong> <?= htmlspecialchars(number_format((float) $calculated['creatinine_mg_dl'], 3, ',', ' ')) ?></p>
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
                                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                                    $egfrValue = (float) ($result['egfr'] ?? 0);
                                    $category = (string) ($result['g_category'] ?? '');
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) ($row['created_at'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            <?= htmlspecialchars(number_format($egfrValue, 1, ',', ' ')) ?> ml/min/1,73m2
                                            <?php if ($category !== ''): ?>
                                                (<?= htmlspecialchars($category) ?>)
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlacit</a>
                                            <form method="POST" action="calculator_egfr.php" style="display:inline" onsubmit="return confirm('Naozaj vymazat zaznam?')">
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
