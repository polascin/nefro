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
    'title' => 'Odporúčania ESC/ERA 2026: spoločný plán starostlivosti o srdce a obličky',
    'slug' => 'esc-era-2026-kardiorenalne-odporucania',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt' => 'Čo prinášajú odporúčania ESC/ERA 2026: spoločné hodnotenie eGFR a albuminúrie, liečba podľa indikácie, ciele tlaku a bezpečné monitorovanie.',
    'content'      => <<<'HTML'
<p>Prvé odporúčania Európskej kardiologickej spoločnosti (ESC) venované kardiovaskulárnym ochoreniam a chronickej chorobe obličiek (CKD), vypracované v spolupráci s Európskou nefrologickou asociáciou (ERA), boli publikované 28. augusta 2026. Ich praktickým posolstvom je včas rozpoznať CKD, vyhodnotiť obličkové aj kardiovaskulárne riziko a zosúladiť liečbu medzi odbormi. Nejde o jednotnú kombináciu liekov pre každého pacienta. [1, 2]</p>
<h2>Vyšetrovať eGFR aj albuminúriu</h2>
<p>Pri diagnostikovaní kardiovaskulárneho ochorenia sa má CKD aktívne vyhľadávať pomocou odhadovanej glomerulovej filtrácie (eGFR) a pomeru albumínu ku kreatinínu v moči (UACR). Samotný kreatinín nezachytí všetkých rizikových pacientov: albuminúria môže byť prítomná aj pri zachovanej eGFR a poskytuje samostatnú prognostickú informáciu. [1, 2]</p>
<p>Jednorazový patologický výsledok ešte automaticky nepotvrdzuje chronickú chorobu. Treba posúdiť predchádzajúce nálezy, možné akútne príčiny a pretrvávanie abnormality najmenej tri mesiace. Oficiálny prehľad ESC zdôrazňuje opakované meranie eGFR a UACR na preukázanie chronicity. Potrebné vyšetrenie akútneho zhoršenia sa však nesmie odkladať len preto, aby uplynuli tri mesiace. [2, 4]</p>
<h2>STAMP: od zistenia choroby po organizáciu starostlivosti</h2>
<p>Rámec STAMP pomáha premeniť výsledky vyšetrení na spoločný plán. Jeho jednotlivé kroky možno prakticky vyjadriť takto: [1, 2]</p>
<ul>
<li><strong>S, Screen:</strong> vyhľadávať CKD pomocou eGFR a UACR.</li>
<li><strong>T, Triage:</strong> určiť riziko a naliehavosť ďalšej starostlivosti, vrátane rizika zlyhania obličiek a kardiovaskulárnych príhod.</li>
<li><strong>A, Address CKD risk:</strong> ovplyvniť rizikové faktory a včas začať indikovanú liečbu.</li>
<li><strong>M, Modify CVD management:</strong> prispôsobiť kardiovaskulárnu diagnostiku a liečbu funkcii obličiek.</li>
<li><strong>P, Plan health services:</strong> naplánovať dostupnú a koordinovanú starostlivosť so zapojením pacienta.</li>
</ul>
<p>Pre ambulanciu to znamená určiť aj to, kto skontroluje laboratórne výsledky, kto upraví liečbu a kedy je potrebná konzultácia druhého odboru. Ide o praktickú interpretáciu rámca, nie o nový povinný formulár.</p>
<h2>Kombinovaná liečba podľa indikácie</h2>
<p>ACE inhibítor alebo blokátor receptorov angiotenzínu II (sartan), inhibítor SGLT2 a vhodná hypolipidemická liečba tvoria dôležité súčasti prevencie. Majú však odlišné indikácie a bezpečnostné podmienky. Statín znižuje najmä aterosklerotické riziko; nemožno mu automaticky pripisovať rovnaký účinok na progresiu CKD ako ostatným liekom. ACE inhibítor a sartan sa navzájom nekombinujú. [1, 4]</p>
<p>Odporúčania ESC/ERA rozlišujú použitie SGLT2 inhibítorov podľa diabetu, eGFR a albuminúrie. Pri diabete 2. typu a CKD uvádzajú začatie pri eGFR najmenej 20 ml/min/1,73 m² bez ohľadu na glykemickú kompenzáciu. Pri CKD bez diabetu závisí sila odporúčania aj od UACR. Samostatnú indikáciu môže predstavovať srdcové zlyhávanie. Preto stručné označenie „základná trojkombinácia“ nenahrádza individuálne posúdenie. [1, 4]</p>
<p>Finerenón a agonista receptora GLP-1 sa nemajú pridávať automaticky každému pacientovi so srdcovým zlyhávaním. Pri obličkovej indikácii ESC/ERA viažu finerenón na diabetes 2. typu, albuminúriu a dostatočnú eGFR, s kontrolou draslíka. Pri semaglutide treba rešpektovať konkrétnu skúmanú populáciu a režim; výsledky nemožno bez ďalších dôkazov preniesť na celú liekovú skupinu. Liečba srdcového zlyhávania sa navyše riadi jeho fenotypom. [1]</p>
<div class="pdf-keep-together"><h2>Cieľ tlaku: rozhodujúca je hranica eGFR a tolerancia</h2>
<p>ESC/ERA odporúčajú systolický tlak <strong>120 až 129 mm Hg pri CKD s eGFR ≥ 30 ml/min/1,73 m², ak je tento cieľ tolerovaný</strong> (trieda I, úroveň dôkazov A). Pri eGFR pod 30 ml/min/1,73 m² odporúčajú individuálny cieľ. Údaj teda neoznačuje iba pacienta s hodnotou presne 30. Výklad musí zohľadniť štandardizovaný spôsob merania, ortostatické ťažkosti, krehkosť a klinický stav. [1, tabuľka odporúčaní 9]</p></div>
<h2>Antikoagulácia: voľba lieku, nie vyššia intenzita</h2>
<p>Pri fibrilácii predsiení a CKD dokument uprednostňuje priame perorálne antikoagulanciá (DOAC) pred antagonistami vitamínu K pri eGFR ≥ 30 ml/min/1,73 m² (I A). Pri eGFR 15 až 29 ml/min/1,73 m² sa má zvážiť uprednostnenie perorálneho inhibítora faktora Xa (IIa B1). Pri eGFR pod 15 vrátane dialýzy sa rozhodovanie individualizuje. Nejde o pokyn zvýšiť dávku alebo intenzitu antikoagulácie. [1, tabuľka odporúčaní 26]</p>
<p>Najskôr treba posúdiť indikáciu antikoagulácie a pomer prevencie tromboembólie k riziku krvácania. Výber aj dávka musia rešpektovať konkrétny prípravok, jeho platný súhrn charakteristických vlastností a spôsob hodnotenia funkcie obličiek požadovaný pre dávkovanie. Triedu odporúčania nemožno zamieňať s registráciou lieku ani s univerzálnou dávkovacou schémou. [1]</p>
<h2>Skorý pokles eGFR: hodnotiť súvislosti, nevynechať monitoring</h2>
<p>Po začatí liečby ovplyvňujúcej vnútroglomerulovú hemodynamiku môže eGFR prechodne klesnúť. Takáto zmena nemusí znamenať štrukturálne poškodenie obličiek ani stratu dlhodobého prínosu liečby. Na druhej strane rastúci kreatinín, hypotenzia, dehydratácia alebo hyperkaliémia vyžadujú vyhodnotenie. Pojem „obava z poklesu eGFR“ preto nesmie viesť ani k reflexnému vysadzovaniu, ani k ignorovaniu akútneho poškodenia. [1, 4]</p>
<p><strong>Monitorovanie sa líši podľa lieku.</strong> Pri ACE inhibítore alebo sartane KDIGO odporúča kontrolovať tlak, kreatinín a draslík do 2 až 4 týždňov od začatia alebo zvýšenia dávky, podľa východiskovej funkcie obličiek a kaliémie. Zvýšenie kreatinínu o viac než 30 % do štyroch týždňov vyžaduje prehodnotenie. Percentuálny vzostup kreatinínu nie je matematicky totožný s rovnakým percentuálnym poklesom eGFR. Aj antagonisty mineralokortikoidných receptorov (MRA) vyžadujú sledovanie draslíka. [4]</p>
<p>ESC/ERA nepožadujú automaticky častejšie meranie kreatinínu alebo eGFR iba preto, že sa začal SGLT2 inhibítor alebo agonista GLP-1. Častejšia kontrola je namieste pri ďalšom klinickom dôvode, napríklad pri podozrení na objemovú depléciu. Pred úpravou liečby treba zhodnotiť hydratáciu, diuretiká, nesteroidové protizápalové lieky a interkurentné ochorenie. [1, 4]</p>
<h2>Súvislosť s americkými odporúčaniami CKM</h2>
<p>Americké odporúčania AHA/ACC/ADA/ASN z roku 2026 používajú širší rámec kardiovaskulárno-renálno-metabolického syndrómu (CKM), ktorý zahŕňa aj obezitu a ďalšie metabolické riziká. U dospelých v štádiu CKM 2 a vyššom odporúčajú hodnotiť eGFR aj UACR najmenej raz ročne. Podporujú interdisciplinárnu starostlivosť a liečbu podľa rizikového profilu. Ide však o samostatný dokument; jeho štádiá, prahy a triedy odporúčaní nemožno automaticky zamieňať s ESC/ERA. [3, 5]</p>
<h2>Čo zmeniť v každodennej praxi</h2>
<p>Pri pacientovi s kardiovaskulárnym ochorením má byť dostupný výsledok eGFR aj UACR, posúdená chronicita a zdokumentovaný liečebný plán. Ten má obsahovať indikácie liekov, spôsob titrácie, termín kontrol a zodpovednosť za reakciu na patologické výsledky. Koordinácia nefrológa, kardiológa a internistu má predísť oneskorenej liečbe aj protichodným úpravám. Toto je praktické posolstvo odporúčaní, nie výzva liečiť všetkých pacientov rovnakou schémou.</p>
<p><small><em>Redakčné overenie k 24. septembru 2026: údaje ESC/ERA boli skontrolované v plnom texte vrátane tabuliek odporúčaní. Bibliografia a autorstvo boli overené cez verejné záznamy PubMed/Europe PMC a Crossref. Americké odporúčanie o každoročnom meraní eGFR a UACR bolo overené v publikovanom texte a oficiálnych materiáloch ACC. Článok je odborným komentovaným prehľadom vybraných bodov, nie úplným prekladom odporúčaní.</em></small></p>

