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
    'title'        => 'Akútny koronárny syndróm pri chronickej chorobe obličiek',
    'slug'         => 'akutny-koronarny-syndrom-pri-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Ako pri CKD vyhodnotiť troponín, načasovať koronarografiu, obmedziť riziko poškodenia obličiek a zvoliť dĺžku antiagregačnej liečby.',
    'content'      => <<<'HTML'
<p>Pri akútnom koronárnom syndróme (AKS) u pacienta s chronickou chorobou obličiek (CKD) treba naraz posúdiť riziko pokračujúcej ischémie, krvácania a akútneho poškodenia obličiek (AKI). Medscape v septembri 2026 spracoval americké odporúčania ACC/AHA z roku 2025. Európske odporúčania ESC/ERA z augusta 2026 k nim pridávajú podrobnejší postup pre pacientov s CKD. Pri infarkte s eleváciou úseku ST (STEMI) má prednosť včasná reperfúzia. Pri stabilizovanom AKS bez elevácie úseku ST (NSTE-AKS) sa načasovanie invazívneho vyšetrenia riadi klinickým rizikom. [1, 2]</p>

<h2>Troponín treba čítať spolu s EKG a klinickým obrazom</h2>

<p>Pri podozrení na AKS má byť 12-zvodové EKG zaznamenané a vyhodnotené do 10 minút od príchodu. Pri pretrvávajúcich alebo vracajúcich sa príznakoch treba EKG zopakovať, ak prvý záznam diagnózu neobjasnil. Pri pracovnej diagnóze STEMI sa reperfúzia neodkladá do výsledku troponínu ani kreatinínu. [1, 2, 3]</p>

<p>Pri CKD môže byť koncentrácia vysokosenzitívneho kardiálneho troponínu (hs-cTn) dlhodobo zvýšená. Pri podozrení na NSTE-AKS sa hodnotí vzostup alebo pokles v sériových odberoch s použitím prahov pre konkrétnu laboratórnu metódu. Zvýšený hs-cTn nad 99. percentilom s dynamikou svedčí o akútnom poškodení myokardu. Diagnóza infarktu vyžaduje aj známky akútnej ischémie, napríklad zodpovedajúce príznaky, nové ischemické zmeny na EKG alebo zobrazovací nález. Pri hypotenzii, ťažkej anémii či tachyarytmii treba zvážiť aj infarkt 2. typu a pri absencii známok ischémie neischemické poškodenie myokardu. [1, 3]</p>

<h2>Kedy vykonať koronarografiu</h2>

<p>Pri STEMI sa má bezodkladne aktivovať reperfúzny postup. Pri NSTE-AKS s refraktérnou alebo opakovanou bolesťou napriek liečbe, hemodynamickou či elektrickou nestabilitou alebo akútnym srdcovým zlyhaním v dôsledku pokračujúcej ischémie je indikovaná urgentná invazívna stratégia aj pri pokročilej CKD. Pri stabilizovanom pacientovi pomáhajú pri rozhodovaní dynamické zmeny EKG, potvrdenie NSTEMI a skóre GRACE. Pri vysokom riziku sa má zvážiť skorá koronarografia do 24 hodín. [1, 2, 3]</p>

<p>ACC/AHA uvádza pokročilú chorobu obličiek u pacienta bez dialýzy a akútne zlyhanie obličiek medzi relatívnymi kontraindikáciami rutinného invazívneho postupu. U stabilizovaného pacienta preto treba spoločne zvážiť pravdepodobnosť liečiteľnej koronárnej lézie, riziko krvácania a možnosť zhoršenia funkcie obličiek. Štúdia ISCHEMIA-CKD skúmala stabilnú koronárnu chorobu. Jej výsledok nemožno použiť na zdôvodnenie odkladu koronarografie pri akútnej alebo nestabilnej ischémii. [1, 2, 4]</p>

<h2>Ako znížiť riziko poškodenia obličiek pri výkone</h2>

<p>Pred výkonom je užitočné zistiť predchádzajúcu hodnotu kreatinínu, jeho aktuálny trend, diurézu a stav hydratácie. Pri rýchlej zmene kreatinínu je vypočítaná eGFR menej spoľahlivým odhadom aktuálnej filtrácie. Pri eGFR &lt;30 ml/min/1,73 m² u pacienta bez dialýzy ESC/ERA odporúča nízkoosmolárnu alebo izoosmolárnu jódovú kontrastnú látku a postupy šetriace jej objem. Intravenóznu hydratáciu možno zvážiť podľa hemodynamiky a rizika objemového preťaženia. Pri pľúcnej kongescii sa tekutiny nesmú podávať mechanicky podľa protokolu. Profylaktická hemodialýza na prevenciu poškodenia obličiek po kontraste sa neodporúča. [2, 3]</p>

<p>Ak po výkone stúpne kreatinín, časová súvislosť s kontrastom sama osebe neurčuje príčinu. Zhodnotiť treba aj hypotenziu, pretrvávajúcu kongesciu, krvácanie a ďalšie možné príčiny AKI. U pacienta s vysokým rizikom má plán monitorovania zahŕňať trend kreatinínu a diurézy. [2]</p>

<h2>Antiagregačná liečba po AKS</h2>

