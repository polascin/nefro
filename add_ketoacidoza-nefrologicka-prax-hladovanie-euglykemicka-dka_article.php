<?php
/**
 * add_ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): Ketoacidóza v nefrologickej praxi —
 * od hladovej a alkoholovej ketoacidózy cez diabetickú a euglykemickú DKA až po
 * graviditu a dialýzu. Slovenské odborné spracovanie s dôrazom na acidobázickú
 * interpretáciu, kaliémiu a nefrologické súvislosti. Primárny zdroj: Palmer &
 * Clegg, Core Curriculum 2026 (AJKD). Pôvodní autori zdroja sú v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka_article.php"
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
    'title'        => 'Ketoacidóza v nefrologickej praxi: od hladovania po euglykemickú diabetickú ketoacidózu',
    'slug'         => 'ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prehľad ketoacidózy pre nefrológa: od hladovej a alkoholovej formy cez diabetickú a euglykemickú DKA až po graviditu a dialýzu. S dôrazom na acidobázickú interpretáciu, kaliémiu, β-hydroxybutyrát a individualizáciu liečby pri chronickej chorobe obličiek.',
    'content'      => <<<'HTML'
<h2>Klinický význam</h2>

<p>Ketoacidóza je život ohrozujúca metabolická acidóza spôsobená nadmernou tvorbou ketolátok, predovšetkým β-hydroxybutyrátu a acetoacetátu. Hoci sa najčastejšie spája s diabetickou ketoacidózou (DKA), vzniká aj pri hladovaní, nadmernom požívaní alkoholu, v gravidite, pri veľmi nízkosacharidových diétach a pri liečbe inhibítormi SGLT2.</p>

<p>Pre nefrológa je rozhodujúce rýchlo rozpoznať acidobázický obraz, vyhodnotiť objemovú depléciu a akútne poškodenie obličiek (AKI), správne interpretovať kaliémiu a odlíšiť ketoacidózu od laktátovej acidózy, intoxikácií či renálnej insuficiencie. Normoglykémia alebo iba mierna hyperglykémia DKA nevylučujú.</p>

<h2>Ketóza nie je automaticky ketoacidóza</h2>

<p>Fyziologická ketóza je adaptácia na obmedzený prísun sacharidov. Pri poklese inzulínu a vzostupe glukagónu sa aktivuje lipolýza, oxidácia mastných kyselín a hepatálna tvorba ketolátok. Počas krátkodobého hladovania je tento proces regulovaný a acidobázická rovnováha býva zachovaná alebo len mierne narušená.</p>

<p>Ketoacidóza vzniká vtedy, keď produkcia ketolátok prekročí ich periférne využitie a schopnosť obličiek vylučovať kyselinovú záťaž. Dôležitý je pomer inzulínu ku glukagónu, dostupnosť sacharidov, objemový stav, renálna funkcia, prítomnosť infekcie alebo iného stresového podnetu a pri alkoholovej ketoacidóze aj redoxný stav organizmu.</p>

<p>Hlavnými ketolátkami sú acetoacetát a β-hydroxybutyrát. Pri ketoacidóze, najmä diabetickej a alkoholovej, býva dominantný β-hydroxybutyrát. Bežný nitroprusidový test v moči ho nezachytáva. Na diagnostiku a monitorovanie je preto vhodnejšie priame stanovenie β-hydroxybutyrátu v krvi.</p>

<h2>Hladová ketoacidóza</h2>

<p>Po približne 24 hodinách bez adekvátneho príjmu potravy sa vyčerpávajú zásoby hepatálneho glykogénu. Zvyšuje sa glukoneogenéza a lipolýza, mastné kyseliny sa v pečeni menia na ketolátky. Pri dlhšom hladovaní sa mozog postupne viac adaptuje na využívanie ketolátok, čím sa znižuje potreba glukózy a proteolýza.</p>

<p>U zdravého človeka býva hladová ketóza zvyčajne limitovaná. Závažnejšia acidóza sa môže vyskytnúť pri dlhodobom hladovaní, vracaní, malnutrícii, gravidite, interkurentnom ochorení alebo pri súčasnej poruche funkcie obličiek.</p>

<p>Obličky majú v tejto situácii ochrannú úlohu. Zvyšujú amoniogenézu z glutamínu, vylučujú amónium s aniónmi ketolátok a regenerujú bikarbonát. Pri pokročilej chronickej chorobe obličiek (CKD) je táto adaptačná kapacita znížená, preto môže byť acidémia pri porovnateľnej ketogenéze výraznejšia.</p>

<h2>Diabetická ketoacidóza</h2>

<p>DKA vzniká pri absolútnom alebo relatívnom nedostatku inzulínu v kombinácii so vzostupom kontraregulačných hormónov, najmä glukagónu, katecholamínov, kortizolu a rastového hormónu. Následkom sú:</p>

<ul>
  <li>zvýšená hepatálna glukoneogenéza a glykogenolýza,</li>
  <li>znížené periférne využitie glukózy,</li>
  <li>aktivácia lipolýzy,</li>
  <li>zvýšená produkcia β-hydroxybutyrátu a acetoacetátu,</li>
  <li>hyperglykémia, osmotická diuréza, hypovolémia a celkový deficit elektrolytov.</li>
</ul>

<p>Podľa medzinárodného konsenzu z roku 2024 vyžaduje diagnóza DKA tri súčasné zložky: diabetes alebo hyperglykémiu, ketonémiu a metabolickú acidózu. Priame stanovenie β-hydroxybutyrátu v koncentrácii najmenej 3,0 mmol/l má vysokú diagnostickú presnosť.</p>

<p>Najčastejšími precipitujúcimi faktormi sú infekcia a vynechanie alebo nedostatočná aplikácia inzulínu. Dôležité sú aj infarkt myokardu, cievna mozgová príhoda, pankreatitída, trauma, chirurgický výkon, alkohol, psychické a sociálne faktory, glukokortikoidy, antipsychotiká a inhibítory imunitných kontrolných bodov.</p>

<h2>Euglykemická DKA a inhibítory SGLT2</h2>

<p>Euglykemická DKA je ketoacidóza s normálnou alebo len mierne zvýšenou glykémiou, zvyčajne pod 11,1 mmol/l. Diagnostické oneskorenie hrozí práve preto, že klinik môže pri normálnej glykémii ketoacidózu nesprávne vylúčiť.</p>

<p>V súčasnosti je významným rizikovým faktorom liečba inhibítorom SGLT2. Tieto lieky majú preukázaný kardiovaskulárny a nefroprotektívny prínos pri diabete, srdcovom zlyhávaní a CKD, no môžu zvýšiť riziko ketoacidózy, najmä pri relatívnom nedostatku inzulínu.</p>

<p>Riziko zvyšujú najmä:</p>

<ul>
  <li>vynechanie alebo redukcia inzulínu,</li>
  <li>dlhšie hladovanie a perioperačné obdobie,</li>
  <li>akútna infekcia alebo iný závažný stres,</li>
  <li>dehydratácia,</li>
  <li>nadmerný príjem alkoholu,</li>
  <li>veľmi nízkosacharidová alebo ketogénna diéta,</li>
  <li>predtým nerozpoznaný autoimunitný diabetes.</li>
</ul>

<p>Pri plánovaných operáciách sa preto inhibítor SGLT2 zvyčajne vysadzuje niekoľko dní vopred (podľa odporúčaní spravidla 3–4 dni). U pacienta liečeného inhibítorom SGLT2 s nauzeou, vracaním, bolesťou brucha, tachypnoe, malátnosťou alebo nevysvetliteľnou metabolickou acidózou treba vyšetriť β-hydroxybutyrát aj pri glykémii, ktorá nevyzerá alarmujúco.</p>

<h2>Kaliémia: sérová hodnota môže byť klamlivá</h2>

<p>V DKA býva sérová koncentrácia draslíka normálna alebo zvýšená napriek významnému celkovému deficitu draslíka. Hlavnými mechanizmami sú nedostatok inzulínu, hypertonicita a renálne straty draslíka pri osmotickej diuréze a sekundárnom hyperaldosteronizme.</p>

<p>Po začatí inzulínovej liečby sa draslík presúva do buniek a môže rýchlo vzniknúť život ohrozujúca hypokaliémia. Preto je nevyhnutné opakované sledovanie kaliémie a individualizovaná substitúcia. Podľa medzinárodného konsenzu z roku 2024 sa má podanie inzulínu odložiť, ak je sérový draslík pod 3,5 mmol/l (staršie odporúčania uvádzali hranicu 3,3 mmol/l), a to až do jeho doplnenia. Substitúciu draslíka treba pritom začať už vtedy, keď kaliémia klesne do horného pásma normy (približne pod 5,0–5,3 mmol/l), za priebežného monitorovania.</p>

<p>Hyperkaliémia pri DKA neznamená, že pacient má nadbytok draslíka. Naopak, pri rozvinutej osmotickej diuréze môže byť celkový deficit výrazný.</p>

<h2>Acidobázická interpretácia</h2>

<p>Typickým nálezom pri DKA je metabolická acidóza so zvýšeným aniónovým rozdielom. Vypočíta sa ako:</p>

<p><strong>Aniónový rozdiel = Na<sup>+</sup> − (Cl<sup>−</sup> + HCO<sub>3</sub><sup>−</sup>)</strong></p>

<p>Normálny aniónový rozdiel je približne 8–12 mmol/l (závisí od laboratória). Pri hypoalbuminémii, ktorá je pri malnutrícii, alkoholovej ketoacidóze aj v kritickom stave bežná, býva nameraný aniónový rozdiel falošne nízky; za každých 10 g/l poklesu albumínu pod normu treba k nameranej hodnote pripočítať približne 2,5 mmol/l, inak sa zvýšený rozdiel môže prehliadnuť.</p>

<p>Treba však myslieť aj na zmiešané poruchy. Pomôckou je porovnanie vzostupu aniónového rozdielu s poklesom bikarbonátu (tzv. delta pomer): ak je vzostup aniónového rozdielu výrazne menší než pokles bikarbonátu, ide o kombináciu s hyperchloremickou acidózou; ak je pokles bikarbonátu menší než vzostup rozdielu, treba pomyslieť na súčasnú metabolickú alkalózu. Vracanie tak môže vyvolať metabolickú alkalózu, hyperventilácia respiračnú alkalózu a následná liečba väčším objemom roztokov s vysokým obsahom chloridov môže viesť k hyperchloremickej metabolickej acidóze s normálnym aniónovým rozdielom.</p>

<p>Pôvodný zdroj správne zdôrazňuje, že po liečbe DKA môže pretrvávať hyperchloremická acidóza aj napriek ustupujúcej ketóze. Tento obraz nesmie byť automaticky interpretovaný ako pretrvávajúca DKA. Základným markerom ústupu ketoacidózy je pokles β-hydroxybutyrátu spolu s klinickým zlepšením a normalizáciou pH alebo bikarbonátu.</p>

<p>Tvrdenie, že DKA sa v najskoršej fáze vždy začína hyperchloremickou acidózou s normálnym aniónovým rozdielom, je však príliš kategorické. V klinickej praxi sa väčšina pacientov prezentuje už so zvýšeným aniónovým rozdielom a často so zmiešanou acidobázickou poruchou.</p>

<h2>Alkoholová ketoacidóza</h2>

<p>Alkoholová ketoacidóza sa typicky rozvíja po epizóde nadmerného pitia alkoholu spojenej s nízkym príjmom potravy a vracaním. Charakteristická je zvýšená tvorba β-hydroxybutyrátu, hypovolémia, často hypoglykémia alebo normoglykémia a zmiešaná acidobázická porucha.</p>

<p>Metabolizmus etanolu zvyšuje pomer NADH/NAD<sup>+</sup>, čo podporuje tvorbu β-hydroxybutyrátu a laktátu a zároveň tlmí glukoneogenézu. Výrazná laktátová acidóza nie je pre čistú alkoholovú ketoacidózu typická. Ak je laktát výrazne zvýšený, treba aktívne hľadať sepsu, hypoperfúziu, hypoxiu, intoxikáciu alebo deficit tiamínu.</p>

<p>Liečba zahŕňa objemovú resuscitáciu, podanie glukózy, korekciu draslíka, fosforu a magnézia a podanie tiamínu pred roztokmi s glukózou. Inzulín sa pri izolovanej alkoholovej ketoacidóze rutinne nepodáva, ak nie je súčasne prítomná významná hyperglykémia alebo DKA.</p>

<h2>Ketoacidóza v gravidite</h2>

<p>Gravidita podporuje inzulínovú rezistenciu, lipolýzu a ketogenézu. Súčasne je v dôsledku chronickej respiračnej alkalózy fyziologicky nižšia koncentrácia bikarbonátu. Aj relatívne krátke obdobie vracania, hladovania alebo interkurentného ochorenia preto môže viesť k závažnej ketoacidóze.</p>

<p>V treťom trimestri môže vzniknúť euglykemická ketoacidóza aj bez známeho diabetu. Riziko zvyšujú infekcie, hyperemesis, glukokortikoidy, β-agonisty a diabetes mellitus. Ide o urgentný stav s potenciálnym ohrozením matky aj plodu, ktorý vyžaduje spoluprácu intenzivistu, diabetológa, pôrodníka a podľa klinickej situácie aj nefrológa.</p>

<h2>Nefrologické súvislosti</h2>

<p>Hypovolémia pri DKA a alkoholovej ketoacidóze môže viesť k prerenálnemu akútnemu poškodeniu obličiek. Pokles glomerulovej filtrácie (GFR) zároveň obmedzuje vylučovanie ketoaniónov a zhoršuje acidózu. Pri CKD je preto potrebné opatrnejšie a individualizované vedenie objemovej liečby, korekcie elektrolytov a inzulínovej terapie.</p>

<p>Osobitne náročná je DKA u pacientov na hemodialýze. Nemusia mať osmotickú diurézu ani klasickú celkovú depléciu draslíka. Môžu byť euvolemickí alebo hypervolemickí, s vysokým rizikom pľúcneho edému a hyperkaliémie. Štandardný objemový resuscitačný postup tu môže byť nebezpečný. Liečba musí vychádzať z reziduálnej diurézy, klinického objemového stavu, hmotnosti, ultrazvukového a kardiopulmonálneho hodnotenia, kaliémie a dostupnosti dialýzy.</p>

<p>Dialýza môže byť potrebná pri refraktérnej hyperkaliémii, závažnej hypervolémii, extrémnej acidémii alebo pri inej štandardnej renálnej indikácii. Nemá však nahradiť inzulín, ktorý je pri DKA kľúčový na zastavenie ketogenézy.</p>

<h2>Praktický diagnostický postup</h2>

<p>Pri metabolickej acidóze so zvýšeným aniónovým rozdielom je vhodné súbežne vyhodnotiť:</p>

<ul>
  <li>venózny alebo arteriálny krvný plyn,</li>
  <li>elektrolyty, bikarbonát, aniónový rozdiel a osmolalitu,</li>
  <li>glykémiu,</li>
  <li>β-hydroxybutyrát v krvi,</li>
  <li>kreatinín, močovinu a diurézu,</li>
  <li>draslík, fosfor a magnézium,</li>
  <li>laktát,</li>
  <li>možné precipitujúce príčiny vrátane infekcie, ischemickej príhody, intoxikácie, gravidity a liekov.</li>
</ul>

<p>Pri podozrení na DKA nesmie negatívny alebo iba slabo pozitívny močový ketónový test prevážiť nad klinickým obrazom a výsledkom β-hydroxybutyrátu.</p>

<h2>Záver</h2>

<p>Ketoacidóza je heterogénny syndróm, pri ktorom musí byť liečba zameraná na zastavenie ketogenézy, korekciu hypovolémie alebo hypervolémie, bezpečnú úpravu elektrolytov a odstránenie vyvolávajúcej príčiny. V nefrologickej praxi sú kľúčové správna acidobázická interpretácia, rozpoznanie AKI a individualizácia liečby u pacientov s CKD alebo na dialýze.</p>

<p>Normálna glykémia ketoacidózu nevylučuje. Osobitnú pozornosť si zaslúžia pacienti liečení inhibítormi SGLT2, gravidné ženy, pacienti s dlhším hladovaním a osoby s nadmerným príjmom alkoholu.</p>

<h2>Zdroje</h2>

<ol>
  <li>Palmer BF, Clegg DJ. <em>Pathophysiology of Ketoacidosis: Core Curriculum 2026.</em> American Journal of Kidney Diseases (2026); 88(2): 301–314. DOI: 10.1053/j.ajkd.2026.02.646. <a href="https://www.ajkd.org/article/S0272-6386(26)00923-6/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></li>
  <li>Umpierrez GE, Davis GM, ElSayed NA, Fadini GP, Galindo RJ, Hirsch IB, a kol. <em>Hyperglycaemic crises in adults with diabetes: a consensus report.</em> Diabetologia (2024); 67(8): 1455–1479. DOI: 10.1007/s00125-024-06183-8. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11343900/" target="_blank" rel="noopener noreferrer">pmc.ncbi.nlm.nih.gov</a></li>
  <li>Palmer BF, Clegg DJ. <em>Electrolyte and Acid–Base Disturbances in Patients with Diabetes Mellitus.</em> New England Journal of Medicine (2015); 373: 548–559. DOI: 10.1056/NEJMra1503102. <a href="https://www.nejm.org/doi/full/10.1056/NEJMra1503102" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
  <li>Palmer BF, Clegg DJ. <em>Starvation Ketosis and the Kidney.</em> American Journal of Nephrology (2021); 52(6): 467–478. DOI: 10.1159/000517305. <a href="https://karger.com/ajn/article/52/6/467/820161" target="_blank" rel="noopener noreferrer">karger.com</a></li>
  <li>Palmer BF, Clegg DJ. <em>Electrolyte Disturbances in Patients with Chronic Alcohol-Use Disorder.</em> New England Journal of Medicine (2017); 377: 1368–1377. DOI: 10.1056/NEJMra1704724. <a href="https://www.nejm.org/doi/full/10.1056/NEJMra1704724" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
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
