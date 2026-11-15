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
    'title'        => 'Obličkové výsledky semaglutidu v štúdiách SELECT, FLOW a SOUL',
    'slug'         => 'semaglutid-select-flow-soul',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Spoločná analýza ukázala menej obličkových udalostí aj po vyradení kardiovaskulárneho úmrtia z ukazovateľa. Rozsah dôkazov sa líši u pacientov s diabetom a bez neho.',
    'content'      => <<<'HTML'
<figure><img src="img/semaglutid-select-flow-soul.webp" alt="Ilustračné injekčné pero pri modeli obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Vo vopred plánovanej spoločnej analýze štúdií SELECT, FLOW a SOUL sa pri semaglutide vyskytlo menej závažných obličkových príhod a úmrtí zahrnutých do zloženého ukazovateľa. Rozdiel pretrval aj po vylúčení kardiovaskulárneho úmrtia z ukazovateľa. Pre klinickú interpretáciu je rozhodujúce, koho jednotlivé štúdie zaradili. FLOW skúmala pacientov s diabetom 2. typu a albuminurickou chronickou chorobou obličiek (CKD). SOUL zahŕňala širšiu populáciu s diabetom a vysokým kardiovaskulárnym rizikom. Údaje o ľuďoch bez diabetu pochádzajú zo SELECT [1 až 4].</p>

<h2>Čo ukázala spoločná analýza</h2>
<p>Mann a spoluautori spojili individuálne údaje 30 787 účastníkov troch randomizovaných skúšaní. Priemerné sledovanie v jednotlivých skúšaniach trvalo 39,5 až 47,5 mesiaca. Primárny ukazovateľ spoločnej analýzy zahŕňal trvalý pokles odhadovanej glomerulovej filtrácie (eGFR) aspoň o 50 %, zlyhanie obličiek (trvalá eGFR pod 15 ml/min/1,73 m² alebo začatie liečby nahrádzajúcej funkciu obličiek), úmrtie z obličkových príčin alebo kardiovaskulárne úmrtie. Hodnotil sa čas do prvej z týchto udalostí [1].</p>
<p>Prvú udalosť primárneho ukazovateľa zaznamenali u 973 účastníkov pri semaglutide a u 1 134 pri placebe. Pomer hazardov (HR) bol 0,84 (95 % interval spoľahlivosti od 0,77 do 0,91). V užšom sekundárnom ukazovateli bez kardiovaskulárneho úmrtia išlo o 347 oproti 416 udalostiam (HR 0,80, od 0,69 do 0,92). Pretrvávajúci rozdiel v užšom ukazovateli podporuje účinok na obličkové výsledky. HR 0,80 sa vzťahuje na celý užší ukazovateľ, ktorý zahŕňal aj trvalý pokles eGFR. Samostatný účinok na potrebu dialýzy sa z neho nedá vyčísliť [1].</p>

<h2>S diabetom 2. typu</h2>
<p><strong>FLOW.</strong> U 3 533 pacientov s diabetom 2. typu a albuminurickou CKD sa skúšal podkožný semaglutid 1 mg týždenne. Primárny ukazovateľ vrátane kardiovaskulárneho úmrtia dosiahlo 331 z 1 767 účastníkov pri semaglutide a 410 z 1 766 pri placebe (HR 0,76, 95 % interval spoľahlivosti od 0,66 do 0,88). Pri samostatnom zložení obličkových udalostí bez kardiovaskulárneho úmrtia bol HR 0,79 (od 0,66 do 0,94). Ide o priamy randomizovaný dôkaz v populácii s diabetom a albuminurickou CKD [2].</p>
<p><strong>SOUL.</strong> U 9 650 pacientov s diabetom 2. typu a aterosklerotickým kardiovaskulárnym ochorením, CKD alebo oboma ochoreniami sa skúšal perorálny semaglutid v dávke do 14 mg denne. Priemerná vstupná eGFR bola 73,8 ml/min/1,73 m². V samostatnej analýze SOUL sa pri zloženom ukazovateli s kardiovaskulárnym úmrtím štatisticky významný rozdiel nepreukázal (HR 0,91, 95 % interval spoľahlivosti od 0,80 do 1,05), rovnako ani pri užšom obličkovom ukazovateli (HR 0,86, od 0,66 do 1,10). Ročný pokles eGFR bol pri semaglutide pomalší o 0,40 ml/min/1,73 m² (od 0,27 do 0,53). Zmena sklonu eGFR a výskyt závažných obličkových udalostí sú odlišné výsledky [3].</p>

