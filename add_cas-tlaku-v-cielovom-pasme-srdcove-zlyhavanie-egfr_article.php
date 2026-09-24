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
    'title' => 'Čas tlaku v cieľovom pásme pri srdcovom zlyhávaní: súvislosť s poklesom eGFR a mortalitou',
    'slug' => 'cas-tlaku-v-cielovom-pasme-srdcove-zlyhavanie-egfr',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt' => 'Vyšší odhadovaný čas so systolickým tlakom 110 až 130 mm Hg sa spájal s priaznivejšou prognózou po hospitalizácii pre srdcové zlyhávanie. Čo výsledok znamená a čo nepreukazuje?',
    'content'      => <<<'HTML'
<p>Vyšší odhadovaný podiel času so systolickým tlakom v pásme 110 až 130 mm Hg sa v čínskej prospektívnej kohorte pacientov po hospitalizácii pre srdcové zlyhávanie spájal s nižšou pravdepodobnosťou poklesu funkcie obličiek a s nižšou dlhodobou mortalitou. Výsledok podporuje záujem o priebeh tlaku v čase, ale nepreukazuje, že cielené zvyšovanie tohto ukazovateľa zlepší prognózu. Pásmo použité vo výskume nemožno automaticky prevziať ako liečebný cieľ. [1]</p>

<h2>Populácia a spôsob hodnotenia tlaku</h2>
<p>Wang a spoluautori analyzovali multicentrickú prospektívnu kohortu pacientov hospitalizovaných pre srdcové zlyhávanie v 52 nemocniciach v Číne v rokoch 2016 až 2018. Systolický krvný tlak (STK) bol meraný pri návštevách v prvom, šiestom a dvanástom mesiaci po prepustení. Analýza renálneho výsledku zahŕňala 1 529 pacientov a analýza úmrtnosti 2 195 pacientov. Ide o rozdielne analytické súbory, ktoré nemožno zamieňať. [1]</p>
<p>Čas v cieľovom pásme (<em>time in target range</em>, TTR) vyjadroval odhadovaný podiel času so STK medzi 110 a 130 mm Hg. Autori ho vypočítali lineárnou interpoláciou medzi dostupnými meraniami. Nešlo o kontinuálne monitorovanie tlaku ani o priamy záznam všetkých denných hodnôt. Vyšší TTR preto znamená dlhší <em>odhadovaný</em> čas v zvolenom intervale, nie preukázanú neprítomnosť krátkych epizód hypotenzie alebo hypertenzie. [1]</p>
<p>Pri lineárnej interpolácii sa predpokladá postupná priamočiara zmena medzi dvoma meraniami. Tento predpoklad je výpočtovým zjednodušením: skutočný tlak môže medzi návštevami kolísať inak. TTR zároveň nie je totožný s variabilitou tlaku. Stabilná hodnota mimo zvoleného pásma môže viesť k nízkemu TTR, hoci je variabilita malá. Ide o metodické vysvetlenie ukazovateľa, nie o ďalší výsledok štúdie.</p>

<h2>Ako bol definovaný pokles funkcie obličiek</h2>
<p>Renálny výsledok vyžadoval <strong>súčasné splnenie oboch podmienok</strong>: pokles odhadovanej glomerulovej filtrácie (eGFR) najmenej o 20 % medzi prvým a dvanástym mesiacom a eGFR v dvanástom mesiaci pod 60 ml/min/1,73 m². Nešlo teda o akýkoľvek vzostup kreatinínu počas hospitalizácie ani o samotné prekročenie hranice eGFR 60 ml/min/1,73 m². [1]</p>
<p>Tento výskumný ukazovateľ nemožno zamieňať za zlyhanie obličiek, potrebu dialýzy alebo dôkaz nezvratného poškodenia. Samotné uvedené kritériá takisto nepotvrdzujú pretrvávanie nového nálezu počas najmenej troch mesiacov, ktoré je dôležité pri diagnostike chronickej choroby obličiek. Pokles eGFR treba klinicky hodnotiť v kontexte opakovaných vyšetrení, liečby a objemového stavu. [1, 3]</p>

