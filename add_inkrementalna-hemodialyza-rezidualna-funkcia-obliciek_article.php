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
    'title' => 'Inkrementálna hemodialýza a reziduálna funkcia obličiek: čo ukazujú dôkazy',
    'slug' => 'inkrementalna-hemodialyza-rezidualna-funkcia-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt' => 'Hemodialýza dvakrát týždenne môže znížiť liečebnú záťaž. Prehľad kohort, randomizovaných štúdií a metaanalýz vysvetľuje neistotu ochrany reziduálnej funkcie aj podmienky bezpečného výberu pacientov.',
    'content'      => <<<'HTML'
<p>Inkrementálna hemodialýza prispôsobuje dialyzačnú dávku reziduálnej funkcii obličiek a postupne ju zvyšuje pri jej poklese. U vybraných pacientov môže začínať dvoma procedúrami týždenne. Observačné štúdie naznačujú pomalší úbytok reziduálnej funkcie, randomizované skúšania však zatiaľ neposkytli presvedčivý dôkaz, že samotná nižšia frekvencia túto funkciu chráni lepšie než liečba trikrát týždenne. Rozhodujúce sú výber pacienta, celková účinnosť liečby a včasná úprava predpisu.</p>

<h2>Čo znamená inkrementálny začiatok dialýzy</h2>
<p>Reziduálna funkcia obličiek (RKF, z anglického <em>residual kidney function</em>) zabezpečuje kontinuálne odstraňovanie vody a rozpustených látok vrátane niektorých stredne veľkých molekúl a toxínov viazaných na bielkoviny. Jej zachovanie sa v observačných štúdiách spája s priaznivejšími výsledkami liečby. Táto asociácia však sama osebe nedokazuje, že zmena frekvencie hemodialýzy zlepší prežívanie. [10]</p>
<p>Režim dvakrát týždenne nie je synonymom inkrementálnej liečby. Inkrementálny program zahŕňa meranie RKF, započítanie jej príspevku do celkového klírensu a zvyšovanie dávky alebo frekvencie podľa potreby. Pevný režim s dvoma procedúrami bez monitorovania a možnosti eskalácie tieto podmienky nespĺňa. Výrazy „dvojtýždňová“ a „trojtýždňová“ nie sú pre uvedené frekvencie vhodné; presné označenia sú <strong>dvakrát týždenne</strong> a <strong>trikrát týždenne</strong>. [9, 13]</p>
<p>Reziduálny renálny klírens močoviny označujeme K<sub>RU</sub>. Hodnoty v ml/min a hodnoty prepočítané na telesný povrch 1,73 m² nemožno bez prepočtu zamieňať. K<sub>RU</sub> zároveň nie je totožný s eGFR vypočítanou zo sérového kreatinínu. Niektoré štúdie odhadujú reziduálnu GFR ako priemer renálneho klírensu močoviny a kreatinínu, následne korigovaný na telesný povrch. [4, 6]</p>

<h2>Observačné kohorty: priaznivá asociácia s významnými obmedzeniami</h2>
<p><strong>Obi a spoluautori</strong> vychádzali z kohorty 23 645 pacientov a porovnali 351 pacientov s inkrementálnym režimom s 8 068 párovanými pacientmi liečenými konvenčne. V druhom štvrťroku bol K<sub>RU</sub> relatívne lepšie zachovaný o 16 % (95 % interval spoľahlivosti [IS] 5 až 28 %) a objem moču o 15 % (95 % IS 2 až 30 %). Pri východiskovom K<sub>RU</sub> ≤ 3 ml/min/1,73 m² sa inkrementálny režim spájal s vyšším rizikom úmrtia: pomer rizík (HR) 1,61; 95 % IS 1,07 až 2,44. Pri vyššom K<sub>RU</sub> sa rozdiel nepreukázal: HR 0,99; 95 % IS 0,76 až 1,28. [2]</p>
<p>Zásadné je, že analýza zahŕňala pacientov, ktorí prežili prvý rok dialýzy, a mortalitu hodnotila až následne. Nemožno ju preto použiť ako dôkaz bezpečnosti prvého roka liečby. Párovanie navyše neodstraňuje všetky rozdiely medzi pacientmi ani skreslenie vyplývajúce z ich výberu. [2]</p>
<p><strong>Kaja Kamal a spoluautori</strong> v jednocentrovej retrospektívnej kohorte porovnali 154 pacientov s režimom dvakrát týždenne a 411 s režimom trikrát týždenne; vstupný K<sub>RU</sub> bol ≥ 3 ml/min. Pri nižšej frekvencii pozorovali pomalší pokles K<sub>RU</sub> a po zohľadnení vybraných premenných priaznivejšie prežívanie (HR 0,755; p = 0,044). Skupiny sa však líšili vekom, hmotnosťou aj komorbiditami. Výsledok podporuje hypotézu, nepreukazuje kauzálny ochranný účinok. [3]</p>

