<?php

declare(strict_types=1);
/**
 * add_providers_fields_migration.php
 * Rozšírenie partner_providers o polia pre sledovanie akvizície:
 *   - ico             IČO poskytovateľa
 *   - outreach_status stav oslovenia (nekontaktovany/osloveny/odpovedal/spolupracuje/odmietol)
 *   - contacted_at    dátum posledného kontaktu
 *
 * Idempotentné (kontroluje existenciu stĺpcov cez SHOW COLUMNS).
 * Poradie nasadenia: commitni a spusti PRED kódom (admin_providers.php), ktorý polia používa.
 * Spustenie: php add_providers_fields_migration.php  (CLI/SSH) alebo admin v prehliadači.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu polí poskytovateľov');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$cols = $pdo->query('SHOW COLUMNS FROM partner_providers')->fetchAll(\PDO::FETCH_COLUMN);

if (!in_array('ico', $cols, true)) {
    $pdo->exec("ALTER TABLE partner_providers ADD COLUMN ico VARCHAR(20) NULL AFTER website");
    $steps[] = 'ico: pridaný';
} else {
    $steps[] = 'ico: existuje';
}

if (!in_array('outreach_status', $cols, true)) {
    $pdo->exec("ALTER TABLE partner_providers ADD COLUMN outreach_status VARCHAR(30) NOT NULL DEFAULT 'nekontaktovany' AFTER source");
    $steps[] = 'outreach_status: pridaný';
} else {
    $steps[] = 'outreach_status: existuje';
}

if (!in_array('contacted_at', $cols, true)) {
    $pdo->exec("ALTER TABLE partner_providers ADD COLUMN contacted_at DATE NULL AFTER outreach_status");
    $steps[] = 'contacted_at: pridaný';
} else {
    $steps[] = 'contacted_at: existuje';
}

// Index na outreach_status (ignoruj, ak už existuje).
try {
    $pdo->exec('ALTER TABLE partner_providers ADD INDEX idx_pp_outreach (outreach_status)');
    $steps[] = 'idx_pp_outreach: pridaný';
} catch (\PDOException $e) {
    $steps[] = 'idx_pp_outreach: existuje/preskočený';
}

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
