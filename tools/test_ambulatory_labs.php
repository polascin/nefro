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

/**
 * @param list<array<string, mixed>> $items
 * @return array<string, array<string, mixed>>
 */
function labsTestByCode(array $items): array
{
    $byCode = [];
    foreach ($items as $item) {
        $byCode[$item['code']] ??= $item;
    }

    return $byCode;
}

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
// Verzia pdf.js v skripte musí existovať v assets (register závislostí stráži obsah).
if (preg_match("/var PDFJS_BASE = '([^']+)'/", $js, $match) !== 1 || !is_file(__DIR__ . '/../' . $match[1] . 'pdf.min.mjs') || !is_file(__DIR__ . '/../' . $match[1] . 'pdf.worker.min.mjs')) {
    throw new \RuntimeException('PDFJS_BASE v calculator_ambulatory.js neukazuje na dodanú knižnicu pdf.js.');
}
$assertions++;

// 2. Riadkový výpis z Nefrisu s hlavičkou pacienta, referenčnými rozpätiami a príznakmi.
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

// 3. Dva parametre v riadku, bez dátumu.
$parsed = labsParse("Na 140 mmol/l   K 4,2 mmol/l   Cl 101 mmol/l\nUrea 12,1 mmol/l  Krea 245 umol/l\nP 1,2 mmol/l Mg 0,8 mmol/l\n");
labsTestSame(['na', 'k', 'cl', 'urea', 'krea', 'p', 'mg'], array_column($parsed['items'], 'code'), 'Viac parametrov v riadku');
labsTestSame([null], array_values(array_unique(array_column($parsed['items'], 'date'))), 'Bez dátumu odberu');

// 4. Kumulatívny stĺpcový výpis: hodnoty patria k dátumu stĺpca.
$cumulative = <<<TXT
Parameter         Jednotka   08.11.2026  12.10.2026  14.09.2026
Urea              mmol/l       18,4        17,9        16,2
Kreatinín         umol/l       412         398         350
eGFR              ml/s         0,22        0,23
Fosfor            mmol/l       2,10H                   1,85
PTH               pmol/l                   48,2
TXT;
$parsed = labsParse($cumulative);
labsTestSame(11, count($parsed['items']), 'Počet hodnôt kumulatívneho výpisu');
$phosphate = array_values(array_filter($parsed['items'], static fn (array $item): bool => $item['code'] === 'p'));
labsTestSame(['2026-11-08', '2026-09-14'], array_column($phosphate, 'date'), 'Fosfor priradený k správnym stĺpcom');
labsTestSame('H', $phosphate[0]['flag'], 'Pripojený príznak 2,10H');

// Polia formulára z kumulatívneho výpisu: bez veku a pohlavia eGFR z laboratória, slope zo starších odberov.
$values = labsFormValues($parsed['items'], null, null);
labsTestSame('lab', $values['egfr']['source'] ?? null, 'Bez veku a pohlavia sa použije eGFR z laboratória');
labsTestSame('13,2', labsNumber((float) $values['egfr']['ml_min'], 1), 'eGFR 0,22 ml/s = 13,2 ml/min');
labsTestSame(['2026-10-12'], array_column($values['slope'], 'date'), 'Slope len zo starších odberov s eGFR');
// S vekom a pohlavím sa eGFR počíta z kreatinínu (CKD-EPI 2021) pre každý odber.
$values = labsFormValues($parsed['items'], 62, 'male');
labsTestSame('computed', $values['egfr']['source'], 'S vekom a pohlavím CKD-EPI 2021 z kreatinínu');
labsTestSame('2026-11-08', $values['egfr']['date'], 'Aktuálne eGFR z najnovšieho odberu');
labsTestSame(['2026-10-12', '2026-09-14'], array_column($values['slope'], 'date'), 'Slope z kreatinínu starších odberov');
// Kreatinín 412 µmol/l, muž 62 r.: 412/88,4 = 4,661 mg/dl; 142 · (4,661/0,9)^-1,2 · 0,9938^62 = 13,4.
labsTestSame('13,4', labsNumber($values['egfr']['ml_min'], 1), 'CKD-EPI 2021, muž 62 r., kreatinín 412 µmol/l');

