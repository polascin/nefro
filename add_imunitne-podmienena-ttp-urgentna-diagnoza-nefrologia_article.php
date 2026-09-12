<?php
/**
 * Odborný prehľad iTTP; vecná a jazyková revízia 12. 9. 2026.
 * Idempotentné publikovanie podľa add_TEMPLATE_article.php.
 */

// Ochrana – len admin alebo CLI
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
    'title'        => 'Imunitne podmienená trombotická trombocytopenická purpura: urgentná diagnóza aj v nefrologickej praxi',
    'slug'         => 'imunitne-podmienena-ttp-urgentna-diagnoza-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ako rozpoznať imunitne podmienenú TTP, odlíšiť ju od iných mikroangiopatií a bezodkladne začať liečbu. ADAMTS13, výmena plazmy, kaplacizumab a sledovanie po remisii.',
    'content'      => <<<'HTML'
<p class="article-dek"><strong>Trombotická trombocytopenická purpura je život ohrozujúca trombotická mikroangiopatia. Včasné rozpoznanie a bezodkladná liečba rozhodujú o prežití aj rozsahu orgánového poškodenia. Pre nefrológa je zásadné odlíšiť ju od hemolyticko-uremických syndrómov a ďalších príčin trombotickej mikroangiopatie, pretože podobný klinický obraz môže vyžadovať odlišnú liečbu.</strong></p>

<h2>Čo znamenajú označenia aTTP a iTTP?</h2>
<p>Trombotická trombocytopenická purpura (TTP) vzniká pri závažnom nedostatku aktivity proteázy ADAMTS13. Tento enzým štiepi multiméry von Willebrandovho faktora. Pri jeho nedostatočnej aktivite pretrvávajú mimoriadne veľké, vysoko trombogénne multiméry, ktoré podporujú adhéziu a agregáciu trombocytov v mikrocirkulácii. Vznikajú mikrotromby bohaté na trombocyty, dochádza k ich spotrebe a ischemickému poškodeniu orgánov. Mechanická fragmentácia erytrocytov vedie k mikroangiopatickej hemolytickej anémii. <a href="#zdroj-1">[1]</a></p>
<ul>
  <li><strong>Imunitne podmienená TTP (iTTP):</strong> autoprotilátky inhibujú ADAMTS13 alebo urýchľujú jeho odstraňovanie z cirkulácie; oba mechanizmy sa môžu kombinovať.</li>
  <li><strong>Vrodená TTP (cTTP):</strong> závažný deficit ADAMTS13 spôsobujú patogénne varianty v oboch alelách génu <em>ADAMTS13</em>. Ochorenie sa môže prvýkrát prejaviť aj v dospelosti.</li>
</ul>
<p>Označenie <strong>získaná TTP</strong> (aTTP) sa tradične používa pre imunitne podmienenú formu. Skratka iTTP presnejšie vyjadruje jej mechanizmus. Mierny alebo stredne závažný pokles aktivity ADAMTS13 sa však vyskytuje aj pri iných ochoreniach a sám osebe nepotvrdzuje TTP. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>

<h2>Klinický obraz: na klasickú pentádu sa nečaká</h2>
<p>Historická pentáda zahŕňa trombocytopéniu, mikroangiopatickú hemolytickú anémiu, neurologické prejavy, poškodenie obličiek a horúčku. <strong>Prítomnosť všetkých piatich znakov nie je podmienkou diagnózy.</strong> Už nevysvetlená trombocytopénia spolu s mikroangiopatickou hemolytickou anémiou vyžaduje urgentné posúdenie možnosti TTP; čakať nemožno ani na zjavné prejavy orgánovej ischémie. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>
<p>Hemolýzu podporujú zvýšená aktivita laktátdehydrogenázy (LDH), znížený haptoglobín, zvýšený nekonjugovaný bilirubín a zvyčajne retikulocytóza. V periférnom krvnom nátere bývajú schistocyty. Ich neprítomnosť v úvodnom nátere však TTP spoľahlivo nevylučuje; pri pretrvávajúcom podozrení treba náter zopakovať. Priamy antiglobulínový test býva negatívny. Zvýšenie LDH neodráža iba hemolýzu, ale môže súvisieť aj s ischemickým poškodením tkanív. <a href="#zdroj-1">[1]</a> <a href="#zdroj-13">[13]</a></p>
<p>Neurologické prejavy siahajú od bolesti hlavy a zmätenosti po ložiskový deficit, epileptické záchvaty či poruchu vedomia. Srdcové postihnutie sa môže prejaviť zvýšením troponínu, arytmiou, srdcovým zlyhávaním alebo náhlou smrťou. Závažné poškodenie môže byť prítomné aj pri nenápadných subjektívnych ťažkostiach; preto do úvodného vyšetrenia patria EKG a troponín. <a href="#zdroj-1">[1]</a> <a href="#zdroj-9">[9]</a></p>

