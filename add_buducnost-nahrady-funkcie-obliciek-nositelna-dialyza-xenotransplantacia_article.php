<?php

/**
 * Odborny clanok: buducnost nahrady funkcie obliciek (nositelna dialyza,
 * bioartificialna oblicka, organoidy, crevne sorbenty, xenotransplantacia).
 * Zdroj: Winkler MKH et al., Nat Rev Nephrol 2026 (PMID 42995255) a primarne prace.
 *
 * Avíza sa pri publikovaní neposielajú: 'enqueue_newsletter' => false
 * (rozosielanie riadi používateľ sám).
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
    'title'        => 'Budúcnosť náhrady funkcie obličiek: od nositeľnej dialýzy po xenotransplantáciu',
    'slug'         => 'buducnost-nahrady-funkcie-obliciek-nositelna-dialyza-xenotransplantacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nositeľná dialýza, implantovateľný bioreaktor, organoidy, črevné sorbenty a prasacia oblička: čo z nových smerov náhrady funkcie obličiek je už preukázané a čo zostáva výskumným cieľom.',
    'content'      => <<<'HTML'
<figure><a href="img/buducnost-nahrady-funkcie-obliciek-nositelna-dialyza-xenotransplantacia.webp" target="_blank" rel="noopener noreferrer"><img src="img/buducnost-nahrady-funkcie-obliciek-nositelna-dialyza-xenotransplantacia.webp" alt="Poloschematická oblička, ktorej jedna polovica je technické mikrozariadenie s membránami a kanálikmi a druhá živé tkanivo s tubulmi" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho zariadenia ani pacienta. Výskum náhrady funkcie obličiek postupuje od techniky k biológii a späť: membrány, sorbenty, živé bunky a celé orgány.</figcaption></figure>

<p><strong>Náhrada funkcie obličiek sa dnes rozvíja naraz viacerými smermi: miniaturizáciou dialyzačných prístrojov, spájaním membrán so živými bunkami, tvorbou obličkového tkaniva z kmeňových buniek a xenotransplantáciou.</strong> Prehľad, ktorý 6. novembra 2026 uverejnil online časopis <em>Nature Reviews Nephrology</em>, tieto smery spája do spoločného výskumného rámca. Ide o aktualizovanú „cestovnú mapu“ (roadmap) inovácií náhrady funkcie obličiek, na ktorej sa podieľalo 29 autorov z oblasti nefrológie, bioinžinierstva, transplantológie aj pacientskych organizácií. [1]</p>

<p>Cieľom je liečba, ktorá lepšie nahradí stratené funkcie obličiek a zároveň menej obmedzí každodenný život pacienta. Prehľad je však výskumná koncepcia, nie dôkaz, že niektorá z opisovaných technológií už môže nahradiť zavedenú dialýzu alebo transplantáciu. Pri každom smere sa preto oplatí oddeliť, čo už bolo preukázané, od toho, čo zostáva cieľom. [1]</p>

<h2>Čo má nová liečba skutočne nahrádzať</h2>

<p>Pri hodnotení nových zariadení nestačí otázka, či odstraňujú močovinu. Podstatné je aj odstraňovanie širšieho spektra uremických retenčných látok vrátane stredných molekúl a látok viazaných na bielkoviny, regulácia objemu a elektrolytov a možnosť doplniť vybrané biologické funkcie obličkových buniek, napríklad aktiváciu vitamínu D. Prepojenie technických a biologických riešení je spoločnou témou nového prehľadu aj staršieho prehľadu o prenosných, nositeľných a implantovateľných systémoch. [1, 2]</p>

<p>Tieto označenia treba používať presne. <strong>Prenosný</strong> prístroj sa dá premiestniť, <strong>nositeľný</strong> má umožniť liečbu počas pohybu a <strong>implantovateľný</strong> má pracovať po chirurgickom vložení do tela. <strong>Bioartificiálna oblička</strong> spája technické súčasti so živými bunkami. <strong>Organoid</strong> je experimentálny trojrozmerný tkanivový model odvodený z kmeňových buniek. <strong>Xenotransplantácia</strong> znamená transplantáciu medzi odlišnými živočíšnymi druhmi. Výsledok dosiahnutý pri jednom z týchto prístupov preto nemožno automaticky pripísať ostatným. [2, 4, 5, 7]</p>

<h2>Nositeľná dialýza a hranice miniaturizácie</h2>

<p>Jedna štvorhodinová hemodialýza bežne spotrebuje 120 až 150 litrov dialyzačného roztoku. Nositeľný prístroj preto potrebuje uzavretý okruh, v ktorom sa malý objem roztoku priebežne regeneruje. Sorbenty majú zachytávať odstránené látky a umožniť opakované použitie roztoku. Prehľad Ramadu a spoluautorov označuje kontinuálnu regeneráciu malého objemu roztoku za jednu z hlavných prekážok ďalšieho vývoja a za najťažšiu úlohu v nej považuje odstraňovanie močoviny: aktívne uhlie ju viaže slabo a rozklad ureázou vytvára amónium, ktoré treba ďalej zachytiť. [2]</p>

<p>Konkrétne klinické údaje priniesla štúdia Guru a spoluautorov z roku 2016. Zo siedmich zaradených pacientov dokončilo plánovanú 24-hodinovú liečbu päť. Priemerný prietok krvi bol 42 ± 24 ml/min, priemerný klírens močoviny 17 ± 10 ml/min, kreatinínu 16 ± 8 ml/min, fosforu 15 ± 9 ml/min a β<sub>2</sub>-mikroglobulínu 5 ± 4 ml/min. Pacienti boli počas liečby hemodynamicky stabilní a nevyskytli sa závažné nežiaduce udalosti. Skúšanie sa však po siedmom účastníkovi zastavilo pre technické problémy zariadenia vrátane nadmernej tvorby bublín oxidu uhličitého v dialyzačnom okruhu a kolísania prietokov krvi a dialyzačného roztoku. [3]</p>

<p>Výsledok podporuje technickú uskutočniteľnosť krátkodobej nositeľnej hemodialýzy. Sedem účastníkov a jednodňová liečba však neposkytujú dôkaz o dlhodobej bezpečnosti, nižšej mortalite ani trvalom zlepšení kvality života. Klírens pri kontinuálnej liečbe s nízkym prietokom krvi navyše nemožno bez zohľadnenia trvania liečby priamo porovnávať s klírensom počas jednej intermitentnej hemodialýzy. [3]</p>

<h2>Implantovateľný bioreaktor ešte nie je funkčná náhrada orgánu</h2>

<p>Bioartificiálny prístup kombinuje filtračnú membránu s bunkovou zložkou. V práci Kimovej a spoluautorov tvorili kremíkové nanopórové membrány rozhranie medzi krvou a ľudskými obličkovými epitelovými bunkami. Membrána mala umožniť výmenu látok a zároveň bunky chrániť pred imunitným poškodením. [4]</p>

<p>Bioreaktor implantovali piatim ošípaným: tri sledovali tri dni, dve sedem dní. Bunky si zachovali životaschopnosť nad 90 %, normálnu alebo zvýšenú expresiu génov pre transportéry a schopnosť aktivovať vitamín D. Zvieratá nedostávali imunosupresiu ani systémovú antikoaguláciu v terapeutickej dávke, dostávali však antiagregačnú liečbu kyselinou acetylsalicylovou a klopidogrelom od troch dní pred implantáciou. Túto okolnosť nemožno vynechať pri interpretácii priechodnosti zariadenia. [4]</p>

<p>Skúmaný bioreaktor je len jednou súčasťou plánovanej implantovateľnej bioartificiálnej obličky. Štúdia neukázala, že by kompletné zariadenie dlhodobo udržalo organizmus so zlyhaním obličiek bez dialýzy. Expresia génu pre transportér sama osebe nedokazuje transport látok v rozsahu potrebnom pre človeka. Predklinická životaschopnosť buniek je nevyhnutný vývojový krok, nie klinický výsledok. [4]</p>

<h2>Organoidy potrebujú aj funkčné prepojenie tkanív</h2>

<p>Pri tvorbe obličkového tkaniva nestačí vytvoriť bunky s vlastnosťami jednotlivých častí nefrónu. Musia byť aj priestorovo a funkčne prepojené. Nefróny v ľudských obličkových organoidoch odvodených z pluripotentných kmeňových buniek zvyčajne končia slepo, bez zberných kanálikov, čo obmedzuje ich funkčný potenciál. Shi a spoluautori v roku 2025 opísali postup, pri ktorom sa distálne časti nefrónov spojili so štruktúrami odvodenými od ureterového púčika a vznikla sieť zberných kanálikov napojená na nefróny. [5]</p>

<p>Ide o pokrok v organizácii tkaniva a v modelovaní vývoja obličky. Zistenie nepreukazuje vytvorenie transplantovateľného orgánu s dostatočnou filtráciou, reguláciou vnútorného prostredia a dlhodobou bezpečnosťou. Z biologicky presvedčivého modelu sa klinická náhrada nestáva len tým, že obsahuje tubuly a zberné kanáliky. [5]</p>

<h2>Črevné sorbenty: rozdiel medzi mechanizmom a prínosom</h2>

<p>Nový prehľad zahŕňa aj znižovanie záťaže uremickými toxínmi prostredníctvom čreva, sorbentov a ovplyvnenia mikrobiómu. Tieto prístupy môžu dopĺňať technické riešenia, ich biologické zdôvodnenie však treba odlišovať od dôkazu klinického prínosu. [1]</p>

<p>Poučným príkladom sú dve randomizované, dvojito zaslepené, placebom kontrolované štúdie EPPIC s perorálnym uhlíkovým adsorbentom AST-120 v dávke 9 g denne. Zaradili spolu 2 035 dospelých so stredne závažnou až závažnou chronickou chorobou obličiek. Primárnym ukazovateľom bol zložený výsledok: začatie dialýzy, transplantácia obličky alebo zdvojnásobenie sérového kreatinínu. Rozdiel oproti placebu sa nepreukázal: pomer rizík bol v EPPIC-1 1,03 (95 % IS 0,84 až 1,27) a v EPPIC-2 0,91 (95 % IS 0,74 až 1,12). Choroba v oboch populáciách progredovala pomalšie, než predpokladal výpočet sily štúdie. [6]</p>

<p>Výsledky nepodporili pridanie AST-120 k štandardnej liečbe v skúmanej populácii. Nemožno ich preniesť na všetky sorbenty a všetky zásahy do mikrobiómu, rovnako však nemožno zníženie koncentrácie vybranej látky automaticky považovať za spomalenie choroby či náhradu dialýzy. Každý postup potrebuje vlastné klinické overenie. [6]</p>

<h2>Xenotransplantácia už prináša klinické údaje</h2>

<p>Xenotransplantácia je v inej fáze vývoja ako laboratórne organoidy. Riella a spoluautori v roku 2026 opísali prvého príjemcu v plánovanej štúdii s troma pacientmi, ktorá prebieha v nemocnici Massachusetts General Hospital v rámci programu rozšíreného prístupu (Expanded Access) FDA. Pacient s dlhým očakávaným čakaním na obličku od zomrelého darcu a bez vhodného žijúceho darcu dostal 25. januára 2025 obličku geneticky upraveného prasaťa s odstránenými hlavnými glykánovými xenoantigénmi, inaktivovanými prasacími endogénnymi retrovírusmi a siedmimi vloženými ľudskými transgénmi. [7]</p>

<p>Štep fungoval okamžite a umožnil 271 dní bez dialýzy. Rejekcia sprostredkovaná T-lymfocytmi zistená v biopsii 14. deň ustúpila po liečbe. Funkcia štepu bola stabilná približne šesť mesiacov, kým sa pre bakteriálnu infekciu (nie zoonotickú) neznížila imunosupresia. Potom sa rozvinul mikrovaskulárny zápal s poškodením endotelu, ktorý napriek trvalo negatívnemu krížovému testu s darcom progredoval do trombotickej mikroangiopatie a viedol k zlyhaniu štepu a nefrektómii. [7]</p>

<p>Prenos prasacích patogénov sa nezistil a protilátky proti HLA sa nezmenili. Po 82 dňoch od odstránenia xenotransplantátu pacient podstúpil transplantáciu ľudskej obličky s okamžitou funkciou štepu a počas 231 dní sledovania bez známok senzibilizácie. Ide však o správu o jednom príjemcovi. Dokladá možnosť dlhšej podpory bez dialýzy a následnej alotransplantácie, neurčuje však pravdepodobnosť úspechu v širšej populácii ani nevylučuje neskoré infekčné či imunologické riziká. [7]</p>

<h2>Čo má rozhodovať o klinickom zavedení</h2>

<p>Spoločným cieľom uvedených prístupov je účinnejšia liečba pri menšej záťaži pacienta. Nový rámec preto popri prežívaní zdôrazňuje mobilitu, kvalitu života a udržateľnosť a za otvorené výzvy považuje bezpečnosť, spravodlivú dostupnosť a možnosť rozšírenia do bežnej praxe. Kladie dôraz aj na to, aby sa do vývoja od začiatku zapájali pacienti. Tieto vlastnosti treba merať spolu s účinnosťou a bezpečnosťou, nie ich predpokladať podľa veľkosti prístroja alebo pôvodu buniek. [1]</p>

<div class="table-responsive" role="region" aria-label="Čo jednotlivé smery náhrady funkcie obličiek doteraz preukázali" tabindex="0">
<table>
<thead><tr><th scope="col">Smer</th><th scope="col">Čo je doložené</th><th scope="col">Čo zostáva otvorené</th></tr></thead>
<tbody>
<tr><th scope="row">Nositeľná hemodialýza</th><td>24-hodinová liečba u 5 zo 7 pacientov bez závažných nežiaducich udalostí</td><td>Technická spoľahlivosť, dlhodobá bezpečnosť, tvrdé klinické výsledky</td></tr>
<tr><th scope="row">Implantovateľný bioreaktor</th><td>Životaschopnosť buniek nad 90 % počas 3 až 7 dní u 5 ošípaných</td><td>Funkcia kompletného zariadenia, transport v rozsahu potrebnom pre človeka</td></tr>
<tr><th scope="row">Obličkové organoidy</th><td>Napojenie nefrónov na zberný systém v laboratórnom modeli</td><td>Filtrácia, regulácia vnútorného prostredia, transplantovateľnosť</td></tr>
<tr><th scope="row">Črevný sorbent AST-120</th><td>Bez vplyvu na progresiu CKD v dvoch randomizovaných štúdiách</td><td>Prínos iných sorbentov a zásahov do mikrobiómu</td></tr>
<tr><th scope="row">Xenotransplantácia</th><td>271 dní bez dialýzy a následná alotransplantácia u jedného príjemcu</td><td>Výsledky v sérii pacientov, neskoré imunologické a infekčné riziká</td></tr>
</tbody>
</table>
</div>

<p>Z klinického pohľadu treba pri každej technológii položiť rovnakú otázku: ktorý výsledok už bol preukázaný a čo ešte zostáva výskumným cieľom? Krátkodobé odstránenie látok, životaschopnosť buniek, prepojenie tubulov a mesiace fungovania xenotransplantátu sú rôzne výsledky. Ich presné pomenovanie umožňuje sledovať pokrok bez neprimeraných očakávaní u pacientov aj lekárov. [3, 4, 5, 7]</p>

<h2>Limity</h2>

<ul>
<li>Prehľad Winklerovej a spoluautorov je naratívny rámec, nie systematický prehľad s metaanalýzou. Viacerí autori uvádzajú vo vyhlásení o konflikte záujmov zakladateľské alebo vlastnícke väzby na firmy vyvíjajúce dialyzačné technológie, kremíkové membrány, organoidy alebo xenotransplantáty. [1]</li>
<li>Údaje o nositeľnej hemodialýze pochádzajú zo skúšania so siedmimi pacientmi a jednodňovou liečbou; konštrukcia zariadenia sa od roku 2016 menila. [3]</li>
<li>Bioreaktor a organoidy sú predklinické modely; výsledky na zvieratách a v kultúre nemožno priamo preniesť na človeka. [4, 5]</li>
<li>Xenotransplantácia je doložená správou o jednom príjemcovi bez kontrolnej skupiny. [7]</li>
</ul>

<hr>

<p><small><em>Text je odborným prehľadom pre zdravotníckych pracovníkov. Opisované technológie s výnimkou zavedenej dialýzy a alotransplantácie sú experimentálne a nie sú súčasťou bežnej klinickej praxe.</em></small></p>

<h2>Literatúra</h2>

<ol>
<li><em>Winkler MKH, Ash SR, Barraclough KA, Bluechel C, Ferrell N, Fissell W 4th, Freedman BS, Gerritsen KGF, Hassan HA, Hentschel DM, Hestekin J, Hughes A, Johnson DG, Krendel M, Li Z, Locke JE, Montserrat N, Nishinakamura R, Plisiewicz A, Ratner BD, Roberts GV, Roy S, Sirich TL, Subramanya AR, Wasse H, Wiener S, Wieringa F, Wolf K, Himmelfarb J. An integrative roadmap for a new era of kidney replacement therapies. Nat Rev Nephrol. 2026 Nov 6; online pred zaradením do čísla. <a href="https://doi.org/10.1038/s41581-026-01146-1" target="_blank" rel="noopener noreferrer">doi:10.1038/s41581-026-01146-1</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42995255/" target="_blank" rel="noopener noreferrer">PubMed PMID 42995255</a>.</em></li>
<li><em>Ramada DL, de Vries J, Vollenbroek J, Noor N, Ter Beek O, Mihăilă SM, Wieringa F, Masereeuw R, Gerritsen K, Stamatialis D. Portable, wearable and implantable artificial kidney systems: needs, opportunities and challenges. Nat Rev Nephrol. 2023;19(8):481-490. <a href="https://doi.org/10.1038/s41581-023-00726-9" target="_blank" rel="noopener noreferrer">doi:10.1038/s41581-023-00726-9</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37277461/" target="_blank" rel="noopener noreferrer">PubMed PMID 37277461</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10240485/" target="_blank" rel="noopener noreferrer">PMC10240485</a>.</em></li>
<li><em>Gura V, Rivara MB, Bieber S, Munshi R, Smith NC, Linke L, Kundzins J, Beizai M, Ezon C, Kessler L, Himmelfarb J. A wearable artificial kidney for patients with end-stage renal disease. JCI Insight. 2016;1(8):e86397. <a href="https://doi.org/10.1172/jci.insight.86397" target="_blank" rel="noopener noreferrer">doi:10.1172/jci.insight.86397</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/27398407/" target="_blank" rel="noopener noreferrer">PubMed PMID 27398407</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4936831/" target="_blank" rel="noopener noreferrer">PMC4936831</a>.</em></li>
<li><em>Kim EJ, Chen C, Gologorsky R, Santandreu A, Torres A, Wright N, Goodin MS, Moyer J, Chui BW, Blaha C, Brakeman P, Vartanian S, Tang Q, Humes HD, Fissell WH, Roy S. Feasibility of an implantable bioreactor for renal cell therapy using silicon nanopore membranes. Nat Commun. 2023;14(1):4890. <a href="https://doi.org/10.1038/s41467-023-39888-2" target="_blank" rel="noopener noreferrer">doi:10.1038/s41467-023-39888-2</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37644033/" target="_blank" rel="noopener noreferrer">PubMed PMID 37644033</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10465514/" target="_blank" rel="noopener noreferrer">PMC10465514</a>.</em></li>
<li><em>Shi M, Crouse B, Sundaram N, Pode Shakked N, Thorner K, King NM, Dutta P, Ester L, Zhang W, Govindarajah V, Kopan R, Cebrian C, Mayhew CN, Helmrath MA, Bonventre JV, McCracken KW. Integrating collecting systems in human kidney organoids through fusion of distal nephron to ureteric bud. Cell Stem Cell. 2025;32(7):1055-1070.e8. <a href="https://doi.org/10.1016/j.stem.2025.04.008" target="_blank" rel="noopener noreferrer">doi:10.1016/j.stem.2025.04.008</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40345193/" target="_blank" rel="noopener noreferrer">PubMed PMID 40345193</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12227295/" target="_blank" rel="noopener noreferrer">PMC12227295</a>.</em></li>
<li><em>Schulman G, Berl T, Beck GJ, Remuzzi G, Ritz E, Arita K, Kato A, Shimizu M. Randomized placebo-controlled EPPIC trials of AST-120 in CKD. J Am Soc Nephrol. 2015;26(7):1732-1746. <a href="https://doi.org/10.1681/ASN.2014010042" target="_blank" rel="noopener noreferrer">doi:10.1681/ASN.2014010042</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25349205/" target="_blank" rel="noopener noreferrer">PubMed PMID 25349205</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4483576/" target="_blank" rel="noopener noreferrer">PMC4483576</a>.</em></li>
<li><em>Riella LV, Borges TJ, Rosales IA, Avillach CT, Palsson R, Hullekes F, Verhoeff R, Pomahac A, Chen JY, Santagata S, Giarraputo A, Smith RN, Le HN, Barth JA, Low SC, Getchell K, Curtis M, Perrin S, Kolev M, Bercovici S, Lindner MS, Ribas GT, Tanguturi VK, Bapat AC, Pattanayak V, Longchamp A, El-Khoury J, Duggan M, Shah S, Pierson R, Madsen JC, Fishman JA, Elias N, Colvin RB, Kawai T. Porcine kidney xenotransplantation as a bridge to allotransplantation: a first-in-human study. Lancet. 2026;408(10559):1029-1040. <a href="https://doi.org/10.1016/S0140-6736(26)01295-X" target="_blank" rel="noopener noreferrer">doi:10.1016/S0140-6736(26)01295-X</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42692038/" target="_blank" rel="noopener noreferrer">PubMed PMID 42692038</a>.</em></li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje všetkých siedmich prác (úplné autorské zoznamy, ročník, číslo, strany, DOI, PMID, PMC) boli overené v databáze PubMed. Číselné údaje pochádzajú zo štruktúrovaných abstraktov [3, 6, 7] a z plných textov v PubMed Central [2, 4]; počet zvierat, trvanie sledovania a antiagregačná liečba v práci [4] sú z jej metodiky. Tabuľka a hodnotenie limitov sú vlastnou syntézou autora článku.</em></small></p>

<h3>Súvisiace články</h3>
<ul>
<li><a href="article.php?slug=xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca">Xenotransplantácia obličky z geneticky upraveného prasaťa: funkčný štep ešte neznamená imunologický pokoj</a></li>
<li><a href="article.php?slug=oblicka-na-cipe-organoidy-mechanicke-sily">Oblička na čipe a obličkové organoidy: mechanické sily otvárajú nové možnosti výskumu ochorení obličiek</a></li>
<li><a href="article.php?slug=synteticke-wnt-organizatory-oblickove-organoidy">Syntetické Wnt-sekretujúce organizátory zlepšujú priestorové usporiadanie ľudských obličkových organoidov</a></li>
<li><a href="article.php?slug=domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja">Domáca hemodialýza: väčšia autonómia pacienta nestačí bez fungujúceho systému</a></li>
<li><a href="article.php?slug=wearables-dialyza-nefrologia-dokazy-a-limity">Nositeľné senzory v nefrológii a dialýze: čo už má validačné dáta a čo je stále vo vývoji</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_buducnost-nahrady-funkcie-obliciek-nositelna-dialyza-xenotransplantacia_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
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
}
