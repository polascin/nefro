<?php
/**
 * add_serove-acylkarnitiny-mozu-predpovedat-pokles-funkcie-obliciek-u-diabetu-2-typu_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Sérové acylkarnitíny môžu predpovedať pokles funkcie obličiek u diabetu 2. typu',
    'slug'         => 'serove-acylkarnitiny-mozu-predpovedat-pokles-funkcie-obliciek-u-diabetu-2-typu',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Prospektívna štúdia ukázala, že sérové hladiny vybraných acylkarnitínov sú spojené s rýchlejším poklesom eGFR u pacientov s diabetom 2. typu. Multimarkerové skóre zo 6 metabolitov zlepšilo predikciu rizika nad rámec bežných klinických modelov.',
    'content'      => <<<'HTML'
<p>U ľudí s diabetom 2. typu (T2D) je chronické zhoršovanie funkcie obličiek časté a individuálna rýchlosť poklesu odhadovanej glomerulárnej filtrácie (eGFR) sa medzi pacientmi výrazne líši. Aktuálna prospektívna štúdia naznačuje, že hladiny vybraných acylkarnitínov v sére sú spojené s rýchlejším zhoršovaním funkcie obličiek. Navyše, kombinácia niektorých z týchto metabolitov môže zlepšiť predikciu rizika v porovnaní s bežne používanými klinickými modelmi.</p>

<h2>Čo sa vyšetrovalo a ako</h2>

<p>Autori sa zamerali na cirkulujúce (t. j. v krvi merateľné) acylkarnitíny. Ide o metabolity, ktorých akumulácia je považovaná za možný mechanizmus spojený s ochorením obličiek.</p>

<p>Štúdia bola prospektívna a pracovala s dvoma kohortami:</p>
<ul>
    <li><strong>Discovery kohorta:</strong> 575 pacientov s T2D zo štúdie Gargano Mortality Study (medián sledovania približne 9 rokov).</li>
    <li><strong>Validačná kohorta:</strong> 252 pacientov s T2D zo štúdie Joslin Kidney Study (medián sledovania približne 10 rokov).</li>
</ul>

<p>Merali sa <strong>baseline sérové hladiny 40 acylkarnitínov</strong> (krátko-, stredne- a dlhoreťazcové) pomocou <strong>cieľovej metabolomiky</strong>. Následne sa hodnotilo, či sú tieto metabolity spojené s mierou poklesu eGFR v čase, a či dokážu zlepšiť predikciu nad rámec existujúcich klinických modelov.</p>

<h2>Hlavné výsledky</h2>

<h3>1) Jedenásť acylkarnitínov súviselo s rýchlejším poklesom eGFR</h3>

<p>V discovery kohorte bolo identifikovaných <strong>11 z 40 acylkarnitínov</strong>, ktoré boli nezávisle spojené so <strong>zrýchleným poklesom eGFR</strong> u pacientov s T2D. Asociácie boli štatisticky významné a <strong>interné overenie</strong> prebehlo v rámci štúdie.</p>

<p>Medzi najsilnejšie asociácie v rámci štúdie patrili najmä niektoré <strong>krátkoreťazcové acylkarnitíny</strong>. Naopak, u ďalších metabolitov sa pozorovala opačná (inverzná) súvislosť so zhoršovaním funkcie obličiek.</p>

<h3>2) Časť výsledkov sa potvrdila aj v nezávislej kohorte</h3>

<p>Z tých acylkarnitínov, ktoré boli dostupné pre externú validáciu, sa v validačnej kohorte ukázali ako prediktory poklesu eGFR najmä:</p>
<ul>
    <li><strong>tiglylcarnitine</strong></li>
    <li><strong>methylglutarylcarnitine</strong></li>
</ul>

<h3>3) „Metabolitové skóre" zlepšilo rizikovú stratifikáciu</h3>

<p>Autori vytvorili multimarkerové skóre z <strong>6 acylkarnitínov</strong>:</p>
<ul>
    <li>methylglutarylcarnitine</li>
    <li>hydroxyvalerylcarnitine</li>
    <li>hexenoylcarnitine</li>
    <li>decadienylcarnitine</li>
    <li>dodecanedioylcarnitine</li>
    <li>tetradecadienylcarnitine</li>
</ul>

<p>Toto skóre podľa výsledkov <strong>zlepšilo výkonnosť zavedených klinických modelov</strong> pri identifikácii osôb s vyšším rizikom rýchleho poklesu eGFR.</p>

<h2>Čo to znamená prakticky (a čo zatiaľ nie)</h2>

<p>Táto práca je zaujímavá v tom, že posúva predikciu diabetickej nefropatie smerom k biologickým biomarkerom, ktoré môžu zachytiť riziko ešte pred výrazným klinickým zhoršením. V texte štúdie autori zdôrazňujú, že vybrané sérové acylkarnitíny môžu potenciálne slúžiť na lepšie určenie pacientov s najvyšším rizikom.</p>

<p>Dôležité je ale povedať, že:</p>
<ul>
    <li>nejde o „priamy klinický test" pripravený na rutinné zavedenie,</li>
    <li>výsledky zatiaľ nie sú komplexne externé validované pre celý panel metabolitov,</li>
    <li>výskum neposkytuje odpoveď, ako presne metabolity vznikajú a aký je ich kauzálny vplyv na vývoj ochorenia (výsledky sú asociácie, nie dôkaz príčiny).</li>
</ul>

<h2>Limity štúdie</h2>

<p>Medzi obmedzenia patrí najmä:</p>
<ul>
    <li><strong>čiastočná externá validácia</strong>, lebo nie všetky identifikované metabolity boli dostupné v validačnej databáze,</li>
    <li><strong>nebolo možné externé overenie výkonu</strong> 6-metabolitového skóre,</li>
    <li><strong>absencia údajov o strave</strong>, čo limituje hodnotenie vplyvu stravovania na hladiny acylkarnitínov a následný pokles funkcie obličiek.</li>
</ul>

<h2>Zhrnutie</h2>

<p>Prospektívna analýza u pacientov s diabetom 2. typu ukázala, že viaceré sérové acylkarnitíny sú spojené s rýchlejším poklesom eGFR. Kombinácia šiestich vybraných metabolitov potom zlepšila predikciu rizika nad rámec existujúcich klinických modelov, aspoň v rámci skúmaných dát. V ďalších krokoch bude kľúčové potvrdiť výsledky v širších a kompletných externých kohortách a upresniť, ako a či sa tieto biomarkery dajú bezpečne a prakticky implementovať do klinickej praxe.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape (online článok o štúdii zverejnenej v BMJ Open Diabetes Research &amp; Care). <a href="https://www.medscape.com/viewarticle/serum-acylcarnitines-may-predict-kidney-decline-diabetes-2026a1000gnh" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