<h2>Obličkové postihnutie: dôležitý, ale nie absolútny rozlišovací znak</h2>
<p>Pri iTTP sa môžu vyskytnúť proteinúria, hematúria aj akútne poškodenie obličiek. Ťažké poškodenie s potrebou dialýzy je menej typické než pri komplementom sprostredkovanom hemolyticko-uremickom syndróme (HUS), ale <strong>TTP nevylučuje</strong>. Výrazná trombocytopénia pri relatívne zachovanej funkcii obličiek podporuje podozrenie na TTP; dominantné obličkové postihnutie rozširuje diferenciálnu diagnostiku. Rozhodujúci je výsledok ADAMTS13 v klinickom kontexte. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>
<p>Biopsia obličky spravidla nie je potrebná na stanovenie akútnej TTP a nesmie odďaľovať liečbu. Pri výraznej trombocytopénii predstavuje krvácavé riziko. Histologický nález trombotickej mikroangiopatie sám osebe neurčuje jej príčinu. <a href="#zdroj-11">[11]</a></p>

<h2>ADAMTS13: kľúčový diagnostický test</h2>
<p>V zodpovedajúcom klinickom kontexte je pre TTP charakteristická <strong>aktivita ADAMTS13 nižšia ako 10 %</strong>, obvykle vyjadrovaná aj ako menej než 10 IU/dl. Vyšetrenie funkčného inhibítora a protilátok proti ADAMTS13 pomáha určiť imunitný mechanizmus. <a href="#zdroj-2">[2]</a></p>
<p>Vzorku citrátovej plazmy treba odobrať <strong>pred začatím terapeutickej výmeny plazmy a pred podaním plazmy alebo iných krvných prípravkov</strong>. Odber však nesmie zdržať neodkladnú liečbu. Ak bola vzorka odobratá až po liečbe, treba túto okolnosť oznámiť laboratóriu a zohľadniť pri interpretácii. <a href="#zdroj-2">[2]</a></p>
<ul>
  <li><strong>Aktivita pod 10 %:</strong> pri kompatibilnom klinickom obraze silno podporuje diagnózu TTP.</li>
  <li><strong>Aktivita 10–20 %:</strong> hraničné pásmo; vyžaduje individuálne posúdenie, podľa okolností opakovanie vyšetrenia a preverenie možnej interferencie.</li>
  <li><strong>Aktivita nad 20 %:</strong> akútna TTP je menej pravdepodobná; treba aktívne hľadať inú príčinu a skontrolovať načasovanie odberu.</li>
</ul>
<p>Negatívny funkčný test inhibítora nevylučuje iTTP. Niektoré autoprotilátky pôsobia predovšetkým zvýšeným odstraňovaním ADAMTS13, ktoré sa v tomto teste nemusí zachytiť. Pri pretrvávajúcom závažnom deficite bez preukázaných protilátok treba podľa okolností zopakovať imunologické vyšetrenie a zvážiť genetickú diagnostiku cTTP. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a></p>

<h2>Prvé kroky pri podozrení na TTP</h2>
<p>Bezodkladne treba kontaktovať hematológa a pracovisko schopné zabezpečiť terapeutickú výmenu plazmy (TPE). Pacient s neurologickým, srdcovým alebo iným závažným orgánovým postihnutím môže potrebovať intenzívnu starostlivosť. Úvodné vyšetrenie zahŕňa najmä: <a href="#zdroj-1">[1]</a> <a href="#zdroj-9">[9]</a></p>
<ul>
  <li>krvný obraz, retikulocyty a periférny krvný náter;</li>
  <li>LDH, bilirubín, haptoglobín a priamy antiglobulínový test;</li>
  <li>kreatinín, elektrolyty, vyšetrenie moču a sledovanie diurézy;</li>
  <li>koagulačné vyšetrenia vrátane fibrinogénu;</li>
  <li>aktivitu ADAMTS13, protilátky proti ADAMTS13 a funkčný inhibítor podľa dostupnosti;</li>
  <li>EKG a troponín, podľa nálezu aj echokardiografiu;</li>
  <li>ďalšie vyšetrenia podľa klinického obrazu, napríklad mikrobiologické vyšetrenie stolice na baktérie produkujúce Shiga toxín, vitamín B12, vyšetrenie infekcií a tehotenský test.</li>
