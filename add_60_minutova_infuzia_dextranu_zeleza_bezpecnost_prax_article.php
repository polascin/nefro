<?php

/**
 * Odborny prehlad 60-minutoveho protokolu infuzie dextranu zeleza.
 */

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
    'title'        => '60-minútová infúzia dextránu železa v menšom centre: prínos, riziká a limity dôkazov',
    'slug'         => '60-minutova-infuzia-dextranu-zeleza-bezpecnost-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-09-24 12:49:18',
    'is_top'       => 0,
    'excerpt'      => 'Retrospektívna štúdia z vidieckeho pracoviska skrátila priemerný čas podania dextránu železa zo 189 na 80 minút. Na potvrdenie rovnakej bezpečnosti však nemala dostatočnú veľkosť ani dizajn.',
    'content'      => <<<'HTML'
<p><strong>Hodinové podanie dextránu železa</strong> môže znížiť časovú a personálnu náročnosť intravenóznej liečby nedostatku železa. Nová práca z menšieho vidieckeho pracoviska americkej Veterans Health Administration (VHA) ukázala výrazné skrátenie celkového času podania po zavedení 60-minútového protokolu. Zároveň zachytila anafylaktický šok počas testovacej dávky. Štúdia preto podporuje uskutočniteľnosť protokolu, ale nedokazuje, že skrátené podanie je rovnako bezpečné ako predĺžená infúzia.</p>
<p>Pre nefrologickú prax je podstatný ešte jeden rozdiel: skúmaný americký protokol nemožno bez úpravy preniesť do Európy. Požiadavky na testovaciu dávku, monitorovanie a rýchlosť podania sa musia riadiť konkrétnym prípravkom, jeho aktuálnym súhrnom charakteristických vlastností lieku a miestnymi pravidlami.</p>
<p>Výsledky sa týkajú dextránu železa používaného v danom americkom systéme; publikácia odkazuje na prípravok INFeD a práce s nízkomolekulovým dextránom železa. Nemožno ich zovšeobecniť na historické vysokomolekulové dextrány ani na iné komplexy intravenózneho železa, ktoré majú odlišné dávkovanie a rýchlosť podania.</p>

<h2>Čo štúdia skutočne porovnávala</h2>
<p>Jay Tieri publikoval v časopise <em>Federal Practitioner</em> jednocentrovú retrospektívnu observačnú štúdiu z Veterans Health Care System of the Ozarks v Arkansase. Išlo o vidiecke zariadenie sekundárnej starostlivosti s osemmiestnou infúznou ambulanciou, jedným klinickým farmaceutom a jednou sestrou s rozšírenými kompetenciami na pracovisku. Lekári poskytovali veľkú časť starostlivosti na diaľku. Zariadenie však malo dostupné urgentné služby, jednotku intenzívnej starostlivosti a systém privolania pomoci.</p>
<p>Autori spätne vyhodnotili podania od 12. novembra 2020 do 30. mája 2025. Celkovo išlo o 160 pacientov a 246 podaní dextránu železa. Obe porovnávané obdobia zahŕňali po 123 podaní:</p>
<ul>
<li>predĺžený protokol: 67 pacientov, podania do 30. mája 2024,</li>
<li>60-minútový protokol: 93 pacientov, podania od 31. mája 2024.</li>
</ul>
<p>Nešlo o randomizované súbežné porovnanie. Skupiny vznikli pred a po zmene lokálneho protokolu, pričom sa naraz zmenila dĺžka infúzie, testovacia dávka, sledovanie aj používanie premedikácie.</p>

