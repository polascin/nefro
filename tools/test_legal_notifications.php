<?php

declare(strict_types=1);

// Iba pamäťová databáza a zachytené e-maily, bez pripojenia k produkcii.
class LegalTestMailbox
{
    /** @var list<string> */
    public static array $messages = [];
}
function legalNoticeSendOne(string $email, string $subject, string $bodyHtml, bool $plain = false): bool
{
    LegalTestMailbox::$messages[] = $bodyHtml;
    return true;
}

function getNewsletterUnsubscribeSecret(): string
{
    return 'fictional-test-key';
}

require_once __DIR__ . '/../legal_notifications.php';

$checks = 0;
function legalTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

// SQLite adaptér mení iba syntax INSERT IGNORE; aplikačné dotazy zostávajú reálne.
class LegalTestPdo extends PDO
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        return parent::prepare(str_replace('INSERT IGNORE', 'INSERT OR IGNORE', $query), $options);
    }
}

$pdo = new LegalTestPdo('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->sqliteCreateFunction('NOW', static fn (): string => '2026-09-24 00:00:00');
$pdo->exec('CREATE TABLE legal_notice_runs (legal_version TEXT PRIMARY KEY, effective_date TEXT,
    change_summary TEXT, dispatched_at TEXT, users_queued INTEGER, subscribers_queued INTEGER)');
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, title_before TEXT,
    first_name TEXT, middle_name TEXT, last_name TEXT, title_after TEXT, email TEXT,
    is_active INTEGER, email_verified_at TEXT)');
$pdo->exec("INSERT INTO users (id, email, is_active, email_verified_at)
    VALUES (1, 'member@example.invalid', 1, '2026-01-01')");
$pdo->exec('CREATE TABLE newsletter_subscribers (id INTEGER PRIMARY KEY, email TEXT,
    verified_at TEXT, unsubscribed_at TEXT)');
$pdo->exec("INSERT INTO newsletter_subscribers VALUES (1, 'subscriber@example.invalid', '2026-01-01', NULL)");
foreach (['legal_notice_queue' => 'user_id', 'legal_notice_sub_queue' => 'subscriber_id'] as $table => $owner) {
    $pdo->exec("CREATE TABLE $table (id INTEGER PRIMARY KEY, legal_version TEXT, $owner INTEGER,
        email TEXT, status TEXT, next_attempt_at TEXT, attempts INTEGER DEFAULT 0,
        sent_at TEXT, last_error TEXT, UNIQUE(legal_version, $owner))");
}

$current = legalNoticeCurrentVersionInfo();
legalTest($current['version'] === '2.8', 'Technická zmena nesmie zvýšiť právnu verziu.');
legalTest(count($current['updates']) === 1, 'Verzia 2.8 obsahuje iba svoju zmenu.');
legalTest(count(legalRecentUpdates()) === 16, 'Web zachová celý historický prehľad.');
legalTest(count(legalRecentUpdates('2.7')) === 4, 'Verzia 2.7 má samostatnú skupinu.');
legalTest(legalRecentUpdates('unknown') === [], 'Neznáma verzia nevracia aktuálne zmeny.');

// Simulácia starého kumulatívneho súhrnu a oneskoreného doručenia oboch frontov.
$first = enqueueLegalChangeNotice($pdo, '2.7', '2026-09-10', legalRecentUpdates());
legalTest($first === ['already' => false, 'users' => 1, 'subscribers' => 1], 'Prvé zaradenie oboch príjemcov.');
$repeat = enqueueLegalChangeNotice($pdo, '2.7', '2026-09-10', legalRecentUpdates('2.7'));
legalTest($repeat === ['already' => true, 'users' => 0, 'subscribers' => 0], 'Opakovanie nesmie pridať oznámenie.');
foreach ([processLegalNoticeQueue($pdo), processLegalNoticeSubQueue($pdo)] as $stats) {
    legalTest($stats['sent'] === 1, 'Oba typy frontov doručia jednu správu.');
}
legalTest(count(LegalTestMailbox::$messages) === 2, 'Zachytené presne dve správy.');
foreach (LegalTestMailbox::$messages as $html) {
    legalTest(str_contains($html, '2026-09-10'), 'Dátum patrí čakajúcej verzii.');
    legalTest(!str_contains($html, '2026-09-17'), 'Aktuálny dátum sa nesmie preliať do staršej verzie.');
    legalTest(!str_contains($html, 'Týždenný newsletter odteraz'), 'Zmena 2.8 nepatrí do verzie 2.7.');
    legalTest(!str_contains($html, 'Webové písmo (Inter)'), 'Staršie zmeny nepatria do verzie 2.7.');
    legalTest(substr_count($html, '<li style="margin:0 0 10px;') === 4, 'E-mail obsahuje štyri relevantné zmeny.');
}
legalTest(processLegalNoticeQueue($pdo)['selected'] === 0, 'Člen nedostane opakovanú správu.');
legalTest(processLegalNoticeSubQueue($pdo)['selected'] === 0, 'Odberateľ nedostane opakovanú správu.');

enqueueLegalChangeNotice($pdo, $current['version'], $current['effectiveDate'], $current['updates']);
legalTest(processLegalNoticeQueue($pdo)['sent'] === 1, 'Člen dostane aktuálnu verziu.');
legalTest(processLegalNoticeSubQueue($pdo)['sent'] === 1, 'Odberateľ dostane aktuálnu verziu.');
foreach (array_slice(LegalTestMailbox::$messages, 2) as $html) {
    legalTest(substr_count($html, '<li style="margin:0 0 10px;') === 1, 'Aktuálny e-mail má jedinú relevantnú zmenu.');
    legalTest(str_contains($html, 'Týždenný newsletter odteraz'), 'Aktuálny e-mail obsahuje zmenu newslettera.');
}
$repeat = enqueueLegalChangeNotice($pdo, $current['version'], $current['effectiveDate'], $current['updates']);
legalTest($repeat['already'], 'Aktuálna verzia sa opakovane nezaradí.');

$snapshot = legalNoticeQueuedVersionInfo([
    'legal_version' => 'future-test', 'effective_date' => '2030-01-01', 'change_summary' => '["Test snapshot"]',
]);
legalTest($snapshot['updates'] === ['Test snapshot'], 'Po rollbacku sa zachová uložený súhrn neznámej verzie.');
foreach ([null, 'broken', '{}', '[42]'] as $invalid) {
    $rejected = false;
    try {
        legalNoticeQueuedVersionInfo(['legal_version' => '2.7', 'change_summary' => $invalid]);
    } catch (RuntimeException | JsonException $e) {
        $rejected = true;
    }
    legalTest($rejected, 'Chybný súhrn nesmie viesť k odoslaniu nesprávnej správy.');
}
echo "Legal notifications: $checks PASS\n";
