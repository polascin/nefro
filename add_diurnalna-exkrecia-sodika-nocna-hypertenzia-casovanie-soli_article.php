<?php
/**
 * add_diurnalna-exkrecia-sodika-nocna-hypertenzia-casovanie-soli_article.php
 * Idempotentný publikačný skript odborného článku.
 * Spracovanie review Nephron 2026 (Karagiannidis et al.; PMID 42731064).
 */

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
    'title'        => 'Diurnálna exkrécia sodíka a nočná hypertenzia: načasovanie soli ako klinický problém',
    'slug'         => 'diurnalna-exkrecia-sodika-nocna-hypertenzia-casovanie-soli',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Porušená denná natriuréza a relatívne zvýšená nočná exkrécia sodíka súvisia s nočnou hypertenziou a oslabeným dippingom. Review v Nephron 2026 ukazuje, prečo má časovanie soli a ABPM klinický význam.',
    'content'      => <<<'HTML'
<p>Za fyziologických podmienok má arteriálny tlak cirkadiánny rytmus. Počas spánku typicky klesá oproti bdelosti približne o <strong>10 až 20&nbsp;%</strong> („nocturnal dipping“). Ak sa tento pokles stratí (blunted / non-dipping) alebo sa objaví <strong>nočná hypertenzia</strong>, stúpa kardiovaskulárne aj renálne riziko. Súbežne má vlastný diurnálny rytmus aj renálne hospodárenie so sodíkom: za normy prevažuje <strong>exkrécia sodíka cez deň</strong>.</p>

<p>Review v <em>Nephron</em> (2026) syntetizuje dôkazy, že <strong>porušená diurnálna exkrécia sodíka</strong> – oslabená denná a/alebo relatívne zvýšená nočná natriuréza – prispieva k abnormálnemu nočnému profilu krvného tlaku. Nasledujúci text rozoberá mechanizmy, klinickú logiku aj limity interpretácie; nie je to univerzálny liečebný algoritmus.</p>

<h2>Kľúčové posolstvá</h2>

<ul>
  <li><strong>Porušená diurnálna exkrécia sodíka</strong> je úzko spojená s nočnou hypertenziou a so zhoršeným nočným dippingom.</li>
  <li><strong>Nočný krvný tlak</strong> je silný prediktor kardiovaskulárneho a renálneho rizika a má sa hodnotiť cieleným ambulantným meraním (ABPM), najmä pri CKD, diabete, spánkovom apnoe, autonómnej dysfunkcii alebo pri rozpore medzi ordináciou a rizikom.</li>
  <li>Kombinácia <strong>ABPM</strong> a <strong>časovaného zberu moču</strong> (deň vs. noc) na sodík môže zlepšiť stratifikáciu rizika a podporiť individualizovaný manažment.</li>
</ul>

<p>Časovanie fyziologických dejov – krvného tlaku aj renálneho spracovania soli – môže byť rovnako dôležité ako samotná veľkosť dennej sodíkovej záťaže.</p>

<h2>Definície, ktoré treba mať jasné pred interpretáciou</h2>

<div class="table-responsive" role="region" aria-label="Praktické definície nočného tlaku a dippingu podľa ESH 2023" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Pojem</th>
      <th scope="col">Praktická definícia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nočná hypertenzia (ABPM)</th>
      <td>Priemerný nočný tlak ≥&nbsp;120/70&nbsp;mmHg (ESH 2023)</td>
    </tr>
    <tr>
      <th scope="row">Denný ambulantný prah</th>
      <td>≥&nbsp;135/85&nbsp;mmHg; 24-hodinový priemer ≥&nbsp;130/80&nbsp;mmHg</td>
    </tr>
    <tr>
      <th scope="row">Normálny dipping</th>
      <td>Pokles nočného oproti dennému priemeru približne o 10–20&nbsp;%</td>
    </tr>
    <tr>
      <th scope="row">Non-dipping / blunted dipping</th>
      <td>Pokles &lt;&nbsp;10&nbsp;%; reverse dipping = nočný nárast</td>
    </tr>
    <tr>
      <th scope="row">Diurnálny pomer sodíka</th>
      <td>Pomer dennej a nočnej rýchlosti exkrécie Na⁺ (alebo night/day pomer); nie je to totálna 24-hodinová natriuréza</td>
    </tr>
  </tbody>
</table>
</div>

<p>Hodnota „10–20&nbsp;%“ je etablovaná praktická aproximácia. V protokoloch a v správach ABPM treba vždy uviesť, aký prah a aké časové okná (diár spánku vs. pevné hodiny) sa použili.</p>

