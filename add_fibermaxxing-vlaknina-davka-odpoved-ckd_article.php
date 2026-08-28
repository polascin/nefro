<?php

/**
 * add_fibermaxxing-vlaknina-davka-odpoved-ckd_article.php
 * Odborný článok: „fibermaxxing“ — dávkovo-odpoveďový vzťah príjmu vlákniny
 * a jeho hranice pri chronickej chorobe obličiek.
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
    'title'        => '„Fibermaxxing“: vyšší príjem vlákniny prináša úžitok, otázkou je kde a pre koho sa krivka vyrovná',
    'slug'         => 'fibermaxxing-vlaknina-davka-odpoved-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Najväčšie zníženie rizika sa v rozsiahlom prehľade pozorovalo pri 25 – 29 g vlákniny denne. Kľúčová veta pre nefrológiu je však iná: tieto zistenia sa výslovne netýkajú ľudí s chronickým ochorením.',
    'content'      => <<<'HTML'
<p>Online trend označovaný ako „fibermaxxing“ vychádza z jednoduchej premisy: vláknina je zdravá, teda čím viac, tým lepšie. Prvá časť tejto premisy je dobre doložená. Druhá časť je problematická — a pri pacientovi s chronickou chorobou obličiek (CKD) je problematická dvojnásobne, pretože dôkazová základňa, o ktorú sa trend opiera, ľudí s chronickým ochorením výslovne nezahŕňa.</p>

<h2>Čo dôkazy skutočne ukazujú</h2>

<p>Najrozsiahlejším podkladom je séria systematických prehľadov a metaanalýz publikovaná v časopise <em>Lancet</em> v roku 2019. Zahrnula tesne pod 135 miliónov osoborokov údajov zo 185 prospektívnych štúdií a 58 klinických skúšaní so 4 635 dospelými účastníkmi.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Hlavné zistenia prehľadu o príjme vlákniny a zdravotných ukazovateľoch" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Zistenie</th>
        <th scope="col">Podrobnosť</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Veľkosť účinku</th>
        <td>Pri porovnaní najvyššieho a najnižšieho príjmu vlákniny bolo v pozorovacích údajoch riziko nižšie <strong>o 15 – 30 %</strong> pre celkovú a kardiovaskulárnu úmrtnosť, výskyt ischemickej choroby srdca, výskyt a úmrtnosť na cievnu mozgovú príhodu, diabetes 2. typu a kolorektálny karcinóm.</td>
      </tr>
      <tr>
        <th scope="row">Najvýhodnejšie pásmo</th>
        <td>Zníženie rizika bolo najväčšie pri dennom príjme vlákniny <strong>medzi 25 g a 29 g</strong>.</td>
      </tr>
      <tr>
        <th scope="row">Klinické skúšania</th>
        <td>Pri vyššom príjme vlákniny sa preukázala nižšia telesná hmotnosť, nižší systolický krvný tlak a nižší celkový cholesterol.</td>
      </tr>
      <tr>
        <th scope="row">Kvalita dôkazov</th>
        <td>Podľa prístupu GRADE hodnotená pre vlákninu ako <strong>stredná</strong>.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Druhým často citovaným podkladom je dávkovo-odpoveďová metaanalýza z časopisu <em>BMJ</em> (2013), ktorá zahrnula 22 kohortových publikácií. Každých ďalších <strong>7 g vlákniny denne</strong> sa v nej spájalo s <strong>rizikovým pomerom 0,91</strong> pre kardiovaskulárne ochorenie (95 % IS 0,88 – 0,94) aj pre ischemickú chorobu srdca (0,91; 95 % IS 0,87 – 0,94).</p>

<h2>Prvá korekcia: „plateau“ nie je celkom presné slovo</h2>

<p>Populárne prehľady z pásma 25 – 29 g/deň často vyvodzujú, že nad touto hranicou už úžitok nepribúda. Prehľad v <em>Lancete</em> však uvádza niečo odlišnejšie: krivky dávky a odpovede naznačovali, že <strong>vyšší príjem vlákniny by mohol prinášať ešte väčší úžitok</strong> v ochrane pred kardiovaskulárnymi ochoreniami, diabetom 2. typu a kolorektálnym a prsníkovým karcinómom.</p>

<p>Presnejšie znenie teda je: pásmo 25 – 29 g/deň je úroveň, pri ktorej bolo zníženie rizika naprieč viacerými ukazovateľmi najkonzistentnejšie doložené — nie strop, za ktorým úžitok končí. Argument proti extrémnym dávkam preto nestojí na tom, že by boli zbytočné, ale na znášanlivosti, na chýbajúcich dôkazoch pre veľmi vysoké dávky z doplnkov a na tom, komu sa dôkazy vôbec týkajú.</p>

<h2>Druhá korekcia, pre nefrológiu podstatnejšia: koho sa dôkazy týkajú</h2>

<p>Autori prehľadu v <em>Lancete</em> uvádzajú výslovné obmedzenie: <strong>zistenia sa vzťahujú na zníženie rizika v bežnej populácii, nie u osôb s chronickým ochorením</strong>. Prospektívne štúdie aj skúšania s účastníkmi s chronickým ochorením boli z analýzy vylúčené.</p>

<p>To má priamy dôsledok. Pacient s CKD, ktorý si prečíta odporúčanie „25 – 29 g denne, pokojne aj viac“, čerpá z dôkazovej základne, ktorá ho nezahŕňala. Neznamená to, že vláknina je pri CKD škodlivá — existuje dobrý mechanistický dôvod pre opak. Znamená to, že prenos číselného cieľa aj očakávanej veľkosti úžitku je extrapoláciou, a že o zdroji vlákniny treba pri CKD rozhodovať inak než v bežnej populácii.</p>

<h2>Prečo je vláknina pri CKD napriek tomu zaujímavá</h2>

<p>Nefrologický dôvod záujmu o vlákninu nie je kardiovaskulárny, ale mikrobiálny. Pri CKD sa mení zloženie črevnej mikrobioty a posilňuje sa <strong>proteolytická fermentácia</strong>, pri ktorej vznikajú prekurzory uremických toxínov viazaných na bielkoviny — indoxylsulfát a p-krezylsulfát. Fermentovateľná vláknina posúva rovnováhu smerom k sacharolytickej fermentácii a produkcii mastných kyselín s krátkym reťazcom. Ide o biologicky vierohodný mechanizmus, nie o dokázaný klinický prínos: štúdie s tvrdými obličkovými ukazovateľmi chýbajú.</p>

<h2>Praktický výber zdroja vlákniny pri CKD</h2>

<p>Pri CKD nie je otázkou „koľko gramov“, ale „z čoho“. Bežné vysokovlákninové potraviny sa líšia v tom, čo okrem vlákniny prinášajú:</p>

<ul>
  <li><strong>Draslík.</strong> Strukoviny, orechy, zemiaky, sušené ovocie a niektoré celozrnné výrobky patria k významným zdrojom draslíka. Pri CKD s hyperkaliémiou alebo pri liečbe blokátorom systému renín-angiotenzín treba výber prispôsobiť aktuálnej kaliémii, nie ho plošne zakázať.</li>
  <li><strong>Fosfor.</strong> Fosfor viazaný vo fytáte v celozrnných výrobkoch a strukovinách sa vstrebáva podstatne horšie než fosforečnanové aditíva v spracovaných potravinách. Z pohľadu fosfátovej záťaže je preto prirodzený zdroj vlákniny spravidla výhodnejší než „obohatený“ výrobok.</li>
  <li><strong>Tekutiny.</strong> Objemotvorná vláknina vrátane psyllia vyžaduje dostatočný príjem tekutín. Pri obmedzení príjmu tekutín — najmä u dialyzovaného pacienta — môže jej zvýšenie zápchu naopak zhoršiť.</li>
  <li><strong>Znášanlivosť.</strong> Nadúvanie a bolesti brucha sú časté najmä pri náhlom zvýšení dávky a pri niektorých typoch vlákniny. Postupné zvyšovanie po malých krokoch je znášané lepšie než skoková zmena.</li>
</ul>

<p>K často spomínanému vplyvu fytátov na vstrebávanie železa, zinku a vápnika: ide o reálny, no spravidla mierny efekt pri bežnom príjme. Klinicky významným sa stáva skôr pri veľmi vysokom príjme v kombinácii s hraničným nutričným stavom — čo je situácia, ktorá u pacienta s pokročilou CKD nastať môže.</p>

<h2>Čo o veľmi vysokých dávkach z doplnkov vieme</h2>

<p>Nič, čo by ich podporovalo. Neexistuje presvedčivý dôkaz, že extrémne dávky vlákniny z doplnkov prinášajú väčší úžitok než príjem z potravy v odporúčanom pásme. Uvedené prehľady navyše hodnotili prevažne vlákninu z potravy; prenos ich záverov na koncentrovaný doplnok nie je automatický. Preferencia potravinových zdrojov pred doplnkami je preto odôvodnená aj mimo nefrologického kontextu.</p>

<h2>Záver</h2>

<p>Vyšší príjem vlákniny je spojený s nižším rizikom viacerých ochorení a pásmo 25 – 29 g denne je najlepšie doloženou úrovňou. „Fibermaxxing“ však robí dva myšlienkové skoky naraz: zamieňa asociáciu za návod a bežnú populáciu za všetkých. Pri chronickej chorobe obličiek platí odporúčanie v inej podobe — vlákninu áno, prednostne z potravy, s postupným zvyšovaním a s výberom zdroja podľa kaliémie, fosfatémie a povoleného príjmu tekutín.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=gutmaxxing-rigidny-dietny-protokol-nefrologia">„Gutmaxxing“: keď sa snaha o zdravé črevo zmení na rigidný protokol</a></li>
  <li><a href="article.php?slug=strava-a-zdravie-creva-myty-influencerov-ckd">Strava a zdravie čreva podľa influencerov: kde vznikajú najčastejšie chyby</a></li>
  <li><a href="article.php?slug=indoxyl-sulfat-kognitivne-zhorsenie-ckd">Indoxylsulfát a kognitívne zhoršenie pri CKD</a></li>
  <li><a href="article.php?slug=tmao-crevny-metabolit-uremicky-toxin-ckd">TMAO: črevný metabolit ako uremický toxín pri CKD</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri CKD: edukovať, nie strašiť</a></li>
  <li><a href="article.php?slug=rastlinna-strava-nizsia-mortalita-ckd">Rastlinná strava a nižšia mortalita pri CKD</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Východiskový materiál:</strong> Medscape. What Is Fibermaxxing — and Is More Fiber Always Better? 2026. Východiskový materiál; číselné údaje a závery boli overené podľa primárnych publikácií uvedených nižšie.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Dávka a odpoveď, séria prehľadov:</strong> Reynolds A, Mann J, Cummings J, Winter N, Mete E, Te Morenga L. Carbohydrate quality and human health: a series of systematic reviews and meta-analyses. <em>Lancet</em>. 2019;393(10170):434–445. doi: <a href="https://doi.org/10.1016/S0140-6736(18)31809-9" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(18)31809-9</a>. PMID 30638909. <a href="https://pubmed.ncbi.nlm.nih.gov/30638909/" target="_blank" rel="noopener noreferrer">PubMed</a>. Zdroj údajov o pásme 25 – 29 g/deň, o znížení rizika o 15 – 30 %, o tvare krivky dávky a odpovede aj o obmedzení platnosti na bežnú populáciu.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. Kardiovaskulárny ukazovateľ:</strong> Threapleton DE, Greenwood DC, Evans CEL, Cleghorn CL, Nykjaer C, Woodhead C, Cade JE, Gale CP, Burley VJ. Dietary fibre intake and risk of cardiovascular disease: systematic review and meta-analysis. <em>BMJ</em>. 2013;347:f6879. doi: <a href="https://doi.org/10.1136/bmj.f6879" target="_blank" rel="noopener noreferrer">10.1136/bmj.f6879</a>. PMID 24355537, PMCID PMC3898422. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3898422/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplné autorské zoznamy a všetky číselné výsledky oboch primárnych prác boli overené 28. augusta 2026 cez PubMed z ich abstraktov. Upozornenie, že prehľad v <em>Lancete</em> vylúčil osoby s chronickým ochorením, a upresnenie tvaru krivky dávky a odpovede nie sú prevzaté z východiskového materiálu; pochádzajú priamo z abstraktu primárnej práce. Odporúčania pre výber zdroja vlákniny pri CKD sú odvodené zo všeobecne známych nutričných súvislostí, nie z uvedených prehľadov — tie pacientov s chronickým ochorením nezahŕňali.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne nutričné poradenstvo. Úpravu príjmu vlákniny pri chronickej chorobe obličiek treba prispôsobiť štádiu ochorenia, aktuálnym laboratórnym hodnotám a povolenému príjmu tekutín.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    // Publikované v dávke viacerých článkov naraz — newsletterové avízo sa zámerne
    // neposiela, aby odberatelia nedostali viacero samostatných e-mailov naraz.
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_fibermaxxing_vlaknina_davka_odpoved',
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
