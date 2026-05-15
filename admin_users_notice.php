<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'phone_utils.php';

requireAdmin();
$currentAdminId = (int) ($_SESSION['user_id'] ?? 0);
$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
$csrfToken = generateCsrfToken();

$requiredColumns = ['last_name', 'first_name', 'username', 'email', 'mobile_phone'];
$hardBlockedColumns = [
    'password_hash',
    'email_verification_token_hash',
    'mobile_verification_code_hash',
];
$sensitiveColumns = [
    'password_hash',
    'email_verification_token_hash',
    'email_verification_expires_at',
    'email_verification_sent_at',
    'mobile_verification_code_hash',
    'mobile_verification_expires_at',
    'mobile_verification_sent_at',
];

$columnLabelMap = [
    'id' => 'ID',
    'username' => 'Používateľské meno',
    'gender' => 'Pohlavie',
    'pronouns' => 'Zámená',
    'avatar_path' => 'Cesta avatara',
    'email' => 'E-mail',
    'email_verified_at' => 'E-mail overený',
    'mobile_verified_at' => 'Mobil overený',
    'title_before' => 'Titul pred',
    'first_name' => 'Meno',
    'middle_name' => 'Stredné meno',
    'last_name' => 'Priezvisko',
    'title_after' => 'Titul za',
    'name_note' => 'Poznámka k menu',
    'organization' => 'Organizácia',
    'job_function' => 'Pracovná pozícia',
    'work_mobile_phone' => 'Pracovný mobil',
    'org_website' => 'Web organizácie',
    'work_email' => 'Pracovný e-mail',
    'mobile_phone' => 'Telefónne číslo',
    'other_phone' => 'Iné telefónne číslo',
    'social_linkedin' => 'LinkedIn',
    'social_x' => 'X (Twitter)',
    'social_facebook' => 'Facebook',
    'social_instagram' => 'Instagram',
    'social_other' => 'Iné sociálne siete',
    'other_contact' => 'Iný kontakt',
    'website' => 'Webstránka',
    'birth_date' => 'Dátum narodenia',
    'street' => 'Ulica',
    'house_number' => 'Súpisné číslo',
    'orientation_number' => 'Orientačné číslo',
    'zip_code' => 'PSČ',
    'city' => 'Mesto',
    'district' => 'Okres',
    'region' => 'Kraj',
    'country' => 'Štát',
    'address_note' => 'Poznámka k adrese',
    'is_admin' => 'Admin účet',
    'is_active' => 'Aktívny účet',
    'newsletter_consent' => 'Súhlas s newslettrom',
    'created_at' => 'Vytvorený',
    'updated_at' => 'Naposledy upravený',
];

$format = strtolower((string) ($_REQUEST['format'] ?? 'view'));
if (!in_array($format, ['view', 'print', 'csv', 'json', 'txt'], true)) {
    $format = 'view';
}

$includeSensitive = ((string) ($_REQUEST['include_sensitive'] ?? '0')) === '1';

if ($includeSensitive) {
    $postedCsrf = $_POST['csrf_token'] ?? '';
    if ($requestMethod !== 'POST' || !validateCsrfToken($postedCsrf)) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Citlivý export vyžaduje POST požiadavku s platným CSRF tokenom.';
        exit;
    }
}

try {
    $allColumnsStmt = $pdo->query('SHOW COLUMNS FROM users');
    $allColumnsRows = $allColumnsStmt->fetchAll();
    $allColumns = [];
    foreach ($allColumnsRows as $colRow) {
        $field = (string) ($colRow['Field'] ?? '');
        if ($field !== '') {
            $allColumns[] = $field;
        }
    }

    $safeColumns = array_values(array_filter(
        $allColumns,
        static fn(string $col): bool => !in_array($col, $hardBlockedColumns, true)
    ));

    if (!$includeSensitive) {
        $safeColumns = array_values(array_filter(
            $safeColumns,
            static fn(string $col): bool => !in_array($col, $sensitiveColumns, true)
        ));
    }

    $orderedColumns = [];
    foreach ($requiredColumns as $required) {
        if (in_array($required, $safeColumns, true)) {
            $orderedColumns[] = $required;
        }
    }

    foreach ($safeColumns as $safeCol) {
        if (!in_array($safeCol, $orderedColumns, true)) {
            $orderedColumns[] = $safeCol;
        }
    }

    if (empty($orderedColumns)) {
        throw new RuntimeException('Nepodarilo sa pripraviť zoznam stĺpcov používateľov.');
    }

    $queryColumns = array_map(static fn(string $col): string => "`{$col}`", $orderedColumns);
    $orderLastName = in_array('last_name', $orderedColumns, true) ? '`last_name` ASC' : '`id` ASC';
    $orderFirstName = in_array('first_name', $orderedColumns, true) ? ', `first_name` ASC' : '';
    $orderUsername = in_array('username', $orderedColumns, true) ? ', `username` ASC' : '';

    $sql = 'SELECT ' . implode(', ', $queryColumns) . ' FROM users ORDER BY ' . $orderLastName . $orderFirstName . $orderUsername;
    $usersStmt = $pdo->query($sql);
    $users = $usersStmt->fetchAll();
} catch (Throwable $e) {
    error_log('Admin users notice error: ' . $e->getMessage());
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Nepodarilo sa pripraviť zoznam používateľov.';
    exit;
}

