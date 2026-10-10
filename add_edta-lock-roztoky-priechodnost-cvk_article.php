<?php
/**
 * add_edta-lock-roztoky-priechodnost-cvk_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_edta-lock-roztoky-priechodnost-cvk_article.php"
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'EDTA lock roztoky: môžu zlepšiť priechodnosť centrálnych venóznych katétrov?',
    'slug'         => 'edta-lock-roztoky-priechodnost-cvk',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia v časopise JAMA naznačuje, že 4 % tetrasodný EDTA lock roztok môže na JIS znížiť komplikácie centrálnych venóznych katétrov. Prínos sa však týkal najmä poklesu oklúzií, nie jednoznačného zníženia katétrových infekcií.',
    'content'      => <<<'HTML'
<figure><a href="img/edta-lock-roztoky-priechodnost-cvk.webp" rel="noopener noreferrer" target="_blank"><img src="img/edta-lock-roztoky-priechodnost-cvk.webp" alt="Katéter naplnený čírym svetelným roztokom, ktorý rozpúšťa tmavé usadeniny a obnovuje prietok" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Zámok pôsobí priamo v lúmene – otázkou zostáva, ako dlho priechodnosť udrží.</figcaption></figure>

<p>Kriticky chorí pacienti sa bez centrálneho venózneho katétra často nezaobídu. Katéter však prináša riziko krvnej infekcie, oklúzie a trombózy súvisiacej s katétrom. Tieto komplikácie zvyšujú morbiditu, predlžujú hospitalizáciu a zvyšujú náklady na zdravotnú starostlivosť.</p>

<p>Jednou z možností prevencie sú lock roztoky, teda roztoky ponechávané v lúmene katétra v čase, keď sa daný vstup nepoužíva. Majú znížiť riziko upchatia katétra, obmedziť tvorbu biofilmu a zachovať funkčnosť cievneho vstupu.</p>

<p>Nová klinická štúdia publikovaná v časopise <em>JAMA</em> naznačuje, že 4 % tetrasodný EDTA lock roztok môže v podmienkach jednotiek intenzívnej starostlivosti znížiť výskyt komplikácií spojených s centrálnymi venóznymi katétrami. Prínos sa však týkal najmä oklúzií katétra, nie jednoznačného poklesu katétrových infekcií.</p>

<h2>Prečo práve EDTA?</h2>

<p>EDTA, teda kyselina etyléndiamíntetraoctová vo forme tetrasodnej soli, pôsobí ako chelátor katiónov. Viazaním iónov môže ovplyvniť procesy súvisiace s koaguláciou, stabilitou biofilmu a mikrobiálnou adherenciou.</p>

<p>Pri použití v lock roztoku sa od EDTA očakávajú najmä tri účinky:</p>

<ul>
  <li>antikoagulačný efekt v lúmene katétra,</li>
  <li>obmedzenie tvorby bakteriálneho biofilmu,</li>
  <li>zlepšenie priechodnosti katétra.</li>
</ul>

<p>Kombinácia antikoagulačných a antibiofilmových vlastností robí z EDTA zaujímavú alternatívu k bežným lock roztokom, ako je fyziologický roztok alebo citrát.</p>

<h2>Dizajn štúdie</h2>

<p>Išlo o pragmatickú, multicentrickú, klastrovo randomizovanú, trojito zaslepenú crossover štúdiu. Prebiehala v šiestich akademických aj komunitných nemocniciach v Kanade.</p>

<p>Do analýzy bolo zahrnutých 1468 dospelých pacientov prijatých na jednotku intenzívnej starostlivosti. Všetci mali funkčný centrálny venózny katéter a aspoň jeden nepoužívaný lúmen. Priemerný vek pacientov bol 60 rokov a väčšinu tvorili muži.</p>

<p>Jednotky intenzívnej starostlivosti boli randomizované na používanie identických, zaslepených, predplnených striekačiek s 2,5 ml 4 % tetrasodného EDTA alebo kontrolného lock roztoku. Kontrolou bol fyziologický roztok, prípadne 4 % citrát pri hemodialyzačných linkách.</p>

<p>Každé pracovisko používalo jednu stratégiu počas 3,5 mesiaca, potom prešlo na druhú stratégiu počas ďalších 3,5 mesiaca. Súčasťou bol aj 1-mesačný udržiavací interval.</p>

<h2>Menej komplikácií, najmä menej oklúzií</h2>

<p>Primárnym cieľom bola kombinovaná incidencia troch udalostí:</p>

<ul>
  <li>krvná infekcia súvisiaca s centrálnym venóznym katétrom,</li>
  <li>oklúzia katétra vyžadujúca použitie alteplázy,</li>
  <li>odstránenie katétra pre oklúziu.</li>
</ul>

<p>Výsledok vyznel v prospech EDTA. Kombinovaný cieľ sa pri EDTA vyskytol s incidenciou 13,1 udalosti na 1000 katétrových dní, pri kontrolnom lock roztoku 19,9 udalosti na 1000 katétrových dní.</p>

<p>Pomer incidencií bol 0,68, 95 % interval spoľahlivosti 0,47 až 0,96 a hodnota <em>P</em> = 0,03. EDTA lock roztok bol teda spojený s približne tretinovým relatívnym znížením kombinovaného cieľa.</p>

<p>Celkový prínos však vychádzal najmä zo zníženia oklúzií katétra vyžadujúcich alteplázu. Práve táto zložka kombinovaného cieľa sa medzi skupinami významne líšila.</p>

<h2>Infekcie sa významne neznížili</h2>

<p>Aj keď kombinovaný cieľ vyznel v prospech EDTA, výsledky jednotlivých zložiek boli menej jednoznačné.</p>

<p>Štúdia nepreukázala štatisticky významný rozdiel v miere katétrových krvných infekcií. To naznačuje, že hlavný klinický prínos EDTA v tejto štúdii spočíval skôr v zachovaní priechodnosti katétra než v jasne dokázanom antiinfekčnom účinku.</p>

<p>EDTA síce môže mať antibiofilmové vlastnosti, v tejto štúdii sa však najpresvedčivejšie prejavil účinok na prevenciu oklúzie. Výsledky preto nedovoľujú tvrdiť, že EDTA jednoznačne znižuje katétrové infekcie v intenzívnej starostlivosti.</p>

<h2>Klinický význam zachovania priechodnosti</h2>

<p>Menej oklúzií katétra má praktický význam. Kriticky chorí pacienti často potrebujú spoľahlivý centrálny venózny prístup na podávanie vazopresorov, antibiotík, parenterálnej výživy, sedácie, tekutín alebo iných liekov.</p>

<p>Ak sa lúmen katétra upchá, môže to znamenať:</p>

<ul>
  <li>potrebu podania alteplázy,</li>
  <li>oneskorenie liečby,</li>
  <li>opakované manipulácie s katétrom,</li>
  <li>riziko predčasného odstránenia katétra,</li>
  <li>potrebu zavedenia nového invazívneho vstupu.</li>
</ul>

<p>Aj relatívne mierne zníženie počtu oklúzií preto môže byť pre jednotku intenzívnej starostlivosti významné, najmä pri veľkom počte pacientov a dlhšom používaní centrálnych venóznych vstupov.</p>

<h2>Bez významného bezpečnostného signálu</h2>

<p>Podľa dostupných údajov zo štúdie neboli hlásené relevantné bezpečnostné signály spojené s použitím 4 % tetrasodného EDTA. To hovorí v prospech jeho ďalšieho hodnotenia a možného využitia v klinickej praxi.</p>

<p>Pri plošnom zavádzaní je však namieste opatrnosť. Lock roztoky sa používajú v citlivom prostredí, kde rozhoduje presná koncentrácia, objem, kompatibilita s typom katétra, protokol používania, zaškolenie personálu a prevencia chýb pri manipulácii.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Štúdia podporuje úvahu, že 4 % tetrasodný EDTA lock roztok môže byť vhodnou alternatívou k štandardným lock roztokom u kriticky chorých pacientov s centrálnymi venóznymi katétrami, najmä ak je problémom častá oklúzia lúmenov.</p>

<p>Silnou stránkou štúdie je multicentrický crossover dizajn a pragmatické usporiadanie, ktoré lepšie odráža reálnu klinickú prax. Výsledky však treba čítať presne: prínos bol skôr v priechodnosti katétra než v preukázanom znížení infekcií.</p>

<p>Pred rutinným zavedením do praxe treba zvážiť:</p>

<ul>
  <li>cena a dostupnosť EDTA roztoku,</li>
  <li>lokálna incidencia oklúzií katétrov,</li>
  <li>porovnanie s existujúcimi protokolmi,</li>
  <li>bezpečnosť pri konkrétnych typoch katétrov,</li>
  <li>štandardizácia prípravy a aplikácie,</li>
  <li>vplyv na potrebu alteplázy a výmenu katétrov.</li>
</ul>

<h2>Praktický záver</h2>

<p>4 % tetrasodný EDTA lock roztok v tejto štúdii znížil kombinovaný výskyt komplikácií spojených s centrálnymi venóznymi katétrami u pacientov na JIS. Prínos však vychádzal najmä zo zníženia počtu oklúzií katétra vyžadujúcich alteplázu. Štatisticky významné zníženie katétrových krvných infekcií sa nepreukázalo.</p>

<p>EDTA lock roztok tak môže byť sľubnou stratégiou na udržanie priechodnosti centrálnych venóznych katétrov, nemal by sa však prezentovať ako jednoznačne dokázaný prostriedok prevencie infekcií.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>EDTA Lock Solutions: Could Catheter Patency Improve?</em> (2026). <a href="https://www.medscape.com/viewarticle/edta-lock-solutions-could-catheter-patency-improve-2026a1000imz" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        }

    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
