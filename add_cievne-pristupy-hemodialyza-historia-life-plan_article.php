<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Cievne prístupy pre hemodialýzu: od prvých kanýl k plánu na celý život',
    'slug' => 'cievne-pristupy-hemodialyza-historia-life-plan',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Šesťdesiat rokov vývoja od Quintonovho-Scribnerovho skratu po endovaskulárnu fistulu. Prečo KDOQI 2019 nahradilo pravidlo „fistula first“ konceptom ESKD Life-Plan.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/cievne-pristupy-hemodialyza-historia-life-plan.webp" type="image/webp">
    <img src="img/cievne-pristupy-hemodialyza-historia-life-plan.png" alt="Poloschematické znázornenie troch typov cievneho prístupu – tunelizovaný katéter, slučkový graft a natívna arteriovenózna fistula – nad prerušovanou osou dlhodobého plánu" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani výrobku. Tri typy prístupu nie sú rebríček, ale možnosti, ktoré majú svoje miesto v rôznych fázach plánu.</figcaption>
</figure>

<p>Cievny prístup je podmienkou chronickej hemodialýzy a zároveň jej najzraniteľnejším článkom. História jeho vývoja je poučná nielen pre zaujímavosť – ukazuje, prečo sa odborné odporúčania za posledné desaťročie posunuli od jednoduchého pravidla „najprv fistula“ k individualizovanému plánovaniu.</p>

<h2>Od sklenených kanýl k opakovanému prístupu</h2>

<p>Prvé pokusy o mimotelovú očistu krvi narážali na elementárny problém: ako sa opakovane dostať do cievneho riečiska. Riešením boli kanyly zo skla, kovu alebo gumy, zavádzané chirurgicky do tepny a žily. Každé napojenie znamenalo obetovanie jednej cievy, takže počet možných dialýz bol daný počtom ciev, ktoré sa dali použiť. Infekcie a trombózy boli pravidlom.</p>

<p>Zlom priniesol v roku 1960 arteriovenózny skrat z teflónových a neskôr silastikových hadičiek, vyvinutý v Seattli tímom okolo Beldinga Scribnera a Wayna Quintona. Skrat zostával medzi dialýzami priechodný, pretože krv ním nepretržite prúdila. Po prvý raz tak bola možná <strong>opakovaná dialýza bez obetovania ďalšej cievy</strong>, a chronická hemodialýza sa stala uskutočniteľnou. Cenou boli infekcie v mieste výstupu a trombózy.</p>

<h2>Rok 1966: natívna fistula</h2>

<p>Rozhodujúci krok urobili Michael Brescia, James Cimino a spolupracovníci. V novembri 1966 opísali v <em>New England Journal of Medicine</em> chronickú hemodialýzu vykonávanú venepunkciou do chirurgicky vytvorenej arteriovenóznej fistuly. Princíp – spojiť tepnu a žilu, nechať žilu pod arteriálnym tlakom dozrieť a potom ju opakovane punktovať ihlami – sa od základu nezmenil dodnes.</p>

<p>Výhoda oproti skratu bola zásadná: <strong>žiadny cudzí materiál neprechádza kožou</strong>. Tým odpadá hlavná vstupná brána pre infekciu. Natívna fistula má preto najnižšiu mieru infekčných komplikácií a najmenej reintervencií zo všetkých typov prístupu. Daňou je nutnosť dozretia, ktorú nemožno obísť.</p>

<h2>Katétre: nevyhnutnosť s cenou</h2>

<p>Perkutánne zavádzanie katétrov umožnila Seldingerova technika – výmena punkčnej ihly za vodiaci drôt, po ktorom sa katéter zavedie do cievy. Dočasné a neskôr tunelizované dvojlumenové katétre dovolili začať dialýzu okamžite, bez čakania na dozretie fistuly.</p>

<p>Komplikácie sa delia na dve skupiny:</p>

<div class="table-responsive" role="region" aria-label="Komplikácie centrálnych žilových katétrov podľa času vzniku" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Časné (pri zavádzaní)</th><th scope="col">Neskoré (počas používania)</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Krvácanie, hematóm</th><td>Infekcia v mieste výstupu</td></tr>
    <tr><th scope="row">Pneumotorax, hemotorax</th><td>Infekcia krvného riečiska súvisiaca s katétrom</td></tr>
    <tr><th scope="row">Malpozícia hrotu</th><td>Trombóza a fibrínový obal katétra</td></tr>
    <tr><th scope="row">Vzduchová embólia</th><td>Stenóza centrálnej žily</td></tr>
    <tr><th scope="row">Poranenie tepny alebo nervu</th><td>Dysfunkcia katétra, dislokácia</td></tr>
  </tbody>