</ul>
<p>Na odhad pravdepodobnosti závažného deficitu ADAMTS13 možno u dospelých použiť <strong>skóre PLASMIC</strong>. Hodnotí počet trombocytov, známky hemolýzy, neprítomnosť aktívneho nádorového ochorenia, neprítomnosť transplantácie, stredný objem erytrocytov, INR a kreatinín. Hodnoty 0–4 zodpovedajú nízkemu, 5 strednému a 6–7 vysokému riziku závažného deficitu ADAMTS13. Skóre nenahrádza jeho meranie ani klinický úsudok a neurčuje imunitnú či vrodenú etiológiu. Jeho spoľahlivosť je obmedzená najmä u detí, v gravidite a pri závažných pridružených ochoreniach, ako sú sepsa, malignita alebo stav po transplantácii. <a href="#zdroj-2">[2]</a></p>
<p><strong>Pri vysokej klinickej pravdepodobnosti TTP sa TPE a kortikosteroidy začínajú bez čakania na výsledok ADAMTS13.</strong> Začatie kaplacizumabu pred potvrdením diagnózy má osobitné podmienky: rozhoduje skúsené pracovisko podľa pravdepodobnosti iTTP, krvácavého rizika a dostupnosti rýchleho výsledku ADAMTS13. Pri nízkej alebo strednej pravdepodobnosti sa na potvrdenie závažného deficitu pred jeho podaním čaká. Ak test ADAMTS13 vôbec nie je dostupný, diagnostické odporúčania ISTH empirické podanie kaplacizumabu neodporúčajú. <a href="#zdroj-2">[2]</a></p>

<h2>Diferenciálna diagnostika trombotickej mikroangiopatie</h2>
<p>Trombotická mikroangiopatia (TMA) je syndróm, nie konečná etiologická diagnóza. Orientačné znaky pomáhajú určiť ďalší postup, ale žiadny z nich sám osebe spoľahlivo nerozlíši všetky príčiny. <a href="#zdroj-1">[1]</a> <a href="#zdroj-11">[11]</a></p>
<div class="table-responsive" role="region" aria-label="Diferenciálna diagnostika trombotickej mikroangiopatie" tabindex="0">
<table>
  <thead><tr><th scope="col">Stav</th><th scope="col">Dôležité orientačné znaky</th></tr></thead>
  <tbody>
    <tr><th scope="row">Imunitne podmienená TTP</th><td>Závažný deficit ADAMTS13, často výrazná trombocytopénia, neurologické a srdcové prejavy.</td></tr>
    <tr><th scope="row">HUS asociovaný so Shiga toxínom</th><td>Často predchádzajúce gastrointestinálne príznaky; potrebná mikrobiologická diagnostika, obličkové postihnutie býva výrazné.</td></tr>
    <tr><th scope="row">Komplementom sprostredkovaný HUS/TMA</th><td>Často závažné poškodenie obličiek a hypertenzia; aktivita ADAMTS13 spravidla nie je znížená pod 10 %.</td></tr>
    <tr><th scope="row">Diseminovaná intravaskulárna koagulácia</th><td>Vyvolávajúce ochorenie a častejšie výrazné odchýlky koagulačných parametrov; včasná fáza nemusí mať všetky typické zmeny.</td></tr>
    <tr><th scope="row">TMA pri hypertenznej emergencii</th><td>Závažná hypertenzia a orgánové poškodenie; hypertenzia môže byť príčinou aj následkom TMA.</td></tr>
    <tr><th scope="row">HELLP syndróm a ďalšie TMA v gravidite</th><td>Dôležité sú gestačný kontext, pečeňové parametre, pôrodnícky nález a ADAMTS13.</td></tr>
    <tr><th scope="row">Sekundárne TMA</th><td>Súvislosť s liekmi, transplantáciou, nádorovým alebo autoimunitným ochorením.</td></tr>
    <tr><th scope="row">Ťažký deficit vitamínu B12 s obrazom pseudo-TMA</th><td>Neefektívna krvotvorba, neprimerane nízka retikulocytová odpoveď a často veľmi vysoká LDH. <a href="#zdroj-12">[12]</a></td></tr>
  </tbody>
