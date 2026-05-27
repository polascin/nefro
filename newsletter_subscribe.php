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
    } else {
        $pdo->prepare(
            "INSERT INTO newsletter_subscribers (email, verify_token, unsub_token) VALUES (:email, :vt, :ut)"
        )->execute(['email' => $email, 'vt' => $verifyToken, 'ut' => $unsubToken]);
    }

    sendSubscriberVerifyEmail($email, $verifyToken);

    echo json_encode(['success' => true, 'message' => 'Skoro hotovo! Skontrolujte e-mailovú schránku a potvrďte odber kliknutím na odkaz v e-maili.']);
} catch (\Throwable $e) {
    error_log('newsletter_subscribe error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Nastala chyba. Skúste to neskôr.']);
}
