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
    'title' => 'Choroba z depozície ľahkých reťazcov v obličke',
    'slug' => 'choroba-z-depozicie-lahkych-retazcov',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt' => 'Biopsia obličky odlišuje depozíciu ľahkých reťazcov od iných monoklonálnych lézií. Kohortové údaje spájajú hĺbku hematologickej odpovede s vývojom funkcie obličiek.',
    'content'      => <<<'HTML'
<p>Pri chorobe z depozície ľahkých reťazcov (LCDD, z angl. <em>light chain deposition disease</em>) poškodzujú obličku neamyloidové depozitá monoklonálneho ľahkého reťazca imunoglobulínu. Klinický obraz môže zahŕňať proteinúriu, artériovú hypertenziu a pokles glomerulovej filtrácie. Rozhodujúca je biopsia obličky: ukáže typ lézie a pomôže určiť, či monoklonálny imunoglobulín vysvetľuje poškodenie obličiek [1, 2].</p>
<figure><img src="img/choroba-z-depozicie-lahkych-retazcov.webp" alt="Objektív laboratórneho mikroskopu nad podložným sklíčkom" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená s podporou umelej inteligencie.</figcaption></figure>

<h2>Čo má ukázať biopsia</h2>
<p>LCDD patrí do skupiny chorôb z depozície monoklonálnych imunoglobulínov (MIDD, z angl. <em>monoclonal immunoglobulin deposition disease</em>). Pri LCDD sú v depozitách ľahké reťazce. Pri ďalších formách MIDD sa ukladajú ťažké reťazce alebo oba typy. Svetelná mikroskopia môže ukázať nodulárnu glomerulosklerózu, ktorá pripomína diabetickú nefropatiu. Uzly však môžu chýbať. Typickým nálezom pri imunofluorescencii je lineárne farbenie jedného typu ľahkého reťazca pozdĺž tubulárnych bazálnych membrán, často aj pozdĺž glomerulových bazálnych membrán. Elektrónová mikroskopia ukazuje jemné granulárne elektrónovo denzné depozitá. Depozitá pri LCDD sú pri farbení konžskou červeňou negatívne; pri AL amyloidóze má zásadný význam pozitivita tohto farbenia a fibrilárna štruktúra depozít. Pri valčekovej nefropatii sú dominantným nálezom intratubulárne valčeky. Valčeková nefropatia a LCDD môžu koexistovať [1, 2, 3].</p>

<h2>Od nálezu v obličke k identifikácii klonu</h2>
<p>Pri podozrení na monoklonálnu léziu sa dopĺňa elektroforéza a imunofixácia séra a moču a stanovenie voľných ľahkých reťazcov v sére. Pri interpretácii koncentrácií a pomeru κ/λ treba zohľadniť funkciu obličiek a použitú analytickú metódu. Typ cirkulujúceho reťazca sa hodnotí spolu s typom reťazca v depozitách. Hematologické vyšetrenie vrátane vyšetrenia kostnej drene pomáha určiť pôvod klonu a odlíšiť mnohopočetný myelóm od monoklonálnej gamapatie s renálnym významom (MGRS, z angl. <em>monoclonal gammopathy of renal significance</em>). Aj malý klon bez samostatnej hematologickej indikácie na liečbu môže vytvárať nefrotoxický imunoglobulín [2].</p>