</table>
</div>
<p>Normálne koncentrácie C3 a C4 <strong>nevylučujú</strong> komplementom sprostredkovanú TMA. Samotná hnačka nepotvrdzuje HUS asociovaný so Shiga toxínom a neprítomnosť hnačky ho úplne nevylučuje. Pri podozrení na komplementom sprostredkovanú TMA sa liečebné rozhodnutie neopiera iba o koncentrácie komplementových zložiek alebo čakanie na genetický výsledok. <a href="#zdroj-1">[1]</a> <a href="#zdroj-11">[11]</a></p>

<h2>Akútna liečba iTTP: štyri zložky s rozdielnymi cieľmi</h2>
<p>Liečba kombinuje doplnenie chýbajúcej proteázy, odstránenie autoprotilátok, potlačenie ich tvorby a rýchle obmedzenie mikrotrombózy. <strong>Aktualizácia ISTH z roku 2025 ponechala odporúčania pre iTTP z roku 2020 v platnosti:</strong> pridanie kortikosteroidov k TPE má silné odporúčanie, pridanie rituximabu a kaplacizumabu podmienené odporúčanie. To platí pre prvú akútnu epizódu aj relaps; podmienenosť vyjadruje potrebu zohľadniť istotu dôkazov, dostupnosť liečby a situáciu pacienta. <a href="#zdroj-3">[3]</a> <a href="#zdroj-4">[4]</a></p>

<h3>Terapeutická výmena plazmy</h3>
<p>TPE s plazmou ako náhradným roztokom odstraňuje cirkulujúce autoprotilátky a dopĺňa funkčný ADAMTS13. V akútnej fáze sa spravidla vykonáva denne podľa hematologického protokolu. Samotná infúzia plazmy nie je pri iTTP rovnocennou náhradou TPE; ak výmena nie je okamžite dostupná, môže slúžiť ako preklenovacie opatrenie počas zabezpečovania urgentného transportu. U pacienta s obličkovým alebo srdcovým poškodením treba zohľadniť riziko objemového preťaženia. <a href="#zdroj-1">[1]</a> <a href="#zdroj-9">[9]</a></p>
<p>Ukončenie výmen sa neurčuje podľa jedného krvného obrazu. Hodnotí sa udržaná úprava počtu trombocytov, ústup hemolýzy a orgánových prejavov. Pri kaplacizumabe môže počet trombocytov stúpnuť skôr, než sa obnoví aktivita ADAMTS13; tento rozdiel je zásadný najmä pri rozhodovaní o pokračovaní kaplacizumabu a imunosupresie. <a href="#zdroj-1">[1]</a> <a href="#zdroj-3">[3]</a></p>

<h3>Kortikosteroidy</h3>
<p>Kortikosteroidy sa podávajú spolu s TPE na potlačenie autoimunitného procesu. Konkrétny režim závisí od závažnosti ochorenia a protokolu pracoviska. Treba sledovať krvný tlak, glykémiu, infekčné komplikácie a ďalšie nežiaduce účinky; osobitnú pozornosť si vyžadujú pacienti s poškodením obličiek, diabetom alebo kardiovaskulárnym ochorením. <a href="#zdroj-3">[3]</a></p>

