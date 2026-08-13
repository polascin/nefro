<?php

/**
 * add_vyssi-prijem-bielkovin-merana-gfr-renis_article.php
 * Odborný článok o príjme bielkovín a desaťročnom vývoji GFR meranej iohexolom v kohorte RENIS.
 */

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
    'title'        => 'Vyšší príjem bielkovín a funkcia obličiek: desaťročná kohorta nezistila rýchlejší pokles meranej GFR',
    'slug'         => 'vyssi-prijem-bielkovin-merana-gfr-renis',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V kohorte RENIS nebol vyšší obvyklý príjem bielkovín počas desiatich rokov spojený s rýchlejším poklesom GFR meranej iohexolom. Výsledok sa však nevzťahuje na extrémny príjem ani na pacientov s CKD.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>V populačnej kohorte RENIS nebol vyšší obvyklý príjem bielkovín udávaný účastníkmi počas mediánu desiatich rokov spojený s rýchlejším poklesom glomerulovej filtrácie meranej iohexolom. Výsledok oslabuje argument pre preventívne obmedzovanie bielkovín u ľudí bez chronickej choroby obličiek (CKD), nie je však povolením extrémneho príjmu ani zmenou výživových odporúčaní pre pacientov s CKD.</em></p>

<p>Otázka, či vyšší príjem bielkovín dlhodobo poškodzuje zdravé obličky, zostáva častým zdrojom obáv. Bielkovinová záťaž prechodne zvyšuje prietok krvi obličkami a glomerulovú filtráciu. Z fyziologickej odpovede však nemožno automaticky vyvodiť, že bežný vyšší príjem spôsobuje progresívne poškodenie obličiek.</p>

<p>Nová analýza nórskej kohorty <strong>Renal Iohexol Clearance Survey (RENIS)</strong>, publikovaná v časopise <em>Clinical Kidney Journal</em>, je dôležitá tým, že funkciu obličiek nesledovala iba pomocou kreatinínu a odhadovanej GFR (eGFR). Použila opakované meranie GFR klírensom iohexolu, čím odstránila časť neistoty spojenej s vplyvom svalovej hmoty a stravy na sérový kreatinín.</p>

<h2>Hlavný výsledok v jednej vete</h2>

<p>U ľudí stredného a vyššieho veku z bežnej populácie, ktorí mali prevažne zachovanú funkciu obličiek, nebol vyšší obvyklý príjem bielkovín udávaný účastníkmi v pozorovanom rozmedzí spojený s rýchlejším poklesom meranej GFR (mGFR), s častejším zrýchleným poklesom GFR ani s častejším novozistením mGFR pod 60 ml/min/1,73 m².</p>

<p>Je rovnako dôležité povedať, čo štúdia nepreukázala. Nešlo o randomizovaný pokus, nehodnotila extrémne vysoké dávky doplnkov a nebola navrhnutá na určovanie optimálneho príjmu bielkovín. Výsledky sa nemajú prenášať na pacientov s potvrdenou CKD.</p>

<h2>Prečo samotný kreatinín nemusí stačiť</h2>

<p>Väčšina populačných štúdií používa eGFR odvodenú od sérového kreatinínu. Je to dostupný a klinicky užitočný odhad, no koncentráciu kreatinínu ovplyvňuje aj svalová hmota, telesná aktivita, konzumácia tepelne upraveného mäsa, kreatínové doplnky a niektoré lieky. Zmena kreatinínu preto nemusí vždy znamenať rovnakú zmenu skutočnej filtrácie.</p>

<p>RENIS merala GFR po podaní iohexolu a stanovení jeho plazmatického klírensu. Iohexol je exogénny filtračný marker; jeho vymiznutie z plazmy poskytuje pri správne vykonanom protokole presnejšie zhodnotenie filtrácie než bežná kreatinínová rovnica. Meraná GFR nie je bez technickej variability, v tejto otázke však predstavuje významnú metodologickú prednosť.</p>