<h2>Randomizované skúšania: čo skutočne preukázali</h2>
<h3>Vilar: uskutočniteľnosť a bezpečnostný signál</h3>
<p>Britská multicentrická pilotná štúdia randomizovala 55 pacientov s K<sub>RU</sub> ≥ 3 ml/min/1,73 m²: 29 do inkrementálnej a 26 do konvenčnej skupiny. Počas 12 mesiacov nezistila rozdiel v sklone poklesu klírensu močoviny. V sledovaní zostalo na konci 21 oproti 12 pacientom. Závažné nežiaduce udalosti boli menej časté v inkrementálnej skupine (pomer mier incidencie 0,47; 95 % IS 0,27 až 0,81), úmrtia boli tri v každej skupine. [1]</p>
<p>Inkrementálna skupina mala nižšie koncentrácie bikarbonátu a nižšie náklady. Výsledok upozorňuje na potrebu sledovať acidobázickú rovnováhu a podľa klinického stavu upraviť liečbu. Pilotný dizajn a malý počet pacientov neumožňujú považovať podobnú mortalitu za definitívny dôkaz rovnakej bezpečnosti. Štúdia neposkytla presvedčivý signál lepšieho zachovania RKF ani kvality života. [1]</p>
<h3>Fernández Lucas: porovnanie hemodiafiltrácie</h3>
<p>Otvorená multicentrická štúdia z roku 2025 randomizovala 150 pacientov s K<sub>RU</sub> ≥ 2,5 ml/min do inkrementálnej hemodiafiltrácie (HDF; n = 77) alebo HDF trikrát týždenne (n = 73). Primárnym ukazovateľom bol sklon poklesu reziduálnej GFR počas 12 mesiacov. Rozdiel medzi skupinami bol −0,09 ml/min/1,73 m² za mesiac (95 % IS −0,23 až 0,06; p = 0,230). Nepreukázali sa ani štatisticky významné rozdiely v anúrii, hospitalizáciách či mortalite. [4]</p>
<p>Publikovaná metodika vypočítala veľkosť vzorky na zachytenie rozdielu v poklese GFR obojstranným testom, nie na preukázanie noninferiority s vopred určenou hranicou. <strong>Nezistený rozdiel preto nemožno interpretovať ako formálny dôkaz noninferiority alebo ekvivalencie.</strong> Išlo o vysokobjemovú postdilučnú HDF, takže prenos výsledkov na iné dialyzačné techniky vyžaduje opatrnosť. [4]</p>
<p>V inkrementálnej skupine bolo počas ročného sledovania podaných priemerne 69,1 procedúry oproti 122,6. Pätnásť pacientov prešlo na tri procedúry týždenne, priemerne po 193 dňoch, bez odmietnutia indikovanej eskalácie. Prínos v niektorých doménach kvality života v šiestom mesiaci sa do dvanásteho mesiaca neudržal. Ide o podporu uskutočniteľnosti a nižšej záťaže procedúrami, nie o dôkaz nefroprotekcie. [4]</p>
<h3>Murea: krátky úvodný režim s podpornou farmakoterapiou</h3>
<p>Ďalšie randomizované pilotné skúšanie zahŕňalo 48 pacientov. Režim dvakrát týždenne bol obmedzený na šesť týždňov a sprevádzala ho protokolová farmakoterapia; následne pacienti prešli na liečbu trikrát týždenne. Primárnym cieľom bolo overiť uskutočniteľnosť. Odhady rozdielov v zachovaní diurézy a klírensu v 24. týždni mali široké intervaly spoľahlivosti zahŕňajúce nulový rozdiel. Táto štúdia dopĺňa dôkazy, ale netestuje dlhodobý režim s dvoma procedúrami bez ďalších intervencií. [14]</p>

