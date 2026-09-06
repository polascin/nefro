<?php

/**
 * add_nefrolog-nie-je-lekar-az-pre-dialyzu-vcasne-vysetrenie_article.php
 * Kedy a preco ma vyznam vcasne nefrologicke vysetrenie - odborne spracovanie
 * s oporou v KDIGO 2024 a v systematickom prehlade Smart & Titus.
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
    'title'        => 'Nefrológ nie je lekár až pre dialýzu: kedy a prečo má význam včasné nefrologické vyšetrenie',
    'slug'         => 'nefrolog-nie-je-lekar-az-pre-dialyzu-vcasne-vysetrenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nie každá eGFR pod 60 patrí k nefrológovi — a nie každý pacient s normálnou eGFR je bez rizika. KDIGO 2024 nahrádza jednoduché prahy predikciou rizika zlyhania obličiek. Ako to vyzerá v praxi.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Otázka „kedy odoslať k nefrológovi“ má dnes presnejšiu odpoveď než pred desiatimi rokmi. Nie je ňou hodnota eGFR, ale vypočítané riziko zlyhania obličiek — a to sa dá získať zo štyroch údajov, ktoré má ambulancia poruke.</em></p>

<p>Nefrológ sa nezaoberá iba dialýzou a pokročilým zlyhaním obličiek. Väčšinu jeho práce tvorí diagnostika príčin poškodenia obličiek, spomaľovanie progresie chronickej choroby obličiek, liečba hypertenzie a porúch vnútorného prostredia a príprava individualizovanej liečby dávno pred prípadnou potrebou náhrady funkcie obličiek.</p>

<p>Včasné nefrologické vyšetrenie má význam najmä pri rýchlom poklese glomerulovej filtrácie, významnej albuminúrii, nejasnej hematúrii, rezistentnej hypertenzii, podozrení na glomerulové alebo dedičné ochorenie a pri vysokom vypočítanom riziku zlyhania obličiek. <strong>Samotná mierne znížená eGFR však automaticky neznamená potrebu nefrologického sledovania každého pacienta.</strong></p>

<h2>Čím sa zaoberá nefrológia</h2>

<p>Nefrológia je odbor vnútorného lekárstva zameraný na fyziológiu a ochorenia obličiek. Zahŕňa akútne poškodenie obličiek, chronickú chorobu obličiek, glomerulové a tubulointersticiálne ochorenia, diabetickú a hypertenznú chorobu obličiek, dedičné nefropatie, poruchy elektrolytov a acidobázickej rovnováhy, rezistentnú a sekundárnu hypertenziu, metabolické vyšetrenie recidivujúcej nefrolitiázy, hemodialýzu, peritoneálnu a domácu dialýzu, prípravu na transplantáciu obličky, dlhodobú starostlivosť o príjemcu transplantátu a konzervatívnu liečbu pokročilej choroby obličiek bez dialýzy.</p>

<p>Obličky odstraňujú metabolické produkty, regulujú objem extracelulárnej tekutiny, koncentrácie elektrolytov a acidobázickú rovnováhu. Podieľajú sa na regulácii krvného tlaku, tvorbe erytropoetínu a aktivácii vitamínu D.</p>

<p>Populárne tvrdenie, že obličky denne „prefiltrujú približne 150 litrov krvi“, nie je fyziologicky presné. Glomeruly zdravého dospelého vytvoria približne <strong>150 až 180 litrov primárneho filtrátu denne</strong>. Nejde o objem krvi, ktorý by sa jednorazovo prefiltroval: krv preteká obličkami opakovane, filtruje sa iba časť plazmy a prevažná väčšina vytvoreného filtrátu sa následne resorbuje v tubuloch.</p>

<h2>Nefrológ a urológ nie sú zameniteľní</h2>

<p>Nefrológ je predovšetkým internisticky orientovaný špecialista. Urológia je chirurgický odbor zameraný na štruktúrne ochorenia obličiek a močových ciest, mužské pohlavné orgány a operačnú liečbu — obštrukciu močových ciest, nádory obličiek, močového mechúra a prostaty, konkrementy vyžadujúce intervenčnú liečbu, poruchy odtoku moču či inkontinenciu.</p>

<p>Nefrológ sa sústreďuje na funkciu obličiek, glomerulové ochorenia, albuminúriu, hypertenziu, poruchy elektrolytov a náhradu funkcie obličiek. Pri hematúrii, opakovanej nefrolitiáze alebo obštrukčnej nefropatii je potrebná spolupráca oboch odborov.</p>

<p>Absolútne tvrdenie, že nefrológ „nikdy nevykonáva zákroky“, nie je správne. Podľa organizácie zdravotníctva, pracoviska a odbornej spôsobilosti môžu nefrológovia vykonávať biopsiu obličky, zavádzať dočasné dialyzačné katétre, robiť niektoré zákroky súvisiace s peritoneálnou dialýzou alebo sa venovať intervenčnej nefrológii. Nefrológ však nevykonáva urologické operácie.</p>

<h2>Chronická choroba obličiek býva dlho bez príznakov</h2>

<p>Včasné štádiá chronickej choroby obličiek sú obyčajne asymptomatické. Pacient nemusí pociťovať bolesť, zmenu močenia ani pokles výkonnosti. Ochorenie sa najčastejšie zistí pri vyšetrení sérového kreatinínu, eGFR alebo albuminúrie.</p>

<p>Často citované tvrdenie, že približne <strong>deväť z desiatich</strong> dospelých s CKD o svojom ochorení nevie, vychádza z amerických populačných údajov a zahŕňa veľký počet ľudí s miernou alebo iba laboratórne definovanou chorobou. Prevalenčné odhady zo Spojených štátov nemožno bez úpravy prenášať na slovenskú populáciu.</p>

<p>Chronická choroba obličiek nie je vylúčená neprítomnosťou príznakov — a zároveň žiadny jednotlivý symptóm nie je pre CKD špecifický.</p>

<h3>Možné klinické prejavy</h3>

<p>Pri pokročilejšom ochorení sa môžu objaviť opuchy dolných končatín alebo očných viečok, únava a znížená výkonnosť, nechutenstvo, nauzea či úbytok hmotnosti, pruritus, dýchavica pri prevodnení alebo anémii, poruchy koncentrácie, svalové kŕče a zmeny objemu alebo frekvencie močenia.</p>

<p>Penivý moč môže sprevádzať významnejšiu proteinúriu, ale sám osebe ju nepotvrdzuje. Podobne únava nie je spoľahlivým skorým znakom renálnej anémie; anémia súvisiaca s CKD sa stáva klinicky významnou spravidla až pri pokročilejšom znížení glomerulovej filtrácie.</p>

<h2>Ako sa diagnostikuje chronická choroba obličiek</h2>

<p>Podľa KDIGO je CKD abnormalita štruktúry alebo funkcie obličiek prítomná najmenej tri mesiace a významná pre zdravie pacienta. Diagnózu môže podporiť eGFR nižšia ako 60 ml/min/1,73 m², albuminúria, abnormalita močového sedimentu, perzistujúca hematúria glomerulového pôvodu, porucha tubulárnej funkcie, histologická abnormalita, štruktúrna zmena zistená zobrazovacím vyšetrením alebo stav po transplantácii obličky.</p>

<p>Jedna znížená eGFR ani jednorazovo zvýšená albuminúria chronickú chorobu obličiek spravidla nepotvrdzujú. Najprv treba zvážiť akútne poškodenie obličiek, prechodnú albuminúriu a ďalšie reverzibilné príčiny.</p>

<h3>Kategórie glomerulovej filtrácie</h3>

<div class="table-responsive" role="region" aria-label="Kategórie glomerulovej filtrácie podľa KDIGO" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Kategória</th>
        <th scope="col">eGFR (ml/min/1,73 m²)</th>
        <th scope="col">Charakteristika</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">G1</th><td>≥ 90</td><td>Normálna alebo vysoká</td></tr>
      <tr><th scope="row">G2</th><td>60 – 89</td><td>Mierne znížená</td></tr>
      <tr><th scope="row">G3a</th><td>45 – 59</td><td>Mierne až stredne znížená</td></tr>
      <tr><th scope="row">G3b</th><td>30 – 44</td><td>Stredne až závažne znížená</td></tr>
      <tr><th scope="row">G4</th><td>15 – 29</td><td>Závažne znížená</td></tr>
      <tr><th scope="row">G5</th><td>&lt; 15</td><td>Zlyhanie obličiek</td></tr>
    </tbody>
  </table>
</div>

<p>Kategórie G1 a G2 samy osebe neznamenajú CKD — musí byť prítomný iný marker poškodenia obličiek.</p>

<p>eGFR nie je priamo nameraná hodnota. Najčastejšie sa vypočítava zo sérového kreatinínu, veku a pohlavia, a ovplyvniť ju môže svalová hmota, amputácia, malnutrícia, extrémna telesná konštitúcia, intenzívna telesná záťaž, užívanie kreatínu aj lieky meniace tubulárnu sekréciu kreatinínu. V situáciách, v ktorých je kreatinín málo spoľahlivý, môže byť užitočný cystatín C alebo kombinovaný výpočet.</p>

<h3>Albuminúria</h3>

<p>Preferovaným vyšetrením je pomer albumínu ku kreatinínu v moči (UACR), ideálne z prvej rannej vzorky.</p>

<div class="table-responsive" role="region" aria-label="Kategórie albuminúrie podľa KDIGO" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Kategória</th>
        <th scope="col">UACR (mg/g)</th>
        <th scope="col">UACR (mg/mmol)</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">A1</th><td>&lt; 30</td><td>&lt; 3</td></tr>
      <tr><th scope="row">A2</th><td>30 – 300</td><td>3 – 30</td></tr>
      <tr><th scope="row">A3</th><td>&gt; 300</td><td>&gt; 30</td></tr>
    </tbody>
  </table>
</div>

<p>Albuminúria môže predchádzať poklesu eGFR, najmä pri diabetickej chorobe obličiek. Nie je však univerzálne prvým prejavom všetkých nefropatií — niektoré tubulointersticiálne, vaskulárne, cystické alebo obštrukčné ochorenia môžu prebiehať bez významnej albuminúrie.</p>

<p>Prechodné zvýšenie UACR môže vzniknúť pri horúčke, infekcii močových ciest, intenzívnej fyzickej záťaži, dekompenzovanom srdcovom zlyhávaní, výraznej hyperglykémii alebo počas menštruácie. Nečakaný nález treba potvrdiť opakovaným vyšetrením.</p>

<h2>Kedy je vhodné nefrologické vyšetrenie</h2>

<p>Samotná eGFR nižšia ako 60 ml/min/1,73 m² neznamená, že každý pacient musí byť bezodkladne odoslaný k nefrológovi. Stabilnú CKD s nižším rizikom môže v mnohých prípadoch sledovať všeobecný lekár, diabetológ alebo internista podľa miestnych kompetencií a dostupnosti starostlivosti.</p>

<p>Nefrologická konzultácia je osobitne vhodná pri:</p>

<ul>
  <li>eGFR nižšej ako 30 ml/min/1,73 m²,</li>
  <li>rýchlom alebo nevysvetlenom poklese eGFR,</li>
  <li>významnej albuminúrii, najmä v kategórii A3,</li>
  <li>albuminúrii spojenej s hematúriou,</li>
  <li>pretrvávajúcej hematúrii s podozrením na glomerulové ochorenie,</li>
  <li>rezistentnej hypertenzii,</li>
  <li>opakovaných alebo závažných poruchách draslíka, sodíka či acidobázickej rovnováhy,</li>
  <li>nejasnej etiológii CKD,</li>
  <li>podozrení na systémové, autoimunitné alebo dedičné ochorenie,</li>
  <li>recidivujúcej nefrolitiáze s metabolickou príčinou,</li>
  <li>komplikáciách CKD, ktoré nemožno zvládnuť v základnej starostlivosti,</li>
  <li>potrebe biopsie obličky,</li>
  <li>príprave na náhradu funkcie obličiek alebo konzervatívnu starostlivosť.</li>
</ul>

<h3>Riziko namiesto prahu: čo prináša KDIGO 2024</h3>

<p>Odporúčania KDIGO 2024 dopĺňajú tradičné kritériá o <strong>predikciu absolútneho rizika zlyhania obličiek</strong> pomocou externe validovanej rovnice. Namiesto jediného prahu eGFR ponúkajú stupňovitý rámec:</p>

<div class="table-responsive" role="region" aria-label="Prahy rizika zlyhania obličiek podľa KDIGO 2024" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Vypočítané riziko zlyhania obličiek</th>
        <th scope="col">Zodpovedajúci krok</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">3 – 5 % za 5 rokov</th>
        <td>Odoslanie do nefrologickej starostlivosti (popri kritériách podľa eGFR)</td>
      </tr>
      <tr>
        <th scope="row">&gt; 10 % za 2 roky</th>
        <td>Zaradenie do multidisciplinárnej starostlivosti</td>
      </tr>
      <tr>
        <th scope="row">&gt; 40 % za 2 roky</th>
        <td>Edukácia o modalitách, príprava na náhradu funkcie obličiek vrátane cievneho prístupu alebo odoslanie na transplantáciu</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Najpoužívanejšia <strong>Kidney Failure Risk Equation</strong> vyžaduje iba štyri údaje: vek, pohlavie, eGFR a UACR. Je validovaná pre CKD kategórií G3 až G5; rovnice vyvinuté pre túto populáciu <strong>nemusia platiť pri kategóriách G1 a G2</strong> a nemajú sa tam nekriticky používať.</p>

<p>Praktický dôsledok je zreteľný: dvaja pacienti s rovnakou eGFR 40 ml/min/1,73 m² môžu mať pri albuminúrii A1 a A3 zásadne odlišné riziko — a teda aj odlišnú naliehavosť odoslania. Bez UACR sa toto rozlíšenie urobiť nedá.</p>

<h2>Čo možno očakávať pri prvom vyšetrení</h2>

<p>Nefrológ hodnotí vývoj laboratórnych výsledkov v čase, komorbidity, rodinnú anamnézu a všetky užívané lieky vrátane voľnopredajných prípravkov a výživových doplnkov. Súčasťou vyšetrenia môže byť opakované stanovenie kreatinínu a eGFR, UACR alebo kvantifikácia celkovej proteinúrie, chemické a mikroskopické vyšetrenie moču, krvný obraz, elektrolyty a acidobázická rovnováha, kalcium, fosfát a parametre minerálovej a kostnej poruchy, imunologické a sérologické vyšetrenia podľa klinického podozrenia, ultrazvuk obličiek a močových ciest, genetické vyšetrenie vo vybraných prípadoch a biopsia obličky, ak jej výsledok môže zmeniť diagnózu, prognózu alebo liečbu.</p>

<p>Ultrazvuk nie je automaticky potrebný pri každej miernej a jednoznačne vysvetlenej abnormalite a väčšina pacientov nepotrebuje biopsiu obličky.</p>

<p>Pre rozhodovanie je často dôležitejší trend než izolovaný výsledok: pokles eGFR zo 75 na 55 ml/min/1,73 m² za jeden rok môže byť naliehavejší než dlhodobo stabilná eGFR 48 ml/min/1,73 m².</p>

<h2>Nefrologická liečba nie je iba „sledovanie kreatinínu“</h2>

<p>Cieľom je určiť príčinu ochorenia, znížiť renálne a kardiovaskulárne riziko, predchádzať akútnemu poškodeniu obličiek a liečiť komplikácie. Podľa diagnózy môže liečba zahŕňať primeranú kontrolu krvného tlaku, inhibítor ACE alebo blokátor receptora AT1 (najmä pri albuminúrii), inhibítor SGLT2 pri splnení indikačných kritérií, finerenón u vybraných pacientov s diabetom 2. typu a albuminurickou CKD, agonistu receptora GLP-1 podľa konkrétnej indikácie, optimalizáciu liečby diabetu a srdcového zlyhávania, statínovú liečbu podľa celkového kardiovaskulárneho rizika, liečbu metabolickej acidózy, anémie a porúch minerálového metabolizmu, úpravu dávok liekov podľa funkcie obličiek, prevenciu nefrotoxicity a cielenú imunosupresívnu alebo inú špecifickú liečbu pri vybraných nefropatiách.</p>

<p>Tvrdenie, že chronická choroba obličiek sa nedá vyliečiť, je príliš absolútne. Chronické jazvovité poškodenie býva nezvratné, ale niektoré príčiny možno úspešne liečiť a časť funkčnej zložky poškodenia sa môže zlepšiť. Pri mnohých ochoreniach možno progresiu významne spomaliť — nemožno však sľubovať jej zastavenie u každého pacienta.</p>

<h2>Strava pri CKD sa musí individualizovať</h2>

<p>Univerzálny zoznam „piatich zakázaných potravín“ nie je odborne správnym spôsobom vedenia renálnej diéty. Potreby pacienta závisia od štádia CKD, albuminúrie, diurézy, koncentrácie draslíka a fosfátu, krvného tlaku, diabetu, nutričného stavu a typu náhrady funkcie obličiek.</p>

<p>Všeobecne býva vhodné obmedziť nadmerný príjem sodíka, znižovať podiel priemyselne spracovaných potravín, vyhýbať sa potravinám s fosfátovými prísadami pri hyperfosfatémii, neprijímať nadmerné množstvo bielkovín, zachovať dostatočný energetický príjem a predchádzať malnutrícii.</p>

<p><strong>Draslík sa nemá rutinne obmedzovať každému pacientovi s CKD.</strong> Obmedzenie treba individualizovať podľa kaliémie, liekov, acidózy, zápchy a schopnosti obličiek vylučovať draslík. Neodôvodnené vyradenie ovocia, zeleniny, strukovín a celozrnných potravín môže zhoršiť kvalitu stravy.</p>

<p>Náhrady soli obsahujúce chlorid draselný môžu byť nebezpečné pri hyperkaliémii alebo pri kombinácii CKD s liekmi zvyšujúcimi koncentráciu draslíka; u iných osôb však nemusia byť automaticky kontraindikované.</p>

<p>Ani pitie čo najväčšieho množstva vody nie je univerzálnou prevenciou poškodenia obličiek. Príjem tekutín sa musí prispôsobiť smädu, stratám, počasiu, srdcovému zlyhávaniu, diuréze a schopnosti vylučovať vodu; nadmerný príjem môže vyvolať hyponatriémiu alebo zhoršiť prevodnenie.</p>

<h2>Nesteroidové protizápalové lieky a ďalšie riziká</h2>

<p>Nesteroidové protizápalové lieky môžu znížiť prietok krvi obličkami a vyvolať akútne poškodenie obličiek, retenciu sodíka, zvýšenie krvného tlaku alebo hyperkaliémiu. Riziko je vyššie pri CKD, dehydratácii, vyššom veku, srdcovom zlyhávaní a pri súčasnom užívaní blokátora systému renín-angiotenzín s diuretikom — klasická „trojitá hrozba“.</p>

<p>Nie je však presné označiť každé krátkodobé užitie za poškodzujúce. Rozhoduje dávka, trvanie, hydratácia, funkcia obličiek a súbežná liečba. Pacient s CKD by mal použitie konzultovať s lekárom a nespoliehať sa na voľnopredajný status lieku.</p>

<p>Rizikové môžu byť aj neregulované rastlinné prípravky, vysoké dávky niektorých doplnkov, kontrastné látky v konkrétnych klinických situáciách a lieky bez úpravy dávky pri zníženej eGFR.</p>

<h2>Znamená nefrologické vyšetrenie blížiacu sa dialýzu?</h2>

<p>Nie. Veľká časť pacientov s CKD nikdy nedospeje k zlyhaniu obličiek. Pravdepodobnosť progresie závisí od príčiny ochorenia, eGFR, albuminúrie, rýchlosti predchádzajúceho poklesu funkcie, veku, krvného tlaku, diabetu, kardiovaskulárnych ochorení a odpovede na liečbu.</p>

<p>O začatí dialýzy sa nerozhoduje iba podľa jednej hodnoty eGFR. Posudzuje sa klinický stav, príznaky urémie, kontrola objemu tekutín, elektrolytové a acidobázické poruchy, výživa a kvalita života.</p>

<p>Ak riziko zlyhania obličiek narastá, včasná nefrologická starostlivosť umožňuje edukáciu o možnostiach liečby, posúdenie preemptívnej transplantácie, včasné vytvorenie cievneho prístupu, plánovanie peritoneálnej alebo domácej hemodialýzy a rozhodovanie o konzervatívnej starostlivosti bez dialýzy.</p>

<p>Systematický prehľad Smarta a Titusa a ďalšie observačné práce spájajú skoršie odoslanie s lepšou prípravou na náhradu funkcie obličiek, menším počtom urgentných začatí dialýzy a nižšou mortalitou. Dôkazy však pochádzajú prevažne z <strong>nerandomizovaných</strong> štúdií, preto môžu byť čiastočne ovplyvnené rozdielmi medzi pacientmi odoslanými včas a neskoro — neskoré odoslanie býva zároveň ukazovateľom horšieho zdravotného a sociálneho kontextu.</p>

<h2>Kedy treba vyhľadať pomoc bezodkladne</h2>

<p>Urgentné lekárske vyšetrenie je potrebné pri náhlom výraznom poklese alebo zastavení tvorby moču, rýchlo vznikajúcom opuchu spojenom s dýchavicou, viditeľnej krvi v moči (najmä so zrazeninami alebo retenciou moču), bolesti v boku spojenej s horúčkou alebo zimnicou, závažnej slabosti, poruche vedomia alebo palpitáciách pri možnej poruche elektrolytov, pretrvávajúcom vracaní alebo hnačke u pacienta s CKD a pri podozrení na rýchlo progredujúce systémové alebo glomerulové ochorenie.</p>

<p>Takéto stavy nepatria na čakanie na plánovaný termín v nefrologickej ambulancii.</p>

<h2>Čo si pripraviť na nefrologické vyšetrenie</h2>

<p>Užitočné je priniesť chronologický prehľad kreatinínu, eGFR a močových nálezov, úplný zoznam liekov a doplnkov vrátane dávok, domáce merania krvného tlaku, prepúšťacie správy a výsledky zobrazovacích vyšetrení a informácie o ochoreniach obličiek v rodine.</p>

<p>Pacient by mal po vyšetrení vedieť, aká je pravdepodobná príčina ochorenia, ako sa mení jeho eGFR, aká je kategória albuminúrie, aké je riziko progresie a ktoré konkrétne opatrenia môžu toto riziko znížiť.</p>

<h2>Čo v populárnych textoch o nefrológii nesedí</h2>

<p>Populárne prehľady o práci nefrológa správne zdôrazňujú asymptomatický priebeh včasnej CKD, význam eGFR a albuminúrie a potrebu individualizovanej diéty. Viaceré obvyklé formulácie však vyžadujú korekciu:</p>

<ul>
  <li>Denný objem glomerulového filtrátu nemožno označovať za množstvo „prefiltrovanej krvi“.</li>
  <li>Albuminúria je častým, nie univerzálne najskorším znakom poškodenia obličiek.</li>
  <li>Nefrológovia nevykonávajú urologické operácie, ale niektorí vykonávajú nefrologické invazívne výkony.</li>
  <li>eGFR nižšia ako 60 musí byť chronická, prípadne ju musí podporovať iný dôkaz CKD.</li>
  <li>Každý pacient s eGFR nižšou ako 60 nepotrebuje automaticky nefrológa.</li>
  <li>Ultrazvuk obličiek nie je povinnou súčasťou každého prvého nefrologického vyšetrenia.</li>
  <li>Hyperkaliémia nie je dôvodom na plošné vyradenie potravín rastlinného pôvodu.</li>
  <li>CKD nie je vždy liečiteľná kauzálne, jej priebeh však často možno významne ovplyvniť.</li>
  <li>Väčšina pacientov s CKD nedospeje k dialýze, ale bez individuálneho prognostického hodnotenia nemožno sľubovať stabilitu „po celé desaťročia“.</li>
  <li>Americké populačné údaje nemožno automaticky vzťahovať na Slovensko.</li>
</ul>

<h2>Záver</h2>

<p>Nefrológ nie je iba špecialista na dialýzu. Jeho najväčší prínos môže spočívať práve v období, keď pacient nemá príznaky a náhrada funkcie obličiek nie je bezprostrednou témou.</p>

<p>Včasná konzultácia má najväčší význam pri rýchlej progresii, významnej albuminúrii, nejasnej hematúrii, rezistentnej hypertenzii, dedičných alebo systémových ochoreniach a vysokom predikovanom riziku zlyhania obličiek. Nie každý mierne abnormálny výsledok však vyžaduje trvalé nefrologické sledovanie. Rozhodnutie má vychádzať z príčiny ochorenia, kategórie eGFR a albuminúrie, vývoja v čase, komplikácií a <strong>vypočítaného individuálneho rizika</strong> — nie z jediného čísla.</p>

<p>Najdôležitejším cieľom nefrologickej starostlivosti nie je pripraviť pacienta na dialýzu, ale chrániť funkciu obličiek, znižovať kardiovaskulárne riziko a dialýze podľa možnosti predísť.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nefrologicka-ambulancia-co-sa-vysetruje">Čo sa vyšetruje v nefrologickej ambulancii</a> — verzia pre pacientov.</li>
  <li><a href="article.php?slug=nerozpoznana-ckd-hypertenzia-kardiovaskularne-ochorenie">Nerozpoznaná CKD pri hypertenzii a KV ochorení</a> — prečo diagnóza často chýba.</li>
  <li><a href="article.php?slug=spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd">Spolupráca všeobecného lekára a nefrológa</a>.</li>
  <li><a href="article.php?slug=upcr-vs-uacr-riziko-zlyhania-obliciek-ckd">UPCR oproti UACR a riziko zlyhania obličiek</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a>; <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Adeera Levin, Sofia B. Ahmed, Juan Jesus Carrero, Bethany Foster, Anna Francis, Rasheeda K. Hall, Will G. Herrington, Guy Hill, Lesley A. Inker, Rümeyza Kazancıoğlu, Edmund Lamb, Peter Lin, Magdalena Madero a spol.</strong> <em>Executive summary of the KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4):684–701. <a href="https://doi.org/10.1016/j.kint.2023.10.016" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Teresa K. Chen, Daphne H. Knicely, Morgan E. Grams.</strong> <em>Chronic Kidney Disease Diagnosis and Management: A Review.</em> JAMA. 2019;322(13):1294–1304. <a href="https://doi.org/10.1001/jama.2019.14745" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Neil A. Smart, Thomas T. Titus.</strong> <em>Outcomes of Early versus Late Nephrology Referral in Chronic Kidney Disease: A Systematic Review.</em> The American Journal of Medicine. 2011;124(11):1073–1080.e2. <a href="https://doi.org/10.1016/j.amjmed.2011.04.026" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Chronic Kidney Disease: Assessment and Management (NICE Guideline NG203).</em> <a href="https://www.nice.org.uk/guidance/ng203" target="_blank" rel="noopener noreferrer">NICE</a>.</li>
  <li><strong>National Institute of Diabetes and Digestive and Kidney Diseases.</strong> <em>Chronic Kidney Disease Tests and Diagnosis.</em> <a href="https://www.niddk.nih.gov/health-information/kidney-disease/chronic-kidney-disease-ckd/tests-diagnosis" target="_blank" rel="noopener noreferrer">NIDDK</a>.</li>
  <li><strong>Centers for Disease Control and Prevention.</strong> <em>Chronic Kidney Disease in the United States.</em> <a href="https://www.cdc.gov/kidney-disease/php/data-research/" target="_blank" rel="noopener noreferrer">CDC</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Prahy rizika zlyhania obličiek odporúčané v KDIGO 2024 — 3 až 5 % za 5 rokov pre odoslanie k nefrológovi, viac než 10 % za 2 roky pre multidisciplinárnu starostlivosť a viac než 40 % za 2 roky pre edukáciu o modalitách a prípravu náhrady funkcie obličiek — ako aj upozornenie, že rovnice validované pre CKD G3 – G5 nemusia platiť pri G1 – G2, boli overené proti verejne dostupnému zneniu odporúčaní. Bibliografia bola overená cez Crossref. <strong>Opravy oproti pôvodnému spracovaniu:</strong> opravené mená <strong>Neil A. Smart</strong> a <strong>Thomas T. Titus</strong> (v podklade nesprávne „Nicole A. Smart, Timothy T. Titus“); autorský kolektív výkonného súhrnu KDIGO 2024 má <strong>33 členov</strong> (v podklade bolo uvedených 12), citácia preto uvádza prvých trinásť a „a spol.“. Doplnené boli dva ďalšie rizikové prahy KDIGO, ktoré podklad neuvádzal. Rozdelenie kompetencií nefrológ – urológ, poznámky k diéte a kritický rozbor populárnych tvrdení sú <strong>vlastným odborným spracovaním</strong>, nie prekladom konkrétneho zdroja.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_nefrolog-nie-je-lekar-az-pre-dialyzu-vcasne-vysetrenie_article',
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
