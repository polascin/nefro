<?php

/**
 * add_administrativna-zataz-lekarov-dokumentacia-vyhorenie_article.php
 * Odborný článok: administratívna a dokumentačná záťaž lekára, práca po ambulancii
 * a vyhorenie, s aplikáciou na nefrologickú prax.
 * Spracovaný zdroj: Hochwald L. Physicians Spend More Time on Paperwork Than With
 * Patients: The Squeeze of Invisible Work. Medscape Medical News, 21. 10. 2026.
 * Avíza sa pri tomto článku zámerne NEposielajú ('enqueue_newsletter' => false).
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
    'title'        => 'Administratívna a dokumentačná záťaž lekára: koľko času naozaj zaberá, prečo vedie k vyhoreniu a čo z toho platí pre nefrológiu',
    'slug'         => 'administrativna-zataz-lekarov-dokumentacia-vyhorenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Lekár v ambulantnej praxi strávi takmer dve hodiny dokumentáciou na každú hodinu priameho kontaktu s pacientom a ďalšiu hodinu až dve večer. Merania sú jednoznačné, riešenie „menej času pri počítači“ však nie je.',
    'content'      => <<<'HTML'
<figure><a href="img/administrativna-zataz-lekarov-dokumentacia-vyhorenie.webp" rel="noopener noreferrer" target="_blank"><img src="img/administrativna-zataz-lekarov-dokumentacia-vyhorenie.webp" alt="Prázdna ordinácia v noci, odsunutá stolička a na stole vysoká svietiaca kopa dokumentov vedľa monitora a stetoskopu" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nejde o snímku konkrétneho pracoviska. Práca, ktorá v rozvrhu nikde nefiguruje, sa aj tak musí niekde odohrať.</figcaption></figure>

<p>Viditeľná časť práce lekára je vyšetrenie a rozhodnutie. Časť, ktorá rozhoduje o tom, kedy odíde domov, je iná: žiadanky, správy z portálu pacienta, žiadosti o predchádzajúci súhlas poisťovne, obnovy receptov, zápisy a kontroly výsledkov. Je neviditeľná v rozvrhu, nemá vlastný kód výkonu a nevyžaduje prítomnosť pacienta. Práve preto sa dá odložiť, a práve preto sa odkladá na večer.</p>

<p>Prehľadový text, ktorý na tento jav upozornil v októbri 2026 na portáli Medscape, pracuje s pojmom, ktorý si americkí lekári vytvorili sami: <em>work after clinic</em>, skratkou WAC, teda práca po ambulancii. Je to presné pomenovanie, lebo nehovorí o nadčase v pracovnoprávnom zmysle. Hovorí o práci, ktorá sa vykonáva po tom, ako sa ambulancia zavrie, a ktorá sa nikde nezapočítava.<sup>1</sup></p>

<p>Otázka, ktorá rozhoduje o tom, či ide o sťažnosť alebo o doložený problém, znie: dá sa to zmerať? Dá. A merania existujú už desať rokov.</p>

<p>Že nejde o okrajovú nespokojnosť, naznačuje aj prieskum Medscape Insights: sedem z desiatich oslovených lekárov bolo nespokojných s tým, koľko času im zostáva na samotného pacienta, a spokojnosť so zápisom a administratívou hodnotili veľmi nízko, bez očakávania zlepšenia v najbližších piatich rokoch.<sup>2</sup></p>

<h2>Koľko času to naozaj je</h2>

<p>Štyri nezávislé práce s odlišnou metodikou dospeli k porovnateľnému obrazu. To je dôležitejšie než ktorékoľvek jednotlivé číslo, pretože každá z metód má inú slabinu, a výsledky sa napriek tomu zbiehajú.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Prehľad meraní času stráveného dokumentáciou a prácou v elektronickej zdravotnej dokumentácii" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Práca</th>
        <th scope="col">Metóda</th>
        <th scope="col">Hlavné zistenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Sinsky a kol., 2016<sup>9</sup></th>
        <td>Priame pozorovanie (430 hodín, 57 lekárov, 4 odbory) a denníky mimo ordinačných hodín</td>
        <td>27,0 % času v ordinačný deň pripadlo na priamy kontakt s pacientom, 49,2 % na dokumentáciu a kancelárske úkony. Na každú hodinu priameho kontaktu teda takmer dve hodiny dokumentácie. Navyše 1 až 2 hodiny každý večer.</td>
      </tr>
      <tr>
        <th scope="row">Arndt a kol., 2017<sup>4</sup></th>
        <td>Záznamy udalostí z elektronickej dokumentácie (142 lekárov, 3 roky), overené priamym pozorovaním</td>
        <td>355 minút (5,9 hodiny) z 11,4-hodinového pracovného dňa v systéme: 269 minút počas ordinačných hodín a 86 minút (1,4 hodiny) po nich. Kancelárske a administratívne úkony tvorili 157 minút (44,2 %), vybavovanie doručenej pošty ďalších 85 minút (23,7 %).</td>
      </tr>
      <tr>
        <th scope="row">Toscano a kol., 2020<sup>5</sup></th>
        <td>Ekologické momentálne hodnotenie cez aplikáciu v mobilnom telefóne (61 lekárov, 28 pracovísk, 16 štátov)</td>
        <td>Po odpočítaní osobného času pripadlo 66,5 % času na priamu starostlivosť o pacienta a 44,9 % celkovo na prácu v elektronickej dokumentácii, z toho 20,7 % výlučne na ňu a 23,6 % súbežne s kontaktom s pacientom.</td>
      </tr>
      <tr>
        <th scope="row">Rotenstein a kol., 2022<sup>7</sup></th>
        <td>Prevádzkové údaje o čase v systéme (291 lekárov primárnej starostlivosti, rok 2021)</td>
        <td>Priemerne 145,9 minúty denne strávených v elektronickej dokumentácii.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Údaje pochádzajú zo Spojených štátov a prevažne z primárnej starostlivosti. Prenositeľnosť absolútnych čísel do slovenskej nefrologickej ambulancie je preto obmedzená. Prenositeľný je však <strong>pomer</strong>: dokumentačná a administratívna zložka tvorí rádovo porovnateľný podiel pracovného dňa ako samotná klinická práca a nezanedbateľná časť z nej sa odohráva po skončení ambulancie.</p>

<h2>Čím sa jednotlivé merania navzájom kontrolujú</h2>

<p>Priame pozorovanie zachytí všetko, čo sa v ordinácii deje, ale je nákladné, pokrýva málo lekárov a samotná prítomnosť pozorovateľa môže správanie meniť. Záznamy udalostí zo systému pokryjú stovky lekárov a tisíce dní, nezachytia však prácu mimo systému, napríklad telefonát alebo papierovú žiadanku. Hodnotenie cez mobilnú aplikáciu zachytí aj činnosti, ktoré v zázname udalostí nezanechajú stopu, je však založené na sebahodnotení a v citovanej práci výslovne <strong>nedokázalo zmerať prácu doma</strong>, čím podiel práce po ambulancii skôr podhodnocuje.<sup>5</sup></p>

<p>Arndt a kol. urobili to, čo tento problém čiastočne rieši: údaje zo záznamov udalostí overili priamym pozorovaním a potvrdili ich ako spoľahlivý zdroj informácií o rozvrhnutí času lekára.<sup>4</sup> Práve toto overenie mení „pocit, že administratíva požiera čas“ na doložené zistenie.</p>

<h2>Použiteľnosť systémov je merateľná a hodnotenie je zlé</h2>

<p>Množstvo času nie je jediná veličina. Rovnako podstatné je, koľko úkonov si jedna úloha vyžiada. Melnick a kol. vyhodnotili v prierezovom prieskume medzi americkými lekármi použiteľnosť elektronickej zdravotnej dokumentácie štandardizovaným nástrojom System Usability Scale, ktorý sa bežne používa naprieč odvetviami.</p>

<p>Priemerné skóre bolo <strong>45,9</strong>, čo je v spodných 9 % spomedzi viac než 1 300 predchádzajúcich hodnotení z iných odvetví a zodpovedá pásmu „neprijateľné“, známkou F. Po úprave na vek, pohlavie, odbor, typ pracoviska, počet odpracovaných hodín a počet nočných pohotovostí sa každý bod lepšieho skóre spájal s o 3 % nižšou pravdepodobnosťou vyhorenia (pomer šancí 0,97; 95 % interval spoľahlivosti 0,97 – 0,98; p &lt; 0,001).<sup>6</sup></p>

<p>Ide o prierezový prieskum s návratnosťou 17,1 %, čo pripúšťa skreslenie výberom aj obrátenú príčinnosť: vyhorený lekár môže ten istý systém hodnotiť horšie. Nález je napriek tomu prakticky použiteľný. Hovorí, že nástroj, s ktorým lekár pracuje polovicu dňa, je používateľsky hodnotený horšie než takmer všetko ostatné, čo kedy niekto takto hodnotil, a že miera tohto hodnotenia sleduje mieru vyhorenia odstupňovane.</p>

<h2>Nepohodlné zistenie: viac času v dokumentácii sa spájalo s lepšími ukazovateľmi kvality</h2>

<p>Tu sa priamočiary záver „skrátiť čas v systéme“ láme. Rotenstein a kol. spojili prevádzkové údaje o čase strávenom v elektronickej dokumentácii s ukazovateľmi kvality starostlivosti na úrovni celého zoznamu pacientov jedného lekára. Výsledok bol opačný, než by sa čakalo.</p>

<p>Každých ďalších 15 minút celkového denného času v systéme sa po úprave spájalo s o 0,58 percentuálneho bodu lepšou kontrolou glykovaného hemoglobínu (95 % IS 0,32 – 0,84), o 0,52 bodu lepšou kontrolou hypertenzie (0,33 – 0,71) a o 0,28 bodu vyššou mierou skríningu karcinómu prsníka (0,05 – 0,52). Pri čase venovanom vybavovaniu doručenej pošty boli rozdiely výraznejšie: 2,26 bodu pri glykovanom hemoglobíne, 1,65 bodu pri hypertenzii a 1,26 bodu pri skríningu. Súvislosti sa sústreďovali u lekárov s úväzkom 0,5 a nižším. Pri skríningu diabetu a liečbe dyslipidémie sa žiadna súvislosť nenašla.<sup>7</sup></p>

<p>Autori to komentujú striedmo a presne: hoci sa dlhší čas v systéme spája s vyhorením, môže zároveň predstavovať mieru dôkladnosti a komunikácie, ktorá niektoré výsledky zlepšuje. Inak povedané, <strong>čas strávený dokumentáciou nie je sám osebe odpad</strong>. Časť z neho je skutočná klinická práca, ktorá sa len odohráva pri klávesnici: kontrola výsledku, odpoveď pacientovi, úprava dávky.</p>

<p>Pre riadenie z toho plynie konkrétne varovanie. Ak si pracovisko určí za cieľ skrátiť čas strávený dokumentáciou, môže spolu s ním skrátiť aj dôkladnosť. Cieľom nemá byť čas, ale <strong>podiel času, ktorý nevyžaduje kvalifikáciu lekára</strong>. Tieto dve veličiny sa dajú ľahko zameniť a ukazovateľ „minúty v systéme“ ich nerozlíši.</p>

<h2>Ekonomický rozmer, ktorý rozhoduje o tom, či niekto zasiahne</h2>

<p>Argument blahobytom zdravotníkov v rozpočtovom rozhovore spravidla neuspeje. Argument nákladom na náhradu lekára uspeje častejšie.</p>

<p>Americká lekárska asociácia uvádza, že priame náklady organizácie na náhradu jedného lekára sa pohybujú <strong>od 500 000 do viac než 1 milióna amerických dolárov</strong>; odhad zahŕňa nábor, nástupné bonusy, výpadok vykázaných výkonov a zapracovanie nového lekára. K tomu sa pripájajú nepriame náklady: chyby v poskytovaní starostlivosti, vyššie riziko sporu o náhradu škody, nižšia spokojnosť pacientov a poškodenie dobrého mena pracoviska. Náhrada lekára stojí pracovisko spravidla dvoj- až trojnásobok jeho ročnej mzdy.<sup>3</sup></p>

<p>Tento odhad pochádza z roku 2018, z amerického prostredia a z nominálnych dolárov; priamy prepočet na slovenské pomery možný nie je a číslo tu neslúži ako kalkulácia, ale ako rád veličiny. Ten prenositeľný je: v odbore, kde zapracovanie nefrológa trvá roky a kde v regióne nemusí byť koho osloviť, je cena odchodu jedného lekára neporovnateľne vyššia než náklad na administratívnu podporu, ktorá by jeho odchodu predišla.</p>

<h2>Prečo je nefrológia na túto záťaž zvlášť citlivá</h2>

<p>Nefrologická ambulancia, dialyzačné stredisko a konziliárna činnosť majú štyri vlastnosti, ktoré dokumentačnú záťaž znásobujú.</p>

<ol>
  <li><strong>Hustota opakovaných rozhodnutí medzi návštevami.</strong> Kaliémia, acidobázická rovnováha, anémia, metabolizmus vápnika a fosforu a krvný tlak sa sledujú priebežne a každá zmena hodnoty si vyžiada rozhodnutie, zápis a oznámenie pacientovi. Veľká časť nefrologickej práce sa nedeje počas návštevy, ale medzi návštevami.</li>
  <li><strong>Rozdelenie starostlivosti medzi viaceré pracoviská.</strong> Pacient na dialýze, pacient pripravovaný na transplantáciu aj pacient v predialyzačnej starostlivosti sa pohybujú medzi strediskom, ambulanciou, transplantačným centrom a lôžkovým oddelením. Každé rozhranie vytvára prenos dokumentácie, hlásenie zmien a kontrolu, či informácia dorazila.</li>
  <li><strong>Schvaľovacie postupy.</strong> Vybrané lieky, pomôcky a výkony si vyžadujú samostatné zdôvodnenie, doklady a opakovanú komunikáciu s poisťovňou. Táto práca je pre pacienta neviditeľná, pre lekára časovo náročná a pre systém spravidla nehonorovaná.</li>
  <li><strong>Dostupnosť mimo ordinačných hodín.</strong> Pacient so zavedeným režimom, jeho rodina aj spolupracujúci lekári sa obracajú na nefrológa s otázkami, ktoré neznesú odklad o týždeň, ale nie sú ani dôvodom na akútne vyšetrenie. Tento tok správ nemá v rozvrhu vlastné miesto, preto si ho nájde vo voľnom čase.</li>
</ol>

<p>Priame merania záťaže špecificky pre nefrológiu k dispozícii nie sú a uvedené body sú odvodené z povahy odboru, nie z meraní. Ten rozdiel treba priznať.</p>

<h2>Čo sa dá urobiť</h2>

<p>Nasledujúce kroky majú rôznu mieru doloženosti. Prvý a druhý vyplývajú priamo z citovaných prác, ostatné sú racionálne organizačné opatrenia bez priameho dôkazu o účinnosti v nefrológii.</p>

<h3>Najprv zmerať, potom škrtať</h3>

<p>Arndt a kol. ukázali, že záznamy udalostí dokážu rozdeliť čas na kategórie a identifikovať úkony, ktoré možno delegovať, čím sa záťaž dá znížiť bez straty obsahu.<sup>4</sup> Bez takého rozdelenia sa záťaž len presúva. Pre nefrologické pracovisko je užitočné vedieť, koľko času padne na vybavovanie správ, na reakcie na laboratórne zmeny, na podklady pre schvaľovanie a na opakované objednávanie, pretože každá z týchto položiek má iné riešenie.</p>

<h3>Delegovať úkony, nie zodpovednosť</h3>

<p>Časť činností, teda príprava podkladov, koordinácia termínov, štandardizované žiadosti a prvotné triedenie správ, nevyžaduje kvalifikáciu lekára a dá sa v rámci platných kompetencií presunúť na sestru alebo administratívneho pracovníka. Kritérium je jednoduché: vyžaduje tento úkon klinické rozhodnutie? Ak nie, do času lekára nepatrí. Klinická zodpovednosť za rozhodnutie zostáva nedelegovateľná.</p>

<h3>Vybavovanie správ urobiť viditeľným procesom</h3>

<p>Pokiaľ schránka správ nemá v rozvrhu vlastný čas, vlastné pravidlá triedenia a určenú zodpovednosť, stane sa z nej druhé, neevidované pracovisko. Vyhradené okno na odpovede počas pracovného času, jasné pravidlo, čo rieši sestra a čo lekár, a zrozumiteľná informácia pre pacienta o tom, kedy odpoveď príde, tlak na okamžitú reakciu znižujú. Vzhľadom na zistenie Rotensteina a kol. je namieste opatrnosť: cieľom je odbremeniť lekára od toho, čo robiť nemusí, nie skrátiť čas venovaný odpovediam pacientom.<sup>7</sup></p>

<h3>Štandardizovať zápis tam, kde šetrí úkony</h3>

<p>Šablóna má zmysel, ak uberá úkony a znižuje riziko opomenutia. Nemá zmysel, ak len vytvára dlhší text s rovnakým informačným obsahom. Kancelárske a administratívne úkony tvorili v práci Arndta a kol. 44,2 % času stráveného v systéme, čo je zároveň najväčší priestor na zlepšenie aj najväčšie riziko, že sa optimalizáciou stratí podstatná informácia.<sup>4</sup></p>

<h3>Technológiu nasadzovať s vopred určeným cieľom a kontrolou</h3>

<p>Nástroje, ktoré znižujú počet manuálnych vstupov, vrátane automatických zapisovačov, majú potenciál uvoľniť čas. Pred nasadením treba vedieť, ktorý konkrétny úkon majú nahradiť, kto a ako overí vecnú správnosť výstupu a čo sa stane s procesom kontroly dokumentácie. Zistenie o zlej použiteľnosti existujúcich systémov je pritom varovaním aj pre nové nástroje: pridaný systém, ktorý sa zle ovláda, záťaž nezníži, iba presunie.<sup>6</sup></p>

<h2>Prevalencia vyhorenia sa medzi pracoviskami líši, a to je dobrá správa</h2>

<p>Viacstredisková pilotná štúdia SUPERPOWER zisťovala vyhorenie u amerických školencov a lekárov v detskej nefrológii. Z 30 školencov a 86 lekárov z 11 pracovísk (návratnosť 85 %) spĺňalo kritériá vyhorenia <strong>13 % školencov a 16 % lekárov</strong>, teda podstatne menej, než sa v literatúre uvádza pre lekárov všeobecne.</p>

<p>Demografické a programové faktory s vyhorením nesúviseli. Súvisela s ním nižšia kvalita života, vyššia vnímaná záťaž stresom, nižšia spokojnosť s voľbou povolania a s rovnováhou medzi prácou a súkromím, a čo je pre riadenie najdôležitejšie, <strong>nižšia inštitucionálna podpora programov starostlivosti o zamestnancov a nižšia spokojnosť s podporou zo strany kolegov</strong>.<sup>8</sup></p>

<p>Ide o pilotnú prácu s malou vzorkou, so zberom od februára do apríla 2020 a s obmedzením na detskú nefrológiu v Spojených štátoch; autori sami uvádzajú, že na potvrdenie nižšej prevalencie treba väčšie štúdie. Smer zistenia je napriek tomu užitočný. Ak sa prevalencia medzi pracoviskami líši a líši sa podľa toho, čo pracovisko robí, potom nejde o nemennú vlastnosť odboru, ale o niečo, čo sa dá riadiť.</p>

<h2>Limity</h2>

<ul>
  <li>Všetky kvantitatívne merania pochádzajú zo Spojených štátov, z prostredia s odlišným financovaním, odlišnou administratívou poisťovní a odlišnými systémami dokumentácie. Absolútne čísla nie sú prenositeľné do slovenskej praxe.</li>
  <li>Prevažná väčšina údajov sa týka primárnej starostlivosti a niekoľkých vybraných odborov. Pre nefrológiu dospelých priame merania času stráveného dokumentáciou chýbajú.</li>
  <li>Všetky citované práce sú prierezové alebo observačné. Súvislosť medzi časom stráveným dokumentáciou, použiteľnosťou systému a vyhorením je asociáciou, nie dokázaným príčinným vzťahom, a obrátenú príčinnosť nemožno vylúčiť.</li>
  <li>Práca Toscana a kol. nedokázala zmerať prácu vykonanú doma, preto podiel práce po ambulancii podhodnocuje. Štúdia Sinského a kol. prebiehala v cielene vybraných, dobre fungujúcich ambulanciách, čo zovšeobecnenie obmedzuje opačným smerom.</li>
  <li>Odhad nákladov na náhradu lekára je americký, z roku 2018, a vychádza z modelových predpokladov. Ako kalkulácia pre slovenské pracovisko neplatí.</li>
  <li>Odporúčania v časti „Čo sa dá urobiť“ nie sú okrem merania a delegovania podložené intervenčnými štúdiami v nefrológii. Ide o organizačné opatrenia odvodené z povahy zistení.</li>
</ul>

<h2>Záver</h2>

<p>Tvrdenie, že lekár strávi dokumentáciou a administratívou porovnateľný čas ako starostlivosťou o pacienta, nie je dojem. Je to opakovane zmeraný údaj, ku ktorému dospeli štyri práce s odlišnou metodikou, a jedna z nich svoje meranie overila priamym pozorovaním. Časť tejto práce sa systematicky presúva za hranicu pracovného dňa a tam sa spája s vyhorením, ktoré má pre pracovisko aj vyčísliteľnú ekonomickú cenu.</p>

<p>Riešenie však nie je „menej času pri počítači“. Údaje ukazujú, že časť času stráveného dokumentáciou zodpovedá skutočnej dôkladnosti a súvisí s lepšími ukazovateľmi kvality. Zmysluplný cieľ je preto užší a náročnejší: odobrať lekárovi to, čo nevyžaduje jeho kvalifikáciu, zlepšiť ovládateľnosť nástrojov a dať vybavovaniu správ miesto v pracovnom čase. V nefrológii, kde sa podstatná časť rozhodovania odohráva medzi návštevami a medzi pracoviskami, je táto úloha naliehavejšia než vo väčšine odborov, hoci práve pre ňu zatiaľ chýbajú vlastné merania.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=lekari-cas-autonomia-vyhorenie-pracovne-podmienky">Lekári nežiadajú iba vyšší plat. Čoraz častejšie žiadajú späť kontrolu nad vlastným časom</a></li>
  <li><a href="article.php?slug=ai-zapisovace-zdravotna-dokumentacia-nefrologia">AI zapisovače a zdravotná dokumentácia: čo ukázalo kanadské hodnotenie</a></li>
  <li><a href="article.php?slug=eocr-nefrologicka-prax-kompetencie-dokumentacia-chyby">eOČR v nefrologickej praxi: kompetencie, dokumentácia a najčastejšie chyby</a></li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo už vieme, kde sú limity a kam to smeruje</a></li>
  <li><a href="article.php?slug=regulacia-medicinskej-umelej-inteligencie-fda-nefrologia">Regulácia medicínskej umelej inteligencie: čo by mal lekár vedieť a čo z toho plynie pre nefrológiu</a></li>
</ul>

<hr>

<p><small><em>Text má odborný informačný charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodovanie ani posúdenie miestnych organizačných a právnych podmienok. Uvedené americké údaje o financovaní, kompetenciách a nákladoch nie sú prenositeľné do slovenského prostredia bez overenia.</em></small></p>

<h2>Odborné zdroje</h2>

<ol>
  <li>Hochwald L. <em>Physicians Spend More Time on Paperwork Than With Patients: The Squeeze of Invisible Work.</em> Medscape Medical News, 21. októbra 2026. <a href="https://www.medscape.com/viewarticle/physicians-spend-more-time-paperwork-than-patients-squeeze-2026a10013gy" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><em>Medscape State of the Medical Profession Index Report 2026.</em> Medscape Insights, 2026. Bez uvedeného individuálneho autora. <a href="https://www.medscape.com/p11/medscape-state-medical-profession-index-report-2026-broken-2026a1000tf8" target="_blank" rel="noopener noreferrer">Správa</a>.</li>
  <li>Berg S. <em>How much physician burnout is costing your organization.</em> American Medical Association, 11. októbra 2018. <a href="https://www.ama-assn.org/practice-management/physician-health/how-much-physician-burnout-costing-your-organization" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li>Arndt BG, Beasley JW, Watkinson MD, Temte JL, Tuan WJ, Sinsky CA, Gilchrist VJ. <em>Tethered to the EHR: Primary Care Physician Workload Assessment Using EHR Event Log Data and Time-Motion Observations.</em> Annals of Family Medicine. 2017;15(5):419 – 426. doi: <a href="https://doi.org/10.1370/afm.2121" target="_blank" rel="noopener noreferrer">10.1370/afm.2121</a>. PMID 28893811, PMCID PMC5593724. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5593724/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li>Toscano F, O’Donnell E, Broderick JE, May M, Tucker P, Unruh MA, Messina G, Casalino LP. <em>How Physicians Spend Their Work Time: an Ecological Momentary Assessment.</em> Journal of General Internal Medicine. 2020;35(11):3166 – 3172. doi: <a href="https://doi.org/10.1007/s11606-020-06087-4" target="_blank" rel="noopener noreferrer">10.1007/s11606-020-06087-4</a>. PMID 32808212, PMCID PMC7661623. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7661623/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li>Melnick ER, Dyrbye LN, Sinsky CA, Trockel M, West CP, Nedelec L, Tutty MA, Shanafelt T. <em>The Association Between Perceived Electronic Health Record Usability and Professional Burnout Among US Physicians.</em> Mayo Clinic Proceedings. 2020;95(3):476 – 487. doi: <a href="https://doi.org/10.1016/j.mayocp.2019.09.024" target="_blank" rel="noopener noreferrer">10.1016/j.mayocp.2019.09.024</a>. PMID 31735343.</li>
  <li>Rotenstein LS, Holmgren AJ, Healey MJ, Horn DM, Ting DY, Lipsitz S, Salmasian H, Gitomer R, Bates DW. <em>Association Between Electronic Health Record Time and Quality of Care Metrics in Primary Care.</em> JAMA Network Open. 2022;5(10):e2237086. doi: <a href="https://doi.org/10.1001/jamanetworkopen.2022.37086" target="_blank" rel="noopener noreferrer">10.1001/jamanetworkopen.2022.37086</a>. PMID 36255725, PMCID PMC9579903. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9579903/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li>Halbach SM, Pillutla K, Seo-Mayer P, Schwartz A, Weidemann D, Mahan JD. <em>Burnout in Pediatric Nephrology Fellows and Faculty: Lessons From the Sustainable Pediatric Nephrology Workforce Project (SUPERPOWER).</em> Frontiers in Pediatrics. 2022;10:849370. doi: <a href="https://doi.org/10.3389/fped.2022.849370" target="_blank" rel="noopener noreferrer">10.3389/fped.2022.849370</a>. PMID 35601419.</li>
  <li>Sinsky C, Colligan L, Li L, Prgomet M, Reynolds S, Goeders L, Westbrook J, Tutty M, Blike G. <em>Allocation of Physician Time in Ambulatory Practice: A Time and Motion Study in 4 Specialties.</em> Annals of Internal Medicine. 2016;165(11):753 – 760. doi: <a href="https://doi.org/10.7326/M16-0961" target="_blank" rel="noopener noreferrer">10.7326/M16-0961</a>. PMID 27595430.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Zdrojový text na portáli Medscape bol 30. októbra 2026 prečítaný v celom rozsahu vrátane mena autorky a dátumu vydania. Úplné autorské zoznamy, ročníky, čísla, strany a identifikátory DOI, PMID a PMCID všetkých šiestich odborných prác boli v ten istý deň overené cez PubMed a Crossref; všetky uvedené číselné hodnoty vrátane podielov času, pomeru šancí, intervalov spoľahlivosti a percentuálnych bodov pochádzajú zo štruktúrovaných abstraktov pôvodných prác. Odhad nákladov na náhradu lekára bol overený priamo na stránke Americkej lekárskej asociácie, kde je uvedený spolu s menom autorky a dátumom vydania. Predloha článku pripisovala tento odhad asociácii bez uvedenia autorky, ktorá na stránke uvedená je, a neuvádzala, že v samotnom zdrojovom texte ho vyslovil prezident organizácie The Physicians Foundation; obidve skutočnosti sú tu opravené. Práce Sinského a kol. (2016), Melnicka a kol. (2020), Rotensteina a kol. (2022) a Halbacha a kol. (2022) v predlohe neboli, boli vyhľadané a doplnené pri spracovaní, rovnako ako celá časť o vzťahu času stráveného dokumentáciou a ukazovateľov kvality, ktorá záver predlohy podstatne koriguje.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_administrativna_zataz_lekarov_dokumentacia_vyhorenie',
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
