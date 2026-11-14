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
    'title'        => 'Novozistený diabetes pri chronickej chorobe obličiek v kohorte REGARDS',
    'slug'         => 'diabetes-2-typu-ckd-regards',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'V kohorte REGARDS sa súvislosť CKD s novozisteným diabetom menila podľa spôsobu odhadu glomerulovej filtrácie. Prediabetes sa s diabetom spájal vo všetkých hlavných modeloch.',
    'content'      => <<<'HTML'
<figure><img src="img/diabetes-2-typu-ckd-regards.webp" alt="Odberová skúmavka a nádobka na vzorku pred anatomickým modelom obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia laboratórneho hodnotenia pri chorobe obličiek vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>V americkej kohorte REGARDS sa pri kontrolnej návšteve po približne desiatich rokoch zistil diabetes u 15,8 % účastníkov so vstupnou chronickou chorobou obličiek (CKD) a u 11,0 % účastníkov bez nej. Pri tejto klasifikácii autori použili odhad glomerulovej filtrácie z kreatinínu a albuminúriu. Keď do odhadu filtrácie zahrnuli aj cystatín C, štatisticky významná súvislosť medzi CKD a novozisteným diabetom sa nepreukázala. Prediabetes mal výraznú súvislosť s neskorším zistením diabetu pri všetkých troch spôsoboch odhadu filtrácie [1].</p>

<h2>Koho a čo sledovala štúdia REGARDS</h2>
<p>Do analýzy americkej prospektívnej kohorty zaradili 7 511 dospelých vo veku najmenej 45 rokov bez diabetu pri vstupe, s dostupnými údajmi z druhej návštevy a so všetkými údajmi potrebnými pre hlavný model. Vstupné kritérium CKD splnilo 994 účastníkov. Bola ním odhadovaná glomerulová filtrácia (eGFR) pod 60 ml/min/1,73 m² podľa rovnice MDRD alebo pomer albumínu ku kreatinínu v moči (ACR) nad 30 mg/g. Na zaradenie stačili vstupné hodnoty. V klinickej praxi sa chronickosť dokladá trvaním abnormality aspoň tri mesiace, prípadne inými dôkazmi chronického poškodenia [1, 2].</p>
<p>Medián času do druhej návštevy bol 9,5 roka (interkvartilové rozpätie od 8,6 do 9,9 roka). Diabetes pri nej autori definovali glykémiou nalačno aspoň 7,0 mmol/l, náhodnou glykémiou aspoň 11,1 mmol/l alebo užívaním inzulínu či iného lieku na zníženie glykémie podľa údajov účastníka. Kritériá štúdie tak zachytávali novozistený diabetes bez spoľahlivého rozlíšenia jeho typov a bez potvrdenia každej laboratórnej odchýlky opakovaným meraním [1].</p>

<h2>Výsledok závisel od spôsobu klasifikácie CKD</h2>
<p>Diabetes sa pri druhej návšteve zistil u 157 z 994 účastníkov s CKD a u 717 zo 6 517 účastníkov bez CKD. Neupravený rozdiel bol 4,8 percentuálneho bodu. Po zohľadnení demografických a metabolických ukazovateľov vrátane vstupného prediabetu bol pomer šancí (OR) pri klasifikácii podľa MDRD 1,45 (95 % interval spoľahlivosti od 1,16 do 1,81). Pri kreatinínovej rovnici CKD-EPI 2021 bol OR 1,30 (od 1,03 do 1,65). Pomer šancí vyjadruje výsledok logistického modelu. Neudáva relatívne riziko ani ročnú incidenciu [1].</p>
<p>Pri kombinovanom odhade z kreatinínu a cystatínu C bol v tabuľke 5 OR 0,84 (95 % interval spoľahlivosti od 0,66 do 1,08). Sprievodný text publikácie uvádza mierne odlišný odhad 0,85 (od 0,66 do 1,09). Z oboch vyplýva rovnaký záver o štatistickej nevýznamnosti. Opis premenných zahrnutých do modelov sa medzi metodikou a poznámkami k tabuľke tiež líši. Rozdiel medzi odhadmi preto nemožno pripísať výlučne zmene rovnice. Štúdia neposkytuje dôkaz, že cystatín C mení riziko vzniku diabetu [1].</p>

