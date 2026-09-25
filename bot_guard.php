<?php

declare(strict_types=1);
/**
 * bot_guard.php — ochrana obsahu pred scrapingom, botmi a crawlermi
 * ────────────────────────────────────────────────────────────────────────────
 * Vrstva 2 (aplikačná). Vrstva 1 je .htaccess (lacné blokovanie User-Agentov
 * ešte pred PHP), vrstva 0 je robots.txt (dobrovoľná deklarácia).
 *
 * Čo tento modul rieši:
 *   • tvrdé blokovanie menovaných scraperov a AI-tréningových crawlerov (403)
 *   • rate-limiting podľa IP so zostupnou toleranciou (429 + Retry-After)
 *   • dočasný ban pri hrubom prekročení (burst) alebo po spadnutí do honeypotu
 *   • overenie, že „Googlebot“ naozaj je Googlebot (forward-confirmed rDNS)
 *
 * Čo NErieši (a ani nemôže): dokonalé zabránenie stiahnutiu obsahu. Cieľ je
 * urobiť hromadný zber drahým a pomalým, nie nemožným. Obrázky majú navyše
 * zapečený vodoznak (tools/watermark_images.php).
 *
 * Stav sa drží v súboroch (private/cache/botguard/), aby limiter nezaťažoval
 * databázu — inak by sám bol zosilňovačom DoS.
 *
 * Modul sa aktivuje sám pri includovaní z web kontextu (na konci súboru).
 * Includuje ho auth.php, ktorý je prvým require prakticky každej stránky.
 */

// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF'] ?? '') === basename(__FILE__)) {
    header('HTTP/1.1 403 Forbidden');
    exit('Prístup odmietnutý.');
}

// ── Ladiace konštanty ───────────────────────────────────────────────────────
// Bežný čitateľ článku si otvorí niekoľko stránok za minútu; 90 je pohodlná
// rezerva aj pre rodinu či ambulanciu za jednou NAT adresou. Scraper ju
// prekročí okamžite.
const BOT_GUARD_WINDOW       = 60;      // sekundy — krátke okno
const BOT_GUARD_MAX          = 90;      // max požiadaviek v krátkom okne
const BOT_GUARD_MAX_TOOL     = 20;      // to isté pre curl/wget a spol.
const BOT_GUARD_MAX_SEARCH   = 300;     // overené vyhľadávače
const BOT_GUARD_BURST_WINDOW = 900;     // sekundy — dlhé okno (15 min)
const BOT_GUARD_BURST_MAX    = 600;     // max požiadaviek v dlhom okne
const BOT_GUARD_BAN_SECONDS  = 1800;    // ban po prekročení burst limitu
const BOT_GUARD_TRAP_BAN     = 3600;    // ban po spadnutí do honeypotu
const BOT_GUARD_RDNS_TTL     = 604800;  // 7 dní — cache overenia vyhľadávača
const BOT_GUARD_STATE_TTL    = 86400;   // po dni je súbor stavu na zmazanie

/**
 * Menovaní scraperi, SEO-harvestery a AI-tréningové crawlery → tvrdé 403.
 * Zámerne NEobsahuje curl/wget (používajú sa pri QA vlastného webu) ani
 * wkhtmltopdf (generuje PDF verzie článkov a sťahuje si obrázky).
 */
