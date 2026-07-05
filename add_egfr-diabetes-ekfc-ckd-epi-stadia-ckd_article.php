<?php
/**
 * add_egfr-diabetes-ekfc-ckd-epi-stadia-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): eGFR rovnice EKFC a CKD-EPI
 * u pacientov s diabetom 2. typu.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_egfr-diabetes-ekfc-ckd-epi-stadia-ckd_article.php"
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
    'title'        => 'Presnejší odhad eGFR u pacientov s diabetom: keď rovnica mení štádium CKD',
    'slug'         => 'egfr-diabetes-ekfc-ckd-epi-stadia-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'U pacientov s diabetom 2. typu môže výber kreatinínovej rovnice pre eGFR meniť zaradenie do G kategórií CKD. Rozdiel medzi CKD-EPI 2021 a EKFC preto nie je len matematický, ale môže ovplyvniť rizikovú stratifikáciu a načasovanie nefroprotekcie.',
    'content'      => <<<'HTML'
<p>Odhad glomerulovej filtrácie patrí medzi základné nástroje nefrologickej aj diabetologickej praxe. U pacientov s diabetes mellitus 2. typu má osobitný význam, pretože práve táto skupina má vysoké riziko chronickej choroby obličiek, progresie albuminúrie, poklesu eGFR a napokon aj zlyhania obličiek.</p>

<p>Krátky článok publikovaný v <em>Journal of Nephrology</em> upozorňuje na prakticky dôležitý problém: rôzne kreatinínové rovnice na výpočet eGFR nemusia toho istého pacienta zaradiť do rovnakej G kategórie. Pri diabete to môže mať priamy dosah na stratifikáciu rizika, frekvenciu kontrol, indikáciu nefroprotektívnej liečby aj načasovanie odoslania pacienta k nefrológovi.</p>

<p>Je dôležité povedať hneď na začiatku: eGFR nie je meraná GFR. Je to odhad odvodený z rovnice. A rovnica nie je neutrálna technická drobnosť. V populácii s vysokým kardiorenálnym rizikom môže výber rovnice zmeniť klinický príbeh pacienta.</p>

<h2>O čo v článku ide</h2>

<p>Autori nadviazali na prácu, ktorá porovnávala odhad GFR u pacientov s diabetes mellitus pomocou rovníc EKFC a CKD-EPI. Namiesto čisto prierezového porovnania sa zamerali aj na prognostickú hodnotu jednotlivých rovníc v reálnej longitudinálnej kohorte.</p>

<p>Hodnotená bola skupina 4591 čínskych pacientov s diabetom 2. typu. Počas sledovania s mediánom približne 1,01 roka autori posudzovali kompozitný renálny výsledok, ktorý zahŕňal pokles eGFR o viac ako 40 %, zdvojnásobenie sérového kreatinínu alebo zlyhanie obličiek.</p>

<p>Cieľom bolo zistiť, ako sa mení zaradenie pacientov do G kategórií pri použití rôznych kreatinínových rovníc a či niektoré rovnice lepšie odrážajú klinické riziko v populácii s diabetom 2. typu.</p>

<h2>EKFC verzus CKD-EPI: nejde len o matematiku</h2>

<p>V klinickej praxi sa eGFR často vníma ako jedno číslo, ktoré automaticky vygeneruje laboratórny informačný systém. Problém je, že toto číslo závisí od použitej rovnice. Rovnice CKD-EPI a EKFC pracujú s kreatinínom, vekom a pohlavím, ale ich matematická konštrukcia a správanie v rôznych populáciách sa líšia.</p>

<p>Autori uvádzajú, že po spresnení implementácie rovnice EKFC pomocou správnych exponenciálnych faktorov pre hodnoty Scr/Q ≥ 1 vzniklo rozdelenie pokročilejších kategórií CKD, ktoré podľa nich lepšie zodpovedalo klinickej realite u vysoko rizikovej diabetickej populácie.</p>

<p>Inými slovami, nejde o akademický detail. Menej vhodná alebo nesprávne implementovaná rovnica môže časť pacientov zaradiť do miernejšej kategórie renálnej funkcie, než by lepšie zodpovedalo ich skutočnému riziku.</p>

<h2>Fenomén stage migration</h2>

<p>Kľúčovým pojmom článku je <em>stage migration</em>, teda presun pacienta medzi kategóriami podľa toho, aká rovnica sa použije na výpočet eGFR.</p>

<p>Podľa dostupného textu článku rovnica CKD-EPI kreatinín 2021 zaradila 37,44 % pacientov do kategórie G1, teda eGFR ≥ 90 ml/min/1,73 m². Pri použití rovnice EKFC kreatinín sa významná časť týchto pacientov presunula do kategórie G2. EKFC zaradila do G2 33,09 % pacientov, zatiaľ čo CKD-EPI 25,90 %.</p>

<p>Tento rozdiel naznačuje, že EKFC môže byť pri diabetických pacientoch konzervatívnejšia. To môže byť výhodné, ak pomáha identifikovať pacientov, ktorí podľa jednej rovnice vyzerajú ako pacienti s normálnou alebo takmer normálnou filtráciou, ale v skutočnosti už majú vyššie renálne riziko.</p>

<p>Zároveň treba zachovať presnú terminológiu. Samotná kategória G1 alebo G2 ešte automaticky neznamená diagnózu CKD, ak chýba chronickosť a marker poškodenia obličiek, napríklad albuminúria, patologický močový sediment, štrukturálne poškodenie alebo transplantovaná oblička. Pri diabete však práve albuminúria a kardiometabolický kontext často rozhodujú, či ide o klinicky významné renálne riziko.</p>

<h2>Prečo je to dôležité pri diabete 2. typu</h2>

<p>Diabetická choroba obličiek môže postupovať dlho nenápadne. Pacient môže mať relatívne zachovanú eGFR, ale už prítomnú albuminúriu, vaskulárne poškodenie, hyperfiltráciu alebo rastúce riziko budúceho poklesu funkcie obličiek.</p>

<p>Ak rovnica nadhodnotí eGFR, môže to viesť k podceneniu rizika. Prakticky to môže znamenať menej časté kontroly renálnych parametrov, oneskorené vyšetrenie albuminúrie, neskoršiu optimalizáciu nefroprotektívnej liečby, oneskorené nefrologické vyšetrenie alebo podcenenie kardiovaskulárneho rizika.</p>

<p>Naopak, konzervatívnejší odhad môže viesť k skoršej intervencii. To však neznamená, že každé nižšie vypočítané eGFR je automaticky pravdivejšie. Znamená to, že pri diabetickej populácii treba výsledok interpretovať v kontexte klinického obrazu, albuminúrie, trendu kreatinínu, liečby a komorbidít.</p>

<h2>Kreatinín má svoje limity</h2>

<p>Obe diskutované rovnice sú kreatinínové. Kreatinín je praktický a lacný biomarker, ale nie je dokonalý. Je ovplyvnený svalovou hmotou, stravou, vekom, pohlavím, niektorými liekmi a analytickými podmienkami merania. U pacientov s diabetom 2. typu môže byť situácia ešte zložitejšia pre obezitu, sarkopéniu, zápal, komorbidity a častú polyfarmakoterapiu.</p>

<p>Preto má pri neistote význam potvrdenie renálnej funkcie cystatínom C alebo kombinovanou kreatinínovo-cystatínovou rovnicou, ak je dostupná a klinicky opodstatnená. Najmä pri hraničných rozhodnutiach, dávkovaní rizikových liekov alebo neočakávanom nesúlade medzi klinikou a eGFR by nemalo zostať len pri jednom čísle z laboratórneho výpisu.</p>

<h2>Praktický nefrologický pohľad</h2>

<p>Pre nefrológa je hlavné posolstvo jednoduché: eGFR nie je absolútna hodnota nezávislá od metódy výpočtu. Pri pacientovi s diabetom 2. typu treba vedieť, akú rovnicu laboratórium používa, najmä ak sa rozhoduje o štádiu CKD, úprave dávok liekov alebo nefrologickom sledovaní.</p>

<p>V praxi má veľký význam trend. Jednorazová hodnota eGFR je menej informatívna než opakované merania v čase. Ak sa pacient podľa jednej rovnice nachádza v G1 a podľa inej v G2, klinické rozhodovanie by nemalo stáť iba na hranici 90 ml/min/1,73 m².</p>

<p>Rozhodujúce sú aj albuminúria, krvný tlak, glykemická kontrola, prítomnosť diabetickej retinopatie, kardiovaskulárne ochorenie, liečba inhibítorom SGLT2, blokáda systému renín-angiotenzín-aldosterón a celkový rizikový profil.</p>

<h2>Dôsledky pre liečbu a sledovanie</h2>

<p>Presnejšia identifikácia rizikových pacientov môže podporiť skoršie zavedenie alebo dôslednejšie využívanie nefroprotektívnych stratégií. Pri diabete 2. typu dnes ide najmä o:</p>

<ul>
  <li>pravidelné vyšetrenie eGFR a albuminúrie,</li>
  <li>dobrú kontrolu krvného tlaku,</li>
  <li>liečbu inhibítormi SGLT2, ak nie sú kontraindikované,</li>
  <li>blokádu systému renín-angiotenzín-aldosterón pri albuminúrii alebo hypertenzii,</li>
  <li>zváženie finerenónu u vhodných pacientov s pretrvávajúcou albuminúriou,</li>
  <li>individualizovanú glykemickú kontrolu,</li>
  <li>aktívnu redukciu kardiovaskulárneho rizika,</li>
  <li>včasné odoslanie k nefrológovi pri progresii, významnej albuminúrii alebo diagnostickej neistote.</li>
</ul>

<p>Výber rovnice teda nemá byť izolovanou laboratórnou otázkou. Môže ovplyvniť, ako skoro lekár rozpozná pacienta ako rizikového a ako intenzívne bude pristupovať k prevencii progresie CKD.</p>

<h2>Čo by malo zaujímať ambulanciu</h2>

<p>Pri diabetikovi s hraničnou eGFR alebo nesúladom medzi klinickým rizikom a číslom v laboratórnom výsledku je rozumné položiť si niekoľko otázok:</p>

<ol>
  <li><strong>Akú rovnicu používa laboratórium?</strong> CKD-EPI 2021, staršiu CKD-EPI, EKFC alebo inú lokálnu implementáciu?</li>
  <li><strong>Je výsledok konzistentný v čase?</strong> Jeden výpočet môže byť ovplyvnený hydratáciou, akútnym stavom alebo laboratórnou variabilitou.</li>
  <li><strong>Aká je albuminúria?</strong> Bez UACR je hodnotenie diabetického renálneho rizika neúplné.</li>
  <li><strong>Sedí eGFR s klinickým obrazom?</strong> Pri nízkej svalovej hmote môže kreatinín renálnu dysfunkciu maskovať.</li>
  <li><strong>Má rozhodnutie liekový alebo prognostický dopad?</strong> Ak áno, môže byť vhodné potvrdenie cystatínom C alebo nefrologická konzultácia.</li>
</ol>

<h2>Limity dostupných údajov</h2>

<p>Treba zdôrazniť, že zdrojový text má charakter krátkeho komentára alebo stručnej analytickej správy, nie rozsiahlej plne otvorenej štúdie s kompletnou metodikou dostupnou v otvorenom zobrazení. Z verejne dostupného extraktu preto nemožno detailne posúdiť všetky štatistické analýzy, charakteristiky kohorty, zastúpenie albuminúrie, liečbu pacientov ani možné konfúzne faktory.</p>

<p>Záver preto treba chápať opatrne. Práca podporuje význam správnej voľby a implementácie eGFR rovníc u pacientov s diabetom, ale nenahrádza individuálne klinické posúdenie pacienta a neznamená, že jedna rovnica je univerzálne najlepšia pre všetky populácie a všetky klinické situácie.</p>

<h2>Záver</h2>

<p>Článok upozorňuje na dôležitý praktický problém: u pacientov s diabetom 2. typu môže použitá rovnica na výpočet eGFR významne meniť zaradenie do G kategórií CKD. Rovnica EKFC v analyzovanej kohorte viedla ku konzervatívnejšiemu hodnoteniu renálnej funkcie a presunu časti pacientov z kategórie G1 do G2.</p>

<p>Pre klinickú prax je dôležité nehodnotiť eGFR mechanicky. U diabetikov má byť vždy interpretovaná spolu s albuminúriou, trendom renálnych parametrov a celkovým kardiometabolickým rizikom. Správny odhad funkcie obličiek môže pomôcť zachytiť rizikových pacientov skôr a umožniť včasnejšiu nefroprotektívnu intervenciu.</p>

<p>Najpraktickejšie posolstvo je jednoduché: poznať rovnicu, sledovať trend, neignorovať albuminúriu a pri hraničných rozhodnutiach si nevystačiť s jedným číslom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Zi Y, Fan W. Improving eGFR estimation in diabetic populations: insights from real-world data. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag081. doi:10.1093/joneph/aajag081. PMID: 42360207. <a href="https://academic.oup.com/joneph/advance-article-abstract/doi/10.1093/joneph/aajag081/8718966" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360207/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_egfr_diabetes newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_egfr_diabetes pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_egfr_diabetes pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_egfr_diabetes migration error: ' . $e->getMessage());
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
