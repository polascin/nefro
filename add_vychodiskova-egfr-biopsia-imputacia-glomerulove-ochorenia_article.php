<?php

/**
 * add_vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia_article.php
 * Odborný článok: výber a imputácia východiskovej eGFR pri biopsii obličky.
 * Spracovaný zdroj: Han J, Canney M, Er L, Barbour SJ. Nephrol Dial Transplant. 2026.
 * doi 10.1093/ndt/gfag194 (PMID 42627408).
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
    'title'        => 'Východisková eGFR pri biopsii obličky: ako jej výber a imputácia môžu skresliť výsledky observačných štúdií',
    'slug'         => 'vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ak sa východisková eGFR pri biopsii určí z merania vzdialeného od výkonu, môže ísť o iný časový bod choroby. Kanadská kohorta ukazuje, že longitudinálne dáta v zmiešanom modeli zlepšujú kvalitu doplnenia chýbajúcej hodnoty.',
    'content'      => <<<'HTML'
<p>Východisková („baseline“) odhadovaná glomerulová filtrácia pri biopsii obličky patrí medzi najčastejšie používané premenné v observačných štúdiách glomerulových ochorení. Vstupuje do stratifikácie závažnosti, do prognostických modelov, do definícií progresie aj do úvah o účinku liečby. V praxi sa pritom určuje pomerne voľne — typicky ako prvé dostupné meranie v okne šiestich mesiacov okolo biopsie — a ak žiadna hodnota k dispozícii nie je, býva doplnená (imputovaná). Analýza z populačnej kanadskej kohorty ukazuje, že táto zdanlivo technická voľba nie je neutrálna: čím ďalej od biopsie hodnotu vezmeme, tým väčšia je odchýlka od skutočného východiskového stavu.</p>

<h2>Prečo nejde len o metodický detail</h2>

<p>Funkcia obličiek sa v okolí biopsie môže meniť rýchlo. Zasahuje do nej samotný priebeh ochorenia, hemodynamické zmeny, objemový stav, podaná liečba aj diagnostický proces. Ak sa za „východiskovú“ označí hodnota z obdobia niekoľkých mesiacov pred biopsiou alebo po nej, nemusí opisovať východiskový stav, ale iný bod priebehu choroby.</p>

<p>Dôsledkom je nesprávne zaradenie pacienta do pásma funkcie obličiek (misklasifikácia). Tá sa v ďalších analýzach neprejaví ako zjavná chyba, ale ako tichý posun: oslabené alebo skreslené asociácie, posunuté prahy pre definíciu progresie a väčšia neistota modelov. Ide o problém merania vysvetľujúcej premennej, ktorý nemožno napraviť pridaním ďalších premenných do modelu.</p>

<h2>Čo analýza skúmala</h2>

<p>Autori vychádzali z populačnej kohorty pacientov s glomerulovým ochorením v Britskej Kolumbii v Kanade a zaradili <strong>2 874 pacientov</strong>. Ako referenčný štandard („skutočná“ východisková eGFR) definovali <strong>najbližšiu hodnotu do 15 dní od biopsie</strong>. Voči tomuto štandardu potom porovnávali dva prístupy, ktoré sa v literatúre bežne používajú:</p>

<ol>
  <li><strong>Najbližšie pozorované meranie</strong> vybrané v postupne sa rozširujúcom časovom okne okolo dátumu biopsie.</li>
  <li><strong>Doplnenie chýbajúcej hodnoty</strong> jednoduchou (single) a viacnásobnou (multiple) imputáciou, a to buď bez využitia opakovaných meraní, alebo s využitím východiskovej eGFR predikovanej <strong>modelom so zmiešanými účinkami</strong> (mixed-effects model), ktorý pracuje s opakovanými meraniami eGFR v čase.</li>
</ol>

<p>Ako mieru odchýlky použili <strong>strednú absolútnu chybu</strong> (mean absolute error).</p>

<h3>Dva pojmy, ktoré sa v slovenskom texte často zamieňajú</h3>

<p>Pri hodnotení imputácie sa posudzujú dve odlišné vlastnosti. Ich rozlíšenie je pre pochopenie výsledkov podstatné:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Rozdiel medzi správnosťou a presnosťou doplnenej hodnoty" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Pojem</th>
        <th scope="col">Čo vyjadruje</th>
        <th scope="col">Čo sa stane, ak je nedostatočná</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Správnosť (accuracy)</th>
        <td>Ako blízko je doplnená hodnota skutočnej východiskovej eGFR — teda veľkosť systematickej odchýlky.</td>
        <td>Odhad je sústavne posunutý jedným smerom; výsledok analýzy je skreslený.</td>
      </tr>
      <tr>
        <th scope="row">Presnosť (precision)</th>
        <td>Ako málo sa doplnené hodnoty navzájom rozptyľujú, teda aká je neistota doplnenia.</td>
        <td>Odhad je rozkolísaný; intervaly spoľahlivosti sú nesprávne úzke alebo príliš široké.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Anglické <em>accuracy</em> a <em>precision</em> sa v slovenských textoch niekedy prekladajú oba ako „presnosť“, prípadne sa druhý pojem nahrádza kalkom „precíznosť“. V tomto článku sa <em>accuracy</em> uvádza ako <strong>správnosť</strong> a <em>precision</em> ako <strong>presnosť</strong>, v súlade so zaužívanou metrologickou konvenciou.</p>

<h2>Výsledky</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Prehľad hlavných zistení podľa použitého prístupu k východiskovej eGFR" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Prístup</th>
        <th scope="col">Zistenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Najbližšie pozorované meranie</th>
        <td>Odchýlka od skutočnej východiskovej hodnoty <strong>rástla s rozširovaním časového okna</strong> od dátumu biopsie.</td>
      </tr>
      <tr>
        <th scope="row">Jednoduchá imputácia</th>
        <td>Východisková eGFR predikovaná modelom so zmiešanými účinkami vykazovala <strong>konzistentne vyššiu správnosť</strong> než najbližšie pozorované hodnoty.</td>
      </tr>
      <tr>
        <th scope="row">Viacnásobná imputácia</th>
        <td>Zahrnutie predikovanej východiskovej eGFR zlepšilo <strong>správnosť aj presnosť</strong> doplnených hodnôt.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Zjednodušene: informácia, ktorá je v kohortách s opakovanými meraniami už k dispozícii, ostáva pri pravidle „vezmi najbližšiu hodnotu“ nevyužitá. Model so zmiešanými účinkami z nej dokáže odhadnúť východiskovú funkciu lepšie než jediné, hoci časovo najbližšie meranie.</p>

<h2>Ako to čítať pri hodnotení publikovaných prác</h2>

<p>Ide o metodickú prácu. Netvrdí nič o tom, či eGFR ochorenie spôsobuje alebo mení jeho priebeh. Tvrdí niečo iné, pre kritického čitateľa však rovnako dôležité: <strong>spôsob, akým bola východisková eGFR definovaná a doplnená, patrí k faktorom ovplyvňujúcim vnútornú validitu štúdie</strong>.</p>

<p>Pri čítaní observačných prác o glomerulových ochoreniach preto stojí za pozornosť:</p>

<ul>
  <li>aké široké okno autori použili na výber východiskovej hodnoty (šesťmesačné okno je bežné, no nie automaticky vhodné),</li>
  <li>koľkým pacientom východisková hodnota chýbala a ako sa s tým naložilo,</li>
  <li>či sa chýbajúce hodnoty len doplnili priemerom alebo jednoduchým modelom, alebo sa využila longitudinálna štruktúra dát,</li>
  <li>či autori pri viacnásobnej imputácii vykázali aj neistotu doplnenia, nielen bodový odhad.</li>
</ul>

<p>Rovnaké úvahy platia pre registrové analýzy, ktoré sa pripravujú aj na domácich dátach. Ak sú v registri opakované merania kreatinínu, ich zahrnutie do odhadu východiskového stavu je dostupné zlepšenie, ktoré nevyžaduje nový zber dát.</p>

<h2>Limity a čo z práce nevyplýva</h2>

<ul>
  <li>Ide o <strong>jednu populačnú kohortu</strong> v konkrétnom systéme starostlivosti; frekvencia a načasovanie meraní eGFR sa medzi pracoviskami líšia a od nich závisí, koľko informácie má model k dispozícii.</li>
  <li>Referenčný štandard je <strong>definovaný, nie meraný</strong>. „Skutočná“ východisková eGFR je najbližšia hodnota do 15 dní od biopsie, nie meraná glomerulová filtrácia exogénnym markerom. Pri inej definícii referencie by sa absolútne odchýlky líšili.</li>
  <li>Práca hodnotí <strong>kvalitu doplnenia jednej premennej</strong>. Z toho, že doplnená hodnota je bližšie k referencii, automaticky nevyplýva, že sa v každej následnej analýze (napríklad v prognostickom modeli) zlepšia aj výsledné odhady rizika.</li>
  <li>Verejne dostupný je zatiaľ len abstrakt; podrobnosti o použitých rovniciach eGFR, o presnej špecifikácii modelu a o zaobchádzaní s liečbou podanou pred biopsiou a po nej z neho nevyplývajú. Výhrady uvedené vyššie preto nie sú prevzaté od autorov, ale odvodené z dostupného opisu metodiky.</li>
</ul>

<h2>Záver</h2>

<p>Ak sa východisková funkcia obličiek pri glomerulovom ochorení určí z merania vzdialeného od biopsie, môže ísť o misklasifikáciu — a teda o chybu v premennej, od ktorej sa odvíja väčšina ďalších záverov. V kohorte s opakovanými meraniami eGFR zlepšilo využitie longitudinálnych dát v modeli so zmiešanými účinkami správnosť pri jednoduchej imputácii a správnosť aj presnosť pri viacnásobnej imputácii. Pre observačný výskum glomerulových ochorení z toho vyplýva praktické odporúčanie: k východiskovej eGFR pristupovať ako k odhadovanej veličine s vlastnou neistotou, nie ako k danému údaju.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=egfr-diabetes-ekfc-ckd-epi-stadia-ckd">Presnejší odhad eGFR u pacientov s diabetom: keď rovnica mení štádium CKD</a></li>
  <li><a href="article.php?slug=renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek">Renálna funkčná rezerva: prečo normálny eGFR nevylučuje významné poškodenie obličiek</a></li>
  <li><a href="article.php?slug=upcr-vs-uacr-riziko-zlyhania-obliciek-ckd">Bielkovina v moči verzus albumín pri hodnotení rizika zlyhania obličiek pri CKD</a></li>
  <li><a href="article.php?slug=perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza">Perzistujúca mikroskopická hematúria pri podocytopatiách: prognostický signál, nie terapeutický cieľ</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Han J, Canney M, Er L, Barbour SJ. Longitudinal eGFR data in the estimation of missing baseline eGFR in patients with glomerular disease. <em>Nephrology Dialysis Transplantation</em>. Publikované online 21. augusta 2026 (predbežný článok, bez ročníka a stránkovania). doi: <a href="https://doi.org/10.1093/ndt/gfag194" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag194</a>. PMID 42627408. <a href="https://pubmed.ncbi.nlm.nih.gov/42627408/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, autorský zoznam, veľkosť kohorty aj definícia referenčného štandardu boli overené 28. augusta 2026 cez PubMed z abstraktu spracovanej práce. Plný text nemá otvorenú verziu, preto článok neuvádza číselné hodnoty stredných absolútnych chýb ani parametre modelu — v abstrakte nie sú uvedené a ich domýšľanie by bolo nepodložené. Metodické výhrady v texte nie sú prevzaté od autorov.</em></small></p>

<p><small><em>Text má odborný informačný charakter a týka sa metodiky observačného výskumu, nie diagnostického ani liečebného postupu u konkrétneho pacienta.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vychodiskova_egfr_biopsia_imputacia',
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
