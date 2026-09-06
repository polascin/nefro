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
    'title'        => 'Zápal ako terapeutický cieľ pri chronickej chorobe obličiek: cesta k lepším renálnym a kardiovaskulárnym výsledkom?',
    'slug'         => 'zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prognostický význam zápalu pri CKD je dobre doložený. Prechod od biomarkera k bezpečnému terapeutickému cieľu však zlyhal už päťkrát. Čo ukázali CANTOS, BEACON, MOSAIC, PREDIAN a čo má rozhodnúť štúdia ZEUS.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Že je chronická choroba obličiek zápalovým stavom, vieme desaťročia. Otázka nikdy nebola, či zápal s prognózou súvisí — ale či ho oplatí liečiť. Prehľad v Nature Reviews Nephrology zhŕňa doterajšie pokusy. Ich spoločným menovateľom je poučný rozpor: biomarkery sa poslušne zlepšovali, klinické výsledky nie.</em></p>

<p>Chronická choroba obličiek nie je iba dôsledkom straty nefrónov a poruchy vylučovacej funkcie. Je to systémové ochorenie sprevádzané aktiváciou vrodenej aj adaptívnej imunity, oxidačným stresom, endotelovou dysfunkciou, poruchou metabolizmu a chronickým nízkostupňovým zápalom.</p>

<p>Zápal môže súčasne pôsobiť ako:</p>

<ul>
  <li>dôsledok zníženej funkcie obličiek,</li>
  <li>mechanizmus ďalšieho poškodzovania obličkového parenchýmu,</li>
  <li>urýchľovač aterosklerózy a srdcového zlyhávania,</li>
  <li>faktor anémie, kachexie a proteínovo-energetického chradnutia,</li>
  <li>ukazovateľ infekcie, komorbidity alebo nedostatočnej biokompatibility dialyzačnej liečby.</li>
</ul>

<p>Prehľad publikovaný 4. septembra 2026 v časopise <em>Nature Reviews Nephrology</em> preto hodnotí zápal nielen ako prognostický ukazovateľ, ale aj ako možný terapeutický cieľ. Zásadná otázka znie: dokáže priame potlačenie zápalu skutočne spomaliť progresiu chronickej choroby obličiek a znížiť kardiovaskulárnu mortalitu bez neprimeraného zvýšenia infekčných a ďalších rizík?</p>

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

<p>Zápal však nie je jednotný proces. Rozdielne ochorenia obličiek majú odlišné zápalové mechanizmy. Preto nemožno očakávať, že jedno všeobecné protizápalové liečivo bude rovnako účinné pri diabetickej chorobe obličiek, IgA nefropatii, ischemickej nefropatii aj u dialyzovaných pacientov. <strong>Práve táto heterogenita je pravdepodobne hlavným dôvodom doterajších neúspechov.</strong></p>

<h2>Vysokosenzitívny CRP: užitočný ukazovateľ, nie samostatný terapeutický cieľ</h2>

<p>Vysokosenzitívny C-reaktívny proteín (hsCRP) je dostupný biomarker systémového zápalu. Vyššie hodnoty sa pri chronickej chorobe obličiek spájajú s:</p>

<ul>
  <li>rýchlejším poklesom funkcie obličiek,</li>
  <li>vyšším rizikom zlyhania obličiek,</li>
  <li>aterosklerotickými kardiovaskulárnymi príhodami,</li>
  <li>srdcovým zlyhávaním,</li>
  <li>celkovou a kardiovaskulárnou mortalitou.</li>
</ul>

<p>Ide však prevažne o <strong>prognostickú asociáciu</strong>. Zvýšený hsCRP môže byť markerom infekcie, obezity, malnutrície, srdcového zlyhávania, poškodenia tkanív alebo iného základného procesu. Samotný pokles hsCRP preto automaticky neznamená zlepšenie klinickej prognózy — a nižšie uvedené štúdie to ukazujú veľmi názorne.</p>

<p>Jednorazové meranie má navyše obmedzenú výpovednú hodnotu. Najmä pri hemodialýze môže koncentrácia CRP výrazne kolísať v závislosti od akútnej infekcie, problémov s cievnym prístupom, retencie tekutín alebo inej interkurentnej udalosti.</p>

