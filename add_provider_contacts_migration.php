<?php

declare(strict_types=1);
/**
 * add_provider_contacts_migration.php
 * História kontaktov s poskytovateľmi (CRM log) — tabuľka `provider_contacts`.
 * Každý záznam = jeden kontakt (dátum+čas, kanál, výsledok, poznámka).
 * FK na partner_providers(id) s ON DELETE CASCADE (zmazanie poskytovateľa
 * odstráni aj jeho históriu).
 *
 * Idempotentné (CREATE TABLE IF NOT EXISTS). Commit a spusti PRED kódom.
 * Spustenie: php add_provider_contacts_migration.php
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu kontaktov poskytovateľov');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$pdo->exec("CREATE TABLE IF NOT EXISTS provider_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id INT NOT NULL,
    contacted_at DATETIME NOT NULL,
    channel VARCHAR(30) NOT NULL DEFAULT 'other',
    outcome VARCHAR(30) NULL,
    note TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pc_provider (provider_id),
    INDEX idx_pc_date (contacted_at),
    CONSTRAINT fk_pc_provider FOREIGN KEY (provider_id)
        REFERENCES partner_providers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

echo 'provider_contacts: OK' . PHP_EOL;
echo 'Migrácia dokončená.' . PHP_EOL;
