<?php
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/search_helpers.php';
$q = 'eGFR';
$tokens = searchTokenize($q);
$useNormalized = false;
$whereParams = [];
$scoreParams = [];
$whereParts = [];
$scoreParts = [];
$idx = 0;
foreach ($tokens as $norm => $orig) {
    $term = $useNormalized ? $norm : $orig;
    $term = str_replace(["\\", "%", "_"], ["\\\\", "\\%", "\\_"], $term);
    $pattern = "%" . $term . "%";
    $wT = "wt" . $idx;
    $wE = "we" . $idx;
    $wC = "wc" . $idx;
    $whereParams[$wT] = $pattern;
    $whereParams[$wE] = $pattern;
    $whereParams[$wC] = $pattern;
    $whereParts[] = "(title LIKE :{$wT} ESCAPE '\\' OR excerpt LIKE :{$wE} ESCAPE '\\' OR content LIKE :{$wC} ESCAPE '\\')";
    $sT = "st" . $idx;
    $sE = "se" . $idx;
    $sC = "sc" . $idx;
    $scoreParams[$sT] = $pattern;
    $scoreParams[$sE] = $pattern;
    $scoreParams[$sC] = $pattern;
    $scoreParts[] = "(CASE WHEN title   LIKE :{$sT} ESCAPE '\\' THEN 10 ELSE 0 END)";
    $scoreParts[] = "(CASE WHEN excerpt LIKE :{$sE} ESCAPE '\\' THEN  5 ELSE 0 END)";
    $scoreParts[] = "(CASE WHEN content LIKE :{$sC} ESCAPE '\\' THEN  1 ELSE 0 END)";
    $idx++;
}
$whereClause = implode(' AND ', $whereParts);
$scoreExpr = implode(' + ', $scoreParts);
$cntSql = "SELECT COUNT(*) FROM articles WHERE is_published = 1 AND ({$whereClause})";
echo $cntSql . "\n";
var_dump($whereParams);
$cntStmt = $pdo->prepare($cntSql);
if (!$cntStmt) {
    var_dump($pdo->errorInfo());
    exit(1);
}
$res = $cntStmt->execute($whereParams);
var_dump($res);
var_dump($cntStmt->errorInfo());
echo 'total=' . $cntStmt->fetchColumn() . "\n";
