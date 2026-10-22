<?php

declare(strict_types=1);
/**
 * add_newsletter_sending_status_migration.php
 * ────────────────────────────────────────────────────────────────────────────
 * Idempotentná migrácia: pridá stav `sending` do stĺpca `status` v newslet-
 * terových frontách.
 *
 * Prečo: SMTP odoslanie nesmie prebiehať v otvorenej transakcii. Ak sa
 * proces preruší po odoslaní, ale pred commitom, rollback vráti riadok do
 * stavu `pending` a nasledujúci beh pošle ten istý e-mail znova — pri dávke
 * to znamená duplicitné rozoslanie celej dávky.
 *
 * Nový postup je trojstupňový:
 *   1. v krátkej transakcii sa riadky označia ako `sending` (lease),
 *   2. e-mail sa odošle bez transakcie,
 *   3. v krátkej transakcii sa zapíše `sent` alebo `failed`.
 *
 * Ak proces zomrie v kroku 2, zostanú tam riadky v stave `sending`. Worker
 * ich po uplynutí lehoty (pozri NEWSLETTER_SENDING_LEASE_SECONDS) vráti do
 * stavu `pending` s pripočítaným pokusom.
 *
 * Spustenie cez SSH na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_newsletter_sending_status_migration.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu stavu newsletter fronty');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

/**
 * Vráti definíciu ENUM stĺpca `status`, alebo null ak stĺpca/tabuľky nie je.
 */
function newsletterStatusEnumDefinition(PDO $pdo, string $table): ?string
{
    $stmt = $pdo->prepare(
        "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = 'status'"
    );
    $stmt->execute(['table' => $table]);
    $type = $stmt->fetchColumn();

    return $type === false ? null : (string) $type;
}

foreach (['article_newsletter_queue', 'nl_sub_queue'] as $table) {
    $definition = newsletterStatusEnumDefinition($pdo, $table);

    if ($definition === null) {
        $steps[] = "{$table}: tabuľka neexistuje — preskočené";
        continue;
    }

    // `sending` už je v definícii → nič nerobíme (idempotencia).
    if (stripos($definition, "'sending'") !== false) {
        $steps[] = "{$table}.status: stav 'sending' už existuje";
        continue;
    }

    // Zachováme pôvodné poradie hodnôt a 'sending' vložíme medzi 'pending'
    // a 'sent' — poradie v ENUM nemá funkčný význam, no pre čitateľnosť
    // schémy dáva zmysel.
    $pdo->exec(
        "ALTER TABLE `{$table}`
         MODIFY COLUMN `status` ENUM('pending', 'sending', 'sent', 'failed', 'cancelled')
         NOT NULL DEFAULT 'pending'"
    );
    $steps[] = "{$table}.status: stav 'sending' pridaný";
}

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
