<?php
/**
 * Odborný článok: Flukloxacilín verzus cefazolín a akútne poškodenie obličiek pri stafylokokovej bakteriémii.
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

$articles = [];

$articles[] = [
    'title'        => 'Flukloxacilín pri bakteriémii spôsobenej Staphylococcus aureus: častejšie akútne poškodenie obličiek než pri cefazolíne',
    'slug'         => 'flukloxacilin-cefazolin-aki-stafylokokova-bakteriemia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Holandská kohorta 1408 pacientov: akútne poškodenie obličiek vzniklo u 35,2 % pacientov na flukloxacilíne a u 20,2 % na cefazolíne. Väčšina epizód sa objavila do týždňa a zníženie dávky riziko neodstránilo.',
    'content'      => <<<'HTML'
<p>Bakteriémia spôsobená <em>Staphylococcus aureus</em> (<em>S. aureus</em> bacteraemia, SAB) je závažná infekcia s vysokou mortalitou a širokým spektrom komplikácií. Jednou z nich je akútne poškodenie obličiek (<em>acute kidney injury</em>, AKI). Retrospektívna multicentrická kohortová štúdia z troch holandských nemocníc, publikovaná v <em>Journal of Antimicrobial Chemotherapy</em>, sledovala jeho výskyt, načasovanie, závažnosť a zotavenie u pacientov liečených flukloxacilínom alebo cefazolínom.</p>

<p>Z 1408 zaradených pacientov vzniklo AKI u 483 (34,3 %). Pri flukloxacilíne to bolo 466 z 1324 pacientov (35,2 %), pri cefazolíne 17 z 84 (20,2 %); rozdiel bol štatisticky významný (P = 0,004). Po multivariabilnej úprave zostal flukloxacilín spojený s vyššou šancou na AKI (upravený pomer šancí 2,37; 95 % interval spoľahlivosti 1,30 – 4,55).</p>

<p>Práca nestojí osamotene a nie je ani prvým dôkazom v tejto otázke. Nadväzuje na dve randomizované klinické skúšania publikované krátko pred ňou — platformové skúšanie SNAP a francúzske skúšanie CloCeBa —, ktoré rovnaký rozdiel v renálnej bezpečnosti preukázali v randomizovanom usporiadaní. Prínos holandskej kohorty je inde: opisuje, <em>kedy</em> AKI vzniká, <em>ako ťažké</em> je, <em>ako sa</em> obličková funkcia zotavuje a či na tom niečo mení <em>dávka</em> flukloxacilínu.</p>

<h2>Voľba antibiotika pri stafylokokovej bakteriémii</h2>

<p>Bakteriémia spôsobená <em>S. aureus</em> sa môže komplikovať infekčnou endokarditídou, osteomyelitídou, septickou artritídou, epidurálnym abscesom, metastatickými infekčnými ložiskami a sepsou s orgánovou dysfunkciou. Pri kmeni citlivom na meticilín (<em>meticillin-susceptible S. aureus</em>, MSSA) sa uprednostňuje betalaktámové antibiotikum. V európskej praxi je to najčastejšie protistafylokokový penicilín — flukloxacilín, prípadne kloxacilín alebo oxacilín. Alternatívou je cefazolín, cefalosporín prvej generácie.</p>

<p>Rozhodnutie nemožno založiť iba na nefrotoxicite. Treba zohľadniť citlivosť izolátu, miesto a rozsah infekcie, prítomnosť endokarditídy alebo hlbokého ložiska, kvalitu kontroly zdroja infekcie, funkciu obličiek a potrebu úpravy dávky, alergologickú anamnézu, liekové interakcie, farmakokinetické a farmakodynamické vlastnosti liečiva, ako aj lokálnu epidemiológiu a mikrobiologické odporúčania.</p>

<h3>Randomizované dôkazy, ktoré tejto kohorte predchádzali</h3>

<p>Do roku 2025 sa preferencia protistafylokokových penicilínov opierala prevažne o desaťročia klinickej praxe a o observačné porovnania. Dve randomizované skúšania to zmenili.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie randomizovaných skúšaní a holandskej kohorty" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Usporiadanie</th>
      <th scope="col">Porovnanie</th>
      <th scope="col">Výskyt AKI</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">SNAP, doména MSSA (2026)</th>
      <td>Medzinárodné bayesovské adaptívne platformové skúšanie, otvorené, randomizované</td>
      <td>Cefazolín verzus protistafylokokový penicilín (flukloxacilín alebo kloxacilín)</td>
      <td>13,9 % (92/660) verzus 19,6 % (127/648); upravený pomer šancí 0,67; 95 % kredibilný interval 0,50 – 0,89</td>
    </tr>
    <tr>
      <th scope="row">CloCeBa (2025)</th>
      <td>Otvorené randomizované skúšanie non-inferiority, 21 francúzskych nemocníc</td>
      <td>Cefazolín verzus kloxacilín</td>
      <td>1 % (1/134) verzus 12 % (15/128); P = 0,0002</td>
    </tr>
    <tr>
      <th scope="row">Holandská kohorta (2026)</th>
      <td>Retrospektívna multicentrická kohorta, tri nemocnice</td>
      <td>Cefazolín verzus flukloxacilín ako liečba prvej voľby</td>
      <td>20,2 % (17/84) verzus 35,2 % (466/1324); P = 0,004</td>
    </tr>
  </tbody>
</table>
</div>

<p>V skúšaní SNAP bol cefazolín non-inferiórny voči protistafylokokovému penicilínu z hľadiska 90-dňovej mortality (15,0 % verzus 17,0 %; upravený pomer šancí 0,81; 95 % kredibilný interval 0,59 – 1,12; posteriórna pravdepodobnosť non-inferiority 99,2 %) a súčasne mal nižší výskyt AKI. V skúšaní CloCeBa bol cefazolín non-inferiórny v zloženom ukazovateli klinickej účinnosti a mal menej závažných nežiaducich udalostí (15 % verzus 27 %; P = 0,010). Do CloCeBa sa však <strong>nezaraďovali</strong> pacienti s vnútrocievnym implantátom ani s podozrením na infekciu centrálneho nervového systému, čo obmedzuje prenos jeho záverov na tieto situácie.</p>

<p>Holandská kohorta má preto iný účel než dokazovať, že rozdiel existuje. Odpovedá na otázky, ktoré randomizované skúšania nechali otvorené.</p>

<h2>Usporiadanie štúdie</h2>

<p>Išlo o retrospektívnu observačnú kohortovú štúdiu v dvoch univerzitných nemocniciach (Radboudumc Nijmegen, UMC Utrecht) a jednej nemocnici neuniverzitného typu (Rijnstate Arnhem). Zaraďovali sa dospelí s aspoň jednou pozitívnou hemokultúrou na <em>S. aureus</em> a aspoň jedným meraním sérového kreatinínu počas hospitalizácie. Obdobia zaraďovania sa medzi centrami líšili: Radboudumc január 2013 až júl 2024, UMC Utrecht január 2014 až december 2023, Rijnstate január 2009 až december 2018.</p>

<p>Vylučovacími kritériami boli kontaminácia hemokultúry, už zavedená chronická náhrada funkcie obličiek, meticilín-rezistentný <em>S. aureus</em> a odvolanie súhlasu s použitím klinických údajov. Pri opakovaných epizódach sa analyzovala len prvá. Kohorta sa napokon zúžila na pacientov, ktorí dostali cefazolín alebo flukloxacilín ako liečbu prvej voľby, a <strong>vylúčili sa pacienti, u ktorých AKI vzniklo ešte pred indexovou hemokultúrou</strong>. Z pôvodných 2114 identifikovaných pacientov tak zostalo 1408.</p>

<p>Zloženie kohorty: 1324 pacientov (94,0 %) dostalo flukloxacilín a 84 (6,0 %) cefazolín. Medián veku bol 67 rokov (medzikvartilové rozpätie 55 – 76), muži tvorili 62,6 %. Medián trvania antibiotickej liečby bol 13 dní (medzikvartilové rozpätie 7 – 17).</p>

<h3>Ako sa určovalo AKI</h3>

<p>AKI sa klasifikovalo podľa kritérií KDIGO zo všetkých meraní sérového kreatinínu po indexovej hemokultúre počas hospitalizácie. <strong>Kritérium diurézy sa nepoužilo</strong> — objem moču sa v týchto centrách rutinne nemeral. Zotavenie funkcie obličiek bolo definované ako návrat kreatinínu pod 1,5-násobok východiskovej hodnoty a súčasne najviac 26,5 µmol/l nad ňu do 30 dní od vzniku AKI.</p>

<p>Východisková koncentrácia kreatinínu sa určovala hierarchicky: najprv z mediánu ambulantných hodnôt 100 až 90 dní pred prijatím (156 pacientov), potom z mediánu hodnôt 365 až 7 dní pred prijatím (796 pacientov). Ak nebola k dispozícii žiadna hodnota spred hospitalizácie, východisková koncentrácia sa <strong>odhadla podľa veku a pohlavia</strong> (456 pacientov, teda takmer tretina kohorty). Distribúcia meraných a odhadnutých východiskových hodnôt sa medzi liečebnými skupinami nelíšila (P = 0,911).</p>

<h2>Výskyt akútneho poškodenia obličiek</h2>

<div class="table-responsive" role="region" aria-label="Výskyt a charakteristika akútneho poškodenia obličiek podľa úvodného antibiotika" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Celá kohorta (n = 1408)</th>
      <th scope="col">Flukloxacilín (n = 1324)</th>
      <th scope="col">Cefazolín (n = 84)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Prítomnosť AKI</th>
      <td>483 (34,3 %)</td>
      <td>466 (35,2 %)</td>
      <td>17 (20,2 %)</td>
    </tr>
    <tr>
      <th scope="row">AKI 1. štádia</th>
      <td>268 (55,5 %)</td>
      <td>257 (55,2 %)</td>
      <td>11 (64,7 %)</td>
    </tr>
    <tr>
      <th scope="row">AKI 2. štádia</th>
      <td>110 (22,8 %)</td>
      <td>108 (23,2 %)</td>
      <td>2 (11,8 %)</td>
    </tr>
    <tr>
      <th scope="row">AKI 3. štádia</th>
      <td>105 (21,7 %)</td>
      <td>101 (21,7 %)</td>
      <td>4 (23,5 %)</td>
    </tr>
    <tr>
      <th scope="row">Začatie náhrady funkcie obličiek</th>
      <td>23 (1,6 %)</td>
      <td>21 (1,6 %)</td>
      <td>2 (2,4 %)</td>
    </tr>
    <tr>
      <th scope="row">AKI vzniknuté do 7 dní</th>
      <td>388 (80,3 %)</td>
      <td>375 (80,5 %)</td>
      <td>13 (76,5 %)</td>
    </tr>
    <tr>
      <th scope="row">30-dňová mortalita</th>
      <td>201 (14,3 %)</td>
      <td>197 (14,8 %)</td>
      <td>5 (6,0 %)</td>
    </tr>
  </tbody>
</table>
<p><small>Percentá štádií AKI a načasovania sú počítané z počtu pacientov s AKI v príslušnom stĺpci.</small></p>
</div>

<p>Neupravený absolútny rozdiel vo výskyte AKI predstavoval 15 percentuálnych bodov (vlastný prepočet z publikovaných podielov). Neupravený pomer šancí pre cefazolín bol 0,47 (95 % interval spoľahlivosti 0,25 – 0,82).</p>

<p>Multivariabilný logistický regresný model sa upravoval o vek, pohlavie, východiskový kreatinín, Charlsonov index komorbidít, prijatie na jednotku intenzívnej starostlivosti, spôsob získania infekcie, nemocnicu, počet súbežných nefrotoxických liekov a — samostatne, pre ich dobre doložený nefrotoxický potenciál — o použitie vankomycínu a aminoglykozidov. Po tejto úprave zostal flukloxacilín spojený s vyššou šancou na AKI (upravený pomer šancí 2,37; 95 % interval spoľahlivosti 1,30 – 4,55).</p>

<p>Citlivostná analýza obmedzená na pacientov s <em>nameraným</em> východiskovým kreatinínom priniesla podobný výsledok (upravený pomer šancí 2,59; 95 % interval spoľahlivosti 1,29 – 5,63). Doplnková analýza zohľadňujúca rozdielnu dĺžku hospitalizácie ukázala mieru výskytu AKI 0,84 na 100 pacientodní pri cefazolíne a 1,66 pri flukloxacilíne; medzi centrami bola u pacientov na flukloxacilíne podobná (1,43 až 1,89). Asociácia teda nebola vysvetliteľná ani dlhším sledovaním, ani jedinou nemocnicou.</p>

<p>Pri interpretácii treba pamätať, že <strong>pomer šancí nie je totožný s relatívnym rizikom</strong>. Pri takom častom výsledku, akým bol výskyt AKI v tejto kohorte, pôsobí pomer šancí výraznejšie než pomer samotných rizík.</p>

<h2>Väčšina prípadov AKI vznikla veľmi skoro</h2>

<p>Medián času od indexovej hemokultúry do vzniku AKI bol v oboch liečebných skupinách 1,3 dňa (medzikvartilové rozpätie 0,4 – 4,7 dňa pri cefazolíne a 0,4 – 5,0 dňa pri flukloxacilíne). Až 80,3 % všetkých epizód AKI vzniklo počas prvých siedmich dní. U 48 pacientov s AKI (9,9 % všetkých prípadov) pripadol vrchol kreatinínu priamo na deň odberu indexovej hemokultúry.</p>

<p>Rozdelenie načasovania (bez AKI, skoré AKI do 7 dní, neskoré AKI po 7 dňoch) sa medzi liečebnými skupinami významne líšilo (P = 0,019). Skoré AKI vzniklo u 15,5 % pacientov na cefazolíne a u 28,3 % pacientov na flukloxacilíne, neskoré u 4,8 % a 6,9 %.</p>

<p>V multinomiálnej regresii bol flukloxacilín spojený s vyššou šancou na skoré AKI (pomer šancí 2,51; 95 % interval spoľahlivosti 1,28 – 4,93; P = 0,007). Pri neskorom AKI bol bodový odhad podobný, interval spoľahlivosti však zahŕňal jednotku a asociácia nebola štatisticky významná (pomer šancí 2,08; 95 % interval spoľahlivosti 0,63 – 6,86; P = 0,23). Neskorých prípadov bolo iba 95, z toho v cefazolínovej skupine štyri — analýza teda nemá silu rozdiel spoľahlivo potvrdiť ani vylúčiť.</p>

<h3>Čo skorý nástup znamená a čo neznamená</h3>

<p>Poškodenie obličiek, ktoré sa prejaví približne jeden deň po indexovej hemokultúre, nemôže byť dôsledkom niekoľkodňovej kumulatívnej expozície antibiotiku. Ponúka sa preto výklad, že ide prevažne o poškodenie zo sepsy, hemodynamickej nestability, hypovolémie a predchádzajúcich zásahov, nie o liekovú toxicitu.</p>

<p>Tento výklad má však tri obmedzenia. Po prvé, pacienti, ktorí spĺňali kritériá AKI už <em>pred</em> indexovou hemokultúrou, boli z kohorty vylúčení — zachytené epizódy teda vznikli až po nej. Po druhé, asociácia s flukloxacilínom pretrvala po úprave o východiskovú funkciu obličiek a o ukazovatele závažnosti ochorenia, čo naznačuje, že rozdiel medzi skupinami nevysvetľuje samotná ťažkosť sepsy. Po tretie, podľa konsenzu ADQI o sepsou podmienenom AKI nie je nefrotoxicita antibiotika samostatná entita oddelená od poškodenia zo sepsy; obe pôsobia súčasne a delia sa o rovnaké mechanizmy.</p>

<p>Autori sami upozorňujú, že veľmi skorý nástup <strong>nezodpovedá</strong> klasickému oneskorenému obrazu akútnej tubulointersticiálnej nefritídy spojenej s flukloxacilínom, ktorá sa typicky rozvíja sedem až desať dní po začatí liečby. To nesvedčí proti liekovému podielu, ale naznačuje, že sa uplatňujú aj iné alebo viaceré mechanizmy súčasne.</p>

<h2>Závažnosť AKI a zotavenie funkcie obličiek</h2>

<p>Medzi pacientmi, u ktorých AKI vzniklo, sa rozdelenie štádií medzi flukloxacilínom a cefazolínom významne nelíšilo (P = 0,599). Hlavný rozdiel sa teda týkal pravdepodobnosti vzniku AKI, nie jeho závažnosti po vzniku. Presnosť tohto porovnania však obmedzuje veľmi malý počet pacientov s AKI v cefazolínovej skupine — iba 17 osôb. Neprítomnosť štatisticky významného rozdielu preto nie je dôkazom rovnakej závažnosti.</p>

<p>Pravdepodobnosť zotavenia funkcie obličiek do 30 dní klesala so závažnosťou AKI, zatiaľ čo úmrtnosť pred zotavením rástla:</p>

<div class="table-responsive" role="region" aria-label="Zotavenie funkcie obličiek a úmrtnosť pred zotavením podľa štádia AKI" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štádium AKI</th>
      <th scope="col">Počet pacientov</th>
      <th scope="col">Zotavenie do 30 dní</th>
      <th scope="col">Úmrtie pred zotavením</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1. štádium</th>
      <td>268</td>
      <td>219 (81,7 %)</td>
      <td>28 (10,4 %)</td>
    </tr>
    <tr>
      <th scope="row">2. štádium</th>
      <td>110</td>
      <td>71 (64,5 %)</td>
      <td>23 (20,9 %)</td>
    </tr>
    <tr>
      <th scope="row">3. štádium</th>
      <td>105</td>
      <td>53 (50,5 %)</td>
      <td>29 (27,6 %)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Približne polovica pacientov s AKI 3. štádia teda do 30 dní nedosiahla zotavenie definované v štúdii. Údaje potvrdzujú klinický význam aj miernejších foriem AKI: nejde iba o prechodnú laboratórnu odchýlku. AKI pri závažnej infekcii môže predĺžiť hospitalizáciu, obmedziť antibiotickú liečbu a zvýšiť riziko chronickej choroby obličiek, ďalšej epizódy AKI aj úmrtia.</p>

<p>Sledovanie zotavenia bolo obmedzené na 30 dní od vzniku AKI alebo po posledné meranie kreatinínu — podľa toho, čo nastalo skôr. Z publikovaných údajov preto nemožno posúdiť dlhodobejší vývoj funkcie obličiek ani podiel pacientov s pretrvávajúcou dysfunkciou po tomto období.</p>

<h2>Nižšia dávka flukloxacilínu nebola spojená s nižším výskytom AKI</h2>

<p>Z 1324 pacientov liečených flukloxacilínom začínalo 718 (55,7 %) na vysokej dávke 12 g denne a 572 (44,3 %) na nižšej dávke 6 až 8 g denne; ďalších 34 pacientov (2,6 %) malo iný režim a do analýzy dávky sa nezahrnuli.</p>

<p>Rozdiely medzi dávkovými skupinami boli malé a nesystematické:</p>

<ul>
  <li>výskyt AKI 35,2 % (253/718) pri vysokej dávke verzus 35,7 % (204/572) pri nižšej;</li>
  <li>medián času do vzniku AKI 1,3 dňa verzus 1,5 dňa;</li>
  <li>skoré AKI u 28,7 % (206/718) verzus 28,0 % (160/572);</li>
  <li>po multivariabilnej úprave (s doplnkovým zohľadnením endokarditídy) upravený pomer šancí 0,85 v neprospech <em>nižšej</em> dávky, 95 % interval spoľahlivosti 0,62 – 1,17;</li>
  <li>krivky Kaplana a Meiera pre zložený ukazovateľ AKI alebo úmrtie do 30 dní boli takmer identické (log-rank P = 0,71).</li>
</ul>

<p>Zníženie dávky preto podľa autorov samo osebe pravdepodobne neodstraňuje renálne riziko spojené s flukloxacilínom.</p>

<p>Tento výsledok však nie je dôkazom, že expozícia liečivu nemá na nefrotoxicitu vplyv. Dávkovanie nebolo randomizované a jeho výber určovala predovšetkým <strong>zvyklosť pracoviska</strong>: vysokú úvodnú dávku dostávalo 86,1 % pacientov v Radboudumc, 49,6 % v UMC Utrecht a iba 27,6 % v Rijnstate. Hodnotila sa navyše iba úvodná denná dávka, nie kumulatívna expozícia, koncentrácia voľného liečiva ani úprava dávky podľa vývoja funkcie obličiek. Vzhľadom na veľkú medziindividuálnu variabilitu expozície flukloxacilínu môže toxicita súvisieť skôr so skutočnou dosiahnutou koncentráciou než s predpísanou dávkou.</p>

<h2>Možné mechanizmy poškodenia obličiek</h2>

<p>Štúdia neobsahovala renálne biopsie ani jednotnú etiologickú klasifikáciu AKI. Nemožno z nej preto určiť, aký podiel prípadov predstavoval ktorý mechanizmus. Do úvahy prichádzajú najmä nasledujúce.</p>

<h3>Akútna tubulointersticiálna nefritída</h3>

<p>Betalaktámové antibiotiká patria medzi klasické príčiny liekovej akútnej tubulointersticiálnej nefritídy. Klinicky sa môže prejaviť vzostupom kreatinínu, sterilnou leukocytúriou, hematúriou, proteinúriou alebo eozinofíliou. Triáda horúčky, exantému a eozinofílie je málo citlivá a v úplnej podobe u väčšiny pacientov chýba. Ako však uvádzajú autori, typický odstup sedem až desať dní od začiatku liečby sa s pozorovaným mediánom 1,3 dňa nezhoduje — tubulointersticiálna nefritída teda ťažko vysvetľuje väčšinu zachytených epizód.</p>

<h3>Akútne tubulárne poškodenie a sepsou podmienené AKI</h3>

<p>Pri sepse môže tubulárne poškodenie vzniknúť v dôsledku porúch mikrocirkulácie, zápalovej odpovede, mitochondriálnej dysfunkcie, hypoperfúzie a súbežného pôsobenia nefrotoxických látok. Antibiotická expozícia je pritom iba jednou zložkou multifaktoriálneho poškodenia. Konsenzus ADQI výslovne zahŕňa poškodenie z liečby sepsy do konceptu sepsou podmieneného AKI, takže „toxické“ a „septické“ AKI nie sú v klinickej praxi oddelené entity.</p>

<h3>Sodíková záťaž — často preceňovaný rozdiel</h3>

<p>Vysoké intravenózne dávky protistafylokokových penicilínov sa niekedy uvádzajú ako zdroj významnej sodíkovej záťaže. Presnejší pohľad je striedmejší: 1 g flukloxacilínu sodného obsahuje približne 2,26 mmol (52 mg) sodíka, 1 g cefazolínu sodného približne 2,1 mmol (48 mg). <strong>Na gram liečiva sú teda takmer rovnaké</strong> a rozdiel v dennej záťaži vzniká iba z rozdielnej dennej dávky — pri 12 g flukloxacilínu ide o približne 27 mmol (asi 620 mg) sodíka denne (vlastný prepočet z údajov v súhrne charakteristických vlastností lieku). Klinicky to môže byť dôležité pri srdcovom zlyhávaní, pokročilej chorobe obličiek alebo objemovom preťažení, štúdia však sodíkovú záťaž nehodnotila a nepreukázala, že by ňou bol rozdiel vo výskyte AKI sprostredkovaný.</p>

<h2>Prečo môže mať cefazolín priaznivejší renálny profil</h2>

<p>Cefazolín sa v observačných porovnaniach aj v oboch citovaných randomizovaných skúšaniach spája s nižším výskytom nefrotoxicity než protistafylokokové penicilíny. Má praktickejší dávkovací režim a pri zodpovedajúcom dávkovaní dosahuje dostatočné koncentrácie proti citlivým kmeňom <em>S. aureus</em>.</p>

<p>Historickou výhradou voči cefazolínu je takzvaný inokulový efekt — laboratórne zníženie účinnosti pri vysokej náloži baktérií, ktoré súvisí s produkciou určitých typov stafylokokovej betalaktamázy (najmä typu A kódovaného génom <em>blaZ</em>). Jeho klinický význam nie je vo všetkých populáciách a pri všetkých formách infekcie jednoznačný a randomizované skúšania ho pri celkovej účinnosti nepotvrdili ako prekážku. Opatrnosť je namieste najmä pri hlbokých ložiskách s vysokým inokulom a pri infekcii centrálneho nervového systému, kde je aj penetrácia cefazolínu obmedzená; práve pacienti s podozrením na infekciu centrálneho nervového systému boli zo skúšania CloCeBa vylúčení.</p>

<p>Predložená kohorta sa venovala výhradne AKI. Sama osebe nehovorí nič o porovnateľnej antibakteriálnej účinnosti oboch liečiv — to je otázka randomizovaných skúšaní, nie tejto práce.</p>

<h2>Hlavné metodologické obmedzenia</h2>

<h3>Retrospektívny dizajn a skreslenie indikáciou</h3>

<p>O liečbe nerozhodovala randomizácia. Výber antibiotika mohol súvisieť s nemocnicou, obdobím liečby, závažnosťou infekcie, vstupnou funkciou obličiek, alergiou, predchádzajúcou liečbou alebo lokálnymi protokolmi. Štatistická úprava reziduálne skreslenie znižuje, neodstraňuje ho však.</p>

<p>Zaujímavé je, že <strong>smer možného skreslenia nie je zrejmý</strong>. Pacienti na cefazolíne mali väčšiu chronickú komorbiditu (medián Charlsonovho indexu 4 verzus 3), ale nižšie ukazovatele akútnej závažnosti; 30-dňová mortalita bola v tejto skupine podstatne nižšia (6,0 % verzus 14,8 %). Chronicky chorejší, ale akútne menej ťažko chorí pacienti dostávali cefazolín, čo môže výsledok skresľovať oboma smermi naraz.</p>

<h3>Výrazne nevyvážené skupiny</h3>

<p>Cefazolín dostávalo iba 84 pacientov (6,0 % kohorty), flukloxacilín 1324. Malá porovnávacia skupina vedie k širokým intervalom spoľahlivosti a obmedzuje analýzu jednotlivých štádií AKI, podskupín aj menej častých komplikácií. Rozdelenie odráža bežnú holandskú prax prvej voľby, nie systematický výber pre potreby štúdie.</p>

<h3>Nesledovanie zmeny antibiotika</h3>

<p>Pacienti boli priradení podľa <em>prvého</em> podaného antibiotika a skupiny sa nepreklasifikovali podľa neskorších zmien liečby ani podľa jej trvania. Počas hospitalizácie pritom 212 pacientov (15,1 %) dostalo obe liečivá; 187 z nich (88,2 %) začínalo flukloxacilínom. Ide o nezanedbateľné riziko nesprávnej klasifikácie expozície, ktoré rozdiel medzi skupinami skôr zmenšuje než zväčšuje.</p>

<h3>Určenie východiskovej funkcie obličiek</h3>

<p>Takmer u tretiny pacientov (456 z 1408) sa východisková koncentrácia kreatinínu iba odhadovala podľa veku a pohlavia. Takýto odhad nemusí zachytiť chronickú chorobu obličiek ani nedávnu zmenu funkcie. Citlivostná analýza obmedzená na pacientov s nameranou hodnotou však priniesla podobný odhad efektu, čo robustnosť výsledku podporuje.</p>

<h3>Hodnotenie založené výlučne na kreatiníne</h3>

<p>Kritérium diurézy sa nepoužilo, pretože objem moču sa rutinne nemeral. Časť epizód AKI mohla preto zostať nezachytená. Kreatinín navyše počas akútneho ochorenia nie je v rovnovážnom stave a jeho koncentráciu ovplyvňujú objemové zmeny, svalová hmota a načasovanie odberov.</p>

<h3>Multifaktoriálny charakter AKI a heterogenita centier</h3>

<p>Pacienti s bakteriémiou súčasne dostávajú kontrastné látky, aminoglykozidy, vankomycín, diuretiká, inhibítory systému renín-angiotenzín, nesteroidové antiflogistiká a ďalšie potenciálne nefrotoxické lieky; význam majú aj hypotenzia, operácia, endokarditída a multiorgánová dysfunkcia. Model zohľadňoval počet nefrotoxických liekov aj vankomycín a aminoglykozidy samostatne, nie však ich dávku, trvanie a časovanie. Centrá sa navyše výrazne líšili zložením infekčných ložísk (osteoartikulárna infekcia 60,6 % v Rijnstate verzus 18,5 % v UMC Utrecht) a obdobia zaraďovania sa prekrývali len sčasti, takže sa mohli uplatniť aj zmeny praxe v čase.</p>

<h2>Klinické dôsledky</h2>

<p>V spojení s randomizovanými dôkazmi zo skúšaní SNAP a CloCeBa výsledky posilňujú postavenie cefazolínu ako plnohodnotnej voľby pri bakteriémii spôsobenej meticilín-citlivým <em>S. aureus</em>, najmä u pacientov so zvýšeným rizikom AKI. Voľba antibiotika však aj naďalej vyžaduje posúdenie miesta infekcie, citlivosti izolátu, alergií a celkového klinického kontextu; automatická zámena bez tohto posúdenia namieste nie je.</p>

<p>Pri liečbe flukloxacilínom je primerané:</p>

<ol>
  <li>stanoviť vstupnú koncentráciu kreatinínu a odhadnúť glomerulovú filtráciu ešte pred začatím liečby;</li>
  <li>kontrolovať kreatinín a elektrolyty často a od prvých dní, nie až po týždni;</li>
  <li>sledovať diurézu, hoci sa v kritériách štúdie nepoužila — v klinickej praxi zachytáva epizódy, ktoré samotný kreatinín minie;</li>
  <li>zhodnotiť objemový a hemodynamický stav a cielene ho korigovať;</li>
  <li>obmedziť alebo vysadiť ďalšie nefrotoxické lieky, ak je to možné;</li>
  <li>prispôsobiť dávkovanie funkcii obličiek a charakteru infekcie, s vedomím, že samotné zníženie dávky riziko AKI podľa tejto kohorty neodstraňuje;</li>
  <li>pri vzostupe kreatinínu znovu posúdiť infekciu, kontrolu zdroja, hemodynamiku, močový nález a všetky súbežné lieky a zvážiť aj tubulointersticiálnu nefritídu;</li>
  <li>po epizóde AKI zabezpečiť kontrolu funkcie obličiek aj po prepustení — najmä pri 2. a 3. štádiu, kde sa do 30 dní nezotavila tretina až polovica pacientov.</li>
</ol>

<p>Keďže väčšina prípadov vznikla počas prvého týždňa, monitorovanie musí byť intenzívne už od začiatku liečby, nie až pri jej predpokladanom kumulatívnom účinku.</p>

<h2>Čo štúdia preukázala a čo nie</h2>

<p>Štúdia preukázala:</p>

<ul>
  <li>vyšší výskyt AKI u pacientov liečených flukloxacilínom než cefazolínom, ktorý pretrval po multivariabilnej úprave aj po zohľadnení rozdielnej dĺžky hospitalizácie a bol konzistentný naprieč centrami;</li>
  <li>prevažne skorý vznik AKI, s mediánom 1,3 dňa a s 80,3 % epizód do siedmich dní;</li>
  <li>podobné rozdelenie štádií AKI medzi oboma liečbami (pri malej cefazolínovej skupine);</li>
  <li>klesajúcu pravdepodobnosť zotavenia a rastúcu úmrtnosť pred zotavením s narastajúcim štádiom AKI;</li>
  <li>neprítomnosť asociácie medzi úvodnou dennou dávkou flukloxacilínu a výskytom, načasovaním či závažnosťou AKI.</li>
</ul>

<p>Štúdia nepreukázala:</p>

<ul>
  <li>že flukloxacilín bol priamou príčinou všetkých zaznamenaných prípadov AKI — observačný dizajn to neumožňuje;</li>
  <li>konkrétny morfologický mechanizmus poškodenia (chýbali biopsie aj etiologická klasifikácia);</li>
  <li>že expozícia flukloxacilínu nesúvisí s nefrotoxicitou — hodnotila sa iba úvodná predpísaná dávka, nie skutočná expozícia;</li>
  <li>rovnakú klinickú účinnosť oboch antibiotík pri všetkých zdrojoch infekcie — to nebolo jej cieľom;</li>
  <li>dlhodobý vývoj funkcie obličiek nad rámec 30 dní od vzniku AKI.</li>
</ul>

<p>Naopak, tvrdenie, že randomizované porovnanie renálnej bezpečnosti cefazolínu a protistafylokokových penicilínov neexistuje, už neplatí — poskytli ho skúšania SNAP a CloCeBa.</p>

<h2>Záver</h2>

<p>V retrospektívnej kohorte 1408 pacientov s bakteriémiou spôsobenou <em>Staphylococcus aureus</em> bolo podávanie flukloxacilínu spojené s vyšším výskytom AKI než podávanie cefazolínu — 35,2 % verzus 20,2 %, upravený pomer šancí 2,37 (95 % interval spoľahlivosti 1,30 – 4,55). Výsledok je konzistentný s randomizovanými dôkazmi zo skúšaní SNAP a CloCeBa.</p>

<p>Najväčšiu klinickú pozornosť si zasluhujú tri zistenia: AKI vzniká veľmi skoro, pravdepodobnosť zotavenia klesá so štádiom a zníženie úvodnej dávky flukloxacilínu riziko neodstraňuje. Prakticky to znamená dôsledné a včasné monitorovanie funkcie obličiek od prvého dňa liečby, sledovanie pacienta aj po prepustení a zvažovanie cefazolínu u vhodných pacientov.</p>

<p>Pre observačný dizajn, výrazne nevyvážené liečebné skupiny a veľmi skorý vznik väčšiny prípadov AKI treba samotný odhad veľkosti efektu z tejto kohorty interpretovať ako významnú asociáciu, nie ako presné vyčíslenie priamej nefrotoxicity flukloxacilínu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť</a></li>
  <li><a href="article.php?slug=nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki">Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup</a></li>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradnú liečbu obličiek (KRT) pri akútnom poškodení obličiek (AKI)</a></li>
  <li><a href="article.php?slug=ambulantna-parenteralna-antimikrobialna-liecba-opat">Ambulantná parenterálna antimikrobiálna liečba (OPAT)</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Sinkeler FS, Kouijzer IJE, Jager NGL, ten Oever J, Leegwater E, Gisolf J, Reuling D, Spoel ZM, Hensgens MPM, Brüggemann RJ. Acute kidney injury in Staphylococcus aureus bacteraemia: a multicentre cohort study of incidence, timing, recovery and associations with antibiotic treatment. Journal of Antimicrobial Chemotherapy. 2026;81(10). doi: 10.1093/jac/dkag304. PMID 42683513. <a href="https://pubmed.ncbi.nlm.nih.gov/42683513/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13535221/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>Lee TC, Barina LA, Walls G, a spol.; SNAP Trial Group. Cefazolin for Methicillin-Susceptible Staphylococcus aureus Bacteremia. The New England Journal of Medicine. 2026;394(23):2329–2339. doi: 10.1056/NEJMoa2506905. PMID 42308484. ClinicalTrials.gov NCT05137119. <a href="https://pubmed.ncbi.nlm.nih.gov/42308484/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Burdet C, Saïdani N, Dupieux C, a spol. Cloxacillin versus cefazolin for meticillin-susceptible Staphylococcus aureus bacteraemia (CloCeBa): a prospective, open-label, multicentre, non-inferiority, randomised clinical trial. The Lancet. 2025;406(10517):2349–2359. doi: 10.1016/S0140-6736(25)01624-1. PMID 41115439. ClinicalTrials.gov NCT03248063. <a href="https://pubmed.ncbi.nlm.nih.gov/41115439/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Goodman AL, Easom N, Bielopolski D, a spol. A review of the randomized clinical trial results from the Staphylococcus aureus network adaptive platform (SNAP) meticillin-susceptible (MSSA) and penicillin-susceptible (PSSA) domains and CloCeBa. Journal of Antimicrobial Chemotherapy. 2026;81(8). doi: 10.1093/jac/dkag215. PMID 42396858. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13329659/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>.</em></small></li>
  <li><small><em>Zarbock A, Nadim MK, Pickkers P, a spol. Sepsis-associated acute kidney injury: consensus report of the 28th Acute Disease Quality Initiative workgroup. Nature Reviews Nephrology. 2023;19(6):401–417. doi: 10.1038/s41581-023-00683-3. PMID 36823168. <a href="https://pubmed.ncbi.nlm.nih.gov/36823168/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Perazella MA, Rosner MH. Drug-Induced Acute Kidney Injury. Clinical Journal of the American Society of Nephrology. 2022;17(8):1220–1233. doi: 10.2215/CJN.11290821. PMID 35273009. <a href="https://pubmed.ncbi.nlm.nih.gov/35273009/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Chong YP, Park SJ, Kim ES, a spol. Prevalence of blaZ gene types and the cefazolin inoculum effect among methicillin-susceptible Staphylococcus aureus blood isolates and their association with multilocus sequence types and clinical outcome. European Journal of Clinical Microbiology &amp; Infectious Diseases. 2015;34(2):349–355. doi: 10.1007/s10096-014-2241-5. PMID 25213722. <a href="https://pubmed.ncbi.nlm.nih.gov/25213722/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group. KDIGO Clinical Practice Guideline for Acute Kidney Injury. Kidney International Supplements. 2012;2(1):1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
  <li><small><em>Súhrn charakteristických vlastností lieku Flucloxacillin 1g powder for solution for injection/infusion vials. Electronic Medicines Compendium, revízia z 30. októbra 2023 — údaj o obsahu sodíka (2,26 mmol, teda 52 mg na injekčnú liekovku). <a href="https://www.medicines.org.uk/emc/product/8745/smpc" target="_blank" rel="noopener noreferrer">emc</a>.</em></small></li>
  <li><small><em>Informácia o lieku Cefazolin for Injection, USP. DailyMed, U.S. National Library of Medicine — údaj o obsahu sodíka (približne 2,1 mmol, teda 48 mg na gram cefazolínu sodného). <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=e8f40f72-3cf0-43dc-a797-fb98dd8af228" target="_blank" rel="noopener noreferrer">DailyMed</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_flukloxacilin-cefazolin-aki-stafylokokova-bakteriemia_article',
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
