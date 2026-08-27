<?php
/**
 * Publikačný skript odborného článku o rezistentnej hypertenzii.
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
    'title'        => 'Nekontrolovaná a rezistentná hypertenzia: diagnostika, aldosterónová os a nové liečebné možnosti',
    'slug'         => 'nekontrolovana-rezistentna-hypertenzia-aldosteronova-os',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Krvný tlak nad cieľom ešte neznamená skutočnú rezistentnú hypertenziu. Článok vysvetľuje rozdiel medzi zdanlivou a skutočnou rezistenciou, rozoberá sekundárne príčiny a hodnotí inhibítory aldosterónsyntázy.',
    'content'      => <<<'HTML'
<p>Nekontrolovaná, zdanlivo rezistentná a skutočne rezistentná hypertenzia nie sú synonymá. Zvýšený krvný tlak napriek predpísanej liečbe môže súvisieť s nesprávnym meraním, fenoménom bieleho plášťa, nedostatočnou adherenciou, suboptimálnym liečebným režimom, látkami zvyšujúcimi krvný tlak alebo sekundárnou príčinou, ktorá môže byť podkladom skutočnej rezistencie na liečbu. Rozlíšenie týchto situácií rozhoduje o ďalšom vyšetrení aj liečbe.</p>

<h2>Tri rozdielne klinické situácie</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Rozlíšenie nekontrolovanej, zdanlivo rezistentnej a skutočne rezistentnej hypertenzie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Pojem</th>
        <th scope="col">Čo znamená</th>
        <th scope="col">Čo ešte treba overiť</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Nekontrolovaná hypertenzia</th>
        <td>Krvný tlak zostáva nad individuálne stanoveným cieľom.</td>
        <td>Pojem sám osebe nevysvetľuje príčinu ani nepreukazuje rezistenciu na liečbu.</td>
      </tr>
      <tr>
        <th scope="row">Zdanlivá rezistencia (pseudorezistencia)</th>
        <td>Krvný tlak a použitá liečba zdanlivo spĺňajú kritériá rezistentnej hypertenzie, stav však ešte nebol spoľahlivo potvrdený.</td>
        <td>Techniku merania, tlak mimo ambulancie, adherenciu, dávky, kombináciu liekov, objemový stav a primeranosť diuretickej liečby.</td>
      </tr>
      <tr>
        <th scope="row">Skutočná rezistentná hypertenzia</th>
        <td>Rezistencia pretrváva aj po vylúčení príčin zdanlivej rezistencie.</td>
        <td>Možné sekundárne príčiny a ďalší bezpečný liečebný postup.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Podľa odporúčaní Európskej kardiologickej spoločnosti (ESC) z roku 2024 ide o rezistentnú hypertenziu vtedy, keď zostáva v ambulancii systolický tlak najmenej 140 mmHg a/alebo diastolický tlak najmenej 90 mmHg napriek maximálnym alebo maximálne tolerovaným dávkam najmenej troch liekov vrátane blokátora systému renín-angiotenzín, blokátora kalciových kanálov a tiazidového alebo tiazidom podobného diuretika. Zvýšené hodnoty treba potvrdiť domácim meraním alebo 24-hodinovým ambulantným monitorovaním krvného tlaku a vylúčiť zdanlivú rezistenciu. Pri odhadovanej glomerulovej filtrácii (eGFR) pod 30 ml/min/1,73 m² má byť na účely tejto definície primerane titrované kľučkové diuretikum. <a href="#odborny-zdroj-2">[2]</a></p>

<p>Americké odporúčanie AHA/ACC z roku 2025 používa širšiu definíciu a za rezistentnú považuje aj hypertenziu kontrolovanú štyrmi alebo viacerými antihypertenzívami. ESC túto kategóriu v definícii z roku 2024 nepoužíva. Pri čítaní štúdií preto treba vždy skontrolovať, podľa akej definície boli účastníci zaradení. <a href="#odborny-zdroj-2">[2]</a> <a href="#odborny-zdroj-3">[3]</a></p>

<p>Výraz „ťažko kontrolovateľná hypertenzia“ možno použiť opisne, nie však ako samostatnú štandardizovanú diagnózu. Nenahrádza presné určenie klinického fenotypu.</p>

<h2>Najprv vylúčiť zdanlivú rezistenciu</h2>

<ol>
  <li><strong>Overiť meranie.</strong> Potrebná je správna veľkosť manžety, pokoj pred meraním, vhodná poloha, opakované merania a validovaný prístroj. Jediná zvýšená hodnota na potvrdenie rezistencie nestačí.</li>
  <li><strong>Potvrdiť tlak mimo ambulancie.</strong> Domáce meranie alebo 24-hodinové ambulantné monitorovanie pomôžu rozpoznať fenomén bieleho plášťa a poskytujú údaje o krvnom tlaku v noci.</li>
  <li><strong>Posúdiť adherenciu nehodnotiacim spôsobom.</strong> Nedostatočné užívanie liekov môže súvisieť s nežiaducimi účinkami, zložitosťou režimu, cenou alebo dostupnosťou liekov, nedostatočným porozumením liečbe, kognitívnymi ťažkosťami či sociálnymi prekážkami.</li>
  <li><strong>Skontrolovať skutočnú intenzitu liečby.</strong> Počet tabliet nehovorí, či sú zastúpené správne triedy, či pacient predpísané dávky toleruje a či sú dostatočné, ani či je pri chronickej chorobe obličiek (CKD) primerane zvládnuté zadržiavanie sodíka a tekutín.</li>
  <li><strong>Identifikovať lieky, látky a režimové faktory zvyšujúce krvný tlak.</strong> Patria medzi ne napríklad nesteroidové protizápalové lieky, glukokortikoidy, sympatomimetiká a stimulanty, niektoré hormonálne prípravky, inhibítory kalcineurínu, látky stimulujúce erytropoézu, sladké drievko, nadmerný príjem alkoholu a vysoký príjem sodíka.</li>
</ol>

<p>Častou chybou je pridať ďalšie antihypertenzívum skôr, než sa vylúči fenomén bieleho plášťa a overia adherencia, vhodnosť liekovej kombinácie a objemový stav. Takýto postup môže zvyšovať riziko hypotenzie, elektrolytových porúch a akútneho poškodenia obličiek bez riešenia príčiny.</p>

<h2>Sekundárne príčiny treba hľadať cielene</h2>

<p>Rozsah vyšetrenia sa riadi vekom, začiatkom a priebehom hypertenzie, klinickými znakmi, laboratórnymi nálezmi a pravdepodobnosťou konkrétnej príčiny. Pri potvrdenej rezistentnej hypertenzii treba myslieť najmä na:</p>

<ul>
  <li>primárny aldosteronizmus,</li>
  <li>CKD a objemové preťaženie,</li>
  <li>obštrukčné spánkové apnoe,</li>
  <li>renovaskulárnu hypertenziu u vhodne vybraných pacientov,</li>
  <li>ďalšie endokrinné príčiny podľa klinického obrazu,</li>
  <li>lieky, výživové doplnky a návykové látky zvyšujúce krvný tlak.</li>
</ul>

<p>Vyšetrenie endogénneho hyperkortizolizmu nie je automaticky indikované u každého pacienta s nekontrolovaným tlakom. Má sa zvážiť u pacientov s príslušnými klinickými alebo biochemickými znakmi. Podobne sa vyšetrenie renovaskulárnej príčiny riadi predtestovou pravdepodobnosťou, nie samotným počtom antihypertenzív.</p>

<h2>Primárny aldosteronizmus a význam ARR</h2>

<p>V podmienenom odporúčaní z roku 2025 Endocrine Society navrhuje skríning primárneho aldosteronizmu u všetkých osôb s hypertenziou. Pri rezistentnej hypertenzii má skríning vysokú klinickú prioritu. Zahŕňa súčasné stanovenie aldosterónu a renínu a výpočet pomeru aldosterónu k renínu (ARR). Koncentrácia draslíka sa stanovuje súbežne najmä na správnu interpretáciu aldosterónu, pretože hypokaliémia môže viesť k falošne nízkej hodnote; sama osebe nie je skríningovým kritériom. Realizácia závisí aj od dostupnosti vyšetrenia a miestnych podmienok. <a href="#odborny-zdroj-4">[4]</a></p>

<p>ARR je skríningový nástroj, nie samostatná diagnóza. Ovplyvňujú ho antihypertenzíva, koncentrácia draslíka, príjem sodíka, funkcia obličiek, vek aj spôsob odberu. ARR preto treba interpretovať v kontexte a podľa zvoleného diagnostického protokolu. Pri potvrdenej diagnóze sa ďalší postup odvíja od toho, či pacient prichádza do úvahy na chirurgickú liečbu. U kandidátov na operáciu môže následne prísť do úvahy zobrazovacie vyšetrenie a selektívna katetrizácia nadobličkových žíl (AVS), ak je potrebná lateralizácia sekrécie. <a href="#odborny-zdroj-4">[4]</a></p>

<p>Pri lateralizovanom primárnom aldosteronizme je štandardnou liečbou jednostranná adrenalektómia, ak je pacient vhodným kandidátom. Pri bilaterálnej forme, bez preukázanej lateralizácie alebo ak sa chirurgická liečba nevolí, zostáva základom liečba antagonistom mineralokortikoidového receptora. Inhibítory aldosterónsyntázy zatiaľ nie sú štandardnou odporúčanou liečbou primárneho aldosteronizmu. <a href="#odborny-zdroj-4">[4]</a></p>

<p>Skutočnosť, že niektoré klinické skúšania inhibítorov aldosterónsyntázy nevyžadovali zvýšený ARR, neznamená, že ARR stráca diagnostický význam. Výber účastníkov do farmakologickej štúdie a diagnostika liečiteľnej sekundárnej príčiny odpovedajú na odlišné otázky.</p>

<h2>Osvedčený liečebný základ pred novou triedou</h2>

<p>Po potvrdení rezistentnej hypertenzie treba optimalizovať režimové opatrenia a základnú trojkombináciu, obmedziť príjem sodíka a podporiť adherenciu. V štúdii PATHWAY-2 bol spironolaktón účinnejší ako placebo, bisoprolol aj doxazosín; priemerný domáci systolický tlak bol oproti placebu nižší o 8,70 mmHg (95 % interval spoľahlivosti 7,69 až 9,72 mmHg). <a href="#odborny-zdroj-5">[5]</a></p>

<p>ESC odporúča zvážiť nízku dávku spironolaktónu ako preferovaný prídavný liek, ak to dovoľujú funkcia obličiek a koncentrácia draslíka. Pri eGFR najmenej 30 ml/min/1,73 m² sa v odporúčaní uvádza vstupná koncentrácia draslíka najviac 4,5 mmol/l a potreba častého monitorovania. Ak spironolaktón nie je vhodný alebo tolerovaný, voľba ďalšej liečby sa individualizuje. <a href="#odborny-zdroj-2">[2]</a></p>

<h2>Čím sa líšia inhibítory aldosterónsyntázy</h2>

<p>Antagonisty mineralokortikoidového receptora blokujú účinok aldosterónu na mineralokortikoidovom receptore. Inhibítory aldosterónsyntázy zasahujú o krok vyššie a tlmia jeho tvorbu inhibíciou enzýmu CYP11B2. Jednotlivé molekuly sa líšia selektivitou, dávkou, skúmanou populáciou, kritériami týkajúcimi sa funkcie obličiek aj regulačným statusom, preto ich nemožno hodnotiť ako vzájomne zameniteľné.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Klinické dôkazy pre vybrané inhibítory aldosterónsyntázy" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liek a štúdia</th>
        <th scope="col">Hlavný výsledok</th>
        <th scope="col">Dôležité obmedzenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Baxdrostat, BaxHTN</th>
        <td>Po 12 týždňoch bol rozdiel v zmene systolického tlaku oproti placebu −8,7 mmHg pri 1 mg a −9,8 mmHg pri 2 mg. <a href="#odborny-zdroj-6">[6]</a></td>
        <td>Do štúdie boli zaradení pacienti s eGFR najmenej 45 ml/min/1,73 m²; výsledok nepreukazuje zníženie počtu kardiovaskulárnych príhod.</td>
      </tr>
      <tr>
        <th scope="row">Lorundrostat, Launch-HTN</th>
        <td>Pri dávke 50 mg bol po 6 týždňoch rozdiel v zmene systolického krvného tlaku oproti placebu −9,1 mmHg. <a href="#odborny-zdroj-9">[9]</a></td>
        <td>Pacienti s eGFR pod 45 ml/min/1,73 m² boli vylúčení; častejšie sa vyskytli hyperkaliémia, hyponatriémia a zhoršenie funkcie obličiek.</td>
      </tr>
      <tr>
        <th scope="row">Vicadrostat, štúdia pri CKD</th>
        <td>Po 14 týždňoch sa pri dávkach 3 až 20 mg znížila albuminúria približne o 22 až 39 %, pri placebe o 3 %. <a href="#odborny-zdroj-10">[10]</a></td>
        <td>Albuminúria je náhradný ukazovateľ; štúdia nepreukázala spomalenie progresie CKD ani zníženie rizika zlyhania obličiek.</td>
      </tr>
      <tr>
        <th scope="row">Dexfadrostat, primárny aldosteronizmus</th>
        <td>V malej osemtýždňovej štúdii klesol priemerný 24-hodinový systolický krvný tlak oproti východisku o 10,7 mmHg. <a href="#odborny-zdroj-11">[11]</a></td>
        <td>Hodnotených bolo 35 pacientov a chýbala súbežná placebová skupina; výsledok má exploratívny charakter.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>K 27. augustu 2026 zostávali lorundrostat, vicadrostat a dexfadrostat skúšanými, neschválenými liekmi. FDA prijal žiadosť o registráciu lorundrostatu a určil cieľový termín rozhodnutia na 22. decembra 2026. Z uvedených štyroch molekúl bolo potvrdené regulačné schválenie iba pre baxdrostat v USA; nejde o dôvod na predpoklad dostupnosti v Európe. <a href="#odborny-zdroj-7">[7]</a> <a href="#odborny-zdroj-9">[9]</a> <a href="#odborny-zdroj-10">[10]</a> <a href="#odborny-zdroj-11">[11]</a> <a href="#odborny-zdroj-12">[12]</a></p>

<p>V randomizovanej štúdii BaxHTN bolo liečených 794 účastníkov s nekontrolovanou alebo rezistentnou hypertenziou. Koncentrácia draslíka nad 6,0 mmol/l sa vyskytla u 2,3 % účastníkov pri baxdrostate v dávke 1 mg, u 3,0 % pri dávke 2 mg a u 0,4 % pri placebe. Tieto údaje sa týkajú konkrétneho skúšania a prahu, nie celkovej frekvencie hyperkaliémie v klinickej praxi. <a href="#odborny-zdroj-6">[6]</a></p>

<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) schválil 15. mája 2026 baxdrostat pod názvom BAXFENDY na prídavnú liečbu dospelých s hypertenziou, ktorá nie je dostatočne kontrolovaná inými liekmi. V americkej informácii o lieku sa vyžaduje sledovanie koncentrácií draslíka a sodíka. Bezpečnosť a účinnosť pri začatí liečby u pacientov s eGFR pod 45 ml/min/1,73 m² neboli stanovené. Dokument zároveň výslovne uvádza, že neexistujú kontrolované štúdie preukazujúce zníženie kardiovaskulárnych príhod s BAXFENDY. Americké schválenie samo osebe neznamená registráciu ani dostupnosť v Európskej únii alebo na Slovensku; aktuálny stav treba overiť v príslušnej liekovej informácii. <a href="#odborny-zdroj-7">[7]</a></p>

<h2>CKD: účinok na krvný tlak a zvýšené bezpečnostné nároky</h2>

<p>V 26-týždňovej štúdii FigHTN u pacientov s CKD a nekontrolovanou hypertenziou bol pri baxdrostate rozdiel systolického tlaku oproti placebu −8,1 mmHg (95 % interval spoľahlivosti −13,4 až −2,8 mmHg). Medián pomeru albumínu ku kreatinínu v moči pri zaradení bol 714 mg/g a priemerná eGFR 44 ml/min/1,73 m². Prieskumná analýza ukázala zníženie albuminúrie oproti placebu približne o 55 %, nejde však o dôkaz ochrany pred zlyhaním obličiek. Hyperkaliémia hlásená ako nežiaduca udalosť sa vyskytla u 41 % účastníkov s baxdrostatom a u 5 % s placebom. <a href="#odborny-zdroj-8">[8]</a></p>

<p>Vicadrostat v 14-týždňovej štúdii fázy 2 znížil albuminúriu pri súbežnej štandardnej liečbe CKD, pričom smer účinku bol podobný pri súbežnom podávaní empagliflozínu aj bez neho. Hyperkaliémia sa v závislosti od dávky vyskytla u 10 až 18 % účastníkov oproti 6 % pri placebe. Ani táto štúdia nehodnotila dlhodobé renálne výsledky. <a href="#odborny-zdroj-10">[10]</a></p>

<p>Pri CKD preto nestačí sledovať iba pokles krvného tlaku. Dôležité sú vstupná eGFR, koncentrácie draslíka a sodíka, súbežná liečba blokátormi systému renín-angiotenzín a antagonistami mineralokortikoidového receptora, diuretická liečba, objemový stav a včasná laboratórna kontrola. Výsledky jednej molekuly alebo jednej štúdie nemožno automaticky preniesť na celú liekovú triedu.</p>

<h2>Praktický diagnostický a liečebný postup</h2>

<ol>
  <li>Stanoviť individuálny cieľ krvného tlaku a zopakovať meranie správnou technikou.</li>
  <li>Potvrdiť nekontrolovaný tlak domácim meraním alebo 24-hodinovým ambulantným monitorovaním.</li>
  <li>Systematicky a bez odsudzovania posúdiť adherenciu, znášanlivosť liečby, dostupnosť liekov a látky zvyšujúce tlak.</li>
  <li>Optimalizovať základnú kombináciu a dávky; pri CKD osobitne zhodnotiť príjem sodíka, objemový stav a vhodnosť diuretika vzhľadom na eGFR.</li>
  <li>Cielene vyšetriť sekundárne príčiny. Primárny aldosteronizmus zaradiť medzi priority; klinickú intuíciu nepovažovať za náhradu ARR.</li>
  <li>Ak to dovoľujú funkcia obličiek a koncentrácia draslíka, zvážiť podľa odporúčaní spironolaktón s primeraným monitorovaním.</li>
  <li>Liečbu inhibítorom aldosterónsyntázy zvažovať iba podľa platnej indikácie, dostupnosti, kritérií funkcie obličiek a koncentrácií elektrolytov a údajov konkrétneho lieku. Pri CKD a kombinovanej blokáde aldosterónovej osi je potrebná zvýšená opatrnosť.</li>
</ol>

<h2>Čo zatiaľ dôkazy nepreukázali</h2>

<ul>
  <li>Pokles krvného tlaku automaticky nepreukazuje zníženie výskytu infarktu myokardu, cievnej mozgovej príhody ani mortality.</li>
  <li>Pokles albuminúrie nepreukazuje automaticky pomalšiu progresiu CKD alebo menšie riziko zlyhania obličiek.</li>
  <li>Priaznivý výsledok jednej molekuly nepreukazuje rovnakú účinnosť a bezpečnosť celej triedy.</li>
  <li>Zaradenie do klinického skúšania bez zvýšeného ARR nenahrádza diagnostiku primárneho aldosteronizmu.</li>
  <li>Americké regulačné rozhodnutie neurčuje dostupnosť lieku v Európe ani jeho miesto v slovenských liečebných postupoch.</li>
</ul>

<p><strong>Záver:</strong> rezistentná hypertenzia nie je diagnóza založená na jedinom vysokom meraní ani na samotnom počte tabliet. Vyžaduje potvrdenie zvýšených hodnôt krvného tlaku mimo ambulancie, posúdenie adherencie, optimalizáciu liečebného režimu a cielené vyšetrenie sekundárnych príčin. Aldosterónová os má v tomto postupe významné miesto, nové inhibítory aldosterónsyntázy však nemožno prezentovať ako automatický ďalší krok bez presného vymedzenia indikácie, dôkazov a bezpečnosti.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu: od správneho merania ku klinickým rozhodnutiam</a></li>
  <li><a href="article.php?slug=renalna-denervacia-rezistentna-hypertenzia">Renálna denervácia pri rezistentnej hypertenzii</a></li>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinačná liečba CKD: štyri piliere a hranice dôkazov</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Zdroj:</strong> Taub PR, Schutte AE, Narkiewicz K, Kreutz R. Uncontrolled, Resistant, or Hard-to-Control Hypertension: Demystifying Definitions and Focusing on the Patient. Medscape Education. 2026. <a href="https://www.medscape.org/viewarticle/uncontrolled-resistant-or-hard-control-hypertension-2026a1000t9x?page=1" target="_blank" rel="noopener noreferrer">Vzdelávacia aktivita</a>. Východiskový materiál; odborné tvrdenia a číselné údaje boli overené podľa primárnych a oficiálnych zdrojov uvedených nižšie.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Európske odporúčanie:</strong> McEvoy JW, McCarthy CP, Bruno RM, et al. 2024 ESC Guidelines for the management of elevated blood pressure and hypertension. <em>Eur Heart J.</em> 2024;45(38):3912–4018. doi: <a href="https://doi.org/10.1093/eurheartj/ehae178" target="_blank" rel="noopener noreferrer">10.1093/eurheartj/ehae178</a>. PMID 39210715. <a href="https://pubmed.ncbi.nlm.nih.gov/39210715/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. Americké odporúčanie:</strong> Jones DW, Ferdinand KC, Taler SJ, et al. 2025 AHA/ACC/AANP/AAPA/ABC/ACCP/ACPM/AGS/AMA/ASPC/NMA/PCNA/SGIM Guideline for the Prevention, Detection, Evaluation and Management of High Blood Pressure in Adults. <em>Circulation.</em> 2025;152(11):e114–e218. doi: <a href="https://doi.org/10.1161/CIR.0000000000001356" target="_blank" rel="noopener noreferrer">10.1161/CIR.0000000000001356</a>. PMID 40811497. <a href="https://pubmed.ncbi.nlm.nih.gov/40811497/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-4"><small><em><strong>4. Primárny aldosteronizmus:</strong> Adler GK, Stowasser M, Correa RR, et al. Primary Aldosteronism: An Endocrine Society Clinical Practice Guideline. <em>J Clin Endocrinol Metab.</em> 2025;110(9):2453–2495. doi: <a href="https://doi.org/10.1210/clinem/dgaf284" target="_blank" rel="noopener noreferrer">10.1210/clinem/dgaf284</a>. PMID 40658480. <a href="https://pubmed.ncbi.nlm.nih.gov/40658480/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-5"><small><em><strong>5. PATHWAY-2:</strong> Williams B, MacDonald TM, Morant S, et al. Spironolactone versus placebo, bisoprolol, and doxazosin to determine the optimal treatment for drug-resistant hypertension: a randomised, double-blind, crossover trial. <em>Lancet.</em> 2015;386(10008):2059–2068. doi: <a href="https://doi.org/10.1016/S0140-6736(15)00257-3" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(15)00257-3</a>. PMID 26414968. <a href="https://pubmed.ncbi.nlm.nih.gov/26414968/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-6"><small><em><strong>6. BaxHTN:</strong> Flack JM, Azizi M, Brown JM, et al. Efficacy and Safety of Baxdrostat in Uncontrolled and Resistant Hypertension. <em>N Engl J Med.</em> 2025;393(14):1363–1374. doi: <a href="https://doi.org/10.1056/NEJMoa2507109" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2507109</a>. PMID 40888730. <a href="https://pubmed.ncbi.nlm.nih.gov/40888730/" target="_blank" rel="noopener noreferrer">PubMed</a>. Registrácia: <a href="https://clinicaltrials.gov/study/NCT06034743" target="_blank" rel="noopener noreferrer">NCT06034743</a>.</em></small></p>

<p id="odborny-zdroj-7"><small><em><strong>7. Regulačný zdroj:</strong> U.S. Food and Drug Administration. BAXFENDY (baxdrostat) tablets, prescribing information. Dátum schválenia: 15. mája 2026. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2026/219878Orig1s000lbl.pdf" target="_blank" rel="noopener noreferrer">Oficiálna informácia o lieku</a>. <a href="https://www.fda.gov/drugs/novel-drug-approvals-fda/novel-drug-approvals-2026" target="_blank" rel="noopener noreferrer">FDA Novel Drug Approvals for 2026</a>.</em></small></p>

<p id="odborny-zdroj-8"><small><em><strong>8. Baxdrostat pri CKD, FigHTN:</strong> Dwyer JP, Maklad N, Vedin O, et al. Efficacy and Safety of Baxdrostat in Participants with CKD and Uncontrolled Hypertension: A Randomized, Double-Blind, Placebo-Controlled Trial. <em>J Am Soc Nephrol.</em> 2026;37(2):299–311. doi: <a href="https://doi.org/10.1681/ASN.0000000849" target="_blank" rel="noopener noreferrer">10.1681/ASN.0000000849</a>. PMID 40913594, PMCID PMC12889919. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12889919/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-9"><small><em><strong>9. Launch-HTN:</strong> Saxena M, Laffin LJ, Borghi C, et al. Lorundrostat in Participants With Uncontrolled Hypertension and Treatment-Resistant Hypertension: The Launch-HTN Randomized Clinical Trial. <em>JAMA.</em> 2025;334(5):409–418. doi: <a href="https://doi.org/10.1001/jama.2025.9413" target="_blank" rel="noopener noreferrer">10.1001/jama.2025.9413</a>. PMID 40587141, PMCID PMC12210145. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12210145/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-10"><small><em><strong>10. Vicadrostat pri CKD:</strong> Tuttle KR, Hauske SJ, Canziani ME, et al. Efficacy and safety of aldosterone synthase inhibition with and without empagliflozin for chronic kidney disease: a randomised, controlled, phase 2 trial. <em>Lancet.</em> 2024;403(10424):379–390. doi: <a href="https://doi.org/10.1016/S0140-6736(23)02408-X" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(23)02408-X</a>. PMID 38109916. <a href="https://pubmed.ncbi.nlm.nih.gov/38109916/" target="_blank" rel="noopener noreferrer">PubMed</a>. Registrácia: <a href="https://clinicaltrials.gov/study/NCT05182840" target="_blank" rel="noopener noreferrer">NCT05182840</a>.</em></small></p>

<p id="odborny-zdroj-11"><small><em><strong>11. Dexfadrostat pri primárnom aldosteronizme:</strong> Mulatero P, Wuerzner G, Groessl M, et al. Safety and efficacy of once-daily dexfadrostat phosphate in patients with primary aldosteronism: a randomised, parallel group, multicentre, phase 2 trial. <em>EClinicalMedicine.</em> 2024;71:102576. doi: <a href="https://doi.org/10.1016/j.eclinm.2024.102576" target="_blank" rel="noopener noreferrer">10.1016/j.eclinm.2024.102576</a>. PMID 38618204, PMCID PMC11015343. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11015343/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-12"><small><em><strong>12. Regulačný stav lorundrostatu:</strong> Mineralys Therapeutics, Inc. Quarterly Report on Form 10-Q for the quarter ended June 30, 2026. U.S. Securities and Exchange Commission. FDA prijal žiadosť o registráciu; cieľový termín rozhodnutia je 22. decembra 2026. <a href="https://www.sec.gov/Archives/edgar/data/1933414/000193341426000114/mlys-20260630.htm" target="_blank" rel="noopener noreferrer">SEC filing</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, regulačný status a číselné výsledky boli overené 27. augusta 2026. Číselné údaje o účinku na krvný tlak vyjadrujú rozdiely v zmene oproti placebu, ak nie je uvedené inak. Albuminúria je náhradný ukazovateľ a uvedené štúdie nepreukázali zníženie rizika zlyhania obličiek. Regulačný status a dostupnosť liekov sa môžu meniť.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani aktuálnu informáciu o lieku. Diagnostika sekundárnej hypertenzie, úprava liečby a monitorovanie elektrolytov a funkcie obličiek sa musia prispôsobiť konkrétnemu pacientovi, komorbiditám a platným miestnym odporúčaniam.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_nekontrolovana_rezistentna_hypertenzia_aldosteronova_os',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    $titleForLog = static function (array $items): string {
        $first = $items[0] ?? null;
        $title = is_array($first) ? ($first['title'] ?? null) : null;

        return is_string($title) && $title !== '' ? $title : '(bez titulu)';
    };

    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $titleForLog($articles) . "\n";
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
