<?php
/**
 * add_dress-alopurinol-granulomatozna-ain-pankreatitida_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_dress-alopurinol-granulomatozna-ain-pankreatitida_article.php"
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
    'title'        => 'DRESS syndróm po alopurinole: diagnostická pasca granulomatóznej intersticiálnej nefritídy s pankreatitídou',
    'slug'         => 'dress-alopurinol-granulomatozna-ain-pankreatitida',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kazuistika ťažkého DRESS syndrómu po alopurinole komplikovaného granulomatóznou akútnou intersticiálnou nefritídou a akútnou pankreatitídou. Ukazuje, prečo má v diagnosticky neprehľadných situáciách s konkurujúcimi príčinami AKI rozhodujúcu hodnotu renálna biopsia.',
    'content'      => <<<'HTML'
<p>DRESS syndróm (Drug Reaction with Eosinophilia and Systemic Symptoms, lieková reakcia s eozinofíliou a systémovými príznakmi) je zriedkavá, no potenciálne život ohrozujúca oneskorená hypersenzitívna reakcia. Alopurinol patrí medzi jej najčastejšie spúšťače, pričom renálne postihnutie býva v rámci DRESS pomerne časté — najčastejšie vo forme akútnej intersticiálnej nefritídy (AIN). V bežnej praxi však DRESS môže maskovať alebo napodobňovať infekčné, autoimunitné či metabolické stavy, najmä ak sa pridruží ďalšia komplikácia.</p>

<p>Nasledujúca kazuistika je cenná tým, že ukazuje kombináciu, ktorá robí diagnostiku mimoriadne zložitou: <strong>granulomatózna AIN</strong> spolu s <strong>akútnou pankreatitídou</strong> po alopurinole, doplnená o neurologické prejavy.</p>

<h2>Klinický obraz, ktorý by mal mať nefrológ na pamäti</h2>

<p>V opísanom prípade 71-ročný muž:</p>

<ul>
  <li>začal užívať alopurinol 3 týždne pred hospitalizáciou,</li>
  <li>prišiel s <strong>horúčkou</strong>, <strong>difúznou morbiliformnou vyrážkou</strong> (bez postihnutia slizníc), <strong>poruchou vedomia</strong>, celkovou slabosťou a brušnými ťažkosťami,</li>
  <li>laboratórne mal <strong>akútnu progresiu obličkového poškodenia (AKI)</strong>, <strong>výraznú eozinofíliu</strong>, <strong>hepatocelulárne poškodenie</strong> a <strong>veľmi vysokú hladinu lipázy</strong>,</li>
  <li>zobrazovacie vyšetrenie potvrdilo <strong>akútnu pankreatitídu</strong> bez jasnej biliárnej príčiny.</li>
</ul>

<p>Infekčné ani autoimunitné vyšetrenia neviedli k jednoznačnému vysvetleniu. Práve tu vzniká typický podnet na diagnostickú skratku: pankreatitídu, horúčku a zhoršenie funkcie obličiek by bolo možné pripísať sepse, komplikácii akútneho zápalu, dehydratácii, záťaži kontrastnou látkou alebo inej príčine. Autori však zdôrazňujú, že celkové zoskupenie príznakov — časová väzba na liek, vyrážka, eozinofília, multiorgánové postihnutie, hepatopatia a AKI — zvyšuje pravdepodobnosť DRESS.</p>

<h2>Prečo bola biopsia kľúčová</h2>

<p>Napriek vysadeniu alopurinolu hladina kreatinínu naďalej stúpala. V situácii s viacerými možnými etiologickými mechanizmami (pankreatitída, systémový zápal, možné poškodenie asociované s kontrastnou látkou, lieková nefritída) sa nefrológovia rozhodli pre <strong>renálnu biopsiu</strong>.</p>

<p>Histológia preukázala:</p>

<ul>
  <li><strong>granulomatóznu intersticiálnu nefritídu</strong>,</li>
  <li>infiltrát s <strong>bohatým zastúpením eozinofilov</strong>,</li>
  <li>tubulitídu, intersticiálny edém a granulomatóznu prestavbu,</li>
</ul>

<p>čo podporilo diagnózu <strong>liekom indukovanej AIN ako súčasti DRESS</strong>. Autori zároveň upozorňujú, že granulomatózny variant býva menej typický a môže diagnózu ešte viac zastrieť.</p>

<h2>Úloha HHV-6 v DRESS</h2>

<p>V kazuistike sa potvrdila reaktivácia ľudského herpetického vírusu 6 (<strong>HHV-6</strong>, pozitívny HHV-6 PCR). Reaktivácia HHV-6 sa v rámci DRESS uvádza približne u šiestich z desiatich pacientov a býva spojená so závažnejším priebehom, dlhším trvaním a vyšším rizikom multiorgánového zlyhávania. V tomto prípade zapadla do „ťažkej“ prezentácie s neurologickými príznakmi.</p>

<h2>Liečba a klinická odpoveď</h2>

<p>Základ manažmentu predstavovali:</p>

<ol>
  <li><strong>okamžité vysadenie alopurinolu</strong>,</li>
  <li><strong>systémové glukokortikoidy</strong> pri stredne ťažkom až ťažkom orgánovom postihnutí.</li>
</ol>

<p>Po nasadení vysokodávkových kortikosteroidov došlo k:</p>

<ul>
  <li>zlepšeniu mentálneho stavu,</li>
  <li>postupnému ústupu vyrážky (vrátane deskvamácie),</li>
  <li>normalizácii eozinofílie,</li>
  <li>stabilizácii a následnému zlepšeniu funkcie obličiek,</li>
  <li>ústupu pankreatitídy v rámci podporných opatrení.</li>
</ul>

<p>Pri DRESS je dôležité mať na pamäti, že hoci sa funkcia obličiek pri včasnej liečbe často zlepší, pri ťažkých formách môže pretrvávať neúplné zotavenie alebo prechod do chronického poškodenia.</p>

<h2>Praktické ponaučenia pre nefrológa</h2>

<h3>1) Na DRESS myslieť aj vtedy, keď to „vyzerá“ ako infekcia alebo iný akútny syndróm</h3>

<p>Ak sa objaví horúčka, difúzna vyrážka, eozinofília, hepatopatia a AKI s časovým odstupom 2 až 6 týždňov od začatia rizikového lieku, treba mať DRESS vysoko v diferenciálnej diagnostike.</p>

<h3>2) Pri multietiologickom AKI neváhať s biopsiou</h3>

<p>V tejto kazuistike biopsia odstránila diagnostickú neistotu. Platí princíp: ak sa AKI zhoršuje a etiológia je neistá, histologický dôkaz liekovej AIN môže urýchliť správnu imunomodulačnú liečbu a zabrániť zbytočným diagnostickým zdržaniam.</p>

<h3>3) Pri alopurinole u pacientov s CKD začínať opatrne a monitorovať</h3>

<p>Alopurinol sa síce používa aj u pacientov s chronickým ochorením obličiek (CKD), no riziko hypersenzitivity je u nich vyššie. Odporúča sa začínať nízkou dávkou (napr. do 100 mg denne, pri CKD ešte nižšie) s pomalou titráciou a intenzívnym dohľadom počas prvých týždňov. U vysokorizikových etník treba podľa platných odporúčaní zvážiť skríning alely <strong>HLA-B*58:01</strong>.</p>

<h2>Záver</h2>

<p>Ide o kazuistiku ťažkého alopurinolom indukovaného DRESS syndrómu komplikovaného granulomatóznou AIN a akútnou pankreatitídou. Správne rozpoznanie syndrómu, skoré vysadenie spúšťajúceho lieku a promptné podanie kortikosteroidov viedli k výraznému klinickému zlepšeniu a takmer úplnému obnoveniu funkcie obličiek. V diagnosticky neprehľadných situáciách s konkurujúcimi príčinami AKI má <strong>renálna biopsia</strong> rozhodujúcu hodnotu.</p>

<hr>

<p><em><strong>Zdroj:</strong> <em>Cureus</em> (2026): „A Nephrologist’s Dilemma: Severe Granulomatous Acute Interstitial Nephritis (AIN) and Pancreatitis From Allopurinol-Induced Drug Reaction With Eosinophilia and Systemic Symptoms (DRESS)“. DOI: 10.7759/cureus.110797. <a href="https://www.cureus.com/articles/502947-a-nephrologists-dilemma-severe-granulomatous-acute-interstitial-nephritis-ain-and-pancreatitis-from-allopurinolinduced-drug-reaction-with-eosinophilia-and-systemic-symptoms-dress" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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
