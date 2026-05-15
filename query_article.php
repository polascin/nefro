<?php
require_once __DIR__ . '/auth.php';
requireAdmin();
ini_set('display_errors', 0);
require_once "db_config.php";
if (!isset($pdo)) { die("PDO connection failed.\n"); }
try {
    $countQuery = $pdo->query("SELECT COUNT(*) FROM articles WHERE is_top=1 AND is_published=1");
    $totalTop = $countQuery->fetchColumn();
    $stmt = $pdo->prepare("SELECT id,title,slug,author,excerpt,content,published_at,sort_order FROM articles WHERE is_top=1 AND is_published=1 ORDER BY sort_order ASC,published_at DESC LIMIT 1");
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total Top Articles: " . $totalTop . "\n\n";
    if ($article) {
        echo "Title: " . $article["title"] . "\n";
        echo "Slug: " . $article["slug"] . "\n";
        echo "Excerpt: " . $article["excerpt"] . "\n";
        echo "Content (first 2000 chars):\n";
        echo substr($article["content"] ?? "", 0, 2000) . "\n";
    } else {
        echo "No top published article found.\n";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage() . "\n";
}
