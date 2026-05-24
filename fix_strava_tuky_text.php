<?php
/**
 * fix_strava_tuky_text.php
 * Oprava textu v článku strava-tuky-kardiovaskularne-riziko-ckd:
 * "nekajúcnosti" → "zdržanlivosti"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$slug = 'strava-tuky-kardiovaskularne-riziko-ckd-co-dava-zmysel-praxi';

$stmt = $pdo->prepare(
    "UPDATE articles
     SET content = REPLACE(content, 'nekajúcnosti', 'zdržanlivosti')
     WHERE slug = :slug AND content LIKE '%nekajúcnosti%'"
);
$stmt->execute(['slug' => $slug]);
$affected = $stmt->rowCount();

if (php_sapi_name() === 'cli') {
    echo "Aktualizovaných riadkov: $affected\n";
} else {
    ?>
    <!DOCTYPE html><html lang="sk"><head><meta charset="UTF-8"><title>Oprava textu</title></head>
    <body style="font-family:sans-serif;padding:40px;">
    <p>Aktualizovaných riadkov: <strong><?= $affected ?></strong></p>
    <p><a href="admin_articles.php">Správa článkov</a></p>
    </body></html>
    <?php
}
