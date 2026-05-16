<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    's_cr_value' => (string) ($_POST['s_cr_value'] ?? ''),
    's_cr_unit' => (string) ($_POST['s_cr_unit'] ?? 'umol_l'),
    'u_cr_value' => (string) ($_POST['u_cr_value'] ?? ''),
    'u_cr_unit' => (string) ($_POST['u_cr_unit'] ?? 'mmol_l'),
    's_na' => (string) ($_POST['s_na'] ?? ''),
    'u_na' => (string) ($_POST['u_na'] ?? ''),
    's_urea' => (string) ($_POST['s_urea'] ?? ''),
    'u_urea' => (string) ($_POST['u_urea'] ?? ''),
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
                    error_log('calculator_aki delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $sCrValue = calculatorParsePositiveFloat($form['s_cr_value']);
        $uCrValue = calculatorParsePositiveFloat($form['u_cr_value']);

        if ($sCrValue === null) $errors[] = 'Zadajte platnú hodnotu sérového kreatinínu.';
        if ($uCrValue === null) $errors[] = 'Zadajte platnú hodnotu kreatinínu v moči.';

        $sCrUnit = in_array($form['s_cr_unit'], ['umol_l', 'mg_dl'], true) ? $form['s_cr_unit'] : '';
        $uCrUnit = in_array($form['u_cr_unit'], ['mmol_l', 'mg_dl'], true) ? $form['u_cr_unit'] : '';

        if ($sCrUnit === '') $errors[] = 'Vyberte jednotku sérového kreatinínu.';
        if ($uCrUnit === '') $errors[] = 'Vyberte jednotku kreatinínu v moči.';

        $sNa = calculatorParsePositiveFloat($form['s_na']);
        $uNa = calculatorParsePositiveFloat($form['u_na']);
        $sUrea = calculatorParsePositiveFloat($form['s_urea']);
        $uUrea = calculatorParsePositiveFloat($form['u_urea']);

        $canCalcNa = ($sNa !== null && $uNa !== null);
        $canCalcUrea = ($sUrea !== null && $uUrea !== null);

        if (!$canCalcNa && !$canCalcUrea) {
            $errors[] = 'Pre výpočet musíte zadať hodnoty sodíka (S-Na a U-Na) alebo urey (S-Urea a U-Urea).';
        }

        if (empty($errors)) {
            $sCrUmol = $sCrUnit === 'mg_dl' ? ((float) $sCrValue * 88.4) : (float) $sCrValue;
            $sCrMmol = $sCrUmol / 1000.0;
            $uCrMmol = $uCrUnit === 'mg_dl' ? ((float) $uCrValue * 0.0884) : (float) $uCrValue;

            $fena = null;
            $fenaInterpretation = '';
            if ($canCalcNa) {
                $fena = ($uNa * $sCrMmol) / ($sNa * $uCrMmol) * 100.0;
                if ($fena < 1.0) {
                    $fenaInterpretation = 'Prerenálne zlyhanie (často < 1 %)';
                } elseif ($fena > 2.0) {
                    $fenaInterpretation = 'Akútna tubulárna nekróza - ATN (často > 2 %)';
                } else {
                    $fenaInterpretation = 'Hraničná hodnota (zmiešaná etiológia)';
                }
            }

            $feurea = null;
            $feureaInterpretation = '';
            if ($canCalcUrea) {
                $feurea = ($uUrea * $sCrMmol) / ($sUrea * $uCrMmol) * 100.0;
                if ($feurea < 35.0) {
                    $feureaInterpretation = 'Prerenálne zlyhanie (často < 35 %)';
                } elseif ($feurea > 50.0) {
                    $feureaInterpretation = 'Akútna tubulárna nekróza - ATN (často > 50 %)';
                } else {
                    $feureaInterpretation = 'Hraničná hodnota (zmiešaná etiológia)';
                }
            }

            $calculated = [
                'fena' => $fena !== null ? round($fena, 2) : null,
                'fena_interpretation' => $fenaInterpretation,
                'feurea' => $feurea !== null ? round($feurea, 2) : null,
                'feurea_interpretation' => $feureaInterpretation,
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            's_cr_value' => round((float) $sCrValue, 2),
                            's_cr_unit' => $sCrUnit,
                            'u_cr_value' => round((float) $uCrValue, 2),
                            'u_cr_unit' => $uCrUnit,
                            's_na' => $sNa,
                            'u_na' => $uNa,
                            's_urea' => $sUrea,
                            'u_urea' => $uUrea,
                        ];

                        $resultPayload = $calculated;

                        if (calculatorSaveResult(
                            $pdo,
                            (int) $_SESSION['user_id'],
                            'aki_fena_feurea',
                            'FENa / FEUrea',
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
                        error_log('calculator_aki save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'aki_fena_feurea', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_aki fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'FENa a FEUrea (AKI) - Kalkulačky KDIGO 2024 CKD';
  $seoDescription = 'Nefrologická kalkulačka a nástroj: FENa a FEUrea (AKI). FENa a FEUrea (Frakčná exkrécia). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.';
  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $baseUrl . 'calculators.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Frakčná exkrécia sodíka a urey (FENa / FEUrea)', 'item' => $baseUrl . 'calculator_aki.php']
      ]
    ]
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačka AKI';
    $headerIntro = 'FENa a FEUrea (Frakčná exkrécia)';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <li><a href="calculator_egfr.php">eGFR</a></li>
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
                <h2>Frakčná exkrécia sodíka a urey (FENa / FEUrea)</h2>
                <p class="auth-subtitle">Diferenciálna diagnostika akútneho poškodenia obličiek (AKI).</p>

                <details class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{FENa} = \frac{U_{Na} \times S_{Cr}}{S_{Na} \times U_{Cr}} \times 100\% \]</div>
                        <div class="calc-formula-line">\[ \text{FEUrea} = \frac{U_{\text{Urea}} \times S_{Cr}}{S_{\text{Urea}} \times U_{Cr}} \times 100\% \]</div>
                        <div class="calc-formula-vars">
                            <strong>FENa:</strong> &lt; 1 % typicky svedčí pre prerenálne zlyhanie (hypoperfúzia), &gt; 2 % pre renálne zlyhanie (ATN). V prípade užívania diuretík je FENa nepresná (zvýšená exkrécia Na).<br>
                            <strong>FEUrea:</strong> Výhodná pri užívaní diuretík. &lt; 35 % svedčí pre prerenálne zlyhanie, &gt; 50 % pre ATN.
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

                <form method="POST" action="calculator_aki.php">
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

                            <?php include __DIR__ . '/patient_insurance_select.php'; ?>


                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Povinné vstupy na výpočet</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="s_cr_value">S-Kreatinín</label>
                                <input type="text" id="s_cr_value" name="s_cr_value" required class="form-control" value="<?= htmlspecialchars($form['s_cr_value']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="s_cr_unit">Jednotka S-Kreatinínu</label>
                                <select id="s_cr_unit" name="s_cr_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form['s_cr_unit'] === 'umol_l' ? 'selected' : '' ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form['s_cr_unit'] === 'mg_dl' ? 'selected' : '' ?>>mg/dL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="u_cr_value">U-Kreatinín</label>
                                <input type="text" id="u_cr_value" name="u_cr_value" required class="form-control" value="<?= htmlspecialchars($form['u_cr_value']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_cr_unit">Jednotka U-Kreatinínu</label>
                                <select id="u_cr_unit" name="u_cr_unit" class="form-control" required>
                                    <option value="mmol_l" <?= $form['u_cr_unit'] === 'mmol_l' ? 'selected' : '' ?>>mmol/L</option>
                                    <option value="mg_dl" <?= $form['u_cr_unit'] === 'mg_dl' ? 'selected' : '' ?>>mg/dL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre pre FENa (Sodík)</h3>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">Vyplňte pre výpočet FENa.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="s_na">S-Sodík (mmol/L)</label>
                                <input type="text" id="s_na" name="s_na" class="form-control" value="<?= htmlspecialchars($form['s_na']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_na">U-Sodík (mmol/L)</label>
                                <input type="text" id="u_na" name="u_na" class="form-control" value="<?= htmlspecialchars($form['u_na']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Parametre pre FEUrea (Urea)</h3>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">Vyplňte pre výpočet FEUrea (vhodné pri diuretikách).</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="s_urea">S-Urea (mmol/L)</label>
                                <input type="text" id="s_urea" name="s_urea" class="form-control" value="<?= htmlspecialchars($form['s_urea']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="u_urea">U-Urea (mmol/L)</label>
                                <input type="text" id="u_urea" name="u_urea" class="form-control" value="<?= htmlspecialchars($form['u_urea']) ?>">
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
                        <?php if ($calculated['fena'] !== null): ?>
                            <p><strong>FENa:</strong> <?= htmlspecialchars(number_format((float) $calculated['fena'], 2, ',', ' ')) ?> %</p>
                            <p style="margin-bottom: 16px;"><strong>Interpretácia FENa:</strong> <?= htmlspecialchars($calculated['fena_interpretation']) ?></p>
                        <?php endif; ?>
                        
                        <?php if ($calculated['feurea'] !== null): ?>
                            <p><strong>FEUrea:</strong> <?= htmlspecialchars(number_format((float) $calculated['feurea'], 2, ',', ' ')) ?> %</p>
                            <p><strong>Interpretácia FEUrea:</strong> <?= htmlspecialchars($calculated['feurea_interpretation']) ?></p>
                        <?php endif; ?>

                        <div class="form-actions no-print" style="margin-top: 24px;">
                            <button type="button" class="btn-primary" onclick="window.print()">Vytlačiť výpočet</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php include 'calculator_disclaimer.php'; ?>
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
                                    $result = is_array($row['result_payload']) ? $row['result_payload'] : [];
                                    $fena = isset($result['fena']) ? number_format((float)$result['fena'], 2, ',', ' ') . ' %' : '-';
                                    $feurea = isset($result['feurea']) ? number_format((float)$result['feurea'], 2, ',', ' ') . ' %' : '-';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            FENa: <?= $fena ?><br>
                                            FEUrea: <?= $feurea ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_aki.php" style="display:inline" onsubmit="return confirm('Naozaj vymazať záznam?')">
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
