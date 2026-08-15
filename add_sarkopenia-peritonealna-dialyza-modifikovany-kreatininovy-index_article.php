<?php
/**
 * Odborny clanok: sarkopenia pri peritonealnej dialyze a modifikovany kreatininovy index.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index_article.php"
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
    'title'        => 'Sarkopénia pri peritoneálnej dialýze: prečo modifikovaný kreatinínový index nestačí',
    'slug'         => 'sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Modifikovaný kreatinínový index obstojí ako jednorazový odhad svalovej hmoty pri peritoneálnej dialýze, jeho sériové zmeny však skutočný vývoj svalstva nesledujú. Prehľad praktického hodnotenia sarkopénie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Jednoduché výpočtové ukazovatele môžu upozorniť na úbytok svalovej hmoty, nemôžu však nahradiť hodnotenie svalovej sily, množstva svalstva, fyzickej výkonnosti, hydratácie a reziduálnej funkcie obličiek. Pri modifikovanom kreatinínovom indexe je rozhodujúce rozlíšiť dve odlišné otázky: ako dobre odhadne svalovú hmotu v jednom časovom bode a či dokáže zachytiť jej zmenu v čase. Odpoveď na tieto dve otázky nie je rovnaká.</em></p>

<h2>Čo presne znamená sarkopénia</h2>

<p>Sarkopénia je progresívna porucha kostrového svalstva charakterizovaná zníženou svalovou silou a úbytkom množstva alebo kvality svalov. Nie je synonymom nízkej telesnej hmotnosti, kachexie, podvýživy ani samotného úbytku svalovej hmoty. Tieto stavy sa často prekrývajú, ale nie sú totožné.</p>

<p>Podľa európskeho konsenzu EWGSOP2 je základným znakom pravdepodobnej sarkopénie <strong>nízka svalová sila</strong>. Diagnóza sa potvrdzuje preukázaním nízkeho množstva alebo zhoršenej kvality svalstva. Ak je súčasne znížená fyzická výkonnosť, ide o ťažkú sarkopéniu.</p>

<div class="table-responsive" role="region" aria-label="Stupne sarkopénie podľa európskeho konsenzu EWGSOP2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Stupeň</th>
      <th scope="col">Svalová sila</th>
      <th scope="col">Množstvo alebo kvalita svalstva</th>
      <th scope="col">Fyzická výkonnosť</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Pravdepodobná sarkopénia</td><td>znížená</td><td>nehodnotené alebo normálne</td><td>nehodnotená</td></tr>
    <tr><td>Potvrdená sarkopénia</td><td>znížená</td><td>znížené</td><td>zachovaná alebo nehodnotená</td></tr>
    <tr><td>Ťažká sarkopénia</td><td>znížená</td><td>znížené</td><td>znížená</td></tr>
  </tbody>
</table>
</div>

<p>Ázijská pracovná skupina pre sarkopéniu AWGS používa podobný koncept, jej prahové hodnoty sú však upravené pre ázijské populácie. Európske a ázijské hranice preto nemožno ľubovoľne zamieňať. Pri interpretácii treba používať kritériá validované pre príslušnú populáciu, vek, pohlavie a použitú metódu merania.</p>

<h2>Prečo je sarkopénia pri peritoneálnej dialýze dôležitá</h2>

<p>U pacientov liečených peritoneálnou dialýzou sa na jej vzniku môžu podieľať chronický zápal, metabolická acidóza, nedostatočný príjem bielkovín a energie, straty bielkovín do dialyzátu, inzulínová rezistencia, nízka pohybová aktivita, komorbidity, opakované hospitalizácie a vek.</p>

<p>Pacient môže mať normálny alebo zvýšený index telesnej hmotnosti a napriek tomu výrazne znížené množstvo svalstva. Tento stav sa označuje ako sarkopenická obezita. Pri peritoneálnej dialýze môže jeho rozpoznanie komplikovať retencia tekutín, glukózová záťaž z dialyzačných roztokov a prírastok tukového tkaniva.</p>

<p>Sarkopénia a nízka svalová sila sa v dialyzačných populáciách observačne spájajú s:</p>

<ul>
  <li>vyšším rizikom pádov a zlomenín,</li>
  <li>horšou mobilitou a sebestačnosťou,</li>
  <li>dlhšími a častejšími hospitalizáciami,</li>
  <li>vyšším infekčným rizikom,</li>
  <li>nižšou kvalitou života,</li>
  <li>zvýšenou mortalitou,</li>
  <li>horšou toleranciou akútneho ochorenia,</li>
  <li>vyššou pravdepodobnosťou krehkosti.</li>
</ul>

<p>Tieto asociácie však automaticky nedokazujú, že samotné zvýšenie svalovej hmoty zníži mortalitu. Sarkopénia je súčasne markerom biologického starnutia, komorbidít, zápalu, nedostatočnej výživy a závažnosti základného ochorenia.</p>

<h2>Čo je modifikovaný kreatinínový index</h2>

<p>Kreatinín vzniká najmä neenzýmovou premenou kreatínu a fosfokreatínu v kostrovom svalstve. Pri stabilnom stave preto jeho denná produkcia približne súvisí s množstvom svalovej hmoty.</p>

<p>Kreatinínový index sa pokúša odhadnúť produkciu kreatinínu, a tým nepriamo aj množstvo svalstva. Canaudova rovnica, vytvorená a validovaná pri hemodialýze, kombinuje:</p>

<ul>
  <li>vek,</li>
  <li>pohlavie,</li>
  <li>predialyzačnú koncentráciu kreatinínu,</li>
  <li>dialyzačnú dávku vyjadrenú jednopriestorovým Kt/V.</li>
</ul>

<p>Výhodou je, že potrebné údaje pochádzajú z bežného dialyzačného monitorovania. Pacienta netreba vystaviť ďalšiemu zobrazovaciemu vyšetreniu a výpočet možno opakovať. Pri peritoneálnej dialýze sa do rovnice dosádza celkové týždenné Kt/V namiesto jednopriestorového.</p>

<h2>Čo ukázali dve štúdie z toho istého pracoviska</h2>

<p>Práve prenos rovnice z hemodialýzy na peritoneálnu dialýzu overila skupina z Prince of Wales Hospital v Hongkongu v dvoch po sebe nasledujúcich prácach. Ich výsledky sú odlišné a práve tento rozdiel je klinicky najdôležitejší.</p>

<h3>Jednorazové meranie obstálo</h3>

<p>Prvá štúdia porovnala index vypočítaný počas peritoneálnej dialýzy s konvenčným indexom po prechode na hemodialýzu u 138 pacientov a výsledok validovala na 605 incidentných pacientoch na peritoneálnej dialýze.</p>

<p>Index vypočítaný počas peritoneálnej dialýzy významne koreloval so svalovou hmotou stanovenou kinetikou kreatinínu (r = 0,684) aj bioimpedančnou spektroskopiou (r = 0,641). Nekoreloval s výskytom dusíka bielkovín, s prevodnením ani s tukovým tkanivom, čo svedčí o primeranej špecificite pre svalové tkanivo. Kvartil indexu súvisel s rizikom úmrtia zo všetkých príčin počas 12 mesiacov, nie však s prechodom na chronickú hemodialýzu.</p>

<p>Záver bol priaznivý: ako <strong>jednorazový</strong> ukazovateľ svalovej hmoty a krátkodobý prognostický marker je index pri peritoneálnej dialýze použiteľný.</p>

<h3>Sériové sledovanie neobstálo</h3>

<p>Druhá štúdia položila inú otázku: dokáže opakované meranie zachytiť <strong>zmenu</strong> svalovej hmoty? Sledovala 351 nových dospelých pacientov na peritoneálnej dialýze, u ktorých sa index počítal na začiatku a potom každých šesť mesiacov počas dvoch rokov. Súčasne sa meralo množstvo svalového tkaniva bioimpedančnou spektroskopiou a beztuková, edému zbavená telesná hmota klasickou kinetikou kreatinínu. Pacienti boli sledovaní priemerne 59,2 mesiaca.</p>

<div class="table-responsive" role="region" aria-label="Zhoda percentuálnej zmeny modifikovaného kreatinínového indexu s referenčnými metódami" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Referenčná metóda</th>
      <th scope="col">Systematická odchýlka</th>
      <th scope="col">Hranice zhody</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Zmena svalového tkaniva podľa bioimpedančnej spektroskopie</td><td>+4,9 %</td><td>−26,6 % až +36,4 %</td></tr>
    <tr><td>Zmena beztukovej hmoty podľa kinetiky kreatinínu</td><td>−7,0 %</td><td>−35,4 % až +21,3 %</td></tr>
  </tbody>
</table>
</div>

<p>Systematická odchýlka bola malá, ale <strong>hranice zhody boli extrémne široké</strong>. Rozpätie presahujúce šesťdesiat percentuálnych bodov znamená, že u konkrétneho pacienta môže index naznačovať výrazný nárast svalstva aj vtedy, keď v skutočnosti ubúda, a naopak. Percentuálna zmena indexu navyše nesúvisela s prežívaním, hospitalizáciami ani s výskytom peritonitídy.</p>

<p>Autori uzavreli, že zmena indexu spoľahlivo neodráža zmenu svalovej hmoty u pacientov na peritoneálnej dialýze a že treba hľadať iné neinvazívne metódy.</p>

<h3>Prečo je tento rozdiel dôležitý</h3>

<p>Ide o typickú, ale často prehliadanú situáciu: ukazovateľ môže mať slušnú <strong>prierezovú</strong> koreláciu s referenčnou metódou a súčasne byť nepoužiteľný na <strong>longitudinálne</strong> sledovanie. Korelačný koeficient okolo 0,65 zodpovedá asi 40 % vysvetlenej variability — na hrubé zaradenie pacienta do rizikovej skupiny to stačí, na hodnotenie individuálnej zmeny v čase nie.</p>

<p>Praktický dôsledok je jednoznačný. Vetu „kreatinínový index pacienta sa za pol roka zlepšil, výživová intervencia teda zaberá“ nemožno na základe súčasných údajov vysloviť.</p>

<h2>Prečo je situácia pri peritoneálnej dialýze odlišná</h2>

<p>Peritoneálna dialýza je kontinuálna alebo takmer kontinuálna liečba. Kreatinín sa z organizmu odstraňuje súčasne reziduálnymi obličkami, peritoneálnou dialýzou a v malej miere inými cestami. Koncentrácia kreatinínu v sére preto nie je iba výsledkom svalovej produkcie, ale rovnováhy medzi produkciou, distribúciou a viacerými spôsobmi eliminácie.</p>

<h3>Reziduálna funkcia obličiek</h3>

<p>Reziduálna funkcia obličiek má pri peritoneálnej dialýze zásadný klinický význam. Pacient so zachovanou diurézou môže mať nižší sérový kreatinín než anurický pacient s rovnakým množstvom svalovej hmoty.</p>

<p>Ak sa reziduálny renálny klírens nezohľadní dostatočne, nízka koncentrácia kreatinínu alebo nízky odvodený index môžu viesť k falošnému záveru o úbytku svalstva. Naopak, pri postupnej strate reziduálnej funkcie môže sérový kreatinín stúpať bez toho, aby pacient získaval svalovú hmotu. Práve tento mechanizmus je najpravdepodobnejším vysvetlením zlyhania indexu pri sériovom sledovaní: reziduálna funkcia sa počas prvých dvoch rokov liečby typicky mení najviac.</p>

<h3>Peritoneálny transport a dialyzačný predpis</h3>

<p>Elimináciu kreatinínu ovplyvňujú:</p>

<ul>
  <li>počet a objem výmen,</li>
  <li>dĺžka zotrvania dialyzačného roztoku,</li>
  <li>kontinuálna ambulantná alebo automatizovaná peritoneálna dialýza,</li>
  <li>vlastnosti peritoneálnej membrány,</li>
  <li>transportný typ,</li>
  <li>ultrafiltrácia,</li>
  <li>vynechané výmeny,</li>
  <li>neúplné vypustenie dialyzátu.</li>
</ul>

<p>Dvaja pacienti s rovnakou svalovou hmotou preto nemusia mať rovnaký sérový kreatinín ani rovnaký peritoneálny klírens kreatinínu.</p>

<h3>Neúplný zber moču a dialyzátu</h3>

<p>Výpočty založené na kinetike kreatinínu sú citlivé na presnosť 24-hodinového zberu moču a dialyzátu. Chyby môžu vzniknúť pri:</p>

<ul>
  <li>vynechaní časti moču,</li>
  <li>neúplnom zhromaždení vypusteného dialyzátu,</li>
  <li>nesprávnom zaznamenaní objemov,</li>
  <li>zbere počas atypického dňa,</li>
  <li>zmene dialyzačného predpisu počas zberu,</li>
  <li>laboratórnych alebo preanalytických odchýlkach.</li>
</ul>

<p>Výsledok môže potom pôsobiť matematicky presne, ale biologicky nezodpovedá skutočnosti.</p>

<h3>Príjem mäsa a výživové doplnky</h3>

<p>Tepelne upravené mäso obsahuje kreatinín a kreatín. Jeho konzumácia pred odberom môže prechodne zvýšiť koncentráciu kreatinínu. Výsledok môžu ovplyvniť aj kreatínové doplnky.</p>

<p>Zvýšenie kreatinínu po mäsitej strave neznamená nárast svalovej hmoty. Naopak, pacient s nízkym príjmom mäsa môže mať nižší kreatinín aj bez významnej sarkopénie.</p>

<h3>Akútne ochorenie a nestabilný stav</h3>

<p>Kreatinínové kinetické modely predpokladajú približne stabilný stav. Tento predpoklad nemusí platiť počas:</p>

<ul>
  <li>peritonitídy,</li>
  <li>sepsy,</li>
  <li>akútneho katabolického ochorenia,</li>
  <li>hospitalizácie,</li>
  <li>výraznej zmeny hydratácie,</li>
  <li>rýchlej straty telesnej hmotnosti,</li>
  <li>zmeny dialyzačného režimu,</li>
  <li>akútneho poškodenia reziduálnej funkcie obličiek.</li>
</ul>

<p>V takýchto situáciách môže byť jednorazový kreatinínový index zavádzajúci.</p>

<h2>Index nie je diagnostický test sarkopénie</h2>

<p>Aj dobre vypočítaný kreatinínový index je nepriamym markerom. Nehodnotí priamo svalovú silu, funkčnú rezervu ani kvalitu svalového tkaniva. Keďže EWGSOP2 stavia do centra diagnostiky práve <strong>silu</strong>, žiadny odhad hmoty sám osebe nemôže sarkopéniu potvrdiť ani vylúčiť.</p>

<p>Nízka hodnota môže súvisieť so sarkopéniou, ale aj s:</p>

<ul>
  <li>menšou telesnou konštitúciou,</li>
  <li>ženským pohlavím,</li>
  <li>vyšším vekom,</li>
  <li>nízkym príjmom bielkovín a energie,</li>
  <li>zachovanou reziduálnou diurézou,</li>
  <li>zvýšeným dialyzačným klírensom,</li>
  <li>chronickým ochorením pečene,</li>
  <li>amputáciou,</li>
  <li>dlhodobou imobilitou,</li>
  <li>akútnym katabolizmom.</li>
</ul>

<p>Vyšší index zas nevylučuje zníženú svalovú silu ani zhoršenú fyzickú výkonnosť.</p>

<p>Index preto môže slúžiť ako <strong>skríningový a krátkodobý prognostický marker</strong>. Nemá sa používať ako samostatný dôkaz prítomnosti alebo neprítomnosti sarkopénie, ani ako nástroj na sledovanie účinku intervencie.</p>

<h2>Praktické hodnotenie sarkopénie</h2>

<h3>Skríning</h3>

<p>Dotazník SARC-F hodnotí silu, schopnosť chôdze, vstávanie zo stoličky, chôdzu po schodoch a pády. Je jednoduchý a použiteľný v ambulancii, ale jeho citlivosť býva nízka. Negatívny výsledok preto sarkopéniu nevylučuje, najmä ak je prítomný úbytok hmotnosti, krehkosť alebo zhoršenie mobility.</p>

<p>Niektoré pracoviská používajú SARC-CalF, ktorý pridáva obvod lýtka. Pri peritoneálnej dialýze však môže obvod končatiny skresľovať edém.</p>

<h3>Sila stisku ruky</h3>

<p>Dynamometrické meranie sily stisku ruky je rýchle, lacné a opakovateľné. Nízka sila postačuje na určenie pravdepodobnej sarkopénie.</p>

<p>Výsledok ovplyvňujú bolesť a artróza ruky, neurologické ochorenie, prekonaná cievna mozgová príhoda, dominantná končatina, poloha tela, typ dynamometra a motivácia či porozumenie pokynom. U pacienta s arteriovenóznou fistulou po predchádzajúcej hemodialýze treba merať na neprístupovej končatine.</p>

<p>Meranie treba vykonávať štandardizovaným spôsobom a hodnotiť podľa referenčných hodnôt pre pohlavie a populáciu.</p>

<h3>Test vstávania zo stoličky</h3>

<p>Čas potrebný na päť opakovaných postavení sa zo stoličky hodnotí silu dolných končatín. Test je praktický, ale jeho výsledok ovplyvňujú rovnováha, artróza, bolesť, neurologické ochorenia a kardiopulmonálna výkonnosť.</p>

<h3>Rýchlosť chôdze a fyzická výkonnosť</h3>

<p>Rýchlosť chôdze na štandardizovanej vzdialenosti je jednoduchým markerom mobility a celkovej funkčnej rezervy. Použiť možno aj batériu SPPB, teda Short Physical Performance Battery, test Timed Up and Go alebo šesťminútový test chôdze.</p>

<p>Nízka výkonnosť nie je špecifická pre sarkopéniu. Môže byť dôsledkom srdcového zlyhávania, ischemickej choroby dolných končatín, neuropatie, artrózy, anémie, pľúcneho ochorenia alebo depresie.</p>

<h2>Meranie svalovej hmoty</h2>

<h3>Duálna röntgenová absorpciometria</h3>

<p>DXA dokáže odhadnúť apendikulárnu beztukovú hmotu. Je relatívne štandardizovaná a má nízku radiačnú záťaž.</p>

<p>U dialyzovaných pacientov však beztuková hmota nie je totožná so svalovou hmotou. Nadbytočná extracelulárna tekutina sa započíta do beztukového kompartmentu a vedie k nadhodnoteniu svalstva. Výsledok treba interpretovať spolu s hydratáciou a časovaním vyšetrenia.</p>

<h3>Bioimpedančná analýza</h3>

<p>Bioimpedančná analýza je dostupnejšia a možno ju opakovane vykonávať pri lôžku alebo v dialyzačnom stredisku. Pri peritoneálnej dialýze má však osobitné obmedzenia:</p>

<ul>
  <li>výsledok závisí od hydratácie,</li>
  <li>význam môže mať prítomnosť dialyzátu v brušnej dutine,</li>
  <li>jednotlivé prístroje používajú odlišné algoritmy,</li>
  <li>výsledky rôznych zariadení nemusia byť zameniteľné,</li>
  <li>populačné predikčné rovnice nemusia byť validované pri pokročilej chronickej chorobe obličiek.</li>
</ul>

<p>Meranie by sa malo vykonávať za štandardizovaných podmienok, vždy v porovnateľnom objemovom stave a podľa odporúčania výrobcu týkajúceho sa prítomnosti dialyzátu. Bioimpedančná spektroskopia s modelovaním tekutinových kompartmentov je pri prevodnení spoľahlivejšia než jednofrekvenčné prístroje.</p>

<h3>Počítačová tomografia a magnetická rezonancia</h3>

<p>Zobrazovanie priečneho prierezu svalov, najčastejšie na úrovni tretieho driekového stavca, umožňuje presnejšie hodnotenie množstva svalstva. Počítačová tomografia môže zároveň hodnotiť svalovú denzitu ako nepriamy ukazovateľ tukovej infiltrácie.</p>

<p>Nevýhodami sú radiačná záťaž, náklady, obmedzená dostupnosť, nejednotné prahové hodnoty a nevhodnosť rutinného opakovaného skríningu.</p>

<p>Ak pacient absolvoval počítačovú tomografiu brucha z inej klinickej indikácie, existujúce snímky možno využiť na doplnkové hodnotenie svalstva. Vyšetrenie sa však nemá vykonávať iba na skríning sarkopénie.</p>

<h3>Ultrasonografia svalov</h3>

<p>Ultrasonografické meranie hrúbky a prierezovej plochy svalov je sľubná metóda bez ionizujúceho žiarenia. Výsledky však závisia od miesta merania, tlaku sondy, skúsenosti vyšetrujúceho a použitého protokolu. U dialyzovaných pacientov zatiaľ chýba úplná štandardizácia diagnostických hraníc.</p>

<h2>Sarkopénia, malnutrícia a proteínovo-energetické chradnutie</h2>

<p>Pri chronickej chorobe obličiek sa používa aj pojem proteínovo-energetické chradnutie, teda <em>protein-energy wasting</em>. Ide o stav znížených zásob telesných bielkovín a energie, ktorý môže zahŕňať:</p>

<ul>
  <li>nízke sérové nutričné ukazovatele,</li>
  <li>zníženú telesnú hmotnosť alebo tukové zásoby,</li>
  <li>úbytok svalovej hmoty,</li>
  <li>nedostatočný príjem bielkovín alebo energie.</li>
</ul>

<p>Sarkopénia sa zameriava predovšetkým na svalstvo a jeho funkciu. Malnutrícia vyjadruje nedostatočný alebo nevyvážený prísun a využitie živín. Proteínovo-energetické chradnutie zahŕňa aj dôsledky zápalu, katabolizmu, uremického prostredia a dialyzačných strát.</p>

<p>Pacient môže mať sarkopéniu bez zjavnej podvýživy, malnutríciu bez splnenia kritérií sarkopénie, oba stavy súčasne alebo obezitu spolu so sarkopéniou. Jedna laboratórna hodnota preto nemôže nahradiť komplexné hodnotenie.</p>

<h2>Albumín nie je samostatným ukazovateľom výživy</h2>

<p>Nízka koncentrácia sérového albumínu sa pri dialýze spája s nepriaznivou prognózou, nie je však špecifickým dôkazom nedostatočného príjmu bielkovín.</p>

<p>Albumín ovplyvňujú zápal, infekcia a peritonitída, hydratácia, straty do peritoneálneho dialyzátu, ochorenie pečene, proteinúria, kapilárny únik a celková závažnosť ochorenia.</p>

<p>Nízky albumín môže sprevádzať malnutríciu, nemá sa však označovať za priamu mieru svalovej hmoty ani byť jediným dôvodom na zvýšenie príjmu bielkovín.</p>

<h2>Osobitné faktory pri peritoneálnej dialýze</h2>

<h3>Straty bielkovín do dialyzátu</h3>

<p>Pri peritoneálnej dialýze sa bielkoviny strácajú do vypusteného dialyzátu. Straty sa môžu výrazne zvýšiť počas peritonitídy a pri vysoko permeabilnej peritoneálnej membráne.</p>

<p>Samotná strata bielkovín však neurčuje potrebu výživovej intervencie. Treba hodnotiť príjem, katabolizmus, zápal, telesnú hmotnosť, svalovú silu a celkový klinický stav.</p>

<h3>Metabolická acidóza</h3>

<p>Chronická metabolická acidóza podporuje proteolýzu a môže prispievať k úbytku svalstva. Treba skontrolovať adekvátnosť dialýzy, zloženie liečby a možné gastrointestinálne alebo iné príčiny nízkej koncentrácie bikarbonátu.</p>

<h3>Glukózová záťaž</h3>

<p>Glukóza absorbovaná z dialyzačného roztoku zvyšuje energetický príjem, telesnú hmotnosť a tukovú hmotu. Prírastok hmotnosti preto nemusí znamenať zlepšenie svalového ani nutričného stavu. Zároveň môže znižovať chuť do jedla a prispievať k nedostatočnému príjmu kvalitných bielkovín.</p>

<h3>Reziduálna funkcia obličiek</h3>

<p>Zachovanie reziduálnej funkcie obličiek sa spája s lepšou objemovou kontrolou, odstraňovaním uremických toxínov a priaznivejšími klinickými výsledkami. Pri interpretácii kreatinínu však predstavuje významný konfundujúci faktor.</p>

<p>Pokles sérového kreatinínu môže znamenať úbytok svalstva, ale aj zvýšenie reziduálneho klírensu alebo dialyzačnej dávky. Stúpajúci kreatinín môže naopak odrážať stratu reziduálnej funkcie, nie zlepšenie svalovej hmoty.</p>

<h2>Praktický algoritmus v ambulancii peritoneálnej dialýzy</h2>

<h3>1. Vyhľadať rizikových pacientov</h3>

<p>Zvýšenú pozornosť si vyžaduje nechcený úbytok hmotnosti, zhoršenie chôdze alebo vstávania, opakované pády, krehkosť, nízky príjem potravy, peritonitída alebo opakované hospitalizácie, pretrvávajúci zápal, metabolická acidóza, strata reziduálnej funkcie obličiek, vysoký vek a multimorbidita.</p>

<h3>2. Zmerať svalovú silu</h3>

<p>Preferovaným jednoduchým testom je sila stisku ruky. Ak ju nemožno spoľahlivo zmerať, možno použiť štandardizovaný test vstávania zo stoličky.</p>

<h3>3. Posúdiť svalovú hmotu</h3>

<p>Podľa dostupnosti možno použiť DXA, bioimpedančnú analýzu, validovanú antropometriu alebo už existujúce snímky počítačovej tomografie či magnetickej rezonancie. Výsledok treba interpretovať s ohľadom na hydratáciu, dialyzát v brušnej dutine a použitú referenčnú populáciu.</p>

<h3>4. Zhodnotiť fyzickú výkonnosť</h3>

<p>Rýchlosť chôdze, batéria SPPB alebo test Timed Up and Go pomáhajú určiť funkčnú závažnosť a plánovať rehabilitáciu.</p>

<h3>5. Hľadať reverzibilné príčiny</h3>

<p>Treba cielene posúdiť:</p>

<ul>
  <li>nedostatočný príjem bielkovín a energie,</li>
  <li>zápal a infekciu,</li>
  <li>peritonitídu,</li>
  <li>metabolickú acidózu,</li>
  <li>anémiu,</li>
  <li>hypervolémiu,</li>
  <li>srdcové zlyhávanie,</li>
  <li>depresiu,</li>
  <li>bolesť a neurologické ochorenia,</li>
  <li>nežiaducu sedáciu alebo polyfarmáciu,</li>
  <li>nedostatočnú dialýzu,</li>
  <li>nadmerné dialyzačné straty bielkovín.</li>
</ul>

<h3>6. Sledovať trend správnym nástrojom</h3>

<p>Jednorazová hodnota kreatinínu, bioimpedancie alebo sily stisku ruky má obmedzenú výpovednú hodnotu. Na sledovanie vývoja sa však nehodí každý ukazovateľ rovnako. Podľa súčasných údajov nemá zmysel opierať longitudinálne rozhodovanie o zmenu kreatinínového indexu; vhodnejšie je opakované meranie svalovej sily a fyzickej výkonnosti doplnené o telesné zloženie merané za porovnateľných podmienok.</p>

<p>Ak sa index napriek tomu sleduje, jeho zmenu treba vždy interpretovať spolu so zmenami reziduálneho klírensu, dialyzačného predpisu, príjmu potravy, zápalového stavu a hydratácie.</p>

<h2>Liečebné možnosti</h2>

<h3>Silový a kombinovaný pohybový tréning</h3>

<p>Odporový tréning je základnou nefarmakologickou intervenciou na zlepšenie svalovej sily. Aeróbna aktivita podporuje kardiopulmonálnu výkonnosť a mobilitu. Program musí byť prispôsobený veku, rovnováhe, neuropatii, kardiovaskulárnemu riziku a funkčnému stavu.</p>

<p>Začiatok môže zahŕňať vstávanie zo stoličky, cvičenia s elastickým odporom, chôdzu podľa tolerancie, tréning rovnováhy a postupné zvyšovanie záťaže. Pri peritoneálnej dialýze treba osobitne zvážiť zaťaženie brušnej steny a riziko hernie, najmä v prvých týždňoch po zavedení katétra.</p>

<p>Dôkazy pri peritoneálnej dialýze sú menej rozsiahle než vo všeobecnej populácii. Napriek tomu je fyzická aktivita pri správnom výbere pacienta klinicky opodstatnená.</p>

<h3>Nutričná intervencia</h3>

<p>Výživová liečba má vychádzať z individuálneho posúdenia dietológom so skúsenosťami v nefrológii. Treba zohľadniť spontánny príjem potravy, dialyzačné straty bielkovín, energiu absorbovanú z glukózy v dialyzáte, hyperkaliémiu a hyperfosfatémiu, diabetes, objemový stav, reziduálnu funkciu obličiek a prítomnosť zápalu či peritonitídy.</p>

<p>Paušálne odporúčanie vysokoproteínovej diéty nie je vhodné pre každého pacienta. Zvýšenie príjmu bielkovín bez dostatočného energetického príjmu, kontroly fosforu a individuálneho zhodnotenia nemusí viesť k tvorbe svalstva.</p>

<h3>Korekcia acidózy a liečba komorbidít</h3>

<p>Treba optimalizovať acidobázickú rovnováhu, liečbu anémie, kontrolu diabetu, objemový stav, dialyzačnú adekvátnosť, liečbu infekcie a zápalu, ako aj depresiu, bolesť a poruchy spánku.</p>

<p>Farmakologická liečba určená výhradne na sarkopéniu pri peritoneálnej dialýze zatiaľ nemá štandardné postavenie.</p>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly pri hodnotení sarkopénie na peritoneálnej dialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Modifikovaný kreatinínový index môže jednorazovo odhadnúť svalovú hmotu</td><td>Podporené</td><td>Pri stabilnom stave koreloval s kinetikou kreatinínu aj bioimpedanciou (r okolo 0,65).</td></tr>
    <tr><td>Zmena indexu v čase odráža zmenu svalovej hmoty</td><td>Vyvrátené</td><td>Hranice zhody presiahli 60 percentuálnych bodov; zmena nesúvisela ani s prežívaním.</td></tr>
    <tr><td>Zvýšenie indexu dokazuje úspešnú tvorbu svalstva</td><td>Nesprávne</td><td>Treba vylúčiť zmenu reziduálnej funkcie, dialýzy, stravy a hydratácie.</td></tr>
    <tr><td>Rovnicu z hemodialýzy možno bez úprav preniesť na peritoneálnu dialýzu</td><td>Nesprávne</td><td>Pri peritoneálnej dialýze sa dosádza celkové týždenné Kt/V a platnosť bolo nutné overiť osobitne.</td></tr>
    <tr><td>Nízky index potvrdzuje sarkopéniu</td><td>Nesprávne</td><td>Chýba priame hodnotenie svalovej sily, ktorá je podľa EWGSOP2 rozhodujúca.</td></tr>
    <tr><td>Normálny alebo vysoký index sarkopéniu vylučuje</td><td>Nesprávne</td><td>Nevylučuje zníženú svalovú silu ani zhoršenú fyzickú výkonnosť.</td></tr>
    <tr><td>Sérový kreatinín je priamou mierou svalovej hmoty</td><td>Nesprávne</td><td>Ovplyvňuje ho produkcia, renálny aj peritoneálny klírens, strava a hydratácia.</td></tr>
    <tr><td>Reziduálna funkcia obličiek významne ovplyvňuje kreatinín pri peritoneálnej dialýze</td><td>Potvrdené</td><td>Je hlavným konfundujúcim faktorom, najmä v prvých rokoch liečby.</td></tr>
    <tr><td>Bioimpedancia meria svalovú hmotu nezávisle od hydratácie</td><td>Nesprávne</td><td>Výsledok závisí od objemového stavu aj od prítomnosti dialyzátu v bruchu.</td></tr>
    <tr><td>DXA presne odlíši svalstvo od nadbytočnej extracelulárnej tekutiny</td><td>Nie úplne</td><td>Prevodnenie sa započíta do beztukovej hmoty a svalstvo nadhodnotí.</td></tr>
    <tr><td>Počítačová tomografia a magnetická rezonancia hodnotia svalstvo presnejšie</td><td>Podporené</td><td>Nie sú však vhodné na rutinný opakovaný skríning bez klinickej indikácie.</td></tr>
    <tr><td>Albumín je spoľahlivou samostatnou mierou výživy a svalstva</td><td>Nesprávne</td><td>Ovplyvňuje ho zápal, hydratácia, straty do dialyzátu a závažnosť ochorenia.</td></tr>
    <tr><td>Sarkopénia, malnutrícia a proteínovo-energetické chradnutie sú synonymá</td><td>Nesprávne</td><td>Prekrývajú sa, ale definujú odlišné javy a môžu sa vyskytovať samostatne.</td></tr>
    <tr><td>Silový tréning a individualizovaná výživa sú racionálnou súčasťou liečby</td><td>Podporené</td><td>Kvalita dôkazov špecificky pri peritoneálnej dialýze je však obmedzená.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Modifikovaný kreatinínový index je praktický doplnkový ukazovateľ svalového a nutričného stavu, ktorý pri peritoneálnej dialýze obstál ako jednorazový odhad svalovej hmoty a krátkodobý prognostický marker. Jeho <strong>sériové</strong> hodnotenie však v prospektívnej štúdii zlyhalo: percentuálna zmena indexu neodrážala skutočnú zmenu svalstva a nesúvisela s klinickými výsledkami.</p>

<p>Hlavnými dôvodmi sú vplyv reziduálnej funkcie obličiek, peritoneálneho klírensu, dialyzačného predpisu, stravy a presnosti zberu moču a dialyzátu. Práve tieto veličiny sa počas prvých rokov liečby menia najviac, takže sa premietnu do indexu bez ohľadu na svalstvo.</p>

<p><strong>Sarkopéniu nemožno diagnostikovať z koncentrácie kreatinínu ani z odvodeného indexu. Klinicky použiteľné hodnotenie má vychádzať zo svalovej sily, doplnenej o množstvo svalstva, fyzickú výkonnosť, nutričný stav, hydratáciu a hľadanie reverzibilných príčin katabolizmu. Index má zmysel ako varovný signál, nie ako meradlo úspechu liečby.</strong></p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Miedziaszczyk M, Ng JK, Fung WW, Chan GC, Chow KM, Szeto CC.</strong> <em>Modified creatinine index as a noninvasive tool for the monitoring of muscle mass in peritoneal dialysis.</em> Perit Dial Int. Publikované online 30. mája 2026. doi: 10.1177/08968608261456380. Prospektívne sledovanie 351 pacientov; zmena indexu spoľahlivo neodrážala zmenu svalovej hmoty. <a href="https://doi.org/10.1177/08968608261456380" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42217156/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Ng JK, Fung WW, Chan GC, Cheng PM, Pang WF, Chow KM, Szeto CC.</strong> <em>Modified creatinine index as a marker of skeletal muscle mass in peritoneal dialysis patients.</em> Clin Kidney J. 2024;17(10):sfae297. doi: 10.1093/ckj/sfae297. Validácia jednorazového merania na 138 a 605 pacientoch. <a href="https://doi.org/10.1093/ckj/sfae297" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11487157/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Abudoureheman W, Zhang F, Sun Q.</strong> <em>Beyond modified creatinine index: Practical assessment of sarcopenia in peritoneal dialysis.</em> Perit Dial Int. Publikované online 13. augusta 2026. doi: 10.1177/08968608261476564. Redakčná korešpondencia k predchádzajúcej štúdii. <a href="https://doi.org/10.1177/08968608261476564" target="_blank" rel="noopener noreferrer">List redakcii</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42594151/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Szeto CC.</strong> <em>Reply to: Beyond modified creatinine index: Practical assessment of sarcopenia in peritoneal dialysis.</em> Perit Dial Int. Publikované online 7. augusta 2026. doi: 10.1177/08968608261476562. Odpoveď autorov. <a href="https://doi.org/10.1177/08968608261476562" target="_blank" rel="noopener noreferrer">Odpoveď</a>.</li>
  <li><strong>Cruz-Jentoft AJ, Bahat G, Bauer J, a spol.</strong> <em>Sarcopenia: revised European consensus on definition and diagnosis.</em> Age Ageing. 2019;48(1):16–31. doi: 10.1093/ageing/afy169. <a href="https://doi.org/10.1093/ageing/afy169" target="_blank" rel="noopener noreferrer">Konsenzus EWGSOP2</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6322506/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Chen LK, Woo J, Assantachai P, a spol.</strong> <em>Asian Working Group for Sarcopenia: 2019 Consensus Update on Sarcopenia Diagnosis and Treatment.</em> J Am Med Dir Assoc. 2020;21(3):300–307.e2. doi: 10.1016/j.jamda.2019.12.012. <a href="https://doi.org/10.1016/j.jamda.2019.12.012" target="_blank" rel="noopener noreferrer">Konsenzus AWGS</a>.</li>
  <li><strong>Canaud B, Granger Vallée A, Molinari N, a spol.</strong> <em>Creatinine index as a surrogate of lean body mass derived from urea Kt/V, pre-dialysis serum levels and anthropometric characteristics of haemodialysis patients.</em> PLoS One. 2014;9(3):e93286. doi: 10.1371/journal.pone.0093286. Pôvodná rovnica pre hemodialýzu. <a href="https://doi.org/10.1371/journal.pone.0093286" target="_blank" rel="noopener noreferrer">Pôvodná publikácia</a>.</li>
  <li><strong>Ikizler TA, Burrowes JD, Byham-Gray LD, a spol.</strong> <em>KDOQI Clinical Practice Guideline for Nutrition in CKD: 2020 Update.</em> Am J Kidney Dis. 2020;76(3 Suppl 1):S1–S107. doi: 10.1053/j.ajkd.2020.05.006. <a href="https://doi.org/10.1053/j.ajkd.2020.05.006" target="_blank" rel="noopener noreferrer">Odporúčanie KDOQI</a>.</li>
  <li><strong>Malmstrom TK, Morley JE.</strong> <em>SARC-F: a simple questionnaire to rapidly diagnose sarcopenia.</em> J Am Med Dir Assoc. 2013;14(8):531–532. doi: 10.1016/j.jamda.2013.05.018. <a href="https://doi.org/10.1016/j.jamda.2013.05.018" target="_blank" rel="noopener noreferrer">Pôvodný opis dotazníka</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Podnetom na tému bola redakčná korešpondencia v časopise Peritoneal Dialysis International. Listy redakcii ani odpovede autorov neposkytujú nové prospektívne dáta, preto článok vychádza predovšetkým z oboch primárnych štúdií, na ktoré korešpondencia nadväzuje, a z platných konsenzov o sarkopénii a výžive pri chronickej chorobe obličiek. Číselné údaje boli overené proti primárnym publikáciám.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Diagnostické hranice odvodené zo všeobecnej alebo hemodialyzačnej populácie vyžadujú samostatnú validáciu u pacientov na peritoneálnej dialýze. Výživové a pohybové intervencie treba prispôsobiť individuálnemu klinickému stavu, objemovému stavu, komorbiditám a dialyzačnému predpisu.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index_article',
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
