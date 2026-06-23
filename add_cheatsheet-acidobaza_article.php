<?php
/**
 * add_cheatsheet-acidobaza_article.php
 * Ťahák (cheat sheet): Acidobáza. category = 'cheatsheet'.
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
    'title'        => 'Acidobáza — ťahák',
    'slug'         => 'cheatsheet-acidobaza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'excerpt'      => 'Rýchla referencia na interpretáciu acidobázy: normálne hodnoty, primárne poruchy a očakávaná kompenzácia, aniónové okno, delta ratio a diferenciálna diagnostika.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/cheatsheet-acidobaza.svg" alt="Schéma acidobázy: pH škála od acidémie po alkalémiu s normou 7,35 – 7,45 a príspevkom respiračnej (pCO₂) a metabolickej (HCO₃⁻) zložky." loading="lazy" decoding="async">
  <figcaption>pH škála: respiračná zložka (pCO₂, pľúca) a metabolická zložka (HCO₃⁻, obličky).</figcaption>
</figure>

<p>Kompaktná pomôcka na <strong>systematickú interpretáciu artériovej acidobázy</strong>. Postupuj v krokoch: pH → primárna porucha → kompenzácia → aniónové okno (AG) → delta ratio → klinický kontext. Výpočty si overíš v <a href="calculator_acidbase.php">kalkulačke acidobázy</a>.</p>

<h2>Normálne hodnoty (artériová krv)</h2>
<table>
  <thead>
    <tr><th scope="col">Parameter</th><th scope="col">Rozsah</th></tr>
  </thead>
  <tbody>
    <tr><td>pH</td><td>7,35 – 7,45</td></tr>
    <tr><td>pCO<sub>2</sub></td><td>35 – 45 mmHg (4,7 – 6,0 kPa)</td></tr>
    <tr><td>HCO<sub>3</sub><sup>−</sup> (aktuálny)</td><td>22 – 26 mmol/l</td></tr>
    <tr><td>Base excess (BE)</td><td>−2 až +2 mmol/l</td></tr>
    <tr><td>Aniónové okno (AG)</td><td>8 – 12 mmol/l (bez K<sup>+</sup>)</td></tr>
  </tbody>
</table>

<h2>Krok 1 — Primárna porucha</h2>
<table>
  <thead>
    <tr><th scope="col">pH</th><th scope="col">Primárna zmena</th><th scope="col">Porucha</th></tr>
  </thead>
  <tbody>
    <tr><td>&lt; 7,35 (acidémia)</td><td>↓ HCO<sub>3</sub><sup>−</sup></td><td>Metabolická acidóza</td></tr>
    <tr><td>&lt; 7,35 (acidémia)</td><td>↑ pCO<sub>2</sub></td><td>Respiračná acidóza</td></tr>
    <tr><td>&gt; 7,45 (alkalémia)</td><td>↑ HCO<sub>3</sub><sup>−</sup></td><td>Metabolická alkalóza</td></tr>
    <tr><td>&gt; 7,45 (alkalémia)</td><td>↓ pCO<sub>2</sub></td><td>Respiračná alkalóza</td></tr>
  </tbody>
</table>
<p><em>pH v norme + abnormálne pCO<sub>2</sub>/HCO<sub>3</sub><sup>−</sup> → zmiešaná porucha.</em></p>

<h2>Krok 2 — Očakávaná kompenzácia</h2>
<p>Kompenzácia <strong>nikdy nekoriguje pH úplne</strong> do normy. Odchýlka od očakávanej hodnoty = ďalšia (zmiešaná) porucha.</p>
<table>
  <thead>
    <tr><th scope="col">Primárna porucha</th><th scope="col">Očakávaná kompenzácia</th></tr>
  </thead>
  <tbody>
    <tr><td>Metabolická acidóza</td><td>pCO<sub>2</sub> = 1,5 × HCO<sub>3</sub><sup>−</sup> + 8 ± 2 (Winterov vzorec)</td></tr>
    <tr><td>Metabolická alkalóza</td><td>pCO<sub>2</sub> stúpa ~0,7 mmHg na každý 1 mmol/l ↑ HCO<sub>3</sub><sup>−</sup></td></tr>
    <tr><td>Respiračná acidóza — akútna</td><td>HCO<sub>3</sub><sup>−</sup> ↑ o 1 na každých 10 mmHg ↑ pCO<sub>2</sub></td></tr>
    <tr><td>Respiračná acidóza — chronická</td><td>HCO<sub>3</sub><sup>−</sup> ↑ o 3,5 – 4 na každých 10 mmHg ↑ pCO<sub>2</sub></td></tr>
    <tr><td>Respiračná alkalóza — akútna</td><td>HCO<sub>3</sub><sup>−</sup> ↓ o 2 na každých 10 mmHg ↓ pCO<sub>2</sub></td></tr>
    <tr><td>Respiračná alkalóza — chronická</td><td>HCO<sub>3</sub><sup>−</sup> ↓ o 4 – 5 na každých 10 mmHg ↓ pCO<sub>2</sub></td></tr>
  </tbody>
</table>

<h2>Krok 3 — Aniónové okno (AG)</h2>
<p><strong>AG = Na<sup>+</sup> − (Cl<sup>−</sup> + HCO<sub>3</sub><sup>−</sup>)</strong>, norma 8 – 12 mmol/l.</p>
<p><strong>Korekcia na albumín:</strong> AG stúpa o ~2,5 mmol/l na každých 10 g/l (1 g/dl), o ktoré je albumín pod 40 g/l (4 g/dl). Pri hypoalbuminémii môže zvýšené AG zostať zamaskované — vždy koriguj.</p>

<h3>Metabolická acidóza so zvýšeným AG (HAGMA) — mnemotechnika GOLD MARK</h3>
<ul>
  <li><strong>G</strong>lykoly (etylénglykol, propylénglykol)</li>
  <li><strong>O</strong>xoprolín (pyroglutamát — chronický paracetamol)</li>
  <li><strong>L</strong>-laktát (sepsa, hypoperfúzia, metformín)</li>
  <li><strong>D</strong>-laktát (syndróm krátkeho čreva)</li>
  <li><strong>M</strong>etanol</li>
  <li><strong>A</strong>spirín (salicyláty)</li>
  <li><strong>R</strong>enálne zlyhanie (urémia)</li>
  <li><strong>K</strong>etoacidóza (diabetická, alkoholová, z hladovania)</li>
</ul>

<h3>Metabolická acidóza s normálnym AG (NAGMA, hyperchloremická)</h3>
<p>Rozlíš podľa <strong>močového aniónového okna (UAG = U-Na + U-K − U-Cl)</strong>:</p>
<ul>
  <li><strong>UAG negatívne</strong> → adekvátna exkrécia NH<sub>4</sub><sup>+</sup> → <em>extrarenálna</em> strata HCO<sub>3</sub><sup>−</sup> (hnačka, drenáže GIT, ureterosigmoideostómia).</li>
  <li><strong>UAG pozitívne</strong> → porucha exkrécie NH<sub>4</sub><sup>+</sup> → <em>renálna</em> tubulárna acidóza (RTA), CKD.</li>
</ul>

<h2>Krok 4 — Delta ratio (ΔAG / ΔHCO<sub>3</sub><sup>−</sup>)</h2>
<p>Pri HAGMA odhalí <strong>skrytú zmiešanú poruchu</strong>: Δratio = (AG − 12) / (24 − HCO<sub>3</sub><sup>−</sup>).</p>
<table>
  <thead>
    <tr><th scope="col">Delta ratio</th><th scope="col">Interpretácia</th></tr>
  </thead>
  <tbody>
    <tr><td>&lt; 0,4</td><td>Súčasná NAGMA (hyperchloremická acidóza)</td></tr>
    <tr><td>0,4 – 1,0</td><td>Zmiešaná HAGMA + NAGMA</td></tr>
    <tr><td>1,0 – 2,0</td><td>Čistá HAGMA</td></tr>
    <tr><td>&gt; 2,0</td><td>Súčasná metabolická alkalóza alebo chronická respiračná acidóza</td></tr>
  </tbody>
</table>

<h2>Metabolická alkalóza — podľa močového chloridu</h2>
<table>
  <thead>
    <tr><th scope="col">U-Cl</th><th scope="col">Typ</th><th scope="col">Príčiny</th></tr>
  </thead>
  <tbody>
    <tr><td>&lt; 20 mmol/l</td><td>Citlivá na chlorid (volumová deplécia)</td><td>Vracanie, NG odsávanie, diuretiká (s odstupom), posthyperkapnia</td></tr>
    <tr><td>&gt; 20 mmol/l</td><td>Rezistentná na chlorid</td><td>Hyperaldosteronizmus, Cushing, ťažká hypokaliémia, Bartter/Gitelman, aktuálne diuretiká</td></tr>
  </tbody>
</table>

<h2>Pomôcky a úskalia</h2>
<ul>
  <li><strong>Osmolárne okno</strong> (vypočítaná vs. meraná osmolalita &gt; 10 mosm/kg) podporuje intoxikáciu toxickým alkoholom (metanol, etylénglykol).</li>
  <li>Vždy <strong>koriguj AG na albumín</strong> — inak ti unikne zvýšené AG u kriticky chorých.</li>
  <li>Pri zmiešaných poruchách porovnaj namerané hodnoty s <strong>očakávanou kompenzáciou</strong>, nie s normálnymi referenčnými hodnotami.</li>
  <li>Klinický kontext (anamnéza, lieky, glykémia, laktát, ketolátky) má prednosť pred samotnými číslami.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Berend K. et al. <em>Physiological Approach to Assessment of Acid–Base Disturbances</em>, N Engl J Med 2014; Kraut JA, Madias NE. <em>Serum Anion Gap</em>, Clin J Am Soc Nephrol 2007. Orientačná pomôcka — nenahrádza klinický úsudok.</em></p>
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
