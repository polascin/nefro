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
    'title'        => 'Rejekcia obličkového štepu bez detegovateľných DSA v registri KOTRY',
    'slug'         => 'rejekcia-oblickoveho-stepu-bez-dsa-kotry',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Kórejský register porovnal stratu štepu pri troch formách rejekcie. Výsledky treba čítať spolu s definíciou mikrovaskulárneho zápalu podľa Banff.',
    'content'      => <<<'HTML'
<p>V kórejskom transplantačnom registri KOTRY sa strata obličkového štepu vyskytla aj u príjemcov s biopsiou klasifikovanou ako protilátkami sprostredkovaná rejekcia (ABMR) bez detegovateľných protilátok špecifických proti darcovi (DSA). Upravené porovnania s ostatnými skupinami však boli nepresné. Pri prenose výsledkov do praxe záleží aj na tom, ako autori definovali DSA-negatívnu ABMR a ako sa táto definícia prekrýva s dnešnou klasifikáciou Banff. [1, 2]</p>

<h2>Čo ukázal register KOTRY</h2>

<p>Z 10 391 príjemcov obličky v registri splnilo kritériá analýzy 740 pacientov. Autori zaradili 90 do skupiny s DSA-negatívnou ABMR, 124 do skupiny s DSA-pozitívnou ABMR a 526 do skupiny s rejekciou sprostredkovanou T-lymfocytmi (TCMR). Pri mediáne sledovania 3,1 roka stratilo štep 93 pacientov (12,6 %). V jednotlivých skupinách išlo o 14 z 90, 15 zo 124 a 64 z 526 pacientov. Tieto podiely opisujú udalosti počas sledovania bez zohľadnenia jeho dĺžky a rozdielov medzi skupinami. [1]</p>

<p>V upravenom modeli s konkurenčnými rizikami bola referenčnou skupinou DSA-negatívna ABMR. Pomer hazardov straty štepu (HR) bol pri DSA-pozitívnej ABMR 0,78 (95 % interval spoľahlivosti 0,36 až 1,69; p = 0,52) a pri TCMR 0,64 (0,35 až 1,18; p = 0,15). Oba intervaly zahŕňajú hodnotu 1 a pripúšťajú klinicky významné rozdiely v oboch smeroch. Záver autorov o horšej prognóze oboch foriem ABMR oproti TCMR tieto dve porovnania samy osebe nepotvrdzujú. Priame upravené porovnanie DSA-pozitívnej ABMR s TCMR abstrakt neuvádza. [1]</p>

<h2>Ako nález zaradiť podľa Banff</h2>

<p>Banff označuje mikrovaskulárny zápal (MVI) bez detegovateľných DSA a bez pozitivity C4d v peritubulárnych kapilárach za opisný fenotyp s nejasnou príčinou. Pri interpretácii treba hodnotiť glomerulitídu a peritubulárnu kapilaritídu spolu s ostatnými nálezmi. Pri súčasnej TCMR, hraničných zmenách alebo infekcii samotná peritubulárna kapilaritída nestačí na splnenie histologického kritéria tohto fenotypu. Pri vhodnom histologickom náleze môže pozitivita C4d podporiť diagnózu ABMR aj pri negatívnom vyšetrení DSA. Z dostupného abstraktu KOTRY sa nedá overiť, koľko prípadov označených ako DSA-negatívna ABMR spĺňalo dnešné kritériá pre MVI s negatívnymi DSA aj C4d. [1, 2]</p>

<h2>Mechanistická kohorta ukazuje viac možných vysvetlení</h2>

<p>V exploračnej kohorte 56 pacientov sa jednotlivé vyšetrenia vykonali len u časti súboru. Nezhodu MICA našli u 16 z 19 a nezhodu MICB u 15 z 19 vyšetrených. Autoprotilátky súvisiace s obličkou zistili u 21 z 52 a konfiguráciu <em>missing self</em> u 9 z 18. Tá môže umožniť aktiváciu NK buniek, keď na bunkách darcu chýba príslušný inhibičný signál. Genetická nezhoda sama osebe nedokazuje prítomnosť protilátky ani príčinu poškodenia. Rozdielne menovatele a malé počty obmedzujú odhad, ako často tieto mechanizmy pôsobia v celej populácii. [1, 2]</p>

<p>Pri nejasnom bioptickom náleze má význam spoločná revízia histológie, C4d a dostupných vyšetrení DSA s transplantačným patológom a HLA laboratóriom. Pri rozhodovaní o imunosupresii treba zohľadniť aj vývoj funkcie štepu, proteinúriu a ďalšie možné príčiny poškodenia. Register porovnával prognózu skupín. Účinnosť konkrétnej liečby pre tento fenotyp z neho nemožno určiť. [1, 2]</p>

<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Byounghwi Ko, Younhee Park, Sung Min Kim, Young Jin Kim, Hee Byung Koh, Hyung Woo Kim, Honglin Piao, Virithy Lon, Minsun Jung, Hyun Jeong Kim, Juhan Lee, Kyu Ha Huh, Beom Seok Kim, Myoung Soo Kim, Jin Sug Kim, Seungyeup Han, Young Joo Kwon, Jaeseok Yang. Clinical Outcomes and Associated Factors of Antibody-mediated Rejection without Detectable Donor-specific Antibodies in Kidney Transplantation. Am J Nephrol. Online 6. novembra 2026. Výsledky spracované z abstraktu. <a href="https://doi.org/10.1159/ajn/ablag034" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42993151/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Banff Foundation for Allograft Pathology. Current Reference Guide to the Banff Classification. <a href="https://banfffoundation.org/central-repository-for-banff-classification-resources-3/" target="_blank" rel="noopener noreferrer">Klasifikácia Banff</a>.</em></small></li>
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
    'log_prefix' => 'add_rejekcia-oblickoveho-stepu-bez-dsa-kotry_article',
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