<h2>Metaanalýzy: súhrn nezvyšuje istotu nad kvalitu vstupných štúdií</h2>
<p><strong>Caton a spoluautori</strong> zahrnuli 26 štúdií so 101 476 účastníkmi, prevažne kohortových, ale aj dve randomizované skúšania. Súhrnný odhad mortality bol HR 0,99 (95 % IS 0,80 až 1,24). Observačné práce naznačovali pomalší úbytok RKF, randomizované údaje tento výsledok nepodporili. Dve malé randomizované štúdie v súhrne naznačovali menej hospitalizácií (relatívne riziko 0,31; 95 % IS 0,18 až 0,54). Definícia inkrementálnej liečby zahŕňala aj kratšie procedúry, nielen nižšiu frekvenciu. [7]</p>
<p><strong>Takkavatakarn a spoluautori</strong> analyzovali 36 prác so 138 939 účastníkmi. Mortalita sa štatisticky významne nelíšila (pomer šancí [OR] 0,87; 95 % IS 0,72 až 1,04). Inkrementálna liečba sa spájala s nižšou šancou hospitalizácie (OR 0,44; 95 % IS 0,27 až 0,72) a straty RKF (OR 0,31; 95 % IS 0,25 až 0,39). Posledný údaj vyjadruje súhrnný výskyt straty RKF podľa definícií zahrnutých prác, nie percentuálne spomalenie poklesu GFR. Prevažujúci observačný dizajn obmedzuje kauzálnu interpretáciu. [8]</p>
<p><strong>Hazara a spoluautori</strong> publikovali v roku 2026 ďalší prehľad 14 štúdií s 91 928 účastníkmi, so súhrnným HR mortality 0,97 (95 % IS 0,76 až 1,19). Vyhľadávanie však siahalo iba do 20. júla 2020. Nejde teda o aktualizované zhrnutie randomizovaných výsledkov z rokov 2022 až 2025. Autori upozornili na rozdielne liečebné protokoly a publikačné skreslenie. [13]</p>
<p>Prehľady zahŕňajú prekrývajúce sa súbory pôvodných štúdií. Ich počty pacientov nemožno sčítavať ako nezávislé dôkazy. Súhrnné výsledky podporujú ďalší výskum a individualizovaný postup, ale nepreukazujú všeobecnú bezpečnosť režimu dvakrát týždenne ani jeho nadradenosť v ochrane RKF.</p>

<h2>Dialýza raz týždenne s nutričnou intervenciou je samostatná otázka</h2>
<p>Kittiskulnam a spoluautori randomizovali 30 pacientov na HD raz týždenne kombinovanú s nízkobielkovinovou diétou a ketoanalógmi alebo na HD dvakrát týždenne s bežným príjmom bielkovín. Reštrikcia na 0,6 g/kg/deň s ketoanalógmi sa týkala nedialyzačných dní; v dialyzačné dni sa používal bežný príjem bielkovín. Kombinovaná intervencia vykazovala priaznivejšie zachovanie diurézy a klírensov. [5]</p>
<p>Nábor sa však skončil po neplánovanej priebežnej analýze 30 pacientov namiesto plánovaných 50. Autori následne použili korigovanú hladinu významnosti α = 0,025. Často citovaný rozdiel v klírense močoviny v šiestom mesiaci (p = 0,03) túto prísnejšiu hranicu nespĺňa. Malá vzorka, predčasné ukončenie náboru a súčasná zmena frekvencie aj diéty obmedzujú závery. Výsledok nemožno pripísať samotnej frekvencii ani preniesť na porovnanie dvoch a troch procedúr týždenne. Reštrikcia bielkovín sa nemá všeobecne prenášať na dialyzovaných pacientov bez špecializovaného nutričného dohľadu. [5]</p>

