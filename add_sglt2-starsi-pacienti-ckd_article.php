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
    'title'        => 'Inhibítory SGLT2 u starších pacientov s chronickou chorobou obličiek',
    'slug'         => 'sglt2-starsi-pacienti-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Dve kohortové analýzy skúmali úmrtnosť a diagnózy demencie. Výsledky treba čítať v kontexte rozdielov medzi kongresovými abstraktmi a reportážou Medscape.',
    'content'      => <<<'HTML'
<figure><img src="img/sglt2-starsi-pacienti-ckd.webp" alt="Ruky staršieho človeka pri balení lieku a okuliaroch" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia konzultácie o liečbe vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>U veľmi starých pacientov s chronickou chorobou obličiek (CKD) sa začatie liečby inhibítorom SGLT2 spájalo s nižšou úmrtnosťou v retrospektívnej analýze TriNetX. Druhá analýza opísaná v Medscape upozornila na menej zaznamenaných diagnóz demencie u starších pacientov s diabetom 2. typu. Ide o dve odlišné otázky s odlišnými porovnávacími skupinami. Pri oboch záveroch treba zohľadniť rozdiely medzi reportážou a verejne dostupnými kongresovými abstraktmi [1, 2, 3].</p>

<h2>Úmrtnosť vo veľmi vysokom veku</h2>
<p>Doricic a spoluautori porovnali pacientov vo veku približne 80 rokov a viac s CKD, ktorí začali užívať inhibítor sodíkovo-glukózového kotransportéra 2 (SGLT2), s pacientmi bez tejto liečby. Po párovaní podľa pravdepodobnosti začatia liečby mala každá skupina 23 765 pacientov. Párovanie zohľadňovalo pridružené ochorenia, laboratórne údaje a dostupné ukazovatele krehkosti. Počas dvojročného sledovania bol upravený pomer hazardov (aHR) pre úmrtie z akejkoľvek príčiny 0,734 (95 % interval spoľahlivosti od 0,705 do 0,765). Pre závažné nepriaznivé obličkové príhody uvádza kongresový abstrakt aHR 0,775 (od 0,745 do 0,806) [2].</p>
<p>Pomer hazardov vyjadruje relatívne porovnanie počas sledovania. Bez údajov o absolútnom riziku z neho nemožno odvodiť, koľkým úmrtiam by liečba zabránila. Aj po párovaní mohli liečení a neliečení pacienti vykazovať rozdiely v miere krehkosti, prognóze či intenzite starostlivosti. Podľa reportáže analýza vylučovala okrem iného pacientov s eGFR najviac 20 ml/min/1,73 m², pacientov liečených dialýzou a príjemcov transplantovanej obličky [1, 2].</p>

<h2>Kardiovaskulárne výsledky sa v zdrojoch rozchádzajú</h2>
<p>Pre zložený ukazovateľ závažných nepriaznivých kardiovaskulárnych príhod (MACE) uvádza abstrakt ASN aHR 0,884 (95 % interval spoľahlivosti od 0,857 do 0,913). Medscape uvádza aHR 1,007 (<i>p</i> = 0,84). Z dostupných podkladov sa nedá určiť, či sa líšila definícia ukazovateľa alebo verzia analýzy. Reportáž navyše opisuje vyšší výskyt niektorých samostatných udalostí vrátane infarktu myokardu a akútneho srdcového zlyhávania. Bez podrobného opisu analýzy a overenia výsledkov nemožno tieto údaje považovať za dôkaz škodlivého účinku liečby [1, 2].</p>

<h2>Demencia a mierna kognitívna porucha</h2>
<p>Medscape opisuje porovnanie nových používateľov inhibítorov SGLT2 a inhibítorov dipeptidylpeptidázy 4 (DPP-4) v databáze TriNetX. Z 43 005 pacientov vo veku aspoň 65 rokov s diabetom 2. typu malo 25 025 vstupnú CKD. V tejto podskupine reportáž uvádza pre zložený ukazovateľ diagnózy demencie alebo miernej kognitívnej poruchy pomer subdistribučných hazardov (sHR) 0,76 (<i>p</i> = 0,003) po zohľadnení úmrtia ako konkurenčnej udalosti. Pre samotnú demenciu uvádza sHR 0,73 bez hodnoty <i>p</i> a pre samotnú miernu kognitívnu poruchu sHR 0,93 bez štatisticky významného rozdielu [1].</p>
<p>Verejne dostupný abstrakt Banoovej a Koraishyho opisuje jedno pracovisko, 969 pacientov a porovnanie s inými liekmi na zníženie glykémie. V analýze zohľadňujúcej úmrtie uvádza sHR 0,49 (95 % interval spoľahlivosti od 0,24 do 1,00, <i>p</i> = 0,051). Tento abstrakt nepotvrdzuje čísla z národnej analýzy opísanej v Medscape. Kódy diagnóz navyše zachytávajú zaznamenanie poruchy, pričom neukazujú, ako sa menil výkon v štandardizovaných kognitívnych testoch. Podobnú asociáciu s diagnózou demencie zistila juhokórejská kohorta pacientov vo veku 40 až 69 rokov. Obe pozorovania podporujú ďalší výskum. Prevenciu demencie inhibítormi SGLT2 zatiaľ nepreukazujú [1, 3, 4].</p>

