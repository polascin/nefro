<?php

declare(strict_types=1);
/**
 * add_providers_seed_referral.php
 * Naplnenie partner_providers sieťou odporúčateľov z master dokumentu
 * (Littlebird, stav 30.6.2026; zdroj e-VÚC + katalógy). Idempotentné:
 * vkladá len ak názov ešte neexistuje → opakované spustenie nevytvorí duplikáty
 * ani neprepíše ručné úpravy v admin_providers.php.
 *
 * Pozn.: e-maily z oficiálnych stránok subjektov sú spoľahlivé; e-maily z katalógov
 * majú v poznámke „overiť“. Čisté dialyzačné konkurencie (B. Braun Avitum, KMI, FMC)
 * do siete odporúčateľov nezaraďujeme; Nemocnica Bory je uvedená kvôli jej internistom/
 * VLD/špecialistom (nie kvôli dialýze) — s poznámkou.
 *
 * Spustenie: php add_providers_seed_referral.php  (CLI/SSH) alebo admin v prehliadači.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť sieť odporúčateľov');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$SRC = 'master dokument (Littlebird) / e-VÚC, 2026-06-30';

/** Skratky lokalít. */
$DUB = 'Bratislava-Dúbravka';
$KV  = 'Bratislava-Karlova Ves';
$LAM = 'Bratislava-Lamač';
$DNV = 'Bratislava-Devínska Nová Ves';
$ZB  = 'Bratislava-Záhorská Bystrica';

