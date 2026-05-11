<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'email_verification.php';

$errors = [];
$success = null;
$loginValue = trim((string) ($_GET['login'] ?? $_POST['login'] ?? ''));

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrf)) {
        $errors[] = 'Neplatný CSRF token. Skúste to znova.';
    } else {
        $loginValue = trim((string) ($_POST['login'] ?? ''));
        if ($loginValue === '') {
            $errors[] = 'Zadajte e-mailovú adresu alebo používateľské meno.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id, username, email, email_verified_at, email_verification_sent_at
                    FROM users WHERE email = :login OR username = :login LIMIT 1");
                $stmt->execute(['login' => $loginValue]);
                $user = $stmt->fetch();

                if (!$user) {
                    $success = 'Ak účet existuje, nový overovací e-mail bol odoslaný.';
                } elseif (!empty($user['email_verified_at'])) {
                    $success = 'Táto e-mailová adresa je už overená.';
                } elseif (!isEmailResendAllowed($user['email_verification_sent_at'] ?? null, 60)) {
                    $errors[] = 'Overovací e-mail bol odoslaný nedávno. Skúste to znova o chvíľu.';
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
                }
            } catch (\PDOException $e) {
                error_log('Resend verification DB error: ' . $e->getMessage());
                $errors[] = 'Pri spracovaní požiadavky došlo k chybe. Skúste to znova neskôr.';
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
    <title>Opätovné odoslanie overenia - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <?php
    $headerTitle = 'Opätovné odoslanie overenia';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
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
                    <input type="text" id="login" name="login" class="form-control" required value="<?= htmlspecialchars($loginValue) ?>">
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
