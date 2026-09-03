<?php
declare(strict_types=1);

$xml = simplexml_load_file(__DIR__ . '/pmid42584887.xml');
if ($xml === false) {
    fwrite(STDERR, "XML fail\n");
    exit(1);
}
$authors = $xml->PubmedArticle->MedlineCitation->Article->AuthorList->Author;
echo 'COUNT=' . count($authors) . PHP_EOL;
echo 'COMPLETE=' . (string) $xml->PubmedArticle->MedlineCitation->Article->AuthorList['CompleteYN'] . PHP_EOL;
foreach ($authors as $a) {
    echo (string) $a->ForeName . '|' . (string) $a->LastName . PHP_EOL;
}

echo "---FILE SIZES---\n";
foreach (['pmc13470430.xml', 'pmid42584887_pmcbioc.json', 'nct06012240.json', 'ctgov_upaa.json'] as $f) {
    $p = __DIR__ . '/' . $f;
    echo $f . ' ' . (is_file($p) ? filesize($p) : 'missing') . PHP_EOL;
}

$ct = json_decode((string) file_get_contents(__DIR__ . '/ctgov_upaa.json'), true);
if (is_array($ct) && isset($ct['studies']) && is_array($ct['studies'])) {
    echo "---CTGOV STUDIES---\n";
    foreach ($ct['studies'] as $s) {
        $id = $s['protocolSection']['identificationModule']['nctId'] ?? '?';
        $t = $s['protocolSection']['identificationModule']['briefTitle'] ?? '?';
        echo $id . ' | ' . $t . PHP_EOL;
    }
} else {
    echo "---CTGOV KEYS---\n";
    echo implode(',', array_keys(is_array($ct) ? $ct : [])) . PHP_EOL;
    echo substr((string) file_get_contents(__DIR__ . '/ctgov_upaa.json'), 0, 800) . PHP_EOL;
}