<h2>Prediabetes a ďalšie súvislosti</h2>
<p>V hlavnom modeli celej kohorty sa vstupný prediabetes spájal s vyššou šancou novozisteného diabetu (OR 4,94, 95 % interval spoľahlivosti od 4,22 do 5,78). Keď autori analýzu obmedzili na 1 486 účastníkov s prediabetom, dodatočná súvislosť CKD s diabetom sa štatisticky nepreukázala (OR 0,91, od 0,64 do 1,29). Výsledok sa týka vybranej podskupiny a interval pripúšťa účinok v oboch smeroch. V kohorte CRIC sa u dospelých s CKD novozistený diabetes spájal so vstupnou glykémiou nalačno a rodinnou anamnézou diabetu. Súvislosť s ukazovateľmi funkcie alebo poškodenia obličiek sa tam nepreukázala [1, 3].</p>
<p>Vyššie šance na diabetes pri častejšej intenzívnej aktivite a nižšie šance pri aktuálnom pití alkoholu treba čítať ako asociácie z dotazníkových údajov. Účastníci sami uvádzali pohyb aj pitie alkoholu. Údaje o trvaní a intenzite týchto návykov boli obmedzené. Výsledky nedávajú dôvod obmedzovať pohyb ani odporúčať alkohol na prevenciu diabetu [1].</p>

<h2>Čo z výsledkov vyplýva pre ambulanciu</h2>
<p>Z pôvodnej kohorty sa na druhú návštevu nedostala veľká časť účastníkov vrátane tých, ktorí počas sledovania zomreli. Ďalších vyradili pre chýbajúce údaje. Uvedené podiely sa preto vzťahujú na analyzovaných účastníkov a ich prenos na všetkých pacientov s CKD je obmedzený. Dve návštevy navyše neumožňujú presne určiť dátum vzniku diabetu [1].</p>
<p>Pri hodnotení CKD má kombinovaný odhad z kreatinínu a cystatínu C svoje miesto podľa odporúčaní KDIGO. REGARDS neoverovala jeho použitie ako testu na predpovedanie diabetu ani neurčila nový interval kontroly glykémie. V ambulancii je z týchto údajov najlepšie doložené, že vstupný prediabetes označuje skupinu s vyššou pravdepodobnosťou neskoršieho zistenia diabetu [1, 2, 3].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Xingsheng Li, Javier A Jurado Vélez, Nita Kanney, Archie Landrum, Lloyd J Edwards, Orlando M Gutierrez, D Leann Long, Bertha Hidalgo. Incident Type 2 Diabetes in Individuals With CKD: The REGARDS Study. Kidney Med. 2026;8(11):101498. <a href="https://doi.org/10.1016/j.xkme.2026.101498">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42898242/">PubMed 42898242</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13677398/">Plný text</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/">PubMed 38490803</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf">Plný text KDIGO</a></em></small></li>
<li><small><em>Christopher Jepson, Jesse Y Hsu, Michael J Fischer, John W Kusek, James P Lash, Ana C Ricardo, Jeffrey R Schelling, Harold I Feldman, Chronic Renal Insufficiency Cohort (CRIC) Study Investigators. Incident Type 2 Diabetes Among Individuals With CKD: Findings From the Chronic Renal Insufficiency Cohort (CRIC) Study. Am J Kidney Dis. 2019;73(1):72-81. <a href="https://doi.org/10.1053/j.ajkd.2018.06.017">DOI a vydavateľ</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30177484/">PubMed 30177484</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6309655/">Plný text</a></em></small></li>
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
    'log_prefix' => 'add_diabetes_ckd_regards',
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
