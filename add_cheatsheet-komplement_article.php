<?php
/**
 * add_cheatsheet-komplement_article.php
 * Ťahák (cheat sheet): Komplement a komplementom sprostredkované choroby obličiek.
 * category = 'cheatsheet'. Generované zo šablóny add_TEMPLATE_cheatsheet_article.php.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať ťahák');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/pdf_generator.php';

$articles = [];

$articles[] = [
    'title'        => 'Komplement a choroby obličiek — ťahák',
    'slug'         => 'cheatsheet-komplement',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tri dráhy komplementu, interpretácia sérového C3/C4, komplementom sprostredkované glomerulopatie (C3G, aHUS, lupus, kryo) a komplement-cielené lieky na jednej strane.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/cheatsheet-komplement.svg" alt="Schéma troch dráh komplementu (klasická, lektínová, alternatívna) konvergujúcich na C3 konvertázu, štiepenie C3, ďalej C5 a membránový atakový komplex C5b-9." loading="lazy" decoding="async">
  <figcaption>Tri aktivačné dráhy komplementu konvergujú na C3 → C5 → MAC (C5b-9).</figcaption>
</figure>

<p>Ťahák k <strong>systému komplementu</strong> v nefrológii — tri aktivačné dráhy, interpretácia sérového C3/C4, komplementom sprostredkované choroby obličiek a cielené lieky. Diferenciálnu diagnostiku nefritíd podľa komplementu rieši <a href="nastroj_gn.php">interaktívny sprievodca GN</a>.</p>

<h2>Tri aktivačné dráhy</h2>
<table>
  <thead>
    <tr><th scope="col">Dráha</th><th scope="col">Spúšťač</th><th scope="col">Kľúčové zložky</th></tr>
  </thead>
  <tbody>
    <tr><td>Klasická</td><td>Imunokomplexy (C1q viaže IgG/IgM)</td><td>C1, <strong>C4</strong>, C2 → C3 konvertáza (C4b2a)</td></tr>
    <tr><td>Lektínová</td><td>Sacharidy patogénov (MBL/fikolíny)</td><td>MBL, MASP, <strong>C4</strong>, C2</td></tr>
    <tr><td>Alternatívna</td><td>Spontánna „tick-over“ + amplifikácia</td><td>Faktor B, faktor D, properdín → C3 konvertáza (C3bBb)</td></tr>
  </tbody>
</table>
<p>Všetky dráhy konvergujú na <strong>C3 → C5 → membránový atakový komplex (MAC, C5b-9)</strong>. Alternatívna dráha funguje aj ako <strong>amplifikačná slučka</strong> ostatných dvoch.</p>

<h2>Interpretácia sérového komplementu</h2>
<table>
  <thead>
    <tr><th scope="col">Vzor C3/C4</th><th scope="col">Aktivovaná dráha</th><th scope="col">Typické jednotky</th></tr>
  </thead>
  <tbody>
    <tr><td><strong>↓C3, normálny C4</strong></td><td>Alternatívna</td><td>C3 glomerulopatia, poststreptokoková GN</td></tr>
    <tr><td><strong>↓C3 aj ↓C4</strong></td><td>Klasická</td><td>Lupusová nefritída, kryoglobulinemická GN, imunokomplexová MPGN, endokarditída/shunt nefritída</td></tr>
    <tr><td><strong>Normálny C3 aj C4</strong></td><td>—</td><td>IgA nefropatia, ANCA-asociovaná, anti-GBM</td></tr>
  </tbody>
</table>

<h2>Komplementom sprostredkované choroby obličiek</h2>
<table>
  <thead>
    <tr><th scope="col">Jednotka</th><th scope="col">Komplement</th><th scope="col">Kľúč</th></tr>
  </thead>
  <tbody>
    <tr><td>C3 glomerulopatia (C3GN, choroba hustých depozitov)</td><td>↓C3, dysregulácia alternatívnej dráhy</td><td>C3-dominantný IF; C3 nefritický faktor, mutácie/protilátky regulátorov; sC5b-9</td></tr>
    <tr><td>Atypický HUS (aHUS)</td><td>Dysregulácia alternatívnej dráhy</td><td>Trombotická mikroangiopatia (trombocytopénia, hemolýza, AKI); mutácie CFH/CFI/MCP/C3/CFB</td></tr>
    <tr><td>Lupusová nefritída</td><td>↓C3 aj C4</td><td>ANA/anti-dsDNA; klasická dráha; trieda I–VI</td></tr>
    <tr><td>Kryoglobulinemická GN</td><td>↓↓C4</td><td>Často HCV; purpura, RF zvýšený</td></tr>
    <tr><td>Imunokomplexová MPGN</td><td>↓C3 ± C4</td><td>Infekcie, autoimunita, monoklonálna gamapatia</td></tr>
  </tbody>
</table>

<h2>Regulátory a genetika (aHUS / C3G)</h2>
<ul>
  <li><strong>Faktor H (CFH)</strong> — hlavný regulátor alternatívnej dráhy; strata funkcie (mutácia alebo anti-FH protilátky) → aHUS/C3G.</li>
  <li><strong>Faktor I (CFI), MCP/CD46</strong> — kofaktor a membránový regulátor; strata funkcie → aHUS.</li>
  <li><strong>C3, faktor B (CFB)</strong> — zisk funkcie (gain-of-function) → nadmerná aktivácia C3 konvertázy.</li>
  <li><strong>Trombomodulín (THBD)</strong> a ďalšie — zriedkavejšie príčiny aHUS.</li>
</ul>

<h2>Komplement-cielené lieky</h2>
<table>
  <thead>
    <tr><th scope="col">Cieľ</th><th scope="col">Liek</th><th scope="col">Indikácia (nefrológia)</th></tr>
  </thead>
  <tbody>
    <tr><td>Anti-C5</td><td>Ekulizumab, ravulizumab</td><td>aHUS (1. línia); refraktérna C3G</td></tr>
    <tr><td>Receptor C5a (C5aR)</td><td>Avakopan</td><td>ANCA-asociovaná vaskulitída (steroid-šetriaci)</td></tr>
    <tr><td>Faktor B</td><td>Iptakopan</td><td>C3 glomerulopatia, IgA nefropatia (skúšky/registrácie)</td></tr>
    <tr><td>C3</td><td>Pegcetakoplan</td><td>C3 glomerulopatia (klinické skúšky)</td></tr>
  </tbody>
</table>
<p><strong>Pozor:</strong> pred inhibíciou C5 <strong>očkovanie proti meningokokom</strong> (riziko invazívnej infekcie Neisseria); zváž antibiotickú profylaxiu.</p>

<hr>

<p><strong>Zdroje a odkazy:</strong></p>
<ul>
  <li><a href="https://kdigo.org/guidelines/gd/" target="_blank" rel="noopener noreferrer">KDIGO — Glomerular Diseases (klinické odporúčania)</a></li>
  <li><a href="https://pubmed.ncbi.nlm.nih.gov/24161035/" target="_blank" rel="noopener noreferrer">Noris M, Remuzzi G. Overview of Complement Activation and Regulation. Semin Nephrol 2013;33(6):479–92</a></li>
  <li><a href="https://clinicaltrials.gov/" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov — komplement-cielené terapie</a></li>
</ul>
<p><em>Orientačná pomôcka — nenahrádza klinický úsudok ani aktuálne SPC liekov.</em></p>
HTML,
];

$inserted = 0;
$updated  = 0;
$skipped  = 0;
$errors   = [];

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'cheatsheet', :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'cheatsheet', is_top = VALUES(is_top)"
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
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_cheatsheet pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_cheatsheet pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri ťaháku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_cheatsheet migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia ťaháka: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total ťahákov.\n";
    echo "Preskočené (bez zmeny):        $skipped\n";
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
      <title>Migrácia ťaháka</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia ťaháka</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> ťahákov. <?= $skipped ?> bez zmeny.</p>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="cheatsheets.php" class="btn-primary">← Späť na ťaháky</a>
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