$template = labsBuildTemplate(labsTemplateData($parsed['items'], ['age' => 62, 'sex' => 'male']));
labsTestSame(true, str_contains($template, "iPTH: 48,2 pmol/L (12.10.2026)\n"), 'Hodnota zo staršieho odberu nesie dátum');
labsTestSame(true, str_contains($template, "S-Kreatinín: 412 mcmol/L\n"), 'Najnovší kreatinín bez dátumu');

// 5. Výsledkový list Synlab (text, ako ho z PDF poskladá calculator_ambulatory.js), vymyslené hodnoty.
$synlab = <<<TXT
Odber: 07.09.2026
Minerálne látky
S_Vápnik (A) 2,03 - 2,10 - 2,55 mmol/l BP
S_Fosfor (A) 1,62 + 0,74 - 1,52 mmol/l BP
S_Draslík (A) 5,4 + 3,50 - 5,10 mmol/l BP
S_Horčík (A) 0,83 0,66 - 1,07 mmol/l BP
Metabolity
S_Albumín (A) 36,5 - 35,0 - 52,0 g/l BP
S_Mocovina (A) 14,7 + 3,0 - 9,2 mmol/l BP
U_Celkové bielkoviny < 0,068 g/l BP
U_Albumín/U_Kreat. 12,4 + < 2,5 mg/mmol BP
eGF CKD-EPI 0,72 ml/s/1,73 m2 BP
S_CRP (A) 1,09 < 5,00 mg/l BP
Body mass index 27,17 + 20,00 - 25,00 kg/m^2 BP
S_Sodík (A) 139,5 136,0 - 145,0 mmol/l BP
S_Chloridy (A) 107 98 - 107 mmol/l BP
S_Kyselina močová (A) 327 220 - 450 umol/l BP
S_Kreatinín (A) 145 + 64 - 104 umol/l BP
S_Vitamín D celk. 45,2 - 75,0 - 100,0 nmol/l BP
< 30 výrazne nedostatočná koncentrácia
Krvný obraz
B_Leukocyty WBC 6,91 3,80 - 10,60 x10^9/l BP
B_Lymfocyty Lymph# 2,06 0,70 - 4,70 x10^9/l BP
B_Neutrofily NEUT% 61,7 45,0 - 73,0 % BP
B_Monocyty Mono% 7,2 2,0 - 9,0 % BP
B_Bazofily BASO% 0,9 < 1,0 % BP
B_Erytrocyty RBC 4,27 - 4,40 - 5,90 x10^12/l BP
B_Farb.ery MCH 25,4 - 26,0 - 34,0 pg BP
Sediment automat
U_Erytrocyty 13 + 0 - 10 počet/ul BP
Moč prúžkom
U_pH prúžkom 5,0 5,0 - 7,0 BP
U_Krv prúžkom + 0 - 5 BP
U_Hustota prúžkom 1,019 1,000 - 1,030 BP
S_Parathormón intakt. 154,8 + 15,0 - 68,3 ng/l BP
B_Neutrofily NEUT# 4,26 2,00 - 7,70 x10^9/l BP
B_Lymfocyty Lymph% 29,8 18,0 - 45,0 % BP
B_Eozinofily EO% 0,4 < 4,0 % BP
B_Hemoglobín HGB 115 - 130 - 180 g/l BP
B_Str.ob.ery MCV 78,2 - 80,0 - 100,0 fl BP
B_Trombocyty PLT 210 150 - 400 x10^9/l BP
U_Leukocyty 2 0 - 10 počet/ul BP
U_Glukóza prúžkom negat 0,00 - 3,00 mmol/l BP
U_Nitrity prúžkom negat BP
TXT;
$parsed = labsParse($synlab);
$byCode = labsTestByCode($parsed['items']);
labsTestSame(['2026-09-07'], array_values(array_unique(array_column($parsed['items'], 'date'))), 'Dátum odberu z PDF');
labsTestSame(['2,03', 'L', '2,10-2,55'], [$byCode['ca']['value'], $byCode['ca']['flag'], $byCode['ca']['ref']], 'Príznak „-“ medzi hodnotou a rozpätím');
labsTestSame(['1,62', 'H'], [$byCode['p']['value'], $byCode['p']['flag']], 'Príznak „+“ medzi hodnotou a rozpätím');
labsTestSame(['1,09', '< 5,00', 'mg/l'], [$byCode['crp']['value'], $byCode['crp']['ref'], $byCode['crp']['unit']], 'Neuzavreté rozpätie bez zátvoriek za hodnotou');
labsTestSame(['12,4', 'H', 'mg/mmol'], [$byCode['uacr']['value'], $byCode['uacr']['flag'], $byCode['uacr']['unit']], 'U_Albumín/U_Kreat. ako uACR');
labsTestSame('<0,068', $byCode['x:u celkove bielkoviny']['value'] ?? $byCode['uprot']['value'] ?? null, 'Porovnávací znak patrí k hodnote');
labsTestSame(false, isset($byCode['x:b neutrofily neut abs']) && ($byCode['neu']['value'] ?? '') === '4,26', 'Absolútny počet neutrofilov nie je podiel');
labsTestSame('61,7', $byCode['neu']['value'], 'NEUT% ako neutrofily v %');
labsTestSame(['sedery', 'uph', 'ubld', 'usg', 'sedleu', 'uglu', 'unitr'], array_values(array_intersect(array_column($parsed['items'], 'code'), ['sedery', 'uph', 'ubld', 'usg', 'sedleu', 'uglu', 'unitr'])), 'Moč prúžkom a sediment');
labsTestSame(1, $parsed['unparsed_count'], 'Výklad hodnôt vitamínu D nie je výsledok');

