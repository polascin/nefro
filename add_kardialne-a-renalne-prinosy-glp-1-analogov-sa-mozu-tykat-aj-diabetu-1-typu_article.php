<?php
/**
 * add_kardialne-a-renalne-prinosy-glp-1-analogov-sa-mozu-tykat-aj-diabetu-1-typu_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Kardiálne a renálne prínosy GLP-1 analógov sa môžu týkať aj diabetu 1. typu',
    'slug'         => 'kardialne-a-renalne-prinosy-glp-1-analogov-sa-mozu-tykat-aj-diabetu-1-typu',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Emulácia klinického skúšania na observačných dátach ukázala, že GLP-1 receptorové agonisty môžu znižovať riziko závažných kardiovaskulárnych udalostí aj terminálneho zlyhania obličiek u pacientov s diabetom 1. typu, bez zvýšenia rizika DKA alebo ťažkej hypoglykémie.',
    'content'      => <<<'HTML'
<p>V cielenej emulácii klinického skúšania sa ukázalo, že u ľudí s <strong>diabetom 1. typu (T1D)</strong> dodatočné užívanie <strong>GLP-1 receptorových agonistov (GLP-1RAs)</strong> bolo spojené s nižším rizikom <strong>závažných kardiovaskulárnych udalostí (MACE)</strong> aj <strong>progresie do terminálneho zlyhania obličiek (ESKD)</strong>. Súčasne sa nepozoroval nárast rizika <strong>diabetickej ketoacidózy (DKA)</strong> ani <strong>ťažkej hypoglykémie</strong>.</p>

<h2>Prečo sa to riešilo</h2>

<p>Autori zdôrazňujú, že ľudia s T1D majú zvýšené riziko kardiovaskulárnych aj obličkových komplikácií, ale v kľúčových randomizovaných štúdiách, ktoré viedli k odporúčaniam u T2D, boli často <strong>systematicky vylúčení</strong>.</p>
<p>Podľa článku je testovanie GLP-1RAs v T1D v podobe klasických RCT náročné pre mladší vek populácie a nižšiu incidenciu udalostí.</p>

<h2>Ako štúdia prebiehala (emulácia „target trial")</h2>

<p>Výskumníci navrhli štúdiu tak, aby čo najviac napodobnila randomizované skúšanie, a použili pozorovacie dáta z databázy <strong>Optum Labs Data Warehouse</strong>.</p>
<ul>
    <li>Celkovo: <strong>174 678</strong> osôb s T1D</li>
    <li>GLP-1RA iniciovalo: <strong>14 488</strong></li>
    <li>Medián sledovania: <strong>38 mesiacov</strong></li>
</ul>

<h2>Hlavné výsledky</h2>

<p>V „intention-to-treat" analýze:</p>
<ul>
    <li><strong>MACE:</strong> 5-ročné riziko <strong>4,3 %</strong> u iniciátorov GLP-1RAs vs <strong>5,0 %</strong> u neiniciátorov (signifikantný rozdiel, približne <strong>15 % relatívne</strong> menej)</li>
    <li><strong>ESKD:</strong> 5-ročné riziko <strong>1,6 %</strong> vs <strong>1,9 %</strong> (tiež signifikantné, približne <strong>19 % relatívne</strong> menej)</li>
</ul>
<p>Účinok bol podľa autorov porovnateľný s veľkosťou zníženia rizika pozorovanou v štúdiách u T2D.</p>

<h3>Sekundárne výsledky</h3>
<ul>
    <li>Zníženie hospitalizácií pre <strong>srdcové zlyhávanie</strong> približne o <strong>18 %</strong></li>
    <li>Zníženie <strong>major adverse liver events</strong> približne o <strong>28 %</strong></li>
    <li>Väčší podiel pacientov dosiahol <strong>chudnutie</strong> o 5 %, 10 % a 15 %</li>
</ul>

<h2>Bezpečnosť: DKA a hypoglykémia bez signálneho zvýšenia</h2>

<p>U iniciátorov GLP-1RAs sa nepozorovalo zvýšenie hospitalizácií pre <strong>DKA</strong> ani pre <strong>ťažkú hypoglykémiu</strong>.</p>
<p>Autori to interpretujú v kontexte toho, že v reálnej praxi môže bezpečnosť podporovať širšie používanie technológií (napr. monitorovanie glykémie a modernejšie dávkovanie inzulínu), spolu so správnym výberom pacientov a dôsledným sledovaním.</p>

<h3>Nežiaduce účinky</h3>
<ul>
    <li><strong>Gastrointestinálne príznaky</strong> sa vyskytovali častejšie, ale rozdiel nebol štatisticky jednoznačne významný.</li>
    <li>Výsledky boli konzistentné naprieč podskupinami podľa veku (&lt;45 vs ≥45 rokov) aj podľa východiskového A1c (&lt;8 % vs ≥8 %).</li>
</ul>

<h2>Čo z toho vyvodiť prakticky</h2>

<p>Tento výsledok je zaujímavý najmä preto, že u T1D ide o populáciu, ktorá bola dlho mimo veľkých RCT zameraných na kardiálne a renálne benefity GLP-1RAs.</p>
<p>Zároveň treba počítať s tým, že ide o <strong>emuláciu target trial</strong> na observačných dátach. Preto je namieste opatrnosť a pokračovanie overovania vo <strong>veľkých randomizovaných skúšaniach</strong> priamo v populácii T1D.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape. <a href="https://www.medscape.com/viewarticle/cardiorenal-benefits-glp-1s-found-type-1-diabetes-2026a1000g8r" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
