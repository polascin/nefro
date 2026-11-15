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
    'title'        => 'Semaglutid v štúdii FLOW a obličkové výsledky pri diabete 2. typu',
    'slug'         => 'semaglutid-oblickove-vysledky-flow',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V štúdii FLOW bol pri semaglutide nižší hazard primárneho ukazovateľa aj užšieho ukazovateľa bez kardiovaskulárneho úmrtia.',
    'content'      => <<<'HTML'
<figure><img src="img/semaglutid-oblickove-vysledky-flow.webp" alt="Injekčné pero pri laboratórnych vzorkách a modeli obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V randomizovanej štúdii FLOW sa pri podkožnom semaglutide znížil výskyt udalostí v primárnom ukazovateli, ktorý zahŕňal aj kardiovaskulárne úmrtie. Priaznivý výsledok pretrval v užšom ukazovateli zloženom iba z obličkových príhod. Odhad účinku na začatie dlhodobej náhrady funkcie obličiek bol menej presný [1].</p>

<h2>Koho FLOW skúmala</h2>
<p>Do dvojito zaslepeného skúšania zaradili 3 533 dospelých s diabetom 2. typu a albuminurickou chronickou chorobou obličiek (CKD). Vstupná odhadovaná glomerulová filtrácia (eGFR) bola od 25 do 75 ml/min/1,73 m². Pri eGFR od 25 do menej ako 50 ml/min/1,73 m² musel byť pomer albumínu ku kreatinínu v moči vyšší ako 100 mg/g. Pri eGFR od 50 do 75 ml/min/1,73 m² musel byť vyšší ako 300 mg/g. V oboch skupinách bola horná hranica albuminúrie menej ako 5 000 mg/g [1].</p>
<p>Účastníci dostávali podkožný semaglutid s cieľovou dávkou 1 mg raz týždenne alebo placebo popri štandardnej liečbe. Liečba inhibítorom renínovo-angiotenzínového systému sa vyžadovala v najvyššej tolerovanej dávke, pokiaľ ju pacient mohol užívať. Nezávislý monitorovací výbor odporučil predčasné ukončenie skúšania po vopred plánovanej priebežnej analýze účinnosti. Medián sledovania bol 3,4 roka [1].</p>

<h2>Primárny ukazovateľ a jeho obličkové zložky</h2>
<p>Primárny ukazovateľ hodnotil čas do prvej z piatich udalostí. Patril sem pokles eGFR aspoň o 50 % oproti vstupu, eGFR pod 15 ml/min/1,73 m², začatie dlhodobej dialýzy alebo transplantácia obličky, úmrtie z obličkových príčin alebo kardiovaskulárne úmrtie. Pokles eGFR musel pretrvávať aspoň 28 dní. Užší ukazovateľ vynechal kardiovaskulárne úmrtie. Skupiny mali 1 767 a 1 766 účastníkov [1].</p>

<table><caption>Výsledky FLOW podľa definície udalosti</caption><thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Semaglutid</th><th scope="col">Placebo</th><th scope="col">Pomer hazardov (95 % interval spoľahlivosti)</th></tr></thead><tbody>
<tr><th scope="row">Primárny ukazovateľ vrátane kardiovaskulárneho úmrtia</th><td>331 (18,7 %)</td><td>410 (23,2 %)</td><td>0,76 (0,66 až 0,88)</td></tr>
<tr><th scope="row">Zložený ukazovateľ iba z obličkových príhod</th><td>218 (12,3 %)</td><td>260 (14,7 %)</td><td>0,79 (0,66 až 0,94)</td></tr>
<tr><th scope="row">Kardiovaskulárne úmrtie</th><td>123 (7,0 %)</td><td>169 (9,6 %)</td><td>0,71 (0,56 až 0,89)</td></tr>
</tbody></table>

<p>Hodnota 0,76 vyjadruje o 24 % nižší hazard primárneho ukazovateľa. Pri užšom obličkovom ukazovateli bol odhad o 21 % nižší. Kardiovaskulárne úmrtia teda nevysvetľujú celý priaznivý výsledok. Užší ukazovateľ bol podpornou analýzou. Jeho interval spoľahlivosti nebol upravený na viacnásobné porovnania. Počty z oboch ukazovateľov nemožno odčítať, aby sa zistil počet kardiovaskulárnych úmrtí. Pri každom ukazovateli sa čas do prvej udalosti počíta samostatne [1].</p>

<h2>Čo ukázali jednotlivé obličkové príhody</h2>
<p>Trvalý pokles eGFR aspoň o 50 % zaznamenali u 165 účastníkov pri semaglutide a u 213 pri placebe (pomer hazardov 0,73, 95 % interval spoľahlivosti od 0,59 do 0,89). Pri trvalej eGFR pod 15 ml/min/1,73 m² bol pomer hazardov 0,80 (od 0,61 do 1,06). Dlhodobú dialýzu alebo transplantáciu obličky potrebovalo 87 účastníkov pri semaglutide a 100 pri placebe (pomer hazardov 0,84, od 0,63 do 1,12). Úmrtia z obličkových príčin boli zriedkavé, po päť v každej skupine. Skúšanie preto neposkytlo presvedčivý samostatný dôkaz o znížení potreby náhrady funkcie obličiek [1, 2].</p>
<p>Priemerná eGFR klesala o 2,19 ml/min/1,73 m² za rok pri semaglutide a o 3,36 pri placebe. Modelový rozdiel bol 1,16 ml/min/1,73 m² za rok (95 % interval spoľahlivosti od 0,86 do 1,47). Ročná zmena eGFR bola jedným z potvrdzujúcich sekundárnych ukazovateľov. Vyjadruje priemerný vývoj funkcie obličiek počas sledovania [1].</p>

<h2>Význam pre nefrologickú ambulanciu</h2>
<p>FLOW poskytuje priamy randomizovaný dôkaz pre podkožný semaglutid u pacientov s diabetom 2. typu a albuminurickou CKD. Pri interpretácii pre jednotlivca je dôležité, do akej miery sa jeho eGFR, albuminúria a liečba podobajú podmienkam skúšania. Výsledky pre izolované začatie dialýzy alebo transplantáciu zostávajú neisté. Na nediabetickú CKD a na perorálnu formu semaglutidu sa výsledky FLOW priamo nevzťahujú. Štúdiu financovala spoločnosť Novo Nordisk [1, 2].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/">PubMed 38785209</a></em></small></li>
<li><small><em>Katherine R Tuttle, Johannes F E Mann, Manuel M Mayrdorfer, Brian Rayner, Giuseppe Pugliese, Richard E Pratley, Vlado Perkovic, Kenneth W Mahaffey, Naoki Kashihara, Ole K Jeppesen, Janusz Gumprecht, Ricardo Correa-Rotter, David Z I Cherney, Heidrun Bosch-Traberg, Mustafa Arici, Peter Rossing, FLOW Trial Investigators. Kidney and Survival Outcomes with Semaglutide by CKD Severity in the FLOW Trial. Clin J Am Soc Nephrol. 2026;21(5):841-851. <a href="https://doi.org/10.2215/CJN.0000000974">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41706532/">PubMed 41706532</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13143484/">Plný text</a></em></small></li>
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
    'log_prefix' => 'add_semaglutid_flow_oblicky',
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
