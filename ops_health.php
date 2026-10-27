<?php

declare(strict_types=1);
/**
 * ops_health.php — CLI prevádzkový health-check (prevádzkové signály, plán rozvoja etapa 1).
 *
 * Kontroluje bez zápisu do aplikačných tabuliek:
 *   - dostupnosť databázy a vek najstaršej čakajúcej položky vo frontoch
 *     (newsletter, odberatelia, právne oznámenia) — zaseknutý worker = FAIL;
 *   - zlyhané položky za posledných 24 h (WARN);
 *   - vek logu týždenného retenčného cronu (private/archive_cleanup_cron.log);
 *   - produkčný marker deploy_info.php (DEPLOY_COMMIT, vek nasadenia);
 *   - párovanie perexov: perex v add_*_article.php (zdroj pravdy v gite) sa
 *     musí zhodovať s articles.excerpt (to, čo číta čitateľ, homepage aj
 *     meta/OG description); cudzí perex iného článku = FAIL, iný text = WARN;
 *   - verejné stránky: HTTP 200, jediný <title>, bez PHP chýb a úniku cesty,
 *     hlavičky CSP a HSTS (vypne --no-http).
 *
 * Výstup je agregovaný (počty a veky), bez e-mailov a osobných údajov.
 * Záznam sa pripája do private/logs/ops_health.log (JSON riadok).
 *
 * Použitie:
 *   php ops_health.php [--no-http] [--mail] [--json] [--max-queue-age-hours=24]
 *                      [--cleanup-log-max-days=8] [--base-url=https://nefro.polascin.net]
 *
 * Návratový kód: 0 = PASS alebo WARN, 1 = FAIL. S --mail sa pri FAIL odošle
 * agregovaná správa na SMTP_ADMIN_EMAIL (konfigurácia e-mailov portálu).
 *
 * Príklad cron jobu (každý deň o 06:10):
 *   10 6 * * * /usr/bin/php /path/to/nefro/ops_health.php --mail >> /path/to/nefro/private/ops_health_cron.log 2>&1
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Tento skript je dostupný iba z príkazového riadku.\n");
}

const OPS_HEALTH_QUEUES = [
    'article_newsletter_queue',
    'nl_sub_queue',
    'legal_notice_queue',
    'legal_notice_sub_queue',
];

const OPS_HEALTH_PUBLIC_PATHS = ['/', '/privacy.php', '/calculators.php'];
const OPS_HEALTH_USER_AGENT = 'nefro-ops-health/1.0';

/**
 * Výraz pre aktuálny čas databázy. Vek sa počíta výhradne z hodín DB
 * (poučenie z Behu 130: PHP a DB môžu bežať v rozdielnych pásmach).
 */
function opsHealthDbNowExpression(PDO $pdo): string
{
    return $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite' ? 'CURRENT_TIMESTAMP' : 'NOW()';
}

function opsHealthDbNow(PDO $pdo): string
{
    $now = $pdo->query('SELECT ' . opsHealthDbNowExpression($pdo) . ' AS now_ts')->fetchColumn();
    return (string) $now;
}

/**
 * @return array{table: string, pending: int, oldest_pending_s: ?int, retry_overdue: int, failed_24h: int}
 */
