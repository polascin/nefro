<?php
/**
 * add_intermitentna-hemodialyza-vs-crrt-aki-kriticky-chori-icraki_article.php
 * Odborný článok: Intermitentná hemodialýza verzus kontinuálna renálna substitučná liečba pri akútnom poškodení obličiek u kriticky chorých dospelých: štúdia ICRAKI
 */

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
    'title'        => 'Intermitentná hemodialýza verzus kontinuálna renálna substitučná liečba pri akútnom poškodení obličiek u kriticky chorých dospelých: štúdia ICRAKI',
    'slug'         => 'intermitentna-hemodialyza-vs-crrt-aki-kriticky-chori-icraki',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Multicentrická randomizovaná štúdia ICRAKI publikovaná v New England Journal of Medicine (október 2026; N = 535 v ITT analýze) porovnala úvodnú intermitentnú hemodialýzu (IHD) s kontinuálnou renálnou substitučnou liečbou (CRRT) u kriticky chorých dospelých s akútnym poškodením obličiek (AKI). Štúdia bola predčasne ukončená: IHD nepreukázala noninferioritu v primárnom cieli MAKE v 90. dni (78,1 % vs. 71,6 %) a bola spojená s významne vyššou 90-dňovou mortalitou (63,1 % vs. 53,5 %; HR 1,30).',
    'content'      => <<<'HTML'
<h2>Úvod: Voľba úvodnej modality renálnej substitučnej liečby na jednotke intenzívnej starostlivosti</h2>
<p>Akútne poškodenie obličiek (<em>acute kidney injury</em>, <strong>AKI</strong>) vyžadujúce renálnu substitučnú liečbu (<em>renal-replacement therapy</em>, <strong>RRT</strong>) postihuje významnú časť kriticky chorých pacientov na jednotkách intenzívnej starostlivosti (JIS) a je spojené s krátkodobou mortalitou presahujúcou 50 %.<sup>1–3</sup> Kým otázku optimálneho načasovania začatia RRT u kriticky chorých bez život ohrozujúcich urgentných komplikácií do veľkej miery zodpovedali veľké randomizované štúdie ako <strong>AKIKI</strong> a <strong>STARRT-AKI</strong> (preukázaním bezpečnosti vyčkávacej stratégie oproti akcelerovanému začatiu), voľba samotnej <strong>úvodnej modality RRT</strong> zostávala predmetom odbornej diskusie.<sup>1–3</sup></p>

<p>V klinickej praxi sa ako úvodná modalita využíva buď <strong>intermitentná hemodialýza (IHD)</strong>, alebo <strong>kontinuálna renálna substitučná liečba (CRRT)</strong>. Teoretickou výhodou CRRT je pomalý, plynulý odber tekutín a solútov s menšími osmotickými a intravaskulárnymi výkyvmi, čo sa tradične uprednostňuje u hemodynamicky nestabilných pacientov. Naopak, IHD ponúka rýchlu korekciu život ohrozujúcej hyperkaliémie či metabolickej acidózy, nižšiu potrebu kontinuálnej antikoagulácie, nižšie priame náklady a lepšiu mobilizáciu pacienta. Staršie randomizované štúdie, vrátane francúzskej štúdie <strong>HEMODIAFE</strong> (Vinsonneau a spolupracovníci, 2006; <em>N</em> = 360) a nemeckej štúdie <strong>CONVINT</strong> (Schefold a spolupracovníci, 2014; <em>N</em> = 252), nepreukázali štatisticky významný rozdiel v prežívaní medzi IHD a CRRT, no mali limitovanú štatistickú silu na vylúčenie klinicky dôležitého rozdielu v mortalite a pretrvávajúcej renálnej dysfunkcii.<sup>4,5</sup></p>

<figure class="article-figure">
  <img src="img/intermitentna-hemodialyza-vs-crrt-aki-kriticky-chori-icraki.png" alt="Umelecká 3D vizualizácia mimotelovej eliminácie krvi cez kapilárny dialyzátor pri akútnom poškodení obličiek s kontrastom pulzného a kontinuálneho prietoku" width="1600" height="1000" loading="lazy">
  <figcaption><strong>Obrázok 1.</strong> Koncepčná vizualizácia mimotelovej eliminačnej liečby pri akútnom poškodení obličiek (AKI): kontrast medzi nárazovými hemodynamickými a osmotickými zmenami pri intermitentnej hemodialýze (IHD) a plynulou kontinuálnou renálnou substitučnou liečbou (CRRT).</figcaption>
</figure>

