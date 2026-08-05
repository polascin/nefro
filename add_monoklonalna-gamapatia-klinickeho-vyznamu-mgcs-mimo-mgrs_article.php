<?php

/**
 * add_monoklonalna-gamapatia-klinickeho-vyznamu-mgcs-mimo-mgrs_article.php
 * MGCS mimo standardnej MGRS - prakticky prehlad pre nefrologa.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Monoklonálna gamapatia klinického významu mimo MGRS: čo má nefrológ poznať',
    'slug'         => 'monoklonalna-gamapatia-klinickeho-vyznamu-mgcs-mimo-mgrs',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nie každý monoklonálny proteín je nevinný nález a nie každé jeho poškodenie postihuje len obličky. Prehľad v NDT triedi MGCS podľa patogenity paraproteínu a upozorňuje na štyri jednotky, ktoré nefrológ nesmie prehliadnuť: POEMS, TEMPI, kapilárny leak syndróm a autoprotilátkami sprostredkované poruchy.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Monoklonálny proteín u staršieho pacienta býva náhodným a nevýznamným nálezom. V zriedkavých prípadoch je však priamou príčinou ochorenia — a to aj vtedy, keď klon nespĺňa kritériá malignity. Prehľad v <em>Nephrology Dialysis Transplantation</em> triedi tieto stavy podľa patogenity paraproteínu, nie podľa veľkosti klonu, a upozorňuje na štyri jednotky mimo klasickej MGRS.</em></p>

<h2>Od MGUS k MGCS: prečo na názvosloví záleží</h2>

<p>Monoklonálna gamapatia nejasného významu (MGUS) sa vyskytuje bežne u starších osôb. Podľa definície ide o benígny nález — rozšírená populácia klonálnych plazmatických a B-lymfocytov produkuje monoklonálnu protilátku, ktorá je <strong>biologicky neaktívna</strong>.</p>

<p>Autori prehľadu pripomínajú dôležitú skutočnosť, ktorá sa v praxi zabúda: <strong>aj pri zjavných plazmocytových neopláziách, ako je mnohopočetný myelóm, býva monoklonálna protilátka len ukazovateľom nádorovej záťaže, a nie priamo patogénnou</strong>. Jedinou výnimkou je nefropatia z odliatkov ľahkých reťazcov (<em>light chain cast nephropathy</em>), kde paraproteín pôsobí priamo škodlivo.</p>

<p>Rastie však poznanie, že v zriedkavých prípadoch môžu byť klonálne bunky a monoklonálna gamapatia <strong>patogénnym motorom ochorenia aj vtedy, keď nespĺňajú kritériá hematologickej malignity</strong>. Tieto stavy sa označujú ako monoklonálne gamapatie klinického významu (MGCS) — širší zastrešujúci pojem, pod ktorý patria aj monoklonálne gamapatie renálneho významu (MGRS).</p>

<p>Zmena názvoslovia nie je akademická. Prekladá sa do jednej klinickej otázky: <strong>je paraproteín u tohto pacienta príčinou, alebo len sprievodným nálezom?</strong> Odpoveď určuje, či liečiť klon, alebo ho len sledovať — a klasický onkologický pohľad na veľkosť klonu tu zlyháva, pretože pri MGCS býva klon malý a napriek tomu škodlivý.</p>

<h2>Mechanizmus namiesto nádorovej záťaže</h2>

<p>Prehľad preto ponúka <strong>klasifikáciu založenú na mechanizme</strong> — sústredenú na patogenitu paraproteínu, nie na klonálnu záťaž. Autori sa zameriavajú na MGCS mimo štandardnej MGRS a vyzdvihujú štyri jednotky, ktoré považujú za relevantné pre nefrológov:</p>

<ul>
  <li>POEMS syndróm,</li>
  <li>TEMPI syndróm,</li>
  <li>systémový kapilárny leak syndróm asociovaný s monoklonálnou gamapatiou,</li>
  <li>hematologické poruchy sprostredkované autoprotilátkami.</li>
</ul>

<h2>POEMS syndróm</h2>

<p>Akronym označuje polyneuropatiu, organomegáliu, endokrinopatiu, monoklonálny proteín a kožné zmeny (<em>skin changes</em>). Kľúčovým mediátorom je nadprodukcia vaskulárneho endotelového rastového faktora (VEGF), ktorá vysvetľuje mikroangiopatický charakter postihnutia.</p>

<p>Pre nefrológa sú podstatné tri body:</p>

<ul>
  <li><strong>Vedúcim príznakom je progresívna demyelinizačná polyneuropatia</strong>, ktorá sa spočiatku často mylne označí ako chronická zápalová demyelinizačná polyradikuloneuropatia.</li>
  <li><strong>Postihnutie obličiek nie je zriedkavé</strong> a má podobu membranoproliferatívneho vzoru s poškodením endotelu a mezangiolýzou — teda obraz blízky trombotickej mikroangiopatii, nie ukladaniu imunoglobulínu.</li>
  <li><strong>Monoklonálny proteín býva malý a takmer vždy s reštrikciou ľahkého reťazca lambda.</strong> Práve preto ho bežné vyšetrenie ľahko prehliadne.</li>
</ul>

<p>Pri podozrení má význam stanovenie VEGF v sére a cielené hľadanie sklerotických kostných lézií. Liečba smeruje proti klonu a pri včasnom zásahu môže byť neurologické aj renálne postihnutie čiastočne zvratné.</p>

<h2>TEMPI syndróm</h2>

<p>Akronym zahŕňa teleangiektázie, zvýšený erytropoetín s erytrocytózou, monoklonálnu gamapatiu, <strong>perirenálne kolekcie tekutiny</strong> a intrapulmonálny skrat.</p>

<p>Písmeno „P“ je pre nefrológa najdôležitejšie. Perirenálne kolekcie tekutiny sú neobvyklý nález a v kombinácii s nevysvetlenou erytrocytózou by mali na TEMPI upozorniť. Ide o kombináciu, ktorá sa inak vyskytuje len výnimočne — a keďže tento syndróm dobre odpovedá na liečbu zameranú proti plazmocytovému klonu, jeho rozpoznanie má priamy terapeutický dosah.</p>

<p>Typickou chybou je, že sa erytrocytóza vyšetruje hematologicky ako možná polycytémia, perirenálne kolekcie sa hodnotia rádiologicky ako neurčitý nález a obidva sa nikdy nespoja.</p>

<h2>Systémový kapilárny leak syndróm asociovaný s monoklonálnou gamapatiou</h2>

<p>Známy aj ako Clarksonova choroba, prebieha v epizódach masívneho úniku plazmy z ciev do interstícia. Klinicky ide o hypovolemický šok s <strong>hemokoncentráciou a hypoalbuminémiou</strong> — teda s kombináciou, ktorá je pri šoku nezvyčajná a mala by byť diagnostickým vodidlom.</p>

<p>Akútne poškodenie obličiek počas epizód je pravidelné a nefrológ býva prizvaný práve preň. Riziko je dvojaké:</p>

<ul>
  <li>počas fázy úniku vedie hypoperfúzia k akútnemu poškodeniu obličiek,</li>
  <li>v následnej fáze návratu tekutín do obehu hrozí naopak preťaženie objemom a pľúcny edém, ak sa v resuscitácii pokračuje príliš dlho.</li>
</ul>

<p>Veľká väčšina pacientov má monoklonálnu gamapatiu. Ak sa opakujúce sa epizódy nevysvetleného šoku liečia iba podpornou infúznou liečbou a paraproteín sa nikdy nevyšetrí, unikne diagnóza, pri ktorej existuje účinná profylaxia.</p>

<h2>Poruchy sprostredkované autoprotilátkami</h2>

<p>Do tejto skupiny patria stavy, v ktorých monoklonálna protilátka pôsobí ako autoprotilátka proti konkrétnemu cieľu — napríklad získaná von Willebrandova choroba, získaná hemofília, získaný deficit inhibítora C1 alebo choroba chladových aglutinínov.</p>

<p>Pre nefrológa je najrelevantnejšia posledná menovaná: hemolýza vedie k pigmentovej nefropatii a k akútnemu poškodeniu obličiek. Diagnostická pasca spočíva v tom, že sa nález uzavrie ako „autoimunitná hemolýza“ a monoklonálny pôvod protilátky sa nezisťuje — hoci práve on určuje liečbu.</p>

<h2>Praktický postup</h2>

<ol>
  <li><strong>Nepovažovať monoklonálny proteín automaticky za nevinný.</strong> Pri nevysvetlenom obličkovom alebo multisystémovom náleze patrí MGCS do diferenciálnej diagnostiky.</li>
  <li><strong>Hľadať systémový vzor.</strong> Neuropatia, kožné zmeny, erytrocytóza, opakované epizódy šoku alebo hemolýza posúvajú úvahu smerom k MGCS.</li>
  <li><strong>Použiť dostatočne citlivé vyšetrenia.</strong> Samotná elektroforéza bielkovín séra nestačí — pri malých klonoch a pri gamapatiách tvorených len ľahkými reťazcami je nutná <strong>imunofixácia a stanovenie voľných ľahkých reťazcov v sére</strong> vrátane ich pomeru.</li>
  <li><strong>Odlíšiť klon ako príčinu od klonu ako nálezu.</strong> Ide o jadro mechanistického prístupu prehľadu. Veľkosť klonu túto otázku nezodpovie.</li>
  <li><strong>Spolupracovať s hematológom včas.</strong> Liečba je pri MGCS zameraná proti klonu a jej cieľom je zastavenie orgánového poškodenia, nie dosiahnutie onkologickej remisie.</li>
</ol>

<h2>Limity</h2>

<p>Ide o <strong>prehľadový článok</strong> zhrňujúci literatúru o veľmi zriedkavých jednotkách. Publikované súbory sú malé, prevažne kazuistické, a preto sa z nich nedá odvodiť ani skutočná incidencia, ani prognóza či pravdepodobnosť odpovede na liečbu. Prehľad ponúka klasifikačný rámec a diagnostickú orientáciu, nie odporúčania podložené kontrolovanými štúdiami. Plný text nebol pri príprave tohto článku sprístupnený, preto sa jednotlivé klinické opisy opierajú o etablované poznatky o týchto syndrómoch a nie o argumentáciu autorov.</p>

<h2>Záver</h2>

<p>Hlavný prínos prehľadu je v posune otázky. Namiesto „aký veľký je klon?“ sa pýta „čo tento paraproteín robí?“. Pri MGCS je klon spravidla malý a kritériá malignity nespĺňa — napriek tomu spôsobuje orgánové poškodenie, ktoré je pri cielenej liečbe často zvratné.</p>

<p>Pre nefrológa z toho vyplýva praktické pravidlo: pri pacientovi s monoklonálnym proteínom a nevysvetlenými systémovými ťažkosťami nestačí zhodnotiť funkciu obličiek a označiť nález ako MGUS. Štyri jednotky, ktoré prehľad vyzdvihuje — POEMS, TEMPI, kapilárny leak syndróm a autoprotilátkami sprostredkované poruchy — majú spoločné to, že sa dajú prehliadnuť veľmi ľahko a liečiť pomerne dobre. Táto kombinácia z nich robí presne ten typ diagnóz, ktoré sa oplatí poznať.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=occam-hickam-diagnosticke-uvazovanie-nefrologia">Occam alebo Hickam?</a> — kedy hľadať jedno vysvetlenie a kedy počítať so súbehom.</li>
  <li><a href="article.php?slug=kolagenozy-klinicky-pohlad-nefrologa-diagnostika-organy">Kolagenózy z pohľadu nefrológa</a> — diagnostika multisystémového postihnutia.</li>
  <li><a href="article.php?slug=terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo">Terapie cielené na B-bunky pri imunitných ochoreniach obličiek</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Patrick Hofmann, Sujal I. Shah, Helmut G. Rennke, Rahel Schwotzer, David B. Sykes, Nelson Leung, Raad B. Chowdhury.</strong> <em>Monoclonal gammopathy of clinical significance: a guide for nephrologists.</em> Nephrology Dialysis Transplantation. 2026 Aug 3 (online ahead of print). doi: 10.1093/ndt/gfag173. <a href="https://pubmed.ncbi.nlm.nih.gov/42545758/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/ndt/gfag173" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Angela Dispenzieri.</strong> <em>Monoclonal gammopathies of clinical significance.</em> Hematology: American Society of Hematology Education Program. 2020;2020(1):380–388. doi: 10.1182/hematology.2020000122. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7727544/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, kompletné autorstvo aj doslovné znenie abstraktu prehľadu boli overené v zázname PubMed a Europe PMC. Priamo z abstraktu pochádzajú: vymedzenie MGUS ako benígneho nálezu s biologicky neaktívnou monoklonálnou protilátkou, konštatovanie, že aj pri zjavných plazmocytových neopláziách býva paraproteín len ukazovateľom nádorovej záťaže s výnimkou nefropatie z odliatkov ľahkých reťazcov, zavedenie pojmu MGCS ako zastrešujúceho rámca nad MGRS, klasifikácia založená na mechanizme a patogenite paraproteínu namiesto klonálnej záťaže, ako aj výslovné uvedenie štyroch jednotiek relevantných pre nefrológov. Plný text prehľadu je za platobnou bariérou vydavateľa a nebol sprístupnený. Klinické opisy jednotlivých syndrómov, diagnostické vodidlá a praktický postup sú <strong>vlastným odborným spracovaním</strong> opretým o etablované poznatky, nie citáciami z prehľadu.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_monoklonalna-gamapatia-klinickeho-vyznamu-mgcs-mimo-mgrs_article',
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
