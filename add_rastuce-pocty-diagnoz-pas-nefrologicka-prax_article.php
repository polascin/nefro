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
    'title' => 'Prečo pribúdajú diagnózy autizmu a čo s tým má spoločné nefrológia',
    'slug' => 'rastuce-pocty-diagnoz-pas-nefrologicka-prax',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Diagnostická miera PAS v USA stúpla medzi rokmi 2011 a 2022 o 175 %. Rozbor príčin, hranice skríningu a praktické dôsledky pre nefrologickú starostlivosť o pacienta s poruchou autistického spektra.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/rastuce-pocty-diagnoz-pas-nefrologicka-prax.webp" type="image/webp">
    <img src="img/rastuce-pocty-diagnoz-pas-nefrologicka-prax.png" alt="Poloschematická scéna: rozširujúci sa kužeľ svetla osvetľuje čoraz väčšiu časť rovnomerného poľa bodov, popri ňom stúpa krivka; vľavo dole obrys obličky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Pole bodov zostáva rovnako husté – mení sa len to, akú jeho časť kužeľ rozpoznania osvetlí.</figcaption>
</figure>

<p>Správy o „epidémii autizmu“ sa opakujú v cykloch a zakaždým vyvolávajú rovnakú otázku: pribúda samotná porucha autistického spektra, alebo iba jej diagnózy? Rozdiel nie je akademický. Od odpovede závisí, či sa má zdravotníctvo sústrediť na hľadanie novej príčiny, alebo na zabezpečenie služieb pre rastúcu populáciu ľudí, ktorí tu boli celý čas.</p>

<p>Pre nefrológa má téma dva konkrétne dôsledky. Pacient s poruchou autistického spektra sa v ambulancii aj na lôžku správa inak, než predpokladá štandardný postup, a jeho ťažkosti sa ľahko pripíšu obličkovému ochoreniu. Zároveň platí, že dieťa s ochorením obličiek môže mať nerozpoznanú neurovývinovú poruchu, ktorá zmení celý priebeh vyšetrovania aj liečby.</p>

<h2>Čo presne stúplo</h2>

<p>Najlepší dostupný kvantitatívny podklad pochádza z prierezovej štúdie v sieti dvanástich amerických zdravotníckych systémov združených v Mental Health Research Network. Analyzovali sa elektronické zdravotné záznamy od 1. januára 2011 do 31. decembra 2022; v roku 2022 bolo v systémoch evidovaných 12 264 003 poistencov.</p>

<div class="table-responsive" role="region" aria-label="Zmena diagnostickej miery poruchy autistického spektra v USA medzi rokmi 2011 a 2022" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Skupina</th><th scope="col">Relatívny nárast 2011 – 2022</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Celá vzorka</th><td>175 % (z 2,3 na 6,3 na 1 000 osôb)</td></tr>
    <tr><th scope="row">Dospelí vo veku 26 – 34 rokov</th><td>450 %</td></tr>
    <tr><th scope="row">Dievčatá</th><td>305 %</td></tr>
    <tr><th scope="row">Chlapci</th><td>185 %</td></tr>
    <tr><th scope="row">Ženy (dospelé)</th><td>315 %</td></tr>
    <tr><th scope="row">Muži (dospelí)</th><td>215 %</td></tr>
  </tbody>
</table>
</div>

<p>Najvyššia diagnostická miera bola počas celého obdobia u detí vo veku 5 až 8 rokov. U detí boli relatívne nárasty vyššie v rasových a etnických menšinových skupinách než u bielych detí; u dospelých sa tento rozdiel nepotvrdil.</p>

<p>Dôležité je presné pomenovanie toho, čo sa meria. Ide o <strong>diagnostickú mieru</strong> – podiel ľudí, ktorí majú v zdravotnej dokumentácii kódovanú diagnózu. To nie je to isté ako prevalencia poruchy v populácii. Samotný rozdiel medzi týmito dvoma veličinami je jadrom celej diskusie.</p>

<h2>Čo nárast poháňa</h2>

<h3>Zmena diagnostickej praxe je kvantifikovateľná</h3>

<p>Retrospektívna analýza záznamov kalifornského Department of Developmental Services preskúmala 7 003 pacientov s autizmom narodených pred rokom 1987 a evidovaných v rokoch 1992 až 2005. V centre pozornosti bolo 631 pacientov, ktorí mali pôvodne iba diagnózu mentálnej retardácie a neskôr k nej pribudla diagnóza autizmu.</p>

