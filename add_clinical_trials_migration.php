<?php

declare(strict_types=1);
/**
 * add_clinical_trials_migration.php
 * Fáza 6 — schéma pre kurátorský register klinických štúdií (ClinicalTrials.gov v2).
 * Dáta plní `sync_clinical_trials.php` (CLI/cron). Zobrazenie: `studie.php` / `studia.php`.
 *
 * Idempotentné (CREATE TABLE IF NOT EXISTS). Spustenie:
 *   - admin cez prehliadač (requireAdmin), alebo
 *   - CLI cez SSH: php add_clinical_trials_migration.php
 *
 * Poradie nasadenia: túto migráciu commitni a nasaď PRED kódom, ktorý tabuľku používa.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS clinical_trials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nct_id VARCHAR(20) NOT NULL,
    brief_title VARCHAR(600) NOT NULL,
    official_title TEXT NULL,
    overall_status VARCHAR(40) NULL,
    phase VARCHAR(40) NULL,
    study_type VARCHAR(40) NULL,
    conditions TEXT NULL,
    interventions TEXT NULL,
    lead_sponsor VARCHAR(300) NULL,
    enrollment INT NULL,
    start_date DATE NULL,
    completion_date DATE NULL,
    last_update_posted DATE NULL,
    countries TEXT NULL,
    brief_summary TEXT NULL,
    category VARCHAR(40) NOT NULL DEFAULT 'other',
    sk_note TEXT NULL,
    is_published TINYINT NOT NULL DEFAULT 1,
    source_synced_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_ct_nct (nct_id),
    INDEX idx_ct_status (overall_status),
    INDEX idx_ct_category (category),
    INDEX idx_ct_published (is_published),
    INDEX idx_ct_updated (last_update_posted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'clinical_trials: OK';

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
