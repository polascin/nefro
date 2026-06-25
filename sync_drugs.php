<?php

declare(strict_types=1);
/**
 * sync_drugs.php
 * Fáza 6 — synchronizácia farmakológie liekov z ChEMBL (EMBL-EBI) REST API v2.
 *
 * Len CLI/cron (php_sapi_name guard + .htaccess deny). Pre kurátorský zoznam liekov
 * (podľa ChEMBL ID) stiahne molekulu + mechanizmus a upsertne do `drugs` (podľa
 * chembl_id). Vytvára lieky ako NEZVEREJNENÉ (is_published ostáva 0).
 *
 * HRANICA KURÁCIE:
 *   - ChEMBL vlastní (aktualizuje pri každom behu): name_intl, atc_code, routes,
 *     max_phase, first_approval, black_box_warning, withdrawn, mechanism, synonyms.
 *   - Seed pri prvom vložení (sync NEPREPISUJE): slug, name_sk, category, drug_class,
 *     source_refs.
 *   - Čisto kurátorské (sync sa NEDOTÝKA): indications, renal_dosing, nephrotoxicity,
 *     dialyzability, warnings, monitoring, sk_note, is_published.
 *
 * Spustenie:  php sync_drugs.php   (cez SSH alebo cron, napr. týždenne)
 * Predpoklad: migrácia `add_drugs_migration.php` už prebehla.
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}
require_once __DIR__ . '/db_config.php';

const DG_API = 'https://www.ebi.ac.uk/chembl/api/data';

/**
 * Kurátorský zoznam nefrologicky relevantných liekov (ChEMBL ID = parent molecule).
 * slug/name_sk/category/drug_class sú seed hodnoty (po vložení ich spravuje admin).
 */
