<?php
declare(strict_types=1);

require_once __DIR__ . '/request_input.php';

// Kalkulačky skladajú JSON-LD ešte pred načítaním head_meta.php.
$baseUrl = $baseUrl ?? 'https://nefro.polascin.net/';

/**
 * Skalárny POST reťazec pre kalkulačky (pole → HTTP 400).
 */
function calculatorPostString(string $key, string $default = ''): string
{
    return requestScalarString($_POST, $key, $default);
}

/**
 * Skalárny POST integer pre kalkulačky (pole → HTTP 400).
 */
function calculatorPostInt(string $key, int $default = 0): int
{
    return requestScalarInt($_POST, $key, $default);
}

/**
 * POST zoznam reťazcov (multi-select / checkbox group). Vnorené polia → HTTP 400.
 *
 * @return list<string>
 */
function calculatorPostStringList(string $key): array
{
    return requestStringList($_POST, $key);
}

/**
 * Formulár z POST podľa predvolieb. Checkboxy sem nedávaj — ostávajú na isset.
 *
 * @param array<string, string> $defaults
 * @return array<string, string>
 */
function calculatorFormFromPost(array $defaults): array
{
    $form = [];
    foreach ($defaults as $key => $default) {
        $form[$key] = calculatorPostString($key, (string) $default);
    }

    return $form;
}

/* ── Retencia výsledkov kalkulačiek ───────────────────────────────────────
 * `calculator_results` ukladá údaje o zdraví: meno, dátum narodenia, rodné
 * číslo a číslo poisťovne. Bez lehoty by tabuľka rástla donekonečna a
 * identifikátory by zostávali v DB navždy.
 *
 * Preto dvojstupňovo:
 *   1. po roku sa odstránia priame identifikátory, výsledok zostáva
 *      anonymizovaný a použiteľný na sledovanie vývoja;
 *   2. po desiatich rokoch sa riadok maž úplne.
 *
 * Lehoty vynucuje `archive_cleanup.php` (cron), nie len text v zásadách —
 * rovnako ako pri objednávkach publikácií.
 * ──────────────────────────────────────────────────────────────────────── */

/** Po tomto čase sa z výsledku odstránia priame identifikátory pacienta. */
const CALCULATOR_RESULT_ANONYMISE_DAYS = 365;
/** Po tomto čase sa výsledok kalkulačky maž úplne. */
const CALCULATOR_RESULT_RETENTION_DAYS = 3653;

/**
 * Odstráni priame identifikátory z výsledku kalkulačky.
 *
 * `input_payload` identifikátory neobsahuje — ukladá iba klinické hodnoty
 * (odber, hmotnosť, laboratórne hodnoty), takže stačí vyčistiť samostatné
 * stĺpce. Výsledok zostáva cenný: lekár vidí trend eGFR alebo draslíka.
 *
 * @return int Počet anonymizovaných riadkov.
 */
function calculatorAnonymiseOldResults(PDO $pdo, int $days = CALCULATOR_RESULT_ANONYMISE_DAYS): int
{
    $stmt = $pdo->prepare(
        "UPDATE calculator_results
         SET patient_first_name = NULL,
             patient_last_name = NULL,
             patient_birth_date = NULL,
             patient_birth_number = NULL,
             patient_insurance_code = NULL
         WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)
           AND (patient_first_name IS NOT NULL
             OR patient_last_name IS NOT NULL
             OR patient_birth_date IS NOT NULL
             OR patient_birth_number IS NOT NULL
             OR patient_insurance_code IS NOT NULL)"
    );
    $stmt->execute(['days' => max(30, $days)]);

    return $stmt->rowCount();
}

/**
 * Odstráni výsledky kalkulačiek, ktoré prekročili celú retenčnú lehotu.
 *
 * @return int Počet zmazaných riadkov.
 */