<h2>Čo zohľadniť pri rozhodovaní o liečbe</h2>
<p>Pri rozhodovaní o nefroprotektívnej liečbe má väčšiu výpovednú hodnotu randomizovaná štúdia DAPA-CKD. Jej vopred plánovaná analýza podľa veku nenašla dôkaz, že by sa účinok dapagliflozínu menil s vekom. Štúdia zahŕňala pacientov s eGFR od 25 do 75 ml/min/1,73 m² a pomerom albumínu ku kreatinínu v moči (ACR) od 200 do 5 000 mg/g. Výsledky preto treba u veľmi krehkých pacientov posudzovať podľa toho, do akej miery sa podobajú účastníkom skúšania [5].</p>
<p>Podľa KDIGO patrí medzi indikácie diabetes 2. typu s CKD pri eGFR aspoň 20 ml/min/1,73 m². KDIGO odporúča liečbu aj dospelým s CKD pri eGFR aspoň 20 ml/min/1,73 m² a ACR aspoň 200 mg/g alebo pri srdcovom zlyhávaní bez ohľadu na albuminúriu. U staršieho pacienta má zmysel posúdiť stav hydratácie a krvný tlak vrátane ťažkostí pri vstávaní, súbežné užívanie diuretík a schopnosť dodržať pokyny pri akútnom ochorení. Podľa KDIGO je rozumné liečbu dočasne prerušiť pri dlhšom hladovaní, v súvislosti s operáciou alebo pri kritickom ochorení, keď stúpa riziko ketózy. Kognitívne pozorovania z kongresu indikácie nerozširujú [1, 5, 6].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Nancy A. Melville. <a href="https://www.medscape.com/viewarticle/sglt2-inhibitors-linked-survival-cognitive-benefits-older-2026a10014v8">SGLT2 Inhibitors Linked to Survival, Cognitive Benefits in Older Patients With CKD</a>. Medscape. 28. októbra 2026.</em></small></li>
<li><small><em>Julian Doricic, Jonas Michael Willerding, Anette Melk, Kai M. Schmidt-Ott, Robert Greite, Wilfried Gwinner, Bernhard M.W. Schmidt. Extending Benefit to the Oldest Old: Efficacy of SGLT2 Inhibitors in Older Adults with CKD. Kidney Week 2026, 24. októbra, <a href="https://www.asn-online.org/education/kidney-week/2026/program-abstract.aspx?controlId=4559698">abstrakt SA-OR031</a>.</em></small></li>
<li><small><em>Ruqiyya Bano, Farrukh M. Koraishy. SGLT2 Inhibitor Use and Incident Cognitive Impairment in Older Adults with Type 2 Diabetes and CKD. Kidney Week 2026, 24. októbra, <a href="https://www.asn-online.org/education/kidney-week/2026/program-abstract.aspx?controlId=4559939">abstrakt SA-OR032</a>.</em></small></li>
<li><small><em>Anna Shin, Bo Kyung Koo, Jun Young Lee, Eun Ha Kang. Risk of dementia after initiation of sodium-glucose cotransporter-2 inhibitors versus dipeptidyl peptidase-4 inhibitors in adults aged 40-69 years with type 2 diabetes: population based cohort study. BMJ. 2024;386:e079475. <a href="https://doi.org/10.1136/bmj-2024-079475">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39197881/">PubMed 39197881</a></em></small></li>
<li><small><em>Margaret K Yu, Priya Vart, Niels Jongs, Ricardo Correa-Rotter, Peter Rossing, John J V McMurray, Fan-Fan Hou, Walter Douthat, Dinesh Khullar, Anna Maria Langkilde, David C Wheeler, Hiddo J L Heerspink, Glenn M Chertow. Effects of Dapagliflozin in Chronic Kidney Disease Across the Spectrum of Age and by Sex. J Gen Intern Med. 2024;39(6):921-930. <a href="https://doi.org/10.1007/s11606-023-08397-9">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38097862/">PubMed 38097862</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11074069/">Plný text</a></em></small></li>
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
    'log_prefix' => 'add_sglt2_starsi_ckd',
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
