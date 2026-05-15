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

    echo "Tabuľky 'users', 'users_profile_archive', 'users_avatar_archive', 'password_resets' a 'admin_users_notice_audit' boli úspešne vytvorené alebo už existujú.";
    echo "\n";

    $articlesSql = "CREATE TABLE IF NOT EXISTS articles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(500) NOT NULL,
        slug VARCHAR(500) NOT NULL,
        author VARCHAR(255) NOT NULL DEFAULT 'Dr. Ľubomír Polaščín',
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

} catch (\PDOException $e) {
    echo "Chyba pri vytváraní tabuľky: " . $e->getMessage();
}
?>
