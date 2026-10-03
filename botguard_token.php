<?php

declare(strict_types=1);
/**
 * botguard_token.php — vydávanie podpísaných tokenov pre vlastné nástroje
 * ────────────────────────────────────────────────────────────────────────────
 * Len CLI (php_sapi_name guard + .htaccess deny).
 *
 * Rate-limiting bez autentizácie považuje vlastný dávkový nástroj a scraper za
 * štatisticky identických — oboje je „veľa požiadaviek z jednej IP". Riešením
 * nie sú voľnejšie pravidlá (tie oslabia ochranu pre všetkých), ale token,
 * ktorým nástroj vopred preukáže vlastníctvo. Potom limiter nemusí hádať.
 *
 * Token NIE JE prístupové oprávnenie: neodomyká žiadny obsah, dáta ani admin.
 * Jediný efekt je v `bot_guard.php` — vlastný tier limitov, vlastný účtovací
 * priestor (nemieša sa s ľudskou prevádzkou z tej istej IP) a žiadny ban.
 *
 * Spustenie (na serveri alebo lokálne — kľúč musí byť ten istý):
 *   php botguard_token.php --tool=ebook-builder              # platnosť 24 h
 *   php botguard_token.php --tool=ebook-builder --ttl=7d     # maximum
 *   php botguard_token.php --tool=ebook-builder --curl       # hotový príklad
 *   php botguard_token.php --verify=nefro1.ebook-builder...  # kontrola tokenu
 *
 * Klient potom pri každej požiadavke pošle hlavičku:
 *   X-Nefro-Trust: <token>
 *
 * Kľúč: `BOT_GUARD_TRUST_KEY` z private/nefro.env.ini (ak nie je nastavený,
 * odvodí sa HKDF-om z kľúča na ochranu údajov — vtedy nie je čo nastavovať,
 * ale pri rotácii kľúča na ochranu údajov prestanú platiť aj tokeny).
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

require_once __DIR__ . '/config_loader.php';
require_once __DIR__ . '/bot_guard.php';

$options = getopt('', ['tool:', 'ttl:', 'curl', 'verify:', 'help']) ?: [];

if (isset($options['help']) || $options === []) {
    echo "Vydávanie tokenov pre vlastné nástroje (bot_guard)\n\n"
        . "  --tool=<názov>     názov nástroja, 1 – 32 znakov z [a-z0-9-]\n"
        . "  --ttl=<čas>        platnosť: 3600, 90m, 24h, 7d (predvolene 24h, max 7d)\n"
        . "  --curl             vypíše hotový príklad použitia v curl\n"
        . "  --verify=<token>   overí existujúci token a vypíše zostávajúcu platnosť\n\n"
        . "Hlavička, ktorú klient posiela:  X-Nefro-Trust: <token>\n";
    exit(0);
}

/** Prevedie „90m" / „24h" / „7d" / „3600" na sekundy. */
function botguardParseTtl(string $raw): ?int
{
    $raw = strtolower(trim($raw));
    if (preg_match('/^(\d+)\s*([smhd]?)$/', $raw, $m) !== 1) {
        return null;
    }

    $value = (int) $m[1];
    $multiplier = match ($m[2]) {
        'm' => 60,
        'h' => 3600,
        'd' => 86400,
        default => 1,
    };

    return $value * $multiplier;
}

/** Čitateľné trvanie v slovenčine (bez skloňovania — prehľad, nie veta). */
function botguardHumanDuration(int $seconds): string
{
    if ($seconds >= 86400) {
        return round($seconds / 86400, 1) . ' d';
    }
    if ($seconds >= 3600) {
        return round($seconds / 3600, 1) . ' h';
    }
    if ($seconds >= 60) {
        return round($seconds / 60) . ' min';
    }

    return $seconds . ' s';
}

// ── --verify=<token> ────────────────────────────────────────────────────────
if (isset($options['verify'])) {
    $token = is_string($options['verify']) ? trim($options['verify']) : '';
    $reason = null;
    $tool = botGuardVerifyTrustToken($token, $reason);

    if ($tool === null) {
        fwrite(STDERR, 'Token NEPLATNÝ: ' . (string) $reason . "\n");
        exit(1);
    }

    $parts = explode('.', $token);
    $expiresAt = (int) ($parts[3] ?? 0);
    echo 'Token platný — nástroj: ' . $tool . "\n"
        . 'Platnosť do:            ' . date('d.m.Y H:i:s', $expiresAt)
        . ' (zostáva ' . botguardHumanDuration($expiresAt - time()) . ")\n";
    exit(0);
}

// ── --tool=<názov> ──────────────────────────────────────────────────────────
$tool = isset($options['tool']) && is_string($options['tool']) ? trim($options['tool']) : '';
if ($tool === '') {
    fwrite(STDERR, "Chýba --tool=<názov>. Nápoveda: --help\n");
    exit(1);
}

$ttlRaw = isset($options['ttl']) && is_string($options['ttl']) ? $options['ttl'] : '24h';
$ttl = botguardParseTtl($ttlRaw);
if ($ttl === null || $ttl < 60) {
    fwrite(STDERR, "Neplatná platnosť: " . $ttlRaw . " (použi napr. 3600, 90m, 24h, 7d)\n");
    exit(1);
}
if ($ttl > BOT_GUARD_TRUST_MAX_TTL) {
    fwrite(
        STDERR,
        'Platnosť presahuje maximum ' . botguardHumanDuration(BOT_GUARD_TRUST_MAX_TTL)
        . " — skrátená na maximum.\n",
    );
    $ttl = BOT_GUARD_TRUST_MAX_TTL;
}

try {
    $token = botGuardMakeTrustToken($tool, $ttl);
} catch (\RuntimeException $e) {
    fwrite(STDERR, 'Token sa nepodarilo vydať: ' . $e->getMessage() . "\n");
    exit(1);
}

$expiresAt = time() + $ttl;

echo $token . "\n";
fwrite(
    STDERR,
    "\nNástroj:     " . $tool . "\n"
    . 'Platnosť do: ' . date('d.m.Y H:i:s', $expiresAt)
    . ' (' . botguardHumanDuration($ttl) . ")\n"
    . "Hlavička:    X-Nefro-Trust: <token>\n",
);

if (isset($options['curl'])) {
    fwrite(
        STDERR,
        "\nPríklad:\n"
        . '  curl -H "X-Nefro-Trust: ' . $token . "\" \\\n"
        . "       -A \"" . $tool . "/1.0\" \\\n"
        . "       https://nefro.polascin.net/article.php?slug=…\n",
    );
}

exit(0);
