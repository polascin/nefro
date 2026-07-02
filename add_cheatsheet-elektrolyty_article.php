<?php
/**
 * add_cheatsheet-elektrolyty_article.php
 * Ťahák (cheat sheet): Elektrolyty. category = 'cheatsheet'.
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
    'title'        => 'Elektrolyty — ťahák',
    'slug'         => 'cheatsheet-elektrolyty',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 1,
    'excerpt'      => 'Prehľad porúch elektrolytov (Na, K, Ca, Mg, P): normálne hodnoty, najčastejšie príčiny, EKG nálezy a kľúčové limity rýchlosti korekcie na jednej strane.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/cheatsheet-elektrolyty.svg" alt="Dlaždice elektrolytov so sérovými referenčnými rozsahmi: sodík 135 – 145, draslík 3,5 – 5,0, vápnik 2,15 – 2,55, magnézium 0,70 – 1,00 a fosfát 0,80 – 1,45 mmol/l." loading="lazy" decoding="async">
  <figcaption>Sérové referenčné rozsahy hlavných elektrolytov (mmol/l).</figcaption>
</figure>

<p>Ťahák k poruchám <strong>sodíka, draslíka, vápnika, magnézia a fosfátov</strong> — normálne hodnoty, hlavné príčiny, EKG nálezy a bezpečné limity korekcie. Interaktívne postupy: <a href="nastroj_hyponatremia.php">algoritmus hyponatrémie</a>, <a href="nastroj_hypokalemia.php">sprievodca hypokaliémiou</a>. Kalkulačky: <a href="calculator_na.php">sodík/korekcia</a>, <a href="calculator_ca.php">korigovaný vápnik</a>.</p>

<h2>Normálne hodnoty (sérum)</h2>
<table>
  <thead>
    <tr><th scope="col">Elektrolyt</th><th scope="col">Rozsah</th></tr>
  </thead>
  <tbody>
    <tr><td>Sodík (Na<sup>+</sup>)</td><td>135 – 145 mmol/l</td></tr>
    <tr><td>Draslík (K<sup>+</sup>)</td><td>3,5 – 5,0 mmol/l</td></tr>
    <tr><td>Vápnik celkový</td><td>2,15 – 2,55 mmol/l</td></tr>
    <tr><td>Vápnik ionizovaný</td><td>1,15 – 1,30 mmol/l</td></tr>
    <tr><td>Magnézium (Mg<sup>2+</sup>)</td><td>0,70 – 1,00 mmol/l</td></tr>
    <tr><td>Fosfát (PO<sub>4</sub>)</td><td>0,80 – 1,45 mmol/l</td></tr>
  </tbody>
</table>

<h2>Sodík</h2>
<table>
  <thead>
    <tr><th scope="col">Porucha</th><th scope="col">Hlavné príčiny</th><th scope="col">Kľúč k manažmentu</th></tr>
  </thead>
  <tbody>
    <tr><td>Hyponatrémia</td><td>SIADH, hypovolémia, srdcové/hepatálne/renálne zlyhanie, polydipsia, hypotyreóza/Addison</td><td>Najprv tonicita + objem; rýchlosť korekcie <strong>≤ 8–10 mmol/l/24 h</strong> (≤ 6 pri vysokom riziku) — prevencia osmotického demyelinizačného syndrómu (ODS)</td></tr>
    <tr><td>Hypernatrémia</td><td>Strata vody (hnačka, horúčka, diabetes insipidus), nedostatočný príjem, hypertonické roztoky</td><td>Vypočítaj deficit vody; pokles Na<sup>+</sup> <strong>≤ 10–12 mmol/l/24 h</strong> — prevencia edému mozgu</td></tr>
  </tbody>
</table>

<h2>Draslík</h2>
<table>
  <thead>
    <tr><th scope="col">Porucha</th><th scope="col">Hlavné príčiny</th><th scope="col">EKG / manažment</th></tr>
  </thead>
  <tbody>
    <tr><td>Hypokaliémia</td><td>Diuretiká, GIT straty (vracanie/hnačka), presun do bunky, hyperaldosteronizmus, hypomagneziémia</td><td>EKG: oploštené T, U vlny, ST depresia, predĺžené QT. <strong>Vždy doplň magnézium.</strong> i.v. K<sup>+</sup> ≤ 10 mmol/h periférne, monitoruj</td></tr>
    <tr><td>Hyperkaliémia</td><td>CKD/AKI, RAAS-blokátory + nsMRA, deštrukcia buniek, acidóza, pseudohyperkaliémia</td><td>EKG: vysoké hrotnaté T, široký QRS, strata P, sínusoida. Pri zmenách: <strong>kalcium i.v.</strong> (membrána) + inzulín/glukóza + β<sub>2</sub>-agonista; odstránenie (diuretiká, viazače, dialýza)</td></tr>
  </tbody>
</table>

<h2>Vápnik</h2>
<p><strong>Korekcia na albumín:</strong> Ca<sub>korig</sub> = Ca<sub>celk</sub> + 0,02 × (40 − albumín g/l). Pri poruche acidobázy alebo u kriticky chorých pacientov uprednostni <strong>ionizovaný vápnik</strong>.</p>
<table>
  <thead>
    <tr><th scope="col">Porucha</th><th scope="col">Hlavné príčiny</th><th scope="col">EKG / poznámka</th></tr>
  </thead>
  <tbody>
    <tr><td>Hypokalciémia</td><td>Hypoparatyreóza, deficit/rezistencia vit. D, CKD-MBD, hypomagneziémia, akútna pankreatitída</td><td>Predĺžené QT, tetania, Chvostek/Trousseau. Pri Mg deficite najprv koriguj Mg</td></tr>
    <tr><td>Hyperkalciémia</td><td>Primárna hyperparatyreóza, malignita (PTHrP, osteolýza), granulomatózy, lieky (tiazidy, lítium)</td><td>Skrátené QT. Liečba: <strong>i.v. izotonický roztok</strong> ± bisfosfonát/denosumab, kalcitonín; rieš príčinu</td></tr>
  </tbody>
</table>

<h2>Magnézium a fosfát</h2>
<table>
  <thead>
    <tr><th scope="col">Porucha</th><th scope="col">Hlavné príčiny</th><th scope="col">Poznámka</th></tr>
  </thead>
  <tbody>
    <tr><td>Hypomagneziémia</td><td>Diuretiká, PPI, alkohol, GIT straty, inhibítory EGFR</td><td>Spôsobuje refraktérnu hypokaliémiu a hypokalciémiu — koriguj ho ako prvé</td></tr>
    <tr><td>Hypermagneziémia</td><td>CKD + suplementácia/antacidá, eklampsia (liečba MgSO<sub>4</sub>)</td><td>Hyporeflexia, hypotenzia, zástava dychu; antidotum kalcium i.v.</td></tr>
    <tr><td>Hypofosfatémia</td><td>Refeeding syndróm, alkohol, DKA pri liečbe, renálne straty (Fanconi)</td><td>Ťažká (&lt; 0,3 mmol/l): svalová slabosť, rabdomyolýza, respiračné zlyhanie</td></tr>
    <tr><td>Hyperfosfatémia</td><td>CKD (najčastejšie), syndróm rozpadu nádoru, rabdomyolýza</td><td>CKD-MBD: diétne obmedzenie + viazače fosfátov; rieš príčinu</td></tr>
  </tbody>
</table>

<h2>Zlaté pravidlá</h2>
<ul>
  <li><strong>Magnézium ako prvé:</strong> refraktérna hypokaliémia aj hypokalciémia sa často neupravia bez korekcie Mg.</li>
  <li><strong>Rýchlosť, nie cieľ:</strong> pri Na<sup>+</sup> rozhoduje rýchlosť korekcie (ODS vs. edém mozgu), nie cieľová hodnota.</li>
  <li>Pri hyperkaliémii s EKG zmenami je <strong>kalcium</strong> prvý krok (stabilizácia membrány), nezníži však kaliémiu.</li>
  <li>Vápnik vždy hodnoť <strong>korigovaný na albumín</strong> alebo ako ionizovaný.</li>
</ul>

<hr>

<p><strong>Zdroje a odkazy:</strong></p>
<ul>
  <li><a href="https://pubmed.ncbi.nlm.nih.gov/25551526/" target="_blank" rel="noopener noreferrer">Sterns RH. Disorders of Plasma Sodium — Causes, Consequences, and Correction. N Engl J Med 2015;372:55–65</a></li>
  <li><a href="https://kdigo.org/guidelines/" target="_blank" rel="noopener noreferrer">KDIGO — klinické odporúčania (poruchy elektrolytov a CKD)</a></li>
</ul>
<p><em>Orientačná pomôcka — nenahrádza klinický úsudok.</em></p>
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
