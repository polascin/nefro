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
    'sex' => (string) ($_POST['sex'] ?? 'female'),
    'egfr' => (string) ($_POST['egfr'] ?? ''),
    'uacr_value' => (string) ($_POST['uacr_value'] ?? ''),
    'uacr_unit' => (string) ($_POST['uacr_unit'] ?? 'mg_mmol'),
    'chronicity' => (string) ($_POST['chronicity'] ?? 'confirmed'),
    'repeat_date' => (string) ($_POST['repeat_date'] ?? date('Y-m-d', strtotime('+3 months'))),
    'related_diagnoses' => ambulatoryPostedCodeList($_POST['related_diagnoses'] ?? ''),
    'sbp' => (string) ($_POST['sbp'] ?? ''),
    'bmi' => (string) ($_POST['bmi'] ?? ''),
    'smoking' => (string) ($_POST['smoking'] ?? 'never'),
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
        if ($cause === '') {
            $errors[] = 'Uveďte príčinu CKD výberom z číselníka MKCH-10 alebo vlastným textom; ak nie je známa, zadajte „neurčená“.';
        }
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

        $birthInput = ambulatoryNormalizeSingleLine($form['birth_input'], 16);
        $form['birth_input'] = $birthInput;
        $birthParts = $birthInput === '' ? null : ambulatoryParseBirthInput($birthInput);
        $ageYears = null;
        if ($birthInput === '') {
            $errors[] = 'Zadajte rok narodenia alebo dátum narodenia.';
        } elseif ($birthParts === null) {
            $errors[] = 'Dátum narodenia je neplatný. Použite rok (1965), mesiac a rok (6/1965) alebo celý dátum (15.6.1965).';
        } elseif ($examinationDate instanceof \DateTimeImmutable) {
            $ageYears = ambulatoryAgeAtExamination($birthParts, $examinationDate);
            if ($ageYears === null) {
                $errors[] = 'Dátum narodenia nemôže byť po dátume vyšetrenia.';
            } elseif ($ageYears < 18 || $ageYears > 120) {
                $errors[] = 'Vek k dátumu vyšetrenia musí byť v intervale 18 až 120 rokov.';
            }
        }

        $sex = in_array($form['sex'], ['female', 'male'], true) ? $form['sex'] : '';
        if ($sex === '') {
            $errors[] = 'Vyberte pohlavie použité v prognostických rovniciach.';
        }

        $egfr = calculatorParsePositiveFloat($form['egfr']);
        if ($egfr === null || $egfr > 200.0) {
            $errors[] = 'eGFR musí byť kladné číslo najviac 200 ml/min/1,73 m².';
        }

        $uacrUnit = in_array($form['uacr_unit'], ['mg_g', 'mg_mmol'], true)
            ? $form['uacr_unit']
            : '';
        if ($uacrUnit === '') {
            $errors[] = 'Vyberte jednotku uACR.';
        }

        $uacrValue = calculatorParsePositiveFloat($form['uacr_value']);
        if ($uacrValue === null || $uacrValue > 15000.0) {
            $errors[] = 'uACR musí byť kladné číslo v realistickom rozsahu.';
        }

        $chronicity = in_array($form['chronicity'], ['confirmed', 'unconfirmed'], true)
            ? $form['chronicity']
            : '';
        if ($chronicity === '') {
            $errors[] = 'Vyberte stav chronicity abnormalít.';
        }

        $repeatDate = null;
        if ($chronicity === 'unconfirmed') {
            $repeatDate = \DateTimeImmutable::createFromFormat('!Y-m-d', $form['repeat_date']);
            if (
                !$repeatDate instanceof \DateTimeImmutable ||
                $repeatDate->format('Y-m-d') !== $form['repeat_date']
            ) {
                $errors[] = 'Pri nepotvrdenej chronicite zadajte platný dátum opakovanej kontroly.';
                $repeatDate = null;
            } elseif (
                $examinationDate instanceof \DateTimeImmutable &&
                $repeatDate <= $examinationDate
            ) {
                $errors[] = 'Opakovaná kontrola musí byť naplánovaná po dátume vyšetrenia.';
            }
        }

        $sbp = calculatorParsePositiveFloat($form['sbp']);
        if ($sbp === null || $sbp < 70.0 || $sbp > 250.0) {
            $errors[] = 'Systolický TK musí byť v rozsahu 70 až 250 mmHg.';
        }

        $bmi = calculatorParsePositiveFloat($form['bmi']);
        if ($bmi === null || $bmi < 10.0 || $bmi > 80.0) {
            $errors[] = 'BMI musí byť v rozsahu 10 až 80 kg/m².';
        }

        $smoking = in_array($form['smoking'], ['never', 'former', 'current'], true)
            ? $form['smoking']
            : '';
        if ($smoking === '') {
            $errors[] = 'Vyberte stav fajčenia.';
        }

        $diabetes = $form['diabetes'] === '1';
        $hba1c = 7.0;
        if ($diabetes) {
            $parsedHba1c = calculatorParsePositiveFloat($form['hba1c']);
            if ($parsedHba1c === null || $parsedHba1c < 4.0 || $parsedHba1c > 20.0) {
                $errors[] = 'Pri diabete zadajte HbA1c v rozsahu 4 až 20 %.';
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
            /** @var int $ageYears */
            /** @var float $egfr */
            /** @var float $uacrValue */
            /** @var float $sbp */
            /** @var float $bmi */
            /** @var \DateTimeImmutable $examinationDate */
            $uacrMgG = $uacrUnit === 'mg_mmol' ? $uacrValue * 8.84 : $uacrValue;
            $gCategory = ckdGCategory($egfr);
            $aCategory = kdigoACategory($uacrMgG);
            $riskInfo = kdigoRisk($gCategory, $aCategory);

            $otherKidneyMarker = $form['other_kidney_marker'] === '1';
            $chronicityConfirmed = $chronicity === 'confirmed';
            $meetsCkdCriteria = $egfr < 60.0 || $uacrMgG >= 30.0 || $otherKidneyMarker;
            $hasConfirmedCkd = $chronicityConfirmed && $meetsCkdCriteria;

            $mainDiagnosis = ambulatoryMainDiagnosis($gCategory, $chronicityConfirmed, $meetsCkdCriteria);

            $kfreText = 'nevypočítané (model je určený pre eGFR 10 až <60)';
            if ($egfr >= 10.0 && $egfr < 60.0 && $ageYears <= 100) {
                $kfre = kfreRisk($ageYears, $sex, $egfr, $uacrMgG);
                $kfreText = '2 r.: ' . ambulatoryFormatNumber($kfre['risk_2yr']) .
                    ' % | 5 r.: ' . ambulatoryFormatNumber($kfre['risk_5yr']) . ' %';
            }

            $ckdpcText = 'nevypočítané (vek mimo validačného rozsahu 20–80 rokov)';
            if ($ageYears >= 20 && $ageYears <= 80) {
                $ckdpc = ckdpcRisk(
                    $ageYears,
                    $sex,
                    $egfr,
                    $uacrMgG,
                    $diabetes,
                    $sbp,
                    $form['antihtn'] === '1',
                    $form['hf'] === '1',
                    $form['chd'] === '1',
                    $form['afib'] === '1',
                    $bmi,
                    $smoking,
                    $hba1c,
                    $form['insulin'] === '1',
                    $form['oral_dm'] === '1',
                );
                $ckdpcText = '3 r.: ' . ambulatoryFormatNumber($ckdpc['risk_3yr']) . ' %';
            }

            $gaRiskKey = match ($riskInfo['risk']) {
                'Nízke riziko' => 'low',
                'Stredné riziko' => 'moderate',
                'Vysoké riziko' => 'high',
                default => 'veryhigh',
            };
            $gaRiskText = match ($gaRiskKey) {
                'low' => 'nízke',
                'moderate' => 'stredné',
                'high' => 'vysoké',
                default => 'veľmi vysoké',
            };

            $isAsian = $form['asian_ancestry'] === '1';
            $adiposity = $bmi >= ($isAsian ? 23.0 : 25.0) || $form['increased_waist'] === '1';
            $dysAdiposity = $form['prediabetes'] === '1';
            $metabolicRisk =
                $form['hypertension'] === '1' ||
                $diabetes ||
                $form['hypertriglyceridemia'] === '1' ||
                $form['metabolic_syndrome'] === '1';
            $ckdModerateHigh = $hasConfirmedCkd && $gaRiskKey !== 'low';
            $kidneyFailure = $hasConfirmedCkd && $egfr < 15.0;
            $ckdVeryHigh = $hasConfirmedCkd && ($gaRiskKey === 'veryhigh' || $kidneyFailure);
            $clinicalCvd =
                $form['hf'] === '1' ||
                $form['chd'] === '1' ||
                $form['afib'] === '1' ||
                $form['other_clinical_cvd'] === '1';

            $ckmStage = ckmComputeStage(
                $adiposity,
                $dysAdiposity,
                $metabolicRisk,
                $ckdModerateHigh,
                $ckdVeryHigh,
                $form['subclinical_cvd'] === '1',
                $clinicalCvd,
                $kidneyFailure,
            );
            $ckmText = $ckmStage['code'] . ' (' . ckmStageLabel($ckmStage['code']) . ')';

            $slopeResult = ambulatoryCalculateEgfrSlope($slopePoints);
            $slopeText = 'nedostupný – zadajte aspoň jedno predchádzajúce meranie';
            if ($slopeResult !== null) {
                $slopeText = ambulatoryFormatNumber($slopeResult['slope'], 2) .
                    ' ml/min/1,73 m²/rok (počet meraní: ' . $slopeResult['count'] .
                    '; obdobie: ' . ambulatoryFormatNumber($slopeResult['duration_years'], 1) . ' roka)';
            }

            $chronicityText = 'potvrdená';
            if (!$chronicityConfirmed && $repeatDate instanceof \DateTimeImmutable) {
                $chronicityText = 'nepotvrdená – opakovať eGFR/uACR dňa ' .
                    $repeatDate->format('d.m.Y') . ' (pri podozrení na AKI skôr)';
            }

            $complicationText = 'neuvedené';
            if ($selectedComplications !== []) {
                $labels = array_map(
                    static fn(string $key): string => $complicationLabels[$key],
                    $selectedComplications,
                );
                $complicationText = implode(' / ', $labels);
            }

            $uacrDisplay = ambulatoryFormatNumber($uacrValue, 2) . ' ' .
                ($uacrUnit === 'mg_mmol' ? 'mg/mmol' : 'mg/g');
            if ($uacrUnit === 'mg_mmol') {
                $uacrDisplay .= ' = ' . ambulatoryFormatNumber($uacrMgG, 1) . ' mg/g';
            }

            $summary = [
                'main_diagnosis' => $mainDiagnosis,
                'cga' => 'príčina (Cause) ' . $cause . ', kategória ' . $gCategory .
                    ' (eGFR ' . ambulatoryFormatNumber($egfr, 1) .
                    ' ml/min/1,73 m²), kategória ' . $aCategory . ' (uACR ' . $uacrDisplay . ')',
                'risks' => 'KFRE (' . $kfreText . ') | CKD-PC (' . $ckdpcText .
                    ') | CKM Stage (AHA 2023): ' . $ckmText,
                'slope' => $slopeText,
                'ga_risk' => $gaRiskText,
                'chronicity' => $chronicityText,
                'related_diagnoses' => $relatedDiagnoses !== '' ? $relatedDiagnoses : 'neuvedené',
                'complications' => $complicationText,
            ];
            $plainTextOutput = ambulatoryBuildPlainText($summary);
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
  $seoDescription = 'Ambulantná CKD kalkulačka pre lekárov: KDIGO 2024 CGA, KFRE, CKD-PC, CKM stage, eGFR slope a kopírovateľný text do lekárskej správy.';
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
                <p class="auth-subtitle">Z jedného formulára vytvorí KDIGO CGA klasifikáciu, prognostické riziká a čistý text vhodný na skopírovanie do ambulantnej správy.</p>

                <div class="info-box-blue">
                    Kalkulačka nevyžaduje identifikačné údaje pacienta a výsledok neukladá do databázy. Dátum alebo rok narodenia slúži len na výpočet veku k dátumu vyšetrenia a na serveri sa neukladá. Príčinu CKD, chronicitu, pridružené diagnózy a komplikácie potvrdzuje lekár; nástroj ich neurčuje zo samotných laboratórnych hodnôt.
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
                            <label for="cause_diagnosis_search">Príčina CKD (Cause) <span class="required">*</span></label>
                            <input type="search" id="cause_diagnosis_search" class="form-control" autocomplete="off" role="combobox" aria-autocomplete="list" aria-haspopup="listbox" aria-controls="cause_diagnosis_results" aria-expanded="false" aria-describedby="cause_diagnosis_help cause_diagnosis_status" placeholder="Začnite písať kód alebo názov diagnózy">
                            <div id="cause_diagnosis_results" class="mkch10-results" role="listbox" aria-label="Výsledky vyhľadávania príčin CKD" hidden></div>
                            <div id="cause_diagnosis_selected" class="mkch10-selected" aria-label="Vybrané príčiny CKD"></div>
                            <small id="cause_diagnosis_help">Vyhľadávajte podľa kódu alebo slovenského názvu. Možno vybrať viac diagnóz, najviac 8. Povinný je aspoň jeden kód alebo doplnenie vlastnými slovami; ak príčina nie je známa, do doplnenia napíšte „neurčená“.</small>
                            <small id="cause_diagnosis_status" class="mkch10-status" role="status" aria-live="polite"></small>
                            <noscript>
                                <label for="cause_diagnoses_noscript">Kódy príčin CKD (MKCH-10-SK, oddelené čiarkou)</label>
                                <input type="text" id="cause_diagnoses_noscript" name="cause_diagnoses" maxlength="300" class="form-control" value="<?= htmlspecialchars($form['cause_diagnoses']) ?>" placeholder="napr. E11.21†, N08.3*">
                                <small>Bez JavaScriptu zadajte kódy ručne. Server overí ich prítomnosť v číselníku.</small>
                            </noscript>
                            <div class="form-group mkch10-note">
                                <label for="cause_note">Doplnenie vlastnými slovami</label>
                                <input type="text" id="cause_note" name="cause_note" maxlength="200" class="form-control" placeholder="napr. diabetická choroba obličiek; neurčená" value="<?= htmlspecialchars($form['cause_note']) ?>" aria-describedby="cause_note_help">
                                <small id="cause_note_help">Voliteľné, ak ste vybrali aspoň jeden kód MKCH-10. Ak kód nevyberiete, toto pole je povinné.</small>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="examination_date">Dátum vyšetrenia <span class="required">*</span></label>
                                <input type="date" id="examination_date" name="examination_date" required class="form-control" max="<?= htmlspecialchars(date('Y-m-d')) ?>" value="<?= htmlspecialchars($form['examination_date']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="birth_input">Dátum alebo rok narodenia <span class="required">*</span></label>
                                <input type="text" id="birth_input" name="birth_input" required maxlength="16" class="form-control" autocomplete="off" placeholder="napr. 1965, 6/1965 alebo 15.6.1965" value="<?= htmlspecialchars($form['birth_input']) ?>" aria-describedby="birth_input_help birth_age_status">
                                <small id="birth_input_help">Vek sa dopočíta k dátumu vyšetrenia. Stačí rok, mesiac a rok, alebo celý dátum. Pri neúplnom údaji sa chýbajúce časti berú ako 1. január, resp. 1. deň mesiaca.</small>
                                <small id="birth_age_status" class="ambulatory-age-status" role="status" aria-live="polite"></small>
                            </div>
                            <div class="form-group">
                                <label for="sex">Pohlavie použité v rovniciach <span class="required">*</span></label>
                                <select id="sex" name="sex" required class="form-control">
                                    <option value="female" <?= $form['sex'] === 'female' ? 'selected' : '' ?>>Žena</option>
                                    <option value="male" <?= $form['sex'] === 'male' ? 'selected' : '' ?>>Muž</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="egfr">Aktuálne eGFR (ml/min/1,73 m²) <span class="required">*</span></label>
                                <input type="text" id="egfr" name="egfr" required inputmode="decimal" class="form-control" placeholder="napr. 38,5" value="<?= htmlspecialchars($form['egfr']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="uacr_value">Aktuálne uACR <span class="required">*</span></label>
                                <div class="input-with-unit">
                                    <input type="text" id="uacr_value" name="uacr_value" required inputmode="decimal" class="form-control" placeholder="napr. 12,4" value="<?= htmlspecialchars($form['uacr_value']) ?>">
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
                        <p class="helper-text">KFRE používa vek, pohlavie, eGFR a uACR. Nasledujúce údaje dopĺňajú CKD-PC a staging CKM.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="sbp">Systolický TK (mmHg) <span class="required">*</span></label>
                                <input type="text" id="sbp" name="sbp" required inputmode="decimal" class="form-control" placeholder="napr. 135" value="<?= htmlspecialchars($form['sbp']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="bmi">BMI (kg/m²) <span class="required">*</span></label>
                                <input type="text" id="bmi" name="bmi" required inputmode="decimal" class="form-control" placeholder="napr. 29,4" value="<?= htmlspecialchars($form['bmi']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="smoking">Fajčenie <span class="required">*</span></label>
                                <select id="smoking" name="smoking" required class="form-control">
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
                        <p class="helper-text">Aktuálne eGFR a dátum vyšetrenia sa pridajú automaticky. Zadajte aspoň jedno staršie meranie; pri viacerých bodoch sa použije lineárna regresia.</p>
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
                        <label for="ambulatory-output">Pred vložením do Nefrisu text skontrolujte a podľa potreby upravte</label>
                        <textarea id="ambulatory-output" class="form-control ambulatory-output" rows="13" readonly><?= htmlspecialchars($plainTextOutput) ?></textarea>
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
                    <li>KFRE sa tu počíta iba pri eGFR 10 až &lt;60 ml/min/1,73 m². CKD-PC sa počíta pri veku 20–80 rokov a predikuje iný endpoint: ≥40 % pokles eGFR alebo zlyhanie obličiek v horizonte 2–3 rokov.</li>
                    <li>Automatický kód N18.x vyjadruje štádium CKD. Príčinu CKD a pridružené diagnózy vyberáte z importovaného číselníka MKCH-10-SK verzie 26, platného od 1. 1. 2026; k príčine možno doplniť vlastný text. Klinickú správnosť výberu musí potvrdiť lekár.</li>
                </ul>

                <h3>Primárne zdroje</h3>
                <ul class="reference-list">
                    <li><small><em><a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of CKD</a>.</em></small></li>
                    <li><small><em><a href="https://jamanetwork.com/journals/jama/fullarticle/897102" target="_blank" rel="noopener noreferrer">Tangri N et al. A Predictive Model for Progression of CKD to Kidney Failure. JAMA. 2011</a>.</em></small></li>
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
