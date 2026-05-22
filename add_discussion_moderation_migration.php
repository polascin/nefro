<?php
/**
 * add_discussion_moderation_migration.php
 * Pridá moderovanie do tabuľky discussion_posts:
 *   is_hidden        TINYINT(1) — skrytie pred verejnosťou bez fyzického mazania
 *   is_pinned        TINYINT(1) — pripnutie príspevku na vrch diskusie
 *   moderation_note  VARCHAR(500) — interná poznámka admina (dôvod skrytia atď.)
 * Idempotentný — bezpečné opakované spustenie.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$results = [];
$errors  = [];

$columns = [
    'is_hidden'       => "ALTER TABLE discussion_posts ADD COLUMN is_hidden TINYINT(1) NOT NULL DEFAULT 0 AFTER is_deleted",
    'is_pinned'       => "ALTER TABLE discussion_posts ADD COLUMN is_pinned TINYINT(1) NOT NULL DEFAULT 0 AFTER is_hidden",
    'moderation_note' => "ALTER TABLE discussion_posts ADD COLUMN moderation_note VARCHAR(500) NULL DEFAULT NULL AFTER is_pinned",
];

$indexes = [
    'idx_disc_hidden' => "ALTER TABLE discussion_posts ADD INDEX idx_disc_hidden (is_hidden)",
    'idx_disc_pinned' => "ALTER TABLE discussion_posts ADD INDEX idx_disc_pinned (is_pinned)",
];

// Zistíme existujúce stĺpce
$existingCols = [];
try {
    $s = $pdo->query("SHOW COLUMNS FROM discussion_posts");
    foreach ($s->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $existingCols[] = strtolower((string) ($row['Field'] ?? ''));
    }
} catch (\PDOException $e) {
    $errors[] = 'Chyba pri čítaní stĺpcov: ' . $e->getMessage();
}

// Zistíme existujúce indexy
$existingIndexes = [];
try {
    $s = $pdo->query("SHOW INDEX FROM discussion_posts");
    foreach ($s->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $existingIndexes[] = strtolower((string) ($row['Key_name'] ?? ''));
    }
} catch (\PDOException $e) {
    $errors[] = 'Chyba pri čítaní indexov: ' . $e->getMessage();
}

// Pridáme chýbajúce stĺpce
if (empty($errors)) {
    foreach ($columns as $col => $sql) {
        if (in_array($col, $existingCols, true)) {
            $results[] = "Stĺpec $col: preskočený (existuje)";
            continue;
        }
        try {
            $pdo->exec($sql);
            $results[] = "Stĺpec $col: pridaný";
        } catch (\PDOException $e) {
            $errors[] = "Stĺpec $col: chyba — " . $e->getMessage();
        }
    }

    foreach ($indexes as $idx => $sql) {
        if (in_array($idx, $existingIndexes, true)) {
            $results[] = "Index $idx: preskočený (existuje)";
            continue;
        }
        try {
            $pdo->exec($sql);
            $results[] = "Index $idx: pridaný";
        } catch (\PDOException $e) {
            $errors[] = "Index $idx: chyba — " . $e->getMessage();
        }
    }
}

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo "Migrácia: discussion_posts moderovanie\n";
    echo "──────────────────────────────────────────────────────\n";
    foreach ($results as $r) { echo "  ✓ $r\n"; }
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $e) { echo "  ✗ $e\n"; }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <title>Migrácia – moderovanie diskusie</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – moderovanie diskusie</h2>
          <?php if (!empty($errors)): ?>
            <div class="alert alert-error"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= empty($errors) ? 'alert-success' : 'alert-info' ?>">
            <ul><?php foreach ($results as $r): ?><li><?= htmlspecialchars($r) ?></li><?php endforeach; ?></ul>
          </div>
          <p><a href="admin.php" class="btn-primary">← Administrácia</a></p>
        </div>
      </main>
    </body>
    </html>
    <?php
}
?>
