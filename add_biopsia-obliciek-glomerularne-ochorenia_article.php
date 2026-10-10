<?php
/** Odborne revidovaný článok; idempotentné publikovanie podľa projektovej šablóny. */

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
    'title'        => 'Biopsia obličiek pri glomerulárnych ochoreniach: čo stále rozhoduje a kde sú výnimky',
    'slug'         => 'biopsia-obliciek-glomerularne-ochorenia',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nové poľské údaje pripomínajú hodnotu biopsie obličky. Praktický pohľad na indikácie, sérologické výnimky, vyšší vek a hranice interpretácie bioptických kohort.',
    'content'      => <<<'HTML'
<p>Biopsia obličky zostáva zásadným nástrojom pri diagnostike mnohých glomerulárnych ochorení. Sérologické a genetické vyšetrenia niekedy umožňujú menej invazívny postup, ale spravidla nenahradia informáciu o type tkanivového poškodenia, jeho aktivite a chronicite. Rozhodujúca otázka preto znie: môže histologický výsledok zmeniť diagnózu, liečbu alebo odhad prognózy natoľko, aby odôvodnil riziko výkonu? [1, 3]</p>

<figure>
<a href="img/biopsia-obliciek-glomerularne-ochorenia.webp" target="_blank" rel="noopener noreferrer"><img src="img/biopsia-obliciek-glomerularne-ochorenia.webp" alt="Ilustračná oblička, valček tkaniva nad podložným sklíčkom a symbolicky zväčšený glomerulus" width="1586" height="992" loading="lazy" decoding="async"></a>
<figcaption>Biopsia spája klinický obraz s tkanivovou diagnózou. Obrázok je umeleckou ilustráciou; nezobrazuje skutočný histologický preparát ani techniku odberu.</figcaption>
</figure>

<h2>Čo prinášajú údaje zo stredného Poľska</h2>
<p>Podnetom na diskusiu je editorial Stompóra a Zbrzeźniak-Suszczewiczovej k regionálnej štúdii Nowickej a spoluautorov. Autori analyzovali 1 662 prvých biopsií vlastných obličiek u dospelých obyvateľov Lodžského vojvodstva z rokov 2011 až 2023. Frekvencia biopsií vzrástla zo 43,9 na 102,2 na milión obyvateľov, s prechodným poklesom počas pandémie COVID-19. Zvyšoval sa podiel starších pacientov. [1, 2]</p>
<p>Najčastejšou diagnózou bola IgA nefropatia (17,4 %), nasledovali fokálna segmentálna glomeruloskleróza (16,3 %), membránová nefropatia (9,4 %) a diabetické ochorenie obličiek (8,0 %). Hodnota 11,7 % uvádzaná v editoriale pre diabetické ochorenie obličiek sa týka najstaršej vekovej skupiny, nie celého súboru. Arteriolonefroskleróza predstavovala 3,7 % všetkých biopsií. [1, 2]</p>
<p><strong>Ide o spektrum chorôb medzi vybranými biopsiovanými pacientmi, nie o prevalenciu v celej populácii.</strong> Výsledky závisia od indikácií, dostupnosti výkonu a charakteristík odosielaných pacientov. Samotný nárast počtu biopsií nedokazuje zlepšenie klinických výsledkov. Štúdia poskytuje epidemiologický a organizačný pohľad; neporovnáva randomizovane stratégiu s biopsiou a bez nej. [2]</p>

<h2>Čo vie povedať tkanivo navyše</h2>
<p>Bioptický materiál umožňuje hodnotiť glomeruly, tubuly, interstícium aj cievy. Svetelná mikroskopia, imunofluorescencia a podľa diagnostickej potreby elektrónová mikroskopia sa dopĺňajú. Rozlíšenie aktívnych zápalových lézií od sklerózy a intersticiálnej fibrózy pomáha odhadnúť potenciálnu liečebnú ovplyvniteľnosť. Výsledok vždy vyžaduje koreláciu s klinickým obrazom; malá alebo nereprezentatívna vzorka môže byť limitujúca. [3]</p>
<p>Názov morfologického vzorca ešte nemusí určovať príčinu. Napríklad fokálna segmentálna glomeruloskleróza môže predstavovať primárne ochorenie, geneticky podmienenú poruchu alebo sekundárnu adaptívnu léziu. Označenia „nekrotizujúca“, „polmesiačiková“ a „pauciimunitná“ glomerulonefritída opisujú rozdielne vlastnosti nálezu a môžu sa vzťahovať na tú istú biopsiu. Nemožno ich bez znalosti klasifikácie štúdie sčítať ako nezávislé diagnózy. [3]</p>

<h2>Biopsia pri diabete alebo hypertenzii</h2>
<p>Prítomnosť diabetu či artériovej hypertenzie nie je dôkazom, že každé poškodenie obličiek vzniklo práve ich následkom. Sama osebe však nie je ani dôvodom na biopsiu. Dôležitý je súlad klinického priebehu s predpokladanou diagnózou. Náhly vznik nefrotického syndrómu, aktívny močový sediment, nevysvetlený rýchly pokles eGFR alebo systémové prejavy môžu upozorniť na inú či pridruženú chorobu. [3, 5]</p>
<p>Praktické rozhodovanie má preto vychádzať z konkrétnej alternatívy: očakávame napríklad imunitne podmienené ochorenie, ktoré by vyžadovalo špecifickú liečbu? Dokáže výsledok odlíšiť aktívnu léziu od prevažne nezvratného poškodenia? Ak by sa postup nezmenil pri žiadnom pravdepodobnom výsledku, diagnostický prínos invazívneho vyšetrenia môže byť malý.</p>

