<?php

/**
 * add_glp1-zapal-anemia-hemodialyza-real-world-evidencia_article.php
 * Odborný článok: observačná evidencia k agonistom GLP-1, zápalu a anémii
 * pri hemodialýze (Kidney Medicine 2026, doi 10.1016/j.xkme.2026.101476).
 *
 * Pôvodní autori spracovanej práce sú uvedení v source_authors.php.
 * Overené proti otvorenému plnému textu Kidney Medicine a záznamu Crossref.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-zapal-anemia-hemodialyza-real-world-evidencia_article.php"
 */

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
    'title'        => 'Agonisty receptora GLP-1, zápal a anémia u pacientov na hemodialýze: čo hovorí evidencia z reálnej praxe a ako to preložiť do praxe',
    'slug'         => 'glp1-zapal-anemia-hemodialyza-real-world-evidencia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'U 2 468 párovaných pacientov na hemodialýze sa začatie agonistu GLP-1 spájalo s nižším NLR, nižšou spotrebou ESA a podobným hemoglobínom. Observačné údaje nedokazujú kauzalitu a nahradiť ESA ani železo nemajú.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Agonisty receptora glukagónu podobného peptidu 1 (GLP-1) majú pri chronickej chorobe obličiek (CKD) doložený obličkový a srdcovocievny prínos v randomizovaných štúdiách, predovšetkým mimo dialýzy. Čo sa deje so zápalom a anémiou po ich začatí už pri hemodialýze, doteraz nebolo v prospektívnej štúdii overené. Nová retrospektívna práca v časopise Kidney Medicine prináša veľkú kohortu z reálnej praxe – a zároveň jasnú hranicu: ide o asociáciu, nie o dôkaz, že agonista GLP-1 „lieči anémiu“.</em></p>

<p>Lama a spoluautori porovnali dospelých so <strong>zlyhaním obličiek s náhradou funkcie (KFRT)</strong> na hemodialýze v sieti Fresenius Kidney Care v Spojených štátoch, u ktorých sa v období od 1. januára 2023 do 1. novembra 2024 začala liečba agonistom receptora GLP-1, s párovanými pacientmi bez tejto liečby. Sledovanie trvalo 12 mesiacov. Autori výslovne uvádzajú, že z observačného dizajnu <strong>nemožno odvodiť kauzalitu</strong>.</p>

<p>Tento článok je slovenské spracovanie uvedenej primárnej práce. Čísla sú overené proti otvorenému plnému textu v <em>Kidney Medicine</em> (článok 101476, doi 10.1016/j.xkme.2026.101476). Do praxe ich treba čítať popri platnom algoritme anémie podľa KDIGO 2026, nie namiesto neho.</p>

<h2>Čo štúdia skutočne porovnávala</h2>

<p>Z 76 011 dospelých na hemodialýze identifikovali 2 683 (3,5 %) pacientov so začatím agonistu GLP-1. Do analýzy vstúpilo <strong>2 468 párov</strong> po párovaní 1 : 1 podľa propensity skóre (skóre pravdepodobnosti začatia liečby) na základe demografických údajov, komorbidít a vstupných laboratórnych hodnôt. Ďalších 215 pacientov so začatím liečby (8,0 %) sa nepodarilo spárovať: išlo o klinických odľahlých pacientov s vyšším indexom telesnej hmotnosti (BMI 42,4 oproti 28,4 kg/m² v dostupnej kontrolnej skupine), mladším vekom a kratším dialyzačným vekom. Zistenia teda neplatia automaticky pre najťažšiu obezitu na dialýze.</p>

<p>Analýza bola <strong>podľa protokolu</strong>: vyžadovala neprerušenú hemodialýzu v stredisku počas 12 mesiacov od indexového dátumu a v liečenej skupine aj setrvanie na agoniste GLP-1 celých 365 dní. Vylúčení boli pacienti s neúplným sledovaním, zmenou modality, prerušením liečby, úmrtím alebo transplantáciou obličky. U liečených bol indexový dátum definovaný ako prvé zaznamenané podanie agonistu GLP-1; u kontrol bol index priradený tak, aby rozloženie dátumov zodpovedalo liečenej skupine.</p>

