<?php
/**
 * add_cheatsheet-diuretika_article.php
 * Ťahák (cheat sheet): Diuretiká. category = 'cheatsheet'.
 * Generované zo šablóny add_TEMPLATE_cheatsheet_article.php.
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
    'title'        => 'Diuretiká — ťahák',
    'slug'         => 'cheatsheet-diuretika',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Triedy diuretík a miesto účinku, dávkové ekvivalencie (slučkové, tiazidy, MRA), zásady pri diuretickej rezistencii a monitorovanie na jednej strane.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/cheatsheet-diuretika.svg" alt="Schéma nefrónu so štyrmi miestami účinku diuretík: acetazolamid v proximálnom tubule, slučkové diuretiká v hrubom vzostupnom raménku, tiazidy v distálnom tubule a MRA/amilorid v zbernom kanáliku." loading="lazy" decoding="async">
  <figcaption>Miesta účinku diuretík pozdĺž nefrónu.</figcaption>
</figure>

<p>Prehľad <strong>tried diuretík, miesta účinku, dávkových ekvivalencií</strong> a zásad pri diuretickej rezistencii. Pri renálnej diéte pozri <a href="nastroj_dieta.php">plánovač renálnej diéty</a>.</p>

<h2>Triedy a miesto účinku</h2>
<div class="table-responsive" role="region" aria-label="Triedy a miesto účinku" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Trieda</th><th scope="col">Zástupcovia</th><th scope="col">Miesto / cieľ</th></tr>
  </thead>
  <tbody>
    <tr><td>Slučkové</td><td>Furosemid, torasemid, bumetanid</td><td>Hrubé vzostupné raménko (NKCC2)</td></tr>
    <tr><td>Tiazidové / tiazidom podobné</td><td>Hydrochlorotiazid, chlortalidón, indapamid, metolazón</td><td>Distálny stočený tubulus (NCC)</td></tr>
    <tr><td>Antagonisty mineralokortikoidov (MRA)</td><td>Spironolaktón, eplerenón, finerenón*</td><td>Zberný kanálik — aldosterónový receptor</td></tr>
    <tr><td>Blokátory ENaC</td><td>Amilorid, triamterén</td><td>Zberný kanálik — epitelový Na kanál</td></tr>
    <tr><td>Inhibítory karboanhydrázy</td><td>Acetazolamid</td><td>Proximálny tubulus</td></tr>
    <tr><td>Osmotické</td><td>Manitol</td><td>Celý nefrón (osmóza)</td></tr>
    <tr><td>Vaptany (akvaretiká)</td><td>Tolvaptan</td><td>Zberný kanálik — V2 receptor (voľná voda)</td></tr>
  </tbody>
</table>
</div>
<p><em>* Finerenón je nesteroidný MRA — používa sa primárne ako <strong>nefroprotektívum</strong> pri CKD (nie ako diuretikum).</em></p>

<h2>Dávkové ekvivalencie — slučkové diuretiká</h2>
<div class="table-responsive" role="region" aria-label="Dávkové ekvivalencie — slučkové diuretiká" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Liek</th><th scope="col">Ekvivalentná dávka</th><th scope="col">Biologická dostupnosť (p.o.)</th></tr>
  </thead>
  <tbody>
    <tr><td>Furosemid</td><td>40 mg</td><td>~50 % (kolísavá, pri edéme čreva ↓)</td></tr>
    <tr><td>Torasemid</td><td>10–20 mg</td><td>~80–100 % (stabilná)</td></tr>
    <tr><td>Bumetanid</td><td>1 mg</td><td>~80–100 %</td></tr>
  </tbody>
</table>
</div>
<p><strong>Furosemid p.o. : i.v. = 2 : 1</strong> (40 mg p.o. ≈ 20 mg i.v.). Pri kolísavej absorpcii uprednostni torasemid alebo i.v. podanie.</p>

<h2>Dávkové ekvivalencie — tiazidy a MRA</h2>
<div class="table-responsive" role="region" aria-label="Dávkové ekvivalencie — tiazidy a MRA" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Liek</th><th scope="col">Približná ekvivalencia / poznámka</th></tr>
  </thead>
  <tbody>
    <tr><td>Hydrochlorotiazid 25 mg</td><td>Referenčná dávka</td></tr>
    <tr><td>Chlortalidón 12,5–25 mg</td><td>Účinnejší a dlhšie pôsobiaci (~1,5–2×), výhodný pri hypertenzii</td></tr>
    <tr><td>Indapamid 1,5–2,5 mg</td><td>Metabolicky neutrálnejší</td></tr>
    <tr><td>Spironolaktón 25–50 mg</td><td>≈ eplerenón 50 mg; spironolaktón má antiandrogénne NÚ (gynekomastia)</td></tr>
  </tbody>
</table>
</div>

<h2>Diuretická rezistencia — princípy</h2>
<ul>
  <li><strong>Prekročiť prah:</strong> slučkové diuretiká majú prahovú dávku — poddávkovanie nezaberie. Pri CKD/srdcovom zlyhaní treba vyššiu jednorazovú dávku.</li>
  <li><strong>Sekvenčná blokáda nefrónu:</strong> pridaj tiazid (napr. metolazón alebo chlortalidón) k slučkovému pri rezistencii.</li>
  <li><strong>Tiazidy pri nízkom eGFR:</strong> tradične menej účinné pri eGFR &lt; 30 ml/min/1,73 m²; metolazón a chlortalidón si časť účinku zachovávajú, využívajú sa v kombinácii.</li>
  <li><strong>Kontinuálna infúzia</strong> slučkového diuretika môže byť účinnejšia než bolusy pri ťažkom edéme.</li>
  <li>Pri hypoalbuminémii a nefrotickom syndróme je odpoveď znížená — rieš aj základnú príčinu.</li>
</ul>

<h2>Monitorovanie a nežiaduce účinky</h2>
<div class="table-responsive" role="region" aria-label="Monitorovanie a nežiaduce účinky" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Trieda</th><th scope="col">Sledovať</th></tr>
  </thead>
  <tbody>
    <tr><td>Slučkové</td><td>Hypokaliémia, hypomagneziémia, hyponatrémia, hypovolémia, ↑ kreatinín, ↑ urát (dna), ototoxicita pri vysokých i.v. dávkach</td></tr>
    <tr><td>Tiazidy</td><td>Hyponatrémia (typická!), hypokaliémia, hyperkalciémia, hyperurikémia, hyperglykémia, dyslipidémia</td></tr>
    <tr><td>MRA / ENaC blokátory</td><td><strong>Hyperkaliémia</strong> (najmä s RAAS-blokátorom alebo pri CKD), gynekomastia (spironolaktón)</td></tr>
    <tr><td>Acetazolamid</td><td>Metabolická acidóza (NAGMA), hypokaliémia</td></tr>
    <tr><td>Tolvaptan</td><td>Rýchla korekcia Na<sup>+</sup> (riziko ODS), smäd, hepatotoxicita (ADPKD)</td></tr>
  </tbody>
</table>
</div>

<hr>

<p><strong>Zdroje a odkazy:</strong></p>
<ul>
  <li><a href="https://pubmed.ncbi.nlm.nih.gov/29141174/" target="_blank" rel="noopener noreferrer">Ellison DH, Felker GM. Diuretic Treatment in Heart Failure. N Engl J Med 2017;377:1964–75</a></li>
  <li><a href="https://www.escardio.org/Guidelines/Clinical-Practice-Guidelines" target="_blank" rel="noopener noreferrer">ESC — Clinical Practice Guidelines (srdcové zlyhávanie)</a></li>
</ul>
<p><em>Dávky over vždy podľa platného SPC. Orientačná pomôcka — nenahrádza klinický úsudok.</em></p>
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
