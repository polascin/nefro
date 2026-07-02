<?php
/**
 * add_rastlinna-strava-nizsia-mortalita-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_rastlinna-strava-nizsia-mortalita-ckd_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Rastlinná strava a nižšia mortalita u pacientov s CKD: čo z toho využiť v praxi',
    'slug'         => 'rastlinna-strava-nizsia-mortalita-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Multikohortová analýza prezentovaná na 63. kongrese ERA spája prevažne rastlinný stravovací model (najmä Planetary Health Diet) s nižšou celkovou aj renálnou mortalitou u pacientov s CKD. Ide o pozorovaciu štúdiu — nie o dôkaz príčinnej súvislosti — no smer pre prax je čitateľný.',
    'content'      => <<<'HTML'
<p>Na 63. kongrese ERA boli prezentované výsledky multikohortovej analýzy (z databáz NHANES a HCNS), ktorá sledovala, či kvalita stravy súvisí s dlhodobými výsledkami u pacientov s <strong>chronickým ochorením obličiek (CKD)</strong>.</p>

<p>CKD bolo definované ako <strong>eGFR &lt; 60 ml/min/1,73 m²</strong> a/alebo prítomnosť albuminúrie. Celkovo bolo zahrnutých <strong>8 165 dospelých</strong>, pričom medián sledovania trval približne <strong>7 až 8 rokov</strong>.</p>

<h2>Porovnávané stravovacie modely</h2>

<p>Autori porovnávali mieru dodržiavania (adherencie) štyroch stravovacích modelov:</p>

<ul>
  <li><strong>DASH</strong> (Dietary Approaches to Stop Hypertension),</li>
  <li><strong>stredomorská strava</strong> (Mediterranean),</li>
  <li><strong>Planetary Health Diet (PHD)</strong> — strava pre zdravie planéty,</li>
  <li><strong>Inverted Pyramid Diet</strong> — „obrátená potravinová pyramída“.</li>
</ul>

<h2>Hlavné výsledky (mortalita)</h2>

<p>Súvislosť s mortalitou sa zistila pri všetkých hodnotených modeloch, no <strong>najsilnejšia</strong> bola pri <strong>Planetary Health Diet (PHD)</strong>. Každé zvýšenie adherencie o 1 štandardnú odchýlku znamenalo:</p>

<ul>
  <li><strong>o 17 % nižšie riziko úmrtia zo všetkých príčin</strong> (HR 0,83; 95 % CI 0,78–0,89; p &lt; 0,001),</li>
  <li><strong>o 24 % nižšie riziko úmrtia súvisiaceho s obličkami</strong> (HR 0,76; 95 % CI 0,64–0,90; p = 0,001).</li>
</ul>

<p>Aj <strong>DASH</strong> a <strong>stredomorská strava</strong> súviseli s nižšou celkovou mortalitou, no veľkosť účinku bola menšia.</p>

<p>Naopak, <strong>Inverted Pyramid Diet</strong> bola spojená s <strong>horšími výsledkami</strong>:</p>

<ul>
  <li><strong>o 18 % vyššie riziko úmrtia zo všetkých príčin</strong> (HR 1,18; 95 % CI 1,10–1,27; p &lt; 0,001),</li>
  <li><strong>o 32 % vyššie riziko úmrtia súvisiaceho s obličkami</strong> (HR 1,32; 95 % CI 1,12–1,56; p = 0,001).</li>
</ul>

<h2>Čo konkrétne zhoršovalo prognózu</h2>

<p>Ďalšia analýza ukázala, že:</p>

<ul>
  <li><strong>ultraspracované potraviny</strong> tvoriace <strong>aspoň 30 % celkového energetického príjmu</strong> zvyšovali riziko úmrtia o <strong>24 %</strong>,</li>
  <li><strong>vyšší príjem červeného mäsa</strong> (definovaný ako <strong>4 a viac porcií týždenne</strong>) bol spojený s <strong>o 19 % vyšším rizikom úmrtia</strong>.</li>
</ul>

<h2>Praktické ponaučenie pre nefrologickú ambulanciu</h2>

<p>Tento zdroj neponúka liečebný algoritmus „na predpis“, ale dáva praktický smer: pri CKD má zmysel zmysluplne komunikovať <strong>kvalitu stravy</strong>. Najviac logiky dáva podporovať model, ktorý:</p>

<ul>
  <li>je <strong>prevažne rastlinný</strong> a stojí na <strong>minimálne spracovaných</strong> potravinách,</li>
  <li><strong>obmedzuje ultraspracované</strong> produkty,</li>
  <li>a <strong>reálne znižuje príjem červeného mäsa</strong>.</li>
</ul>

<p>Dôležité upozornenie pri interpretácii: ide o <strong>pozorovaciu analýzu</strong> a o kongresový abstrakt — nie teda o dôkaz príčinnej súvislosti. V praxi treba tiež myslieť na to, že pri CKD môže byť problematická individuálna nutričná tolerancia (napr. príjem bielkovín, riziko sarkopénie pri nevhodne „prehnanom“ rastlinnom režime). Najlepšie funguje skríning nutričného stavu a cielené odporúčanie v spolupráci s dietológom.</p>

<hr>

<p><em><strong>Zdroj:</strong> EMJ Reviews (ERA Congress, 2026): „Plant-Based Diet Linked to Lower Mortality in CKD“. <a href="https://www.emjreviews.com/nephrology/news/plant-based-diet-linked-to-lower-mortality-in-ckd-era-2026/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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
      <title>Migrácia článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
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
