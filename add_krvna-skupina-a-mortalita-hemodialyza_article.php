<?php
/**
 * add_krvna-skupina-a-mortalita-hemodialyza_article.php
 * Idempotentny UPSERT odborneho clanku o krvnej skupine a mortalite pri hemodialyze.
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// Data clanku

$articles = [];

$articles[] = [
    'title'        => 'Krvná skupina A a nižšia mortalita pri hemodialýze: zaujímavá asociácia bez dôsledkov pre súčasnú liečbu',
    'slug'         => 'krvna-skupina-a-mortalita-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Japonská kohorta spojila krvnú skupinu A s nižšou celkovou a kardiovaskulárnou mortalitou pri hemodialýze. Nález je observačný, má minimálny predikčný prínos a liečbu nemení.',
    'content'      => <<<'HTML'
<p>Japonská multicentrická kohortová štúdia zistila, že pacienti s krvnou skupinou A liečení udržiavacou hemodialýzou mali nižšiu celkovú a kardiovaskulárnu mortalitu než pacienti s krvnou skupinou O. Výsledok je prekvapujúci, pretože v nedialyzovanej populácii sa s nižším trombotickým a kardiovaskulárnym rizikom zvyčajne spája skôr krvná skupina O.</p>

<p><strong>Ide však o observačnú asociáciu, nie o dôkaz ochranného účinku krvnej skupiny A.</strong> Štúdia pochádza z geograficky aj etnicky pomerne homogénnej skupiny pacientov, nepreukázala mechanizmus a zaradenie krvnej skupiny do prognostického modelu zlepšilo jeho diskriminačnú schopnosť iba minimálne. Nález preto nemení prevenciu ani liečbu pacientov na hemodialýze.</p>

<h2>Prečo sa systém ABO skúma aj mimo transfúznej medicíny</h2>

<p>Antigény systému ABO sa nenachádzajú iba na erytrocytoch. Systém ABO súvisí aj s vlastnosťami endotelu, trombocytov a cirkulujúcich glykoproteínov. Najlepšie preskúmaný je jeho vzťah k von Willebrandovmu faktoru (VWF) a koagulačnému faktoru VIII. Osoby s krvnou skupinou O majú v priemere nižšie koncentrácie VWF a faktora VIII než osoby s ne-O krvnými skupinami, okrem iného pre rýchlejší klírens VWF.</p>

<p>V observačných štúdiách bežnej populácie sa ne-O krvné skupiny spájali s mierne vyšším rizikom niektorých trombotických a arteriálnych príhod. Miera asociácie a istota dôkazov sa však medzi jednotlivými výsledkami líšia. Krvná skupina má navyše v individuálnej prognóze podstatne menší význam než vek, fajčenie, diabetes, hypertenzia, dyslipidémia alebo už prítomné kardiovaskulárne ochorenie.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>Autori analyzovali údaje z prospektívnej Osaka Dialysis Complication Study. Do pôvodnej kohorty zaradili 1 696 pacientov z 17 dialyzačných pracovísk v prefektúre Osaka. Po vylúčení 25 osôb s chýbajúcimi údajmi zahŕňala analýza 1 671 pacientov, ktorí už pri vstupe podstupovali udržiavaciu hemodialýzu. Sledovanie prebiehalo v rokoch 2012 až 2017, najviac päť rokov; medián dosiahol 1 826 dní.</p>

<div class="table-responsive" role="region" aria-label="Ako bola štúdia navrhnutá" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Krvná skupina</th>
      <th scope="col">Počet pacientov</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>A</td><td>650</td><td>38,9 %</td></tr>
    <tr><td>B</td><td>358</td><td>21,4 %</td></tr>
    <tr><td>AB</td><td>176</td><td>10,5 %</td></tr>
    <tr><td>O</td><td>487</td><td>29,1 %</td></tr>
  </tbody>
</table>
</div>

<p>Hodnotenými výsledkami boli celková, kardiovaskulárna a nekardiovaskulárna mortalita. Pri analýze príčin úmrtia autori zohľadnili konkurenčné riziká pomocou Fineovho–Grayovho modelu. Pacienti po transplantácii obličky, prechode na peritoneálnu dialýzu, presťahovaní alebo preložení na iné pracovisko boli cenzorovaní pri poslednom potvrdenom sledovaní.</p>

<p>Počas sledovania zomrelo 464 pacientov. Z nich bolo 278 úmrtí klasifikovaných ako kardiovaskulárnych a 186 ako nekardiovaskulárnych. Až 123 kardiovaskulárnych úmrtí tvorili náhle úmrtia, čo je dôležité pri posudzovaní presnosti klasifikácie príčin smrti.</p>

<h2>Hlavný výsledok: asociácia, nie kauzalita</h2>

<p>V multivariabilnom Coxovom modeli bola krvná skupina A v porovnaní so skupinou O spojená s nižším hazardom celkovej mortality: <strong>HR 0,780; 95 % interval spoľahlivosti 0,619–0,981; p = 0,034</strong>. Ide približne o 22 % nižší odhad hazardu počas sledovania. Neznamená to 22 % zníženie absolútnej mortality ani dôkaz, že krvná skupina A úmrtiam biologicky bráni. Pri skupinách B a AB sa oproti skupine O štatisticky významná asociácia s celkovou mortalitou nezistila.</p>

<p>V primárnom Fineovom–Grayovom modeli so štyrmi krvnými skupinami bola skupina A oproti skupine O spojená aj s nižšou kardiovaskulárnou mortalitou. Pri nekardiovaskulárnej mortalite sa významná asociácia s krvnou skupinou nepreukázala.</p>

<p>Autori následne porovnali skupinu A so všetkými ne-A skupinami. Pri kardiovaskulárnej mortalite zistili <strong>HR 0,733; 95 % interval spoľahlivosti 0,568–0,947; p = 0,017</strong>. Toto dichotomické porovnanie však nebolo vopred špecifikované a nebola pri ňom použitá formálna korekcia na viacnásobné porovnávanie. Treba ho preto interpretovať ako exploratívne.</p>

<h2>Čo upravené modely zohľadnili</h2>

<p>Základné modely zahŕňali vek, pohlavie, dĺžku dialyzačnej liečby, diabetickú chorobu obličiek, predchádzajúce kardiovaskulárne príhody, fajčenie, hypertenziu, dyslipidémiu, hemoglobín, liečbu anémie, ukazovatele minerálovej a kostnej poruchy pri CKD, index telesnej hmotnosti, albumín a C-reaktívny proteín.</p>

<p>Citlivostné analýzy sa týkali najmä exploratívneho porovnania A verzus ne-A pri kardiovaskulárnej mortalite. Dodatočne zohľadnili antiagregačnú a antikoagulačnú liečbu, betablokátory, inhibítory ACE alebo sartany, statíny, alkalickú fosfatázu, hospitalizáciu pre srdcové zlyhávanie a primeranosť dialýzy. Podobný smer výsledku pretrval aj po párovaní podľa propensity skóre.</p>

<p>Táto stabilita oslabuje niektoré jednoduché vysvetlenia nálezu, ale neodstraňuje reziduálne skreslenie. Štatistická úprava pracuje iba s premennými, ktoré boli zaznamenané dostatočne presne; z observačných údajov nevytvorí randomizovaný experiment.</p>

<h2>Prečo je výsledok biologicky nejasný</h2>

<p>Ak by bol rozhodujúci iba vzťah systému ABO k VWF a faktoru VIII, priaznivejší výsledok by sa očakával skôr pri skupine O. Nižšie koncentrácie týchto faktorov sa totiž pri skupine O opisujú aj u hemodialyzovaných pacientov. V analyzovanej kohorte sa však VWF ani faktor VIII priamo nemerali, takže ich úlohu nemožno potvrdiť ani vylúčiť.</p>

<p>Autori preverovali aj alkalickú fosfatázu. Jej hodnota závisí nielen od kostného a hepatobiliárneho metabolizmu, ale pri niektorých meracích metódach aj od podielu intestinálneho izoenzýmu, ktorý súvisí s krvnou skupinou. Dodatočná úprava o alkalickú fosfatázu však pozorovanú asociáciu nevysvetlila.</p>

<p>Rizikové prostredie hemodialyzovaných pacientov charakterizuje súbeh zápalu, malnutrície, endotelovej dysfunkcie, cievnych kalcifikácií, urémie, porúch trombocytov, objemového preťaženia a opakovaných hemodynamických výkyvov. Tieto vplyvy môžu meniť epidemiologické vzťahy známe z bežnej populácie. Tvrdenie, že dialyzačné prostredie mení biologický účinok systému ABO, však zostáva hypotézou, pretože štúdia príslušné mechanizmy nemerala.</p>

<h2>Predikčný prínos bol minimálny</h2>

<p>Po pridaní štyroch kategórií krvnej skupiny do základného modelu celkovej mortality stúpla Harrellova C-štatistika z 0,749 na 0,751. Presná zmena bola iba <strong>ΔC = 0,0025</strong>, hoci test pomeru vierohodností vyšiel štatisticky významne.</p>

<p>To dobre ilustruje rozdiel medzi štatistickou asociáciou a klinickou užitočnosťou. Informácia o krvnej skupine takmer nezlepšila schopnosť modelu rozlíšiť pacientov s odlišnou prognózou a štúdia neurčila žiadny klinicky použiteľný prah ani intervenciu.</p>

<h2>Kľúčové obmedzenia</h2>

<ul>
  <li><strong>Observačný dizajn:</strong> nemožno vylúčiť reziduálne skreslenie a nemožno preukázať ochranný účinok skupiny A.</li>
  <li><strong>Pacienti už liečení dialýzou:</strong> kohorta nezahŕňala pacientov od začiatku hemodialýzy, preto je možný efekt selekcie prežívajúcich.</li>
  <li><strong>Jednorazové vstupné údaje:</strong> modely nezachytili zmeny liečby, výživy, zápalu, objemového stavu ani dialyzačného predpisu počas sledovania.</li>
  <li><strong>Nezmerané faktory:</strong> chýbali údaje o reziduálnej funkcii obličiek, VWF, faktore VIII, cievnych kalcifikáciách, endotelovej funkcii, závažnosti kardiovaskulárneho ochorenia, genetickom pozadí a socioekonomickom stave.</li>
  <li><strong>Fenotyp bez genotypizácie:</strong> autori nerozlišovali varianty lokusu ABO ani podskupiny A1 a A2.</li>
  <li><strong>Klasifikácia úmrtí:</strong> údaje pochádzali z viacerých pracovísk a časť kardiovaskulárnych úmrtí tvorila etiologicky nehomogénna kategória náhleho úmrtia.</li>
  <li><strong>Exploratívne porovnania:</strong> analýza A verzus ne-A nebola vopred plánovaná a nebola korigovaná na multiplicitu.</li>
  <li><strong>Obmedzená zovšeobecniteľnosť:</strong> takmer výlučne japonskú kohortu z jednej prefektúry nemožno bez replikácie preniesť na európske populácie ani na iné modality náhrady funkcie obličiek.</li>
</ul>

<p>Štúdia bola čiastočne podporená Japan Kidney Foundation a troma farmaceutickými spoločnosťami. Jeden autor deklaroval granty od týchto spoločností; podľa publikácie financovatelia nezasahovali do návrhu, analýzy, interpretácie ani rozhodnutia článok publikovať.</p>

<h2>Čo nález nemení v klinickej praxi</h2>

<p>Krvnú skupinu A nemožno považovať za ochranný faktor ani skupinu O za indikáciu intenzívnejšej liečby. Podľa krvnej skupiny sa nemá meniť:</p>

<ul>
  <li>kardiovaskulárna prevencia ani cieľový krvný tlak,</li>
  <li>antiagregačná alebo antikoagulačná liečba,</li>
  <li>manažment anémie a minerálovej a kostnej poruchy pri CKD,</li>
  <li>dialyzačná dávka, ultrafiltračný režim ani typ cievneho prístupu,</li>
  <li>posudzovanie vhodnosti na transplantáciu obličky.</li>
</ul>

<p>Klinicky rozhodujúce zostávajú preukázané a ovplyvniteľné faktory: diabetes, fajčenie, krvný tlak, dyslipidémia, objemový stav, poruchy rytmu, výživa, zápal, kvalita dialýzy a prítomné kardiovaskulárne ochorenie. Aj samotní autori a ich pracovisko výslovne uvádzajú, že na základe výsledku zatiaľ nemožno meniť liečbu ani prevenciu.</p>

<h2>Čo by mal objasniť ďalší výskum</h2>

<p>Výsledok si vyžaduje nezávislé potvrdenie v incidentných dialyzačných kohortách a v etnicky rozmanitých populáciách. Užitočné by bolo spojiť ABO genotypizáciu s meraním VWF, faktora VIII, endotelovej funkcie, zápalu a cievnych kalcifikácií a používať časovo aktualizované klinické údaje. Až potom bude možné odlíšiť biologický účinok od genetickej väzby, interakcie s prostredím, selekčného skreslenia alebo náhodného nálezu.</p>

<h2>Záver</h2>

<p>V prospektívnej japonskej kohorte 1 671 hemodialyzovaných pacientov bola krvná skupina A oproti skupine O spojená s nižšou celkovou a kardiovaskulárnou mortalitou, nie však s nekardiovaskulárnou mortalitou. Nález je neočakávaný, mechanisticky nevysvetlený a jeho príspevok k prognostickému modelu bol minimálny.</p>

<p><strong>Štúdia vytvára výskumnú hypotézu, nie nový postup pre dialyzačnú prax.</strong> Bez nezávislej replikácie a mechanistického vysvetlenia nemožno z krvnej skupiny vyvodzovať individuálnu prognózu ani podľa nej upravovať liečbu.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Kurajoh M, Shoji T, Nakatani S, et al. ABO Blood Types and Mortality in Patients Undergoing Hemodialysis. Kidney International Reports. 2026;11(7):106558. DOI: 10.1016/j.ekir.2026.106558. <a href="https://doi.org/10.1016/j.ekir.2026.106558" target="_blank" rel="noopener noreferrer">Pôvodná štúdia a doplnkový materiál</a>.</em></small></li>
  <li><small><em>Osaka Metropolitan University. Tlačová správa k štúdii „ABO Blood Types and Mortality in Patients Undergoing Hemodialysis“. 17. júna 2026. <a href="https://www.omu.ac.jp/info/research_news/entry-24436.html" target="_blank" rel="noopener noreferrer">Oficiálna tlačová správa</a>.</em></small></li>
  <li><small><em>Ward SE, O'Sullivan JM, O'Donnell JS. The Relationship Between ABO Blood Group, von Willebrand Factor, and Primary Hemostasis. Blood. 2020;136(25):2864–2874. DOI: 10.1182/blood.2020005843. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7751360/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
  <li><small><em>Liu FH, Guo JK, Xing WY, et al. ABO and Rhesus Blood Groups and Multiple Health Outcomes: An Umbrella Review of Systematic Reviews With Meta-analyses of Observational Studies. BMC Medicine. 2024;22:206. DOI: 10.1186/s12916-024-03423-x. <a href="https://doi.org/10.1186/s12916-024-03423-x" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
  <li><small><em>Nagano N, Tagahara A, Shimada T, et al. Comparison of Serum Alkaline Phosphatase Levels Between Two Measurement Methods in Chronic Hemodialysis Patients in Japan: Involvement of ABO Blood Group System and Relationship With Mortality Risk. Clinical and Experimental Nephrology. 2024;28(12):1300–1310. DOI: 10.1007/s10157-024-02540-4. <a href="https://pubmed.ncbi.nlm.nih.gov/39110345/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>
HTML,
];

// Vkladanie do databazy

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_krvna-skupina-a-mortalita-hemodialyza_article',
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
