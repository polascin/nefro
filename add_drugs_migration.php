<?php

declare(strict_types=1);
/**
 * add_drugs_migration.php
 * Fáza 6 — schéma pre kurátorskú databázu liekov relevantných v nefrológii.
 *
 * Technické/farmakologické polia napĺňa `sync_drugs.php` z ChEMBL (CLI/cron):
 * name_intl, chembl_id, atc_code, mechanism, max_phase, first_approval, routes,
 * black_box_warning, withdrawn, synonyms, source_refs.
 *
 * Kurátorské KLINICKÉ polia (lieková bezpečnosť — NIE z ChEMBL) sa zadávajú ručne
 * v admin_drugs.php a sync ich NEPREPISUJE: name_sk, drug_class, category,
 * indications, renal_dosing, nephrotoxicity, dialyzability, warnings, monitoring,
 * sk_note, is_published.
 *
 * POZOR: is_published má DEFAULT 0 — liek sa zverejní až po odbornej kurátorskej
 * kontrole (na rozdiel od clinical_trials, kde je default 1).
 *
 * Idempotentné (CREATE TABLE IF NOT EXISTS). Spustenie:
 *   - admin cez prehliadač (requireAdmin), alebo
 *   - CLI cez SSH: php add_drugs_migration.php
 *
 * Poradie nasadenia: túto migráciu commitni a nasaď (a spusti) PRED kódom, ktorý
 * tabuľku používa.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS drugs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) NOT NULL,
    name_sk VARCHAR(200) NOT NULL,
    name_intl VARCHAR(200) NULL,
    chembl_id VARCHAR(20) NULL,
    atc_code VARCHAR(16) NULL,
    drug_class VARCHAR(200) NULL,
    routes VARCHAR(100) NULL,
    max_phase TINYINT NULL,
    first_approval SMALLINT NULL,
    black_box_warning TINYINT NOT NULL DEFAULT 0,
    withdrawn TINYINT NOT NULL DEFAULT 0,
    mechanism TEXT NULL,
    indications TEXT NULL,
    renal_dosing TEXT NULL,
    nephrotoxicity TEXT NULL,
    dialyzability TEXT NULL,
    warnings TEXT NULL,
    monitoring TEXT NULL,
    sk_note TEXT NULL,
    synonyms TEXT NULL,
    source_refs TEXT NULL,
    category VARCHAR(40) NOT NULL DEFAULT 'other',
    is_published TINYINT NOT NULL DEFAULT 0,
    chembl_synced_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_drugs_slug (slug),
    UNIQUE KEY uq_drugs_chembl (chembl_id),
    INDEX idx_drugs_category (category),
    INDEX idx_drugs_published (is_published),
    INDEX idx_drugs_atc (atc_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'drugs: OK';

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
