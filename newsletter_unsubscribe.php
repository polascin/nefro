<?php
require_once 'db_config.php';
require_once 'newsletter_notifications.php';

$status = 'error';
$message = 'Neplatný alebo neúplný odhlasovací odkaz.';

$uid = (int) ($_GET['uid'] ?? 0);
$expiresAt = (int) ($_GET['exp'] ?? 0);
$signature = trim((string) ($_GET['sig'] ?? ''));

if ($uid > 0 && $expiresAt > 0 && $signature !== '') {
    try {
        $stmt = $pdo->prepare("SELECT id, email, newsletter_consent FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $uid]);
        $user = $stmt->fetch();

        if (!$user) {
            $message = 'Odhlasovací odkaz nie je platný.';
        } elseif (!verifyNewsletterUnsubscribeSignature(
            (int) ($user['id'] ?? 0),
            (string) ($user['email'] ?? ''),
            $expiresAt,
            $signature
        )) {
            $message = 'Odhlasovací odkaz je neplatný alebo jeho platnosť vypršala.';
        } elseif ((int) ($user['newsletter_consent'] ?? 0) !== 1) {
            $status = 'success';
            $message = 'Odber noviniek je už odhlásený.';
        } else {
            $pdo->beginTransaction();

            $unsubscribeStmt = $pdo->prepare("UPDATE users
                SET newsletter_consent = 0
                WHERE id = :id");
            $unsubscribeStmt->execute(['id' => $uid]);

            $cancelStmt = $pdo->prepare("UPDATE article_newsletter_queue
                SET status = 'cancelled',
                    next_attempt_at = NOW(),
                    last_error = 'Používateľ sa odhlásil z noviniek cez odkaz v e-maile.'
                WHERE user_id = :uid
                  AND status IN ('pending', 'failed')
                  AND sent_at IS NULL");
            $cancelStmt->execute(['uid' => $uid]);

            $cancelledQueueItems = (int) $cancelStmt->rowCount();
            $pdo->commit();

            $status = 'success';
            $message = 'Odber noviniek bol úspešne odhlásený.';
            if ($cancelledQueueItems > 0) {
                $message .= ' Z fronty bolo zrušených ' . $cancelledQueueItems . ' čakajúcich e-mailov.';
            }
        }
    } catch (\PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Newsletter unsubscribe DB error: ' . $e->getMessage());
        $message = 'Pri odhlásení odberu došlo k chybe. Skúste to neskôr.';
    }
}

$pageClass = $status === 'success' ? 'alert-success' : 'alert-error';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odhlásenie noviniek - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <?php
    $headerTitle = 'Odhlásenie noviniek';
    $showLogo = false;
    include 'header.php';
    ?>

    <main class="container">
        <div class="auth-container">
            <h2>Odhlásenie odberu noviniek</h2>
            <div class="alert <?= $pageClass ?>">
                <p><?= htmlspecialchars($message) ?></p>
            </div>
            <div class="auth-links auth-links--spaced">
                <p>
                    <a href="index.php">Prejsť na domovskú stránku</a>
                    |
                    <a href="login.php">Prihlásiť sa</a>
                </p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