<h2>Hlavné výsledky a ich správna interpretácia</h2>
<p>Medián sledovania bol 1,0 roka pre renálnu analýzu a 4,2 roka pre analýzu úmrtnosti. Autori hodnotili päťročnú celkovú mortalitu; údaj 4,2 roka vyjadruje medián dĺžky sledovania, nie odlišný koncový ukazovateľ. Od najnižšieho po najvyšší tercil TTR klesal výskyt renálneho výsledku aj úmrtia. [1]</p>
<div class="table-responsive pdf-keep-together" role="region" aria-label="Upravené asociácie vyššieho času v cieľovom pásme s výsledkami" tabindex="0">
<table>
<thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Upravený odhad</th><th scope="col">95 % interval spoľahlivosti</th><th scope="col">Hodnota p</th></tr></thead>
<tbody>
<tr><th scope="row">Pokles funkcie obličiek</th><td>OR 0,74</td><td>0,60 až 0,93</td><td>0,008</td></tr>
<tr><th scope="row">Úmrtie z akejkoľvek príčiny</th><td>HR 0,90</td><td>0,83 až 0,98</td><td>0,01</td></tr>
</tbody>
</table>
</div>
<p>Odhady sa vzťahujú na zvýšenie TTR o jednu štandardnú odchýlku, v príslušných analýzach približne o 35 až 36 percentuálnych bodov. Nejde o zvýšenie TTR o jeden percentuálny bod ani o relatívne zvýšenie o 35 %. Napríklad posun z 30 % na 65 % predstavuje 35 percentuálnych bodov; tento príklad iba vysvetľuje mierku a nie je údajom o konkrétnych pacientoch. [1]</p>
<p><strong>OR 0,74 znamená o 26 % nižšiu šancu udalosti, nie automaticky o 26 % nižšie riziko.</strong> HR 0,90 znamená približne o 10 % nižšie okamžité riziko úmrtia počas sledovania. Ani jeden údaj nevyjadruje absolútny počet odvrátených udalostí. Bez absolútnych rizík a bez kauzálneho dôkazu nemožno vypočítať spoľahlivý počet pacientov potrebných liečiť na zabránenie jednej udalosti.</p>
<p>Abstrakt opisuje konzistentné výsledky aj pri šesťmesačnom TTR, v podskupinách a pri kardiovaskulárnej mortalite. Bez podrobností však nemožno tvrdiť, že účinok bol dokázaný osobitne pre každý fenotyp srdcového zlyhávania alebo každé štádium CKD. [1]</p>

<h2>Prečo z výsledku nemožno odvodiť liečebný účinok</h2>
<ul>
<li><strong>Observačný dizajn:</strong> pacienti neboli randomizovaní na stratégie zvyšujúce TTR. Lepší priebeh tlaku môže odrážať menej závažné srdcové zlyhávanie, lepšiu adherenciu alebo iné priaznivé charakteristiky. Úprava na dostupné premenné nevylučuje zvyškové skreslenie.</li>
<li><strong>Riedke merania:</strong> tri návštevy počas prvého roka nemôžu spoľahlivo zachytiť všetky medziľahlé výkyvy. Presnosť TTR závisí od meraní aj od predpokladu lineárneho priebehu.</li>
<li><strong>Prekrývanie hodnotených období:</strong> TTR a zmena eGFR boli hodnotené počas prvého roka. Renálny výsledok preto nemožno prezentovať ako predpoveď udalostí, ktoré sa všetky odohrali až po dokončení merania TTR. Vzťah môže byť obojstranný.</li>
<li><strong>Výber pacientov a chýbajúce údaje:</strong> rozdielne počty v oboch analýzach upozorňujú na dostupnosť odlišných údajov. Bez plného textu nemožno presne zhodnotiť vplyv vylúčení, strát zo sledovania ani spôsob časového ukotvenia mortalitnej analýzy.</li>
<li><strong>Bez overeného rozhodovacieho prahu:</strong> samotný abstrakt neposkytuje validovanú hranicu TTR, podľa ktorej by sa mala meniť liečba. Rozdelenie do tercilov nevytvára univerzálny klinický prah.</li>
</ul>
<p>Uvedené výhrady sú metodickou interpretáciou dostupného opisu štúdie. Neznamenajú, že analýza je bez hodnoty; určujú, aké závery z nej možno bezpečne vyvodiť.</p>

