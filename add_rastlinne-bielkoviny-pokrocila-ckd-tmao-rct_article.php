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
    'title' => 'Viac rastlinných bielkovín pri pokročilej CKD: randomizovaná štúdia ukázala pokles TMAO bez rozdielu v draslíku',
    'slug' => 'rastlinne-bielkoviny-pokrocila-ckd-tmao-rct',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt' => 'Štvortýždňová japonská RCT pri eGFR pod 20 ml/min/1,73 m²: strava so 70 % rastlinných bielkovín znížila TMAO, IS a PCS sa významne nelíšili a draslík sa medzi skupinami významne nelíšil.',
    'content'      => <<<'HTML'
<p>Japonská randomizovaná štúdia overovala, či pri rovnakom množstve bielkovín zmení vyšší podiel rastlinných zdrojov hladiny uremických toxínov u pacientov s eGFR pod 20 ml/min/1,73 m². Po štyroch týždňoch klesol trimetylamín-N-oxid (TMAO), pri indoxylsulfáte a p-krezylsulfáte sa významný rozdiel nenašiel a zmena sérového draslíka sa medzi skupinami významne nelíšila [1].</p>
<figure><a href="img/rastlinne-bielkoviny-pokrocila-ckd-tmao-rct.webp" rel="noopener noreferrer" target="_blank"><img src="img/rastlinne-bielkoviny-pokrocila-ckd-tmao-rct.webp" alt="Strukoviny, brokolica a kel vedľa polopriesvitnej obličky so svetielkujúcimi časticami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna vytvorená s podporou umelej inteligencie, nie snímka konkrétneho pacienta ani stravy zo štúdie.</figcaption></figure>
<p>Výsledok je zaujímavý najmä pre obavu z hyperkaliémie, pre ktorú sa pacientom v pokročilých štádiách CKD často obmedzuje zelenina, ovocie a strukoviny. Štúdia je však malá, krátka a klinické výsledky nesledovala [1].</p>

<h2>Prečo môže záležať na zdroji bielkovín</h2>
<p>Pri CKD sa hromadia uremické toxíny, ktoré vznikajú činnosťou črevnej mikrobioty: indoxylsulfát (IS), p-krezylsulfát (PCS) a TMAO. Prekurzormi TMAO sú najmä cholín a karnitín zo živočíšnych potravín. Rastlinná strava prináša viac vlákniny a menšiu kyslú záťaž. Intervenčných údajov u ľudí s pokročilou CKD je však málo [1].</p>
<p>KDIGO 2024 navrhuje u dospelých s CKD G3 až G5 udržiavať príjem bielkovín 0,8 g/kg/deň a v praktickom bode odporúča pestrú stravu s vyšším podielom rastlinných potravín v porovnaní so živočíšnymi a s menším podielom ultraspracovaných potravín [2]. Japonská štúdia testovala práve zloženie bielkovín pri nezmenenom množstve.</p>

<h2>Dizajn štúdie</h2>
<p>Do randomizovanej kontrolovanej štúdie zaradili 36 japonských pacientov s eGFR pod 20 ml/min/1,73 m² a sérovým draslíkom pod 5,5 mEq/l, ktorí užívali inhibítory systému renín-angiotenzín. Medián eGFR bol 13 ml/min/1,73 m² (IQR 10 až 17) a 55 % tvorili ženy. Obe skupiny po 18 pacientov dostávali štyri týždne vopred pripravenú stravu s príjmom bielkovín 0,8 g/kg/deň. V intervenčnej skupine pochádzalo z rastlinných zdrojov 70 % bielkovín, v kontrolnej 50 % [1].</p>
<p>Primárnymi ukazovateľmi boli sérové koncentrácie IS, PCS a TMAO. Sekundárne ukazovatele zahŕňali venózny bikarbonát, sérové mastné kyseliny s krátkym reťazcom a zloženie fekálnej mikrobioty určené sekvenovaním 16S rRNA. Dobrú adherenciu k diéte uviedlo 34 pacientov (94 %) [1].</p>

<h2>Výsledky</h2>
<div class="table-responsive" role="region" aria-label="Primárne výsledky štúdie" tabindex="0">
<table>
<thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Rozdiel medzi skupinami po 4 týždňoch (95 % IS)</th><th scope="col">p upravené na FDR</th></tr></thead>
<tbody>
<tr><th scope="row">TMAO</th><td>−4,6 µg/ml (−7,2 až −2,0)</td><td>0,003</td></tr>
<tr><th scope="row">Indoxylsulfát</th><td>−0,8 µg/ml (−2,5 až 0,9)</td><td>0,5</td></tr>
<tr><th scope="row">p-krezylsulfát</th><td>−0,9 µg/ml (−5,1 až 3,4)</td><td>0,7</td></tr>
</tbody>
</table>
</div>
<p>Rozdiely sú uvedené pre skupinu so 70 % rastlinných bielkovín oproti kontrolnej skupine. FDR znamená mieru falošných objavov (<em>false discovery rate</em>), teda korekciu na viacnásobné testovanie [1].</p>
<p>Diéta so 70 % rastlinných bielkovín zvýšila venózny bikarbonát, sérový vápnik a acetát a znížila parathormón. V mikrobiote ubudlo rodov spájaných so zápalom a pribudlo rodov, ktoré tvoria mastné kyseliny s krátkym reťazcom. Zmena sérového draslíka sa medzi skupinami významne nelíšila [1]. Veľkosť sekundárnych účinkov abstrakt číselne neuvádza.</p>

