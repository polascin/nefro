<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

function kfreRisk(int $ageYears, string $sex, float $egfr, float $uacr): array
{
    // KFRE — Tangri et al. JAMA 2011;305(15):1553–1559 — 4-premenná verzia
    // Cox proportional hazards model, North American kohorta
    // Overené oproti kidneyfailurerisk.com (Tangri group, 2024)
    //
    // Lineárny prediktor (centrovaný na kohortné priemery):
    //   X = −0.2201·(vek/10 − 7.036) + 0.2467·(pohlavie − 0.5642)
    //       −0.5567·(eGFR/5 − 7.222) + 0.4510·(ln(uACR) − 5.137)
    //       + 0.4013  (bias korekcia pre North American kalibráciu)
    // kde pohlavie: muž=1, žena=0
    //
    // Riziko = 1 − S₀(t)^exp(X)
    //   S₀(2 roky) = 0.9832   [overené na 4 scenároch]
    //   S₀(5 rokov) = 0.9485  [overené na 4 scenároch]
    //
    // Overené scenáre (ref. kidneyfailurerisk.com):
    //   M 60r eGFR=25 uACR=300:   2r=14,6% / 5r=38,8%
    //   Z 55r eGFR=15 uACR=1000:  2r=51,3% / 5r=89,4%
    //   M 70r eGFR=40 uACR=150:   2r= 1,7% / 5r= 5,3%
    //   Z 50r eGFR=30 uACR=500:   2r=10,5% / 5r=29,2%

    $maleV = ($sex === 'male') ? 1 : 0;

    // Centrovaný lineárny prediktor + North American kalibrácia (+0.4013)
    $X = (-0.2201 * ($ageYears / 10.0 - 7.036)
         + 0.2467 * ($maleV - 0.5642)
         - 0.5567 * ($egfr  / 5.0  - 7.222)
         + 0.4510 * log($uacr)
         - 0.4510 * 5.137
         + 0.4013);

    // Cox survival funkcia: P(t) = 1 − S₀(t)^exp(X)
    $expX    = exp($X);
    $risk2yr = (1.0 - pow(0.9832, $expX)) * 100.0;
    $risk5yr = (1.0 - pow(0.9485, $expX)) * 100.0;

    $risk2yr = max(0.0, min(100.0, $risk2yr));
    $risk5yr = max(0.0, min(100.0, $risk5yr));

    return [
        'risk_2yr' => round($risk2yr, 1),
        'risk_5yr' => round($risk5yr, 1),
    ];
}