function calculatorDeleteExpiredResults(PDO $pdo, int $days = CALCULATOR_RESULT_RETENTION_DAYS): int
{
    $stmt = $pdo->prepare(
        "DELETE FROM calculator_results
         WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $stmt->execute(['days' => max(30, $days)]);

    return $stmt->rowCount();
}

function calculatorPatientDataFromRequest(array $source): array
{
    $firstName = requestScalarString($source, 'patient_first_name');
    $lastName = requestScalarString($source, 'patient_last_name');
    $birthDate = requestScalarString($source, 'patient_birth_date');
    $birthNumber = requestScalarString($source, 'patient_birth_number');
    $insuranceCode = requestScalarString($source, 'patient_insurance_code');

    return [
        'first_name' => mb_substr($firstName, 0, 100),
        'last_name' => mb_substr($lastName, 0, 100),
        'birth_date' => mb_substr($birthDate, 0, 10),
        'birth_number' => mb_substr($birthNumber, 0, 20),
        'insurance_code' => mb_substr($insuranceCode, 0, 10),
    ];
}

/**
 * Odvodí pohlavie z rodného čísla.
 * Žena:  mesiac 51–62 (bežne) alebo 71–82 (náhradná starostlivosť)
 * Muž:   mesiac 01–12 (bežne) alebo 21–32 (náhradná starostlivosť)
 *
 * @param  string $raw  Surové RČ (môže obsahovať lomku a medzery)
 * @return string|null  'female', 'male', alebo null ak formát neplatí
 */
function sexFromBirthNumber(string $raw): ?string {
    $bn = preg_replace('/[\s\/]/', '', $raw) ?? '';
    if (!preg_match('/^\d{9,10}$/', $bn)) {
        return null;
    }
    $mm = (int) substr($bn, 2, 2);
    if ($mm >= 51 && $mm <= 62) { return 'female'; }  // žena — bežný rozsah
    if ($mm >= 71 && $mm <= 82) { return 'female'; }  // žena — záložný rozsah (+70)
    if ($mm >= 1  && $mm <= 12) { return 'male';   }  // muž  — bežný rozsah
    if ($mm >= 21 && $mm <= 32) { return 'male';   }  // muž  — záložný rozsah (+20)
    return null;
}

/**
 * Validuje slovenské / české rodné číslo.
 *
 * Pravidlá:
 * - Formát: 6 číslic, voliteľné „/", 3–4 číslice (pred r. 1954 = 9-ciferné bez lomky)
 * - Prvých 6 číslic musí tvoriť platný kalendárny dátum (s korekciou pre ženy +50 a pre adoptované +20/+70)
 * - Pre RČ vydané od 1.1.1954 (10-ciferné): celé číslo musí byť deliteľné 11
 *
 * @param  string $raw   Surový vstup (môže obsahovať lomku, medzery)
 * @return string[]      Pole chybových hlásení (prázdne = OK)
 */
function validateBirthNumber(string $raw): array {
    // Normalizácia: odstránenie medzier a lomky
    $bn = preg_replace('/[\s\/]/', '', $raw) ?? '';

    // Dĺžka: 9 alebo 10 číslic
    if (!preg_match('/^\d{9,10}$/', $bn)) {
        return ['Rodné číslo musí obsahovať 9 alebo 10 číslic (formát 000000/0000 alebo XXXXXXXXXX).'];
    }

    $yy = (int) substr($bn, 0, 2);
    $mm = (int) substr($bn, 2, 2);
    $dd = (int) substr($bn, 4, 2);

    // Korekcie mesiacov
    $mmReal = $mm;
    if ($mmReal >= 71)      { $mmReal -= 70; }   // žena — záložný rozsah (+70)
    elseif ($mmReal >= 51)  { $mmReal -= 50; }   // žena — bežný rozsah (+50)
    elseif ($mmReal >= 21)  { $mmReal -= 20; }   // muž  — záložný rozsah (+20)

    if ($mmReal < 1 || $mmReal > 12) {
        return ['Rodné číslo obsahuje neplatný mesiac (pozícia 3–4).'];
    }

    // Deväťmiestne RČ sa vydávali iba osobám narodeným pred rokom 1954.
    $currentYear = (int) (new DateTime('today'))->format('Y');
    if (strlen($bn) === 9) {
        $year = 1900 + $yy;
        if ($year >= 1954) {
            return ['Deväťmiestne rodné číslo je platné iba pre dátum narodenia pred rokom 1954.'];
        }
    } else {
        $year = (2000 + $yy <= $currentYear) ? 2000 + $yy : 1900 + $yy;
    }

    // Overenie dátumu
    $dateStr = sprintf('%04d-%02d-%02d', $year, $mmReal, $dd);
    $dt = DateTime::createFromFormat('Y-m-d', $dateStr);
    if (!$dt || $dt->format('Y-m-d') !== $dateStr) {
        return ["Rodné číslo obsahuje neplatný dátum ($dateStr)."];
    }
    if ($dt > new DateTime('today')) {
        return ['Rodné číslo obsahuje dátum narodenia v budúcnosti.'];
    }

    // Modulo 11 — platí pre 10-ciferné RČ (vydané od 1.1.1954)
    if (strlen($bn) === 10) {
        $legacyRemainderException = $dt < new DateTime('1985-01-01')
            && str_ends_with($bn, '0')
            && ((int) substr($bn, 0, 9) % 11) === 10;
        if ((int) $bn % 11 !== 0 && !$legacyRemainderException) {
            return ['Rodné číslo má nesprávny kontrolný súčet (modulo 11).'];
        }
    }

    return [];
}

function calculatorValidateOptionalPatientData(array $patient, array &$errors): void
{
    if ($patient['birth_date'] !== '') {
        $dt = \DateTime::createFromFormat('Y-m-d', $patient['birth_date']);
        if (!$dt || $dt->format('Y-m-d') !== $patient['birth_date']) {
            $errors[] = 'Neplatný dátum narodenia.';
        }
    }

    if ($patient['birth_number'] !== '') {
        $bnErrors = validateBirthNumber($patient['birth_number']);
        foreach ($bnErrors as $bnError) {
            $errors[] = $bnError;
        }
    }

    if ($patient['insurance_code'] !== '' && !preg_match('/^\d{2,3}(-\d{2})?$/', $patient['insurance_code'])) {
        $errors[] = 'Kód zdravotnej poisťovne musí mať formát XX alebo XX-YY (napr. 24 alebo 24-01).';
    }
}

function calculatorValidateExaminationDate(string $date, array &$errors): void
{
    $dt = \DateTime::createFromFormat('!Y-m-d', $date);
    if (!$dt || $dt->format('Y-m-d') !== $date) {
        $errors[] = 'Zadajte platný dátum vyšetrenia.';
        return;
    }

    if ($dt > new \DateTime('today')) {
        $errors[] = 'Dátum vyšetrenia nemôže byť v budúcnosti.';
    }
}

/**
 * Odvodí vek pacienta z dátumu narodenia alebo rodného čísla.
 * Preferuje dátum narodenia; fallback na rodné číslo.
 *
 * @param array $patient  Výstup calculatorPatientDataFromRequest()
 * @return int|null  Vek v rokoch, alebo null ak sa nedá odvodiť
 */
function calculatorAgeFromPatient(array $patient): ?int
{
    $today = new \DateTime('today');

    if ($patient['birth_date'] !== '') {
        $dt = \DateTime::createFromFormat('Y-m-d', $patient['birth_date']);
        if ($dt && $dt->format('Y-m-d') === $patient['birth_date']) {
            $diff = $today->diff($dt);
            return ($diff->invert === 1) ? (int) $diff->y : null;
        }
    }

    if ($patient['birth_number'] !== '') {
        $bn = preg_replace('/[\s\/]/', '', $patient['birth_number']) ?? '';
        if (!preg_match('/^\d{9,10}$/', $bn)) {
            return null;
        }
        $yy = (int) substr($bn, 0, 2);
        $mm = (int) substr($bn, 2, 2);
        $dd = (int) substr($bn, 4, 2);

        if ($mm >= 71) {
            $mm -= 70;
        } elseif ($mm >= 51) {
            $mm -= 50;
        } elseif ($mm >= 21) {
            $mm -= 20;
        }

        if ($mm < 1 || $mm > 12 || $dd < 1 || $dd > 31) {
            return null;
        }

        $currentYear = (int) $today->format('Y');
        $year = strlen($bn) === 9
            ? 1900 + $yy
            : ((2000 + $yy <= $currentYear) ? 2000 + $yy : 1900 + $yy);
        $dateStr = sprintf('%04d-%02d-%02d', $year, $mm, $dd);
        $dt = \DateTime::createFromFormat('Y-m-d', $dateStr);
        if (!$dt || $dt->format('Y-m-d') !== $dateStr) {
            return null;
        }
        $diff = $today->diff($dt);
        return ($diff->invert === 1) ? (int) $diff->y : null;
    }

    return null;
}

function calculatorParsePositiveFloat(string $value): ?float
{
    $normalized = str_replace(',', '.', trim($value));
    if ($normalized === '' || !is_numeric($normalized)) {
        return null;
    }

    $number = (float) $normalized;
    if (!is_finite($number) || $number <= 0) {
        return null;
    }

    return $number;
}

function calculatorParseNonNegativeFloat(string $value): ?float
{
    $normalized = str_replace(',', '.', trim($value));
    if ($normalized === '' || !is_numeric($normalized)) {
        return null;
    }

    $number = (float) $normalized;
    if (!is_finite($number) || $number < 0) {
        return null;
    }

    return $number;
}

/** CSS trieda podľa PLASMIC skóre (0–7). */
function plasmicRiskClass(int $score): string
{
    if ($score >= 6) {
        return 'risk-high';
    }
    if ($score === 5) {
        return 'risk-moderate';
    }
    return 'risk-low';
}

/** Slovný opis rizikovej skupiny PLASMIC. */
function plasmicRiskLabel(int $score): string
{
    if ($score >= 6) {
        return 'vysoké riziko (≈ 62 až 82 %)';
    }
    if ($score === 5) {
        return 'stredné riziko (≈ 5 až 24 %)';
    }
    return 'nízke riziko (≈ 0 až 4 %)';
}

/** Prepočtový faktor kreatinínu: 1 mg/dL = 88,4 µmol/L (= 0,0884 mmol/L). */
const CREATININE_UMOL_PER_MGDL = 88.4;

/**
 * Molárna hmotnosť kreatinínu [g/mol] ≈ 113,12
 * (= 10 000 / CREATININE_UMOL_PER_MGDL; jeden zdroj pravdy s faktorom 88,4).
 */
const CREATININE_MOLAR_MASS_G_PER_MOL = 10000.0 / CREATININE_UMOL_PER_MGDL;

// Prah kreatinínu: 2,0 mg/dL × CREATININE_UMOL_PER_MGDL.
const PLASMIC_CREA_UMOL = 2.0 * CREATININE_UMOL_PER_MGDL;

/**
 * UACR: 1 mg/mmol ≈ 8,84 mg/g (= CREATININE_UMOL_PER_MGDL / 10).
 * Len na prevod hodnoty UACR medzi jednotkami; prahy KDIGO A1/A2/A3
 * (30/300 mg/g vs 3/30 mg/mmol) sa nesmú odvodzovať týmto faktorom.
 */
const UACR_MG_G_PER_MG_MMOL = CREATININE_UMOL_PER_MGDL / 10.0;

/**
 * BUN (urea-N) mg/dL → urea mmol/L (konvenčný faktor prevodníka).
 * Približne reciproký k UREA_MMOLL_TO_BUN_MGDL (2 × 14,007 / 10 ≈ 2,801).
 */
const BUN_MGDL_TO_UREA_MMOLL = 0.357;

/**
 * Urea mmol/L → BUN (urea-N) mg/dL (konvenčný faktor; ≈ 2 × 14,007 / 10).
 * Nie je odvodený ako 1/0,357: oba faktory sú samostatne zaokrúhlené klinické konštanty.
 */
const UREA_MMOLL_TO_BUN_MGDL = 2.8;

/**
 * Glukóza mg/dL → mmol/L (konvenčný faktor prevodníka; ≈ 1/18).
 * Približne reciproký k GLUCOSE_MMOLL_TO_MGDL (MW glukózy ≈ 180,16 / 10).
 */
const GLUCOSE_MGDL_TO_MMOLL = 0.0555;

/**
 * Glukóza mmol/L → mg/dL (≈ MW glukózy / 10 = 18,0182).
 * Nie je odvodený ako 1/0,0555: prevodník a Na kalkulačka používajú samostatne
 * zaokrúhlené klinické konštanty (0,0555 vs 18,0182).
 */
const GLUCOSE_MMOLL_TO_MGDL = 18.0182;

/**
 * Vápnik mg/dL → mmol/L (konvenčný faktor prevodníka; ≈ 10 / 40,08).
 * Približne reciproký k CALCIUM_MMOLL_TO_MGDL (MW Ca ≈ 40,08 / 10).
 */
const CALCIUM_MGDL_TO_MMOLL = 0.2495;

/**
 * Vápnik mmol/L → mg/dL (≈ MW vápnika / 10 = 4,008).
 * Nie je odvodený ako 1/0,2495: samostatne zaokrúhlené klinické konštanty
 * (prevodník 0,2495; TLS / korekcia albumínu 4,008).
 */
const CALCIUM_MMOLL_TO_MGDL = 4.008;

/**
 * Fosfát (P) mg/dL → mmol/L (konvenčný faktor prevodníka; ≈ 10 / 30,974).
 * Približne reciproký k PHOSPHATE_MMOLL_TO_MGDL (MW P ≈ 30,974 / 10).
 */
const PHOSPHATE_MGDL_TO_MMOLL = 0.3229;

/**
 * Fosfát (P) mmol/L → mg/dL (≈ MW fosforu / 10 = 3,097).
 * Nie je odvodený ako 1/0,3229: samostatne zaokrúhlené klinické konštanty
 * (prevodník 0,3229; TLS prahy Cairo–Bishop 4,5 / 6,5 mg/dL ÷ 3,097).
 */
const PHOSPHATE_MMOLL_TO_MGDL = 3.097;

/**
 * Magnézium mg/dL → mmol/L (konvenčný faktor prevodníka; ≈ 10 / 24,305).
 * Približne reciproký k MAGNESIUM_MMOLL_TO_MGDL (MW Mg ≈ 24,305 / 10).
 */
const MAGNESIUM_MGDL_TO_MMOLL = 0.4114;

/**
 * Magnézium mmol/L → mg/dL (≈ MW magnézia / 10 = 2,4305).
 * Nie je odvodený ako 1/0,4114: samostatne zaokrúhlené klinické konštanty
 * (prevodník 0,4114; MW Mg 24,305 → 2,4305).
 */
const MAGNESIUM_MMOLL_TO_MGDL = 2.4305;

/** CSS trieda podľa klasifikácie Cairo–Bishop. */
function tlsRiskClass(bool $ctls, bool $ltls): string
{
    if ($ctls) {
        return 'risk-high';
    }
    if ($ltls) {
        return 'risk-moderate';
    }
    return 'risk-low';
}

/** Slovný opis klasifikácie Cairo–Bishop. */
function tlsRiskLabel(bool $ctls, bool $ltls): string
{
    if ($ctls) {
        return 'klinický TLS';
    }
    if ($ltls) {
        return 'laboratórny TLS';
    }
    return 'bez TLS (Cairo-Bishop)';
}

// Absolútne prahy Cairo–Bishop (SI jednotky).
const TLS_URIC_ACID = 476.0;   // µmol/L (8 mg/dL)
const TLS_POTASSIUM = 6.0;     // mmol/L
const TLS_PHOS_ADULT = 1.45;   // mmol/L (4,5 mg/dL) — dospelí
const TLS_PHOS_CHILD = 2.1;    // mmol/L (6,5 mg/dL) — deti
const TLS_CALCIUM = 1.75;      // mmol/L (7 mg/dL) — korigovaný/ionizovaný

/**
 * PLASMIC skóre (Bendapudi a kol., Lancet Haematol 2017;4(4):e157–e164, PMID 28259520):
 * po 1 bode trombocyty < 30 ×10⁹/L, hemolýza, bez aktívneho nádoru, bez transplantácie,
 * MCV < 90 fL, INR < 1,5, kreatinín < 2,0 mg/dL (176,8 µmol/L).
 *
 * @return array{platelets: bool, hemolysis: bool, no_cancer: bool, no_transplant: bool, mcv: bool, inr: bool, creatinine: bool, score: int}
 */
function plasmicScore(
    float $plateletsGL,
    bool $hemolysis,
    bool $activeCancer,
    bool $transplant,
    float $mcvFl,
    float $inr,
    float $creatinineUmolL
): array {
    $c = [
        'platelets' => $plateletsGL < 30.0,
        'hemolysis' => $hemolysis,
        'no_cancer' => !$activeCancer,
        'no_transplant' => !$transplant,
        'mcv' => $mcvFl < 90.0,
        'inr' => $inr < 1.5,
        'creatinine' => $creatinineUmolL < PLASMIC_CREA_UMOL,
    ];

    return $c + ['score' => count(array_filter($c))];
}

/**
 * Klasifikácia syndrómu rozpadu nádoru podľa Cairo a Bishop (Br J Haematol 2004;127(1):3–11,
 * PMID 15384972), absolútne prahy v SI jednotkách. Laboratórny TLS: ≥ 2 odchýlky;
 * klinický TLS: laboratórny TLS + ≥ 1 klinický prejav.
 *
 * @return array{uric: bool, potassium: bool, phosphate: bool, calcium: bool, lab_count: int, clinical_count: int, ltls: bool, ctls: bool}
 */
function tlsCairoBishop(
    float $uricAcidUmolL,
    float $potassiumMmolL,
    float $phosphateMmolL,
    float $calciumMmolL,
    bool $isChild,
    bool $creatinineHigh,
    bool $arrhythmia,
    bool $seizure
): array {
    $lab = [
        'uric' => $uricAcidUmolL >= TLS_URIC_ACID,
        'potassium' => $potassiumMmolL >= TLS_POTASSIUM,
        'phosphate' => $phosphateMmolL >= ($isChild ? TLS_PHOS_CHILD : TLS_PHOS_ADULT),
        'calcium' => $calciumMmolL <= TLS_CALCIUM,
    ];
    $labCount = count(array_filter($lab));
    $clinicalCount = count(array_filter([$creatinineHigh, $arrhythmia, $seizure]));
    $ltls = $labCount >= 2;

    return $lab + [
        'lab_count' => $labCount,
        'clinical_count' => $clinicalCount,
        'ltls' => $ltls,
        'ctls' => $ltls && $clinicalCount >= 1,
    ];
}

/** Body za vek (roky). */
function guptaAgePoints(float $age): float
{
    if ($age <= 45.0) {
        return 0.0;
    }
    if ($age <= 60.0) {
        return 2.5;
    }
    if ($age <= 70.0) {
        return 3.5;
    }
    return 4.5;
}

/** Body za hemoglobín (g/dL). */
function guptaHbPoints(float $hbGdl): float
{
    if ($hbGdl >= 12.0) {
        return 0.0;
    }
    if ($hbGdl >= 11.0) {
        return 1.0;
    }
    return 1.5;
}

/** Body za albumín (g/dL). */
function guptaAlbPoints(float $albGdl): float
{
    if ($albGdl > 3.8) {
        return 0.0;
    }
    if ($albGdl >= 3.3) {
        return 1.0;
    }
    return 1.5;
}

/** Body za dávku cisplatiny (absolútne mg). */
function guptaDosePoints(float $mg): float
{
    if ($mg <= 50.0) {
        return 0.0;
    }
    if ($mg <= 75.0) {
        return 2.0;
    }
    if ($mg <= 100.0) {
        return 2.5;
    }
    if ($mg <= 125.0) {
        return 3.0;
    }
    if ($mg <= 150.0) {
        return 5.0;
    }
    if ($mg <= 200.0) {
        return 7.5;
    }
    return 9.5;
}

/**
 * Riziková kategória podľa celkového skóre.
 * @return array{code: string, label: string, risk_class: string, incidence: string}
 */
function guptaRiskCategory(float $score): array
{
    if ($score <= 5.5) {
        return ['code' => 'low', 'label' => 'nízke riziko', 'risk_class' => 'risk-low',
            'incidence' => '≈ 0,9 až 1,3 % ťažkého CP-AKI'];
    }
    if ($score <= 9.5) {
        return ['code' => 'moderate', 'label' => 'stredné riziko', 'risk_class' => 'risk-moderate',
            'incidence' => 'stredná (medzi nízkym a vysokým)'];
    }
    if ($score <= 15.5) {
        return ['code' => 'high', 'label' => 'vysoké riziko', 'risk_class' => 'risk-high',
            'incidence' => 'zvýšená (medzi stredným a veľmi vysokým)'];
    }
    return ['code' => 'veryhigh', 'label' => 'veľmi vysoké riziko', 'risk_class' => 'risk-high',
        'incidence' => '≈ 16,7 až 23,5 % ťažkého CP-AKI'];
}

/**
 * Gupta skóre ťažkej AKI po cisplatine (Gupta S a kol., BMJ 2024;384:e077169,
 * PMID 38538012): 9 premenných, rozsah 0 až 22,5 bodu. Kategórie premenných podľa
 * textu článku; bodové hodnoty a hranice rizikových skupín sú v obr. 2.
 *
 * @return array{age: float, htn: float, dm: float, hb: float, wbc: float, plt: float, alb: float, mg: float, dose: float, score: float}
 */
function guptaScore(
    float $ageYears,
    bool $hypertension,
    bool $diabetes,
    float $hbGdl,
    float $wbcGL,
    float $plateletsGL,
    float $albGdl,
    float $mgMgdl,
    float $cisplatinMg
): array {
    $p = [
        'age' => guptaAgePoints($ageYears),
        'htn' => $hypertension ? 1.0 : 0.0,
        'dm' => $diabetes ? 1.0 : 0.0,
        'hb' => guptaHbPoints($hbGdl),
        'wbc' => $wbcGL > 12.0 ? 1.5 : 0.0,
        'plt' => $plateletsGL < 150.0 ? 1.0 : 0.0,
        'alb' => guptaAlbPoints($albGdl),
        'mg' => $mgMgdl < 2.0 ? 1.0 : 0.0,
        'dose' => guptaDosePoints($cisplatinMg),
    ];

    return $p + ['score' => array_sum($p)];
}

/** CSS trieda podľa počtu rizikových faktorov Mayo MGUS (0–3). */
function mgusRiskClass(int $factors): string
{
    if ($factors <= 0) {
        return 'risk-low';
    }
    if ($factors >= 3) {
        return 'risk-high';
    }
    return 'risk-moderate';
}

/** Slovný opis rizikovej skupiny Mayo MGUS. */
function mgusRiskLabel(int $factors): string
{
    switch ($factors) {
        case 0:
            return 'nízke riziko';
        case 1:
            return 'nízko-stredné riziko';
        case 2:
            return 'stredne-vysoké riziko';
        default:
            return 'vysoké riziko';
    }
}

/** 20-ročné absolútne riziko progresie MGUS podľa počtu faktorov (Rajkumar 2005). */
function mgusProgressionPct(int $factors): int
{
    $map = [0 => 5, 1 => 21, 2 => 37, 3 => 58];
    return $map[$factors] ?? 58;
}

// Normálne referenčné rozpätie κ/λ FLC pomeru (Mayo model, Katzmann 2002).
const MGUS_FLC_LOW = 0.26;
const MGUS_FLC_HIGH = 1.65;

/**
 * Mayo riziková stratifikácia MGUS (Rajkumar SV a kol., Blood 2005;106(3):812–817,
 * PMID 15855274): M-proteín ≥ 15 g/L, izotyp iný než IgG a pomer κ/λ mimo 0,26 až 1,65.
 *
 * @return array{ratio: float, abnormal_flc: bool, high_m_protein: bool, factors: int}
 */
function mgusMayoRisk(float $mProteinGL, bool $nonIgg, float $kappaMgL, float $lambdaMgL): array
{
    if ($lambdaMgL <= 0.0) {
        throw new InvalidArgumentException('Voľné λ reťazce musia byť kladné.');
    }
    $ratio = $kappaMgL / $lambdaMgL;
    $abnormalFlc = $ratio < MGUS_FLC_LOW || $ratio > MGUS_FLC_HIGH;
    $highMProtein = $mProteinGL >= 15.0;

    return [
        'ratio' => $ratio,
        'abnormal_flc' => $abnormalFlc,
        'high_m_protein' => $highMProtein,
        'factors' => ($highMProtein ? 1 : 0) + ($nonIgg ? 1 : 0) + ($abnormalFlc ? 1 : 0),
    ];
}

/**
 * Klasifikácia MGRS podľa konsenzu IKMG (Leung N. a kol., Nat Rev Nephrol 2019;15(1):45–59,
 * PMID 30510265): hierarchické určenie kategórie.
 *
 * MGRS = klon B-buniek / plazmocytov produkujúci monoklonálny imunoglobulín, ktorý
 * spôsobuje obličkové poškodenie, ale nespĺňa kritériá hematologickej malignity
 * vyžadujúcej cielenú liečbu. Biopsia s monoklonálnymi depozitmi dokladá klon aj
 * pri negatívnom sére/moči (~30 % MGRS).
 *
 * @return array{code: string, label: string, risk_class: string}
 */
function mgrsClassify(bool $cloneEvidence, bool $biopsyMGRS, bool $clinicalRenal, bool $hasMalignancy): array
{
    $hasClone = $cloneEvidence || $biopsyMGRS;
    $hasRenal = $biopsyMGRS || $clinicalRenal;

    if ($hasMalignancy) {
        if ($hasRenal) {
            return [
                'code' => 'Malignita',
                'label' => 'paraproteinémická renálna lézia pri hematologickej malignite (mimo definície MGRS)',
                'risk_class' => 'risk-high',
            ];
        }
        return [
            'code' => 'Malignita',
            'label' => 'hematologická malignita vyžadujúca cielenú liečbu',
            'risk_class' => 'risk-high',
        ];
    }
    if ($hasClone && $hasRenal) {
        if ($biopsyMGRS) {
            return [
                'code' => 'MGRS',
                'label' => 'MGRS potvrdená obličkovou biopsiou',
                'risk_class' => 'risk-high',
            ];
        }
        return [
            'code' => 'MGRS?',
            'label' => 'MGRS pravdepodobná, nutné potvrdenie obličkovou biopsiou',
            'risk_class' => 'risk-high',
        ];
    }
    if ($hasClone) {
        return [
            'code' => 'MGUS',
            'label' => 'monoklonálna gamapatia bez doloženého renálneho významu (MGUS)',
            'risk_class' => 'risk-low',
        ];
    }
    if ($hasRenal) {
        return [
            'code' => 'Klon?',
            'label' => 'renálne postihnutie bez doloženého klonu, hľadaj okultnú monoklonálnu gamapatiu',
            'risk_class' => 'risk-moderate',
        ];
    }
    return [
        'code' => '—',
        'label' => 'nedostatok kritérií na klasifikáciu',
        'risk_class' => 'risk-low',
    ];
}

/** Nezáporné desatinné číslo; prázdny/neplatný/záporný vstup = null. */
function kdpiParseNonNeg(string $value): ?float
{
    $v = str_replace(',', '.', trim($value));
    if ($v === '' || !is_numeric($v)) {
        return null;
    }
    $f = (float) $v;
    return $f < 0 ? null : $f;
}

/**
 * Lineárny prediktor KDRI (Rao PS a kol., Transplantation 2009;88(2):231–236, PMID 19623019;
 * donor-only model používaný OPTN). Sérový kreatinín v mg/dL, výška v cm, hmotnosť v kg,
 * vek v rokoch. KDRI_Rao = exp(xbeta); referenčný darca (xbeta = 0) má KDRI = 1,00.
 *
 * Koeficienty: vek 0,0128 (úpravy < 18: −0,0194; > 50: +0,0107); výška −0,0464 / 10 cm;
 * hmotnosť < 80 kg: −0,0199 / 5 kg; afroamerický pôvod 0,1790; HTN 0,1260; DM 0,1300;
 * CVA 0,0881; kreatinín 0,2200 (nad 1,5 mg/dL: −0,2090); HCV 0,2400; DCD 0,1330.
 * OPTN stropuje sérový kreatinín pri výpočte na 8,0 mg/dL.
 */
function kdriXbeta(
    float $ageYears,
    float $heightCm,
    float $weightKg,
    float $creatMgDl,
    bool $aaRace,
    bool $htn,
    bool $dm,
    bool $cva,
    bool $hcv,
    bool $dcd
): float {
    $cr = min($creatMgDl, 8.0);

    $x = 0.0128 * ($ageYears - 40.0);
    if ($ageYears < 18.0) {
        $x += -0.0194 * ($ageYears - 18.0);
    }
    if ($ageYears > 50.0) {
        $x += 0.0107 * ($ageYears - 50.0);
    }
    $x += -0.0464 * ($heightCm - 170.0) / 10.0;
    if ($weightKg < 80.0) {
        $x += -0.0199 * ($weightKg - 80.0) / 5.0;
    }
    if ($aaRace) {
        $x += 0.1790;
    }
    if ($htn) {
        $x += 0.1260;
    }
    if ($dm) {
        $x += 0.1300;
    }
    if ($cva) {
        $x += 0.0881;
    }
    $x += 0.2200 * ($cr - 1.0);
    if ($cr > 1.5) {
        $x += -0.2090 * ($cr - 1.5);
    }
    if ($hcv) {
        $x += 0.2400;
    }
    if ($dcd) {
        $x += 0.1330;
    }
    return $x;
}

/** KDRI_Rao = exp(xbeta) voči referenčnému darcovi (KDRI = 1,00). */
function kdriRao(
    float $ageYears,
    float $heightCm,
    float $weightKg,
    float $creatMgDl,
    bool $aaRace,
    bool $htn,
    bool $dm,
    bool $cva,
    bool $hcv,
    bool $dcd
): float {
    return exp(kdriXbeta($ageYears, $heightCm, $weightKg, $creatMgDl, $aaRace, $htn, $dm, $cva, $hcv, $dcd));
}

/** CSS trieda podľa veľkosti KDRI_Rao (referenčný darca = 1,00). */
function kdriRiskClass(float $kdri): string
{
    if ($kdri < 1.0) {
        return 'risk-low';
    }
    if ($kdri < 1.45) {
        return 'risk-moderate';
    }
    return 'risk-high';
}

/** Slovný opis veľkosti KDRI_Rao. */
function kdriRiskLabel(float $kdri): string
{
    if ($kdri < 1.0) {
        return 'nižšie riziko než referenčný darca';
    }
    if ($kdri < 1.45) {
        return 'stredné riziko';
    }
    return 'vyššie riziko';
}

/**
 * Efluentová dávka CRRT: (dialyzát + substitúcia + čistá UF) [mL/h] / hmotnosť [kg].
 * Dodaná dávka odpočíta podiel výpadku času. Cieľ dodanej dávky 20 až 25 mL/kg/h
 * (KDIGO AKI 2012, odporúčanie 5.8.1). Bez korekcie na prediluciu.
 *
 * @return array{effluent: float, prescribed: float, delivered: float} mL/h, mL/kg/h, mL/kg/h
 */
function calculatorCrrtEffluentDose(float $dialysateMlH, float $replacementMlH, float $netUfMlH, float $weightKg, float $downtimePct): array
{
    if ($weightKg <= 0.0) {
        throw new InvalidArgumentException('Hmotnosť musí byť kladná.');
    }
    $effluent = $dialysateMlH + $replacementMlH + $netUfMlH;
    $prescribed = $effluent / $weightKg;

    return [
        'effluent' => $effluent,
        'prescribed' => $prescribed,
        'delivered' => $prescribed * (1.0 - $downtimePct / 100.0),
    ];
}

/** CSS trieda podľa dodanej efluentovej dávky voči cieľu KDIGO (20–25 mL/kg/h). */
function crrtDoseClass(float $dose): string
{
    if ($dose < 20.0) {
        return 'risk-high';        // poddávkovanie
    }
    if ($dose <= 30.0) {
        return 'risk-low';         // cieľ + bežná rezerva na výpadky
    }
    return 'risk-moderate';        // nadmerná dávka
}

/** Slovný opis pásma dávky. */
function crrtDoseLabel(float $dose): string
{
    if ($dose < 20.0) {
        return 'pod cieľom KDIGO';
    }
    if ($dose <= 25.0) {
        return 'cieľové pásmo KDIGO';
    }
    if ($dose <= 30.0) {
        return 'prijateľná rezerva';
    }
    return 'nad cieľom';
}

/**
 * Furstov pomer elektrolytov moču a plazmy: (U_Na + U_K) / S_Na
 * (Furst H a kol., Am J Med Sci 2000;319(4):240–244, PMID 10768609).
 */
function calculatorFurstRatio(float $urineNa, float $urineK, float $serumNa): float
{
    if ($serumNa <= 0.0) {
        throw new InvalidArgumentException('Sérový sodík musí byť kladný.');
    }

    return ($urineNa + $urineK) / $serumNa;
}

/** CSS trieda podľa Furstovho pomeru (U_Na+U_K)/S_Na. */
function furstClass(float $ratio): string
{
    if ($ratio < 0.5) {
        return 'risk-low';         // reštrikcia < 1000 mL/deň účinná
    }
    if ($ratio <= 1.0) {
        return 'risk-moderate';    // prísna reštrikcia < 500 mL/deň
    }
    return 'risk-high';            // reštrikcia tekutín neúčinná
}

/** Slovný opis pásma Furstovho pomeru. */
function furstLabel(float $ratio): string
{
    if ($ratio < 0.5) {
        return 'reštrikcia < 1000 mL/deň účinná';
    }
    if ($ratio <= 1.0) {
        return 'prísna reštrikcia < 500 mL/deň';
    }
    return 'reštrikcia tekutín neúčinná';
}

/**
 * Frakčná exkrécia látky v %: (U_x · S_cr) / (S_x · U_cr) · 100.
 * U_x a S_x v rovnakej jednotke, U_cr a S_cr v rovnakej jednotke.
 */
function calculatorFractionalExcretion(float $urineX, float $serumX, float $urineCr, float $serumCr): float
{
    if ($serumX <= 0.0 || $urineCr <= 0.0) {
        throw new InvalidArgumentException('Sérová koncentrácia aj kreatinín v moči musia byť kladné.');
    }

    return (($urineX * $serumCr) / ($serumX * $urineCr)) * 100.0;
}

/** Slovné hodnotenie FENa: < 1 % prerenálne, > 2 % ATN. */
function akiFenaInterpretation(float $fena): string
{
    if ($fena < 1.0) {
        return "Prerenálne zlyhanie (často < 1 %)";
    }
    if ($fena > 2.0) {
        return "Akútna tubulárna nekróza - ATN (často > 2 %)";
    }

    return "Hraničná hodnota (zmiešaná etiológia)";
}

/**
 * Slovné hodnotenie FEurea: < 35 % prerenálne, > 50 % ATN. Carvounis a kol.
 * (Kidney Int 2002;62(6):2223–2229, PMID 12427149) uvádzajú prerenálne ≤ 35 %.
 */
function akiFeureaInterpretation(float $feurea): string
{
    if ($feurea < 35.0) {
        return "Prerenálne zlyhanie (často < 35 %)";
    }
    if ($feurea > 50.0) {
        return "Akútna tubulárna nekróza - ATN (často > 50 %)";
    }

    return "Hraničná hodnota (zmiešaná etiológia)";
}

/**
 * Korigovaný celkový vápnik pri hypoalbuminémii: Ca + 0,02 · (40 − albumín) v mmol/L
 * (albumín v g/L). Ide o bežne používaný tvar (0,8 mg/dL na 1 g/dL); Payne a kol.
 * (Br Med J 1973;4(5893):643–646, PMID 4758544) odvodili v mg/dL koeficient 1,0.
 */
function calculatorCorrectedCalcium(float $calciumMmolL, float $albuminGL): float
{
    return $calciumMmolL + 0.02 * (40.0 - $albuminGL);
}

/** Referenčná AG (mmol/L) pre ΔAG vo výpočte Δ/Δ pomeru. */
const ACIDBASE_NORMAL_AG = 12.0;
/** Referenčný HCO₃ (mmol/L) pre ΔHCO₃. */
const ACIDBASE_NORMAL_HCO3 = 24.0;
/** Normálny albumín (g/L) vo Figgeho korekcii. */
const ACIDBASE_NORMAL_ALBUMIN_GL = 40.0;
/** Figge: +0,25 mmol/L AG na každý g/L poklesu albumínu (PMID 9824071). */
const ACIDBASE_ALBUMIN_CORR_PER_GL = 0.25;
/** Minimálna |ΔHCO₃| pre spoľahlivý Δ/Δ pomer. */
const ACIDBASE_DELTA_HCO3_MIN = 0.5;

/**
 * Aniónová medzera, korekcia na albumín a Δ/Δ pomer.
 *
 * AG = Na − (Cl + HCO₃). Korekcia: AG + 0,25 · (40 − albumín g/L)
 * (Figge J a kol., Crit Care Med 1998;26(11):1807–1810, PMID 9824071).
 * Δ-ratio = (AG_korig − 12) / (24 − HCO₃); pásma < 0,4 / < 0,8 / < 2,0 sú
 * výučbová konvencia (Rastegar A, J Am Soc Nephrol 2007;18(9):2429–2431,
 * PMID 17656477, upozorňuje na široký individuálny rozptyl).
 *
 * @return array{
 *   ag: float,
 *   corrected_ag: float,
 *   delta_ratio: ?float,
 *   interpretation: string,
 *   na: float,
 *   cl: float,
 *   hco3: float,
 *   alb: float
 * }
 */
function calculatorAnionGapAnalysis(
    float $na,
    float $cl,
    float $hco3,
    float $albuminGL = ACIDBASE_NORMAL_ALBUMIN_GL
): array {
    $ag = $na - ($cl + $hco3);
    $correctedAg = $ag + ACIDBASE_ALBUMIN_CORR_PER_GL * (ACIDBASE_NORMAL_ALBUMIN_GL - $albuminGL);
    $deltaGap = $correctedAg - ACIDBASE_NORMAL_AG;
    $deltaHco3 = ACIDBASE_NORMAL_HCO3 - $hco3;

    $deltaRatio = null;
    $interpretation = '';

    if (abs($deltaHco3) > ACIDBASE_DELTA_HCO3_MIN) {
        $deltaRatio = $deltaGap / $deltaHco3;
        $interpretation = calculatorAnionGapDeltaInterpretation($deltaRatio);
    } else {
        $interpretation = 'Delta HCO3 je príliš blízko nule pre výpočet Delta pomeru.';
    }

    return [
        'ag' => round($ag, 1),
        'corrected_ag' => round($correctedAg, 1),
        'delta_ratio' => $deltaRatio !== null ? round($deltaRatio, 2) : null,
        'interpretation' => $interpretation,
        'na' => round($na, 1),
        'cl' => round($cl, 1),
        'hco3' => round($hco3, 1),
        'alb' => round($albuminGL, 1),
    ];
}

/** Slovná interpretácia Δ/Δ pomeru podľa výučbových pásiem. */
function calculatorAnionGapDeltaInterpretation(float $deltaRatio): string
{
    if ($deltaRatio < 0.4) {
        return 'Hyperchloremická (normálna AG) metabolická acidóza.';
    }
    if ($deltaRatio < 0.8) {
        return 'Zmiešaná high-AG a normálna-AG metabolická acidóza.';
    }
    if ($deltaRatio < 2.0) {
        return 'Čistá high-AG metabolická acidóza.';
    }

    return 'High-AG metabolická acidóza + súbežná metabolická alkalóza alebo chronická respiračná acidóza.';
}

/** Winters: očakávané pCO₂ = 1,5 · HCO₃ + 8 (± 2 mmHg) pri metabolickej acidóze. */
const ACIDBASE_WINTERS_SLOPE = 1.5;
const ACIDBASE_WINTERS_INTERCEPT = 8.0;
const ACIDBASE_WINTERS_TOLERANCE_MMHG = 2.0;

/** Javaheri: očakávané pCO₂ = 0,7 · HCO₃ + 20 (± 5 mmHg) pri metabolickej alkalóze. */
const ACIDBASE_ALKALOSIS_SLOPE = 0.7;
const ACIDBASE_ALKALOSIS_INTERCEPT = 20.0;
const ACIDBASE_ALKALOSIS_TOLERANCE_MMHG = 5.0;

/**
 * Wintersova rovnica: očakávané pCO₂ pri primárnej metabolickej acidóze.
 *
 * expected_pCO₂ = 1,5 · [HCO₃⁻] + 8 (± 2 mmHg)
 * (Albert MS, Dell RB, Winters RW, Ann Intern Med 1967;66(2):312–322, PMID 6016545).
 * Platí len pri HCO₃ < 24 mmol/L; inak null.
 *
 * @return array{
 *   applicable: bool,
 *   expected_pco2: ?float,
 *   expected_pco2_low: ?float,
 *   expected_pco2_high: ?float,
 *   measured_pco2: ?float,
 *   interpretation: string
 * }|null null len pri neaplikovateľnom HCO₃ (nie acidóza)
 */
function calculatorWintersCompensation(float $hco3, ?float $measuredPco2 = null): ?array
{
    if ($hco3 >= ACIDBASE_NORMAL_HCO3) {
        return null;
    }

    $expected = ACIDBASE_WINTERS_SLOPE * $hco3 + ACIDBASE_WINTERS_INTERCEPT;
    $low = $expected - ACIDBASE_WINTERS_TOLERANCE_MMHG;
    $high = $expected + ACIDBASE_WINTERS_TOLERANCE_MMHG;
    $interpretation = calculatorWintersCompensationInterpretation($measuredPco2, $low, $high);

    return [
        'applicable' => true,
        'expected_pco2' => round($expected, 1),
        'expected_pco2_low' => round($low, 1),
        'expected_pco2_high' => round($high, 1),
        'measured_pco2' => $measuredPco2 !== null ? round($measuredPco2, 1) : null,
        'interpretation' => $interpretation,
    ];
}

/** Slovná interpretácia nameraného pCO₂ voči Wintersovmu pásmu ± 2 mmHg. */
function calculatorWintersCompensationInterpretation(
    ?float $measuredPco2,
    float $expectedLow,
    float $expectedHigh
): string {
    if ($measuredPco2 === null) {
        return 'Wintersova kompenzácia: očakávané pCO₂ pri metabolickej acidóze (bez nameranej hodnoty).';
    }
    if ($measuredPco2 < $expectedLow) {
        return 'Namerané pCO₂ je nižšie než Wintersovo pásmo: súbežná respiračná alkalóza.';
    }
    if ($measuredPco2 > $expectedHigh) {
        return 'Namerané pCO₂ je vyššie než Wintersovo pásmo: súbežná respiračná acidóza (nedostatočná kompenzácia).';
    }

    return 'Namerané pCO₂ je v Wintersovom pásme: primeraná respiračná kompenzácia.';
}

/**
 * Očakávané pCO₂ pri primárnej metabolickej alkalóze (kompenzačná hypoventilácia).
 *
 * expected_pCO₂ = 0,7 · [HCO₃⁻] + 20 (± 5 mmHg)
 * (Javaheri S, Shore NS, Rose B, Kazemi H, Chest 1982;81(3):296–301, PMID 6799256).
 * Pásmo ± 5 mmHg je výučbová konštanta (Brandis); pôvodná práca uvádza lineárny vzťah ± SEM.
 * Platí len pri HCO₃ > 24 mmol/L; inak null.
 *
 * @return array{
 *   applicable: bool,
 *   expected_pco2: ?float,
 *   expected_pco2_low: ?float,
 *   expected_pco2_high: ?float,
 *   measured_pco2: ?float,
 *   interpretation: string
 * }|null null len pri neaplikovateľnom HCO₃ (nie alkalóza)
 */
function calculatorMetabolicAlkalosisCompensation(float $hco3, ?float $measuredPco2 = null): ?array
{
    if ($hco3 <= ACIDBASE_NORMAL_HCO3) {
        return null;
    }

    $expected = ACIDBASE_ALKALOSIS_SLOPE * $hco3 + ACIDBASE_ALKALOSIS_INTERCEPT;
    $low = $expected - ACIDBASE_ALKALOSIS_TOLERANCE_MMHG;
    $high = $expected + ACIDBASE_ALKALOSIS_TOLERANCE_MMHG;
    $interpretation = calculatorMetabolicAlkalosisCompensationInterpretation($measuredPco2, $low, $high);

    return [
        'applicable' => true,
        'expected_pco2' => round($expected, 1),
        'expected_pco2_low' => round($low, 1),
        'expected_pco2_high' => round($high, 1),
        'measured_pco2' => $measuredPco2 !== null ? round($measuredPco2, 1) : null,
        'interpretation' => $interpretation,
    ];
}

/** Slovná interpretácia nameraného pCO₂ voči pásmu metabolickej alkalózy ± 5 mmHg. */
function calculatorMetabolicAlkalosisCompensationInterpretation(
    ?float $measuredPco2,
    float $expectedLow,
    float $expectedHigh
): string {
    if ($measuredPco2 === null) {
        return 'Kompenzácia pri metabolickej alkalóze: očakávané pCO₂ (bez nameranej hodnoty).';
    }
    if ($measuredPco2 < $expectedLow) {
        return 'Namerané pCO₂ je nižšie než očakávané pásmo: súbežná respiračná alkalóza (nedostatočná hypoventilácia).';
    }
    if ($measuredPco2 > $expectedHigh) {
        return 'Namerané pCO₂ je vyššie než očakávané pásmo: súbežná respiračná acidóza.';
    }

    return 'Namerané pCO₂ je v očakávanom pásme: primeraná respiračná kompenzácia.';
}

/**
 * Sklon lineárnej regresie metódou najmenších štvorcov (y na x).
 * Null pri menej ako 2 bodoch alebo nulovom rozptyle x.
 *
 * @param list<float> $x
 * @param list<float> $y
 */
function calculatorOlsSlope(array $x, array $y): ?float
{
    $n = count($x);
    if ($n < 2 || $n !== count($y)) {
        return null;
    }
    $meanX = array_sum($x) / $n;
    $meanY = array_sum($y) / $n;
    $num = $den = 0.0;
    for ($i = 0; $i < $n; $i++) {
        $num += ($x[$i] - $meanX) * ($y[$i] - $meanY);
        $den += ($x[$i] - $meanX) ** 2;
    }

    return $den == 0.0 ? null : $num / $den;
}

/**
 * Slovné hodnotenie sklonu eGFR (mL/min/1,73 m² za rok). Pokles rýchlejší než
 * 5 za rok zodpovedá rýchlej progresii podľa KDIGO.
 */
function egfrSlopeInterpretation(float $slope): string
{
    if ($slope < -5) {
        return "Rýchla progresia CKD (> 5 ml/min/rok). Zvážte zintenzívnenie liečby (SGLT2i, RASi) a dispenzarizáciu.";
    }
    if ($slope < -2) {
        return "Stredne rýchla progresia. Prirodzený vekový pokles je zvyčajne okolo 1 ml/min/rok.";
    }
    if ($slope > 0) {
        return "eGFR sa v čase zlepšuje alebo je stabilné.";
    }

    return "Pomalá progresia, blízka fyziologickému starnutiu.";
}

/**
 * Meraný klírens kreatinínu zo zberu moču: (U_cr · V) / (P_cr · T) v mL/min.
 * U_cr a P_cr v rovnakej jednotke, V v mL, T v hodinách.
 */
function calculatorMeasuredCreatinineClearance(float $urineCr, float $urineMl, float $plasmaCr, float $hours): float
{
    if ($plasmaCr <= 0.0 || $hours <= 0.0) {
        throw new InvalidArgumentException('Plazmatický kreatinín aj čas zberu musia byť kladné.');
    }

    return ($urineCr * $urineMl) / ($plasmaCr * $hours * 60.0);
}

/**
 * Povrch tela podľa Du Boisa a Du Boisa (1916): 0,007184 · výška[cm]^0,725 · hmotnosť[kg]^0,425 (m²).
 */
function calculatorBsaDuBois(float $heightCm, float $weightKg): float
{
    return 0.007184 * pow($heightCm, 0.725) * pow($weightKg, 0.425);
}

/**
 * Podiel celkovej telesnej vody na hmotnosti pri poruchách nátria
 * (Adrogué a Madias, N Engl J Med 2000;342(20):1493–1499, PMID 10816188):
 * muži 0,6 (od 65 r 0,5), ženy 0,5 (od 65 r 0,45).
 */
function calculatorTbwFraction(string $sex, int $ageYears): float
{
    if ($sex === 'male') {
        return $ageYears >= 65 ? 0.5 : 0.6;
    }

    return $ageYears >= 65 ? 0.45 : 0.5;
}

/**
 * Deficit voľnej vody v litroch: TBW · (S-Na / cieľové Na − 1).
 */
function calculatorFreeWaterDeficit(float $tbwLiters, float $serumNa, float $targetNa): float
{
    if ($targetNa <= 0.0) {
        throw new InvalidArgumentException('Cieľové nátrium musí byť kladné.');
    }

    return $tbwLiters * ($serumNa / $targetNa - 1.0);
}

/**
 * Adrogué–Madias: zmena S-Na po 1 L infúzie = (Na_inf + K_inf − S-Na) / (TBW + 1)
 * (N Engl J Med 2000;342(21):1581–1589, PMID 10824078).
 */
function calculatorAdrogueMadias(float $infusateNa, float $infusateK, float $serumNa, float $tbwLiters): float
{
    return ($infusateNa + $infusateK - $serumNa) / ($tbwLiters + 1.0);
}

/**
 * Korekcia S-Na na hyperglykémiu: S-Na + koeficient · (glykémia[mg/dL] − 100) / 100.
 * Koeficient 1,6 (Katz, N Engl J Med 1973;289(16):843–844, PMID 4763428)
 * alebo 2,4 (Hillier a kol., Am J Med 1999;106(4):399–403, PMID 10225241).
 */
function calculatorSodiumGlucoseCorrection(float $serumNa, float $glucoseMgDl, float $coefficient): float
{
    return $serumNa + $coefficient * ($glucoseMgDl - 100.0) / 100.0;
}

/** mg/dL → µmol/L. */
function creatinineMgDlToUmolL(float $mgDl): float
{
    return $mgDl * CREATININE_UMOL_PER_MGDL;
}

/** µmol/L → mg/dL. */
function creatinineUmolLToMgDl(float $umolL): float
{
    return $umolL / CREATININE_UMOL_PER_MGDL;
}

/** mg/dL → mmol/L (88,4 / 1000). */
function creatinineMgDlToMmolL(float $mgDl): float
{
    return $mgDl * CREATININE_UMOL_PER_MGDL / 1000.0;
}

/** mmol/L → g/L (MW kreatinínu). */
function creatinineMmolLToGL(float $mmolL): float
{
    return ($mmolL * CREATININE_MOLAR_MASS_G_PER_MOL) / 1000.0;
}

/** BUN mg/dL → urea mmol/L. */
function bunMgDlToUreaMmolL(float $bunMgDl): float
{
    return $bunMgDl * BUN_MGDL_TO_UREA_MMOLL;
}

/** Urea mmol/L → BUN mg/dL. */
function ureaMmolLToBunMgDl(float $ureaMmolL): float
{
    return $ureaMmolL * UREA_MMOLL_TO_BUN_MGDL;
}

/** Glukóza mg/dL → mmol/L. */
function glucoseMgDlToMmolL(float $mgDl): float
{
    return $mgDl * GLUCOSE_MGDL_TO_MMOLL;
}

/** Glukóza mmol/L → mg/dL. */
function glucoseMmolLToMgDl(float $mmolL): float
{
    return $mmolL * GLUCOSE_MMOLL_TO_MGDL;
}

/** Vápnik mg/dL → mmol/L. */
function calciumMgDlToMmolL(float $mgDl): float
{
    return $mgDl * CALCIUM_MGDL_TO_MMOLL;
}

/** Vápnik mmol/L → mg/dL. */
function calciumMmolLToMgDl(float $mmolL): float
{
    return $mmolL * CALCIUM_MMOLL_TO_MGDL;
}

/** Fosfát (P) mg/dL → mmol/L. */
function phosphateMgDlToMmolL(float $mgDl): float
{
    return $mgDl * PHOSPHATE_MGDL_TO_MMOLL;
}

/** Fosfát (P) mmol/L → mg/dL. */
function phosphateMmolLToMgDl(float $mmolL): float
{
    return $mmolL * PHOSPHATE_MMOLL_TO_MGDL;
}

/** Magnézium mg/dL → mmol/L. */
function magnesiumMgDlToMmolL(float $mgDl): float
{
    return $mgDl * MAGNESIUM_MGDL_TO_MMOLL;
}

/** Magnézium mmol/L → mg/dL. */
function magnesiumMmolLToMgDl(float $mmolL): float
{
    return $mmolL * MAGNESIUM_MMOLL_TO_MGDL;
}

/** UACR mg/mmol → mg/g. */
function uacrMgMmolToMgG(float $mgMmol): float
{
    return $mgMmol * UACR_MG_G_PER_MG_MMOL;
}

/** UACR mg/g → mg/mmol. */
function uacrMgGToMgMmol(float $mgG): float
{
    return $mgG / UACR_MG_G_PER_MG_MMOL;
}

/**
 * UACR na kanonické mg/g podľa jednotky vstupu.
 * Jednotky: mg_mmol, mg_g (iné → bez prepočtu, ako doteraz).
 */
function uacrToMgG(float $value, string $unit): float
{
    return $unit === 'mg_mmol' ? uacrMgMmolToMgG($value) : $value;
}

/**
 * Prepočet koncentrácie kreatinínu na mg/dL.
 * Jednotky: umol_l, mmol_l, mg_dl (iné → bez prepočtu, ako doteraz pri CrCl).
 */
function crclCreatinineToMgDl(float $value, string $unit): float
{
    return match ($unit) {
        'umol_l' => creatinineUmolLToMgDl($value),
        'mmol_l' => creatinineUmolLToMgDl($value * 1000.0),
        default => $value, // mg_dl
    };
}

/**
 * Klírens kreatinínu podľa Cockcrofta a Gaulta (Nephron 1976;16(1):31–41, PMID 1244564):
 * (140 − vek) · hmotnosť [kg] / (72 · S-kreatinín [mg/dL]), u žien × 0,85. Výsledok v mL/min.
 */
function calculatorCockcroftGault(int $ageYears, float $weightKg, float $sCrMgDl, string $sex): float
{
    if ($sCrMgDl <= 0.0) {
        throw new InvalidArgumentException('S-kreatinín musí byť kladný.');
    }
    $crcl = ((140 - $ageYears) * $weightKg) / (72.0 * $sCrMgDl);

    return $sex === 'female' ? $crcl * 0.85 : $crcl;
}

/**
 * Recirkulácia v cievnom prístupe metódou troch vzoriek močoviny:
 * R [%] = (C_P − C_A) / (C_P − C_V) · 100. Záporná hodnota (A > P) znamená
 * chybu odberu; o orezaní na nulu rozhoduje volajúci.
 */
function calculatorUreaRecirculationPct(float $systemic, float $arterial, float $venous): float
{
    if ($systemic - $venous <= 0.0) {
        throw new InvalidArgumentException('Systémová koncentrácia musí byť vyššia než venózna.');
    }

    return (($systemic - $arterial) / ($systemic - $venous)) * 100.0;
}

/**
 * Klasický klírens voľnej vody: C_osm = U_osm · V / P_osm, C_H2O = V − C_osm (mL/min).
 *
 * @return array{c_osm: float, c_h2o: float}
 */
function calculatorFreeWaterClearance(float $urineMlMin, float $urineOsm, float $plasmaOsm): array
{
    if ($plasmaOsm <= 0.0) {
        throw new InvalidArgumentException('Osmolalita plazmy musí byť kladná.');
    }
    $cOsm = ($urineOsm * $urineMlMin) / $plasmaOsm;

    return ['c_osm' => $cOsm, 'c_h2o' => $urineMlMin - $cOsm];
}

/**
 * Elektrolytový klírens voľnej vody: V · (1 − (U_Na + U_K) / P_Na) v mL/min.
 */
function calculatorElectrolyteFreeWaterClearance(float $urineMlMin, float $urineNa, float $urineK, float $plasmaNa): float
{
    if ($plasmaNa <= 0.0) {
        throw new InvalidArgumentException('Nátrium v plazme musí byť kladné.');
    }

    return $urineMlMin * (1.0 - ($urineNa + $urineK) / $plasmaNa);
}

/** CSS trieda podľa miery recirkulácie (urea-based periférna/slow-flow metóda). */
function recircClass(float $pct): string
{
    if ($pct <= 5.0) {
        return 'risk-low';         // bez významnej recirkulácie
    }
    if ($pct <= 10.0) {
        return 'risk-moderate';    // hraničné — over techniku/polohu ihiel
    }
    return 'risk-high';            // významná recirkulácia
}

/** Slovný opis pásma recirkulácie. */
function recircLabel(float $pct): string
{
    if ($pct <= 5.0) {
        return 'bez významnej recirkulácie';
    }
    if ($pct <= 10.0) {
        return 'hraničná recirkulácia';
    }
    return 'významná recirkulácia';
}

/** CSS trieda podľa elektrolytového klírensu voľnej vody (tendencia nátriémie). */
function fwcClass(float $efwc): string
{
    // EFWC > 0 → tendencia ↑ Na (vylučovanie voľnej vody); < 0 → tendencia ↓ Na.
    if ($efwc < -0.5) {
        return 'risk-high';      // retencia voľnej vody → riziko poklesu Na (SIADH)
    }
    if ($efwc > 0.5) {
        return 'risk-moderate';  // strata voľnej vody → riziko vzostupu Na
    }
    return 'risk-low';           // približne neutrálne
}

/**
 * spKt/V podľa Daugirdasa II (J Am Soc Nephrol 1993;4(5):1205–1213, PMID 8305648):
 * −ln(R − 0,008·t) + (4 − 3,5·R)·UF/W. R = U_post/U_pre, t v hodinách,
 * UF v litroch, W = hmotnosť po dialýze v kg. Null, ak logaritmus nie je definovaný.
 */
function calculatorKtvDaugirdas2(float $ratio, float $hours, float $ufLiters, float $weightPostKg): ?float
{
    $logTerm = $ratio - 0.008 * $hours;
    if ($logTerm <= 0.0 || $weightPostKg <= 0.0) {
        return null;
    }

    return -log($logTerm) + (4.0 - 3.5 * $ratio) * ($ufLiters / $weightPostKg);
}

/** Watson odhad celkovej telesnej vody (TBW, L). */
function npcrWatsonTbw(string $sex, int $age, float $heightCm, float $weightKg): float
{
    if ($sex === "male") {
        return 2.447 - 0.09516 * $age + 0.1074 * $heightCm + 0.3362 * $weightKg;
    }
    // female
    return -2.097 + 0.1069 * $heightCm + 0.2466 * $weightKg;
}

/** Prepočet močoviny/BUN na BUN (urea-nitrogen) v mg/dL. */
function npcrToBunMgDl(float $value, string $unit): float
{
    // urea mmol/L → BUN mg/dL cez UREA_MMOLL_TO_BUN_MGDL; bun_mg_dl je už BUN mg/dL
    return $unit === "mmol_l" ? ureaMmolLToBunMgDl($value) : $value;
}

/**
 * Riziková kategória pre nPCR/nPNA (g/kg/deň).
 * @return array{0:string,1:string} [trieda, popis]
 */
function npcrCategory(float $npcr): array
{
    if ($npcr < 0.8) {
        return ['risk-high', 'Nízky príjem bielkovín: riziko malnutrície'];
    }
    if ($npcr < 1.0) {
        return ['risk-moderate', 'Hraničný príjem'];
    }
    if ($npcr <= 1.4) {
        return ['risk-low', 'Cieľové rozpätie (1,0 až 1,4)'];
    }

    return ['risk-moderate', 'Vysoký: hyperkatabolizmus alebo vysoký príjem'];
}

/**
 * nPCR (nPNA) v g/kg/deň podľa Sargenta a Gotcha pre anurického pacienta:
 * G [mg/min] = ΔBUN [mg/dL] · V [dL] / interval [min]; PCR = 9,35·G + 0,294·V [L];
 * normalizácia na V/0,58. BUN pred dialýzou a po predošlej dialýze.
 *
 * @return array{g_mg_min: float, pcr: float, npcr: float} G [mg/min], PCR [g/deň], nPCR [g/kg/deň]
 */
function npcrSargentGotch(float $bunPreMgDl, float $bunPostPrevMgDl, float $tbwLiters, float $interdialyticHours): array
{
    $gMgMin = (($bunPreMgDl - $bunPostPrevMgDl) * ($tbwLiters * 10.0)) / ($interdialyticHours * 60.0);
    $pcr = 9.35 * $gMgMin + 0.294 * $tbwLiters;

    return ['g_mg_min' => $gMgMin, 'pcr' => $pcr, 'npcr' => 0.58 * $pcr / $tbwLiters];
}

/**
 * UACR v mg/mmol z albumínu [mg/L] a kreatinínu v moči [mmol/L].
 */
function calculatorUacrMgMmol(float $albuminMgL, float $creatinineMmolL): float
{
    if ($creatinineMmolL <= 0.0) {
        throw new InvalidArgumentException('Kreatinín v moči musí byť kladný.');
    }

    return $albuminMgL / $creatinineMmolL;
}

/**
 * UACR v mg/g z albumínu [mg/L] a kreatinínu v moči [mmol/L]
 * (MW kreatinínu = CREATININE_MOLAR_MASS_G_PER_MOL).
 */
function calculatorUacrMgG(float $albuminMgL, float $creatinineMmolL): float
{
    if ($creatinineMmolL <= 0.0) {
        throw new InvalidArgumentException('Kreatinín v moči musí byť kladný.');
    }

    $creatinineGL = creatinineMmolLToGL($creatinineMmolL);
    if ($creatinineGL <= 0.0) {
        throw new InvalidArgumentException('Kreatinín v moči musí byť kladný.');
    }

    return $albuminMgL / $creatinineGL;
}

/**
 * KDIGO A1/A2/A3 podľa UACR v mg/mmol.
 *
 * @return array{stage: string, desc: string}
 */
function calculatorUacrACategory(float $uacrMgMmol): array
{
    if ($uacrMgMmol < 3.0) {
        return [
            'stage' => 'A1',
            'desc' => 'Normálna až mierne zvýšená albuminúria',
        ];
    }
    if ($uacrMgMmol <= 30.0) {
        return [
            'stage' => 'A2',
            'desc' => 'Stredne zvýšená albuminúria (mikroalbuminúria)',
        ];
    }

    return [
        'stage' => 'A3',
        'desc' => 'Výrazne zvýšená albuminúria (makroalbuminúria)',
    ];
}

/** Renálne body podľa eGFR (mL/min/1,73 m²) — Mehran 2004. */
function mehranRenalPoints(float $egfr): int
{
    if ($egfr >= 60.0) {
        return 0;
    }
    if ($egfr >= 40.0) {
        return 2;
    }
    if ($egfr >= 20.0) {
        return 4;
    }

    return 6;
}

/**
 * Mehran skóre rizika CI-AKI po PCI (Mehran R a kol., J Am Coll Cardiol 2004;44(7):1393–1399,
 * PMID 15464318). Hypotenzia / IABP / CHF NYHA III–IV: po 5; vek > 75: 4; anémia / diabetes: po 3;
 * kontrast ≈ 1 bod / 100 mL; eGFR pásma cez mehranRenalPoints().
 *
 * @return array{
 *     score: int,
 *     age_pts: int,
 *     renal_pts: int,
 *     contrast_pts: int,
 *     hypotension_pts: int,
 *     iabp_pts: int,
 *     chf_pts: int,
 *     anemia_pts: int,
 *     diabetes_pts: int
 * }
 */
function mehranScore(
    int $ageYears,
    float $egfr,
    float $contrastVolumeMl,
    bool $hypotension,
    bool $iabp,
    bool $chf,
    bool $anemia,
    bool $diabetes
): array {
    $agePts = $ageYears > 75 ? 4 : 0;
    $renalPts = mehranRenalPoints($egfr);
    $contrastPts = (int) round($contrastVolumeMl / 100.0);
    $hypotensionPts = $hypotension ? 5 : 0;
    $iabpPts = $iabp ? 5 : 0;
    $chfPts = $chf ? 5 : 0;
    $anemiaPts = $anemia ? 3 : 0;
    $diabetesPts = $diabetes ? 3 : 0;

    return [
        'score' => $hypotensionPts + $iabpPts + $chfPts + $agePts + $anemiaPts
            + $diabetesPts + $contrastPts + $renalPts,
        'age_pts' => $agePts,
        'renal_pts' => $renalPts,
        'contrast_pts' => $contrastPts,
        'hypotension_pts' => $hypotensionPts,
        'iabp_pts' => $iabpPts,
        'chf_pts' => $chfPts,
        'anemia_pts' => $anemiaPts,
        'diabetes_pts' => $diabetesPts,
    ];
}

/**
 * Riziková kategória pre celkové Mehran skóre.
 *
 * @return array{0:string,1:string,2:string,3:string} [trieda, popis, CIN %, dialýza %]
 */
function mehranCategory(int $score): array
{
    if ($score <= 5) {
        return ['risk-low', 'Nízke riziko', '7,5 %', '0,04 %'];
    }
    if ($score <= 10) {
        return ['risk-moderate', 'Stredné riziko', '14,0 %', '0,12 %'];
    }
    if ($score <= 15) {
        return ['risk-high', 'Vysoké riziko', '26,1 %', '1,09 %'];
    }

    return ['risk-very-high', 'Veľmi vysoké riziko', '57,3 %', '12,6 %'];
}

/**
 * Konverzné riadky prevodníka jednotiek.
 *
 * SI = konvenčné × faktor. Zhodné s dokumentovanými reciprokami projektu
 * (cholesterol ÷ 38,67; glukóza ÷ 18; triglyceridy ÷ 88,57) a eGFR ÷ 60.
 *
 * @return list<array{0:string,1:string,2:string,3:float,4:int,5:int}>
 *   [analyt, konv. jednotka, SI jednotka, faktor, dec_konv, dec_si]
 */
function calculatorUnitConversionRows(): array
{
    return [
        ['Kreatinín', 'mg/dL', 'µmol/L', CREATININE_UMOL_PER_MGDL, 2, 0],
        ['Urea (BUN)', 'mg/dL (BUN)', 'mmol/L (urea)', BUN_MGDL_TO_UREA_MMOLL, 1, 1],
        ['Glukóza', 'mg/dL', 'mmol/L', GLUCOSE_MGDL_TO_MMOLL, 0, 1],
        ['Vápnik', 'mg/dL', 'mmol/L', CALCIUM_MGDL_TO_MMOLL, 1, 2],
        ['Fosfát (P)', 'mg/dL', 'mmol/L', PHOSPHATE_MGDL_TO_MMOLL, 1, 2],
        ['Magnézium', 'mg/dL', 'mmol/L', MAGNESIUM_MGDL_TO_MMOLL, 1, 2],
        ['Kyselina močová', 'mg/dL', 'µmol/L', 59.48, 1, 0],
        ['Cholesterol', 'mg/dL', 'mmol/L', 0.02586, 0, 2],
        ['Triglyceridy', 'mg/dL', 'mmol/L', 0.01129, 0, 2],
        ['Hemoglobín', 'g/dL', 'g/L', 10.0, 1, 0],
        ['Albumín', 'g/dL', 'g/L', 10.0, 1, 0],
        ['Bilirubín', 'mg/dL', 'µmol/L', 17.1, 1, 0],
        ['eGFR', 'ml/min/1,73 m²', 'ml/s/1,73 m²', 1 / 60, 1, 3],
    ];
}

/** SI = konvenčné × faktor. */
function calculatorConvertConventionalToSi(float $conventional, float $factor): float
{
    return $conventional * $factor;
}

/** Konvenčné = SI ÷ faktor. */
function calculatorConvertSiToConventional(float $si, float $factor): float
{
    if ($factor == 0.0) {
        throw new InvalidArgumentException('Konverzný faktor nesmie byť nula.');
    }

    return $si / $factor;
}

/**
 * Faktor podľa názvu analytu (presná zhoda s calculatorUnitConversionRows).
 *
 * @return array{factor: float, dec_conv: int, dec_si: int}|null
 */
function calculatorUnitFactorByName(string $name): ?array
{
    foreach (calculatorUnitConversionRows() as $row) {
        if ($row[0] === $name) {
            return [
                'factor' => (float) $row[3],
                'dec_conv' => (int) $row[4],
                'dec_si' => (int) $row[5],
            ];
        }
    }

    return null;
}

function ckdGCategory(float $value): string
{
    if ($value >= 90.0) {
        return 'G1';
    }
    if ($value >= 60.0) {
        return 'G2';
    }
    if ($value >= 45.0) {
        return 'G3a';
    }
    if ($value >= 30.0) {
        return 'G3b';
    }
    if ($value >= 15.0) {
        return 'G4';
    }

    return 'G5';
}

function ckdGCategoryDescription(string $category): string
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

function calculatorSaveResult(
    PDO $pdo,
    int $userId,
    string $calculatorKey,
    string $calculatorLabel,
    array $patient,
    array $inputPayload,
    array $resultPayload
): bool {
    $stmt = $pdo->prepare(
        'INSERT INTO calculator_results (
            user_id,
            calculator_key,
            calculator_label,
            patient_first_name,
            patient_last_name,
            patient_birth_date,
            patient_birth_number,
            patient_insurance_code,
            input_payload,
            result_payload
        ) VALUES (
            :user_id,
            :calculator_key,
            :calculator_label,
            :patient_first_name,
            :patient_last_name,
            :patient_birth_date,
            :patient_birth_number,
            :patient_insurance_code,
            :input_payload,
            :result_payload
        )'
    );

    return $stmt->execute([
        'user_id' => $userId,
        'calculator_key' => $calculatorKey,
        'calculator_label' => $calculatorLabel,
        'patient_first_name' => ($patient['first_name'] ?? '') !== '' ? $patient['first_name'] : null,
        'patient_last_name' => ($patient['last_name'] ?? '') !== '' ? $patient['last_name'] : null,
        'patient_birth_date' => ($patient['birth_date'] ?? '') !== '' ? $patient['birth_date'] : null,
        'patient_birth_number' => ($patient['birth_number'] ?? '') !== '' ? $patient['birth_number'] : null,
        'patient_insurance_code' => ($patient['insurance_code'] ?? '') !== '' ? $patient['insurance_code'] : null,
        'input_payload' => json_encode($inputPayload, JSON_UNESCAPED_UNICODE),
        'result_payload' => json_encode($resultPayload, JSON_UNESCAPED_UNICODE),
    ]);
}

