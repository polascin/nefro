<?php
/**
 * Odborný článok: individuálne určovanie príjmu bielkovín pri CKD.
 */

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
    'title'        => 'Bielkoviny pri CKD: otázka nie je len „koľko“, ale aj „pre koho“',
    'slug'         => 'bielkoviny-ckd-mnozstvo-kvalita-individualizacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pri CKD nerozhoduje len cieľ v g/kg/deň. Správny plán rozlišuje nedialyzovanú CKD, dialýzu, nutričný stav, vek a zdroj bielkovín; vysvetľuje hranice nízko- a veľmi nízkobielkovinových diét.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pri chronickej chorobe obličiek (CKD) nie je príjem bielkovín jediným číslom. Rovnaký cieľ môže byť primeraný pre metabolicky stabilného človeka s progredujúcou nedialyzovanou CKD, ale nevhodný pre pacienta na dialýze, po akútnom ochorení alebo s proteinovo-energetickým chradnutím. Klinický cieľ nie je „jesť čo najmenej bielkovín“, ale chrániť funkciu obličiek bez straty výživového a funkčného stavu.</em></p>

<p>Otázka príjmu bielkovín pri CKD vyvoláva zdanlivo jednoduchú odpoveď: menej bielkovín má znížiť tvorbu dusíkatých metabolitov, fosfátovú nálož a glomerulárnu hyperfiltráciu. Takáto skratka je však nebezpečná. Pri nedostatočnom energetickom príjme, anorexii, zápale alebo krehkosti môže reštrikcia urýchliť úbytok svalovej hmoty, zhoršiť fyzickú výkonnosť a viesť k proteinovo-energetickému chradnutiu (PEW).</p>

<p>Správne položená otázka preto znie: <strong>aký príjem bielkovín je primeraný pre konkrétneho pacienta v konkrétnej fáze choroby a pri akom nutričnom riziku?</strong> Množstvo, zdroj, celkový energetický príjem, laboratórny kontext aj schopnosť diétu dlhodobo dodržiavať sú rovnako dôležité.</p>

<h2>Najprv treba rozlíšiť tri klinické situácie</h2>

<h3>Nedialyzovaná CKD pri stabilnom nutričnom stave</h3>

<p>Tu môže byť riadené obmedzenie bielkovín súčasťou nefroprotektívnej stratégie, najmä pri CKD G3 až G5 s rizikom progresie. Cieľom je znížiť metabolickú záťaž bez zníženia príjmu energie a bez úbytku svalovej hmoty. Ide o diétu vedenú nefrológom a nutričným terapeutom, nie o samovoľné vynechávanie jedál alebo mäsa.</p>

<h3>CKD s podvýživou, krehkosťou alebo katabolizmom</h3>

<p>Neúmyselný úbytok hmotnosti, nízky príjem energie, slabosť, zhoršovanie svalovej sily, akútne ochorenie, zápal alebo hojenie rán menia prioritu. V tejto situácii je najprv potrebné stabilizovať výživu a príčinu katabolizmu. Prísna reštrikcia bielkovín môže byť škodlivá. Vyšší vek sám osebe nie je kontraindikáciou nízkobielkovinovej diéty, ale zvyšuje potrebu systematicky hodnotiť svalovú hmotu, funkciu a celkový príjem potravy.</p>

<h3>Dialyzačná liečba</h3>

<p>Po začatí pravidelnej dialýzy sa pravidlá menia. Pri hemodialýze a peritoneálnej dialýze dochádza k stratám aminokyselín a k ďalšiemu katabolickému stresu; režim určený pre nedialyzovanú CKD sa preto automaticky neprenáša. KDOQI u metabolicky stabilných dospelých na udržiavacej dialýze odporúča vyšší príjem, približne <strong>1,0 až 1,2 g/kg ideálnej telesnej hmotnosti/deň</strong>. Predpis „0,6 g/kg/deň pre každého s CKD“ je preto vecne nesprávny.</p>

<h2>Čo hovoria odporúčania a prečo sa čísla líšia</h2>

