<?php

declare(strict_types=1);
/**
 * archive_cleanup.php — CLI-only retenčný cleanup skript
 *
 * Použitie: php archive_cleanup.php [profile_days] [avatar_days] [access_log_days]
 * Predvolená retenčná lehota: 365 dní pre archívy, 90 dní pre access logy/rate-limit záznamy.
 *
 * Príklad cron jobu (každú nedeľu o 02:00):
 *   0 2 * * 0 /usr/bin/php /path/to/nefro/archive_cleanup.php >> /var/log/nefro_cleanup.log 2>&1
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Tento skript je dostupný iba z príkazového riadku.\n");
}

$profileRetentionDays = max(30, (int) ($argv[1] ?? 365));
$avatarRetentionDays  = max(30, (int) ($argv[2] ?? 365));
$accessLogRetentionDays = min(90, max(30, (int) ($argv[3] ?? 90)));

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

echo "Nefro Archív Cleanup\n";
echo "====================\n";
echo "Dátum:                    " . date('Y-m-d H:i:s') . "\n";
echo "Retenčná lehota profilov: {$profileRetentionDays} dní\n";
echo "Retenčná lehota avatarov: {$avatarRetentionDays} dní\n";
echo "Retenčná lehota logov: {$accessLogRetentionDays} dní\n\n";

$errors          = [];
$profileDeleted  = 0;
$avatarDeleted   = 0;
$filesDeleted    = 0;
$laDeleted       = 0;
$taDeleted       = 0;
$flDeleted       = 0;
$accessDeleted   = 0;
$passwordResetDeleted = 0;
$deletionTokenDeleted = 0;
$accountAuditDeleted = 0;
$adminAuditDeleted = 0;
$fallbackAccessDeleted = 0;
$fallbackDeletionDeleted = 0;
$cspReportDeleted = 0;
$cspRateLimitDeleted = 0;

/**
 * Vyčistí riadky staršie než cutoff z tab-delimited fallback logu.
 * Prvých 19 znakov každého riadka musí byť dátum Y-m-d H:i:s.
 */