<p>V rokoch, keď sa diagnostická prax menila, bola šanca na zmenu diagnózy významne vyššia (pomery šancí 1,68; 1,55; 1,58; 1,82 a 1,61). Autori odhadli, že <strong>26,4 % (95 % IS 16,25 – 36,48) nárastu počtu prípadov autizmu v Kalifornii</strong> súvisí výlučne so zmenou diagnostickej praxe, a to <em>jedinou cestou</em> – u ľudí, ktorí predtým mali diagnózu mentálnej retardácie.</p>

<p>Posledná veta sa pri citovaní často vynecháva, hoci je zásadná. Štvrtina nárastu sa vysvetlí jednou jedinou diagnostickou dráhou. Ostatné dráhy – zmena kritérií DSM, širšie povedomie, lepšia dostupnosť služieb, diagnostika v dospelosti – v tomto odhade nie sú vôbec zahrnuté. Skutočný podiel „zachytenia“ na celkovom náraste je teda s veľkou pravdepodobnosťou podstatne vyšší než 26 %.</p>

<h3>Zmena klasifikácie posunula hranicu diagnózy</h3>

<p>DSM-5 v roku 2013 zlúčil predchádzajúce samostatné kategórie – autistickú poruchu, Aspergerov syndróm, detskú dezintegratívnu poruchu a PDD-NOS – do jednej entity „porucha autistického spektra“. Keď sa zmení rámec, krivka diagnóz môže rásť bez toho, aby sa zmenil biologický výskyt čohokoľvek.</p>

<h3>Diagnóza sa stala žiadanou</h3>

<p>Zmenil sa aj spoločenský význam označenia. Autizmus kedysi platil za rozsudok a rodiny sa diagnóze bránili; dnes ju časť ľudí aktívne vyhľadáva. U detí preto, že otvára prístup k službám – ergoterapii, fyzioterapii, logopédii, behaviorálnej intervencii. U dospelých preto, že prináša komunitu a vysvetľujúci rámec pre vlastné ťažkosti. Tento posun pravdepodobne vysvetľuje značnú časť nárastu práve u dospelých.</p>

<h2>Diagnostika: žiadny test neexistuje</h2>

<p>Pre poruchu autistického spektra <strong>neexistuje medicínsky test</strong>. Diagnóza stojí na pozorovaní správania a na anamnéze – u dieťaťa od rodičov a učiteľov, u dospelého od neho samého a od okolia. Nejde o situáciu ako pri zápale stredného ucha alebo bakteriálnej infekcii, kde existuje jednoznačný laboratórny alebo zobrazovací nález.</p>

<p>Kľúčové prejavy sú základné prvky sociálneho správania: očný kontakt, mimika, držanie tela, intonácia a emočná reciprocita. Spektrum je však veľmi široké a prejavy sa menia v čase – dospelý ich zvládne kontrolovať podstatne lepšie než trojročné dieťa.</p>

<h2>Skríning a jeho hranice</h2>

<p>Americká akadémia pediatrov odporúča univerzálny skríning poruchy autistického spektra vo veku 18 a 24 mesiacov popri všeobecnom skríningu vývinových oneskorení. Skríning má zachytiť rizikové deti, nie stanoviť diagnózu; pri pozitívnom výsledku musí nasledovať klinické vyšetrenie.</p>

<p>Výpovedná hodnota skríningových nástrojov je však obmedzenejšia, než sa bežne predpokladá. Nórska štúdia v rámci kohorty Norwegian Mother and Child Cohort Study hodnotila <strong>68 197 detí, ktoré v 18 mesiacoch prešli skríningom M-CHAT ako negatívne</strong>. Časť z nich neskôr dostala diagnózu poruchy autistického spektra – a už v 18 mesiacoch mala merateľné oneskorenia v sociálnych, komunikačných a motorických schopnostiach. Skríningový nástroj ich teda nezachytil, hoci rozdiel bol prítomný.</p>

<p>Z praxe k tomu pribúda dôležité pozorovanie: najlepším jednotlivým prediktorom neskoršej diagnózy bol v tejto kohorte <strong>rodičovský nepokoj o vývin dieťaťa v jednom roku veku</strong> a otázka, či niekto iný už vyjadril obavu. Európska pediatria univerzálny skríning väčšinou nepoužíva práve pre slabosť dôkazov. Prakticky to znamená, že negatívny skríning nemá prebiť pretrvávajúcu obavu rodiča.</p>

<h2>Prečo téma patrí na nefrologický portál</h2>

