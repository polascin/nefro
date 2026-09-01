<?php

declare(strict_types=1);

const MKCH10_CODEBOOK_PATH = __DIR__ . '/assets/data/mkch10-sk.json';

/**
 * @return list<string>
 */
function mkch10NormalizeCodeList(string $rawCodes): array
{
    $parts = preg_split('/[,;\s]+/u', strtoupper(trim($rawCodes)), -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($parts)) {
        return [];
    }

    $codes = [];
    foreach ($parts as $part) {
        $code = trim($part);
        if ($code !== '' && !in_array($code, $codes, true)) {
            $codes[] = $code;
        }
    }

    return $codes;
}

/**
 * @return array<string, string>
 */
function mkch10LoadCodeIndex(): array
{
    static $index = null;

    if (is_array($index)) {
        return $index;
    }
    if (!is_file(MKCH10_CODEBOOK_PATH)) {
        throw new \RuntimeException('Importovaný číselník MKCH-10-SK nie je dostupný.');
    }

    $json = file_get_contents(MKCH10_CODEBOOK_PATH);
    if ($json === false) {
        throw new \RuntimeException('Importovaný číselník MKCH-10-SK sa nepodarilo načítať.');
    }

    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($data) || !isset($data['items']) || !is_array($data['items'])) {
        throw new \RuntimeException('Importovaný číselník MKCH-10-SK má neplatný formát.');
    }

    $index = [];
    foreach ($data['items'] as $item) {
        if (!is_array($item) || !isset($item[0], $item[1]) || !is_string($item[0]) || !is_string($item[1])) {
            continue;
        }
        $index[$item[0]] = $item[1];
    }

    return $index;
}

/**
 * @param list<string> $codes
 * @return list<string>
 */
function mkch10FindUnknownCodes(array $codes): array
{
    if ($codes === []) {
        return [];
    }

    $index = mkch10LoadCodeIndex();

    return array_values(array_filter(
        $codes,
        static fn(string $code): bool => !isset($index[$code])
    ));
}
