<?php

declare(strict_types=1);
/**
 * add_legal_notice_migration.php
 * Schéma pre upozornenia na zmenu právnych dokumentov (Privacy/Cookie/Terms).
 *
 * Pri každej zmene verzie právnych dokumentov (`legalInfo()['version']` v
 * `legal_data.php`) sa všetkým registrovaným členom a anonymným odberateľom
 * newslettera odošle e-mail s popisom zmien (`legalRecentUpdates()`).
 *
 * Tabuľky:
 *  - legal_notice_runs       — jeden záznam na odoslanú verziu (idempotencia +
 *                              admin prehľad); UNIQUE(legal_version).
 *  - legal_notice_queue      — fronta pre registrovaných členov (FK users).
 *  - legal_notice_sub_queue  — fronta pre anonymných odberateľov (FK
 *                              newsletter_subscribers).
 *
 * Právny základ: oznámenie o zmene Privacy/Terms je transparenčná povinnosť
 * (GDPR čl. 13–14), preto sa členom posiela bez ohľadu na newsletter_consent.
 *
 * Idempotentné (CREATE TABLE IF NOT EXISTS). Spustenie:
 *   - admin cez prehliadač (requireAdmin), alebo
 *   - CLI cez SSH: php add_legal_notice_migration.php
 *
 * Poradie nasadenia: túto migráciu commitni a nasaď (a spusti) PRED kódom
 * (legal_notifications.php, legal_notice_worker.php), ktorý tabuľky používa.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu právnych oznámení');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS legal_notice_runs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    legal_version VARCHAR(20) NOT NULL,
    effective_date DATE NULL,
    change_summary TEXT NULL,
    users_queued INT NOT NULL DEFAULT 0,
    subscribers_queued INT NOT NULL DEFAULT 0,
    dispatched_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_legal_notice_runs_version (legal_version),
    INDEX idx_legal_notice_runs_dispatched (dispatched_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'legal_notice_runs: OK';

$pdo->exec("CREATE TABLE IF NOT EXISTS legal_notice_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    legal_version VARCHAR(20) NOT NULL,
    user_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    status ENUM('pending', 'sent', 'failed', 'cancelled') NOT NULL DEFAULT 'pending',
    attempts INT NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sent_at DATETIME NULL,
    last_error TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_legal_notice_queue_version_user (legal_version, user_id),
    INDEX idx_legal_notice_queue_status_next (status, next_attempt_at),
    INDEX idx_legal_notice_queue_user_id (user_id),
    CONSTRAINT fk_legal_notice_queue_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'legal_notice_queue: OK';

$pdo->exec("CREATE TABLE IF NOT EXISTS legal_notice_sub_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    legal_version VARCHAR(20) NOT NULL,
    subscriber_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    status ENUM('pending', 'sent', 'failed', 'cancelled') NOT NULL DEFAULT 'pending',
    attempts INT NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sent_at DATETIME NULL,
    last_error TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_legal_notice_sub_queue_version_sub (legal_version, subscriber_id),
    INDEX idx_legal_notice_sub_queue_status_next (status, next_attempt_at),
    INDEX idx_legal_notice_sub_queue_sub_id (subscriber_id),
    CONSTRAINT fk_legal_notice_sub_queue_sub FOREIGN KEY (subscriber_id) REFERENCES newsletter_subscribers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'legal_notice_sub_queue: OK';

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