<h2>Patofyziológia: prečo „sodík v správnom čase“ súvisí s nočným tlakom</h2>

<h3>Cirkadiánna organizácia tlaku a natriurézy</h3>

<p>V noci klesá aktivácia viacerých regulačných systémov a mení sa hemodynamika v súlade so spánkom. Oblička má vlastné rytmy transportu sodíka, ktoré sa premietajú do diurnálneho profilu exkrécie. Ak je denná natriuretická kapacita oslabená, sodík (a často aj objem) sa kompenzačne „presúva“ do nočnej fázy.</p>

<h3>Pressure-natriuresis ako nočná kompenzácia</h3>

<p>Keď oblička cez deň nedokáže vylúčiť dostatok sodíka, na udržanie sodíkovej rovnováhy môže byť potrebný vyšší perfúzny tlak. Kompenzácia sa potom môže prejaviť ako <strong>vyšší nočný tlak</strong> a oslabený dipping – nie len ako „sekundárny dôsledok“, ale ako súčasť regulačnej slučky. Tento rámec podporujú aj mechanistické prehľady o nondippingu ako zlyhaní denného renálneho spracovania sodíka.</p>

<h3>Čo ukazujú klinické kohorty</h3>

<ul>
  <li>U osôb afrického pôvodu bol nižší pomer dennej k nočnej exkrécii sodíka spojený s vyšším nočným systolickým tlakom a horším dippingom (Bankir a kol., 2008).</li>
  <li>Vo všeobecnej populácii (Švajčiarsko) sa znížená denná natriuréza spájala s vyšším nočným tlakom najmä u osôb starších ako 50&nbsp;rokov (Del Giorno a kol., 2020).</li>
  <li>Pri CKD boli nižšie day-to-night pomery sodíka (a draslíka) nezávisle spojené s vyšším nočným systolickým tlakom a blunted dippingom; v jednej veľkej kohorte išlo o rozdiely rádovo o niekoľko mmHg medzi kvartilmi (Liu a kol., 2024).</li>
  <li>Abnormálny cirkadiánny pomer exkrécie sodíka súvisel s hypertenziou a poškodením cieľových orgánov pri CKD (Zhang a kol., 2020) a v novšej práci aj s progresiou CKD (Liu a kol., 2026).</li>
</ul>

<p>Dôležité: <strong>24-hodinová natriuréza môže byť podobná</strong> pri veľmi odlišnom denno-nočnom rozdelení. Preto samotný „sodík za 24&nbsp;hodín“ nemusí odhaliť fenotyp, ktorý súvisí s nočným tlakom.</p>

<h2>Čo je asociácia a čo ešte nie je kauzalita</h2>

<p>Review aj podporné štúdie ukazujú <strong>tesnú súvislosť</strong>, nie automaticky kauzalitu v každom prípade. Porušená diurnálna natriuréza môže byť:</p>

<ul>
  <li><strong>mechanizmom</strong> (nedostatočná denná exkrécia → nočná pressure-natriuresis → vyšší nočný tlak),</li>
  <li>alebo <strong>markerom</strong> už narušenej regulácie (pokles eGFR, autonómna dysfunkcia, spánkové apnoe, chronický zápal, farmakoterapia, režim príjmu soli a tekutín).</li>
</ul>

<p>V praxi to neznamená, že sodík „nemá význam“. Znamená to, že mechanistický model treba spájať s klinickou stratégiou opatrne, najmä kým nie sú k dispozícii robustné randomizované dáta o cielených chronoterapeutických intervenciách v danej populácii.</p>

<h2>Metodické „úzke hrdlo“: ako merať, aby mal výsledok zmysel</h2>

<p>Presvedčivé hodnotenie vzťahu medzi diurnálnym sodíkom a tlakom vyžaduje:</p>

<ul>
  <li>jasné oddelenie bdelosti a spánku (diár, ideálne synchronizované s ABPM),</li>
  <li>kvalitný split zber moču (úplnosť, kontaminácia, compliance; oddelené denné a nočné vzorky),</li>
  <li>spojenie ABPM fenotypov (nočná hypertenzia, dipping) s rovnakými časovými oknami moču,</li>
  <li>zohľadnenie diuretík, SGLT2 inhibítorov, príjmu soli, noctúrie a kvality spánku.</li>
</ul>

<p>V bežnej ambulancii je ťažké dosiahnuť rovnakú kvalitu ako v protokoloch štúdií. Preto má zmysel cielené použitie u vybraných pacientov, nie plošný zber u každého s hypertenziou.</p>

<h2>Klinické implikácie</h2>

<h3>Koho typicky zaujíma nočná hypertenzia</h3>

