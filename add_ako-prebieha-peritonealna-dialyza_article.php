<?php
/**
 * add_ako-prebieha-peritonealna-dialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov“ → populars.php) o tom,
 * ako prebieha peritoneálna dialýza a príprava na ňu (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ako-prebieha-peritonealna-dialyza_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/article_publisher.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Ako prebieha peritoneálna dialýza a príprava na ňu',
    'slug'         => 'ako-prebieha-peritonealna-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Peritoneálna dialýza prebieha doma. Vysvetľujeme, ako funguje, aký je rozdiel medzi CAPD a APD, ako vyzerá výmena a ako sa na liečbu pripraviť.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/ako-prebieha-peritonealna-dialyza.webp" alt="Infografika: peritoneálna dialýza — princíp, výmena roztoku, CAPD a APD a príprava na liečbu" loading="lazy" decoding="async">
</figure>

<p>Peritoneálna dialýza (PD) je metóda dialýzy, ktorá prebieha <strong>doma</strong> a dáva vám
väčšiu nezávislosť. V tomto článku jednoduchým jazykom vysvetlíme, ako funguje a ako sa na ňu
pripraviť.</p>

<h2>Čo je peritoneálna dialýza</h2>

<p>Na čistenie krvi využíva vašu vlastnú <strong>pobrušnicu</strong> (tenkú blanu vystielajúcu
brušnú dutinu). Cez tenkú hadičku — <strong>PD katéter</strong> — sa do brucha napustí čistý
dialyzačný roztok. Ten počas niekoľkých hodín „nasáva“ odpadové látky a prebytočnú vodu z krvi.
Potom sa použitý roztok vypustí a nahradí čerstvým. Tomuto cyklu sa hovorí <strong>výmena</strong>.</p>

<h2>CAPD a APD — dve formy</h2>
<ul>
  <li><strong>CAPD</strong> (kontinuálna ambulantná PD) — výmeny robíte <strong>ručne</strong>
      niekoľkokrát denne, sami, bez prístroja.</li>
  <li><strong>APD</strong> (automatizovaná PD) — výmeny za vás v noci vykonáva malý prístroj
      (<strong>cykler</strong>), kým spíte. Cez deň ste voľnejší.</li>
</ul>
<p>Niektoré strediská umožňujú aj <strong>vzdialené sledovanie</strong> liečby, takže nefrológ
vidí priebeh a môže program upraviť na diaľku.</p>

<h2>Ako vyzerá výmena</h2>
<ol>
  <li><strong>Napustenie.</strong> Čistý roztok natečie cez katéter do brušnej dutiny.</li>
  <li><strong>Prebývanie.</strong> Roztok zostáva v bruchu niekoľko hodín a čistí krv.</li>
  <li><strong>Vypustenie.</strong> Použitý roztok sa vypustí a nahradí čerstvým.</li>
</ol>
<p>Výmena je nebolestivá; po zaškolení ju zvládnete sami v pohodlí domova.</p>

<h2>PD katéter a príprava</h2>
<p>Pred začatím liečby sa drobným zákrokom zavedie <strong>PD katéter</strong> do brucha. Miesto
sa nechá zahojiť a vy aj vaši blízki absolvujete <strong>zaškolenie</strong> — naučíte sa robiť
výmeny správne a hygienicky.</p>

<h2>Na čo myslieť</h2>
<ul>
  <li><strong>Hygiena je kľúčová</strong> — dôsledná čistota pri výmenách znižuje riziko infekcie
      (zápalu pobrušnice).</li>
  <li>Potrebujete doma miesto na skladovanie roztokov a pomôcok.</li>
  <li>Pravidelne chodíte na kontroly do nefrologickej ambulancie.</li>
</ul>

<h2>Kde poskytujeme peritoneálnu dialýzu</h2>
<p>Peritoneálnu dialýzu (CAPD aj APD) s edukáciou a podporou poskytuje
<strong>Dialyzačné stredisko a nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke.
Viac nájdete na stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O vhodnosti a podobe liečby vždy rozhoduje ošetrujúci lekár.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'popularne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

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
