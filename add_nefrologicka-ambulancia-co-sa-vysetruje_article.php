<?php
/**
 * add_nefrologicka-ambulancia-co-sa-vysetruje_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o tom,
 * čo sa vyšetruje a sleduje v nefrologickej ambulancii (klinická a preventívna
 * nefrológia, príprava na dialyzačný program). Podpora strediska Medimpax.
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_nefrologicka-ambulancia-co-sa-vysetruje_article.php"
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
    'title'        => 'Čo sa vyšetruje a sleduje v nefrologickej ambulancii',
    'slug'         => 'nefrologicka-ambulancia-co-sa-vysetruje',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Čo robí nefrologická ambulancia v oblasti klinickej a preventívnej nefrológie a ako pripravuje pacientov na zaradenie do hemodialyzačného programu alebo programu peritoneálnej dialýzy.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/nefrologicka-ambulancia-co-sa-vysetruje.webp" alt="Infografika: čo sa vyšetruje a sleduje v nefrologickej ambulancii" loading="lazy" decoding="async">
</figure>

<p>Nefrologická ambulancia sa stará o <strong>zdravie obličiek</strong> — od včasného záchytu
problémov cez liečbu ochorení až po prípravu na dialýzu, ak je potrebná. V tomto článku
prehľadne vysvetlíme, čo sa v nej vyšetruje a sleduje.</p>

<h2>Klinická nefrológia</h2>
<p>Ide o diagnostiku a liečbu ochorení obličiek. Nefrológ rieši napríklad chronické ochorenie
obličiek (CKD), zápalové ochorenia obličiek, vysoký krvný tlak súvisiaci s obličkami, poruchy
solí a minerálov (elektrolytov) či bielkovinu a krv v moči. Cieľom je <strong>spomaliť
postup ochorenia</strong> a chrániť funkciu obličiek čo najdlhšie.</p>

<h2>Preventívna nefrológia</h2>
<p>Mnohé ochorenia obličiek dlho nebolia a prebiehajú ticho. Preto je dôležité
<strong>včasné odhalenie</strong> u rizikových ľudí — pacientov s cukrovkou, vysokým tlakom,
ochorením srdca alebo s ochorením obličiek v rodine. Pravidelné sledovanie umožní zachytiť
zmeny skôr, než narobia škodu.</p>

<h2>Čo sa typicky vyšetruje a sleduje</h2>
<ul>
  <li><strong>Krvný tlak</strong> — kľúčový pre obličky aj srdce.</li>
  <li><strong>Funkcia obličiek</strong> — kreatinín a vypočítaná glomerulárna filtrácia (eGFR).</li>
  <li><strong>Moč</strong> — najmä bielkovina/albumín v moči (albuminúria) a prítomnosť krvi.</li>
  <li><strong>Soli a minerály</strong> — draslík, sodík, vápnik, fosfor a ďalšie.</li>
  <li><strong>Krvný obraz</strong> — napr. záchyt chudokrvnosti (anémie) pri CKD.</li>
  <li><strong>Ultrazvuk</strong> obličiek, močových ciest a brucha podľa potreby.</li>
</ul>
<p>Výsledky lekár hodnotí v čase — dôležitý je <strong>vývoj</strong>, nielen jedno číslo.</p>

<h2>Príprava na zaradenie do dialyzačného programu</h2>
<p>Ak ochorenie postupuje, ambulancia pripravuje pacienta na <strong>chronický intermitentný
hemodialyzačný program alebo program peritoneálnej dialýzy</strong>. To zahŕňa rozhovor o voľbe metódy
(hemodialýza vs. peritoneálna dialýza), <strong>včasné plánovanie cievneho prístupu alebo PD
katétra</strong>, vysvetlenie priebehu liečby a sprevádzanie pri rozhodovaní. Tam, kde je
vhodná transplantácia, ambulancia zabezpečí vyšetrenia a odoslanie do transplantačného centra.</p>

<h2>Ako prebieha návšteva</h2>
<p>Lekár si prejde vašu anamnézu a doterajšie nálezy, vyšetrí vás, podľa potreby doplní laboratórne
testy alebo ultrazvuk a navrhne ďalší postup. Prineste si <strong>zoznam liekov</strong>, predošlé
výsledky a otázky, ktoré vás zaujímajú.</p>

<h2>Kde nás nájdete</h2>
<p>Klinickú aj preventívnu nefrológiu a prípravu na dialyzačný program poskytuje
<strong>nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke. Viac na stránke
<a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O rozsahu vyšetrení a liečbe vždy rozhoduje ošetrujúci lekár.</em></p>
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
                error_log('add_nefro_ambulancia newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_nefro_ambulancia pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_nefro_ambulancia pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_nefro_ambulancia migration error: ' . $e->getMessage());
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
