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
    'title'        => 'Štyri piliere liečby pri diabete 2. typu a CKD G4 až G5',
    'slug'         => 'styri-piliere-diabetes-ckd-g4-g5',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Pri pokročilej chronickej chorobe obličiek sa hranice začatia, pokračovania a obnovenia liečby líšia podľa liekovej skupiny aj klinickej situácie.',
    'content'      => <<<'HTML'
<figure><img src="img/styri-piliere-diabetes-ckd-g4-g5.webp" alt="Priehľadný model obličiek a neoznačené liekové formy" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Zobrazené liekové formy nepredstavujú konkrétne prípravky.</figcaption></figure>

<p>Pri diabete 2. typu a chronickej chorobe obličiek (CKD) sa hranica na začatie liečby často líši od hranice na jej ukončenie. V štádiu G4, pri odhadovanej glomerulovej filtrácii (eGFR) od 15 do menej ako 30 ml/min/1,73 m², sa možnosti menia už v rámci jedného štádia. Pri G5 pred dialýzou, s eGFR pod 15 ml/min/1,73 m², je priamych dôkazov podstatne menej. Naratívny prehľad Yamanouchiho a spoluautorov zhrnul údaje o jednotlivých liekových skupinách. Súbežné začatie všetkých štyroch v G4 alebo G5 samostatne netestoval [1].</p>

<h2>Inhibítor ACE alebo sartán</h2>
<p>Pri diabete a stredne až výrazne zvýšenej albuminúrii KDIGO odporúča v štádiách G1 až G4 inhibítor angiotenzín konvertujúceho enzýmu (ACE) alebo blokátor receptora AT₁ pre angiotenzín II (sartán). Po začatí alebo zvýšení dávky treba skontrolovať krvný tlak, kreatinín a draslík spravidla do dvoch až štyroch týždňov podľa funkcie obličiek a koncentrácie draslíka. Vzostup kreatinínu o viac ako 30 % v prvých štyroch týždňoch je dôvodom zhodnotiť stav objemu tekutín, súbežné lieky a iné príčiny zhoršenia funkcie obličiek [1, 6].</p>
<p>V štúdii STOP-ACEi u 411 pacientov s pokročilou progresívnou CKD vysadenie už zavedenej blokády systému renín-angiotenzín nezlepšilo eGFR po troch rokoch. Štúdia zahŕňala aj pacientov bez diabetu a nehodnotila začatie liečby v G5. Samotný pokles eGFR pod 30 ml/min/1,73 m² podľa KDIGO nie je dôvodom na vysadenie. Pri symptomatickej hypotenzii, nezvládnuteľnej hyperkaliémii napriek liečbe alebo potrebe zmierniť uremické príznaky pri zlyhaní obličiek možno dávku znížiť alebo liek vysadiť [1, 2, 6].</p>

<h2>Inhibítor SGLT2</h2>
<p>EMPA-KIDNEY zahŕňala pacientov s eGFR od 20 ml/min/1,73 m², s diabetom aj bez diabetu. Empagliflozín znížil riziko progresie choroby obličiek alebo kardiovaskulárneho úmrtia v celej populácii štúdie (pomer hazardov 0,72, 95 % interval spoľahlivosti od 0,64 do 0,82). KDIGO odporúča pri diabete 2. typu a CKD začať inhibítor SGLT2 pri eGFR aspoň 20 ml/min/1,73 m². Pri voľbe lieku treba zohľadniť jeho európsky súhrn charakteristických vlastností. Hranica, pod ktorou EMA začatie neodporúča, je pri empagliflozíne eGFR 20 ml/min/1,73 m² a pri dapagliflozíne GFR 25 ml/min [1, 3, 6, 7, 8].</p>
<p>Pri dobrej tolerancii možno podľa KDIGO pokračovať aj po poklese eGFR pod 20 ml/min/1,73 m² až do začatia liečby nahrádzajúcej funkciu obličiek. Toto odporúčanie sa týka už zavedenej liečby. Malý počiatočný pokles eGFR býva reverzibilný. Pri dlhšom hladovaní, operácii alebo kritickom ochorení je primerané liek dočasne prerušiť pre riziko ketózy. Obnovenie je vhodné posúdiť po stabilizácii a obnovení príjmu potravy, so zohľadnením príčiny prerušenia. Po prekonanej ketoacidóze treba postupovať podľa súhrnu charakteristických vlastností lieku [1, 6, 7, 8].</p>

