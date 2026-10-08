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
    'title' => 'Infekcie močových ciest u detí: kratšia liečba a presnejšia diagnostika',
    'slug' => 'infekcie-mocovych-ciest-deti-kratsia-liecba-diagnostika',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Odporúčanie AAP z roku 2026 podporuje najviac sedemdňovú antibiotickú liečbu u väčšiny malých detí s IMC. Bezpečné skrátenie však závisí od veku, diagnózy a rizika komplikácií.',
    'content' => <<<'HTML'
<p>Aktualizované odporúčanie Americkej pediatrickej akadémie (AAP) mení diagnostiku a liečbu infekcií močových ciest u detí vo veku od 8 dní do 5 rokov. U väčšiny detí podporuje antibiotickú liečbu trvajúcu najviac sedem dní. Nejde však o plošné pravidlo. Dĺžka a spôsob liečby závisia od veku, klinického obrazu, predpokladaného miesta infekcie, bakteriémie, anatomických pomerov a odpovede na liečbu. [1]</p>

<p>Odporúčanie je určené najmä deťom s nízkou medicínskou komplexnosťou. Nevzťahuje sa priamo na deti s neurogénnym močovým mechúrom, imunokompromitáciou, extrémnou prematuritou, známymi vrodenými chybami obličiek a močových ciest ani s iným závažným chronickým ochorením. Tie vyžadujú individuálny a spravidla špecializovaný postup. [1]</p>

<figure>
  <picture>
    <source srcset="img/infekcie-mocovych-ciest-deti-kratsia-liecba-diagnostika.webp" type="image/webp">
    <img src="img/infekcie-mocovych-ciest-deti-kratsia-liecba-diagnostika.png" alt="Dieťa pri pediatrickom vyšetrení s ilustračným zobrazením obličiek, močovodov a močového mechúra a symbolom kratšej antibiotickej liečby" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Kratšia antibiotická liečba je bezpečnou možnosťou iba po správnom potvrdení infekcie, posúdení závažnosti a výbere režimu zodpovedajúceho veku a riziku dieťaťa. Ilustračné zobrazenie.</figcaption>
</figure>

<h2>Čo presne znamená kratšia liečba</h2>

<p>AAP podmienečne odporúča pri potvrdenej infekcii močových ciest liečbu trvajúcu najviac sedem dní namiesto dlhšej liečby. Istota dôkazov je nízka. Konkrétne trvanie spresňuje podľa klinickej skupiny: [1]</p>

<div class="table-responsive" role="region" aria-label="Odporúčané trvanie antibiotickej liečby infekcie močových ciest u detí" tabindex="0">
<table>
  <thead><tr><th scope="col">Klinická skupina</th><th scope="col">Trvanie podľa AAP</th><th scope="col">Podstatná podmienka</th></tr></thead>
  <tbody>
    <tr><th scope="row">Deti vo veku od 2 do 5 rokov s nefebrilnou cystitídou</th><td>3 až 5 dní</td><td>Bez známej anatomickej abnormality močových ciest; prítomné typické príznaky dolných močových ciest</td></tr>
    <tr><th scope="row">Deti vo veku od 2 do 24 mesiacov</th><td>5 až 7 dní</td><td>Potvrdená infekcia močových ciest</td></tr>
    <tr><th scope="row">Deti vo veku od 2 do 5 rokov s príznakmi pyelonefritídy</th><td>5 až 7 dní</td><td>Bez známej anatomickej abnormality močových ciest</td></tr>
    <tr><th scope="row">Dojčatá vo veku od 8 dní do 2 mesiacov alebo deti s vyšším rizikom</th><td>Môže byť potrebných viac ako 7 dní</td><td>Anatomická abnormalita, bakteriémia alebo nedostatočná klinická odpoveď patria medzi dôvody na dlhší režim</td></tr>
  </tbody>
</table>
</div>

<p>Trojdňový až päťdňový režim sa teda netýka každej detskej infekcie močových ciest. Je určený deťom od dvoch rokov s nízkym rizikom, nefebrilným priebehom a príznakmi cystitídy, ako sú dyzúria, časté močenie, urgencia alebo novovzniknutá inkontinencia. Pri febrilnej infekcii alebo pravdepodobnej pyelonefritíde AAP odporúča v tejto vekovej skupine päť až sedem dní. [1]</p>

<p>Odporúčanie neurčuje jeden antibiotický liek pre všetky situácie. Empirický výber má zohľadniť vek dieťaťa, závažnosť stavu, miesto infekcie, lokálnu rezistenciu a predchádzajúce mikrobiologické nálezy. Po získaní kultivácie sa má liečba prispôsobiť citlivosti izolovaného uropatogénu. Skrátenie neúčinného alebo nevhodne zvoleného režimu nie je zodpovedným používaním antibiotík.</p>

<h2>Perorálna liečba má širšie miesto</h2>

