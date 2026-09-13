<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/calculators_common.php';
require_once __DIR__ . '/ckd_risk_models.php';
require_once __DIR__ . '/calculator_ambulatory_logic.php';
require_once __DIR__ . '/mkch10_codebook.php';

$baseUrl = 'https://nefro.polascin.net/';
$errors = [];
$plainTextOutput = null;
$skippedOutput = [];

$checkboxFields = [
    'other_kidney_marker',
    'antihtn',
    'hf',
    'chd',
    'afib',
    'diabetes',
    'insulin',
    'oral_dm',
    'asian_ancestry',
    'increased_waist',
    'prediabetes',
    'hypertension',
    'hypertriglyceridemia',
    'metabolic_syndrome',
    'subclinical_cvd',
    'other_clinical_cvd',
];

$form = [
    'examination_date' => (string) ($_POST['examination_date'] ?? date('Y-m-d')),
    'cause_diagnoses' => ambulatoryPostedCodeList($_POST['cause_diagnoses'] ?? ''),
    'cause_note' => (string) ($_POST['cause_note'] ?? ''),
    'birth_input' => (string) ($_POST['birth_input'] ?? ''),
    'sex' => (string) ($_POST['sex'] ?? ''),
    'egfr' => (string) ($_POST['egfr'] ?? ''),
    'uacr_value' => (string) ($_POST['uacr_value'] ?? ''),
    'uacr_unit' => (string) ($_POST['uacr_unit'] ?? 'mg_mmol'),
    'chronicity' => (string) ($_POST['chronicity'] ?? 'confirmed'),
    'repeat_date' => (string) ($_POST['repeat_date'] ?? date('Y-m-d', strtotime('+3 months'))),
    'related_diagnoses' => ambulatoryPostedCodeList($_POST['related_diagnoses'] ?? ''),
    'sbp' => (string) ($_POST['sbp'] ?? ''),
    'bmi' => (string) ($_POST['bmi'] ?? ''),
    'smoking' => (string) ($_POST['smoking'] ?? ''),
    'hba1c' => (string) ($_POST['hba1c'] ?? ''),
];

for ($index = 1; $index <= 3; $index++) {
    $form['slope_date_' . $index] = (string) ($_POST['slope_date_' . $index] ?? '');
    $form['slope_egfr_' . $index] = (string) ($_POST['slope_egfr_' . $index] ?? '');
}

foreach ($checkboxFields as $field) {
    $form[$field] = isset($_POST[$field]) ? '1' : '';
}

