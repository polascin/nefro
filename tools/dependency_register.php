<?php

declare(strict_types=1);
/**
 * dependency_register.php — register dodávaných knižníc a nástrojov (plán rozvoja, etapa 2).
 *
 * Register `tools/dependencies.json` eviduje pre každú dodanú knižnicu/PHAR
 * verziu, pôvod, licenciu, zdroj bezpečnostných oznámení, postup aktualizácie
 * a SHA-256 každého súboru. Ľudsky čitateľný prehľad je v `DEPENDENCIES.md`.
 *
 *   php tools/dependency_register.php --check    # overí hashe a pokrytie (regresná brána)
 *   php tools/dependency_register.php --update   # prepočíta hashe podľa vzorov súborov
 *
 * Súbory mimo gitu (PHAR nástroje) sú `optional`: ak chýbajú, kontrola ich
 * preskočí; ak existujú, hash musí sedieť.
 */

const DEPENDENCY_REGISTER_PATH = __DIR__ . '/dependencies.json';

/**
 * Vzory, ktoré register musí pokrývať úplne: každý existujúci súbor
 * zodpovedajúci vzoru musí patriť niektorej položke.
 */
const DEPENDENCY_COVERAGE_GLOBS = [
    'assets/katex/*/*.js',
    'assets/katex/*/*.css',
    'assets/katex/*/contrib/*',
    'assets/katex/*/fonts/*',
    'assets/katex/*/LICENSE',
    'assets/fonts/*',
    'assets/*.js',
    'tools/*.phar',
];

/**
 * @return array{schema: int, updated: string, entries: list<array<string, mixed>>}
 */
function dependencyRegisterLoad(string $path = DEPENDENCY_REGISTER_PATH): array
{
    $decoded = json_decode((string) file_get_contents($path), true, 32, JSON_THROW_ON_ERROR);
    if (!is_array($decoded) || !isset($decoded['entries']) || !is_array($decoded['entries'])) {
        throw new RuntimeException('Register závislostí má neplatnú štruktúru.');
    }
    return $decoded;
}

/**
 * @return list<string> relatívne cesty (lomky) zoradené podľa názvu
 */
function dependencyRegisterExpand(string $root, array $patterns): array
{
    $files = [];
    foreach ($patterns as $pattern) {
        foreach (glob($root . '/' . $pattern, GLOB_NOSORT) ?: [] as $match) {
            if (is_file($match)) {
                $files[] = str_replace('\\', '/', substr($match, strlen($root) + 1));
            }
        }
    }
    $files = array_values(array_unique($files));
    sort($files);
    return $files;
}

/**
 * Prepočíta hashe všetkých položiek podľa ich vzorov súborov.
 *
 * @param array{schema: int, updated: string, entries: list<array<string, mixed>>} $register
 * @return array{schema: int, updated: string, entries: list<array<string, mixed>>}
 */
/**
 * SHA-256 súboru s normalizovanými koncami riadkov.
 *
 * Register závislostí bol vypočítaný nad súbormi s koncom riadku LF. Na
 * Windows s `core.autocrlf=true` git pri checkoute konvertuje konce riadkov
 * na CRLF, takže ten istý obsah dáva iný hash — kontrola by hlásila nesúlad,
 * hoci by sa naozaj nič nezmenilo.
 *
 * Preto textové súbory hashujeme v normalizovanom tvare (CRLF → LF).
 * Binárne súbory (NUL bajt v prvých 8 kB) nechávame tak, ako sú, aby sa
 * nezničil ich obsah.
 */
function dependencyRegisterHash(string $path): string
{
    $contents = @file_get_contents($path);
    if ($contents === false) {
        $hash = @hash_file('sha256', $path);

        return $hash === false ? '' : $hash;
    }

    if (str_contains(substr($contents, 0, 8192), "\0")) {
        return hash('sha256', $contents);
    }

    return hash('sha256', str_replace("\r\n", "\n", $contents));
}

