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
    'title'        => 'Semaglutid v štúdii SELECT a obličkové výsledky bez diabetu',
    'slug'         => 'semaglutid-oblickove-vysledky-select',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V štúdii SELECT bola pretrvávajúca makroalbuminúria najčastejšou zložkou obličkového ukazovateľa. Pri závažných obličkových príhodách zostal účinok neistý.',
    'content'      => <<<'HTML'
<figure><img src="img/semaglutid-oblickove-vysledky-select.webp" alt="Nádobka na vzorku moču a injekčné pero pri modeli obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V štúdii SELECT sa pri semaglutide vyskytlo menej udalostí v päťzložkovom obličkovom ukazovateli. Najčastejšou zložkou bola pretrvávajúca makroalbuminúria. Keď autori hodnotili iba závažné obličkové príhody bez makroalbuminúrie a bez kardiovaskulárneho úmrtia, zaznamenali 17 udalostí pri semaglutide a 27 pri placebe. Tento rozdiel nedosiahol štatistickú významnosť [1].</p>

<h2>Koho do SELECT zaradili</h2>
<p>SELECT bola dvojito zaslepená randomizovaná štúdia kardiovaskulárnych výsledkov. Zaradila 17 604 dospelých vo veku aspoň 45 rokov s indexom telesnej hmotnosti aspoň 27 kg/m² a preukázaným kardiovaskulárnym ochorením. Účastníci nemali diabetes. Dostávali podkožný semaglutid s cieľovou dávkou 2,4 mg raz týždenne alebo placebo popri štandardnej starostlivosti. Chronická choroba obličiek (CKD) nebola podmienkou zaradenia. Pacientov so zlyhaním obličiek v konečnom štádiu alebo s potrebou dialýzy štúdia vylučovala. Obličková analýza bola vopred plánovaná a sekundárna [1, 2].</p>

<h2>Makroalbuminúria a zložené ukazovatele</h2>
<p>Pôvodný päťzložkový ukazovateľ zahŕňal úmrtie z obličkových príčin, začatie dlhodobej liečby nahrádzajúcej funkciu obličiek, trvalú odhadovanú glomerulovú filtráciu (eGFR) pod 15 ml/min/1,73 m², trvalý pokles eGFR aspoň o 50 % oproti vstupu alebo vznik pretrvávajúcej makroalbuminúrie. Pri makroalbuminúrii bol rozhodujúci pomer albumínu ku kreatinínu v moči (UACR) nad 300 mg/g. Pretrvávanie laboratórnej odchýlky vyžadovalo najmenej dve nové merania s odstupom aspoň štyroch týždňov [1].</p>

<table><caption>Výsledky obličkovej analýzy SELECT</caption><thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Semaglutid</th><th scope="col">Placebo</th><th scope="col">Pomer hazardov (95 % interval spoľahlivosti)</th></tr></thead><tbody>
<tr><th scope="row">Pôvodný päťzložkový ukazovateľ</th><td>155 (1,8 %)</td><td>198 (2,2 %)</td><td>0,78 (0,63 až 0,96)</td></tr>
<tr><th scope="row">Pretrvávajúca makroalbuminúria</th><td>144 (1,6 %)</td><td>179 (2,0 %)</td><td>0,80 (0,64 až 1,00)</td></tr>
<tr><th scope="row">Štyri závažné obličkové zložky bez makroalbuminúrie</th><td>17 (0,2 %)</td><td>27 (0,3 %)</td><td>0,62 (0,33 až 1,14)</td></tr>
<tr><th scope="row">Štyri obličkové zložky a kardiovaskulárne úmrtie</th><td>239 (2,7 %)</td><td>289 (3,3 %)</td><td>0,82 (0,69 až 0,97)</td></tr>
</tbody></table>

<p>Počty vychádzajú z obrázka 2 a doplnkovej tabuľky 3 pôvodnej publikácie. Každý zložený ukazovateľ má vlastnú analýzu času do prvej udalosti. Výsledok bez makroalbuminúrie preto treba čítať priamo z doplnkovej tabuľky. Nedá sa vypočítať odčítaním počtov. Pri samotnej makroalbuminúrii uvádza obrázok 2 zaokrúhlené <i>p</i> = 0,05 a hornú hranicu intervalu 1,00. Ide o hraničný výsledok bez korekcie na viacnásobné porovnania [1].</p>