<h2>Ako sa protokoly líšili</h2>
<p>V pôvodnom režime dostával pacient bez predchádzajúcej expozície testovaciu dávku ako 15-minútovú infúziu a potom nasledovalo 45-minútové sledovanie. Zvyšok dávky sa podával 120 až 180 minút. Premedikácia bola štandardizovaná.</p>
<p>Nový protokol umožňoval fixné dávky 500, 750 alebo 1 000 mg. Premedikácia bola voliteľná. Pacient bez predchádzajúcej expozície dostal testovaciu dávku počas piatich minút a po nej nasledovalo 15-minútové sledovanie. Zvyšok dávky sa podával z 250 ml vaku rýchlosťou 300 ml/h; pri ďalších podaniach bola plánovaná 60-minútová infúzia.</p>
<p>Takéto jednorazové dávky zároveň nezodpovedajú aktuálnemu americkému schválenému dávkovaniu prípravku INFeD. Jeho preskripčná informácia pre väčšinu pacientov uvádza najviac 100 mg denne a pred prvou terapeutickou dávkou vyžaduje testovaciu dávku. Podanie 500 až 1 000 mg v skúmanom režime preto predstavovalo použitie mimo schváleného dávkovania v USA. Ani tolerovaná testovacia dávka podľa upozornenia výrobcu nevylučuje následnú závažnú alebo fatálnu reakciu.</p>
<p>Označenie „60-minútový protokol“ teda neznamenalo, že celý pobyt trval presne hodinu. Priemerný celkový čas dosiahol 80,1 minúty oproti 189,2 minúty pri predĺženom režime (P &lt; 0,01). U pacientov bez predchádzajúcej expozície sa čas skrátil z 218,5 na 86,7 minúty a u predliečených zo 169,7 na 67,3 minúty.</p>

<h2>Reakcie súvisiace s infúziou</h2>
<p>V skupine so 60-minútovým protokolom bolo zaznamenaných šesť hodnotiteľných udalostí zo 123 podaní (4,9 %):</p>
<ul>
<li>štyri prípady nauzey a jeden prípad bolesti alebo kŕčov brucha, všetky stupňa 1,</li>
<li>jeden anafylaktický šok stupňa 4 počas testovacej dávky.</li>
</ul>
<p>Pacient s anafylaktickým šokom potreboval vazopresory a prijatie na jednotku intenzívnej starostlivosti. Tryptáza presiahla dvojnásobok hornej hranice referenčného rozpätia a neskôr sa normalizovala. Infúzia bola ukončená.</p>
<p>V skupine s predĺženým protokolom nastala pri jednom zo 123 podaní hypertenzia stupňa 3 (0,8 %), ktorá si vyžiadala liečbu a ukončenie infúzie. Výskyt závažných udalostí sa medzi skupinami štatisticky nelíšil, ale pri jednom závažnom prípade v každej skupine je odhad mimoriadne nepresný. Nulový alebo nevýznamný rozdiel v malej štúdii nie je dôkazom rovnakej bezpečnosti.</p>
<p>Publikácia navyše nie je úplne konzistentná v opise miernych reakcií. Abstrakt uvádza päť pacientov s piatimi príhodami stupňa 1, zatiaľ čo časť o limitáciách uvádza, že jeden pacient mal nauzeu pri troch podaniach. To nemení celkový počet zaznamenaných udalostí v tabuľke, ale sťažuje presné určenie počtu jedinečných pacientov s miernou reakciou.</p>

<h2>Čo ukazujú väčšie súbory</h2>
<p>Multicentrická retrospektívna kohorta publikovaná v <em>JAMA Network Open</em> zahŕňala 35 737 podaní intravenózneho železa u 12 237 pacientov. Reakcia bola identifikovaná pri 3,9 % podaní. Pri dextráne železa bola zaznamenaná pri 3,8 % podaní, pričom iba dve udalosti v celom súbore viedli k podaniu adrenalínu; obe súviseli s dextránom železa. Táto práca používala podanie liekov po infúzii ako zástupný ukazovateľ reakcie, preto nemerala klinicky potvrdenú anafylaxiu pri každom prípade.</p>
<p>Premedikované podania mali v tejto kohorte 23-násobne vyššiu evidovanú mieru reakcií než podania bez premedikácie (38,6 % oproti 1,7 %). Nejde o dôkaz, že premedikácia reakcie spôsobuje. Rizikovejší pacienti ju dostávali častejšie a najmä antihistaminiká prvej generácie môžu samy vyvolať ospalosť, návaly, hypotenziu alebo tachykardiu, ktoré sa podobajú reakcii na infúziu.</p>
<p>Staršia analýza 20 213 pacientov bez predchádzajúcej expozície dextránu železa našla sedem reakcií vyžadujúcich resuscitačné lieky, teda 0,035 %. Všetky vznikli pri testovacej alebo prvej terapeutickej dávke. Ani tento výsledok nepodporuje predstavu, že negatívna testovacia dávka spoľahlivo predpovedá bezpečnosť zvyšku podania.</p>

