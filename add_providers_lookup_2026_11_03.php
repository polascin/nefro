<?php

declare(strict_types=1);
/**
 * add_providers_lookup_2026_11_03.php
 * Doplnenie chýbajúcich údajov (IČO, telefón, e-mail, adresa, kontaktná osoba)
 * pri odporúčateľoch, ktorí nie sú v zozname e-VÚC z 1. 11. 2026, podľa
 * verejných zdrojov dohľadaných 3. 11. 2026 (weby poskytovateľov, e-VÚC,
 * ORSR/FinStat, registre sociálnych služieb). Zdroj každého údaju je v poznámke.
 *
 * Zapisuje len do prázdnych polí (ručné úpravy ostávajú); vedomé prepisy sú
 * v kľúči `force` so zdôvodnením v poznámke. Poznámka a zdroj sa pripájajú
 * idempotentne (kontrola podreťazca).
 *
 * Spustenie: php add_providers_lookup_2026_11_03.php [--dry-run]
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Doplniť dohľadané údaje odporúčateľov (2026-11-03)');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$dryRun = in_array('--dry-run', $argv ?? [], true);
$SRCTAG = 'verejné zdroje 2026-11-03';

// id => ['expect' => začiatok názvu, polia..., 'force' => [...], 'note' => '...']
$updates = [
// ── Zariadenia sociálnych služieb (IČO: Register účtovných závierok, weby zariadení) ──
    58 => ['expect' => 'Domov pri kríži', 'ico' => '00641405', 'website' => 'https://www.domovprikrizi.sk/',
        'force' => ['address' => 'Pri kríži 3082/26, 841 02 Bratislava-Dúbravka'],
        'note' => 'RegisterUZ 2026-11-03: rozpočtová organizácia hl. mesta, IČO 00641405. Ďalší e-mail: info@domovprikrizi.sk (domovprikrizi.sk/kontakty).'],
    59 => ['expect' => 'CSS Náruč', 'ico' => '30856515',
        'force' => ['address' => 'Fedákova 1944/5, 841 02 Bratislava-Dúbravka'],
        'note' => 'RegisterUZ 2026-11-03: prevádzkovateľ NÁRUČ Senior & Junior, občianske združenie, IČO 30856515.'],
    60 => ['expect' => 'Domov jesene života', 'ico' => '00490873',
        'force' => ['address' => 'Hanulova 1993/7A, 844 01 Bratislava-Dúbravka'],
        'note' => 'RegisterUZ 2026-11-03: rozpočtová organizácia, IČO 00490873; web djzhanulova.sk bez obsahu.'],
    61 => ['expect' => 'HESTIA', 'ico' => '36077313', 'website' => 'https://www.hestia.sk/',
        'force' => ['address' => 'Bošániho 1805/2, 841 02 Bratislava-Dúbravka'],
        'note' => 'hestia.sk/kontakt 2026-11-03: IČO 36077313, pevná linka +421 2 6446 3485.'],
    62 => ['expect' => 'Dúbravská oáza', 'ico' => '45747431', 'website' => 'https://www.dubravskaoaza.sk/',
        'force' => ['address' => 'Plachého 3640/1D, 841 02 Bratislava-Dúbravka'],
        'note' => 'RegisterUZ 2026-11-03: prevádzkovateľ Dúbravská oáza pokoja a oddychu n.o., IČO 45747431. Všeobecný e-mail: info@dubravskaoaza.sk.'],
    63 => ['expect' => 'GERION Karlova Ves', 'ico' => '56676590', 'website' => 'https://www.gerion.sk/',
        'contact_person' => 'Mgr. Roman Križan, riaditeľ',
        'force' => ['address' => 'Borská 694/2, 841 04 Bratislava-Karlova Ves'],
        'note' => 'RegisterUZ a výročná správa 2025 (gerion.sk) 2026-11-03: samostatná právnická osoba GERION - Karlova Ves, IČO 56676590 (nie Združenie GERION); ZpS 39 miest, prevádzka od júna 2025; riaditeľ +421 903 788 829.'],
    64 => ['expect' => 'Domov seniorov Lamač', 'ico' => '00896276',
        'force' => ['address' => 'Na barine 2976/5, 841 03 Bratislava-Lamač'],
        'note' => 'RegisterUZ 2026-11-03: IČO 00896276.'],
    65 => ['expect' => 'DSS Senecio', 'ico' => '36077518', 'website' => 'https://www.senecio.sk/',
        'force' => ['address' => 'Na Grbe 6195/2, 841 07 Bratislava-Devínska Nová Ves'],
        'note' => 'senecio.sk a RegisterUZ 2026-11-03: Dom sociálnych služieb Senecio, n.o., IČO 36077518; pevná linka +421 2 604 21 261.'],
    66 => ['expect' => 'ŠZ GERION Záhorská Bystrica', 'ico' => '37999958', 'phone' => '+421 2 4552 9811', 'website' => 'https://www.gerion.sk/',
        'contact_person' => 'Mgr. Tomáš Lendel, riaditeľ',
        'force' => ['address' => 'Námestie rodiny 7397/1, 841 06 Bratislava-Záhorská Bystrica'],
        'note' => 'gerion.sk/kontakt a CRZ 2026-11-03: prevádzkovateľ Združenie GERION, IČO 37999958, sídlo Tešedíkova 8470/91A; recepcia +421 2 4552 9811, riaditeľ +421 911 70 70 60, e-mail gerionsk@gmail.com.'],
    67 => ['expect' => 'Kaštieľ Stupava', 'ico' => '00364193', 'website' => 'https://www.ddstupava.eu.sk/',
        'note' => 'RegisterUZ 2026-11-03: Domov sociálnych služieb a zariadenie pre seniorov Kaštieľ, IČO 00364193, rozpočtová organizácia BSK.'],
// ── Mlynská dolina, ProCare, Rovinka ──
    30 => ['expect' => 'MUDr. Danica Malíčková', 'phone' => '+421 2 323 13 030', 'email' => 'recepcia@klinikamd.sk', 'website' => 'https://www.klinikamd.sk/sk/ambulancie/diabetologicka-ambulancia',
        'force' => ['address' => 'Klinika Mlynská dolina, Staré Grunty 56, 3. NP, m. č. 309, 841 04 Bratislava-Karlova Ves'],
        'note' => 'klinikamd.sk a e-VÚC 2026-11-03: lekárka potvrdená (objednávací systém uvádza aj MUDr. Jelínkovú a Pogorelovú); priama linka ambulancie nie je zverejnená, telefón je linka z e-VÚC (ordinačné hodiny od 15. 7. 2026), e-mail recepcia.'],
    31 => ['expect' => 'MUDr. Ingrid Jurkovičová', 'phone' => '+421 2 323 13 030', 'email' => 'recepcia@klinikamd.sk',
        'note' => 'klinikamd.sk, objednávací systém ani e-VÚC 2026-11-03 lekárku na Klinike Mlynská dolina NEUVÁDZAJÚ (zoznam lekárov vracia 404); pôsobenie neoverené, pred oslovením overiť telefonicky na recepcii.'],
    37 => ['expect' => 'MUDr. Peter Kalist', 'ico' => '35946792', 'email' => 'info@procare.sk', 'website' => 'https://pentahospitals.sk/ambulancia/kardiologicka-ambulancia-procare-betliarska/',
        'contact_person' => 'MUDr. Peter Kalist, MPH',
        'note' => 'pentahospitals.sk, ORSR a e-VÚC 2026-11-03: prevádzkovateľ Euromedix, a.s., IČO 35946792 (ProCare); záznam 61-35946792-A0045, sestra Bc. Dominika Wittenbergerová; po a ut 7:30 až 12:00 a 12:30 až 18:30; telefóny sú call centrum ProCare (02/3232 3838, 0907 888 999), e-mail len všeobecný.'],
    25 => ['expect' => 'Euromedix', 'ico' => '35946792', 'website' => 'https://pentahospitals.sk/poliklinika/procare-devinska-nova-ves/',
        'contact_person' => 'doc. MUDr. Štefánia Moricová, PhD.; MUDr. Barbora Lőrincz, MPH',
        'force' => ['address' => 'Poliklinika ProCare Devínska Nová Ves, Jána Jonáša 6889/1,3, 841 08 Bratislava-Devínska Nová Ves'],
        'note' => 'ORSR a e-VÚC 2026-11-03: Euromedix, a.s., IČO 35946792, sídlo Einsteinova 25 (skupina ProCare); všeobecné ambulancie 61-35946792-A0085 (Moricová, Lőrincz, hodiny od 3. 4. 2026) a A0086; v DNV aj kardiológia A0092; telefóny len call centrum (0850 888 999, 0907 888 999), e-mail info@procare.sk.'],
    68 => ['expect' => 'Diabetologická ambulancia MUDr. Miriam Adamovičová', 'ico' => '31386563', 'website' => 'https://nemocnicamilosrdni.agel.sk/zoznam-ambulancii/ambulancia-diabetologie-a-poruch-latkovej-premeny-a-vyzivy-3/',
        'force' => ['address' => 'Zdravotné stredisko Rovinka, Hlavná 209/104B, prízemie, dvere 2, 900 41 Rovinka'],
        'note' => 'ORSR, agel.sk a e-VÚC 2026-11-03: prevádzkovateľ Univerzitná nemocnica AGEL Milosrdní bratia s. r. o., IČO 31386563 (premenovaná 17. 4. 2026); záznam 61-31386563-A0077, sestra Ľudmila Sláviková, tel. aj +421 2 578 87 100; aktuálny e-mail recepciamb@careservices.sk, pôvodný diabet.mbrovinka@milosrdni.sk už nie je zverejnený; po 7:00 až 15:30, ut a št 7:00 až 16:30, pi 7:00 až 13:30.'],
// ── Dúbravka (e-VÚC, ORSR, RPO, weby; katalógy označené) ──
    27 => ['expect' => 'Diacrin', 'ico' => '47898551', 'phone' => '+421 915 311 689', 'contact_person' => 'MUDr. Eva Žákovičová, PhD.',
        'force' => ['address' => 'Domy Kramáre, Jelšová 3086/1, 3. NP, m. č. A3.06-1/2, 831 01 Bratislava-Nové Mesto', 'locality' => 'Bratislava-Nové Mesto', 'priority' => 'B'],
        'note' => 'e-VÚC a ORSR 2026-11-03: Diacrin s. r. o., IČO 47898551; ambulancia sa PRESŤAHOVALA zo Saratovskej 24 do Nového Mesta (záznamy 61-47898551-A0001 diabetológia a A0002 endokrinológia), sestra Marcela Čechová, hodiny od 1. 1. 2025: po 7 až 16, ut 10 až 16, st 7 až 15, pi 7 až 14. Preto priorita B. E-mail diacrin12@gmail.com v registri nie je.'],
    28 => ['expect' => 'MUDr. Peter Habán', 'phone' => '+421 2 642 87 038',
        'note' => 'e-VÚC 2026-11-03: na Saratovskej 24 nie je žiadny (ani zrušený) záznam diabetologickej ambulancie, ORSR bez záznamu; telefón z katalógu navstevalekara.sk (overiť), staršie katalógy uvádzajú 0907 221 347 a dvere 115. Pôsobenie neoverené.'],
    35 => ['expect' => 'MUDr. Eva Bischerová',
        'note' => 'e-VÚC, ORSR, web a katalógy 2026-11-03: lekárka nenájdená; v e-VÚC nie je na Saratovskej 24 žiadna kardiologická ambulancia. Pravdepodobne už neordinuje, navrhujem deaktivovať po telefonickom overení.'],
    42 => ['expect' => 'MUDr. Oľga Rabenseiferová', 'phone' => '+421 2 643 68 708',
        'force' => ['address' => 'ZS Paracelsus, M. Schneidra Trnavského 1825/8, 841 01 Bratislava-Dúbravka'],
        'note' => 'navstevalekara.sk (katalóg) 2026-11-03: telefón 02/643 68 708, overiť; v e-VÚC meno nenájdené, jediná registrovaná interná ambulancia v ZS Paracelsus je INTERNA - MED (MUDr. Ševčík, MUDr. Srdoš).'],
    34 => ['expect' => 'VERIA', 'ico' => '35882221', 'website' => 'https://www.veria.sk/',
        'force' => ['name' => 'VERIA, s.r.o. (MUDr. Rudolf Uhliar, CSc., kardiológ)', 'contact_person' => 'MUDr. Rudolf Uhliar, CSc.',
            'address' => 'Švabinského 3682/17, prízemie, 851 01 Bratislava-Petržalka', 'locality' => 'Bratislava-Petržalka',
            'phone' => '+421 2 638 12 304', 'email' => 'info@veria.sk', 'priority' => 'C'],
        'note' => 'ORSR, e-VÚC a veria.sk 2026-11-03: VERIA, s.r.o. (IČO 35882221, konateľ MUDr. Rudolf Uhliar) má kardiologickú ambulanciu 61-35882221-A0001 v PETRŽALKE, v Dúbravke záznam nemá; master dokument ju nesprávne spojil s MUDr. Ivanom Matejčíkom, ktorý je chirurg (Saratovská 223/24, IČO 31769331, tel. +421 2 644 61 939). Pôvodný katalógový e-mail veria.ambulancia@gmail.com nahradený. Priorita C.'],
    43 => ['expect' => 'In Clinic', 'ico' => '44677910', 'website' => 'https://www.inclinic.sk/',
        'force' => ['contact_person' => 'MUDr. Etela Janeková, PhD.', 'address' => 'ZS MAGMA, Rusovská cesta 3298/19, 2. NP, 851 01 Bratislava-Petržalka',
            'locality' => 'Bratislava-Petržalka', 'phone' => '+421 2 638 10 143', 'priority' => 'C'],
        'note' => 'ORSR, e-VÚC a inclinic.sk 2026-11-03: In Clinic s. r. o., IČO 44677910, interná ambulancia 61-44677910-A0001 v PETRŽALKE (po a ut 15:00 až 17:30, pi 13:00 až 15:00), na Saratovskej 24 záznam nemá; e-mail janekova@inclinic.sk potvrdený, katalógový telefón 02/6353 1013 nahradený. Priorita C.'],
    49 => ['expect' => 'MILUMED', 'ico' => '48040959', 'contact_person' => 'MUDr. Milan Blaško', 'website' => 'https://www.urodoktor.sk/',
        'force' => ['address' => 'ZS Paracelsus, M. Schneidra Trnavského 1825/8, 2. NP, dv. 110, 841 01 Bratislava-Dúbravka'],
        'note' => 'ORSR, e-VÚC a urodoktor.sk 2026-11-03: MILUMED s.r.o., IČO 48040959; urológia 61-48040959-A0001 (po 8 až 16, ut až št 8 až 14, pi 8 až 12), telefón a e-mail potvrdené.'],
    11 => ['expect' => 'LH med', 'phone' => '+421 908 799 048',
        'force' => ['address' => 'Kristy Bendovej 3476/4, 841 02 Bratislava-Dúbravka', 'is_active' => '0'],
        'note' => 'Deaktivované 2026-11-03: rodinnydoktor.sk oznamuje, že ambulancia Dúbravka je od 10. 2. 2026 do odvolania zatvorená (pacienti presmerovaní do Senca); e-VÚC záznamy 61-51914123-A0006 a 51-51914123-A0003 zrušené k 26. 2. a 14. 6. 2026. Sídlo Clementisova 1483/24, Bernolákovo.'],
// ── Poliklinika Karlova Ves (RPO ŠÚ SR, e-VÚC, bratislavskykraj.sk/poliklinika, weby) ──
    40 => ['expect' => 'Kardiovita', 'ico' => '53644492', 'contact_person' => 'MUDr. Peter Kalist, MPH; MUDr. Ivana Soóšová, PhD.',
        'force' => ['address' => 'Poliklinika Karlova Ves, Líščie údolie 98/57, m. č. 40 a 41, 842 31 Bratislava-Karlova Ves'],
        'note' => 'RPO a e-VÚC 2026-11-03: Kardiovita s.r.o., IČO 53644492, sídlo Bezručova 3; kardiológia 61-53644492-A0001 (po 10 až 14, ut 7:30 až 15:30, st 10 až 17, št 7:30 až 17, pi 7:30 až 10:30), sestra Eva Kolláthová; telefón ani e-mail nezverejnené, informácie polikliniky 02/602 64 111. V tých istých miestnostiach má od 14. 1. 2026 kardiologický záznam aj Novate s. r. o. (IČO 56654375, 61-56654375-A0001), overiť nástupníctvo.'],
    38 => ['expect' => 'MUDr. Ivana Soóšová',
        'force' => ['is_active' => '0'],
        'note' => 'Deaktivované 2026-11-03: duplicita voči id 40 (Kardiovita s.r.o.), lekárka je jej spoločníčkou (RPO).'],
    54 => ['expect' => 'MUDr. Andrea Škublová', 'ico' => '35833254', 'phone' => '+421 2 5465 4141', 'email' => 'objednanie@fidelitas.sk', 'website' => 'https://www.fidelitas.sk/',
        'force' => ['address' => 'Poliklinika Karlova Ves, Líščie údolie 98/57, 1. a 3. poschodie (m. č. 128/B, 310), 842 31 Bratislava-Karlova Ves'],
        'note' => 'RPO, e-VÚC a fidelitas.sk 2026-11-03: Fidelitas, s.r.o., IČO 35833254, reumatológia a osteológia (záznamy 61-35833254-A0015, A0016, A0017; endokrinológia A0018); e-VÚC uvádza lekárov Popracová, Štekláč, Halmová, Sisol, Gajdárová, Huszárová, Samelová, Kolesnikov, Ursínyová, MUDr. Škublovú NIE (len katalóg); osloviť Fidelitas ako celok.'],
    46 => ['expect' => 'MUDr. Jaroslava Richterová',
        'force' => ['specialization' => 'angiológia, interná medicína'],
        'note' => 'bratislavskykraj.sk/poliklinika 2026-11-03: vedená v angiologickej (cievnej) ambulancii spolu s MUDr. Ľubomírou Javorčíkovou (LION-MED); samostatný e-VÚC záznam, telefón ani e-mail nenájdené.'],
    50 => ['expect' => 'MUDr. Juraj Brutenič', 'ico' => '36808661',
        'note' => 'RPO 2026-11-03: BB MEDICAL s.r.o., IČO 36808661, sídlo Zhorínska 14B/4724; urológia potvrdená na webe polikliniky; e-VÚC záznam nenájdený, e-mail nezverejnený.'],
    51 => ['expect' => 'MUDr. Zuzana Seresová', 'ico' => '44659474',
        'force' => ['name' => 'MUDr. Zuzana Seresová, PhD. (ZUNAGYN, gynekológia)', 'specialization' => 'gynekológia a pôrodníctvo'],
        'note' => 'bratislavskykraj.sk/poliklinika a RPO 2026-11-03: gynekologická ambulancia (s MUDr. Matúšom Chudom), ZUNAGYN s.r.o., IČO 44659474; master dokument ju nesprávne viedol ako urologičku. Telefón a e-mail nezverejnené.'],
    17 => ['expect' => 'MUDr. Silvia Sýkorová', 'ico' => '44530935',
        'note' => 'RPO 2026-11-03: MUDr. Sýkorová Silvia, s. r. o., IČO 44530935 (sídlo Kadnárova 70), všeobecné lekárstvo pre dospelých aj deti a dorast.'],
    45 => ['expect' => 'MUDr. Denisa Holzerová',
        'note' => 'e-VÚC, RPO, web polikliniky a katalógy 2026-11-03: lekárka nenájdená (nie je v zozname ambulancií Polikliniky Karlova Ves); overiť meno alebo deaktivovať.'],
    55 => ['expect' => 'Poliklinika Karlova Ves',
        'note' => 'bratislavskykraj.sk/poliklinika/kontakt 2026-11-03: informácie 02/602 64 111, sekretariát +421 2 602 64 311, sekretariat@poliklinikakv.sk (poliklinikakv.sk presmeruje na bratislavskykraj.sk).'],
];

$softFields = ['ico', 'contact_person', 'phone', 'email', 'address', 'website'];
$rowStmt    = $pdo->prepare('SELECT * FROM partner_providers WHERE id = :id');

if ($dryRun) {
    echo '[dry-run] nič sa nezapisuje' . PHP_EOL;
}
$updated = 0;
$unchanged = 0;
$warned = 0;
foreach ($updates as $id => $u) {
    $rowStmt->execute(['id' => $id]);
    $row = $rowStmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false || !str_starts_with((string) $row['name'], $u['expect'])) {
        $warned++;
        echo "POZOR: id {$id} nenájdené alebo názov nezačína na „{$u['expect']}“ (" . ($row['name'] ?? '-') . ') – preskočené.' . PHP_EOL;
        continue;
    }
    $set    = [];
    $params = ['id' => $id];
    foreach ($softFields as $f) {
        if (isset($u[$f]) && trim((string) ($row[$f] ?? '')) === '') {
            $set[]      = "$f = :$f";
            $params[$f] = $u[$f];
        }
    }
    foreach ($u['force'] ?? [] as $f => $v) {
        if ((string) ($row[$f] ?? '') !== $v) {
            $set[]      = "$f = :$f";
            $params[$f] = $v;
        }
    }
    $notes = (string) ($row['notes'] ?? '');
    $note  = (string) $u['note'];
    if (!str_contains($notes, $note)) {
        $set[]           = 'notes = :notes';
        $params['notes'] = $notes === '' ? $note : $notes . ' | ' . $note;
    }
    $source = (string) ($row['source'] ?? '');
    if (!str_contains($source, $SRCTAG)) {
        $set[]            = 'source = :source';
        $params['source'] = $source === '' ? $SRCTAG : $source . ' / ' . $SRCTAG;
    }
    if ($set === []) {
        $unchanged++;
        continue;
    }
    echo "Doplnené id {$id} ({$row['name']}): " . implode(', ', array_diff(array_keys($params), ['id'])) . PHP_EOL;
    $updated++;
    if (!$dryRun) {
        $pdo->prepare('UPDATE partner_providers SET ' . implode(', ', $set) . ' WHERE id = :id')->execute($params);
    }
}
echo "Doplnených {$updated}, bez zmeny {$unchanged}, varovaní {$warned}." . PHP_EOL;