<p>V súčasnosti nie je dostatok dôkazov na používanie hsCRP ako univerzálneho liečebného cieľa pri CKD. Jeho zvýšenie má byť predovšetkým podnetom na hľadanie príčiny a na komplexné posúdenie rizika.</p>

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

<h2>Priame protizápalové stratégie: prehľad výsledkov</h2>

<p>Nasledujúca tabuľka zhŕňa to, čo sa v tejto oblasti skutočne odskúšalo — a s akým výsledkom:</p>

<div class="table-responsive" role="region" aria-label="Prehľad kľúčových štúdií priamej protizápalovej liečby" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liečivo / cieľ</th>
        <th scope="col">Štúdia</th>
        <th scope="col">Hlavný výsledok</th>
        <th scope="col">Cena</th>
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
        <td>Prebieha; primárny ukazovateľ trojzložkový MACE</td>
        <td>Zatiaľ neznáma</td>
      </tr>
    </tbody>
  </table>
</div>

<h3>Inhibícia interleukínu 1β</h3>

<p>Interleukín 1β patrí medzi kľúčové cytokíny vrodenej imunity. Štúdia CANTOS zaradila 10 061 pacientov po infarkte myokardu s hsCRP najmenej 2 mg/l. Kanakinumab v dávke 150 mg podkožne každé tri mesiace znížil výskyt primárneho kardiovaskulárneho ukazovateľa: HR 0,85 (95 % IS 0,74–0,98; p = 0,021). Dávka 50 mg účinok nemala.</p>

<p>Dva detaily robia z tejto štúdie základný kameň celej hypotézy. Po prvé, kanakinumab <strong>vôbec neovplyvnil lipidy</strong> — účinok teda musel ísť cez zápal. Po druhé, hsCRP klesol dávkovo závisle o 26, 37 a 41 percentuálnych bodov oproti placebu, čo dokladá zásah do cieľovej dráhy.</p>

<p>Cena však bola reálna: vyšší výskyt fatálnych infekcií a <strong>žiadny rozdiel v celkovej mortalite</strong> (HR 0,94; 95 % IS 0,83–1,06). CANTOS teda potvrdila, že zápal je kauzálne ovplyvniteľnou súčasťou reziduálneho kardiovaskulárneho rizika — nepreukázala však, že blokáda IL-1β je renoprotektívnou liečbou CKD. Renálne analýzy boli sekundárne a kanakinumab takúto indikáciu nemá.</p>

<h3>Inhibícia interleukínu 6</h3>

<p>Interleukín 6 stimuluje pečeňovú syntézu CRP a podieľa sa na aterogenéze, anémii, svalovom katabolizme a poruche metabolizmu železa. Vyššie koncentrácie IL-6 sa spájajú s nepriaznivými renálnymi a kardiovaskulárnymi výsledkami.</p>

<p>Monoklonálne protilátky proti IL-6 alebo jeho receptoru dokážu výrazne znížiť hsCRP. Zatiaľ však nie je preukázané, že táto stratégia bezpečne znižuje riziko zlyhania obličiek alebo úmrtia u pacientov s CKD.</p>

<p><strong>Odpoveď má priniesť štúdia ZEUS</strong> (NCT05021835). Zaradila 6 376 pacientov s aterosklerotickým kardiovaskulárnym ochorením, CKD a hsCRP najmenej 2 mg/l, randomizovaných na ziltivekimab 15 mg podkožne mesačne alebo placebo. Ide o populáciu, ktorá zodpovedá reálnej nefrologickej ambulancii: priemerný vek 69,5 roka, priemerná eGFR 44,5 ml/min/1,73 m², medián hsCRP 4,5 mg/l, 65,7 % s diabetom a 41,3 % so srdcovým zlyhávaním. Primárnym ukazovateľom je trojzložkový MACE, pričom <strong>sekundárny renálny ukazovateľ</strong> zahŕňa pokles eGFR o viac než 40 %, zlyhanie obličiek, dialýzu, transplantáciu a úmrtie z renálnych alebo kardiovaskulárnych príčin.</p>

