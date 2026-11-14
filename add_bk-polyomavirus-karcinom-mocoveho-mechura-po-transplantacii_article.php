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
    'title'        => 'BK polyomavírus a karcinóm močového mechúra po transplantácii obličky',
    'slug'         => 'bk-polyomavirus-karcinom-mocoveho-mechura-po-transplantacii',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Karcinóm močového mechúra bol v registrovej kohorte častejší pri BKPyV DNAémii. Čo z toho vyplýva pre sledovanie po transplantácii?',
    'content'      => <<<'HTML'
<figure><a href="img/bk-polyomavirus-karcinom-mocoveho-mechura-po-transplantacii.webp" target="_blank" rel="noopener noreferrer"><img src="img/bk-polyomavirus-karcinom-mocoveho-mechura-po-transplantacii.webp" alt="Močový mechúr pri sledovaní príjemcov obličkového štepu" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Močový mechúr pri sledovaní príjemcov obličkového štepu. Ilustračný obrázok.</figcaption></figure>
<p>V registrovej kohorte príjemcov obličky sa karcinóm močového mechúra zistil častejšie u pacientov s DNAémiou BK polyomavírusu (BKPyV). Celkovo však išlo o 12 nádorov. Výsledok upozorňuje na možnú súvislosť a sám osebe neodôvodňuje zavedenie pravidelnej cystoskopie u bezpríznakových príjemcov. [1, 2]</p>
<h2>Čo zistila registrová kohorta</h2>
<p>Clinceová a spoluautori analyzovali prospektívne zbierané údaje o 1 372 príjemcoch prvej transplantovanej obličky z rokov 2011 až 2022. Pri pravidelnom monitorovaní definovali BKPyV DNAémiu ako viac než 1 000 kópií/ml. Túto hranicu prekročilo 22,2 % príjemcov. Pozitívna PCR v krvi a biopticky potvrdená BKPyV nefropatia predstavujú odlišné klinické nálezy. [1, 2]</p>
<p>Karcinóm močového mechúra sa zaznamenal u 12 príjemcov (0,87 %). V skupine s DNAémiou išlo o osem prípadov (2,6 %) a v skupine bez DNAémie o štyri (0,37 %). Upravený pomer hazardov bol 4,95 (p = 0,008). Tento odhad vyjadruje relatívny rozdiel v okamžitej miere výskytu počas sledovania. U pacientov s DNAémiou bol medián času od transplantácie po diagnózu nádoru 72 mesiacov. Päťročné prežívanie štepu bolo 91 % pri DNAémii a 88 % bez nej. Tieto hodnoty samy osebe neukazujú, že DNAémia zlepšuje prežívanie štepu alebo že prognóza je v oboch skupinách rovnocenná. [1]</p>
<h2>Čo z výsledku zatiaľ nemožno vyvodiť</h2>
<p>Pri dvanástich nádoroch je upravený odhad citlivý na jednotlivé udalosti a voľbu premenných. Autori opisujú vyšší pomer hazardov pri vyššej vírusovej náloži. Abstrakt však neuvádza interval spoľahlivosti hlavného odhadu, úplný zoznam premenných v modeli ani presné výsledky pre jednotlivé prahy. Plný text sa nepodarilo získať. Z dostupných údajov preto nemožno určiť, do akej miery výsledok ovplyvnili spoločné rizikové faktory, intenzita vyšetrení alebo časový vzťah medzi DNAémiou a diagnózou nádoru. Samotná DNAémia nedokazuje prítomnosť vírusu v nádorovom tkanive ani jeho podiel na vzniku konkrétneho nádoru. [1, 2]</p>
<h2>Sledovanie DNAémie a urologické vyšetrenie</h2>
<p>Monitorovanie BKPyV DNAémie po transplantácii slúži predovšetkým na včasné rozpoznanie rizika poškodenia štepu. Medzinárodný konsenzus z roku 2024 neurčuje osobitnú skríningovú metódu pre BKPyV-asociovaný uroteliálny karcinóm. Pri hematúrii má význam včas zhodnotiť aj urologické príčiny. Predchádzajúca DNAémia je údaj, ktorý patrí do klinickej anamnézy, pričom samotná kohorta neurčuje, koho z bezpríznakových pacientov vyšetrovať, akou metódou ani ako často. [1, 2]</p>
<hr><h2>Zdroje</h2><ol>
<li><small><em>Michelle Clince, Darragh O'Donoghue, Vicki Sandys, Peter Conlon, Ciara Magee, Patrick O'Kelly, Anne Cooney, Caoimhe Brennan, Una Sutton-Fitzpatrick, Nicholas Kruseman Aretz, Eilis Ni Chinneide, Jeff Connell, Min Yuen Teo, Fidelma Fitzpatrick, Brendan Doyle, Mark Broe, Dilly Little, Peter J Conlon. BK polyomavirus viraemia after kidney transplantation: incidence, graft survival and its association with urinary tract malignancies. J Nephrol. Online 5. novembra 2026. <a href="https://doi.org/10.1093/joneph/aajag154" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42986224/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Camille N. Kotton, Nassim Kamar, David Wojciechowski, Michael Eder, Helmut Hopfer, Parmjeet Randhawa, Martina Sester, Patrizia Comoli, Helio Tedesco Silva, Greg Knoll, Daniel C. Brennan, Jennifer Trofe-Clark, Lars Pape, David Axelrod, Bryce Kiberd, Germaine Wong, Hans H. Hirsch, Transplantation Society International BK Polyomavirus Consensus Group. The Second International Consensus Guidelines on the Management of BK Polyomavirus in Kidney Transplantation. Transplantation. 2024;108(9):1834-1866. <a href="https://doi.org/10.1097/TP.0000000000004976" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38605438/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li></ol>
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
    'log_prefix' => 'add_bk-polyomavirus-karcinom-mocoveho-mechura-po-transplantacii_article',
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