function botGuardDenyPattern(): string
{
    static $pattern = null;
    if ($pattern !== null) {
        return $pattern;
    }

    $deny = [
        // SEO / backlink harvestery — čistá záťaž bez návratnosti
        'semrushbot', 'ahrefsbot', 'ahrefssiteaudit', 'mj12bot', 'dotbot',
        'blexbot', 'petalbot', 'dataforseobot', 'barkrowler', 'seekportbot',
        'serpstatbot', 'zoominfobot', 'megaindex', 'linkpadbot', 'seokicks',
        'backlinkcrawler', 'siteauditbot', 'riddler', 'netestate',
        'magpie-crawler', 'mediatoolkitbot', 'trendictionbot', 'domainstatsbot',
        'sitecheckerbotcrawler', 'awariobot', 'onalyticabot',
        'velenpublicwebcrawler', 'surdotlybot', 'aihitbot', 'grapeshot',
        'admantx', 'linguee', 'screaming frog', 'sitebulb', 'seolyt',
        // AI tréningové crawlery (zber na učenie modelov, nie na odkazovanie)
        'gptbot', 'claudebot', 'claude-web', 'anthropic-ai', 'ccbot',
        'google-extended', 'bytespider', 'amazonbot', 'applebot-extended',
        'facebookbot', 'meta-externalagent', 'meta-externalfetcher',
        'diffbot', 'omgili', 'omgilibot', 'imagesiftbot', 'youbot',
        'timpibot', 'webzio', 'cohere-ai', 'cohere-training-data-crawler',
        'ai2bot', 'pangubot', 'kangaroo bot', 'icc-crawler', 'img2dataset',
        'iaskspider', 'firecrawl', 'bedrockbot',
        // Hromadné sťahovače a skenery
        'httrack', 'webcopier', 'webzip', 'offline explorer', 'teleport',
        'sitesnagger', 'xenu', 'nutch', 'scrapy', 'masscan', 'zgrab',
        'nuclei', 'sqlmap', 'nikto', 'wpscan', 'dirbuster', 'gobuster',
        'python-requests', 'python-urllib', 'aiohttp', 'httpx/', 'scrapfly',
        'zyte', 'apify',
        // Agresívne vyhľadávače bez prínosu pre slovenský web
        'sogou', 'yisouspider', 'sputnikbot', 'mail.ru_bot',
    ];

    $pattern = '~(' . implode('|', array_map(
        static fn (string $s): string => preg_quote($s, '~'),
        $deny
    )) . ')~i';

    return $pattern;
}

/**
 * Vyhľadávače a sociálne siete, ktoré chceme pustiť — web má byť nájditeľný.
 * Zahrnuté sú aj AI *vyhľadávacie* (citujúce) agenty; tie na rozdiel od
 * tréningových crawlerov posielajú návštevníkov späť.
 */
function botGuardSearchPattern(): string
{
    static $pattern = null;
    if ($pattern !== null) {
        return $pattern;
    }

    $allow = [
        'googlebot', 'google-inspectiontool', 'storebot-google', 'adsbot-google',
        'bingbot', 'bingpreview', 'msnbot', 'adidxbot',
        'duckduckbot', 'duckassistbot', 'yandexbot', 'yandeximages',
        'applebot', 'seznambot', 'qwantify', 'slurp', 'yeti',
        'facebookexternalhit', 'twitterbot', 'linkedinbot', 'pinterest',
        'whatsapp', 'telegrambot', 'discordbot', 'slackbot', 'redditbot',
        'mastodon', 'embedly', 'skypeuripreview', 'viber',
        'oai-searchbot', 'chatgpt-user', 'claude-user', 'claude-searchbot',
        'perplexitybot', 'perplexity-user',
    ];

    $pattern = '~(' . implode('|', array_map(
        static fn (string $s): string => preg_quote($s, '~'),
        $allow
    )) . ')~i';

    return $pattern;
}

/**
 * Nástroje z príkazového riadka a HTTP knižnice. Neblokujeme ich (vlastné QA
 * aj monitoring ich používa), ale dostávajú výrazne prísnejší limit.
 */
function botGuardToolPattern(): string
{
    return '~(curl/|wget|libwww-perl|lwp::|go-http-client|java/|okhttp|'
        . 'apache-httpclient|node-fetch|axios/|guzzle|ruby|powershell|'
        . 'winhttp|restsharp|postman|insomnia|headlesschrome|phantomjs)~i';
}

/**
 * Domény, ktorých rDNS potvrdzuje pravosť veľkých vyhľadávačov.
 *
 * @return array<string, list<string>>
 */
function botGuardVerifiableBots(): array
{
    return [
        'googlebot'       => ['.googlebot.com', '.google.com'],
        'adsbot-google'   => ['.googlebot.com', '.google.com'],
        'storebot-google' => ['.googlebot.com', '.google.com'],
        'bingbot'         => ['.search.msn.com'],
        'msnbot'          => ['.search.msn.com'],
        'yandexbot'       => ['.yandex.ru', '.yandex.net', '.yandex.com'],
        'applebot'        => ['.applebot.apple.com'],
        'seznambot'       => ['.seznam.cz'],
        'duckduckbot'     => ['.duckduckgo.com'],
    ];
}

/** Klientská IP adresa. Proxy hlavičkám zámerne nedôverujeme — dajú sa podvrhnúť. */
function botGuardClientIp(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
    return filter_var($ip, FILTER_VALIDATE_IP) !== false ? $ip : '0.0.0.0';
}