function calculatorFetchSavedResults(PDO $pdo, int $userId, string $calculatorKey, int $limit = 20): array
{
    $limit = max(1, min(100, $limit));

    $stmt = $pdo->prepare(
        'SELECT
            id,
            calculator_label,
            patient_first_name,
            patient_last_name,
            patient_birth_date,
            patient_birth_number,
            patient_insurance_code,
            input_payload,
            result_payload,
            created_at
         FROM calculator_results
         WHERE user_id = :user_id AND calculator_key = :calculator_key
         ORDER BY patient_last_name ASC, patient_first_name ASC, created_at DESC
         LIMIT :result_limit'
    );
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':calculator_key', $calculatorKey, PDO::PARAM_STR);
    $stmt->bindValue(':result_limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as &$row) {
        $row['input_payload'] = calculatorDecodeJsonArray((string) ($row['input_payload'] ?? ''));
        $row['result_payload'] = calculatorDecodeJsonArray((string) ($row['result_payload'] ?? ''));
    }

    return $rows;
}

function calculatorFetchSavedResultById(PDO $pdo, int $resultId, int $userId): ?array
{
    $stmt = $pdo->prepare(
        'SELECT
            id,
            calculator_key,
            calculator_label,
            patient_first_name,
            patient_last_name,
            patient_birth_date,
            patient_birth_number,
            patient_insurance_code,
            input_payload,
            result_payload,
            created_at
         FROM calculator_results
         WHERE id = :id AND user_id = :user_id
         LIMIT 1'
    );
    $stmt->execute([
        'id' => $resultId,
        'user_id' => $userId,
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return null;
    }

    $row['input_payload'] = calculatorDecodeJsonArray((string) ($row['input_payload'] ?? ''));
    $row['result_payload'] = calculatorDecodeJsonArray((string) ($row['result_payload'] ?? ''));

    return $row;
}

function calculatorDeleteSavedResult(PDO $pdo, int $resultId, int $userId): bool
{
    $stmt = $pdo->prepare('DELETE FROM calculator_results WHERE id = :id AND user_id = :user_id');
    $stmt->execute([
        'id' => $resultId,
        'user_id' => $userId,
    ]);

    return $stmt->rowCount() > 0;
}

function calculatorDecodeJsonArray(string $json): array
{
    if ($json === '') {
        return [];
    }

    $decoded = json_decode($json, true);
    if (!is_array($decoded)) {
        return [];
    }

    return $decoded;
}

function calculatorBuildPatientDisplay(array $row): string
{
    $name = trim((string) (($row['patient_first_name'] ?? '') . ' ' . ($row['patient_last_name'] ?? '')));
    $parts = [];
    if ($name !== '') {
        $parts[] = $name;
    }
    if (!empty($row['patient_birth_date'])) {
        $parts[] = 'nar. ' . $row['patient_birth_date'];
    }
    if (!empty($row['patient_birth_number'])) {
        $parts[] = 'RC: ' . $row['patient_birth_number'];
    }
    if (!empty($row['patient_insurance_code'])) {
        $parts[] = 'ZP: ' . $row['patient_insurance_code'];
    }

    if (empty($parts)) {
        return 'Pacient nebol vyplnený';
    }

    return implode(', ', $parts);
}

/**
 * Načíta základné klinické údaje používateľa z DB pre quickfill.
 */
function calculatorGetUserProfile(PDO $pdo, int $userId): array
{
    try {
        $stmt = $pdo->prepare(
            'SELECT first_name, last_name, birth_date, gender
             FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $age = null;
        if (!empty($row['birth_date'])) {
            $bd = new DateTime((string) $row['birth_date']);
            $age = (int) $bd->diff(new DateTime())->y;
        }
        $sexMap = ['Muž' => 'male', 'Žena' => 'female'];
        return [
            'first_name' => (string) ($row['first_name'] ?? ''),
            'last_name'  => (string) ($row['last_name']  ?? ''),
            'birth_date' => (string) ($row['birth_date'] ?? ''),
            'sex'        => $sexMap[$row['gender'] ?? ''] ?? '',
            'age'        => $age,
        ];
    } catch (\PDOException $e) {
        return [];
    }
}

/**
 * Vráti všetky uložené výsledky používateľa naprieč všetkými kalkulačkami.
 */
function calculatorFetchAllResults(PDO $pdo, int $userId, int $limit = 200): array
{
    $limit = max(1, min(500, $limit));
    $stmt = $pdo->prepare(
        'SELECT id, calculator_key, calculator_label,
                patient_first_name, patient_last_name, patient_birth_date,
                patient_birth_number, patient_insurance_code,
                input_payload, result_payload, created_at
         FROM calculator_results
         WHERE user_id = :user_id
         ORDER BY created_at DESC
         LIMIT :lim'
    );
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as &$row) {
        $row['input_payload']  = calculatorDecodeJsonArray((string) ($row['input_payload']  ?? ''));
        $row['result_payload'] = calculatorDecodeJsonArray((string) ($row['result_payload'] ?? ''));
    }
    return $rows;
}

/**
 * Vráti CSS triedu rizika pre eGFR kategóriu.
 */
function egfrRiskClass(string $category): string
{
    return match ($category) {
        'G1'  => 'risk-g1',
        'G2'  => 'risk-g2',
        'G3a' => 'risk-g3a',
        'G3b' => 'risk-g3b',
        'G4'  => 'risk-g4',
        'G5'  => 'risk-g5',
        default => '',
    };
}

/**
 * Vráti CSS triedu rizika pre KFRE percentuálne riziko (5-ročné).
 */
function kfreRiskClass(float $risk5yr): string
{
    if ($risk5yr < 3.0)  return 'risk-low';
    if ($risk5yr < 10.0) return 'risk-moderate';
    if ($risk5yr < 40.0) return 'risk-high';
    return 'risk-very-high';
}

/**
 * load_id je navigácia (GET). Pri POST ho ignoruj — formuláre bez action
 * (a bookmarky s ?load_id=) by inak pred výpočtom prepísali odoslané hodnoty
 * históriou a mohli uložiť alebo zobraziť starý klinický výsledok.
 */
function calculatorIsHistoryLoadRequest(): bool
{
    if (strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET')) === 'POST') {
        return false;
    }

    return requestScalarInt($_GET, 'load_id') > 0;
}

/**
 * Skopíruje uložený input_payload do formulára.
 * Kľúče, ktoré vo formulári nie sú, sa ignorujú — okrem kanonického UACR:
 * staršie PREVENT záznamy ukladali len uacr_mg_g, KDIGO zase uacr_value
 * do poľa uacr.
 *
 * @param array<string, mixed> $form
 * @param array<string, mixed> $payload
 */
function calculatorApplyInputPayloadToForm(array &$form, array $payload): void
{
    foreach ($payload as $k => $v) {
        if (!array_key_exists($k, $form)) {
            continue;
        }
        if (is_bool($v)) {
            $form[$k] = $v ? '1' : '0';
        } elseif (is_scalar($v) || $v === null) {
            $form[$k] = (string) $v;
        }
    }

    $hasStoredUacr = static function (mixed $value): bool {
        return $value !== null && $value !== '';
    };

    if (array_key_exists('uacr_value', $form) && trim((string) $form['uacr_value']) === '') {
        $canonical = $payload['uacr_mg_g'] ?? null;
        if ($hasStoredUacr($canonical)) {
            $form['uacr_value'] = (string) $canonical;
            if (array_key_exists('uacr_unit', $form)) {
                $form['uacr_unit'] = 'mg_g';
            }
        }
    }

    if (array_key_exists('uacr', $form) && trim((string) $form['uacr']) === '') {
        if ($hasStoredUacr($payload['uacr_value'] ?? null)) {
            $form['uacr'] = (string) $payload['uacr_value'];
        } elseif ($hasStoredUacr($payload['uacr_mg_g'] ?? null)) {
            $form['uacr'] = (string) $payload['uacr_mg_g'];
            if (array_key_exists('uacr_unit', $form)) {
                $form['uacr_unit'] = 'mg_g';
            }
        }
    }
}

/**
 * Načíta uložený výsledok do $form podľa GET parametra load_id.
 */
function calculatorHandleLoadId(PDO $pdo, array &$form, array &$messages): void
{
    if (!isLoggedIn() || !calculatorIsHistoryLoadRequest()) {
        return;
    }
    $loadId = requestScalarInt($_GET, 'load_id');
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION['user_id']);
    if (!$loadedRow) {
        return;
    }
    $form['patient_first_name']     = (string) ($loadedRow['patient_first_name'] ?? '');
    $form['patient_last_name']      = (string) ($loadedRow['patient_last_name'] ?? '');
    $form['patient_birth_date']     = (string) ($loadedRow['patient_birth_date'] ?? '');
    $form['patient_birth_number']   = (string) ($loadedRow['patient_birth_number'] ?? '');
    $form['patient_insurance_code'] = (string) ($loadedRow['patient_insurance_code'] ?? '');
    if (is_array($loadedRow['input_payload'])) {
        calculatorApplyInputPayloadToForm($form, $loadedRow['input_payload']);
    }
    // eGFR sa v histórii ukladá vždy v kanonických ml/min/1,73 m² — jednotku
    // vo formulári preto po načítaní vrátime na ml/min, nech hodnota sedí.
    if (array_key_exists('egfr_unit', $form)) {
        $form['egfr_unit'] = EGFR_UNIT_ML_MIN;
    }
    $messages[] = 'Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.';
}

