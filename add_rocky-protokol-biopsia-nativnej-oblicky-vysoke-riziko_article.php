<?php

/**
 * add_rocky-protokol-biopsia-nativnej-oblicky-vysoke-riziko_article.php
 * Odborný článok: protokol ROCKY a bezpečnosť perkutánnej biopsie natívnej
 * obličky u vysokorizikových pacientov (ASN Kidney Week 2026, TH-OR001).
 * Spracovaný zdroj: Nancy A. Melville. Kidney Biopsies Using Standardized
 * Protocol Safe Even in High-Risk Patients. Medscape Medical News, 24. 10. 2026.
 * Avíza sa pri tomto článku zámerne NEposielajú ('enqueue_newsletter' => false).
 */

// Ochrana: len admin alebo CLI
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
    'title'        => 'Bezpečnosť perkutánnej biopsie natívnej obličky aj u vysokorizikových pacientov: validácia štandardizovaného protokolu ROCKY',
    'slug'         => 'rocky-protokol-biopsia-nativnej-oblicky-vysoke-riziko',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prospektívna kohorta 1 096 vysokorizikových biopsií podľa protokolu ROCKY ukázala 0,8 % závažných komplikácií bez štatistického rozdielu medzi hospitalizovanými a ambulantnými výkonmi.',
    'content'      => <<<'HTML'
<figure><a href="img/rocky-protokol-biopsia-nativnej-oblicky-vysoke-riziko.webp" rel="noopener noreferrer" target="_blank"><img src="img/rocky-protokol-biopsia-nativnej-oblicky-vysoke-riziko.webp" alt="Polopriesvitná oblička a bioptická ihla v tyrkysovom svetle na takmer čiernom pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani výkonu. Znázorňuje navigovanú perkutánnu biopsiu natívnej obličky v duchu štandardizovaného bezpečnostného protokolu.</figcaption></figure>

<p>Perkutánna biopsia natívnej obličky ostáva základnou diagnostickou metódou pri mnohých ochoreniach obličiek. Histologické vyšetrenie môže upresniť diagnózu, prognózu a liečbu. V praxi však pretrváva opatrnosť, najmä u pacientov so zvýšeným rizikom krvácania: vyšším vekom, zhoršenou funkciou obličiek, obezitou, anatomickými abnormalitami, antitrombotickou liečbou alebo poruchou hemostázy.</p>

<p>Na Kidney Week 2026 bola predstavená prospektívna validácia štandardizovaného protokolu ROCKY (<em>Renal-biopsy Optimized Care and Knowledge Yielding safety</em>). V skupine 1 096 vysokorizikových výkonov bola miera závažných komplikácií 0,8 %, bez štatisticky významného rozdielu medzi hospitalizovanými a ambulantnými pacientmi.<sup>1,2</sup> Kongresová správa Nancy A. Melvilleovej na Medscape tieto výsledky zhrnula a doplnila komentár moderátora k bežnému používaniu desmopresínu v skúmanom centre.<sup>1</sup></p>

<h2>Čo štúdia ROCKY skúmala</h2>

<p>Išlo o prospektívnu monocentrickú observačnú štúdiu. Od januára 2014 do júna 2024 vykonali 1 937 po sebe nasledujúcich perkutánnych biopsií natívnej obličky podľa jednotnej bezpečnostnej cesty ROCKY. Protokol zahŕňal predprocedurálne skríningové hodnotenie, manažment antitrombotickej liečby, navigáciu ultrazvukom v reálnom čase a štruktúrované sledovanie po výkone.<sup>2</sup></p>

<p>Do analýzy vysokého rizika zaradili 1 096 biopsií u 801 pacientov s aspoň jedným preddefinovaným rizikovým znakom. To bolo 56,6 % všetkých výkonov; 26,9 % tvorili opakované biopsie. Hospitalizovaní pacienti predstavovali 842 výkonov (76,8 %), ambulantní 254 (23,2 %).<sup>2</sup></p>

<h2>Závažné komplikácie: 0,8 %</h2>

<p>Závažné komplikácie vznikli v 9 prípadoch (0,8 %). Medzi hospitalizovanými a ambulantnými výkonmi nebol štatisticky významný rozdiel: 6 z 842 oproti 3 z 254 (p = 0,45).<sup>2</sup> V tlačovej správe ASN k prezentácii autori uviedli, že nedošlo k nefektómii ani k úmrtiu súvisiacemu s výkonom.<sup>3</sup></p>

