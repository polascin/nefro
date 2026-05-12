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

    echo "Tabuľky 'users', 'users_profile_archive', 'users_avatar_archive' a 'password_resets' boli úspešne vytvorené alebo už existujú.";
} catch (\PDOException $e) {
    echo "Chyba pri vytváraní tabuľky: " . $e->getMessage();
}
?>
