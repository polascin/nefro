<?php

/**
 * add_iptakopan-iga-nefropatia-applause-igan-24-mesiacov_article.php
 * Konecne 24-mesacne vysledky studie APPLAUSE-IgAN
 * (Barratt a spol., N Engl J Med 2026;395(5):465-477, doi 10.1056/NEJMoa2600743).
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
    'title'        => 'Iptakopan spomaľuje pokles funkcie obličiek pri IgA nefropatii: konečné 24-mesačné výsledky štúdie APPLAUSE-IgAN',
    'slug'         => 'iptakopan-iga-nefropatia-applause-igan-24-mesiacov',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Inhibítor faktora B spomalil ročný pokles eGFR o polovicu a znížil riziko kombinovaného obličkového ukazovateľa o 43 %. Bezpečnostný profil však nie je totožný s placebom: závažné infekcie 6,7 % oproti 2,1 %.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Prvý raz máme z dlhodobej štúdie fázy III dôkaz, že selektívna inhibícia alternatívnej cesty komplementu pri IgA nefropatii ovplyvní nielen proteinúriu, ale aj stratu funkcie obličiek. Cenou je trojnásobný výskyt závažných infekcií — a to je pri komplementovej blokáde údaj, ktorý sa nedá odbiť poznámkou o „porovnateľnej bezpečnosti“.</em></p>

<p>Konečná analýza randomizovanej štúdie fázy III APPLAUSE-IgAN preukázala, že pridanie iptakopanu k podpornej liečbe významne spomalilo pokles odhadovanej glomerulovej filtrácie (eGFR) u dospelých pacientov s IgA nefropatiou a pretrvávajúcou proteinúriou. Liečba zároveň znížila riziko kombinovaného ukazovateľa progresie ochorenia obličiek.</p>

<h2>Komplement v patogenéze IgA nefropatie</h2>

<p>IgA nefropatia je imunitne podmienené glomerulové ochorenie s výraznou klinickou aj biologickou heterogenitou. Jej patogenéza sa zvyčajne vysvetľuje viacúderovým modelom: zvýšená tvorba galaktózovo deficitného IgA1, vznik protilátok proti nemu, tvorba cirkulujúcich imunokomplexov, ich ukladanie v glomerulovom mezangiu a následná aktivácia mezangiálnych buniek, komplementu a zápalových mechanizmov.</p>

<p>V obličkách pacientov s IgA nefropatiou sa často nachádzajú depozitá C3 spolu s IgA. Zastúpenie zložiek alternatívnej a lektínovej cesty komplementu a vzťah niektorých komplementových markerov k nepriaznivej prognóze podporujú význam komplementu v patogenéze ochorenia.</p>

<p>Alternatívna cesta funguje ako <strong>amplifikačný mechanizmus</strong> aktivácie komplementu bez ohľadu na to, ktorou cestou sa aktivácia začala. Faktor B je nevyhnutnou súčasťou C3-konvertázy alternatívnej cesty; jeho inhibíciou sa obmedzuje štiepenie C3, ďalšia amplifikácia, tvorba C5-konvertázy a následná tvorba terminálneho komplexu C5b-9.</p>

<p>Tvrdenie, že aktivácia komplementu je jediným alebo univerzálne dominantným mechanizmom IgA nefropatie, by však bolo nepresné. Ide o jednu z viacerých vzájomne prepojených zložiek patogenézy a jej význam sa medzi pacientmi pravdepodobne líši — čo je zároveň dôvod, prečo nemožno očakávať rovnakú odpoveď u všetkých.</p>

<h2>Mechanizmus účinku iptakopanu</h2>

<p>Iptakopan je perorálne podávaný selektívny inhibítor faktora B. Zasahuje <strong>proximálnu</strong> časť alternatívnej cesty komplementu a neblokuje klasickú ani lektínovú cestu priamo. Inhibícia faktora B má obmedziť amplifikáciu aktivácie C3, tvorbu C3a a C5a, depozíciu fragmentov C3, vznik terminálneho komplexu C5b-9 a komplementom sprostredkovaný zápal.</p>

<p>Iptakopan sa už klinicky používa pri niektorých ďalších ochoreniach spojených s dysreguláciou komplementu. Účinnosť a bezpečnosť však nemožno automaticky prenášať medzi rozdielnymi diagnózami — každá indikácia vyžaduje samostatné hodnotenie pomeru prínosu a rizika.</p>

<h2>Usporiadanie štúdie APPLAUSE-IgAN</h2>

<p>APPLAUSE-IgAN (NCT04578834) bola medzinárodná, multicentrická, randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy III. Zaradení boli dospelí pacienti s biopsiou potvrdenou primárnou IgA nefropatiou, eGFR najmenej 30 ml/min/1,73 m² a 24-hodinovým pomerom bielkovín ku kreatinínu v moči najmenej 1 g/g <strong>napriek podpornej liečbe</strong>.</p>

<p>Pacienti boli randomizovaní v pomere 1 : 1 na iptakopan 200 mg perorálne dvakrát denne alebo placebo dvakrát denne. Obe skupiny pokračovali v podpornej liečbe zahŕňajúcej stabilnú maximálnu tolerovanú dávku inhibítora ACE alebo blokátora receptora AT1. Liečba inhibítorom SGLT2 bola povolená, ale nebola podmienkou zaradenia; pri vstupe ju dostávala približne pätina pacientov.</p>

<p>Randomizovaných bolo 478 pacientov, konečná analýza primárneho výsledku zahŕňala <strong>477 pacientov</strong> — 238 na iptakopane a 239 na placebe. Tieto dva údaje treba rozlišovať.</p>

<h2>Primárny výsledok: spomalenie poklesu eGFR</h2>

<p>Primárnym výsledkom konečnej analýzy bol celkový anualizovaný sklon eGFR počas 24 mesiacov.</p>

<div class="table-responsive" role="region" aria-label="Primárny a hlavný sekundárny výsledok štúdie APPLAUSE-IgAN" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Iptakopan (n = 238)</th>
        <th scope="col">Placebo (n = 239)</th>
        <th scope="col">Rozdiel / efekt</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Anualizovaný sklon eGFR</th>
        <td>−3,10 ml/min/1,73 m²/rok</td>
        <td>−6,12 ml/min/1,73 m²/rok</td>
        <td>3,02 (95 % IS 2,02 – 4,01); upravené p &lt; 0,001</td>
      </tr>
      <tr>
        <th scope="row">Kombinovaný obličkový ukazovateľ</th>
        <td>21,4 %</td>
        <td>33,5 %</td>
        <td>HR 0,57 (95 % IS 0,40 – 0,81); upravené p = 0,003</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Iptakopan teda v priemere <strong>znížil ročnú stratu eGFR približne o polovicu</strong>. Absolútne spomalenie o 3,02 ml/min/1,73 m² za rok je klinicky významné, najmä ak by sa udržalo počas dlhšieho obdobia. Dvojročná štúdia však nedokazuje, že veľkosť účinku zostane nezmenená počas ďalších rokov.</p>

<p>Za povšimnutie stojí aj rýchlosť poklesu v placebovom ramene: −6,12 ml/min/1,73 m² za rok napriek podpornej liečbe. Ide o populáciu s vysokým rizikom progresie, ktorá by pri nezmenenom tempe smerovala k zlyhaniu obličiek v horizonte rádovo jedného desaťročia.</p>

<h2>Proteinúria</h2>

<p>Predchádzajúca deväťmesačná analýza preukázala, že iptakopan znížil 24-hodinový pomer bielkovín ku kreatinínu v moči v porovnaní s placebom o <strong>38,3 %</strong>. Tento údaj vyjadruje <em>porovnávací</em> účinok oproti placebu — nemožno ho zamieňať s percentuálnymi zmenami v jednotlivých ramenách, ktoré sú zo svojej podstaty vyššie.</p>

<p>Pokles proteinúrie sa prejavil už v prvých mesiacoch a predchádzal rozdielu v poklese eGFR. Tento časový priebeh je biologicky konzistentný s nefroprotektívnym účinkom, hoci nepreukazuje, že celý účinok na eGFR bol sprostredkovaný iba znížením proteinúrie.</p>

<h2>Kombinovaný výsledok progresie ochorenia obličiek</h2>

<p>Kombinovaný ukazovateľ zahŕňal <strong>pretrvávajúci pokles eGFR najmenej o 30 %</strong>, pretrvávajúcu eGFR nižšiu ako 15 ml/min/1,73 m², začatie udržiavacej dialýzy, transplantáciu obličky alebo úmrtie v dôsledku zlyhania obličiek.</p>

<p>Udalosť sa vyskytla u 21,4 % pacientov na iptakopane oproti 33,5 % na placebe; pomer rizík 0,57 (95 % IS 0,40 – 0,81; upravené p = 0,003). Relatívne riziko sa teda znížilo približne o 43 % a absolútny rozdiel predstavoval <strong>12,1 percentuálneho bodu</strong>, čo zodpovedá počtu pacientov potrebných na liečbu (NNT) približne osem až deväť počas dvoch rokov.</p>

<p>Tento výpočet je však odvodený zo zloženého ukazovateľa, ktorého najčastejšou súčasťou pravdepodobne nebolo terminálne zlyhanie obličiek, ale 30-percentný pokles eGFR. <strong>Nie je preto presné opisovať výsledok jednoducho ako 43-percentné zníženie rizika zlyhania obličiek.</strong></p>

<h2>Bezpečnosť</h2>

<div class="table-responsive" role="region" aria-label="Bezpečnostné výsledky štúdie APPLAUSE-IgAN" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Iptakopan</th>
        <th scope="col">Placebo</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Akákoľvek nežiaduca udalosť</th><td>87,0 %</td><td>89,1 %</td></tr>
      <tr><th scope="row">Závažná nežiaduca udalosť</th><td>12,2 %</td><td>11,7 %</td></tr>
      <tr><th scope="row">Závažná infekcia</th><td><strong>6,7 %</strong></td><td><strong>2,1 %</strong></td></tr>
      <tr><th scope="row">Úmrtie</th><td>0</td><td>0</td></tr>
    </tbody>
  </table>
</div>

<p>Celkový bezpečnostný profil teda <strong>nemožno označiť za totožný s placebom</strong>. Hoci celkový počet nežiaducich a závažných nežiaducich udalostí bol podobný, viac než trojnásobný výskyt závažných infekcií pri inhibícii komplementu si zaslúži osobitnú pozornosť — je to práve tá kategória rizika, ktorú tento mechanizmus účinku predpovedá.</p>

<p>Pred liečbou sa vyžaduje očkovanie proti <em>Neisseria meningitidis</em> a <em>Streptococcus pneumoniae</em>; očkovanie proti <em>Haemophilus influenzae</em> typu b sa odporúča podľa miestnych pravidiel. Ani správne očkovanie riziko infekcie neodstraňuje úplne. Pacienti musia byť poučení o príznakoch závažnej infekcie a o potrebe bezodkladného vyšetrenia.</p>

<h2>Silné stránky štúdie</h2>

<ul>
  <li>randomizované a dvojito zaslepené usporiadanie s placebovou kontrolou,</li>
  <li>medzinárodná populácia s centrálne definovanými vstupnými kritériami,</li>
  <li>24-mesačné hodnotenie sklonu eGFR, nie iba proteinúrie,</li>
  <li>konzistentný účinok na proteinúriu, sklon eGFR aj kombinovaný výsledok,</li>
  <li>použitie iptakopanu ako <strong>prídavnej</strong> liečby k podpornej terapii.</li>
</ul>

<p>Najvýznamnejším prínosom je preukázanie účinku na sklon eGFR a na klinicky relevantný kombinovaný výsledok, nie iba na proteinúriu ako náhradný ukazovateľ. Práve to odlišuje APPLAUSE-IgAN od väčšiny predchádzajúcich štúdií v tejto indikácii.</p>

<h2>Obmedzenia a otvorené otázky</h2>

<h3>Vybraná študijná populácia</h3>

<p>Pacienti museli mať proteinúriu najmenej 1 g/g a eGFR najmenej 30 ml/min/1,73 m². Výsledky preto nemožno bez ďalších údajov preniesť na pacientov s nižšou proteinúriou, pokročilejším ochorením obličiek alebo veľmi pomaly progredujúcou IgA nefropatiou.</p>

<h3>Krátke obdobie vzhľadom na celoživotné ochorenie</h3>

<p>Dvadsaťštyri mesiacov postačuje na hodnotenie sklonu eGFR, ale nie na úplné posúdenie celoživotného prínosu a dlhodobej bezpečnosti komplementovej blokády.</p>

<h3>Nízke využitie inhibítorov SGLT2</h3>

<p>Inhibítor SGLT2 užívala pri vstupe iba približne pätina pacientov. Nie je preto jasné, aký bude <strong>absolútny</strong> prínos iptakopanu pri dôslednej súčasnej liečbe zahŕňajúcej blokádu systému renín-angiotenzín aj inhibítor SGLT2. Ide o systematický problém všetkých súčasných štúdií pri IgA nefropatii: štandard podpornej liečby sa mení rýchlejšie, než sa stihnú dokončiť.</p>

<h3>Bez priameho porovnania s inou cielenou liečbou</h3>

<p>Štúdia neporovnávala iptakopan so sparsentanom, cielene uvoľňovaným budezonidom ani s inými imunologicky či komplementovo orientovanými liekmi. Neumožňuje preto určiť optimálnu sekvenciu alebo kombináciu terapií.</p>

<h3>Infekčné riziko a financovanie</h3>

<p>Vyšší výskyt závažných infekcií je klinicky relevantný; na presnejšie vymedzenie rizika zriedkavých, ale potenciálne závažných infekcií budú potrebné dlhodobejšie údaje a farmakovigilančné sledovanie. Štúdiu financovala spoločnosť Novartis, výrobca iptakopanu, a niekoľkí spoluautori sú jej zamestnancami.</p>

<h2>Zaradenie do liečby IgA nefropatie</h2>

<p>Výsledky podporujú model súbežnej liečby dvoch hlavných zložiek progresie IgA nefropatie — nešpecifických mechanizmov chronického poškodenia nefrónov a imunologických mechanizmov primárneho ochorenia.</p>

<p>Základom liečby zostáva optimalizácia krvného tlaku, blokáda systému renín-angiotenzín, primeraná liečba inhibítorom SGLT2, kontrola kardiovaskulárneho rizika a ďalšie nefroprotektívne opatrenia. <strong>Iptakopan túto liečbu nenahrádza</strong> — predstavuje prídavnú cielenú terapiu alternatívnej cesty komplementu.</p>

<p>O vhodnosti liečby treba rozhodovať individuálne podľa rizika progresie, výšky a trvania proteinúrie, aktuálnej eGFR a jej vývoja, histologického nálezu, predchádzajúcej a súčasnej liečby, infekčného rizika, stavu očkovania a dostupnosti a nákladov liečby.</p>

<p>Štúdia nepreukázala, že komplementová aktivita bola u jednotlivých pacientov meraná a použitá na výber liečby. <strong>Zatiaľ preto nemáme validovaný biomarker</strong>, ktorý by spoľahlivo identifikoval pacientov s najväčšou pravdepodobnosťou odpovede — a pri liečbe s trojnásobným rizikom závažnej infekcie by taký biomarker bol mimoriadne užitočný.</p>

<h2>Záver</h2>

<p>Iptakopan pridaný k podpornej liečbe významne spomalil ročný pokles eGFR (−3,10 oproti −6,12 ml/min/1,73 m² za rok), znížil proteinúriu a znížil riziko kombinovaného ukazovateľa progresie ochorenia obličiek (21,4 % oproti 33,5 %; HR 0,57) u dospelých pacientov s IgA nefropatiou a pretrvávajúcou proteinúriou.</p>

<p>Výsledky predstavujú presvedčivý dôkaz účinnosti inhibície faktora B pri vybranej populácii pacientov s vysokým rizikom progresie. Interpretácia bezpečnosti však musí zohľadniť vyšší výskyt závažných infekcií. Otvorenými otázkami zostávajú dlhodobá bezpečnosť, optimálna dĺžka liečby, miesto iptakopanu medzi ďalšími cielenými terapiami a jeho prínos pri plne optimalizovanej modernej podpornej liečbe.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kompletna-remisia-proteinurie-igan-protect-post-hoc">Kompletná remisia proteinúrie pri IgA nefropatii (PROTECT)</a> — sparsentan a hodnota proteinúrie ako cieľa.</li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus liečby IgA nefropatie podľa KDIGO 2025</a>.</li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept pri IgA nefropatii</a>.</li>
  <li><a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3 glomerulopatia a inhibícia komplementu</a> — príbuzný mechanizmus v inej diagnóze.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Jonathan Barratt, Necmi Eren, Naoki Kashihara, Bart Maes, Dana V. Rizk, Brad Rovin, Hernán Trimarchi, Hong Zhang, Weiming Wang, Ismail Kocyigit, Chuanming Hao, Vladimir Tesař, Kenan Turgutalp, Li Yang, Guangqun Xing, Valter Duro Garcia, Seung Hyeok Han, Wanhong Lu, Antonio Pisani, Julia Weinmann-Menke, Frank Eitner, Nicolas Guerard, Dmytro Butylin, Luca Monaco, Emil Scosyrev, Annabel Magirr, Ronny Renfurm, Thomas Hach, Vlado Perkovic (APPLAUSE-IgAN Study Group).</strong> <em>Iptacopan in IgA Nephropathy — Final 24-Month Data.</em> New England Journal of Medicine. 2026;395(5):465–477. <a href="https://doi.org/10.1056/NEJMoa2600743" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41910396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>ClinicalTrials.gov, U.S. National Library of Medicine.</strong> <em>Study of Efficacy and Safety of Iptacopan in Participants With IgA Nephropathy (APPLAUSE-IgAN), NCT04578834.</em> Zadávateľ Novartis Pharmaceuticals. <a href="https://clinicaltrials.gov/study/NCT04578834" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes, KDIGO IgA Nephropathy Guideline Work Group.</strong> <em>Clinical Practice Guideline for the Management of Immunoglobulin A Nephropathy and Immunoglobulin A Vasculitis.</em> <a href="https://kdigo.org/guidelines/iga-nephropathy/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje — 477 pacientov v konečnej analýze (238 iptakopan, 239 placebo), vstupné kritériá eGFR ≥ 30 ml/min/1,73 m² a UPCR ≥ 1 g/g, dávka 200 mg dvakrát denne, anualizovaný sklon eGFR −3,10 oproti −6,12 s rozdielom 3,02 (95 % IS 2,02 – 4,01) pri upravenom p &lt; 0,001, kombinovaný ukazovateľ 21,4 % oproti 33,5 % s HR 0,57 (0,40 – 0,81) a upraveným p = 0,003, jeho úplná definícia vrátane 30-percentného poklesu eGFR, nežiaduce udalosti 87,0 % oproti 89,1 %, závažné nežiaduce udalosti 12,2 % oproti 11,7 %, závažné infekcie 6,7 % oproti 2,1 %, žiadne úmrtia, deväťmesačný pokles UPCR o 38,3 % oproti placebu, financovanie spoločnosťou Novartis a registračné číslo NCT04578834 — boli overené proti abstraktu v zázname PubMed. <strong>Úplný autorský kolektív (29 mien) bol doplnený z metaúdajov PubMed</strong>; podklad ho neuvádzal a upozorňoval, že mená netreba dopĺňať odhadom. Plný text v <em>New England Journal of Medicine</em> je za platobnou bariérou vydavateľa a nebol sprístupnený; údaje o počte randomizovaných pacientov (478), podiele užívateľov inhibítorov SGLT2 pri vstupe (približne pätina), stratifikácii randomizácie a požiadavkách na očkovanie pochádzajú z podkladového spracovania a <strong>neboli nezávisle overené</strong> proti plnému textu. Výpočet NNT, komentár k rýchlosti poklesu v placebovom ramene a upozornenie, že bezpečnosť nie je totožná s placebom, sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_iptakopan-iga-nefropatia-applause-igan-24-mesiacov_article',
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
