<?php
declare(strict_types=1);
$html = file_get_contents(__DIR__ . '/glp1_live.html');
if ($html === false) {
    fwrite(STDERR, "missing html\n");
    exit(1);
}

echo 'bytes: ' . strlen($html) . PHP_EOL;
echo 'Fatal error: ' . (preg_match('/Fatal error/i', $html) ? 'YES' : 'no') . PHP_EOL;
echo 'Parse error: ' . (preg_match('/Parse error/i', $html) ? 'YES' : 'no') . PHP_EOL;
echo 'Warning: ' . (preg_match('/<b>Warning<\/b>:/', $html) ? 'YES' : 'no') . PHP_EOL;

preg_match_all('/<title>(.*?)<\/title>/s', $html, $titles);
echo 'title count: ' . count($titles[0]) . PHP_EOL;
foreach ($titles[1] as $t) {
    echo 'title: ' . html_entity_decode(strip_tags($t), ENT_QUOTES | ENT_HTML5, 'UTF-8') . PHP_EOL;
}

preg_match_all('/<h1[^>]*>(.*?)<\/h1>/s', $html, $h1);
echo 'h1 count: ' . count($h1[0]) . PHP_EOL;
foreach ($h1[1] as $t) {
    echo 'h1: ' . html_entity_decode(strip_tags($t), ENT_QUOTES | ENT_HTML5, 'UTF-8') . PHP_EOL;
}

echo 'Slovak quotes: ' . (str_contains($html, '„') && str_contains($html, '“') ? 'yes' : 'NO') . PHP_EOL;
echo 'en dash: ' . (str_contains($html, '–') ? 'yes' : 'NO') . PHP_EOL;
echo '>= in body: ' . (preg_match('/>=/', $html) ? 'YES' : 'no') . PHP_EOL;
echo '<= in body: ' . (preg_match('/<=/', $html) ? 'maybe' : 'no') . PHP_EOL;
echo 'inline style=: ' . (preg_match('/style="/', $html) ? 'YES (check if from layout)' : 'no in file - need count') . PHP_EOL;
echo 'style= count: ' . substr_count($html, 'style="') . PHP_EOL;
echo '5 047: ' . (str_contains($html, '5 047') ? 'yes' : 'NO') . PHP_EOL;
echo '−560: ' . (str_contains($html, '−560') ? 'yes' : 'NO') . PHP_EOL;
echo 'Nancy: ' . (str_contains($html, 'Nancy A. Melville') ? 'yes' : 'NO') . PHP_EOL;
echo 'table-responsive: ' . substr_count($html, 'table-responsive') . PHP_EOL;
echo 'target=_blank count: ' . substr_count($html, 'target="_blank"') . PHP_EOL;
echo 'noopener: ' . (str_contains($html, 'noopener noreferrer') ? 'yes' : 'NO') . PHP_EOL;
echo 'kolko-krokov crosslink: ' . (str_contains($html, 'kolko-krokov-denne-staci') ? 'yes' : 'NO') . PHP_EOL;
echo 'Access Forbidden / 466: ' . (preg_match('/Access Forbidden|466/', $html) ? 'YES' : 'no') . PHP_EOL;

// first h2
if (preg_match('/<h2[^>]*>(.*?)<\/h2>/s', $html, $m)) {
    echo 'first h2: ' . html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8') . PHP_EOL;
}
