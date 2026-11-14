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
    'title'        => 'Epimér vitamínu D a tuhosť tepien pri pokročilej CKD',
    'slug'         => 'epimer-vitaminu-d-tuhost-tepien-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V kohorte pacientov s CKD G5 a G5D sa koncentrácia 3-epi-25(OH)D₃ nespájala s tuhosťou tepien ani so zloženým ukazovateľom príhod a úmrtia.',
    'content'      => <<<'HTML'
<figure><img src="img/epimer-vitaminu-d-tuhost-tepien-ckd.webp" alt="Skúmavka s krvou pred modelmi obličky a tepny" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia modelov obličky a tepny vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V kohorte 270 pacientov s chronickou chorobou obličiek (CKD) v štádiu G5 alebo G5D sa vstupná koncentrácia epiméru 25-hydroxyvitamínu D₃ štatisticky významne nespájala s ukazovateľmi tuhosti tepien ani so zloženým ukazovateľom kardiovaskulárnych príhod a úmrtia z akejkoľvek príčiny. Intervaly spoľahlivosti však ponechávajú otvorenú možnosť klinicky významnej asociácie [1].</p>

<h2>Čo sa meralo</h2>
<p>3-epi-25(OH)D₃ vzniká z 25-hydroxyvitamínu D₃ zmenou priestorovej orientácie hydroxylovej skupiny na treťom uhlíku. Camposová a spoluautori stanovili jeho sérovú koncentráciu kvapalinovou chromatografiou s tandemovou hmotnostnou spektrometriou, ktorá umožnila oddeliť epimér od 25(OH)D₃. V prospektívnej kohorte Cambridge Coventry Vascular bola približne štvrtina pacientov pred dialýzou (24,8 %), 61,1 % podstupovalo hemodialýzu a 14,1 % peritoneálnu dialýzu. Priemerný vek bol približne 45 rokov. Medzi kvartilmi koncentrácie epiméru sa líšilo zastúpenie skupín podľa pôvodu, ako ich uviedli autori, aj zastúpenie dialyzačných modalít [1].</p>

<h2>Tuhosť tepien pri vstupe</h2>
<p>Aplanačnou tonometriou autori stanovili karoticko-femorálnu rýchlosť šírenia pulzovej vlny (PWV), ukazovateľ tuhosti aorty, a augmentačný index prepočítaný na srdcovú frekvenciu 75/min (AIx75). Augmentačný index ovplyvňuje aj odraz pulzovej vlny a cievny tonus. Mediány PWV sa v jednotlivých kvartiloch pohybovali od 7,8 do 8,0 m/s (<i>p</i> = 0,94) a priemery AIx75 približne od 20 do 21 % (<i>p</i> = 0,99). Asociácia sa nepreukázala ani po zohľadnení veku, kategórie pôvodu podľa údajov štúdie a dialyzačného stavu [1].</p>

<h2>Kardiovaskulárne príhody a úmrtia</h2>
<p>Pri mediáne sledovania 9,3 roka autori uviedli 115 udalostí v zloženom ukazovateli, z toho 97 kardiovaskulárnych príhod a 18 úmrtí z akejkoľvek príčiny. Najčastejšie kardiovaskulárne udalosti zahŕňali zhoršenie srdcového zlyhávania a hypertenzie. Zložený ukazovateľ teda zahŕňal širšie spektrum udalostí než bežný trojzložkový ukazovateľ kardiovaskulárneho úmrtia, infarktu a cievnej mozgovej príhody. Krivky podľa Kaplana a Meiera sa medzi kvartilmi štatisticky významne nelíšili (log-rankový test, <i>p</i> = 0,23) [1].</p>
<p>V upravenom Coxovom modeli bol pomer hazardov v najvyššom kvartile (≥ 0,73 ng/ml) oproti najnižšiemu (&lt; 0,30 ng/ml) 1,37 (95 % interval spoľahlivosti od 0,76 do 2,46). Rozpätie intervalu pripúšťa nižší aj vyšší hazard. Záver sa podstatne nezmenil po dodatočnom zohľadnení koncentrácie 25(OH)D₃. Hranice kvartilov vznikli z rozdelenia hodnôt v kohorte a štúdia ich nezavádza ako klinické prahy [1].</p>

