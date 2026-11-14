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
    'title'        => 'Extrakorporálna fotoferéza pri BK polyomavírusovej infekcii po transplantácii obličky',
    'slug'         => 'fotoferaza-bk-polyomavirus-transplantacia-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Francúzsky register opísal pokles BKPyV DNAémie po fotoferéze. Čo ukazujú počty pacientov a akú úlohu mohla mať úprava imunosupresie?',
    'content'      => <<<'HTML'
<figure><a href="img/fotoferaza-bk-polyomavirus-transplantacia-oblicky.webp" target="_blank" rel="noopener noreferrer"><img src="img/fotoferaza-bk-polyomavirus-transplantacia-oblicky.webp" alt="Extrakorporálna fotoferéza po transplantácii obličky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Extrakorporálna fotoferéza po transplantácii obličky. Ilustračný obrázok.</figcaption></figure>
<p>Francúzsky multicentrický register opísal vývoj BK polyomavírusovej (BKPyV) DNAémie u 50 príjemcov obličky liečených extrakorporálnou fotoferézou (ECP). U mnohých pacientov s dostupnými kontrolnými odbermi DNAémia klesla pod hranicu detekcie. Súčasne sa znižovala imunosupresia a chýbala kontrolná skupina, takže samostatný prínos fotoferézy zostáva neznámy. [1]</p>

<h2>Koho liečili fotoferézou</h2>
<p>Register spojil retrospektívne a prospektívne údaje z 13 transplantačných centier. U 36 pacientov sa ECP začala bez súbežnej rejekcie a u 14 pri súbežnej rejekcii. Na začiatku ECP trvala DNAémia viac než tri mesiace u 56 % pacientov. Autori uvádzajú biopticky potvrdenú BKPyV nefropatiu u 55 %. Histologické nálezy neboli centrálne posúdené. Imunosupresia bola výrazne znížená už pred ECP a ďalej sa upravovala počas sledovania. [1]</p>

<h2>Virologické výsledky a funkcia štepu</h2>
<p>Po šiestich mesiacoch klesla DNAémia oproti začiatku ECP o viac než 1 log u 30 zo 43 hodnotiteľných pacientov a pod hranicu detekcie PCR u 21 zo 43. Po 12 mesiacoch išlo o 25 z 33, respektíve 18 z 33 pacientov. Autori pri poklese o viac než 1 log po roku uvádzajú 75 %. Zlomok 25/33 zodpovedá po zaokrúhlení 76 %, preto je presnejšie uviesť pôvodný počet. Negatívna PCR v krvi vyjadruje výsledok konkrétneho odberu. Histologický ústup nefropatie register pre malý počet kontrolných biopsií neumožnil vyhodnotiť. [1]</p>

<p>Podľa kritéria autorov bol sérový kreatinín stabilný alebo lepší u 26 zo 44 hodnotených pacientov po šiestich mesiacoch a u 19 z 35 po roku. Súhrnných 58 % vychádza zo 103 zo 176 opakovaných hodnotení kreatinínu a vyjadruje podiel hodnotení. Pri súbežnej rejekcii boli virologické výsledky podobné, ale ukazovatele funkcie štepu mali menej priaznivý priebeh. Skupiny boli malé a klinicky odlišné už pri začatí ECP. [1]</p>

<p>Počas sledovania sa zaznamenalo šesť nových epizód rejekcie, päť prípadov novovzniknutých protilátok špecifických proti darcovi a štyri straty štepu. Autori uvádzajú tri nežiaduce udalosti spojené s ECP: infekciu žilového prístupu, trombózu žilového prístupu a zrazenie krvi v mimotelovom okruhu. Malá kohorta umožňuje opísať zaznamenané komplikácie, ale presný odhad ich rizika neposkytuje. [1]</p>

<h2>Čo z registra vyplýva pre prax</h2>
<p>Základom liečby klinicky významnej BKPyV DNAémie alebo nefropatie zostáva podľa medzinárodného konsenzu postupné znižovanie imunosupresie podľa imunologického rizika a so sledovaním DNAémie a funkcie štepu. Súbežná rejekcia si vyžaduje individuálne rozhodnutie transplantačného tímu. Francúzsky register ukazuje, aké výsledky sa pozorovali pri kombinácii ECP s úpravou imunosupresie. Na určenie prínosu samotnej ECP by bolo potrebné prospektívne porovnanie s rovnakým postupom úpravy imunosupresie v oboch skupinách. [1, 2]</p>

<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Anne-Elisabeth Heng, Jean-François Augusto, Charlotte Colosio, Jean-Philippe Rerolle, Arwa Jalal Eddine, Nicolas Le-Berre, Lionel Rostaing, Bruno Pereira, Cyril Garrouste, Sophie Caillard. Real-world use of extracorporeal photopheresis for BK polyomavirus infection after kidney transplantation: results from the French multicenter registry. Front Immunol. 2026;17:1936468. <a href="https://doi.org/10.3389/fimmu.2026.1936468" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42990927/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Camille N. Kotton, Nassim Kamar, David Wojciechowski, Michael Eder, Helmut Hopfer, Parmjeet Randhawa, Martina Sester, Patrizia Comoli, Helio Tedesco Silva, Greg Knoll, Daniel C. Brennan, Jennifer Trofe-Clark, Lars Pape, David Axelrod, Bryce Kiberd, Germaine Wong, Hans H. Hirsch, Transplantation Society International BK Polyomavirus Consensus Group. The Second International Consensus Guidelines on the Management of BK Polyomavirus in Kidney Transplantation. Transplantation. 2024;108(9):1834-1866. <a href="https://doi.org/10.1097/TP.0000000000004976" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38605438/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_fotoferaza-bk-polyomavirus-transplantacia-oblicky_article',
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
