<?php

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.\n");
}

const MKCH10_OID = '1.3.158.00165387.100.10.25';

/**
 * @return string
 */
function mkch10XpathText(\SimpleXMLElement $element, string $query): string
{
    $element->registerXPathNamespace('j', 'http://eHealth.gov.sk/JRUZ/v1');
    $nodes = $element->xpath($query);

    return isset($nodes[0]) ? trim((string) $nodes[0]) : '';
}

/**
 * @param array<string, string|int> $meta
 * @param array<string, string> $items
 */
function mkch10WriteJson(string $outputPath, array $meta, array $items): void
{
    $directory = dirname($outputPath);
    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new \RuntimeException('Nepodarilo sa vytvoriť adresár: ' . $directory);
    }

    $metaJson = json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    $lines = ["{", '  "meta": ' . str_replace("\n", "\n  ", $metaJson) . ',', '  "items": ['];
    $position = 0;
    $lastPosition = count($items) - 1;

    foreach ($items as $code => $name) {
        $itemJson = json_encode([$code, $name], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $lines[] = '    ' . $itemJson . ($position < $lastPosition ? ',' : '');
        ++$position;
    }

    $lines[] = '  ]';
    $lines[] = '}';

    $temporaryPath = $outputPath . '.tmp';
    $bytes = file_put_contents($temporaryPath, implode("\n", $lines) . "\n", LOCK_EX);
    if ($bytes === false) {
        throw new \RuntimeException('Nepodarilo sa zapísať dočasný výstup: ' . $temporaryPath);
    }

    if (is_file($outputPath) && !unlink($outputPath)) {
        throw new \RuntimeException('Nepodarilo sa nahradiť existujúci výstup: ' . $outputPath);
    }
    if (!rename($temporaryPath, $outputPath)) {
        throw new \RuntimeException('Nepodarilo sa dokončiť výstup: ' . $outputPath);
    }
}

$zipPath = $argv[1] ?? '';
$outputPath = $argv[2] ?? dirname(__DIR__) . '/assets/data/mkch10-sk.json';

if ($zipPath === '' || !is_file($zipPath)) {
    fwrite(STDERR, "Použitie: php tools/import_mkch10_codebook.php <ciselniky_balik.zip> [vystup.json]\n");
    exit(1);
}

$zip = new \ZipArchive();
if ($zip->open($zipPath) !== true) {
    fwrite(STDERR, "ZIP balík sa nepodarilo otvoriť.\n");
    exit(1);
}

