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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hodnotenie hemodialýzy Kt/V a URR - Kalkulačky</title>
    <meta name="description" content="Nefrologická kalkulačka a nástroj: Hodnotenie hemodialýzy Kt/V a URR. Hodnotenie adekvátnosti HD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <link rel="canonical" href="https://nefro.polascin.net/calculator_ktv.php">
    <meta property="og:title" content="Hodnotenie hemodialýzy Kt/V a URR">
    <meta property="og:description" content="Nefrologická kalkulačka a nástroj: Hodnotenie hemodialýzy Kt/V a URR. Hodnotenie adekvátnosti HD. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <meta property="og:url" content="https://nefro.polascin.net/calculator_ktv.php">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">

    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": [
        "MedicalWebPage",
        "WebApplication"
    ],
    "name": "Lekárska kalkulačka",
    "description": "Nástroj pre klinické rozhodovanie a výpočty v nefrológii.",
    "url": "https://nefro.polascin.net/calculator_ktv.php",
    "applicationCategory": "HealthApplication",
    "audience": {
        "@type": "MedicalAudience",
        "audienceType": "Clinician"
    },
    "about": {
        "@type": "MedicalCondition",
        "name": "Kidney Disease"
    },
    "publisher": {
        "@type": "MedicalOrganization",
        "name": "Nefro-projekt Slovensko",
        "logo": {
            "@type": "ImageObject",
            "url": "https://nefro.polascin.net/img/nps-logo.gif"
        }
    }
}
    </script>
</head>
<body>
    <?php $headerTitle = 'Kt/V a URR'; $headerIntro = 'Hodnotenie adekvátnosti HD'; $showLogo = false; include 'header.php'; ?>
    <nav class="main-nav"><div class="container"><ul><li><a href="calculators.php">Späť na kalkulačky</a></li></ul></div></nav>
    <main class="container main-content main-content--single-col">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Kt/V (Daugirdas II) a Urea Reduction Ratio (URR)</h2>
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
                            <div class="form-group">
                                <label for="patient_insurance_code">Kód zdravotnej poisťovne</label>
                                <input type="text" id="patient_insurance_code" name="patient_insurance_code" class="form-control" placeholder="24 alebo 24-01" value="<?= htmlspecialchars($form['patient_insurance_code']) ?>">
                            </div>
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