<p>ACC/AHA odporúča ako východiskový postup po AKS dvojitú antiagregačnú liečbu (DAPT) s kyselinou acetylsalicylovou a inhibítorom P2Y₁₂ najmenej 12 mesiacov u pacientov bez vysokého rizika krvácania. ESC/ERA pri AKS a CKD bez indikácie na antikoaguláciu odporúča zvážiť skrátenie DAPT na tri mesiace s následným prechodom na jeden antiagregačný liek alebo zníženie intenzity DAPT po jednom až troch mesiacoch. Cieľom je znížiť riziko závažného krvácania. Pri rozhodovaní záleží aj na priebehu po intervencii, riziku trombózy stentu, predchádzajúcom krvácaní a prípadnej potrebe dlhodobej antikoagulácie. Údaje pri pokročilej CKD a dialýze sú obmedzené. Pri výbere a dávkovaní antikoagulancia v akútnej fáze treba použiť ukazovateľ funkcie obličiek určený pre daný liek a zohľadniť, či je kreatinín v ustálenom stave. [1, 2, 3]</p>

<hr>
<h2>Zdroje</h2>
<p><small><em>Management of Acute Coronary Syndromes. Medscape Guideline Essentials. 3. septembra 2026. Odborná revízia Shouvik Haldar. <a href="https://reference.medscape.com/cc2/p10/acute-coronary-syndromes-acc-aha-guideline-2026a1000snr" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>
<ol>
<li><small><em>Sunil V Rao, Michelle L O&#39;Donoghue, Marc Ruel, Tanveer Rab, Jaqueline E Tamis-Holland, John H Alexander, Usman Baber, Heather Baker, Mauricio G Cohen, Mercedes Cruz-Ruiz, Leslie L Davis, James A de Lemos, Tracy A DeWald, Islam Y Elgendy, Dmitriy N Feldman, Abhinav Goyal, Ijeoma Isiadinso, Venu Menon, David A Morrow, Debabrata Mukherjee, Elke Platz, Susan B Promes, Sigrid Sandner, Yader Sandoval, Rachel Schunder, Binita Shah, Jason P Stopyra, Amy W Talbot, Pam R Taub, Marlene S Williams. 2025 ACC/AHA/ACEP/NAEMSP/SCAI Guideline for the Management of Patients With Acute Coronary Syndromes: A Report of the American College of Cardiology/American Heart Association Joint Committee on Clinical Practice Guidelines. Circulation. 2025;151(13):e771-e862. <a href="https://doi.org/10.1161/CIR.0000000000001309" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40014670/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kevin Damman, Jozine M Ter Maaten, Kaitlin J Mayne, Davide Bolignano, Elizabeth M Brown, Bruno R da Costa, Anna Dagre, Ron T Gansevoort, Cristina Gavina, Andreas Goette, Diana A Gorog, Nina Nikolova Gotcheva, Marta Kaluzna-Oleksy, Dearbhla M Kelly, Oleksii Korzh, Jennifer S Lees, Olivia Manfrini, Pieter Martens, Julio Nunez, Eugenio Stabile, Isabella Sudano, Marieta P Theodorakopoulou, Simon Winther, William G Herrington, ESC Guidelines Advisory Group. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease, in collaboration with the European Renal Association (ERA). Eur Heart J. Online 28. augusta 2026. ehag098. <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Robert A Byrne, Xavier Rossello, J J Coughlan, Emanuele Barbato, Colin Berry, Alaide Chieffo, Marc J Claeys, Gheorghe-Andrei Dan, Marc R Dweck, Mary Galbraith, Martine Gilard, Lynne Hinterbuchner, Ewa A Jankowska, Peter J&#252;ni, Takeshi Kimura, Vijay Kunadian, Margret Leosdottir, Roberto Lorusso, Roberto F E Pedretti, Angelos G Rigopoulos, Maria Rubini Gimenez, Holger Thiele, Pascal Vranckx, Sven Wassmann, Nanette Kass Wenger, Borja Ibanez, ESC Scientific Document Group. 2023 ESC Guidelines for the management of acute coronary syndromes. Eur Heart J. 2023;44(38):3720-3826. <a href="https://doi.org/10.1093/eurheartj/ehad191" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37622654/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Sripal Bangalore, David J Maron, Sean M O&#39;Brien, Jerome L Fleg, Evgeny I Kretov, Carlo Briguori, Upendra Kaul, Harmony R Reynolds, Tomasz Mazurek, Mandeep S Sidhu, Jeffrey S Berger, Roy O Mathew, Olga Bockeria, Samuel Broderick, Radoslaw Pracon, Charles A Herzog, Zhen Huang, Gregg W Stone, William E Boden, Jonathan D Newman, Ziad A Ali, Daniel B Mark, John A Spertus, Karen P Alexander, Bernard R Chaitman, Glenn M Chertow, Judith S Hochman, ISCHEMIA-CKD Research Group. Management of Coronary Disease in Patients with Advanced Kidney Disease. N Engl J Med. 2020;382(17):1608-1618. <a href="https://doi.org/10.1056/NEJMoa1915925" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32227756/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
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
    'log_prefix' => 'add_akutny-koronarny-syndrom-pri-ckd_article',
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