<ul>
  <li>CKD, diabetes, obštrukčné spánkové apnoe, autonómna dysfunkcia,</li>
  <li>rezistentná alebo „maskovaná“ hypertenzia, rozpor medzi ordináciou a orgánovým rizikom,</li>
  <li>perzistentné nočné elevácie pri uspokojivej dennej kontrole,</li>
  <li>podozrenie na nepravidelný režim soli alebo na stav, ktorý oslabuje dennú natriurézu.</li>
</ul>

<h3>Logika ABPM + časovaný sodík</h3>

<p>Ak je nočný tlak vysoký a denná natriuréza relatívne oslabená (nízky day/night pomer), uvažujte o:</p>

<ol>
  <li>kontrole celkového príjmu soli a sodíkovej záťaže podľa štandardných odporúčaní,</li>
  <li><strong>časovaní</strong> príjmu soli tak, aby denná fáza lepšie podporila natriurézu (konceptuálne; nie ako rigidný protokol bez individualizácie),</li>
  <li>optimalizácii antihypertenznej schémy s ohľadom na nočný profil – vrátane načasovania dávok, ak je to podľa manažmentu hypertenzie indikované a bezpečné,</li>
  <li>pátraní po sekundárnych prispievajúcich faktoroch (OSA, objemové preťaženie, lieky).</li>
</ol>

<p>Konkrétne chronoterapeutické protokoly (napr. univerzálne „večerné dávkovanie všetkých liekov“) si vyžadujú oporu v dôkazoch pre danú populáciu; tento text ich preto neponúka ako plošné pravidlo.</p>

<h2>Praktický rámec pre ambulanciu</h2>

<div class="table-responsive" role="region" aria-label="Praktický rámec hodnotenia nočného tlaku a diurnálneho sodíka" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Krok</th>
      <th scope="col">Čo urobiť</th>
      <th scope="col">Čo neočakávať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1. Fenotyp tlaku</th>
      <td>Kvalitné ABPM s denníkom spánku; zaznamenať nočný priemer a dipping</td>
      <td>Že samotný kancelársky tlak odhalí nočný fenotyp</td>
    </tr>
    <tr>
      <th scope="row">2. Fenotyp sodíka</th>
      <td>Pri vybraných pacientoch split 24-hodinový zber (deň/noc) na Na⁺</td>
      <td>Že jeden neúplný zber spoľahlivo klasifikuje rytmus</td>
    </tr>
    <tr>
      <th scope="row">3. Interpretácia</th>
      <td>Vysoký nočný BP + nízky day/night pomer Na⁺ → zvážiť sodíkovo-časovú logiku</td>
      <td>Automatickú kauzalitu bez konfúzorov (CKD, OSA, lieky)</td>
    </tr>
    <tr>
      <th scope="row">4. Intervencia</th>
      <td>Úprava soli, objemu, liečby a spánku podľa celkového rizika</td>
      <td>Jednoduchý „recept na večernú soľ“ bez dôkazov a bezpečnosti</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Zhrnutie</h2>

<p>Diurnálna exkrécia sodíka a nočný krvný tlak tvoria spoločný cirkadiánny problém. Dôkazy z review aj z klinických kohort podporujú, že <strong>oslabená denná natriuréza</strong> súvisí s nočnou hypertenziou a horším dippingom. Klinicky to posilňuje dôraz na ABPM a – u vybraných pacientov – na časovaný sodík. Interpretácia musí zostať kritická: asociácia nie je automaticky kauzalita a rutinný split zber moču nie je pre každého.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax">Cieľový systolický tlak 120&nbsp;mmHg pri CKD: odporúčanie KDIGO a reálna prax</a></li>
  <li><a href="article.php?slug=nekontrolovana-rezistentna-hypertenzia-aldosteronova-os">Nekontrolovaná a rezistentná hypertenzia: úloha aldosterónovej osi</a></li>
  <li><a href="article.php?slug=baxdrostat-rezistentna-hypertenzia-bax24">Baxdrostat pri rezistentnej hypertenzii: štúdia BaxHTN / Bax24</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Artemios G. Karagiannidis, Marieta Theodorakopoulou, Fotini Iatridi, Pantelis Sarafidis. Diurnal urine sodium excretion and nighttime blood pressure: the timing dimension of salt consumption. <em>Nephron</em>. 2026 Sep 12:1. doi:10.1159/nef/adtag007. <a href="https://pubmed.ncbi.nlm.nih.gov/42731064/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1159/nef/adtag007" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Ďalšie overené zdroje:</strong></em></p>

