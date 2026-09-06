<?php

/**
 * add_kompletna-remisia-proteinurie-igan-protect-post-hoc_article.php
 * Post hoc analyza studie PROTECT - kompletna remisia proteinurie pri IgAN
 * (Heerspink a spol., CJASN 2026;21(4):578-592, doi 10.2215/CJN.0000000961).
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
    'title'        => 'Kompletná remisia proteinúrie pri IgA nefropatii súvisí s pomalším poklesom glomerulovej filtrácie',
    'slug'         => 'kompletna-remisia-proteinurie-igan-protect-post-hoc',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pacienti štúdie PROTECT, ktorí dosiahli proteinúriu pod 0,3 g/deň, strácali eGFR šesťkrát pomalšie. Ide však o post hoc analýzu, v ktorej remisia nebola randomizovaná — a u tretiny z nich sa proteinúria vrátila.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Rozdiel je pôsobivý: −0,7 oproti −4,2 ml/min/1,73 m² za rok. Skupiny však nevznikli randomizáciou, ale podľa toho, ako pacient na liečbu odpovedal — a odpoveď je zároveň prognostickým znakom. Čo z toho zostane, keď sa to zohľadní?</em></p>

<p>Proteinúria patrí medzi najvýznamnejšie prognostické ukazovatele progresie IgA nefropatie. Nová <em>post hoc</em> analýza štúdie PROTECT ukázala, že pacienti, ktorí počas liečby dosiahli proteinúriu nižšiu ako 0,3 g/deň, mali podstatne pomalší pokles odhadovanej glomerulovej filtrácie (eGFR) a menej kombinovaných obličkových príhod než pacienti bez takejto odpovede.</p>

<p>Výsledky podporujú súčasný liečebný cieľ — čo najvýraznejšie a dlhodobé zníženie proteinúrie. Pre metodologické obmedzenia však z tejto analýzy nemožno vyvodiť, že samotné dosiahnutie remisie bolo <strong>príčinou</strong> priaznivejšieho výsledku.</p>

<h2>Štúdia PROTECT</h2>

<p>PROTECT (NCT03762850) bola medzinárodná, randomizovaná, dvojito zaslepená štúdia fázy III s aktívnou kontrolou. Zahŕňala 404 dospelých pacientov s biopsiou potvrdenou primárnou IgA nefropatiou, 24-hodinovou proteinúriou najmenej 1,0 g/deň a eGFR najmenej 30 ml/min/1,73 m², ktorí mali pretrvávajúcu proteinúriu napriek stabilnej maximálnej tolerovanej dávke inhibítora ACE alebo blokátora receptora AT1. Randomizovaní boli na <strong>sparsentan</strong> alebo <strong>irbesartan</strong> v maximálnej schválenej dávke.</p>

<p>Sparsentan je nesteroidová molekula, ktorá súčasne antagonizuje receptor typu A pre endotelín a receptor AT1 pre angiotenzín II — <strong>duálny antagonista endotelínového a angiotenzínového receptora (DEARA)</strong>. Na rozdiel od kombinácie dvoch samostatných liekov ide o jednu molekulu s dvojitým mechanizmom účinku.</p>

<p>Táto <em>post hoc</em> analýza sa však nezaoberala iba porovnaním oboch liekov. Pacientov rozdelila podľa toho, či počas sledovania dosiahli kompletnú remisiu proteinúrie — <strong>bez ohľadu na pôvodne pridelenú liečbu</strong>. To je pre interpretáciu kľúčové.</p>

<h2>Ako bola definovaná kompletná remisia</h2>

<p>Kompletná remisia proteinúrie bola definovaná ako 24-hodinové vylučovanie bielkovín močom nižšie ako 0,3 g/deň <strong>aspoň pri jednej návšteve</strong>. Autori hodnotili dve skupiny:</p>

<ul>
  <li><strong>CR36:</strong> kompletná remisia dosiahnutá najneskôr do 36. týždňa,</li>
  <li><strong>CR110:</strong> kompletná remisia dosiahnutá kedykoľvek do 110. týždňa.</li>
</ul>

<div class="table-responsive" role="region" aria-label="Dosiahnutie kompletnej remisie podľa liečebného ramena" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Skupina</th>
        <th scope="col">Počet (podiel zo 404)</th>
        <th scope="col">Sparsentan</th>
        <th scope="col">Irbesartan</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">CR36</th><td>43 (11 %)</td><td>35 (81 %)</td><td>8 (19 %)</td></tr>
      <tr><th scope="row">CR110</th><td>85 (21 %)</td><td>62 (73 %)</td><td>23 (27 %)</td></tr>
    </tbody>
  </table>
</div>

<p>Kompletná remisia bola teda výrazne častejšia pri liečbe sparsentanom — ale nastala aj u časti pacientov na maximálnej dávke irbesartanu.</p>

<h2>Remisia proteinúrie a vývoj eGFR</h2>

<p>Pacienti, ktorí dosiahli kompletnú remisiu, vykazovali rýchlejšie a výraznejšie zníženie proteinúrie už počas prvých šiestich týždňov a rozdiel pretrvával. V 110. týždni dosahovala modelovaná zmena 24-hodinového pomeru bielkovín ku kreatinínu v moči:</p>

<ul>
  <li><strong>−73 %</strong> (95 % IS −77 až −68) u pacientov s CR110,</li>
  <li><strong>−3 %</strong> (95 % IS −11 až +6) u pacientov bez CR110.</li>
</ul>

<p>Rozdiel sa prejavil aj vo vývoji funkcie obličiek:</p>

<div class="table-responsive" role="region" aria-label="Vývoj eGFR podľa dosiahnutia kompletnej remisie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">CR110</th>
        <th scope="col">Bez CR110</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Absolútna zmena eGFR do 110. týždňa</th><td>−4,0 ml/min/1,73 m²</td><td>−8,6 ml/min/1,73 m²</td></tr>
      <tr><th scope="row">Celkový sklon eGFR (1. deň – 110. týždeň)</th><td>−0,7 ml/min/1,73 m²/rok</td><td>−4,2 ml/min/1,73 m²/rok</td></tr>
      <tr><th scope="row">Chronický sklon eGFR (6. týždeň – 110. týždeň)</th><td>−0,4 (−1,4 až 0,6)</td><td>−4,2 (−4,7 až −3,7)</td></tr>
    </tbody>
  </table>
</div>

<p>Chronický sklon vylučuje úvodnú hemodynamickú zmenu počas prvých šiestich týždňov, a je preto z patofyziologického hľadiska informatívnejší. Jeho interval spoľahlivosti u pacientov s remisiou (−1,4 až 0,6) <strong>zahŕňa nulu</strong> — v tejto skupine teda nemožno vylúčiť ani úplnú stabilizáciu funkcie obličiek počas sledovaných dvoch rokov.</p>

<h2>Vzťah medzi úrovňou proteinúrie a poklesom eGFR</h2>

<p>Analýza nezistila iba rozdiel medzi kompletnou remisiou a jej nedosiahnutím. Pacienti boli rozdelení podľa dosiahnutej proteinúrie do kategórií pod 0,3 g/deň, 0,3 až menej ako 0,5 g/deň, 0,5 až menej ako 1,0 g/deň a najmenej 1,0 g/deň — a s rastúcou reziduálnou proteinúriou sa <strong>progresívne zrýchľoval</strong> aj pokles eGFR.</p>

<p>Nešlo teda o ostro ohraničený prahový jav. Výsledky skôr naznačujú kontinuálny vzťah, v ktorom je každé ďalšie zníženie proteinúrie spojené s pomalšou stratou funkcie obličiek. To je klinicky užitočnejšia predstava než binárne „remisia áno/nie“.</p>

<h2>Kombinovaný obličkový ukazovateľ</h2>

<p>Kombinovaný ukazovateľ zahŕňal potvrdený pokles eGFR najmenej o 40 %, zlyhanie obličiek alebo začatie náhrady funkcie obličiek a úmrtie z akejkoľvek príčiny. Vyskytol sa u <strong>jedného pacienta s CR110 (1 %)</strong> a u <strong>43 pacientov bez CR110 (14 %)</strong>. U pacientov s remisiou do 36. týždňa sa počas hodnoteného obdobia nevyskytol vôbec.</p>

<p>Absolútny počet príhod bol v skupine s remisiou veľmi malý (jedna udalosť). Výsledok preto nemožno interpretovať ako presný odhad veľkosti klinického účinku ani ako dôkaz, že dosiahnutie remisie samo osebe zabránilo zlyhaniu obličiek. Formulácia „menej prípadov zlyhania obličiek“ navyše nie je presná — ukazovateľ zahŕňal aj 40-percentný pokles eGFR a úmrtie z akejkoľvek príčiny.</p>

<h2>Krvný tlak a bezpečnosť</h2>

<p>Pacienti s kompletnou remisiou dosiahli väčší úvodný pokles systolického aj diastolického krvného tlaku; rozdiel oproti pacientom bez remisie sa následne pohyboval okolo <strong>4 mm Hg</strong>. Lepšia kontrola krvného tlaku preto mohla nezávisle prispieť k pomalšiemu poklesu eGFR — proteinúria a krvný tlak sa tu nedajú oddeliť.</p>

<div class="table-responsive" role="region" aria-label="Bezpečnostné údaje podľa dosiahnutia remisie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">CR110 (n = 85)</th>
        <th scope="col">Bez CR110 (n = 319)</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Akákoľvek nežiaduca udalosť</th><td>79 (93 %)</td><td>285 (89 %)</td></tr>
      <tr><th scope="row">Udalosti spojené s hypotenziou</th><td>14 (16 %)</td><td>32 (10 %)</td></tr>
      <tr><th scope="row">Ukončenie liečby pre nežiaduce účinky</th><td>3 (4 %)</td><td>34 (11 %)</td></tr>
      <tr><th scope="row">Ukončenie na želanie pacienta</th><td>2 (2 %)</td><td>24 (8 %)</td></tr>
    </tbody>
  </table>
</div>

<p>Vyšší výskyt hypotenzných udalostí u pacientov s remisiou je logický — ide o dôsledok silnejšieho hemodynamického účinku, ktorý zároveň proteinúriu znižoval.</p>

<p>Nižší podiel ukončení liečby v skupine s remisiou však <strong>nemožno interpretovať tak, že remisia znižuje toxicitu</strong>. Vzťah je opačný: pacient, ktorý liečbu predčasne ukončí, má menšiu príležitosť neskoršiu remisiu vôbec dosiahnuť. To isté platí o ukončení na vlastné želanie.</p>

<h2>Prečo výsledky nepreukazujú kauzalitu</h2>

<p>Analýza bola <em>post hoc</em> a skupiny neboli randomizované podľa dosiahnutia remisie. Pacienti, ktorí remisiu dosiahli, mali už na začiatku <strong>priaznivejší rizikový profil</strong>: nižšiu východiskovú proteinúriu, vyššiu vstupnú eGFR, nižší vek a o 1 až 2 mm Hg nižší krvný tlak.</p>

<p>Remisia bola navyše definovaná podľa výsledku, ktorý vznikol až počas liečby. Pacient musel zostať v štúdii dostatočne dlho a pokračovať v liečbe, aby mohol byť zaradený medzi tých s remisiou. Takéto rozdelenie prináša riziko reziduálneho skreslenia, spätnej kauzality a skreslenia súvisiaceho s časom potrebným na dosiahnutie remisie (<em>immortal time bias</em>).</p>

<p>Štatistické analýzy boli prevažne založené na údajoch získaných počas liečby, hodnoty významnosti boli <strong>nominálne</strong> a Kaplanova-Meierova analýza kombinovaného ukazovateľa nebola určená na kauzálnu interpretáciu.</p>

<h3>Remisia nemusela byť trvalá</h3>

<p>Z 85 pacientov s CR110 sa proteinúria neskôr aspoň pri jednej návšteve zvýšila nad 0,75 g/deň u <strong>30 pacientov (35 %)</strong>, s mediánom času do tohto vzostupu 24,2 týždňa. Jednorazové dosiahnutie hodnoty pod 0,3 g/deň teda nemožno stotožňovať s dlhodobou stabilnou remisiou — a viac než tretina „remitentov“ ju nedokázala udržať ani pol roka.</p>

<h2>Klinický význam</h2>

<p>Výsledky podporujú proteinúriu ako praktický ukazovateľ liečebnej odpovede a dlhodobého obličkového rizika pri IgA nefropatii. Sú v súlade s odporúčaniami KDIGO, podľa ktorých sa má proteinúria udržiavať pod 0,5 g/deň a podľa možnosti pod 0,3 g/deň.</p>

<p>Z analýzy však <strong>nemožno odvodiť, že každý farmakologický zásah, ktorý krátkodobo zníži proteinúriu pod 0,3 g/deň, automaticky prinesie rovnakú ochranu funkcie obličiek</strong>. Pri hodnotení liečby treba zohľadniť trvanie antiproteinurického účinku, vývoj eGFR, krvný tlak, bezpečnosť, znášanlivosť a celkový klinický profil pacienta.</p>

<p>Sparsentan dosahoval kompletnú remisiu častejšie než maximálna dávka irbesartanu. Predložená analýza však predovšetkým ukazuje, že <strong>veľmi nízka dosiahnutá proteinúria je priaznivým prognostickým markerom</strong>. Nie je samostatným randomizovaným dôkazom, že rozdiel medzi pacientmi s remisiou a bez nej bol spôsobený výlučne sparsentanom.</p>

<h2>Praktický dôsledok pre ambulanciu</h2>

<p>Ak by sme z tejto analýzy mali vyvodiť jediné pravidlo, znelo by takto: <strong>proteinúria je pri IgA nefropatii ukazovateľ, ktorý sa oplatí sledovať opakovane, nie raz</strong>. Jedna hodnota pod 0,3 g/deň je dobrá správa, ale u tretiny pacientov nevydrží. Rozhodujúca je hodnota udržaná v čase — a práve tú treba dokumentovať pred rozhodnutím o zmene alebo ukončení liečby.</p>

<h2>Záver</h2>

<p>Dosiahnutie proteinúrie pod 0,3 g/deň bolo v štúdii PROTECT spojené s výrazne pomalším poklesom eGFR (−0,7 oproti −4,2 ml/min/1,73 m² za rok) a menším počtom kombinovaných obličkových príhod (1 % oproti 14 %). Kompletnú remisiu dosahovali podstatne častejšie pacienti liečení sparsentanom než irbesartanom.</p>

<p>Výsledky podporujú intenzívnu, bezpečnú a dlhodobú kontrolu proteinúrie ako jeden z hlavných liečebných cieľov pri IgA nefropatii. Pre <em>post hoc</em> charakter analýzy, vstupné rozdiely medzi skupinami a definovanie remisie až počas sledovania však ide o <strong>silnú prognostickú asociáciu, nie o dôkaz priameho príčinného účinku remisie</strong>.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus liečby IgA nefropatie podľa KDIGO 2025</a>.</li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept pri IgA nefropatii</a> — iná cesta k zníženiu proteinúrie.</li>
  <li><a href="article.php?slug=atacicept-trutakna-iga-nefropatia-fda-proteinuria">Atacicept a proteinúria pri IgA nefropatii</a>.</li>
  <li><a href="article.php?slug=upcr-vs-uacr-riziko-zlyhania-obliciek-ckd">UPCR oproti UACR</a> — ako sa proteinúria meria a prečo na tom záleží.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Hiddo J. L. Heerspink, Brad H. Rovin, Radko Komers, Bruce Hendry, Alex Mercer, Priscila Preciado, Edward Murphy, Vladimir Tesař.</strong> <em>Association between Complete Proteinuria Remission and Kidney Function in the Phase 3 PROTECT Trial of Sparsentan in IgA Nephropathy.</em> Clinical Journal of the American Society of Nephrology. 2026;21(4):578–592. <a href="https://doi.org/10.2215/CJN.0000000961" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41428405/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13065159/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>ClinicalTrials.gov, U.S. National Library of Medicine.</strong> <em>A Study of the Effect and Safety of Sparsentan in the Treatment of Patients With IgA Nephropathy (PROTECT), NCT03762850.</em> Inštitucionálny zdroj bez menovaných osobných autorov. <a href="https://clinicaltrials.gov/study/NCT03762850" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes, KDIGO IgA Nephropathy Guideline Work Group.</strong> <em>Clinical Practice Guideline for the Management of IgA Nephropathy and IgA Vasculitis.</em> <a href="https://kdigo.org/guidelines/iga-nephropathy/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje — 404 randomizovaných a liečených pacientov, CR36 u 43 (11 %; 35 sparsentan / 8 irbesartan) a CR110 u 85 (21 %; 62 / 23), zmena UPCR −73 % (−77 až −68) oproti −3 % (−11 až +6), absolútna zmena eGFR −4,0 oproti −8,6 ml/min/1,73 m², celkový sklon −0,7 oproti −4,2 a chronický sklon −0,4 (−1,4 až 0,6) oproti −4,2 (−4,7 až −3,7) ml/min/1,73 m²/rok, kombinovaný ukazovateľ u 1 % oproti 14 %, rozdiel krvného tlaku okolo 4 mm Hg, vzostup proteinúrie nad 0,75 g/deň u 30 z 85 pacientov (35 %, medián 24,2 týždňa), nežiaduce udalosti 93 % oproti 89 %, hypotenzné udalosti 16 % oproti 10 %, ukončenie liečby pre nežiaduce účinky 4 % oproti 11 % a na želanie pacienta 2 % oproti 8 % — boli overené proti plnému textu publikácie v PMC a proti abstraktu v zázname PubMed. <strong>Opravy oproti pôvodnému spracovaniu:</strong> modelovaná zmena proteinúrie v 110. týždni je <strong>−73 % a −3 %</strong>, nie 76 % a 5 %; ukončenie liečby pre nežiaduce účinky bolo 4 % oproti 11 %, nie 4,6 % v oboch skupinách. Doplnené bolo financovanie spoločnosťou <strong>Travere Therapeutics</strong> (výrobcom sparsentanu), ktorú podklad neuvádzal a ktorej štyria zamestnanci sú spoluautormi práce, ako aj medián času do relapsu proteinúrie. Registračné číslo štúdie je NCT03762850. Metodologické komentáre — vrátane upozornenia na immortal time bias a na to, že nižší podiel ukončení liečby v skupine s remisiou je dôsledkom, nie príčinou — sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kompletna-remisia-proteinurie-igan-protect-post-hoc_article',
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
