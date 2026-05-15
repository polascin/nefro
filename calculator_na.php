<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'sex' => (string) ($_POST['sex'] ?? 'female'),
    'age_years' => (string) ($_POST['age_years'] ?? ''),
    'weight_kg' => (string) ($_POST['weight_kg'] ?? ''),
    's_na' => (string) ($_POST['s_na'] ?? ''),
    'target_na' => (string) ($_POST['target_na'] ?? '140'),
    'infusion_na' => (string) ($_POST['infusion_na'] ?? '154'), // 0.9% NaCl has 154 mmol/L
    'infusion_k' => (string) ($_POST['infusion_k'] ?? '0'),
    'patient_first_name' => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name' => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date' => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number' => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
];


if (isLoggedIn() && isset($_GET['load_id'])) {
    $loadId = (int) $_GET['load_id'];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION['user_id']);
    if ($loadedRow) {
        $form['patient_first_name'] = (string) ($loadedRow['patient_first_name'] ?? '');
        $form['patient_last_name'] = (string) ($loadedRow['patient_last_name'] ?? '');
        $form['patient_birth_date'] = (string) ($loadedRow['patient_birth_date'] ?? '');
        $form['patient_birth_number'] = (string) ($loadedRow['patient_birth_number'] ?? '');
        $form['patient_insurance_code'] = (string) ($loadedRow['patient_insurance_code'] ?? '');
        if (is_array($loadedRow['input_payload'])) {
            foreach ($loadedRow['input_payload'] as $k => $v) {
                if (isset($form[$k]) || array_key_exists($k, $form)) {
                    $form[$k] = (string) $v;
                }
            }
        }
        $messages[] = 'Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.';
    }
}

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
                    error_log('calculator_na delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        if ($form['age_years'] === '') {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form['age_years'] = (string) $derived;
            }
        }

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '') $errors[] = 'Vyberte pohlavie.';

        $ageYears = filter_var($form['age_years'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 18, 'max_range' => 120]
        ]);
        if ($ageYears === false) $errors[] = 'Vek musí byť celé číslo v intervale 18 až 120 rokov.';

        $weightKg = calculatorParsePositiveFloat($form['weight_kg']);
        if ($weightKg === null) $errors[] = 'Hmotnosť musí byť kladné číslo.';

        $sNa = calculatorParsePositiveFloat($form['s_na']);
        if ($sNa === null) $errors[] = 'Zadajte platnú hladinu aktuálneho sérového sodíka.';

        $targetNa = calculatorParsePositiveFloat($form['target_na']);
        if ($targetNa === null) $targetNa = 140.0;

        $infNa = calculatorParsePositiveFloat($form['infusion_na']);
        if ($infNa === null && $form['infusion_na'] === '0') $infNa = 0.0;

        $infK = calculatorParsePositiveFloat($form['infusion_k']);
        if ($infK === null && $form['infusion_k'] === '0') $infK = 0.0;

        if (empty($errors)) {
            // Výpočet celkovej telesnej vody (TBW)
            $factor = 0.5;
            if ($sex === 'male') {
                $factor = ($ageYears >= 65) ? 0.5 : 0.6;
            } else {
                $factor = ($ageYears >= 65) ? 0.45 : 0.5;
            }
            $tbw = $weightKg * $factor;

            // Deficit voľnej vody (iba ak hypernatrémia)
            $fwd = null;
            if ($sNa > $targetNa) {
                $fwd = $tbw * (($sNa / $targetNa) - 1);
            }

            // Adrogue-Madias (Odhadovaná zmena Na po 1L infúzie)
            $changePerL = null;
            if ($infNa !== null && $infK !== null) {
                $changePerL = ($infNa + $infK - $sNa) / ($tbw + 1);
            }

            $calculated = [
                'tbw' => round($tbw, 1),
                'fwd' => $fwd !== null ? round($fwd, 2) : null,
                'change_per_l' => $changePerL !== null ? round($changePerL, 2) : null,
                's_na' => round($sNa, 1),
                'target_na' => round($targetNa, 1),
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            'sex' => $sex,
                            'age_years' => (int) $ageYears,
                            'weight_kg' => round($weightKg, 1),
                            's_na' => round($sNa, 1),
                            'target_na' => round($targetNa, 1),
                            'infusion_na' => $infNa,
                            'infusion_k' => $infK,
                        ];

                        if (calculatorSaveResult($pdo, (int) $_SESSION['user_id'], 'na_water_disorders', 'Poruchy Na a vody', $patient, $inputPayload, $calculated)) {
                            $messages[] = 'Výsledok bol uložený do databázy.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
                        error_log('calculator_na save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'na_water_disorders', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_na fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poruchy sodíka a vody - Kalkulačky KDIGO 2024 CKD</title>
    <meta name="description" content="Nefrologická kalkulačka a nástroj: Poruchy sodíka a vody. Deficit voľnej vody a Adrogue-Madias. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <link rel="canonical" href="https://nefro.polascin.net/calculator_na.php">
    <meta property="og:title" content="Poruchy sodíka a vody">
    <meta property="og:description" content="Nefrologická kalkulačka a nástroj: Poruchy sodíka a vody. Deficit voľnej vody a Adrogue-Madias. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <meta property="og:url" content="https://nefro.polascin.net/calculator_na.php">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">

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
    $headerTitle = 'Kalkulačka Sodíka';
    $headerIntro = 'Deficit voľnej vody a Adrogue-Madias';
    $showLogo = false;
    include 'header.php';
    ?>
    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?><li><a href="admin.php">Admin panel</a></li><?php endif; ?>
                    <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlásenie</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Poruchy sodíka a vody</h2>
                <p class="auth-subtitle">Kalkulačka pre manažment hypernatrémie (deficit voľnej vody) a hyponatrémie (Adrogue-Madiasova rovnica).</p>

                <details class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">TBW = Hmotnosť &times; (0.45 až 0.6 podľa pohlavia a veku)</code>
                        <code class="calc-formula-line">Deficit vody [L] = TBW &times; ((S-Na / Cieľové Na) &minus; 1)</code>
                        <code class="calc-formula-line">Adrogue-Madias = (Infúzia Na + Infúzia K &minus; S-Na) / (TBW + 1)</code>
                        <div class="calc-formula-vars">
                            <strong>TBW:</strong> Celková telesná voda v litroch.<br>
                            <strong>Adrogue-Madias:</strong> Odhaduje, o koľko mmol/L sa zmení sérový sodík po podaní 1 litra konkrétneho infúzneho roztoku. Upozornenie: Rýchlosť korekcie by nemala presiahnuť 8-10 mmol/L za 24h, inak hrozí osmotický demyelinizačný syndróm!
                        </div>
                    </div>
                </details>

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

                <form method="POST" action="calculator_na.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

                    <div class="form-section">
                        <h3>Identifikačné údaje a základné parametre</h3>
                        <div class="form-grid">
                            <div class="form-group"><label for="sex">Pohlavie</label><select id="sex" name="sex" class="form-control" required><option value="female" <?= $form['sex']==='female'?'selected':'' ?>>Žena</option><option value="male" <?= $form['sex']==='male'?'selected':'' ?>>Muž</option></select></div>
                            <div class="form-group"><label for="age_years">Vek</label><input type="number" id="age_years" name="age_years" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>"></div>
                            <div class="form-group"><label for="weight_kg">Hmotnosť (kg)</label><input type="text" id="weight_kg" name="weight_kg" required class="form-control" value="<?= htmlspecialchars($form['weight_kg']) ?>"></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Sérový sodík a korekcia</h3>
                        <div class="form-grid">
                            <div class="form-group"><label for="s_na">Aktuálny S-Na (mmol/L)</label><input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars($form['s_na']) ?>"></div>
                            <div class="form-group"><label for="target_na">Cieľový S-Na (mmol/L) [Pre hypernatrémiu]</label><input type="text" id="target_na" name="target_na" required class="form-control" value="<?= htmlspecialchars($form['target_na']) ?>"></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre infúzie (Pre Adrogue-Madias)</h3>
                        <div class="form-grid">
                            <div class="form-group"><label for="infusion_na">Sodík v infúzii (mmol/L)</label><input type="text" id="infusion_na" name="infusion_na" class="form-control" value="<?= htmlspecialchars($form['infusion_na']) ?>" placeholder="Napr. 154 pre 0.9% NaCl"></div>
                            <div class="form-group"><label for="infusion_k">Draslík v infúzii (mmol/L)</label><input type="text" id="infusion_k" name="infusion_k" class="form-control" value="<?= htmlspecialchars($form['infusion_k']) ?>"></div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok výpočtu</h3>
                        <p><strong>Celková telesná voda (TBW):</strong> <?= htmlspecialchars(number_format((float) $calculated['tbw'], 1, ',', ' ')) ?> L</p>
                        <?php if ($calculated['fwd'] !== null && $calculated['fwd'] > 0): ?>
                            <p style="color:var(--color-accent); font-weight:600; margin-top:8px;">Deficit voľnej vody: <?= htmlspecialchars(number_format((float) $calculated['fwd'], 2, ',', ' ')) ?> L (na zníženie Na z <?= $calculated['s_na'] ?> na <?= $calculated['target_na'] ?> mmol/L)</p>
                        <?php endif; ?>
                        <?php if ($calculated['change_per_l'] !== null): ?>
                            <p style="margin-top:8px;"><strong>Odhad. zmena S-Na po 1L infúzie:</strong> <?= htmlspecialchars(number_format((float) $calculated['change_per_l'], 2, ',', ' ')) ?> mmol/L</p>
                            <p style="font-size:0.85rem; opacity:0.8;">Ak je hodnota kladná, S-Na stúpne. Ak je záporná, S-Na klesne.</p>
                        <?php endif; ?>
                        <div class="form-actions no-print" style="margin-top: 24px;">
                            <button type="button" class="btn-primary" onclick="window.print()">Vytlačiť</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <section class="auth-container auth-container--wide calc-saved-results">
                <h3>Uložené výsledky</h3>
                <?php if (!isLoggedIn()): ?>
                    <p>Pre ukladanie výsledkov sa prihláste.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Žiadne uložené výsledky.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead><tr><th>Dátum</th><th>Výsledok</th><th>Akcie</th></tr></thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></td>
                                        <td>
                                            TBW: <?= number_format($row['result_payload']['tbw']??0, 1) ?> L<br>
                                            <?php if(isset($row['result_payload']['fwd'])): ?>
                                                FWD: <?= number_format($row['result_payload']['fwd'], 2) ?> L
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_na.php" style="display:inline">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                                <input type="hidden" name="action" value="delete_saved">
                                                <input type="hidden" name="result_id" value="<?= (int) $row['id'] ?>">
                                                <button type="submit" class="btn-admin-action btn-admin-action--warn">Zmazať</button>
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