</table>
</div>

<p>Ultrazvuková navigácia pri zavádzaní dnes riziká prvého stĺpca výrazne znižuje. Druhý stĺpec je však vlastnosťou katétra ako takého a práve preto zostáva cieľom skrátiť obdobie závislosti od katétra, nie ho len bezpečnejšie zaviesť.</p>

<p><strong>Stenóza centrálnej žily</strong> si zaslúži osobitnú pozornosť: vzniká ticho a prejaví sa až vtedy, keď na tej istej končatine vytvoríme fistulu a objaví sa masívny opuch. Katéter zavedený dnes môže znemožniť prístup o dva roky.</p>

<h2>Grafty a dysfunkcia prístupu</h2>

<p>Arteriovenózny graft zo syntetického materiálu je riešením, keď vlastné cievy nestačia. Dozrieva rýchlejšie než natívna fistula, ale má vyššiu mieru trombóz, stenóz v žilovej anastomóze a infekčných komplikácií.</p>

<p>Pri natívnej fistule je najväčším problémom opačný koniec cesty – <strong>primárne zlyhanie</strong>. Obštrukcia cievy alebo nedozretie sa podieľa na 20 % až 54 % prípadov primárneho zlyhania fistuly. Veľká časť z toho sú pritom korigovateľné abnormality, ktoré treba včas rozpoznať ultrazvukom a riešiť endovaskulárne. To je dôvod, prečo sa predoperačné mapovanie ciev a pooperačné sledovanie dozrievania stali štandardom.</p>

<h2>Vysokoprietoková fistula a kardiálna záťaž</h2>

<p>Fistula je skratom časti srdcového výdaja mimo kapilárne riečisko. Pri vysokom prietoku – typicky pri proximálnych, brachiálne založených prístupoch – to môže viesť k zvýšeniu srdcového výdaja, remodelácii ľavej komory a u predisponovaného pacienta k zlyhávaniu srdca s vysokým výdajom.</p>

<p>Postup je vtedy nasledovný: zmerať prietok prístupom, vykonať echokardiografiu, posúdiť, nakoľko sa na symptómoch podieľa prístup, a až potom zvažovať chirurgickú alebo endovaskulárnu redukciu prietoku. <em>Jednotná univerzálna prahová hodnota prietoku, ktorá by definovala „vysokoprietokovú“ fistulu, nie je všeobecne prijatá</em> a líši sa podľa typu prístupu aj podľa pracoviska; rozhodovať má kombinácia prietoku, srdcového nálezu a symptómov, nie jedno číslo.</p>

<h2>Ischémia končatiny vyvolaná prístupom (HAIDI)</h2>

<p>Odklonenie arteriálneho prítoku do fistuly alebo graftu môže viesť k nedostatočnej perfúzii ruky a prstov. V literatúre sa tento stav označuje ako <strong>hemodialysis access-induced distal ischemia (HAIDI)</strong>; staršie označenie „steal syndróm“ je nepresné, pretože ischémia nevzniká len „kradnutím“ prietoku, ale aj nedostatočným lokoregionálnym perfúznym tlakom.</p>

<p>Rozhodujúce je načasovanie a závažnosť. Ťažkosti môžu byť prítomné iba počas dialýzy, alebo prejsť do pokojovej bolesti a ďalej k nekróze a gangréne prstov. Ťažká forma sa spája s horším prežívaním, pričom k nej prispievajú aj periférne arteriálne ochorenie a diabetes.</p>

<p>Prevencia je účinnejšia než liečba. Rizikových pacientov treba identifikovať predoperačne – anamnézou, fyzikálnym vyšetrením a zobrazením – a podľa toho zvoliť lokalizáciu a typ prístupu. Riziko je vyššie pri proximálnych, brachiálne založených prístupoch a pri graftoch než pri distálnych natívnych fistulách.</p>

<h2>Endovaskulárne vytvorená fistula</h2>

<p>Od druhej dekády tohto storočia je možné arteriovenóznu anastomózu vytvoriť katétrom, bez otvorenej operácie. Prospektívna multicentrická štúdia NEAT hodnotila endovaskulárnu fistulu v proximálnom predlaktí u 80 pacientov v deviatich centrách v Kanade, Austrálii a na Novom Zélande. Fistula sa podarila u 98 % účastníkov, závažná udalosť súvisiaca s výkonom nastala u 8 % (súvisiaca s pomôckou u 2 %) a fyziologicky vhodných na dialýzu bolo v priebehu troch mesiacov 87 % fistúl, pri priemernom prietoku brachiálnou tepnou 918 ml/min.</p>

