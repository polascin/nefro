<?php
/**
 * add_renin-aldosteron-dapagliflozin-spironolakton-hfpef_article.php
 * Odborný článok o reníne a aldosteróne ako modifikátoroch odpovede na dapagliflozín
 * a spironolaktón pri HFpEF (analýza SOGALDI-PEF, JACC Heart Fail 2026).
 * Spracovanie jedného konkrétneho zdrojového článku, doi 10.1016/j.jchf.2026.103111.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Renín, nie aldosterón: ktorý pacient s HFpEF získa z pridania spironolaktónu k dapagliflozínu',
    'slug'         => 'renin-aldosteron-dapagliflozin-spironolakton-hfpef',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Analýza SOGALDI-PEF: bazálny renín ≤ 21 mU/l označuje fenotyp sodíkového preťaženia, v ktorom kombinácia takmer zdvojnásobila pokles tlaku. Riziko hyperkaliémie však zostáva rovnaké.',
    'content'      => <<<'HTML'
<figure><a href="img/renin-aldosteron-dapagliflozin-spironolakton-hfpef.webp" rel="noopener noreferrer" target="_blank"><img src="img/renin-aldosteron-dapagliflozin-spironolakton-hfpef.webp" alt="Polopriesvitné sklené srdce a oblička spojené cievou v tme; hustý roj jantárových kryštálikov sodíka sa zhlukuje pri srdci a naľavo sa stráca do tmy" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zobrazenie konkrétneho lieku. Potlačený renín označuje tú stranu spektra, kde sodík a objem rozhodujú o hemodynamike – a kde blokáda mineralokortikoidového receptora zaberá najviac.</figcaption></figure>

<p>Mineralokortikoidové receptorové antagonisty (MRA) patria pri srdcovom zlyhávaní so zachovanou ejekčnou frakciou (HFpEF) k mála triedam, ktoré znižujú kongesciu, potrebu diuretík a krvný tlak. Nefrológ ich však predpisuje s dvoma otáznikmi: hyperkaliémia a pokles odhadovanej glomerulovej filtrácie (eGFR). Keby sa dalo dopredu povedať, u koho bude hemodynamický zisk veľký, dala by sa tá istá dávka rizika kúpiť za výrazne vyšší prínos.</p>

<p>Analýza štúdie SOGALDI-PEF, publikovaná v <em>JACC: Heart Failure</em>, ponúka na túto otázku prvú randomizovanú odpoveď v populácii HFpEF. Testovala hypotézu prenesenú z hypertenziológie: že <strong>plazmatický renín</strong> – nepriamy ukazovateľ sodíkovej avidity – predpovedá veľkosť poklesu tlaku po pridaní spironolaktónu. Odpoveď je prekvapivo čistá: renín áno, aldosterón nie.</p>

<p>Text nižšie zhŕňa, čo analýza ukázala, kde sú jej hranice a prečo je pre nefrológiu zaujímavejšia ako bežná podskupinová analýza.</p>

<h2>Čo SOGALDI-PEF je – a čo v nej nebolo</h2>

<p>SOGALDI-PEF (NCT05676684, EudraCT 2020-000973-26) je dvojcentrová, skúšajúcim iniciovaná randomizovaná prekrížená (crossover) štúdia s otvorenou liečbou a zaslepeným hodnotením ukazovateľov (dizajn PROBE), vykonaná v Porte. Zaradila 108 ambulantných pacientov vo veku ≥ 50 rokov s NYHA II–IV, ejekčnou frakciou > 40 %, štrukturálnym postihnutím srdca a zvýšenými natriuretickými peptidmi; podmienkou bola eGFR ≥ 30 ml/min/1,73 m² a kálium ≤ 5,5 mmol/l. Medián veku bol 76 rokov, 57 % tvorili ženy, 46 % malo diabetes 2. typu a 33 % eGFR pod 60 ml/min/1,73 m².</p>

<p>Dizajn je potrebné uviesť presne, lebo predlohy ho zvyknú zjednodušovať. Pôvodne išlo o <strong>tri</strong> sekvencie po 12 týždňoch – dapagliflozín, spironolaktón, a ich kombinácia – oddelené štvortýždňovým vymývacím obdobím. V júli 2023, po publikovaní štúdií EMPEROR-Preserved a DELIVER, bol protokol zmenený: rameno so samotným spironolaktónom bolo zrušené a vymývacie obdobie skrátené na jeden týždeň. Preto je počet pozorovaní pre monoterapiu spironolaktónom nízky (n = 39–41) a hlavné porovnanie znie <strong>spironolaktón/dapagliflozín verzus dapagliflozín samotný</strong>.</p>

<p>Dávka dapagliflozínu bola 10 mg denne bez úpravy. Spironolaktón sa titroval podľa eGFR a kália od 25 mg každý druhý deň po 25 mg denne; 45 % pacientov zostalo na dávke každý druhý deň a <strong>vážený medián dávky bol približne 19 mg denne</strong>. To je dôležité: ide o dávky, ktoré sa nepovažujú za natriuretické.</p>

<p>V hlavnej publikácii štúdie bola kombinácia lepšia ako samotný dapagliflozín v znížení NT-proBNP aj krvného tlaku, ale za cenu výraznejšieho poklesu eGFR a vyššieho sérového kália. Práve to je dôvod, prečo má zmysel hľadať podskupinu s najlepším pomerom prínosu a rizika.</p>

<p>Renín a aldosterón boli merané v ranných odberoch po päťminútovom ležaní, v EDTA skúmavkách, priamymi chemiluminiscenčnými imunoanalýzami, všetky vzorky v jednej dávke. Hodnoty sú k dispozícii u 106 pacientov na začiatku a u 103 na konci každej z oboch hlavných sekvencií.</p>

<h2>Dva fenotypy, ktoré sa neprekrývajú</h2>

<p>Medián bazálneho renínu bol 29,7 mU/l (25.–75. percentil 17,6–61,6). Prvá tertila – teda <strong>renín ≤ 21 mU/l</strong> – mala medián 12,4 mU/l, tretia 96,1 mU/l. Rozdiely medzi tertilami nakreslili veľmi konzistentný obraz.</p>

<div class="table-responsive" role="region" aria-label="Vybrané vstupné charakteristiky podľa tertíl plazmatického renínu v štúdii SOGALDI-PEF" tabindex="0">
<table>
<caption>Vybrané vstupné charakteristiky podľa tertíl plazmatického renínu (n = 106). Hodnoty sú priemer ± SD alebo podiel.</caption>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">T1 (≤ 21 mU/l), n = 36</th><th scope="col">T2, n = 35</th><th scope="col">T3, n = 35</th><th scope="col">P pre trend</th></tr>
</thead>
<tbody>
<tr><th scope="row">Systolický TK (mm Hg)</th><td>139,7 ± 17,2</td><td>132,2 ± 18,8</td><td>128,1 ± 19,6</td><td>0,030</td></tr>
<tr><th scope="row">Diastolický TK (mm Hg)</th><td>76,3 ± 8,8</td><td>73,8 ± 11,6</td><td>69,3 ± 10,2</td><td>0,017</td></tr>
<tr><th scope="row">TK &gt; 130/80 mm Hg</th><td>75 %</td><td>46 %</td><td>37 %</td><td>0,004</td></tr>
<tr><th scope="row">Periférny edém</th><td>81 %</td><td>80 %</td><td>57 %</td><td>0,042</td></tr>
<tr><th scope="row">Sérový sodík (mmol/l)</th><td>140,8 ± 2,2</td><td>139,4 ± 2,5</td><td>138,7 ± 3,8</td><td>0,008</td></tr>
<tr><th scope="row">Laterálne E/e′</th><td>12,6 ± 6,2</td><td>11,6 ± 4,2</td><td>9,7 ± 3,5</td><td>0,037</td></tr>
<tr><th scope="row">Rýchlosť pulzovej vlny (m/s)</th><td>11,9 ± 1,7</td><td>10,9 ± 1,5</td><td>11,2 ± 1,4</td><td>0,019</td></tr>
<tr><th scope="row">eGFR (ml/min/1,73 m²)</th><td>74,1 ± 20,3</td><td>70,2 ± 22,4</td><td>63,9 ± 22,6</td><td>0,14</td></tr>
<tr><th scope="row">Urea (mg/dl)</th><td>45,0 ± 16,7</td><td>52,3 ± 27,6</td><td>63,5 ± 39,5</td><td>0,032</td></tr>
<tr><th scope="row">Kyselina močová (mg/dl)</th><td>5,4 ± 1,7</td><td>6,0 ± 2,1</td><td>6,9 ± 2,2</td><td>0,009</td></tr>
<tr><th scope="row">Sodík v moči (mmol/l)</th><td>82,1 ± 32,3</td><td>85,2 ± 41,2</td><td>62,2 ± 29,9</td><td>0,022</td></tr>
<tr><th scope="row">Plazmatický aldosterón (pg/ml, medián)</th><td>51,2</td><td>66,5</td><td>94,4</td><td>0,19</td></tr>
</tbody>
</table>
</div>

<p>Pacient s nízkym renínom je teda hypertenznejší, viac opuchnutý, má vyšší sérový sodík, tuhšie cievy a horšiu diastolickú funkciu – a napriek tomu <strong>lepšiu, nie horšiu obličkovú funkciu</strong>. Rozdiel v eGFR nedosiahol štatistickú významnosť (P = 0,14), ale urea aj kyselina močová boli u nízkeho renínu jednoznačne nižšie, čo rovnaký smer podporuje.</p>

<p>Vysoký aldosterón (tretia tertila, ≥ 98 pg/ml; medián celej kohorty 68,1 pg/ml) kreslí iný obraz: nižšia eGFR, nižší sérový sodík, nižšia exkrécia sodíka a vyššia exkrécia kália v moči, častejšia hospitalizácia pre srdcové zlyhávanie v predchádzajúcom roku – ale <strong>bez gradientu v krvnom tlaku, echokardiografických ukazovateľoch, rýchlosti pulzovej vlny či periférnom edéme</strong>.</p>

<p>Oba hormóny pritom spolu prakticky nesúviseli: Spearmanovo <em>rho</em> = 0,15, P = 0,12. Nejde teda o „slabú nekoreláciu“, ale o <strong>absenciu štatisticky významnej korelácie</strong> – dva čiastočne nezávislé patofyziologické rozmery v tej istej populácii. Vo viacrozmernom modeli boli s nízkym renínom spojené TK &gt; 130/80 mm Hg, vyšší sérový sodík, vyššie laterálne E/e′ a nižšia kyselina močová (plocha pod krivkou 0,68) – teda skromná, nie však zanedbateľná diskriminácia.</p>

<h2>Spätná väzba RAAS: koľko presne pridá blokáda receptora</h2>

<p>Samotný dapagliflozín zvýšil renín aj aldosterón len mierne (pomer geometrických priemerov oproti východisku 1,32; 95 % IS 1,07–1,62 pre renín a 1,18; 95 % IS 1,07–1,29 pre aldosterón). Sekvencie so spironolaktónom vyvolali podstatne silnejšiu odpoveď.</p>

<div class="table-responsive" role="region" aria-label="Vplyv liečebných sekvencií na plazmatický renín, aldosterón a ich pomer" tabindex="0">
<table>
<caption>Pomer geometrických priemerov (95 % interval spoľahlivosti) oproti samotnému dapagliflozínu. ARR = pomer aldosterón/renín.</caption>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">Spironolaktón/dapagliflozín vs. dapagliflozín</th><th scope="col">Spironolaktón samotný vs. dapagliflozín</th></tr>
</thead>
<tbody>
<tr><th scope="row">Renín</th><td>2,65 (2,06–3,41)</td><td>2,14 (1,41–3,24)</td></tr>
<tr><th scope="row">Aldosterón</th><td>1,77 (1,56–2,02)</td><td>1,65 (1,29–2,09)</td></tr>
<tr><th scope="row">ARR</th><td>0,67 (0,52–0,86)</td><td>0,79 (0,52–1,21)</td></tr>
</tbody>
</table>
</div>

<p>Kombinácia teda zvýšila renín viac než 2,5-násobne a aldosterón viac než 1,5-násobne oproti dapagliflozínu – očakávaná protiregulačná odpoveď na blokádu mineralokortikoidového receptora. Keďže renín stúpol viac ako aldosterón, pomer ARR pri kombinácii klesol. Praktický dôsledok: <strong>u pacienta užívajúceho MRA stráca meranie renínu, aldosterónu aj ARR diagnostickú výpovednú hodnotu</strong> – vrátane skríningu primárneho hyperaldosteronizmu.</p>

<h2>Renín modifikuje pokles tlaku, a to výrazne</h2>

<p>Hlavným ukazovateľom tejto analýzy bola interakcia liečba × renín pre systolický tlak. Vyšla jednoznačne.</p>

<div class="table-responsive" role="region" aria-label="Rozdiel v krvnom tlaku medzi kombináciou spironolaktón/dapagliflozín a samotným dapagliflozínom podľa tertíl renínu" tabindex="0">
<table>
<caption>Rozdiel (mm Hg; 95 % interval spoľahlivosti) kombinácia spironolaktón/dapagliflozín verzus dapagliflozín samotný. Záporná hodnota znamená väčší pokles tlaku pri kombinácii.</caption>
<thead>
<tr><th scope="col">Tertila renínu</th><th scope="col">Systolický TK</th><th scope="col">Diastolický TK</th></tr>
</thead>
<tbody>
<tr><th scope="row">T1 (≤ 21 mU/l)</th><td>−10,9 (−16,4 až −5,4)</td><td>−6,3 (−10,2 až −2,4)</td></tr>
<tr><th scope="row">T2 (~30 mU/l)</th><td>−5,6 (−11,3 až 0,02)</td><td>0,1 (−3,8 až 4,2)</td></tr>
<tr><th scope="row">T3 (~96 mU/l)</th><td>1,5 (−4,1 až 7,0)</td><td>0,4 (−3,5 až 4,4)</td></tr>
<tr><th scope="row">P pre trend interakcie</th><td>0,007</td><td>0,006</td></tr>
</tbody>
</table>
</div>

<p>Pri nízkom reníne pridanie spironolaktónu k dapagliflozínu takmer zdvojnásobilo pokles tlaku: samotný dapagliflozín znížil systolický tlak o 12,3 mm Hg oproti východisku, kombinácia o 23,3 mm Hg. Pri vyššom reníne kombinácia tlak významne neznižovala vôbec. Rovnaký vzorec sa zopakoval pri diastolickom tlaku.</p>

<p>Prvá námietka, ktorá napadne – regresia k priemeru, keďže skupina T1 mala vyšší vstupný tlak – autorov neobišla a nevysvetľuje nález. Samotný dapagliflozín v tejto skupine tlak už znížil výrazne; až <em>prídavok</em> spironolaktónu k tomuto už zníženému tlaku priniesol ďalších ~11 mm Hg. Interakcia bola navyše významná aj pri reníne ako spojitej premennej a zachovala sa bez ohľadu na prítomnosť hypertenzie či počet antihypertenzív.</p>

<p>Zaujímavý mechanistický detail: pokles tlaku nesprevádzalo zvýšenie exkrécie sodíka v moči. Autori to vysvetľujú skôr zvýšením objemu moču než natriurézou – čomu zodpovedá aj použitá dávka spironolaktónu pod 20 mg denne, ktorá nie je natriuretická.</p>

<h2>Čo treba čítať opatrnejšie: echokardiografia a cievna tuhosť</h2>

<p>Tu je potrebné formulovať presne, lebo rozdiel je ľahké prehliadnuť. Laterálne E/e′ sa pri nízkom reníne zlepšilo o 1,6 jednotky – ale <strong>rovnako pri samotnom dapagliflozíne aj pri kombinácii</strong>; rozdiel medzi nimi bol presne nulový (0,0; 95 % IS −1,3 až 1,3). Interakcia liečba × renín bola významná (P = 0,013) preto, že pri vyšších tertilách sa nezlepšilo nič – nie preto, že by kombinácia prekonala monoterapiu.</p>

<p>Pri rýchlosti pulzovej vlny bol rozdiel v prospech kombinácie malý, ale prítomný (−0,3 m/s; 95 % IS −0,6 až −0,1 pri T1), s interakciou na hranici významnosti (P = 0,063). Podobne sa pri nízkom reníne viac zmenšoval priemer ľavej predsiene (P = 0,027).</p>

<p>Správne zhrnutie teda znie: <strong>fenotyp nízkeho renínu odpovedá lepšie na liečbu ako celok</strong>, pričom jednoznačný prírastok samotného spironolaktónu nad dapagliflozín je doložený pre krvný tlak, nie pre diastolické ukazovatele.</p>

<h2>Čo renín nemodifikoval: NT-proBNP, eGFR a kálium</h2>

<p>Renín <strong>nemodifikoval</strong> zmenu NT-proBNP (P pre trend 0,25). Autori to pripisujú malému celkovému poklesu NT-proBNP (približne 11 %) a vysokému podielu fibrilácie predsiení v kohorte, ktorá hodnoty natriuretických peptidov zásadne ovplyvňuje.</p>

<p>Bezpečnostné ukazovatele renín takisto nemodifikoval, a to je nález, ktorý má pre nefrológa najväčší praktický dosah:</p>

<ul>
  <li><strong>eGFR</strong> (kombinácia vs. dapagliflozín): −7,3 ml/min/1,73 m² pri T1, −5,2 pri T2, −6,4 pri T3; P pre trend 0,72.</li>
  <li><strong>Sérové kálium</strong> (kombinácia vs. dapagliflozín): +0,4 mmol/l pri T1, +0,3 pri T2, +0,3 pri T3; P pre trend 0,74.</li>
</ul>

<p>Inými slovami: <strong>prínos sa koncentruje do podskupiny s nízkym renínom, riziko sa rozprestiera rovnomerne.</strong> Práve táto asymetria je dôvod, prečo by mal renín vôbec niekoho zaujímať. Najväčší absolútny pokles eGFR nastal zhodou okolností v skupine T1, pravdepodobne preto, že tam bol najvyšší východiskový filtrát aj najväčší pokles tlaku – krátkodobé zmeny eGFR sú prevažne hemodynamické.</p>

<h2>Aldosterón: marker porúch hospodárenia so sodíkom, nie prediktor odpovede</h2>

<p>Bazálny aldosterón ani ARR významne nemodifikovali účinok žiadnej sekvencie na krvný tlak, NT-proBNP, echokardiografické ukazovatele, rýchlosť pulzovej vlny ani sérové kálium (všetky P pre trend &gt; 0,10; pre systolický tlak 0,062, pre diastolický 0,085). ARR sa správal podobne ako renín, čo je očakávané, keďže renín je jeho dominantným určovateľom pri absencii gradientu aldosterónu.</p>

<p>Autori na to ponúkajú biologicky vierohodné vysvetlenie. Starnutie posúva vnútrobunkový redoxný stav, zvyšuje tvorbu reaktívnych foriem kyslíka a inhibuje 11β-hydroxysteroiddehydrogenázu typu 2; mineralokortikoidový receptor je potom vystavený kortizolu ako agonistovi a jeho expresia stúpa. V populácii s mediánom veku 76 rokov tak môže byť receptor aktivovaný aj pri normálnych hladinách aldosterónu – a koncentrácia samotného hormónu prestáva byť informatívna.</p>

<h2>Zasadenie do existujúcich dôkazov</h2>

<p>Nález nie je izolovaný. V štúdii PATHWAY-2 pri rezistentnej hypertenzii bol spironolaktón najúčinnejším liekom a pokles systolického tlaku bol výrazne väčší na dolnom konci rozdelenia renínu; medián bazálneho renínu bol tam 34 mU/l, teda blízko hodnote v SOGALDI-PEF. V štúdii HOMAGE u osôb s rizikom vzniku srdcového zlyhávania znížil spironolaktón systolický tlak celkovo asi o 10 mm Hg, pričom pri nízkom reníne presahoval pokles 15 mm Hg. Priame porovnanie absolútnych hodnôt renínu medzi štúdiami však nie je možné: HOMAGE používal platformu Olink, PATHWAY-2 aj SOGALDI-PEF priamu koncentráciu renínu.</p>

<p>Spoločný záver naprieč týmito populáciami znie, že <strong>sodíková retencia je prierezovým patofyziologickým činiteľom</strong> – od rezistentnej hypertenzie cez rizikové stavy až po manifestné HFpEF – a že renín ju zachytáva lepšie než aldosterón.</p>

<h2>Čo z toho vyplýva pre nefrologickú prax</h2>

<ol>
  <li><strong>Výber pacienta.</strong> U pacienta s HFpEF, pretrvávajúcou hypertenziou a klinickými známkami objemového preťaženia, ktorý už užíva inhibítor SGLT2, je pridanie MRA hemodynamicky najvýnosnejšie práve vtedy, keď je renín nízky. Ak renín k dispozícii nie je, klinický obraz z tabuľky vyššie – vyšší tlak, periférny edém, vyšší-normálny sérový sodík – ukazuje rovnakým smerom.</li>
  <li><strong>Načasovanie odberu.</strong> Renín má zmysel merať <em>pred</em> nasadením MRA. Po nasadení ho blokáda receptora zvýši zhruba 2,5-násobne a hodnota už nehovorí o fenotype pacienta, ale o účinku lieku.</li>
  <li><strong>Monitorovanie sa neuvoľňuje.</strong> Nízky renín nepredpovedá menšie riziko hyperkaliémie ani menší pokles eGFR – vzostup kália o ~0,4 mmol/l a pokles eGFR o ~5–7 ml/min/1,73 m² platia naprieč tertilami. Kontrola kália a kreatinínu o 1–2 týždne po nasadení a po každej zmene dávky zostáva povinná.</li>
  <li><strong>Očakávanie úbytku filtrátu.</strong> Iniciálny pokles eGFR po pridaní MRA k inhibítoru SGLT2 je u pacienta s nízkym renínom spravidla väčší, pretože má vyšší východiskový filtrát a väčší pokles tlaku. Ide prevažne o hemodynamickú zmenu, nie o štrukturálne poškodenie – rozlíšenie od skutočného zhoršenia je ale klinickým úsudkom, nie automatizmom.</li>
  <li><strong>Fenotypizácia namiesto plošnosti.</strong> Nezávislosť renínovej a aldosterónovej osi hovorí, že kardiorenálny fenotyp nie je jednorozmerný. „Vysoký aldosterón“ v tejto kohorte označoval pacienta s horšou obličkovou funkciou a poruchou hospodárenia so sodíkom, nie pacienta s väčším prínosom z MRA.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Štúdia nebola dimenzovaná na testovanie interakcií.</strong> Ide o prieskumnú analýzu bez korekcie na mnohonásobné testovanie, pri 106 pacientoch a asi 35 na tertilu. Konzistentnosť nálezu pre systolický aj diastolický tlak a zhoda s PATHWAY-2 a HOMAGE sú argumentom pre vierohodnosť, nie dôkazom.</li>
  <li><strong>Odbery prebehli bez vysadenia liečby ovplyvňujúcej RAAS</strong> – inhibítorov ACE a sartanov užívalo 60–72 % pacientov, diuretiká dve tretiny, betablokátory 70 %. To sťažuje fyziologickú interpretáciu, zároveň však robí nález priamo prenositeľným do bežnej ambulancie.</li>
  <li><strong>Chýbajú tvrdé ukazovatele.</strong> Štúdia nebola navrhnutá na hodnotenie hospitalizácií ani mortality; o prognostickom význame renínu nehovorí nič.</li>
  <li><strong>Rameno so samotným spironolaktónom bolo v priebehu štúdie zrušené</strong>, jeho výsledky stoja na 39–41 pozorovaniach a treba ich čítať ako orientačné. Pri laterálnom E/e′ dokonca vyšli v opačnom smere, čo pri takejto veľkosti vzorky nemožno interpretovať.</li>
  <li><strong>Hraničná prenositeľnosť medzných hodnôt.</strong> Hranica 21 mU/l platí pre použitú súpravu (priama chemiluminiscenčná imunoanalýza) a pre túto populáciu. Laboratóriá sa v metódach aj jednotkách líšia a výsledky nie sú bez prepočtu zameniteľné.</li>
  <li><strong>Populácia bola staršia</strong> (medián 76 rokov) a s vysokým podielom fibrilácie predsiení, čo obmedzuje zovšeobecnenie na mladších pacientov s HFpEF.</li>
  <li><strong>Financovanie.</strong> Štúdiu podporila spoločnosť AstraZeneca (grant ESR-20-20771) a portugalská FCT; išlo o štúdiu iniciovanú a vedenú skúšajúcimi.</li>
</ul>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza odborné posúdenie konkrétneho prípadu ani platné súhrny charakteristických vlastností liekov. Spironolaktón ani dapagliflozín nemajú na Slovensku registrovanú indikáciu „HFpEF“ v znení použitom v tejto štúdii; o liečbe rozhoduje ošetrujúci lekár podľa platných odporúčaní a registračného stavu.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Ferreira JP, Marques P, Neves JS, Leite AR, Teixeira C, Saraiva F, Sharma A, Zannad F, Pimenta J, Fontes-Carvalho R, Leite-Moreira A, Vasques-Nóvoa F. Renin, Aldosterone, and Treatment Response to Dapagliflozin, Spironolactone, and Their Combination: An Analysis From SOGALDI-PEF. <em>JACC Heart Fail.</em> 2026;14(9):103111. doi: <a href="https://doi.org/10.1016/j.jchf.2026.103111" target="_blank" rel="noopener noreferrer">10.1016/j.jchf.2026.103111</a>. PMID: 42201301.</li>
  <li>Ferreira JP, Vasques-Nóvoa F, Saraiva F, et al. Sodium-Glucose Cotransporter 2 Inhibitor With and Without an Aldosterone Antagonist for Heart Failure With Preserved Ejection Fraction: The SOGALDI-PEF Trial. <em>J Am Coll Cardiol.</em> 2025;86(5):320–333. doi: <a href="https://doi.org/10.1016/j.jacc.2025.05.033" target="_blank" rel="noopener noreferrer">10.1016/j.jacc.2025.05.033</a>.</li>
  <li>Ferreira JP, Vasques-Nóvoa F, Saraiva F, et al. SGLT2 inhibitor with and without ALDosterone AntagonIst for heart failure with preserved ejection fraction: Design paper. <em>ESC Heart Fail.</em> 2025;12(4):3134–3144. doi: <a href="https://doi.org/10.1002/ehf2.15294" target="_blank" rel="noopener noreferrer">10.1002/ehf2.15294</a>. PMID: 40388563, PMC12287783.</li>
  <li>Williams B, MacDonald TM, Morant S, Webb DJ, Sever P, McInnes G, Ford I, Cruickshank JK, et al. Spironolactone versus placebo, bisoprolol, and doxazosin to determine the optimal treatment for drug-resistant hypertension (PATHWAY-2): a randomised, double-blind, crossover trial. <em>Lancet.</em> 2015;386(10008):2059–2068. doi: <a href="https://doi.org/10.1016/S0140-6736(15)00257-3" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(15)00257-3</a>.</li>
  <li>Williams B, MacDonald TM, Morant SV, Webb DJ, Sever P, McInnes GT, Ford I, Cruickshank JK, et al. Endocrine and haemodynamic changes in resistant hypertension, and blood pressure responses to spironolactone or amiloride: the PATHWAY-2 mechanisms substudies. <em>Lancet Diabetes Endocrinol.</em> 2018;6(6):464–475. doi: <a href="https://doi.org/10.1016/S2213-8587(18)30071-8" target="_blank" rel="noopener noreferrer">10.1016/S2213-8587(18)30071-8</a>. PMID: 29655877, PMC5966620.</li>
  <li>Ferreira JP, Collier T, Clark AL, et al. Spironolactone effect on the blood pressure of patients at risk of developing heart failure: an analysis from the HOMAGE trial. <em>Eur Heart J Cardiovasc Pharmacother.</em> 2022;8(2):149–156. doi: <a href="https://doi.org/10.1093/ehjcvp/pvab031" target="_blank" rel="noopener noreferrer">10.1093/ehjcvp/pvab031</a>.</li>
  <li>Pitt B, Pfeffer MA, Assmann SF, et al. Spironolactone for Heart Failure with Preserved Ejection Fraction (TOPCAT). <em>N Engl J Med.</em> 2014;370(15):1383–1392. doi: <a href="https://doi.org/10.1056/NEJMoa1313731" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1313731</a>.</li>
  <li>Solomon SD, McMurray JJV, Vaduganathan M, et al. Finerenone in Heart Failure with Mildly Reduced or Preserved Ejection Fraction (FINEARTS-HF). <em>N Engl J Med.</em> 2024;391(16):1475–1485. doi: <a href="https://doi.org/10.1056/NEJMoa2407107" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2407107</a>.</li>
  <li>ClinicalTrials.gov. Dapagliflozin With or Without Spironolactone for HFpEF (SOGALDI-PEF), <a href="https://clinicaltrials.gov/study/NCT05676684" target="_blank" rel="noopener noreferrer">NCT05676684</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Všetky číselné údaje v texte pochádzajú z plného znenia primárnej publikácie (zdroj 1) vrátane tabuliek 1–3; registračné údaje štúdie boli overené priamo v API ClinicalTrials.gov (108 randomizovaných, dokončenie november 2024) a parametre dizajnu v protokolovej publikácii (zdroj 3). Bibliografické údaje všetkých citácií – úplné autorské zoznamy, ročníky, čísla a strany – boli overené cez PubMed, Crossref a Europe PMC k 17. októbru 2026.</p>

<p>Vlastným prínosom tohto spracovania je: doplnenie dizajnových skutočností, ktoré bývajú vynechávané (zrušenie ramena so samotným spironolaktónom, skrátenie vymývacieho obdobia, nenatriuretická dávka spironolaktónu okolo 19 mg denne); oddelenie nálezu pre krvný tlak od nálezu pre laterálne E/e′, kde kombinácia nad dapagliflozín nepridala nič (rozdiel 0,0) a interakcia vznikla rozdielom medzi tertilami, nie medzi liečbami; zdôraznenie asymetrie medzi prínosom a rizikom (renín modifikuje tlak, nie kálium a eGFR), ktorá je vlastným dôvodom klinickej použiteľnosti; a praktické odporúčanie merať renín pred nasadením MRA. V primárnej publikácii je v odseku o prediktoroch nízkeho renínu preklep „T1; ≥ 21 mU/L“; z definície tertíl v celom zvyšku práce ide o hodnotu ≤ 21 mU/l, a tak je uvedená aj tu.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=nekontrolovana-rezistentna-hypertenzia-aldosteronova-os">Nekontrolovaná a rezistentná hypertenzia: aldosterónová os</a></li>
  <li><a href="article.php?slug=ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register">CKD a vznik srdcového zlyhávania so zachovanou ejekčnou frakciou</a></li>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia RAASi a MRA pri hyperkaliémii u pacientov s CKD a srdcovým zlyhávaním</a></li>
  <li><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Hyperkaliémia pri RAASi a MRA: viazače draslíka a príjem sodíka</a></li>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie pri CKD: kontroverzie KDIGO 2026</a></li>
  <li><a href="article.php?slug=sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky">Inhibítory SGLT2: rozdiely v schválených indikáciách pre srdce a obličky</a></li>
  <li><a href="article.php?slug=diurnalna-exkrecia-sodika-nocna-hypertenzia-casovanie-soli">Diurnálna exkrécia sodíka a nočná hypertenzia</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_renin_aldosteron_sogaldi_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_renin_aldosteron_sogaldi_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_renin_aldosteron_sogaldi_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_renin_aldosteron_sogaldi_2026 migration error: ' . $e->getMessage());
    }
}

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