$seed = [
    // ── VLD (všeobecní lekári pre dospelých) ─────────────────────────────────
    ['Ambulancia Dúbravka, s.r.o. (MUDr. Ruth Tomas Poláková)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'Dúbravka', null, null, null],
    ['SA-FE AMBULANCIA, s.r.o. (MUDr. Eva Fellnerová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'ZS Paracelsus, M. Sch. Trnavského 1825/8', '02/642 87 956', 'safe.ambulancia@gmail.com', null],
    ['MENDELSANA s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'ZS Paracelsus, M. Sch. Trnavského 1825/8', '0911 111 038', 'mendelsana@mendelsana.sk', null],
    ['Care Med, s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'Saratovská 2141/26', null, null, null],
    ['AVE VITA, s.r.o. (MUDr. Beata Maníková)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'Saratovská 24', null, null, null],
    ['MEDIRA s.r.o. (MUDr. Veronika Lackovičová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'ZS Saratovská', null, null, null],
    ['LH med s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $DUB, 'Dúbravka', null, null, null],
    ['DARAMED s.r.o. (MUDr. Darina Gajdošová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Dúbravská cesta 9', null, null, null],
    ['STAMED, s.r.o. (MUDr. Zimanová)', 'vseobecny_lekar', 'všeobecné lekárstvo, reumatológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', null, 'dr.zimanova@gmail.com', 'Ďalší e-mail: lekarka.karlovka@gmail.com. E-mail z katalógu — overiť.'],
    ['MiriaMed s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', null, null, null],
    ['MEDICUS PARTNERS, s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', null, null, null],
    ['DAMED s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Poliklinika Karlova Ves', null, null, null],
    ['MUDr. Silvia Sýkorová, s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Staré Grunty 5913/53', null, null, null],
    ['Medicínske zariadenie Mlynská dolina', 'vseobecny_lekar', 'všeobecné lekárstvo', $KV, 'Staré Grunty 56', null, null, null],
    ['STANMED s.r.o. (MUDr. Sabina Stankovičová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $LAM, 'Malokarpatské nám. 1124/2', null, null, null],
    ['PRO SANUS, a.s. (MUDr. Daniel Hassan, MUDr. Magdaléna Pažitná)', 'vseobecny_lekar', 'všeobecné lekárstvo', $LAM, 'Bory Mall, Lamačská cesta 6780', '0907 888 999', 'info@procare.sk', 'ProCare/PRO SANUS Bory.'],
    ['DAHAMED, s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $LAM, 'ZS Lamač', null, null, null],
    ['Všeobecný lekár DNV, s.r.o. (MUDr. Martina Rutaiová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DNV, 'Istrijská 8B', null, null, null],
    ['FaMa Med s.r.o. (MUDr. Jaroslava Sojková)', 'vseobecny_lekar', 'všeobecné lekárstvo', $DNV, 'ZS Pavla Horova 6147/14', '0948 205 106', null, 'E-mail nenájdený — volať.'],
    ['MEDIVITAL s.r.o.', 'vseobecny_lekar', 'všeobecné lekárstvo', $DNV, 'ZS Pavla Horova 6147/14', null, null, null],
    ['Euromedix, a.s.', 'vseobecny_lekar', 'všeobecné lekárstvo', $DNV, 'Poliklinika Jána Jonáša', null, null, null],
    ['STANMED s.r.o. (MUDr. Alžbeta Olexová)', 'vseobecny_lekar', 'všeobecné lekárstvo', $ZB, 'Záhorská Bystrica', null, null, null],

    // ── Diabetológovia ───────────────────────────────────────────────────────
    ['Diacrin (MUDr. Eva Žákovičová, PhD.)', 'specialista', 'diabetológia', $DUB, 'Poliklinika Saratovská 24', null, 'diacrin12@gmail.com', 'Ďalší e-mail: evazak07@gmail.com. E-mail z katalógu — overiť.'],
    ['MUDr. Peter Habán, CSc. (diabetológ)', 'specialista', 'diabetológia', $DUB, 'Poliklinika Saratovská 24', null, null, null],
    ['MUDr. Roman Žák, PhD. (diabetológ)', 'specialista', 'diabetológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', null, null, null],
    ['MUDr. Danica Malíčková (diabetológ)', 'specialista', 'diabetológia', $KV, 'Mlynská dolina, Staré Grunty 56', null, null, null],
    ['MUDr. Ingrid Jurkovičová, PhD. (diabetológ)', 'specialista', 'diabetológia', $KV, 'Mlynská dolina, Staré Grunty 56', null, null, null],
    ['doc. MUDr. Boris Krahulec, CSc. (diabetológ)', 'specialista', 'diabetológia', $KV, 'Pavilón lek. vied SAV, Dúbravská cesta 9', null, null, null],

    // ── Kardiológovia ────────────────────────────────────────────────────────
    ['INTERNA-MED s.r.o. (MUDr. Milan Ševčík)', 'specialista', 'kardiológia, interná medicína', $DUB, 'ZS Paracelsus, M. Sch. Trnavského 1825/8', '0907 628 930', 'info@internamed.sk', 'Ďalší e-mail: M.sevcik@internamed.sk.'],
    ['VERIA, s.r.o. (MUDr. Ivan Matejčík, kardiológ)', 'specialista', 'kardiológia', $DUB, 'Poliklinika Saratov, Saratovská 24', '02/638 123 04', 'veria.ambulancia@gmail.com', 'E-mail z katalógu — overiť.'],
    ['MUDr. Eva Bischerová (kardiológ)', 'specialista', 'kardiológia', $DUB, 'Poliklinika Saratov, Saratovská 24', null, null, null],
    ['MUDr. Koloman Žiška (kardiológ)', 'specialista', 'kardiológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, null],
    ['MUDr. Peter Kalist (kardiológ)', 'specialista', 'kardiológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, null],
    ['MUDr. Ivana Soóšová (kardiológ)', 'specialista', 'kardiológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, null],
    ['MARKOMEDIK, s.r.o. (kardiológia)', 'specialista', 'kardiológia', $KV, 'Líščie údolie 57', null, null, null],
    ['Kardiovita s.r.o.', 'specialista', 'kardiológia', $KV, 'Líščie údolie 57', null, null, null],
    ['KARDIO-SANUS, s.r.o. (MUDr. Jaroslava Štrbová)', 'specialista', 'kardiológia', $DNV, 'Poliklinika DNV, Opletalova', '0911 626 902', 'kardiosanus@kardiosanus.sk', null],

    // ── Internisti ───────────────────────────────────────────────────────────
    ['MUDr. Oľga Rabenseiferová (internista)', 'specialista', 'interná medicína', $DUB, 'ZS Paracelsus', null, null, null],
    ['In Clinic s.r.o. (interná)', 'specialista', 'interná medicína', $DUB, 'Poliklinika Saratov, Saratovská 24', '02/63 53 10 13', 'janekova@inclinic.sk', 'E-mail z katalógu — overiť.'],
    ['LION-MED s.r.o. (interná + angiológia)', 'specialista', 'interná medicína, angiológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', '0905 827 222', 'lekar@lionmed.sk', 'Ďalší e-mail: ambulancia@lionmed.sk. Angiológ MUDr. Ľubomíra Javorčíková.'],
    ['MUDr. Denisa Holzerová (internista)', 'specialista', 'interná medicína', $KV, 'Poliklinika Karlova Ves', null, null, null],
    ['MUDr. Jaroslava Richterová (internista)', 'specialista', 'interná medicína', $KV, 'Líščie údolie 57', null, null, null],
    ['PANAKEIA, s.r.o. (MUDr. Jaroslava Schichorová)', 'specialista', 'geriatria, interná medicína', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', '02/6541 2266', null, 'E-mail nenájdený — volať.'],
    ['MM AMBULANCIA, s.r.o.', 'specialista', 'interná medicína', $KV, 'Hany Meličkovej 11, Dlhé Diely', null, null, null],

    // ── Urológia ─────────────────────────────────────────────────────────────
    ['MILUMED s.r.o. (urológia)', 'specialista', 'urológia', $DUB, 'M. Sch. Trnavského 1825/8', '0948 487 030', 'urodoktor1@gmail.com', null],
    ['MUDr. Juraj Brutenič (BB Medical, urológ)', 'specialista', 'urológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, null],
    ['MUDr. Zuzana Seresová, PhD. (urológ)', 'specialista', 'urológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, null],

    // ── Nefrológia (možní partneri) ──────────────────────────────────────────
    ['MUDr. Mahmoud Hassan (nefrológ, Klinika MD)', 'specialista', 'nefrológia', $KV, 'Staré Grunty 56', null, null, null],
    ['MUDr. Juraj Magyarics (nefrológ)', 'specialista', 'nefrológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 57', null, null, 'Náš lekár (nie konkurencia).'],

    // ── Reumatológia / angiológia ────────────────────────────────────────────
    ['MUDr. Andrea Škublová (Fidelitas, reumatológia)', 'specialista', 'reumatológia', $KV, 'Poliklinika Karlova Ves, Líščie údolie 98/57', null, null, null],

    // ── Polikliniky / kliniky / nemocnice (referral-relevantné) ──────────────
    ['Poliklinika Karlova Ves (správa)', 'poliklinika', 'poliklinika', $KV, 'Líščie údolie 98/57', '02/602 64 378', 'sekretariat@poliklinikakv.sk', null],
    ['Klinika Mlynská dolina', 'poliklinika', 'interná, kardiológia, nefrológia', $KV, 'Staré Grunty 56', '02/3231 3020', 'recepcia@klinikamd.sk', 'Ďalší e-mail: riaditel@klinikamd.sk.'],
    ['Nemocnica Bory, a.s.', 'nemocnica', 'všeobecná nemocnica (interná, diabetológia, urológia, geriatria)', $LAM, 'Ul. I. Kadlečíka 6851/2', '0911 186 373', 'zuzana.kacur@pentahospitals.com', 'POZOR: v dialýze konkurencia — oslovovať cez internistov/VLD/špecialistov, nie cez dialýzu.'],

    // ── DSS a zariadenia pre seniorov (zvozoví pacienti) ─────────────────────
    ['Domov pri kríži', 'socialna_sluzba', 'zariadenie pre seniorov', $DUB, 'Pri kríži 26', '02/6428 3259', 'domov@domovprikrizi.sk', 'Zriaďovateľ: Mesto BA.'],
    ['CSS Náruč', 'socialna_sluzba', 'zariadenie pre seniorov', $DUB, 'Fedákova 5', '0903 903 298', 'naruczachrany@naruczachrany.sk', null],
    ['Domov jesene života', 'socialna_sluzba', 'zariadenie pre seniorov', $DUB, 'Hanulova 7/A', '02/6010 1411', 'info@djzhanulova.sk', 'Zriaďovateľ: Mesto BA.'],
    ['HESTIA n.o.', 'socialna_sluzba', 'zariadenie pre seniorov', $DUB, 'Bošániho 1805/2', '0911 194 449', 'hestia@hestia.sk', 'Ďalší e-mail: katarina.simkovicova@hestia.sk.'],
    ['Dúbravská oáza', 'socialna_sluzba', 'zariadenie pre seniorov', $DUB, 'Plachého 3640/1D', '02/4363 9682', 'jakubcik@dubravskaoaza.sk', null],
    ['GERION Karlova Ves', 'socialna_sluzba', 'zariadenie pre seniorov', $KV, 'Borská 694/2', '02/2073 8500', 'karlovka@gerion.sk', null],
    ['Domov seniorov Lamač', 'socialna_sluzba', 'zariadenie pre seniorov', $LAM, 'Na barine 5', '02/6478 1054', 'riaditel@dslamac.sk', 'Ďalší e-mail: dslamac@gmail.com. Zriaďovateľ: Mesto BA.'],
    ['DSS Senecio', 'socialna_sluzba', 'zariadenie pre seniorov', $DNV, 'Na Grbe 6195/2', '0948 133 466', 'senecio@senecio.sk', 'Ďalší e-mail: riaditel@senecio.sk.'],
    ['ŠZ GERION Záhorská Bystrica', 'socialna_sluzba', 'zariadenie pre seniorov', $ZB, 'Nám. Rodiny 7397/1', null, null, null],
    ['Kaštieľ Stupava', 'socialna_sluzba', 'zariadenie pre seniorov', 'Stupava', 'Hlavná 13', null, null, 'Zriaďovateľ: BSK.'],
];

$checkStmt = $pdo->prepare('SELECT id FROM partner_providers WHERE name = :name LIMIT 1');
$insStmt   = $pdo->prepare(
    'INSERT INTO partner_providers
        (name, provider_type, specialization, locality, address, phone, email, notes, source, is_active)
     VALUES
        (:name, :provider_type, :specialization, :locality, :address, :phone, :email, :notes, :source, 1)'
);

$inserted = 0;
$skipped  = 0;
foreach ($seed as $r) {
    [$name, $type, $spec, $locality, $address, $phone, $email, $notes] = $r;
    $checkStmt->execute(['name' => $name]);
    if ($checkStmt->fetchColumn() !== false) {
        $skipped++;
        continue;
    }
    $insStmt->execute([
        'name'           => $name,
        'provider_type'  => $type,
        'specialization' => $spec,
        'locality'       => $locality,
        'address'        => $address,
        'phone'          => $phone,
        'email'          => $email,
        'notes'          => $notes,
        'source'         => $SRC,
    ]);
    $inserted++;
}

echo "Seed siete odporúčateľov: vložených {$inserted}, preskočených (už existujú) {$skipped}." . PHP_EOL;