<p>ZEUS je teda prvou veľkou štúdiou, ktorá testuje protizápalovú liečbu priamo v populácii s CKD a s renálnym ukazovateľom v protokole. Do jej publikovania zostáva táto oblasť hypotézou.</p>

<h3>Baricitinib a inhibícia JAK1/JAK2</h3>

<p>Signalizácia JAK-STAT sprostredkúva účinky viacerých cytokínov. V randomizovanej štúdii fázy 2 u 129 pacientov s diabetom 2. typu a diabetickou chorobou obličiek znížil baricitinib 4 mg denne pomer albumínu ku kreatinínu v moči o 41 % po 24 týždňoch (pomer k východiskovej hodnote 0,59; 95 % IS 0,38–0,93; p = 0,022) a znížil aj viaceré zápalové biomarkery.</p>

<p>Pokles albuminúrie je klinicky relevantný, no v 24-týždňovej štúdii nepredstavuje dôkaz spomalenia zlyhania obličiek. Bezpečnostný signál bol pritom výrazný: <strong>anémia sa vyskytla u 32,0 % pacientov na dávke 4 mg oproti 3,7 % pri placebe</strong> — čo je pri populácii, ktorá je anémiou ohrozená už zo svojej podstaty, obzvlášť nepríjemné. Inhibítory JAK navyše zvyšujú riziko infekcií, cytopénií a tromboembolických komplikácií. V nefrologickej praxi preto nejde o rutinnú liečbu CKD.</p>

<h3>Selonsertib a inhibícia ASK1</h3>

<p>ASK1 sa aktivuje pri oxidačnom strese a podieľa sa na zápale, apoptóze a fibróze. Štúdia MOSAIC fázy 2b zaradila 310 pacientov s diabetom 2. typu, eGFR 20 – 59 ml/min/1,73 m² a albuminúriou 150 – 5 000 mg/g.</p>

<p>Dizajn štúdie sám osebe hovorí veľa. Selonsertib <strong>akútne znižuje sérový kreatinín</strong>, a tým zdanlivo zvyšuje eGFR, preto musel byť zaradený štvortýždňový úvodný liečebný beh na stanovenie východiskovej hodnoty počas liečby. Ide o zrkadlový obraz problému s bardoxolónom — s tým rozdielom, že tu bol artefakt vopred rozpoznaný a metodicky ošetrený.</p>

<p>Výsledok bol rozporný. Rozdiel v sklone eGFR po 84 týždňoch predstavoval 1,20 ml/min/1,73 m² za rok (95 % IS −0,41 až 2,81; p = 0,14) — pri vopred stanovenej hladine významnosti α = 0,30, teda pri mimoriadne benevolentnom prahu. Zároveň však <strong>renálne klinické príhody nastali u 17 % pacientov na selonsertibe oproti 12 % na placebe</strong> a hlásená incidencia akútneho poškodenia obličiek bola takmer dvojnásobná (11,0 oproti 5,9 na 100 pacientorokov).</p>

<p>Selonsertib je tak učebnicovým príkladom rozporu medzi náhradným a klinickým ukazovateľom: sklon eGFR sa zlepšil, tvrdé renálne príhody nie. Označiť to jednoducho za „negatívnu štúdiu“ by bolo zjednodušením; presnejšie je povedať, že štúdia nepreukázala prínos a upozornila na možné riziko.</p>

<h3>Ruboxistaurín a inhibícia proteínkinázy C-β</h3>

<p>Aktivácia proteínkinázy C-β sa podieľa na mikrovaskulárnych komplikáciách diabetu. Ruboxistaurín vykazoval možné priaznivé účinky na albuminúriu a niektoré diabetické komplikácie, ale nedosiahol postavenie štandardnej liečby diabetickej choroby obličiek. Chýba dostatočný dôkaz o znížení rizika zlyhania obličiek.</p>

<h3>Bardoxolónmetyl a aktivácia Nrf2</h3>

<p>Bardoxolón aktivuje transkripčný faktor Nrf2 a inhibuje niektoré prozápalové signálne dráhy. V skorších štúdiách zvyšoval eGFR — čo sa vtedy vykladalo ako renoprotekcia.</p>