<h2>Bez diabetu</h2>
<p><strong>SELECT.</strong> Štúdia zaradila 17 604 dospelých s nadváhou alebo obezitou a preukázaným kardiovaskulárnym ochorením bez diabetu. CKD nebola podmienkou zaradenia. Podkožný semaglutid 2,4 mg týždenne sa v pôvodnej obličkovej analýze spájal s nižším výskytom vopred určeného zloženého ukazovateľa (1,8 % oproti 2,2 %, HR 0,78, 95 % interval spoľahlivosti od 0,63 do 0,96). Ukazovateľ SELECT zahŕňal aj vznik pretrvávajúcej makroalbuminúrie. Tá do spoločného ukazovateľa troch štúdií nevstupovala. Údaj HR 0,78 preto patrí k pôvodnej definícii výsledku SELECT [1, 4].</p>
<p>SELECT rozširuje dôkazy na ľudí bez diabetu s nadváhou alebo obezitou a preukázaným kardiovaskulárnym ochorením. Prenos na širšiu populáciu s nediabetickou CKD bez týchto vstupných charakteristík zostáva neistý. Keďže stav diabetu, klinický profil, dávka aj spôsob podania sa medzi skúšaniami líšili súčasne, ich výsledky neumožňujú pripísať rozdiely samotnému diabetu ani priamo porovnať perorálnu a injekčnú formu [1 až 4].</p>

<h2>Čo z výsledkov použiť v ambulancii</h2>
<p>Pri posudzovaní očakávaného obličkového prínosu má zmysel vychádzať zo štúdie, ktorej populácii sa pacient najviac podobá. Spoločný odhad spresňuje priemerný účinok naprieč troma skúšaniami. Pri individuálnom rozhodovaní zostávajú podstatné vstupná eGFR, albuminúria, diabetes a prítomnosť kardiovaskulárneho ochorenia. Spoločnú analýzu financovala spoločnosť Novo Nordisk [1 až 4].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Johannes F E Mann, Sunil V Badve, Florian M M Baeres, Nicolas Belmar, Kirstine Brown-Frandsen, John B Buse, Helen M Colhoun, John E Deanfield, Mads D M Engelmann, G Kees Hovingh, Thomas Idorn, A Michael Lincoff, Ildiko Lingvay, Kenneth W Mahaffey, Darren K McGuire, Richard E Pratley, Søren Rasmussen, Peter Rossing, Naveed Sattar, Katherine R Tuttle, Vlado Perkovic. Effect of semaglutide on kidney outcomes in the SELECT, FLOW, and SOUL trials: a prespecified pooled analysis. Lancet Diabetes Endocrinol. 2026;14(10):818-830. <a href="https://doi.org/10.1016/S2213-8587(26)00134-8">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42567173/">PubMed 42567173</a></em></small></li>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/">PubMed 38785209</a></em></small></li>
<li><small><em>Johannes F E Mann, Nikolaus Marx, John E Deanfield, Scott S Emerson, Silvio E Inzucchi, Darren K McGuire, Sharon L Mulvagh, Rodica Pop-Busui, Neil R Poulter, Mads D M Engelmann, G Kees Hovingh, Nicolas Belmar, Thomas Idorn, Ole Kleist Jeppesen, Andreas L Birkenfeld, Aslam Amod, Boris Mankovsky, Cyrus Desouza, Juan J Gorgojo-Martinez, Rosario Arechavaleta, Shih-Te Tu, John B Buse, SOUL Study Group*. Impact of Oral Semaglutide on Kidney Outcomes in People With Type 2 Diabetes: Results From the SOUL Randomized Trial. Diabetes Care. 2026;49(2):257-265. <a href="https://doi.org/10.2337/dc25-1080">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41380027/">PubMed 41380027</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12824789/">Plný text</a></em></small></li>
<li><small><em>Helen M Colhoun, Ildiko Lingvay, Paul M Brown, John Deanfield, Kirstine Brown-Frandsen, Steven E Kahn, Jorge Plutzky, Koichi Node, Alexander Parkhomenko, Lars Rydén, John P H Wilding, Johannes F E Mann, Katherine R Tuttle, Thomas Idorn, Naveen Rathor, A Michael Lincoff. Long-term kidney outcomes of semaglutide in obesity and cardiovascular disease in the SELECT trial. Nat Med. 2024;30(7):2058-2066. <a href="https://doi.org/10.1038/s41591-024-03015-5">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38796653/">PubMed 38796653</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11271413/">Plný text</a></em></small></li>
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
    'log_prefix' => 'add_semaglutid_select_flow_soul',
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
