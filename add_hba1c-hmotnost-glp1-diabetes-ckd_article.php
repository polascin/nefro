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
    'title'        => 'Keď sa HbA1c a hmotnosť pri liečbe GLP-1 menia rozdielne',
    'slug'         => 'hba1c-hmotnost-glp1-diabetes-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Ako u pacienta s diabetom 2. typu a chronickou chorobou obličiek interpretovať nesúlad medzi HbA1c a poklesom hmotnosti.',
    'content'      => <<<'HTML'
<p>Pri liečbe založenej na GLP‑1 môže HbA1c klesnúť aj pri malom úbytku hmotnosti. Inokedy pacient schudne, ale glykémie zostávajú nad cieľom. Julie Pecková v Medscape opisuje, ako odborníci pri takomto nesúlade zvažujú glykémiu, obezitu a pridružené ochorenia. Pri chronickej chorobe obličiek (CKD) treba navyše overiť, či zmena hmotnosti odráža úbytok tukového tkaniva a či HbA1c spoľahlivo vystihuje glykémiu. [1, 2, 3]</p>
<h2>HbA1c klesol, hmotnosť sa výrazne nezmenila</h2>
<p>Zlepšenie glykémie má klinický význam aj pri malom úbytku hmotnosti. Ak však obezita naďalej obmedzuje pohyb alebo zhoršuje pridružené ochorenia, zostáva samostatným cieľom liečby. ADA odporúča u dospelých s diabetom 2. typu a nadhmotnosťou alebo obezitou stanoviť ciele pre glykémiu aj hmotnosť a prispôsobiť postup zdravotnému stavu a preferenciám pacienta. Pri CKD treba pri hodnotení hmotnosti zohľadniť aj zmeny hydratácie. Ústup edémov môže vysvetliť časť poklesu hmotnosti a retencia tekutín môže úbytok tkaniva zakryť. [2, 3]</p>
<h2>Hmotnosť klesla, HbA1c zostáva nad cieľom</h2>
<p>Pri pokročilej CKD, najmä pri dialýze, je HbA1c menej spoľahlivý. Interpretáciu môže ovplyvniť anémia, transfúzia alebo liečba stimulujúca erytropoézu. Pri nesúlade s domácimi meraniami pomôže profil kapilárnej glukózy alebo kontinuálne monitorovanie glukózy. Ak merania potvrdia pretrvávajúcu hyperglykémiu, treba prehodnotiť liečbu aj pri priaznivom vývoji hmotnosti. Pri nechcenom chudnutí alebo slabosti treba posúdiť príjem potravy a funkčný stav. Pri symptomatickej hyperglykémii s nechceným úbytkom hmotnosti treba myslieť aj na katabolizmus. [2, 3]</p>
<h2>Ochrana obličiek má vlastné klinické ukazovatele</h2>
<p>V štúdii FLOW u pacientov s diabetom 2. typu a albuminurickou CKD zaznamenali primárny kombinovaný ukazovateľ u 331 z 1 767 účastníkov so semaglutidom a u 410 z 1 766 s placebom (HR 0,76, 95 % interval spoľahlivosti 0,66 až 0,88). Ukazovateľ zahŕňal zlyhanie obličiek, pretrvávajúci pokles eGFR aspoň o 50 % alebo úmrtie z obličkových či kardiovaskulárnych príčin. Výsledok sa vzťahuje na skúmanú populáciu. Samotná zmena HbA1c alebo hmotnosti neumožňuje určiť veľkosť ochrany obličiek u jednotlivca. [4]</p>
<hr><h2>Zdroje</h2>
<ol>
<li><small><em>Julie Peck. When A1c and Weight Loss Don’t Agree: Which Should Drive Obesity Treatment? Medscape. 6. novembra 2026. <a href="https://www.medscape.com/viewarticle/when-a1c-and-weight-loss-dont-agree-which-should-drive-2026a10016hp" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li>
<li><small><em>American Diabetes Association Professional Practice Committee for Diabetes. Obesity and Weight Management for the Prevention and Treatment of Diabetes. Standards of Care in Diabetes 2026, oddiel 8. <a href="https://doi.org/10.2337/dc26-s008" target="_blank" rel="noopener noreferrer">DOI</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Diabetes Work Group. KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. Kidney Int. 2022;102(5S):S1-S127. <a href="https://doi.org/10.1016/j.kint.2022.06.008" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36272764/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_hba1c-hmotnost-glp1-diabetes-ckd_article',
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
