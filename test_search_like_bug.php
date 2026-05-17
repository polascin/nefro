<?php
/**
 * test_search_like_bug.php — Test LIKE vyhľadávania ako v search.php
 * Reprodukuje presný SQL pattern použitý v searchViaLike()
 */
if (php_sapi_name() !== 'cli') { exit(403); }
require_once __DIR__ . '/db_config.php';

function escapeLikeTerm(string $term): string
{
    return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $term);
}

function buildLikeSearchSql(array $tokens): array
{
    $whereParams = [];
    $scoreParams = [];
    $whereParts = [];
    $scoreParts = [];
    $idx = 0;

    foreach ($tokens as $norm => $orig) {
        $term = escapeLikeTerm($orig);
        $pattern = "%{$term}%";

        $wT = "wt{$idx}";
        $wE = "we{$idx}";
        $wC = "wc{$idx}";
        $whereParams[$wT] = $pattern;
        $whereParams[$wE] = $pattern;
        $whereParams[$wC] = $pattern;
        $whereParts[] = "(title LIKE :{$wT} ESCAPE '\\\\' OR excerpt LIKE :{$wE} ESCAPE '\\\\' OR content LIKE :{$wC} ESCAPE '\\\\')";

        $sT = "st{$idx}";
        $sE = "se{$idx}";
        $sC = "sc{$idx}";
        $scoreParams[$sT] = $pattern;
        $scoreParams[$sE] = $pattern;
        $scoreParams[$sC] = $pattern;
        $scoreParts[] = "(CASE WHEN title LIKE :{$sT} ESCAPE '\\\\' THEN 10 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN excerpt LIKE :{$sE} ESCAPE '\\\\' THEN 5 ELSE 0 END)";
        $scoreParts[] = "(CASE WHEN content LIKE :{$sC} ESCAPE '\\\\' THEN 1 ELSE 0 END)";

        $idx++;
    }

    return [
        $whereParams,
        $scoreParams,
        implode(' AND ', $whereParts),
        implode(' + ', $scoreParts),
    ];
}

echo "── Test searchViaLike() pattern ────────────────────────────────\n\n";

echo "1. Rozšírený LIKE test pre špeciálne prípady vyhľadávania:\n";
$cases = [
    ['egfr' => 'eGFR'],
    ['hyponatriemia' => 'hyponatriémia'],
    ['vitamin d' => 'vitamín D'],
];

foreach ($cases as $case) {
    $label = implode(' + ', $case);
    echo "\nTest: {$label}\n";
    [$whereParams, $scoreParams, $whereClause, $scoreExpr] = buildLikeSearchSql($case);

    try {
        $cnt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE is_published=1 AND ({$whereClause})");
        $cnt->execute($whereParams);
        echo "   ✓ COUNT = " . $cnt->fetchColumn() . "\n";
    } catch (\PDOException $e) {
        echo "   ✗ COUNT CHYBA: " . $e->getMessage() . "\n";
    }

    try {
        $sel = $pdo->prepare(
            "SELECT id, title, ({$scoreExpr}) AS score
             FROM articles
             WHERE is_published=1 AND ({$whereClause})
             ORDER BY score DESC LIMIT 5"
        );
        foreach ($whereParams as $k => $v) {
            $sel->bindValue(':' . $k, $v, PDO::PARAM_STR);
        }
        foreach ($scoreParams as $k => $v) {
            $sel->bindValue(':' . $k, $v, PDO::PARAM_STR);
        }
        $sel->execute();
        $rows = $sel->fetchAll();
        echo "   ✓ SELECT = " . count($rows) . " výsledkov\n";
        foreach ($rows as $r) {
            echo "      " . $r['id'] . " [skóre=" . $r['score'] . "]: " . mb_substr($r['title'], 0, 50) . "\n";
        }
    } catch (\PDOException $e) {
        echo "   ✗ SELECT CHYBA: " . $e->getMessage() . "\n";
    }
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
