<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

requireAdmin();

const ERROR_INVALID_ID = 'Neplatné ID.';
const ERROR_SUBSCRIBER_NOT_FOUND = 'Odberateľ nenájdený.';

$actionResult = null;
$actionError  = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrf)) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = $_POST['action'] ?? '';
        $subId  = (int) ($_POST['sub_id'] ?? 0);

        switch ($action) {
            case 'delete_subscriber':
                if ($subId <= 0) { $actionError = ERROR_INVALID_ID; break; }
                try {
                    $s = $pdo->prepare("SELECT email FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = ERROR_SUBSCRIBER_NOT_FOUND; break; }
                    $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = :id")->execute(['id' => $subId]);
                    $actionResult = 'Odberateľ ' . $sub['email'] . ' bol natrvalo zmazaný.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter delete error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní odberateľa.';
                }
                break;

            case 'force_verify':
                if ($subId <= 0) { $actionError = ERROR_INVALID_ID; break; }
                try {
                    $s = $pdo->prepare("SELECT email, verified_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = ERROR_SUBSCRIBER_NOT_FOUND; break; }
                    if ($sub['verified_at'] !== null) { $actionError = 'Odberateľ je už overený.'; break; }
                    $pdo->prepare("UPDATE newsletter_subscribers SET verified_at = NOW(), unsubscribed_at = NULL WHERE id = :id")
                        ->execute(['id' => $subId]);
                    $actionResult = 'E-mail ' . $sub['email'] . ' bol manuálne overený.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter force_verify error: ' . $e->getMessage());
                    $actionError = 'Chyba pri manuálnom overení.';
                }
                break;

            case 'force_unsubscribe':
                if ($subId <= 0) { $actionError = ERROR_INVALID_ID; break; }
                try {
                    $s = $pdo->prepare("SELECT email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = ERROR_SUBSCRIBER_NOT_FOUND; break; }
                    if ($sub['unsubscribed_at'] !== null) { $actionError = 'Odberateľ je už odhlásený.'; break; }
                    $pdo->beginTransaction();
                    $pdo->prepare("UPDATE newsletter_subscribers SET unsubscribed_at = NOW() WHERE id = :id")
                        ->execute(['id' => $subId]);
                    $pdo->prepare(
                        "UPDATE nl_sub_queue
                         SET status = 'cancelled', next_attempt_at = NOW(), last_error = 'Odberateľ bol odhlásený administrátorom.'
                         WHERE subscriber_id = :id AND status IN ('pending', 'failed') AND sent_at IS NULL"
                    )->execute(['id' => $subId]);
                    $pdo->commit();
                    $actionResult = 'Odberateľ ' . $sub['email'] . ' bol odhlásený z odberu.';
                } catch (\PDOException $e) {
                    if ($pdo->inTransaction()) { $pdo->rollBack(); }
                    error_log('admin_newsletter force_unsubscribe error: ' . $e->getMessage());
                    $actionError = 'Chyba pri odhlasovaní odberateľa.';
                }
                break;

            case 'resend_verification':
                if ($subId <= 0) { $actionError = ERROR_INVALID_ID; break; }
                try {
                    $s = $pdo->prepare("SELECT email, verified_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = ERROR_SUBSCRIBER_NOT_FOUND; break; }
                    if ($sub['verified_at'] !== null) { $actionError = 'Odberateľ je už overený — overovací e-mail nie je potrebný.'; break; }
                    $newToken = bin2hex(random_bytes(32));
                    $pdo->prepare("UPDATE newsletter_subscribers SET verify_token = :token_hash, updated_at = NOW() WHERE id = :id")
                        ->execute(['token_hash' => hash('sha256', $newToken), 'id' => $subId]);
                    $sent = sendSubscriberVerifyEmail((string) $sub['email'], $newToken);
                    if ($sent) {
                        $actionResult = 'Overovací e-mail bol znovu odoslaný na ' . $sub['email'] . '.';
                    } else {
                        $actionError = 'Nepodarilo sa odoslať overovací e-mail.';
                    }
                } catch (\PDOException $e) {
                    error_log('admin_newsletter resend_verification error: ' . $e->getMessage());
                    $actionError = 'Chyba pri opätovnom odoslaní overovacieho e-mailu.';
                }
                break;

            case 'reactivate':
                if ($subId <= 0) { $actionError = ERROR_INVALID_ID; break; }
                try {
                    $s = $pdo->prepare("SELECT email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = ERROR_SUBSCRIBER_NOT_FOUND; break; }
                    if ($sub['unsubscribed_at'] === null) { $actionError = 'Odberateľ nie je odhlásený.'; break; }
                    $pdo->prepare("UPDATE newsletter_subscribers SET unsubscribed_at = NULL WHERE id = :id")
                        ->execute(['id' => $subId]);
                    $actionResult = 'Odber pre ' . $sub['email'] . ' bol obnovený.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter reactivate error: ' . $e->getMessage());
                    $actionError = 'Chyba pri obnovení odberu.';
                }
                break;
            default:
                $actionError = 'Neznáma akcia.';
                break;
        }
    }
}

// Filter
$statusFilter = strtolower(trim((string) ($_GET['status'] ?? '')));
if (!in_array($statusFilter, ['active', 'pending', 'unsubscribed'], true)) {
    $statusFilter = '';
}

// Štatistiky
$stats = ['total' => 0, 'active' => 0, 'pending' => 0, 'unsubscribed' => 0];
try {
    $row = $pdo->query("SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN verified_at IS NOT NULL AND unsubscribed_at IS NULL THEN 1 ELSE 0 END) AS active,
        SUM(CASE WHEN verified_at IS NULL THEN 1 ELSE 0 END) AS pending,
        SUM(CASE WHEN unsubscribed_at IS NOT NULL THEN 1 ELSE 0 END) AS unsubscribed
        FROM newsletter_subscribers")->fetch();
    if ($row) {
        $stats = [
            'total'        => (int) ($row['total'] ?? 0),
            'active'       => (int) ($row['active'] ?? 0),
            'pending'      => (int) ($row['pending'] ?? 0),
            'unsubscribed' => (int) ($row['unsubscribed'] ?? 0),
        ];
    }
} catch (\PDOException $e) {
    error_log('admin_newsletter stats error: ' . $e->getMessage());
}

// Zoznam odberateľov
$subscribers = [];
try {
    $where = match ($statusFilter) {
        'active'       => 'WHERE verified_at IS NOT NULL AND unsubscribed_at IS NULL',
        'pending'      => 'WHERE verified_at IS NULL',
        'unsubscribed' => 'WHERE unsubscribed_at IS NOT NULL',
        default        => '',
    };
    $subscribers = $pdo->query(
        "SELECT id, email, verified_at, unsubscribed_at, created_at, updated_at
         FROM newsletter_subscribers
         {$where}
         ORDER BY created_at DESC
         LIMIT 500"
    )->fetchAll();
} catch (\PDOException $e) {
    error_log('admin_newsletter list error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();
$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odberatelia newslettera – Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>"></script>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Odberatelia newslettera';
    $headerIntro = 'Správa anonymných odberateľov noviniek';
    $showLogo = false;
    include_once 'header.php';
    include_once 'admin_menu.php';
    ?>

    <main id="main-content" class="container container--wide admin-page-main" role="main">
        <div class="auth-container auth-container--wide">
            <h2>Odberatelia newslettera</h2>
            <p class="auth-subtitle">Anonymní odberatelia (bez registrácie). Registrovaných používateľov spravujte v <a href="admin.php">Administrácii</a>.</p>

            <?php if ($actionResult !== null): ?>
                <div class="alert alert-success"><p><?= htmlspecialchars($actionResult) ?></p></div>
            <?php endif; ?>
            <?php if ($actionError !== null): ?>
                <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
            <?php endif; ?>

            <!-- Štatistiky -->
            <div class="admin-stats-grid">
                <?php
                $statItems = [
                    ['label' => 'Celkom', 'value' => $stats['total'], 'filter' => ''],
                    ['label' => 'Aktívni', 'value' => $stats['active'], 'filter' => 'active'],
                    ['label' => 'Čakajú na overenie', 'value' => $stats['pending'], 'filter' => 'pending'],
                    ['label' => 'Odhlásení', 'value' => $stats['unsubscribed'], 'filter' => 'unsubscribed'],
                ];
                foreach ($statItems as $si):
                    $isActive = $statusFilter === $si['filter'];
                ?>
                <a href="admin_newsletter.php<?= $si['filter'] !== '' ? '?status=' . urlencode($si['filter']) : '' ?>"
                   class="admin-stat-link">
                    <div class="admin-stat-card<?= $isActive ? ' admin-stat-card--active' : '' ?>">
                        <div class="admin-stat-value"><?= $si['value'] ?></div>
                        <div class="admin-stat-label"><?= htmlspecialchars($si['label']) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Filter -->
            <div class="admin-filter-bar">
                <span class="admin-filter-label">Filter:</span>
                <?php
                $filterLinks = [
                    '' => 'Všetci',
                    'active' => 'Aktívni',
                    'pending' => 'Čakajú na overenie',
                    'unsubscribed' => 'Odhlásení',
                ];
                foreach ($filterLinks as $fVal => $fLabel):
                    $isSelected = $statusFilter === $fVal;
                ?>
                <a href="admin_newsletter.php<?= $fVal !== '' ? '?status=' . urlencode($fVal) : '' ?>"
                         class="<?= $isSelected ? 'btn-primary' : 'btn-secondary-small' ?> fs-085"
                         aria-label="Filter odberateľov: <?= htmlspecialchars($fLabel, ENT_QUOTES) ?>">
                    <?= htmlspecialchars($fLabel) ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Tabuľka odberateľov -->
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Stav</th>
                            <th scope="col">Zaregistrovaný</th>
                            <th scope="col">Overený</th>
                            <th scope="col">Odhlásený</th>
                            <th scope="col">Akcie</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($subscribers)): ?>
                        <tr><td colspan="7" class="admin-empty-cell">Žiadni odberatelia.</td></tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $sub):
                            $isVerified    = $sub['verified_at'] !== null;
                            $isUnsubscribed = $sub['unsubscribed_at'] !== null;
                            if ($isUnsubscribed) {
                                $statusLabel = 'Odhlásený';
                                $statusClass = 'nl-status--unsub';
                            } elseif ($isVerified) {
                                $statusLabel = 'Aktívny';
                                $statusClass = 'nl-status--active';
                            } else {
                                $statusLabel = 'Čaká na overenie';
                                $statusClass = 'nl-status--pending';
                            }
                        ?>
                        <tr>
                            <td><?= (int) $sub['id'] ?></td>
                            <td><?= htmlspecialchars((string) $sub['email']) ?></td>
                            <td><span class="nl-status <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            <td><?= htmlspecialchars((string) ($sub['created_at'] ?? '')) ?></td>
                            <td><?= $sub['verified_at'] !== null ? htmlspecialchars((string) $sub['verified_at']) : '<span class="text-muted">—</span>' ?></td>
                            <td><?= $sub['unsubscribed_at'] !== null ? htmlspecialchars((string) $sub['unsubscribed_at']) : '<span class="text-muted">—</span>' ?></td>
                            <td>
                                <div class="admin-actions-row">
                                    <?php if (!$isVerified): ?>
                                    <form method="POST" action="admin_newsletter.php" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="force_verify">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Manuálne overiť e-mail">Overiť</button>
                                    </form>
                                    <form method="POST" action="admin_newsletter.php" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="resend_verification">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Znovu odoslať overovací e-mail">Znovu odoslať</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($isVerified && !$isUnsubscribed): ?>
                                    <form method="POST" action="admin_newsletter.php" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="force_unsubscribe">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Odhlásiť odberateľa">Odhlásiť</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($isUnsubscribed): ?>
                                    <form method="POST" action="admin_newsletter.php" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="reactivate">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Obnoviť odber">Obnoviť odber</button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="POST" action="admin_newsletter.php"
                                          class="form-delete-sub d-inline" data-email="<?= htmlspecialchars((string) $sub['email'], ENT_QUOTES) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="delete_subscriber">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small text-danger" title="Natrvalo zmazať">Zmazať</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p class="mt-16 fs-08 text-muted">
                Zobrazuje sa max. 500 záznamov. Posledná aktualizácia stránky: <?= htmlspecialchars($pageLastUpdated) ?>.
            </p>
        </div>
    </main>

    <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
    document.querySelectorAll('.form-delete-sub').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var email = form.getAttribute('data-email') || '';
            if (!confirm('Natrvalo zmazať odberateľa ' + email + '?')) {
                e.preventDefault();
            }
        });
    });
    </script>
    <?php include_once 'footer.php'; ?>
</body>
</html>