$seed = [
    ['chembl' => 'CHEMBL429910',  'slug' => 'dapagliflozin', 'name_sk' => 'Dapagliflozín', 'category' => 'nephroprotect', 'drug_class' => 'SGLT2 inhibítor'],
    ['chembl' => 'CHEMBL2107830', 'slug' => 'empagliflozin', 'name_sk' => 'Empagliflozín', 'category' => 'nephroprotect', 'drug_class' => 'SGLT2 inhibítor'],
    ['chembl' => 'CHEMBL2181927', 'slug' => 'finerenon',     'name_sk' => 'Finerenón',     'category' => 'nephroprotect', 'drug_class' => 'Nesteroidný MRA'],
    ['chembl' => 'CHEMBL2108724', 'slug' => 'semaglutid',    'name_sk' => 'Semaglutid',    'category' => 'nephroprotect', 'drug_class' => 'GLP-1 receptorový agonista'],
    ['chembl' => 'CHEMBL191',     'slug' => 'losartan',      'name_sk' => 'Losartan',      'category' => 'nephroprotect', 'drug_class' => 'ARB (sartan)'],
    ['chembl' => 'CHEMBL1168',    'slug' => 'ramipril',      'name_sk' => 'Ramipril',      'category' => 'nephroprotect', 'drug_class' => 'ACE inhibítor'],
    ['chembl' => 'CHEMBL1393',    'slug' => 'spironolakton', 'name_sk' => 'Spironolaktón', 'category' => 'nephroprotect', 'drug_class' => 'Steroidný MRA'],
    ['chembl' => 'CHEMBL1431',    'slug' => 'metformin',     'name_sk' => 'Metformín',     'category' => 'dose_adjust',   'drug_class' => 'Biguanid'],
    ['chembl' => 'CHEMBL6067485', 'slug' => 'gentamicin',    'name_sk' => 'Gentamicín',    'category' => 'nephrotoxic',   'drug_class' => 'Aminoglykozid'],
    ['chembl' => 'CHEMBL269732',  'slug' => 'tacrolimus',    'name_sk' => 'Takrolimus',    'category' => 'nephrotoxic',   'drug_class' => 'Kalcineurínový inhibítor', 'atc' => 'L04AD02'],
    // Diuretiká
    ['chembl' => 'CHEMBL35',      'slug' => 'furosemid',         'name_sk' => 'Furosemid',          'category' => 'diuretic',      'drug_class' => 'Slučkové diuretikum'],
    ['chembl' => 'CHEMBL1148',    'slug' => 'torazemid',         'name_sk' => 'Torazemid',          'category' => 'diuretic',      'drug_class' => 'Slučkové diuretikum'],
    ['chembl' => 'CHEMBL435',     'slug' => 'hydrochlorotiazid', 'name_sk' => 'Hydrochlorotiazid',  'category' => 'diuretic',      'drug_class' => 'Tiazidové diuretikum', 'atc' => 'C03AA03'],
    // Nefroprotektíva
    ['chembl' => 'CHEMBL1069',    'slug' => 'valsartan',         'name_sk' => 'Valsartan',          'category' => 'nephroprotect', 'drug_class' => 'ARB (sartan)'],
    // Úprava dávky podľa obličiek
    ['chembl' => 'CHEMBL1467',    'slug' => 'alopurinol',        'name_sk' => 'Alopurinol',         'category' => 'dose_adjust',   'drug_class' => 'Inhibítor xantínoxidázy'],
    ['chembl' => 'CHEMBL940',     'slug' => 'gabapentin',        'name_sk' => 'Gabapentín',         'category' => 'dose_adjust',   'drug_class' => 'Antikonvulzívum / analgetikum'],
    // Nefrotoxické lieky
    ['chembl' => 'CHEMBL262777',  'slug' => 'vankomycin',        'name_sk' => 'Vankomycín',         'category' => 'nephrotoxic',   'drug_class' => 'Glykopeptidové antibiotikum', 'atc' => 'J01XA01'],
    ['chembl' => 'CHEMBL11359',   'slug' => 'cisplatina',        'name_sk' => 'Cisplatina',         'category' => 'nephrotoxic',   'drug_class' => 'Platinové cytostatikum'],
    ['chembl' => 'CHEMBL521',     'slug' => 'ibuprofen',         'name_sk' => 'Ibuprofén',          'category' => 'nephrotoxic',   'drug_class' => 'NSAID', 'atc' => 'M01AE01'],
    // Lieky a dialýza / CKD-MBD
    ['chembl' => 'CHEMBL1201492', 'slug' => 'sevelamer',         'name_sk' => 'Sevelamer',          'category' => 'dialysis',      'drug_class' => 'Viazač fosfátov', 'atc' => 'V03AE02'],
    ['chembl' => 'CHEMBL1201284', 'slug' => 'cinakalcet',        'name_sk' => 'Cinakalcet',         'category' => 'dialysis',      'drug_class' => 'Kalcimimetikum'],
    // Transplantácia / imunosupresia
    ['chembl' => 'CHEMBL160',     'slug' => 'cyklosporin',       'name_sk' => 'Cyklosporín',        'category' => 'transplant',    'drug_class' => 'Kalcineurínový inhibítor', 'atc' => 'L04AD01'],
    ['chembl' => 'CHEMBL866',     'slug' => 'mykofenolat',       'name_sk' => 'Mykofenolát mofetil', 'category' => 'transplant',   'drug_class' => 'Inhibítor IMPDH'],
    // Nefrotoxické lieky (2. vlna)
    ['chembl' => 'CHEMBL184',     'slug' => 'aciklovir',         'name_sk' => 'Aciklovir',          'category' => 'nephrotoxic',   'drug_class' => 'Antivirotikum'],
    ['chembl' => 'CHEMBL1538',    'slug' => 'tenofovir',         'name_sk' => 'Tenofovir-dizoproxil', 'category' => 'nephrotoxic', 'drug_class' => 'Antivirotikum (NtRTI)', 'atc' => 'J05AF07'],
    ['chembl' => 'CHEMBL267345',  'slug' => 'amfotericin',       'name_sk' => 'Amfotericín B',      'category' => 'nephrotoxic',   'drug_class' => 'Polyénové antimykotikum'],
    // CKD-MBD, anémia a dialýza (2. vlna)
    ['chembl' => 'CHEMBL846',     'slug' => 'kalcitriol',        'name_sk' => 'Kalcitriol',         'category' => 'dialysis',      'drug_class' => 'Aktívny vitamín D'],
    ['chembl' => 'CHEMBL1200622', 'slug' => 'parikalcitol',      'name_sk' => 'Parikalcitol',       'category' => 'dialysis',      'drug_class' => 'Analóg vitamínu D'],
    ['chembl' => 'CHEMBL2338329', 'slug' => 'roxadustat',        'name_sk' => 'Roxadustat',         'category' => 'dialysis',      'drug_class' => 'HIF-PHI (anémia pri CKD)'],
    // Úprava dávky / nefroprotektíva (2. vlna)
    ['chembl' => 'CHEMBL107',     'slug' => 'kolchicin',         'name_sk' => 'Kolchicín',          'category' => 'dose_adjust',   'drug_class' => 'Inhibítor mikrotubulov'],
    ['chembl' => 'CHEMBL2108027', 'slug' => 'dulaglutid',        'name_sk' => 'Dulaglutid',         'category' => 'nephroprotect', 'drug_class' => 'GLP-1 receptorový agonista'],
    // ── 3. vlna ───────────────────────────────────────────────────────────────
    // Nefroprotektíva
    ['chembl' => 'CHEMBL2048484', 'slug' => 'kanagliflozin',     'name_sk' => 'Kanagliflozín',      'category' => 'nephroprotect', 'drug_class' => 'SGLT2 inhibítor', 'atc' => 'A10BK02'],
    ['chembl' => 'CHEMBL578',     'slug' => 'enalapril',         'name_sk' => 'Enalapril',          'category' => 'nephroprotect', 'drug_class' => 'ACE inhibítor', 'atc' => 'C09AA02'],
    ['chembl' => 'CHEMBL1095097', 'slug' => 'eplerenon',         'name_sk' => 'Eplerenón',          'category' => 'nephroprotect', 'drug_class' => 'Selektívny steroidný MRA', 'atc' => 'C03DA04'],
    // Diuretiká
    ['chembl' => 'CHEMBL406',     'slug' => 'indapamid',         'name_sk' => 'Indapamid',          'category' => 'diuretic',      'drug_class' => 'Tiazidu podobné diuretikum', 'atc' => 'C03BA11'],
    ['chembl' => 'CHEMBL945',     'slug' => 'amilorid',          'name_sk' => 'Amilorid',           'category' => 'diuretic',      'drug_class' => 'Kálium-šetriace diuretikum', 'atc' => 'C03DB01'],
    ['chembl' => 'CHEMBL20',      'slug' => 'acetazolamid',      'name_sk' => 'Acetazolamid',       'category' => 'diuretic',      'drug_class' => 'Inhibítor karboanhydrázy', 'atc' => 'S01EC01'],
    // Úprava dávky podľa obličiek
    ['chembl' => 'CHEMBL539697',  'slug' => 'dabigatran',        'name_sk' => 'Dabigatran-etexilát', 'category' => 'dose_adjust',  'drug_class' => 'Priamy inhibítor trombínu (DOAC)', 'atc' => 'B01AE07'],
    ['chembl' => 'CHEMBL231779',  'slug' => 'apixaban',          'name_sk' => 'Apixaban',           'category' => 'dose_adjust',   'drug_class' => 'Inhibítor faktora Xa (DOAC)', 'atc' => 'B01AF02'],
    ['chembl' => 'CHEMBL1751',    'slug' => 'digoxin',           'name_sk' => 'Digoxín',            'category' => 'dose_adjust',   'drug_class' => 'Srdcový glykozid', 'atc' => 'C01AA05'],
    ['chembl' => 'CHEMBL1059',    'slug' => 'pregabalin',        'name_sk' => 'Pregabalín',         'category' => 'dose_adjust',   'drug_class' => 'Antikonvulzívum (α2δ ligand)', 'atc' => 'N02BF02'],
    // Nefrotoxické lieky
    ['chembl' => 'CHEMBL1200826', 'slug' => 'litium',            'name_sk' => 'Lítium (uhličitan)', 'category' => 'nephrotoxic',   'drug_class' => 'Stabilizátor nálady', 'atc' => 'N05AN01'],
    ['chembl' => 'CHEMBL177',     'slug' => 'amikacin',          'name_sk' => 'Amikacín',           'category' => 'nephrotoxic',   'drug_class' => 'Aminoglykozid', 'atc' => 'J01GB06'],
    ['chembl' => 'CHEMBL34259',   'slug' => 'metotrexat',        'name_sk' => 'Metotrexát',         'category' => 'nephrotoxic',   'drug_class' => 'Antimetabolit (antagonista folátu)', 'atc' => 'L04AX03'],
    // CKD-MBD a dialýza
    ['chembl' => 'CHEMBL2096647', 'slug' => 'lantan',            'name_sk' => 'Lantán-karbonát',    'category' => 'dialysis',      'drug_class' => 'Viazač fosfátov (bez kalcia)', 'atc' => 'V03AE03'],
    // Transplantácia / imunosupresia
    ['chembl' => 'CHEMBL413',     'slug' => 'sirolimus',         'name_sk' => 'Sirolimus',          'category' => 'transplant',    'drug_class' => 'mTOR inhibítor', 'atc' => 'L04AH01'],
    ['chembl' => 'CHEMBL1542',    'slug' => 'azatioprin',        'name_sk' => 'Azatioprín',         'category' => 'transplant',    'drug_class' => 'Purínový antimetabolit', 'atc' => 'L04AX01'],
    // ── 4. vlna — viazače draslíka, ESA, železo, CKD-MBD ───────────────────────
    ['chembl' => 'CHEMBL5315081', 'slug' => 'patiromer',         'name_sk' => 'Patiromér',          'category' => 'dialysis',      'drug_class' => 'Viazač draslíka (hyperkaliémia)', 'atc' => 'V03AE09'],
    ['chembl' => 'CHEMBL3301592', 'slug' => 'szc',               'name_sk' => 'Nátrium-zirkónium-cyklosilikát', 'category' => 'dialysis', 'drug_class' => 'Viazač draslíka (hyperkaliémia)', 'atc' => 'V03AE10'],
    ['chembl' => 'CHEMBL1201565', 'slug' => 'epoetin',           'name_sk' => 'Epoetín alfa',       'category' => 'dialysis',      'drug_class' => 'Erytropoetín (ESA)', 'atc' => 'B03XA01'],
    ['chembl' => 'CHEMBL1201566', 'slug' => 'darbepoetin',       'name_sk' => 'Darbepoetín alfa',   'category' => 'dialysis',      'drug_class' => 'Erytropoetín (ESA, dlhodobý)', 'atc' => 'B03XA02'],
    ['chembl' => 'CHEMBL2108597', 'slug' => 'zelezo-karboxymaltoza', 'name_sk' => 'Železitá karboxymaltóza', 'category' => 'dialysis', 'drug_class' => 'Železo (i.v.)'],
    ['chembl' => 'CHEMBL1200800', 'slug' => 'kalciumacetat',     'name_sk' => 'Kalciumacetát',      'category' => 'dialysis',      'drug_class' => 'Viazač fosfátov (kalciový)', 'atc' => 'V03AE07'],
    ['chembl' => 'CHEMBL3545184', 'slug' => 'etelkalcetid',      'name_sk' => 'Etelkalcetid',       'category' => 'dialysis',      'drug_class' => 'Kalcimimetikum (i.v.)', 'atc' => 'H05BX04'],
    // ── 5. vlna — renálne dávkovanie a nefrotoxíny ────────────────────────────
    ['chembl' => 'CHEMBL1201476', 'slug' => 'enoxaparin',        'name_sk' => 'Enoxaparín',         'category' => 'dose_adjust',   'drug_class' => 'Nízkomolekulový heparín (LMWH)', 'atc' => 'B01AB05'],
    ['chembl' => 'CHEMBL22',      'slug' => 'kotrimoxazol',      'name_sk' => 'Kotrimoxazol (TMP-SMX)', 'category' => 'nephrotoxic', 'drug_class' => 'Antibiotikum (DHFR inhibítor + sulfónamid)', 'atc' => 'J01EE01'],
    ['chembl' => 'CHEMBL8',       'slug' => 'ciprofloxacin',     'name_sk' => 'Ciprofloxacín',      'category' => 'dose_adjust',   'drug_class' => 'Fluorochinolón', 'atc' => 'J01MA02'],
    ['chembl' => 'CHEMBL1503',    'slug' => 'omeprazol',         'name_sk' => 'Omeprazol',          'category' => 'nephrotoxic',   'drug_class' => 'Inhibítor protónovej pumpy', 'atc' => 'A02BC01'],
    ['chembl' => 'CHEMBL572',     'slug' => 'nitrofurantoin',    'name_sk' => 'Nitrofurantoín',     'category' => 'dose_adjust',   'drug_class' => 'Uroantiseptikum', 'atc' => 'J01XE01'],
    ['chembl' => 'CHEMBL701',     'slug' => 'baklofen',          'name_sk' => 'Baklofén',           'category' => 'dose_adjust',   'drug_class' => 'Centrálne myorelaxans (GABA-B agonista)', 'atc' => 'M03BX01'],
    ['chembl' => 'CHEMBL1422',    'slug' => 'sitagliptin',       'name_sk' => 'Sitagliptín',        'category' => 'dose_adjust',   'drug_class' => 'DPP-4 inhibítor', 'atc' => 'A10BH01'],
    ['chembl' => 'CHEMBL237500',  'slug' => 'linagliptin',       'name_sk' => 'Linagliptín',        'category' => 'dose_adjust',   'drug_class' => 'DPP-4 inhibítor', 'atc' => 'A10BH05'],
    ['chembl' => 'CHEMBL198362',  'slug' => 'rivaroxaban',       'name_sk' => 'Rivaroxaban',        'category' => 'dose_adjust',   'drug_class' => 'Inhibítor faktora Xa (DOAC)', 'atc' => 'B01AF01'],
    ['chembl' => 'CHEMBL1496',    'slug' => 'rosuvastatin',      'name_sk' => 'Rosuvastatín',       'category' => 'dose_adjust',   'drug_class' => 'Statín (inhibítor HMG-CoA reduktázy)', 'atc' => 'C10AA07'],
    // ── 6. vlna — transplantácia, ADPKD/ARNI, dna, CKD-MBD, onkonefrológia ─────
    ['chembl' => 'CHEMBL1908360', 'slug' => 'everolimus',        'name_sk' => 'Everolimus',         'category' => 'transplant',    'drug_class' => 'mTOR inhibítor', 'atc' => 'L04AH02'],
    ['chembl' => 'CHEMBL635',     'slug' => 'prednizon',         'name_sk' => 'Prednizón',          'category' => 'transplant',    'drug_class' => 'Kortikosteroid (glukokortikoid)', 'atc' => 'H02AB07'],
    ['chembl' => 'CHEMBL1201576', 'slug' => 'rituximab',         'name_sk' => 'Rituximab',          'category' => 'transplant',    'drug_class' => 'Anti-CD20 monoklonálna protilátka', 'atc' => 'L01FA01'],
    ['chembl' => 'CHEMBL1742990', 'slug' => 'belatacept',        'name_sk' => 'Belatacept',         'category' => 'transplant',    'drug_class' => 'Blokátor kostimulácie (CTLA-4 Ig)', 'atc' => 'L04AA28'],
    ['chembl' => 'CHEMBL344159',  'slug' => 'tolvaptan',         'name_sk' => 'Tolvaptan',          'category' => 'nephroprotect', 'drug_class' => 'Vaptan (antagonista V2 receptora)', 'atc' => 'C03XA01'],
    ['chembl' => 'CHEMBL3137301', 'slug' => 'sakubitril-valsartan', 'name_sk' => 'Sakubitril/valsartan', 'category' => 'nephroprotect', 'drug_class' => 'ARNI (inhibítor neprilyzínu + ARB)', 'atc' => 'C09DX04'],
    ['chembl' => 'CHEMBL1164729', 'slug' => 'febuxostat',        'name_sk' => 'Febuxostat',         'category' => 'dose_adjust',   'drug_class' => 'Inhibítor xantínoxidázy', 'atc' => 'M04AA03'],
    ['chembl' => 'CHEMBL1072',    'slug' => 'bumetanid',         'name_sk' => 'Bumetanid',          'category' => 'diuretic',      'drug_class' => 'Slučkové diuretikum', 'atc' => 'C03CA02'],
    ['chembl' => 'CHEMBL1601669', 'slug' => 'alfakalcidol',      'name_sk' => 'Alfakalcidol',       'category' => 'dialysis',      'drug_class' => 'Analóg vitamínu D (1α-OH-D₃)', 'atc' => 'A11CC03'],
    ['chembl' => 'CHEMBL1201594', 'slug' => 'rasburikaza',       'name_sk' => 'Rasburikáza',        'category' => 'other',         'drug_class' => 'Rekombinantná urátoxidáza', 'atc' => 'M04AX01'],
    // ── 7. vlna — antimikrobiká, acidobáza, diuretická rezistencia, analgézia ──
    ['chembl' => 'CHEMBL1353',    'slug' => 'natriumbikarbonat', 'name_sk' => 'Hydrogenuhličitan sodný', 'category' => 'dialysis',  'drug_class' => 'Alkalizans (korekcia metabolickej acidózy)', 'atc' => 'B05XA02'],
    ['chembl' => 'CHEMBL1055',    'slug' => 'chlortalidon',      'name_sk' => 'Chlórtalidon',       'category' => 'diuretic',      'drug_class' => 'Tiazidu podobné diuretikum', 'atc' => 'C03BA04'],
    ['chembl' => 'CHEMBL878',     'slug' => 'metolazon',         'name_sk' => 'Metolazón',          'category' => 'diuretic',      'drug_class' => 'Tiazidu podobné diuretikum', 'atc' => 'C03BA08'],
    ['chembl' => 'CHEMBL127',     'slug' => 'meropenem',         'name_sk' => 'Meropeném',          'category' => 'dose_adjust',   'drug_class' => 'Karbapenémové antibiotikum', 'atc' => 'J01DH02'],
    ['chembl' => 'CHEMBL702',     'slug' => 'piperacilin-tazobaktam', 'name_sk' => 'Piperacilín/tazobaktám', 'category' => 'nephrotoxic', 'drug_class' => 'Penicilínové antibiotikum (s tazobaktámom)', 'atc' => 'J01CR05'],
    ['chembl' => 'CHEMBL666',     'slug' => 'foscarnet',         'name_sk' => 'Foskarnet',          'category' => 'nephrotoxic',   'drug_class' => 'Antivirotikum (analóg pyrofosfátu)', 'atc' => 'J05AD01'],
    ['chembl' => 'CHEMBL182',     'slug' => 'ganciklovir',       'name_sk' => 'Ganciklovir',        'category' => 'dose_adjust',   'drug_class' => 'Antivirotikum (anti-CMV)', 'atc' => 'J05AB06'],
    ['chembl' => 'CHEMBL6067481', 'slug' => 'kolistin',          'name_sk' => 'Kolistín (kolistimetát)', 'category' => 'nephrotoxic', 'drug_class' => 'Polymyxínové antibiotikum', 'atc' => 'J01XB01'],
    ['chembl' => 'CHEMBL70',      'slug' => 'morfin',            'name_sk' => 'Morfín',             'category' => 'dose_adjust',   'drug_class' => 'Opioidné analgetikum', 'atc' => 'N02AA01'],
    ['chembl' => 'CHEMBL4802224', 'slug' => 'sukroferik',        'name_sk' => 'Sukroferik-oxyhydroxid', 'category' => 'dialysis',  'drug_class' => 'Viazač fosfátov (na báze železa)', 'atc' => 'V03AE05'],
    ['chembl' => 'CHEMBL1487',    'slug' => 'atorvastatin',      'name_sk' => 'Atorvastatín',       'category' => 'dose_adjust',   'drug_class' => 'Statín (inhibítor HMG-CoA reduktázy)', 'atc' => 'C10AA05'],
];

