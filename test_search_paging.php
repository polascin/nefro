<?php
/**
 * test_search_paging.php — Regression test for search page clamping.
 *
 * This script includes search.php with a very large page number and
 * verifies that the search result still returns valid items instead of
 * empty output due to out-of-range pagination.
 */
if (php_sapi_name() !== 'cli') {
    exit(403);
}

require_once __DIR__ . '/db_config.php';

$_SERVER['PHP_SELF'] = '/test_search_paging.php';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['s'] = 'eGFR';
$_GET['page'] = 999;

ob_start();
include __DIR__ . '/search.php';
$html = ob_get_clean();

if (stripos($html, 'Žiadne výsledky') !== false) {
    echo "✗ FAILED: search.php returned no results for a large page number.\n";
    exit(1);
}

$matches = [];
$count = preg_match_all('/<article[^>]+class="search-result"/i', $html, $matches);
if ($count === false) {
    echo "✗ FAILED: Could not parse search result output.\n";
    exit(1);
}

if ($count > 0) {
    echo "✓ PASS: Out-of-range pagination is clamped and returned {$count} result(s).\n";
    exit(0);
}

echo "✗ FAILED: No search result items rendered for out-of-range page.\n";
exit(1);
