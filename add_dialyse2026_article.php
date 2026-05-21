<?php
/**
 * add_dialyse2026_article.php
 * Pridanie článku o Dialyse 2026 – NephroLive livestream
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Dáta článkov ──────────────────────────────────────────────────────────────

$articles = [];

// ── Článok: Dialyse 2026 – odborný livestream pre nefrologickú prax ───────────
$articles[] = [
    'title'        => 'Dialyse 2026: odborný livestream pre nefrologickú prax',
    'slug'         => 'dialyse-2026-odborny-livestream-nefrologicka-prax',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-21',
    'is_top'       => 0,
    'excerpt'      => 'STREAMED UP zaradil do série NephroLive ďalšie odborné vysielanie s názvom Dialyse 2026. Obsah je zameraný na tri oblasti, ktoré zostávajú v nefrológii mimoriadne dôležité: aferézu, aktuálny vývoj v hemodialýze a pokroky v peritoneálnej dialýze.',
    'content'      => <<<'HTML'
<p>STREAMED UP zaradil do série NephroLive ďalšie odborné vysielanie s názvom <strong>Dialyse 2026</strong>. Obsah je zameraný na tri oblasti, ktoré zostávajú v nefrológii mimoriadne dôležité: <strong>aferézu</strong>, <strong>aktuálny vývoj v hemodialýze</strong> a <strong>pokroky v peritoneálnej dialýze</strong>.</p>

<p>Dialýza patrí medzi základné piliere liečby pacientov s pokročilým chronickým ochorením obličiek a pri akútnych stavoch, kde je potrebná náhrada funkcie obličiek. Každá odborná platforma, ktorá prehľadne sprístupňuje nové poznatky z tejto oblasti, má preto praktický význam pre lekárov aj pre zdravotníckych pracovníkov v dialyzačných prevádzkach.</p>

<p>V prípade programu Dialyse 2026 ide najmä o príležitosť získať stručný prehľad aktuálnych trendov, porovnať prístupy k jednotlivým modalitám dialyzačnej liečby a sledovať smerovanie ďalšieho vývoja. Z pohľadu klinickej praxe je to užitočné najmä preto, že dialyzačná liečba sa neustále mení technicky aj organizačne.</p>

<p>Pre nefrologickú komunitu je dôležité nielen sledovať nové technológie, ale aj kriticky vyhodnocovať ich reálny prínos pre pacienta. Pri témach ako hemodialýza, peritoneálna dialýza či aferéza rozhoduje najmä bezpečnosť, dostupnosť, individuálna indikácia a kvalita dlhodobej starostlivosti.</p>

<p>Ak vás zaujímajú aktuálne odborné informácie z oblasti dialýzy, toto vysielanie môže byť vhodným zdrojom na rýchlu orientáciu v témach, ktoré sa priamo dotýkajú každodennej nefrologickej praxe.</p>

<hr>

<p><em><strong>Zdroj:</strong> STREAMED UP, Online-Fortbildung: Dialyse 2026. <a href="https://streamed-up.com/live/dialyse-2026" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted = 0;
$skipped  = 0;
$errors   = [];

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_dialyse2026_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku Dialyse 2026\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    // ── HTML výstup pre webový prístup ──────────────────────────────────
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia – Dialyse 2026</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Dialyse 2026</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
          </div>

          <p>Vstavané články o Dialyse 2026:</p>
          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
