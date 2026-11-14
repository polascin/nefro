<?php
// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Dapagliflozín na ochranu obličiek po transplantácii srdca v štúdii DAPARHT',
    'slug'         => 'dapagliflozin-po-transplantacii-srdca-daparht',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V štúdii DAPARHT bol vývoj eGFR od druhého týždňa priaznivejší pri dapagliflozíne. Čo znamená tento rozdiel pre príjemcov srdca?',
    'content'      => <<<'HTML'
<figure><a href="img/dapagliflozin-po-transplantacii-srdca-daparht.webp" target="_blank" rel="noopener noreferrer"><img src="img/dapagliflozin-po-transplantacii-srdca-daparht.webp" alt="Transplantované srdce a obličky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Transplantované srdce a obličky. Ilustračný obrázok.</figcaption></figure>
<p>V randomizovanej štúdii DAPARHT sa u dospelých po transplantácii srdca od druhého týždňa do dvanásteho mesiaca vyvíjala odhadovaná glomerulová filtrácia (eGFR) priaznivejšie pri dapagliflozíne ako pri placebe. Rozdiel v zmene eGFR za toto obdobie bol 1,7 ml/min/1,73 m². Štúdia hodnotila náhradný ukazovateľ a nepreukázala, že dapagliflozín znižuje riziko zlyhania obličiek alebo potreby dialýzy. [1]</p>

<h2>Koho štúdia sledovala</h2>

<p>V šiestich transplantačných centrách v severnej Európe randomizovali 430 dospelých príjemcov srdca najmenej rok po transplantácii s eGFR ≥25 ml/min/1,73 m². Dapagliflozín 10 mg raz denne dostávalo podľa randomizácie 217 účastníkov a placebo 213. Zaslepená fáza trvala 12 mesiacov. Do hlavnej analýzy sa zahrnulo 424 účastníkov s aspoň jedným meraním eGFR po vstupe do štúdie. Priemerná východisková eGFR bola 67 ± 22 ml/min/1,73 m² a medián času od transplantácie bol sedem rokov. Vstupný prah eGFR preto sám osebe nevystihuje typického účastníka. [1, 2]</p>

<h2>Čo znamená rozdiel 1,7 ml/min/1,73 m²</h2>

<p>Primárnym ukazovateľom bol chronický sklon eGFR od druhého týždňa do konca zaslepenej fázy. Za toto obdobie sa eGFR podľa odhadu zvýšila o 2,0 ml/min/1,73 m² pri dapagliflozíne (95 % interval spoľahlivosti 1,0 až 3,1) a o 0,3 ml/min/1,73 m² pri placebe (95 % interval spoľahlivosti −0,8 až 1,4). Rozdiel medzi skupinami bol 1,7 ml/min/1,73 m² (95 % interval spoľahlivosti 0,1 až 3,3; p = 0,03). Dolná hranica intervalu pripúšťa veľmi malý účinok. [1]</p>

<p>Analýza sa začína v druhom týždni, aby zachytila vývoj eGFR po období, v ktorom inhibícia SGLT2 môže vyvolať úvodný hemodynamický pokles filtrácie. Odhad 1,7 ml/min/1,73 m² preto nemožno čítať ako rozdiel v zmene od hodnoty pred začatím liečby. Keďže výsledok vychádza z jednoročného sledovania, jeho veľkosť nemožno jednoducho premietnuť do ďalších rokov. [1, 2]</p>

<h2>Bezpečnosť a prenos výsledku do praxe</h2>

<p>Podľa publikovaného abstraktu autori nezaznamenali neočakávané bezpečnostné zistenia a frekvencia nežiaducich udalostí vrátane infekcií bola podobná. Pri 430 randomizovaných účastníkoch a 12 mesiacoch zaslepenej liečby zostáva istota o zriedkavých a neskorých nežiaducich účinkoch obmedzená. Tento text vychádza z abstraktu s výsledkami, publikovaného dizajnu a registrácie štúdie. Úplné bezpečnostné tabuľky a výsledok za obdobie od začiatku liečby do 12. mesiaca sa nepodarilo overiť. [1, 2]</p>

<p>Pri poklese eGFR po transplantácii srdca môže byť expozícia inhibítorom kalcineurínu jedným z viacerých faktorov. DAPARHT podporuje možnosť priaznivého účinku dapagliflozínu na neskorší priebeh eGFR u vybraných príjemcov srdca. O tom, či sa účinok prenáša aj na príjemcov obličky, táto štúdia neposkytuje priamy dôkaz. Rovnako neobjasňuje pomer prínosu a rizika v prvom roku po transplantácii srdca ani pri východiskovej eGFR pod 25 ml/min/1,73 m². [1, 2]</p>

<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Stine Holmen, Olivier Manintveld, Kevin Damman, Ida Haugen Löfman, Mariusz Szymanski, Oscar Braun, Martin Lando, Elisabeth Bjørkelund, Jasper J. Brugts, Yannick J. H. J. Taverne, Jozine M. Ter Maaten, Tonje Thorvaldsen, Michael Melin, Manon G. van der Meer, Morten W. Fagerland, Håvard Ravnestad, Einar Gude, Arne K. Andreassen, Lars Gullestad, Kaspar Broch. Dapagliflozin for Renal Protection in Heart Transplant Recipients: A Randomized Clinical Trial. Circulation. Online 8. novembra 2026. <a href="https://doi.org/10.1161/CIRCULATIONAHA.126.083760" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42999953/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Stine Holmen, Olivier Manintveld, Kevin Damman, Oscar Braun, Ida Haugen Löfman, Mariusz Szymanski, Håvard Ravnestad, Einar Gude, Elisabeth Bjørkelund, Arne K. Andreassen, Lars Gullestad, Kaspar Broch. DAPAgliflozin for renal protection in heart transplant recipients. Rationale and design of the randomized controlled DAPARHT trial. Am Heart J. 2026;291:128-135. <a href="https://doi.org/10.1016/j.ahj.2025.08.010" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40840822/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://clinicaltrials.gov/study/NCT05321706" target="_blank" rel="noopener noreferrer">Registrácia NCT05321706</a>.</em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dapagliflozin-po-transplantacii-srdca-daparht_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
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

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
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
