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
    'title'        => 'Inhibítory SGLT2 pri inkrementálnej hemodialýze a reziduálna diuréza',
    'slug'         => 'sglt2-diureza-inkrementalna-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V malej dvojcentrovej kohorte pri inhibícii SGLT2 stúpla diuréza. Čo ukázali merania klírensu a čo z výsledku vyplýva pre predpis dialýzy?',
    'content'      => <<<'HTML'
<figure><a href="img/sglt2-diureza-inkrementalna-hemodialyza.webp" target="_blank" rel="noopener noreferrer"><img src="img/sglt2-diureza-inkrementalna-hemodialyza.webp" alt="Zvyšková funkcia obličiek pri hemodialýze" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Zvyšková funkcia obličiek pri hemodialýze. Ilustračný obrázok.</figcaption></figure>
<p>V malej španielskej kohorte sa po začatí inkrementálnej hemodialýzy zvýšila 24-hodinová diuréza u pacientov užívajúcich inhibítor SGLT2. Výsledok, na ktorý upozornil ReachMD, sa týka objemu moču. Klírens močoviny ani kreatinínu sa v liečenej skupine štatisticky významne nezmenil. Štúdia preto otvára otázku, či by liečba mohla pomôcť udržať diurézu, a zatiaľ ponecháva jej vplyv na reziduálnu funkciu obličiek otvorený. [1]</p>

<h2>Čo ukázala dvojcentrová kohorta</h2>

<p>Retrospektívna štúdia zahŕňala 32 dospelých, ktorí začínali plánovanú hemodialýzu s jedným alebo dvoma výkonmi týždenne. Inhibítor SGLT2 užívalo 15 pacientov z jedného centra. Porovnávaciu skupinu tvorilo 17 pacientov z druhého centra. Zo štúdie boli vylúčení okrem iných pacienti s diurézou ≤200 ml za 24 hodín a pacienti, ktorí začínali dialýzu urgentne. Autori sledovali diurézu, reziduálny klírens močoviny (KrU) a klírens kreatinínu počas 12 mesiacov. [1]</p>

<p>V liečenej skupine sa priemerný objem moču za 24 hodín zvýšil približne z 1 620 na 2 193 ml. Zmena oproti východiskovej hodnote bola +573,3 ml (p &lt; 0,001). V porovnávacej skupine sa objem zmenil o −202,9 ml (p = 0,34). Obe hodnoty p sa týkajú zmien vnútri skupín. Autori rozdiel zmien medzi skupinami formálne netestovali. KrU a klírens kreatinínu mali v liečenej skupine nevýznamný vzostupný trend a v porovnávacej skupine nevýznamný zostupný trend. [1]</p>

<h2>Liečba sa v tejto štúdii nedá oddeliť od vplyvu centra</h2>

<p>Všetci liečení pacienti pochádzali z jedného pracoviska. Iba toto pracovisko používalo pri určovaní suchej hmotnosti kombináciu klinického vyšetrenia, bioimpedancie a ultrazvuku pri lôžku. Skupiny sa líšili aj niektorými východiskovými charakteristikami vrátane zastúpenia diabetu 2. typu a reziduálnej funkcie obličiek. Pri takomto usporiadaní nemožno spoľahlivo odhadnúť, aká časť pozorovanej zmeny súvisela s liekom, s výberom pacientov alebo s vedením dialyzačnej liečby. Nezaznamenaná ketoacidóza pri 15 exponovaných pacientoch zároveň poskytuje len obmedzené údaje o bezpečnosti. [1]</p>

<h2>Diuréza a klírens majú pri predpise odlišnú úlohu</h2>

<p>Väčší objem moču môže uľahčiť bilanciu tekutín. Časovaný zber moču s výpočtom KrU pomáha určiť, koľko močoviny obličky ešte odstraňujú medzi výkonmi. Pri vyššej diuréze preto treba reziduálny klírens ďalej merať. Pri úvahe o frekvencii hemodialýzy rozhoduje jeho trend spolu s celkovou adekvátnosťou liečby, stavom hydratácie, kontrolou draslíka a príznakmi urémie. [1, 2]</p>

<p>KDIGO pri už zavedenej liečbe inhibítorom SGLT2 pripúšťa pokračovanie aj pri poklese eGFR pod 20 ml/min/1,73 m², pokiaľ je liečba tolerovaná a nezačala sa liečba nahrádzajúca funkciu obličiek. Táto kohorta neposkytuje dostatočný podklad na zavedenie inhibítora SGLT2 po začatí hemodialýzy iba s cieľom zachovať diurézu ani na predĺženie intervalu medzi výkonmi na základe vyššieho objemu moču. [1, 3]</p>
<p><a href="article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek">Súvisiaci článok o inkrementálnej hemodialýze a reziduálnej funkcii obličiek</a></p>
<hr>
<h2>Zdroje</h2>
<p><small><em>SGLT2 Inhibitors in Incremental Hemodialysis: Urine Output. <a href="https://reachmd.com/news/sglt2-inhibitors-in-incremental-hemodialysis-urine-output/2488920/" target="_blank" rel="noopener noreferrer">ReachMD</a>.</em></small></p>
<ol>
<li><small><em>Avinash Chandu Nanwani, Celia Rodríguez Tudero, Francisco Valga, Esperanza Moral Berrio, Javier Deira, Jesús Hernández Vaquero, Gabriel de Arriba. Effects of Sodium-Glucose Cotransporter Type 2 Inhibitors on Residual Kidney Function in Patients Undergoing Incremental Hemodialysis: A Two-Center, Retrospective, Exploratory Cohort Study. Medicina (Kaunas). 2026;62(10):1972. <a href="https://doi.org/10.3390/medicina62101972" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42942503/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13707212/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>National Kidney Foundation. KDOQI Clinical Practice Guideline for Hemodialysis Adequacy: 2015 Update. Am J Kidney Dis. 2015;66(5):884-930. Odporúčania 3.2 a 3.3. <a href="https://doi.org/10.1053/j.ajkd.2015.07.015" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/26498416/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. Praktický bod 3.7.1. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_sglt2-diureza-inkrementalna-hemodialyza_article',
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
