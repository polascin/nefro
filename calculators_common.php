<?php
declare(strict_types=1);

// Kalkulačky skladajú JSON-LD ešte pred načítaním head_meta.php.
$baseUrl = $baseUrl ?? 'https://nefro.polascin.net/';

function calculatorPatientDataFromRequest(array $source): array
{
    $firstName = trim((string) ($source['patient_first_name'] ?? ''));
    $lastName = trim((string) ($source['patient_last_name'] ?? ''));
    $birthDate = trim((string) ($source['patient_birth_date'] ?? ''));
    $birthNumber = trim((string) ($source['patient_birth_number'] ?? ''));
    $insuranceCode = trim((string) ($source['patient_insurance_code'] ?? ''));

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
 * Načíta uložený výsledok do $form podľa GET parametra load_id.
 */
function calculatorHandleLoadId(PDO $pdo, array &$form, array &$messages): void
{
    if (!isLoggedIn() || !isset($_GET['load_id'])) {
        return;
    }
    $loadId = (int) $_GET['load_id'];
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
        foreach ($loadedRow['input_payload'] as $k => $v) {
            if (isset($form[$k]) || array_key_exists($k, $form)) {
                if (is_bool($v)) {
                    $form[$k] = $v ? '1' : '0';
                } elseif (is_scalar($v) || $v === null) {
                    $form[$k] = (string) $v;
                }
            }
        }
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
    $resultId = (int) ($_POST['result_id'] ?? 0);
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
        ? 'Vyťažte z kalkulačiek maximum — vytvorte si bezplatný účet'
        : 'Uložte si tento výpočet — vytvorte si bezplatný účet';
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
        <p class="calc-register-cta__note">Registrácia trvá ~30&nbsp;sekúnd — stačí e-mail a&nbsp;heslo.</p>
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
                                    <?= $_examD ? htmlspecialchars(date('d.m.Y', strtotime($_examD))) : '—' ?>
                                    <small class="d-block saved-meta">ulo.: <?= htmlspecialchars(date('d.m.Y H:i', strtotime((string) ($row['created_at'] ?? '')))) ?></small>
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
