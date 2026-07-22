<?php

declare(strict_types=1);
/**
 * add_providers_priority_migration.php
 * - pridá stĺpec `priority` (A/B/C — cielenie najsilnejších odporúčateľov),
 * - zmení `contacted_at` z DATE na DATETIME (dátum aj čas kontaktovania).
 *
 * Idempotentné (kontrola cez SHOW COLUMNS). Commit a spusti PRED kódom.
 * Spustenie: php add_providers_priority_migration.php
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu priorít poskytovateľov');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps  = [];
$byField = [];
foreach ($pdo->query('SHOW COLUMNS FROM partner_providers')->fetchAll(\PDO::FETCH_ASSOC) as $c) {
    $byField[(string) $c['Field']] = $c;
}

if (!isset($byField['priority'])) {
    $pdo->exec("ALTER TABLE partner_providers ADD COLUMN priority CHAR(1) NULL AFTER outreach_status");
    $steps[] = 'priority: pridaný';
} else {
    $steps[] = 'priority: existuje';
}

$ctType = strtolower((string) ($byField['contacted_at']['Type'] ?? ''));
if ($ctType === 'date') {
    $pdo->exec("ALTER TABLE partner_providers MODIFY COLUMN contacted_at DATETIME NULL");
    $steps[] = 'contacted_at: date → datetime';
} else {
    $steps[] = 'contacted_at: ' . ($ctType !== '' ? $ctType : '?') . ' (bez zmeny)';
}

try {
    $pdo->exec('ALTER TABLE partner_providers ADD INDEX idx_pp_priority (priority)');
    $steps[] = 'idx_pp_priority: pridaný';
} catch (\PDOException $e) {
    $steps[] = 'idx_pp_priority: existuje/preskočený';
}

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
