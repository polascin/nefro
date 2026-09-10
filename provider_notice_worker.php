<?php

declare(strict_types=1);
/**
 * provider_notice_worker.php  (CLI / cron)
 *
 * Informovanie poskytovateľov podľa čl. 14 GDPR — pozri `provider_notices.php`.
 *
 * Pri každom behu:
 *   1. označí záznamy bez e-mailu ako informované verejne (čl. 14 ods. 5 písm. b),
 *   2. zaradí do fronty aktívne záznamy s e-mailom, ktoré ešte informované neboli,
 *   3. frontu spracuje — ale IBA ak je uvedený prepínač `--send`.
 *
 * ODOSIELANIE JE ZÁMERNE VYPNUTÉ. Bez `--send` beží worker nasucho a len vypíše,
 * čo by odoslal. Ide o e-maily reálnym zdravotníckym zariadeniam, ktoré sa nedajú
 * vziať späť; predvolené správanie preto nesmie byť „odošli“. Odoslanie je vedomé
 * rozhodnutie prevádzkovateľa, nie vedľajší účinok spustenia skriptu alebo cronu.
 *
 * Použitie:
 *   php provider_notice_worker.php                  # nasucho — vypíše, čo by sa stalo
 *   php provider_notice_worker.php --status         # len prehľad stavu
 *   php provider_notice_worker.php --send --only=a@b.sk  # jediná konkrétna adresa
 *   php provider_notice_worker.php --send --limit=5      # skutočné odoslanie, prvých 5
 *   php provider_notice_worker.php --send                # skutočné odoslanie, dávka 25
 *
 * Odporúčaný postup: najprv `--status`, potom beh nasucho, potom `--send --only=`
 * na vlastnú adresu, a až potom celá dávka. `--only` je dôležité: bez neho by
 * `--limit=1` poslal tomu, kto je vo fronte prvý, nie tomu, koho si vyberieš.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Prístup odmietnutý.');
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/provider_notices.php';

$limit       = 25;
$maxAttempts = 5;
$send        = false;
$statusOnly  = false;
$enqueueOnly = false;
$only        = '';

$arguments = isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : [];
foreach ($arguments as $arg) {
    if (preg_match('/^--limit=(\d+)$/', (string) $arg, $m)) {
        $limit = (int) $m[1];
    } elseif (preg_match('/^--max-attempts=(\d+)$/', (string) $arg, $m)) {
        $maxAttempts = (int) $m[1];
    } elseif ($arg === '--send') {
        $send = true;
    } elseif ($arg === '--status') {
        $statusOnly = true;
    } elseif ($arg === '--enqueue-only') {
        $enqueueOnly = true;
    } elseif (preg_match('/^--only=(.+)$/', (string) $arg, $m)) {
        $only = trim($m[1]);
    }
}

if ($only !== '' && filter_var($only, FILTER_VALIDATE_EMAIL) === false) {
    fwrite(STDERR, "Neplatná adresa v --only: {$only}\n");
    exit(2);
}

// Horná hranica dávky je nízka zámerne. Pri 35 schránkach nie je dôvod posielať
// všetko naraz a menšia dávka dáva šancu zachytiť problém po prvých kusoch.
$limit       = max(1, min(100, $limit));
$maxAttempts = max(1, min(20, $maxAttempts));

/**
 * @param array<string,int> $summary
 */
$printSummary = static function (array $summary, PDO $pdo): void {
    $labels = [
        'neinformovany' => 'neinformovaný',
        'odoslany'      => 'oznámenie odoslané',
        'verejne'       => 'informovaný verejne (čl. 14 ods. 5 písm. b)',
        'zlyhal'        => 'odoslanie zlyhalo',
        'namietka'      => 'namietol',
    ];
    echo "Stav adresára:\n";
    $total = 0;
    foreach ($summary as $status => $count) {
        $total += $count;
        printf("  %-46s %3d\n", $labels[$status] ?? $status, $count);
    }
    printf("  %-46s %3d\n", '── spolu aktívnych', $total);

    $pending = (int) $pdo->query(
        "SELECT COUNT(*) FROM provider_notice_queue
          WHERE notice_version = " . $pdo->quote(PROVIDER_NOTICE_VERSION) . " AND status = 'pending'"
    )->fetchColumn();
    $sent = (int) $pdo->query(
        "SELECT COUNT(*) FROM provider_notice_queue
          WHERE notice_version = " . $pdo->quote(PROVIDER_NOTICE_VERSION) . " AND status = 'sent'"
    )->fetchColumn();
    echo "Fronta (verzia " . PROVIDER_NOTICE_VERSION . "): čaká {$pending}, odoslaných {$sent}\n";
};

$lockAcquired = false;
$exitCode     = 0;

try {
    if ($statusOnly) {
        $printSummary(providerNoticeSummary($pdo), $pdo);
        exit(0);
    }

    $lockAcquired = acquireNewsletterProcessLock($pdo, 'provider_notice_worker');
    if (!$lockAcquired) {
        echo "Worker už beží v inom procese; tento beh sa preskočil.\n";
        exit(0);
    }

    $public = markProvidersInformedPublicly($pdo);
    if ($public > 0) {
        echo "Bez e-mailu — informované verejne podľa čl. 14 ods. 5 písm. b): {$public}\n";
    }

    $enq = enqueueProviderNotices($pdo);
    echo "Kandidáti: {$enq['candidates']}, novo zaradených do fronty: {$enq['enqueued']}";
    if ($enq['suppressed'] > 0) {
        echo ", preskočených po námietke: {$enq['suppressed']}";
    }
    echo "\n";

    if ($enqueueOnly) {
        $printSummary(providerNoticeSummary($pdo), $pdo);
        exit(0);
    }

    if ($only !== '') {
        echo "Obmedzené na jedinú adresu: {$only}\n";
    }
    if (!$send) {
        echo "\n--- BEH NASUCHO (bez --send sa nič neodosiela) ---\n";
    }

    $stats = processProviderNoticeQueue($pdo, $limit, $maxAttempts, !$send, $only);

    if ($only !== '' && $stats['selected'] === 0) {
        echo "Pre túto adresu nie je vo fronte nič čakajúce "
            . "(už odoslané, alebo nie je medzi kandidátmi).\n";
    }

    echo "\nVybraných z fronty: {$stats['selected']}";
    if ($send) {
        echo ", odoslaných: {$stats['sent']}, zlyhalo: {$stats['failed']}\n";
    } else {
        echo " (nasucho, neodoslané: {$stats['skipped']})\n";
        echo "Na skutočné odoslanie spusti s prepínačom --send.\n";
    }

    $printSummary(providerNoticeSummary($pdo), $pdo);
} catch (Throwable $e) {
    fwrite(STDERR, 'Chyba: ' . $e->getMessage() . PHP_EOL);
    $exitCode = 1;
} finally {
    if ($lockAcquired) {
        releaseNewsletterProcessLock($pdo, 'provider_notice_worker');
    }
}

exit($exitCode);