<h2>Kto bol zahrnutý do kohorty RENIS</h2>

<p>Analýza zahŕňala <strong>1 324 účastníkov</strong>. Priemerný vek bol 63,6 roka, ženy tvorili 50,4 % súboru a priemerná vstupná mGFR dosahovala 89,1 ml/min/1,73 m². Medián času medzi prvým a posledným meraním mGFR bol 10,0 roka.</p>

<p>Pôvodná kohorta vylučovala ľudí so samostatne uvádzaným diabetom, ochorením obličiek alebo kardiovaskulárnym ochorením. Do času východiskového vyšetrenia pre túto analýzu však časť účastníkov tieto stavy získala. Diabetes malo 2,0 %, kardiovaskulárne ochorenie 4,1 % a mGFR pod 60 ml/min/1,73 m² 2,5 % účastníkov. Hypertenziu podľa definície štúdie malo 52,1 %, prediabetes 47,8 % a obezitu 21,7 % súboru.</p>

<p>Preto je presnejšie hovoriť o všeobecnej populácii s <strong>prevažne zachovanou funkciou obličiek</strong> než o homogénnej skupine úplne zdravých ľudí.</p>

<h2>Ako sa hodnotil príjem bielkovín</h2>

<p>Účastníci vyplnili validovaný frekvenčný dotazník zachytávajúci obvyklý príjem 261 potravinových položiek počas predchádzajúceho roka. Priemerný uvádzaný príjem bielkovín bol 1,2 ± 0,5 g/kg/deň. Priemerné hodnoty v jednotlivých kvartiloch boli približne 0,8; 1,0; 1,3 a 1,8 g/kg/deň, pričom hranica najvyššieho kvartilu bola najmenej 1,4 g/kg/deň.</p>

<p>Dotazník sa však vypĺňal iba raz a jeho vyplnenie bolo od vstupného merania mGFR vzdialené v mediáne 20,5 mesiaca. U 233 účastníkov chýbali údaje o príjme bielkovín a energie; autori ich doplnili viacnásobnou imputáciou. Štúdia nemala 24-hodinový zber moču s dusíkom močoviny, ktorý by poskytol objektívnejšiu kontrolu príjmu, ani validované údaje o podiele živočíšnych a rastlinných bielkovín.</p>

<h2>Opakované meranie GFR počas desiatich rokov</h2>

<p>Zo všetkých 1 324 účastníkov malo 1 165 aspoň jedno následné meranie mGFR. Celkovo 920 účastníkov malo tri merania a 245 dve merania. Autori analyzovali tri výsledkové ukazovatele:</p>

<ol>
  <li><strong>ročnú rýchlosť zmeny mGFR,</strong></li>
  <li><strong>zrýchlený pokles mGFR,</strong> definovaný ako 10 % najstrmších poklesov, teda menej než −2,08 ml/min/1,73 m² za rok,</li>
  <li><strong>novozistenú mGFR pod 60 ml/min/1,73 m²</strong> u ľudí, ktorí mali na začiatku hodnotu aspoň 60.</li>
</ol>

<p>Posledný ukazovateľ nemožno bez ďalšieho nazývať novou CKD. Diagnóza CKD vyžaduje chronickú abnormalitu trvajúcu najmenej tri mesiace alebo iný marker poškodenia obličiek; jednorazový pokles mGFR pod túto hranicu podmienku chronicity sám osebe nespĺňa.</p>

<div class="pdf-avoid-break">
<h2>Čo ukázali plne upravené analýzy</h2>