/**
 * Spracuje akciu delete_saved z POST handlera kalkulačky.
 */
function calculatorHandleDeleteSaved(PDO $pdo, array &$errors, array &$messages, string $logPrefix): void
{
    if (!isLoggedIn()) {
        $errors[] = 'Na mazanie výsledkov je potrebné prihlásenie.';
        return;
    }
    $resultId = calculatorPostInt('result_id');
    if ($resultId <= 0) {
        $errors[] = 'Neplatné ID záznamu.';
        return;
    }
    try {
        if (calculatorDeleteSavedResult($pdo, $resultId, (int) $_SESSION['user_id'])) {
            $messages[] = 'Uložený výsledok bol vymazaný.';
        } else {
            $errors[] = 'Záznam sa nepodarilo vymazať alebo neexistuje.';
        }
    } catch (\PDOException $e) {
        $errors[] = 'Databázová chyba pri mazaní záznamu.';
        error_log($logPrefix . ' delete error: ' . $e->getMessage());
    }
}

/**
 * Vykreslí výzvu na bezplatnú registráciu pre NEPRIHLÁSENÝCH používateľov.
 * Pre prihlásených nevykreslí nič (volajúci ju môže volať bezpodmienečne).
 *
 * Soft-gate filozofia: samotný výpočet je vždy voľný a indexovateľný (SEO/dosah);
 * účet odomyká pridanú hodnotu (ukladanie k pacientovi, história, tlač). CTA sa
 * zobrazuje v momente najvyššieho záujmu — pri výsledku a v sekcii histórie.
 *
 * @param string $variant 'saved' (sekcia histórie) | 'hub' (prehľad kalkulačiek)
 */
