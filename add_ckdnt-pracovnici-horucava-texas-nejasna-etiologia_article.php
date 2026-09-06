<?php

/**
 * add_ckdnt-pracovnici-horucava-texas-nejasna-etiologia_article.php
 * CKDu/CKDnt medzi pracovnikmi vystavenymi horucave - spracovanie reportaze
 * Texas Monthly a primarnej odbornej literatury.
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
    'title'        => 'Chronická choroba obličiek nejasnej etiológie u pracovníkov vystavených horúčave: prichádza CKDnt aj do Texasu?',
    'slug'         => 'ckdnt-pracovnici-horucava-texas-nejasna-etiologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tepelný stres a akútne poškodenie obličiek u poľnohospodárskych pracovníkov v USA sú dobre doložené. Populačný dôkaz rozsiahlej epidémie chronickej CKDnt v Texase zatiaľ chýba. Čo z toho vyplýva pre nefrológiu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Reportáž z Texasu opisuje reálny a pravdepodobne rastúci problém. Medzi „u pracovníkov v horúčave stúpa kreatinín“ a „do Texasu prišla epidémia záhadnej choroby obličiek“ však leží značná evidenčná vzdialenosť. Práve tá je pri tejto téme najzaujímavejšia — a najviac sa prehliada.</em></p>

<p>Chronická choroba obličiek nejasnej alebo netradičnej etiológie, označovaná skratkami <strong>CKDu</strong> alebo <strong>CKDnt</strong>, bola najprv opísaná medzi pracovníkmi v poľnohospodárstve v Strednej Amerike a na Srí Lanke. Postihuje prevažne mladších mužov vykonávajúcich namáhavú fyzickú prácu v horúcom prostredí, často bez diabetu, závažnej hypertenzie alebo iného bežného vysvetlenia poškodenia obličiek.</p>

<p>Reportáž časopisu <em>Texas Monthly</em> s titulkom „A Mysterious Kidney Disease Has Arrived in Texas. Immigration Enforcement Has Made It Harder to Combat.“ upozorňuje, že podobné poškodenie obličiek sa objavuje aj medzi prisťahovaleckými pracovníkmi v Texase. Text vychádza zo skúseností lekárov z nemocnice Ben Taub v Houstone, kde internista Ricardo Nuila opisuje obavu, že vidí prvú vlnu podstatne väčšieho problému.</p>

<p>Téma je medicínsky aj spoločensky závažná — a druhá polovica titulku je pritom podstatnejšia než tá prvá. Dostupné údaje presvedčivo dokumentujú výskyt tepelného stresu, dehydratácie a akútneho poškodenia obličiek medzi pracovníkmi v Spojených štátoch. Zatiaľ však neposkytujú rovnako presvedčivý <strong>populačný</strong> dôkaz rozsiahlej epidémie chronickej CKDnt v Texase.</p>

<h2>Čo označujú pojmy CKDu a CKDnt</h2>

<p>Pojem <strong>CKDu</strong> (<em>chronic kidney disease of unknown etiology</em>) označuje chronickú chorobu obličiek, pri ktorej sa ani po primeranom vyšetrení nepodarí identifikovať známu príčinu.</p>

<p>Novšie označenie <strong>CKDnt</strong> (<em>chronic kidney disease of non-traditional origin</em>) zdôrazňuje neprítomnosť tradičných príčin, najmä:</p>

<ul>
  <li>diabetes mellitus,</li>
  <li>dlhodobú závažnú hypertenziu,</li>
  <li>primárne glomerulové ochorenie,</li>
  <li>dedičné ochorenie obličiek,</li>
  <li>obštrukčnú uropatiu,</li>
  <li>systémové autoimunitné ochorenie.</li>
</ul>

<p>Tieto termíny nie sú úplne zameniteľné. „Neznáma etiológia“ vyjadruje <strong>diagnostickú neistotu</strong>, zatiaľ čo „netradičná etiológia“ už predpokladá určitý spoločný epidemiologický a klinický fenotyp. Prechod od prvého označenia k druhému teda nie je len zmenou názvu — je to tichý posun od priznanej nevedomosti k hypotéze.</p>

<p>CKDnt nie je jedna choroba s jedinou príčinou. Pravdepodobnejšie ide o skupinu tubulointersticiálnych poškodení vznikajúcich kombináciou pracovných, environmentálnych, biologických a sociálnych faktorov.</p>

<h2>Typický klinický obraz</h2>

<p>Opisovaný fenotyp sa od klasickej diabetickej alebo hypertenznej choroby obličiek často líši. Postihnutí môžu mať:</p>

<ul>
  <li>postupný pokles odhadovanej glomerulovej filtrácie,</li>
  <li>žiadnu alebo iba miernu proteinúriu,</li>
  <li>nevýrazný močový sediment,</li>
  <li>normálny alebo iba mierne zvýšený krvný tlak,</li>
  <li>hyperurikémiu,</li>
  <li>hypokaliémiu alebo iné známky tubulárnej dysfunkcie,</li>
  <li>zmenšené obličky v pokročilejších štádiách,</li>
  <li>histologický obraz chronickej tubulointersticiálnej nefritídy a fibrózy.</li>
</ul>

<p>Tento obraz nie je špecifický. Podobné nálezy sa môžu vyskytnúť pri analgetickej nefropatii, toxickom poškodení, chronickej hypokaliémii, refluxovej nefropatii alebo po opakovaných epizódach akútneho poškodenia obličiek. Diagnóza CKDu alebo CKDnt preto musí zostať <strong>diagnózou per exclusionem</strong>.</p>

<h2>Tepelný stres ako hlavný podozrivý mechanizmus</h2>

<p>Najlepšie preskúmaným rizikovým faktorom je opakovaná kombinácia:</p>

<ol>
  <li>vysokej teploty a vlhkosti,</li>
  <li>intenzívnej fyzickej práce,</li>
  <li>potenia a strát tekutín,</li>
  <li>nedostatočného príjmu vody a elektrolytov,</li>
  <li>nedostatočných prestávok a ochladzovania,</li>
  <li>opakovanej expozície počas mnohých pracovných dní.</li>
</ol>

<p>Počas tepelného stresu sa znižuje efektívny cirkulujúci objem a aktivuje sa sympatikový nervový systém, systém renín-angiotenzín-aldosterón a vazopresín. Vazokonstrikcia a presmerovanie krvi do kože môžu znížiť perfúziu obličiek. Ak sa stav opakuje, môžu vznikať subklinické alebo manifestné epizódy akútneho poškodenia obličiek; neúplné zotavenie po opakovaných epizódach je biologicky prijateľným mechanizmom vzniku chronického tubulointersticiálneho poškodenia.</p>

<p>Model je podporený experimentálnymi a observačnými údajmi, ale nevysvetľuje všetky prípady. <strong>Nie každý pracovník vystavený rovnakým teplotám ochorie a nie všetky oblasti s extrémnou horúčavou vykazujú rovnaký výskyt CKDnt.</strong> Táto nezhoda je najsilnejším argumentom proti čisto tepelnému vysvetleniu.</p>

<h2>Čo ukazujú štúdie pracovníkov v Spojených štátoch</h2>

<p>Najcitovanejšie údaje pochádzajú z kalifornskej štúdie 283 poľnohospodárskych pracovníkov, u ktorých sa porovnával sérový kreatinín pred pracovnou zmenou a po nej:</p>

<div class="table-responsive" role="region" aria-label="Rizikové faktory akútneho poškodenia obličiek počas jednej pracovnej zmeny" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Výsledok</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Výskyt AKI počas jednej zmeny</th>
        <td>35 z 283 pracovníkov (12,3 %)</td>
      </tr>
      <tr>
        <th scope="row">Tepelná záťaž</th>
        <td>OR 1,34 (95 % IS 1,04–1,74)</td>
      </tr>
      <tr>
        <th scope="row">Práca odmeňovaná podľa výkonu (úkolová mzda)</th>
        <td>OR 4,24 (95 % IS 1,56–11,52)</td>
      </tr>
      <tr>
        <th scope="row">Ženy odmeňované podľa výkonu</th>
        <td>OR 102,81 (95 % IS 7,32–1443,20)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Posledný riadok si zaslúži osobitnú poznámku. Interval spoľahlivosti siahajúci od 7 po 1 443 znamená, že veľkosť efektu je <strong>prakticky neurčená</strong> — ide o odhad z malého počtu prípadov, nie o merateľné stonásobné riziko. Citovať „stonásobne vyššie riziko“ by bolo zavádzajúce; poctivá formulácia znie, že u žien pracujúcich za úkolovú mzdu bola asociácia veľmi silná, ale odhad mimoriadne nepresný.</p>

<p>Vecné jadro nálezu je však robustné a klinicky zaujímavé: <strong>spôsob odmeňovania predpovedal poškodenie obličiek silnejšie než samotná tepelná záťaž.</strong> Úkolová mzda pracovníka motivuje obmedzovať prestávky a pokračovať napriek prejavom tepelného vyčerpania. Ide teda o rizikový faktor, ktorý sa dá zmeniť zmluvou, nie liekom.</p>

<p>Tieto nálezy dokazujú pracovné renálne riziko. <strong>Jednorazový vzostup kreatinínu po pracovnej zmene však nie je dôkazom chronickej choroby obličiek.</strong> Na diagnostiku CKD je potrebná abnormalita funkcie alebo štruktúry obličiek pretrvávajúca dlhšie ako tri mesiace.</p>

<h2>Úskalia diagnostiky AKI po pracovnej zmene</h2>

<p>Kreatinín sa po namáhavej fyzickej práci môže zvýšiť nielen pre zníženie glomerulovej filtrácie, ale aj v dôsledku:</p>

<ul>
  <li>hemokoncentrácie,</li>
  <li>svalovej záťaže a zvýšenej tvorby kreatinínu,</li>
  <li>príjmu mäsa alebo výživových doplnkov,</li>
  <li>prechodných zmien distribučného objemu.</li>
</ul>

<p>Kritériá KDIGO boli vytvorené najmä pre klinické sledovanie pacientov, nie na porovnávanie kreatinínu pred jednou pracovnou zmenou a bezprostredne po nej. Takéto merania môžu zachytiť skutočné AKI, ale aj reverzibilné fyziologické zmeny.</p>

<p>Presvedčivejšie hodnotenie by malo zahŕňať opakované meranie kreatinínu po dostatočnej regenerácii, cystatín C, močový sediment a albuminúriu, markery tubulárneho poškodenia, dlhodobú trajektóriu eGFR, ultrasonografiu obličiek a posúdenie objemového stavu a svalového poškodenia.</p>

<h2>Je CKDnt spôsobená iba horúčavou?</h2>

<p>Tvrdenie, že horúčava sama osebe vysvetľuje celú epidémiu, je príliš silné. Tepelný stres je pravdepodobne významným faktorom, ale skúmajú sa aj ďalšie možné príčiny a modifikátory:</p>

<ul>
  <li>pesticídy a ďalšie agrochemikálie,</li>
  <li>ťažké kovy,</li>
  <li>kontaminovaná pitná voda,</li>
  <li>infekčné ochorenia,</li>
  <li>nesteroidové protizápalové lieky,</li>
  <li>nefrotoxické rastlinné prípravky,</li>
  <li>nadmerný príjem sladených nápojov,</li>
  <li>hyperurikémia a aktivácia fruktózovej metabolickej dráhy,</li>
  <li>genetická predispozícia,</li>
  <li>podvýživa a nízka pôrodná hmotnosť.</li>
</ul>

<p>Pri väčšine týchto faktorov sú dôkazy nejednotné. Expozície sa často vyskytujú súčasne a presné meranie ich intenzity je náročné. Najprimeranejší súčasný model preto predpokladá <strong>multifaktoriálne ochorenie</strong>, v ktorom tepelný stres a opakovaná hypovolémia predstavujú hlavný rámec, ale individuálne riziko môžu meniť toxické, infekčné, farmakologické a sociálne faktory.</p>

<h2>Prisťahovalectvo nie je biologickou príčinou ochorenia</h2>

<p>Reportáž správne upozorňuje na nadmerné zastúpenie prisťahovaleckých pracovníkov medzi ohrozenými profesiami. Prisťahovalecký status však nie je biologickým rizikovým faktorom CKDnt. Riziko vzniká prostredníctvom okolností, ktoré sa s týmto postavením môžu spájať:</p>

<ul>
  <li>fyzicky náročná práca v exteriéri,</li>
  <li>nedostatočné prestávky a tlak na pracovný výkon,</li>
  <li>odmeňovanie podľa výkonu,</li>
  <li>obmedzený prístup k vode, tieňu a hygienickým zariadeniam,</li>
  <li>nedostatočné zdravotné poistenie,</li>
  <li>jazykové bariéry,</li>
  <li>obava zo straty zamestnania,</li>
  <li>strach z kontaktu s verejnými inštitúciami,</li>
  <li>oneskorené vyhľadanie zdravotnej starostlivosti.</li>
</ul>

<p>Formulácia „choroba prisťahovalcov“ by bola odborne nepresná a stigmatizujúca. Ide o <strong>chorobu pracovnej a environmentálnej expozície</strong>, ktorá neúmerne postihuje sociálne zraniteľných pracovníkov. Posledný bod zoznamu je pritom zároveň hlavnou prekážkou epidemiologického poznania: populácia, ktorá sa vyhýba kontaktu s inštitúciami, sa vyhýba aj registrom a skríningovým programom. Časť „chýbajúceho dôkazu“ o rozsahu problému teda nemusí odrážať jeho neprítomnosť, ale nemerateľnosť.</p>

<h2>Klimatická zmena ako zosilňovač pracovného rizika</h2>

<p>Rastúce teploty, dlhšie vlny horúčav a vyšší počet extrémne teplých pracovných dní predlžujú obdobie, počas ktorého môže dochádzať k poškodeniu obličiek. Klimatická zmena pravdepodobne:</p>

<ul>
  <li>zvyšuje celkovú tepelnú dávku počas pracovného roka,</li>
  <li>obmedzuje možnosť bezpečnej práce v denných hodinách,</li>
  <li>predlžuje čas potrebný na ochladenie organizmu,</li>
  <li>zvyšuje spotrebu tekutín a elektrolytov,</li>
  <li>zvyšuje riziko AKI aj u pracovníkov, ktorí v minulosti rovnakú profesiu tolerovali.</li>
</ul>

<p>Z jednoduchej časovej súvislosti však nemožno vyvodiť, že každý nový prípad CKD je spôsobený klimatickou zmenou. Na individuálnej úrovni zostáva príčinné priradenie náročné.</p>

<h2>Prevencia nemôže spočívať iba v odporúčaní „viac piť“</h2>

<p>Hydratácia je dôležitá, ale sama osebe nestačí. Ak pracovné tempo neumožňuje prestávky, pracovník nemá prístup k toalete alebo je za odpočinok finančne penalizovaný, odporúčanie na zvýšenie príjmu tekutín má obmedzenú praktickú hodnotu. Kalifornské údaje o úkolovej mzde to potvrdzujú číselne.</p>

<p>Účinný preventívny program má zahŕňať:</p>

<ul>
  <li>dostupnú chladnú pitnú vodu,</li>
  <li>pravidelné plánované prestávky,</li>
  <li>tieň alebo klimatizovaný priestor,</li>
  <li>prispôsobenie pomeru práce a odpočinku tepelnej záťaži,</li>
  <li>postupnú aklimatizáciu nových pracovníkov,</li>
  <li>zníženie intenzity práce počas najteplejších hodín,</li>
  <li>monitorovanie teploty a indexu WBGT (teplota mokrého guľového teplomera),</li>
  <li>vhodné pracovné oblečenie a chladiace pomôcky,</li>
  <li>dostupné hygienické zariadenia,</li>
  <li>odmeňovanie, ktoré nemotivuje k vynechávaniu prestávok,</li>
  <li>edukáciu vo vhodnom jazyku,</li>
  <li>ochranu pracovníka pred postihom za nahlásenie príznakov.</li>
</ul>

<h3>Ako to vyzerá regulačne</h3>

<p>V Spojených štátoch dosiaľ neexistuje záväzný federálny predpis venovaný tepelnej záťaži pri práci. Úrad OSHA zverejnil 30. augusta 2024 návrh normy <em>Heat Injury and Illness Prevention in Outdoor and Indoor Work Settings</em>, ktorá by sa vzťahovala na väčšinu odvetví vrátane poľnohospodárstva a stavebníctva. Návrh pracuje s prahmi tepelného indexu <strong>80 °F (približne 27 °C)</strong> a <strong>90 °F (približne 32 °C)</strong> a od zamestnávateľov by vyžadoval písomný plán prevencie.</p>

<p>Verejné pojednávanie sa skončilo 2. júla 2025 a lehota na dodatočné pripomienky 30. októbra 2025. <strong>Norma však zostáva nedokončená a nemá stanovený termín prijatia.</strong> V apríli 2026 vydal OSHA revidovaný národný program cieleného dozoru (<em>National Emphasis Program</em>), ktorý je zatiaľ jediným operatívnym nástrojom dohľadu nad tepelnými rizikami.</p>

<p>Toto je podstatná časť príbehu. Nefrologické riziko, o ktorom je reč, nie je primárne otázkou liekov ani skríningových algoritmov — je to otázka pracovného práva a jeho vymožiteľnosti.</p>

<p>Elektrolytové roztoky môžu byť užitočné pri dlhotrvajúcom intenzívnom potení, ale ich zloženie a množstvo treba prispôsobiť zdravotnému stavu. Nekontrolovaný príjem vysokého množstva draslíka nie je vhodný pri už prítomnej pokročilej CKD.</p>

<h2>Skríning ohrozených pracovníkov</h2>

<p>Jednorazové meranie kreatinínu nestačí. Vhodný skríningový rámec by mal zahŕňať:</p>

<ol>
  <li>pracovnú anamnézu vrátane rokov práce v horúčave,</li>
  <li>krvný tlak,</li>
  <li>kreatinín a eGFR,</li>
  <li>pomer albumínu ku kreatinínu v moči,</li>
  <li>chemické vyšetrenie a sediment moču,</li>
  <li>elektrolyty, bikarbonát a kyselinu močovú,</li>
  <li>opakovanie patologických výsledkov po regenerácii,</li>
  <li>podľa nálezu ultrasonografiu obličiek,</li>
  <li>vylúčenie diabetu, glomerulopatie, obštrukcie a toxického poškodenia.</li>
</ol>

<p>Pri hodnotení kreatinínu krátko po práci treba zohľadniť dehydratáciu a svalovú záťaž. Diagnózu chronickej choroby obličiek možno potvrdiť až pri pretrvávaní abnormality dlhšie ako tri mesiace.</p>

<h2>Liečba zisteného poškodenia obličiek</h2>

<p>Pre CKDnt zatiaľ neexistuje špecifická farmakologická liečba založená na veľkých randomizovaných štúdiách. Základom je:</p>

<ul>
  <li>ukončenie alebo podstatné zníženie škodlivej expozície,</li>
  <li>prevencia ďalších epizód dehydratácie a AKI,</li>
  <li>vyhýbanie sa nefrotoxickým liekom,</li>
  <li>primeraná kontrola krvného tlaku,</li>
  <li>liečba albuminúrie podľa všeobecných nefrologických zásad,</li>
  <li>úprava metabolickej acidózy a elektrolytových porúch,</li>
  <li>pravidelné sledovanie eGFR,</li>
  <li>včasné odoslanie k nefrológovi.</li>
</ul>

<p>Úloha inhibítorov SGLT2 pri špecifickom fenotype CKDnt bez diabetu a bez významnej albuminúrie nie je priamo preskúmaná. Registračné štúdie v tejto oblasti zaraďovali prevažne pacientov s albuminúriou, takže prenos ich výsledkov na neproteinurický tubulointersticiálny fenotyp je hypotetický. Použitie sa má riadiť schválenou indikáciou, funkciou obličiek a individuálnym pomerom prínosu a rizika.</p>

<h2>Kontrola správnosti hlavných tvrdení</h2>

<h3>Dobre podložené</h3>

<ul>
  <li>Fyzická práca v horúčave je spojená s dehydratáciou a akútnymi zmenami funkcie obličiek.</li>
  <li>Opakované AKI môže prispievať k vzniku CKD.</li>
  <li>Poľnohospodárski pracovníci v USA sú vystavení merateľnému renálnemu riziku (12,3 % laboratórne definovaných AKI počas jedinej zmeny).</li>
  <li>Odmeňovanie podľa výkonu je nezávisle spojené s vyšším rizikom AKI.</li>
  <li>Sociálne a právne bariéry môžu oddialiť diagnostiku a liečbu.</li>
  <li>Federálna norma o tepelnej záťaži pri práci v USA zatiaľ neplatí.</li>
</ul>

<h3>Pravdepodobné, ale nie definitívne dokázané</h3>

<ul>
  <li>Opakovaný tepelný stres je hlavnou príčinou väčšiny prípadov CKDnt.</li>
  <li>Klimatická zmena zvýši incidenciu CKDnt v južných oblastiach USA.</li>
  <li>Opatrenia na ochladzovanie a hydratáciu zabránia dlhodobej strate funkcie obličiek.</li>
</ul>

<h3>Zatiaľ nepreukázané</h3>

<ul>
  <li>Texas čelí epidemiologicky potvrdenej rozsiahlej epidémii CKDnt.</li>
  <li>Každý vzostup kreatinínu po pracovnej zmene predstavuje štrukturálne poškodenie obličiek.</li>
  <li>Jediným príčinným faktorom CKDnt je dehydratácia.</li>
  <li>Prisťahovalecký pôvod je samostatným biologickým rizikovým faktorom.</li>
</ul>

<h2>Čo z toho platí pre slovenskú nefrológiu</h2>

<p>Slovensko nemá stredoamerický klimatický profil ani porovnateľné poľnohospodárske pracovné podmienky. Prenositeľný je však samotný postup uvažovania. Pri pacientovi s nevysvetleným poklesom eGFR, minimálnou proteinúriou a nevýrazným sedimentom má pracovná anamnéza rovnaké postavenie ako liekový záznam — a pri práci v horúcich prevádzkach (zlievarne, sklárne, pekárne, stavebníctvo, sezónne poľnohospodárstvo) sa na ňu treba pýtať cielene.</p>

<p>Druhým prenositeľným poznatkom je, že opakované epizódy AKI — bez ohľadu na príčinu — patria do anamnézy chronickej choroby obličiek. Pacient po prekonanom AKI potrebuje následné sledovanie, nie prepustenie s normalizovaným kreatinínom.</p>

<h2>Záver</h2>

<p>Reportáž časopisu <em>Texas Monthly</em> upozorňuje na reálny a pravdepodobne rastúci problém: pracovníci vykonávajúci namáhavú prácu v texaských horúčavách môžu byť vystavení opakovanému poškodeniu obličiek, pričom prisťahovalecké a sociálne znevýhodnené skupiny majú najmenšiu možnosť toto riziko ovplyvniť.</p>

<p>Dostupné vedecké údaje podporujú súvislosť medzi pracovným tepelným stresom, dehydratáciou a akútnym poškodením obličiek. Menej isté je, aká časť týchto epizód prechádza do CKDnt a aký rozsah má tento problém konkrétne v Texase.</p>

<p>Najpresnejšie preto nie je tvrdiť, že tajomná epidémia už bola v Texase definitívne potvrdená. Primeranejšie je povedať, že <strong>v Texase existujú podmienky, rizikové profesie a pravdepodobné prípady zodpovedajúce vznikajúcemu fenotypu CKDnt, ktorý si vyžaduje systematický dohľad, dlhodobé štúdie a záväznú ochranu pracovníkov pred tepelným stresom</strong>. Posledná z týchto troch podmienok je pritom najbližšie k splneniu — a najďalej od uskutočnenia.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=extremne-horucavy-riziko-ckd-dialyza">Extrémne horúčavy a riziko pri CKD a dialýze</a> — klinický pohľad na tepelnú záťaž u pacientov.</li>
  <li><a href="article.php?slug=extremne-horucavy-podcenovanie-zdravotnych-rizik-nefrologia">Podceňovanie zdravotných rizík horúčav</a> — prečo sa tepelná záťaž systematicky nemeria.</li>
  <li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek</a> — druhá skupina podozrivých pri CKDnt.</li>
  <li><a href="article.php?slug=hydratacne-prestavky-futbal-ms-2026">Hydratačné prestávky a tepelná záťaž</a> — ten istý princíp v inom kontexte.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Texas Monthly.</strong> <em>A Mysterious Kidney Disease Has Arrived in Texas. Immigration Enforcement Has Made It Harder to Combat.</em> 2026. <a href="https://www.texasmonthly.com/news-politics/ckdu-kidney-disease-immigration/" target="_blank" rel="noopener noreferrer">Texas Monthly</a>.</li>
  <li><strong>Richard J. Johnson, Catharina Wesseling, Lee S. Newman.</strong> <em>Chronic Kidney Disease of Unknown Cause in Agricultural Communities.</em> New England Journal of Medicine. 2019;380(19):1843–1852. <a href="https://doi.org/10.1056/NEJMra1813869" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Jason Glaser, Jay Lemery, Balaji Rajagopalan, Henry F. Diaz, Ramón García-Trabanino, Gangadhar Taduri, Magdalena Madero, Mala Amarasinghe, Georgi Abraham, Sirirat Anutrakulchai, Vivekanand Jha, Peter Stenvinkel, Carlos Roncal-Jimenez, Miguel A. Lanaspa, Ricardo Correa-Rotter, David Sheikh-Hamad, Emmanuel A. Burdmann, Ana Andres-Hernando, Tamara Milagres, Ilana Weiss, Mehmet Kanbay, Catharina Wesseling, Laura Gabriela Sánchez-Lozada, Richard J. Johnson.</strong> <em>Climate Change and the Emergent Epidemic of CKD from Heat Stress in Rural Communities: The Case for Heat Stress Nephropathy.</em> Clinical Journal of the American Society of Nephrology. 2016;11(8):1472–1483. <a href="https://doi.org/10.2215/CJN.13841215" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Sally Moyce, Diane Mitchell, Tracey Armitage, Daniel Tancredi, Jill Joseph, Marc Schenker.</strong> <em>Heat strain, volume depletion and kidney function in California agricultural workers.</em> Occupational and Environmental Medicine. 2017;74(6):402–409. <a href="https://doi.org/10.1136/oemed-2016-103848" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/28093502/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Occupational Safety and Health Administration.</strong> <em>Heat Injury and Illness Prevention in Outdoor and Indoor Work Settings — Rulemaking.</em> Inštitucionálny zdroj bez uvedeného individuálneho autorstva. <a href="https://www.osha.gov/heat-exposure/rulemaking/" target="_blank" rel="noopener noreferrer">OSHA</a>.</li>
  <li><strong>Occupational Safety and Health Administration.</strong> <em>Heat Exposure.</em> Inštitucionálny zdroj. <a href="https://www.osha.gov/heat-exposure" target="_blank" rel="noopener noreferrer">OSHA</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje kalifornskej štúdie — 283 pracovníkov, 35 prípadov AKI (12,3 %) počas jedinej zmeny, OR 1,34 (1,04–1,74) pre tepelnú záťaž, OR 4,24 (1,56–11,52) pre úkolovú mzdu a OR 102,81 (7,32–1443,20) pre ženy odmeňované podľa výkonu — boli overené proti abstraktu v zázname PubMed. Bibliografické údaje všetkých citovaných prác boli overené cez Crossref a PubMed; <strong>opravené boli mená ôsmich autorov</strong> v citáciách (Gangadhar Taduri, Mala Amarasinghe, Georgi Abraham, Sirirat Anutrakulchai, David Sheikh-Hamad, Tamara Milagres, Laura Gabriela Sánchez-Lozada; a Sally Moyce, Tracey Armitage, Jill Joseph). Údaje o regulačnom stave v USA — návrh normy z 30. augusta 2024, prahy tepelného indexu 80 °F a 90 °F, koniec pojednávania 2. júla 2025, koniec pripomienkovania 30. októbra 2025, chýbajúci termín prijatia a revidovaný národný program cieleného dozoru z apríla 2026 — pochádzajú z verejných materiálov OSHA a z odborných právnych komentárov. Stránka časopisu <em>Texas Monthly</em> blokuje automatizovaný prístup, preto <strong>meno autora reportáže nebolo možné nezávisle overiť</strong> a citácia uvádza iba vydavateľa a úplný titulok; menovaný lekár Ricardo Nuila a nemocnica Ben Taub v Houstone boli overení vo verejne dostupných výňatkoch. Kritické komentáre — rozlíšenie CKDu a CKDnt ako posunu od nevedomosti k hypotéze, nepresnosť odhadu pri veľmi širokom intervale spoľahlivosti, nemerateľnosť populácie vyhýbajúcej sa inštitúciám a časť o slovenskej praxi — sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckdnt-pracovnici-horucava-texas-nejasna-etiologia_article',
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
