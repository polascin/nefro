<?php

declare(strict_types=1);
/**
 * legal_notice_worker.php  (CLI / cron)
 *
 * Pri každom behu:
 *   1. zistí aktuálnu verziu právnych dokumentov (legalInfo()['version']),
 *   2. ak pre ňu ešte nebolo odoslané upozornenie (legal_notice_runs), zaradí ho
 *      do fronty pre VŠETKÝCH členov aj odberateľov (idempotentne),
 *   3. spracuje frontu a odošle e-maily (dávkovo, s retry/backoff).
 *
 * Idempotentné: opakované behy pre tú istú verziu nezaradia duplikáty.
 * Bezpečné voči súbehu cez GET_LOCK (rovnaký mechanizmus ako newsletter_worker).
 *
 * Použitie:
 *   php legal_notice_worker.php [--limit=50] [--max-attempts=5] [--enqueue-only] [--no-enqueue]
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/legal_notifications.php';

$limit = 50;
$maxAttempts = 5;
$enqueueOnly = false;
$noEnqueue = false;

$arguments = isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : [];
foreach ($arguments as $arg) {
    if (preg_match('/^--limit=(\d+)$/', (string) $arg, $m)) {
        $limit = (int) $m[1];
    } elseif (preg_match('/^--max-attempts=(\d+)$/', (string) $arg, $m)) {
        $maxAttempts = (int) $m[1];
    } elseif ($arg === '--enqueue-only') {
        $enqueueOnly = true;
    } elseif ($arg === '--no-enqueue') {
        $noEnqueue = true;
    }
}

$limit = max(1, min(500, $limit));
$maxAttempts = max(1, min(20, $maxAttempts));

$lockAcquired = false;
$exitCode = 0;

try {
    $lockAcquired = acquireNewsletterProcessLock($pdo, 'legal_notice_worker');
    if (!$lockAcquired) {
        echo "Legal notice worker už spracúva iný proces; tento beh sa preskočil.\n";
        exit(0);
    }

    $info = legalNoticeCurrentVersionInfo();
    if ($info['version'] === '') {
        fwrite(STDERR, "legalInfo()['version'] je prázdne — nemám čo oznámiť.\n");
        exit(1);
    }

    if (!$noEnqueue) {
        $enq = enqueueLegalChangeNotice($pdo, $info['version'], $info['effectiveDate'], $info['updates']);
        if ($enq['already']) {
            echo "Verzia {$info['version']} už bola zaradená skôr — nové zaradenie sa nevykonalo.\n";
        } else {
            echo "Verzia {$info['version']} zaradená: členovia {$enq['users']}, odberatelia {$enq['subscribers']}.\n";
        }
    }

    if ($enqueueOnly) {
        echo "Režim --enqueue-only: odosielanie preskočené.\n";
    } else {
        $userStats = processLegalNoticeQueue($pdo, $limit, $maxAttempts);
        $subStats  = processLegalNoticeSubQueue($pdo, $limit, $maxAttempts);

        echo "Legal notice worker dokončený.\n";
        echo "\n-- Registrovaní členovia --\n";
        echo "Vybrané z fronty: " . (int) $userStats['selected'] . "\n";
        echo "Odoslané e-maily: " . (int) $userStats['sent'] . "\n";
        echo "Zlyhané pokusy: " . (int) $userStats['failed'] . "\n";
        echo "Zrušené položky: " . (int) $userStats['cancelled'] . "\n";
        echo "Preskočené položky: " . (int) $userStats['skipped'] . "\n";
        echo "\n-- Anonymní odberatelia --\n";
        echo "Vybrané z fronty: " . (int) $subStats['selected'] . "\n";
        echo "Odoslané e-maily: " . (int) $subStats['sent'] . "\n";
        echo "Zlyhané pokusy: " . (int) $subStats['failed'] . "\n";
        echo "Zrušené položky: " . (int) $subStats['cancelled'] . "\n";
        echo "Preskočené položky: " . (int) $subStats['skipped'] . "\n";
    }
} catch (Throwable $e) {
    error_log('legal_notice_worker error: ' . $e->getMessage());
    fwrite(STDERR, "Legal notice worker zlyhal: " . $e->getMessage() . "\n");
    $exitCode = 1;
} finally {
    if ($lockAcquired) {
        releaseNewsletterProcessLock($pdo, 'legal_notice_worker');
    }
}

exit($exitCode);