function dependencyRegisterUpdate(array $register, string $root, string $today): array
{
    foreach ($register['entries'] as &$entry) {
        $patterns = $entry['patterns'] ?? [];
        if (!is_array($patterns) || $patterns === []) {
            throw new RuntimeException('Položka bez vzorov súborov: ' . (string) ($entry['id'] ?? '?'));
        }
        $files = [];
        foreach (dependencyRegisterExpand($root, $patterns) as $relative) {
            $files[$relative] = dependencyRegisterHash($root . '/' . $relative);
        }
        if ($files === [] && empty($entry['optional'])) {
            throw new RuntimeException('Povinná položka nemá žiadne súbory: ' . (string) ($entry['id'] ?? '?'));
        }
        if ($files !== []) {
            $entry['files'] = $files;
        }
    }
    unset($entry);
    $register['updated'] = $today;
    return $register;
}

/**
 * Overí hashe a pokrytie. Vráti zoznam problémov (prázdny = PASS).
 *
 * @param array{schema: int, updated: string, entries: list<array<string, mixed>>} $register
 * @return list<string>
 */
function dependencyRegisterCheck(array $register, string $root): array
{
    $problems = [];
    $registered = [];
    foreach ($register['entries'] as $entry) {
        $id = (string) ($entry['id'] ?? '?');
        foreach (['name', 'version', 'origin', 'license', 'advisories', 'update'] as $field) {
            if (!isset($entry[$field]) || trim((string) $entry[$field]) === '') {
                $problems[] = "{$id}: chýba pole {$field}.";
            }
        }
        $files = $entry['files'] ?? [];
        if (!is_array($files) || $files === []) {
            $problems[] = "{$id}: položka nemá evidované súbory.";
            continue;
        }
        $optional = !empty($entry['optional']);
        foreach ($files as $relative => $expected) {
            $registered[(string) $relative] = $id;
            $path = $root . '/' . $relative;
            if (!is_file($path)) {
                if (!$optional) {
                    $problems[] = "{$id}: evidovaný súbor chýba: {$relative}";
                }
                continue;
            }
            if (!is_string($expected) || preg_match('/^[0-9a-f]{64}$/', $expected) !== 1) {
                $problems[] = "{$id}: neplatný hash pre {$relative}";
                continue;
            }
            if (!hash_equals($expected, dependencyRegisterHash($path))) {
                $problems[] = "{$id}: SHA-256 nesedí: {$relative} (zmena dodanej knižnice bez aktualizácie registra).";
            }
        }
    }
    foreach (dependencyRegisterExpand($root, DEPENDENCY_COVERAGE_GLOBS) as $relative) {
        if (!isset($registered[$relative])) {
            $problems[] = "Neevidovaný dodaný súbor: {$relative}";
        }
    }
    return $problems;
}

if (realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    if (php_sapi_name() !== 'cli') {
        http_response_code(403);
        exit("Prístup odmietnutý.\n");
    }
    $root = dirname(__DIR__);
    $mode = $_SERVER['argv'][1] ?? '--check';
    $register = dependencyRegisterLoad();
    if ($mode === '--update') {
        $register = dependencyRegisterUpdate($register, $root, date('Y-m-d'));
        file_put_contents(DEPENDENCY_REGISTER_PATH, json_encode($register, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        echo 'Register aktualizovaný: ' . count($register['entries']) . " položiek.\n";
        exit(0);
    }
    if ($mode !== '--check') {
        fwrite(STDERR, "Použitie: php tools/dependency_register.php [--check|--update]\n");
        exit(2);
    }
    $problems = dependencyRegisterCheck($register, $root);
    foreach ($problems as $problem) {
        echo 'FAIL ', $problem, "\n";
    }
    $total = 0;
    foreach ($register['entries'] as $entry) {
        $total += count($entry['files'] ?? []);
    }
    echo $problems === [] ? "Register závislostí: {$total} súborov v " . count($register['entries']) . " položkách PASS\n" : count($problems) . " problémov.\n";
    exit($problems === [] ? 0 : 1);
}
