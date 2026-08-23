<?php
/**
 * Odborne a jazykovo revidovaný článok o odporúčaniach Talianskej nefrologickej
 * spoločnosti k online hemodiafiltrácii. Pôvodní autori spracovaného dokumentu
 * sú uvedení v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Online hemodiafiltrácia ako dávkovaná liečba: odporúčania Talianskej nefrologickej spoločnosti',
    'slug'         => 'online-hemodiafiltracia-davkovana-liecba-odporucania-sin',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prínos online hemodiafiltrácie nie je vlastnosťou metódy, ale dosiahnutého konvektívneho objemu. Nové odporúčania to formulujú priamo a spresňujú, čo musí pracovisko splniť, aby dávka zo štúdií vôbec vznikla.',
    'content'      => <<<'HTML'
<p>Online hemodiafiltrácia (OL-HDF) sa v európskych dialyzačných strediskách používa už dve desaťročia, no otázka, či pacientovi skutočne predĺži život, mala dlho rozporuplné odpovede. Rozuzlenie neprišlo z porovnania metód, ale z pochopenia, že ide o <strong>dávkovanú liečbu</strong>: rozhoduje objem konvekcie, ktorý sa počas sedenia naozaj dosiahne.</p>

<p>Odporúčania, ktoré v auguste 2026 zverejnil medzinárodný multidisciplinárny panel zvolaný Talianskou nefrologickou spoločnosťou, túto tézu formulujú priamo a prekladajú ju do prevádzkových požiadaviek. Pre nefrológa je to užitočnejší dokument než ďalšie porovnanie modalít – hovorí totiž o tom, čo musí pracovisko urobiť, aby prínos vôbec vznikol.</p>

<h2>Čo odporúčania hovoria</h2>

<p>Panel syntetizoval randomizované dôkazy porovnávajúce online <strong>postdilučnú</strong> HDF s high-flux hemodialýzou u dospelých na udržiavacej liečbe a istotu dôkazov hodnotil metodikou GRADE. Výsledné stanoviská sú tri:</p>

<ul>
  <li><strong>Odporúčanie:</strong> používať online postdilučnú HDF na zníženie kardiovaskulárnej úmrtnosti.</li>
  <li><strong>Návrh:</strong> používať vysokoobjemovú HDF na zníženie celkovej úmrtnosti a na spomalenie zhoršovania vo vybraných pacientom hlásených doménach.</li>
  <li><strong>Konštatovanie:</strong> bezpečnosť online postdilučnej HDF je porovnateľná s high-flux hemodialýzou.</li>
</ul>

<p>Zastrešujúca veta dokumentu znie, že OL-HDF sa má chápať ako <em>dose-dependent</em> liečba. Účinná implementácia si vyžaduje cielený a individualizovaný prístup s optimalizáciou a monitorovaním konvektívneho objemu, primeraný čas liečby, prietok krvi, zodpovedajúcu infraštruktúru a zohľadnenie preferencií pacienta.</p>

<h2>Čísla, o ktoré sa odporúčania opierajú</h2>

<div class="table-responsive" role="region" aria-label="Kľúčové randomizované dôkazy o online hemodiafiltrácii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Zdroj dôkazu</th>
      <th scope="col">Rozsah</th>
      <th scope="col">Celková úmrtnosť</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">ESHOL (2013)</th>
      <td>906 pacientov, vysokoúčinná postdilučná OL-HDF</td>
      <td>HR 0,70 (95 % IS 0,53–0,92; p = 0,01)</td>
      <td>Kardiovaskulárna úmrtnosť HR 0,67 (0,44–1,02; p = 0,06) – <strong>nedosiahla významnosť</strong>. Úmrtnosť na infekcie HR 0,45 (0,21–0,96). Menej hypotenzných sedení a hospitalizácií.</td>
    </tr>
    <tr>
      <th scope="row">CONVINCE (2023)</th>
      <td>1 360 pacientov, cieľ ≥ 23 l konvekcie na sedenie</td>
      <td>HR 0,77 (95 % IS 0,65–0,93)</td>
      <td>Úmrtnosť 17,3 % oproti 21,9 % pri mediáne sledovania 30 mesiacov. Priemerný dosiahnutý konvektívny objem 25,3 l na sedenie.</td>
    </tr>
    <tr>
      <th scope="row">Metaanalýza individuálnych údajov (2024)</th>
      <td>5 štúdií, 4 153 pacientov</td>
      <td>HR 0,84 (95 % IS 0,74–0,95)</td>
      <td>Úmrtnosť 23,3 % oproti 27,0 %. <strong>Stupňovitý vzťah medzi konvektívnym objemom a rizikom úmrtia</strong>; bez rozdielu účinku medzi podskupinami.</td>
    </tr>
    <tr>
      <th scope="row">Odporúčania (2026)</th>
      <td>Syntéza podľa GRADE</td>
      <td>HR 0,84 (0,74–0,95), stredná istota</td>
      <td>Kardiovaskulárna úmrtnosť HR 0,78 (0,64–0,96), stredná istota. Pacientom hlásené domény: nízka istota.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiel medzi číslom 0,70 z jednej štúdie a 0,84 zo súhrnu individuálnych údajov nie je rozporom. Je to očakávaný posun pri prechode od jedného vysoko selektovaného súboru k spoločnej analýze piatich štúdií a práve preto sa odporúčania opierajú o konzervatívnejší odhad.</p>

<h2>Prečo „dávka“ a nie „metóda“</h2>

<p>Kľúčovým zistením metaanalýzy individuálnych údajov nie je samotný pomer rizík, ale <strong>tvar vzťahu</strong>: s rastúcim konvektívnym objemom riziko úmrtia klesá plynulo. Zároveň sa nenašiel rozdiel účinku podľa veku, pohlavia, diabetu, trvania dialýzy ani ďalších vopred určených charakteristík.</p>

<p>To má dva praktické dôsledky. Prvý: prepnutie prístroja do režimu HDF bez dosiahnutia potrebného objemu neprinesie očakávaný prínos, hoci v dokumentácii bude modalita zapísaná ako hemodiafiltrácia. Druhý: neexistuje podskupina, ktorú by bolo možné vopred vylúčiť ako „nevhodnú“ – rozhodujúce je, či sa u konkrétneho pacienta dá dávka technicky dodať.</p>

<h2>Čo obmedzuje dosiahnutý konvektívny objem</h2>

<p>Pri postdilučnom režime sa substitučný roztok pridáva až za dialyzátorom, takže krv sa v kapilárach zahusťuje. Dosiahnuteľný objem preto limituje <strong>filtračná frakcia</strong>: pri jej prekročení stúpa hematokrit a onkotický tlak vo vláknach, rastie riziko zrážania, klesá účinnosť a zvyšujú sa straty albumínu. Prakticky to znamená, že konvektívny objem nemožno zvyšovať samostatne – vyplýva zo súčinu prietoku krvi a času.</p>

<ol>
  <li><strong>Prietok krvi.</strong> Pri bežných parametroch sa cieľ 23 litrov na sedenie nedosiahne pri nízkom prietoku. Prietok krvi zase určuje kvalita cievneho prístupu – funkčná fistula umožňuje to, čo tunelizovaný katéter spravidla nie.</li>
  <li><strong>Čas liečby.</strong> Skracovanie sedení pod štandardné trvanie znižuje konvektívny objem priamo úmerne, a to aj pri optimálnom prietoku.</li>
  <li><strong>Hematokrit a viskozita.</strong> Vyšší hematokrit po korekcii anémie znižuje dosiahnuteľnú filtračnú frakciu; parametre treba prehodnocovať, nie nastaviť raz.</li>
  <li><strong>Antikoagulácia a vlastnosti dialyzátora.</strong> Nedostatočná antikoagulácia alebo malá plocha membrány vedú k zrážaniu skôr, než sa cieľový objem dosiahne.</li>
  <li><strong>Kvalita vody a roztoku.</strong> Substitučný roztok sa pripravuje online z dialyzačného roztoku, ktorý sa infunduje priamo do krvi. Ultračistá kvalita a zaradené ultrafiltre preto nie sú voliteľnou nadstavbou, ale podmienkou bezpečnosti metódy.</li>
</ol>

<p>Odtiaľ pramení odporúčanie panelu monitorovať <em>dodaný</em>, nie predpísaný objem. Rozdiel medzi nimi je presne tým miestom, kde sa prínos v bežnej prevádzke stráca.</p>

<h2>Čo z odporúčaní naopak nevyplýva</h2>

<ul>
  <li><strong>Prínos nie je preukázaný pre predilučný režim.</strong> Dôkazy sa týkajú online <em>postdilučnej</em> HDF; predilúcia sa používa vtedy, keď postdilúcia nie je technicky možná, ale rovnaký účinok na úmrtnosť z nej odvodiť nemožno.</li>
  <li><strong>Kardiovaskulárny prínos nestojí na jednej štúdii.</strong> V ESHOL kardiovaskulárna úmrtnosť samostatne významnosť nedosiahla; odporúčanie sa opiera o súhrnnú analýzu individuálnych údajov.</li>
  <li><strong>Vplyv na kvalitu života je zatiaľ signál.</strong> Spomalenie zhoršovania fyzickej funkcie, pacientom vnímanej kognície, obťažovania bolesťou a sociálnej účasti má <strong>nízku</strong> istotu dôkazu a nemá sa pacientovi prezentovať ako očakávaný účinok.</li>
  <li><strong>HDF nenahrádza objemový manažment ani kontrolu dávky dialýzy.</strong> Ide o doplnenie odstraňovania stredne veľkých molekúl, nie o náhradu ostatných rozhodnutí o preskripcii.</li>
</ul>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení odporúčaní k online hemodiafiltrácii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">OL-HDF zvyšuje odstraňovanie stredne veľkých molekúl difúziou aj konvekciou</th>
      <td>Potvrdené</td>
      <td>Ide o princíp metódy, nie o klinický výsledok.</td>
    </tr>
    <tr>
      <th scope="row">Vysokoobjemová postdilučná HDF znižuje celkovú úmrtnosť, HR 0,84 (0,74–0,95)</th>
      <td>Potvrdené</td>
      <td>Údaj z metaanalýzy individuálnych údajov piatich štúdií so 4 153 pacientmi; stredná istota dôkazu.</td>
    </tr>
    <tr>
      <th scope="row">Znižuje kardiovaskulárnu úmrtnosť, HR 0,78 (0,64–0,96)</th>
      <td>Potvrdené</td>
      <td>Stredná istota. Jednotlivé štúdie samostatne tento výsledok nedosiahli.</td>
    </tr>
    <tr>
      <th scope="row">Bezpečnosť je porovnateľná s high-flux hemodialýzou</th>
      <td>Potvrdené s podmienkou</td>
      <td>Platí pri dodržaní kvality dialyzačného roztoku a nastavení; substitučný roztok sa pripravuje online a vstupuje priamo do krvi.</td>
    </tr>
    <tr>
      <th scope="row">Prínos je závislý od dávky konvekcie</th>
      <td>Potvrdené</td>
      <td>Metaanalýza individuálnych údajov opísala stupňovitý vzťah objemu a rizika úmrtia.</td>
    </tr>
    <tr>
      <th scope="row">HDF spomaľuje zhoršovanie kvality života</th>
      <td>Neisté</td>
      <td>Nízka istota dôkazu; ide o signál v niekoľkých doménach, nie o preukázaný účinok.</td>
    </tr>
    <tr>
      <th scope="row">Stačí prepnúť prístroj do režimu HDF</th>
      <td>Nesprávne</td>
      <td>Bez dosiahnutého konvektívneho objemu ide o zmenu záznamu, nie liečby. Objem vyplýva z prietoku krvi, času, cievneho prístupu a hematokritu.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Praktický postup pre dialyzačné stredisko</h2>

<ol>
  <li><strong>Merať dodaný konvektívny objem pri každom sedení</strong> a sledovať jeho medián na pacienta, nie len priemer za stredisko.</li>
  <li><strong>Určiť podiel sedení, ktoré dosiahnu cieľ.</strong> Ukazovateľ „percento sedení nad cieľovým objemom“ je informatívnejší než počet pacientov formálne vedených na HDF.</li>
  <li><strong>Riešiť cievny prístup ako súčasť dávky.</strong> Pacient s recirkuláciou alebo s katétrom s nízkym prietokom cieľ nedosiahne; kandidatúra na HDF je aj otázkou prístupu.</li>
  <li><strong>Nekrátiť čas.</strong> Skrátenie sedenia zníži konvekciu aj pri dokonalých ostatných parametroch.</li>
  <li><strong>Kontrolovať kvalitu vody a roztoku podľa noriem</strong> a viesť dokumentáciu o výmene ultrafiltrov.</li>
  <li><strong>Prehodnocovať nastavenia po zmene hematokritu, prístupu alebo antikoagulácie</strong>, nie raz pri prevedení na HDF.</li>
  <li><strong>Informovať pacienta triezvo:</strong> preukázaný je prínos v úmrtnosti pri dostatočnej dávke, nie zlepšenie pocitu z liečby.</li>
</ol>

<h2>Záver</h2>

<p>Odporúčania Talianskej nefrologickej spoločnosti posúvajú diskusiu z otázky „hemodiafiltrácia alebo hemodialýza“ na otázku „koľko konvekcie sme pacientovi skutočne dodali“. To je zmena, ktorá sa dá premietnuť do ukazovateľov kvality pracoviska: dodaný objem, podiel sedení nad cieľom a kvalita cievneho prístupu. Bez nich zostáva HDF technologickým označením, nie liečbou s doloženým prínosom.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=online-hemodiafiltracia-mco-dialyzatory-stredne-molekuly">Za hranicami difúzie: online hemodiafiltrácia a MCO dialyzátory v liečbe zlyhania obličiek</a></li>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Načasovanie cievneho prístupu pred hemodialýzou: AVF potrebuje väčší predstih než AVG</a></li>
  <li><a href="article.php?slug=improvizovana-hemodialyza-kvalita-vody-dialyzacneho-roztoku">Improvizovaná domáca hemodialýza: prečo prežitie jedného človeka nie je dôkazom bezpečnosti</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Strippoli GFM, Pellegrino G, Hegbrant J, Fabbrini P, Lentini PLM, Aucella F, Panichi V, Gallieni M, Canaud B, Davenport A, Ortiz A, Ramos R, Malyszko J, Kazancıoğlu R, Kuhlman M, Ferreira AC, Cromm K, Nigwekar S, Nissenson AR, De Nicola L. Online hemodiafiltration for kidney failure: guidance and best clinical practice recommendations from the Italian Society of Nephrology. <em>Journal of Nephrology</em>. Publikované online 19. augusta 2026. doi: 10.1093/joneph/aajag225. <a href="https://pubmed.ncbi.nlm.nih.gov/42614082/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Metaanalýza individuálnych údajov:</strong> Vernooij RWM, Hockham C, Strippoli G, et al. Haemodiafiltration versus haemodialysis for kidney failure: an individual patient data meta-analysis of randomised controlled trials. <em>The Lancet</em>. 2024;404(10464):1742–1749. doi: 10.1016/S0140-6736(24)01859-2. <a href="https://pubmed.ncbi.nlm.nih.gov/39489903/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia CONVINCE:</strong> Blankestijn PJ, Vernooij RWM, Hockham C, et al. Effect of Hemodiafiltration or Hemodialysis on Mortality in Kidney Failure. <em>New England Journal of Medicine</em>. 2023;389(8):700–709. doi: 10.1056/NEJMoa2304820. <a href="https://pubmed.ncbi.nlm.nih.gov/37326323/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia ESHOL:</strong> Maduell F, Moreso F, Pons M, et al. High-efficiency postdilution online hemodiafiltration reduces all-cause mortality in hemodialysis patients. <em>Journal of the American Society of Nephrology</em>. 2013;24(3):487–497. doi: 10.1681/ASN.2012080875. <a href="https://pubmed.ncbi.nlm.nih.gov/23411788/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Kvalita vody a dialyzačného roztoku:</strong> ISO 23500-1 až 23500-5: Preparation and quality management of fluids for haemodialysis and related therapies. Medzinárodná organizácia pre normalizáciu; aktuálne vydanie 2024. <a href="https://www.iso.org/standard/84368.html" target="_blank" rel="noopener noreferrer">ISO</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný zoznam autorov a všetky uvedené číselné výsledky boli overené 23. augusta 2026 cez PubMed a Crossref. Odporúčania boli v čase spracovania publikované online bez pridelenia ročníka a čísla. Uvedené cieľové hodnoty konvektívneho objemu sú prevzaté z podmienok citovaných štúdií a nenahrádzajú preskripciu pre konkrétneho pacienta.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_online_hemodiafiltracia_odporucania_sin',
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