<div class="table-responsive">
<table>
  <thead>
    <tr>
      <th>Výsledok pri zvýšení príjmu o 0,1 g/kg/deň</th>
      <th>Odhad</th>
      <th>95 % interval spoľahlivosti</th>
      <th>Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Ročná zmena mGFR</td>
      <td>−0,01 ml/min/1,73 m² za rok</td>
      <td>−0,04 až 0,02</td>
      <td>Bez štatisticky významnej asociácie</td>
    </tr>
    <tr>
      <td>Zrýchlený pokles mGFR</td>
      <td>OR 0,97</td>
      <td>0,86 až 1,10</td>
      <td>Bez štatisticky významnej asociácie</td>
    </tr>
    <tr>
      <td>Novozistená mGFR pod 60 ml/min/1,73 m²</td>
      <td>HR 1,09</td>
      <td>0,96 až 1,21</td>
      <td>Bez štatisticky významnej asociácie</td>
    </tr>
  </tbody>
</table>
</div>

<p><em>OR označuje pomer šancí a HR pomer okamžitých rizík.</em></p>
</div>

<p>V analýze novozistenej mGFR pod 60 bolo 1 064 účastníkov s úplnými údajmi a východiskovou mGFR aspoň 60; udalosť sa zaznamenala u 118 z nich (11,1 %). Výsledky sa významne nemenili ani pri analýze kvartilov, pri použití absolútnej neindexovanej GFR, po zohľadnení východiskovej GFR alebo vo viacerých analýzach citlivosti.</p>

<p>Autori nezistili štatisticky významnú modifikáciu vzťahu podľa pohlavia, albuminúrie, obezity, hypertenzie ani prediabetu. Tieto podskupinové výsledky však nemajú rovnakú výpovednú silu ako samostatne navrhnuté štúdie vo vysoko rizikových populáciách.</p>

<h2>Nulový výsledok nie je dôkaz absolútnej bezpečnosti</h2>

<p>Výsledok podporuje záver, že obvyklý príjem bielkovín v rozmedzí zastúpenom v tejto kohorte pravdepodobne nie je významným samostatným cieľom primárnej prevencie poklesu GFR. Neznamená však, že akékoľvek množstvo bielkovín je dlhodobo bezpečné pre každého človeka.</p>

<p>Pozorovacia štúdia nedokáže odstrániť všetky rozdiely medzi ľuďmi s nižším a vyšším príjmom. V najvyššom kvartile boli účastníci napríklad v priemere štíhlejší a mali nižšiu prevalenciu hypertenzie a prediabetu. Štatistické modely sa tieto rozdiely snažili zohľadniť, reziduálne skreslenie však nemožno vylúčiť.</p>

<p>Neistotu zvyšuje jednorazové sebahodnotenie stravy, časový odstup od vstupnej mGFR, chýbajúca objektívna validácia príjmu a neznáme zdroje bielkovín. Kohorta pozostávala prevažne z obyvateľov nórskeho mesta Tromsø vo veku približne 55 až 70 rokov. Výsledok sa preto nemusí prenášať na iné geografické a etnické skupiny, veľmi starých ľudí, osoby s nižším počtom nefrónov alebo populácie s vyšším výskytom CKD.</p>

<h2>Štúdia nehodnotila extrémny príjem ani doplnky</h2>

<p>Najvyšší kvartil síce zahŕňal príjem najmenej 1,4 g/kg/deň a jeho priemer bol 1,8 g/kg/deň, údaje však opisovali obvyklú stravu. Autori osobitne nehodnotili bielkovinové doplnky ani veľmi vysoký príjem typický pre časť silových športovcov. Z výsledku preto nemožno stanoviť bezpečnú hornú hranicu ani tvrdiť, že dlhodobý príjem 2 až 3 g/kg/deň je bez rizika.</p>

<p>Štúdia zároveň nerozlišovala rastlinné a živočíšne zdroje. Celková kvalita stravy môže ovplyvňovať kardiometabolické a renálne riziko nezávisle od samotného počtu gramov bielkovín. Rovnaký príjem môže byť súčasťou stravy bohatej na strukoviny, orechy, ryby a minimálne spracované potraviny alebo stravy s nadbytkom spracovaného mäsa, sodíka a ultraprocesovaných výrobkov. RENIS tieto rozdiely nevie porovnať.</p>