<p>KDIGO 2024 odporúča u dospelých s CKD G3 až G5, ktorí nie sú na dialýze, udržiavať príjem bielkovín približne <strong>0,8 g/kg telesnej hmotnosti/deň</strong>. U osôb s rizikom progresie odporúča vyhnúť sa vysokému príjmu nad <strong>1,3 g/kg/deň</strong>. Veľmi nízkobielkovinovú diétu možno zvážiť iba u vybraných, motivovaných a metabolicky stabilných dospelých s CKD G4 až G5, s doplnením esenciálnych aminokyselín alebo ketoanalógov tak, aby celkový príjem dosiahol približne 0,6 g/kg/deň. Takýto postup patrí do špecializovaného nutričného programu.</p>

<p>KDOQI 2020 používa prísnejšie ciele pre metabolicky stabilných dospelých s nedialyzovanou CKD G3 až G5: u pacientov bez diabetu 0,55 až 0,60 g/kg <strong>ideálnej</strong> telesnej hmotnosti/deň, pri diabete 0,6 až 0,8 g/kg/deň. Rozdiel oproti KDIGO neznamená, že jedno odporúčanie je správne a druhé chybné. Odlišujú sa populáciou, hodnotením dôkazov aj tým, akú hmotnosť používajú ako menovateľa.</p>

<p><strong>Praktická nuansa:</strong> zápis „g/kg/deň“ nie je plnohodnotný recept. Treba uviesť, či ide o aktuálnu, ideálnu alebo upravenú telesnú hmotnosť. Pri obezite, edémoch, amputácii alebo rýchlej zmene hmotnosti musí menovateľ určiť nutričný odborník v klinickom kontexte.</p>

<h2>Sila dôkazov: účinok existuje, istota nie je absolútna</h2>

<p>Výsledky štúdií nízkobielkovinových diét nie sú úplne jednotné. Významnou príčinou sú rozdiely v skutočne dosiahnutom príjme bielkovín, energii, nutričnom poradenstve, prítomnosti diabetu, východiskovej eGFR a sledovaných výsledkoch. Úspech diéty sa nedá posúdiť iba podľa toho, čo bolo predpísané; rozhoduje aj adherencia a či pacient pri reštrikcii stále pokrýva energetickú potrebu.</p>

<p>Umbrella review z roku 2025 zahrnula 25 meta-analýz so 47 randomizovanými štúdiami. Pri nízkobielkovinových diétach uviedla strednú istotu dôkazov pre priaznivý vplyv na fosfatémiu a riziko zlyhania obličiek, no pri zmene GFR a pri viacerých ďalších výsledkoch bola istota nízka až veľmi nízka. Výsledok preto podporuje individuálne vedenú diétu, nie univerzálne obmedzenie pre všetkých pacientov s CKD.</p>

<p>Osobitne dôležité je, že pacient so stabilnou eGFR nemusí byť nutrične v poriadku a pacient s pokročilou CKD nemusí automaticky profitovať z najprísnejšej reštrikcie. Rozhodovanie má vyvažovať očakávaný prínos pre progresiu CKD oproti riziku úbytku svalovej hmoty, nižšej výkonnosti a horšej kvality života.</p>

<h2>Starší pacient: nejde o jednoduchý konflikt dvoch odporúčaní</h2>

<p>Geriatrické odporúčania často pracujú s príjmom nad 1,0 g/kg/deň na prevenciu podvýživy a sarkopénie. Tento cieľ však nemožno automaticky preniesť na každého staršieho pacienta s CKD. Spoločný kritický prehľad ERN-ERA a ESPEN odporúča najprv určiť naliehavejší problém: pri dobrom nutričnom stave a progredujúcej pokročilej CKD môže mať prednosť kontrolovaná reštrikcia; pri PEW, podvýžive alebo stabilnej funkcii obličiek treba reštrikciu odložiť alebo jej zabrániť.</p>

<p>V observačnej štúdii EQUAL u ľudí vo veku najmenej 65 rokov s eGFR pod 20 ml/min/1,73 m² nebola nízkobielkovinová diéta predpísaná v bežnej klinickej praxi spojená s vyššou mortalitou ani so zhoršením globálneho nutričného hodnotenia. Keďže išlo o observačné údaje, výsledok nepotvrdzuje bezpečnosť pre každého jednotlivca. Interakcie s vekom nad 75 rokov, nižším nutričným skóre a vyššou komorbiditou naopak zdôrazňujú potrebu častejšieho monitorovania.</p>

