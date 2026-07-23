<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, max-age=0');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Nepovolená metóda.']);
    exit;
}

// Vlastná hlavička sa nedá odoslať cez cross-site HTML formulár a cross-site
// JavaScript by pred POST požiadavkou potreboval úspešný CORS preflight.
if (!hash_equals('1', (string) ($_SERVER['HTTP_X_NPS_NEWSLETTER'] ?? ''))) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Neplatná požiadavka.']);
    exit;
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

// Origin/Referer check — bráni CSRF z tretích stránok.
// Prehliadač vždy posiela Origin hlavičku pre cross-site POST; útočník ju nemôže spoofiť.
// V lokálnom vývoji sa kontrola preskakuje (rôzne hosty/porty).
if (!isAppLocalDev()) {
    $_nlAllowedHost = 'nefro.polascin.net';
    $_nlOrigin      = $_SERVER['HTTP_ORIGIN'] ?? '';
    $_nlReferer     = $_SERVER['HTTP_REFERER'] ?? '';
    $_nlHostOk      = false;
    if ($_nlOrigin !== '') {
        $_nlHostOk = (parse_url($_nlOrigin, PHP_URL_HOST) === $_nlAllowedHost);
    } elseif ($_nlReferer !== '') {
        $_nlHostOk = (parse_url($_nlReferer, PHP_URL_HOST) === $_nlAllowedHost);
    }
    if (!$_nlHostOk) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Neplatná požiadavka.']);
        exit;
    }
}

$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$genericSuccessMessage = 'Ak je možné túto adresu prihlásiť na odber, poslali sme na ňu ďalšie pokyny.';

// Honeypot
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    echo json_encode(['success' => true, 'message' => $genericSuccessMessage]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Neplatná e-mailová adresa.']);
    exit;
}

// IP rate limiting
$_nlIp    = getClientIpAddress();
if (!checkFormRateLimit($pdo, 'nl_subscribe', $_nlIp, 5, 3600)) {
    echo json_encode(['success' => false, 'message' => 'Príliš veľa pokusov. Skúste to neskôr.']);
    exit;
}

try {
    // Odpoveď nesmie prezradiť, či adresa patrí registrovanému používateľovi.
    $userStmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(email) = :email AND is_active = 1 LIMIT 1");
    $userStmt->execute(['email' => $email]);
    if ($userStmt->fetch()) {
        echo json_encode(['success' => true, 'message' => $genericSuccessMessage]);
        exit;
    }

    $subStmt = $pdo->prepare("SELECT id, verified_at, unsubscribed_at FROM newsletter_subscribers WHERE email = :email LIMIT 1");
    $subStmt->execute(['email' => $email]);
    $existing = $subStmt->fetch();

    if ($existing
        && $existing['verified_at'] !== null
        && $existing['unsubscribed_at'] === null
    ) {
        echo json_encode(['success' => true, 'message' => $genericSuccessMessage]);
        exit;
    }

    $verifyToken     = bin2hex(random_bytes(32));
    $unsubToken      = bin2hex(random_bytes(32));
    $verifyTokenHash = hash('sha256', $verifyToken);
    $unsubTokenHash  = hash('sha256', $unsubToken);

    if ($existing) {
        $pdo->prepare(
            "UPDATE newsletter_subscribers
             SET verify_token = :vt, unsub_token = :ut, verified_at = NULL, unsubscribed_at = NULL, updated_at = NOW()
             WHERE id = :id"
        )->execute(['vt' => $verifyTokenHash, 'ut' => $unsubTokenHash, 'id' => (int) $existing['id']]);
        // Zruš čakajúce položky — po resete overovania sa nesmú odoslať.
        $pdo->prepare(
            "UPDATE nl_sub_queue SET status = 'cancelled', last_error = 'Odberateľ znovu podal formulár a resetoval overenie.'
             WHERE subscriber_id = :sid AND status IN ('pending','failed') AND sent_at IS NULL"
        )->execute(['sid' => (int) $existing['id']]);
    } else {
        $pdo->prepare(
            "INSERT INTO newsletter_subscribers (email, verify_token, unsub_token) VALUES (:email, :vt, :ut)"
        )->execute(['email' => $email, 'vt' => $verifyTokenHash, 'ut' => $unsubTokenHash]);
    }

    if (!sendSubscriberVerifyEmail($email, $verifyToken)) {
        error_log('newsletter_subscribe: overovací e-mail sa nepodarilo odoslať pre subscriber_id=' . (int) ($existing['id'] ?? $pdo->lastInsertId()));
    }

    echo json_encode(['success' => true, 'message' => $genericSuccessMessage]);
} catch (\Throwable $e) {
    error_log('newsletter_subscribe error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Nastala chyba. Skúste to neskôr.']);
}