<h2>Ako výsledok čítať v ambulancii</h2>
<p>V skoršej kohorte CAPER sa koncentrácia epiméru spájala s vrcholovou spotrebou kyslíka pri záťažovom vyšetrení. Asociácia s tuhosťou tepien sa ani tam nepreukázala. Záťažová kapacita a výskyt kardiovaskulárnych príhod odpovedajú na rôzne klinické otázky. Randomizovaná štúdia Levina a spoluautorov zase hodnotila účinok kalcifediolu a kalcitriolu na PWV. Jej výsledky sa týkajú podávania iných foriem vitamínu D a nemožno ich preniesť na účinok skúmaného epiméru [1, 2, 3].</p>
<p>Kohorta hodnotila jednorazové stanovenie epiméru. Pri obmedzenom počte udalostí a možnom vplyve nezohľadnených faktorov, napríklad stravy či fyzickej aktivity, štúdia nedokáže vylúčiť menšie asociácie ani určiť príčinný účinok. Pre rutinné meranie 3-epi-25(OH)D₃ na odhad kardiovaskulárneho rizika neposkytla dostatočnú oporu. Odporúčanie KDIGO pre poruchu minerálového a kostného metabolizmu pri CKD sa týka merania 25(OH)D a korekcie jeho nedostatku, čo je samostatná klinická otázka [1, 4].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Monique O Campos, Chien-Yao Sun, Heather N Burney, Yang Li, Gayatri Narayanan, Olivia Carlton, Tzong-Shi Lu, Glenville Jones, Martin Kaufmann, Stephen M S Ting, Daniel Zehnder, Thomas Hiemstra, Kenneth Lim. Epimeric Vitamin D is Not Associated With Arterial Stiffness or Cardiovascular Outcomes in Patients With Advanced CKD. Kidney Med. 2026;8(11):101519. <a href="https://doi.org/10.1016/j.xkme.2026.101519" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42894851/" target="_blank" rel="noopener noreferrer">PubMed 42894851</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13677220/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Eliott Arroyo, Cecilia A Leber, Heather N Burney, Yang Li, Xiaochun Li, Tzong-Shi Lu, Glenville Jones, Martin Kaufmann, Stephen M S Ting, Thomas F Hiemstra, Daniel Zehnder, Kenneth Lim. Epimeric vitamin D and cardiovascular structure and function in advanced CKD and after kidney transplantation. Nephrol Dial Transplant. 2024;39(2):264-276. <a href="https://doi.org/10.1093/ndt/gfad168" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37468453/" target="_blank" rel="noopener noreferrer">PubMed 37468453</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10828205/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Adeera Levin, Mila Tang, Taylor Perry, Nadia Zalunardo, Monica Beaulieu, Joshua A Dubland, Kelly Zerr, Ognjenka Djurdjev. Randomized Controlled Trial for the Effect of Vitamin D Supplementation on Vascular Stiffness in CKD. Clin J Am Soc Nephrol. 2017;12(9):1447-1460. <a href="https://doi.org/10.2215/CJN.10791016" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/28550081/" target="_blank" rel="noopener noreferrer">PubMed 28550081</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5586581/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD-MBD Update Work Group. KDIGO 2017 Clinical Practice Guideline Update for the Diagnosis, Evaluation, Prevention, and Treatment of Chronic Kidney Disease-Mineral and Bone Disorder (CKD-MBD). Kidney Int Suppl (2011). 2017;7(1):1-59. <a href="https://doi.org/10.1016/j.kisu.2017.04.001" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30675420/" target="_blank" rel="noopener noreferrer">PubMed 30675420</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6340919/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
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
    'log_prefix' => 'add_epimer_vitaminu_d_ckd',
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
