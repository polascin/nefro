<?php

declare(strict_types=1);

/**
 * Overí PubMed odkazy na stránkach portálu (koreňové *.php okrem add_*) proti NCBI esummary.
 *
 * Dostupný odkaz nedokazuje správnu citáciu (Beh 134, 159): PMID môže viesť na úplne iný
 * článok. Pre každý odkaz porovná text odkazu s PubMed: priezvisko prvého autora, rok
 * a zväzok musia byť v texte odkazu. Text odkazu „PMID 123“ sa považuje za čistý identifikátor.
 *
 * Použitie (CLI, sieť): php tools/check_calculator_pubmed.php [--json]
 * Exit 0 = všetko sedí, 1 = nesúlad, 2 = chyba siete alebo odpovede.
 * Nespúšťa sa v regresnej sade (izolovanej od siete); offline pin je
 * tools/test_calculator_pmid_registry.php.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}

$root = dirname(__DIR__);
$asJson = in_array('--json', $argv ?? [], true);

/** @return list<array{file: string, pmid: string, text: string}> */
function pubmedLinksInPages(string $root): array
{
    $links = [];
    foreach (glob($root . '/*.php') ?: [] as $path) {
        $file = basename($path);
        if (str_starts_with($file, 'add_')) {
            continue;
        }
        $src = (string) file_get_contents($path);
        if (preg_match_all('~<a[^>]+href="https?://pubmed\.ncbi\.nlm\.nih\.gov/(\d+)/?"[^>]*>(.*?)</a>~s', $src, $m, PREG_SET_ORDER) === false) {
            continue;
        }
        foreach ($m as $hit) {
            $text = html_entity_decode(strip_tags($hit[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = trim((string) preg_replace('/\s+/u', ' ', str_replace("\u{00A0}", ' ', $text)));
            $links[] = ['file' => $file, 'pmid' => $hit[1], 'text' => $text];
        }
    }

    return $links;
}

$links = pubmedLinksInPages($root);
$ids = array_values(array_unique(array_column($links, 'pmid')));
if ($ids === []) {
    fwrite(STDOUT, "Žiadne PubMed odkazy.\n");
    exit(0);
}

$url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&retmode=json&id=' . implode(',', $ids);
$ctx = stream_context_create(['http' => ['timeout' => 20, 'user_agent' => 'nefro-citation-check/1.0']]);
$body = @file_get_contents($url, false, $ctx);
$data = is_string($body) ? json_decode($body, true) : null;
if (!is_array($data) || !isset($data['result']) || !is_array($data['result'])) {
    fwrite(STDERR, "Chyba: NCBI esummary neodpovedalo platným JSON.\n");
    exit(2);
}
$result = $data['result'];

$problems = [];
foreach ($links as $link) {
    $rec = $result[$link['pmid']] ?? null;
    if (!is_array($rec) || isset($rec['error'])) {
        $problems[] = $link + ['reason' => 'PMID v PubMed neexistuje'];
        continue;
    }
    if (preg_match('/^PMID\s*\d+$/u', $link['text']) === 1) {
        continue;
    }
    $firstAuthor = (string) ($rec['authors'][0]['name'] ?? '');
    $surname = (string) preg_replace('/\s+\S+$/u', '', $firstAuthor);
    $year = substr((string) ($rec['pubdate'] ?? ''), 0, 4);
    $volume = (string) ($rec['volume'] ?? '');
    $missing = [];
    if ($surname !== '' && mb_stripos($link['text'], $surname) === false) {
        $missing[] = "autor {$surname}";
    }
    if ($year !== '' && !str_contains($link['text'], $year)) {
        $missing[] = "rok {$year}";
    }
    if ($volume !== '' && !preg_match('/(?<!\d)' . preg_quote($volume, '/') . '(?!\d)/', $link['text'])) {
        $missing[] = "zväzok {$volume}";
    }
    if ($missing !== []) {
        $problems[] = $link + ['reason' => 'v texte chýba ' . implode(', ', $missing) . ' (PubMed: ' . $firstAuthor . ', ' . ($rec['source'] ?? '') . ' ' . ($rec['pubdate'] ?? '') . '; „' . mb_substr((string) ($rec['title'] ?? ''), 0, 80) . '“)'];
    }
}

if ($asJson) {
    fwrite(STDOUT, (string) json_encode(['links' => count($links), 'problems' => $problems], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
} else {
    foreach ($problems as $p) {
        fwrite(STDOUT, "NESÚLAD {$p['file']} PMID {$p['pmid']}: {$p['reason']}\n");
    }
    fwrite(STDOUT, sprintf("PubMed odkazy: %d, nesúlad: %d\n", count($links), count($problems)));
}

exit($problems === [] ? 0 : 1);