<h2>Kvalita bielkovín: rastlinné neznamená automaticky lepšie ani menej hodnotné</h2>

<p>Rastlinné stravovacie vzorce môžu pri CKD zlepšiť príjem vlákniny, znížiť kyslú nálož a znížiť biologickú dostupnosť fosforu, ktorý je v mnohých rastlinných potravinách viazaný vo fytáte. Výhodou môže byť aj nižší podiel ultraprocesovaných mäsových výrobkov s fosfátovými a sodnými aditívami. Klinické výsledky však nemožno prisúdiť jednej aminokyseline alebo jednej potravine; rozhoduje celkový stravovací vzorec.</p>

<p>Koncept PLADO (<em>plant-dominant low-protein diet</em>) opisuje nízkobielkovinový režim s 0,6 až 0,8 g/kg/deň, v ktorom viac než polovica bielkovín pochádza z rastlinných zdrojov. Je to užitočný model na plánovanie jedla, nie univerzálne usmernenie ani dôkaz, že hranica 50 % funguje pre každého pacienta.</p>

<p>Rastlinné bielkoviny netreba označovať za „nekompletné“ v zmysle, že musia byť doplnené v každom jedle. Pri pestrej strave sa esenciálne aminokyseliny bežne dopĺňajú v rámci celého dňa. Pri nízkom celkovom príjme, u staršieho pacienta alebo pri prevažne vegánskej strave však treba cielene posúdiť dostatok bielkovín, energie, leucínu, vitamínu B<sub>12</sub> a ďalších rizikových živín.</p>

<h3>Draslík a fosfor treba posudzovať individuálne</h3>

<p>Rastlinná strava nie je automaticky kontraindikovaná pri CKD ani pri sklonoch k hyperkaliémii. Riziko určuje aktuálna kaliémia, funkcia obličiek, metabolická acidóza, zápcha, lieky blokujúce systém renín – angiotenzín – aldosterón, použitie draselných náhrad soli a konkrétne potraviny. Plošné vylúčenie ovocia, zeleniny a strukovín môže pripraviť pacienta o vlákninu a zhoršiť kvalitu stravy.</p>

<p>Podobne ani nízka vstrebateľnosť fytátového fosforu neznamená voľný príjem každého rastlinného výrobku. Spracované potraviny môžu obsahovať dobre vstrebateľné fosfátové prídavné látky. Rozhodovať má jedálny lístok a laboratórny kontext, nie jednoduchý zoznam „zakázaných“ skupín potravín.</p>

<h2>Ketoanalógy: možnosť pre selektovaného pacienta, nie rutinný doplnok</h2>

<p>Ketoanalógy esenciálnych aminokyselín umožňujú znížiť dusíkovú záťaž veľmi nízkobielkovinovej diéty bez toho, aby pacientovi chýbali prekurzory esenciálnych aminokyselín. Nemajú však samostatný účinok mimo správne nastavenej diéty a bez dostatočného príjmu energie.</p>

<p>Randomizovaná štúdia z roku 2016 ukázala možný prínos vegetariánskej veľmi nízkobielkovinovej diéty s ketoanalógmi u starostlivo vybraných nedialyzovaných pacientov s eGFR pod 30 ml/min/1,73 m², dobrým nutričným stavom a preukázanou adherenciou. Do randomizácie sa však dostalo iba 14 % skrínovaných osôb, čo výrazne obmedzuje prenositeľnosť výsledku do bežnej ambulancie.</p>

