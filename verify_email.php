<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
header('Referrer-Policy: no-referrer');
require_once __DIR__ . '/db_config.php';
if (!isset($pdo) || !$pdo instanceof \PDO) {
    throw new \RuntimeException('Databázové pripojenie nie je dostupné.');
}
require_once __DIR__ . '/email_verification.php';

const VERIFY_MAX_ATTEMPTS = 20;
const VERIFY_WINDOW_SECS  = 900;

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$status  = 'error';
$message = 'Neplatný alebo neúplný overovací odkaz.';
$showConfirmation = false;
$autoRedirect = false;

$verificationFlash = $requestMethod === 'GET'
    ? (string) ($_SESSION['verify_email_flash'] ?? '')
    : '';
if ($verificationFlash !== '') {
    unset($_SESSION['verify_email_flash']);
    $status = 'success';
    $message = 'E-mailová adresa bola úspešne overená. Teraz sa môžete prihlásiť.';
    $autoRedirect = true;
}

$uid   = (int) ($_GET['uid'] ?? $_POST['uid'] ?? 0);
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$tokenFormatValid = $uid > 0
    && preg_match('/^[A-Za-z0-9_-]{32,128}$/D', $token) === 1;

if ($requestMethod === 'GET' && $verificationFlash === '' && $tokenFormatValid) {
    // GET iba zobrazí potvrdenie. E-mailové skenery a prefetch tak nemôžu
    // spotrebovať token ani aktivovať účet bez vedomej akcie používateľa.
    $status = 'pending';
    $message = 'Kliknutím na tlačidlo potvrďte overenie svojej e-mailovej adresy.';
    $showConfirmation = true;
}

