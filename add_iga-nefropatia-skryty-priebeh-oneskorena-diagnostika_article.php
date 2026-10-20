<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Skrytý priebeh IgA nefropatie: prečo sa diagnóza oneskoruje a čo to stojí obličky',
    'slug' => 'iga-nefropatia-skryty-priebeh-oneskorena-diagnostika',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'IgA nefropatia prebieha roky bez príznakov. Register RaDaR ukázal medián prežívania obličky 11,4 roka a zlyhanie do 10 rokov aj u pacientov považovaných za málo rizikových.',
    'content' => <<<'HTML'
<p>IgA nefropatia je najčastejšie primárne glomerulové ochorenie. Jej skutočný klinický problém však nie je len to, čo sa deje v glomeruloch, ale rýchlosť, akou sa to deje — pomaly, ticho a spravidla bez toho, aby pacient čokoľvek cítil. Kým sa dostane k nefrológovi, často už nejde o začiatok choroby, ale o jej dôsledok.</p>

<p>Podkladom tohto textu je prednáška profesora Jonathana Barratta z Univerzity v Leicesteri o patogenéze a neuspokojených potrebách pri IgA nefropatii. Doplnili sme ju o údaje z britského registra RaDaR, o aktuálne odporúčanie KDIGO 2025 a o novšie práce k patogenéze a biomarkerom, aby bolo zrejmé, aká je cena oneskorenej diagnózy v číslach.</p>

<figure>
  <picture>
    <source srcset="img/iga-nefropatia-skryty-priebeh-oneskorena-diagnostika.webp" type="image/webp">
    <img src="img/iga-nefropatia-skryty-priebeh-oneskorena-diagnostika.png" alt="Priesvitná sklenená oblička v tme s jantárovými ložiskami hlboko vnútri, ktoré vpravo hasnú a sklo sa mení na matný zjazvený povrch" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie histologický preparát ani snímka konkrétneho pacienta. Znázorňuje roky trvajúce tiché ukladanie imunokomplexov a prechod do nevratného jazvenia.</figcaption>
</figure>

<h2>Čo sa deje v glomerule</h2>

<p>IgA nefropatia je imunokomplexmi sprostredkované glomerulové ochorenie. Imunofluorescenčne sa depozity IgA zobrazia v mezangiu a v oblasti kapilárnych kľučiek, elektrónovou mikroskopiou ich možno potvrdiť ako elektrónovo denzné depozity. Ich prítomnosť spúšťa zápalovú a jazvovú prestavbu glomerulu, ktorá napokon vedie k strate funkcie obličiek.</p>

<p>Imunokomplexy vznikajú preto, že v obehu je nadbytok IgA slizničného pôvodu. Genetické asociačné štúdie v rôznych populáciách opakovane ukázali, že rizikové alely zasahujú predovšetkým dráhy slizničnej tvorby IgA, najmä v tráviacom trakte. Predpokladá sa teda nenápadná porucha regulácie slizničného imunitného systému.</p>

<p>Toto IgA má sklon zhlukovať sa a viazať ďalšie bielkoviny v obehu. Zároveň existujú protilátky proti glykánovým štruktúram, pravdepodobne vytvorené pôvodne proti mikrobiálnym patogénom, ktoré s ním krížovo reagujú a tvorbu imunokomplexov zosilňujú.</p>

<p>Dnešný výklad zhŕňa takzvaná hypotéza štyroch zásahov: tvorba galaktózovo deficitného IgA1 (Gd-IgA1), vznik protilátok proti nemu, tvorba cirkulujúcich imunokomplexov a napokon ich ukladanie v mezangiu so zápalovou odpoveďou. Práce na bunkách produkujúcich IgA1 z periférnej krvi a z tonzíl ukázali, že vyššia tvorba Gd-IgA1 súvisí s poruchou regulácie niekoľkých glykozylačných enzýmov a dá sa ešte zvýšiť pôsobením niektorých cytokínov. Súvislosť so slizničnou imunitou podporuje aj dlho známa synfaryngitická hematúria, teda viditeľná krv v moči súbežne s infekciou horných dýchacích ciest.</p>

<h2>Prečo je choroba roky nemá</h2>

