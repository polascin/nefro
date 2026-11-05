<?php
/**
 * add_komplement-nefrologia-patofyziologia-diagnostika-terapia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT: Core Curriculum 2026 (Thurman, Poppelaars) + doplňujúce
 * overené zdroje. Avíza do newslettera sa neposielajú (enqueue_newsletter false).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_komplement-nefrologia-patofyziologia-diagnostika-terapia_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Komplement v nefrológii: od patofyziológie k diagnostike a cielenej terapii',
    'slug'         => 'komplement-nefrologia-patofyziologia-diagnostika-terapia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Komplementová kaskáda v nefrológii: tri iniciačné dráhy, regulácia, viacvrstvová diagnostika, FDA schválené inhibítory pre päť renálnych indikácií a prevencia meningokokovej infekcie.',
    'content'      => <<<'HTML'
<figure><a href="img/komplement-nefrologia-patofyziologia-diagnostika-terapia.webp" rel="noopener noreferrer" target="_blank"><img src="img/komplement-nefrologia-patofyziologia-diagnostika-terapia.webp" alt="Polopriesvitná oblička v tmavom priestore s jantárovou molekulárnou kaskádou a tyrkysovým lúčom, ktorý blokuje jeden uzol" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Komplementová kaskáda môže poškodiť glomerulus; cielená blokáda zasahuje konkrétny uzol, no zároveň oslabuje obranu proti infekcii.</figcaption></figure>

<p>Komplementová kaskáda je súčasťou vrodenej imunity. Plní ochranné aj homeostatické („udržiavacie“) funkcie. Pri poruche regulácie však môže dôjsť k nekontrolovanej aktivácii, ktorá prispieva k zápalovému poškodeniu tkanív, vrátane glomerulov a tubulointerstícia. V nefrológii sa preto komplement posúva od rámca čisto „imunitne sprostredkovanej“ nefritídy k vysvetľovaniu poškodenia aj pri chorobách, ktoré sa tradične nepovažujú za výlučne imunitné. Význam tejto osi rastie aj vďaka schváleným komplementovým inhibítorom, ktoré cielene blokujú rozhodujúce uzly kaskády. Súčasťou praktického prístupu je kvalitná diagnostika, opatrná interpretácia biomarkerov a osobitná prevencia infekcií, najmä invazívneho meningokokového ochorenia.<sup><a href="#ref1">1</a>–<a href="#ref4">4</a></sup></p>

<p>Podľa <em>Core Curriculum 2026</em> v <em>American Journal of Kidney Diseases</em> (Thurman, Poppelaars) už Úrad pre kontrolu potravín a liekov (FDA) schválil komplementové inhibítory pre päť renálnych indikácií: atypický hemolyticko-uremický syndróm (aHUS), komplement 3 glomerulopatiu (C3G), imunokomplexovú membranoproliferatívnu glomerulonefritídu (IC-MPGN), ANCA-asociovanú vaskulitídu (AAV) a IgA nefropatiu. Väčšina imunosupresív komplement priamo neblokuje; preto sa očakáva ďalšie rozširovanie indikácií aj nových látok.<sup><a href="#ref1">1</a></sup></p>

<h2>Úvod do kaskády</h2>

<p>Komplement je systém rozpustných a membránovo viazaných bielkovín, ktorý sa aktivuje kaskádovito a rýchlo generuje biologicky aktívne fragmenty. Po aktivácii komplement:</p>

<ul>
  <li>spúšťa zápalové a vasoaktívne reakcie,</li>
  <li>opsonizuje cieľové štruktúry,</li>
  <li>umožňuje lýzu buniek prostredníctvom membránového útočného komplexu (C5b-9).<sup><a href="#ref1">1</a>,<a href="#ref2">2</a>,<a href="#ref5">5</a></sup></li>
</ul>

<p>V obličkách sa komplement podieľa na poškodení v rôznych klinických fenotypoch. Najvýraznejší kauzálny vplyv sa ukazuje pri ochoreniach, kde je komplementová dysregulácia dominantným mechanizmom, napríklad pri aHUS a C3G. Súčasne pribúdajú dôkazy o úlohe komplementu aj v iných ochoreniach, kde môže pôsobiť ako sekundárny mediátor zápalu alebo poškodenia.<sup><a href="#ref2">2</a>,<a href="#ref3">3</a></sup></p>

<h2>Aktivácia komplementu a výstupy relevantné pre obličky</h2>

<p>Komplementový systém sa iniciuje tromi dráhami: klasickou, lektínovou a alternatívnou.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup> Bez ohľadu na iniciačný mechanizmus sa dráhy zbiehajú na spoločných funkčných uzloch, najmä v momente, keď vzniká aktivita C3-konvertázy a následne sa štiepi C3 na fragmenty C3a a C3b. Pre patofyziológiu obličiek sú tieto fragmenty kľúčové, pretože C3b:</p>

<ul>
  <li>amplifikuje ďalšiu aktiváciu systému (pozitívna spätná väzba; pri alternatívnej dráhe aj spontánny „tick-over“ mechanizmus),</li>
  <li>opsonizuje cieľové štruktúry fixáciou fragmentov na povrchy buniek alebo extracelulárnu matrix,</li>
  <li>slúži ako ligand pre komplementové receptory na leukocytoch a dendritických bunkách.<sup><a href="#ref1">1</a>,<a href="#ref2">2</a></sup></li>
</ul>

<p>Pri ďalšom priebehu aktivácie vznikajú aj C5a a C5b-9. C5a je silný anafylatoxín s výrazným prozápalovým účinkom. C5b-9 (membránový útočný komplex) môže pri dostatočnej lokálnej tvorbe spôsobiť osmotickú lýzu cieľových buniek; pri sublytickom množstve skôr ich aktiváciu.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></p>

<p>Komplementové výstupné mediátory sa nedajú posudzovať izolovane. Podľa konkrétnej diagnózy sa líši dominantná iniciačná dráha, miera systémovej spotreby niektorých komponentov a najmä spôsob, akým sa fragmenty komplementu ukladajú v tkanive obličky.<sup><a href="#ref1">1</a>,<a href="#ref2">2</a></sup></p>

<h2>Regulačné proteíny a citlivosť obličky</h2>

<p>Aby sa predišlo poškodeniu vlastných tkanív, je komplementová aktivácia prísne regulovaná inhibičnými a kontrolnými mechanizmami. Ide o proteíny exprimované na povrchu buniek aj cirkulujúce v plazme. Ich funkcie zahŕňajú:</p>

<ol>
  <li>zrýchlenie rozpadu (decay acceleration) konvertáz,</li>
  <li>kofaktorovú funkciu pre štiepenie C3b faktorom I,</li>
  <li>blokovanie tvorby úplného póru C5b-9 prostredníctvom CD59.<sup><a href="#ref1">1</a>,<a href="#ref2">2</a></sup></li>
</ol>

<p>V obličkách má osobitný význam regulácia alternatívnej dráhy. Poruchy regulácie, aj keď sú systémové, často vedú k tomu, že klinicky najvýraznejšie poškodenie je práve v obličkách. Klinický význam tohto tvrdenia podporuje skutočnosť, že izolované funkčné deficity faktora H predstavujú riziko pre aHUS a C3G.<sup><a href="#ref1">1</a>,<a href="#ref2">2</a></sup></p>

<h2>Úloha komplementu v nefrologických fenotypoch</h2>

<p>Súčasné pohľady zdôrazňujú dve roviny. Pri vybraných diagnózach (napríklad aHUS, C3G) je komplementová aktivácia dominantným kauzálnym mechanizmom. Pri iných ochoreniach môže byť komplement sekundárnym mediátorom, ktorého príspevok k progresii treba overovať biomarkermi a klinickými štúdiami.<sup><a href="#ref3">3</a></sup> Tento rozdiel má priamy vplyv na prístup k liečbe a na interpretáciu diagnostických testov, najmä pri rozhodovaní o komplementovej blokáde.<sup><a href="#ref1">1</a>,<a href="#ref3">3</a></sup></p>

<p>Praktický prehľad s dôrazom na IgA nefropatiu je v samostatnom článku <a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement v nefrológii: diagnostika, infekčné riziko a cielená inhibícia pri IgA nefropatii</a>. Stručný vizuálny prehľad dráh nájdete aj v <a href="article.php?slug=cheatsheet-komplement">cheatsheete o komplemente</a>.</p>

<h2>Diagnostika komplementu v praxi</h2>

<p>Diagnostika komplementu nie je jeden test. Zahŕňa kombináciu genetickej analýzy, merania intaktných komponentov a aktivačných fragmentov v plazme a moči, funkčných hemolytických testov, imunofluorescenčnej mikroskopie depozít v tkanive a vyhľadávania autoprotilátok proti komplementovým faktorom.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></p>

<h3>Meranie plazmatických komponentov a fragmentov</h3>

<p>Meranie C3 a C4 môže byť užitočné, ale má limity. Pokles C3 alebo C4 často odráža spotrebu pri aktívnej komplementovej aktivácii; tieto bielkoviny však môžu byť nízke aj z iných dôvodov (sepse, iné zápalové stavy, porucha tvorby pri chronickom ochorení pečene alebo malnutrícia). Naopak, C3 a C4 sú proteíny akútnej fázy, takže ich zvýšenie môže maskovať spotrebu.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></p>

<p>Fragmenty vznikajúce počas aktivácie (napríklad C3a, C4a, C5a, Bb, sC5b-9) môžu byť citlivejšie, no závisia od manipulácie so vzorkou a ich interpretácia v klinickej rutine nie je rovnako štandardizovaná ako pri základných skríningových parametroch.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup> Pre konzistentný odber platí, že na testy fragmentov sa používa plazma s EDTA, pretože zrážanie séra v skúmavkách môže podporiť tvorbu fragmentov.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></p>

<h3>Funkčné testy: CH50 a AH50</h3>

<p>CH50 meria celkovú hemolytickú kapacitu klasickej dráhy, AH50 funkciu dráhy alternatívnej. Tieto testy sa využívajú aj na monitorovanie, či je komplement úplne inhibovaný u pacientov liečených inhibítorom komplementu.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></p>

<h3>Imunofluorescenčná mikroskopia a depozity v obličke</h3>

<p>Imunofluorescencia je kľúčová pre diagnostické rozlíšenie komplementom sprostredkovaných fenotypov, napríklad detekcia depozít C3 pri C3 glomerulopatii, zachytenie vzorov spojených s inými imunitne sprostredkovanými procesmi a v transplantovanej obličke význam C4d v diagnostike protilátkovej rejekcie.<sup><a href="#ref1">1</a></sup></p>

<p>Praktický detail: „C3 depozity“ spravidla odrážajú fixáciu fragmentov C3 vytvorených počas aktivácie ktoroukoľvek iniciačnou dráhou, nie priamy dôkaz jednej konkrétnej vetvy aktivácie. Interpretácia sa preto musí viazať na celý diagnostický obraz.<sup><a href="#ref1">1</a></sup></p>

<h3>Genetická analýza</h3>

<p>Genetické testovanie má v nefrológii najväčšiu hodnotu pri aHUS, IC-MPGN a C3G. Identifikácia variantov podporuje diagnostiku, stratifikáciu rizika recidívy po transplantácii a výber racionálnej stratégie monitorovania.<sup><a href="#ref1">1</a>,<a href="#ref2">2</a></sup></p>

<h2>Cielená komplementová terapia</h2>

<p>Komplementové inhibítory patria medzi lieky, ktoré priamo zasahujú do patologickej osi. Iné imunosupresívne postupy (napríklad cytotoxické látky alebo glukokortikoidy) zvyčajne blokujú iné mechanizmy a nie sú cielene zamerané na komplementovú aktiváciu.<sup><a href="#ref1">1</a>,<a href="#ref4">4</a></sup></p>

<h3>Ktoré diagnózy sú dnes cielene liečiteľné podľa FDA</h3>

<p>Podľa abstraktu Core Curriculum 2026 boli inhibítory komplementu schválené FDA pre päť nefrologických indikácií: aHUS, C3G, IC-MPGN, AAV a IgA nefropatiu.<sup><a href="#ref1">1</a></sup> Regulačný status konkrétnych liekov a indikácií sa môže líšiť medzi USA, Európskou úniou a Slovenskom; FDA schválenie samo osebe nie je lokálnym odporúčaním na predpis.</p>

<h3>Princíp liečby a kombinovanie pri chorobách s viacerými mechanizmami</h3>

<p>Pri diagnózach, kde je komplement hlavný mechanizmus ochorenia, môžu inhibítory predstavovať lieky meniace priebeh. Pri iných ochoreniach sa však komplementová inhibícia má začleniť do širšieho terapeutického rámca. Samotné blokovanie komplementu nepôsobí na tvorbu autoprotilátok alebo imunokomplexov vyššie v patogenéze. Existujúce imunokomplexy v glomeruloch sa preto môžu odstraňovať pomalšie, často v horizonte mesiacov.<sup><a href="#ref1">1</a></sup></p>

<h3>Praktické rozhodovanie pred začiatkom liečby</h3>

<p>Pred začatím komplementovej inhibície je potrebné:</p>

<ul>
  <li>optimalizovať podpornú liečbu,</li>
  <li>zhodnotiť riziko infekcií a stav očkovania,</li>
  <li>posúdiť, či ide o komplementom sprostredkované ochorenie,</li>
  <li>vyhodnotiť aktivitu a rozsah ireverzibilného poškodenia (napríklad podľa biopsie a sledovaných markerov).<sup><a href="#ref1">1</a></sup></li>
</ul>

<p>Detailnejšie o C3G pozri <a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">Komplement 3 glomerulopatia: štandard starostlivosti a cielená inhibícia</a>.</p>

<h2>Riziko infekcií pri komplementovej inhibícii</h2>

<p>Komplement má zásadnú úlohu v obrane proti patogénom. Komplementová inhibícia preto zvyšuje riziko závažných bakteriálnych infekcií, najmä invazívneho meningokokového ochorenia.</p>

<h3>Očkovanie a prečo nie je úplnou garanciou ochrany</h3>

<p>Pri inhibícii C5 (napríklad ekulizumab) je známe zvýšenie incidencie invazívneho meningokokového ochorenia. V klinickom kontexte je riziko približne 1&nbsp;000- až 2&nbsp;000-násobné v porovnaní s bežnou populáciou.<sup><a href="#ref6">6</a>,<a href="#ref7">7</a></sup></p>

<p>Očkovanie proti meningokokom je odporúčané pred začiatkom liečby. CDC odporúča ideálne dokončiť alebo aktualizovať meningokokové očkovanie (MenACWY aj MenB) aspoň 2&nbsp;týždne pred prvou dávkou komplementového inhibítora; ak odklad liečby nie je prijateľný, možno začať skôr, no treba počítať s antibiotickou profylaxiou do vytvorenia imunity. Ani po očkovaní riziko ochorenia nezaniká, čo dokumentujú analýzy prípadov u pacientov liečených C5 inhibítormi.<sup><a href="#ref6">6</a>,<a href="#ref7">7</a></sup></p>

<h3>Preventívna antibiotická profylaxia</h3>

<p>V niektorých odporúčaniach a v praxi sa zvažuje antibiotická profylaxia, často počas trvania inhibície komplementu, najmä pri blokátoroch C5. CDC uvádza, že niektorí poskytovatelia zdravotnej starostlivosti aj verejné zdravotnícke inštitúcie odporúčajú profylaxiu počas celej liečby, pretože očkovanie samo osebe riziko nemusí vylúčiť.<sup><a href="#ref6">6</a>,<a href="#ref7">7</a></sup></p>

<h3>Profil infekcií podľa typu deficitu alebo inhibície</h3>

<p>Zápalové a infekčné riziko závisí od miesta v kaskáde, kde je komplement oslabený. Pacienti s vrodenými alebo získanými deficitmi komponentov na rôznych úrovniach kaskády majú rozdielne spektrum rizikových patogénov. Tento princíp je dôležitý pri edukácii a pri klinickej ostražitosti.<sup><a href="#ref1">1</a>,<a href="#ref4">4</a></sup></p>

<h2>Komplementové vyšetrenia v klinickom rozhodovaní</h2>

<p>V praxi je užitočné rozlišovať:</p>

<ul>
  <li>testy, ktoré sú skôr skríningom systémovej spotreby,</li>
  <li>testy, ktoré lepšie odrážajú lokálnu aktiváciu v obličke (najmä tkanivové depozity),</li>
  <li>testy s najvyššou hodnotou pre interpretáciu v kontexte konkrétneho lieku (napríklad funkčné testy pri monitorovaní úplnosti inhibície).<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></li>
</ul>

<p>Opakovaná biopsia môže byť vhodná v špecifických klinických scenároch, no jej klinická užitočnosť a implementácia zostávajú predmetom hodnotenia. Tkanivová imunofluorescencia je dôležitá pre diagnózu viacerých komplementom sprostredkovaných ochorení a v niektorých štúdiách sa spája aj s prognózou.<sup><a href="#ref1">1</a></sup></p>

<h2>Zhrnutie pre nefrologickú komunitu</h2>

<p>Komplementová kaskáda predstavuje v nefrológii cieľovú os so štyrmi praktickými dôsledkami:</p>

<ol>
  <li>Komplement nie je len mechanizmus „klasickej“ imunitnej nefritídy, ale môže byť kľúčový aj pri ochoreniach, ktoré klinicky vyzerajú heterogénne.<sup><a href="#ref3">3</a></sup></li>
  <li>Diagnostika musí byť viacvrstvová: biomarkery, funkčné testy a tkanivové nálezy treba čítať spoločne, nie izolovane.<sup><a href="#ref1">1</a>,<a href="#ref5">5</a></sup></li>
  <li>Komplementová inhibícia je liečebný smer, ktorý sa v primeraných indikáciách odlišuje od iných imunosupresívnych stratégií tým, že zasahuje priamo do patologického mechanizmu.<sup><a href="#ref4">4</a></sup></li>
  <li>Bezpečnosť vyžaduje systematickú prevenciu infekcií, edukáciu pacienta a koordinovaný manažment rizika.<sup><a href="#ref6">6</a>,<a href="#ref7">7</a></sup></li>
</ol>

<h2>Limity</h2>

<ul>
  <li>Plný text Core Curriculum 2026 je u vydavateľa spoplatnený; tento článok vychádza z PubMed abstraktu (PMID 42726032), Crossref metadát, otvorených CDC/MMWR dokumentov a ďalších overených sekundárnych zdrojov.</li>
  <li>Schválenia FDA nie sú automaticky platné pre EÚ ani Slovensko; pred predpisom treba overiť lokálny SPC a úhradový status.</li>
  <li>Presné percentá a tabuľky dávkovania konkrétnych liekov nie sú v tomto prehľade cieľom; podrobnosti k jednotlivým diagnózam sú v súvisiacich článkoch.</li>
  <li>Interpretácia C3/C4 a fragmentov bez kontextu biopsie a klinického obrazu môže viesť k nesprávnemu rozhodnutiu o blokáde.</li>
</ul>

<hr>

<p><strong>Upozornenie pre zdravotníckych pracovníkov:</strong> Text slúži na odbornú orientáciu. Nie je návodom na liečbu konkrétneho pacienta. Indikáciu, dávkovanie, očkovanie a antibiotickú profylaxiu treba vždy overiť podľa aktuálneho SPC, lokálnych odporúčaní a stavu pacienta.</p>

<h2>Literatúra</h2>

<ol>
  <li id="ref1"><strong>Joshua M. Thurman, Felix Poppelaars.</strong> <em>Complement in Kidney Disease: Core Curriculum 2026.</em> American Journal of Kidney Diseases. 2026;88(5):781–796. doi:<a href="https://doi.org/10.1053/j.ajkd.2026.06.008" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2026.06.008</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42726032/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ajkd.org/article/S0272-6386(26)01049-8/fulltext" target="_blank" rel="noopener noreferrer">AJKD</a>.</li>
  <li id="ref2"><strong>Vojtech Petr, Joshua M. Thurman.</strong> <em>The role of complement in kidney disease.</em> Nature Reviews Nephrology. 2023;19(12):771–787. doi:<a href="https://doi.org/10.1038/s41581-023-00766-1" target="_blank" rel="noopener noreferrer">10.1038/s41581-023-00766-1</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37735215/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li id="ref3"><strong>Marina Vivarelli, Jonathan Barratt, Laurence H. Beck, Fadi Fakhouri, Daniel P. Gale, Elena Goicoechea de Jorge, Marta Mosca, Marina Noris, Matthew C. Pickering, Katalin Susztak, Joshua M. Thurman, Michael Cheung, Jennifer M. King, Michel Jadoul, Wolfgang C. Winkelmayer, Richard J. H. Smith.</strong> <em>The role of complement in kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference.</em> Kidney International. 2024;106(3):369–391. doi:<a href="https://doi.org/10.1016/j.kint.2024.05.015" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2024.05.015</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38844295/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li id="ref4"><strong>Erin E. West, Trent Woodruff, Veronique Fremeaux-Bacchi, Claudia Kemper.</strong> <em>Complement in human disease: approved and up-and-coming therapeutics.</em> The Lancet. 2024;403(10424):392–405. doi:<a href="https://doi.org/10.1016/S0140-6736(23)01524-6" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(23)01524-6</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37979593/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li id="ref5"><strong>Maria Alice V. Willrich, Karin M. P. Braun, Ann M. Moyer, David H. Jeffrey, Ashley Frazer-Abel.</strong> <em>Complement testing in the clinical laboratory.</em> Critical Reviews in Clinical Laboratory Sciences. 2021;58(7):447–478. doi:<a href="https://doi.org/10.1080/10408363.2021.1907297" target="_blank" rel="noopener noreferrer">10.1080/10408363.2021.1907297</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33962553/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li id="ref6"><strong>Lucy A. McNamara, Nadav Topaz, Xin Wang, Susan Hariri, LeAnne Fox, Jessica R. MacNeil.</strong> <em>High Risk for Invasive Meningococcal Disease Among Patients Receiving Eculizumab (Soliris) Despite Receipt of Meningococcal Vaccine.</em> MMWR Morbidity and Mortality Weekly Report. 2017;66(27):734–737. doi:<a href="https://doi.org/10.15585/mmwr.mm6627e1" target="_blank" rel="noopener noreferrer">10.15585/mmwr.mm6627e1</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28704351/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.cdc.gov/mmwr/volumes/66/wr/mm6627e1.htm" target="_blank" rel="noopener noreferrer">CDC/MMWR</a>.</li>
  <li id="ref7"><strong>Centers for Disease Control and Prevention (CDC).</strong> <em>Clinical Guidance for Managing Meningococcal Disease Risk in Patients Receiving Complement Inhibitor Therapy.</em> Dostupné na: <a href="https://www.cdc.gov/meningococcal/hcp/clinical-guidance/complement-inhibitor.html" target="_blank" rel="noopener noreferrer">cdc.gov/meningococcal/…/complement-inhibitor.html</a> (overené 1. 11. 2026).</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Identifikátory DOI/PMID, úplné autorské zoznamy a bibliografické údaje (ročník, číslo, strany) boli overené cez Crossref a PubMed eutils. Hlavné tvrdenie o piatich FDA indikáciách vychádza z PubMed abstraktu Core Curriculum 2026. Údaje o 1&nbsp;000- až 2&nbsp;000-násobnom riziku meningokokovej infekcie a o limitoch očkovania boli overené v MMWR 2017 a v otvorenom CDC guidance. Plný text AJKD nebol dostupný bez paywallu; formulácie, ktoré by vyžadovali doslovný citát z plného textu, neboli použité. Vlastný prínos: slovenská odborná redakcia, štruktúra pre klinickú prax a krížové odkazy na súvisiace články portálu.</em></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement v nefrológii: diagnostika, infekčné riziko a cielená inhibícia pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3 glomerulopatia a inhibícia komplementu</a></li>
  <li><a href="article.php?slug=cheatsheet-komplement">Cheatsheet: komplement</a></li>
  <li><a href="article.php?slug=imunitne-podmienena-ttp-urgentna-diagnoza-nefrologia">Imunitne podmienená TTP: urgentná diagnóza</a></li>
  <li><a href="article.php?slug=anca-vaskulitida-renalne-postihnutie-standardy-liecby-2026">ANCA vaskulitída: renálne postihnutie</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// Avíza sa pri publikovaní neposielajú, pokiaľ používateľ výslovne nepožiada.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_komplement-nefrologia-patofyziologia-diagnostika-terapia_article',
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