<p>U detí starších ako 28 dní a mladších ako 5 rokov AAP silno odporúča perorálne antibiotiká namiesto parenterálnej alebo sekvenčnej liečby vyžadujúcej hospitalizáciu. Istota dôkazov je však veľmi nízka. Odporúčanie sa týka detí, ktoré nie sú kriticky choré, nemajú pridruženú bakteriémiu a dokážu perorálny liek prijať a udržať. [1]</p>

<p>U dojčiat vo veku od 8 do 28 dní panel podmienečne odporúča začať parenterálnu liečbu a po klinickom zlepšení včas prejsť na perorálnu. To nemožno interpretovať ako podporu ambulantného začatia liečby novorodenca bez zodpovedajúceho vyšetrenia. [1]</p>

<h2>Diagnóza nie je iba pozitívna kultivácia</h2>

<p>Technický report AAP definuje infekciu pomocou kombinácie zápalového nálezu v moči, rastu jedného uropatogénu a spôsobu odberu. Pozitívna kultivácia sama osebe môže predstavovať skutočnú infekciu, asymptomatickú bakteriúriu alebo kontamináciu. [2]</p>

<p>Po dostupnosti kultivácie podporuje vysokú pravdepodobnosť infekcie u dojčiat mladších ako dva mesiace nález najmenej 5 leukocytov v zornom poli pri veľkom zväčšení alebo aspoň stopovej leukocytovej esterázy. U detí od dvoch mesiacov do piatich rokov je hranicou najmenej 5 leukocytov v zornom poli alebo leukocytová esteráza najmenej 1+. Súčasne sa vyžaduje rast jedného patogénu najmenej 10 000 CFU/ml z katetrizovaného moču alebo suprapubickej aspirácie, prípadne najmenej 100 000 CFU/ml zo správne odobratého stredného prúdu moču. [2]</p>

<p>Pred dostupnosťou kultivácie používa AAP pri rozhodovaní o pravdepodobnej infekcii citlivejšie vekovo špecifické prahy. U detí od dvoch mesiacov ide o najmenej 10 leukocytov v zornom poli alebo leukocytovú esterázu 2+. Výsledok treba interpretovať spolu s klinickou pravdepodobnosťou a technikou laboratórneho vyšetrenia. [2]</p>

<p>Moč zo zberného vrecka sa nemá používať na kultivačné potvrdenie infekcie u dieťaťa, ktoré nedokáže poskytnúť čistý stredný prúd. Negatívny skríningový nález môže pomôcť vyhnúť sa katetrizácii, pozitívny nález z vrecka však vyžaduje vhodne odobratú vzorku na kultiváciu. [2]</p>

<h2>Vyšetrenie do 72 hodín nie je pokyn čakať</h2>

<p>U medicínsky nekomplexných detí vo veku od 2 do 24 mesiacov s horúčkou bez známeho zdroja a u detí od 2 do 5 rokov s príznakmi infekcie močových ciest AAP podmienečne odporúča lekárske vyšetrenie do 72 hodín od začiatku príznakov namiesto dlhšieho pozorovania. Istota dôkazov je nízka. [1]</p>

<p>Tento časový rámec neznamená, že je bezpečné tri dni vyčkávať pri závažnom stave. Vyšetrenie treba urýchliť pri známej urologickej abnormalite, predchádzajúcej febrilnej infekcii, bolesti v boku alebo iných príznakoch pyelonefritídy. Novorodenec s horúčkou, dieťa s poruchou vedomia, výraznou apatiou, nedostatočným príjmom tekutín, obehovou nestabilitou alebo podozrením na sepsu potrebuje bezodkladné posúdenie.</p>

<h2>Zobrazovanie po febrilnej infekcii</h2>

<p>Po prvej febrilnej infekcii močových ciest u dieťaťa mladšieho ako päť rokov AAP silno odporúča ultrasonografiu obličiek a močového mechúra. Cieľom je zistiť štruktúrne abnormality alebo nálezy spojené s vezikoureterovým refluxom, nie reflux samotný. Istota dôkazov o klinickom vplyve zistených abnormalít je nízka. [1]</p>

<p>Pri normálnom ultrasonografickom náleze sa po prvej febrilnej infekcii rutinná mikčná cystouretrografia neodporúča. Ďalší postup sa mení pri abnormálnej ultrasonografii, recidivujúcej febrilnej infekcii alebo iných rizikových okolnostiach. Ani zobrazovacie odporúčania preto nemožno oddeliť od konkrétnej anamnézy a nálezov. [1]</p>

<h2>Zápcha a dysfunkcia močového mechúra a čreva</h2>

<p>AAP označuje dysfunkciu močového mechúra a čreva vrátane zápchy za významný rizikový faktor recidív. U dieťaťa s infekciou odporúča cielene hodnotiť a liečiť poruchy močenia a vyprázdňovania. Anamnéza má podľa veku zahŕňať frekvenciu močenia, urgenciu, inkontinenciu, zadržiavacie manévre, slabý alebo prerušovaný prúd moču, pocit neúplného vyprázdnenia, frekvenciu a konzistenciu stolice aj bolestivé vyprázdňovanie. [1]</p>