function calculatorRenderRegisterCta(string $variant = 'saved'): void
{
    if (isLoggedIn()) {
        return;
    }
    $title = $variant === 'hub'
        ? 'Vyťažte z kalkulačiek maximum: vytvorte si bezplatný účet'
        : 'Uložte si tento výpočet: vytvorte si bezplatný účet';
    ?>
    <aside class="calc-register-cta" aria-label="Výhody bezplatného účtu">
        <h3 class="calc-register-cta__title"><?= htmlspecialchars($title) ?></h3>
        <p class="calc-register-cta__lead">
            Samotný výpočet je vždy zadarmo a bez prihlásenia. S&nbsp;bezplatným účtom navyše získate:
        </p>
        <ul class="calc-register-cta__benefits">
            <li>Uloženie výsledkov k&nbsp;pacientovi a&nbsp;históriu výpočtov</li>
            <li>Sledovanie vývoja v&nbsp;čase (napr. trajektória eGFR)</li>
            <li>Tlač a&nbsp;PDF záznamu, opätovné použitie údajov pacienta</li>
        </ul>
        <div class="calc-register-cta__actions">
            <a href="register.php" class="btn-primary calc-register-cta__btn">Vytvoriť bezplatný účet</a>
            <a href="login.php" class="btn-secondary calc-register-cta__btn">Už mám účet</a>
        </div>
        <p class="calc-register-cta__note">Registrácia trvá ~30&nbsp;sekúnd, stačí e-mail a&nbsp;heslo.</p>
    </aside>
    <?php
}

