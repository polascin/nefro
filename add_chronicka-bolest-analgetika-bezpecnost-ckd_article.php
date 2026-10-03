<?php
/**
 * add_chronicka-bolest-analgetika-bezpecnost-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: liečba chronickej bolesti s dôrazom na renálnu
 * bezpečnosť — rámec odporúčaní CDC 2022 (prednosť neopioidnej liečby),
 * debata o NSAID pri CKD (Kidney360 PRO/CON/COMMENTARY), duloxetín a renálne
 * obmedzenie, gabapentinoidy a opioidy s renálne eliminovanými metabolitmi.
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie viacerých zdrojov
 * (Dowell 2022 MMWR, Guthrie 2020 Kidney360 CON, Baker a Perazella 2020
 * Kidney360 COMMENTARY, preskripčné informácie duloxetínu) — nie preklad
 * jedného zdrojového článku, preto sa do source_authors.php nedopĺňajú
 * pôvodní autori.
 *
 * Číselné údaje overené proti abstraktom v PubMede (PMID 36327391, 35372868,
 * 35372870, 39447933) a proti americkým preskripčným informáciám duloxetínu.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Chronická bolesť pri chronickej chorobe obličiek: ktoré analgetikum a za akú cenu',
    'slug'         => 'chronicka-bolest-analgetika-bezpecnost-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pri chronickej chorobe obličiek sú problematické takmer všetky bežné analgetiká — každé inak. Prehľad rámca odporúčaní CDC 2022, odbornej debaty o nesteroidných antiflogistikách pri CKD, renálnych obmedzení duloxetínu a opioidov s renálne eliminovanými metabolitmi. Vrátane toho, prečo „nepredpísať nič“ nie je bezpečná voľba.',
    'content'      => <<<'HTML'
<figure><a href="img/chronicka-bolest-analgetika-ckd.webp" rel="noopener noreferrer" target="_blank"><img src="img/chronicka-bolest-analgetika-ckd.webp" alt="Jedna súvislá stuha svetla vychádza z rozpúšťajúcej sa tablety: pri zovretej ruke je chladne modrá a upokojujúca, no cestou sa mení na žeravú oranžovú a obličku na druhom konci spaľuje a rozpukáva" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie klinický záznam. Tá istá stuha svetla, ktorá uvoľňuje bolesť v ruke, dopadá na obličku ako žiar. Pri CKD nejde o to, či analgetikum účinkuje — ale o to, čo stojí na druhom konci.</figcaption></figure>

<p>Chronická bolesť je u pacientov s chronickou chorobou obličiek bežná, poddiagnostikovaná a poddliečená. Dôvod nie je ľahostajnosť: pri CKD je <strong>problematické prakticky každé bežné analgetikum</strong>, len každé iným spôsobom. Výsledkom býva buď zbytočné utrpenie, alebo liečba, ktorá sa po čase prejaví ako akútne poškodenie obličiek, hyperkaliémia, delírium či pád.</p>

<p>Tento článok neponúka univerzálny recept — neexistuje. Ponúka rámec na rozhodovanie a tri okruhy liekov, pri ktorých sa v nefrologickej ambulancii rozhoduje najčastejšie.</p>

<h2>Rámec: neopioidná liečba má prednosť</h2>

<p>Najcitovanejším rámcovým dokumentom sú <strong>odporúčania CDC pre predpisovanie opioidov pri bolesti (2022)</strong>, publikované v <em>MMWR Recommendations and Reports</em>. Aktualizujú dokument z roku 2016 a pokrývajú akútnu (trvanie pod 1 mesiac), subakútnu (1 až 3 mesiace) aj chronickú (nad 3 mesiace) bolesť u ambulantných pacientov od 18 rokov. <strong>Nevzťahujú sa</strong> na bolesť pri kosáčikovej anémii, na onkologickú bolesť ani na paliatívnu a terminálnu starostlivosť.</p>

<p>Dokument je postavený na metodike GRADE a rieši štyri okruhy: či vôbec začať opioid, výber opioidu a dávky, dĺžku úvodného predpisu a kontroly, a posúdenie rizika a riešenie potenciálnych škôd.</p>

<p>Dve vety z neho stojí za to prečítať doslova, pretože sa obe v praxi pravidelne skresľujú:</p>

<ul>
  <li><strong>„Osoby s bolesťou majú dostať primeranú liečbu bolesti“</strong> — s dôkladným zvážením prínosov a rizík <em>všetkých</em> možností liečby v kontexte situácie pacienta. Dokument nie je návodom na nepredpisovanie.</li>
  <li><strong>„Odporúčania sa nemajú uplatňovať ako nepružné štandardy starostlivosti naprieč populáciami pacientov.“</strong> Toto je v dokumente explicitne — práve preto, že predchádzajúca verzia sa v praxi uplatňovala ako rigidný limit.</li>
</ul>

<p>Pre nefrológa z toho vyplýva pracovný postup, nie zákaz: <strong>maximalizovať nefarmakologické a neopioidné možnosti, a opioid zvažovať až vtedy, keď očakávaný prínos prevažuje nad možnou škodou — s hodnotením rizika a s kontrolami.</strong></p>

<h2>Okruh 1: nesteroidné antiflogistiká</h2>

<p>Otázka, či sa NSAID dajú pri CKD používať bezpečne, je natoľko sporná, že časopis <em>Kidney360</em> jej venoval formát <strong>PRO / CON / COMMENTARY</strong> — teda dve protichodné stanoviská a komentár. To samo o sebe hovorí viac než ktorákoľvek jednotlivá veta: <strong>zhoda neexistuje.</strong></p>

<p>Argumenty proti sú známe a vážne:</p>

<ul>
  <li>NSAID majú nežiaduce účinky naprieč orgánmi — <strong>obličky, gastrointestinálny trakt, kardiovaskulárny systém</strong>.</li>
  <li>Pri CKD je riziko akútneho poškodenia obličiek klinicky významne vyššie, pretože inhibícia prostaglandínov odoberá obličke práve ten mechanizmus, ktorým si pri zníženej perfúzii udržiava glomerulovú filtráciu.</li>
  <li>Pacienti s CKD <strong>už užívajú lieky, ktoré riziko AKI zvyšujú</strong> — diuretiká a blokátory systému renín-angiotenzín-aldosterón. Kombinácia všetkých troch skupín je klasickou cestou k akútnemu zlyhaniu obličiek.</li>
  <li>K tomu sa pridáva riziko <strong>hyperkaliémie</strong> a zhoršenia kontroly krvného tlaku.</li>
</ul>

<p>Že nejde o teoretickú obavu, ilustrujú aj údaje z inej oblasti. V retrospektívnej kohorte pacientov po totálnej endoprotéze kolena (<em>Journal of Arthroplasty</em>, 2025) bolo pridanie ketorolaku do lokálnej infiltračnej analgézie <strong>u pacientov s CKD</strong> spojené s vyšším výskytom AKI — <strong>12,7 % oproti 2,0 %</strong> (p = 0,041, po párovaní podľa skóre náklonnosti; n = 114). U pacientov <em>bez</em> CKD rozdiel nebol (2,0 % oproti 1,9 %; n = 870). Jediná perioperačná dávka — a desaťnásobný rozdiel vo výskyte AKI, ale len v tej skupine, ktorá už mala zníženú rezervu.</p>

<h3>Praktický postoj</h3>

<p>Rozumný postoj nie je „zakázať“, ale „nikdy to nepovažovať za bezpečné“. Ak je NSAID naozaj nevyhnutné:</p>

<ul>
  <li><strong>čo najkratšie a v najnižšej účinnej dávke</strong>,</li>
  <li>s plánom kontroly kreatinínu, eGFR, kália a krvného tlaku,</li>
  <li>s výslovným poučením pacienta, <strong>kedy NSAID vysadiť</strong> — pri dehydratácii, vracaní, hnačke alebo horúčkovitom ochorení,</li>
  <li>a s vedomím, že kombinácia s diuretikom a blokádou RAAS je tá, ktorej sa treba vyhnúť predovšetkým.</li>
</ul>

<p>Pri pokročilej CKD a u dialyzovaných pacientov treba zvážiť aj to, čo sa pri rozhodovaní často prehliada: u pacienta so zachovanou reziduálnou funkciou obličiek je jej strata samostatná škoda, ktorá sa už nevráti. Riziko a prínos sa preto nerátajú rovnako u pacienta s eGFR 50 a u pacienta na peritoneálnej dialýze s reziduálnou diurézou. Dlhodobým renálnym dopadom bežne užívaných liekov vrátane NSAID sa venuje samostatný článok <a href="article.php?slug=ppi-h2-antihistaminika-nsaid-ckd-progresia">o PPI, H2-antihistaminikách a NSAID a progresii CKD</a>.</p>

<h2>Okruh 2: duloxetín a neuropatická bolesť</h2>

<p>Duloxetín (inhibítor spätného vychytávania serotonínu a noradrenalínu) je pri chronickej bolesti dolného chrbta aj pri diabetickej neuropatii rozumnou neopioidnou voľbou — <strong>ale má jasné renálne obmedzenie</strong>.</p>

<p>Podľa preskripčných informácií sa duloxetín <strong>neodporúča pri terminálnom zlyhaní obličiek a pri závažnom renálnom poškodení (odhadovaný klírens kreatinínu pod 30 ml/min)</strong>. Dôvod je farmakokinetický a presvedčivý: po jednorazovej dávke 60 mg boli u pacientov s terminálnym zlyhaním obličiek na chronickej intermitentnej hemodialýze hodnoty C<sub>max</sub> a AUC približne <strong>dvojnásobné</strong> oproti osobám s normálnou funkciou obličiek. Expozícia hlavných cirkulujúcich metabolitov (4-hydroxyduloxetín-glukuronid a 5-hydroxy-6-metoxyduloxetín-sulfát), ktoré sa vylučujú prevažne močom, bola <strong>približne 7- až 9-násobne vyššia</strong> — a pri opakovanom podávaní by sa ešte zvyšovala.</p>

<p>Naopak pri <strong>miernom až stredne ťažkom renálnom poškodení (klírens kreatinínu 30 až 80 ml/min)</strong> sa zdanlivý klírens duloxetínu významne nemení a úprava dávky nie je potrebná.</p>

<p>Prakticky: duloxetín je použiteľný pri CKD G3, ale <strong>pri CKD G4 a G5 a u dialyzovaných pacientov nie je vhodnou voľbou</strong>. Overte v aktuálnom SPC konkrétneho prípravku — formulácie sa medzi krajinami líšia.</p>

<h2>Okruh 3: gabapentinoidy a opioidy — lieky, ktoré sa pri CKD kumulujú</h2>

<h3>Gabapentinoidy</h3>

<p>Gabapentín a pregabalín sa vylučujú obličkami nezmenené, takže pri poklese eGFR rastie expozícia priamo úmerne. Dôsledkom je zvýšené riziko útlmu, zmätenosti, pádov a fraktúr — a pri kombinácii s opioidmi aj respiračnej depresie. Téme je venovaný samostatný článok <a href="article.php?slug=gabapentin-bezpecnost-ckd-hemodialyza-temna-strana">o bezpečnosti gabapentínu pri CKD a hemodialýze</a>; konkrétne dávkovacie schémy podľa klírensu kreatinínu rozoberá <a href="article.php?slug=polyneuropatia-ckd-diagnostika-liecba-bezpecne-davkovanie">článok o polyneuropatii pri CKD</a>.</p>

<h3>Opioidy</h3>

<p>Pri opioidoch nie je hlavným problémom samotná účinná látka, ale <strong>renálne eliminované aktívne metabolity</strong>. Preto nie sú opioidy pri CKD jedna skupina — sú to liečivá s veľmi odlišným správaním:</p>

<ul>
  <li><strong>Morfín</strong> má aktívne metabolity (morfín-6-glukuronid, morfín-3-glukuronid), ktoré sa vylučujú obličkami a pri CKD sa kumulujú. Prejavom nie je len hlbší útlm, ale aj myoklonus, hyperalgézia a delírium.</li>
  <li><strong>Kodeín</strong> je prekurzorom morfínu a zdieľa ten istý problém, pričom ho ešte komplikuje nepredvídateľná aktivácia cez CYP2D6.</li>
  <li><strong>Petidín</strong> (meperidín) má neurotoxický metabolit norpetidín, ktorý sa kumuluje a znižuje prah pre kŕče.</li>
</ul>

<p>Spoločný záver je ten, ktorý už poznáme z gabapentinoidov: <strong>začínať nízko, titrovať pomaly, sledovať útlm, zmätenosť a riziko pádu, a pri každej kontrole prehodnotiť, či liek ešte prináša úžitok.</strong> Konkrétnu voľbu a dávkovanie viažte na aktuálne SPC a na klinický stav, nie na zvyk.</p>

<p>Osobitne treba zdôrazniť kombináciu <strong>opioid plus gabapentinoid</strong>. Ide o najčastejšiu dvojicu pri neuropatickej bolesti a zároveň o kombináciu, pred ktorou FDA výslovne varuje pre riziko závažnej respiračnej depresie — najmä u starších pacientov a pri chronickej obštrukčnej chorobe pľúc.</p>

<h2>Čo pri CKD často chýba: nefarmakologická liečba</h2>

<p>Rámec CDC kladie nefarmakologickú liečbu na začiatok, nie na koniec po zlyhaní liekov. Pri CKD je to o to dôležitejšie, že lieková alternatíva je úzka. Prakticky dostupné sú:</p>

<ul>
  <li><strong>pohybová a cvičebná terapia</strong> — pri chronickej bolesti chrbta má najlepší dôkazový základ zo všetkých nefarmakologických postupov a u pacientov s CKD prináša navyše benefit vo svalovej sile a funkčnej kapacite,</li>
  <li><strong>psychologická intervencia</strong> vrátane postupov zameraných na zvládanie bolesti,</li>
  <li><strong>lokálna liečba</strong> — kapsaicín a lokálne anestetiká pri lokalizovanej neuropatickej bolesti; systémová expozícia je minimálna, čo je pri CKD podstatná výhoda,</li>
  <li><strong>manuálne a fyzikálne techniky</strong> podľa dostupnosti.</li>
</ul>

<p>Pri dialyzovaných pacientoch stojí za zváženie aj jednoduchá vec: významná časť bolesti súvisí s kŕčmi, s cievnym prístupom alebo s objemovým manažmentom — a tie sa neriešia analgetikom. Tému kŕčov rozoberá <a href="article.php?slug=krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza">samostatný článok</a>.</p>

<h2>Praktický postup v ambulancii</h2>

<ol>
  <li><strong>Určite typ bolesti.</strong> Nociceptívna, neuropatická alebo zmiešaná — liečba sa volí podľa dominantného mechanizmu, nie podľa toho, čo „naposledy zabralo“.</li>
  <li><strong>Zistite trvanie</strong> a odlíšte akútnu od chronickej bolesti (nad 3 mesiace); liečebná stratégia sa líši zásadne.</li>
  <li><strong>Spustite nefarmakologickú liečbu hneď</strong>, nie až po zlyhaní liekov.</li>
  <li><strong>Pred každým predpisom skontrolujte eGFR a celú medikáciu</strong> — konkrétne diuretikum, blokádu RAAS, inhibítor SGLT2 a všetky lieky tlmiace centrálny nervový systém.</li>
  <li><strong>Vyberte liek s ohľadom na renálnu funkciu:</strong>
    <ul>
      <li>NSAID — len krátkodobo, ak vôbec, s monitorovaním a s pravidlom chorého dňa,</li>
      <li>duloxetín — použiteľný pri miernom až stredne ťažkom poškodení, nie pri klírense pod 30 ml/min,</li>
      <li>gabapentinoidy — nízka štartovacia dávka, pomalá titrácia, sledovanie útlmu a pádov,</li>
      <li>opioidy — pozor na renálne eliminované aktívne metabolity; vyhýbať sa kumulácii.</li>
    </ul>
  </li>
  <li><strong>Prehodnoťte skoro a potom pravidelne.</strong> Hodnoťte nielen intenzitu bolesti, ale aj <strong>funkčný dopad</strong> a znášanlivosť. Liek, ktorý znížil bolesť o dva body, ale pacient po ňom spí celý deň a dvakrát spadol, nie je úspech.</li>
</ol>

<h2>Čo tento prehľad nehovorí</h2>

<ul>
  <li><strong>„Nepredpísať nič“ nie je bezpečná voľba.</strong> Neliečená chronická bolesť zhoršuje spánok, náladu, pohyblivosť aj adherenciu k ostatnej liečbe — a u krehkého pacienta vedie k nehybnosti, úbytku svaloviny a pádom.</li>
  <li><strong>Prahy pre NSAID pri CKD nie sú podložené randomizovanými dátami.</strong> Pochádzajú z pozorovacích údajov a odborného konsenzu; práve preto o nich existuje otvorená odborná debata.</li>
  <li><strong>Odporúčania CDC sú americké</strong> a vznikli v kontexte opioidnej krízy v Spojených štátoch. Ich logika — prednosť neopioidnej liečby, hodnotenie rizika, kontroly — je prenosná; konkrétne regulačné detaily nie.</li>
</ul>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Dowell D, Ragan KR, Jones CM, Baldwin GT, Chou R. <em>CDC Clinical Practice Guideline for Prescribing Opioids for Pain — United States, 2022.</em> MMWR Recomm Rep 2022;71(3):1–95. <a href="https://doi.org/10.15585/mmwr.rr7103a1" target="_blank" rel="noopener noreferrer">doi:10.15585/mmwr.rr7103a1</a> (PMID 36327391).</li>
  <li>Guthrie B. <em>Can NSAIDs Be Used Safely for Analgesia in Patients with CKD?: CON.</em> Kidney360 2020;1(11):1189–1191. <a href="https://doi.org/10.34067/KID.0005112020" target="_blank" rel="noopener noreferrer">doi:10.34067/KID.0005112020</a> (PMID 35372868).</li>
  <li>Baker ML, Perazella MA. <em>Can NSAIDs Be Used Safely for Analgesia in Patients with CKD?: COMMENTARY.</em> Kidney360 2020;1(11):1192–1194. <a href="https://doi.org/10.34067/KID.0004652020" target="_blank" rel="noopener noreferrer">doi:10.34067/KID.0004652020</a> (PMID 35372870).</li>
  <li>Chee BRK, Quah ESH, Zhao CXS, Tan KGP, Thwin L. <em>The Addition of a Nonsteroidal Anti-inflammatory Drug in Local Infiltration Analgesia During Total Knee Arthroplasty Increases the Risk of Acute Kidney Injury in Patients Who Have Renal Impairment.</em> J Arthroplasty 2025;40(4):916–922. <a href="https://doi.org/10.1016/j.arth.2024.10.020" target="_blank" rel="noopener noreferrer">doi:10.1016/j.arth.2024.10.020</a> (PMID 39447933).</li>
  <li>Preskripčné informácie duloxetínu (CYMBALTA), sekcie <em>Use in Specific Populations — Renal Impairment</em> a <em>Clinical Pharmacology</em>. <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=059d730b-4294-47e1-8399-4cb8c468cee8" target="_blank" rel="noopener noreferrer">DailyMed</a>.</li>
</ol>

<p><em>Bibliografické údaje prác 1 až 4 boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza platné súhrny charakteristických vlastností liečiv ani individuálne klinické rozhodnutie. Dávkovanie a renálne obmedzenia overte v aktuálnom SPC konkrétneho prípravku.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_chronicka-bolest-analgetika-bezpecnost-ckd_article',
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