function opsHealthQueueStats(PDO $pdo, string $table, string $dbNow): array
{
    if (!in_array($table, OPS_HEALTH_QUEUES, true)) {
        throw new InvalidArgumentException('Neznámy front.');
    }
    $nowTs = strtotime($dbNow) ?: time();
    $since24h = date('Y-m-d H:i:s', $nowTs - 86400);
    $retryBefore = date('Y-m-d H:i:s', $nowTs - 3600);

    $pendingStmt = $pdo->query("SELECT COUNT(*) AS pending, MIN(created_at) AS oldest FROM {$table} WHERE status = 'pending'");
    $pending = $pendingStmt->fetch(PDO::FETCH_ASSOC) ?: ['pending' => 0, 'oldest' => null];

    $overdueStmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE status = 'pending' AND next_attempt_at < :retry_before");
    $overdueStmt->execute(['retry_before' => $retryBefore]);

    $failedStmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE status = 'failed' AND updated_at >= :since");
    $failedStmt->execute(['since' => $since24h]);

    $oldest = $pending['oldest'] !== null ? strtotime((string) $pending['oldest']) : false;

    return [
        'table' => $table,
        'pending' => (int) $pending['pending'],
        'oldest_pending_s' => $oldest !== false ? max(0, $nowTs - $oldest) : null,
        'retry_overdue' => (int) $overdueStmt->fetchColumn(),
        'failed_24h' => (int) $failedStmt->fetchColumn(),
    ];
}

/**
 * @param array{table: string, pending: int, oldest_pending_s: ?int, retry_overdue: int, failed_24h: int} $stats
 * @return array{status: string, messages: list<string>}
 */
function opsHealthEvaluateQueue(array $stats, int $maxPendingAgeSeconds): array
{
    $status = 'PASS';
    $messages = [];
    if ($stats['oldest_pending_s'] !== null && $stats['oldest_pending_s'] > $maxPendingAgeSeconds) {
        $status = 'FAIL';
        $messages[] = sprintf('%s: najstaršia čakajúca položka má %d h (limit %d h) — worker pravdepodobne nebeží.',
            $stats['table'], intdiv($stats['oldest_pending_s'], 3600), intdiv($maxPendingAgeSeconds, 3600));
    }
    if ($stats['retry_overdue'] > 0 && $status !== 'FAIL') {
        $status = 'WARN';
        $messages[] = sprintf('%s: %d položiek čaká na opakovanie dlhšie než 1 h.', $stats['table'], $stats['retry_overdue']);
    }
    if ($stats['failed_24h'] > 0 && $status === 'PASS') {
        $status = 'WARN';
        $messages[] = sprintf('%s: %d zlyhaní za 24 h.', $stats['table'], $stats['failed_24h']);
    }
    return ['status' => $status, 'messages' => $messages];
}

/**
 * Vek súboru v sekundách alebo null, ak neexistuje.
 */
function opsHealthFileAgeSeconds(string $path): ?int
{
    if (!is_file($path)) {
        return null;
    }
    $mtime = filemtime($path);
    return $mtime === false ? null : max(0, time() - $mtime);
}

/**
 * @return array{status: string, messages: list<string>}
 */
function opsHealthEvaluateFileAge(string $label, ?int $ageSeconds, int $maxAgeSeconds, bool $missingIsFailure = false): array
{
    if ($ageSeconds === null) {
        return [
            'status' => $missingIsFailure ? 'FAIL' : 'WARN',
            'messages' => [$label . ': súbor neexistuje, stav sa nedá overiť.'],
        ];
    }
    if ($ageSeconds > $maxAgeSeconds) {
        return [
            'status' => 'FAIL',
            'messages' => [sprintf('%s: posledná zmena pred %d dňami (limit %d dní).', $label, intdiv($ageSeconds, 86400), intdiv($maxAgeSeconds, 86400))],
        ];
    }
    return ['status' => 'PASS', 'messages' => []];
}

/**
 * Načíta DEPLOY_COMMIT a DEPLOY_TIMESTAMP z deploy_info.php bez jeho vykonania.
 *
 * @return array{commit: ?string, timestamp: ?int}
 */
function opsHealthDeployMarker(string $path): array
{
    if (!is_file($path)) {
        return ['commit' => null, 'timestamp' => null];
    }
    $source = (string) file_get_contents($path);
    $commit = preg_match("/define\\('DEPLOY_COMMIT',\\s*'([0-9a-f]{7,40})'\\)/", $source, $m) === 1 ? $m[1] : null;
    $timestamp = preg_match("/define\\('DEPLOY_TIMESTAMP',\\s*(\\d{9,11})\\)/", $source, $t) === 1 ? (int) $t[1] : null;
    return ['commit' => $commit, 'timestamp' => $timestamp];
}