<p>Po párovaní boli skupiny vyvážené (absolútny štandardizovaný rozdiel &lt; 0,1). V spárovanej liečenej skupine bol vek 61,3 ± 11,9 roka, podiel žien 46,5 %, BMI 34,8 ± 8,2 kg/m² a diabetes 82,5 %. U párovaných nepoužívateľov vek 61,2 ± 13,1 roka, 46,6 % žien, BMI 35,3 ± 10,1 kg/m² a diabetes 85,6 %. Dialyzačný vek bol približne 2,5 roka. Trajektórie sa hodnotili lineárnymi zmiešanými modelmi s korekciou Bonferroniho.</p>

<h3>Ktoré látky vstúpili do kohorty</h3>

<p>Predpis zahŕňal semaglutid, tirzepatid, dulaglutid, liraglutid a exenatid, bez ohľadu na dávku a indikáciu. Novšie látky dominovali: <strong>semaglutid 48,1 %</strong>, <strong>dulaglutid 29,2 %</strong> a <strong>tirzepatid 14,3 %</strong>; liraglutid a exenatid spolu 8,4 %. Kohorta využívala predovšetkým injekčný semaglutid. Tirzepatid je duálny agonista receptorov GIP a GLP-1; v práci je zaradený do spoločnej skupiny „GLP-1RA“. Trvanie, dávka ani indikácia liečby pred začiatkom KFRT neboli k dispozícii. Autori medzi jednotlivými molekulami neporovnávali.</p>

<h2>Hlavné výsledky po 12 mesiacoch</h2>

<p>V liečenej skupine klesol pomer neutrofilov k lymfocytom (NLR) a počet leukocytov, mierne stúpol sérový albumín, boli vyššie ukazovatele železa a nižšia spotreba erytropoézu stimulujúcich látok (ESA). Hemoglobín sa v 12. mesiaci medzi skupinami prakticky nelíšil. Absolútne rozdiely sú malé; sami autori ich označujú za signály tvoriace hypotézu a klinický význam za neistý.</p>

<div class="table-responsive" role="region" aria-label="Dvanásťmesačné rozdiely medzi používateľmi agonistov GLP-1 a párovanými kontrolami" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ v 12. mesiaci</th>
      <th scope="col">GLP-1 RA</th>
      <th scope="col">Kontroly</th>
      <th scope="col">Stredný rozdiel (95 % CI)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">NLR</th>
      <td>3,97</td>
      <td>4,64</td>
      <td>−0,67 (−0,89 až −0,45)</td>
    </tr>
    <tr>
      <th scope="row">Leukocyty (× 10³/µl)</th>
      <td>7,21</td>
      <td>7,49</td>
      <td>−0,28 (−0,46 až −0,10)</td>
    </tr>
    <tr>
      <th scope="row">Albumín (g/dl)</th>
      <td>3,92</td>
      <td>3,86</td>
      <td>+0,06 (0,04 až 0,08)</td>
    </tr>
    <tr>
      <th scope="row">Ferritín (ng/ml)</th>
      <td>887,4</td>
      <td>846,9</td>
      <td>+40,50 (15,2 až 65,8)</td>
    </tr>
    <tr>
      <th scope="row">Saturácia transferínu (%)</th>
      <td>34,0</td>
      <td>32,3</td>
      <td>+1,7 (0,98 až 2,42)</td>
    </tr>
    <tr>
      <th scope="row">Sérové železo (µg/dl)</th>
      <td>77,3</td>
      <td>72,8</td>
      <td>+4,50 (2,92 až 6,08)</td>
    </tr>
    <tr>
      <th scope="row">Okamžitá dávka ESA (µg)</th>
      <td>29,1</td>
      <td>31,3</td>
      <td>−2,20 (−3,87 až −0,53)</td>
    </tr>
    <tr>
      <th scope="row">Kumulatívna dávka ESA za 12 mesiacov (µg)</th>
      <td>1 881,9</td>
      <td>2 005,8</td>
      <td>−123,9 (−201,7 až −46,1)</td>
    </tr>
    <tr>
      <th scope="row">Index rezistencie na erytropoetín (ERI)</th>
      <td>3,31</td>
      <td>3,63</td>
      <td>−0,32 (−0,54 až −0,10)</td>
    </tr>
    <tr>
      <th scope="row">Hemoglobín (g/dl)</th>
      <td>10,90</td>
      <td>10,84</td>
      <td>+0,06 (−0,004 až 0,12)</td>
    </tr>
    <tr>
      <th scope="row">IV železo na podanie (mg)</th>
      <td>74,2</td>
      <td>76,4</td>
      <td>−2,20 (−3,79 až −0,61)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Dávky ESA sú prepočítané na ekvivalent metoxy-polyetylénglykol-epoetínu beta (Mircera): darbepoetín µg/1,28; epoetín alfa µg/244,51. ERI autori počítali z týždennej dávky ESA delenej hmotnosťou a priemerným hemoglobínom; ide o kompozitnú mieru odpovede na ESA, nie o percento. NLR sa začal rozchádzať už v 2. mesiaci a rozdiel pretrval do 12. mesiaca. Leukocyty boli nižšie od 6. mesiaca. ERI sa oddelil od 3. mesiaca (3,26 oproti 3,60) a v 12. mesiaci zostal nižší.</p>

