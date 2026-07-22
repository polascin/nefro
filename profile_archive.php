<?php

declare(strict_types=1);

/**
 * Jediný zoznam profilových polí, ktoré smie obsahovať história zmien.
 * Autentifikačné tokeny, heslá, 2FA tajomstvá a bezpečnostné stavové polia
 * sem zámerne nepatria.
 */
const NPS_PROFILE_ARCHIVE_ALLOWED_FIELDS = [
    'username',
    'gender',
    'pronouns',
    'user_type',
    'title_before',
    'first_name',
    'middle_name',
    'last_name',
    'title_after',
    'name_note',
    'organization',
    'job_function',
    'work_mobile_phone',
    'org_website',
    'work_email',
    'mobile_phone',
    'other_phone',
    'social_linkedin',
    'social_x',
    'social_facebook',
    'social_instagram',
    'social_other',
    'other_contact',
    'website',
    'birth_date',
    'street',
    'house_number',
    'orientation_number',
    'zip_code',
    'city',
    'district',
    'region',
    'country',
    'address_note',
    'newsletter_consent',
    'theme_auto',
    'avatar_path',
];

/**
 * @param array<string, mixed> $previousData
 * @param array<int, mixed> $changedFields
 * @return array{changed_fields: list<string>, previous_data: array<string, mixed>}
 */
function npsSanitizeProfileArchivePayload(array $previousData, array $changedFields): array
{
    $allowed = array_fill_keys(NPS_PROFILE_ARCHIVE_ALLOWED_FIELDS, true);
    $safeChangedFields = [];

    foreach ($changedFields as $field) {
        if (is_string($field) && isset($allowed[$field]) && !in_array($field, $safeChangedFields, true)) {
            $safeChangedFields[] = $field;
        }
    }

    $safePreviousData = array_intersect_key(
        $previousData,
        array_fill_keys($safeChangedFields, true)
    );

    return [
        'changed_fields' => $safeChangedFields,
        'previous_data' => $safePreviousData,
    ];
}

/**
 * Odstráni z historických záznamov všetko mimo profilového allowlistu.
 * Neplatné alebo po minimalizácii prázdne záznamy bezpečne zmaže.
 *
 * @return array{updated: int, deleted: int}
 */
function npsScrubProfileArchive(PDO $pdo): array
{
    $rows = $pdo->query(
        'SELECT id, changed_fields, previous_data FROM users_profile_archive ORDER BY id'
    )->fetchAll(PDO::FETCH_ASSOC);
    $update = $pdo->prepare(
        'UPDATE users_profile_archive
         SET changed_fields = :changed_fields, previous_data = :previous_data
         WHERE id = :id'
    );
    $delete = $pdo->prepare('DELETE FROM users_profile_archive WHERE id = :id');
    $updated = 0;
    $deleted = 0;

    foreach ($rows as $row) {
        $changedFields = json_decode((string) ($row['changed_fields'] ?? ''), true);
        $previousData = json_decode((string) ($row['previous_data'] ?? ''), true);

        if (!is_array($changedFields) || !is_array($previousData)) {
            $delete->execute(['id' => (int) $row['id']]);
            $deleted += $delete->rowCount();
            continue;
        }

        $payload = npsSanitizeProfileArchivePayload($previousData, $changedFields);
        if ($payload['changed_fields'] === []) {
            $delete->execute(['id' => (int) $row['id']]);
            $deleted += $delete->rowCount();
            continue;
        }

        $safeChangedFields = json_encode($payload['changed_fields'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        $safePreviousData = json_encode($payload['previous_data'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        if ($safeChangedFields === (string) $row['changed_fields']
            && $safePreviousData === (string) $row['previous_data']
        ) {
            continue;
        }

        $update->execute([
            'changed_fields' => $safeChangedFields,
            'previous_data' => $safePreviousData,
            'id' => (int) $row['id'],
        ]);
        $updated += $update->rowCount();
    }

    return ['updated' => $updated, 'deleted' => $deleted];
}
