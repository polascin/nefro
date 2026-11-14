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
    'title'        => 'Kreatinín a cystatín C pri hodnotení poklesu filtrácie v ADPKD',
    'slug'         => 'adpkd-kreatinin-cystatin-c-pokles-filtracie',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V kohorte DIPAK kombinovaný odhad lepšie sledoval pokles meranej filtrácie. Prínos pre klinické skúšania ešte treba potvrdiť prospektívne.',
    'content'      => <<<'HTML'
<figure><img src="img/adpkd-kreatinin-cystatin-c-pokles-filtracie.webp" alt="Schematický rez obličkou s cystami vedľa skúmaviek" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Rez obličkou je schematický.</figcaption></figure>

<p>Pri autozómovo dominantnej polycystickej chorobe obličiek (ADPKD) sledoval odhad glomerulovej filtrácie z kreatinínu a cystatínu C ročný pokles meranej filtrácie lepšie než odhad zo samotného kreatinínu. Tento výsledok z observačnej kohorty komentuje Gopala Rangan v <i>Kidney International Reports</i>. Pre klinické skúšania je dôležité, že zhoda s meranou filtráciou pri sledovaní zmien v čase sa môže zlepšiť aj vtedy, keď jednorazový odhad vykazuje väčšiu systematickú odchýlku [1, 2].</p>

<h2>Čo porovnala kohorta DIPAK</h2>
<p>Bais a spoluautori analyzovali údaje 260 pacientov s ADPKD sledovaných v Groningene. Referenčnou metódou bola glomerulová filtrácia meraná klírensom iotalamátu (mGFR). Autori porovnali odhad zo samotného kreatinínu (eGFRcr), z cystatínu C (eGFRcys) a z oboch markerov (eGFRcr-cys). Kreatinín a cystatín C zo skladovaných vzoriek stanovili v jednej analytickej sérii. Odhady zo samotného kreatinínu stanoveného v tejto sérii sa správali podobne ako odhady z rutinných stanovení pri rovnakých návštevách [2].</p>
<p>Pri vstupnom porovnaní mal kombinovaný odhad menší rozptyl rozdielov voči mGFR, ale oproti rutinnému eGFRcr väčšiu priemernú odchýlku. Priemerný rozdiel eGFR mínus mGFR bol −1,5 ml/min/1,73 m² pri kombinovanom odhade a +0,1 ml/min/1,73 m² pri rutinnom odhade z kreatinínu. Zhoda v zaradení do kategórie glomerulovej filtrácie sa zreteľne nezlepšila [2].</p>

<h2>Ročná zmena filtrácie a veľkosť štúdie</h2>
<p>Opakovanú mGFR malo 189 pacientov. Koeficient korelácie zhody ročnej zmeny s mGFR dosiahol 0,68 (95 % interval spoľahlivosti od 0,59 do 0,76) pri eGFRcr-cys, 0,58 (od 0,47 do 0,67) pri eGFRcr a 0,61 (od 0,50 do 0,70) pri eGFRcys. Všetky tri odhady v tomto porovnaní vychádzali zo vzoriek analyzovaných v jednej sérii. Ani hodnota 0,68 nedovoľuje tieto metódy u jednotlivca považovať za zameniteľné [1, 2].</p>
<p>V skupine 99 pacientov, ktorí sa charakteristikami približovali populácii klinického skúšania, sa kombinovaným odhadom znížil rozptyl ročných zmien eGFR. Modelový výpočet pri predpokladanom 20 % spomalení poklesu filtrácie odhadol potrebný počet účastníkov na 304 pri kombinovanom ukazovateli a 490 pri ukazovateli zo samotného kreatinínu stanovovaného v jednej sérii. Ide približne o 38 % menšiu vzorku za predpokladov daného modelu. Skutočná veľkosť skúšania bude závisieť od populácie, harmonogramu meraní a od toho, ako sa bude v analýze postupovať pri predčasnom ukončení sledovania alebo začatí dialýzy [1, 2].</p>

