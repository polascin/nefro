<?php
/**
 * add_kolko-vetrov-denne-normalne_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o normatívnej frekvencii odchodu plynov.
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Koľko vetrov denne je ešte normálne?',
    'slug'         => 'kolko-vetrov-denne-je-este-normalne',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Nová austrálska štúdia v JAMA Network Open priniesla normatívne dáta: priemerný človek vypúšťa črevné plyny približne päťkrát denne. Kedy ide o bežný fyziologický prejav a kedy treba spozornieť?',
    'content'      => <<<'HTML'
<p>Nadúvanie a odchod črevných plynov patria medzi bežné telesné prejavy, o ktorých sa v ambulancii často hovorí opatrne, niekedy s rozpakmi. Napriek tomu ide o medicínsky relevantnú tému. Pacienti sa často pýtajú, či majú „príliš veľa plynov", či je ich trávenie v poriadku a kedy už môže ísť o príznak ochorenia.</p>

<p>Nová štúdia publikovaná v časopise <em>JAMA Network Open</em> prináša zaujímavé normatívne údaje o tom, ako často ľudia bežne vypúšťajú črevné plyny. Hoci téma môže pôsobiť úsmevne, jej praktický význam je jasný: aby sme vedeli hovoriť o nadmernej plynatosti, musíme najskôr vedieť, čo je ešte normálne.</p>

<h2>Austrálska štúdia cez mobilnú aplikáciu</h2>

<p>Výskumníčky Emily Brindalová a Danielle Bairdová pripravili občiansko-vedecký projekt s názvom <strong>Chart Your Fart</strong>. Išlo o mobilnú aplikáciu, prostredníctvom ktorej účastníci v reálnom čase zaznamenávali odchod črevných plynov.</p>

<p>Do projektu sa zapojilo viac ako 19 000 ľudí, pričom do finálnej analýzy bolo zaradených 6416 účastníkov. Súbor bol vo všeobecnosti reprezentatívny pre austrálsku populáciu.</p>

<p>Účastníci spolu zaznamenali <strong>360 192 epizód odchodu črevných plynov</strong> počas priemerne 10 dní sledovania. Jeden z účastníkov dokonca zaznamenával údaje 97 dní.</p>

<h2>Priemer: približne päťkrát denne</h2>

<p>Výsledok bol jednoduchý a zároveň prakticky užitočný: priemerný počet zaznamenaných epizód bol približne <strong>5 odchodov plynov denne na osobu</strong>.</p>

<p>Rozptyl medzi jednotlivcami bol však výrazný. Niektorí ľudia mali epizód menej, iní viac. To je pri tráviacich prejavoch očakávané, pretože ich ovplyvňuje strava, množstvo vlákniny, črevná mikrobiota, pohyb, denný režim, lieky aj individuálna citlivosť.</p>

<h2>Rozdiely podľa pohlavia, veku a dennej doby</h2>

<p>Štúdia zistila, že muži zaznamenávali odchod plynov častejšie než ženy. Pri takomto type výskumu však treba počítať s možnosťou rozdielneho sebazaznamenávania, teda nie je isté, či ide výlučne o biologický rozdiel.</p>

<p>Podľa veku bola najvyššia frekvencia v skupine <strong>26 až 45 rokov</strong>. Najnižšie hodnoty boli zaznamenané u mladších účastníkov vo veku <strong>14 až 25 rokov</strong>.</p>

<p>Zaujímavý bol aj denný rytmus. Frekvencia odchodu plynov počas dňa postupne stúpala a vrcholila tesne pred spaním. Najnižšia bola v skorých ranných hodinách. Tento priebeh dáva biologicky zmysel, pretože tvorba a odchod črevných plynov súvisia s príjmom potravy, trávením a bakteriálnou fermentáciou v čreve.</p>

<h2>Vláknina, trávenie a črevné plyny</h2>

<p>Autori sledovali aj súvislosť so samostatne hláseným príjmom vlákniny. Vzťah nebol veľmi silný, čo nie je prekvapujúce. Trávenie nie je okamžitý proces a tvorba plynov závisí od viacerých faktorov, nielen od jedného jedla alebo jedného parametra stravy.</p>

<p>Všeobecne však platí, že fermentovateľné sacharidy a vláknina môžu u niektorých ľudí zvyšovať tvorbu plynov. Neznamená to, že vláknina je škodlivá. Práve naopak, má dôležitý význam pre črevné zdravie, metabolizmus aj kardiovaskulárne riziko. Problémom môže byť skôr rýchle zvýšenie jej príjmu alebo individuálna intolerancia niektorých potravín.</p>

<h2>Limity štúdie</h2>

<p>Najväčším obmedzením je spôsob zberu údajov. Všetky epizódy boli zaznamenané samotnými účastníkmi. Nešlo teda o objektívne meranie. Niektoré epizódy mohli byť nezaznamenané, iné mohli byť zaznamenané nepresne.</p>

<p>Ďalším limitom je spánok. Štúdia nevie spoľahlivo povedať, čo sa dialo v noci, keď účastníci spali. Údaje preto opisujú najmä vedome zaznamenané denné epizódy.</p>

<p>Napriek týmto obmedzeniam ide o užitočné normatívne dáta. Pre lekára aj pacienta môžu byť oporou pri rozlišovaní medzi bežným fyziologickým prejavom a stavom, ktorý si zaslúži bližšie vyšetrenie.</p>

<h2>Kedy spozornieť?</h2>

<p>Samotný odchod plynov, aj keď je pre pacienta spoločensky nepríjemný, väčšinou neznamená závažné ochorenie. Vyšetrenie je však vhodné zvážiť, ak je plynatosť nová, výrazne zhoršená alebo sa spája s ďalšími príznakmi.</p>

<p>Medzi varovné prejavy patria najmä:</p>

<ul>
  <li>neúmyselný úbytok hmotnosti,</li>
  <li>krv v stolici,</li>
  <li>pretrvávajúce alebo nočné bolesti brucha,</li>
  <li>zmena charakteru stolice,</li>
  <li>chronická hnačka alebo zápcha,</li>
  <li>anémia,</li>
  <li>horúčky,</li>
  <li>začiatok ťažkostí vo vyššom veku,</li>
  <li>rodinná záťaž kolorektálnym karcinómom alebo zápalovým ochorením čreva.</li>
</ul>

<p>V takýchto prípadoch už nejde iba o otázku „normálneho počtu vetrov", ale o potrebu cielene hľadať príčinu ťažkostí.</p>

<h2>Praktický záver</h2>

<p>Priemerný človek podľa tejto austrálskej štúdie vypúšťa črevné plyny približne <strong>päťkrát denne</strong>. To však neznamená, že vyšší počet je automaticky chorobný. Dôležitý je celkový kontext: strava, pravidelnosť stolice, bolesti, nafukovanie, zmena návykov a prítomnosť varovných príznakov.</p>

<p>Plynatosť je normálnou súčasťou trávenia. Medicínsky problém z nej robí najmä výrazná zmena oproti doterajšiemu stavu, sprievodné ťažkosti alebo dopad na kvalitu života.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Flatus Status: How Many Farts a Day Is Normal?". <a href="https://www.medscape.com/viewarticle/flatus-status-how-many-farts-day-normal-2026a1000i7w" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