<p>V skúmaných premenných sa nezistila nezávislá asociácia so závažnými komplikáciami. Uvádza sa vek (OR 1,01 na rok, p = 0,54), pohlavie (OR 0,98 pre mužov, p = 0,89), sérový kreatinín (OR 1,007 na mg/dl, p = 0,47), odhadovaná glomerulová filtrácia (eGFR; OR 0,99 ml/min/1,73 m², p = 0,61), antiagregačná liečba (OR 1,05, p = 0,77) aj antikoagulácia (OR 0,95, p = 0,84).<sup>2</sup></p>

<div class="table-responsive" role="region" aria-label="Závažné komplikácie podľa nastavenia biopsie v kohorte ROCKY" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina</th>
      <th scope="col">Počet výkonov</th>
      <th scope="col">Závažné komplikácie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Vysokorizikové biopsie spolu</th>
      <td>1 096</td>
      <td>9 (0,8 %)</td>
    </tr>
    <tr>
      <th scope="row">Hospitalizovaní</th>
      <td>842</td>
      <td>6</td>
    </tr>
    <tr>
      <th scope="row">Ambulantní</th>
      <td>254</td>
      <td>3</td>
    </tr>
  </tbody>
</table>
</div>

<p>Autori záverom tvrdia, že pri dôsledne protokolizovanom postupe možno biopsiu bezpečne rozšíriť aj na pacientov, ktorí boli tradične považovaní za kontraindikovaných, vrátane ambulantného nastavenia.<sup>2</sup></p>

<h2>Čo obsahuje protokol ROCKY</h2>

<p>Podľa abstraktu a sprievodných materiálov k prezentácii má ROCKY štyri praktické piliere:<sup>2,3</sup></p>

<ol>
  <li><strong>Štandardizované predprocedurálne vyšetrenie a stratifikácia rizika</strong> – systematické hodnotenie rizikových faktorov krvácania a identifikácia pacientov s preddefinovanými znakmi vysokého rizika.</li>
  <li><strong>Úprava antitrombotickej liečby a korekcia ovplyvniteľných rizík</strong> – perioperačný manažment antikoagulácie a antiagregácie podľa bezpečných postupov.</li>
  <li><strong>Biopsia pod zobrazovacou kontrolou</strong> – dôraz na ultrazvukové navádzanie v reálnom čase a technický štandard výkonu.</li>
  <li><strong>Štruktúrované sledovanie po výkone</strong> – klinické monitorovanie zamerané na hematúriu, bolesť v boku, hemodynamickú nestabilitu a ďalšie komplikácie, s dĺžkou pozorovania podľa rizika.</li>
</ol>

<p>Takéto usporiadanie podporuje myšlienku, že „kontraindikácia“ nie je vždy binárna. Rozhodnutie má byť individualizované, no zároveň jasne protokolizované.</p>

<h2>Krvácanie ako hlavná komplikácia a odporúčania KHA-CARI</h2>

<p>Krvácanie ostáva najčastejšou komplikáciou biopsie. V prehľade Brachemiovej a Bolléeho sa uvádza, že závažné krvácanie vyžadujúce invazívnu hemostázu alebo chirurgický zákrok je v súčasnosti zriedkavé, najmä pri automatických zariadeniach a ultrazvukovom navádzaní.<sup>4</sup></p>

<p>Odporúčania KHA-CARI pre renálnu biopsiu sú s týmto rámcom konzistentné. Pred výkonom sa rutinne hodnotí hemoglobín, počet trombocytov, INR a aktivovaný parciálny tromboplastínový čas (aPTT). Riziko krvácania sa znižuje úpravou antiagregačnej a antikoagulačnej liečby. U nízkorizikových pacientov sa považuje za prijateľné krátke pozorovanie, typicky 6 až 8 hodín s prepustením v ten istý deň (1B); u pacientov s najvyšším rizikom sa odporúča predĺžená hospitalizácia, často až do 24 hodín.<sup>5</sup></p>

<p>K desmopresínu (DDAVP) KHA-CARI neuvádza formálne odporúčanie pre nedostatok dôkazov. V negraduovaných poznámkach k starostlivosti sa uvádza, že jednotky môžu pokračovať v doterajšej praxi, pričom sa má zvážiť najmä u pacientov od štádia CKD 3b vyššie, s dôslednou kontrolou bilancie tekutín a vyhýbaním sa nadmernému príjmu tekutín počas 6 až 8 hodín po podaní; u pacientov s významnou okluzívnou kardiovaskulárnou chorobou, vrátane cievneho stentu, sa desmopresín neodporúča.<sup>5</sup></p>

<h2>Desmopresín: súčasť lokálnej praxe, nie dokázaná príčina výsledku</h2>

