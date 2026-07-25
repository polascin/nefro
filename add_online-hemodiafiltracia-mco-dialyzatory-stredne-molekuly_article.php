<?php
/**
 * add_online-hemodiafiltracia-mco-dialyzatory-stredne-molekuly_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): Online hemodiafiltrácia (OL-HDF) a MCO
 * dialyzátory v liečbe zlyhania obličiek — odstraňovanie stredných molekúl,
 * dôkazy o prežívaní (CONVINCE, ESHOL), praktický výber modality. Slovenské
 * odborné spracovanie. Hlavný zdroj: Bergling & Blankestijn, AJKD (2026).
 * Pôvodní autori v source_authors.php.
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
    'title'        => 'Za hranicami difúzie: online hemodiafiltrácia a MCO dialyzátory v liečbe zlyhania obličiek',
    'slug'         => 'online-hemodiafiltracia-mco-dialyzatory-stredne-molekuly',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vysokodávková online hemodiafiltrácia má randomizovaný dôkaz o znížení mortality (štúdia CONVINCE); MCO dialyzátory zatiaľ preukázali len lepší klírens stredných molekúl. Prečo lepší laboratórny výsledok neznamená rovnaký klinický prínos a ako vybrať modalitu.',
    'content'      => <<<'HTML'
<p>Konvenčná hemodialýza účinne odstraňuje malé vo vode rozpustné látky, napríklad močovinu, draslík a kreatinín. Podstatne menej účinná je pri odstraňovaní väčších uremických toxínov označovaných ako stredné molekuly. Online hemodiafiltrácia a dialýza s medium cut-off membránami rozširujú možnosti mimotelovej eliminačnej liečby práve zvýšením transportu týchto látok.</p>

<p>Obe metódy však využívajú odlišné mechanizmy a nemožno ich považovať za klinicky rovnocenné. Kým pri vysokodávkovej online hemodiafiltrácii už existuje randomizovaný dôkaz o znížení celkovej mortality, pri MCO dialyzátoroch sú zatiaľ preukázané najmä priaznivé účinky na laboratórne ukazovatele odstránenia stredných molekúl. Dôkazy o zlepšení prežívania alebo o znížení počtu závažných klinických príhod pri MCO dialyzátoroch chýbajú.</p>

<h2>Prečo samotná difúzia nestačí</h2>

<p>Transport látok počas klasickej hemodialýzy je založený prevažne na difúzii. Jej účinnosť je vysoká pri malých molekulách, ale klesá so zväčšujúcou sa molekulovou hmotnosťou, väzbou na bielkoviny a distribučným objemom látky.</p>

<p>Medzi klinicky skúmané stredné molekuly patria napríklad:</p>

<ul>
  <li>β2-mikroglobulín,</li>
  <li>myoglobín,</li>
  <li>prolaktín,</li>
  <li>fibroblastový rastový faktor 23,</li>
  <li>voľné ľahké reťazce imunoglobulínov,</li>
  <li>niektoré cytokíny a mediátory zápalu.</li>
</ul>

<p>Ich koncentrácia pri zlyhaní obličiek stúpa, ale samotné účinnejšie odstránenie konkrétnej molekuly ešte automaticky neznamená zlepšenie prognózy. Mnohé z týchto látok sú biomarkermi alebo možnými mediátormi ochorenia, pričom ich priamy kauzálny význam nie je pri všetkých jednoznačne dokázaný.</p>

<h2>Online hemodiafiltrácia</h2>

<p>Online hemodiafiltrácia, OL-HDF, kombinuje difúzny transport hemodialýzy s konvekčným transportom hemofiltrácie. Veľký objem plazmatickej vody sa filtruje cez vysokopriepustnú membránu a nahrádza sterilným, apyrogénnym substitučným roztokom pripravovaným online z dialyzačnej vody.</p>

<p>V súčasnosti sa najčastejšie používa postdilučná OL-HDF. Substitučný roztok sa podáva za dialyzátorom, čo umožňuje vysokú účinnosť konvekčného transportu. Limitujúcim faktorom je hemokoncentrácia vo vnútri dialyzátora, nárast transmembránového tlaku a riziko zrážania krvi.</p>

<h3>Význam konvekčného objemu</h3>

<p>Klinický prínos OL-HDF sa spája najmä s dosiahnutím vysokého konvekčného objemu. V randomizovaných štúdiách sa ako praktický cieľ často používal objem najmenej 23 litrov počas jednej štandardnej dialyzačnej procedúry.</p>

<p>Túto hodnotu nemožno interpretovať ako presnú biologickú hranicu. Ide skôr o praktický cieľ odvodený z dávok dosiahnutých v klinických štúdiách. Výsledný objem ovplyvňujú:</p>

<ul>
  <li>prietok krvi,</li>
  <li>čas liečby,</li>
  <li>filtračná frakcia,</li>
  <li>hematokrit a koncentrácia plazmatických bielkovín,</li>
  <li>kvalita cievneho prístupu,</li>
  <li>plocha a vlastnosti dialyzátora,</li>
  <li>tolerancia ultrafiltrácie a hemodynamická stabilita.</li>
</ul>

<p>Pri postdilučnej OL-HDF je na dosiahnutie približne 23 litrov konvekcie spravidla výhodný prietok krvi nad 350 ml/min. Predĺženie liečby o 30 minút môže zvýšiť konvekčný objem približne o 2 až 3 litre, výsledok však závisí od ostatných parametrov.</p>

<p>Moderné dialyzačné prístroje dokážu priebežne upravovať filtračnú frakciu a transmembránový tlak. Ani automatické riadenie však nenahrádza kontrolu cievneho prístupu, zrážania v okruhu a skutočne dosiahnutého konvekčného objemu.</p>

<h2>Dôkazy o prežívaní</h2>

<p>Najvýznamnejším novším dôkazom je randomizovaná štúdia CONVINCE, ktorá porovnávala vysokodávkovú OL-HDF s konvenčnou vysokoprietokovou hemodialýzou. Do štúdie bolo zaradených 1 360 pacientov.</p>

<p>Počas mediánu sledovania približne 30 mesiacov zomrelo:</p>

<ul>
  <li>17,3 % pacientov liečených OL-HDF,</li>
  <li>21,9 % pacientov liečených vysokoprietokovou hemodialýzou.</li>
</ul>

<p>Pomer rizík úmrtia bol 0,77, čo zodpovedá relatívnemu zníženiu rizika o 23 %. Absolútny rozdiel mortality predstavoval približne 4,6 percentuálneho bodu.</p>

<p>Výsledok podporuje používanie vysokodávkovej OL-HDF u vhodne vybraných pacientov. Neznamená však, že prechod každého pacienta na OL-HDF automaticky zníži jeho individuálne riziko úmrtia o 23 %. Absolútny prínos závisí od východiskového rizika, dĺžky liečby, dosiahnutej dávky, komorbidít a konkurenčných príčin mortality.</p>

<h3>Kritické obmedzenia dôkazov</h3>

<p>Štúdia bola otvorená a zahŕňala pacientov schopných dosahovať vysoké konvekčné objemy. Táto podmienka môže zvýhodňovať pacientov s kvalitnejším cievnym prístupom, lepším nutričným stavom a menším zápalovým zaťažením.</p>

<p>Pozorovacie analýzy síce nachádzajú väčší prínos pri vyššom konvekčnom objeme, ale vzťah medzi dávkou a prežívaním nemusí byť výlučne kauzálny. Pacient, u ktorého možno dosiahnuť vysoký prietok krvi a veľký konvekčný objem, býva často celkovo v lepšom klinickom stave.</p>

<p>Predchádzajúca štúdia ESHOL tiež preukázala nižšiu mortalitu pri vysokovýkonnej postdilučnej OL-HDF. Staršie metaanalýzy však poskytovali menej presvedčivé výsledky, čiastočne pre rozdielne technické parametre, nedostatočné konvekčné objemy a heterogenitu porovnávacích dialyzačných režimov.</p>

<p>Najlepšie podloženým tvrdením preto je, že <strong>vysokodávková postdilučná OL-HDF môže u vhodných pacientov znížiť celkovú mortalitu v porovnaní s vysokoprietokovou hemodialýzou</strong>. Nie je dostatočne dokázané, že rovnaký účinok prináša nízkoobjemová HDF alebo akákoľvek procedúra označená ako hemodiafiltrácia.</p>

<h2>MCO dialyzátory a rozšírená hemodialýza</h2>

<p>Medium cut-off dialyzátory majú membránu s väčšími a presnejšie definovanými pórmi než štandardné vysokoprietokové dialyzátory. Umožňujú účinnejšie odstránenie väčších stredných molekúl bez potreby samostatnej online substitučnej tekutiny.</p>

<p>Liečba sa niekedy označuje ako rozšírená hemodialýza alebo HDx. Konvekčný transport vzniká vnútornou filtráciou a spätnou filtráciou v dialyzátore. Jeho veľkosť však nemožno počas bežnej procedúry priamo predpísať ani presne merať tak, ako pri OL-HDF.</p>

<p>Randomizované štúdie ukázali účinnejšie odstránenie niektorých stredných molekúl, najmä voľných ľahkých reťazcov. Zatiaľ však nepreukázali:</p>

<ul>
  <li>zníženie celkovej mortality,</li>
  <li>zníženie kardiovaskulárnej mortality,</li>
  <li>nižšiu mieru hospitalizácií,</li>
  <li>spoľahlivé zlepšenie funkčného stavu,</li>
  <li>klinicky významné zlepšenie kvality života.</li>
</ul>

<p>MCO dialyzátory preto predstavujú technicky zaujímavú alternatívu, najmä tam, kde OL-HDF nie je dostupná alebo nie je možné dosiahnuť dostatočný konvekčný objem. Nemožno ich však označovať za klinicky rovnocennú náhradu vysokodávkovej OL-HDF.</p>

<h2>Albumín a bezpečnosť</h2>

<p>Rozšírenie priepustnosti membrány prináša riziko straty albumínu. Moderné MCO dialyzátory majú hranicu priepustnosti nastavenú tak, aby sa zlepšilo odstránenie väčších stredných molekúl bez masívnej straty albumínu do dialyzátu. Menší pokles sérového albumínu sa však v niektorých štúdiách pozoroval.</p>

<p>Pri dlhodobom používaní je vhodné sledovať:</p>

<ul>
  <li>sérový albumín,</li>
  <li>vývoj telesnej hmotnosti a svalovej hmoty,</li>
  <li>príjem bielkovín,</li>
  <li>známky chronického zápalu,</li>
  <li>opakované straty krvi,</li>
  <li>reziduálnu funkciu obličiek,</li>
  <li>prípadné straty liekov alebo biologicky aktívnych látok.</li>
</ul>

<p>Pokles albumínu nemožno automaticky pripísať membráne. Diferenciálne diagnosticky treba zohľadniť zápal, malnutríciu, hepatopatiu, proteinúriu, straty do gastrointestinálneho traktu a objemové zmeny.</p>

<h2>Kt/V zostáva užitočný, ale nestačí</h2>

<p>Jednopoolový Kt/V je ukazovateľom odstránenia močoviny, nie komplexným meradlom kvality dialyzačnej liečby. Nehodnotí dostatočne:</p>

<ul>
  <li>odstraňovanie stredných molekúl,</li>
  <li>objemový stav,</li>
  <li>kontrolu sodíka a fosfátov,</li>
  <li>hemodynamickú toleranciu,</li>
  <li>zachovanie reziduálnej diurézy,</li>
  <li>kvalitu cievneho prístupu,</li>
  <li>nutričný a funkčný stav,</li>
  <li>symptómy a kvalitu života.</li>
</ul>

<p>Pri OL-HDF sa má preto popri Kt/V zaznamenávať dosiahnutý konvekčný objem, čas liečby, efektívny prietok krvi, filtračná frakcia a priebeh transmembránového tlaku. Pri MCO dialýze zatiaľ neexistuje všeobecne prijatý klinický ukazovateľ, ktorý by spoľahlivo vyjadroval jej „dávku“.</p>

<h2>Praktický výber liečebnej modality</h2>

<h3>OL-HDF možno uprednostniť, ak:</h3>

<ul>
  <li>je dostupná technológia s mikrobiologicky bezpečnou ultračistou (ultrapure) vodou,</li>
  <li>pacient má cievny prístup umožňujúci dostatočný prietok krvi,</li>
  <li>možno pravidelne dosahovať vysoký konvekčný objem,</li>
  <li>pacient toleruje štandardnú alebo predĺženú dĺžku liečby,</li>
  <li>pracovisko dokáže systematicky kontrolovať kvalitu vody a technické parametre.</li>
</ul>

<h3>MCO dialyzátor možno zvážiť, ak:</h3>

<ul>
  <li>OL-HDF nie je dostupná,</li>
  <li>cievny prístup neumožňuje vysoké prietoky,</li>
  <li>pacient je dialyzovaný centrálnym venóznym katétrom,</li>
  <li>vysoký konvekčný objem nemožno spoľahlivo dosiahnuť,</li>
  <li>cieľom je zvýšiť odstraňovanie stredných molekúl bez zmeny dialyzačného prístroja.</li>
</ul>

<p>Pri oboch modalitách zostáva rozhodujúca individualizácia liečby. Zvýšenie konvekcie nenahrádza správne stanovenie suchej hmotnosti, kontrolu krvného tlaku, liečbu anémie a minerálovej a kostnej poruchy, prevenciu infekcií ani starostlivosť o cievny prístup.</p>

<h2>Otvorené otázky</h2>

<p>Nie je definitívne vyriešené, ktoré konkrétne odstránené molekuly sprostredkúvajú klinický prínos OL-HDF. Nie je jasné ani to, či je rozhodujúci samotný konvekčný transport, lepšia biokompatibilita, nižšie zápalové zaťaženie, stabilnejší priebeh procedúry alebo kombinácia viacerých faktorov.</p>

<p>Ďalší výskum má určiť:</p>

<ul>
  <li>optimálnu dávku konvekcie podľa telesného povrchu,</li>
  <li>prínos u starších a polymorbídnych pacientov,</li>
  <li>účinnosť pri katétrovom cievnom prístupe,</li>
  <li>vplyv na hospitalizácie a funkčný stav,</li>
  <li>dlhodobé klinické výsledky MCO dialyzátorov,</li>
  <li>nákladovú efektívnosť a environmentálnu záťaž jednotlivých modalít.</li>
</ul>

<h2>Záver</h2>

<p>Vysokodávková online hemodiafiltrácia je v súčasnosti najlepšie klinicky podloženou metódou rozšírenia konvenčnej hemodialýzy o konvekčný transport. Randomizované údaje podporujú zníženie celkovej mortality pri dosahovaní konvekčného objemu približne 23 litrov alebo viac počas jednej procedúry.</p>

<p>MCO dialyzátory účinnejšie odstraňujú niektoré väčšie stredné molekuly a technicky zjednodušujú rozšírenú dialýzu. Doteraz však nemajú porovnateľné dôkazy o zlepšení prežívania. Laboratórne lepší klírens preto nemožno zamieňať za preukázaný klinický prínos.</p>

<p>Pri výbere modality treba zohľadniť cievny prístup, reálne dosiahnuteľný prietok krvi, dĺžku procedúry, nutričný a zápalový stav, hemodynamickú toleranciu, technické možnosti pracoviska a preferencie pacienta.</p>

<h2>Zdroje</h2>

<ol>
  <li>Bergling K, Blankestijn PJ. <em>Beyond Diffusion: Clinical Perspectives on Online Hemodiafiltration and Medium Cut-Off Dialyzers.</em> American Journal of Kidney Diseases. Publikované online 27. marca 2026. DOI: 10.1053/j.ajkd.2025.11.018. <a href="https://www.ajkd.org/article/S0272-6386(26)00824-3/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></li>
  <li>Blankestijn PJ, Fischer KI, Barth C, Cromm K, Canaud B, Davenport A, a kol. (CONVINCE Scientific Committee). <em>Effect of Hemodiafiltration or Hemodialysis on Mortality in Kidney Failure.</em> New England Journal of Medicine (2023); 389: 700–709. DOI: 10.1056/NEJMoa2304820. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2304820" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
  <li>Maduell F, Moreso F, Pons M, Ramos R, Mora-Macià J, Carreras J, a kol. (ESHOL Study Group). <em>High-Efficiency Postdilution Online Hemodiafiltration Reduces All-Cause Mortality in Hemodialysis Patients.</em> Journal of the American Society of Nephrology (2013); 24(3): 487–497. DOI: 10.1681/ASN.2012080875. <a href="https://jasn.asnjournals.org/content/24/3/487" target="_blank" rel="noopener noreferrer">jasn.asnjournals.org</a></li>
  <li>Nistor I, Palmer SC, Craig JC, Saglimbene V, Vecchio M, Covic A, Strippoli GFM. <em>Haemodiafiltration, Haemofiltration and Haemodialysis for End-Stage Kidney Disease.</em> Cochrane Database of Systematic Reviews (2015); (5): CD006258. DOI: 10.1002/14651858.CD006258.pub2. <a href="https://www.cochranelibrary.com/cdsr/doi/10.1002/14651858.CD006258.pub2/full" target="_blank" rel="noopener noreferrer">cochranelibrary.com</a></li>
  <li>Weiner DE, Falzon L, Skoufos L, Bernardo A, Beck W, Xiao M, Tran H. <em>Efficacy and Safety of Expanded Hemodialysis with the Theranova 400 Dialyzer: A Randomized Controlled Trial.</em> Clinical Journal of the American Society of Nephrology (2020); 15(9): 1310–1319. DOI: 10.2215/CJN.01210120. <a href="https://journals.lww.com/cjasn/fulltext/2020/09000/efficacy_and_safety_of_expanded_hemodialysis_with.14.aspx" target="_blank" rel="noopener noreferrer">journals.lww.com</a></li>
</ol>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