/**
 * Perex (excerpt) článku žije na dvoch miestach: v skripte add_<slug>_article.php
 * (zdroj pravdy v gite) a v tabuľke articles (čo vidí čitateľ, homepage a
 * meta/OG description). Deploy spúšťa UPSERT iba pre upravené (M) skripty, takže
 * oprava perexu v skripte, ktorý sa do mainu dostal ako nový súbor (A), ostane
 * v DB neuplatnená. Presne tak mal článok SoBic od 2026-10-18 do 2026-10-20 v DB
 * perex iného článku (CAC/Mg/PTH), hoci commit d98c5dc skript opravil.
 *
 * Normalizácia: odstráni escapovanie PHP reťazca v jednoduchých úvodzovkách,
 * zjednotí biele znaky a oreže okraje; DB porovnanie je citlivé na diakritiku.
 */
function opsHealthNormalizeExcerpt(string $text): string
{
    $text = str_replace(["\\'", '\\\\'], ["'", '\\'], $text);
    return trim((string) preg_replace('/\s+/u', ' ', $text));
}

/**
 * Perexy zo skriptov článkov: slug => normalizovaný perex. Skript bez
 * jednoznačného páru slug/excerpt sa preskočí (rovnaká logika ako
 * tools/test_article_excerpts.php).
 *
 * @return array<string, string>
 */
function opsHealthScriptExcerpts(string $root): array
{
    $bySlug = [];
    foreach (glob($root . '/add_*_article.php') ?: [] as $file) {
        $source = (string) file_get_contents($file);
        $slugCount = preg_match_all("/'slug'\\s*=>\\s*'([^']+)'/u", $source, $slugs);
        $excerptCount = preg_match_all("/'excerpt'\\s*=>\\s*'((?:[^'\\\\]|\\\\.)*)'/u", $source, $texts);
        if ($slugCount === 0 || $slugCount !== $excerptCount) {
            continue;
        }
        foreach ($slugs[1] as $i => $slug) {
            $bySlug[$slug] = opsHealthNormalizeExcerpt($texts[1][$i]);
        }
    }
    ksort($bySlug);
    return $bySlug;
}

/**
 * Porovná perexy skriptov s tabuľkou articles.
 *
 * - `foreign`: DB nesie perex, ktorý v skriptoch patrí INÉMU článku
 *   (perex spárovaný s nesprávnym článkom — chyba viditeľná čitateľom);
 * - `drift`: DB má iný text než skript (úprava v admin UI alebo neuplatnený
 *   UPSERT) — na posúdenie, nie nutne chyba;
 * - `missing`: slug zo skriptu v DB nie je (nepublikovaný alebo premenovaný).
 *
 * @param array<string, string> $scriptExcerpts slug => normalizovaný perex
 * @return array{scripts: int, compared: int, missing: int, drift: list<string>, foreign: list<array{slug: string, owner: string}>}
 */
function opsHealthExcerptDrift(PDO $pdo, array $scriptExcerpts): array
{
    $owners = [];
    foreach ($scriptExcerpts as $slug => $excerpt) {
        if ($excerpt !== '') {
            $owners[mb_strtolower($excerpt)][] = $slug;
        }
    }

    $compared = 0;
    $drift = [];
    $foreign = [];
    $slugs = array_keys($scriptExcerpts);
    foreach (array_chunk($slugs, 200) as $chunk) {
        $placeholders = implode(',', array_fill(0, count($chunk), '?'));
        $stmt = $pdo->prepare("SELECT slug, excerpt FROM articles WHERE slug IN ({$placeholders})");
        $stmt->execute(array_values($chunk));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $slug = (string) $row['slug'];
            if (!isset($scriptExcerpts[$slug])) {
                continue;
            }
            ++$compared;
            $dbExcerpt = opsHealthNormalizeExcerpt((string) ($row['excerpt'] ?? ''));
            if ($dbExcerpt === $scriptExcerpts[$slug]) {
                continue;
            }
            $others = array_values(array_diff($owners[mb_strtolower($dbExcerpt)] ?? [], [$slug]));
            if ($others !== []) {
                $foreign[] = ['slug' => $slug, 'owner' => $others[0]];
            } else {
                $drift[] = $slug;
            }
        }
    }
    sort($drift);
    usort($foreign, static fn (array $a, array $b): int => strcmp($a['slug'], $b['slug']));

    return [
        'scripts' => count($scriptExcerpts),
        'compared' => $compared,
        'missing' => count($scriptExcerpts) - $compared,
        'drift' => $drift,
        'foreign' => $foreign,
    ];
}

