<?php
/**
 * Import všetkých obcí SR z CSV súboru (gunsoft/obce-okresy-kraje-slovenska)
 * do tabuľky codebook_municipalities.
 *
 * Zdroj: https://github.com/gunsoft/obce-okresy-kraje-slovenska
 * Licencia: GPL-3.0
 * Spúšťa sa iba cez CLI: php import_municipalities_from_csv.php
 *
 * Formát CSV: id, name, name2, zip, district_id, region_id
 * Okresy: gunsoft district_id → náš district_name (mapa nižšie)
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Spúšťajte iba cez CLI.\n");
}

require_once __DIR__ . '/db_config.php';

// ── Konverzia CSV súboru z Windows-1250 na UTF-8 ────────────────────
$csvPath = __DIR__ . '/private/villages_sk.csv';
if (!file_exists($csvPath)) {
    exit("CHYBA: Súbor private/villages_sk.csv neexistuje.\n");
}

$raw  = file_get_contents($csvPath);
// Súbor bol stiahnutý Invoke-WebRequest ako UTF-8
$utf8 = $raw;
$lines = preg_split('/\r?\n/', trim($utf8));
echo "Načítaných riadkov: " . count($lines) . "\n";

// ── Mapa gunsoft district_id → [district_name, region_code] ─────────
// Zdroj: CSV/districts.csv z rovnakého repozitára
$districtMap = [
    1  => ['Bánovce nad Bebravou',  'TC'],
    2  => ['Banská Bystrica',       'BC'],
    3  => ['Banská Štiavnica',      'BC'],
    4  => ['Bardejov',              'PV'],
    5  => ['Bratislava I',          'BL'],
    6  => ['Bratislava II',         'BL'],
    7  => ['Bratislava III',        'BL'],
    8  => ['Bratislava IV',         'BL'],
    9  => ['Bratislava V',          'BL'],
    10 => ['Brezno',                'BC'],
    11 => ['Bytča',                 'ZI'],
    12 => ['Čadca',                 'ZI'],
    13 => ['Detva',                 'BC'],
    14 => ['Dolný Kubín',           'ZI'],
    15 => ['Dunajská Streda',       'TA'],
    16 => ['Galanta',               'TA'],
    17 => ['Gelnica',               'KI'],
    18 => ['Hlohovec',              'TA'],
    19 => ['Humenné',               'PV'],
    20 => ['Ilava',                 'TC'],
    21 => ['Kežmarok',              'PV'],
    22 => ['Komárno',               'NI'],
    23 => ['Košice I',              'KI'],
    24 => ['Košice II',             'KI'],
    25 => ['Košice III',            'KI'],
    26 => ['Košice IV',             'KI'],
    27 => ['Košice-okolie',         'KI'],
    28 => ['Krupina',               'BC'],
    29 => ['Kysucké Nové Mesto',    'ZI'],
    30 => ['Levice',                'NI'],
    31 => ['Levoča',                'PV'],
    32 => ['Liptovský Mikuláš',     'ZI'],
    33 => ['Lučenec',               'BC'],
    34 => ['Malacky',               'BL'],
    35 => ['Martin',                'ZI'],
    36 => ['Medzilaborce',          'PV'],
    37 => ['Michalovce',            'KI'],
    38 => ['Myjava',                'TC'],
    39 => ['Námestovo',             'ZI'],
    40 => ['Nitra',                 'NI'],
    41 => ['Nové Mesto nad Váhom',  'TC'],
    42 => ['Nové Zámky',            'NI'],
    43 => ['Partizánske',           'TC'],
    44 => ['Pezinok',               'BL'],
    45 => ['Piešťany',              'TA'],
    46 => ['Poltár',                'BC'],
    47 => ['Poprad',                'PV'],
    48 => ['Považská Bystrica',     'TC'],
    49 => ['Prešov',                'PV'],
    50 => ['Prievidza',             'TC'],
    51 => ['Púchov',                'TC'],
    52 => ['Revúca',                'BC'],
    53 => ['Rimavská Sobota',       'BC'],
    54 => ['Rožňava',               'KI'],
    55 => ['Ružomberok',            'ZI'],
    56 => ['Sabinov',               'PV'],
    57 => ['Senec',                 'BL'],
    58 => ['Senica',                'TA'],
    59 => ['Skalica',               'TA'],
    60 => ['Snina',                 'PV'],
    61 => ['Sobrance',              'KI'],
    62 => ['Spišská Nová Ves',      'KI'],
    63 => ['Spišská Stará Ves',     'PV'],
    64 => ['Stará Ľubovňa',         'PV'],
    65 => ['Stropkov',              'PV'],
    66 => ['Šaľa',                  'NI'],
    67 => ['Topoľčany',             'NI'],
    68 => ['Trebišov',              'KI'],
    69 => ['Trenčín',               'TC'],
    70 => ['Trnava',                'TA'],
    71 => ['Turčianske Teplice',    'ZI'],
    72 => ['Tvrdošín',              'ZI'],
    73 => ['Veľký Krtíš',           'BC'],
    74 => ['Vranov nad Topľou',     'PV'],
    75 => ['Zlaté Moravce',         'NI'],
    76 => ['Zvolen',                'BC'],
    77 => ['Žarnovica',             'BC'],
    78 => ['Žiar nad Hronom',       'BC'],
    79 => ['Žilina',                'ZI'],
];

// ── Oprava chýbajúcich okresov v DB ─────────────────────────────────
$allDistricts = array_unique(array_column(array_values($districtMap), 0));
$stmt = $pdo->prepare(
    "INSERT IGNORE INTO codebook_districts (name, region_code, sort_order)
     VALUES (:name, :region, :sort)"
);
foreach ($districtMap as $id => [$dName, $rCode]) {
    $stmt->execute(['name' => $dName, 'region' => $rCode, 'sort' => $id * 10]);
}
echo "Okresy synchronizované.\n";

// ── Vymazanie starých dát a import nových ───────────────────────────
$pdo->exec("TRUNCATE TABLE codebook_municipalities");
echo "Tabuľka codebook_municipalities vyprázdnená.\n";

$insertStmt = $pdo->prepare(
    "INSERT INTO codebook_municipalities (name, district_name, region_code, zip_code, sort_order)
     VALUES (:name, :district, :region, :zip, :sort)"
);

$inserted = 0;
$skipped  = 0;
$errors   = 0;

$pdo->beginTransaction();

foreach ($lines as $i => $line) {
    $line = trim($line);
    if ($line === '') continue;

    // Formát: id, name, name_ascii, zip, district_id, region_id
    $parts = str_getcsv($line);
    if (count($parts) < 5) {
        echo "PRESKOČENÝ (krátky): $line\n";
        $skipped++;
        continue;
    }

    $name       = trim($parts[1]);
    $zipRaw     = trim($parts[3]); // napr. "985 13"
    $zip        = preg_replace('/\s+/', '', $zipRaw); // "98513"
    $districtId = (int) trim($parts[4]);

    if ($name === '' || strlen($zip) < 5 || !isset($districtMap[$districtId])) {
        $skipped++;
        continue;
    }

    // Berieme len prvých 5 číslic PSČ
    $zip = substr($zip, 0, 5);

    [$districtName, $regionCode] = $districtMap[$districtId];

    try {
        $insertStmt->execute([
            'name'     => $name,
            'district' => $districtName,
            'region'   => $regionCode,
            'zip'      => $zip,
            'sort'     => $i + 1,
        ]);
        $inserted++;
    } catch (\PDOException $e) {
        // Duplicita meno+okres — preskočíme
        if ((string) $e->getCode() === '23000') {
            $skipped++;
        } else {
            echo "CHYBA [{$name}]: " . $e->getMessage() . "\n";
            $errors++;
        }
    }
}

$pdo->commit();

echo "\nImport dokončený:\n";
echo "  Vložených:  $inserted\n";
echo "  Preskočených: $skipped\n";
echo "  Chýb:      $errors\n";
echo "  Celkový počet v DB: ";
echo $pdo->query("SELECT COUNT(*) FROM codebook_municipalities")->fetchColumn() . "\n";
?>
