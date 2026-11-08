<?php

declare(strict_types=1);

require_once __DIR__ . '/../ambulatory_labs.php';

$assertions = 0;

function labsTestSame(mixed $expected, mixed $actual, string $message): void
{
    global $assertions;
    $assertions++;
    if ($expected !== $actual) {
        throw new \RuntimeException(
            $message . ': očakávané ' . var_export($expected, true) . ', získané ' . var_export($actual, true),
        );
    }
}

$defaults = [
    'selection' => 'usual',
    'custom_list' => '',
    'dates' => 'latest',
    'format' => 'inline',
    'flags' => true,
    'ref' => false,
    'item_template' => '{nazov} {hodnota} {jednotka} {priznak}',
    'group_template' => 'Lab. {datum}: ',
    'separator' => ', ',
    'width' => 80,
];

// 1. Tabuľka CP852 v calculator_ambulatory.js musí sedieť s iconv (bajty 0x80 až 0xFF).
$js = (string) file_get_contents(__DIR__ . '/../calculator_ambulatory.js');
if (preg_match('/var CP852_HIGH = (.*?);/su', $js, $match) !== 1) {
    throw new \RuntimeException('V calculator_ambulatory.js chýba tabuľka CP852_HIGH.');
}
preg_match_all("/'((?:[^'\\\\]|\\\\.)*)'/u", $match[1], $pieces);
$table = (string) preg_replace_callback(
    '/\\\\u([0-9A-Fa-f]{4})/',
    static fn (array $m): string => mb_chr((int) hexdec($m[1]), 'UTF-8'),
    implode('', $pieces[1]),
);
labsTestSame(128, mb_strlen($table, 'UTF-8'), 'Tabuľka CP852 má 128 znakov');
if (function_exists('iconv')) {
    $expected = '';
    for ($byte = 0x80; $byte <= 0xFF; $byte++) {
        $expected .= (string) iconv('CP852', 'UTF-8', chr($byte));
    }
    labsTestSame($expected, $table, 'Tabuľka CP852 zodpovedá iconv');
}

// 2. Riadkový výpis s hlavičkou pacienta, referenčnými rozpätiami a príznakmi.
$flow = <<<TXT
Pacient: Testovací Pacient   RČ: 650615/1234
Dátum narodenia: 15.06.1985
Dátum odberu: 08.11.2026 07:30
S-Urea            18,4    mmol/l    (2,8 - 8,1)     H
S-Kreatinín       412     umol/l    (62 - 106)
eGFR CKD-EPI 2021 0,22    ml/s/1,73 m2
S-K               5,8     mmol/l    3,5 - 5,1
Hb                98      g/l       (135-175)       L
C-peptid          1,1     nmol/l
BE                -2,5    mmol/l    (-2,5 - 2,5)
TXT;
$parsed = labsParse($flow);
labsTestSame(7, count($parsed['items']), 'Počet položiek riadkového výpisu');
labsTestSame(['urea', 'krea', 'egfr', 'k', 'hb', 'x:c peptid', 'be'], array_column($parsed['items'], 'code'), 'Kódy položiek');
labsTestSame(['2026-11-08'], array_values(array_unique(array_column($parsed['items'], 'date'))), 'Dátum odberu (nie dátum narodenia)');
labsTestSame('H', $parsed['items'][1]['flag'], 'Príznak H odvodený z rozpätia kreatinínu');
labsTestSame('H', $parsed['items'][3]['flag'], 'Príznak H z neuzavretého rozpätia K');
labsTestSame('ml/s/1,73m2', $parsed['items'][2]['unit'], 'Jednotka eGFR, rok v názve nie je hodnota');
labsTestSame('-2,5-2,5', $parsed['items'][6]['ref'], 'Záporné referenčné rozpätie BE');
labsTestSame('', $parsed['items'][6]['flag'], 'BE na dolnej hranici nemá príznak');
foreach ($parsed['items'] as $item) {
    labsTestSame(false, str_contains($item['name'], 'Pacient'), 'Hlavička pacienta sa neparsuje');
}

$result = labsBuildOutput($flow, $defaults);
labsTestSame(
    "Lab. 08.11.2026: Urea 18,4 mmol/l H, Kreatinín 412 umol/l H,\r\n"
    . "  eGFR 0,22 ml/s/1,73m2, K 5,8 mmol/l H, Hb 98 g/l L",
    $result['output'],
    'Zvyčajný formát, CRLF, zalomenie po položkách',
);
foreach (explode("\r\n", $result['output']) as $line) {
    labsTestSame(true, mb_strlen($line, 'UTF-8') <= 80, 'Riadok výstupu najviac 80 znakov');
}

