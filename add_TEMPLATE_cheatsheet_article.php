<?php
/**
 * add_TEMPLATE_cheatsheet_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre ŤAHÁK / CHEAT SHEET (sekcia „Ťaháky"
 * → cheatsheets.php, category = 'cheatsheet'). Tlačiteľný kompaktný
 * prehľad pre klinickú prax (acidobáza, elektrolyty, diuretiká, infúzne
 * roztoky …). Renderuje sa cez article.php (spoločná infraštruktúra + PDF).
 *
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   4. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE OBSAH ŤAHÁKA (CHEAT SHEET):
 *   • Účel    – ťahák (rýchla referencia), nie naratívny článok. Kľúčové čísla,
 *               klasifikácie a postupy v kompaktnej, tlačiteľnej forme.
 *   • title    – čistý text, bez HTML; napr. „Acidobáza — ťahák (cheat sheet)"
 *   • slug     – len [a-z0-9-], max 80 znakov, unikátny. Diakritika → ASCII.
 *   • excerpt  – 1–2 vety, čo ťahák obsahuje; zobrazí sa na karte v sekcii
 *   • content  – HTML; NEZAČÍNAJ <h2> zhodným s titulom (duplikát)
 *                Preferuj <table> (s <thead>/<th scope="col">), <ul>/<ol>,
 *                <strong> pre kľúčové hodnoty. Žiadne inline style="" (CSP).
 *                Nadpisy sekcií → <h2>; pododdiely → <h3>.
 *                Vždy uveď zdroj/odporúčanie na konci (<hr> + „Zdroj:").
 *   • category – 'cheatsheet' (nastavené automaticky nižšie — needituj)
 *   • is_top   – 0 = bežný, 1 = odporúčaný (zobrazí sa s odznakom navrchu sekcie)
 *   • author   – autor projektu (predvolene 'MUDr. Ľubomír Polaščín').
 *
 *   ⓘ NEWSLETTER: ťaháky sa pridávajú v dávkach a sú referenčným, nie
 *     spravodajským obsahom — preto sa pri ich vložení NEodosiela newsletter
 *     avízo (na rozdiel od odborných a popularizačných článkov). PDF verzia sa
 *     generuje normálne (bonus na stiahnutie a tlač).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať ťahák');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta ťaháka ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => '',                    // ← VYPLNIŤ: napr. 'Acidobáza — ťahák'
    'slug'         => '',                    // ← VYPLNIŤ: napr. 'cheatsheet-acidobaza'
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť odporúčaný navrchu sekcie
    'excerpt'      => '',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<!-- ← VYPLNIŤ: nahraď tento komentár skutočným HTML obsahom ťaháka -->
<!-- POZOR: nezačínaj <h2> zhodným s titulom — ten sa generuje automaticky -->

<p>Krátky úvodný odsek — na čo ťahák slúži a pre koho.</p>

<h2>Prvá sekcia</h2>

<table>
  <thead>
    <tr><th scope="col">Parameter</th><th scope="col">Hodnota</th></tr>
  </thead>
  <tbody>
    <tr><td>…</td><td>…</td></tr>
  </tbody>
</table>

<hr>

<p><em><strong>Zdroj:</strong> Odporúčanie / guideline, rok. <a href="" target="_blank" rel="noopener noreferrer">Odkaz</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted = 0;
$updated  = 0;
$skipped  = 0;
$errors   = [];

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci ťahák
// (regenerácia). `category` ostáva 'cheatsheet' aj pri update (needituj).
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho ťaháka, 0 = bez zmeny.
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
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu (bonus na stiahnutie a tlač).
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