<h3>Kaplacizumab</h3>
<p>Kaplacizumab sa viaže na doménu A1 von Willebrandovho faktora a blokuje jeho interakciu s trombocytmi. Tým rýchlo obmedzuje tvorbu mikrotrombov. <strong>Neodstraňuje autoprotilátky ani priamo neobnovuje aktivitu ADAMTS13</strong>, preto nenahrádza imunosupresiu. <a href="#zdroj-3">[3]</a> <a href="#zdroj-5">[5]</a></p>
<p>Randomizovaná štúdia HERCULES so 145 pacientmi preukázala rýchlejšiu úpravu počtu trombocytov a nižší výskyt kombinovaného ukazovateľa úmrtia súvisiaceho s TTP, recidívy TTP alebo veľkej tromboembolickej príhody počas liečby: 12 % pri kaplacizumabe oproti 49 % pri placebe. Obe skupiny dostávali aj TPE a imunosupresiu. <strong>Pokles kombinovaného ukazovateľa nemožno interpretovať ako rovnaké zníženie samotnej úmrtnosti.</strong> Krvácanie, najmä slizničné, bolo častejšie pri kaplacizumabe. <a href="#zdroj-6">[6]</a></p>
<p>Podľa slovenského súhrnu charakteristických vlastností lieku (SPC) sa u dospelých podáva prvá dávka 10 mg intravenózne pred TPE; následne 10 mg subkutánne denne po výmene a ešte 30 dní po ukončení každodenných výmen. Pri pretrvávajúcom imunologickom ochorení sa optimalizuje imunosupresia a pokračuje v podávaní podľa SPC a rozhodnutia centra. Samotná normalizácia trombocytov preto nestačí na ukončenie liečby. Pri poruche funkcie obličiek sa dávka podľa SPC neupravuje. <a href="#zdroj-5">[5]</a></p>
<ul>
  <li>Po ukončení kaplacizumabu pri pretrvávajúcom závažnom deficite ADAMTS13 hrozí opätovné vzplanutie ochorenia.</li>
  <li>Okrem slizničného krvácania sa môže vyskytnúť aj závažné, život ohrozujúce krvácanie.</li>
  <li>Pri klinicky významnom krvácaní sa liečba prerušuje; ďalší postup určuje skúsené pracovisko.</li>
  <li>Súbežná antikoagulačná, protidoštičková alebo trombolytická liečba vyžaduje individuálne posúdenie rizika a dôsledné sledovanie.</li>
  <li>Pred plánovaným invazívnym výkonom SPC odporúča prerušenie aspoň na 7 dní; pri urgentnom výkone treba hemostatický postup koordinovať s hematológom.</li>
</ul>
<p>Registračná indikácia Cablivi v EÚ zostáva viazaná na kombináciu s výmenou plazmy a imunosupresiou. Registrácia sama osebe nedokladá okamžitú dostupnosť ani úhradu na konkrétnom slovenskom pracovisku; tie treba overiť pri zabezpečovaní liečby. <a href="#zdroj-5">[5]</a></p>

<h3>Rituximab</h3>
<p>Rituximab pôsobí proti CD20-pozitívnym B-lymfocytom a pomáha potlačiť tvorbu autoprotilátok. Jeho účinok nie je okamžitý, preto nenahrádza urgentnú TPE ani rýchlu kontrolu mikrotrombózy. Pred podaním treba vyšetriť infekciu vírusom hepatitídy B, minimálne HBsAg a anti-HBc, a pri pozitívnom náleze zabezpečiť odborný postup na prevenciu reaktivácie. Načasovanie podania sa koordinuje s TPE, ktorá môže časť lieku odstrániť z cirkulácie. Použitie rituximabu pri iTTP je odporúčaniami podporovaná liečba mimo schválenej indikácie lieku (off-label). <a href="#zdroj-1">[1]</a> <a href="#zdroj-3">[3]</a> <a href="#zdroj-10">[10]</a></p>

<h2>Možno dnes vynechať výmenu plazmy?</h2>
<p>Dôkazy už presahujú jednotlivé kazuistiky. Retrospektívna multicentrická kohorta publikovaná v roku 2024 opísala liečbu vybraných pacientov kaplacizumabom a imunosupresiou bez TPE; pri nedostatočnej odpovedi bola potrebná záchranná TPE. Nerandomizovaný výber pacientov však obmedzuje závery o rovnocennosti postupov. <a href="#zdroj-7">[7]</a></p>
<p>V otvorenej jednoramennej štúdii fázy 3 MAYARI bolo podľa registra zaradených 51 účastníkov. Primárny výsledok sa vyhodnocoval u 46: remisiu bez potreby TPE dosiahlo 93,5 % (95 % interval spoľahlivosti 82,5–97,8 %). Výsledky registra boli zverejnené 30. decembra 2025. Štúdia vylučovala okrem iného pacientov so závažným neurologickým alebo srdcovým postihnutím, potrebou okamžitého invazívneho výkonu či klinicky významným aktívnym krvácaním. <strong>Chýbala randomizovaná kontrolná skupina a výsledok nemožno preniesť na všetkých pacientov s akútnou iTTP.</strong> <a href="#zdroj-8">[8]</a></p>
<p>Režim bez TPE preto patrí do špecializovaného rozhodovania s rýchlym potvrdením diagnózy, dôsledným sledovaním ADAMTS13 a okamžite dostupnou záchrannou TPE. Pre bežný urgentný postup zostáva základom bezodkladné zabezpečenie štandardnej kombinovanej liečby podľa odporúčaní a SPC. <a href="#zdroj-4">[4]</a> <a href="#zdroj-5">[5]</a> <a href="#zdroj-8">[8]</a></p>