/** Stiahne JSON z ChEMBL REST; vráti dekódované pole alebo null pri chybe. */
function dgFetch(string $url): ?array
{
    $ch = curl_init($url);
    if ($ch === false) {
        return null;
    }
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        CURLOPT_USERAGENT      => 'nefro.polascin.net drug-database sync (+https://nefro.polascin.net)',
    ]);
    $resp = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (!is_string($resp) || $code !== 200) {
        return null;
    }
    $data = json_decode($resp, true);
    return is_array($data) ? $data : null;
}

/** Cesty podania z booleanov molekuly → CSV „oral,parenteral,topical". */
function dgBuildRoutes(array $m): ?string
{
    $r = [];
    foreach (['oral', 'parenteral', 'topical'] as $k) {
        if (!empty($m[$k])) {
            $r[] = $k;
        }
    }
    return $r !== [] ? implode(',', $r) : null;
}

/** ATC level5 z poľa atc_classifications (REST: pole reťazcov, prvý prvok). */
function dgExtractAtc(array $m): ?string
{
    $atc = $m['atc_classifications'] ?? null;
    if (is_array($atc) && isset($atc[0]) && is_string($atc[0]) && $atc[0] !== '') {
        return mb_substr($atc[0], 0, 16);
    }
    return null;
}

