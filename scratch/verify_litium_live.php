<?php
declare(strict_types=1);
$h = @file_get_contents(__DIR__ . '/live_litium_headers.txt');
$b = @file_get_contents(__DIR__ . '/live_litium.html');
echo "=== HEADERS ===\n" . ($h === false ? "missing\n" : $h);
echo "=== BODY ===\n";
if ($b === false) {
    echo "missing body\n";
    exit(1);
}
echo 'LEN=' . strlen($b) . PHP_EOL;
echo 'FATAL=' . (stripos($b, 'Fatal error') !== false ? 'YES' : 'NO') . PHP_EOL;
echo 'WARNING_PHP=' . (preg_match('/<b>Warning<\/b>|<b>Notice<\/b>|Parse error/i', $b) ? 'YES' : 'NO') . PHP_EOL;
preg_match_all('/<title>(.*?)<\/title>/s', $b, $tm);
echo 'TITLE_COUNT=' . count($tm[1]) . PHP_EOL;
foreach ($tm[1] as $t) {
    echo 'TITLE=' . trim(html_entity_decode(strip_tags($t), ENT_QUOTES, 'UTF-8')) . PHP_EOL;
}
echo 'H1=' . (preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $b, $hm) ? trim(html_entity_decode(strip_tags($hm[1]), ENT_QUOTES, 'UTF-8')) : 'NONE') . PHP_EOL;
echo 'GHAEMI=' . (str_contains($b, 'Nassir Ghaemi') ? 'YES' : 'NO') . PHP_EOL;
echo 'LITIUM_WORD=' . (str_contains($b, 'Lítium') || str_contains($b, 'lítium') ? 'YES' : 'NO') . PHP_EOL;
echo 'U201E=' . preg_match_all('/\x{201E}/u', $b, $x) . ' U201C=' . preg_match_all('/\x{201C}/u', $b, $y) . PHP_EOL;
echo 'mmol_l=' . (str_contains($b, 'mmol/l') ? 'YES' : 'NO') . PHP_EOL;
echo 'mmol_L=' . (preg_match('/mmol\\/L/', $b) ? 'YES' : 'NO') . PHP_EOL;
echo 'inline_style_in_article=' . (preg_match('/class="article[\s\S]{0,200}style="/', $b) ? 'maybe' : 'not_obvious') . PHP_EOL;
echo 'table_responsive=' . preg_match_all('/table-responsive/', $b, $z) . PHP_EOL;
echo '466=' . (str_contains($h ?: '', '466') || str_contains($b, 'Access Forbidden') ? 'YES' : 'NO') . PHP_EOL;
