<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$email = strtolower(trim((string) ($_POST['email'] ?? '')));

// Honeypot
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    echo json_encode(['success' => true, 'message' => 'Skoro hotovo! Skontrolujte e-mailovú schránku.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Neplatná e-mailová adresa.']);
    exit;
}

// IP rate limiting
$_nlIp    = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$_nlMax   = 5;
$_nlBlock = 3600;
try {
    $pdo->prepare("DELETE FROM form_rate_limit WHERE action = 'nl_subscribe' AND blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")->execute();
    $_nlRlStmt = $pdo->prepare("SELECT attempt_count, blocked_until FROM form_rate_limit WHERE ip = :ip AND action = 'nl_subscribe'");
    $_nlRlStmt->execute(['ip' => $_nlIp]);
    $_nlRlRow = $_nlRlStmt->fetch();
    if ($_nlRlRow && !empty($_nlRlRow['blocked_until'])) {
        if (strtotime((string) $_nlRlRow['blocked_until']) > time()) {
            echo json_encode(['success' => false, 'message' => 'Príliš veľa pokusov. Skúste to neskôr.']);
            exit;
        }
        $pdo->prepare("UPDATE form_rate_limit SET blocked_until = NULL WHERE ip = :ip AND action = 'nl_subscribe'")->execute(['ip' => $_nlIp]);
    }
    $pdo->prepare("INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt) VALUES (:ip, 'nl_subscribe', 1, NOW()) ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()")->execute(['ip' => $_nlIp]);
    $_nlCntStmt = $pdo->prepare("SELECT attempt_count FROM form_rate_limit WHERE ip = :ip AND action = 'nl_subscribe'");
    $_nlCntStmt->execute(['ip' => $_nlIp]);
    if ((int) ($_nlCntStmt->fetchColumn() ?? 0) >= $_nlMax) {
        $pdo->prepare("UPDATE form_rate_limit SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip AND action = 'nl_subscribe'")->execute(['secs' => $_nlBlock, 'ip' => $_nlIp]);
    }
} catch (\PDOException $e) {
    error_log('nl_subscribe rate limit error: ' . $e->getMessage());
}

try {
    // Registrovaný používateľ — nasmeruj na profil
    $userStmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(email) = :email AND is_active = 1 LIMIT 1");
    $userStmt->execute(['email' => $email]);
    if ($userStmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Tento e-mail je viazaný na registrovaný účet. <a href="login.php">Prihláste sa</a> a odber nastavte v Profili.',
            'registered' => true,
        ]);
        exit;
    }

    $subStmt = $pdo->prepare("SELECT id, verified_at, unsubscribed_at FROM newsletter_subscribers WHERE email = :email LIMIT 1");
    $subStmt->execute(['email' => $email]);
    $existing = $subStmt->fetch();

    if ($existing
        && $existing['verified_at'] !== null
        && $existing['unsubscribed_at'] === null
    ) {
        echo json_encode(['success' => true, 'message' => 'Tento e-mail je už prihlásený na odber. Tešíme sa na vás!', 'already' => true]);
        exit;
    }

    $verifyToken = bin2hex(random_bytes(32));
    $unsubToken  = bin2hex(random_bytes(32));

    if ($existing) {
        $pdo->prepare(
            "UPDATE newsletter_subscribers
             SET verify_token = :vt, unsub_token = :ut, verified_at = NULL, unsubscribed_at = NULL, updated_at = NOW()
             WHERE id = :id"
        )->execute(['vt' => $verifyToken, 'ut' => $unsubToken, 'id' => (int) $existing['id']]);
        // Zruš čakajúce položky — po resete overovania sa nesmú odoslať.
        $pdo->prepare(
            "UPDATE nl_sub_queue SET status = 'cancelled', last_error = 'Odberateľ znovu podal formulár a resetoval overenie.'
             WHERE subscriber_id = :sid AND status IN ('pending','failed') AND sent_at IS NULL"
        )->execute(['sid' => (int) $existing['id']]);
    } else {
        $pdo->prepare(
            "INSERT INTO newsletter_subscribers (email, verify_token, unsub_token) VALUES (:email, :vt, :ut)"
        )->execute(['email' => $email, 'vt' => $verifyToken, 'ut' => $unsubToken]);
    }

    if (!sendSubscriberVerifyEmail($email, $verifyToken)) {
        echo json_encode(['success' => false, 'message' => 'Nepodarilo sa odoslať overovací e-mail. Skúste to neskôr.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Skoro hotovo! Skontrolujte e-mailovú schránku a potvrďte odber kliknutím na odkaz v e-maili.']);
} catch (\Throwable $e) {
    error_log('newsletter_subscribe error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Nastala chyba. Skúste to neskôr.']);
}