<h2>Cieľ, hypotéza a dizajn štúdie ICRAKI</h2>
<p>Dňa 14. októbra 2026 publikovali Gaudry a spolupracovníci (za skupinu <em>ICRAKI Trial Group</em>) v časopise <em>New England Journal of Medicine</em> výsledky multicentrickej randomizovanej štúdie <strong>ICRAKI</strong> (NCT06032884), ktorej cieľom bolo definitívne overiť, či je intermitentná hemodialýza ako počiatočná modalita RRT u kriticky chorých dospelých s ťažkým AKI <strong>nehoršia (noninferiórna)</strong> oproti kontinuálnej renálnej substitučnej liečbe.<sup>1</sup></p>

<h3>Metodika a sledované ukazovatele</h3>
<ul>
  <li><strong>Dizajn štúdie:</strong> Multicentrická, pragmatická, otvorená (<em>open-label</em>), randomizovaná štúdia noninferiority realizovaná na jednotkách intenzívnej starostlivosti vo Francúzsku.<sup>1</sup></li>
  <li><strong>Zaradená populácia a randomizácia:</strong> Do štúdie boli zaradení kriticky chorí dospelí pacienti s ťažkým AKI, u ktorých vznikla klinická indikácia na začatie RRT. Celkovo bolo randomizovaných <strong>554 pacientov</strong> (272 do ramena s úvodnou IHD a 282 do ramena s úvodnou CRRT). Do modifikovanej <em>intention-to-treat</em> (ITT) analýzy bolo zaradených <strong>535 pacientov</strong>: <strong>260 v skupine IHD</strong> a <strong>275 v skupine CRRT</strong>.<sup>1</sup></li>
  <li><strong>Primárny zložený ukazovateľ (MAKE v 90. dni):</strong> Primárnym cieľom bol výskyt závažnej nežiaducej obličkovej príhody (<em>major adverse kidney event</em>, <strong>MAKE</strong>) do 90. dňa od randomizácie, definovaný ako zloženie troch komponentov:
    <ol>
      <li>úmrtie z akejkoľvek príčiny,</li>
      <li>pretrvávajúca závislosť od renálnej substitučnej liečby, alebo</li>
      <li>sérová koncentrácia kreatinínu prevyšujúca východiskovú hodnotu o viac než <strong>25 %</strong>.<sup>1</sup></li>
    </ol>
  </li>
  <li><strong>Predčasné ukončenie štúdie:</strong> Štúdia bola predčasne zastavená na základe odporúčania nezávislej komisie pre monitorovanie údajov a bezpečnosti po sekvenčných priebežných (interim) analýzach, ktoré preukázali pretrvávajúci signál vyššej mortality v ramene s intermitentnou hemodialýzou v porovnaní s CRRT.<sup>1</sup></li>
</ul>

<h2>Výsledky štúdie ICRAKI</h2>

<h3>1. Primárny ukazovateľ (MAKE do 90. dňa): nepotvrdená noninferiorita IHD</h3>
<p>Do 90. dňa od randomizácie sa primárny zložený ukazovateľ MAKE vyskytol u:<sup>1</sup></p>
<ul>
  <li><strong>203 z 260 pacientov (78,1 %)</strong> v skupine s úvodnou intermitentnou hemodialýzou (IHD),</li>
  <li><strong>197 z 275 pacientov (71,6 %)</strong> v skupine s úvodnou kontinuálnou renálnou substitučnou liečbou (CRRT).</li>
</ul>
<p>Upravený absolútny rozdiel rizika predstavoval <strong>6,28 percentuálneho bodu</strong> v neprospech IHD (95 % interval spoľahlivosti [CI] −1,22 až 13,79). Keďže horná hranica 95 % CI (13,79 percentuálneho bodu) prekročila vopred stanovenú hranicu noninferiority, <strong>štúdia ICRAKI nepreukázala noninferioritu intermitentnej hemodialýzy</strong> voči CRRT.<sup>1</sup></p>

<h3>2. Mortalita do 90. dňa: štatisticky významne vyššie riziko úmrtia pri IHD</h3>
<p>Rozhodujúci klinický rozdiel medzi oboma stratégiami sa prejavil v samotnom prežívaní pacientov:<sup>1</sup></p>
<ul>
  <li>Do 90. dňa zomrelo <strong>164 z 260 pacientov (63,1 %)</strong> v skupine IHD oproti <strong>147 z 275 pacientov (53,5 %)</strong> v skupine CRRT (absolútny rozdiel hrubého výskytu úmrtí 9,6 percentuálneho bodu).</li>
  <li>Kaplanove-Meierove odhady 90-dňovej mortality dosiahli <strong>63,3 % v skupine IHD verzus 53,6 % v skupine CRRT</strong>.</li>
  <li>Pomer rizík (<em>hazard ratio</em>, HR) pre úmrtie do 90. dňa predstavoval <strong>1,30</strong> (95 % CI 1,04 až 1,63), čo dokumentuje o 30 % vyššie okamžité riziko úmrtia pri voľbe IHD ako úvodnej modality RRT.<sup>1</sup></li>
