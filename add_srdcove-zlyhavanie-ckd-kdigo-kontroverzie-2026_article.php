<?php
/**
 * add_srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026_article.php
 * Odborný článok: závery KDIGO Controversies Conference o srdcovom zlyhávaní
 * a CKD (marec 2024; spoločná publikácia 2026 v Kidney International a JACC HF).
 *
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026_article.php"
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

$articles = [];

$articles[] = [
    'title'        => 'Srdcové zlyhávanie a CKD: závery KDIGO konferencie o obojsmernom zaťažení, GDMT a koordinovanej starostlivosti',
    'slug'         => 'srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Závery konferencie KDIGO 2024 o srdcovom zlyhávaní a CKD: obojsmerné zaťaženie, GDMT s duálnym prínosom a hemodynamický pokles eGFR, ktorý sám osebe nie je dôvodom na vysadenie liečby.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Konferencia KDIGO o chorobe obličiek a srdcovom zlyhávaní (marec 2024) bola v roku 2026 uverejnená súčasne v Kidney International a v JACC: Heart Failure. Správa nie je novým usmernením KDIGO, ale konsenzuálnym prehľadom dôkazov, diagnostických dilem a praktických princípov liečby tam, kde sa srdce a obličky stretávajú. Tento článok je slovenské spracovanie tejto správy pre nefrologickú prax.</em></p>

<p>Srdcové zlyhávanie (HF) a chronická choroba obličiek (CKD) sa často vyskytujú spolu, zdieľajú rizikové faktory aj hemodynamické, neurohormonálne a zápalové mechanizmy a navzájom zhoršujú prognózu. Podľa konferenčnej správy má približne <strong>10–30 % pacientov s CKD srdcové zlyhávanie</strong> a približne <strong>30–60 % pacientov so srdcovým zlyhávaním má CKD</strong>. Súčasný výskyt oboch stavov je spojený s vyšším rizikom straty funkcie obličiek, hospitalizácií aj úmrtia.</p>

<p>Klinický odkaz je priamy: izolovaný manažment jedného orgánu nestačí. Liečba má byť <strong>integrovaná, individualizovaná a koordinovaná</strong>, s meraním eGFR aj pomeru albumín/kreatinín v moči (UACR), s triedami liekov, ktoré v štúdiách prinášajú kardiálny aj renálny prínos, a s tým, že malý hemodynamický pokles eGFR po začatí liečby podľa odporúčaní (GDMT) spravidla nie je dôvodom na jej reflexné vysadenie.</p>

<h2>Obojsmerné zaťaženie: CKD zvyšuje riziko HF a HF zhoršuje CKD</h2>

<p>Vzťah nie je jednosmerný. Nižšia eGFR je silným rizikovým faktorom nepriaznivých výsledkov pri HF so zníženou aj so zachovanou ejekčnou frakciou (HFrEF aj HFpEF). Albuminúria nezávisle predikuje vznik HFpEF a horšie výsledky pri už prítomnom zlyhávaní. Závažnosť CKD je so srdcovým zlyhávaním asociovaná stupňovito – a naopak.</p>

<p>Presné čísla prináša prospektívna kohorta CRIC (Chronic Renal Insufficiency Cohort) u 3 791 dospelých s CKD v USA. Hrubá miera hospitalizácií pre HF bola <strong>5,8 na 100 osoborokov</strong>. Upravené miery hospitalizácie rástli s klesajúcou eGFR aj s vyššou albuminúriou. Hospitalizácia pre HF v prvých dvoch rokoch sledovania bola spojená s následnou progresiou CKD aj s úmrtím z akejkoľvek príčiny:</p>

<div class="table-responsive" role="region" aria-label="Hospitalizácie pre srdcové zlyhávanie v kohorte CRIC" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Údaj zo štúdie CRIC</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Miera hospitalizácií pre HF</th>
      <td>5,8 na 100 osoborokov</td>
    </tr>
    <tr>
      <th scope="row">Upravený pomer mier (eGFR 30–44 vs. &gt;45 ml/min/1,73 m<sup>2</sup>)</th>
      <td>1,7</td>
    </tr>
    <tr>
      <th scope="row">Upravený pomer mier (eGFR &lt;30 vs. &gt;45 ml/min/1,73 m<sup>2</sup>)</th>
      <td>2,2</td>
    </tr>
    <tr>
      <th scope="row">Upravený pomer mier (UACR 30–299 vs. &lt;30 mg/g)</th>
      <td>1,9</td>
    </tr>
    <tr>
      <th scope="row">Upravený pomer mier (UACR ≥300 vs. &lt;30 mg/g)</th>
      <td>2,6</td>
    </tr>
    <tr>
      <th scope="row">Rehospitalizácia pre HF do 30 dní</th>
      <td>20,6 %</td>
    </tr>
    <tr>
      <th scope="row">Progresia CKD po 1 / ≥2 hospitalizáciách pre HF</th>
      <td>HR 1,93 (95 % CI 1,40–2,67) / HR 2,14 (1,30–3,54)</td>
    </tr>
    <tr>
      <th scope="row">Úmrtie z akejkoľvek príčiny po 1 / ≥2 hospitalizáciách</th>
      <td>HR 2,20 (1,71–2,84) / HR 3,06 (2,23–4,18)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Ide o <strong>asociácie z observačnej kohorty</strong>, nie o dôkaz, že hospitalizácia pre HF kauzálne „spôsobuje“ progresiu CKD. Klinický význam je však jasný: pri CKD treba aktívne hľadať riziko a prejavy HF a pri HF treba systematicky sledovať obličky. Súhrn „približne dvoj- až trojnásobné riziko“ zhruba zodpovedá týmto pomerom rizika, ale v texte je presnejšie uvádzať konkrétne HR.</p>

<p>Patofyziológia ostáva čiastočne otvorená. Konferencia pripomína hypotézu „spoločnej pôdy“: obezita, diabetes a hypertenzia vedú k zápalu, endotelovej dysfunkcii, neurohormonálnej aktivácii a hemodynamickému stresu v srdci aj v obličkách. Pri HF sa na poklese GFR podieľajú zmeny krvného tlaku, znížený srdcový index aj zvýšený centrálny venózny tlak; relatívny prínos týchto zložiek nie je úplne objasnený. Predchádzajúce klasifikácie kardiorenálneho syndrómu sa sústreďovali najmä na HFrEF a podceňovali čoraz častejší fenotyp HFpEF.</p>

<h2>Dva rámce štádií: HF A–D nie sú totožné s CKM 0–4</h2>

<p>V podkladoch sa často miešajú dva rôzne systémy. Pre prax ich treba držať oddelene.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie štádií srdcového zlyhávania a CKM syndrómu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Rámec</th>
      <th scope="col">Čo opisuje</th>
      <th scope="col">Kde je CKD</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Štádiá HF A–D (univerzálna definícia HF)</th>
      <td>Kontinuum od rizika cez preklinické štrukturálne zmeny po symptomatické a pokročilé zlyhávanie</td>
      <td>Konferencia navrhuje zaradiť zníženú eGFR (&lt;60 ml/min/1,73 m<sup>2</sup>) aj UACR &gt;30 mg/g do <strong>štádia A (riziko HF)</strong>, hoci CKD v pôvodnom texte univerzálnej definície nie je výslovne vypísaná</td>
    </tr>
    <tr>
      <th scope="row">Štádiá CKM 0–4 (AHA 2023)</th>
      <td>Kardiovaskulárno-obličkovo-metabolické kontinuum od absencie rizika po klinické kardiovaskulárne ochorenie</td>
      <td>CKD zvyčajne patrí do <strong>štádia 2</strong> (metabolické rizikové faktory a/alebo CKD); veľmi vysoké renálne riziko môže zodpovedať <strong>štádiu 3</strong> (subklinické KVO / ekvivalent)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Ani jeden rámec nenahrádza etiologickú diagnostiku CKD podľa KDIGO ani formálnu kardiologickú diagnózu HF. Sú to nástroje na <strong>stratifikáciu rizika a včasnú intervenciu</strong>. „Preklinické“ tu znamená riziko a podklady (štruktúra, biomarkery), nie definitívnu anatomickú diagnózu.</p>

<p>Pri vyšetrení pre HF konferencia zdôrazňuje súčasné meranie <strong>eGFR a UACR</strong> popri natriuretických peptidoch. UACR je pri HF častá, súvisí so závažnosťou, hospitalizáciami, AKI aj mortalitou a v niektorých údajoch má prediktívnu hodnotu porovnateľnú s BNP. Napriek tomu sa UACR v rizikových populáciách meria málo: v laboratórnej analýze v USA malo UACR len približne 20 % tých, u ktorých sa vôbec testovalo. Kalkulačka PREVENT (AHA) zahŕňa eGFR v základnom modeli a UACR aj HbA1c ako doplnkové premenné – jej používanie môže zvýšiť záujem o obličkové markery aj mimo nefrológie.</p>

<h2>Diagnostické dilemy: kreatinín, natriuretické peptidy a kongescia</h2>

<p>HF je klinický syndróm so súčasnými alebo predchádzajúcimi príznakmi a známkami spôsobenými štrukturálnou alebo funkčnou srdcovou abnormalitou, potvrdený natriuretickými peptidmi alebo objektívnym dôkazom kongescie. Pri CKD sa príznaky prekrývajú s retenciou tekutín z obličiek. Ortodopnoe, paroxyzmálna nočná dyspnoe, zvýšená náplň krčných žíl, tretia ozva a kardiomegália svedčia skôr pre HF, ale nie sú spoľahlivo špecifické.</p>

<p><strong>Natriuretické peptidy</strong> sú pri CKD často vyššie pre znížený renálny klírens a korelujú so závažnosťou CKD aj s horšou prognózou. Naopak pri obezite a často aj pri HFpEF bývajú nižšie. Všeobecné prahy (ambulancia: BNP ≥35 pg/ml, NT-proBNP ≥125 pg/ml; akútny stav: BNP ≥100 pg/ml, NT-proBNP ≥300 pg/ml) <strong>nie sú CKD-špecifické</strong>. Konferencia preto žiada prahy prispôsobené CKD. Prakticky: vyššia hodnota diagnózu HF skôr podporuje, <strong>normálna hodnota ju pomáha vylúčiť</strong>. Pri G4–G5 a u dialyzovaných sú užitočné aj iné dôkazy zvýšených plniacich tlakov (echokardiografia, v vybraných situáciách pravostranná katetrizácia). Zobrazovanie u hemodialyzovaných treba podľa možnosti plánovať na deň bez dialýzy. Ľavokomorová hypertrofia je pri pokročilej CKD častá a sama osebe HF nediagnostikuje.</p>

<p>Vzostup kreatinínu pri akútne dekompenzovanom HF môže znamenať intrinsic poškodenie obličiek, ale aj primeraný hemodynamický posun pri účinnej dekongescii. V post-hoc analýze štúdie DOSE zhoršenie kreatinínu nebolo spojené s horšími výsledkami; v inej práci bol vzostup kreatinínu spojený s lepším prežívaním. Konferencia preto uvádza, že <strong>definície AKI odvodené od kreatinínu nemusia pri HF a začatí GDMT platiť rovnako</strong> ako pri iných stavoch. Liečba má smerovať na symptómy, objemový stav a hemodynamiku – nie na izolované číslo kreatinínu.</p>

<h2>GDMT s duálnym prínosom: v štúdiách a v odporúčaných indikáciách</h2>

<p>Terapeutické spektrum HF a CKD sa zbieha. SGLT2 inhibítory, inhibítory RAAS a novšie aj nesteroidné antagonisty mineralokortikoidového receptora (nsMRA, napr. finerenón) a agonisty receptora GLP-1 môžu v príslušných populáciách zlepšiť kardiovaskulárne aj obličkové výsledky. Dôkazy pri pokročilej CKD, najmä G5 a G5D, ostávajú obmedzené – tieto pacienti sú z randomizovaných štúdií často vylúčení.</p>

<p>Prínos treba viazať na indikačné populácie, nie prezentovať ako univerzálnu „dvojitú ochranu“ u každého:</p>

<ul>
  <li><strong>SGLT2 inhibítory</strong> sú podľa KDIGO 2024 základom nefroprotekcie pri CKD s diabetes mellitus 2. typu aj bez neho (pri splnení prahov eGFR a albuminúrie). Súčasne sú súčasťou GDMT HFrEF aj HFpEF. Konferenčný rámec počíta s použitím spravidla pri eGFR nad približne 20 ml/min/1,73 m<sup>2</sup>.</li>
  <li><strong>ACEi/ARB</strong> ostávajú základom pri CKD s albuminúriou. KDIGO odporúča v liečbe pokračovať aj vtedy, keď eGFR klesne pod 30 ml/min/1,73 m<sup>2</sup>, ak je to klinicky únosné. ESC pri HF uvádza pokračovanie v RAAS inhibícii, pokiaľ vzostup sérového kreatinínu nie je &gt;50 % (a kreatinín ostáva &lt;3 mg/dl, eGFR &gt;25 ml/min/1,73 m<sup>2</sup> a nie je hyperkaliémia).</li>
  <li><strong>Finerenón</strong> v predšpecifikovanej súhrnnej analýze FIDELITY (13 026 pacientov s DM2 a CKD) znížil kompozitný kardiovaskulárny výsledok (HR 0,86; 95 % CI 0,78–0,95) aj kompozitný obličkový výsledok (HR 0,77; 0,67–0,88) oproti placebu. Trvalé ukončenie pre hyperkaliémiu bolo častejšie pri finerenóne (1,7 % vs. 0,6 %). Konferencia spomína aj prínos finerenónu pri HF s mierne zníženou alebo zachovanou ejekčnou frakciou (FINEARTS-HF); ide o inú populáciu než FIDELITY.</li>
  <li><strong>Semaglutid</strong> v štúdii FLOW u 3 533 pacientov s DM2 a CKD znížil riziko primárneho obličkového kompozitu o 24 % (HR 0,76; 95 % CI 0,66–0,88). KDIGO 2024 odporúča dlhodobo pôsobiaci GLP-1 RA u dospelých s DM2 a CKD, ktorí nedosiahli glykemické ciele alebo SGLT2 inhibítor/metformín nemôžu užívať; prednosť majú látky s preukázaným kardiovaskulárnym prínosom. Konferencia pre GLP-1 RA pri CKD uvádza aj praktický názor účastníkov (nie samostatné odporúčanie KDIGO) vo väzbe na údaje z klinických štúdií.</li>
</ul>

<p>Pri HFrEF ostáva cieľom rýchla iniciácia a titrácia štyroch kľúčových tried (ARNI, SGLT2 inhibítor, MRA, betablokátor) v tolerovaných dávkach. Pri CKD sú častými bariérami vzostup kreatinínu, hypotenzia a hyperkaliémia – a práve pre ne sa GDMT často <strong>neprimerane vysadzuje</strong>. Pri eGFR &lt;60 ml/min/1,73 m<sup>2</sup> konferencia v koncepčnom rámci uvádza začatie ACEi/ARB, steroidného MRA alebo nsMRA pri sérovom draslíku &lt;5 mmol/l, s opakovaným meraním kaliémie. Diuretiká treba použiť pri expanzii objemu bez ohľadu na eGFR; pri nízkej eGFR sú spravidla potrebné vyššie dávky kľučkových diuretík. ARNI sa nesmie kombinovať s ACEi.</p>

<p>Hyperkaliémiu pri RAAS inhibícii, MRA/nsMRA a ARNI treba riešiť cielenými opatreniami, nie automatickým ukončením GDMT: súbežný SGLT2 inhibítor, viazače draslíka, korekcia acidózy, úprava diéty a súbežných liekov, diuretiká. Reflexné vysadenie prognosticky účinnej liečby je podľa konferencie jedným z hlavných praktických zlyhaní.</p>

<h2>Pokles eGFR po začatí GDMT: očakávaný hemodynamický jav, nie univerzálne pravidlo „až 30 %“</h2>

<p>SGLT2 inhibítory, RAAS inhibítory, MRA/nsMRA aj ARNI môžu spôsobiť akútny, často reverzibilný pokles eGFR znížením intraglomerulárneho tlaku. Tento „dip“ spravidla <strong>nesúvisí s horšími klinickými výsledkami</strong> a malé poklesy po začatí GDMT podľa konferencie vo všeobecnosti <strong>nevyžadujú vysadenie</strong>.</p>

<p>Konferenčná tabuľka k manažmentu nežiaducich účinkov formuluje praktické pravidlo:</p>

<ul>
  <li>hemodynamické výkyvy eGFR <strong>až do 30 %</strong> sa môžu vyskytnúť a <strong>nemajú samy osebe viesť k ukončeniu liečby</strong>;</li>
  <li>pri poklese <strong>&gt;30 %</strong> treba pátrať po iných príčinách AKI (hypovolémia, obštrukcia, nefrotoxíny, interkurentné ochorenie, hypotenzia, hyperkaliémia).</li>
</ul>

<p>To nie je totéž ako očakávať u každého pacienta pokles o 30 %. V editoriali Heerspinka a Cherneyho k SGLT2 inhibítorom bol pokles eGFR ≥10 % častý (28 % pri empagliflozíne v EMPA-REG OUTCOME vs. 13 % pri placebe; 45 % pri kanagliflozíne v CREDENCE vs. 21 % pri placebe), zatiaľ čo pokles <strong>&gt;30 % bol v CREDENCE zriedkavý (0,5 %)</strong> a v tejto malej podskupine sa riziko obličkových nežiaducich udalostí mierne zvýšilo – vtedy treba liek dočasne vysadiť a počkať na návrat eGFR. Kontinuálny pokles je znepokojivejší než jednorazový mierny (približne 10–15 %) pokles, ktorý sa následne stabilizuje.</p>

<p>Močový sediment pomôže, ak je podozrenie na tubulárne poškodenie. Cieľom ostáva udržať GDMT tam, kde je to bezpečné, a neliečiť kreatinín namiesto pacienta.</p>

<h2>Koordinovaná interdisciplinárna starostlivosť</h2>

<p>Odporúčania pre HF a CKD sa pri tých istých liekoch môžu líšiť (napríklad prahy eGFR pre začatie RAAS inhibície). Bez vzájomného sledovania obličiek pri liečbe HF a srdca pri liečbe CKD hrozí, že jedna disciplína neúmyselne zhorší druhý orgán. Konferencia preto žiada <strong>integrované, individualizované a kolaboratívne</strong> riadenie a ako výskumnú prioritu uvádza hodnotenie integrovaných modelov starostlivosti.</p>

<p>Systematický prehľad Durua a spoluautorov (22 štúdií u pacientov s najmenej dvoma CKM stavmi) zahŕňal multidisciplinárne ambulancie, zapojenie farmaceuta, edukáciu pacienta aj tímové porady. V porovnaní s bežnou starostlivosťou boli programy <strong>spojené</strong> s vyššou spokojnosťou pacientov, menším počtom zdravotných problémov, lepšou dochádzkou a v niektorých modeloch (najmä s telemedicínou) s nižšími nákladmi. Autori uzatvárajú, že koordinovaná CKM starostlivosť <strong>môže</strong> zlepšiť klinické výsledky a znížiť náklady; heterogenita zásahov, populácií aj ukazovateľov bráni silnému kauzálnemu zovšeobecneniu. Do článku preto patrí formulácia „boli spojené so“, nie „preukázali, že“.</p>

<p>V praxi má primárna starostlivosť kľúčovú úlohu pri včasnom záchyte (eGFR, UACR, tlak, glykémia, nadváha). Pri rastúcej komplexnosti, krehkosti, opakovaných hospitalizáciách pre HF, rýchlom poklese eGFR alebo ťažkej albuminúrii je potrebná úzka spolupráca nefrológa, kardiológa, diabetológa/endokrinológa, sestry a klinického farmaceuta.</p>

<h2>Čo z toho vyplýva pre nefrologickú ambulanciu</h2>

<ol>
  <li>Pri každom pacientovi s CKD aktívne myslite na HF (anamnéza námahovej dychovice, ortodopnoe, opuchy, natriuretické peptidy, echo podľa indikácie). Pri každom pacientovi s HF merajte <strong>eGFR aj UACR</strong>, nielen kreatinín.</li>
  <li>Štádium A podľa HF klasifikácie (CKD ako riziko HF) nie je totožné so štádiom 2 CKM syndrómu. Používajte oba rámce ako mapu rizika, nie ako náhradu diagnózy.</li>
  <li>GDMT s duálnym prínosom (SGLT2 inhibítor a RAAS inhibícia; podľa fenotypu nsMRA a/alebo GLP-1 RA) začnite a <strong>udržte</strong> v registrovaných a odporúčaných indikáciách, s monitorovaním draslíka, tlaku a trendu eGFR.</li>
  <li>Očakávajte hemodynamický pokles eGFR. Mierny stabilizovaný pokles liečbu spravidla nevysadzuje; pokles &gt;30 %, oligúria, hypotenzia, ťažká hyperkaliémia alebo známky hypovolémie vyžadujú iný postup.</li>
  <li>Hyperkaliémiu riešte (SGLT2 inhibítor, diuretiká, viazače draslíka, acidóza, diéta), aby ste predišli predčasnému ukončeniu RAAS/MRA liečby.</li>
  <li>Kongesciu liečte diuretikami podľa objemu; prognózu menia triedne lieky, nie samotná kľučka. Pri rezistencii zvážte vyššie dávky, sekvenčnú blokádu nefrónu a v refraktérnych prípadoch ultrafiltráciu alebo peritoneálnu dialýzu podľa kontextu.</li>
  <li>Pri pokročilej CKD a G5D priznajte medzery v dôkazoch a rozhodujte individuálne, v spolupráci s kardiológiou.</li>
</ol>

<div class="table-responsive" role="region" aria-label="Praktický checklist po začatí GDMT pri súbehu HF a CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Situácia</th>
      <th scope="col">Čo kontrolovať</th>
      <th scope="col">Ako reagovať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Pred začatím ACEi/ARB, MRA/nsMRA</th>
      <td>eGFR, draslík, objemový stav, súbežné lieky (NSAID, kálium šetriace diuretiká)</td>
      <td>Pri K<sup>+</sup> ≥5 mmol/l najprv upraviť kaliémiu; nezačínať „naslepo“</td>
    </tr>
    <tr>
      <th scope="row">Po začatí alebo titrácii RAAS/MRA</th>
      <td>Kreatinín a draslík o 2–4 týždne (pri vysokom riziku skôr)</td>
      <td>Mierny pokles eGFR pri stabilnom klinickom stave: pokračovať; &gt;30 % alebo alarmujúce znaky: hľadať AKI</td>
    </tr>
    <tr>
      <th scope="row">Po začatí SGLT2 inhibítora</th>
      <td>Objem, tlak, príznaky deplecie; rutinná extra kontrola elektrolytov nie je u väčšiny nutná</td>
      <td>Typický dip nie je AKI; pri &gt;30 % dočasne vysadiť a overiť návrat eGFR</td>
    </tr>
    <tr>
      <th scope="row">Hyperkaliémia pri GDMT</th>
      <td>Diéta, acidóza, lieky, diuréza, SGLT2 inhibícia</td>
      <td>Cielený manažment pred reflexným stopom RAAS/MRA</td>
    </tr>
    <tr>
      <th scope="row">Akútna dekongescia</th>
      <td>Hmotnosť, diuréza, spotový sodík v moči, NT-proBNP, tlak, perfúzia</td>
      <td>Izolovaný vzostup kreatinínu pri zlepšujúcej sa kongescii nie je automatický neúspech</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Limitácie tohto prehľadu</h2>

<p>Konferenčná správa je syntéza diskusií, nie náhrada KDIGO 2024 ani ESC/AHA usmernení pre HF. Percentá 10–30 % a 30–60 % sú rozsahy z epidemiologickej literatúry citovanej v správe, nie presný odhad pre slovenské ambulancie. Údaje CRIC pochádzajú z USA a nemusia sa presne prenášať. Prínosy GDMT sú viazané na štúdiové populácie; pri G4–G5 a dialýze ostávajú dôkazy slabšie. Systematický prehľad koordinovanej CKM starostlivosti je heterogénny a väčšinou neumožňuje kauzálny záver pre každý ukazovateľ. Tento článok je praktický prehľad pre nefrológa, nie úplný preklad dvadsaťstranovej správy.</p>

<h2>Záver</h2>

<p>HF a CKD tvoria obojsmerné zaťaženie so spoločnou pôdou rizikových faktorov. Moderná starostlivosť meria eGFR aj UACR, používa triedy liekov s preukázaným duálnym prínosom v štúdiách, počíta s hemodynamickým poklesom eGFR a namiesto izolovaného manažmentu jedného orgánu stavia na koordinácii nefrológie, kardiológie, diabetológie a primárnej starostlivosti. Najväčšou praktickou chybou nie je začať GDMT, ale ju predčasne vysadiť pre očakávanú laboratórnu zmenu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu: ako KDIGO prepája nefrológiu, diabetológiu a kardiológiu</a></li>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4, skríning a liečba podľa usmernenia AHA/ACC/ADA/ASN 2026</a></li>
  <li><a href="article.php?slug=ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia">CKM syndróm konečne ako „jeden rámec“: čo znamenajú nové ACC/AHA/ADA/ASN usmernenia pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=5-kritickych-chyb-manazment-ckm-syndromu-nefrologia">5 kritických chýb v manažmente CKM syndrómu a praktické kroky pre nefrológiu</a></li>
  <li><a href="article.php?slug=ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register">Chronická choroba obličiek a vznik srdcového zlyhávania: najsilnejšia väzba smeruje k HFpEF</a></li>
  <li><a href="article.php?slug=finerenon-ckm-syndrom-dm2-ckd-fidelity">Finerenón naprieč štádiami CKM syndrómu u pacientov s DM2 a CKD: čo prináša post-hoc analýza FIDELITY</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
</ul>

<p>Na odhad rizika zlyhania obličiek v ambulancii slúži aj <a href="calculator_kfre.php">kalkulačka KFRE</a> a <a href="calculator_ambulatory.php">ambulantný panel CKD</a>.</p>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Lam CSP, Bozkurt B, Cherney DZI, Ezekowitz JA, Jardine MJ, Khan SS, Madero M, Sarnak MJ, Ter Maaten JM, Cheung M, King JM, Grams ME, Jadoul M, Bansal N; Conference Participants.</strong> <em>Kidney disease and heart failure: recent advances and current challenges: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference.</em> Kidney Int. 2026;109(6):1095–1113. doi: 10.1016/j.kint.2025.10.011. Súčasná (identická) publikácia: JACC Heart Fail. 2026;14(4):102943. doi: 10.1016/j.jchf.2026.102943. Písací výbor má 14 menovaných autorov; ďalší účastníci konferencie sú uvedení v appendixe ako skupinové spoluautorstvo. <a href="https://doi.org/10.1016/j.kint.2025.10.011" target="_blank" rel="noopener noreferrer">Kidney International</a>; <a href="https://doi.org/10.1016/j.jchf.2026.102943" target="_blank" rel="noopener noreferrer">JACC: Heart Failure</a>; <a href="https://kdigo.org/wp-content/uploads/2026/05/KDIGO-2026-Kidney-Disease-Heart-Failure-Controversies-Conference-Report-KI-Final.pdf" target="_blank" rel="noopener noreferrer">voľne dostupný PDF KDIGO</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41791738/" target="_blank" rel="noopener noreferrer">PubMed (KI)</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41793402/" target="_blank" rel="noopener noreferrer">PubMed (JACC HF)</a>.</li>
  <li><strong>Bansal N, Zelnick L, Bhat Z, Dobre M, He J, Lash J, Jaar B, Mehta R, Raj D, Rincon-Choles H, Saunders M, Schrauben S, Weir M, Wright J, Go AS; CRIC Study Investigators.</strong> <em>Burden and outcomes of heart failure hospitalizations in adults with chronic kidney disease.</em> J Am Coll Cardiol. 2019;73(21):2691–2700. doi: 10.1016/j.jacc.2019.02.071. <a href="https://doi.org/10.1016/j.jacc.2019.02.071" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/31146814/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6590908/" target="_blank" rel="noopener noreferrer">PMC (voľne dostupný text)</a>.</li>
  <li><strong>Ndumele CE, Rangaswami J, Chow SL, Neeland IJ, Tuttle KR, Khan SS, Coresh J, Mathew RO, Baker-Smith CM, Carnethon MR, Després JP, Ho JE, Joseph JJ, Kernan WN, Khera A, Kosiborod MN, Lekavich CL, Lewis EF, Lo KB, Ozkan B, Palaniappan LP, Patel SS, Pencina MJ, Powell-Wiley TM, Sperling LS, Virani SS, Wright JT, Rajgopal Singh R, Elkind MSV; American Heart Association.</strong> <em>Cardiovascular-kidney-metabolic health: a presidential advisory from the American Heart Association.</em> Circulation. 2023;148(20):1606–1635. doi: 10.1161/CIR.0000000000001184. Definuje štádiá CKM 0–4. <a href="https://doi.org/10.1161/CIR.0000000000001184" target="_blank" rel="noopener noreferrer">Presidential advisory</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37807924/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Ndumele CE, Neeland IJ, Tuttle KR, Chow SL, Mathew RO, Khan SS, Coresh J, Baker-Smith CM, Carnethon MR, Després JP, Ho JE, Joseph JJ, Kernan WN, Khera A, Kosiborod MN, Lekavich CL, Lewis EF, Lo KB, Ozkan B, Palaniappan LP, Patel SS, Pencina MJ, Powell-Wiley TM, Sperling LS, Virani SS, Wright JT, Rajgopal Singh R, Elkind MSV, Rangaswami J; American Heart Association.</strong> <em>A synopsis of the evidence for the science and clinical management of cardiovascular-kidney-metabolic (CKM) syndrome: a scientific statement from the American Heart Association.</em> Circulation. 2023;148(20):1636–1664. doi: 10.1161/CIR.0000000000001186. Sprievodné vedecké vyhlásenie k advisory (iné strany, iný PMID). <a href="https://doi.org/10.1161/CIR.0000000000001186" target="_blank" rel="noopener noreferrer">Scientific statement</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37807920/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bozkurt B, Coats AJ, Tsutsui H, Abdelhamid M, Adamopoulos S, Albert N, Anker SD, Atherton J, Böhm M, Butler J, Drazner MH, Felker GM, Filippatos G, Fonarow GC, Fiuzat M, Gomez-Mesa JE, Heidenreich P, Imamura T, Januzzi J, Jankowska EA, Khazanie P, Kinugawa K, Lam CSP, Matsue Y, Metra M, Ohtani T, Francesco Piepoli M, Ponikowski P, Rosano GMC, Sakata Y, Seferović P, Starling RC, Teerlink JR, Vardeny O, Yamamoto K, Yancy C, Zhang J, Zieroth S.</strong> <em>Universal definition and classification of heart failure: a report of the Heart Failure Society of America, Heart Failure Association of the European Society of Cardiology, Japanese Heart Failure Society and Writing Committee of the Universal Definition of Heart Failure.</em> J Card Fail. 2021;27(4):387–413. doi: 10.1016/j.cardfail.2021.01.022. <a href="https://doi.org/10.1016/j.cardfail.2021.01.022" target="_blank" rel="noopener noreferrer">Univerzálna definícia HF</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33663906/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Agarwal R, Filippatos G, Pitt B, Anker SD, Rossing P, Joseph A, Kolkhof P, Nowack C, Gebel M, Ruilope LM, Bakris GL; FIDELIO-DKD and FIGARO-DKD investigators.</strong> <em>Cardiovascular and kidney outcomes with finerenone in patients with type 2 diabetes and chronic kidney disease: the FIDELITY pooled analysis.</em> Eur Heart J. 2022;43(6):474–484. doi: 10.1093/eurheartj/ehab777. <a href="https://doi.org/10.1093/eurheartj/ehab777" target="_blank" rel="noopener noreferrer">FIDELITY</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35023547/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, Mahaffey KW, Mann JFE, Bakris G, Baeres FMM, Idorn T, Bosch-Traberg H, Lausvig NL, Pratley R; FLOW Trial Committees and Investigators.</strong> <em>Effects of semaglutide on chronic kidney disease in patients with type 2 diabetes.</em> N Engl J Med. 2024;391(2):109–121. doi: 10.1056/NEJMoa2403347. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">FLOW</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Heerspink HJL, Cherney DZI.</strong> <em>Clinical implications of an acute dip in eGFR after SGLT2 inhibitor initiation.</em> Clin J Am Soc Nephrol. 2021;16(8):1278–1280. doi: 10.2215/CJN.02480221. <a href="https://doi.org/10.2215/CJN.02480221" target="_blank" rel="noopener noreferrer">Editorial</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33879500/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8455037/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Bailey CJ, Day C, Bellary S.</strong> <em>Renal protection with SGLT2 inhibitors: effects in acute and chronic kidney disease.</em> Curr Diab Rep. 2022;22(1):39–52. doi: 10.1007/s11892-021-01442-z. Prehľad mechanizmu a klinického významu akútneho poklesu eGFR po SGLT2 inhibícii. <a href="https://doi.org/10.1007/s11892-021-01442-z" target="_blank" rel="noopener noreferrer">Prehľad</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35113333/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Duru OK, Alicic R, Vaduganathan M, St Peter WL, Roberts GV, Rangaswami J, Nicholas SB, Neumiller JJ, Mathew RO, Gee P, Tuttle KR.</strong> <em>A systematic literature review of coordinated care in cardiovascular-kidney-metabolic conditions.</em> Mayo Clin Proc Innov Qual Outcomes. 2025;9(6):100671. doi: 10.1016/j.mayocpiqo.2025.100671. <a href="https://doi.org/10.1016/j.mayocpiqo.2025.100671" target="_blank" rel="noopener noreferrer">Systematický prehľad</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41321907/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC12657295/" target="_blank" rel="noopener noreferrer">PMC (voľne dostupný text)</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Primárnym zdrojom je spoločná publikácia konferenčnej správy KDIGO v <em>Kidney International</em> (PMID 41791738) a v <em>JACC: Heart Failure</em> (PMID 41793402); články sú podľa vydavateľov identické až na drobné štylistické rozdiely, preto sa necitujú ako dve samostatné práce. Autori písacieho výboru boli overení cez PubMed/Europe PMC. Rozsahy 10–30 % a 30–60 %, návrh zaradiť CKD do HF štádia A, formulácia o hemodynamických výkyvoch eGFR až do 30 % a stratégie manažmentu hyperkaliémie pochádzajú z plného textu správy (voľne dostupný PDF KDIGO). Čísla zo štúdie CRIC (miery hospitalizácie, pomery mier, HR progresie CKD a mortality) sú z abstraktu a záznamu Europe PMC (PMID 31146814). HR z FIDELITY a FLOW sú z PubMed abstraktov. Údaje o frekvencii eGFR dipu ≥10 % a zriedkavosti poklesu &gt;30 % v CREDENCE sú z editoriálu Heerspink–Cherney (PMC8455037). Štádiá CKM 0–4 sú z presidential advisory AHA (PMID 37807924), nie z HF klasifikácie A–D. Autori citovaných podporných štúdií nie sú autormi spracovaného zdroja a vo widgete „Zúčastnení autori“ sa neuvádzajú.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Observačné asociácie (CRIC, prehľad koordinovanej starostlivosti) nepreukazujú kauzalitu. Prínosy liekov platia v štúdiových a odporúčaných indikáciách; pri pokročilej CKD ostávajú dôkazy obmedzené. Pokles eGFR do 30 % nie je univerzálnym cieľom ani očakávaním u každého pacienta, ale prahom, pod ktorým konferencia neodporúča automatické vysadenie pri chýbaní varovných znakov.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026_article',
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