<h2>Riziko rýchlej straty reziduálnej funkcie</h2>
<p>Medeiros a spoluautori retrospektívne hodnotili 37 pacientov; kompletné údaje boli dostupné u 30. Pokles K<sub>RU</sub> najmenej o 25 % do troch mesiacov sa vyskytol u deviatich z nich. V multivariačnej analýze sa s týmto výsledkom spájala východisková GFR &lt; 7 ml/min/1,73 m² (OR 25,41; 95 % IS 1,22 až 530,27). [6]</p>
<p>Extrémne široký interval spoľahlivosti, malý počet udalostí a hranica odvodená z analyzovaného súboru znamenajú veľmi neistý odhad. <strong>Hodnota 7 ml/min/1,73 m² nie je validovanou univerzálnou hranicou výberu pacienta ani indikáciou skoršieho začatia dialýzy.</strong> Štúdia podporuje obozretné sledovanie, nie kategorický liečebný algoritmus. [6]</p>

<h2>Praktické dôsledky pre nefrologickú prax</h2>
<p>KDOQI 2015 pripúšťa zníženie dialyzačnej dávky pri významnej reziduálnej funkcii za predpokladu jej pravidelného merania. Pre režimy odlišné od troch procedúr týždenne navrhuje cieľový štandardný Kt/V 2,3 za týždeň a minimálnu podanú hodnotu 2,1, s výpočtom zahŕňajúcim ultrafiltráciu aj reziduálnu funkciu. Ide o neklasifikované odporúčania; samotné dosiahnutie čísla nenahrádza klinické posúdenie. [11]</p>
<ul>
<li><strong>Vybrať vhodného pacienta:</strong> zohľadniť meraný K<sub>RU</sub>, diurézu, priebeh ich poklesu, objemový stav, medzidialyzačné prírastky hmotnosti, draslík, acidobázickú rovnováhu, výživu a schopnosť spoľahlivo spolupracovať. Hranice 2,5 až 3 ml/min zo štúdií sa nesmú mechanicky zjednotiť bez kontroly metodiky a korekcie na telesný povrch. [1–4, 9]</li>
<li><strong>Naplánovať meranie RKF:</strong> používať časovaný zber moču a zodpovedajúce odbery krvi. Mesačné hodnotenie je praktický postup používaný vo viacerých programoch; KDOQI vyžaduje periodické meranie, neurčuje univerzálne povinný mesačný interval. Kontrolu treba urýchliť pri poklese diurézy, interkurentnom ochorení alebo klinickom zhoršení. Samotný objem moču nenahrádza posúdenie klírensu. [3, 6, 10, 11]</li>
<li><strong>Sledovať celú účinnosť liečby:</strong> popri týždennom štandardnom Kt/V hodnotiť urémiu, draslík, bikarbonát, hydratáciu, krvný tlak, fosfát a nutričný stav. Jednorazový spKt/V jednej procedúry nemožno zamieňať s celkovou týždennou dávkou. [9, 11]</li>
<li><strong>Včas zvýšiť dávku alebo frekvenciu:</strong> pri nedostatočnom klírense, nezvládnutej hyperkaliémii, acidóze, preťažení tekutinami alebo uremických prejavoch nemá zachovanie režimu dvakrát týždenne prednosť pred účinnou liečbou. Španielsky protokol napríklad zvyšoval frekvenciu pri opakovane nameranom K<sub>RU</sub> &lt; 2,5 ml/min alebo pri klinickej indikácii; nejde o univerzálnu hranicu pre každý program. [4, 9, 11]</li>
<li><strong>Dohodnúť postup s pacientom:</strong> vysvetliť výhody menšieho počtu návštev aj potrebu zberov moču a budúcej eskalácie. Obmedzovať symptomatickú hypotenziu a neprimeranú ultrafiltráciu. Úspora zdrojov môže byť prínosom, ale nesmie určovať nedostatočný dialyzačný predpis. [9, 10]</li>
</ul>