// 3. Dva parametre v riadku, bez dátumu.
$twoColumn = "Na 140 mmol/l   K 4,2 mmol/l   Cl 101 mmol/l\nUrea 12,1 mmol/l  Krea 245 umol/l\nP 1,2 mmol/l Mg 0,8 mmol/l\n";
$result = labsBuildOutput($twoColumn, $defaults);
labsTestSame(
    "Lab.: Urea 12,1 mmol/l, Kreatinín 245 umol/l, Na 140 mmol/l, K 4,2 mmol/l,\r\n  Cl 101 mmol/l, P 1,2 mmol/l, Mg 0,8 mmol/l",
    $result['output'],
    'Viac parametrov v riadku, poradie podľa katalógu',
);

// 4. Kumulatívny stĺpcový výpis.
$cumulative = <<<TXT
Parameter         Jednotka   08.11.2026  12.10.2026  14.09.2026
Urea              mmol/l       18,4        17,9        16,2
Kreatinín         umol/l       412         398
Fosfor            mmol/l       2,10H                   1,85
PTH               pmol/l                   48,2
TXT;
$parsed = labsParse($cumulative);
labsTestSame(8, count($parsed['items']), 'Počet hodnôt kumulatívneho výpisu');
$phosphate = array_values(array_filter($parsed['items'], static fn (array $item): bool => $item['code'] === 'p'));
labsTestSame(['2026-11-08', '2026-09-14'], array_column($phosphate, 'date'), 'Fosfor priradený k správnym stĺpcom');
labsTestSame('H', $phosphate[0]['flag'], 'Pripojený príznak 2,10H');

$table = labsBuildOutput($cumulative, ['format' => 'table'] + $defaults);
labsTestSame(
    "Parameter       08.11.26  12.10.26  14.09.26  Jednotka\r\n"
    . "Urea            18,4      17,9      16,2      mmol/l\r\n"
    . "Kreatinín       412       398       -         umol/l\r\n"
    . "P               2,10 H    -         1,85      mmol/l\r\n"
    . "PTH             -         48,2      -         pmol/l",
    $table['output'],
    'Tabuľka odberov',
);

$latestEach = labsBuildOutput($cumulative, ['dates' => 'latest_each'] + $defaults);
labsTestSame(
    "Lab. 08.11.2026: Urea 18,4 mmol/l, Kreatinín 412 umol/l, P 2,10 mmol/l H,\r\n  PTH 48,2 pmol/l (12.10.2026)",
    $latestEach['output'],
    'Posledná hodnota každého parametra so starším dátumom',
);

// 5. Vlastný zoznam a vlastný formát.
$custom = labsBuildOutput($flow, [
    'selection' => 'custom',
    'custom_list' => 'Hb, K, PCR, C-peptid, Neexistuje',
    'format' => 'custom',
    'item_template' => '{nazov}: {hodnota} {jednotka} ({priznak})',
    'group_template' => 'Odber {datum}\n',
    'separator' => '\n',
] + $defaults);
labsTestSame(
    "Odber 08.11.2026\r\nHb: 98 g/l (L)\r\nK: 5,8 mmol/l (H)\r\nC-peptid: 1,1 nmol/l",
    $custom['output'],
    'Vlastný zoznam a šablóna, prázdne zátvorky odstránené',
);
labsTestSame(['Neexistuje'], $custom['unresolved'], 'Nepriradená položka zoznamu');

$list = labsBuildOutput($flow, ['format' => 'list', 'ref' => true, 'selection' => 'custom', 'custom_list' => 'Krea, Hb'] + $defaults);
labsTestSame(
    "Laboratórne výsledky 08.11.2026:\r\n  Kreatinín  412 umol/l        H  (ref. 62-106)\r\n  Hb         98 g/l            L  (ref. 135-175)",
    $list['output'],
    'Zoznam s referenčným rozpätím',
);

// 6. Aliasy a vzorky.
labsTestSame('uacr', labsResolveName('U-Alb/Krea'), 'Alb/Krea v moči');
labsTestSame('ukrea', labsResolveName('U-Kreatinín'), 'Kreatinín v moči nie je sérový');
labsTestSame('krea', labsResolveName('Kreatinín v sére'), 'Prípona vzorky séra');
labsTestSame('vitd', labsResolveName('25-OH vit. D'), '25-OH vitamín D');
labsTestSame('cai', labsResolveName('Ca2+'), 'Ionizovaný vápnik');
labsTestSame(null, labsResolveName('Neznámy test'), 'Neznámy názov');

// 7. Normalizácia: tabulátor a rámčeky DOS.
$boxed = "│ 08.11.2026 │\n│Urea\t12,5\tmmol/l│\n";
$parsed = labsParse($boxed);
labsTestSame(1, count($parsed['items']), 'Rámčeky a tabulátory');
labsTestSame('12,5', $parsed['items'][0]['value'], 'Hodnota z riadka s rámčekom');

echo "test_ambulatory_labs: {$assertions} assertions PASS\n";
