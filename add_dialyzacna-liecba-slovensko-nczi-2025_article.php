<?php

/**
 * add_dialyzacna-liecba-slovensko-nczi-2025_article.php
 * Dialyzacna liecba na Slovensku podla udajov NCZI za rok 2025
 * (Nefrologicka starostlivost a liecba nahradzajuca funkciu obliciek v SR 2025,
 *  publikovane august 2026), s porovnanim roku 2024 a klinickym kontextom.
 *
 * Institucionalny autor zdroja (NCZI) - individualni autori nie su uvedeni,
 * preto sa do source_authors.php nic nedoplna.
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
    'title'        => 'Dialyzačná liečba na Slovensku podľa údajov NCZI za rok 2025: čo z nich vyplýva a čo nie',
    'slug'         => 'dialyzacna-liecba-slovensko-nczi-2025',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V pravidelnej dialyzačnej liečbe bolo v roku 2025 evidovaných 4 352 pacientov – o 93 menej ako rok predtým. Prvý medziročný pokles po rokoch rastu, podiel peritoneálnej dialýzy 3 % a 118 transplantácií: čo tieto čísla znamenajú a čo z nich odvodiť nemožno.',
    'content'      => <<<'HTML'
<figure><a href="img/dialyzacna-liecba-slovensko-nczi-2025.webp" rel="noopener noreferrer" target="_blank"><img src="img/dialyzacna-liecba-slovensko-nczi-2025.webp" alt="Polopriesvitné obličky v tmavej scéne, z ktorých sa odvíja prúd jantárových svetelných bodov usporiadaných do mriežky pripomínajúcej celoštátny register" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nejde o snímku konkrétneho pacienta ani o zobrazenie reálneho pracoviska. Celoštátny register vidí počty; jednotlivého pacienta za nimi nevidí.</figcaption></figure>

<p class="article-dek"><em>Súhrnné celoštátne údaje sú cenné práve tým, čo o systéme povedia – a zavádzajúce práve tým, čo sa z nich povedať nedá. Správa Národného centra zdravotníckych informácií za rok 2025 prináša prvý medziročný pokles počtu dialyzovaných pacientov po dlhodobo rastúcom trende, veľmi nízky podiel peritoneálnej dialýzy a najnižší počet transplantácií obličky od roku 2021. Žiadny z týchto údajov sa však sám osebe nedá čítať ako hodnotenie kvality starostlivosti.</em></p>

<p>Národné centrum zdravotníckych informácií (NCZI) zverejnilo v auguste 2026 súhrnnú správu <em>Nefrologická starostlivosť a liečba nahrádzajúca funkciu obličiek v Slovenskej republike 2025</em>. Zdrojom sú ročné výkazy o činnosti nefrologickej ambulancie (A [MZ SR] 13-01) a o činnosti stacionára v odbore nefrológia (T [MZ SR] 2-01).</p>

<p>Výstup za rok 2025 nahrádza údaje za rok 2024, ktoré NCZI publikovalo v novembri 2025 a sprevádzalo tlačovou správou z 3. decembra 2025 s titulkom o tom, že dialýzu potrebuje čoraz viac seniorov. Tento článok vychádza z oboch výstupov, pretože až ich porovnanie ukazuje, ktoré závery sú stabilné a ktoré boli platné iba pre jeden rok.</p>

<h2>Čo ukazujú najnovšie celoštátne údaje</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie kľúčových ukazovateľov dialyzačnej starostlivosti na Slovensku za roky 2024 a 2025" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">2024</th>
        <th scope="col">2025</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Dialyzačné stacionáre, ktoré vykázali činnosť</th>
        <td>75</td>
        <td>72</td>
      </tr>
      <tr>
        <th scope="row">Lôžka pre pacientov vo veku 19 rokov a viac</th>
        <td>999</td>
        <td>962</td>
      </tr>
      <tr>
        <th scope="row">Pacienti v pravidelnej dialyzačnej liečbe (PDL)</th>
        <td>4 445</td>
        <td>4 352</td>
      </tr>
      <tr>
        <th scope="row">Pacienti v PDL na 100 000 obyvateľov</th>
        <td>82,0</td>
        <td>80,5</td>
      </tr>
      <tr>
        <th scope="row">Liečení hemodialýzou k 31. 12.</th>
        <td>3 319</td>
        <td>3 330</td>
      </tr>
      <tr>
        <th scope="row">Liečení peritoneálnou dialýzou k 31. 12.</th>
        <td>94</td>
        <td>103</td>
      </tr>
      <tr>
        <th scope="row">Osoby na transplantačnej čakacej listine k 31. 12.</th>
        <td>372</td>
        <td>348</td>
      </tr>
      <tr>
        <th scope="row">Transplantácie obličky</th>
        <td>140</td>
        <td>118</td>
      </tr>
      <tr>
        <th scope="row">Evidované úmrtia osôb liečených v PDL</th>
        <td>595</td>
        <td>548</td>
      </tr>
      <tr>
        <th scope="row">Osoby s CKD v 5. štádiu v nefrologických ambulanciách, nezaradené do PDL</th>
        <td>1 529</td>
        <td>1 500</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Každý riadok tejto tabuľky má inú metodickú povahu. Počet pacientov v PDL je prevalenčný údaj za celý rok. Počty liečených hemodialýzou a peritoneálnou dialýzou sú stavy k 31. decembru. Počet transplantácií je ročný tok. Osoby na čakacej listine sú stav k jednému dňu. Tieto ukazovatele <strong>nemožno navzájom deliť ani sčítavať</strong> bez toho, aby sme si uvedomili, že ide o rôzne typy veličín.</p>

<p>Názorne to ukazuje samotná správa. K 31. decembru 2025 bolo hemodialýzou liečených 3 330 a peritoneálnou dialýzou 103 pacientov, spolu teda 3 433 osôb. Za celý rok však bolo v PDL evidovaných 4 352 pacientov. Rozdiel nie je chybou – vyjadruje, že počas roka časť pacientov zomrela, podstúpila transplantáciu alebo z programu odišla z iných dôvodov.</p>

<h2>Medziročný pokles neznamená, že zlyhania obličiek ubúda</h2>

<p>Miera pacientov v PDL klesla z 82,0 na 80,5 prípadu na 100 000 obyvateľov, teda o 1,2 %, čo v absolútnom vyjadrení predstavuje 93 osôb. Ide o prvý pokles po období, ktoré NCZI dlhodobo opisovalo ako rastúce; od roku 2009 miera stúpla o 11 %.</p>

<p>Pokles o 1,2 % v jedinom roku <strong>nie je dôkazom obratu trendu</strong>. Prevalencia dialyzovaných pacientov je výsledkom rovnováhy medzi prítokom a odtokom. Zvýšiť ju môže vyšší výskyt zlyhania obličiek alebo dlhšie prežívanie; znížiť ju môže viac transplantácií, vyššia úmrtnosť, menej nových pacientov, ale aj zmena vo vykazovaní.</p>

<p>Práve posledná možnosť si zaslúži pozornosť. Počet stacionárov, ktoré vykázali činnosť, klesol zo 75 na 72 a počet lôžok z 999 na 962. Správa za rok 2025 navyše uvádza, že na začiatku roka bolo hemodialýzou liečených 3 172 pacientov, hoci podľa správy za rok 2024 ich na konci predchádzajúceho roka bolo 3 319. Takýto nesúlad medzi koncom jedného a začiatkom nasledujúceho roka ukazuje, že časť medziročnej zmeny môže vzniknúť na úrovni vykazujúcich pracovísk, nie v epidemiológii.</p>

<p>Zodpovedný záver preto znie: miera dialyzovaných pacientov v roku 2025 mierne klesla, dlhodobý trend zostáva rastúci a na posúdenie, či ide o začiatok zmeny, bude potrebných viac rokov a stabilné vykazovanie.</p>

<h2>Diabetes a cievne poškodenie obličiek dominujú diagnostickej štruktúre</h2>

<p>Podľa vykazovanej základnej diagnózy tvorili v roku 2025 pacienti v PDL:</p>

<ul>
  <li><strong>34,8 %</strong> glomerulová choroba pri diabetes mellitus, teda diabetická nefropatia (N08.3) – 1 513 osôb,</li>
  <li><strong>15,2 %</strong> hypertenzná a vaskulárna nefroskleróza (I12 – I13, I70.1, N28.0) – 661 osôb,</li>
  <li><strong>15,1 %</strong> tubulointersticiálne nefritídy (N10 – N16) – 657 osôb,</li>
  <li><strong>11,7 %</strong> primárne (N00 – N06) a hereditárne (N07) glomerulové choroby – 510 osôb,</li>
  <li><strong>6,0 %</strong> sekundárne glomerulové choroby okrem diabetu, <strong>5,5 %</strong> polycystické obličky a <strong>3,3 %</strong> nešpecifikovaná choroba obličiek.</li>
</ul>

<p>Rozloženie je medziročne takmer nezmenené (v roku 2024 to bolo 34,8 %, 15,8 %, 15,0 % a 12,4 %). Diagnostická štruktúra dialyzovanej populácie je teda stabilná a dominuje jej metabolické a cievne poškodenie obličiek.</p>

<p>Tieto podiely však <strong>nevyjadrujú riziko</strong>, že konkrétny človek s diabetom alebo hypertenziou bude potrebovať dialýzu. Opisujú zloženie dialyzovanej populácie, nie pravdepodobnosť progresie. Na takéto hodnotenie by boli potrebné údaje o všetkých osobách s danou chorobou a o ich dlhodobom sledovaní.</p>

<p>Užitočné je porovnanie s ambulantnou nefrologickou starostlivosťou, kde bolo v roku 2025 sledovaných 149 527 osôb. Tam tvorila diabetická nefropatia iba 20,1 % a tubulointersticiálne nefritídy 18,8 %. Diabetické poškodenie obličiek je teda v dialyzačnej populácii zastúpené <strong>takmer dvojnásobne</strong> oproti ambulantnej. To je zlučiteľné s vyššou pravdepodobnosťou progresie do zlyhania obličiek, no samo osebe to nedokazuje – rovnaký obraz by mohol vzniknúť aj rozdielnym prežívaním alebo rozdielnou dostupnosťou transplantácie.</p>

<p>Pri diabete treba navyše dôsledne rozlišovať štatistickú kategóriu, klinickú diagnózu a histologický nález. Označenie „glomerulová choroba pri diabetes mellitus“ je prevzaté z vykazovania a nie je dôkazom, že u každého takto zaradeného pacienta bolo diabetické poškodenie potvrdené biopsiou. Nie každá chronická choroba obličiek u človeka s diabetom je spôsobená diabetom.</p>

<p>Podobne hypertenzia môže k poškodeniu obličiek prispievať, ale môže byť aj jeho dôsledkom. Súhrnná štatistika tieto vzťahy nerozlišuje.</p>

<h2>Vek mení potreby pacienta, nie je však kritériom rozhodovania</h2>

<p>Potreba dialyzačnej liečby rastie s vekom veľmi výrazne. Vekovo špecifické miery za rok 2025 to ukazujú lepšie ako samotné poradie skupín:</p>

<div class="table-responsive" role="region" aria-label="Počet pacientov v pravidelnej dialyzačnej liečbe podľa veku na 100 000 obyvateľov daného veku" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Veková skupina</th>
        <th scope="col">2024 (na 100 000 obyvateľov daného veku)</th>
        <th scope="col">2025 (na 100 000 obyvateľov daného veku)</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">70 rokov a viac</th><td>268,6</td><td>257,2</td></tr>
      <tr><th scope="row">60 – 69 rokov</th><td>176,6</td><td>168,9</td></tr>
      <tr><th scope="row">50 – 59 rokov</th><td>97,4</td><td>94,7</td></tr>
      <tr><th scope="row">40 – 49 rokov</th><td>44,7</td><td>44,0</td></tr>
      <tr><th scope="row">30 – 39 rokov</th><td>28,0</td><td>27,7</td></tr>
      <tr><th scope="row">19 – 29 rokov</th><td>12,8</td><td>13,1</td></tr>
      <tr><th scope="row">Slovenská republika spolu</th><td>82,0</td><td>80,5</td></tr>
    </tbody>
  </table>
</div>

<p>Medzi skupinou 19 – 29 rokov a skupinou 70 rokov a viac je rozdiel takmer dvadsaťnásobný. Vekovo špecifické miery zároveň ukazujú, že medziročný pokles celkovej miery nebol rovnomerný: v najstarších skupinách klesla výraznejšie, v skupine 19 – 29 rokov naopak mierne stúpla.</p>

<p>Prevaha starších pacientov má praktické dôsledky pre organizáciu starostlivosti. U nich je potrebné venovať väčšiu pozornosť funkčnej zdatnosti, krehkosti, výžive, kognitívnym schopnostiam, riziku pádov, dostupnosti pomoci v domácnosti a záťaži spojenej s dopravou na pracovisko a zotavením po procedúre.</p>

<p>Kalendárny vek však <strong>nie je dostatočným podkladom</strong> na rozhodnutie o začatí, pokračovaní či spôsobe dialýzy. Klasická práca Kurella Tamura a spolupracovníkov na 3 702 obyvateľoch amerických zariadení dlhodobej starostlivosti ukázala, že dvanásť mesiacov po začatí dialýzy bolo 58 % z nich mŕtvych a predialyzačnú funkčnú zdatnosť si zachovalo iba 13 %. Táto populácia je mimoriadne krehká a výsledky nemožno zovšeobecňovať na všetkých starších pacientov – práve preto je ich odkazom individuálne posúdenie, nie vekový limit.</p>

<h2>Modalita: hemodialýza takmer bez alternatívy</h2>

<p>Správa za rok 2025 umožňuje spoľahlivo posúdiť zastúpenie dialyzačných metód. K 31. decembru 2025 bolo hemodialýzou liečených 3 330 pacientov (2 078 mužov a 1 252 žien) a peritoneálnou dialýzou 103 pacientov. Peritoneálna dialýza teda tvorila <strong>približne 3 % dialyzovanej populácie</strong> (v roku 2024 približne 2,8 %).</p>

<p>Pre porovnanie: podľa výročnej správy registra Európskej renálnej asociácie (ERA) za rok 2022, ktorá pokrývala 530 miliónov obyvateľov z 35 krajín, tvorila peritoneálna dialýza 5 % všetkých pacientov liečených náhradou funkcie obličiek a hemodialýza 56 %. Prepočítané na samotnú dialyzovanú populáciu ide o približne <strong>8 % peritoneálnej dialýzy</strong>, teda zhruba dvaapolnásobok slovenského podielu.</p>

<p>Regionálne rozdiely sú ešte výraznejšie než celoštátny priemer. V Bratislavskom kraji bolo ku koncu roka 2025 peritoneálnou dialýzou liečených 22 pacientov a v Banskobystrickom 27, zatiaľ čo v Trnavskom kraji 2 a v Prešovskom kraji NCZI neuvádza žiadneho. Z celkových 103 pacientov bolo 81 liečených automatizovanou a 41 kontinuálnou ambulantnou peritoneálnou dialýzou (pacient, u ktorého boli použité oba typy, je započítaný v oboch skupinách).</p>

<p>Tieto čísla samy osebe nehovoria, prečo je podiel domácej metódy taký nízky. Prispievať môže zloženie pacientov, dostupnosť predialyzačnej edukácie, personálne a technické zabezpečenie pracovísk, spôsob úhrady aj preferencie pacientov. Údaje však ukazujú, kde by sa dal priestor na zmenu hľadať – a že ten priestor nie je rozložený rovnomerne po krajoch.</p>

<p>Pozoruhodný je aj údaj o type mimotelovej liečby. V roku 2025 bolo vykázaných 449 333 procedúr hemodiafiltrácie oproti 53 251 procedúram klasickej hemodialýzy; hemodiafiltrácia teda tvorila približne <strong>89 % mimotelových eliminačných procedúr</strong>. To je klinicky priaznivé zistenie: randomizovaná štúdia CONVINCE s 1 360 pacientmi preukázala, že vysokoobjemová hemodiafiltrácia znižuje celkovú úmrtnosť oproti konvenčnej vysokoprietokovej hemodialýze (17,3 % oproti 21,9 %; HR 0,77; 95 % IS 0,65 – 0,93).</p>

<p>Dôležitá výhrada: výkaz NCZI eviduje počty procedúr, <strong>nie dosahovaný konvekčný objem</strong>. Prínos preukázaný v štúdii CONVINCE bol viazaný na vysoký konvekčný objem (v priemere 25,3 litra na procedúru). Z počtu vykázaných procedúr hemodiafiltrácie preto nemožno usudzovať, že slovenskí pacienti dostávajú dávku porovnateľnú s tou, ktorá prínos preukázala.</p>

<h2>Kategória G5 neznamená automatickú indikáciu dialýzy</h2>

<p>V nefrologických ambulanciách bolo v roku 2025 evidovaných 1 500 osôb s chronickou chorobou obličiek v 5. štádiu, ktoré neboli zaradené do pravidelnej dialyzačnej liečby. Osobitne správa uvádza 664 pacientov s týmto ochorením zaradených do PDL.</p>

<p>Tieto dve hodnoty <strong>nemožno interpretovať</strong> tak, že 664 pacientov pochádzalo práve zo skupiny 1 500 osôb, a nemožno z nich počítať podiel tých, ktorí počas roka „prešli na dialýzu“.</p>

<p>Z klinického hľadiska kategória G5 podľa KDIGO označuje chronickú chorobu obličiek s odhadovanou glomerulovou filtráciou nižšou ako 15 ml/min/1,73 m². Sama osebe neurčuje deň začatia dialýzy. Rozhodujú prejavy zlyhania obličiek, zvládnuteľnosť porúch vnútorného prostredia a objemového stavu, výživový stav a celkový klinický kontext.</p>

<p>Randomizovaná štúdia IDEAL u 828 pacientov porovnávala plánované začatie dialýzy pri odhadovanej glomerulovej filtrácii 10 – 14 ml/min oproti 5 – 7 ml/min. Po mediáne sledovania 3,59 roka sa úmrtnosť medzi skupinami nelíšila (37,6 % oproti 36,6 %; HR 1,04; 95 % IS 0,83 – 1,30), rovnako ani výskyt kardiovaskulárnych príhod, infekcií a komplikácií dialýzy. Pozoruhodné je, že 75,9 % pacientov v skupine s neskorým začatím začalo dialýzu skôr, než klesli na cieľovú hodnotu – pre rozvoj príznakov. Práve to podporuje záver, že o načasovaní má rozhodovať klinický stav, nie prahová hodnota filtrácie.</p>

<p>Medzi naliehavé dôvody na začatie dialyzačnej liečby patria nezvládnuteľná hyperkaliémia, metabolická acidóza, prevodnenie a uremické komplikácie. Naliehavosť sa posudzuje individuálne a nemožno ju určiť z jednej hodnoty kreatinínu ani z odhadovanej glomerulovej filtrácie.</p>

<p>Nezaradenie pacienta s kategóriou G5 do PDL preto samo osebe <strong>nepreukazuje zanedbanie ani nedostupnosť starostlivosti</strong>. Môže ísť o klinicky odôvodnené sledovanie, prípravu na náhradu funkcie obličiek alebo o individuálne zvolenú komplexnú konzervatívnu starostlivosť. Systematický prehľad jedenástich štúdií porovnávajúcich konzervatívny a dialyzačný postup u pacientov s 5. štádiom CKD – prevažne u starších osôb – nezistil prevahu dialýzy v prežívaní, hospitalizáciách ani kvalite života. Prehľad je metodicky obmedzený prevahou observačných štúdií a výberovým skreslením a jeho výsledky nemožno zovšeobecniť na mladších pacientov, upozorňuje však, že nezaradenie do dialýzy nie je automaticky horšou alternatívou. Súhrnné údaje NCZI tieto situácie nerozlišujú.</p>

<h2>Transplantácia obličky nie je podmienená predchádzajúcou dialýzou</h2>

<p>Ku koncu roka 2025 bolo na transplantačnej čakacej listine 348 osôb a v priebehu roka podstúpilo transplantáciu obličky 118 pacientov. Oproti roku 2024 (372 osôb a 140 transplantácií) ide o pokles v oboch ukazovateľoch a o najnižší počet transplantácií od roku 2021.</p>

<p>Tu je namieste <strong>vecná oprava formulácie samotného zdroja</strong>. Správa NCZI uvádza, že transplantácia obličky sa vykonáva u pacientov, ktorí pravidelne podstupujú dialyzačnú liečbu, a že podmienkou je „dobrý zdravotný stav pacienta“. Obe formulácie sú zjednodušujúce.</p>

<p>Transplantácia obličky nie je vyhradená pacientom, ktorí už dialýzu podstupujú. U vhodného kandidáta možno vykonať <strong>preemptívnu transplantáciu</strong>, teda transplantáciu pred začatím pravidelnej dialyzačnej liečby. Nejde o okrajovú možnosť: podľa registra ERA tvorila preemptívna transplantácia v roku 2022 <strong>5 % všetkých začatí náhrady funkcie obličiek</strong> v sledovaných európskych krajinách. Rozsiahla analýza 38 836 prvých transplantácií obličky zistila, že preemptívna transplantácia bola spojená s nižším rizikom zlyhania štepu (relatívne riziko 0,75 pri darcovi po smrti a 0,73 pri žijúcom darcovi) aj s nižším rizikom úmrtia (0,84, resp. 0,69). Ide o observačné údaje, pri ktorých nemožno vylúčiť, že preemptívne transplantovaní pacienti boli vybranejšou skupinou.</p>

<p>Ani transplantačnú spôsobilosť nemožno zúžiť na „dobrý zdravotný stav“. Odporúčanie KDIGO z roku 2020 ju definuje ako odborné posúdenie pomeru prínosu a rizika, imunologických a psychosociálnych faktorov, jednotlivých komorbidít a možnosti dlhodobej potransplantačnej starostlivosti – pričom každý rizikový faktor sa posudzuje samostatne a výsledkom je celkový úsudok, nie splnenie jedinej podmienky.</p>

<p>Pomer 348 čakajúcich k 4 352 dialyzovaným <strong>nemožno interpretovať</strong> ako podiel pacientov, ktorým bola transplantácia neoprávnene odopretá. Na posúdenie dostupnosti transplantácie sú potrebné údaje o spôsobilosti, odosielaní na vyšetrenie, dôvodoch nezaradenia a čase strávenom na čakacej listine.</p>

<p>Určitý kontext predsa len poskytnúť možno. Pri počte obyvateľov 5 409 407 k 31. decembru 2025 zodpovedá 118 transplantácií približne 21,8 výkonu na milión obyvateľov; v roku 2024 to bolo približne 25,8. Register ERA uvádza za rok 2022 priemernú mieru transplantácií 40 na milión obyvateľov. Ide o hrubé, vekovo neštandardizované porovnanie s inou metodikou aj iným rokom a slovenský údaj navyše zahŕňa iba transplantácie u pacientov z vlastného dialyzačného stacionára. Ani s týmito výhradami nejde o rozdiel, ktorý by sa dal prehliadnuť.</p>

<h2>Čo možno a nemožno povedať o úmrtnosti</h2>

<p>V roku 2025 bolo evidovaných 548 úmrtí osôb liečených v PDL. NCZI tento počet vzťahuje na prevalenčnú populáciu a uvádza približne 13 úmrtí na 100 pacientov v PDL.</p>

<div class="table-responsive" role="region" aria-label="Najčastejšie príčiny úmrtia pacientov v pravidelnej dialyzačnej liečbe v rokoch 2024 a 2025" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Príčina úmrtia</th>
        <th scope="col">2024</th>
        <th scope="col">2025</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Kardiovaskulárne choroby</th><td>332</td><td>286</td></tr>
      <tr><th scope="row">Infekčné choroby</th><td>124</td><td>142</td></tr>
      <tr><th scope="row">Malignity</th><td>88</td><td>68</td></tr>
      <tr><th scope="row">„Dialyzačná kachexia“</th><td>27</td><td>24</td></tr>
      <tr><th scope="row">Úmrtia spolu</th><td>595</td><td>548</td></tr>
    </tbody>
  </table>
</div>

<p>Kardiovaskulárne príčiny zostávajú najčastejšie, ich absolútny počet však klesol z 332 na 286, zatiaľ čo počet úmrtí na infekčné choroby stúpol zo 124 na 142. Jednoročná zmena pri takýchto počtoch môže byť náhodná a nemožno ju bez ďalšej analýzy vykladať ako zmenu rizikového profilu dialyzovanej populácie.</p>

<p>Označenie <strong>„dialyzačná kachexia“</strong> treba chápať ako termín použitý vo výkaze. Nezodpovedá zavedenej odbornej terminológii. Expertný panel Medzinárodnej spoločnosti pre renálnu výživu a metabolizmus odporúča pre stratu telesnej bielkovinovej hmoty a energetických zásob pri chorobe obličiek termín <strong>proteínovo-energetické chradnutie</strong> a kachexiu vyhradzuje pre jeho najťažšiu, zriedkavú formu. Bez definície vykazovanej kategórie nemožno 24 úmrtí stotožniť s počtom pacientov s proteínovo-energetickým chradnutím ani ich čítať ako dôkaz, že príčinou úmrtia bola samotná dialýza.</p>

<p>Jednoduché vydelenie 548 úmrtí počtom 4 352 pacientov (12,6 %) <strong>neposkytuje spoľahlivý odhad ročnej mortality</strong>. Počas roka pacienti do programu vstupujú, podstupujú transplantáciu, zomierajú alebo z neho odchádzajú z iných dôvodov; korektný výpočet vyžaduje populáciu v riziku a čas sledovania.</p>

<p>Podrobnejšie údaje o pohybe pacientov to dokladajú. V roku 2025 bolo do PDL prijatých 151 pacientov dovtedy nesledovaných pre zlyhanie obličiek, 534 z vlastnej nefrologickej ambulancie, 149 z inej nefrologickej ambulancie a 265 z iných dôvodov; prepustených bolo 548 pre úmrtie, 114 pre transplantáciu a 257 pre preradenie do iného stacionára. Pacienti teda do sledovanej populácie vstupovali a z nej vystupovali v priebehu celého roka.</p>

<p>Dvojica čísel si tu zaslúži osobitnú poznámku: správa uvádza 118 transplantovaných pacientov, no zároveň 114 pacientov prepustených z PDL pre transplantáciu. Nejde o protirečenie, ale o dva rôzne ukazovatele z dvoch rôznych výkazových tabuliek. Je to presne ten typ rozdielu, ktorý pri nekritickom spájaní čísel vedie k nesprávnym výpočtom.</p>

<p>Osobitnú pozornosť si zaslúži skupina 151 pacientov prijatých bez predchádzajúceho sledovania pre zlyhanie obličiek. Zo 834 pacientov prijatých buď z nefrologickej ambulancie, alebo bez nej, ide približne o 18 %. Neplánovaný začiatok dialýzy je vo všeobecnosti spojený s horšími výsledkami, nižším podielom natívnych cievnych prístupov a menšou možnosťou voľby modality. Samotný výkaz však neuvádza, či išlo o neskorý záchyt, o akútny priebeh alebo o pacientov sledovaných inde, a nemožno z neho tieto situácie rozlíšiť.</p>

<p>Zaujímavý je aj vzťah medzi dĺžkou dialyzačnej liečby a úmrtnosťou. Najpočetnejšiu skupinu tvorili pacienti liečení kratšie ako jeden rok (1 716 osôb), z ktorých počas roka zomrelo 192, teda 11,2 %. Najvyššia úmrtnosť bola v skupine liečenej 15 a viac rokov (14,7 %) a v skupine 6 až 10 rokov (14,6 %). Ani tieto podiely nie sú ročnou mortalitou v epidemiologickom zmysle: súčet pacientov vo všetkých skupinách (4 734) prevyšuje počet pacientov v PDL (4 352), pretože zahŕňa aj osoby dialyzované kratšie ako 90 dní, ktoré do PDL zaradené neboli.</p>

<p>Z celoštátneho počtu úmrtí napokon <strong>nemožno porovnávať kvalitu jednotlivých pracovísk</strong>. Takéto porovnanie vyžaduje zohľadniť vek, komorbidity, krehkosť, spôsob začatia dialýzy a ďalšie prognostické faktory.</p>

<h2>Limity a čo v údajoch chýba</h2>

<p>Správa NCZI je administratívnym výkazovým zberom, nie klinickým registrom. Z toho vyplývajú jej hlavné obmedzenia:</p>

<ul>
  <li>základná diagnóza je vykazovaná, nie overená biopsiou ani jednotnou klinickou definíciou,</li>
  <li>nie sú dostupné údaje o cievnych prístupoch, dialyzačnej dávke, konvekčnom objeme ani o reziduálnej funkcii obličiek,</li>
  <li>chýbajú údaje o plánovanom oproti neplánovanému začatiu liečby, o hospitalizáciách a o infekčných komplikáciách,</li>
  <li>chýbajú údaje o počte žijúcich príjemcov štepu, takže nemožno vypočítať celkovú prevalenciu náhrady funkcie obličiek ani ju porovnať s európskym priemerom 1 074 pacientov na milión obyvateľov,</li>
  <li>chýbajú údaje o kvalite života, o záťaži spojenej s dochádzaním a o preferenciách pacientov,</li>
  <li>návratnosť výkazov a počet vykazujúcich pracovísk sa medzi rokmi mení, čo ovplyvňuje porovnateľnosť.</li>
</ul>

<p>Pre slovenskú nefrológiu z toho vyplývajú dva praktické odkazy. Prvým je, že údaje podporujú prepájanie prevencie progresie chronickej choroby obličiek, včasnej predialyzačnej edukácie, plánovania cievneho prístupu, transplantačného vyšetrenia a dlhodobej multidisciplinárnej starostlivosti. Druhým je, že na hodnotenie kvality starostlivosti súčasný výkazový zber nestačí – a že nízky podiel peritoneálnej dialýzy a klesajúci počet transplantácií sú práve tie oblasti, kde by podrobnejšie údaje priniesli najväčší úžitok.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie, odborné nefrologické vyšetrenie ani aktuálne odporúčané postupy. Rozhodnutie o začatí, modalite a pokračovaní liečby nahrádzajúcej funkciu obličiek je vždy individuálne.</em></p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin">Preemptívna transplantácia</a> – transplantácia pred začatím dialýzy.</li>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Zaradenie do transplantačného programu</a> – ako sa posudzuje spôsobilosť.</li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy</a> – predpoklad vyššieho podielu domácej liečby.</li>
  <li><a href="article.php?slug=dialyzacna-modalita-prezivanie-oktogenari-pd-hd">Dialyzačná modalita a prežívanie oktogenárov</a> – peritoneálna dialýza oproti hemodialýze u najstarších pacientov.</li>
  <li><a href="article.php?slug=vysokoobjemova-hdf-mortalita-incidentni-dialyzovani-pacienti">Vysokoobjemová hemodiafiltrácia a mortalita</a> – prečo záleží na konvekčnom objeme, nie na názve metódy.</li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v nefrológii</a> – komplexná konzervatívna starostlivosť u krehkých starších pacientov.</li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Klinická krehkosť a mortalita na dialýze</a> – prečo kalendárny vek nestačí.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Národné centrum zdravotníckych informácií.</strong> <em>Nefrologická starostlivosť a liečba nahrádzajúca funkciu obličiek v Slovenskej republike 2025.</em> Bratislava: NCZI; publikované august 2026. Inštitucionálny autor, individuálni autori neuvedení. <a href="https://data.nczisk.sk/statisticke_vystupy/Nefrologia/Nefrologia_v_SR_2025.pdf" target="_blank" rel="noopener noreferrer">Správa k publikovaným výstupom (PDF)</a>; <a href="https://data.nczisk.sk/statisticke_vystupy/Nefrologia/Nefrologia_v_SR_2025.xlsx" target="_blank" rel="noopener noreferrer">tabuľkové výstupy (XLSX)</a>.</li>
  <li><strong>Národné centrum zdravotníckych informácií.</strong> <em>Nefrologická starostlivosť a liečba nahrádzajúca funkciu obličiek v Slovenskej republike 2024.</em> Bratislava: NCZI; publikované november 2025. <a href="https://data.nczisk.sk/statisticke_vystupy/Nefrologia/Nefrologia_v_SR_2024.pdf" target="_blank" rel="noopener noreferrer">Správa (PDF)</a>; <a href="https://www.nczisk.sk/Statisticke_vystupy/Tematicke_statisticke_vystupy/Nefrologia/Pages/default.aspx" target="_blank" rel="noopener noreferrer">prehľad výstupov v odbore nefrológia</a>.</li>
  <li><strong>Národné centrum zdravotníckych informácií.</strong> <em>Dialýzu potrebuje čoraz viac seniorov, najčastejším dôvodom je cukrovka.</em> Tlačová správa, 3. decembra 2025. <a href="https://www.nczisk.sk/Aktuality/Pages/Dialyzu-potrebuje-coraz-viac-seniorov-najcastejsim-dovodom-je-cukrovka.aspx" target="_blank" rel="noopener noreferrer">Text správy</a>.</li>
  <li><strong>Rianne Boenink, Marjolein Bonthuis, Brittany A. Boerstra, Megan E. Astley, Iris R. Montez de Sousa a spol. (ERA Registry).</strong> <em>The ERA Registry Annual Report 2022: Epidemiology of Kidney Replacement Therapy in Europe, with a focus on sex comparisons.</em> Clinical Kidney Journal. 2025;18(2):sfae405. <a href="https://doi.org/10.1093/ckj/sfae405" target="_blank" rel="noopener noreferrer">DOI</a>. Korigendum: Clinical Kidney Journal. 2025;18(5):sfaf107, <a href="https://doi.org/10.1093/ckj/sfaf107" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Bruce A. Cooper, Pauline Branley, Liliana Bulfone, John F. Collins, Jonathan C. Craig a spol. (IDEAL).</strong> <em>A Randomized, Controlled Trial of Early versus Late Initiation of Dialysis.</em> New England Journal of Medicine. 2010;363(7):609–619. <a href="https://doi.org/10.1056/NEJMoa1000552" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Bertram L. Kasiske, Jon J. Snyder, Arthur J. Matas, Mary D. Ellison, John S. Gill, Annamaria T. Kausz.</strong> <em>Preemptive Kidney Transplantation: The Advantage and the Advantaged.</em> Journal of the American Society of Nephrology. 2002;13(5):1358–1364. <a href="https://doi.org/10.1097/01.ASN.0000013295.11876.C9" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Steven J. Chadban, Curie Ahn, David A. Axelrod, Bethany J. Foster, Bertram L. Kasiske, Vijah Kher a spol. (KDIGO).</strong> <em>KDIGO Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation.</em> Transplantation. 2020;104(4S1 Suppl 1):S11–S103. <a href="https://doi.org/10.1097/TP.0000000000003136" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Peter J. Blankestijn, Robin W. M. Vernooij, Carinna Hockham, Giovanni F. M. Strippoli, Bernard Canaud a spol. (CONVINCE).</strong> <em>Effect of Hemodiafiltration or Hemodialysis on Mortality in Kidney Failure.</em> New England Journal of Medicine. 2023;389(8):700–709. <a href="https://doi.org/10.1056/NEJMoa2304820" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>D. Fouque, K. Kalantar-Zadeh, J. Kopple, N. Cano, P. Chauveau a spol. (ISRNM).</strong> <em>A Proposed Nomenclature and Diagnostic Criteria for Protein-Energy Wasting in Acute and Chronic Kidney Disease.</em> Kidney International. 2008;73(4):391–398. <a href="https://doi.org/10.1038/sj.ki.5002585" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Manjula Kurella Tamura, Kenneth E. Covinsky, Glenn M. Chertow, Kristine Yaffe, C. Seth Landefeld, Charles E. McCulloch.</strong> <em>Functional Status of Elderly Adults before and after Initiation of Dialysis.</em> New England Journal of Medicine. 2009;361(16):1539–1547. <a href="https://doi.org/10.1056/NEJMoa0904655" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Mario Pacilio, Roberto Minutolo, Carlo Garofalo, Maria Elena Liberti, Giuseppe Conte, Luca De Nicola.</strong> <em>Stage 5-CKD under Nephrology Care: To Dialyze or Not to Dialyze, That Is the Question.</em> Journal of Nephrology. 2016;29(2):153–161. <a href="https://doi.org/10.1007/s40620-015-0243-8" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky slovenské číselné údaje boli overené priamo proti primárnym výstupom NCZI, nie proti tlačovej správe: údaje za rok 2025 proti správe k publikovaným výstupom a proti tabuľkám T 7 (modality), T 8 (pohyb pacientov), T 12 (dĺžka liečby a úmrtia), T 15 (mimotelová eliminačná liečba), T 16 (typy peritoneálnej dialýzy), T 18 (čakacia listina a transplantácie) a prílohe s počtom obyvateľov; údaje za rok 2024 proti správe publikovanej v novembri 2025. Bibliografia zahraničných prác bola overená cez PubMed a Crossref (úplné autorské zoznamy, ročník, číslo, strany, DOI); číselné výsledky štúdií IDEAL a CONVINCE, práce Kasiskeho a spolupracovníkov, práce Kurella Tamura a spolupracovníkov, prehľadu Pacilia a spolupracovníkov a výročnej správy registra ERA pochádzajú z ich abstraktov. <strong>Rozdiely oproti pôvodnej predlohe:</strong> predloha vychádzala z údajov za rok 2024 a z tlačovej správy NCZI; v čase prípravy tohto článku už boli zverejnené údaje za rok 2025, ktoré ukazujú medziročný pokles, nie rast, a ktoré obsahujú aj rozpis podľa dialyzačnej modality, pohybu pacientov a dĺžky liečby. Predloha uvádzala, že tieto údaje k dispozícii nie sú. Oprava zjednodušených formulácií zdroja o transplantácii, porovnanie s registrom ERA, prepočty na milión obyvateľov, terminologická korekcia pojmu „dialyzačná kachexia“ a prepojenie na klinické usmernenia a randomizované štúdie sú <strong>vlastným odborným spracovaním</strong>, nie závermi NCZI.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dialyzacna-liecba-slovensko-nczi-2025_article',
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
