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
    'title'        => 'Kvalita darcovskej obličky pred transplantáciou a po nej',
    'slug'         => 'kvalita-darcovskej-oblicky-strojova-perfuzia-biomarkery',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Čo preukázala hypotermická strojová perfúzia pri uchovávaní obličky a čo ešte treba overiť pred rozhodovaním podľa biomarkerov?',
    'content'      => <<<'HTML'
<p>Strojová perfúzia umožňuje darcovskú obličku uchovať a zároveň získať údaje o jej stave pred implantáciou. Prehľad Zua a spoluautorov opisuje tri obdobia, v ktorých možno tieto údaje využiť. Klinické dôkazy o účinnosti perfúzie pri uchovaní orgánu treba posudzovať samostatne od dôkazov o tom, či nový biomarker pomáha rozhodnúť o prijatí konkrétnej obličky. [1, 2]</p>
<h2>Pred odberom, počas uchovávania a po transplantácii</h2>
<p>Pri hodnotení darcu môžu genetické a epigenetické údaje či analýza obrazových nálezov doplniť klinické skóre. Pred použitím v praxi treba preukázať, že zlepšujú odhad rizika aj mimo pracoviska, na ktorom vznikli. Model vyvinutý v jednom centre môže pri inom výbere darcov alebo inom postupe odberu odhadovať riziko nepresne. [1]</p>
<p>Po odbere možno počas strojovej perfúzie analyzovať perfuzát alebo tkanivo. Transkriptomika, proteomika a metabolomika prinášajú kandidátne ukazovatele poškodenia a funkcie. Hranica odvodená z jedného súboru ešte neposkytuje spoľahlivý podklad na vyradenie štepu. Pred takým použitím treba overiť reprodukovateľnosť merania a zistiť, či rozhodovanie podľa testu znižuje počet zlyhaní bez zbytočného vyradenia použiteľných orgánov. [1]</p>
<p>Po transplantácii sa skúma využitie voľnej DNA darcovského pôvodu (dd-cfDNA), močových chemokínov a zobrazovacích metód na skoré zachytenie poškodenia štepu. Výsledok získaný po implantácii odpovedá na otázku o aktuálnom stave štepu v príjemcovi. Jeho interpretácia preto patrí do inej klinickej situácie než rozhodovanie o prijatí orgánu pred transplantáciou. [1]</p>
<h2>Čo preukázala randomizácia pri strojovej perfúzii</h2>
<p>V párovej randomizovanej štúdii Moersa a spoluautorov priradili jednu obličku od každého z 336 zosnulých darcov k hypotermickej strojovej perfúzii a druhú k statickému uchovávaniu v chlade. Oneskorená funkcia štepu, definovaná potrebou dialýzy v prvom týždni, nastala u 70 z 336 príjemcov po perfúzii a u 89 z 336 po statickom uchovávaní (upravený pomer šancí 0,57; p = 0,01). Jednoročné prežívanie štepu bolo 94 % oproti 90 % (p = 0,04). Štúdia porovnávala metódy uchovania. Hranice biomarkerov na prijatie alebo vyradenie orgánu netestovala. [2]</p>
<h2>Aký dôkaz treba pred zavedením nového testu</h2>
<p>Prehľad upozorňuje na malé jednocentrové súbory, rozdielne metódy merania a nedostatočné prospektívne overenie modelov strojového učenia. Klinicky rozhodujúca otázka je, či postup riadený biomarkerom prináša lepšie výsledky než súčasné hodnotenie. Na jej zodpovedanie treba sledovať využitie orgánov aj dlhodobú funkciu a prežívanie štepu. Prehľad v tomto článku spracúvam v rozsahu publikovaného abstraktu. Plný text sa nepodarilo získať. [1]</p>
<hr><h2>Zdroje</h2><ol>
<li><small><em>You Zuo, Veerle A. Lantinga, Elizabeth Orozco-García, Baran Ogurlu, Cyril Moers. Advances in assessing donor organ quality and perioperative risk for kidney transplantation. Kidney Int. Online 5. novembra 2026. <a href="https://doi.org/10.1016/j.kint.2026.07.040" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42988162/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Cyril Moers, Jacqueline M. Smits, Mark-Hugo J. Maathuis, Jürgen Treckmann, Frank van Gelder, Bogdan P. Napieralski, Margitta van Kasterop-Kutz, Jaap J. Homan van der Heide, Jean-Paul Squifflet, Ernest van Heurn, Günter R. Kirste, Axel Rahmel, Henri G. D. Leuvenink, Andreas Paul, Jacques Pirenne, Rutger J. Ploeg. Machine perfusion or cold storage in deceased-donor kidney transplantation. N Engl J Med. 2009;360(1):7-19. <a href="https://doi.org/10.1056/NEJMoa0802289" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/19118301/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li></ol>
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
    'log_prefix' => 'add_kvalita-darcovskej-oblicky-strojova-perfuzia-biomarkery_article',
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