</ul>

<h3>3. Hemodynamická tolerancia a nežiaduce udalosti</h3>
<p>Najčastejšou zaznamenanou komplikáciou potenciálne súvisiacou s AKI alebo so samotnou procedúrou RRT bola <strong>hypotenzia</strong>, ktorá sa vyskytla u <strong>179 pacientov (68,8 %)</strong> v skupine IHD a u <strong>183 pacientov (66,5 %)</strong> v skupine CRRT.<sup>1</sup></p>

<div class="table-responsive">
  <table class="article-table">
    <thead>
      <tr>
        <th>Klinický ukazovateľ / štúdia</th>
        <th>Skupina IHD</th>
        <th>Skupina CRRT</th>
        <th>Efekt / medziskupinové porovnanie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>ICRAKI (2026)</strong>: Randomizovaní / ITT populácia<sup>1</sup></td>
        <td>272 / 260 pacientov</td>
        <td>282 / 275 pacientov</td>
        <td>Predčasne ukončené po interim analýzach pre vyššiu mortalitu v ramene IHD</td>
      </tr>
      <tr>
        <td><strong>ICRAKI</strong>: Primárny cieľ MAKE v 90. dni<sup>1</sup></td>
        <td><strong>203 / 260 (78,1 %)</strong></td>
        <td><strong>197 / 275 (71,6 %)</strong></td>
        <td>Upravený rozdiel rizika <strong>+6,28 p. b.</strong> (95 % CI −1,22 až 13,79); noninferiorita IHD <strong>nepreukázaná</strong></td>
      </tr>
      <tr>
        <td><strong>ICRAKI</strong>: Úmrtie do 90. dňa (Kaplanov-Meierov odhad)<sup>1</sup></td>
        <td><strong>164 / 260 (63,1 %; KM 63,3 %)</strong></td>
        <td><strong>147 / 275 (53,5 %; KM 53,6 %)</strong></td>
        <td><strong>HR 1,30</strong> (95 % CI 1,04 až 1,63); vyššia 90-dňová mortalita pri IHD</td>
      </tr>
      <tr>
        <td><strong>ICRAKI</strong>: Hypotenzia počas sledovania<sup>1</sup></td>
        <td>179 / 260 (68,8 %)</td>
        <td>183 / 275 (66,5 %)</td>
        <td>Najčastejšia komplikácia potenciálne súvisiaca s AKI/RRT v oboch skupinách</td>
      </tr>
      <tr>
        <td><strong>HEMODIAFE (2006)</strong>: 60-dňové prežívanie (<em>N</em> = 360)<sup>4</sup></td>
        <td>32 % (57 / 184)</td>
        <td>33 % (58 / 175)</td>
        <td>Bez významného rozdielu v 60-dňovom prežívaní v staršej ére protokolov RRT (<em>p</em> = 0,98)</td>
      </tr>
      <tr>
        <td><strong>CONVINT (2014)</strong>: Prežívanie do 14 dní po ukončení RRT (<em>N</em> = 252)<sup>5</sup></td>
        <td>39,5 %</td>
        <td>43,9 %</td>
        <td>Numericky nižšie prežívanie pri IHD, no štúdia nemala dostatočnú štatistickú silu (OR 0,84; <em>p</em> = 0,50)</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Klinická interpretácia a porovnanie s doterajšou evidenciou</h2>

<h3>Prečo štúdia ICRAKI mení pohľad vytvorený štúdiami HEMODIAFE a CONVINT</h3>
<p>Po publikovaní štúdií HEMODIAFE (2006) a CONVINT (2014) prevládal najmä vo francúzskej a časti európskej intenzivistickej školy názor, že pri dodržaní prísnych opatrení na zlepšenie hemodynamickej tolerancie (izotonické plnenie okruhu, chladený dialyzát s vyššou koncentráciou sodíka, včasné nasadenie vazopresorov) sú IHD a CRRT u kriticky chorých s AKI rovnocenné.<sup>4,5</sup> Odvtedy sa však zmenila štruktúra pacientov indikovaných na RRT: po zavedení odloženej (konzervatívnejšej) stratégie začínania RRT podľa štúdií <strong>AKIKI</strong> a <strong>STARRT-AKI</strong> dnes dostávajú RRT len pacienti s najťažším, perzistujúcim AKI a závažným multiorgánovým zlyhávaním, kým pacienti s včasným spontánnym zotavením obličiek sa dialýze úplne vyhnú.<sup>1–3</sup></p>

