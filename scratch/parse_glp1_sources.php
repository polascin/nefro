<?php
declare(strict_types=1);

$extractPath = 'C:/Users/polas/.cursor/projects/d-Dev-nefro/agent-tools/d92c6fa5-a7cd-473e-bbb6-b9bac8e6ebdf.txt';
$pubmedPath = 'C:/Users/polas/.cursor/projects/d-Dev-nefro/agent-tools/76acd060-beaf-4b26-a1ba-b4f90c6773dd.txt';

$j = json_decode((string) file_get_contents($extractPath), true);
if (!is_array($j)) {
    fwrite(STDERR, "extract JSON failed\n");
    exit(1);
}
echo "FAILED: " . json_encode($j['failed_results'] ?? []) . "\n\n";
foreach ($j['results'] as $i => $r) {
    $out = __DIR__ . "/glp1_extract_{$i}.md";
    $body = "URL: {$r['url']}\nTITLE: {$r['title']}\n\n" . ($r['raw_content'] ?? '');
    file_put_contents($out, $body);
    echo "Wrote {$out} (" . strlen($body) . " bytes)\n";
}

$raw = (string) file_get_contents($pubmedPath);
file_put_contents(__DIR__ . '/glp1_pubmed_raw.xml', $raw);
echo "Wrote pubmed raw " . strlen($raw) . " bytes\n";