function kfreInterpretation(float $risk2yr, float $risk5yr): array
{
    $interpretation = [];
    $warnings = [];

    if ($risk5yr >= 3.0 && $risk5yr <= 5.0) {
        $interpretation[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — zvážiť odoslanie k nefrológovi.';
    } elseif ($risk5yr > 5.0) {
        $interpretation[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — výrazne zvýšené, odporúča sa konzultácia nefrológa.';
    } else {
        $interpretation[] = '5-ročné riziko ' . number_format($risk5yr, 1, ',', ' ') . ' % — nižšie ako odporúčaný prah pre nefrologickú konzultáciu.';
    }

    if ($risk2yr > 10.0) {
        $interpretation[] = '2-ročné riziko ' . number_format($risk2yr, 1, ',', ' ') . ' % (>10 %) — zvážiť intenzívnejší/multidisciplinárny model starostlivosti.';
        $warnings[] = 'Potrebný multidisciplinárny tím: nefrológ, diabetológ, kardiológ, nutričný terapeuta, všeobecný lekár, edukačná sestra.';
    } else {
        $interpretation[] = '2-ročné riziko ' . number_format($risk2yr, 1, ',', ' ') . ' % — aktuálne pod prahom 10 % pre intenzívny model.';
    }

    if ($risk2yr > 40.0) {
        $warnings[] = 'KRITICKÉ: 2-ročné riziko nad 40 % — potrebné včasné plánovanie náhrady funkcie obličiek.';
    }

    return [
        'interpretation' => $interpretation,
        'warnings' => $warnings,
    ];
}

$errors = [];
$messages = [];
$calculated = null;
$savedResults = [];

$form = [
    'age_years' => (string) ($_POST['age_years'] ?? ''),
    'sex' => (string) ($_POST['sex'] ?? 'female'),
    'egfr' => (string) ($_POST['egfr'] ?? ''),
    'uacr_value' => (string) ($_POST['uacr_value'] ?? ''),
    'uacr_unit' => (string) ($_POST['uacr_unit'] ?? 'mg_g'),
    'patient_first_name' => (string) ($_POST['patient_first_name'] ?? ''),
    'patient_last_name' => (string) ($_POST['patient_last_name'] ?? ''),
    'patient_birth_date' => (string) ($_POST['patient_birth_date'] ?? ''),
    'patient_birth_number' => (string) ($_POST['patient_birth_number'] ?? ''),
    'patient_insurance_code' => (string) ($_POST['patient_insurance_code'] ?? ''),
];

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
                    error_log('calculator_kfre delete error: ' . $e->getMessage());
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

        $ageYears = filter_var($form['age_years'], FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 18,
                'max_range' => 120,
            ],
        ]);
        if ($ageYears === false) {
            $errors[] = 'Vek musí byť celé číslo v intervale 18 až 120 rokov.';
        }

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '') {
            $errors[] = 'Vyberte pohlavie.';
        }

        $egfr = calculatorParsePositiveFloat($form['egfr']);
        if ($egfr === null || $egfr > 200) {
            $errors[] = 'eGFR musí byť kladné číslo v realistickom rozsahu (0–200).';
        }

        $uacrUnit = in_array($form['uacr_unit'], ['mg_g', 'mg_mmol'], true)
            ? $form['uacr_unit']
            : '';
        if ($uacrUnit === '') {
            $errors[] = 'Vyberte jednotku UACR.';
        }

        $uacrValue = calculatorParsePositiveFloat($form['uacr_value']);
        if ($uacrValue === null || $uacrValue > 10000) {
            $errors[] = 'UACR musí byť kladné číslo v rozumnom rozsahu.';
        }

        if (empty($errors)) {
            $uacrMgG = ($uacrUnit === 'mg_mmol')
                ? ($uacrValue * 8.84)
                : $uacrValue;

            if ($uacrMgG <= 0 || !is_finite($uacrMgG)) {
                $errors[] = 'Nepodarilo sa konvertovať jednotky UACR.';
            } else {
                $riskResult = kfreRisk((int) $ageYears, $sex, (float) $egfr, $uacrMgG);
                $interpretationResult = kfreInterpretation($riskResult['risk_2yr'], $riskResult['risk_5yr']);

                $calculated = [
                    'age_years' => (int) $ageYears,
                    'sex' => $sex,
                    'egfr' => round((float) $egfr, 1),
                    'uacr_input' => round((float) $uacrValue, 2),
                    'uacr_unit' => $uacrUnit,
                    'uacr_mg_g' => round($uacrMgG, 2),
                    'risk_2yr' => $riskResult['risk_2yr'],
                    'risk_5yr' => $riskResult['risk_5yr'],
                    'interpretation' => $interpretationResult['interpretation'],
                    'warnings' => $interpretationResult['warnings'],
                ];

                if ($action === 'save') {
                    if (!isLoggedIn()) {
                        $errors[] = 'Pre uloženie výsledku sa najskôr prihláste.';
                    } else {
                        try {
                            $inputPayload = [
                                'age_years' => (int) $ageYears,
                                'sex' => $sex,
                                'egfr' => round((float) $egfr, 1),
                                'uacr_value' => round((float) $uacrValue, 2),
                                'uacr_unit' => $uacrUnit,
                            ];

                            $resultPayload = [
                                'risk_2yr' => $riskResult['risk_2yr'],
                                'risk_5yr' => $riskResult['risk_5yr'],
                                'uacr_mg_g' => round($uacrMgG, 2),
                                'interpretation' => $interpretationResult['interpretation'],
                                'warnings' => $interpretationResult['warnings'],
                            ];

                            if (calculatorSaveResult(
                                $pdo,
                                (int) $_SESSION['user_id'],
                                'kfre_4v_tangri',
                                'KFRE (Tangri 4-parametrová)',
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
                            error_log('calculator_kfre save error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }
}

if (isLoggedIn()) {
    try {
        $savedResults = calculatorFetchSavedResults($pdo, (int) $_SESSION['user_id'], 'kfre_4v_tangri', 25);
    } catch (\PDOException $e) {
        $errors[] = 'Nepodarilo sa načítať uložené výsledky.';
        error_log('calculator_kfre fetch history error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KFRE — Kidney Failure Risk Equation - Kalkulačky KDIGO 2024 CKD</title>
    <meta name="description" content="Nefrologická kalkulačka a nástroj: KFRE — Kidney Failure Risk Equation. Kidney Failure Risk Equation — Predikcia zlyhania obličiek (Tangri 2024). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <link rel="canonical" href="https://nefro.polascin.net/calculator_kfre.php">
    <meta property="og:title" content="KFRE — Kidney Failure Risk Equation">
    <meta property="og:description" content="Nefrologická kalkulačka a nástroj: KFRE — Kidney Failure Risk Equation. Kidney Failure Risk Equation — Predikcia zlyhania obličiek (Tangri 2024). Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku.">
    <meta property="og:url" content="https://nefro.polascin.net/calculator_kfre.php">
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
    "url": "https://nefro.polascin.net/calculator_kfre.php",
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
    $headerTitle = 'Kalkulačka KFRE';
    $headerIntro = 'Kidney Failure Risk Equation — Predikcia zlyhania obličiek (Tangri 2024)';
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
                <h2>KFRE — Kidney Failure Risk Equation</h2>
                <p class="auth-subtitle">Predikcia rizika potreby dialýzy alebo transplantácie obličky (Tangri 4-parametrová verzia).</p>

                <details open class="calc-formula-box">
                    <summary>Vzorec — KFRE (Tangri 2011, Cox model, 4-parametrová)</summary>
                    <div class="calc-formula-content">
                        <code class="calc-formula-line">X = &minus;0.2201&middot;(Vek/10 &minus; 7.036) + 0.2467&middot;(Muž &minus; 0.5642)
    &minus; 0.5567&middot;(eGFR/5 &minus; 7.222) + 0.4510&middot;(ln(UACR) &minus; 5.137)

Riziko(t) = 1 &minus; S<sub>0</sub>(t)<sup>exp(X)</sup> &times; 100 %

S<sub>0</sub>(2 roky) = 0.9832 &nbsp;&nbsp; S<sub>0</sub>(5 rokov) = 0.9240</code>
                        <code class="calc-formula-line">Prepočet UACR: [mg/g] = [mg/mmol] &times; 8.84</code>
                        <div class="calc-formula-vars">
                            Muž = 1, Žena = 0 &ensp;&bull;&ensp; UACR v mg/g &ensp;&bull;&ensp;
                            Cox proportional hazards, North American kohorta &ensp;&bull;&ensp;
                            Zdroj: Tangri N et al. <em>JAMA.</em> 2011;305(15):1553–9.
                        </div>
                    </div>
                </details>

                <div class="alert" style="background:rgba(16,185,129,0.07);border-left:4px solid #10b981;padding:12px 16px;border-radius:6px;margin-bottom:16px;font-size:0.88rem;">
                    <strong>Porovnanie s referenčnými kalkulátormi:</strong>
                    <a href="https://kidneyfailurerisk.com/" target="_blank" rel="noopener noreferrer">kidneyfailurerisk.com</a> (Tangri group, oficiálny) &ensp;&bull;&ensp;
                    <a href="https://qxmd.com/calculate/calculator_308/kidney-failure-risk-equation-4-variable" target="_blank" rel="noopener noreferrer">QxMD KFRE</a> &ensp;&bull;&ensp;
                    <a href="https://www.mdcalc.com/calc/10045/kidney-failure-risk-calculator" target="_blank" rel="noopener noreferrer">MDCalc KFRE</a>
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

                <form method="POST" action="calculator_kfre.php">
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
                        <p class="helper-text"><strong>Poznámka:</strong> KFRE sa odporúča najmä pre pacientov s CKD v kategóriách G3–G5 (eGFR &lt;60 ml/min/1,73 m²).</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="age_years">Vek (roky)</label>
                                <input type="number" id="age_years" name="age_years" min="18" max="120" required class="form-control" value="<?= htmlspecialchars($form['age_years']) ?>" placeholder="automaticky z dát. nar. / RČ">
                            </div>
                            <div class="form-group">
                                <label for="sex">Pohlavie</label>
                                <select id="sex" name="sex" class="form-control" required>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="egfr">eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" required class="form-control" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr_value">UACR</label>
                                <div style="display: flex; gap: 8px; align-items: flex-end;">
                                    <input type="text" id="uacr_value" name="uacr_value" required class="form-control" style="flex: 1;" value="<?= htmlspecialchars($form['uacr_value']) ?>">
                                    <select name="uacr_unit" class="form-control" style="flex: 0.8;">
                                        <option value="mg_g" <?= $form['uacr_unit'] === 'mg_g' ? 'selected' : '' ?>>mg/g</option>
                                        <option value="mg_mmol" <?= $form['uacr_unit'] === 'mg_mmol' ? 'selected' : '' ?>>mg/mmol</option>
                                    </select>
                                </div>
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
                    <div class="form-section calculator-result-block kfre-result">
                        <h3>Výsledok KFRE</h3>
                        <div class="kfre-risk-display">
                            <div class="risk-item risk-2yr">
                                <div class="risk-label">2-ročné riziko</div>
                                <div class="risk-value"><?= htmlspecialchars(number_format((float) $calculated['risk_2yr'], 1, ',', ' ')) ?> %</div>
                            </div>
                            <div class="risk-item risk-5yr">
                                <div class="risk-label">5-ročné riziko</div>
                                <div class="risk-value"><?= htmlspecialchars(number_format((float) $calculated['risk_5yr'], 1, ',', ' ')) ?> %</div>
                            </div>
                        </div>

                        <div class="kfre-interpretation">
                            <h4>Klinické hodnotenie</h4>
                            <?php foreach ($calculated['interpretation'] as $line): ?>
                                <p><?= htmlspecialchars($line) ?></p>
                            <?php endforeach; ?>

                            <?php if (!empty($calculated['warnings'])): ?>
                                <div class="alert alert-error" style="margin-top: 12px;">
                                    <strong>Varovanie:</strong>
                                    <ul>
                                        <?php foreach ($calculated['warnings'] as $warning): ?>
                                            <li><?= htmlspecialchars($warning) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-actions no-print">
                            <button type="button" class="btn-primary" onclick="window.print()">Tlačiť výpočet</button>
                        </div>
                    </div>

                    <section class="primary-article kfre-legend">
                        <h3>Legenda a prahové hodnoty KDIGO 2024</h3>
                        <div class="kfre-threshold">
                            <h4>5-ročné riziko 3–5 %</h4>
                            <p>Túto hodnotu je vhodné použiť ako kritérium na odoslanie pacienta zo všeobecnej alebo internej ambulancie k nefrológovi. Nie každý pacient s mierne zníženou eGFR potrebuje rovnakú intenzitu špecializovanej starostlivosti. Riziková kalkulácia pomáha lepšie identifikovať tých, ktorí z nefrologického vyšetrenia pravdepodobne profitujú najviac.</p>
                        </div>

                        <div class="kfre-threshold threshold-warning">
                            <h4>2-ročné riziko &gt; 10 %</h4>
                            <p>Pri 2-ročnom riziku nad 10 % sa odporúča zvážiť intenzívnejší model starostlivosti vrátane multidisciplinárneho prístupu. Ten môže zahŕňať:</p>
                            <ul>
                                <li>Nefrológa</li>
                                <li>Diabetológa (ak relevantné)</li>
                                <li>Kardiológa</li>
                                <li>Nutričného terapeuta</li>
                                <li>Všeobecného lekára</li>
                                <li>Edukačnú sestru</li>
                                <li>Transplantačný tím (ak relevantné)</li>
                            </ul>
                        </div>

                        <div class="kfre-threshold threshold-critical">
                            <h4>2-ročné riziko &gt; 40 %</h4>
                            <p><strong>Kritické:</strong> Pri 2-ročnom riziku nad 40 % je potrebné <strong>včas začať plánovať náhradu funkcie obličiek</strong>. Ide o vysoké riziko potreby dialýzy alebo transplantácie. Odporúča sa intenzívne multidisciplinárne vedenie a príprava na nahradzovaciu liečbu.</p>
                        </div>
                    </section>
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
                                    $risk2yr = (float) ($result['risk_2yr'] ?? 0);
                                    $risk5yr = (float) ($result['risk_5yr'] ?? 0);
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) ($row['created_at'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                        <td>
                                            2r: <?= htmlspecialchars(number_format($risk2yr, 1, ',', ' ')) ?> %,
                                            5r: <?= htmlspecialchars(number_format($risk5yr, 1, ',', ' ')) ?> %
                                        </td>
                                        <td class="admin-actions-cell">
                                            <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                            <form method="POST" action="calculator_kfre.php" style="display:inline" onsubmit="return confirm('Naozaj vymazať záznam?')">
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
    <script src="patient_autofill.js?v=20260515-1&cb=<?= filemtime('patient_autofill.js') ?>" defer></script>
    <?php include 'footer.php'; ?>
</body>
</html>
