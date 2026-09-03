<?php
declare(strict_types=1);
$b = file_get_contents(__DIR__ . '/live_litium.html');
preg_match_all('/<h1[^>]*>(.*?)<\/h1>/s', $b, $hm);
echo "H1_COUNT=" . count($hm[1]) . PHP_EOL;
foreach ($hm[1] as $i => $t) {
    echo ($i + 1) . ': ' . trim(html_entity_decode(strip_tags($t), ENT_QUOTES, 'UTF-8')) . PHP_EOL;
}
echo "HAS_ARTICLE_TITLE=" . (str_contains($b, 'sedem mýtov, ktoré môžu brániť') ? 'YES' : 'NO') . PHP_EOL;
preg_match_all('/<h2[^>]*>(.*?)<\/h2>/s', $b, $h2);
echo "H2_COUNT=" . count($h2[1]) . PHP_EOL;
foreach (array_slice($h2[1], 0, 12) as $i => $t) {
    echo 'H2 ' . ($i + 1) . ': ' . trim(html_entity_decode(strip_tags($t), ENT_QUOTES, 'UTF-8')) . PHP_EOL;
}
echo "NDI=" . (str_contains($b, 'nefrogenný diabetes insipidus') ? 'YES' : 'NO') . PHP_EOL;
echo "BALANCE=" . (str_contains($b, 'BALANCE') ? 'YES' : 'NO') . PHP_EOL;
echo "0,6" . (str_contains($b, '0,6–0,8') ? '-0,8 YES' : ' NO') . PHP_EOL;
echo "Zucastneni=" . (str_contains($b, 'Nassir Ghaemi') ? 'YES' : 'NO') . PHP_EOL;
echo "target_blank=" . preg_match_all('/target="_blank"/', $b, $x) . PHP_EOL;
echo "noopener=" . preg_match_all('/rel="noopener noreferrer"/', $b, $y) . PHP_EOL;
