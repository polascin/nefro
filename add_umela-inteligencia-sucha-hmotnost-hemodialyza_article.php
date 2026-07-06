<?php
/**
 * add_umela-inteligencia-sucha-hmotnost-hemodialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): využitie strojového učenia
 * pri odhade klinicky primeranej suchej hmotnosti u hemodialyzovaných pacientov.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_umela-inteligencia-sucha-hmotnost-hemodialyza_article.php"
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
    'title'        => 'Umelá inteligencia pri určovaní suchej hmotnosti u hemodialyzovaných pacientov',
    'slug'         => 'umela-inteligencia-sucha-hmotnost-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Retrospektívna štúdia PLOS One ukazuje, že strojové učenie môže doplniť bioimpedančný odhad suchej hmotnosti, najmä pri menšom rozdiele medzi technickým a klinickým hodnotením.',
    'content'      => <<<'HTML'
<p>Stanovenie suchej hmotnosti patrí medzi najpraktickejšie a zároveň najťažšie rozhodnutia v chronickej hemodialýze. Ak je cieľová suchá hmotnosť nadhodnotená, pacient ostáva chronicky hyperhydratovaný. Výsledkom môže byť horšia kontrola krvného tlaku, hypertrofia ľavej komory, srdcové zlyhávanie a vyššie kardiovaskulárne riziko. Ak je naopak podhodnotená, ultrafiltrácia môže viesť k hypovolémii, intradialyzačnej hypotenzii, kŕčom, závratom, orgánovej ischémii a strate zvyškovej funkcie obličiek.</p>

<p>Štúdia publikovaná v časopise <em>PLOS One</em> sa zaoberala otázkou, či možno pomocou strojového učenia presnejšie odhadnúť klinicky primeranú suchú hmotnosť hemodialyzovaných pacientov. Autori vychádzali z údajov bioimpedančnej spektroskopie a z bežných klinických, laboratórnych a antropometrických parametrov. Najdôležitejším posolstvom práce nie je predstava, že algoritmus nahradí nefrológa. Skôr ukazuje, v ktorých situáciách môže byť technický odhad bioimpedanciou spoľahlivejší a kde sa začína od klinickej reality nebezpečne vzďaľovať.</p>

<h2>Prečo samotná bioimpedancia nestačí</h2>

<p>Bioimpedančná spektroskopia (BIS) je užitočný nástroj na hodnotenie hydratácie a telesného zloženia. Meraním elektrických vlastností tkanív pomáha odhadnúť extracelulárnu vodu, intracelulárnu vodu, celkovú telesnú vodu a modelový nadbytok tekutiny. V dialyzačnej praxi tak prináša objektívnejší vstup než samotný klinický pohľad na edémy alebo jednorazové meranie krvného tlaku.</p>

<p>Limitom je, že BIS nepracuje vo vákuu. Výsledok ovplyvňuje telesné zloženie, svalová hmota, tuková hmota, hypoalbuminémia, malnutrícia, periférne edémy, kardiálne ochorenie aj aktuálna tolerancia ultrafiltrácie. U časti pacientov sa preto bioimpedančne odvodená suchá hmotnosť môže líšiť od hmotnosti, ktorú pacient reálne toleruje bez prejavov hypervolémie alebo hypovolémie.</p>

<p>Autori preto rozlišovali dve hodnoty:</p>

<ul>
  <li><strong>DW<sub>BIS</sub></strong> – suchú hmotnosť odvodenú z bioimpedančnej spektroskopie,</li>
  <li><strong>DW<sub>CP</sub></strong> – klinicky primeranú suchú hmotnosť stanovenú podľa tolerancie pacienta, klinických príznakov a zobrazovacích nálezov.</li>
</ul>

<p>Rozdiel medzi týmito dvoma hodnotami označili ako <strong>Gap<sub>DW</sub></strong>. Práve tento rozdiel je klinicky zaujímavý: ak je malý, BIS a klinický obraz sa zhodujú. Ak je veľký, treba hľadať dôvod, prečo technický odhad nesedí s pacientom pred nami.</p>

<h2>Cieľ štúdie</h2>

<p>Cieľom bolo zistiť, či modely strojového učenia dokážu lepšie predpovedať klinicky primeranú suchú hmotnosť než samotný bioimpedančný výstup a ktoré faktory najviac vysvetľujú rozdiel medzi DW<sub>BIS</sub> a DW<sub>CP</sub>. Autori teda neriešili len technickú presnosť modelu, ale aj biologickú interpretáciu situácií, v ktorých sa bioimpedancia odchyľuje od klinickej praxe.</p>

<h2>Dizajn a metodika</h2>

<p>Išlo o retrospektívnu jednocentrovú štúdiu z Chungnam National University Hospital. Autori analyzovali údaje 1 672 pacientov liečených udržiavacou hemodialýzou. Zaradení boli pacienti s terminálnym zlyhaním obličiek, ktorí podstupovali hemodialýzu trikrát týždenne a liečba trvala aspoň tri mesiace. Vylúčení boli pacienti s akútnym poškodením obličiek, nestabilným klinickým stavom, akútnou infekciou, pobytom na jednotke intenzívnej starostlivosti, neúplnými údajmi o hydratácii alebo zmenou antihypertenzív v okolí merania telesného zloženia.</p>

<p>Bioimpedančné merania sa vykonávali pred dialýzou. Hodnotili sa ukazovatele telesnej vody a zloženia tela vrátane extracelulárnej vody (ECW), intracelulárnej vody (ICW), celkovej telesnej vody (TBW), pomeru ECW/ICW, indexu chudej hmoty a indexu tukovej hmoty. Do analýzy boli zahrnuté aj laboratórne hodnoty, napríklad hemoglobín, urea, kreatinín, albumín, celkové bielkoviny, vápnik, fosfor, sodík, draslík a chloridy.</p>

<h2>Použité modely</h2>

<p>Autori použili stromové modely vhodné pre tabuľkové klinické údaje: XGBoost, LightGBM a random forest. Dáta boli opakovane náhodne delené na tréningový a testovací súbor. V každom cykle sa 80 % údajov použilo na trénovanie a 20 % na testovanie; postup sa opakoval 20-krát a výsledky sa spriemerovali.</p>

<p>Tento dizajn je dôležitý pre interpretáciu: nejde o prospektívne nasadený rozhodovací systém, ale o retrospektívnu prediktívnu analýzu z jedného pracoviska. Model sa teda učil nielen fyziológiu pacienta, ale aj lokálny spôsob dokumentácie, merania a klinického rozhodovania.</p>

<h2>Hlavné výsledky</h2>

<p>Podľa veľkosti rozdielu medzi bioimpedančne odvodenou a klinicky primeranou suchou hmotnosťou boli pacienti rozdelení do troch skupín:</p>

<ul>
  <li><strong>Gap<sub>DW</sub> &lt; 1 kg:</strong> 972 pacientov,</li>
  <li><strong>Gap<sub>DW</sub> ≥ 1 kg a &lt; 2 kg:</strong> 303 pacientov,</li>
  <li><strong>Gap<sub>DW</sub> ≥ 2 kg:</strong> 384 pacientov.</li>
</ul>

<p>Pri použití celého súboru bola predikcia klinicky primeranej suchej hmotnosti slabá. Autori uvádzajú presnosť menej než 40 % a maximálnu chybu predikcie nadbytku tekutiny až približne 1,5 kg. Inými slovami: ak sa do modelu vložili aj pacienti s veľkým nesúladom medzi BIS a klinikou, algoritmus nedokázal spoľahlivo určiť cieľovú hodnotu.</p>

<p>Výsledky sa zlepšili po obmedzení analýzy na pacientov s menším rozdielom medzi DW<sub>BIS</sub> a DW<sub>CP</sub>. Pri Gap<sub>DW</sub> &lt; 1 kg dosiahol XGBoost podľa autormi použitej metriky priemernú presnosť približne 83 %. Pri rozšírení na Gap<sub>DW</sub> &lt; 2 kg klesla priemerná presnosť približne na 72 %. Prakticky to znamená, že strojové učenie pomáhalo najmä tam, kde sa technický a klinický odhad už relatívne zhodovali. Pri väčšom nesúlade výkon modelu klesal.</p>

<h2>Čo zväčšovalo rozdiel medzi BIS a klinickou realitou</h2>

<p>Jedným z najcennejších prínosov štúdie je identifikácia faktorov súvisiacich s rastúcim Gap<sub>DW</sub>. So zväčšujúcim sa rozdielom klesali najmä hodnoty hemoglobínu, celkových bielkovín, sérového albumínu, kreatinínu, fosforu, draslíka a indexu tukovej hmoty. V detailnej distribučnej analýze sa uvádzal aj pokles sodíka. Naopak, s rastúcim Gap<sub>DW</sub> stúpali výška, celková telesná voda, extracelulárna voda a pomer extracelulárnej k intracelulárnej vode.</p>

<p>Tieto zistenia podporujú klinicky známy obraz: najväčšie nezhody medzi technickým a klinickým odhadom suchej hmotnosti vznikajú u pacientov s prevodnením, zmeneným telesným zložením a znakmi malnutrície alebo nízkej svalovej hmoty. Nízky albumín, nižší kreatinín, nižší fosfor a nižší draslík nemusia byť samostatnými „ukazovateľmi suchej hmotnosti“, ale upozorňujú, že distribúcia tekutín a efektívny cirkulujúci objem môžu byť atypické.</p>

<h2>Klinická interpretácia</h2>

<p>Suchá hmotnosť nie je iba matematický výsledok. Je to dynamický klinický cieľ medzi odstránením nadbytočnej tekutiny a zachovaním hemodynamickej stability. Bioimpedancia poskytuje objektívny údaj o telesnej vode, ale tolerovaná cieľová hmotnosť závisí aj od vaskulárnej náplne, srdcovej funkcie, výživového stavu, svalovej hmoty, albumínu, periférnych edémov, krvného tlaku, reziduálnej diurézy a tolerancie ultrafiltrácie.</p>

<p>Ak má pacient nízky albumín, nízky kreatinín, nízky fosfor a nízky draslík, môže ísť o obraz malnutrície alebo zníženej svalovej hmoty. Extracelulárna voda môže byť zvýšená, ale intravaskulárny objem nemusí byť dostatočný. Príliš agresívne znižovanie suchej hmotnosti podľa technického odhadu potom môže viesť k hypotenzii, kŕčom alebo zlej tolerancii dialýzy, hoci pacient zároveň môže mať intersticiálne alebo pľúcne preťaženie.</p>

<h2>Význam pre dialyzačnú prax</h2>

<p>Pre prax je najdôležitejšie, že strojové učenie nemá nahradiť klinické rozhodovanie. Môže však fungovať ako doplnkový nástroj, ak sa doň integrujú údaje z bioimpedancie, laboratórnych parametrov a klinického stavu pacienta. Užitočné môže byť najmä ako druhý pohľad na trend alebo ako upozornenie, že určitý pacient sa odlišuje od bežnej populácie dialyzačného strediska.</p>

<p>Pri nastavovaní suchej hmotnosti by nefrológ nemal vychádzať z jednej hodnoty. Rozumný prístup kombinuje:</p>

<ul>
  <li>predialyzačný, intradialyzačný, postdialyzačný a domáci krvný tlak,</li>
  <li>výskyt intradialyzačnej hypotenzie, kŕčov, závratov a postdialyzačnej únavy,</li>
  <li>periférne edémy a známky pľúcnej kongescie,</li>
  <li>interdialyzačný hmotnostný prírastok a ultrafiltračnú rýchlosť,</li>
  <li>albumín, kreatinín, fosfor, draslík a celkový nutričný stav,</li>
  <li>reziduálnu diurézu, srdcové zlyhávanie a hypertrofiu ľavej komory,</li>
  <li>výsledky bioimpedancie, prípadne pľúcneho ultrazvuku alebo iných objektívnych metód.</li>
</ul>

<h2>Umelá inteligencia ako podpora, nie autorita</h2>

<p>Štúdia je zaujímavá aj širšie: ukazuje, že algoritmy môžu odhaliť vzťahy, ktoré dávajú klinický zmysel. Extracelulárna voda, pomer ECW/ICW a malnutričné laboratórne signály sú presne tie premenné, pri ktorých nefrológ očakáva zložitejšiu interpretáciu suchej hmotnosti.</p>

<p>Zároveň však práca veľmi dobre ukazuje hranice umelej inteligencie. Modely boli najmenej presné u pacientov s najväčším rozdielom medzi DW<sub>BIS</sub> a DW<sub>CP</sub> – teda práve u pacientov, ktorí sú klinicky najťažší a pri ktorých by lekár najviac potreboval pomoc. To je dôležité varovanie pred nekritickým používaním algoritmov. AI môže zlepšiť rozhodovanie v štandardnejších situáciách, ale pri komplexnom pacientovi s malnutríciou, edémami, srdcovým zlyhávaním alebo nestabilnou toleranciou ultrafiltrácie zostáva rozhodujúce klinické posúdenie.</p>

<h2>Limity štúdie</h2>

<p>Štúdia bola retrospektívna a jednocentrová, preto nemožno výsledky automaticky preniesť na všetky dialyzačné populácie. Bioimpedančné merania vykonávala jedna osoba, čo síce môže znižovať variabilitu merania, ale zároveň prináša riziko systematickej chyby. Autori nehodnotili externú validačnú kohortu a neanalyzovali výkon modelu osobitne podľa pohlavia alebo veku.</p>

<p>Dôležité je aj to, že štúdia priamo nepreukázala, že algoritmická úprava suchej hmotnosti znižuje mortalitu, hospitalizácie alebo kardiovaskulárne príhody. Ide najmä o metodologický a prediktívny výskum. Na potvrdenie klinického prínosu by boli potrebné prospektívne a multicentrické štúdie s jasne definovanými pacientskymi výsledkami.</p>

<h2>Praktický záver</h2>

<p>Strojové učenie môže pomôcť pri odhade klinicky primeranej suchej hmotnosti u hemodialyzovaných pacientov, najmä ak rozdiel medzi bioimpedančným a klinickým odhadom nie je veľký. Najlepšie výsledky v tejto štúdii dosiahol XGBoost u pacientov s Gap<sub>DW</sub> &lt; 1 kg. Pri väčších rozdieloch sa presnosť zhoršovala a pri Gap<sub>DW</sub> ≥ 2 kg ostáva predikcia klinicky problematická.</p>

<p>Najväčší klinický význam práce spočíva v upozornení, že veľký nesúlad medzi BIS a klinickou suchou hmotnosťou často súvisí s extracelulárnou prevodnenosťou a znakmi malnutrície. Bioimpedančný výsledok preto treba interpretovať opatrne a vždy ho konfrontovať s klinickým stavom. Pre nefrológa je posolstvo jasné: suchá hmotnosť má byť výsledkom kombinácie objektívneho merania, klinického pozorovania, laboratórnych údajov a skúsenosti dialyzačného tímu. Algoritmus môže pomôcť, ale nemá rozhodovať sám.</p>

<hr>

<p><em><strong>Zdroj:</strong> Kim HR, Bae HJ, Jeon JW, Ham YR, Na KR, Lee KW, et al. A novel approach to dry weight adjustments for dialysis patients using machine learning. <em>PLOS One</em>. 2021;16(4):e0250467. Publikované 23. apríla 2021. DOI: 10.1371/journal.pone.0250467. <a href="https://journals.plos.org/plosone/article?id=10.1371%2Fjournal.pone.0250467" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_umela_inteligencia_sucha_hmotnost_hemodialyza newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_umela_inteligencia_sucha_hmotnost_hemodialyza pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_umela_inteligencia_sucha_hmotnost_hemodialyza pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_umela_inteligencia_sucha_hmotnost_hemodialyza migration error: ' . $e->getMessage());
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