$data = labsTemplateData($parsed['items'], ['age' => 62, 'sex' => 'male']);
$expectedTemplate = <<<TXT
Laboratórne a pomocné vyšetrenia:

eGFR (CKD-EPI 2021): 0,78 mL/s/1,73m2 | 47 mL/min/1,73m2
eGFR (Cystatín C):  mL/s/1,73m2 |  mL/min/1,73m2
uACR: 12,4 mg/mmol

S-Kreatinín: 145 mcmol/L
S-Urea (močovina): 14,7 mmol/L
S-Kyselina močová: 327 mcmol/L

Ionogram:
S-Na: 139,5 mmol/L
S-K: 5,4 mmol/L
S-Cl: 107 mmol/L
S-Ca: 2,03 mmol/L
S-P: 1,62 mmol/L
S-Mg: 0,83 mmol/L

ABR:
HCO3-:  mmol/L (pH )
Korigovaný Ca pri hypalbuminémii: 2,10 mmol/L | Ionizovaný Ca:  mmol/L

Krvný obraz + diff.:
Hb: 115 g/L
Er: 4,27 x10^12/L; hypochrómne mikrocyty
Le: 6,91 x10^9/L; neutrofily 61,7 %, lymfocyty 29,8 %, monocyty 7,2 %, eozinofily 0,4 %, bazofily 0,9 %
Tr: 210 x10^9/L

S-Feritín:  mcg/L
Saturácia transferínu:  %

S-CRP: 1,09 mg/L
S-Albumín: 36,5 g/L
iPTH: 16,4 pmol/L
25-OH-vit. D: 45,2 nmol/L

Moč chem. + sediment: pH 5,0, hustota 1,019, glukóza negat, krv +, nitrity negat; sediment: erytrocyty 13/ul, leukocyty 2/ul
TXT;
labsTestSame(str_replace("\r\n", "\n", $expectedTemplate), labsBuildTemplate($data), 'Šablóna z výsledkového listu Synlab');
labsTestSame(
    ['eGFR (cystatín C)', 'HCO3-', 'pH', 'ionizovaný Ca', 'feritín', 'saturácia transferínu'],
    labsMissingTemplateLabels($data),
    'Údaje na ručné doplnenie',
);
foreach (explode("\r\n", ambulatoryToDosText(labsBuildTemplate($data))) as $line) {
    labsTestSame(true, mb_strlen($line, 'UTF-8') <= 80, 'Riadok šablóny v MS-DOS najviac 80 znakov');
}
$values = labsFormValues($parsed['items'], null, null);
labsTestSame(['lab', 43.2], [$values['egfr']['source'], round($values['egfr']['ml_min'], 1)], 'eGFR 0,72 ml/s z výsledkového listu');
labsTestSame(['value' => 12.4, 'unit' => 'mg_mmol'], $values['uacr'], 'uACR do formulára');
labsTestSame(27.17, $values['bmi'], 'BMI do formulára');