<p>IgA nefropatia je chronické ochorenie. Imunokomplexy pravdepodobne kolujú veľmi dlho, kým spôsobia merateľnú stratu funkcie obličiek. Sled udalostí je pritom celkom pravidelný:</p>

<ol>
  <li>uloženie imunokomplexov v mezangiu,</li>
  <li>nízkostupňový glomerulový zápal,</li>
  <li>poškodenie glomerulovej bazálnej membrány,</li>
  <li>prienik erytrocytov do moču, teda mikroskopická hematúria,</li>
  <li>začínajúca nízkostupňová albuminúria,</li>
  <li>zjavná proteinúria.</li>
</ol>

<p>Celý tento sled je prakticky bezpríznakový. Pacient preto môže nahromadiť značné glomerulové poškodenie skôr, než sa vôbec dostane do pozornosti lekára.</p>

<p>Ako sa teda choroba najčastejšie odhalí? Spravidla neskoro, a to dôsledkami rozsiahlej straty nefrónov — artériovou hypertenziou alebo zvýšeným sérovým kreatinínom. Skôr sa zachytí vtedy, keď niekto z iného dôvodu vyšetrí moč a nájde krv a bielkovinu ešte pred výraznejšou stratou nefrónov. Epizódy viditeľnej hematúrie pri aktivácii slizničného imunitného systému sú v dospelej praxi zriedkavé; podstatne častejšie sa vyskytujú u detí a najmä u dospievajúcich.</p>

<h2>Koľko oneskorenie stojí: údaje z registra RaDaR</h2>

<p>Rozsah problému dobre vyjadruje analýza britského Národného registra zriedkavých ochorení obličiek (RaDaR). Zahrnula 2 299 dospelých a 140 detí s bioptickou diagnózou IgA nefropatie a s proteinúriou nad 0,5 g/deň alebo eGFR pod 60 ml/min/1,73 m².</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky kohorty RaDaR pri IgA nefropatii" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Hodnota</th></tr></thead>
  <tbody>
    <tr><th scope="row">Medián sledovania</th><td>5,9 roka (Q1–Q3: 3,0–10,5)</td></tr>
    <tr><th scope="row">Zlyhanie obličiek alebo úmrtie počas sledovania</th><td>50 % pacientov</td></tr>
    <tr><th scope="row">Medián prežívania obličky</th><td>11,4 roka (95 % IS 10,5–12,5)</td></tr>
    <tr><th scope="row">Priemerný vek pri zlyhaní obličiek alebo úmrtí</th><td>48 rokov</td></tr>
    <tr><th scope="row">Zlyhanie do 10 rokov pri časovo priemernej proteinúrii 0,44–&lt;0,88 g/g</th><td>30 %</td></tr>
    <tr><th scope="row">Zlyhanie do 10 rokov pri časovo priemernej proteinúrii &lt;0,44 g/g</th><td>približne 20 %</td></tr>
  </tbody>
</table>
</div>

<p>Dve zistenia sú pre prax rozhodujúce. Po prvé: podľa eGFR a veku pri diagnóze bola takmer u všetkých pacientov očakávaná progresia do zlyhania obličiek počas ich života, pokiaľ sa nepodarilo udržať ročný pokles eGFR na hodnote najviac 1 ml/min/1,73 m². Po druhé: <strong>pacienti, ktorých sme tradične považovali za málo rizikových</strong> — s proteinúriou pod 0,88 g/g, teda pod 100 mg/mmol — <strong>mali vysoký podiel zlyhania obličiek do desiatich rokov</strong>. Každý 10 % pokles časovo priemernej proteinúrie oproti východiskovej hodnote bol v populácii zodpovedajúcej klinickému skúšaniu spojený s pomerom rizika zlyhania obličiek alebo úmrtia 0,89 (95 % IS 0,87–0,92).</p>

<p>Pri výklade treba mať na pamäti vstupné kritérium registra: zaradení boli len pacienti s proteinúriou nad 0,5 g/deň alebo so zníženou eGFR. Ide teda o kohortu s už vyjadreným ochorením, nie o celé spektrum IgA nefropatie, a absolútne čísla nemožno preniesť na náhodne zachytenú izolovanú mikroskopickú hematúriu. Smer zistenia je však jednoznačný a je priamym protiargumentom voči predstave, že nízka proteinúria znamená bezpečnú chorobu.</p>