<p>Hemoglobín bol v liečenej skupine vyšší v 2. a 3. mesiaci; v 12. mesiaci interval spoľahlivosti stredného rozdielu nulu zahŕňa. Tvrdenie o „zlepšení anémie“ sa teda nemôže opierať o trvalý vzostup hemoglobínu, ale nanajvýš o podobný hemoglobín pri nižšej kumulatívnej spotrebe ESA a nižšom ERI.</p>

<p>Analýzy citlivosti s časovo premenlivou úpravou na telesnú hmotnosť a dávku intravenózneho železa trajektórie podstatne nezmenili.</p>

<h2>Čo z toho nevyplýva</h2>

<ul>
  <li><strong>Agonista GLP-1 nie je liekom na anémiu pri KFRT.</strong> Štúdia nemerala tvrdé klinické ukazovatele anémie (transfúzie, hospitalizácie, kvalitu života) a hemoglobín sa v 12. mesiaci nelíšil.</li>
  <li><strong>ESA a železo ostávajú štandardom.</strong> Nižšia bodová a kumulatívna dávka ESA nie je dôvodom na vysadenie ani na odklon od algoritmu KDIGO 2026. Rozhodovanie o železe, ESA a inhibítoroch HIF-prolylhydroxylázy sa riadi diagnostikou, bezpečnosťou a zdieľaným rozhodovaním – nie predpisom agonistu GLP-1.</li>
  <li><strong>Ferritín nie je čistý ukazovateľ zásob železa.</strong> Pri hemodialýze je súčasne reaktantom akútnej fázy. V 12. mesiaci bol ferritín v oboch skupinách nad 800 ng/ml (887,4 oproti 846,9 ng/ml), teda v pásme, kde KDIGO/KDOQI pri HD bežne zadržiava rutinné železo pri ferritíne &gt; 700 ng/ml. Saturácia transferínu ostala pod 40 % (34,0 % oproti 32,3 %). Vyšší ferritín tu nemožno čítať ako „lepšie zásoby“, ktoré treba ešte dopĺňať.</li>
  <li><strong>Chýba hs-CRP.</strong> Vysoko citlivý C-reaktívny proteín (hs-CRP) sa v americkej dialyzačnej populácii bežne nemeria. Bez neho nemožno oddeliť zmenu metabolizmu železa od zmeny zápalu. NLR a počet leukocytov sú len náhradné ukazovatele.</li>
  <li><strong>Porovnanie je voči nepoužívateľom, nie voči inému antidiabetiku.</strong> Používanie inhibítorov DPP-4 bolo približne vyvážené (11,1 % oproti 9,8 %), aktívny komparátor však chýba. Časť rozdielu môže odrážať výber pacientov na agonistu GLP-1, nie účinok lieku.</li>
</ul>

<h2>Obmedzenia, ktoré treba pomenovať pred praxou</h2>

<p>Autori uvádzajú niekoľko obmedzení, ktoré interpretáciu priamo zužujú:</p>

