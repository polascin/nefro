<?php
/**
 * add_metabolicka-acidoza-ckd-vyssi-vs-nizsi-ciel-hydrogenuhlicitanu-sobic_article.php
 * Odborný článok o randomizovanej štúdii SoBic: vyšší (24 mmol/l) oproti nižšiemu
 * (20 mmol/l) cieľu sérového hydrogénuhličitanu pri metabolickej acidóze u CKD.
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
    'title'        => 'Liečba metabolickej acidózy pri chronickej chorobe obličiek: randomizovaná štúdia SoBic a porovnanie vyššieho a nižšieho cieľa sérového hydrogénuhličitanu',
    'slug'         => 'metabolicka-acidoza-ckd-vyssi-vs-nizsi-ciel-hydrogenuhlicitanu-sobic',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia SoBic: cieľ HCO₃⁻ 24 oproti 20 mmol/l počas 104 týždňov nespomalil pokles eGFR (rozdiel −0,98 ml/min/1,73 m²; p = 0,648), no zvýšil liekovú záťaž.',
    'content'      => <<<'HTML'
<figure>
  <a href="img/metabolicka-acidoza-ckd-vyssi-vs-nizsi-ciel-hydrogenuhlicitanu-sobic.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/metabolicka-acidoza-ckd-vyssi-vs-nizsi-ciel-hydrogenuhlicitanu-sobic.webp" alt="Poloschematická umelecká ilustrácia obličky s tubulárnym systémom znázorňujúca protiklad kyslého metabolického prostredia a tlmivého pôsobenia hydrogénuhličitanu" width="1600" height="1000" loading="lazy" decoding="async" />
  </a>
  <figcaption>Ilustračná poloschematická vizualizácia acidobázickej rovnováhy v obličkovom parenchýme: vnútorné jantárovo-červené žiarenie symbolizuje retenciu kyselín a tubulointersticiálnu acidifikáciu pri pokročilej chronickej chorobe obličiek, kým tyrkysovo-smaragdové prúdenie s mikrobublinami predstavuje exogénne doplnenie hydrogénuhličitanového tlmivého systému. Ide o koncepčnú schému, nie o zobrazenie tkaniva konkrétneho pacienta.</figcaption>
</figure>

<p class="clanok-dek">Chronická metabolická acidóza sprevádza pokročilé štádiá chronickej choroby obličiek (chronic kidney disease, CKD) a spája sa s katabolizmom bielkovín kostrového svalstva, demineralizáciou kosti a urýchlením straty glomerulovej filtrácie. Hoci sa perorálny hydrogénuhličitan sodný používa v nefrológii vyše storočia, klinické skúšania priniesli protichodné odpovede na otázku, akú cieľovú koncentráciu sérového hydrogénuhličitanu (HCO<sub>3</sub><sup>−</sup>) treba dosiahnuť a či intenzívna alkalizácia do pásma plnej normy chráni obličkovú funkciu lepšie než mierna korekcia ťažkej acidémie<sup>1,4–8</sup>.</p>

<p class="clanok-dek">V októbri 2026 publikoval tím z Lekárskej univerzity vo Viedni pod vedením Martiny Gagglovej a Gereho Sunder-Plassmanna v časopise <em>Scientific Reports</em> výsledky otvorenej randomizovanej štúdie <strong>SoBic</strong> (DOI: <a href="https://doi.org/10.1038/s41598-026-68492-9" target="_blank" rel="noopener noreferrer">10.1038/s41598-026-68492-9</a>)<sup>1</sup>. Štúdia ako prvá priamo porovnala dve cieľovo riadené stratégie titrácie enterosolventného hydrogénuhličitanu sodného počas 104 týždňov u dospelých s CKD štádia G3 až G4 a potvrdenou manifestnou metabolickou acidózou (HCO<sub>3</sub><sup>−</sup> ≤ 21 mmol/l): intenzívny cieľ 24 ± 1 mmol/l oproti záchrannej („rescue“) stratégii s cieľom 20 ± 1 mmol/l. Napriek trvalému oddeleniu hladín sérového HCO<sub>3</sub><sup>−</sup> o 3,64 mmol/l na konci sledovania neviedla intenzívna alkalizácia k spomaleniu poklesu odhadovanej glomerulovej filtrácie (estimated glomerular filtration rate, eGFR): rozdiel dvojročnej zmeny eGFR medzi skupinami bol −0,98 ml/min/1,73 m<sup>2</sup> (95 % interval spoľahlivosti [IS] od −3,08 do +1,12; <em>p</em> = 0,648), no za cenu vysokej liekovej záťaže (medián 10 kapsúl po 840 mg denne v 104. týždni) a výrazného nárastu močového vylučovania sodíka<sup>1</sup>.</p>

<h2>Patofyziologické východiská a neistota cieľového pásma</h2>

<p>Pri poklese glomerulovej filtrácie pod približne 25 až 30 ml/min/1,73 m<sup>2</sup> klesá schopnosť obličiek syntetizovať amoniak a vylučovať čistú dennú kyselinovú nálož pochádzajúcu z metabolizmu a potravy<sup>1,2</sup>. Kompenzačná hyperfunkcia zvyšných nefrónov zvyšuje lokálnu amoniogenézu a tubulointersticiálnu koncentráciu vodíkových iónov, čo aktivuje zložku komplementu C3 a stimuluje intrarenálnu tvorbu endotelínu-1, angiotenzínu II a aldosterónu s následnou zápalovou a fibrotizujúcou odpoveďou<sup>1</sup>. Experimentálne a klinické práce navyše rozlišujú včasné štádium retencie kyselín s ešte normálnym sérovým hydrogénuhličitanom (tzv. eubikarbonátová metabolická acidóza) od manifestnej chronickej metabolickej acidózy s poklesom sérového HCO<sub>3</sub><sup>−</sup><sup>1</sup>.</p>

<p>Historická dôkazová základňa pre alkalizačnú liečbu pri CKD bola nejednotná. Jednocentrová britská štúdia Ione de Brito-Ashurstovej a kolegov (2009; <em>N</em> = 134, klírens kreatinínu od 15 do 30 ml/min/1,73 m<sup>2</sup>, východiskový HCO<sub>3</sub><sup>−</sup> od 16 do 20 mmol/l) a talianska multicentrická štúdia UBI Biagia R. Di Ioria a kolegov (2019; <em>N</em> = 740, CKD štádia G3 až G5) preukázali spomalenie straty renálnej funkcie a nižší prechod do dialýzy pri podávaní hydrogénuhličitanu sodného oproti štandardnej starostlivosti<sup>4,5</sup>. Naopak, pragmatická dvojito zaslepená placebom kontrolovaná britská štúdia BiCARB (Miles D. Witham a kolegovia, 2020; <em>N</em> = 300, vek ≥ 60 rokov, CKD G4 až G5, HCO<sub>3</sub><sup>−</sup> &lt; 22 mmol/l) nezistila žiadny prínos pre fyzickú výkonnosť ani obličkovú funkciu a zaznamenala vyšší výskyt nežiaducich udalostí<sup>6,7</sup>. Aj nedávna metaanalýza 14 randomizovaných štúdií (<em>N</em> = 2 037; Ting-Ya Yang a kolegovia, 2024) upozornila, že hoci suplementácia hydrogénuhličitanu sodného v súhrne mierne zlepšila eGFR, výsledky zaťažuje absencia zaslepenia, nejednotná definícia kontrolných skupín a signál vyššieho rizika vzostupu systolického tlaku<sup>8</sup>. Aktualizované odporúčania KDIGO 2024 pre manažment CKD preto opustili staršiu hranicu &lt; 22 mmol/l z roku 2012 a v praktickom bode 3.10.1 odporúčajú zvážiť farmakologickú liečbu metabolickej acidózy predovšetkým pri sérovom HCO<sub>3</sub><sup>−</sup> &lt; 18 mmol/l<sup>10</sup>.</p>

<h2>Metodika a dizajn štúdie SoBic</h2>

<p>Štúdia SoBic (EudraCT: <code>2012-001824-36</code>; schválenie etickej komisie č. 1331/2012) prebiehala v nefrologickej ambulancii Kliniky vnútorného lekárstva III Lekárskej univerzity vo Viedni; nábor sa začal v roku 2014 a posledný pacient ukončil 104-týždňové sledovanie v januári 2024<sup>1,2</sup>. Zaradení boli klinicky stabilní dospelí pacienti s eGFR od 15 do &lt; 60 ml/min/1,73 m<sup>2</sup> (CKD G3 až G4) a s dvomi nezávislými meraniami venózneho sérového HCO<sub>3</sub><sup>−</sup> ≤ 21 mmol/l v priebehu 14 dní pred randomizáciou. Pacienti, ktorí užívali hydrogénuhličitan sodný v predchorobí (18 z 58 osôb, teda 31 %), mohli vstúpiť do štúdie po 4-týždňovej vymývacej („washout“) fáze<sup>1</sup>.</p>

<p>Vylučovacie kritériá zahŕňali aktívne malígne ochorenie alebo stav do 5 rokov po jeho vyliečení, morbídnu obezitu (BMI &gt; 40 kg/m<sup>2</sup>), chronický zápal (CRP &gt; 10 mg/dl), akúkoľvek imunosupresívnu liečbu, nekontrolovanú artériovú hypertenziu (&gt; 150/90 mmHg napriek štvorkombinácii antihypertenzív), manifestné kongestívne srdcové zlyhávanie a alergiu na arašidy alebo sóju (pomocné látky kapsulového prípravku)<sup>1</sup>. Pacienti boli randomizovaní v pomere 1 : 1 metódou minimalizácie so stratifikáciou podľa veku (&gt; 60 verzus ≤ 60 rokov), prítomnosti diabetu, ťažkej metabolickej acidózy (HCO<sub>3</sub><sup>−</sup> &lt; 18 mmol/l) a predchádzajúcej alkalizačnej liečby<sup>1</sup>:</p>

<ul>
  <li><strong>Intervenčná skupina s vyšším cieľom (<em>n</em> = 29):</strong> perorálny enterosolventný hydrogénuhličitan sodný v kapsulách po 840 mg (<em>Nephrotrans</em> 840 mg) titrovaný pri každej kontrole (týždne 4, 8, 12, 20, 29, 38, 47, 60, 73, 86 a 104) na cieľovú koncentráciu venózneho sérového HCO<sub>3</sub><sup>−</sup> 24 ± 1 mmol/l<sup>1</sup>.</li>
  <li><strong>Záchranná („rescue“) skupina s nižším cieľom (<em>n</em> = 29):</strong> hydrogénuhličitan sodný bol nasadený alebo titrovaný len v prípade, že sérový HCO<sub>3</sub><sup>−</sup> na začiatku alebo počas sledovania klesol pod 19 mmol/l, s cieľom udržiavať hladinu v pásme 20 ± 1 mmol/l<sup>1</sup>.</li>
</ul>

<p>Pôvodný výpočet veľkosti vzorky z roku 2012 predpokladal 2 × 100 pacientov pri konzervatívnom odhade smerodajnej odchýlky (SD) dvojročnej zmeny eGFR na úrovni 12 ml/min/1,73 m<sup>2</sup> (z prierezových ambulantných dát) na zachytenie rozdielu 5 ml/min/1,73 m<sup>2</sup> za dva roky (2,5 ml/min/1,73 m<sup>2</sup>/rok) so silou testu 80 % pri α = 0,05. Keďže u mnohých skrínovaných ambulantných pacientov sa po úprave diéty a štandardnej liečby zvýšil sérový HCO<sub>3</sub><sup>−</sup> nad prah 21 mmol/l, nábor postupoval pomaly. Po schválení etickou komisiou vykonal nezávislý štatistik zaslepený prepočet veľkosti vzorky zo 649 longitudinálnych meraní eGFR; zistená vnútroskupinová SD zmeny eGFR bola 5,62 ml/min/1,73 m<sup>2</sup>, pri ktorej súbor 58 randomizovaných pacientov zabezpečoval viac než 80 % štatistickú silu pre pôvodne definovaný klinický rozdiel<sup>1</sup>.</p>

<p>Primárnym ukazovateľom bol rozdiel v zmene eGFR (vypočítanej 4-premennou rovnicou MDRD z IDMS-kalibrovaného Jaffeovho kreatinínu) po 104 týždňoch v populácii podľa zámeru liečby (intention-to-treat, ITT). Na elimináciu skreslenia z informatívneho vypadávania pacientov (úmrtie alebo začatie renálnej substitučnej liečby, RRT) použili autori združený longitudinálno-prežívací model (joint model so zdieľanými náhodnými efektmi: lineárny zmiešaný model pre eGFR s kubickými splajnmi pre východiskový vek a HCO<sub>3</sub><sup>−</sup> a úpravou o diabetes, prepojený s Weibullovým modelom proporcionálnych rizík pre čas do úmrtia alebo RRT)<sup>1</sup>.</p>

<div class="table-responsive" role="region" aria-label="Východiskové charakteristiky a dávkovanie v štúdii SoBic" tabindex="0">
  <table class="comparison-table">
    <thead>
      <tr>
        <th scope="col">Parameter</th>
        <th scope="col">Intervenčná skupina: cieľ HCO<sub>3</sub><sup>−</sup> 24 ± 1 mmol/l (<em>n</em> = 29)</th>
        <th scope="col">Záchranná skupina: cieľ HCO<sub>3</sub><sup>−</sup> 20 ± 1 mmol/l (<em>n</em> = 29)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Vek, priemer (SD)</th>
        <td>59 (13) rokov</td>
        <td>59 (16) rokov</td>
      </tr>
      <tr>
        <th scope="row">Ženy, <em>n</em> (%)</th>
        <td>12 (41 %)</td>
        <td>10 (34 %)</td>
      </tr>
      <tr>
        <th scope="row">Východiskový sérový HCO<sub>3</sub><sup>−</sup>, priemer (SD)</th>
        <td>18,87 (1,83) mmol/l</td>
        <td>19,38 (1,49) mmol/l</td>
      </tr>
      <tr>
        <th scope="row">Ťažká acidóza pri vstupe (HCO<sub>3</sub><sup>−</sup> &lt; 18 mmol/l), <em>n</em> (%)</th>
        <td>6 (21 %)</td>
        <td>6 (21 %)</td>
      </tr>
      <tr>
        <th scope="row">Venózne pH / pCO<sub>2</sub>, priemer (SD)</th>
        <td>7,29 (0,06) / 43 (7) mmHg</td>
        <td>7,29 (0,04) / 45 (6) mmHg</td>
      </tr>
      <tr>
        <th scope="row">Východisková eGFR (MDRD), priemer (SD)</th>
        <td>25 (8) ml/min/1,73 m<sup>2</sup></td>
        <td>27 (10) ml/min/1,73 m<sup>2</sup></td>
      </tr>
      <tr>
        <th scope="row">Zastúpenie štádií CKD: G3a / G3b / G4</th>
        <td>1 (3,4 %) / 6 (21 %) / 22 (76 %)</td>
        <td>3 (10 %) / 8 (28 %) / 18 (62 %)</td>
      </tr>
      <tr>
        <th scope="row">Diabetes mellitus / artériová hypertenzia</th>
        <td>11 (38 %) / 28 (97 %)</td>
        <td>10 (34 %) / 28 (97 %)</td>
      </tr>
      <tr>
        <th scope="row">Východiskový ambulantný TK (systolický / diastolický)</th>
        <td>135 (15) / 83 (11) mmHg</td>
        <td>127 (17) / 76 (14) mmHg</td>
      </tr>
      <tr>
        <th scope="row">Medián dávky NaHCO<sub>3</sub> v 20. / 47. / 104. týždni</th>
        <td>6 720 / 7 560 / 8 400 mg/deň (10 kapsúl v 104. týždni)</td>
        <td>1 680 mg/deň (len u liečených: <em>n</em> = 13 / 8 / 7)</td>
      </tr>
      <tr>
        <th scope="row">Dosiahnutie cieľového HCO<sub>3</sub><sup>−</sup> v 47. / 104. týždni</th>
        <td>80,8 % (<em>n</em> = 21) / 72,0 % (<em>n</em> = 18)</td>
        <td>69,0 % (<em>n</em> = 20) v oboch časových bodoch</td>
      </tr>
      <tr>
        <th scope="row">Zmena 24-hodinovej natriurézy oproti vstupu (47. / 104. týždeň)</th>
        <td>+78 ± 93 / +64 ± 69 mmol/24 h</td>
        <td>−17 ± 58 (<em>p</em> &lt; 0,001) / +10 ± 45 mmol/24 h (<em>p</em> = 0,007)</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Hlavné výsledky: biochemické oddelenie ramien bez renálneho benefitu</h2>

<p>Celkové sledovanie zahŕňalo 5 499 osobotýždňov s mediánom 104 týždňov (interkvartilové rozpätie [IQR] od 104 do 105 týždňov). Návštevu v 104. týždni absolvovalo 49 z 58 účastníkov; 2 pacienti počas štúdie zomreli (po jednom v každom ramene), 4 začali renálnu substitučnú liečbu, 2 odvolali informovaný súhlas a 1 pacient bol stratený z priameho sledovania (pričom pri kontrole na inom pracovisku o 24 mesiacov nedosiahol RRT ani úmrtie)<sup>1</sup>.</p>

<p>Celkový medián dennej dávky hydrogénuhličitanu sodného v intervenčnej skupine bol 6,7 g/deň (IQR od 4,2 do 8,4 g/deň) a postupnou titráciou vzrástol až na medián 8 400 mg/deň (IQR od 7 140 do 10 080 mg/deň, čo zodpovedá 10 kapsulám po 840 mg denne) v 104. týždni. V záchrannej skupine potrebovalo suplementáciu len 13 pacientov v 20. týždni, 8 v 47. týždni a 7 v 104. týždni s mediánom dávky 1 680 mg/deň (2 kapsuly denne). Približne 70 % pacientov v oboch skupinách dosiahlo predpísané cieľové pásmo, čo viedlo k štatisticky vysokovýznamnému medziskupinovému rozdielu v zmene sérového HCO<sub>3</sub><sup>−</sup> o <strong>3,57 mmol/l</strong> (95 % IS od 2,29 do 4,85; <em>p</em> &lt; 0,001) v 47. týždni a o <strong>3,64 mmol/l</strong> (95 % IS od 2,21 do 5,07 mmol/l; <em>p</em> &lt; 0,001) v 104. týždni<sup>1</sup>.</p>

<p>Napriek tomuto dosiahnutému rozdielu v acidobázickom stave sa primárny obličkový ukazovateľ medzi skupinami nelíšil<sup>1</sup>:</p>

<ul>
  <li><strong>Záchranná skupina (cieľ 20 ± 1 mmol/l):</strong> odhadovaný priemerný pokles eGFR za 104 týždňov bol <strong>−5,80 ml/min/1,73 m<sup>2</sup></strong> (95 % IS od −8,77 do −2,84), čo zodpovedá ročnému tempu poklesu −2,90 ml/min/1,73 m<sup>2</sup>/rok (95 % IS od −4,38 do −1,42).</li>
  <li><strong>Intervenčná skupina (cieľ 24 ± 1 mmol/l):</strong> odhadovaný priemerný pokles eGFR za 104 týždňov bol <strong>−6,78 ml/min/1,73 m<sup>2</sup></strong> (95 % IS od −9,79 do −3,78), teda ročné tempo poklesu −3,39 ml/min/1,73 m<sup>2</sup>/rok (95 % IS od −4,89 do −1,89).</li>
  <li><strong>Medziskupinový rozdiel (intervenčná verzus záchranná skupina):</strong> za dva roky predstavoval <strong>−0,98 ml/min/1,73 m<sup>2</sup></strong> (95 % IS od −3,08 do +1,12; <em>p</em> = 0,648), resp. ročný rozdiel −0,49 ml/min/1,73 m<sup>2</sup>/rok (95 % IS od −2,59 do +1,61; <em>p</em> = 0,648).</li>
  <li><strong>Analýza per-protocol (<em>n</em> = 10 v intervenčnej a <em>n</em> = 13 v záchrannej skupine s dodržaním cieľového pásma na &gt; 60 % kontrol po 12. týždni; 3 125 osobotýždňov):</strong> v združenom modeli mala intervenčná skupina prídavný ročný pokles eGFR o 0,85 ml/min/1,73 m<sup>2</sup>/rok oproti záchrannej skupine (<em>p</em> = 0,637), takže ani u striktne adherentných pacientov sa neprejavil náznak nefroprotektívneho prínosu vyššieho cieľa<sup>1</sup>.</li>
</ul>

<div class="table-responsive" role="region" aria-label="Primárne, sekundárne a bezpečnostné výsledky štúdie SoBic po 104 týždňoch" tabindex="0">
  <table class="comparison-table">
    <thead>
      <tr>
        <th scope="col">Sledovaný ukazovateľ</th>
        <th scope="col">Intervenčná skupina (24 ± 1 mmol/l)</th>
        <th scope="col">Záchranná skupina (20 ± 1 mmol/l)</th>
        <th scope="col">Rozdiel medzi skupinami (95 % IS) a hodnota <em>p</em></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Rozdiel v zmene sérového HCO<sub>3</sub><sup>−</sup> (47. / 104. týždeň)</th>
        <td>Cieľ 24 ± 1 mmol/l</td>
        <td>Cieľ 20 ± 1 mmol/l</td>
        <td>+3,57 mmol/l (2,29 až 4,85; <em>p</em> &lt; 0,001) / +3,64 mmol/l (2,21 až 5,07; <em>p</em> &lt; 0,001)</td>
      </tr>
      <tr>
        <th scope="row">Zmena eGFR za 104 týždňov (ITT, združený model)</th>
        <td>−6,78 ml/min/1,73 m<sup>2</sup> (−9,79 až −3,78)</td>
        <td>−5,80 ml/min/1,73 m<sup>2</sup> (−8,77 až −2,84)</td>
        <td>−0,98 ml/min/1,73 m<sup>2</sup> (−3,08 až +1,12; <em>p</em> = 0,648)</td>
      </tr>
      <tr>
        <th scope="row">Ročná zmena eGFR (ITT, združený model)</th>
        <td>−3,39 ml/min/1,73 m<sup>2</sup>/rok (−4,89 až −1,89)</td>
        <td>−2,90 ml/min/1,73 m<sup>2</sup>/rok (−4,38 až −1,42)</td>
        <td>−0,49 ml/min/1,73 m<sup>2</sup>/rok (−2,59 až +1,61; <em>p</em> = 0,648)</td>
      </tr>
      <tr>
        <th scope="row">Zmena ambulantného systolického TK (47. / 104. týždeň)</th>
        <td>Medián v 104. týždni: −4,5 mmHg (−14 až +5,3)</td>
        <td>Medián v 104. týždni: +6,5 mmHg (−5 až +16,5)</td>
        <td>47. týždeň: −4,25 mmHg (<em>p</em> = 0,344); 104. týždeň: −11,17 mmHg (−19,63 až −2,70; <em>p</em> = 0,011)</td>
      </tr>
      <tr>
        <th scope="row">Zmena telesnej hmotnosti / albuminúrie (UACR) v 104. týždni</th>
        <td>Bez klinicky významného posunu</td>
        <td>Bez klinicky významného posunu</td>
        <td>Hmotnosť: −0,28 kg (<em>p</em> = 0,902); UACR: +184 mg/g (<em>p</em> = 0,298)</td>
      </tr>
      <tr>
        <th scope="row">Nežiaduce udalosti (AE) spolu / závažné AE (SAE)</th>
        <td>90 AE (81 % mierne) / 5 SAE (4 hospitalizácie)</td>
        <td>97 AE (70 % mierne) / 10 SAE (8 hospitalizácií)</td>
        <td>Gastrointestinálne AE: 20 (22 %) vs. 15 (16 %); edémy: 6 (6,6 %) vs. 4 (4,1 %)</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Bezpečnostný profil, krvný tlak a záťaž sodíkom</h2>

<p>Vzhľadom na to, že každý gram hydrogénuhličitanu sodného obsahuje približne 11,9 mmol (274 mg) sodíka, denná dávka 8,4 g v intervenčnej skupine predstavovala prídavný príjem okolo 100 mmol sodíka denne. Tomu zodpovedal nárast 24-hodinového močového vylučovania sodíka v intervenčnej skupine v priemere o +78 ± 93 mmol/24 h v 47. týždni a o +64 ± 69 mmol/24 h v 104. týždni oproti východiskovej hodnote<sup>1</sup>. Napriek tejto exogénnej sodíkovej náloži sa v intervenčnej skupine nezistil nárast ambulantného krvného tlaku, telesnej hmotnosti (−0,28 kg v 104. týždni; <em>p</em> = 0,902) ani pomeru albumínu ku kreatinínu v moči (<em>p</em> = 0,298). Priemerná zmena systolického tlaku v 104. týždni bola v intervenčnej skupine dokonca nižšia než v záchrannej skupine (upravený rozdiel −11,17 mmHg; <em>p</em> = 0,011), k čomu však mohol prispieť vyšší východiskový tlak v intervenčnom ramene (135/83 verzus 127/76 mmHg) a mierne častejšie navýšenie antihypertenzívnej či diuretickej liečby počas sledovania (medián čistej zmeny počtu antihypertenzív +1 [IQR od 0 do 2] v intervenčnej oproti 0 [IQR od 0 do 1] v záchrannej skupine)<sup>1</sup>. Výsledok sa zhoduje s predchádzajúcou podanalýzou 24-hodinového ambulantného monitorovania krvného tlaku (ABPM) v kohorte SoBic po 8 týždňoch (Martina Gagglová a kolegovia, 2021) aj so systematickým prehľadom Beverley Beynon-Cobbovej a kolegov (2023; 14 RCT, <em>N</em> = 2 110)<sup>3,9</sup>.</p>

<p>Počas štúdie bolo zaznamenaných spolu 187 nežiaducich udalostí u 56 pacientov (90 v intervenčnej a 97 v záchrannej skupine), z ktorých väčšina bola mierna (81 % verzus 70 %). V skupine s vyšším cieľom sa častejšie vyskytovali gastrointestinálne ťažkosti (20 udalostí [22 %] oproti 15 udalostiam [16 %], najmä meteorizmus [9 verzus 5] a hnačka [5 verzus 4, plus 1 opakovaná]) a periférne edémy (6 [6,6 %] oproti 4 [4,1 %])<sup>1</sup>. Autori však osobitne upozorňujú na klinicky dôležitú kazuistickú súvislosť: jeden pacient v intervenčnej skupine s anamnézou kongestívneho srdcového zlyhávania zaznamenal počas titrácie dávky hydrogénuhličitanu sodného medzi 8. a 12. týždňom edémy dolných končatín a dýchavičnosť a približne päť týždňov po kontrole v 20. týždni zomrel mimo nemocnice; hoci bezprostrednú príčinu smrti nebolo možné určiť, príčinný podiel sodíkovej záťaže pri preexistujúcom srdcovom zlyhávaní nemožno vylúčiť<sup>1</sup>.</p>

<h2>Prečo sa výsledky štúdie SoBic líšia od starších randomizovaných skúšaní?</h2>

<p>Rozdiel medzi neutrálnym výsledkom štúdie SoBic a pozitívnymi závermi štúdií de Brito-Ashurstovej a kolegov (2009) či UBI (2019) možno vysvetliť tromi metodickými a populačnými faktormi<sup>1,4,5</sup>:</p>

<ol>
  <li><strong>Prítomnosť protokolovanej záchrannej liečby v kontrolnom ramene:</strong> Na rozdiel od starších otvorených štúdií, kde pacienti v ramene štandardnej starostlivosti zotrvávali pri výraznej nekorigovanej acidémii, štúdia SoBic eticky nepripustila pokles sérového HCO<sub>3</sub><sup>−</sup> pod 19 mmol/l a udržiavala kontrolné rameno na hladine 20 ± 1 mmol/l. Záver štúdie preto nehovorí, že ťažkú metabolickú acidózu netreba liečiť vôbec, ale že agresívna titrácia na 24 ± 1 mmol/l neprináša prídavnú nefroprotekciu oproti udržaniu HCO<sub>3</sub><sup>−</sup> okolo 20 ± 1 mmol/l<sup>1</sup>.</li>
  <li><strong>Štádium CKD a prítomnosť manifestnej acidózy:</strong> V kohorte SoBic mali všetci pacienti potvrdenú manifestnú chronickú metabolickú acidózu (≤ 21 mmol/l v dvoch odberoch, priemer ~19,1 mmol/l) a až 69 % súboru bolo v štádiu CKD G4 (priemerná eGFR 25 až 27 ml/min/1,73 m<sup>2</sup>). Naopak, v štúdii UBI (priemerný východiskový HCO<sub>3</sub><sup>−</sup> 21,5 ± 2,4 mmol/l) mala približne polovica účastníkov východiskový hydrogénuhličitan v pásme normy<sup>1,5</sup>. Autori SoBic preto vyslovujú hypotézu, že pri včasnej, eubikarbonátovej retencii kyselín (v štádiách G2 až G3a, či už úpravou stravy s prevahou rastlinných zásadotvorných zložiek, alebo malou dávkou alkálií) možno tubulointersticiálne poškodenie ešte spomaliť, zatiaľ čo pri pokročilej CKD s fixovanou hypobikarbonatémiou sú už fibrotické mechanizmy natoľko rozvinuté, že samotná normalizácia sérového HCO<sub>3</sub><sup>−</sup> ich nezvráti<sup>1</sup>.</li>
  <li><strong>Obtiažnosť dosiahnutia horného pásma normy a lieková záťaž:</strong> U pacientov s pokročilou CKD a manifestnou acidózou si cieľ 24 ± 1 mmol/l vyžiadal na konci štúdie medián 10 kapsúl (8,4 g) denne, pričom 28 % pacientov tento cieľ v 104. týždni napriek intenzívnej titrácii nedosiahlo. Keďže pacienti s pokročilou CKD užívajú v priemere okolo 12 rôznych liekov denne, pridanie 8 až 12 veľkých kapsúl hydrogénuhličitanu sodného bez preukázaného prínosu pre eGFR zhoršuje celkovú adherenciu a môže ovplyvňovať žalúdočné pH i vstrebávanie súbežne podávaných liečiv<sup>1</sup>.</li>
</ol>

<h2>Limity</h2>

<p>Pri klinickej interpretácii štúdie SoBic treba zohľadniť niekoľko obmedzení, ktoré autori transparentne uvádzajú<sup>1</sup>:</p>

<ul>
  <li><strong>Veľkosť vzorky a štatistická sila pre menšie účinky:</strong> Štúdia bola dimenzovaná (po zaslepenom prepočte so zistenou longitudinálnou SD 5,62 ml/min/1,73 m<sup>2</sup>) na odhalenie rozdielu 5 ml/min/1,73 m<sup>2</sup> za dva roky (2,5 ml/min/1,73 m<sup>2</sup>/rok). Menší rozdiel v tempe poklesu eGFR (napr. 0,5 až 1,0 ml/min/1,73 m<sup>2</sup>/rok) na vzorke <em>N</em> = 58 nemožno štatisticky vylúčiť, hoci bodový odhad v štúdii SoBic smeroval numericky dokonca v neprospech vyššieho cieľa (−0,98 ml/min/1,73 m<sup>2</sup> za 2 roky)<sup>1</sup>.</li>
  <li><strong>Otvorený (open-label) a jednocentrový dizajn:</strong> Pre vysoký počet kapsúl a priebežnú titráciu podľa krvných plynov nebolo použité dvojité zaslepenie placebom, čo mohlo ovplyvniť rozhodovanie o úprave sprievodnej antihypertenzívnej a diuretickej liečby.</li>
  <li><strong>Nízke zastúpenie modernej nefroprotektívnej liečby (SGLT2i a GLP-1 RA):</strong> Keďže nábor sa začal v roku 2014, inhibítory SGLT2 užíval pri vstupe len 1 pacient (a 2 začali počas sledovania) a agonisty receptorov GLP-1 užívali pri vstupe 2 pacienti (a 3 začali počas sledovania)<sup>1</sup>.</li>
  <li><strong>Výpočet eGFR rovnicou MDRD a Jaffeov kreatinín:</strong> V súlade s protokolom z roku 2012 bola primárna analýza postavená na 4-premennej rovnici MDRD namiesto dnes preferovanej rovnice CKD-EPI<sup>1,2</sup>.</li>
</ul>

<h2>Klinický záver pre nefrologickú prax</h2>

<p>Randomizovaná štúdia SoBic prináša pre každodennú ambulantnú prax tri konkrétne posolstvá<sup>1,10</sup>:</p>

<ol>
  <li><strong>Neskĺznuť k terapeutickému perfekcionizmu:</strong> U pacientov s CKD štádia G3 až G4 a manifestnou metabolickou acidózou (HCO<sub>3</sub><sup>−</sup> ≤ 21 mmol/l) neprináša agresívna titrácia perorálneho hydrogénuhličitanu sodného na cieľ 24 ± 1 mmol/l žiadne spomalenie poklesu eGFR v porovnaní s miernym cieľom okolo 20 ± 1 mmol/l (so zásahom pri poklese pod 18 až 19 mmol/l).</li>
  <li><strong>Súlad s konzervatívnejším prahom KDIGO 2024:</strong> Zistenia priamo podporujú posun v odporúčaniach KDIGO 2024 (praktický bod 3.10.1), ktoré odporúčajú farmakologickú alkalizáciu predovšetkým pri poklese sérového HCO<sub>3</sub><sup>−</sup> &lt; 18 mmol/l, pričom v pásme od 18 do 21 mmol/l má prednosť úprava stravy (zníženie kyselinovej nálože zvýšením podielu ovocia a zeleniny s prihliadnutím na kaliémiu), korekcia hyperkaliémie a optimalizácia konzervatívnej nefroprotektívnej liečby<sup>1,10</sup>.</li>
  <li><strong>Opatrnosť pri srdcovom zlyhávaní a vysokej liekovej záťaži:</strong> Kým u kardiovaskulárne kompenzovaných pacientov s CKD G3 až G4 neviedli ani vysoké dávky NaHCO<sub>3</sub> k vzostupu krvného tlaku či hmotnosti, u pacientov s anamnézou srdcového zlyhávania a sklonom k retencii tekutín môže vysoká sodíková nálož vyvolať objemovú dekompenzáciu; pri potrebe alkalizácie je preto bezpečnejšie cieliť na dolnú hranicu okolo 20 mmol/l s nízkou dávkou (zvyčajne 1,5 až 2,5 g/deň)<sup>1</sup>.</li>
</ol>

<hr />

<p><em>Upozornenie: Tento odborný text slúži výlučne ako informačný a vzdelávací materiál pre lekárov a zdravotníckych pracovníkov. Nenahrádza klinický úsudok ošetrujúceho lekára, platné súhrny charakteristických vlastností liekov (SPC) ani individuálne posúdenie stavu pacienta.</em></p>

<h2>Literatúra</h2>

<ol class="clanok-literatura">
  <li><em>Gaggl, Martina; Aigner, Christof; Repitz, Alexandra; Riesenhuber, Sonja; Sliber, Christopher; Madern, Moritz; Gleiss, Andreas; Fraunschiel, Melanie; Schmidt, Alice; Sunder-Plassmann, Gere. A randomized trial of high versus low serum bicarbonate targets and glomerular filtration rate decline in stage 3–4 chronic kidney disease. Scientific Reports. 2026 (online 10. októbra 2026). DOI: <a href="https://doi.org/10.1038/s41598-026-68492-9" target="_blank" rel="noopener noreferrer">10.1038/s41598-026-68492-9</a>.</em></li>
  <li><em>Gaggl, Martina; Cejka, Daniel; Plischke, Max; Heinze, Georg; Fraunschiel, Melanie; Schmidt, Alice; Hörl, Walter H.; Sunder-Plassmann, Gere. Effect of oral sodium bicarbonate supplementation on progression of chronic kidney disease in patients with chronic metabolic acidosis: study protocol for a randomized controlled trial (SoBic-Study). Trials. 2013;14:196. DOI: <a href="https://doi.org/10.1186/1745-6215-14-196" target="_blank" rel="noopener noreferrer">10.1186/1745-6215-14-196</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/23826760/" target="_blank" rel="noopener noreferrer">23826760</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3729547/" target="_blank" rel="noopener noreferrer">PMC3729547</a>.</em></li>
  <li><em>Gaggl, Martina; Repitz, Alexandra; Riesenhuber, Sonja; Aigner, Christof; Sliber, Christopher; Fraunschiel, Melanie; Cejka, Daniel; Sunder-Plassmann, Gere. Effect of Oral Sodium Bicarbonate Treatment on 24-Hour Ambulatory Blood Pressure Measurements in Patients With Chronic Kidney Disease and Metabolic Acidosis. Frontiers in Medicine. 2021;8:711034. DOI: <a href="https://doi.org/10.3389/fmed.2021.711034" target="_blank" rel="noopener noreferrer">10.3389/fmed.2021.711034</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/34552945/" target="_blank" rel="noopener noreferrer">34552945</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8450526/" target="_blank" rel="noopener noreferrer">PMC8450526</a>.</em></li>
  <li><em>de Brito-Ashurst, Ione; Varagunam, Mira; Raftery, Martin J.; Yaqoob, Muhammad M. Bicarbonate supplementation slows progression of CKD and improves nutritional status. Journal of the American Society of Nephrology. 2009;20(9):2075–2084. DOI: <a href="https://doi.org/10.1681/ASN.2008111205" target="_blank" rel="noopener noreferrer">10.1681/ASN.2008111205</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/19608703/" target="_blank" rel="noopener noreferrer">19608703</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC2736774/" target="_blank" rel="noopener noreferrer">PMC2736774</a>.</em></li>
  <li><em>Di Iorio, Biagio R.; Bellasi, Antonio; Raphael, Kalani L.; Santoro, Domenico; Aucella, Filippo; Garofano, Luciano; Ceccarelli, Michele; Di Lullo, Luca; Capolongo, Giovanna; Di Iorio, Mattia; Guastaferro, Pasquale; Capasso, Giovambattista; UBI Study Group. Treatment of metabolic acidosis with sodium bicarbonate delays progression of chronic kidney disease: the UBI Study. Journal of Nephrology. 2019;32(6):989–1001. DOI: <a href="https://doi.org/10.1007/s40620-019-00656-5" target="_blank" rel="noopener noreferrer">10.1007/s40620-019-00656-5</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/31598912/" target="_blank" rel="noopener noreferrer">31598912</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6821658/" target="_blank" rel="noopener noreferrer">PMC6821658</a>.</em></li>
  <li><em>BiCARB study group. Clinical and cost-effectiveness of oral sodium bicarbonate therapy for older patients with chronic kidney disease and low-grade acidosis (BiCARB): a pragmatic randomised, double-blind, placebo-controlled trial. BMC Medicine. 2020;18(1):91. DOI: <a href="https://doi.org/10.1186/s12916-020-01542-9" target="_blank" rel="noopener noreferrer">10.1186/s12916-020-01542-9</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/32268897/" target="_blank" rel="noopener noreferrer">32268897</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7144058/" target="_blank" rel="noopener noreferrer">PMC7144058</a>.</em></li>
  <li><em>Witham, Miles D.; Band, Margaret; Chong, Huey; Donnan, Peter T.; Hampson, Geeta; Hu, May Khei; Littleford, Roberta; Lamb, Edmund; Kalra, Philip A.; Kennedy, Gwen; McNamee, Paul; Plews, Deirdre; Rauchhaus, Petra; Soiza, Roy L.; Sumukadas, Deepa; Warwick, Graham; Avenell, Alison. Sodium bicarbonate to improve physical function in patients over 60 years with advanced chronic kidney disease: the BiCARB RCT. Health Technology Assessment. 2020;24(27):1–90. DOI: <a href="https://doi.org/10.3310/hta24270" target="_blank" rel="noopener noreferrer">10.3310/hta24270</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/32568065/" target="_blank" rel="noopener noreferrer">32568065</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7336221/" target="_blank" rel="noopener noreferrer">PMC7336221</a>.</em></li>
  <li><em>Yang, Ting-Ya; Lin, Hong-Min; Wang, Hsien-Yi; Chuang, Min-Hsiang; Hsieh, Chia-Chen; Tsai, Kang-Ting; Chen, Jui-Yi. Sodium Bicarbonate Treatment and Clinical Outcomes in Chronic Kidney Disease with Metabolic Acidosis: A Meta-Analysis. Clinical Journal of the American Society of Nephrology. 2024;19(8):959–969. DOI: <a href="https://doi.org/10.2215/CJN.0000000000000487" target="_blank" rel="noopener noreferrer">10.2215/CJN.0000000000000487</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38980732/" target="_blank" rel="noopener noreferrer">38980732</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11321727/" target="_blank" rel="noopener noreferrer">PMC11321727</a>.</em></li>
  <li><em>Beynon-Cobb, Beverley; Louca, Panayiotis; Hoorn, Ewout J.; Menni, Cristina; Padmanabhan, Sandosh. Effect of Sodium Bicarbonate on Systolic Blood Pressure in CKD: A Systematic Review and Meta-Analysis. Clinical Journal of the American Society of Nephrology. 2023;18(4):435–445. DOI: <a href="https://doi.org/10.2215/CJN.0000000000000119" target="_blank" rel="noopener noreferrer">10.2215/CJN.0000000000000119</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/36758154/" target="_blank" rel="noopener noreferrer">36758154</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10103210/" target="_blank" rel="noopener noreferrer">PMC10103210</a>.</em></li>
  <li><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. DOI: <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.10.018</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">38490803</a>.</em></li>
  <li><em>Kilduff, Stella; Brown, Denver D.; Melamed, Michal L. Treating Metabolic Acidosis for CKD Progression? Need for Higher Quality Data. Clinical Journal of the American Society of Nephrology. 2025;20(1):147–149. DOI: <a href="https://doi.org/10.2215/CJN.0000000632" target="_blank" rel="noopener noreferrer">10.2215/CJN.0000000632</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/39665575/" target="_blank" rel="noopener noreferrer">39665575</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11875390/" target="_blank" rel="noopener noreferrer">PMC11875390</a>.</em></li>
</ol>

<p class="clanok-poznamka"><strong>Poznámka k dôkazom a metodike overenia:</strong> Východiskový neúplný návrh bol nahradený kompletnou analýzou plného 15-stranového rukopisu štúdie SoBic (<code>s41598-026-68492-9_reference.pdf</code>) a 14-stranovej elektronickej prílohy (<code>41598_2026_68492_MOESM1_ESM.pdf</code>) na portáli <em>Scientific Reports</em>. Boli overené mená všetkých 10 bibliografických autorov (oddelene od 10 osôb uvedených v poďakovaní za zber dát), presné vstupné a vylučovacie kritériá, zaslepený prepočet veľkosti vzorky, špecifikácia združeného longitudinálno-prežívacieho modelu, dávky <em>Nephrotransu</em> 840 mg, 24-hodinová natriuréza, výsledky ITT aj per-protocol analýzy a kompletná tabuľka nežiaducich udalostí. Zastaraná referencia na KDIGO 2012 bola nahradená aktuálnym usmernením KDIGO 2024 (PMID 38490803) a doplnená o kontext štúdií de Brito-Ashurst et al. (2009), UBI (2019), BiCARB (2020) a metaanalýz CJASN (2023, 2024).</p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=transport-tlmivych-latok-korekcia-acidozy-pd-model-3pm-abe">Transport tlmivých látok a korekcia acidózy pri peritoneálnej dialýze: trojpórový model s acidobázickou rovnováhou</a></li>
  <li><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Sodíková záťaž viazačov draslíka pri liečbe RAASi a MRA</a></li>
  <li><a href="article.php?slug=progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth">Progresia kalcifikácie koronárnych artérií pri zhoršovaní funkcie obličiek: úloha sérového horčíka a parathormónu</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