<h2>Sérologická výnimka má presné hranice</h2>
<p>KDIGO 2021 uvádza, že pri nefrotickom syndróme a pozitivite protilátok proti receptoru fosfolipázy A₂ (anti-PLA2R) nie je biopsia potrebná na samotné potvrdenie membránovej nefropatie. Aj vtedy môže byť vhodná pri atypickom priebehu alebo otázke pridruženého poškodenia. Pacient naďalej potrebuje vyšetrenie možných súvisiacich ochorení. [3]</p>
<p><strong>Túto výnimku nemožno automaticky preniesť na pozitivitu anti-THSD7A.</strong> KDIGO nepovažuje dôkazy za dostatočné na rovnaký diagnostický postup bez biopsie. Pozitívny biomarker navyše neodpovedá na všetky otázky aktivity, chronicity a pridružených lézií. Presná formulácia je tu dôležitejšia než všeobecné tvrdenie, že „nové protilátky nahrádzajú histológiu“. [3]</p>

<h2>Kedy čakanie na biopsiu nesmie odložiť liečbu</h2>
<p>Pri rýchlo sa zhoršujúcom stave kompatibilnom s vaskulitídou malých ciev a pozitívnymi MPO-ANCA alebo PR3-ANCA nemá čakanie na odber či výsledok biopsie odďaľovať začatie imunosupresie. KDIGO 2024 tento postup zasadzuje do starostlivosti skúseného pracoviska; biopsia sa má vykonať čo najskôr, keď je uskutočniteľná. Pozitivita ANCA bez zodpovedajúceho klinického obrazu sama osebe takýto postup neodôvodňuje. [4]</p>
<p>Naliehavosť liečby a hodnota biopsie sa teda nevylučujú; v akútnej situácii sa mení len ich časové poradie. Treba súčasne posúdiť infekciu, liekové príčiny a iné stavy, ktoré môžu vaskulitídu napodobňovať.</p>

<h2>Vyšší vek vyžaduje individualizáciu</h2>
<p>Vyšší vek sám osebe nie je kontraindikáciou. Zvažujú sa krehkosť, komorbidity, funkčný stav, krvácavé riziko a ochota pacienta podstúpiť prípadnú následnú liečbu. Potenciálny prínos môže byť významný aj u staršieho človeka s liečiteľnou príčinou akútneho zhoršenia funkcie obličiek. [5]</p>
<p>Pred výkonom treba skontrolovať krvný tlak, krvný obraz, koaguláciu, antikoagulačnú a antiagregačnú liečbu aj ultrazvukovú anatómiu. Hlavnou komplikáciou je krvácanie. Nekorigovaná porucha hemostázy či nekontrolovaná hypertenzia si vyžadujú nápravu alebo zmenu postupu. Po odbere nasleduje sledovanie podľa rizika a protokolu pracoviska. Rozhovor o prínose a riziku je súčasťou informovaného súhlasu. [5]</p>
<p>Poľská skúsenosť podporuje diskusiu o dostupnosti kvalitnej nefropatologickej diagnostiky. Klinickým cieľom však nie je čo najväčší počet biopsií. Je ním včasná biopsia u pacienta, ktorému môže výsledok podstatne zmeniť starostlivosť.</p>

<hr>
<p><small><em><strong>Zdroj:</strong> [1] Stompór T, Zbrzeźniak-Suszczewicz J. Kidney biopsy still rules the diagnosis of glomerular disease: new insights into trends in biopsy-proven kidney disease in Poland. Pol Arch Intern Med. Publikované online 29. septembra 2026. DOI: <a href="https://doi.org/10.20452/pamw.17405" target="_blank" rel="noopener noreferrer">10.20452/pamw.17405</a>. <a href="https://www.mp.pl/paim/issue/article/17405/" target="_blank" rel="noopener noreferrer">Editorial vydavateľa</a>. Slovenské odborné spracovanie s doplneným klinickým kontextom.</em></small></p>
<p><small><em>[2] Nowicka M, Wągrowska-Danilewicz M, Olkowski M a kol. Trends in biopsy-confirmed kidney disease in the adult population of central Poland: a single-region cohort study of 13-year duration (2011–2023). Pol Arch Intern Med. 2026. DOI: <a href="https://doi.org/10.20452/pamw.17344" target="_blank" rel="noopener noreferrer">10.20452/pamw.17344</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42423079/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
<p><small><em>[3] KDIGO Glomerular Diseases Work Group. KDIGO 2021 Clinical Practice Guideline for the Management of Glomerular Diseases. Kidney Int. 2021;100(Suppl 4S):S1–S276. <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-Glomerular-Diseases-Guideline-2021-English.pdf" target="_blank" rel="noopener noreferrer">Úplné odporúčanie</a>, najmä kapitoly 1, 3 a 6.</em></small></p>
<p><small><em>[4] KDIGO ANCA Vasculitis Work Group. KDIGO 2024 Clinical Practice Guideline for the Management of Antineutrophil Cytoplasmic Antibody (ANCA)-Associated Vasculitis. Kidney Int. 2024;105(Suppl 3S):S71–S116. <a href="https://kdigo.org/wp-content/uploads/2024/05/KDIGO-2024-ANCA-Vasculitis-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčanie</a>, praktický bod 9.1.1.</em></small></p>
<p><small><em>[5] Schnuelle P. Renal Biopsy for Diagnosis in Kidney Disease: Indication, Technique, and Safety. J Clin Med. 2023;12(19):6424. DOI: <a href="https://doi.org/10.3390/jcm12196424" target="_blank" rel="noopener noreferrer">10.3390/jcm12196424</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37835066/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
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
    'log_prefix' => 'add_biopsia-obliciek-glomerularne-ochorenia_article',
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
