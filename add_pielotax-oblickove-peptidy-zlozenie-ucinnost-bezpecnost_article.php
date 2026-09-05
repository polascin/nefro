<?php
/**
 * Odborne a jazykovo revidovaný článok o výživovom doplnku Pielotax
 * a o takzvaných obličkových peptidových bioregulátoroch.
 *
 * Text je kritickou analýzou verejne dostupných podkladov (označenie u distribútora,
 * správa o klinickej štúdii zverejnená predajcom) doplnenou o platné odborné
 * odporúčania a regulačné predpisy. Nejde o spracovanie jednej publikácie,
 * preto sa autori citovaných prác nepridávajú do source_authors.php.
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
    'title'        => 'Pielotax a „obličkové peptidy“: analýza zloženia, účinnosti a bezpečnosti z pohľadu nefrológa',
    'slug'         => 'pielotax-oblickove-peptidy-zlozenie-ucinnost-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pielotax sa propaguje ako orgánovo špecifický peptidový bioregulátor obličiek. Rozbor označenia produktu a jedinej dostupnej klinickej správy ukazuje, prečo dostupné údaje nepodporujú tvrdenie o nefroprotektívnom účinku.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pielotax je výživový doplnok propagovaný ako orgánovo špecifický peptidový bioregulátor obličiek. Dostupné údaje však neposkytujú spoľahlivý dôkaz, že prípravok zvyšuje glomerulovú filtráciu, spomaľuje progresiu chronickej choroby obličiek (CKD) alebo znižuje riziko zlyhania obličiek. Jediná dohľadaná klinická správa má závažné metodologické nedostatky a nestačí na formulovanie liečebného odporúčania.</em></p>

<p>Otázky na doplnky tohto typu prichádzajú do nefrologickej ambulancie čoraz častejšie. Pacient s dnou, hyperurikémiou alebo poklesom glomerulovej filtrácie hľadá „niečo na obličky“ a nájde produkt, ktorý sľubuje obnovu obličkového tkaniva. Cieľom tohto rozboru nie je odsúdiť výživové doplnky ako kategóriu, ale ukázať konkrétne, kde sa v prípade Pielotaxu končia dostupné údaje a kde začína interpretácia predajcu.</p>

<h2>Čo deklaruje označenie produktu</h2>

<p>Podľa údajov českého distribútora obsahuje jedna kapsula:</p>

<div class="table-responsive" role="region" aria-label="Deklarované zloženie prípravku Pielotax" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Zložka</th>
        <th scope="col">Deklarovaná funkcia</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Mikrokryštalická celulóza</th>
        <td>Plnidlo</td>
      </tr>
      <tr>
        <th scope="row">Hydroxypropylmetylcelulóza</th>
        <td>Obal kapsuly</td>
      </tr>
      <tr>
        <th scope="row">Voda</th>
        <td>Zložka obalu kapsuly</td>
      </tr>
      <tr>
        <th scope="row">Karagénan</th>
        <td>Zahusťovadlo</td>
      </tr>
      <tr>
        <th scope="row">Octan draselný</th>
        <td>Regulátor kyslosti</td>
      </tr>
      <tr>
        <th scope="row">Peptidový komplex A-9 (kyselina glutámová, kyselina asparágová, alanín)</th>
        <td>Deklarovaná účinná zložka</td>
      </tr>
      <tr>
        <th scope="row">Vápenaté soli mastných kyselín</th>
        <td>Protihrudkujúca látka</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Dve kapsuly majú obsahovať 20 mg komplexu A-9, teda približne 10 mg v jednej kapsule. Odporúčané dávkovanie distribútora je 1 až 2 kapsuly 1- až 2-krát denne počas jedla, spravidla jeden mesiac. Ako výrobca sa uvádza spoločnosť VITA Ltd. so sídlom v Petrohrade, distribútorom pre český trh je Unlimit Beauty s.r.o.<sup>[1]</sup></p>

<h3>Dva nezhodné opisy toho istého produktu</h3>

<p>Predajný a propagačný materiál v anglickom jazyku opisuje Pielotax odlišne – ako zmes nízkomolekulových peptidov s molekulovou hmotnosťou do 5 000 Da, izolovaných z obličiek teliat vo veku do 12 mesiacov.<sup>[2]</sup> Tieto dva opisy nie sú rovnocenné a nemožno ich zamieňať. Zoznam troch aminokyselín v označení produktu neurčuje:</p>

<ul>
  <li>konkrétne aminokyselinové sekvencie prítomných peptidov,</li>
  <li>počet a koncentráciu jednotlivých peptidov,</li>
  <li>distribúciu molekulových hmotností,</li>
  <li>biologickú aktivitu jednotlivých frakcií,</li>
  <li>čistotu a reprodukovateľnosť medzi výrobnými šaržami.</li>
</ul>

<p>Bez týchto údajov nemožno komplex A-9 hodnotiť ako presne definovanú farmakologicky aktívnu látku. Ide o extrakt, ktorého zloženie nie je verejne charakterizované, nie o liečivo so známou štruktúrou a dávkou.</p>

<h2>Čo znamená „peptidový komplex z obličiek“</h2>

<p>Peptidy sú krátke reťazce aminokyselín. Ich biologický účinok závisí od presnej sekvencie, priestorovej štruktúry, dávky, stability, absorpcie a väzby na konkrétny receptor alebo inú cieľovú štruktúru. Samotný pôvod z obličkového tkaniva nepreukazuje selektívne pôsobenie na ľudskú obličku – tkanivo je len východiskovou surovinou extrakcie.</p>

<p>Orgánová selektivita by musela byť doložená minimálne:</p>

<ol>
  <li>chemickou charakterizáciou aktívnych peptidov,</li>
  <li>farmakokinetickými údajmi,</li>
  <li>dôkazom absorpcie neporušených peptidov,</li>
  <li>dôkazom distribúcie do obličiek,</li>
  <li>identifikáciou mechanizmu účinku,</li>
  <li>reprodukovateľnými klinickými výsledkami.</li>
</ol>

<p>Takéto údaje sa v preskúmaných verejných materiáloch nenachádzajú.</p>

<h3>Problém perorálnej biologickej dostupnosti</h3>

<p>Perorálne podané peptidy sú spravidla vystavené denaturácii v kyslom prostredí žalúdka, štiepeniu pepsínom a pankreatickými proteázami, ďalšej degradácii peptidázami kefkového lemu črevnej sliznice a napokon obmedzenému prechodu cez črevný epitel. Ide o dobre opísanú a v praxi mimoriadne náročnú bariéru.<sup>[3,4]</sup></p>

<p>Praktickú mieru tejto náročnosti dobre ilustruje perorálny semaglutid. Aby sa peptidové liečivo dalo vôbec podávať ústami, bolo potrebné vyvinúť špeciálnu tabletovú formuláciu s látkou podporujúcou vstrebávanie (SNAC); aj tak sa jeho biologická dostupnosť pohybuje rádovo okolo jedného percenta a dávka podávaná ústami je preto mnohonásobne vyššia než dávka podkožná.<sup>[3]</sup></p>

<p>Časť veľmi krátkych peptidov (di- a tripeptidov) sa síce v tenkom čreve vstrebáva prenášačovými systémami, no bez farmakokinetickej štúdie nemožno predpokladať, že neznáme peptidy komplexu A-9 prechádzajú do systémového obehu v biologicky účinnej koncentrácii. Už vôbec nemožno automaticky predpokladať ich selektívnu akumuláciu v obličkách.</p>

<p>Kyselina glutámová, kyselina asparágová a alanín sú navyše bežné aminokyseliny, ktoré sa zo stravy prijímajú v množstvách rádovo v gramoch denne – teda o dva až tri rády vyšších než deklarovaných 20 mg komplexu. Ich prítomnosť preto sama osebe nevysvetľuje deklarovaný orgánovo špecifický účinok.</p>

<h2>Pomocné látky</h2>

<h3>Mikrokryštalická celulóza</h3>

<p>Ide o bežne používané farmaceutické a potravinárske plnidlo. Prakticky sa nevstrebáva a pri obvyklých množstvách sa neočakáva nefrotoxický účinok. U citlivých osôb môže prispievať k miernym gastrointestinálnym ťažkostiam.</p>

<h3>Hydroxypropylmetylcelulóza</h3>

<p>Používa sa najmä na výrobu rastlinných kapsúl. Pri množstve prítomnom v obale kapsuly sa nepovažuje za klinicky významný zdroj systémovej toxicity.</p>

<h3>Karagénan</h3>

<p>Karagénan (E 407) je potravinárske zahusťovadlo. Diskusia o jeho bezpečnosti sa často komplikuje zamieňaním potravinárskeho karagénanu s degradovanými formami (poligenán) používanými v experimentálnych zápalových modeloch.</p>

<p>Európsky úrad pre bezpečnosť potravín (EFSA) pri prehodnotení v roku 2018 nepotvrdil nefrotoxicitu pri množstvách používaných ako prídavná látka. Skupinový prijateľný denný príjem 75 mg/kg telesnej hmotnosti/deň však označil za dočasný a upozornil na konkrétne neistoty: chýbajúcu validovanú analytickú metódu na stanovenie nízkomolekulovej frakcie pod 50 kDa, nedostatočnú charakterizáciu molekulovej hmotnosti vo väčšine toxikologických štúdií a na to, že pri modelovaní vernosti jednej značke môže expozícia v niektorých skupinách populácie prijateľný denný príjem prekročiť. Neistota sa teda týka charakterizácie látky a expozície, nie preukázaného poškodenia obličiek.<sup>[5]</sup></p>

<h3>Octan draselný</h3>

<p>Presné množstvo nie je uvedené. Ako technologická pomocná látka pravdepodobne predstavuje zanedbateľný prísun draslíka: aj keby kapsula obsahovala niekoľko desiatok miligramov octanu draselného, išlo by o desatiny milimolu draslíka oproti bežnému dennému príjmu v desiatkach milimolov. Bez kvantitatívneho údaja to však nemožno u pacienta s pokročilou CKD alebo hyperkaliémiou definitívne posúdiť – a práve nemožnosť overiť si to v označení produktu je samostatný nedostatok.</p>

<h3>Vápenaté soli mastných kyselín</h3>

<p>Najčastejšie ide o technologické protihrudkujúce látky, napríklad stearan vápenatý. Pri obvyklom použití nepredstavujú významnú záťaž vápnikom a nemožno od nich očakávať liečebný ani nefrotoxický účinok.</p>

<h2>Klinická štúdia uvádzaná na podporu Pielotaxu</h2>

<p>Dostupná správa opisuje štúdiu vykonanú od februára do augusta 2011 v zdravotníckom centre Petrohradského inštitútu bioregulácie a gerontológie. Zaradených bolo 42 pacientov s dnavou nefropatiou:</p>

<ul>
  <li>kontrolná skupina: 15 pacientov (9 mužov, 6 žien, vek 43 až 67 rokov), ktorí dostávali len bežnú liečbu,</li>
  <li>hlavná skupina: 27 pacientov (19 mužov, 8 žien, vek 42 až 68 rokov), ktorí popri bežnej liečbe užívali Pielotax,</li>
  <li>sledovanie trvalo 30 dní,</li>
  <li>dávkovanie bolo 1 až 2 kapsuly trikrát denne, 10 až 15 minút pred jedlom.<sup>[2]</sup></li>
</ul>

<p>Autori uvádzajú ústup klinických prejavov nefropatie u 78 % liečených pacientov a pokles koncentrácie močoviny, kyseliny močovej a reziduálneho (neproteínového) dusíka. Uvedené hodnoty sú nasledujúce.</p>

<div class="table-responsive" role="region" aria-label="Výsledky uvádzané v správe o klinickej štúdii Pielotaxu" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Kontrola pred</th>
        <th scope="col">Kontrola po</th>
        <th scope="col">Pielotax pred</th>
        <th scope="col">Pielotax po</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Reziduálny dusík (mmol/l)</th>
        <td>35,4 ± 0,8</td>
        <td>30,5 ± 0,6</td>
        <td>34,1 ± 0,7</td>
        <td>27,1 ± 0,4</td>
      </tr>
      <tr>
        <th scope="row">Močovina (mmol/l)</th>
        <td>14,7 ± 0,5</td>
        <td>11,8 ± 0,5</td>
        <td>13,8 ± 0,6</td>
        <td>9,2 ± 0,3</td>
      </tr>
      <tr>
        <th scope="row">Kyselina močová – muži (mmol/l)</th>
        <td>0,75 ± 0,03</td>
        <td>0,56 ± 0,01</td>
        <td>0,78 ± 0,04</td>
        <td>0,44 ± 0,02</td>
      </tr>
      <tr>
        <th scope="row">Kyselina močová – ženy (mmol/l)</th>
        <td>0,57 ± 0,01</td>
        <td>0,48 ± 0,02</td>
        <td>0,55 ± 0,02</td>
        <td>0,37 ± 0,03</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Správa označuje všetky zmeny oproti východiskovým hodnotám aj rozdiel medzi skupinami po liečbe za štatisticky významné na hladine <em>p</em> &lt; 0,05.<sup>[2]</sup></p>

<h3>Kontrolná skupina sa zlepšila tiež</h3>

<p>Najdôležitejšie zistenie pri čítaní tabuľky sa v propagačných textoch neuvádza: <strong>významne sa zlepšila aj kontrolná skupina</strong>, ktorá Pielotax neužívala. Močovina v nej klesla približne o 20 %, reziduálny dusík približne o 14 % a kyselina močová u mužov približne o 25 %. To ukazuje, že podstatnú časť pozorovanej zmeny vysvetľuje samotná bežná liečba, prípadne úprava životosprávy, hydratácia, regresia k priemeru alebo iné sprievodné vplyvy.</p>

<p>Zostávajúci rozdiel medzi skupinami by bolo možné pripísať Pielotaxu len vtedy, keby boli skupiny porovnateľné a bežná liečba v oboch rovnaká. Ani jedno nie je doložené.</p>

<h3>Hlavné metodologické problémy</h3>

<p>Správa uvádza, že pacienti boli do skupín rozdelení „randomizačnou metódou“, no spôsob randomizácie neopisuje. Chýba údaj o utajení prideľovania do skupín aj o zaslepení. Kontrolná skupina nedostávala placebo. Pri hodnotení mäkkých klinických prejavov, akými sú bolesti kĺbov, to umožňuje výberové, observačné aj interpretačné skreslenie.</p>

<p>Skupiny boli malé a nerovnako početné (15 verzus 27), pričom pomer 15 : 27 nezodpovedá bežnej randomizácii v pomere 1 : 1. Nie je uvedený výpočet potrebnej veľkosti súboru ani vopred určený primárny ukazovateľ účinnosti. Chýba registračné číslo štúdie, úplný protokol, opis vstupných a vylučovacích kritérií aj spôsob, akým bola dnavá nefropatia diagnostikovaná. Nejde o recenzovanú publikáciu, ale o dokument zverejnený predajcom; ako autor je uvedený V. Chavinson, teda predstaviteľ pracoviska, ktoré peptidové bioregulátory vyvíja.<sup>[2]</sup></p>

<p>Bežná liečba je opísaná len ako „lieky na všeobecné použitie“. Pri dne a hyperurikémii môže pritom hladinu kyseliny močovej zásadne ovplyvniť liečba znižujúca urikémiu, diuretiká, hydratácia, strava, alkohol aj zmena telesnej hmotnosti. Bez kontroly týchto faktorov nemožno pozorovaný pokles pripísať Pielotaxu.</p>

<h3>Nevhodné ukazovatele funkcie obličiek</h3>

<p>Správa neuvádza základné parametre potrebné na posúdenie ochorenia obličiek:</p>

<ul>
  <li>sérový kreatinín,</li>
  <li>odhadovanú glomerulovú filtráciu,</li>
  <li>albuminúriu alebo proteinúriu,</li>
  <li>močový sediment,</li>
  <li>krvný tlak,</li>
  <li>výskyt akútneho poškodenia obličiek,</li>
  <li>rýchlosť dlhodobej straty glomerulovej filtrácie.</li>
</ul>

<p>Močovina nie je špecifickým ukazovateľom renálnej funkcie. Ovplyvňuje ju príjem bielkovín, hydratácia, katabolizmus, gastrointestinálne krvácanie, glukokortikoidy aj funkcia pečene. Pokles močoviny počas 30 dní preto nie je dôkazom regenerácie obličkového parenchýmu.</p>

<p>Kyselina močová je predovšetkým metabolický a terapeutický ukazovateľ dny. Jej pokles môže byť priaznivý, ale nepreukazuje zlepšenie glomerulovej filtrácie ani štruktúry obličiek.</p>

<p>Použitie reziduálneho (neproteínového) dusíka ako hlavného parametra je zastarané a v modernej nefrológii sa nepoužíva. Uvedené čísla navyše nie sú vnútorne konzistentné: podľa nich by dusík obsiahnutý v močovine tvoril približne 70 až 85 % celkového reziduálneho dusíka, hoci klasicky sa uvádza približne polovica. Buď ide o inú definíciu či jednotku parametra, alebo o nepresnosť v prepise; v každom prípade to znemožňuje spoľahlivú interpretáciu.</p>

<h3>Ani liečená skupina nedosiahla cieľovú urikémiu</h3>

<p>Odborné odporúčania na liečbu dny sú v tomto bode jednoznačné. Americká reumatologická spoločnosť (ACR) v odporúčaní z roku 2020 silne odporúča stratégiu liečby k cieľu s cieľovou koncentráciou urátu pod 6 mg/dl, čo zodpovedá približne 0,36 mmol/l.<sup>[6]</sup> Európska liga proti reumatizmu (EULAR) uvádza rovnaký cieľ pod 360 µmol/l a pri ťažkej dne pod 300 µmol/l.<sup>[7]</sup></p>

<p>Po 30 dňoch dosiahli muži v liečenej skupine 0,44 mmol/l (približne 7,4 mg/dl) a ženy 0,37 mmol/l (približne 6,2 mg/dl). <strong>Ani jedna skupina teda cieľovú hodnotu nedosiahla.</strong> Aj keby bol pokles reálny a spôsobil ho prípravok, výsledok by z hľadiska platných odporúčaní znamenal nedostatočne liečenú dnu.</p>

<h3>Štatistické nedostatky</h3>

<p>Uvádzané hodnoty <em>p</em> &lt; 0,05 nestačia na posúdenie kvality výsledku. Nie je opísané:</p>

<ul>
  <li>aký štatistický test sa použil,</li>
  <li>či boli overené predpoklady testu,</li>
  <li>či sa korigovalo viacnásobné porovnávanie (hodnotených bolo súčasne viacero ukazovateľov a osobitne obe pohlavia),</li>
  <li>či analýza prebehla podľa pôvodného zámeru liečby (intention-to-treat),</li>
  <li>ako sa postupovalo pri chýbajúcich údajoch a predčasných ukončeniach,</li>
  <li>aké boli intervaly spoľahlivosti a veľkosť účinku.</li>
</ul>

<p>Štatistická významnosť navyše nie je synonymom klinického prínosu.</p>

<h3>Nezrovnalosti v texte</h3>

<p>V mechanistickej časti správy sa objavuje veta o tom, že „peptidy Cerluten regulujú metabolické procesy v bunkách obličkového tkaniva“, hoci predmetom dokumentu je Pielotax a Cerluten sa bežne propaguje ako peptidový prípravok pre nervové tkanivo. Môže ísť o chybu pri kopírovaní textu, no znižuje to dôveryhodnosť dokumentu a vyvoláva otázku, ktoré údaje sa skutočne vzťahujú na skúmaný produkt.</p>

<p>Nezrovnalosť je aj v dávkovaní. Referenčná denná dávka podľa označenia produktu je 20 mg komplexu A-9 (dve kapsuly) a maximum vyplývajúce z pokynov distribútora je 40 mg (štyri kapsuly) počas jedla. V štúdii sa podávali až dve kapsuly trikrát denne, teda až 60 mg denne, a to 10 až 15 minút <em>pred</em> jedlom. Skúšaná dávka bola teda až trojnásobkom referenčnej dennej dávky a líšilo sa aj časovanie voči jedlu. Výsledky preto nemožno bez ďalších údajov prenášať na aktuálne odporúčané užívanie.</p>

<h2>Širší kontext: peptidové bioregulátory</h2>

<p>Pielotax nie je izolovaný produkt, ale súčasť rozsiahlej skupiny takzvaných peptidových bioregulátorov (v angloamerickej literatúre označovaných aj ako „Khavinson peptides“) a s nimi príbuzných tkanivových extraktov. Ich spoločnou črtou je tvrdenie, že krátke peptidy izolované z konkrétneho zvieracieho orgánu selektívne regulujú funkciu toho istého orgánu u človeka.</p>

<p>Pri hodnotení tejto skupiny sú podstatné tri okolnosti. Po prvé, značná časť literatúry pochádza z jedného výskumného pracoviska a je publikovaná v ruskojazyčných časopisoch s obmedzeným medzinárodným dosahom.<sup>[8]</sup> Po druhé, nezávislá replikácia kľúčových klinických zistení inými pracoviskami je zriedkavá – pritom práve nezávislé potvrdenie je mechanizmus, ktorým sa veda opravuje. Po tretie, mechanistické hypotézy o regulácii génovej expresie krátkymi peptidmi sa opierajú prevažne o bunkové a zvieracie modely a neriešia otázku, či sa perorálne podaný peptid vôbec dostane k cieľovému tkanivu.</p>

<p>To neznamená, že výskum krátkych peptidov je bezcenný. Znamená to, že „existuje výskum“ a „je preukázaný klinický účinok u ľudí“ sú dve rôzne úrovne dôkazu a Pielotax spĺňa prvú, nie druhú.</p>

<h2>Je tvrdenie o účinnosti oprávnené?</h2>

<p>Nie. Na základe dostupných podkladov nemožno spoľahlivo tvrdiť, že Pielotax:</p>

<ul>
  <li>obnovuje poškodené nefróny,</li>
  <li>regeneruje obličkový parenchým,</li>
  <li>zvyšuje glomerulovú filtráciu,</li>
  <li>lieči dnavú nefropatiu,</li>
  <li>znižuje albuminúriu,</li>
  <li>spomaľuje chronickú chorobu obličiek,</li>
  <li>chráni pred dialýzou,</li>
  <li>nahrádza liečbu znižujúcu urikémiu alebo nefroprotektívnu liečbu.</li>
</ul>

<p>Tvrdenie o „normalizácii metabolizmu obličkového tkaniva“ nie je v predloženej štúdii priamo merané. Ide o interpretáciu autorov, nie o preukázaný klinický výsledok.</p>

<p>Súčasné odborné odporúčania KDIGO pre chronickú chorobu obličiek Pielotax ani orgánové peptidové extrakty neuvádzajú medzi postupmi s preukázaným nefroprotektívnym účinkom.<sup>[9]</sup> Rovnako nie sú súčasťou štandardných odporúčaní na liečbu dny.<sup>[6,7]</sup></p>

<h2>Bezpečnosť</h2>

<p>V malej 30-dňovej štúdii neboli hlásené nežiaduce účinky a správa uvádza, že prípravok „nespôsobuje nežiaduce účinky, komplikácie ani liekovú závislosť“.<sup>[2]</sup> Takéto všeobecné tvrdenie však z tohto súboru vyvodiť nemožno – ide o typickú zámenu chýbajúceho dôkazu za dôkaz neprítomnosti rizika.</p>

<p>Súbor 42 pacientov sledovaný jeden mesiac nie je dostatočný na zistenie:</p>

<ul>
  <li>zriedkavých nežiaducich reakcií,</li>
  <li>alergických reakcií na živočíšne bielkoviny,</li>
  <li>dôsledkov dlhodobého užívania,</li>
  <li>rizika u pacientov s ťažkou poruchou funkcie obličiek,</li>
  <li>interakcií s liekmi,</li>
  <li>účinkov v gravidite, počas dojčenia a u detí.</li>
</ul>

<p>Pri prípravku živočíšneho pôvodu sú dôležité aj informácie o veterinárnej kontrole suroviny, metóde extrakcie, mikrobiologickej čistote, vírusovej bezpečnosti, kontrole reziduálnych bielkovín a reprodukovateľnosti jednotlivých šarží. Obličky hovädzieho dobytka nepatria medzi špecifikovaný rizikový materiál podľa európskej legislatívy o prenosných spongiformných encefalopatiách,<sup>[10]</sup> to však nenahrádza doklad o pôvode a veterinárnej kontrole konkrétnej suroviny. Takéto údaje neboli v preskúmaných verejných podkladoch dostupné.</p>

<h2>Regulačný význam označenia „výživový doplnok“</h2>

<p>Výživový doplnok nie je liek. Uvedenie na trh preto samo osebe nepotvrdzuje klinickú účinnosť pri ochorení obličiek. Na výživové doplnky sa v Európskej únii vzťahujú potravinové predpisy, najmä smernica o výživových doplnkoch<sup>[11]</sup> a nariadenie o výživových a zdravotných tvrdeniach.<sup>[12]</sup> Nariadenie o poskytovaní informácií o potravinách spotrebiteľom navyše výslovne zakazuje pripisovať potravine vlastnosti predchádzať ochoreniu, liečiť ho alebo vyliečiť.<sup>[13]</sup></p>

<p>Samostatnou otázkou je, či peptidový extrakt z teľacích obličiek nepatrí medzi nové potraviny podľa nariadenia o nových potravinách, ktoré pred uvedením na trh vyžadujú povolenie na úrovni Európskej únie.<sup>[14]</sup> Bez dokladu o významnej spotrebe v EÚ pred 15. májom 1997 alebo o vydanom povolení nie je regulačné postavenie takéhoto extraktu zrejmé.</p>

<p>V Slovenskej republike podlieha uvedenie výživového doplnku na trh oznamovacej povinnosti voči Úradu verejného zdravotníctva SR, ktorý produkt zapisuje do registra.<sup>[15]</sup> Ide o evidenčný úkon, nie o posúdenie účinnosti.</p>

<p>Tvrdenia naznačujúce liečbu, prevenciu alebo vyliečenie konkrétneho ochorenia preto nemožno považovať za preukázané len preto, že sa nachádzajú na stránke predajcu. Pred kúpou je vhodné overiť:</p>

<ul>
  <li>presného výrobcu a dovozcu,</li>
  <li>oznámenie alebo registráciu produktu v príslušnom štátnom registri,</li>
  <li>číslo šarže a dátum minimálnej trvanlivosti,</li>
  <li>úplné označenie v slovenskom jazyku,</li>
  <li>certifikát analýzy konkrétnej šarže,</li>
  <li>kvantitatívne zloženie a pôvod živočíšnej suroviny.</li>
</ul>

<h2>Nefrologické stanovisko</h2>

<p>Pielotax nemožno na základe dostupných dôkazov odporučiť ako liečbu chronickej choroby obličiek, dnavého poškodenia obličiek ani hyperurikémie. Ak ho pacient napriek tomu užíva ako doplnok, nemal by ním nahrádzať diagnostiku ani liečbu s preukázaným účinkom a mal by o jeho užívaní informovať ošetrujúceho lekára.</p>

<p>Pri chronickej chorobe obličiek majú podľa individuálnej indikácie podstatne lepšiu dôkazovú základňu:<sup>[9]</sup></p>

<ul>
  <li>kontrola krvného tlaku,</li>
  <li>blokáda renín-angiotenzínového systému,</li>
  <li>inhibítory SGLT2,</li>
  <li>liečba diabetu a kardiovaskulárneho rizika,</li>
  <li>obmedzenie nefrotoxických liekov,</li>
  <li>primeraná liečba albuminúrie,</li>
  <li>cielená liečba základného ochorenia.</li>
</ul>

<p>Pri dne je základom dosiahnutie cieľovej koncentrácie kyseliny močovej validovanou liečbou znižujúcou urikémiu, nie použitie neštandardizovaného obličkového extraktu.<sup>[6,7]</sup></p>

<h2>Záver</h2>

<p>Pielotax obsahuje deklarovaný komplex A-9 živočíšneho pôvodu, jeho presné peptidové zloženie však nie je verejne dostatočne charakterizované. Nie sú doložené farmakokinetické údaje, perorálna biologická dostupnosť ani selektívne pôsobenie na obličky.</p>

<p>Jediná dostupná klinická správa zahŕňa 42 pacientov, krátke 30-dňové sledovanie, neopísanú randomizáciu, kontrolu bez placeba a neadekvátne ukazovatele funkcie obličiek. Významné zlepšenie sa v nej dosiahlo aj v kontrolnej skupine, cieľovú urikémiu nedosiahla ani jedna skupina a dávkovanie sa líšilo od dnes odporúčaného. Správa neposkytuje dôkaz o zlepšení glomerulovej filtrácie ani o spomalení progresie ochorenia obličiek.</p>

<p>Z pohľadu medicíny založenej na dôkazoch preto Pielotax zostáva výživovým doplnkom s nepreukázanou klinickou nefroprotektívnou účinnosťou.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=alopurinol-ckd-asymptomaticka-hyperurikemia-dokazy">Alopurinol pri chronickej chorobe obličiek: prečo randomizované štúdie a retrospektívne dáta hovoria opačne</a>.</li>
  <li><a href="article.php?slug=cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao">Doplnky s cholínom a L-karnitínom pri diabetickej nefropatii a úloha TMAO</a>.</li>
  <li><a href="article.php?slug=vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika">Vitamín D v klinickej praxi: koho vyšetrovať, komu ho podávať a kedy môže liečba škodiť</a>.</li>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinovaná liečba chronickej choroby obličiek: štyri piliere, dôkazy a otvorené otázky</a>.</li>
  <li><a href="article.php?slug=strava-a-zdravie-creva-myty-influencerov-ckd">Strava a zdravie čreva podľa influencerov: kde vznikajú najčastejšie chyby</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Peptidové produkty.</strong> <em>Pielotax – zloženie, dávkovanie a údaje distribútora.</em> Výrobca VITA Ltd. (Petrohrad), distribútor pre ČR Unlimit Beauty s.r.o. <a href="https://www.peptidoveprodukty.cz/pielotax/" target="_blank" rel="noopener noreferrer nofollow">peptidoveprodukty.cz</a>.</li>
  <li><strong>Khavinson V.</strong> <em>Report of the results of clinical study of the biologically active peptide bioregulator Pielotax.</em> Dokument zverejnený predajcom; nejde o recenzovanú publikáciu. <a href="https://www.antiaging-systems.com/articles/clinical-study-of-the-biologically-active-peptide-bioregulator-pielotax/" target="_blank" rel="noopener noreferrer nofollow">antiaging-systems.com</a>.</li>
  <li><strong>Drucker DJ.</strong> <em>Advances in oral peptide therapeutics.</em> Nat Rev Drug Discov. 2020;19(4):277–289. doi: 10.1038/s41573-019-0053-0. PMID 31848464. <a href="https://pubmed.ncbi.nlm.nih.gov/31848464/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Xu Y, Shrestha N, Préat V, Beloqui A.</strong> <em>Overcoming the intestinal barrier: a look into targeting approaches for improved oral drug delivery systems.</em> J Control Release. 2020;322:486–508. doi: 10.1016/j.jconrel.2020.04.006. PMID 32276004. <a href="https://pubmed.ncbi.nlm.nih.gov/32276004/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>EFSA Panel on Food Additives and Nutrient Sources added to Food (ANS).</strong> <em>Re-evaluation of carrageenan (E 407) and processed Eucheuma seaweed (E 407a) as food additives.</em> EFSA Journal. 2018;16(4):5238. doi: 10.2903/j.efsa.2018.5238. <a href="https://doi.org/10.2903/j.efsa.2018.5238" target="_blank" rel="noopener noreferrer">EFSA Journal</a>.</li>
  <li><strong>FitzGerald JD, Dalbeth N, Mikuls T, et al.</strong> <em>2020 American College of Rheumatology Guideline for the Management of Gout.</em> Arthritis Care Res (Hoboken). 2020;72(6):744–760. doi: 10.1002/acr.24180. PMID 32391934. <a href="https://pubmed.ncbi.nlm.nih.gov/32391934/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Richette P, Doherty M, Pascual E, et al.</strong> <em>2016 updated EULAR evidence-based recommendations for the management of gout.</em> Ann Rheum Dis. 2017;76(1):29–42. doi: 10.1136/annrheumdis-2016-209707. PMID 27457514. <a href="https://pubmed.ncbi.nlm.nih.gov/27457514/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Khavinson VK, Linkova NS, Diatlova AS, et al.</strong> <em>Short peptides: regulation of skin function during aging</em> (v ruskom jazyku). Adv Gerontol. 2020;33(1):46–54. PMID 32362083. <a href="https://pubmed.ncbi.nlm.nih.gov/32362083/" target="_blank" rel="noopener noreferrer">PubMed</a>; <strong>Khavinson VKh, Kuznik BI, Tarnovskaia SI, Lin'kova NS.</strong> <em>Peptides and CCL11 and HMGB1 as molecular markers of aging</em> (v ruskom jazyku). Adv Gerontol. 2014;27(3):399–406. PMID 25826983. <a href="https://pubmed.ncbi.nlm.nih.gov/25826983/" target="_blank" rel="noopener noreferrer">PubMed</a>. Uvedené ako príklady prevažujúceho zdroja literatúry o krátkych peptidových bioregulátoroch.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4S):S117–S314. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>Európsky parlament a Rada.</strong> <em>Nariadenie (ES) č. 999/2001, ktorým sa stanovujú pravidlá prevencie, kontroly a eradikácie niektorých prenosných spongiformných encefalopatií</em> (príloha V – špecifikovaný rizikový materiál). <a href="https://eur-lex.europa.eu/legal-content/SK/TXT/?uri=CELEX:32001R0999" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</li>
  <li><strong>Európsky parlament a Rada.</strong> <em>Smernica 2002/46/ES o aproximácii právnych predpisov členských štátov týkajúcich sa výživových doplnkov.</em> <a href="https://eur-lex.europa.eu/legal-content/SK/TXT/?uri=CELEX:32002L0046" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</li>
  <li><strong>Európsky parlament a Rada.</strong> <em>Nariadenie (ES) č. 1924/2006 o výživových a zdravotných tvrdeniach o potravinách.</em> <a href="https://eur-lex.europa.eu/legal-content/SK/TXT/?uri=CELEX:32006R1924" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</li>
  <li><strong>Európsky parlament a Rada.</strong> <em>Nariadenie (EÚ) č. 1169/2011 o poskytovaní informácií o potravinách spotrebiteľom</em> (článok 7 ods. 3). <a href="https://eur-lex.europa.eu/legal-content/SK/TXT/?uri=CELEX:32011R1169" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</li>
  <li><strong>Európsky parlament a Rada.</strong> <em>Nariadenie (EÚ) 2015/2283 o nových potravinách.</em> <a href="https://eur-lex.europa.eu/legal-content/SK/TXT/?uri=CELEX:32015R2283" target="_blank" rel="noopener noreferrer">EUR-Lex</a>.</li>
  <li><strong>Úrad verejného zdravotníctva Slovenskej republiky.</strong> <em>Výživové (potravinové) doplnky – oznamovacia povinnosť a register.</em> <a href="https://www.uvzsr.sk/web/uvz/vyzivove-potravinove-doplnky1" target="_blank" rel="noopener noreferrer">uvzsr.sk</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Analýza vychádza z verejne dostupných podkladov k septembru 2026 – z označenia produktu u distribútora a zo správy o klinickej štúdii zverejnenej predajcom. Nejde o výsledok nezávislého laboratórneho rozboru produktu ani o posúdenie konkrétnej šarže. Ak by výrobca zverejnil chemickú charakterizáciu komplexu A-9, farmakokinetické údaje a recenzovanú randomizovanú štúdiu s tvrdými renálnymi ukazovateľmi, hodnotenie by bolo potrebné prehodnotiť. Článok nenahrádza individuálne odborné vyšetrenie ani liečbu.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_pielotax-oblickove-peptidy-zlozenie-ucinnost-bezpecnost_article',
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
      <link rel="stylesheet" href="index.css?v=20260509-1&amp;cb=<?= filemtime('index.css') ?>">
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
