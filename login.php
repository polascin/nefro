<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

// Ak už je prihlásený, presmerovať
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$isLocalDev = isAppLocalDev();

/**
 * Spracuje POST požiadavku prihlásenia. Vráti pole errors+loginFailureDetails,
 * alebo pri úspešnom prihlásení priamo presmeruje (header + exit).
 * @return array{errors: string[], loginFailureDetails: string[]}
 */
function handleLoginPost(PDO $pdo, bool $isLocalDev): array
{
    $errors             = [];
    $loginFailureDetails = [];
    $maxAttempts        = 10;
    $blockSecs          = 900;

    // ── CSRF ─────────────────────────────────────────────────────────────────
    $postedCsrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrfToken)) {
        $errors[] = "Neplatný CSRF token. Skúste to znova.";
        if ($isLocalDev) {
            $sessionTokenPresent = !empty($_SESSION['csrf_token']);
            $postTokenPresent    = !empty($postedCsrfToken);
            $csrfReason = !$postTokenPresent
                ? 'Vo formulári chýba CSRF token.'
                : (!$sessionTokenPresent
                    ? 'V relácii chýba CSRF token (pravdepodobne problém so session cookie alebo stará otvorená karta).'
                    : 'Token vo formulári sa nezhoduje s tokenom v relácii.');
            $errors[] = "[DEV diagnostika] CSRF zlyhanie: " . $csrfReason;
        }
        return compact('errors', 'loginFailureDetails');
    }

    // ── 0. User-Agent check ───────────────────────────────────────────────────
    if (isKnownBotUserAgent()) {
        if ($isLocalDev) {
            $errors[] = "[DEV] Detekovaný nepovolený User-Agent.";
        } else {
            $errors[] = "Neplatná požiadavka. Skúste to znova (User-Agent neprešiel overením).";
            return compact('errors', 'loginFailureDetails');
        }
    }

    // ── 1. Honeypot ───────────────────────────────────────────────────────────
    if (($_POST['work_email_confirm'] ?? '') !== '') {
        if ($isLocalDev) {
            $errors[] = "[DEV] Honeypot aktivovaný.";
        } else {
            $errors[] = "Neplatná požiadavka. Skúste to znova.";
            return compact('errors', 'loginFailureDetails');
        }
    }

    // ── 2. JS-Challenge ───────────────────────────────────────────────────────
    if (!validateJsChallengeToken($_POST['js_token'] ?? null)) {
        if ($isLocalDev) {
            $errors[] = "[DEV] JS-Challenge zlyhal.";
        } else {
            $errors[] = "Požiadavka nebola overená (vyžaduje sa JavaScript). Zapnite JavaScript a skúste znova.";
            return compact('errors', 'loginFailureDetails');
        }
    }

    // ── 3. Time-based check ───────────────────────────────────────────────────
    if (!validateFormTime('login', 4)) {
        if ($isLocalDev) {
            $errors[] = "[DEV] Formulár odoslaný príliš rýchlo.";
        } else {
            $errors[] = "Formulár bol odoslaný príliš rýchlo. Skúste to znova za pár sekúnd.";
            return compact('errors', 'loginFailureDetails');
        }
    }

    // ── IP rate-limit ─────────────────────────────────────────────────────────
    $clientIp = getClientIpAddress();
    try {
        $blockedUntilTs = ipRateLimitBlockedUntil($pdo, 'login_attempts', $clientIp);
        if ($blockedUntilTs > 0) {
            $errors[] = "Z bezpečnostných dôvodov bol prístup dočasne zablokovaný. Skúste to znova o 15 minút.";
            if ($isLocalDev) {
                $remainingMins = max(1, (int) ceil(($blockedUntilTs - time()) / 60));
                $loginFailureDetails[] = "Prihlásenie z IP adresy je blokované ešte približne {$remainingMins} min.";
            }
            return compact('errors', 'loginFailureDetails');
        }
    } catch (\PDOException $e) {
        error_log("Rate limit check error: " . $e->getMessage());
    }

    // ── Prihlasovanie údaje ───────────────────────────────────────────────────
    $loginInput = trim($_POST['login'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (empty($loginInput) || empty($password)) {
        $errors[] = "Zadajte používateľské meno (alebo e-mail) a heslo.";
        if (empty($loginInput)) {
            $loginFailureDetails[] = 'Nie je vyplnené používateľské meno ani e-mail.';
        }
        if (empty($password)) {
            $loginFailureDetails[] = 'Nie je vyplnené heslo.';
        }
        return compact('errors', 'loginFailureDetails');
    }

    try {
        $stmt = $pdo->prepare(
            "SELECT id, email, password_hash, username, is_admin, is_active, email_verified_at, totp_enabled, totp_secret
             FROM users WHERE email = :email OR username = :username"
        );
        $stmt->execute(['email' => $loginInput, 'username' => $loginInput]);
        $user = $stmt->fetch();

        // Vždy voláme password_verify (aj pre neexistujúceho používateľa)
        // aby sme zabránili timing útoku na enumeráciu e-mailov.
        // Dummy hash sa generuje dynamicky — žiadny hardcoded reťazec v kóde.
        $hashToVerify = $user
            ? (string) $user['password_hash']
            : password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
        $passwordOk = password_verify($password, $hashToVerify);

        if (!$user || !$passwordOk) {
            $errors[] = "Prihlásenie sa nepodarilo.";
            if ($isLocalDev) {
                $loginFailureDetails[] = !$user
                    ? 'Účet so zadaným e-mailom alebo používateľským menom neexistuje.'
                    : 'Zadané heslo nie je správne.';
            }
            try {
                $count = recordIpFailedAttempt($pdo, 'login_attempts', $clientIp, $maxAttempts, $blockSecs);
                if ($count >= $maxAttempts) {
                    $errors[] = "Príliš veľa neúspešných pokusov. Prístup bol zablokovaný na 15 minút.";
                    if ($isLocalDev) {
                        $loginFailureDetails[] = 'Bol dosiahnutý bezpečnostný limit neúspešných pokusov pre túto IP adresu.';
                    }
                } elseif ($isLocalDev) {
                    $loginFailureDetails[] = "Zostávajúce pokusy pred dočasnou blokáciou IP: " . max(0, $maxAttempts - $count) . ".";
                }
            } catch (\PDOException $e) {
                error_log("Rate limit update error: " . $e->getMessage());
                if ($isLocalDev) {
                    $loginFailureDetails[] = 'Nepodarilo sa aktualizovať počítadlo bezpečnostných pokusov.';
                }
            }
            return compact('errors', 'loginFailureDetails');
        }

        if (!(int) ($user['is_active'] ?? 1)) {
            $errors[] = "Prihlásenie sa nepodarilo.";
            if ($isLocalDev) {
                $loginFailureDetails[] = 'Účet existuje, ale je deaktivovaný administrátorom.';
            }
            return compact('errors', 'loginFailureDetails');
        }

        // Prihlásenie úspešné — vyčisti IP záznamy
        try {
            clearIpRateLimit($pdo, 'login_attempts', $clientIp);
        } catch (\PDOException) { /* ignoruj */ }

        $emailVerified = !empty($user['email_verified_at']) ? 1 : 0;

        if ($emailVerified !== 1) {
            setFlashMessage('warning', 'Pred prihlásením musíte overiť svoju e-mailovú adresu. Skontrolujte doručenú poštu alebo si nechajte zaslať nový overovací e-mail.');
            header("Location: resend_verification.php");
            exit;
        }

        // ── 2FA check ─────────────────────────────────────────────────────────
        if ((int) ($user['totp_enabled'] ?? 0) === 1 && !empty($user['totp_secret'])) {
            regenerateSession();
            $_SESSION['2fa_pending'] = [
                'user_id'         => $user['id'],
                'expires'         => time() + 300,
                'attempts'        => 0,
                'pwd_fingerprint' => substr(hash('sha256', (string) $user['password_hash']), 0, 16),
            ];
            header("Location: 2fa_verify.php");
            exit;
        }

        regenerateSession();
        $_SESSION['user_id']         = $user['id'];
        $_SESSION['username']        = $user['username'];
        $_SESSION['email']           = (string) ($user['email'] ?? '');
        $_SESSION['is_admin']        = (int) ($user['is_admin'] ?? 0);
        $_SESSION['email_verified']  = $emailVerified;
        $_SESSION['_last_activity']  = time();

        header("Location: index.php");
        exit;

    } catch (\PDOException $e) {
        error_log("Chyba prihlásenia: " . $e->getMessage());
        $errors[] = "Vyskytla sa chyba. Skúste to prosím neskôr.";
        if ($isLocalDev) {
            $loginFailureDetails[] = 'Pri overovaní prihlasovacích údajov došlo k databázovej chybe.';
        }
        return compact('errors', 'loginFailureDetails');
    }
}

$errors             = [];
$loginFailureDetails = [];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $result              = handleLoginPost($pdo, $isLocalDev);
    $errors              = $result['errors'];
    $loginFailureDetails = $result['loginFailureDetails'];
} else {
    // GET požiadavka: zaznamenaj čas načítania
    markFormLoadTime('login');
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Prihlásenie | Nefro-projekt Slovensko';
  $seoDescription = 'Prihláste sa do Nefro-projekt Slovensko — odborného portálu pre nefrológov a lekárov.';
  $robotsMeta     = 'noindex, follow';
  $canonicalUrl   = 'https://nefro.polascin.net/login.php';
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

    <main id="main-content" class="container">
        <div class="auth-container">
            <h2>Prihlásenie</h2>

            <?php if (($_GET['account_deleted'] ?? '') === '1'): ?>
                <div class="alert alert-success">
                    <p><strong>Váš účet bol úspešne zrušený.</strong></p>
                    <p>Všetky vaše osobné údaje boli natrvalo vymazané. Ďakujeme, že ste využívali Nefro-projekt Slovensko.</p>
                </div>
            <?php endif; ?>

            <?php if (($_GET['verified'] ?? '') === '1'): ?>
                <div class="alert alert-success">
                    <p><strong>E-mailová adresa bola úspešne overená.</strong></p>
                    <p>Váš účet je aktívny. Môžete sa prihlásiť.</p>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($loginFailureDetails)): ?>
                <div class="alert alert-error">
                    <p><strong>Podrobnosti príčin neúspešného prihlásenia:</strong></p>
                    <ul>
                        <?php foreach ($loginFailureDetails as $detail): ?>
                            <li><?= htmlspecialchars($detail) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <input type="hidden" name="js_token" id="js_token_field" value="<?= htmlspecialchars(generateJsChallengeToken(), ENT_QUOTES) ?>">
                <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
                    document.addEventListener('DOMContentLoaded', function() {
                        var el = document.getElementById('js_token_field');
                        if (el && !el.value) {
                            el.value = "<?= htmlspecialchars(generateJsChallengeToken(), ENT_QUOTES) ?>";
                        }
                    });
                </script>

                <!-- Honeypot: neviditeľné pole -->
                <div class="honeypot" aria-hidden="true" tabindex="-1">
                    <label for="work_email_confirm">Pracovný e-mail (potvrdenie)</label>
                    <input type="text" id="work_email_confirm" name="work_email_confirm" value="" autocomplete="off" tabindex="-1">
                </div>


                <div class="form-group">
                    <label for="login">Používateľské meno alebo e-mailová adresa</label>
                    <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Prihlásiť sa</button>
                </div>
            </form>

            <div class="auth-links">
                <p><a href="forgot_password.php">Zabudnuté heslo?</a></p>
                <p>Ešte nemáte účet? <a href="register.php">Zaregistrujte sa</a></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
