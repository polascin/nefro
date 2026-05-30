<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$status = 'error';
$message = 'Neplatný alebo neúplný odhlasovací odkaz.';

$uid = (int) ($_GET['uid'] ?? 0);
$expiresAt = (int) ($_GET['exp'] ?? 0);
$signature = trim((string) ($_GET['sig'] ?? ''));

// Anonymný odberateľ (newsletter_subscribers)
$subId    = (int) ($_GET['sub'] ?? 0);
$subToken = trim((string) ($_GET['token'] ?? ''));

if ($subId > 0 && $expiresAt > 0 && $signature !== '') {
    // Nový HMAC odhlasovací odkaz (bez DB tokenu)
    try {
        $stmt = $pdo->prepare(
            "SELECT id, email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id AND verified_at IS NOT NULL LIMIT 1"
        );
        $stmt->execute(['id' => $subId]);
        $sub = $stmt->fetch();

        if (!$sub) {
            $message = 'Odhlasovací odkaz nie je platný.';
        } elseif (!verifySubscriberUnsubscribeHmac($subId, (string) ($sub['email'] ?? ''), $expiresAt, $signature)) {
            $message = 'Odhlasovací odkaz je neplatný alebo jeho platnosť vypršala.';
        } elseif ($sub['unsubscribed_at'] !== null) {
            $status  = 'success';
            $message = 'Odber noviniek je už odhlásený.';
        } else {
            $pdo->beginTransaction();
            $pdo->prepare(
                "UPDATE newsletter_subscribers SET unsubscribed_at = NOW() WHERE id = :id"
            )->execute(['id' => $subId]);
            $cancelStmt = $pdo->prepare(
                "UPDATE nl_sub_queue SET status='cancelled', next_attempt_at=NOW(), last_error='Odberateľ sa odhlásil.'
                 WHERE subscriber_id = :sid AND status IN ('pending','failed') AND sent_at IS NULL"
            );
            $cancelStmt->execute(['sid' => $subId]);
            $cancelled = (int) $cancelStmt->rowCount();
            $pdo->commit();

            $status  = 'success';
            $message = 'Odber noviniek bol úspešne odhlásený.';
            if ($cancelled > 0) {
                $message .= ' Z fronty bolo zrušených ' . $cancelled . ' čakajúcich e-mailov.';
            }
        }
    } catch (\PDOException $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log('Newsletter sub HMAC unsubscribe error: ' . $e->getMessage());
        $message = 'Pri odhlásení odberu došlo k chybe. Skúste to neskôr.';
    }
} elseif ($subId > 0 && $subToken !== '') {
    // Starý formát tokenu — backward kompatibilita (token v URL, hash v DB)
    try {
        $stmt = $pdo->prepare(
            "SELECT id, email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id AND unsub_token = :token_hash LIMIT 1"
        );
        $stmt->execute(['id' => $subId, 'token_hash' => hash('sha256', $subToken)]);
        $sub = $stmt->fetch();

        if (!$sub) {
            $message = 'Odhlasovací odkaz nie je platný.';
        } elseif ($sub['unsubscribed_at'] !== null) {
            $status  = 'success';
            $message = 'Odber noviniek je už odhlásený.';
        } else {
            $pdo->beginTransaction();
            $pdo->prepare(
                "UPDATE newsletter_subscribers SET unsubscribed_at = NOW() WHERE id = :id"
            )->execute(['id' => $subId]);
            $cancelStmt = $pdo->prepare(
                "UPDATE nl_sub_queue SET status='cancelled', next_attempt_at=NOW(), last_error='Odberateľ sa odhlásil.'
                 WHERE subscriber_id = :sid AND status IN ('pending','failed') AND sent_at IS NULL"
            );
            $cancelStmt->execute(['sid' => $subId]);
            $cancelled = (int) $cancelStmt->rowCount();
            $pdo->commit();

            $status  = 'success';
            $message = 'Odber noviniek bol úspešne odhlásený.';
            if ($cancelled > 0) {
                $message .= ' Z fronty bolo zrušených ' . $cancelled . ' čakajúcich e-mailov.';
            }
        }
    } catch (\PDOException $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log('Newsletter sub unsubscribe error: ' . $e->getMessage());
        $message = 'Pri odhlásení odberu došlo k chybe. Skúste to neskôr.';
    }
} elseif ($uid > 0 && $expiresAt > 0 && $signature !== '') {
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
} // end elseif registered user

$pageClass = $status === 'success' ? 'alert-success' : 'alert-error';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odhlásenie noviniek - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Odhlásenie noviniek';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container">
        <div class="auth-container">
            <h2>Odhlásenie odberu noviniek</h2>
            <div class="alert <?= htmlspecialchars($pageClass, ENT_QUOTES) ?>">
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