/**
 * Vykreslí sekciu uložených výsledkov so štandardnou 4-stĺpcovou tabuľkou.
 * $renderResultCell(array $row): void — echos HTML pre stĺpec "Výsledok"
 */
function calculatorRenderSavedResultsTable(
    array $savedResults,
    string $calcFile,
    callable $renderResultCell,
    string $extraSectionClass = ''
): void {
    // Hosť dostane CTA bez kartového orámovania (CTA si nesie vlastný box);
    // prihlásený používateľ vidí klasickú kartu s tabuľkou histórie.
    $cls = isLoggedIn() ? 'auth-container auth-container--wide calc-saved-results' : 'calc-saved-results';
    if ($extraSectionClass !== '') {
        $cls .= ' ' . $extraSectionClass;
    }
    ?>
    <section class="<?= htmlspecialchars($cls) ?>">
        <?php if (!isLoggedIn()): ?>
            <?php calculatorRenderRegisterCta('saved'); ?>
        <?php elseif (empty($savedResults)): ?>
            <h3>Uložené výsledky</h3>
            <p>Zatiaľ nemáte uložené žiadne výsledky pre túto kalkulačku.</p>
        <?php else: ?>
            <h3>Uložené výsledky</h3>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr><th scope="col">Vyšetrenie</th><th scope="col">Pacient</th><th scope="col">Výsledok</th><th scope="col">Akcie</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($savedResults as $row):
                            $_examD = (string) ($row['input_payload']['examination_date'] ?? ''); ?>
                            <tr>
                                <td>
                                    <?= $_examD ? htmlspecialchars(formatUserDate($_examD, 'd.m.Y')) : '—' ?>
                                    <small class="d-block saved-meta">ulo.: <?= htmlspecialchars(formatUserDateTime((string) ($row['created_at'] ?? ''), 'd.m.Y H:i')) ?></small>
                                </td>
                                <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
                                <td><?php $renderResultCell($row); ?></td>
                                <td class="admin-actions-cell">
                                    <a href="?load_id=<?= (int) $row['id'] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                                    <a href="calculator_result_print.php?result_id=<?= (int) $row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
                                    <form method="POST" action="<?= htmlspecialchars($calcFile) ?>" class="d-inline" data-confirm="Naozaj vymazať záznam?">
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
    <?php
}

