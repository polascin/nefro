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
    'title'        => 'Perorálny semaglutid v štúdii SOUL a obličkové výsledky',
    'slug'         => 'peroralny-semaglutid-soul',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V štúdii SOUL perorálny semaglutid spomalil priemerný pokles eGFR. Pri závažných obličkových príhodách sa štatisticky významný rozdiel nepreukázal.',
    'content'      => <<<'HTML'
<figure><img src="img/peroralny-semaglutid-soul.webp" alt="Tableta a pohár vody pri anatomickom modeli obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia perorálnej liečby vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V štúdii SOUL klesala odhadovaná glomerulová filtrácia (eGFR) pri perorálnom semaglutide pomalšie než pri placebe. Pri závažných obličkových príhodách sa štatisticky významný rozdiel nepreukázal. Oba výsledky treba čítať spolu. Priemerný ročný pokles eGFR opisuje vývoj funkcie obličiek počas sledovania, kým analýza klinických udalostí hodnotí, či pacient dospel napríklad k trvalému poklesu eGFR o polovicu alebo k začatiu dlhodobej náhrady funkcie obličiek [1, 2].</p>

<h2>Koho štúdia SOUL zaradila</h2>
<p>V dvojito zaslepenom randomizovanom skúšaní dostávalo 9 650 pacientov s diabetom 2. typu a aterosklerotickým kardiovaskulárnym ochorením, chronickou chorobou obličiek (CKD) alebo oboma ochoreniami perorálny semaglutid v dávke do 14 mg denne alebo placebo popri štandardnej liečbe. Priemerné sledovanie trvalo 47,5 mesiaca. Priemerná vstupná eGFR bola 73,8 ml/min/1,73 m². Hodnotu pod 60 ml/min/1,73 m² malo 29,2 % účastníkov a pod 30 ml/min/1,73 m² iba 2,5 %. Pacienti na dialýze a príjemcovia transplantovanej obličky boli pri vstupe vylúčení. Albuminúria sa nemerala, preto nemožno populáciu zaradiť do rizikových kategórií podľa kombinácie eGFR a albuminúrie [1, 2].</p>

<h2>Priemerný ročný pokles eGFR</h2>
<p>Priemerná ročná zmena eGFR bola −1,67 ml/min/1,73 m² pri semaglutide a −2,06 ml/min/1,73 m² pri placebe. Modelový rozdiel dosiahol 0,40 ml/min/1,73 m² za rok (95 % interval spoľahlivosti od 0,27 do 0,53). Autori ho odhadli z opakovaných meraní kreatinínu od vstupu do konca liečby. Ide o rozdiel medzi priemernými ročnými zmenami, ktorý nemožno priamo prepočítať na čas do dialýzy [1].</p>
<p>Pri vstupnej eGFR pod 60 ml/min/1,73 m² bol rozdiel v ročnej zmene 0,55 ml/min/1,73 m² (95 % interval spoľahlivosti od 0,31 do 0,80). Pri vyššej vstupnej eGFR bol 0,34 (od 0,19 do 0,49). Test interakcie neposkytol dôkaz, že sa účinok medzi týmito podskupinami líšil (<i>p</i> = 0,15) [1].</p>

<h2>Závažné obličkové príhody</h2>
<p>Päťzložkový ukazovateľ zahŕňal trvalý pokles eGFR aspoň o 50 %, trvalý pokles eGFR pod 15 ml/min/1,73 m², začatie dlhodobej náhrady funkcie obličiek, úmrtie z obličkových príčin alebo kardiovaskulárne úmrtie. Užší ukazovateľ vynechal kardiovaskulárne úmrtie. Každá skupina mala 4 825 účastníkov [1].</p>
<table><caption>Prvé udalosti v zložených ukazovateľoch SOUL</caption><thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Semaglutid</th><th scope="col">Placebo</th><th scope="col">Pomer hazardov (95 % interval spoľahlivosti)</th></tr></thead><tbody>
<tr><th scope="row">Päť zložiek vrátane kardiovaskulárneho úmrtia</th><td>403 (8,4 %)</td><td>435 (9,0 %)</td><td>0,91 (0,80 až 1,05)</td></tr>
<tr><th scope="row">Štyri obličkové zložky</th><td>112 (2,3 %)</td><td>129 (2,7 %)</td><td>0,86 (0,66 až 1,10)</td></tr>
</tbody></table>
<p>V primárnom kardiovaskulárnom ukazovateli SOUL sa preukázal prínos semaglutidu. Pri nasledujúcom päťzložkovom ukazovateli sa však hierarchické testovanie zastavilo (<i>p</i> = 0,19). Analýzy užšieho ukazovateľa a ročnej zmeny eGFR preto zostávajú exploračné. V oboch zložených ukazovateľoch intervaly spoľahlivosti pripúšťajú prínos aj malý nárast hazardu. Užší ukazovateľ mal málo udalostí, takže odhad je menej presný [1, 2].</p>

<h2>Ako výsledok použiť v nefrológii</h2>
<p>FLOW poskytla priamy dôkaz o znížení výskytu závažných obličkových príhod pri podkožnom semaglutide u pacientov s diabetom 2. typu a albuminurickou CKD. Rozdiel v zložení populácie, vstupnom obličkovom riziku a spôsobe podania obmedzuje priame porovnanie FLOW a SOUL. Pri perorálnom semaglutide v SOUL je doložený pomalší priemerný pokles eGFR. Účinok na závažné obličkové príhody zostáva neistý. Štúdiu SOUL financovala spoločnosť Novo Nordisk [1 až 3].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Johannes F E Mann, Nikolaus Marx, John E Deanfield, Scott S Emerson, Silvio E Inzucchi, Darren K McGuire, Sharon L Mulvagh, Rodica Pop-Busui, Neil R Poulter, Mads D M Engelmann, G Kees Hovingh, Nicolas Belmar, Thomas Idorn, Ole Kleist Jeppesen, Andreas L Birkenfeld, Aslam Amod, Boris Mankovsky, Cyrus Desouza, Juan J Gorgojo-Martinez, Rosario Arechavaleta, Shih-Te Tu, John B Buse, SOUL Study Group*. Impact of Oral Semaglutide on Kidney Outcomes in People With Type 2 Diabetes: Results From the SOUL Randomized Trial. Diabetes Care. 2026;49(2):257-265. <a href="https://doi.org/10.2337/dc25-1080">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41380027/">PubMed 41380027</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12824789/">Plný text</a></em></small></li>
<li><small><em>Darren K McGuire, Nikolaus Marx, Sharon L Mulvagh, John E Deanfield, Silvio E Inzucchi, Rodica Pop-Busui, Johannes F E Mann, Scott S Emerson, Neil R Poulter, Mads D M Engelmann, Maria Sejersten Ripa, G Kees Hovingh, Kirstine Brown-Frandsen, Stephen C Bain, Matthew A Cavender, Mette Gislum, Jens-Peter David, John B Buse, SOUL Study Group. Oral Semaglutide and Cardiovascular Outcomes in High-Risk Type 2 Diabetes. N Engl J Med. 2025;392(20):2001-2012. <a href="https://doi.org/10.1056/NEJMoa2501006">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40162642/">PubMed 40162642</a></em></small></li>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/">PubMed 38785209</a></em></small></li>
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
    'log_prefix' => 'add_peroralny_semaglutid_soul',
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