/** Obchodné názvy (TRADE_NAME) z molecule_synonyms → JSON (max 15, dedup). */
function dgExtractSynonyms(array $m): ?string
{
    $syns = $m['molecule_synonyms'] ?? null;
    if (!is_array($syns)) {
        return null;
    }
    $seen = [];
    $out = [];
    foreach ($syns as $s) {
        if (!is_array($s)) {
            continue;
        }
        $type = strtoupper((string) ($s['syn_type'] ?? ''));
        if ($type !== 'TRADE_NAME') {
            continue;
        }
        $name = trim((string) ($s['molecule_synonym'] ?? ''));
        $key = mb_strtolower($name);
        if ($name === '' || isset($seen[$key])) {
            continue;
        }
        $seen[$key] = true;
        $out[] = $name;
        if (count($out) >= 15) {
            break;
        }
    }
    return $out !== [] ? (json_encode($out, JSON_UNESCAPED_UNICODE) ?: null) : null;
}

/** EMA odkazy z cross_references → JSON [{label,url}] (len pri prvom vložení). */
function dgExtractSources(array $m): ?string
{
    $refs = $m['cross_references'] ?? null;
    if (!is_array($refs)) {
        return null;
    }
    $out = [];
    foreach ($refs as $r) {
        if (!is_array($r) || strtoupper((string) ($r['xref_src'] ?? '')) !== 'EMA') {
            continue;
        }
        $xid = trim((string) ($r['xref_id'] ?? ''));
        $xname = trim((string) ($r['xref_name'] ?? ''));
        if ($xid === '' || !str_starts_with($xid, 'human/')) {
            continue;
        }
        $out[] = [
            'label' => 'EMA EPAR' . ($xname !== '' ? ' — ' . ucfirst($xname) : ''),
            'url'   => 'https://www.ema.europa.eu/en/medicines/' . $xid,
        ];
        if (count($out) >= 6) {
            break;
        }
    }
    return $out !== [] ? (json_encode($out, JSON_UNESCAPED_UNICODE) ?: null) : null;
}

