<?php
$j = json_decode(file_get_contents(__DIR__ . '/crossref_surpass_cvot.json'), true);
$m = $j['message'];
echo 'title: ' . $m['title'][0] . PHP_EOL;
echo 'container: ' . $m['container-title'][0] . PHP_EOL;
echo 'issued: ' . json_encode($m['issued']) . PHP_EOL;
echo 'published-print: ' . json_encode($m['published-print'] ?? null) . PHP_EOL;
echo 'published-online: ' . json_encode($m['published-online'] ?? null) . PHP_EOL;
echo 'volume: ' . ($m['volume'] ?? '') . PHP_EOL;
echo 'issue: ' . ($m['issue'] ?? '') . PHP_EOL;
echo 'page: ' . ($m['page'] ?? '') . PHP_EOL;
echo 'DOI: ' . $m['DOI'] . PHP_EOL;
echo 'URL: ' . ($m['URL'] ?? '') . PHP_EOL;
echo 'author count: ' . count($m['author']) . PHP_EOL;
foreach ($m['author'] as $i => $a) {
    $given = $a['given'] ?? '';
    $family = $a['family'] ?? '';
    $name = $a['name'] ?? '';
    echo ($i + 1) . '. ' . trim($given . ' ' . $family . ' ' . $name) . PHP_EOL;
}
if (isset($m['abstract'])) {
    echo PHP_EOL . 'ABSTRACT:' . PHP_EOL . $m['abstract'] . PHP_EOL;
}