/**
 * @param array{scripts: int, compared: int, missing: int, drift: list<string>, foreign: list<array{slug: string, owner: string}>} $result
 * @return array{status: string, messages: list<string>}
 */
function opsHealthEvaluateExcerptDrift(array $result): array
{
    $messages = [];
    $status = 'PASS';
    foreach ($result['foreign'] as $item) {
        $status = 'FAIL';
        $messages[] = sprintf('perex článku %s je v DB perexom článku %s — spusti php add_%s_article.php (UPSERT bez avíza).',
            $item['slug'], $item['owner'], $item['slug']);
    }
    if ($result['drift'] !== []) {
        if ($status === 'PASS') {
            $status = 'WARN';
        }
        $shown = array_slice($result['drift'], 0, 5);
        $messages[] = sprintf('%d článkov má v DB iný perex než skript: %s%s — over, či platí skript alebo admin úprava.',
            count($result['drift']), implode(', ', $shown), count($result['drift']) > 5 ? ', …' : '');
    }
    return ['status' => $status, 'messages' => $messages];
}

/**
 * Posúdi verejnú odpoveď: stav, telo a bezpečnostné hlavičky.
 *
 * @param array<string, string> $headers kľúče malými písmenami
 * @return array{status: string, messages: list<string>}
 */
function opsHealthEvaluateHttp(string $path, int $code, array $headers, string $body, string $privatePathPrefix): array
{
    $messages = [];
    if ($code !== 200) {
        return ['status' => 'FAIL', 'messages' => [sprintf('%s: HTTP %d namiesto 200.', $path, $code)]];
    }
    if (preg_match('~(?:<b>)?(Fatal error|Parse error|Warning|Deprecated|Notice)(?:</b>)?:\s+(?:Uncaught|Undefined|require|include|syntax|[A-Za-z_\\\\]+::|[a-z_]+\()~', $body) === 1) {
        $messages[] = $path . ': telo obsahuje chybový výstup PHP.';
    }
    if ($privatePathPrefix !== '' && str_contains($body, $privatePathPrefix)) {
        $messages[] = $path . ': telo prezrádza súborovú cestu servera.';
    }
    $titles = preg_match_all('~<title\b~i', $body);
    if ($titles !== 1) {
        $messages[] = sprintf('%s: počet <title> je %d, očakáva sa 1.', $path, (int) $titles);
    }
    if (!isset($headers['content-security-policy'])) {
        $messages[] = $path . ': chýba hlavička Content-Security-Policy.';
    }
    $status = $messages === [] ? 'PASS' : 'FAIL';
    if (!isset($headers['strict-transport-security'])) {
        $messages[] = $path . ': chýba hlavička Strict-Transport-Security.';
        if ($status === 'PASS') {
            $status = 'WARN';
        }
    }
    return ['status' => $status, 'messages' => $messages];
}

