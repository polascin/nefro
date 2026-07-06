<?php
/**
 * add_stanovenie-suchej-vahy-edw-hemodialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): stanovenie suchej váhy (EDW)
 * pri hemodialýze, klinický odhad, BCM/BIS, BVM/RBV a POCUS.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_stanovenie-suchej-vahy-edw-hemodialyza_article.php"
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
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Stanovenie suchej váhy (EDW) pri hemodialýze: klinický odhad, BCM, BVM a POCUS',
    'slug'         => 'stanovenie-suchej-vahy-edw-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Suchá váha pri hemodialýze nie je číslo z jedného vzorca. Praktický postup kombinuje klinický trend, toleranciu ultrafiltrácie, krvný tlak, bioimpedanciu, BVM/RBV krivky a POCUS.',
    'content'      => <<<'HTML'
<p>Stanovenie „suchej váhy“ pri hemodialýze patrí medzi najťažšie rutinné rozhodnutia v nefrológii. Na prvý pohľad ide iba o číslo v kilogramoch. V skutočnosti je to klinický odhad objemového stavu, ktorý sa mení podľa výživy, svalovej hmoty, sodíkovej bilancie, reziduálnej diurézy, zápalu, srdcovej funkcie, cievnej poddajnosti a tolerancie ultrafiltrácie.</p>

<p>EDW (<em>estimated dry weight</em>) preto nie je výsledok jedného univerzálneho matematického vzorca. V praxi ide skôr o <strong>dynamický terapeutický cieľ</strong>: čo najnižšiu dlhodobo tolerovanú postdialyzačnú hmotnosť, pri ktorej pacient nemá klinicky významné známky hypervolémie ani hypovolémie. Bioimpedančná spektroskopia, napríklad BCM od spoločnosti Fresenius Medical Care, vie rozhodovanie objektivizovať, ale ani ona nenahrádza klinický úsudok.</p>

<h2>Prečo neexistuje jednoduchý vzorec</h2>

<p>Ak by suchá váha bola iba rozdiel medzi aktuálnou hmotnosťou a prebytočnou vodou, úloha by bola jednoduchá. Problém je, že telesná hmotnosť sa skladá z viacerých zložiek: svalov, tuku, kostnej hmoty, intravaskulárneho objemu, intersticiálnej tekutiny a intracelulárnej vody. Pacient môže za mesiac pribrať svalovú alebo tukovú hmotu, schudnúť pri infekcii, mať nižší albumín, zhoršené srdcové zlyhávanie alebo vyšší príjem soli. Rovnaký údaj na váhe potom znamená inú fyziológiu.</p>

<p>Ďalší problém je tolerancia ultrafiltrácie. Dvaja pacienti s rovnakým interdialyzačným prírastkom môžu reagovať úplne odlišne podľa rýchlosti plazmatického dopĺňania, diabetickej autonómnej neuropatie, liekov, dialyzačného sodíka, teploty dialyzátu a kardiálnej rezervy. Preto sa EDW musí pravidelne prehodnocovať, nie iba mechanicky prepisovať.</p>

<h2>Klinické „probing“: stále základ, ale nie naslepo</h2>

<p>Najpoužívanejší prístup je kontrolované, postupné testovanie cieľovej postdialyzačnej hmotnosti. Starší termín „trial and error“ je výstižný, ale v modernej praxi by nemal znamenať náhodné znižovanie váhy. Ide o štruktúrované sledovanie trendov:</p>

<ul>
  <li>predialyzačný, intradialyzačný, postdialyzačný a domáci krvný tlak,</li>
  <li>interdialyzačný hmotnostný prírastok (IDWG) a sodíková disciplína,</li>
  <li>rýchlosť ultrafiltrácie a dĺžku liečby,</li>
  <li>edémy, dýchavicu, ortopnoe, náplň krčných žíl a chrôpky,</li>
  <li>kŕče, intradialytickú hypotenziu, závraty, nauzeu a postdialyzačnú únavu,</li>
  <li>zmeny výživy, albumínu, svalovej hmoty a funkčnej kondície.</li>
</ul>

<p>Príliš vysoká EDW vedie k chronickej hypervolémii, hypertenzii, hypertrofii ľavej komory, pľúcnej kongescii a vyššiemu kardiovaskulárnemu riziku. Príliš nízka EDW sa prejaví intradialytickou hypotenziou, kŕčmi, nevoľnosťou, postdialyzačnou vyčerpanosťou, rizikom ischémie myokardu alebo mozgu a horšou adherenciou pacienta. Dobrá EDW preto nie je „najnižšie číslo za každú cenu“, ale bezpečné rozhranie medzi preťažením a dehydratáciou.</p>

<h2>Kardiotorakálny index: historický, ale stále poučný parameter</h2>

<p>V literatúre sa uvádza aj staršie kritérium založené na normotenzii bez antihypertenzív v kombinácii s kardiotorakálnym indexom (CTI/CTR) &lt; 48 % na RTG snímke hrudníka. Ide o objektívnejší marker než samotný edém predkolení, ale nemá sa interpretovať izolovane.</p>

<p>CTI ovplyvňuje hypertrofia a dilatácia ľavej komory, chlopňové chyby, perikardiálny výpotok, technika snímky aj habitus. U pacienta s dlhodobou kardiomegáliou nemusí pokles objemu rýchlo normalizovať CTI, zatiaľ čo u pacienta bez kardiomegálie môže byť významná hypervolémia prítomná ešte pred jasným zväčšením srdcového tieňa. CTI je preto skôr súčasť dlhodobého obrazu, nie denný dialyzačný kompas.</p>

<h2>Bioimpedancia a BCM: objektivizácia, nie veštba</h2>

<p>Bioimpedančná spektroskopia (BIS) odhaduje rozloženie telesnej vody a pri nástrojoch typu BCM modelovo oddeľuje <strong>overhydratáciu</strong> od svalovej a tukovej zložky. Jej veľká výhoda je, že pomáha odhaliť „tichú“ hypervolémiu u pacienta bez nápadných edémov a zároveň upozorní na zmenu nutričného alebo svalového stavu.</p>

<p>Limitom je dostupnosť prístroja, potreba štandardizovaného merania a interpretácia v kontexte pacienta. Výsledok môže byť ťažšie čitateľný pri amputáciách, kovových implantátoch, výrazných deformitách, extrémnom BMI, lokálnych edémoch, peritoneálnej tekutine alebo nestabilnom akútnom stave. Ak BCM ukáže overhydratáciu, stále treba rozhodnúť, ako rýchlo a bezpečne sa k cieľu priblížiť.</p>

<h2>BVM/RBV krivky: čo hovoria a čo nehovoria</h2>

<p>Kontinuálne monitorovanie relatívneho objemu krvi počas hemodialýzy (BVM/RBV) sleduje zmenu intravaskulárneho priestoru, často nepriamo cez hematokrit alebo optické/ultrazvukové vlastnosti krvi. Jeho klinická hodnota je najmä trendová: pomáha odhadnúť, či ultrafiltrácia predbieha dopĺňanie plazmy z interstícia.</p>

<p>Plochšia krivka relatívneho objemu krvi pri primeranej ultrafiltrácii môže podporovať podozrenie na nadbytok extracelulárnej tekutiny a dobré plazmatické dopĺňanie. Strmý pokles, najmä ak sa spája s hypotenziou, kŕčmi alebo nauzeou, upozorňuje na obmedzenú toleranciu ultrafiltrácie, príliš nízku cieľovú hmotnosť alebo príliš vysokú rýchlosť odstraňovania tekutín. Samotná krivka však neurčí absolútnu suchú váhu pred dialýzou a je citlivá na predpis dialýzy, príjem jedla počas HD, albumín, vaskulárny tonus, lieky a technické faktory.</p>

<h2>POCUS: dolná dutá žila a pľúcny ultrazvuk</h2>

<p>Point-of-care ultrazvuk sa v nefrológii presadzuje najmä preto, že objemový stav zviditeľní pri lôžku alebo v ambulancii. Pri dolnej dutej žile (vena cava inferior, VCI/IVC) sa sleduje priemer a respiračná kolapsibilita. Bežne používaný vzorec je:</p>

<p><strong>IVC-CI = (IVC<sub>max</sub> − IVC<sub>min</sub>) / IVC<sub>max</sub> × 100</strong></p>

<p>Dilatovaná VCI s nízkou kolapsibilitou podporuje obraz zvýšeného pravostranného plniaceho tlaku alebo venóznej kongescie. Malá výrazne kolabujúca VCI skôr podporuje nízky preload. V hemodialýze však treba byť opatrný: VCI ovplyvňuje pravostranné srdcové zlyhávanie, trikuspidálna regurgitácia, pľúcna hypertenzia, spontánne dýchanie verzus ventilácia, intraabdominálny tlak a technika merania.</p>

<p>Veľmi praktický doplnok je <strong>pľúcny ultrazvuk</strong> so sledovaním B-línií. B-línie zachytávajú extravaskulárnu pľúcnu vodu a môžu upozorniť na subklinickú pľúcnu kongesciu ešte pred výraznou dýchavicou. Randomizovaná štúdia ukázala, že stratégia redukcie suchej váhy vedená pľúcnym ultrazvukom môže znížiť ambulantný krvný tlak u hypertenzných hemodialyzovaných pacientov.</p>

<h2>Biomarkery a laboratórium: užitočné, ale nešpecifické</h2>

<p>NT-proBNP, albumín, CRP, sodík, hemoglobín a ďalšie laboratórne parametre môžu pomôcť vysvetliť klinický obraz, ale nie sú priamym výpočtom EDW. NT-proBNP môže rásť pri objemovom preťažení, ale aj pri štrukturálnom ochorení srdca a zníženom renálnom klírense. Hypoalbuminémia zhoršuje plazmatické dopĺňanie a mení distribúciu tekutiny. Zápal a malnutrícia môžu znížiť skutočnú tkanivovú hmotnosť, takže „stará“ suchá váha sa stane príliš vysokou.</p>

<h2>Prediktívne modely a machine learning</h2>

<p>Najnovšie práce skúšajú predikovať potrebu úpravy suchej váhy pomocou modelov strojového učenia. Používajú sa premenné ako IDWG, pokles krvného tlaku počas dialýzy, laboratórne parametre, nutričné markery, bioimpedančné údaje a predchádzajúce rozhodnutia personálu. Random Forest, XGBoost a príbuzné modely v publikovaných štúdiách ukazujú, že vedia zachytiť niektoré klinické vzorce.</p>

<p>Ich miesto je však zatiaľ podporné. Model sa učí z dát konkrétneho pracoviska, z lokálnych rozhodovacích návykov a z kvality vstupných údajov. Bez externej validácie, priebežného auditu a jasnej zodpovednosti lekára nemá nahradiť klinické rozhodnutie. Najrozumnejšie využitie je ako „early warning“ alebo druhý pohľad na trend, nie ako automatický predpis suchej váhy.</p>

<h2>Praktický algoritmus pri úprave EDW</h2>

<ol>
  <li><strong>Najprv odlíšiť vodu od tkanivovej hmoty.</strong> Schudol pacient pri infekcii, nechutenstve alebo hospitalizácii? Pribral svaly alebo tuk po zlepšení apetítu? Zmenil sa albumín alebo funkčný stav?</li>
  <li><strong>Zhodnotiť hypervolémiu.</strong> Pretrváva hypertenzia, dýchavica, edémy, ortopnoe, B-línie, dilatovaná VCI, vysoký IDWG alebo plochá RBV krivka pri dostatočnej ultrafiltrácii?</li>
  <li><strong>Zhodnotiť hypovolémiu a toleranciu.</strong> Sú prítomné kŕče, intradialytická hypotenzia, závraty, nauzea, postdialyzačná slabosť, strmý pokles RBV alebo malá kolabujúca VCI?</li>
  <li><strong>Upravovať postupne.</strong> Pri stabilnom pacientovi je bezpečnejšie meniť cieľ v malých krokoch naprieč viacerými dialýzami, zároveň upraviť príjem soli, dĺžku HD alebo rýchlosť ultrafiltrácie.</li>
  <li><strong>Overiť mimo dialyzačnej sály.</strong> Domáci alebo ambulantný krvný tlak, symptómy medzi dialýzami a funkčná tolerancia sú často cennejšie než jeden izolovaný predialyzačný tlak.</li>
  <li><strong>Pravidelne revidovať.</strong> EDW treba prehodnotiť po hospitalizácii, infekcii, zmene apetítu, zmene diurézy, dekompenzácii srdcového zlyhávania, zmene antihypertenzív a pri opakovaných intradialytických komplikáciách.</li>
</ol>

<h2>Porovnanie metód</h2>

<div class="admin-table-overflow">
<table class="admin-articles-table">
  <thead>
    <tr>
      <th>Metóda</th>
      <th>Silná stránka</th>
      <th>Slabé miesto</th>
      <th>Najlepšie použitie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Klinický odhad</td>
      <td>Dostupný vždy, zohľadňuje symptómy a toleranciu</td>
      <td>Subjektívny; riziko tichej hypervolémie</td>
      <td>Každodenný základ rozhodovania</td>
    </tr>
    <tr>
      <td>CTI/CTR</td>
      <td>Jednoduchý objektívny RTG parameter</td>
      <td>Ovplyvnený kardiálnou patológiou a technikou snímky</td>
      <td>Dlhodobý kontext pri hypertenzii a kardiomegálii</td>
    </tr>
    <tr>
      <td>BCM/BIS</td>
      <td>Kvantifikuje overhydratáciu a telesné zloženie</td>
      <td>Dostupnosť, cena, potreba štandardizácie a klinickej interpretácie</td>
      <td>Objektivizácia pri nejasnom alebo chronicky preťaženom pacientovi</td>
    </tr>
    <tr>
      <td>BVM/RBV</td>
      <td>Reálny čas počas hemodialýzy</td>
      <td>Relatívny údaj; závisí od predpisu a intradialytických podmienok</td>
      <td>Posúdenie tolerancie ultrafiltrácie a trendu plazmatického dopĺňania</td>
    </tr>
    <tr>
      <td>POCUS: VCI a pľúca</td>
      <td>Vizuálny dôkaz venóznej alebo pľúcnej kongescie pri lôžku</td>
      <td>Závisí od zručnosti, prístroja a kardiopulmonálneho kontextu</td>
      <td>Dýchavica, hypertenzia, nejasná kongescia, kardiorenálny pacient</td>
    </tr>
    <tr>
      <td>Biomarkery</td>
      <td>Pomáhajú vysvetliť trend a riziko</td>
      <td>Nízka špecificita pre samotnú EDW</td>
      <td>Doplnok pri srdcovom zlyhávaní, zápale, malnutrícii</td>
    </tr>
    <tr>
      <td>Machine learning</td>
      <td>Vie zachytiť komplexné vzorce vo veľkých dátach</td>
      <td>Nutná validácia, audit a kvalitné vstupy</td>
      <td>Podporný systém a včasné upozornenie na potrebu revízie</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Záver</h2>

<p>Suchá váha nie je stabilná konštanta, ale priebežne overovaný klinický cieľ. Najbezpečnejší prístup je multimodálny: klinika a tlakové trendy tvoria základ, bioimpedancia a POCUS pridávajú objektívny objemový obraz, BVM/RBV ukazuje intradialytickú toleranciu a laboratórium pomáha vysvetliť, prečo sa cieľ mení.</p>

<p>V dobrej dialyzačnej praxi sa EDW neurčuje jedným meraním ani jednou krivkou. Určuje sa opakovaným porovnávaním symptómov, tlaku, ultrafiltračnej tolerancie, výživového stavu a objektívnych nástrojov. Cieľom nie je „suchý“ pacient za každú cenu, ale euvolémia, lepšia kontrola tlaku, menej intradialytických komplikácií a dlhodobo nižšie kardiovaskulárne riziko.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>
<ul>
  <li><em>KDOQI Clinical Practice Guidelines and Clinical Practice Recommendations, Guideline 5: Control of Volume and Blood Pressure.</em> <a href="https://kidneyfoundation.cachefly.net/professionals/KDOQI/guideline_upHD_PD_VA/hd_guide5.htm" target="_blank" rel="noopener noreferrer">NKF KDOQI</a>.</li>
  <li>Flythe JE, Chang TI, Gallagher MP, et al. Blood pressure and volume management in dialysis: conclusions from a KDIGO Controversies Conference. <em>Kidney International</em>. 2020;97(5):861–876. <a href="https://kdigo.org/wp-content/uploads/2017/05/KDIGO-BP-Volume-in-Dialysis-FINAL.pdf" target="_blank" rel="noopener noreferrer">KDIGO PDF</a>.</li>
  <li>Agarwal R, Weir MR. Dry-weight: a concept revisited in an effort to avoid medication-directed approaches for blood pressure control in hemodialysis patients. <em>Clin J Am Soc Nephrol</em>. 2010;5(7):1255–1260. <a href="https://pubmed.ncbi.nlm.nih.gov/20507951/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li>Charra B. How to determine „dry weight“? <em>Kidney International Supplements</em>. 2013;3(4):377–379. <a href="https://www.kisupplements.com/article/S2157-1716%2815%2931175-8/abstract" target="_blank" rel="noopener noreferrer">Kidney International Supplements</a>.</li>
  <li>Loutradis C, Sarafidis PA, Ekart R, et al. The effect of dry-weight reduction guided by lung ultrasound on ambulatory blood pressure in hemodialysis patients: a randomized controlled trial. <em>Kidney International</em>. 2019;95(6):1505–1513. <a href="https://doi.org/10.1016/j.kint.2019.02.018" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Ando Y, Yanagiba S, Asano Y. The inferior vena cava diameter as a marker of dry weight in chronic hemodialyzed patients. <em>Artificial Organs</em>. 1995;19(12):1237–1242. <a href="https://pubmed.ncbi.nlm.nih.gov/8967881/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li>Rodriguez HJ, Domenici R, Diroll A, Goykhman I. Assessment of dry weight by monitoring changes in blood volume during hemodialysis using Crit-Line. <em>Kidney International</em>. 2005;68(2):854–861. <a href="https://www.sciencedirect.com/science/article/pii/S0085253815509095" target="_blank" rel="noopener noreferrer">ScienceDirect</a>.</li>
  <li>Kim HR, Bae HJ, Jeon JW, et al. A novel approach to dry weight adjustments for dialysis patients using machine learning. <em>PLOS ONE</em>. 2021;16(4):e0250467. <a href="https://journals.plos.org/plosone/article?id=10.1371%2Fjournal.pone.0250467" target="_blank" rel="noopener noreferrer">PLOS ONE</a>.</li>
  <li>National Kidney Foundation. What Is Dry Weight? <a href="https://www.kidney.org/kidney-topics/what-dry-weight" target="_blank" rel="noopener noreferrer">kidney.org</a>.</li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_stanovenie_suchej_vahy_edw newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_stanovenie_suchej_vahy_edw pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_stanovenie_suchej_vahy_edw pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_stanovenie_suchej_vahy_edw migration error: ' . $e->getMessage());
    }
}

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
