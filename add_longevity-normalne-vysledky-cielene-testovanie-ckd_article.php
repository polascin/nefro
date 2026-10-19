<?php
/**
 * add_longevity-normalne-vysledky-cielene-testovanie-ckd_article.php
 * Odborný článok: longevity medicína, hranice „normálnych“ laboratórnych výsledkov,
 * cielené testovanie a nedostatočný skríning chronickej choroby obličiek (eGFR a UACR).
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
    'title'        => 'Keď sú výsledky „v norme“, no pacient sa cíti zle: longevity medicína, cielené testovanie a nefrologická perspektíva',
    'slug'         => 'longevity-normalne-vysledky-cielene-testovanie-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Normálny panel nevylučuje chorobu obličiek. V USA nedostalo 80,3 % rizikových dospelých hodnotenie podľa usmernení a UACR malo stanovené len 21,0 %. Kde končí oprávnená kritika nadmerného testovania a kde začína nedovyšetrenie.',
    'content'      => <<<'HTML'
<figure>
  <a href="img/longevity-normalne-vysledky-cielene-testovanie-ckd.webp" target="_blank" rel="noopener noreferrer">
    <img src="img/longevity-normalne-vysledky-cielene-testovanie-ckd.webp" alt="Polopriesvitná oblička v tme s vnútorným jantárovým žiarením skrytého poškodenia, cez ktorú vodorovne prechádza plochý chladný tyrkysový lúč predstavujúci zdanlivo normálny výsledok" width="1600" height="1000" loading="lazy" decoding="async" />
  </a>
  <figcaption>Ilustračná poloschematická vizualizácia rozporu medzi laboratórnym obrazom a skutočným stavom obličiek: plochý tyrkysový lúč predstavuje výsledok, ktorý sa zmestil do referenčného intervalu, zatiaľ čo jantárové žiarenie vo vnútri parenchýmu symbolizuje prebiehajúce, klinicky nemé poškodenie. Ide o koncepčnú scénu, nie o zobrazenie tkaniva konkrétneho pacienta ani o výstup zobrazovacej metódy.</figcaption>
</figure>

<p>Dopyt po „longevity“ starostlivosti rastie rýchlejšie než jej dôkazový základ. Spoločnosť Future Market Insights odhadla globálny trh s infraštruktúrou reťazcov longevity ambulancií na 2,6 miliardy USD v roku 2026 s projekciou 6,9 miliardy USD o desaťročie neskôr – ide o komerčný trhový odhad, nie o recenzovaný údaj, a treba ho čítať ako indikátor dopytu, nie ako dôkaz účinnosti.<sup>1</sup> Za týmto dopytom stojí reálna klinická skúsenosť pacientov: po štandardnom odbere a krátkej prehliadke dostanú odpoveď, že laboratórne a vitálne parametre sú v norme, pričom spánok, nálada, hmotnosť, libido a výkonnosť sa nemenia.</p>

<p>Pre nefrológiu má táto debata nečakane presný význam, ktorý sa v populárnom podaní stráca. Chronická choroba obličiek (CKD) je prototypom ochorenia, ktoré roky neprodukuje symptómy a súčasne sa <strong>systematicky nedovyšetruje</strong>. Kritika nadmerného testovania, ktorú longevity segment oprávnene vyvoláva, preto v nefrológii nesmie viesť k rezignácii na dve lacné, dostupné a usmerneniami jednoznačne odporúčané vyšetrenia – odhadovanú glomerulárnu filtráciu (eGFR) a pomer albumínu ku kreatinínu v moči (UACR).<sup>3,4</sup></p>

<p>Tento text vychádza z redakčného prehľadu agentúry Medscape, ktorý zhromaždil stanoviská ôsmich klinikov pôsobiacich prevažne v longevity a wellness segmente.<sup>1</sup> Ich vyjadrenia sú tu spracované ako hypotézy a podnety, nie ako dôkaz; každé klinicky relevantné tvrdenie je doplnené o recenzovaný zdroj alebo o explicitné upozornenie, že dôkaz chýba.</p>

<h2>Čo vlastne znamená „výsledky sú v norme“</h2>

<p>Veta „máte to v norme“ nesie tri rozdielne významy, ktoré sa v ambulancii bežne zlievajú do jedného:</p>

<ol>
  <li><strong>Hodnota padla do referenčného intervalu.</strong> Referenčný interval je spravidla konštruovaný tak, aby zahrnul stredných 95 % zdravej referenčnej populácie. Pri paneli desiatich vzájomne nezávislých analytov je potom pravdepodobnosť, že aspoň jeden vyjde mimo interval, približne 40 % (1 − 0,95<sup>10</sup>) – a naopak, hodnota vnútri intervalu nevypovedá o tom, či sa u daného pacienta nezmenila oproti jeho vlastnej východiskovej úrovni.</li>
  <li><strong>Nebola prekročená diagnostická prahová hodnota.</strong> Prah je rozhodovacia konvencia, nie biologická hranica. Zhoršovanie funkcie môže prebiehať celé roky pod ňou.</li>
  <li><strong>Test odpovedal na jednu konkrétnu otázku.</strong> Normálny výsledok vylučuje presne to, na čo bol test indikovaný – nič viac. Nevysvetľuje symptóm, ktorý pacienta priviedol.</li>
</ol>

<p>V nefrológii tento rozdiel nie je akademický. Sérový kreatinín je ovplyvnený svalovou hmotou, príjmom bielkovín a vekom, takže u sarkopenického alebo staršieho pacienta môže zostať „v norme“ aj pri významne zníženej filtrácii. Usmernenie KDIGO 2024 preto odporúča v situáciách, keď má presnosť odhadu klinický dopad, potvrdiť eGFR stanovením cystatínu C a dôsledne hodnotiť CKD v trojosovom rámci príčina – kategória eGFR – kategória albuminúrie (CGA).<sup>3</sup></p>

<div class="table-responsive" role="region" aria-label="Čo normálny rutinný panel pri obličkách nevylučuje" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">„Normálny“ nález</th>
        <th scope="col">Čo nevylučuje</th>
        <th scope="col">Cielený doplnkový krok</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Sérový kreatinín v referenčnom intervale</th>
        <td>Zníženú eGFR pri nízkej svalovej hmote, sarkopénii, vyššom veku alebo po amputácii</td>
        <td>eGFR z kreatinínu aj cystatínu C (eGFRcr-cys)<sup>3</sup></td>
      </tr>
      <tr>
        <th scope="row">eGFR ≥ 90 ml/min/1,73 m²</th>
        <td>Albuminúriu kategórie A2 alebo A3, teda štádium G1 – G2 s vysokým kardiorenálnym rizikom</td>
        <td>UACR z prvej rannej vzorky moču, pri pozitivite potvrdenie opakovaním<sup>3,6</sup></td>
      </tr>
      <tr>
        <th scope="row">Negatívny prúžok na bielkovinu v moči</th>
        <td>Stredne zvýšenú albuminúriu – prúžok je na jej záchyt nedostatočne citlivý</td>
        <td>Kvantitatívne stanovenie UACR<sup>3</sup></td>
      </tr>
      <tr>
        <th scope="row">Jednorazovo normálny panel</th>
        <td>Trend: postupný pokles eGFR alebo vzostup albuminúrie v čase</td>
        <td>Opakované meranie s definovaným intervalom a porovnanie s vlastnou východiskovou hodnotou<sup>3,5</sup></td>
      </tr>
      <tr>
        <th scope="row">Normálny HbA<sub>1c</sub> a lipidogram</th>
        <td>Kumulatívne kardio-renálno-metabolické riziko dané kombináciou parametrov naprieč systémami</td>
        <td>Stagingové zaradenie podľa rámca CKM a odhad rizika<sup>2</sup></td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Nefrologická výnimka: tu sa netestuje priveľa, ale primálo</h2>

<p>Analýza 28 295 982 dospelých s diabetom alebo hypertenziou z národnej laboratórnej databázy v USA (2013 – 2019) ukázala, že <strong>80,3 % z nich nedostalo hodnotenie obličiek v súlade s usmerneniami</strong>. Zatiaľ čo eGFR malo stanovené 89,6 %, UACR iba <strong>21,0 %</strong>. Aspoň raz bolo kompletne vyšetrených 28,7 % pacientov s diabetom, 10,5 % pacientov s hypertenziou a 41,4 % pacientov s oboma diagnózami; ročná miera testovania sa medzi jednotlivými štátmi pohybovala od 5 % do 30 % a na celonárodnej úrovni stúpla v rokoch 2013 až 2018 len z 10,7 % na 15,2 %.<sup>4</sup></p>

<p>Autori v úvode práce pripomínajú odhad, že CKD má približne 37 miliónov Američanov a takmer 90 % z nich o svojom ochorení nevie.<sup>4</sup> Záverečná správa z konferencie KDIGO Controversies k včasnej identifikácii CKD stavia na rovnakej logike: ochorenie je dlho asymptomatické, k dispozícii sú lacné testy aj liečba meniaca prognózu, a práve preto je oneskorený záchyt zlyhaním systému, nie biologickou nevyhnutnosťou.<sup>5</sup></p>

<p>Metaanalýza individuálnych údajov účastníkov z konzorcia CKD Prognosis Consortium doložila, prečo samotné eGFR nestačí: albuminúria prináša u pacientov s hypertenziou a diabetom prognostickú informáciu, ktorú filtračná funkcia nenahrádza, a jej vynechanie systematicky podhodnocuje riziko.<sup>6</sup></p>

<p>Praktický dôsledok je jednoznačný: ak pacient prichádza s nešpecifickými ťažkosťami a súčasne má diabetes, hypertenziu, obezitu, kardiovaskulárne ochorenie alebo rodinnú záťaž, <em>UACR nie je nadbytočný test</em> – je to test, ktorý vo väčšine prípadov chýba.</p>

<h2>Kardio-renálno-metabolický syndróm: riziko sa skrýva v medzerách medzi panelmi</h2>

<p>Stanovisko Americkej kardiologickej asociácie (AHA) k zdraviu kardio-renálno-metabolickej osi definovalo CKM syndróm ako systémový stav vznikajúci z interakcie metabolických rizikových faktorov, CKD a kardiovaskulárneho systému a zaviedlo stagingovanie od štádia 0 po štádium 4, ktoré má umožniť prevenciu naprieč celým priebehom života. Dokument výslovne označuje <strong>fragmentáciu starostlivosti</strong> za prekážku a volá po interdisciplinárnom modeli sústredenom na pacienta.<sup>2</sup></p>

<p>Práve tu je kritika zo zdrojového prehľadu vecne oprávnená: hodnota HbA<sub>1c</sub> z preventívnej prehliadky, základná biochémia z pohotovosti a lipidogram z kardiológie môžu byť jednotlivo bezchybné a napriek tomu nedávajú obraz, ktorý vznikne až ich spoločným čítaním v čase.<sup>1</sup> Riešením však nie je rozšíriť panel o marketingovo atraktívne biomarkery, ale <strong>zjednotiť už existujúce údaje a doplniť to, čo v nich preukázateľne chýba</strong> – v nefrológii predovšetkým albuminúriu a longitudinálny sklon krivky eGFR.</p>

<h2>Cielené testovanie namiesto plošného: čo hovoria dôkazy o „viac testov = viac zdravia“</h2>

<p>Systematický prehľad intervencií zameraných na žiadanky laboratórnych vyšetrení v primárnej starostlivosti uvádza, že približne <strong>30 % kontaktov s pacientom vyústi do laboratórnej žiadanky</strong>, pričom podstatná časť z nich neprináša úžitok pre starostlivosť. Z jedenástich zaradených štúdií (štyri randomizované) takmer všetky zaznamenali po intervencii významné zníženie objemu testov s veľkosťou účinku 1,2 % až 60 %; autori však úroveň dôkazov výslovne hodnotia ako nízku a kvalitu ako slabú, takže ide o indíciu o smerovaní, nie o kvantifikovaný návod.<sup>7</sup></p>

<p>Dôsledky plošného zobrazovania sú doložené lepšie. Zastrešujúci prehľad systematických prehľadov (20 prehľadov, 240 primárnych štúdií) ukázal, že prevalencia náhodných nálezov sa medzi metódami dramaticky líši – od menej než 5 % po viac než tretinu vyšetrení – a že väčšina incidentalómov nevedie ku klinicky významnej diagnóze.<sup>8</sup> Pri celotelovej magnetickej rezonancii u asymptomatických osôb bola združená prevalencia kritických a neurčitých náhodných nálezov <strong>32,1 %</strong> (95 % interval spoľahlivosti 18,3 – 50,1) a združený podiel falošne pozitívnych nálezov 16,0 %, pričom žiadna zo zaradených štúdií nesledovala overenie negatívnych nálezov dlhšie než päť rokov.<sup>9</sup> Metaanalýza desiatich štúdií s 9024 asymptomatickými účastníkmi zároveň zistila, že potvrdená malignita sa našla u <strong>1,57 %</strong> (95 % interval spoľahlivosti 1,22 – 2,03) vyšetrených; autori uzatvárajú, že nízka výťažnosť, časté náhodné nálezy, neštandardizované protokoly a chýbajúce údaje o dlhodobých výsledkoch aj nákladovej efektívnosti zatiaľ obmedzujú klinickú použiteľnosť metódy.<sup>10</sup></p>

<p>Pre nefrológa z toho plynie konkrétna výstraha: kaskáda po náhodnom náleze zvyčajne pokračuje výpočtovou tomografiou s jódovou kontrastnou látkou, prípadne biopsiou. U pacienta so zníženou eGFR tým test s nízkou pravdepodobnosťou prínosu generuje reálne, nenulové riziko.</p>

<h2>Čo z longevity ponuky môže ohroziť obličky</h2>

<h3>Intravenózne „wellness“ infúzie</h3>

<p>Medicínsky indikovaná infúzna liečba je bežnou a bezpečnou súčasťou praxe; problémom je jej podávanie bez indikácie. Opakované intravenózne podania nesú riziko spojené s cievnym vstupom a infekciou, objemovú a sodíkovú záťaž u pacientov s CKD alebo srdcovým zlyhávaním a možné elektrolytové dôsledky. Osobitne doložené je riziko <strong>oxalátovej nefropatie po vysokodávkovom intravenóznom vitamíne C</strong>, ktorý sa metabolizuje na kyselinu šťaveľovú; opísaný prípad u pacienta s mnohopočetným myelómom ilustruje, že k akútnemu poškodeniu obličiek stačí aj krátka séria podaní.<sup>11</sup></p>

<h3>Výživové doplnky a „prírodné“ prípravky</h3>

<p>Kritický prehľad v <em>American Journal of Kidney Diseases</em> upozorňuje, že užívanie výživových doplnkov je u dospelých v USA vysoko rozšírené a osobitne časté práve u osôb, ktoré sa považujú za zdravé – vrátane žijúcich darcov obličky –, a ponúka rámec na ich systematické zhodnotenie pred nefrologickým rozhodnutím.<sup>12</sup> Retrospektívna disproporcionalitná analýza hlásení v databáze FDA Adverse Event Reporting System identifikovala signály možnej nefrotoxicity pri viacerých prírodných produktoch; tento typ údajov umožňuje generovať hypotézy, nie dokázať príčinnosť, pre klinickú obozretnosť však postačuje.<sup>13</sup> Kazuisticky je doložená aj oxalátová nefropatia po dlhodobom užívaní prípravkov z huby <em>Inonotus obliquus</em> (čaga), ktorá sa klinicky prejavila ako nefrotický syndróm.<sup>16</sup></p>

<h3>„Hormóny mladosti“</h3>

<p>Zdrojový prehľad uvádza medzi rozširovanými vyšetreniami aj dehydroepiandrosterón (DHEA) a pregnenolón.<sup>1</sup> Cochrane prehľad randomizovaných placebom kontrolovaných štúdií u osôb nad 50 rokov bez demencie uzatvoril, že <strong>dostupné dôkazy nepodporujú priaznivý vplyv suplementácie DHEA na kognitívne funkcie</strong>; v jednej zo štúdií bola dokonca pozorovaná horšia výkonnosť v teste vizuálnej pamäti oproti placebu.<sup>14</sup> Metaanalýza randomizovaných štúdií o vplyve DHEA na kostnú denzitu naznačila čiastočné zvýšenie denzity bedra a trochanteru u žien, nie však u mužov, pričom samotní autori označili klinickú významnosť za nepreukázanú a vyzvali na ďalšie štúdie; smerovanie uvádzaných štandardizovaných rozdielov je navyše v publikácii prezentované nekonzistentne, čo sťažuje priamu interpretáciu veľkosti účinku.<sup>15</sup> Pre pregnenolón porovnateľný dôkazový základ pri indikácii „spomalenie starnutia“ neexistuje.</p>

<p>Je namieste formulovať to presne: absencia dôkazu o prínose nie je dôkazom neúčinnosti. Pri intervencii s nejasnou indikáciou, nedefinovaným ukazovateľom úspechu a vysokou cenou však dôkazné bremeno nesie ten, kto ju ponúka.</p>

<div class="table-responsive" role="region" aria-label="Longevity intervencie a ich nefrologické riziká" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Intervencia</th>
        <th scope="col">Nefrologicky relevantné riziko</th>
        <th scope="col">Na čo sa pýtať</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Vysokodávkový intravenózny vitamín C</th>
        <td>Oxalátová nefropatia, akútne poškodenie obličiek<sup>11</sup></td>
        <td>Dávka, počet podaní, stav funkcie obličiek pred prvým podaním</td>
      </tr>
      <tr>
        <th scope="row">Opakované „wellness“ infúzie a koktaily</th>
        <td>Objemová a sodíková záťaž, infekcie cievneho vstupu, elektrolytové odchýlky</td>
        <td>Zloženie roztoku, objem, frekvencia, súbežná diuretická liečba</td>
      </tr>
      <tr>
        <th scope="row">Výživové doplnky a bylinné prípravky</th>
        <td>Signály možnej nefrotoxicity, liekové interakcie, nedeklarované zloženie<sup>12,13,16</sup></td>
        <td>Presný názov, výrobca, dávka, dĺžka užívania, dôvod začatia</td>
      </tr>
      <tr>
        <th scope="row">DHEA a pregnenolón</th>
        <td>Chýbajúci dôkaz prínosu, androgénne a hormonálne účinky<sup>14,15</sup></td>
        <td>Indikácia, cieľový parameter, spôsob hodnotenia účinku</td>
      </tr>
      <tr>
        <th scope="row">Celotelová magnetická rezonancia ako skríning</th>
        <td>Kaskáda po náhodnom náleze: kontrastná tomografia, biopsia, záťaž pri zníženej eGFR<sup>8,9,10</sup></td>
        <td>Čo konkrétne sa hľadá a čo bude nasledovať pri neurčitom náleze</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Rámec pre ambulanciu: ako neodmietnuť pacienta a nerozsypať dôkazový základ</h2>

<ol>
  <li><strong>Začnite anamnézou, nie výsledkom.</strong> Nechajte pacienta opísať, čo sa zmenilo a ako to ovplyvňuje jeho fungovanie, ešte pred interpretáciou laboratórneho nálezu. Veta „vaše doterajšie výsledky sú upokojujúce a zároveň vidím, že sa stále necítite dobre“ je poctivým východiskom, nie ústupkom.<sup>1</sup></li>
  <li><strong>Pred každým testom si odpovedzte na tri otázky.</strong> Viem výsledok pacientovi zrozumiteľne vysvetliť? Zmení manažment? Dokážem ho sledovať longitudinálne? Záporná odpoveď na ktorúkoľvek z nich je dôvodom na postúpenie alebo na vynechanie testu.<sup>1</sup></li>
  <li><strong>V rizikovej populácii doplňte to, čo preukázateľne chýba.</strong> Pri diabete, hypertenzii, obezite, kardiovaskulárnom ochorení alebo rodinnej záťaži stanovte eGFR <em>aj</em> UACR a zaraďte pacienta do rámca CGA; pri sarkopénii alebo nesúlade klinického obrazu s kreatinínom doplňte cystatín C.<sup>3,4,6</sup></li>
  <li><strong>Interpretujte v čase.</strong> Pri chronických ťažkostiach je rozhodujúci trend, nie jedna hodnota. Zaznamenajte východiskovú úroveň a definujte interval kontroly.<sup>3,5</sup></li>
  <li><strong>Dohodnite merateľný cieľ a termín prehodnotenia.</strong> Pacient má odchádzať s tým, čo sa vylučuje alebo potvrdzuje, čo sa mení v liečbe a podľa čoho sa o niekoľko týždňov posúdi úspech.<sup>1</sup></li>
  <li><strong>Pýtajte sa na intervencie zvonku bez odsudzovania.</strong> Presný názov prípravku, dávku, frekvenciu a deklarovanú indikáciu potrebujete na posúdenie bezpečnosti a interakcií. Zahanbenie pacienta spoľahlivo zastaví tok informácií, ktorý práve potrebujete.<sup>1,12</sup></li>
  <li><strong>Neprekladajte si personalizáciu ako „všetko, čo sa dá objednať“.</strong> Plošné rozširovanie panelov a zobrazovania zvyšuje počet nálezov, nie množstvo zdravia.<sup>7,8,9,10</sup></li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Povaha východiskového zdroja.</strong> Zdrojový text je redakčný prehľad spravodajskej platformy, nie systematická rešerša. Jeho jadrom sú stanoviská ôsmich oslovených klinikov; všetci deklarovali, že nemajú relevantné konflikty záujmov, no väčšina z nich prevádzkuje alebo odborne vedie súkromné longevity, wellness či zobrazovacie zariadenia, takže ich vyjadrenia treba čítať s vedomím vlastného záujmu na rozšírení tohto modelu starostlivosti.<sup>1</sup></li>
  <li><strong>Trhové čísla.</strong> Odhad veľkosti trhu pochádza od komerčnej analytickej agentúry, nie z recenzovanej publikácie, a nebol nezávisle overený.<sup>1</sup></li>
  <li><strong>Prenositeľnosť amerických dát.</strong> Údaje o mierach testovania pochádzajú z americkej laboratórnej databázy s odlišnou organizáciou starostlivosti a úhradovými mechanizmami; porovnateľné celoslovenské dáta o pokrytí UACR v rizikových skupinách nie sú verejne dostupné v rovnakej podrobnosti.<sup>4</sup></li>
  <li><strong>Dôkazy o samotných longevity intervenciách.</strong> Pre väčšinu ponúkaných postupov neexistujú randomizované štúdie s tvrdými ukazovateľmi; závery o DHEA vychádzajú z prehľadov malých štúdií s heterogénnymi dávkami a krátkym sledovaním, závery o nefrotoxicite doplnkov z kazuistík a z hlásení, ktoré nedokazujú príčinnosť.<sup>13,14,15,16</sup></li>
  <li><strong>Celotelová magnetická rezonancia.</strong> Zaradené štúdie mali väčšinou stredné až vážne riziko skreslenia a heterogénne protokoly; uvedené združené odhady preto nesú širokú neistotu.<sup>9,10</sup></li>
</ul>

<hr>

<p class="clanok-upozornenie"><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom ako odborná informácia. Nenahrádza klinické rozhodnutie pri konkrétnom pacientovi, platné súhrny charakteristických vlastností liekov ani národné odporúčania. Pacientom neslúži ako návod na zmenu liečby či doplnkov bez konzultácie s ošetrujúcim lekárom.</p>

<h2>Literatúra</h2>

<ol class="references-list">
  <li>Peck J. <em>Longevity Boom: How to Respond When „Normal“ Isn’t Enough</em>. Medscape Medical News; 14. október 2026. Dostupné z: <a href="https://www.medscape.com/viewarticle/longevity-boom-how-respond-when-normal-isnt-enough-2026a10012h5" target="_blank" rel="noopener noreferrer">https://www.medscape.com/viewarticle/longevity-boom-how-respond-when-normal-isnt-enough-2026a10012h5</a></li>
  <li>Ndumele CE, Rangaswami J, Chow SL, Neeland IJ, Tuttle KR, Khan SS, Coresh J, Mathew RO, Baker-Smith CM, Carnethon MR, Despres JP, Ho JE, Joseph JJ, Kernan WN, Khera A, Kosiborod MN, Lekavich CL, Lewis EF, Lo KB, Ozkan B, Palaniappan LP, Patel SS, Pencina MJ, Powell-Wiley TM, Sperling LS, Virani SS, Wright JT, Rajgopal Singh R, Elkind MSV; American Heart Association. Cardiovascular-Kidney-Metabolic Health: A Presidential Advisory From the American Heart Association. <em>Circulation</em>. 2023;148(20):1606–1635. DOI: <a href="https://doi.org/10.1161/CIR.0000000000001184" target="_blank" rel="noopener noreferrer">10.1161/CIR.0000000000001184</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/37807924/" target="_blank" rel="noopener noreferrer">37807924</a>.</li>
  <li>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117–S314. DOI: <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.10.018</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">38490803</a>.</li>
  <li>Alfego D, Ennis J, Gillespie B, Lewis MJ, Montgomery E, Ferrè S, Vassalotti JA, Letovsky S. Chronic Kidney Disease Testing Among At-Risk Adults in the U.S. Remains Low: Real-World Evidence From a National Laboratory Database. <em>Diabetes Care</em>. 2021;44(9):2025–2032. DOI: <a href="https://doi.org/10.2337/dc21-0723" target="_blank" rel="noopener noreferrer">10.2337/dc21-0723</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/34353883/" target="_blank" rel="noopener noreferrer">34353883</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8740927/" target="_blank" rel="noopener noreferrer">PMC8740927</a>.</li>
  <li>Shlipak MG, Tummalapalli SL, Boulware LE, Grams ME, Ix JH, Jha V, Kengne AP, Madero M, Mihaylova B, Tangri N, Cheung M, Jadoul M, Winkelmayer WC, Zoungas S; Conference Participants. The case for early identification and intervention of chronic kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney International</em>. 2021;99(1):34–47. DOI: <a href="https://doi.org/10.1016/j.kint.2020.10.012" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2020.10.012</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/33127436/" target="_blank" rel="noopener noreferrer">33127436</a>.</li>
  <li>Shin JI, Chang AR, Grams ME, Coresh J, Ballew SH, Surapaneni A, Matsushita K, Bilo HJG, Carrero JJ, Chodick G, Daratha KB, Jassal SK, Nadkarni GN, Nelson RG, Nowak C, Stempniewicz N, Sumida K, Traynor JP, Woodward M, Sang Y, Gansevoort RT; Chronic Kidney Disease Prognosis Consortium. Albuminuria Testing in Hypertension and Diabetes: An Individual-Participant Data Meta-Analysis in a Global Consortium. <em>Hypertension</em>. 2021;78(4):1042–1052. DOI: <a href="https://doi.org/10.1161/HYPERTENSIONAHA.121.17323" target="_blank" rel="noopener noreferrer">10.1161/HYPERTENSIONAHA.121.17323</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/34365812/" target="_blank" rel="noopener noreferrer">34365812</a>.</li>
  <li>Cadogan SL, Browne JP, Bradley CP, Cahill MR. The effectiveness of interventions to improve laboratory requesting patterns among primary care physicians: a systematic review. <em>Implementation Science</em>. 2015;10:167. DOI: <a href="https://doi.org/10.1186/s13012-015-0356-4" target="_blank" rel="noopener noreferrer">10.1186/s13012-015-0356-4</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/26637335/" target="_blank" rel="noopener noreferrer">26637335</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4670500/" target="_blank" rel="noopener noreferrer">PMC4670500</a>.</li>
  <li>O’Sullivan JW, Muntinga T, Grigg S, Ioannidis JPA. Prevalence and outcomes of incidental imaging findings: umbrella review. <em>BMJ</em>. 2018;361:k2387. DOI: <a href="https://doi.org/10.1136/bmj.k2387" target="_blank" rel="noopener noreferrer">10.1136/bmj.k2387</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/29914908/" target="_blank" rel="noopener noreferrer">29914908</a>.</li>
  <li>Kwee RM, Kwee TC. Whole-body MRI for preventive health screening: A systematic review of the literature. <em>Journal of Magnetic Resonance Imaging</em>. 2019;50(5):1489–1503. DOI: <a href="https://doi.org/10.1002/jmri.26736" target="_blank" rel="noopener noreferrer">10.1002/jmri.26736</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/30932247/" target="_blank" rel="noopener noreferrer">30932247</a>.</li>
  <li>Martins da Fonseca J, Trennepohl T, Pinheiro LG, Carra Forte G, Campello CA, Altmayer S, Andrade RG, Hochhegger B. Whole-body MRI for opportunistic cancer detection in asymptomatic individuals: a systematic review and meta-analysis. <em>European Radiology</em>. 2026;36(3):1813–1823. DOI: <a href="https://doi.org/10.1007/s00330-025-11976-5" target="_blank" rel="noopener noreferrer">10.1007/s00330-025-11976-5</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/40884613/" target="_blank" rel="noopener noreferrer">40884613</a>.</li>
  <li>Zou G, Lim J, Rosenberg AZ. Oxalate nephropathy from high-dose intravenous vitamin C in a patient with multiple myeloma. <em>Journal of Nephrology</em>. 2025;38(2):751–753. DOI: <a href="https://doi.org/10.1007/s40620-024-02078-4" target="_blank" rel="noopener noreferrer">10.1007/s40620-024-02078-4</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/39511062/" target="_blank" rel="noopener noreferrer">39511062</a>.</li>
  <li>Leonberg-Yoo AK, Johnson D, Persun N, Bahrainwala J, Reese PP, Naji A, Trofe-Clark J. Use of Dietary Supplements in Living Kidney Donors: A Critical Review. <em>American Journal of Kidney Diseases</em>. 2020;76(6):851–860. DOI: <a href="https://doi.org/10.1053/j.ajkd.2020.03.030" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2020.03.030</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/32659245/" target="_blank" rel="noopener noreferrer">32659245</a>.</li>
  <li>Lukan CJ, Karimzadeh I, Tran TL, Sestito MR, Abanyie K, Boyce RD, Kane-Gill SL. A Retrospective Pharmacovigilance Disproportionality Analysis of Possible Nephrotoxicity and Natural Products Using Data from the FDA Adverse Event Reporting System. <em>Journal of Integrative and Complementary Medicine</em>. Publikované online 11. júna 2026. DOI: <a href="https://doi.org/10.1177/27683605261456017" target="_blank" rel="noopener noreferrer">10.1177/27683605261456017</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42274044/" target="_blank" rel="noopener noreferrer">42274044</a>.</li>
  <li>Grimley Evans J, Malouf R, Huppert F, van Niekerk JK. Dehydroepiandrosterone (DHEA) supplementation for cognitive function in healthy elderly people. <em>Cochrane Database of Systematic Reviews</em>. 2006;(4):CD006221. DOI: <a href="https://doi.org/10.1002/14651858.CD006221" target="_blank" rel="noopener noreferrer">10.1002/14651858.CD006221</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/17054283/" target="_blank" rel="noopener noreferrer">17054283</a>.</li>
  <li>Lin H, Li L, Wang Q, Wang Y, Wang J, Long X. A systematic review and meta-analysis of randomized placebo-controlled trials of DHEA supplementation of bone mineral density in healthy adults. <em>Gynecological Endocrinology</em>. 2019;35(11):924–931. DOI: <a href="https://doi.org/10.1080/09513590.2019.1616175" target="_blank" rel="noopener noreferrer">10.1080/09513590.2019.1616175</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/31237150/" target="_blank" rel="noopener noreferrer">31237150</a>.</li>
  <li>Kwon O, Kim Y, Paek JH, Park WY, Han S, Sin H, Jin K. Chaga mushroom-induced oxalate nephropathy that clinically manifested as nephrotic syndrome: A case report. <em>Medicine (Baltimore)</em>. 2022;101(10):e28997. DOI: <a href="https://doi.org/10.1097/MD.0000000000028997" target="_blank" rel="noopener noreferrer">10.1097/MD.0000000000028997</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/35451393/" target="_blank" rel="noopener noreferrer">35451393</a>.</li>
</ol>

<p class="clanok-poznamka"><strong>Poznámka k dôkazom a metodike overenia:</strong> Plný text zdrojového prehľadu bol načítaný priamo z verejne dostupnej stránky Medscape vrátane autorského bylinu (Julie Peck, 14. október 2026) a vyhlásení o konfliktoch záujmov; citované trhové čísla (2,6 a 6,9 miliardy USD) boli porovnané s jeho doslovným znením. Bibliografické údaje všetkých šestnástich referencií vrátane úplných autorských zoznamov, ročníkov, čísel, strán, DOI, PMID a PMCID boli overené cez PubMed a Crossref. Východiskový podklad obsahoval tri vecné chyby, ktoré sú tu opravené: identifikátor PMC4670500 nepatrí práci s názvom „Towards Better Test Utilization“, ale systematickému prehľadu Cadogan a kol. v <em>Implementation Science</em> (2015); pri práci Shlipak a kol. bol autorský zoznam označený za neoveriteľný, hoci je v databáze PubMed úplný (štrnásť menovaných autorov plus skupina „Conference Participants“, ktorá nie je autorstvom); a formulácia o nedostupnosti metadát bola redakčnou poznámkou, nie obsahom zdroja. Vlastným prínosom oproti podkladu je nefrologické ťažisko: dáta o nedostatočnom pokrytí UACR a eGFR, kvantifikované riziko náhodných nálezov pri celotelovej magnetickej rezonancii, doložené nefrotoxické riziká longevity intervencií a tabuľkové zhrnutie pre ambulantnú prax. Rozpor medzi výzvou na obmedzenie nadmerného testovania a potrebou <em>viac</em> testovať obličky v rizikových skupinách je tu pomenovaný výslovne, keďže zdrojový text ho nerieši.</p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4, skríning a liečba podľa usmernenia AHA/ACC/ADA/ASN 2026</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida">Cystatín C a kreatinínové odhady eGFR oproti biomarkerom aktivity reumatoidnej artritídy</a></li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_longevity-normalne-vysledky-cielene-testovanie-ckd_article',
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