/*
 * eGFR v dvoch jednotkách
 * ----------------------
 * Kanonická jednotka pre všetky výpočty je ml/min/1,73 m².
 * SI alternatíva ml/s/1,73 m² sa pred výpočtom prepočíta faktorom 60
 * (1 ml/s = 60 ml/min). Zadané hodnoty sa uchovávajú v kanonickej jednotke,
 * pôvodná jednotka len pre zobrazenie.
 */

const EGFR_UNIT_ML_MIN = 'ml_min';
const EGFR_UNIT_ML_S = 'ml_s';
const EGFR_ML_S_PER_ML_MIN = 60.0;

/**
 * CKD-EPI 2021 (kreatinín, bez rasy) — spoločný vzorec pre kalkulačku eGFR aj porovnanie v EKFC.
 * Vstup: Scr v mg/dL, vek v celých rokoch (formulár), sex `female`|`male`.
 * Zdroj: Inker LA et al., NEJM 2021; KDIGO 2024 používa túto rovnicu.
 */
function calculatorCkdEpi2021FromCreatinineMgDl(float $creatinineMgDl, int $ageYears, string $sex): float
{
    $sexNorm = $sex === 'female' ? 'female' : 'male';
    $kappa = $sexNorm === 'female' ? 0.7 : 0.9;
    $alpha = $sexNorm === 'female' ? -0.241 : -0.302;
    $ratio = $creatinineMgDl / $kappa;

    $egfr = 142.0
        * (min($ratio, 1.0) ** $alpha)
        * (max($ratio, 1.0) ** -1.2)
        * (0.9938 ** $ageYears);

    if ($sexNorm === 'female') {
        $egfr *= 1.012;
    }

    return $egfr;
}