/** Skrátený User-Agent (chránime sa pred megabajtovou hlavičkou v logu). */
function botGuardUserAgent(): string
{
    $raw = (string) ($_SERVER['HTTP_USER_AGENT'] ?? '');
    return mb_substr(trim(str_replace(["\r", "\n", "\0"], ' ', $raw)), 0, 512);
}

/** Adresár so stavom limitera. */
function botGuardStateDir(): string
{
    static $dir = null;
    if ($dir !== null) {
        return $dir;
    }

    $dir = __DIR__ . '/private/cache/botguard';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }

    return $dir;
}

/** Cesta k súboru stavu pre danú IP (názov je hash — IP nie je v názve súboru). */
function botGuardStatePath(string $ip): string
{
    return botGuardStateDir() . '/' . hash('sha256', 'nefro-bg:' . $ip) . '.json';
}

/**
 * Atomicky prečíta, upraví a zapíše stav pre IP. Callback dostane pole stavu
 * a vracia upravené pole; návratová hodnota funkcie je výsledný stav.
 *
 * @param callable(array<string,mixed>):array<string,mixed> $mutator
 * @return array<string,mixed>
 */
function botGuardMutateState(string $ip, callable $mutator): array
{
    $path = botGuardStatePath($ip);
    $handle = @fopen($path, 'c+');
    if ($handle === false) {
        // Bez úložiska limiter nevieme vynucovať — radšej pustiť ďalej,
        // než spadnúť a odstaviť web aj návštevníkom.
        return $mutator([]);
    }

    $state = [];
    try {
        @chmod($path, 0600);
        if (flock($handle, LOCK_EX)) {
            rewind($handle);
            $raw = stream_get_contents($handle);
            if (is_string($raw) && $raw !== '') {
                $parsed = json_decode($raw, true);
                if (is_array($parsed)) {
                    $state = $parsed;
                }
            }

            $state = $mutator($state);

            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, (string) json_encode($state, JSON_UNESCAPED_SLASHES));
            fflush($handle);
            flock($handle, LOCK_UN);
        }
    } finally {
        fclose($handle);
    }

    return $state;
}

/** Zápis do bot-guard logu s rotáciou. */
function botGuardLog(string $action, string $reason): void
{
    $dir = __DIR__ . '/private/logs';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }

    $file = $dir . '/bot-guard.log';
    if (is_file($file) && (int) @filesize($file) > 5 * 1024 * 1024) {
        @rename($file, $file . '.old');
    }

    $ua = botGuardUserAgent();
    $line = implode("\t", [
        date('Y-m-d H:i:s'),
        $action,
        $reason,
        botGuardClientIp(),
        mb_substr((string) ($_SERVER['REQUEST_URI'] ?? '-'), 0, 300),
        $ua !== '' ? $ua : '-',
    ]) . "\n";

    @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    @chmod($file, 0640);
}

/**
 * Forward-confirmed reverse DNS: rDNS musí končiť oficiálnou doménou bota
 * a spätné preloženie mena sa musí vrátiť na tú istú IP.
 *
 * Návratové hodnoty: true = overený, false = podvrh, null = nedá sa rozhodnúť
 * (DNS nedostupné) — vtedy bota nezahadzujeme, len ho neodmeníme výnimkou.
 */
function botGuardVerifyRdns(string $ip, array $suffixes): ?bool
{
    if (!function_exists('gethostbyaddr')) {
        return null;
    }

    $host = @gethostbyaddr($ip);
    if (!is_string($host) || $host === '' || $host === $ip) {
        return null;
    }

    $host = strtolower(rtrim($host, '.'));
    $matches = false;
    foreach ($suffixes as $suffix) {
        if (str_ends_with($host, $suffix)) {
            $matches = true;
            break;
        }
    }
    if (!$matches) {
        return false;
    }

    // Spätné overenie mena → IP (bráni podvrhnutému PTR záznamu).
    if (str_contains($ip, ':')) {
        $records = @dns_get_record($host, DNS_AAAA);
        if (!is_array($records) || $records === []) {
            return null;
        }
        $target = inet_pton($ip);
        foreach ($records as $record) {
            if (isset($record['ipv6']) && inet_pton((string) $record['ipv6']) === $target) {
                return true;
            }
        }
        return false;
    }

    $resolved = @gethostbyname($host);
    if ($resolved === $host) {
        return null;
    }

    return $resolved === $ip;
}

