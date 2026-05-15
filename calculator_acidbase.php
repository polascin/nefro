<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    's_na' => (string) ($_POST['s_na'] ?? ''),
    's_cl' => (string) ($_POST['s_cl'] ?? ''),
    's_hco3' => (string) ($_POST['s_hco3'] ?? ''),
    'albumin' => (string) ($_POST['albumin'] ?? '40'),
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
                    error_log('calculator_acidbase delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $na = calculatorParsePositiveFloat($form['s_na']);
        $cl = calculatorParsePositiveFloat($form['s_cl']);
        $hco3 = calculatorParsePositiveFloat($form['s_hco3']);
        $alb = calculatorParsePositiveFloat($form['albumin']);

        if ($na === null) $errors[] = 'Zadajte platnú hodnotu S-Na.';
        if ($cl === null) $errors[] = 'Zadajte platnú hodnotu S-Cl.';
        if ($hco3 === null) $errors[] = 'Zadajte platnú hodnotu HCO3.';
        if ($alb === null) $alb = 40.0;

        if (empty($errors)) {
            $ag = $na - ($cl + $hco3);
            $correctedAg = $ag + 0.25 * (40.0 - $alb);
            $deltaGap = $correctedAg - 12.0;
            $deltaHco3 = 24.0 - $hco3;
            
            $deltaRatio = null;
            $interpretation = '';
            
            if (abs($deltaHco3) > 0.5) {
                $deltaRatio = $deltaGap / $deltaHco3;
                
                if ($deltaRatio < 0.4) {
                    $interpretation = 'Hyperchloremická (normálna AG) metabolická acidóza.';
                } elseif ($deltaRatio < 0.8) {
                    $interpretation = 'Zmiešaná high-AG a normálna-AG metabolická acidóza.';
                } elseif ($deltaRatio < 2.0) {
                    $interpretation = 'Čistá high-AG metabolická acidóza.';
                } else {
                    $interpretation = 'High-AG metabolická acidóza + súbežná metabolická alkalóza alebo chronická respiračná acidóza.';
                }
            } else {
                $interpretation = 'Delta HCO3 je príliš blízko nule pre výpočet Delta pomeru.';
            }

            $calculated = [
                'ag' => round($ag, 1),
                'corrected_ag' => round($correctedAg, 1),
                'delta_ratio' => $deltaRatio !== null ? round($deltaRatio, 2) : null,
                'interpretation' => $interpretation,
                'na' => round($na, 1),
                'cl' => round($cl, 1),
                'hco3' => round($hco3, 1),
                'alb' => round($alb, 1),
            ];

            if ($action === 'save') {
                if (!isLoggedIn()) {
                    $errors[] = 'Pre uloženie výsledku sa prihláste.';
                } else {
                    try {
                        $inputPayload = [
                            's_na' => round($na, 1),
                            's_cl' => round($cl, 1),
                            's_hco3' => round($hco3, 1),
                            'albumin' => round($alb, 1),
                        ];

                        if (calculatorSaveResult($pdo, (int) $_SESSION['user_id'], 'acidbase_ag', 'Acidobáza (Anion Gap)', $patient, $inputPayload, $calculated)) {
                            $messages[] = 'Výsledok bol uložený.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
                        error_log('calculator_acidbase save error: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'acidbase_ag', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aniónová medzera a Delta Ratio - Kalkulačky</title>
    <meta name="description" content="Nefrologická kalkulačka a nástroj: Aniónová medzera a Delta Ratio. Súčasť analýzy metabolickej acidózy. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <link rel="canonical" href="https://nefro.polascin.net/calculator_acidbase.php">
    <meta property="og:title" content="Aniónová medzera a Delta Ratio">
    <meta property="og:description" content="Nefrologická kalkulačka a nástroj: Aniónová medzera a Delta Ratio. Súčasť analýzy metabolickej acidózy. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <meta property="og:url" content="https://nefro.polascin.net/calculator_acidbase.php">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">

    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": [
        "MedicalWebPage",
        "WebApplication"
    ],
    "name": "Lekárska kalkulačka",
    "description": "Nástroj pre klinické rozhodovanie a výpočty v nefrológii.",
    "url": "https://nefro.polascin.net/calculator_acidbase.php",
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
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Aniónová medzera (Anion Gap)';
    $headerIntro = 'Súčasť analýzy metabolickej acidózy';
    $showLogo = false;
    include 'header.php';
    ?>
    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active">Kalkulačky</a></li>
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
                <h2>Aniónová medzera a Delta-Delta pomer</h2>
                <p class="auth-subtitle">Základný nástroj na diagnostiku zmiešaných porúch acidobázickej rovnováhy.</p>

                <details class="calc-formula-box">
                    <summary>Vzorce a vysvetlivky</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">AG = Na &minus; (Cl + HCO3)</code>
                        <code class="calc-formula-line">Korig. AG = AG + 0.25 &times; (40 &minus; Albumín)</code>
                        <code class="calc-formula-line">&Delta; Ratio = (Korig. AG &minus; 12) / (24 &minus; HCO3)</code>
                        <div class="calc-formula-vars">
                            Normálna aniónová medzera je cca 10-14 mmol/L.<br>
                            U pacientov s hypoalbuminémiou (časté pri nefrotickom syndróme, závažnom CKD) musí byť AG korigovaná, inak sa falošne podhodnotí.
                        </div>
                    </div>
                </details>

                <?php foreach ($messages as $message): ?>
                    <div class="alert alert-success"><p><?= htmlspecialchars($message) ?></p></div>
                <?php endforeach; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error"><ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <form method="POST" action="calculator_acidbase.php">
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
                            <div class="form-group"><label for="s_na">S-Na (mmol/L)</label><input type="text" id="s_na" name="s_na" required class="form-control" value="<?= htmlspecialchars($form['s_na']) ?>"></div>
                            <div class="form-group"><label for="s_cl">S-Cl (mmol/L)</label><input type="text" id="s_cl" name="s_cl" required class="form-control" value="<?= htmlspecialchars($form['s_cl']) ?>"></div>
                            <div class="form-group"><label for="s_hco3">S-HCO3 (mmol/L)</label><input type="text" id="s_hco3" name="s_hco3" required class="form-control" value="<?= htmlspecialchars($form['s_hco3']) ?>"></div>
                            <div class="form-group"><label for="albumin">S-Albumín (g/L)</label><input type="text" id="albumin" name="albumin" class="form-control" value="<?= htmlspecialchars($form['albumin']) ?>"></div>
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
                        <p><strong>Nekorigovaná Aniónová medzera:</strong> <?= htmlspecialchars($calculated['ag']) ?> mmol/L</p>
                        <p><strong>Korigovaná Aniónová medzera (pri Alb. <?= $calculated['alb'] ?> g/L):</strong> <?= htmlspecialchars($calculated['corrected_ag']) ?> mmol/L</p>
                        <?php if ($calculated['delta_ratio'] !== null): ?>
                            <p style="margin-top:16px;"><strong>Delta Ratio (&Delta;/&Delta; pomer):</strong> <?= htmlspecialchars($calculated['delta_ratio']) ?></p>
                            <p style="color:var(--color-accent); font-weight:600;">Interpretácia: <?= htmlspecialchars($calculated['interpretation']) ?></p>
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
                                            AG: <?= number_format($row['result_payload']['ag']??0, 1) ?> mmol/L<br>
                                            <?php if(isset($row['result_payload']['delta_ratio'])): ?>
                                                &Delta; Ratio: <?= number_format($row['result_payload']['delta_ratio'], 2) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_acidbase.php" style="display:inline">
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