<p>Prehľadová práca z detskej nefrológie zhŕňa, čo je a čo nie je známe. Existujú <strong>náznaky prekryvu medzi poruchou autistického spektra a ochoreniami obličiek</strong> na úrovni genetických variantov počtu kópií a environmentálnych faktorov, ktoré prispievajú k spoločnej patogenéze. Autori zároveň výslovne uvádzajú, že <strong>prevalencia poruchy autistického spektra u pacientov s ochorením obličiek nie je známa</strong>. Tvrdenia o sile tohto prepojenia treba preto formulovať opatrne.</p>

<p>Praktický záver je napriek tomu jednoznačný. Pri mladom pacientovi s ochorením obličiek, ktorý má komunikačné ťažkosti, úzkosť alebo správanie, ktoré kladie nároky na okolie, je namieste <strong>vysoká miera podozrenia</strong> a odoslanie na neurovývinové a behaviorálne vyšetrenie. Neurovývinové poruchy sú uznanou významnou asociáciou detských ochorení obličiek a dysfunkcie močového mechúra.</p>

<p>Riziko, ktorého sa treba vyvarovať, je diagnostické zatienenie: príznaky sa automaticky pripíšu urémii, anémii, dialýze alebo imunosupresii a neurovývinová porucha zostane nerozpoznaná. Platí aj opak – poruchu autistického spektra môže odhaliť až zmena prostredia, ktorú prináša nová diagnóza: hospitalizácia, pravidelná dialýza, príprava na transplantáciu.</p>

<h2>Praktické úpravy v nefrologickej starostlivosti</h2>

<ol>
  <li><strong>Zistiť spôsob komunikácie pacienta.</strong> Verbálna či neverbálna, potreba vizuálnej podpory, zrozumiteľnosť abstraktných pokynov.</li>
  <li><strong>Pripraviť pacienta vopred.</strong> Pred odberom, zobrazovacím vyšetrením aj pred hospitalizáciou – vrátane toho, čo sa bude diať a v akom poradí.</li>
  <li><strong>Rozložiť vyšetrenie na zvládnuteľné kroky</strong> a určiť, kto ich vysvetľuje a akým spôsobom.</li>
  <li><strong>Zohľadniť senzorické citlivosti.</strong> Hluk, osvetlenie, dotyk, zápach dezinfekcie, potreba osobného priestoru – na dialyzačnom sále ide o kumuláciu všetkých naraz.</li>
  <li><strong>Použiť časové a vizuálne štruktúry.</strong> Harmonogramy, ukazovatele času, prístupy typu „najprv – potom“.</li>
  <li><strong>Identifikovať spúšťače tiesne</strong> a mať dohodnutú behaviorálnu stratégiu skôr, než nastane krízová situácia pri venepunkcii alebo napojení na mimotelový obeh.</li>
</ol>

<p>Tieto úpravy nie sú ústupkom. Rozhodujú o tom, či sa vyšetrenie vôbec podarí vykonať, a znižujú potrebu sedácie alebo obmedzenia pacienta.</p>

<h2>Limity</h2>

<ul>
  <li><strong>Údaje o nárastu diagnóz pochádzajú z USA.</strong> Americké poistné a zdravotnícke prostredie nie je prenositeľné na slovenské; absolútne hodnoty sa použiť nedajú.</li>
  <li><strong>Diagnostická miera nie je prevalencia.</strong> Analýza zdravotných záznamov nemôže rozlíšiť, nakoľko sa mení skutočný výskyt a nakoľko zachytenie.</li>
  <li><strong>Odhad 26,4 % pokrýva jedinú diagnostickú dráhu</strong> v jednom americkom štáte v rokoch 1992 až 2005. Nejde o celkový podiel „umelého“ nárastu.</li>
  <li><strong>Prevalencia poruchy autistického spektra v populácii pacientov s ochorením obličiek nie je známa.</strong> Údaje o prekryve sú opisované ako vznikajúce, nie ako potvrdené.</li>
  <li><strong>Odporúčania pre praktické úpravy starostlivosti</strong> vychádzajú z odbornej zhody a klinickej skúsenosti, nie z randomizovaných štúdií.</li>
