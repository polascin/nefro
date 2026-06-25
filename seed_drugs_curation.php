<?php

declare(strict_types=1);
/**
 * seed_drugs_curation.php
 * Fáza 6 — NÁVRH klinickej kurácie liekov (renálne dávkovanie, nefrotoxicita,
 * dialyzovateľnosť, upozornenia, monitorovanie, indikácie).
 *
 * Len CLI/cron (php_sapi_name guard + .htaccess deny). Obsah je NÁVRH zostavený zo
 * štandardnej renálnej farmakológie a SPC/KDIGO; pred zverejnením ho odborne overte
 * proti aktuálnemu SPC. Skript len UPSERTuje kurátorské textové polia podľa slugu a
 * NEMENÍ is_published (lieky ostávajú nezverejnené, kým ich admin neskontroluje a
 * nezverejní v admin_drugs.php). Idempotentné — prepíše uvedené polia hodnotami nižšie.
 *
 * Spustenie:  php seed_drugs_curation.php
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

/** Povolené (kurátorské) stĺpce — bezpečnostný whitelist pre UPDATE. */
const DG_CUR_COLS = ['indications', 'renal_dosing', 'nephrotoxicity', 'dialyzability', 'warnings', 'monitoring'];

/**
 * NÁVRH kurácie podľa slugu. Uvádzaj len polia, ktoré pre daný liek dávajú zmysel.
 * Štýl: stručné, klinicky použiteľné, orientačné (nie náhrada SPC).
 */
