<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

requireAdmin();

$currentAdminId     = (int) ($_SESSION['user_id'] ?? 0);
$actionResult       = null;
$actionError        = null;
$actionTempPassword = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($postedCsrf)) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action       = $_POST['action'] ?? '';
        $targetUserId = (int) ($_POST['user_id'] ?? 0);

        switch ($action) {
            case 'toggle_admin':
                if ($targetUserId === $currentAdminId) {
                    $actionError = 'Nemôžete zmeniť vlastnú rolu.';
                    break;
                }
                try {
                    $tStmt = $pdo->prepare("SELECT is_admin, username FROM users WHERE id = :id");
                    $tStmt->execute(['id' => $targetUserId]);
                    $tUser = $tStmt->fetch();
                    if (!$tUser) { $actionError = 'Používateľ nenájdený.'; break; }
                    $newRole = ((int) $tUser['is_admin']) ? 0 : 1;
                    $pdo->prepare("UPDATE users SET is_admin = :role WHERE id = :id")->execute(['role' => $newRole, 'id' => $targetUserId]);
                    $actionResult = ($newRole ? 'Rola Admin udelená' : 'Rola Admin odňatá') . ' — ' . htmlspecialchars((string) $tUser['username']) . '.';
                } catch (\PDOException $e) {
                    error_log('Admin toggle_admin error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zmene roly.';
                }
                break;

            case 'toggle_active':
                if ($targetUserId === $currentAdminId) {
                    $actionError = 'Nemôžete deaktivovať vlastný účet.';
                    break;
                }
                try {
                    $tStmt = $pdo->prepare("SELECT is_active, username FROM users WHERE id = :id");
                    $tStmt->execute(['id' => $targetUserId]);
                    $tUser = $tStmt->fetch();
                    if (!$tUser) { $actionError = 'Používateľ nenájdený.'; break; }
                    $newActive = ((int) $tUser['is_active']) ? 0 : 1;
                    $pdo->prepare("UPDATE users SET is_active = :active WHERE id = :id")->execute(['active' => $newActive, 'id' => $targetUserId]);
                    $actionResult = ($newActive ? 'Účet aktivovaný' : 'Účet deaktivovaný') . ' — ' . htmlspecialchars((string) $tUser['username']) . '.';
                } catch (\PDOException $e) {
                    error_log('Admin toggle_active error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zmene stavu účtu.';
                }
                break;

            case 'reset_password':
                try {
                    $tStmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
                    $tStmt->execute(['id' => $targetUserId]);
                    $tUser = $tStmt->fetch();
                    if (!$tUser) { $actionError = 'Používateľ nenájdený.'; break; }
                    $tempPwd = bin2hex(random_bytes(8));
                    $pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id")
                        ->execute(['hash' => password_hash($tempPwd, PASSWORD_DEFAULT), 'id' => $targetUserId]);
                    // Dočasné heslo uložené oddelene — výpis cez htmlspecialchars() + <code> v šablóne
                    $actionResult = 'Heslo resetované — ' . htmlspecialchars((string) $tUser['username']) . '.';
                    $actionTempPassword = $tempPwd;
                } catch (\PDOException $e) {
                    error_log('Admin reset_password error: ' . $e->getMessage());
                    $actionError = 'Chyba pri resete hesla.';
                }
                break;

            case 'run_cleanup':
                $retDays = max(30, min(3650, (int) ($_POST['retention_days'] ?? 365)));
                try {
                    $s1 = $pdo->prepare("DELETE FROM users_profile_archive WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY)");
                    $s1->execute(['days' => $retDays]);
                    $cntProfile = $s1->rowCount();

                    $avatarBase2 = realpath(__DIR__ . '/uploads/avatars');
                    $s2 = $pdo->prepare("SELECT archived_path FROM users_avatar_archive WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY) AND archived_path IS NOT NULL");
                    $s2->execute(['days' => $retDays]);
                    $cntFiles = 0;
                    foreach ($s2->fetchAll() as $fRow) {
                        if (!empty($fRow['archived_path']) && $avatarBase2 !== false) {
                            $fp = realpath(__DIR__ . '/' . ltrim((string) $fRow['archived_path'], '/\\'));
                            if ($fp !== false && str_starts_with($fp, $avatarBase2) && is_file($fp)) {
                                if (@unlink($fp)) { $cntFiles++; }
                            }
                        }
                    }
                    $s3 = $pdo->prepare("DELETE FROM users_avatar_archive WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY)");
                    $s3->execute(['days' => $retDays]);
                    $cntAvatar = $s3->rowCount();

                    $actionResult = "Čistenie dokončené: {$cntProfile} prof. záznamov, {$cntAvatar} avatar záznamov, {$cntFiles} súborov zmazaných (retenčná lehota: {$retDays} dní).";
                } catch (\PDOException $e) {
                    error_log('Cleanup error: ' . $e->getMessage());
                    $actionError = 'Chyba počas cleanup operácie.';
                }
                break;
        }
    }
}

