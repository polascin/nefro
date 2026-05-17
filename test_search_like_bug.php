<?php
/**
 * test_search_like_bug.php — Test LIKE vyhľadávania ako v search.php
 * Reprodukuje presný SQL pattern použitý v searchViaLike()
 */
if (php_sapi_name() !== 'cli') { exit(403); }
require_once __DIR__ . '/db_config.php';

echo "── Test searchViaLike() pattern ────────────────────────────────\n\n";

// Simulácia: token "eGFR" (1 token, indx=0)
$pattern = '%eGFR%';

// Toto je presne to, čo robí search.php → searchViaLike()
$whereClause = "(title LIKE :pt0 OR excerpt LIKE :pe0 OR content LIKE :pc0)";
$scoreExpr   = "(CASE WHEN title LIKE :pt0 THEN 10 ELSE 0 END) + "
             . "(CASE WHEN excerpt LIKE :pe0 THEN 5 ELSE 0 END) + "
             . "(CASE WHEN content LIKE :pc0 THEN 1 ELSE 0 END)";

$params = ['pt0' => $pattern, 'pe0' => $pattern, 'pc0' => $pattern];

echo "1. COUNT query (každý param ojedinele):\n";
try {
    $cnt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE is_published=1 AND ({$whereClause})");
    $cnt->execute($params);
    echo "   ✓ COUNT = " . $cnt->fetchColumn() . "\n\n";
} catch (\PDOException $e) {
    echo "   ✗ CHYBA: " . $e->getMessage() . "\n\n";
}

echo "2. SELECT query (každý param 2× v SQL: WHERE + CASE):\n";
try {
    $sel = $pdo->prepare(
        "SELECT id, title, ({$scoreExpr}) AS score
         FROM articles
         WHERE is_published=1 AND ({$whereClause})
         ORDER BY score DESC LIMIT 5"
    );
    foreach ($params as $k => $v) {
        $sel->bindValue(':' . $k, $v, PDO::PARAM_STR);
    }
    $sel->execute();
    $rows = $sel->fetchAll();
    echo "   ✓ Nájdených: " . count($rows) . " výsledkov\n";
    foreach ($rows as $r) echo "      " . $r['id'] . " [skóre=" . $r['score'] . "]: " . mb_substr($r['title'], 0, 50) . "\n";
} catch (\PDOException $e) {
    echo "   ✗ CHYBA: " . $e->getMessage() . "\n";
    echo "   ← TOTO JE TEN BUG!\n";
}

echo "\n── Test FULLTEXT cesty ─────────────────────────────────────────\n";
try {
    $ft = $pdo->prepare("SELECT id, title FROM articles WHERE is_published=1 AND MATCH(title,excerpt,content) AGAINST(:q IN BOOLEAN MODE) LIMIT 3");
    $ft->execute(['q' => 'eGFR*']);
    $rows = $ft->fetchAll();
    echo "FULLTEXT eGFR* → " . count($rows) . " výsledkov\n";
    foreach ($rows as $r) echo "  " . $r['id'] . ": " . mb_substr($r['title'], 0, 50) . "\n";
} catch (\PDOException $e) {
    echo "FULLTEXT zlyhal: " . $e->getMessage() . "\n";
}
