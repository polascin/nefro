<?php

/**
 * add_primarna-alebo-latkou-vyvolana-psychoza-diagnostika_article.php
 * Primarna vs latkou vyvolana psychoza - diferencialna diagnostika a akutna liecba.
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
    'title'        => 'Primárna alebo látkou vyvolaná psychóza? Diferenciálna diagnostika a zásady akútnej liečby',
    'slug'         => 'primarna-alebo-latkou-vyvolana-psychoza-diagnostika',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Rozlíšenie primárnej a látkou vyvolanej psychózy nestojí na toxikologickom teste ani na pevnej časovej hranici. Po psychóze vyvolanej kanabisom prejde k schizofrénii asi tretina pacientov — po alkohole a sedatívach približne desatina.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Psychóza je syndróm, nie etiologická diagnóza. Rozlíšenie primárnej psychotickej poruchy od psychózy vyvolanej psychoaktívnou látkou nemožno založiť na jedinom príznaku, toxikologickom teste ani na pevnej časovej hranici. Rozhoduje časová os, objektívna anamnéza, vylúčenie delíria a sledovanie vývoja po ukončení expozície.</em></p>

<p>Psychotické príznaky sa môžu objaviť pri schizofréniovom spektre, afektívnych poruchách, intoxikácii alebo abstinenčnom syndróme, v súvislosti s liekmi, pri delíriu a pri neurologických, metabolických, endokrinných, infekčných či autoimunitných ochoreniach. Pre nefrológa je táto téma relevantnejšia, než by sa zdalo — u pacienta s pokročilou chorobou obličiek je psychotický obraz spravidla prejavom niečoho iného než primárnej psychiatrickej poruchy.</p>

<h2>Čo psychóza znamená</h2>

<p>Medzi hlavné psychotické prejavy patria <strong>bludy</strong> (pevné presvedčenia nezodpovedajúce realite, ktoré nemožno korigovať dôkazmi), <strong>halucinácie</strong> (najčastejšie sluchové, ale aj zrakové, hmatové, čuchové alebo chuťové), <strong>dezorganizované myslenie a reč</strong>, <strong>výrazne dezorganizované alebo katatónne správanie</strong> a <strong>negatívne symptómy</strong> — oploštená afektivita, abúlia, alógia a sociálne stiahnutie.</p>

<p>Zjednodušenie, že psychóza znamená „stratu kontaktu s realitou“, je zrozumiteľné, ale neúplné. Intenzita príznakov aj náhľad kolíšu. Čiastočne zachovaný náhľad preto psychotickú poruchu nevylučuje a jeho prítomnosť sama osebe nesvedčí pre látkovú etiológiu.</p>

<h2>Ktoré látky a lieky psychózu vyvolávajú</h2>

<p>Psychotické prejavy sa môžu vyskytnúť počas intoxikácie aj abstinencie. Najčastejšie sa zvažuje kanabis (najmä prípravky s vysokým obsahom tetrahydrokanabinolu), amfetamín a metamfetamín, kokaín, syntetické katinóny, halucinogény, fencyklidín a príbuzné disociatíva, syntetické kanabinoidy, alkoholový abstinenčný syndróm a abstinenčný syndróm po benzodiazepínoch alebo iných sedatívach.</p>

<p>Psychózu alebo závažné neuropsychiatrické prejavy môžu vyvolať aj lieky — dopaminergné látky vrátane levodopy, systémové glukokortikoidy, anticholinergiká, niektoré antiepileptiká, stimulanciá a niektoré antivirotiká a imunomodulačné lieky.</p>

<p>Časová následnosť je nevyhnutná, ale nestačí. To, že pacient látku užil pred vznikom psychózy, príčinný vzťah nedokazuje. Užívanie látok je časté aj pri primárnych psychotických poruchách a môže byť príčinou, spúšťačom, udržiavajúcim faktorom alebo iba sprievodným javom.</p>

<h2>Rozhoduje časová os</h2>

<p>Zisťovať treba: kedy sa začala expozícia, aká bola dávka, frekvencia a spôsob podania, kedy sa objavili prvé zmeny správania a psychotické príznaky, či vznikli počas intoxikácie alebo abstinencie, či podobné epizódy predchádzali užívaniu látky, ako sa stav menil počas <em>preukázanej</em> abstinencie, či príznaky úplne ustúpili a či je prítomná rodinná anamnéza psychotickej alebo bipolárnej poruchy.</p>

<p>Náhly začiatok tesne po expozícii a rýchle ustúpenie po jej ukončení podporujú látkovú etiológiu. Postupný rozvoj sociálneho ústupu, funkčného poklesu, negatívnych symptómov a dezorganizácie počas týždňov až mesiacov skôr svedčí pre primárnu psychotickú poruchu.</p>

<p>Ani jeden priebeh však nie je špecifický. Schizofrénia môže prepuknúť akútne a psychóza po stimulanciách môže pretrvávať podstatne dlhšie, než by zodpovedalo trvaniu intoxikácie.</p>

<h2>Hranica jedného mesiaca nie je pravidlo</h2>

<p>Často sa uvádza, že pretrvávanie psychózy dlhšie ako približne jeden mesiac po ukončení užívania látky svedčí pre primárnu psychotickú poruchu. Ide o užitočné diagnostické vodidlo, <strong>nie o biologicky absolútnu hranicu</strong>.</p>

<p>Pretrvávanie príznakov približne mesiac po skončení akútnej intoxikácie alebo abstinencie má viesť k dôkladnému prehodnoteniu diagnózy. Nemožno však mechanicky tvrdiť, že psychóza trvajúca 29 dní je látková a psychóza trvajúca 31 dní primárna. Priebeh ovplyvňujú vlastnosti a dávka látky, opakované alebo kombinované užívanie, neistota o skutočnej abstinencii, individuálna zraniteľnosť, predchádzajúce epizódy a súčasné neurologické alebo metabolické ochorenie. Definitívna diagnóza môže vyžadovať dlhodobejšie sledovanie.</p>

<h2>Ktoré príznaky pomáhajú a ktoré zavádzajú</h2>

<p>Sluchové halucinácie, bludy a poruchy myslenia sú typické pre primárne psychotické poruchy. Zrakové a hmatové halucinácie zvyšujú podozrenie na intoxikáciu, abstinenčný stav, delírium alebo neurologické ochorenie — formikácie sa objavujú pri intoxikácii kokaínom a stimulanciami, zrakové halucinácie pri alkoholovom abstinenčnom syndróme.</p>

<p>Tieto rozdiely však nie sú diagnostické samy osebe: zrakové halucinácie sa vyskytujú aj pri primárnej psychóze, sluchové aj pri látkovej, paranoidné bludy sú bežné v oboch skupinách a čiastočný náhľad etiológiu nerozlišuje.</p>

<h2>Najprv vylúčiť delírium</h2>

<p>Toto je najdôležitejší krok — a v somatickej medicíne najčastejšie opomínaný. Delírium sa typicky prejavuje poruchou pozornosti a bdelosti, kolísaním stavu počas dňa, dezorientáciou, narušením spánkového rytmu, akútnym alebo subakútnym začiatkom a prítomnosťou somatickej, toxickej alebo abstinenčnej príčiny.</p>

<p>Halucinácie pri delíriu neznamenajú primárnu psychotickú poruchu. <strong>Delírium je urgentný medicínsky stav</strong> a vyžaduje prednostnú diagnostiku a liečbu základnej príčiny. Alkoholový alebo benzodiazepínový abstinenčný syndróm s autonómnou hyperaktivitou, poruchou vedomia alebo záchvatmi nemožno redukovať na „látkou vyvolanú psychózu“.</p>

<h2>Akútne vyšetrenie</h2>

<h3>Bezpečnosť</h3>

<p>Bezodkladne treba posúdiť suicidálne a násilné riziko, schopnosť pacienta zabezpečiť základné potreby, závažnosť agitovanosti, intoxikáciu alebo abstinenciu, delírium a poruchu vedomia, prítomnosť nebezpečných predmetov a potrebu urgentnej hospitalizácie. Deeskalácia a pokojné prostredie majú prednosť, ak ich možno bezpečne použiť.</p>

<h3>Anamnéza</h3>

<p>Informácie nemožno získavať iba od pacienta, pretože náhľad aj pamäť môžu byť narušené. Dôležité sú údaje od rodiny, záchrannej služby, ambulantných lekárov, lekárnika a z predchádzajúcej dokumentácie. Cielene treba zisťovať všetky psychoaktívne látky vrátane syntetických prípravkov, alkohol a sedatíva, lieky na predpis aj voľnopredajné prípravky, nedávne zmeny dávkovania, spánkovú depriváciu, predchádzajúce epizódy, afektívne symptómy, epileptické záchvaty, úrazy hlavy a infekcie, pôrod a šestonedelie a autoimunitné alebo onkologické ochorenie.</p>

<h3>Fyzikálne a neurologické vyšetrenie</h3>

<p>Hodnotia sa vitálne funkcie, hydratácia, výživa, známky úrazu alebo vpichov, veľkosť a reaktivita zreníc, tremor, rigidita, klonus a autonómna aktivita. Fokálny neurologický deficit, nový záchvat, katatónia, rýchla kognitívna deteriorácia, dyskinézy, porucha vedomia alebo vysoká horúčka zvyšujú podozrenie na sekundárnu príčinu.</p>

<h2>Negatívny toxikologický skríning látkovú psychózu nevylučuje</h2>

<p>Bežné močové imunochemické testy majú obmedzený rozsah a rozdielne detekčné okná. Nemusia zachytiť syntetické kanabinoidy, mnohé nové psychoaktívne látky, LSD, niektoré benzodiazepíny, látku už eliminovanú pred odberom ani látku prítomnú pod detekčným prahom.</p>

<p>Pozitívny výsledok zase nedokazuje, že zistená látka psychózu spôsobila — metabolity kanabisu môžu zostať detegovateľné dlho po odznení akútneho účinku. <strong>Toxikologické vyšetrenie je doplnkom anamnézy, nie etiologickým verdiktom.</strong></p>

<h2>Ako často látková psychóza prejde do schizofrénie</h2>

<p>Toto je otázka s prekvapivo dobrými dátami. Systematický prehľad a metaanalýza Benjamina Murrieho a spolupracovníkov zahrnula 50 štúdií so 79 odhadmi prechodu u 40 783 osôb. Látkou vyvolaná psychóza prešla do schizofrénie u <strong>25 % (95 % IS 18–35 %)</strong>. Rozdiely podľa látky sú však podstatné:</p>

<div class="table-responsive" role="region" aria-label="Ako často látková psychóza prejde do schizofrénie" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Látka</th><th scope="col">Podiel s prechodom do schizofrénie</th><th scope="col">95 % IS</th></tr>
  </thead>
  <tbody>
    <tr><td><strong>Kanabis</strong></td><td><strong>34 %</strong></td><td>25–46 %</td></tr>
    <tr><td>Halucinogény</td><td>26 %</td><td>14–43 %</td></tr>
    <tr><td>Amfetamíny</td><td>22 %</td><td>14–34 %</td></tr>
    <tr><td>Opioidy</td><td>12 %</td><td>—</td></tr>
    <tr><td>Alkohol</td><td>10 %</td><td>—</td></tr>
    <tr><td>Sedatíva</td><td>9 %</td><td>—</td></tr>
  </tbody>
</table>
</div>

<p>Klinicky použiteľný záver je teda diferencovaný: psychóza po kanabise, halucinogénoch a amfetamínoch nesie podstatné riziko neskoršieho prechodu k schizofrénii a zasluhuje si aktívne psychiatrické sledovanie, kým po alkohole a sedatívach je riziko rádovo nižšie.</p>

<p>Zaujímavý je aj komparátor, ktorý pôsobí proti alarmizmu: iné krátke psychózy prechádzali do schizofrénie v <strong>36 %</strong> prípadov, teda <em>častejšie</em> než psychózy vyvolané látkami. Označenie epizódy za „látkovú“ preto neznamená horšiu prognózu než pri krátkej psychóze bez zistenej látky.</p>

<h2>Kanabis a zraniteľnosť</h2>

<p>Rastúca potencia kanabisových produktov a možnosť, že intenzívne užívanie odhalí alebo urýchli psychotické ochorenie u zraniteľného človeka, sú podložené obavy. Metafora „zapnutia spiaceho génu“ je však biologicky príliš zjednodušujúca.</p>

<p>Psychóza vzniká interakciou genetickej predispozície, neurovývinových faktorov, prostredia a expozície psychoaktívnym látkam. Výskum podporuje asociáciu medzi častým užívaním vysokopotentných produktov a zvýšeným rizikom psychotických porúch. U jednotlivca však <strong>nemožno určiť, či by ochorenie bez kanabisu nikdy nevzniklo</strong> — a metaanalytické údaje o prechode zhrňujú heterogénne observačné štúdie, nie individuálnu predikciu.</p>

<h2>Zásady akútnej liečby</h2>

<h3>Podporné pozorovanie</h3>

<p>Pri miernej, ustupujúcej intoxikačnej psychóze bez agitovanosti, suicidality, násilia, delíria alebo medicínskej nestability môže postačovať pokojné prostredie, monitorovanie a podporná starostlivosť. „Nechať pacienta metabolizovať látku“ však nie je prípustné bez predchádzajúceho posúdenia rizika a vitálnych funkcií.</p>

<h3>Abstinenčné syndrómy</h3>

<p>Pri alkoholovom alebo benzodiazepínovom abstinenčnom syndróme sú základom liečby <strong>benzodiazepíny</strong> podľa klinického protokolu. Antipsychotiká adekvátnu liečbu abstinencie nenahrádzajú a pri nevhodnom použití môžu znižovať záchvatový prah alebo maskovať závažnosť stavu.</p>

<h3>Antipsychotiká</h3>

<p>Antipsychotikum možno použiť pri závažnej psychóze, agitovanosti alebo ohrození pacienta a okolia. Výber sa má riadiť pravdepodobnou príčinou, vekom a somatickým stavom, dĺžkou intervalu QT, rizikom extrapyramídových a metabolických účinkov, predchádzajúcou odpoveďou, liekovými interakciami, funkciou obličiek a pečene a potrebnou rýchlosťou účinku.</p>

<p>Paušálne uprednostňovanie antipsychotík prvej generácie nepredstavuje univerzálne odporúčanie. Prvá generácia môže byť vhodná v niektorých akútnych situáciách, nesie však vyššie riziko akútnych dystónií a akatízie. Druhá generácia má iný — nie automaticky priaznivejší — profil, najmä z hľadiska metabolických účinkov.</p>

<h3>Dlhodobá liečba</h3>

<p>Pri potvrdenej primárnej psychotickej poruche sa plánuje udržiavacia farmakoterapia, psychosociálna intervencia a dlhodobé sledovanie. Dĺžku liečby nemožno paušálne označiť za celoživotnú. Ani po predpokladanej látkovej psychóze sa antipsychotikum nemá automaticky vysadiť presne po mesiaci — postup musí byť individuálny, pomalý a spojený s monitorovaním abstinencie a návratu príznakov.</p>

<h2>Liečba poruchy užívania látok je súčasťou liečby</h2>

<p>Ústup psychózy nie je ukončením starostlivosti. Potrebné sú motivačné intervencie, liečba poruchy užívania konkrétnej látky, prevencia relapsu, edukácia pacienta a rodiny, psychosociálne služby, sledovanie kognitívnych, afektívnych a negatívnych symptómov a včasná psychiatrická kontrola. Pokračujúce užívanie zvyšuje riziko recidívy, hospitalizácií aj diagnostickej neistoty.</p>

<h2>Osobitný význam v nefrológii</h2>

<p>U pacientov s chronickou chorobou obličiek alebo na dialýze treba pred stanovením primárnej psychiatrickej diagnózy vylúčiť najmä:</p>

<ul>
  <li>uremickú encefalopatiu,</li>
  <li>poruchy sodíka, vápnika, horčíka a acidobázickej rovnováhy,</li>
  <li>hypoglykémiu alebo hyperosmolárny stav,</li>
  <li>hypertenznú encefalopatiu,</li>
  <li>infekciu a sepsu,</li>
  <li>liekovú toxicitu pri zníženom renálnom vylučovaní,</li>
  <li>intoxikáciu alebo abstinenčný syndróm,</li>
  <li>dialyzačný dysekvilibračný syndróm v príslušnom kontexte,</li>
  <li>deficit tiamínu alebo inú závažnú malnutríciu.</li>
</ul>

<p>Akútny nepokoj, halucinácie alebo paranoidné správanie u dialyzovaného pacienta nemajú byť automaticky označené za psychiatrickú psychózu. <strong>Fluktuácia pozornosti a vedomia smeruje k delíriu alebo metabolickej encefalopatii</strong>, nie k primárnej psychotickej poruche — a rozdiel je zásadný, pretože určuje, či sa bude hľadať a liečiť somatická príčina.</p>

<p>Pri výbere psychofarmaka treba zohľadniť funkciu obličiek, dialyzovateľnosť, predĺženie intervalu QT, elektrolytové poruchy, ortostatickú hypotenziu a liekové interakcie. Dávkovanie sa musí posudzovať pre konkrétny liek — neexistuje jednotná „renálna dávka“ celej skupiny antipsychotík.</p>

<h2>Varovné znaky sekundárnej psychózy</h2>

<p>Urgentné somatické a neurologické vyšetrenie vyžaduje najmä prvá psychóza vo vyššom veku, porucha vedomia alebo výrazné kolísanie stavu, horúčka alebo autonómna nestabilita, nový epileptický záchvat, fokálny neurologický nález, katatónia, rýchla kognitívna deteriorácia, výrazné poruchy pohybu, závažná bolesť hlavy, nedávny úraz, imunosupresia, šestonedelie, podozrenie na intoxikáciu alebo abstinenciu a náhly vznik príznakov bez predchádzajúcej psychiatrickej anamnézy.</p>

<p>Popôrodná psychóza je psychiatrický urgentný stav, často súvisiaci s bipolárnym spektrom; nie je vhodné zaraďovať ju bez ďalšieho medzi „psychózy spôsobené medicínskym ochorením“.</p>

<h2>Záver</h2>

<p>Rozlíšenie primárnej a látkou vyvolanej psychózy je longitudinálny proces, nie jednorazové rozhodnutie. Najdôležitejšia je podrobná časová os expozície a príznakov, objektívna anamnéza, vylúčenie delíria a medicínskych príčin a sledovanie vývoja počas preukázanej abstinencie.</p>

<p>Náhly začiatok, zrakové alebo hmatové halucinácie a rýchle zlepšenie po ukončení expozície podporujú látkovú etiológiu, ale istotu neposkytujú. Negatívny toxikologický skríning ju nevylučuje a pretrvávanie príznakov nad mesiac podozrenie na primárnu poruchu zvyšuje, no nerozhoduje.</p>

<p>Látkou vyvolaná psychóza nie je vždy krátka a prognosticky nevýznamná epizóda — po kanabise prejde k schizofrénii približne tretina pacientov. Každá prvá psychotická epizóda preto vyžaduje odborné vyšetrenie, liečbu poruchy užívania látok a dostatočne dlhé psychiatrické sledovanie.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy">Dialyzačný dysekvilibračný syndróm</a> — dôležitá položka v diferenciálnej diagnostike zmätenosti.</li>
  <li><a href="article.php?slug=semaglutid-wernickeho-encefalopatia-deficit-tiaminu">Wernickeho encefalopatia a deficit tiamínu</a>.</li>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">CKD a mozog</a> — kognitívne poruchy a cievne poškodenie.</li>
  <li><a href="article.php?slug=lubovnik-bodkovany-depresia-interakcie-nefrologia">Ľubovník bodkovaný a liekové interakcie</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Adjoa Smalls-Mantey.</strong> <em>Primary or Substance-Induced Psychosis? How to Tell and Treat.</em> Medscape, 2026. <a href="https://www.medscape.com/viewarticle/primary-or-substance-induced-psychosis-how-tell-and-treat-2026a1000opg" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>Benjamin Murrie, Julia Lappin, Matthew Large, Grant Sara.</strong> <em>Transition of Substance-Induced, Brief, and Atypical Psychoses to Schizophrenia: A Systematic Review and Meta-analysis.</em> Schizophrenia Bulletin. 2020;46(3):505–516. doi: 10.1093/schbul/sbz102. <a href="https://pubmed.ncbi.nlm.nih.gov/31618428/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Maja Skikic, Jose Alberto Arriola.</strong> <em>First Episode Psychosis Medical Workup: Evidence-Informed Recommendations and Introduction to a Clinically Guided Approach.</em> Child and Adolescent Psychiatric Clinics of North America. 2020;29(1):15–28. doi: 10.1016/j.chc.2019.08.010. <a href="https://pubmed.ncbi.nlm.nih.gov/31708044/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a autorstvo všetkých citovaných prác boli overené v Europe PMC. Číselné údaje o prechode do schizofrénie — 50 štúdií, 79 odhadov, 40 783 osôb, celkovo 25 % (95 % IS 18 – 35 %), kanabis 34 % (25 – 46 %), halucinogény 26 % (14 – 43 %), amfetamíny 22 % (14 – 34 %), opioidy 12 %, alkohol 10 %, sedatíva 9 % a 36 % pri iných krátkych psychózach — boli overené proti zneniu abstraktu metaanalýzy. Zdrojový článok Medscape uvádza niektoré tvrdenia kategorickejšie, než dovoľujú dôkazy; v tomto spracovaní sú <strong>zámerne zmiernené</strong> — týka sa to najmä hranice jedného mesiaca ako rozhodujúceho kritéria, výpovednej hodnoty zrakových a hmatových halucinácií, paušálneho uprednostňovania antipsychotík prvej generácie, tvrdenia o odlišnom účinku antipsychotík na halucinácie a bludy a metafory „zapnutia spiaceho génu“. Nefrologická časť, zoznam varovných znakov a praktické postupy sú <strong>vlastným odborným spracovaním</strong>. Článok má informačný charakter; akútna psychóza vyžaduje individuálne psychiatrické a somatické posúdenie a pri ohrození pacienta alebo okolia ide o urgentný stav.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_primarna-alebo-latkou-vyvolana-psychoza-diagnostika_article',
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