$complicationLabels = [
    'anemia' => 'anémia',
    'mbd' => 'MBD',
    'acidosis' => 'metabolická acidóza',
    'hyperkalemia' => 'hyperkaliémia',
    'hypervolemia' => 'hypervolémia',
];
$selectedComplications = [];
$postedComplications = $_POST['complications'] ?? [];
if (is_array($postedComplications)) {
    foreach ($postedComplications as $complication) {
        if (is_string($complication) && isset($complicationLabels[$complication])) {
            $selectedComplications[] = $complication;
        }
    }
}
$selectedComplications = array_values(array_unique($selectedComplications));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } else {
        $causeDiagnosisCodes = mkch10NormalizeCodeList($form['cause_diagnoses']);
        $form['cause_diagnoses'] = implode(', ', $causeDiagnosisCodes);
        $causeNoteRaw = $form['cause_note'];
        $causeNote = ambulatoryNormalizeSingleLine($causeNoteRaw, 200);
        $form['cause_note'] = $causeNote;
        $cause = ambulatoryFormatCause($causeDiagnosisCodes, $causeNote);
        if (mb_strlen($causeNoteRaw, 'UTF-8') > 200) {
            $errors[] = 'Doplnenie príčiny CKD môže mať najviac 200 znakov.';
        }
        if (mb_strlen($form['cause_diagnoses'], 'UTF-8') > 300) {
            $errors[] = 'Kódy príčin CKD môžu mať najviac 300 znakov.';
        } elseif (count($causeDiagnosisCodes) > 8) {
            $errors[] = 'Vyberte najviac 8 diagnóz ako príčinu CKD.';
        }

        $relatedDiagnosisCodes = mkch10NormalizeCodeList($form['related_diagnoses']);
        $form['related_diagnoses'] = implode(', ', $relatedDiagnosisCodes);
        $relatedDiagnoses = $form['related_diagnoses'];
        if (mb_strlen($form['related_diagnoses'], 'UTF-8') > 300) {
            $errors[] = 'Pridružené diagnózy môžu mať najviac 300 znakov.';
        } elseif (count($relatedDiagnosisCodes) > 12) {
            $errors[] = 'Vyberte najviac 12 pridružených diagnóz.';
        }

        $codesToValidate = array_values(array_unique(array_merge(
            $causeDiagnosisCodes,
            $relatedDiagnosisCodes,
        )));
        if ($codesToValidate !== []) {
            try {
                $unknownDiagnosisCodes = mkch10FindUnknownCodes($codesToValidate);
                if ($unknownDiagnosisCodes !== []) {
                    $errors[] = 'Číselník MKCH-10-SK neobsahuje kódy: ' . implode(', ', $unknownDiagnosisCodes) . '.';
                }
            } catch (\RuntimeException | \JsonException $exception) {
                error_log('Ambulantná kalkulačka – MKCH-10: ' . $exception->getMessage());
                $errors[] = 'Číselník MKCH-10-SK sa nepodarilo overiť. Skúste to znova neskôr.';
            }
        }

        $examinationDate = null;
        if (trim($form['examination_date']) !== '') {
            $examinationDate = \DateTimeImmutable::createFromFormat('!Y-m-d', $form['examination_date']);
            if (
                !$examinationDate instanceof \DateTimeImmutable ||
                $examinationDate->format('Y-m-d') !== $form['examination_date']
            ) {
                $errors[] = 'Zadajte platný dátum vyšetrenia.';
                $examinationDate = null;
            } elseif ($examinationDate > new \DateTimeImmutable('today')) {
                $errors[] = 'Dátum vyšetrenia nemôže byť v budúcnosti.';
            }
        }

        $birthInput = ambulatoryNormalizeSingleLine($form['birth_input'], 16);
        $form['birth_input'] = $birthInput;
        $birthParts = $birthInput === '' ? null : ambulatoryParseBirthInput($birthInput);
        $ageYears = null;
        if ($birthInput !== '' && $birthParts === null) {
            $errors[] = 'Dátum narodenia je neplatný. Použite rok (1965), mesiac a rok (6/1965) alebo celý dátum (15.6.1965).';
        } elseif ($birthParts !== null && $examinationDate instanceof \DateTimeImmutable) {
            $ageYears = ambulatoryAgeAtExamination($birthParts, $examinationDate);
            if ($ageYears === null) {
                $errors[] = 'Dátum narodenia nemôže byť po dátume vyšetrenia.';
            } elseif ($ageYears < 18 || $ageYears > 120) {
                $errors[] = 'Vek k dátumu vyšetrenia musí byť v intervale 18 až 120 rokov.';
            }
        }

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : null;
        if ($form['sex'] !== '' && $sex === null) {
            $errors[] = 'Vyberte pohlavie použité v prognostických rovniciach.';
        }

        $egfr = null;
        if (trim($form['egfr']) !== '') {
            $egfr = calculatorParsePositiveFloat($form['egfr']);
            if ($egfr === null || $egfr > 200.0) {
                $errors[] = 'eGFR musí byť kladné číslo najviac 200 ml/min/1,73 m².';
                $egfr = null;
            }
        }

        $uacrUnit = in_array($form['uacr_unit'], ['mg_g', 'mg_mmol'], true)
            ? $form['uacr_unit']
            : null;
        if ($uacrUnit === null) {
            $errors[] = 'Vyberte jednotku uACR.';
        }

        $uacrValue = null;
        if (trim($form['uacr_value']) !== '') {
            $uacrValue = calculatorParsePositiveFloat($form['uacr_value']);
            if ($uacrValue === null || $uacrValue > 15000.0) {
                $errors[] = 'uACR musí byť kladné číslo v realistickom rozsahu.';
                $uacrValue = null;
            }
        }

        $chronicity = in_array($form['chronicity'], ['confirmed', 'unconfirmed'], true)
            ? $form['chronicity']
            : null;
        if ($chronicity === null) {
            $errors[] = 'Vyberte stav chronicity abnormalít.';
        }

        $repeatDate = null;
        if ($chronicity === 'unconfirmed' && trim($form['repeat_date']) !== '') {
            $repeatDate = \DateTimeImmutable::createFromFormat('!Y-m-d', $form['repeat_date']);
            if (
                !$repeatDate instanceof \DateTimeImmutable ||
                $repeatDate->format('Y-m-d') !== $form['repeat_date']
            ) {
                $errors[] = 'Dátum opakovanej kontroly je neplatný.';
                $repeatDate = null;
            } elseif (
                $examinationDate instanceof \DateTimeImmutable &&
                $repeatDate <= $examinationDate
            ) {
                $errors[] = 'Opakovaná kontrola musí byť naplánovaná po dátume vyšetrenia.';
            }
        }

        $sbp = null;
        if (trim($form['sbp']) !== '') {
            $sbp = calculatorParsePositiveFloat($form['sbp']);
            if ($sbp === null || $sbp < 70.0 || $sbp > 250.0) {
                $errors[] = 'Systolický TK musí byť v rozsahu 70 až 250 mmHg.';
                $sbp = null;
            }
        }

        $bmi = null;
        if (trim($form['bmi']) !== '') {
            $bmi = calculatorParsePositiveFloat($form['bmi']);
            if ($bmi === null || $bmi < 10.0 || $bmi > 80.0) {
                $errors[] = 'BMI musí byť v rozsahu 10 až 80 kg/m².';
                $bmi = null;
            }
        }

        $smoking = in_array($form['smoking'], ['never', 'former', 'current'], true)
            ? $form['smoking']
            : null;
        if ($form['smoking'] !== '' && $smoking === null) {
            $errors[] = 'Vyberte stav fajčenia.';
        }

        $diabetes = $form['diabetes'] === '1';
        $hba1c = null;
        if (trim($form['hba1c']) !== '') {
            $parsedHba1c = calculatorParsePositiveFloat($form['hba1c']);
            if ($parsedHba1c === null || $parsedHba1c < 4.0 || $parsedHba1c > 20.0) {
                $errors[] = 'HbA1c musí byť v rozsahu 4 až 20 %.';
            } else {
                $hba1c = $parsedHba1c;
            }
        }

        $slopePoints = [];
        if (
            $examinationDate instanceof \DateTimeImmutable &&
            $egfr !== null &&
            $egfr <= 200.0
        ) {
            $slopePoints[] = ['date' => $examinationDate, 'egfr' => (float) $egfr];
        }
        $slopeDates = $examinationDate instanceof \DateTimeImmutable
            ? [$examinationDate->format('Y-m-d') => true]
            : [];

        for ($index = 1; $index <= 3; $index++) {
            $dateValue = trim($form['slope_date_' . $index]);
            $egfrValue = trim($form['slope_egfr_' . $index]);
            if ($dateValue === '' && $egfrValue === '') {
                continue;
            }
            if ($dateValue === '' || $egfrValue === '') {
                $errors[] = 'Pri predchádzajúcom meraní ' . $index . ' vyplňte dátum aj eGFR.';
                continue;
            }

            $pointDate = \DateTimeImmutable::createFromFormat('!Y-m-d', $dateValue);
            $pointEgfr = calculatorParsePositiveFloat($egfrValue);
            if (
                !$pointDate instanceof \DateTimeImmutable ||
                $pointDate->format('Y-m-d') !== $dateValue
            ) {
                $errors[] = 'Predchádzajúce meranie ' . $index . ' má neplatný dátum.';
                continue;
            }
            if (
                $examinationDate instanceof \DateTimeImmutable &&
                $pointDate > $examinationDate
            ) {
                $errors[] = 'Predchádzajúce meranie ' . $index . ' nemôže byť po dátume vyšetrenia.';
            }
            if (isset($slopeDates[$dateValue])) {
                $errors[] = 'Každé meranie pre eGFR slope musí mať odlišný dátum.';
            }
            if ($pointEgfr === null || $pointEgfr > 200.0) {
                $errors[] = 'eGFR pri predchádzajúcom meraní ' . $index . ' musí byť v rozsahu 0 až 200.';
            }

            if (
                $pointEgfr !== null &&
                $pointEgfr <= 200.0 &&
                !isset($slopeDates[$dateValue])
            ) {
                $slopeDates[$dateValue] = true;
                $slopePoints[] = ['date' => $pointDate, 'egfr' => $pointEgfr];
            }
        }

        if (empty($errors)) {
            $complicationText = '';
            if ($selectedComplications !== []) {
                $labels = array_map(
                    static fn(string $key): string => $complicationLabels[$key],
                    $selectedComplications,
                );
                $complicationText = implode(', ', $labels);
            }

            $report = ambulatoryComputeReport([
                'cause' => $cause,
                'age_years' => $ageYears,
                'sex' => $sex,
                'egfr' => $egfr,
                'uacr_value' => $uacrValue,
                'uacr_unit' => $uacrValue !== null ? $uacrUnit : null,
                'chronicity' => $chronicity,
                'repeat_date' => $repeatDate,
                'other_kidney_marker' => $form['other_kidney_marker'] === '1',
                'related_diagnoses' => $relatedDiagnoses,
                'sbp' => $sbp,
                'bmi' => $bmi,
                'smoking' => $smoking,
                'diabetes' => $diabetes,
                'hba1c' => $hba1c,
                'antihtn' => $form['antihtn'] === '1',
                'hf' => $form['hf'] === '1',
                'chd' => $form['chd'] === '1',
                'afib' => $form['afib'] === '1',
                'insulin' => $form['insulin'] === '1',
                'oral_dm' => $form['oral_dm'] === '1',
                'asian_ancestry' => $form['asian_ancestry'] === '1',
                'increased_waist' => $form['increased_waist'] === '1',
                'prediabetes' => $form['prediabetes'] === '1',
                'hypertension' => $form['hypertension'] === '1',
                'hypertriglyceridemia' => $form['hypertriglyceridemia'] === '1',
                'metabolic_syndrome' => $form['metabolic_syndrome'] === '1',
                'subclinical_cvd' => $form['subclinical_cvd'] === '1',
                'other_clinical_cvd' => $form['other_clinical_cvd'] === '1',
                'slope_points' => $slopePoints,
                'complications' => $complicationText,
            ]);
            $plainTextOutput = ambulatoryBuildPlainText($report['summary']);
            $skippedOutput = $report['skipped'];
            if (trim($plainTextOutput) === '') {
                $errors[] = 'Zadajte aspoň jeden údaj, z ktorého možno zostaviť súhrn (napr. eGFR, uACR, príčinu CKD, BMI alebo komplikácie).';
                $plainTextOutput = null;
                $skippedOutput = [];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Ambulantná kalkulačka CKD | Nefro-projekt Slovensko';
  $canonicalUrl = 'https://nefro.polascin.net/calculator_ambulatory.php';
  $seoDescription = 'Ambulantná CKD kalkulačka pre lekárov: KDIGO 2024 CGA, KFRE, CKD-PC, štádium CKM, eGFR slope a kopírovateľný text do lekárskej správy. Počíta len z vyplnených údajov.';
  $structuredData = [[
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'Kalkulačky', 'item' => $baseUrl . 'calculators.php'],
          ['@type' => 'ListItem', 'position' => 3, 'name' => 'Ambulantná kalkulačka', 'item' => $canonicalUrl],
      ],
  ]];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Ambulantná kalkulačka';
    $headerIntro = 'Súhrn CKD pripravený na vloženie do lekárskej správy v Nefrise';
    $showLogo = false;
    include 'header.php';
    include 'main_nav.php';
    ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Ambulantná kalkulačka</h2>
                <p class="auth-subtitle">Z dostupných údajov zostaví KDIGO CGA klasifikáciu, prognostické riziká a čistý text na skopírovanie do ambulantnej správy. Vyplňte len to, čo máte — vypočíta sa iba to, na čo stačia zadané parametre.</p>

                <div class="info-box-blue">
                    Kalkulačka nevyžaduje identifikačné údaje pacienta a výsledok neukladá do databázy. Dátum alebo rok narodenia slúži len na výpočet veku k dátumu vyšetrenia a na serveri sa neukladá. Príčinu CKD, chronicitu, pridružené diagnózy a komplikácie potvrdzuje lekár; nástroj ich neurčuje zo samotných laboratórnych hodnôt. Chýbajúce vstupy sa vo výstupe vynechajú.
                </div>

                <?php if ($errors !== []): ?>
                    <div class="alert alert-error" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="calculator_ambulatory.php" id="ambulatory-calculator-form" autocomplete="off">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">

                    <section class="form-section" aria-labelledby="ambulatory-core-heading">
                        <h3 id="ambulatory-core-heading">Základné údaje a KDIGO CGA</h3>
                        <div class="form-group mkch10-picker" id="mkch10-cause-picker" data-source="assets/data/mkch10-sk.json" data-max-items="8" data-field-name="cause_diagnoses[]" data-selected="<?= htmlspecialchars($form['cause_diagnoses']) ?>" data-empty-status="Nie je vybraná žiadna príčina CKD." data-count-status="Vybrané príčiny CKD">
                            <label for="cause_diagnosis_search">Príčina CKD (Cause)</label>
                            <input type="search" id="cause_diagnosis_search" class="form-control" autocomplete="off" role="combobox" aria-autocomplete="list" aria-haspopup="listbox" aria-controls="cause_diagnosis_results" aria-expanded="false" aria-describedby="cause_diagnosis_help cause_diagnosis_status" placeholder="Začnite písať kód alebo názov diagnózy">
                            <div id="cause_diagnosis_results" class="mkch10-results" role="listbox" aria-label="Výsledky vyhľadávania príčin CKD" hidden></div>
                            <div id="cause_diagnosis_selected" class="mkch10-selected" aria-label="Vybrané príčiny CKD"></div>
                            <small id="cause_diagnosis_help">Vyhľadávajte podľa kódu alebo slovenského názvu. Možno vybrať viac diagnóz, najviac 8. Ak príčina nie je známa, do doplnenia napíšte „neurčená“. Bez príčiny sa tento riadok vo výstupe vynechá.</small>
                            <small id="cause_diagnosis_status" class="mkch10-status" role="status" aria-live="polite"></small>
                            <noscript>
                                <label for="cause_diagnoses_noscript">Kódy príčin CKD (MKCH-10-SK, oddelené čiarkou)</label>
                                <input type="text" id="cause_diagnoses_noscript" name="cause_diagnoses" maxlength="300" class="form-control" value="<?= htmlspecialchars($form['cause_diagnoses']) ?>" placeholder="napr. E11.21†, N08.3*">
                                <small>Bez JavaScriptu zadajte kódy ručne. Server overí ich prítomnosť v číselníku.</small>
                            </noscript>
                            <div class="form-group mkch10-note">
                                <label for="cause_note">Doplnenie vlastnými slovami</label>
                                <input type="text" id="cause_note" name="cause_note" maxlength="200" class="form-control" placeholder="napr. diabetická choroba obličiek; neurčená" value="<?= htmlspecialchars($form['cause_note']) ?>" aria-describedby="cause_note_help">
                                <small id="cause_note_help">Voliteľné. Ak kód nevyberiete, stačí vlastný text. Bez oboch sa príčina vo výstupe neobjaví.</small>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia</label>
                                <input type="date" id="examination_date" name="examination_date" class="form-control" max="<?= htmlspecialchars(date('Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="birth_input">Dátum alebo rok narodenia</label>
                                <input type="text" id="birth_input" name="birth_input" maxlength="16" class="form-control" autocomplete="off" placeholder="napr. 1965, 6/1965 alebo 15.6.1965" value="<?= htmlspecialchars($form['birth_input']) ?>" aria-describedby="birth_input_help birth_age_status">
                                <small id="birth_input_help">Vek sa dopočíta k dátumu vyšetrenia a použije sa v KFRE a CKD-PC. Stačí rok, mesiac a rok, alebo celý dátum. Pri neúplnom údaji sa chýbajúce časti berú ako 1. január, resp. 1. deň mesiaca.</small>
                                <small id="birth_age_status" class="ambulatory-age-status" role="status" aria-live="polite"></small>
                            </div>
                            <div class="form-group">
                                <label for="sex">Pohlavie použité v rovniciach</label>
                                <select id="sex" name="sex" class="form-control">
                                    <option value="" <?= $form['sex'] === '' ? 'selected' : '' ?>>Neuvedené</option>
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="egfr">Aktuálne eGFR (ml/min/1,73 m²)</label>
                                <input type="text" id="egfr" name="egfr" inputmode="decimal" class="form-control" placeholder="napr. 38,5" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr_value">Aktuálne uACR</label>
                                <div class="input-with-unit">
                                    <input type="text" id="uacr_value" name="uacr_value" inputmode="decimal" class="form-control" placeholder="napr. 12,4" value="<?= htmlspecialchars($form['uacr_value']) ?>">
                                    <select id="uacr_unit" name="uacr_unit" class="form-control flex-08" aria-label="Jednotka uACR">
                                        <option value="mg_mmol" <?= $form['uacr_unit'] === 'mg_mmol' ? 'selected' : '' ?>>mg/mmol</option>
                                        <option value="mg_g" <?= $form['uacr_unit'] === 'mg_g' ? 'selected' : '' ?>>mg/g</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="chronicity">Chronicita abnormalít <span class="required">*</span></label>
                                <select id="chronicity" name="chronicity" required class="form-control">
                                    <option value="confirmed" <?= $form['chronicity'] === 'confirmed' ? 'selected' : '' ?>>Potvrdená (≥ 3 mesiace)</option>
                                    <option value="unconfirmed" <?= $form['chronicity'] === 'unconfirmed' ? 'selected' : '' ?>>Nepotvrdená</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="repeat_date">Plánovaný dátum opakovanej kontroly</label>
                                <input type="date" id="repeat_date" name="repeat_date" class="form-control" value="<?= htmlspecialchars($form['repeat_date']) ?>">
                                <small>Použije sa iba pri nepotvrdenej chronicite.</small>
                            </div>
                        </div>
                        <label class="form-check">
                            <input type="checkbox" name="other_kidney_marker" value="1" <?= $form['other_kidney_marker'] === '1' ? 'checked' : '' ?>>
                            Iný potvrdený marker poškodenia obličiek (napr. močový sediment, zobrazovací alebo histologický nález)
                        </label>
                        <div class="form-group mkch10-picker" id="mkch10-related-picker" data-source="assets/data/mkch10-sk.json" data-max-items="12" data-field-name="related_diagnoses[]" data-selected="<?= htmlspecialchars($form['related_diagnoses']) ?>" data-empty-status="Nie je vybraná žiadna pridružená diagnóza." data-count-status="Vybrané pridružené diagnózy">
                            <label for="related_diagnosis_search">Pridružené diagnózy (MKCH-10-SK)</label>
                            <input type="search" id="related_diagnosis_search" class="form-control" autocomplete="off" role="combobox" aria-autocomplete="list" aria-haspopup="listbox" aria-controls="related_diagnosis_results" aria-expanded="false" aria-describedby="related_diagnosis_help related_diagnosis_status" placeholder="Začnite písať kód alebo názov diagnózy">
                            <div id="related_diagnosis_results" class="mkch10-results" role="listbox" aria-label="Výsledky vyhľadávania pridružených diagnóz" hidden></div>
                            <div id="related_diagnosis_selected" class="mkch10-selected" aria-label="Vybrané pridružené diagnózy"></div>
                            <small id="related_diagnosis_help">Ďalšie diagnózy okrem príčiny CKD. Vyhľadávajte podľa kódu alebo slovenského názvu. Možno vybrať najviac 12 kódov.</small>
                            <small id="related_diagnosis_status" class="mkch10-status" role="status" aria-live="polite"></small>
                            <noscript>
                                <label for="related_diagnoses_noscript">Kódy diagnóz MKCH-10-SK (oddelené čiarkou)</label>
                                <input type="text" id="related_diagnoses_noscript" name="related_diagnoses" maxlength="300" class="form-control" value="<?= htmlspecialchars($form['related_diagnoses']) ?>" placeholder="napr. N18.3, I12.00">
                                <small>Bez JavaScriptu zadajte kódy ručne. Server overí ich prítomnosť v číselníku.</small>
                            </noscript>
                        </div>
                    </section>

                    <section class="form-section" aria-labelledby="ambulatory-risk-heading">
                        <h3 id="ambulatory-risk-heading">Vstupy pre KFRE, CKD-PC a CKM</h3>
                        <p class="helper-text">KFRE potrebuje vek, pohlavie, eGFR a uACR. CKD-PC navyše systolický TK, BMI a fajčenie; pri diabete aj HbA1c. CKM využije zadané metabolické a KV údaje. Nevyplnené polia sa vo výstupe vynechajú.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="sbp">Systolický TK (mmHg)</label>
                                <input type="text" id="sbp" name="sbp" inputmode="decimal" class="form-control" placeholder="napr. 135" value="<?= htmlspecialchars($form['sbp']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="bmi">BMI (kg/m²)</label>
                                <input type="text" id="bmi" name="bmi" inputmode="decimal" class="form-control" placeholder="napr. 29,4" value="<?= htmlspecialchars($form['bmi']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="smoking">Fajčenie</label>
                                <select id="smoking" name="smoking" class="form-control">
                                    <option value="" <?= $form['smoking'] === '' ? 'selected' : '' ?>>Neuvedené</option>
                                    <option value="never" <?= $form['smoking'] === 'never' ? 'selected' : '' ?>>Nikdy nefajčil/a</option>
                                    <option value="former" <?= $form['smoking'] === 'former' ? 'selected' : '' ?>>Bývalý/á fajčiar/ka</option>
                                    <option value="current" <?= $form['smoking'] === 'current' ? 'selected' : '' ?>>Aktívne fajčí</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hba1c">HbA1c (%)</label>
                                <input type="text" id="hba1c" name="hba1c" inputmode="decimal" class="form-control" placeholder="povinné pri DM, napr. 7,2" value="<?= htmlspecialchars($form['hba1c']) ?>">
                            </div>
                        </div>

                        <fieldset class="calc-fieldset">
                            <legend>Komorbidity a liečba</legend>
                            <div class="ambulatory-check-grid">
                                <label class="form-check"><input type="checkbox" name="antihtn" value="1" <?= $form['antihtn'] === '1' ? 'checked' : '' ?>> Antihypertenzívna liečba</label>
                                <label class="form-check"><input type="checkbox" name="hf" value="1" <?= $form['hf'] === '1' ? 'checked' : '' ?>> Srdcové zlyhanie</label>
                                <label class="form-check"><input type="checkbox" name="chd" value="1" <?= $form['chd'] === '1' ? 'checked' : '' ?>> ICHS</label>
                                <label class="form-check"><input type="checkbox" name="afib" value="1" <?= $form['afib'] === '1' ? 'checked' : '' ?>> Fibrilácia predsiení</label>
                                <label class="form-check"><input type="checkbox" name="diabetes" value="1" <?= $form['diabetes'] === '1' ? 'checked' : '' ?>> Diabetes mellitus</label>
                                <label class="form-check"><input type="checkbox" name="insulin" value="1" <?= $form['insulin'] === '1' ? 'checked' : '' ?>> Liečba inzulínom</label>
                                <label class="form-check"><input type="checkbox" name="oral_dm" value="1" <?= $form['oral_dm'] === '1' ? 'checked' : '' ?>> Perorálna antidiabetická liečba</label>
                                <label class="form-check"><input type="checkbox" name="hypertension" value="1" <?= $form['hypertension'] === '1' ? 'checked' : '' ?>> Diagnóza hypertenzie</label>
                                <label class="form-check"><input type="checkbox" name="hypertriglyceridemia" value="1" <?= $form['hypertriglyceridemia'] === '1' ? 'checked' : '' ?>> Hypertriglyceridémia</label>
                                <label class="form-check"><input type="checkbox" name="metabolic_syndrome" value="1" <?= $form['metabolic_syndrome'] === '1' ? 'checked' : '' ?>> Metabolický syndróm</label>
                                <label class="form-check"><input type="checkbox" name="prediabetes" value="1" <?= $form['prediabetes'] === '1' ? 'checked' : '' ?>> Prediabetes / porucha glukózovej tolerancie</label>
                            </div>
                        </fieldset>

                        <fieldset class="calc-fieldset">
                            <legend>Doplňujúce kritériá CKM</legend>
                            <div class="ambulatory-check-grid">
                                <label class="form-check"><input type="checkbox" name="asian_ancestry" value="1" <?= $form['asian_ancestry'] === '1' ? 'checked' : '' ?>> Ázijský pôvod (BMI hranica 23 kg/m²)</label>
                                <label class="form-check"><input type="checkbox" name="increased_waist" value="1" <?= $form['increased_waist'] === '1' ? 'checked' : '' ?>> Zvýšený obvod pása</label>
                                <label class="form-check"><input type="checkbox" name="subclinical_cvd" value="1" <?= $form['subclinical_cvd'] === '1' ? 'checked' : '' ?>> Subklinické KV ochorenie alebo vysoké predikované KV riziko</label>
                                <label class="form-check"><input type="checkbox" name="other_clinical_cvd" value="1" <?= $form['other_clinical_cvd'] === '1' ? 'checked' : '' ?>> NCMP, PAO alebo iné klinické KV ochorenie</label>
                            </div>
                        </fieldset>
                    </section>

                    <section class="form-section" aria-labelledby="ambulatory-slope-heading">
                        <h3 id="ambulatory-slope-heading">Predchádzajúce eGFR pre výpočet slope</h3>
                        <p class="helper-text">Aktuálne eGFR a dátum vyšetrenia sa pridajú automaticky, ak sú zadané. Pre slope uveďte aspoň jedno staršie meranie; pri viacerých bodoch sa použije lineárna regresia.</p>
                        <?php for ($index = 1; $index <= 3; $index++): ?>
                            <div class="form-grid calc-item-separator">
                                <div class="form-group">
                                    <label for="slope_date_<?= $index ?>">Dátum staršieho merania <?= $index ?></label>
                                    <input type="date" id="slope_date_<?= $index ?>" name="slope_date_<?= $index ?>" class="form-control" max="<?= htmlspecialchars($form['examination_date']) ?>" value="<?= htmlspecialchars($form['slope_date_' . $index]) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="slope_egfr_<?= $index ?>">eGFR pri meraní <?= $index ?></label>
                                    <input type="text" id="slope_egfr_<?= $index ?>" name="slope_egfr_<?= $index ?>" inputmode="decimal" class="form-control" placeholder="ml/min/1,73 m²" value="<?= htmlspecialchars($form['slope_egfr_' . $index]) ?>">
                                </div>
                            </div>
                        <?php endfor; ?>
                    </section>

                    <section class="form-section" aria-labelledby="ambulatory-complications-heading">
                        <h3 id="ambulatory-complications-heading">Komplikácie CKD</h3>
                        <div class="ambulatory-check-grid">
                            <?php foreach ($complicationLabels as $key => $label): ?>
                                <label class="form-check">
                                    <input type="checkbox" name="complications[]" value="<?= htmlspecialchars($key) ?>" <?= in_array($key, $selectedComplications, true) ? 'checked' : '' ?>>
                                    <?= htmlspecialchars($label) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Vytvoriť text do správy</button>
                        <a href="calculator_ambulatory.php" class="btn-secondary">Vymazať formulár</a>
                    </div>
                </form>

                <?php if ($plainTextOutput !== null): ?>
                    <section class="form-section calculator-result-block" role="status" aria-live="polite" aria-labelledby="ambulatory-result-heading">
                        <h3 id="ambulatory-result-heading">Text do lekárskej správy</h3>
                        <label for="ambulatory-output">Pred vložením do Nefrisu text skontrolujte a podľa potreby upravte. Sekcie, na ktoré nestačili vstupy, sú vynechané.</label>
                        <textarea id="ambulatory-output" class="form-control ambulatory-output" rows="<?= max(14, min(28, substr_count($plainTextOutput, "\n") + 3)) ?>" readonly><?= htmlspecialchars($plainTextOutput) ?></textarea>
                        <?php if ($skippedOutput !== []): ?>
                            <div class="info-box-blue ambulatory-skipped" role="note" aria-labelledby="ambulatory-skipped-heading">
                                <p id="ambulatory-skipped-heading">Z dostupných údajov sa nevypočítalo:</p>
                                <ul>
                                    <?php foreach ($skippedOutput as $skippedItem): ?>
                                        <li><?= htmlspecialchars($skippedItem) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="form-actions no-print">
                            <button type="button" id="copy-ambulatory-output" class="btn-primary">Skopírovať text</button>
                            <span id="ambulatory-copy-status" class="helper-text" role="status" aria-live="polite"></span>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <section class="primary-article auth-container auth-container--wide" aria-labelledby="ambulatory-limits-heading">
                <h3 id="ambulatory-limits-heading">Dôležité hranice interpretácie</h3>
                <ul>
                    <li>CKD vyžaduje abnormalitu štruktúry alebo funkcie obličiek trvajúcu najmenej 3 mesiace. Jediný abnormálny eGFR alebo uACR chronicitu nepotvrdzuje.</li>
                    <li>Pri G1–G2 a A1 bez iného markera poškodenia obličiek nie sú z uvedených údajov splnené kritériá CKD.</li>
                    <li>KFRE sa tu počíta iba pri eGFR 10 až &lt;60 ml/min/1,73 m², s kalibráciou mimo Severnej Ameriky (Tangri 2016). CKD-PC sa počíta pri veku 20–80 rokov a predikuje iný endpoint: ≥40 % pokles eGFR alebo zlyhanie obličiek v horizonte 2–3 rokov. Ak niektorý vstup chýba, príslušný model sa vo výstupe vynechá.</li>
                    <li>Automatický kód N18.x vyjadruje štádium CKD. Príčinu CKD a pridružené diagnózy vyberáte z importovaného číselníka MKCH-10-SK verzie 26, platného od 1. 1. 2026; k príčine možno doplniť vlastný text. Klinickú správnosť výberu musí potvrdiť lekár.</li>
                </ul>

                <h3>Primárne zdroje</h3>
                <ul class="reference-list">
                    <li><small><em><a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of CKD</a>.</em></small></li>
                    <li><small><em><a href="https://jamanetwork.com/journals/jama/fullarticle/897102" target="_blank" rel="noopener noreferrer">Tangri N et al. A Predictive Model for Progression of CKD to Kidney Failure. JAMA. 2011</a>.</em></small></li>
                    <li><small><em><a href="https://jamanetwork.com/journals/jama/fullarticle/2481159" target="_blank" rel="noopener noreferrer">Tangri N et al. Multinational Assessment of Accuracy of Equations for Predicting Risk of Kidney Failure. JAMA. 2016</a>.</em></small></li>
                    <li><small><em><a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9472501/" target="_blank" rel="noopener noreferrer">Grams ME et al. Development and Validation of Prediction Models of Adverse Kidney Outcomes. Diabetes Care. 2022</a>.</em></small></li>
                    <li><small><em><a href="https://professional.heart.org/en/science-news/cardiovascular-kidney-metabolic-health-a-presidential-advisory" target="_blank" rel="noopener noreferrer">AHA 2023 Presidential Advisory on Cardiovascular-Kidney-Metabolic Health</a>.</em></small></li>
                    <li><small><em><a href="https://nczisk.sk/Standardy-v-zdravotnictve/Pages/Medzinarodna-klasifikacia-chorob-MKCH-10.aspx" target="_blank" rel="noopener noreferrer">NCZI: aktuálna Medzinárodná klasifikácia chorôb MKCH-10-SK</a>.</em></small></li>
                </ul>
            </section>

            <?php include 'calculator_disclaimer.php'; ?>
        </div>
    </main>

    <script src="calculator_ambulatory.js?v=<?= filemtime(__DIR__ . '/calculator_ambulatory.js') ?>" defer></script>
    <?php include 'footer.php'; ?>
</body>
</html>