</ul>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odborné odporúčania. Diagnostiku poruchy autistického spektra vykonáva príslušný špecialista.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Grosvenor LP, Croen LA, Lynch FL, Marafino BJ, Maye M, Penfold RB, Simon GE, Ames JL. Autism Diagnosis Among US Children and Adults, 2011-2022. <em>JAMA Netw Open.</em> 2024;7(10):e2442218. DOI: <a href="https://doi.org/10.1001/jamanetworkopen.2024.42218" target="_blank" rel="noopener noreferrer">10.1001/jamanetworkopen.2024.42218</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39476234/" target="_blank" rel="noopener noreferrer">PubMed PMID 39476234</a>.</small></li>
  <li><small>King M, Bearman P. Diagnostic change and the increased prevalence of autism. <em>Int J Epidemiol.</em> 2009;38(5):1224–1234. DOI: <a href="https://doi.org/10.1093/ije/dyp261" target="_blank" rel="noopener noreferrer">10.1093/ije/dyp261</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/19737791/" target="_blank" rel="noopener noreferrer">PubMed PMID 19737791</a>.</small></li>
  <li><small>Clothier J, Absoud M. Autism spectrum disorder and kidney disease. <em>Pediatr Nephrol.</em> 2021;36(10):2987–2995. DOI: <a href="https://doi.org/10.1007/s00467-020-04875-y" target="_blank" rel="noopener noreferrer">10.1007/s00467-020-04875-y</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33340339/" target="_blank" rel="noopener noreferrer">PubMed PMID 33340339</a>.</small></li>
  <li><small>Hyman SL, Levy SE, Myers SM; Council on Children With Disabilities, Section on Developmental and Behavioral Pediatrics. Identification, Evaluation, and Management of Children With Autism Spectrum Disorder. <em>Pediatrics.</em> 2020;145(1):e20193447. DOI: <a href="https://doi.org/10.1542/peds.2019-3447" target="_blank" rel="noopener noreferrer">10.1542/peds.2019-3447</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31843864/" target="_blank" rel="noopener noreferrer">PubMed PMID 31843864</a>.</small></li>
  <li><small>Øien RA, Schjølberg S, Volkmar FR, Shic F, Cicchetti DV, Nordahl-Hansen A, Stenberg N, Hornig M, Havdahl A, Øyen AS, Ventola P, Susser ES, Eisemann MR, Chawarska K. Clinical Features of Children With Autism Who Passed 18-Month Screening. <em>Pediatrics.</em> 2018;141(6):e20173596. DOI: <a href="https://doi.org/10.1542/peds.2017-3596" target="_blank" rel="noopener noreferrer">10.1542/peds.2017-3596</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/29784756/" target="_blank" rel="noopener noreferrer">PubMed PMID 29784756</a>.</small></li>
  <li><small>King BH, Navot N, Bernier R, Webb SJ. Update on diagnostic classification in autism. <em>Curr Opin Psychiatry.</em> 2014;27(2):105–109. DOI: <a href="https://doi.org/10.1097/YCO.0000000000000040" target="_blank" rel="noopener noreferrer">10.1097/YCO.0000000000000040</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/24441420/" target="_blank" rel="noopener noreferrer">PubMed PMID 24441420</a>.</small></li>
  <li><small>Strakowski SM, Lord C, Volkmar FR. Autism Diagnoses Are Rising. What's Driving the Increase? <em>Medscape Psychiatry</em>, 5. októbra 2026. <a href="https://www.medscape.com/viewarticle/autism-diagnoses-are-rising-whats-driving-increase-2026a10010mn" target="_blank" rel="noopener noreferrer">dostupné online</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>V predlohe bol opravený nesprávny identifikátor zdroja: uvedené PMCID viedlo na prehľad prevalencie autizmu siete ADDM v <em>MMWR Surveillance Summaries</em>, nie na prehľad o autizme a ochoreniach obličiek – ten vyšiel v <em>Pediatric Nephrology</em> 2021 (Clothier J, Absoud M). Doplnené boli chýbajúce autorské mená pri dvoch zdrojoch (King M, Bearman P; úplný zoznam autorov štúdie JAMA Network Open) a konkrétne percentuálne hodnoty nárastu podľa veku a pohlavia. Doplnené bolo aj upozornenie, že prevalencia poruchy autistického spektra u pacientov s ochorením obličiek nie je známa, a oddiel o hraniciach skríningu vrátane nórskej kohortovej štúdie – ten v predlohe chýbal, hoci skríning bol prezentovaný bez výhrad. Všetky bibliografické údaje boli overené cez PubMed eutils, Crossref a prevodník PMCID.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=psychicka-tiesen-dusevna-porucha-nefrologia">Psychická tieseň a duševná porucha v nefrológii</a></li>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Spoločné rozhodovanie o náhrade funkcie obličiek</a></li>
  <li><a href="article.php?slug=claudiny-nefrolitiaza-geneticke-asociacie">Klaudíny a nefrolitiáza: genetické asociácie</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rastuce-pocty-diagnoz-pas-nefrologicka-prax_article',
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
