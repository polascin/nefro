<?php

/**
 * add_tenapanor-vyssia-davka-kostna-resorpcia-crevna-pasaz_article.php
 * Ktori dialyzovani pacienti potrebuju vyssiu davku tenapanoru - suhrnna analyza
 * troch japonskych studii fazy 3 (PLOS ONE 2026;21(8):e0356873).
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
    'title'        => 'Ktorí dialyzovaní pacienti potrebujú vyššiu dávku tenapanoru? Úloha kostnej resorpcie a črevnej pasáže',
    'slug'         => 'tenapanor-vyssia-davka-kostna-resorpcia-crevna-pasaz',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Súhrnná analýza troch japonských štúdií fázy 3 (212 pacientov) našla dva faktory spojené s vyššou konečnou dávkou tenapanoru: vyššiu kostnú resorpciu a tvrdšiu stolicu. Ide o prieskumné nálezy, nie o dávkovací algoritmus.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Tenapanor nie je viazač fosfátov — znižuje ich vstrebávanie v čreve. Nová súhrnná analýza troch japonských štúdií fázy 3 sa pýta prakticky: čím sa líšia pacienti, ktorí po titrácii skončili na najvyšších dávkach. Odpoveďou sú dva signály — kostná resorpcia a črevná pasáž. Oba sú zaujímavé, ani jeden zatiaľ nie je prediktorom.</em></p>

<p>Hyperfosfatémia patrí medzi základné prejavy minerálovej a kostnej poruchy pri chronickej chorobe obličiek (CKD-MBD). U dialyzovaných pacientov sú možnosti odstránenia fosfátov obmedzené: bežný dialyzačný režim odstráni približne <strong>1 800 až 2 520 mg fosfátov týždenne</strong>, čo je výrazne menej, než koľko sa priemerne prijme a vstrebe z potravy. Liečba preto stojí na troch pilieroch — primeranej dialyzačnej dávke, nutričnej intervencii a farmakoterapii.</p>

<p>Viazače fosfátov účinkujú v črevnom lúmene, kde viažu fosfáty prijaté potravou. Ich používanie však sprevádza vysoká tabletová záťaž, gastrointestinálne nežiaduce účinky a nedostatočná adherencia. Tenapanor predstavuje farmakologicky odlišný prístup: fosfáty neviaže, ale znižuje ich <strong>paracelulárnu absorpciu</strong> inhibíciou sodíkovo-vodíkového výmenníka 3 (NHE3).</p>

<p>Súhrnná analýza troch japonských klinických štúdií, publikovaná 28. augusta 2026 v <em>PLOS ONE</em>, skúmala, ktoré vstupné charakteristiky pacientov sú spojené s potrebou vyššej dávky tenapanoru. Výsledky upozorňujú na dva možné faktory: <strong>vyššiu aktivitu kostnej resorpcie</strong> a <strong>sklon k zápche</strong>. Ide o prieskumné <em>post hoc</em> zistenia, ktoré zatiaľ nemožno považovať za validovaný dávkovací algoritmus.</p>

<h2>Ako tenapanor účinkuje</h2>

<p>Tenapanor selektívne inhibuje NHE3 na apikálnej membráne enterocytov. Zmena intracelulárnej koncentrácie sodíka a protónov vedie ku konformačnej zmene bielkovín tesných spojov (<em>tight junctions</em>) medzi epitelovými bunkami, k zvýšeniu transepitelového odporu a k zníženiu paracelulárnej priepustnosti pre fosfáty. Liek sa prakticky nevstrebáva a účinkuje výlučne v črevnom lúmene.</p>

<p>Inhibícia absorpcie sodíka zároveň zvyšuje množstvo sodíka a vody v črevnom lúmene. Stolica sa stáva mäkšou a zvyšuje sa jej frekvencia. Ten istý mechanizmus, ktorý znižuje fosfatémiu, teda vysvetľuje aj najčastejší nežiaduci účinok — <strong>hnačku</strong>. Táto dvojznačnosť je pre pochopenie celej analýzy kľúčová.</p>

<h3>Dávkovanie sa medzi regiónmi líši</h3>

<p>Režim skúmaný v japonských štúdiách nemožno automaticky prenášať inam. Schválené indikácie aj dávkovacie schémy sa medzi regulačnými oblasťami podstatne líšia:</p>

<div class="table-responsive" role="region" aria-label="Dávkovanie tenapanoru podľa regulačnej oblasti" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Oblasť</th>
        <th scope="col">Prípravok</th>
        <th scope="col">Dávkovanie a postavenie v liečbe</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Japonsko</th>
        <td>PHOZEVEL</td>
        <td>Začiatok 5 mg dvakrát denne, titrácia na 10, 20 alebo 30 mg dvakrát denne podľa fosfatémie a znášanlivosti; monoterapia aj kombinácia s viazačmi</td>
      </tr>
      <tr>
        <th scope="row">USA</th>
        <td>XPHOZAH</td>
        <td>Fixne 30 mg dvakrát denne; <strong>len ako prídavná liečba</strong> pri nedostatočnej odpovedi na viazače alebo pri ich neznášanlivosti</td>
      </tr>
      <tr>
        <th scope="row">EÚ vrátane SR</th>
        <td>—</td>
        <td>K septembru 2026 nefiguruje v databáze centrálne registrovaných liekov EMA; v bežnej praxi nie je dostupný</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Titračný režim, o ktorý sa opiera celá analýza, je teda <strong>japonské špecifikum</strong>. V USA sa tenapanor podáva vo fixnej dávke, ktorá zodpovedá hornej hranici japonského rozsahu, a otázka „kto potrebuje vyššiu dávku“ sa tam nekladie rovnako.</p>

<h2>Dizajn súhrnnej analýzy</h2>

<p>Autori spojili údaje z troch japonských klinických štúdií fázy 3. Štúdie sa líšili nielen modalitou dialýzy, ale aj tým, či bol tenapanor podávaný samostatne, alebo pridaný k viazačom:</p>

<div class="table-responsive" role="region" aria-label="Prehľad troch zlúčených štúdií fázy 3" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štúdia</th>
        <th scope="col">Registrácia</th>
        <th scope="col">Dizajn</th>
        <th scope="col">Populácia</th>
        <th scope="col">Postavenie tenapanoru</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">A (n = 81)</th>
        <td>NCT04767581</td>
        <td>Randomizovaná, dvojito zaslepená, placebom kontrolovaná</td>
        <td>Hemodialýza, fosfatémia v cieľovom pásme pri stabilnej dávke viazačov</td>
        <td>Monoterapia po vysadení viazačov</td>
      </tr>
      <tr>
        <th scope="row">B (n = 80)</th>
        <td>NCT04766398</td>
        <td>Randomizovaná, dvojito zaslepená, placebom kontrolovaná</td>
        <td>Hemodialýza, refraktérna hyperfosfatémia (fosfor ≥ 6,1 a &lt; 10,0 mg/dl napriek viazačom)</td>
        <td>Pridanie k existujúcim viazačom</td>
      </tr>
      <tr>
        <th scope="row">C (n = 51)</th>
        <td>NCT04766385</td>
        <td>Otvorená, jednoramenná</td>
        <td>Peritoneálna dialýza</td>
        <td>Monoterapia po vysadení viazačov</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Do analýzy účinnosti vstúpilo <strong>212 pacientov</strong>, ktorí v 8. týždni užívali tenapanor:</p>

<ul>
  <li><strong>127 pacientov</strong> na dávke 5 alebo 10 mg dvakrát denne — skupina s nižšou dávkou,</li>
  <li><strong>85 pacientov</strong> na dávke 20 alebo 30 mg dvakrát denne — skupina s vyššou dávkou.</li>
</ul>

<p>Bezpečnostná analýza zahŕňala <strong>218 pacientov</strong> (133 v skupine s nižšou a 85 v skupine s vyššou dávkou) — pri porovnávaní percent nežiaducich účinkov treba mať na pamäti, že menovateľ nie je totožný s analýzou účinnosti.</p>

<p>Podľa modality bolo v analýze účinnosti 107 pacientov (50,5 %) na hemodiafiltrácii, 54 (25,5 %) na hemodialýze a 51 (24,1 %) na peritoneálnej dialýze. <em>(Poznámka: v časti Obmedzenia pôvodná práca uvádza mierne odlišné počty — 162 pacientov na hemodialýze a 52 na peritoneálnej dialýze. Ide o vnútornú nezrovnalosť publikácie; vyššie uvedené čísla pochádzajú z tabuľky 1 a súčtovo zodpovedajú populácii 212 pacientov.)</em></p>

<h3>Kto boli títo pacienti</h3>

<p>Priemerný vek bol <strong>63,2 roka</strong>, muži tvorili 65,1 % a priemerné trvanie dialyzačnej liečby bolo <strong>93,1 mesiaca</strong>, teda takmer osem rokov. Diabetická nefropatia bola príčinou zlyhania obličiek u 32,1 % pacientov. Východisková koncentrácia sérového fosforu dosahovala v priemere <strong>7,39 mg/dl</strong> (približne 2,39 mmol/l), korigovaného vápnika 8,88 mg/dl.</p>

<p>Hodnota 7,39 mg/dl je nápadne vysoká a nemožno ju čítať ako „bežnú“ fosfatémiu dialyzovaného pacienta. V štúdiách A a C sa merala <strong>po vysadení viazačov</strong>, teda v stave zámerne navodenej nekontrolovanej hyperfosfatémie; v štúdii B išlo o vstupné kritérium refraktérnosti. Východisková hodnota je teda artefaktom dizajnu, nie odrazom kvality bežnej starostlivosti.</p>

<h2>Dosiahnuté dávky a kontrola fosfatémie</h2>

<p>Po ôsmich týždňoch bola priemerná dávka:</p>

<ul>
  <li><strong>8,0 ± 2,5 mg dvakrát denne</strong> v skupine s nižšou dávkou,</li>
  <li><strong>26,7 ± 4,9 mg dvakrát denne</strong> v skupine s vyššou dávkou.</li>
</ul>

<p>Koncentrácia sérového fosforu počas liečby postupne klesala v oboch skupinách. Zmena oproti východiskovej hodnote sa však medzi skupinami štatisticky významne nelíšila (p = 0,456; zmiešaný model opakovaných meraní, MMRM).</p>

<p>Tento výsledok <strong>nemožno</strong> interpretovať tak, že nižšia a vyššia dávka sú rovnako účinné. Pacienti neboli na jednotlivé dávky randomizovaní — vyššia dávka bola výsledkom titrácie podľa fosfatémie a znášanlivosti. Pacienti s ťažšie kontrolovateľnou hyperfosfatémiou preto prirodzene častejšie skončili v skupine s vyššou dávkou. Ide o učebnicové <strong>skreslenie indikáciou</strong> (<em>confounding by indication</em>). Podobná zmena fosfatémie pri dvojnásobne odlišnej dávke skôr naznačuje, že titrácia fungovala tak, ako mala.</p>

<h2>Ktoré faktory súviseli s vyššou dávkou</h2>

<p>V jednorozmernej analýze boli s vyššou konečnou dávkou spojené:</p>

<ul>
  <li>vyššia východisková fosfatémia,</li>
  <li>vyššia koncentrácia tartarát-rezistentnej kyslej fosfatázy 5b (TRACP-5b),</li>
  <li>užívanie sevelaméru,</li>
  <li>väčší počet súčasne užívaných viazačov fosfátov,</li>
  <li>užívanie laxatív,</li>
  <li>nižšie skóre Bristolovej škály formy stolice (BSFS).</li>
</ul>

<p>Východiskové hodnoty oboch neskôr potvrdených ukazovateľov:</p>

<div class="table-responsive" role="region" aria-label="Východiskové hodnoty ukazovateľov kostného obratu a črevnej pasáže" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Nižšia dávka (n = 127)</th>
        <th scope="col">Vyššia dávka (n = 85)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">TRACP-5b (mU/dl)</th>
        <td>532,4 ± 312,9</td>
        <td>660,1 ± 389,3</td>
      </tr>
      <tr>
        <th scope="row">Bristolova škála (skóre)</th>
        <td>4,15 ± 0,87</td>
        <td>3,88 ± 0,89</td>
      </tr>
      <tr>
        <th scope="row">Počet stolíc (za týždeň)</th>
        <td>8,17 ± 3,76</td>
        <td>8,35 ± 3,37</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Po viacrozmernej korekcii zostali štatisticky významné iba dva faktory.</p>

<h3>TRACP-5b — marker kostnej resorpcie</h3>

<p>Každé zvýšenie TRACP-5b o 100 mU/dl bolo spojené s vyššou pravdepodobnosťou zaradenia do skupiny s vyššou dávkou: <strong>OR 1,121 (95 % IS 1,005–1,249; p = 0,040)</strong>.</p>

<p>Efekt treba čítať v mierke skutočného rozdielu medzi skupinami. Ten predstavoval približne 128 mU/dl, čomu zodpovedá pomer šancí okolo 1,16 — teda <strong>skromný efekt</strong>. Dolná hranica intervalu spoľahlivosti (1,005) sa navyše takmer dotýka jednotky. Ide o hranične štatisticky významnú asociáciu, ktorú treba považovať za signál na ďalšie skúmanie, nie za potvrdený prediktor použiteľný na samostatné rozhodovanie.</p>

<p>TRACP-5b je marker aktivity osteoklastov a kostnej resorpcie. Biologická úvaha autorov je priamočiara: približne <strong>85 % celkového telesného fosforu</strong> sa nachádza v kosti vo forme hydroxyapatitu a osteoklastová resorpcia ho uvoľňuje do obehu. Tenapanor pritom účinkuje výlučne v čreve a na kostnú resorpciu priamo nepôsobí. Pacient s vyšším prísunom fosfátov z kostného kompartmentu tak môže potrebovať intenzívnejšiu liečbu — alebo, presnejšie povedané, liečbu zameranú inam než na črevo.</p>

<p>Interpretácia je vierohodná, ale štúdia <strong>tok fosfátov z kostí priamo nemerala</strong> a nevykonávala kostnú biopsiu. TRACP-5b preto nie je dôkazom vysokého kostného obratu ani dôkazom, že kostná resorpcia spôsobila potrebu vyššej dávky.</p>

<p>Pôvodná publikácia navyše na jednom mieste označuje parathormón za „marker kostnej formácie“. To nie je presné: <strong>PTH je regulačný hormón</strong> ovplyvňujúci kostný obrat, nie marker formácie kosti. Medzi markery kostnej formácie patria kostná alkalická fosfatáza (bALP) a P1NP, medzi markery resorpcie CTX a práve TRACP-5b. Argument, že PTH nevykazoval asociáciu s dávkou, tak nemožno stavať proti nálezu s TRACP-5b ako protiváhu „formácia verzus resorpcia“ — ide o ukazovatele odlišnej povahy.</p>

<h3>Konzistencia stolice — a čo v skutočnosti meria</h3>

<p>Každé zvýšenie skóre Bristolovej škály o jeden stupeň bolo spojené s <strong>nižšou</strong> pravdepodobnosťou potreby vyššej dávky: <strong>OR 0,667 (95 % IS 0,468–0,951; p = 0,025)</strong>. V opačnom smere: každý stupeň smerom k tvrdšej stolici zvyšoval šancu na vyššiu dávku približne 1,5-násobne.</p>

<p>Nižšie skóre označuje tvrdšiu stolicu a sklon k zápche. Interpretácia je tu odlišná od TRACP-5b a treba ju povedať otvorene: pacienti so zápchou pravdepodobne <strong>lepšie tolerovali</strong> osmotický a sekrečný účinok tenapanoru, čo umožnilo intenzívnejšiu titráciu. Vyššia dávka teda nemusela odrážať farmakologickú potrebu, ale schopnosť pacienta dávku zniesť.</p>

<p>Počet stolíc za týždeň nebol nezávislým prediktorom — a pri pohľade na východiskové hodnoty (8,17 oproti 8,35 za týždeň) je zrejmé prečo: skupiny sa vo frekvencii prakticky nelíšili. <strong>Konzistencia stolice je pri hodnotení tolerancie informatívnejšia než frekvencia vyprázdňovania.</strong> To je poznatok použiteľný aj mimo tenapanoru.</p>

<h2>Gastrointestinálna bezpečnosť</h2>

<div class="table-responsive" role="region" aria-label="Gastrointestinálne nežiaduce účinky podľa dávkovej skupiny" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Nežiaduci účinok</th>
        <th scope="col">Nižšia dávka (n = 133)</th>
        <th scope="col">Vyššia dávka (n = 85)</th>
        <th scope="col">p</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Hnačka</th>
        <td>95 (71,4 %)</td>
        <td>57 (67,1 %)</td>
        <td>0,546</td>
      </tr>
      <tr>
        <th scope="row">Mäkká stolica</th>
        <td>7 (5,3 %)</td>
        <td>5 (5,9 %)</td>
        <td>1,000</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Hnačka bola veľmi častá v oboch skupinách a rozdiel nebol štatisticky významný. Záver, že vyššia dávka spôsobuje menej hnačky, by však bol <strong>nesprávny</strong>. Do skupiny s vyššou dávkou sa mohli dostať predovšetkým pacienti, ktorí liečbu lepšie tolerovali; tí citlivejší na gastrointestinálne účinky zostali na nižšej dávke alebo dávku nezvyšovali. Ide o <strong>selekciu podľa tolerancie</strong> — rovnaký mechanizmus, ktorý vysvetľuje aj nález s Bristolovou škálou. Obidva výsledky sú v skutočnosti dvoma pohľadmi na tú istú vec.</p>

<h2>Čo štúdia preukázala</h2>

<p>Medzi pacientmi, ktorí po titrácii dosiahli vyššiu dávku tenapanoru, boli častejšie prítomné:</p>

<ul>
  <li>vyššie východiskové hodnoty TRACP-5b,</li>
  <li>tvrdšia stolica a sklon k zápche.</li>
</ul>

<p>Zistenia podporujú individuálnu titráciu podľa fosfatémie a znášanlivosti. Naznačujú tiež, že pri nedostatočnej odpovedi na liečbu pôsobiacu v čreve treba uvažovať nielen o príjme fosfátov a adherencii, ale aj o <strong>kostnom obrate a liečbe sekundárnej hyperparatyreózy</strong>.</p>

<h2>Čo štúdia nepreukázala</h2>

<p>Výsledky nepreukazujú, že:</p>

<ul>
  <li>TRACP-5b spoľahlivo predpovedá optimálnu dávku u individuálneho pacienta,</li>
  <li>vyššia kostná resorpcia kauzálne znižuje účinnosť tenapanoru,</li>
  <li>zápcha je indikáciou na podávanie vysokej dávky,</li>
  <li>vyššia dávka je účinnejšia alebo bezpečnejšia než nižšia,</li>
  <li>tenapanor znižuje výskyt zlomenín, cievnych kalcifikácií, kardiovaskulárnych príhod alebo úmrtí.</li>
</ul>

<p>Hodnotenými ukazovateľmi boli dávka, fosfatémia a gastrointestinálna znášanlivosť. <strong>Klinické prognostické ukazovatele sa nesledovali</strong> — a práve tie zatiaľ chýbajú celej triede liečiv znižujúcich fosfatémiu.</p>

<h2>Metodologické obmedzenia</h2>

<p>Najdôležitejším obmedzením je <em>post hoc</em> observačný charakter analýzy. Skupiny nevznikli randomizáciou, ale retrospektívne podľa konečnej dávky. Dávka pritom bola priamo určovaná fosfatémiou a znášanlivosťou, teda vlastnosťami, ktoré sa následne analyzovali ako možné vysvetlenie dávky. Autori riziko <strong>kruhovej inferencie</strong> otvorene pripúšťajú a čiastočne ho tlmia zaradením východiskovej fosfatémie do viacrozmerného modelu — úplne ho však odstrániť nemožno.</p>

<p>Ďalšie obmedzenia:</p>

<ul>
  <li>zlúčenie troch štúdií s rozdielnym dizajnom (dve zaslepené, jedna otvorená a jednoramenná),</li>
  <li>zlúčenie monoterapie po vysadení viazačov s prídavnou liečbou; samostatné analýzy neboli pre malé počty uskutočniteľné,</li>
  <li>zlúčenie hemodialýzy, hemodiafiltrácie a peritoneálnej dialýzy napriek odlišnej kinetike odstraňovania fosfátov,</li>
  <li>krátke, osemtýždňové hodnotenie (v štúdii C sa nevyužilo dostupných 16 týždňov),</li>
  <li>iba 85 pacientov v skupine s vyššou dávkou pri veľkom počte premenných vo viacrozmernom modeli — riziko nadmerného prispôsobenia modelu,</li>
  <li>výlučne japonská populácia s dlhým dialyzačným vekom a odlišnými stravovacími zvyklosťami,</li>
  <li>protokolová titrácia, ktorá nemusí zodpovedať bežnej klinickej praxi,</li>
  <li>štúdiu financovala spoločnosť Kyowa Kirin, dvaja z piatich autorov sú jej zamestnancami a ďalší traja deklarujú honoráre alebo granty od výrobcu.</li>
</ul>

<p>Za zmienku stojí aj rozdiel v tóne: záver pôvodnej práce znie pomerne kategoricky („pacienti vyžadujúci vyššie dávky sa vyznačujú buď zvýšenou kostnou resorpciou, alebo sklonom k zápche“), hoci samotné údaje takúto istotu neunesú.</p>

<h2>Praktické využitie v dialyzačnej ambulancii</h2>

<p>Pred zvýšením dávky ktoréhokoľvek lieku znižujúceho črevnú absorpciu fosfátov je vhodné posúdiť:</p>

<ol>
  <li>fosfatémiu <strong>v čase</strong> — trend a variabilitu, nie jedinú hodnotu,</li>
  <li>príjem fosfátov vrátane fosfátových aditív v spracovaných potravinách,</li>
  <li>adherenciu a správne načasovanie viazačov vo vzťahu k jedlu,</li>
  <li>účinnosť dialýzy, dĺžku a frekvenciu procedúr a reziduálnu funkciu obličiek,</li>
  <li>liečbu sekundárnej hyperparatyreózy a jej primeranosť,</li>
  <li>ukazovatele kostného obratu — vždy v klinickom kontexte, nie izolovane,</li>
  <li>konzistenciu a frekvenciu stolice — konzistencia je informatívnejšia,</li>
  <li>súbežné užívanie laxatív a liekov spôsobujúcich zápchu alebo hnačku.</li>
</ol>

<p>TRACP-5b ani Bristolova škála zatiaľ nemajú nahradiť titráciu podľa fosfatémie a znášanlivosti. Môžu však pomôcť <strong>vysvetliť</strong>, prečo niektorí pacienti potrebujú intenzívnejšiu liečbu alebo prečo ju dokážu lepšie tolerovať.</p>

<h3>Čo si z toho odniesť, keď tenapanor k dispozícii nemáme</h3>

<p>Keďže tenapanor u nás dostupný nie je, praktická hodnota tejto práce je konceptuálna — a preto univerzálnejšia, než sa na prvý pohľad zdá. Úvaha o kostnom rezervoári totiž platí pre <strong>ktorúkoľvek</strong> stratégiu, ktorá zasahuje len črevný príjem fosfátov, teda aj pre všetky viazače. Ak fosfatémia neklesá napriek správne užívaným viazačom, primeranej diéte a dostatočnej dialyzačnej dávke, ďalšie zvyšovanie tabletovej záťaže nemusí byť správnou odpoveďou — otázka sa má presunúť <strong>od čreva ku kosti a k prištítnym telieskam</strong>.</p>

<p>Druhé posolstvo je jednoduchšie: pri liečivách s osmotickým črevným účinkom rozhoduje o dosiahnuteľnej dávke charakter stolice, nie počet stolíc. Stojí za to sa naň pýtať cielene.</p>

<h2>Záver</h2>

<p>Vyššia koncentrácia TRACP-5b a tvrdšia stolica boli v súhrnnej <em>post hoc</em> analýze spojené s vyššou konečnou dávkou tenapanoru. Prvý nález môže odrážať zvýšený prísun fosfátov z kostného kompartmentu, druhý pravdepodobne lepšiu toleranciu črevného účinku lieku. Sú to teda dva nálezy odlišnej povahy — jeden hovorí o potrebe, druhý o možnosti.</p>

<p>Obidve asociácie sú klinicky zaujímavé, ale zatiaľ nepredstavujú validované prediktory dávky. Tenapanor sa má titrovať individuálne podľa fosfatémie, gastrointestinálnej znášanlivosti a celkového manažmentu CKD-MBD. Potrebné sú prospektívne štúdie, ktoré vopred definujú prediktory odpovede, <strong>oddelia farmakodynamickú potrebu od tolerancie</strong> a vyhodnotia aj dlhodobé klinické výsledky.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=perzistujuca-hyperparatyreoza-po-transplantacii-oblicky">Perzistujúca hyperparatyreóza po transplantácii obličky</a> — druhá strana osi kosť–prištítne telieska.</li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a> — kontext tabletovej záťaže viazačov.</li>
  <li><a href="article.php?slug=online-hemodiafiltracia-davkovana-liecba-odporucania-sin">Online hemodiafiltrácia ako dávkovaná liečba</a> — dialyzačná zložka odstraňovania fosfátov.</li>
  <li><a href="article.php?slug=prukaloprid-brain-fog-depresia-kognicia-nefrologia">Prukaloprid, zápcha a kognícia</a> — črevná pasáž ako klinická premenná.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Nobuo Nagano, Shin Tokunaga, Shinji Asada, Masafumi Fukagawa, Tadao Akizawa.</strong> <em>Patient characteristics associated with the need for high doses of tenapanor hydrochloride in dialysis patients with hyperphosphatemia: A pooled analysis of three clinical trials.</em> PLOS ONE. 2026;21(8):e0356873. <a href="https://doi.org/10.1371/journal.pone.0356873" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Tadao Akizawa, Natsuki Urano, Kazuaki Ikejiri, Kaoru Nakanishi, Masafumi Fukagawa.</strong> <em>Tenapanor: A novel therapeutic agent for dialysis patients with hyperphosphatemia.</em> Therapeutic Apheresis and Dialysis. 2025;29(2):157–169. <a href="https://doi.org/10.1111/1744-9987.14241" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Kosaku Nitta, Saki Itoyama, Kazuaki Ikejiri, Jun Kinoshita, Kaoru Nakanishi, Masafumi Fukagawa, Tadao Akizawa.</strong> <em>Randomized Study of Tenapanor Added to Phosphate Binders for Patients With Refractory Hyperphosphatemia.</em> Kidney International Reports. 2023;8(11):2243–2253. <a href="https://doi.org/10.1016/j.ekir.2023.08.003" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Masaaki Inaba, Yotaro Une, Kazuaki Ikejiri, Hironori Kanda, Masafumi Fukagawa, Tadao Akizawa.</strong> <em>Dose-Response of Tenapanor in Patients With Hyperphosphatemia Undergoing Hemodialysis in Japan — A Phase 2 Randomized Trial.</em> Kidney International Reports. 2022;7(2):177–188. <a href="https://doi.org/10.1016/j.ekir.2021.11.008" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Stuart M. Sprague, Kevin J. Martin, Daniel W. Coyne.</strong> <em>Phosphate Balance and CKD–Mineral Bone Disease.</em> Kidney International Reports. 2021;6(8):2049–2058. <a href="https://doi.org/10.1016/j.ekir.2021.05.012" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Swetha Raju, Ramesh Saxena.</strong> <em>Hyperphosphatemia in Kidney Failure: Pathophysiology, Challenges, and Critical Role of Phosphorus Management.</em> Nutrients. 2025;17(9):1587. <a href="https://doi.org/10.3390/nu17091587" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Michel Vallée, Jordan Weinstein, Marisa Battistella, Roxanne Papineau, Dianne Moseley, Gordon Wong.</strong> <em>Multidisciplinary Perspectives of Current Approaches and Clinical Gaps in the Management of Hyperphosphatemia.</em> International Journal of Nephrology and Renovascular Disease. 2021;14:301–311. <a href="https://doi.org/10.2147/IJNRD.S318593" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Ebele M. Umeukeje, Amanda S. Mixon, Kerri L. Cavanaugh.</strong> <em>Phosphate-control adherence in hemodialysis patients: current perspectives.</em> Patient Preference and Adherence. 2018;12:1175–1191. <a href="https://doi.org/10.2147/PPA.S145648" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Yi-Wen Chiu, Isaac Teitelbaum, Madhukar Misra, Essel Marie de Leon, Tochi Adzize, Rajnish Mehrotra.</strong> <em>Pill Burden, Adherence, Hyperphosphatemia, and Quality of Life in Maintenance Dialysis Patients.</em> Clinical Journal of the American Society of Nephrology. 2009;4(6):1089–1096. <a href="https://doi.org/10.2215/CJN.00290109" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>XPHOZAH (tenapanor) tablets — Highlights of Prescribing Information.</em> 2023. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2023/213931s000lbl.pdf" target="_blank" rel="noopener noreferrer">FDA</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje pripísané súhrnnej analýze — 212 pacientov v analýze účinnosti (127 a 85), 218 v bezpečnostnej analýze (133 a 85), rozdelenie 107/54/51 podľa modality, vek 63,2 roka, 65,1 % mužov, 93,1 mesiaca dialyzačnej liečby, fosfor 7,39 mg/dl, korigovaný vápnik 8,88 mg/dl, diabetická nefropatia 32,1 %, dávky 8,0 ± 2,5 a 26,7 ± 4,9 mg dvakrát denne, p = 0,456, TRACP-5b 532,4 ± 312,9 oproti 660,1 ± 389,3 mU/dl, BSFS 4,15 ± 0,87 oproti 3,88 ± 0,89, stolice 8,17 ± 3,76 oproti 8,35 ± 3,37 za týždeň, OR 1,121 (95 % IS 1,005–1,249; p = 0,040), OR 0,667 (95 % IS 0,468–0,951; p = 0,025), hnačka 95 (71,4 %) oproti 57 (67,1 %) pri p = 0,546 a mäkká stolica 7 (5,3 %) oproti 5 (5,9 %) — boli overené proti plnému textu a tabuľkám otvorene prístupnej publikácie v PLOS ONE. Bibliografické údaje všetkých citovaných prác vrátane mien autorov boli overené v registri Crossref. Údaj o týždennom odstránení 1 800 – 2 520 mg fosfátov dialýzou pochádza z prehľadu Sprague a spol. (zdroj 5); podiel 85 % telesného fosforu v kosti uvádza samotná primárna práca. Porovnanie dávkovania medzi Japonskom a USA vychádza z registračných údajov FDA (zdroj 10) a z prehľadu Akizawa a spol. (zdroj 2); neprítomnosť tenapanoru v databáze centrálne registrovaných liekov EMA bola overená k septembru 2026. Kritické komentáre — skreslenie indikáciou, selekcia podľa tolerancie, mierka efektu TRACP-5b, nepresné označenie parathormónu za marker kostnej formácie a vnútorná nezrovnalosť v počtoch podľa modality — sú <strong>vlastným odborným hodnotením</strong>, nie záverom pôvodných autorov.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_tenapanor-vyssia-davka-kostna-resorpcia-crevna-pasaz_article',
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