<h2>Finerenón</h2>
<p>Pri pretrvávajúcej albuminúrii napriek maximálnej tolerovanej blokáde systému renín-angiotenzín je finerenón možnosťou pri normálnej koncentrácii draslíka a dostatočnej eGFR. FIDELIO-DKD zahŕňala pacientov od eGFR 25 ml/min/1,73 m² a preukázala prínos pre zložený obličkový výsledok v celej populácii štúdie. V podskupine G4 v súhrnnej analýze FIDELITY boli klinické odhady menej presné. Hyperkaliémia sa vyskytla častejšie pri finerenóne než pri placebe [1, 4, 6].</p>
<p>Podľa európskeho súhrnu charakteristických vlastností lieku sa finerenón pri CKD nezačína, ak koncentrácia draslíka v sére presahuje 5,0 mmol/l. Začatie pri eGFR pod 25 ml/min/1,73 m² sa neodporúča. Pri už zavedenej liečbe možno pri eGFR aspoň 15 ml/min/1,73 m² pokračovať s úpravou podľa draslíka. Pri progresii pod túto hranicu súhrn odporúča liečbu ukončiť. Draslík a eGFR sa kontrolujú po štyroch týždňoch od začatia, obnovenia alebo zvýšenia dávky. Ak draslík počas liečby prekročí 5,5 mmol/l, liek sa preruší a podľa dávkovacej tabuľky pre CKD možno obnoviť podávanie po poklese draslíka na 5,0 mmol/l alebo menej [9].</p>

<h2>Agonista receptora GLP-1</h2>
<p>Pri nedosiahnutí individuálneho cieľa glykémie napriek metformínu a inhibítoru SGLT2 alebo pri ich nevhodnosti odporúča KDIGO použiť dlhodobo pôsobiaci agonista receptora glukagónu podobného peptidu 1 (GLP-1). Výber ovplyvňuje aj kardiovaskulárne riziko. V štúdii FLOW u pacientov s albuminurickou CKD a diabetom 2. typu znížil semaglutid riziko primárneho zloženého výsledku, ktorý zahŕňal závažné obličkové príhody a kardiovaskulárne úmrtie (pomer hazardov 0,76, 95 % interval spoľahlivosti od 0,66 do 0,88). Dolná vstupná hranica eGFR bola 25 ml/min/1,73 m². Výsledok preto sám nepreukazuje účinok začatia liečby v G5 [1, 5, 6].</p>
<p>Pri semaglutide podľa európskeho súhrnu charakteristických vlastností lieku netreba upravovať dávku pri ľahkej, stredne ťažkej ani ťažkej poruche funkcie obličiek. Skúsenosti pri terminálnom zlyhaní obličiek sú obmedzené. Pri nevoľnosti, vracaní a nízkom príjme treba zhodnotiť riziko dehydratácie a výživový stav. Podmienky použitia iných agonistov GLP-1 sa môžu líšiť [1, 10].</p>