<h2>Čo prináša KDIGO 2025</h2>

<p>Odporúčanie KDIGO pre IgA nefropatiu a IgA vaskulitídu bolo naposledy aktualizované v rámci odporúčania pre glomerulové ochorenia z roku 2021. Vzhľadom na vývoj v hodnotení aj liečbe bola v roku 2024 potrebná zásadná aktualizácia; výsledkom je odporúčanie KDIGO 2025, ktoré zahŕňa dôkazy z randomizovaných štúdií do augusta 2024.</p>

<p>Pre tému oneskorenej diagnostiky sú podstatné tri zmeny:</p>

<ul>
  <li><strong>Voľnejší prístup k bioptickému vyšetreniu obličky.</strong> Odporúčanie podporuje skoršiu indikáciu biopsie, čo priamo adresuje oneskorené rozpoznanie.</li>
  <li><strong>Prísnejší cieľ proteinúrie.</strong> Odporúča sa smerovať pod 0,5 g/deň, ideálne pod 0,3 g/deň, pri súčasne stabilnej eGFR. Údaje z RaDaR tento posun priamo podopierajú.</li>
  <li><strong>Dvojzložková liečebná stratégia.</strong> Nový koncept spája liečbu, ktorá bráni tvorbe patogénneho IgA a vzniku imunokomplexov IgA/IgA a IgA/IgG, s liečbou dôsledkov už vzniknutej straty nefrónov.</li>
</ul>

<p>Prvý cieľ je zatiaľ dosiahnuteľný obmedzene — cielene uvoľňovaným budezonidom alebo systémovou kortikoterapiou v zníženej dávke, u čínskych pacientov mykofenolát mofetilom. Druhý, všeobecnejší cieľ zahŕňa edukáciu o zdravom životnom štýle, blokádu systému renín–angiotenzín, inhibítory SGLT2 a duálne blokátory endotelínových a angiotenzínových receptorov.</p>

<p>Pri osobitných situáciách — nefrotický syndróm, akútne poškodenie obličiek, rýchlo progredujúca glomerulonefritída, gravidita pri IgA nefropatii, deti s IgA nefropatiou alebo IgA vaskulitídou — sa zmenilo málo, pretože pre tieto skupiny chýbajú väčšie klinické skúšania. KDIGO 2025 je teda rámec s rôznou hustotou dôkazov, nie jednotný liečebný predpis.</p>

<h2>Kde dnes naráža skorá diagnostika</h2>

<p>Patogenéze rozumieme podstatne lepšie než pred desiatimi rokmi, oneskorenie diagnózy to však samo osebe nerieši. Nefrologická komunita sa preto usiluje o skoršie rozpoznanie nielen IgA nefropatie, ale aj ďalších zriedkavých ochorení obličiek, ktoré sa prejavia neskoro. Prakticky to znamená cielene si všímať:</p>

<ul>
  <li>mierne odchýlky sérového kreatinínu, ktoré sa opakovane potvrdzujú,</li>
  <li>skorý rozvoj artériovej hypertenzie, najmä u mladšieho človeka,</li>
  <li>drobné, ale pretrvávajúce zmeny močového nálezu — krv a bielkovinu.</li>
</ul>

<p>Nejde o plošný skríning populácie. Ide o to, aby sa nález, ktorý už máme v ruke, nezľahčil. Najväčšou prekážkou býva práve klinická zotrvačnosť: opakovaný patologický močový nález sa odloží na „kontrolu“ bez jasného plánu a bez určenia, kto a kedy ho vyhodnotí.</p>

<h2>Prečo na čase skutočne záleží</h2>

<p>Nové liečebné možnosti zasahujú rôzne miesta patogénnej kaskády a súčasne tlmia všeobecné dôsledky straty nefrónov, spoločné pre každú chronickú chorobu obličiek. Ich prínos je však zhora ohraničený rozsahom už vzniknutého poškodenia. <strong>Keď sa v glomeruloch vytvorí fixné jazvenie a zjazví sa tubulointerstícium, tento stav už zvrátiť nemožno</strong> — ostáva liečiť dôsledky trvalého poškodenia.</p>

