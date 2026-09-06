<?php

/**
 * add_nerozpoznana-ckd-hypertenzia-kardiovaskularne-ochorenie_article.php
 * Nerozpoznana CKD u pacientov s hypertenziou a KV ochorenim -
 * konferencny abstrakt Tangri a spol. + recenzovana studia REVEAL-CKD.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Chronická choroba obličiek zostáva u pacientov s hypertenziou a kardiovaskulárnym ochorením často nerozpoznaná',
    'slug'         => 'nerozpoznana-ckd-hypertenzia-kardiovaskularne-ochorenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dve tretiny rizikových pacientov bez diabetu s opakovane zníženou eGFR nemali zaznamenanú diagnózu CKD. Recenzovaná štúdia REVEAL-CKD ukazuje, že v Európe je situácia ešte horšia — a že najčastejšie unikajú ženy.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Diagnostický kód sám osebe nikoho nevylieči. Je však podmienkou toho, aby bola choroba obličiek viditeľná pre všetkých, ktorí o pacientovi rozhodujú — od predpisovania dávok po indikáciu kontrastného vyšetrenia. Práve v tomto bode zlyhávame najčastejšie u pacientov, ktorí nemajú diabetes.</em></p>

<p>Chronická choroba obličiek patrí medzi najčastejšie, ale zároveň najčastejšie nerozpoznané chronické ochorenia. Analýza amerických elektronických zdravotných záznamov prezentovaná na Kidney Week ukázala, že diagnóza nebola zaznamenaná približne u <strong>dvoch tretín</strong> pacientov, ktorí mali hypertenziu alebo kardiovaskulárne ochorenie a súčasne opakovane zníženú odhadovanú glomerulovú filtráciu. Poddiagnostikovanie bolo výraznejšie u pacientov bez diabetu 2. typu.</p>

<p>Rovnaká výskumná skupina publikovala rozsiahlejšiu, recenzovanú medzinárodnú analýzu <strong>REVEAL-CKD</strong>, ktorá tento nález potvrdzuje a v európskych krajinách nachádza ešte horší obraz. Práve tá je pre nás relevantnejšia než americké údaje.</p>

<h2>Čo skúmala americká analýza</h2>

<p>Navdeep Tangri a spolupracovníci analyzovali údaje z americkej databázy elektronických zdravotných záznamov TriNetX za roky 2015 až 2020. Zaradili dospelých pacientov, ktorí mali dve po sebe nasledujúce hodnoty odhadovanej glomerulovej filtrácie (eGFR) od 30 do menej ako 60 ml/min/1,73 m², merané s odstupom 91 až 730 dní. Takéto hodnoty zodpovedajú kategóriám <strong>G3a</strong> (45 – 59) a <strong>G3b</strong> (30 – 44 ml/min/1,73 m²).</p>

<p>Za nerozpoznanú chronickú chorobu obličiek autori považovali stav, pri ktorom nebol v dokumentácii zaznamenaný diagnostický kód CKD pred druhým meraním eGFR ani počas nasledujúcich šiestich mesiacov. Pacientov rozdelili do štyroch skupín:</p>

<div class="table-responsive" role="region" aria-label="Podiel pacientov bez zaznamenanej diagnózy CKD" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Skupina pacientov</th>
        <th scope="col">CKD bez zaznamenanej diagnózy</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Hypertenzia bez diabetu 2. typu</th><td>68,4 %</td></tr>
      <tr><th scope="row">Hypertenzia alebo aterosklerotické KV ochorenie bez diabetu 2. typu</th><td>68,7 %</td></tr>
      <tr><th scope="row">Hypertenzia alebo srdcové zlyhávanie bez diabetu 2. typu</th><td>68,6 %</td></tr>
      <tr><th scope="row">Diabetes 2. typu</th><td>51,7 %</td></tr>
    </tbody>
  </table>
</div>

<p>CKD teda nebola zaznamenaná približne u dvoch tretín rizikových pacientov bez diabetu. Aj medzi pacientmi s diabetom zostala bez diagnostického kódu viac než polovica prípadov. Rozdiel pravdepodobne súvisí s tým, že pri diabete sa funkcia obličiek a albuminúria kontrolujú systematickejšie — hypertenzia, ischemická choroba srdca alebo srdcové zlyhávanie zrejme stále nevedú k rovnako dôslednému nefrologickému hodnoteniu.</p>

<h2>REVEAL-CKD: recenzované medzinárodné údaje</h2>

<p>Tie isté kritériá — dve po sebe idúce hodnoty eGFR 30 až menej ako 60 ml/min/1,73 m² a chýbajúci diagnostický kód pred druhým meraním aj šesť mesiacov po ňom — použila štúdia REVEAL-CKD, publikovaná v recenzovanom časopise <em>BMJ Open</em>. Zahrnula šesť databáz v piatich krajinách:</p>

<div class="table-responsive" role="region" aria-label="Prevalencia nerozpoznanej CKD kategórie G3 podľa krajiny" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Krajina / databáza</th>
        <th scope="col">Nerozpoznaná CKD G3</th>
        <th scope="col">Počet pacientov</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Francúzsko</th><td>95,5 %</td><td>19 120 / 20 012</td></tr>
      <tr><th scope="row">Japonsko</th><td>92,1 %</td><td>83 693 / 90 902</td></tr>
      <tr><th scope="row">Nemecko</th><td>84,3 %</td><td>22 557 / 26 767</td></tr>
      <tr><th scope="row">Taliansko</th><td>77,0 %</td><td>50 547 / 65 676</td></tr>
      <tr><th scope="row">USA — TriNetX</th><td>64,3 %</td><td>161 254 / 250 879</td></tr>
      <tr><th scope="row">USA — Explorys</th><td>61,6 %</td><td>13 845 / 22 470</td></tr>
    </tbody>
  </table>
</div>

<p>Európske čísla sú horšie než americké — vo Francúzsku nemalo diagnózu <strong>viac než deväť z desiatich</strong> pacientov s laboratórne definovanou CKD kategórie G3. Rozdiely medzi krajinami pravdepodobne odrážajú aj odlišné kódovacie zvyklosti a spôsob úhrady, nie iba klinickú prax; interpretovať ich ako priame porovnanie kvality starostlivosti by bolo neopatrné. Poradie však varuje pred predstavou, že ide o americký problém.</p>

<h3>Komu diagnóza uniká najčastejšie</h3>

<p>REVEAL-CKD identifikovala faktory spojené s chýbajúcou diagnózou (rozpätie pomerov šancí naprieč krajinami):</p>

<ul>
  <li><strong>ženské pohlavie</strong> oproti mužskému: OR 1,29 – 1,77,</li>
  <li>kategória <strong>G3a</strong> oproti G3b: OR 1,81 – 3,66,</li>
  <li><strong>neprítomnosť diabetu</strong> v anamnéze: OR 1,26 – 2,77,</li>
  <li><strong>neprítomnosť hypertenzie</strong> v anamnéze: OR 1,35 – 1,78.</li>
</ul>

<p>Prevalencia nerozpoznanej CKD navyše stúpala s vekom. Nález o ženskom pohlaví si zaslúži osobitnú pozornosť: rovnaká laboratórna hodnota u ženy vedie k diagnóze menej často než u muža. Časť rozdielu môže súvisieť s tým, že ženy majú pri rovnakej eGFR nižší sérový kreatinín a nález sa preto vníma ako menej alarmujúci — ide však o skreslenie interpretácie, nie o biologické opodstatnenie.</p>

<h2>Čo výsledok skutočne znamená</h2>

<p>Obidve analýzy preukázali predovšetkým <strong>neprítomnosť diagnostického kódu CKD v elektronickej zdravotnej dokumentácii</strong>. Nezisťovali priamo, či:</p>

<ul>
  <li>lekár pokles funkcie obličiek rozpoznal,</li>
  <li>pacient bol o náleze informovaný,</li>
  <li>bola CKD uvedená iba vo voľnom texte,</li>
  <li>sa funkcia obličiek zohľadnila pri liečbe,</li>
  <li>bol pacient odoslaný na nefrologické vyšetrenie.</li>
</ul>

<p>Pojem „nediagnostikovaná CKD“ preto treba interpretovať opatrne. Presnejšie ide o <strong>CKD bez zachyteného diagnostického kódu</strong> v analyzovanej databáze. Administratívne nezaznamenanie diagnózy nie je vždy totožné s úplným klinickým nerozpoznaním ochorenia.</p>

<p>Napriek tomu je takýto nedostatok významný. Ak CKD nie je jasne uvedená v dokumentácii, zvyšuje sa riziko, že nebude dôsledne sledovaná, nebude správne hodnotená albuminúria a nebude využitá liečba ovplyvňujúca renálne a kardiovaskulárne riziko.</p>

<h2>Bola chronická choroba obličiek potvrdená správne?</h2>

<p>Podľa KDIGO je CKD definovaná abnormalitou štruktúry alebo funkcie obličiek, ktorá trvá najmenej tri mesiace a má zdravotné dôsledky. Dve hodnoty eGFR od 30 do menej ako 60 ml/min/1,73 m² s odstupom najmenej 91 dní podporujú diagnózu CKD a spĺňajú základnú požiadavku chronickosti.</p>

<p>Údaje však neumožňujú úplne vylúčiť prechodný pokles eGFR súvisiaci napríklad s akútnym poškodením obličiek, infekciou, dehydratáciou, hemodynamickou zmenou alebo liečbou. Riziko nesprávnej klasifikácie je väčšie najmä vtedy, keď boli dve merania od seba vzdialené takmer dva roky a medzi nimi neboli dostupné ďalšie výsledky.</p>

<h2>Označenie „včasná CKD“ nie je úplne presné</h2>

<p>Pôvodná práca používa označenie <em>early CKD</em>. Analyzovaní pacienti však mali CKD kategórie G3a alebo G3b, pričom najmä <strong>G3b už predstavuje klinicky významné zníženie funkcie obličiek</strong>, ktoré nemožno bez výhrad označiť za skoré štádium.</p>

<p>Kategórie G1 a G2, pri ktorých môže byť eGFR normálna alebo iba mierne znížená, možno diagnostikovať len pri prítomnosti iného znaku poškodenia obličiek, najčastejšie albuminúrie. Tieto skoršie formy CKD analýza nezachytávala — skutočný rozsah nerozpoznanej CKD teda môže byť ešte väčší, hoci to skúmané výsledky samy osebe nedokazujú.</p>

<h2>Chýbajúce hodnotenie albuminúrie</h2>

<p>Základným nedostatkom oboch analýz je absencia podrobného hodnotenia albuminúrie. Správne vyšetrenie pacienta s rizikom CKD má zahŕňať stanovenie sérového kreatinínu s výpočtom eGFR <strong>aj</strong> pomer albumínu ku kreatinínu v jednorazovej vzorke moču (UACR):</p>

<div class="table-responsive" role="region" aria-label="Kategórie albuminúrie podľa KDIGO" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Kategória</th>
        <th scope="col">UACR (mg/mmol)</th>
        <th scope="col">UACR (mg/g)</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">A1</th><td>&lt; 3</td><td>&lt; 30</td></tr>
      <tr><th scope="row">A2</th><td>3 – 30</td><td>30 – 300</td></tr>
      <tr><th scope="row">A3</th><td>&gt; 30</td><td>&gt; 300</td></tr>
    </tbody>
  </table>
</div>

<p>Albuminúria je samostatným ukazovateľom rizika progresie CKD, akútneho poškodenia obličiek, srdcového zlyhávania, aterosklerotických príhod a mortality. Pacient s eGFR 55 ml/min/1,73 m² a výraznou albuminúriou má zásadne odlišnú prognózu než pacient s rovnakou eGFR bez albuminúrie. <strong>Samotná eGFR preto nestačí na úplnú klasifikáciu CKD ani na spoľahlivé stanovenie prognózy.</strong></p>

<h2>Obojsmerný vzťah hypertenzie a CKD</h2>

<p>Hypertenzia môže byť príčinou aj následkom chronickej choroby obličiek. Dlhodobo zvýšený krvný tlak poškodzuje malé renálne artérie a glomeruly. Naopak, pokles funkcie obličiek podporuje retenciu sodíka, objemovú expanziu, aktiváciu systému renín-angiotenzín-aldosterón a zvýšenie aktivity sympatikového nervového systému.</p>

<p>Vzniká bludný kruh: <strong>hypertenzia → poškodenie obličiek → retencia sodíka a neurohumorálna aktivácia → ďalšie zvýšenie krvného tlaku</strong>. Znížená eGFR a albuminúria zároveň podstatne zvyšujú kardiovaskulárne riziko, takže CKD nemožno chápať ako izolovaný renálny problém.</p>

<h2>Prečo je zaznamenanie diagnózy dôležité</h2>

<p>Správne rozpoznaná a klasifikovaná CKD môže ovplyvniť:</p>

<ul>
  <li>výber a dávkovanie liekov,</li>
  <li>prevenciu nefrotoxicity,</li>
  <li>použitie blokády systému renín-angiotenzín,</li>
  <li>indikáciu inhibítora SGLT2,</li>
  <li>intenzitu kontroly krvného tlaku,</li>
  <li>frekvenciu laboratórneho monitorovania,</li>
  <li>hodnotenie kardiovaskulárneho rizika,</li>
  <li>prípravu na vyšetrenia s kontrastnou látkou,</li>
  <li>včasné odoslanie k nefrológovi.</li>
</ul>

<p>Diagnostický kód sám osebe výsledky pacienta nezlepší. Je však predpokladom, aby sa CKD stala <strong>viditeľnou</strong> pre všetkých zdravotníkov, ktorí sa podieľajú na starostlivosti — vrátane tých, ktorí pacienta nikdy nevideli a rozhodujú iba podľa dokumentácie.</p>

<h2>Možnosti spomalenia progresie</h2>

<p>Moderná liečba CKD nie je obmedzená na pacientov s diabetom. Podľa individuálneho klinického profilu zahŕňa optimalizáciu krvného tlaku, obmedzenie nadmerného príjmu sodíka, nefajčenie a pravidelnú pohybovú aktivitu, liečbu obezity a dyslipidémie, inhibítor ACE alebo blokátor receptora AT1 (najmä pri albuminúrii), inhibítor SGLT2 u vhodných pacientov, prevenciu opakovaného akútneho poškodenia obličiek a kontrolu anémie, minerálovej a kostnej poruchy a metabolickej acidózy podľa štádia ochorenia.</p>

<p>Randomizované štúdie DAPA-CKD a EMPA-KIDNEY preukázali renálny prínos inhibítorov SGLT2 aj u pacientov bez diabetu. Účinok však nemožno automaticky preniesť na každého človeka so zníženou eGFR — rozhodujú konkrétna eGFR, albuminúria, príčina CKD, kontraindikácie a celkový klinický stav.</p>

<h2>Koho treba cielene vyšetriť</h2>

<p>Systematické hodnotenie CKD je odôvodnené najmä u pacientov s hypertenziou, diabetom, srdcovým zlyhávaním, aterosklerotickým kardiovaskulárnym ochorením, obezitou, prekonaným akútnym poškodením obličiek, opakovanými infekciami alebo obštrukciou močových ciest, autoimunitným či systémovým ochorením, rodinnou anamnézou choroby obličiek alebo dlhodobou expozíciou nefrotoxickým liekom.</p>

<p>Vyšetrenie má zahŕňať <strong>eGFR aj UACR</strong>. Abnormálny výsledok treba potvrdiť opakovaným vyšetrením a interpretovať v klinickom kontexte.</p>

<h2>Obmedzenia</h2>

<p>Americká analýza bola prezentovaná ako <strong>konferenčný abstrakt</strong>, nie ako kompletná recenzovaná pôvodná práca s podrobnou metodikou. Hlavné obmedzenia oboch analýz sú:</p>

<ul>
  <li>závislosť od správnosti a úplnosti elektronických zdravotných záznamov,</li>
  <li>stotožnenie chýbajúceho diagnostického kódu s nerozpoznaným ochorením,</li>
  <li>výber iba pacientov s najmenej dvoma dostupnými meraniami eGFR — teda tých, ktorých už niekto vyšetroval,</li>
  <li>chýbajúce podrobnosti o albuminúrii a etiológii CKD,</li>
  <li>možné zvyškové ovplyvnenie výsledkov vekom, pohlavím, etnicitou a komorbiditami,</li>
  <li>nemožnosť posúdiť kvalitu následnej liečby,</li>
  <li>rozdielne kódovacie a úhradové zvyklosti medzi krajinami,</li>
  <li>financovanie spoločnosťou AstraZeneca; viacerí spoluautori sú jej zamestnancami.</li>
</ul>

<p>Výsledky nemožno chápať ako prevalenciu nerozpoznanej CKD v celej populácii. Týkajú sa vybranej skupiny pacientov, ktorí mali opakovane vykonanú eGFR a spĺňali definované kritériá — teda pravdepodobne skôr <strong>podhodnotenia</strong> skutočného problému.</p>

<h2>Záver</h2>

<p>Približne 68 % pacientov s hypertenziou alebo kardiovaskulárnym ochorením bez diabetu 2. typu, ktorí mali dvakrát zaznamenanú eGFR od 30 do menej ako 60 ml/min/1,73 m², nemalo v elektronickej dokumentácii uvedenú diagnózu CKD. U pacientov s diabetom predstavoval tento podiel približne 52 %. Recenzovaná medzinárodná štúdia REVEAL-CKD ukázala, že v európskych krajinách je podiel nerozpoznaných prípadov ešte vyšší — vo Francúzsku 95,5 %.</p>

<p>Tieto analýzy nepreukázali, že všetci títo pacienti boli klinicky úplne nediagnostikovaní. Spoľahlivo však identifikovali veľký rozdiel medzi laboratórnymi nálezmi a administratívnym zaznamenaním diagnózy.</p>

<p>Najdôležitejším praktickým posolstvom je, že hodnotenie funkcie obličiek nesmie byť sústredené iba na pacientov s diabetom. U ľudí s hypertenziou, srdcovým zlyhávaním alebo aterosklerotickým kardiovaskulárnym ochorením treba cielene vyšetrovať eGFR aj albuminúriu, potvrdiť chronickosť nálezu a výsledok <strong>zapísať do dokumentácie</strong> — a potom ho premietnuť do liečby.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=upcr-vs-uacr-riziko-zlyhania-obliciek-ckd">UPCR oproti UACR a riziko zlyhania obličiek</a> — prečo na spôsobe merania proteinúrie záleží.</li>
  <li><a href="article.php?slug=spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd">Spolupráca všeobecného lekára a nefrológa pri CKD</a>.</li>
  <li><a href="article.php?slug=egfr-diabetes-ekfc-ckd-epi-stadia-ckd">eGFR podľa EKFC a CKD-EPI</a> — ako voľba rovnice mení štádium.</li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Skríning CKD pri diabete</a> — model, ktorý pri hypertenzii chýba.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Navdeep Tangri, Peter R. Kushner, Salvatore Barone, Michael Arnold, Hailing Chen, Carlos S. Alvarez.</strong> <em>Undiagnosed Early CKD in Patients with Hypertension and Cardiovascular Disease in the United States (TH-PO1004).</em> Journal of the American Society of Nephrology. 2023;34:372. Konferenčný abstrakt ASN Kidney Week. <a href="https://journals.lww.com/jasn/fulltext/10.1681/asn.20233411s1372a~undiagnosed-early-ckd-in-patients-with-hypertension-and" target="_blank" rel="noopener noreferrer">Abstrakt</a>.</li>
  <li><strong>Navdeep Tangri, Takahito Moriyama, Markus P. Schneider, Jean Baptiste Virgitti, Luca De Nicola, Michael Arnold, Salvatore Barone, Elizabeth Peach, Eric Wittbrodt, Hungta Chen, Krister Järbrink, Pamela Kushner.</strong> <em>Prevalence of undiagnosed stage 3 chronic kidney disease in France, Germany, Italy, Japan and the USA: results from the multinational observational REVEAL-CKD study.</em> BMJ Open. 2023;13(5):e067386. <a href="https://doi.org/10.1136/bmjopen-2022-067386" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37217263/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Teresa K. Chen, Daphne H. Knicely, Morgan E. Grams.</strong> <em>Chronic Kidney Disease Diagnosis and Management: A Review.</em> JAMA. 2019;322(13):1294–1304. <a href="https://doi.org/10.1001/jama.2019.14745" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Hiddo J. L. Heerspink, Bergur V. Stefánsson, Ricardo Correa-Rotter, Glenn M. Chertow a spol. (DAPA-CKD).</strong> <em>Dapagliflozin in Patients with Chronic Kidney Disease.</em> New England Journal of Medicine. 2020;383(15):1436–1446. <a href="https://doi.org/10.1056/NEJMoa2024816" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>The EMPA-KIDNEY Collaborative Group.</strong> <em>Empagliflozin in Patients with Chronic Kidney Disease.</em> New England Journal of Medicine. 2023;388(2):117–127. <a href="https://doi.org/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Panagiotis I. Georgianos, Rajiv Agarwal.</strong> <em>Hypertension in chronic kidney disease — treatment standard 2023.</em> Nephrology Dialysis Transplantation. 2023;38(12):2694–2703. <a href="https://doi.org/10.1093/ndt/gfad118" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Údaje štúdie REVEAL-CKD — prevalencia nerozpoznanej CKD kategórie G3 vo Francúzsku 95,5 % (19 120/20 012), Japonsku 92,1 % (83 693/90 902), Nemecku 84,3 % (22 557/26 767), Taliansku 77,0 % (50 547/65 676), v americkej databáze TriNetX 64,3 % (161 254/250 879) a Explorys 61,6 % (13 845/22 470), ako aj faktory spojené s chýbajúcou diagnózou (ženské pohlavie OR 1,29 – 1,77; kategória G3a oproti G3b 1,81 – 3,66; neprítomnosť diabetu 1,26 – 2,77; neprítomnosť hypertenzie 1,35 – 1,78) — boli overené proti abstraktu v zázname PubMed. Bibliografia bola overená cez Crossref a PubMed; opravené bolo meno <strong>Panagiotis I. Georgianos</strong> (v podklade nesprávne „Nikolay A. Georgianos“). <strong>Upozornenie:</strong> percentá 68,4 / 68,7 / 68,6 / 51,7 % pochádzajú z konferenčného abstraktu, ktorý je za platobnou bariérou vydavateľa a <strong>nebolo možné ich nezávisle overiť</strong>; sú však konzistentné s hodnotou 64,3 % pre tú istú databázu TriNetX v recenzovanej štúdii REVEAL-CKD, ktorá používa zhodnú definíciu. Doplnenie štúdie REVEAL-CKD, medzikrajinové porovnanie, nález o ženskom pohlaví a komentáre k rozdielom v kódovacích zvyklostiach sú <strong>vlastným odborným spracovaním</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_nerozpoznana-ckd-hypertenzia-kardiovaskularne-ochorenie_article',
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
