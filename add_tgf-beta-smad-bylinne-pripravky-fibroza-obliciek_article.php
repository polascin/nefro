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
    'title'        => 'Dráha TGF‑β/Smad, bylinné prípravky a fibróza obličiek',
    'slug'         => 'tgf-beta-smad-bylinne-pripravky-fibroza-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Čo experimenty s čínskymi bylinnými prípravkami ukazujú o dráhe TGF‑β/Smad a aké dôkazy ešte chýbajú pre liečbu fibrózy obličiek.',
    'content'      => <<<'HTML'
<figure><a href="img/tgf-beta-smad-bylinne-pripravky-fibroza-obliciek.webp" target="_blank" rel="noopener noreferrer"><img src="img/tgf-beta-smad-bylinne-pripravky-fibroza-obliciek.webp" alt="Rastlinné látky a výskum fibrózy obličiek" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Rastlinné látky a výskum fibrózy obličiek. Ilustračný obrázok.</figcaption></figure>
<p>Prehľad Shaoa a spoluautorov opisuje, ako čínske bylinné prípravky a ich zložky ovplyvňujú dráhu transformujúceho rastového faktora β (TGF‑β) a proteínov Smad v experimentálnych modeloch poškodenia obličiek. Výsledky pomáhajú formulovať hypotézy o vzniku fibrózy. Z dostupných údajov však nemožno určiť, či skúmané prípravky spomaľujú pokles funkcie obličiek u pacientov. [1]</p>
<h2>Čo ukazujú experimenty</h2>
<p>Autori sa venujú akútnemu poškodeniu obličiek (AKI), chronickej chorobe obličiek (CKD) aj prechodu z AKI do CKD. Medzi skúmané rastlinné zdroje patria <em>Rheum officinale</em>, <em>Scutellaria baicalensis</em>, <em>Salvia miltiorrhiza</em>, <em>Astragalus membranaceus</em> a <em>Coptis chinensis</em>. Prehľad zahŕňa aj <em>Wolfiporia cocos</em>, hubu používanú v tradičných prípravkoch. Výsledok pre izolovanú látku nemožno automaticky preniesť na extrakt alebo viaczložkovú zmes. [1]</p>
<p>Experimentálne práce opisujú zmeny aktivácie Smad3 a rovnováhy medzi Smad3 a inhibičným proteínom Smad7. Autori spomínajú aj súvislosti s oxidačným stresom, zápalom a ferroptózou. Keď prípravok ovplyvní viac dráh naraz, zmena signálu Smad sama osebe neurčí, ktorá dráha sprostredkovala pozorovaný účinok. Hodnotenie prehľadu v tomto článku vychádza z publikovaného abstraktu. Plný text a údaje o jednotlivých prípravkoch sa nepodarilo overiť. [1]</p>
<h2>Od mechanizmu ku klinickému výsledku</h2>
<p>Príkladom rozdielu medzi biologickým cieľom a klinickým účinkom je randomizovaná štúdia fázy 2, v ktorej Voelker a spoluautori skúmali neutralizačnú protilátku proti TGF‑β1 u 416 pacientov s diabetickou nefropatiou. Liečba nepreukázala spomalenie straty funkcie obličiek a štúdiu ukončili predčasne pre nízku pravdepodobnosť dosiahnutia primárneho cieľa. Štúdia hodnotila protilátku. Pre bylinné prípravky by bolo potrebné samostatne preukázať účinok v presne určenej populácii s reprodukovateľným zložením prípravku, primeraným sledovaním a klinicky významnými ukazovateľmi. [1, 2]</p>
<h2>Čo z toho vyplýva pre ambulanciu</h2>
<p>Experimentálne ovplyvnenie dráhy TGF‑β/Smad neposkytuje podklad na odporúčanie týchto prípravkov ako liečby fibrózy obličiek. Pri revízii liekov má význam zaznamenať aj názvy a zloženie užívaných bylinných prípravkov. KDIGO odporúča preveriť ich používanie a obmedziť prípravky, ktoré môžu pacientom s CKD škodiť. [1, 3]</p>
<hr><h2>Zdroje</h2>
<ol>
<li><small><em>Baoyi Shao, Ziyun Xu, Hao Lu, Jianbo Guo, Wei Biao, Meicen Wu, Yifan Wang, Shen Chen, Huiyao Lan, Haiyong Chen. Transforming Growth Factor Beta/Smad Signaling: A Therapeutic Target of Chinese Herbal Medicine for Kidney Disease. Semin Nephrol. 2026;151757. Online 6. novembra 2026. <a href="https://doi.org/10.1016/j.semnephrol.2026.151757" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42995132/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>James Voelker, Paul H. Berg, Matthew Sheetz, Kevin Duffin, Tong Shen, Brian Moser, Tom Greene, Samuel S. Blumenthal, Ivan Rychlik, Yoram Yagil, Philippe Zaoui, Julia B. Lewis. Anti-TGF-β1 Antibody Therapy in Patients with Diabetic Nephropathy. J Am Soc Nephrol. 2017;28(3):953-962. <a href="https://doi.org/10.1681/ASN.2015111230" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/27647855/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. Praktický bod 4.1.3. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_tgf-beta-smad-bylinne-pripravky-fibroza-obliciek_article',
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