<p>Práve preto je rozdiel medzi diagnózou pri mikroskopickej hematúrii a diagnózou pri už zníženej eGFR rozdielom medzi potenciálne ovplyvniteľným zápalom a nevratnou prestavbou tkaniva.</p>

<h2>Biomarkery: čo sa môže zmeniť</h2>

<p>Zlatým štandardom diagnostiky ostáva bioptické vyšetrenie obličky. Najlepšie overenými prognostickými ukazovateľmi sú naďalej histopatologický nález, proteinúria, glomerulová filtrácia a hypertenzia — na vedenie liečby však nie sú dosť jemné.</p>

<p>Hypotéza štyroch zásahov otvorila cestu ďalším kandidátom: Gd-IgA1 a zodpovedajúcej autoprotilátke, ukazovateľom aktivácie komplementu a novším postupom na úrovni mikroRNA, genomiky a mikrobiómu. Ani jeden z nich zatiaľ nenahrádza biopsiu ani zavedené prognostické ukazovatele; ide o perspektívu, nie o súčasnú prax.</p>

<h2>Terminologická poznámka</h2>

<p>V slovenských textoch sa dôsledne odlišuje <strong>IgA nefropatia (IgAN)</strong> ako primárne glomerulové ochorenie od <strong>IgA vaskulitídy (IgAV)</strong> ako systémového ochorenia s obličkovým postihnutím. Obe pokrýva to isté odporúčanie KDIGO, ich klinický obraz, priebeh aj rozhodovanie o liečbe sa však líšia, a zamieňanie pojmov vedie k nesprávnym záverom o prognóze.</p>

<h2>Praktické závery pre spoluprácu so všeobecnými lekármi</h2>

<ol>
  <li><strong>Opakovaný patologický močový nález potrebuje plán, nie odklad.</strong> Mikroskopická hematúria s proteinúriou u dospelého je dôvod na nefrologické uvažovanie, nie na ďalšiu nezáväznú kontrolu.</li>
  <li><strong>Mierne, ale opakované zmeny kreatinínu sledujte ako trend.</strong> Jedna hodnota v medziach normy nevylučuje prebiehajúci pokles.</li>
  <li><strong>Hypertenzia spolu s močovým nálezom nie je náhoda.</strong> Spoločný výskyt má viesť k vyšetreniu obličiek, nie k izolovanej liečbe tlaku.</li>
  <li><strong>Nízka proteinúria nie je dôkaz nízkeho rizika.</strong> Údaje z RaDaR to vyvracajú priamo.</li>
  <li><strong>Pacientovi vysvetlite, že „bez príznakov“ neznamená „bez rizika“.</strong> Je to podmienka toho, aby prišiel na ďalšie vyšetrenie aj vtedy, keď sa cíti dobre.</li>
</ol>

<h2>Limity tohto textu</h2>

<p>Východiskom je vzdelávacia prednáška jedného odborníka, teda expertný výklad, nie systematický prehľad. Číselné údaje o prognóze pochádzajú z observačného registra s uvedenými vstupnými kritériami a nie z randomizovaného skúšania; ukazujú teda prirodzený priebeh v už vybranej populácii, nie účinok zásahu. Odporúčanie KDIGO 2025 obsahuje odstupňované odporúčania aj konsenzuálne praktické body a nie všetky jeho časti majú rovnakú dôkazovú oporu — pri osobitných klinických situáciách je dôkazov naďalej málo.</p>

<h2>Záver</h2>

<p>IgA nefropatia je nebezpečná práve tým, že je ticho. Patogenéza beží roky, klinický prejav býva nenápadný a diagnóza prichádza často až vtedy, keď je prítomné významné štrukturálne poškodenie. Údaje z registra RaDaR ukazujú, akú cenu to má: medián prežívania obličky 11,4 roka, priemerný vek pri zlyhaní obličiek alebo úmrtí 48 rokov a vysoký podiel zlyhania do desiatich rokov aj u pacientov s nízkou proteinúriou.</p>

