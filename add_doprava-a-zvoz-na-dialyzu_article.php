<?php
/**
 * add_doprava-a-zvoz-na-dialyzu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov“ → populars.php):
 * doprava a zvoz na dialýzu (podpora strediska Medimpax).
 *
 * Pozn.: kontakt na organizáciu dopravy smeruje na všeobecné číslo strediska
 * (ambulancia / e-mail), nie na súkromné číslo logistiky.
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_doprava-a-zvoz-na-dialyzu_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Doprava a zvoz na dialýzu: aké sú možnosti',
    'slug'         => 'doprava-a-zvoz-na-dialyzu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pravidelné cesty na hemodialýzu sú dôležitou praktickou témou. Prinášame prehľad možností dopravy vrátane zvozu organizovaného strediskom a ako si ju zariadiť.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/doprava-a-zvoz-na-dialyzu.webp" alt="Infografika: možnosti dopravy a zvozu na dialýzu" loading="lazy" decoding="async">
</figure>

<p>Hemodialýza znamená pravidelné cesty do strediska — najčastejšie trikrát týždenne. Spoľahlivá
doprava preto býva dôležitou praktickou otázkou. V tomto článku zhrnieme, aké sú možnosti a ako si
dopravu zariadiť.</p>

<h2>Možnosti dopravy</h2>
<ul>
  <li><strong>Vlastná doprava</strong> alebo s pomocou rodiny — ak to váš stav dovoľuje.</li>
  <li><strong>Mestská a verejná doprava</strong> — pri dobrej dostupnosti a vhodnom stave.</li>
  <li><strong>Zmluvná sanitná preprava</strong> — pri zdravotnej indikácii ju môže predpísať lekár.</li>
  <li><strong>Zvoz organizovaný strediskom</strong> — spoločná preprava pacientov v rámci spádovej
      oblasti.</li>
</ul>

<h2>Zvoz organizovaný strediskom</h2>
<p>Pre pacientov v spádovej oblasti — vrátane <strong>západnej Bratislavy a Záhoria</strong> — môže
stredisko pomôcť s organizáciou <strong>zvozu</strong> na dialýzu a späť. Konkrétne možnosti
a podmienky závisia od vašej polohy a stavu; najlepšie je vopred sa informovať.</p>

<h2>Ako si dopravu zariadiť</h2>
<ol>
  <li>Poraďte sa so svojím lekárom, ktorá forma dopravy je pre vás vhodná (vrátane prípadnej
      zdravotnej indikácie sanitnej prepravy).</li>
  <li>Informujte sa v stredisku o možnostiach zvozu vo vašej oblasti.</li>
  <li>Dohodnite si časy tak, aby nadväzovali na vaše termíny dialýz.</li>
</ol>

<h2>Tipy</h2>
<ul>
  <li>Plánujte s rezervou — počítajte s časom na cestu pred aj po dialýze.</li>
  <li>Majte záložný plán dopravy pre prípad výpadku.</li>
  <li>Dôležité zmeny v termínoch hláste vopred.</li>
</ul>

<h2>Kontakt a viac informácií</h2>
<p>O možnostiach dopravy a zvozu sa informujte v
<strong>Dialyzačnom stredisku Medimpax</strong> v Bratislave-Dúbravke:</p>
<ul>
  <li>Nefrologická ambulancia: <a href="tel:+421940609480">0940 609 480</a></li>
  <li>E-mail: <a href="mailto:medimpax@impax.sk">medimpax@impax.sk</a></li>
</ul>
<p>Viac na stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. Možnosti a úhradu prepravy posúďte so svojím ošetrujúcim lekárom a poisťovňou.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'popularne', is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_doprava_zvoz newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_doprava_zvoz pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_doprava_zvoz pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_doprava_zvoz migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia popularizačného článku: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia popularizačného článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia popularizačného článku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="populars.php" class="btn-primary">← Späť na sekciu Pre pacientov</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