$curation = [
    // ── Nefroprotektíva ───────────────────────────────────────────────────────
    'dapagliflozin' => [
        'indications'    => 'Chronická choroba obličiek (spomalenie progresie, aj bez diabetu), srdcové zlyhanie, diabetes 2. typu.',
        'renal_dosing'   => "Pri CKD a srdcovom zlyhaní možno začať pri eGFR ≥ 25 ml/min/1,73 m² a pokračovať aj pri ďalšom poklese až do dialýzy (podľa indikácie). Glykemický účinok klesá pri eGFR < 45. Pri akútnom ochorení/dehydratácii prechodne vysadiť (sick-day pravidlá).",
        'nephrotoxicity' => 'Nie je nefrotoxický — naopak nefroprotektívny. Po začatí možný mierny reverzibilný pokles eGFR (hemodynamický „dip“).',
        'dialyzability'  => 'Pri dialýze bez renálneho/glykemického prínosu (neindikovaný na zníženie glykémie).',
        'warnings'       => 'Euglykemická diabetická ketoacidóza (vysadiť pri akútnom ochorení a pred operáciou), genitálne mykotické infekcie, volumová deplécia; zriedkavo Fournierova gangréna.',
        'monitoring'     => 'eGFR a objemový stav pred liečbou a počas nej.',
    ],
    'empagliflozin' => [
        'indications'    => 'Chronická choroba obličiek, srdcové zlyhanie, diabetes 2. typu.',
        'renal_dosing'   => "Pri CKD možno začať a pokračovať do eGFR ~ 20 ml/min/1,73 m² (EMPA-KIDNEY). Glykemický účinok klesá pri eGFR < 45. Pri akútnom ochorení/dehydratácii prechodne vysadiť.",
        'nephrotoxicity' => 'Nie je nefrotoxický (nefroprotektívny); po začatí možný reverzibilný „dip“ eGFR.',
        'dialyzability'  => 'Pri dialýze bez prínosu.',
        'warnings'       => 'Euglykemická ketoacidóza, genitálne infekcie, volumová deplécia.',
        'monitoring'     => 'eGFR a objemový stav pred liečbou a počas nej.',
    ],
    'finerenon' => [
        'indications'    => 'Chronická choroba obličiek pri diabete 2. typu (spomalenie progresie, zníženie KV rizika).',
        'renal_dosing'   => "Nezačínať pri K⁺ > 5,0 mmol/l. Iniciácia podľa eGFR (10 alebo 20 mg/d), pri eGFR < 25 sa začatie neodporúča; pokračovanie a titrácia podľa kália a eGFR. Vyhnúť sa silným inhibítorom CYP3A4.",
        'nephrotoxicity' => 'Nie je nefrotoxický (nefroprotektívny).',
        'dialyzability'  => 'Vysoko viazaný na bielkoviny — predpoklad nedialyzovateľnosti.',
        'warnings'       => 'Hyperkaliémia (najmä so súbehom ACEi/ARB, ďalších kálium-šetriacich liekov); kontraindikácia pri Addisonovej chorobe.',
        'monitoring'     => 'Kálium o ~ 4 týždne po začatí/zmene dávky, potom pravidelne; eGFR.',
    ],
    'losartan' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie, nefroprotekcia.',
        'renal_dosing'   => "Začať nižšou dávkou a titrovať. Vzostup kreatinínu do ~ 30 % po začatí je akceptovateľný (hemodynamický); väčší vzostup alebo hyperkaliémia → prehodnotiť (vylúčiť stenózu renálnej artérie, hypovolémiu).",
        'nephrotoxicity' => 'Hemodynamické zhoršenie funkcie pri hypovolémii, súbehu s NSAID/diuretikom alebo kontrastom.',
        'dialyzability'  => 'Viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Hyperkaliémia; kontraindikovaný v gravidite; vysadiť pri akútnej hypovolémii/pred kontrastom podľa rizika.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'valsartan' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie.',
        'renal_dosing'   => "Začať nižšou dávkou a titrovať. Vzostup kreatinínu do ~ 30 % je akceptovateľný; väčší vzostup/hyperkaliémia → prehodnotiť.",
        'nephrotoxicity' => 'Hemodynamické zhoršenie pri hypovolémii/súbehu s NSAID/kontrastom.',
        'dialyzability'  => 'Viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Hyperkaliémia; kontraindikovaný v gravidite.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'ramipril' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie, nefroprotekcia.',
        'renal_dosing'   => "Renálne eliminovaný — pri eGFR < 30 znížiť úvodnú a udržiavaciu dávku a titrovať. Vzostup kreatinínu do ~ 30 % je akceptovateľný; väčší vzostup/hyperkaliémia → prehodnotiť.",
        'nephrotoxicity' => 'Hemodynamické zhoršenie pri hypovolémii, NSAID, kontraste; pozor pri obojstrannej stenóze renálnych artérií.',
        'dialyzability'  => 'Čiastočne dialyzovateľný — zvážiť dávku po HD.',
        'warnings'       => 'Hyperkaliémia, suchý kašeľ, angioedém; kontraindikovaný v gravidite.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'spironolakton' => [
        'indications'    => 'Rezistentná hypertenzia, srdcové zlyhanie, edémy, primárny hyperaldosteronizmus.',
        'renal_dosing'   => "Riziko hyperkaliémie rastie s poklesom eGFR. Vyhnúť sa pri eGFR < 30 a pri K⁺ > 5,0 mmol/l; pri eGFR 30–45 opatrne, nízka dávka a častá kontrola kália.",
        'nephrotoxicity' => 'Nie priamo nefrotoxický; aktívne metabolity sa kumulujú pri zlyhaní obličiek.',
        'dialyzability'  => 'Nedialyzovateľný (viazaný); metabolity sa kumulujú.',
        'warnings'       => 'Hyperkaliémia (najmä so súbehom ACEi/ARB), gynekomastia.',
        'monitoring'     => 'Kálium a kreatinín 3–7 dní po začatí/zmene, potom pravidelne.',
    ],
    'semaglutid' => [
        'indications'    => 'Diabetes 2. typu, obezita; KV/renálne benefity (FLOW pri CKD a DM2).',
        'renal_dosing'   => "Úprava dávky podľa funkcie obličiek nie je potrebná; obmedzené skúsenosti pri terminálnom zlyhaní obličiek. Titrovať pomaly pre GI toleranciu.",
        'nephrotoxicity' => 'Nie je nefrotoxický; ťažké GI nežiaduce účinky (vracanie, hnačka) môžu dehydratáciou vyvolať prerenálne AKI.',
        'dialyzability'  => 'Nedialyzovateľný (veľká, viazaná molekula).',
        'warnings'       => 'Nauzea/vracanie → riziko hypovolémie a AKI; pankreatitída; diabetická retinopatia.',
        'monitoring'     => 'Funkcia obličiek pri výrazných GI ťažkostiach; hydratácia.',
    ],
    // ── Diuretiká ─────────────────────────────────────────────────────────────
    'furosemid' => [
        'indications'    => 'Edémy a objemové preťaženie pri CKD/srdcovom/hepatálnom zlyhaní, hypertenzia pri pokročilej CKD.',
        'renal_dosing'   => "Pri CKD často potrebné vyššie dávky (znížená tubulárna sekrécia do lúmenu); dávku titrovať podľa diuretickej odpovede. Pri rezistencii zvážiť kombináciu s tiazidom. Neúčinný pri anúrii/ESRD.",
        'nephrotoxicity' => 'Nadmerná diuréza → prerenálne AKI; ototoxicita pri vysokých i.v. dávkach a rýchlom podaní.',
        'dialyzability'  => 'Vysoko viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Hypokaliémia, hyponatriémia, hypomagneziémia, hypovolémia, ototoxicita, hyperurikémia.',
        'monitoring'     => 'Elektrolyty (K, Na, Mg), objemový stav a funkcia obličiek.',
    ],
    'torazemid' => [
        'indications'    => 'Edémy a objemové preťaženie, hypertenzia; predvídateľnejšia biodostupnosť ako furosemid.',
        'renal_dosing'   => "Pri CKD často vyššie dávky; lepšia a stálejšia perorálna biodostupnosť ako furosemid. Titrovať podľa odpovede; neúčinný pri anúrii.",
        'nephrotoxicity' => 'Nadmerná diuréza → prerenálne AKI; ototoxicita (nižšia ako furosemid).',
        'dialyzability'  => 'Vysoko viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Hypokaliémia, hyponatriémia, hypovolémia, hyperurikémia.',
        'monitoring'     => 'Elektrolyty, objemový stav, funkcia obličiek.',
    ],
    'hydrochlorotiazid' => [
        'indications'    => 'Hypertenzia, edémy; pri CKD ako prídavok k slučkovému diuretiku (rezistencia).',
        'renal_dosing'   => "Účinnosť v monoterapii klesá pri eGFR < 30 (tiazidy bývajú neúčinné). Pri pokročilej CKD preferovať slučkové diuretiká alebo kombináciu tiazid + slučka pri diuretickej rezistencii.",
        'nephrotoxicity' => 'Hypovolémia → prerenálne AKI; idiosynkratická intersticiálna nefritída zriedkavo.',
        'dialyzability'  => 'Pri ESRD neúčinný a neindikovaný.',
        'warnings'       => 'Hyponatriémia, hypokaliémia, hyperurikémia, hyperkalciémia, hyperglykémia, fotosenzitivita; kumulatívne riziko nemelanómového kožného karcinómu.',
        'monitoring'     => 'Elektrolyty (Na, K), urát, glykémia.',
    ],
    // ── Úprava dávky podľa obličiek ───────────────────────────────────────────
    'metformin' => [
        'indications'    => 'Diabetes 2. typu (liek prvej voľby).',
        'renal_dosing'   => "Kontraindikovaný pri eGFR < 30. Pri eGFR 30–44 nezačínať; ak už užíva, prehodnotiť a zvážiť zníženie dávky (napr. max ~ 1000 mg/d) a zvýšenú opatrnosť. Vysadiť pri akútnom ochorení, dehydratácii a pred podaním jódovej kontrastnej látky (sick-day pravidlá).",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický; pri kumulácii riziko laktátovej acidózy.',
        'dialyzability'  => 'Dialyzovateľný — hemodialýza je liečbou ťažkej laktátovej acidózy/predávkovania.',
        'warnings'       => 'Laktátová acidóza (zriedkavá, ale závažná) — riziko pri zlyhaní obličiek, hypoxii, sepse.',
        'monitoring'     => 'eGFR aspoň 1×/rok, pri eGFR < 45 častejšie.',
    ],
    'alopurinol' => [
        'indications'    => 'Chronická dna, hyperurikémia; prevencia uráthovej nefropatie/nefrolitiázy.',
        'renal_dosing'   => "Aktívny metabolit oxypurinol sa pri zníženej funkcii obličiek kumuluje. Začať nízkou dávkou (napr. 50–100 mg/d) a pomaly titrovať podľa cieľového urátu; opatrne pri eGFR < 30.",
        'nephrotoxicity' => 'Nie priamo; alopurinolová hypersenzitivita môže zahŕňať intersticiálnu nefritídu.',
        'dialyzability'  => 'Oxypurinol je dialyzovateľný — dávkovať po hemodialýze.',
        'warnings'       => 'Závažné kožné reakcie (SJS/TEN, DRESS) — vyššie riziko pri CKD a nosičstve HLA-B*58:01; zvážiť skríning v rizikových populáciách.',
        'monitoring'     => 'Sérový urát, kožné prejavy, krvný obraz a pečeňové testy na začiatku.',
    ],
    'gabapentin' => [
        'indications'    => 'Neuropatická bolesť (aj uremický pruritus a syndróm nepokojných nôh pri CKD), epilepsia.',
        'renal_dosing'   => "Takmer výhradne renálna eliminácia — dávkovať podľa CrCl a progresívne znižovať (CrCl 30–59, 15–29, < 15). Pri hemodialýze podať doplnkovú dávku po procedúre. „Bežné“ dávky pri CKD často spôsobujú toxicitu.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Dialyzovateľný — doplnková dávka po HD.',
        'warnings'       => 'Kumulácia → sedácia, závrat, ataxia, myoklonus, respiračná depresia (najmä so súbehom opioidov).',
        'monitoring'     => 'Klinické príznaky toxicity, funkcia obličiek.',
    ],
    // ── Nefrotoxické lieky ────────────────────────────────────────────────────
    'gentamicin' => [
        'indications'    => 'Závažné gramnegatívne infekcie (zvyčajne kombinovaná liečba).',
        'renal_dosing'   => "Výrazne nefrotoxický — dávkovať podľa funkcie obličiek a hladín; pri zníženom eGFR predĺžiť interval. Preferovať režim raz denne a terapeutické monitorovanie hladín; minimalizovať dĺžku liečby.",
        'nephrotoxicity' => 'Akútna tubulárna nekróza (často neoligurická, zvyčajne reverzibilná); riziko rastie s kumulatívnou dávkou, dĺžkou liečby, hypovolémiou a súbehom ďalších nefrotoxínov.',
        'dialyzability'  => 'Dialyzovateľný — dávkovať podľa hladín a doplniť po HD.',
        'warnings'       => 'Nefro- a ototoxicita (vestibulárna/kochleárna, môže byť ireverzibilná); vyhnúť sa súbehu s inými nefrotoxínmi.',
        'monitoring'     => 'Hladiny (trough/peak), kreatinín/eGFR denne–obdeň, sluch/rovnováha.',
    ],
    'vankomycin' => [
        'indications'    => 'Závažné grampozitívne infekcie (vrátane MRSA); perorálne pri C. difficile.',
        'renal_dosing'   => "Dávkovať podľa funkcie obličiek a cieľovej expozície (preferovaný AUC/MIC, alt. trough). Pri CKD a dialýze individuálne podľa hladín. Perorálna forma pri kolitíde sa nevstrebáva.",
        'nephrotoxicity' => 'Nefrotoxicita najmä pri vyššej expozícii (vysoký trough), dlhšej liečbe a súbehu s piperacilín-tazobaktámom; zvyčajne reverzibilná.',
        'dialyzability'  => 'Závisí od membrány — high-flux odstraňuje časť; dávkovať podľa hladín.',
        'warnings'       => 'Infúzna reakcia („vancomycin flushing“), oto-/nefrotoxicita; opatrnosť so súbežnými nefrotoxínmi.',
        'monitoring'     => 'Hladiny (AUC-riadené preferované), kreatinín/eGFR.',
    ],
    'cisplatina' => [
        'indications'    => 'Solídne nádory (onkonefrológia).',
        'renal_dosing'   => "Výrazne nefrotoxická — pri zníženej funkcii obličiek redukcia dávky/odklad/alternatíva. Povinná intenzívna hydratácia (± Mg suplementácia); pozri Gupta CP-AKI rizikové skóre.",
        'nephrotoxicity' => 'Dávka-závislá toxicita proximálneho tubulu, renálne straty horčíka (hypomagneziémia), soľný-wasting, akútne aj chronické zníženie eGFR.',
        'dialyzability'  => 'Voľná platina krátko po podaní čiastočne dialyzovateľná, viazaná nie — dialýza toxicite nezabráni.',
        'warnings'       => 'Nefro-, oto- a neurotoxicita; profylaxia hydratáciou a korekciou Mg.',
        'monitoring'     => 'eGFR a elektrolyty (Mg, K) pred každým cyklom; bilancia tekutín.',
    ],
    'ibuprofen' => [
        'indications'    => 'Bolesť, zápal, horúčka (v nefrológii skôr liek, ktorému sa vyhýbame).',
        'renal_dosing'   => "Vyhnúť sa pri pokročilej CKD; ak je nevyhnutný, najnižšia účinná dávka čo najkratšie. Vyhnúť sa „triple whammy“ (ACEi/ARB + diuretikum + NSAID) a podaniu pri hypovolémii.",
        'nephrotoxicity' => 'Hemodynamické AKI (inhibícia prostaglandínov → vazokonstrikcia aferentnej arterioly), retencia sodíka a vody, hyperkaliémia, akútna intersticiálna nefritída, papilárna nekróza, zhoršenie CKD.',
        'dialyzability'  => 'Vysoko viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Vyhnúť sa pri CKD, srdcovom zlyhaní a cirhóze; GI a kardiovaskulárne riziko.',
        'monitoring'     => 'Funkcia obličiek, kálium a tlak pri nevyhnutnom použití.',
    ],
    // ── Lieky a dialýza / CKD-MBD ─────────────────────────────────────────────
    'sevelamer' => [
        'indications'    => 'Hyperfosfatémia pri CKD/dialýze.',
        'renal_dosing'   => "Dávkovať podľa sérového fosfátu; užívať s jedlom. Nevstrebáva sa systémovo, preto netreba úpravu podľa eGFR.",
        'nephrotoxicity' => 'Bez systémovej toxicity (pôsobí v GIT).',
        'dialyzability'  => 'Neaplikovateľné — pôsobí lokálne v čreve.',
        'warnings'       => 'GI ťažkosti; môže viazať niektoré súbežné lieky (časový odstup); forma s chloridom môže prispieť k metabolickej acidóze (na rozdiel od karbonátu).',
        'monitoring'     => 'Sérový fosfát, kalcium a bikarbonát.',
    ],
    'cinakalcet' => [
        'indications'    => 'Sekundárna hyperparatyreóza pri dialýze; hyperkalciémia pri karcinóme prištítnych teliesok.',
        'renal_dosing'   => "Bez úpravy podľa eGFR — dávka sa titruje podľa PTH a kalcia. Nezačínať pri kalciu pod dolnou hranicou normy.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Vysoko viazaný na bielkoviny — nedialyzovateľný.',
        'warnings'       => 'Hypokalciémia (parestézie, kŕče, predĺženie QT); opatrne pri rizikových arytmiách.',
        'monitoring'     => 'Kalcium a fosfát (najmä na začiatku/po titrácii), PTH.',
    ],
    // ── Transplantácia / imunosupresia ────────────────────────────────────────
    'cyklosporin' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; niektoré glomerulopatie (napr. MCD/FSGS, membranózna).',
        'renal_dosing'   => "Dávkovať podľa hladín (TDM), nie podľa eGFR. Sám je nefrotoxický — cieľové hladiny podľa protokolu a obdobia po transplantácii.",
        'nephrotoxicity' => 'Akútna (hemodynamická, vazokonstrikcia, reverzibilná) aj chronická (intersticiálna fibróza/tubulárna atrofia, arteriolopatia); trombotická mikroangiopatia.',
        'dialyzability'  => 'Nedialyzovateľný (veľká, viazaná molekula).',
        'warnings'       => 'Hypertenzia, hyperkaliémia, hypomagneziémia, hyperurikémia, hirzutizmus, gingiválna hyperplázia; početné interakcie cez CYP3A4 (azoly, makrolidy, grapefruit).',
        'monitoring'     => 'Hladiny (trough), kreatinín, kálium, horčík, tlak.',
    ],
    'tacrolimus' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; niektoré glomerulopatie.',
        'renal_dosing'   => "Dávkovať podľa hladín (TDM), nie podľa eGFR. Sám je nefrotoxický — cieľové hladiny podľa protokolu a obdobia po transplantácii.",
        'nephrotoxicity' => 'Akútna aj chronická kalcineurín-inhibítorová nefrotoxicita; trombotická mikroangiopatia.',
        'dialyzability'  => 'Nedialyzovateľný (viazaný).',
        'warnings'       => 'Hyperkaliémia, hypomagneziémia, neurotoxicita (tremor), diabetogénny účinok, predĺženie QT; početné interakcie cez CYP3A4.',
        'monitoring'     => 'Hladiny (trough), kreatinín, kálium, horčík, glykémia.',
    ],
    'mykofenolat' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; lupusová nefritída a iné glomerulopatie.',
        'renal_dosing'   => "Úprava podľa eGFR zvyčajne nie je potrebná; pri ťažkej CKD a včasne po transplantácii sledovať toxicitu a podľa potreby upraviť dávku.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný (viazaný).',
        'warnings'       => 'Myelosupresia (leukopénia), GI intolerancia (hnačka), infekcie/PML; silná teratogenita — nutná spoľahlivá antikoncepcia.',
        'monitoring'     => 'Krvný obraz, infekčné prejavy.',
    ],
    // ── Nefrotoxické lieky (2. vlna) ──────────────────────────────────────────
    'aciklovir' => [
        'indications'    => 'Herpetické infekcie (HSV, VZV).',
        'renal_dosing'   => "Renálne eliminovaný — dávkovať podľa CrCl (znížiť dávku/predĺžiť interval). Pri i.v. podaní zabezpečiť dostatočnú hydratáciu a pomalú infúziu (prevencia kryštálovej nefropatie). Pri hemodialýze doplniť dávku po procedúre.",
        'nephrotoxicity' => 'Kryštálová nefropatia (intratubulárna precipitácia acikloviru) — najmä pri rýchlom i.v. boluse, dehydratácii a vysokých dávkach; zriedkavejšie akútna intersticiálna nefritída. Zvyčajne reverzibilná pri hydratácii.',
        'dialyzability'  => 'Dialyzovateľný — doplnková dávka po HD.',
        'warnings'       => 'Neurotoxicita (zmätenosť, myoklonus) pri kumulácii u CKD; pred i.v. podaním zabezpečiť hydratáciu.',
        'monitoring'     => 'Funkcia obličiek, hydratácia, neurologické príznaky.',
    ],
    'tenofovir' => [
        'indications'    => 'HIV infekcia, chronická hepatitída B.',
        'renal_dosing'   => "Tenofovir-dizoproxil (TDF) sa renálne eliminuje — dávkovať podľa CrCl (predĺžiť interval pri zníženej funkcii). Pri proximálnej tubulopatii zvážiť prechod na tenofovir-alafenamid (TAF, nižšia renálna/kostná toxicita).",
        'nephrotoxicity' => 'Proximálna tubulopatia (Fanconiho syndróm — glykozúria, fosfatúria, proteinúria, hypofosfatémia), pokles eGFR, nefrogénny diabetes insipidus; TDF > TAF.',
        'dialyzability'  => 'Dialyzovateľný — dávkovať podľa CrCl, pri HD upraviť interval.',
        'warnings'       => 'Sledovať fosfát, glykozúriu a proteinúriu; kostná demineralizácia.',
        'monitoring'     => 'eGFR, sérový fosfát, moč (glukóza, bielkovina) periodicky.',
    ],
    'amfotericin' => [
        'indications'    => 'Závažné systémové mykózy.',
        'renal_dosing'   => "Sám výrazne nefrotoxický — preferovať lipozomálnu formuláciu (nižšia nefrotoxicita), zabezpečiť hydratáciu a soľnú nálož; dávkovanie sa neriadi primárne podľa eGFR, liečbu však treba viesť opatrne.",
        'nephrotoxicity' => 'Renálna vazokonstrikcia a priame tubulárne poškodenie → pokles eGFR, renálne straty kália a horčíka (hypokaliémia, hypomagneziémia), renálna tubulárna acidóza, polyúria. Lipozomálna forma menej nefrotoxická.',
        'dialyzability'  => 'Nedialyzovateľný (veľká, viazaná molekula).',
        'warnings'       => 'Infúzne reakcie (horúčka, triaška), elektrolytové straty; pri renálnom riziku preferovať lipozomálnu formu.',
        'monitoring'     => 'Kreatinín, kálium a horčík často; bilancia tekutín.',
    ],
    // ── CKD-MBD, anémia a dialýza (2. vlna) ───────────────────────────────────
    'kalcitriol' => [
        'indications'    => 'Sekundárna hyperparatyreóza a hypokalciémia pri CKD; renálna osteodystrofia.',
        'renal_dosing'   => "Aktívny vitamín D (nevyžaduje renálnu 1α-hydroxyláciu) — dávka sa titruje podľa kalcia, fosfátu a PTH, nie podľa eGFR.",
        'nephrotoxicity' => 'Nie priamo; hyperkalciémia môže zhoršiť funkciu obličiek a podporiť nefrokalcinózu.',
        'dialyzability'  => 'Neaplikovateľné na dávkovanie (titrácia podľa laboratórnych hodnôt).',
        'warnings'       => 'Hyperkalciémia a hyperfosfatémia (riziko cievnej kalcifikácie) — pred začatím korigovať fosfát.',
        'monitoring'     => 'Kalcium, fosfát a PTH (najmä na začiatku a po titrácii).',
    ],
    'parikalcitol' => [
        'indications'    => 'Sekundárna hyperparatyreóza pri CKD (vrátane dialýzy).',
        'renal_dosing'   => "Selektívny aktivátor receptora pre vitamín D — titrácia podľa PTH a kalcia, bez úpravy podľa eGFR.",
        'nephrotoxicity' => 'Nie priamo; hyperkalciémia môže zhoršiť funkciu obličiek.',
        'dialyzability'  => 'Titrácia podľa laboratórnych hodnôt.',
        'warnings'       => 'Hyperkalciémia/hyperfosfatémia (menej výrazné ako kalcitriol); riziko adynamickej kostnej choroby pri nadmernej supresii PTH.',
        'monitoring'     => 'Kalcium, fosfát, PTH.',
    ],
    'roxadustat' => [
        'indications'    => 'Anémia pri chronickej chorobe obličiek (dialyzovaní aj nedialyzovaní).',
        'renal_dosing'   => "Perorálny inhibítor HIF-prolylhydroxylázy — dávka podľa hemoglobínu a telesnej hmotnosti, titrácia podľa odpovede; bez primárnej úpravy podľa eGFR.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Podľa SPC bez potreby doplnkovej dávky pri hemodialýze.',
        'warnings'       => 'Trombembolické príhody, hypertenzia; pred začatím doplniť deficit železa; cieľový hemoglobín neprestreľovať (KV riziko ako pri ESA).',
        'monitoring'     => 'Hemoglobín, zásoby železa, krvný tlak.',
    ],
    // ── Úprava dávky / nefroprotektíva (2. vlna) ──────────────────────────────
    'kolchicin' => [
        'indications'    => 'Dnavý záchvat a profylaxia, familiárna stredomorská horúčka (FMF), perikarditída.',
        'renal_dosing'   => "Pri zníženej funkcii obličiek znížiť dávku a predĺžiť interval; pri ťažkej CKD/dialýze sa kumuluje — opatrnosť, vyhnúť sa kumulatívnej profylaxii. Nebezpečné interakcie s inhibítormi CYP3A4/P-gp (makrolidy, azoly, cyklosporín, statíny).",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný (veľký distribučný objem) — HD pri toxicite neúčinná.',
        'warnings'       => 'Úzke terapeutické okno — pri CKD a liekových interakciách riziko ťažkej toxicity (myelosupresia, neuromyopatia, multiorgánové zlyhanie).',
        'monitoring'     => 'Krvný obraz, svalové príznaky (CK), liekové interakcie.',
    ],
    'dulaglutid' => [
        'indications'    => 'Diabetes 2. typu; kardiovaskulárny benefit (REWIND).',
        'renal_dosing'   => "Úprava dávky podľa funkcie obličiek nie je potrebná; obmedzené skúsenosti pri terminálnom zlyhaní obličiek. Titrovať pre GI toleranciu.",
        'nephrotoxicity' => 'Nie je nefrotoxický; ťažké GI nežiaduce účinky môžu dehydratáciou vyvolať prerenálne AKI.',
        'dialyzability'  => 'Nedialyzovateľný (veľká, viazaná molekula).',
        'warnings'       => 'Nauzea/vracanie → riziko hypovolémie a AKI; pankreatitída.',
        'monitoring'     => 'Funkcia obličiek pri výrazných GI ťažkostiach.',
    ],
];

