<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Forbidden');
}

require_once __DIR__ . '/db_config.php';
/** @var PDO $pdo */

$pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_consent_audit (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_type ENUM('user','subscriber') NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    email_digest CHAR(64) NOT NULL,
    event ENUM('granted','withdrawn') NOT NULL,
    consent_version VARCHAR(20) NOT NULL,
    consent_text TEXT NOT NULL,
    source VARCHAR(80) NOT NULL,
    occurred_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    retain_until DATETIME NULL,
    INDEX idx_nca_subject (subject_type, subject_id),
    INDEX idx_nca_email_event (email_digest, event),
    INDEX idx_nca_retention (retain_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

$pdo->exec("CREATE TABLE IF NOT EXISTS content_notices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reporter_name VARCHAR(255) NULL,
    reporter_email VARCHAR(254) NULL,
    contact_exemption TINYINT(1) NOT NULL DEFAULT 0,
    content_url VARCHAR(2048) NOT NULL,
    legal_basis VARCHAR(1000) NOT NULL,
    explanation TEXT NOT NULL,
    good_faith TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('received','reviewing','actioned','rejected') NOT NULL DEFAULT 'received',
    decision VARCHAR(100) NULL,
    decision_reason TEXT NULL,
    affected_email VARCHAR(254) NULL,
    decided_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_content_notices_status_created (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

echo "Compliance tables are ready.\n";
