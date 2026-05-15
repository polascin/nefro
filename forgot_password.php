<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'email_verification.php';

// Bezpečnostné HTTP hlavičky
header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$errors = [];
$notice = null;

$isLocalDev = isAppLocalDev();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";

        if ($isLocalDev) {
            $sessionTokenPresent = !empty($_SESSION['csrf_token']);
            $postTokenPresent = !empty($postedCsrfToken);
            $csrfReason = !$postTokenPresent
                ? 'Vo formulári chýba CSRF token.'
                : (!$sessionTokenPresent
                    ? 'V relácii chýba CSRF token (pravdepodobne problém so session cookie alebo stará otvorená karta).'
                    : 'Token vo formulári sa nezhoduje s tokenom v relácii.');

            $errors[] = "[DEV diagnostika] CSRF zlyhanie: " . $csrfReason;
        }
    } else {
        // ── 1. Honeypot ochrana ─────────────────────────────────────────
        // Skryté CSS pole — musí ostatť prázdne, boti ho vypĺňajú.
        if (($_POST['hp_contact'] ?? '') !== '') {
            if ($isLocalDev) {
                $errors[] = "[DEV] Honeypot aktivovaný na forgot_password.";
            } else {
                // Ticho simulujeme úspešnú akciu — bot nezíska informáciu
                $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
                goto endOfFpProcessing;
            }
        }

        // ── 2. IP Rate Limiting (max 3 pokusy/hodína per IP) ───────────────
        // Prísnejší limit ako na registrácii — každý pokus odosielal e-mail.
        $clientIpFp   = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $maxFpAttempts = 3;    // max pokusov za okno
        $fpBlockSecs   = 3600; // blokácia: 1 hodína
        $fpIsBlocked   = false;

        try {
            $pdo->prepare("DELETE FROM form_rate_limit WHERE action = 'forgot_password' AND blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")
                ->execute();

            $fpRlStmt = $pdo->prepare("SELECT attempt_count, blocked_until FROM form_rate_limit WHERE ip = :ip AND action = 'forgot_password'");
            $fpRlStmt->execute(['ip' => $clientIpFp]);
            $fpRlRow = $fpRlStmt->fetch();

            if ($fpRlRow && !empty($fpRlRow['blocked_until'])) {
                $fpBlockedTs = strtotime((string) $fpRlRow['blocked_until']);
                if ($fpBlockedTs !== false && $fpBlockedTs > time()) {
                    $fpIsBlocked = true;
                    // Anti-enumeration: rovnaká úspešná správa — bot/účastníci sa nedozvedú, že sú blokovaní
                    $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
                    error_log("forgot_password: IP {$clientIpFp} je rate-limitovaná.");
                } else {
                    $pdo->prepare("UPDATE form_rate_limit SET blocked_until = NULL WHERE ip = :ip AND action = 'forgot_password'")
                        ->execute(['ip' => $clientIpFp]);
                }
            }
        } catch (\PDOException $e) {
            error_log('FP rate limit check error: ' . $e->getMessage());
        }

        if (!$fpIsBlocked) {
        $login = trim((string) ($_POST['login'] ?? ''));

        if ($login === '') {
            $errors[] = 'Zadajte e-mail alebo používateľské meno.';
        } else {
            try {
                // Zaznamenať pokus PRED odoslaním emailu
                try {
                    $pdo->prepare(
                        "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt)
                         VALUES (:ip, 'forgot_password', 1, NOW())
                         ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                    )->execute(['ip' => $clientIpFp]);

                    $fpCntStmt = $pdo->prepare("SELECT attempt_count FROM form_rate_limit WHERE ip = :ip AND action = 'forgot_password'");
                    $fpCntStmt->execute(['ip' => $clientIpFp]);
                    $fpCurrentCount = (int) ($fpCntStmt->fetchColumn() ?? 0);

                    if ($fpCurrentCount >= $maxFpAttempts) {
                        $pdo->prepare("UPDATE form_rate_limit SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip AND action = 'forgot_password'")
                            ->execute(['secs' => $fpBlockSecs, 'ip' => $clientIpFp]);
                    }
                } catch (\PDOException $rlEx) {
                    error_log('FP rate limit update error: ' . $rlEx->getMessage());
                }

                $stmt = $pdo->prepare("SELECT id, email, username, is_active FROM users WHERE email = :email OR username = :username LIMIT 1");
                $stmt->execute(['email' => $login, 'username' => $login]);
                $user = $stmt->fetch();

                if ($user && (int) ($user['is_active'] ?? 1) === 1) {
                    $rawToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
                    $tokenHash = hash('sha256', $rawToken);
                    $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 60 min
                    $clientIp = $_SERVER['REMOTE_ADDR'] ?? null;

                    $pdo->prepare("DELETE FROM password_resets WHERE user_id = :user_id AND used_at IS NULL")
                        ->execute(['user_id' => (int) $user['id']]);

                    $insert = $pdo->prepare("INSERT INTO password_resets (user_id, token_hash, expires_at, requested_ip) VALUES (:user_id, :token_hash, :expires_at, :requested_ip)");
                    $insert->execute([
                        'user_id'      => (int) $user['id'],
                        'token_hash'   => $tokenHash,
                        'expires_at'   => $expiresAt,
                        'requested_ip' => $clientIp,
                    ]);

                    if (!sendPasswordResetEmail((string) $user['email'], (string) ($user['username'] ?? ''), $rawToken)) {
                        error_log('Password reset email send failed for user_id=' . (int) $user['id']);
                    }
                }

                // Anti-enumeration: rovnaká odpoveď bez ohľadu na existenciu účtu.
                $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
            } catch (\PDOException $e) {
                error_log('Forgot password error: ' . $e->getMessage());
                $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
            }
        }
        } // end if (!$fpIsBlocked)
        // ── endOfFpProcessing ── cieľ pre goto pri honeypot detekcii ──
        endOfFpProcessing:
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Zabudnuté heslo - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $headerTitle = 'Nefro-projekt Slovensko';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container">
            <h2>Zabudnuté heslo</h2>
            <p class="auth-subtitle">Zadajte e-mail alebo používateľské meno a pošleme vám odkaz na obnovenie hesla.</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($notice !== null): ?>
                <div class="alert alert-success">
                    <p><?= htmlspecialchars($notice) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="forgot_password.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <!-- Honeypot pole: neviditeľné pre ľudí, vypĺňajú ho iba boti. Musí ostatť prázdne. -->
                <div style="position:absolute;left:-9999px;top:-9999px;overflow:hidden;" aria-hidden="true" tabindex="-1">
                    <label for="hp_contact">Kontakt (nevypĺňať)</label>
                    <input type="text" id="hp_contact" name="hp_contact" value="" autocomplete="off" tabindex="-1" maxlength="255">
                </div>

                <div class="form-group">
                    <label for="login">E-mail alebo používateľské meno</label>
                    <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" autocomplete="username">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Poslať odkaz na obnovenie hesla</button>
                </div>
            </form>

            <div class="auth-links">
                <p><a href="login.php">Späť na prihlásenie</a></p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