<p>Samotná liečba zápchy nemusí odstrániť všetky poruchy dolných močových ciest. Pri recidivujúcich infekciách, vezikoureterovom refluxe, významnom rezíduu po močení alebo nedostatočnej odpovedi na režimové opatrenia je vhodné zvážiť pediatrickú nefrologickú alebo urologickú konzultáciu. [1]</p>

<h2>Rasa nie je biologický diagnostický parameter</h2>

<p>Nové odporúčanie nepoužíva rasovú kategóriu na rozhodovanie, či dieťa vyšetriť na infekciu močových ciest. Predchádzajúce odporúčanie z roku 2011, ktoré rasu zahŕňalo do odhadu rizika, AAP vyradila. Aktuálny postup sa opiera o vek, klinické prejavy, individuálnu anamnézu a výsledky vyšetrení. [1]</p>

<h2>Ako silné sú dôkazy</h2>

<p>Odporúčanie vzniklo metódou GRADE a sprevádzajú ho tri technické reporty. Obsahuje osem kľúčových odporúčaní, z toho dve silné a šesť podmienečných, a štyri vyhlásenia správnej praxe. Istota dôkazov pri jednotlivých odporúčaniach siaha od nízkej po veľmi nízku. [1]</p>

<p>To je dôležité najmä pri dĺžke a spôsobe podávania antibiotík. Kratšie režimy sú rozumným smerovaním, ale presnosť odhadov a priama použiteľnosť dôkazov nie sú rovnaké vo všetkých vekových a rizikových skupinách. Silné odporúčanie perorálnej liečby pri veľmi nízkej istote dôkazov vyjadruje aj zohľadnenie nežiaducich účinkov hospitalizácie a parenterálnej liečby, uskutočniteľnosti a preferencií rodiny. Nie je to tvrdenie, že dôkazový podklad má vysokú istotu.</p>

<h2>Klinické posolstvo</h2>

<p>Najvýraznejšou zmenou nie je samotné číslo sedem. Odporúčanie prepája kratšiu antibiotickú expozíciu s presnejšou definíciou infekcie, vhodným odberom moču, včasným prehodnotením kultivácie, rozlíšením cystitídy od pyelonefritídy a aktívnym riešením faktorov recidívy.</p>

<p>V praxi treba oddeliť tri rozhodnutia: či dieťa infekciu skutočne má, ktorý liek a spôsob podania zodpovedajú jeho stavu a aké trvanie je dostatočné pre jeho vek a riziko. Odporúčanie nemožno automaticky prenášať na medicínsky komplexné deti, príjemcov transplantovanej obličky ani pacientov s významnou poruchou funkcie obličiek alebo komplexnou urologickou anamnézou.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Brian K. Alverson, David S. Hains, Stephen M. Downs, Rana E. El Feghaly, Catherine S. Forster, Shabnam Jain, Andrea Johnston, Tej K. Mattoo, Caleb P. Nelson, Olusoji Olakanpo, Hansel J. Otero, Craig A. Peters, Nicole M. Poppinga, Dipanwita Saha, Alan R. Schroeder, Emily Senerth, Lauren Pilcher, Susan K. Flinn, Rebecca L. Morgan, Reem A. Mustafa. Clinical Practice Guideline for the Diagnosis and Treatment of Urinary Tract Infection in Children From 8 Days to 5 Years of Age. <em>Pediatrics.</em> 2026;158(4):e2026078565. DOI: <a href="https://doi.org/10.1542/peds.2026-078565" target="_blank" rel="noopener noreferrer">10.1542/peds.2026-078565</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42803578/" target="_blank" rel="noopener noreferrer">PubMed PMID 42803578</a>. <a href="https://publications.aap.org/pediatrics/article/158/4/e2026078565/209460/Clinical-Practice-Guideline-for-the-Diagnosis-and" target="_blank" rel="noopener noreferrer">Úplné odporúčanie AAP</a>.</em></small></p>
<p><small><em>[2] Catherine S. Forster, Caleb Nelson, Rana El Feghaly, David S. Hains, Jamil Nazzal, Emily Senerth, Reem A. Mustafa, Rebecca L. Morgan, Brian Alverson, AAP Guideline Panel on Diagnosis and Management of UTI. Urinary Tract Infection Diagnosis: A Companion to the American Academy of Pediatrics’ 2026 Clinical Practice Guideline on the Diagnosis and Management of Urinary Tract Infection: Technical Report. <em>Pediatrics.</em> 2026;158(4):e2026078566. DOI: <a href="https://doi.org/10.1542/peds.2026-078566" target="_blank" rel="noopener noreferrer">10.1542/peds.2026-078566</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42803592/" target="_blank" rel="noopener noreferrer">PubMed PMID 42803592</a>. <a href="https://publications.aap.org/pediatrics/article/158/4/e2026078566/209462/Urinary-Tract-Infection-Diagnosis-A-Companion-to" target="_blank" rel="noopener noreferrer">Úplný technický report AAP</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_infekcie-mocovych-ciest-deti-kratsia-liecba-diagnostika_article',
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
