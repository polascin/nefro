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
    'title'        => 'Spironolaktón a finerenón pri chronickej chorobe obličiek',
    'slug'         => 'spironolakton-finerenon-ckd-sietova-metaanalyza',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Metaanalýza našla podobný pokles albuminúrie pri spironolaktóne 25 mg a finerenóne 20 mg. Dôkazy o dlhodobej ochrane obličiek a srdca sa líšia.',
    'content'      => <<<'HTML'
<figure><img src="img/spironolakton-finerenon-ckd-sietova-metaanalyza.webp" alt="Dve neoznačené tablety v blistroch pri nádobke na vzorku moču" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Tablety neznázorňujú konkrétne lieky.</figcaption></figure>

<p>Spironolaktón v dávke 25 mg a finerenón v dávke 20 mg dosiahli v sieťovej metaanalýze podobný pokles albuminúrie. Tento výsledok vychádza prevažne z nepriamych porovnaní. Pre rozhodovanie o liečbe je podstatné, že účinok na albuminúriu a účinok na zlyhanie obličiek či kardiovaskulárne príhody vyžadujú odlišné dôkazy [1].</p>

<h2>Čo sa porovnávalo</h2>
<p>Korucu a spoluautori zahrnuli 32 randomizovaných štúdií s 21 678 účastníkmi s chronickou chorobou obličiek (CKD). V bayesovskom modeli hodnotili jednotlivé kombinácie liečiva a dávky samostatne. Pre hlavný ukazovateľ, pomer albumínu ku kreatinínu v moči (UACR), poskytlo údaje 16 štúdií s 9 149 účastníkmi. V porovnaní so štandardnou starostlivosťou všetky hodnotené dávky antagonistov mineralokortikoidových receptorov (MRA) znižovali UACR. Pomer priemerov oproti štandardnej starostlivosti bol 0,64 pri spironolaktóne 25 mg (95 % bayesovský interval vierohodnosti od 0,55 do 0,75) a 0,66 pri finerenóne 20 mg (od 0,60 do 0,72) [1].</p>

<p>Odhady sa vzťahujú na spoločný porovnávací režim. Na vyhlásenie klinickej rovnocennosti oboch liekov by bolo potrebné priame porovnanie s vopred určenou hranicou rovnocennosti a klinicky dôležitými výsledkami. Prenositeľnosť nepriamych odhadov obmedzujú rozdiely v populáciách, dĺžke sledovania a sprievodnej liečbe. Súhrnná zmena odhadovanej glomerulovej filtrácie (eGFR) od vstupu do konca sledovania navyše zachytávala v niektorých štúdiách prevažne skorú fázu liečby. Z takto meranej zmeny nemožno určiť, ako liek ovplyvní dlhodobé tempo poklesu eGFR [1].</p>

<h2>Hyperkaliémia pri oboch liekoch</h2>
<p>Odhadovaný absolútny nárast rizika hyperkaliémie oproti štandardnej starostlivosti bol 4,9 percentuálneho bodu pri spironolaktóne 25 mg (95 % bayesovský interval vierohodnosti od 3,1 do 6,6) a 5,3 percentuálneho bodu pri finerenóne 20 mg (od 4,5 do 6,2). Metaanalýza neposkytla konzistentný dôkaz, že by jedna podtrieda MRA mala nižšie riziko pri všetkých dávkach. V metaregresii sa hyperkaliémia a ďalšie nežiaduce účinky vyskytovali častejšie v štúdiách s dlhším sledovaním a nižšou východiskovou eGFR. Dlhšie sledovanie dáva viac času na zachytenie udalostí. Výsledok na úrovni štúdií preto nepredpovedá riziko jednotlivca. Pri porovnaní treba zohľadniť aj vstupné hranice koncentrácie draslíka a spôsob jeho sledovania [1].</p>

<h2>Klinické výsledky v randomizovaných štúdiách</h2>
<p>Pri CKD s diabetom 2. typu má finerenón dôkazy z veľkých randomizovaných štúdií oproti placebu pri súbežnej blokáde systému renín-angiotenzín. Vo FIDELIO-DKD nastal primárny zložený výsledok, ktorý zahŕňal zlyhanie obličiek, pretrvávajúci pokles eGFR aspoň o 40 % alebo úmrtie z obličkovej príčiny, u 17,8 % pacientov pri finerenóne a u 21,1 % pri placebe (pomer hazardov 0,82, 95 % interval spoľahlivosti od 0,73 do 0,93). Vo FIGARO-DKD bol výskyt primárneho zloženého kardiovaskulárneho výsledku 12,4 % oproti 14,2 % (pomer hazardov 0,87, 95 % interval spoľahlivosti od 0,76 do 0,98). K rozdielu najviac prispelo menej hospitalizácií pre srdcové zlyhávanie [2, 3].</p>

<p>Spironolaktón bol tiež predmetom randomizovanej štúdie s klinickými výsledkami. V BARACK-D pri CKD prevažne v štádiu G3b neprinieslo pridanie 25 mg spironolaktónu k bežnej starostlivosti preukázaný pokles výskytu primárneho zloženého výsledku úmrtia a kardiovaskulárnych udalostí (pomer hazardov 1,05, 95 % interval spoľahlivosti od 0,81 do 1,37). Liečbu v prvých šiestich mesiacoch prerušili približne dve tretiny pacientov priradených k spironolaktónu. Výsledok treba čítať s ohľadom na odlišnú populáciu, časté ukončenie liečby a absenciu priameho porovnania s finerenónom [4].</p>

