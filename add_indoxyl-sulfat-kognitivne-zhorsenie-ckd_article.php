<?php
/**
 * add_indoxyl-sulfat-kognitivne-zhorsenie-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): indoxyl sulfát a kognitívne
 * zhoršenie pri CKD (tryptofánové deriváty). Slovenské spracovanie zdroja
 * (Medscape Medical News / Clinical Kidney Journal).
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_indoxyl-sulfat-kognitivne-zhorsenie-ckd_article.php"
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
    'title'        => 'Indoxyl sulfát a kognitívne zhoršenie pri chronickej chorobe obličiek: čo vieme z derivátov tryptofánu',
    'slug'         => 'indoxyl-sulfat-kognitivne-zhorsenie-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prierezová analýza francúzskej kohorty CKD (2389 dospelých): vyššie hladiny indoxyl sulfátu nezávisle súviseli s kognitívnym poškodením (MMSE ≤ 26/30), kým kynurenín a indole-3-acetát nie. Signál pre biomarkery a rizikovú stratifikáciu, nie terapeutické odporúčanie.',
    'content'      => <<<'HTML'
<p>Pacienti s chronickou chorobou obličiek (CKD) majú vyššie riziko neurologických komplikácií,
ale biologické mechanizmy a využiteľné biomarkery nie sú úplne jasné. V poslednom prehľade na Medscape sa rieši súvislosť medzi metabolitmi odvodenými od tryptofánu, najmä uremickým toxínom
<strong>indoxyl sulfátom (IS)</strong>, a kognitívnym poškodením u pacientov s CKD.</p>

<h2>Cieľ štúdie</h2>
<p>Autori skúmali, či sa hladiny tryptofánových uremických derivátov (<strong>indoxyl sulfát</strong>,
<strong>kynurenín</strong>, <strong>indole-3-acetát</strong>) viažu na <strong>kognitívne
zhoršenie</strong> u dospelých s CKD.</p>

<h2>Dizajn a populácia</h2>
<p>Ide o <strong>prierezovú (cross-sectional) analýzu</strong> francúzskej kohorty (2013 až 2016).
Do analýzy bolo zahrnutých <strong>2389 dospelých</strong> s CKD <strong>stupňa 2 až 5</strong>, bez
predchádzajúcej dialýzy alebo transplantácie, ktorí mali dostupné:</p>
<ul>
  <li>merania uremických toxínov (voľné sérové hladiny merané validovanou metodikou LC-MS/MS),</li>
  <li>výsledok kognitívneho skríningu.</li>
</ul>
<p>Kognitívne zhoršenie sa hodnotilo pomocou <strong>Mini-Mental State Examination (MMSE)</strong>,
pričom za poškodenie sa považovalo <strong>MMSE skóre ≤ 26/30</strong>.</p>

<h2>Hlavné výsledky</h2>
<p>V kohorte malo kognitívne zhoršenie <strong>858 pacientov (35,9 %)</strong>.</p>
<p>Najdôležitejší nález:</p>
<ul>
  <li><strong>vyššie sérové hladiny indoxyl sulfátu</strong> boli <strong>nezávisle</strong> spojené
      s vyššou pravdepodobnosťou kognitívneho poškodenia (upravené OR <strong>1,11</strong>,
      <em>P</em> = 0,03),</li>
  <li>v analýze citlivosti (porovnanie s najnižšou skupinou IS) bola skupina s najvyšším IS spojená
      s <strong>viac než 40 % vyššou pravdepodobnosťou</strong> MMSE ≤ 26/30 (upravené OR
      <strong>1,43</strong>, <em>P</em> = 0,02).</li>
</ul>
<p>Naopak:</p>
<ul>
  <li><strong>kynurenín</strong> a <strong>indole-3-acetát</strong> nepreukázali signifikantnú
      asociáciu s kognitívnym poškodením.</li>
</ul>

<h3>„Takeaway" z článku</h3>
<p>V rámci tryptofánových cirkulujúcich derivátov vychádza, že <strong>IS</strong> je ten, ktorý sa
viaže ku kognitívnemu zhoršeniu pri CKD, zatiaľ čo <strong>KYN</strong> (kynurenín) a
<strong>IAA</strong> (indole-3-acetát) nie.</p>

<h2>Preklad do nefrologickej praxe: čo to môže znamenať</h2>
<p>Ak je táto asociácia stabilná aj v prospektívnych štúdiách, IS by sa mohol stať praktickým
biomarkerom „biologického rizika" neurologických komplikácií pri CKD. Z praktického pohľadu to
otvára dve roviny:</p>
<ol>
  <li><strong>Riziková stratifikácia.</strong> Pacienti s vyšším IS môžu byť „viac ohrození", čo môže
      byť užitočné pri plánovaní sledovania kognície alebo pri práci s rizikami, ktoré kogníciu
      zhoršujú (napr. vaskulárne faktory, zápal, anémia, urémia).</li>
  <li><strong>Mechanistické prepojenie.</strong> Keďže ide o uremický toxín, výsledok podporuje úvahu,
      že niektoré tryptofánové metabolity môžu byť súčasťou biologickej osi vedúcej k neurologickému
      poškodzovaniu pri CKD.</li>
</ol>
<p>Zároveň však treba byť opatrný: ide o <strong>prierezové dáta</strong>, takže z toho nejde priamo
vyvodiť kauzalitu ani to, že zníženie IS automaticky zlepší kogníciu.</p>

<h2>Limity, ktoré sú dôležité na správnu interpretáciu</h2>
<p>Medscape explicitne uvádza limity, ktoré si zaslúžia zdôrazniť:</p>
<ul>
  <li><strong>prierezový dizajn</strong> neumožňuje určiť príčinu a následok,</li>
  <li><strong>MMSE</strong> nemusí optimálne zachytiť všetky domény kognície, najmä
      <strong>exekutívne funkcie</strong>, čo môže viesť k skresleniu merania,</li>
  <li>štúdia nezohľadnila vplyv <strong>diétnych faktorov a výživy</strong>.</li>
</ul>

<h2>Záver</h2>
<p>V tejto francúzskej kohorte pacientov s CKD vyššie hladiny <strong>indoxyl sulfátu</strong>
nezávisle súviseli s vyššou pravdepodobnosťou <strong>kognitívneho poškodenia</strong>, zatiaľ čo
<strong>kynurenín</strong> a <strong>indole-3-acetát</strong> asociáciu nepreukázali. Pre klinickú
prax je to zaujímavý signál, ale zatiaľ skôr podnet pre výskum biomarkerov a rizikovej stratifikácie
než hotové terapeutické odporúčanie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Gaye Hafez et al., „Tryptophan Metabolite Indoxyl Sulphate Levels Tied
to Cognitive Impairment in CKD", <em>Clinical Kidney Journal</em> (spracované v <em>Medscape Medical
News</em>, 2026).
<a href="https://www.medscape.com/viewarticle/tryptophan-metabolite-indoxyl-sulphate-levels-tied-cognitive-2026a1000l83" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_indoxyl newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_indoxyl pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_indoxyl pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_indoxyl migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
