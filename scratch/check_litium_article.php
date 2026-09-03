<?php
declare(strict_types=1);
$f = file_get_contents(__DIR__ . '/../add_litium-sedem-mytov-nefrologicka-perspektiva_article.php');
if ($f === false) {
    fwrite(STDERR, "read fail\n");
    exit(1);
}
if (preg_match("/'excerpt'\\s+=>\\s+'([^']+)'/", $f, $m)) {
    echo 'EXCERPT_LEN=' . mb_strlen($m[1], 'UTF-8') . PHP_EOL;
    echo $m[1] . PHP_EOL;
}
echo 'bez_titulu=' . (str_contains($f, 'bez titulu') ? 'YES' : 'NO') . PHP_EOL;
echo 'inline_style=' . (preg_match('/style="/', $f) ? 'YES' : 'NO') . PHP_EOL;
echo 'mmol_L=' . (preg_match('/mmol\\/L/', $f) ? 'YES' : 'NO') . PHP_EOL;
echo 'ascii_dquote=' . (preg_match('/[„].{0,80}["”]/u', $f) ? 'check_quotes' : 'ok_or_none') . PHP_EOL;
echo 'starts_h2_title=' . (preg_match("/<<<'HTML'\\s*<h2>/", $f) ? 'YES' : 'NO') . PHP_EOL;
echo 'php_version=' . PHP_VERSION . PHP_EOL;
