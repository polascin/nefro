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
    'title'        => 'hs-CRP pri chronickej chorobe obličiek a riziko klinických príhod',
    'slug'         => 'hs-crp-riziko-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Vo švédskej kohorte pacientov s CKD G3 až G5 sa vyššie hs-CRP spájalo najmä s celkovou úmrtnosťou. Súvislosť so zlyhaním obličiek vyžadujúcim náhradu ich funkcie bola slabšia.',
    'content'      => <<<'HTML'
<figure><img src="img/hs-crp-riziko-ckd.webp" alt="Skúmavka so vzorkou krvi pred anatomickým modelom obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia laboratórneho vyšetrenia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Vo švédskej kohorte pacientov s chronickou chorobou obličiek (CKD) sa vyššia koncentrácia C-reaktívneho proteínu stanovená vysokocitlivou metódou (hs-CRP) spájala najvýraznejšie s celkovou úmrtnosťou. Súvisela aj s hospitalizáciou pre srdcové zlyhávanie, akútnym poškodením obličiek a závažnými kardiovaskulárnymi príhodami. Súvislosť so zlyhaním obličiek vyžadujúcim náhradu ich funkcie bola slabšia a menila sa podľa štádia CKD [1, 2].</p>

<h2>Čo sledoval švédsky register</h2>
<p>Mazhar a spoluautori použili údaje zo Švédskeho nefrologického registra z rokov 2008 až 2023. Analyzovali 23 008 dospelých s CKD G3 až G5 v nefrologickej starostlivosti, ktorí pri vstupe nepodstupovali dialýzu a mali dostupné meranie hs-CRP. Priemerný vek bol približne 71 rokov a medián odhadovanej glomerulovej filtrácie 25 ml/min/1,73 m². Počas sledovania s mediánom 3,9 roka autori vyhodnotili 94 500 meraní hs-CRP. Medián koncentrácie bol 4,0 mg/l a tri štvrtiny pacientov mali hodnotu aspoň 2 mg/l [1, 2].</p>
<p>Autori aktualizovali hodnoty hs-CRP v priebehu sledovania a súvislosti odhadovali Coxovými modelmi pre jednotlivé udalosti. Pri výsledkoch, ktorým môže predísť úmrtie, je dôležité, že takto odhadnutý pomer hazardov sa vzťahuje na pacientov, ktorí sú v danom čase ešte vystavení možnosti príhody. Nevyjadruje priamo individuálnu pravdepodobnosť príhody do určitého dátumu [1].</p>

<h2>Najvýraznejšia súvislosť sa týkala úmrtnosti</h2>
<p>Pri koncentrácii hs-CRP aspoň 2 mg/l oproti hodnotám pod 2 mg/l boli upravené pomery hazardov nasledovné. Počty udalostí sa vzťahujú na celú kohortu pre daný výsledok [1, 2].</p>
<table>
<caption>Upravené pomery hazardov podľa koncentrácie hs-CRP</caption>
<thead><tr><th scope="col">Výsledok</th><th scope="col">Počet udalostí</th><th scope="col">Pomer hazardov (95 % interval spoľahlivosti)</th></tr></thead>
<tbody>
<tr><th scope="row">Úmrtie z akejkoľvek príčiny</th><td>12 645</td><td>1,43 (1,37 až 1,50)</td></tr>
<tr><th scope="row">Hospitalizácia pre srdcové zlyhávanie</th><td>8 173</td><td>1,29 (1,22 až 1,37)</td></tr>
<tr><th scope="row">Akútne poškodenie obličiek</th><td>3 943</td><td>1,28 (1,18 až 1,38)</td></tr>
<tr><th scope="row">Závažná kardiovaskulárna príhoda</th><td>5 480</td><td>1,20 (1,12 až 1,28)</td></tr>
<tr><th scope="row">Zlyhanie obličiek vyžadujúce náhradu ich funkcie</th><td>6 177</td><td>1,09 (1,02 až 1,15)</td></tr>
</tbody></table>
<p>Zložený kardiovaskulárny ukazovateľ zahŕňal infarkt myokardu, ischemickú cievnu mozgovú príhodu alebo kardiovaskulárne úmrtie. Keď autori hodnotili hs-CRP ako spojitú premennú, pri väčšine výsledkov sa hazard menil výraznejšie v dolnej časti rozsahu koncentrácií a pri vyšších hodnotách sa krivka splošťovala. Pri zlyhaní obličiek vyžadujúcom náhradu ich funkcie bola krivka pomerne plochá. Súvislosť bola najvýraznejšia pri CKD G4. Pri G3 a G5 štatisticky významnú súvislosť v tejto analýze nepreukázali. Tieto výsledky neustanovujú hranicu, od ktorej by sa mala meniť liečba [1, 2].</p>

