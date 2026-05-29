<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

requireAdmin();

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
                if ($subId <= 0) { $actionError = 'Neplatné ID.'; break; }
                try {
                    $s = $pdo->prepare("SELECT email FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = 'Odberateľ nenájdený.'; break; }
                    $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = :id")->execute(['id' => $subId]);
                    $actionResult = 'Odberateľ ' . $sub['email'] . ' bol natrvalo zmazaný.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter delete error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní odberateľa.';
                }
                break;

            case 'force_verify':
                if ($subId <= 0) { $actionError = 'Neplatné ID.'; break; }
                try {
                    $s = $pdo->prepare("SELECT email, verified_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = 'Odberateľ nenájdený.'; break; }
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
                if ($subId <= 0) { $actionError = 'Neplatné ID.'; break; }
                try {
                    $s = $pdo->prepare("SELECT email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = 'Odberateľ nenájdený.'; break; }
                    if ($sub['unsubscribed_at'] !== null) { $actionError = 'Odberateľ je už odhlásený.'; break; }
                    $pdo->prepare("UPDATE newsletter_subscribers SET unsubscribed_at = NOW() WHERE id = :id")
                        ->execute(['id' => $subId]);
                    $actionResult = 'Odberateľ ' . $sub['email'] . ' bol odhlásený z odberu.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter force_unsubscribe error: ' . $e->getMessage());
                    $actionError = 'Chyba pri odhlasovaní odberateľa.';
                }
                break;

            case 'resend_verification':
                if ($subId <= 0) { $actionError = 'Neplatné ID.'; break; }
                try {
                    $s = $pdo->prepare("SELECT email, verified_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = 'Odberateľ nenájdený.'; break; }
                    if ($sub['verified_at'] !== null) { $actionError = 'Odberateľ je už overený — overovací e-mail nie je potrebný.'; break; }
                    $newToken = bin2hex(random_bytes(32));
                    $pdo->prepare("UPDATE newsletter_subscribers SET verify_token = :token, updated_at = NOW() WHERE id = :id")
                        ->execute(['token' => $newToken, 'id' => $subId]);
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
                if ($subId <= 0) { $actionError = 'Neplatné ID.'; break; }
                try {
                    $s = $pdo->prepare("SELECT email, unsubscribed_at FROM newsletter_subscribers WHERE id = :id LIMIT 1");
                    $s->execute(['id' => $subId]);
                    $sub = $s->fetch();
                    if (!$sub) { $actionError = 'Odberateľ nenájdený.'; break; }
                    if ($sub['unsubscribed_at'] === null) { $actionError = 'Odberateľ nie je odhlásený.'; break; }
                    $pdo->prepare("UPDATE newsletter_subscribers SET unsubscribed_at = NULL WHERE id = :id")
                        ->execute(['id' => $subId]);
                    $actionResult = 'Odber pre ' . $sub['email'] . ' bol obnovený.';
                } catch (\PDOException $e) {
                    error_log('admin_newsletter reactivate error: ' . $e->getMessage());
                    $actionError = 'Chyba pri obnovení odberu.';
                }
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
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <script src="nefro-ui.js?v=<?= filemtime('nefro-ui.js') ?>" defer></script>
</head>
<body>
    <?php
    $headerTitle = 'Odberatelia newslettera';
    $headerIntro = 'Správa anonymných odberateľov noviniek';
    $showLogo = false;
    include 'header.php';
    include 'admin_menu.php';
    ?>

    <main class="container container--wide admin-page-main">
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
            <div class="admin-stats-grid" style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:24px;">
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
                   style="flex:1;min-width:130px;text-decoration:none;">
                    <div class="admin-stat-card<?= $isActive ? ' admin-stat-card--active' : '' ?>"
                         style="border:2px solid <?= $isActive ? '#0055a5' : '#e2e8f0' ?>;border-radius:8px;padding:16px;text-align:center;background:<?= $isActive ? '#eff6ff' : 'var(--bg-card, #fff)' ?>;">
                        <div style="font-size:1.8rem;font-weight:700;color:#0055a5;"><?= $si['value'] ?></div>
                        <div style="font-size:0.85rem;color:#64748b;margin-top:4px;"><?= htmlspecialchars($si['label']) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Filter -->
            <div style="margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                <span style="font-size:0.9rem;color:#64748b;">Filter:</span>
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
                   class="<?= $isSelected ? 'btn-primary' : 'btn-secondary-small' ?>"
                   style="font-size:0.85rem;">
                    <?= htmlspecialchars($fLabel) ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Tabuľka odberateľov -->
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>E-mail</th>
                            <th>Stav</th>
                            <th>Zaregistrovaný</th>
                            <th>Overený</th>
                            <th>Odhlásený</th>
                            <th>Akcie</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($subscribers)): ?>
                        <tr><td colspan="7" style="text-align:center;padding:24px;color:#64748b;">Žiadni odberatelia.</td></tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $sub):
                            $isVerified    = $sub['verified_at'] !== null;
                            $isUnsubscribed = $sub['unsubscribed_at'] !== null;
                            if ($isUnsubscribed) {
                                $statusLabel = 'Odhlásený';
                                $statusColor = '#dc2626';
                            } elseif ($isVerified) {
                                $statusLabel = 'Aktívny';
                                $statusColor = '#16a34a';
                            } else {
                                $statusLabel = 'Čaká na overenie';
                                $statusColor = '#d97706';
                            }
                        ?>
                        <tr>
                            <td><?= (int) $sub['id'] ?></td>
                            <td><?= htmlspecialchars((string) $sub['email']) ?></td>
                            <td><span style="color:<?= $statusColor ?>;font-weight:600;font-size:0.85rem;"><?= $statusLabel ?></span></td>
                            <td><?= htmlspecialchars((string) ($sub['created_at'] ?? '')) ?></td>
                            <td><?= $sub['verified_at'] !== null ? htmlspecialchars((string) $sub['verified_at']) : '<span style="color:#94a3b8;">—</span>' ?></td>
                            <td><?= $sub['unsubscribed_at'] !== null ? htmlspecialchars((string) $sub['unsubscribed_at']) : '<span style="color:#94a3b8;">—</span>' ?></td>
                            <td>
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                    <?php if (!$isVerified): ?>
                                    <form method="POST" action="admin_newsletter.php" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="force_verify">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Manuálne overiť e-mail">Overiť</button>
                                    </form>
                                    <form method="POST" action="admin_newsletter.php" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="resend_verification">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Znovu odoslať overovací e-mail">Znovu odoslať</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($isVerified && !$isUnsubscribed): ?>
                                    <form method="POST" action="admin_newsletter.php" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="force_unsubscribe">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Odhlásiť odberateľa">Odhlásiť</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($isUnsubscribed): ?>
                                    <form method="POST" action="admin_newsletter.php" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="reactivate">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" title="Obnoviť odber">Obnoviť odber</button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="POST" action="admin_newsletter.php" style="display:inline;"
                                          onsubmit="return confirm('Natrvalo zmazať odberateľa <?= htmlspecialchars((string) $sub['email'], ENT_QUOTES) ?>?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="action" value="delete_subscriber">
                                        <input type="hidden" name="sub_id" value="<?= (int) $sub['id'] ?>">
                                        <button type="submit" class="btn-secondary-small" style="color:#dc2626;" title="Natrvalo zmazať">Zmazať</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p style="margin-top:16px;font-size:0.8rem;color:#94a3b8;">
                Zobrazuje sa max. 500 záznamov. Posledná aktualizácia stránky: <?= htmlspecialchars($pageLastUpdated) ?>.
            </p>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