function cleanupTimestampedLogFile(
    string $path,
    int $cutoffTimestamp,
    array &$errors,
    bool $stripAccessLogQueries = false
): int
{
    if (!is_file($path)) {
        return 0;
    }

    $handle = @fopen($path, 'c+');
    if ($handle === false) {
        $errors[] = "Nepodarilo sa otvoriť log: {$path}";
        return 0;
    }

    $deleted = 0;
    try {
        if (!flock($handle, LOCK_EX)) {
            $errors[] = "Nepodarilo sa zamknúť log: {$path}";
            return 0;
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        $lines = $contents === false || $contents === ''
            ? []
            : preg_split('/(?<=\n)/', $contents, -1, PREG_SPLIT_NO_EMPTY);
        $kept = [];

        foreach ($lines ?: [] as $line) {
            $timestamp = strtotime(substr($line, 0, 19));
            if ($timestamp !== false && $timestamp < $cutoffTimestamp) {
                $deleted++;
                continue;
            }
            if ($stripAccessLogQueries) {
                $lineEnding = str_ends_with($line, "\r\n") ? "\r\n" : (str_ends_with($line, "\n") ? "\n" : '');
                $fields = explode("\t", rtrim($line, "\r\n"));
                if (count($fields) >= 9) {
                    $fields[3] = explode('?', $fields[3], 2)[0];
                    $fields[4] = '';
                    $fields[8] = explode('?', $fields[8], 2)[0];
                    $line = implode("\t", $fields) . $lineEnding;
                }
            }
            $kept[] = $line;
        }

        rewind($handle);
        if (!ftruncate($handle, 0) || fwrite($handle, implode('', $kept)) === false) {
            $errors[] = "Nepodarilo sa prepísať log: {$path}";
        }
        fflush($handle);
        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }

    return $deleted;
}

try {
    // 1. Zmaž staré záznamy z histórie profilov
    $stmt = $pdo->prepare("DELETE FROM users_profile_archive WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY)");
    $stmt->execute(['days' => $profileRetentionDays]);
    $profileDeleted = $stmt->rowCount();

    // 2. Zmaž archívne súbory avatarov a záznamy z DB
    $avatarBase = realpath(__DIR__ . '/uploads/avatars');
    if ($avatarBase === false) {
        $errors[] = "Upozornenie: adresár uploads/avatars nebol nájdený, súbory sa nezmažú.";
        $avatarBase = null;
    }
    $avatarBasePrefix = $avatarBase !== null
        ? rtrim($avatarBase, '/\\') . DIRECTORY_SEPARATOR
        : null;

    $fetchStmt = $pdo->prepare(
        "SELECT id, archived_path FROM users_avatar_archive
         WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY)
           AND archived_path IS NOT NULL"
    );
    $fetchStmt->execute(['days' => $avatarRetentionDays]);
    $avatarRows = $fetchStmt->fetchAll();

    foreach ($avatarRows as $row) {
        if (!empty($row['archived_path']) && $avatarBase !== null) {
            $absPath = realpath(__DIR__ . '/' . ltrim((string) $row['archived_path'], '/\\'));
            if ($absPath !== false
                && $avatarBasePrefix !== null
                && str_starts_with($absPath, $avatarBasePrefix)
                && is_file($absPath)
            ) {
                if (@unlink($absPath)) {
                    $filesDeleted++;
                } else {
                    $errors[] = "Nepodarilo sa zmazať súbor: {$absPath}";
                }
            }
        }
    }

    $delStmt = $pdo->prepare("DELETE FROM users_avatar_archive WHERE changed_at < DATE_SUB(NOW(), INTERVAL :days DAY)");
    $delStmt->execute(['days' => $avatarRetentionDays]);
    $avatarDeleted = $delStmt->rowCount();

    // 3. Vyčisti staré bezpečnostné a auditné záznamy
    $laStmt = $pdo->prepare(
        "DELETE FROM login_attempts WHERE last_attempt < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $laStmt->execute(['days' => $accessLogRetentionDays]);
    $laDeleted = $laStmt->rowCount();

    $taStmt = $pdo->prepare(
        "DELETE FROM totp_attempts WHERE last_attempt < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $taStmt->execute(['days' => $accessLogRetentionDays]);
    $taDeleted = $taStmt->rowCount();

    $flStmt = $pdo->prepare(
        "DELETE FROM form_rate_limit WHERE last_attempt IS NOT NULL AND last_attempt < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $flStmt->execute(['days' => $accessLogRetentionDays]);
    $flDeleted = $flStmt->rowCount();

    $alStmt = $pdo->prepare(
        "DELETE FROM access_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $alStmt->execute(['days' => $accessLogRetentionDays]);
    $accessDeleted = $alStmt->rowCount();

    $prStmt = $pdo->prepare(
        "DELETE FROM password_resets
         WHERE expires_at < NOW()
            OR (used_at IS NOT NULL AND used_at < DATE_SUB(NOW(), INTERVAL :days DAY))"
    );
    $prStmt->execute(['days' => $accessLogRetentionDays]);
    $passwordResetDeleted = $prStmt->rowCount();

    $dtStmt = $pdo->prepare("DELETE FROM account_deletion_tokens WHERE expires_at < NOW()");
    $dtStmt->execute();
    $deletionTokenDeleted = $dtStmt->rowCount();

    $aaStmt = $pdo->prepare(
        "DELETE FROM account_deletion_log WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $aaStmt->execute(['days' => $accessLogRetentionDays]);
    $accountAuditDeleted = $aaStmt->rowCount();

    $adminStmt = $pdo->prepare(
        "DELETE FROM admin_users_notice_audit WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)"
    );
    $adminStmt->execute(['days' => $accessLogRetentionDays]);
    $adminAuditDeleted = $adminStmt->rowCount();

} catch (\PDOException $e) {
    $errors[] = "Databázová chyba: " . $e->getMessage();
}

$fallbackCutoff = strtotime("-{$accessLogRetentionDays} days");
$fallbackAccessDeleted = cleanupTimestampedLogFile(
    __DIR__ . '/private/logs/access.log',
    $fallbackCutoff,
    $errors,
    true
);
$fallbackDeletionDeleted = cleanupTimestampedLogFile(
    __DIR__ . '/private/logs/account_deletions.log',
    $fallbackCutoff,
    $errors
);
$cspReportDeleted += cleanupTimestampedLogFile(
    __DIR__ . '/private/logs/csp-violations.log',
    $fallbackCutoff,
    $errors
);
$cspReportDeleted += cleanupTimestampedLogFile(
    __DIR__ . '/private/logs/csp-violations.log.old',
    $fallbackCutoff,
    $errors
);

// CSP rate-limit súbory obsahujú iba počítadlo a čas okna, názov je však
// pseudonym odvodený z IP. Po dvoch dňoch už nemajú prevádzkový účel.
$cspRateLimitCutoff = time() - 2 * 86400;
foreach (['nefro_csp_rl_*.json', 'csp_rl_*.json'] as $pattern) {
    foreach (glob(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $pattern) ?: [] as $rateLimitFile) {
        if (is_file($rateLimitFile)
            && filemtime($rateLimitFile) < $cspRateLimitCutoff
            && @unlink($rateLimitFile)
        ) {
            $cspRateLimitDeleted++;
        }
    }
}

echo "Výsledky:\n";
echo "  Zmaz. záznamy z histórie profilov:  {$profileDeleted}\n";
echo "  Zmaz. záznamy z histórie avatarov:  {$avatarDeleted}\n";
echo "  Zmazané archívne súbory:            {$filesDeleted}\n";
echo "  Vyčistené login rate-limit záznamy: {$laDeleted}\n";
echo "  Vyčistené 2FA rate-limit záznamy:   {$taDeleted}\n";
echo "  Vyčistené staré rate-limit záznamy: {$flDeleted}\n";
echo "  Vyčistené staré access logy:        {$accessDeleted}\n";
echo "  Vyčistené password reset tokeny:    {$passwordResetDeleted}\n";
echo "  Vyčistené account deletion tokeny:  {$deletionTokenDeleted}\n";
echo "  Vyčistené account deletion audity:  {$accountAuditDeleted}\n";
echo "  Vyčistené admin export audity:      {$adminAuditDeleted}\n";
echo "  Vyčistené fallback access logy:     {$fallbackAccessDeleted}\n";
echo "  Vyčistené fallback deletion logy:   {$fallbackDeletionDeleted}\n";
echo "  Vyčistené CSP reporty:              {$cspReportDeleted}\n";
echo "  Vyčistené CSP rate-limit súbory:    {$cspRateLimitDeleted}\n";

if (!empty($errors)) {
    echo "\nUpozornenia:\n";
    foreach ($errors as $err) {
        echo "  - {$err}\n";
    }
    exit(1);
}

echo "\nDokončené.\n";
exit(0);