<h2>Hematologická odpoveď a funkcia obličiek</h2>
<p>Sayed a spoluautori prospektívne sledovali 53 pacientov s biopticky potvrdenou LCDD. Medián sledovania bol 6,2 roka. V analýze podľa hematologickej odpovede sa pri kompletnej alebo veľmi dobrej parciálnej odpovedi glomerulová filtrácia zvyšovala v priemere o 6,1 ml/min za rok. Pri parciálnej odpovedi alebo bez odpovede klesala v priemere o 6,5 ml/min za rok (p &lt; 0,009). Výsledok ukazuje súvislosť medzi hĺbkou hematologickej odpovede a vývojom funkcie obličiek. Skupiny vznikli podľa dosiahnutej odpovede po liečbe a režimy boli rôznorodé. Rozdiel preto nemožno pripísať konkrétnemu režimu ani použiť na predpoveď individuálneho vývoja [3].</p>
<p>V retrospektívnom súbore Cohena a spoluautorov dosiahlo renálnu odpoveď 26 zo 49 pacientov liečených režimami s bortezomibom. Súbor zahŕňal viaceré formy MIDD a nemal kontrolnú skupinu. Európsky konsenzus odporúča posúdiť liečbu zameranú na klon individuálne, s ohľadom na rozsah orgánového poškodenia, funkciu obličiek, riziká liečby a možnosť transplantácie. Pri sledovaní je užitočné hodnotiť hematologickú odpoveď spolu s vývojom odhadovanej glomerulovej filtrácie a proteinúrie, pretože ide o rozdielne ukazovatele [2, 4].</p>

<h2>Transplantácia obličky</h2>
<p>U pacienta vhodného na transplantáciu treba vopred posúdiť kontrolu klonu a riziko návratu depozície v štepe. Európsky konsenzus považuje kompletnú alebo veľmi dobrú parciálnu hematologickú odpoveď za priaznivý predpoklad pri posudzovaní kandidáta. Pri slabšej odpovedi sú údaje obmedzené a rozhodnutie patrí do spoločného hodnotenia transplantačného nefrológa a hematológa [2, 3].</p>
<hr>
<p><small><em><strong>Zdroj:</strong> [1] Eric J Vick. Light-Chain Deposition Disease. Medscape Reference. Aktualizované 23. októbra 2026. <a href="https://emedicine.medscape.com/article/202585-overview" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>
<p><small><em>[2] Ben Sprangers, Camille Cohen, Viviane Gnemmi, Amir Shabaka, Gema Fernandez-Juarez, Dominique van Midden, Eric Steenbergen, Paolo Milani, Marguerite Vignon, Benjamin Wilde, Ute Hegenbart, Jack F Wetzels. Executive summary of the European consensus report on the diagnosis and treatment of monoclonal gammopathy of renal significance. Clin Kidney J. 2026. 19(6), sfag163. <a href="https://doi.org/10.1093/ckj/sfag163" target="_blank" rel="noopener noreferrer">DOI 10.1093/ckj/sfag163</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42338690/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://academic.oup.com/ckj/article/doi/10.1093/ckj/sfag163/8694705" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[3] Rabya H Sayed, Ashutosh D Wechalekar, Janet A Gilbertson, Paul Bass, Shameem Mahmood, Sajitha Sachchithanantham, Marianna Fontana, Ketna Patel, Carol J Whelan, Helen J Lachmann, Philip N Hawkins, Julian D Gillmore. Natural history and outcome of light chain deposition disease. Blood. 2015. 126(26), 2805-10. <a href="https://doi.org/10.1182/blood-2015-07-658872" target="_blank" rel="noopener noreferrer">DOI 10.1182/blood-2015-07-658872</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/26392598/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://ashpublications.org/blood/article/126/26/2805/34774/Natural-history-and-outcome-of-light-chain" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[4] Camille Cohen, Bruno Royer, Vincent Javaugue, Raphael Szalat, Khalil El Karoui, Alexis Caulier, Bertrand Knebelmann, Arnaud Jaccard, Sylvie Chevret, Guy Touchard, Jean-Paul Fermand, Bertrand Arnulf, Frank Bridoux. Bortezomib produces high hematological response rates with prolonged renal survival in monoclonal immunoglobulin deposition disease. Kidney Int. 2015. 88(5), 1135-43. <a href="https://doi.org/10.1038/ki.2015.201" target="_blank" rel="noopener noreferrer">DOI 10.1038/ki.2015.201</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/26176826/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://linkinghub.elsevier.com/retrieve/pii/S0085253815609930" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
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
    'log_prefix' => 'add_choroba-z-depozicie-lahkych-retazcov_article',
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
