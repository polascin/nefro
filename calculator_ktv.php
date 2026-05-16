<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'u_pre' => (string) ($_POST['u_pre'] ?? ''),
    'u_post' => (string) ($_POST['u_post'] ?? ''),
    'weight_post' => (string) ($_POST['weight_post'] ?? ''),
    'time_hours' => (string) ($_POST['time_hours'] ?? ''),
    'uf_volume' => (string) ($_POST['uf_volume'] ?? ''),
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

        $upre = calculatorParsePositiveFloat($form['u_pre']);
        $upost = calculatorParsePositiveFloat($form['u_post']);
        $w = calculatorParsePositiveFloat($form['weight_post']);
        $t = calculatorParsePositiveFloat($form['time_hours']);
        $uf = calculatorParsePositiveFloat($form['uf_volume']);

        if (!$upre || !$upost || !$w || !$t || $uf === null) {
            $errors[] = 'Vyplňte všetky hodnoty platnými číslami.';
        } else {
            $r = $upost / $upre;
            $urr = (1 - $r) * 100;
            
            $logTerm = $r - (0.008 * $t);
            if ($logTerm <= 0) {
                $errors[] = 'Zadané hodnoty neumožňujú výpočet logaritmu v Daugirdasovej rovnici (extrémne nízke U_post alebo dlhý čas).';
            } else {
                $ktv = -log($logTerm) + (4 - 3.5 * $r) * ($uf / $w);
                
                $calculated = [
                    'urr' => round($urr, 1),
                    'ktv' => round($ktv, 2),
                    'interpretation' => ($ktv >= 1.2 && $urr >= 65) ? 'Adekvátna dialýza podľa štandardov (Kt/V ≥ 1.2, URR ≥ 65%).' : 'Suboptimálna dialyzačná dávka. Zvážte predĺženie času alebo zvýšenie prietoku krvi/dialyzátu.',
                ];

                if ($action === 'save') {
                    if (!isLoggedIn()) $errors[] = 'Pre uloženie sa prihláste.';
                    else {
                        $inPayload = [
                            'u_pre' => $upre, 'u_post' => $upost,
                            'weight_post' => $w, 'time_hours' => $t, 'uf_volume' => $uf
                        ];
                        calculatorSaveResult($pdo, (int)$_SESSION['user_id'], 'hd_ktv', 'Kt/V a URR', $patient, $inPayload, $calculated);
                        $messages[] = 'Výsledok uložený.';
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'hd_ktv', 25);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Hodnotenie hemodialýzy Kt/V a URR - Kalkulačky';
  $seoDescription = 'Nefrologická kalkulačka a nástroj: Hodnotenie hemodialýzy Kt/V a URR. Hodnotenie adekvátnosti HD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.';
  $structuredData = [
    [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $baseUrl . 'calculators.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Kt/V (Daugirdas II) a Urea Reduction Ratio (URR)', 'item' => $baseUrl . 'calculator_ktv.php']
      ]
    ]
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php $headerTitle = 'Kt/V a URR'; $headerIntro = 'Hodnotenie adekvátnosti HD'; $showLogo = false; include 'header.php'; ?>
    <nav class="main-nav" aria-label="Hlavná navigácia"><div class="container"><ul>
        <li><a href="index.php">Domov</a></li>
        <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?><li><a href="admin.php">Admin panel</a></li><?php endif; ?>
            <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php">Prihlásenie</a></li>
        <?php endif; ?>
    </ul></div></nav>
    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Kt/V (Daugirdas II) a Urea Reduction Ratio (URR)</h2>

                <details class="calc-formula-box">
                    <summary>Vzorce — Kt/V (Daugirdas II) a URR</summary>
                    <div class="calc-formula-content">
                        <div class="calc-formula-line">\[ \text{URR} = \left(1 - \frac{U_{\text{post}}}{U_{\text{pre}}}\right) \times 100\% \]</div>
                        <div class="calc-formula-line">\[ r = \frac{U_{\text{post}}}{U_{\text{pre}}}, \quad \text{Kt/V} = -\ln(r - 0.008 \cdot t) + (4 - 3.5r) \cdot \frac{UF}{W} \]</div>
                        <div class="calc-formula-vars">
                            $U_{\text{pre/post}}$ = močová urea pred/po dialýze &bull;
                            $t$ = čas dialýzy (h) &bull;
                            $UF$ = ultrafiltrát (L) &bull;
                            $W$ = postdialyzačná hmotnosť (kg)
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
                            <div class="form-group"><label>S-Urea PRED dialýzou (mmol/L)</label><input type="text" name="u_pre" class="form-control" value="<?= htmlspecialchars($form['u_pre']) ?>" required></div>
                            <div class="form-group"><label>S-Urea PO dialýze (mmol/L)</label><input type="text" name="u_post" class="form-control" value="<?= htmlspecialchars($form['u_post']) ?>" required></div>
                            <div class="form-group"><label>Trvanie dialýzy (hodiny)</label><input type="text" name="time_hours" class="form-control" value="<?= htmlspecialchars($form['time_hours']) ?>" required></div>
                            <div class="form-group"><label>Hmotnosť PO dialýze (kg)</label><input type="text" name="weight_post" class="form-control" value="<?= htmlspecialchars($form['weight_post']) ?>" required></div>
                            <div class="form-group"><label>Ultrafiltrácia (L alebo kg)</label><input type="text" name="uf_volume" class="form-control" value="<?= htmlspecialchars($form['uf_volume']) ?>" required></div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="action" value="calculate" class="btn-primary">Vypočítať</button>
                        <button type="submit" name="action" value="save" class="btn-secondary">Vypočítať a uložiť</button>
                    </div>
                </form>

                <?php if ($calculated !== null): ?>
                    <div class="form-section calculator-result-block">
                        <h3>Výsledok</h3>
                        <p><strong>Kt/V (Daugirdas II):</strong> <?= htmlspecialchars($calculated['ktv']) ?></p>
                        <p><strong>URR (Urea Reduction Ratio):</strong> <?= htmlspecialchars($calculated['urr']) ?> %</p>
                        <p style="color:var(--color-accent); font-weight:600;">Interpretácia: <?= htmlspecialchars($calculated['interpretation']) ?></p>
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
                                            Kt/V: <?= number_format($row['result_payload']['ktv']??0, 2) ?><br>
                                            URR: <?= number_format($row['result_payload']['urr']??0, 1) ?> %
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
