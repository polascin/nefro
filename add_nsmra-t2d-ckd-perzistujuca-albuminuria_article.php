<?php
/**
 * add_nsmra-t2d-ckd-perzistujuca-albuminuria_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Postup:
 *   1. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_nsmra-t2d-ckd-perzistujuca-albuminuria_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nefroverzia pre ambulanciu: kedy a ako pridať nesteroidné MRA (nsMRA) u pacienta s T2D a CKD pri perzistujúcej albuminúrii',
    'slug'         => 'nsmra-t2d-ckd-perzistujuca-albuminuria',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-05-30',
    'is_top'       => 0,
    'excerpt'      => 'U pacienta s T2D a CKD s pretrvávajúcou albuminúriou napriek maximálne tolerovanej RAS inhibícii je nsMRA logickým ďalším krokom. Praktický prehľad indikačného rámca, work-upu pred nasadením a ambulantného algoritmu vrátane monitorovania K⁺.',
    'content'      => <<<'HTML'
<p>U pacienta s <strong>diabetom 2. typu (T2D)</strong> a <strong>chronickým ochorením obličiek (CKD)</strong>, ktorý má <strong>pretrvávajúcu albuminúriu napriek maximálne tolerovanej liečbe v osi RAS</strong>, dáva zmysel zvážiť prídavok <strong>nesteroidného antagonistu mineralokortikoidového receptora (nsMRA)</strong>. Výsledkom má byť zlepšenie „cardio-kidney" dopadov a spomalenie nepriaznivého priebehu.</p>

<h2>Indikačný rámec (prakticky)</h2>

<p>Zváž prínos nsMRA, ak sú splnené tieto podmienky:</p>
<ol>
  <li><strong>T2D + CKD</strong></li>
  <li><strong>pretrvávajúca albuminúria</strong></li>
  <li>pacient už dostáva <strong>maximálne tolerovanú liečbu v osi RAS</strong> (ACE inhibítor alebo AT1 blokátor) a albuminúria pretrváva</li>
</ol>
<p>Toto je situácia, kde sa nsMRA považujú za ďalší krok v „treatment pillar" prístupe.</p>

<h2>Rýchly „work-up" pred nasadením</h2>

<p>Skôr než začneš, nastav si kontrolný rámec tak, aby si minimalizoval riziko nežiaducich účinkov (najmä hyperkaliémie) a aby dávalo zmysel aj časovanie kontrol.</p>

<h3>Laboratórny prehľad (pred nasadením)</h3>
<ul>
  <li><strong>kreatinín / eGFR</strong></li>
  <li><strong>draslík (K⁺)</strong></li>
  <li>podľa lokálneho protokolu aj <strong>acidobázická rovnováha</strong> a ďalšie parametre rizika hyperkaliémie</li>
</ul>

<h3>Zhodnoť riziká hyperkaliémie</h3>
<p>V praxi sú to typicky:</p>
<ul>
  <li>vyšší východiskový draslík,</li>
  <li>výraznejšia renálna insuficiencia,</li>
  <li>lieky zvyšujúce draslík (presahy medikácie si skontrolovať),</li>
  <li>stavy s vyšším rizikom dehydratácie (infekcia, vracanie, interkurentné ochorenie).</li>
</ul>

<h2>Algoritmus: ako postupovať v ambulancii</h2>

<h3>Krok A: potvrdíš, že albuminúria pretrváva</h3>
<ul>
  <li>over, že nejde o prechodný stav</li>
  <li>pracuj s trendom (opakované merania, ak máte nastavený systém v poradni)</li>
</ul>

<h3>Krok B: zabezpečíš „core" liečbu</h3>
<p>Títo antagonisti sa zvyčajne pridávajú až vtedy, keď:</p>
<ul>
  <li>RAS inhibícia je už v maximálne tolerovanej podobe,</li>
  <li>ďalšie nefro-metabolické piliere (napr. SGLT2 inhibícia u vhodných pacientov) sú už riešené podľa štandardu starostlivosti.</li>
</ul>

<h3>Krok C: nasadenie nsMRA</h3>
<ul>
  <li>nastav si jasný plán kontrol laboratórií</li>
  <li>pacientovi vysvetli, že ide o liečbu s cieľom nefro-kardiálnej ochrany, ale s potrebou kontroly K⁺</li>
</ul>

<h3>Krok D: kontrola po nasadení</h3>
<p>V praxi sa kontroluje najmä <strong>K⁺ a renálne parametre</strong> krátko po začatí a následne podľa rizika. Presné načasovanie si zosúladíš s lokálnym protokolom a východiskovým rizikom konkrétneho pacienta.</p>

<h3>Krok E: úprava pri nežiaducich účinkoch</h3>
<ul>
  <li>ak K⁺ stúpne, postupuj podľa lokálnych pravidiel (redukcia, dočasné prerušenie, úprava sprievodnej medikácie, riešenie precipitujúcich faktorov)</li>
  <li>dôležité je mať v ambulancii pripravený „plan B", aby sa pacient nedostal do dlhého čakania bez monitorovania</li>
</ul>

<h2>Praktický príklad zo vzdelávacieho materiálu</h2>

<p>V materiáli je uvedený pacient „Mark" (52 rokov) s <strong>T2D a CKD</strong>, ktorý už má:</p>
<ul>
  <li><strong>empagliflozín</strong>,</li>
  <li><strong>ramipril</strong>,</li>
  <li>napriek tomu pretrváva miernejšia proteinúria a rieši sa aj metabolický aspekt (hmotnosť).</li>
</ul>
<p>V rozhodovacom modeli sa potom pridáva:</p>
<ul>
  <li><strong>semaglutid</strong> (metabolický cieľ, úprava hmotnosti),</li>
  <li><strong>finerenone</strong> (nsMRA) ako ďalší krok pri pretrvávajúcej albuminúrii, aj keď je RAS inhibícia už zavedená.</li>
</ul>
<p>Tento príklad ukazuje, že nsMRA je „doplnok do stratégie", nie izolovaný zásah.</p>

<h2>Mechanistické pozadie (pre pochopenie)</h2>

<p>Nadmerná aktivácia MR sa spája s nepriaznivými procesmi v obličkách a srdci. Preto sa nsMRA prezentujú ako lieky, ktoré zasahujú do „škodlivých dráh" pri kardioreálnom prepojení.</p>
<p>Pri ambulantnom vysvetľovaní pacientovi stačí povedať v jednoduchej forme:</p>
<ul>
  <li>liek cieli nepriaznivé signály v tkanivách,</li>
  <li>tým pomáha chrániť obličky aj kardiovaskulárny systém,</li>
  <li>a preto treba kontrolovať draslík.</li>
</ul>

<h2>Záver</h2>

<p>U pacienta s <strong>T2D a CKD</strong> s <strong>perzistujúcou albuminúriou napriek maximálne tolerovanej RAS inhibícii</strong> je <strong>nsMRA</strong> logickým ďalším krokom. Kľúčom k bezpečnej implementácii je vopred nastavený plán kontrol (najmä <strong>K⁺</strong> a renálnych parametrov) a jasná komunikácia s pacientom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Education Cardiology, „The Evolving Role of Nonsteroidal MRAs for Heart and Kidney Disease", uverejnené 30. 5. 2025. <a href="https://www.medscape.org/viewarticle/1002559" target="_blank" rel="noopener noreferrer">https://www.medscape.org/viewarticle/1002559</a>.</em></p>
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
