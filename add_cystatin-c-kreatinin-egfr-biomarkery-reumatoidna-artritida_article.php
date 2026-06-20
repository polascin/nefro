<?php
/**
 * add_cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida_article.php"
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
    'title'        => 'Cystatín C a kreatinínové odhady eGFR vs. biomarkery aktivity reumatoidnej artritídy: čo prináša sekundárna analýza randomizovanej štúdie',
    'slug'         => 'cystatin-c-kreatinin-egfr-biomarkery-reumatoidna-artritida',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Sekundárna analýza randomizovanej štúdie pri aktívnej reumatoidnej artritíde: eGFR z cystatínu C je konzistentne nižší než z kreatinínu už na začiatku a zmena TNFR1 súvisí so zmenou eGFRcys, nie eGFRcr.',
    'content'      => <<<'HTML'
<p>Reumatoidná artritída (RA) je chronické systémové zápalové ochorenie, ktoré okrem kĺbov zasahuje aj ďalšie orgánové systémy vrátane obličiek. V klinickej praxi sa funkcia obličiek najčastejšie monitoruje nepriamo – prostredníctvom odhadov glomerulárnej filtrácie z koncentrácií kreatinínu a cystatínu C. Pri RA však môže byť interpretácia týchto testov problematická: samotný chronický zápal, zmeny svalovej hmoty (sarkopénia) aj liečba môžu ovplyvňovať tvorbu alebo hladiny týchto markerov, a tým aj výsledné odhady eGFR.</p>

<p>Cieľom práce, z ktorej tento prehľad vychádza, bolo charakterizovať, ako sa v čase menia odhady glomerulárnej filtrácie založené na cystatíne C (eGFRcys) a na kreatiníne (eGFRcr), a následne zhodnotiť ich vzťah k biomarkerom aktivity RA meraným v rámci randomizovanej klinickej štúdie.</p>

<h2>Dizajn štúdie a populácia</h2>

<p>Ide o <strong>sekundárnu observačnú analýzu</strong> randomizovanej štúdie, ktorá porovnávala dve stratégie liečby aktívnej RA:</p>

<ol>
  <li><strong>inhibítor TNF v kombinácii s metotrexátom (MTX)</strong>,</li>
  <li><strong>trojkombinácia (MTX, sulfasalazín a hydroxychlorochín)</strong>.</li>
</ol>

<p>Štúdia sa uskutočnila u pacientov s aktívnou RA z viacerých pracovísk v USA. Analyzovaný súbor tvorilo <strong>157 oprávnených účastníkov</strong>, medián veku bol <strong>58 rokov</strong> a <strong>75 % tvorili ženy</strong>.</p>

<h2>Sledované ukazovatele</h2>

<p>Východisková situácia a jej ďalší vývoj sa hodnotili v časových bodoch <strong>vstupné vyšetrenie (baseline), 6., 18. a 24. týždeň</strong>.</p>

<h3>Primárne cieľové ukazovatele</h3>

<ul>
  <li>eGFRcys,</li>
  <li>eGFRcr.</li>
</ul>

<p>Štúdia nezahŕňala priamo meranú GFR (napríklad izotopovou metódou); išlo výlučne o výpočtové odhady z laboratórnych parametrov.</p>

<h3>Biomarkery aktivity RA</h3>

<p>Autori analyzovali vzťahy medzi odhadmi eGFR a viacerými biomarkermi zápalovej aktivity. Medzi významne asociované patrili najmä:</p>

<ul>
  <li>vaskulárny bunkový adhézny proteín 1 (VCAM-1),</li>
  <li>interleukín 6 (IL-6),</li>
  <li>receptor 1 pre TNF (TNFR1),</li>
  <li>leptín,</li>
  <li>rezistín.</li>
</ul>

<h2>Výsledky</h2>

<h3>1. Rozdiel medzi eGFRcys a eGFRcr už na začiatku</h3>

<p>Pri vstupnom vyšetrení bol <strong>priemerný eGFRcys nižší než eGFRcr</strong>:</p>

<ul>
  <li>eGFRcys: <strong>63,3</strong>,</li>
  <li>eGFRcr: <strong>84,2</strong>,</li>
  <li>rozdiel: <strong>−20,9 ml/min/1,73 m²</strong> (95 % interval spoľahlivosti, ďalej IS: −24,7 až −17,0).</li>
</ul>

<p>Tento nález naznačuje, že u pacientov s aktívnou RA môžu byť kreatinínové a cystatínové odhady systematicky odlišné už v čase zaradenia do štúdie, teda pred plným rozvinutím účinku liečby.</p>

<h3>2. Zmena eGFR počas 24 týždňov</h3>

<p>Počas <strong>24 týždňov</strong> sa v celej kohorte <strong>nezistila významná celková zmena</strong> ani pre eGFRcys, ani pre eGFRcr:</p>

<ul>
  <li>zmena eGFRcys: <strong>+1,74 ml/min/1,73 m²</strong> (95 % IS −0,77 až 4,24),</li>
  <li>zmena eGFRcr: <strong>−0,28 ml/min/1,73 m²</strong> (95 % IS −3,71 až 3,15).</li>
</ul>

<p>Inými slovami, hoci sa v štúdii hodnotila aktivita RA a jej biomarkery, odhady funkcie obličiek sa na makroúrovni významne nemenili.</p>

<h3>3. Asociácie biomarkerov zápalu a eGFR na začiatku</h3>

<p>Po úprave na viaceré faktory bolo niekoľko biomarkerov aktivity RA <strong>inverzne asociovaných</strong> s eGFRcys, prípadne s eGFRcr. Inverzná väzba sa explicitne uvádza pre:</p>

<ul>
  <li>VCAM-1,</li>
  <li>IL-6,</li>
  <li>TNFR1,</li>
  <li>leptín,</li>
  <li>rezistín.</li>
</ul>

<p>Z klinického pohľadu tento výsledok podporuje myšlienku, že pri RA nejde o „obličky ako izolovaný orgán“ – zápalové prostredie môže odrážať alebo ovplyvňovať laboratórne parametre, z ktorých sa eGFR počíta.</p>

<h3>4. Zmena biomarkerov v čase a vzťah k zmene eGFR</h3>

<p>Počas sledovania sa ukázalo, že zmeny biomarkerov nemajú rovnaký vzťah ku všetkým typom odhadov eGFR:</p>

<ul>
  <li><strong>iba zmena TNFR1</strong> (receptor I pre TNF) bola <strong>inverzne asociovaná so zmenou eGFRcys</strong> – zmena eGFRcys: <strong>−2,91 ml/min/1,73 m²</strong> (95 % IS −4,48 až −1,33),</li>
  <li><strong>žiadna zmena biomarkerov</strong> nebola významne spojená so zmenou <strong>eGFRcr</strong>.</li>
</ul>

<p>Toto zistenie je dôležité, pretože naznačuje odlišnú citlivosť, prípadne odlišnú mechanizmovú cestu cystatínového a kreatinínového odhadu v kontexte dynamiky zápalu po liečbe RA.</p>

<h2>Interpretácia a klinické implikácie</h2>

<p>Zistenia tejto práce možno zhrnúť do niekoľkých praktických bodov:</p>

<ol>
  <li><strong>Systémový rozdiel medzi eGFRcys a eGFRcr je prítomný už na začiatku</strong> aktívnej RA. Môže to znamenať buď rozdielne „vykazovanie“ reálnej renálnej funkcie v závislosti od mechanizmov ochorenia, alebo vplyv mimorenálnych faktorov na samotné markery.</li>
  <li><strong>Po 24 týždňoch liečby RA sa celkový eGFR (cystatínový ani kreatinínový) významne nemenil.</strong> Neznamená to, že obličky sú nezúčastnené, ale skôr to, že v tomto časovom okne pravdepodobne nedošlo k výraznej zmene GFR, prípadne boli zmeny malé a prekryté variabilitou.</li>
  <li><strong>Biomarkery zápalu sú spojené s nižším eGFR (najmä cystatínovým) už pri vstupnom vyšetrení.</strong> To môže byť relevantné u pacientov s aktívnou RA, u ktorých sa súčasne posudzuje renálna bezpečnosť liečby.</li>
  <li><strong>Zmena jedného z ukazovateľov osi TNF súvisela so zmenou eGFRcys</strong>, nie však s eGFRcr. Ak sa tento vzor potvrdí v ďalších štúdiách, môže ovplyvniť výber odhadu eGFR pri sledovaní vplyvu zápalu a liečby na „renálne“ laboratórne ukazovatele.</li>
</ol>

<h2>Limity štúdie</h2>

<p>Autori uvádzajú viaceré obmedzenia, ktoré treba pri interpretácii zohľadniť:</p>

<ul>
  <li><strong>GFR sa nemerala priamo</strong>, takže nevieme, či rozdiely odrážajú skutočnú zmenu filtrácie, alebo skôr vplyv zápalu, prípadne liečby na markery;</li>
  <li><strong>sledovanie bolo relatívne krátke</strong> (24 týždňov);</li>
  <li>existuje riziko <strong>falošne pozitívnych asociácií</strong>, keďže sa hodnotilo veľké množstvo vzťahov medzi biomarkermi a eGFR.</li>
</ul>

<h2>Záver</h2>

<p>V populácii pacientov s aktívnou RA, ktorí dostávali buď konvenčný režim (trojkombinácia), alebo inhibítor TNF, štúdia ukázala, že:</p>

<ul>
  <li><strong>eGFRcys je konzistentne nižší než eGFRcr už na začiatku</strong>,</li>
  <li><strong>počas 24 týždňov sa celkový eGFR významne nezmenil</strong>,</li>
  <li>viaceré biomarkery aktivity RA boli inverzne asociované s eGFR (najmä pri vstupnom vyšetrení),</li>
  <li>v dynamike po liečbe sa pozorovala <strong>špecifická asociácia zmeny TNFR1 so zmenou eGFRcys</strong>, zatiaľ čo zmena eGFRcr takto nesúvisela.</li>
</ul>

<p>Autori preto oprávnene zdôrazňujú, že budú potrebné ďalšie štúdie, ideálne so <strong>zahrnutím priamo meranej GFR</strong>, aby sa upresnilo, do akej miery ide o skutočnú zmenu renálnej funkcie a do akej o „artefakt“ spôsobený zápalom a mimorenálnymi determinantmi markerov.</p>

<hr>

<p><em><strong>Zdroj:</strong> <em>Cystatin C and Creatinine-Based Estimated GFR and Disease Activity Biomarkers in Rheumatoid Arthritis</em>, American Journal of Kidney Diseases (AJKD), 2026. DOI: 10.1053/j.ajkd.2026.01.014. <a href="https://www.ajkd.org/article/S0272-6386(26)00848-6/abstract" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
