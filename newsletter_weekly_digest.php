<?php
declare(strict_types=1);

/**
 * newsletter_weekly_digest.php
 * ════════════════════════════════════════════════════════════════════════════
 * Pošle týždenný prehľad (digest) nových článkov všetkým overeným príjemcom
 * (registrovaní používatelia so súhlasom + anonymní odberatelia). Posiela jeden
 * súhrnný e-mail za okno od konca posledného behu (predvolene posledných 7 dní).
 *
 * Spúšťa sa cez CRON, typicky raz týždenne, napr. v pondelok o 08:00:
 *   0 8 * * 1  php /cesta/k/nefro/newsletter_weekly_digest.php
 *
 * Voľby:
 *   --days=N      veľkosť okna v dňoch pri prvom behu (predvolené 7)
 *   --force       ignoruj posledný beh a použi okno posledných N dní
 *   --dry-run     nič neodošli ani nezaznamenaj, len vypíš, čo by sa stalo
 * ════════════════════════════════════════════════════════════════════════════
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$opts = ['days' => 7, 'dry_run' => false, 'ignore_last_run' => false];

foreach ($argv as $arg) {
    if (preg_match('/^--days=(\d+)$/', (string) $arg, $m)) {
        $opts['days'] = (int) $m[1];
    } elseif ($arg === '--dry-run') {
        $opts['dry_run'] = true;
    } elseif ($arg === '--force') {
        $opts['ignore_last_run'] = true;
    }
}

try {
    $r = sendWeeklyNewsletterDigest($pdo, $opts);

    echo "Týždenný prehľad – " . ($r['dry_run'] ? "SKÚŠOBNÝ BEH (nič sa neodoslalo)" : "dokončené") . ".\n";
    echo "Okno: " . $r['window_start'] . "  →  " . $r['window_end'] . "\n";

    if (!empty($r['skipped_empty'])) {
        echo "Za toto obdobie nepribudli žiadne nové články — prehľad sa neposlal.\n";
        exit(0);
    }

    echo "Nových článkov v prehľade: " . (int) $r['articles'] . "\n";
    echo "Odoslané registrovaným:    " . (int) $r['users_sent'] . "\n";
    echo "Odoslané odberateľom:      " . (int) $r['subscribers_sent'] . "\n";
    echo "Zlyhané odoslania:         " . (int) $r['failed'] . "\n";
} catch (Throwable $e) {
    error_log('newsletter_weekly_digest error: ' . $e->getMessage());
    fwrite(STDERR, "Týždenný prehľad zlyhal: " . $e->getMessage() . "\n");
    exit(1);
}
