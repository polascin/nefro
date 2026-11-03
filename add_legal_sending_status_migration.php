<?php

declare(strict_types=1);
/**
 * add_legal_sending_status_migration.php
 * ────────────────────────────────────────────────────────────────────────────
 * Idempotentná migrácia: pridá stav `sending` do ENUM `status` v právnych
 * frontách (legal_notice_queue, legal_notice_sub_queue).
 *
 * Rovnaký dôvod ako add_newsletter_sending_status_migration.php: SMTP mimo
 * otvorenej transakcie + lease, aby pád workera po odoslaní nespôsobil
 * duplicitné e-maily. Kód: legal_notifications.php (claim/lease).
 *
 * Spustenie cez SSH:
 *   php add_legal_sending_status_migration.php
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu stavu právnych front');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

/**
 * @return ?string
 */
function legalStatusEnumDefinition(PDO $pdo, string $table): ?string
{
    $stmt = $pdo->prepare(
        "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = 'status'"
    );
    $stmt->execute(['table' => $table]);
    $type = $stmt->fetchColumn();

    return $type === false ? null : (string) $type;
}

foreach (['legal_notice_queue', 'legal_notice_sub_queue'] as $table) {
    $definition = legalStatusEnumDefinition($pdo, $table);

    if ($definition === null) {
        $steps[] = "{$table}: tabuľka neexistuje — preskočené";
        continue;
    }

    if (stripos($definition, "'sending'") !== false) {
        $steps[] = "{$table}.status: stav 'sending' už existuje";
        continue;
    }

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
