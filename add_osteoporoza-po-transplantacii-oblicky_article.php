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
    'title'        => 'Osteoporóza po transplantácii obličky',
    'slug'         => 'osteoporoza-po-transplantacii-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Farmakologická liečba zlepšila kostnú minerálnu denzitu na viacerých miestach. Údaje o zlomeninách pochádzajú len z troch štúdií a účinok zostáva neistý.',
    'content'      => <<<'HTML'
<figure><img src="img/osteoporoza-po-transplantacii-oblicky.webp" alt="Ilustračné zobrazenie driekovej chrbtice vedľa anatomického modelu obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Zobrazenie chrbtice nepochádza z vyšetrenia pacienta.</figcaption></figure>

<p>V súhrne randomizovaných štúdií sa po farmakologickej liečbe príjemcov obličkového transplantátu zvýšila kostná minerálna denzita (BMD) na viacerých miestach. Účinok na riziko zlomenín zostáva neistý. Z 33 štúdií hlásili zlomeniny len tri [1].</p>

<h2>Kde sa kostná minerálna denzita zmenila</h2>
<p>Wipattanakitcharoen a spoluautori zahrnuli 33 randomizovaných štúdií s 2 623 príjemcami obličkového transplantátu. Databázy prehľadali do decembra 2024. Súhrnné odhady získali modelom s náhodnými účinkami. Porovnávané intervencie zahŕňali okrem iného bisfosfonáty, aktívny vitamín D a denosumab. Počty štúdií a pacientov sa pri jednotlivých výsledkoch líšili [1].</p>

<div class="table-responsive" role="region" aria-label="Zmeny kostnej minerálnej denzity podľa miesta merania" tabindex="0">
<table>
<thead><tr><th scope="col">Miesto merania</th><th scope="col">Štúdie a účastníci</th><th scope="col">Vážený priemerný rozdiel BMD (95 % interval spoľahlivosti), g/cm²</th><th scope="col">I²</th></tr></thead>
<tbody>
<tr><th scope="row">Drieková chrbtica</th><td>30 a 1 749</td><td>+0,04 (od 0,00 do 0,08)</td><td>99,9 %</td></tr>
<tr><th scope="row">Krčok stehennej kosti</th><td>27 a 1 442</td><td>+0,05 (od 0,03 do 0,07)</td><td>83,2 %</td></tr>
<tr><th scope="row">Vretenná kosť</th><td>11 a 696</td><td>+0,14 (od 0,08 do 0,19)</td><td>98,4 %</td></tr>
<tr><th scope="row">Celková oblasť bedra</th><td>8 a 652</td><td>+0,03 (od −0,01 do 0,07)</td><td>96,5 %</td></tr>
</tbody></table></div>

<p>Vážený priemerný rozdiel bol štatisticky významný v driekovej chrbtici (<i>p</i> = 0,04, dolná hranica intervalu je zaokrúhlená), v krčku stehennej kosti a vo vretennej kosti (v oboch prípadoch <i>p</i> &lt; 0,001). Pre celkovú oblasť bedra interval zahŕňal nulový rozdiel. Hodnoty I² ukazujú značnú variabilitu medzi štúdiami. Rozdiely v liekoch, čase od transplantácie, funkcii štepu, imunosupresii a sprievodnej liečbe obmedzujú prenos súhrnných odhadov na konkrétneho pacienta [1].</p>

<h2>Čo vieme o zlomeninách</h2>
<p>Zlomeniny hlásili tri štúdie so 750 účastníkmi a sledovaním od jedného do dvoch rokov. Súhrnný pomer rizík bol 0,38 (95 % interval spoľahlivosti od 0,14 do 1,01, zaokrúhlené <i>p</i> = 0,05). Bodový odhad pripúšťa významný klinický prínos, interval však siaha až za hodnotu 1. Pri takomto rozsahu neistoty nemožno spoľahlivo určiť, či a o koľko liečba riziko zlomenín znižuje. I² = 0 % pri troch štúdiách túto neistotu nerieši [1].</p>

<h2>Parathormón a kostný obrat</h2>
<p>V súhrnnej analýze sa koncentrácia intaktného parathormónu (iPTH) a osteokalcínu ani aktivita kostnej alkalickej fosfatázy štatisticky významne nezmenili. Pokles iPTH sa preukázal v podskupine liečenej aktívnym vitamínom D. Vážený priemerný rozdiel bol približne −25 pg/ml. Ide o biochemický výsledok. Stav kostného obratu a riziko zlomeniny si pri rozhodovaní vyžadujú širšie posúdenie [1, 3].</p>

