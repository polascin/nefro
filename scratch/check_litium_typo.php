<?php
declare(strict_types=1);
$t = file_get_contents(__DIR__ . '/../add_litium-sedem-mytov-nefrologicka-perspektiva_article.php');
if ($t === false) {
    exit(1);
}
if (preg_match_all('/.{0,50}lítia.{0,50}/u', $t, $m)) {
    foreach ($m[0] as $i => $s) {
        echo ($i + 1) . ': ' . trim(preg_replace('/\s+/u', ' ', $s) ?? $s) . PHP_EOL;
    }
}
echo "---quotes---\n";
echo 'U201E=' . preg_match_all('/\x{201E}/u', $t, $x) . ' U201C=' . preg_match_all('/\x{201C}/u', $t, $y) . PHP_EOL;
echo 'ascii_quot=' . preg_match_all('/"/', $t, $z) . PHP_EOL;
echo 'en_dash=' . preg_match_all('/–/', $t, $a) . PHP_EOL;
echo 'style=' . (preg_match('/style=/', $t) ? 'YES' : 'NO') . PHP_EOL;
echo 'target_blank_no_rel=' . (preg_match('/target="_blank"(?! rel="noopener noreferrer")/', $t) ? 'YES' : 'NO') . PHP_EOL;
echo 'table_without_wrapper=' . (preg_match('/(?<!table-responsive" role="region" aria-label="[^"]+" tabindex="0">\n)<table>/', $t) ? 'maybe' : 'check_manual') . PHP_EOL;
echo 'table_count=' . preg_match_all('/<table>/', $t, $b) . ' wrappers=' . preg_match_all('/table-responsive/', $t, $c) . PHP_EOL;
echo 'th_scope=' . preg_match_all('/<th scope="/', $t, $d) . PHP_EOL;
