<?php

/**
 * add_ckm-riziko-mladi-dospeli-79-percent-vyznam_article.php
 * CKM syndrom u mladych dospelych - spracovanie studie FF-CHAYA
 * (Krishnan a spol., Circ Popul Health Outcomes 2026, doi 10.1161/circoutcomes.125.013042).
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Kardiovaskulárno-obličkovo-metabolické riziko sa začína už v mladosti. Čo skutočne znamená nález u 79 % mladých dospelých?',
    'slug'         => 'ckm-riziko-mladi-dospeli-79-percent-vyznam',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štyria z piatich dvadsaťtrojročných spĺňali kritériá aspoň prvého štádia CKM syndrómu. Väčšinou však išlo o nadmernú adipozitu — a rozdiel v hrúbke karotíd predstavoval 14 mikrometrov.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Titulok hovorí o poškodení tepien u dvadsiatnikov. Publikované čísla hovoria o rozdiele 0,014 mm v hrúbke intimy-médie. Obidve tvrdenia sa opierajú o tú istú štúdiu — a rozdiel medzi nimi je presne tým, čo stojí za vysvetlenie.</em></p>

<p>Nová americká štúdia upozornila, že približne <strong>štyria z piatich</strong> ľudí vo veku okolo 23 rokov spĺňali kritériá najmenej prvého štádia kardiovaskulárno-obličkovo-metabolického syndrómu. Tento výsledok však neznamená, že 79 % mladých dospelých už má ochorenie srdca alebo obličiek. Vo väčšine prípadov išlo o prítomnosť nadmerného alebo dysfunkčného tukového tkaniva, prípadne o metabolické rizikové faktory.</p>

<h2>Čo je kardiovaskulárno-obličkovo-metabolický syndróm</h2>

<p>Kardiovaskulárno-obličkovo-metabolický syndróm (CKM, z anglického <em>cardiovascular-kidney-metabolic syndrome</em>) je koncepčný rámec vytvorený American Heart Association. Vyjadruje vzájomné prepojenie obezity a dysfunkcie tukového tkaniva, inzulínovej rezistencie a diabetu, chronickej choroby obličiek, aterosklerotického kardiovaskulárneho ochorenia a srdcového zlyhávania.</p>

<p>Nejde o jednu chorobu ani o novú samostatnú diagnózu, ale o <strong>systém klasifikácie rizika</strong>, ktorého cieľom je rozpoznať nepriaznivý vývoj skôr, než sa objaví klinicky manifestné ochorenie. CKM kontinuum sa rozdeľuje do piatich štádií:</p>

<div class="table-responsive" role="region" aria-label="Štádiá CKM syndrómu podľa American Heart Association" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štádium</th>
        <th scope="col">Definícia</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">0</th>
        <td>Bez identifikovaných rizikových faktorov</td>
      </tr>
      <tr>
        <th scope="row">1</th>
        <td>Nadbytok alebo porucha funkcie tukového tkaniva bez ďalších metabolických abnormalít</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Metabolické rizikové faktory alebo chronická choroba obličiek</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td>Subklinické kardiovaskulárne ochorenie alebo veľmi vysoké kardiovaskulárne riziko</td>
      </tr>
      <tr>
        <th scope="row">4</th>
        <td>Klinicky manifestné kardiovaskulárne ochorenie</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Už samotné zaradenie do štádia 1 teda môže byť podmienené nadváhou, obezitou alebo nepriaznivým rozložením telesného tuku. Výraz „syndróm“ môže preto u mladého človeka znieť závažnejšie, než zodpovedá jeho aktuálnemu klinickému stavu.</p>

<h2>Výsledky štúdie mladých dospelých</h2>

<p>Analyzovaných bolo <strong>1 283 účastníkov</strong> kohorty FF-CHAYA (<em>Future of Families – Cardiovascular Health Among Young Adults</em>). Priemerný vek dosahoval 22,9 roka (smerodajná odchýlka 0,7), ženy tvorili 54,4 %.</p>

<div class="table-responsive" role="region" aria-label="Rozdelenie účastníkov podľa štádia CKM syndrómu" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štádium CKM</th>
        <th scope="col">Podiel účastníkov</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Štádium 0</th><td>20,7 %</td></tr>
      <tr><th scope="row">Štádium 1 (nadmerná adipozita)</th><td>40,2 %</td></tr>
      <tr><th scope="row">Štádium 2 (metabolické rizikové faktory)</th><td>36,2 %</td></tr>
      <tr><th scope="row">Štádium 3 (subklinické KV ochorenie)</th><td>2,8 %</td></tr>
      <tr><th scope="row">Štádium 4</th><td>0 %</td></tr>
    </tbody>
  </table>
</div>

<p>Najmenej jedno kritérium štádií 1 až 3 teda spĺňalo <strong>79,2 % účastníkov</strong>. Väčšina z nich však bola zaradená do prvých dvoch štádií; iba 2,8 % patrilo do štádia 3 a <strong>nikto nemal klinicky manifestné kardiovaskulárne ochorenie</strong>.</p>

<p>Tvrdenie, že 79 % mladých ľudí už vykazuje „známky ochorenia srdca a obličiek“, by preto bolo nepresné. Správnejšie je povedať, že 79 % malo najmenej jeden znak CKM rizika, pričom najčastejšou jedinou položkou bola nadmerná alebo dysfunkčná adipozita — teda v praxi zvýšený index telesnej hmotnosti.</p>

<h2>Hodnotenie pomocou Life's Essential 8</h2>

<p>Skóre Life's Essential 8 zahŕňa štyri ukazovatele správania (stravovanie, pohybová aktivita, expozícia nikotínu, spánok) a štyri biologické faktory (telesná hmotnosť, lipidy, glykémia, krvný tlak). Pohybuje sa od 0 do 100 bodov, pričom vyššia hodnota znamená priaznivejšie kardiovaskulárne zdravie.</p>

<p>Štúdia neuvádza jednoduché priemery podľa štádia, ale <strong>upravené regresné koeficienty</strong> oproti štádiu 0, korigované na vek, pohlavie a etnicitu:</p>

<div class="table-responsive" role="region" aria-label="Rozdiel skóre Life's Essential 8 oproti štádiu 0" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štádium CKM</th>
        <th scope="col">Rozdiel skóre oproti štádiu 0 (β)</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Štádium 1</th><td>−7,6 bodu</td><td>−9,4 až −5,8</td></tr>
      <tr><th scope="row">Štádium 2</th><td>−13,9 bodu</td><td>−15,7 až −12,0</td></tr>
      <tr><th scope="row">Štádium 3</th><td>−13,2 bodu</td><td>−17,4 až −9,0</td></tr>
    </tbody>
  </table>
</div>

<p>Výsledky podporujú predpoklad, že vyššie štádium CKM je spojené s horším celkovým profilom kardiovaskulárneho zdravia. Zdanlivo lepšia hodnota v štádiu 3 (−13,2) než v štádiu 2 (−13,9) <strong>nie je prejavom priaznivejšieho stavu</strong> — interval spoľahlivosti pre štádium 3 (−17,4 až −9,0) je vzhľadom na malý počet účastníkov (2,8 %) široký a s intervalom štádia 2 sa prekrýva. Obidve skupiny majú v skutočnosti nerozlíšiteľný výsledok.</p>

<h2>Zmeny na karotických artériách — a ich skutočná veľkosť</h2>

<p>V súbore sa uskutočnilo ultrazvukové vyšetrenie karotických artérií. Vyššie štádium CKM bolo spojené s väčšou hrúbkou komplexu intima-média a s nižším sivotónovým mediánom (ukazovateľom echogenity steny). Konkrétne rozdiely oproti štádiu 0 v maximálnej priemernej hrúbke intimy-médie boli:</p>

<div class="table-responsive" role="region" aria-label="Rozdiel hrúbky intimy-médie karotídy oproti štádiu 0" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štádium CKM</th>
        <th scope="col">Rozdiel hrúbky</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Štádium 1</th><td>+0,014 mm</td><td>0,005 – 0,020</td></tr>
      <tr><th scope="row">Štádium 2</th><td>+0,020 mm</td><td>0,017 – 0,035</td></tr>
      <tr><th scope="row">Štádium 3</th><td>+0,100 mm</td><td>0,085 – 0,128</td></tr>
    </tbody>
  </table>
</div>

<p>Tieto čísla si zaslúžia pozornosť, pretože sa v mediálnom podaní strácajú. Rozdiel <strong>14 mikrometrov</strong> medzi štádiom 1 a štádiom 0 je štatisticky významný, ale u jednotlivého človeka nemerateľný — leží hlboko pod reprodukovateľnosťou bežného ultrazvukového merania. Ide o <strong>populačný signál, nie o individuálny nález</strong>.</p>

<p>Označenie „poškodenie tepien u dvadsiatnikov“ je preto pre štádiá 1 a 2 nadnesené. Vecne odlišná je situácia v štádiu 3, kde rozdiel 0,100 mm už zodpovedá rozsahu, aký sa v epidemiologických štúdiách spája s meraným kardiovaskulárnym rizikom — ale toto štádium bolo definované práve prítomnosťou subklinického kardiovaskulárneho ochorenia, takže nález nie je prekvapením.</p>

<p>Hrúbka intimy-médie je navyše ukazovateľom cievnej štruktúry, ktorý nemožno automaticky stotožňovať s aterosklerotickým plátom ani s klinickým aterosklerotickým ochorením. Keďže išlo o <strong>prierezové hodnotenie</strong>, štúdia nemohla preukázať „rýchly rozvoj“ poškodenia. Na posúdenie rýchlosti progresie by boli potrebné opakované vyšetrenia v časových odstupoch.</p>

<h2>Čo štúdia hovorí o obličkách</h2>

<p>CKM koncepcia správne zdôrazňuje, že obličky nemožno oddeliť od metabolického a kardiovaskulárneho zdravia. Obezita, hypertenzia, diabetes, glomerulová hyperfiltrácia, albuminúria a pokles glomerulovej filtrácie tvoria navzájom prepojený patologický reťazec.</p>

<p>Z publikovaných údajov však nemožno vyvodiť, že 79 % účastníkov malo poruchu funkcie obličiek. Do štádií 1 a 2 bolo možné vstúpiť aj na základe neobličkových kritérií a <strong>abstrakt štúdie neuvádza samostatnú prevalenciu albuminúrie ani zníženej eGFR</strong>. Bez týchto údajov nemožno určiť, akú časť CKM záťaže predstavovalo skutočné poškodenie obličiek — a v tejto vekovej skupine je pravdepodobne malá.</p>

<p>Diagnóza chronickej choroby obličiek navyše vyžaduje abnormalitu štruktúry alebo funkcie obličiek trvajúcu najmenej tri mesiace. Jednorazovo zistená albuminúria alebo znížená eGFR preto sama osebe diagnózu nepotvrdzuje; albuminúria môže byť prechodne zvýšená pri febrilnom stave, infekcii, intenzívnej telesnej záťaži, dehydratácii alebo počas menštruácie.</p>

<p>U mladých dospelých treba opatrne interpretovať aj eGFR založenú na sérovom kreatiníne. Výsledok môže ovplyvniť svalová hmota, výživa, fyzická aktivita či užívanie kreatínu — čo sú v tejto vekovej skupine mimoriadne časté vplyvy.</p>

<h2>Prečo sú výsledky napriek tomu významné</h2>

<p>Hoci titulkové interpretácie závažnosť zveličujú, samotný nález nie je zanedbateľný. Ukazuje, že obezita a metabolické rizikové faktory sú rozšírené už na začiatku dospelosti — a že sa dajú zachytiť merateľnou zmenou cievnej steny ešte v treťom decéniu života.</p>

<p>Ateroskleróza, hypertrofia ľavej komory, glomerulová hyperfiltrácia a mikrovaskulárne poškodenie sa môžu vyvíjať mnoho rokov pred prvými klinickými príznakmi. Dlhodobé riziko preto nezávisí iba od aktuálnej hodnoty krvného tlaku, glykémie alebo cholesterolu, ale aj od <strong>trvania expozície</strong>.</p>

<p>Rizikový faktor prítomný od 20 rokov môže mať podstatne väčší celoživotný účinok než rovnaká abnormalita vzniknutá v neskoršom veku. Bežné kalkulačky desaťročného kardiovaskulárneho rizika pritom u veľmi mladých ľudí nie sú dostatočne informatívne: nízke vypočítané krátkodobé riziko môže zakrývať vysoké celoživotné riziko.</p>

<h2>Obmedzenia výsledkov</h2>

<ul>
  <li>Prierezový dizajn neumožňuje posúdiť príčinnosť ani rýchlosť progresie.</li>
  <li>Kohorta FF-CHAYA vznikla z americkej štúdie rodín a detí zameranej najmä na populáciu veľkých miest. Výsledky nemožno automaticky prenášať na všetkých mladých dospelých ani na slovenskú populáciu.</li>
  <li>CKM štádium 1 zachytáva veľmi skorú rizikovú odchýlku, nie klinické ochorenie; v praxi ide často iba o zvýšený index telesnej hmotnosti.</li>
  <li>Štádium 3 zahŕňalo iba 36 účastníkov (2,8 %), preto sú všetky odhady v tejto skupine nepresné.</li>
  <li>Abstrakt neuvádza, aký podiel štádia 2 tvorila hypertenzia, dyslipidémia, porucha metabolizmu glukózy alebo chronická choroba obličiek.</li>
  <li>Asociácia vyššieho CKM štádia s hrúbkou intimy-médie nepotvrdzuje, že ľudia v danom štádiu majú aterosklerózu.</li>
  <li>Absolútna veľkosť cievneho rozdielu je v štádiách 1 a 2 pod hranicou klinickej rozlíšiteľnosti.</li>
</ul>

<h2>Praktické dôsledky pre prevenciu</h2>

<p>Výsledky podporujú začatie prevencie už v mladom veku. Základom zostáva pravidelné meranie krvného tlaku, hodnotenie telesnej hmotnosti a obvodu pása, zisťovanie fajčenia, pohybovej aktivity, kvality stravy a spánku.</p>

<p>Vyšetrenie lipidov a metabolizmu glukózy má byť prispôsobené individuálnemu riziku a odporúčaniam pre danú populáciu. Vyšetrenie sérového kreatinínu, eGFR a pomeru albumínu ku kreatinínu v moči je osobitne dôležité pri hypertenzii, diabete, obezite, kardiovaskulárnom ochorení, rodinnej anamnéze choroby obličiek alebo po prekonanom akútnom poškodení obličiek.</p>

<p>Výsledky štúdie samy osebe <strong>neodôvodňujú plošné ultrazvukové vyšetrovanie karotických artérií</strong> u asymptomatických mladých ľudí. Prínos takéhoto skríningu pre klinické výsledky nebol preukázaný a merané rozdiely sú u jednotlivca nerozlíšiteľné.</p>

<p>Najväčší význam má včasná úprava ovplyvniteľných faktorov: nefajčenie, pravidelný pohyb, primeraná telesná hmotnosť, kvalitná strava, dostatok spánku a včasná liečba hypertenzie, dyslipidémie a porúch metabolizmu glukózy.</p>

<h2>Záver</h2>

<p>Približne 79 % skúmaných mladých dospelých spĺňalo kritériá najmenej prvého štádia CKM. Tento údaj nemožno interpretovať tak, že štyria z piatich mladých ľudí už majú choré srdce alebo obličky. Väčšina mala skoré a potenciálne ovplyvniteľné rizikové charakteristiky, najmä nadmernú alebo dysfunkčnú adipozitu.</p>

<p>Štúdia však presvedčivo pripomína, že kardiovaskulárne a obličkové riziko nevzniká náhle v strednom či vyššom veku. Jeho biologické základy sa často vytvárajú už počas detstva a ranej dospelosti — a práve toto obdobie poskytuje najväčší priestor na účinnú dlhodobú prevenciu.</p>

<p>Zároveň ide o dobrú ilustráciu toho, ako sa z korektne publikovaného rozdielu 0,014 mm stane v tlačovej správe „poškodenie tepien“. Obidve formulácie vychádzajú z tých istých údajov; iba jedna z nich pacientovi neuškodí.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá, skríning a liečba</a> — podrobne k rámcu AHA.</li>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre CKM syndrómu</a> — pohľad KDIGO.</li>
  <li><a href="article.php?slug=5-kritickych-chyb-manazment-ckm-syndromu-nefrologia">Päť kritických chýb v manažmente CKM syndrómu</a>.</li>
  <li><a href="article.php?slug=acc-aha-ckm-syndrom-prve-odporucanie">Prvé odporúčanie ACC/AHA ku CKM syndrómu</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Vaishnavi Krishnan, Hongyan Ning, Daniel A. Notterman, Noreen Goldman, Sadiya S. Khan, Nilay S. Shah, Norrina B. Allen, Donald M. Lloyd-Jones.</strong> <em>Association Between Cardiovascular-Kidney-Metabolic Health and Early Arterial Injury in Young Adults in the United States: The Future of Families–Cardiovascular Health Among Young Adults Study.</em> Circulation: Population Health and Outcomes. 2026;e013042. <a href="https://doi.org/10.1161/circoutcomes.125.013042" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Donald M. Lloyd-Jones, Norrina B. Allen, James Stein, Hongyan Ning, Kristin Hansen, Lifang Hou a spol.</strong> <em>Future of Families: Cardiovascular Health Among Young Adults Cohort Study: Rationale, Key Questions, Study Design, and Participant Characteristics.</em> Journal of the American Heart Association. 2025;14(17):e042030. <a href="https://doi.org/10.1161/JAHA.125.042030" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Donald M. Lloyd-Jones, Norrina B. Allen, Cheryl A. M. Anderson, Terrie Black, LaPrincess C. Brewer, Randi E. Foraker, Michael A. Grandner, Helen Lavretsky, Amanda Marma Perak, Garima Sharma, Wayne Rosamond.</strong> <em>Life's Essential 8: Updating and Enhancing the American Heart Association's Construct of Cardiovascular Health.</em> Circulation. 2022;146(5):e18–e43. <a href="https://doi.org/10.1161/CIR.0000000000001078" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Rahul Aggarwal, John W. Ostrominski, Muthiah Vaduganathan.</strong> <em>Prevalence of Cardiovascular-Kidney-Metabolic Syndrome Stages in US Adults, 2011–2020.</em> JAMA. 2024;331(21):1858–1860. <a href="https://doi.org/10.1001/jama.2024.6892" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>American Heart Association.</strong> <em>Study found artery damage in adults in their 20s, highlighting need for early cardiovascular risk assessment.</em> Tlačová správa, 20. augusta 2026. <a href="https://newsroom.heart.org/news/study-found-artery-damage-in-adults-in-their-20s-highlighting-need-for-early-cardiovascular-risk-assessment" target="_blank" rel="noopener noreferrer">AHA Newsroom</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Všetky číselné údaje — 1 283 účastníkov, priemerný vek 22,9 (SD 0,7) roka, 54,4 % žien, rozdelenie štádií 20,7 / 40,2 / 36,2 / 2,8 %, regresné koeficienty skóre Life's Essential 8 (−7,6 [−9,4 až −5,8]; −13,9 [−15,7 až −12,0]; −13,2 [−17,4 až −9,0]) a rozdiely maximálnej priemernej hrúbky intimy-médie (+0,014 [0,005 – 0,020]; +0,020 [0,017 – 0,035]; +0,100 [0,085 – 0,128] mm) — boli overené proti štruktúrovanému abstraktu primárnej publikácie v registri Crossref. Nulový podiel štádia 4 pochádza z tlačovej správy AHA. Bibliografia bola overená cez Crossref. <strong>Opravy oproti pôvodnému spracovaniu:</strong> primárnym zdrojom nie je Healthline ani prehľadový článok o kohorte v <em>Journal of the American Heart Association</em> (ktorý opisuje dizajn kohorty), ale samostatná práca v časopise <em>Circulation: Population Health and Outcomes</em>; jej prvou autorkou je Vaishnavi Krishnan, nie Donald M. Lloyd-Jones. Absolútne priemerné skóre Life's Essential 8 podľa štádia (69,2 / 77,6 / 70,0 / 63,8 / 64,4) sa v publikovanom abstrakte nenachádza, preto bolo nahradené publikovanými upravenými regresnými koeficientmi. V citáciách boli opravené mená Terrie Black, Randi E. Foraker, Amanda Marma Perak a John W. Ostrominski. Kvantifikácia cievneho nálezu a upozornenie, že rozdiel 0,014 mm je pod hranicou individuálnej merateľnosti, sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckm-riziko-mladi-dospeli-79-percent-vyznam_article',
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