<h2>Pre pacientov s CKD platia iné odporúčania</h2>

<p>Výsledky sa nesmú preniesť na ľudí s potvrdenou chronickou chorobou obličiek. KDIGO 2024 navrhuje u dospelých s CKD G3 až G5 udržiavať príjem približne <strong>0,8 g/kg telesnej hmotnosti za deň</strong> a u pacientov s rizikom progresie sa vyhýbať vysokému príjmu nad <strong>1,3 g/kg/deň</strong>. Ide o individualizované odporúčanie, nie o dôvod na nekontrolovanú reštrikciu.</p>

<p>Pri rozhodovaní treba zohľadniť štádium a príčinu CKD, albuminúriu, rýchlosť poklesu eGFR, diabetes, vek, telesnú kompozíciu, fyzickú aktivitu, celkový energetický príjem a riziko sarkopénie alebo podvýživy. Nízko- a veľmi nízkobielkovinové režimy patria do rúk nefrológa a nutričného odborníka; KDIGO ich neodporúča metabolicky nestabilným pacientom. Pri dialýze sú potreby bielkovín zvyčajne vyššie a záver RENIS sa na túto populáciu nevzťahuje.</p>

<h2>Čo z toho vyplýva pre ambulanciu</h2>

<ol>
  <li><strong>Neobmedzovať bielkoviny preventívne iba zo strachu o zdravé obličky.</strong> U človeka bez CKD a bez významného renálneho rizika RENIS nepodporuje bežný obvyklý príjem bielkovín ako hlavný motor poklesu GFR.</li>
  <li><strong>Pred plánovaným výrazným zvýšením príjmu posúdiť riziko.</strong> Pri diabete, hypertenzii, známej CKD, albuminúrii, jedinej funkčnej obličke, opakovaných kameňoch alebo nejasnom trende kreatinínu je rozumné poznať eGFR, močový nález a pomer albumínu ku kreatinínu v moči (UACR).</li>
  <li><strong>Nehodnotiť funkciu obličiek z jedného kreatinínu bez kontextu.</strong> Zmenu môžu ovplyvniť mäso, kreatín, svalová hmota, hydratácia, cvičenie a lieky. Pri nesúlade s klinickým obrazom môže pomôcť kombinovaná eGFR z kreatinínu a cystatínu C; ak presnosť rozhoduje o zásadnom postupe, možno zvážiť meranú GFR.</li>
  <li><strong>Sledovať trend a albuminúriu.</strong> Stabilná eGFR nevylučuje poškodenie obličiek a samotný prechodný vzostup filtrácie nie je dôkazom dlhodobej ochrany.</li>
  <li><strong>Uprednostniť kvalitu celej stravy.</strong> Množstvo bielkovín treba zasadiť do príjmu energie, sodíka, vlákniny, draslíka a fosfátových aditív, podľa konkrétneho zdravotného stavu.</li>
</ol>

<h2>Ako výsledok zaradiť do doterajších dôkazov</h2>

<p>Staršia metaanalýza 28 intervenčných štúdií u 1 358 dospelých bez ochorenia obličiek nezistila nepriaznivú zmenu GFR pri vyššom príjme bielkovín, hoci štúdie boli väčšinou krátke a mali metodologické obmedzenia. RENIS pridáva dlhé sledovanie a opakovanú mGFR, no zostáva observačná.</p>

<p>Naopak, u pacientov s CKD G3 až G4 novšia retrospektívna kohorta spájala mierny príjem pod 1,0 g/kg/deň s nižším rizikom nepriaznivého kompozitného výsledku, najmä začatia dialýzy. Ani táto štúdia nedokazuje kauzalitu. Zdanlivý rozpor je predovšetkým pripomienkou, že primárna prevencia u ľudí s prevažne zachovanou funkciou obličiek a manažment už prítomnej CKD sú dve odlišné klinické otázky.</p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Kohorta RENIS poskytuje metodologicky mimoriadne hodnotné dlhodobé observačné údaje o príjme bielkovín a skutočne meranej GFR. Počas desiatich rokov nezistila, že by vyšší obvyklý príjem bielkovín udávaný účastníkmi súvisel s rýchlejším poklesom mGFR u ľudí stredného a vyššieho veku s prevažne zachovanou funkciou obličiek.</p>

