<?php
/**
 * Odborne a jazykovo revidovaný článok o alopurinole pri chronickej chorobe
 * obličiek a asymptomatickej hyperurikémii. Spracovaný editoriál z Brazilian
 * Journal of Nephrology; pôvodní autori sú uvedení v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Alopurinol pri chronickej chorobe obličiek: prečo randomizované štúdie a retrospektívne dáta hovoria opačne',
    'slug'         => 'alopurinol-ckd-asymptomaticka-hyperurikemia-dokazy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dve veľké randomizované štúdie nepreukázali, že alopurinol spomalí pokles eGFR. Retrospektívna kohorta pritom hlási vzostup filtrácie o 12 ml/min. Rozbor toho, prečo je rozpor zdanlivý a ktorý výsledok platí.',
    'content'      => <<<'HTML'
<p>Kyselina močová je pri chronickej chorobe obličiek (CKD) lákavý terapeutický cieľ. Urát poškodzuje endotel, aktivuje renín-angiotenzínový systém, podieľa sa na arteriolopatii aferentnej arterioly a jeho hladina stúpa už v skorých štádiách CKD. Hypotéza, že jeho zníženie spomalí progresiu, je preto biologicky vierohodná a merateľný cieľ liečby je k dispozícii.</p>

<p>Klinické dôkazy však hovoria inak. Editoriál publikovaný v <em>Brazilian Journal of Nephrology</em> v roku 2026 túto nezhodu formuluje presne: dve veľké randomizované štúdie renoprotektívny účinok nepreukázali, no retrospektívna kohorta z rovnakého čísla časopisu opisuje zlepšenie funkcie obličiek. Práve tento rozpor stojí za rozbor, pretože sa v praxi opakuje pri každom biomarkeri, ktorý sa dá liečebne ovplyvniť.</p>

<h2>Čo ukázali randomizované štúdie</h2>

<div class="table-responsive" role="region" aria-label="Randomizované štúdie alopurinolu pri chronickej chorobe obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Populácia</th>
      <th scope="col">Hlavný ukazovateľ</th>
      <th scope="col">Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">CKD-FIX (2020)</th>
      <td>369 dospelých s CKD G3–G4 bez dny, s albuminúriou alebo poklesom eGFR ≥ 3 ml/min/1,73 m² za predchádzajúci rok; priemerná eGFR 31,7; priemerný urát 8,2 mg/dl (približne 488 µmol/l)</td>
      <td>Zmena eGFR za 104 týždňov</td>
      <td>−3,33 (95 % IS −4,11 až −2,55) oproti −3,23 (−3,98 až −2,47) ml/min/1,73 m² za rok; rozdiel −0,10 (−1,18 až 0,97); p = 0,85. Závažné nežiaduce udalosti 46 % oproti 44 %.</td>
    </tr>
    <tr>
      <th scope="row">PERL (2020)</th>
      <td>530 dospelých s diabetom 1. typu a skorou až stredne pokročilou diabetickou chorobou obličiek</td>
      <td>Iohexolom meraná GFR po 3 rokoch a dvojmesačnom vymývaní</td>
      <td>Rozdiel medzi skupinami 0,001 ml/min/1,73 m² (−1,9 až 1,9); p = 0,99. Ročný pokles −3,0 oproti −2,5 (rozdiel −0,6; −1,5 až 0,4). Vylučovanie albumínu bolo pri alopurinole o <strong>40 %</strong> (0 až 80) <strong>vyššie</strong>.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Dve poznámky, ktoré sa pri citovaní týchto štúdií často vynechávajú. Po prvé, <strong>zníženie urátu sa v oboch podarilo</strong> – v štúdii PERL klesol z 6,1 na 3,9 mg/dl (približne 363 na 232 µmol/l), zatiaľ čo pri placebe zostal nezmenený. Nešlo teda o zlyhanie liečby, ale o zlyhanie hypotézy. Po druhé, PERL použila <strong>meranú</strong> GFR pomocou iohexolu, takže výsledok nemožno vysvetliť artefaktom odhadu z kreatinínu. Nález vyššieho vylučovania albumínu pri alopurinole je navyše presným opakom očakávaného renoprotektívneho účinku.</p>

<p>CKD-FIX bola predčasne ukončená pre pomalé nábery po zaradení 369 zo zamýšľaných 620 pacientov, čo znižuje jej silu. Interval spoľahlivosti rozdielu (−1,18 až 0,97) však vylučuje klinicky významný prínos v oboch smeroch, takže výsledok nie je iba „nepreukázané pre malý súbor“.</p>

<h2>Čo z toho urobili odporúčania</h2>

<p>KDIGO 2024 uvádza v odporúčaní 3.14.2 stanovisko so silou 2D: <em>navrhujeme nepoužívať látky znižujúce sérovú kyselinu močovú u osôb s CKD a asymptomatickou hyperurikémiou s cieľom spomaliť progresiu CKD</em>. Formulácia je zámerne úzka a stojí za povšimnutie, čo <strong>nezakazuje</strong>: liečbu symptomatickej dny, liečbu urátovej nefrolitiázy ani prevenciu syndrómu nádorového rozpadu. Neodporúčaná je konkrétne renoprotektívna indikácia pri asymptomatickej hyperurikémii.</p>

<h2>Retrospektívna kohorta, ktorá tvrdí opak</h2>

<p>Editoriál komentuje retrospektívnu kohortovú štúdiu z jedného špecializovaného pracoviska, ktorá čerpala zo zdravotnej dokumentácie z rokov 2006 až 2020. Zaradila <strong>80 pacientov</strong> s CKD G3–G4 a asymptomatickou hyperurikémiou, rozdelených na 40 liečených alopurinolom a 40 neliečených, so sledovaním 24 mesiacov a štyrmi kontrolami. Porovnávala sa priemerná hodnota urátu a eGFR podľa CKD-EPI, štatisticky analýzou rozptylu.</p>

<p>Výsledky sú pozoruhodné: v skupine s alopurinolom urát klesol pri každej kontrole a priemerná eGFR <strong>významne stúpla</strong> (p &lt; 0,001), zatiaľ čo v kontrolnej skupine sa funkcia zhoršovala. Do zlyhania obličiek počas 24 mesiacov neprešiel nikto z liečených oproti štyrom neliečeným pacientom.</p>

<h2>Prečo tento výsledok nemožno prijať ako dôkaz účinku</h2>

<ol>
  <li><strong>Veľkosť „účinku“ je fyziologicky nepravdepodobná.</strong> Vzostup priemernej eGFR z hodnôt okolo 35 na približne 47 ml/min/1,73 m² počas dvoch rokov nie je pri CKD G3–G4 obraz spomalenia progresie, ale obraz <em>uzdravenia</em>. Žiadna randomizovaná štúdia so žiadnym nefroprotektívnym liekom taký priemerný vzostup nedosiahla. Keď intervencia v observačných dátach prevýši všetko, čo dokázali randomizované štúdie, prvým podozrivým nie je liek, ale dizajn.</li>
  <li><strong>Zaraďovanie do liečby určoval ošetrujúci tím.</strong> Ide o učebnicové skreslenie indikáciou. Alopurinol dostal ten, u koho ho lekár považoval za vhodný – teda spravidla stabilnejší pacient s menším počtom kontraindikácií a lepšou spoluprácou.</li>
  <li><strong>Návrat k priemeru.</strong> Ak sa liečba začína po zachytení vyššej hodnoty urátu a horšej filtrácie, časť neskoršieho „zlepšenia“ vznikne aj bez akéhokoľvek zásahu – najmä ak bol pokles eGFR spôsobený prechodnou príčinou, ako je dehydratácia, nesteroidové antiflogistikum alebo dekompenzácia srdcového zlyhávania.</li>
  <li><strong>Analýza bez adjustácie.</strong> Použitá bola analýza rozptylu bez viacrozmerného modelu a bez zohľadnenia sklonu k liečbe. Rozdiely v krvnom tlaku, blokáde renín-angiotenzínového systému, kompenzácii diabetu, príjme bielkovín či užívaní diuretík zostali neošetrené.</li>
  <li><strong>Obdobie zberu 2006 – 2020.</strong> Ide takmer výlučne o éru pred inhibítormi SGLT2 a pred finerenónom. Skladba sprievodnej liečby v oboch skupinách nie je známa a práve tá dnes rozhoduje o priebehu CKD viac než urikémia.</li>
  <li><strong>Štyri príhody proti nule.</strong> Rozdiel v prechode do zlyhania obličiek stojí na štyroch udalostiach v štyridsaťčlennej skupine. Pri takom počte je odhad neistý bez ohľadu na hodnotu p.</li>
</ol>

<p>Nič z toho neznamená, že práca je bezcenná. Znamená to, že jej miesto je v generovaní hypotéz a v opise reálnej praxe, nie v zmene liečebného postupu. Editoriál k nej pristupuje rovnako opatrne.</p>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o alopurinole pri chronickej chorobe obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Urát poškodzuje endotel a prispieva k renálnej vaskulopatii</th>
      <td>Mechanisticky vierohodné</td>
      <td>Podporené experimentálnymi prácami; samo osebe nie je dôkazom klinického prínosu liečby.</td>
    </tr>
    <tr>
      <th scope="row">CKD-FIX a PERL nepreukázali spomalenie poklesu filtrácie</th>
      <td>Potvrdené</td>
      <td>Rozdiel −0,10 ml/min/1,73 m²/rok (p = 0,85), respektíve 0,001 ml/min/1,73 m² pri meranej GFR (p = 0,99).</td>
    </tr>
    <tr>
      <th scope="row">Alopurinol nedokázal znížiť urikémiu</th>
      <td>Nesprávne</td>
      <td>Urát klesol podľa očakávania. Neúspešná bola hypotéza o renoprotekcii, nie samotná liečba.</td>
    </tr>
    <tr>
      <th scope="row">KDIGO 2024 neodporúča urát znižovať na spomalenie progresie CKD</th>
      <td>Potvrdené</td>
      <td>Odporúčanie 3.14.2, sila 2D. Netýka sa dny, urátovej litiázy ani syndrómu nádorového rozpadu.</td>
    </tr>
    <tr>
      <th scope="row">Retrospektívna kohorta preukázala zlepšenie funkcie obličiek</th>
      <td>Nesprávne</td>
      <td>Preukázala rozdiel medzi skupinami, ktoré neboli porovnateľné. Zaraďovanie určoval lekár, analýza bola bez adjustácie a veľkosť zmeny je fyziologicky nepravdepodobná.</td>
    </tr>
    <tr>
      <th scope="row">Alopurinol nemá pri CKD miesto</th>
      <td>Nesprávne</td>
      <td>Má – pri dne, tofóznom ochorení a v ďalších indikáciách. Neodporúčaná je izolovaná renoprotektívna indikácia pri asymptomatickej hyperurikémii.</td>
    </tr>
    <tr>
      <th scope="row">Alopurinol je pri zníženej funkcii obličiek bezpečný liek bez zvláštností</th>
      <td>Nepresné</td>
      <td>Znížená filtrácia je rizikovým faktorom hypersenzitívneho syndrómu; dávkovanie sa začína nízko a titruje podľa cieľovej urikémie.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Kedy má alopurinol pri CKD miesto</h2>

<ul>
  <li><strong>Dna s opakovanými záchvatmi, tofmi alebo urátovou artropatiou.</strong> Tu je indikácia jednoznačná a CKD ju nespochybňuje – naopak, dna je pri CKD častejšia a horšie tolerovaná.</li>
  <li><strong>Urátová nefrolitiáza.</strong> Popri alkalizácii moču a príjme tekutín.</li>
  <li><strong>Prevencia syndrómu nádorového rozpadu</strong> podľa onkologického protokolu.</li>
  <li><strong>Asymptomatická hyperurikémia bez inej indikácie</strong> nie je dôvodom na liečbu s cieľom chrániť obličky.</li>
</ul>

<h2>Bezpečnosť pri zníženej funkcii obličiek</h2>

<p>Ak je indikácia daná, na dávkovaní záleží viac než pri normálnej funkcii obličiek:</p>

<ol>
  <li><strong>Začať nízkou dávkou a titrovať.</strong> Pri pokročilej CKD sa začína dávkou 50 mg denne alebo aj obdeň a zvyšuje sa postupne podľa dosiahnutej urikémie, nie podľa vopred určenej cieľovej dávky.</li>
  <li><strong>Cieľom je urikémia, nie dávka.</strong> Pri dne sa spravidla mieri pod 360 µmol/l (6 mg/dl), pri tofóznom ochorení nižšie.</li>
  <li><strong>Zvážiť vyšetrenie HLA-B*58:01</strong> u osôb juhovýchodoázijského alebo afrického pôvodu pred začatím liečby; alela výrazne zvyšuje riziko závažnej kožnej reakcie a CKD toto riziko ďalej zosilňuje.</li>
  <li><strong>Poznať interakcie.</strong> Súbežné podanie s azatioprínom alebo 6-merkaptopurínom je nebezpečné pre blokádu xantínoxidázy a hrozbu ťažkej myelosupresie.</li>
  <li><strong>Nepodceňovať oneskorenú reakciu.</strong> Hypersenzitívny syndróm sa môže prejaviť aj týždne po začatí a jeho renálnym obrazom býva granulomatózna intersticiálna nefritída.</li>
</ol>

<h2>Praktický záver</h2>

<p>Rozpor medzi randomizovanými štúdiami a retrospektívnou kohortou nie je odborným sporom – je to rozdiel v tom, čo jednotlivé dizajny dokážu ukázať. Pri asymptomatickej hyperurikémii a CKD zostáva platné, že <strong>znížením urátu obličky nechránime</strong>. Ak by mala prísť zmena, musí ju priniesť randomizovaná štúdia, nie väčšia retrospektívna kohorta.</p>

<p>Klinicky užitočnejším prekladom biologickej hypotézy je preto niečo iné: hyperurikémia pri CKD je <em>ukazovateľom</em> metabolického a hemodynamického zaťaženia. Rozumnou odpoveďou je hľadať a riešiť to, čo za ňou stojí – diuretickú liečbu, objemový stav, konzumáciu alkoholu, obezitu, kompenzáciu diabetu a nasadenie liečby s doloženým renálnym prínosom –, nie automaticky predpísať liek na samotné číslo.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=alopurinol-zivi-darcovia-oblicky-lvm-al-don">Alopurinol u živých darcov obličky znížil kyselinu močovú, no nezlepšil srdcovú štruktúru ani krvný tlak</a></li>
  <li><a href="article.php?slug=dress-alopurinol-granulomatozna-ain-pankreatitida">DRESS syndróm po alopurinole: diagnostická pasca granulomatóznej intersticiálnej nefritídy s pankreatitídou</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Vargas-Santos AB, Telles RW, Castelar-Pinheiro GR. Allopurinol in chronic kidney disease: navigating between pathophysiology, experimental evidence, and real-world challenges. <em>Brazilian Journal of Nephrology</em>. 2026;48(3):e2026E011. doi: 10.1590/2175-8239-JBN-2026-E011en. <a href="https://pubmed.ncbi.nlm.nih.gov/42599773/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Komentovaná pôvodná práca:</strong> Souza MELS, Heringer TA, Schneider APH, Possuelo LG, Valim ARM. Assessment of allopurinol use in patients with chronic kidney disease and asymptomatic hyperuricemia: a retrospective cohort study. <em>Brazilian Journal of Nephrology</em>. 2026;48(3):e20250243. doi: 10.1590/2175-8239-JBN-2025-0243en. <a href="https://pubmed.ncbi.nlm.nih.gov/42017921/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia CKD-FIX:</strong> Badve SV, Pascoe EM, Tiku A, et al. Effects of Allopurinol on the Progression of Chronic Kidney Disease. <em>New England Journal of Medicine</em>. 2020;382(26):2504–2513. doi: 10.1056/NEJMoa1915833. <a href="https://pubmed.ncbi.nlm.nih.gov/32579811/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia PERL:</strong> Doria A, Galecki AT, Spino C, et al. Serum Urate Lowering with Allopurinol and Kidney Function in Type 1 Diabetes. <em>New England Journal of Medicine</em>. 2020;382(26):2493–2503. doi: 10.1056/NEJMoa1916624. <a href="https://pubmed.ncbi.nlm.nih.gov/32579810/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Nefrologické odporúčanie:</strong> Kidney Disease: Improving Global Outcomes CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease (odporúčanie 3.14.2, sila 2D). <em>Kidney International</em>. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Odporúčanie k liečbe dny:</strong> FitzGerald JD, Dalbeth N, Mikuls T, et al. 2020 American College of Rheumatology Guideline for the Management of Gout. <em>Arthritis Care &amp; Research</em>. 2020;72(6):744–760. doi: 10.1002/acr.24180. <a href="https://pubmed.ncbi.nlm.nih.gov/32391934/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, autorské zoznamy aj číselné výsledky boli overené 23. augusta 2026 cez PubMed a Crossref. Editoriál vyšiel v portugalskej aj anglickej jazykovej verzii s odlišnými identifikátormi DOI; uvedený je identifikátor anglickej verzie. Prevody kyseliny močovej z mg/dl na µmol/l sú vlastným prepočtom (faktor 59,48).</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_alopurinol_ckd_asymptomaticka_hyperurikemia',
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
