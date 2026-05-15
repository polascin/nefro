<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

requireLogin();

$resultId   = (int) ($_GET['result_id'] ?? 0);
$resultRow  = null;
$errorMessage = null;

if ($resultId <= 0) {
    $errorMessage = 'Neplatné ID výsledku.';
} else {
    try {
        $resultRow = calculatorFetchSavedResultById($pdo, $resultId, (int) $_SESSION['user_id']);
        if ($resultRow === null) {
            $errorMessage = 'Výsledok nebol nájdený alebo nemáte oprávnenie na jeho zobrazenie.';
        }
    } catch (\PDOException $e) {
        $errorMessage = 'Databázová chyba pri načítaní výsledku.';
        error_log('calculator_result_print error: ' . $e->getMessage());
    }
}

$inputPayload  = is_array($resultRow['input_payload']  ?? null) ? $resultRow['input_payload']  : [];
$resultPayload = is_array($resultRow['result_payload'] ?? null) ? $resultRow['result_payload'] : [];

// Zostaví čitateľný štítok kľúča vstupného poľa
function formatInputKey(string $key): string {
    $map = [
        'sex'                 => 'Pohlavie',
        'age_years'           => 'Vek (roky)',
        'creatinine_value'    => 'Kreatinín',
        'creatinine_unit'     => 'Jednotka kreatinínu',
        'creatinine_mg_dl'    => 'Kreatinín (mg/dL)',
        'weight_kg'           => 'Hmotnosť (kg)',
        'height_cm'           => 'Výška (cm)',
        'urine_creatinine'    => 'Kreatinín v moči',
        'urine_albumin'       => 'Albumín v moči',
        'uacr_value'          => 'UACR',
        'uacr_unit'           => 'Jednotka UACR',
        'dialysis_time_h'     => 'Čas dialýzy (h)',
        'urea_pre'            => 'Urea pred dialýzou',
        'urea_post'           => 'Urea po dialýze',
        'bicarbonate'         => 'Bikarbonát',
        'ph'                  => 'pH',
        'pco2'                => 'pCO₂',
        'sodium'              => 'Sodík (Na)',
        'chloride'            => 'Chlór (Cl)',
        'potassium'           => 'Draslík (K)',
        'calcium_total'       => 'Celkový vápnik',
        'albumin_gdl'         => 'Albumín (g/dL)',
        'phosphate'           => 'Fosfát',
        'stage'               => 'Štádium',
        'mutation_type'       => 'Typ mutácie',
        'age_at_diagnosis'    => 'Vek pri diagnóze',
        'kidney_length_cm'    => 'Dĺžka obličky (cm)',
    ];
    return $map[$key] ?? ucfirst(str_replace('_', ' ', $key));
}

// Zostaví čitateľný štítok kľúča výsledkového poľa
function formatResultKey(string $key): string {
    $map = [
        'egfr'            => 'eGFR (ml/min/1,73 m²)',
        'g_category'      => 'Kategória G',
        'g_description'   => 'Popis kategórie',
        'a_category'      => 'Kategória A (UACR)',
        'ktv'             => 'Kt/V',
        'creatinine_mg_dl'=> 'Kreatinín (mg/dL)',
        'cg_crcl'         => 'Klírens kreatinínu (CG)',
        'na_corrected'    => 'Korigovaný Na',
        'ca_corrected'    => 'Korigovaný vápnik',
        'result'          => 'Výsledok',
        'classification'  => 'Klasifikácia',
        'risk_category'   => 'Riziková kategória',
        'interpretation'  => 'Interpretácia',
        'slope'           => 'Sklon eGFR',
        'aki_stage'       => 'Štádium AKI',
    ];
    return $map[$key] ?? ucfirst(str_replace('_', ' ', $key));
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tlač výsledku – <?= htmlspecialchars((string) ($resultRow['calculator_label'] ?? 'Kalkulačka')) ?> – Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Header includovaný rovnako ako v kalkulačkách — aktivuje print-layout-table a user-print-header
    $headerTitle = htmlspecialchars((string) ($resultRow['calculator_label'] ?? 'Výsledok kalkulačky'));
    $headerIntro = 'Uložený výsledok klinickej kalkulačky';
    $showLogo    = false;
    include 'header.php';
    // $currentUser je teraz nastavený cez header_profile.php (includovaný z header.php)
    ?>

    <main class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">

                <?php if ($errorMessage !== null): ?>
                    <div class="alert alert-error"><p><?= htmlspecialchars($errorMessage) ?></p></div>
                    <p><a href="calculators.php" class="btn-primary">Späť na kalkulačky</a></p>
                <?php else: ?>

                    <h2><?= htmlspecialchars((string) ($resultRow['calculator_label'] ?? 'Výsledok')) ?></h2>
                    <p class="auth-subtitle">Uložený klinický výsledok · Dátum uloženia: <strong><?= htmlspecialchars((string) ($resultRow['created_at'] ?? '')) ?></strong></p>

                    <!-- Identifikácia pacienta -->
                    <div class="admin-notice-print-user">
                        <h3>Identifikácia pacienta</h3>
                        <div class="admin-notice-print-row">
                            <strong>Pacient</strong>
                            <span><?= htmlspecialchars(calculatorBuildPatientDisplay($resultRow)) ?></span>
                        </div>
                        <?php if (!empty($resultRow['patient_birth_date'])): ?>
                        <div class="admin-notice-print-row">
                            <strong>Dátum narodenia</strong>
                            <span><?= htmlspecialchars((string) $resultRow['patient_birth_date']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($resultRow['patient_birth_number'])): ?>
                        <div class="admin-notice-print-row">
                            <strong>Rodné číslo</strong>
                            <span><?= htmlspecialchars((string) $resultRow['patient_birth_number']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($resultRow['patient_insurance_code'])): ?>
                        <div class="admin-notice-print-row">
                            <strong>Kód zdravotnej poisťovne</strong>
                            <span><?= htmlspecialchars((string) $resultRow['patient_insurance_code']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Vstupné hodnoty kalkulačky -->
                    <div class="admin-notice-print-user">
                        <h3>Vstupné hodnoty</h3>
                        <?php if (empty($inputPayload)): ?>
                            <p>Vstupné údaje nie sú dostupné.</p>
                        <?php else: ?>
                            <?php foreach ($inputPayload as $key => $value): ?>
                                <div class="admin-notice-print-row">
                                    <strong><?= htmlspecialchars(formatInputKey((string) $key)) ?></strong>
                                    <span><?= htmlspecialchars(is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Výsledky kalkulačky -->
                    <div class="admin-notice-print-user">
                        <h3>Výsledok výpočtu</h3>
                        <?php if (empty($resultPayload)): ?>
                            <p>Výsledok nie je dostupný.</p>
                        <?php else: ?>
                            <?php foreach ($resultPayload as $key => $value): ?>
                                <div class="admin-notice-print-row">
                                    <strong><?= htmlspecialchars(formatResultKey((string) $key)) ?></strong>
                                    <span><?= htmlspecialchars(is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions no-print" style="margin-top: 24px;">
                        <button type="button" class="btn-primary" onclick="window.print()">🖨 Tlačiť</button>
                        <a href="javascript:window.close()" class="btn-secondary">Zatvoriť okno</a>
                        <a href="calculators.php" class="btn-secondary">Kalkulačky</a>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // Automatická tlač iba ak nedošlo k chybe
        if (document.querySelector('.alert-error') === null) {
            window.addEventListener('load', function () {
                window.print();
            });
        }
    </script>
</body>
</html>
