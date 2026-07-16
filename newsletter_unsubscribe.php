<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
header('Referrer-Policy: no-referrer');
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$status = 'error';
$message = 'Neplatný alebo neúplný odhlasovací odkaz.';
$showConfirmation = false;
$isPost = $requestMethod === 'POST';
$request = $isPost ? $_POST : $_GET;

$uid = (int) ($request['uid'] ?? 0);
$expiresAt = (int) ($request['exp'] ?? 0);
$signature = trim((string) ($request['sig'] ?? ''));

// Anonymný odberateľ (newsletter_subscribers)
$subId    = (int) ($request['sub'] ?? 0);
$subToken = trim((string) ($request['token'] ?? ''));

if ($isPost && !validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
    $message = 'Neplatný CSRF token. Otvorte odhlasovací odkaz znova.';
} elseif ($subId > 0 && $expiresAt > 0 && $signature !== '') {
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
        } elseif (!$isPost) {
            $status = 'confirm';
            $message = 'Potvrďte, že chcete túto e-mailovú adresu odhlásiť z odberu noviniek.';
            $showConfirmation = true;
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
        } elseif (!$isPost) {
            $status = 'confirm';
            $message = 'Potvrďte, že chcete túto e-mailovú adresu odhlásiť z odberu noviniek.';
            $showConfirmation = true;
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
        } elseif (!$isPost) {
            $status = 'confirm';
            $message = 'Potvrďte, že chcete túto e-mailovú adresu odhlásiť z odberu noviniek.';
            $showConfirmation = true;
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

if ($isPost && $status === 'success') {
    $_SESSION['newsletter_unsubscribe_flash'] = $message;
    header('Location: newsletter_unsubscribe.php?done=1', true, 303);
    exit;
}
if (!$isPost && isset($_SESSION['newsletter_unsubscribe_flash'])) {
    $status = 'success';
    $message = (string) $_SESSION['newsletter_unsubscribe_flash'];
    $showConfirmation = false;
    unset($_SESSION['newsletter_unsubscribe_flash']);
}

$pageClass = match ($status) {
    'success' => 'alert-success',
    'confirm' => 'alert-success',
    default => 'alert-error',
};
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Odhlásenie noviniek - Nefro-projekt Slovensko</title>
    <link rel="stylesheet" href="index.css?v=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=<?= filemtime('ui-preferences.js') ?>"></script>
    <script src="theme.js?v=<?= filemtime('theme.js') ?>"></script>
    <script src="ui-preferences-fallback.js?v=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Odhlásenie noviniek';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container" role="main">
        <div class="auth-container">
            <h2>Odhlásenie odberu noviniek</h2>
            <div class="alert <?= htmlspecialchars($pageClass, ENT_QUOTES) ?>">
                <p><?= htmlspecialchars($message) ?></p>
            </div>
            <?php if ($showConfirmation): ?>
                <form method="POST" action="newsletter_unsubscribe.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                    <?php if ($uid > 0): ?><input type="hidden" name="uid" value="<?= $uid ?>"><?php endif; ?>
                    <?php if ($subId > 0): ?><input type="hidden" name="sub" value="<?= $subId ?>"><?php endif; ?>
                    <?php if ($expiresAt > 0): ?><input type="hidden" name="exp" value="<?= $expiresAt ?>"><?php endif; ?>
                    <?php if ($signature !== ''): ?><input type="hidden" name="sig" value="<?= htmlspecialchars($signature) ?>"><?php endif; ?>
                    <?php if ($subToken !== ''): ?><input type="hidden" name="token" value="<?= htmlspecialchars($subToken) ?>"><?php endif; ?>
                    <div class="form-actions">
                        <button type="submit" class="btn-danger">Potvrdiť odhlásenie</button>
                        <a href="index.php" class="btn-secondary">Ponechať odber</a>
                    </div>
                </form>
            <?php endif; ?>
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