<h2>Podporná starostlivosť</h2>
<p>Pacient potrebuje priebežné sledovanie neurologického stavu, srdcovej činnosti, diurézy, krvného obrazu, hemolýzy a funkcie obličiek. Dôležité sú tieto zásady: <a href="#zdroj-1">[1]</a> <a href="#zdroj-4">[4]</a> <a href="#zdroj-9">[9]</a></p>
<ul>
  <li><strong>Trombocyty sa profylakticky nepodávajú iba pre nízky počet.</strong> Transfúzia môže byť odôvodnená pri život ohrozujúcom krvácaní alebo výnimočne pri neodkladnom výkone po individuálnom odbornom posúdení. Zavedenie centrálneho venózneho katétra samo osebe neznamená automatickú potrebu transfúzie trombocytov.</li>
  <li>Transfúzia erytrocytov sa riadi klinickým stavom a závažnosťou anémie.</li>
  <li>Farmakologickú tromboprofylaxiu možno zvažovať po vzostupe trombocytov nad 50 × 10<sup>9</sup>/l, so zohľadnením trombotického a krvácavého rizika, kaplacizumabu aj funkcie obličiek. Nejde o automatický pokyn na podanie antikoagulancia.</li>
  <li>Dialýza sa indikuje podľa obvyklých klinických kritérií pri akútnom poškodení obličiek; nelieči základný mechanizmus TTP.</li>
  <li>Inhibícia komplementu nie je štandardnou liečbou potvrdenej iTTP. Je zásadná pri vybraných iných TMA, najmä pri komplementom sprostredkovanom HUS.</li>
</ul>
<p>Rovnako treba odlíšiť liečbu cTTP: aktualizácia ISTH z roku 2025 pri vrodenej forme v remisii uprednostňuje dostupný rekombinantný ADAMTS13 pred čerstvo zmrazenou plazmou. Toto odporúčanie sa <strong>nevzťahuje na rutinnú liečbu iTTP</strong>. <a href="#zdroj-4">[4]</a></p>

<h2>Remisia neznamená koniec sledovania</h2>
<p>iTTP je ochorenie s rizikom relapsov a dlhodobých následkov. Aj po normalizácii krvného obrazu môžu pretrvávať únava, poruchy koncentrácie a pamäti, depresívne alebo úzkostné príznaky; treba sledovať aj hypertenziu a kardiovaskulárne riziko. Klinická remisia a úprava aktivity ADAMTS13 nie sú totožné stavy. <a href="#zdroj-1">[1]</a> <a href="#zdroj-9">[9]</a></p>
<p>Následná starostlivosť zahŕňa hematologické kontroly s meraním ADAMTS13 a krvným obrazom, pri podozrení na relaps aj parametre hemolýzy. Nefrologické sledovanie sa prispôsobuje rozsahu obličkového postihnutia a zahŕňa krvný tlak, funkciu obličiek a proteinúriu. Súčasťou kontroly má byť zhodnotenie psychických a kognitívnych ťažkostí aj poučenie o príznakoch vyžadujúcich okamžité vyšetrenie. <a href="#zdroj-1">[1]</a> <a href="#zdroj-9">[9]</a></p>
<p>Odporúčania správnej klinickej praxe uvádzajú ako orientačný režim kontroly každý mesiac počas prvých troch mesiacov, potom každé tri mesiace počas prvého roka a pri stabilnom stave každých 6–12 mesiacov. Pri klesajúcej aktivite ADAMTS13 sa kontroly zintenzívňujú; nejde o univerzálny interval vhodný pre každého pacienta. <a href="#zdroj-9">[9]</a></p>
<p>Pokles ADAMTS13 počas klinickej remisie môže predchádzať relapsu, ale neznamená jeho bezprostredný vznik. U vybraných pacientov s pretrvávajúcou alebo opakovane výrazne zníženou aktivitou sa zvažuje preemptívna liečba rituximabom. Rozhoduje špecializované pracovisko podľa vývoja hodnôt, predchádzajúceho priebehu a individuálnych rizík. Ženy plánujúce graviditu potrebujú predkoncepčnú konzultáciu a spoločný plán hematológa a pôrodníka, podľa potreby aj nefrológa. <a href="#zdroj-3">[3]</a> <a href="#zdroj-9">[9]</a></p>

