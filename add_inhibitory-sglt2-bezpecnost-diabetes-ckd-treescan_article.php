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
    'title' => 'Bezpečnosť inhibítorov SGLT2 pri diabete 2. typu a CKD: plošné skenovanie nenašlo nové signály',
    'slug' => 'inhibitory-sglt2-bezpecnost-diabetes-ckd-treescan',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt' => 'Kohortová štúdia z Medicare a MarketScan potvrdila pri inhibítoroch SGLT2 známy signál genitálnych infekcií a nový nezachytila. Neprítomnosť signálu však nie je dôkazom neprítomnosti rizika.',
    'content'      => <<<'HTML'
<p>Pacienti s diabetom 2. typu a chronickou chorobou obličiek sú v randomizovaných štúdiách zastúpení menej, než zodpovedá ich počtu v praxi. Americká kohortová štúdia z dvoch poisťovacích databáz preto plošne prehľadala diagnózy po začatí liečby inhibítorom SGLT2 alebo agonistom receptora GLP-1. Potvrdila známy signál genitálnych infekcií a nový bezpečnostný signál nezachytila [1].</p>
<figure><a href="img/inhibitory-sglt2-bezpecnost-diabetes-ckd-treescan.webp" rel="noopener noreferrer" target="_blank"><img src="img/inhibitory-sglt2-bezpecnost-diabetes-ckd-treescan.webp" alt="Polopriesvitná oblička, rozvetvená štruktúra z jemných svetelných línií a biele tablety na tmavom povrchu" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna vytvorená s podporou umelej inteligencie, nie snímka konkrétneho pacienta ani lieku.</figcaption></figure>
<p>Metóda je skríning, ktorý vytvára hypotézy, nie odhad rizika konkrétnej príhody. Neprítomnosť signálu preto neznamená neprítomnosť rizika. Dokladá to aj staršia cielená analýza tej istej výskumnej skupiny [1, 3].</p>

<h2>Čo je stromová skenovacia štatistika</h2>
<p>Bezpečnosť liekov sa tradične hodnotí podľa vopred určených výsledkov. Stromová skenovacia štatistika (TreeScan) postupuje inak. Prechádza hierarchický strom diagnóz ICD-10 od širších kategórií po konkrétne kódy a hľadá uzly, v ktorých sa príhody v exponovanej skupine vyskytujú častejšie, než by sa čakalo. Korekciu na viacnásobné testovanie zabezpečuje simulácia Monte Carlo [1, 4]. V tejto štúdii autori vyhodnotili 53 016 uzlov na úrovniach 3 až 6 [1].</p>

<h2>Dizajn</h2>
<p>Išlo o kohortovú štúdiu nových užívateľov s aktívnym komparátorom. Údaje pochádzali z programu Medicare Fee-for-Service (október 2016 až december 2020, vek aspoň 65 rokov) a z komerčnej databázy MarketScan (október 2016 až december 2022, vek aspoň 18 rokov). Zaradení mali diabetes 2. typu a CKD štádia 3 alebo 4 určenú podľa diagnostických kódov. Skupinu inhibítorov SGLT2 tvorili kanagliflozín, dapagliflozín, empagliflozín a ertugliflozín, komparátorom boli agonisti receptora GLP-1. Pacientov párovali v pomere 1 : 1 podľa skóre propenzity zo 60 vopred určených premenných vrátane indexu krehkosti a sledovali ich počas liečby [1].</p>
<p>Po spárovaní vzniklo 22 328 párov v Medicare (priemerný vek 74 rokov, 45 % žien, 20 % krehkých) a 8 918 párov v MarketScan (priemerný vek 65 rokov, 42 % žien, 6 % krehkých). Všetky štandardizované rozdiely medzi skupinami boli pod 0,1 [1].</p>

<h2>Výsledky</h2>
<p>V súbore Medicare zachytila analýza naprieč ambulantnou, nemocničnou a urgentnou starostlivosťou 13 štatisticky významných signálov. Všetky sa týkali kandidózy a iných genitálnych infekcií alebo glykozúrie. Kandidóza vulvy a vagíny mala relatívne riziko 1,61 (267 prípadov pri 165,5 očakávaných), balanitída 1,64. V súbore MarketScan bolo významných 8 signálov a týkali sa genitálnych infekcií žien a glykozúrie [1].</p>
<p>Pri obmedzení na hospitalizácie a urgentné príjmy, s ročným obdobím vymývania aj bez neho, nedosiahol štatistickú významnosť žiadny signál v žiadnej z databáz [1].</p>