<p>Ide o jednoramennú štúdiu bez kontrolnej skupiny, takže priame porovnanie s chirurgicky vytvorenou fistulou z nej vyvodiť nemožno. Metóda má navyše úzke anatomické kritériá a nenahrádza chirurgiu plošne.</p>

<p>Pri vyčerpaní bežných možností pri centrálnej žilovej oklúzii sa používajú neštandardné riešenia – napríklad HeRO graft, ktorý spája arteriálnu graftovú časť s výstužným komponentom zavedeným do centrálneho riečiska, alebo techniky typu „inside-out“. Ide o postupy pre úzko vybraných pacientov v centrách so skúsenosťou.</p>

<h2>ESKD Life-Plan: čo sa v KDOQI 2019 zmenilo</h2>

<p>Aktualizácia odporúčaní KDOQI pre cievny prístup z roku 2019 priniesla koncepčný posun. Namiesto pravidla, ktoré uprednostňuje jeden typ prístupu pre všetkých, zavádza <strong>ESKD Life-Plan</strong> – individualizovaný plán náhrady funkcie obličiek a cievnych prístupov na celý predpokladaný priebeh ochorenia.</p>

<p>Plán odpovedá na otázky, ktoré jedno pravidlo zodpovedať nedokáže:</p>

<ul>
  <li>Aká je očakávaná dĺžka života a priebeh ochorenia u tohto konkrétneho pacienta?</li>
  <li>Je realistickým cieľom transplantácia, peritoneálna dialýza, domáca hemodialýza?</li>
  <li>Ktoré cievy sú k dispozícii teraz a ktoré treba zachovať pre budúce prístupy?</li>
  <li>Aké je poradie prístupov – nielen prvý, ale aj druhý a tretí?</li>
  <li>Čo sa stane, keď aktuálny prístup zlyhá?</li>
</ul>

<p>Z tohto rámca vyplýva aj dôsledok, ktorý sa v praxi podceňuje: <strong>zachovanie ciev je súčasťou plánu od začiatku.</strong> Odbery krvi, periférne kanyly a najmä centrálne katétre na nesprávnej končatine môžu uzavrieť cestu k budúcemu prístupu.</p>

<p>Plán zároveň predpokladá tímovú prácu – nefrológ, cievny chirurg, intervenčný rádiológ, sonografista a dialyzačný tím – a pravidelnú revíziu podľa toho, ako sa stav pacienta a jeho ciele menia.</p>

<h2>Limity</h2>

<ul>
  <li><strong>Historické prvenstvá sa v literatúre uvádzajú nejednotne.</strong> Vývoj prebiehal paralelne na viacerých pracoviskách a priradenie k jednému dátumu je zjednodušením.</li>
  <li><strong>Prahové hodnoty prietoku pre vysokoprietokovú fistulu nie sú všeobecne prijaté.</strong> Čísla uvádzané v prehľadoch sa líšia podľa typu prístupu a pracoviska.</li>
  <li><strong>Údaje o výskyte HAIDI sú heterogénne.</strong> Rozsah závisí od definície, od lokalizácie a typu prístupu aj od spôsobu zisťovania; jedno univerzálne číslo preto tento článok neuvádza.</li>
  <li><strong>Štúdia NEAT bola jednoramenná.</strong> Nemá kontrolnú skupinu ani dlhodobé porovnanie s chirurgicky vytvorenou fistulou.</li>
  <li><strong>Odporúčania KDOQI sú z roku 2019</strong> a vychádzajú prevažne zo severoamerickej praxe; dostupnosť jednotlivých postupov sa v Európe líši.</li>
  <li><strong>Koncept ESKD Life-Plan nebol overený randomizovane.</strong> Ide o organizačný rámec opretý o odbornú zhodu.</li>
</ul>

<h2>Záver</h2>

<p>Šesťdesiat rokov vývoja viedlo od improvizovaných kanýl k súboru postupov, z ktorých má každý svoje miesto. Natívna arteriovenózna fistula zostáva pri chronickej hemodialýze preferovaným prístupom pre najnižšiu mieru infekcií a reintervencií; graft je plnohodnotnou alternatívou tam, kde fistula nie je možná alebo nedozrela; katéter je potrebný, ale jeho používanie treba skrátiť na nevyhnutné minimum.</p>

