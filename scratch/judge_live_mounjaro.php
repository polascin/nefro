<?php
$headers = file_get_contents(__DIR__ . '/live_mounjaro_headers.txt');
$body = file_get_contents(__DIR__ . '/live_mounjaro.html');
echo $headers . PHP_EOL;
echo 'BYTES=' . strlen($body) . PHP_EOL;
echo 'FATAL=' . (preg_match('/Fatal error/i', $body) ? 'YES' : 'no') . PHP_EOL;
echo 'TITLES=' . preg_match_all('/<title>/i', $body, $m) . PHP_EOL;
if (preg_match('/<title>(.*?)<\/title>/is', $body, $t)) {
    echo 'TITLE=' . trim(html_entity_decode($t[1], ENT_QUOTES | ENT_HTML5, 'UTF-8')) . PHP_EOL;
}
echo 'H1=' . (preg_match('/<h1[^>]*>/i', $body) ? 'yes' : 'no') . PHP_EOL;
echo 'OPEN_QUOTE=' . (strpos($body, "\xE2\x80\x9E") !== false ? 'yes' : 'no') . PHP_EOL;
echo 'CLOSE_QUOTE=' . (strpos($body, "\xE2\x80\x9C") !== false ? 'yes' : 'no') . PHP_EOL;
echo 'EN_DASH=' . (strpos($body, "\xE2\x80\x93") !== false ? 'yes' : 'no') . PHP_EOL;
echo 'INLINE_STYLE=' . (preg_match('/style="/', $body) ? 'YES' : 'no') . PHP_EOL;
echo 'SLUG_IN_BODY=' . (strpos($body, 'tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot') !== false ? 'yes' : 'no') . PHP_EOL;
echo 'NEINFERIORITA=' . (strpos($body, 'neinferioritu') !== false ? 'yes' : 'no') . PHP_EOL;
echo 'EMA=' . (preg_match('/CHMP|EMA/', $body) ? 'yes' : 'no') . PHP_EOL;
echo '12.2=' . (strpos($body, '12,2') !== false ? 'yes' : 'no') . PHP_EOL;
echo '0.09=' . (strpos($body, '0,09') !== false ? 'yes' : 'no') . PHP_EOL;