/**
 * Jednoduché GET s vlastným User-Agentom. Prázdny UA web odmieta (403) a WAF
 * hostingu blokuje skrátené prehliadačové UA; identifikátor nástroja prechádza
 * a zároveň ho odlíši v logoch (overené 2026-10-27 zo servera aj lokálne).
 *
 * Pri zlyhaní transportu (DNS, TLS, timeout) je code 0 a error nesie príčinu;
 * bez nej sa lokálne chýbajúci CA bundle nedá odlíšiť od výpadku webu.
 *
 * @return array{code: int, headers: array<string, string>, body: string, error: string}
 */
function opsHealthFetch(string $url, int $timeout = 20): array
{
    $headers = [];
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_USERAGENT => OPS_HEALTH_USER_AGENT,
            CURLOPT_HEADERFUNCTION => static function ($curl, string $line) use (&$headers): int {
                $pos = strpos($line, ':');
                if ($pos !== false) {
                    $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos + 1));
                }
                return strlen($line);
            },
        ]);
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $error = $body === false ? sprintf('curl %d: %s', curl_errno($ch), curl_error($ch)) : '';
        curl_close($ch);
        return ['code' => $body === false ? 0 : $code, 'headers' => $headers, 'body' => is_string($body) ? $body : '', 'error' => $error];
    }

    $context = stream_context_create(['http' => ['method' => 'GET', 'timeout' => $timeout, 'ignore_errors' => true, 'follow_location' => 0, 'user_agent' => OPS_HEALTH_USER_AGENT]]);
    $http_response_header = [];
    $body = @file_get_contents($url, false, $context);
    $code = 0;
    foreach ($http_response_header as $line) {
        if (preg_match('~^HTTP/\S+\s+(\d{3})~', $line, $m) === 1) {
            $code = (int) $m[1];
            continue;
        }
        $pos = strpos($line, ':');
        if ($pos !== false) {
            $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos + 1));
        }
    }
    $error = '';
    if ($body === false) {
        $last = error_get_last();
        $error = $last !== null ? $last['message'] : 'požiadavka zlyhala';
    }
    return ['code' => $body === false ? 0 : $code, 'headers' => $headers, 'body' => is_string($body) ? $body : '', 'error' => $error];
}

/**
 * Zlúči čiastkové stavy: FAIL > WARN > PASS.
 *
 * @param list<string> $statuses
 */
function opsHealthCombine(array $statuses): string
{
    if (in_array('FAIL', $statuses, true)) {
        return 'FAIL';
    }
    return in_array('WARN', $statuses, true) ? 'WARN' : 'PASS';
}

/**
 * Riadok do logu: iba agregáty, žiadne adresy ani obsah.
 *
 * @param list<array{table: string, pending: int, oldest_pending_s: ?int, retry_overdue: int, failed_24h: int}> $queues
 * @param array<string, int> $http cesta => HTTP kód
 * @param array{scripts: int, compared: int, missing: int, drift: list<string>, foreign: list<array{slug: string, owner: string}>}|null $excerpts
 * @return array<string, mixed>
 */
function opsHealthLogEntry(string $result, array $queues, array $http, ?string $deployCommit, ?int $cleanupLogAge, ?array $excerpts = null): array
{
    $queueSummary = [];
    foreach ($queues as $q) {
        $queueSummary[$q['table']] = [
            'pending' => $q['pending'],
            'oldest_h' => $q['oldest_pending_s'] === null ? null : intdiv($q['oldest_pending_s'], 3600),
            'retry_overdue' => $q['retry_overdue'],
            'failed_24h' => $q['failed_24h'],
        ];
    }
    return [
        'ts' => gmdate('c'),
        'result' => $result,
        'deploy_commit' => $deployCommit,
        'cleanup_log_age_d' => $cleanupLogAge === null ? null : intdiv($cleanupLogAge, 86400),
        'queues' => $queueSummary,
        'excerpts' => $excerpts === null ? null : [
            'compared' => $excerpts['compared'],
            'drift' => count($excerpts['drift']),
            'foreign' => count($excerpts['foreign']),
        ],
        'http' => $http,
    ];
}

/**
 * Hlavný beh — iba pri priamom spustení (testy súbor includujú).
 */