<ul>
  <li><strong>Zvyškové skreslenie</strong> napriek párovaniu podľa propensity skóre. Do modelu vstúpili aj laboratórne premenné, ktoré môžu ležať na kauzálnej dráhe medzi zápalom a spotrebou ESA – to môže asociáciu zoslabiť.</li>
  <li><strong>Skreslenie prežitím:</strong> 12 mesiacov neprerušeného sledovania a vylúčenie úmrtí, transplantácií, zmeny modality aj prerušenia liečby vyberá pacientov, ktorí liečbu aj dialýzu „vydržali“.</li>
  <li><strong>Skreslenie zdravého používateľa</strong> a výberu liečby: hľadanie zdravotnej starostlivosti, predpisovacie zvyky a socioekonomické rozdiely sa plne zachytiť nedajú. Používatelia agonistu GLP-1 môžu byť relatívne zdravšou skupinou.</li>
  <li><strong>Chýbajú údaje pred KFRT</strong> o type, dávke, indikácii a trvaní agonistu GLP-1; adherenciu v priebehu roka súbor neumožnil hodnotiť. Medzi molekulami a dávkami autori nerozlišovali, hoci prevažoval semaglutid.</li>
  <li>Domáce lieky v dialyzačnej ambulancii nie sú vždy spoľahlivo zachytené. Diferenciálny krvný obraz sa nemeria každý mesiac, preto mesačné priemery NLR môžu kolísať.</li>
  <li>Absolútna veľkosť zmien je skromná. Smerovo sú výsledky konzistentné naprieč viacerými ukazovateľmi; to ešte nerobí z NLR ani z kumulatívnej dávky ESA náhradu klinického výsledku.</li>
</ul>

<p>Práca nemala externé financovanie; analýzu interne podporila spoločnosť Fresenius Medical Care. Väčšina autorov je zamestnancami alebo spolupracovníkmi Renal Research Institute, dcérskej spoločnosti Fresenius. To nevylučuje užitočnosť údajov, ale patrí k čítaniu konfliktu záujmov.</p>

<h2>Ako to preložiť do nefrologickej praxe</h2>

<p>Praktický záver je úzky a opatrný.</p>

<p><strong>Ak pacient na hemodialýze už má indikáciu agonistu GLP-1</strong> – diabetes 2. typu, obezita, srdcovocievne riziko v rámci schválenej indikácie a tolerancie – tieto údaje podporujú hypotézu, že súčasne môžu klesnúť náhradné zápalové ukazovatele a spotreba ESA pri podobnom hemoglobíne. Nie sú dôvodom začať agonistu GLP-1 <em>kvôli anémii</em>.</p>

<p><strong>Ak pacient agonistu GLP-1 nemá</strong>, anémia sa naďalej rieši podľa KDIGO 2026: potvrdenie anémie, hľadanie reverzibilných príčin, železo podľa ferritínu a saturácie transferínu s bezpečnostnými hranicami pri HD, potom ESA alebo HIF-PHI so zdieľaným rozhodovaním. Nižší ERI v observačnej kohorte tento algoritmus nemení.</p>

<p>Pri už prebiehajúcej liečbe agonistom GLP-1 na dialýze ostáva v popredí bezpečnosť: gastrointestinálna znášanlivosť, príjem bielkovín a energie, riziko úbytku svalovej hmoty, objem a glykémia. Protokolu tejto štúdie zodpovedá práve pacient, ktorý liek 12 mesiacov neprerušil – nie ten, kto ho pre neznášanlivosť vysadil.</p>