<p>Primeraný záver nie je „čím viac bielkovín, tým lepšie“, ale užšie tvrdenie: dostupné údaje nepodporujú preventívne obmedzovanie bežného príjmu bielkovín ako významnú stratégiu ochrany obličiek u ľudí bez CKD. Extrémne dávky, doplnky, konkrétne zdroje bielkovín a vysoko rizikové populácie zostávajú neisté. Pri CKD sa naďalej postupuje podľa individuálneho nefrologického a nutričného plánu.</p>
</div>

<div class="pdf-avoid-break">
<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=mierne-obmedzenie-bielkovin-ckd-prognoza">Mierne obmedzenie bielkovín môže pri CKD zlepšiť prognózu</a> – odlišná otázka u pacientov s už prítomnou CKD G3 až G4.</li>
  <li><a href="article.php?slug=kreatin-ochorenia-obliciek-bezpecnost-benefit">Kreatín v ochoreniach obličiek: škoda alebo benefit?</a> – prečo sa zmena kreatinínu nemusí rovnať zmene GFR.</li>
  <li><a href="article.php?slug=renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek">Renálna funkčná rezerva: prečo normálna eGFR nevylučuje poškodenie obličiek</a> – hranice jedného filtračného čísla.</li>
</ul>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Rinde LB, Hopstock LA, Lundblad MW, Rinde NB, Brobak KM, Norvik JV, Enoksen IT, Solbu MD, Fuskevåg OM, Carrero JJ, Carlsen MH, Eriksen BO, Melsom T.</strong> <em>Higher habitual protein intake is not linked to decline of iohexol-measured GFR in adults ≥40 years.</em> Clinical Kidney Journal. 2026;19(8):sfag235. doi: 10.1093/ckj/sfag235. <a href="https://doi.org/10.1093/ckj/sfag235" target="_blank" rel="noopener noreferrer">Plný text primárnej štúdie</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(Suppl 4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text odporúčania</a>.</li>
  <li><strong>Devries MC, Sithamparapillai A, Brimble KS, Banfield L, Morton RW, Phillips SM.</strong> <em>Changes in Kidney Function Do Not Differ between Healthy Adults Consuming Higher- Compared with Lower- or Normal-Protein Diets: A Systematic Review and Meta-Analysis.</em> Journal of Nutrition. 2018;148(11):1760–1775. doi: 10.1093/jn/nxy197. <a href="https://pubmed.ncbi.nlm.nih.gov/30383278/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Beberashvili I, Baevsky T, Shmuel D, Yoles I, Rosen M, Efrati S.</strong> <em>Protein Intake and Kidney Outcomes in Nondialysis Chronic Kidney Disease Over 15 Years.</em> JAMA Network Open. 2026;9(4):e269575. doi: 10.1001/jamanetworkopen.2026.9575. <a href="https://doi.org/10.1001/jamanetworkopen.2026.9575" target="_blank" rel="noopener noreferrer">Plný text štúdie pri CKD</a>.</li>
</ol>
</div>

<p><em><strong>Poznámka k interpretácii:</strong> Primárna publikácia bola vecne overená v plnom texte vydavateľa a bibliografické údaje i úplný zoznam autorov v Crossref. Číselné výsledky sú uvádzané z plne upravených modelov. Praktické rozlíšenie populácie bez CKD a pacientov s CKD vychádza z KDIGO 2024; štúdia RENIS nemení odporúčania pre CKD ani neurčuje bezpečnú hornú hranicu príjmu bielkovín.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vyssi-prijem-bielkovin-merana-gfr-renis_article',
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
