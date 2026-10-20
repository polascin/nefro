<?php

declare(strict_types=1);

// Includuje iba funkcie; hlavný beh sa spúšťa len pri priamom volaní skriptu.
require_once __DIR__ . '/../ops_health.php';

$checks = 0;
function opsHealthTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
foreach (OPS_HEALTH_QUEUES as $table) {
    $pdo->exec("CREATE TABLE {$table} (
        id INTEGER PRIMARY KEY, status TEXT NOT NULL DEFAULT 'pending', attempts INTEGER NOT NULL DEFAULT 0,
        next_attempt_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, email TEXT NOT NULL DEFAULT 'synthetic@example.invalid'
    )");
}
$dbNow = opsHealthDbNow($pdo);
opsHealthTest(strtotime($dbNow) !== false, 'Čas DB musí byť parsovateľný.');

// Prázdne fronty = PASS.
foreach (OPS_HEALTH_QUEUES as $table) {
    $stats = opsHealthQueueStats($pdo, $table, $dbNow);
    opsHealthTest($stats['pending'] === 0 && $stats['oldest_pending_s'] === null, "Prázdny front {$table} musí mať nulové agregáty.");
    opsHealthTest(opsHealthEvaluateQueue($stats, 24 * 3600)['status'] === 'PASS', "Prázdny front {$table} musí byť PASS.");
}

// Čakajúca položka stará dva dni (čas DB) = FAIL pri limite 24 h, PASS pri limite 72 h.
$pdo->exec("INSERT INTO nl_sub_queue (status, created_at, next_attempt_at) VALUES ('pending', datetime('now', '-2 days'), datetime('now', '-2 days'))");
$stats = opsHealthQueueStats($pdo, 'nl_sub_queue', $dbNow);
opsHealthTest($stats['pending'] === 1, 'Čakajúca položka sa musí započítať.');
opsHealthTest($stats['oldest_pending_s'] !== null && abs($stats['oldest_pending_s'] - 172800) < 120, 'Vek najstaršej položky sa počíta z času DB.');
opsHealthTest($stats['retry_overdue'] === 1, 'Položka s next_attempt_at pred hodinou je po termíne.');
$evaluation = opsHealthEvaluateQueue($stats, 24 * 3600);
opsHealthTest($evaluation['status'] === 'FAIL' && $evaluation['messages'] !== [], 'Dva dni stará položka musí byť FAIL.');
opsHealthTest(opsHealthEvaluateQueue($stats, 72 * 3600)['status'] === 'WARN', 'Pri vyššom limite ostane iba WARN za oneskorené opakovanie.');

// Zlyhanie za 24 h = WARN; staršie zlyhanie sa nepočíta.
$pdo->exec("INSERT INTO legal_notice_queue (status, created_at, updated_at) VALUES ('failed', datetime('now', '-3 hours'), datetime('now', '-3 hours'))");
$pdo->exec("INSERT INTO legal_notice_queue (status, created_at, updated_at) VALUES ('failed', datetime('now', '-5 days'), datetime('now', '-5 days'))");
$stats = opsHealthQueueStats($pdo, 'legal_notice_queue', $dbNow);
opsHealthTest($stats['failed_24h'] === 1, 'Počítajú sa iba zlyhania za posledných 24 h.');
opsHealthTest(opsHealthEvaluateQueue($stats, 24 * 3600)['status'] === 'WARN', 'Čerstvé zlyhanie musí byť WARN.');

// Odoslané položky sa nepovažujú za čakajúce.
$pdo->exec("INSERT INTO article_newsletter_queue (status, created_at) VALUES ('sent', datetime('now', '-10 days'))");
opsHealthTest(opsHealthQueueStats($pdo, 'article_newsletter_queue', $dbNow)['pending'] === 0, 'Odoslané položky nie sú čakajúce.');

// Neznámy front sa odmietne (ochrana pred vložením názvu tabuľky).
try {
    opsHealthQueueStats($pdo, 'users; DROP TABLE users', $dbNow);
    opsHealthTest(false, 'Neznámy front musí vyhodiť výnimku.');
} catch (InvalidArgumentException) {
    opsHealthTest(true, '');
}

// Vek súboru.
$tmp = tempnam(sys_get_temp_dir(), 'nefro-ops-');
opsHealthTest($tmp !== false, 'Dočasný súbor sa musí vytvoriť.');
$age = opsHealthFileAgeSeconds((string) $tmp);
opsHealthTest($age !== null && $age < 60, 'Čerstvý súbor má malý vek.');
opsHealthTest(opsHealthEvaluateFileAge('log', $age, 8 * 86400)['status'] === 'PASS', 'Čerstvý log je PASS.');
opsHealthTest(opsHealthEvaluateFileAge('log', 9 * 86400, 8 * 86400)['status'] === 'FAIL', 'Starý log je FAIL.');
opsHealthTest(opsHealthEvaluateFileAge('log', null, 8 * 86400)['status'] === 'WARN', 'Chýbajúci log je WARN.');
opsHealthTest(opsHealthEvaluateFileAge('log', null, 8 * 86400, true)['status'] === 'FAIL', 'Chýbajúci povinný súbor je FAIL.');
opsHealthTest(opsHealthFileAgeSeconds((string) $tmp . '.missing') === null, 'Neexistujúci súbor vracia null.');

