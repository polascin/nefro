<?php

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
    'title'        => 'Budúcnosť dialýzy od domácej liečby po bioartificiálnu obličku',
    'slug'         => 'buducnost-dialyzy',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Domáca dialýza už dnes mení organizáciu liečby. Nositeľné prístroje a implantovateľné bioreaktory sú vo vývoji. Čo ukazujú klinické a predklinické štúdie?',
    'content'      => <<<'HTML'
<figure><img src="img/buducnost-dialyzy.webp" alt="Ilustračný dialyzačný prístroj pri kresle v domácom prostredí" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia domáceho prostredia na dialýzu vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Domáca peritoneálna dialýza a domáca hemodialýza môžu už dnes prispôsobiť liečbu dennému režimu pacienta. Nositeľné prístroje a implantovateľné bioartificiálne obličky riešia inú otázku: či možno liečbu predĺžiť, zmenšiť potrebné zariadenie a nahradiť aj niektoré funkcie obličiek, ktoré súčasná dialýza nepokrýva. Reportáž Ute Eppingerovej z tlačovej konferencie pri kongrese Nemeckej nefrologickej spoločnosti otvorila obe témy. Každá má inú úroveň klinických dôkazov [1].</p>

<h2>Domáca dialýza sa začína prípravou pacienta</h2>
<p>Domáca peritoneálna dialýza alebo hemodialýza môže obmedziť pravidelné dochádzanie do strediska a dať pacientovi väčšiu voľnosť pri plánovaní dňa. Výber závisí od klinického stavu, možností domáceho prostredia a od toho, akú časť starostlivosti chce a dokáže pacient prevziať. Pri plánovaní treba prebrať zaškolenie, dostupnosť pomoci, kontakt so strediskom pri komplikácii aj možnosti prechodu na inú metódu [1, 2].</p>
<p>Financovanie môže ovplyvniť, či strediská dokážu takúto prípravu a podporu zabezpečiť. V Nemecku sa v roku 2025 zaviedol príplatok pre poskytovateľov pri začatí prvej domácej dialýzy na prvých 52 týždňov. Pri položke GOP 40845 išlo o 96,50 eura za týždeň liečby. Od 1. januára 2026 sa suma zvýšila na 99,20 eura. Príklad ukazuje, ako možno financovať zavádzanie domácej liečby. Údaje o úhrade samy osebe nehovoria, či opatrenie zvýšilo počet pacientov liečených doma [1, 3, 4].</p>

<h2>Častejšia hemodialýza má prínosy aj náklady</h2>
<p>Kratšie prestávky medzi výkonmi môžu zmierniť výkyvy objemu tekutín a koncentrácií rozpustených látok. V randomizovanej štúdii FHN Daily porovnali u 245 pacientov hemodialýzu v stredisku šesťkrát a trikrát týždenne počas jedného roka. Výsledky pri častejšej dialýze boli priaznivejšie v oboch zložených ukazovateľoch. Jeden zahŕňal úmrtie alebo zmenu hmotnosti ľavej komory, druhý úmrtie alebo zmenu skóre telesného zdravia podľa pacienta. Zásahy na cievnom prístupe boli pri častejšej dialýze častejšie (pomer hazardov 1,71, 95 % interval spoľahlivosti od 1,08 do 2,73). Zo zložených ukazovateľov nemožno vyvodiť samostatný účinok na prežívanie a skúšanie prebiehalo v strediskách [5].</p>

<h2>Čo membrána odstráni z krvi</h2>
<p>Indoxylsulfát a <i>p</i>-krezylsulfát sa v krvi viažu prevažne na albumín. Pri bežnej hemodialýze prestupuje cez membránu najmä voľná frakcia. Účinnosť odstraňovania týchto látok je preto obmedzená aj pri dobrom klírense močoviny. Nové membrány a sorpčné systémy sa skúmajú okrem iného preto, aby rozšírili spektrum odstraňovaných látok. Väčší klírens alebo nižšia koncentrácia vybranej látky sú medzivýsledky. Na posúdenie prínosu treba údaje o príznakoch, kvalite života a klinických príhodách [1, 6].</p>

<h2>Nositeľný prístroj a implantovateľný bioreaktor</h2>
<p>Nositeľná umelá oblička v skúšaní Gura a spoluautorov regenerovala dialyzát v malom mimotelovom okruhu. Zo siedmich účastníkov päť dokončilo 24-hodinovú liečbu. Skúšanie zastavili pre technické problémy vrátane tvorby bublín oxidu uhličitého v okruhu dialyzátu a kolísania prietokov krvi a dialyzátu. Krátke skúšanie ukázalo, že prístroj môže fungovať počas dlhšieho výkonu. Dlhodobú spoľahlivosť ani bezpečnosť pri samostatnom používaní nehodnotilo [7].</p>
<p>Implantovateľná bioartificiálna oblička má spojiť filtračnú súčasť so živými tubulárnymi bunkami. Kimová a spoluautori overovali jednu súčasť návrhu, bioreaktor s ľudskými obličkovými epitelovými bunkami za membránou s nanopórmi. Po siedmich dňoch implantácie do ošípaných zostalo životaschopných viac ako 90 % buniek. Ide o predklinický výsledok týkajúci sa životaschopnosti a funkcie buniek v bioreaktore. Pokus nesledoval nahradenie funkcie zlyhávajúcich obličiek u človeka [8].</p>

