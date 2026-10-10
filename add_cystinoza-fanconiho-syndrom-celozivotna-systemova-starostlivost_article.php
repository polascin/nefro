<?php

/**
 * add_cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost_article.php
 *
 * Odborný článok: Cystinóza: od Fanconiho syndrómu k celoživotnej systémovej starostlivosti
 * Spracovanie medzinárodného konsenzu a klinických odporúčaní pre multidisciplinárny manažment.
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
    'title'        => 'Cystinóza: od Fanconiho syndrómu k celoživotnej systémovej starostlivosti',
    'slug'         => 'cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nefropatická cystinóza je zriedkavé lyzozómové ochorenie a hlavná dedičná príčina Fanconiho syndrómu u detí. Včasná cielená liečba cysteamínom chráni funkciu obličiek a vyžaduje pokračovanie aj po transplantácii.',
    'content'      => <<<'HTML'
<p>Polyúria, neprospievanie, normoglykemická glukozúria a hypofosfatemická rachitída u dojčaťa či malého dieťaťa sú varovnými príznakmi renálneho Fanconiho syndrómu. Jednou z jeho najzávažnejších a najčastejších dedičných príčin je infantilná nefropatická cystinóza. Včasné rozpoznanie a okamžité začatie špecifickej liečby zásadne menia prirodzený priebeh ochorenia, hoci jeho genetickú príčinu zatiaľ neodstraňujú.</p>

<p>Cystinóza je autozómovo recesívne lyzozómové ochorenie charakterizované patologickým hromadením aminokyseliny cystínu vo vnútri buniek. Hoci obličky bývajú prvým klinicky nápadným miestom poškodenia, ochorenie zďaleka nepostihuje iba vylučovaciu sústavu. Postupne zasahuje oči, endokrinné žľazy, kostrové svaly a centrálny nervový systém. Komplexná starostlivosť sa preto nekončí dialýzou ani úspešnou transplantáciou obličky, ale sprevádza pacienta po celý život. [1,2]</p>

<figure>
  <picture>
    <source srcset="img/cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost.webp" type="image/webp">
    <img src="img/cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost.png" alt="Ilustračné schematické zobrazenie obličky s proximálnymi tubulmi a lyzozómovým ukladaním cystínu v bunkách pri nefropatickej cystinóze" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Nefropatická cystinóza spája včasné zlyhanie transportných funkcií proximálneho tubulu s celoživotným ukladaním cystínu v mimorenálnych tkanivách. Ilustračné schematické zobrazenie.</figcaption>
</figure>

<p>Napriek podobnému názvu sa cystinóza nesmie zamieňať s cystinúriou. Pri cystinóze je podstatou zlyhanie lyzozómového výstupu a vnútrobunková kumulácia cystínu v celom tele. Pri cystinúrii ide o izolovanú apikálnu poruchu transportérov v tubuloch a čreve, ktorá vedie k masívnemu vylučovaniu cystínu močom a tvorbe močových kameňov, bez systémového ukladania v tkanivách.</p>

<h2>Porucha cystinozínu a patogenéza ďaleko za hranicami kryštálov</h2>

<p>Príčinou cystinózy sú patogénne varianty v oboch alelách génu <em>CTNS</em> na chromozóme 17p13. Tento gén kóduje cystinozín, integrálny membránový proteín so siedmimi transmembránovými doménami, ktorý pôsobí ako protónovo viazaný transportér cystínu z lyzozómu do cytoplazmy. Pri jeho funkčnom výpadku sa cystín v lyzozómoch hromadí a pri prekročení rozpustnosti tvorí vnútrobunkové kryštály. V stredoeurópskej a severoeurópskej populácii tvorí najčastejšiu príčinu rozsiahla delécia približne 57 kilobáz, ktorá odstraňuje prvých desať exónov génu <em>CTNS</em> a zasahuje aj susedný gén <em>SHPK</em> (kódujúci sedoheptulokinázu). [1]</p>

<p>Z biochemického hľadiska je dôležité odlišovať cysteín a cystín. Cysteín je jednotlivá aminokyselina s voľnou tiolovou skupinou (-SH). Cystín vzniká oxidáciou dvoch molekúl cysteínu spojených disulfidovým mostíkom (-S-S-). Pri cystinóze je defekt prísne viazaný na membránový lyzozómový transport cystínu, nejde o následok nadmerného príjmu cystínu či cysteínu v potrave.</p>

<p>Výskum ukazuje, že samotné mechanické ukladanie kryštálov poškodenie buniek úplne nevysvetľuje. Strata funkcie cystinozínu vedie k poruchám vnútrobunkového vezikulárneho transportu, zlyhaniu autofágie, narušeniu signálnej dráhy mTORC1, oxidačnému stresu a skorej apoptóze. V bunkách proximálneho tubulu dochádza k strate a zníženej expresii multiligandových endocytických receptorov megalínu (LRP2) a kubilínu (CUBN), ktoré zabezpečujú spätné vychytávanie filtrovaných bielkovín. Progresívna dediferenciácia a atrofia buniek vedú k typickému histologickému obrazu stenčenia a skrátenia počiatočného segmentu proximálneho tubulu, označovanému ako deformita labutieho krku (swan-neck deformity). [1]</p>

<p>Preto je nesprávne opisovať Fanconiho syndróm iba ako mechanické poškodenie mitochondrií kryštálmi s náhlym vypnutím tvorby ATP. Energetický metabolizmus bunky je síce narušený, no ide o mnohovrstvový biologický proces zahŕňajúci poškodenie apikálnych kotransportérov, cytoskeletu a lyzozómovej integrity.</p>

<h2>Klinické spektrum: tri fenotypy jedného ochorenia</h2>

<p>Fenotypy cystinózy tvoria spojité spektrum závažnosti, ktoré zvyčajne určuje zvyšková aktivita cystinozínu. Tradičné klinické rozdelenie na tri formy pomáha pri orientácii, jednotlivé fenotypy sa však môžu v hraničných prípadoch prekrývať. [1]</p>

<div class="table-responsive" role="region" aria-label="Klinické formy cystinózy a ich charakteristika" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Forma</th>
      <th scope="col">Typický začiatok</th>
      <th scope="col">Charakteristika a hlavné prejavy</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Infantilná nefropatická cystinóza</th>
      <td>Prvý rok života (najčastejšie 4. až 6. mesiac)</td>
      <td>Predstavuje približne 95 % všetkých prípadov. Plne vyjadrený renálny Fanconiho syndróm, ťažké neprospievanie, hypofosfatemická rachitída, epizodické dehydratácie a neliečená rýchla progresia do zlyhania obličiek do konca prvého desaťročia života.</td>
    </tr>
    <tr>
      <th scope="row">Juvenilná (neskoro manifestujúca) forma</th>
      <td>Neskoré detstvo, dospievanie, zriedkavo dospelosť</td>
      <td>Miernejšia alebo inkompletná proximálna tubulopatia, často dominujúca asymptomatická proteinúria alebo nefrotický syndróm; podstatne pomalší pokles glomerulovej filtrácie.</td>
    </tr>
    <tr>
      <th scope="row">Očná (nenefropatická) cystinóza</th>
      <td>Dospelosť</td>
      <td>Izolované ukladanie kryštálov v rohovke bez tubulopatie a bez poklesu funkcie obličiek. Spôsobuje fotofóbiu, blefarospazmus a erózie rohovky.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Označenie očnej formy ako benígnej je nevhodné. Hoci obličky nie sú postihnuté, fotofóbia, blefarospazmus a recidivujúce erózie rohovky môžu výrazne obmedzovať kvalitu života a zrakové funkcie. Ani diagnóza zachytená v dospelosti automaticky neznamená očnú formu; môže ísť o nerozpoznanú juvenilnú formu so zlyhávaním obličiek, ktorá vyžaduje dôkladné nefrologické vyšetrenie. [1,2]</p>

<h2>Renálny Fanconiho syndróm: zachovaná filtrácia pri strate reabsorpcie</h2>

<p>Renálny Fanconiho syndróm je generalizovaná porucha reabsorpčnej funkcie proximálneho tubulu. Nejde o samostatnú nozologickú jednotku, ale o funkčný syndróm, ktorý môže sprevádzať viaceré dedičné aj získané stavy. U dojčiat a malých detí je práve infantilná cystinóza jeho najvýznamnejšou dedičnou príčinou. [1]</p>

<p>Za fyziologických okolností proximálny tubulus spätne vstrebáva viac než 65 % filtrovanej vody a sodíka, približne 80 až 90 % bikarbonátu a fosfátov a prakticky celú filtrovanú nálož glukózy a aminokyselín. Zabezpečuje aj receptorom sprostredkovanú endocytózu nízkomolekulových proteínov. Pri generalizovanom zlyhaní epitelu vzniká charakteristický klinický a laboratórny obraz:</p>

<ul>
  <li><strong>Glukozúria pri normoglykémii:</strong> strata funkcie kotransportéra SGLT2 vedie k úniku glukózy do moču napriek normálnej koncentrácii glukózy v krvnej plazme.</li>
  <li><strong>Generalizovaná aminoacidúria:</strong> močom unikajú prakticky všetky aminokyseliny, nielen dibázické aminokyseliny.</li>
  <li><strong>Renálne straty fosfátov:</strong> výpadok kotransportérov NaPi-IIa (SLC34A1) a NaPi-IIc (SLC34A3) spôsobuje závažnú hypofosfatémiu a poruchu mineralizácie kostného tkaniva.</li>
  <li><strong>Renálne straty bikarbonátu:</strong> znížená reabsorpčná kapacita vedie k proximálnej renálnej tubulárnej acidóze (RTA 2. typu) s hyperchloremickou metabolickou acidózou.</li>
  <li><strong>Tubulárna nízkomolekulová proteinúria:</strong> zlyhanie megalínu a kubilínu spôsobuje vylučovanie beta-2-mikroglobulínu, alfa-1-mikroglobulínu a proteínu viažuceho retinol (RBP).</li>
  <li><strong>Straty vody a elektrolytov:</strong> osmotická diuréza a znížené vstrebávanie sodíka vedú k polyúrii, kompenzačnej polydipsii, epizodickej hypovolémii, sekundárnemu hyperaldosteronizmu a hypokaliémii. [1,2]</li>
</ul>

<p>Úskalím je, že na začiatku ochorenia býva sérový kreatinín úplne normálny. Glomerulová filtrácia môže byť dokonca prechodne zvýšená v dôsledku tubuloglomerulárneho feedbacku a hyperfiltrácie. Normálny kreatinín a neprítomnosť oligúrie preto v žiadnom prípade nevylučujú závažnú tubulopatiu ohrozujúcu život dieťaťa. [1]</p>

<p>Terminologická poznámka: Renálny Fanconiho syndróm sa nesmie zamieňať s Fanconiho anémiou. Fanconiho anémia je odlišný dedičný syndróm s poruchou reparácie DNA, aplastickou anémiou, vrodenými anomáliami a vysokým rizikom hematologických malignít.</p>

<h2>Patogenéza rachitídy: prečo samotný bežný vitamín D nestačí</h2>

<p>Pri nefropatickej cystinóze je primárnou príčinou kostného poškodenia masívna strata anorganického fosfátu v proximálnom tubule. Bez dostatočného množstva fosfátových iónov nemôže prebiehať fyziologická kryštalizácia hydroxyapatitu v rastových chrupavkách a osteoide. U detí sa tento deficit prejaví hypofosfatemickou rachitídou, u dospelých osteomaláciou. [1,2]</p>

<p>K demineralizácii kostí významne prispieva aj chronická metabolická acidóza, ktorá aktivuje kostnú resorpciu vápnika ako systémový tlmivý mechanizmus. Mitochondriálne poškodenie buniek proximálneho tubulu navyše znižuje aktivitu enzýmu 1-alfa-hydroxylázy (CYP27B1). Tento enzým premieňa 25-hydroxyvitamín D (kalcidiol) na biologicky aktívny 1,25-dihydroxyvitamín D (kalcitriol). Miera tejto poruchy je však individuálna a u väčšiny pacientov nedochádza k úplnému vymiznutiu enzýmu. 1-alfa-hydroxyláza navyše neaktivuje priamo natívny vitamín D prijatý v potrave, ale jeho pečeňový metabolit.</p>

<p>Podávanie bežného natívneho vitamínu D (cholekalciferolu) preto deficit mineralizácie nevyrieši. Liečba si vyžaduje kombináciu perorálnych neutrálnych fosfátov, aktívnej formy vitamínu D (kalcitriol alebo alfakalcidol) a dôslednej alkalizácie roztokmi citrátu sodného a draselného. Nekontrolované zvyšovanie dávok vitamínu D bez kompenzácie fosfátových strát predstavuje riziko: vedie k hyperkalciúrii, nefrokalcinóze a ďalšiemu zrýchleniu zániku funkčných nefrónov. [1,2]</p>

<h2>Diagnostický algoritmus: leukocyty, genetika a štrbinová lampa</h2>

<p>Pri klinickom podozrení na cystinózu stojí diagnostika na troch nezávislých pilieroch, z ktorých každý má v postupe vymedzené miesto. [1]</p>

<ol>
  <li><strong>Stanovenie množstva cystínu v leukocytoch:</strong> predstavuje zlatý štandard biochemického potvrdenia a následného monitorovania účinnosti liečby. Vyšetrenie vyžaduje špecializované laboratórium a validovanú metodiku (HPLC alebo tandemovú hmotnostnú spektrometriu LC-MS/MS). U neliečených pacientov s infantilnou formou presahuje koncentrácia zvyčajne 2 až 5 nmol polovičného cystínu na miligram bunkového proteínu (norma u zdravých osôb je pod 0,2 nmol). Cieľom účinnej liečby cysteamínom je udržiavať hladinu pod 1,0 nmol polovičného cystínu na miligram proteínu. Výsledok závisí od typu buniek (zmiešané leukocyty verzus purifikované granulocyty) a od presného načasovania odberu krvi vo vzťahu k užitej dávke.</li>
  <li><strong>Molekulovogenetické vyšetrenie génu <em>CTNS</em>:</strong> identifikácia kauzálnych variantov v oboch alelách definitívne potvrdzuje diagnózu na DNA úrovni. Štandardný postup začína cieleným testovaním častej európskej delécie 57 kb, po ktorom nasleduje sekvenovanie všetkých kódujúcich exónov pri jej neprítomnosti alebo heterozygozite.</li>
  <li><strong>Oftalmologické vyšetrenie štrbinovou lampou:</strong> biomikroskopia predného segmentu oka odhaľuje charakteristické ihlicovité, vysoko reflektujúce kryštály cystínu v rohovkovej stróme.</li>
</ol>

<p>Kľúčové diagnostické varovanie: Kryštály v rohovke sa biomikroskopicky objavujú spravidla až medzi 12. a 18. mesiacom života. U dojčaťa vo veku 4 až 8 mesiacov s plne rozvinutým Fanconiho syndrómom býva nález na rohovke ešte negatívny. <strong>Negatívne vyšetrenie štrbinovou lampou v prvom roku života cystinózu nevylučuje</strong> a nesmie oddialiť genetické vyšetrenie ani stanovenie leukocytového cystínu. [1]</p>

<p>Pri potvrdení diagnózy je nevyhnutné genetické poradenstvo pre celú rodinu. Pri autozómovo recesívnej dedičnosti je riziko postihnutia ďalšieho dieťaťa u rodičov prenášačov 25 % pri každom tehotenstve. Vyšetrenie má zahŕňať aj narodených súrodencov pacienta.</p>

<h2>Cystinóza verzus cystinúria: zásadné rozdiely v patofyziológii a liečbe</h2>

<p>Zámena cystinózy a cystinúrie patrí k častým omylom v klinickej komunikácii. Hoci obe ochorenia súvisia s aminokyselinou cystínom, ich mechanizmus, fenotyp aj liečebná stratégia sú úplne odlišné.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie cystinózy a cystinúrie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Cystinóza</th>
      <th scope="col">Cystinúria</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Základná porucha</th>
      <td>Výpadok lyzozómového exportéra cystínu (cystinozínu)</td>
      <td>Výpadok apikálneho luminálneho transportéra pre dibázické aminokyseliny v proximálnom tubule a enterocytoch</td>
    </tr>
    <tr>
      <th scope="row">Kauzálne gény</th>
      <td><em>CTNS</em> (chromozóm 17p13)</td>
      <td><em>SLC3A1</em> (podjednotka rBAT) alebo <em>SLC7A9</em> (podjednotka b<sup>0,+</sup>AT)</td>
    </tr>
    <tr>
      <th scope="row">Miesto kumulácie cystínu</th>
      <td>Vnútro buniek, najmä lyzozómy všetkých tkanív a orgánov</td>
      <td>Moč v dutom systéme obličiek a močových cestách</td>
    </tr>
    <tr>
      <th scope="row">Typické renálne prejavy</th>
      <td>Renálny Fanconiho syndróm, rachitída, progresívna chronická choroba obličiek</td>
      <td>Recidivujúca cystínová litiáza, obštrukčné nefropatie, urosepsa</td>
    </tr>
    <tr>
      <th scope="row">Mimorenálne postihnutie</th>
      <td>Systémové: oči, štítna žľaza, pankreas, kostrové svaly, mozog, gonády</td>
      <td>Neprítomné; ochorenie je obmedzené na urotel a gastrointestinálnu absorpciu</td>
    </tr>
    <tr>
      <th scope="row">Charakteristický nález</th>
      <td>Zvýšený cystín v leukocytoch, ihlicovité rohovkové kryštály</td>
      <td>Hexagonálne kryštály v močovom sedimente, pozitívny kyanid-nitroprusidový test, analýza konkrementu</td>
    </tr>
    <tr>
      <th scope="row">Špecifická liečba</th>
      <td>Cysteamín (systémový perorálny a lokálny do oka)</td>
      <td>Vysoká hydratácia, alkalizácia moču (cieľové pH 7,0 až 7,5), tiolové chelátory (tiopronín)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Známa mnemotechnická pomôcka COLA (cystín, ornitín, lyzín, arginín) opisuje aminokyseliny vylučované pri cystinúrii. Pri Fanconiho syndróme v rámci cystinózy je aminoacidúria kompletná a generalizovaná, zahŕňa neutrálne, kyslé aj zásadité aminokyseliny. Nález hexagonálnych kryštálov v moči je typický pre cystinúriu, pri cystinóze sa v močovom sedimente nevyskytujú.</p>

<p>Ani cystinúria však nie je čisto urologickou banalitou. Opakované litiázy, infekcie a invazívne urologické zákroky môžu viesť k sekundárnej chronickej chorobe obličiek. Nejde však o primárne lyzozómové zlyhanie buniek.</p>

<h2>Cysteamín: mechanizmus účinku a klinické úskalia liečby</h2>

<p>Základným kameňom kauzálnej liečby cystinózy je aminotiol cysteamín (merkaptamín). Cysteamín voľne preniká cez plazmatickú a lyzozómovú membránu do lyzozómov. V ich kyslom prostredí reaguje s nahromadeným cystínom prostredníctvom tiol-disulfidovej výmeny. Výsledkom reakcie je jedna molekula voľného cysteínu a jedna molekula zmiešaného disulfidu cysteamín-cysteín. [1]</p>

<p>Tento zmiešaný disulfid má priestorové usporiadanie a náboj nápadne pripomínajúci aminokyselinu lyzín. Vďaka tejto štrukturálnej podobnosti dokáže lyzozóm opustiť cez nepoškodený transportér katiónových aminokyselín PQLC2. Cysteamín tak obchádza nefunkčný cystinozín a radikálne znižuje vnútrobunkovú záťaž cystínom.</p>

<p>Cysteamín je potrebné nasadiť ihneď po stanovení diagnózy. Dlhodobé sledovania jednoznačne potvrdili, že včasná a dostatočne dávkovaná liečba spomaľuje pokles glomerulovej filtrácie, odďaľuje nástup renálneho zlyhania o mnoho rokov a chráni mimorenálne orgány. <strong>Cysteamín však neopravuje gén CTNS a nedokáže zvrátiť už vzniknutý Fanconiho syndróm.</strong> Epitel proximálneho tubulu ostáva trvalo zmenený a vyžaduje pokračujúcu substitučnú liečbu. [1,2]</p>

<p>V klinickej praxi sú dostupné dve perorálne formy: liek s okamžitým uvoľňovaním (cysteamín bitartrát), ktorý vyžaduje prísne dávkovanie každých 6 hodín vrátane nočnej dávky, a enterosolventný liek s oneskoreným uvoľňovaním, podávaný každých 12 hodín. Režimy nemožno svojvoľne zamieňať bez kontroly leukocytového cystínu.</p>

<p>Dodržiavanie liečby cysteamínom patrí k najnáročnejším v celej medicíne. Liečivo vyvoláva výraznú gastrointestinálnu neznášanlivosť: stimuluje sekréciu žalúdočnej kyseliny a gastrínu, spôsobuje nauzeu, zvracanie, dysmotilitu a vredovú chorobu. Pacienti často vyžadujú súbežnú liečbu inhibítormi protónovej pumpy. Druhým závažným problémom je metabolit dimetylsulfid, ktorý spôsobuje intenzívny sírny zápach dychu a potu. U adolescentov vedie zápach k sociálnej izolácii a častému zlyhaniu adherencie. Zlyhanie spolupráce si vyžaduje trpezlivú edukáciu, psychologickú podporu a hľadanie tolerovateľného režimu, nie moralizovanie.</p>

<h2>Lokálna očná liečba: samostatný pilier starostlivosti</h2>

<p>Rohovka je bezcievne tkanivo, do ktorého perorálne podávaný cysteamín nepreniká v terapeutických koncentráciách. Systémová liečba preto vôbec nebráni ukladaniu cystínových kryštálov v rohovkovej stróme ani ich nerozpúšťa. [1,2]</p>

<p>Na odstránenie rohovkových kryštálov je nevyhnutná lokálna liečba vo forme očných kvapiek s cysteamínom. Pravidelná a dlhodobá aplikácia kvapiek vedie k postupnému rozpúšťaniu kryštálov, zmierňuje fotofóbiu, tlmí blefarospazmus a chráni epitel pred recidivujúcimi defektmi. Očné kvapky nenahrádzajú systémovú liečbu a perorálny cysteamín nenahrádza očné kvapky. Obe formy terapie musia prebiehať súbežne.</p>

<h2>Podporná liečba a dynamika substitúcie podľa funkcie obličiek</h2>

<p>Podporná substitučná liečba je pri Fanconiho syndróme rovnocenná kauzálnej terapii. U malého dieťaťa s masívnymi stratami môže dehydratácia alebo elektrolytový rozvrat spôsobiť obehový kolaps už počas bežného infektu. [1]</p>

<p>Podľa aktuálnych laboratórnych strát sa substituujú:</p>

<ul>
  <li><strong>Tekutiny a sodík:</strong> pacienti vyžadujú voľný prístup k vode a suplementáciu chloridu alebo citrátu sodného. Reštrikcia soli a tekutín, bežná pri iných nefropatiách, je pri aktívnom Fanconiho syndróme hrubou chybou, ktorá vedie k ťažkej hypovolémii a prerenálnemu zlyhaniu obličiek.</li>
  <li><strong>Draslík:</strong> renálne straty vyžadujú podávanie citrátu draselného, ktorý súčasne tlmí acidózu.</li>
  <li><strong>Fosfáty:</strong> neutrálne roztoky fosfátov rozdelené do viacerých denných dávok na podporu kostnej mineralizácie.</li>
  <li><strong>Bikarbonát:</strong> korekcia metabolickej acidózy zmesami citrátov, ktoré majú lepšiu gastrointestinálnu toleranciu než samotný hydrogenuhličitan sodný.</li>
  <li><strong>Nutričná podpora:</strong> deti s cystinózou trpia ťažkým nechutenstvom, gastroezofageálnym refluxom a poruchou prehĺtania. Na zabezpečenie rastu a podávanie liekov býva často indikované zavedenie nazo-gastrickej sondy alebo perkutánnej endoskopickej gastrostómie (PEG).</li>
</ul>

<p>Substitučná liečba musí dynamicky reagovať na vývoj ochorenia. S klesajúcou glomerulovou filtráciou a zánikom nefrónov v štádiách CKD G4 a G5 sa tubulárne straty prirodzene zmenšujú. Dávky fosfátov a draslíka, ktoré boli životne dôležité v dojčenskom veku, by v pokročilom zlyhaní obličiek viedli k fatálnej hyperkaliémii a ťažkej hyperfosfatémii. Dávkovanie sa preto musí nepretržite titrovať podľa aktuálnych laboratórnych parametrov.</p>

<h2>Transplantácia obličky a celoživotný multidisciplinárny manažment dospelých</h2>

<p>Neliečená infantilná cystinóza viedla k zlyhaniu obličiek okolo deviateho až desiateho roku života. Dnešné deti, diagnostikované v dojčenskom veku a dôsledne liečené cysteamínom, si dokážu zachovať vlastné obličky až do dospelosti. Keď však terminálne zlyhanie nastane, optimálnou metódou voľby je transplantácia obličky. [1,2]</p>

<p>Transplantovaný štep pochádza od darcu s funkčným génom <em>CTNS</em>. V transplantovanej obličke sa preto Fanconiho syndróm nikdy neobnoví. Hoci sa v interstíciu štepu môžu objaviť kryštály cystínu z migrujúcich makrofágov príjemcu, funkciu štepu to nepoškodzuje.</p>

<p><strong>Transplantácia obličky vylieči zlyhanie obličiek, ale nelieči cystinózu.</strong> Systémové ukladanie cystínu v mimorenálnych orgánoch pokračuje bez prerušenia. Ukončenie liečby cysteamínom po úspešnej transplantácii je fatálnou chybou, ktorá vedie k invalidizujúcim mimorenálnym komplikáciám v dospelosti. [2]</p>

<p>Odporúčania pre adolescentov a dospelých zdôrazňujú cielený skríning a prevenciu systémových komplikácií:</p>

<ul>
  <li><strong>Endokrinný systém:</strong> primárna hypotyreóza postihuje väčšinu pacientov a vyžaduje substitúciu levotyroxínom; poškodenie beta-buniek pankreasu vedie k inzulín-dependentnému diabetu mellitus; u mužov vzniká primárny hypogonadizmus s azoospermiou a neplodnosťou (plodnosť žien býva zachovaná).</li>
  <li><strong>Neuromuskulárny aparát:</strong> distálna vakuolárna myopatia sa prejavuje svalovou slabosťou rúk, poruchami chôdze a dysfágiou. Dysfágia zvyšuje riziko aspirácie a aspiračnej pneumónie.</li>
  <li><strong>Respiračný systém:</strong> slabosť dýchacích svalov vedie k reštrikčnej ventilačnej poruche a nočnej hypoventilácii.</li>
  <li><strong>Kostná choroba cystinózy:</strong> aj po transplantácii pretrvávajú kostné deformity, skolióza a riziko patologických fraktúr z dôvodu predchádzajúcej rachitídy a imunosupresie.</li>
  <li><strong>Centrálny nervový systém:</strong> v dospelosti sa môže rozvinúť encefalopatia, kognitívny deficit alebo hydrocefalus.</li>
</ul>

<p>Manažment dospelého pacienta si vyžaduje koordinovaný multidisciplinárny tím: dospelého nefrológa, oftalmológa, endokrinológa, neurológa, logopéda a psychológa. Štruktúrovaný prechod z pediatrickej do dospelej starostlivosti (tranzícia) je kľúčovým obdobím, v ktorom hrozí prerušenie liečby a strata kontroly nad ochorením. [2]</p>

<h2>Limity a praktické úskalia</h2>

<ul>
  <li><strong>Skorý normálny kreatinín:</strong> neznamená zdravé obličky. Rozhoduje vyšetrenie moču na glukózu, aminokyseliny, fosfáty a nízkomolekulové proteíny.</li>
  <li><strong>Falošný pocit bezpečia pri negatívnom očnom náleze:</strong> u detí do jedného roka sú rohovkové kryštály spravidla neprítomné. Ich absencia nesmie oddialiť genetiku ani odber leukocytového cystínu.</li>
  <li><strong>Riziko paušálnych diétnych obmedzení:</strong> obmedzenie soli a tekutín pri Fanconiho syndróme je kontraindikované a vedie k hypovolémii.</li>
  <li><strong>Chybné vysadenie cysteamínu po transplantácii:</strong> transplantácia chráni obličku, no nechráni svaly, mozog, štítnu žľazu a oči. Cysteamín musí pokračovať celoživotne.</li>
</ul>

<h2>Klinické posolstvo</h2>

<p>Infantilná nefropatická cystinóza je najčastejšou dedičnou príčinou renálneho Fanconiho syndrómu u malých detí. Včasné rozpoznanie proximálnej tubulopatie pred rozvojom zlyhania obličiek a okamžité začatie liečby cysteamínom zásadne menia prežívanie a kvalitu života pacienta.</p>

<p>Liečba cystinózy stojí na troch neoddeliteľných pilieroch: systémovom znižovaní vnútrobunkového cystínu cysteamínom, lokálnej očnej terapii kvapkami s cysteamínom a dynamickej substitúcii tubulárnych strát. Tento komplexný prístup sa nesmie prerušiť ani po úspešnej transplantácii obličky.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Francesco Emma, Galina Nesterova, Craig Langman, Antoine Labbé, Stephanie Cherqui, Paul Goodyer, Mirian C. Janssen, Marcella Greco, Rezan Topaloglu, Ewa Elenberg, Ranjan Dohil, Doris Trauner, Corinne Antignac, Pierre Cochat, Frederick Kaskel, Aude Servais, Elke Wühl, Patrick Niaudet, William Van’t Hoff, William Gahl, Elena Levtchenko. Nephropathic cystinosis: an international consensus document. <em>Nephrology Dialysis Transplantation.</em> 2014;29(Suppl 4):iv87–iv94. DOI: <a href="https://doi.org/10.1093/ndt/gfu090" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfu090</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25165189/" target="_blank" rel="noopener noreferrer">PubMed PMID 25165189</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4158338/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
<p><small><em>[2] Elena Levtchenko, Aude Servais, Sally A. Hulton, Gema Ariceta, Francesco Emma, David S. Game, Karin Lange, Risto Lapatto, Hong Liang, Rebecca Sberro-Soussan, Rezan Topaloglu, Anibh M. Das, Nicholas J. A. Webb, Christoph Wanner. Expert guidance on the multidisciplinary management of cystinosis in adolescent and adult patients. <em>Clinical Kidney Journal.</em> 2022;15(9):1675–1684. DOI: <a href="https://doi.org/10.1093/ckj/sfac099" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfac099</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36003666/" target="_blank" rel="noopener noreferrer">PubMed PMID 36003666</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9394719/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>

<h3>Súvisiace články</h3>
<p>K problematike tubulopatií, metabolických porúch a nefrologickej starostlivosti pozri aj:</p>
<ul>
  <li><a href="article.php?slug=cystinuria-genetika-diagnostika-komplexna-liecba">Cystínuria: klinický obraz, genetická diagnostika a komplexná liečba</a></li>
  <li><a href="article.php?slug=bartterov-syndrom-diagnostika-geneticke-formy-liecba">Bartterov syndróm: diagnostika, genetické formy a liečba</a></li>
  <li><a href="article.php?slug=vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika">Vitamín D v klinickej praxi: vyšetrovanie, suplementácia a riziká</a></li>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Transplantácia obličky: zaradenie do programu</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost_article',
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
