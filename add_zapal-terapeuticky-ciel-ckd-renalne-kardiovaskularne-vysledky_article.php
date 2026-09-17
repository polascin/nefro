<?php

/**
 * add_zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky_article.php
 * Zapal ako terapeuticky ciel pri CKD - spracovanie prehladu
 * Nature Reviews Nephrology 2026, doi 10.1038/s41581-026-01117-6.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Zápal pri chronickej chorobe obličiek: od rizikového biomarkera k liečebnému cieľu',
    'slug'         => 'zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zápal pri CKD súvisí s renálnym aj kardiovaskulárnym rizikom, no samotné zníženie CRP nie je liečebným cieľom. Čo ukázali CANTOS, ZEUS, BEACON, MOSAIC a ďalšie štúdie?',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Chronický zápal patrí medzi mechanizmy spájajúce poškodenie obličiek, kardiovaskulárne ochorenia a metabolické komplikácie. Jeho prítomnosť však sama osebe neurčuje konkrétnu liečbu. Pre nefrologickú prax je rozhodujúce rozlišovať medzi zápalom ako ukazovateľom rizika, zápalom ako príčinou poškodenia a zápalovou dráhou, ktorej ovplyvnenie preukázateľne zlepšuje klinické výsledky.</em></p>

<p>Chronická choroba obličiek nie je iba dôsledkom straty nefrónov a poruchy vylučovacej funkcie. Je to systémové ochorenie sprevádzané aktiváciou vrodenej aj adaptívnej imunity, oxidačným stresom, endotelovou dysfunkciou, poruchou metabolizmu a chronickým nízkostupňovým zápalom.</p>

<p>Zápal môže súčasne pôsobiť ako:</p>

<ul>
  <li>dôsledok zníženej funkcie obličiek,</li>
  <li>mechanizmus ďalšieho poškodzovania obličkového parenchýmu,</li>
  <li>urýchľovač aterosklerózy a srdcového zlyhávania,</li>
  <li>faktor anémie, kachexie a proteínovo-energetického chradnutia,</li>
  <li>ukazovateľ infekcie, komorbidity alebo nedostatočnej biokompatibility dialyzačnej liečby.</li>
</ul>

<p>Prehľad publikovaný 4. septembra 2026 v časopise <em>Nature Reviews Nephrology</em> preto hodnotí zápal nielen ako prognostický ukazovateľ, ale aj ako možný terapeutický cieľ. Zásadná otázka znie: dokáže cielené ovplyvnenie konkrétnej zápalovej dráhy spomaliť progresiu chronickej choroby obličiek alebo znížiť kardiovaskulárne riziko bez neprimeraného zvýšenia infekčných a ďalších rizík?</p>

<p>Pri interpretácii treba odlíšiť tri klinicky rozdielne situácie:</p>

<ul>
  <li><strong>infekciu</strong>, pri ktorej je základom identifikácia a liečba pôvodcu alebo ložiska,</li>
  <li><strong>imunitne sprostredkované ochorenie obličiek</strong>, pri ktorom sa imunomodulačná liečba riadi konkrétnou diagnózou a aktivitou ochorenia,</li>
  <li><strong>chronický nízkostupňový systémový zápal</strong>, ktorý pri CKD vzniká z rôznych a často sa prekrývajúcich podnetov.</li>
</ul>

<p>Potlačenie zápalovej odpovede bez kontroly infekcie môže byť nebezpečné. Naopak, pri vaskulitíde či lupusovej nefritíde môže byť imunomodulačná liečba zásadná, ale jej indikáciou nie je samotná hodnota CRP.</p>

<h2>Prečo je chronická choroba obličiek prozápalovým stavom</h2>

<p>Zápal pri chronickej chorobe obličiek vzniká kombináciou viacerých mechanizmov:</p>

<ul>
  <li>zníženého odstraňovania prozápalových mediátorov,</li>
  <li>oxidačného stresu a stresu endoplazmatického retikula,</li>
  <li>aktivácie inflamazómu a jadrového faktora NF-κB,</li>
  <li>poškodenia endotelu a tubulointerstícia,</li>
  <li>metabolickej acidózy,</li>
  <li>poruchy črevnej bariéry a zmien mikrobioty,</li>
  <li>translokácie bakteriálnych produktov,</li>
  <li>akumulácie uremických toxínov,</li>
  <li>zvýšenej sympatikovej aktivity,</li>
  <li>infekcií, periodontitídy a pridružených zápalových ochorení,</li>
  <li>kontaktu krvi s mimotelovým okruhom pri hemodialýze,</li>
  <li>katétrov, cievnych prístupov a nedostatočne biokompatibilných materiálov.</li>
</ul>

<p>Pri diabete, obezite a ateroskleróze sa k tomu pridáva metabolický zápal. Aktivované makrofágy, lymfocyty a poškodené parenchýmové bunky produkujú cytokíny, chemokíny a profibrotické mediátory. Výsledkom môže byť glomerulové poškodenie, tubulointersticiálna fibróza a progresívny pokles glomerulovej filtrácie.</p>

<p>Zápal však nie je jednotný proces. Rozdielne ochorenia obličiek majú odlišné zápalové mechanizmy a klinické kontexty. Nemožno preto predpokladať, že jedno všeobecné protizápalové liečivo bude rovnako účinné pri diabetickej chorobe obličiek, IgA nefropatii, ischemickej nefropatii aj u dialyzovaných pacientov. Heterogenita je jedným z možných vysvetlení rozdielnych výsledkov štúdií; sama osebe ich však nevysvetľuje.</p>

<h2>Vysokosenzitívny CRP: užitočný ukazovateľ, nie samostatný terapeutický cieľ</h2>

<p>Vysokosenzitívny C-reaktívny proteín (hsCRP) je dostupný biomarker systémového zápalu. Označenie <em>hs</em> vyjadruje vysoko citlivú metódu merania tej istej molekuly CRP, nie iný zápalový proteín. Vyššie hodnoty sa pri chronickej chorobe obličiek spájajú s:</p>

<ul>
  <li>rýchlejším poklesom funkcie obličiek,</li>
  <li>vyšším rizikom zlyhania obličiek,</li>
  <li>aterosklerotickými kardiovaskulárnymi príhodami,</li>
  <li>srdcovým zlyhávaním,</li>
  <li>celkovou a kardiovaskulárnou mortalitou.</li>
</ul>

<p>Ide však prevažne o <strong>prognostickú asociáciu</strong>. Zvýšený hsCRP môže byť markerom infekcie, obezity, poruchy výživy, srdcového zlyhávania, poškodenia tkanív alebo iného základného procesu. Koncentrácia cirkulujúceho biomarkera navyše nemusí priamo vyjadrovať intenzitu zápalu v obličkovom tkanive; pri niektorých mediátoroch ju ovplyvňuje aj metabolizmus a eliminácia. Samotný pokles hsCRP preto automaticky neznamená zlepšenie klinickej prognózy.</p>

<p>Jednorazové meranie má obmedzenú výpovednú hodnotu. Najmä pri hemodialýze môže koncentrácia CRP výrazne kolísať v závislosti od akútnej infekcie, problémov s cievnym prístupom, objemového preťaženia alebo inej interkurentnej udalosti. Opakovanie odberu v porovnateľných podmienkach môže pomôcť odlíšiť prechodnú od pretrvávajúcej elevácie, samotné intenzívne monitorovanie bez zmysluplného klinického rozhodnutia však prognózu nezlepšuje.</p>

<p>Hranice hsCRP použité v kardiovaskulárnych štúdiách nemožno bez validácie považovať za univerzálny prah na začatie protizápalovej liečby pri CKD. Zvýšenie má byť predovšetkým podnetom na hľadanie príčiny a komplexné posúdenie rizika.</p>

<h2>Prepojenie zápalu, kardiovaskulárneho ochorenia a CKD</h2>

<p>Pacienti s CKD majú vysoké riziko aterosklerotických aj neaterosklerotických kardiovaskulárnych komplikácií. Zápal podporuje:</p>

<ul>
  <li>endotelovú dysfunkciu,</li>
  <li>oxidáciu a modifikáciu lipoproteínov,</li>
  <li>vznik a nestabilitu aterosklerotických plakov,</li>
  <li>aktiváciu koagulácie,</li>
  <li>vaskulárnu a chlopňovú kalcifikáciu,</li>
  <li>hypertrofiu a fibrózu myokardu,</li>
  <li>mikrovaskulárne poškodenie,</li>
  <li>progresiu srdcového zlyhávania.</li>
</ul>

<p>Vzťah je obojsmerný. Srdcové zlyhávanie a systémová ateroskleróza môžu zhoršovať perfúziu obličiek, aktivovať neurohumorálne systémy a ďalej zosilňovať zápal. Vzniká tak kardiorenálny cyklus, v ktorom sa poškodenie oboch orgánov vzájomne podporuje.</p>

<h2>Od biomarkera ku klinickému prínosu</h2>

<p>Pri hodnotení protizápalovej intervencie nestačí informácia, že významne znížila cytokín, hsCRP alebo albuminúriu. Treba sa pýtať:</p>

<div class="table-responsive" role="region" aria-label="Otázky pri hodnotení protizápalovej liečby" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Otázka</th>
        <th scope="col">Prečo je dôležitá</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Kto bol do štúdie zaradený?</th>
        <td>Výsledky pri miernej CKD nemusia platiť pri zlyhaní obličiek, dialýze alebo po transplantácii.</td>
      </tr>
      <tr>
        <th scope="row">Aký bol primárny ukazovateľ?</th>
        <td>Biomarker nie je rovnocenný zlyhaniu obličiek, infarktu, cievnej mozgovej príhode ani úmrtiu.</td>
      </tr>
      <tr>
        <th scope="row">Bola renálna účinnosť vopred určeným cieľom?</th>
        <td>Dodatočná podskupinová analýza má slabšiu výpovednú hodnotu než prospektívne naplánovaný ukazovateľ.</td>
      </tr>
      <tr>
        <th scope="row">Aká bola súbežná liečba a dĺžka sledovania?</th>
        <td>Prínos treba preukázať nad rámec štandardnej starostlivosti a dostatočne dlho na zachytenie účinnosti aj rizík.</td>
      </tr>
      <tr>
        <th scope="row">Aké boli nežiaduce účinky?</th>
        <td>Infekcie, cytopénie, retencia tekutín či interakcie môžu zmeniť celkový pomer prínosu a rizika.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Kardiovaskulárny prínos nie je automatickým dôkazom renoprotekcie. Podobne môže priaznivý sklon eGFR alebo pokles albuminúrie podporovať hypotézu renálneho účinku, ale jeho význam závisí od mechanizmu lieku, dizajnu a trvania štúdie.</p>

<h2>Priame protizápalové stratégie: prehľad výsledkov</h2>

<p>Nasledujúca tabuľka zhŕňa to, čo sa v tejto oblasti skutočne odskúšalo — a s akým výsledkom:</p>

<div class="table-responsive" role="region" aria-label="Prehľad kľúčových štúdií priamej protizápalovej liečby" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liečivo / cieľ</th>
        <th scope="col">Štúdia</th>
        <th scope="col">Hlavný výsledok</th>
        <th scope="col">Bezpečnosť alebo hlavný limit</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Kanakinumab (IL-1β)</th>
        <td>CANTOS, 10 061 pacientov po infarkte</td>
        <td>MACE HR 0,85 (95 % IS 0,74–0,98) pri dávke 150 mg; hsCRP nižší o 37 percentuálnych bodov</td>
        <td>Vyšší výskyt fatálnych infekcií; celková mortalita bez zmeny</td>
      </tr>
      <tr>
        <th scope="row">Bardoxolónmetyl (Nrf2)</th>
        <td>BEACON, 2 185 pacientov, T2D + CKD G4</td>
        <td>Bez účinku na ESRD/KV úmrtie: HR 0,98 (0,70–1,37); eGFR aj UACR <strong>stúpli</strong></td>
        <td>Predčasné ukončenie; srdcové zlyhávanie HR 1,83 (1,32–2,55)</td>
      </tr>
      <tr>
        <th scope="row">Selonsertib (ASK1)</th>
        <td>MOSAIC, 310 pacientov, T2D + CKD</td>
        <td>Rozdiel sklonu eGFR 1,20 ml/min/1,73 m²/rok (−0,41 až 2,81; p = 0,14)</td>
        <td>Viac renálnych príhod (17 % oproti 12 %) a viac AKI</td>
      </tr>
      <tr>
        <th scope="row">Baricitinib (JAK1/JAK2)</th>
        <td>Fáza 2, 129 pacientov s diabetickou CKD</td>
        <td>UACR nižší o 41 % (pomer 0,59; 0,38–0,93; p = 0,022)</td>
        <td>Anémia u 32,0 % oproti 3,7 % pri placebe</td>
      </tr>
      <tr>
        <th scope="row">Pentoxifylín (PDE)</th>
        <td>PREDIAN, 169 pacientov, T2D + CKD G3–4</td>
        <td>Pokles eGFR 2,1 oproti 6,5 ml/min/1,73 m² za 2 roky (rozdiel 4,3; p &lt; 0,001)</td>
        <td>Otvorený dizajn, malý súbor, bez tvrdých ukazovateľov</td>
      </tr>
      <tr>
        <th scope="row">Ziltivekimab (IL-6)</th>
        <td>ZEUS, 6 376 pacientov, ASCVD + CKD + hsCRP ≥ 2 mg/l</td>
        <td>Podľa predbežných výsledkov bez zníženia MACE: HR 0,99 (0,88–1,11), napriek poklesu voľného IL-6 a hsCRP</td>
        <td>Závažné infekcie častejšie; úplné recenzované výsledky zatiaľ nepublikované</td>
      </tr>
    </tbody>
  </table>
</div>

<h3>Inhibícia interleukínu 1β</h3>

<p>Interleukín 1β patrí medzi kľúčové cytokíny vrodenej imunity. Štúdia CANTOS zaradila 10 061 pacientov po infarkte myokardu s hsCRP najmenej 2 mg/l. Kanakinumab v dávke 150 mg podkožne každé tri mesiace znížil výskyt primárneho kardiovaskulárneho ukazovateľa: HR 0,85 (95 % IS 0,74–0,98; p = 0,021). Dávka 50 mg účinok nemala.</p>

<p>Dva detaily robia z tejto štúdie dôležitú oporu zápalovej hypotézy aterotrombózy. Po prvé, kanakinumab <strong>neznížil koncentrácie lipidov</strong>, takže výsledok podporuje prínos cieleného ovplyvnenia zápalovej dráhy nezávisle od znižovania lipidov. Po druhé, hsCRP klesol dávkovo závisle o 26, 37 a 41 percentuálnych bodov oproti placebu, čo dokladá zásah do cieľovej dráhy.</p>

<p>Cena však bola reálna: vyšší výskyt fatálnych infekcií a <strong>žiadny rozdiel v celkovej mortalite</strong> (HR 0,94; 95 % IS 0,83–1,06). CANTOS teda potvrdila, že zápal je kauzálne ovplyvniteľnou súčasťou reziduálneho kardiovaskulárneho rizika — nepreukázala však, že blokáda IL-1β je renoprotektívnou liečbou CKD. Renálne analýzy boli sekundárne a kanakinumab takúto indikáciu nemá.</p>

<h3>Inhibícia interleukínu 6</h3>

<p>Interleukín 6 stimuluje pečeňovú syntézu CRP a podieľa sa na aterogenéze, anémii, svalovom katabolizme a poruche metabolizmu železa. Vyššie koncentrácie IL-6 sa spájajú s nepriaznivými renálnymi a kardiovaskulárnymi výsledkami.</p>

<p>Monoklonálne protilátky proti IL-6 alebo jeho receptoru dokážu výrazne znížiť hsCRP. To však ešte nedokazuje priaznivý účinok na klinické príhody. Navyše, blokáda dráhy IL-6 môže tlmiť tvorbu CRP aj počas infekcie, takže nízke CRP pri takejto liečbe nemôže samo osebe vylúčiť závažnú infekciu.</p>

<p>Štúdia ZEUS (NCT05021835) zaradila 6 376 pacientov s aterosklerotickým kardiovaskulárnym ochorením, CKD a hsCRP najmenej 2 mg/l. Účastníci dostávali ziltivekimab 15 mg podkožne raz mesačne alebo placebo. Priemerný vek bol 69,5 roka, priemerná eGFR 44,5 ml/min/1,73 m², medián hsCRP 4,5 mg/l; diabetes malo 65,7 % a srdcové zlyhávanie 41,3 % účastníkov. Primárnym ukazovateľom bol trojzložkový MACE — kardiovaskulárne úmrtie, nefatálny infarkt myokardu alebo nefatálna cievna mozgová príhoda. Vopred určený sekundárny renálny ukazovateľ zahŕňal pokles eGFR o viac než 40 %, eGFR pod 15 ml/min/1,73 m², dialýzu, transplantáciu alebo úmrtie z renálnej či kardiovaskulárnej príčiny.</p>

<p><strong>Výsledok už poznáme aspoň na úrovni oficiálne oznámených hlavných údajov.</strong> Dňa 31. júla 2026 spoločnosť Novo Nordisk uviedla, že ziltivekimab dosiahol očakávané zníženie voľného IL-6 a hsCRP, no neznížil výskyt MACE oproti placebu: HR 0,99 (95 % IS 0,88–1,11). Celkový výskyt nežiaducich a závažných nežiaducich udalostí bol podobný, závažné infekcie však boli pri ziltivekimabe častejšie; celková mortalita sa nelíšila.</p>

<p>Tieto údaje sú zásadným varovaním pred zámenou zásahu do biologického cieľa za klinický prínos. Zároveň ich treba hodnotiť primerane: ide o hlavné výsledky oznámené sponzorom, nie o úplnú recenzovanú publikáciu. Číselné výsledky sekundárneho renálneho ukazovateľa zatiaľ zverejnené neboli.</p>

<h3>Baricitinib a inhibícia JAK1/JAK2</h3>

<p>Signalizácia JAK-STAT sprostredkúva účinky viacerých cytokínov. V randomizovanej štúdii fázy 2 u 129 pacientov s diabetom 2. typu a diabetickou chorobou obličiek znížil baricitinib 4 mg denne pomer albumínu ku kreatinínu v moči o 41 % po 24 týždňoch (pomer k východiskovej hodnote 0,59; 95 % IS 0,38–0,93; p = 0,022) a znížil aj viaceré zápalové biomarkery.</p>

<p>Pokles albuminúrie je klinicky relevantný, no v 24-týždňovej štúdii nepredstavuje dôkaz spomalenia zlyhania obličiek. Jedinou nežiaducou udalosťou s rozdielnym výskytom medzi skupinami bola <strong>anémia: 32,0 % pri dávke 4 mg oproti 3,7 % pri placebe</strong>. Pri populácii už ohrozenej anémiou je to dôležitý bezpečnostný signál. Inhibítory JAK majú navyše triedové riziká vrátane infekcií, cytopénií a tromboembolických komplikácií. Baricitinib nie je rutinnou liečbou CKD.</p>

<h3>Selonsertib a inhibícia ASK1</h3>

<p>ASK1 sa aktivuje pri oxidačnom strese a podieľa sa na zápale, apoptóze a fibróze. Štúdia MOSAIC fázy 2b zaradila 310 pacientov s diabetom 2. typu, eGFR 20–59 ml/min/1,73 m² a albuminúriou 150–5 000 mg/g.</p>

<p>Dizajn štúdie zohľadnil, že selonsertib môže inhibíciou tubulárnej sekrécie kreatinínu vyvolať akútny pokles eGFR vypočítanej z kreatinínu bez zodpovedajúcej zmeny skutočnej filtrácie. Preto bol zaradený štvortýždňový úvodný liečebný beh a východisková hodnota pre analýzu sklonu eGFR sa stanovila počas liečby.</p>

<p>Výsledok bol rozporný. Rozdiel v sklone eGFR po 84 týždňoch predstavoval 1,20 ml/min/1,73 m² za rok (95 % IS −0,41 až 2,81; p = 0,14). Protokol použil pre primárny ukazovateľ neobvykle vysokú, vopred určenú obojstrannú hladinu významnosti 0,30, primeranú skôr exploračnému rozhodovaniu vo fáze 2 než potvrdeniu účinnosti. Zároveň <strong>renálne klinické príhody nastali u 17 % pacientov na selonsertibe oproti 12 % na placebe</strong> a incidencia hláseného akútneho poškodenia obličiek bola numericky vyššia (11,0 oproti 5,9 na 100 pacientorokov).</p>

<p>Selonsertib je tak príkladom rozporu medzi náhradným a klinickým ukazovateľom: sklon eGFR sa zlepšil, tvrdé renálne príhody nie. Označiť výsledok jednoducho za „negatívnu štúdiu“ by bolo zjednodušením; presnejšie je povedať, že nepriniesla dostatočne presvedčivý dôkaz čistého klinického prínosu a upozornila na možné riziko.</p>

<h3>Ruboxistaurín a inhibícia proteínkinázy C-β</h3>

<p>Aktivácia proteínkinázy C-β sa podieľa na mikrovaskulárnych komplikáciách diabetu. V 12-mesačnej pilotnej štúdii so 123 účastníkmi s diabetom 2. typu a albuminúriou klesol UACR v ramene s ruboxistaurínom, rozdiely medzi skupinami v zmene UACR ani eGFR však neboli štatisticky významné. Štúdia bola na takéto porovnanie nedostatočne veľká. Ruboxistaurín sa nestal štandardnou liečbou diabetickej choroby obličiek a chýba dôkaz o znížení rizika zlyhania obličiek.</p>

<h3>Bardoxolónmetyl a aktivácia Nrf2</h3>

<p>Bardoxolón aktivuje transkripčný faktor Nrf2 a inhibuje niektoré prozápalové signálne dráhy. V skorších štúdiách zvyšoval eGFR — čo sa vtedy vykladalo ako renoprotekcia.</p>

<p>Štúdia BEACON zaradila 2 185 pacientov s diabetom 2. typu a CKD kategórie G4 (eGFR 15–29 ml/min/1,73 m²). Bola predčasne ukončená na odporúčanie nezávislej komisie po mediáne sledovania 9 mesiacov. Primárny zložený ukazovateľ (zlyhanie obličiek alebo kardiovaskulárne úmrtie) sa vyskytol u 6 % v oboch ramenách: HR 0,98 (95 % IS 0,70–1,37; p = 0,92). Hospitalizácia pre srdcové zlyhávanie alebo úmrtie na srdcové zlyhávanie však nastali u 96 oproti 55 pacientov: <strong>HR 1,83 (95 % IS 1,32–2,55; p &lt; 0,001)</strong>.</p>

<p>Rozhodujúci detail sa často prehliada: pri bardoxolóne stúpla nielen eGFR, ale <strong>aj albuminúria a krvný tlak</strong>. Vzostup eGFR preto nemožno bez ďalších dôkazov stotožniť so zachovaním nefrónov; môže odrážať hemodynamickú zmenu a meraná GFR v neskoršej štúdii TSUBAKI skutočne stúpla. BEACON zostáva varovaním, že priaznivá zmena fyziologického alebo laboratórneho ukazovateľa nezaručuje klinický prínos a môže sprevádzať závažné riziko.</p>

<h3>Pentoxifylín</h3>

<p>Pentoxifylín inhibuje fosfodiesterázu a môže tlmiť tvorbu niektorých cytokínov. Otvorená randomizovaná štúdia PREDIAN zaradila 169 pacientov s diabetom 2. typu a CKD kategórie G3–G4, ktorí už užívali blokádu systému renín-angiotenzín. Po dvoch rokoch klesla eGFR o 2,1 ± 0,4 ml/min/1,73 m² v skupine s pentoxifylínom oproti 6,5 ± 0,4 v kontrolnej skupine (rozdiel 4,3; 95 % IS 3,1–5,5; p &lt; 0,001). Albuminúria klesla o 14,9 %, kým v kontrolnej skupine stúpla o 5,7 %.</p>

<p>Rozsah účinku je pozoruhodný, ale dôkazová sila nie. Išlo o otvorenú štúdiu jedného pracoviska so 169 účastníkmi a bez tvrdých klinických ukazovateľov. Pentoxifylín preto nemožno považovať za náhradu štandardnej renoprotektívnej liečby; je to skôr nezodpovedaná otázka než hotová odpoveď.</p>

<h2>Majú zavedené nefroprotektívne lieky protizápalové účinky?</h2>

<p>Tu je pointa celého prehľadu. Zatiaľ čo priame protizápalové stratégie zlyhávali, lieky, ktoré za protizápalové vôbec nepovažujeme, prinášali jednoznačné klinické výsledky — a zápal ovplyvňujú takisto.</p>

<h3>Inhibítory systému renín-angiotenzín-aldosterón</h3>

<p>ACE inhibítory a sartany znižujú intraglomerulový tlak, albuminúriu a aktivitu angiotenzínu II. Okrem hemodynamického účinku môžu tlmiť oxidačný stres, zápal a fibrózu. Ich klinický prínos je preukázaný, ale nemožno určiť, aká časť účinku je sprostredkovaná protizápalovým pôsobením.</p>

<h3>Inhibítory SGLT2</h3>

<p>Inhibítory SGLT2 znižujú riziko progresie CKD, srdcového zlyhávania a viacerých kardiovaskulárnych príhod. Okrem obnovy tubuloglomerulovej spätnej väzby a priaznivých hemodynamických účinkov môžu znižovať oxidačný stres, aktiváciu inflamazómu a tubulointersticiálny zápal. Protizápalový účinok je pravdepodobne jedným z viacerých mechanizmov, nie jediným vysvetlením klinického prínosu.</p>

<h3>Agonisty receptora GLP-1</h3>

<p>Agonisty receptora GLP-1 znižujú telesnú hmotnosť, glykémiu a riziko aterosklerotických príhod; niektoré majú preukázaný priaznivý vplyv aj na renálne výsledky. Experimentálne a klinické údaje naznačujú redukciu zápalovej signalizácie, endotelovej dysfunkcie a oxidačného stresu. Aj tu platí, že protizápalové pôsobenie je iba jedným z možných mediátorov.</p>

<h3>Nesteroidné antagonisty mineralokortikoidového receptora</h3>

<p>Finerenón znižuje riziko progresie diabetickej choroby obličiek a kardiovaskulárnych príhod. Mineralokortikoidový receptor sa podieľa na zápale a fibróze v obličkách aj v srdci, takže jeho blokáda môže pôsobiť nielen hemodynamicky, ale aj protizápalovo a antifibroticky. Klinickým limitom zostáva riziko hyperkaliémie, najmä pri pokročilej CKD a kombinovanej blokáde systému renín-angiotenzín-aldosterón.</p>

<h2>Zápal pri dialyzačnej liečbe</h2>

<p>U dialyzovaných pacientov je chronický zápal mimoriadne častý. Môže súvisieť s:</p>

<ul>
  <li>infekciou cievneho prístupu,</li>
  <li>tunelizovaným alebo netunelizovaným katétrom,</li>
  <li>biofilmom,</li>
  <li>nedostatočnou biokompatibilitou dialyzátora,</li>
  <li>kontamináciou dialyzačnej vody,</li>
  <li>retenciou tekutín a črevným edémom,</li>
  <li>periodontitídou,</li>
  <li>ischemickými léziami,</li>
  <li>nefunkčným transplantátom,</li>
  <li>malignitou,</li>
  <li>proteínovo-energetickým chradnutím.</li>
</ul>

<p>Zápal zvyšuje koncentráciu hepcidínu, obmedzuje dostupnosť železa pre erytropoézu a znižuje odpoveď na lieky stimulujúce erytropoézu (ESA). Môže preto viesť k funkčnému nedostatku železa a zvýšenej potrebe ESA. Pri nedostatočnej odpovedi však nemožno iba zvyšovať dávku: treba posúdiť zásoby a dostupnosť železa, krvácanie, infekciu, zápal, adekvátnosť dialýzy a ďalšie príčiny anémie.</p>

<p>Zápal súvisí aj s nechutenstvom, katabolizmom a úbytkom telesných bielkovín. Sérový albumín však nie je čistým ukazovateľom výživy: ovplyvňujú ho zápalová odpoveď, hydratácia, syntéza aj straty. Nízku koncentráciu albumínu preto nemožno automaticky pripísať nedostatočnému príjmu bielkovín. Nutričný postup musí zohľadniť štádium CKD, dialyzačnú liečbu, laboratórne výsledky a riziko proteínovo-energetického chradnutia.</p>

<p>Protizápalová liečba dialyzovaného pacienta sa nemá začínať empirickým podaním imunosupresíva. <strong>Najprv treba cielene hľadať ovplyvniteľnú príčinu zápalu</strong>; rozsah mikrobiologických, zobrazovacích či onkologických vyšetrení sa má riadiť anamnézou, klinickým nálezom a vývojom laboratórnych hodnôt, nie automaticky jedinou mierne zvýšenou hodnotou CRP.</p>

<h2>Fakt, asociácia, hypotéza a neistota</h2>

<h3>Dostatočne podložené</h3>

<ul>
  <li>CKD je často sprevádzaná systémovým a lokálnym zápalom.</li>
  <li>Vyššie zápalové biomarkery sú spojené s progresiou CKD, kardiovaskulárnymi príhodami a mortalitou.</li>
  <li>Niektoré zavedené renoprotektívne lieky majú protizápalové vlastnosti.</li>
  <li>Cielená blokáda zápalových dráh dokáže výrazne meniť zápalové biomarkery.</li>
  <li>Blokáda IL-1β znižuje výskyt aterosklerotických príhod u pacientov po infarkte so zvýšeným hsCRP — za cenu vyššieho rizika fatálnych infekcií.</li>
  <li>V štúdii ZEUS blokáda IL-6 znížila voľný IL-6 a hsCRP, ale podľa oznámených hlavných výsledkov neznížila MACE.</li>
</ul>

<h3>Pravdepodobné, ale nie úplne dokázané</h3>

<ul>
  <li>Protizápalové pôsobenie môže čiastočne sprostredkovať klinický prínos inhibítorov SGLT2, agonistov receptora GLP-1, finerenónu a blokátorov systému renín-angiotenzín-aldosterón.</li>
  <li>Niektoré zápalové dráhy môžu byť vhodnými cieľmi vo vybraných populáciách, ale cieľ aj populácia musia byť overené samostatne; výsledok ZEUS ukazuje, že ani biologicky účinná blokáda IL-6 nezaručuje kardiovaskulárny prínos.</li>
</ul>

<h3>Nepreukázané alebo neprimerane silné tvrdenia</h3>

<ul>
  <li>Každé zvýšenie hsCRP je dôkazom aktívneho poškodzovania obličiek.</li>
  <li>Zníženie CRP automaticky vedie k zlepšeniu prognózy.</li>
  <li>Nešpecifická protizápalová liečba je vhodná pre všetkých pacientov s CKD.</li>
  <li>Experimentálne protizápalové lieky môžu nahradiť etablovanú renoprotektívnu liečbu.</li>
  <li>Zvýšenie eGFR počas liečby vždy znamená zachovanie nefrónov.</li>
</ul>

<h2>Praktický postup pri pretrvávajúcom zápale</h2>

<p>Pri opakovane zvýšenom CRP alebo inom podozrení na systémový zápal je vhodné posúdiť:</p>

<ol>
  <li>akútnu alebo chronickú infekciu,</li>
  <li>cievny prístup a prípadný biofilm,</li>
  <li>periodontálny a kožný nález,</li>
  <li>objemové preťaženie a srdcové zlyhávanie,</li>
  <li>malignitu a autoimunitné ochorenie,</li>
  <li>nutričný stav a stratu svalovej hmoty,</li>
  <li>metabolickú aktivitu spojenú s diabetom a obezitou,</li>
  <li>funkčnú dostupnosť železa a odpoveď na ESA,</li>
  <li>kvalitu dialyzačnej vody a biokompatibilitu liečby,</li>
  <li>vývoj hodnôt v čase, nie iba jedno laboratórne meranie.</li>
</ol>

<p>Rutinné podávanie priamej protizápalovej liečby iba na základe zvýšeného hsCRP nemožno v súčasnosti odporučiť.</p>

<p>Pri pokročilej CKD, dialýze, po transplantácii, pri opakovaných infekciách, cytopénii alebo výraznej krehkosti je prenos výsledkov z iných populácií obzvlášť neistý. Použitie protizápalového lieku na inú schválenú indikáciu nie je totožné s jeho použitím na prevenciu progresie CKD.</p>

<h2>Záver</h2>

<p>Chronický zápal je dôležitou súčasťou patofyziológie chronickej choroby obličiek a jej kardiovaskulárnych komplikácií. Jeho prognostický význam je dobre doložený, ale prechod od biomarkera k bezpečnému terapeutickému cieľu zostáva náročný.</p>

<p>Doterajšie pokusy ukazujú, prečo sa biologický účinok nesmie zamieňať s klinickým prínosom. Bardoxolón zvýšil eGFR, no nezlepšil primárny klinický výsledok a zvýšil riziko srdcového zlyhávania. Selonsertib priaznivo ovplyvnil sklon eGFR pri exploračnom štatistickom prahu, ale renálne príhody aj hlásené AKI boli numericky častejšie. Baricitinib znížil albuminúriu, no anémia bola pri dávke 4 mg podstatne častejšia. Kanakinumab naopak preukázal mierne zníženie aterosklerotických príhod bez poklesu celkovej mortality a s vyšším výskytom fatálnych infekcií. Ziltivekimab znížil voľný IL-6 a hsCRP, ale podľa hlavných výsledkov ZEUS neznížil MACE.</p>

<p>Najsilnejšie klinické dôkazy zostávajú pri liekoch, ktoré primárne nepovažujeme za protizápalové, ale popri hemodynamických a metabolických účinkoch tlmia aj zápal a fibrózu: blokátory systému renín-angiotenzín-aldosterón, inhibítory SGLT2, agonisty receptora GLP-1 a finerenón.</p>

<p>Budúcnosť pravdepodobne nespočíva v plošnom potláčaní imunity, ale vo výbere pacientov podľa konkrétnej zápalovej dráhy, etiológie CKD, biomarkerového profilu a individuálneho pomeru prínosu a rizika. Negatívny hlavný výsledok ZEUS túto potrebu ešte zvýrazňuje. Kým ďalšie štúdie nepreukážu klinický prínos a prijateľnú bezpečnosť, zvýšený hsCRP zostáva informáciou, ktorú treba interpretovať v kontexte, nie samostatnou indikáciou na liečbu.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=pentoxifylin-diabeticka-choroba-obliciek-mini-review">Pentoxifylín pri diabetickej chorobe obličiek</a> — podrobnejšie k dôkazovej báze.</li>
  <li><a href="article.php?slug=zapalove-markery-crp-esr-pv">Zápalové markery: CRP, ESR a plazmatická viskozita</a> — čo v skutočnosti merajú.</li>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Štyri piliere liečby CKD a hranice dôkazov</a> — kde stoja etablované liečivá.</li>
  <li><a href="article.php?slug=finerenon-nefroprotekcia-ckd-3-4-bez-ohladu-na-diabetes">Finerenón a nefroprotekcia pri CKD G3–G4</a> — antifibrotický a protizápalový rozmer blokády MR.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Katherine R. Tuttle, Mehmet Kanbay, Radica Z. Alicic, Juan Jesus Carrero, Sidar Copur, Ann Marie Navar, Brendon L. Neuen, Vlado Perkovic, Peter Rossing, Nikolaus Marx, Paul M. Ridker.</strong> <em>Inflammation as a therapeutic target to improve kidney and cardiovascular outcomes.</em> Nature Reviews Nephrology. Publikované 4. septembra 2026. <a href="https://doi.org/10.1038/s41581-026-01117-6" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Paul M. Ridker, Brendan M. Everett, Tom Thuren, Jean G. MacFadyen a spol. (CANTOS).</strong> <em>Antiinflammatory Therapy with Canakinumab for Atherosclerotic Disease.</em> New England Journal of Medicine. 2017;377(12):1119–1131. <a href="https://doi.org/10.1056/NEJMoa1707914" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Paul M. Ridker, Florian M. M. Baeres, Anders Hveplund, Mads M. D. Engelmann, G. Kees Hovingh, A. Michael Lincoff, Nikolaus Marx, Ann Marie Navar, Naveed Sattar, Katherine Tuttle, Vlado Perkovic.</strong> <em>Rationale, Design, and Baseline Clinical Characteristics of the Ziltivekimab Cardiovascular Outcomes Trial (ZEUS).</em> JAMA Cardiology. 2026;11(1):89–97. <a href="https://doi.org/10.1001/jamacardio.2025.4491" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Novo Nordisk.</strong> <em>Novo Nordisk provides update on the ZEUS phase 3 trial in people with ASCVD, CKD and inflammation.</em> Oznámenie hlavných výsledkov z 31. júla 2026. <a href="https://www.novonordisk.com/news-and-media/news-and-ir-materials/news-details.html?id=916587" target="_blank" rel="noopener noreferrer">Zdroj</a>.</li>
  <li><strong>Dick de Zeeuw, Tadao Akizawa, Paul Audhya, George L. Bakris a spol. (BEACON).</strong> <em>Bardoxolone Methyl in Type 2 Diabetes and Stage 4 Chronic Kidney Disease.</em> New England Journal of Medicine. 2013;369(26):2492–2503. <a href="https://doi.org/10.1056/NEJMoa1306033" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Masaomi Nangaku, Hironori Kanda, Hirotaka Takama, Tomohiro Ichikawa, Hiroki Hase, Tadao Akizawa (TSUBAKI).</strong> <em>Randomized Clinical Trial on the Effect of Bardoxolone Methyl on GFR in Diabetic Kidney Disease Patients.</em> Kidney International Reports. 2020;5(6):879–890. <a href="https://doi.org/10.1016/j.ekir.2020.03.030" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Hiddo J. L. Heerspink, Vlado Perkovic, Katherine R. Tuttle, Pablo E. Pergola a spol. (MOSAIC).</strong> <em>Selonsertib in Patients with Diabetic Kidney Disease: A Phase 2b Randomized Active Run-In Clinical Trial.</em> Journal of the American Society of Nephrology. 2024;35(12):1726–1736. <a href="https://doi.org/10.1681/ASN.0000000000000444" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Katherine R. Tuttle, Frank C. Brosius, Sharon G. Adler, Matthias Kretzler a spol.</strong> <em>JAK1/JAK2 inhibition by baricitinib in diabetic kidney disease: results from a Phase 2 randomized controlled clinical trial.</em> Nephrology Dialysis Transplantation. 2018;33(11):1950–1959. <a href="https://doi.org/10.1093/ndt/gfx377" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Katherine R. Tuttle, George L. Bakris, Robert D. Toto, Janet B. McGill, Kuolung Hu, Pamela W. Anderson.</strong> <em>The Effect of Ruboxistaurin on Nephropathy in Type 2 Diabetes.</em> Diabetes Care. 2005;28(11):2686–2690. <a href="https://doi.org/10.2337/diacare.28.11.2686" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Juan F. Navarro-González, Carmen Mora-Fernández, Mercedes Muros de Fuentes, Jesús Chahin a spol. (PREDIAN).</strong> <em>Effect of Pentoxifylline on Renal Function and Urinary Albumin Excretion in Patients with Diabetic Kidney Disease.</em> Journal of the American Society of Nephrology. 2015;26(1):220–229. <a href="https://doi.org/10.1681/ASN.2014010012" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Joachim Jankowski, Jürgen Floege, Danilo Fliser, Michael Böhm, Nikolaus Marx.</strong> <em>Cardiovascular Disease in Chronic Kidney Disease: Pathophysiological Insights and Therapeutic Options.</em> Circulation. 2021;143(11):1157–1172. <a href="https://doi.org/10.1161/CIRCULATIONAHA.120.050686" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Xiejia Li, Bengt Lindholm.</strong> <em>Cardiovascular Risk Prediction in Chronic Kidney Disease.</em> American Journal of Nephrology. 2022;53(10):730–739. <a href="https://doi.org/10.1159/000528560" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Marcello Tonelli, Frank Sacks, Marc Pfeffer, Gian S. Jhangri, Gary Curhan.</strong> <em>Biomarkers of inflammation and progression of chronic kidney disease.</em> Kidney International. 2005;68(1):237–245. <a href="https://doi.org/10.1111/j.1523-1755.2005.00398.x" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Christiaan L. Meuwese, Peter Stenvinkel, Friedo W. Dekker, Juan J. Carrero.</strong> <em>Monitoring of inflammation in patients on dialysis: forewarned is forearmed.</em> Nature Reviews Nephrology. 2011;7(3):166–176. <a href="https://doi.org/10.1038/nrneph.2011.2" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Kamyar Kalantar-Zadeh, T. Alp Ikizler, Gladys Block, Morrel M. Avram, Joel D. Kopple.</strong> <em>Malnutrition-inflammation complex syndrome in dialysis patients: causes and consequences.</em> American Journal of Kidney Diseases. 2003;42(5):864–881. <a href="https://doi.org/10.1016/j.ajkd.2003.07.016" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Carmine Zoccali, Giovanni Tripepi, Francesca Mallamaci.</strong> <em>Dissecting Inflammation in ESRD: Do Cytokines and C-Reactive Protein Have a Complementary Prognostic Value for Mortality in Dialysis Patients?</em> Journal of the American Society of Nephrology. 2006;17(12 Suppl 3):S169–S173. <a href="https://doi.org/10.1681/ASN.2006080910" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Yu-Ming Chen, Shuei-Liong Lin, Wen-Chih Chiang, Kwan-Dun Wu, Tun-Jun Tsai.</strong> <em>Pentoxifylline ameliorates proteinuria through suppression of renal monocyte chemoattractant protein-1 in patients with proteinuric primary glomerular diseases.</em> Kidney International. 2006;69(8):1410–1415. <a href="https://doi.org/10.1038/sj.ki.5000302" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje zo štúdií CANTOS, BEACON, MOSAIC, baricitinibu, PREDIAN a z protokolu ZEUS boli skontrolované podľa ich primárnych publikácií. Údaj, že bardoxolón zvýšil aj meranú GFR, pochádza zo štúdie TSUBAKI; nepreukazuje však zlepšenie tvrdých klinických výsledkov. Pre ZEUS boli k 13. septembru 2026 verejne dostupné iba hlavné výsledky oznámené sponzorom: MACE HR 0,99 (95 % IS 0,88–1,11), bez rozdielu v celkovej mortalite a s častejšími závažnými infekciami pri ziltivekimabe. Úplná recenzovaná publikácia a číselné výsledky sekundárneho renálneho ukazovateľa zatiaľ neboli zverejnené. Závery o klinickom prínose preto nemožno rozširovať nad rámec dostupných údajov.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky_article',
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
