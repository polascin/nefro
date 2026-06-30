<?php
/**
 * add_usg-obliciek-mocovych-ciest-brucha_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o tom,
 * ako prebieha USG vyšetrenie obličiek, močových ciest a brucha a ako sa naň
 * pripraviť (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_usg-obliciek-mocovych-ciest-brucha_article.php"
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
    'title'        => 'Ako prebieha USG vyšetrenie obličiek, močových ciest a brucha a ako sa naň pripraviť',
    'slug'         => 'usg-obliciek-mocovych-ciest-brucha',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ultrazvuk je rýchle a nebolestivé vyšetrenie. Poradíme, ako prebieha a ako sa naň pripraviť — kedy treba prísť nalačno a kedy s plným močovým mechúrom.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/impax.png" alt="Nefrologická ambulancia Medimpax v Bratislave-Dúbravke" loading="lazy" decoding="async">
  <figcaption>Nefrologická ambulancia Medimpax, Bratislava-Dúbravka.</figcaption>
</figure>

<p>Ultrazvuk (USG) je bežné, rýchle a <strong>nebolestivé</strong> vyšetrenie bez žiarenia.
V nefrológii pomáha posúdiť obličky, močové cesty aj orgány brucha. V tomto článku vysvetlíme,
ako prebieha a ako sa naň pripraviť — príprava sa totiž líši podľa toho, čo sa vyšetruje.</p>

<h2>Čo je ultrazvuk a prečo sa robí</h2>
<p>Prístroj vysiela neškodné zvukové vlny a z ich odrazu vytvára obraz vnútorných orgánov na
obrazovke. Lekár tak vidí veľkosť a štruktúru obličiek, prípadné kamene, rozšírenie močových
ciest, stav močového mechúra či orgánov brucha (pečeň, žlčník, slezina, pankreas).</p>

<h2>Ako vyšetrenie prebieha</h2>
<ol>
  <li>Pohodlne si ľahnete na vyšetrovacie lôžko a odhalíte vyšetrovanú oblasť.</li>
  <li>Lekár nanesie na kožu <strong>gél</strong> (chvíľu môže byť chladný) a priloží sondu.</li>
  <li>Sondou prechádza po koži a sníma obraz; niekedy vás požiada o <strong>nádych a zadržanie
      dychu</strong> alebo o zmenu polohy.</li>
  <li>Vyšetrenie zvyčajne trvá približne <strong>15–20 minút</strong> a nebolí.</li>
</ol>

<h2>Ako sa pripraviť</h2>
<p>Príprava závisí od toho, čo sa vyšetruje — riaďte sa pokynmi pri objednaní. Vo všeobecnosti:</p>
<ul>
  <li><strong>USG brucha</strong> — príďte <strong>nalačno</strong> (zvyčajne nejedzte približne
      6 hodín pred vyšetrením), aby črevá neboli plné plynu a obraz bol jasný. Vodu si v malom
      množstve spravidla vypiť môžete; lieky berte podľa pokynov lekára.</li>
  <li><strong>USG močových ciest a močového mechúra</strong> — naopak je potrebný
      <strong>plný močový mechúr</strong>. Pred vyšetrením vypite väčšie množstvo vody (napr. 0,5–1 l)
      a <strong>nemočte</strong>, aby bol mechúr naplnený.</li>
  <li><strong>USG obličiek</strong> — často je vhodné prísť nalačno; samotné obličky bývajú dobre
      zobraziteľné aj bez náročnej prípravy.</li>
</ul>
<p>So sebou si vezmite <strong>predošlé nálezy</strong> a výsledky, ak ich máte — pomôžu pri
porovnaní.</p>

<h2>Čo vyšetrenie ukáže (a čo nie)</h2>
<p>Ultrazvuk dobre zobrazí štruktúru orgánov a mnohé zmeny, no nie je univerzálny — niekedy lekár
doplní ďalšie vyšetrenia. Výsledok s vami preberie ošetrujúci lekár v kontexte vašich ostatných
nálezov.</p>

<h2>Kde sa vyšetrenie robí</h2>
<p>Ultrazvukové vyšetrenia obličiek, močových ciest a brucha sú súčasťou
<strong>nefrologickej ambulancie Medimpax</strong> v Bratislave-Dúbravke. Viac na stránke
<a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. Konkrétnu prípravu na vyšetrenie vždy upresní vaše pracovisko.</em></p>
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
                error_log('add_usg_oblicky newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_usg_oblicky pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_usg_oblicky pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_usg_oblicky migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia popularizačného článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