<p>Štúdia BEACON zaradila 2 185 pacientov s diabetom 2. typu a CKD kategórie G4 (eGFR 15 – 29 ml/min/1,73 m²). Bola predčasne ukončená na odporúčanie nezávislej komisie po mediáne sledovania 9 mesiacov. Primárny zložený ukazovateľ (zlyhanie obličiek alebo kardiovaskulárne úmrtie) sa vyskytol u 6 % v oboch ramenách: HR 0,98 (95 % IS 0,70–1,37; p = 0,92). Hospitalizácia pre srdcové zlyhávanie alebo úmrtie na srdcové zlyhávanie však nastali u 96 oproti 55 pacientov: <strong>HR 1,83 (95 % IS 1,32–2,55; p &lt; 0,001)</strong>.</p>

<p>Rozhodujúci detail sa často prehliada: pri bardoxolóne stúpla nielen eGFR, ale <strong>aj albuminúria a krvný tlak</strong>. Vzostup eGFR teda takmer isto odrážal hemodynamickú, hyperfiltračnú zmenu, nie zachovanie nefrónov. BEACON je preto trvalým varovaním pred stotožňovaním krátkodobého vzostupu eGFR s renoprotekciou.</p>

<h3>Pentoxifylín</h3>

<p>Pentoxifylín inhibuje fosfodiesterázu a môže tlmiť tvorbu niektorých cytokínov. Otvorená randomizovaná štúdia PREDIAN zaradila 169 pacientov s diabetom 2. typu a CKD kategórie G3 – G4, ktorí už užívali blokádu systému renín-angiotenzín. Po dvoch rokoch klesla eGFR o 2,1 ± 0,4 ml/min/1,73 m² v skupine s pentoxifylínom oproti 6,5 ± 0,4 v kontrolnej skupine (rozdiel 4,3; 95 % IS 3,1 – 5,5; p &lt; 0,001). Albuminúria klesla o 14,9 %, kým v kontrolnej skupine stúpla o 5,7 %.</p>

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

<p>Zápal zvyšuje koncentráciu hepcidínu, obmedzuje dostupnosť železa pre erytropoézu a znižuje odpoveď na látky stimulujúce erytropoézu (ESA). Môže preto viesť k funkčnému nedostatku železa a zvýšenej potrebe ESA.</p>

<p>Protizápalová liečba dialyzovaného pacienta sa nemá začínať empirickým podaním imunosupresíva. <strong>Najprv treba hľadať a odstrániť konkrétnu príčinu zápalu</strong> — a v tejto populácii je príčina spravidla nájditeľná.</p>

<h2>Fakt, asociácia, hypotéza a neistota</h2>

<h3>Dostatočne podložené</h3>

<ul>
  <li>CKD je často sprevádzaná systémovým a lokálnym zápalom.</li>
  <li>Vyššie zápalové biomarkery sú spojené s progresiou CKD, kardiovaskulárnymi príhodami a mortalitou.</li>
  <li>Niektoré zavedené renoprotektívne lieky majú protizápalové vlastnosti.</li>
  <li>Cielená blokáda zápalových dráh dokáže výrazne meniť zápalové biomarkery.</li>
  <li>Blokáda IL-1β znižuje výskyt aterosklerotických príhod u pacientov po infarkte so zvýšeným hsCRP — za cenu vyššieho rizika fatálnych infekcií.</li>
</ul>

<h3>Pravdepodobné, ale nie úplne dokázané</h3>

<ul>
  <li>Protizápalové pôsobenie môže čiastočne sprostredkovať klinický prínos inhibítorov SGLT2, agonistov receptora GLP-1, finerenónu a blokátorov systému renín-angiotenzín-aldosterón.</li>
  <li>IL-1β, IL-6 a ďalšie zápalové dráhy môžu byť vhodnými cieľmi u vybraných pacientov s reziduálnym zápalovým rizikom.</li>
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

<h2>Záver</h2>

<p>Chronický zápal je dôležitou súčasťou patofyziológie chronickej choroby obličiek a jej kardiovaskulárnych komplikácií. Jeho prognostický význam je dobre doložený, ale prechod od biomarkera k bezpečnému terapeutickému cieľu zostáva náročný.</p>