<h2>Záver pre klinickú prax</h2>
<p><strong>Nevysvetlená trombocytopénia s mikroangiopatickou hemolytickou anémiou je dôvodom na urgentné posúdenie možnosti TTP.</strong> Vzorku na ADAMTS13 treba odobrať pred podaním plazmy, ale pri vysokej klinickej pravdepodobnosti sa nesmie čakať s TPE a kortikosteroidmi na výsledok. Závažnosť poškodenia obličiek nie je absolútnym rozlišovacím kritériom. Úspešná liečba musí zvládnuť mikrotrombózu aj autoimunitný proces a pokračovať dlhodobým sledovaním. <a href="#zdroj-1">[1]</a> <a href="#zdroj-2">[2]</a> <a href="#zdroj-4">[4]</a></p>

<hr>
<h2>Zdroje</h2>
<p><em>Odborné odporúčania a informácie o liekoch overené k 12. septembru 2026.</em></p>
<ol>
<li id="zdroj-1">M. Scully; R. Rayment; A. Clark; J. P. Westwood; T. Cranfield; R. Gooding; C. N. Bagot; A. Taylor; V. Sankar; D. Gale; T. Dutt; J. McIntyre; W. Lester; the BSH Committee; BSH Committee. A British Society for Haematology Guideline: Diagnosis and management of thrombotic thrombocytopenic purpura and thrombotic microangiopathies. <em>British Journal of Haematology</em>. 2023;203(4):546–563. <a href="https://doi.org/10.1111/bjh.19026" target="_blank" rel="noopener noreferrer">DOI: 10.1111/bjh.19026</a>.</li>
<li id="zdroj-2">X. Long Zheng; Sara K. Vesely; Spero R. Cataland; Paul Coppo; Brian Geldziler; Alfonso Iorio; Masanori Matsumoto; Reem A. Mustafa; Menaka Pai; Gail Rock; Lene Russell; Rawan Tarawneh; Julie Valdes; Flora Peyvandi. ISTH guidelines for the diagnosis of thrombotic thrombocytopenic purpura. <em>Journal of Thrombosis and Haemostasis</em>. 2020;18(10):2486–2495. <a href="https://doi.org/10.1111/jth.15006" target="_blank" rel="noopener noreferrer">DOI: 10.1111/jth.15006</a>.</li>
<li id="zdroj-3">X. Long Zheng; Sara K. Vesely; Spero R. Cataland; Paul Coppo; Brian Geldziler; Alfonso Iorio; Masanori Matsumoto; Reem A. Mustafa; Menaka Pai; Gail Rock; Lene Russell; Rawan Tarawneh; Julie Valdes; Flora Peyvandi. ISTH guidelines for treatment of thrombotic thrombocytopenic purpura. <em>Journal of Thrombosis and Haemostasis</em>. 2020;18(10):2496–2502. <a href="https://doi.org/10.1111/jth.15010" target="_blank" rel="noopener noreferrer">DOI: 10.1111/jth.15010</a>.</li>
<li id="zdroj-4">X. Long Zheng; Zainab Al-Housni; Spero R. Cataland; Paul Coppo; Brian Geldziler; Federico Germini; Alfonso Iorio; Arun Keepanasseril; Camila Masias; Masanori Matsumoto; Keith R. McCrae; Jo McIntyre; Reem A. Mustafa; Flora Peyvandi; Lene Russell; Rawan Tarawneh; Sara K. Vesely; International Society on Thrombosis and Haemostasis. 2025 focused update of the 2020 ISTH guidelines for management of thrombotic thrombocytopenic purpura. <em>Journal of Thrombosis and Haemostasis</em>. 2025;23(11):3711–3732. <a href="https://doi.org/10.1016/j.jtha.2025.06.002" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.jtha.2025.06.002</a>.</li>
<li id="zdroj-5">European Medicines Agency. <em>Cablivi (kaplacizumab): súhrn charakteristických vlastností lieku</em>, najmä časti 4.1, 4.2, 4.4 a 5.1. <a href="https://www.ema.europa.eu/sk/documents/product-information/cablivi-epar-product-information_sk.pdf" target="_blank" rel="noopener noreferrer">Slovenské SPC (PDF)</a>.</li>
<li id="zdroj-6">Marie Scully; Spero R. Cataland; Flora Peyvandi; Paul Coppo; Paul Knöbl; Johanna A. Kremer Hovinga; Ara Metjian; Javier de la Rubia; Katerina Pavenski; Filip Callewaert; Debjit Biswas; Hilde De Winter; Robert K. Zeldin; HERCULES Investigators. Caplacizumab Treatment for Acquired Thrombotic Thrombocytopenic Purpura. <em>New England Journal of Medicine</em>. 2019;380(4):335–346. <a href="https://doi.org/10.1056/NEJMoa1806311" target="_blank" rel="noopener noreferrer">DOI: 10.1056/NEJMoa1806311</a>.</li>
<li id="zdroj-7">Lucas Kühne; Paul Knöbl; Kathrin Eller; Johannes Thaler; Wolfgang R. Sperr; Karoline Gleixner; Thomas Osterholt; Jessica Kaufeld; Jan Menne; Veronika Buxhofer-Ausch; Anja Mühlfeld; Evelyn Seelow; Adrian Schreiber; Polina Todorova; Sadrija Cukoski; Wolfram J. Jabs; Fedai Özcan; Anja Gäckler; Kristina Schönfelder; Felix S. Seibert; Timm Westhoff; Vedat Schwenger; Dennis A. Eichenauer; Linus A. Völker; Paul T. Brinkkoetter. Management of immune thrombotic thrombocytopenic purpura without therapeutic plasma exchange. <em>Blood</em>. 2024;144(14):1486–1495. <a href="https://doi.org/10.1182/blood.2023023780" target="_blank" rel="noopener noreferrer">DOI: 10.1182/blood.2023023780</a>.</li>
<li id="zdroj-8">Sanofi. Caplacizumab and Immunosuppressive Therapy Without Firstline Therapeutic Plasma Exchange in Adults With Immune-mediated Thrombotic Thrombocytopenic Purpura (MAYARI). <em>ClinicalTrials.gov</em>, NCT05468320. Výsledky zverejnené 30. 12. 2025. <a href="https://clinicaltrials.gov/study/NCT05468320" target="_blank" rel="noopener noreferrer">Register a výsledky štúdie</a>.</li>
<li id="zdroj-9">X. Long Zheng; Sara K. Vesely; Spero R. Cataland; Paul Coppo; Brian Geldziler; Alfonso Iorio; Masanori Matsumoto; Reem A. Mustafa; Menaka Pai; Gail Rock; Lene Russell; Rawan Tarawneh; Julie Valdes; Flora Peyvandi. Good practice statements (GPS) for the clinical care of patients with thrombotic thrombocytopenic purpura. <em>Journal of Thrombosis and Haemostasis</em>. 2020;18(10):2503–2512. <a href="https://doi.org/10.1111/jth.15009" target="_blank" rel="noopener noreferrer">DOI: 10.1111/jth.15009</a>.</li>
<li id="zdroj-10">European Medicines Agency. <em>MabThera (rituximab): súhrn charakteristických vlastností lieku</em>, najmä časti 4.1 a 4.4. <a href="https://www.ema.europa.eu/sk/documents/product-information/mabthera-epar-product-information_sk.pdf" target="_blank" rel="noopener noreferrer">Slovenské SPC (PDF)</a>.</li>
<li id="zdroj-11">Vicky Brocklebank; Katrina M. Wood; David Kavanagh. Thrombotic Microangiopathy and the Kidney. <em>Clinical Journal of the American Society of Nephrology</em>. 2018;13(2):300–317. <a href="https://doi.org/10.2215/CJN.00620117" target="_blank" rel="noopener noreferrer">DOI: 10.2215/CJN.00620117</a>.</li>
<li id="zdroj-12">N. Noel; G. Maigne; G. Tertian; N. Anguel; X. Monnet; J.- M. Michot; C. Goujard; O. Lambotte. Hemolysis and schistocytosis in the emergency department: consider pseudothrombotic microangiopathy related to vitamin B12 deficiency. <em>QJM</em>. 2013;106(11):1017–1022. <a href="https://doi.org/10.1093/qjmed/hct142" target="_blank" rel="noopener noreferrer">DOI: 10.1093/qjmed/hct142</a>.</li>
<li id="zdroj-13">M. Saha; J.K. McDaniel; X.L. Zheng. Thrombotic thrombocytopenic purpura: pathogenesis, diagnosis and potential novel therapeutics. <em>Journal of Thrombosis and Haemostasis</em>. 2017;15(10):1889–1900. <a href="https://doi.org/10.1111/jth.13764" target="_blank" rel="noopener noreferrer">DOI: 10.1111/jth.13764</a>.</li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_imunitne-podmienena-ttp-urgentna-diagnoza-nefrologia_article',
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