<p>KDIGO 2025 na to odpovedá voľnejšou indikáciou biopsie, prísnejším cieľom proteinúrie a dvojzložkovou liečebnou stratégiou. Rozhodujúce však ostáva to, čo sa deje pred nefrológom: aby sa opakovaný patologický močový nález, mierny vzostup kreatinínu a skorá hypertenzia nebrali ako bezvýznamná odchýlka.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatia podľa KDIGO 2025 a KDOQI US Commentary: od biopsie po cielenejšiu liečbu</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Praktická príloha: Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025 s ohľadom na KDOQI US Commentary</a></li>
  <li><a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement v nefrológii: diagnostika, infekčné riziko a cielená inhibícia pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=kompletna-remisia-proteinurie-igan-protect-post-hoc">Kompletná remisia proteinúrie pri IgA nefropatii súvisí s pomalším poklesom glomerulovej filtrácie</a></li>
  <li><a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">Sparsentan s inhibítorom SGLT2 pri IgA nefropatii: SPARTACUS a PROTECT OLE</a></li>
</ul>

<h2>Poznámka k dôkazom</h2>

<p>Východiskovým zdrojom je prepis vzdelávacej prednášky profesora Jonathana Barratta (ReachMD / Global Learning Collaborative, uvoľnené 31. augusta 2026), overený priamo z verejne dostupného prepisu aktivity. Keďže ide o expertný výklad bez vlastných číselných údajov, doplnili sme k nemu primárne pramene: analýzu registra RaDaR (všetky uvedené čísla overené proti abstraktu v PubMed), výkonné zhrnutie odporúčania KDIGO 2025 a dva prehľadové články k patogenéze a biomarkerom. Bibliografické údaje všetkých citovaných prác boli overené cez PubMed. Doplnili sme tiež vstupné kritériá kohorty RaDaR, ktoré obmedzujú prenositeľnosť uvedených podielov, a terminologické rozlíšenie IgAN a IgAV.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Barratt J. The Hidden Danger of IgAN: Pathogenesis and Unmet Needs. CME aktivita, Global Learning Collaborative / ReachMD, uvoľnené 31. augusta 2026. <a href="https://reachmd.com/programs/cme/the-hidden-danger-of-igan-pathogenesis-and-unmet-needs/48884/" target="_blank" rel="noopener noreferrer">stránka aktivity</a>.</em></small></li>
  <li><small><em>Pitcher D, Braddon F, Hendry B, Mercer A, Osmaston K, Saleem MA, Steenkamp R, Wong K, Turner AN, Wang K, Gale DP, Barratt J. Long-Term Outcomes in IgA Nephropathy. <em>Clinical Journal of the American Society of Nephrology.</em> 2023;18(6):727–738. doi: 10.2215/CJN.0000000000000135. PMID 37055195. <a href="https://pubmed.ncbi.nlm.nih.gov/37055195/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10278810/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
  <li><small><em>Floege J, Barratt J, Cook HT, Noronha IL, Reich HN, Suzuki Y, Tang SCW, Trimarchi H, Balk EM, Gordon CE, Adam GP, Tonelli MA, Earley A, Rovin BH. Executive summary of the KDIGO 2025 Clinical Practice Guideline for the Management of Immunoglobulin A Nephropathy (IgAN) and Immunoglobulin A Vasculitis (IgAV). <em>Kidney International.</em> 2025;108(4):548–554. doi: 10.1016/j.kint.2025.04.003. PMID 40975525. <a href="https://pubmed.ncbi.nlm.nih.gov/40975525/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://kdigo.org/guidelines/iga-nephropathy/" target="_blank" rel="noopener noreferrer">stránka odporúčania KDIGO</a>.</em></small></li>
  <li><small><em>Yamada K, Ogiwara K, Novak J, Suzuki Y. Aberrant signaling in tonsillar B cells producing pathogenic-glycoforms of IgA1 in IgA nephropathy. <em>Frontiers in Immunology.</em> 2026;17:1737992. doi: 10.3389/fimmu.2026.1737992. PMID 41694356. <a href="https://pubmed.ncbi.nlm.nih.gov/41694356/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Kamal F, Kim J, Lafayette R. Current Biomarkers of IgA Nephropathy. <em>Seminars in Nephrology.</em> 2025;44(5):151572. doi: 10.1016/j.semnephrol.2025.151572. PMID 40087126. <a href="https://pubmed.ncbi.nlm.nih.gov/40087126/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_iga-nefropatia-skryty-priebeh-oneskorena-diagnostika_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
