<?php
/**
 * add_progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth_article.php
 * Odborný článok o longitudinálnej progresii kalcifikácie koronárnych artérií
 * naprieč štádiami chronickej choroby obličiek a o nelineárnych vzťahoch
 * so sérovým horčíkom a parathormónom (Chen et al., Front Med 2026).
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
    'title'        => 'Progresia kalcifikácie koronárnych artérií pri zhoršovaní funkcie obličiek: úloha sérového horčíka a parathormónu',
    'slug'         => 'progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kalcifikácia koronárnych artérií zrýchľuje z 8,5 %/rok v štádiu CKD G1 až G2 na 29,5 %/rok u dialyzovaných. Čo v 800-člennej kohorte ukázali prahy horčíka 0,82 mmol/l a PTH 120 pg/ml a kde sú hranice intervencie.',
    'content'      => <<<'HTML'
<figure><a href="img/progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth.webp" rel="noopener noreferrer" target="_blank"><img src="img/progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth.webp" alt="Poloschematická scéna: z polopriesvitnej sklenej obličky vpravo prúdia jemné svetelné častice minerálov k otvorenému rezu koronárnej tepny na siluete srdca vľavo, kde stenu tepny postupne prestupujú bielo-jantárové kryštalické ložiská kalcifikácie" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zobrazenie konkrétneho výrobku. S úbytkom glomerulovej filtrácie sa cievna kalcifikácia mení z pomalého degeneratívneho deja na aktívne riadenú mineralizáciu steny koronárnych tepien.</figcaption></figure>

<p>Kalcifikácia koronárnych artérií (coronary artery calcification, CAC) patrí k hlavným štrukturálnym prejavom kardiovaskulárneho poškodenia pri chronickej chorobe obličiek (chronic kidney disease, CKD). Kým v bežnej populácii odráža predovšetkým aterosklerotickú záťaž intimy, u pacientov s CKD sa k nej pridáva kalcifikácia médie a aktívna osteogénna prestavba buniek hladkej svaloviny ciev (vascular smooth muscle cells, VSMC) v prostredí poruchy minerálového a kostného metabolizmu (CKD-mineral and bone disorder, CKD-MBD). Jednorazové stanovenie vápnikového skóre pritom zachytí len doterajší súčet zmien, nie aktuálne tempo, akým proces napreduje. [1,2]</p>

<p>Retrospektívna longitudinálna štúdia autorov z Čchung-čchingu, publikovaná v septembri 2026 v časopise <em>Frontiers in Medicine</em> a zhrnutá aj v spravodajstve <em>Physicians Weekly</em>, sledovala trajektórie CAC u 800 pacientov so sériovými vyšetreniami hrudníka výpočtovou tomografiou (CT). Práca kvantifikovala strmý nárast ročného tempa kalcifikácie od včasných štádií CKD až po dialýzu a určila nelineárne prahy pre vstupný sérový horčík (0,82 mmol/l) a parathormón (PTH; 120 pg/ml). [1,3]</p>

<p>Text nižšie podrobne rozoberá metodiku a číselné výsledky primárnej práce, upozorňuje na dôležité podskupinové rozdiely, ktoré sekundárne zhrnutia vynechali, a konfrontuje tieto observačné nálezy s odporúčaniami KDIGO aj s výsledkami randomizovaných klinických štúdií perorálnej suplementácie horčíka.</p>

<h2>Dizajn štúdie, výber súboru a hodnotenie kalcifikácie</h2>

<p>Analýza zahŕňala dospelých pacientov s CKD (definovanou ako štrukturálne alebo funkčné postihnutie obličiek trvajúce dlhšie ako 3 mesiace), ktorí boli v období od januára 2017 do januára 2025 pravidelne sledovaní na Nefrologickom oddelení a v Hemodialyzačnom centre Druhej fakultnej nemocnice Čchungčchinskej lekárskej univerzity (The Second Affiliated Hospital of Chongqing Medical University). Zo 874 skrínovaných osôb so sériovými CT vyšetreniami hrudníka autori vylúčili 74 pacientov: 12 pre akútnu kardiovaskulárnu príhodu na začiatku sledovania, 14 pre primárnu hyperparatyreózu, 40 pre zmenu dlhodobej suplementácie horčíka alebo viazačov fosfátov v priebehu posledných troch mesiacov pred vstupným vyšetrením, 6 pre aktívnu malignitu alebo očakávané prežívanie kratšie než 1 rok a 2 pre tehotenstvo či dojčenie. [1]</p>

<p>Do výslednej kohorty vstúpilo <strong>800 pacientov</strong> (482 mužov, teda 60,3 %; priemerný vek 59,2 ± 12,8 roka). Podľa vstupnej odhadovanej glomerulovej filtrácie (eGFR), ktorú autori počítali rovnicou MDRD, a podľa dialyzačnej liečby bol súbor rozdelený do štyroch skupín: štádiá CKD G1 až G2 (n = 120; 15,0 %), štádium CKD G3 (n = 100; 12,5 %), nedialyzované štádiá CKD G4 až G5 (n = 380; 47,5 %) a dialyzovaní pacienti (n = 200; 25,0 %). Pacienti s pokročilou CKD G4 až G5 a pacienti na dialýze tak tvorili spolu <strong>72,5 % celého súboru</strong> (580 z 800 osôb), čo treba mať na pamäti pri interpretácii celkových modelov. [1]</p>

<p>Podmienkou zaradenia boli najmenej dve CT vyšetrenia hrudníka s vyhodnotením CAC v odstupe aspoň 6 mesiacov. Dôležitou metodickou črtou je, že CT vyšetrenia neboli vykonávané v rámci plošného skríningového protokolu, ale z klinickej indikácie ošetrujúceho lekára (podozrenie na kardiovaskulárne alebo kardiopulmonálne ochorenie, kontrola známeho nálezu alebo predoperačné posúdenie). Celkovo bolo analyzovaných 2 320 CT skenov (priemer 2,9 a medián 3 vyšetrenia na pacienta, rozsah od 2 do 5; medián odstupu medzi po sebe nasledujúcimi vyšetreniami bol 9,8 mesiaca, medzikvartilové rozpätie [IQR] 6,5 až 13,2 mesiaca). Medián celkového sledovania dosiahol <strong>20,5 mesiaca</strong> (IQR 11,0 až 32,0 mesiaca; rozsah od 6 do 36 mesiacov), pričom 112 pacientov (14,0 %) bolo sledovaných kratšie než 12 mesiacov, 328 (41,0 %) od 12 do 24 mesiacov a 360 (45,0 %) od 24 do 36 mesiacov. [1]</p>

<p>Skóre CAC sa stanovovalo Agatstonovou metódou na multidetektorovom špirálovom CT v štyroch hlavných povodiach (pravá koronárna artéria, kmeň ľavej koronárnej artérie, ramus interventricularis anterior a ramus circumflexus). Primárnym sledovaným ukazovateľom bola <strong>rýchla progresia CAC</strong>, definovaná kombinovaným kritériom ako absolútny ročný prírastok Agatstonovho skóre najmenej o 100 jednotiek za rok alebo relatívny ročný nárast najmenej o 10 % (pričom pri východiskovom skóre CAC 100 jednotiek a menej slúžila ako menovateľ práve táto nízka vstupná hodnota, keďže v pásme nízkeho vápnikového skóre by samotný absolútny prah 100 jednotiek zachytil len extrémne zmeny). Trajektórie celkového CAC skóre v čase autori modelovali lineárnym modelom so zmiešanými efektmi po logaritmickej transformácii ln(CAC + 1), nelineárne vzťahy hodnotili obmedzenými kubickými splajnami (uzly na 5., 35., 65. a 95. percentile) v kombinácii s multivariabilnou logistickou regresiou a výber premenných do predikčného nomogramu vykonali penalizovanou regresiou LASSO. [1]</p>

<h2>Vstupný profil a zrýchľovanie kalcifikácie naprieč štádiami CKD</h2>

<p>Na začiatku sledovania malo artériovú hypertenziu 73,0 % pacientov, diabetes mellitus 39,0 %, hyperlipidémiu 44,5 % a osobnú anamnézu kardiovaskulárneho ochorenia 22,0 %. Medián vstupného Agatstonovho skóre v celom súbore bol 98,6 (IQR 18,5 až 386,5) a nulové vstupné skóre (CAC = 0) malo 168 pacientov (21,0 %). S klesajúcou glomerulovou filtráciou klesal podiel pacientov bez koronárnych kalcifikácií zo 43,3 % v štádiu CKD G1 až G2 na 11,0 % u dialyzovaných, klesala koncentrácia sérového horčíka a stúpali hodnoty fosforu, PTH aj kyseliny močovej. [1]</p>

<div class="table-responsive" role="region" aria-label="Vstupné charakteristiky a ročná miera progresie CAC podľa štádia CKD" tabindex="0">
<table>
  <caption>Vstupné laboratórne parametre, východiskové skóre CAC a ročné tempo progresie podľa štádia CKD (Chen et al., 2026 [1]).</caption>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Celý súbor (N = 800)</th>
      <th scope="col">CKD G1 až G2 (n = 120)</th>
      <th scope="col">CKD G3 (n = 100)</th>
      <th scope="col">CKD G4 až G5 bez dialýzy (n = 380)</th>
      <th scope="col">Dialýza (n = 200)</th>
      <th scope="col">p</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Vek (roky, priemer ± SD)</th>
      <td>59,2 ± 12,8</td>
      <td>54,5 ± 12,6</td>
      <td>56,8 ± 12,4</td>
      <td>60,2 ± 12,6</td>
      <td>60,8 ± 11,8</td>
      <td>0,002</td>
    </tr>
    <tr>
      <th scope="row">eGFR (ml/min/1,73 m², medián, IQR)</th>
      <td>22,5 (12,8 až 42,6)</td>
      <td>86,5 (72,5 až 102,5)</td>
      <td>48,5 (40,5 až 56,5)</td>
      <td>18,5 (12,5 až 25,5)</td>
      <td>neuvádza sa</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Sérový horčík (mmol/l, medián, IQR)</th>
      <td>0,84 (0,75 až 0,92)</td>
      <td>0,92 (0,86 až 0,98)</td>
      <td>0,89 (0,83 až 0,95)</td>
      <td>0,83 (0,75 až 0,90)</td>
      <td>0,80 (0,72 až 0,88)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Hypomagneziémia (&lt; 0,75 mmol/l), n (%)</th>
      <td>168 (21,0 %)</td>
      <td>14 (11,7 %)</td>
      <td>16 (16,0 %)</td>
      <td>86 (22,6 %)</td>
      <td>52 (26,0 %)</td>
      <td>0,008</td>
    </tr>
    <tr>
      <th scope="row">PTH (pg/ml, medián, IQR)</th>
      <td>85,6 (42,5 až 168,3)</td>
      <td>42,5 (32,5 až 58,6)</td>
      <td>58,6 (42,5 až 85,6)</td>
      <td>102,5 (58,6 až 186,5)</td>
      <td>215,6 (145,6 až 356,8)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
    <th scope="row">Sérový fosfor (mmol/l, priemer ± SD)</th>
      <td>1,38 ± 0,36</td>
      <td>1,18 ± 0,24</td>
      <td>1,25 ± 0,28</td>
      <td>1,42 ± 0,36</td>
      <td>1,52 ± 0,42</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Kyselina močová (µmol/l, medián, IQR)</th>
      <td>428 (356 až 508)</td>
      <td>368 (325 až 435)</td>
      <td>398 (342 až 462)</td>
      <td>438 (365 až 512)</td>
      <td>462 (385 až 535)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Vstupné CAC skóre (AU, medián, IQR)</th>
      <td>98,6 (18,5 až 386,5)</td>
      <td>32,5 (6,5 až 128,5)</td>
      <td>68,5 (12,5 až 256,5)</td>
      <td>128,5 (32,5 až 428,5)</td>
      <td>268,5 (95,6 až 512,5)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Vstupné CAC skóre = 0, n (%)</th>
      <td>168 (21,0 %)</td>
      <td>52 (43,3 %)</td>
      <td>26 (26,0 %)</td>
      <td>68 (17,9 %)</td>
      <td>22 (11,0 %)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Ročná miera progresie CAC (%/rok, 95 % IS)</th>
      <td>18,5 (IQR 5,6 až 42,8)</td>
      <td><strong>8,5 (6,0 až 11,0)</strong></td>
      <td><strong>13,2 (10,5 až 15,9)</strong></td>
      <td><strong>22,8 (19,5 až 26,1)</strong></td>
      <td><strong>29,5 (25,0 až 34,0)</strong></td>
      <td>&lt; 0,001</td>
    </tr>
  </tbody>
</table>
</div>

<p>Na konci sledovania stúpol medián CAC skóre v celej kohorte z 98,6 na 156,2 Agatstonovej jednotky (IQR 32,5 až 512,6) a kritérium rýchlej progresie splnilo <strong>348 z 800 pacientov (43,5 %)</strong>. V lineárnom modeli so zmiešanými efektmi upravenom o vek, pohlavie a vstupnú anamnézu kardiovaskulárneho ochorenia rástlo skóre CAC v čase (β = 0,168; 95 % interval spoľahlivosti [IS] 0,138 až 0,198; p &lt; 0,001) s vysoko významnou interakciou medzi dĺžkou sledovania a štádiom CKD (p &lt; 0,001). Modelované mediány CAC skóre po troch rokoch sledovania rástli v štádiu CKD G1 až G2 z 35,6 na 46,2 jednotky, v štádiu G3 zo 72,5 na 105,6 jednotky, v nedialyzovaných štádiách G4 až G5 zo 132,5 na 260,5 jednotky a u dialyzovaných pacientov z 272,5 až na 629,5 jednotky. [1]</p>

<p>Z klinického hľadiska sú na tejto trajektórii podstatné dva momenty. Po prvé, ročné tempo progresie u dialyzovaných pacientov (29,5 %/rok) bolo viac než trojnásobné oproti štádiu CKD G1 až G2 (8,5 %/rok). Po druhé, výrazný skok nastal už v predialyzačných štádiách CKD G4 až G5 (22,8 %/rok) – akcelerácia cievnej kalcifikácie sa teda začína dávno pred zahájením liečby nahrádzajúcej funkciu obličiek. Pozornosť si zaslúži aj údaj z plného textu, že u 112 pacientov sledovaných kratšie než 12 mesiacov bol medián anualizovanej progresie vyšší než u osôb sledovaných najmenej 24 mesiacov (20,2 %/rok oproti 16,8 %/rok). Okrem skutočnej včasnej akcelerácie to však môže odrážať aj skutočnosť, že skoršie kontrolné CT vyšetrenie podstupovali pacienti so zhoršením klinického stavu. [1]</p>

<h2>Nelineárne prahy pre horčík a PTH: kde asociácia platí</h2>

<p>Analýza obmedzenými kubickými splajnami ukázala, že vzťah sérového horčíka a PTH k rýchlej progresii CAC nie je lineárny:</p>

<ul>
  <li><strong>Sérový horčík – krivka tvaru L (p pre nelinearitu = 0,028):</strong> pri hodnotách pod bodom zlomu <strong>0,82 mmol/l</strong> pravdepodobnosť rýchlej progresie CAC s klesajúcou magneziémiou strmo rástla, zatiaľ čo nad hranicou 0,82 mmol/l sa ďalší pokles rizika stabilizoval do plató. V multivariabilnom logistickom modeli upravenom o vek, pohlavie, diabetes, hypertenziu, vstupnú eGFR, dialyzačný status, sérový vápnik, sérový fosfor a albumín bola hodnota horčíka pod 0,82 mmol/l spojená s viac než dvojnásobnou šancou rýchlej progresie CAC oproti hodnotám ≥ 0,82 mmol/l (<strong>upravený pomer šancí [OR] 2,18; 95 % IS 1,60 až 2,98; p &lt; 0,001</strong>; v jednorozmernej analýze OR 2,52; 95 % IS 1,88 až 3,38). Všimnime si prakticky dôležitý detail: identifikovaný prah 0,82 mmol/l leží nad konvenčnou laboratórnou dolnou hranicou normy (0,75 mmol/l), takže zvýšené riziko v tejto kohorte zahŕňalo aj pacientov v dolnom pásme bežného referenčného intervalu. [1]</li>
  <li><strong>Parathormón – krivka tvaru J (p pre nelinearitu = 0,015):</strong> do koncentrácie <strong>120 pg/ml</strong> rástlo riziko pozvoľna, nad prahom 120 pg/ml sa sklon krivky prudko zvýšil; pri veľmi nízkych hodnotách PTH autori pozorovali len štatisticky nevýznamný trend k vyššiemu riziku. V plne upravenom modeli bol vstupný PTH ≥ 120 pg/ml spojený s viac než dvojnásobnou šancou rýchlej progresie CAC oproti hodnotám pod 120 pg/ml (<strong>upravený OR 2,15; 95 % IS 1,58 až 2,92; p &lt; 0,001</strong>; jednorozmerne OR 2,45; 95 % IS 1,85 až 3,25). Medzi horčíkom a PTH sa pri súčasnom zaradení do modelu nepreukázala štatisticky významná interakcia (p pre interakciu = 0,298). [1]</li>
  <li><strong>Kyselina močová – približne lineárny vzťah (p pre nelinearitu = 0,382):</strong> každé zvýšenie o 50 µmol/l bolo v upravenom modeli spojené s hranične vyššou šancou rýchlej progresie CAC (<strong>upravený OR 1,14; 95 % IS 1,00 až 1,30; p = 0,048</strong>; jednorozmerne OR 1,20; 95 % IS 1,06 až 1,36; p = 0,005). Pri autormi deklarovanej Bonferroniho korekcii pre viacnásobné testovanie (p &lt; 0,017) však tento upravený odhad prísny prah štatistickej významnosti neprekročil. [1]</li>
</ul>

<p>Podskupinová analýza v plnom texte priniesla spresnenie, ktoré v sekundárnej správe chýba. Kým asociácia nižšieho sérového horčíka s rýchlou progresiou CAC bola konzistentná naprieč štádiami CKD (s miernym oslabením u dialyzovaných na OR 1,89), asociácia <strong>PTH ≥ 120 pg/ml bola štatisticky významná v štádiách CKD G4 až G5 a na dialýze (OR 2,62; 95 % IS 1,80 až 3,82), ale nie v štádiách CKD G1 až G3 (OR 1,42; 95 % IS 0,92 až 2,18)</strong>. Prah PTH 120 pg/ml teda v tejto práci odrážal predovšetkým metabolickú situáciu pokročilej nefropatie, kde už sekundárna hyperparatyreóza a fosfátová retencia pôsobia plnou silou. [1]</p>

<h2>Sedemfaktorový predikčný nomogram a jeho metodické úskalia</h2>

<p>Zo 34 vstupných kandidátnych premenných (vrátane sérového vápnika a fosforu) vybrala penalizovaná regresia LASSO pri optimálnom parametri penalizácie (λ<sub>1se</sub> v 10-násobnej krížovej validácii) sedem prediktorov. Tie autori vložili do multivariabilného logistického modelu a prepočítali na bodový nomogram s rozsahom od 0 do 180 bodov. [1]</p>

<div class="table-responsive" role="region" aria-label="Premenné a bodové ohodnotenie v 7-faktorovom predikčnom nomograme rýchlej progresie CAC" tabindex="0">
<table>
  <caption>Finálny multivariabilný logistický model a bodové priradenie v nomograme pre rýchlu progresiu CAC (Chen et al., 2026 [1]).</caption>
  <thead>
    <tr>
      <th scope="col">Prediktor v modeli</th>
      <th scope="col">LASSO koeficient</th>
      <th scope="col">Regresný koeficient β</th>
      <th scope="col">OR (95 % IS)</th>
      <th scope="col">p</th>
      <th scope="col">Body v nomograme</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Sérový horčík &lt; 0,82 mmol/l</th>
      <td>0,305</td>
      <td>0,845</td>
      <td>2,33 (1,70 až 3,20)</td>
      <td>&lt; 0,001</td>
      <td>35</td>
    </tr>
    <tr>
      <th scope="row">PTH ≥ 120 pg/ml</th>
      <td>0,282</td>
      <td>0,778</td>
      <td>2,18 (1,60 až 2,96)</td>
      <td>&lt; 0,001</td>
      <td>32</td>
    </tr>
    <tr>
      <th scope="row">Dialyzačná liečba (áno)</th>
      <td>0,238</td>
      <td>0,625</td>
      <td>1,87 (1,38 až 2,54)</td>
      <td>&lt; 0,001</td>
      <td>26</td>
    </tr>
    <tr>
      <th scope="row">Diabetes mellitus (áno)</th>
      <td>0,202</td>
      <td>0,538</td>
      <td>1,71 (1,30 až 2,26)</td>
      <td>&lt; 0,001</td>
      <td>22</td>
    </tr>
    <tr>
      <th scope="row">Vstupné CAC skóre (na každých +100 AU)</th>
      <td>0,292</td>
      <td>0,392</td>
      <td>1,48 (1,33 až 1,65)</td>
      <td>&lt; 0,001</td>
      <td>16</td>
    </tr>
    <tr>
      <th scope="row">Vek (na každých +10 rokov)</th>
      <td>0,078</td>
      <td>0,292</td>
      <td>1,34 (1,16 až 1,55)</td>
      <td>&lt; 0,001</td>
      <td>12</td>
    </tr>
    <tr>
      <th scope="row">Vstupná eGFR (na každých +10 ml/min/1,73 m²)</th>
      <td>−0,045</td>
      <td>−0,142</td>
      <td>0,87 (0,79 až 0,96)</td>
      <td>0,004</td>
      <td>−6</td>
    </tr>
  </tbody>
</table>
</div>

<p>Podľa súčtu bodov autori rozdelili pacientov do troch pásiem predpokladanej pravdepodobnosti rýchlej progresie CAC: <strong>nízke riziko</strong> (&lt; 45 bodov; predpokladaná pravdepodobnosť &lt; 10 %), <strong>stredné riziko</strong> (45 až 135 bodov; pravdepodobnosť 10 až 60 %) a <strong>vysoké riziko</strong> (&gt; 135 bodov; pravdepodobnosť &gt; 60 %). Optimálny prah podľa Youdenovho indexu predstavoval <strong>90 bodov</strong> so senzitivitou 75,0 %, špecificitou 72,5 %, pozitívnou prediktívnou hodnotou 68,5 % a negatívnou prediktívnou hodnotou 78,8 %. C-štatistika modelu dosiahla 0,802 (95 % IS 0,772 až 0,832) a po internej validácii pomocou 1 000 bootstrapových výberov klesla na korigovanú hodnotu <strong>0,789</strong> so sklonom kalibračnej krivky 0,93 (Hosmerov-Lemeshowov test p = 0,385). [1]</p>

<p>Pri kritickom čítaní primárnej publikácie vystupujú do popredia tri metodické body, ktoré bránia bezprostrednému prevzatiu nomogramu do bežnej ambulantnej praxe:</p>

<ol>
  <li><strong>Nejasné dosadzovanie eGFR u dialyzovaných pacientov:</strong> vo vstupnej tabuľke autori pre skupinu dialyzovaných pacientov uvádzajú eGFR ako neaplikovateľnú (<code>NA</code>), no vo finálnom modeli figuruje súčasne binárny ukazovateľ dialýzy (+26 bodov) aj kontinuálna hodnota eGFR (−6 bodov na každých +10 ml/min/1,73 m²) bez toho, aby text spresnil, aká číselná hodnota eGFR bola pri výpočte skóre priradená dialyzovaným pacientom.</li>
  <li><strong>Vyradenie vápnika a fosforu v LASSO regresii nie je biologický dôkaz:</strong> ako sami autori v diskusii pripúšťajú, nezaradenie sérového vápnika, fosforu a kyseliny močovej do finálneho nomogramu je dôsledkom štatistickej kolinearity so štádiom CKD, eGFR a PTH pri zvolenej penalizácii λ<sub>1se</sub>, nie dôkazom, že fosfátová záťaž je pri kalcifikácii nepodstatná. Práca navyše nekvantifikovala prídavnú diskriminačnú hodnotu (napríklad zmenu C-štatistiky alebo index čistej reklasifikácie) horčíka a PTH oproti štandardným parametrom CKD-MBD.</li>
  <li><strong>Absencia externej validácie:</strong> model vznikol a bol overený v jedinom centre na klinicky selektovanej čínskej populácii s opakovanými CT vyšetreniami hrudníka.</li>
</ol>

<h2>Patofyziologický kontext a konfrontácia s klinickými štúdiami</h2>

<p>Biologická vierohodnosť ochranného pôsobenia horčíka proti cievnej kalcifikácii je v experimentálnej literatúre dobre podložená. Horčík na fyzikálno-chemickej úrovni brzdí vyzrievanie amorfných kalcium-fosfátových precipitátov do termodynamicky stabilných kryštálov hydroxyapatitu a na bunkovej úrovni v ľudských aortálnych VSMC vystavených vysokým koncentráciám fosfátov tlmí osteogénnu transformáciu (znižuje expresiu dráh BMP-2 a NF-κB a chráni syntézu inhibítorov kalcifikácie vrátane matrixového Gla proteínu). [1]</p>

<p>Observačná asociácia medzi nižšou magneziémiou a rýchlejšou progresiou CAC však <strong>nie je dôkazom, že suplementácia horčíka u pacientov s CKD progresiu kalcifikácie spoľahlivo zastaví</strong>. Hoci samotná práca Chen et al. priame intervenčné štúdie s horčíkom podrobne nerozoberá, nefrologická literatúra už má k dispozícii systematický prehľad klinických skúšaní aj dve protichodné randomizované kontrolované štúdie u predialyzačných pacientov: [4–6]</p>

<div class="table-responsive" role="region" aria-label="Porovnanie randomizovaných štúdií perorálnej suplementácie horčíka pri predialyzačnej CKD" tabindex="0">
<table>
  <caption>Randomizované klinické štúdie hodnotiace vplyv perorálnej suplementácie horčíka na progresiu CAC pri predialyzačnej CKD.</caption>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Dizajn a populácia</th>
      <th scope="col">Intervencia a trvanie</th>
      <th scope="col">Hlavný výsledok (CAC)</th>
      <th scope="col">Bezpečnosť a obmedzenia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Sakaguchi et al., <em>JASN</em> 2019 [5]</th>
      <td>Otvorená RCT (2×2 faktoriálny dizajn); CKD G3 až G4 s rizikovými faktormi CAC; 125 zaradených, 96 dokončilo</td>
      <td>Oxid horečnatý (MgO, titrovaný na sérové Mg 1,03 až 1,23 mmol/l) ± perorálny uhlíkový adsorbent AST-120 počas 2 rokov (predčasne ukončené)</td>
      <td>Menší medián relatívnej zmeny CAC skóre v skupine s MgO oproti kontrole (<strong>11,3 % oproti 39,5 %</strong>; p &lt; 0,001); podiel s ročným nárastom ≥ 15 % bol 23,9 % oproti 62,0 %</td>
      <td>Otvorený dizajn a predčasné ukončenie po priebežnej analýze; bez účinku na kalcifikáciu hrudnej aorty; vyššie prerušenie liečby pre hnačku (27 % oproti 17 %)</td>
    </tr>
    <tr>
      <th scope="row">MAGiCAL-CKD (Bressendorff et al.), <em>JASN</em> 2023 [6]</th>
      <td>Dvojito zaslepená, placebom kontrolovaná RCT v Dánsku a Nórsku; 148 pacientov s eGFR 15 až 45 ml/min/1,73 m² (medián eGFR 25 ml/min/1,73 m²)</td>
      <td>Pomaly sa uvoľňujúci hydroxid horečnatý 15 mmol dvakrát denne (30 mmol/deň) oproti placebu počas 12 mesiacov</td>
      <td>Napriek významnému vzostupu plazmatického horčíka <strong>žiadny významný rozdiel vo výslednom CAC skóre</strong> po 12 mesiacoch (vstupný medián CAC 413 v ramene s Mg a 274 v placebe)</td>
      <td>Gastrointestinálne nežiaduce účinky u 35 zo 75 pacientov s Mg oproti 9 zo 73 s placebom; 5 úmrtí a 6 kardiovaskulárnych príhod v ramene s Mg oproti 2 úmrtiam a 0 príhodám v placebe</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kontrast medzi týmito dvoma prácami presne vymedzuje súčasný stav poznania. Otvorená japonská štúdia ukázala priaznivý signál, no rigoróznejšia dvojito zaslepená štúdia MAGiCAL-CKD po 12 mesiacoch účinok na progresiu CAC nepotvrdila a upozornila na gastrointestinálnu intoleranciu aj na numerickú nerovnováhu závažných udalostí. Systematický prehľad 77 klinických skúšaní zameraných na spomalenie cievnej kalcifikácie pri CKD (Xu et al., 2022) preto oprávnene uzavrel, že dôkazy pre väčšinu intervencií zostávajú nejednoznačné alebo založené na malých a krátkych štúdiách. [4–6]</p>

<h2>Čo výsledky znamenajú pre každodennú prax v kontexte KDIGO</h2>

<ol>
  <li><strong>Prah PTH ≥ 120 pg/ml nemožno mechanicky preklopiť na cieľovú hodnotu pre všetkých pacientov s CKD.</strong> Aktualizované odporúčania KDIGO pre CKD-MBD z roku 2017 zdôrazňujú, že u nedialyzovaných pacientov v štádiách CKD G3a až G5 optimálna koncentrácia intaktného PTH nie je známa; namiesto reakcie na jednu izolovanú hodnotu nad hornou hranicou normy sa má hodnotiť <strong>progresívne stúpajúci alebo trvalo zvýšený PTH</strong> a pátrať po modifikovateľných faktoroch (hyperfosfatémia, nadmerný príjem fosfátov, hypokalciémia, deficit vitamínu D), pričom rutinné podávanie kalcitriolu či analógov vitamínu D sa v predialyzačnej CKD neodporúča pre zvýšené riziko hyperkalciémie. U dialyzovaných pacientov (CKD G5D) KDIGO odporúča udržiavať iPTH v pásme približne <strong>2- až 9-násobku hornej hranice normy laboratória</strong> (približne 130 až 600 pg/ml). Prah 120 pg/ml zo štúdie Chen et al. teda u dialyzovaného pacienta leží tesne pod dolnou hranicou odporúčaného cieľového pásma. Snaha agresívne stlačiť PTH u dialyzovaného pacienta pod 120 pg/ml (napríklad vysokými dávkami kalcitriolu alebo kalciových viazačov) by hrozila navodením adynamickej kostnej choroby so zníženou schopnosťou kosti ukladať vápnik a fosfor, čo cievnu kalcifikáciu paradoxne urýchľuje. [1,7]</li>
  <li><strong>Prítomnosť vaskulárnej kalcifikácie mení výber viazačov fosfátov.</strong> Podľa odporúčaní KDIGO 2017 patrí pacient s CKD G3a až G5D a dokázanou cievnou alebo chlopňovou kalcifikáciou do kategórie najvyššieho kardiovaskulárneho rizika, u ktorej je opodstatnené obmedziť dávku viazačov fosfátov na báze vápnika. Rýchla progresia CAC už v štádiách CKD G4 až G5 (22,8 %/rok) v čínskej kohorte podporuje včasnú kontrolu fosfátovej záťaže ešte pred zaradením do dialyzačného programu. [1,7]</li>
  <li><strong>Sérový horčík pod 0,82 mmol/l je praktický varovný marker, nie automatická indikácia k vysokodávkovej suplementácii.</strong> Vyšetrenie magneziémie u pacienta s pokročilou CKD alebo na dialýze pomáha odhaliť nielen zjavnú hypomagneziémiu (&lt; 0,75 mmol/l), ale aj hodnoty v dolnom pásme normy, prípadne liekové vplyvy (napríklad dlhodobé užívanie inhibítorov protónovej pumpy alebo diuretík). Prípadná korekcia horčíka pri pokročilej CKD a na dialýze však vyžaduje opatrnosť, kontrolu sérových koncentrácií a zohľadnenie koncentrácie horčíka v dialyzačnom roztoku aj znášanlivosti v tráviacom trakte. [1,6]</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Jednocentrový retrospektívny dizajn a indikačné skreslenie:</strong> zaradenie vyžadovalo najmenej dve klinicky indikované CT vyšetrenia hrudníka. Súbor tak prednostne zachytil pacientov s vyššou kardiovaskulárnou záťažou alebo s klinickými ťažkosťami, čo obmedzuje zovšeobecnenie absolútnych mier progresie na neselektovanú ambulantnú populáciu s CKD. [1]</li>
  <li><strong>Technické obmedzenia CT protokolov:</strong> štúdia využívala klinicky indikované CT hrudníka a nešpecifikuje jednotné EKG hradlovanie (ECG-gating) pri všetkých vyšetreniach; pri nebránených skenoch hrudníka môžu pohybové artefakty zvýšiť variabilitu Agatstonovho skóre.</li>
  <li><strong>Jednorazové meranie biomarkerov na začiatku sledovania:</strong> horčík, PTH, kyselina močová, vápnik aj fosfor boli do modelov zahrnuté iba zo vstupného odberu. Napriek vylúčeniu 40 pacientov so zmenou suplementácie horčíka alebo viazačov fosfátov v posledných troch mesiacoch pred vstupom chýbali úplné údaje o zmenách farmakoterapie počas 6 až 36 mesiacov sledovania. [1]</li>
  <li><strong>Metodika odhadu filtrácie a špecifiká dialýzy:</strong> eGFR bola počítaná staršou rovnicou MDRD namiesto rovnice CKD-EPI a práca nerozlišuje modality dialýzy (hemodialýza oproti peritoneálnej dialýze), dĺžku dialyzačnej liečby ani koncentráciu vápnika a horčíka v dialyzačnom roztoku. [1]</li>
  <li><strong>Náhradný ukazovateľ bez hodnotenia klinických príhod:</strong> primárnym výstupom bola rádiologická progresia CAC skóre, nie výskyt infarktu myokardu, srdcového zlyhávania či kardiovaskulárnej mortality.</li>
  <li><strong>Chýbajúca externá validácia nomogramu:</strong> bodové skóre nebolo otestované v nezávislej multicentrickej ani európskej kohorte. [1]</li>
</ul>

<h2>Záver</h2>

<p>Longitudinálna štúdia 800 pacientov s CKD potvrdzuje, že progresia kalcifikácie koronárnych artérií výrazne zrýchľuje už v predialyzačných štádiách CKD G4 až G5 a vrcholí u dialyzovaných pacientov. Nízky sérový horčík pod 0,82 mmol/l a zvýšený PTH od 120 pg/ml (najmä v pokročilých štádiách G4 až G5D) identifikujú pacientov s viac než dvojnásobnou šancou rýchlej progresie CAC. Pre klinickú prax sú tieto prahy užitočným nástrojom rizikovej stratifikácie a dôvodom na dôslednú kontrolu parametrov CKD-MBD, samy osebe však nenahrádzajú cieľové pásma odporúčaní KDIGO ani nepreukazujú, že rutinná suplementácia horčíka zníži výskyt kardiovaskulárnych príhod.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani platné odborné odporúčania. Úpravu liečby porúch minerálového a kostného metabolizmu pri chronickej chorobe obličiek (vrátane viazačov fosfátov, kalcimimetík, vitamínu D a prípravkov horčíka) indikuje ošetrujúci lekár s prihliadnutím na štádium ochorenia a laboratórne trendy.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Yutong Chen, Wenhao Qiu, Yinglan Shu, Lifeng Lu, Yindeng Luo. Progression of coronary artery calcification in chronic kidney disease: nonlinear associations with serum magnesium and parathyroid hormone. <em>Frontiers in Medicine (Lausanne).</em> 2026;13:1910302. Publikované online 15. septembra 2026. DOI: <a href="https://doi.org/10.3389/fmed.2026.1910302" target="_blank" rel="noopener noreferrer">10.3389/fmed.2026.1910302</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42812376/" target="_blank" rel="noopener noreferrer">PubMed PMID 42812376</a>. PMC13619518. (Oprava afiliácie a poďakovania: <em>Front Med (Lausanne).</em> 2026;13:2003996. DOI: <a href="https://doi.org/10.3389/fmed.2026.2003996" target="_blank" rel="noopener noreferrer">10.3389/fmed.2026.2003996</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42871910/" target="_blank" rel="noopener noreferrer">PubMed PMID 42871910</a>.)</small></li>
  <li><small>Linda L. Demer, Yin Tintut. Vascular calcification: pathobiology of a multifaceted disease. <em>Circulation.</em> 2008;117(22):2938–2948. DOI: <a href="https://doi.org/10.1161/CIRCULATIONAHA.107.743161" target="_blank" rel="noopener noreferrer">10.1161/CIRCULATIONAHA.107.743161</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/18519861/" target="_blank" rel="noopener noreferrer">PubMed PMID 18519861</a>.</small></li>
  <li><small>Jolynn Tumolo. Coronary Artery Calcification Intensifies as Renal Function Declines. <em>Physicians Weekly.</em> Publikované 14. októbra 2026. Dostupné na: <a href="https://www.physiciansweekly.com/post/coronary-artery-calcification-intensifies-as-renal-function-declines" target="_blank" rel="noopener noreferrer">physiciansweekly.com</a>.</small></li>
  <li><small>Chelsea Xu, Edward R. Smith, Mark K. Tiong, Irene Ruderman, Nigel D. Toussaint. Interventions To Attenuate Vascular Calcification Progression in Chronic Kidney Disease: A Systematic Review of Clinical Trials. <em>Journal of the American Society of Nephrology.</em> 2022;33(5):1011–1032. DOI: <a href="https://doi.org/10.1681/ASN.2021101327" target="_blank" rel="noopener noreferrer">10.1681/ASN.2021101327</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35232774/" target="_blank" rel="noopener noreferrer">PubMed PMID 35232774</a>. PMC9063901.</small></li>
  <li><small>Yusuke Sakaguchi, Takayuki Hamano, Yoshitsugu Obi, Chikako Monden, Tatsufumi Oka, Satoshi Yamaguchi, Isao Matsui, Nobuhiro Hashimoto, Ayumi Matsumoto, Karin Shimada, Yoshitsugu Takabatake, Atsushi Takahashi, Jun-Ya Kaimori, Toshiki Moriyama, Ryohei Yamamoto, Masaru Horio, Koichi Yamamoto, Ken Sugimoto, Hiromi Rakugi, Yoshitaka Isaka. A Randomized Trial of Magnesium Oxide and Oral Carbon Adsorbent for Coronary Artery Calcification in Predialysis CKD. <em>Journal of the American Society of Nephrology.</em> 2019;30(6):1073–1085. DOI: <a href="https://doi.org/10.1681/ASN.2018111150" target="_blank" rel="noopener noreferrer">10.1681/ASN.2018111150</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31036759/" target="_blank" rel="noopener noreferrer">PubMed PMID 31036759</a>. PMC6551769.</small></li>
  <li><small>Iain Bressendorff, Ditte Hansen, Morten Schou, Charlotte Kragelund, My Svensson, Bahram Hashemi, Tilde Kristensen, Marie Houmaa Vrist, Rikke Borg, Birgitte Tougaard, Kristine Borg, Henrik Øder Hjortkjær, Cathrine Helgestad Kristiansen, Nicholas Carlson, Mohammad Nasiri, Haseem Ashraf, Andreas Pasch, Lisbet Brandi. The Effect of Magnesium Supplementation on Vascular Calcification in CKD: A Randomized Clinical Trial (MAGiCAL-CKD). <em>Journal of the American Society of Nephrology.</em> 2023;34(5):886–894. DOI: <a href="https://doi.org/10.1681/ASN.0000000000000092" target="_blank" rel="noopener noreferrer">10.1681/ASN.0000000000000092</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36749131/" target="_blank" rel="noopener noreferrer">PubMed PMID 36749131</a>. PMC10125639.</small></li>
  <li><small>Markus Ketteler, Geoffrey A. Block, Pieter Evenepoel, Masafumi Fukagawa, Charles A. Herzog, Linda McCann, Sharon M. Moe, Rukshana Shroff, Marcello A. Tonelli, Nigel D. Toussaint, Marc G. Vervloet, Mary B. Leonard. Executive summary of the 2017 KDIGO Chronic Kidney Disease-Mineral and Bone Disorder (CKD-MBD) Guideline Update: what's changed and why it matters. <em>Kidney International.</em> 2017;92(1):26–36. DOI: <a href="https://doi.org/10.1016/j.kint.2017.04.006" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2017.04.006</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28646995/" target="_blank" rel="noopener noreferrer">PubMed PMID 28646995</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Všetky číselné výsledky, štatistické odhady a vstupné charakteristiky boli overené priamo v plnom texte primárnej štúdie vo <em>Frontiers in Medicine</em> (vrátane opravy z 29. septembra 2026) a v databáze PubMed eutils k 18. októbru 2026. Oproti predlohe boli doplnené úplné autorské zoznamy všetkých citovaných prác v pôvodnom poradí, presná štruktúra kohorty (vylúčenie 74 zo 874 skrínovaných pacientov, 72,5 % zastúpenie štádií CKD G4 až G5 a dialýzy), upravené pomery šancí z multivariabilných modelov a bodové váhy všetkých siedmich prvkov nomogramu. Opravená bola nepresná formulácia predlohy o zaradení eGFR v nomograme (išlo o kontinuálnu premennú hodnotenú na každých +10 ml/min/1,73 m² so ziskom −6 bodov, nie o kategorickú premennú) a spresnený bol preklad kombinovaného kritéria rýchlej progresie CAC. Z plného textu bol doplnený kľúčový podskupinový nález, že prah PTH ≥ 120 pg/ml bol štatisticky významne spojený s rýchlou progresiou CAC iba v štádiách CKD G4 až G5 a na dialýze (OR 2,62), nie v štádiách G1 až G3 (OR 1,42). Autor projektu zároveň doplnil konfrontáciu s randomizovanými štúdiami suplementácie horčíka (Sakaguchi et al., 2019; MAGiCAL-CKD, 2023), zasadenie prahu PTH do cieľových pásiem KDIGO 2017 vrátane upozornenia na riziko adynamickej kostnej choroby a opravil chybnú pagináciu systematického prehľadu Xu et al. (2022), ktorú primárna publikácia uvádzala nesprávne ako strany 1201 až 1216 namiesto skutočných strán 1011 až 1032.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=dynamika-kalciemie-hemodialyza">Dynamika kalciémie pri hemodialýze: prečo nestačí jediný výsledok</a></li>
  <li><a href="article.php?slug=perzistujuca-hyperparatyreoza-po-transplantacii-oblicky">Perzistujúca hyperparatyreóza po transplantácii obličky ako rizikový marker mortality a zlyhania štepu</a></li>
  <li><a href="article.php?slug=tenapanor-vyssia-davka-kostna-resorpcia-crevna-pasaz">Ktorí dialyzovaní pacienti potrebujú vyššiu dávku tenapanoru? Úloha kostnej resorpcie a črevnej pasáže</a></li>
  <li><a href="article.php?slug=statiny-ckd-dialyza-gradient-prinosu-dokazy">Prečo prínos statínov klesá s pokročilosťou CKD: SHARP, 4D a AURORA</a></li>
  <li><a href="article.php?slug=esc-era-2026-kardiorenalne-odporucania">Odporúčania ESC/ERA 2026: spoločný plán starostlivosti o srdce a obličky</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