<ol>
  <li>Artemios G. Karagiannidis, Marieta Theodorakopoulou, Fotini Iatridi, Pantelis Sarafidis. Diurnal urine sodium excretion and nighttime blood pressure: the timing dimension of salt consumption. <em>Nephron</em>. 2026; doi:10.1159/nef/adtag007. <a href="https://pubmed.ncbi.nlm.nih.gov/42731064/" target="_blank" rel="noopener noreferrer">PubMed PMID 42731064</a>; <a href="https://doi.org/10.1159/nef/adtag007" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://apps.crossref.org/pendingpub/pendingpub.html?doi=10.1159%2Fnef%2Fadtag007" target="_blank" rel="noopener noreferrer">Crossref pending publication</a>.</li>
  <li>Lise Bankir, Murielle Bochud, Marc Maillard, Pascal Bovet, Anne Gabriel, Michel Burnier. Nighttime blood pressure and nocturnal dipping are associated with daytime urinary sodium excretion in African subjects. <em>Hypertension</em>. 2008;51(4):891–898. <a href="https://pubmed.ncbi.nlm.nih.gov/18316653/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1161/HYPERTENSIONAHA.107.105510" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Lingling Liu, Lin Lin, Jianting Ke, Binhuan Chen, Yu Xia, Cheng Wang. Higher nocturnal blood pressure and blunted nocturnal dipping are associated with decreased daytime urinary sodium and potassium excretion in patients with CKD. <em>Kidney International Reports</em>. 2024;9(1):73–86. <a href="https://pubmed.ncbi.nlm.nih.gov/38312777/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC10831351/" target="_blank" rel="noopener noreferrer">PMC (otvorený text)</a>; <a href="https://doi.org/10.1016/j.ekir.2023.10.017" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Rosaria Del Giorno, Chiara Troiani, Sofia Gabutti, Kevyn Stefanelli, Sandro Puggelli, Luca Gabutti. Impaired daytime urinary sodium excretion impacts nighttime blood pressure and nocturnal dipping at older ages in the general population. <em>Nutrients</em>. 2020;12(7):2013. <a href="https://pubmed.ncbi.nlm.nih.gov/32645850/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC7400814/" target="_blank" rel="noopener noreferrer">PMC (otvorený text)</a>; <a href="https://doi.org/10.3390/nu12072013" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Jun Zhang, Jialing Rao, Man Liu, Wenying Zhou, Yuanqing Li, Jianhao Wu, Hui Peng, Tanqi Lou. Abnormal circadian rhythm of urinary sodium excretion correlates closely with hypertension and target organ damage in Chinese patients with CKD. <em>International Journal of Medical Sciences</em>. 2020;17(10):1366–1375. <a href="https://pubmed.ncbi.nlm.nih.gov/32218691/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.medsci.org/v17p1366.htm" target="_blank" rel="noopener noreferrer">Otvorený text</a>; <a href="https://doi.org/10.7150/ijms.42875" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Lingling Liu, Sirui Liu, Menglei Jv, Shengnan Ge, Kehang Xie, Qing Xie, Hui Peng, Cheng Wang. Abnormal circadian pattern of urinary sodium excretion and chronic kidney disease progression. <em>BMC Nephrology</em>. 2026; doi:10.1186/s12882-026-04825-0. <a href="https://pubmed.ncbi.nlm.nih.gov/41792648/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://bmcnephrol.biomedcentral.com/articles/10.1186/s12882-026-04825-0" target="_blank" rel="noopener noreferrer">Otvorený text</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC13081315/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li>Jessica R. Ivy, Matthew A. Bailey. Nondipping blood pressure: predictive or reactive failure of renal sodium handling? <em>Physiology</em>. 2021;36(1):21–34. <a href="https://pubmed.ncbi.nlm.nih.gov/33325814/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1152/physiol.00024.2020" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Giuseppe Mancia, Reinhold Kreutz, Mattias Brunström, Michel Burnier, Guido Grassi, Andrzej Januszewicz, Maria Lorenza Muiesan, Konstantinos Tsioufis, et al. 2023 ESH Guidelines for the management of arterial hypertension. <em>Journal of Hypertension</em>. 2023;41(12):1874–2071. <a href="https://pubmed.ncbi.nlm.nih.gov/37345492/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1097/HJH.0000000000003480" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><small>Bibliografické údaje a dostupnosť odkazov overené 14.&nbsp;septembra 2026 (PubMed/eutils, Crossref, PMC a DOI). Text je odborným informačným materiálom a nenahrádza individuálne klinické rozhodnutie.</small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_diurnalna_exkrecia_sodika_nocna_hypertenzia',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