// 6. Odvodené hodnoty: korigovaný Ca, saturácia transferínu, eGFR z cystatínu C, prepočet jednotiek.
$derived = labsParse("Odber: 10.11.2026\nCa 2,10 mmol/l\nAlbumín 30 g/l\nFe 9 umol/l\nTIBC 60 umol/l\nCystatín C 1,6 mg/l\nKreatinín 1,8 mg/dl\nHb 10,5 g/dl\n25-OH vit. D 20 ng/ml\nMCV 104 fl\nHbA1c 58 mmol/mol\nuACR 300 mg/g\n");
$data = labsTemplateData($derived['items'], ['age' => 70, 'sex' => 'female']);
labsTestSame('2,30', $data['values']['cacorr']['text'], 'Korigovaný Ca: 2,10 + 0,02 · (40 - 30)');
labsTestSame('15', $data['values']['tsat']['text'], 'TSAT = Fe / TIBC');
labsTestSame('159', $data['values']['krea']['text'], 'Kreatinín 1,8 mg/dl = 159 µmol/l');
labsTestSame('105', $data['values']['hb']['text'], 'Hb 10,5 g/dl = 105 g/l');
labsTestSame('50', $data['values']['vitd']['text'], '25-OH vit. D 20 ng/ml = 50 nmol/l');
labsTestSame('makrocyty', $data['values']['morphology']['text'], 'MCV nad 100 fl bez rozpätia');
labsTestSame('33,9', $data['values']['uacr']['text'], 'uACR 300 mg/g = 33,9 mg/mmol');
// CKD-EPI 2012 cystatín C, žena 70 r., 1,6 mg/l: 133 · 2^-1,328 · 0,996^70 · 0,932 = 37,3.
labsTestSame(['0,62', '37'], $data['values']['egfrcys']['pair'], 'eGFR z cystatínu C (CKD-EPI 2012)');
labsTestSame('37,3', labsNumber(labsCkdEpi2012Cystatin(1.6, 70, 'female'), 1), 'CKD-EPI 2012 cystatín C, presná hodnota');
$values = labsFormValues($derived['items'], 70, 'female');
labsTestSame(['value' => 58.0, 'unit' => 'mmol_mol'], $values['hba1c'], 'HbA1c v mmol/mol');
labsTestSame(['value' => 300.0, 'unit' => 'mg_g'], $values['uacr'], 'uACR v mg/g ostáva v mg/g');
// Albumín 40 g/l a viac: bez korekcie, platí nameraný Ca.
$normalAlbumin = labsTemplateData(labsParse("Ca 2,40 mmol/l\nAlbumín 44 g/l\n")['items'], []);
labsTestSame('2,40', $normalAlbumin['values']['cacorr']['text'], 'Pri albumíne 44 g/l bez korekcie');

// 7. Prázdna šablóna: bez výsledkov ostanú len popisy a jednotky; eGFR a uACR z formulára.
$empty = labsBuildTemplate(labsTemplateData([], ['egfr_ml_min' => 42.0, 'uacr_value' => 35.0, 'uacr_unit' => 'mg_g']));
labsTestSame(true, str_contains($empty, "eGFR (CKD-EPI 2021): 0,70 mL/s/1,73m2 | 42 mL/min/1,73m2\n"), 'eGFR z formulára');
labsTestSame(true, str_contains($empty, "uACR: 4,0 mg/mmol\n"), 'uACR z formulára prepočítané na mg/mmol');
labsTestSame(true, str_contains($empty, "S-Kreatinín:  mcmol/L\n"), 'Prázdny riadok s jednotkou na doplnenie');
labsTestSame(true, str_ends_with($empty, 'Moč chem. + sediment:'), 'Prázdny riadok moču');

