<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

/**
 * IgAN — International IgA Nephropathy Prediction Tool
 * Barbour SJ et al. JAMA Intern Med. 2019;179(7):942–952. PMC7876283
 * Klinický model (bez histológie) — Cox proportional hazards
 *
 * Výsledok: 5-ročné riziko poklesu eGFR o ≥50 % alebo ESKD
 * Koeficienty z publikovaných HR (Table 2, klinický model bez MEST):
 *   eGFR:         HR=0.9737/mL/min -> beta=ln(0.9737)=-0.02663
 *   Proteinúria:  HR=1.7380/g/deň  -> beta=ln(1.7380)= 0.55198
 *   MAP:          HR=1.0068/mmHg   -> beta=ln(1.0068)= 0.00678
 *   RASB:         HR=0.7940 (áno)  -> beta=ln(0.7940)=-0.23079
 *   Imunosupr.:   HR=0.5280 (áno)  -> beta=ln(0.5280)=-0.63861
 * Kohortné priemery (centrujeme LP): eGFR=66, prot=1.7, MAP=96, RASB=0.65, IS=0.21
 * S0(5yr) = 0.972
 */
function iganRisk(float $egfr, float $uprotGDay, float $map, bool $rasb, bool $immuno): float
{
    $lp = (-0.02663 * ($egfr      - 66.0)
          + 0.55198 * ($uprotGDay - 1.70)
          + 0.00678 * ($map       - 96.0)
          + (-0.23079) * (($rasb   ? 1 : 0) - 0.65)
          + (-0.63861) * (($immuno ? 1 : 0) - 0.21));

    $risk5yr = (1.0 - pow(0.972, exp($lp))) * 100.0;
    return max(0.0, min(100.0, $risk5yr));
}