<p>V komentári k ROCKY Laith Al-Rabadi, M.D., upozornil, že autori rutinne používali desmopresín na prevenciu krvácania. Z dizajnu štúdie však nemožno uzavrieť, že práve desmopresín bol hlavnou príčinou nízkej miery závažných komplikácií. Zároveň zdôraznil, že závažné krvácanie sa aj napriek priaznivým číslam vyskytlo a že vysoké riziko nemá automaticky vylúčiť biopsiu, ak môže zmeniť liečbu.<sup>1</sup></p>

<p>Retrospektívna kohorta Leclerca a kol. (413 biopsií natívnej obličky) ukázala, že pacienti, ktorí dostali desmopresín, mali horšiu funkciu obličiek (eGFR 28 oproti 45 ml/min/1,73 m²) a častejšie boli hospitalizovaní, no výskyt symptomatických hematómov bol porovnateľný (OR 0,39; 95 % CI 0,13 až 1,14) a potreba urgentného zobrazovania bola nižšia (OR 0,33; 95 % CI 0,11 až 0,98). Autori sami upozorňujú na limitačné dôsledky retrospektívneho dizajnu a indikácie liečby.<sup>6</sup></p>

<p>V praxi to znamená: desmopresín môže byť súčasťou lokálnej preventívnej schémy, no široká atribúcia efektu samotnému DDAVP nie je správna. Bez prospektívneho dizajnu zameraného na účinok desmopresínu v presne definovaných vysokorizikových skupinách ostáva jeho prínos neistý, čo je v súlade aj s postojom KHA-CARI.<sup>5,6</sup></p>

<h2>Klinické dôsledky</h2>

<p>Výsledky ROCKY majú tri prakticky dôležité posolstvá.</p>

<p><strong>1. Vysoké riziko nie je automatická absolútna bariéra.</strong> Pri prísnom štandardizovanom postupe môže byť výskyt závažných komplikácií aj v tejto skupine veľmi nízky.<sup>2</sup></p>

<p><strong>2. Ambulantná biopsia môže byť realistická, ak je splnená protokolová podmienka.</strong> Štatisticky významný rozdiel v závažných komplikáciách medzi hospitalizovanými a ambulantnými pacientmi sa nezistil. Širšie ambulantné programy majú zmysel len tam, kde je riziková stratifikácia, adekvátne pozorovanie a rýchla dostupnosť diagnostiky a intervencie pri komplikáciách. Ide o systémovú záchytnú sieť, nie len o individuálne rozhodnutie lekára.<sup>2,3</sup></p>

<p><strong>3. Protokol je pravdepodobne rovnako dôležitý ako výber pacientov.</strong> Konzistentnosť naprieč podskupinami podporuje, že bezpečnosť vyplýva z predprocedurálneho hodnotenia, korekcie rizík, zobrazovacej navigácie a sledovania po výkone, nie z náhody.<sup>2</sup></p>

<h2>Limity</h2>

<p>Pri interpretácii treba zohľadniť monocentrický charakter a závislosť výsledkov od organizačnej skúsenosti konkrétneho pracoviska, observačný dizajn s rizikom reziduálneho skreslenia a komplexnosť zásahov v protokole. Prínos jednotlivých prvkov, napríklad desmopresínu, úpravy antitrombotík, zobrazovacej techniky či dĺžky pozorovania, nie je možné jednoducho oddeliť.<sup>1,2</sup></p>

<p>Dostupné údaje sú zatiaľ predovšetkým kongresový abstrakt a sprievodné spravodajské materiály; peer-reviewed plný text v čase písania nebol k dispozícii. Pri prenose do iných centier treba protokol prispôsobiť lokálnym podmienkam, no zachovať jeho jadro: definované kroky prípravy, navigácie a monitorovania.</p>

<h2>Záver</h2>

<p>Štandardizovaná bezpečnostná cesta ROCKY v prospektívnej veľkej kohorte ukázala, že perkutánna biopsia natívnej obličky môže byť pri dôslednom protokole spojená s výskytom závažných komplikácií na úrovni 0,8 % aj u pacientov tradične považovaných za vysokorizikových. Výsledky podporujú aj ambulantné nastavenie, ak je striktne dodržaná protokolová redukcia rizika.<sup>2</sup></p>

<p>Pre klinickú prax to posúva dôraz od kategorizácie „povoliť alebo nepovoliť“ k protokolovej optimalizácii: perioperačná úprava antitrombotík, voľba zobrazovacej techniky a štruktúrované sledovanie po výkone.</p>

<hr>

