<?php
/**
 * add_zivot-na-dialyze_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov“ → populars.php):
 * život na dialýze — bežný týždeň, strava, práca, cestovanie (Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_zivot-na-dialyze_article.php"
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
    'title'        => 'Život na dialýze: bežný týždeň, strava, práca a cestovanie',
    'slug'         => 'zivot-na-dialyze',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ako vyzerá bežný týždeň na dialýze, na čo myslieť pri strave a pitnom režime a ako sa dá popri liečbe pracovať aj cestovať.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/zivot-na-dialyze.webp" alt="Infografika: život na dialýze — bežný týždeň, strava a pitný režim, práca, cestovanie, psychika a praktické tipy" loading="lazy" decoding="async">
</figure>

<p>Dialýza je síce pravidelná súčasť života, no neznamená, že sa musíte vzdať toho, čo máte radi.
Mnohí pacienti popri nej pracujú, cestujú a žijú aktívne. V tomto článku zhrnieme, ako taký život
vyzerá a na čo myslieť.</p>

<h2>Bežný týždeň na dialýze</h2>
<p>Pri <strong>hemodialýze</strong> chodíte do strediska spravidla <strong>trikrát týždenne</strong>,
jedno sedenie trvá približne 4–5 hodín. Pri <strong>peritoneálnej dialýze</strong> prebieha liečba
doma — buď ručnými výmenami počas dňa, alebo automaticky v noci. Časom sa z toho stane rutina,
ktorú si zladíte s prácou aj rodinou.</p>

<h2>Strava a pitný režim</h2>
<p>Strava je dôležitou súčasťou liečby. Podľa typu dialýzy a vašich výsledkov vám lekár alebo
nutričný špecialista poradí, na čo si dať pozor — najčastejšie ide o príjem
<strong>tekutín, soli, draslíka a fosforu</strong>. Odporúčania sú individuálne, preto sa riaďte
pokynmi svojho tímu.</p>

<h2>Práca, cestovanie a voľný čas</h2>
<ul>
  <li><strong>Práca</strong> — mnohí pacienti zostávajú zamestnaní; rozvrh dialýz sa dá prispôsobiť.</li>
  <li><strong>Cestovanie</strong> — dovolenka je možná; dialýzu absolvujete v cieľovom mieste
      ako <strong>hosťovskú (dovolenkovú) dialýzu</strong> (vopred dohodnutú).</li>
  <li><strong>Pohyb a záľuby</strong> — primeraná aktivita prospieva; o vhodnej miere sa poraďte
      s lekárom.</li>
</ul>

<h2>Psychika a podpora</h2>
<p>Je úplne normálne prežívať obavy či únavu. Pomáha hovoriť o tom — s rodinou, s personálom
strediska aj s ostatnými pacientmi. Dobrá podpora robí liečbu znesiteľnejšou.</p>

<h2>Praktické tipy</h2>
<ul>
  <li>Veďte si zoznam liekov a noste ho so sebou.</li>
  <li>Dodržiavajte termíny dialýz a kontrol.</li>
  <li>Pýtajte sa — personál vám rád pomôže.</li>
</ul>

<h2>Sme tu pre vás</h2>
<p>O dialyzačnú aj nefrologickú starostlivosť sa stará
<strong>Dialyzačné stredisko a nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke.
Viac na stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. Konkrétne odporúčania (vrátane stravy) vždy určuje váš ošetrujúci lekár.</em></p>
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
                error_log('add_zivot_na_dialyze newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_zivot_na_dialyze pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_zivot_na_dialyze pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_zivot_na_dialyze migration error: ' . $e->getMessage());
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