/** Očistí koncový hydrátový/anhydridový deskriptor z INN (napr. „TACROLIMUS ANHYDROUS"). */
function dgCleanInn(string $name): string
{
    $name = trim($name);
    return preg_replace('/\s+(ANHYDROUS|HYDRATE|MONOHYDRATE|DIHYDRATE|TRIHYDRATE|HEMIHYDRATE|HYDROCHLORIDE|MESYLATE|MESILATE|MALEATE|SULFATE|SULPHATE|BESYLATE|FUMARATE|SUCCINATE|TARTRATE)$/i', '', $name) ?? $name;
}

/**
 * Mechanizmus účinku z mechanism endpointu (spojí unikátne MoA).
 * Filtruje cez parent_molecule_chembl_id — ChEMBL ukladá mechanizmus pod dávkovú/soľnú
 * formu (napr. losartan pod CHEMBL995, metformín pod CHEMBL1703), nie pod parent ID.
 */
function dgFetchMechanism(string $chemblId): ?string
{
    $data = dgFetch(DG_API . '/mechanism.json?parent_molecule_chembl_id=' . rawurlencode($chemblId) . '&limit=20');
    $list = is_array($data) ? ($data['mechanisms'] ?? null) : null;
    if (!is_array($list)) {
        return null;
    }
    $seen = [];
    $parts = [];
    foreach ($list as $row) {
        $moa = is_array($row) ? trim((string) ($row['mechanism_of_action'] ?? '')) : '';
        if ($moa === '' || isset($seen[$moa])) {
            continue;
        }
        $seen[$moa] = true;
        $parts[] = $moa;
    }
    return $parts !== [] ? mb_substr(implode('; ', $parts), 0, 2000) : null;
}

