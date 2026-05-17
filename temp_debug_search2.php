<?php
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/search_helpers.php';
$q = 'eGFR';
$tokens = searchTokenize($q);
var_dump($tokens);
$sr = doArticleSearch($pdo, $q, $tokens, 999, 10);
var_dump($sr['total']);
var_dump(count($sr['items']));
foreach ($sr['items'] as $r) {
    echo $r['id'] . "\n";
}
