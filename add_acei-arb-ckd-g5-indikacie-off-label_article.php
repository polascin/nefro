<?php
/** Odborna synteza ACEI/ARB pri CKD G5. Automaticke aviza su vypnute. */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'ACEI a ARB pri CKD G5: indikácie, kontraindikácie a použitie mimo registrácie',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'acei-arb-ckd-g5-indikacie-off-label',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Nízka filtrácia sama osebe nie je dôvodom na vysadenie ACEI alebo ARB. Kedy pokračovať, kedy liečbu začať či prerušiť a čo pri CKD G5 skutočne znamená použitie mimo registrácie.',                    // ← VYPLNIŤ: 1-2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/acei-arb-ckd-g5-indikacie-off-label.webp" target="_blank" rel="noopener noreferrer"><img src="img/acei-arb-ckd-g5-indikacie-off-label.webp" alt="Poloschematická oblička a tableta medzi dvoma svetelnými oblúkmi ako symbol individuálneho posúdenia liečby" width="1586" height="992" loading="lazy" decoding="async"></a><figcaption>Ilustrácia vytvorená s podporou umelej inteligencie. Poloschematická scéna znázorňuje rozhodovanie o liečbe, nejde o snímku pacienta ani konkrétneho lieku.</figcaption></figure>
<p><strong>Chronická choroba obličiek v kategórii G5 sama osebe nie je všeobecnou kontraindikáciou inhibítorov angiotenzín konvertujúceho enzýmu (ACEI) ani blokátorov receptorov angiotenzínu II (ARB).</strong> Rozhodovanie sa však mení: treba odlíšiť pokračovanie v tolerovanej liečbe od jej nového začatia, pacienta pred dialýzou od pacienta liečeného dialýzou a klinické opodstatnenie od súladu s registráciou konkrétneho lieku. Označenie „off-label“ nevyplýva automaticky z nízkej filtrácie. [1, 4, 5]</p>
<p>Kategória CKD G5 znamená glomerulovú filtráciu pod 15 ml/min/1,73 m² pri chronickej chorobe obličiek. Označenie G5D dopĺňa informáciu o dialyzačnej liečbe. Samotné číslo eGFR nevystihuje objemový stav, kaliémiu, hemodynamickú stabilitu, reziduálnu funkciu obličiek ani dôvod predpisovania. Práve tieto okolnosti určujú, či liečba pacientovi ešte prospieva. [1]</p>
<h2>Pokračovanie v liečbe: čo skutočne ukázala štúdia STOP ACEi</h2>
<p>V randomizovanej otvorenej štúdii STOP ACEi bolo 411 pacientov s pokročilou progresívnou CKD a eGFR pod 30 ml/min/1,73 m² zaradených na vysadenie alebo pokračovanie blokády renín-angiotenzínového systému. Vstupnú eGFR pod 15 ml/min/1,73 m² malo 118 pacientov, teda približne 29 % súboru. Liečbu ACEI alebo ARB užívali pred zaradením dlhšie než šesť mesiacov. Po troch rokoch bola upravená priemerná eGFR 12,6 ml/min/1,73 m² po vysadení a 13,3 ml/min/1,73 m² pri pokračovaní. Rozdiel −0,7 ml/min/1,73 m² mal 95 % interval spoľahlivosti od −2,5 do 1,0; p = 0,42. Rutinné vysadenie teda neprinieslo očakávané zlepšenie dlhodobej funkcie obličiek. [2, 12]</p>
<p>Zlyhanie obličiek alebo začatie liečby nahrádzajúcej funkciu obličiek nastalo u 62 % pacientov po vysadení a u 56 % pri pokračovaní; pomer hazardov bol 1,28 s 95 % intervalom spoľahlivosti od 0,99 do 1,65. Išlo o sekundárny výsledok; intervaly spoľahlivosti neboli upravené na viacnásobné porovnávanie. Výsledok neoprávňuje tvrdiť, že vysadenie jednoznačne spôsobilo viac týchto udalostí, ale neposkytuje dôvod vysádzať liečbu iba preto, aby sa oddialila dialýza. Štúdia skúmala vysadenie už užívaných liekov, nie ich prvé nasadenie pri CKD G5, a nepreukazuje bezpečnosť pokračovania napriek závažnej hyperkaliémii či hypotenzii. [2, 12]</p>
<p>Pri interpretácii eGFR je podstatné, že primárna analýza nezahŕňala merania po začatí dialýzy alebo po transplantácii. Uvedené hodnoty sú modelové upravené priemery, nie jednoduché priemery všetkých 411 pacientov po troch rokoch. Analýzy citlivosti s inými rovnicami eGFR a s odlišným spracovaním chýbajúcich údajov hlavný záver nezmenili; potvrdzujú to aj tabuľky S1 až S4 suplementu podrobnej správy NIHR. [2, 12]</p>
<p>Aj novšia analýza kohorty CKD-REIN z roku 2026, ktorá pomocou observačných údajov napodobnila porovnanie dvoch liečebných stratégií, zistila súvislosť vysadenia s vyšším kardiovaskulárnym rizikom a s častejším začatím náhrady funkcie obličiek. Zahŕňala 1 434 pacientov s mediánom eGFR 25 ml/min/1,73 m². Podporuje obozretnosť pri vysadzovaní, ale neodstraňuje možné reziduálne skreslenie a nie je priamym dôkazom pre celú populáciu G5. [9]</p>
<h2>Nové začatie v CKD G5 má slabšiu dôkazovú oporu</h2>
<p>Metaanalýza individuálnych údajov z 18 randomizovaných štúdií zahŕňala 1 739 účastníkov s eGFR pod 30 ml/min/1,73 m². Začatie ACEI alebo ARB znížilo riziko zlyhania obličiek vyžadujúceho náhradu ich funkcie, s upraveným pomerom hazardov 0,66 a 95 % intervalom spoľahlivosti od 0,55 do 0,79. Významný rozdiel v úmrtiach pred týmto výsledkom sa nepreukázal. Priemerná vstupná eGFR bola 22,2 ml/min/1,73 m² a 84,4 % účastníkov s dostupným údajom malo závažnú albuminúriu. Štúdie zamerané na srdcové zlyhávanie boli z metaanalýzy vylúčené. Individuálne údaje o hyperkaliémii a akútnom poškodení obličiek neboli dostupné. V niektorých pôvodných štúdiách navyše predchádzalo randomizácii úvodné obdobie liečby, ktoré mohlo zvýhodniť zaradenie pacientov s lepšou toleranciou. Renálny prínos preto nemožno zamieňať za dôkaz bezpečnosti u každého pacienta s G5. [3]</p>
<p>Tieto výsledky podporujú začatie liečby pri pokročilej CKD, nemožno ich však bez ďalšieho preniesť na každého pacienta s eGFR pod 15, osobitne tesne pred dialýzou. Ani neprítomnosť štatisticky významnej interakcie v podskupine s eGFR pod 20 ml/min/1,73 m² nenahrádza samostatnú, dostatočne presnú analýzu CKD G5. Odporúčania KDIGO 2024 na začatie ACEI/ARB pre albuminúriu sú formulované pre G1 až G4; praktický bod o pokračovaní pod hranicou eGFR 30 nie je všeobecným pokynom začať liečbu pri ľubovoľne nízkej filtrácii. [1, 3]</p>
<p>Pri novom nasadení v G5 musí byť zrejmý konkrétny cieľ: kontrola artériovej hypertenzie, liečba srdcového zlyhávania so zníženou ejekčnou frakciou alebo individuálne posúdený antiproteinurický účinok. Dôkazy o prognostickom prínose pri srdcovom zlyhávaní pochádzajú prevažne z pacientov s lepšou funkciou obličiek. Registračná indikácia preto môže byť splnená aj tam, kde je priamy dôkaz pre G5 obmedzený. [4, 5, 8]</p>
<h2>Kedy možno pokračovať a kedy liečbu prehodnotiť</h2>
<div class="table-responsive" role="region" aria-label="Klinické rozhodovanie o ACEI a ARB v CKD G5" tabindex="0"><table><thead><tr><th scope="col">Situácia</th><th scope="col">Primeraný postup</th></tr></thead><tbody>
<tr><th scope="row">Tolerovaná liečba, trvajúca indikácia, stabilný tlak a zvládnuteľná kaliémia</th><td>Pokračovanie je spravidla odôvodnené. Samotný prechod do G5 nie je dôvodom na vysadenie. [1, 2]</td></tr>
<tr><th scope="row">Významná albuminúria alebo proteinúria pred dialýzou</th><td>Posúdiť doterajšiu odpoveď, tlak, kaliémiu, prognózu a konkrétnu registráciu. Nové začatie v G5 vyžaduje individuálne rozhodnutie. [1, 3 až 5]</td></tr>
<tr><th scope="row">Symptomatická hypotenzia alebo hyperkaliémia nezvládnuteľná napriek liečbe</th><td>Znížiť dávku alebo liečbu prerušiť či ukončiť podľa závažnosti. Akútne nebezpečný stav vyžaduje bezodkladnú liečbu. [1]</td></tr>
<tr><th scope="row">Dehydratácia, obehová nestabilita alebo akútne zhoršenie funkcie obličiek</th><td>Vyšetriť príčinu, upraviť reverzibilné faktory a individuálne zvážiť dočasné prerušenie. Po stabilizácii určiť, či a kedy liečbu obnoviť. [1, 4, 5]</td></tr>
<tr><th scope="row">Uremické ťažkosti pri zlyhaní obličiek</th><td>KDIGO pripúšťa redukciu alebo vysadenie s cieľom zmierniť príznaky. Takýto postup nesmie oddialiť potrebné začatie dialýzy. [1]</td></tr>
</tbody></table></div>
<p>Pokles filtrácie po začatí ACEI/ARB môže súvisieť so zmenou glomerulovej hemodynamiky a nemusí znamenať štruktúrne poškodenie obličiek. KDIGO uvádza vzostup kreatinínu o viac než 30 % počas štyroch týždňov po začatí alebo zvýšení dávky ako hranicu na prehodnotenie pokračovania. Treba hľadať hypovolémiu, interakcie vrátane nesteroidových protizápalových liekov a stenózu renálnych artérií. Hranica sa týka časovej súvislosti so zmenou liečby, nie akéhokoľvek neskoršieho vzostupu kreatinínu. Pokles eGFR o 30 % nie je matematicky totožný so vzostupom kreatinínu o 30 %; KDIGO tieto ukazovatele používa v odlišných častiach dokumentu. [1]</p>
<h2>Kontraindikácie nie sú rovnaké pre každý liek</h2>
<p>Pri ACEI treba osobitne preveriť angioedém v anamnéze a súbežné podávanie sakubitrilu/valsartanu. SPC ramiprilu vyžaduje pri prechode medzi týmito liečbami odstup najmenej 36 hodín. Uvádza aj významnú obojstrannú stenózu renálnych artérií alebo stenózu artérie jedinej funkčnej obličky, hypotenziu a hemodynamickú nestabilitu. U losartanu je angioedém v anamnéze uvedený medzi upozorneniami; nemožno preto bez rozlíšenia preniesť celý zoznam kontraindikácií ACEI na ARB. [4, 5]</p>
<p>ACEI aj ARB sú kontraindikované v druhom a treťom trimestri gravidity. Pri plánovaní gravidity sa volí vhodná alternatíva a po zistení gravidity sa liečba ukončuje. Súbežné podávanie s aliskirénom je pri GFR pod 60 ml/min/1,73 m² kontraindikované. KDIGO odporúča pri CKD vyhnúť sa kombinácii ACEI s ARB aj kombináciám s priamym inhibítorom renínu. Zvyšovanie blokády týmto spôsobom nie je opodstatnenou „off-label“ cestou na intenzívnejšie potlačenie proteinúrie. [1, 4, 5]</p>
<p>Pre dialyzačnú prax je podstatná aj kompatibilita s mimotelovým okruhom. SPC ramiprilu kontraindikuje extrakorporálnu liečbu, pri ktorej prichádza krv do kontaktu s negatívne nabitými povrchmi, a upozorňuje na závažné anafylaktoidné reakcie pri určitých vysokopriepustných membránach, napríklad polyakrylonitrilových, a pri aferéze s dextránsulfátom. Nejde o zákaz akejkoľvek hemodialýzy, ale o potrebu overiť konkrétnu membránu a postup. [4]</p>
<h2>Hemodialýza a peritoneálna dialýza: rozdielne ciele</h2>
<p>Pri hemodialýze môže ACEI alebo ARB slúžiť na liečbu hypertenzie či srdcového zlyhávania. Nemá sa však pridávať každému pacientovi iba na základe všeobecného predpokladu kardioprotekcie. V štúdii ARCADIA s 269 hemodialyzovanými pacientmi s hypertenziou alebo hypertrofiou ľavej komory ramipril nepreukázal zníženie kombinovaného rizika kardiovaskulárneho úmrtia, infarktu myokardu alebo cievnej mozgovej príhody: pomer hazardov 0,93, 95 % interval spoľahlivosti od 0,52 do 1,64. Hypotenzné epizódy sa vyskytli u 41 % oproti 12 % v kontrolnej skupine. Široký interval spoľahlivosti zároveň nepreukazuje rovnocennosť postupov. [6]</p>
<p>Pri peritoneálnej dialýze môže byť samostatným cieľom zachovanie reziduálnej funkcie obličiek. Malá otvorená randomizovaná štúdia so 60 pacientmi zistila počas 12 mesiacov menší pokles reziduálnej GFR pri ramiprile než bez neho, o 0,93 ml/min/1,73 m²; 95 % interval spoľahlivosti bol od 0,09 do 1,78. Rozdiel v mortalite sa nepreukázal. Novšia retrospektívna kohorta s 231 pacientmi z roku 2026 sledovala reziduálny Kt/V a objem moču, nie priamo reziduálnu GFR. Súvislosť liečby s pomalším poklesom reziduálneho Kt/V nedosiahla štatistickú významnosť (p = 0,069 pre interakciu liečby s časom); pri objeme moču sa významná súvislosť takisto nepreukázala. Skupina liečená blokádou systému zahŕňala na začiatku aj troch pacientov užívajúcich sakubitril/valsartan. Vylúčenie 76 pacientov s neúplnými údajmi a možné skreslenie výberom liečby obmedzujú interpretáciu. Nejde o priamu repliku malej randomizovanej štúdie ani o dôkaz neúčinnosti ACEI/ARB. Podklady teda umožňujú individuálnu úvahu, nie prísľub spoľahlivej ochrany zvyškovej funkcie ani automatické prenesenie výsledkov na hemodialýzu. [7, 10]</p>
<h2>Čo je a čo nie je použitie mimo registrácie</h2>
<p><strong>Off-label znamená použitie mimo schválených podmienok konkrétneho lieku, nie synonymum rizikovej liečby alebo liečby s nedostatkom štúdií.</strong> Posudzuje sa indikácia, populácia, dávka, spôsob podávania aj ďalšie obmedzenia v SPC. Úhradové podmienky sú ďalšou, od registrácie odlišnou otázkou. [4, 5, 11]</p>
<p>SPC lieku RAMIMED zahŕňa hypertenziu, symptomatické srdcové zlyhávanie a vymedzené diabetické i nediabetické nefropatie. Pre nediabetickú glomerulovú nefropatiu uvádza proteinúriu najmenej 3 g/deň. Pri klírense kreatinínu od 10 do 30 ml/min uvádza úvodnú dávku 1,25 mg denne a maximum 5 mg denne; rovnaké dávkové hranice uvádza u hemodialyzovaných pacientov s hypertenziou, s podaním niekoľko hodín po dialýze. To je konkrétny príklad podania pri dialýze, ktoré SPC výslovne opisuje. Pre nedialyzovaného pacienta s klírensom pod 10 ml/min táto tabuľka samostatný režim neposkytuje. Jeho absenciu nemožno zmeniť na všeobecnú kontraindikáciu ani na overené dávkové odporúčanie. [4]</p>
<p>SPC lieku Losartan Zentiva, zverejnené v júli 2026, zahŕňa esenciálnu hypertenziu, ochorenie obličiek pri hypertenzii a diabete 2. typu s proteinúriou najmenej 0,5 g/deň a definované použitie pri chronickom srdcovom zlyhávaní, keď ACEI nie je vhodný. Pri poruche funkcie obličiek a hemodialýze nevyžaduje úpravu úvodného dávkovania iba z tohto dôvodu. To neodstraňuje potrebu zohľadniť hypovolémiu, tlak, kaliémiu a srdcové zlyhávanie. Losartan ani jeho aktívny metabolit sa hemodialýzou neodstraňujú. [5]</p>
<p>Uvedené dávky sú informáciou o konkrétnych SPC, nie univerzálnym predpisom pre CKD G5. Klírens kreatinínu v ml/min sa nesmie mechanicky stotožniť s indexovanou eGFR v ml/min/1,73 m². Rovnako nemožno podmienky samostatného ACEI alebo ARB preniesť na fixnú kombináciu s ďalším liečivom. [1, 4, 5]</p>
<p>Za použitie mimo príslušnej registrovanej indikácie možno považovať napríklad losartan podaný výlučne na zníženie proteinúrie pri nediabetickej nefropatii u normotenzného pacienta bez inej schválenej indikácie. Ďalším príkladom je ramipril podaný výlučne na zachovanie reziduálnej funkcie pri peritoneálnej dialýze, ak pacient nespĺňa žiadnu z jeho registrovaných indikácií. Tieto príklady označujú registračnú hranicu, nie odporúčanie liečbu automaticky začať. Pri G5 treba osobitne posúdiť, či očakávaný prínos prevažuje nad rizikom a či ho možno v primeranom čase vyhodnotiť. [3 až 5, 7, 10]</p>
<p>Slovenský právny rámec treba posudzovať podľa aktuálneho znenia. K 17. novembru 2026 zákon č. 362/2011 Z. z. v § 119 ods. 15 písm. i) výslovne upravuje vyznačenie predpísania alebo podania registrovaného lieku v neregistrovanej terapeutickej indikácii v preskripčnom zázname alebo na lekárskom predpise. Ak má byť taká liečba hradená z verejného zdravotného poistenia, vyžaduje predchádzajúcu žiadosť poskytovateľa o úhradu a súhlas zdravotnej poisťovne podľa osobitného predpisu. Toto ustanovenie nie je klinickým schválením ľubovoľného postupu. Konkrétny režim použitia, poučenie pacienta, dokumentáciu a úhradu treba vyriešiť pred začatím liečby; odborné odporúčanie samo nemení SPC. [11]</p>
<h2>Bezpečné sledovanie je súčasťou indikácie</h2>
<p>Pred novým nasadením alebo titráciou treba poznať trend kreatinínu a kaliémie, krvný tlak vrátane príznakov ortostatickej hypotenzie, objemový stav a súbežnú medikáciu. Osobitnú pozornosť vyžadujú nesteroidové protizápalové lieky, doplnky a náhrady soli s draslíkom, trimetoprim a draslík šetriace lieky. KDIGO odporúča kontrolu tlaku, kreatinínu a draslíka do dvoch až štyroch týždňov po začatí alebo zvýšení dávky podľa východiskovej GFR a kaliémie. V G5 treba termín individualizovať a pri vysokom riziku alebo klinickej zmene kontrolovať skôr, nie mechanicky čakať štyri týždne. [1, 4, 5]</p>
<p>Pri zvládnuteľnej hyperkaliémii možno podľa príčiny upraviť súbežné lieky a stravu, korigovať metabolickú acidózu, využiť diuretikum pri zachovanej diuréze alebo liek viažuci draslík. U dialyzovaného pacienta sa prehodnocuje aj dialyzačná liečba. Cieľom je umožniť odôvodnenú liečbu, nie udržať ACEI/ARB za každú cenu. Pretrvávajúca nekontrolovaná hyperkaliémia a symptomatická hypotenzia zostávajú dôvodmi na redukciu alebo vysadenie. [1]</p>
<h2>Hranice dôkazov a klinického rozhodnutia</h2>
<p>Najpevnejším záverom je neprítomnosť prínosu rutinného vysadzovania tolerovanej blokády renín-angiotenzínového systému iba pre pokročilú CKD. Menej isté zostáva prvé nasadenie pri veľmi nízkej filtrácii, univerzálna kardioprotekcia pri hemodialýze a rozsah ochrany reziduálnej funkcie pri peritoneálnej dialýze. Odborne obhájiteľné rozhodnutie preto obsahuje konkrétnu indikáciu, kontrolu SPC, bezpečnostný plán a kritériá prehodnotenia liečby. Samotné „CKD G5“ nenahrádza ani indikáciu, ani kontraindikáciu.</p>
<hr><p><em>Text je určený zdravotníckym pracovníkom. Ide o odbornú syntézu odporúčaní, štúdií a regulačných dokumentov, nie o individuálny liečebný plán.</em></p>
<h2>Literatúra a regulačné zdroje</h2>
<ol>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney international. 2024;105(4S):S117-S314. DOI: <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.10.018</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Sunil Bhandari, Samir Mehta, Arif Khwaja, John G F Cleland, Natalie Ives, Elizabeth Brettell, Marie Chadburn, Paul Cockwell, STOP ACEi Trial Investigators. Renin-Angiotensin System Inhibition in Advanced Chronic Kidney Disease. The New England journal of medicine. 2022;387(22):2021-2032. DOI: <a href="https://doi.org/10.1056/NEJMoa2210639" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2210639</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36326117/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Elaine Ku, Lesley A Inker, Hocine Tighiouart, Charles E McCulloch, Ogechi M Adingwupu, Tom Greene, Raymond O Estacio, Mark Woodward, Dick de Zeeuw, Julia B Lewis, Thierry Hannedouche, Tazeen H Jafar, Enyu Imai, Giuseppe Remuzzi, Hiddo J L Heerspink, Fan Fan Hou, Robert D Toto, Philip K Li, Mark J Sarnak. Angiotensin-Converting Enzyme Inhibitors or Angiotensin-Receptor Blockers for Advanced Chronic Kidney Disease : A Systematic Review and Retrospective Individual Participant-Level Meta-analysis of Clinical Trials. Annals of internal medicine. 2024;177(7):953-963. DOI: <a href="https://doi.org/10.7326/M23-3236" target="_blank" rel="noopener noreferrer">10.7326/M23-3236</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38950402/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>MEDOCHEMIE Ltd. RAMIMED 2,5 mg, 5 mg a 10 mg. Súhrn charakteristických vlastností lieku, 04/2022. Časti 4.1 až 4.5. <a href="https://www.sukl.sk/ramimed-5-mg-53520" target="_blank" rel="noopener noreferrer">ŠÚKL, záznam lieku</a>. <a href="https://www.sukl.sk/document/download?dok_id=720111&amp;dok_sec=1bdce632c98807da33724796697d2bd4" target="_blank" rel="noopener noreferrer">SPC, PDF</a>.</em></small></li>
<li><small><em>Zentiva a.s. Losartan Zentiva 12,5 mg, 50 mg a 100 mg. Súhrn charakteristických vlastností lieku, 07/2026. Časti 4.1 až 4.5 a 5.2. <a href="https://www.sukl.sk/losartan-zentiva-50-mg-filmom-obalene-tablety-49527" target="_blank" rel="noopener noreferrer">ŠÚKL, záznam lieku</a>. <a href="https://www.sukl.sk/document/download?dok_id=901088&amp;dok_sec=abf6604c781cd70c2c91ac8cf7f79779" target="_blank" rel="noopener noreferrer">SPC, PDF</a>.</em></small></li>
<li><small><em>Piero Ruggenenti, Manuel Alfredo Podestà, Matias Trillini, Annalisa Perna, Tobia Peracchi, Nadia Rubis, Davide Villa, Davide Martinetti, Monica Cortinovis, Patrizia Ondei, Carmela Giuseppina Condemi, Carlo Maria Guastoni, Agnese Meterangelis, Antonio Granata, Emanuele Mambelli, Sonia Pasquali, Simonetta Genovesi, Federico Pieruzzi, Silvio Volmer Bertoli, Goffredo Del Rosso, Maurizio Garozzo, Angelo Rigotti, Claudio Pozzi, Salvatore David, Giuseppe Daidone, Giulio Mingardi, Giovanni Mosconi, Andrea Galfré, Giorgio Romei Longhena, Alfonso Pacitti, Antonello Pani, Jorge Hidalgo Godoy, Hans-Joachim Anders, Giuseppe Remuzzi, ARCADIA Study Organization. Ramipril and Cardiovascular Outcomes in Patients on Maintenance Hemodialysis: The ARCADIA Multicenter Randomized Controlled Trial. Clinical journal of the American Society of Nephrology : CJASN. 2021;16(4):575-587. DOI: <a href="https://doi.org/10.2215/CJN.12940820" target="_blank" rel="noopener noreferrer">10.2215/CJN.12940820</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33782036/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Philip Kam-Tao Li, Kai-Ming Chow, Teresa Yuk-Hwa Wong, Chi-Bon Leung, Cheuk-Chun Szeto. Effects of an angiotensin-converting enzyme inhibitor on residual renal function in patients receiving peritoneal dialysis. A randomized, controlled study. Annals of internal medicine. 2003;139(2):105-112. DOI: <a href="https://doi.org/10.7326/0003-4819-139-2-200307150-00010" target="_blank" rel="noopener noreferrer">10.7326/0003-4819-139-2-200307150-00010</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/12859160/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Iris E Beldhuis, Carolyn S P Lam, Jeffrey M Testani, Adriaan A Voors, Harriette G C Van Spall, Jozine M Ter Maaten, Kevin Damman. Evidence-Based Medical Therapy in Patients With Heart Failure With Reduced Ejection Fraction and Chronic Kidney Disease. Circulation. 2022;145(9):693-712. DOI: <a href="https://doi.org/10.1161/CIRCULATIONAHA.121.052792" target="_blank" rel="noopener noreferrer">10.1161/CIRCULATIONAHA.121.052792</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35226558/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Valentin Maisons, Margaux Costes-Albrespic, Sophie Liabeuf, Solène M Laville, Ziad Massy, Angelo Karaboyas, Roberto Pecoits-Filho, Emilie Moutard, Marie Metzger, Jean-Michel Halimi, Etienne Dantan, Natalia Alencar de Pinho, Bénédicte Sautenet. Impact of renin-angiotensin system inhibitors discontinuation in advanced chronic kidney disease: a target trial emulation. Clinical kidney journal. 2026;19(10):sfag304. DOI: <a href="https://doi.org/10.1093/ckj/sfag304" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag304</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42851449/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://u-picardie.hal.science/hal-05740728/document" target="_blank" rel="noopener noreferrer">Plný text v HAL</a>.</em></small></li>
<li><small><em>Jing Xin Goh, Kamal Sud, Katrina Chau, Surjit Tarafdar, Elvira Dsouza, Nazim Bhimani, Ronald L Castelino. Effect of Renin-Angiotensin System Inhibition on Residual Kidney Function in Peritoneal Dialysis. Medicina (Kaunas, Lithuania). 2026;62(2):282. DOI: <a href="https://doi.org/10.3390/medicina62020282" target="_blank" rel="noopener noreferrer">10.3390/medicina62020282</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41752681/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Národná rada Slovenskej republiky. Zákon č. 362/2011 Z. z. o liekoch a zdravotníckych pomôckach a o zmene a doplnení niektorých zákonov, § 119 ods. 15 písm. i), časová verzia účinná od 1. novembra do 31. decembra 2026. <a href="https://static.slov-lex.sk/static/SK/ZZ/2011/362/20261101.print.html" target="_blank" rel="noopener noreferrer">Slov-Lex, časová verzia</a>.</em></small></li>
<li><small><em>Sunil Bhandari, Samir Mehta, Arif Khwaja, John G F Cleland, Natalie Ives, Elizabeth Brettell, Marie Chadburn, Paul Cockwell, STOP-ACEi Trial Investigators. Withdrawal of renin-angiotensin system inhibitors’ effect on estimated glomerular filtration rate in adults with advanced kidney disease: the STOP-ACEi RCT. Efficacy and Mechanism Evaluation. 2024;11(5):1-60. <a href="https://doi.org/10.3310/TTMC6210" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38564538/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://www.journalslibrary.nihr.ac.uk/eme/TTMC6210" target="_blank" rel="noopener noreferrer">Plný text</a>. <a href="https://www.journalslibrary.nihr.ac.uk/sites/journalslibrary/files/journal_data/TTMC6210/11-30-07-supp1.pdf" target="_blank" rel="noopener noreferrer">Suplement, PDF</a>.</em></small></li>
</ol>
<p><small><em>Rozsah overenia po doplňujúcej kontrole: plné texty STOP ACEi, metaanalýzy Ku a spoluautorov, prehľadu Beldhuis a spoluautorov a kohorty Goh a spoluautorov; podrobná správa STOP ACEi z roku 2024 a jej 24-stranový suplement, osobitne tabuľky S1 až S4. Odporúčania KDIGO a relevantné časti slovenských SPC boli overené v plných dokumentoch. Pri ARCADIA a štúdii Li z roku 2003 zostáva kontrola obmedzená na bibliografiu a úplné abstrakty. Pri CKD-REIN bola overená úplná publikovaná verzia z repozitára HAL. Samostatné suplementy metaanalýzy Ku, prehľadu Beldhuis, ARCADIA a CKD-REIN sa nepodarilo obsahovo overiť. Suplement správy NIHR sa nezamieňa za kompletnú prílohu pôvodného článku v NEJM. Rozdiel medzi randomizovaným dôkazom, observačnou súvislosťou a klinickou interpretáciou zostáva zachovaný. Stav overenia: 17. november 2026.</em></small></p>
<h3>Súvisiace články</h3><ul><li><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Hyperkaliémia, blokáda RAAS a viazače draslíka</a></li><li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia liečby RAASi a MRA pri hyperkaliémii</a></li></ul>

HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome , pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_acei-arb-ckd-g5-indikacie-off-label_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
