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
    'title'        => 'UACR a UPCR pri CKD: podobná prognostická informácia, rozdielne klinické použitie',
    'slug'         => 'uacr-upcr-prognosticka-informacia-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Analýza CRIC ukazuje podobnú prognostickú výkonnosť UACR a UPCR. Čo tento výsledok znamená pre klasifikáciu CKD, výpočet rizika a každodenné rozhodovanie?',
    'content'      => <<<'HTML'
<p>Pomer albumínu ku kreatinínu v moči (UACR) a pomer celkových bielkovín ku kreatinínu v moči (UPCR) zachytávajú príbuzné, ale nie totožné informácie. Analýza kohorty CRIC publikovaná v časopise <em>JAMA</em> ukázala veľmi podobnú prognostickú výkonnosť modelov s týmito ukazovateľmi u dospelých s chronickým ochorením obličiek (CKD). Výsledok podporuje využitie dostupného UPCR pri hodnotení prognózy, neodôvodňuje však automatickú náhradu UACR pri diagnostike, klasifikácii alebo liečebných rozhodnutiach. [1, 2]</p>

<figure>
<a href="img/uacr-upcr-prognosticka-informacia-ckd.webp" target="_blank" rel="noopener noreferrer"><img src="img/uacr-upcr-prognosticka-informacia-ckd.webp" alt="Symbolické zobrazenie albumínu a rôznych močových bielkovín pri obličke a dvoch laboratórnych vzorkách" width="1586" height="992" loading="lazy" decoding="async"></a>
<figcaption>UACR meria albumín, UPCR celkové bielkoviny. Ilustračná vizualizácia biomarkerov, nie anatomická schéma toku moču ani dôkaz zameniteľnosti vyšetrení.</figcaption>
</figure>

<h2>Čo ukázala analýza CRIC</h2>
<p>Verma a spoluautori analyzovali 3 742 účastníkov so vstupným UACR a UPCR stanovenými z toho istého 24-hodinového zberu moču. Priemerná odhadovaná glomerulárna filtrácia (eGFR) bola 42,3 ml/min/1,73 m² a medián sledovania 15 rokov. Hodnotili zlyhanie obličiek, progresiu CKD a kardiovaskulárne príhody. Išlo o observačnú prognostickú analýzu, nie o randomizované porovnanie dvoch vyšetrovacích stratégií. [1]</p>
<p>Ukazovatele silno korelovali (Spearmanov koeficient 0,92). Pri päťročnej predikcii zlyhania obličiek dosahovala plocha pod ROC krivkou 0,894 pre model s UACR a 0,899 pre model s UPCR. Rozdiel bol menší než autormi vopred zvolená hranica klinickej významnosti 0,01. Malé rozdiely sa pozorovali aj pri ostatných výsledkoch a desaťročnom horizonte. [1]</p>
<p>Rozhodovacie krivky ukázali rozdiely čistého prínosu najviac tri na 1 000 osôb v osobitne sledovaných pásmach rozhodovacích prahov. Tento údaj neplatí bez obmedzenia pre všetky prahy. Vyjadruje modelovaný prínos po zohľadnení falošne pozitívnych rozhodnutí, nie počet skutočne odvrátených zlyhaní obličiek alebo ušetrených výkonov. [1]</p>

<h2>Podobná predikcia neznamená rovnaký biologický význam</h2>
<p><strong>UACR vyjadruje albuminúriu, kým UPCR zahŕňa albumín aj ostatné močové bielkoviny.</strong> Albumín je dôležitým ukazovateľom glomerulárneho poškodenia. Pri tubulárnej alebo nadprodukčnej proteinúrii, napríklad pri vylučovaní monoklonálnych ľahkých reťazcov, môže byť podiel nealbumínových bielkovín podstatný. Nízke UACR preto samo osebe nevylučuje významnú nealbumínovú proteinúriu. [2, 3]</p>
<p>Kreatinín v menovateli zmierňuje vplyv zriedenia moču, neodstraňuje však všetku variabilitu. Výsledok ovplyvňuje aj tvorba a vylučovanie kreatinínu, telesná konštitúcia a okolnosti odberu. Dôležité sú jednotky: mg/g a mg/mmol sa nesmú zamieňať. Rovnako nemožno pri tej istej jednotke považovať hodnotu UPCR za hodnotu UACR. [2]</p>

<h2>Ako výsledok zapadá do širších dôkazov</h2>
<p>Metaanalýza individuálnych údajov CKD Prognosis Consortium zahŕňajúca 148 994 osôb z 38 kohort zistila silnejšiu asociáciu UACR so zlyhaním obličiek než pri UPCR. Pomer rizík na štandardnú odchýlku logaritmicky transformovaného ukazovateľa bol 2,55 pre UACR a 2,40 pre UPCR. Rozdiely boli výraznejšie v niektorých klinických podskupinách; kardiovaskulárne asociácie boli celkovo podobnejšie. [3]</p>
<p>Tieto závery sa nemusia vylučovať s analýzou CRIC. <strong>Sila asociácie jedného biomarkera s výsledkom nie je to isté ako diskriminácia celého klinického modelu.</strong> Model už obsahujúci vek, eGFR a ďalšie premenné môže dosahovať podobnú predikciu pri oboch ukazovateľoch. Rozdielne kohorty, horizonty a štatistické otázky preto treba porovnávať vecne, nie iba podľa titulkov publikácií. Ide o interpretáciu rozdielov medzi štúdiami. [1, 3]</p>