<p>Naopak, pragmatická randomizovaná štúdia ERIKA u 223 pacientov s CKD G4 až G5 nepriniesla pri predpísaní veľmi nízkobielkovinovej diéty s ketoanalógmi oproti štandardnej nízkobielkovinovej diéte dodatočný prínos pre prežívanie pacienta ani obličiek. Ukázala aj praktický problém: dlhodobá adherencia k prísnej reštrikcii je nízka. Meta-analýza zo 16 štúdií s 1 344 účastníkmi naznačila priaznivejší vývoj GFR a parametrov minerálového metabolizmu, ale medián sledovania bol iba 13 mesiacov a autori požadujú väčšie dlhodobé štúdie, najmä pri diabete.</p>

<p>Pre prax z toho vyplýva striedmy záver: ketoanalógy možno zvažovať v špecializovanom programe u vhodného a adherentného pacienta, nie ich používať ako univerzálnu náhradu kvalitnej nutričnej starostlivosti.</p>

<h2>Čo pravidelne kontrolovať</h2>

<ul>
  <li><strong>Skutočný príjem potravy a energie:</strong> predpísaná hodnota nie je dôkazom, že pacient jedáva dostatočne.</li>
  <li><strong>Trend hmotnosti:</strong> osobitne neúmyselný úbytok hmotnosti, znížená chuť do jedla a zhoršovanie funkčného stavu.</li>
  <li><strong>Svalovú a funkčnú rezervu:</strong> podľa možností telesnú kompozíciu, obvod svalstva, silu stisku a bežnú mobilitu.</li>
  <li><strong>Laboratórne a metabolické dôsledky:</strong> eGFR a albuminúriu, ureu, bikarbonát, draslík, fosfor, vápnik a podľa klinickej situácie ďalšie parametre CKD-MBD.</li>
  <li><strong>Albumín s kontextom:</strong> sérový albumín nie je samostatným ukazovateľom výživy; ovplyvňuje ho zápal, objemový stav aj strata bielkovín.</li>
  <li><strong>Realizovateľnosť:</strong> cena, dostupnosť potravín, chuťové preferencie, zubný stav, varenie a podpora rodiny rozhodujú o tom, či sa plán dá dlhodobo dodržať.</li>
</ul>

<h2>Praktický postup v ambulancii</h2>

<ol>
  <li><strong>Určte klinickú situáciu.</strong> Rozlíšte nedialyzovanú CKD, dialýzu, akútny katabolický stav a nutričné riziko.</li>
  <li><strong>Posúďte progresiu a výživu súčasne.</strong> Samotná eGFR nestačí; význam má aj albuminúria, trend funkcie, hmotnosť, svalová sila a príjem energie.</li>
  <li><strong>Zvoľte realistický cieľ.</strong> Pri stabilnej nedialyzovanej CKD môže byť primeraná riadená redukcia; pri PEW, podvýžive alebo katabolizme nie je prísna reštrikcia prioritou.</li>
  <li><strong>Pracujte s kvalitou celej stravy.</strong> Uprednostnite málo spracované potraviny a primeraný podiel rastlinných zdrojov, ale individualizujte draslík, fosfor, sodík a energiu.</li>
  <li><strong>Po každej zmene znova merajte výsledok.</strong> Ak pacient chudne, slabne, nedosahuje energetický príjem alebo sa zhoršuje funkcia, plán treba upraviť, nie ďalej sprísňovať.</li>
</ol>

<h2>Záver</h2>

<p>Príjem bielkovín pri CKD nemožno redukovať na univerzálnu hranicu. Pri metabolicky stabilnej nedialyzovanej CKD môže nízkobielkovinová diéta podporiť kontrolu metabolických komplikácií a u vybraných pacientov spomaliť postup choroby. Pri dialýze, podvýžive, krehkosti a katabolizme však rovnaký prístup môže byť nevhodný.</p>

