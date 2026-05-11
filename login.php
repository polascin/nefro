<?php
require_once 'auth.php';
require_once 'db_config.php';

// Ak už je prihlásený, presmerovať
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$errors = [];
$loginFailureDetails = [];

$host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? ''));
$isLocalDev = $host === 'localhost'
    || str_starts_with($host, 'localhost:')
    || str_starts_with($host, '127.0.0.1')
    || str_starts_with($host, '::1');

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
        // DB/IP brute-force ochrana (10 pokusov, blokovanie na 15 minút)
        $clientIp    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $maxAttempts = 10;
        $blockSecs   = 900; // 15 minút
        $ipBlocked   = false;

        try {
            // Odstrán expirované bloky (staršie ako 1 deň)
            $pdo->prepare("DELETE FROM login_attempts WHERE blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)")
                ->execute();

            $laStmt = $pdo->prepare("SELECT attempt_count, blocked_until FROM login_attempts WHERE ip = :ip");
            $laStmt->execute(['ip' => $clientIp]);
            $laRow = $laStmt->fetch();

            if ($laRow && !empty($laRow['blocked_until'])) {
                $blockedUntilTs = strtotime((string) $laRow['blocked_until']);
                if ($blockedUntilTs !== false && $blockedUntilTs > time()) {
                    $ipBlocked = true;
                    $errors[] = "Z bezpečnostných dôvodov bol prístup dočasne zablokovaný. Skúste to znova o 15 minút.";
                    $remainingMins = max(1, (int) ceil(($blockedUntilTs - time()) / 60));
                    $loginFailureDetails[] = "Prihlásenie z IP adresy je blokované ešte približne {$remainingMins} min.";
                } else {
                    // Blokácia už vypršala, vyčisti ju pre tento záznam IP.
                    $pdo->prepare("UPDATE login_attempts SET blocked_until = NULL WHERE ip = :ip")
                        ->execute(['ip' => $clientIp]);
                }
            }
        } catch (\PDOException $e) {
            error_log("Rate limit check error: " . $e->getMessage());
            // Pri DB chybe pokračuj bez rate limitingu
        }

        if (!$ipBlocked) {
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
            } else {
                try {
                    $stmt = $pdo->prepare("SELECT id, email, password_hash, username, is_admin, is_active, email_verified_at FROM users WHERE email = :email OR username = :username");
                    $stmt->execute([
                        'email'    => $loginInput,
                        'username' => $loginInput,
                    ]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password_hash'])) {
                        if (!(int) ($user['is_active'] ?? 1)) {
                            $errors[] = "Váš účet bol deaktivovaný. Kontaktujte administrátora.";
                            $loginFailureDetails[] = 'Účet existuje, ale je deaktivovaný administrátorom.';
                        } else {
                            // Prihlásenie úspešné — vyčisti IP záznamy
                            try {
                                $pdo->prepare("DELETE FROM login_attempts WHERE ip = :ip")->execute(['ip' => $clientIp]);
                            } catch (\PDOException) { /* ignoruj */ }

                            $emailVerified = !empty($user['email_verified_at']) ? 1 : 0;
                            regenerateSession();
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['email'] = (string) ($user['email'] ?? '');
                            $_SESSION['is_admin'] = (int) ($user['is_admin'] ?? 0);
                            $_SESSION['email_verified'] = $emailVerified;

                            if ($emailVerified !== 1) {
                                setFlashMessage('warning', 'Váš účet má neoverenú e-mailovú adresu. Neoverení používatelia nemôžu využívať služby určené pre používateľov.');
                            }

                            header("Location: index.php");
                            exit;
                        }
                    } else {
                        // Nesprávne prihlásenie — zaznamenaj pokus
                        if (!$user) {
                            $errors[] = "Prihlásenie sa nepodarilo.";
                            $loginFailureDetails[] = 'Účet so zadaným e-mailom alebo používateľským menom neexistuje.';
                        } else {
                            $errors[] = "Prihlásenie sa nepodarilo.";
                            $loginFailureDetails[] = 'Zadané heslo nie je správne.';
                        }

                        try {
                            $pdo->prepare(
                                "INSERT INTO login_attempts (ip, attempt_count, first_attempt, last_attempt)
                                 VALUES (:ip, 1, NOW(), NOW())
                                 ON DUPLICATE KEY UPDATE attempt_count = attempt_count + 1, last_attempt = NOW()"
                            )->execute(['ip' => $clientIp]);

                            $cntStmt = $pdo->prepare("SELECT attempt_count FROM login_attempts WHERE ip = :ip");
                            $cntStmt->execute(['ip' => $clientIp]);
                            $currentCount = (int) ($cntStmt->fetchColumn() ?? 0);

                            if ($currentCount >= $maxAttempts) {
                                $pdo->prepare("UPDATE login_attempts SET blocked_until = DATE_ADD(NOW(), INTERVAL :secs SECOND) WHERE ip = :ip")
                                    ->execute(['secs' => $blockSecs, 'ip' => $clientIp]);
                                $errors[] = "Príliš veľa neúspešných pokusov. Prístup bol zablokovaný na 15 minút.";
                                $loginFailureDetails[] = 'Bol dosiahnutý bezpečnostný limit neúspešných pokusov pre túto IP adresu.';
                            } else {
                                $remaining = max(0, $maxAttempts - $currentCount);
                                $loginFailureDetails[] = "Zostávajúce pokusy pred dočasnou blokáciou IP: {$remaining}.";
                            }
                        } catch (\PDOException $e) {
                            error_log("Rate limit update error: " . $e->getMessage());
                            $errors[] = "Nesprávny e-mail alebo heslo.";
                            $loginFailureDetails[] = 'Nepodarilo sa aktualizovať počítadlo bezpečnostných pokusov.';
                        }
                    }
                } catch (\PDOException $e) {
                    error_log("Chyba prihlásenia: " . $e->getMessage());
                    $errors[] = "Vyskytla sa chyba. Skúste to prosím neskôr.";
                    $loginFailureDetails[] = 'Pri overovaní prihlasovacích údajov došlo k databázovej chybe.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
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
            <h2>Prihlásenie</h2>
            
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
                
                <div class="form-group">
                    <label for="login">Používateľské meno alebo e-mailová adresa</label>
                    <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-block">Prihlásiť sa</button>
                </div>
            </form>

            <div class="auth-links">
                <p>Ešte nemáte účet? <a href="register.php">Zaregistrujte sa</a></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
