<?php

declare(strict_types=1);

require_once __DIR__ . '/../mkch10_codebook.php';

$assertions = 0;

function mkch10TestSame(mixed $expected, mixed $actual, string $label): void
{
    global $assertions;
    ++$assertions;
    if ($expected !== $actual) {
        fwrite(STDERR, sprintf(
            "%s: očakávané %s, získané %s\n",
            $label,
            var_export($expected, true),
            var_export($actual, true)
        ));
        exit(1);
    }
}

$json = file_get_contents(MKCH10_CODEBOOK_PATH);
if ($json === false) {
    fwrite(STDERR, "Číselník sa nepodarilo načítať.\n");
    exit(1);
}

$data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
if (!is_array($data) || !isset($data['meta'], $data['items']) || !is_array($data['meta']) || !is_array($data['items'])) {
    fwrite(STDERR, "Číselník má neplatnú štruktúru.\n");
    exit(1);
}

$index = mkch10LoadCodeIndex();

mkch10TestSame('1.3.158.00165387.100.10.25', $data['meta']['oid'] ?? null, 'OID číselníka');
mkch10TestSame('26', $data['meta']['version'] ?? null, 'Verzia číselníka');
mkch10TestSame('2026-01-01', $data['meta']['valid_from'] ?? null, 'Začiatok platnosti');
mkch10TestSame(17008, count($index), 'Počet unikátnych kódov');
mkch10TestSame(17008, $data['meta']['count'] ?? null, 'Počet kódov v metadátach');
mkch10TestSame('Chronická choroba obličiek, 3. štádium', $index['N18.3'] ?? null, 'CKD N18.3');
mkch10TestSame(
    'Diabetes mellitus 2. typu: s obličkovými komplikáciami, kompenzovaný',
    $index['E11.20†'] ?? null,
    'Diabetická choroba obličiek E11.20'
);
mkch10TestSame(
    'Hypertenzná choroba obličiek s obličkovým zlyhávaním, bez hypertenznej krízy',
    $index['I12.00'] ?? null,
    'Hypertenzná choroba obličiek I12.00'
);
mkch10TestSame(
    ['N18.3', 'I12.00', 'D63.8*'],
    mkch10NormalizeCodeList('n18.3, I12.00; n18.3 D63.8*'),
    'Normalizácia a odstránenie duplicít'
);
mkch10TestSame([], mkch10FindUnknownCodes(['N18.3', 'I12.00', 'D63.8*']), 'Známe kódy');
mkch10TestSame(['E11.2'], mkch10FindUnknownCodes(['E11.2']), 'Neaktuálny neúplný kód');

echo 'MKCH-10-SK: ' . $assertions . " kontrol prešlo.\n";