<p>Doterajšie pokusy majú spoločnú štruktúru zlyhania: <strong>biomarker sa zlepšil, klinický výsledok nie</strong>. Bardoxolón zvýšil eGFR a zhoršil srdcové zlyhávanie. Selonsertib spomalil sklon eGFR a zvýšil počet renálnych príhod. Baricitinib znížil albuminúriu a vyvolal anémiu u tretiny liečených. Kanakinumab znížil kardiovaskulárne príhody, ale nie celkovú mortalitu. Táto opakujúca sa schéma je hlavným poučením celej oblasti.</p>

<p>Najsilnejšie klinické dôkazy zostávajú pri liekoch, ktoré primárne nepovažujeme za protizápalové, ale popri hemodynamických a metabolických účinkoch tlmia aj zápal a fibrózu: blokátory systému renín-angiotenzín-aldosterón, inhibítory SGLT2, agonisty receptora GLP-1 a finerenón.</p>

<p>Budúcnosť pravdepodobne nespočíva v plošnom potláčaní imunity, ale vo výbere pacientov podľa konkrétnej zápalovej dráhy, etiológie CKD, biomarkerového profilu a individuálneho pomeru prínosu a rizika. Prvou skutočnou skúškou tohto prístupu v nefrológii bude štúdia ZEUS.</p>

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
  <li><strong>Dick de Zeeuw, Tadao Akizawa, Paul Audhya, George L. Bakris a spol. (BEACON).</strong> <em>Bardoxolone Methyl in Type 2 Diabetes and Stage 4 Chronic Kidney Disease.</em> New England Journal of Medicine. 2013;369(26):2492–2503. <a href="https://doi.org/10.1056/NEJMoa1306033" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Hiddo J. L. Heerspink, Vlado Perkovic, Katherine R. Tuttle, Pablo E. Pergola a spol. (MOSAIC).</strong> <em>Selonsertib in Patients with Diabetic Kidney Disease: A Phase 2b Randomized Active Run-In Clinical Trial.</em> Journal of the American Society of Nephrology. 2024;35(12):1726–1736. <a href="https://doi.org/10.1681/ASN.0000000000000444" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Katherine R. Tuttle, Frank C. Brosius, Sharon G. Adler, Matthias Kretzler a spol.</strong> <em>JAK1/JAK2 inhibition by baricitinib in diabetic kidney disease: results from a Phase 2 randomized controlled clinical trial.</em> Nephrology Dialysis Transplantation. 2018;33(11):1950–1959. <a href="https://doi.org/10.1093/ndt/gfx377" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Juan F. Navarro-González, Carmen Mora-Fernández, Mercedes Muros de Fuentes, Jesús Chahin a spol. (PREDIAN).</strong> <em>Effect of Pentoxifylline on Renal Function and Urinary Albumin Excretion in Patients with Diabetic Kidney Disease.</em> Journal of the American Society of Nephrology. 2015;26(1):220–229. <a href="https://doi.org/10.1681/ASN.2014010012" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Joachim Jankowski, Jürgen Floege, Danilo Fliser, Michael Böhm, Nikolaus Marx.</strong> <em>Cardiovascular Disease in Chronic Kidney Disease: Pathophysiological Insights and Therapeutic Options.</em> Circulation. 2021;143(11):1157–1172. <a href="https://doi.org/10.1161/CIRCULATIONAHA.120.050686" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Xiejia Li, Bengt Lindholm.</strong> <em>Cardiovascular Risk Prediction in Chronic Kidney Disease.</em> American Journal of Nephrology. 2022;53(10):730–739. <a href="https://doi.org/10.1159/000528560" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Marcello Tonelli, Frank Sacks, Marc Pfeffer, Gian S. Jhangri, Gary Curhan.</strong> <em>Biomarkers of inflammation and progression of chronic kidney disease.</em> Kidney International. 2005;68(1):237–245. <a href="https://doi.org/10.1111/j.1523-1755.2005.00398.x" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Christiaan L. Meuwese, Peter Stenvinkel, Friedo W. Dekker, Juan J. Carrero.</strong> <em>Monitoring of inflammation in patients on dialysis: forewarned is forearmed.</em> Nature Reviews Nephrology. 2011;7(3):166–176. <a href="https://doi.org/10.1038/nrneph.2011.2" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Kamyar Kalantar-Zadeh, T. Alp Ikizler, Gladys Block, Morrel M. Avram, Joel D. Kopple.</strong> <em>Malnutrition-inflammation complex syndrome in dialysis patients: causes and consequences.</em> American Journal of Kidney Diseases. 2003;42(5):864–881. <a href="https://doi.org/10.1016/j.ajkd.2003.07.016" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Carmine Zoccali, Giovanni Tripepi, Francesca Mallamaci.</strong> <em>Dissecting Inflammation in ESRD: Do Cytokines and C-Reactive Protein Have a Complementary Prognostic Value for Mortality in Dialysis Patients?</em> Journal of the American Society of Nephrology. 2006;17(12 Suppl 3):S169–S173. <a href="https://doi.org/10.1681/ASN.2006080910" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Yu-Ming Chen, Shuei-Liong Lin, Wen-Chih Chiang, Kwan-Dun Wu, Tun-Jun Tsai.</strong> <em>Pentoxifylline ameliorates proteinuria through suppression of renal monocyte chemoattractant protein-1 in patients with proteinuric primary glomerular diseases.</em> Kidney International. 2006;69(8):1410–1415. <a href="https://doi.org/10.1038/sj.ki.5000302" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje jednotlivých štúdií — CANTOS (10 061 pacientov, HR 0,85 [0,74–0,98] pri 150 mg, HR 0,93 a 0,86 pri 50 a 300 mg, pokles hsCRP o 26/37/41 percentuálnych bodov, celková mortalita HR 0,94 [0,83–1,06]), BEACON (2 185 pacientov, HR 0,98 [0,70–1,37], srdcové zlyhávanie HR 1,83 [1,32–2,55], vzostup eGFR, UACR aj krvného tlaku, medián sledovania 9 mesiacov), MOSAIC (310 pacientov, sklon eGFR 1,20 [−0,41 až 2,81] pri α = 0,30, renálne príhody 17 % oproti 12 %, AKI 11,0 oproti 5,9 na 100 pacientorokov, štvortýždňový úvodný liečebný beh), baricitinib (129 pacientov, pomer UACR 0,59 [0,38–0,93], p = 0,022, anémia 32,0 % oproti 3,7 %), PREDIAN (169 pacientov, pokles eGFR 2,1 ± 0,4 oproti 6,5 ± 0,4, rozdiel 4,3 [3,1 – 5,5], albuminúria −14,9 % oproti +5,7 %) a ZEUS (6 376 pacientov, ziltivekimab 15 mg mesačne, hsCRP ≥ 2 mg/l, priemerná eGFR 44,5, medián hsCRP 4,5 mg/l, 65,7 % diabetes, 41,3 % srdcové zlyhávanie, NCT05021835) — boli overené proti abstraktom príslušných prác v zázname PubMed. Bibliografia bola overená cez Crossref a PubMed. <strong>Opravy oproti pôvodnému spracovaniu:</strong> autorský kolektív prehľadu v Nature Reviews Nephrology má jedenásť členov (uvedení boli štyria); v citáciách boli opravené mená Xiejia Li a Gian S. Jhangri. Tvrdenie, že klinické programy selonsertibu „nepriniesli presvedčivý dôkaz renálneho prínosu“, bolo nahradené konkrétnym výsledkom štúdie MOSAIC, ktorá sklon eGFR spomalila, ale zaznamenala viac renálnych príhod. Doplnená bola prebiehajúca štúdia ZEUS, ktorá má na hlavnú otázku článku odpovedať. Prehľad v Nature Reviews Nephrology je za platobnou bariérou vydavateľa a nebol sprístupnený; číselné údaje preto pochádzajú z primárnych publikácií jednotlivých štúdií, nie z prehľadu. Hodnotenie opakujúcej sa schémy „biomarker áno, klinický výsledok nie“ je <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
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