$updated = 0;
$skipped = 0;
$missing = [];

foreach ($curation as $slug => $fields) {
    $set = [];
    $params = ['slug' => $slug];
    foreach ($fields as $col => $val) {
        if (!in_array($col, DG_CUR_COLS, true)) {
            continue;
        }
        $set[] = "$col = :$col";
        $params[$col] = $val;
    }
    if ($set === []) {
        $skipped++;
        continue;
    }
    /** @var \PDO $pdo */
    $stmt = $pdo->prepare('UPDATE drugs SET ' . implode(', ', $set) . ' WHERE slug = :slug');
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $updated++;
    } else {
        // rowCount 0 = buď slug neexistuje, alebo hodnoty rovnaké (idempotentné spustenie).
        $chk = $pdo->prepare('SELECT 1 FROM drugs WHERE slug = :slug LIMIT 1');
        $chk->execute(['slug' => $slug]);
        if ($chk->fetchColumn() === false) {
            $missing[] = $slug;
        } else {
            $updated++; // existuje, len bez zmeny
        }
    }
}

echo "──────────────────────────────────────────────────────\n";
echo "Kurácia liekov (NÁVRH — overte pred zverejnením)\n";
echo "──────────────────────────────────────────────────────\n";
echo 'Aktualizovaných: ' . $updated . "\n";
echo 'Bez polí:        ' . $skipped . "\n";
if ($missing !== []) {
    echo 'Chýbajúci slug (spustite najprv sync_drugs.php): ' . implode(', ', $missing) . "\n";
}
echo "Lieky ostávajú NEZVEREJNENÉ — skontrolujte a zverejnite v admin_drugs.php.\n";