<p>Obličkový prínos semaglutidu pri CKD mimo dialýzy (štúdia FLOW) a evidencia z reálnej praxe pri už prebiehajúcej hemodialýze sú <strong>dve rôzne roviny dôkazu</strong>. FLOW nemerala hs-CRP a nebola štúdiou anémie pri KFRT. Túto prácu preto nemožno čítať ako „FLOW pre dialýzu“, ani ako dôkaz, že nižší zápal vysvetľuje obličkový alebo srdcovocievny účinok.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=anemia-ckd-kdigo-2026-kdoqi-komentar">Anémia pri CKD podľa KDIGO 2026: čo prináša KDOQI US Commentary do praxe</a></li>
  <li><a href="article.php?slug=anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi">Anémia pri CKD 2026 prakticky: algoritmus od diagnostiky po ESA a HIF-PHI</a></li>
  <li><a href="article.php?slug=anemia-ckd-checklist-kdigo-2026-kdoqi">Checklist: anémia pri CKD podľa KDIGO 2026 a KDOQI</a></li>
  <li><a href="article.php?slug=anemia-ckd-dialyza-ambulancia-checklist">Checklist: anémia pri CKD pre dialýzu aj ambulanciu</a></li>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">Sú GLP-1 lieky už „lieky na obličky“? Renálne benefity v dôkazoch a praxi</a></li>
  <li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber SGLT2, agonistov GLP-1 a duálnych agonistov pri kardiorenálnom riziku</a></li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko CKD pri diabete 2. typu: porovnanie agonistov GLP-1 v reálnej praxi</a></li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilom CKD a dialýze</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Lama S, Chaudhuri S, Blankenship D, Nandorine Ban A, Usvyat L, Pecoits-Filho R, Hippen BE.</strong> <em>Real-World Evidence for Improvements in Inflammation and Anemia Biomarkers After the Initiation of GLP-1RA in Patients on Hemodialysis.</em> Kidney Medicine. 2026; article 101476 (journal pre-proof, online 17. júla 2026). doi: 10.1016/j.xkme.2026.101476. Otvorený prístup (CC BY 4.0). <a href="https://www.kidneymedicinejournal.org/article/S2590-0595(26)00238-4/fulltext" target="_blank" rel="noopener noreferrer">Plný text</a>; <a href="https://doi.org/10.1016/j.xkme.2026.101476" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, a spol.; FLOW Trial Committees and Investigators.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> N Engl J Med. 2024;391(2):109–121. doi: 10.1056/NEJMoa2403347. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">Štúdia FLOW</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Anemia Work Group.</strong> <em>KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in Chronic Kidney Disease.</em> Citované ako platný klinický rámec anémie na tomto portáli; táto práca ho nemení. <a href="https://pubmed.ncbi.nlm.nih.gov/41485807/" target="_blank" rel="noopener noreferrer">PubMed (executive summary)</a>; komentár KDOQI: <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext" target="_blank" rel="noopener noreferrer">AJKD</a>.</li>
  <li><strong>Choudhury J (ed.).</strong> <em>GLP-1s May Improve Inflammation, Anemia in Dialysis Patients.</em> Medscape Medical News, 27. augusta 2026. Sekundárne spravodajské spracovanie; čísla v článku sa opierajú o primárny text Kidney Medicine, nie o Medscape. <a href="https://www.medscape.com/viewarticle/glp-1s-may-improve-inflammation-anemia-dialysis-patients-2026a1000twd" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Zdroj:</strong> Lama S, Chaudhuri S, Blankenship D, Nandorine Ban A, Usvyat L, Pecoits-Filho R, Hippen BE. Real-World Evidence for Improvements in Inflammation and Anemia Biomarkers After the Initiation of GLP-1RA in Patients on Hemodialysis. <em>Kidney Medicine</em> (2026). <a href="https://www.kidneymedicinejournal.org/article/S2590-0595(26)00238-4/fulltext" target="_blank" rel="noopener noreferrer">kidneymedicinejournal.org</a>.</em></p>

<p><em><strong>Poznámka k spracovaniu:</strong> Primárnym zdrojom je otvorený plný text v <em>Kidney Medicine</em> (doi 10.1016/j.xkme.2026.101476, PII S2590-0595(26)00238-4). Autorstvo siedmich osôb overené cez Crossref 2026-09-03 (given/family: Suman Lama, Sheetal Chaudhuri, Derek Blankenship, Andrea Nandorine Ban, Len Usvyat, Roberto Pecoits-Filho, Benjamin E. Hippen) a zhoduje sa so sekciou Authors’ Full Names v plnom texte. K 3. septembru 2026 ešte nebolo PMID v PubMed ani v Europe PMC (in-press / journal pre-proof). Kumulatívna dávka ESA je v naratíve výsledkov 1 881,9 oproti 2 005,8 µg (stredný rozdiel −123,9 µg; 95 % CI −201,7 až −46,1); tabuľka 3 uvádza zaokrúhlenie 1 882,00 oproti 2 005,80 µg a −123,80 (−201,70 až −45,90). V článku používame naratívne čísla autorov. Medscape (editor Javed Choudhury) nie je spracovaný zdroj – k autorom widgetu sa nepridáva. Vek 61,3 roka a 46,5 % žien patrí spárovanej liečenej skupine v tabuľke 1, nie celej nespárovanej kohorte iniciátorov (2 683).</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Článok je odborné spracovanie observačnej asociácie, nie liečebný protokol ani indikačné rozšírenie agonistov GLP-1 o anémiu. Štandardom anémie pri CKD ostáva KDIGO 2026. Voľba agonistu GLP-1 pri hemodialýze patrí ošetrujúcemu lekárovi podľa schválenej indikácie, súhrnu charakteristických vlastností lieku, nutrície, znášanlivosti a komorbidít.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glp1-zapal-anemia-hemodialyza-real-world-evidencia_article',
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
