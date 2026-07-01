<?php
/**
 * add_transplantacia-oblicky-zaradenie-do-programu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o tom,
 * ako prebieha zaradenie do transplantačného programu na transplantáciu obličky.
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_transplantacia-oblicky-zaradenie-do-programu_article.php"
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
    'title'        => 'Ako prebieha zaradenie do transplantačného programu na transplantáciu obličky',
    'slug'         => 'transplantacia-oblicky-zaradenie-do-programu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Transplantácia je pre mnohých najlepšou formou náhrady funkcie obličiek. Vysvetľujeme, kto môže byť zaradený, aké vyšetrenia to vyžaduje a ako prebieha čakacia listina.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/transplantacia-oblicky-zaradenie-do-programu.webp" alt="Infografika: zaradenie do transplantačného programu na transplantáciu obličky" loading="lazy" decoding="async">
</figure>

<p>Transplantácia obličky je pre mnohých pacientov s pokročilým ochorením obličiek
<strong>často preferovanou formou náhrady ich funkcie</strong> — umožňuje život bez dialýzy alebo
s jej ukončením. Cesta k nej vedie cez dôkladnú prípravu a zaradenie do transplantačného programu.
V tomto článku zrozumiteľne vysvetlíme, ako to prebieha.</p>

<h2>Prečo transplantácia</h2>
<p>Fungujúca darovaná oblička dokáže nahradiť prácu vlastných obličiek lepšie a komplexnejšie
než dialýza. Mnohí pacienti po transplantácii majú vyššiu kvalitu života. Nie je však vhodná
pre každého — vhodnosť posudzuje tím odborníkov.</p>

<h2>Kto môže byť zaradený</h2>
<p>O zaradení rozhoduje <strong>transplantačné centrum</strong> na základe celkového zdravotného
stavu. Posudzuje sa, či je zákrok pre vás bezpečný a prínosný. Niektoré ochorenia alebo riziká
môžu zaradenie odložiť alebo vylúčiť — všetko sa hodnotí individuálne.</p>

<h2>Aké vyšetrenia to vyžaduje</h2>
<p>Pred zaradením absolvujete sadu vyšetrení, ktoré overia, že telo zákrok a následnú liečbu
zvládne. Typicky zahŕňajú:</p>
<ul>
  <li>vyšetrenie srdca a ciev,</li>
  <li>skríning infekcií a onkologický skríning,</li>
  <li>imunologické vyšetrenia a stanovenie krvnej skupiny a tkanivovej typizácie,</li>
  <li>zubné a ďalšie konziliárne vyšetrenia podľa potreby.</li>
</ul>

<h2>Darca: žijúci alebo zosnulý</h2>
<p>Oblička môže pochádzať od <strong>žijúceho darcu</strong> (najčastejšie blízkej osoby, ktorá
prejde vlastným vyšetrením) alebo od <strong>zosnulého darcu</strong>. Pri žijúcom darcovstve
je niekedy možné zákrok naplánovať skôr.</p>

<h2>Čakacia listina</h2>
<p>Po úspešnom posúdení vás transplantačné centrum zaradí na <strong>čakaciu listinu</strong>.
Pri darcovi od zosnulého sa vhodný orgán prideľuje podľa zhody a ďalších kritérií, preto sa
čakanie nedá presne predpovedať. Počas čakania zvyčajne pokračujete v dialyzačnej liečbe
a chodíte na pravidelné kontroly.</p>

<h2>Úloha nefrológa a dialyzačného strediska</h2>
<p>Samotnú transplantáciu vykonáva špecializované transplantačné centrum, no <strong>cesta k nej
začína u nefrológa</strong>. Nefrologická ambulancia s vami preberie možnosť transplantácie,
zabezpečí potrebné vyšetrenia, pripraví dokumentáciu a <strong>odošle vás do transplantačného
centra</strong>. Sprevádza vás aj počas čakania.</p>

<h2>Kde sa pripraviť</h2>
<p>Prípravu a odoslanie do transplantačného programu, ako aj nefrologickú a dialyzačnú
starostlivosť, poskytuje <strong>nefrologická ambulancia a Dialyzačné stredisko Medimpax</strong>
v Bratislave-Dúbravke. Viac na stránke
<a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O vhodnosti a zaradení do transplantačného programu rozhoduje transplantačné centrum
v spolupráci s vaším ošetrujúcim lekárom.</em></p>
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
                error_log('add_transplantacia_oblicky newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_transplantacia_oblicky pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_transplantacia_oblicky pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_transplantacia_oblicky migration error: ' . $e->getMessage());
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