<h2>Čo ešte treba overiť</h2>
<p>Kreatinín ovplyvňuje svalová hmota, strava aj tubulárna sekrécia. Na cystatín C môžu pôsobiť napríklad zápal, funkcia štítnej žľazy, adipózita či glukokortikoidy. Kombinácia markerov môže zmenšiť vplyv faktorov, ktoré pôsobia prevažne na jeden z nich. Výsledok však stále závisí od štandardizácie stanovení a od toho, či skúšaná liečba mení koncentráciu niektorého markera nezávisle od filtrácie. V kohorte nebol k dispozícii rutinne stanovovaný cystatín C ani údaje o funkcii štítnej žľazy. Merania mGFR neprebiehali každý rok a časť účastníkov prestala byť sledovaná, okrem iného po začatí liečby nahrádzajúcej funkciu obličiek [1, 2, 3].</p>
<p>Rangan navrhuje v budúcich štúdiách vopred naplánovať stanovenie cystatínu C pri každom stanovení kreatinínu a kombinovaný odhad vopred určiť ako dôležitý sekundárny ukazovateľ. Paralelné hodnotenie oboch odhadov pri rovnakých návštevách a rovnakým analytickým postupom by umožnilo posúdiť, či sa zlepšená zhoda prenesie aj na odhad účinku liečby v randomizovanej štúdii. Podštúdia s priamo meranou GFR by pomohla vysvetliť prípadné rozdiely medzi markermi [1].</p>

<h2>Význam pre ambulanciu</h2>
<p>KDIGO odporúča pri dostupnom cystatíne C odhadovať kategóriu GFR pri chronickej chorobe obličiek z oboch markerov. Pri ADPKD má pri odhade rizika progresie svoje miesto aj celkový objem obličiek upravený na výšku, napríklad v zobrazovacej klasifikácii Mayo. Objem pomáha odhadnúť budúce riziko najmä v skoršom štádiu, keď môže byť filtrácia ešte zachovaná. Meraná a odhadovaná GFR slúžia na hodnotenie filtrácie. Výsledky kohorty podporujú ďalšie skúmanie kombinovaného ukazovateľa, pričom o účinnosti konkrétnej liečby rozhodujú údaje z intervenčných štúdií [2, 3, 4].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Gopala Rangan. Beyond Creatinine: Refining Kidney Function End Points in ADPKD Clinical Trials. Kidney Int Rep. 2026;11(11):107090. <a href="https://doi.org/10.1016/j.ekir.2026.107090" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42894668/" target="_blank" rel="noopener noreferrer">PubMed 42894668</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13677015/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Thomas Bais, Abdulfataah A. A. Mohamed, A. Noruzi, Muhammad Umar, Bella A. Binoy, M. Salih, Esther Meijer, Ron T. Gansevoort. Combining Cystatin C and Creatinine Increases eGFR Slope Accuracy in ADPKD. Kidney Int Rep. 2026;11(10):107008. <a href="https://doi.org/10.1016/j.ekir.2026.107008" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42733501/" target="_blank" rel="noopener noreferrer">PubMed 42733501</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13571460/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) ADPKD Work Group. KDIGO 2025 Clinical Practice Guideline for the Evaluation, Management, and Treatment of Autosomal Dominant Polycystic Kidney Disease (ADPKD). Kidney Int. 2025;107(2S):S1-S239. <a href="https://doi.org/10.1016/j.kint.2024.07.009" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39848759/" target="_blank" rel="noopener noreferrer">PubMed 39848759</a> · <a href="https://kdigo.org/guidelines/autosomal-dominant-polycystic-kidney-disease-adpkd/" target="_blank" rel="noopener noreferrer">KDIGO</a></em></small></li>
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
    'log_prefix' => 'add_adpkd_kreatinin_cystatin_c',
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