<div class="pdf-keep-together"><hr><h2>Zdroje</h2><ol>
<li><small><em>Damman K, Ter Maaten JM, Mayne KJ, Bolignano D, Brown EM, da Costa BR, Dagre A, Gansevoort RT, Gavina C, Goette A, Gorog DA, Gotcheva NN, Kaluzna-Oleksy M, Kelly DM, Korzh O, Lees JS, Manfrini O, Martens P, Nunez J, Stabile E, Sudano I, Theodorakopoulou MP, Winther S, Herrington WG, ESC Guidelines Advisory Group. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease, in collaboration with the European Renal Association (ERA). Eur Heart J. 2026. ehag098. <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>European Society of Cardiology. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease. Kongresový prehľad, 30. augusta 2026. <a href="https://www.escardio.org/news/news-room/congress-news/2026-esc-guidelines-for-the-management-of-cvd-and-ckd/" target="_blank" rel="noopener noreferrer">Oficiálny prehľad ESC</a>.</em></small></li>
<li><small><em>Ndumele CE, Rodriguez F, Dixon DL, Khan SS, Mukherjee D, Bajaj M, Bangalore S, Bozkurt B, Breathett K, Clarke SL, de Boer IH, Ellison DH, Evangelista LS, Heffron SP, Kazi DS, Kulshreshtha A, Lingvay I, Low Wang CC, Mercado CA, Morton JM, Neeland IJ, Pagidipati N, Powell-Wiley TM, Rangaswami J, Rao G, Reza N, Saeed A, St Peter W, Starks JB, Sterling M, Talbot AW, Tran AH, Tuttle KR, VanWagner LB, Vest AR, Virani SS. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. J Am Coll Cardiol. 2026;87(22S):e1889–e2007. <a href="https://doi.org/10.1016/j.jacc.2026.03.056" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42265997/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plné odporúčanie</a>.</em></small></li>
<li><small><em>American College of Cardiology. First-Ever Guideline Addresses CKM Syndrome. 9. júna 2026. <a href="https://www.acc.org/Latest-in-Cardiology/Journal-Scans/2026/06/08/17/44/First-Ever-Guideline-Addresses-CKM-Syndrome" target="_blank" rel="noopener noreferrer">Oficiálny prehľad ACC</a>.</em></small></li>
</ol></div>
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
    'log_prefix' => 'add_esc-era-2026-kardiorenalne-odporucania_article',
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
