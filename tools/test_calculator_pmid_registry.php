<?php

declare(strict_types=1);

/**
 * Offline register overených PubMed odkazov na stránkach portálu.
 *
 * Každý PMID tu bol overený proti NCBI esummary (prvý autor, rok, zväzok; Beh 160,
 * 3. 11. 2026). Nový alebo zmenený odkaz test odmietne, kým ho niekto neoverí cez
 * `php tools/check_calculator_pubmed.php` a nedoplní sem. Dôvod: odkazy na
 * calculator_gupta.php a calculator_mgrs.php viedli na nesúvisiace články
 * (polyadenylácia RNA, schistozomiáza pečene), hoci vracali HTTP 200.
 */

$root = dirname(__DIR__);
$checks = 0;

/** @var array<string, list<string>> súbor => overené PMID */
$registry = [
    'calculator_adpkd.php' => ['24904092'],
    'calculator_ckdpc.php' => ['35856507'],
    'calculator_ckm.php' => ['37807924'],
    'calculator_furst.php' => ['10768609'],
    'calculator_gupta.php' => ['38538012'],
    'calculator_kdpi.php' => ['19623019'],
    'calculator_mgrs.php' => ['30510265'],
    'calculator_mgus.php' => ['15855274'],
    'calculator_plasmic.php' => ['28259520', '31131442'],
    'calculator_tls.php' => ['15384972', '21561350'],
];

/** Známe chybné PMID, ktoré sa nesmú vrátiť. */
$knownWrong = ['38538052', '30401957'];

function pmidRegistryTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$found = [];
foreach (glob($root . '/*.php') ?: [] as $path) {
    $file = basename($path);
    if (str_starts_with($file, 'add_')) {
        continue;
    }
    if (preg_match_all('~https?://pubmed\.ncbi\.nlm\.nih\.gov/(\d+)~', (string) file_get_contents($path), $m) > 0) {
        $found[$file] = array_values(array_unique($m[1]));
        sort($found[$file]);
    }
}

foreach ($found as $file => $pmids) {
    $expected = $registry[$file] ?? [];
    sort($expected);
    pmidRegistryTest(
        $pmids === $expected,
        "{$file}: PubMed odkazy " . implode(',', $pmids) . ' nezodpovedajú registru ' . implode(',', $expected)
            . '. Over ich cez php tools/check_calculator_pubmed.php a doplň register.',
    );
    foreach ($knownWrong as $bad) {
        pmidRegistryTest(!in_array($bad, $pmids, true), "{$file}: známy chybný PMID {$bad}.");
    }
}
foreach (array_keys($registry) as $file) {
    pmidRegistryTest(isset($found[$file]), "{$file}: register očakáva PubMed odkaz, na stránke chýba.");
}

echo "Calculator PMID registry: $checks PASS\n";
