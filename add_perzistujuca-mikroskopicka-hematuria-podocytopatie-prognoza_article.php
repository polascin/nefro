<?php

/**
 * add_perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza_article.php
 * Odborný článok o prognostickom význame hematúrie pri podocytopatiách.
 *
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Perzistujúca mikroskopická hematúria pri podocytopatiách: prognostický signál, nie terapeutický cieľ',
    'slug'         => 'perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V retrospektívnej kohorte bola perzistujúca mikroskopická hematúria po úprave o vybrané faktory spojená s vyšším rizikom zlyhania obličiek. Podporuje sledovanie sedimentu, nie automatickú eskaláciu liečby.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Perzistujúca mikroskopická hematúria bola v novej retrospektívnej kohorte pacientov s membranóznou nefropatiou, chorobou minimálnych zmien alebo fokálnou segmentálnou glomerulosklerózou nezávisle spojená so zlyhaním obličiek. Ide o klinicky dostupný prognostický signál, nie o dôkaz, že samotná hematúria spôsobuje progresiu alebo že má automaticky viesť k intenzívnejšej imunosupresii.</em></p>

<p>Pri ochoreniach s poškodením podocytov dominuje klinickému hodnoteniu proteinúria, nefrotický syndróm a trend glomerulovej filtrácie. Krv v moči býva často považovaná za sprievodný nález alebo za dôvod na hľadanie inej diagnózy. Štúdia Gabriela Ștefana a spoluautorov publikovaná v časopise <em>Nephrology</em> ukazuje, že dôležitá môže byť najmä perzistencia mikroskopickej hematúrie v prvých mesiacoch po biopsii.</p>

<h2>Čo presne štúdia skúmala</h2>

<p>Autori retrospektívne analyzovali 236 dospelých s biopsiou potvrdeným ochorením, ktoré v štúdii zaradili pod spoločný pojem primárne podocytopatie:</p>

<ul>
  <li>114 pacientov s membranóznou nefropatiou (MN),</li>
  <li>76 pacientov s chorobou minimálnych zmien (MCD),</li>
  <li>46 pacientov s fokálnou segmentálnou glomerulosklerózou (FSGS).</li>
</ul>

<p>Perzistujúca hematúria bola definovaná ako nález najmenej piatich erytrocytov na zorné pole pri veľkom zväčšení v najmenej troch po sebe nasledujúcich vzorkách moču odobratých do troch mesiacov po biopsii. Takáto definícia je podstatne prísnejšia než jednorazová pozitivita testovacieho prúžka.</p>

<p>Primárnym výsledkom bolo zlyhanie obličiek vyžadujúce chronickú náhradu funkcie obličiek. Autori použili Kaplanovu-Meierovu analýzu a Coxov model proporcionálnych rizík. V multivariabilnom modeli zohľadnili diagnózu, východiskovú eGFR, proteinúriu, Charlsonov index komorbidity a histologické skóre chronicity.</p>

<h2>Hlavné výsledky</h2>

<p>Perzistujúcu hematúriu malo 73 pacientov, teda 31 % kohorty. V porovnaní s pacientmi bez perzistujúcej hematúrie mali vyššiu proteinúriu (5,3 oproti 3,2 g/g; <em>p</em> = 0,01) a častejšie hypertenziu (55 % oproti 36 %; <em>p</em> = 0,007).</p>

<p>Počas mediánu sledovania 96 mesiacov dosiahlo zlyhanie obličiek 38 pacientov, teda 16 % celej kohorty. V skupine s perzistujúcou hematúriou to bolo 32 % pacientov, kým v skupine bez nej 9 % (<em>p</em> &lt; 0,001).</p>

<p>Po uvedenej multivariabilnej úprave bola perzistujúca hematúria spojená s vyšším rizikom zlyhania obličiek: hazard ratio (HR) 3,55; 95 % interval spoľahlivosti 1,78–7,05; <em>p</em> &lt; 0,001. Asociácia teda pretrvala aj po zohľadnení viacerých významných prognostických premenných.</p>

<h2>Ako správne čítať HR 3,55</h2>

<p>Hazard ratio 3,55 neznamená, že každému pacientovi s hematúriou sa riziko zvýši presne 3,55-násobne ani že hematúria spôsobila zlyhanie obličiek. Vyjadruje pomer okamžitého rizika udalosti medzi skupinami počas sledovania za predpokladu proporcionality rizík a pri úprave o premenné zahrnuté do modelu.</p>

<p>Označenie „nezávislá asociácia“ sa vzťahuje iba na tento konkrétny model. Neznamená nezávislosť od všetkých možných faktorov. Z abstraktu publikácie nie je možné posúdiť, ako výsledok ovplyvnili časovo premenlivá proteinúria, remisia ochorenia, opakované relapsy, konkrétna imunosupresívna liečba alebo neglomerulové príčiny krvácania.</p>

<p>Široký 95 % interval spoľahlivosti od 1,78 do 7,05 navyše ukazuje neistotu veľkosti účinku. Smer asociácie je presvedčivý, presný odhad jej sily si však vyžaduje potvrdenie vo väčších nezávislých súboroch.</p>

<h2>Výsledok nadväzuje na väčšiu kohortu</h2>

<p>Nová práca nie je prvým signálom prognostického významu hematúrie pri týchto diagnózach. Marchel a spoluautori analyzovali 1 516 detí a dospelých z prospektívnych kohort NEPTUNE a CureGN. Hematúriu pri vstupnom vyšetrení malo 33 % účastníkov. Po úprave o diagnózu, vek, pohlavie, proteinúriu, eGFR, čas od biopsie a kohortu bola spojená s vyšším rizikom kompozitného renálneho výsledku (HR 1,31; 95 % interval spoľahlivosti 1,04–1,65) a s nižšou mierou dosiahnutia remisie proteinúrie (HR 0,80; 95 % interval spoľahlivosti 0,65–0,98).</p>

<p>Obe štúdie sa navzájom podporujú, ich odhady však nemožno priamo porovnávať. Líšia sa vekom a pôvodom účastníkov, definíciou hematúrie, okamihom merania aj sledovaným výsledkom. Novšia práca hodnotila opakovane potvrdenú perzistenciu a tvrdší výsledok v podobe zlyhania obličiek vyžadujúceho chronickú náhradu funkcie.</p>

<h2>Marker aktivity, poškodenia alebo samostatný mediátor?</h2>

<p>Retrospektívna štúdia mechanizmus nepreukazuje. Perzistujúca hematúria môže označovať závažnejšie alebo nedostatočne kontrolované glomerulové poškodenie, ktoré sa súčasne prejavuje vyššou proteinúriou, hypertenziou a chronickými histologickými zmenami. Môže tiež zachytávať inú, súbežnú glomerulovú alebo genetickú diagnózu.</p>

<p>Biologicky je možné, že prechod erytrocytov cez poškodenú glomerulovú bariéru a následná expozícia tubulov hemoglobínu a hému podporujú oxidačný stres a tubulointersticiálne poškodenie. Z dostupných údajov však nemožno určiť, akú časť asociácie vysvetľuje priama toxicita krvácania a akú časť spoločná závažnosť základného ochorenia. Mechanistické vysvetlenie preto zostáva hypotézou.</p>

<h2>Testovací prúžok nestačí</h2>

<p>KDIGO odporúča pozitivitu testovacieho prúžka na krv potvrdiť mikroskopickým vyšetrením čerstvého močového sedimentu. Prúžok reaguje na hemový pigment a nerozlíši erytrocyty od voľného hemoglobínu alebo myoglobínu. Výsledok môže ovplyvniť aj koncentrácia moču, čas spracovania a laboratórna metodika.</p>

<p>Pri glomerulovom pôvode podporujú diagnózu dysmorfné erytrocyty, akantocyty a erytrocytové valce. Ich neprítomnosť však glomerulové ochorenie automaticky nevylučuje. Dôležité je zaznamenať nielen pozitivitu, ale aj počet erytrocytov, morfológiu, prítomnosť valcov, súčasnú albuminúriu alebo proteinúriu a trend v čase.</p>

<p>Jednorazový nález po fyzickej záťaži, počas infekcie, pri menštruácii alebo krátko po invazívnom výkone nemožno stotožniť s perzistujúcou hematúriou použitou v štúdii. Rovnakú definíciu možno v praxi uplatniť iba pri porovnateľnom odbere, spracovaní a mikroskopickom hodnotení.</p>

<h2>Pred atribúciou podocytopatii treba myslieť na alternatívy</h2>

<p>Biopsiou potvrdená MN, MCD alebo FSGS nevylučuje druhú príčinu hematúrie. Podľa klinického kontextu treba zvažovať infekciu močových ciest, litiázu, štruktúrnu léziu, nádor močových ciest, gynekologickú kontamináciu, liekové vplyvy, inú glomerulopatiu alebo dedičnú poruchu glomerulovej bazálnej membrány.</p>

<p>Osobitne pri FSGS treba pamätať, že ide o histologický vzor s primárnymi, genetickými, adaptívnymi aj sekundárnymi príčinami. Pri membranóznej nefropatii je zasa dôležité správne odlíšenie primárnej a sekundárnej formy. Prenositeľnosť výsledkov preto závisí aj od kvality pôvodného diagnostického zaradenia.</p>

<h2>Čo výsledok mení v ambulancii</h2>

<ol>
  <li><strong>Potvrdiť a charakterizovať nález.</strong> Pozitívny prúžok overiť mikroskopicky a posúdiť glomerulové znaky, kvantitu aj možné prechodné príčiny.</li>
  <li><strong>Sledovať perzistenciu.</strong> Výsledky zapisovať porovnateľným spôsobom a hodnotiť ich spolu s proteinúriou, eGFR, krvným tlakom a klinickou odpoveďou na liečbu.</li>
  <li><strong>Prehodnotiť diferenciálnu diagnózu.</strong> Pri netypickom sedimente, makroskopickej hematúrii, zrazeninách, močových príznakoch alebo rizikových faktoroch doplniť nefrologické či urologické vyšetrenie podľa situácie.</li>
  <li><strong>Nepovažovať hematúriu za samostatný liečebný cieľ.</strong> Štúdia neposkytuje prah na začatie alebo eskaláciu imunosupresie a nedokazuje prínos liečby zameranej iba na vymiznutie erytrocytúrie.</li>
  <li><strong>Intenzitu sledovania individualizovať.</strong> Perzistencia môže podporiť častejšiu kontrolu vysokorizikového pacienta, ale rozhodnutie má vychádzať z celého fenotypu ochorenia.</li>
</ol>

<h2>Limity štúdie</h2>

<ul>
  <li><strong>Retrospektívny dizajn:</strong> umožňuje preukázať asociáciu, nie kauzalitu.</li>
  <li><strong>Malý počet udalostí:</strong> zlyhanie obličiek dosiahlo 38 pacientov, čo obmedzuje presnosť viacpremenného modelu a podskupinových záverov.</li>
  <li><strong>Heterogénna kohorta:</strong> MN, MCD a FSGS majú rozdielnu patogenézu, liečbu aj prirodzený priebeh; úprava o diagnózu nemusí odstrániť všetku heterogenitu.</li>
  <li><strong>Reziduálne skreslenie:</strong> pacienti s hematúriou mali vyššiu proteinúriu a častejšiu hypertenziu. V abstrakte nie je uvedené modelovanie liečby, remisie, relapsov ani časovo premenlivých ukazovateľov.</li>
  <li><strong>Laboratórna prenositeľnosť:</strong> definícia vyžadovala tri po sebe nasledujúce mikroskopické nálezy v úzkom časovom okne a nemusí byť reprodukovateľná pri odlišnej metodike.</li>
  <li><strong>Tvrdý, ale úzky výsledok:</strong> sledovalo sa zlyhanie obličiek vyžadujúce chronickú náhradu funkcie; výsledok neodpovedá na všetky otázky o skoršom poklese eGFR, remisii či kvalite života.</li>
</ul>

<h2>Záver</h2>

<p>V kohorte 236 dospelých s biopsiou potvrdenou MN, MCD alebo FSGS bola perzistujúca mikroskopická hematúria častá a po úprave o vybrané klinické a histologické faktory zostala spojená so zlyhaním obličiek. Nález podporuje systematické monitorovanie močového sedimentu ako jednej zo súčastí prognostického hodnotenia.</p>

<p>Najdôležitejším praktickým dôsledkom nie je agresívnejšia liečba samotnej hematúrie, ale presnejšie sledovanie, opätovné posúdenie etiológie a integrácia nálezu s proteinúriou, eGFR, krvným tlakom, histológiou a odpoveďou na liečbu. Na určenie, či zmena alebo vymiznutie hematúrie môže byť terapeutickým ukazovateľom, sú potrebné prospektívne štúdie.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Ștefan G, Petre N, Zugravu A, Stancu S.</strong> <em>Persistent Haematuria Is Associated With Reduced Kidney Survival in Primary Podocytopathies.</em> Nephrology (Carlton). 2026;31(8):e70252. doi: 10.1111/nep.70252. <a href="https://pubmed.ncbi.nlm.nih.gov/42543789/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1111/nep.70252" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Marchel D, Trachtman H, Larkina M, et al.</strong> <em>The Significance of Hematuria in Podocytopathies.</em> Clinical Journal of the American Society of Nephrology. 2024;19(1):56–66. doi: 10.2215/CJN.0000000000000309. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10843204/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes Glomerular Diseases Work Group.</strong> <em>KDIGO 2021 Clinical Practice Guideline for the Management of Glomerular Diseases.</em> Kidney International. 2021;100(4S):S1–S276. <a href="https://kdigo.org/wp-content/uploads/2021/10/KDIGO-2021-Guideline-for-the-Management-of-Glomerular-Diseases.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je retrospektívna kohorta Ștefana a spoluautorov. Číselné výsledky a zoznam premenných v modeli vychádzajú z publikačného abstraktu a bibliografických záznamov PubMed a Crossref. Praktická interpretácia močového sedimentu je doplnená z KDIGO; odlíšenie dôkazu od biologickej hypotézy a terapeutickej extrapolácie je v texte výslovne označené.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza_article',
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
