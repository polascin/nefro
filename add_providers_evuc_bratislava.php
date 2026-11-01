<?php

declare(strict_types=1);
/**
 * add_providers_evuc_bratislava.php
 * Doplnenie partner_providers podľa zoznamu „76 ambulancií na oslovenie"
 * (Ambulancie_Bratislava.pdf; verejné kontakty e-VÚC skontrolované 1. 11. 2026).
 *
 *  - vloží nové pracoviská (idempotentne: preskočí, ak už existuje rovnaký názov
 *    alebo e-mail),
 *  - existujúcim záznamom doplní IČO, kontaktnú osobu, telefón, e-mail a adresu
 *    LEN tam, kde pole chýba; vedome prepisované polia sú v kľúči `force`
 *    a dôvod je vždy v poznámke,
 *  - do poznámky pripojí číslo záznamu e-VÚC (idempotentne: kontrola podreťazca),
 *  - do `source` pripojí značku zdroja.
 *
 * Spustenie: php add_providers_evuc_bratislava.php [--dry-run]
 *   --dry-run vypíše plánované zmeny a nič nezapíše.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Doplniť ambulancie podľa zoznamu e-VÚC (Bratislava, 2026-11-01)');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$dryRun = in_array('--dry-run', $argv ?? [], true);
$SRC    = 'e-VÚC, zoznam Ambulancie_Bratislava.pdf, 2026-11-01';
$SRCTAG = 'e-VÚC 2026-11-01';

$DUB = 'Bratislava-Dúbravka';
$KV  = 'Bratislava-Karlova Ves';
$LAM = 'Bratislava-Lamač';
$DEV = 'Bratislava-Devín';
$PB  = 'Bratislava-Podunajské Biskupice';
$VRA = 'Bratislava-Vrakuňa';
$RAC = 'Bratislava-Rača';
$NM  = 'Bratislava-Nové Mesto';
$SM  = 'Bratislava-Staré Mesto';
$RUZ = 'Bratislava-Ružinov';
$PET = 'Bratislava-Petržalka';
$VL  = 'vseobecny_lekar';
$VLS = 'všeobecné lekárstvo';

// ── Nové pracoviská ──────────────────────────────────────────────────────────
// [name, provider_type, specialization, locality, address, phone, email, contact_person, ico, notes]
$new = [
    ['Med Prax, s.r.o. (MUDr. Beata Maníková)', $VL, $VLS, $DUB,
        'ZS Paracelsus, M. Schneidra Trnavského 1825/8, č. m. 103, 841 01 Bratislava-Dúbravka',
        '+421 2 642 87 990', null, 'MUDr. Beata Maníková', '36727253',
        'e-VÚC 61-36727253-A0001. E-mail nezverejnený: list na adresu pracoviska alebo telefón.'],
    ['Viatica, s. r. o.', $VL, $VLS, $DUB,
        'ZS Saratovská 223/24, 841 02 Bratislava-Dúbravka',
        '+421 910 912 189', 'ambulancia.ivancova@gmail.com', null, '44438834',
        'e-VÚC 61-44438834-A0001. E-mail z registra, doručiteľnosť neoverená.'],
    ['CINRE s. r. o. (interná ambulancia, Nemocnica Bory)', 'specialista', 'interná medicína', $LAM,
        'Nemocnica Bory, Ulica Ivana Kadlečíka 6851/2, 841 03 Bratislava-Lamač',
        null, null, null, '51012138',
        'e-VÚC 61-51012138-A0015. Osloviť koordinovane s Nemocnicou Bory (interná a diabetologická ambulancia). Pozor: Bory je v dialýze konkurencia.'],
    ['WAMED s.r.o. (diabetológia)', 'specialista', 'diabetológia', $KV,
        'Hany Meličkovej 3514/11/A, prízemie, samostatný trakt, 841 05 Bratislava-Karlova Ves (Dlhé diely)',
        '+421 911 653 653', null, null, '35969563',
        'e-VÚC 61-35969563-A0002.'],
    ['Neštátna gastroenterologická ambulancia spol. s r.o. (MUDr. Miriam Šišuláková)', 'specialista', 'interná medicína, gastroenterológia', $KV,
        'Poliklinika Karlova Ves, Líščie údolie 98/57, 841 04 Bratislava-Karlova Ves',
        '+421 905 885 115', null, 'MUDr. Miriam Šišuláková', '35947896',
        'e-VÚC 61-35947896-A0001 (interná ambulancia).'],
    ['ONKOCET, s.r.o. (interná ambulancia)', 'specialista', 'interná medicína', $KV,
        'Pribišova 47, 3. NP, nebytové priestory č. 3, 841 05 Bratislava-Karlova Ves',
        '+421 2 446 40 977, +421 948 610 228', null, null, '36767280',
        'e-VÚC 61-36767280-A0001.'],
    ['Doktornet s.r.o. (MUDr. Martina Vaľková, PhD.)', $VL, $VLS, $KV,
        'Poliklinika Karlova Ves, Líščie údolie 98/57, 1. poschodie, m. č. 115, 841 04 Bratislava-Karlova Ves',
        '+421 2 602 64 381', 'info@mediprevent.sk', 'MUDr. Martina Vaľková, PhD.', '56030797',
        'e-VÚC 61-56030797-A0001.'],
    ['MED-ADULT, s.r.o.', $VL, $VLS, $KV,
        'Poliklinika Karlova Ves, Líščie údolie 98/57, I. poschodie, m. č. 109, 841 04 Bratislava-Karlova Ves',
        '+421 2 654 23 101', null, null, '35908815',
        'e-VÚC 61-35908815-A0001.'],
    ['Oftasan, spol. s r.o. (MUDr. Mechura, MUDr. Martišková)', $VL, $VLS, $KV,
        'Poliklinika Karlova Ves, Líščie údolie 98/57, pavilón dospelých, 1. poschodie, č. dv. 113 a 114, 841 04 Bratislava-Karlova Ves',
        '+421 2 602 64 245', null, 'MUDr. Mechura; MUDr. Martišková', '35825111',
        'e-VÚC 61-35825111-A0001.'],
    ['SOMED s.r.o.', $VL, $VLS, $KV,
        'Poliklinika Karlova Ves, Líščie údolie 98/57, 1. poschodie, 841 04 Bratislava-Karlova Ves',
        null, 'lekarka.karlovka@gmail.com', null, '35909447',
        'e-VÚC 61-35909447-A0001. E-mail lekarka.karlovka@gmail.com bol v master dokumente 6/2026 pripísaný STAMED; podľa e-VÚC patrí SOMED.'],
    ['DevinAmb s. r. o. (všeobecná a interná ambulancia, Devín)', $VL, 'všeobecné lekárstvo, interná medicína', $DEV,
        'Dom kultúry Devín, Rytierska 3687/2, m. č. 1 a 2, 841 10 Bratislava-Devín',
        null, null, null, '55351883',
        'e-VÚC 61-55351883-A0001 (všeobecná ambulancia) a A0002 (interná ambulancia). Kontakt nezverejnený: list na adresu pracoviska.'],
    ['LH med s.r.o. (Podunajské Biskupice)', $VL, $VLS, $PB,
        'Podunajská 12484/27, 1. NP, m. č. 1.04 (samostatný vstup zvonka), 821 06 Bratislava-Podunajské Biskupice',
        '+421 918 936 896', 'sestra.podunajska@rdo.sk', null, '51914123',
        'e-VÚC 51-51914123-A0005. Sieť rdo.sk; pracovisko Dúbravka je samostatný záznam.'],
    ['LUKOMED s. r. o.', $VL, $VLS, $VRA,
        'ZS Bebravská I, Bebravská 8850/34, I. poschodie, m. č. 169.1 a 170.1, 821 07 Bratislava-Vrakuňa',
        '+421 2 452 42 040', 'lukomed70@gmail.com', null, '46453385',
        'e-VÚC 61-46453385-A0001.'],
    ['M-MED, s. r. o. (ŠGN Podunajské Biskupice)', $VL, $VLS, $PB,
        'Špecializovaná geriatrická nemocnica Podunajské Biskupice, Krajinská 91, m. č. 115 a 116, 825 56 Bratislava',
        '+421 918 379 783', null, null, '48180467',
        'e-VÚC 61-48180467-A0001.'],
    ['MED-AMB DANIELA, s.r.o.', $VL, $VLS, $VRA,
        'ZS Bebravská 8956/1, prízemie, 821 07 Bratislava-Vrakuňa',
        '+421 2 452 41 241', null, null, '36361372',
        'e-VÚC 61-36361372-A0001.'],
    ['MEDMAK, s.r.o.', $VL, $VLS, $RAC,
        'OC Kubačova 7562/19, 1. NP, samostatný trakt, m. č. 2.04 a 2.05, 831 06 Bratislava-Rača',
        '+421 2 448 89 329', null, null, '36667099',
        'e-VÚC 61-36667099-A0001.'],
    ['MUDr. Očadlík, s.r.o. (MUDr. Ivan Očadlík, PhD.)', $VL, $VLS, $PB,
        'ZS Učiteľská 10590/20, 1. NP, m. č. 1.03 a 1.04, 821 06 Bratislava-Podunajské Biskupice',
        '+421 914 656 657', 'ambulancia@ocadlik.sk', 'MUDr. Ivan Očadlík, PhD.', '47243376',
        'e-VÚC 61-47243376-A0001. Ďalší e-mail: sestra@ocadlik.sk. Telefón obsluhuje AI asistent.'],
    ['Mimedicus s.r.o. (MUDr. Michaela Randušková)', $VL, $VLS, $VRA,
        'ZS Bebravská 8956/1, 2. NP, ambulancia č. 137, 821 07 Bratislava-Vrakuňa',
        '+421 2 455 25 018', 'ambmimedicus@gmail.com', 'MUDr. Michaela Randušková', '45378185',
        'e-VÚC 61-45378185-A0001.'],
    ['ProSalvus s. r. o. (MUDr. Viera Krátka)', $VL, $VLS, $PB,
        'ZS Učiteľská 10590/20, prízemie, samostatný trakt, 821 06 Bratislava-Podunajské Biskupice',
        '+421 2 381 04 738', null, 'MUDr. Viera Krátka; MUDr. PharmDr. Evelin Karim Aziz, MPH; MUDr. Iva Mišigová', '46193316',
        'e-VÚC 61-46193316-A0001.'],
    ['Univerzitná nemocnica - Nemocnica svätého Michala, a. s. (všeobecné ambulancie)', 'nemocnica', $VLS, $SM,
        'Nemocnica svätého Michala, Cintorínska 3/B, 1. poschodie, 811 08 Bratislava-Staré Mesto',
        '+421 2 3261 1160, +421 2 3261 2253', null, 'MUDr. Adrián Kiss; MUDr. Peter Novák', '44570783',
        'e-VÚC 51-44570783-A0050 (MUDr. Kiss) a A0107 (MUDr. Novák).'],
    ['MUDr. Eva Oravcová (všeobecná ambulancia)', $VL, $VLS, $NM,
        'Vajnorská 1346/135, 831 04 Bratislava-Nové Mesto',
        '+421 2 595 02 223', null, 'MUDr. Eva Oravcová', '31761569',
        'e-VÚC 61-31761569-A0001.'],
    ['Maritim s. r. o.', $VL, $VLS, $NM,
        'Jelšová 3086/1, 2. NP, m. č. A2.03-2, 831 01 Bratislava-Nové Mesto',
        '+421 910 400 333', null, null, '54754143',
        'e-VÚC 61-54754143-A0001. Telefón iba SMS, ambulancia volá späť.'],
    ['Next s.r.o.', $VL, $VLS, $NM,
        'Vajnorská 1354/40, 3. poschodie, m. č. 307, 831 03 Bratislava-Nové Mesto',
        '+421 911 331 128', null, null, '31375979',
        'e-VÚC 61-31375979-A0014.'],
    ['Národný ústav srdcových a cievnych chorôb, a.s. (všeobecná ambulancia)', 'nemocnica', $VLS, $NM,
        'Pod Krásnou hôrkou 1, 833 48 Bratislava-Nové Mesto',
        '+421 2 5932 0111', null, null, '35971126',
        'e-VÚC 51-35971126-A0018. Telefón je ústredňa NÚSCH.'],
    ['VeroPractice s. r. o.', $VL, $VLS, $NM,
        'Robotnícka 3204/1, 3. NP, m. č. 3.12 (ordinácia) a 3.11, 831 03 Bratislava-Nové Mesto',
        '+421 909 164 451', null, null, '56622945',
        'e-VÚC 61-56622945-A0001.'],
    ['Univerzitná nemocnica Bratislava - Nemocnica Ružinov (diabetologická ambulancia)', 'nemocnica', 'diabetológia', $RUZ,
        'Nemocničná poliklinika Nemocnice Ružinov, Ružinovská 4810/6, suterén monobloku A, č. dverí 11, 821 01 Bratislava-Ružinov',
        '+421 2 4823 4772', null, null, '31813861',
        'e-VÚC 51-31813861-A0047.'],
    ['Ambulancie Poliklinika Váš Lekár, s.r.o. (Eurovea 2)', $VL, $VLS, $RUZ,
        'Polyfunkčný súbor Eurovea 2, Pribinova 19277/40, V01, 811 09 Bratislava',
        null, null, null, '55548202',
        'e-VÚC 61-55548202-A0002. Sieť Váš Lekár (vaslekar.sk).'],
    ['Komplexná zdravotná služba s. r. o.', $VL, $VLS, $RUZ,
        'Budova Univerzitnej lekárne Farmaceutickej fakulty UK, Ružinovská 4813/12, m. č. 216 a 217, 821 01 Bratislava-Ružinov',
        '+421 2 4960 8306', null, null, '51804573',
        'e-VÚC 61-51804573-A0003.'],
    ['Polimed s. r. o.', $VL, $VLS, $RUZ,
        'Rezedová 1886/5, prízemie, samostatný trakt, 821 01 Bratislava-Ružinov',
        '+421 947 932 244', 'a63098@napislekarovi.sk', null, '46582258',
        'e-VÚC 61-46582258-A0001.'],
    ['Praktická Ambulancia, s. r. o. (Nivy)', $VL, $VLS, $RUZ,
        'Azovská 1077/2 (vchod z Ul. Nitová 1), 821 08 Bratislava-Ružinov',
        '+421 2 4960 8345', 'nivy@praktickaambulancia.sk', null, '47057271',
        'e-VÚC 51-47057271-A0018.'],
    ['APL DOS s. r. o.', $VL, $VLS, $PET,
        'Poliklinika Šustekova, Šustekova 2422/2, m. č. 104 a 105, 851 04 Bratislava-Petržalka',
        '+421 2 624 10 151', null, null, '35851112',
        'e-VÚC 61-35851112-A0001.'],
    ['GUDr. s.r.o.', $VL, $VLS, $PET,
        'ZS Strečnianska 2975/13, trakt C, m. č. C213 a C215, 851 05 Bratislava-Petržalka',
        null, null, null, '55191622',
        'e-VÚC 61-55191622-A0001.'],
    ['Poliklinika Karlova Ves (všeobecná ambulancia Rovniankova, Petržalka)', $VL, $VLS, $PET,
        'ZS Rovniankova 1656/1, prízemie, detský pavilón, m. č. 6, 851 02 Bratislava-Petržalka',
        '+421 947 915 516', null, null, '17336236',
        'e-VÚC 61-17336236-A0008. Prevádzkovateľ Poliklinika Karlova Ves (správa polikliniky je samostatný záznam).'],
    ['Praktická Ambulancia, s. r. o. (Petržalka)', $VL, $VLS, $PET,
        'Kopčianska 3756/8, 1. NP, m. č. 05, 851 01 Bratislava-Petržalka',
        '+421 2 622 40 154', 'petrzalka@praktickaambulancia.sk', null, '47057271',
        'e-VÚC 51-47057271-A0002.'],
    ['Váš Lekár ambulancie, s.r.o. (Záporožská, Petržalka)', $VL, $VLS, $PET,
        'Záporožská 257/12, prízemie, č. 1.07, 851 01 Bratislava-Petržalka',
        null, null, null, '54712653',
        'e-VÚC 61-54712653-A0002. Sieť Váš Lekár (vaslekar.sk).'],
];

// ── Doplnenie existujúcich záznamov ─────────────────────────────────────────
// Kľúč = id na produkcii (stav 2026-11-01); `expect` = začiatok názvu ako poistka,
// že sa nedopĺňa cudzí záznam. Polia ico/contact_person/phone/email/address sa
// zapíšu len do prázdneho poľa; `force` prepíše vždy (dôvod v poznámke).
$updates = [
    1  => ['expect' => 'Klinika nefrológie', 'ico' => '31813861',
        'note' => 'IČO prevádzkovateľa UNB podľa e-VÚC.'],
    2  => ['expect' => 'Urologická klinika', 'ico' => '31813861',
        'note' => 'IČO prevádzkovateľa UNB podľa e-VÚC.'],
    3  => ['expect' => 'Univerzitná nemocnica Bratislava', 'ico' => '31813861',
        'note' => 'e-VÚC 51-31813861-A0097 (diabetologická ambulancia, poliklinika, č. dv. 260, tel. +421 2 5954 2385) a A0136 (všeobecná ambulancia, č. dv. 268, tel. +421 2 5954 2980).'],
    5  => ['expect' => 'Ambulancia Dúbravka', 'ico' => '36718483', 'contact_person' => 'MUDr. Alžbeta Bothová',
        'note' => 'e-VÚC 61-36718483-A0001: lekárka MUDr. Alžbeta Bothová, 1. NP, m. č. 12, ZS Saratovská 223/24. Meno v názve záznamu je z master dokumentu 6/2026.'],
    6  => ['expect' => 'SA-FE AMBULANCIA', 'ico' => '36735256', 'contact_person' => 'MUDr. Eva Fellnerová',
        'note' => 'e-VÚC 61-36735256-A0001: II. poschodie, blok II.'],
    7  => ['expect' => 'MENDELSANA', 'ico' => '56766653',
        'note' => 'e-VÚC 61-56766653-A0001: m. č. 123.'],
    8  => ['expect' => 'Care Med', 'ico' => '36281891',
        'note' => 'e-VÚC 61-36281891-A0001.'],
    9  => ['expect' => 'AVE VITA', 'ico' => '35965827',
        'force' => ['name' => 'AVE VITA, s.r.o.'],
        'note' => 'e-VÚC 61-35965827-A0001. Master dokument 6/2026 uvádzal MUDr. Beatu Maníkovú; e-VÚC 1. 11. 2026 ju vedie v Med Prax, s.r.o. (samostatný záznam), preto meno z názvu odstránené.'],
    10 => ['expect' => 'MEDIRA', 'ico' => '36728195', 'contact_person' => 'MUDr. Veronika Lackovičová; MUDr. Estera Kubicová',
        'note' => 'e-VÚC 61-36728195-A0001: II. NP, m. č. 122; e-mail v registri esterakubicova@gmail.com, tel. +421 2 642 87 951.'],
    11 => ['expect' => 'LH med', 'ico' => '51914123',
        'note' => 'e-VÚC: prevádzkovateľ má aj pracovisko Podunajské Biskupice (51-51914123-A0005, samostatný záznam).'],
    12 => ['expect' => 'DARAMED', 'ico' => '54748844', 'contact_person' => 'MUDr. Darina Gajdošová',
        'note' => 'e-VÚC 61-54748844-A0001.'],
    13 => ['expect' => 'STAMED', 'ico' => '35909757',
        'note' => 'e-VÚC 61-35909757-A0001 (všeobecná ambulancia, tel. +421 2 602 64 177, +421 940 808 289) a A0002 (interná ambulancia, tel. +421 2 529 23 349), 2. NP, m. č. 120 a 121. E-mail lekarka.karlovka@gmail.com patrí podľa e-VÚC SOMED s.r.o.'],
    14 => ['expect' => 'MiriaMed', 'ico' => '54837901',
        'note' => 'e-VÚC 61-54837901-A0001.'],
    15 => ['expect' => 'MEDICUS PARTNERS', 'ico' => '35866560',
        'note' => 'e-VÚC 61-35866560-A0001.'],
    16 => ['expect' => 'DAMED', 'ico' => '54136709', 'phone' => '+421 905 535 570',
        'force' => ['address' => 'ZS ŠD Družba, Botanická 6/25, 1. NP, samostatný trakt, m. č. 1.6, 841 04 Bratislava-Karlova Ves'],
        'note' => 'e-VÚC 61-54136709-A0001: pracovisko ZS ŠD Družba, Botanická 6/25 (master dokument 6/2026 uvádzal Poliklinika Karlova Ves).'],
    18 => ['expect' => 'Medicínske zariadenie Mlynská dolina', 'ico' => '47236311',
        'note' => 'e-VÚC 61-47236311-A0031 (všeobecná ambulancia, 1. NP, m. č. 101), A0015 (interná, 1. NP, m. č. 103), A0014 (diabetológia, 3. NP, m. č. 309); tel. +421 2 323 13 030. Register vedie viac samostatných ambulancií, osloviť jedným spoločným listom.'],
    19 => ['expect' => 'STANMED', 'ico' => '35913088', 'contact_person' => 'MUDr. Sabina Stankovičová',
        'note' => 'e-VÚC 61-35913088-A0001.'],
    20 => ['expect' => 'PRO SANUS', 'ico' => '35875704',
        'contact_person' => 'MUDr. Oksana Labíková; MUDr. Veronika Tóthová; MUDr. Zuzana Sabová; MUDr. Magdaléna Pažitná; MUDr. Jitka Herczeg Račická, MHA, MPH',
        'note' => 'e-VÚC 51-35875704-A0005, A0006, A0007 (tri všeobecné ambulancie v Bory Mall); call centrum ProCare +421 2 3232 3838.'],
    21 => ['expect' => 'DAHAMED', 'ico' => '57140910',
        'note' => 'e-VÚC 61-57140910-A0001: prízemie, m. č. 1.6.'],
    22 => ['expect' => 'Všeobecný lekár DNV', 'ico' => '36769797', 'contact_person' => 'MUDr. Martina Rutaiová',
        'note' => 'e-VÚC 61-36769797-A0001.'],
    23 => ['expect' => 'FaMa Med', 'ico' => '44767005', 'contact_person' => 'MUDr. Jaroslava Sojková; MUDr. Tatiana Madarászová',
        'note' => 'e-VÚC 61-44767005-A0001.'],
    24 => ['expect' => 'MEDIVITAL', 'ico' => '57051003',
        'force' => ['address' => 'ZS Pavla Horova 6147/14, č. m. 122, 841 08 Bratislava-Devínska Nová Ves'],
        'note' => 'e-VÚC 61-57051003-A0001. Kontakt nezverejnený: list na adresu pracoviska.'],
    26 => ['expect' => 'STANMED', 'ico' => '35913088', 'contact_person' => 'MUDr. Alžbeta Olexová', 'phone' => '+421 908 116 160',
        'force' => ['address' => 'ZS Gbelská 7426/8, 841 06 Bratislava-Záhorská Bystrica'],
        'note' => 'e-VÚC 61-35913088-A0002.'],
    29 => ['expect' => 'MUDr. Roman Žák', 'ico' => '31346651', 'phone' => '+421 2 654 12 797',
        'note' => 'e-VÚC: prevádzkovateľ BEMI Export Group spol. s r.o. (MUDr. Žak), 61-31346651-A0001 (diabetológia) a A0002 (interná ambulancia); koordinovať oslovenie oboch ambulancií.'],
    30 => ['expect' => 'MUDr. Danica Malíčková', 'ico' => '47236311',
        'note' => 'e-VÚC 61-47236311-A0014 (diabetologická ambulancia MZ Mlynská dolina, 3. NP, m. č. 309, tel. +421 2 323 13 030).'],
    31 => ['expect' => 'MUDr. Ingrid Jurkovičová', 'ico' => '47236311',
        'note' => 'e-VÚC 61-47236311-A0014 (diabetologická ambulancia MZ Mlynská dolina, 3. NP, m. č. 309, tel. +421 2 323 13 030).'],
    32 => ['expect' => 'doc. MUDr. Boris Krahulec', 'ico' => '50073869',
        'note' => 'e-VÚC: prevádzkovateľ Biomedicínske centrum SAV (meno lekára v registri neuvedené), 61-50073869-A0002 (diabetológia) a A0001 (interná ambulancia), Pavilón lekárskych vied SAV, Dúbravská cesta 5779/9, 1. NP, blok C.'],
    33 => ['expect' => 'INTERNA-MED', 'ico' => '44776845',
        'note' => 'e-VÚC 61-44776845-A0002 (interná ambulancia).'],
    39 => ['expect' => 'MARKOMEDIK', 'ico' => '35874643', 'contact_person' => 'MUDr. Michal Marko', 'phone' => '+421 2 443 73 342',
        'force' => [
            'address'        => 'Cesta na Červený Most 1791/1, 841 04 Bratislava-Karlova Ves',
            'specialization' => 'interná medicína, kardiológia',
        ],
        'note' => 'e-VÚC 61-35874643-A0001: interná ambulancia, Cesta na Červený Most 1791/1 (master dokument 6/2026 uvádzal kardiológiu v Líščom údolí 57).'],
    41 => ['expect' => 'KARDIO-SANUS', 'ico' => '35976918',
        'force' => ['address' => 'Štefana Králika 1/B a 1/G, 1. NP, m. č. 101 až 116, 841 08 Bratislava-Devínska Nová Ves'],
        'note' => 'e-VÚC 61-35976918-A0005 (interná ambulancia, tel. 0918 626 902) a A0001 (všeobecná ambulancia, tel. 0911 279 762). Adresa Poliklinika DNV, Opletalova bola z master dokumentu 6/2026.'],
    44 => ['expect' => 'LION-MED', 'ico' => '36808369',
        'note' => 'e-VÚC 61-36808369-A0002 (interná ambulancia): m. č. 103 a 104; tel. +421 2 602 64 240.'],
    47 => ['expect' => 'PANAKEIA', 'ico' => '35969873', 'contact_person' => 'MUDr. Jaroslava Schichorová',
        'note' => 'e-VÚC 61-35969873-A0002 (interná ambulancia).'],
    48 => ['expect' => 'MM AMBULANCIA', 'ico' => '36270229', 'contact_person' => 'MUDr. Lucia Mariničová', 'phone' => '+421 911 870 900',
        'force' => ['provider_type' => 'vseobecny_lekar', 'specialization' => 'všeobecné lekárstvo'],
        'note' => 'e-VÚC 61-36270229-A0003: všeobecná ambulancia (master dokument 6/2026 uvádzal internú).'],
    52 => ['expect' => 'MUDr. Mahmoud Hassan', 'ico' => '47236311',
        'note' => 'IČO prevádzkovateľa MZ Mlynská dolina podľa e-VÚC.'],
    55 => ['expect' => 'Poliklinika Karlova Ves', 'ico' => '17336236',
        'note' => 'e-VÚC 61-17336236-A0008: prevádzkuje aj všeobecnú ambulanciu v ZS Rovniankova 1656/1, Petržalka (samostatný záznam).'],
    56 => ['expect' => 'Klinika Mlynská dolina', 'ico' => '47236311',
        'note' => 'e-VÚC: prevádzkovateľ MEDICÍNSKE ZARIADENIE MLYNSKÁ DOLINA, s. r. o., záznamy A0031 (VL), A0015 (interná), A0014 (diabetológia).'],
    57 => ['expect' => 'Nemocnica Bory', 'ico' => '53773411',
        'note' => 'e-VÚC 61-53773411-A0002 (interná ambulancia) a A0007 (diabetologická ambulancia); osloviť koordinovane s CINRE s. r. o. (interná ambulancia v Nemocnici Bory).'],
];

// ── Vykonanie ────────────────────────────────────────────────────────────────
$softFields = ['ico', 'contact_person', 'phone', 'email', 'address'];

$checkStmt = $pdo->prepare(
    'SELECT id, name FROM partner_providers WHERE name = :name OR (:email IS NOT NULL AND email = :email2) LIMIT 1'
);
$insStmt = $pdo->prepare(
    'INSERT INTO partner_providers
        (name, provider_type, specialization, locality, address, phone, email,
         contact_person, ico, notes, source, is_active)
     VALUES
        (:name, :provider_type, :specialization, :locality, :address, :phone, :email,
         :contact_person, :ico, :notes, :source, 1)'
);
$rowStmt = $pdo->prepare('SELECT * FROM partner_providers WHERE id = :id');

if ($dryRun) {
    echo "[dry-run] nič sa nezapisuje" . PHP_EOL;
}

$inserted = 0;
$skipped  = 0;
foreach ($new as $r) {
    [$name, $type, $spec, $locality, $address, $phone, $email, $person, $ico, $notes] = $r;
    $checkStmt->execute(['name' => $name, 'email' => $email, 'email2' => $email]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
    if ($existing !== false) {
        $skipped++;
        echo 'Preskočené (už existuje id ' . (int) $existing['id'] . '): ' . $existing['name'] . PHP_EOL;
        continue;
    }
    echo 'Vložené: ' . $name . PHP_EOL;
    $inserted++;
    if ($dryRun) {
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
        'contact_person' => $person,
        'ico'            => $ico,
        'notes'          => $notes,
        'source'         => $SRC,
    ]);
}

$updated   = 0;
$unchanged = 0;
$warned    = 0;
foreach ($updates as $id => $u) {
    $rowStmt->execute(['id' => $id]);
    $row = $rowStmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false || !str_starts_with((string) $row['name'], $u['expect'])) {
        $warned++;
        echo "POZOR: id {$id} nenájdené alebo názov nezačína na „{$u['expect']}“ (" . ($row['name'] ?? '-') . ") – preskočené." . PHP_EOL;
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
    if (isset($u['note']) && !str_contains($notes, $u['note'])) {
        $set[]           = 'notes = :notes';
        $params['notes'] = $notes === '' ? $u['note'] : $notes . ' | ' . $u['note'];
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
    $changed = array_diff(array_keys($params), ['id']);
    echo "Doplnené id {$id} (" . $row['name'] . '): ' . implode(', ', $changed) . PHP_EOL;
    $updated++;
    if ($dryRun) {
        continue;
    }
    $pdo->prepare('UPDATE partner_providers SET ' . implode(', ', $set) . ' WHERE id = :id')->execute($params);
}

echo "Nové pracoviská: vložených {$inserted}, preskočených {$skipped}." . PHP_EOL;
echo "Existujúce záznamy: doplnených {$updated}, bez zmeny {$unchanged}, varovaní {$warned}." . PHP_EOL;