<p>V tejto súčasnej, vysoko zraniteľnej populácii kriticky chorých (kde 90-dňová mortalita presahuje 50 %) ukazuje štúdia ICRAKI na vzorke 535 hodnotených pacientov, že začať liečbu intermitentnou hemodialýzou nie je ekvivalentné začatiu CRRT a spája sa s takmer o 10 percentuálnych bodov vyššou 90-dňovou úmrtnosťou (63,1 % vs. 53,5 %; HR 1,30).<sup>1</sup></p>

<h3>Mechanistické úvahy a opatrnosť pri interpretácii hypotenzie</h3>
<p>Hoci sa vyšší prínos CRRT tradične pripisuje menšej incidencii hypotenzie, samotný hrubý podiel pacientov s aspoň jednou epizódou hypotenzie bol v štúdii ICRAKI medzi skupinami blízky (68,8 % pri IHD vs. 66,5 % pri CRRT).<sup>1</sup> Pri interpretácii tohto zistenia treba vziať do úvahy, že binárne zaznamenanie výskytu hypotenzie počas oveľa dlhšieho kumulatívneho trvania CRRT oproti krátkym 4- až 6-hodinovým sedeniam IHD neodráža rýchlosť osmotického posunu (syndróm nerovnováhy s mikroedémom mozgu a subklinickou myokardiálnou ischémiou), rýchlosť ultrafiltrácie za hodinu ani kumulatívnu dávku vazopresorov počas procedúry. Bez podrobnej analýzy hemodynamických kriviek a príčin úmrtí z plného protokolu a doplnkovej prílohy preto nemožno mechanizmus vyššej mortality zúžiť len na samotný výskyt hypotenzie.<sup>1</sup></p>

<h2>Limity štúdie</h2>
<ul>
  <li><strong>Otvorený (<em>open-label</em>) dizajn:</strong> Vzhľadom na technickú povahu IHD a CRRT nebolo možné zaslepenie ošetrujúceho personálu, čo mohlo ovplyvniť sprievodné klinické rozhodnutia (napr. manažment tekutín, sedácie, mobilizácie alebo prechod medzi modalitami).<sup>1</sup></li>
  <li><strong>Predčasné ukončenie po interim analýzach:</strong> Hoci zastavenie štúdie pre pretrvávajúci signál vyššej mortality v ramene IHD bolo z etického hľadiska nevyhnutné, predčasné ukončenie znižuje presnosť odhadov v podskupinách a sekundárnych renálnych ukazovateľoch.<sup>1</sup></li>
  <li><strong>Špecifiká národnej praxe:</strong> Štúdia prebiehala na francúzskych pracoviskách intenzívnej medicíny s dlhoročnou skúsenosťou s oboma modalitami; detailné hodnotenie predpísaných a dodaných dávok dialýzy/hemofiltrácie, režimov antikoagulácie (citrát vs. heparín) a miery prechodu z jednej modality na druhú si vyžaduje analýzu kompletnej prílohy štúdie.<sup>1</sup></li>
</ul>

<h2>Záver pre klinickú prax</h2>
<p>Multicentrická randomizovaná štúdia <strong>ICRAKI</strong> prináša kľúčový dôkaz pre intenzivistickú nefrológiu: u kriticky chorých dospelých s akútnym poškodením obličiek vyžadujúcich začatie RRT <strong>nebola preukázaná noninferiorita intermitentnej hemodialýzy</strong> voči kontinuálnej renálnej substitučnej liečbe v primárnom zloženom ukazovateli MAKE v 90. dni (78,1 % vs. 71,6 %) a úvodná liečba pomocou IHD bola spojená s <strong>významne vyššou 90-dňovou mortalitou</strong> (63,1 % vs. 53,5 %; HR 1,30; 95 % CI 1,04 až 1,63).<sup>1</sup> Na jednotkách intenzívnej starostlivosti, kde sú dostupné technické a personálne kapacity pre kontinuálne metódy, by preto mala byť <strong>CRRT preferovanou úvodnou modalitou RRT</strong> u kriticky chorých pacientov s AKI, s výnimkou špecifických perakútnych stavov vyžadujúcich okamžitý vysokoprietokový klírens difúziou (napr. refraktérna malígna hyperkaliémia alebo vybrané dialyzovateľné intoxikácie).<sup>1</sup></p>