<h2>Čo sa v ambulancii nemení</h2>
<p>KDIGO 2024 uprednostňuje UACR pri úvodnom vyšetrení albuminúrie a preferuje prvú rannú vzorku stredného prúdu moču. UACR ≥ 30 mg/g (≥ 3 mg/mmol) z náhodnej vzorky sa má potvrdiť následným ranným odberom. Jediný abnormálny nález ešte sám osebe nepreukazuje chronickosť ochorenia. [2]</p>
<div class="table-responsive" role="region" aria-label="Použitie UACR a UPCR v klinických situáciách" tabindex="0">
<table>
<thead><tr><th scope="col">Klinická otázka</th><th scope="col">Praktický postup</th></tr></thead>
<tbody>
<tr><th scope="row">Kategória albuminúrie A1 až A3</th><td>Použiť UACR. Kategórie albuminúrie nemožno priamo priradiť z rovnakej číselnej hodnoty UPCR. [2]</td></tr>
<tr><th scope="row">Výpočet rizika zlyhania obličiek pomocou KFRE</th><td>Štvorpremenná rovnica Kidney Failure Risk Equation (KFRE) vyžaduje UACR. UPCR nevkladať priamo do poľa pre albuminúriu. [2, 4]</td></tr>
<tr><th scope="row">Rozhodnutie podľa albuminurického prahu</th><td>Zmerať UACR a rešpektovať kritériá konkrétneho odporúčania alebo lieku. Prognostická štúdia tieto prahy nepredefinovala. [1, 2]</td></tr>
<tr><th scope="row">Výrazná proteinúria pri relatívne nízkom UACR</th><td>Posúdiť nealbumínovú zložku a podľa kontextu doplniť vyšetrenia tubulárnej proteinúrie alebo monoklonálneho proteínu. [2, 3]</td></tr>
</tbody>
</table>
</div>

<h2>Ako pracovať s už dostupným UPCR</h2>
<p>Existujúce UPCR netreba považovať za bezcenný údaj. Pri známom CKD poskytuje prognostickú informáciu a umožňuje sledovať celkovú proteinúriu. Ak však rozhodnutie závisí od albuminúrie, je vhodné UACR doplniť. Pri dlhodobom sledovaní treba zaznamenávať, ktorý ukazovateľ sa používa, a zmenu vyšetrenia neinterpretovať ako biologickú zmenu ochorenia. [1, 2]</p>
<p>Publikované rovnice umožňujú odhadnúť UACR z UPCR, keď priame stanovenie chýba. Sumida a spoluautori ich skúmali v metaanalýze 919 383 osôb. Ide však o <strong>odhad s neistotou na úrovni jednotlivca</strong>, nie o laboratórne zmeraný albumín; vzťah je zvlášť problematický pri nízkej proteinúrii. Odhad musí byť výslovne označený a použitie vo výpočte rizika musí zodpovedať validovanému postupu. Vlastný neoverený prepočet nie je primeranou náhradou. [4]</p>
<p>Analýza CRIC sa týka pacientov s etablovaným CKD. Nedokazuje rovnocennosť pri populačnom skríningu, pri hodnotení odpovede na liečbu ani pri sledovaní pacientov, ktorí už podstupujú udržiavaciu dialýzu. Klinickým posolstvom je rozumné využitie oboch ukazovateľov podľa otázky, ktorú potrebujeme zodpovedať.</p>

<hr>
<p><small><em><strong>Zdroj:</strong> [1] Verma A, Schmidt IM, Claudel SE, Waikar SS. Prediction Utility of Urinary Albumin-Creatinine vs Protein-Creatinine Ratios in Chronic Kidney Disease. JAMA. Publikované online 23. septembra 2026. DOI: <a href="https://doi.org/10.1001/jama.2026.16237" target="_blank" rel="noopener noreferrer">10.1001/jama.2026.16237</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42776523/" target="_blank" rel="noopener noreferrer">PubMed</a>. Slovenské odborné spracovanie doplnené o klinický kontext nasledujúcich zdrojov.</em></small></p>
<p><small><em>[2] KDIGO CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Úplné odporúčanie</a>.</em></small></p>
<p><small><em>[3] Heerspink HJL a kol.; CKD Prognosis Consortium. Proteinuria or Albuminuria as Markers of Kidney and Cardiovascular Disease Risk: An Individual Patient-Level Meta-analysis. Ann Intern Med. 2026;179(1):32–41. DOI: <a href="https://doi.org/10.7326/ANNALS-25-02117" target="_blank" rel="noopener noreferrer">10.7326/ANNALS-25-02117</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41183334/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
<p><small><em>[4] Sumida K a kol. Conversion of Urine Protein-Creatinine Ratio or Urine Dipstick Protein to Urine Albumin-Creatinine Ratio for Use in Chronic Kidney Disease Screening and Prognosis: An Individual Participant-Based Meta-analysis. Ann Intern Med. 2020. DOI: <a href="https://doi.org/10.7326/M20-0529" target="_blank" rel="noopener noreferrer">10.7326/M20-0529</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32658569/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
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
    'log_prefix' => 'add_uacr-upcr-prognosticka-informacia-ckd_article',
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
