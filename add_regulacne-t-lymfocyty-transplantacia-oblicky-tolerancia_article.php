<?php
/**
 * add_regulacne-t-lymfocyty-transplantacia-oblicky-tolerancia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): Regulačné T-lymfocyty (Treg) po
 * transplantácii obličky — cesta k cielenej tolerancii bez celoživotnej
 * imunosupresie? Slovenské odborné spracovanie. Východiskový zdroj: spravodajský
 * článok Medscape; hlavný odborný prehľad: Bluestone a kol., Frontiers in Science
 * (2026); kritický komentár: Issa & Wood (2026). Pôvodní autori v source_authors.php.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Regulačné T-lymfocyty po transplantácii obličky: cesta k imunologickej tolerancii bez celoživotnej imunosupresie?',
    'slug'         => 'regulacne-t-lymfocyty-transplantacia-oblicky-tolerancia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Regulačné T-lymfocyty (Treg) sľubujú cielenú transplantačnú toleranciu namiesto plošnej imunosupresie. Prvé klinické štúdie potvrdili uskutočniteľnosť a krátkodobú bezpečnosť, zatiaľ však nedokázali, že po transplantácii obličky dokážu spoľahlivo nahradiť celoživotnú imunosupresiu.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>Súčasná transplantácia obličky je založená na dlhodobej kombinovanej imunosupresii. Tá účinne znižuje riziko akútnej rejekcie, ale zároveň zvyšuje výskyt závažných infekcií, malignít, metabolických komplikácií, kardiovaskulárnych príhod a liekovej nefrotoxicity. Ani moderná imunosupresia navyše spoľahlivo nezabráni chronickému poškodzovaniu aloštepu.</p>

<p>Regulačné T-lymfocyty, označované ako Treg bunky, predstavujú možnosť, ako imunitnú odpoveď nepotláčať plošne, ale cielene obnoviť toleranciu voči antigénom darcu. Experimentálne a prvé klinické štúdie potvrdili, že Treg bunky možno izolovať, namnožiť, geneticky upraviť a podať pacientovi. Doterajšie dôkazy však ešte nepreukazujú, že by po transplantácii obličky dokázali bezpečne a trvalo nahradiť štandardnú imunosupresiu.</p>

<p>Titulok pôvodného článku Medscape, podľa ktorého by nová terapeutická trieda mohla ukončiť používanie imunosupresív, preto vyjadruje dlhodobú vedeckú ambíciu, nie súčasnú klinickú realitu.</p>

<h2>Čo sú regulačné T-lymfocyty</h2>

<p>Regulačné T-lymfocyty sú špecializovanou populáciou CD4+ T-lymfocytov, ktorá udržiava periférnu imunitnú toleranciu. Typicky exprimujú vysokú hladinu receptora CD25 a transkripčný faktor FOXP3, ktorý má zásadný význam pre ich vývoj, stabilitu a regulačnú funkciu.</p>

<p>Treg bunky nie sú iba pasívnou „brzdou“ imunitného systému. Ide o funkčne heterogénnu bunkovú populáciu, ktorá reaguje na lokálne antigény, cytokíny, metabolické podmienky a signály poškodeného tkaniva. Niektoré Treg bunky vznikajú v týmuse, iné sa diferencujú z konvenčných T-lymfocytov v periférnych tkanivách.</p>

<p>Ich biologická úloha zahŕňa:</p>

<ul>
  <li>udržiavanie tolerancie voči vlastným antigénom,</li>
  <li>obmedzovanie nadmernej zápalovej reakcie,</li>
  <li>reguláciu odpovede voči environmentálnym a potravinovým antigénom,</li>
  <li>podporu tolerancie voči črevnému mikrobiómu,</li>
  <li>kontrolu imunitnej odpovede počas gravidity,</li>
  <li>podporu reparácie a regenerácie tkanív.</li>
</ul>

<p>V transplantačnej medicíne je najdôležitejšia ich schopnosť tlmiť reakciu proti antigénom darcu bez úplného vyradenia obrany proti ostatným antigénom.</p>

<h2>Ako Treg bunky tlmia imunitnú odpoveď</h2>

<p>Regulačné T-lymfocyty využívajú viacero vzájomne sa dopĺňajúcich mechanizmov.</p>

<h3>Inhibičné cytokíny</h3>

<p>Treg bunky produkujú interleukín 10 a transformujúci rastový faktor beta. Tieto mediátory tlmia aktiváciu efektorových T-lymfocytov, makrofágov a antigén prezentujúcich buniek.</p>

<h3>CTLA-4 a obmedzenie kostimulácie</h3>

<p>Molekula CTLA-4 na povrchu Treg buniek interaguje s CD80 a CD86 na antigén prezentujúcich bunkách. Tým znižuje dostupnosť kostimulačných signálov, ktoré sú potrebné na plnú aktiváciu efektorových T-lymfocytov.</p>

<h3>Spotreba interleukínu 2</h3>

<p>Treg bunky exprimujú vysoké množstvo CD25, vysokoafinitnej súčasti receptora pre interleukín 2. Intenzívnym vychytávaním interleukínu 2 obmedzujú jeho dostupnosť pre efektorové T-lymfocyty a súčasne podporujú vlastné prežívanie.</p>

<h3>Metabolická regulácia</h3>

<p>Prostredníctvom molekúl CD39 a CD73 premieňajú extracelulárne nukleotidy na adenozín s protizápalovým účinkom. Ovplyvňujú aj metabolizmus tryptofánu a tvorbu imunoregulačných kynurenínov.</p>

<h3>Bystander supresia a prenos tolerancie</h3>

<p>Treg bunka rozpoznávajúca konkrétny antigén môže v jeho okolí vytvoriť regulačné mikroprostredie a tlmiť aj reakcie namierené proti ďalším antigénom. Takzvaná infekčná tolerancia navyše umožňuje preniesť regulačný fenotyp na ďalšie imunitné bunky.</p>

<p>Práve tieto mechanizmy vytvárajú predpoklad, že relatívne malá populácia antigénovo špecifických Treg buniek by mohla vyvolať rozsiahlejšiu a dlhodobejšiu toleranciu aloštepu.</p>

<h2>Treg bunky ako živý liek</h2>

<p>Na rozdiel od klasického lieku sú terapeutické Treg bunky biologicky aktívnym a premenlivým produktom. Po podaní môžu migrovať do tkanív, proliferovať, reagovať na lokálne podmienky a meniť svoj funkčný stav.</p>

<p>Vyvíja sa niekoľko základných prístupov.</p>

<h3>Polyklonálne autológne Treg bunky</h3>

<p>Treg bunky sa izolujú z krvi pacienta, namnožia v laboratóriu a následne sa podajú tomu istému pacientovi. Výhodou je nízke riziko imunologického odmietnutia bunkového produktu. Nevýhodou je široká antigénová reaktivita a relatívne nízky podiel buniek špecifických pre darcu.</p>

<h3>Treg bunky reaktívne voči darcovi</h3>

<p>Počas laboratórnej expanzie možno selektívne obohatiť bunky rozpoznávajúce antigény konkrétneho darcu. Takýto produkt by mohol byť účinnejší pri menšom počte podaných buniek, jeho výroba je však technicky náročnejšia.</p>

<h3>TCR-modifikované Treg bunky</h3>

<p>Genetická úprava môže Treg bunkám vložiť definovaný T-bunkový receptor. Ten ich nasmeruje proti konkrétnemu antigénu. Použitie limituje závislosť rozpoznávania od konkrétnych molekúl HLA.</p>

<h3>CAR-Treg bunky</h3>

<p>Treg bunky možno vybaviť chimérickým antigénovým receptorom, CAR, ktorý rozpoznáva povrchový antigén nezávisle od klasickej prezentácie prostredníctvom HLA. V transplantácii sa skúmajú najmä receptory namierené proti antigénom darcu, napríklad HLA-A2.</p>

<p>CAR-Treg bunky zatiaľ predstavujú prevažne experimentálny prístup. Účinnosť v bunkových a zvieracích modeloch nemožno automaticky preniesť na ľudskú transplantáciu.</p>

<h3>Univerzálne produkty od zdravých darcov</h3>

<p>Takzvané „off-the-shelf“ produkty by sa vyrábali vo väčších sériách z buniek zdravých darcov. Mohli by znížiť cenu a skrátiť čas prípravy. Vyžadujú však riešenie rizika odmietnutia podaných buniek, aloimunizácie a nežiaducej imunologickej reakcie.</p>

<h3>Tvorba alebo expanzia Treg buniek priamo v organizme</h3>

<p>Skúmajú sa stratégie založené na nízkych dávkach interleukínu 2, cielených cytokínových komplexoch, nanočasticiach, génovom prenose a programovaní T-lymfocytov priamo v tele. Tieto postupy by mohli obísť individuálnu laboratórnu výrobu, zatiaľ však nemajú overenú účinnosť ani dlhodobú bezpečnosť po transplantácii obličky.</p>

<h2>Čo ukázali klinické štúdie pri transplantácii obličky</h2>

<p>Prvé klinické programy, vrátane medzinárodného projektu ONE Study, ukázali, že podanie regulačných bunkových produktov pacientom po transplantácii obličky je technicky uskutočniteľné. Treg bunky možno pripraviť podľa požadovaných výrobných štandardov a podať príjemcom bez jednoznačného nárastu bezprostredných závažných nežiaducich účinkov.</p>

<p>Niektoré štúdie zaznamenali možnosť znížiť intenzitu udržiavacej imunosupresie. Tieto výsledky však majú významné obmedzenia:</p>

<ul>
  <li>väčšinou išlo o malé štúdie fázy 1 alebo 1/2,</li>
  <li>primárnym cieľom bola bezpečnosť a uskutočniteľnosť,</li>
  <li>viaceré štúdie nemali randomizovanú kontrolnú skupinu,</li>
  <li>používali rozdielne bunkové produkty a výrobné protokoly,</li>
  <li>pacienti naďalej dostávali určitú formu imunosupresie,</li>
  <li>obdobie sledovania bolo nedostatočné na hodnotenie chronickej rejekcie a dlhodobého prežívania štepu.</li>
</ul>

<p>Doterajšie štúdie teda nepotvrdili, že jednorazová alebo opakovaná infúzia Treg buniek umožňuje rutinné a úplné vysadenie imunosupresie.</p>

<h2>Prečo samotná bezpečnosť nestačí</h2>

<p>Neprítomnosť akútnej toxicity neznamená, že bunkový produkt obnovil toleranciu. Budúce štúdie musia preukázať, že Treg bunky:</p>

<ol>
  <li>dosiahli transplantovanú obličku alebo príslušné lymfatické tkanivo,</li>
  <li>pretrvali dostatočne dlho,</li>
  <li>zachovali stabilnú expresiu FOXP3 a regulačný fenotyp,</li>
  <li>skutočne potlačili odpoveď proti darcovi,</li>
  <li>nevytvorili systémovú imunosupresiu,</li>
  <li>umožnili znížiť alebo vysadiť farmakologickú liečbu bez subklinického poškodzovania štepu.</li>
</ol>

<p>Zvýšenie počtu Treg buniek v periférnej krvi nie je dostatočným dôkazom úspechu. Cirkulujúce bunky nemusia odrážať situáciu v aloštepe a regionálnych lymfatických uzlinách.</p>

<h2>Ako by sa mala hodnotiť účinnosť</h2>

<p>Pri transplantácii obličky nestačí sledovať iba neprítomnosť klinickej akútnej rejekcie. Pacient môže mať stabilný kreatinín a súčasne subklinický zápal alebo molekulové známky poškodenia štepu.</p>

<p>Klinické skúšania by mali kombinovať:</p>

<ul>
  <li>meranú alebo odhadovanú GFR,</li>
  <li>dynamiku kreatinínu a cystatínu C,</li>
  <li>albuminúriu alebo proteinúriu,</li>
  <li>protokolárne a indikované biopsie,</li>
  <li>histologické známky rejekcie a chronického poškodenia,</li>
  <li>donor-špecifické HLA protilátky,</li>
  <li>bezbunkovú DNA pochádzajúcu od darcu,</li>
  <li>antigénovo špecifické efektorové a regulačné odpovede,</li>
  <li>molekulové a transkriptomické vyšetrenie biopsie,</li>
  <li>infekcie, malignity a metabolické komplikácie,</li>
  <li>prežívanie pacienta a aloštepu.</li>
</ul>

<p>Skutočným úspechom by bolo bezpečné zníženie imunosupresie pri stabilnej funkcii a histológii štepu bez molekulových známok pokračujúceho poškodenia.</p>

<h2>Riziko straty regulačného fenotypu</h2>

<p>Chronický zápal môže destabilizovať Treg bunky. Cytokíny, ako interleukín 6, interleukín 12 a interleukín 1 beta, môžu oslabiť ich regulačný program. Za určitých podmienok môžu bunky získať vlastnosti efektorových T-lymfocytov a produkovať interferón gama alebo interleukín 17.</p>

<p>Výrobca preto musí overovať nielen počet a životaschopnosť buniek, ale aj:</p>

<ul>
  <li>stabilitu FOXP3,</li>
  <li>epigenetický profil regulačnej línie,</li>
  <li>supresívnu účinnosť,</li>
  <li>neprítomnosť kontaminujúcich efektorových T-lymfocytov,</li>
  <li>genetickú stabilitu,</li>
  <li>odolnosť voči zápalovému prostrediu,</li>
  <li>schopnosť migrácie do cieľového tkaniva.</li>
</ul>

<p>Nedostatočne stabilný alebo kontaminovaný produkt by teoreticky mohol imunitné poškodenie zhoršiť namiesto jeho potlačenia.</p>

<h2>Infekcie a malignity nemusia úplne zmiznúť</h2>

<p>Treg terapia má byť selektívnejšia než systémová imunosupresia, ale ani ona nie je bez imunologických rizík. Treg bunky môžu tlmiť antivírusovú alebo protinádorovú odpoveď, ak sa nahromadia v nesprávnom tkanive alebo získajú nežiaducu antigénovú špecificitu.</p>

<p>Riziko bude závisieť od:</p>

<ul>
  <li>antigénovej špecificity produktu,</li>
  <li>dávky a perzistencie buniek,</li>
  <li>distribúcie v organizme,</li>
  <li>súbežnej imunosupresie,</li>
  <li>veku a infekčnej anamnézy pacienta,</li>
  <li>predchádzajúcich malignít,</li>
  <li>možnosti produkt kontrolovať alebo v prípade potreby eliminovať.</li>
</ul>

<p>Nemožno teda predpokladať, že Treg terapia automaticky odstráni všetky infekčné a onkologické riziká spojené s transplantáciou.</p>

<h2>Výroba je súčasťou biologického účinku</h2>

<p>Autológna výroba vyžaduje odber buniek, ich selekciu, niekoľkotýždňovú expanziu, kontrolu kvality a transport do transplantačného centra. Každý produkt je individuálny a jeho vlastnosti môžu ovplyvniť vek pacienta, chronické ochorenie, predchádzajúca imunosupresia a samotná metóda výroby.</p>

<p>Kryokonzervácia, kultivačné cytokíny, počet bunkových delení a genetická manipulácia môžu meniť životaschopnosť, metabolickú zdatnosť, schopnosť migrácie aj stabilitu regulačného fenotypu.</p>

<p>Cena a organizačná náročnosť môžu byť porovnateľné s inými personalizovanými bunkovými terapiami. Bez automatizácie a štandardizácie bude široká dostupnosť problematická.</p>

<h2>Orca-T nie je dôkazom tolerancie po transplantácii obličky</h2>

<p>Pôvodný článok Medscape uvádza úspešnú štúdiu bunkového produktu Orca-T v alogénnej transplantácii krvotvorných buniek. Ide o transplantát s definovaným zložením, ktorý využíva regulačné T-lymfocyty na zníženie rizika reakcie štepu proti hostiteľovi.</p>

<p>Tento výsledok podporuje biologickú využiteľnosť Treg buniek, nemožno ho však považovať za dôkaz, že rovnaký prístup umožní vysadiť imunosupresiu po transplantácii obličky. Transplantácia krvotvorných buniek a transplantácia solídneho orgánu majú odlišnú imunobiológiu, cieľ liečby, zloženie štepu aj mechanizmus komplikácií.</p>

<p>Orca-T navyše nie je ekvivalentom izolovanej autológnej alebo CAR-Treg terapie. Ide o komplexne zostavený hematopoetický transplantát obohatený o regulačnú bunkovú zložku.</p>

<h2>Potenciálny význam pri autoimunitných ochoreniach obličiek</h2>

<p>Treg terapia by mohla mať uplatnenie aj mimo transplantácie, napríklad pri:</p>

<ul>
  <li>lupusovej nefritíde,</li>
  <li>ANCA-asociovanej vaskulitíde,</li>
  <li>anti-GBM ochorení,</li>
  <li>IgA nefropatii,</li>
  <li>membranóznej nefropatii,</li>
  <li>ďalších imunologicky podmienených glomerulopatiách.</li>
</ul>

<p>Tento potenciál je zatiaľ prevažne experimentálny. Glomerulové ochorenia často nemajú jediný známy cieľový antigén a ich patogenéza zahŕňa protilátky, komplement, neutrofily, monocyty aj tkanivové mechanizmy. Samotná úprava T-bunkovej tolerancie preto nemusí postačovať.</p>

<p>Najväčšiu šancu môže mať včasná liečba, kým ešte nedošlo k rozsiahlej glomeruloskleróze, tubulárnej atrofii a intersticiálnej fibróze. Obnovenie tolerancie totiž nedokáže automaticky obnoviť už zaniknuté nefróny.</p>

<h2>Konflikty záujmov a interpretácia zdroja</h2>

<p>Hlavný prehľad v časopise <em>Frontiers in Science</em> je strategickým odborným dokumentom, nie systematickým prehľadom ani randomizovanou klinickou štúdiou. Viacerí autori sa dlhodobo podieľajú na základnom výskume, vývoji a komercializácii Treg terapií.</p>

<p>Jeffrey A. Bluestone je spoluzakladateľom spoločnosti Sonoma Biotherapeutics, vlastní v nej majetkový podiel a je uvedený ako pôvodca patentov súvisiacich s Treg terapiou. Megan K. Levings je uvedená ako pôvodkyňa patentov týkajúcich sa CAR-Treg technológií a pôsobí vo vedeckej poradnej rade spoločnosti Quell Therapeutics.</p>

<p>Tieto vzťahy neznehodnocujú vedecký obsah, ale posilňujú potrebu oddeliť biologický potenciál od klinicky preukázanej účinnosti.</p>

<h2>Limity súčasných dôkazov</h2>

<p>Súčasný výskum Treg terapií limitujú najmä:</p>

<ul>
  <li>malé a heterogénne súbory pacientov,</li>
  <li>prevažne skoré fázy klinického vývoja,</li>
  <li>rozdielne bunkové produkty a dávkovacie protokoly,</li>
  <li>chýbajúce spoľahlivé biomarkery účinku,</li>
  <li>obmedzené údaje o migrácii buniek do tkanív,</li>
  <li>neistá dlhodobá stabilita regulačného fenotypu,</li>
  <li>krátke sledovanie,</li>
  <li>nedostatok randomizovaných porovnaní,</li>
  <li>súbežné podávanie klasickej imunosupresie,</li>
  <li>výrobná komplexnosť a vysoké náklady.</li>
</ul>

<p>Úplné vysadenie imunosupresie po transplantácii obličky zostáva výskumným cieľom. Mimo kontrolovanej klinickej štúdie by nebolo bezpečné.</p>

<h2>Záver</h2>

<p>Regulačné T-lymfocyty predstavujú jednu z najsľubnejších ciest k cielenej transplantačnej tolerancii. Ich potenciál spočíva v schopnosti rozpoznať antigény darcu, pôsobiť prevažne v mieste imunitnej reakcie a vytvárať dlhodobejšie regulačné prostredie bez plošného potlačenia imunity.</p>

<p>Prvé klinické štúdie potvrdili uskutočniteľnosť a prijateľnú krátkodobú bezpečnosť. Zatiaľ však nepreukázali, že Treg terapia dokáže po transplantácii obličky spoľahlivo nahradiť celoživotnú farmakologickú imunosupresiu.</p>

<p>Najbližším realistickým cieľom nie je úplné odstránenie všetkých imunosupresív, ale bezpečné zníženie ich dávok a toxicity pri zachovaní stabilnej funkcie, histológie a imunologickej integrity aloštepu. Definitívne potvrdenie bude vyžadovať randomizované štúdie s dlhodobým sledovaním, protokolárnymi biopsiami a mechanistickými biomarkermi.</p>

<h2>Zdroje</h2>

<h3>Východiskový spravodajský článok</h3>

<p>Medscape Medical News. <em>A New Class of Therapeutics Could End Immunosuppressants.</em> Medscape, 2026. <a href="https://www.medscape.com/viewarticle/new-class-therapeutics-could-end-immunosuppressants-2026a1000nkm" target="_blank" rel="noopener noreferrer">medscape.com</a></p>

<h3>Hlavný odborný prehľad</h3>

<p>Jeffrey A. Bluestone, Megan K. Levings, Frederick J. Ramsdell, Alexander Y. Rudensky, Qizhi Tang, Piotr Trzonkowski. <em>Regulatory T cells: master orchestrators of immune tolerance and tissue homeostasis.</em> Frontiers in Science (2026); 4: 1792210. DOI: 10.3389/fsci.2026.1792210. <a href="https://www.frontiersin.org/journals/science/articles/10.3389/fsci.2026.1792210/full" target="_blank" rel="noopener noreferrer">frontiersin.org</a></p>

<h3>Kritický odborný komentár</h3>

<p>Fadi Issa, Kathryn Wood. <em>Treg therapy needs better trials.</em> Frontiers in Science (2026); 4: 1874873. DOI: 10.3389/fsci.2026.1874873. <a href="https://www.frontiersin.org/journals/science/articles/10.3389/fsci.2026.1874873/full" target="_blank" rel="noopener noreferrer">frontiersin.org</a></p>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
