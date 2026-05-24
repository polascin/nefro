<?php
/**
 * fix_language_corrections.php
 * Jazyková korektúra obsahu článkov v databáze:
 *  1. špecifickosťou → špecificitou (terminológia: špecificita, nie špecifickosť)
 *  2. Zároveň ale platí → Zároveň však platí (gramatika: redundantná kombinácia)
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$fixes = [
    [
        'slug'    => 'molekularne-zobrazovanie-z-mocu-novy-biomarker-test-fibroza-obliciek',
        'search'  => 'špecifickosťou',
        'replace' => 'špecificitou',
        'note'    => 'Medicínsky termín: špecificita (nie špecifickosť)',
    ],
    [
        'slug'    => 'zelenina-pre-lepsie-zdravie-obliciek-ckd-5-druhov-dietologovia',
        'search'  => 'Zároveň ale platí',
        'replace' => 'Zároveň však platí',
        'note'    => 'Gramatika: redundantná kombinácia ale+zároveň',
    ],
];

$stmt = $pdo->prepare(
    "UPDATE articles
     SET content = REPLACE(content, :search, :replace)
     WHERE slug = :slug AND content LIKE :like"
);

$results = [];
foreach ($fixes as $fix) {
    $stmt->execute([
        'slug'    => $fix['slug'],
        'search'  => $fix['search'],
        'replace' => $fix['replace'],
        'like'    => '%' . $fix['search'] . '%',
    ]);
    $results[] = ['rows' => $stmt->rowCount(), 'note' => $fix['note'], 'slug' => $fix['slug']];
}

if (php_sapi_name() === 'cli') {
    foreach ($results as $r) {
        echo ($r['rows'] > 0 ? '✓' : '–') . " [{$r['slug']}] {$r['note']}\n";
    }
} else {
    ?>
    <!DOCTYPE html><html lang="sk"><head><meta charset="UTF-8"><title>Jazyková korektúra DB</title></head>
    <body style="font-family:sans-serif;padding:40px;">
    <h2>Jazyková korektúra databázy</h2>
    <ul>
    <?php foreach ($results as $r): ?>
      <li><?= $r['rows'] > 0 ? '✓' : '–' ?> <code><?= htmlspecialchars($r['slug']) ?></code> — <?= htmlspecialchars($r['note']) ?></li>
    <?php endforeach; ?>
    </ul>
    <p><a href="admin_articles.php">Správa článkov</a></p>
    </body></html>
    <?php
}