<p>Najbezpečnejší postup je individualizovať cieľ podľa fázy CKD, nutričnej a funkčnej rezervy, zdrojov bielkovín, energetického príjmu a opakovaného monitorovania. Nejde o voľbu medzi „proteínovou posadnutosťou“ a slepou reštrikciou, ale o presne vedenú nutričnú intervenciu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=mierne-obmedzenie-bielkovin-ckd-prognoza">Mierne obmedzenie bielkovín môže pri CKD zlepšiť prognózu</a></li>
  <li><a href="article.php?slug=vyssi-prijem-bielkovin-merana-gfr-renis">Vyšší príjem bielkovín a funkcia obličiek: desaťročná kohorta nezistila rýchlejší pokles meranej GFR</a></li>
  <li><a href="article.php?slug=vegetarianska-strava-riziko-ckd-uk-biobank">Vegetariánska strava a nižšie riziko vzniku chronickej choroby obličiek v UK Biobank: čo z toho platí pre prax</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<ol>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Ikizler TA, Burrowes JD, Byham-Gray LD, et al.</strong> <em>KDOQI Clinical Practice Guideline for Nutrition in CKD: 2020 Update.</em> American Journal of Kidney Diseases. 2020;76(3 Suppl 1):S1–S107. doi: 10.1053/j.ajkd.2020.05.006. <a href="https://pubmed.ncbi.nlm.nih.gov/32829751/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Amiri Khosroshahi R, Zare M, Zeraattalab-Motlagh S, et al.</strong> <em>Effects of a Low-Protein Diet on Kidney Function in Patients With Chronic Kidney Disease: An Umbrella Review of Systematic Reviews and Meta-analyses of Randomized Controlled Trials.</em> Nutrition Reviews. 2025;83(7):e2127–e2138. doi: 10.1093/nutrit/nuae178. <a href="https://pubmed.ncbi.nlm.nih.gov/39657217/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Fouque D, Mafra D, Bellizzi V.</strong> <em>Dietary Protein Intake in CKD: Quantity and Quality.</em> Clinical Journal of the American Society of Nephrology. 2026;21(3):497–505. doi: 10.2215/CJN.0000000777. <a href="https://pubmed.ncbi.nlm.nih.gov/40459947/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Piccoli GB, Cederholm T, Avesani CM, et al.</strong> <em>Nutritional status and the risk of malnutrition in older adults with chronic kidney disease: implications for low protein intake and nutritional care.</em> Clinical Nutrition. 2023;42(4):443–457. doi: 10.1016/j.clnu.2023.01.018. <a href="https://pubmed.ncbi.nlm.nih.gov/36857954/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Windahl K, Chesnaye NC, Faxén Irving G, et al.</strong> <em>The safety of a low-protein diet in older adults with advanced chronic kidney disease.</em> Nephrology Dialysis Transplantation. 2024;39(11):1867–1875. doi: 10.1093/ndt/gfae077. <a href="https://pubmed.ncbi.nlm.nih.gov/38544335/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Carrero JJ, González-Ortiz A, Avesani CM, et al.</strong> <em>Plant-based diets to manage the risks and complications of chronic kidney disease.</em> Nature Reviews Nephrology. 2020;16(9):525–542. doi: 10.1038/s41581-020-0297-2. <a href="https://pubmed.ncbi.nlm.nih.gov/32528189/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Chen CH, Tsai PH, Tsai WC, et al.</strong> <em>Effects of ketoanalogue-supplemented protein-restricted diets in advanced chronic kidney disease: a systematic review and meta-analysis.</em> Journal of Nephrology. 2024;37(8):2113–2125. doi: 10.1007/s40620-024-02065-9. <a href="https://pubmed.ncbi.nlm.nih.gov/39340710/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Garneata L, Stancu A, Dragomir D, et al.</strong> <em>Ketoanalogue-Supplemented Vegetarian Very Low-Protein Diet and CKD Progression.</em> Journal of the American Society of Nephrology. 2016;27(7):2164–2176. doi: 10.1681/ASN.2015040369. <a href="https://pubmed.ncbi.nlm.nih.gov/26823552/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bellizzi V, Signoriello S, Minutolo R, et al.</strong> <em>No additional benefit of prescribing a very low-protein diet in patients with advanced chronic kidney disease under regular nephrology care: a pragmatic, randomized, controlled trial.</em> American Journal of Clinical Nutrition. 2022;115(5):1404–1417. doi: 10.1093/ajcn/nqab417. <a href="https://pubmed.ncbi.nlm.nih.gov/34967847/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie. Výživový plán pri CKD má viesť nefrológ v spolupráci s nutričným terapeutom so skúsenosťou s ochoreniami obličiek.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
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
?>