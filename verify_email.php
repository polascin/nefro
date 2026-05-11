<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'email_verification.php';

$status = 'error';
$message = 'Neplatný alebo neúplný overovací odkaz.';

$uid = (int) ($_GET['uid'] ?? 0);
$token = trim((string) ($_GET['token'] ?? ''));

if ($uid > 0 && $token !== '') {
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, email_verified_at, email_verification_token_hash, email_verification_expires_at
            FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $uid]);
        $user = $stmt->fetch();

        if (!$user) {
            $message = 'Overovací odkaz nie je platný.';
        } elseif (!empty($user['email_verified_at'])) {
            $status = 'success';
            $message = 'E-mailová adresa je už overená.';
        } elseif (empty($user['email_verification_token_hash']) || empty($user['email_verification_expires_at'])) {
            $message = 'Overovací odkaz nie je dostupný. Požiadajte o nové overenie.';
        } elseif (strtotime((string) $user['email_verification_expires_at']) < time()) {
            $message = 'Platnosť overovacieho odkazu vypršala. Požiadajte o nové overenie.';
        } else {
            $providedHash = hash('sha256', $token);
            if (!hash_equals((string) $user['email_verification_token_hash'], $providedHash)) {
                $message = 'Overovací odkaz nie je platný.';
            } else {
                markEmailAsVerified($pdo, (int) $user['id']);
                $status = 'success';
                $message = 'E-mailová adresa bola úspešne overená. Teraz sa môžete prihlásiť.';
            }
        }
    } catch (\PDOException $e) {
        error_log('Verify email DB error: ' . $e->getMessage());
        $message = 'Pri overovaní e-mailu došlo k chybe. Skúste to neskôr.';
    }
}

$pageClass = $status === 'success' ? 'alert-success' : 'alert-error';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overenie e-mailu - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
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
            </div>
            <div class="auth-links auth-links--spaced">
                <p>
                    <a href="login.php">Prejsť na prihlásenie</a>
                    |
                    <a href="resend_verification.php">Poslať nový overovací e-mail</a>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
