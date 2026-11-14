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
    'title'        => 'POTS po COVID-19 a pri chronickej chorobe obličiek',
    'slug'         => 'pots-po-covide-a-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Ako rozpoznať syndróm posturálnej ortostatickej tachykardie, čo ukázali skúšania imunoglobulínov a prečo pri chorobe obličiek treba individuálne nastaviť príjem soli a tekutín.',
    'content'      => <<<'HTML'
<figure><img src="img/pots-po-covide-a-ckd.webp" alt="Pacientka stojí pri vyšetrovacom ležadle v ambulancii" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia ambulantného vyšetrenia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Búšenie srdca, závrat či pocit na odpadnutie po postavení môžu byť prejavom syndrómu posturálnej ortostatickej tachykardie (POTS), a to aj po prekonaní COVID-19. Reportáž Laurie Tarkanovej v Medscape opisuje rastúci počet zaznamenaných diagnóz a výskum možných imunitných mechanizmov. Pre nefrológa je dôležitá aj praktická otázka. Zvýšenie príjmu soli a tekutín, ktoré sa používa pri POTS, môže pri chronickej chorobe obličiek (CKD) zhoršiť hypertenziu alebo preťaženie tekutinami [1, 2, 8].</p>

<h2>Diagnóza stojí na príznakoch a meraní v stoji</h2>
<p>Typické ťažkosti vznikajú alebo sa zhoršujú vo vzpriamenej polohe a ustupujú po ľahnutí. Zahŕňajú závraty, palpitácie, slabosť, zahmlené videnie a únavu. U dospelého sa vyžaduje pretrvávajúci vzostup srdcovej frekvencie aspoň o 30 úderov za minútu do desiatich minút po postavení. Vo veku 12 až 19 rokov je hranica 40 úderov za minútu. Vzostup má byť prítomný najmenej pri dvoch meraniach s odstupom aspoň jednej minúty. Kritériá vyžadujú príznaky aspoň tri mesiace, bez významnej ortostatickej hypotenzie a bez iného vysvetlenia tachykardie [2].</p>
<p>V ambulancii sa meria krvný tlak a srdcová frekvencia po 5 až 10 minútach v ľahu a potom opakovane počas desiatich minút státia. Pri CKD treba zvážiť najmä anémiu, nedostatok cirkulujúceho objemu, účinok liekov či nedávnu zmenu ultrafiltrácie u dialyzovaného pacienta. Pri nepravidelnom pulze alebo náhlom začiatku a konci palpitácií je dôležité odlíšiť arytmiu. Samotný údaj o vysokom pulze z hodiniek diagnózu nepotvrdzuje [2, 8].</p>

<h2>Po pandémii pribudli zaznamenané diagnózy</h2>
<p>Dulal a spoluautori analyzovali časový vývoj diagnóz v databáze TriNetX s údajmi o viac než 65 miliónoch dospelých zo 64 zdravotníckych organizácií. Po marci 2020 pribúdali diagnózy rýchlejšie. Porovnanie období však neurčuje, akú časť nárastu spôsobila samotná infekcia. K zmene počtu záznamov mohli prispieť aj väčšia informovanosť, dostupnosť vyšetrení a zmeny diagnostického kódovania [1, 3].</p>
<p>V prierezovej štúdii Seeleyovej a spoluautorov splnilo kritériá POTS 15 z 24 účastníkov s postakútnymi následkami COVID-19. Tento podiel opisuje malú vybranú skupinu a nedá sa použiť ako odhad výskytu POTS u všetkých ľudí s dlhým COVID-19. Prekryv príznakov je dôvodom na vyšetrenie ortostatickej intolerancie, ak sa ťažkosti viažu na vzpriamenú polohu [2, 4].</p>

<h2>Imunitná hypotéza zatiaľ neurčuje liečbu</h2>
<p>Výsledky merania autoprotilátok závisia od použitej metódy. Hallová a spoluautori nezistili rozdiel v koncentráciách autoprotilátok proti skúmaným receptorom medzi pacientmi s POTS a zdravými kontrolami pri použití komerčného imunoanalytického testu. Ani Seeleyovej tím nezistil štatisticky významný rozdiel medzi skupinami pri meraní aktivácie adrenergných receptorov. Pozitívny komerčný test preto sám osebe nepotvrdzuje POTS ani autoimunitnú príčinu ťažkostí [4, 5].</p>
<p>V randomizovanom skúšaní iSTAND dostalo 30 účastníkov intravenózny imunoglobulín alebo albumín. Zmena skóre autonómnych príznakov sa medzi skupinami štatisticky významne nelíšila (<i>p</i> = 0,629). Malý počet účastníkov obmedzuje presnosť a albumín môže sám ovplyvniť cirkulujúci objem. Skúšanie podkožného imunoglobulínu pri POTS po COVID-19 (NCT06524739) sa skončilo predčasne. V 25. týždni boli údaje o primárnom výsledku dostupné u troch účastníkov liečenej skupiny a u žiadneho účastníka v skupine s placebom. Výsledky neposkytujú podklad na rutinné nasadenie imunoglobulínov pri POTS [6, 7].</p>