$errors = [];
$csrfToken = generateCsrfToken();
$noticeAudit = [];
$noticeAuditAdminOptions = [];

$auditFilterAdminId = max(0, (int) ($_GET['audit_admin_id'] ?? 0));
$auditFilterFormatRaw = strtolower(trim((string) ($_GET['audit_format'] ?? '')));
$auditAllowedFormats = ['view', 'print', 'csv', 'json', 'txt'];
$auditFilterFormat = in_array($auditFilterFormatRaw, $auditAllowedFormats, true) ? $auditFilterFormatRaw : '';

$auditFilterDateFromRaw = trim((string) ($_GET['audit_date_from'] ?? ''));
$auditFilterDateToRaw = trim((string) ($_GET['audit_date_to'] ?? ''));
$auditFilterDateFrom = preg_match('/^\d{4}-\d{2}-\d{2}$/', $auditFilterDateFromRaw) ? $auditFilterDateFromRaw : '';
$auditFilterDateTo = preg_match('/^\d{4}-\d{2}-\d{2}$/', $auditFilterDateToRaw) ? $auditFilterDateToRaw : '';
$auditDatePreset = strtolower(trim((string) ($_GET['audit_date_preset'] ?? '')));

if ($auditDatePreset !== '') {
    switch ($auditDatePreset) {
        case 'today':
            $today = date('Y-m-d');
            $auditFilterDateFrom = $today;
            $auditFilterDateTo = $today;
            break;
        case 'last7':
            $auditFilterDateFrom = date('Y-m-d', strtotime('-6 days'));
            $auditFilterDateTo = date('Y-m-d');
            break;
        case 'month':
            $auditFilterDateFrom = date('Y-m-01');
            $auditFilterDateTo = date('Y-m-t');
            break;
        default:
            $auditDatePreset = '';
            break;
    }
}

