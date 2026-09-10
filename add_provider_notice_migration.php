<?php

declare(strict_types=1);
/**
 * add_provider_notice_migration.php
 *
 * Schéma pre informovanie poskytovateľov podľa čl. 14 GDPR:
 *   - provider_notice_queue  fronta oznámení (rovnaký vzor ako legal_notice_queue)
 *   - provider_suppressions  zoznam namietajúcich (len HMAC odtlačok e-mailu)
 *   - partner_providers      + notice_status, notice_sent_at
 *
 * `provider_suppressions` zámerne neukladá e-mail v čitateľnej podobe. Po námietke
 * podľa čl. 21 sa záznam poskytovateľa maže; jediné, čo potrebujeme si pamätať, je
 * schopnosť rozpoznať ten istý kontakt pri budúcom seedovaní, aby sme ho nevložili
 * a neoslovili znova. Na to stačí nezvratný odtlačok — ukladať samotnú adresu by bolo
 * v rozpore s minimalizáciou údajov (čl. 5 ods. 1 písm. c)).
 *
 * UNIQUE (notice_version, email) je funkčné, nielen ochranné: v adresári zdieľa
 * viacero záznamov tú istú schránku (38 e-mailov, 35 unikátnych), takže bez neho
 * by tá istá schránka dostala oznámenie viac ráz.
 *
 * Idempotentné. Spustenie:
 *   - admin cez prehliadač (requireAdmin), alebo
 *   - CLI cez SSH: php add_provider_notice_migration.php
 *
 * Poradie nasadenia: túto migráciu commitni, nasaď a SPUSTI PRED kódom
 * (provider_notices.php, provider_notice_worker.php, provider_namietka.php).
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Spustiť migráciu oznámení poskytovateľom');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$steps = [];

$pdo->exec("CREATE TABLE IF NOT EXISTS provider_notice_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    notice_version VARCHAR(20) NOT NULL,
    provider_id INT NOT NULL,
    email VARCHAR(190) NOT NULL,
    status ENUM('pending', 'sent', 'failed', 'cancelled') NOT NULL DEFAULT 'pending',
    attempts INT NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sent_at DATETIME NULL,
    last_error TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_pnq_version_email (notice_version, email),
    INDEX idx_pnq_status_next (status, next_attempt_at),
    INDEX idx_pnq_provider (provider_id),
    CONSTRAINT fk_pnq_provider FOREIGN KEY (provider_id)
        REFERENCES partner_providers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'provider_notice_queue: OK';

$pdo->exec("CREATE TABLE IF NOT EXISTS provider_suppressions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_hash CHAR(64) NOT NULL,
    reason VARCHAR(30) NOT NULL DEFAULT 'namietka',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_ps_hash (email_hash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$steps[] = 'provider_suppressions: OK';

/** @var list<string> $cols */
$cols = $pdo->query('SHOW COLUMNS FROM partner_providers')->fetchAll(PDO::FETCH_COLUMN, 0);

if (!in_array('notice_status', $cols, true)) {
    $pdo->exec("ALTER TABLE partner_providers
        ADD COLUMN notice_status VARCHAR(20) NOT NULL DEFAULT 'neinformovany' AFTER contacted_at");
    $steps[] = 'notice_status: pridaný';
} else {
    $steps[] = 'notice_status: existuje';
}

if (!in_array('notice_sent_at', $cols, true)) {
    $pdo->exec('ALTER TABLE partner_providers ADD COLUMN notice_sent_at DATETIME NULL AFTER notice_status');
    $steps[] = 'notice_sent_at: pridaný';
} else {
    $steps[] = 'notice_sent_at: existuje';
}

try {
    $pdo->exec('ALTER TABLE partner_providers ADD INDEX idx_pp_notice (notice_status)');
    $steps[] = 'idx_pp_notice: pridaný';
} catch (PDOException $e) {
    $steps[] = 'idx_pp_notice: existuje/preskočený';
}

foreach ($steps as $s) {
    echo $s . PHP_EOL;
}
echo 'Migrácia dokončená.' . PHP_EOL;
