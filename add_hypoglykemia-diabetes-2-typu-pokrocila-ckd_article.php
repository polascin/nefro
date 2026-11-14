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
    'title'        => 'Hypoglykémia pri diabete 2. typu a pokročilej chorobe obličiek',
    'slug'         => 'hypoglykemia-diabetes-2-typu-pokrocila-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Kedy pri pokročilej CKD doplniť HbA1c meraním glukózy a ako podľa zistených hypoglykémií upraviť liečbu diabetu 2. typu.',
    'content'      => <<<'HTML'
<p>Konsenzus ADA a EASD z roku 2026, ktorý v októbri spracoval Medscape, odporúča pri diabete 2. typu a krehkosti prehodnotiť lieky s rizikom hypoglykémie, najmä deriváty sulfonylmočoviny. Pri pokročilej chronickej chorobe obličiek (CKD) má táto revízia osobitný význam. HbA1c môže byť skreslený a ani pri presnom meraní neukáže, kedy a ako často glykémia klesá. [1, 2]</p>

<h2>Kedy HbA1c nestačí</h2>

<p>Spoľahlivosť HbA1c pri CKD G4 a G5 klesá, najmä pri dialýze. Skrátené prežívanie erytrocytov, liečba látkami stimulujúcimi erytropoézu a dopĺňanie železa môžu viesť k nižšiemu HbA1c, než by zodpovedalo nameraným glykémiám. Pri interpretácii treba zohľadniť aj nedávnu transfúziu. Pokles HbA1c po začatí liečby anémie preto sám osebe nepotvrdzuje zlepšenie glykémie. [2]</p>

<p>HbA1c navyše nevystihuje variabilitu glykémie. Pri podozrení na nočné hypoglykémie, pri nesúlade HbA1c s domácimi meraniami alebo pri epizódach slabosti počas dialýzy pomôže kontinuálne monitorovanie glukózy (CGM). Pri hemodialýze je užitočné porovnať deň s dialýzou a deň bez nej, posúdiť čas výskytu nízkych hodnôt a zohľadniť jedlo a podanie inzulínu. Ak údaj zo senzora nezodpovedá príznakom alebo sa glukóza rýchlo mení, treba hodnotu podľa okolností overiť glukomerom. Pri nedostupnosti CGM možno zvoliť cielené kapilárne merania v čase predpokladaných poklesov. [1, 2, 3]</p>

<h2>Liečbu upraviť podľa priebehu glykémie</h2>

<p>U človeka s krehkosťou a opakovanými hypoglykémiami treba preveriť najmä inzulín a deriváty sulfonylmočoviny. Pomôže súpis skutočne užívaných liekov, časov podania, vynechaných jedál a zmien príjmu či hmotnosti. Podľa vzorca glykémií možno znížiť intenzitu liečby s rizikom hypoglykémie, zjednodušiť inzulínový režim alebo zvoliť liečbu s nižším rizikom. Po úprave je potrebné skontrolovať, či ustúpili nízke hodnoty a či sa neobjavila symptomatická hyperglykémia. [1, 3]</p>

<p>Pri CKD bez dialýzy KDIGO odporúča individualizovať cieľ HbA1c v rozmedzí od &lt;6,5 % do &lt;8,0 %. Výber cieľa závisí od komorbidít, očakávaného prínosu liečby a rizika hypoglykémie. Toto rozpätie sa vzťahuje na pacientov bez dialýzy. Pri veľmi zlom zdravotnom stave ADA uprednostňuje pred rozhodovaním podľa cieľového HbA1c prevenciu hypoglykémie a symptomatickej hyperglykémie. [2, 3]</p>

<p>Pri zmene liečby sa osobitne posudzuje potreba znižovať glykémiu a indikácia na ochranu srdca a obličiek. Hodnota HbA1c v cieľovom rozmedzí sama osebe neurčuje, či má pacient naďalej prínos z lieku s preukázaným kardiorenálnym účinkom. Pri pokračovaní treba zohľadniť štádium CKD, znášanlivosť a indikáciu konkrétneho lieku. Údaje z populácií bez dialýzy sa na pacientov liečených dialýzou prenášajú len v rozsahu, ktorý umožňujú dostupné dôkazy. [1, 2, 3]</p>

<h2>Modelová situácia z nefrologickej ambulancie</h2>

<p>Pacient s diabetom 2. typu na hemodialýze užíva bazálny inzulín a po začatí liečby anémie mu klesol HbA1c. Po návrate z dialýzy má občas slabosť a pred večerou si nameral nízku glykémiu. Pri najbližšej revízii má význam porovnať priebeh glykémie počas dialyzačných a nedialyzačných dní, zaznamenať jedlo a časy podania inzulínu a zistiť, či sa pokles opakuje aj v noci. Podľa týchto údajov možno upraviť inzulínový režim a skontrolovať účinok zmeny. Samotný pokles HbA1c na takéto rozhodnutie nestačí. [2, 3]</p>

<p><a href="article.php?slug=konsenzus-ada-easd-2026-diabetes-2-typu-nefrologia">Súvisiaci článok o konsenze ADA a EASD 2026</a></p>
<hr>
<h2>Zdroje</h2>
<p><small><em>Management of Type 2 Diabetes. Medscape Guideline Essentials. 8. októbra 2026. <a href="https://reference.medscape.com/cc2/p10/management-type-2-diabetes-ada-easd-guidelines-2026a100112t" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>
<ol>
<li><small><em>Melanie J Davies, Vanita R Aroda, Mandeep Bajaj, Nuha A ElSayed, Francesco Giorgino, Jennifer Green, Rita R Kalyani, Nisa M Maruthur, Chantal Mathieu, Sylvia E Rosas, Peter Rossing, Tommy Slater, Tsvetalina Tankova, Pinar Topsever, Apostolos Tsapas, John B Buse. Management of type 2 diabetes, 2026. A consensus report by the American Diabetes Association (ADA) and the European Association for the Study of Diabetes (EASD). Diabetologia. Online 2. októbra 2026. <a href="https://doi.org/10.1007/s00125-026-06855-7" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42825923/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Diabetes Work Group. KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. Kidney Int. 2022;102(5S):S1-S127. <a href="https://doi.org/10.1016/j.kint.2022.06.008" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36272764/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>American Diabetes Association Professional Practice Committee for Diabetes. 13. Older Adults: Standards of Care in Diabetes-2026. Diabetes Care. 2026;49(Suppl 1):S277-S296. <a href="https://doi.org/10.2337/dc26-S013" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41358888/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_hypoglykemia-diabetes-2-typu-pokrocila-ckd_article',
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
