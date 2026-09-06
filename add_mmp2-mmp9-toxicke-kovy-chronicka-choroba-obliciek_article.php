<?php

/**
 * add_mmp2-mmp9-toxicke-kovy-chronicka-choroba-obliciek_article.php
 * MMP-2, MMP-9, toxicke prvky a CKD - taiwanska pripadovo-kontrolna studia
 * (Chen a spol., Ecotoxicol Environ Saf 2026;309:119529, doi 10.1016/j.ecoenv.2025.119529).
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
    'title'        => 'Matrixové metaloproteinázy, toxické kovy a chronická choroba obličiek: silná asociácia bez dôkazu príčinnosti',
    'slug'         => 'mmp2-mmp9-toxicke-kovy-chronicka-choroba-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vyššie plazmatické MMP-2 a MMP-9 boli spojené s CKD s pomerom šancí 12,45 a 3,77. Prípadovo-kontrolný dizajn však neumožňuje určiť, či ide o príčinu alebo o následok zníženej funkcie obličiek.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pomer šancí 12,45 vyzerá ohromujúco. V prípadovo-kontrolnej štúdii, v ktorej sa marker aj ochorenie merali v ten istý deň, však toto číslo nehovorí o riziku vzniku ochorenia — hovorí o tom, ako dobre marker odlišuje chorých od zdravých. To je iná otázka a iná úroveň dôkazu.</em></p>

<p>Taiwanská prípadovo-kontrolná štúdia zistila výraznú asociáciu medzi vyššími plazmatickými koncentráciami matrixových metaloproteináz MMP-2 a MMP-9 a chronickou chorobou obličiek. Súvislosť bola výraznejšia pri súčasne zvýšených koncentráciách arzénu, kadmia alebo olova a pri nižšej koncentrácii selénu.</p>

<p>Výsledky podporujú hypotézu, že aktivita matrixových metaloproteináz a environmentálna expozícia nefrotoxickým prvkom môžu súvisieť s poškodením obličiek. Vzhľadom na prierezový prípadovo-kontrolný dizajn však <strong>nemožno určiť smer vzťahu</strong> ani preukázať, že zvýšené koncentrácie MMP alebo meraných prvkov spôsobili vznik chronickej choroby obličiek.</p>

<h2>Matrixové metaloproteinázy a obličková fibróza</h2>

<p>Matrixové metaloproteinázy (MMP) sú endopeptidázy závislé od zinku. Podieľajú sa na fyziologickej prestavbe extracelulárnej matrix, hojení, angiogenéze, zápalovej odpovedi a spracovaní biologicky aktívnych molekúl. MMP-2 (gelatináza A) štiepi najmä želatínu a kolagén typu IV; MMP-9 (gelatináza B) má podobné substráty, ale odlišnú reguláciu a bunkové zdroje.</p>

<p>Ich úloha pri fibróze obličiek <strong>nie je jednoducho profibrotická alebo antifibrotická</strong>. Degradácia extracelulárnej matrix môže podporovať jej odstraňovanie, ale nadmerná alebo nesprávne lokalizovaná aktivita MMP môže poškodzovať bazálne membrány, meniť bunkovú signalizáciu, podporovať zápal a uľahčovať patologickú prestavbu tkaniva.</p>

<p>Kľúčové obmedzenie interpretácie: koncentrácia MMP v plazme <strong>nie je meradlom aktivity MMP v obličkovom interstíciu</strong>. Výsledok môže odrážať systémový zápal, vaskulárne poškodenie, zmenený metabolizmus alebo klírens proteínov a ďalšie sprievodné procesy chronickej choroby obličiek.</p>

<h2>Skúmané environmentálne prvky</h2>

<p>Autori hodnotili expozíciu trom potenciálne nefrotoxickým prvkom (kadmium, olovo, arzén) a koncentráciu selénu. Označenie „ťažké kovy“ nie je pre celú skupinu chemicky presné — arzén je polokov a selén je esenciálny stopový prvok, ktorý môže byť pri nadmernej expozícii toxický. Autori si to uvedomujú a v práci výslovne definujú súhrnný pojem „kovy“ ako <em>kovy a polokovy</em>; v slovenskom texte je vhodnejšie hovoriť o environmentálne významných prvkoch.</p>

<h3>Kadmium</h3>

<p>Kadmium sa hromadí najmä v proximálnych tubuloch. Chronická expozícia môže viesť k tubulárnej dysfunkcii, nízkomolekulovej proteinúrii a postupnej strate funkcie obličiek; významnými zdrojmi sú tabakový dym, kontaminované potraviny a niektoré pracovné expozície. Interpretáciu komplikuje skutočnosť, že koncentrácie kadmia v krvi a moči môžu byť ovplyvnené samotnou funkciou obličiek.</p>

<h3>Olovo</h3>

<p>Olovo môže spôsobovať tubulointersticiálne poškodenie, oxidačný stres, endotelovú dysfunkciu a hypertenziu. Chronická choroba obličiek môže zároveň meniť distribúciu a vylučovanie olova a olovo uložené v kostiach sa môže pri zvýšenej kostnej resorpcii opätovne uvoľňovať do obehu.</p>

<h3>Arzén</h3>

<p>Anorganický arzén a jeho metylované metabolity môžu pôsobiť nefrotoxicky prostredníctvom oxidačného stresu, mitochondriálnej dysfunkcie, zápalu a poškodenia tubulárnych buniek. <strong>Celkový arzén v moči má obmedzenú špecificitu</strong> — po konzumácii morských živočíchov môže byť zvýšený najmä pre relatívne málo toxické organické zlúčeniny arzénu.</p>

<h3>Selén</h3>

<p>Selén je súčasťou antioxidačných selenoproteínov. Jeho nedostatok môže zvyšovať citlivosť na oxidačný stres, ale nadmerný príjem je toxický. Pozorovaná nepriama asociácia medzi plazmatickým selénom a CKD nie je dôkazom, že suplementácia selénom ochoreniu obličiek predchádza — nižšia koncentrácia môže byť následkom zápalu, malnutrície, proteinúrie alebo pokročilejšieho ochorenia.</p>

<h2>Usporiadanie štúdie</h2>

<p>Do štúdie uskutočnenej v dvoch nemocniciach v Tchaj-peji bolo zaradených <strong>215 pacientov s chronickou chorobou obličiek</strong> a <strong>389 kontrolných osôb</strong> zodpovedajúceho veku a pohlavia. Pacienti mali eGFR nižšiu ako 60 ml/min/1,73 m² počas viac ako troch mesiacov a nepotrebovali náhradu funkcie obličiek; eGFR sa vypočítala rovnicou MDRD. Kontrolnú skupinu tvorili osoby bez známej CKD s eGFR vyššou ako 60 ml/min/1,73 m².</p>

<p>Takáto definícia kontrol nie je postačujúca na vylúčenie chronickej choroby obličiek. Osoba s eGFR od 60 do 89 ml/min/1,73 m² môže mať CKD, ak sú prítomné albuminúria, štruktúrne poškodenie alebo iné markery trvajúce najmenej tri mesiace. <strong>Bez údajov o albuminúrii je možná nesprávna klasifikácia časti kontrol</strong> — čo by systematicky zväčšovalo pozorované rozdiely.</p>

<h3>Laboratórne metódy</h3>

<p>Plazmatické koncentrácie MMP-2 a MMP-9 sa stanovovali enzýmovou imunoanalýzou (ELISA). Plazmatický selén a koncentrácie kadmia a olova v krvi sa merali hmotnostnou spektrometriou s indukčne viazanou plazmou. Zlúčeniny arzénu v moči sa oddeľovali vysokoúčinnou kvapalinovou chromatografiou a kvantifikovali spektrometricky; celkový arzén v moči sa vyjadroval vo vzťahu ku koncentrácii kreatinínu v moči. Autori zároveň genotypizovali vybrané polymorfizmy génov MMP2 a MMP9.</p>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Asociácia plazmatických MMP s chronickou chorobou obličiek" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Marker</th>
        <th scope="col">Upravený pomer šancí</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">MMP-2</th><td>12,45</td><td>6,04 – 25,66</td></tr>
      <tr><th scope="row">MMP-9</th><td>3,77</td><td>2,14 – 6,66</td></tr>
    </tbody>
  </table>
</div>

<p>Plazmatické koncentrácie oboch metaloproteináz nepriamo korelovali s eGFR — vyššie hodnoty sa teda pozorovali u osôb s horšou funkciou obličiek.</p>

<p>Pomer šancí 12,45 <strong>neznamená dvanásťnásobné riziko vzniku ochorenia</strong>. Ide o porovnanie šancí na <em>prítomnosť</em> chronickej choroby obličiek v prípadovo-kontrolnom súbore, pričom pri častom výsledku nemožno pomer šancí interpretovať ani ako relatívne riziko. Interval spoľahlivosti siahajúci od 6 po 26 navyše ukazuje, že samotná veľkosť efektu je odhadnutá pomerne nepresne.</p>

<h2>Vzťah k arzénu, kadmiu, olovu a selénu</h2>

<p>Pacienti s chronickou chorobou obličiek mali v porovnaní s kontrolami vyššiu koncentráciu arzénu v moči, vyššie koncentrácie kadmia a olova v krvi a nižšiu koncentráciu selénu v plazme. Vyššia koncentrácia MMP-2 súvisela s vyšším arzénom v moči, kadmiom aj olovom v krvi; pri MMP-9 bola významná asociácia zistená najmä s kadmiom.</p>

<p>Autori identifikovali <strong>aditívne interakcie</strong> medzi vysokou koncentráciou MMP-2 a vyšším celkovým arzénom v moči, vyšším kadmiom v krvi, vyšším olovom v krvi, vyššou koncentráciou MMP-9 a nižšou koncentráciou selénu. <strong>Multiplikatívna interakcia</strong> sa zistila medzi vysokou koncentráciou MMP-2 a vyšším olovom v krvi.</p>

<h3>Čo znamená štatistická interakcia</h3>

<p>Štatistická interakcia znamená, že spoločná asociácia dvoch ukazovateľov s CKD sa odlišovala od asociácie očakávanej na základe ich samostatných účinkov. Aditívna a multiplikatívna interakcia sú matematicky rozdielne koncepty a ich prítomnosť <strong>automaticky nedokazuje biologickú synergiu</strong> ani to, že toxický prvok zvýšil expresiu MMP v obličkách. Formulácia „synergický toxický účinok“ by bola bez experimentálneho potvrdenia príliš silná.</p>

<p>Pri veľkom počte skúmaných biomarkerov, polymorfizmov, podskupín a interakcií navyše rastie pravdepodobnosť náhodne významných výsledkov. Význam má preto nezávislá replikácia.</p>

<h2>Genetické polymorfizmy</h2>

<p>Medzi skúmanými polymorfizmami génov MMP2 alebo MMP9 a chronickou chorobou obličiek sa <strong>nezistila</strong> významná asociácia. Negatívny výsledok nepreukazuje, že genetická regulácia MMP nemá pri chorobách obličiek význam — štúdia hodnotila iba vybrané časté varianty a mohla mať nedostatočnú štatistickú silu na zachytenie slabších účinkov, zriedkavých variantov alebo génovo-environmentálnych interakcií.</p>

<p>Tento nález je pritom pre interpretáciu celej práce dôležitý: ak by boli zvýšené koncentrácie MMP geneticky podmienenou <em>príčinou</em> ochorenia, dalo by sa očakávať aspoň slabé genetické signály. Ich absencia je skôr v súlade s predstavou, že zvýšené MMP sú <strong>sprievodným javom</strong> ochorenia.</p>

<h2>Najdôležitejšie metodologické obmedzenia</h2>

<h3>Nemožnosť určiť časovú následnosť</h3>

<p>MMP, environmentálne biomarkery a funkcia obličiek sa hodnotili v rovnakom období. Nie je známe, či zvýšené koncentrácie predchádzali poškodeniu obličiek, alebo vznikli až ako jeho následok.</p>

<h3>Spätná kauzalita</h3>

<p>Pokles glomerulovej filtrácie môže meniť klírens, distribúciu a koncentrácie MMP aj toxických prvkov. Vyššie hodnoty preto nemusia byť iba ukazovateľom expozície, ale môžu byť čiastočne <strong>dôsledkom</strong> samotnej chronickej choroby obličiek.</p>

<h3>Ďalšie obmedzenia</h3>

<ul>
  <li>Nemocničné kontroly nemusia reprezentovať všeobecnú populáciu.</li>
  <li>Jedno meranie nemusí zachytiť dlhodobú expozíciu ani biologickú variabilitu MMP; močový arzén odráža skôr nedávnu expozíciu.</li>
  <li>Normalizácia na kreatinín v moči koriguje zriedenie, ale pri CKD môže byť ovplyvnená svalovou hmotou, výživou a zmeneným vylučovaním kreatinínu — teda práve tým, čo odlišuje prípady od kontrol.</li>
  <li>Koncentráciu MMP-9 môžu ovplyvniť leukocyty, trombocyty, spôsob odberu, čas do centrifugácie, typ skúmavky a skladovanie vzorky.</li>
  <li>Štúdia sa uskutočnila v dvoch nemocniciach v Tchaj-peji; expozícia prvkom, genetické pozadie, strava a etiológia CKD sa v iných populáciách líšia.</li>
  <li>Diabetes, hypertenzia, fajčenie, užívanie analgetík, zápal, výživa a sociálno-ekonomické faktory môžu súčasne ovplyvňovať funkciu obličiek, koncentrácie MMP aj expozíciu — reziduálne skreslenie nemožno vylúčiť.</li>
</ul>

<h2>Klinický význam</h2>

<p>Výsledky zatiaľ nemenia diagnostiku ani liečbu chronickej choroby obličiek. Stanovenie plazmatických MMP-2 alebo MMP-9 nemožno na základe tejto štúdie odporučiť na skríning CKD, určovanie jej príčiny, predpovedanie individuálnej progresie, rozhodovanie o liečbe ani monitorovanie expozície toxickým prvkom.</p>

<p>Rovnako nie je odôvodnené rutinné stanovovanie kovov a polokovov u každého pacienta s CKD. Cielené vyšetrenie je primerané pri relevantnej pracovnej, environmentálnej, stravovacej alebo liekovej anamnéze — a práve <strong>anamnéza je v tejto oblasti hodnotnejším nástrojom než laboratórium</strong>.</p>

<p>Zistená inverzná asociácia so selénom nie je indikáciou na jeho nekontrolovanú suplementáciu. Selén má úzke rozmedzie medzi nedostatočným a nadmerným príjmom a nadbytok je toxický.</p>

<h2>Potrebný ďalší výskum</h2>

<ol>
  <li>prospektívne kohortové štúdie s meraním expozície pred poklesom eGFR,</li>
  <li>opakované merania MMP a environmentálnych biomarkerov,</li>
  <li>presná špeciácia arzénu a kontrola konzumácie morských potravín,</li>
  <li>hodnotenie albuminúrie, etiológie a štádia chronickej choroby obličiek,</li>
  <li>meranie tkanivovej expresie a enzymatickej aktivity MMP,</li>
  <li>experimentálne štúdie mechanizmov,</li>
  <li>nezávislá replikácia v geograficky a etnicky odlišných populáciách.</li>
</ol>

<h2>Záver</h2>

<p>Vyššie plazmatické koncentrácie MMP-2 a MMP-9 boli v taiwanskej prípadovo-kontrolnej štúdii výrazne spojené s prítomnosťou chronickej choroby obličiek. Asociácie boli silnejšie pri súčasne vyšších koncentráciách arzénu, kadmia alebo olova a pri nižšej koncentrácii selénu.</p>

<p>Štúdia prináša zaujímavú mechanistickú hypotézu, ale nepreukazuje, že environmentálna expozícia zvýšila aktivitu MMP a tým spôsobila fibrózu obličiek. Rovnako nemožno vylúčiť, že časť pozorovaných rozdielov bola následkom zníženej funkcie obličiek, sprievodných ochorení alebo metodiky merania.</p>

<p><strong>MMP-2 a MMP-9 preto zatiaľ treba považovať za výskumné biomarkery</strong>, nie za validované klinické ukazovatele alebo terapeutické ciele pri chronickej chorobe obličiek.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek</a> — širší kontext.</li>
  <li><a href="article.php?slug=uran-a-oblicky-nefrotoxicita-radiacne-poskodenie-kovy">Urán a obličky: nefrotoxicita a ťažké kovy</a>.</li>
  <li><a href="article.php?slug=ckdnt-pracovnici-horucava-texas-nejasna-etiologia">CKDnt u pracovníkov vystavených horúčave</a> — iná hypotéza environmentálnej etiológie.</li>
  <li><a href="article.php?slug=zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky">Zápal ako terapeutický cieľ pri CKD</a> — prečo biomarker nestačí.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Hsi-Hsien Chen, Chih-Yin Wu, Sheng-Lun Hsu, Horng-Sheng Shiue, Mei-Chieh Chen, Wei-Jen Chen, Yu-Mei Hsueh.</strong> <em>Interaction between plasma matrix metalloproteinases and arsenic, cadmium, lead, and selenium on chronic kidney disease.</em> Ecotoxicology and Environmental Safety. 2026;309:119529. <a href="https://doi.org/10.1016/j.ecoenv.2025.119529" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41353804/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Emily C. Moody, Steven G. Coca, Alison P. Sanders.</strong> <em>Toxic Metals and Chronic Kidney Disease: a Systematic Review of Recent Literature.</em> Current Environmental Health Reports. 2018;5(4):453–463. <a href="https://doi.org/10.1007/s40572-018-0212-1" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje — 215 pacientov s CKD a 389 vekovo a pohlavím zodpovedajúcich kontrol, upravený pomer šancí 12,45 (6,04 – 25,66) pre MMP-2 a 3,77 (2,14 – 6,66) pre MMP-9, absencia asociácie genotypov MMP2 a MMP9 s CKD, aditívne interakcie medzi vysokou MMP-2 a vyšším močovým arzénom, kadmiom, olovom alebo MMP-9 a nízkym selénom, ako aj multiplikatívna interakcia medzi MMP-2 a olovom — boli overené proti abstraktu v zázname PubMed. Bibliografia bola overená cez Crossref a PubMed; mená autorov sa v origináli uvádzajú so spojovníkmi (Hsi-Hsien Chen a podobne). Údaj, že pomery šancí porovnávajú najvyšší a najnižší tercil, ako aj podrobnosti o laboratórnych metódach a asociáciách s pohlavím, diabetom, hypertenziou či užívaním analgetík pochádzajú z plného textu, ktorý <strong>nebol nezávisle sprístupnený</strong>. Práca sama výslovne definuje súhrnný pojem „kovy“ ako kovy a polokovy — pripomienka k terminológii sa preto týka jej prekladu do slovenčiny, nie nepresnosti originálu. Argument, že absencia genetického signálu podporuje výklad zvýšených MMP ako sprievodného javu, a komentáre k spätnej kauzalite a ku korekcii na močový kreatinín sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_mmp2-mmp9-toxicke-kovy-chronicka-choroba-obliciek_article',
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
