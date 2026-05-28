<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/email_verification.php';

const VERIFY_MAX_ATTEMPTS = 20;   // max pokusov per IP za okno
const VERIFY_WINDOW_SECS  = 900;  // okno 15 minút

$status  = 'error';
$message = 'Neplatný alebo neúplný overovací odkaz.';
$autoRedirect = false;

$uid   = (int) ($_GET['uid']   ?? 0);
$token = trim((string) ($_GET['token'] ?? ''));

if ($uid > 0 && $token !== '') {
    $clientIp = getClientIpAddress();

    // ── IP rate limiting pre verify_email ────────────────────────────────────
    $rateLimitBlocked = false;
    try {
        $pdo->prepare(
            "DELETE FROM form_rate_limit
             WHERE action = 'verify_email'
               AND first_attempt < DATE_SUB(NOW(), INTERVAL 1 DAY)"
        )->execute();

        $rlStmt = $pdo->prepare(
            "SELECT attempt_count, blocked_until
             FROM form_rate_limit
             WHERE ip = :ip AND action = 'verify_email'"
        );
        $rlStmt->execute(['ip' => $clientIp]);
        $rlRow = $rlStmt->fetch();

        if ($rlRow && !empty($rlRow['blocked_until'])) {
            $blockedUntilTs = strtotime((string) $rlRow['blocked_until']);
            if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                $rateLimitBlocked = true;
                $message = 'Príliš veľa neúspešných pokusov. Skúste to znova neskôr.';
                error_log('verify_email rate limit hit: ip=' . $clientIp . ' uid=' . $uid);
            } else {
                $pdo->prepare(
                    "UPDATE form_rate_limit
                     SET blocked_until = NULL
                     WHERE ip = :ip AND action = 'verify_email'"
                )->execute(['ip' => $clientIp]);
            }
        }
    } catch (\PDOException $e) {
        error_log('verify_email rate limit check error: ' . $e->getMessage());
    }

    if (!$rateLimitBlocked) {
        try {
            $stmt = $pdo->prepare(
                "SELECT id, username, email, email_verified_at,
                        email_verification_token_hash, email_verification_expires_at
                 FROM users WHERE id = :id LIMIT 1"
            );
            $stmt->execute(['id' => $uid]);
            $user = $stmt->fetch();

            if (!$user) {
                $message = 'Overovací odkaz nie je platný.';
                error_log('verify_email: uid=' . $uid . ' not found; ip=' . $clientIp);
            } elseif (!empty($user['email_verified_at'])) {
                $status  = 'success';
                $message = 'E-mailová adresa je už overená. Môžete sa prihlásiť.';
                $autoRedirect = true;
            } elseif (
                empty($user['email_verification_token_hash']) ||
                empty($user['email_verification_expires_at'])
            ) {
                $message = 'Overovací odkaz nie je dostupný. Požiadajte o nové overenie.';
            } elseif (strtotime((string) $user['email_verification_expires_at']) < time()) {
                $message = 'Platnosť overovacieho odkazu vypršala. Požiadajte o nové overenie.';
            } else {
                $providedHash = hash('sha256', $token);
                if (!hash_equals(
                    (string) $user['email_verification_token_hash'],
                    $providedHash
                )) {
                    // Neplatný token — zaznamenaj pokus
                    $message = 'Overovací odkaz nie je platný.';
                    error_log(
                        'verify_email: invalid token for uid=' . $uid .
                        '; ip=' . $clientIp
                    );

                    try {
                        $pdo->prepare(
                            "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt)
                             VALUES (:ip, 'verify_email', 1, NOW())
                             ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                        )->execute(['ip' => $clientIp]);

                        $cntStmt = $pdo->prepare(
                            "SELECT attempt_count FROM form_rate_limit
                             WHERE ip = :ip AND action = 'verify_email'"
                        );
                        $cntStmt->execute(['ip' => $clientIp]);
                        $currentCount = (int) ($cntStmt->fetchColumn() ?? 0);

                        if ($currentCount >= VERIFY_MAX_ATTEMPTS) {
                            $pdo->prepare(
                                "UPDATE form_rate_limit
                                 SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND)
                                 WHERE ip = :ip AND action = 'verify_email'"
                            )->execute(['secs' => VERIFY_WINDOW_SECS, 'ip' => $clientIp]);
                        }
                    } catch (\PDOException $e) {
                        error_log('verify_email rate limit update error: ' . $e->getMessage());
                    }
                } else {
                    // Token platný — overíme e-mail
                    markEmailAsVerified($pdo, (int) $user['id']);

                    // Vyčisti rate limit counter pre túto IP po úspešnom overení
                    try {
                        $pdo->prepare(
                            "DELETE FROM form_rate_limit
                             WHERE ip = :ip AND action = 'verify_email'"
                        )->execute(['ip' => $clientIp]);
                    } catch (\PDOException) { /* ignoruj */ }

                    error_log(
                        'verify_email: success uid=' . $uid .
                        ' email=' . ($user['email'] ?? '?') .
                        '; ip=' . $clientIp
                    );

                    $status      = 'success';
                    $message     = 'E-mailová adresa bola úspešne overená. Teraz sa môžete prihlásiť.';
                    $autoRedirect = true;
                }
            }
        } catch (\PDOException $e) {
            error_log('verify_email DB error: ' . $e->getMessage());
            $message = 'Pri overovaní e-mailu došlo k chybe. Skúste to neskôr.';
        }
    }
}

$pageClass = $status === 'success' ? 'alert-success' : 'alert-error';
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
    <?php
    $headerTitle = 'Overenie e-mailu';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container">
            <h2>Overenie e-mailovej adresy</h2>

            <div class="alert <?= $pageClass ?>">
                <p><?= htmlspecialchars($message) ?></p>
                <?php if ($autoRedirect): ?>
                    <p><small>Budete automaticky presmerovaný na prihlásenie o 5 sekúnd.</small></p>
                <?php endif; ?>
            </div>

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