<h2>Soľ a tekutiny pri súbežnej chorobe obličiek</h2>
<p>Pri POTS sa liečba prispôsobuje príznakom, krvnému tlaku a tolerancii záťaže. Medzi používané opatrenia patrí kompresia dolných končatín a brucha a pohybová rehabilitácia prispôsobená tolerancii pacienta. Vyšší príjem soli a tekutín sa niekedy využíva na zväčšenie cirkulujúceho objemu. Pri CKD treba posúdiť krvný tlak, opuchy, diurézu a prípadné srdcové zlyhávanie ešte pred odporúčaním takéhoto režimu. KDIGO pri CKD vo všeobecnosti navrhuje príjem menej ako 2 g sodíka denne, čo zodpovedá približne 5 g kuchynskej soli. Výnimkou môžu byť napríklad nefropatie so stratami sodíka [2, 8].</p>
<p>U dialyzovaného pacienta s ťažkosťami po postavení má význam ich časový vzťah k dialýze, zmenám hmotnosti a ultrafiltrácii. Tieto údaje pomáhajú posúdiť, či sa na ťažkostiach podieľa zmena objemu. Úpravu príjmu tekutín a sodíka treba zosúladiť s dialyzačným predpisom a aktuálnym objemovým stavom [2, 8].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Laurie Tarkan. A Long-Ignored Syndrome Is Drawing Unprecedented Attention. Medscape. 29. októbra 2026. <a href="https://www.medscape.com/viewarticle/long-ignored-syndrome-drawing-unprecedented-attention-2026a1001531">Reportáž</a></em></small></li>
<li><small><em>Satish R Raj, Artur Fedorowski, Robert S Sheldon. Diagnosis and management of postural orthostatic tachycardia syndrome. CMAJ. 2022;194(10):E378-E385. <a href="https://doi.org/10.1503/cmaj.211373">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/35288409/">PubMed 35288409</a></em></small></li>
<li><small><em>Dharmindra Dulal, Ahmed Maraey, Hadeer Elsharnoby, Paul Chacko, Blair Grubb. Impact of COVID-19 pandemic on the incidence and prevalence of postural orthostatic tachycardia syndrome. Eur Heart J Qual Care Clin Outcomes. 2025;11(5):698-704. <a href="https://doi.org/10.1093/ehjqcco/qcae111">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39775762/">PubMed 39775762</a></em></small></li>
<li><small><em>Marie-Claire Seeley, Celine Gallagher, Gemma Wilson, Danielle Bailey, Amy Langdon, Eric Ong, Jonathan Chieng, Kristina Comacchio, Amanda J Page, Lynsie Morris, Maria Toumpourleka, H Greg Matlock, Xue Cai, Xichun Yu, Dennis H Lau, Stavros Stavrakis. Comparative Analysis of Circulating Cytokines and Adrenergic Autoantibodies in Postural Orthostatic Tachycardia Syndrome, Postacute Sequelae of SARS-CoV-2, and Healthy Controls. J Am Heart Assoc. 2026;15(11):e048615. <a href="https://doi.org/10.1161/JAHA.125.048615">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42179241/">PubMed 42179241</a></em></small></li>
<li><small><em>Juliette Hall, Kate M Bourne, Steven Vernino, Viktor Hamrefors, Isabella Kharraziha, Jan Nilsson, Robert S Sheldon, Artur Fedorowski, Satish R Raj. Detection of G Protein-Coupled Receptor Autoantibodies in Postural Orthostatic Tachycardia Syndrome Using Standard Methodology. Circulation. 2022;146(8):613-622. <a href="https://doi.org/10.1161/CIRCULATIONAHA.122.059971">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/35766055/">PubMed 35766055</a></em></small></li>
<li><small><em>Steven Vernino, Steve Hopkins, Meredith Bryarly, Roberto S Hernandez, Amber Salter. Randomized controlled trial of intravenous immunoglobulin for autoimmune postural orthostatic tachycardia syndrome (iSTAND). Clin Auton Res. 2024;34(1):153-163. <a href="https://doi.org/10.1007/s10286-024-01020-9">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38311655/">PubMed 38311655</a></em></small></li>
<li><small><em>CSL Behring. Double-blind, Randomized, Placebo-controlled Study Evaluating Efficacy and Safety of IgPro20 in Post-COVID-19 POTS. Výsledky v registri ClinicalTrials.gov, 13. apríla 2026. <a href="https://clinicaltrials.gov/study/NCT06524739?tab=results">NCT06524739</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/">PubMed 38490803</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">Plný text KDIGO</a></em></small></li>
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
    'log_prefix' => 'add_pots_po_covide',
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
