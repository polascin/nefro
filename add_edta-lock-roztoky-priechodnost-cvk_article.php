<?php
/**
 * add_edta-lock-roztoky-priechodnost-cvk_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_edta-lock-roztoky-priechodnost-cvk_article.php"
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'EDTA lock roztoky: môžu zlepšiť priechodnosť centrálnych venóznych katétrov?',
    'slug'         => 'edta-lock-roztoky-priechodnost-cvk',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia v časopise JAMA naznačuje, že 4 % tetrasodný EDTA lock roztok môže na JIS znížiť komplikácie centrálnych venóznych katétrov. Prínos sa však týkal najmä poklesu oklúzií, nie jednoznačného zníženia katétrových infekcií.',
    'content'      => <<<'HTML'
<p>Komplikácie spojené s centrálnymi venóznymi katétrami zostávajú v intenzívnej medicíne významným problémom. Centrálne venózne vstupy sú pre kriticky chorých pacientov často nevyhnutné, no prinášajú riziko krvnej infekcie, oklúzie katétra a trombózy súvisiacej s katétrom. Tieto komplikácie zvyšujú morbiditu, predlžujú hospitalizáciu a zvyšujú náklady na zdravotnú starostlivosť.</p>

<p>Jednou z možností prevencie sú takzvané lock roztoky, teda roztoky ponechávané v lúmene katétra v čase, keď sa daný vstup nepoužíva. Cieľom je znížiť riziko upchatia katétra, obmedziť tvorbu biofilmu a zachovať funkčnosť cievneho vstupu.</p>

<p>Nová klinická štúdia publikovaná v časopise <em>JAMA</em> naznačuje, že 4 % tetrasodný EDTA lock roztok môže v podmienkach jednotiek intenzívnej starostlivosti znížiť výskyt komplikácií spojených s centrálnymi venóznymi katétrami. Hlavný prínos sa však týkal najmä zníženia oklúzií katétra, nie jednoznačného poklesu katétrových infekcií.</p>

<h2>Prečo práve EDTA?</h2>

<p>EDTA, teda kyselina etyléndiamíntetraoctová vo forme tetrasodnej soli, pôsobí ako chelátor katiónov. Viazaním iónov môže ovplyvniť procesy súvisiace s koaguláciou, stabilitou biofilmu a mikrobiálnou adherenciou.</p>

<p>Pri použití v lock roztoku sa od EDTA očakávajú najmä tri účinky:</p>

<ul>
  <li>antikoagulačný efekt v lúmene katétra,</li>
  <li>obmedzenie tvorby bakteriálneho biofilmu,</li>
  <li>zlepšenie priechodnosti katétra.</li>
</ul>

<p>Práve kombinácia antikoagulačných a antibiofilmových vlastností robí z EDTA zaujímavú alternatívu k bežným lock roztokom, ako je fyziologický roztok alebo citrát.</p>

<h2>Dizajn štúdie</h2>

<p>Išlo o pragmatickú, multicentrickú, klastrovo randomizovanú, trojito zaslepenú crossover štúdiu. Prebiehala v šiestich nemocniciach v Kanade, vrátane akademických aj komunitných centier.</p>

<p>Do analýzy bolo zahrnutých 1468 dospelých pacientov prijatých na jednotku intenzívnej starostlivosti. Všetci mali funkčný centrálny venózny katéter a aspoň jeden nepoužívaný lúmen. Priemerný vek pacientov bol 60 rokov a väčšinu tvorili muži.</p>

<p>Jednotky intenzívnej starostlivosti boli randomizované na používanie identických, zaslepených, predplnených striekačiek s 2,5 ml 4 % tetrasodného EDTA alebo kontrolného lock roztoku. Kontrolou bol fyziologický roztok, prípadne 4 % citrát pri hemodialyzačných linkách.</p>

<p>Každé pracovisko používalo jednu stratégiu počas 3,5 mesiaca, potom prešlo na druhú stratégiu počas ďalších 3,5 mesiaca. Súčasťou bol aj 1-mesačný udržiavací interval.</p>

<h2>Menej komplikácií, najmä menej oklúzií</h2>

<p>Primárnym cieľom bola kombinovaná incidencia troch udalostí:</p>

<ul>
  <li>krvná infekcia súvisiaca s centrálnym venóznym katétrom,</li>
  <li>oklúzia katétra vyžadujúca použitie alteplázy,</li>
  <li>odstránenie katétra pre oklúziu.</li>
</ul>

<p>Výsledok bol priaznivejší pri použití EDTA. Kombinovaný cieľ sa vyskytol s incidenciou 13,1 udalosti na 1000 katétrových dní pri EDTA oproti 19,9 udalosti na 1000 katétrových dní pri kontrolnom lock roztoku.</p>

<p>Pomer incidencií bol 0,68, 95 % interval spoľahlivosti 0,47 až 0,96 a hodnota <em>P</em> = 0,03. Inak povedané, EDTA lock roztok bol spojený s približne tretinovým relatívnym znížením kombinovaného endpointu.</p>

<p>Dôležité však je, že celkový prínos bol ťahaný najmä znížením oklúzií katétra vyžadujúcich alteplázu. Práve táto jednotlivá zložka kombinovaného cieľa sa medzi skupinami významne líšila.</p>

<h2>Infekcie sa významne neznížili</h2>

<p>Aj keď kombinovaný endpoint vyznel v prospech EDTA, výsledky jednotlivých zložiek boli menej jednoznačné.</p>

<p>Štúdia nepreukázala štatisticky významný rozdiel v miere katétrových krvných infekcií. To naznačuje, že hlavný klinický prínos EDTA v tejto štúdii spočíval skôr v zachovaní priechodnosti katétra než v jasne dokázanom antiinfekčnom účinku.</p>

<p>Toto rozlíšenie je dôležité. EDTA môže mať antibiofilmové vlastnosti, ale v tejto konkrétnej klinickej štúdii sa najpresvedčivejšie prejavil efekt na prevenciu oklúzie. Preto by sa výsledky nemali interpretovať tak, že EDTA jednoznačne znižuje katétrové infekcie v intenzívnej starostlivosti.</p>

<h2>Klinický význam zachovania priechodnosti</h2>

<p>Zníženie oklúzií katétra má reálny praktický význam. Kriticky chorí pacienti často potrebujú spoľahlivý centrálny venózny prístup na podávanie vazopresorov, antibiotík, parenterálnej výživy, sedácie, tekutín alebo iných liekov.</p>

<p>Ak sa lúmen katétra upchá, môže to znamenať:</p>

<ul>
  <li>potrebu podania alteplázy,</li>
  <li>oneskorenie liečby,</li>
  <li>opakované manipulácie s katétrom,</li>
  <li>riziko predčasného odstránenia katétra,</li>
  <li>potrebu zavedenia nového invazívneho vstupu.</li>
</ul>

<p>V tomto kontexte aj relatívne mierne zníženie počtu oklúzií môže byť pre jednotku intenzívnej starostlivosti významné, najmä pri veľkom počte pacientov a dlhšom používaní centrálnych venóznych vstupov.</p>

<h2>Bez významného bezpečnostného signálu</h2>

<p>Podľa dostupných údajov zo štúdie neboli hlásené relevantné bezpečnostné signály spojené s použitím 4 % tetrasodného EDTA. To podporuje jeho ďalšie hodnotenie a možné využitie v klinickej praxi.</p>

<p>Napriek tomu treba byť opatrný pri plošnom zavádzaní. Lock roztoky sa používajú v citlivom prostredí, kde rozhoduje presná koncentrácia, objem, kompatibilita s typom katétra, protokol používania, zaškolenie personálu a prevencia chýb pri manipulácii.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Štúdia podporuje úvahu, že 4 % tetrasodný EDTA lock roztok môže byť vhodnou alternatívou k štandardným lock roztokom u kriticky chorých pacientov s centrálnymi venóznymi katétrami, najmä ak je problémom častá oklúzia lúmenov.</p>

<p>Silnou stránkou štúdie je multicentrický crossover dizajn a pragmatické usporiadanie, ktoré lepšie odráža reálnu klinickú prax. Zároveň však treba výsledky čítať presne: benefit bol skôr v priechodnosti katétra než v preukázanom znížení infekcií.</p>

<p>Pred rutinným zavedením do praxe budú dôležité ďalšie faktory:</p>

<ul>
  <li>cena a dostupnosť EDTA roztoku,</li>
  <li>lokálna incidencia oklúzií katétrov,</li>
  <li>porovnanie s existujúcimi protokolmi,</li>
  <li>bezpečnosť pri konkrétnych typoch katétrov,</li>
  <li>štandardizácia prípravy a aplikácie,</li>
  <li>vplyv na potrebu alteplázy a výmenu katétrov.</li>
</ul>

<h2>Praktický záver</h2>

<p>4 % tetrasodný EDTA lock roztok v tejto štúdii znížil kombinovaný výskyt komplikácií spojených s centrálnymi venóznymi katétrami u pacientov na JIS. Efekt bol však poháňaný najmä redukciou oklúzií katétra vyžadujúcich alteplázu. Štatisticky významné zníženie katétrových krvných infekcií sa nepreukázalo.</p>

<p>Pre prax to znamená, že EDTA lock roztok môže byť sľubnou stratégiou na udržanie priechodnosti centrálnych venóznych katétrov, ale nemal by sa prezentovať ako jednoznačne dokázané riešenie na prevenciu infekcií.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>EDTA Lock Solutions: Could Catheter Patency Improve?</em> (2026). <a href="https://www.medscape.com/viewarticle/edta-lock-solutions-could-catheter-patency-improve-2026a1000imz" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
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