try {
    $selectedEntry = '';
    $selectedVersion = -1;

    for ($index = 0; $index < $zip->numFiles; ++$index) {
        $entryName = (string) $zip->getNameIndex($index);
        if (preg_match('~(?:^|/)' . preg_quote(MKCH10_OID, '~') . '-([0-9]+)\.xml$~', $entryName, $matches) !== 1) {
            continue;
        }

        $version = (int) $matches[1];
        if ($version > $selectedVersion) {
            $selectedVersion = $version;
            $selectedEntry = $entryName;
        }
    }

    if ($selectedEntry === '') {
        throw new \RuntimeException('V ZIP balíku sa nenašiel číselník diagnóz s OID ' . MKCH10_OID . '.');
    }

    $sourceStream = $zip->getStream($selectedEntry);
    $temporaryXml = tmpfile();
    if (!is_resource($sourceStream) || !is_resource($temporaryXml)) {
        throw new \RuntimeException('Nepodarilo sa otvoriť XML číselníka.');
    }

    try {
        if (stream_copy_to_stream($sourceStream, $temporaryXml) === false) {
            throw new \RuntimeException('Nepodarilo sa načítať XML číselníka.');
        }
        $temporaryMeta = stream_get_meta_data($temporaryXml);
        $temporaryUri = (string) ($temporaryMeta['uri'] ?? '');
        if ($temporaryUri === '') {
            throw new \RuntimeException('Dočasné XML nemá čitateľnú cestu.');
        }

        $reader = new \XMLReader();
        if (!$reader->open($temporaryUri, null, LIBXML_NONET | LIBXML_COMPACT | LIBXML_PARSEHUGE)) {
            throw new \RuntimeException('XML číselníka sa nepodarilo otvoriť.');
        }

        $header = [];
        $items = [];

        try {
            while ($reader->read()) {
                if ($reader->nodeType !== \XMLReader::ELEMENT) {
                    continue;
                }

                if ($reader->localName === 'ZahlavieCiselnika') {
                    $headerXml = $reader->readOuterXml();
                    $headerElement = simplexml_load_string($headerXml);
                    if (!$headerElement instanceof \SimpleXMLElement) {
                        throw new \RuntimeException('Hlavička XML číselníka je neplatná.');
                    }
                    $header = [
                        'name' => mkch10XpathText($headerElement, './j:codingSchemeName'),
                        'version' => mkch10XpathText($headerElement, './j:codingSchemeVersion'),
                        'last_updated' => mkch10XpathText($headerElement, './j:DatumPoslednejZmeny'),
                        'oid' => mkch10XpathText($headerElement, './j:codingScheme/j:oid'),
                        'valid_from' => mkch10XpathText($headerElement, './j:Platnost/j:DatumOd'),
                        'valid_to' => mkch10XpathText($headerElement, './j:Platnost/j:DatumDo'),
                    ];

                    continue;
                }

                if ($reader->localName !== 'PolozkaCiselnika') {
                    continue;
                }

                $itemXml = $reader->readOuterXml();
                $itemElement = simplexml_load_string($itemXml);
                if (!$itemElement instanceof \SimpleXMLElement) {
                    throw new \RuntimeException('Položka XML číselníka je neplatná.');
                }

                $code = strtoupper(mkch10XpathText(
                    $itemElement,
                    './j:DoplnujuciAtribut[j:IdAtributu="2"]/j:HodnotaS'
                ));
                $name = preg_replace('/\s+/u', ' ', mkch10XpathText($itemElement, './j:displayName')) ?? '';

                if (preg_match('/^[A-Z][0-9]{2}(?:\.[0-9A-Z]{1,2})?[*!†]?$/u', $code) !== 1 || $name === '') {
                    continue;
                }

                $items[$code] = $name;
            }
        } finally {
            $reader->close();
        }
    } finally {
        if (is_resource($sourceStream)) {
            fclose($sourceStream);
        }
        if (is_resource($temporaryXml)) {
            fclose($temporaryXml);
        }
    }

    if (($header['oid'] ?? '') !== MKCH10_OID || ($header['name'] ?? '') !== 'Zoznam diagnóz') {
        throw new \RuntimeException('Vybrané XML nie je očakávaný číselník diagnóz.');
    }
    if (($header['version'] ?? '') !== (string) $selectedVersion) {
        throw new \RuntimeException('Verzia v názve XML sa nezhoduje s hlavičkou číselníka.');
    }
    if ($items === []) {
        throw new \RuntimeException('Číselník neobsahuje žiadne použiteľné kódy diagnóz.');
    }

    uksort($items, 'strnatcasecmp');
    $meta = $header + [
        'source_entry' => $selectedEntry,
        'source_zip_sha256' => hash_file('sha256', $zipPath) ?: '',
        'count' => count($items),
    ];
    mkch10WriteJson($outputPath, $meta, $items);

    echo sprintf(
        "Import MKCH-10-SK dokončený: verzia %d, %d kódov, výstup %s\n",
        $selectedVersion,
        count($items),
        $outputPath
    );
} catch (\Throwable $exception) {
    fwrite(STDERR, 'Import MKCH-10-SK zlyhal: ' . $exception->getMessage() . "\n");
    exit(1);
} finally {
    $zip->close();
}
