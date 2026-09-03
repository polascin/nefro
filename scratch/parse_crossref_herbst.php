<?php
declare(strict_types=1);
$j = json_decode((string) file_get_contents(__DIR__ . '/crossref_herbst.json'), true);
$auth = $j['message']['author'] ?? [];
echo 'count=' . count($auth) . PHP_EOL;
foreach ($auth as $i => $a) {
    echo ($i + 1) . '. ' . ($a['given'] ?? '') . ' ' . ($a['family'] ?? '') . PHP_EOL;
}
