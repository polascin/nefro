<?php
/**
 * add_cheatsheet-membranozna-nefropatia_article.php
 * Ťahák (cheat sheet): Membranózna nefropatia (antigény, vyšetrenie, liečba).
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
    'title'        => 'Membranózna nefropatia — ťahák',
    'slug'         => 'cheatsheet-membranozna-nefropatia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Cieľové antigény (PLA2R, THSD7A, NELL1, EXT1/2…), primárne vs sekundárne príčiny, vyšetrenie, riziková stratifikácia (KDIGO) a liečba membranóznej nefropatie na jednej strane.',
    'content'      => <<<'HTML'
<p>Ťahák k <strong>membranóznej nefropatii</strong> — najčastejšej príčine nefrotického syndrómu u nediabetických dospelých. Podklad: subepiteliálne imunokomplexy a aktivácia komplementu. Diferenciálnu diagnostiku nefrotického syndrómu rieši <a href="nastroj_gn.php">interaktívny sprievodca GN</a>.</p>

<h2>Cieľové antigény (fáza podocytu)</h2>
<table>
  <thead>
    <tr><th scope="col">Antigén</th><th scope="col">Podiel / kontext</th><th scope="col">Asociácia</th></tr>
  </thead>
  <tbody>
    <tr><td><strong>PLA2R</strong></td><td>~70 % primárnych</td><td>Sérová protilátka koreluje s aktivitou a prognózou</td></tr>
    <tr><td>THSD7A</td><td>~1–3 %</td><td>Občas malignita</td></tr>
    <tr><td>NELL1</td><td>~5–10 %</td><td>Často sekundárna — malignita, lieky (vrátane tradičnej medicíny)</td></tr>
    <tr><td>EXT1/EXT2</td><td>autoimunitná</td><td>Lupus a autoimunita; zvyčajne lepšia prognóza</td></tr>
    <tr><td>Semaforín-3B</td><td>pediatrická/skorá</td><td>Deti a mladí dospelí</td></tr>
    <tr><td>PCDH7, NCAM1</td><td>zriedkavé</td><td>PCDH7 často bez imunosupresie; NCAM1 pri lupuse</td></tr>
  </tbody>
</table>

<h2>Primárna vs sekundárna</h2>
<table>
  <thead>
    <tr><th scope="col">Kategória</th><th scope="col">Príčiny</th></tr>
  </thead>
  <tbody>
    <tr><td>Primárna (~75–80 %)</td><td>Autoimunitná, najčastejšie anti-PLA2R; IgG4-dominantná v IF</td></tr>
    <tr><td>Malignita</td><td>Solídne nádory (pľúca, GIT, prostata, prsník) — skríning podľa veku, najmä pri NELL1/THSD7A</td></tr>
    <tr><td>Autoimunita</td><td>Lupus (trieda V), autoimunitná tyreoiditída, sarkoidóza</td></tr>
    <tr><td>Infekcie</td><td>Hepatitída B a C, syfilis, malária</td></tr>
    <tr><td>Lieky</td><td>NSA, penicilamín, zlato, anti-TNF</td></tr>
  </tbody>
</table>

<h2>Vyšetrenie</h2>
<ul>
  <li><strong>Anti-PLA2R protilátky</strong> (sérum, ELISA/IFA) — pozitivita podporuje primárnu MN a často umožní diagnózu aj bez biopsie; titer slúži na monitoring odpovede.</li>
  <li><strong>Renálna biopsia:</strong> subepiteliálne depozity, „spikes" na striebornom farbení; IF granulárny IgG (IgG4 pri primárnej); EM štádiá I–IV (Ehrenreich–Churg). Tkanivový PLA2R/THSD7A/NELL1 farbením.</li>
  <li><strong>Skríning sekundárnych príčin</strong> podľa veku a kontextu: malignita, sérológie hepatitíd, ANA/anti-dsDNA, TSH.</li>
  <li>Kvantifikácia proteinúrie, albumín, eGFR; posúdenie rizika trombózy.</li>
</ul>

<h2>Riziková stratifikácia (KDIGO) a liečba</h2>
<table>
  <thead>
    <tr><th scope="col">Riziko</th><th scope="col">Znaky (orientačne)</th><th scope="col">Liečba</th></tr>
  </thead>
  <tbody>
    <tr><td>Nízke</td><td>Normálny eGFR, proteinúria &lt; 3,5 g/deň a normálny albumín; alebo pokles proteinúrie &gt; 50 % pri podpornej liečbe</td><td>Podporná renoprotekcia, sledovanie</td></tr>
    <tr><td>Stredné</td><td>Normálny eGFR, proteinúria &gt; 3,5 g pretrváva napriek 6 mes. podpornej liečby</td><td>Zváž imunosupresiu (rituximab alebo CNI ± rituximab)</td></tr>
    <tr><td>Vysoké</td><td>eGFR &lt; 60 alebo proteinúria &gt; 8 g/deň; nízky albumín, vysoký/rastúci anti-PLA2R</td><td>Imunosupresia: rituximab; cyklofosfamid + glukokortikoidy (Ponticelli)</td></tr>
    <tr><td>Veľmi vysoké</td><td>Život ohrozujúci nefrotický syndróm alebo rýchly pokles funkcie</td><td>Cyklofosfamid + glukokortikoidy; urýchlene</td></tr>
  </tbody>
</table>

<h2>Podporná liečba a komplikácie</h2>
<ul>
  <li><strong>Renoprotekcia u všetkých:</strong> RAAS blokáda, cieľový TK, obmedzenie soli, statín, diuretiká pri edémoch; SGLT2 inhibítor podľa indikácie.</li>
  <li><strong>Tromboprofylaxia:</strong> nefrotický syndróm zvyšuje riziko VTE/renálnej trombózy — zváž antikoaguláciu pri <strong>albumíne &lt; 25 g/l</strong> a ďalších rizikových faktoroch.</li>
  <li><strong>Monitoring anti-PLA2R:</strong> imunologická odpoveď (pokles titra) predchádza klinickej remisii; perzistujúci titer = vyššie riziko relapsu.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> KDIGO 2024 (a 2021) Clinical Practice Guideline for the Management of Glomerular Diseases. Orientačná pomôcka — nenahrádza klinický úsudok ani biopsiu.</em></p>
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
        $errors[] = 'Chyba pri ťaháku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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