function iganInterpretation(float $risk5yr): array
{
    $interp = [];
    $warn   = [];

    if ($risk5yr < 5.0) {
        $interp[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — nízke riziko progresie.';
    } elseif ($risk5yr < 15.0) {
        $interp[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — stredné riziko; zvážiť optimalizáciu RASB a proteinúrie.';
    } elseif ($risk5yr < 40.0) {
        $interp[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — vysoké riziko; odporúča sa nefrologická konzultácia a zváženie imunosupresie.';
        $warn[]   = 'Zvážiť imunosupresívnu liečbu podľa KDIGO 2021 IgAN Guidelines.';
    } else {
        $interp[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — veľmi vysoké riziko rýchlej progresie.';
        $warn[]   = 'VYSOKÉ RIZIKO: Urgentná nefrologická konzultácia. Zvážiť imunosupresiu a prípravu na náhradu funkcie obličiek.';
    }

    return ['interpretation' => $interp, 'warnings' => $warn];
}

// --- Hlavičkové premenné ---
header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Referrer-Policy: strict-origin-when-cross-origin');

$csp = "default-src 'self'; img-src 'self' data: https:; "
     . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
     . "font-src 'self' https://fonts.gstatic.com; "
     . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
     . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com "
     . "https://analytics.google.com https://*.analytics.google.com "
     . "https://stats.g.doubleclick.net; "
     . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; "
     . "form-action 'self'; upgrade-insecure-requests";
header('Content-Security-Policy: ' . $csp);

$siteName  = 'Nefro-projekt Slovensko';
$baseUrl   = 'https://nefro.polascin.net/';
$pageUrl   = $baseUrl . 'calculator_igan.php';
$pageTitle = 'IgAN Prediction Tool — riziko progresie IgA nefropatie | ' . $siteName;
$pageDesc  = 'International IgA Nephropathy Prediction Tool (Barbour 2019) — odhad 5-ročného rizika poklesu eGFR o ≥50 % alebo ESKD u pacientov s IgA nefropatiou. Klinický model.';
$ogImage   = $baseUrl . 'img/nps-logo.gif';

$errors    = [];
$messages  = [];
$calculated = null;
$savedResults = [];

$form = [
    'egfr'              => (string) ($_POST['egfr']        ?? ''),
    'uprot_g_day'       => (string) ($_POST['uprot_g_day'] ?? ''),
    'map_mmhg'          => (string) ($_POST['map_mmhg']    ?? ''),
    'rasb'              => (string) ($_POST['rasb']         ?? '0'),
    'immuno'            => (string) ($_POST['immuno']       ?? '0'),
    'patient_first_name'    => (string) ($_POST['patient_first_name']    ?? ''),
    'patient_last_name'     => (string) ($_POST['patient_last_name']     ?? ''),
    'patient_birth_date'    => (string) ($_POST['patient_birth_date']    ?? ''),
    'patient_birth_number'  => (string) ($_POST['patient_birth_number']  ?? ''),
    'patient_insurance_code'=> (string) ($_POST['patient_insurance_code']?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif (isset($_POST['delete_id'])) {
        if (!isLoggedIn()) {
            $errors[] = 'Na mazanie výsledkov je potrebné prihlásenie.';
        } else {
            $deleteId = (int)$_POST['delete_id'];
            if ($deleteId > 0) {
                try {
                    $pdo = getPDO();
                    if (calculatorDeleteSavedResult($pdo, $deleteId, (int)$_SESSION['user_id'])) {
                        $messages[] = 'Záznam bol úspešne vymazaný.';
                    } else {
                        $errors[] = 'Záznam sa nepodarilo vymazať (alebo neexistuje).';
                    }
                } catch (\Throwable $e) {
                    $errors[] = 'Chyba pri mazaní: ' . htmlspecialchars($e->getMessage());
                }
            }
        }
    } else {
        $patient = calculatorPatientDataFromRequest($_POST);
        calculatorValidateOptionalPatientData($patient, $errors);

        $egfr        = calculatorParsePositiveFloat($form['egfr']);
        $uprotGDay   = calculatorParsePositiveFloat($form['uprot_g_day']);
        $mapMmhg     = calculatorParsePositiveFloat($form['map_mmhg']);
        $rasbBool    = ($form['rasb']   === '1');
        $immunoBool  = ($form['immuno'] === '1');

        if ($egfr === null)      $errors[] = 'eGFR musí byť kladné číslo (napr. 45).';
        elseif ($egfr > 150)     $errors[] = 'eGFR musí byť ≤ 150 mL/min/1,73 m².';

        if ($uprotGDay === null) $errors[] = 'Proteinúria musí byť kladné číslo (napr. 1.5).';
        elseif ($uprotGDay > 30) $errors[] = 'Proteinúria musí byť ≤ 30 g/deň.';

        if ($mapMmhg === null)   $errors[] = 'Stredný arteriálny tlak (MAP) musí byť kladné číslo.';
        elseif ($mapMmhg < 50 || $mapMmhg > 200) $errors[] = 'MAP musí byť v rozsahu 50–200 mmHg.';

        if (empty($errors)) {
            $risk5yr  = iganRisk($egfr, $uprotGDay, $mapMmhg, $rasbBool, $immunoBool);
            $interp   = iganInterpretation($risk5yr);
            $calculated = [
                'egfr'        => $egfr,
                'uprot_g_day' => $uprotGDay,
                'map_mmhg'    => $mapMmhg,
                'rasb'        => $rasbBool,
                'immuno'      => $immunoBool,
                'risk5yr'     => $risk5yr,
                'interpretation' => $interp['interpretation'],
                'warnings'       => $interp['warnings'],
            ];

            if (isLoggedIn()) {
                try {
                    $pdo = getPDO();
                    $saved = calculatorSaveResult($pdo, (int)$_SESSION['user_id'], 'igan', 'IgAN Prediction Tool',
                        $patient,
                        ['egfr' => $egfr, 'uprot_g_day' => $uprotGDay, 'map_mmhg' => $mapMmhg,
                         'rasb' => $rasbBool, 'immuno' => $immunoBool],
                        ['risk5yr' => $risk5yr]
                    );
                    if ($saved) $messages[] = 'Výsledok bol uložený.';
                } catch (\Throwable $e) {
                    $errors[] = 'Výsledok sa nepodarilo uložiť: ' . htmlspecialchars($e->getMessage());
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $pdo = getPDO();
        $savedResults = calculatorFetchSavedResults($pdo, (int)$_SESSION['user_id'], 'igan');
    } catch (\Throwable) {}
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="MUDr. Ľubomír Polaščín">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap"></noscript>
    <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": [
        "MedicalWebPage",
        "WebApplication"
    ],
    "name": "IgAN Prediction Tool — riziko progresie IgA nefropatie",
    "description": "International IgA Nephropathy Prediction Tool (Barbour 2019) — odhad 5-ročného rizika poklesu eGFR o ≥50 % alebo ESKD u pacientov s IgA nefropatiou. Klinický model.",
    "url": "https://nefro.polascin.net/calculator_igan.php",
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

    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime('patient_autofill.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'IgAN Prediction Tool';
    $headerIntro = 'Predikcia progresie IgA nefropatie';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <li><a href="calculator_egfr.php">eGFR CKD-EPI</a></li>
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
                <h2>IgAN Prediction Tool</h2>
                <p class="auth-subtitle">Odhad 5-ročného rizika poklesu eGFR o ≥&thinsp;50&thinsp;% alebo ESKD pri IgA nefropatii (Barbour et al. 2019, klinický model).</p>

                <div class="alert" style="background:rgba(245,158,11,0.08);border-left:4px solid #f59e0b;padding:12px 16px;border-radius:6px;margin-bottom:16px;font-size:0.88rem;">
                    <strong>⚠ Klinický model bez histológie.</strong> Pre presnejšie výsledky vrátane Oxford MEST-C skóre použite
                    <a href="https://qxcalc.app.link/igarisk" target="_blank" rel="noopener noreferrer">QxMD IgAN Tool</a> alebo
                    <a href="https://www.mdcalc.com/search?q=IgA+Nephropathy" target="_blank" rel="noopener noreferrer">MDCalc IgAN Tool</a>.
                </div>

                <details open class="calc-formula-box">
                    <summary>Vzorec — IgAN Prediction Tool (Barbour 2019, klinický model)</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">LP = &minus;0.02663·(eGFR&minus;66) + 0.55198·(prot&minus;1.7) + 0.00678·(MAP&minus;96) &minus; 0.23079·(RASB&minus;0.65) &minus; 0.63861·(IS&minus;0.21)

Riziko (5 r.) = 1 &minus; 0.972<sup>exp(LP)</sup> &times; 100&thinsp;%</code>
                        <div class="calc-formula-vars">
                            prot = proteinúria (g/deň) &ensp;&bull;&ensp; MAP = stredný arteriálny tlak (mmHg) &ensp;&bull;&ensp;
                            RASB = blokáda RAAS (0/1) &ensp;&bull;&ensp; IS = imunosupresia (0/1) &ensp;&bull;&ensp;
                            Zdroj: Barbour SJ et al. <em>JAMA Intern Med.</em> 2019;179(7):942–952.
                        </div>
                    </div>
                </details>

                <div class="alert" style="background:rgba(16,185,129,0.07);border-left:4px solid #10b981;padding:12px 16px;border-radius:6px;margin-bottom:16px;font-size:0.88rem;">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://qxcalc.app.link/igarisk" target="_blank" rel="noopener noreferrer">QxMD IgAN (plný model)</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/search?q=IgA+Nephropathy" target="_blank" rel="noopener noreferrer">MDCalc IgAN Tool</a> &ensp;&bull;&ensp;
                    <a href="https://kidneyfailurerisk.com/" target="_blank" rel="noopener noreferrer">kidneyfailurerisk.com (KFRE)</a>
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

                <?php if ($calculated !== null): ?>
                <div class="calc-result-box" role="region" aria-label="Výsledok kalkulácie">
                    <h3>Výsledok — IgAN Prediction Tool</h3>
                    <div class="calc-result-grid">
                        <div class="calc-result-item calc-result-item--highlight">
                            <span class="calc-result-label">5-ročné riziko progresie</span>
                            <span class="calc-result-value"><?= number_format($calculated['risk5yr'], 1, ',', ' ') ?>&thinsp;%</span>
                        </div>
                    </div>
                    <?php foreach ($calculated['interpretation'] as $line): ?>
                        <p class="calc-result-note"><?= htmlspecialchars($line) ?></p>
                    <?php endforeach; ?>
                    <?php foreach ($calculated['warnings'] as $w): ?>
                        <p class="calc-result-warning">⚠ <?= htmlspecialchars($w) ?></p>
                    <?php endforeach; ?>
                    <p class="calc-result-note" style="margin-top:8px;font-size:0.82rem;opacity:0.75;">
                        Vstupy: eGFR&nbsp;<?= number_format($calculated['egfr'],1,',','&thinsp;') ?>&thinsp;mL/min/1,73&thinsp;m² &bull;
                        Proteinúria&nbsp;<?= number_format($calculated['uprot_g_day'],2,',','&thinsp;') ?>&thinsp;g/deň &bull;
                        MAP&nbsp;<?= number_format($calculated['map_mmhg'],0,',','&thinsp;') ?>&thinsp;mmHg &bull;
                        RASB:&nbsp;<?= $calculated['rasb'] ? 'áno' : 'nie' ?> &bull;
                        IS:&nbsp;<?= $calculated['immuno'] ? 'áno' : 'nie' ?>
                    </p>
                </div>
                <?php endif; ?>

                <form method="POST" action="calculator_igan.php" novalidate>
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
                                <label for="igan_egfr">eGFR (mL/min/1,73&thinsp;m²) <span class="required">*</span></label>
                                <input type="number" id="igan_egfr" name="egfr" min="1" max="150" step="0.1" required class="form-control"
                                    placeholder="napr. 45" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="igan_uprot">Proteinúria (g/deň) <span class="required">*</span></label>
                                <input type="number" id="igan_uprot" name="uprot_g_day" min="0.01" max="30" step="0.01" required class="form-control"
                                    placeholder="napr. 1.5" value="<?= htmlspecialchars($form['uprot_g_day']) ?>">
                                <small class="form-hint">24-hodinová alebo z uPCR (g/g ≈ g/deň pri diuréze 1 L)</small>
                            </div>
                            <div class="form-group">
                                <label for="igan_map">MAP (mmHg) <span class="required">*</span></label>
                                <input type="number" id="igan_map" name="map_mmhg" min="50" max="200" step="1" required class="form-control"
                                    placeholder="napr. 96" value="<?= htmlspecialchars($form['map_mmhg']) ?>">
                                <small class="form-hint">MAP = (SBP + 2×DBP) / 3</small>
                            </div>
                            <div class="form-group">
                                <label for="igan_rasb">Blokáda RAAS (ACE-inhibítor / ARB) <span class="required">*</span></label>
                                <select id="igan_rasb" name="rasb" class="form-control">
                                    <option value="0" <?= $form['rasb'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['rasb'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="igan_immuno">Imunosupresívna liečba <span class="required">*</span></label>
                                <select id="igan_immuno" name="immuno" class="form-control">
                                    <option value="0" <?= $form['immuno'] === '0' ? 'selected' : '' ?>>Nie</option>
                                    <option value="1" <?= $form['immuno'] === '1' ? 'selected' : '' ?>>Áno</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" id="igan_submit">Vypočítať riziko</button>
                        <a href="calculator_igan.php" class="btn-secondary">Vymazať formulár</a>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </form>

                <?php if (!empty($savedResults)): ?>
            <?php include 'calculator_disclaimer.php'; ?>
                <section class="calc-saved-results" aria-labelledby="saved-results-heading">
                    <h3 id="saved-results-heading">Uložené výsledky</h3>
                    <div class="calc-saved-list">
                        <?php foreach ($savedResults as $row): ?>
                        <details class="calc-saved-item">
                            <summary>
                                <?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?> —
                                <?= number_format((float)($row['result_payload']['risk5yr'] ?? 0), 1, ',', ' ') ?>&thinsp;%
                                <span class="calc-saved-date">(<?= htmlspecialchars(substr((string)($row['created_at'] ?? ''), 0, 10)) ?>)</span>
                            </summary>
                            <div class="calc-saved-detail">
                                <p>5-ročné riziko: <strong><?= number_format((float)($row['result_payload']['risk5yr'] ?? 0), 1, ',', ' ') ?>&thinsp;%</strong></p>
                                <p>eGFR: <?= htmlspecialchars((string)($row['input_payload']['egfr'] ?? '—')) ?> &bull;
                                   Prot.: <?= htmlspecialchars((string)($row['input_payload']['uprot_g_day'] ?? '—')) ?> g/d &bull;
                                   MAP: <?= htmlspecialchars((string)($row['input_payload']['map_mmhg'] ?? '—')) ?> mmHg</p>
                                <form method="POST" action="calculator_igan.php" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                                    <input type="hidden" name="delete_id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="btn-danger btn-sm">Vymazať</button>
                                </form>
                            </div>
                        </details>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