<h2>Rozdiel medzi americkým protokolom, EMA a KDIGO</h2>
<p>Európska lieková agentúra uvádza, že testovacia dávka intravenózneho železa nie je spoľahlivým prediktorom následnej hypersenzitivity a rutinne ju neodporúča. Opatrnosť je potrebná pri každom podaní, aj keď pacient predchádzajúce dávky toleroval. EMA zároveň požaduje sledovanie počas podania a najmenej 30 minút po ňom a okamžitú dostupnosť vyškoleného personálu a resuscitačných prostriedkov.</p>
<p>Odporúčanie KDIGO 2026 pre anémiu pri CKD podobne zdôrazňuje, že intravenózne železo sa má podávať iba tam, kde možno zvládnuť akútnu hypersenzitívnu a hypotenznú reakciu. Dávka a rýchlosť nesmú prekročiť limity konkrétneho prípravku. Rutinná premedikácia kortikosteroidom alebo antihistaminikom nie je potrebná a testovacie dávky sa zvyčajne nevyžadujú, pretože negatívny výsledok nepredikuje riziko.</p>
<p>KDIGO zároveň spochybňuje fyziologický dôvod rutinného 30-minútového sledovania po ukončení každej infúzie, kým EMA ho naďalej požaduje. V európskej praxi treba rešpektovať platné regulačné a produktové požiadavky aj vtedy, keď sa odborné odporúčanie v tomto bode líši.</p>
<p>Tieto rámce nie sú totožné s protokolom skúmaným vo VHA. Americké výsledky preto nemožno použiť ako samostatný návod na zmenu slovenského interného predpisu. Pred zavedením treba overiť dostupný liek, jeho registráciu, aktuálny súhrn charakteristických vlastností, maximálnu jednorazovú dávku, riedenie, minimálny čas podania a požadované sledovanie.</p>

<h2>Čo z toho vyplýva pre nefrologické pracovisko</h2>
<p>Štúdia sa uskutočnila v hematologicko-onkologickej ambulancii a nebola zameraná na CKD ani dialyzovaných pacientov. V 60-minútovej skupine objednala nefrológia iba jedno zo 123 podaní. Výsledky preto neoverujú osobitne bezpečnosť u pacientov s pokročilým CKD, počas hemodialýzy ani pri súbežnej liečbe ESA.</p>
<p>Ak pracovisko zvažuje skrátené podanie prípravku, interný protokol má obsahovať aspoň:</p>
<ol>
<li>presnú identifikáciu prípravku a režim zodpovedajúci jeho platným informáciám,</li>
<li>kritériá výberu pacienta a zhodnotenie predchádzajúcich reakcií, alergií, astmy a zápalových ochorení,</li>
<li>meranie vitálnych funkcií a priame pozorovanie v rozhodujúcej počiatočnej fáze,</li>
<li>okamžitú dostupnosť vyškoleného personálu, adrenalínu a kompletného vybavenia na resuscitáciu,</li>
<li>jednoznačný algoritmus zastavenia infúzie, rozlíšenia miernej reakcie od anafylaxie a ďalšieho postupu,</li>
<li>štandardizovaný záznam dávky, času, príznakov, zásahu a výsledku na účely auditu.</li>
</ol>
<p>Časová úspora nesmie vzniknúť skrátením pozorovania požadovaného regulačným dokumentom ani znížením pripravenosti na urgentnú liečbu. Pracovisko v publikovanej štúdii síce fungovalo decentralizovane, nešlo však o ambulanciu bez urgentného zázemia.</p>

