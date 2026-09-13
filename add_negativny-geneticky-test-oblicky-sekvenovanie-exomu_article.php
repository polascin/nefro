<?php
/**
 * Odborný komentár k ďalšiemu postupu po negatívnom alebo nejednoznačnom
 * paneli génov pre choroby obličiek.
 * Vecná a slovenská jazyková revízia: 13. september 2026.
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
    'title'        => 'Negatívny genetický test nevylučuje genetickú príčinu choroby obličiek',
    'slug'         => 'negativny-geneticky-test-oblicky-sekvenovanie-exomu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Sekvenovanie exómu odhalilo relevantný nález aj po nevýťažnom paneli génov. Ako správne čítať negatívny výsledok a kedy diagnostiku rozšíriť alebo prehodnotiť?',
    'content'      => <<<'HTML'
<p><strong>Výsledok „negatívny“ pri genetickom vyšetrení choroby obličiek spravidla znamená, že použitá metóda v analyzovanom rozsahu a pri aktuálnom stave poznania neodhalila príčinný variant. Neznamená automaticky, že ochorenie nemá genetický podklad.</strong> Retrospektívna štúdia z programu renálnej genetiky Cleveland Clinic ukázala, že sekvenovanie exómu po predchádzajúcom negatívnom alebo nejednoznačnom paneli prinieslo nový alebo preklasifikovaný patogénny nález u 7 z 54 vyšetrených pacientov, teda u 13 %. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>

<p>Toto číslo nie je univerzálnou pravdepodobnosťou úspechu a nemožno ho preniesť na každého pacienta. Šlo o retrospektívny súbor zo špecializovanej jednocentrovej ambulancie; pacienti odoslaní na vyšetrenie exómu boli klinicky selektovaní a podskupina po nevýťažnom paneli bola malá. Výsledok však názorne potvrdzuje dôležitý princíp: <strong>ak klinické podozrenie pretrváva, nevýťažný prvý test nemusí byť koncom diagnostiky</strong>.</p>

<div class="pdf-avoid-break">
<h2>Čo presne znamená negatívny výsledok</h2>

<p>Interpretácia závisí od otázky, ktorú mal test zodpovedať. Najčastejší „negatívny“ výsledok pri pacientovi bez známeho rodinného variantu znamená, že sa nenašiel variant klasifikovaný ako patogénny alebo pravdepodobne patogénny, ktorý by primerane vysvetľoval fenotyp. Zvyškové riziko genetickej príčiny závisí od predtestovej pravdepodobnosti, rozsahu testu, analytickej citlivosti, kvality fenotypových údajov a času, keď sa výsledok interpretoval. <a href="#zdroj-3">[3]</a> <a href="#zdroj-4">[4]</a></p>

<p>Odlišná je situácia, keď sa v rodine už pozná konkrétny kauzálny variant a príbuzný je naň cielene testovaný. Technicky spoľahlivý negatívny výsledok vtedy s vysokou mierou istoty vylučuje nosičstvo <em>tohto konkrétneho rodinného variantu</em>. Nevylučuje však inú genetickú príčinu ani fenokópiu, ak klinický obraz zostáva podozrivý. <a href="#zdroj-4">[4]</a></p>
</div>

<h2>Prečo môže genetická príčina zostať nezachytená</h2>

<ul>
  <li><strong>Príliš úzky rozsah:</strong> panel nemusel obsahovať gén, ktorý zodpovedá skutočnému alebo prekrývajúcemu sa fenotypu; nové vzťahy medzi génmi a chorobami navyše priebežne pribúdajú.</li>
  <li><strong>Technické slepé miesta:</strong> bežné panely a sekvenovanie exómu sú najlepšie pri malých zmenách v zachytených kódujúcich oblastiach. Podľa použitej technológie a bioinformatiky môžu uniknúť zmeny počtu kópií, väčšie štruktúrne prestavby, hlboké intrónové a regulačné varianty, niektoré mitochondriálne varianty alebo nízkoúrovňový mozaicizmus.</li>
  <li><strong>Ťažko analyzovateľné oblasti:</strong> príkladom je <em>PKD1</em> s vysokou sekvenčnou homológiou so pseudogénmi alebo VNTR oblasť génu <em>MUC1</em>. Pri fenotype autozómovo dominantnej tubulointersticiálnej choroby obličiek treba v správe výslovne overiť, či bola problematická oblasť <em>MUC1</em> analyzovaná vhodnou metódou. <a href="#zdroj-3">[3]</a> <a href="#zdroj-4">[4]</a></li>
  <li><strong>Obmedzenia interpretácie:</strong> variant mohol byť zachytený, ale v čase vyšetrenia nebol dostatok dôkazov na jeho spojenie s chorobou alebo na jeho patogénnu klasifikáciu.</li>
  <li><strong>Nesúlad fenotypu a zvoleného testu:</strong> neúplné údaje o rodine, veku začiatku, priebehu ochorenia či mimorenálnych prejavoch môžu viesť k výberu nevhodného panelu alebo k prehliadnutiu relevantného nálezu.</li>
</ul>

<p>Preto by laboratórna správa nemala obsahovať iba záver „negatívny“. Má uvádzať, ktoré gény a oblasti sa analyzovali, použitú technológiu, relevantné obmedzenia a informáciu, či bola vykonaná analýza zmien počtu kópií. Dôležitý je aj rok vyšetrenia: starší panel môže byť dnes neúplný a staršia interpretácia variantu už nemusí zodpovedať aktuálnym poznatkom. <a href="#zdroj-3">[3]</a></p>

<div class="pdf-avoid-break">
<h2>Negatívny výsledok nie je VUS</h2>

<p><strong>Variant neistého významu (VUS)</strong> nie je potvrdením diagnózy ani „takmer pozitívnym“ výsledkom. Bez ďalších dôkazov sa nemá používať na zásadné liečebné rozhodnutia, prediktívne testovanie zdravých príbuzných ani vyradenie potenciálneho darcu. Pomôcť môže podrobnejšie fenotypovanie, analýza segregácie v rodine, funkčné vyšetrenie alebo neskoršia reklasifikácia. <a href="#zdroj-3">[3]</a> <a href="#zdroj-4">[4]</a></p>

<p>Rovnako ani samotná prítomnosť patogénneho alebo pravdepodobne patogénneho variantu ešte nedokazuje, že práve on vysvetľuje pacientovu nefropatiu. Nález musí zodpovedať mechanizmu dedičnosti, fenotypu a klinickému kontextu. <a href="#zdroj-3">[3]</a></p>
</div>

<h2>Čo priniesla nová štúdia</h2>

<p>Autori spätne vyhodnotili pacientov vyšetrených v Cleveland Clinic Renal Genetics Clinic od januára 2019 do júna 2024. Genetické vyšetrenie absolvovalo 584 pacientov, z nich 110 bolo pediatrických. Panel génov pre choroby obličiek malo 457 pacientov a sekvenovanie exómu 98 pacientov; 54 z nich podstúpilo vyšetrenie exómu po negatívnom alebo nejednoznačnom paneli. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>

<p>Diagnostická výťažnosť bola 33 % pri paneloch a 31 % pri exóme. <strong>Tieto dve percentá nemožno interpretovať ako priame porovnanie metód</strong>, pretože išlo o rozdielne skupiny pacientov, nie o randomizované ani párové porovnanie. Klinicky podstatný je druhostupňový výsledok: po nevýťažnom paneli sa v 7 z 54 prípadov našiel nový alebo preklasifikovaný patogénny nález. Medzi možné dôvody dodatočného záchytu patrilo širšie spektrum analyzovaných génov; štúdia upozornila aj na mitochondriálne nálezy pri glomerulových fenotypoch, ktoré niektoré renálne panely nemusia pokrývať. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>

<p>Percentuálne výťažnosti jednotlivých fenotypových podskupín boli založené na malých počtoch a treba ich považovať za exploratórne. Štúdia preto nepodporuje automatické sekvenovanie exómu po každom negatívnom paneli; podporuje <strong>cielené prehodnotenie u pacientov s pretrvávajúcim klinickým podozrením</strong>.</p>

<h2>Panel, exóm alebo genóm?</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie genetických vyšetrení pri chorobách obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Prístup</th>
      <th scope="col">Hlavná výhoda</th>
      <th scope="col">Dôležité obmedzenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Cielený test známeho rodinného variantu</th>
      <td>Veľmi presná odpoveď na konkrétnu rodinnú otázku</td>
      <td>Nehľadá inú príčinu ochorenia</td>
    </tr>
    <tr>
      <th scope="row">Panel génov</th>
      <td>Hĺbková analýza klinicky relevantného súboru génov, menej vedľajších nálezov</td>
      <td>Výťažnosť závisí od zloženia panelu a schopnosti zachytiť špecifické typy variantov</td>
    </tr>
    <tr>
      <th scope="row">Sekvenovanie exómu</th>
      <td>Širší záber kódujúcich oblastí a možnosť neskoršej reanalýzy</td>
      <td>Nepokrýva spoľahlivo všetky nekódujúce, repetitívne ani štruktúrne zmeny; interpretácia býva fenotypovo usmernená</td>
    </tr>
    <tr>
      <th scope="row">Sekvenovanie genómu</th>
      <td>Najširší záber vrátane nekódujúcich oblastí a lepší potenciál pre časť štruktúrnych variantov</td>
      <td>Nie je univerzálne dostupné, všetky typy variantov nezachytí rovnako a prináša väčšiu interpretačnú záťaž</td>
    </tr>
  </tbody>
</table>
</div>

<p>„Širší“ test teda nie je automaticky „lepší“ pre každú situáciu. Rozhoduje konkrétny fenotyp, rodinná anamnéza, predchádzajúca metóda a otázka, ktorú potrebujeme vyriešiť. Niekedy je správnym ďalším krokom rozšírenie na exóm alebo genóm, inokedy cielená analýza CNV, mitochondriálnej DNA, <em>MUC1</em> alebo inej ťažko vyšetriteľnej oblasti. <a href="#zdroj-3">[3]</a> <a href="#zdroj-4">[4]</a></p>

<h2>Kedy má zmysel diagnostiku znovu otvoriť</h2>

<p>Opätovné posúdenie je osobitne dôležité pri skorom začiatku CKD alebo zlyhania obličiek, pozitívnej či nejasnej rodinnej anamnéze, nevysvetlenej CKD, vrodených alebo cystických anomáliách a pri mimorenálnych prejavoch – napríklad poruche sluchu alebo zraku, neurologických, skeletálnych, metabolických či pečeňových znakoch. Negatívna rodinná anamnéza genetické ochorenie nevylučuje; príčinou môže byť variant vzniknutý <em>de novo</em>, recesívna alebo X-viazaná dedičnosť, variabilná penetrancia, malá rodina či neúplné informácie. <a href="#zdroj-3">[3]</a> <a href="#zdroj-5">[5]</a></p>

<ol>
  <li><strong>Vrátiť sa k fenotypu a rodokmeňu:</strong> doplniť vek začiatku, histológiu, zobrazovanie, priebeh, mimorenálne prejavy a údaje aspoň o blízkych príbuzných.</li>
  <li><strong>Prečítať celú laboratórnu správu:</strong> overiť zoznam génov, pokrytie, analyzované typy variantov, CNV, mitochondriálnu DNA a technické výluky.</li>
  <li><strong>Zistiť, či možno reanalyzovať pôvodné dáta:</strong> ak bol panel vyhodnotený z exómových alebo genómových sekvenačných dát, nemusí byť vždy potrebný nový odber a nové sekvenovanie; závisí to od laboratória a pôvodnej kvality dát.</li>
  <li><strong>Zvoliť cielené doplnenie alebo širšiu metódu:</strong> podľa predpokladanej medzery môže ísť o doplnenie špecifickej analýzy, širší panel, exóm, genóm alebo vyšetrenie iného tkaniva.</li>
  <li><strong>Zabezpečiť odbornú interpretáciu:</strong> zložité negatívne výsledky a VUS patria do spolupráce nefrológa, klinického genetika, laboratórneho genetika a genetického poradcu.</li>
  <li><strong>Naplánovať periodické prehodnotenie:</strong> potreba a načasovanie závisia od sily klinického podozrenia, veku a vývoja fenotypu, roku vyšetrenia a možnosti laboratória reanalyzovať dáta. Jednotný interval vhodný pre všetkých pacientov nie je stanovený. <a href="#zdroj-3">[3]</a> <a href="#zdroj-5">[5]</a></li>
</ol>

<div class="pdf-avoid-break">
<h2>Transplantácia a rodinné dôsledky</h2>

<p>Pri hodnotení biologicky príbuzného živého darcu je presná molekulová diagnóza mimoriadne dôležitá. Všeobecne negatívny panel u príjemcu alebo darcu nemusí stačiť na bezpečné vylúčenie rodinného rizika, ak kauzálny variant nepoznáme a klinické podozrenie zostáva vysoké. Posúdenie musí spájať rodokmeň, fenotyp, vek darcu, funkciu obličiek a limity použitého testu. VUS sám osebe nemá byť dôvodom na automatické prijatie ani vyradenie darcu. <a href="#zdroj-4">[4]</a> <a href="#zdroj-5">[5]</a></p>

<p>Výsledok môže mať dôsledky aj pre príbuzných, reprodukčné rozhodovanie a cielené sledovanie mimorenálnych prejavov. Preto má byť genetické vyšetrenie sprevádzané primeraným poučením pred testom aj po ňom, vrátane diskusie o možných sekundárnych nálezoch pri širších metódach.</p>
</div>

<h2>Praktický záver</h2>

<p>Po negatívnom genetickom teste si netreba položiť iba otázku „je ochorenie genetické?“, ale najmä <strong>„čo presne tento test dokázal vyšetriť a čo zostalo mimo jeho dosahu?“</strong> Ak je fenotyp presvedčivý, ďalší krok môže priniesť reanalýza, rozšírenie na exóm alebo genóm, cielené doplnenie technicky problematickej oblasti či nové klinické fenotypovanie.</p>

<p>Nová štúdia poskytuje užitočný signál, nie automatický algoritmus. Rozumným cieľom nie je maximalizovať počet genetických testov, ale vybrať správny test pre správneho pacienta, správne interpretovať jeho hranice a k nevýťažnému výsledku sa v odôvodnených prípadoch vrátiť.</p>

<hr>

<h2>Zdroje</h2>
<ol>
  <li id="zdroj-1">Bindhu S, Lim E, Borden C, et al. Diagnostic Yield of Exome Sequencing after Negative or Inconclusive Kidney Genes Panel Testing. <em>Clin J Am Soc Nephrol.</em> 2026;21(6):1048–1050. <a href="https://doi.org/10.2215/CJN.0000001042" target="_blank" rel="noopener noreferrer">doi:10.2215/CJN.0000001042</a>.</li>
  <li id="zdroj-2">Cleveland Clinic Consult QD. Negative or Inconclusive Kidney Gene Panel? When To Consider Exome Sequencing. 4. september 2026. <a href="https://consultqd.clevelandclinic.org/negative-or-inconclusive-kidney-gene-panel-when-to-consider-exome-sequencing" target="_blank" rel="noopener noreferrer">consultqd.clevelandclinic.org</a>.</li>
  <li id="zdroj-3">Halbritter J, Figueres L, Van Eerde AM, et al.; Genes &amp; Kidney Working Group of the ERA. Chronic Kidney Disease of unexplained cause (CKDx): a consensus statement. <em>Nephrol Dial Transplant.</em> 2025;40(12):2390–2400. <a href="https://doi.org/10.1093/ndt/gfaf092" target="_blank" rel="noopener noreferrer">doi:10.1093/ndt/gfaf092</a>.</li>
  <li id="zdroj-4">de Haan A, Eijgelsheim M, Vogt L, Knoers NVAM, de Borst MH. Genetic testing in the diagnosis of chronic kidney disease: recommendations for clinical practice. <em>Nephrol Dial Transplant.</em> 2022;37(2):239–254. <a href="https://doi.org/10.1093/ndt/gfab218" target="_blank" rel="noopener noreferrer">doi:10.1093/ndt/gfab218</a>.</li>
  <li id="zdroj-5">KDIGO Conference Participants. Genetics in chronic kidney disease: conclusions from a KDIGO Controversies Conference. <em>Kidney Int.</em> 2022;101(6):1126–1141. <a href="https://doi.org/10.1016/j.kint.2022.03.019" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2022.03.019</a>.</li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_negativny-geneticky-test-oblicky-sekvenovanie-exomu_article',
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