try {
    $clientIp = substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    $userAgent = substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500);
    $auditStmt = $pdo->prepare('INSERT INTO admin_users_notice_audit (admin_user_id, export_format, include_sensitive, generated_rows, client_ip, user_agent)
        VALUES (:admin_user_id, :export_format, :include_sensitive, :generated_rows, :client_ip, :user_agent)');
    $auditStmt->execute([
        'admin_user_id' => $currentAdminId,
        'export_format' => $format,
        'include_sensitive' => $includeSensitive ? 1 : 0,
        'generated_rows' => count($users),
        'client_ip' => $clientIp,
        'user_agent' => $userAgent,
    ]);
} catch (Throwable $e) {
    error_log('Admin users notice audit write error: ' . $e->getMessage());
}

$labelFor = static function (string $column) use ($columnLabelMap): string {
    return $columnLabelMap[$column] ?? str_replace('_', ' ', ucfirst($column));
};

$phoneColumns = ['mobile_phone', 'work_mobile_phone', 'other_phone'];
$formatCellValue = static function (string $column, mixed $value) use ($phoneColumns): string {
    $stringValue = (string) ($value ?? '');
    if (in_array($column, $phoneColumns, true)) {
        return formatPhoneForDisplay($stringValue);
    }
    return $stringValue;
};

if ($format === 'csv') {
    $timestamp = date('Ymd_His');
    $filename = 'zoznam_pouzivatelov_' . $timestamp . '.csv';

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'wb');
    if ($output === false) {
        exit;
    }

    $headers = array_map($labelFor, $orderedColumns);
    fputcsv($output, $headers, ';');

    foreach ($users as $userRow) {
        $line = [];
        foreach ($orderedColumns as $col) {
            $value = $userRow[$col] ?? '';
            if (is_bool($value)) {
                $line[] = $value ? '1' : '0';
            } else {
                $line[] = (string) $value;
            }
        }
        fputcsv($output, $line, ';');
    }

    fclose($output);
    exit;
}