/**
 * Overí vyhľadávacieho bota a výsledok nacachuje na BOT_GUARD_RDNS_TTL.
 * Vracia true (overený), false (podvrhnutý UA) alebo null (neoveriteľné).
 */
function botGuardVerifySearchBot(string $ip, string $ua): ?bool
{
    $suffixes = null;
    foreach (botGuardVerifiableBots() as $needle => $domains) {
        if (stripos($ua, $needle) !== false) {
            $suffixes = $domains;
            break;
        }
    }

    if ($suffixes === null) {
        // Sociálne náhľady a AI-vyhľadávacie agenty rDNS overenie nemajú;
        // prechádzajú bez výnimky, ale so štandardným limitom.
        return null;
    }

    $now = time();
    $cached = null;
    botGuardMutateState($ip, static function (array $s) use ($now, &$cached): array {
        if (isset($s['rdns'], $s['rdns_at']) && ($now - (int) $s['rdns_at']) < BOT_GUARD_RDNS_TTL) {
            $cached = (bool) $s['rdns'];
        }
        return $s;
    });

    if ($cached !== null) {
        return $cached;
    }

    $verdict = botGuardVerifyRdns($ip, $suffixes);
    if ($verdict === null) {
        return null;
    }

    botGuardMutateState($ip, static function (array $s) use ($now, $verdict): array {
        $s['rdns'] = $verdict;
        $s['rdns_at'] = $now;
        return $s;
    });

    return $verdict;
}

/** Odstráni dávno neaktívne súbory stavu (spúšťa sa náhodne, ~0,5 % požiadaviek). */
function botGuardCollectGarbage(): void
{
    if (random_int(1, 200) !== 1) {
        return;
    }

    $files = @glob(botGuardStateDir() . '/*.json');
    if (!is_array($files)) {
        return;
    }

    $cutoff = time() - BOT_GUARD_STATE_TTL;
    foreach ($files as $file) {
        if ((int) @filemtime($file) < $cutoff) {
            @unlink($file);
        }
    }
}

/** Uvalí dočasný ban na IP. */
function botGuardBan(string $ip, int $seconds, string $reason): void
{
    $until = time() + $seconds;
    botGuardMutateState($ip, static function (array $s) use ($until): array {
        $s['banned_until'] = max((int) ($s['banned_until'] ?? 0), $until);
        return $s;
    });
    botGuardLog('ban', $reason . ' (' . $seconds . 's)');
}

/** Odošle 403 a ukončí požiadavku. */
function botGuardReject(string $reason): void
{
    botGuardLog('deny', $reason);
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex, nofollow', true);
    header('Cache-Control: no-store');
    exit(
        "403 — Prístup odmietnutý.\n\n"
        . "Obsah Nefro-projektu Slovensko je chránený autorským právom a nie je\n"
        . "určený na automatizovaný zber ani na trénovanie jazykových modelov.\n"
        . "Ak ide o omyl, napíšte na nefro@polascin.net.\n"
    );
}

/** Odošle 429 s Retry-After a ukončí požiadavku. */
function botGuardThrottle(int $retryAfter, string $reason): void
{
    botGuardLog('throttle', $reason);
    $retryAfter = max(1, $retryAfter);
    http_response_code(429);
    header('Retry-After: ' . $retryAfter);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex, nofollow', true);
    header('Cache-Control: no-store');
    exit(
        "429 — Príliš veľa požiadaviek.\n\n"
        . 'Skúste to znova o ' . $retryAfter . " sekúnd.\n"
    );
}

/** Má sa požiadavka vôbec posudzovať? (CLI, lokálny beh, generovanie PDF nie.) */
function botGuardShouldSkip(): bool
{
    if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
        return true;
    }

    $ip = botGuardClientIp();
    if (in_array($ip, ['127.0.0.1', '::1', '0.0.0.0'], true)) {
        return true;
    }

    // wkhtmltopdf si pri generovaní PDF verzie článku sťahuje vlastné obrázky.
    if (stripos(botGuardUserAgent(), 'wkhtmltopdf') !== false) {
        return true;
    }

    return false;
}

/**
 * Hlavný vstupný bod. Klasifikuje požiadavku, vynúti limity a prípadne ju
 * ukončí (403/429). Pri normálnej prevádzke iba inkrementuje počítadlá.
 */
