<?php
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/search_helpers.php';
$q = 'eGFR';
$tokens = searchTokenize($q);
var_dump($tokens);
$sr = searchViaLike($pdo, $tokens, 0, 10, false);
var_dump($sr);
$sr2 = searchViaLike($pdo, $tokens, 0, 10, true);
var_dump($sr2);