/** @var \PDO $pdo */
$insert = $pdo->prepare(
    "INSERT INTO drugs
        (slug, name_sk, category, drug_class, chembl_id, name_intl, atc_code, routes,
         max_phase, first_approval, black_box_warning, withdrawn, mechanism, synonyms,
         source_refs, chembl_synced_at)
     VALUES
        (:slug, :name_sk, :category, :drug_class, :chembl_id, :name_intl, :atc_code, :routes,
         :max_phase, :first_approval, :black_box_warning, :withdrawn, :mechanism, :synonyms,
         :source_refs, :synced_at)
     ON DUPLICATE KEY UPDATE
        name_intl = VALUES(name_intl), atc_code = VALUES(atc_code), routes = VALUES(routes),
        max_phase = VALUES(max_phase), first_approval = VALUES(first_approval),
        black_box_warning = VALUES(black_box_warning), withdrawn = VALUES(withdrawn),
        mechanism = VALUES(mechanism), synonyms = VALUES(synonyms),
        chembl_synced_at = VALUES(chembl_synced_at)"
);

$now = date('Y-m-d H:i:s');
$ok = 0;
$failed = 0;
$errors = [];

foreach ($seed as $drug) {
    $chemblId = $drug['chembl'];
    $mol = dgFetch(DG_API . '/molecule/' . rawurlencode($chemblId) . '.json');
    if ($mol === null) {
        $failed++;
        $errors[] = "$chemblId ({$drug['name_sk']}): zlyhalo stiahnutie molekuly.";
        continue;
    }

    $maxPhaseRaw = $mol['max_phase'] ?? null;
    $maxPhase = is_numeric($maxPhaseRaw) ? (int) round((float) $maxPhaseRaw) : null;
    $approval = isset($mol['first_approval']) && is_numeric($mol['first_approval']) ? (int) $mol['first_approval'] : null;

    try {
        $insert->execute([
            'slug'              => $drug['slug'],
            'name_sk'           => $drug['name_sk'],
            'category'          => $drug['category'],
            'drug_class'        => $drug['drug_class'],
            'chembl_id'         => $chemblId,
            'name_intl'         => (($p = dgCleanInn((string) ($mol['pref_name'] ?? ''))) !== '') ? mb_substr($p, 0, 200) : null,
            'atc_code'          => $drug['atc'] ?? dgExtractAtc($mol),
            'routes'            => dgBuildRoutes($mol),
            'max_phase'         => $maxPhase,
            'first_approval'    => $approval,
            'black_box_warning' => !empty($mol['black_box_warning']) ? 1 : 0,
            'withdrawn'         => !empty($mol['withdrawn_flag']) ? 1 : 0,
            'mechanism'         => dgFetchMechanism($chemblId),
            'synonyms'          => dgExtractSynonyms($mol),
            'source_refs'       => dgExtractSources($mol),
            'synced_at'         => $now,
        ]);
        $ok++;
    } catch (\PDOException $e) {
        $failed++;
        $errors[] = "$chemblId: " . $e->getMessage();
        error_log('sync_drugs upsert error: ' . $e->getMessage());
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Synchronizácia liekov (ChEMBL / EMBL-EBI)\n";
echo "──────────────────────────────────────────────────────\n";
echo "V zozname:        " . count($seed) . "\n";
echo "Uložených/upsert: $ok\n";
echo "Zlyhaných:        $failed\n";
if ($errors !== []) {
    echo "Chyby:\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}
echo "Lieky sa vytvárajú ako NEZVEREJNENÉ — doplňte renálne dávkovanie a zverejnite v admin_drugs.php.\n";
echo "Dokončené: $now\n";

error_log(sprintf('sync_drugs: total=%d ok=%d failed=%d at %s', count($seed), $ok, $failed, $now));
