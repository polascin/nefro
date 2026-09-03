<?php
declare(strict_types=1);

$path = 'C:\\Users\\polas\\.cursor\\projects\\d-Dev-nefro\\agent-tools\\0f396ee1-1e9f-44b9-98ca-e27e7b7b6111.txt';
$raw = file_get_contents($path);
$data = json_decode($raw, true);
if (!is_array($data)) {
    fwrite(STDERR, "json fail: " . json_last_error_msg() . "\n");
    exit(1);
}
$outDir = __DIR__;
foreach ($data['results'] as $i => $r) {
    $url = $r['url'] ?? 'unknown';
    $title = $r['title'] ?? '';
    $content = $r['raw_content'] ?? ($r['content'] ?? '');
    echo "RESULT $i\nURL: $url\nTITLE: $title\nLEN: " . strlen((string) $content) . "\n\n";
    $safe = 'extract_' . $i . '.md';
    file_put_contents($outDir . '/' . $safe, "# $title\n\nURL: $url\n\n" . $content);
}
