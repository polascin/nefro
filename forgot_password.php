<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/email_verification.php';

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$errors = [];
$notice = null;

$isLocalDev = isAppLocalDev();
if ($requestMethod === 'GET' && isset($_SESSION['forgot_password_flash'])) {
    $notice = (string) $_SESSION['forgot_password_flash'];
    unset($_SESSION['forgot_password_flash']);
}

if ($requestMethod === 'POST') {
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
        // ── 0. User-Agent Check ───────────────────────────────────────────
        if (isKnownBotUserAgent()) {
            if ($isLocalDev) { $errors[] = "[DEV] Detekovaný nepovolený User-Agent."; }
            else { $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.'; goto endOfFpProcessing; }
        }

        // ── 1. Honeypot ochrana ─────────────────────────────────────────
        if (($_POST['hp_contact'] ?? '') !== '') {
            if ($isLocalDev) { $errors[] = "[DEV] Honeypot aktivovaný."; }
            else { $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.'; goto endOfFpProcessing; }
        }

        // ── 2. JS-Challenge Check ─────────────────────────────────────────
        if (!validateJsChallengeToken($_POST['js_token'] ?? null)) {
            if ($isLocalDev) { $errors[] = "[DEV] JS-Challenge zlyhal."; }
            else { $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.'; goto endOfFpProcessing; }
        }

        // ── 3. Time-based Check ───────────────────────────────────────────
        if (!validateFormTime('forgot_password', 5)) {
            if ($isLocalDev) { $errors[] = "[DEV] Formulár odoslaný príliš rýchlo."; }
            else { $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.'; goto endOfFpProcessing; }
        }

        // ── 4. IP Rate Limiting (max 5 pokusov/hodina per IP) ───────────────
        // Prísnejší limit ako na registrácii — každý pokus odosielal e-mail.
        $clientIpFp   = getClientIpAddress();
        $maxFpAttempts = 5;    // max pokusov za okno (zvýšené z 3 na 5 pre lepší UX)
        $fpBlockSecs   = 3600; // blokácia: 1 hodina
        $fpIsBlocked   = false;

        try {
            $pdo->prepare(
                "DELETE FROM form_rate_limit
                 WHERE action = 'forgot_password'
                   AND first_attempt < DATE_SUB(NOW(), INTERVAL 1 HOUR)
                   AND (blocked_until IS NULL OR blocked_until <= NOW())"
            )
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
                    $pdo->prepare(
                        "UPDATE form_rate_limit
                         SET attempt_count = 0, first_attempt = NOW(), last_attempt = NOW(), blocked_until = NULL
                         WHERE ip = :ip AND action = 'forgot_password'"
                    )
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
                    $clientIp = getClientIpAddress();

                    // Uzamknutie používateľa serializuje súbežné požiadavky. Samotná
                    // transakcia bez riadkového zámku by mohla vytvoriť dva platné tokeny.
                    $pdo->beginTransaction();
                    $lockUser = $pdo->prepare('SELECT id FROM users WHERE id = :user_id FOR UPDATE');
                    $lockUser->execute(['user_id' => (int) $user['id']]);
                    if (!$lockUser->fetchColumn()) {
                        throw new \RuntimeException('Používateľ počas vytvárania reset tokenu prestal existovať.');
                    }
                    $pdo->prepare("DELETE FROM password_resets WHERE user_id = :user_id AND used_at IS NULL")
                        ->execute(['user_id' => (int) $user['id']]);
                    $pdo->prepare(
                        "INSERT INTO password_resets (user_id, token_hash, expires_at, requested_ip)
                         VALUES (:user_id, :token_hash, :expires_at, :requested_ip)"
                    )->execute([
                        'user_id'      => (int) $user['id'],
                        'token_hash'   => $tokenHash,
                        'expires_at'   => $expiresAt,
                        'requested_ip' => $clientIp,
                    ]);
                    $pdo->commit();

                    if (!sendPasswordResetEmail((string) $user['email'], (string) ($user['username'] ?? ''), $rawToken)) {
                        error_log('Password reset email send failed for user_id=' . (int) $user['id']);
                    }
                }

                // Anti-enumeration: rovnaká odpoveď bez ohľadu na existenciu účtu.
                $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
            } catch (\Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Forgot password error: ' . $e->getMessage());
                $notice = 'Ak účet existuje, poslali sme na jeho e-mail odkaz na obnovenie hesla.';
            }
        }
        } // end if (!$fpIsBlocked)
        // ── endOfFpProcessing ── cieľ pre goto pri honeypot detekcii ──
        endOfFpProcessing:
    }
} else {
    // GET požiadavka: zaznamenaj čas načítania
    markFormLoadTime('forgot_password');
}
if ($requestMethod === 'POST' && $notice !== null && empty($errors)) {
    $_SESSION['forgot_password_flash'] = $notice;
    header('Location: forgot_password.php?sent=1', true, 303);
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Zabudnuté heslo | Nefro-projekt Slovensko';
  $seoDescription = 'Obnovte prístup k svojmu účtu Nefro-projekt Slovensko zadaním e-mailu alebo používateľského mena.';
  $robotsMeta     = 'noindex, follow';
  $canonicalUrl   = 'https://nefro.polascin.net/forgot_password.php';
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Nefro-projekt Slovensko';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container" role="main">
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
                <input type="hidden" name="js_token" id="js_token_field" value="">
                <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('js_token_field').value = "<?= htmlspecialchars(generateJsChallengeToken(), ENT_QUOTES) ?>";
                    });
                </script>

                <!-- Honeypot pole: neviditeľné pre ľudí, vypĺňajú ho iba boti. Musí ostať prázdne. -->
                <div class="honeypot" aria-hidden="true" tabindex="-1">
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
