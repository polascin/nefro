<?php

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

function calculatorValidateOptionalPatientData(array $patient, array &$errors): void
{
    if ($patient['birth_date'] !== '') {
        $dt = \DateTime::createFromFormat('Y-m-d', $patient['birth_date']);
        if (!$dt || $dt->format('Y-m-d') !== $patient['birth_date']) {
            $errors[] = 'Neplatny datum narodenia.';
        }
    }

    if ($patient['birth_number'] !== '') {
        $normalizedBirthNumber = preg_replace('/\s+/', '', $patient['birth_number']) ?? '';
        if (!preg_match('/^\d{6}\/??\d{3,4}$/', $normalizedBirthNumber)) {
            $errors[] = 'Rodne cislo musi byt vo formate 000000/0000 alebo 0000000000.';
        }
    }

    if ($patient['insurance_code'] !== '' && !preg_match('/^\d{3}$/', $patient['insurance_code'])) {
        $errors[] = 'Kod zdravotnej poistovne musi mat 3 cislice.';
    }
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
         ORDER BY created_at DESC, id DESC
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
        return 'Pacient nebol vyplneny';
    }

    return implode(', ', $parts);
}