<h2>Čo vieme o závažných obličkových príhodách</h2>
<p>Pri štyroch obličkových zložkách bez makroalbuminúrie bol bodový odhad v prospech semaglutidu, no široký interval pripúšťal aj neprítomnosť účinku. Samostatné odhady pre trvalý pokles eGFR aspoň o 50 % (HR 0,57, 95 % interval spoľahlivosti od 0,27 do 1,14) a začatie dlhodobej náhrady funkcie obličiek (HR 0,66, od 0,17 do 2,32) boli nepresné. Priaznivý výsledok ukazovateľa po pridaní kardiovaskulárneho úmrtia sa vzťahuje na túto širšiu kombináciu udalostí [1].</p>
<p>Priemerná eGFR vypočítaná z kreatinínu klesala v celej populácii pri semaglutide o 0,39 ml/min/1,73 m² za rok pomalšie (95 % interval spoľahlivosti od 0,30 do 0,48). Údaj opisuje priemerný vývoj eGFR. Autori nemali merania cystatínu C, ktoré by pomohli posúdiť možný vplyv zmeny svalovej hmoty na kreatinín pri úbytku hmotnosti [1].</p>

<h2>Význam pre pacienta bez diabetu</h2>
<p>SELECT poskytuje údaje pre pacientov bez diabetu s nadváhou alebo obezitou a preukázaným kardiovaskulárnym ochorením. V tejto populácii bol priaznivý výsledok pôvodného obličkového ukazovateľa spätý najmä s menším počtom prípadov pretrvávajúcej makroalbuminúrie. Pri samostatnom odhade účinku na zlyhanie obličiek alebo potrebu dialýzy zostáva neistota. Spoločná analýza SELECT, FLOW a SOUL zistila menej závažných obličkových udalostí aj bez kardiovaskulárneho úmrtia. Jej odhad však zahŕňa aj pacientov s diabetom 2. typu a nemožno ho použiť ako samostatný odhad pre nediabetickú CKD. SELECT financovala spoločnosť Novo Nordisk [1 až 3].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Helen M Colhoun, Ildiko Lingvay, Paul M Brown, John Deanfield, Kirstine Brown-Frandsen, Steven E Kahn, Jorge Plutzky, Koichi Node, Alexander Parkhomenko, Lars Rydén, John P H Wilding, Johannes F E Mann, Katherine R Tuttle, Thomas Idorn, Naveen Rathor, A Michael Lincoff. Long-term kidney outcomes of semaglutide in obesity and cardiovascular disease in the SELECT trial. Nat Med. 2024;30(7):2058-2066. <a href="https://doi.org/10.1038/s41591-024-03015-5">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38796653/">PubMed 38796653</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11271413/">Plný text</a> · <a href="https://media.springernature.com/full/springer-static/esm/art%3A10.1038%2Fs41591-024-03015-5/MediaObjects/41591_2024_3015_MOESM2_ESM.xlsx">Doplnkové tabuľky</a></em></small></li>
<li><small><em>A Michael Lincoff, Kirstine Brown-Frandsen, Helen M Colhoun, John Deanfield, Scott S Emerson, Sille Esbjerg, Søren Hardt-Lindberg, G Kees Hovingh, Steven E Kahn, Robert F Kushner, Ildiko Lingvay, Tugce K Oral, Marie M Michelsen, Jorge Plutzky, Christoffer W Tornøe, Donna H Ryan, SELECT Trial Investigators. Semaglutide and Cardiovascular Outcomes in Obesity without Diabetes. N Engl J Med. 2023;389(24):2221-2232. <a href="https://doi.org/10.1056/NEJMoa2307563">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37952131/">PubMed 37952131</a></em></small></li>
<li><small><em>Johannes F E Mann, Sunil V Badve, Florian M M Baeres, Nicolas Belmar, Kirstine Brown-Frandsen, John B Buse, Helen M Colhoun, John E Deanfield, Mads D M Engelmann, G Kees Hovingh, Thomas Idorn, A Michael Lincoff, Ildiko Lingvay, Kenneth W Mahaffey, Darren K McGuire, Richard E Pratley, Søren Rasmussen, Peter Rossing, Naveed Sattar, Katherine R Tuttle, Vlado Perkovic. Effect of semaglutide on kidney outcomes in the SELECT, FLOW, and SOUL trials: a prespecified pooled analysis. Lancet Diabetes Endocrinol. 2026;14(10):818-830. <a href="https://doi.org/10.1016/S2213-8587(26)00134-8">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42567173/">PubMed 42567173</a></em></small></li>
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
    'log_prefix' => 'add_semaglutid_select_oblicky',
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
