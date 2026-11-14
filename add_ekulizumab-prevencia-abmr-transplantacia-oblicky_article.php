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
    'title'        => 'Ekulizumab v prevencii protilátkami sprostredkovanej rejekcie po transplantácii obličky',
    'slug'         => 'ekulizumab-prevencia-abmr-transplantacia-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Znižuje pridanie ekulizumabu k desenzibilizácii riziko rejekcie? Systematický prehľad ukazuje, prečo randomizované a historické porovnania vedú k odlišným záverom.',
    'content'      => <<<'HTML'
<p>Peritransplantačná blokáda komplementu ekulizumabom má biologické opodstatnenie, ale jej prínos nad rámec štandardnej desenzibilizácie zostáva neistý. V jedinej randomizovanej štúdii zahrnutej do systematického prehľadu Lianga a spoluautorov sa centrálne potvrdená protilátkami sprostredkovaná rejekcia (ABMR) vyskytla u 5 z 51 príjemcov v každom ramene. Široký interval spoľahlivosti ponecháva otvorenú možnosť prínosu aj poškodenia. [1, 2]</p>

<h2>Čo testovala randomizovaná štúdia</h2>

<p>Marks a spoluautori v multicentrickej otvorenej štúdii fázy 2 skúmali príjemcov obličky od živého darcu, ktorí potrebovali desenzibilizáciu. Publikovaná analýza zahŕňala 102 transplantovaných pacientov, po 51 v skupine s ekulizumabom a v skupine so štandardným postupom. Primárny kombinovaný ukazovateľ do deviateho týždňa zahŕňal centrálne potvrdenú ABMR stupňa II alebo III, stratu štepu, úmrtie alebo stratu zo sledovania. Vyskytol sa u 5 z 51 pacientov (9,8 %) pri ekulizumabe a u 7 z 51 (13,7 %) pri štandardnom postupe (p = 0,760). [2]</p>

<p>Pri samostatnom hodnotení centrálne potvrdenej ABMR stupňa II alebo III nastalo päť udalostí v každom ramene. Pomer rizík (RR) bol 1,00 (95 % interval spoľahlivosti 0,31 až 3,25). Výsledok nepreukázal prírastkový prínos ekulizumabu a presnosť odhadu nestačí na záver o rovnocennosti. Dodatočné analýzy s odlišnou definíciou ABMR vrátane stupňa I majú exploračný charakter. Použitie ekulizumabu ako záchrannej liečby v kontrolnom ramene navyše sťažuje interpretáciu dlhodobých výsledkov. [1, 2]</p>

<h2>Prečo historická kontrola dáva iný obraz</h2>

<p>Prehľad identifikoval 31 správ. Tridsať patrilo k 14 štúdiám alebo registrovým projektom a jedna patologická správa bola hodnotená kvalitatívne. Autori posudzovali dôkazy podľa dizajnu. V historickom porovnaní sa ABMR vyskytla u 2 z 26 príjemcov s ekulizumabom a u 21 z 51 historických kontrol (RR 0,19; 95 % interval spoľahlivosti 0,05 až 0,74). Súčasne sa však zmenilo obdobie transplantácie, používanie plazmaferézy po výkone a ďalšie súčasti starostlivosti. Samostatný účinok blokády C5 z tohto porovnania nemožno určiť. [1]</p>

<h2>Čo výsledok znamená pre prevenciu ABMR</h2>

<p>Ekulizumab bráni štiepeniu C5 a tlmí terminálnu aktiváciu komplementu. Táto blokáda sama osebe neodstraňuje protilátky špecifické proti darcovi (DSA). V dlhodobom sledovaní prehľad nenašiel konzistentnú výhodu v prežívaní alebo funkcii štepu a v niektorých súboroch pretrvávali DSA aj chronické mikrovaskulárne poškodenie. Doterajší dôkaz preto nepodporuje rutinné pridávanie ekulizumabu k desenzibilizácii s cieľom predísť ABMR. Rozsah randomizovanej štúdie obmedzuje prenášanie výsledku na transplantácie od zosnulých darcov či na inkompatibilitu v systéme ABO. [1, 2]</p>

<p>Pri hodnotení pomeru prínosu a rizika treba zohľadniť aj riziko závažnej meningokokovej infekcie pri blokáde C5. Prevencia ABMR po transplantácii obličky nepatrí medzi schválené indikácie lieku Soliris v EÚ. [3]</p>

<p><a href="article.php?slug=komplement-nefrologia-patofyziologia-diagnostika-terapia">Súvisiaci článok o komplemente v nefrológii</a></p>
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Chengze Liang, Rong Bao, Saifu Yin, Turun Song, Tao Lin. Peri-transplant eculizumab for preventing antibody-mediated rejection in kidney transplant recipients at high immunologic risk: a systematic review with design-stratified evidence synthesis. Front Immunol. 2026;17:1982870. <a href="https://doi.org/10.3389/fimmu.2026.1982870" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42978583/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13727399/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>William H. Marks, Nizam Mamode, Robert A. Montgomery, Mark D. Stegall, Lloyd E. Ratner, Lynn D. Cornell, Ajda T. Rowshani, Robert B. Colvin, Bradley Dain, Judith A. Boice, Denis Glotz, C10-001 Study Group. Safety and efficacy of eculizumab in the prevention of antibody-mediated rejection in living-donor kidney transplant recipients requiring desensitization therapy: A randomized trial. Am J Transplant. 2019;19(10):2876-2888. <a href="https://doi.org/10.1111/ajt.15364" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30887675/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6790671/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>European Medicines Agency. Soliris. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/soliris" target="_blank" rel="noopener noreferrer">Európska verejná hodnotiaca správa</a>.</em></small></li>
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
    'log_prefix' => 'add_ekulizumab-prevencia-abmr-transplantacia-oblicky_article',
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