<h2>Environmentálna záťaž vzniká aj mimo dialyzačného kresla</h2>
<p>Pri porovnaní štyroch metód u jedného poskytovateľa v Melbourne mala najvyššiu ročnú uhlíkovú stopu hemodialýza v stredisku. Pri všetkých metódach patrili medzi hlavné zdroje emisií spotrebné materiály. K rozdielu medzi hemodialýzou v stredisku a domácimi metódami najviac prispievala doprava pacientov. Čísla závisia od miestnych vzdialeností, energetiky a spôsobu poskytovania liečby. Pre stredisko je preto užitočné najprv zistiť, kde pri jeho vlastnej prevádzke vzniká najväčšia záťaž [9].</p>
<p>Pri rozhovore s pacientom, ktorý sa pripravuje na dialýzu, možno už dnes prebrať, koľko času liečba zaberie, akú podporu bude mať doma a ako bude postupovať pri ťažkostiach. Pri nových zariadeniach bude potrebné overiť, či dokážu túto každodennú záťaž znížiť pri dlhodobo bezpečnej liečbe [1, 2, 7, 8].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Ute Eppinger. Dialysis at a Turning Point: What Comes Next? Medscape, 30. októbra 2026. <a href="https://www.medscape.com/viewarticle/dialysis-turning-point-what-comes-next-2026a10015d6">Reportáž</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/">PubMed 38490803</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">Plný text KDIGO</a></em></small></li>
<li><small><em>Kassenärztliche Bundesvereinigung. Heimdialysen werden ab Januar stärker gefördert. 12. decembra 2024. <a href="https://www.kbv.de/praxis/tools-und-services/praxisnachrichten/2024/12-12/Heimdialysen%20werden%20ab%20Januar%20st%C3%A4rker%20gef%C3%B6rdert">Oznámenie KBV</a></em></small></li>
<li><small><em>Kassenärztliche Bundesvereinigung. Kostenpauschalen für nichtärztliche Dialyseleistungen steigen zum ersten Januar. 27. novembra 2025. <a href="https://www.kbv.de/praxis/tools-und-services/praxisnachrichten/2025/11-27/kostenpauschalen-f%25C3%25BCr-nichtaerztliche-dialyseleistungen-steigen-zum-ersten-januar">Sadzby KBV od januára 2026</a></em></small></li>
<li><small><em>FHN Trial Group, Glenn M Chertow, Nathan W Levin, Gerald J Beck, Thomas A Depner, Paul W Eggers, Jennifer J Gassman, Irina Gorodetskaya, Tom Greene, Sam James, Brett Larive, Robert M Lindsay, Ravindra L Mehta, Brent Miller, Daniel B Ornt, Sanjay Rajagopalan, Anjay Rastogi, Michael V Rocco, Brigitte Schiller, Olga Sergeyeva, Gerald Schulman, George O Ting, Mark L Unruh, Robert A Star, Alan S Kliger. In-center hemodialysis six times per week versus three times per week. N Engl J Med. 2010;363(24):2287-2300. <a href="https://doi.org/10.1056/NEJMoa1001593">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/21091062/">PubMed 21091062</a></em></small></li>
<li><small><em>Liesbeth Viaene, Pieter Annaert, Henriette de Loor, Ruben Poesen, Pieter Evenepoel, Björn Meijers. Albumin is the main plasma binding protein for indoxyl sulfate and p-cresyl sulfate. Biopharm Drug Dispos. 2013;34(3):165-175. <a href="https://doi.org/10.1002/bdd.1834">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/23300093/">PubMed 23300093</a></em></small></li>
<li><small><em>Victor Gura, Matthew B Rivara, Scott Bieber, Raj Munshi, Nancy Colobong Smith, Lori Linke, John Kundzins, Masoud Beizai, Carlos Ezon, Larry Kessler, Jonathan Himmelfarb. A wearable artificial kidney for patients with end-stage renal disease. JCI Insight. 2016;1(8):e86397. <a href="https://doi.org/10.1172/jci.insight.86397">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/27398407/">PubMed 27398407</a></em></small></li>
<li><small><em>Eun Jung Kim, Caressa Chen, Rebecca Gologorsky, Ana Santandreu, Alonso Torres, Nathan Wright, Mark S Goodin, Jarrett Moyer, Benjamin W Chui, Charles Blaha, Paul Brakeman, Shant Vartanian, Qizhi Tang, H David Humes, William H Fissell, Shuvo Roy. Feasibility of an implantable bioreactor for renal cell therapy using silicon nanopore membranes. Nat Commun. 2023;14(1):4890. <a href="https://doi.org/10.1038/s41467-023-39888-2">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37644033/">PubMed 37644033</a></em></small></li>
<li><small><em>Katherine A Barraclough, Ben Talbot, John Knight, Susan Blair, Forbes McGain, Rosemary Masterson, Richard Knight, Craig Nelson, Stephen McDonald, Scott McAlister. Carbon Emissions From Different Dialysis Modalities: A Life Cycle Assessment. Am J Kidney Dis. 2025;86(4):465-474.e1. <a href="https://doi.org/10.1053/j.ajkd.2025.04.019">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40602678/">PubMed 40602678</a></em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_buducnost_dialyzy',
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
?>
