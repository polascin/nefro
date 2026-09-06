<?php

/**
 * add_baxdrostat-rezistentna-hypertenzia-bax24_article.php
 * Studia Bax24 - baxdrostat pri rezistentnej hypertenzii
 * (Azizi a spol., Lancet 2026;407(10532):988-999, doi 10.1016/S0140-6736(25)02549-8).
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
    'title'        => 'Baxdrostat výrazne znižuje 24-hodinový krvný tlak pri rezistentnej hypertenzii: výsledky štúdie Bax24',
    'slug'         => 'baxdrostat-rezistentna-hypertenzia-bax24',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Selektívny inhibítor aldosterónsyntázy znížil 24-hodinový ambulantný systolický tlak o 14,0 mm Hg viac než placebo. Za 12 týždňov, u 217 pacientov a s hyperkaliémiou nad 6,0 mmol/l u 3 % liečených.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Štrnásť milimetrov ortuti navyše v 24-hodinovom ambulantnom meraní je pri rezistentnej hypertenzii veľké číslo. Štúdia však trvala tri mesiace, primárny výsledok bol dostupný len u 85 % randomizovaných pacientov a chýba porovnanie so spironolaktónom — teda s liečbou, ktorú by baxdrostat mal nahradiť.</em></p>

<p>Selektívny inhibítor aldosterónsyntázy baxdrostat znížil v štúdii Bax24 priemerný 24-hodinový ambulantný systolický krvný tlak o <strong>14,0 mm Hg viac než placebo</strong>. Účinok sa dosiahol u pacientov s rezistentnou hypertenziou napriek súbežnej liečbe najmenej tromi antihypertenzívami vrátane diuretika.</p>

<p>Výsledok je klinicky významný a podporuje patofyziologickú úlohu neprimeranej tvorby aldosterónu pri rezistentnej hypertenzii. Krátke trvanie štúdie, neúplné ambulantné merania u časti randomizovaných pacientov a výskyt závažnej hyperkaliémie však zatiaľ neumožňujú posúdiť dlhodobý pomer prínosu a rizika.</p>

<h2>Rezistentná hypertenzia a úloha aldosterónu</h2>

<p>Rezistentná hypertenzia sa obvykle definuje ako krvný tlak nad cieľovou hodnotou napriek súčasnému užívaniu najmenej troch antihypertenzív rozdielnych skupín v maximálnych alebo maximálne tolerovaných dávkach, pričom jedno z nich má byť diuretikum. Za rezistentnú sa považuje aj hypertenzia kontrolovaná štyrmi alebo viacerými liekmi.</p>

<p>Pred potvrdením diagnózy treba vylúčiť <strong>pseudorezistenciu</strong> spôsobenú nesprávnou technikou merania, nedostatočnou adherenciou, suboptimálnymi dávkami alebo nevhodnou kombináciou liekov, efektom bieleho plášťa, liekmi a látkami zvyšujúcimi krvný tlak a nedostatočnou kontrolou príjmu sodíka a objemového preťaženia.</p>

<p>Ambulantné monitorovanie krvného tlaku je preto pri diagnostike rezistentnej hypertenzie kľúčové — umožňuje potvrdiť pretrvávajúcu hypertenziu mimo ambulancie, zhodnotiť nočný krvný tlak a vylúčiť významný efekt bieleho plášťa.</p>

<p>Aldosterón podporuje retenciu sodíka, zväčšenie extracelulárneho objemu, straty draslíka a vaskulárne aj tkanivové poškodenie. Jeho význam sa neobmedzuje na pacientov s jednoznačne diagnostikovaným primárnym aldosteronizmom: relatívne autonómna alebo neprimeraná tvorba aldosterónu môže prispievať k rezistentnej hypertenzii aj bez klasického biochemického obrazu.</p>

<h2>Mechanizmus účinku baxdrostatu</h2>

<p>Baxdrostat je perorálny selektívny inhibítor aldosterónsyntázy — enzýmu <strong>CYP11B2</strong>, ktorý katalyzuje záverečné kroky biosyntézy aldosterónu v kôre nadobličiek.</p>

<p>Vývoj tejto liekovej skupiny bol dlho obmedzený podobnosťou aldosterónsyntázy s enzýmom <strong>CYP11B1</strong>, potrebným na tvorbu kortizolu; nedostatočne selektívna inhibícia by mohla viesť k nežiaducej supresii kortizolu. Baxdrostat bol vyvinutý s vyššou selektivitou voči CYP11B2.</p>

<p>Na rozdiel od antagonistov mineralokortikoidového receptora neblokuje účinok aldosterónu na receptore, ale znižuje jeho <strong>syntézu</strong>. Ani tento mechanizmus však neodstraňuje riziko hyperkaliémie — zníženie biologického účinku aldosterónu obmedzuje vylučovanie draslíka obličkami rovnako.</p>

<h2>Usporiadanie štúdie Bax24</h2>

<p>Bax24 (NCT06168409) bola medzinárodná, randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy III v <strong>79 centrách v 22 krajinách</strong>. Zaradení mohli byť dospelí, ktorí napriek užívaniu najmenej troch antihypertenzív vrátane diuretika mali systolický krvný tlak v sede najmenej 140 a menej ako 170 mm Hg.</p>

<p>Po dvojtýždňovej úvodnej fáze s placebom boli pacienti s priemerným 24-hodinovým ambulantným systolickým tlakom najmenej 130 mm Hg randomizovaní v pomere 1 : 1 na <strong>baxdrostat 2 mg perorálne raz denne</strong> alebo placebo, a to počas 12 týždňov popri pôvodnej antihypertenzívnej liečbe. Randomizácia bola stratifikovaná podľa toho, či bol vstupný ambulantný systolický tlak nižší ako 140 alebo najmenej 140 mm Hg.</p>

<h3>Študijná populácia</h3>

<p>Od 1. marca 2024 do 16. apríla 2025 bolo vyšetrených <strong>854 pacientov</strong>, z ktorých bolo vyradených 636 (437 pred úvodnou placebovou fázou a 199 počas nej). Randomizovaných a liečených bolo <strong>217 pacientov</strong>: 108 na baxdrostate a 109 na placebe.</p>

<p><em>(Poznámka: 854 mínus 636 dáva 218, kým randomizovaných bolo 217. Ide o nezrovnalosť jedného pacienta priamo v publikovanom abstrakte, ktorú bez úplného diagramu priebehu štúdie nemožno vyriešiť.)</em></p>

<p>Muži tvorili 65 % (140 pacientov), ženy 35 % (77) a 78 % (170) účastníkov bolo bielej rasy. Medián veku bol 60,0 roka (medzikvartilové rozpätie 51,0 – 68,0).</p>

<p>Primárna analýza neobsahovala všetkých randomizovaných pacientov. Platné vstupné aj 12-týždňové ambulantné meranie bolo dostupné u <strong>89 pacientov</strong> v skupine s baxdrostatom a u <strong>95 pacientov</strong> v skupine s placebom — do primárnej analýzy tak vstúpilo 184 zo 217 randomizovaných (približne 85 %). Chýbajúce alebo neplatné ambulantné merania sa štatisticky <strong>nenahrádzali</strong>.</p>

<h2>Výrazné zníženie 24-hodinového systolického tlaku</h2>

<div class="table-responsive" role="region" aria-label="Primárny výsledok štúdie Bax24" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Skupina</th>
        <th scope="col">Zmena 24-hodinového ambulantného systolického tlaku</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Baxdrostat (n = 89)</th><td>−16,6 mm Hg</td><td>−18,8 až −14,3</td></tr>
      <tr><th scope="row">Placebo (n = 95)</th><td>−2,6 mm Hg</td><td>−4,7 až −0,4</td></tr>
      <tr><th scope="row"><strong>Rozdiel oproti placebu</strong></th><td><strong>−14,0 mm Hg</strong></td><td>−17,2 až −10,8; p &lt; 0,0001</td></tr>
    </tbody>
  </table>
</div>

<p>Ide o veľký antihypertenzný účinok, ktorý nemožno vysvetliť regresiou k priemeru ani efektom bieleho plášťa — výsledok vychádzal z <strong>24-hodinového ambulantného merania</strong> a bol porovnávaný s placebom. Pokles o 2,6 mm Hg v placebovom ramene navyše ukazuje, že samotné zaradenie do štúdie a opakované meranie prinášajú len malý efekt.</p>

<p>Účinok bol podľa autorov konzistentný v preddefinovaných podskupinách. Štúdia však nemusela mať dostatočnú štatistickú silu na spoľahlivé vylúčenie rozdielov medzi všetkými podskupinami.</p>

<h2>Bezpečnosť a hyperkaliémia</h2>

<div class="table-responsive" role="region" aria-label="Bezpečnostné výsledky štúdie Bax24" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Baxdrostat (n = 108)</th>
        <th scope="col">Placebo (n = 109)</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Akákoľvek nežiaduca udalosť</th><td>56 (52 %)</td><td>40 (37 %)</td></tr>
      <tr><th scope="row">Potvrdený draslík &gt; 6,0 mmol/l</th><td>3 (3 %)</td><td>0</td></tr>
    </tbody>
  </table>
</div>

<p>Hoci bol absolútny počet prípadov malý, draslík nad 6,0 mmol/l predstavuje <strong>klinicky závažnú hyperkaliémiu</strong> a v placebovom ramene sa nevyskytol ani raz. Rozdiel preto nemožno považovať za zanedbateľný.</p>

<p>Riziko v bežnej klinickej praxi môže byť <strong>vyššie</strong> než v štúdii, pretože zaradenie vyžadovalo zachovanú funkciu obličiek a normálnu vstupnú kaliémiu. Opatrnosť je potrebná najmä pri chronickej chorobe obličiek, diabete, vyššej vstupnej koncentrácii draslíka a súčasnej liečbe inhibítorom systému renín-angiotenzín alebo antagonistom mineralokortikoidového receptora.</p>

<p>Pri prípadnom klinickom používaní bude potrebné presne stanoviť kontraindikácie a liekové interakcie, intervaly kontroly draslíka a funkcie obličiek, postup pri interkurentnom ochorení a dehydratácii a kritériá dočasného prerušenia alebo ukončenia liečby.</p>

<h2>Čo štúdia preukázala a čo nie</h2>

<p>Bax24 presvedčivo ukázala, že baxdrostat pridaný k základnej liečbe počas 12 týždňov znižuje 24-hodinový ambulantný systolický tlak viac než placebo u vybranej populácie pacientov s rezistentnou hypertenziou. Sila dôkazu vychádza z randomizovaného a dvojito zaslepeného usporiadania, placebovej kontroly, potvrdenia hypertenzie ambulantným monitorovaním a klinicky významného rozdielu medzi skupinami.</p>

<p>Štúdia <strong>nepreukázala</strong>, že baxdrostat:</p>

<ul>
  <li>znižuje kardiovaskulárnu alebo celkovú mortalitu,</li>
  <li>znižuje výskyt infarktu myokardu, cievnej mozgovej príhody alebo srdcového zlyhávania,</li>
  <li>chráni funkciu obličiek,</li>
  <li>je bezpečný pri pokročilejšej chronickej chorobe obličiek,</li>
  <li>je dlhodobo bezpečnejší alebo účinnejší než spironolaktón,</li>
  <li>je účinnejší než iné inhibítory aldosterónsyntázy,</li>
  <li>odstraňuje potrebu vyšetrenia sekundárnych príčin hypertenzie.</li>
</ul>

<p>Štúdia trvala iba 12 týždňov a bola zameraná na krvný tlak, nie na klinické kardiovaskulárne alebo obličkové príhody.</p>

<h2>Metodologické obmedzenia</h2>

<h3>Neúplná primárna analýza</h3>

<p>Primárny výsledok bol dostupný len u 184 z 217 randomizovaných pacientov a chýbajúce merania sa nenahrádzali. Ak dôvody chýbajúcich údajov súviseli s účinnosťou alebo toleranciou liečby, mohol vzniknúť výberový bias. Veľkosť rozdielu medzi skupinami je napriek tomu taká výrazná, že neúplnosť údajov pravdepodobne nevysvetľuje celý účinok — znižuje však istotu presného odhadu jeho veľkosti.</p>

<h3>Krátke sledovanie a vybraná populácia</h3>

<p>Dvanásť týždňov postačuje na preukázanie antihypertenzného účinku, nie však na posúdenie jeho dlhodobej udržateľnosti, bezpečnosti a vplyvu na klinické príhody. Pacienti so zníženou funkciou obličiek, vstupnou hyperkaliémiou, veľmi vysokým krvným tlakom a niektorými sekundárnymi príčinami hypertenzie boli vylúčení — a práve u nich by bola potreba novej liečby najväčšia.</p>

<h3>Placebová úvodná fáza</h3>

<p>Dvojtýždňová fáza s placebom pomáhala identifikovať pacientov s nedostatočnou adherenciou. Sama však nemusí spoľahlivo potvrdiť dlhodobé užívanie všetkých základných antihypertenzív; na definitívne vylúčenie pseudorezistencie by boli najspoľahlivejšie objektívne metódy kontroly adherencie. Za povšimnutie stojí, že <strong>199 pacientov bolo vyradených až počas samotnej placebovej fázy</strong> — čo naznačuje, koľko „rezistentnej hypertenzie“ sa pri dôslednom overení rozplynie.</p>

<h3>Bez aktívneho komparátora</h3>

<p>Baxdrostat sa porovnával s placebom, nie so spironolaktónom. Štúdia preto neumožňuje tvrdiť, že inhibícia syntézy aldosterónu je účinnejšia alebo bezpečnejšia než blokáda mineralokortikoidového receptora.</p>

<h3>Priemyselné financovanie</h3>

<p>Štúdiu financovala spoločnosť AstraZeneca. Piati spoluautori sú jej zamestnancami a držiteľmi jej akcií a väčšina ostatných autorov je členmi výkonného výboru pre klinické štúdie baxdrostatu. Financovanie samo osebe výsledky neznehodnocuje, vyžaduje však transparentné uvedenie a nezávislé overenie dlhodobej účinnosti a bezpečnosti.</p>

<h2>Baxdrostat a spironolaktón</h2>

<p>Spironolaktón má pri rezistentnej hypertenzii rozsiahlu dôkazovú základňu a zostáva významnou terapeutickou možnosťou, pokiaľ ho pacient toleruje a umožňuje to koncentrácia draslíka a funkcia obličiek.</p>

<p>Baxdrostat môže mať teoretické výhody: znižuje tvorbu aldosterónu namiesto blokovania jeho receptora, nemá antiandrogénne a gestagénne účinky typické pre spironolaktón a môže obmedziť účinky aldosterónu aj mimo klasického mineralokortikoidového receptora.</p>

<p>Tieto mechanistické výhody však nepredstavujú dôkaz klinickej nadradenosti. <strong>Bez priamej randomizovanej porovnávacej štúdie nemožno baxdrostat označiť za účinnejšiu alebo bezpečnejšiu náhradu spironolaktónu.</strong> Hyperkaliémia zostáva spoločným rizikom oboch prístupov.</p>

<h2>Klinický význam</h2>

<p>Pokles priemerného 24-hodinového systolického tlaku o ďalších 14 mm Hg oproti placebu je výrazný. Ak by bol dlhodobo udržateľný a bezpečný, mohol by viesť k relevantnému zníženiu kardiovaskulárneho rizika — štúdia Bax24 však takýto vplyv priamo nehodnotila.</p>

<p>Pred použitím novej cielenej liečby zostáva nevyhnutné:</p>

<ol>
  <li>potvrdiť rezistentnú hypertenziu ambulantným alebo domácim meraním,</li>
  <li>objektivizovať adherenciu,</li>
  <li>optimalizovať dávky a kombináciu základných antihypertenzív,</li>
  <li>zabezpečiť primeranú diuretickú liečbu,</li>
  <li>obmedziť nadmerný príjem sodíka,</li>
  <li>vyšetriť sekundárne príčiny, najmä primárny aldosteronizmus a obštrukčné spánkové apnoe,</li>
  <li>zohľadniť funkciu obličiek a riziko hyperkaliémie.</li>
</ol>

<h2>Záver</h2>

<p>Baxdrostat v dávke 2 mg raz denne počas 12 týždňov znížil u pacientov s rezistentnou hypertenziou priemerný 24-hodinový ambulantný systolický krvný tlak o 14,0 mm Hg viac než placebo. Ide o klinicky významný výsledok, ktorý podporuje cielenú inhibíciu syntézy aldosterónu ako nový terapeutický prístup.</p>

<p>Najdôležitejším bezpečnostným signálom bola potvrdená koncentrácia draslíka nad 6,0 mmol/l u 3 % liečených pacientov oproti nulovému výskytu pri placebe. Na určenie miesta baxdrostatu v liečebnom algoritme budú potrebné dlhodobé štúdie, priame porovnanie so spironolaktónom a údaje o kardiovaskulárnych a obličkových výsledkoch.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nekontrolovana-rezistentna-hypertenzia-aldosteronova-os">Nekontrolovaná rezistentná hypertenzia a aldosterónová os</a>.</li>
  <li><a href="article.php?slug=renalna-denervacia-rezistentna-hypertenzia">Renálna denervácia pri rezistentnej hypertenzii</a> — nefarmakologická alternatíva.</li>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia RAASi a MRA pri riziku hyperkaliémie</a>.</li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pri hypertenzii: meranie a rozhodnutia</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Michel Azizi, Jenifer M. Brown, Jamie P. Dwyer, John M. Flack, Erica S. W. Jones, Raisa Kurlyandskaya, Hongjian Li, Filip Birve, Aina S. Lihn, Shira Perl, Markus P. Schlaich, Hirotaka Shibata, Ji-Guang Wang, Bryan Williams (za skupinu Bax24 investigators).</strong> <em>Effect of baxdrostat on ambulatory blood pressure in patients with resistant hypertension (Bax24): a phase 3, randomised, double-blind, placebo-controlled trial.</em> The Lancet. 2026;407(10532):988–999. <a href="https://doi.org/10.1016/S0140-6736(25)02549-8" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41794437/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>ClinicalTrials.gov, U.S. National Library of Medicine.</strong> <em>A Study to Investigate the Effect of Baxdrostat on Ambulatory Blood Pressure in Participants With Resistant Hypertension (Bax24), NCT06168409.</em> Zadávateľ AstraZeneca. <a href="https://clinicaltrials.gov/study/NCT06168409" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje — 79 centier v 22 krajinách, vstupný systolický tlak ≥ 140 a &lt; 170 mm Hg, dvojtýždňová placebová fáza, prah ambulantného tlaku ≥ 130 mm Hg, dávka 2 mg raz denne počas 12 týždňov, stratifikácia podľa hodnoty 140 mm Hg, nábor od 1. marca 2024 do 16. apríla 2025, 854 skrínovaných a 636 vyradených (437 pred fázou a 199 počas nej), 217 randomizovaných (108/109), 140 mužov (65 %), 77 žien (35 %), 170 bielej rasy (78 %), medián veku 60,0 roka (MKR 51,0 – 68,0), primárny výsledok −16,6 (−18,8 až −14,3) pri n = 89 oproti −2,6 (−4,7 až −0,4) pri n = 95 s rozdielom −14,0 (−17,2 až −10,8) a p &lt; 0,0001, nežiaduce udalosti 56 (52 %) oproti 40 (37 %), draslík nad 6,0 mmol/l u 3 (3 %) oproti 0 a financovanie spoločnosťou AstraZeneca — boli overené proti štruktúrovanému abstraktu v zázname PubMed. <strong>Zásadná oprava oproti pôvodnému spracovaniu:</strong> podklad uvádzal medzi autormi mená „George Thomas“ a „Gary Sirken“ — tieto osoby však <strong>nie sú autormi</strong>, ale figurujú v zozname spolupracujúcich skúšajúcich (<em>Bax24 investigators</em>). Zároveň chýbalo osem skutočných autorov (Hongjian Li, Filip Birve, Aina S. Lihn, Shira Perl, Markus P. Schlaich, Hirotaka Shibata, Ji-Guang Wang, Bryan Williams). Úplný autorský kolektív bol doplnený z metaúdajov PubMed a Crossref. Vstupné kritériá kaliémie (3,5 až &lt; 5,0 mmol/l) a eGFR (nad 45 ml/min/1,73 m²), podiel pacientov s dosiahnutým tlakom pod 130 mm Hg a počet ukončení liečby sa v abstrakte nenachádzajú a <strong>neboli nezávisle overené</strong>; plný text v <em>The Lancet</em> je za platobnou bariérou. Nezrovnalosť jedného pacienta (854 − 636 = 218 oproti 217 randomizovaným) je prítomná priamo v publikovanom abstrakte. Komentár k 199 pacientom vyradeným počas placebovej fázy a porovnanie so spironolaktónom sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_baxdrostat-rezistentna-hypertenzia-bax24_article',
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
