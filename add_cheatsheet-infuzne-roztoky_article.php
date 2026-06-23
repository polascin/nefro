<?php
/**
 * add_cheatsheet-infuzne-roztoky_article.php
 * Ťahák (cheat sheet): Infúzne roztoky. category = 'cheatsheet'.
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
    'title'        => 'Infúzne roztoky — ťahák',
    'slug'         => 'cheatsheet-infuzne-roztoky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zloženie a výber infúznych roztokov: kryštaloidy vs. koloidy, tonicita, obsah elektrolytov, balansované roztoky vs. fyziologický roztok a zásady pri náhrade objemu a udržiavacej terapii.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/cheatsheet-infuzne-roztoky.svg" alt="Štyri infúzne vaky s obsahom sodíka a tonicitou: 0,9 % NaCl (Na 154, izotonický), Ringer-laktát (Na 130, balansovaný), Plasma-Lyte (Na 140, balansovaný) a 5 % glukóza (voľná voda, hypotonický efekt)." loading="lazy" decoding="async">
  <figcaption>Najčastejšie kryštaloidy — obsah sodíka a tonicita.</figcaption>
</figure>

<p>Prehľad <strong>zloženia a výberu infúznych roztokov</strong> — koncentrácie elektrolytov, tonicita a klinické zásady. Súvisí s <a href="calculator_na.php">poruchami sodíka</a> a <a href="nastroj_hyponatremia.php">algoritmom hyponatrémie</a>.</p>

<h2>Zloženie bežných roztokov (na 1 liter)</h2>
<table>
  <thead>
    <tr>
      <th scope="col">Roztok</th>
      <th scope="col">Na<sup>+</sup></th>
      <th scope="col">Cl<sup>−</sup></th>
      <th scope="col">K<sup>+</sup></th>
      <th scope="col">Iné</th>
      <th scope="col">Osmolarita (mosm/l)</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Plazma (referencia)</td><td>140</td><td>100</td><td>4</td><td>HCO<sub>3</sub><sup>−</sup> 24</td><td>~290</td></tr>
    <tr><td>0,9 % NaCl (fyziologický)</td><td>154</td><td>154</td><td>0</td><td>—</td><td>~308</td></tr>
    <tr><td>Ringer-laktát (Hartmann)</td><td>130</td><td>109</td><td>4</td><td>Ca 1,5; laktát 28</td><td>~273</td></tr>
    <tr><td>Plasma-Lyte 148</td><td>140</td><td>98</td><td>5</td><td>Mg 1,5; acetát 27; glukonát 23</td><td>~295</td></tr>
    <tr><td>0,45 % NaCl (½ fyziologický)</td><td>77</td><td>77</td><td>0</td><td>—</td><td>~154</td></tr>
    <tr><td>5 % glukóza (G5)</td><td>0</td><td>0</td><td>0</td><td>glukóza 50 g</td><td>~278*</td></tr>
    <tr><td>3 % NaCl (hypertonický)</td><td>513</td><td>513</td><td>0</td><td>—</td><td>~1027</td></tr>
    <tr><td>8,4 % NaHCO<sub>3</sub></td><td>1000</td><td>0</td><td>0</td><td>HCO<sub>3</sub><sup>−</sup> 1000 (1 mmol/ml)</td><td>~2000</td></tr>
  </tbody>
</table>
<p><em>* G5 je in vitro takmer izotonická, no po metabolizme glukózy poskytuje <strong>voľnú vodu</strong> — pôsobí hypotonicky.</em></p>

<h2>Tonicita — praktické dôsledky</h2>
<table>
  <thead>
    <tr><th scope="col">Tonicita</th><th scope="col">Príklady</th><th scope="col">Použitie</th></tr>
  </thead>
  <tbody>
    <tr><td>Izotonické</td><td>0,9 % NaCl, Ringer-laktát, Plasma-Lyte</td><td>Náhrada objemu, resuscitácia, udržiavacia terapia</td></tr>
    <tr><td>Hypotonické</td><td>0,45 % NaCl, G5</td><td>Náhrada voľnej vody (hypernatrémia); v udržiavacej terapii u dospelých opatrne (riziko hyponatrémie)</td></tr>
    <tr><td>Hypertonické</td><td>3 % NaCl</td><td>Symptomatická ťažká hyponatrémia (bolusy 100–150 ml), edém mozgu</td></tr>
  </tbody>
</table>

<h2>Balansované roztoky vs. 0,9 % NaCl</h2>
<ul>
  <li><strong>0,9 % NaCl</strong> má vysoký chlorid (154) — pri veľkých objemoch spôsobuje <strong>hyperchloremickú metabolickú acidózu</strong> a môže zhoršiť renálnu perfúziu.</li>
  <li><strong>Balansované kryštaloidy</strong> (Ringer-laktát, Plasma-Lyte) majú zloženie bližšie plazme; pri resuscitácii sú vo väčšine situácií <strong>uprednostňované</strong> (štúdie SMART, BaSICS, PLUS — celkovo v prospech balansovaných pri riziku poškodenia obličiek).</li>
  <li><strong>Ringer-laktát obsahuje vápnik</strong> — nepodávaj v jednej linke s <em>citrátovými</em> krvnými prípravkami (riziko zrazenia) ani s ceftriaxónom u novorodencov.</li>
  <li>Pri ťažkej hyperkaliémii sa balansované roztoky (K 4–5) v praxi tolerujú; paradoxne 0,9 % NaCl môže acidózou kaliémiu zhoršiť.</li>
</ul>

<h2>Výber podľa situácie</h2>
<table>
  <thead>
    <tr><th scope="col">Situácia</th><th scope="col">Voľba</th></tr>
  </thead>
  <tbody>
    <tr><td>Resuscitácia / hypovolémia</td><td>Balansovaný kryštaloid (Ringer-laktát, Plasma-Lyte)</td></tr>
    <tr><td>Hypernatrémia (náhrada voľnej vody)</td><td>G5 alebo 0,45 % NaCl, pomalá korekcia (≤ 10–12 mmol/l/24 h)</td></tr>
    <tr><td>Symptomatická ťažká hyponatrémia</td><td>3 % NaCl 100–150 ml bolus, kontrola Na<sup>+</sup>, limit ≤ 8 mmol/l/24 h</td></tr>
    <tr><td>Diabetická ketoacidóza</td><td>Najprv 0,9 % NaCl, potom balansovaný; pridať glukózu pri glykémii &lt; 14 mmol/l</td></tr>
    <tr><td>Hyperkalciémia</td><td>Izotonický roztok (0,9 % NaCl) na obnovu volémie a kalciurézu</td></tr>
    <tr><td>Udržiavacia terapia (dospelí)</td><td>Izotonický roztok (vyhni sa hypotonickým — riziko nozokomiálnej hyponatrémie)</td></tr>
  </tbody>
</table>

<h2>Úskalia</h2>
<ul>
  <li><strong>Koloidy</strong> (hydroxyetylškrob) sa pri kritickej chorobe a sepse <strong>neodporúčajú</strong> (riziko AKI a mortality); albumín má vybrané indikácie.</li>
  <li>Hypotonické roztoky u dospelých sú častou príčinou <strong>nemocničnej hyponatrémie</strong> — preferuj izotonické udržiavacie roztoky.</li>
  <li>Hypertonický roztok pri kontinuálnom podávaní cez <strong>centrálny katéter</strong>; vždy monitoruj rýchlosť korekcie Na<sup>+</sup>.</li>
  <li>Objem a typ vždy prispôsob klinickému stavu (srdcové/renálne zlyhanie — riziko preťaženia).</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Semler MW et al. <em>Balanced Crystalloids versus Saline (SMART)</em>, N Engl J Med 2018; Finfer S et al. <em>Balanced Multielectrolyte Solution (PLUS)</em>, N Engl J Med 2022; štandardné odporúčania intenzívnej a internej medicíny. Orientačná pomôcka — nenahrádza klinický úsudok.</em></p>
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
