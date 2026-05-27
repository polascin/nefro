<?php
/**
 * add_cotrimoxazol-vs-fluorochinolony-uti-starsich-neziaduce-ucinky_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Cotrimoxazol pri UTI u starších pacientov častejšie spôsobuje nežiaduce udalosti než fluorochinolóny',
    'slug'         => 'cotrimoxazol-vs-fluorochinolony-uti-starsich-neziaduce-ucinky',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Retrospektívna francúzska štúdia u starších mužov zistila, že cotrimoxazol je pri UTI spojený s dvojnásobne vyšším rizikom nežiaducich udalostí než fluorochinolóny, vrátane akútneho poškodenia obličiek a metabolických porúch.',
    'content'      => <<<'HTML'
<p>Podľa retrospektívnej štúdie z Francúzska u starších mužov s infekciou močových ciest (UTI), ktorí boli liečení <strong>cotrimoxazolom</strong>, bolo zaznamenané približne <strong>dvojnásobne vyššie riziko nežiaducich udalostí (AEs)</strong> v porovnaní s liečbou <strong>fluorochinolónmi</strong>. Zároveň bolo pre nežiaduce účinky častejšie potrebné liečbu ukončiť.</p>

<h2>Ako bola štúdia robená</h2>

<p>Výskumníci analyzovali dáta z <strong>8 nemocníc vo Francúzsku</strong>. Išlo o retrospektívne porovnanie pri UTI u starších mužov liečených fluorochinolónmi vs. cotrimoxazolom v období <strong>2019 až 2023</strong>.</p>
<p>Zahrnutých bolo <strong>228 pacientov</strong> (medián veku <strong>85 rokov</strong>), ktorí počas liečby vyžadovali aspoň <strong>7 dní hospitalizačného alebo interného monitoringu</strong>:</p>
<ul>
    <li><strong>131</strong> dostávalo fluorochinolóny</li>
    <li><strong>97</strong> dostávalo cotrimoxazol</li>
</ul>
<p>Primárny výsledok: výskyt aspoň jednej AEs počas liečby. Sekundárny výsledok: AEs, ktorá viedla k <strong>ukončeniu liečby</strong>.</p>

<h2>Hlavné výsledky</h2>

<p>Nežiaduce udalosti mali výrazne častejšie pacienti na <strong>cotrimoxazole</strong> než tí na fluorochinolónoch:</p>
<ul>
    <li><strong>48,5 % vs 29,7 %</strong> (P = 0,006)</li>
    <li>cotrimoxazol bol spojený s vyšším rizikom AEs: <strong>adjusted OR 2,10</strong> (P = 0,01)</li>
</ul>
<p>Ukončenie liečby kvôli AEs:</p>
<ul>
    <li>celkovo <strong>6,2 %</strong> pacientov</li>
    <li>výrazne častejšie pri cotrimoxazole: <strong>11,3 % vs 2,3 %</strong> (P = 0,009)</li>
</ul>
<p>Najčastejšie AEs boli <strong>akútne poškodenie obličiek (AKI)</strong> a <strong>metabolické poruchy</strong>, ktoré sa vyskytovali signifikantne častejšie v skupine s cotrimoxazolom (P &lt; 0,05).</p>

<h2>Praktický význam</h2>

<p>Autori zdôrazňujú, že výber antibiotika sa nemá opierať len o účinnosť. Pri starších, krehkých pacientoch (frailty, multimorbidita) je často kľúčová <strong>tolerabilita</strong> liečby, aby sa minimalizovalo liekom indukované poškodenie.</p>
<p>Štúdia zároveň upozorňuje, že výsledky odrážajú reálnu klinickú prax a je potrebné ich interpretovať v kontexte retrospektívneho dizajnu.</p>

<h2>Limity</h2>

<ul>
    <li>ide o <strong>observačnú retrospektívnu</strong> štúdiu,</li>
    <li>relatívne <strong>malý počet pacientov</strong>,</li>
    <li>zaradení boli pacienti s vyššou krehkosťou a komorbiditami, čo môže obmedziť zovšeobecniteľnosť.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Medscape. <a href="https://www.medscape.com/viewarticle/cotrimoxazole-tied-more-adverse-effects-than-2026a1000fqo" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
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

          <p style="margin-top:30px;">
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
