<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/email_verification.php';

$errors     = [];
$success    = null;
$loginValue = trim((string) ($_GET['login'] ?? $_POST['login'] ?? ''));

// Konštanty rate limitingu
const RESEND_MAX_ATTEMPTS  = 5;    // max pokusov per IP
const RESEND_WINDOW_SECS   = 3600; // okno 1 hodina
const RESEND_COOLDOWN_SECS = 300;  // 5 minút medzi jednotlivými odoslaniami

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrf)) {
        $errors[] = 'Neplatný CSRF token. Skúste to znova.';
    } else {
        $loginValue = trim((string) ($_POST['login'] ?? ''));
        if ($loginValue === '') {
            $errors[] = 'Zadajte e-mailovú adresu alebo používateľské meno.';
        } else {
            // ── IP rate limiting ──────────────────────────────────────────────
            $clientIp = getClientIpAddress();
            $ipBlocked = false;

            try {
                $pdo->prepare(
                    "DELETE FROM form_rate_limit
                     WHERE action = 'resend_verification'
                       AND first_attempt < DATE_SUB(NOW(), INTERVAL 1 DAY)"
                )->execute();

                $rlStmt = $pdo->prepare(
                    "SELECT attempt_count, blocked_until
                     FROM form_rate_limit
                     WHERE ip = :ip AND action = 'resend_verification'"
                );
                $rlStmt->execute(['ip' => $clientIp]);
                $rlRow = $rlStmt->fetch();

                if ($rlRow && !empty($rlRow['blocked_until'])) {
                    $blockedUntilTs = strtotime((string) $rlRow['blocked_until']);
                    if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                        $ipBlocked = true;
                        $errors[] = 'Príliš veľa pokusov. Skúste to znova o hodinu.';
                    } else {
                        $pdo->prepare(
                            "UPDATE form_rate_limit
                             SET blocked_until = NULL
                             WHERE ip = :ip AND action = 'resend_verification'"
                        )->execute(['ip' => $clientIp]);
                    }
                }
            } catch (\PDOException $e) {
                error_log('Resend verification rate limit check error: ' . $e->getMessage());
            }

            if (!$ipBlocked) {
                try {
                    $stmt = $pdo->prepare(
                        "SELECT id, username, email, email_verified_at, email_verification_sent_at
                         FROM users WHERE email = :login OR username = :login LIMIT 1"
                    );
                    $stmt->execute(['login' => $loginValue]);
                    $user = $stmt->fetch();

                    // Anti-enumeration: rovnaká odpoveď pre neexistujúci účet aj overený účet
                    if (!$user || !empty($user['email_verified_at'])) {
                        $success = 'Ak účet existuje a čaká na overenie, nový overovací e-mail bol odoslaný.';
                    } elseif (!isEmailResendAllowed(
                        $user['email_verification_sent_at'] ?? null,
                        RESEND_COOLDOWN_SECS
                    )) {
                        $errors[] = 'Overovací e-mail bol odoslaný nedávno. Skúste to znova o 5 minút.';
                    } else {
                        $tokenData = generateEmailVerificationToken();
                        saveEmailVerificationToken(
                            $pdo,
                            (int) $user['id'],
                            $tokenData['token_hash'],
                            $tokenData['expires_at']
                        );

                        $sent = sendVerificationEmail(
                            (string) $user['email'],
                            (string) ($user['username'] ?? ''),
                            (int) $user['id'],
                            $tokenData['token']
                        );

                        if ($sent) {
                            $success = 'Nový overovací e-mail bol odoslaný.';
                        } else {
                            $errors[] = 'Overovací e-mail sa nepodarilo odoslať. Skúste to znova neskôr.';
                        }

                        // Zaznamenaj pokus per IP (aj pri úspechu)
                        try {
                            $pdo->prepare(
                                "INSERT INTO form_rate_limit (ip, action, attempt_count, first_attempt)
                                 VALUES (:ip, 'resend_verification', 1, NOW())
                                 ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                            )->execute(['ip' => $clientIp]);

                            $cntStmt = $pdo->prepare(
                                "SELECT attempt_count FROM form_rate_limit
                                 WHERE ip = :ip AND action = 'resend_verification'"
                            );
                            $cntStmt->execute(['ip' => $clientIp]);
                            $currentCount = (int) ($cntStmt->fetchColumn() ?? 0);

                            if ($currentCount >= RESEND_MAX_ATTEMPTS) {
                                $pdo->prepare(
                                    "UPDATE form_rate_limit
                                     SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND)
                                     WHERE ip = :ip AND action = 'resend_verification'"
                                )->execute(['secs' => RESEND_WINDOW_SECS, 'ip' => $clientIp]);
                            }
                        } catch (\PDOException $e) {
                            error_log('Resend verification rate limit update error: ' . $e->getMessage());
                        }
                    }
                } catch (\PDOException $e) {
                    error_log('Resend verification DB error: ' . $e->getMessage());
                    $errors[] = 'Pri spracovaní požiadavky došlo k chybe. Skúste to znova neskôr.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Opätovné odoslanie overenia | Nefro-projekt Slovensko';
  $seoDescription = 'Požiadajte o nové overenie e-mailovej adresy vášho účtu na Nefro-projekt Slovensko.';
  $robotsMeta     = 'noindex, follow';
  $canonicalUrl   = 'https://nefro.polascin.net/resend_verification.php';
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Opätovné odoslanie overenia';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container">
        <div class="auth-container">
            <h2>Poslať nový overovací e-mail</h2>
            <p class="auth-subtitle">Zadajte e-mail alebo používateľské meno účtu, ktorý chcete overiť.</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success !== null): ?>
                <div class="alert alert-success">
                    <p><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="resend_verification.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <div class="form-group">
                    <label for="login">E-mail alebo používateľské meno</label>
                    <input type="text" id="login" name="login" class="form-control" required
                           value="<?= htmlspecialchars($loginValue) ?>">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Poslať overovací e-mail</button>
                </div>
            </form>

            <div class="auth-links auth-links--spaced">
                <p><a href="login.php">Späť na prihlásenie</a></p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
