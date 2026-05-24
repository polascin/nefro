<?php
/**
 * add_wellness_peptidy_article.php
 * Pridanie článku o bezpečnostných rizikách „wellness" peptidov (upozornenie ISMP a ECRI)
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
    'title'        => '„Wellness" peptidy: chýba spoľahlivé overenie bezpečnosti a účinnosti',
    'slug'         => 'wellness-peptidy-chyba-overenie-bezpecnosti-a-ucinnosti',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Dve organizácie zamerané na bezpečnosť pacientov (ISMP a ECRI) upozorňujú: na trhu „wellness" peptidov chýbajú adekvátne ľudské dáta o bezpečnosti aj účinnosti, produkty pochádzajú z neregulovaných zdrojov s preukázateľnou variabilitou čistoty a kontaminantmi, a pacienti ich môžu používať bez vedomia svojho zdravotníckeho tímu.',
    'content'      => <<<'HTML'
<p>Medscape približuje upozornenie dvoch organizácií zameraných na bezpečnosť pacientov (ISMP a ECRI): na trhu „wellness" peptidov rastie ponuka látok, pri ktorých nie je dostatok údajov z kvalitných ľudských štúdií o <strong>bezpečnosti</strong> ani <strong>účinnosti</strong>. Tieto produkty sa často predávajú bez jasnej regulácie, predpisu a štandardnej kontroly kvality.</p>

<h2>Kľúčové tvrdenia a príklady</h2>

<p>V článku sa uvádza, že mnohé peptidy:</p>

<ul>
  <li><strong>nie sú schválené na ľudské použitie</strong>,</li>
  <li>nemajú adekvátne klinické testovanie,</li>
  <li>často sa propagujú na svalový rast, regeneráciu po zraneniach alebo „immune support".</li>
</ul>

<p>Ako príklady sa spomínajú napríklad <strong>BPC-157</strong>, <strong>TB-500</strong> a <strong>epitalon</strong>, pričom pri niektorých z nich sú podľa článku dostupné dáta v prevažnej miere z <strong>živočíšnych štúdií</strong>, nie z kontrolovaných štúdií u ľudí (napr. bez fázy 1 bezpečnosti alebo dôkazov účinnosti v riadnych štúdiách).</p>

<h2>Bezpečnostné riziká a kvalita produktov</h2>

<p>Článok zdôrazňuje najmä problém neoveriteľnej kvality produktov z „gray market" kanálov:</p>

<ul>
  <li>v publikovaných kontrolách sa uvádzala široká variabilita čistoty,</li>
  <li>niektoré vzorky mali obsah kontaminantov ako <strong>arzén a olovo</strong> nad úrovňami prijateľnými pre injekčné lieky.</li>
</ul>

<p>Autori upozorňujú aj na súvis s predchádzajúcimi kontaminačnými udalosťami pri neregulovaných pripravovaných liekoch, kde došlo k závažným následkom — v článku sa uvádza analógia s epizódou z roku 2012 spojenej s kontamináciou.</p>

<h2>Nežiadúce udalosti hlásené v súvislosti s niektorými peptidmi</h2>

<p>Medscape uvádza, že správy spomínajú vážne nežiadúce udalosti vrátane:</p>

<ul>
  <li><strong>kardiálnych príhod</strong>,</li>
  <li><strong>dysfunkcie obličiek</strong>,</li>
  <li><strong>melanómu</strong>,</li>
  <li><strong>infekcií</strong>.</li>
</ul>

<p>Zámerom upozornenia je, že ide skôr o „bezpečnostnú konverzáciu" než marketingové tvrdenia: cieľom je, aby pacienti vedeli, že pri väčšine „wellness" peptidov chýbajú ľudské dáta, ktoré by umožnili reálne posúdenie rizika a prínosu.</p>

<h2>Čo by mali robiť klinici</h2>

<p>V článku zaznieva, že lekári by mali:</p>

<ul>
  <li><strong>aktívne zisťovať</strong>, odkiaľ pacient peptidy získava a či ich používa,</li>
  <li>sledovať znaky <strong>infekcie</strong>, <strong>imunologických reakcií</strong> a iných neobvyklých symptómov,</li>
  <li>pristupovať k peptidom podobne ako k doplnkom výživy: nie predpokladať, že pacient o tom sám povie.</li>
</ul>

<p>Dôležité je aj upozornenie, že pacienti môžu injekčne aplikovať látky neznámeho obsahu popri predpísaných liekoch, pričom ich zdravotnícky tím o tom nemusí vedieť.</p>

<h2>Zhrnutie pre prax</h2>

<p>„Wellness" peptidy sú podľa článku dostupné v podmienkach, kde nie je overiteľná bezpečnosť ani účinnosť v zmysle kvalitných ľudských dát, a rizikom môže byť aj nečistota alebo kontaminácia z neregulovaných zdrojov. Pri pacientoch je preto kľúčové <strong>aktívne sa zaujímať o ich používanie</strong> a sledovať potenciálne nežiadúce účinky — vrátane dysfunkcie obličiek, ktorá patrí medzi hlásené komplikácie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape – „Wellness Peptides Lack Reliable Safety Information, Watchdog Groups Warn". <a href="https://www.medscape.com/viewarticle/wellness-peptides-lack-reliable-safety-information-watchdog-2026a1000fbf" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

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
                error_log('add_wellness_peptidy_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_wellness_peptidy_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: „Wellness" peptidy – bezpečnosť a účinnosť\n";
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
      <title>Migrácia – „Wellness" peptidy: bezpečnosť a účinnosť</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – „Wellness" peptidy: bezpečnosť a účinnosť</h2>

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
