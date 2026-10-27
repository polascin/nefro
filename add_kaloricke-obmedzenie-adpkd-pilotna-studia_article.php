<?php

/**
 * add_kaloricke-obmedzenie-adpkd-pilotna-studia_article.php
 * Kalorické obmedzenie pri ADPKD: Warner 2016, Nowak 2018, Hopp 2022, protokol Nowak 2026.
 *
 * enqueue_newsletter je zámerne false: avíza sa pri tomto článku neposielajú.
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
    'title'        => 'Kalorické obmedzenie pri ADPKD: predklinické mechanizmy a pilotná štúdia úbytku hmotnosti',
    'slug'         => 'kaloricke-obmedzenie-adpkd-pilotna-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kalorické obmedzenie u 28 dospelých s ADPKD a nadváhou znížilo hmotnosť za rok o 9,1 %. Lepšie sa znášalo než prerušované hladovanie. Rast obličiek súvisel s úbytkom hmotnosti. eGFR sa nezmenila a kontrola chýbala.',
    'content'      => <<<'HTML'
<figure><a href="img/kaloricke-obmedzenie-adpkd-pilotna-studia.webp" rel="noopener noreferrer" target="_blank"><img src="img/kaloricke-obmedzenie-adpkd-pilotna-studia.webp" alt="Priesvitná polycystická oblička v tme, cysty žiaria jantárovým svetlom" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani obraz z magnetickej rezonancie. Jantárové svetlo v cystách je obraz otázky, či obmedzenie energetického príjmu mení rast polycystickej obličky.</figcaption></figure>

<p class="article-dek"><em>Dvanásťmesačná pilotná štúdia u 28 dospelých s autozómovo dominantnou polycystickou chorobou obličiek a s nadváhou alebo obezitou porovnala denné kalorické obmedzenie s prerušovaným hladovaním. Hmotnosť klesla v oboch ramenách, výraznejšie pri dennom obmedzení, a denné obmedzenie bolo lepšie znášané. Ročná zmena objemu obličiek bola v oboch ramenách podobná a s úbytkom hmotnosti súvisela. Kontrolná skupina v štúdii nebola a priemerná odhadovaná glomerulová filtrácia sa nezmenila.</em></p>

<p>Pri autozómovo dominantnej polycystickej chorobe obličiek (ADPKD) sa čoraz častejšie kladie otázka, či sa progresia dá spomaliť aj úpravou energetického príjmu. Denné kalorické obmedzenie je z týchto postupov najďalej preskúmané. Nie je to postup pre každého. Nižšie je oddelené, čo ukázali myši, čo ukázala pilotná štúdia u ľudí s nadváhou a čo ešte ukázané nie je.<sup>1</sup></p>

<h2>Nadváha sprevádza rýchlejšiu progresiu</h2>

<p>Kristen L. Nowaková a spolupracovníci hodnotili 441 dospelých bez diabetu s ADPKD a s odhadovanou glomerulovou filtráciou (eGFR) nad 60 ml/min/1,73 m<sup>2</sup> zo štúdie HALT-PKD A. Index telesnej hmotnosti prepočítali po odčítaní hmotnosti obličiek a pečene, aby veľké orgány samy kategóriu hmotnosti neposunuli. Priemerný vek bol 37 ± 8 rokov a priemerná ročná zmena celkového objemu obličiek 7,4 ± 5,1 %. Objem rástol rýchlejšie s vyššou kategóriou hmotnosti: 6,1 ± 4,7 % za rok pri normálnej hmotnosti (n = 192), 7,9 ± 4,8 % pri nadváhe (n = 168) a 9,4 ± 6,2 % pri obezite (n = 81; <em>P</em> &lt; 0,001). V plne upravenom modeli pripadalo na každých 5 kg/m<sup>2</sup> o 0,79 percentuálneho bodu vyššia ročná zmena objemu (95 % interval spoľahlivosti od 0,18 do 1,39). Pomer šancí na ročný rast objemu najmenej 7 % oproti rastu pod 5 % bol pri nadváhe 2,02 (interval od 1,15 do 3,56) a pri obezite 3,76 (interval od 1,81 do 7,80). Obezita súvisela aj s väčším poklesom eGFR oproti normálnej hmotnosti, plne upravený koeficient sklonu bol −0,08 (interval od −0,15 do −0,02). Abstrakt jednotku tohto sklonu neuvádza.<sup>2</sup></p>

<p>Je to súvislosť, nie dôkaz, že chudnutie progresiu spomalí. Index telesnej hmotnosti nerozozná tuk od svalu a do modelu vstúpila len vstupná hodnota. Práve táto súvislosť však bola dôvod, prečo ďalšia štúdia skúšala úbytok hmotnosti, a nie hladovanie bez neho.<sup>1,2</sup></p>

<h2>Čo obmedzenie potravy urobilo u myší</h2>

<p>Gina Warnerová a spolupracovníci ukázali v myšacích modeloch ADPKD, že mierne až stredné obmedzenie potravy, od 10 % do 40 %, zmenšilo plochu cýst, obličkovú fibrózu, zápal a známky poškodenia. Účinok závisel od miery obmedzenia. Autori ho vysvetľujú útlmom dráhy cieľa rapamycínu u cicavcov (mTOR) a aktiváciou dráhy kinázy B1 pečene a AMP-aktivovanej proteínkinázy (LKB1-AMPK).<sup>3</sup></p>

<p>Katharina Hoppová a spolupracovníci ten istý smer skúšali v ortológnom modeli <em>Pkd1</em> RC/RC u myší s normálnou hmotnosťou, od tretieho do šiesteho mesiaca života. Skupiny mali od 7 do 12 zvierat. Týždenný energetický deficit mal byť približne 34 %, rovnako ako neskôr u ľudí. Denne obmedzené myši zjedli 65,47 % voľného príjmu a ako jediné schudli. Pri prerušovanom hladovaní klesol príjem v pôstnych dňoch na 19,62 % voľného príjmu, v ostatných dňoch však myši zjedli 160,62 % a hmotnosť pribrali podobne ako myši kŕmené voľne. Časovo obmedzené jedenie, osem hodín denne, znížilo príjem len na 92,13 % a úbytok hmotnosti neprinieslo. Menší cystický objem, nižší cystický index a nižší podiel hmotnosti obličky k telesnej hmotnosti boli len pri dennom obmedzení. Tento podiel bol 1,90 ± 0,15 % oproti 2,87 ± 0,32 % pri voľnom kŕmení. Dusík močoviny v krvi sa medzi režimami nelíšil. V obličke stúpol pomer fosforylovanej AMPK k celkovej AMPK. Pomer fosforylovanej bielkoviny S6 k celkovej S6, ktorý by zodpovedal útlmu mTOR z práce Warnerovej, nižší nebol.<sup>1,3</sup></p>

<p>Denné obmedzenie malo u týchto myší aj cenu. Beztuková hmota klesla o 3,36 ± 1,06 %, kým pri voľnom kŕmení stúpla o 2,90 ± 1,16 % (priemer ± štandardná chyba priemeru, <em>P</em> &lt; 0,001). Stehenná kosť bola kratšia, 14,62 ± 0,22 mm oproti 15,21 ± 0,35 mm. Ide o rastúce, neobézne myši, nie o dospelých s nadváhou. Autori preto píšu, že úbytok hmotnosti môže mať zmysel nad ideálnou hmotnosťou a že pri už primeranej hmotnosti je namieste opatrnosť. V diskusii zároveň pripomínajú, že v inom, rýchlo postupujúcom myšom modeli bolo spomalenie opísané aj bez zmeny hmotnosti. V modeli, ktorý použili oni, sa účinok viazal na denné obmedzenie a na úbytok hmotnosti.<sup>1</sup></p>

<h2>Pilot u dospelých s nadváhou alebo obezitou</h2>

<p>Tá istá skupina urobila prvú štúdiu redukcie hmotnosti zmenou správania u dospelých s ADPKD. Register štúdie je NCT02903511. Vstupovali ľudia vo veku od 18 do 65 rokov s ADPKD, s indexom telesnej hmotnosti od 25 do 45 kg/m<sup>2</sup>, s eGFR najmenej 30 ml/min/1,73 m<sup>2</sup> podľa rovnice CKD-EPI, bez diabetu, so stabilnou hmotnosťou a bez iného programu chudnutia. Z 122 predbežne posúdených ľudí bolo 28 náhodne priradených: 15 k dennému kalorickému obmedzeniu a 13 k prerušovanému hladovaniu. Najčastejší dôvod nezaradenia bola nízka eGFR, 38 ľudí, potom nízky index telesnej hmotnosti, 22 ľudí. Tolvaptan vylučovacou podmienkou nebol. Nikto ho na začiatku ani počas štúdie neužíval.<sup>1</sup></p>

<p>Obe ramená mali rovnaké zastúpenie živín, 55 % sacharidov, 15 % bielkovín a 30 % tukov, a rovnaký cieľový týždenný energetický deficit približne 34 %. Pri dennom obmedzení bol priemerný denný cieľ 1 773 ± 253 kcal, odvodený od nameraného pokojového výdaja vynásobeného faktorom 1,5. Pri prerušovanom hladovaní boli tri dni v týždni s priemerným cieľom 532 ± 73 kcal. Neboli to dni s nulovým príjmom. Výživu viedli výživoví terapeuti v skupinových sedeniach a časť kontaktov bola dištančná.<sup>1</sup></p>

<p>Za tri mesiace klesla hmotnosť v priemere o 7,1 ± 4,2 % pri dennom obmedzení a o 5,5 ± 3,3 % pri prerušovanom hladovaní. Za 12 mesiacov denné obmedzenie pokračovalo na −9,1 ± 6,0 % a prerušované hladovanie ostalo na −4,9 ± 5,6 % (<em>P</em> &lt; 0,05). Samohodnotené dodržiavanie na škále do 10, kde 10 znamená úplné dodržanie, bolo na konci 7,5 ± 0,67 oproti 4,5 ± 0,84. Kvalita života, nálada a pohyb sa v žiadnom ramene významne nezmenili a nikto nesplnil skríningové kritériá záchvatovitého prejedania. Triacylglyceroly, celkový cholesterol a LDL-cholesterol klesli len pri dennom obmedzení. Priemerná eGFR sa nezmenila v žiadnom ramene. V ramene s denným obmedzením percentuálna zmena hmotnosti nepriamo súvisela so zmenou eGFR (<em>r</em> = −0,63, <em>P</em> = 0,04). Štúdia mnohé prieskumné testy neupravila na mnohonásobné porovnávanie, takže aj táto súvislosť môže byť náhodná. Za rok sa podľa priemernej eGFR funkcia obličiek neochránila.<sup>1</sup></p>

<p>Pred tretím mesiacom skončili dvaja ľudia z denného obmedzenia a jeden z prerušovaného hladovania z dôvodov, ktoré so znášanlivosťou nesúviseli: sťahovanie, kolízia termínov a iné životné udalosti vrátane pandémie. Jeden človek z prerušovaného hladovania skončil pred tretím mesiacom pre znášanlivosť. Mal hlad, poruchu sústredenia, kognitívne ťažkosti a závrat, cieľ príjmu v pôstny deň sa mu podľa protokolu zvýšil a napokon odišiel. Ďalší dvaja z denného obmedzenia skončili pred dvanástym mesiacom, v analýze tretieho mesiaca však ostali. Do magnetickej rezonancie na konci štúdie nevstúpil jeden človek pre kontraindikáciu a jeden sa pre pandémiu nedostavil osobne. Tabuľka objemu má preto 10 a 10 ľudí.<sup>1</sup></p>

<div class="table-responsive" role="region" aria-label="Hmotnosť, rast obličiek a vybrané nežiaduce udalosti v pilotnej štúdii pri ADPKD" tabindex="0">
  <table>
    <caption>Denné kalorické obmedzenie a prerušované hladovanie za 12 mesiacov. Hmotnosť a nežiaduce udalosti sú zo všetkých priradených ľudí, objem obličiek len z tých, ktorí mali magnetickú rezonanciu.</caption>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Denné kalorické obmedzenie</th>
        <th scope="col">Prerušované hladovanie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Úbytok hmotnosti za 12 mesiacov</th>
        <td>−9,1 ± 6,0 % (n = 15)</td>
        <td>−4,9 ± 5,6 % (n = 13)</td>
      </tr>
      <tr>
        <th scope="row">Ročná zmena objemu obličiek korigovaného na telesnú výšku</th>
        <td>1,5 ± 3,4 % (n = 10)</td>
        <td>1,7 ± 6,1 % (n = 10)</td>
      </tr>
      <tr>
        <th scope="row">Hlad</th>
        <td>5 z 15 (33 %)</td>
        <td>11 z 13 (85 %)</td>
      </tr>
      <tr>
        <th scope="row">Únava</th>
        <td>1 z 15 (7 %)</td>
        <td>8 z 13 (62 %)</td>
      </tr>
      <tr>
        <th scope="row">Neznášanlivosť chladu</th>
        <td>1 z 15 (7 %)</td>
        <td>7 z 13 (54 %)</td>
      </tr>
      <tr>
        <th scope="row">Podráždenosť</th>
        <td>1 z 15 (7 %)</td>
        <td>6 z 13 (46 %)</td>
      </tr>
      <tr>
        <th scope="row">Nespavosť</th>
        <td>2 z 15 (13 %)</td>
        <td>7 z 13 (54 %)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Hlad, únava, neznášanlivosť chladu, podráždenosť a nespavosť boli pri prerušovanom hladovaní častejšie (<em>P</em> &lt; 0,05, Fisherov presný test). Rozdiel v úbytku hmotnosti za 12 mesiacov bol tiež <em>P</em> &lt; 0,05. Ročná zmena objemu obličiek sa medzi ramenami takto nelíšila. Hodnoty s ± sú priemer a smerodajná odchýlka.<sup>1</sup></p>

<h2>Rast obličiek súvisel s úbytkom hmotnosti</h2>

<p>Ročná zmena celkového objemu obličiek korigovaného na telesnú výšku (htTKV) bola prieskumný ukazovateľ. Vopred sa mala porovnať s historickými súbormi, nie so súčasnou kontrolnou skupinou, lebo tá v štúdii nebola. Výsledok bol 1,5 ± 3,4 % pri dennom obmedzení a 1,7 ± 6,1 % pri prerušovanom hladovaní. Autori ho označujú za nízky oproti historickým súborom. Čísla tých súborov v hlavnom texte nie sú a vstupné htTKV ramien nebolo vyrovnané: medián 921 ml/m pri dennom obmedzení a 1 288 ml/m pri prerušovanom hladovaní.<sup>1</sup></p>

<p>Ročná zmena htTKV tesne súvisela s percentuálnou zmenou hmotnosti (<em>r</em> = 0,68, <em>P</em> = 0,001) a so zmenou indexu telesnej hmotnosti (<em>r</em> = 0,63, <em>P</em> &lt; 0,01). Ľudia, ktorí za rok schudli aspoň o 5 %, mali ročnú zmenu htTKV −1,0 ± 3,3 %. Tí, ktorí tento úbytok nedosiahli, mali 5,5 ± 4,1 % (<em>P</em> &lt; 0,01). To nie je výsledok náhodného priradenia. Je to rozdelenie podľa toho, kto skutočne schudol. So zmenou htTKV súvisel aj úbytok vnútrobrušného tuku (<em>r</em> = 0,49) a celkového brušného tuku (<em>r</em> = 0,46), nie však podkožného tuku. V spojenom súbore klesla plocha vnútrobrušného tuku zo 103,8 ± 39,6 na 90,4 ± 40,7 cm<sup>2</sup>/m<sup>2</sup>.<sup>1</sup></p>

<p>Pomalší rast celého objemu neznamená, že cysty ustúpili. Výškovo korigovaný objem cýst bol na konci v oboch ramenách aj v spojenom súbore vyšší než na začiatku. V spojenom súbore stúpol medián z 891 na 925 ml/m a cystický index z 0,69 ± 0,24 na 0,73 ± 0,24. Záver o „zastavení rastu“ platí v priemere len pre htTKV u ľudí s úbytkom aspoň 5 % hmotnosti, a aj tam je smerodajná odchýlka 3,3 percentuálneho bodu. Časť z nich teda ďalej rástla.<sup>1</sup></p>

<p>Plocha brušného svalstva na jednej snímke magnetickej rezonancie klesla pri dennom obmedzení z 87,5 ± 14,4 na 81,4 ± 16,6 cm<sup>2</sup>/m<sup>2</sup>. Pri prerušovanom hladovaní rozdiel oproti začiatku významný nebol. Nie je to celotelová svalová hmota ani diagnóza sarkopénie. Je to dôvod sledovať sval pozorne, keď človek chudne.<sup>1</sup></p>

<p>V mononukleároch periférnej krvi sa pomer fosforylovanej AMPK k celkovej AMPK medzi ramenami líšil a naprieč súborom súvisel s ročnou zmenou htTKV (<em>r</em> = −0,53). Pomer pre S6 kinázu sa nelíšil. Je to súlad s myšou AMPK, nie dôkaz, že u človeka ide o ten istý obličkový mechanizmus. Tkanivo obličky od účastníkov nebolo.<sup>1</sup></p>

<h2>Väčšia štúdia ešte nemá výsledky</h2>

<p>Kontrolované porovnanie denného kalorického obmedzenia s bežným výživovým odporúčaním pri ADPKD už beží. Výsledky z neho tento článok nemá. Kristen L. Nowaková a spolupracovníci zverejnili 17. októbra 2026 protokol štúdie NCT04907799. Je to jednocentrová štúdia fázy 2, zaslepená pre skúšajúceho. Účastník vie, ktorý režim drží, lebo ide o jedlo. Náhodne priradila 120 dospelých, 84 žien a 36 mužov, na 24 mesiacov buď k dennému obmedzeniu so zmenou správania, alebo k bežnému výživovému odporúčaniu pri ADPKD. Primárny ukazovateľ je zmena htTKV na magnetickej rezonancii za 24 mesiacov. Na začiatku mal súbor priemerný vek 45 ± 11 rokov, priemernú eGFR 68 ± 26 ml/min/1,73 m<sup>2</sup> a medián htTKV 986 ml/m, s medzikvartilovým rozpätím od 700 do 1 398. Tolvaptan užívalo 29 ľudí, 24 %. Abstrakt uvádza, že sledovanie kohorty sa má uzavrieť v júli 2027. Dovtedy niet výsledku, ktorý by súvislosť z pilotnej štúdie potvrdil alebo vyvrátil.<sup>4</sup></p>

<h2>Čo z toho zatiaľ plynie pre prax</h2>

<p>Univerzálna schéma kalorického obmedzenia pre každého s ADPKD z týchto prác nevyplýva. Študovaní dospelí mali nadváhu alebo obezitu, eGFR najmenej 30 ml/min/1,73 m<sup>2</sup>, vek od 18 do 65 rokov a nemali diabetes. O pokročilejšej chorobe obličiek, o vyššom veku a o normálnej hmotnosti pilotná štúdia nehovorí. Pri normálnej hmotnosti ostáva varovanie z myší: úbytok beztukovej hmoty a kratšia stehenná kosť pri dlhšom dennom obmedzení. Na človeka s ideálnou hmotnosťou sa to priamo neprenáša. Nie je to ani dôvod taký režim pokladať za neškodný.<sup>1</sup></p>

<p>Ak sa u človeka s ADPKD a s nadváhou úbytok hmotnosti zvažuje, tieto údaje hovoria skôr pre denné obmedzenie než pre tri dni veľmi nízkeho príjmu v týždni. Hovoria aj skôr pre sledovanie než pre prevzatie čísla 1 773 kcal ako predpisu. Ten cieľ vyšiel z nameraného pokojového výdaja konkrétnych ľudí a z pravidelnej skupinovej opory. Bez nej štúdia nebežala a autori sami píšu, že bežná prax môže vyzerať inak. Rozumné je dohodnúť tempo s nefrológom a s dietológom alebo výživovým terapeutom a sledovať hlad, únavu, spánok, hmotnosť aj sval, aby schudnutie nešlo na úkor svalovej hmoty. eGFR za jeden rok v tejto štúdii úspech režimu neukázala. Súvislosť s úbytkom hmotnosti sa ukázala na objeme obličiek, a to len ako prieskumný ukazovateľ.<sup>1</sup></p>

<h2>Limity</h2>

<p>Tvrdenia o ploche cýst, fibróze, zápale a dráhach mTOR a LKB1-AMPK pri obmedzení od 10 % do 40 % sú zo štruktúrovaného abstraktu Warnerovej práce. Plný text tejto práce sa v tomto kole nepodarilo stiahnuť, takže dávkovanie po jednotlivých modeloch a veta o malnutrícii overené nie sú. Predloha, z ktorej článok vyšiel, uvádzala aj pokles proliferácie a apoptózy. Abstrakt ich nespomína, preto v článku nie sú.<sup>3</sup></p>

<p>Ľudská štúdia mala 28 ľudí a žiadnu súčasnú kontrolnú skupinu. Magnetickú rezonanciu na konci malo dvadsať z nich. htTKV bol prieskumný ukazovateľ. Štatistické testy neboli upravené na mnohonásobné porovnávanie. Časť sledovania prebehla na diaľku a pandémia ovplyvnila dochádzku. Súbor bol z jedného centra a 24 z 28 ľudí bolo bieleho nehispánskeho pôvodu. Samohodnotené dodržiavanie nie je záznam odvážených jedál. Z týchto údajov sa nedá oddeliť účinok samotných kalórií od úbytku hmotnosti a od zmeny zloženia tela. U myší s normálnou hmotnosťou zabralo len denné obmedzenie, ktoré zároveň znížilo hmotnosť. Autori pripomínajú, že iný model účinok opísal aj bez zmeny hmotnosti.<sup>1</sup></p>

<p>Observačná práca z HALT-PKD A nedokazuje, že zníženie indexu telesnej hmotnosti spomalí chorobu. Protokol z októbra 2026 opisuje nábor a plán, nie účinok. Ročník a rozsah strán ešte nemá.<sup>2,4</sup></p>

<h2>Záver</h2>

<p>U dospelých s ADPKD, s nadváhou alebo obezitou a s eGFR najmenej 30 ml/min/1,73 m<sup>2</sup> bolo denné kalorické obmedzenie počas jedného roka uskutočniteľné a lepšie znášané než prerušované hladovanie s troma dňami veľmi nízkeho príjmu. Hmotnosť klesla o 9,1 % oproti 4,9 %. Nižšia ročná zmena htTKV súvisela s úbytkom hmotnosti a vnútrobrušného tuku. Medzi režimami sa nelíšila. Objem cýst pritom stúpol, priemerná eGFR sa nezmenila a kontrolná skupina chýbala. Pri normálnej hmotnosti predklinické údaje varujú pred úbytkom beztukovej hmoty. Kým neskončí prebiehajúca kontrolovaná štúdia, kalorické obmedzenie nie je liečba ADPKD. U človeka s nadváhou, u ktorého sa úbytok hmotnosti zvažuje aj z iného dôvodu, je z týchto prác rozumné voliť denné obmedzenie, nie prerušované hladovanie, a viesť ho tak, aby schudnutie nešlo na úkor svalu.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani výživový predpis. Cieľ 1 773 kcal a 34 % týždenný deficit sú ciele štúdie u konkrétnych ľudí s nadváhou, nie dávka pre ambulanciu.</em></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=empagliflozin-adpkd-pilotna-studia">Empagliflozín pri autozómovo dominantnej polycystickej chorobe obličiek: pilotná randomizovaná štúdia</a></li>
  <li><a href="article.php?slug=vasopresin-nezavisla-cesta-regulacie-vody-adpkd">Od vazopresínu nezávislá regulácia vody a jej možný význam pri liečbe ADPKD</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li id="ref-hopp-2022"><strong>Katharina Hopp, Victoria A. Catenacci, Nidhi Dwivedi, Timothy L. Kline, Wei Wang, Zhiying You, Dustin T. Nguyen, Kristen Bing, Bhavya Poudyal, Ginger C. Johnson, Matthew R. Jackman, Marsha Miller, Cortney N. Steele, Natalie J. Serkova, Paul S. MacLean, Raphael A. Nemenoff, Berenice Gitomer, Michel Chonchol, Kristen L. Nowak.</strong> <em>Weight loss and cystic disease progression in autosomal dominant polycystic kidney disease.</em> iScience. 21. januára 2022, ročník 25, číslo 1, článok 103697. Elektronicky 27. decembra 2021. Register NCT02903511. <a href="https://doi.org/10.1016/j.isci.2021.103697" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.isci.2021.103697</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35059607/" target="_blank" rel="noopener noreferrer">PubMed 35059607</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8760407/" target="_blank" rel="noopener noreferrer">PMC8760407</a>.</li>
  <li id="ref-nowak-2018"><strong>Kristen L. Nowak, Zhiying You, Berenice Gitomer, Godela Brosnahan, Vicente E. Torres, Arlene B. Chapman, Ronald D. Perrone, Theodore I. Steinman, Kaleab Z. Abebe, Frederic F. Rahbari-Oskoui, Alan S. L. Yu, Peter C. Harris, Kyongtae T. Bae, Marie Hogan, Dana Miskulin, Michel Chonchol.</strong> <em>Overweight and Obesity Are Predictors of Progression in Early Autosomal Dominant Polycystic Kidney Disease.</em> Journal of the American Society of Nephrology. 2018, ročník 29, číslo 2, strany 571 až 578. Online 8. novembra 2017. <a href="https://doi.org/10.1681/ASN.2017070819" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.2017070819</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/29118087/" target="_blank" rel="noopener noreferrer">PubMed 29118087</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5791072/" target="_blank" rel="noopener noreferrer">PMC5791072</a>.</li>
  <li id="ref-warner-2016"><strong>Gina Warner, Kyaw Zaw Hein, Veronica Nin, Marika Edwards, Claudia C. S. Chini, Katharina Hopp, Peter C. Harris, Vicente E. Torres, Eduardo N. Chini.</strong> <em>Food Restriction Ameliorates the Development of Polycystic Kidney Disease.</em> Journal of the American Society of Nephrology. 2016, ročník 27, číslo 5, strany 1437 až 1447. Online 4. novembra 2015. <a href="https://doi.org/10.1681/ASN.2015020132" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.2015020132</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/26538633/" target="_blank" rel="noopener noreferrer">PubMed 26538633</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4849816/" target="_blank" rel="noopener noreferrer">PMC4849816</a>.</li>
  <li id="ref-nowak-2026"><strong>Kristen L. Nowak, Cortney N. Steele, Wei Wang, Megan Little, Diana George, Heather Farmer-Bailey, Daniel H. Bessesen, Kristen Bing, Danielle M. Ostendorf, Zhiying You, Katharina Hopp, Timothy Lee Kline, Berenice Gitomer, Victoria A. Catenacci, Michel Chonchol.</strong> <em>Daily Caloric Restriction in Overweight and Obese Adults with ADPKD: Rationale and Protocol of a Randomized Controlled Trial.</em> American Journal of Nephrology. Zverejnené online 17. októbra 2026. Ročník a rozsah strán v čase overenia neboli pridelené. Register NCT04907799. <a href="https://doi.org/10.1159/ajn/ablag025" target="_blank" rel="noopener noreferrer">DOI 10.1159/ajn/ablag025</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42891955/" target="_blank" rel="noopener noreferrer">PubMed 42891955</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom.</strong> Abstrakt Warnerovej práce bol načítaný z PubMed (efetch, PMID 26538633). Deväť autorov, ročník 27, číslo 5 a strany 1437 až 1447 boli porovnané s Crossref. Crossref uvádza online dátum 4. novembra 2015. Europe PMC na plný text XML vrátil chybu servera, preto tvrdenia o ploche cýst, fibróze, zápale a dráhach mTOR a LKB1-AMPK neprekračujú štruktúrovaný abstrakt. Plný text Hoppovej práce bol čítaný na PMC8760407, vrátane tabuliek 1 až 3, opisu výpadkov, nežiaducich udalostí a myšej časti. Autorský zoznam vrátane Kristen Bing, ktorá v HTML zozname autorov na PMC chýba, je z MEDLINE PMID 35059607 a zhoduje sa s Crossref aj s OpenAlex. iScience 21. januára 2022, ročník 25, číslo 1, článok 103697, elektronicky 27. decembra 2021. Register NCT02903511 je z doplnkovej poznámky tejto práce. Záznam ClinicalTrials.gov sa v tomto kole neotváral. Abstrakt Nowakovej observačnej práce bol čítaný na PMC5791072, šestnásť autorov a strany 571 až 578 sú z Crossref, online dátum 8. novembra 2017 tiež. Každá tabuľka plného textu HALT-PKD A sa neporovnávala. Protokol z 17. októbra 2026 bol čítaný ako abstrakt PubMed PMID 42891955 a metadátami Crossref. DOI 10.1159/ajn/ablag025, ročník nepridelený. MEDLINE uvádza stranu 1, čo pri online publikácii nie je rozsah strán. Register NCT04907799 je z abstraktu, stránka registra sa neotvárala. Vlastné je oddelenie útlmu mTOR z abstraktu Warnerovej práce od neskoršieho myšacieho nálezu, kde pomer pre S6 neklesol, upozornenie, že objem cýst u ľudí stúpol, aj keď ročná zmena htTKV vyzerala nízko, a odmietnutie prepísať študijný kalorický cieľ ako ambulancný predpis.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kaloricke-obmedzenie-adpkd-pilotna-studia_article',
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