/**
 * CKD-EPI 2021 (kreatinín + cystatín C, bez rasy) — spoločný vzorec pre calculator_egfr_cys.php.
 * Vstup: Scr v mg/dL, Scys v mg/L, vek v celých rokoch, sex `female`|`male`.
 * Zdroj: Inker LA et al., N Engl J Med 2021;385(19):1737–1749, PMID 34554658.
 */
function calculatorCkdEpi2021FromCreatinineCystatinMgDl(
    float $creatinineMgDl,
    float $cystatinMgL,
    int $ageYears,
    string $sex
): float {
    $sexNorm = $sex === 'female' ? 'female' : 'male';
    $kappa = $sexNorm === 'female' ? 0.7 : 0.9;
    $alpha = $sexNorm === 'female' ? -0.219 : -0.144;
    $crRatio = $creatinineMgDl / $kappa;
    $cysRatio = $cystatinMgL / 0.8;

    $egfr = 135.0
        * (min($crRatio, 1.0) ** $alpha)
        * (max($crRatio, 1.0) ** -0.544)
        * (min($cysRatio, 1.0) ** -0.323)
        * (max($cysRatio, 1.0) ** -0.778)
        * (0.9961 ** $ageYears);

    if ($sexNorm === 'female') {
        $egfr *= 0.963;
    }

    return $egfr;
}

/** Vráti platnú jednotku eGFR; pri neznámej hodnote kanonickú ml/min/1,73 m². */
function calculatorNormalizeEgfrUnit(string $unit): string
{
    return $unit === EGFR_UNIT_ML_S ? EGFR_UNIT_ML_S : EGFR_UNIT_ML_MIN;
}

/** Popisok jednotky pre zobrazenie (bez zalomenia medzery pred m²). */
function calculatorEgfrUnitLabel(string $unit): string
{
    return calculatorNormalizeEgfrUnit($unit) === EGFR_UNIT_ML_S
        ? 'ml/s/1,73 m²'
        : 'ml/min/1,73 m²';
}

/** Prepočet zadanej hodnoty na kanonické ml/min/1,73 m². */
function calculatorEgfrToMlMin(float $value, string $unit): float
{
    return calculatorNormalizeEgfrUnit($unit) === EGFR_UNIT_ML_S
        ? $value * EGFR_ML_S_PER_ML_MIN
        : $value;
}

/** Prepočet z kanonických ml/min/1,73 m² do zvolenej jednotky. */
function calculatorEgfrFromMlMin(float $value, string $unit): float
{
    return calculatorNormalizeEgfrUnit($unit) === EGFR_UNIT_ML_S
        ? $value / EGFR_ML_S_PER_ML_MIN
        : $value;
}

/**
 * Naformátuje eGFR v kanonických ml/min/1,73 m² spolu s ekvivalentom v ml/s/1,73 m².
 * Napr. "45,2 ml/min/1,73 m² (0,753 ml/s/1,73 m²)".
 */
function calculatorFormatEgfrBothUnits(float $mlMin, int $decimals = 1): string
{
    return number_format($mlMin, $decimals, ',', ' ') . ' ml/min/1,73 m² (' .
        number_format($mlMin / EGFR_ML_S_PER_ML_MIN, 3, ',', ' ') . ' ml/s/1,73 m²)';
}

/**
 * Prečíta hodnotu eGFR z formulára a prepočíta ju na ml/min/1,73 m².
 * Rozsah $min/$max sa kontroluje v kanonickej jednotke.
 * Vracia null a doplní $errors, ak je hodnota neplatná.
 */
function calculatorParseEgfrToMlMin(
    string $rawValue,
    string $rawUnit,
    array &$errors,
    float $min = 0.0,
    float $max = 200.0,
    string $fieldLabel = 'eGFR'
): ?float {
    $unit = calculatorNormalizeEgfrUnit($rawUnit);
    $value = calculatorParsePositiveFloat($rawValue);
    if ($value === null) {
        $errors[] = $fieldLabel . ' musí byť kladné číslo.';
        return null;
    }

    $mlMin = calculatorEgfrToMlMin($value, $unit);
    // Rozsah je uzavretý z oboch strán ([min, max]). `<= $min` by pri min>0
    // odmietlo platnú dolnú hranicu (PREVENT: eGFR 15 ml/min = 0,25 ml/s).
    if ($mlMin < $min || $mlMin > $max) {
        $errors[] = sprintf(
            '%s musí byť v rozsahu %s–%s ml/min/1,73 m² (t. j. %s–%s ml/s/1,73 m²).',
            $fieldLabel,
            rtrim(rtrim(number_format($min, 1, ',', ' '), '0'), ','),
            rtrim(rtrim(number_format($max, 1, ',', ' '), '0'), ','),
            number_format($min / EGFR_ML_S_PER_ML_MIN, 3, ',', ' '),
            number_format($max / EGFR_ML_S_PER_ML_MIN, 3, ',', ' ')
        );
        return null;
    }

    return $mlMin;
}

/**
 * Vykreslí <select> s jednotkou eGFR (ml/min vs. ml/s).
 *
 * $hasVisibleLabel = true, ak je k poľu vykreslený <label for>. Vtedy sa
 * aria-label NEpridáva — prepísal by prístupný názov a ten by potom
 * neobsahoval viditeľný text (WCAG 2.5.3 Label in Name).
 */
function calculatorRenderEgfrUnitSelect(
    string $selected,
    string $name = 'egfr_unit',
    string $extraClass = 'flex-08',
    bool $hasVisibleLabel = false
): void {
    $selected = calculatorNormalizeEgfrUnit($selected);
    $classAttr = trim('form-control ' . $extraClass);
    ?>
    <select name="<?= htmlspecialchars($name) ?>" id="<?= htmlspecialchars($name) ?>"
            <?= $hasVisibleLabel ? '' : 'aria-label="Jednotka eGFR"' ?> class="<?= htmlspecialchars($classAttr) ?>">
        <option value="<?= EGFR_UNIT_ML_MIN ?>"<?= $selected === EGFR_UNIT_ML_MIN ? ' selected' : '' ?>>ml/min/1,73 m²</option>
        <option value="<?= EGFR_UNIT_ML_S ?>"<?= $selected === EGFR_UNIT_ML_S ? ' selected' : '' ?>>ml/s/1,73 m²</option>
    </select>
    <?php
}