if ($format === 'json') {
    $timestamp = date('Ymd_His');
    $filename = 'zoznam_pouzivatelov_' . $timestamp . '.json';

    header('Content-Type: application/json; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $payload = [
        'generated_at' => date('c'),
        'total_users' => count($users),
        'columns' => array_map($labelFor, $orderedColumns),
        'column_keys' => $orderedColumns,
        'users' => $users,
    ];

    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

if ($format === 'txt') {
    $timestamp = date('Ymd_His');
    $filename = 'zoznam_pouzivatelov_' . $timestamp . '.txt';

    header('Content-Type: text/plain; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo "Zoznam používateľov\n";
    echo "Generované: " . date('d.m.Y H:i:s') . "\n";
    echo "Počet používateľov: " . count($users) . "\n\n";

    if (empty($users)) {
        echo "V databáze sa nenašli žiadni používatelia.\n";
        exit;
    }

    $counter = 1;
    foreach ($users as $userRow) {
        echo "Používateľ #" . $counter . "\n";
        foreach ($orderedColumns as $col) {
            $label = $labelFor($col);
            $value = $formatCellValue($col, $userRow[$col] ?? '');
            echo $label . ': ' . $value . "\n";
        }
        echo str_repeat('-', 72) . "\n";
        $counter++;
    }

    exit;
}

$isPrintMode = ($format === 'print');
$nowHuman = date('d.m.Y H:i:s');
$totalUsers = count($users);
$modeLabel = $includeSensitive
    ? 'Rozšírený režim (bez hash/token polí)'
    : 'Bez technických/citlivých polí';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoznam používateľov - Nefro</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body class="admin-notice-page">
    <div class="print-layout-table">
        <div class="print-layout-thead">
            <div class="admin-print-header print-only">
                <div>Zoznam používateľov</div>
                <div>Generované: <?= htmlspecialchars($nowHuman) ?></div>
            </div>
        </div>
        
        <div class="print-layout-tbody">
            <main class="container admin-notice-container">
        <div class="auth-container auth-container--wide admin-notice-card">
            <h2>Zoznam používateľov</h2>
            <p class="auth-subtitle">Zoznam všetkých používateľov zoradený abecedne podľa priezviska.</p>

            <div class="admin-notice-meta">
                <span>Generované: <strong><?= htmlspecialchars($nowHuman) ?></strong></span>
                <span>Počet používateľov: <strong><?= (int) $totalUsers ?></strong></span>
                <span>Režim: <strong><?= htmlspecialchars($modeLabel) ?></strong></span>
            </div>

            <div class="admin-notice-actions no-print">
                <?php if ($includeSensitive): ?>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj pokračovať v citlivom exporte?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="view">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Zobraziť</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj pokračovať v citlivom exporte?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="print">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Tlačiť</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj pokračovať v citlivom exporte?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="csv">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Stiahnuť CSV</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj pokračovať v citlivom exporte?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="json">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Stiahnuť JSON</button>
                    </form>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj pokračovať v citlivom exporte?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="txt">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Stiahnuť TXT</button>
                    </form>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=view&amp;include_sensitive=0">Prepnúť na bezpečný režim</a>
                <?php else: ?>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=view&amp;include_sensitive=0">Zobraziť</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=print&amp;include_sensitive=0">Tlačiť</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=csv&amp;include_sensitive=0">Stiahnuť CSV</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=json&amp;include_sensitive=0">Stiahnuť JSON</a>
                    <a class="btn-admin-action" href="admin_users_notice.php?format=txt&amp;include_sensitive=0">Stiahnuť TXT</a>
                    <form method="POST" action="admin_users_notice.php" style="display:inline" onsubmit="return confirm('Naozaj prepnúť na citlivý režim exportu?')">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="format" value="view">
                        <input type="hidden" name="include_sensitive" value="1">
                        <button type="submit" class="btn-admin-action btn-admin-action--warn">Prepnúť na citlivý režim</button>
                    </form>
                <?php endif; ?>
                <a class="btn-admin-action" href="admin.php">Späť na Admin panel</a>
            </div>

            <div class="admin-table-wrap screen-only">
                <table class="admin-table admin-notice-table">
                    <thead>
                        <tr>
                            <?php foreach ($orderedColumns as $col): ?>
                                <th><?= htmlspecialchars($labelFor($col)) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="<?= (int) count($orderedColumns) ?>">V databáze sa nenašli žiadni používatelia.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $userRow): ?>
                                <tr>
                                    <?php foreach ($orderedColumns as $col): ?>
                                        <td><?= htmlspecialchars($formatCellValue($col, $userRow[$col] ?? '')) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="admin-notice-print-list print-only">
                <?php if (empty($users)): ?>
                    <p>V databáze sa nenašli žiadni používatelia.</p>
                <?php else: ?>
                    <?php foreach ($users as $index => $userRow): ?>
                        <section class="admin-notice-print-user">
                            <h3>Používateľ #<?= (int) ($index + 1) ?></h3>
                            <?php foreach ($orderedColumns as $col): ?>
                                <div class="admin-notice-print-row">
                                    <strong><?= htmlspecialchars($labelFor($col)) ?>:</strong>
                                    <span><?= htmlspecialchars($formatCellValue($col, $userRow[$col] ?? '')) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    </div> <!-- end print-layout-tbody -->
    
    <div class="print-layout-tfoot">
        <div class="admin-print-footer print-only">
            <span>Nefro - Zoznam používateľov</span>
        </div>
    </div>
    </div> <!-- end print-layout-table -->

    <?php if ($isPrintMode): ?>
        <script>
            window.addEventListener('load', function () {
                window.print();
            });
        </script>
    <?php endif; ?>
</body>
</html>