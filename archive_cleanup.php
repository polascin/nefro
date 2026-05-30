<?php
declare(strict_types=1);
/**
 * archive_cleanup.php — CLI-only retenčný cleanup skript
 *
 * Použitie: php archive_cleanup.php [profile_days] [avatar_days]
 * Predvolená retenčná lehota: 365 dní pre oba archívy.
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

require_once __DIR__ . '/db_config.php';

echo "Nefro Archív Cleanup\n";
echo "====================\n";
echo "Dátum:                    " . date('Y-m-d H:i:s') . "\n";
echo "Retenčná lehota profilov: {$profileRetentionDays} dní\n";
echo "Retenčná lehota avatarov: {$avatarRetentionDays} dní\n\n";

$errors        = [];
$profileDeleted = 0;
$avatarDeleted  = 0;
$filesDeleted   = 0;
$laDeleted      = 0;

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
            if ($absPath !== false && str_starts_with($absPath, $avatarBase) && is_file($absPath)) {
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

    // 3. Vyčisti expirované IP bloky z login_attempts (staršie ako 1 deň po expiráii)
    $laStmt = $pdo->prepare(
        "DELETE FROM login_attempts WHERE blocked_until IS NOT NULL AND blocked_until < DATE_SUB(NOW(), INTERVAL 1 DAY)"
    );
    $laStmt->execute();
    $laDeleted = $laStmt->rowCount();

} catch (\PDOException $e) {
    $errors[] = "Databázová chyba: " . $e->getMessage();
}

echo "Výsledky:\n";
echo "  Zmaz. záznamy z histórie profilov:  {$profileDeleted}\n";
echo "  Zmaz. záznamy z histórie avatarov:  {$avatarDeleted}\n";
echo "  Zmazané archívne súbory:            {$filesDeleted}\n";
echo "  Vyčistené expirované IP záznamy:    {$laDeleted}\n";

if (!empty($errors)) {
    echo "\nUpozornenia:\n";
    foreach ($errors as $err) {
        echo "  - {$err}\n";
    }
    exit(1);
}

echo "\nDokončené.\n";
exit(0);
