<?php
declare(strict_types=1);
$t = file_get_contents(__DIR__ . '/../add_litium-sedem-mytov-nefrologicka-perspektiva_article.php');
if (preg_match_all('/.{0,70}o lítiu.{0,70}/u', $t, $m)) {
    foreach ($m[0] as $i => $s) {
        echo ($i + 1) . ': ' . trim(preg_replace('/\s+/u', ' ', $s) ?? $s) . PHP_EOL;
    }
} else {
    echo "no o lítiu\n";
}
