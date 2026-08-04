<?php

/**
 * add_teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia_article.php
 * Odborný článok o experimentálnom použití teclistamabu pri HLA senzibilizácii.
 *
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Teclistamab pred transplantáciou obličky: prvý klinický signál pri extrémnej HLA senzibilizácii',
    'slug'         => 'teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kazuistika v NEJM opisuje transplantáciu po experimentálnom znížení anti-HLA protilátok teclistamabom. Ide o dôležitý dôkaz konceptu, nie o potvrdený desenzibilizačný štandard.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>List publikovaný v New England Journal of Medicine opisuje úspešnú transplantáciu obličky po experimentálnom použití teclistamabu u extrémne HLA senzibilizovaného pacienta. Výsledok je biologicky presvedčivý a klinicky významný, ale zostáva dôkazom konceptu u jediného človeka.</em></p>

<p>Preformované anti-HLA protilátky patria medzi najťažšie imunologické prekážky transplantácie obličky. Predchádzajúca transplantácia, transfúzie alebo gravidita môžu vytvoriť široké spektrum protilátok proti HLA antigénom potenciálnych darcov. Čím väčšiu časť darcovskej populácie tieto protilátky vylučujú, tým menšia je pravdepodobnosť vhodnej ponuky orgánu a tým dlhšie môže pacient zostať na dialýze.</p>

<p>Martina Schatzl a spoluautori v júli 2026 opísali použitie teclistamabu, bispecifickej protilátky pôvodne vyvinutej pre mnohopočetný myelóm, na zníženie anti-HLA protilátok pred transplantáciou obličky. Publikácia má formu trojstranového listu, nie prospektívnej klinickej štúdie.</p>

<h2>Najprv oprava dôležitého pojmu: cPRA</h2>

<p>Skóre calculated panel-reactive antibody (cPRA) odhaduje percento darcov, s ktorými by bol kandidát imunologicky inkompatibilný na základe nahlásených neprijateľných HLA antigénov a ich frekvencie v referenčnej populácii. Vysoké cPRA preto znamená málo potenciálne kompatibilných darcov; hodnota blízka 100 % vyjadruje extrémnu senzibilizáciu.</p>

<p><strong>cPRA 0 % neznamená nulovú šancu na kompatibilného darcu.</strong> Znamená opak: vypočítaný podiel inkompatibilných darcov v referenčnej populácii je nulový alebo po zaokrúhlení minimálny. Formuláciu „nulová kompatibilita“ možno použiť iba ako slovný opis prakticky nulovej pravdepodobnosti nájsť vhodného darcu, nie ako synonymum cPRA 0 %. Východiskový text tieto dve veličiny zamieňal.</p>

<p>cPRA navyše nie je priamym meraním sily protilátok ani individuálneho rizika rejekcie konkrétneho štepu. Výsledné rozhodnutie závisí aj od špecificity protilátok, výsledku virtuálnej a fyzickej krížovej skúšky, charakteru darcu a od metodiky transplantačno-imunologického laboratória.</p>

<h2>Čo bolo opísané v kazuistike</h2>

<p>Autori opísali 37-ročného dialyzovaného pacienta po dvoch predchádzajúcich transplantáciách, ktorý bol pre mimoriadne širokú HLA senzibilizáciu na čakacej listine viac ako 12 rokov. Pravdepodobnosť imunologicky vhodnej ponuky orgánu bola podľa opisu prípadu prakticky nulová. Presnú východiskovú hodnotu cPRA však nemožno nahradiť nesprávnym zápisom „cPRA = 0 %“.</p>

<p>Počas 31 týždňov liečby teclistamabom poklesli hladiny vybraných anti-HLA protilátok natoľko, že transplantačný tím mohol prehodnotiť zoznam neprijateľných antigénov a rozšíriť okruh potenciálne prijateľných darcov. Následne sa našiel vhodný orgán a transplantácia sa uskutočnila. V čase krátkodobého hodnotenia mal pacient funkčný štep a nepotreboval dialýzu.</p>

<p>Tento priebeh ukazuje, že zásah do bunkového zdroja protilátok môže u starostlivo vybraného pacienta zmeniť praktickú transplantovateľnosť. Neurčuje však pravdepodobnosť úspechu u ďalších pacientov ani dlhodobé riziko protilátkami sprostredkovanej rejekcie.</p>

<h2>Prečo môže teclistamab znižovať anti-HLA protilátky</h2>

<p>Teclistamab je bispecifická protilátka namierená proti BCMA a CD3. Väzbou na BCMA na cieľovej bunke a na CD3 na T-lymfocyte privedie obe bunky do tesnej blízkosti a aktivuje T-bunkovú cytotoxicitu. V schválenej onkohematologickej indikácii tým ničí BCMA-pozitívne bunky mnohopočetného myelómu.</p>

<p>BCMA sa nachádza najmä na plazmablastoch a plazmatických bunkách, teda na bunkách, ktoré produkujú protilátky. Ich úbytok môže obmedziť ďalšiu tvorbu anti-HLA protilátok. Nejde však o okamžité odstránenie už cirkulujúceho IgG z plazmy. Účinok sa preto biologicky odlišuje od plazmaferézy alebo štiepenia IgG a môže nastupovať postupne.</p>

<p>Samotné zacielenie BCMA zároveň nemusí odstrániť celý imunologický zdroj senzibilizácie. Pamäťové B-lymfocyty môžu pretrvať a po opätovnej stimulácii obnoviť tvorbu protilátok. Aj preto sú potrebné údaje o dlhodobej dynamike protilátok pred transplantáciou a po nej.</p>

<h2>Pokles MFI nie je automaticky bezpečná transplantácia</h2>

<p>Anti-HLA protilátky sa často sledujú pomocou testov so single-antigen beads. Výsledok sa zvyčajne vyjadruje ako intenzita fluorescencie (MFI), ktorá je semikvantitatívnym laboratórnym signálom, nie univerzálnym titrom protilátky. MFI ovplyvňujú vlastnosti súpravy, interferencie, riedenie séra, laboratórny postup aj biologické vlastnosti protilátky.</p>

<p>Odstránenie konkrétneho HLA antigénu zo zoznamu neprijateľných antigénov preto nemá vychádzať z jedného všeobecného prahu. Vyžaduje opakované merania, posúdenie trendu, znalosti miestneho laboratória a začlenenie výsledku do celej imunologickej situácie. Pred transplantáciou zostávajú rozhodujúce donor-specific antibodies (DSA), virtuálna krížová skúška a podľa protokolu centra aj fyzická krížová skúška.</p>

<h2>Bezpečnosť je pri tejto indikácii otvorenou otázkou</h2>

<p>V Európskej únii je teclistamab schválený na liečbu dospelých s relabujúcim a refraktérnym mnohopočetným myelómom po najmenej troch predchádzajúcich liečebných režimoch určených v registračnej indikácii. Použitie na predtransplantačnú HLA desenzibilizáciu je mimo schválenej indikácie.</p>

<p>Medzi významné riziká teclistamabu patria syndróm uvoľnenia cytokínov, hypogamaglobulinémia, neutropénia, lymfopénia, trombocytopénia a infekcie vrátane pneumónie a sepsy. Závažná môže byť aj neurologická toxicita. Pri kandidátovi na transplantáciu sa k tomuto riziku následne pridáva indukčná a udržiavacia imunosupresia. Kazuistika jedného pacienta nemôže spoľahlivo určiť bezpečný interval medzi poslednou dávkou a transplantáciou, potrebu substitúcie imunoglobulínov, optimálnu antiinfekčnú profylaxiu ani dlhodobé riziko infekcií.</p>

<p>Pri budúcom skúšaní bude potrebné sledovať najmenej krvný obraz, imunoglobulíny, infekčné komplikácie, imunitnú rekonštitúciu, dynamiku HLA protilátok, DSA, výsledky krížových skúšok a biopsiou potvrdenú rejekciu. Takýto postup vyžaduje spoločný protokol transplantačného nefrológa, imunológa, hematológa, infektológa a transplantačného chirurga.</p>

<h2>Čo tento prípad dokazuje a čo nie</h2>

<p><strong>Publikácia podporuje biologickú uskutočniteľnosť.</strong> Ukazuje, že BCMA×CD3 T-bunkový engager môže u konkrétneho extrémne senzibilizovaného pacienta znížiť časť anti-HLA protilátkovej záťaže a rozšíriť reálny okruh darcov.</p>

<p><strong>Nedokazuje však populačnú účinnosť ani bezpečnosť.</strong> Chýba kontrolná skupina, vopred definovaný klinický výsledok, odhad frekvencie odpovede, porovnanie s inými desenzibilizačnými postupmi a dlhodobé sledovanie štepu. Nie je známe, ktoré imunologické profily budú odpovedať, aká dávka a dĺžka liečby sú optimálne ani či prínos preváži riziko u pacienta, ktorý má aj iné možnosti alokácie.</p>

<p>Súbežne sa skúmajú aj odlišné stratégie zamerané na zdroj protilátok. V roku 2026 bola napríklad publikovaná pilotná skúsenosť s kombinovanými CD19- a BCMA-cielenými CAR T-bunkami u dvoch vysoko senzibilizovaných kandidátov. CAR T-bunky a teclistamab však nie sú zameniteľné intervencie a ich výsledky nemožno spájať do jedného odhadu účinnosti.</p>

<h2>Praktický odkaz pre transplantačnú nefrológiu</h2>

<ol>
  <li><strong>Najprv využiť zavedené možnosti.</strong> Hodnotenie má zahŕňať alokačné zvýhodnenie vysoko senzibilizovaných kandidátov, program prijateľnej nezhody, párovú výmenu pri dostupnom živom darcovi a desenzibilizáciu podľa možností a protokolu centra.</li>
  <li><strong>Nezamieňať laboratórny signál s klinickým výsledkom.</strong> Pokles MFI alebo cPRA je dôležitý, ale cieľom je bezpečná transplantácia s dlhodobou funkciou štepu bez neprijateľného infekčného a rejekčného rizika.</li>
  <li><strong>Teclistamab zatiaľ nepoužívať rutinne.</strong> Mimo schválenej indikácie patrí nanajvýš do riadne schváleného klinického skúšania alebo výnimočného programu v centre so skúsenosťami s T-bunkovými engagermi a transplantáciou vysoko senzibilizovaných pacientov.</li>
  <li><strong>Vopred definovať úspech aj pravidlá zastavenia.</strong> Protokol musí určiť laboratórne ciele, bezpečnostné limity, načasovanie transplantácie, manažment hypogamaglobulinémie a infekcií aj následné sledovanie DSA a štepu.</li>
</ol>

<h2>Záver</h2>

<p>Kazuistika Schatzlovej a spoluautorov prináša dôležitý klinický signál: teclistamabom sprostredkované zacielenie BCMA-pozitívnych buniek môže znížiť anti-HLA protilátkovú záťaž natoľko, že sa transplantácia obličky stane uskutočniteľnou aj u extrémne senzibilizovaného pacienta. Najväčšou hodnotou publikácie je dôkaz biologického konceptu, nie návod na rutinnú liečbu.</p>

<p>Ďalší postup musí určiť systematický klinický výskum s presnou HLA charakterizáciou, jednotnými kritériami odpovede, aktívnym bezpečnostným dohľadom a dlhodobými výsledkami po transplantácii. Dovtedy má teclistamab v tejto oblasti zostať experimentálnou intervenciou.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Schatzl M, Mayer KA, Agis H, et al.</strong> <em>T-Cell Engager–Mediated HLA Antibody Depletion before Kidney Transplantation.</em> New England Journal of Medicine. 2026;395(5):511–513. doi: 10.1056/NEJMc2603853. <a href="https://pubmed.ncbi.nlm.nih.gov/42526030/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1056/NEJMc2603853" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Medical University of Vienna.</strong> <em>Kidney transplant despite poor initial conditions: New drug sustainably reduces immune response against donor organ.</em> 30. júla 2026. Sprievodná správa ku kazuistike s opisom klinického priebehu. <a href="https://www.meduniwien.ac.at/web/en/about-us/news/2026/news-in-july-2026/kidney-transplant-despite-poor-initial-conditions-new-drug-sustainably-reduces-immune-response-against-donor-organ/" target="_blank" rel="noopener noreferrer">MedUni Vienna</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Tecvayli (teclistamab): European public assessment report.</em> Aktuálna európska indikácia, mechanizmus účinku a bezpečnostné informácie. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/tecvayli" target="_blank" rel="noopener noreferrer">EMA</a>.</li>
  <li><strong>Health Resources and Services Administration.</strong> <em>CPRA Calculator: How Calculated Panel Reactive Antibodies score is calculated and used.</em> Revízia z decembra 2025. <a href="https://www.hrsa.gov/optn/data-calculators/allocation-calculators/cpra-calculator" target="_blank" rel="noopener noreferrer">Definícia cPRA</a>.</li>
  <li><strong>Noble J, Jouve T, Malvezzi P, Rostaing L.</strong> <em>Desensitization in Crossmatch-positive Kidney Transplant Candidates.</em> Transplantation. 2023;107(2):351–360. doi: 10.1097/TP.0000000000004279. <a href="https://pubmed.ncbi.nlm.nih.gov/35939390/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bhoj VG, Kaminski M, Zhao H, et al.</strong> <em>Kidney Transplantation in Two Highly Sensitized Candidates after CAR T-Cell Therapy.</em> New England Journal of Medicine. 2026;394(21):2117–2125. doi: 10.1056/NEJMoa2513428. <a href="https://pubmed.ncbi.nlm.nih.gov/42235014/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je list Schatzlovej a spoluautorov opisujúci jedného pacienta. Registračné informácie o teclistamabe a definícia cPRA pochádzajú z oficiálnych zdrojov. Závery nad rámec tejto kazuistiky sú označené ako výskumné otázky, nie ako odporúčanie na liečbu.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_teclistamab-pred-transplantaciou-oblicky-hla-senzibilizacia_article',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
