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
        'G1' => 'normálna alebo vysoká filtrácia',
        'G2' => 'mierne znížená filtrácia',
        'G3a' => 'mierne až stredne znížená filtrácia',
        'G3b' => 'stredne až výrazne znížená filtrácia',
        'G4' => 'výrazne znížená filtrácia',
        'G5' => 'zlyhanie obličiek',
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
                    error_log('calculator_egfr delete error: ' . $e->getMessage());
                }
            }
        }
    } elseif ($action === 'calculate' || $action === 'save') {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);
        // Auto-doplniť vek z dát. narodenia / rodného čísla, ak pole ostalo prázdne
        if ($form['age_years'] === '') {
            $derived = calculatorAgeFromPatient($patient);
            if ($derived !== null) {
                $form['age_years'] = (string) $derived;
            }
        }

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
            $errors[] = 'Vek musí byť celé číslo v intervale 18 až 120 rokov.';
        }

        $creatinineValue = calculatorParsePositiveFloat($form['creatinine_value']);
        if ($creatinineValue === null) {
            $errors[] = 'Kreatinín musí byť kladné číslo.';
        }

        $creatinineUnit = in_array($form['creatinine_unit'], ['umol_l', 'mg_dl'], true)
            ? $form['creatinine_unit']
            : '';
        if ($creatinineUnit === '') {
            $errors[] = 'Vyberte jednotku kreatinínu.';
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
                    $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
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
                            $messages[] = 'Výsledok bol uložený do databázy.';
                        } else {
                            $errors[] = 'Výsledok sa nepodarilo uložiť.';
                        }
                    } catch (\PDOException $e) {
                        $errors[] = 'Databázová chyba pri ukladaní výsledku.';
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
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_egfr fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGFR CKD-EPI 2021 - Kalkulačky KDIGO 2024 CKD</title>
    <meta name="description" content="Nefrologická kalkulačka a nástroj: eGFR CKD-EPI 2021. CKD-EPI 2021 podľa KDIGO 2024. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <link rel="canonical" href="https://nefro.polascin.net/calculator_egfr.php">
    <meta property="og:title" content="eGFR CKD-EPI 2021">
    <meta property="og:description" content="Nefrologická kalkulačka a nástroj: eGFR CKD-EPI 2021. CKD-EPI 2021 podľa KDIGO 2024. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <meta property="og:url" content="https://nefro.polascin.net/calculator_egfr.php">
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
    "url": "https://nefro.polascin.net/calculator_egfr.php",
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
    $headerTitle = 'Kalkulačka eGFR';
    $headerIntro = 'CKD-EPI 2021 podľa KDIGO 2024';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <li><a href="calculator_kdigo_risk.php">KDIGO G/A riziko</a></li>
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
                <h2>eGFR (CKD-EPI 2021)</h2>
                <p class="auth-subtitle">Voliteľné údaje pacienta + povinné vstupy pre výpočet.</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec — CKD-EPI 2021</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">eGFR = 142 &times; min(S<sub>cr</sub>/&kappa;, 1)<sup>&alpha;</sup> &times; max(S<sub>cr</sub>/&kappa;, 1)<sup>&minus;1.200</sup> &times; 0.9938<sup>Vek</sup> [&times; 1.012 &nbsp;ak&nbsp;&nbsp;&#x2640;]</code>
                        <code class="calc-formula-line">Prepočet: S<sub>cr</sub> [mg/dL] = S<sub>cr</sub> [&micro;mol/L] &divide; 88.4</code>
                        <div class="calc-formula-vars">
                            &kappa; = 0.7 (žena) / 0.9 (muž)&ensp;&bull;&ensp;
                            &alpha; = &minus;0.241 (žena) / &minus;0.302 (muž)&ensp;&bull;&ensp;
                            S<sub>cr</sub> = sérový kreatinín v mg/dL
                        </div>
                    </div>
                </details>

                <div class="alert" style="background:rgba(16,185,129,0.07);border-left:4px solid #10b981;padding:12px 16px;border-radius:6px;margin-bottom:16px;font-size:0.88rem;">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://www.kidney.org/professionals/kdoqi/gfr_calculator" target="_blank" rel="noopener noreferrer">NKF / KDOQI eGFR</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/3939/ckd-epi-equations-glomerular-filtration-rate-gfr" target="_blank" rel="noopener noreferrer">MDCalc CKD-EPI</a> &ensp;&bull;&ensp;
                    <a href="https://qxmd.com/calculate/calculator_251/egfr-using-ckd-epi-2021" target="_blank" rel="noopener noreferrer">QxMD eGFR</a>
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

                <form method="POST" action="calculator_egfr.php">
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
                            <div class="form-group">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_value">S-kreatinín</label>
                                <input type="text" id="creatinine_value" name="creatinine_value" required class="form-control" value="<?= htmlspecialchars($form['creatinine_value']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="creatinine_unit">Jednotka kreatinínu</label>
                                <select id="creatinine_unit" name="creatinine_unit" class="form-control" required>
                                    <option value="umol_l" <?= $form['creatinine_unit'] === 'umol_l' ? 'selected' : '' ?>>µmol/L</option>
                                    <option value="mg_dl" <?= $form['creatinine_unit'] === 'mg_dl' ? 'selected' : '' ?>>mg/dL</option>
                                </select>
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
                        <p><strong>eGFR:</strong> <?= htmlspecialchars(number_format((float) $calculated['egfr'], 1, ',', ' ')) ?> ml/min/1,73m²</p>
                        <p><strong>Kategória:</strong> <?= htmlspecialchars($calculated['g_category']) ?> (<?= htmlspecialchars($calculated['g_description']) ?>)</p>
                        <p><strong>Kreatinín prepočítaný na mg/dL:</strong> <?= htmlspecialchars(number_format((float) $calculated['creatinine_mg_dl'], 3, ',', ' ')) ?></p>
                        <div class="form-actions no-print">
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
                                    $egfrValue = (float) ($result['egfr'] ?? 0);
                                    $category = (string) ($result['g_category'] ?? '');
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            <?= htmlspecialchars(number_format($egfrValue, 1, ',', ' ')) ?> ml/min/1,73 m²
                                            <?php if ($category !== ''): ?>
                                                (<?= htmlspecialchars($category) ?>)
                                            <?php endif; ?>
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_egfr.php" style="display:inline" onsubmit="return confirm('Naozaj vymazať záznam?')">
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

    <script>
    (function () {
        function ageFromDate(dateStr) {
            if (!dateStr) return null;
            var b = new Date(dateStr), t = new Date();
            var age = t.getFullYear() - b.getFullYear();
            var m = t.getMonth() - b.getMonth();
            if (m < 0 || (m === 0 && t.getDate() < b.getDate())) age--;
            return age >= 0 ? age : null;
        }
        function ageFromBirthNumber(bn) {
            var d = bn.replace(/[\s\/]/g, '');
            if (!/^\d{9,10}$/.test(d)) return null;
            var yy = +d.slice(0,2), mm = +d.slice(2,4), dd = +d.slice(4,6);
            if (mm >= 71) mm -= 70; else if (mm >= 51) mm -= 50; else if (mm >= 21) mm -= 20;
            if (mm < 1 || mm > 12 || dd < 1 || dd > 31) return null;
            var cy = new Date().getFullYear();
            var yr = (2000 + yy <= cy) ? 2000 + yy : 1900 + yy;
            var ds = yr + '-' + String(mm).padStart(2,'0') + '-' + String(dd).padStart(2,'0');
            return ageFromDate(ds);
        }
        function fillAge(age) {
            var el = document.getElementById('age_years');
            if (!el || age === null) return;
            el.value = age;
        }
        var bd = document.getElementById('patient_birth_date');
        var bn = document.getElementById('patient_birth_number');
        if (bd) bd.addEventListener('change', function () { fillAge(ageFromDate(this.value)); });
        if (bn) bn.addEventListener('input', function () {
            var a = ageFromBirthNumber(this.value); if (a !== null) fillAge(a);
        });
    })();
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
