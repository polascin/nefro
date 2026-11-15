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
    'title'        => 'Roztok so 126 mmol/l sodíka pri peritoneálnej dialýze',
    'slug'         => 'peritonealna-dialyza-roztok-sodik-126',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Roztok s nižším obsahom sodíka zvýšil jeho peritoneálne odstránenie. Po ôsmich týždňoch sa rozdiel v prevodnení medzi skupinami nepreukázal.',
    'content'      => <<<'HTML'
<figure><img src="img/peritonealna-dialyza-roztok-sodik-126.webp" alt="Priehľadný vak s dialyzačným roztokom na stojane" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vaku na peritoneálnu dialýzu vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Pri peritoneálnej dialýze (PD) zvýšila výmena s roztokom obsahujúcim 126 mmol/l sodíka jeho denné odstránenie dialyzátom. Po ôsmich týždňoch bol rozdiel oproti kontrolnej skupine 35,0 mmol denne. Zmeny prevodnenia meraného bioimpedanciou ani domáceho krvného tlaku sa medzi skupinami presvedčivo nelíšili [1].</p>

<h2>Ako štúdia prebiehala</h2>
<p>Do dvojito zaslepenej štúdie fázy 3 v 20 japonských centrách randomizovali 79 pacientov v pomere 2 : 1. Jeden pacient prešiel na hemodialýzu pred podaním skúšaného roztoku. Súbor na hodnotenie účinnosti tak zahŕňal 51 pacientov v skupine s roztokom s nižším obsahom sodíka a 27 v kontrolnej skupine. Naplánovanú dennú výmenu nahradili skúšaným roztokom (126 mmol/l sodíka, 1,6 % glukózy) alebo kontrolným roztokom (135 mmol/l sodíka, 1,35 % glukózy). Ostatné výmeny pokračovali štandardnými roztokmi. Po štyroch týždňoch mohli pacienti, ktorí splnili kritériá protokolu, prejsť na dve výmeny so skúšaným alebo kontrolným roztokom denne. Roztoky sa líšili aj obsahom ďalších elektrolytov a glukózy. Výsledok sa preto vzťahuje na porovnávané zloženia a režimy výmen [1].</p>

<h2>Odstránenie sodíka dialyzátom a močom</h2>
<p>Po ôsmich týždňoch boli údaje pre primárny ukazovateľ dostupné u 46 pacientov s roztokom s nižším obsahom sodíka a u 20 pacientov v kontrolnej skupine. Denné peritoneálne odstránenie sodíka sa oproti východisku zmenilo o +28,7 ± 36,2 mmol/deň pri roztoku s nižším obsahom sodíka a o −6,3 ± 26,2 mmol/deň pri kontrolnom roztoku (priemer ± smerodajná odchýlka). Rozdiel medzi skupinami bol 35,0 mmol/deň (95 % interval spoľahlivosti od 17,1 do 53,0, <i>p</i> = 0,0002). Po zohľadnení východiskovej hodnoty bol rozdiel 30,9 mmol/deň (95 % interval spoľahlivosti od 13,0 do 48,7) [1].</p>

<p>Nižšia koncentrácia sodíka v napúšťanom roztoku zväčšuje gradient pre difúziu sodíka z krvi do dialyzátu. Množstvo odstráneného sodíka pritom ovplyvňuje aj konvekcia pri ultrafiltrácii. V ôsmom týždni sa medzi skupinami líšila aj zmena celkového odstránenia sodíka dialyzátom a močom, o 30,4 mmol/deň v prospech roztoku s nižším obsahom sodíka (95 % interval spoľahlivosti od 7,7 do 53,2). Rozdiely v diuréze, celkovom odstránení vody a v celkovom, peritoneálnom či renálnom Kt/V sa nepreukázali. Zistenia za osem týždňov ponechávajú otvorenú otázku dlhodobej kontroly objemu tekutín aj zachovania reziduálnej funkcie obličiek [1, 2].</p>

<h2>Objem tekutín a bezpečnosť</h2>
<p>V ôsmom týždni bol rozdiel v zmene bioimpedančne hodnoteného prevodnenia −0,1 l (95 % interval spoľahlivosti od −0,9 do 0,7). Štúdia nezistila presvedčivý rozdiel ani v telesnej hmotnosti, edémoch, smäde či domácom krvnom tlaku. Výsledok podskupiny s výraznejším prevodnením ostáva podnetom na ďalší výskum. Štúdia neposkytuje podklad na záver o hospitalizáciách ani o tom, ako dlho pacienti dokážu pokračovať v PD [1].</p>

