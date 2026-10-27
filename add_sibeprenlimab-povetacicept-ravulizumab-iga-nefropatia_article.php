<?php

/**
 * add_sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia_article.php
 * Tri studie fazy 3 pri IgA nefropatii (NEJM, oktober 2026):
 * VISIONARY (sibeprenlimab), RAINIER (povetacicept), I CAN (ravulizumab).
 *
 * Clanok je povodne spracovanie troch studii, nie prepis jedneho zdroja.
 * Autori studii su v literature, nie v source_authors.php.
 * enqueue_newsletter je zamerne false: aviza sa pri tomto clanku neposielaju.
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
    'title'        => 'Sibeprenlimab, povetacicept a ravulizumab pri IgA nefropatii: tri štúdie fázy 3',
    'slug'         => 'sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'VISIONARY ukázala sklon eGFR 0,3 oproti −4,2 ml/min/1,73 m² za rok. RAINIER a I CAN zatiaľ prinášajú výrazný pokles proteinúrie, nie tento údaj o funkcii obličiek.',
    'content'      => <<<'HTML'
<figure><a href="img/sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia.webp" rel="noopener noreferrer" target="_blank"><img src="img/sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia.webp" alt="Ilustračná polopriesvitná oblička v tme, do ktorej sa zbiehajú tri svietiace dráhy" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie snímka pacienta ani zobrazenie konkrétneho lieku. Tri dráhy sa zbiehajú v glomerule: blokáda APRIL, duálna blokáda BAFF a APRIL a terminálna inhibícia C5. Rovnaký cieľový orgán neznamená rovnakú zrelosť dôkazu.</figcaption></figure>

<p class="article-dek"><em>V jednom týždni vyšli tri placebom kontrolované štúdie fázy 3 pri IgA nefropatii. Len jedna z nich, VISIONARY, už ukazuje, čo sa za 24 mesiacov stane so sklonom odhadovanej glomerulovej filtrácie. Ďalšie dve zatiaľ odpovedajú na otázku proteinúrie.</em></p>

<p>Sibeprenlimab, povetacicept a ravulizumab zasahujú rôzne miesta tej istej choroby. Sibeprenlimab je humanizovaná monoklonálna protilátka proti ligandu indukujúcemu proliferáciu (APRIL). Povetacicept je upravený fúzny proteín s extracelulárnou doménou receptora TACI (TACI-Fc), skonštruovaný na súčasnú inhibíciu aktivačného faktora B-lymfocytov (BAFF) aj APRIL. Ravulizumab je terminálny inhibítor komplementu C5 a bráni vzniku C5a a komplexu C5b-9.<sup>1,2,3</sup> Spoločný cieľ, spomalenie straty nefrónov, z týchto troch publikácií ešte nevyplýva rovnakým spôsobom.</p>

<h2>Prečo proteinúria nestačí na porovnanie</h2>

<p>Pokles proteinúrie je pri IgA nefropatii užitočný a v regulačnom rámci prijateľný náhradný ukazovateľ. Americké zrýchlené schválenie sibeprenlimabu z 25. novembra 2025 sa oň priamo opiera. Označenie lieku Voyxact v znení aktualizovanom 17. marca 2026 však zároveň hovorí, že spomalenie dlhodobého poklesu funkcie obličiek v tom čase preukázané nebolo a že pokračovanie schválenia môže závisieť od konfirmačnej štúdie.<sup>4,5</sup> Októbrová finálna analýza VISIONARY je práve tento chýbajúci údaj. Samotná publikácia neznamená, že úrad už zrýchlené schválenie zmenil na riadne.</p>

<p>Povetacicept a ravulizumab sú v nových prácach v skoršej fáze toho istého oblúka. Ich priebežné analýzy majú ako primárny ukazovateľ 24-hodinový pomer bielkovín ku kreatinínu v moči (UPCR). Sklon eGFR majú štúdie naplánovaný, v týchto publikáciách ho však neudávajú.<sup>2,3,8,9</sup></p>

<h2>VISIONARY: sibeprenlimab a sklon eGFR za 24 mesiacov</h2>

<p>VISIONARY (NCT05248646) randomizovala dospelých s IgA nefropatiou na sibeprenlimab 400 mg subkutánne každé 4 týždne alebo na placebo. Randomizovaných bolo 510 pacientov, 259 na sibeprenlimab a 251 na placebo. Štúdiu financovala spoločnosť Otsuka.<sup>1</sup></p>

<p>Primárnym ukazovateľom štúdie bol 24-hodinový UPCR v 9. mesiaci. Ten už bol podkladom zrýchleného schválenia. V priebežnej analýze prvých 320 pacientov (152 a 168) americké označenie udáva geometrický priemer zmeny približne −50 % pri sibeprenlimabe a +2 % pri placebe, čo zodpovedá 51-percentnej redukcii oproti placebu (96,5 % interval spoľahlivosti [IS] od 43 do 58; <em>P</em> &lt; 0,0001). V tej istej priebežnej populácii bola priemerná vstupná eGFR 63 ml/min/1,73 m<sup>2</sup>, priemerný 24-hodinový UPCR 1,5 g/g a inhibítor SGLT2 užívalo 40 % pacientov.<sup>5</sup> Finálny abstrakt tieto deväťmesačné čísla neopakuje.</p>

<p>Kľúčovým sekundárnym ukazovateľom finálnej analýzy bol anualizovaný sklon eGFR počas 24 mesiacov.<sup>1</sup></p>

<div class="table-responsive" role="region" aria-label="Finálna analýza štúdie VISIONARY, sklon eGFR a bezpečnosť" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Sibeprenlimab (n = 259)</th>
        <th scope="col">Placebo (n = 251)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Anualizovaný sklon eGFR</th>
        <td>0,3 ml/min/1,73 m<sup>2</sup> za rok (95 % IS od −0,4 do 0,9)</td>
        <td>−4,2 ml/min/1,73 m<sup>2</sup> za rok (95 % IS od −4,9 do −3,6)</td>
      </tr>
      <tr>
        <th scope="row">Rozdiel sklonov</th>
        <td colspan="2">4,5 ml/min/1,73 m<sup>2</sup> za rok (95 % IS od 3,6 do 5,4; <em>P</em> &lt; 0,001)</td>
      </tr>
      <tr>
        <th scope="row">Rozdiel v zmene eGFR od vstupu do 24. mesiaca</th>
        <td colspan="2">9,2 ml/min/1,73 m<sup>2</sup> (95 % IS od 7,1 do 11,4; <em>P</em> &lt; 0,001)</td>
      </tr>
      <tr>
        <th scope="row">Kombinovaný ukazovateľ poklesu funkcie alebo zlyhania obličiek</th>
        <td>1 pacient (0,4 %)</td>
        <td>28 pacientov (11,2 %)</td>
      </tr>
      <tr>
        <th scope="row">Upravený rozdiel a pomer rizík</th>
        <td colspan="2">−10,8 percentuálnych bodov; pomer rizík 0,029 (95 % IS od 0,004 do 0,214; <em>P</em> &lt; 0,001)</td>
      </tr>
      <tr>
        <th scope="row">Nežiaduce udalosti</th>
        <td>235 (90,7 %)</td>
        <td>226 (90,0 %)</td>
      </tr>
      <tr>
        <th scope="row">Závažné nežiaduce udalosti</th>
        <td>21 (8,1 %)</td>
        <td>32 (12,7 %)</td>
      </tr>
      <tr>
        <th scope="row">Závažné infekcie</th>
        <td>5 (1,9 %)</td>
        <td>10 (4,0 %)</td>
      </tr>
      <tr>
        <th scope="row">Úmrtia</th>
        <td>0</td>
        <td>0</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Sklon 0,3 ml/min/1,73 m<sup>2</sup> za rok má interval, ktorý zahŕňa nulu. Ide teda o výsledok zhodný so stabilizáciou, nie o preukázaný vzostup filtrácie. Rozdiel 4,5 ml/min/1,73 m<sup>2</sup> za rok oproti placebu je veľký a štatisticky jednoznačný. Hodnota 9,2 ml/min/1,73 m<sup>2</sup> je rozdiel zmien od vstupu do 24. mesiaca, nie eGFR, ktorú pacienti na konci štúdie mali.<sup>1</sup></p>

<p>Kombinovaný ukazovateľ abstrakt opisuje ako pokles funkcie obličiek alebo zlyhanie obličiek. Jednotlivé zložky, napríklad hranicu percentuálneho poklesu eGFR, dialýzu alebo transplantáciu, abstrakt nevymenúva. V aktívnom ramene nastala jedna udalosť, v placebovom ramene 28. Absolútny rozdiel je 10,8 percentuálnych bodov. Pomer rizík 0,029 je extrémny práve preto, že stojí na jednej udalosti, a interval od 0,004 do 0,214 je široký. Jeho doplnok do jednotky je približne 97 %. To je len iný zápis toho istého pomeru, nie 97-percentné zníženie rizika terminálneho zlyhania obličiek.<sup>1</sup></p>

<p>Celková incidencia nežiaducich udalostí bola v oboch ramenách takmer rovnaká. Závažné udalosti a závažné infekcie boli početne nižšie pri sibeprenlimabe. Štúdia na tomto rozdiele nebola postavená ako na preukázaní väčšej bezpečnosti. Americké označenie žiada pred liečbou posúdiť aktívnu infekciu, počas liečby sledovať jej príznaky a nepodávať živé vakcíny v posledných 30 dňoch pred začatím ani počas liečby. Najčastejšie uvedené reakcie sú infekcia horných dýchacích ciest a erytém v mieste vpichu.<sup>1,5</sup></p>

<p>V tom istom označení vznikli protilátky proti lieku u 88 z 256 hodnotiteľných pacientov (34 %). U 21 z týchto 88 pacientov mali protilátky neutralizačnú aktivitu. Expozícia bola pri pozitívnych protilátkach približne o 40 % nižšia a pokles UPCR do 9. mesiaca bol číselne menší (41,6 % oproti 52,7 %). Klinický význam tohto rozdielu označenie nepokladá za objasnený.<sup>5</sup> Ide o údaj z tej časti štúdie, ktorá hodnotila proteinúriu v 9. mesiaci, nie o výsledok októbrovej analýzy eGFR.</p>

<p>Abstrakt finálnej analýzy vstupné kritériá nevypisuje. Označenie opisuje dospelých s biopsiou potvrdenou IgA nefropatiou, eGFR najmenej 30 ml/min/1,73 m<sup>2</sup>, 24-hodinovým UPCR najmenej 0,75 g/g alebo proteinúriou najmenej 1,0 g/deň a so stabilnou maximálne tolerovanou dávkou inhibítora ACE alebo blokátora receptora AT<sub>1</sub>, s inhibítorom SGLT2 alebo bez neho. Vylúčení boli pacienti s inou glomerulopatiou a pacienti so systémovou imunosupresiou v 16 týždňoch pred skríningom.<sup>5</sup> Register má navyše exploratívnu kohortu s eGFR od 20 do menej ako 30 ml/min/1,73 m<sup>2</sup>. Či je táto kohorta súčasťou publikovaných 510 pacientov, abstrakt nehovorí.<sup>7</sup></p>

<h2>RAINIER: povetacicept a proteinúria v 36. týždni</h2>

<p>RAINIER (NCT06564142) je prebiehajúca randomizovaná, dvojito zaslepená a placebom kontrolovaná štúdia fázy 3. Dospelí s biopsiou potvrdenou IgA nefropatiou na stabilnej podpornej liečbe boli randomizovaní v pomere 2 : 1 na povetacicept 80 mg subkutánne každé 4 týždne alebo na placebo. Liečbu dostalo 557 účastníkov, 372 povetacicept a 185 placebo. Prespecifikovaná priebežná analýza účinnosti zahŕňa prvých 199 randomizovaných, 131 a 68. Abstrakt uvádza financovanie spoločnosťou Vertex. V registri je ako zadávateľ uvedená spoločnosť Alpine Immune Sciences.<sup>2,8</sup></p>

<p>Primárnym ukazovateľom tejto analýzy bol 24-hodinový UPCR v 36. týždni. Klesol o 52,0 % pri povetacicepte a o 4,3 % pri placebe. Upravený rozdiel bol −49,8 percentuálnych bodov (95 % interval spoľahlivosti od −58,6 do −39,2; <em>P</em> &lt; 0,001).<sup>2</sup></p>

<p>Galaktózovo deficitný IgA1 (Gd-IgA1) klesol o 77,4 % a pri placebe stúpol o 9,1 % (upravený rozdiel −79,3 percentuálnych bodov, 95 % interval spoľahlivosti od −82,2 do −75,9; <em>P</em> &lt; 0,001). Hematúria, ak bola prítomná pri vstupe, do 36. týždňa vymizla u 85 % účastníkov s povetaciceptom a u 23 % s placebom (upravený rozdiel 62 percentuálnych bodov, 95 % interval spoľahlivosti od 45 do 78; <em>P</em> &lt; 0,001). Počet účastníkov v tejto podskupine abstrakt neudáva.<sup>2</sup></p>

<p>Incidencia nežiaducich udalostí bola 75 % a 78 %, závažných nežiaducich udalostí 3 % a 4 %. Abstrakt nehovorí, či sú to podiely zo 557 liečených, alebo z prvých 199. Úmrtia v abstrakte uvedené nie sú.<sup>2</sup></p>

<p>V registri je popri UPCR v 36. týždni primárnym ukazovateľom celej štúdie aj celkový sklon eGFR do 104. týždňa. Táto priebežná publikácia ho neprináša. Pokles proteinúrie, Gd-IgA1 a hematúrie preto zatiaľ nemožno čítať ako preukázané spomalenie straty funkcie.<sup>2,8</sup></p>

<p>Podľa oznámenia spoločnosti Vertex z 1. júna 2026 FDA prijala žiadosť o zrýchlené schválenie povetaciceptu pri IgA nefropatii a určila cieľový dátum rozhodnutia 30. novembra 2026. Ide o oznámenie žiadateľa, nie o schválenie.<sup>10</sup></p>

<h2>I CAN: ravulizumab a proteinúria v 34. týždni</h2>

<p>I CAN (NCT06291376) zaradila dospelých s IgA nefropatiou, eGFR najmenej 30 ml/min/1,73 m<sup>2</sup> a proteinúriou napriek štandardnej liečbe. Proteinúria znamenala 24-hodinový UPCR najmenej 0,75, pri bielkovine aj kreatiníne v gramoch, alebo celkovú proteinúriu najmenej 1,0 g/deň. Randomizácia bola 1 : 1 na intravenózny ravulizumab alebo placebo každé 8 týždňov. Randomizovaných bolo 485 pacientov, 240 a 245. Do priebežnej analýzy vstúpilo 352 pacientov, 176 v každom ramene. Štúdiu financovali Alexion a AstraZeneca Rare Disease Unit.<sup>3</sup></p>

<p>Register opisuje hmotnostne určenú úvodnú dávku v 1. deň, udržiavaciu dávku od 15. dňa a ďalej podanie každé 8 týždňov. Miligramové dávky abstrakt neuvádza a z dávkovania schválených indikácií ich nemožno do štúdie doplniť.<sup>3,9</sup></p>

<p>Geometrický priemer 24-hodinového UPCR klesol pri ravulizumabe z 1,56 na 0,83 a pri placebe z 1,60 na 1,48. Vnútri ramien to je zmena −46,6 % a −5,6 %. Primárne porovnanie je iné číslo: upravený geometrický priemer UPCR bol pri ravulizumabe o 43,4 % nižší než pri placebe (99 % interval spoľahlivosti od 30,1 do 54,2; <em>P</em> &lt; 0,001). Interval 99 %, nie 95 %, patrí k prísnejšej hladine priebežnej analýzy. Týchto 43,4 % nie je rozdiel vnútroskupinových zmien a nie je to 43,4 percentuálnych bodov.<sup>3</sup></p>

<p>Nežiaduce udalosti boli u 69,5 % a 75,8 % pacientov, závažné u 4,6 % a 9,0 %. Meningokoková infekcia ani úmrtie sa v priebežnej analýze nevyskytli.<sup>3</sup> Neprítomnosť udalosti v tomto okne nie je dôkaz, že terminálna inhibícia C5 je z hľadiska meningokoka bez rizika.</p>

<p>V súhrne charakteristických vlastností lieku Ultomiris nie je IgA nefropatia medzi indikáciami. Sú tam paroxyzmálna nočná hemoglobinúria, atypický hemolyticko-uremický syndróm, generalizovaná myasténia gravis s protilátkami proti receptoru pre acetylcholín a ochorenie spektra optickej neuromyelitídy s protilátkami proti akvaporínu 4. Pre tieto indikácie platí, že pacient musí byť očkovaný proti meningokokom najmenej dva týždne pred začatím ravulizumabu, pokiaľ riziko odkladu liečby nepreváži riziko infekcie. Ak sa liečba začne skôr, podáva sa antibiotická profylaxia až do dvoch týždňov po očkovaní. Odporúčané je krytie séroskupín A, C, Y, W135 a B. Očkovanie infekcii nezabráni spoľahlivo. Závažné a fatálne meningokokové infekcie boli hlásené pri ravulizumabe aj pri iných terminálnych inhibítoroch C5, u očkovaných aj neočkovaných.<sup>6</sup> Toto je požiadavka schváleného používania lieku. Priebežná analýza I CAN ju nenahrádza a indikáciu IgA nefropatie nezakladá.</p>

<p>Aj I CAN má neskorší ukazovateľ funkcie. V registri je zmena eGFR v 106. týždni primárnym ukazovateľom finálnej analýzy. V tejto publikácii nie je.<sup>9</sup></p>

<h2>Čo z trojice vyplýva a čo nie</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie otázky, na ktorú tri štúdie v tejto chvíli odpovedajú" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">VISIONARY</th>
        <th scope="col">RAINIER</th>
        <th scope="col">I CAN</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Liečba v štúdii</th>
        <td>sibeprenlimab 400 mg subkutánne každé 4 týždne</td>
        <td>povetacicept 80 mg subkutánne každé 4 týždne</td>
        <td>ravulizumab intravenózne, hmotnostne, každé 8 týždňov</td>
      </tr>
      <tr>
        <th scope="row">Čo táto publikácia rieši</th>
        <td>finálny sklon eGFR za 24 mesiacov</td>
        <td>priebežný UPCR v 36. týždni</td>
        <td>priebežný UPCR v 34. týždni</td>
      </tr>
      <tr>
        <th scope="row">Hlavný rozdiel oproti placebu</th>
        <td>4,5 ml/min/1,73 m<sup>2</sup> za rok</td>
        <td>−49,8 percentuálnych bodov UPCR</td>
        <td>geometrický priemer UPCR nižší o 43,4 %</td>
      </tr>
      <tr>
        <th scope="row">Čo ešte nie je v tejto práci</th>
        <td>deväťmesačný UPCR abstrakt neopakuje</td>
        <td>sklon eGFR do 104. týždňa</td>
        <td>eGFR v 106. týždni</td>
      </tr>
    </tbody>
  </table>
</div>

<p>VISIONARY je z trojice jediná práca, ktorá už viaže mechanizmus na trajektóriu eGFR a na kombinovaný ukazovateľ progresie. RAINIER k proteinúrii pridáva silný pokles Gd-IgA1 a vymiznutie hematúrie, teda biologickú stopu dráhy BAFF a APRIL. I CAN ukazuje, že aj samotná terminálna inhibícia C5 proteinúriu v 34. týždni zníži. To sú tri rôzne vety. Nedajú sa zložiť do poradia, v akom liek nasadiť, ani do tvrdenia, že jeden mechanizmus je účinnejší než druhý. Štúdie sa neporovnávali navzájom, nemali rovnaký horizont ani rovnaký primárny ukazovateľ v publikovanom čase.</p>

<p>Atacicept, iný TACI-Fc, má vlastnú štúdiu fázy 3 ORIGIN 3. Telitacicept je ďalšia duálna inhibícia BAFF a APRIL. Iptakopan zasahuje alternatívnu cestu komplementu proximálnejšie než ravulizumab a pri ňom už dvojročný sklon eGFR publikovaný bol. Čísla týchto prác patria do ich vlastných článkov. Sem nepatria ako nepriamy rebríček.</p>

<h2>Limity</h2>

<p>Plný text troch prác v <em>New England Journal of Medicine</em> je za platobnou bariérou. Čísla účinnosti a bezpečnosti v tomto článku sú z abstraktov. Vstupné kritériá VISIONARY, protilátky proti lieku a deväťmesačný UPCR sú z amerického označenia. Dávková schéma I CAN nad rámec abstraktu a neskoršie ukazovatele eGFR pri RAINIER a I CAN sú z registra. Tam, kde sa tieto vrstvy líšia, je to v texte povedané.</p>

<p>Kombinovaný ukazovateľ VISIONARY nie je v abstrakte rozložený na zložky. Jedna udalosť v aktívnom ramene robí pomer rizík nestabilným. Pri RAINIER nie je jasný menovateľ bezpečnostných percent. Pri žiadnej z troch prác abstrakt neudáva, aká časť celej analyzovanej populácie užívala inhibítor SGLT2. Štyridsať percent platí len pre priebežných 320 pacientov VISIONARY v americkom označení. Podporná liečba sa medzi začiatkom náboru a dneškom menila, takže absolútny prínos nad dnešnú plnú liečbu tieto práce samy neodzrkadľujú.</p>

<p>Všetky tri štúdie platil výrobca skúšaného lieku. Európsku registráciu sibeprenlimabu a povetaciceptu pri IgA nefropatii tento prehľad v dokumentoch EMA nenašiel. Ravulizumab európsku registráciu má, IgA nefropatia medzi jeho indikáciami v prečítanom súhrne nie je.</p>

<h2>Záver</h2>

<p>Sibeprenlimab v dávke 400 mg subkutánne každé 4 týždne udržal v štúdii VISIONARY dvojročný sklon eGFR pri nule (0,3 oproti −4,2 ml/min/1,73 m<sup>2</sup> za rok) a výrazne znížil výskyt kombinovaného ukazovateľa poklesu funkcie alebo zlyhania obličiek (1 oproti 28 udalostiam). Povetacicept a ravulizumab majú v týchto priebežných analýzach presvedčivý účinok na proteinúriu. Kým nepríde ich údaj o eGFR, nie je dôvod radiť ich so sibeprenlimabom podľa veľkosti percenta na UPCR.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza súhrn charakteristických vlastností lieku, platné odporúčania ani individuálne klinické rozhodnutie. Dávkovanie zo štúdie nie je schválené dávkovanie pri IgA nefropatii, pokiaľ ho tak neuvádza platné označenie lieku. Pri ravulizumabe ostáva podmienkou schváleného používania očkovanie proti meningokokom a vedomie, že očkovanie invazívnu infekciu nevylučuje.</em></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">Iptakopan a APPLAUSE-IgAN: 24-mesačný sklon eGFR pri inhibícii faktora B</a></li>
  <li><a href="article.php?slug=cielena-liecba-glomerulopatii-skrining-ckd-q3-2026">Atacicept a ORIGIN 3 v prehľade cielených liečeb z roku 2026</a></li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept pri IgA nefropatii, priebežná analýza fázy 3</a></li>
  <li><a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement pri IgA nefropatii: diagnostika, infekčné riziko a cielená inhibícia</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus liečby IgA nefropatie podľa KDIGO 2025</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li id="ref-rizk-2026"><strong>Dana V. Rizk, Jonathan Barratt, Yusuke Suzuki, Hong Zhang, Muh Geot Wong, Adrian Liew, Richard Lafayette, Vladimír Tesař, Hernán Trimarchi, Kevin Carroll, Ian S. D. Roberts, Vivekanand Jha, Alejandra Quevedo, Seung Hyeok Han, Rosnawati Yahya, Chee Kay Cheung, Raja Ramachandran, Michael Walsh, Bobby Chacko, Manuel Praga, Jin-Bor Chen, José Suassuna, Jing Xia, Lokesh Shah, Vlado Perkovic, VISIONARY Trial Investigators Group.</strong> <em>Sibeprenlimab in IgA Nephropathy. Final Phase 3 Trial Analysis.</em> New England Journal of Medicine. Zverejnené online 22. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. <a href="https://doi.org/10.1056/NEJMoa2609127" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2609127</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42911185/" target="_blank" rel="noopener noreferrer">PubMed 42911185</a>.</li>
  <li id="ref-barratt-rainier-2026"><strong>Jonathan Barratt, Hong Zhang, Seung Hyeok Han, Yuzuke Suzuki, James Tumlin, Bobby Chacko, Irene L. Noronha, Arvind Madan, Raphaël Duivenvoorden, Jamil R. Azzi, Carla Nester, Cassie Dong, Neil Ahluwalia, Jiahua Li, Carmen Bozic, Ogo Egbuna, Muh Geot Wong, Richard Lafayette, RAINIER AIS-D08 Trial Group.</strong> <em>Interim Analysis of a Phase 3 Trial of Povetacicept in IgA Nephropathy.</em> New England Journal of Medicine. Zverejnené online 23. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. Krstné meno štvrtého autora je v PubMed aj v Crossref uvedené ako Yuzuke. V štúdiách VISIONARY a I CAN je ten istý autor uvedený ako Yusuke Suzuki. Citácia zachováva znenie tejto publikácie. <a href="https://doi.org/10.1056/NEJMoa2608682" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2608682</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42912669/" target="_blank" rel="noopener noreferrer">PubMed 42912669</a>.</li>
  <li id="ref-barratt-ican-2026"><strong>Jonathan Barratt, Youssef M. K. Farag, Kara Rice, Tobin J. Cammett, Lesley A. Inker, Hernán Trimarchi, Annette Bruchfeld, Hiddo J. L. Heerspink, Adrian Liew, Kevin Carroll, Hong Zhang, Sayna Norouzi, Shuang Hou, Sehoon Park, Miguel Ángel Pérez Valdivia, Jai Radhakrishnan, Yusuke Suzuki, Bonnie Schneider, John Marsala, Cynthia Carrillo-Infante, Stephen L. Lake, Ajay K. Singh, Stephen Nolan, Richard A. Lafayette, I CAN Trial Group.</strong> <em>Ravulizumab in IgA Nephropathy. Interim Analysis of a Phase 3 Trial.</em> New England Journal of Medicine. Zverejnené online 23. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. <a href="https://doi.org/10.1056/NEJMoa2607544" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2607544</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42912700/" target="_blank" rel="noopener noreferrer">PubMed 42912700</a>.</li>
  <li id="ref-fda-voyxact-2025"><strong>U.S. Food and Drug Administration, Center for Drug Evaluation and Research.</strong> <em>Approval letter, BLA 761434, Voyxact (sibeprenlimab-szsi).</em> 25. november 2025. Zrýchlené schválenie na zníženie proteinúrie u dospelých s primárnou IgA nefropatiou s rizikom progresie. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/nda/2025/761434Orig1s000Approv.pdf" target="_blank" rel="noopener noreferrer">FDA, schvaľovací list</a>.</li>
  <li id="ref-dailymed-voyxact"><strong>Otsuka America Pharmaceutical.</strong> <em>Voyxact (sibeprenlimab-szsi) injection, for subcutaneous use. Prescribing information.</em> DailyMed, aktualizácia 17. marca 2026. Indikácia, dávka 400 mg každé 4 týždne, populácia a deväťmesačný UPCR štúdie VISIONARY, imunogenicita, infekcie a živé vakcíny. <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=c8a93b32-0676-4704-86dc-cb65f425c6e5" target="_blank" rel="noopener noreferrer">DailyMed</a>.</li>
  <li id="ref-ema-ultomiris"><strong>European Medicines Agency.</strong> <em>Ultomiris, INN-ravulizumab. Product information.</em> Časť 4.1 (indikácie bez IgA nefropatie) a časť 4.4 (meningokoková infekcia a očkovanie). <a href="https://www.ema.europa.eu/en/documents/product-information/ultomiris-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA, súhrn informácií o lieku</a>.</li>
  <li id="ref-nct-visionary"><strong>ClinicalTrials.gov.</strong> <em>Trial of Sibeprenlimab in the Treatment of IgA Nephropathy (VISIONARY), NCT05248646.</em> Otsuka Pharmaceutical Development and Commercialization. Vstupné kritériá vrátane exploratívnej kohorty. <a href="https://clinicaltrials.gov/study/NCT05248646" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li id="ref-nct-rainier"><strong>ClinicalTrials.gov.</strong> <em>Evaluation of Efficacy of Povetacicept in Adults With Immunoglobulin A Nephropathy (RAINIER), NCT06564142.</em> Alpine Immune Sciences. Primárne ukazovatele UPCR v 36. týždni a sklon eGFR do 104. týždňa. <a href="https://clinicaltrials.gov/study/NCT06564142" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li id="ref-nct-ican"><strong>ClinicalTrials.gov.</strong> <em>Study of Ravulizumab in Immunoglobulin A Nephropathy (I CAN), NCT06291376.</em> Alexion Pharmaceuticals. Hmotnostné dávkovanie a finálny ukazovateľ eGFR v 106. týždni. <a href="https://clinicaltrials.gov/study/NCT06291376" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li id="ref-vertex-2026"><strong>Vertex Pharmaceuticals.</strong> <em>Vertex Announces US FDA Acceptance of Biologics License Application for Accelerated Approval of Povetacicept in IgA Nephropathy.</em> Oznámenie spoločnosti, 1. jún 2026. Cieľový dátum rozhodnutia 30. november 2026. <a href="https://investors.vrtx.com/news-releases/news-release-details/vertex-announces-us-fda-acceptance-biologics-license-application" target="_blank" rel="noopener noreferrer">Vertex</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom.</strong> Abstrakty troch prác boli načítané z PubMed (efetch, PMID 42911185, 42912669 a 42912700). Úplné autorské zoznamy a dátumy online zverejnenia 22. a 23. októbra 2026 boli porovnané s Crossref. Skupinové autorstvo je z PubMed, lebo Crossref ho neuvádza. Ročník, číslo a strany Crossref ani PubMed v čase overenia nemali. Plný text NEJM nebol dostupný. Deväťmesačný UPCR, vstupné charakteristiky priebežných 320 pacientov, protilátky proti sibeprenlimabu, dávka 400 mg a upozornenie na živé vakcíny sú z označenia na DailyMed aktualizovaného 17. marca 2026, nie z októbrového abstraktu. Dátum zrýchleného schválenia je zo schvaľovacieho listu FDA. Indikácie ravulizumabu a znenie o očkovaní sú z častí 4.1 a 4.4 súhrnu EMA. Neskoršie ukazovatele eGFR a schéma úvodnej a udržiavacej dávky ravulizumabu sú z ClinicalTrials.gov, nie z abstraktu. Oznámenie Vertexu je sekundárny zdroj o podaní žiadosti, nie dokument FDA. Vlastné je čítanie hierarchie ukazovateľov, upozornenie na nestabilitu pomeru rizík pri jednej udalosti a odmietnutie poradia liečby. Európska registrácia sibeprenlimabu a povetaciceptu nebola v prehľade dokumentov EMA nájdená. Register ŠÚKL som osobitne neprešiel.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia_article',
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