<p><em>Upozornenie pre zdravotníckych pracovníkov: text je určený na odbornú informáciu a nenahrádza lokálne protokoly biopsie, súhrn charakteristických vlastností lieku ani individuálne klinické rozhodnutie. Indikáciu biopsie, úpravu antitrombotickej liečby a dĺžku pozorovania treba prispôsobiť pacientovi, dostupnosti intervencie a skúsenosti pracoviska.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Melville NA. <em>Kidney Biopsies Using Standardized Protocol Safe Even in High-Risk Patients.</em> Medscape Medical News. 24. októbra 2026. <a href="https://www.medscape.com/viewarticle/kidney-biopsies-using-standardized-protocol-safe-even-high-2026a100146l" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li>Roccatello D, Fenoglio R, Sciascia S. <em>Prospective Validation of the ROCKY Protocol for High-Risk Kidney Biopsy in 1,000 Procedures over 10 Years.</em> ASN Kidney Week 2026, abstrakt TH-OR001 (controlId 4558059). 22. októbra 2026. <a href="https://www.asn-online.org/education/kidneyweek/2026/program-abstract.aspx?controlId=4558059" target="_blank" rel="noopener noreferrer">ASN</a>.</li>
  <li>American Society of Nephrology. <em>Standardized Kidney Biopsy Protocol Is Safe in High-Risk Patients.</em> Newswise (tlačová správa ASN). 22. októbra 2026. <a href="https://www.newswise.com/articles/standardized-kidney-biopsy-protocol-is-safe-in-high-risk-patients" target="_blank" rel="noopener noreferrer">Newswise</a>.</li>
  <li>Brachemi S, Bollée G. <em>Renal biopsy practice: What is the gold standard?</em> World Journal of Nephrology. 2014;3(4):287-294. doi: <a href="https://doi.org/10.5527/wjn.v3.i4.287" target="_blank" rel="noopener noreferrer">10.5527/wjn.v3.i4.287</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/25374824/" target="_blank" rel="noopener noreferrer">25374824</a>, PMCID <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4220363/" target="_blank" rel="noopener noreferrer">PMC4220363</a>.</li>
  <li>MacGinley R, Champion De Crespigny PJ, Gutman T, Lopez-Vargas P, Manera K, Menahem S, Saunders J, See E, Voss D, Wong J. <em>KHA-CARI Guideline recommendations for renal biopsy.</em> Nephrology (Carlton). 2019;24(12):1205-1213. doi: <a href="https://doi.org/10.1111/nep.13662" target="_blank" rel="noopener noreferrer">10.1111/nep.13662</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/31490584/" target="_blank" rel="noopener noreferrer">31490584</a>.</li>
  <li>Leclerc S, Nadeau-Fredette AC, Elftouh N, Lafrance JP, Pichette V, Laurin LP. <em>Use of Desmopressin Prior to Kidney Biopsy in Patients With High Bleeding Risk.</em> Kidney International Reports. 2020;5(8):1180-1187. doi: <a href="https://doi.org/10.1016/j.ekir.2020.05.006" target="_blank" rel="noopener noreferrer">10.1016/j.ekir.2020.05.006</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/32775817/" target="_blank" rel="noopener noreferrer">32775817</a>, PMCID <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7403497/" target="_blank" rel="noopener noreferrer">PMC7403497</a>.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Hlavné počty (1 937 / 1 096 / 801; 56,6 %; 26,9 % opakovaných; 842 vs. 254; 9/0,8 %; p = 0,45) a OR pre vek, pohlavie, kreatinín, eGFR, antiagregáciu a antikoaguláciu boli overené v oficiálnom abstrakte ASN TH-OR001. Údaje o absencii nefektómie a úmrtia súvisiaceho s výkonom pochádzajú z tlačovej správy ASN (Newswise). Autorský zoznam KHA-CARI a Leclerca bol overený cez PubMed eutils a Crossref; Brachemi/Bollée cez PubMed (PMID 25374824). Byline Medscape (Nancy A. Melville) a komentár k desmopresínu (Al-Rabadi) boli overené z verejne dostupného textu Medscape. Peer-reviewed plný text ROCKY v čase písania nebol k dispozícii. Vlastný prínos: slovenská syntéza, oddelenie abstraktu od tlačovej správy a Medscape komentára, kalibrácia istoty k desmopresínu a limity monocentrického observačného dizajnu.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=transverzalna-koaxialna-biopsia-nativnej-oblicky-vytaznost">Transverzálna koaxiálna biopsia natívnej obličky: vyššia výťažnosť vzorky, ale dôkazy na zmenu praxe nestačia</a></li>
  <li><a href="article.php?slug=vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia">Východisková eGFR pri biopsii obličky: ako jej výber a imputácia môžu skresliť výsledky observačných štúdií</a></li>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
</ul>

HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rocky_protokol_biopsia',
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
