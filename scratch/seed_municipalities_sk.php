<?php
/**
 * Seed skript pre import obcí Slovenskej republiky do tabuľky codebook_municipalities.
 * Spúšťa sa iba cez CLI: php seed_municipalities_sk.php
 *
 * Zdroj dát: Štatistický úrad SR – Register obcí
 * Formát: INSERT IGNORE (bezpečné opakované spustenie)
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý. Spúšťajte iba cez CLI: php seed_municipalities_sk.php\n");
}

require_once __DIR__ . '/db_config.php';

// Pole: [názov obce, názov okresu, kód kraja, PSČ]
$municipalities = [
    // ── Bratislavský kraj (BL) ────────────────────────────────────────
    ['Bratislava - Staré Mesto',    'Bratislava I',   'BL', '81101'],
    ['Bratislava - Ružinov',        'Bratislava II',  'BL', '82101'],
    ['Bratislava - Nové Mesto',     'Bratislava III', 'BL', '83101'],
    ['Bratislava - Karlova Ves',    'Bratislava IV',  'BL', '84104'],
    ['Bratislava - Petržalka',      'Bratislava V',   'BL', '85101'],
    ['Bratislava - Dúbravka',       'Bratislava IV',  'BL', '84101'],
    ['Bratislava - Rača',           'Bratislava III', 'BL', '83106'],
    ['Bratislava - Vajnory',        'Bratislava III', 'BL', '83107'],
    ['Bratislava - Vrakuňa',        'Bratislava II',  'BL', '82107'],
    ['Bratislava - Podunajské Biskupice', 'Bratislava II', 'BL', '82107'],
    ['Bratislava - Devín',          'Bratislava IV',  'BL', '84110'],
    ['Bratislava - Záhorská Bystrica', 'Bratislava IV', 'BL', '84106'],
    ['Bratislava - Lamač',          'Bratislava IV',  'BL', '84103'],
    ['Bratislava - Devínska Nová Ves', 'Bratislava IV', 'BL', '84107'],
    ['Malacky',     'Malacky', 'BL', '90101'],
    ['Stupava',     'Malacky', 'BL', '90031'],
    ['Záhorská Ves','Malacky', 'BL', '90065'],
    ['Zohor',       'Malacky', 'BL', '90051'],
    ['Pezinok',     'Pezinok', 'BL', '90201'],
    ['Modra',       'Pezinok', 'BL', '90001'],
    ['Svätý Jur',   'Pezinok', 'BL', '90021'],
    ['Vinosady',    'Pezinok', 'BL', '90227'],
    ['Senec',       'Senec',   'BL', '90301'],
    ['Bernolákovo', 'Senec',   'BL', '90027'],
    ['Chorvátsky Grob', 'Senec', 'BL', '90025'],
    ['Šamorín',     'Senec',   'BL', '93101'],

    // ── Trnavský kraj (TA) ────────────────────────────────────────────
    ['Trnava',           'Trnava',           'TA', '91701'],
    ['Dunajská Streda',  'Dunajská Streda',  'TA', '92901'],
    ['Galanta',          'Galanta',          'TA', '92401'],
    ['Šaľa',             'Šaľa',             'NI', '92701'],
    ['Hlohovec',         'Hlohovec',         'TA', '92001'],
    ['Leopoldov',        'Hlohovec',         'TA', '92035'],
    ['Piešťany',         'Piešťany',         'TA', '92101'],
    ['Vrbové',           'Piešťany',         'TA', '92203'],
    ['Senica',           'Senica',           'TA', '90501'],
    ['Gbely',            'Senica',           'TA', '90845'],
    ['Holíč',            'Senica',           'TA', '90851'],
    ['Skalica',          'Skalica',          'TA', '90901'],
    ['Radošovce',        'Skalica',          'TA', '90946'],

    // ── Trenčiansky kraj (TC) ─────────────────────────────────────────
    ['Trenčín',               'Trenčín',               'TC', '91101'],
    ['Bánovce nad Bebravou',  'Bánovce nad Bebravou',  'TC', '95701'],
    ['Partizánske',           'Partizánske',           'TC', '95801'],
    ['Ilava',                 'Ilava',                 'TC', '01901'],
    ['Dubnica nad Váhom',     'Ilava',                 'TC', '01841'],
    ['Nová Dubnica',          'Ilava',                 'TC', '01851'],
    ['Myjava',                'Myjava',                'TC', '90701'],
    ['Nové Mesto nad Váhom',  'Nové Mesto nad Váhom',  'TC', '91501'],
    ['Stará Turá',            'Nové Mesto nad Váhom',  'TC', '91601'],
    ['Považská Bystrica',     'Považská Bystrica',     'TC', '01701'],
    ['Púchov',                'Púchov',                'TC', '02001'],
    ['Ladce',                 'Púchov',                'TC', '01863'],

    // ── Nitriansky kraj (NI) ──────────────────────────────────────────
    ['Nitra',           'Nitra',           'NI', '94901'],
    ['Komárno',         'Komárno',         'NI', '94501'],
    ['Levice',          'Levice',          'NI', '93401'],
    ['Štúrovo',         'Nové Zámky',      'NI', '94301'],
    ['Nové Zámky',      'Nové Zámky',      'NI', '94001'],
    ['Hurbanovo',       'Komárno',         'NI', '94735'],
    ['Topoľčany',       'Topoľčany',       'NI', '95501'],
    ['Zlaté Moravce',   'Zlaté Moravce',   'NI', '95301'],
    ['Vráble',          'Nitra',           'NI', '95112'],

    // ── Žilinský kraj (ZI) ────────────────────────────────────────────
    ['Žilina',              'Žilina',              'ZI', '01001'],
    ['Martin',              'Martin',              'ZI', '03601'],
    ['Liptovský Mikuláš',   'Liptovský Mikuláš',   'ZI', '03101'],
    ['Ružomberok',          'Ružomberok',          'ZI', '03401'],
    ['Čadca',               'Čadca',               'ZI', '02201'],
    ['Kysucké Nové Mesto',  'Kysucké Nové Mesto',  'ZI', '02401'],
    ['Bytča',               'Bytča',               'ZI', '01401'],
    ['Dolný Kubín',         'Dolný Kubín',         'ZI', '02601'],
    ['Námestovo',           'Námestovo',           'ZI', '02901'],
    ['Tvrdošín',            'Tvrdošín',            'ZI', '02744'],
    ['Turčianske Teplice',  'Turčianske Teplice',  'ZI', '03801'],
    ['Trstená',             'Tvrdošín',            'ZI', '02701'],
    ['Liptovský Hrádok',    'Liptovský Mikuláš',   'ZI', '03354'],

    // ── Banskobystrický kraj (BC) ─────────────────────────────────────
    ['Banská Bystrica',  'Banská Bystrica',  'BC', '97401'],
    ['Zvolen',           'Zvolen',           'BC', '96001'],
    ['Lučenec',          'Lučenec',          'BC', '98401'],
    ['Brezno',           'Brezno',           'BC', '97701'],
    ['Rimavská Sobota',  'Rimavská Sobota',  'BC', '97901'],
    ['Žiar nad Hronom',  'Žiar nad Hronom',  'BC', '96501'],
    ['Detva',            'Detva',            'BC', '96212'],
    ['Revúca',           'Revúca',           'BC', '05001'],
    ['Krupina',          'Krupina',          'BC', '96301'],
    ['Poltár',           'Poltár',           'BC', '98701'],
    ['Veľký Krtíš',      'Veľký Krtíš',      'BC', '99001'],
    ['Banská Štiavnica', 'Banská Štiavnica', 'BC', '96901'],
    ['Žarnovica',        'Žarnovica',        'BC', '96681'],
    ['Fiľakovo',         'Lučenec',          'BC', '98604'],

    // ── Prešovský kraj (PV) ───────────────────────────────────────────
    ['Prešov',           'Prešov',           'PV', '08001'],
    ['Poprad',           'Poprad',           'PV', '05801'],
    ['Bardejov',         'Bardejov',         'PV', '08501'],
    ['Humenné',          'Humenné',          'PV', '06601'],
    ['Michalovce',       'Michalovce',       'KI', '07101'],
    ['Kežmarok',         'Kežmarok',         'PV', '06001'],
    ['Levoča',           'Levoča',           'PV', '05401'],
    ['Spišská Nová Ves', 'Spišská Nová Ves', 'KI', '05201'],
    ['Stará Ľubovňa',    'Stará Ľubovňa',    'PV', '06401'],
    ['Vranov nad Topľou','Vranov nad Topľou', 'PV', '09301'],
    ['Snina',            'Snina',            'PV', '06901'],
    ['Sabinov',          'Sabinov',          'PV', '08301'],
    ['Stropkov',         'Stropkov',         'PV', '09101'],
    ['Medzilaborce',     'Medzilaborce',     'PV', '06801'],
    ['Spišská Stará Ves','Spišská Stará Ves','PV', '06101'],
    ['Lipany',           'Sabinov',          'PV', '08271'],
    ['Svit',             'Poprad',           'PV', '05921'],
    ['Vysoké Tatry',     'Poprad',           'PV', '06201'],

    // ── Košický kraj (KI) ─────────────────────────────────────────────
    ['Košice',           'Košice I',         'KI', '04001'],
    ['Košice - Staré Mesto', 'Košice I',     'KI', '04001'],
    ['Košice - Západ',   'Košice II',        'KI', '04023'],
    ['Košice - Sever',   'Košice III',       'KI', '04011'],
    ['Košice - Juh',     'Košice IV',        'KI', '04013'],
    ['Rožňava',          'Rožňava',          'KI', '04801'],
    ['Trebišov',         'Trebišov',         'KI', '07501'],
    ['Gelnica',          'Gelnica',          'KI', '05601'],
    ['Sobrance',         'Sobrance',         'KI', '07301'],
    ['Spišská Nová Ves', 'Spišská Nová Ves', 'KI', '05201'],
    ['Moldava nad Bodvou','Košice-okolie',   'KI', '04501'],
    ['Strážske',         'Michalovce',       'KI', '07222'],
];

$inserted = 0;
$skipped  = 0;
$errors   = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO codebook_municipalities (name, district_name, region_code, zip_code, sort_order)
     VALUES (:name, :district, :region, :zip, :sort)"
);

foreach ($municipalities as $i => $m) {
    try {
        $stmt->execute([
            'name'     => $m[0],
            'district' => $m[1],
            'region'   => $m[2],
            'zip'      => $m[3],
            'sort'     => $i + 1,
        ]);
        if ($stmt->rowCount() > 0) {
            $inserted++;
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        echo "CHYBA [{$m[0]}]: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "Import dokončený:\n";
echo "  Vložených: $inserted\n";
echo "  Preskočených (duplicity): $skipped\n";
echo "  Chýb: $errors\n";
echo "  Celkový počet obcí v DB: ";
echo $pdo->query("SELECT COUNT(*) FROM codebook_municipalities")->fetchColumn() . "\n";
?>
