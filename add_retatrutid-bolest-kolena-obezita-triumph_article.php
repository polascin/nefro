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
    'title'        => 'Retatrutid pri obezite a bolestivej osteoartróze kolena',
    'slug'         => 'retatrutid-bolest-kolena-obezita-triumph',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Štúdie TRIUMPH ukázali ústup bolesti kolena a pokles hmotnosti. Aké sú hranice týchto výsledkov pri chronickej chorobe obličiek?',
    'content'      => <<<'HTML'
<p>Retatrutid v dvoch randomizovaných porovnaniach fázy 3 zmiernil bolesť pri osteoartróze kolena a znížil hmotnosť viac než placebo. Medscape priniesol správu o výsledkoch TRIUMPH-4 a osteoartrózovej kohorty TRIUMPH-1. Pre nefrologickú prax je podstatné, že publikácia hodnotila najmä bolesť, funkciu a hmotnosť. Neposkytuje priamy dôkaz o renálnom prínose ani o bezpečnosti pri pokročilej chronickej chorobe obličiek (CKD). [1, 2]</p>
<h2>Bolesť kolena a hmotnosť</h2>
<p>Zaradení dospelí mali bolestivú osteoartrózu kolena, BMI aspoň 27 kg/m² a nemali diabetes. V TRIUMPH-4 randomizovali 445 účastníkov na týždenný podkožný retatrutid v dávke 9 alebo 12 mg, alebo placebo. Primárne hodnotili zmenu bolesti a hmotnosti po 68 týždňoch. Na škále bolesti WOMAC od 0 do 10, kde vyššie skóre znamená väčšiu bolesť, bol v hlavnej analýze rozdiel oproti placebu −1,83 bodu pri 9 mg (95 % interval spoľahlivosti −2,37 až −1,30) a −1,61 bodu pri 12 mg (−2,16 až −1,07). Analýza podľa pôvodného priradenia ukázala rozdiely −1,70 a −1,38 bodu. [1]</p>
<p>Hmotnosť v TRIUMPH-4 klesla v priemere o 20,0 % pri 9 mg a o 23,7 % pri 12 mg oproti 4,6 % pri placebe. V kohorte TRIUMPH-1-OA s 574 účastníkmi sa po 80 týždňoch preukázal priaznivejší výsledok bolesti aj pri dávke 4 mg. Skóre fyzickej funkcie sa zlepšilo. Porovnania s placebom neobjasňujú, aká časť úľavy súvisela so schudnutím, a neposkytujú dôkaz o obnove chrupavky. [1]</p>
<h2>Znášanlivosť a význam pre nefrológiu</h2>
<p>Najčastejšie nežiaduce udalosti boli gastrointestinálne, najmä nauzea, hnačka a zápcha. V bezpečnostnej populácii TRIUMPH-4 sa závažné nežiaduce udalosti zaznamenali u 14 zo 147 účastníkov pri 9 mg, u 16 zo 148 pri 12 mg a u 3 zo 149 pri placebe. Tieto počty opisujú udalosti počas štúdie. Príčinnú súvislosť pre jednotlivé udalosti z nich nemožno určiť. Obe skúšania financovala spoločnosť Eli Lilly. [1]</p>
<p>U pacienta s CKD treba pri výraznej zmene hmotnosti zohľadniť aj hydratáciu, príjem potravy a funkčný stav. Hnačka alebo obmedzený príjem tekutín môžu pri malej renálnej rezerve viesť k objemovej deplécii. Výsledky týchto skúšaní nemožno priamo preniesť na dialyzovaných pacientov ani z nich odvodiť schopnosť retatrutidu spomaliť progresiu CKD. Uvedené dávky opisujú skúšobné ramená. [1]</p>
<hr><h2>Zdroje</h2><ol>
<li><small><em>Thomas J. Schnitzer, David J. Hunter, Philip G. Conaghan, Arya M. Sharma, Sue D. Pedersen, Kaiyi Chen, So Young Park, Nune Makarova, Kathryn Giblin, Tammy Forrester, TRIUMPH-4 and TRIUMPH-1-OA Investigators. Retatrutide Once Weekly in Adults with Knee Osteoarthritis Pain and Obesity. N Engl J Med. Online 8. novembra 2026. <a href="https://doi.org/10.1056/NEJMoa2610676" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43001755/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Miriam E. Tucker. Retatrutide Reduces Knee Osteoarthritis Pain and Weight, Improves Physical Function. Medscape. 9. novembra 2026. <a href="https://www.medscape.com/viewarticle/retatrutide-reduces-knee-osteoarthritis-pain-and-weight-2026a10016nb" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li></ol>
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
    'log_prefix' => 'add_retatrutid-bolest-kolena-obezita-triumph_article',
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