if ($requestMethod === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $message = 'Neplatný CSRF token. Skúste to znova.';
        $showConfirmation = $tokenFormatValid;
    } elseif (!$tokenFormatValid) {
        $message = 'Overovací odkaz nie je platný.';
    } else {
        $clientIp = getClientIpAddress();
        $rateLimitBlocked = false;

        try {
            // Pevné 15-minútové okno. Expirovaná aktívna blokácia sa resetuje,
            // platná blokácia sa nikdy neskracuje.
            $pdo->prepare(
                "DELETE FROM form_rate_limit
                 WHERE action = 'verify_email'
                   AND first_attempt < DATE_SUB(NOW(), INTERVAL 15 MINUTE)
                   AND (blocked_until IS NULL OR blocked_until <= NOW())"
            )->execute();

            $rlStmt = $pdo->prepare(
                "SELECT blocked_until
                 FROM form_rate_limit
                 WHERE ip = :ip AND action = 'verify_email'"
            );
            $rlStmt->execute(['ip' => $clientIp]);
            $blockedUntil = $rlStmt->fetchColumn();

            if ($blockedUntil !== false && $blockedUntil !== null) {
                $blockedUntilTs = strtotime((string) $blockedUntil);
                if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                    $rateLimitBlocked = true;
                } else {
                    $pdo->prepare(
                        "UPDATE form_rate_limit
                         SET attempt_count = 0, first_attempt = NOW(),
                             last_attempt = NOW(), blocked_until = NULL
                         WHERE ip = :ip AND action = 'verify_email'"
                    )->execute(['ip' => $clientIp]);
                }
            }

            if (!$rateLimitBlocked) {
                // Každý syntakticky platný POST sa započíta ešte pred lookupom
                // používateľa a kryptografickou validáciou tokenu.
                $pdo->prepare(
                    "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt)
                     VALUES (:ip, 'verify_email', 1, NOW())
                     ON DUPLICATE KEY UPDATE
                         attempt_count = attempt_count + 1,
                         last_attempt = NOW()"
                )->execute(['ip' => $clientIp]);

                $countStmt = $pdo->prepare(
                    "SELECT attempt_count
                     FROM form_rate_limit
                     WHERE ip = :ip AND action = 'verify_email'"
                );
                $countStmt->execute(['ip' => $clientIp]);
                $currentCount = (int) ($countStmt->fetchColumn() ?? 0);

                if ($currentCount >= VERIFY_MAX_ATTEMPTS) {
                    $pdo->prepare(
                        "UPDATE form_rate_limit
                         SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND)
                         WHERE ip = :ip AND action = 'verify_email'"
                    )->execute([
                        'secs' => VERIFY_WINDOW_SECS,
                        'ip' => $clientIp,
                    ]);
                }
            }
        } catch (\PDOException $e) {
            error_log('Verify email rate-limit error: ' . $e->getMessage());
        }

        if ($rateLimitBlocked) {
            $message = 'Príliš veľa pokusov. Skúste to znova neskôr.';
        } else {
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare(
                    "SELECT id, email_verified_at,
                            email_verification_token_hash, email_verification_expires_at
                     FROM users
                     WHERE id = :id
                     LIMIT 1
                     FOR UPDATE"
                );
                $stmt->execute(['id' => $uid]);
                $user = $stmt->fetch();

                $storedHash = is_array($user)
                    ? (string) ($user['email_verification_token_hash'] ?? '')
                    : '';
                $providedHash = hash('sha256', $token);
                $tokenMatches = $storedHash !== '' && hash_equals($storedHash, $providedHash);

                if (!is_array($user)
                    || !empty($user['email_verified_at'])
                    || !$tokenMatches
                    || empty($user['email_verification_expires_at'])
                ) {
                    $pdo->rollBack();
                    // Rovnaká odpoveď pre neexistujúce, už overené a neplatné ID.
                    $message = 'Overovací odkaz nie je platný alebo už bol použitý.';
                } elseif (strtotime((string) $user['email_verification_expires_at']) < time()) {
                    $pdo->rollBack();
                    $message = 'Platnosť overovacieho odkazu vypršala. Požiadajte o nové overenie.';
                } else {
                    markEmailAsVerified($pdo, (int) $user['id']);
                    $pdo->commit();

                    try {
                        $pdo->prepare(
                            "DELETE FROM form_rate_limit
                             WHERE ip = :ip AND action = 'verify_email'"
                        )->execute(['ip' => $clientIp]);
                    } catch (\PDOException) {
                        // Vyčistenie počítadla je best-effort.
                    }

                    $_SESSION['verify_email_flash'] = 'success';
                    header('Location: verify_email.php?verified=1', true, 303);
                    exit;
                }
            } catch (\PDOException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Verify email DB error: ' . $e->getMessage());
                $message = 'Pri overovaní e-mailu došlo k chybe. Skúste to neskôr.';
                $showConfirmation = true;
            }
        }
    }
}

$pageClass = match ($status) {
    'success' => 'alert-success',
    'pending' => 'alert-info',
    default => 'alert-error',
};
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Overenie e-mailu | Nefro-projekt Slovensko';
  $seoDescription = 'Overenie e-mailovej adresy účtu na Nefro-projekt Slovensko.';
  $robotsMeta     = 'noindex, nofollow';
  $canonicalUrl   = 'https://nefro.polascin.net/verify_email.php';
  include 'head_meta.php';
  ?>
  <?php if ($autoRedirect): ?>
  <meta http-equiv="refresh" content="5;url=login.php?verified=1">
  <?php endif; ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Overenie e-mailu';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container" role="main">
        <div class="auth-container">
            <h2>Overenie e-mailovej adresy</h2>

            <div class="alert <?= $pageClass ?>">
                <p><?= htmlspecialchars($message) ?></p>
                <?php if ($autoRedirect): ?>
                    <p><small>Budete automaticky presmerovaný na prihlásenie o 5 sekúnd.</small></p>
                <?php endif; ?>
            </div>

            <?php if ($showConfirmation): ?>
                <form method="POST" action="verify_email.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <input type="hidden" name="uid" value="<?= $uid ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-block">Potvrdiť e-mailovú adresu</button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="auth-links auth-links--spaced">
                <p>
                    <a href="login.php<?= $status === 'success' ? '?verified=1' : '' ?>">Prejsť na prihlásenie</a>
                    <?php if ($status !== 'success'): ?>
                    |
                    <a href="resend_verification.php">Poslať nový overovací e-mail</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
