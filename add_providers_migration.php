<?php

declare(strict_types=1);
/**
 * add_providers_migration.php
 * Schéma pre INTERNÚ databázu spolupracujúcich lekárov a poskytovateľov zdravotnej
 * a sociálnej starostlivosti (sieť odporúčateľov okolo Medimpax Dúbravka).
 *
 * Tabuľka `partner_providers` je admin-only (nie verejná). Spravuje sa v
 * admin_providers.php (CRUD). Filtrovateľné podľa lokality, typu a odbornosti.
 *
 * Idempotentné (CREATE TABLE IF NOT EXISTS). Spustenie:
 *   - admin cez prehliadač (requireAdmin), alebo
 *   - CLI cez SSH: php add_providers_migration.php
 *
 * Poradie nasadenia: túto migráciu commitni, nasaď a SPUSTI PRED kódom
 * (admin_providers.php), ktorý tabuľku používa.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu poskytovateľov');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS partner_providers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    provider_type VARCHAR(60) NOT NULL DEFAULT 'specialista',
    specialization VARCHAR(255) NULL,
    locality VARCHAR(120) NULL,
    address VARCHAR(255) NULL,
    phone VARCHAR(120) NULL,
    email VARCHAR(190) NULL,
    website VARCHAR(255) NULL,
    contact_person VARCHAR(190) NULL,
    notes TEXT NULL,
    source VARCHAR(255) NULL,
    is_active TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_pp_type (provider_type),
    INDEX idx_pp_locality (locality),
    INDEX idx_pp_specialization (specialization),
    INDEX idx_pp_active (is_active),
    INDEX idx_pp_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'partner_providers: OK';

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
