<?php

/**
 * add_cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — spracovanie štúdie JASN 2026;37(8):1764-1772
 * (doi 10.1681/ASN.0000001046, PMID 41719070, PMC13441074)
 * doplnené o odborné odporúčania a podkladové randomizované dôkazy.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Cieľový systolický tlak pod 120 mm Hg pri chronickej chorobe obličiek sa v praxi uplatňuje len obmedzene',
    'slug'         => 'cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V roku 2024 malo priemerný systolický tlak pod 120 mm Hg iba 21,9 % pacientov s CKD G3 až G4. Číslo však nemeria dodržiavanie odporúčania KDIGO: to sa viaže na štandardizované meranie, štúdia použila rutinné ambulantné hodnoty.',
    'content'      => <<<'HTML'
<p>Analýza zdravotných záznamov zo siete Mass General Brigham ukázala, že v roku 2024 malo priemerný systolický krvný tlak pod 120 mm Hg iba <strong>21,9 %</strong> pacientov s chronickou chorobou obličiek v štádiu G3 až G4. Oproti roku 2020 išlo len o mierny nárast.</p>

<p>Výsledok však nemožno interpretovať tak, že takmer štyria z piatich pacientov boli liečení nesprávne. Odporúčanie KDIGO sa vzťahuje na <strong>štandardizované</strong> meranie krvného tlaku, zatiaľ čo štúdia analyzovala bežné ambulantné merania. Ide o dva rôzne ukazovatele, ktoré nie sú zameniteľné.</p>

<h2>Čo odporúča KDIGO</h2>

<p>Odporúčanie KDIGO z roku 2021 navrhuje, aby sa u dospelých pacientov s vysokým krvným tlakom a chronickou chorobou obličiek, ktorí nie sú liečení dialýzou, znižoval systolický krvný tlak na hodnotu <strong>nižšiu ako 120 mm Hg</strong>, pokiaľ pacient takúto liečbu toleruje.</p>

<p>Ide o odporúčanie so stupňom <strong>2B</strong>, teda o podmienené odporúčanie založené na dôkazoch strednej kvality. Nie je to univerzálna hranica, ktorú treba bez výnimky dosiahnuť u každého pacienta.</p>

<p>Zásadnou podmienkou je, že tlak musí byť meraný <strong>štandardizovanou ambulantnou metódou</strong>. Tá zahŕňa najmä:</p>

<ul>
  <li>pokoj pred meraním,</li>
  <li>správnu polohu tela a oporu chrbta,</li>
  <li>chodidlá položené na podlahe,</li>
  <li>podopreté rameno v úrovni srdca,</li>
  <li>vhodnú veľkosť manžety,</li>
  <li>zákaz rozhovoru počas merania,</li>
  <li>viacnásobné meranie podľa stanoveného protokolu,</li>
  <li>vylúčenie fajčenia, fyzickej námahy a príjmu kofeínu krátko pred vyšetrením.</li>
</ul>

<p>Hodnota systolického tlaku pod 120 mm Hg získaná štandardizovaným spôsobom preto nie je priamo zameniteľná s hodnotou nameranou narýchlo počas bežnej ambulantnej návštevy.</p>

<p>Odporúčanie sa nevzťahuje rovnakým spôsobom na dialyzovaných pacientov, deti a príjemcov transplantovanej obličky. Opatrnosť a individualizácia sú potrebné aj pri symptomatickej ortostatickej hypotenzii, veľmi nízkom diastolickom tlaku, pokročilej krehkosti, obmedzenej očakávanej dĺžke života alebo pri neznášanlivosti intenzívnej antihypertenzívnej liečby.</p>

<h3>Cieľ KDIGO je medzi odporúčaniami výnimkou</h3>

<p>Pri interpretácii pomáha vedieť, že hranica 120 mm Hg nie je konsenzom odborných spoločností, ale najprísnejším z používaných cieľov.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie cieľových hodnôt krvného tlaku podľa odborných spoločností" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Odporúčanie</th>
      <th scope="col">Cieľový systolický tlak</th>
      <th scope="col">Spôsob merania</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">KDIGO 2021 (CKD bez dialýzy)</th>
      <td>&lt; 120 mm Hg, ak sa toleruje (2B)</td>
      <td>Štandardizované ambulantné meranie</td>
    </tr>
    <tr>
      <th scope="row">ACC/AHA 2017</th>
      <td>&lt; 130 mm Hg</td>
      <td>Ambulantné meranie podľa protokolu</td>
    </tr>
    <tr>
      <th scope="row">ESC 2024</th>
      <td>120–129 mm Hg u väčšiny liečených dospelých</td>
      <td>Ambulantné meranie s potvrdením mimo ambulancie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Dasgupta a Zoccali v prehľade v časopise <em>Hypertension</em> upozornili, že cieľ KDIGO je „výnimkou medzi súčasnými veľkými medzinárodnými odporúčaniami pre hypertenziu“ a že jeho mechanické použitie na rutinne merané hodnoty by pacientov s viacerými ochoreniami a krehkých pacientov vystavilo riziku nežiaducich udalostí vrátane pádov a zlomenín. Pomalé prijatie cieľa preto nie je len prejavom zotrvačnosti — odráža aj odbornú neistotu, ktorá bola opísaná krátko po zverejnení odporúčania.</p>

<h2>Ako bola skúmaná reálna klinická prax</h2>

<p>Hyeok-Hee Lee a spolupracovníci analyzovali elektronické zdravotné záznamy zo siete Mass General Brigham v Novom Anglicku. Štúdia mala dve samostatné časti.</p>

<h3>Opakované prierezové analýzy</h3>

<p>Autori v jednotlivých rokoch 2020 až 2024 identifikovali dospelých vo veku 18 až 79 rokov s CKD G3 až G4. Chronická choroba obličiek bola určená na základe diagnostického kódu alebo hodnoty odhadovanej glomerulovej filtrácie od 15 do 59 ml/min/1,73 m².</p>

<div class="table-responsive" role="region" aria-label="Počet zaradených pacientov podľa roku" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Rok</th>
      <th scope="col">Počet pacientov</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">2020</th><td>51 404</td></tr>
    <tr><th scope="row">2021</th><td>52 855</td></tr>
    <tr><th scope="row">2022</th><td>51 852</td></tr>
    <tr><th scope="row">2023</th><td>50 169</td></tr>
    <tr><th scope="row">2024</th><td>45 651</td></tr>
  </tbody>
</table>
</div>

<p>Pacienti po transplantácii obličky a pacienti liečení dialýzou boli vylúčení. Podmienkou zaradenia boli najmenej dve ambulantné merania krvného tlaku v príslušnom roku.</p>

<p>Jednotliví pacienti mohli byť zahrnutí vo viacerých rokoch. Nešlo teda o sledovanie jednej nemennej kohorty, ale o samostatné ročné prierezy populáciou zdravotníckeho systému.</p>

<h3>Longitudinálna analýza</h3>

<p>V druhej časti autori sledovali 18 996 pacientov s novozistenou CKD G3 až G4 v rokoch 2014 až 2019. Vylúčení boli okrem dialyzovaných a transplantovaných pacientov aj ľudia s predchádzajúcim kardiovaskulárnym ochorením, nedostatočným počtom meraní tlaku alebo chýbajúcimi údajmi potrebnými na štatistickú analýzu.</p>

<p>Priemerný systolický tlak počas úvodného šesťmesačného obdobia sa použil na rozdelenie pacientov do dvoch skupín: pod 120 mm Hg a 120 mm Hg alebo vyšší. Následne sa hodnotil výskyt kardiovaskulárnych príhod, zlyhania obličiek a vybraných bezpečnostných ukazovateľov.</p>

<h2>Len mierny nárast podielu pacientov s tlakom pod 120 mm Hg</h2>

<p>V roku 2020, teda pred publikovaním odporúčania KDIGO, malo priemerný systolický tlak pod 120 mm Hg 18,3 % pacientov. Vývoj v nasledujúcich rokoch bol len mierny.</p>

<div class="table-responsive" role="region" aria-label="Podiel pacientov so systolickým tlakom pod 120 mm Hg podľa roku" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Rok</th>
      <th scope="col">Pacienti so systolickým tlakom pod 120 mm Hg</th>
      <th scope="col">Upravený absolútny rozdiel oproti roku 2020</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">2020</th><td>18,3 %</td><td>referenčný rok</td></tr>
    <tr><th scope="row">2021</th><td>18,0 %</td><td>−0,3 pb (95 % IS −1,2 až 1,3)</td></tr>
    <tr><th scope="row">2022</th><td>19,3 %</td><td>1,0 pb (95 % IS −0,1 až 2,0)</td></tr>
    <tr><th scope="row">2023</th><td>20,0 %</td><td>1,7 pb (95 % IS 0,2 až 3,1)</td></tr>
    <tr><th scope="row">2024</th><td>21,9 %</td><td>3,6 pb (95 % IS 1,9 až 5,3)</td></tr>
  </tbody>
</table>
</div>

<p>Za povšimnutie stojí, že v prvom roku po publikovaní odporúčania sa podiel nezvýšil vôbec a intervaly spoľahlivosti prekročili nulu až od roku 2023. Nárast teda nastal až s odstupom dvoch rokov.</p>

<p>V roku 2024 tak malo priemerný systolický tlak 120 mm Hg alebo vyšší približne 78 % pacientov. Zároveň však medián systolického tlaku mierne klesol zo 131 mm Hg v roku 2020 na 130 mm Hg v roku 2024 a medián diastolického tlaku zo 73 na 71 mm Hg. Nešlo teda o úplnú absenciu populačnej zmeny, ale o malý posun, ktorý väčšinu pacientov nepresunul pod hranicu 120 mm Hg.</p>

<h2>Minimálna zmena antihypertenzívnej liečby</h2>

<p>Priemerný počet predpísaných skupín antihypertenzív sa zvýšil z 1,53 v roku 2020 na 1,58 v roku 2023 a následne klesol na 1,55 v roku 2024. Celková zmena medzi rokmi 2020 a 2024 tak predstavovala iba 0,02 liekovej skupiny na pacienta.</p>

<p>Používanie jednotlivých tried antihypertenzív sa tiež menilo len málo. V roku 2024 malo podľa elektronických záznamov predpísaný inhibítor angiotenzín konvertujúceho enzýmu alebo blokátor receptora angiotenzínu 51 % pacientov, blokátor kalciových kanálov 37 % a diuretikum 43 %.</p>

<p>Tieto údaje môžu poukazovať na obmedzenú intenzifikáciu liečby, nemožno však z nich priamo dokázať terapeutickú zotrvačnosť. Počet predpísaných liekov neinformuje o:</p>

<ul>
  <li>použitých dávkach,</li>
  <li>zvyšovaní alebo znižovaní dávok,</li>
  <li>adherencii pacienta,</li>
  <li>kontraindikáciách,</li>
  <li>neznášanlivosti liečby,</li>
  <li>vysadení lieku pre nežiaduce účinky,</li>
  <li>používaní fixných kombinácií,</li>
  <li>liekoch predpísaných mimo analyzovaného systému.</li>
</ul>

<p>Samotná hodnota 1,55 liekovej skupiny na pacienta preto nie je úplným ukazovateľom intenzity antihypertenzívnej liečby.</p>

<h2>Výsledky pri miernejšej hranici 130 mm Hg</h2>

<p>Autori vykonali aj citlivostnú analýzu s hranicou systolického tlaku pod 130 mm Hg, ktorá zodpovedala americkému odporúčaniu ACC/AHA z roku 2017.</p>

<p>Podiel pacientov pod touto hranicou vzrástol zo 44,7 % v roku 2020 na 50,4 % v roku 2024, absolútny rozdiel 5,7 percentuálneho bodu.</p>

<p>Aj pri menej prísnej hranici tak malo v roku 2024 približne 49,6 % pacientov systolický tlak 130 mm Hg alebo vyšší. Problém nedostatočne kontrolovanej hypertenzie preto nemožno vysvetliť iba mimoriadne prísnym cieľom KDIGO.</p>

<h2>Súvislosť krvného tlaku s kardiovaskulárnymi a obličkovými príhodami</h2>

<p>V longitudinálnej kohorte malo systolický tlak pod 120 mm Hg 3 767 z 18 996 pacientov, teda 19,8 %. Medián sledovania predstavoval 6,9 roka. Počas sledovania sa zaznamenalo 6 021 kardiovaskulárnych príhod a 2 213 prípadov zlyhania obličiek.</p>

<p>Po štatistickom zohľadnení viacerých klinických charakteristík bol systolický tlak 120 mm Hg alebo vyšší v porovnaní s tlakom pod 120 mm Hg spojený s:</p>

<ul>
  <li>o 19 % vyšším relatívnym rizikom kardiovaskulárnej príhody, pomer rizík 1,19 (95 % IS 1,11 až 1,27),</li>
  <li>o 21 % vyšším relatívnym rizikom zlyhania obličiek, pomer rizík 1,21 (95 % IS 1,08 až 1,35).</li>
</ul>

<p>Kardiovaskulárny výsledok zahŕňal infarkt myokardu, cievnu mozgovú príhodu alebo srdcové zlyhávanie. Modely boli upravené o vek, pohlavie, rasu a etnicitu, zdravotné poistenie, fajčenie, diabetes mellitus, index telesnej hmotnosti, diastolický tlak, eGFR, koncentrácie celkového a HDL cholesterolu, antihypertenzívnu a hypolipidemickú liečbu a Charlsonov index komorbidity.</p>

<p>Výsledok podporuje známy vzťah medzi vyšším krvným tlakom a kardiorenálnym rizikom. Nedokazuje však, že zníženie tlaku konkrétne pod 120 mm Hg by u tejto populácie príčinne znížilo riziko o uvedené percentá.</p>

<h2>Bezpečnostné ukazovatele</h2>

<p>Pacienti so systolickým tlakom 120 mm Hg alebo vyšším mali nižší zaznamenaný výskyt hypotenzie než pacienti s tlakom pod 120 mm Hg: pomer rizík 0,80 (95 % IS 0,72 až 0,89). Pri ostatných sledovaných bezpečnostných ukazovateľoch sa štatisticky významné rozdiely nezistili.</p>

<div class="table-responsive" role="region" aria-label="Bezpečnostné ukazovatele pri systolickom tlaku najmenej 120 mm Hg oproti tlaku pod 120 mm Hg" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Výsledok pri tlaku najmenej 120 mm Hg oproti tlaku pod 120 mm Hg</th>
      <th scope="col">Pomer rizík</th>
      <th scope="col">95 % interval spoľahlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Hypotenzia</th><td>0,80</td><td>0,72 až 0,89</td></tr>
    <tr><th scope="row">Synkopa</th><td>1,06</td><td>0,95 až 1,18</td></tr>
    <tr><th scope="row">Bradykardia</th><td>1,05</td><td>0,92 až 1,19</td></tr>
    <tr><th scope="row">Elektrolytová porucha</th><td>0,98</td><td>0,90 až 1,07</td></tr>
    <tr><th scope="row">Pád s poranením</th><td>0,93</td><td>0,83 až 1,05</td></tr>
  </tbody>
</table>
</div>

<p>Tieto údaje nie sú dôkazom, že aktívne znižovanie systolického tlaku pod 120 mm Hg je v bežnej populácii bezpečné. Štúdia neporovnávala randomizované liečebné stratégie, ale skupiny vytvorené podľa už existujúceho krvného tlaku.</p>

<p>Vyšší výskyt hypotenzie v skupine s nižším tlakom mohol súvisieť s intenzívnejšou liečbou, ale aj s autonómnou dysfunkciou, srdcovým zlyhávaním, krehkosťou, interkurentnými ochoreniami alebo inými charakteristikami pacientov. Časť týchto faktorov nemožno spoľahlivo odstrániť štatistickou korekciou.</p>

<h2>Najdôležitejší metodologický problém: neštandardizované meranie</h2>

<p>Najväčším problémom pri interpretácii štúdie je rozdiel medzi spôsobom merania krvného tlaku v odporúčaní KDIGO a spôsobom jeho merania v analyzovanej zdravotnej dokumentácii.</p>

<p>KDIGO viaže cieľ pod 120 mm Hg na štandardizované ambulantné meranie. V štúdii sa použili hodnoty získané počas bežných ambulantných návštev automatickými oscilometrickými alebo aneroidnými auskultačnými prístrojmi. Z dokumentácie nebolo možné spoľahlivo overiť:</p>

<ul>
  <li>dĺžku odpočinku pred meraním,</li>
  <li>polohu pacienta,</li>
  <li>správnosť veľkosti manžety,</li>
  <li>prítomnosť zdravotníckeho pracovníka,</li>
  <li>rozhovor počas merania,</li>
  <li>čas od príjmu kofeínu, fajčenia alebo námahy,</li>
  <li>jednotnosť meracieho protokolu medzi pracoviskami.</li>
</ul>

<p>Pri bežnom ambulantnom meraní býva tlak často vyšší než pri dôsledne štandardizovanom meraní, hoci veľkosť a niekedy aj smer rozdielu sa medzi pacientmi a pracoviskami menia.</p>

<p>Preto nemožno tvrdiť, že iba 21,9 % pacientov skutočne dosahovalo správne aplikovaný cieľ KDIGO. Presnejšie je povedať, že 21,9 % malo <strong>priemer rutinne nameraných ambulantných hodnôt pod číselnou hranicou 120 mm Hg</strong>.</p>

<p>Takéto rozlíšenie je klinicky významné. Bez štandardizácie môže mechanické použitie hranice 120 mm Hg viesť k zbytočnej intenzifikácii liečby a u citlivých pacientov k hypotenzii.</p>

<h2>Ďalšie obmedzenia štúdie</h2>

<h3>Pozorovacia štúdia nedokazuje príčinnosť</h3>

<p>Pacienti neboli náhodne priradení k rozdielnym cieľovým hodnotám krvného tlaku. Skupina s tlakom najmenej 120 mm Hg bola staršia, mala častejšie diabetes, vyšší index telesnej hmotnosti, viac komorbidít a nepriaznivejší kardiometabolický profil.</p>

<p>Štatistická úprava znižuje vplyv známych rozdielov, ale nevylučuje reziduálne a nemerané skreslenie. Vyššie riziko preto nemožno pripísať samotnému prekročeniu hranice 120 mm Hg.</p>

<h3>Longitudinálna kohorta vznikla pred publikovaním odporúčania</h3>

<p>Pacienti boli do longitudinálnej analýzy zaradení v rokoch 2014 až 2019. Táto časť štúdie preto nehodnotila výsledky implementácie odporúčania KDIGO z roku 2021. Hodnotila prognostický význam krvného tlaku definovaného podľa hranice, ktorá bola stanovená neskôr.</p>

<h3>Krvný tlak sa hodnotil najmä na začiatku sledovania</h3>

<p>Pacienti boli rozdelení podľa priemeru meraní počas úvodného obdobia. Ich tlak, liečba a zdravotný stav sa však mohli v priebehu takmer siedmich rokov významne meniť. Zmena expozície počas sledovania mohla oslabiť alebo skresliť pozorované vzťahy.</p>

<h3>Definícia CKD mohla viesť k nesprávnej klasifikácii</h3>

<p>CKD bola identifikovaná pomocou diagnostického kódu alebo hodnoty eGFR od 15 do 59 ml/min/1,73 m². Jednorazovo znížená eGFR bez potvrdenia trvania najmenej tri mesiace nemusí spĺňať definíciu chronickej choroby obličiek. Výsledky zostali podobné aj pri citlivostnej analýze založenej iba na eGFR, ale problém preukázania chronicity tým nebol úplne odstránený.</p>

<h3>Albuminúria nebola dostupná u všetkých pacientov</h3>

<p>Albuminúria je významný nezávislý prediktor progresie CKD aj kardiovaskulárneho rizika. V longitudinálnych modeloch nebola uvedená medzi hlavnými korekčnými premennými, pravdepodobne pre veľký podiel chýbajúcich údajov. Reziduálne skreslenie rozdielnym stupňom albuminúrie preto nemožno vylúčiť.</p>

<h3>Výrazná selekcia longitudinálnej kohorty</h3>

<p>Zo 83 249 potenciálne vhodných pacientov zostalo po uplatnení všetkých kritérií 18 996, teda necelá štvrtina. Hlavnými dôvodmi boli nedostatočný počet meraní, predchádzajúce kardiovaskulárne ochorenie a chýbajúce údaje. Takáto selekcia obmedzuje prenositeľnosť výsledkov na všetkých pacientov s CKD — najmä vylúčenie pacientov s predchádzajúcim kardiovaskulárnym ochorením, teda práve tých s najvyšším absolútnym rizikom.</p>

<h3>Chýbali pacienti vo veku 80 rokov a viac</h3>

<p>Priemerný vek pacientov v ročných analýzach sa pohyboval od 73 do 75 rokov, ale osoby vo veku 80 rokov a viac boli vylúčené. Výsledky preto nemožno priamo preniesť na najstarších, často najkrehkejších pacientov, u ktorých je riziko ortostatickej hypotenzie a nežiaducich účinkov liečby mimoriadne dôležité.</p>

<h3>Vplyv pandémie a zmien v zdravotnej starostlivosti</h3>

<p>Východiskovým rokom bol rok 2020. Dostupnosť ambulantnej starostlivosti, frekvencia návštev a spôsob merania krvného tlaku boli počas pandémie COVID-19 neštandardné. Časť rozdielov medzi rokmi preto môže súvisieť so zmenami v organizácii starostlivosti, nie iba s prijatím alebo neprijatím odporúčania. Nápadný je aj pokles počtu zaradených pacientov v roku 2024 o približne 4 500 oproti predchádzajúcemu roku, ktorý štúdia nevysvetľuje.</p>

<h3>Výsledky pochádzajú z jedného amerického systému</h3>

<p>Mass General Brigham je rozsiahla a dobre vybavená zdravotnícka sieť, ale jej pacienti, organizačné postupy a dostupnosť liečby nemusia zodpovedať podmienkam v iných krajinách. Nehispánski belosi tvorili 83 % a 86 % oboch skupín longitudinálnej kohorty.</p>

<p>Výsledky nemožno bez ďalšieho preniesť na Slovensko ani na zdravotné systémy s inou dostupnosťou primárnej, nefrologickej a farmakologickej starostlivosti.</p>

<h2>Čo priniesla štúdia SPRINT</h2>

<p>Odporúčanie KDIGO bolo do veľkej miery založené na štúdii SPRINT, ktorá u 9 361 osôb so zvýšeným kardiovaskulárnym rizikom porovnávala intenzívnu liečbu s cieľovým systolickým tlakom pod 120 mm Hg so štandardnou liečbou s cieľom pod 140 mm Hg.</p>

<p>V celom súbore SPRINT preukázala zníženie výskytu závažných kardiovaskulárnych príhod (pomer rizík 0,75; 95 % IS 0,64 až 0,89) aj celkovej mortality (0,73; 0,60 až 0,90). Do štúdie však neboli zaradení pacienti s diabetes mellitus ani s prekonanou cievnou mozgovou príhodou. Vylúčené boli aj niektoré klinicky významné skupiny pacientov s CKD, napríklad pacienti s proteinúriou nad 1 g denne, polycystickou chorobou obličiek alebo glomerulonefritídou liečenou imunosupresívami.</p>

<h3>Podskupina s CKD: výsledok je slabší, než sa často uvádza</h3>

<p>Vopred určená podskupinová analýza 2 646 účastníkov s CKD priniesla údaje, ktoré si zasluhujú presné znenie:</p>

<div class="table-responsive" role="region" aria-label="Výsledky podskupiny s CKD v štúdii SPRINT" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Výsledok (intenzívna oproti štandardnej liečbe)</th>
      <th scope="col">Pomer rizík</th>
      <th scope="col">95 % IS</th>
      <th scope="col">Význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Zložený kardiovaskulárny výsledok</th>
      <td>0,81</td>
      <td>0,63 až 1,05</td>
      <td><strong>Nedosiahol štatistickú významnosť</strong></td>
    </tr>
    <tr>
      <th scope="row">Úmrtie z akejkoľvek príčiny</th>
      <td>0,72</td>
      <td>0,53 až 0,99</td>
      <td>Významné zníženie</td>
    </tr>
    <tr>
      <th scope="row">Hlavný obličkový výsledok (pokles eGFR o ≥ 50 % alebo zlyhanie obličiek)</th>
      <td>0,90</td>
      <td>0,44 až 1,83</td>
      <td>Bez rozdielu; iba 15 oproti 16 udalostiam</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tvrdenie, že intenzívna liečba v podskupine s CKD znížila kardiovaskulárne riziko, teda nie je presné: zložený kardiovaskulárny výsledok významnosť <strong>nedosiahol</strong>. Významné bolo iba zníženie celkovej mortality. Zároveň sa nepreukázalo modifikovanie účinku prítomnosťou CKD (hodnoty p pre interakciu ≥ 0,30), takže prínos zistený v celom súbore sa na pacientov s CKD pravdepodobne vzťahuje — ale samotná podskupina na jeho preukázanie nemala dostatočnú silu.</p>

<p>Presvedčivý renoprotektívny účinok sa nepreukázal. Po úvodných šiestich mesiacoch mala intenzívne liečená skupina dokonca mierne rýchlejší pokles eGFR (−0,47 oproti −0,32 ml/min/1,73 m² za rok; p &lt; 0,03). Akútny hemodynamický pokles eGFR po začatí intenzívnej liečby pritom nemožno automaticky stotožniť so štrukturálnym poškodením obličiek.</p>

<p>SPRINT navyše používala starostlivo organizované meranie krvného tlaku automatickým prístrojom podľa protokolu. Jej cieľovú hodnotu preto nemožno nekriticky preniesť na neštandardizované ambulantné meranie.</p>

<h2>Prečo sa cieľ KDIGO uplatňuje pomaly</h2>

<ol>
  <li><strong>Neistota o prenositeľnosti štúdie SPRINT.</strong> Mnohí pacienti s CKD majú diabetes, výraznú albuminúriu, glomerulové ochorenie, multimorbiditu alebo pokročilú krehkosť. Tieto skupiny neboli v rozhodujúcej štúdii zastúpené dostatočne alebo vôbec.</li>
  <li><strong>Rozdiel medzi štandardizovaným a rutinným meraním.</strong> Zavedenie štandardizovaného protokolu predlžuje návštevu a vyžaduje personálne, priestorové a organizačné podmienky.</li>
  <li><strong>Obavy z hypotenzie a pádov.</strong> Riziko je významné najmä u starších pacientov, pri autonómnej dysfunkcii, ortostatickej hypotenzii a polyfarmácii.</li>
  <li><strong>Nízky diastolický tlak.</strong> U pacienta s izolovanou systolickou hypertenziou môže ďalšie znižovanie systolického tlaku viesť k veľmi nízkemu diastolickému tlaku. Klinický význam závisí od koronárneho rizika, príznakov a celkového zdravotného stavu.</li>
  <li><strong>Terapeutická záťaž.</strong> Dosiahnutie prísneho cieľa môže vyžadovať viacero liekov, opakované kontroly, laboratórne monitorovanie a riešenie nežiaducich účinkov.</li>
  <li><strong>Rozdielne odporúčania odborných spoločností.</strong> Ako ukazuje porovnanie vyššie, KDIGO je s hranicou 120 mm Hg medzi veľkými odporúčaniami výnimkou.</li>
  <li><strong>Nediagnostikovaná alebo nedostatočne liečená rezistentná hypertenzia.</strong> Chýbať môže ambulantné monitorovanie, hodnotenie adherencie, vyšetrenie sekundárnych príčin alebo optimalizácia diuretickej liečby.</li>
</ol>

<h2>Praktický postup pri pacientovi s CKD</h2>

<p>Výsledky štúdie podporujú potrebu kvalitnejšej kontroly krvného tlaku, nie automatické predpisovanie ďalšieho antihypertenzíva pri každom rutinnom systolickom tlaku nad 120 mm Hg.</p>

<ol>
  <li><strong>Overenie spôsobu merania.</strong> Pred rozhodnutím o intenzifikácii treba tlak opakovane zmerať štandardizovaným spôsobom.</li>
  <li><strong>Meranie tlaku doma alebo ambulantné monitorovanie.</strong> Domáce meranie a 24-hodinové ambulantné monitorovanie pomáhajú odhaliť hypertenziu bieleho plášťa, maskovanú hypertenziu, nočnú hypertenziu a nadmerný pokles tlaku počas spánku.</li>
  <li><strong>Posúdenie ortostatickej reakcie.</strong> Ortostatický tlak treba hodnotiť najmä u starších pacientov, diabetikov, pacientov s autonómnou dysfunkciou, po pádoch alebo pri závratoch.</li>
  <li><strong>Určenie albuminúrie.</strong> Pomer albumínu ku kreatinínu v moči je podstatný pre odhad renálneho a kardiovaskulárneho rizika aj pre výber liečby.</li>
  <li><strong>Kontrola adherencie a liekov zvyšujúcich tlak.</strong> Treba preveriť užívanie nesteroidových antiflogistík, sympatomimetík, glukokortikoidov, niektorých imunosupresív a ďalších látok.</li>
  <li><strong>Optimalizácia nefroprotektívnej liečby.</strong> U vhodných pacientov treba posúdiť blokádu renínovo-angiotenzínového systému, inhibítor SGLT2 a pri diabetickej CKD aj ďalšie liečebné možnosti. Tieto lieky nemožno hodnotiť iba podľa ich antihypertenzívneho účinku.</li>
  <li><strong>Individualizácia cieľa.</strong> Rozhodnutie má zohľadniť vek, krehkosť, diastolický tlak, albuminúriu, ortostatické príznaky, kardiovaskulárne riziko, komorbidity, očakávaný prínos a preferencie pacienta.</li>
</ol>

<h2>Čo možno zo štúdie spoľahlivo vyvodiť</h2>

<p>Štúdia presvedčivo ukazuje, že priemerný rutinne meraný systolický tlak pod 120 mm Hg bol v analyzovanom zdravotníckom systéme zriedkavý a jeho výskyt sa po roku 2021 zvýšil iba mierne. Počet predpísaných skupín antihypertenzív sa takmer nezmenil.</p>

<p>Pacienti s tlakom 120 mm Hg alebo vyšším mali vyššie kardiovaskulárne a renálne riziko. Tento vzťah je klinicky vierohodný a zodpovedá širším poznatkom o hypertenzii pri CKD.</p>

<p>Štúdia však nedokazuje, že:</p>

<ul>
  <li>78 % pacientov bolo liečených nedostatočne,</li>
  <li>každý pacient s rutinným tlakom najmenej 120 mm Hg potrebuje intenzifikáciu liečby,</li>
  <li>dosiahnutie tlaku pod 120 mm Hg príčinne zníži riziko presne o 19 % alebo 21 %,</li>
  <li>intenzívna liečba je rovnako bezpečná vo všetkých skupinách pacientov,</li>
  <li>výsledky možno preniesť na osoby vo veku 80 rokov a viac,</li>
  <li>cieľ pod 120 mm Hg je vhodný pri neštandardizovanom meraní.</li>
</ul>

<h2>Záver</h2>

<p>Cieľový systolický krvný tlak pod 120 mm Hg odporúčaný KDIGO sa v analyzovanej americkej praxi uplatňoval len obmedzene. V roku 2024 malo priemer rutinných ambulantných meraní pod touto hranicou 21,9 % pacientov s CKD G3 až G4.</p>

<p>Najdôležitejším interpretačným obmedzením je metodický nesúlad medzi odporúčaním a analyzovanými údajmi. KDIGO definuje cieľ pomocou štandardizovaného ambulantného merania, zatiaľ čo štúdia použila rutinné hodnoty z elektronickej zdravotnej dokumentácie. Výsledok preto nemožno považovať za presné meranie skutočného dodržiavania odporúčania.</p>

<p>Klinickým posolstvom nie je bezvýhradná snaha dostať každý bežne nameraný systolický tlak pod 120 mm Hg. Podstatné je správne meranie, potvrdenie hypertenzie mimo ambulancie, posúdenie tolerancie a individuálna voľba cieľa. U vhodne vybraných pacientov môže intenzívnejšia kontrola tlaku priniesť významný kardiovaskulárny úžitok. U krehkých alebo symptomatických pacientov môže byť bezpečnejší menej prísny cieľ.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki">Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup</a></li>
  <li><a href="article.php?slug=vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia">Východisková eGFR pri biopsii obličky: ako jej výber a imputácia môžu skresliť výsledky observačných štúdií</a></li>
  <li><a href="article.php?slug=betablokatory-ckd-bez-kardiovaskularneho-ochorenia">Betablokátory pri CKD bez kardiovaskulárneho ochorenia</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Lee HH, Cho SMJ, McCarthy CP, Yoo TH, Wadhera RK, Secemsky EA, Natarajan P. Real-World Adoption of the 2021 KDIGO BP Guideline in CKD. <em>Journal of the American Society of Nephrology</em>. 2026;37(8):1764–1772. doi: 10.1681/ASN.0000001046. <a href="https://pubmed.ncbi.nlm.nih.gov/41719070/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13441074/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Sprievodná správa:</strong> Limited Adoption of KDIGO BP Target in CKD. ReachMD (autor neuvedený). <a href="https://reachmd.com/news/limited-adoption-of-kdigo-bp-target-in-ckd/2488279/" target="_blank" rel="noopener noreferrer">reachmd.com</a>.</em></small></p>

<p><small><em><strong>Odporúčanie KDIGO:</strong> Kidney Disease: Improving Global Outcomes (KDIGO) Blood Pressure Work Group. KDIGO 2021 Clinical Practice Guideline for the Management of Blood Pressure in Chronic Kidney Disease. <em>Kidney International</em>. 2021;99(3S):S1–S87. doi: 10.1016/j.kint.2020.11.003. <a href="https://pubmed.ncbi.nlm.nih.gov/33637192/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://kdigo.org/guidelines/blood-pressure-in-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></p>

<p><small><em><strong>Kritický prehľad cieľa KDIGO:</strong> Dasgupta I, Zoccali C. Is the KDIGO Systolic Blood Pressure Target &lt;120 mm Hg for Chronic Kidney Disease Appropriate in Routine Clinical Practice? <em>Hypertension</em>. 2022;79(1):4–11. doi: 10.1161/HYPERTENSIONAHA.121.18434. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8654101/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia SPRINT:</strong> SPRINT Research Group; Wright JT Jr, Williamson JD, Whelton PK, et al. A Randomized Trial of Intensive versus Standard Blood-Pressure Control. <em>New England Journal of Medicine</em>. 2015;373(22):2103–2116. doi: 10.1056/NEJMoa1511939. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4689591/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Podskupina s CKD v štúdii SPRINT:</strong> Cheung AK, Rahman M, Reboussin DM, et al. Effects of Intensive BP Control in CKD. <em>Journal of the American Society of Nephrology</em>. 2017;28(9):2812–2823. doi: 10.1681/ASN.2017020148. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5576945/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Európske odporúčania:</strong> McEvoy JW, McCarthy CP, Bruno RM, et al. 2024 ESC Guidelines for the management of elevated blood pressure and hypertension. <em>European Heart Journal</em>. 2024;45(38):3912–4018. doi: 10.1093/eurheartj/ehae178. <a href="https://pubmed.ncbi.nlm.nih.gov/39210715/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
HTML,
];

// ── Vloženie / aktualizácia ───────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cielovy_systolicky_tlak_120_ckd',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
