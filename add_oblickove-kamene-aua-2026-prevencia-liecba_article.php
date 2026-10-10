<?php

/**
 * Prakticky nefrologicky prehlad AUA 2026 pre medicinsky manazment nefrolitiazy.
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
    'title'        => 'Obličkové kamene podľa AUA 2026: metabolické vyšetrenie, prevencia a liečba',
    'slug'         => 'oblickove-kamene-aua-2026-prevencia-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický nefrologický prehľad AUA 2026: koho metabolicky vyšetriť, ako interpretovať 24-hodinový moč, cieliť diétu a lieky a bezpečne sledovať odpoveď.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Prevencia recidívy nefrolitiázy sa nezačína univerzálnym zákazom „oxalátových potravín“ ani automatickým predpisom lieku. Aktualizované odporúčanie American Urological Association (AUA) z roku 2026 spája skríning, analýzu kameňa, metabolické vyšetrenie, cielenú úpravu stravy a farmakoterapiu s kontrolou odpovede a nežiaducich účinkov. Pre nefrológa je rozhodujúce rozlíšiť všeobecnú prevenciu od liečby konkrétneho fenotypu.</em></p>

<figure class="article-figure">
  <a href="img/oblickove-kamene-aua-2026-prevencia-liecba.png" target="_blank" rel="noopener noreferrer">
    <img src="img/oblickove-kamene-aua-2026-prevencia-liecba.webp" alt="Schéma metabolického vyšetrenia, cielenej prevencie a následného sledovania pacienta s obličkovým kameňom" width="1586" height="992" loading="lazy">
  </a>
  <figcaption>Medicínsky manažment nefrolitiázy je cyklus: zhodnotenie rizika a fenotypu, cielená intervencia a následná kontrola účinnosti aj bezpečnosti. Ilustrácia je schematická.</figcaption>
</figure>

<p>Dokument AUA 2026 je rozdelený na dve vzájomne sa dopĺňajúce časti. Prvá sa venuje vyšetreniu pacienta a diétnemu manažmentu kalciových kameňov, druhá farmakologickej liečbe, ďalším typom kameňov a následnému sledovaniu. Nejde o odporúčanie pre akútnu obštrukciu, infikovaný obštrukčný systém ani voľbu operačnej techniky. Tie patria do urgentného a chirurgického manažmentu.</p>

<h2>Najprv vylúčiť situáciu, ktorá nepatrí do ambulantnej prevencie</h2>

<p>Horúčka alebo sepsa pri obštrukcii, anúria, solitárna oblička s obštrukciou, nezvládnuteľná bolesť alebo vracanie, významné akútne poškodenie obličiek a obojstranná obštrukcia vyžadujú urgentné urologické posúdenie. Metabolická prevencia sa rieši až po stabilizácii akútneho stavu.</p>

<h2>Skríningové vyšetrenie každého pacienta</h2>

<p>Pri novodiagnostikovanom kameni má základné vyšetrenie obsahovať podrobnú osobnú, rodinnú, liekovú a diétnu anamnézu, fyzikálne vyšetrenie, základné sérové parametre a vyšetrenie moču vrátane mikroskopie. Prakticky treba hľadať najmä:</p>

<ul>
  <li>predchádzajúce epizódy, zákroky, infekcie močových ciest a rast kameňov v čase;</li>
  <li>množstvo tekutín, príjem sodíka, vápnika, živočíšnych bielkovín, oxalátu a doplnkov výživy;</li>
  <li>črevné ochorenie, malabsorpciu alebo bariatrický výkon, dnu, diabetes, obezitu a kostné ochorenie;</li>
  <li>lieky podporujúce tvorbu kameňov, napríklad topiramát, acetazolamid, triamterén alebo niektoré antivirotiká;</li>
  <li>v sére najmä kreatinín, elektrolyty, hydrogénuhličitan, vápnik a urát podľa klinického kontextu.</li>
</ul>

<p>Intaktný parathormón sa stanovuje pri podozrení na primárnu hyperparatyreózu, najmä pri hyperkalciémii alebo neprimerane vysokom normálnom vápniku. Ak je kameň dostupný, má sa aspoň raz analyzovať validovanou metódou. Dostupné zobrazovanie treba prehodnotiť z hľadiska počtu, veľkosti, lokalizácie a prípadnej nefrokalcinózy.</p>

<h2>Kto potrebuje rozšírené metabolické vyšetrenie</h2>

<p>Rozšírené vyšetrenie je určené rekurentným pacientom a vysokorizikovým alebo motivovaným pacientom po prvej epizóde. Vyššie riziko naznačujú napríklad mnohopočetné alebo obojstranné kamene, nefrokalcinóza, rodinná záťaž, detský alebo mladý vek, solitárna oblička, chronická choroba obličiek, črevná malabsorpcia, primárna hyperoxalúria, cystinúria, urátové, brushitové alebo infekčné kamene a rýchly rast či časté zákroky.</p>

<p>Obezita alebo nízky vek samy osebe ešte automaticky neznamenajú indikáciu na rozšírené vyšetrenie. Rozhoduje súhrn klinického rizika, kamenná aktivita a to, či výsledok vyšetrenia zmení liečbu.</p>

<h2>24-hodinový moč: čo merať a ako ho interpretovať</h2>

<p>AUA odporúča jednu alebo dve 24-hodinové zbierky moču počas bežnej stravy. Mnohé centrá uprednostňujú dve zbierky, pretože denná variabilita môže zmeniť interpretáciu. Minimálny panel zahŕňa:</p>

<ul>
  <li>objem moču a pH;</li>
  <li>vápnik, oxalát, urát a citrát;</li>
  <li>sodík, draslík a kreatinín.</li>
</ul>

<p>Laboratórium môže doplniť močovinu, síran, fosfát, horčík a výpočet presýtenia podľa lokálneho protokolu, nejde však o povinné minimum pôvodného jadrového panelu. Kreatinín a klinický kontext pomáhajú posúdiť úplnosť zberu. Výsledok treba interpretovať spolu so zložením kameňa, stravou, liekmi, telesnou veľkosťou a funkciou obličiek.</p>

<h2>Hydratácia: cieľom je moč, nie počet pohárov</h2>

<p>Všeobecným cieľom u dospelých tvorcov kameňov je príjem tekutín postačujúci na dosiahnutie objemu moču najmenej <strong>2,5 litra denne</strong>. Potrebný príjem sa mení podľa potenia, klímy, telesnej aktivity, hnačky a stravy. Pri cystinúrii sa spravidla cieli ešte vyššia diuréza, často aspoň 3 litre denne, ak to dovoľuje kardiálny a renálny stav.</p>

<p>Pacient so srdcovým zlyhávaním, pokročilou chronickou chorobou obličiek alebo hyponatriémiou nemá dostať mechanický príkaz na vysoký príjem tekutín bez individuálneho posúdenia. Cieľ diurézy musí byť bezpečný.</p>

<h2>Kalciové kamene: normálny vápnik, menej sodíka, cielený oxalát</h2>

<h3>Hyperkalciúria</h3>

<p>Pri kalciových kameňoch a vysokom močovom vápniku sa odporúča obmedziť sodík a zachovať normálny príjem vápnika zo stravy, približne 1 000 až 1 200 mg denne u väčšiny dospelých. Nízkovápniková diéta môže zvýšiť črevnú absorpciu oxalátu a riziko kalcium-oxalátových kameňov.</p>

<p>Ak diéta nestačí a kamene recidivujú, možno ponúknuť tiazidové alebo tiazidom podobné diuretikum. Účinok závisí aj od kontroly sodíka. Treba sledovať tlak krvi, sodík, draslík, kreatinín, glukózu a urát; zvážiť treba riziko hypotenzie, hypokaliémie, hyponatriémie, hyperurikémie a poruchy glukózovej tolerancie.</p>

<h3>Hyperoxalúria</h3>

<p>Pri vysokom močovom oxaláte sa obmedzujú najmä potraviny s veľmi vysokým obsahom oxalátu, nie bezhlavo celé skupiny rastlinných potravín. Vápnik zo stravy sa prijíma spolu s jedlom, aby viazal oxalát v čreve. Pri enterickej hyperoxalúrii môže byť potrebný vápnik s jedlom, liečba malabsorpcie a špecializovaný diétny plán. Vysoké dávky vitamínu C môžu zvyšovať oxalúriu.</p>

<h3>Hypocitratúria</h3>

<p>Pri nízkom močovom citráte sa zvyšuje podiel ovocia a zeleniny a obmedzuje nadmerná záťaž kyselinotvornými živočíšnymi bielkovinami. Pri rekurentných kalciových kameňoch a nízkom citráte je štandardnou možnosťou citrát draselný. Liečba vyžaduje sledovanie kaliémie, funkcie obličiek, hydrogénuhličitanu a močového pH. Pri pokročilej CKD alebo riziku hyperkaliémie môže byť nevhodná.</p>

<p>Nadmerná alkalizácia môže zvyšovať presýtenie kalcium-fosfátom. Cieľ pH sa preto neurčuje izolovane bez znalosti zloženia kameňa a ostatných parametrov moču.</p>

<h3>Hyperurikozúria pri kalcium-oxalátových kameňoch</h3>

<p>Allopurinol možno ponúknuť pacientom s rekurentnými kalcium-oxalátovými kameňmi, hyperurikozúriou a normálnym močovým vápnikom. Nie je univerzálnou liečbou všetkých kalciových kameňov. Pred liečbou a počas nej treba zohľadniť funkciu obličiek, interakcie, krvný obraz a hepatálne parametre podľa klinickej situácie.</p>

<p>Test HLA-B*58:01 sa nerobí plošne každému. Zvažuje sa pred začatím allopurinolu u populácií s vyššou prevalenciou alely a rizikom závažných kožných reakcií, najmä pri niektorých východo- a juhovýchodoázijských pôvodoch a u Afroameričanov, podľa miestnych farmakogenetických odporúčaní.</p>

<h3>Recidíva bez jasnej metabolickej abnormality</h3>

<p>Ak rekurentné kalciové kamene pretrvávajú napriek úprave stravy a 24-hodinový moč neukazuje jednoznačný cieľ, AUA umožňuje zvážiť tiazid a/alebo citrát draselný. Ide o spoločné rozhodovanie po zohľadnení aktivity ochorenia, kontraindikácií a monitorovacej záťaže, nie o povinnú automatickú kombináciu.</p>

<h2>Urátové kamene</h2>

<p>Najčastejším hnacím mechanizmom je nízke pH moču, preto je prvou líniou alkalizácia, typicky citrátom draselným, s domácim sledovaním pH. Pri prevencii sa často cieli pH približne 6,0 až 6,5; pri rozpúšťaní môže byť cieľ vyšší podľa odborného plánu. Príliš vysoké pH podporuje kalcium-fosfátové presýtenie.</p>

<p>Allopurinol ani febuxostat nie sú rutinnou prvou líniou urátovej nefrolitiázy, ak hlavným problémom zostáva kyslý moč. Uplatnenie majú pri vybranej hyperurikozúrii, dne alebo inej samostatnej indikácii. Súčasťou liečby je redukcia nadmerného príjmu purínov a manažment metabolického syndrómu.</p>

<h2>Cystinúria a cystínové kamene</h2>

<p>Základom je vysoká diuréza, obmedzenie sodíka a alkalizácia moču, zvyčajne s cieľom pH okolo 7,0 až 7,5 podľa tolerancie a sledovania. Ak kamene recidivujú napriek týmto opatreniam, možno pridať cystín viažuci tiolový liek, najčastejšie tiopronín. Liečba patrí do skúseného centra a vyžaduje monitorovanie nežiaducich účinkov a adherencie.</p>

<h2>Infekčné a struvitové kamene</h2>

<p>Pri struvitových kameňoch je základom maximálne možné odstránenie kameňa a kontrola infekcie baktériami produkujúcimi ureázu. Acetohydroxámová kyselina môže byť možnosťou pri reziduálnom alebo rekurentnom struvitovom kameni, keď definitívna chirurgická liečba nie je možná. Pre časté a závažné nežiaduce účinky nejde o bežnú prvú voľbu.</p>

<h2>Primárna hyperoxalúria</h2>

<p>Pri podozrení na primárnu hyperoxalúriu je potrebná genetická a metabolická diagnostika v špecializovanom centre. Pyridoxín pomáha iba pri citlivých genotypoch primárnej hyperoxalúrie typu 1, nie univerzálne pri každej hyperoxalúrii. RNA-interferenčné lieky, lumasiran a nedosiran, majú špecifické regulačné indikácie a dávkovanie; ich použitie sa riadi typom ochorenia, vekom, funkciou obličiek a aktuálnymi podmienkami úhrady.</p>

<h2>Kontrola účinku a bezpečnosti</h2>

<p>Po začatí diétnych alebo liekových opatrení sa má získať kontrolný 24-hodinový moč <strong>do šiestich mesiacov</strong>, nie automaticky presne po troch mesiacoch. Pri stabilnom náleze sa zber opakuje približne raz ročne; pri vysokej aktivite, zmene liečby alebo nedostatočnej odpovedi častejšie.</p>

<p>Periodické krvné testy majú cieliť na nežiaduce účinky konkrétnej liečby. Neexistuje jeden univerzálny interval ani rovnaký „základný metabolický panel“ pre všetkých. Zobrazovanie sa opakuje podľa kamennej aktivity, symptómov, typu kameňa a radiačnej záťaže. Ultrasonografia, natívna snímka a nízkodávkové CT nie sú zameniteľné; voľba závisí od klinickej otázky a rádiopacity kameňa.</p>

<h2>Praktický algoritmus pre nefrologickú ambulanciu</h2>

<ol>
  <li>Vylúčiť urgentnú obštrukciu alebo infekciu a získať urologický plán.</li>
  <li>Urobiť skríningové vyšetrenie, analyzovať dostupný kameň a zhodnotiť zobrazovanie.</li>
  <li>Určiť riziko recidívy a indikáciu rozšíreného metabolického vyšetrenia.</li>
  <li>Získať jednu alebo dve kvalitné 24-hodinové zbierky moču počas bežnej stravy.</li>
  <li>Stanoviť bezpečný cieľ diurézy a fenotypovo cielenú diétu.</li>
  <li>Pridať liek iba pri jasnej indikácii alebo pri zdôvodnenej empirickej prevencii rekurentných kalciových kameňov.</li>
  <li>Naplánovať laboratórnu bezpečnostnú kontrolu a kontrolný moč do šiestich mesiacov.</li>
  <li>Ďalšie kontroly a zobrazovanie prispôsobiť aktivite ochorenia.</li>
</ol>

<h2>Čo sa oproti zjednodušenému prístupu mení</h2>

<p>Najväčšou zmenou nie je jeden nový liek. Je ňou dôsledné prepojenie rizikovej stratifikácie, metabolického fenotypu, merateľných cieľov a kontroly odpovede. „Pite viac“ bez cieľa diurézy, plošné obmedzenie vápnika, citrát bez sledovania pH a kaliémie alebo allopurinol bez správnej indikácie nie sú personalizovanou prevenciou.</p>

<p>Nové možnosti pri primárnej hyperoxalúrii rozširujú liečbu zriedkavých genetických príčin, ale nemenia základ pre väčšinu pacientov: kvalitný zber moču, primeraná hydratácia, normálny príjem vápnika, kontrola sodíka a fenotypovo cielená liečba.</p>

<h2>Záver</h2>

<p>AUA guideline 2026 podporuje aktívny, merateľný a individualizovaný manažment nefrolitiázy. Nefrológ má osobitnú úlohu pri interpretácii metabolických nálezov, liečbe systémových príčin, bezpečnom použití tiazidov a alkálií a pri koordinácii starostlivosti s urológom, dietológom, klinickým genetikom a pediatrom.</p>

<p>Najlepší preventívny plán nie je najkomplikovanejší. Je to plán, ktorý zodpovedá typu kameňa a močovému fenotypu, rešpektuje funkciu obličiek a komorbidity a ktorého účinok sa skutočne skontroluje.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Margaret S. Pearle, Brian R. Matlaga, Jodi A. Antonelli, Gary N. Asher, Thomas Chi, Ryan S. Hsi, Sennett K. Kim, Erin Kirkby, Bodo Knudsen, Kevin Koo, Naim M. Maalouf, Vernon M. Pais Jr, Ann Paris, Kristina L. Penniston, Kymora B. Scotland, Necole Streeper, Gregory Tasian, Kyle D. Wood, Justin B. Ziemba.</strong> <em>Medical Management of Kidney Stones: AUA Guideline (2026) Part I: Evaluation of Patients with Kidney Stones and Dietary Management of Patients with Calcium Stones.</em> Journal of Urology. Publikované online 30. júla 2026. doi: 10.1097/JU.0000000000005227. <a href="https://pubmed.ncbi.nlm.nih.gov/42529981/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1097/JU.0000000000005227" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Margaret S. Pearle, Brian R. Matlaga, Jodi A. Antonelli, Gary N. Asher, Thomas Chi, Ryan S. Hsi, Sennett K. Kim, Erin Kirkby, Bodo Knudsen, Kevin Koo, Naim M. Maalouf, Vernon M. Pais Jr, Ann Paris, Kristina L. Penniston, Kymora B. Scotland, Necole Streeper, Gregory Tasian, Kyle D. Wood, Justin B. Ziemba.</strong> <em>Medical Management of Kidney Stones: AUA Guideline (2026) Part II: Treatment and Follow-Up of Kidney Stones.</em> Journal of Urology. Publikované online 30. júla 2026. doi: 10.1097/JU.0000000000005228. <a href="https://pubmed.ncbi.nlm.nih.gov/42529979/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1097/JU.0000000000005228" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Gerlineke Hawkins-van der Cingel.</strong> <em>Ten tips on the work-up and management of CKD patients with nephrolithiasis.</em> Clinical Kidney Journal. 2026;19(1):sfaf353. doi: 10.1093/ckj/sfaf353. <a href="https://pubmed.ncbi.nlm.nih.gov/41498064/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12766456/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Daniel A. Wollin, Aaron G. Kaplan, Glenn M. Preminger, Pietro M. Ferraro, Antonio Nouvenne, Andrea Tasca, Elisabetta Croppi, Giovanni Gambaro, Ita P. Heilberg.</strong> <em>Defining metabolic activity of nephrolithiasis — appropriate evaluation and follow-up of stone formers.</em> Asian Journal of Urology. 2018;5(4):235–242. doi: 10.1016/j.ajur.2018.06.007. <a href="https://pubmed.ncbi.nlm.nih.gov/30364613/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6197397/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Článok je praktickým odborným spracovaním oboch častí AUA guideline 2026, doplneným nefrologickým pohľadom. Nie všetky odporúčania majú rovnakú silu dôkazov; viaceré vychádzajú z klinických princípov alebo expertného názoru. Presné autorstvo, DOI a PubMed identifikátory oboch častí boli overené cez PubMed E-utilities, Crossref a metaúdaje vydavateľa. Dávkovanie liekov, konkrétne cieľové pH a frekvencia kontrol sa musia individualizovať podľa zloženia kameňa, funkcie obličiek, komorbidít a lokálnych regulačných podmienok.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_oblickove-kamene-aua-2026-prevencia-liecba_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
      <link rel="stylesheet" href="index.css?v=20260509-1&amp;cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>
          <?php if (!empty($errors)): ?>
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