<h2>Dôsledky pre potransplantačné sledovanie</h2>
<p>Riziko zlomeniny ovplyvňuje kostná choroba prítomná pred transplantáciou, pretrvávajúca hyperparatyreóza, funkcia štepu aj expozícia glukokortikoidom. BMD pomáha odhadnúť riziko zlomeniny. Samotná denzitometria nedokáže určiť typ renálnej osteodystrofie ani spoľahlivo rozlíšiť vysoký a nízky kostný obrat. KDIGO navrhuje merať BMD u príjemcov s rizikovými faktormi osteoporózy, ak výsledok ovplyvní liečbu [1, 3].</p>

<p>V prvých 12 mesiacoch po transplantácii možno pri nízkej BMD a odhadovanej glomerulovej filtrácii nad približne 30 ml/min/1,73 m² podľa KDIGO zvážiť vitamín D, kalcitriol alebo alfakalcidol a podľa okolností antiresorpčnú liečbu. Ide o podmienené odporúčanie s veľmi nízkou istotou dôkazov (2D). Pri výbere liečby treba zohľadniť vápnik, fosfát, PTH, alkalickú fosfatázu a 25-hydroxyvitamín D. Kostná biopsia môže pomôcť, ak jej výsledok zmení liečbu. Po prvom roku odporúčanie upozorňuje na nedostatok údajov [3].</p>

<p>V jednej randomizovanej štúdii z prvého roka po transplantácii denosumab zvýšil BMD driekovej chrbtice aj celkovej oblasti bedra. Častejšie sa zaznamenala cystitída a asymptomatická hypokalciémia. Európsky súhrn charakteristických vlastností lieku upozorňuje na vyššie riziko hypokalciémie pri ťažkej poruche funkcie obličiek alebo dialýze. Výber lieku preto vychádza z individuálneho rizika zlomeniny, funkcie štepu a minerálového metabolizmu. Veľkosť zmeny BMD v metaanalýze sama osebe na výber lieku nestačí [1, 2, 4].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Aschariya Wipattanakitcharoen, Tanun Ngamvichchukorn, Sirinatta Prachathai, Kullaya Takkavatakarn, Kearkiat Praditpornsilpa, Paweena Susantitaphong. Pharmacological Interventions for Osteoporosis in Kidney Transplant Recipients: A Systematic Review and Meta-analysis. Kidney Med. 2026;8(11):101537. <a href="https://doi.org/10.1016/j.xkme.2026.101537" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.xkme.2026.101537</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42965180/" target="_blank" rel="noopener noreferrer">PubMed 42965180</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13722076/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>M Bonani, D Frey, J Brockmann, T Fehr, T F Mueller, L Saleh, A von Eckardstein, N Graf, R P Wüthrich. Effect of Twice-Yearly Denosumab on Prevention of Bone Mineral Density Loss in De Novo Kidney Transplant Recipients: A Randomized Controlled Trial. Am J Transplant. 2016;16(6):1882-1891. <a href="https://doi.org/10.1111/ajt.13692" target="_blank" rel="noopener noreferrer">DOI 10.1111/ajt.13692</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/26713403/" target="_blank" rel="noopener noreferrer">PubMed 26713403</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD-MBD Update Work Group. KDIGO 2017 Clinical Practice Guideline Update for the Diagnosis, Evaluation, Prevention, and Treatment of Chronic Kidney Disease-Mineral and Bone Disorder (CKD-MBD). Kidney Int Suppl (2011). 2017;7(1):1-59. <a href="https://doi.org/10.1016/j.kisu.2017.04.001" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kisu.2017.04.001</a> · <a href="https://kdigo.org/guidelines/ckd-mbd/" target="_blank" rel="noopener noreferrer">KDIGO</a></em></small></li>
<li><small><em>Európska lieková agentúra. Prolia. Súhrn charakteristických vlastností lieku, časť 4.4. <a href="https://www.ema.europa.eu/en/documents/product-information/prolia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
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
    'log_prefix' => 'add_osteoporoza_po_transplantacii_oblicky',
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