function opsHealthMain(array $argv): int
{
    $noHttp = false;
    $mail = false;
    $json = false;
    $maxQueueAgeHours = 24;
    $cleanupLogMaxDays = 8;
    $baseUrl = 'https://nefro.polascin.net';
    foreach (array_slice($argv, 1) as $arg) {
        if ($arg === '--no-http') {
            $noHttp = true;
        } elseif ($arg === '--mail') {
            $mail = true;
        } elseif ($arg === '--json') {
            $json = true;
        } elseif (preg_match('/^--max-queue-age-hours=(\d{1,4})$/', $arg, $m) === 1) {
            $maxQueueAgeHours = max(1, (int) $m[1]);
        } elseif (preg_match('/^--cleanup-log-max-days=(\d{1,3})$/', $arg, $m) === 1) {
            $cleanupLogMaxDays = max(1, (int) $m[1]);
        } elseif (preg_match('~^--base-url=(https://[A-Za-z0-9.-]+)/?$~', $arg, $m) === 1) {
            $baseUrl = $m[1];
        } else {
            fwrite(STDERR, "Neznámy parameter: {$arg}\n");
            return 2;
        }
    }

    $statuses = [];
    $lines = [];
    $queueStats = [];
    $httpCodes = [];
    $excerptDrift = null;

    // 1) Databáza a fronty. db_config.php pri chybe konfigurácie končí exit(0)
    // so správou, preto sa pripojenie zostavuje tu s rovnakými parametrami
    // (utf8mb4, natívne prepared statements), aby zlyhanie bolo FAIL s kódom 1.
    try {
        require_once __DIR__ . '/config_loader.php';
        $env = loadAppConfig();
        $dbHost = (string) ($env['DB_HOST'] ?? '');
        $dbName = (string) ($env['DB_NAME'] ?? '');
        if ($dbHost === '' || $dbName === '' || (string) ($env['DB_USER'] ?? '') === '') {
            throw new RuntimeException('Databázová konfigurácia je nekompletná.');
        }
        $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", (string) $env['DB_USER'], (string) ($env['DB_PASS'] ?? ''), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 10,
        ]);
        $dbNow = opsHealthDbNow($pdo);
        $lines[] = 'DB: pripojená, čas DB ' . $dbNow;
        foreach (OPS_HEALTH_QUEUES as $table) {
            $stats = opsHealthQueueStats($pdo, $table, $dbNow);
            $queueStats[] = $stats;
            $evaluation = opsHealthEvaluateQueue($stats, $maxQueueAgeHours * 3600);
            $statuses[] = $evaluation['status'];
            $lines[] = sprintf('%-5s %s: pending=%d, najstaršia=%s, po termíne=%d, zlyhané 24h=%d',
                $evaluation['status'], $table, $stats['pending'],
                $stats['oldest_pending_s'] === null ? '-' : intdiv($stats['oldest_pending_s'], 60) . ' min',
                $stats['retry_overdue'], $stats['failed_24h']);
            foreach ($evaluation['messages'] as $message) {
                $lines[] = '      ' . $message;
            }
        }

        // 1b) Párovanie perexov: skript add_*_article.php vs articles.excerpt.
        $excerptDrift = opsHealthExcerptDrift($pdo, opsHealthScriptExcerpts(__DIR__));
        $excerptEval = opsHealthEvaluateExcerptDrift($excerptDrift);
        $statuses[] = $excerptEval['status'];
        $lines[] = sprintf('%-5s perexy článkov: skriptov=%d, porovnaných=%d, bez záznamu v DB=%d, odlišných=%d, cudzích=%d',
            $excerptEval['status'], $excerptDrift['scripts'], $excerptDrift['compared'], $excerptDrift['missing'],
            count($excerptDrift['drift']), count($excerptDrift['foreign']));
        foreach ($excerptEval['messages'] as $message) {
            $lines[] = '      ' . $message;
        }
    } catch (\Throwable $e) {
        $statuses[] = 'FAIL';
        $lines[] = 'FAIL  DB: ' . get_class($e) . ' — ' . preg_replace('/\s+/', ' ', $e->getMessage());
    }

    // 2) Retenčný cron
    $cleanupLog = __DIR__ . '/private/archive_cleanup_cron.log';
    $cleanupAge = opsHealthFileAgeSeconds($cleanupLog);
    $cleanupEval = opsHealthEvaluateFileAge('archive_cleanup_cron.log', $cleanupAge, $cleanupLogMaxDays * 86400);
    $statuses[] = $cleanupEval['status'];
    $lines[] = sprintf('%-5s retenčný cron: log %s', $cleanupEval['status'],
        $cleanupAge === null ? 'chýba' : 'zmenený pred ' . intdiv($cleanupAge, 3600) . ' h');
    foreach ($cleanupEval['messages'] as $message) {
        $lines[] = '      ' . $message;
    }

    // 3) Produkčný marker
    $marker = opsHealthDeployMarker(__DIR__ . '/deploy_info.php');
    if ($marker['commit'] === null) {
        $statuses[] = 'WARN';
        $lines[] = 'WARN  deploy_info.php: marker chýba alebo je nečitateľný.';
    } else {
        $age = $marker['timestamp'] === null ? null : max(0, time() - $marker['timestamp']);
        $lines[] = sprintf('PASS  deploy marker: %s%s', $marker['commit'],
            $age === null ? '' : ' (nasadené pred ' . intdiv($age, 3600) . ' h)');
    }

    // 4) Verejné stránky
    if (!$noHttp) {
        foreach (OPS_HEALTH_PUBLIC_PATHS as $path) {
            $response = opsHealthFetch($baseUrl . $path);
            $httpCodes[$path] = $response['code'];
            $evaluation = opsHealthEvaluateHttp($path, $response['code'], $response['headers'], $response['body'], __DIR__);
            $statuses[] = $evaluation['status'];
            $lines[] = sprintf('%-5s GET %s: HTTP %d, %d B', $evaluation['status'], $path, $response['code'], strlen($response['body']));
            if ($response['error'] !== '') {
                $lines[] = '      transport: ' . $response['error'];
            }
            foreach ($evaluation['messages'] as $message) {
                $lines[] = '      ' . $message;
            }
        }
    }

    $result = opsHealthCombine($statuses);
    $entry = opsHealthLogEntry($result, $queueStats, $httpCodes, $marker['commit'], $cleanupAge, $excerptDrift);

    $logDir = __DIR__ . '/private/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0770, true);
    }
    if (is_dir($logDir) && is_writable($logDir)) {
        @file_put_contents($logDir . '/ops_health.log', json_encode($entry, JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND | LOCK_EX);
    } else {
        $lines[] = 'WARN  private/logs nie je zapisovateľný, záznam sa neuložil.';
    }

    $report = "Nefro ops health — " . date('Y-m-d H:i:s') . "\n" . implode("\n", $lines) . "\nRESULT: {$result}\n";
    if ($json) {
        echo json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
    } else {
        echo $report;
    }

    if ($mail && $result === 'FAIL') {
        require_once __DIR__ . '/email_verification.php';
        $cfg = getEmailEnvConfig();
        $to = (string) ($cfg['admin_notification_email'] ?? '');
        if ($to !== '' && smtpHasRequiredConfig($cfg)) {
            $sent = sendViaSmtp($to, '[Nefro] ops health FAIL', $report, $cfg);
            echo $sent ? "Upozornenie odoslané správcovi.\n" : "Upozornenie sa nepodarilo odoslať (pozri SMTP log).\n";
        } else {
            echo "Upozornenie neodoslané: chýba SMTP_ADMIN_EMAIL alebo SMTP konfigurácia.\n";
        }
    }

    return $result === 'FAIL' ? 1 : 0;
}

if (realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    exit(opsHealthMain(isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : []));
}
