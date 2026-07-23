<?php
/**
 * add_bbc-unosy-migrantov-libya-hrozba-odberu-obliciek_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_bbc-unosy-migrantov-libya-hrozba-odberu-obliciek_article.php"
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
    'title'        => 'BBC: únosy migrantov v Líbyi a vyhrážky odobratím obličiek',
    'slug'         => 'bbc-unosy-migrantov-libya-hrozba-odberu-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'BBC informuje, že vyše 300 migrantov bolo v Líbyi unesených, mučených a zastrašovaných vyhrážkami odobratia obličiek pri nezaplatení výkupného. Samotnú BBC sa odber orgánov nepodarilo úplne overiť. Z pohľadu nefrológie pripomíname, čo zachytiť u obetí násilia s možným poškodením obličiek.',
    'content'      => <<<'HTML'
<p>Britská BBC priniesla zistenia, podľa ktorých bolo <strong>vyše 300 migrantov</strong> smerujúcich do Spojeného kráľovstva <strong>unesených v Líbyi</strong>, mučených a zastrašovaných vyhrážkami, že im budú <strong>odobraté obličky</strong>, ak ich rodiny nezaplatia výkupné.</p>

<h2>Čo BBC uvádza</h2>

<ul>
  <li>unesení boli <strong>mladí muži z irackého Kurdistanu</strong>,</li>
  <li>boli zadržiavaní v <strong>preplnených a krutých podmienkach</strong> (silne preplnená cela, mučenie),</li>
  <li>milícia údajne žiadala <strong>5 000 USD (približne 3 700 GBP) od každej rodiny</strong>,</li>
  <li>ak by peniaze neboli zaplatené včas, rodiny dostali varovanie, že „to bude na úkor obličky“,</li>
  <li>BBC uvádza aj <strong>fotografické dôkazy a svedectvá</strong> naznačujúce, že k násilným zákrokom mohlo dôjsť, no <strong>úplne overiť odobratie orgánov</strong> sa jej nepodarilo,</li>
  <li>podľa BBC je <strong>známe najmenej jedno úmrtie</strong> a nie je jasné, koľko ľudí stále zostáva v zajatí.</li>
</ul>

<h2>Kontext a mechanika prípadu</h2>

<p>BBC dáva vznik situácie do súvislosti s fungovaním pašeráckych sietí v Líbyi, kde podľa expertov a opisov chýba účinná štátna kontrola. Riešia sa aj spory medzi pašerákmi o to, kto má finančne zabezpečiť transport, čo následne eskaluje do vymáhania výkupného milíciou.</p>

<h2>Nefrologický a medicínsky presah (prakticky)</h2>

<p>Z pohľadu nefrologickej praxe z prípadu vyplýva najmä toto:</p>

<ul>
  <li>hrozia <strong>závažné dlhodobé zdravotné následky</strong> (trauma, infekcie, možný odber orgánu, komplikácie po zákrokoch, dehydratácia, sekundárne poškodenie obličiek),</li>
  <li>u utečencov a obetí násilia treba pri príznakoch poškodenia obličiek myslieť na <strong>urgentné nefrologické vyšetrenie</strong> (oligúria, zmeny kreatinínu, hematúria, hypertenzia, príznaky infekcie),</li>
  <li>v praxi by to malo ísť ruka v ruke s <strong>medicínsko-forenzným prístupom</strong> a dokumentáciou nálezov, doplneným o psychologickú a sociálnu podporu.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> BBC News: „300 migrants… kidnapped and threatened with kidney removal“. <a href="https://www.bbc.com/news/articles/c8xwxdgvx8lo" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
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
