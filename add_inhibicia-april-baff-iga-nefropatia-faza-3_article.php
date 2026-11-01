<?php

/**
 * add_inhibicia-april-baff-iga-nefropatia-faza-3_article.php
 * Odborný článok: inhibícia APRIL/BAFF pri IgA nefropatii podľa dvochročných
 * výsledkov VISIONARY, ORIGIN 3 a TELIGAN (Kidney Week 2026 / NEJM).
 * Spracovaný zdroj: Nancy A. Melville. APRIL/BAFF-Inhibiting Drugs Show Sustained
 * Benefits in IgA Nephropathy at 2 Years. Medscape Medical News, 23. 10. 2026.
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
    'title'        => 'Inhibícia dráhy APRIL/BAFF pri IgA nefropatii: trvalé priaznivé účinky cielenej B-bunkovej imunoterapie v štúdiách fázy 3',
    'slug'         => 'inhibicia-april-baff-iga-nefropatia-faza-3',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dvojročné výsledky VISIONARY, ORIGIN 3 a TELIGAN ukazujú stabilizáciu sklonu eGFR a menej progresívnych udalostí pri inhibícii APRIL, prípadne súčasne BAFF. Sibeprenlimab má zrýchlené schválenie FDA na zníženie proteinúrie.',
    'content'      => <<<'HTML'
<figure><a href="img/inhibicia-april-baff-iga-nefropatia-faza-3.webp" rel="noopener noreferrer" target="_blank"><img src="img/inhibicia-april-baff-iga-nefropatia-faza-3.webp" alt="Polopriesvitný glomerulus a oblička v tyrkysovom svetle na tmavom pozadí s abstraktnými B-bunkami a imunoglobulínmi" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nejde o snímku konkrétneho pacienta ani výrobku. Znázorňuje spojenie glomerulu s B-bunkovou dráhou, ktorá je cieľom inhibície APRIL a BAFF.</figcaption></figure>

<p>IgA nefropatia (IgAN) je najčastejšie primárne glomerulové ochorenie a u podstatnej časti pacientov vedie k postupnému zhoršovaniu funkcie obličiek až k zlyhaniu obličiek. Podporná liečba a nefroprotektívne postupy prognózu zlepšili, no u časti pacientov ochorenie progreduje aj pri optimálnej štandardnej liečbe.</p>

<p>Na Kidney Week 2026 boli predstavené dvojročné údaje troch samostatných štúdií fázy 3 s liekmi, ktoré tlmi APRIL, a pri dvoch z nich aj BAFF. Kongresová správa Nancy A. Melvilleovej na Medscape tieto výsledky zhrnula a označila spoločný mechanizmus ako zásah do jadra patogenézy IgAN na úrovni B-buniek.<sup>1</sup> Nižšie uvádzam čísla podľa primárnych publikácií v <em>New England Journal of Medicine</em>, kde sú dostupné, a podľa FDA, kde ide o regulačný status.</p>

<h2>Patogenetické východisko: BAFF a APRIL</h2>

<p>BAFF (faktor aktivujúci B-bunky) a APRIL (ligand indukujúci proliferáciu) patria do rodiny TNF a podporujú prežívanie a diferenciáciu B-buniek. Pri IgAN sú zvýšené hladiny oboch cytokínov spájané so závažnosťou ochorenia a s tvorbou galaktóza-deficitného IgA1 (Gd-IgA1), následných autoprotilátok a imunokomplexov v mezangiu. Prehľad Cheunga a kol. preto BAFF a APRIL označuje za relevantné terapeutické ciele.<sup>2</sup></p>

<p>Inhibícia tejto osi nie je zameraná len na hemodynamiku a metabolické následky proteinúrie. Má potenciál znížiť produkciu patologického IgA1 a tým tlmiť samotný imunologický motor ochorenia.</p>

<h2>VISIONARY: sibeprenlimab (inhibítor APRIL)</h2>

<p>VISIONARY je randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 3 u dospelých s biopticky potvrdenou IgAN. Zaradených bolo 510 pacientov, randomizácia 1 : 1 na sibeprenlimab 400 mg alebo placebo subkutánne každé 4 týždne.<sup>3,4</sup></p>

<p>Predšpecifikovaná interim analýza prvých 320 pacientov, ktorí mohli dosiahnuť 9. mesiac, ukázala významné zníženie 24-hodinového pomeru bielkovín ku kreatinínu: pri sibeprenlimabe −50,2 %, pri placebe +2,1 %, čo zodpovedalo placebom upravenému zníženiu o 51,2 % (96,5 % CI 42,9 až 58,2; p &lt; 0,001).<sup>3</sup> Na základe týchto proteinúrických údajov FDA 25. novembra 2025 udelila zrýchlené schválenie lieku Voyxact (sibeprenlimab-szsi) na zníženie proteinúrie u dospelých s primárnou IgAN s rizikom progresie. Schválenie je podmienené potvrdením dlhodobého prínosu pre funkciu obličiek v pokračujúcej štúdii VISIONARY.<sup>5</sup></p>

<p>Finálna 24-mesačná analýza, publikovaná 22. októbra 2026, priniesla kľúčový sekundárny ukazovateľ: annualizovaný sklon eGFR bol 0,3 ml/min/1,73 m² za rok (95 % CI −0,4 až 0,9) pri sibeprenlimabe a −4,2 (95 % CI −4,9 až −3,6) pri placebe; rozdiel medzi skupinami 4,5 ml/min/1,73 m² za rok (95 % CI 3,6 až 5,4; p &lt; 0,001).<sup>4</sup> Zložený ukazovateľ poklesu funkcie obličiek alebo zlyhania sa vyskytol u 1 pacienta (0,4 %) v skupine sibeprenlimabu a u 28 pacientov (11,2 %) pri placebe (HR 0,029; 95 % CI 0,004 až 0,214; p &lt; 0,001).<sup>4</sup> Nežiaduce udalosti boli celkovo porovnateľné; závažné infekcie sa vyskytli u 1,9 % oproti 4,0 % pri placebe. Úmrtia neboli hlásené.<sup>4</sup></p>

<h2>ORIGIN 3: atacicept (duálna inhibícia BAFF a APRIL)</h2>

<p>ORIGIN 3 randomizovala dospelých s biopticky potvrdenou IgAN v pomere 1 : 1 na atacicept 150 mg alebo placebo, podávané subkutánne raz týždenne. Liečbu dostalo 428 pacientov (214 v každej skupine).<sup>6,7</sup></p>

<p>Interim analýza pri 36. týždni ukázala zníženie 24-hodinového UPCR o 45,7 % pri atacicepte oproti 6,8 % pri placebe (geometrický priemer rozdielu 41,8 percentuálneho bodu; 95 % CI 28,9 až 52,3; p &lt; 0,001).<sup>6</sup></p>

<p>Finálna účinnostná analýza pri 52 a 104 týždňoch: priemerná zmena eGFR v 52. týždni bola −0,11 ml/min/1,73 m² pri atacicepte a −5,69 pri placebe (rozdiel 5,58; 95 % CI 3,68 až 7,48; p &lt; 0,001). Annualizovaný sklon eGFR do 104. týždňa bol −0,60 oproti −5,60 ml/min/1,73 m² za rok (rozdiel 5,00; 95 % CI 3,55 až 6,45; p &lt; 0,001).<sup>7</sup> Zložená progresia ochorenia obličiek nastala u 5,1 % oproti 17,8 % (HR 0,24; 95 % CI 0,12 až 0,48; p &lt; 0,001). V skupine ataciceptu nebola dialýza, transplantácia ani úmrtie; v placebovej skupine sa dialýza, transplantácia alebo úmrtie vyskytli u 7 pacientov. Závažné nežiaduce udalosti: 7,0 % oproti 15,4 %.<sup>7</sup></p>

<h2>TELIGAN: telitacicept (duálna inhibícia BAFF a APRIL)</h2>

<p>TELIGAN je multicentrická štúdia fázy 3 v Číne u 318 dospelých s biopticky potvrdenou IgAN a perzistujúcou proteinúriou najmenej 1,0 g denne. Randomizácia 1 : 1 na telitacicept 240 mg alebo placebo subkutánne; do 39. týždňa raz týždenne, potom udržiavací režim každé 2 týždne do 104. týždňa.<sup>1,8</sup></p>

<p>Interim analýza v 39. týždni (NEJM): zmena 24-hodinového UPCR −58,9 % pri telitacicepte oproti −8,8 % pri placebe; relatívny rozdiel −55,0 % (95 % CI −61,3 až −47,6; p &lt; 0,001). Zmena eGFR od východiskovej hodnoty: −1,0 % oproti −7,7 %.<sup>8</sup> Nežiaduce udalosti boli častejšie pri telitacicepte (89,3 % oproti 78,6 %), závažné nežiaduce udalosti menej časté (2,5 % oproti 8,2 %).<sup>8</sup></p>

<p>Dvojročné údaje predstavené na Kidney Week 2026 a zhrnuté Melvilleovou uvádzajú annualizovaný sklon eGFR −0,6 oproti −5,7 ml/min/1,73 m² za rok (rozdiel približne 5,1; p &lt; 0,001), menej pacientov s poklesom eGFR o 30 % a o 40 % (HR 0,11 a 0,19) a žiadne zložené udalosti zlyhania obličiek v aktívnej skupine oproti 3,1 % pri placebe.<sup>1</sup> Tieto 104-týždňové čísla zatiaľ nemajú samostatný peer-reviewed DOI; v článku ich preto uvádzam ako kongresové a sekundárne hlásené výsledky, nie ako plne bibliograficky uzavretú NEJM analýzu.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Prehľad sklonu eGFR v troch štúdiách fázy 3" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štúdia / liek</th>
        <th scope="col">Cieľ</th>
        <th scope="col">n</th>
        <th scope="col">Sledovanie sklonu eGFR</th>
        <th scope="col">Sklon eGFR (aktívna vs placebo)</th>
        <th scope="col">Rozdiel</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">VISIONARY / sibeprenlimab<sup>4</sup></th>
        <td>APRIL</td>
        <td>510</td>
        <td>24 mesiacov</td>
        <td>0,3 vs −4,2 ml/min/1,73 m²/rok</td>
        <td>4,5</td>
      </tr>
      <tr>
        <th scope="row">ORIGIN 3 / atacicept<sup>7</sup></th>
        <td>BAFF + APRIL</td>
        <td>428 liečených</td>
        <td>do 104. týždňa</td>
        <td>−0,60 vs −5,60</td>
        <td>5,00</td>
      </tr>
      <tr>
        <th scope="row">TELIGAN / telitacicept<sup>1</sup></th>
        <td>BAFF + APRIL</td>
        <td>318</td>
        <td>do 104. týždňa (kongres)</td>
        <td>−0,6 vs −5,7</td>
        <td>~5,1</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Klinické implikácie</h2>

<p>Tri odlišné molekuly so spoločným zásahom do osi APRIL (a pri atacicepte s telitaciceptom aj BAFF) konzistentne ukázali veľký rozdiel v sklone eGFR oproti placebu, rádovo okolo 4,5 až 5 ml/min/1,73 m² za rok, a menej zložených progresívnych udalostí. To je v súlade s hypotézou, že modulácia B-buniek zasahuje patogenézu IgAN bližšie k zdroju než samotná hemodynamická nefroprotekcia.<sup>1,2</sup></p>

<p>Sibeprenlimab je v USA dostupný v režime zrýchleného schválenia na redukciu proteinúrie; potvrdenie dlhodobého prínosu pre eGFR je predmetom dokončenia VISIONARY a regulačného sledovania.<sup>5</sup> Atacicept a telitacicept v čase písania tohto textu nemajú rovnaké FDA schválenie pre IgAN; ich použitie mimo schválených indikácií treba viazať na lokálnu dostupnosť a regulačný rámec.</p>

<p>V praxi zostáva otázka zaradenia týchto liekov do sekvencie so SGLT2 inhibítormi, RAAS blokádou, endotelínovými antagonistami a inhibítormi komplementu. Štúdie mali na pozadí vysoký podiel RAAS inhibície a rôzny podiel SGLT2 inhibítorov; priame porovnania medzi biologikami chýbajú.</p>

<h2>Limity</h2>

<ul>
  <li>Finálne 104-týždňové údaje TELIGAN sú zatiaľ dostupné predovšetkým ako kongresové a sekundárne hlásenie; peer-reviewed finálna publikácia s DOI ešte nie je v tom istom rozsahu ako VISIONARY a ORIGIN 3.<sup>1</sup></li>
  <li>Populácie mali relatívne zachovanú východiskovú eGFR (okolo 65 až 75 ml/min/1,73 m²). Platnosť pri eGFR pod 40 alebo 30 ml/min/1,73 m² nie je z týchto dát overená.<sup>1</sup></li>
  <li>TELIGAN prebiehala v Číne; vonkajšia platnosť pre iné populácie si vyžaduje opatrnosť.</li>
  <li>Zrýchlené schválenie sibeprenlimabu stojí na proteinúrii; spomalenie poklesu eGFR je podporené finálnou VISIONARY analýzou, ale regulačné potvrdenie dlhodobého prínosu ostáva podmienkou ďalšieho sledovania.<sup>4,5</sup></li>
  <li>Bezpečnosť pri dlhodobej modulácii B-buniek, najmä infekcie a hypogamaglobulinémia, treba sledovať aj mimo rámca štúdií.</li>
  <li>Nejde o priame head-to-head porovnanie liekov; rozdiely medzi štúdiami (vstupné kritériá, sprievodná liečba, geografické zloženie) neumožňujú tvrdiť, ktorý liek je nadradený.</li>
</ul>

<hr>

<p><em>Upozornenie pre zdravotníckych pracovníkov: text je určený na odbornú informáciu a nenahrádza súhrn charakteristických vlastností lieku, lokálne odporúčania ani individuálne klinické rozhodnutie. Regulačný status a indikácie sa môžu meniť; pred predpisom overte aktuálne SPC a rozhodnutia príslušných autorít.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Melville NA. <em>APRIL/BAFF-Inhibiting Drugs Show Sustained Benefits in IgA Nephropathy at 2 Years.</em> Medscape Medical News. 23. októbra 2026. <a href="https://www.medscape.com/viewarticle/april-baff-inhibiting-drugs-show-sustained-benefits-iga-2026a1001456" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li>Cheung CK, Barratt J, Liew A, Zhang H, Tesar V, Lafayette R. <em>The role of BAFF and APRIL in IgA nephropathy: pathogenic mechanisms and targeted therapies.</em> Frontiers in Nephrology. 2024;3:1346769. doi: <a href="https://doi.org/10.3389/fneph.2023.1346769" target="_blank" rel="noopener noreferrer">10.3389/fneph.2023.1346769</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/38362118/" target="_blank" rel="noopener noreferrer">38362118</a>, PMCID <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC10867227/" target="_blank" rel="noopener noreferrer">PMC10867227</a>.</li>
  <li>Perkovic V, Trimarchi H, Tesar V, Lafayette R, Wong MG, Barratt J, Suzuki Y, Liew A, Zhang H, Carroll K, Jha V, Quevedo A, Han SH, Praga M, Chacko B, Sahay M, Cheung CK, Kooienga L, Walsh M, Xia J, Fajardo C, Shah L, Hafkin J, Rizk DV. <em>Sibeprenlimab in IgA Nephropathy: Interim Analysis of a Phase 3 Trial.</em> New England Journal of Medicine. 2026;394(7):635-646. doi: <a href="https://doi.org/10.1056/NEJMoa2512133" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2512133</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/41211929/" target="_blank" rel="noopener noreferrer">41211929</a>.</li>
  <li>Rizk DV, Barratt J, Suzuki Y, Zhang H, Wong MG, Liew A, Lafayette R, Tesař V, Trimarchi H, Carroll K, Roberts ISD, Jha V, Quevedo A, Han SH, Yahya R, Cheung CK, Ramachandran R, Walsh M, Chacko B, Praga M, Chen JB, Suassuna J, Xia J, Shah L, Perkovic V. <em>Sibeprenlimab in IgA Nephropathy: Final Phase 3 Trial Analysis.</em> New England Journal of Medicine. 2026 Oct 22. doi: <a href="https://doi.org/10.1056/NEJMoa2609127" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2609127</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/42911185/" target="_blank" rel="noopener noreferrer">42911185</a>.</li>
  <li>U.S. Food and Drug Administration. <em>FDA approves a new treatment for primary immunoglobulin A nephropathy.</em> 25. novembra 2025. <a href="https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-new-treatment-primary-immunoglobulin-nephropathy" target="_blank" rel="noopener noreferrer">FDA</a>.</li>
  <li>Lafayette R, Barbour SJ, Brenner RM, Campbell KN, Doan T, Eren N, Floege J, Jha V, Kim BS, Liew A, Maes B, Pal A, Pecoits-Filho R, Phoon RKS, Rizk DV, Suzuki H, Tesař V, Trimarchi H, Wei X, Zhang H, Barratt J. <em>A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy.</em> New England Journal of Medicine. 2026;394(7):647-657. doi: <a href="https://doi.org/10.1056/NEJMoa2510198" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2510198</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/41196369/" target="_blank" rel="noopener noreferrer">41196369</a>.</li>
  <li>Barratt J, Brenner RM, Barbour SJ, Campbell KN, Doan T, Eren N, Floege J, Fordyce MW, Jha V, Khawaja Z, Kim BS, Liew A, Maes B, Pal A, Pecoits-Filho R, Phoon RKS, Rizk DV, Suzuki H, Tesař V, Trimarchi H, Wei X, Yu L, Zhang H, Lafayette R. <em>Atacicept in IgA Nephropathy: Phase 3 Trial Final Efficacy Analysis.</em> New England Journal of Medicine. 2026 Oct 22. doi: <a href="https://doi.org/10.1056/NEJMoa2610103" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2610103</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/42911181/" target="_blank" rel="noopener noreferrer">42911181</a>.</li>
  <li>Lv J, Liu L, Wang W, Wang X, Zuraw Q, Perkovic V, Fang J, Zhang H; for the TELIGAN Investigators. <em>Telitacicept for IgA Nephropathy: Interim Analysis of a Phase 3 Trial.</em> New England Journal of Medicine. 2026;394(19):1916-1924. doi: <a href="https://doi.org/10.1056/NEJMoa2514415" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2514415</a>. PMID <a href="https://pubmed.ncbi.nlm.nih.gov/42127391/" target="_blank" rel="noopener noreferrer">42127391</a>.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Hlavné čísla sklonu eGFR, zložených ukazovateľov a interim proteinúrie boli overené v abstraktoch NEJM a v PubMed/Crossref záznamoch (DOI a PMID uvedené vyššie). Autorské zoznamy interim aj finálnych NEJM prác boli overené cez Crossref. FDA schválenie Voyxactu (sibeprenlimab-szsi) bolo overené na oficiálnej stránke FDA (25. 11. 2025). Dvojročné údaje TELIGAN o sklone eGFR a zložených endpointoch boli prevzaté zo správy Medscape (Melville, 23. 10. 2026) a konzistentné s tlačovou správou o ASN prezentácii; samostatný peer-reviewed DOI finálnej TELIGAN analýzy v čase písania nebol k dispozícii. Prehľad patogenézy BAFF/APRIL: Cheung a kol., Frontiers in Nephrology, PMC10867227. Vlastný prínos: slovenská syntéza, oddelenie overených NEJM/FDA údajov od kongresových TELIGAN čísel, tabuľkové porovnanie a limity vonkajšej platnosti.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept v IgA nefropatii: interim analýza fázy 3 (TELIGAN)</a></li>
  <li><a href="article.php?slug=sibeprenlimab-povetacicept-ravulizumab-iga-nefropatia">Sibeprenlimab, povetacicept a ravulizumab pri IgA nefropatii</a></li>
  <li><a href="article.php?slug=iptakopan-iga-nefropatia-applause-igan-24-mesiacov">Iptakopan a APPLAUSE-IgAN: 24-mesačný sklon eGFR</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus liečby IgA nefropatie podľa KDIGO 2025</a></li>
  <li><a href="article.php?slug=komplement-oblicky-iga-nefropatia-inhibicia-klinik">Komplement pri IgA nefropatii: diagnostika a cielená inhibícia</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_inhibicia_april_baff_iga_nefropatia_faza_3',
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