<h2>Čo zostáva otvorené</h2>
<p>Štúdia VA IncHVets (NCT05465044) porovnáva inkrementálny a konvenčný začiatok HD u veteránov. Podľa registra aktualizovaného 20. augusta 2026 pokračuje nábor, odhadované ukončenie primárneho sledovania je 30. septembra 2027 a výsledky v registri zatiaľ nie sú zverejnené. Prehľadový článok Rheeovej a spoluautorov opisuje tento projekt, nepredkladá jeho výsledky. Nie je možné vopred sľubovať, že jedno skúšanie definitívne vyrieši všetky otázky ochrany RKF. [12, 15]</p>
<p>Inkrementálna HD dvakrát týždenne môže byť rozumnou možnosťou pre starostlivo vybraných pacientov pri zabezpečenom monitorovaní a pripravenosti zvýšiť dávku liečby. Jej uskutočniteľnosť a zníženie počtu procedúr majú oporu v klinických dátach. Presvedčivý dôkaz, že samotná nižšia frekvencia kauzálne spomaľuje stratu RKF alebo zlepšuje prežívanie, však zatiaľ chýba.</p>
<p><small><em>Ide o naratívny odborný prehľad, nie o systematický prehľad so samostatným vyhľadávacím protokolom. Bibliografia a vybrané kľúčové tvrdenia boli overené v PubMed, Europe PMC, dostupných plných textoch, odporúčaniach KDOQI a registri ClinicalTrials.gov. Pri prácach Vilar, Kaja Kamal a Murea sa uvedené výsledky opierajú o bibliografický záznam a abstrakt. Stav overenia: 24. september 2026.</em></small></p>
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Vilar E, Kaja Kamal RM, Fotheringham J, Busby A, Berdeprado J, Kislowska E, Wellsted D, Alchi B, Burton JO, Davenport A, Farrington K. A multicenter feasibility randomized controlled trial to assess the impact of incremental versus conventional initiation of hemodialysis on residual kidney function. Kidney Int. 2022;101(3):615-625. <a href="https://doi.org/10.1016/j.kint.2021.07.025" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/34418414/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Obi Y, Streja E, Rhee CM, Ravel V, Amin AN, Cupisti A, Chen J, Mathew AT, Kovesdy CP, Mehrotra R, Kalantar-Zadeh K. Incremental Hemodialysis, Residual Kidney Function, and Mortality Risk in Incident Dialysis Patients: A Cohort Study. Am J Kidney Dis. 2016;68(2):256-265. <a href="https://doi.org/10.1053/j.ajkd.2016.01.008" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26867814/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kaja Kamal RM, Farrington K, Busby AD, Wellsted D, Chandna H, Mawer LJ, Sridharan S, Vilar E. Initiating haemodialysis twice-weekly as part of an incremental programme may protect residual kidney function. Nephrol Dial Transplant. 2019;34(6):1017-1025. <a href="https://doi.org/10.1093/ndt/gfy321" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/30357360/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Fernández Lucas M, Muriel A, Mendiola NR, Merino JL, Collado A, Díaz Domínguez ME, Ruíz-Roso G, Sánchez R, Herrero JA, Bouarich H, López de la Manzanara V, Zamora J. Randomized Trial of Twice-Weekly Versus Thrice-Weekly Hemodiafiltration for Initiation of Renal Replacement Therapy. Kidney Int Rep. 2025;10(12):4188-4198. <a href="https://doi.org/10.1016/j.ekir.2025.09.048" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41426040/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kittiskulnam P, Tiranathanagul K, Susantitaphong P, Phannajit J, Chongpison Y, Asavapujanamanee P, Surattichaiyakul B, Takkavatakarn K, Katavetin P, Metta K, Praditpornsilpa K. Stepwise Incremental Hemodialysis and Low-Protein Diet Supplemented with Keto-Analogues Preserve Residual Kidney Function: A Randomized Controlled Trial. Nutrients. 2025;17(15):2422. <a href="https://doi.org/10.3390/nu17152422" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40806006/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Medeiros J, Bastos JM, Silva C, Viana J, Ribeiro B, Carvalho R, Costa RM. Accelerated Loss of Residual Kidney Function in Incremental Hemodialysis. Cureus. 2025;17(2):e78601. <a href="https://doi.org/10.7759/cureus.78601" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40062122/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Caton E, Sharma S, Vilar E, Farrington K. Impact of incremental initiation of haemodialysis on mortality: a systematic review and meta-analysis. Nephrol Dial Transplant. 2023;38(2):435-446. <a href="https://doi.org/10.1093/ndt/gfac274" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36130107/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Takkavatakarn K, Jintanapramote K, Phannajit J, Praditpornsilpa K, Eiam-Ong S, Susantitaphong P. Incremental versus conventional haemodialysis in end-stage kidney disease: a systematic review and meta-analysis. Clin Kidney J. 2024;17(1):sfad280. <a href="https://doi.org/10.1093/ckj/sfad280" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38186889/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kalantar-Zadeh K, Unruh M, Zager PG, Kovesdy CP, Bargman JM, Chen J, Sankarasubbaiyan S, Shah G, Golper T, Sherman RA, Goldfarb DS. Twice-weekly and incremental hemodialysis treatment for initiation of kidney replacement therapy. Am J Kidney Dis. 2014;64(2):181-186. <a href="https://doi.org/10.1053/j.ajkd.2014.04.019" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/24840669/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Mathew AT, Fishbane S, Obi Y, Kalantar-Zadeh K. Preservation of residual kidney function in hemodialysis patients: reviving an old concept. Kidney Int. 2016;90(2):262-271. <a href="https://doi.org/10.1016/j.kint.2016.02.037" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/27182000/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>National Kidney Foundation. KDOQI Clinical Practice Guideline for Hemodialysis Adequacy: 2015 update. Am J Kidney Dis. 2015;66(5):884-930. <a href="https://doi.org/10.1053/j.ajkd.2015.07.015" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26498416/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Rhee CM, Kovesdy CP, Unruh M, Crowley S, Geller D, Goldfarb DS, Kraut J, Rastegar M, Rifkin IR, Kalantar-Zadeh K. Incremental hemodialysis transition in veterans and nonveterans with kidney failure. Curr Opin Nephrol Hypertens. 2025;34(1):33-40. <a href="https://doi.org/10.1097/mnh.0000000000001040" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39611277/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Hazara AM, Abdullah A, Allgar V, Twiddy M, Bhandari S. Incremental Hemodialysis Practices and Impact on Survival: Systematic Review and Meta-Analysis. Kidney Med. 2026;8(3):101238. <a href="https://doi.org/10.1016/j.xkme.2025.101238" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41767695/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Murea M, Patel A, Highland BR, Yang W, Fletcher AJ, Kalantar-Zadeh K, Dressler E, Russell GB. Twice-Weekly Hemodialysis With Adjuvant Pharmacotherapy and Transition to Thrice-Weekly Hemodialysis: A Pilot Study. Am J Kidney Dis. 2022;80(2):227-240.e1. <a href="https://doi.org/10.1053/j.ajkd.2021.12.001" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/34933066/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>ClinicalTrials.gov. Incremental Hemodialysis for Veterans in the First Year of Dialysis (IncHVets). NCT05465044. Aktualizácia 20. augusta 2026. <a href="https://clinicaltrials.gov/study/NCT05465044" target="_blank" rel="noopener noreferrer">Register štúdie</a>.</em></small></li>
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
    'log_prefix' => 'add_inkrementalna-hemodialyza-rezidualna-funkcia-obliciek_article',
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