<p>FIND-CKD rozšírila dôkazy na dospelých s albuminurickou CKD bez diabetu. Za 32 mesiacov finerenón spomalil priemerný ročný pokles eGFR oproti placebu o 0,7 ml/min/1,73 m² (95 % interval spoľahlivosti od 0,3 do 1,1). Zložený obličkový alebo kardiovaskulárny výsledok bol sekundárnym ukazovateľom (pomer hazardov 0,77, 95 % interval spoľahlivosti od 0,60 do 0,99). Samostatné obličkové a kardiovaskulárne odhady boli menej presné. Pri interpretácii treba odlíšiť výsledok štúdie od schválenej indikácie [5, 6].</p>

<h2>Význam pre ambulantné rozhodovanie</h2>
<p>Pri rozhodovaní o predpise má prednosť cieľ liečby. U pacienta s albuminurickou CKD a diabetom 2. typu by zámena finerenónu za spironolaktón na základe podobného poklesu UACR znamenala spoliehať sa na nepriamy dôkaz o náhradnom ukazovateli. Pri samostatnej indikácii spironolaktónu sa rozhoduje podľa tejto indikácie, funkcie obličiek, koncentrácie draslíka a možností sledovania. Podľa aktuálneho európskeho súhrnu charakteristických vlastností lieku je obličkovou indikáciou finerenónu albuminurická CKD spojená s diabetom 2. typu. Pred začatím liečby treba overiť koncentráciu draslíka a eGFR a po začatí alebo úprave dávky ich sledovať podľa súhrnu charakteristických vlastností lieku [2, 3, 4, 6].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Berfu Korucu, Ayse Colak, Reem Mustafa, Amy Earley, David C Wheeler. Dose-Specific Network Meta-Analysis of Mineralocorticoid Receptor Antagonists in CKD. Kidney Int Rep. 2026;11(12):107084. <a href="https://doi.org/10.1016/j.ekir.2026.107084" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.ekir.2026.107084</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42965115/" target="_blank" rel="noopener noreferrer">PubMed 42965115</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13721858/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>George L Bakris, Rajiv Agarwal, Stefan D Anker, Bertram Pitt, Luis M Ruilope, Peter Rossing, Peter Kolkhof, Christina Nowack, Patrick Schloemer, Amer Joseph, Gerasimos Filippatos, FIDELIO-DKD Investigators. Effect of Finerenone on Chronic Kidney Disease Outcomes in Type 2 Diabetes. N Engl J Med. 2020;383(23):2219-2229. <a href="https://doi.org/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2025845</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33264825/" target="_blank" rel="noopener noreferrer">PubMed 33264825</a></em></small></li>
<li><small><em>Bertram Pitt, Gerasimos Filippatos, Rajiv Agarwal, Stefan D Anker, George L Bakris, Peter Rossing, Amer Joseph, Peter Kolkhof, Christina Nowack, Patrick Schloemer, Luis M Ruilope, FIGARO-DKD Investigators. Cardiovascular Events with Finerenone in Kidney Disease and Type 2 Diabetes. N Engl J Med. 2021;385(24):2252-2263. <a href="https://doi.org/10.1056/NEJMoa2110956" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2110956</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/34449181/" target="_blank" rel="noopener noreferrer">PubMed 34449181</a></em></small></li>
<li><small><em>F D Richard Hobbs, Richard J McManus, Clare J Taylor, Nicholas R Jones, Joy K Rahman, Jane Wolstenholme, Sungwook Kim, Joseph Kwon, Louise Jones, Jennifer A Hirst, Ly-Mee Yu, Sam Mort, BARACK-D Investigators. Low-dose spironolactone and cardiovascular outcomes in moderate stage chronic kidney disease: a randomized controlled trial. Nat Med. 2024;30(12):3634-3645. <a href="https://doi.org/10.1038/s41591-024-03263-5" target="_blank" rel="noopener noreferrer">DOI 10.1038/s41591-024-03263-5</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39349629/" target="_blank" rel="noopener noreferrer">PubMed 39349629</a></em></small></li>
<li><small><em>Hiddo J L Heerspink, Brendon L Neuen, Rajiv Agarwal, David Z I Cherney, Carolyn S P Lam, Katherine R Tuttle, Christoph Wanner, Pantelis Sarafidis, Niels Jongs, J David Smeijer, Meike Brinker, Nicole Rethemeier, Patrick Schloemer, Paula Vesterinen, David Goldsbury, Sara Dizayee, Jon W Mares, Vlado Perkovic, FIND-CKD Investigators. Finerenone in Persons with Chronic Kidney Disease without Diabetes. N Engl J Med. 2026;395(6):533-545. <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2604625</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42246672/" target="_blank" rel="noopener noreferrer">PubMed 42246672</a></em></small></li>
<li><small><em>Európska lieková agentúra. Kerendia. Súhrn charakteristických vlastností lieku, časti 4.1, 4.2 a 5.1. <a href="https://www.ema.europa.eu/en/documents/product-information/kerendia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
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
    'log_prefix' => 'add_spironolakton_finerenon_ckd',
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