<h2>Ako nález zohľadniť v ambulancii</h2>
<p>hs-CRP je nešpecifický ukazovateľ zápalu. Vyššiu hodnotu treba posudzovať spolu s klinickým stavom a dôvodom odberu, napríklad pri podozrení na infekciu alebo pri inom akútnom ochorení. Do kohorty vstúpili iba pacienti s dostupným meraním a približne tretine chýbali údaje o albuminúrii. Pridružené ochorenia aj okolnosti, ktoré viedli k odberu, mohli ovplyvniť zistené súvislosti. Štúdiu podporila spoločnosť Novo Nordisk spolu s verejnými a neziskovými zdrojmi. Medzi autormi boli zamestnanci spoločnosti [1, 2].</p>
<p>V skoršej švédskej kohorte dospelých s aterosklerotickým kardiovaskulárnym ochorením sa vyššie CRP tiež spájalo s akútnym poškodením obličiek. Táto kohorta mala odlišné vstupné kritériá aj spôsob hodnotenia obličkových výsledkov [3].</p>
<p>Pre odhad absolútneho rizika zlyhania obličiek pri CKD G3 až G5 odporúča KDIGO externe overenú predikčnú rovnicu, napríklad KFRE, ktorá v štvorpremennej verzii pracuje s vekom, pohlavím, eGFR a pomerom albumínu ku kreatinínu v moči. Švédska analýza hodnotila asociácie. Neurčovala, či pridanie hs-CRP k takému modelu zlepší rozhodovanie, či pravidelné meranie zlepší výsledky liečby alebo či zásah zameraný na zníženie hs-CRP prinesie klinický úžitok [1, 4].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Faizan Mazhar, Minjung Han, Katherine R Tuttle, Aurora Caldinelli, Magnus Fugger, Sofia Gerward, Jimmi Mathisen, Brendon L Neuen, Marie Evans, Juan-Jesus Carrero. High sensitivity C-reactive protein and the risk of cardio-kidney outcomes in adults with moderate to severe chronic kidney disease: a nationwide study. Nephrol Dial Transplant. 2026, online 16. októbra, gfag240. <a href="https://doi.org/10.1093/ndt/gfag240">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42886061/">PubMed 42886061</a></em></small></li>
<li><small><em>Medscape. High Levels of High-Sensitivity C-Reactive Protein Tied to Higher Cardiovascular and Kidney Risks in Advanced CKD. 29. októbra 2026. <a href="https://www.medscape.com/viewarticle/high-levels-high-sensitivity-c-reactive-protein-tied-higher-2026a10014o7">Redakčný súhrn</a></em></small></li>
<li><small><em>Faizan Mazhar, Edouard L Fu, Anne-Laure Faucon, Paul Hjemdahl, Jimmi Mathisen, Iram Faqir Muhammad, Oscar Plunde, Vlado Perkovic, Katherine R Tuttle, Juan-Jesus Carrero. Systemic Inflammation and the Risks of Adverse Kidney Outcomes in Adults With Atherosclerotic Cardiovascular Disease. Am J Kidney Dis. 2025;86(3):314-323.e1. <a href="https://doi.org/10.1053/j.ajkd.2025.04.011">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40484340/">PubMed 40484340</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/">PubMed 38490803</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">Plný text KDIGO</a></em></small></li>
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
    'log_prefix' => 'add_hs_crp_riziko_ckd',
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
