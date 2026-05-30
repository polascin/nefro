<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
ini_set('display_errors', 0);
header('Content-Type: text/plain; charset=UTF-8');
require_once __DIR__ . '/db_config.php';
if (!isset($pdo)) { die("Pripojenie PDO zlyhalo.\n"); }
try {
    $countQuery = $pdo->query("SELECT COUNT(*) FROM articles WHERE is_top=1 AND is_published=1");
    $totalTop = $countQuery->fetchColumn();
    $stmt = $pdo->prepare("SELECT id,title,slug,author,excerpt,content,published_at,sort_order FROM articles WHERE is_top=1 AND is_published=1 ORDER BY sort_order ASC,published_at DESC LIMIT 1");
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Celkový počet TOP článkov: " . $totalTop . "\n\n";
    if ($article) {
        echo "Názov: " . $article["title"] . "\n";
        echo "Slug: " . $article["slug"] . "\n";
        echo "Úvod (excerpt): " . $article["excerpt"] . "\n";
        echo "Obsah (prvých 2000 znakov):\n";
        echo substr($article["content"] ?? "", 0, 2000) . "\n";
    } else {
        echo "Nebol nájdený žiadny TOP publikovaný článok.\n";
    }
} catch (PDOException $e) {
    echo "Dotaz zlyhal: " . $e->getMessage() . "\n";
}