<h2>Ako výsledky čítať</h2>
<p>Pokles TMAO je biologicky zrozumiteľný, ide však o náhradný ukazovateľ. Štúdia nesledovala progresiu CKD, kardiovaskulárne príhody ani mortalitu, takže klinický prínos nedokazuje. Chýbajúci rozdiel v IS a PCS pri 18 pacientoch v skupine neznamená, že diéta na tieto toxíny nepôsobí. Štúdia na ich zachytenie mohla mať nedostatočnú štatistickú silu.</p>
<p>Údaj o draslíku je pre prax možno najdôležitejší, treba ho však čítať presne. Zaradení boli len pacienti s draslíkom pod 5,5 mEq/l, všetci užívali inhibítory RAS a strava bola pripravená vopred, teda s kontrolovaným zložením. Neprítomnosť významného rozdielu počas štyroch týždňov v malom súbore nie je dôkazom bezpečnosti. Výsledok sa nedá preniesť na pacientov s hyperkaliémiou, na pacientov, ktorí si stravu zostavujú sami, ani na pacientov liečených dialýzou [1].</p>
<p>Kontrolná skupina mala tiež polovicu bielkovín z rastlinných zdrojov. Štúdia teda porovnáva dve úrovne rastlinného podielu, nie rastlinnú stravu so stravou bežnou v Európe. Japonská populácia a jedálny lístok ďalej obmedzujú prenos výsledkov do našej praxe.</p>
<p>Ako klinický úsudok z toho vyplýva, že pri pokročilej CKD a normálnej kaliémii netreba rastlinné zdroje bielkovín obmedzovať automaticky. Zmenu stravy je rozumné plánovať s nutričným terapeutom, ako odporúča aj KDIGO [2], a sledovať pri nej draslík.</p>

<h2>Limity</h2>
<p>Malý súbor, štvortýždňové trvanie, náhradné ukazovatele, adherencia hodnotená podľa údajov pacientov, jedna japonská populácia a výber pacientov bez hyperkaliémie liečených inhibítormi RAS. Plný text článku nebol pri príprave dostupný, číselné údaje pochádzajú zo štruktúrovaného abstraktu. Register ClinicalTrials.gov uvádza skutočný počet zaradených osôb 40, publikácia 36 randomizovaných. Rozdiel abstrakt nevysvetľuje, môže ísť o osoby vylúčené pred randomizáciou [1, 3].</p>

<h2>Záver</h2>
<p>Normoproteínová strava so 70 % rastlinných bielkovín počas štyroch týždňov znížila TMAO a priaznivo ovplyvnila acidobázickú rovnováhu a mikrobiotu bez významného rozdielu v draslíku oproti kontrolnej strave. Ide o sľubný, ale predbežný signál. Na odporúčania potrebujeme väčšie a dlhšie štúdie s klinickými výsledkami.</p>
<p><small><em>Článok je určený zdravotníckym pracovníkom a nenahrádza individuálne klinické ani nutričné posúdenie.</em></small></p>
<hr>
<p><small><em><strong>Zdroj:</strong> [1] Ryuta Uwatoko, Yusuke Sakaguchi, Tatsufumi Oka, Yohei Doi, Yuki Kawano, Hikaru Kadono, Shungo Fukuda, Ryohei Yamamoto, Isao Matsui, Masayuki Mizui, Jun-Ya Kaimori, Yoshitaka Isaka. Normoproteic Plant-Dominant Protein Diets, Uremic Toxins, and Gut Microbiota in Patients With Advanced CKD: A Randomized Controlled Trial. Am J Kidney Dis. 2026. 88(6), 948-958.e1. <a href="https://doi.org/10.1053/j.ajkd.2026.07.008" target="_blank" rel="noopener noreferrer">DOI 10.1053/j.ajkd.2026.07.008</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42767319/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.ajkd.org/article/S0272-6386(26)01119-4/abstract" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[2] Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024. 105(4S), S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2023.10.018</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></p>
<p><small><em>[3] A Randomized Controlled Trial to Evaluate the Efficacy of Plant-protein Diets in Patients With Chronic Kidney Disease: a Pilot-study. ClinicalTrials.gov NCT05350098. <a href="https://clinicaltrials.gov/study/NCT05350098" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</em></small></p>
<p><small><em><strong>Poznámka k dôkazom:</strong> Plné znenie článku [1] je za platobnou bránou. Čísla, dizajn a limity sme overili v štruktúrovanom abstrakte na stránke vydavateľa a v PubMed, primárny ukazovateľ a počet zaradených v registri [3]. Znenie odporúčania 3.3.1.1 a praktických bodov 3.3.1 a 3.3.2 sme overili v PDF usmernenia [2]. Výklad v častiach o čítaní výsledkov je vlastnou interpretáciou autora článku.</em></small></p>
<h3>Súvisiace články</h3>
<ul>
<li><a href="article.php?slug=bielkoviny-ckd-mnozstvo-kvalita-individualizacia">Bielkoviny pri CKD: otázka nie je len „koľko“, ale aj „pre koho“</a></li>
<li><a href="article.php?slug=cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao">Doplnky s cholínom a L-karnitínom pri diabetickej nefropatii a TMAO</a></li>
<li><a href="article.php?slug=draslik-fosfor-pridavne-latky-ckd">Draslík, fosfor a prídavné látky pri CKD</a></li>
</ul>
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
    'log_prefix' => 'add_rastlinne-bielkoviny-pokrocila-ckd-tmao-rct_article',
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