<p>Nežiaduce účinky pripísané skúšanému roztoku sa vyskytli u 12 z 51 pacientov (24 %). Prevažovala hyponatriémia. U troch pacientov klesla koncentrácia sodíka v sére pod 130 mmol/l a podávanie ukončili. Symptomatickú hyponatriémiu nezaznamenali. Väčšina nežiaducich účinkov bola mierna a reverzibilná. Spoločnosť Terumo štúdiu financovala a vyrobila oba roztoky. Hiroaki Takahashi, Hideka Hosaka a Fumiyo Uosaki sú zamestnancami spoločnosti [1].</p>

<h2>Čo výsledky znamenajú pre prax</h2>
<p>Do štúdie sa často dostali pacienti na inkrementálnej PD s pomerne zachovanou reziduálnou funkciou obličiek. Automatizovaná PD patrila medzi vylučovacie kritériá. Účinok pri anúrii alebo pri krátkych výmenách automatizovanej PD ostáva neistý. V staršej štúdii roztok so 125 mmol/l sodíka zvýšil odstránenie sodíka, ale v celkovom týždennom Kt/V močoviny sa nepodarilo potvrdiť, že rozdiel zostal v stanovenej hranici noninferiority. V ďalšej štúdii jedna denná výmena s roztokom so 112 mmol/l sodíka nepreukázala lepšiu kontrolu tlaku podľa primárneho ukazovateľa a hypotenzia bola častejšia. Výsledky sa vzťahujú na odlišné zloženia a režimy [1, 2, 3].</p>

<p>TCD-58205 je označenie roztoku vo verejnom japonskom registri klinických skúšaní. Pri kontrole verejných zdrojov k 14. novembru 2026 sa registráciu ani bežnú dostupnosť tohto konkrétneho roztoku v EÚ alebo na Slovensku nepodarilo potvrdiť. Centrálny register EÚ nepokrýva všetky vnútroštátne registrácie a registrácia sama o sebe nepotvrdzuje dodávky [4, 5, 6, 7].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Masaaki Nakayama, Hiroaki Takahashi, Hideka Hosaka, Fumiyo Uosaki, Yasuhiko Ito, Hidetomo Nakamoto. Low-Sodium Peritoneal Dialysis Solution (Na 126 mmol/L) for Enhanced Sodium Removal: A Multicenter Randomized Controlled Trial. Kidney Med. 2026;8(11):101487. <a href="https://doi.org/10.1016/j.xkme.2026.101487" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.xkme.2026.101487</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42959528/" target="_blank" rel="noopener noreferrer">PubMed 42959528</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13717097/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Bolesław Rutkowski, Paul Tam, Frank M van der Sande, Andreas Vychytil, Vedat Schwenger, Rainer Himmele, Adelheid Gauly, Low Sodium Balance Study Group. Low-Sodium Versus Standard-Sodium Peritoneal Dialysis Solution in Hypertensive Patients: A Randomized Controlled Trial. Am J Kidney Dis. 2016;67(5):753-761. <a href="https://doi.org/10.1053/j.ajkd.2015.07.031" target="_blank" rel="noopener noreferrer">DOI 10.1053/j.ajkd.2015.07.031</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/26388284/" target="_blank" rel="noopener noreferrer">PubMed 26388284</a></em></small></li>
<li><small><em>Simon Davies, Börje Haraldsson, François Vrtovsnik, Vedat Schwenger, Stanley Fan, Alexandre Klein, Saynab Atiye, Adelheid Gauly. Single-dwell treatment with a low-sodium solution in hypertensive peritoneal dialysis patients. Perit Dial Int. 2020;40(5):446-454. <a href="https://doi.org/10.1177/0896860820924136" target="_blank" rel="noopener noreferrer">DOI 10.1177/0896860820924136</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32425111/" target="_blank" rel="noopener noreferrer">PubMed 32425111</a></em></small></li>
<li><small><em>Japan Registry of Clinical Trials. Peritoneal dialysate TCD-58205. <a href="https://jrct.mhlw.go.jp/latest-detail/jRCT2031200398" target="_blank" rel="noopener noreferrer">jRCT2031200398</a>.</em></small></li>
<li><small><em>Európska komisia. <a href="https://health.ec.europa.eu/medicinal-products/union-register_en" target="_blank" rel="noopener noreferrer">Register liekov Únie</a>.</em></small></li>
<li><small><em>Heads of Medicines Agencies. <a href="https://www.hma.eu/human-medicines/mri-product-index.html" target="_blank" rel="noopener noreferrer">MRI Product Index</a>.</em></small></li>
<li><small><em>Štátny ústav pre kontrolu liečiv. <a href="https://www.sukl.sk/pre-verejnost-pacientov-a-media/sluzby-pre-verejnost/vyhladavanie-liekov-a-zdravotnickych-pomocok" target="_blank" rel="noopener noreferrer">Vyhľadávanie liekov a zdravotníckych pomôcok</a>.</em></small></li>
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
    'log_prefix' => 'add_peritonealna_dialyza_roztok_sodik_126',
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
