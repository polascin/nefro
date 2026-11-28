<?php

// Ochrana pre správcu alebo spustenie z príkazového riadka
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// Dáta článku

$articles = [[
    'title' => 'Biotín pri hemodialýze môže skresliť výsledky parathormónu a 25-hydroxyvitamínu D',
    'slug' => 'biotin-hemodialyza-parathormon-vitamin-d',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Pri hemodialýze môže biotín v niektorých imunochemických metódach skresliť výsledky parathormónu a 25-hydroxyvitamínu D. Kazuistika ukazuje, ako vzniká podozrivý nález.',
    'content' => <<<'HTML'
<p>Náhly pokles parathormónu (PTH) a súčasný vzostup 25-hydroxyvitamínu D [25(OH)D] u pacienta na hemodialýze môžu byť dôsledkom interferencie biotínu. Pri výklade takého nálezu záleží na tom, akú dávku biotínu pacient užíva a akou metódou laboratórium meria oba ukazovatele. Biotín (vitamín B7) sa nachádza aj v doplnkoch na vlasy, pokožku a nechty. [<a href="#zdroj-1">1</a>, <a href="#zdroj-2">2</a>, <a href="#zdroj-5">5</a>]</p>

<figure class="article-figure"><img src="img/biotin-hemodialyza-parathormon-vitamin-d.webp" width="1584" height="990" alt="Neoznačený obal výživového doplnku pri skúmavke so vzorkou krvi v laboratórnom stojane." loading="lazy" decoding="async"></figure>

<h2>Priebeh kazuistiky</h2>

<p>Plasse a spoluautori opísali pacientku na udržiavacej hemodialýze, ktorá užívala 10 mg biotínu denne. Nameraný intaktný parathormón (iPTH) klesol z 966 na 63 pg/ml a 25(OH)D stúpol z 25 na viac ako 100 ng/ml. Pracovisko stanovovalo oba ukazovatele imunochemicky na analyzátore Roche Cobas 8000 s využitím väzby biotínu na streptavidín. Sedem týždňov po vysadení doplnku pri nezmenenej medikácii namerali iPTH 806 pg/ml a 25(OH)D 16 ng/ml. Abstrakt opisuje návrat oboch výsledkov k východiskovým hodnotám. Táto formulácia je nepresná. Podľa plného textu sa iPTH k pôvodnej hodnote priblížil a 25(OH)D klesol pod svoju východiskovú hodnotu. [<a href="#zdroj-1">1</a>]</p>

<p>Autori pripísali neobvyklú kombináciu výsledkov interferencii biotínu. Túto interpretáciu podporuje smer oboch zmien pri užívaní doplnku a ich vývoj po vysadení. Kazuistika neuvádza porovnávacie meranie v tej istej vzorke metódou bez biotínu. Skutočný rozsah skreslenia preto nemožno spätne vyčísliť. Z jedného prípadu sa nedá určiť ani frekvencia interferencie pri hemodialýze, ani potrebný čas od poslednej dávky do odberu. [<a href="#zdroj-1">1</a>]</p>

<h2>Prečo záleží na metóde</h2>

<p>Vo vybraných imunochemických metódach slúži väzba biotínu na streptavidín na zachytenie reakčného komplexu. Voľný biotín zo vzorky obsadzuje väzbové miesta streptavidínu a môže oslabiť signál. V citlivej sendvičovej metóde sa to môže prejaviť falošne nízkym výsledkom PTH. Pri citlivej kompetitívnej metóde môže znížený signál znamenať falošne vysoký výsledok 25(OH)D. Citlivosť závisí od konkrétnej súpravy a koncentrácie biotínu vo vzorke. [<a href="#zdroj-2">2</a>]</p>

<p>V nerandomizovanej skríženej štúdii u šiestich zdravých dospelých po užívaní 10 mg biotínu denne počas siedmich dní zistili interferenciu pri 9 z 23 metód využívajúcich biotín. Pri 14 metódach bez biotínu ju nezistili. Aj pri tom istom ukazovateli sa výsledky podľa metódy líšili. Pri stanovení PTH na systéme Vitros zaznamenali falošne nízke výsledky. Pri stanovení PTH na analyzátore Cobas e602 interferenciu za podmienok tejto štúdie nezistili. Tieto údaje dokumentujú závislosť od spôsobu merania a podmienok odberu. Na určenie odstupu pred odberom u pacientov na hemodialýze štúdia neposkytuje údaje. [<a href="#zdroj-3">3</a>]</p>

<h2>Ako overiť podozrivý nález</h2>

<p>Pri sledovaní poruchy minerálového a kostného metabolizmu pri chronickej chorobe obličiek odporúča KDIGO (Kidney Disease: Improving Global Outcomes) posudzovať vývoj výsledkov a súvislosti s ostatnými nálezmi. Laboratórium má uviesť použitú metódu a oznámiť jej zmenu. Pri nečakanom poklese PTH a súčasnom vzostupe 25(OH)D má preto zmysel porovnať výsledky s predchádzajúcimi hodnotami, s vápnikom a fosfátmi a overiť, či pacient užíva biotín. Pre laboratórium sú dôležité názov prípravku, denná dávka a čas posledného užitia. [<a href="#zdroj-2">2</a>, <a href="#zdroj-4">4</a>, <a href="#zdroj-5">5</a>]</p>

<p>Usmernenie Americkej asociácie pre klinickú chémiu (AACC) uprednostňuje pri podozrení na interferenciu overenie pôvodnej vzorky vhodnou metódou, ktorá pri meraní nevyužíva biotín. Ak taká metóda nie je dostupná, laboratórium môže navrhnúť nový odber po dohodnutom prerušení užívania. Pri zhoršenej funkcii obličiek sa biotín môže vylučovať pomalšie. Odstup treba dohodnúť s laboratóriom podľa dávky, funkcie obličiek, pokynov výrobcu a citlivosti použitej metódy. [<a href="#zdroj-2">2</a>, <a href="#zdroj-5">5</a>]</p>

<h2 id="zdroje">Zdroje</h2>

<ol class="article-references">
<li id="zdroj-1"><small><em>Richard A. Plasse, Stephen W. Olson, Christina M. Yuan, Robert Nee. Biotin supplement interference with immunoassays for parathyroid hormone and 25-hydroxyvitamin D in a patient with metabolic bone disease on maintenance hemodialysis. Clinical Kidney Journal. 2020, roč. 13, č. 4, s. 710 až 712. Online 26. novembra 2019. <a href="https://doi.org/10.1093/ckj/sfz134" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32905171/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://academic.oup.com/ckj/article-abstract/13/4/710/5643863" target="_blank" rel="noopener noreferrer">Oxford Academic</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7467599/" target="_blank" rel="noopener noreferrer">Plný text v PMC</a></em></small></li>
<li id="zdroj-2"><small><em>Danni Li, Angela Ferguson, Mark A. Cervinski, Kara L. Lynch, Patrick B. Kyle. AACC Guidance Document on Biotin Interference in Laboratory Tests. The Journal of Applied Laboratory Medicine. 2020, roč. 5, č. 3, s. 575 až 587. <a href="https://doi.org/10.1093/jalm/jfz010" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32445355/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://academic.oup.com/jalm/article/5/3/575/5700349" target="_blank" rel="noopener noreferrer">Oxford Academic</a> · <a href="https://myadlm.org/science-and-research/academy-guidance/biotin-interference-in-laboratory-tests" target="_blank" rel="noopener noreferrer">ADLM</a></em></small></li>
<li id="zdroj-3"><small><em>Danni Li, Angela Radulescu, Rupendra T. Shrestha, Matthew Root, Amy B. Karger, Anthony A. Killeen, James S. Hodges, Shu-Ling Fan, Angela Ferguson, Uttam Garg, Lori J. Sokoll, Lynn A. Burmeister. Association of Biotin Ingestion With Performance of Hormone and Nonhormone Assays in Healthy Adults. JAMA. 2017, roč. 318, č. 12, s. 1150 až 1160. <a href="https://doi.org/10.1001/jama.2017.13705" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/28973622/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://jamanetwork.com/journals/jama/fullarticle/2654822" target="_blank" rel="noopener noreferrer">JAMA Network</a></em></small></li>
<li id="zdroj-4"><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD-MBD Update Work Group. KDIGO 2017 Clinical Practice Guideline Update for the Diagnosis, Evaluation, Prevention, and Treatment of Chronic Kidney Disease-Mineral and Bone Disorder (CKD-MBD). Kidney International Supplements. 2017, roč. 7, č. 1, s. 1 až 59. <a href="https://doi.org/10.1016/j.kisu.2017.04.001" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30675420/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://linkinghub.elsevier.com/retrieve/pii/S2157171617300011" target="_blank" rel="noopener noreferrer">Elsevier</a> · <a href="https://kdigo.org/guidelines/ckd-mbd/" target="_blank" rel="noopener noreferrer">KDIGO</a></em></small></li>
<li id="zdroj-5"><small><em>Health Canada. Biotin and the risk of false lab test results. 2025. Oznámenie regulačného orgánu. <a href="https://www.canada.ca/en/health-canada/services/drugs-health-products/medical-devices/biotin-risk-false-lab-test-results.html" target="_blank" rel="noopener noreferrer">Health Canada</a></em></small></li>
</ol>
HTML,
]];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_biotin-hemodialyza-parathormon-vitamin-d_article',
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
