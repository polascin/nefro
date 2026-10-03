<?php

declare(strict_types=1);

/*
 * botguard_unban.php — správa dočasných banov z bot_guard.php (len CLI).
 *
 * Bot guard ukladá stav limitera do private/cache/botguard/<sha256>.json,
 * kde názov súboru je hash IP (IP sa nikam neukladá v čitateľnej podobe).
 * Ban preto nie je možné zrušiť „ručne" bez prepočtu hashu — na to je tento
 * nástroj. Používa priamo funkcie z bot_guard.php, takže ostáva v zhode
 * s produkčnou logikou aj po jej zmene.
 *
 * Použitie (na serveri, z koreňa projektu):
 *   php tools/botguard_unban.php --list                 prehľad aktívnych banov
 *   php tools/botguard_unban.php --ip=138.199.34.196    zruší ban pre jednu IP
 *   php tools/botguard_unban.php --ip=1.2.3.4 --keep-counters
 *                                                       zruší len ban, počítadlá
 *                                                       okien ponechá
 *   php tools/botguard_unban.php --all                  zruší všetky aktívne bany
 *
 * Typický dôvod použitia: vlastný nástroj (napr. generátor e-booku) prekročí
 * burst limit 600 požiadaviek / 15 minút a zabanuje celú odchádzajúcu IP —
 * teda aj prehliadač autora, ktorý ide z tej istej adresy.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../bot_guard.php';

$options = getopt('', ['list', 'ip:', 'all', 'keep-counters', 'help']) ?: [];

if (isset($options['help']) || $options === []) {
    echo "Správa banov bot_guard.php\n\n"
        . "  --list                prehľad aktívnych banov\n"
        . "  --ip=<adresa>         zruší ban pre danú IP\n"
        . "  --all                 zruší všetky aktívne bany\n"
        . "  --keep-counters       ponechá počítadlá okien (zruší len samotný ban)\n";
    exit(0);
}

$now = time();
$keepCounters = isset($options['keep-counters']);

/**
 * Vráti cesty k súborom stavu, ktoré majú aktívny ban.
 *
 * @return array<string, array<string, mixed>> cesta => dekódovaný stav
 */
function botguardActiveBans(int $now): array
{
    $files = @glob(botGuardStateDir() . '/*.json');
    if (!is_array($files)) {
        return [];
    }

    $active = [];
    foreach ($files as $file) {
        $raw = @file_get_contents($file);
        if ($raw === false || $raw === '') {
            continue;
        }
        $state = json_decode($raw, true);
        if (!is_array($state)) {
            continue;
        }
        if ((int) ($state['banned_until'] ?? 0) > $now) {
            $active[$file] = $state;
        }
    }

    return $active;
}

/** Odstráni ban (a voliteľne aj počítadlá) zo súboru stavu. */
function botguardClearFile(string $file, bool $keepCounters): bool
{
    if ($keepCounters) {
        $raw = @file_get_contents($file);
        $state = $raw !== false && $raw !== '' ? json_decode($raw, true) : [];
        if (!is_array($state)) {
            $state = [];
        }
        unset($state['banned_until']);

        return @file_put_contents(
            $file,
            json_encode($state, JSON_UNESCAPED_SLASHES),
            LOCK_EX,
        ) !== false;
    }

    // Zmazanie celého súboru = ban aj počítadlá okien idú na nulu. Bot guard si
    // súbor pri najbližšej požiadavke vytvorí znova s čistým stavom.
    return @unlink($file);
}

// ── --list ──────────────────────────────────────────────────────────────────
if (isset($options['list'])) {
    $active = botguardActiveBans($now);
    if ($active === []) {
        echo "Žiadne aktívne bany.\n";
        exit(0);
    }

    echo 'Aktívne bany (' . count($active) . "):\n";
    foreach ($active as $file => $state) {
        $left = (int) $state['banned_until'] - $now;
        printf(
            "  %s  zostáva %4d s (do %s)  hits=%s\n",
            basename($file, '.json'),
            $left,
            date('H:i:s', (int) $state['banned_until']),
            (string) ($state['b_count'] ?? '?'),
        );
    }
    echo "\nIP v názve súboru nie je — je to jej hash. Konkrétnu IP zruš cez --ip=<adresa>.\n";
    exit(0);
}

// ── --ip=<adresa> ───────────────────────────────────────────────────────────
if (isset($options['ip'])) {
    $ip = is_string($options['ip']) ? trim($options['ip']) : '';
    if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
        fwrite(STDERR, "Neplatná IP adresa: " . $ip . "\n");
        exit(1);
    }

    $path = botGuardStatePath($ip);
    if (!is_file($path)) {
        echo 'Pre ' . $ip . " neexistuje žiadny stav limitera (nič na zrušenie).\n";
        exit(0);
    }

    $raw = (string) @file_get_contents($path);
    $state = json_decode($raw, true);
    $bannedUntil = is_array($state) ? (int) ($state['banned_until'] ?? 0) : 0;

    if (!botguardClearFile($path, $keepCounters)) {
        fwrite(STDERR, "Stav sa nepodarilo prepísať: " . $path . "\n");
        exit(1);
    }

    if ($bannedUntil > $now) {
        echo 'Ban pre ' . $ip . ' zrušený (zostávalo ' . ($bannedUntil - $now) . " s).\n";
    } else {
        echo 'Stav pre ' . $ip . " vyčistený (aktívny ban tam nebol).\n";
    }
    exit(0);
}

// ── --all ───────────────────────────────────────────────────────────────────
if (isset($options['all'])) {
    $active = botguardActiveBans($now);
    if ($active === []) {
        echo "Žiadne aktívne bany.\n";
        exit(0);
    }

    $cleared = 0;
    foreach (array_keys($active) as $file) {
        if (botguardClearFile($file, $keepCounters)) {
            $cleared++;
        }
    }
    echo 'Zrušených banov: ' . $cleared . ' z ' . count($active) . ".\n";
    exit(0);
}