// 8. Aliasy a vzorky.
labsTestSame('uacr', labsResolveName('U-Alb/Krea'), 'Alb/Krea v moči');
labsTestSame('ukrea', labsResolveName('U-Kreatinín'), 'Kreatinín v moči nie je sérový');
labsTestSame('krea', labsResolveName('Kreatinín v sére'), 'Prípona vzorky séra');
labsTestSame('krea', labsResolveName('S_Kreatinín'), 'Predpona S_ zo Synlabu');
labsTestSame('vitd', labsResolveName('25-OH vit. D'), '25-OH vitamín D');
labsTestSame('cai', labsResolveName('Ca2+'), 'Ionizovaný vápnik');
labsTestSame('cacorr', labsResolveName('Vápnik korig./albumín'), 'Korigovaný vápnik zo Synlabu');
labsTestSame('hb', labsResolveName('B_Hemoglobín HGB'), 'Kód analyzátora za názvom');
labsTestSame('mch', labsResolveName('B_Farb.ery MCH'), 'Neznámy názov, známy kód analyzátora');
labsTestSame(null, labsResolveName('B_Neutrofily NEUT#'), 'Absolútny počet z diferenciálu');
labsTestSame('usprot', labsResolveName('U_Proteíny prúžkom'), 'Bielkovina prúžkom');
labsTestSame('uprot', labsResolveName('U-Bielkovina'), 'Kvantitatívna proteinúria');
labsTestSame('egfrcys', labsResolveName('eGFR cystatín C'), 'eGFR z cystatínu C nie je eGFR z kreatinínu');
labsTestSame(null, labsResolveName('Neznámy test'), 'Neznámy názov');

// 9. Normalizácia: tabulátor a rámčeky DOS.
$parsed = labsParse("│ 08.11.2026 │\n│Urea\t12,5\tmmol/l│\n");
labsTestSame(1, count($parsed['items']), 'Rámčeky a tabulátory');
labsTestSame('12,5', $parsed['items'][0]['value'], 'Hodnota z riadka s rámčekom');
// Riadok s rodným číslom bez lomky (výsledkový list) sa preskočí celý.
labsTestSame([], labsParse("Rodné číslo: 7001019999 ZP:24 Odber: 07.09.2026\n")['items'], 'Riadok s rodným číslom');
labsTestSame('2026-09-07', labsParse("Tlač: 09.09.2026 12:56\nOdber: 07.09.2026\nNa 140 mmol/l\n")['items'][0]['date'], 'Dátum tlače nie je dátum odberu');

// 10. Text z MS-DOS (CP852) prečítaný v inom kódovaní pred vložením do okna.
if (function_exists('iconv')) {
    $dosText = "Dátum odberu: 08.11.2026\nS-Kreatinín 412 umol/l\nKys. močová 455 umol/l\nŽelezo 12 umol/l\nĽudský ťažký ňô ýŕĺ";
    $dosBytes = (string) iconv('UTF-8', 'CP852', $dosText);
    foreach (labsMisreadEncodings() as $key => $encoding) {
        $misread = (string) @iconv($encoding['iconv'], 'UTF-8//IGNORE', $dosBytes);
        $repair = labsRepairDosText($misread);
        labsTestSame($key, $repair['from'], 'Rozpoznané nesprávne čítanie ' . $encoding['label']);
        labsTestSame($dosText, $repair['text'], 'Opravený text z ' . $encoding['label']);
    }
    $misread = (string) iconv('CP1250', 'UTF-8', $dosBytes);
    labsTestSame('cp1250', labsRepairDosText($misread, 'cp1250')['from'], 'Ručne zvolené kódovanie');
    labsTestSame($misread, labsRepairDosText($misread, 'none')['text'], 'Režim bez prevodu');
    labsTestSame('412', labsParse($misread)['items'][0]['value'] ?? null, 'Výpis sa parsuje aj bez opravy');
}
labsTestSame(null, labsRepairDosText($flow)['from'], 'Správny slovenský text sa nemení');
labsTestSame(null, labsRepairDosText("Urea 12,5 mmol/l\n")['from'], 'ASCII text sa nemení');

// Limit dĺžky riadku: počíta znaky, nie bajty, a pozná všetky konce riadkov.
labsTestSame(0, labsLongestLineChars(''), 'Prázdny vstup nemá riadok');
labsTestSame(9, labsLongestLineChars("Urea 12\r\nKreatinín\rK 4"), 'Najdlhší riadok v znakoch pri CRLF a CR');
labsTestSame(true, labsLongestLineChars(str_repeat('S-Urea 18,4 mmol/l ', 300)) > LABS_MAX_LINE_CHARS, 'Príliš dlhý riadok prekročí limit');
labsTestSame(true, labsLongestLineChars(str_repeat(str_repeat('x', 132) . "\n", 50)) <= LABS_MAX_LINE_CHARS, 'Výpis so 132 stĺpcami limit neprekročí');

echo "test_ambulatory_labs: {$assertions} assertions PASS\n";
