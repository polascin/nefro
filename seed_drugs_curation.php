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
 * DIALYZOVATEĽNOSŤ: pole `dialyzability` je zostavené z determinantov odstrániteľnosti
 * pri hemodialýze — molekulová hmotnosť (MW), väzba na plazmatické bielkoviny (PB) a
 * distribučný objem (Vd) — doplnené o praktický dôsledok (doplnková dávka po HD, použitie
 * HD pri intoxikácii). Zdroje: štandardná klinická farmakológia (SPC/EMA/ŠÚKL), KDIGO a
 * pri intoxikáciách odporúčania EXTRIP. Hodnoty sú orientačné — vždy overte v aktuálnom SPC.
 *
 * ZDROJE (source_refs): skript po kurácii pridá ku každému lieku overený odkaz na SPC v
 * registri DailyMed (NIH) — MERGE, ktorý zachová EMA EPAR odkazy doplnené synchronizáciou
 * z ChEMBL aj prípadné ručné admin úpravy (dedup, idempotentné).
 *
 * POZNÁMKA: údaje NEPREBERÁME z cudzích databáz (vrátane nephroresource.com) — staviame
 * z primárnych autoritatívnych zdrojov (pozri PLAN_NEPHRORESOURCE.md, časť 8).
 *
 * Predpoklad: liek už existuje v `drugs` (najprv spustite sync_drugs.php).
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
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~91 %) a veľký distribučný objem; HD ho neodstráni. Pri dialýze bez renálneho/glykemického prínosu (neindikovaný na zníženie glykémie).',
        'warnings'       => 'Euglykemická diabetická ketoacidóza (vysadiť pri akútnom ochorení a pred operáciou), genitálne mykotické infekcie, volumová deplécia; zriedkavo Fournierova gangréna.',
        'monitoring'     => 'eGFR a objemový stav pred liečbou a počas nej.',
    ],
    'empagliflozin' => [
        'indications'    => 'Chronická choroba obličiek, srdcové zlyhanie, diabetes 2. typu.',
        'renal_dosing'   => "Pri CKD možno začať a pokračovať do eGFR ~ 20 ml/min/1,73 m² (EMPA-KIDNEY). Glykemický účinok klesá pri eGFR < 45. Pri akútnom ochorení/dehydratácii prechodne vysadiť.",
        'nephrotoxicity' => 'Nie je nefrotoxický (nefroprotektívny); po začatí možný reverzibilný „dip“ eGFR.',
        'dialyzability'  => 'Minimálne dialyzovateľný — väzba na bielkoviny ~86 %, distribučný objem ~74 l; pri HD bez klinického prínosu.',
        'warnings'       => 'Euglykemická ketoacidóza, genitálne infekcie, volumová deplécia.',
        'monitoring'     => 'eGFR a objemový stav pred liečbou a počas nej.',
    ],
    'finerenon' => [
        'indications'    => 'Chronická choroba obličiek pri diabete 2. typu (spomalenie progresie, zníženie KV rizika).',
        'renal_dosing'   => "Nezačínať pri K⁺ > 5,0 mmol/l. Iniciácia podľa eGFR (10 alebo 20 mg/d), pri eGFR < 25 sa začatie neodporúča; pokračovanie a titrácia podľa kália a eGFR. Vyhnúť sa silným inhibítorom CYP3A4.",
        'nephrotoxicity' => 'Nie je nefrotoxický (nefroprotektívny).',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~92 %); HD ho neodstráni.',
        'warnings'       => 'Hyperkaliémia (najmä so súbehom ACEi/ARB, ďalších kálium-šetriacich liekov); kontraindikácia pri Addisonovej chorobe.',
        'monitoring'     => 'Kálium o ~ 4 týždne po začatí/zmene dávky, potom pravidelne; eGFR.',
    ],
    'losartan' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie, nefroprotekcia.',
        'renal_dosing'   => "Začať nižšou dávkou a titrovať. Vzostup kreatinínu do ~ 30 % po začatí je akceptovateľný (hemodynamický); väčší vzostup alebo hyperkaliémia → prehodnotiť (vylúčiť stenózu renálnej artérie, hypovolémiu).",
        'nephrotoxicity' => 'Hemodynamické zhoršenie funkcie pri hypovolémii, súbehu s NSAID/diuretikom alebo kontrastom.',
        'dialyzability'  => 'Nedialyzovateľný — losartan aj aktívny metabolit E-3174 sú > 98 % viazané na bielkoviny; HD ani PD ich neodstránia.',
        'warnings'       => 'Hyperkaliémia; kontraindikovaný v gravidite; vysadiť pri akútnej hypovolémii/pred kontrastom podľa rizika.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'valsartan' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie.',
        'renal_dosing'   => "Začať nižšou dávkou a titrovať. Vzostup kreatinínu do ~ 30 % je akceptovateľný; väčší vzostup/hyperkaliémia → prehodnotiť.",
        'nephrotoxicity' => 'Hemodynamické zhoršenie pri hypovolémii/súbehu s NSAID/kontrastom.',
        'dialyzability'  => 'Nedialyzovateľný — väzba na bielkoviny ~95 %, malý distribučný objem (~17 l); HD ho neodstráni.',
        'warnings'       => 'Hyperkaliémia; kontraindikovaný v gravidite.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'ramipril' => [
        'indications'    => 'Proteinurická/diabetická CKD, hypertenzia, srdcové zlyhanie, nefroprotekcia.',
        'renal_dosing'   => "Renálne eliminovaný — pri eGFR < 30 znížiť úvodnú a udržiavaciu dávku a titrovať. Vzostup kreatinínu do ~ 30 % je akceptovateľný; väčší vzostup/hyperkaliémia → prehodnotiť.",
        'nephrotoxicity' => 'Hemodynamické zhoršenie pri hypovolémii, NSAID, kontraste; pozor pri obojstrannej stenóze renálnych artérií.',
        'dialyzability'  => 'Čiastočne dialyzovateľný — aktívny ramiprilát je stredne viazaný (~56 %) a renálne eliminovaný; HD znižuje jeho hladiny. Zvážiť dávku po HD.',
        'warnings'       => 'Hyperkaliémia, suchý kašeľ, angioedém; kontraindikovaný v gravidite. Pri dialýze cez high-flux/AN69 membrány riziko anafylaktoidných reakcií.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'spironolakton' => [
        'indications'    => 'Rezistentná hypertenzia, srdcové zlyhanie, edémy, primárny hyperaldosteronizmus.',
        'renal_dosing'   => "Riziko hyperkaliémie rastie s poklesom eGFR. Vyhnúť sa pri eGFR < 30 a pri K⁺ > 5,0 mmol/l; pri eGFR 30–45 opatrne, nízka dávka a častá kontrola kália.",
        'nephrotoxicity' => 'Nie priamo nefrotoxický; aktívne metabolity sa kumulujú pri zlyhaní obličiek.',
        'dialyzability'  => 'Nedialyzovateľný — spironolaktón aj aktívne metabolity (kanrenón) sú > 90 % viazané na bielkoviny; metabolity sa pri zlyhaní obličiek kumulujú.',
        'warnings'       => 'Hyperkaliémia (najmä so súbehom ACEi/ARB), gynekomastia.',
        'monitoring'     => 'Kálium a kreatinín 3–7 dní po začatí/zmene, potom pravidelne.',
    ],
    'semaglutid' => [
        'indications'    => 'Diabetes 2. typu, obezita; KV/renálne benefity (FLOW pri CKD a DM2).',
        'renal_dosing'   => "Úprava dávky podľa funkcie obličiek nie je potrebná; obmedzené skúsenosti pri terminálnom zlyhaní obličiek. Titrovať pomaly pre GI toleranciu.",
        'nephrotoxicity' => 'Nie je nefrotoxický; ťažké GI nežiaduce účinky (vracanie, hnačka) môžu dehydratáciou vyvolať prerenálne AKI.',
        'dialyzability'  => 'Nedialyzovateľný — veľká peptidová molekula viazaná na albumín (~99 %); HD ju neodstráni.',
        'warnings'       => 'Nauzea/vracanie → riziko hypovolémie a AKI; pankreatitída; diabetická retinopatia.',
        'monitoring'     => 'Funkcia obličiek pri výrazných GI ťažkostiach; hydratácia.',
    ],
    // ── Diuretiká ─────────────────────────────────────────────────────────────
    'furosemid' => [
        'indications'    => 'Edémy a objemové preťaženie pri CKD/srdcovom/hepatálnom zlyhaní, hypertenzia pri pokročilej CKD.',
        'renal_dosing'   => "Pri CKD často potrebné vyššie dávky (znížená tubulárna sekrécia do lúmenu); dávku titrovať podľa diuretickej odpovede. Pri rezistencii zvážiť kombináciu s tiazidom. Neúčinný pri anúrii/ESRD.",
        'nephrotoxicity' => 'Nadmerná diuréza → prerenálne AKI; ototoxicita pri vysokých i.v. dávkach a rýchlom podaní.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~95–99 %); HD ho neodstráni.',
        'warnings'       => 'Hypokaliémia, hyponatriémia, hypomagneziémia, hypovolémia, ototoxicita, hyperurikémia.',
        'monitoring'     => 'Elektrolyty (K, Na, Mg), objemový stav a funkcia obličiek.',
    ],
    'torazemid' => [
        'indications'    => 'Edémy a objemové preťaženie, hypertenzia; predvídateľnejšia biodostupnosť ako furosemid.',
        'renal_dosing'   => "Pri CKD často vyššie dávky; lepšia a stálejšia perorálna biodostupnosť ako furosemid. Titrovať podľa odpovede; neúčinný pri anúrii.",
        'nephrotoxicity' => 'Nadmerná diuréza → prerenálne AKI; ototoxicita (nižšia ako furosemid).',
        'dialyzability'  => 'Nedialyzovateľný — väzba na bielkoviny ~99 %; klírens hemodialýzou zanedbateľný.',
        'warnings'       => 'Hypokaliémia, hyponatriémia, hypovolémia, hyperurikémia.',
        'monitoring'     => 'Elektrolyty, objemový stav, funkcia obličiek.',
    ],
    'hydrochlorotiazid' => [
        'indications'    => 'Hypertenzia, edémy; pri CKD ako prídavok k slučkovému diuretiku (rezistencia).',
        'renal_dosing'   => "Účinnosť v monoterapii klesá pri eGFR < 30 (tiazidy bývajú neúčinné). Pri pokročilej CKD preferovať slučkové diuretiká alebo kombináciu tiazid + slučka pri diuretickej rezistencii.",
        'nephrotoxicity' => 'Hypovolémia → prerenálne AKI; idiosynkratická intersticiálna nefritída zriedkavo.',
        'dialyzability'  => 'Pri ESRD neúčinný a neindikovaný (tiazid vyžaduje tubulárnu sekréciu); HD ho čiastočne odstráni, no klinicky to nemá význam.',
        'warnings'       => 'Hyponatriémia, hypokaliémia, hyperurikémia, hyperkalciémia, hyperglykémia, fotosenzitivita; kumulatívne riziko nemelanómového kožného karcinómu.',
        'monitoring'     => 'Elektrolyty (Na, K), urát, glykémia.',
    ],
    // ── Úprava dávky podľa obličiek ───────────────────────────────────────────
    'metformin' => [
        'indications'    => 'Diabetes 2. typu (liek prvej voľby).',
        'renal_dosing'   => "Kontraindikovaný pri eGFR < 30. Pri eGFR 30–44 nezačínať; ak už užíva, prehodnotiť a zvážiť zníženie dávky (napr. max ~ 1000 mg/d) a zvýšenú opatrnosť. Vysadiť pri akútnom ochorení, dehydratácii a pred podaním jódovej kontrastnej látky (sick-day pravidlá).",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický; pri kumulácii riziko laktátovej acidózy.',
        'dialyzability'  => 'Dobre dialyzovateľný — nízka MW (129 Da), prakticky bez väzby na bielkoviny; hemodialýza je liečbou ťažkej laktátovej acidózy/predávkovania (odstraňuje metformín aj laktát).',
        'warnings'       => 'Laktátová acidóza (zriedkavá, ale závažná) — riziko pri zlyhaní obličiek, hypoxii, sepse.',
        'monitoring'     => 'eGFR aspoň 1×/rok, pri eGFR < 45 častejšie.',
    ],
    'alopurinol' => [
        'indications'    => 'Chronická dna, hyperurikémia; prevencia uráthovej nefropatie/nefrolitiázy.',
        'renal_dosing'   => "Aktívny metabolit oxypurinol sa pri zníženej funkcii obličiek kumuluje. Začať nízkou dávkou (napr. 50–100 mg/d) a pomaly titrovať podľa cieľového urátu; opatrne pri eGFR < 30.",
        'nephrotoxicity' => 'Nie priamo; alopurinolová hypersenzitivita môže zahŕňať intersticiálnu nefritídu.',
        'dialyzability'  => 'Oxypurinol je dialyzovateľný (nízka väzba na bielkoviny, malá molekula) — pri intermitentnej HD dávkovať po procedúre.',
        'warnings'       => 'Závažné kožné reakcie (SJS/TEN, DRESS) — vyššie riziko pri CKD a nosičstve HLA-B*58:01; zvážiť skríning v rizikových populáciách. Interakcia s azatioprínom/merkaptopurínom (inhibícia xantínoxidázy).',
        'monitoring'     => 'Sérový urát, kožné prejavy, krvný obraz a pečeňové testy na začiatku.',
    ],
    'gabapentin' => [
        'indications'    => 'Neuropatická bolesť (aj uremický pruritus a syndróm nepokojných nôh pri CKD), epilepsia.',
        'renal_dosing'   => "Takmer výhradne renálna eliminácia — dávkovať podľa CrCl a progresívne znižovať (CrCl 30–59, 15–29, < 15). Pri hemodialýze podať doplnkovú dávku po procedúre. „Bežné“ dávky pri CKD často spôsobujú toxicitu.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Vysoko dialyzovateľný — nízka MW (171 Da), zanedbateľná väzba na bielkoviny; HD ho účinne odstraňuje → doplnková dávka po každej procedúre.',
        'warnings'       => 'Kumulácia → sedácia, závrat, ataxia, myoklonus, respiračná depresia (najmä so súbehom opioidov).',
        'monitoring'     => 'Klinické príznaky toxicity, funkcia obličiek.',
    ],
    // ── Nefrotoxické lieky ────────────────────────────────────────────────────
    'gentamicin' => [
        'indications'    => 'Závažné gramnegatívne infekcie (zvyčajne kombinovaná liečba).',
        'renal_dosing'   => "Výrazne nefrotoxický — dávkovať podľa funkcie obličiek a hladín; pri zníženom eGFR predĺžiť interval. Preferovať režim raz denne a terapeutické monitorovanie hladín; minimalizovať dĺžku liečby.",
        'nephrotoxicity' => 'Akútna tubulárna nekróza (často neoligurická, zvyčajne reverzibilná); riziko rastie s kumulatívnou dávkou, dĺžkou liečby, hypovolémiou a súbehom ďalších nefrotoxínov.',
        'dialyzability'  => 'Dialyzovateľný — malá molekula, minimálna väzba na bielkoviny, malý distribučný objem (~0,25 l/kg); HD odstráni ~50 % za procedúru. Dávkovať podľa hladín a doplniť po HD.',
        'warnings'       => 'Nefro- a ototoxicita (vestibulárna/kochleárna, môže byť ireverzibilná); vyhnúť sa súbehu s inými nefrotoxínmi.',
        'monitoring'     => 'Hladiny (trough/peak), kreatinín/eGFR denne–obdeň, sluch/rovnováha.',
    ],
    'vankomycin' => [
        'indications'    => 'Závažné grampozitívne infekcie (vrátane MRSA); perorálne pri C. difficile.',
        'renal_dosing'   => "Dávkovať podľa funkcie obličiek a cieľovej expozície (preferovaný AUC/MIC, alt. trough). Pri CKD a dialýze individuálne podľa hladín. Perorálna forma pri kolitíde sa nevstrebáva.",
        'nephrotoxicity' => 'Nefrotoxicita najmä pri vyššej expozícii (vysoký trough), dlhšej liečbe a súbehu s piperacilín-tazobaktámom; zvyčajne reverzibilná.',
        'dialyzability'  => 'Závisí od membrány — pri high-flux dialyzátoroch sa odstráni ~25–50 % (väzba na bielkoviny ~50 %), pri low-flux minimálne. Dávkovať podľa hladín a často redávkovať po HD pri high-flux.',
        'warnings'       => 'Infúzna reakcia („vancomycin flushing“), oto-/nefrotoxicita; opatrnosť so súbežnými nefrotoxínmi.',
        'monitoring'     => 'Hladiny (AUC-riadené preferované), kreatinín/eGFR.',
    ],
    'cisplatina' => [
        'indications'    => 'Solídne nádory (onkonefrológia).',
        'renal_dosing'   => "Výrazne nefrotoxická — pri zníženej funkcii obličiek redukcia dávky/odklad/alternatíva. Povinná intenzívna hydratácia (± Mg suplementácia); pozri Gupta CP-AKI rizikové skóre.",
        'nephrotoxicity' => 'Dávka-závislá toxicita proximálneho tubulu, renálne straty horčíka (hypomagneziémia), soľný-wasting, akútne aj chronické zníženie eGFR.',
        'dialyzability'  => 'Voľná platina je krátko po podaní čiastočne dialyzovateľná, no platina ireverzibilne viazaná na bielkoviny nie — dialýza po fixácii toxicite nezabráni.',
        'warnings'       => 'Nefro-, oto- a neurotoxicita; profylaxia hydratáciou a korekciou Mg.',
        'monitoring'     => 'eGFR a elektrolyty (Mg, K) pred každým cyklom; bilancia tekutín.',
    ],
    'ibuprofen' => [
        'indications'    => 'Bolesť, zápal, horúčka (v nefrológii skôr liek, ktorému sa vyhýbame).',
        'renal_dosing'   => "Vyhnúť sa pri pokročilej CKD; ak je nevyhnutný, najnižšia účinná dávka čo najkratšie. Vyhnúť sa „triple whammy“ (ACEi/ARB + diuretikum + NSAID) a podaniu pri hypovolémii.",
        'nephrotoxicity' => 'Hemodynamické AKI (inhibícia prostaglandínov → vazokonstrikcia aferentnej arterioly), retencia sodíka a vody, hyperkaliémia, akútna intersticiálna nefritída, papilárna nekróza, zhoršenie CKD.',
        'dialyzability'  => 'Nedialyzovateľný — väzba na bielkoviny ~99 %, malý distribučný objem; HD ho neodstráni.',
        'warnings'       => 'Vyhnúť sa pri CKD, srdcovom zlyhaní a cirhóze; GI a kardiovaskulárne riziko.',
        'monitoring'     => 'Funkcia obličiek, kálium a tlak pri nevyhnutnom použití.',
    ],
    // ── Lieky a dialýza / CKD-MBD ─────────────────────────────────────────────
    'sevelamer' => [
        'indications'    => 'Hyperfosfatémia pri CKD/dialýze.',
        'renal_dosing'   => "Dávkovať podľa sérového fosfátu; užívať s jedlom. Nevstrebáva sa systémovo, preto netreba úpravu podľa eGFR.",
        'nephrotoxicity' => 'Bez systémovej toxicity (pôsobí v GIT).',
        'dialyzability'  => 'Neaplikovateľné — nevstrebáva sa, pôsobí lokálne v lúmene čreva (viazač fosfátov); v krvi necirkuluje.',
        'warnings'       => 'GI ťažkosti; môže viazať niektoré súbežné lieky (časový odstup); forma s chloridom môže prispieť k metabolickej acidóze (na rozdiel od karbonátu).',
        'monitoring'     => 'Sérový fosfát, kalcium a bikarbonát.',
    ],
    'cinakalcet' => [
        'indications'    => 'Sekundárna hyperparatyreóza pri dialýze; hyperkalciémia pri karcinóme prištítnych teliesok.',
        'renal_dosing'   => "Bez úpravy podľa eGFR — dávka sa titruje podľa PTH a kalcia. Nezačínať pri kalciu pod dolnou hranicou normy.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~93–97 %); dávka sa titruje podľa PTH a kalcia, nie podľa dialýzy.',
        'warnings'       => 'Hypokalciémia (parestézie, kŕče, predĺženie QT); opatrne pri rizikových arytmiách.',
        'monitoring'     => 'Kalcium a fosfát (najmä na začiatku/po titrácii), PTH.',
    ],
    // ── Transplantácia / imunosupresia ────────────────────────────────────────
    'cyklosporin' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; niektoré glomerulopatie (napr. MCD/FSGS, membranózna).',
        'renal_dosing'   => "Dávkovať podľa hladín (TDM), nie podľa eGFR. Sám je nefrotoxický — cieľové hladiny podľa protokolu a obdobia po transplantácii.",
        'nephrotoxicity' => 'Akútna (hemodynamická, vazokonstrikcia, reverzibilná) aj chronická (intersticiálna fibróza/tubulárna atrofia, arteriolopatia); trombotická mikroangiopatia.',
        'dialyzability'  => 'Nedialyzovateľný — veľká, vysoko lipofilná molekula (MW 1203 Da) viazaná na lipoproteíny a erytrocyty, veľký distribučný objem; HD ani PD ju neodstránia. Dávkovať podľa hladín.',
        'warnings'       => 'Hypertenzia, hyperkaliémia, hypomagneziémia, hyperurikémia, hirzutizmus, gingiválna hyperplázia; početné interakcie cez CYP3A4 (azoly, makrolidy, grapefruit).',
        'monitoring'     => 'Hladiny (trough), kreatinín, kálium, horčík, tlak.',
    ],
    'tacrolimus' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; niektoré glomerulopatie.',
        'renal_dosing'   => "Dávkovať podľa hladín (TDM), nie podľa eGFR. Sám je nefrotoxický — cieľové hladiny podľa protokolu a obdobia po transplantácii.",
        'nephrotoxicity' => 'Akútna aj chronická kalcineurín-inhibítorová nefrotoxicita; trombotická mikroangiopatia.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny a erytrocyty (~99 %), veľký distribučný objem; HD ho neodstráni.',
        'warnings'       => 'Hyperkaliémia, hypomagneziémia, neurotoxicita (tremor), diabetogénny účinok, predĺženie QT; početné interakcie cez CYP3A4.',
        'monitoring'     => 'Hladiny (trough), kreatinín, kálium, horčík, glykémia.',
    ],
    'mykofenolat' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; lupusová nefritída a iné glomerulopatie.',
        'renal_dosing'   => "Úprava podľa eGFR zvyčajne nie je potrebná; pri ťažkej CKD a včasne po transplantácii sledovať toxicitu a podľa potreby upraviť dávku.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — kyselina mykofenolová je ~97 % viazaná na albumín; HD ju klinicky neodstráni (pri urémii väzba klesá a voľná frakcia rastie).',
        'warnings'       => 'Myelosupresia (leukopénia), GI intolerancia (hnačka), infekcie/PML; silná teratogenita — nutná spoľahlivá antikoncepcia.',
        'monitoring'     => 'Krvný obraz, infekčné prejavy.',
    ],
    // ── Nefrotoxické lieky (2. vlna) ──────────────────────────────────────────
    'aciklovir' => [
        'indications'    => 'Herpetické infekcie (HSV, VZV).',
        'renal_dosing'   => "Renálne eliminovaný — dávkovať podľa CrCl (znížiť dávku/predĺžiť interval). Pri i.v. podaní zabezpečiť dostatočnú hydratáciu a pomalú infúziu (prevencia kryštálovej nefropatie). Pri hemodialýze doplniť dávku po procedúre.",
        'nephrotoxicity' => 'Kryštálová nefropatia (intratubulárna precipitácia acikloviru) — najmä pri rýchlom i.v. boluse, dehydratácii a vysokých dávkach; zriedkavejšie akútna intersticiálna nefritída. Zvyčajne reverzibilná pri hydratácii.',
        'dialyzability'  => 'Dobre dialyzovateľný — nízka MW (225 Da), nízka väzba na bielkoviny (~15–30 %); HD odstráni ~60 % → doplnková dávka po procedúre.',
        'warnings'       => 'Neurotoxicita (zmätenosť, myoklonus) pri kumulácii u CKD; pred i.v. podaním zabezpečiť hydratáciu.',
        'monitoring'     => 'Funkcia obličiek, hydratácia, neurologické príznaky.',
    ],
    'tenofovir' => [
        'indications'    => 'HIV infekcia, chronická hepatitída B.',
        'renal_dosing'   => "Tenofovir-dizoproxil (TDF) sa renálne eliminuje — dávkovať podľa CrCl (predĺžiť interval pri zníženej funkcii). Pri proximálnej tubulopatii zvážiť prechod na tenofovir-alafenamid (TAF, nižšia renálna/kostná toxicita).",
        'nephrotoxicity' => 'Proximálna tubulopatia (Fanconiho syndróm — glykozúria, fosfatúria, proteinúria, hypofosfatémia), pokles eGFR, nefrogénny diabetes insipidus; TDF > TAF.',
        'dialyzability'  => 'Dialyzovateľný — nízka väzba na bielkoviny (< 7 %); ~4-hodinová HD odstráni časť dávky. Pri HD dávkovať po procedúre.',
        'warnings'       => 'Sledovať fosfát, glykozúriu a proteinúriu; kostná demineralizácia.',
        'monitoring'     => 'eGFR, sérový fosfát, moč (glukóza, bielkovina) periodicky.',
    ],
    'amfotericin' => [
        'indications'    => 'Závažné systémové mykózy.',
        'renal_dosing'   => "Sám výrazne nefrotoxický — preferovať lipozomálnu formuláciu (nižšia nefrotoxicita), zabezpečiť hydratáciu a soľnú nálož; dávkovanie sa neriadi primárne podľa eGFR, liečbu však treba viesť opatrne.",
        'nephrotoxicity' => 'Renálna vazokonstrikcia a priame tubulárne poškodenie → pokles eGFR, renálne straty kália a horčíka (hypokaliémia, hypomagneziémia), renálna tubulárna acidóza, polyúria. Lipozomálna forma menej nefrotoxická.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~90 %), veľká molekula; HD ho neodstráni.',
        'warnings'       => 'Infúzne reakcie (horúčka, triaška), elektrolytové straty; pri renálnom riziku preferovať lipozomálnu formu.',
        'monitoring'     => 'Kreatinín, kálium a horčík často; bilancia tekutín.',
    ],
    // ── CKD-MBD, anémia a dialýza (2. vlna) ───────────────────────────────────
    'kalcitriol' => [
        'indications'    => 'Sekundárna hyperparatyreóza a hypokalciémia pri CKD; renálna osteodystrofia.',
        'renal_dosing'   => "Aktívny vitamín D (nevyžaduje renálnu 1α-hydroxyláciu) — dávka sa titruje podľa kalcia, fosfátu a PTH, nie podľa eGFR.",
        'nephrotoxicity' => 'Nie priamo; hyperkalciémia môže zhoršiť funkciu obličiek a podporiť nefrokalcinózu.',
        'dialyzability'  => 'Neaplikovateľné na dávkovanie — vysoko viazaný na vitamín-D viažuci proteín; titruje sa podľa kalcia, fosfátu a PTH.',
        'warnings'       => 'Hyperkalciémia a hyperfosfatémia (riziko cievnej kalcifikácie) — pred začatím korigovať fosfát.',
        'monitoring'     => 'Kalcium, fosfát a PTH (najmä na začiatku a po titrácii).',
    ],
    'parikalcitol' => [
        'indications'    => 'Sekundárna hyperparatyreóza pri CKD (vrátane dialýzy).',
        'renal_dosing'   => "Selektívny aktivátor receptora pre vitamín D — titrácia podľa PTH a kalcia, bez úpravy podľa eGFR.",
        'nephrotoxicity' => 'Nie priamo; hyperkalciémia môže zhoršiť funkciu obličiek.',
        'dialyzability'  => 'Nedialyzovateľný — vysoko viazaný na bielkoviny; dávka sa titruje podľa PTH a kalcia (vrátane dialyzovaných pacientov).',
        'warnings'       => 'Hyperkalciémia/hyperfosfatémia (menej výrazné ako kalcitriol); riziko adynamickej kostnej choroby pri nadmernej supresii PTH.',
        'monitoring'     => 'Kalcium, fosfát, PTH.',
    ],
    'roxadustat' => [
        'indications'    => 'Anémia pri chronickej chorobe obličiek (dialyzovaní aj nedialyzovaní).',
        'renal_dosing'   => "Perorálny inhibítor HIF-prolylhydroxylázy — dávka podľa hemoglobínu a telesnej hmotnosti, titrácia podľa odpovede; bez primárnej úpravy podľa eGFR.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Bez potreby doplnkovej dávky pri hemodialýze (SPC) — vysoká väzba na bielkoviny (~99 %); podáva sa nezávisle od dialýzy.',
        'warnings'       => 'Trombembolické príhody, hypertenzia; pred začatím doplniť deficit železa; cieľový hemoglobín neprestreľovať (KV riziko ako pri ESA).',
        'monitoring'     => 'Hemoglobín, zásoby železa, krvný tlak.',
    ],
    // ── Úprava dávky / nefroprotektíva (2. vlna) ──────────────────────────────
    'kolchicin' => [
        'indications'    => 'Dnavý záchvat a profylaxia, familiárna stredomorská horúčka (FMF), perikarditída.',
        'renal_dosing'   => "Pri zníženej funkcii obličiek znížiť dávku a predĺžiť interval; pri ťažkej CKD/dialýze sa kumuluje — opatrnosť, vyhnúť sa kumulatívnej profylaxii. Nebezpečné interakcie s inhibítormi CYP3A4/P-gp (makrolidy, azoly, cyklosporín, statíny).",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — veľký distribučný objem (~5–8 l/kg) napriek nízkej väzbe na bielkoviny; HD pri toxicite neúčinná.',
        'warnings'       => 'Úzke terapeutické okno — pri CKD a liekových interakciách riziko ťažkej toxicity (myelosupresia, neuromyopatia, multiorgánové zlyhanie).',
        'monitoring'     => 'Krvný obraz, svalové príznaky (CK), liekové interakcie.',
    ],
    'dulaglutid' => [
        'indications'    => 'Diabetes 2. typu; kardiovaskulárny benefit (REWIND).',
        'renal_dosing'   => "Úprava dávky podľa funkcie obličiek nie je potrebná; obmedzené skúsenosti pri terminálnom zlyhaní obličiek. Titrovať pre GI toleranciu.",
        'nephrotoxicity' => 'Nie je nefrotoxický; ťažké GI nežiaduce účinky môžu dehydratáciou vyvolať prerenálne AKI.',
        'dialyzability'  => 'Nedialyzovateľný — veľká fúzna proteínová molekula (Fc-GLP-1); HD ju neodstráni.',
        'warnings'       => 'Nauzea/vracanie → riziko hypovolémie a AKI; pankreatitída.',
        'monitoring'     => 'Funkcia obličiek pri výrazných GI ťažkostiach.',
    ],
    // ── Nefroprotektíva (3. vlna) ─────────────────────────────────────────────
    'kanagliflozin' => [
        'indications'    => 'Diabetes 2. typu; diabetická choroba obličiek (CREDENCE — spomalenie progresie); zníženie KV rizika.',
        'renal_dosing'   => "Pri diabetickej CKD možno začať pri eGFR ≥ 30 ml/min/1,73 m² (v CREDENCE 100 mg/d) a pokračovať aj pri ďalšom poklese až do dialýzy. Glykemický účinok klesá pri eGFR < 45. Pri akútnom ochorení/dehydratácii prechodne vysadiť (sick-day pravidlá).",
        'nephrotoxicity' => 'Nefroprotektívny; po začatí možný reverzibilný „dip“ eGFR. Vyššie riziko volumovej deplécie pri súbehu s diuretikom.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~99 %), veľký distribučný objem (~119 l); pri dialýze bez glykemického/renálneho prínosu.',
        'warnings'       => 'Euglykemická ketoacidóza, genitálne mykotické infekcie, volumová deplécia; zvýšené riziko amputácií dolných končatín a fraktúr (CANVAS); Fournierova gangréna.',
        'monitoring'     => 'eGFR, objemový stav, stav dolných končatín; ketolátky pri podozrení na DKA.',
    ],
    'enalapril' => [
        'indications'    => 'Hypertenzia, srdcové zlyhanie, proteinurická/diabetická CKD (nefroprotekcia).',
        'renal_dosing'   => "Renálne eliminovaný (aktívny enaláprilát) — pri eGFR < 30 znížiť úvodnú dávku a titrovať. Vzostup kreatinínu do ~ 30 % po začatí je akceptovateľný; väčší vzostup alebo hyperkaliémia → prehodnotiť (vylúčiť stenózu renálnej artérie, hypovolémiu).",
        'nephrotoxicity' => 'Hemodynamické zhoršenie funkcie pri hypovolémii, súbehu s NSAID/diuretikom alebo kontrastom; pozor pri obojstrannej stenóze renálnych artérií.',
        'dialyzability'  => 'Dialyzovateľný — aktívny enaláprilát je stredne viazaný (~50–60 %) a renálne eliminovaný; HD znižuje hladiny → zvážiť dávku po HD. Pri high-flux/AN69 membránach riziko anafylaktoidných reakcií.',
        'warnings'       => 'Hyperkaliémia, suchý kašeľ, angioedém; kontraindikovaný v gravidite.',
        'monitoring'     => 'Kreatinín a kálium 1–2 týždne po začatí a po titrácii.',
    ],
    'eplerenon' => [
        'indications'    => 'Srdcové zlyhanie po infarkte myokardu, hypertenzia; selektívnejší MRA ako spironolaktón (menej gynekomastie).',
        'renal_dosing'   => "Riziko hyperkaliémie rastie s poklesom eGFR. Kontraindikovaný pri eGFR < 30 (pri hypertenznej indikácii < 50) a pri K⁺ > 5,0 mmol/l. Vyhnúť sa silným inhibítorom CYP3A4.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — HD ho neodstraňuje v klinicky významnom rozsahu; pri ťažkej CKD kontraindikovaný pre riziko hyperkaliémie.',
        'warnings'       => 'Hyperkaliémia (najmä so súbehom ACEi/ARB); menej hormonálnych vedľajších účinkov ako spironolaktón.',
        'monitoring'     => 'Kálium a kreatinín 3–7 dní po začatí/zmene, potom pravidelne.',
    ],
    // ── Diuretiká (3. vlna) ───────────────────────────────────────────────────
    'indapamid' => [
        'indications'    => 'Hypertenzia; mierne (tiazidu podobné) diuretikum.',
        'renal_dosing'   => "Účinnosť klesá pri eGFR < 30 (ako tiazidy); pri pokročilej CKD preferovať slučkové diuretikum. Pri ťažkej poruche funkcie obličiek sa neodporúča.",
        'nephrotoxicity' => 'Hypovolémia → prerenálne AKI.',
        'dialyzability'  => 'Nedialyzovateľný — väzba na bielkoviny ~75 %, lipofilný; pri ťažkej CKD aj tak neúčinný, preferovať slučkové diuretikum.',
        'warnings'       => 'Hyponatriémia (najmä u starších), hypokaliémia, predĺženie QT, hyperurikémia, fotosenzitivita.',
        'monitoring'     => 'Nátrium, kálium, urát; EKG pri rizikových.',
    ],
    'amilorid' => [
        'indications'    => 'Kálium-šetriaci prídavok k slučkovým/tiazidovým diuretikám; Liddleov syndróm; lítiom indukovaný nefrogénny diabetes insipidus.',
        'renal_dosing'   => "Renálne eliminovaný a pri zlyhaní obličiek sa kumuluje — kontraindikovaný pri eGFR < 30 a pri hyperkaliémii. Pri zníženej funkcii obličiek riziko ťažkej hyperkaliémie, najmä so súbehom ACEi/ARB.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Renálne eliminovaný (MW 230 Da, nízka väzba na bielkoviny); pri HD sa odstraňuje, no liek je u pacientov so zlyhaním obličiek nevhodný pre riziko hyperkaliémie.',
        'warnings'       => 'Hyperkaliémia (môže byť život ohrozujúca), hyponatriémia.',
        'monitoring'     => 'Kálium a kreatinín krátko po začatí a pravidelne.',
    ],
    'acetazolamid' => [
        'indications'    => 'Metabolická alkalóza (napr. diuretikami indukovaná), glaukóm, výšková choroba, podpora diurézy pri zmiešaných poruchách.',
        'renal_dosing'   => "Renálne eliminovaný; pri eGFR < 30 sa neodporúča (kumulácia, riziko ťažkej metabolickej acidózy). Účinok závisí od funkcie obličiek.",
        'nephrotoxicity' => 'Riziko nefrolitiázy (kalciumfosfátové kamene) pri dlhodobom užívaní; metabolická acidóza, hypokaliémia.',
        'dialyzability'  => 'Vysoká väzba na bielkoviny (~95 %) → HD ho účinne neodstraňuje; pri ESRD sa kumuluje a neodporúča.',
        'warnings'       => 'Hyperchloremická metabolická acidóza, hypokaliémia, parestézie, sulfónamidová alergia, nefrolitiáza.',
        'monitoring'     => 'Acidobáza (bikarbonát), kálium, funkcia obličiek.',
    ],
    // ── Úprava dávky podľa obličiek (3. vlna) ─────────────────────────────────
    'dabigatran' => [
        'indications'    => 'Prevencia NCMP pri nevalvulárnej fibrilácii predsiení, liečba a prevencia venózneho tromboembolizmu.',
        'renal_dosing'   => "Silne renálne eliminovaný (~80 %) — dávkovať podľa CrCl. Pri CrCl 30–50 zvážiť redukciu (110 mg 2×/d podľa rizika); pri CrCl < 30 kontraindikovaný (EMA). Pred plánovanými výkonmi vysadiť s ohľadom na CrCl.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický; pri akútnom poklese eGFR riziko akumulácie a krvácania. Opísaná antikoagulanciami asociovaná nefropatia (glomerulárne krvácanie) aj pri DOAC.',
        'dialyzability'  => 'Dialyzovateľný — nízka väzba na bielkoviny (~35 %), distribučný objem ~60 l; HD odstráni ~50–60 % za 4 h a možno ju použiť pri ťažkom krvácaní/predávkovaní (ak nie je dostupné antidotum idarucizumab).',
        'warnings'       => 'Krvácanie (zvýšené pri kumulácii v CKD); špecifické antidotum idarucizumab. Dyspepsia.',
        'monitoring'     => 'Funkcia obličiek (CrCl) minimálne 1×/rok, častejšie pri CKD/akútnom ochorení; známky krvácania.',
    ],
    'apixaban' => [
        'indications'    => 'Prevencia NCMP pri nevalvulárnej fibrilácii predsiení, liečba a prevencia venózneho tromboembolizmu.',
        'renal_dosing'   => "Menej závislý od obličiek (~27 % renálne) — často preferovaný DOAC pri CKD. Pri fibrilácii predsiení redukcia na 2,5 mg 2×/d pri splnení ≥ 2 z: vek ≥ 80 r., hmotnosť ≤ 60 kg, kreatinín ≥ 133 µmol/l. Pri ťažkej CKD/dialýze obmedzené dáta.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Minimálne dialyzovateľný — vysoká väzba na bielkoviny (~87 %); HD odstráni len ~7 %. Antidotum andexanet alfa. Pri CKD bezpečnejší profil ako dabigatran.',
        'warnings'       => 'Krvácanie; antidotum andexanet alfa.',
        'monitoring'     => 'Funkcia obličiek, krvný obraz, známky krvácania.',
    ],
    'digoxin' => [
        'indications'    => 'Kontrola komorovej frekvencie pri fibrilácii predsiení, srdcové zlyhanie so zníženou ejekčnou frakciou.',
        'renal_dosing'   => "Renálne eliminovaný a s úzkym terapeutickým oknom — pri zníženej funkcii obličiek znížiť dávku a predĺžiť interval; dávkovať podľa hladín (cieľ často 0,5–0,9 ng/ml pri SZ). Pri ESRD výrazne redukovať.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — obrovský distribučný objem (~5–7 l/kg) napriek nízkej väzbe na bielkoviny (~25 %); HD ani PD ho neodstránia. Pri život ohrozujúcej toxicite digoxín-špecifické Fab protilátky (DigiFab).',
        'warnings'       => 'Toxicita potencovaná hypokaliémiou, hypomagneziémiou a hyperkalciémiou (časté pri CKD/diuretikách); arytmie, GI a vizuálne príznaky. Interakcie (amiodarón, verapamil).',
        'monitoring'     => 'Hladina digoxínu, kálium, horčík, funkcia obličiek; EKG.',
    ],
    'pregabalin' => [
        'indications'    => 'Neuropatická bolesť (vrátane uremickej), epilepsia, generalizovaná úzkostná porucha; pri CKD aj syndróm nepokojných nôh.',
        'renal_dosing'   => "Takmer výhradne renálna eliminácia — dávkovať podľa CrCl a výrazne znižovať (CrCl 30–60 ~ polovica dávky; 15–30; < 15). Pri hemodialýze podať doplnkovú dávku po procedúre.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Vysoko dialyzovateľný — nízka MW (159 Da), nulová väzba na bielkoviny; HD ho účinne odstraňuje → doplnková dávka po každej procedúre.',
        'warnings'       => 'Kumulácia → sedácia, závrat, periférne edémy, encefalopatia, respiračná depresia (najmä so súbehom opioidov). Riziko závislosti.',
        'monitoring'     => 'Klinické príznaky toxicity, funkcia obličiek.',
    ],
    // ── Nefrotoxické lieky (3. vlna) ──────────────────────────────────────────
    'litium' => [
        'indications'    => 'Bipolárna afektívna porucha (profylaxia a liečba mánie).',
        'renal_dosing'   => "Úzke terapeutické okno; takmer výhradne renálne eliminované. Dávkovať podľa hladín (cieľ 0,6–0,8 mmol/l); pri zníženej funkcii obličiek a dehydratácii riziko intoxikácie. Vyhnúť sa súbehu s NSAID, ACEi/ARB a tiazidmi (znižujú klírens lítia).",
        'nephrotoxicity' => 'Nefrogénny diabetes insipidus (polyúria), chronická tubulointersticiálna nefropatia s pomalou progresiou CKD, akútna intoxikácia pri dehydratácii; zriedkavo hyperkalciémia (lítiom indukovaná hyperparatyreóza).',
        'dialyzability'  => 'Vysoko dialyzovateľný — malý ión bez väzby na bielkoviny; hemodialýza je liečbou ťažkej intoxikácie (EXTRIP). Po HD častý rebound z redistribúcie → kontrolovať hladiny a opakovať.',
        'warnings'       => 'Intoxikácia (tremor, ataxia, zmätenosť, kŕče, arytmie) — potencovaná dehydratáciou a liekmi znižujúcimi klírens. Hypotyreóza.',
        'monitoring'     => 'Hladina lítia pravidelne, funkcia obličiek, kalcium, TSH; objemový stav.',
    ],
    'amikacin' => [
        'indications'    => 'Závažné gramnegatívne infekcie (vrátane multirezistentných), niektoré mykobaktériové infekcie.',
        'renal_dosing'   => "Výrazne nefrotoxický — dávkovať podľa funkcie obličiek a hladín; pri zníženom eGFR predĺžiť interval. Preferovať režim raz denne a terapeutické monitorovanie; minimalizovať dĺžku liečby.",
        'nephrotoxicity' => 'Akútna tubulárna nekróza (zvyčajne neoligurická, reverzibilná); riziko rastie s kumulatívnou dávkou, dĺžkou liečby, hypovolémiou a súbehom nefrotoxínov.',
        'dialyzability'  => 'Dialyzovateľný — nízka väzba na bielkoviny, malý distribučný objem (~0,25 l/kg); HD odstráni ~50 % za procedúru. Dávkovať podľa hladín a doplniť po HD.',
        'warnings'       => 'Nefro- a ototoxicita (môže byť ireverzibilná); vyhnúť sa súbehu s inými nefrotoxínmi.',
        'monitoring'     => 'Hladiny (trough/peak), kreatinín/eGFR denne–obdeň, sluch/rovnováha.',
    ],
    'metotrexat' => [
        'indications'    => 'Reumatoidná artritída a iné autoimunitné choroby (nízke týždenné dávky), onkológia (vysoké dávky); niektoré vaskulitídy.',
        'renal_dosing'   => "Renálne eliminovaný — nízkodávkový týždenný režim sa pri eGFR < 30 neodporúča (riziko kumulácie a myelosupresie). Vysokodávkový MTX vyžaduje alkalizáciu moču, hydratáciu a monitorovanie hladín; pri AKI je liečbou glukarpidáza.",
        'nephrotoxicity' => 'Kryštálová nefropatia (precipitácia MTX a 7-OH metabolitu v tubuloch) pri vysokých dávkach a kyslom moči → AKI, ktoré ďalej spomaľuje elimináciu (bludný kruh).',
        'dialyzability'  => 'Slabo odstrániteľný bežnou HD; high-flux/high-efficiency HD je účinnejšia, ale častý je rebound. Pri ťažkej toxicite je liečbou glukarpidáza (rekombinantná karboxypeptidáza) + leukovorín, nie dialýza.',
        'warnings'       => 'Myelosupresia, mukozitída, hepatotoxicita, pneumonitída; súbeh s NSAID, salicylátmi a PPI zvyšuje hladiny. Substitúcia folátom (leukovorín pri vysokých dávkach).',
        'monitoring'     => 'Krvný obraz, pečeňové testy, funkcia obličiek; pri vysokých dávkach hladiny MTX a pH moču.',
    ],
    // ── CKD-MBD a dialýza (3. vlna) ───────────────────────────────────────────
    'lantan' => [
        'indications'    => 'Hyperfosfatémia pri CKD/dialýze (viazač fosfátov bez obsahu kalcia).',
        'renal_dosing'   => "Dávkovať podľa sérového fosfátu; tablety žuvať s jedlom. Minimálne sa vstrebáva, preto netreba úpravu podľa eGFR.",
        'nephrotoxicity' => 'Bez systémovej renálnej toxicity (pôsobí v GIT).',
        'dialyzability'  => 'Neaplikovateľné — minimálne sa vstrebáva, pôsobí lokálne v lúmene čreva ako viazač fosfátov.',
        'warnings'       => 'GI ťažkosti (nauzea, zápcha); dlhodobé ukladanie lantánu v tkanivách (kosť, GIT), klinický význam neistý. Neobsahuje kalcium (výhoda pri riziku cievnych kalcifikácií).',
        'monitoring'     => 'Sérový fosfát a kalcium.',
    ],
    // ── Transplantácia / imunosupresia (3. vlna) ──────────────────────────────
    'sirolimus' => [
        'indications'    => 'Imunosupresia po transplantácii obličky (najmä ako náhrada kalcineurínového inhibítora pri jeho nefrotoxicite).',
        'renal_dosing'   => "Dávkovať podľa hladín (TDM), nie podľa eGFR. Nie je klasicky nefrotoxický, ale môže zhoršiť proteinúriu a oddialiť hojenie; konverzia z CNI sa zvažuje individuálne.",
        'nephrotoxicity' => 'Sám nie je klasicky nefrotoxický (na rozdiel od CNI), no môže indukovať/zhoršiť proteinúriu a de novo FSGS; zhoršené hojenie rán, oneskorená funkcia štepu.',
        'dialyzability'  => 'Nedialyzovateľný — veľká lipofilná molekula (MW 914 Da) viazaná na bielkoviny (~92 %) a erytrocyty, veľký distribučný objem; dávkovať podľa hladín (TDM).',
        'warnings'       => 'Hyperlipidémia, myelosupresia, oneskorené hojenie rán, pneumonitída, proteinúria, afty; početné interakcie cez CYP3A4.',
        'monitoring'     => 'Hladiny (trough), lipidy, krvný obraz, proteinúria.',
    ],
    'azatioprin' => [
        'indications'    => 'Imunosupresia po transplantácii obličky; autoimunitné choroby a vaskulitídy (udržiavacia liečba).',
        'renal_dosing'   => "Pri ťažkej CKD/zlyhaní obličiek zvážiť redukciu dávky (kumulácia aktívnych metabolitov, vyššie riziko myelosupresie). Dávkovanie individuálne; pri ESRD a HD podávať po procedúre.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický.',
        'dialyzability'  => 'Čiastočne dialyzovateľná — azatioprín aj aktívny 6-merkaptopurín majú nízku väzbu na bielkoviny; HD odstráni časť (~45 %). Pri ESRD/HD zvážiť redukciu dávky a podanie po procedúre.',
        'warnings'       => 'Myelosupresia (pred liečbou skríning aktivity TPMT/NUDT15), hepatotoxicita, pankreatitída, infekcie, dlhodobé riziko malignít; závažná interakcia s alopurinolom/febuxostatom (inhibícia xantínoxidázy → výrazné zvýšenie toxicity — dávku výrazne redukovať).',
        'monitoring'     => 'Krvný obraz pravidelne, pečeňové testy; TPMT pred začatím.',
    ],
    // ── Viazače draslíka, ESA, železo a CKD-MBD (4. vlna) ──────────────────────
    'patiromer' => [
        'indications'    => 'Chronická hyperkaliémia pri CKD a srdcovom zlyhaní (umožňuje pokračovať v RAAS inhibícii).',
        'renal_dosing'   => "Pôsobí v GIT, bez úpravy podľa eGFR. Začať 8,4 g 1×/d, titrovať podľa kália à ~ 1 týždeň. Užívať s odstupom ≥ 3 h od iných perorálnych liekov (viaže ich vstrebávanie). Nevhodný na akútnu/život ohrozujúcu hyperkaliémiu (pomalý nástup).",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Neaplikovateľné — nevstrebáva sa, viaže draslík v lúmene čreva (výmenou za kalcium); v krvi necirkuluje.',
        'warnings'       => 'Hypokaliémia a hypomagneziémia (sledovať horčík), GI ťažkosti (zápcha); môže viazať súbežné lieky — dodržať časový odstup.',
        'monitoring'     => 'Kálium a horčík, klinická odpoveď.',
    ],
    'szc' => [
        'indications'    => 'Chronická hyperkaliémia (vrátane CKD a pri RAAS inhibícii).',
        'renal_dosing'   => "Pôsobí v GIT, bez úpravy podľa eGFR. Korekčná fáza 10 g 3×/d do 48 h, potom udržiavacia ~ 5 g/d (titrovať podľa kália). Obsahuje sodík — pozor pri objemovom preťažení a hypertenzii. Odstup od iných perorálnych liekov.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Neaplikovateľné — anorganický katexový sorbent, nevstrebáva sa a pôsobí v čreve.',
        'warnings'       => 'Edémy a hypertenzia (nálož sodíka), hypokaliémia; GI ťažkosti. U dialyzovaných sa dávkuje len v dňoch bez dialýzy (podľa SPC).',
        'monitoring'     => 'Kálium, objemový stav/edémy, krvný tlak.',
    ],
    'epoetin' => [
        'indications'    => 'Anémia pri chronickej chorobe obličiek (dialyzovaní aj nedialyzovaní).',
        'renal_dosing'   => "Dávka podľa hemoglobínu a telesnej hmotnosti (i.v./s.c.), titrovať podľa odpovede; cieľ Hb ~ 100–115 g/l (neprestreľovať > 115–120). Bez úpravy podľa eGFR, ale pred začatím a počas liečby zabezpečiť dostatok železa.",
        'nephrotoxicity' => 'Nie je nefrotoxický; nadmerná korekcia Hb a hypertenzia zvyšujú KV riziko.',
        'dialyzability'  => 'Nedialyzovateľný — veľký glykoproteín (~30 kDa); podáva sa i.v./s.c., u HD pacientov často počas dialýzy (do návratovej linky).',
        'warnings'       => 'Hypertenzia, trombembolické príhody; zriedkavo čistá aplázia červenej rady (anti-EPO protilátky). Cieľový Hb neprestreľovať (zvýšená mortalita a KV riziko).',
        'monitoring'     => 'Hemoglobín pravidelne, zásoby železa (feritín, saturácia transferínu), krvný tlak.',
    ],
    'darbepoetin' => [
        'indications'    => 'Anémia pri chronickej chorobe obličiek; dlhšie dávkovacie intervaly ako epoetín.',
        'renal_dosing'   => "Dlhší polčas → menej časté dávkovanie (1×/1–2 týždne, i.v./s.c.). Cieľ Hb ako pri epoetíne; titrovať podľa odpovede. Pred začatím doplniť deficit železa.",
        'nephrotoxicity' => 'Nie je nefrotoxický; nadmerná korekcia Hb a hypertenzia zvyšujú KV riziko.',
        'dialyzability'  => 'Nedialyzovateľný — veľký glykoproteín (~37 kDa, hyperglykozylovaný); HD ho neodstráni.',
        'warnings'       => 'Hypertenzia, trombembolické príhody, zriedkavo aplázia červenej rady; neprestreľovať cieľový Hb (KV riziko, mortalita).',
        'monitoring'     => 'Hemoglobín, zásoby železa, krvný tlak.',
    ],
    'zelezo-karboxymaltoza' => [
        'indications'    => 'Deficit železa pri CKD (vrátane funkčného deficitu počas ESA liečby), keď perorálne železo nestačí alebo nie je tolerované.',
        'renal_dosing'   => "I.v. železo — dávka podľa veľkosti deficitu a telesnej hmotnosti; bez úpravy podľa eGFR. Umožňuje podať veľkú dávku v jednej infúzii. Nepodávať pri aktívnej infekcii.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný — veľký komplex železa s karbohydrátom; podáva sa i.v. vrátane HD pacientov.',
        'warnings'       => 'Hypersenzitívne/infúzne reakcie; hypofosfatémia (pri železitej karboxymaltóze môže byť ťažká a pretrvávajúca — sledovať fosfát); riziko preťaženia železom.',
        'monitoring'     => 'Parametre železa (feritín, saturácia transferínu), sérový fosfát po podaní.',
    ],
    'kalciumacetat' => [
        'indications'    => 'Hyperfosfatémia pri CKD/dialýze (kalciový viazač fosfátov).',
        'renal_dosing'   => "Dávkovať podľa sérového fosfátu; užívať s jedlom. Sledovať celkovú nálož kalcia — KDIGO odporúča obmedziť kalciové viazače pre riziko cievnych kalcifikácií.",
        'nephrotoxicity' => 'Nie priamo; hyperkalciémia môže zhoršiť funkciu obličiek a podporiť kalcifikácie/nefrokalcinózu.',
        'dialyzability'  => 'Neaplikovateľné — viazač pôsobí v lúmene čreva; časť kalcia sa však vstrebáva a prispieva k riziku hyperkalciémie.',
        'warnings'       => 'Hyperkalciémia (najmä so súbehom aktívnych analógov vitamínu D), zápcha; riziko cievnych kalcifikácií pri vysokej nálcii kalcia.',
        'monitoring'     => 'Sérový fosfát a kalcium, PTH.',
    ],
    'etelkalcetid' => [
        'indications'    => 'Sekundárna hyperparatyreóza u dospelých na hemodialýze.',
        'renal_dosing'   => "Len pre pacientov na hemodialýze — i.v. na konci dialyzačnej procedúry 3×/týždeň. Titrácia podľa PTH a kalcia; nezačínať pri kalciu pod dolnou hranicou normy.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Dialyzovateľný — odstraňuje sa hemodialýzou, preto sa podáva i.v. až na konci dialyzačnej procedúry (nie medzi dialýzami).',
        'warnings'       => 'Hypokalciémia (parestézie, kŕče, predĺženie QT, zriedkavo arytmie a kŕče), nauzea/vracanie; opatrne pri rizikových arytmiách a súbehu liekov predlžujúcich QT.',
        'monitoring'     => 'Kalcium (vrátane korigovaného), PTH, fosfát.',
    ],
    // ── Renálne dávkovanie a nefrotoxíny (5. vlna) ────────────────────────────
    'enoxaparin' => [
        'indications'    => 'Profylaxia a liečba venózneho tromboembolizmu, akútny koronárny syndróm; antikoagulácia dialyzačného okruhu.',
        'renal_dosing'   => "Renálne eliminovaný — pri CrCl < 30 ml/min sa kumuluje (riziko krvácania). Liečebná dávka pri CrCl 15–30: redukcia na 1 mg/kg 1×/d (namiesto 2×/d), profylaxia 20 mg 1×/d. Pri ťažkej CKD zvážiť nefrakcionovaný heparín (lepšie riaditeľný) alebo monitorovať anti-Xa.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Slabo dialyzovateľný — pri zlyhaní obličiek sa kumuluje a antikoagulačný účinok pretrváva; HD ho účinne neodstráni. Protamín neutralizuje účinok len čiastočne (~ 60 %).',
        'warnings'       => 'Krvácanie (zvýšené pri kumulácii v CKD), heparínom indukovaná trombocytopénia (HIT), hyperkaliémia (supresia aldosterónu pri dlhšom podaní).',
        'monitoring'     => 'Anti-Xa pri CKD/extrémnej hmotnosti/gravidite; trombocyty, kálium pri dlhšom podaní, funkcia obličiek.',
    ],
    'kotrimoxazol' => [
        'indications'    => 'Infekcie močových ciest, pneumocystová pneumónia (PJP — liečba a profylaxia), niektoré ďalšie infekcie.',
        'renal_dosing'   => "Renálne eliminovaný — pri CrCl 15–30 redukovať dávku na polovicu; pri CrCl < 15 sa zvyčajne neodporúča. Pri vysokodávkovej PJP liečbe a CKD dôsledne sledovať kálium a kreatinín.",
        'nephrotoxicity' => 'Trimetoprim blokuje epitelové sodíkové kanály (ENaC) → hyperkaliémia (najmä pri CKD, vysokých dávkach, súbehu s ACEi/ARB) a blokuje tubulárnu sekréciu kreatinínu → „pseudo-AKI“ (vzostup kreatinínu bez poklesu GFR). Sulfametoxazol: kryštalúria a akútna intersticiálna nefritída.',
        'dialyzability'  => 'Obe zložky sú dialyzovateľné (trimetoprim aj sulfametoxazol majú strednú väzbu na bielkoviny) — pri HD dávkovať po procedúre.',
        'warnings'       => 'Hyperkaliémia, vzostup kreatinínu (často benígny — pseudo-AKI), kryštalúria/AIN, kožné reakcie (SJS/TEN), myelosupresia; interakcie s warfarínom a metotrexátom.',
        'monitoring'     => 'Kálium a kreatinín (najmä pri CKD a vysokých dávkach), krvný obraz, hydratácia.',
    ],
    'ciprofloxacin' => [
        'indications'    => 'Komplikované infekcie močových ciest, pyelonefritída, niektoré gramnegatívne infekcie.',
        'renal_dosing'   => "Čiastočne renálne eliminovaný — pri CrCl < 30 redukovať dávku (predĺžiť interval/znížiť dávku). Zabezpečiť hydratáciu (prevencia kryštalúrie). Pri hemodialýze podať po procedúre.",
        'nephrotoxicity' => 'Kryštalúria pri alkalickom moči a dehydratácii; zriedkavo akútna intersticiálna nefritída a kryštálová nefropatia.',
        'dialyzability'  => 'Len mierne dialyzovateľný (~ 10–30 %; čiastočná väzba na bielkoviny a stredný distribučný objem) — pri HD doplniť dávku po procedúre.',
        'warnings'       => 'Tendinopatia/ruptúra šľachy (vyššie riziko pri CKD a súbehu s kortikoidmi), predĺženie QT, aneuryzma aorty, dysglykémia, CNS účinky; katióny (vrátane viazačov fosfátov) znižujú vstrebávanie.',
        'monitoring'     => 'Funkcia obličiek, hydratácia; EKG pri rizikových.',
    ],
    'omeprazol' => [
        'indications'    => 'Refluxová choroba, peptický vred, profylaxia stresového vredu, eradikácia H. pylori.',
        'renal_dosing'   => "Hepatálne metabolizovaný — bez úpravy podľa eGFR. Riziko súvisí skôr s dĺžkou užívania než s dávkou (deprescribing pri nejasnej indikácii).",
        'nephrotoxicity' => 'Akútna intersticiálna nefritída (idiosynkratická, môže viesť k AKI a prejsť do CKD); pri dlhodobom užívaní spájaný s rizikom CKD a hypomagneziémie.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~ 95 %), krátky polčas a hepatálna eliminácia; HD ho neodstráni (ani to nie je potrebné).',
        'warnings'       => 'Akútna intersticiálna nefritída (môže byť bez eozinofílie), hypomagneziémia (a sekundárna hypokalciémia/hypokaliémia), pri dlhodobom užívaní riziko CKD.',
        'monitoring'     => 'Pri dlhodobom užívaní horčík; funkcia obličiek pri klinickom podozrení na AIN.',
    ],
    'nitrofurantoin' => [
        'indications'    => 'Nekomplikované infekcie dolných močových ciest (cystitída), profylaxia rekurentných UTI.',
        'renal_dosing'   => "Kontraindikovaný pri CrCl < 45 ml/min (podľa niektorých zdrojov < 30) — pri zníženej funkcii sa nedosahuje účinná koncentrácia v moči a rastie systémová toxicita. Vhodný len pri zachovanej funkcii obličiek.",
        'nephrotoxicity' => 'Nie je priamo nefrotoxický, no pri zlyhaní obličiek je neúčinný a toxický (kumulácia).',
        'dialyzability'  => 'Pri ESRD neúčinný a kontraindikovaný — do moču sa nevylúči dostatočne; HD ho síce odstráni, ale liek je u dialyzovaných nevhodný.',
        'warnings'       => 'Pri CKD neúčinný a toxický; akútna a chronická pľúcna toxicita (fibróza), periférna neuropatia (riziko rastie pri CKD), hepatotoxicita, hemolýza pri deficite G6PD.',
        'monitoring'     => 'Funkcia obličiek pred predpisom (vylúčiť nízky eGFR); pri dlhodobej profylaxii pľúcne a pečeňové prejavy.',
    ],
    'baklofen' => [
        'indications'    => 'Spasticita (skleróza multiplex, poranenie miechy a i.); v nefrológii dôležitý pre riziko toxicity pri CKD.',
        'renal_dosing'   => "Takmer výhradne renálne eliminovaný — pri CKD výrazne znížiť dávku; pri eGFR < 30 a u dialyzovaných hrozí ťažká neurotoxicita aj pri nízkych dávkach (odporúča sa vyhnúť sa alebo extrémna opatrnosť).",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Dialyzovateľný — nízka MW (~ 214 Da), nízka väzba na bielkoviny; hemodialýza je účinnou liečbou baklofénovej neurotoxicity/predávkovania pri CKD.',
        'warnings'       => 'Neurotoxicita pri CKD (encefalopatia, somnolencia až kóma, útlm dychu) — častá a podceňovaná komplikácia; náhle vysadenie po dlhšom podaní → abstinenčný syndróm.',
        'monitoring'     => 'Neurologický stav pri CKD; funkcia obličiek.',
    ],
    'sitagliptin' => [
        'indications'    => 'Diabetes 2. typu (DPP-4 inhibítor).',
        'renal_dosing'   => "Prevažne renálne eliminovaný — redukovať dávku: 100 mg/d pri eGFR ≥ 45; 50 mg/d pri eGFR 30–45; 25 mg/d pri eGFR < 30 a u dialyzovaných.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Mierne dialyzovateľný (~ 13 % počas 3–4 h HD) — dávka 25 mg/d, podanie nezávisí od času dialýzy.',
        'warnings'       => 'Pankreatitída, bolesti kĺbov, zriedkavo bulózny pemfigoid.',
        'monitoring'     => 'Funkcia obličiek (na úpravu dávky), glykémia.',
    ],
    'linagliptin' => [
        'indications'    => 'Diabetes 2. typu (DPP-4 inhibítor) — vhodný pri CKD bez úpravy dávky.',
        'renal_dosing'   => "Prevažne biliárna/enterohepatálna eliminácia — JEDINÝ gliptín BEZ potreby úpravy dávky podľa funkcie obličiek (vrátane ťažkej CKD a dialýzy). Praktická voľba pri pokročilej CKD.",
        'nephrotoxicity' => 'Nie je nefrotoxický.',
        'dialyzability'  => 'Nedialyzovateľný a bez potreby doplnkovej dávky — vysoká väzba na bielkoviny a prevažne nerenálna eliminácia; podáva sa nezávisle od dialýzy.',
        'warnings'       => 'Pankreatitída, bolesti kĺbov, zriedkavo bulózny pemfigoid.',
        'monitoring'     => 'Glykémia (úprava dávky podľa obličiek nie je potrebná).',
    ],
    'rivaroxaban' => [
        'indications'    => 'Prevencia NCMP pri nevalvulárnej fibrilácii predsiení, liečba a prevencia venózneho tromboembolizmu.',
        'renal_dosing'   => "Čiastočne renálne eliminovaný (~ 1/3) — pri fibrilácii predsiení a CrCl 15–50 redukcia na 15 mg/d; pri CrCl < 15 sa neodporúča. Pri liečbe VTE opatrnosť pri CrCl < 30. Tablety 15/20 mg užívať s jedlom.",
        'nephrotoxicity' => 'Nie priamo nefrotoxický; opísaná antikoagulanciami asociovaná nefropatia (glomerulárne krvácanie).',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~ 92–95 %); HD ho neodstráni. Antidotum andexanet alfa (alt. PCC).',
        'warnings'       => 'Krvácanie (zvýšené pri CKD); antidotum andexanet alfa.',
        'monitoring'     => 'Funkcia obličiek (CrCl) pravidelne, známky krvácania, krvný obraz.',
    ],
    'rosuvastatin' => [
        'indications'    => 'Dyslipidémia, kardiovaskulárna prevencia (vrátane pacientov s CKD).',
        'renal_dosing'   => "Pri ťažkej CKD (eGFR < 30) začať 5 mg a NEPREKROČIŤ 10 mg/d (zvýšená expozícia, riziko myopatie). Pri miernej–stredne ťažkej CKD bez špecifickej úpravy; pri dialýze opatrne.",
        'nephrotoxicity' => 'Nie priamo nefrotoxický; dávkovo závislá (tubulárna, zvyčajne benígna) proteinúria a zriedkavo myoglobinúrické AKI pri rabdomyolýze.',
        'dialyzability'  => 'Nedialyzovateľný — vysoká väzba na bielkoviny (~ 90 %); HD ho neodstráni.',
        'warnings'       => 'Myopatia/rabdomyolýza (riziko rastie pri CKD, vyšších dávkach a interakciách — napr. cyklosporín, gemfibrozil), hepatopatia; pri CKD preferovať nižšiu dávku.',
        'monitoring'     => 'CK pri svalových príznakoch, lipidy, pečeňové testy; funkcia obličiek.',
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

// ── source_refs: pridá overený odkaz na SPC (DailyMed, NIH) ku každému lieku ───
// MERGE, nie prepis: zachová existujúce odkazy (EMA EPAR zo sync, ručné admin úpravy),
// pridá DailyMed len ak ešte chýba (dedup podľa hostiteľa). Idempotentné. DailyMed je
// verejný register SPC/PI (https://dailymed.nlm.nih.gov); dotaz podľa INN názvu lieku.
// Pre EU/SK kontext ostávajú EMA EPAR odkazy doplnené synchronizáciou z ChEMBL.
$srcAdded = 0;
$srcStmt = $pdo->prepare('UPDATE drugs SET source_refs = :src WHERE id = :id');
foreach ($pdo->query('SELECT id, name_intl, source_refs FROM drugs')->fetchAll(\PDO::FETCH_ASSOC) as $d) {
    $name = trim((string) ($d['name_intl'] ?? ''));
    if ($name === '') {
        continue; // bez INN nevieme spoľahlivo dotazovať DailyMed
    }
    $refs = json_decode((string) ($d['source_refs'] ?? ''), true);
    if (!is_array($refs)) {
        $refs = [];
    }
    foreach ($refs as $r) {
        if (is_array($r) && isset($r['url']) && str_contains((string) $r['url'], 'dailymed.nlm.nih.gov')) {
            continue 2; // už má DailyMed odkaz — preskočiť (idempotentné)
        }
    }
    $refs[] = [
        'label' => 'DailyMed – SPC (NIH)',
        'url'   => 'https://dailymed.nlm.nih.gov/dailymed/search.cfm?query=' . rawurlencode(mb_strtolower($name)),
    ];
    $srcStmt->execute([
        'src' => json_encode($refs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: null,
        'id'  => $d['id'],
    ]);
    $srcAdded++;
}

echo "──────────────────────────────────────────────────────\n";
echo "Kurácia liekov (NÁVRH — overte pred zverejnením)\n";
echo "──────────────────────────────────────────────────────\n";
echo 'V zozname:       ' . count($curation) . "\n";
echo 'Aktualizovaných: ' . $updated . "\n";
echo 'Bez polí:        ' . $skipped . "\n";
echo 'Zdroje (+DailyMed): ' . $srcAdded . "\n";
if ($missing !== []) {
    echo 'Chýbajúci slug (spustite najprv sync_drugs.php): ' . implode(', ', $missing) . "\n";
}
echo "Lieky ostávajú NEZVEREJNENÉ — skontrolujte a zverejnite v admin_drugs.php.\n";