<p>Hlavný posun však nie je technický, ale organizačný. Otázka „aký prístup založiť“ sa zmenila na otázku „aký je plán prístupov pre tohto pacienta na celý priebeh jeho ochorenia“. Odpoveď na druhú otázku rozhoduje o tom, či bude pacient o päť rokov ešte mať kam dialyzovať.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odborné odporúčania.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Lok CE, Huber TS, Lee T, Shenoy S, Yevzlin AS, Abreo K, Allon M, Asif A, Astor BC, Glickman MH, Graham J, Moist LM, Rajan DK, Roberts C, Vachharajani TJ, Valentini RP; National Kidney Foundation. KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update. <em>Am J Kidney Dis.</em> 2020;75(4 Suppl 2):S1–S164. DOI: <a href="https://doi.org/10.1053/j.ajkd.2019.12.001" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2019.12.001</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32778223/" target="_blank" rel="noopener noreferrer">PubMed PMID 32778223</a>.</small></li>
  <li><small>Brescia MJ, Cimino JE, Appel K, Hurwich BJ. Chronic hemodialysis using venipuncture and a surgically created arteriovenous fistula. <em>N Engl J Med.</em> 1966;275(20):1089–1092. DOI: <a href="https://doi.org/10.1056/NEJM196611172752002" target="_blank" rel="noopener noreferrer">10.1056/NEJM196611172752002</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/5923023/" target="_blank" rel="noopener noreferrer">PubMed PMID 5923023</a>.</small></li>
  <li><small>Chytilova E, Jemcov T, Malik J, Pajek J, Fila B, Kavan J. Role of Doppler ultrasonography in the evaluation of hemodialysis arteriovenous access maturation and influencing factors. <em>J Vasc Access.</em> 2021;22(1_suppl):42–55. DOI: <a href="https://doi.org/10.1177/1129729820965064" target="_blank" rel="noopener noreferrer">10.1177/1129729820965064</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/34281411/" target="_blank" rel="noopener noreferrer">PubMed PMID 34281411</a>.</small></li>
  <li><small>Horst VD, Nelson PR, Mallios A, Kempe K, Pandit V, Kim H, Jennings WC. Avoiding hemodialysis access-induced distal ischemia. <em>J Vasc Access.</em> 2021;22(5):786–794. DOI: <a href="https://doi.org/10.1177/1129729820943464" target="_blank" rel="noopener noreferrer">10.1177/1129729820943464</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32715859/" target="_blank" rel="noopener noreferrer">PubMed PMID 32715859</a>.</small></li>
  <li><small>Gerrickens MWM, Yadav R, Wouda R, Beerenhout CH, Scheltinga MRM. Severe hemodialysis access-induced distal ischemia may be associated with poor survival. <em>J Vasc Access.</em> 2021;22(2):194–202. DOI: <a href="https://doi.org/10.1177/1129729820933456" target="_blank" rel="noopener noreferrer">10.1177/1129729820933456</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32588720/" target="_blank" rel="noopener noreferrer">PubMed PMID 32588720</a>.</small></li>
  <li><small>Lok CE, Rajan DK, Clement J, Kiaii M, Sidhu R, Thomson K, Buldo G, Dipchand C, Moist L, Sasal J; NEAT Investigators. Endovascular Proximal Forearm Arteriovenous Fistula for Hemodialysis Access: Results of the Prospective, Multicenter Novel Endovascular Access Trial (NEAT). <em>Am J Kidney Dis.</em> 2017;70(4):486–497. DOI: <a href="https://doi.org/10.1053/j.ajkd.2017.03.026" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2017.03.026</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28624422/" target="_blank" rel="noopener noreferrer">PubMed PMID 28624422</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>V predlohe bol opravený nesprávne priradený zdroj: uvedené PMCID nevedie na prehľad o ischémii končatiny vyvolanej prístupom, ale na prehľad o úlohe dopplerovskej ultrasonografie pri dozrievaní prístupu – ten je v článku citovaný na mieste, kam patrí, a doplnený o údaj o 20 – 54 % podiele obštrukcie a nedozretia na primárnom zlyhaní fistuly. Konkrétne percentuálne rozpätia výskytu HAIDI, ktoré predloha uvádzala, sa z dostupných zdrojov nepodarilo potvrdiť, preto článok uvádza riziko kvalitatívne podľa typu a lokalizácie prístupu a dopĺňa ho prácami o prevencii a o prognostickom význame ťažkej formy. Autor projektu doplnil chýbajúce primárne zdroje – pôvodnú prácu o natívnej fistule z roku 1966, štúdiu NEAT a odporúčanie KDOQI s úplným autorským zoznamom – a rozbor rizika stenózy centrálnej žily ako dôsledku skorého zavedenia katétra. Všetky bibliografické údaje boli overené cez PubMed eutils a prevodník PMCID.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Načasovanie cievneho prístupu pred začatím hemodialýzy</a></li>
  <li><a href="article.php?slug=cievny-pristup-nemozny-avf-avg-planovanie-dialyzy">Keď cievny prístup nie je možný: plánovanie dialýzy</a></li>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cievne-pristupy-hemodialyza-historia-life-plan_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