try {
    $statsStmt = $pdo->query("SELECT
        COUNT(*) AS users_total,
        SUM(CASE WHEN is_admin = 1 THEN 1 ELSE 0 END) AS admins_total,
        SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) AS inactive_total,
        (SELECT COUNT(*) FROM users_profile_archive) AS profile_changes_total,
        (SELECT COUNT(*) FROM users_avatar_archive) AS avatar_changes_total
        FROM users");
    $stats = $statsStmt->fetch();

    try {
        $blockedStmt = $pdo->query("SELECT COUNT(*) FROM login_attempts WHERE blocked_until > NOW()");
        $stats['blocked_ips_total'] = (int) $blockedStmt->fetchColumn();
    } catch (\PDOException) {
        $stats['blocked_ips_total'] = 0;
    }

    $usersStmt = $pdo->query("SELECT id, username, email, is_admin, is_active, created_at, updated_at FROM users ORDER BY id DESC LIMIT 100");
    $users = $usersStmt->fetchAll();

    $profileHistoryStmt = $pdo->query("SELECT a.id, a.user_id, u.username, u.email, a.changed_fields, a.changed_at
        FROM users_profile_archive a
        LEFT JOIN users u ON u.id = a.user_id
        ORDER BY a.changed_at DESC, a.id DESC
        LIMIT 200");
    $profileHistory = $profileHistoryStmt->fetchAll();

    $avatarHistoryStmt = $pdo->query("SELECT a.id, a.user_id, u.username, u.email, a.action, a.original_path, a.archived_path, a.replacement_path, a.changed_at
        FROM users_avatar_archive a
        LEFT JOIN users u ON u.id = a.user_id
        ORDER BY a.changed_at DESC, a.id DESC
        LIMIT 200");
    $avatarHistory = $avatarHistoryStmt->fetchAll();

    $accessLogs = [];
    try {
        $accessLogsStmt = $pdo->query("SELECT a.id, a.user_id, u.username, a.event_type, a.method, a.request_uri, a.http_status, a.client_ip, a.user_agent, a.referer, a.accept_language, a.response_time_ms, a.is_bot, a.created_at
            FROM access_logs a
            LEFT JOIN users u ON u.id = a.user_id
            ORDER BY a.created_at DESC, a.id DESC
            LIMIT 200");
        $accessLogs = $accessLogsStmt->fetchAll();
    } catch (\PDOException $e) {
        error_log('Admin access log read error: ' . $e->getMessage());
    }

    try {
        $noticeAuditAdminsStmt = $pdo->query("SELECT DISTINCT a.admin_user_id, u.username
            FROM admin_users_notice_audit a
            LEFT JOIN users u ON u.id = a.admin_user_id
            ORDER BY u.username ASC, a.admin_user_id ASC");
        $noticeAuditAdminOptions = $noticeAuditAdminsStmt->fetchAll();

        $noticeAuditWhere = [];
        $noticeAuditParams = [];

        if ($auditFilterAdminId > 0) {
            $noticeAuditWhere[] = 'a.admin_user_id = :admin_user_id';
            $noticeAuditParams['admin_user_id'] = $auditFilterAdminId;
        }

        if ($auditFilterFormat !== '') {
            $noticeAuditWhere[] = 'a.export_format = :export_format';
            $noticeAuditParams['export_format'] = $auditFilterFormat;
        }

        if ($auditFilterDateFrom !== '') {
            $noticeAuditWhere[] = 'a.created_at >= :date_from';
            $noticeAuditParams['date_from'] = $auditFilterDateFrom . ' 00:00:00';
        }

        if ($auditFilterDateTo !== '') {
            $noticeAuditWhere[] = 'a.created_at <= :date_to';
            $noticeAuditParams['date_to'] = $auditFilterDateTo . ' 23:59:59';
        }

        $noticeAuditSql = "SELECT a.id, a.admin_user_id, u.username, a.export_format, a.include_sensitive, a.generated_rows, a.client_ip, a.user_agent, a.created_at
            FROM admin_users_notice_audit a
            LEFT JOIN users u ON u.id = a.admin_user_id";

        if (!empty($noticeAuditWhere)) {
            $noticeAuditSql .= ' WHERE ' . implode(' AND ', $noticeAuditWhere);
        }

        $noticeAuditSql .= ' ORDER BY a.created_at DESC, a.id DESC LIMIT 200';

        $noticeAuditStmt = $pdo->prepare($noticeAuditSql);
        $noticeAuditStmt->execute($noticeAuditParams);
        $noticeAudit = $noticeAuditStmt->fetchAll();
    } catch (\PDOException $e) {
        error_log('Admin notice audit read error: ' . $e->getMessage());
        $noticeAudit = [];
        $noticeAuditAdminOptions = [];
    }
} catch (\PDOException $e) {
    error_log('Admin page DB error: ' . $e->getMessage());
    $errors[] = 'Nepodarilo sa načítať administrátorské údaje.';
    $stats = [
        'users_total'          => 0,
        'admins_total'         => 0,
        'inactive_total'       => 0,
        'profile_changes_total'=> 0,
        'avatar_changes_total' => 0,
        'blocked_ips_total'    => 0,
    ];
    $users = [];
    $profileHistory = [];
    $avatarHistory = [];
    $noticeAudit = [];
    $noticeAuditAdminOptions = [];
}

$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrácia - Nefro-projekt Slovensko</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <script src="nefro-ui.js?v=<?= filemtime('nefro-ui.js') ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $headerTitle = 'Administrácia systému';
    $headerIntro = 'Správa používateľov a audit zmien';
    $showLogo = false;
    include 'header.php';
    include 'admin_menu.php';
    ?>

    <main class="container container--wide">
        <div class="auth-container auth-container--wide">
            <h2>Administrácia</h2>
            <p class="auth-subtitle">Komplexné možnosti administrácie a audit histórie zmien profilov.</p>

            <p class="admin-p-intro">
                <a href="admin_articles.php" class="btn-admin-action">📝 Správa článkov</a>
            </p>

            <?php if ($actionResult !== null): ?>
                <div class="alert alert-success">
                    <p><?= htmlspecialchars($actionResult) ?></p>
                    <?php if ($actionTempPassword !== null): ?>
                        <p>Dočasné heslo: <code><?= htmlspecialchars($actionTempPassword) ?></code></p>
                        <p><em>Heslo sa zobrazí iba raz. Odovzdajte ho používateľovi bezpečným kanálom.</em></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($actionError !== null): ?>
                <div class="alert alert-error">
                    <p><?= htmlspecialchars($actionError) ?></p>
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

            <div class="admin-grid">
                <div class="admin-stat">
                    <div class="admin-stat__label">Počet používateľov</div>
                    <div class="admin-stat__value"><?= (int) ($stats['users_total'] ?? 0) ?></div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat__label">Počet admin účtov</div>
                    <div class="admin-stat__value"><?= (int) ($stats['admins_total'] ?? 0) ?></div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat__label">Neaktívne účty</div>
                    <div class="admin-stat__value"><?= (int) ($stats['inactive_total'] ?? 0) ?></div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat__label">Blokované IP adresy</div>
                    <div class="admin-stat__value"><?= (int) ($stats['blocked_ips_total'] ?? 0) ?></div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat__label">Archivované zmeny profilov</div>
                    <div class="admin-stat__value"><?= (int) ($stats['profile_changes_total'] ?? 0) ?></div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat__label">Archivované zmeny avatarov</div>
                    <div class="admin-stat__value"><?= (int) ($stats['avatar_changes_total'] ?? 0) ?></div>
                </div>
            </div>

            <div class="form-section">
                <h3>Zoznam používateľov</h3>
                <p>Generovanie kompletného zoznamu všetkých používateľov zoradených podľa priezviska (vzostupne) s možnosťou výberu režimu exportu.</p>
                <h4>Režim: bez technických a citlivých polí</h4>
                <div class="admin-notice-actions">
                    <a class="btn-admin-action" href="admin_users_notice.php?format=view&amp;include_sensitive=0" target="_blank" rel="noopener">Zobraziť dokument</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=print&amp;include_sensitive=0" target="_blank" rel="noopener">Vytlačiť</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=csv&amp;include_sensitive=0" rel="noopener">Uložiť CSV</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=json&amp;include_sensitive=0" rel="noopener">Uložiť JSON</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=txt&amp;include_sensitive=0" rel="noopener">Uložiť TXT</a>
                </div>
                <h4>Režim: vrátane technických a citlivých polí</h4>
                <div class="admin-notice-actions">
                    <form method="POST" action="admin_users_notice.php" target="_blank" class="d-inline" data-confirm="Naozaj otvoriť citlivý výstup používateľov?">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="view">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Zobraziť dokument</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" target="_blank" class="d-inline" data-confirm="Naozaj otvoriť citlivý výstup používateľov?">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="print">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Vytlačiť</button>
                    </form>
                    <p class="form-hint" style="margin:0.75rem 0 0;color:#475569;">Citlivý export vyžaduje POST požiadavku s platným CSRF tokenom.</p>
                    <form method="POST" action="admin_users_notice.php" class="d-inline" data-confirm="Naozaj otvoriť citlivý výstup používateľov?">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="csv">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Uložiť CSV</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" class="d-inline" data-confirm="Naozaj otvoriť citlivý výstup používateľov?">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="json">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Uložiť JSON</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" class="d-inline" data-confirm="Naozaj otvoriť citlivý výstup používateľov?">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="txt">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Uložiť TXT</button>
                    </form>
                </div>
                <p class="form-hint">Pre uloženie do PDF použite voľbu „Vytlačiť“ a v dialógu prehliadača vyberte „Uložiť ako PDF“.</p>
            </div>

            <div class="form-section">
                <h3>Používatelia (posledných 100)</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Používateľské meno</th>
                                <th>E-mail</th>
                                <th>Rola</th>
                                <th>Stav</th>
                                <th>Vytvorený</th>
                                <th>Akcie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr><td colspan="7">Žiadni používatelia.</td></tr>
                            <?php else: ?>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td><?= (int) $u['id'] ?></td>
                                        <td><?= htmlspecialchars((string) ($u['username'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars((string) ($u['email'] ?? '')) ?></td>
                                        <td><?= !empty($u['is_admin']) ? '<strong>Admin</strong>' : 'Používateľ' ?></td>
                                        <td><?= ((int) ($u['is_active'] ?? 1)) ? 'Aktívny' : '<em>Neaktívny</em>' ?></td>
                                        <td><?= htmlspecialchars((string) ($u['created_at'] ?? '')) ?></td>
                                        <td class="admin-actions-cell">
                                            <?php if ((int) $u['id'] !== $currentAdminId): ?>
                                                <form method="POST" action="admin.php" class="d-inline" data-confirm="Naozaj zmeniť rolu?">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                                    <input type="hidden" name="action" value="toggle_admin">
                                                    <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                                                    <button type="submit" class="btn-admin-action"><?= !empty($u['is_admin']) ? 'Odňať Admin' : 'Udeliť Admin' ?></button>
                                                </form>
                                                <form method="POST" action="admin.php" class="d-inline" data-confirm="Naozaj zmeniť stav účtu?">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                                    <input type="hidden" name="action" value="toggle_active">
                                                    <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                                                    <button type="submit" class="btn-admin-action"><?= ((int) ($u['is_active'] ?? 1)) ? 'Deaktivovať' : 'Aktivovať' ?></button>
                                                </form>
                                                <form method="POST" action="admin.php" class="d-inline" data-confirm="Naozaj resetovať heslo? Dočasné heslo bude zobrazené jednorázovo.">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                                    <input type="hidden" name="action" value="reset_password">
                                                    <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                                                    <button type="submit" class="btn-admin-action btn-admin-action--warn">Reset hesla</button>
                                                </form>
                                            <?php else: ?>
                                                <em>(vlastný účet)</em>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">
                <h3>História zmien profilov (posledných 200)</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Používateľ</th>
                                <th>E-mail</th>
                                <th>Zmenené polia</th>
                                <th>Čas zmeny</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($profileHistory)): ?>
                                <tr><td colspan="5">Zatiaľ bez histórie zmien profilov.</td></tr>
                            <?php else: ?>
                                <?php foreach ($profileHistory as $h): ?>
                                    <tr>
                                        <td><?= (int) $h['id'] ?></td>
                                        <td><?= htmlspecialchars((string) ($h['username'] ?? ('#' . (int) $h['user_id']))) ?></td>
                                        <td><?= htmlspecialchars((string) ($h['email'] ?? '')) ?></td>
                                        <td><code><?= htmlspecialchars((string) $h['changed_fields']) ?></code></td>
                                        <td><?= htmlspecialchars((string) ($h['changed_at'] ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">
                <h3>História zmien avatarov (posledných 200)</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Používateľ</th>
                                <th>Akcia</th>
                                <th>Pôvodná cesta</th>
                                <th>Archívna cesta</th>
                                <th>Nová cesta</th>
                                <th>Čas zmeny</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($avatarHistory)): ?>
                                <tr><td colspan="7">Zatiaľ bez histórie zmien avatarov.</td></tr>
                            <?php else: ?>
                                <?php foreach ($avatarHistory as $h): ?>
                                    <tr>
                                        <td><?= (int) $h['id'] ?></td>
                                        <td><?= htmlspecialchars((string) ($h['username'] ?? ('#' . (int) $h['user_id']))) ?></td>
                                        <td><?= htmlspecialchars((string) ($h['action'] ?? '')) ?></td>
                                        <td><code><?= htmlspecialchars((string) ($h['original_path'] ?? '')) ?></code></td>
                                        <td><code><?= htmlspecialchars((string) ($h['archived_path'] ?? '')) ?></code></td>
                                        <td><code><?= htmlspecialchars((string) ($h['replacement_path'] ?? '')) ?></code></td>
                                        <td><?= htmlspecialchars((string) ($h['changed_at'] ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">
                <h3>Audit log exportov zoznamu používateľov (posledných 200)</h3>
                <form method="GET" action="admin.php">
                    <div class="form-group form-group--inline">
                        <label for="audit_admin_id">Admin:</label>
                        <select id="audit_admin_id" name="audit_admin_id" class="form-control form-control--short">
                            <option value="0">Všetci</option>
                            <?php foreach ($noticeAuditAdminOptions as $opt): ?>
                                <?php $optAdminId = (int) ($opt['admin_user_id'] ?? 0); ?>
                                <option value="<?= $optAdminId ?>" <?= ($auditFilterAdminId === $optAdminId) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars((string) (($opt['username'] ?? '') !== '' ? $opt['username'] : ('#' . $optAdminId))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="audit_format">Formát:</label>
                        <select id="audit_format" name="audit_format" class="form-control form-control--short">
                            <option value="">Všetky</option>
                            <?php foreach ($auditAllowedFormats as $fmt): ?>
                                <option value="<?= htmlspecialchars($fmt) ?>" <?= ($auditFilterFormat === $fmt) ? 'selected' : '' ?>><?= htmlspecialchars(strtoupper($fmt)) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="audit_date_from">Dátum od:</label>
                        <input type="date" id="audit_date_from" name="audit_date_from" value="<?= htmlspecialchars($auditFilterDateFrom) ?>" class="form-control">

                        <label for="audit_date_to">Dátum do:</label>
                        <input type="date" id="audit_date_to" name="audit_date_to" value="<?= htmlspecialchars($auditFilterDateTo) ?>" class="form-control">

                        <button type="submit" class="btn-admin-action">Filtrovať</button>
                        <button type="submit" name="audit_date_preset" value="today" class="btn-admin-action <?= ($auditDatePreset === 'today') ? 'btn-admin-action--active' : '' ?>">Dnes</button>
                        <button type="submit" name="audit_date_preset" value="last7" class="btn-admin-action <?= ($auditDatePreset === 'last7') ? 'btn-admin-action--active' : '' ?>">Posledných 7 dní</button>
                        <button type="submit" name="audit_date_preset" value="month" class="btn-admin-action <?= ($auditDatePreset === 'month') ? 'btn-admin-action--active' : '' ?>">Tento mesiac</button>
                        <a href="admin.php" class="btn-admin-action">Zrušiť filter</a>
                    </div>
                </form>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Admin</th>
                                <th>Formát</th>
                                <th>Citlivé polia</th>
                                <th>Počet riadkov</th>
                                <th>IP adresa</th>
                                <th>User Agent</th>
                                <th>Čas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($noticeAudit)): ?>
                                <tr><td colspan="8">Zatiaľ bez záznamov v audit logu exportov zoznamu používateľov.</td></tr>
                            <?php else: ?>
                                <?php foreach ($noticeAudit as $a): ?>
                                    <tr>
                                        <td><?= (int) $a['id'] ?></td>
                                        <td><?= htmlspecialchars((string) ($a['username'] ?? ('#' . (int) $a['admin_user_id']))) ?></td>
                                        <td><?= htmlspecialchars(strtoupper((string) ($a['export_format'] ?? ''))) ?></td>
                                        <td><?= ((int) ($a['include_sensitive'] ?? 0) === 1) ? 'Áno' : 'Nie' ?></td>
                                        <td><?= (int) ($a['generated_rows'] ?? 0) ?></td>
                                        <td><?= htmlspecialchars((string) ($a['client_ip'] ?? '')) ?></td>
                                        <td><code><?= htmlspecialchars((string) ($a['user_agent'] ?? '')) ?></code></td>
                                        <td><?= htmlspecialchars((string) ($a['created_at'] ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">
                <h3>Audit log prístupov (posledných 200)</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Používateľ</th>
                                <th>Typ</th>
                                <th>Metóda</th>
                                <th>URI</th>
                                <th>Stav</th>
                                <th>IP adresa</th>
                                <th>Bot</th>
                                <th>Čas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($accessLogs)): ?>
                                <tr><td colspan="9">Zatiaľ bez záznamov v access logu.</td></tr>
                            <?php else: ?>
                                <?php foreach ($accessLogs as $log): ?>
                                    <tr>
                                        <td><?= (int) $log['id'] ?></td>
                                        <td><?= htmlspecialchars((string) ($log['username'] ?? ('#' . (int) $log['user_id']))) ?></td>
                                        <td><?= htmlspecialchars((string) $log['event_type']) ?></td>
                                        <td><?= htmlspecialchars((string) $log['method']) ?></td>
                                        <td><code><?= htmlspecialchars((string) $log['request_uri']) ?></code></td>
                                        <td><?= (int) $log['http_status'] ?></td>
                                        <td><?= htmlspecialchars((string) ($log['client_ip'] ?? '')) ?></td>
                                        <td><?= ((int) ($log['is_bot'] ?? 0) === 1) ? 'Áno' : 'Nie' ?></td>
                                        <td><?= htmlspecialchars((string) ($log['created_at'] ?? '')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">
                <h3>Cleanup archívnych dát</h3>
                <p>Zmaže záznamy staršie ako zadaný počet dní z tabuliek <code>users_profile_archive</code> a <code>users_avatar_archive</code> vrátane súborov na disku.</p>
                <form method="POST" action="admin.php" data-confirm="Naozaj spustiť cleanup? Operácia je nevratná.">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="action" value="run_cleanup">
                    <div class="form-group form-group--inline">
                        <label for="retention_days">Retenčná lehota (dni):</label>
                        <input type="number" id="retention_days" name="retention_days" value="365" min="30" max="3650" class="form-control form-control--short">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Spustiť cleanup</button>
                    </div>
                </form>
                <p class="form-hint">Pre automatizáciu použite CLI skript: <code>php archive_cleanup.php [profile_days] [avatar_days]</code></p>
            </div>

            <div class="auth-links auth-links--spaced">
                <p><a href="index.php">Späť na domovskú stránku</a> | <a href="logout.php" class="link-error">Odhlásiť sa</a></p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