<h2>Limity štúdie</h2>
<ul>
<li>historické porovnanie pred a po zmene protokolu bez randomizácie,</li>
<li>súčasná zmena viacerých prvkov postupu, nielen rýchlosti infúzie,</li>
<li>jediné pracovisko a iba 246 podaní,</li>
<li>nedostatočná štatistická sila na porovnanie veľmi zriedkavých závažných reakcií,</li>
<li>prevažne mužská a biela veteránska populácia,</li>
<li>závislosť od kvality retrospektívnej ošetrovateľskej dokumentácie,</li>
<li>odlišné trvanie zberu údajov a zmena využívania dextránu železa medzi obdobiami.</li>
</ul>

<h2>Záver</h2>
<p>Zavedenie 60-minútového protokolu v menšom vidieckom centre skrátilo priemerný celkový čas podania dextránu železa približne o 109 minút. Štúdia preukázala uskutočniteľnosť organizačnej zmeny, nie bezpečnostnú ekvivalenciu. Zachytený anafylaktický šok potvrdzuje, že aj zriedkavé reakcie sú klinicky reálne a vyžadujú okamžitú liečbu.</p>
<p>Pre nefrologickú prax je vhodné prevziať najmä organizačné ponaučenie: protokol možno zrýchliť iba v rozsahu povolenom pre konkrétny liek a pri zachovaní plnej reakčnej kapacity. Samotná publikácia neoprávňuje zaviesť americkú testovaciu dávku, 15-minútové sledovanie ani hodinové podanie bez kontroly európskych a lokálnych požiadaviek.</p>
<p><small><em>Redakčné overenie k 24. septembru 2026: hlavná publikácia bola skontrolovaná v úplnom texte a cez Crossref; doplnkové klinické údaje a autorstvo boli overené cez PubMed E-utilities, KDIGO a EMA. Text nenahrádza platný súhrn charakteristických vlastností konkrétneho lieku ani interný urgentný protokol pracoviska.</em></small></p>

<div class="pdf-keep-together"><hr><h2>Zdroje</h2><ol>
<li><small><em>Tieri J. Evaluating the Implementation of 60-Minute Iron Dextran Infusions at a Rural Health Center. Fed Pract. 2026;43(Suppl 3):e1–e5. doi:10.12788/fp.0744; <a href="https://doi.org/10.12788/fp.0744" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Anemia Work Group. KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in Chronic Kidney Disease (CKD). Kidney Int. 2026;109(Suppl 1S):S1–S99. doi:10.1016/j.kint.2025.06.006; <a href="https://pubmed.ncbi.nlm.nih.gov/41485812/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>European Medicines Agency. New recommendations to manage risk of allergic reactions with intravenous iron-containing medicines. 2013; <a href="https://www.ema.europa.eu/en/news/new-recommendations-manage-risk-allergic-reactions-intravenous-iron-containing-medicines" target="_blank" rel="noopener noreferrer">EMA</a>.</em></small></li>
<li><small><em>INFeD (iron dextran injection), prescribing information. Revised August 2024; <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2024/017441s181lbl.pdf" target="_blank" rel="noopener noreferrer">US Food and Drug Administration</a>.</em></small></li>
<li><small><em>Arastu AH, Elstrott BK, Martens KL, et al. Analysis of Adverse Events and Intravenous Iron Infusion Formulations in Adults With and Without Prior Infusion Reactions. JAMA Netw Open. 2022;5(3):e224488. doi:10.1001/jamanetworkopen.2022.4488; <a href="https://pubmed.ncbi.nlm.nih.gov/35353168/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Walters BAJ, Van Wyck DB. Benchmarking iron dextran sensitivity: reactions requiring resuscitative medication in incident and prevalent patients. Nephrol Dial Transplant. 2005;20(7):1438–1442. doi:10.1093/ndt/gfh811; <a href="https://pubmed.ncbi.nlm.nih.gov/15840683/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol></div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_60-minutova-infuzia-dextranu-zeleza-bezpecnost-prax_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\nMigrácia článku: {$articles[0]['title']}\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny): $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $error) {
        echo "Chyba: $error\n";
    }
} else {
    echo '<p>Článok bol spracovaný: ' . htmlspecialchars($articles[0]['title']) . '.</p>';
}
