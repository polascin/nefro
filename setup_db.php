<?php
// Ochrana pred priamym prístupom z webu
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__) && php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}
require_once 'db_config.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        gender VARCHAR(50),
        pronouns VARCHAR(50),
        avatar_path VARCHAR(255),
        email VARCHAR(255) UNIQUE NOT NULL,
        email_verified_at DATETIME NULL,
        email_verification_token_hash VARCHAR(255) NULL,
        email_verification_expires_at DATETIME NULL,
        email_verification_sent_at DATETIME NULL,
        mobile_verified_at DATETIME NULL,
        mobile_verification_code_hash CHAR(64) NULL,
        mobile_verification_expires_at DATETIME NULL,
        mobile_verification_sent_at DATETIME NULL,
        password_hash VARCHAR(255) NOT NULL,
        title_before VARCHAR(50),
        first_name VARCHAR(255),
        middle_name VARCHAR(255),
        last_name VARCHAR(255),
        title_after VARCHAR(50),
        name_note TEXT,
        organization VARCHAR(255),
        job_function VARCHAR(255),
        work_mobile_phone VARCHAR(50),
        org_website VARCHAR(255),
        work_email VARCHAR(255),
        mobile_phone VARCHAR(50),
        other_phone VARCHAR(50),
        social_linkedin VARCHAR(255),
        social_x VARCHAR(255),
        social_facebook VARCHAR(255),
        social_instagram VARCHAR(255),
        social_other TEXT,
        other_contact TEXT,
        website VARCHAR(255),
        birth_date DATE,
        street VARCHAR(255),
        house_number VARCHAR(50),
        orientation_number VARCHAR(50),
        zip_code VARCHAR(20),
        city VARCHAR(255),
        district VARCHAR(255),
        region VARCHAR(255),
        country VARCHAR(255),
        address_note TEXT,
        is_admin TINYINT(1) DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        newsletter_consent TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);

    $isAdminColumnStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'is_admin'");
    $isAdminColumnStmt->execute();
    if ((int) $isAdminColumnStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0");
    }

    $isActiveColumnStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'is_active'");
    $isActiveColumnStmt->execute();
    if ((int) $isActiveColumnStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1");
    }

    $districtColumnStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'district'");
    $districtColumnStmt->execute();
    if ((int) $districtColumnStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN district VARCHAR(255) NULL AFTER city");
    }

    $mobilePhoneColumnStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'mobile_phone'");
    $mobilePhoneColumnStmt->execute();
    if ((int) $mobilePhoneColumnStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN mobile_phone VARCHAR(50) NULL AFTER work_email");
    }

    $emailVerifiedAtAdded = false;
    $emailVerifiedAtStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email_verified_at'");
    $emailVerifiedAtStmt->execute();
    if ((int) $emailVerifiedAtStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN email_verified_at DATETIME NULL AFTER email");
        $emailVerifiedAtAdded = true;
    }

    $emailTokenHashStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email_verification_token_hash'");
    $emailTokenHashStmt->execute();
    if ((int) $emailTokenHashStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN email_verification_token_hash VARCHAR(255) NULL AFTER email_verified_at");
    }

    $emailExpiresStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email_verification_expires_at'");
    $emailExpiresStmt->execute();
    if ((int) $emailExpiresStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN email_verification_expires_at DATETIME NULL AFTER email_verification_token_hash");
    }

    $emailSentAtStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email_verification_sent_at'");
    $emailSentAtStmt->execute();
    if ((int) $emailSentAtStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN email_verification_sent_at DATETIME NULL AFTER email_verification_expires_at");
    }

    $mobileVerifiedAtStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'mobile_verified_at'");
    $mobileVerifiedAtStmt->execute();
    if ((int) $mobileVerifiedAtStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN mobile_verified_at DATETIME NULL AFTER email_verification_sent_at");
    }

    $mobileCodeHashStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'mobile_verification_code_hash'");
    $mobileCodeHashStmt->execute();
    if ((int) $mobileCodeHashStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN mobile_verification_code_hash CHAR(64) NULL AFTER mobile_verified_at");
    }

    $mobileExpiresStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'mobile_verification_expires_at'");
    $mobileExpiresStmt->execute();
    if ((int) $mobileExpiresStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN mobile_verification_expires_at DATETIME NULL AFTER mobile_verification_code_hash");
    }

    $mobileSentAtStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'mobile_verification_sent_at'");
    $mobileSentAtStmt->execute();
    if ((int) $mobileSentAtStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN mobile_verification_sent_at DATETIME NULL AFTER mobile_verification_expires_at");
    }

    // Pri prvom zavedení stĺpca považujeme existujúce účty za overené,
    // aby sa neblokovali produkčné prístupy.
    if ($emailVerifiedAtAdded) {
        $pdo->exec("UPDATE users SET email_verified_at = NOW() WHERE email_verified_at IS NULL");
    }

    $profileArchiveSql = "CREATE TABLE IF NOT EXISTS users_profile_archive (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        changed_fields JSON NOT NULL,
        previous_data JSON NOT NULL,
        changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_users_profile_archive_user_id (user_id),
        CONSTRAINT fk_users_profile_archive_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $avatarArchiveSql = "CREATE TABLE IF NOT EXISTS users_avatar_archive (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action ENUM('updated', 'deleted') NOT NULL,
        original_path VARCHAR(255) NOT NULL,
        archived_path VARCHAR(255),
        replacement_path VARCHAR(255),
        changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_users_avatar_archive_user_id (user_id),
        CONSTRAINT fk_users_avatar_archive_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($profileArchiveSql);
    $pdo->exec($avatarArchiveSql);

    $loginAttemptsSql = "CREATE TABLE IF NOT EXISTS login_attempts (
        ip VARCHAR(45) NOT NULL,
        attempt_count INT NOT NULL DEFAULT 1,
        first_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        blocked_until TIMESTAMP NULL DEFAULT NULL,
        PRIMARY KEY (ip),
        INDEX idx_login_attempts_blocked (blocked_until)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($loginAttemptsSql);

    $passwordResetsSql = "CREATE TABLE IF NOT EXISTS password_resets (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        token_hash CHAR(64) NOT NULL,
        expires_at DATETIME NOT NULL,
        requested_ip VARCHAR(45) NULL,
        used_at DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_password_resets_token_hash (token_hash),
        INDEX idx_password_resets_user_id (user_id),
        INDEX idx_password_resets_expires_at (expires_at),
        CONSTRAINT fk_password_resets_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($passwordResetsSql);

    $accessLogsSql = "CREATE TABLE IF NOT EXISTS access_logs (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        username VARCHAR(255) NULL,
        event_type VARCHAR(50) NOT NULL DEFAULT 'page_view',
        method VARCHAR(10) NOT NULL DEFAULT 'GET',
        request_uri VARCHAR(2048) NOT NULL,
        query_string VARCHAR(2048) NULL,
        http_status SMALLINT NOT NULL DEFAULT 200,
        client_ip VARCHAR(45) NULL,
        user_agent VARCHAR(500) NULL,
        referer VARCHAR(2048) NULL,
        host VARCHAR(255) NULL,
        accept_language VARCHAR(255) NULL,
        response_time_ms INT NULL,
        is_bot TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_access_logs_created_at (created_at),
        INDEX idx_access_logs_user_id (user_id),
        INDEX idx_access_logs_http_status (http_status),
        INDEX idx_access_logs_client_ip (client_ip),
        CONSTRAINT fk_access_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($accessLogsSql);

    $adminExportsAuditSql = "CREATE TABLE IF NOT EXISTS admin_users_notice_audit (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        admin_user_id INT NOT NULL,
        export_format VARCHAR(20) NOT NULL,
        include_sensitive TINYINT(1) NOT NULL DEFAULT 0,
        generated_rows INT NOT NULL DEFAULT 0,
        client_ip VARCHAR(45) NULL,
        user_agent VARCHAR(500) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_admin_users_notice_audit_created_at (created_at),
        INDEX idx_admin_users_notice_audit_admin_user_id (admin_user_id),
        CONSTRAINT fk_admin_users_notice_audit_user FOREIGN KEY (admin_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($adminExportsAuditSql);

    // ── Rate limiting pre formuláre (registrácia, reset hesla, atď.) ────────
    // UNIQUE KEY na (ip, action) je nevyhnutný pre správne fungovanie
    // ON DUPLICATE KEY UPDATE v register.php, resend_verification.php a verify_email.php.
    $formRateLimitSql = "CREATE TABLE IF NOT EXISTS form_rate_limit (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(45) NOT NULL,
        action VARCHAR(50) NOT NULL COMMENT 'Identifikátor akcie (napr. register, forgot_password)',
        attempt_count INT NOT NULL DEFAULT 1,
        first_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        blocked_until TIMESTAMP NULL DEFAULT NULL,
        UNIQUE KEY uq_form_rate_limit_ip_action (ip, action),
        INDEX idx_form_rate_limit_blocked (blocked_until)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($formRateLimitSql);
    echo "Tabuľka 'form_rate_limit' bola úspešne vytvorená alebo už existuje.\n";

    // ── Migrácia: pridanie UNIQUE constraint pre existujúce inštalácie ────────
    $uqCheckStmt = $pdo->prepare(
        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME   = 'form_rate_limit'
           AND INDEX_NAME   = 'uq_form_rate_limit_ip_action'"
    );
    $uqCheckStmt->execute();
    if ((int) $uqCheckStmt->fetchColumn() === 0) {
        // Odstrán duplikáty (ponechaj riadok s najvyšším attempt_count per ip+action)
        $pdo->exec("
            DELETE t1 FROM form_rate_limit t1
            INNER JOIN form_rate_limit t2
                ON t1.ip = t2.ip AND t1.action = t2.action
            WHERE t1.attempt_count < t2.attempt_count
               OR (t1.attempt_count = t2.attempt_count AND t1.id < t2.id)
        ");
        // Staré INDEX nahraď UNIQUE KEY
        try {
            $pdo->exec("ALTER TABLE form_rate_limit DROP INDEX idx_form_rate_limit_ip_action");
        } catch (\PDOException) { /* index nemusí existovať */ }
        $pdo->exec(
            "ALTER TABLE form_rate_limit
             ADD UNIQUE KEY uq_form_rate_limit_ip_action (ip, action)"
        );
        echo "Migracia: UNIQUE constraint pridany do form_rate_limit.\n";
    }

    // ── Audit log pre zrušenie/vymazanie účtov ───────────────────────────────
    // Zámerne BEZ FK na users(id) — záznam musí pretrvať po vymazaní používateľa.
    // E-mail je uložený ako SHA-256 hash (GDPR — možnosť overenia bez uchovávania plaintextu).
    // IP adresa a username podliehajú retenčnej politike (odporúčané vymazanie po 90 dňoch).
    $accountDeletionLogSql = "CREATE TABLE IF NOT EXISTS account_deletion_log (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        deleted_user_id INT NOT NULL COMMENT 'ID vymazaného používateľa (bez FK)',
        username VARCHAR(255) NOT NULL COMMENT 'Meno v čase vymazania (retenčná politika: 90 dní)',
        email_hash CHAR(64) NOT NULL COMMENT 'SHA-256 hex hash e-mailu',
        email_domain VARCHAR(255) NOT NULL COMMENT 'Doména e-mailu pre štatistiky',
        is_admin TINYINT(1) NOT NULL DEFAULT 0,
        account_age_days INT NOT NULL DEFAULT 0 COMMENT 'Vek účtu od registrácie v dňoch',
        initiated_by ENUM('user_self', 'admin') NOT NULL DEFAULT 'user_self',
        admin_actor_id INT NULL COMMENT 'ID admina pri admin-iniciovanom mazaní',
        client_ip VARCHAR(45) NOT NULL COMMENT 'IP žiadateľa (retenčná politika: 90 dní)',
        user_agent VARCHAR(500) NULL,
        stat_calculator_results INT NOT NULL DEFAULT 0 COMMENT 'Počet vymazaných výsledkov kalkulačiek',
        stat_profile_changes INT NOT NULL DEFAULT 0 COMMENT 'Počet záznamov v profile archive',
        had_avatar TINYINT(1) NOT NULL DEFAULT 0,
        had_newsletter_consent TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_adl_deleted_user_id (deleted_user_id),
        INDEX idx_adl_created_at (created_at),
        INDEX idx_adl_client_ip (client_ip),
        INDEX idx_adl_email_hash (email_hash)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($accountDeletionLogSql);
    echo "Tabuľka 'account_deletion_log' bola úspešne vytvorená alebo už existuje.\n";

    echo "Tabuľky 'users', 'users_profile_archive', 'users_avatar_archive', 'password_resets' a 'admin_users_notice_audit' boli úspešne vytvorené alebo už existujú.";
    echo "\n";

    $articlesSql = "CREATE TABLE IF NOT EXISTS articles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(500) NOT NULL,
        slug VARCHAR(500) NOT NULL,
        author VARCHAR(255) NOT NULL DEFAULT 'MUDr. Ľubomír Polaščín',
        content LONGTEXT NOT NULL,
        excerpt TEXT NOT NULL,
        published_at DATETIME NOT NULL,
        is_top TINYINT(1) NOT NULL DEFAULT 0,
        is_published TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_articles_slug (slug),
        INDEX idx_articles_published_at (published_at),
        INDEX idx_articles_is_top (is_top),
        INDEX idx_articles_is_published (is_published)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($articlesSql);
    echo "Tabuľka 'articles' bola úspešne vytvorená alebo už existuje.\n";

    $articleNewsletterQueueSql = "CREATE TABLE IF NOT EXISTS article_newsletter_queue (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        article_id INT NOT NULL,
        user_id INT NOT NULL,
        email VARCHAR(255) NOT NULL,
        status ENUM('pending', 'sent', 'failed', 'cancelled') NOT NULL DEFAULT 'pending',
        attempts INT NOT NULL DEFAULT 0,
        next_attempt_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        sent_at DATETIME NULL,
        last_error TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_article_newsletter_queue_article_user (article_id, user_id),
        INDEX idx_article_newsletter_queue_status_next (status, next_attempt_at),
        INDEX idx_article_newsletter_queue_user_id (user_id),
        CONSTRAINT fk_article_newsletter_queue_article FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
        CONSTRAINT fk_article_newsletter_queue_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($articleNewsletterQueueSql);
    echo "Tabuľka 'article_newsletter_queue' bola úspešne vytvorená alebo už existuje.\n";

    $calculatorResultsSql = "CREATE TABLE IF NOT EXISTS calculator_results (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        calculator_key VARCHAR(100) NOT NULL,
        calculator_label VARCHAR(255) NOT NULL,
        patient_first_name VARCHAR(100) NULL,
        patient_last_name VARCHAR(100) NULL,
        patient_birth_date DATE NULL,
        patient_birth_number VARCHAR(20) NULL,
        patient_insurance_code VARCHAR(10) NULL,
        input_payload JSON NOT NULL,
        result_payload JSON NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_calculator_results_user (user_id),
        INDEX idx_calculator_results_calculator (calculator_key),
        INDEX idx_calculator_results_created (created_at),
        CONSTRAINT fk_calculator_results_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($calculatorResultsSql);
    echo "Tabuľka 'calculator_results' bola úspešne vytvorená alebo už existuje.\n";

    // ── Číselník zdravotných poisťovní SR ────────────────────────────────
    $insuranceSql = "CREATE TABLE IF NOT EXISTS insurance_companies (
        id SMALLINT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(10) NOT NULL UNIQUE COMMENT 'Číselný kód poisťovne (napr. 24)',
        nazov VARCHAR(255) NOT NULL COMMENT 'Úradný názov poisťovne',
        skratka VARCHAR(50) NOT NULL COMMENT 'Obchodná skratka (napr. VšZP)',
        aktivna TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = aktívna, 0 = historická',
        poznamka TEXT NULL COMMENT 'Voliteľná poznámka (napr. dôvod zániku)',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_insurance_code (code),
        INDEX idx_insurance_aktivna (aktivna)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($insuranceSql);
    echo "Tabuľka 'insurance_companies' bola úspešne vytvorená alebo už existuje.\n";

    // Seed: vloží aktuálne aktívne poisťovne (ignoruje duplicity)
    $insuranceSeedSql = "INSERT IGNORE INTO insurance_companies (code, nazov, skratka, aktivna) VALUES
        ('24', 'Všeobecná zdravotná poisťovňa, a. s.', 'VšZP',   1),
        ('25', 'DÔVERA zdravotná poisťovňa, a. s.',   'DÔVERA',  1),
        ('27', 'UNION zdravotná poisťovňa, a. s.',     'UNION',   1)";
    $pdo->exec($insuranceSeedSql);
    echo "Seed dáta poisťovní boli vložené (duplicity ignorované).\n";

    // Migrácia: rozšíriť patient_insurance_code na VARCHAR(10) ak je kratší
    $insColStmt = $pdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME   = 'calculator_results'
          AND COLUMN_NAME  = 'patient_insurance_code'");
    $insColStmt->execute();
    $insColLen = (int) $insColStmt->fetchColumn();
    if ($insColLen > 0 && $insColLen < 10) {
        $pdo->exec("ALTER TABLE calculator_results MODIFY COLUMN patient_insurance_code VARCHAR(10) NULL");
        echo "Migrácia: patient_insurance_code rozšírená na VARCHAR(10).\n";
    }

    // ── Migrácia: sort_order stĺpec ──────────────────────────────────
    $sortOrderColumnStmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'articles' AND COLUMN_NAME = 'sort_order'");
    $sortOrderColumnStmt->execute();
    if ((int) $sortOrderColumnStmt->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE articles ADD COLUMN sort_order INT NOT NULL DEFAULT 0");
        $pdo->exec("SET @row_num := 0; UPDATE articles SET sort_order = (@row_num := @row_num + 1) ORDER BY published_at DESC, id DESC");
        echo "Stĺpec 'sort_order' bol pridaný a inicializovaný.\n";
    }

    // ── Číselník akademických a iných titulov ───────────────────────
    $titleCodebookSql = "CREATE TABLE IF NOT EXISTS title_codebook (
        id SMALLINT AUTO_INCREMENT PRIMARY KEY,
        type ENUM('before', 'after') NOT NULL COMMENT 'before = pred menom, after = za menom',
        title VARCHAR(50) NOT NULL COMMENT 'Titul (napr. MUDr., PhD.)',
        sort_order SMALLINT NOT NULL DEFAULT 100 COMMENT 'Poradie zobrazenia (nižšie = skôr)',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_title_codebook_type_title (type, title),
        INDEX idx_title_codebook_type (type),
        INDEX idx_title_codebook_sort (sort_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($titleCodebookSql);
    echo "Tabuľka 'title_codebook' bola úspešne vytvorená alebo už existuje.\n";

    // Seed: tituly pred menom — akademické a odborné tituly SR/ČR
    $titleBeforeSeedSql = "INSERT IGNORE INTO title_codebook (type, title, sort_order) VALUES
        ('before', 'prof.',       10),
        ('before', 'doc.',        20),
        ('before', 'MUDr.',       30),
        ('before', 'MDDr.',       35),
        ('before', 'MVDr.',       40),
        ('before', 'RNDr.',       50),
        ('before', 'PhDr.',       55),
        ('before', 'JUDr.',       60),
        ('before', 'PaedDr.',     65),
        ('before', 'PhMr.',       70),
        ('before', 'Mgr.',        75),
        ('before', 'Mgr. art.',   76),
        ('before', 'Ing.',        80),
        ('before', 'Ing. arch.',  81),
        ('before', 'Bc.',         85),
        ('before', 'BcA.',        86),
        ('before', 'ThDr.',       90),
        ('before', 'ThLic.',      91),
        ('before', 'ThMgr.',      92),
        ('before', 'Dr.',         95),
        ('before', 'Dr. h. c.',   96),
        ('before', 'Dipl. Ing.', 100)";
    $pdo->exec($titleBeforeSeedSql);
    echo "Seed dáta titulov pred menom boli vložené (duplicity ignorované).\n";

    // Seed: tituly za menom — vedecké hodnosti a medzinárodné certifikácie
    $titleAfterSeedSql = "INSERT IGNORE INTO title_codebook (type, title, sort_order) VALUES
        ('after', 'PhD.',    10),
        ('after', 'Ph.D.',   11),
        ('after', 'CSc.',    20),
        ('after', 'DrSc.',   25),
        ('after', 'DSc.',    26),
        ('after', 'DBA',     30),
        ('after', 'MBA',     35),
        ('after', 'MSc.',    40),
        ('after', 'LL.M.',   45),
        ('after', 'MPH',     50),
        ('after', 'MHA',     51),
        ('after', 'MPA',     52),
        ('after', 'MPHA',    53),
        ('after', 'MPM',     54),
        ('after', 'FRCPS',   60),
        ('after', 'FACP',    61),
        ('after', 'FRCP',    62),
        ('after', 'dis.',    80),
        ('after', 'DiS.',    81)";
    $pdo->exec($titleAfterSeedSql);
    echo "Seed dáta titulov za menom boli vložené (duplicity ignorované).\n";

    // ── Číselník štátov ─────────────────────────────────────────────
    $pdo->exec("CREATE TABLE IF NOT EXISTS codebook_countries (
        id SMALLINT AUTO_INCREMENT PRIMARY KEY,
        code CHAR(2) NOT NULL COMMENT 'ISO 3166-1 alpha-2',
        name_sk VARCHAR(100) NOT NULL COMMENT 'Názov štátu v slovenčine',
        sort_order SMALLINT NOT NULL DEFAULT 100,
        UNIQUE KEY uq_codebook_countries_code (code),
        INDEX idx_codebook_countries_sort (sort_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Tabuľka 'codebook_countries' bola úspešne vytvorená alebo už existuje.\n";

    $pdo->exec("INSERT IGNORE INTO codebook_countries (code, name_sk, sort_order) VALUES
        ('SK','Slovenská republika',1),('CZ','Česká republika',2),('AT','Rakúsko',3),
        ('HU','Maďarsko',4),('PL','Poľsko',5),('DE','Nemecko',6),('UA','Ukrajina',7),
        ('AF','Afganistan',100),('AL','Albánsko',101),('DZ','Alžírsko',102),
        ('AD','Andorra',103),('AO','Angola',104),('AG','Antigua a Barbuda',105),
        ('AR','Argentína',106),('AM','Arménsko',107),('AU','Austrália',108),
        ('AZ','Azerbajdžan',109),('BS','Bahamy',110),('BH','Bahrajn',111),
        ('BD','Bangladéš',112),('BB','Barbados',113),('BE','Belgicko',114),
        ('BZ','Belize',115),('BJ','Benin',116),('BT','Bhután',117),
        ('BY','Bielorusko',118),('BO','Bolívia',119),('BA','Bosna a Hercegovina',120),
        ('BW','Botswana',121),('BR','Brazília',122),('BN','Brunej',123),
        ('BG','Bulharsko',124),('BF','Burkina Faso',125),('BI','Burundi',126),
        ('CL','Čile',127),('CN','Čína',128),('ME','Čierna Hora',129),
        ('TD','Čad',130),('DK','Dánsko',131),('DM','Dominika',132),
        ('DO','Dominikánska republika',133),('DJ','Džibutsko',134),
        ('EG','Egypt',135),('EC','Ekvádor',136),('ER','Eritrea',137),
        ('EE','Estónsko',138),('ET','Etiópia',139),('FJ','Fidži',140),
        ('PH','Filipíny',141),('FI','Fínsko',142),('FR','Francúzsko',143),
        ('GA','Gabon',144),('GM','Gambia',145),('GH','Ghana',146),
        ('GD','Grenada',147),('GE','Gruzínsko',148),('GT','Guatemala',149),
        ('GN','Guinea',150),('GW','Guinea-Bissau',151),('GY','Guyana',152),
        ('HT','Haiti',153),('NL','Holandsko',154),('HN','Honduras',155),
        ('HR','Chorvátsko',156),('ID','Indonézia',157),('IQ','Irak',158),
        ('IR','Irán',159),('IE','Írsko',160),('IS','Island',161),
        ('IL','Izrael',162),('JM','Jamajka',163),('JP','Japonsko',164),
        ('YE','Jemen',165),('JO','Jordánsko',166),('ZA','Južná Afrika',167),
        ('SS','Južný Sudán',168),('KH','Kambodža',169),('CM','Kamerun',170),
        ('CA','Kanada',171),('QA','Katar',172),('KZ','Kazachstan',173),
        ('KE','Keňa',174),('CY','Cyprus',175),('KI','Kiribati',176),
        ('CO','Kolumbia',177),('KM','Komory',178),('CG','Kongo',179),
        ('CD','Konžská demokratická republika',180),('KP','Kórea (KĽDR)',181),
        ('KR','Kórea (republika)',182),('XK','Kosovo',183),('CR','Kostarika',184),
        ('CU','Kuba',185),('KW','Kuvajt',186),('KG','Kirgizsko',187),
        ('LA','Laos',188),('LS','Lesotho',189),('LB','Libanon',190),
        ('LR','Libéria',191),('LY','Líbya',192),('LI','Lichtenštajnsko',193),
        ('LT','Litva',194),('LV','Lotyšsko',195),('LU','Luxembursko',196),
        ('MG','Madagaskar',197),('MK','Macedónsko',198),('MW','Malawi',199),
        ('MV','Maldivy',200),('MY','Malajzia',201),('ML','Mali',202),
        ('MT','Malta',203),('MA','Maroko',204),('MH','Marshallove ostrovy',205),
        ('MR','Mauritánia',206),('MU','Mauritius',207),('MX','Mexiko',208),
        ('FM','Mikronézia',209),('MD','Moldavsko',210),('MC','Monako',211),
        ('MN','Mongolsko',212),('MZ','Mozambik',213),('MM','Mjanmarsko',214),
        ('NA','Namíbia',215),('NR','Nauru',216),('NP','Nepál',217),
        ('NE','Niger',218),('NG','Nigéria',219),('NI','Nikaragua',220),
        ('NO','Nórsko',221),('NZ','Nový Zéland',222),('OM','Omán',223),
        ('PK','Pakistan',224),('PW','Palau',225),('PA','Panama',226),
        ('PG','Papua Nová Guinea',227),('PY','Paraguaj',228),('PE','Peru',229),
        ('PT','Portugalsko',230),('RO','Rumunsko',231),('RU','Rusko',232),
        ('RW','Rwanda',233),('SB','Šalamúnove ostrovy',234),('SM','San Maríno',235),
        ('SA','Saudská Arábia',236),('SN','Senegal',237),('SC','Seychely',238),
        ('SL','Sierra Leone',239),('SG','Singapur',240),('SI','Slovinsko',241),
        ('SO','Somálsko',242),('RS','Srbsko',243),('LK','Srí Lanka',244),
        ('SD','Sudán',245),('SR','Surinam',246),('SZ','Svazijsko',247),
        ('SY','Sýria',248),('ST','Svätý Tomáš a Princov ostrov',249),
        ('VC','Svätý Vincent a Grenadíny',250),('KN','Svätý Krištof a Nevis',251),
        ('LC','Svätá Lucia',252),('ES','Španielsko',253),('SE','Švédsko',254),
        ('CH','Švajčiarsko',255),('TJ','Tadžikistan',256),('TZ','Tanzánia',257),
        ('TH','Thajsko',258),('TL','Východný Timor',259),('TG','Togo',260),
        ('TO','Tonga',261),('TT','Trinidad a Tobago',262),('TN','Tunisko',263),
        ('TR','Turecko',264),('TM','Turkménsko',265),('TV','Tuvalu',266),
        ('UG','Uganda',267),('UY','Uruguaj',268),('UZ','Uzbekistan',269),
        ('VU','Vanuatu',270),('VA','Vatikán',271),('VE','Venezuela',272),
        ('VN','Vietnam',273),('GB','Veľká Británia',274),('US','Spojené štáty americké',275),
        ('AE','Spojené arabské emiráty',276),('CF','Stredoafrická republika',277),
        ('WS','Samoa',278),('ZM','Zambia',279),('ZW','Zimbabwe',280)");
    echo "Seed dáta štátov boli vložené (duplicity ignorované).\n";

    // ── Číselník krajov SR ───────────────────────────────────────────
    $pdo->exec("CREATE TABLE IF NOT EXISTS codebook_regions (
        id TINYINT AUTO_INCREMENT PRIMARY KEY,
        code CHAR(2) NOT NULL COMMENT 'Kód kraja (napr. BA)',
        name VARCHAR(80) NOT NULL COMMENT 'Názov kraja',
        country_code CHAR(2) NOT NULL DEFAULT 'SK',
        sort_order TINYINT NOT NULL DEFAULT 10,
        UNIQUE KEY uq_codebook_regions_code (code),
        INDEX idx_codebook_regions_country (country_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Tabuľka 'codebook_regions' bola úspešne vytvorená alebo už existuje.\n";

    $pdo->exec("INSERT IGNORE INTO codebook_regions (code, name, country_code, sort_order) VALUES
        ('BL','Bratislavský kraj','SK',1),
        ('TA','Trnavský kraj','SK',2),
        ('TC','Trenčiansky kraj','SK',3),
        ('NI','Nitriansky kraj','SK',4),
        ('ZI','Žilinský kraj','SK',5),
        ('BC','Banskobystrický kraj','SK',6),
        ('PV','Prešovský kraj','SK',7),
        ('KI','Košický kraj','SK',8)");
    echo "Seed dáta krajov SR boli vložené (duplicity ignorované).\n";

    // ── Číselník okresov SR ──────────────────────────────────────────
    $pdo->exec("CREATE TABLE IF NOT EXISTS codebook_districts (
        id SMALLINT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(80) NOT NULL COMMENT 'Názov okresu',
        region_code CHAR(2) NOT NULL COMMENT 'Kód kraja',
        sort_order SMALLINT NOT NULL DEFAULT 100,
        UNIQUE KEY uq_codebook_districts_name (name),
        INDEX idx_codebook_districts_region (region_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Tabuľka 'codebook_districts' bola úspešne vytvorená alebo už existuje.\n";

    $pdo->exec("INSERT IGNORE INTO codebook_districts (name, region_code, sort_order) VALUES
        ('Bratislava I','BL',1),('Bratislava II','BL',2),('Bratislava III','BL',3),
        ('Bratislava IV','BL',4),('Bratislava V','BL',5),('Malacky','BL',6),
        ('Pezinok','BL',7),('Senec','BL',8),
        ('Dunajská Streda','TA',10),('Galanta','TA',11),('Hlohovec','TA',12),
        ('Piešťany','TA',13),('Senica','TA',14),('Skalica','TA',15),('Trnava','TA',16),
        ('Bánovce nad Bebravou','TC',20),('Ilava','TC',21),('Myjava','TC',22),
        ('Nové Mesto nad Váhom','TC',23),('Partizánske','TC',24),
        ('Považská Bystrica','TC',25),('Púchov','TC',26),('Trenčín','TC',27),
        ('Komárno','NI',30),('Levice','NI',31),('Nitra','NI',32),
        ('Nové Zámky','NI',33),('Šaľa','NI',34),('Topoľčany','NI',35),
        ('Zlaté Moravce','NI',36),
        ('Bytča','ZI',40),('Čadca','ZI',41),('Dolný Kubín','ZI',42),
        ('Kysucké Nové Mesto','ZI',43),('Liptovský Mikuláš','ZI',44),
        ('Martin','ZI',45),('Námestovo','ZI',46),('Ružomberok','ZI',47),
        ('Turčianske Teplice','ZI',48),('Tvrdošín','ZI',49),('Žilina','ZI',50),
        ('Banská Bystrica','BC',60),('Banská Štiavnica','BC',61),('Brezno','BC',62),
        ('Detva','BC',63),('Krupina','BC',64),('Lučenec','BC',65),('Poltár','BC',66),
        ('Revúca','BC',67),('Rimavská Sobota','BC',68),('Veľký Krtíš','BC',69),
        ('Zvolen','BC',70),('Žarnovica','BC',71),('Žiar nad Hronom','BC',72),
        ('Bardejov','PV',80),('Humenné','PV',81),('Kežmarok','PV',82),
        ('Levoča','PV',83),('Medzilaborce','PV',84),('Poprad','PV',85),
        ('Prešov','PV',86),('Sabinov','PV',87),('Snina','PV',88),
        ('Spišská Stará Ves','PV',89),('Stará Ľubovňa','PV',90),
        ('Stropkov','PV',91),('Vranov nad Topľou','PV',92),
        ('Gelnica','KI',100),('Košice I','KI',101),('Košice II','KI',102),
        ('Košice III','KI',103),('Košice IV','KI',104),('Košice-okolie','KI',105),
        ('Michalovce','KI',106),('Rožňava','KI',107),('Sobrance','KI',108),
        ('Spišská Nová Ves','KI',109),('Trebišov','KI',110)");
    echo "Seed dáta okresov SR boli vložené (duplicity ignorované).\n";

    // ── Číselník obcí SR s PSČ ───────────────────────────────────────
    $pdo->exec("CREATE TABLE IF NOT EXISTS codebook_municipalities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL COMMENT 'Názov obce',
        district_name VARCHAR(80) NOT NULL COMMENT 'Okres',
        region_code CHAR(2) NOT NULL COMMENT 'Kód kraja',
        zip_code CHAR(5) NOT NULL COMMENT 'PSČ (5 číslic)',
        sort_order INT NOT NULL DEFAULT 100,
        UNIQUE KEY uq_codebook_mun_name_district (name, district_name),
        INDEX idx_codebook_mun_district (district_name),
        INDEX idx_codebook_mun_region (region_code),
        INDEX idx_codebook_mun_zip (zip_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Tabuľka 'codebook_municipalities' bola úspešne vytvorená alebo už existuje.\n";
    echo "Poznámka: Pre import všetkých obcí SR spustite seed_municipalities_sk.php\n";

} catch (\PDOException $e) {
    echo "Chyba pri vytváraní tabuľky: " . $e->getMessage();
}
?>