<h2>Literatúra</h2>
<ol class="references-list">
  <li>Gaudry S, Boubaya M, Louis G, Chaïbi K, de Montmollin E, Bohé J, Desgrouas M, Devautour C, Joseph A, Mégarbane B, Camus C, Bailly P, Lambour A, Arrestier R, Jaber S, Robine A, Chudeau N, Chevrel G, La Combe B, Nicolas J, Argaud L, Bureau C, Kimmoun A, Zucman N, Ricard JD, Thiery G, Faguer S, Jozwiak M, Ferrand N, Chousterman B, Marzouk M, Cadiet J, Combes A, Mari A, Contou D, Amathieu R, Da Silva D, Salmon Gandonnière C, Rodie-Talbere PA, Durand-Zaleski I, Rossignol P, Quenot JP, Biard L, Bloch C, Dreyfuss D; ICRAKI Trial Group. Intermittent or Continuous Renal-Replacement Therapy in Acute Kidney Injury. <em>New England Journal of Medicine</em>. Publikované online 14. októbra 2026. DOI: <a href="https://doi.org/10.1056/NEJMoa2608397" target="_blank" rel="noopener">10.1056/NEJMoa2608397</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42873070/" target="_blank" rel="noopener">42873070</a>.</li>
  <li>Gaudry S, Hajage D, Schortgen F, Martin-Lefevre L, Pons B, Boulet E, Boyer A, Chevrel G, Lerolle N, Carpentier D, de Prost N, Lautrette A, Bretagnol A, Mayaux J, Nitenberg G, Thille AW, Tadié JM, Quiquempoix A,Constan A, Ricard JD, Dreyfuss D; AKIKI Study Group. Initiation Strategies for Renal-Replacement Therapy in the Intensive Care Unit. <em>New England Journal of Medicine</em>. 2016;375(2):122–133. DOI: <a href="https://doi.org/10.1056/NEJMoa1603017" target="_blank" rel="noopener">10.1056/NEJMoa1603017</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/27181456/" target="_blank" rel="noopener">27181456</a>.</li>
  <li>STARRT-AKI Investigators; Canadian Critical Care Trials Group; Australian and New Zealand Intensive Care Society Clinical Trials Group; United Kingdom Critical Care Research Group; Canadian Nephrology Trials Network; Irish Critical Care Trials Group; Bagshaw SM, Wald R, Adhikari NKJ, Bellomo R, da Costa BR, Dreyfuss D, Du B, Gallagher MP, Gaudry S, Hoste EA, Lamontagne F, Joannidis M, Landoni G, Liu KD, McAuley DF, McGuinness SP, Neyra JA, Nicholl DDM, Ostermann M, Palevsky PM, Pettilä V, Quenot JP, Qiu H, Rochwerg B, Schneider AG, Smith OM, Thomé F, Thorpe KE, Vaara S, Weir M, Wang AY, Young P, Zarbock A. Timing of Initiation of Renal-Replacement Therapy in Acute Kidney Injury. <em>New England Journal of Medicine</em>. 2020;383(3):240–251. DOI: <a href="https://doi.org/10.1056/NEJMoa2000741" target="_blank" rel="noopener">10.1056/NEJMoa2000741</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/32668114/" target="_blank" rel="noopener">32668114</a>.</li>
  <li>Vinsonneau C, Camus C, Combes A, Costa de Beauregard MA, Klouche K, Boulain T, Pallazzo B, Chiche JD, Taupin P, Landais P, Dhainaut JF; Hemodiafe Study Group. Continuous venovenous haemodiafiltration versus intermittent haemodialysis for acute renal failure in patients with multiple-organ dysfunction syndrome: a multicentre randomised trial. <em>The Lancet</em>. 2006;368(9533):379–385. DOI: <a href="https://doi.org/10.1016/S0140-6736(06)69111-3" target="_blank" rel="noopener">10.1016/S0140-6736(06)69111-3</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/16876666/" target="_blank" rel="noopener">16876666</a>.</li>
  <li>Schefold JC, von Haehling S, Pschowski R, Bender TO, Berkmann C, Briegel S, Hasper D, Jörres A. The effect of continuous versus intermittent renal replacement therapy on the outcome of critically ill patients with acute renal failure (CONVINT): a prospective randomized controlled trial. <em>Critical Care</em>. 2014;18(1):R11. DOI: <a href="https://doi.org/10.1186/cc13188" target="_blank" rel="noopener">10.1186/cc13188</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/24405734/" target="_blank" rel="noopener">24405734</a>.</li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_intermitentna-hemodialyza-vs-crrt-aki-kriticky-chori-icraki_article',
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
