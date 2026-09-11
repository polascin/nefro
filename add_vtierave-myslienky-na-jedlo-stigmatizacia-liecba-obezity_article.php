<?php

/**
 * add_vtierave-myslienky-na-jedlo-stigmatizacia-liecba-obezity_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — spracovanie redakčného prehľadu Medscape a odborných
 * komentárov (DOM 2026, Int J Obes 2026, Obesity 2026) doplnené o
 * experimentálne a prehľadové dôkazy overené cez PubMed.
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
    'title'        => 'Vtieravé myšlienky na jedlo, stigmatizácia a liečba obezity: prečo nestačí sledovať telesnú hmotnosť',
    'slug'         => 'vtierave-myslienky-na-jedlo-stigmatizacia-liecba-obezity',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Opakované vtieravé myšlienky na jedlo a stigmatizácia liečby vstupujú do diskusie o obezite. Ide zatiaľ o odborné komentáre a jeden vinetový experiment, nie o klinické dôkazy — a to treba pri interpretácii rešpektovať.',
    'content'      => <<<'HTML'
<p>Obezitu nemožno primerane hodnotiť iba podľa čísla na váhe. Klinicky významné sú aj zdravotné komplikácie, funkčná zdatnosť, psychická záťaž a vzťah človeka k jedlu. Do diskusie o liečbe vstupujú dva súvisiace, ale odlišné javy: opakované vtieravé myšlienky na jedlo, označované ako <em>food noise</em>, a stigmatizácia ľudí, ktorí užívajú lieky na zníženie telesnej hmotnosti.</p>

<p>Pred ďalším čítaním je užitočné vedieť, o aký typ dôkazov ide. Všetky tri odborné práce z roku 2026, na ktorých táto diskusia stojí, sú <strong>komentáre a koncepčné state, nie pôvodný výskum</strong>. Jediná experimentálna práca v tejto oblasti je z roku 2024 a ide o vinetový experiment na internetovej vzorke, nie o klinickú štúdiu pacientov. Komentár môže pomenovať klinický problém a navrhnúť ďalší výskum, sám však nepreukazuje účinnosť diagnostického nástroja ani príčinný vzťah medzi stigmatizáciou a prerušením liečby.</p>

<div class="table-responsive" role="region" aria-label="Typ dôkazu jednotlivých zdrojov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Práca</th>
      <th scope="col">Typ</th>
      <th scope="col">Čo z nej možno vyvodiť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Umashanker a Mitchell (2026)</th>
      <td>Odborný komentár</td>
      <td>Návrh, ako jav vymedziť a merať. Nie je to validovaný diagnostický nástroj.</td>
    </tr>
    <tr>
      <th scope="row">Post (2026)</th>
      <td>Koncepčná stať, výzva na výskum</td>
      <td>Hypotéza, že stigma spojená s liekmi je odlišnou formou hmotnostnej stigmy.</td>
    </tr>
    <tr>
      <th scope="row">Sumithran a Baur (2026)</th>
      <td>Odborný komentár</td>
      <td>Orientácia v rozmnožených rámcoch klasifikácie a stagingu obezity.</td>
    </tr>
    <tr>
      <th scope="row">Post a Persky (2024)</th>
      <td>Randomizovaný vinetový experiment, 357 dospelých</td>
      <td>Preukázané predsudky voči <em>opísanej postave</em> v kontrolovaných podmienkach.</td>
    </tr>
    <tr>
      <th scope="row">Brown, Flint a Batterham (2022)</th>
      <td>Prehľad zdravotnej politiky</td>
      <td>Rozšírenosť a dosah hmotnostnej stigmy naprieč spoločnosťou.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo znamená „food noise“</h2>

<p>Výraz <em>food noise</em> nemá v slovenčine ustálený odborný ekvivalent. Doslovný preklad „potravinový hluk“ nevystihuje jeho význam. V klinickom texte je výstižnejšie hovoriť o opakovaných vtieravých myšlienkach na jedlo.</p>

<p>Devika Umashanker a James Mitchell navrhujú chápať tento jav ako určitý <strong>typ myslenia</strong>. Podstatná nie je samotná prítomnosť myšlienok na jedlo, ale ich frekvencia, vtieravosť, emocionálny náboj a vplyv na správanie či každodenné fungovanie. Plánovanie nákupu, príprava jedla alebo príjemná spomienka na spoločné stolovanie sú bežné prejavy života, nie automaticky príznaky poruchy.</p>

<p>Klinickú pozornosť si zasluhujú predovšetkým myšlienky, ktoré človek vníma ako ťažko ovládateľné, opakovane narúšajú jeho sústredenie alebo sú spojené s výrazným utrpením či problémovým jedením. Ani vtedy však nejde o samostatne stanovenú diagnózu.</p>

<p>Treba ich odlišovať od fyziologického hladu, intenzívnej túžby po konkrétnom jedle, záchvatového prejedania a ďalších psychických ťažkostí. Tieto javy sa môžu prekrývať. Samotné časté myslenie na jedlo však nepreukazuje záchvatové prejedanie a jeho neprítomnosť nevylučuje poruchu príjmu potravy.</p>

<p>Pri hodnotení je potrebné zohľadniť aj reštriktívne stravovanie a nedostatočný energetický príjem. Myšlienky na jedlo nemusia byť prejavom nadmernej chuti do jedla — môžu súvisieť aj s hladovaním alebo s úzkostlivým dodržiavaním diétnych pravidiel. Klinický rozhovor preto nemá smerovať iba k otázke, ako tieto myšlienky potlačiť, ale aj k tomu, <strong>prečo vznikajú</strong>.</p>

<h2>Prečo liečba nemusí tieto myšlienky odstrániť</h2>

<p>Agonisty receptora glukagónu podobného peptidu 1, označované ako agonisty receptora GLP-1, ovplyvňujú reguláciu apetítu a príjmu potravy. Niektorí pacienti počas liečby opisujú aj oslabenie neustáleho zaoberania sa jedlom. Podobné skúsenosti sa uvádzajú po bariatrických operáciách. Odpoveď však nie je jednotná.</p>

<p>Zníženie hladu, skoršie nasýtenie, zmena túžby po jedle a ústup vtieravých myšlienok nie sú totožné výsledky. Pacient môže prijímať menej energie a znižovať telesnú hmotnosť, hoci sa naďalej intenzívne zaoberá jedlom. Naopak, subjektívna úľava od týchto myšlienok nemusí spoľahlivo predpovedať rozsah hmotnostného poklesu.</p>

<p>Pretrvávanie takýchto myšlienok preto samo osebe neznamená neúčinnosť liečby ani nedostatočnú spoluprácu pacienta. Nie je ani automatickým dôvodom na zvýšenie dávky lieku. Rozhodnutie musí vychádzať z celkového účinku, tolerancie, nutričného stavu, indikácie a psychického zdravia.</p>

<p>V diskusii sa spomínajú dotazníky <em>Food Noise Questionnaire</em> a <em>Ro Allison Indiana Dhurandhar-Food Noise Inventory</em>. Ich existencia však neznamená, že máme všeobecne prijatý diagnostický štandard alebo spoľahlivo stanovenú hranicu klinicky významnej zmeny. Návrh Umashanker a Mitchella je predovšetkým podnetom na presnejšie vymedzenie a meranie problému.</p>

<h2>Stigma spojená s liečbou je ďalšou záťažou</h2>

<p>Ľudia s obezitou čelia predsudkom, ktoré ich telesnú hmotnosť vysvetľujú nedostatkom disciplíny alebo osobným zlyhaním. Farmakoterapia tento problém nemusí odstrániť. Môže priniesť ďalšiu formu znevažovania: predstavu, že pacient dosiahol výsledok „príliš ľahko“.</p>

<p>Stacy M. Post navrhuje venovať stigmatizácii spojenej s užívaním agonistov receptora GLP-1 samostatnú výskumnú pozornosť. Argumentuje, že ide o <strong>odlišnú formu hmotnostnej stigmy</strong>, pri ktorej sa hodnotenie presúva od veľkosti tela k domnelej legitímnosti a „morálnej zaslúženosti“ farmakologickej liečby. Formuluje to však dôsledne v podmieňovacom spôsobe — takto zložená stigma <em>môže</em> zhoršovať zdravotné dôsledky a zapojenie do liečby. Ide teda o odôvodnenú obavu a výskumnú hypotézu, nie o preukázaný príčinný vzťah.</p>

<h3>Čo skutočne ukázal experiment</h3>

<p>Jediný priamy experimentálny doklad pochádza z práce Post a Perskej z roku 2024. Išlo o usporiadanie 2 × 2 na vzorke <strong>357 dospelých z USA</strong> (priemerný vek 37,8 roka; SD 13), ktorí boli náhodne priradení k čítaniu opisu ženy — buď štíhlej, alebo s obezitou — ktorá schudla 15 % telesnej hmotnosti buď diétou a cvičením, alebo pomocou agonistu receptora GLP-1. Práca bola vopred zaregistrovaná.</p>

<p>Výsledky:</p>

<ul>
  <li>negatívne hodnotenia boli silnejšie voči žene, ktorá schudla pomocou lieku, než voči tej, ktorá schudla diétou a cvičením;</li>
  <li>tento účinok sprostredkovalo presvedčenie, že pacientka „použila skratku“ — a to <strong>bez ohľadu na veľkosť tela</strong>;</li>
  <li>u štíhlej ženy bol navyše silnejší účinok na hodnotenia spojené s egotizmom.</li>
</ul>

<p>Takéto usporiadanie zachytáva predsudky v kontrolovaných podmienkach. Nehovorí však o ich frekvencii v bežnej populácii ani o dlhodobom klinickom dosahu. Vzorka bola americká a internetová, podnetom bol textový opis, nie skutočný človek, a posudzovanou postavou bola <strong>vždy žena</strong> — o postojoch voči mužom teda experiment nevypovedá nič.</p>

<h3>Vonkajšia a zvnútornená stigma</h3>

<p>Dôležité je rozlišovať medzi vonkajšou stigmatizáciou a jej zvnútornením. V prvom prípade ide napríklad o ponižujúce poznámky alebo spochybňovanie liečby okolím. V druhom pacient sám prijíma presvedčenie, že potreba lieku dokazuje jeho slabosť.</p>

<p>Širšia odborná literatúra opisuje súvislosti hmotnostnej stigmy s psychickou záťažou, problémovým stravovacím správaním a nepriaznivými skúsenosťami v zdravotnej starostlivosti; prehľad Browna, Flinta a Batterhamovej ju dokumentuje naprieč zdravotníctvom, médiami, pracoviskami, vzdelávaním aj tvorbou politík.</p>

<p>Pri konkrétnom tvrdení, že stigma súvisiaca s agonistami receptora GLP-1 spôsobuje nedodržiavanie liečby, je však potrebná opatrnosť. Prerušenie liečby môže mať mnoho príčin vrátane nežiaducich účinkov, ceny, dostupnosti alebo nesúladu medzi očakávaniami a výsledkom. Bez rozhovoru s pacientom nemožno určiť, akú úlohu zohrala stigma.</p>

<h2>BMI je užitočný, ale klinicky nepostačuje</h2>

<p>Index telesnej hmotnosti je dostupný orientačný ukazovateľ. Nedokáže však priamo rozlíšiť tukové tkanivo od svalovej hmoty ani určiť distribúciu tuku. Rovnako nevyjadruje závažnosť orgánového poškodenia alebo funkčného obmedzenia.</p>

<p>Priya Sumithran a Louise A. Baur sa vo svojom komentári venujú práve rozmnoženiu rámcov starostlivosti o obezitu a ich klasifikačným a stagingovým prístupom. Podľa redakčného prehľadu Medscape sa porovnávané rámce — vrátane prístupov Lancet Commission, European Association for the Study of Obesity a American Association of Clinical Endocrinology — zhodujú na potrebe širšieho klinického hodnotenia a individualizovanej dlhodobej starostlivosti, nie sú však vo všetkých diagnostických a klasifikačných detailoch totožné.</p>

<p>Vyšetrenie má podľa klinickej situácie dopĺňať index telesnej hmotnosti o posúdenie centrálnej adipozity, napríklad meraním obvodu pása, a o vyhľadanie komplikácií. Dôležité sú metabolické a kardiovaskulárne ochorenia, poruchy dýchania v spánku, pohybové obmedzenia, psychické zdravie a kvalita života.</p>

<p>Neprítomnosť zjavnej komplikácie neznamená neprítomnosť budúceho rizika. Zároveň nie každý človek s rovnakým indexom telesnej hmotnosti potrebuje rovnakú intervenciu. Rozhodujúce sú celkový zdravotný stav, pravdepodobný prínos a riziká liečby aj preferencie pacienta.</p>

<h2>Osobitosti u pacientov s ochorením obličiek</h2>

<p>V nefrológii má interpretácia telesnej hmotnosti ďalšie úskalia. Pri retencii tekutín nemusí zvýšená hmotnosť znamenať pribúdanie tuku. Rýchly pokles hmotnosti po úprave objemového preťaženia zase nemožno zamieňať za úspech redukčnej liečby.</p>

<p>Pri chronickej chorobe obličiek, najmä v pokročilých štádiách a pri dialýze, treba hodnotiť aj svalovú hmotu, funkčnú zdatnosť a riziko proteínovo-energetického chradnutia. Obezita a podvýživa sa navzájom nevylučujú — pacient môže mať nadbytok tukového tkaniva a súčasne nedostatočnú svalovú hmotu či neprimeraný príjem živín.</p>

<p>Z toho vyplýva praktický dôsledok, ktorý je pri tejto téme kľúčový: <strong>menšia chuť do jedla nie je sama osebe vždy priaznivým výsledkom</strong>. Jej význam závisí od východiskového nutričného stavu a od toho, či sa zachováva primeraný príjem energie a živín. To, čo je u metabolicky zdravšieho pacienta žiaduci účinok, môže byť u dialyzovaného pacienta so sklonom k chradnutiu varovným signálom.</p>

<p>Pri liečbe sprevádzanej nauzeou, vracaním alebo hnačkou treba venovať pozornosť hydratácii a funkcii obličiek. Režim príjmu tekutín musí rešpektovať konkrétny stav pacienta, najmä pri srdcovom zlyhávaní alebo dialyzačnej liečbe. Všeobecné odporúčanie zvýšiť príjem tekutín preto nemusí byť vhodné.</p>

<p>Tieto nefrologické súvislosti predstavujú klinické doplnenie témy. Uvedené komentáre o vtieravých myšlienkach a stigmatizácii neposkytujú podklad na posudzovanie účinnosti alebo bezpečnosti konkrétneho lieku u dialyzovaných pacientov.</p>

<h2>Ako viesť klinický rozhovor</h2>

<p>Hodnotenie možno začať otázkou, ako často pacient myslí na jedlo, či mu tieto myšlienky prekážajú a čo po nich nasleduje. Užitočné je rozlíšiť hlad, plánovanie jedla, úzkosť a epizódy straty kontroly nad jedením. Pri podozrení na poruchu príjmu potravy je potrebné cielené odborné vyšetrenie.</p>

<p>Rovnako dôležitý je rozhovor o skúsenostiach s liečbou. Pacient potrebuje priestor povedať, či ju pred okolím zatajuje, či sa stretáva so znevažovaním alebo či sa za užívanie lieku hanbí. Zdravotník nemá zľahčovať ani tieto skúsenosti, ani reálne nežiaduce účinky.</p>

<p>Úspech liečby sa má posudzovať podľa viacerých ukazovateľov. Okrem telesnej hmotnosti sú dôležité zdravotné komplikácie, funkčná zdatnosť, kvalita života, tolerancia liečby, nutričný stav a podľa potrieb pacienta aj zmena psychickej záťaže spojenej s jedlom.</p>

<p>Dlhodobá starostlivosť pritom neznamená nemennú liečbu za každých okolností. Znamená pravidelné prehodnocovanie prínosu, rizík a cieľov. Zmena liečebného postupu nie je morálnym hodnotením pacienta.</p>

<h2>Záver</h2>

<p>Obezita si vyžaduje medicínsky prístup, ktorý berie vážne biologické mechanizmy aj osobnú skúsenosť človeka. Vtieravé myšlienky na jedlo môžu byť významnou súčasťou tejto skúsenosti, zatiaľ však nie sú validovaným diagnostickým ani terapeutickým ukazovateľom — pojem sa ešte len vymedzuje a nástroje na jeho meranie nie sú overené.</p>

<p>Stigmatizácia spojená s farmakologickou liečbou je doložená experimentálne, no zatiaľ len na vinetovej vzorke; jej klinický dosah na dodržiavanie liečby ostáva hypotézou, ktorú treba overiť. To nemení nič na tom, že stigmatizácia nemá v liečbe miesto bez ohľadu na to, či pacient využíva režimové opatrenia, lieky alebo chirurgickú liečbu.</p>

<p>V nefrologickom kontexte platí navyše osobitná výhrada: ukazovatele, ktoré sú inde znakom úspechu — menšia chuť do jedla, pokles hmotnosti —, treba u pacienta s pokročilým ochorením obličiek vždy posudzovať spolu s nutričným a objemovým stavom.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ketogenna-dieta-metabolicke-zdravie-pecen-randomizovana-studia">Ketogénna diéta a metabolické zdravie: sľubné výsledky pre pečeň, nie dôkaz univerzálnej prevahy</a></li>
  <li><a href="article.php?slug=bmi-hematokrit-diabetes-2-typu-riziko-zlyhania-obliciek">BMI a hematokrit pri diabete 2. typu: čo skutočne hovoria o riziku zlyhania obličiek</a></li>
  <li><a href="article.php?slug=alternativne-sladidla-masld-ckd-inkretinova-liecba">Sladidlá pri MASLD, CKD a inkretínovej liečbe: dôkazy a neistoty</a></li>
</ul>

<hr>

<p><small><em><strong>Východiskový redakčný prehľad:</strong> Food Noise, Weight Stigma, and Managing Obesity. Medscape, 31. augusta 2026 (individuálny autor na dostupnej stránke neuvedený). <a href="https://www.medscape.com/viewarticle/med-op-ed-food-noise-weight-stigma-and-managing-obesity-2026a1000um7" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></small></p>

<p><small><em><strong>Vymedzenie pojmu:</strong> Umashanker D, Mitchell J. Food Noise Is a Type of Thinking. <em>Diabetes, Obesity and Metabolism</em>. Publikované online 10. augusta 2026. doi: 10.1111/dom.71203. <a href="https://pubmed.ncbi.nlm.nih.gov/42575863/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Stigma spojená s liečbou — koncepčná stať:</strong> Post SM. GLP-1 receptor agonists and the emergence of treatment-related stigma: a call for conceptual clarity. <em>International Journal of Obesity</em>. Publikované online 17. augusta 2026. doi: 10.1038/s41366-026-02200-5. <a href="https://pubmed.ncbi.nlm.nih.gov/42608457/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Experimentálny doklad:</strong> Post SM, Persky S. The effect of GLP-1 receptor agonist use on negative evaluations of women with higher and lower body weight. <em>International Journal of Obesity</em>. 2024;48(7):1019–1026. doi: 10.1038/s41366-024-01516-4. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12439114/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Rámce starostlivosti o obezitu:</strong> Sumithran P, Baur LA. Navigating the Numerous Frameworks for Obesity Care. <em>Obesity (Silver Spring)</em>. Publikované online 30. júla 2026. doi: 10.1002/oby.70273. <a href="https://pubmed.ncbi.nlm.nih.gov/42532510/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Hmotnostná stigma — prehľad:</strong> Brown A, Flint SW, Batterham RL. Pervasiveness, impact and implications of weight stigma. <em>eClinicalMedicine</em>. 2022;47:101408. doi: 10.1016/j.eclinm.2022.101408. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9046114/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>
HTML,
];

// ── Vloženie / aktualizácia ───────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vtierave_myslienky_stigmatizacia_obezita',
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