<h2>Ako nález zapadá do širších dôkazov</h2>
<p>Systematický prehľad z roku 2025 zahŕňal 21 štúdií TTR krvného tlaku. Vyšší TTR sa spájal s nižšou celkovou a kardiovaskulárnou mortalitou a s niektorými kardiovaskulárnymi výsledkami. Pre nepriaznivé obličkové udalosti však vtedajšie údaje neposkytovali dostatočnú podporu asociácie. Nová práca preto dopĺňa vznikajúci súbor dôkazov, ale sama nemení TTR na potvrdený liečebný cieľ alebo validovaný nefrologický prognostický nástroj. [2]</p>

<h2>Praktický význam pre nefrológa</h2>
<p>Výskumné pásmo 110 až 130 mm Hg sa nesmie stať automatickým pokynom upravovať liečbu každému pacientovi so srdcovým zlyhávaním. Pre ilustráciu odlišného klinického rámca: KDIGO 2024 pri vysokom tlaku a CKD navrhuje STK pod 120 mm Hg, ak je tolerovaný a meraný štandardizovaným ambulantným postupom. Súčasne pripúšťa menej intenzívnu liečbu pri krehkosti, vysokom riziku pádov, veľmi obmedzenej očakávanej dĺžke života alebo symptomatickej ortostatickej hypotenzii. Toto odporúčanie nie je totožné s TTR zo skúmanej kohorty a nemožno ho mechanicky aplikovať na každého pacienta so srdcovým zlyhávaním. [3]</p>
<p>Rozumným praktickým dôsledkom je sledovať opakované hodnoty tlaku spolu so symptómami, ortostatickou reakciou, funkciou obličiek, elektrolytmi a objemovým stavom. Pri zhoršení treba hľadať príčinu vrátane zmien liečby alebo interkurentného ochorenia. KDIGO považuje pri CKD zmenu eGFR o viac než 20 % pri následnom vyšetrení za dôvod na vyhodnotenie; nejde však o totožnú definíciu so skúmaným renálnym ukazovateľom. [3]</p>
<p>Úprava diuretík alebo ďalších liekov má vychádzať z klinického stavu a ich indikácie, nie zo snahy za každú cenu zvýšiť TTR. Výsledok tejto štúdie nepodporuje automatické vysadzovanie prognosticky prospešnej liečby pri jednej hodnote tlaku mimo pásma. TTR môže byť doplnkovým opisom priebehu, ale nenahrádza klinické rozhodovanie.</p>

<h2>Záver</h2>
<p>U pacientov po hospitalizácii pre srdcové zlyhávanie bol vyšší odhadovaný čas so STK 110 až 130 mm Hg spojený s priaznivejšími renálnymi výsledkami a nižšou mortalitou. Najdôležitejším posolstvom je význam dlhodobého sledovania a kontextu meraní. Kauzálny prínos liečby riadenej podľa TTR, optimálne cieľové pásmo a klinické prahy si vyžadujú ďalšie overenie.</p>
<p><small><em>Rozsah overenia: pôvodný abstrakt a bibliografia boli overené cez PubMed, Europe PMC a Crossref vrátane úplného autorského zoznamu. Plný text pôvodnej práce nebol dostupný; preto sa neuvádzajú neoverené absolútne počty udalostí, hranice tercilov, zoznam všetkých premenných modelu ani podrobnosti o začiatku sledovania mortality. Praktická interpretácia je oddelená od výsledkov štúdie a doplnená odporúčaním KDIGO. Stav overenia: 24. september 2026.</em></small></p>
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>Wang B, Li J, Huang X, Liu J, Zheng X, Li Y, Li M, Xu Y, Zhang H. Improved Long-Term Systolic Blood Pressure Control Measured by Time in Target Range Is Associated With Lower Risks of Renal Function Decline and Long-Term Death Among Patients With Heart Failure. J Am Heart Assoc. 2026;15(18):e048006. <a href="https://doi.org/10.1161/jaha.125.048006" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42714424/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Wang H, Song J, Liu Z, Yu H, Wang K, Qin X, Wu Y. Time in Target Range for Blood Pressure and Adverse Health Outcomes: A Systematic Review. Hypertension. 2025;82(3):419-431. <a href="https://doi.org/10.1161/hypertensionaha.124.24013" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39801461/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plné odporúčanie</a>.</em></small></li>
</ol>
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
    'log_prefix' => 'add_cas-tlaku-v-cielovom-pasme-srdcove-zlyhavanie-egfr_article',
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