function botGuardEnforce(): void
{
    static $done = false;
    if ($done || botGuardShouldSkip()) {
        return;
    }
    $done = true;

    $ip = botGuardClientIp();
    $ua = botGuardUserAgent();
    $now = time();

    // ── 1. Prázdny User-Agent ───────────────────────────────────────────────
    // Každý prehliadač aj každý slušný bot sa predstaví. Prázdna hlavička je
    // takmer vždy skript; HEAD (kontrola dostupnosti odkazu) ju mať môže.
    if ($ua === '' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'HEAD') {
        botGuardReject('empty-user-agent');
    }

    // ── 2. Tvrdý blocklist ──────────────────────────────────────────────────
    if ($ua !== '' && preg_match(botGuardDenyPattern(), $ua) === 1) {
        botGuardReject('blocklisted-agent');
    }

    // ── 3. Klasifikácia a limit pre túto triedu klienta ─────────────────────
    $isSearch = $ua !== '' && preg_match(botGuardSearchPattern(), $ua) === 1;
    $isTool   = !$isSearch && $ua !== '' && preg_match(botGuardToolPattern(), $ua) === 1;

    if ($isSearch) {
        $verified = botGuardVerifySearchBot($ip, $ua);
        if ($verified === false) {
            // UA sa vydáva za Googlebota, ale rDNS to nepotvrdzuje → scraper.
            botGuardBan($ip, BOT_GUARD_BAN_SECONDS, 'spoofed-search-bot');
            botGuardReject('spoofed-search-bot');
        }
        $limit = $verified === true ? BOT_GUARD_MAX_SEARCH : BOT_GUARD_MAX;
    } elseif ($isTool) {
        $limit = BOT_GUARD_MAX_TOOL;
    } else {
        $limit = BOT_GUARD_MAX;
    }

    // Fulltextové vyhľadávanie je najdrahšia operácia → polovičný limit.
    if (str_contains((string) ($_SERVER['PHP_SELF'] ?? ''), 'search.php')) {
        $limit = (int) max(10, $limit / 2);
    }

    // ── 4. Započítanie požiadavky a vyhodnotenie okien ──────────────────────
    $banUntil = 0;
    $shortCount = 0;
    $burstCount = 0;

    botGuardMutateState($ip, static function (array $s) use ($now, &$banUntil, &$shortCount, &$burstCount): array {
        $banUntil = (int) ($s['banned_until'] ?? 0);
        if ($banUntil > $now) {
            return $s;
        }
        if ($banUntil !== 0) {
            unset($s['banned_until']);
            $banUntil = 0;
        }

        if (($now - (int) ($s['w_start'] ?? 0)) >= BOT_GUARD_WINDOW) {
            $s['w_start'] = $now;
            $s['w_count'] = 0;
        }
        if (($now - (int) ($s['b_start'] ?? 0)) >= BOT_GUARD_BURST_WINDOW) {
            $s['b_start'] = $now;
            $s['b_count'] = 0;
        }

        $s['w_count'] = (int) ($s['w_count'] ?? 0) + 1;
        $s['b_count'] = (int) ($s['b_count'] ?? 0) + 1;
        $shortCount = (int) $s['w_count'];
        $burstCount = (int) $s['b_count'];

        return $s;
    });

    botGuardCollectGarbage();

    if ($banUntil > $now) {
        $left = $banUntil - $now;
        botGuardLog('banned', 'ban active, ' . $left . 's left');
        http_response_code(403);
        header('Retry-After: ' . $left);
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: no-store');
        exit(
            "403 — Prístup dočasne pozastavený.\n\n"
            . "Zo zariadenia prišlo neúmerné množstvo požiadaviek.\n"
            . 'Skúste to znova o ' . (int) ceil($left / 60) . " minút.\n"
        );
    }

    if ($burstCount > BOT_GUARD_BURST_MAX) {
        botGuardBan($ip, BOT_GUARD_BAN_SECONDS, 'burst-limit ' . $burstCount . '/' . BOT_GUARD_BURST_MAX);
        botGuardThrottle(BOT_GUARD_BAN_SECONDS, 'burst-limit');
    }

    if ($shortCount > $limit) {
        botGuardThrottle(BOT_GUARD_WINDOW, 'rate-limit ' . $shortCount . '/' . $limit);
    }

    // Deklaratívny nesúhlas so zberom na trénovanie AI (`X-Robots-Tag: noai`)
    // pridáva Apache pre všetky odpovede — pozri .htaccess. Tu sa nenastavuje,
    // aby sa hlavička nezdvojila.
}

botGuardEnforce();
