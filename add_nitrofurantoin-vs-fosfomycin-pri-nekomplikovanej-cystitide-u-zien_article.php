<?php
/**
 * add_nitrofurantoin-vs-fosfomycin-pri-nekomplikovanej-cystitide-u-zien_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Nitrofurantoín vs. fosfomycín: čo ukazuje nová španielska štúdia pri nekomplikovanej cystitíde u žien',
    'slug'         => 'nitrofurantoin-vs-fosfomycin-pri-nekomplikovanej-cystitide-u-zien',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Španielska randomizovaná štúdia porovnala štyri antibiotické stratégie pri nekomplikovanej cystitíde u žien. 5-dňový nitrofurantoín dosiahol klinické vymiznutie príznakov na 7. deň u 74 % pacientok, čo bolo výrazne lepšie než jednorazový fosfomycín (59 %).',
    'content'      => <<<'HTML'
<p>Nekomplikované infekcie dolných močových ciest (UTI, typicky akútna cystitída) patria u žien medzi najčastejšie dôvody predpisovania antibiotík. Nová randomizovaná štúdia porovnala tri antibiotické stratégie a ukázala, že <strong>5-dňový nitrofurantoín</strong> dosahuje lepšie klinické výsledky než <strong>jednorazový fosfomycín</strong>. Rozdiely oproti alternatívam existujú, no celkovo boli všetky režimy účinné a bezpečné.</p>

<h2>Dizajn štúdie a populácia</h2>

<p>Štúdia bola realizovaná v podmienkach primárnej starostlivosti v Španielsku. Zaradených bolo <strong>768 žien vo veku 34 až 63 rokov</strong> (medián veku 48 rokov) z <strong>34 praxí</strong> medzi aprílom 2022 a novembrom 2024.</p>
<p>Všetky účastníčky mali typické príznaky UTI (pálenie pri močení, urgencia, časté močenie alebo bolestivosť nad lonovou kosťou) a pozitívny močový test na <strong>nitrit alebo leukocytovú esterázu</strong>. Zároveň malo <strong>57 %</strong> pozitívnu kultiváciu moču.</p>
<p>Ženy boli randomizované do štyroch skupín:</p>
<ol>
    <li><strong>Jednorazový fosfomycín:</strong> 1 × 3 g</li>
    <li><strong>Fosfomycín v 2 dávkach:</strong> 2 × 3 g s odstupom 24 hodín</li>
    <li><strong>Nitrofurantoín:</strong> 100 mg trikrát denne počas <strong>5 dní</strong></li>
    <li><strong>Pivmecillinam:</strong> 400 mg trikrát denne počas <strong>3 dní</strong></li>
</ol>
<p>Autori zámerne nepoužili „širokospektrálne" antibiotiká.</p>

<h2>Primárny cieľ</h2>

<p>Primárnym ukazovateľom bolo, aké percento pacientok dosiahlo <strong>klinické vymiznutie príznakov do 7. dňa</strong>. Pre primárnu analýzu boli dostupné dáta od <strong>720</strong> z <strong>768</strong> účastníčok.</p>

<h2>Výsledky účinnosti</h2>

<p>Na 7. deň mala <strong>najnižšiu účinnosť</strong> skupina s jednorazovým fosfomycínom: symptomaticky bez ťažkostí bolo len <strong>59 %</strong> pacientok.</p>
<p>Najlepšie dopadol <strong>nitrofurantoín</strong>:</p>
<ul>
    <li><strong>74 %</strong> pacientok bez príznakov po 1 týždni</li>
</ul>
<p>Nasledovali:</p>
<ul>
    <li><strong>Pivmecillinam:</strong> 70 %</li>
    <li><strong>Fosfomycín v 2 dávkach:</strong> 67 %</li>
</ul>
<p>Podobné trendy sa pozorovali aj pri hodnoteniach na <strong>14. a 28. deň</strong> a v podskupine s východiskovou pozitívnou kultiváciou moču.</p>

<h2>Nežiaduce účinky a bezpečnosť</h2>

<p>Nežiaduce udalosti sa vyskytli u štvrtiny až tretiny pacientok v závislosti od režimu:</p>
<ul>
    <li>jednorazový fosfomycín: <strong>19,9 %</strong></li>
    <li>fosfomycín v 2 dávkach: <strong>26,3 %</strong></li>
    <li>nitrofurantoín: <strong>26,8 %</strong></li>
    <li>pivmecillinam: <strong>21,2 %</strong></li>
</ul>
<p>Väčšina nežiaducich účinkov boli <strong>mierne, samovoľne prechodné gastrointestinálne príznaky</strong>. Zaznamenali sa <strong>4 závažné nežiaduce udalosti</strong>, z ktorých len jedna sa javila ako súvisiaca s liečbou: <strong>pyelonefritída</strong> v skupine pivmecillinam.</p>

<h2>Čo z toho vyplýva</h2>

<p>Autori uzatvárajú, že výsledky podporujú predchádzajúce zistenia, podľa ktorých je <strong>fosfomycín menej účinný v jednorazovom režime</strong> než nitrofurantoín. V praktickom zmysle to znamená, že podľa tejto štúdie by sa mala uprednostniť <strong>niekoľkodňová antibiotická liečba pred jednorazovým režimom fosfomycínu</strong>, najmä ak sa sleduje klinické vymiznutie príznakov na 7. deň.</p>
<p>Medscape zároveň uvádza, že počet zaradených pacientok pravdepodobne nebol dostatočný na jemnejšie rozlíšenie menších rozdielov medzi všetkými režimami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape (príbeh o španielskej randomizovanej štúdii v The Lancet). <a href="https://www.medscape.com/viewarticle/uti-treatment-shift-nitrofurantoin-coming-out-top-2026a1000gem" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