<h2>Čo výsledok znamená a čo nie</h2>
<p>Genitálne mykotické infekcie sú známym účinkom liekov, ktoré zvyšujú glykozúriu. To, že ich metóda našla v oboch databázach, svedčí o jej citlivosti na skutočný signál. Autori výsledok hodnotia ako upokojujúci: u pacientov s CKD, multimorbiditou a polyfarmáciou sa neobjavilo nové bezpečnostné riziko [1].</p>
<p>Treba však vedieť, čo skríning nevidí. TreeScan potrebuje dostatočný nadbytok prípadov a pri zriedkavých alebo nejednotne kódovaných príhodách má malú silu. Diabetická ketoacidóza sa v Medicare pri hospitalizáciách a urgentných príjmoch vyskytla v skupine s inhibítormi SGLT2 v 66 prípadoch pri 50 očakávaných (relatívne riziko 1,32), signál však nebol významný. Autori dodávajú, že euglykemická ketoacidóza môže byť poddiagnostikovaná alebo nesprávne kódovaná [1].</p>
<p>Staršia cielená kohortová analýza tej istej skupiny autorov porovnávala tie isté triedy liekov u 96 128 dospelých s CKD štádia 3 alebo 4 a diabetom 2. typu. Pri inhibítoroch SGLT2 zistila vyššie riziko nevertebrálnych zlomenín (HR 1,30; 95 % IS 1,03 až 1,65), amputácií dolnej končatiny (HR 1,65; 95 % IS 1,22 až 2,23) a genitálnych infekcií (HR 3,08; 95 % IS 2,73 až 3,48) [3]. Zlomeniny ani amputácie TreeScan ako signál nezachytil. Nejde o rozpor, ale o rozdiel otázok: cielená analýza odhaduje riziko vopred zvolenej príhody, skenovanie hľadá neočakávané zhluky medzi desaťtisícmi diagnóz. Výsledky plošného skenovania teda cielené analýzy dopĺňajú, nenahrádzajú.</p>
<p>Na liečebnom odporúčaní sa nič nemení. KDIGO 2024 odporúča inhibítor SGLT2 u pacientov s diabetom 2. typu, CKD a eGFR aspoň 20 ml/min/1,73 m² (1A). V liečbe je rozumné pokračovať aj pri poklese eGFR pod 20 ml/min/1,73 m², ak je tolerovaná a nezačala sa náhrada funkcie obličiek [2]. Ako klinický úsudok zo štúdie vyplýva najmä potreba poučiť pacienta pri začatí liečby o hygiene a príznakoch genitálnej infekcie.</p>

<h2>Limity</h2>
<p>Ide o observačnú štúdiu s možným reziduálnym zmiešavaním. CKD bola určená len podľa diagnostických kódov, bez údajov o eGFR a albuminúrii. Výsledky platia pre spárovanú populáciu a pre obdobie liečby. Pri zriedkavých príhodách má metóda obmedzenú silu. Signály sú relatívne voči agonistom receptora GLP-1, ktoré majú vlastný profil nežiaducich účinkov, nie voči placebu. Štúdiu podporili granty NIDDK, PCORI a FDA. Jedna z autoriek bola riešiteľkou grantov firiem Boehringer Ingelheim, AstraZeneca a Bayer pre svoju nemocnicu [1].</p>

<h2>Záver</h2>
<p>Plošné skenovanie nežiaducich udalostí u pacientov s diabetom 2. typu a CKD potvrdilo známe riziko genitálnych infekcií pri inhibítoroch SGLT2 a nenašlo nové signály. Výsledok podporuje doterajšie odporúčania, nie je však dôkazom, že iné riziká neexistujú.</p>
<p><small><em>Článok je určený zdravotníckym pracovníkom a nenahrádza individuálne klinické posúdenie ani súhrn charakteristických vlastností lieku.</em></small></p>
<hr>
<p><small><em><strong>Zdroj:</strong> [1] Janinne Ortega-Montiel, Wajd Alkabbani, Georg Hahn, Jun Liu, Caroline F Byrne, Deborah J Wexler, Elisabetta Patorno, Julie M Paik. Safety of Sodium/Glucose Cotransporter 2 Inhibitors in Patients With Type 2 Diabetes and CKD. Am J Kidney Dis. 2026. 88(6), 937-947.e1. <a href="https://doi.org/10.1053/j.ajkd.2026.06.013" target="_blank" rel="noopener noreferrer">DOI 10.1053/j.ajkd.2026.06.013</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42767321/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.ajkd.org/article/S0272-6386(26)01118-2/fulltext" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></p>
<p><small><em>[2] Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024. 105(4S), S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2023.10.018</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></p>
<p><small><em>[3] Edouard L Fu, Elvira D'Andrea, Deborah J Wexler, Elisabetta Patorno, Julie M Paik. Safety of Sodium-Glucose Cotransporter-2 Inhibitors in Patients with CKD and Type 2 Diabetes: Population-Based US Cohort Study. Clin J Am Soc Nephrol. 2023. 18(5), 592-601. <a href="https://doi.org/10.2215/CJN.0000000000000115" target="_blank" rel="noopener noreferrer">DOI 10.2215/CJN.0000000000000115</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36827225/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10278835/" target="_blank" rel="noopener noreferrer">PMC</a>.</em></small></p>
<p><small><em>[4] Martin Kulldorff, Zixing Fang, Stephen J Walsh. A tree-based scan statistic for database disease surveillance. Biometrics. 2003. 59(2), 323-31. <a href="https://doi.org/10.1111/1541-0420.00039" target="_blank" rel="noopener noreferrer">DOI 10.1111/1541-0420.00039</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/12926717/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
<p><small><em><strong>Poznámka k dôkazom:</strong> Článok [1] je voľne dostupný a bol prečítaný v plnom znení vrátane tabuliek signálov. Čísla porovnávacej analýzy [3] pochádzajú z jej štruktúrovaného abstraktu, znenie odporúčania 3.7.1 a praktického bodu 3.7.1 z PDF usmernenia [2]. Autorské zoznamy a identifikátory boli overené v PubMed. Porovnanie výsledkov [1] a [3] je vlastnou interpretáciou autora článku.</em></small></p>
<h3>Súvisiace články</h3>
<ul>
<li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov</a></li>
<li><a href="article.php?slug=kombinovana-nefroprotektivna-liecba-ckd-ras-sglt2-finerenon">Kombinovaná nefroprotektívna liečba pri chronickej chorobe obličiek</a></li>
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
    'log_prefix' => 'add_inhibitory-sglt2-bezpecnost-diabetes-ckd-treescan_article',
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