// Produkčný marker sa číta bez vykonania PHP.
file_put_contents((string) $tmp, "<?php\ndefine('DEPLOY_TIME', '20.10.2026 10:00');\ndefine('DEPLOY_TIMESTAMP', 1792000000);\ndefine('DEPLOY_COMMIT', 'abc1234');\ndefine('DEPLOY_BRANCH', 'main');\n");
$marker = opsHealthDeployMarker((string) $tmp);
opsHealthTest($marker['commit'] === 'abc1234' && $marker['timestamp'] === 1792000000, 'Marker sa musí prečítať.');
opsHealthTest(opsHealthDeployMarker((string) $tmp . '.missing') === ['commit' => null, 'timestamp' => null], 'Chýbajúci marker vracia null.');
unlink((string) $tmp);

// Posúdenie verejnej odpovede.
$okHeaders = ['content-security-policy' => "default-src 'self'", 'strict-transport-security' => 'max-age=31536000'];
$okBody = '<!DOCTYPE html><html><head><title>Nefro</title></head><body><p>Obsah s výrazom Warning v texte je v poriadku.</p></body></html>';
opsHealthTest(opsHealthEvaluateHttp('/', 200, $okHeaders, $okBody, 'D:/nikde')['status'] === 'PASS', 'Zdravá odpoveď je PASS.');
opsHealthTest(opsHealthEvaluateHttp('/', 503, $okHeaders, $okBody, '')['status'] === 'FAIL', 'HTTP 503 je FAIL.');
opsHealthTest(opsHealthEvaluateHttp('/', 0, $okHeaders, '', '')['status'] === 'FAIL', 'Neúspešné spojenie je FAIL.');
opsHealthTest(opsHealthEvaluateHttp('/', 200, ['strict-transport-security' => 'x'], $okBody, '')['status'] === 'FAIL', 'Chýbajúca CSP je FAIL.');
opsHealthTest(opsHealthEvaluateHttp('/', 200, ['content-security-policy' => 'x'], $okBody, '')['status'] === 'WARN', 'Chýbajúci HSTS je WARN.');
opsHealthTest(opsHealthEvaluateHttp('/', 200, $okHeaders, $okBody . '<title>Druhý</title>', '')['status'] === 'FAIL', 'Dva <title> sú FAIL.');
$fatal = '<html><head><title>x</title></head><body><br />' . "\n" . '<b>Fatal error</b>:  Uncaught Error: Call to undefined function x() in /srv/app/legal.php:12</body></html>';
opsHealthTest(opsHealthEvaluateHttp('/privacy.php', 200, $okHeaders, $fatal, '')['status'] === 'FAIL', 'PHP fatal error v tele je FAIL.');
$warning = '<html><head><title>x</title></head><body>Warning: Undefined variable $x in /srv/app/index.php on line 3</body></html>';
opsHealthTest(opsHealthEvaluateHttp('/', 200, $okHeaders, $warning, '')['status'] === 'FAIL', 'PHP warning v tele je FAIL.');
$leak = '<html><head><title>x</title></head><body>/data/8/6/abc/polascin.net/sub/nefro/x.php</body></html>';
opsHealthTest(opsHealthEvaluateHttp('/', 200, $okHeaders, $leak, '/data/8/6/abc/polascin.net/sub/nefro')['status'] === 'FAIL', 'Únik cesty je FAIL.');

// Kombinácia stavov a záznam do logu bez osobných údajov.
opsHealthTest(opsHealthCombine(['PASS', 'WARN', 'FAIL']) === 'FAIL' && opsHealthCombine(['PASS', 'WARN']) === 'WARN' && opsHealthCombine(['PASS']) === 'PASS' && opsHealthCombine([]) === 'PASS', 'Kombinácia stavov.');
$entry = opsHealthLogEntry('WARN', [opsHealthQueueStats($pdo, 'nl_sub_queue', $dbNow)], ['/' => 200], 'abc1234', 3 * 86400 + 5);
$json = json_encode($entry, JSON_THROW_ON_ERROR);
opsHealthTest(!str_contains($json, '@') && !str_contains($json, 'synthetic'), 'Záznam nesmie obsahovať e-maily.');
opsHealthTest($entry['result'] === 'WARN' && $entry['cleanup_log_age_d'] === 3 && $entry['queues']['nl_sub_queue']['pending'] === 1 && $entry['http']['/'] === 200, 'Záznam obsahuje agregáty.');

// Priame spustenie bez DB konfigurácie: skript sa nesmie zrútiť, FAIL vráti kód 1 a nezapíše do produkčnej cesty.
$root = dirname(__DIR__);
$environment = getenv();
$environment['NEFRO_ENV_PATH'] = sys_get_temp_dir() . '/nefro-missing-' . bin2hex(random_bytes(6)) . '.ini';
$descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
$process = proc_open([PHP_BINARY, $root . '/ops_health.php', '--no-http', '--json'], $descriptors, $pipes, $root, $environment);
opsHealthTest(is_resource($process), 'Skript sa musí spustiť.');
fclose($pipes[0]);
$stdout = stream_get_contents($pipes[1]);
$stderr = stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
$exit = proc_close($process);
opsHealthTest($exit === 1, 'Bez dostupnej DB musí byť výsledok FAIL (kód 1), dostal ' . $exit . ' ' . $stderr);
$decoded = json_decode((string) $stdout, true);
opsHealthTest(is_array($decoded) && $decoded['result'] === 'FAIL' && $decoded['queues'] === [], 'JSON výstup musí niesť FAIL bez frontov.');
opsHealthTest(!str_contains((string) $stdout, '@'), 'Výstup nesmie obsahovať adresy.');

$process = proc_open([PHP_BINARY, $root . '/ops_health.php', '--neznamy'], $descriptors, $pipes, $root, $environment);
fclose($pipes[0]);
stream_get_contents($pipes[1]);
stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
opsHealthTest(proc_close($process) === 2, 'Neznámy parameter vracia kód 2.');

echo "Ops health: $checks PASS\n";
