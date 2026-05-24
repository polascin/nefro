<?php
/**
 * add_glycocalyx_krvny_test_article.php
 * Pridanie článku o krvnom teste na detekciu cievneho poškodenia cez glycocalyx červených krviniek
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nový jednoduchý krvný test má potenciál skoršie odhaliť poškodenie ciev a tým aj riziko srdca a obličiek',
    'slug'         => 'novy-krvny-test-glycocalyx-detekcia-cievneho-poskodenia',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Nový krvný test využívajúci princíp „liquid biopsy" meria stav endotelového glycocalyx prostredníctvom červených krviniek. Ak by sa výsledky z predklinických štúdií potvrdili aj u ľudí, mohol by umožniť skoršiu detekciu cievneho poškodenia spojeného s kardiovaskulárnymi a renálnymi rizikami — ešte pred rozvojom nezvratného orgánového poškodenia.',
    'content'      => <<<'HTML'
<p>Článok z EMJ Reviews opisuje koncept „liquid biopsy" pri vaskulárnom (cievnom) poškodení. Kľúčová myšlienka je, že <strong>červené krvinky</strong> nesú informáciu o stave ochranného cukrovo-proteínového povlaku na vnútornej strane ciev, ktorý sa volá <strong>endotelový glycocalyx</strong>. Ak je tento povlak poškodený, podľa autorov sa to „odzrkadlí" aj v zmenách na glycocalyx červených krviniek.</p>

<p>Sledovanie glycocalyx priamo v cievach je zvyčajne zložité — vyžaduje invazívne alebo náročné zobrazovacie metódy. Krvný test by mohol byť menej invazívnym spôsobom, ako zachytiť poškodenie ciev <strong>skôr</strong>, než sa stihne rozvinúť nezvratné orgánové poškodenie.</p>

<h2>Čo je endotelový glycocalyx a prečo je dôležitý</h2>

<p>Endotelový glycocalyx je tenká vrstva na vnútornej strane ciev, ktorá:</p>

<ul>
  <li>tvorí <strong>permeabilitnú bariéru</strong>,</li>
  <li>pomáha regulovať <strong>zápal</strong> a migráciu imunitných buniek v cievach.</li>
</ul>

<p>Podľa článku sa jeho poškodenie spája s viacerými stavmi vrátane <strong>kardiovaskulárnych ochorení, obličkového poškodenia, diabetu a zápalových ochorení</strong>. Z pohľadu nefrológa je zaujímavé najmä to, že ide o mechanizmus, ktorý môže vysvetľovať, prečo sa cievne poškodenie a progresia CKD alebo akútne renálne zmeny často „ťahajú spolu".</p>

<h2>Kľúčový mechanizmus: glycocalyx sa v tele neustále vymieňa</h2>

<p>Článok uvádza, že výskumný tím vysvetľuje blízke prepojenie glycocalyx červených krviniek a endotelu tým, že:</p>

<ul>
  <li>medzi endotelom a erytrocytmi dochádza ku <strong>kontinuálnej výmene zložiek glycocalyx</strong>,</li>
  <li>takto vzniká „biochemický odtlačok" na cirkulujúcich červených krvinkách, ktorý zodpovedá stavu glycocalyx v cievnej stene.</li>
</ul>

<p>To je prakticky dôvod, prečo by sa teoreticky dalo poškodenie endotelu zachytiť z jednoduchej vzorky krvi.</p>

<h2>Čo zatiaľ vieme a čo ešte nie</h2>

<p>V článku sa uvádza, že dôkazy sú zatiaľ najmä z <strong>experimentov na zvieratách</strong>. Autori prezentujú, že merania z červených krviniek korelovali s:</p>

<ul>
  <li>poškodením glycocalyx v srdci a obličkách,</li>
  <li>nepriamo meranou poruchou bariérovej funkcie ciev.</li>
</ul>

<p>Z nefrologického pohľadu je to povzbudivé, ale zároveň treba triezvo doplniť, že:</p>

<ul>
  <li><strong>ľudské dáta</strong> zatiaľ nemusia byť rovnaké,</li>
  <li>vyšetrenie môže vyžadovať štandardizáciu: čo presne sa meria, aké je referenčné pásmo a ako interpretovať vplyv iných ochorení a liečby.</li>
</ul>

<h2>Praktický význam pre nefrologickú prax (ak by sa test potvrdil)</h2>

<p>Ak by sa tento prístup v humánnych štúdiách osvedčil, v praxi by mohol pomôcť napríklad pri:</p>

<ul>
  <li><strong>skoršej identifikácii rizika</strong> u ľudí s kardiovaskulárnym a renálnym ohrozením — pred zjavným orgánovým poškodením,</li>
  <li><strong>stratifikácii rizika</strong>: kto potrebuje intenzívnejšie nefroprotektívne a kardioprotektívne opatrenia,</li>
  <li>monitorovaní, či liečba <strong>reálne zlepšuje cievnu funkciu</strong> v čase, nielen laboratórne čísla.</li>
</ul>

<p>Zároveň je fér povedať, že bez klinického overenia by bolo predčasné stavať liečbu iba na výsledku takéhoto testu. V najbližšej fáze by mal byť skôr doplnkovým markerom.</p>

<h2>Zhrnutie</h2>

<p>Článok popisuje, že červené krvinky nesú „odtlačok" stavu endotelového glycocalyx. Ak by sa to potvrdilo v ľudských dátach, mohlo by to umožniť <strong>skoršie zachytenie cievneho poškodenia</strong> spojeného s kardiovaskulárnymi a renálnymi rizikami. Zatiaľ však ide hlavne o predklinické výsledky a pred rutinným používaním sú potrebné ďalšie štúdie.</p>

<hr>

<p><em><strong>Zdroj:</strong> EMJ Reviews – „New Blood Test to Revolutionise Heart and Kidney Disease Detection". <a href="https://www.emjreviews.com/nephrology/news/new-blood-test-to-revolutionise-heart-and-kidney-disease-detection/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Upozornenie:</strong> Tento článok bol osobne spracovaný aj s pomocou rozličných nástrojov tzv. umelej inteligencie (AI).</em></p>
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
                error_log('add_glycocalyx_krvny_test_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_glycocalyx_krvny_test_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migracia clanku: Novy krvny test glycocalyx\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Vysledok: $inserted z $total clankov bolo vlozenych.\n";
    echo "Preskoceni (slug uz existuje): $skipped\n";
    echo "Zaradených do fronty aviz:     $queuedTotal\n";
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
      <title>Migrácia – Nový krvný test: glycocalyx a cievne poškodenie</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Nový krvný test: glycocalyx a cievne poškodenie</h2>

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

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