<h2>Prerušenie liečby má mať plán kontroly</h2>
<p>Pri dočasnom prerušení pre akútne poškodenie obličiek, hypovolémiu, hypotenziu alebo hyperkaliémiu je užitočné zapísať dôvod, termín kontroly a podmienky obnovenia. Po odznení príčiny treba overiť, či indikácia trvá, a podľa konkrétneho lieku posúdiť krvný tlak, stav hydratácie, príjem potravy, vývoj kreatinínu a draslík. Pri G5 je potrebné zohľadniť aj prípravu na dialýzu alebo konzervatívnu liečbu, toleranciu a priority pacienta. Údaje z nižších štádií CKD alebo z observačných kohort môžu rozhodnutie informovať, ich prenos na začatie liečby v G5 však zostáva neistý [1, 6].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Masayuki Yamanouchi, Naoki Sawa, Kengo Furuichi, Takashi Wada. Four Pillars in Type 2 Diabetes and Chronic Kidney Disease G4-G5: Mission Impossible-or Not Too Late to Start? Kidney Med. 2026;8(11):101516. <a href="https://doi.org/10.1016/j.xkme.2026.101516" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.xkme.2026.101516</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42890508/" target="_blank" rel="noopener noreferrer">PubMed 42890508</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13673336/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Sunil Bhandari, Samir Mehta, Arif Khwaja, John G F Cleland, Natalie Ives, Elizabeth Brettell, Marie Chadburn, Paul Cockwell, STOP ACEi Trial Investigators. Renin-Angiotensin System Inhibition in Advanced Chronic Kidney Disease. N Engl J Med. 2022;387(22):2021-2032. <a href="https://doi.org/10.1056/NEJMoa2210639" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2210639</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36326117/" target="_blank" rel="noopener noreferrer">PubMed 36326117</a></em></small></li>
<li><small><em>The EMPA-KIDNEY Collaborative Group, William G Herrington, Natalie Staplin, Christoph Wanner, Jennifer B Green, Sibylle J Hauske, Jonathan R Emberson, David Preiss, Parminder Judge, Kaitlin J Mayne, Sarah Y A Ng, Emily Sammons, Doreen Zhu, Michael Hill, Will Stevens, Karl Wallendszus, Susanne Brenner, Alfred K Cheung, Zhi-Hong Liu, Jing Li, Lai Seong Hooi, Wen Liu, Takashi Kadowaki, Masaomi Nangaku, Adeera Levin. Empagliflozin in Patients with Chronic Kidney Disease. N Engl J Med. 2023;388(2):117-127. <a href="https://doi.org/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2204233</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/36331190/" target="_blank" rel="noopener noreferrer">PubMed 36331190</a></em></small></li>
<li><small><em>George L Bakris, Rajiv Agarwal, Stefan D Anker, Bertram Pitt, Luis M Ruilope, Peter Rossing, Peter Kolkhof, Christina Nowack, Patrick Schloemer, Amer Joseph, Gerasimos Filippatos, FIDELIO-DKD Investigators. Effect of Finerenone on Chronic Kidney Disease Outcomes in Type 2 Diabetes. N Engl J Med. 2020;383(23):2219-2229. <a href="https://doi.org/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2025845</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33264825/" target="_blank" rel="noopener noreferrer">PubMed 33264825</a></em></small></li>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2403347</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed 38785209</a></em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2023.10.018</a> · <a href="https://kdigo.org/guidelines/ckd-evaluation--and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a></em></small></li>
<li><small><em>Európska lieková agentúra. Jardiance. Súhrn charakteristických vlastností lieku. <a href="https://www.ema.europa.eu/en/documents/product-information/jardiance-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
<li><small><em>Európska lieková agentúra. Forxiga. Súhrn charakteristických vlastností lieku. <a href="https://www.ema.europa.eu/en/documents/product-information/forxiga-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
<li><small><em>Európska lieková agentúra. Kerendia. Súhrn charakteristických vlastností lieku. <a href="https://www.ema.europa.eu/en/documents/product-information/kerendia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
<li><small><em>Európska lieková agentúra. Ozempic. Súhrn charakteristických vlastností lieku. <a href="https://www.ema.europa.eu/en/documents/product-information/ozempic-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a></em></small></li>
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
    'log_prefix' => 'add_styri_piliere_diabetes_ckd_g4_g5',
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
