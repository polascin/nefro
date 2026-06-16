<?php
/**
 * add_domaca-dialyza-100-pacientov-treningovy-model_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_domaca-dialyza-100-pacientov-treningovy-model_article.php"
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
    'title'        => 'Sto pacientov na domácej dialýze: model tréningu a domáceho monitorovania liečby',
    'slug'         => 'domaca-dialyza-100-pacientov-treningovy-model',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Clínic Barcelona dosiahol 100 pacientov na domácej dialýze a konsoliduje model tréningu a domáceho monitorovania. Úspech domácich modalít stojí menej na technike a viac na organizačných pilieroch — spojitom tréningu, zdieľanej infraštruktúre pre PD aj domácu HD a aktívnej edukácii.',
    'content'      => <<<'HTML'
<p>Nemocnica Clínic Barcelona informuje, že dosiahla <strong>100 pacientov na domácej dialýze</strong> a zároveň konsoliduje priekopnícky model <strong>tréningu a domáceho monitorovania</strong>. Cieľom je urobiť z domácej liečby bezpečnú, efektívnu a do bežného života integrovanú alternatívu.</p>

<h2>Aktuálne počty a trend rastu</h2>

<p>Jednotka sa stará o:</p>

<ul>
  <li><strong>80 pacientov na peritoneálnej dialýze (PD)</strong>,</li>
  <li><strong>20 pacientov na domácej hemodialýze (domáca HD)</strong>.</li>
</ul>

<p>Rast bol výrazný najmä v posledných dvoch rokoch:</p>

<ul>
  <li>PD: zo <strong>40 na 80</strong> pacientov (od decembra 2023),</li>
  <li>domáca HD: zo <strong>14 na 20</strong> pacientov (nárast o <strong>43 %</strong>),</li>
  <li>v roku <strong>2025</strong> začalo domácu liečbu <strong>61 ľudí</strong> (50 PD, 11 domáca HD),</li>
  <li>v roku <strong>2026</strong> doteraz pribudlo ďalších <strong>42</strong>.</li>
</ul>

<p>Celkovo jednotka v roku 2025 ošetrila <strong>120 pacientov</strong> a v roku 2026 už <strong>128 pacientov</strong>.</p>

<h2>Kľúčový organizačný prvok</h2>

<p>Najdôležitejšou zmenou je otvorenie <strong>novej infraštruktúry pre domácu dialýzu</strong> (na ulici Carrer Manso), navrhnutej špecificky na:</p>

<ul>
  <li><strong>tréning pacientov</strong>,</li>
  <li><strong>monitorovanie počas domácej liečby</strong>.</li>
</ul>

<p>V tomto priestore spolunažívajú obe modality — domáca hemodialýza aj peritoneálna dialýza. Tím dokáže <strong>trénovať pacientov pre obe techniky</strong> a umožňuje vzájomné učenie: pacienti si môžu vymieňať skúsenosti a strácajú počiatočné obavy. V praxi to znižuje bariéry a pomáha budovať dôveru v sebaobsluhu.</p>

<h2>Úloha sestier a domácej podpory</h2>

<p>Projekt stojí najmä na tom, že ošetrovateľský tím:</p>

<ul>
  <li>vedie tréning v centre,</li>
  <li>zároveň poskytuje <strong>podporu a tréning priamo v domácnosti</strong>,</li>
  <li>a tým udržiava bezpečnosť a adaptáciu počas celého procesu, nielen v úvodnej fáze.</li>
</ul>

<h2>Prepojenie na širšiu stratégiu zdravotnej starostlivosti</h2>

<p>Nemocnica spája tento míľnik so strategickými dokumentmi (CKD a stratégie manažmentu chronických ochorení), kde sa kladie dôraz na:</p>

<ul>
  <li><strong>sebastarostlivosť</strong> (self-care),</li>
  <li><strong>edukačné programy</strong>,</li>
  <li><strong>spoločné rozhodovanie s pacientom</strong>.</li>
</ul>

<h2>Praktické ponaučenie</h2>

<p>Ak sa na domáce modality hľadí len ako na „zariadenie a techniku“, implementácia často zlyháva. Tento model je dobrým príkladom toho, že úspech stojí na organizačných pilieroch:</p>

<ol>
  <li><strong>centralizovaný tréning a následná domáca podpora ako jedna kontinuita</strong>, nie oddelené fázy,</li>
  <li><strong>spoločná infraštruktúra pre PD aj domácu HD</strong>, ktorá zvyšuje flexibilitu a psychologickú prijateľnosť,</li>
  <li><strong>aktívna edukácia a budovanie dôvery</strong>, aby pacient liečbu zvládol dlhodobo v reálnom živote.</li>
</ol>

<hr>

<p><em><strong>Zdroj:</strong> Clínic Barcelona (2026): „The Clínic Reaches 100 Patients on Home Dialysis and Consolidates a Pioneering Model of Training and Home Monitoring“. <a href="https://www.clinicbarcelona.org/en/news/the-clinic-reaches-100-patients-on-home-dialysis-and-consolidates-a-pioneering-model-of-training-and-home-monitoring" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
