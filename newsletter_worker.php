<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$limit = 50;
$maxAttempts = 5;

foreach ($argv as $arg) {
    if (preg_match('/^--limit=(\d+)$/', (string) $arg, $m)) {
        $limit = (int) $m[1];
    }
    if (preg_match('/^--max-attempts=(\d+)$/', (string) $arg, $m)) {
        $maxAttempts = (int) $m[1];
    }
}

$limit = max(1, min(500, $limit));
$maxAttempts = max(1, min(20, $maxAttempts));

$lockAcquired = false;
$exitCode = 0;

try {
    $lockAcquired = acquireNewsletterProcessLock($pdo, 'newsletter_worker');
    if (!$lockAcquired) {
        echo "Newsletter worker už spracúva iný proces; tento beh sa preskočil.\n";
    } else {
        $stats = processArticleNewsletterQueue($pdo, $limit, $maxAttempts);
        $subStats = processNlSubQueue($pdo, $limit, $maxAttempts);

        echo "Newsletter worker dokončený.\n";
        echo "\n-- Registrovaní používatelia --\n";
        echo "Vybrané z fronty: " . (int) ($stats['selected'] ?? 0) . "\n";
        echo "Odoslané e-maily: " . (int) ($stats['sent'] ?? 0) . "\n";
        echo "Zlyhané pokusy: " . (int) ($stats['failed'] ?? 0) . "\n";
        echo "Zrušené položky: " . (int) ($stats['cancelled'] ?? 0) . "\n";
        echo "Preskočené položky: " . (int) ($stats['skipped'] ?? 0) . "\n";
        echo "\n-- Anonymní odberatelia --\n";
        echo "Vybrané z fronty: " . (int) ($subStats['selected'] ?? 0) . "\n";
        echo "Odoslané e-maily: " . (int) ($subStats['sent'] ?? 0) . "\n";
        echo "Zlyhané pokusy: " . (int) ($subStats['failed'] ?? 0) . "\n";
        echo "Zrušené položky: " . (int) ($subStats['cancelled'] ?? 0) . "\n";
        echo "Preskočené položky: " . (int) ($subStats['skipped'] ?? 0) . "\n";
    }
} catch (Throwable $e) {
    error_log('newsletter_worker error: ' . $e->getMessage());
    fwrite(STDERR, "Newsletter worker zlyhal: " . $e->getMessage() . "\n");
    $exitCode = 1;
} finally {
    if ($lockAcquired) {
        releaseNewsletterProcessLock($pdo, 'newsletter_worker');
    }
}

exit($exitCode);
