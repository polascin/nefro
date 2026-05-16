<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'u_alb' => (string) ($_POST['u_alb'] ?? ''),
    'u_alb_unit' => (string) ($_POST['u_alb_unit'] ?? 'mg_l'),
    'u_cr' => (string) ($_POST['u_cr'] ?? ''),
    'u_cr_unit' => (string) ($_POST['u_cr_unit'] ?? 'mmol_l'),
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
            if ($resultId > 0) {
                calculatorDeleteSavedResult($pdo, $resultId, (int) $_SESSION['user_id']);
                $messages[] = 'Výsledok bol vymazaný.';
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $ualb = calculatorParsePositiveFloat($form['u_alb']);
        $ucr = calculatorParsePositiveFloat($form['u_cr']);
        
        if ($ualb === null || $ucr === null) {
            $errors[] = 'Zadajte platné kladné čísla pre albumín aj kreatinín.';
        } else {
            $alb_mg_l = $ualb;
            if ($form['u_alb_unit'] === 'mg_dl') $alb_mg_l = $ualb * 10;
            elseif ($form['u_alb_unit'] === 'g_l') $alb_mg_l = $ualb * 1000;
            
            $cr_mmol_l = $ucr;
            if ($form['u_cr_unit'] === 'mg_dl') {
                $cr_mmol_l = $ucr * 0.0884;
            }
            $cr_g_l = $cr_mmol_l * 113.12 / 1000;
            
            if ($cr_mmol_l > 0 && $cr_g_l > 0) {
                $uacr_mg_mmol = $alb_mg_l / $cr_mmol_l;
                $uacr_mg_g = $alb_mg_l / $cr_g_l;
                
                $stage = '';
                $desc = '';
                if ($uacr_mg_mmol < 3) {
                    $stage = 'A1';
                    $desc = 'Normálna až mierne zvýšená albuminúria';
                } elseif ($uacr_mg_mmol <= 30) {
                    $stage = 'A2';
                    $desc = 'Stredne zvýšená albuminúria (mikroalbuminúria)';
                } else {
                    $stage = 'A3';
                    $desc = 'Výrazne zvýšená albuminúria (makroalbuminúria)';
                }
                
                $calculated = [
                    'mg_mmol' => round($uacr_mg_mmol, 2),
                    'mg_g' => round($uacr_mg_g, 2),
                    'stage' => $stage,
                    'desc' => $desc,
                ];

                if ($action === 'save') {
                    if (!isLoggedIn()) $errors[] = 'Pre uloženie sa prihláste.';
                    else {
                        $inPayload = [
                            'u_alb' => $ualb, 'u_alb_unit' => $form['u_alb_unit'],
                            'u_cr' => $ucr, 'u_cr_unit' => $form['u_cr_unit']
                        ];
                        calculatorSaveResult($pdo, (int)$_SESSION['user_id'], 'uacr_kdigo', 'UACR klasifikácia', $patient, $inPayload, $calculated);
                        $messages[] = 'Výsledok uložený.';
                    }
                }
            } else {
                $errors[] = 'Kreatinín musí byť väčší ako 0.';
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'uacr_kdigo', 25);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'UACR a KDIGO klasifikácia - Kalkulačky';
  $seoDescription = 'Nefrologická kalkulačka a nástroj: UACR a KDIGO klasifikácia. Hodnotenie albuminúrie (KDIGO). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.';
  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $baseUrl . 'calculators.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'UACR (Urine Albumin-to-Creatinine Ratio) a KDIGO A-štádium', 'item' => $baseUrl . 'calculator_uacr.php']
      ]
    ]
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <?php $headerTitle = 'UACR (Albumín/Kreatinín)'; $headerIntro = 'Hodnotenie albuminúrie (KDIGO)'; $showLogo = false; include 'header.php'; ?>
    <nav class="main-nav"><div class="container"><ul><li><a href="calculators.php">Späť na kalkulačky</a></li></ul></div></nav>
    <main class="container main-content main-content--single-col">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>UACR (Urine Albumin-to-Creatinine Ratio) a KDIGO A-štádium</h2>

                <details class="calc-formula-box">
                    <summary>Vzorce — UACR a KDIGO A-štádium</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{UACR} = \frac{\text{Alb}_{\text{moč}}}{\text{Cr}_{\text{moč}}} \]</div>
                        <div class="calc-formula-line">\[ \text{UACR [mg/g]} = \text{UACR [mg/mmol]} \times 8.84 \]</div>
                        <div class="calc-formula-vars">
                            A1: UACR $\lt 30$ mg/g &bull; A2: $30$–$300$ mg/g &bull; A3: $\gt 300$ mg/g
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $m): ?><div class="alert alert-success"><?= htmlspecialchars($m) ?></div><?php endforeach; ?>
                <?php if (!empty($errors)): ?><div class="alert alert-error"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

                <form method="POST">
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
                            <div class="form-group"><label>U-Albumín</label><input type="text" name="u_alb" class="form-control" value="<?= htmlspecialchars($form['u_alb']) ?>" required></div>
                            <div class="form-group">
                                <label>Jednotka Albumínu</label>
                                <select name="u_alb_unit" class="form-control">
                                    <option value="mg_l" <?= $form['u_alb_unit']==='mg_l'?'selected':'' ?>>mg/L</option>
                                    <option value="mg_dl" <?= $form['u_alb_unit']==='mg_dl'?'selected':'' ?>>mg/dL</option>
                                    <option value="g_l" <?= $form['u_alb_unit']==='g_l'?'selected':'' ?>>g/L</option>
                                </select>
                            </div>
                            <div class="form-group"><label>U-Kreatinín</label><input type="text" name="u_cr" class="form-control" value="<?= htmlspecialchars($form['u_cr']) ?>" required></div>
                            <div class="form-group">
                                <label>Jednotka Kreatinínu</label>
                                <select name="u_cr_unit" class="form-control">
                                    <option value="mmol_l" <?= $form['u_cr_unit']==='mmol_l'?'selected':'' ?>>mmol/L</option>
                                    <option value="mg_dl" <?= $form['u_cr_unit']==='mg_dl'?'selected':'' ?>>mg/dL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok KDIGO</h3>
                        <p><strong>UACR:</strong> <?= htmlspecialchars($calculated['mg_mmol']) ?> mg/mmol (<?= htmlspecialchars($calculated['mg_g']) ?> mg/g)</p>
                        <p style="color:var(--color-accent); font-weight:600; font-size:1.1rem; margin-top:8px;">KDIGO Štádium: <?= htmlspecialchars($calculated['stage']) ?></p>
                        <p><?= htmlspecialchars($calculated['desc']) ?></p>
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
                    <p>Pre ukladanie výsledkov sa prihláste.</p>
                <?php elseif (empty($savedResults)): ?>
                    <p>Žiadne uložené výsledky.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead><tr><th>Dátum</th><th>Pacient</th><th>Výsledok</th><th>Akcie</th></tr></thead>
                            <tbody>
                                <?php foreach ($savedResults as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            <?= number_format($row['result_payload']['mg_mmol']??0, 2) ?> mg/mmol<br>
                                            Štádium: <?= htmlspecialchars($row['result_payload']['stage']??'') ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" style="display:inline">
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
