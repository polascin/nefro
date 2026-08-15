<?php
/**
 * Odborny clanok: axialna spondyloartritida - diagnostika, zobrazovanie, liecba.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_axialna-spondyloartritida-diagnostika-zobrazovanie-liecba_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Axiálna spondyloartritída: včasná diagnostika, zobrazovanie a individualizovaná liečba',
    'slug'         => 'axialna-spondyloartritida-diagnostika-zobrazovanie-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Revízia klasifikačných kritérií ASAS-SPARTAN z roku 2025 a odporúčania ACR z roku 2026 menia váhu magnetickej rezonancie aj poradie cielenej liečby. Prehľad diagnostiky, zobrazovania a bezpečného výberu liekov.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Axiálna spondyloartritída sa nedá diagnostikovať jedným testom. Revidované klasifikačné kritériá ASAS-SPARTAN z roku 2025 znížili váhu izolovaného edému kostnej drene a odporúčania ACR, SAA a SPARTAN z roku 2026 postavili inhibítory TNF a interleukínu 17 na rovnakú úroveň ako prvú biologickú voľbu. Nasledujúci prehľad zhŕňa, čo z toho vyplýva pre včasnú diagnostiku, interpretáciu zobrazovania a bezpečný výber liečby vrátane pacientov s obličkovým rizikom.</em></p>

<h2>Čo je axiálna spondyloartritída</h2>

<p>Axiálna spondyloartritída, axSpA, patrí do skupiny spondyloartritíd. Zápal postihuje predovšetkým sakroiliakálne kĺby a chrbticu, ochorenie však môže mať aj periférne a mimokĺbové prejavy.</p>

<p>Súčasná koncepcia rozlišuje:</p>

<ul>
  <li><strong>nerádiografickú axiálnu spondyloartritídu</strong>, pri ktorej konvenčná rádiografia nepreukazuje jednoznačnú rádiografickú sakroiliitídu,</li>
  <li><strong>rádiografickú axiálnu spondyloartritídu</strong>, ktorá zodpovedá tradičnému pojmu ankylozujúca spondylitída.</li>
</ul>

<p>Rozdelenie vyjadruje predovšetkým prítomnosť alebo neprítomnosť jednoznačných štrukturálnych zmien na konvenčnej rádiografii, nie dve úplne oddelené choroby.</p>

<p>Pojem nerádiografická neznamená, že ochorenie je ľahké, neaktívne alebo neobjektívne. Pacient môže mať výraznú bolesť, stuhnutosť, únavu a funkčné obmedzenie aj bez pokročilých zmien na röntgenovej snímke.</p>

<p>Nie každý pacient s nerádiografickou formou progreduje do rádiografického štádia. Riziko progresie je vyššie pri mužskom pohlaví, fajčení, zvýšených zápalových parametroch, aktívnom zápale sakroiliakálnych kĺbov na magnetickej rezonancii a už prítomných štrukturálnych léziách. Ide však o populačné prediktory, nie o spoľahlivú prognózu konkrétneho pacienta.</p>

<h2>Kedy na ochorenie myslieť</h2>

<p>Podozrenie vzniká najmä pri chronickej bolesti chrbta, ktorá sa začala pred 45. rokom života a trvá najmenej tri mesiace.</p>

<p>Pre zápalovú bolesť chrbta sú typické:</p>

<ul>
  <li>nenápadný začiatok,</li>
  <li>zlepšenie pohybom,</li>
  <li>neprítomnosť úľavy alebo zhoršenie pri dlhom pokoji,</li>
  <li>nočná bolesť, najmä v druhej polovici noci,</li>
  <li>ranná stuhnutosť,</li>
  <li>striedavá bolesť v sedacej oblasti, teda alternujúca gluteálna bolesť.</li>
</ul>

<p>Tieto znaky zvyšujú pravdepodobnosť axSpA, samy osebe však diagnózu nepotvrdzujú. Podobné symptómy sa môžu objaviť pri mechanickej bolesti chrbta, poruchách spánku, fibromyalgii, hypermobilite, preťažení a ďalších ochoreniach.</p>

<p>Podozrenie ďalej podporujú:</p>

<ul>
  <li>akútna predná uveitída,</li>
  <li>psoriáza,</li>
  <li>Crohnova choroba alebo ulcerózna kolitída,</li>
  <li>periférna artritída,</li>
  <li>entezitída, najmä v oblasti úponu Achillovej šľachy,</li>
  <li>daktylitída,</li>
  <li>dobrá symptomatická odpoveď na nesteroidový protizápalový liek,</li>
  <li>výskyt spondyloartritídy v rodine,</li>
  <li>pozitivita HLA-B27,</li>
  <li>zvýšený C-reaktívny proteín,</li>
  <li>sakroiliitída na zobrazovacom vyšetrení.</li>
</ul>

<h2>Diagnostické oneskorenie</h2>

<p>Axiálna spondyloartritída sa často diagnostikuje až po niekoľkých rokoch príznakov. K oneskoreniu prispievajú:</p>

<ul>
  <li>vysoká prevalencia nešpecifickej bolesti chrbta,</li>
  <li>absencia špecifického biomarkera,</li>
  <li>normálny C-reaktívny proteín u časti pacientov,</li>
  <li>negatívna konvenčná rádiografia v skorom štádiu,</li>
  <li>nesprávna interpretácia magnetickej rezonancie,</li>
  <li>stereotypná predstava, že ochorenie postihuje takmer výlučne mladých mužov,</li>
  <li>podceňovanie axiálnej spondyloartritídy u žien.</li>
</ul>

<p>Ženy majú častejšie nerádiografickú formu, menej výraznú rádiografickú progresiu a niekedy väčšiu subjektívnu symptomatickú záťaž. Diagnostické pochybnosti však nemožno riešiť automatickým pripísaním symptómov axSpA. U každého pacienta treba rovnako dôsledne hodnotiť objektívne známky zápalu aj alternatívne príčiny bolesti.</p>

<h2>Klasifikačné kritériá nie sú diagnostické kritériá</h2>

<p>Klasifikačné kritériá ASAS z roku 2009 možno použiť u osoby s bolesťou chrbta trvajúcou najmenej tri mesiace, ktorá sa začala pred 45. rokom života. Pacient môže splniť:</p>

<ul>
  <li>zobrazovaciu vetvu, teda sakroiliitídu na zobrazovaní a najmenej jeden ďalší znak spondyloartritídy,</li>
  <li>klinickú vetvu, teda pozitivitu HLA-B27 a najmenej dva ďalšie znaky spondyloartritídy.</li>
</ul>

<p>Tieto kritériá boli vytvorené na zostavovanie relatívne homogénnych výskumných súborov. Ich splnenie nie je automaticky synonymom diagnózy a ich nesplnenie diagnózu definitívne nevylučuje.</p>

<h3>Revízia ASAS-SPARTAN z roku 2025</h3>

<p>Práve nedostatočná špecificita kritérií z roku 2009 viedla k ich revízii. V medzinárodnej inceptívnej kohorte CLASSIC bolo vyšetrených 1 015 pacientov odoslaných reumatológovi pre nediagnostikovanú bolesť chrbta; diagnózu axSpA napokon dostalo približne 37 % z nich. Referenčným štandardom bola diagnóza skúseného reumatológa.</p>

<p>Revidované kritériá:</p>

<ul>
  <li>zachovávajú vstupnú podmienku chronickej bolesti chrbta a veku pri začiatku,</li>
  <li>nahrádzajú dve vetvy váženým bodovým systémom odvodeným z regresie s regularizáciou LASSO,</li>
  <li>zaraďujú HLA-B27, zvýšený C-reaktívny proteín, zápalovú bolesť chrbta, zápalové ochorenie čreva, akútnu prednú uveitídu, entezitídu päty a psoriázu,</li>
  <li>ako najsilnejšiu položku zaraďujú magnetickú rezonanciu sakroiliakálnych kĺbov <strong>hodnotenú globálne, teda súčasne pre aktívne aj štrukturálne lézie</strong>.</li>
</ul>

<p>Vo validačnom súbore dosiahli senzitivitu 79,5 % a špecificitu 90,4 %. Zásadná zmena je koncepčná: <strong>samotný edém kostnej drene už nestačí na to, aby sa magnetická rezonancia považovala za nález svedčiaci pre axSpA</strong>. Vyžaduje sa obraz zlučiteľný so spondyloartritídou pri spoločnom posúdení zápalových aj štrukturálnych zmien.</p>

<p>Aj revidované kritériá však ostávajú klasifikačné. Sú nástrojom na zaraďovanie pacientov do štúdií, nie diagnostickým algoritmom pre ambulanciu. Mechanická bolesť chrbta u HLA-B27 pozitívneho človeka sa nestáva axiálnou spondyloartritídou iba preto, že pacient nazbiera dostatok bodov.</p>

<p>Pri diagnostike treba vždy zohľadniť predtestovú pravdepodobnosť a alternatívne vysvetlenia.</p>

<h2>HLA-B27: dôležitý, ale nie rozhodujúci nález</h2>

<p>HLA-B27 je najsilnejším známym genetickým faktorom asociovaným s axSpA. Jeho klinická hodnota však závisí od populácie a kontextu.</p>

<p>Pozitivita HLA-B27:</p>

<ul>
  <li>podporuje diagnózu pri kompatibilnom klinickom obraze,</li>
  <li>nie je dôkazom ochorenia,</li>
  <li>vyskytuje sa aj u zdravých ľudí,</li>
  <li>neumožňuje predpovedať priebeh jednotlivého pacienta.</li>
</ul>

<p>Negativita HLA-B27 axSpA nevylučuje. Ochorenie sa môže vyskytovať aj bez tohto antigénu, najmä v populáciách s nižšou prevalenciou HLA-B27.</p>

<p>Príbuzných prvého stupňa je vhodné informovať o zvýšenom riziku ochorenia a o príznakoch, pri ktorých sa majú ozvať. Genetické testovanie asymptomatických príbuzných sa však neodporúča, pretože pozitivita sama osebe neurčuje, či sa ochorenie rozvinie.</p>

<h2>Zápalové parametre</h2>

<p>C-reaktívny proteín a sedimentácia erytrocytov môžu byť zvýšené, ale u značnej časti pacientov zostávajú normálne aj pri klinicky aktívnom ochorení.</p>

<p>Normálny C-reaktívny proteín preto:</p>

<ul>
  <li>nevylučuje axSpA,</li>
  <li>nevylučuje aktívny zápal,</li>
  <li>nevylučuje potenciálnu odpoveď na liečbu.</li>
</ul>

<p>Naopak, zvýšený C-reaktívny proteín nie je špecifický. Pred jeho pripísaním spondyloartritíde treba zvážiť infekciu, obezitu, periodontálne ochorenie, zápalové ochorenie čreva a ďalšie príčiny.</p>

<p>Pravidelné sledovanie C-reaktívneho proteínu alebo sedimentácie je napriek tomu súčasťou monitorovania. Poskytuje objektívnu protiváhu k subjektívnym skóre.</p>

<h2>Konvenčná rádiografia</h2>

<p>Röntgenová snímka sakroiliakálnych kĺbov môže preukázať:</p>

<ul>
  <li>erózie,</li>
  <li>sklerózu,</li>
  <li>zúženie alebo rozšírenie kĺbovej štrbiny,</li>
  <li>čiastočnú alebo úplnú ankylózu.</li>
</ul>

<p>Jej citlivosť v skorom štádiu je nízka. Hodnotenie je zaťažené významnou variabilitou medzi pozorovateľmi, najmä pri miernych alebo hraničných zmenách.</p>

<p>Skleróza sama osebe nie je špecifická. Môže byť mechanická, degeneratívna alebo súvisieť s <em>osteitis condensans ilii</em>.</p>

<p>Ako iniciálne zobrazenie u dospelých sa odporúča jednoduchá predozadná snímka panvy, nie cielené šikmé projekcie sakroiliakálnych kĺbov ani snímka driekovej chrbtice. Pri nejednoznačnom náleze nasleduje magnetická rezonancia sakroiliakálnych kĺbov bez kontrastnej látky.</p>

<p>Opakovanie rádiografie v pevných intervaloch, napríklad každé dva roky, sa nemá robiť rutinne bez klinickej otázky.</p>

<h2>Magnetická rezonancia</h2>

<p>Magnetická rezonancia umožňuje zachytiť aktívny zápal aj niektoré štrukturálne lézie skôr než konvenčná rádiografia. Práve preto sa stala aj najčastejším zdrojom nadmernej diagnostiky.</p>

<h3>Aktívne zápalové zmeny</h3>

<p>Najčastejšie hodnoteným nálezom je edém kostnej drene, respektíve osteitída, na sekvenciách citlivých na tekutinu. Diagnostická výpovedná hodnota závisí od:</p>

<ul>
  <li>lokalizácie lézie,</li>
  <li>jej rozsahu a hĺbky,</li>
  <li>počtu postihnutých rezov,</li>
  <li>prítomnosti štrukturálnych zmien,</li>
  <li>klinického kontextu.</li>
</ul>

<p>Samotný drobný edém kostnej drene nie je dôkazom axSpA. Podobné zmeny sa môžu objaviť:</p>

<ul>
  <li>po intenzívnej fyzickej záťaži,</li>
  <li>u bežcov a ďalších športovcov,</li>
  <li>u vojenských regrútov,</li>
  <li>v tehotenstve a po pôrode,</li>
  <li>pri mechanickom preťažení,</li>
  <li>pri degeneratívnych zmenách,</li>
  <li>pri <em>osteitis condensans ilii</em>,</li>
  <li>po úraze,</li>
  <li>zriedkavejšie pri infekcii alebo nádore.</li>
</ul>

<h3>Štrukturálne zmeny</h3>

<p>Diagnostiku môžu podporiť:</p>

<ul>
  <li>erózie,</li>
  <li>tuková metaplázia,</li>
  <li>subchondrálna skleróza,</li>
  <li>ankylóza.</li>
</ul>

<p>Ani tieto nálezy nie sú úplne špecifické. Zmysel má až ich spoločné posúdenie so zápalovými zmenami, presne v duchu revidovaných kritérií z roku 2025.</p>

<h3>Ako vyšetrenie objednať a čítať</h3>

<p>Kvalita zobrazenia a jeho interpretácie je pri axSpA rovnako dôležitá ako indikácia. Odporúča sa:</p>

<ul>
  <li>vyšetrenie <strong>sakroiliakálnych kĺbov</strong>, nie iba driekovej chrbtice,</li>
  <li>špecifický protokol pre axSpA, nie nešpecifický protokol chrbtice,</li>
  <li>vyšetrenie <strong>bez gadolínia</strong>, ktoré k diagnostickej výťažnosti spravidla nič nepridáva,</li>
  <li>štandardizovaná štruktúra nálezu,</li>
  <li>hodnotenie rádiológom alebo reumatológom, ktorý má skúsenosť so spondyloartritídami a s ich napodobňujúcimi stavmi.</li>
</ul>

<p>Táto požiadavka nie je formalita. Pri centrálnom prehodnocovaní nálezov v rámci telemedicínskych iniciatív bola interpretácia magnetickej rezonancie u významnej časti odoslaných prípadov nesprávna. Chybné čítanie vedie k obom nežiaducim koncom: k prehliadnutiu ochorenia aj k jeho nadmernej diagnostike.</p>

<p>Pozitrónová emisná tomografia ani scintigrafia skeletu nie sú pri podozrení na axSpA vhodnou alternatívou. Nízkodávková počítačová tomografia sakroiliakálnych kĺbov je použiteľná najmä na hodnotenie štrukturálnych zmien.</p>

<h3>Opakovanie magnetickej rezonancie</h3>

<p>Rutinné opakovanie magnetickej rezonancie v pevne určených intervaloch sa neodporúča. Je vhodné najmä vtedy, keď výsledok môže zmeniť diagnostické alebo terapeutické rozhodnutie, typicky pri nejasnej aktivite ochorenia počas biologickej alebo cielenej syntetickej liečby.</p>

<p>Naopak, u pacienta s klinicky neaktívnym ochorením sa magnetická rezonancia nemá robiť len na potvrdenie remisie.</p>

<p>Negatívna magnetická rezonancia v jednom časovom bode axSpA definitívne nevylučuje, ale jej nekritické opakovanie pri nízkej klinickej pravdepodobnosti zvyšuje riziko náhodných a falošne pozitívnych nálezov.</p>

<h2>Diferenciálna diagnostika</h2>

<p>Pred stanovením diagnózy treba podľa klinického kontextu zvážiť:</p>

<ul>
  <li>mechanickú nešpecifickú bolesť chrbta,</li>
  <li>degeneratívne ochorenie chrbtice a sakroiliakálnych kĺbov,</li>
  <li>herniu medzistavcovej platničky,</li>
  <li><em>osteitis condensans ilii</em>,</li>
  <li>fibromyalgiu,</li>
  <li>hypermobilitu,</li>
  <li>stresovú zlomeninu,</li>
  <li>septickú sakroiliitídu,</li>
  <li>osteomyelitídu,</li>
  <li>nádorové ochorenie,</li>
  <li>osteoporotickú kompresívnu zlomeninu,</li>
  <li>metabolické ochorenia kostí,</li>
  <li>difúznu idiopatickú skeletálnu hyperostózu.</li>
</ul>

<p>Varovnými prejavmi sú najmä horúčka, septický stav, progresívny neurologický deficit, syndróm kaudy equiny, významný úraz, nevysvetlený úbytok hmotnosti, anamnéza malignity a nová závažná bolesť u imunokompromitovaného pacienta.</p>

<h2>Hodnotenie aktivity ochorenia</h2>

<p>Aktivitu nemožno spoľahlivo posudzovať iba podľa intenzity bolesti. Bolestivosť môže byť ovplyvnená štrukturálnym poškodením, poruchou spánku, depresiou, fibromyalgiou, obezitou, mechanickým preťažením a ďalšími komorbiditami.</p>

<p>Používajú sa najmä:</p>

<ul>
  <li><strong>BASDAI</strong>, index založený na pacientom hodnotených symptómoch,</li>
  <li><strong>ASDAS</strong>, ktorý kombinuje klinické položky s C-reaktívnym proteínom alebo sedimentáciou.</li>
</ul>

<p>ASDAS poskytuje lepšie ukotvenie v objektívnom zápale než samotný BASDAI, hoci ani on nie je bez obmedzení. Odporúča sa používať niektoré z ochorení špecifických skóre pravidelne, nie iba všeobecné meradlá bolesti či kvality života.</p>

<p>Formálna stratégia liečby k cieľu, teda systematická eskalácia podľa vopred stanovenej hraničnej hodnoty skóre, sa pri axSpA zatiaľ neopiera o presvedčivé dôkazy o prevahe nad postupom vedeným symptómami. Ak sa cieľ stanovuje, primeraným cieľom je nízka aktivita ochorenia. Pri rozhodovaní o eskalácii cielenej liečby sa má vysoká aktivita potvrdiť klinickým posúdením a podľa možnosti objektívnymi znakmi zápalu.</p>

<h2>Ciele liečby</h2>

<p>Liečba má smerovať k:</p>

<ul>
  <li>potlačeniu zápalovej aktivity,</li>
  <li>zmierneniu bolesti a stuhnutosti,</li>
  <li>zachovaniu mobility a fyzickej funkcie,</li>
  <li>udržaniu pracovnej a sociálnej participácie,</li>
  <li>prevencii alebo spomaleniu štrukturálneho poškodenia,</li>
  <li>kontrole periférnych a mimokĺbových prejavov,</li>
  <li>minimalizácii toxicity liečby.</li>
</ul>

<p>Úplné odstránenie všetkých symptómov nemusí byť dosiahnuteľné. Pretrvávajúca bolesť nemusí automaticky znamenať pokračujúci zápal, preto pred každou eskaláciou treba zhodnotiť príčinu ťažkostí.</p>

<h2>Edukácia, pohyb a fyzioterapia</h2>

<p>Fyzioterapia je pri aktívnej axSpA jedným z mála silne odporúčaných opatrení. Program má zahŕňať:</p>

<ul>
  <li>mobilizačné cvičenia chrbtice,</li>
  <li>udržiavanie extenzie a správneho držania tela,</li>
  <li>posilňovanie svalov trupu a končatín,</li>
  <li>aeróbnu aktivitu,</li>
  <li>dychové cvičenia,</li>
  <li>tréning rovnováhy a koordinácie podľa potreby.</li>
</ul>

<p>Aktívne, supervidované cvičenie sa uprednostňuje pred pasívnymi postupmi, ako sú masáž, ultrazvuk alebo aplikácia tepla. Cvičenie vo vode býva pre kĺby šetrnejšie než záťaž vo vzpriamenej polohe. Prínos môžu mať aj strečing, joga, tai-či a rekreačný pohyb; opakované cykly fyzioterapie sú vhodnejšie než jednorazová inštruktáž. Dôležitá je dlhodobá adherencia a prispôsobenie programu aktuálnemu stavu. Samostatné cvičenie doma je stále lepšie než žiadne, ale supervidovaný program býva účinnejší než všeobecné odporúčanie „viac sa hýbať“.</p>

<p><strong>Manipulačná liečba chrbtice sa pri axSpA neodporúča.</strong> Ankylotická chrbtica je biomechanicky krehká a môže sa zlomiť aj pri relatívne malom násilí; riziko je vyššie pri pokročilej ankylóze, osteoporóze a výraznej kyfóze. Neodporúča sa ani trakcia a rádiofrekvenčná ablácia.</p>

<p>Súčasťou edukácie má byť aj poradenstvo o ťažkej fyzickej práci, o rizikách kontaktných športov, o úpravách pri šoférovaní a o dosiahnutí či udržaní primeranej telesnej hmotnosti.</p>

<p>Fajčenie je spojené s horšou aktivitou, funkciou a rádiografickou progresiou. Ukončenie fajčenia je preto súčasťou liečebného plánu.</p>

<p>Naopak, terapie zamerané na úpravu mikrobiómu ani alternatívna medicína, napríklad naturopatické, homeopatické či ajurvédske postupy, sa neodporúčajú. Akupunktúru a masáž možno pripustiť ako doplnok, nie ako náhradu účinnej liečby.</p>

<h2>Nesteroidové protizápalové lieky</h2>

<p>Nesteroidové protizápalové lieky, NSAID, zostávajú prvou farmakologickou možnosťou pri bolesti a stuhnutosti u väčšiny pacientov. Niektorí na ne reagujú výrazne, u iných je účinok nedostatočný alebo ich nemožno bezpečne podávať.</p>

<p>Praktické zásady:</p>

<ul>
  <li>pri <strong>aktívnom</strong> ochorení sa uprednostňuje pravidelné, kontinuálne podávanie pred podávaním podľa potreby,</li>
  <li>pri <strong>neaktívnom</strong> ochorení je vhodnejšie podávanie podľa potreby,</li>
  <li>pri nedostatočnom účinku sa má vyskúšať iný NSAID, nie kombinácia dvoch NSAID naraz,</li>
  <li>ak je pacient dobre kontrolovaný na biologickej alebo cielenej syntetickej liečbe, súbežné dlhodobé podávanie NSAID spravidla nie je potrebné.</li>
</ul>

<p>Údaje o štrukturálne modifikujúcom účinku sú nekonzistentné. Desaťročné pozorovanie nemeckej inceptívnej kohorty GESPIC naznačilo mierne spomalenie rádiografickej progresie pri vyššom kumulatívnom príjme NSAID, najvýraznejšie pri rádiografickej forme ochorenia. Ide však o observačné dáta s malým efektom. Kontinuálna liečba sa preto nemá indikovať s tvrdením, že spoľahlivo zabraňuje ankylóze; rozhodujúca ostáva potreba kontroly symptómov a bezpečnostný profil.</p>

<h3>Renálne riziko NSAID</h3>

<p>NSAID znižujú syntézu renálnych prostaglandínov. Následkom môže byť:</p>

<ul>
  <li>oslabenie prostaglandínmi sprostredkovanej vazodilatácie aferentnej arterioly,</li>
  <li>zníženie glomerulárnej filtrácie,</li>
  <li>retencia sodíka a vody,</li>
  <li>zvýšenie krvného tlaku,</li>
  <li>hyperkaliémia,</li>
  <li>akútne poškodenie obličiek,</li>
  <li>dekompenzácia srdcového zlyhávania.</li>
</ul>

<p>Riziko je vyššie pri:</p>

<ul>
  <li>chronickej chorobe obličiek,</li>
  <li>vyššom veku,</li>
  <li>dehydratácii,</li>
  <li>srdcovom zlyhávaní,</li>
  <li>cirhóze,</li>
  <li>súčasnom podávaní diuretika,</li>
  <li>blokáde systému renín-angiotenzín,</li>
  <li>kombinácii viacerých nefrotoxických liekov.</li>
</ul>

<p>Kombinácia NSAID, inhibítora ACE alebo sartanu a diuretika výrazne zvyšuje riziko hemodynamického akútneho poškodenia obličiek. NSAID vrátane voľnopredajných prípravkov sa preto majú aktívne zisťovať v liekovej anamnéze.</p>

<p>Pri rizikovom pacientovi treba po začatí alebo zvýšení dávky skontrolovať krvný tlak, sérový kreatinín, eGFR a draslík. Jednotný interval neplatí pre každého, pri vysokom riziku je však vhodná kontrola v priebehu niekoľkých dní až týždňov.</p>

<p>Selektívny inhibítor COX-2 môže mať za určitých okolností priaznivejší gastrointestinálny profil, nie je však bez renálneho a kardiovaskulárneho rizika.</p>

<p>U pacienta so súčasným zápalovým ochorením čreva je výber konkrétneho NSAID dôležitý a dlhodobé kontinuálne podávanie sa pri inaktívnom črevnom ochorení skôr neodporúča.</p>

<h2>Analgetiká, glukokortikoidy a nociplastická bolesť</h2>

<p>Paracetamol alebo vybrané ďalšie analgetiká možno zvážiť pri reziduálnej bolesti, ak sú NSAID kontraindikované alebo nedostatočné. Nemajú však protizápalový ani chorobu modifikujúci účinok.</p>

<p><strong>Opioidy sa pri axSpA neodporúčajú</strong>, a to ani ako alternatíva účinnej cielenej liečby. Neodporúčajú sa ani kanabinoidy.</p>

<p>Dlhodobá systémová liečba glukokortikoidmi sa pri čisto axiálnom ochorení neodporúča. Lokálna aplikácia má svoje miesto: intraartikulárna injekcia pri aktívnej sakroiliitíde alebo pri periférnej artritíde a perienteálna injekcia v okolí úponu pri aktívnej entezitíde. Aplikácia priamo do Achillovej šľachy je však riziková pre možnosť ruptúry.</p>

<p>U časti pacientov dominuje nociplastická bolesť, ktorá nereaguje na potláčanie zápalu. V takom prípade prichádzajú do úvahy gabapentinoidy, antidepresíva zo skupiny SSRI alebo SNRI, myorelaxanciá a kognitívno-behaviorálna terapia. Rozpoznanie tohto fenotypu bráni zbytočnému stupňovaniu imunosupresie.</p>

<h2>Konvenčné syntetické chorobu modifikujúce lieky</h2>

<p>Metotrexát, sulfasalazín, leflunomid, hydroxychlorochín, azatioprín ani apremilast nemajú presvedčivo dokázanú účinnosť na čisto axiálne prejavy a pri axiálnom ochorení sa neodporúčajú. Neodporúča sa ani ich pridávanie k biologickej alebo cielenej syntetickej liečbe pri axiálnom ochorení.</p>

<p>Miesto si zachovávajú pri významnej periférnej artritíde alebo pri niektorých mimokĺbových prejavoch. Sulfasalazín sa nemá používať ako povinný medzistupeň pred biologickou liečbou u pacienta s dominantným axiálnym ochorením.</p>

<p>Táto hranica je dôležitá aj pri posudzovaní „zlyhania štandardnej liečby“. Nedostatočný účinok metotrexátu na axiálnu bolesť nie je prekvapivým dôkazom rezistencie, pretože tento liek nie je na axiálnu zložku spoľahlivo účinný.</p>

<h2>Kedy zvažovať biologickú alebo cielenú syntetickú liečbu</h2>

<p>Cielená liečba sa zvažuje pri pretrvávajúcej vysokej aktivite napriek primeranej nefarmakologickej liečbe a adekvátnej skúške NSAID, alebo ak sú NSAID kontraindikované.</p>

<p>U pacientov s vysokým rizikom nepriaznivého vývoja, typicky s prítomnými syndezmofytmi a vysokým C-reaktívnym proteínom, možno zvážiť biologickú alebo cielenú syntetickú liečbu už ako iniciálnu farmakoterapiu, teda bez predchádzajúcej skúšky NSAID.</p>

<p>Pred začatím treba:</p>

<ol>
  <li>znovu potvrdiť diagnózu,</li>
  <li>zhodnotiť aktivitu ochorenia validovaným nástrojom,</li>
  <li>posúdiť objektívne známky zápalu,</li>
  <li>vylúčiť mechanickú bolesť, nociplastickú bolesť a fibromyalgiu ako dominantnú príčinu symptómov,</li>
  <li>vyšetriť infekčné riziko,</li>
  <li>skontrolovať očkovanie,</li>
  <li>zohľadniť mimokĺbové prejavy a komorbidity.</li>
</ol>

<p>Pri nerádiografickej axSpA sa pri indikácii a úhrade liečby často vyžaduje objektívny dôkaz zápalu, napríklad zvýšený C-reaktívny proteín alebo aktívna sakroiliitída na magnetickej rezonancii. Presné podmienky sa líšia podľa registrácie lieku a národných úhradových pravidiel.</p>

<h2>Poradie liekových tried</h2>

<p>Odporúčania ACR, SAA a SPARTAN z roku 2026 formulujú poradie zreteľnejšie než predchádzajúca verzia z roku 2019:</p>

<div class="table-responsive" role="region" aria-label="Poradie liekových tried pri axiálnej spondyloartritíde podľa odporúčaní z roku 2026" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Trieda</th>
      <th scope="col">Postavenie</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>NSAID</td><td>prvá farmakologická voľba</td><td>silné odporúčanie; pri vysokom riziku progresie možno začať rovno cielenou liečbou</td></tr>
    <tr><td>Inhibítory TNF</td><td>prvá biologická voľba</td><td>silné odporúčanie; rovnocenné s inhibítormi IL-17</td></tr>
    <tr><td>Inhibítory IL-17</td><td>prvá biologická voľba</td><td>silné odporúčanie; vrátane duálnej inhibície IL-17A a IL-17F</td></tr>
    <tr><td>Inhibítory JAK</td><td>účinné, ale spravidla až po predchádzajúcich triedach</td><td>silné odporúčanie pre účinnosť, zároveň podmienené uprednostnenie TNF alebo IL-17 pred JAK</td></tr>
    <tr><td>Inhibítory IL-23</td><td>neodporúčajú sa</td><td>silné odporúčanie proti použitiu pri axiálnom ochorení</td></tr>
    <tr><td>Konvenčné syntetické DMARD</td><td>nie pri axiálnom ochorení</td><td>miesto majú len pri periférnych alebo mimokĺbových prejavoch</td></tr>
  </tbody>
</table>
</div>

<p>Vnútri jednotlivých tried sa nepreferuje konkrétna molekula plošne. Výber sa riadi mimokĺbovými prejavmi, komorbiditami, spôsobom podania a preferenciou pacienta.</p>

<h3>Inhibítory TNF</h3>

<p>Inhibítory tumor nekrotizujúceho faktora zmierňujú symptómy, zlepšujú funkciu a znižujú zápalovú aktivitu. Dostupné sú monoklonálne protilátky aj receptorový fúzny proteín.</p>

<p>Výber konkrétneho prípravku ovplyvňujú mimokĺbové prejavy:</p>

<ul>
  <li>pri recidivujúcej prednej uveitíde sa spravidla uprednostňuje monoklonálna protilátka proti TNF,</li>
  <li>pri aktívnom zápalovom ochorení čreva sa používajú lieky s dokázanou účinnosťou pre príslušnú črevnú diagnózu,</li>
  <li>etanercept nie je účinnou liečbou zápalového ochorenia čreva a môže byť menej vhodný pri recidivujúcej uveitíde.</li>
</ul>

<p>Pred liečbou treba vyšetriť najmä latentnú tuberkulózu, hepatitídu B a podľa rizika hepatitídu C a HIV. Živé vakcíny sa počas významnej biologickej imunosupresie spravidla nepodávajú.</p>

<h3>Inhibítory interleukínu 17</h3>

<p>Inhibítory IL-17A, duálne inhibítory IL-17A a IL-17F aj inhibítor receptora IL-17 sú pri axiálnej spondyloartritíde účinné a môžu byť mimoriadne vhodné pri klinicky významnej psoriáze.</p>

<p>Pri aktívnom zápalovom ochorení čreva sa im spravidla treba vyhnúť alebo ich používať s mimoriadnou opatrnosťou, pretože nie sú liečbou Crohnovej choroby a môžu súvisieť s jej vznikom alebo exacerbáciou.</p>

<p>Pred liečbou sa hodnotí infekčné riziko. Častejšie sa môžu vyskytnúť mukokutánne kandidózy, pretože dráha IL-17 má význam v obrane proti kvasinkám.</p>

<h3>Inhibítory Janusových kináz</h3>

<p>Niektoré inhibítory JAK majú schválenú účinnosť pri rádiografickej aj nerádiografickej axSpA. Výhodou je perorálne podávanie, ale bezpečnostný profil vyžaduje dôsledný výber pacienta, a preto sa spravidla nepoužívajú ako prvá cielená liečba.</p>

<p>Treba posúdiť najmä:</p>

<ul>
  <li>vek,</li>
  <li>fajčenie,</li>
  <li>aterosklerotické kardiovaskulárne riziko,</li>
  <li>anamnézu venózneho tromboembolizmu,</li>
  <li>malignitu,</li>
  <li>recidivujúce infekcie,</li>
  <li>riziko herpes zoster,</li>
  <li>hematologické a hepatálne parametre,</li>
  <li>funkciu obličiek.</li>
</ul>

<p>Bezpečnostné varovania vychádzajú najmä z údajov pri reumatoidnej artritíde vo vysoko rizikovej populácii. Nemožno ich bez rozdielu preniesť na každého mladého pacienta s axSpA, ale ani ignorovať.</p>

<p>Dávkovanie niektorých inhibítorov JAK sa musí upraviť podľa funkcie obličiek alebo pečene. Rozhodujúci je aktuálny súhrn charakteristických vlastností konkrétneho lieku.</p>

<h3>Čo sa pri axiálnej spondyloartritíde nemá používať</h3>

<p>Na axiálne ochorenie sa neodporúčajú abatacept, rituximab, tocilizumab, sarilumab, belimumab ani anakinra. Bisfosfonáty nie sú liečbou axSpA, hoci majú miesto pri osteoporóze. Adrenokortikotropný hormón sa neodporúča. Rutinné riadenie liečby podľa hladín lieku alebo protiliekových protilátok sa tiež neodporúča.</p>

<h2>Výber lieku podľa mimokĺbových prejavov</h2>

<h3>Uveitída</h3>

<p>Akútna predná uveitída sa prejavuje bolestivým červeným okom, fotofóbiou a poruchou videnia. Vyžaduje urgentné oftalmologické vyšetrenie.</p>

<p>Anamnézu uveitídy treba cielene zisťovať u každého pacienta s axSpA. Preventívne oftalmologické vyšetrenie u asymptomatického pacienta sa naopak rutinne neodporúča.</p>

<p>U pacienta s <strong>recidivujúcou</strong> uveitídou má zmysel mať kortikoidové očné kvapky predpísané vopred, aby ich mohol pri nástupe očných príznakov okamžite použiť doma. Nejde o samoliečbu: ide o vopred dohodnutý postup, ktorý má okamžite nasledovať kontakt s oftalmológom. Používanie kortikoidových kvapiek na vlastnú päsť u nevyšetreného pacienta je nevhodné, pretože môže zamaskovať infekčnú keratitídu alebo zhoršiť glaukóm.</p>

<p>Pri opakovaných epizódach sa pri systémovej liečbe spravidla uprednostňuje monoklonálna protilátka proti TNF. Ak sa uveitída objaví u pacienta už liečeného monoklonálnou protilátkou proti TNF, spravidla je vhodnejšie v nej pokračovať a doplniť lokálnu liečbu než hneď meniť triedu.</p>

<h3>Zápalové ochorenie čreva</h3>

<p>Chronická hnačka, krv v stolici, nevysvetlený úbytok hmotnosti, bolesti brucha alebo anémia si vyžadujú gastroenterologické vyšetrenie. Fekálny kalprotektín sa má vyšetrovať pri klinickom podozrení, nie plošne u bezpríznakových pacientov. Starostlivosť o pacienta s potvrdeným zápalovým ochorením čreva má byť spoločná s gastroenterológom.</p>

<p>Nie každý pacient s axSpA a črevnými symptómami má zápalové ochorenie čreva. Diferenciálne treba zvážiť infekciu, celiakiu, syndróm dráždivého čreva, mikroskopickú kolitídu a liekovú toxicitu.</p>

<h3>Psoriáza</h3>

<p>Pri rozsiahlej kožnej psoriáze alebo psoriatickom postihnutí nechtov môže výber ovplyvniť vyššia účinnosť inhibítorov IL-17 alebo iných tried aj na kožné prejavy; starostlivosť je vhodné zdieľať s dermatológom. Rozhodnutie sa má prispôsobiť súčasnému črevnému, očnému a infekčnému riziku.</p>

<p>Ak sa počas liečby inhibítorom TNF objaví mierna psoriáza vyvolaná liekom, spravidla je vhodnejšie v liečbe pokračovať a doplniť lokálnu liečbu alebo fototerapiu než liek okamžite meniť.</p>

<h2>Zlyhanie cielenej liečby</h2>

<p>Nedostatočná odpoveď na prvý biologický alebo cielený liek neznamená, že všetky ďalšie lieky budú neúčinné. Pri zlyhaní prvej molekuly sa spravidla uprednostňuje prechod na liek s <strong>iným mechanizmom účinku</strong>; zmena v rámci tej istej triedy je alternatívou, ktorá je vhodnejšia než pridanie konvenčného syntetického lieku.</p>

<p>Pred zmenou treba preveriť:</p>

<ul>
  <li>správnosť diagnózy,</li>
  <li>adherenciu,</li>
  <li>čas potrebný na nástup účinku,</li>
  <li>objektívnu zápalovú aktivitu,</li>
  <li>mechanické poškodenie,</li>
  <li>fibromyalgiu a nociplastickú bolesť,</li>
  <li>depresiu, poruchy spánku a obezitu,</li>
  <li>infekciu alebo inú komorbiditu.</li>
</ul>

<p>Ak sa vysoké subjektívne skóre nezhoduje s normálnymi objektívnymi nálezmi, automatické zvyšovanie imunosupresie môže priniesť viac rizika než úžitku. Pri zlyhaní dvoch a viacerých tried sa má dôvod neodpovede systematicky prehodnotiť ešte pred ďalšou zmenou lieku. Vo vybraných prípadoch prichádza do úvahy eskalácia dávky nad registračné maximum alebo duálna cielená liečba, vždy však ako individuálne rozhodnutie s jasným posúdením rizika.</p>

<p>Súčasťou prehodnotenia „refraktérneho“ ochorenia má byť aj skríning depresie a jej liečba.</p>

<h2>Remisia a znižovanie dávky</h2>

<p>Pri dlhodobo udržanej remisii možno u vybraných pacientov zvážiť opatrné predĺženie dávkovacieho intervalu alebo redukciu dávky biologickej liečby. Ak pacient užíva aj konvenčný syntetický liek, spravidla sa vysadzuje ako prvý.</p>

<p><strong>Náhle úplné vysadenie bez postupného znižovania sa neodporúča</strong>, pretože vedie častejšie k relapsu. Neexistuje jeden univerzálny postup. Rozhodnutie má byť spoločné, s vopred stanoveným plánom sledovania a návratu k účinnej dávke pri relapse. Ak sa ochorenie po vysadení reaktivuje, spravidla sa vracia ten istý liek, ktorý predtým účinkoval.</p>

<h2>Chirurgická liečba a perioperačná bezpečnosť</h2>

<p>Totálna endoprotéza bedrového kĺbu môže významne zlepšiť funkciu pri pokročilom poškodení bedra. Na prevenciu heterotopickej osifikácie po výkone sa uprednostňuje celekoxib pred lokálnym ožiarením.</p>

<p>Korekčná operácia chrbtice, teda elektívna spinálna osteotómia, prichádza do úvahy pri závažnej fixovanej kyfóze a výraznom funkčnom obmedzení. Ide o náročný výkon patriaci do skúseného špecializovaného centra.</p>

<p>Pri postihnutí krčnej chrbtice treba pred každým výkonom v celkovej anestézii vopred upozorniť anestéziológa na sťaženú intubáciu a tento problém prebrať s pacientom v rámci informovaného súhlasu.</p>

<p>Pacient s kyfózou alebo ankylózou by mal nosiť identifikačný náramok, ktorý zdravotníkov v teréne upozorní na krehkú, zrastenú chrbticu a na riziko zlomeniny.</p>

<p>Pri podozrení na zlomeninu ankylotickej chrbtice je potrebné urgentné zobrazovanie. Bežná röntgenová snímka môže zlomeninu prehliadnuť, preto býva potrebná počítačová tomografia a podľa neurologického obrazu magnetická rezonancia.</p>

<h2>Kostné zdravie</h2>

<p>Osteopénia, osteoporóza a vertebrálne zlomeniny sú pri axSpA časté aj u mladších pacientov. Odporúča sa:</p>

<ul>
  <li>denzitometrické vyšetrenie, spravidla nie každoročne, ale v dvoj- až päťročných intervaloch,</li>
  <li>pri syndezmofytoch alebo spinálnej fúzii merať okrem bedra aj chrbticu, pretože samotné meranie bedra môže situáciu podhodnotiť,</li>
  <li>systematické hodnotenie rizika pádu a poradenstvo,</li>
  <li>pri osteoporóze doplniť antiresorpčnú alebo anabolickú liečbu k prebiehajúcej cielenej liečbe.</li>
</ul>

<p>Rutinné meranie markerov kostného obratu sa neodporúča.</p>

<h2>Kardiovaskulárne a ďalšie komorbidity</h2>

<p>Axiálna spondyloartritída sa spája so zvýšeným výskytom:</p>

<ul>
  <li>arteriálnej hypertenzie,</li>
  <li>aterosklerotických kardiovaskulárnych ochorení,</li>
  <li>osteopénie a osteoporózy,</li>
  <li>vertebrálnych zlomenín,</li>
  <li>depresie a úzkosti,</li>
  <li>porúch spánku.</li>
</ul>

<p>Tradičné kardiovaskulárne rizikové faktory treba aktívne vyhľadávať a liečiť. Plošný skríning prevodových porúch elektrokardiogramom ani chlopňových chýb echokardiografiou sa u bezpríznakových pacientov naopak neodporúča. Odporúča sa skríning depresie a jej liečba.</p>

<p>Dlhodobé používanie NSAID môže zhoršovať krvný tlak, retenciu tekutín a funkciu obličiek.</p>

<h3>Možné renálne prejavy</h3>

<p>Renálne komplikácie nie sú dominantným prejavom axSpA, ale môžu zahŕňať:</p>

<ul>
  <li>sekundárnu AA amyloidózu pri dlhodobo nekontrolovanom zápale,</li>
  <li>IgA nefropatiu,</li>
  <li>liekové poškodenie obličiek, najmä v súvislosti s NSAID,</li>
  <li>zriedkavé glomerulárne alebo tubulointersticiálne poškodenie súvisiace s liečbou alebo pridruženým ochorením.</li>
</ul>

<p>Asociácia medzi axSpA a IgA nefropatiou neznamená, že každý nález mikroskopickej hematúrie je prejavom základného reumatického ochorenia. Vyžaduje štandardnú nefrologickú diferenciálnu diagnostiku.</p>

<h2>Praktické nefrologické monitorovanie</h2>

<p>Pred dlhodobejším alebo opakovaným podávaním NSAID je vhodné poznať:</p>

<ul>
  <li>sérový kreatinín a eGFR,</li>
  <li>sérový draslík,</li>
  <li>krvný tlak,</li>
  <li>prítomnosť albuminúrie alebo proteinúrie,</li>
  <li>objemový stav,</li>
  <li>súbežnú liečbu blokátorom systému renín-angiotenzín a diuretikom.</li>
</ul>

<p>Nefrologické vyšetrenie treba zvážiť najmä pri:</p>

<ul>
  <li>pretrvávajúcej hematúrii,</li>
  <li>významnej albuminúrii alebo proteinúrii,</li>
  <li>nevysvetlenom poklese eGFR,</li>
  <li>nefrotickom syndróme,</li>
  <li>opakovanom akútnom poškodení obličiek,</li>
  <li>podozrení na systémovú amyloidózu.</li>
</ul>

<p>Pri akútnom ochorení s dehydratáciou, vracaním alebo hnačkou sa NSAID majú spravidla dočasne prerušiť. Pacient musí vedieť, že voľnopredajný ibuprofén, diklofenak alebo naproxén sa započítavajú do jeho celkovej expozície NSAID.</p>

<p>U pacienta s chronickou chorobou obličiek, u ktorého nie je bezpečné dlhodobé podávanie NSAID, je argument pre skoršie zvažovanie cielenej liečby silnejší než u pacienta s normálnou renálnou funkciou.</p>

<h2>Gravidita a reprodukčné otázky</h2>

<p>Ochorenie postihuje často ľudí v reprodukčnom veku. Plánovanie gravidity je potrebné prediskutovať vopred, pretože bezpečnosť jednotlivých liekov sa výrazne líši.</p>

<p>Niektoré inhibítory TNF možno podľa konkrétnej molekuly a klinickej situácie používať počas gravidity. Inhibítory JAK sú počas gravidity kontraindikované alebo sa neodporúčajú. NSAID majú časovo závislé obmedzenia a v pokročilej gravidite sa nepodávajú pre riziko fetálnej renálnej dysfunkcie, oligohydramniónu a predčasného uzáveru <em>ductus arteriosus</em>.</p>

<p>Rozhodovanie sa musí riadiť aktuálnou registračnou dokumentáciou a spoločným posúdením reumatológa a gynekológa.</p>

<h2>Deti a dospievajúci</h2>

<p>Popri aktualizácii odporúčaní pre dospelých vznikla v roku 2026 aj samostatná smernica pre juvenilnú axiálnu spondyloartritídu. Najvýraznejším rozdielom je zobrazovanie: u detí a dospievajúcich je preferovaným prvým vyšetrením magnetická rezonancia sakroiliakálnych kĺbov bez kontrastnej látky, nie röntgenová snímka. Opakované snímkovanie chrbtice a panvy v pevných intervaloch sa v detskom veku neodporúča dôraznejšie než u dospelých.</p>

<h2>Praktický klinický postup</h2>

<p>Pri podozrení na axiálnu spondyloartritídu je vhodné:</p>

<ol>
  <li>overiť vek pri začiatku a trvanie bolesti chrbta,</li>
  <li>cielene zisťovať znaky zápalovej bolesti,</li>
  <li>pátrať po uveitíde, psoriáze, črevnom zápale, entezitíde a rodinnej anamnéze,</li>
  <li>vykonať fyzikálne vyšetrenie chrbtice, sakroiliakálnych kĺbov, entéz a periférnych kĺbov,</li>
  <li>vyšetriť C-reaktívny proteín a podľa kontextu HLA-B27,</li>
  <li>začať predozadnou snímkou panvy a pri nejednoznačnom náleze doplniť magnetickú rezonanciu sakroiliakálnych kĺbov bez kontrastu,</li>
  <li>interpretovať magnetickú rezonanciu v klinickom kontexte a spolu so štrukturálnymi zmenami,</li>
  <li>vylúčiť infekčné, mechanické, metabolické a nádorové príčiny,</li>
  <li>začať edukáciu, fyzioterapiu a bezpečnú symptomatickú liečbu,</li>
  <li>pri pretrvávajúcej vysokej aktivite zvážiť cielenú liečbu podľa fenotypu pacienta a jeho rizík.</li>
</ol>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly pri axiálnej spondyloartritíde a ich odborné spresnenie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Nerádiografická a rádiografická axSpA sú súčasťou jedného spektra</td><td>Podporené</td><td>Nie každý pacient s nerádiografickou formou však progreduje do rádiografického štádia.</td></tr>
    <tr><td>Klasifikačné kritériá možno používať ako diagnostický test</td><td>Nesprávne</td><td>Boli vytvorené pre výskum; aj revízia z roku 2025 ostáva klasifikačná.</td></tr>
    <tr><td>HLA-B27 potvrdzuje axSpA</td><td>Nesprávne</td><td>Pozitivita iba mení pravdepodobnosť diagnózy; vyskytuje sa aj u zdravých osôb.</td></tr>
    <tr><td>Negatívny HLA-B27 vylučuje axSpA</td><td>Nesprávne</td><td>Ochorenie sa vyskytuje aj u HLA-B27 negatívnych pacientov.</td></tr>
    <tr><td>Normálny C-reaktívny proteín vylučuje aktívne ochorenie</td><td>Nesprávne</td><td>Zápalové parametre môžu zostať normálne aj pri aktívnom zápale.</td></tr>
    <tr><td>Edém kostnej drene na MRI stačí na diagnózu</td><td>Nesprávne</td><td>Revidované kritériá z roku 2025 vyžadujú globálne posúdenie aktívnych aj štrukturálnych lézií.</td></tr>
    <tr><td>Nerádiografická axSpA je vždy miernejšia</td><td>Nesprávne</td><td>Symptomatická a funkčná záťaž môže byť porovnateľná s rádiografickou formou.</td></tr>
    <tr><td>NSAID spoľahlivo zabraňujú ankylóze</td><td>Nepotvrdené</td><td>Hlavný dokázaný prínos je symptomatický; údaje o štrukturálnej progresii sú slabé a observačné.</td></tr>
    <tr><td>Metotrexát je účinný na čisto axiálne prejavy</td><td>Nepodporené</td><td>Konvenčné syntetické lieky sa pri čisto axiálnom ochorení neodporúčajú.</td></tr>
    <tr><td>Inhibítory IL-17 sú vhodné pri aktívnej Crohnovej chorobe</td><td>Spravidla nesprávne</td><td>Nie sú liečbou aktívneho črevného zápalu a môžu súvisieť s jeho exacerbáciou.</td></tr>
    <tr><td>Inhibítory IL-23 fungujú pri axSpA podobne ako pri psoriáze</td><td>Nesprávne</td><td>Pri axiálnom ochorení sa dôrazne neodporúčajú.</td></tr>
    <tr><td>Inhibítory JAK sú vhodné pre každého pre pohodlné perorálne podanie</td><td>Nesprávne</td><td>Vyžadujú hodnotenie infekčného, kardiovaskulárneho, tromboembolického a onkologického rizika.</td></tr>
    <tr><td>Manipulačná liečba chrbtice je pri axSpA bežnou možnosťou</td><td>Nesprávne</td><td>Neodporúča sa; ankylotická chrbtica sa môže zlomiť aj pri malom násilí.</td></tr>
    <tr><td>Biologickú liečbu možno po dosiahnutí remisie okamžite vysadiť</td><td>Nepodporené</td><td>Náhle vysadenie bez postupného znižovania sa neodporúča.</td></tr>
    <tr><td>NSAID sú pri CKD bezpečné, ak sú podávané iba na predpis</td><td>Nesprávne</td><td>Renálne riziko závisí od mechanizmu, dávky, objemového stavu a kombinácie liekov, nie od spôsobu výdaja.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Axiálna spondyloartritída je klinicky heterogénne ochorenie, ktorého diagnózu nemožno redukovať na pozitivitu HLA-B27, jednu položku klasifikačných kritérií ani drobný nález edému kostnej drene na magnetickej rezonancii. Revízia kritérií z roku 2025 túto hranicu posilnila: rozhoduje celkový obraz aktívnych aj štrukturálnych zmien v klinickom kontexte.</p>

<p>Rovnako nesprávne je považovať nerádiografickú formu za nevýznamnú alebo predpokladať, že každý pacient nevyhnutne progreduje do ankylózy. Liečba má vychádzať z aktivity ochorenia, objektívnych známok zápalu, funkčného postihnutia, mimokĺbových prejavov a individuálnych rizík.</p>

<p><strong>Pohyb a fyzioterapia zostávajú základom starostlivosti. NSAID sú účinnou symptomatickou liečbou, nie však bezpečným univerzálnym riešením pre každého pacienta. Pri nedostatočnej kontrole zápalu sú dostupné viaceré cielené liekové skupiny, ktorých výber sa musí prispôsobiť očným, črevným, kožným, infekčným, kardiovaskulárnym a renálnym súvislostiam.</strong></p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>American College of Rheumatology, Spondylitis Association of America, Spondyloarthritis Research and Treatment Network.</strong> <em>2026 Update of the ACR/SAA/SPARTAN Recommendations for the Treatment of Axial Spondyloarthritis in Adults and Children/Adolescents.</em> Zhrnutie odporúčaní zverejnené 24. júna 2026; plné rukopisy sú pripravované na publikovanie v Arthritis &amp; Rheumatology a Arthritis Care &amp; Research. <a href="https://rheumatology.org/axial-spondyloarthritis-guideline" target="_blank" rel="noopener noreferrer">Stránka odporúčaní ACR</a>.</li>
  <li><strong>Maksymowych WP, van der Heijde D, Landewé R, a spol.</strong> <em>The Assessment of SpondyloArthritis International Society (ASAS) and Spondyloarthritis Research and Treatment Network (SPARTAN) Revised Classification Criteria for Axial Spondyloarthritis: Development and Validation in the Classification of Axial SpA Inception Cohort (CLASSIC) Study.</em> Prezentované na ACR Convergence 2025 a EULAR 2026. <a href="https://acrabstracts.org/abstract/the-assessments-in-spondyloarthritis-international-society-asas-and-spondyloarthritis-research-and-treatment-network-spartan-revised-classification-criteria-for-axial-spondyloarthritis-developmen/" target="_blank" rel="noopener noreferrer">Abstrakt ACR</a>.</li>
  <li><strong>Ramiro S, Nikiphorou E, Sepriano A, a spol.</strong> <em>ASAS-EULAR recommendations for the management of axial spondyloarthritis: 2022 update.</em> Ann Rheum Dis. 2023;82(1):19–34. doi: 10.1136/ard-2022-223296. <a href="https://doi.org/10.1136/ard-2022-223296" target="_blank" rel="noopener noreferrer">Odporúčania ASAS-EULAR</a>.</li>
  <li><strong>Zhao SS, Harrison SR, Thompson B, a spol.</strong> <em>The 2025 British Society for Rheumatology guideline for the treatment of axial spondyloarthritis with biologic and targeted synthetic DMARDs.</em> Rheumatology (Oxford). 2025;64(6):3242–3254. doi: 10.1093/rheumatology/keaf089. <a href="https://doi.org/10.1093/rheumatology/keaf089" target="_blank" rel="noopener noreferrer">Odporúčania BSR</a>.</li>
  <li><strong>Ward MM, Deodhar A, Gensler LS, a spol.</strong> <em>2019 Update of the American College of Rheumatology/Spondylitis Association of America/Spondyloarthritis Research and Treatment Network Recommendations for the Treatment of Ankylosing Spondylitis and Nonradiographic Axial Spondyloarthritis.</em> Arthritis Care Res (Hoboken). 2019;71(10):1285–1299. doi: 10.1002/acr.24025. <a href="https://doi.org/10.1002/acr.24025" target="_blank" rel="noopener noreferrer">Predchádzajúca verzia odporúčaní ACR</a>.</li>
  <li><strong>Poddubnyy D, van Tubergen A, Landewé R, Sieper J, van der Heijde D.</strong> <em>Development of an ASAS-endorsed recommendation for the early referral of patients with a suspicion of axial spondyloarthritis.</em> Ann Rheum Dis. 2015;74(8):1483–1487. doi: 10.1136/annrheumdis-2014-207151. <a href="https://doi.org/10.1136/annrheumdis-2014-207151" target="_blank" rel="noopener noreferrer">Odporúčanie na včasné odoslanie</a>.</li>
  <li><strong>Diekhoff T, Poddubnyy D.</strong> <em>The imaging crisis in axial spondyloarthritis.</em> Lancet Rheumatol. 2025;7(9):e652–e656. doi: 10.1016/S2665-9913(25)00108-0. <a href="https://doi.org/10.1016/S2665-9913(25)00108-0" target="_blank" rel="noopener noreferrer">Analýza nadmernej diagnostiky pri zobrazovaní</a>.</li>
  <li><strong>Torgutalp M, Rios Rodriguez V, Proft F, a spol.</strong> <em>The Impact of Nonsteroidal Anti-Inflammatory Drugs on Radiographic Spinal Progression in Patients With Axial Spondyloarthritis: 10-Year Results From an Inception Cohort.</em> Arthritis Rheumatol. 2026;78(3):582–591. doi: 10.1002/art.43447. <a href="https://doi.org/10.1002/art.43447" target="_blank" rel="noopener noreferrer">Kohorta GESPIC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
  <li><strong>European Medicines Agency.</strong> Registračné a bezpečnostné informácie o biologických a cielených syntetických liekoch používaných pri axiálnej spondyloartritíde. <a href="https://www.ema.europa.eu/en/medicines" target="_blank" rel="noopener noreferrer">Databáza liekov EMA</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Podnetom na tému bol odborný program o axiálnej spondyloartritíde na platforme Streamed Up; verejne dostupná stránka však neobsahovala prepis ani konkrétne klinické tvrdenia, článok preto nie je jeho prekladom ani prepisom. Ide o nezávislú syntézu aktuálnych odporúčaní a odbornej literatúry.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Indikácie, kontraindikácie, úpravy dávok a úhradové podmienky biologických a cielených liekov treba pred klinickým použitím overiť podľa aktuálneho európskeho a slovenského súhrnu charakteristických vlastností lieku a pravidiel zdravotných poisťovní. Odporúčania ACR z roku 2026 vychádzajú z prostredia Spojených štátov; európska prax sa v niektorých bodoch, napríklad pri zámene za biologicky podobné lieky, líši.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_axialna-spondyloartritida-diagnostika-zobrazovanie-liecba_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
