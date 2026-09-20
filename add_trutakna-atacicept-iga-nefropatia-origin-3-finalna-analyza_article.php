<?php
/**
 * Odborná syntéza výsledkov ORIGIN 3, overená k 20. 9. 2026.
 * Zdroje: FDA, recenzovaná interim analýza a primárne dokumenty SEC.
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
    'title'        => 'Trutakna pri IgA nefropatii: finálna analýza ORIGIN 3 a význam pre prax',
    'slug'         => 'trutakna-atacicept-iga-nefropatia-origin-3-finalna-analyza',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Finálna analýza ORIGIN 3 priniesla priaznivé výsledky eGFR a progresie IgA nefropatie. Čo údaje o atacicepte dokazujú a prečo ich nemožno zamieňať za dôkaz zníženia úmrtnosti?',
    'content'      => <<<'HTML'
<p>Finálna analýza účinnosti štúdie ORIGIN 3, oznámená 15. septembra 2026, rozširuje poznatky o atacicepte (Trutakna, atacicept-vymj) pri primárnej IgA nefropatii. Popri predtým publikovanom znížení proteinúrie priniesla priaznivé výsledky odhadovanej glomerulovej filtrácie (eGFR) a kombinovaného ukazovateľa progresie. Septembrové údaje však zatiaľ pochádzajú z oznámenia zadávateľa a jeho prezentácie, nie z tu overenej recenzovanej publikácie finálnej analýzy. [1, 2]</p>
<p><strong>Stav poznatkov k 20. septembru 2026:</strong> treba odlíšiť recenzovanú priebežnú analýzu proteinúrie, novšie firemné výsledky a platnú americkú indikáciu. Každý z týchto zdrojov odpovedá na inú otázku.</p>

<h2>Prečo blokovať BAFF a APRIL</h2>
<p>Pri IgA nefropatii sa v mezangiu ukladajú imunokomplexy obsahujúce IgA a vzniká zápalové poškodenie glomerulov. Galaktózovo deficitný IgA1 (Gd-IgA1) je súčasťou tejto patogenetickej kaskády. Atacicept je rekombinantný fúzny proteín TACI-Fc, ktorý viaže cytokíny BAFF a APRIL. Tým zasahuje do signálov podporujúcich B-lymfocyty a tvorbu protilátok. Biologická vierohodnosť tohto mechanizmu sama osebe nenahrádza klinický dôkaz účinnosti. [3, 4]</p>

<h2>Čo bolo schválené a prečo prišli výsledky skôr</h2>
<p>FDA udelila lieku 7. júla 2026 zrýchlené schválenie na zníženie proteinúrie u dospelých s primárnou IgA nefropatiou ohrozených progresiou. Podkladom bol účinok na proteinúriu. Regulačný text naďalej uvádza, že dlhodobé spomalenie poklesu funkcie obličiek nebolo pre túto indikáciu stanovené a pokračovanie schválenia môže závisieť od potvrdenia klinického prínosu. [5, 6]</p>
<p>Rozdiel medzi pôvodne avizovaným rokom 2027 a septembrom 2026 má vysvetlenie: výrobca 2. júna 2026 oznámil dohodu s FDA o skoršej analýze eGFR. V septembri plánoval podať doplňujúcu žiadosť o plné schválenie vo štvrtom štvrťroku 2026. Pozitívne oznámenie výsledkov teda nemožno zamieňať za nové rozhodnutie FDA. [1, 7]</p>

<h2>Populácia a priebežný výsledok proteinúrie</h2>
<p>ORIGIN 3 je medzinárodná randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 3. Dospelí dostávali atacicept 150 mg podkožne raz týždenne alebo placebo v pomere 1 : 1. Recenzovaná priebežná analýza zahŕňala 203 pacientov: 106 s ataciceptom a 97 s placebom. V 36. týždni klesol pomer bielkovín ku kreatinínu v 24-hodinovom zbere moču (UPCR) oproti východisku o 45,7 % a 6,8 %. Relatívne zníženie oproti placebu podľa modelu geometrických priemerov bolo približne 42 %; nejde o jednoduché odčítanie uvedených percent. [3, 4]</p>
<p>Vstupné kritériá zahŕňali biopsiou potvrdenú IgA nefropatiu, eGFR ≥30 ml/min/1,73 m² a UPCR ≥1 g/g alebo proteinúriu ≥1 g/24 hodín pri stabilnej maximálne tolerovanej inhibícii renínovo-angiotenzínového systému. Súbežná stabilná liečba inhibítorom SGLT2 bola povolená. Tieto kritériá opisujú skúmanú populáciu; nemožno ich automaticky vydávať za úplné znenie schválenej indikácie. [4]</p>

<h2>Finálna analýza: funkcia obličiek a progresia</h2>
<p>Nasledujúce výsledky výrobca uviedol pre analytický súbor 428 pacientov. Hodnoty v tabuľke sú prevzaté z primárneho firemného hlásenia v SEC, nie zo sekundárneho mediálneho súhrnu. [1]</p>
<div class="table-responsive" role="region" aria-label="Výsledky finálnej analýzy ORIGIN 3" tabindex="0">
<table>
<thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Atacicept</th><th scope="col">Placebo</th><th scope="col">Rozdiel alebo pomer rizík (95 % IS)</th></tr></thead>
<tbody>
<tr><th scope="row">Zmena eGFR v 52. týždni (ml/min/1,73 m²)</th><td>−0,1</td><td>−5,7</td><td>5,6 (3,7 až 7,5)</td></tr>
<tr><th scope="row">Ročné tempo zmeny eGFR do 104. týždňa (ml/min/1,73 m²/rok)</th><td>−0,6</td><td>−5,6</td><td>5,0 (3,6 až 6,5)</td></tr>
<tr><th scope="row">Kombinovaný ukazovateľ progresie do 104. týždňa</th><td>11 udalostí</td><td>38 udalostí</td><td>HR 0,24 (0,12 až 0,48)</td></tr>
</tbody></table></div>
<p>Pre všetky tri porovnania výrobca uviedol p &lt; 0,0001. IS znamená interval spoľahlivosti; HR je pomer okamžitých rizík. Hodnota −0,1 v 52. týždni je zmena od východiska, kým −0,6 je odhad ročného tempa zmeny počas sledovania do 104. týždňa. Ide o odlišné veličiny. [1]</p>
<p>Kombinovaný ukazovateľ zahŕňal prvý výskyt úmrtia, transplantácie obličky, dialýzy trvajúcej ≥30 dní, eGFR &lt;15 ml/min/1,73 m² pretrvávajúcej ≥30 dní alebo poklesu eGFR o ≥30 % pretrvávajúceho ≥30 dní. [2]</p>
<p><strong>Zníženie o 76 % sa týka kombinovaného ukazovateľa, nie samotnej úmrtnosti.</strong> HR 0,24 tiež neznamená absolútne zníženie rizika o 76 percentuálnych bodov. Súhrn dialýzy trvajúcej ≥30 dní, transplantácie alebo úmrtia predstavoval 0 oproti 8 udalostiam. Bez samostatného spoľahlivého vyhodnotenia jednotlivých zložiek nemožno tvrdiť, že liek preukázateľne znižuje úmrtnosť súvisiacu s obličkami. [1]</p>

<h2>Čo znamená sledovanie do dvoch rokov</h2>
<p>V grafe eGFR výrobcu malo v 104. týždni dostupné meranie 50 pacientov s ataciceptom a 37 s placebom, hoci každé rameno analytického súboru zahŕňalo 214 pacientov. Ročný sklon bol odhadnutý zmiešaným modelom s náhodným interceptom a sklonom. [2]</p>
<p>Označenie „dvojročné výsledky“ preto neznamená, že všetkých 428 pacientov dokončilo dva roky liečby. Samotný menší počet neskorých meraní nepreukazuje vysoký počet predčasných ukončení; súvisieť môže aj s priebežným náborom a skorším dátovým uzáverom. Na definitívne posúdenie treba úplné údaje o dĺžke sledovania, chýbajúcich meraniach, cenzorovaní a analýzach citlivosti. Stabilizácia priemernej eGFR navyše nie je dôkazom vyliečenia ani zárukou individuálnej odpovede.</p>

<h2>Bezpečnosť: celkový súhrn nestačí</h2>
<p>Vo finálnom bezpečnostnom súbore výrobca hlásil nežiaduce udalosti u 75 % oproti 78 % a infekcie u 51 % oproti 52 % pacientov. Reakcie v mieste vpichu však boli častejšie pri atacicepte: 25 % oproti 7 %. Ide o údaje z neskoršieho hodnotenia, ktoré netreba miešať s kratšou expozíciou v pôvodných registračných podkladoch. [2]</p>
<p>Americká preskripčná informácia upozorňuje na infekcie, odporúča odložiť začatie pri aktívnej infekcii a pri závažnej infekcii zvážiť prerušenie liečby. Kontraindikáciou je závažná precitlivenosť na liečivo alebo pomocné látky. [4] Pred liečbou sa majú doplniť očkovania primerané veku; živé vakcíny sa neodporúčajú počas 30 dní pred začatím ani počas liečby. Súbežné imunomodulačné lieky môžu zvýšiť infekčné riziko a ich kombinácia nebola vyhodnotená. [8]</p>

<h2>Význam pre nefrologickú prax</h2>
<p>Výsledky podporujú potenciál ataciceptu ovplyvniť priebeh ochorenia nad rámec samotného zníženia proteinúrie. Ich praktická interpretácia však musí zohľadniť výber pacientov, sprievodnú liečbu, trvanie sledovania a dostupnosť úplnej analýzy. Porovnanie s placebom neumožňuje vyhlásiť atacicept za účinnejší než iné cielené lieky bez priameho porovnania.</p>
<p>Rozhodnutie FDA platí pre USA a samo osebe nedokladá registráciu, dostupnosť ani úhradu na Slovensku. Pri klinickom rozhodovaní treba vychádzať z aktuálne platných miestnych podmienok a schválenej informácie o lieku.</p>
<p>Najpresnejší záver preto znie: finálna analýza oznámená zadávateľom priniesla priaznivý signál zachovania eGFR a nižšieho výskytu kombinovanej progresie. Samostatný prínos pre úmrtnosť, dlhodobá ochrana pred dialýzou a úplné regulačné potvrdenie týchto nových výsledkov sa z tohto oznámenia nedajú automaticky vyvodiť.</p>
<p>Súvisiaci článok: <a href="article.php?slug=atacicept-trutakna-iga-nefropatia-fda-proteinuria">Atacicept pri IgA nefropatii: pôvodné zrýchlené schválenie FDA a proteinúria</a>.</p>

<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Vera Therapeutics. Form 8-K, 15. 9. 2026, časť 8.01. <a href="https://www.sec.gov/Archives/edgar/data/1831828/000119312526391280/d32300d8k.htm" target="_blank" rel="noopener noreferrer">Primárne hlásenie finálnych výsledkov</a>.</em></small></li>
<li><small><em>Vera Therapeutics. Corporate Presentation, september 2026, snímky 23 až 25. <a href="https://www.sec.gov/Archives/edgar/data/1831828/000119312526391280/d32300dex992.htm" target="_blank" rel="noopener noreferrer">Príloha 99.2 k hláseniu SEC</a>.</em></small></li>
<li><small><em>Richard Lafayette, Sean J. Barbour, Robert M. Brenner, Kirk N. Campbell, Tom Doan, Necmi Eren, Jürgen Floege, Vivekanand Jha, Beom Seok Kim, Adrian Liew, Bart Maes, Atanu Pal, Roberto Pecoits-Filho, Richard K. S. Phoon, Dana V. Rizk, Hitoshi Suzuki, Vladimir Tesař, Hernán Trimarchi, Xuelian Wei, Hong Zhang, Jonathan Barratt; ORIGIN Phase 3 Trial Investigators. A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy. N Engl J Med. 2026;394:647–657. Elektronicky 6. 11. 2025. DOI: <a href="https://doi.org/10.1056/NEJMoa2510198" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2510198</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41196369/" target="_blank" rel="noopener noreferrer">PubMed, overený zoznam autorov a abstrakt</a>.</em></small></li>
<li><small><em>FDA. TRUTAKNA, Prescribing Information, júl 2026, oddiely 4, 5, 11 a 14. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2026/761486Orig1s000lbl.pdf" target="_blank" rel="noopener noreferrer">Úplná americká preskripčná informácia</a>.</em></small></li>
<li><small><em>FDA. FDA Approves New Treatment to Reduce Proteinuria in Adults with Primary Immunoglobulin A Nephropathy. <a href="https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-new-treatment-reduce-proteinuria-adults-primary-immunoglobulin-nephropathy" target="_blank" rel="noopener noreferrer">Schvaľovacie oznámenie</a>.</em></small></li>
<li><small><em>FDA. Purple Book, Trutakna, BLA 761486. <a href="https://purplebooksearch.fda.gov/index.cfm?blaNo=761486&amp;event=productdetails" target="_blank" rel="noopener noreferrer">Dátum prvého schválenia</a>.</em></small></li>
<li><small><em>Vera Therapeutics. Announces Alignment with U.S. FDA on Earlier ORIGIN Phase 3 Analysis, 2. 6. 2026. <a href="https://ir.veratx.com/news-releases/news-release-details/vera-therapeutics-announces-alignment-us-fda-earlier-origin" target="_blank" rel="noopener noreferrer">Zmena harmonogramu analýzy</a>.</em></small></li>
<li><small><em>Vera Therapeutics. Oznámenie finálnej analýzy ORIGIN 3, 15. 9. 2026, vrátane bezpečnostnej informácie. <a href="https://www.sec.gov/Archives/edgar/data/1831828/000119312526391280/d32300dex991.htm" target="_blank" rel="noopener noreferrer">Príloha 99.1 k hláseniu SEC</a>.</em></small></li>
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
    'log_prefix' => 'add_trutakna-atacicept-iga-nefropatia-origin-3-finalna-analyza_article',
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
