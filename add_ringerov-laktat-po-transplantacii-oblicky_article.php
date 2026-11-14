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
    'title'        => 'Ringerov laktát po transplantácii obličky v randomizovanej štúdii',
    'slug'         => 'ringerov-laktat-po-transplantacii-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Ringerov laktát viedol k vyššiemu bikarbonátu na štvrtý deň než dvojinfúzny protokol NaCl a glukózy. Čo štúdia ukázala o funkcii štepu?',
    'content'      => <<<'HTML'
<figure><a href="img/ringerov-laktat-po-transplantacii-oblicky.webp" target="_blank" rel="noopener noreferrer"><img src="img/ringerov-laktat-po-transplantacii-oblicky.webp" alt="Infúzne kryštaloidy v starostlivosti o obličkový štep" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Infúzne kryštaloidy v starostlivosti o obličkový štep. Ilustračný obrázok.</figcaption></figure>
<p>V otvorenej randomizovanej štúdii bol po transplantácii obličky sérový bikarbonát na štvrtý deň vyšší pri Ringerovom laktáte než pri protokole s 0,9 % NaCl a 5 % glukózou. Príjemcovia v skupine s Ringerovým laktátom tiež menej často potrebovali záchranné podanie bikarbonátu. Výsledok sa vzťahuje na dva konkrétne pooperačné infúzne postupy a najmä na príjemcov s včasnou funkciou štepu. [1]</p>
<h2>Čo sa v štúdii porovnávalo</h2>
<p>Štúdia prebehla v jednom thajskom transplantačnom centre. Randomizovali 159 dospelých príjemcov obličky od živého alebo zosnulého darcu. Ringerov laktát porovnali s aktívnou kontrolou, pri ktorej sa 0,9 % NaCl a 5 % glukóza podávali oddelenými infúziami s cieľom znížiť celkovú chloridovú záťaž. Objem infúzií sa prispôsoboval hodinovej diuréze. Výsledok preto nemožno priamo preniesť na porovnanie Ringerovho laktátu so samotným 0,9 % NaCl. [1]</p>
<p>Do vopred stanovenej modifikovanej analýzy podľa pôvodného priradenia (mITT) zahrnuli 134 príjemcov, po 67 v každom ramene. Po randomizácii vylúčili 25 pacientov, ktorí dostali menej než 2 litre študijnej tekutiny. Keďže objem závisel od diurézy, toto kritérium obmedzuje použiteľnosť výsledku pri výraznej skorej oligúrii alebo anúrii. [1]</p>
<h2>Bikarbonát na štvrtý deň a funkcia štepu po mesiaci</h2>
<p>Priemerný sérový bikarbonát na štvrtý pooperačný deň, primárny ukazovateľ, bol 19,39 oproti 17,31 mmol/l (p &lt; 0,001). Záchranný bikarbonát podľa protokolu dostalo 17,9 % oproti 58,2 % príjemcov (p &lt; 0,001). Koncentrácie chloridov boli na štvrtý deň porovnateľné, hoci na druhý a tretí deň boli pri Ringerovom laktáte nižšie. Acidobázický výsledok opisuje účinok celého infúzneho postupu vrátane následných zásahov. [1]</p>
<p>Po mesiaci bola priemerná eGFR 61,63 oproti 53,18 ml/min/1,73 m² (p = 0,028). Ide o sekundárny výsledok pri krátkom sledovaní. Oneskorená funkcia štepu sa zaznamenala u 2 zo 67 oproti 6 zo 67 pacientov (p = 0,14). Štúdia nepreukázala rozdiel v tomto klinickom ukazovateli. Pri močovom NGAL sa v podskupine príjemcov obličky od zosnulého darcu líšil podiel nad zvoleným prahom, ale porovnanie samotných koncentrácií nebolo štatisticky významné. Výsledky NGAL a cytokínov slúžia na tvorbu hypotéz. [1]</p>
<h2>Čo výsledok znamená pre voľbu infúzie</h2>
<p>Najistejším zistením je priaznivejší skorý acidobázický priebeh pri Ringerovom laktáte v porovnaní so skúmaným dvojinfúznym protokolom. Jednomesačný rozdiel eGFR si zaslúži potvrdenie v štúdii s dlhším sledovaním a klinickými ukazovateľmi. Samotný výsledok neopodstatňuje preberanie náhrady diurézy podľa rovnakého protokolu u pacienta s oligoanúriou. [1]</p>
<hr>
<h2>Zdroje</h2>
<ol><li><small><em>Kornrawee Sawasdichai, Chanyanuch Rakpithayanon, Sirihatai Konwai, Thunyatorn Wuttiputhanun, Nuttha Lumlertgul, Kirada Apisutimaitri, Rattanaporn Burimsittichai, Athaya Vorasittha, Pea Pobpan, Adis Tasanarong, Asada Leelahavanichkul, Natavudh Townamchai, Kearkiat Praditpornsilpa, Somchai Eiam-Ong, Yingyos Avihingsanon, Suwasin Udomkarnjananun. Randomized Clinical Trial of Ringer’s Lactate Versus Chloride-Reduced Saline-Dextrose in Postoperative Kidney Transplantation. Kidney Int Rep. 2026;11(11):107081. <a href="https://doi.org/10.1016/j.ekir.2026.107081" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42898223/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13677585/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li></ol>
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
    'log_prefix' => 'add_ringerov-laktat-po-transplantacii-oblicky_article',
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
