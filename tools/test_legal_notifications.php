<?php

declare(strict_types=1);

// Iba pamäťová databáza a zachytené e-maily, bez pripojenia k produkcii.
class LegalTestMailbox
{
    /** @var list<string> */
    public static array $messages = [];
    public static bool $failNext = false;
}
function legalNoticeSendOne(string $email, string $subject, string $bodyHtml, bool $plain = false): bool
{
    if (LegalTestMailbox::$failNext) {
        LegalTestMailbox::$failNext = false;
        throw new RuntimeException('fictional-secret: transport failed');
    }
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
class LegalTestPdo extends Pdo\Sqlite
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        return parent::prepare(str_replace('INSERT IGNORE', 'INSERT OR IGNORE', $query), $options);
    }
}

$pdo = new LegalTestPdo('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->createFunction('NOW', static fn (): string => '2026-09-24 00:00:00');
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
legalTest($current['version'] === legalInfo()['version'], 'Aktuálna verzia musí zodpovedať právnym dokumentom.');
legalTest(count(legalRecentUpdates('2.8')) === 1, 'Historická verzia 2.8 obsahuje iba svoju zmenu.');
legalTest(count(legalRecentUpdates()) > count($current['updates']), 'Web zachová aj staršie skupiny zmien.');
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
    legalTest(substr_count($html, '<li style="margin:0 0 10px;') === count($current['updates']), 'Aktuálny e-mail obsahuje presne zmeny svojej verzie.');
    foreach ($current['updates'] as $update) {
        legalTest(str_contains($html, htmlspecialchars($update, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')), 'Aktuálny e-mail obsahuje každú schválenú zmenu.');
    }
    legalTest(!str_contains($html, 'Týždenný newsletter odteraz'), 'Staršia zmena 2.8 nesmie prejsť do aktuálneho e-mailu.');
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
// Chybný snapshot ani výnimka transportu nesmú zablokovať ďalšie položky.
foreach ([false, true] as $transportFailure) {
    $prefix = $transportFailure ? 'synthetic-transport-' : 'synthetic-snapshot-';
    foreach (['bad', 'next'] as $suffix) {
        $version = $prefix . $suffix;
        $summary = !$transportFailure && $suffix === 'bad' ? 'broken' : '["Synthetic update"]';
        $pdo->prepare('INSERT INTO legal_notice_runs VALUES (?, ?, ?, ?, 1, 1)')
            ->execute([$version, '2026-01-01', $summary, '2026-01-01']);
        foreach (['legal_notice_queue' => 'user_id', 'legal_notice_sub_queue' => 'subscriber_id'] as $table => $owner) {
            $pdo->prepare("INSERT INTO $table (legal_version, $owner, email, status, next_attempt_at)
                VALUES (?, 1, 'fixture@example.invalid', 'pending', '2026-01-01')")
                ->execute([$version]);
        }
    }
    foreach (['legal_notice_queue' => 'processLegalNoticeQueue', 'legal_notice_sub_queue' => 'processLegalNoticeSubQueue'] as $table => $processor) {
        LegalTestMailbox::$failNext = $transportFailure;
        $stats = $processor($pdo);
        legalTest($stats['failed'] === 1 && $stats['sent'] === 1, 'Chyba jednej položky nezablokuje ďalšieho príjemcu.');
        $query = $pdo->prepare("SELECT status, attempts, last_error FROM $table WHERE legal_version = ?");
        $query->execute([$prefix . 'bad']);
        $failed = $query->fetch();
        legalTest($failed['status'] === 'failed' && (int) $failed['attempts'] === 1, 'Chybná položka má ohraničený počet retry.');
        legalTest(!str_contains($failed['last_error'], 'fictional-secret'), 'Detail výnimky sa nesmie uložiť do frontu.');
        legalTest($processor($pdo)['selected'] === 0, 'Chybná položka sa neskúša znovu pred retry termínom.');
    }
}

echo "Legal notifications: $checks PASS\n";
