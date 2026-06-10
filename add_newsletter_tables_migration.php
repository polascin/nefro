<?php
declare(strict_types=1);
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    verify_token VARCHAR(64) NULL,
    verified_at DATETIME NULL,
    unsubscribed_at DATETIME NULL,
    unsub_token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_ns_email (email),
    INDEX idx_ns_verified (verified_at),
    INDEX idx_ns_unsub (unsub_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'newsletter_subscribers: OK';

$pdo->exec("CREATE TABLE IF NOT EXISTS nl_sub_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    subscriber_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    status ENUM('pending','sent','failed','cancelled') NOT NULL DEFAULT 'pending',
    attempts INT NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sent_at DATETIME NULL,
    last_error TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_nl_sub_queue (article_id, subscriber_id),
    INDEX idx_nl_sub_queue_status (status, next_attempt_at),
    CONSTRAINT fk_nl_sub_queue_article FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    CONSTRAINT fk_nl_sub_queue_sub FOREIGN KEY (subscriber_id) REFERENCES newsletter_subscribers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'nl_sub_queue: OK';

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
