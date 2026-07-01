<?php
/**
 * add_co-je-dialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php):
 * základné vysvetlenie, čo je dialýza (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_co-je-dialyza_article.php"
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
    'title'        => 'Čo je dialýza a kedy je potrebná',
    'slug'         => 'co-je-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Jednoduché vysvetlenie, čo je dialýza, aké sú jej dva hlavné druhy, kedy je potrebná a čo znamená pre bežný život.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/co-je-dialyza.webp" alt="Infografika: čo je dialýza — zdravá funkcia obličiek, ich zlyhanie, hemodialýza v centre a peritoneálna dialýza doma" loading="lazy" decoding="async">
</figure>

<p>Slovo „dialýza" znie pre mnohých ľudí znepokojivo. V skutočnosti ide o liečbu, ktorá za
zlyhávajúce obličky preberá ich najdôležitejšiu úlohu — čistiť krv. V tomto článku jednoducho
vysvetlíme, čo dialýza je a kedy je potrebná.</p>

<h2>Čo robia obličky a čo je dialýza</h2>
<p>Zdravé obličky odstraňujú z krvi odpadové látky a prebytočnú vodu, udržiavajú rovnováhu solí
a podieľajú sa na ďalších dôležitých funkciách. Keď ich funkcia výrazne poklesne, tieto látky sa
v tele hromadia. <strong>Dialýza</strong> je liečba, ktorá ich z tela odstraňuje namiesto obličiek.</p>

<h2>Dva hlavné druhy dialýzy</h2>
<ul>
  <li><strong>Hemodialýza (HD)</strong> — krv sa čistí mimo tela cez prístroj, najčastejšie
      v dialyzačnom stredisku trikrát týždenne.</li>
  <li><strong>Peritoneálna dialýza (PD)</strong> — prebieha doma, využíva sa pri nej vlastná
      brušná blana (pobrušnica); môže byť ručná (CAPD) alebo automatizovaná v noci (APD).</li>
</ul>
<p>Obe metódy sú plnohodnotné. Ktorá je pre vás vhodnejšia, posúdi nefrológ spolu s vami.</p>

<h2>Kedy je dialýza potrebná</h2>
<p>Dialýza prichádza na rad pri <strong>pokročilom zlyhaní obličiek</strong>, keď už ich funkcia
nestačí. O správnom čase rozhoduje lekár podľa vašich výsledkov a príznakov — nie podľa jediného
čísla, ale podľa celkového stavu. Niekedy je potrebná dočasne (napr. pri náhlom zlyhaní obličiek),
inokedy dlhodobo.</p>

<h2>Znamená dialýza koniec bežného života?</h2>
<p>Nie. Mnohí ľudia na dialýze pracujú, cestujú a venujú sa svojim záľubám. Liečba sa stáva
súčasťou rutiny a s dobrou prípravou a podporou tímu sa dá zvládnuť.</p>

<h2>Kde sa o dialýzu postaráme</h2>
<p>Hemodialýzu, peritoneálnu dialýzu aj nefrologickú starostlivosť poskytuje
<strong>Dialyzačné stredisko a nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke.
Viac na stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O potrebe a podobe liečby vždy rozhoduje ošetrujúci lekár.</em></p>
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
                error_log('add_co_je_dialyza newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_co_je_dialyza pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_co_je_dialyza pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_co_je_dialyza migration error: ' . $e->getMessage());
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
