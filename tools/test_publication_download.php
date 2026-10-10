<?php

declare(strict_types=1);

require_once __DIR__ . '/../publications_common.php';

// Pamäťová SQLite používa skutočný podmienený UPDATE, bez produkčných údajov.
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->sqliteCreateFunction('NOW', static fn (): string => '2026-10-04 12:00:00');
$pdo->exec('CREATE TABLE publication_orders (id INTEGER PRIMARY KEY, status TEXT,
    access_expires_at TEXT, download_count INTEGER, last_download_at TEXT, last_download_format TEXT)');
$pdo->exec("INSERT INTO publication_orders VALUES (1, 'paid', '2026-10-05 12:00:00', 39, NULL, NULL)");

$checks = 0;
function publicationDownloadTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

publicationDownloadTest(recordPublicationDownload($pdo, 1, 'pdf'), 'Posledné povolené stiahnutie musí prejsť.');
publicationDownloadTest(!recordPublicationDownload($pdo, 1, 'epub'), 'Ďalšia požiadavka nesmie prekročiť limit.');
$row = $pdo->query('SELECT * FROM publication_orders WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
publicationDownloadTest((int) $row['download_count'] === 40 && $row['last_download_format'] === 'pdf', 'Odmietnutie nesmie meniť počítadlo ani posledný formát.');

$pdo->exec("UPDATE publication_orders SET download_count = 0, status = 'cancelled' WHERE id = 1");
publicationDownloadTest(!recordPublicationDownload($pdo, 1, 'pdf'), 'Zrušenie medzi načítaním a rezerváciou musí zablokovať prenos.');
$pdo->exec("UPDATE publication_orders SET status = 'awaiting_payment' WHERE id = 1");
publicationDownloadTest(!recordPublicationDownload($pdo, 1, 'pdf'), 'Neuhradená objednávka nesmie prejsť.');
$pdo->exec("UPDATE publication_orders SET status = 'paid', access_expires_at = '2026-10-04 11:59:59' WHERE id = 1");
publicationDownloadTest(!recordPublicationDownload($pdo, 1, 'pdf'), 'Vypršaný prístup nesmie prejsť.');
$pdo->exec("UPDATE publication_orders SET access_expires_at = '2026-10-04 12:00:00' WHERE id = 1");
publicationDownloadTest(recordPublicationDownload($pdo, 1, 'pdf'), 'Hraničný čas platnosti musí byť konzistentný.');
$pdo->exec('UPDATE publication_orders SET access_expires_at = NULL WHERE id = 1');
publicationDownloadTest(recordPublicationDownload($pdo, 1, 'epub'), 'Prístup bez dátumu expirácie zostáva povolený.');
publicationDownloadTest(!recordPublicationDownload($pdo, 999, 'pdf'), 'Neexistujúca objednávka nesmie prejsť.');

publicationDownloadTest(
    normalizePublicationFormats(['formats' => ['pdf', 'epub']], [' EPUB ', ['pdf'], null, 1, 'pdf', 'pdf', 'unknown']) === ['pdf', 'epub'],
    'Vnorené a neplatné hodnoty nesmú vyvolať chybu; poradie a jedinečnosť určuje katalóg.'
);

$freeDownloadSource = (string) file_get_contents(__DIR__ . '/../download_free_publication.php');
publicationDownloadTest(
    str_contains($freeDownloadSource, "REQUEST_METHOD'] ?? 'GET') !== 'GET'")
        && str_contains($freeDownloadSource, "header('Allow: GET')"),
    'Bezplatný download endpoint povoľuje iba GET a oznamuje povolenú metódu.',
);
$robots = (string) file_get_contents(__DIR__ . '/../robots.txt');
publicationDownloadTest(
    str_contains($robots, 'Disallow: /download_free_publication.php'),
    'Binárny download endpoint je vylúčený z indexovania.',
);

echo "Publication download: $checks checks PASS\n";
