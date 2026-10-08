<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Kedy znížiť antihypertenzívnu liečbu u krehkého seniora?',
    'slug' => 'znizenie-antihypertenziv-krehky-senior-retreat-frail',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'RETREAT-FRAIL ukazuje hranice znižovania antihypertenzív u krehkých obyvateľov zariadení dlhodobej starostlivosti. Rozhodujú indikácie, tolerancia, objemový stav a monitorovanie.',
    'content' => <<<'HTML'
<p>Liečba artériovej hypertenzie znižuje kardiovaskulárne riziko, jej intenzita však nemusí zostať primeraná počas celého života. U človeka s pokročilou krehkosťou, multimorbiditou, polyfarmáciou a klesajúcim krvným tlakom môže pôvodne vhodná kombinácia liekov predstavovať neprimeranú liečebnú záťaž.</p>

<p>Otázkou preto nie je, či starší ľudia potrebujú antihypertenzíva. Rozhodujúce je, či konkrétny pacient naďalej potrebuje všetky lieky v pôvodných dávkach, či ich toleruje a či očakávaný prínos zodpovedá jeho aktuálnym cieľom starostlivosti. Randomizovaná štúdia RETREAT-FRAIL túto otázku skúmala v úzko definovanej populácii. Jej výsledky podporujú riadenú individualizáciu, nie plošné vysadzovanie liekov.</p>

<figure>
  <picture>
    <source srcset="img/znizenie-antihypertenziv-krehky-senior-retreat-frail.webp" type="image/webp">
    <img src="img/znizenie-antihypertenziv-krehky-senior-retreat-frail.png" alt="Lekárka meria tlak krehkej seniorke a zvažuje rovnováhu medzi orgánovou ochranou a rizikami nadmernej antihypertenzívnej liečby" width="1600" height="1000" loading="lazy">
  </picture>
  <figcaption>Depreskripcia antihypertenzív nie je opustenie liečby. Je to monitorovaná a podľa potreby reverzibilná úprava podľa krehkosti, tolerancie, ďalších indikácií a cieľov starostlivosti.</figcaption>
</figure>

<h2>Čo RETREAT-FRAIL skutočne skúmal</h2>

<p>RETREAT-FRAIL bola multicentrická randomizovaná kontrolovaná štúdia vo francúzskych zariadeniach dlhodobej starostlivosti. Zaradení boli obyvatelia vo veku najmenej 80 rokov s krehkosťou, systolickým krvným tlakom nižším ako 130 mmHg a liečbou viac než jedným antihypertenzívom. Celkovo 1 048 účastníkov bolo pridelených v pomere 1 : 1 k protokolovo riadenej postupnej redukcii liečby alebo k obvyklej starostlivosti. Plánované sledovanie trvalo najviac štyri roky; odhadovaný medián potenciálneho sledovania bol 38,4 mesiaca.</p>

<p>Medzi východiskom a poslednou návštevou klesol priemerný počet antihypertenzív v redukčnom ramene z 2,6 na 1,5 a v ramene obvyklej starostlivosti z 2,5 na 2,0. Systolický tlak sa pri redukcii zvýšil v priemere o 4,1 mmHg viac než pri obvyklej starostlivosti (95 % interval spoľahlivosti 1,9–5,7 mmHg).</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky štúdie RETREAT-FRAIL" tabindex="0">
<table>
  <thead><tr><th scope="col">Výsledok</th><th scope="col">Postupná redukcia</th><th scope="col">Obvyklá starostlivosť</th></tr></thead>
  <tbody>
    <tr><th scope="row">Randomizovaní pacienti</th><td>528</td><td>520</td></tr>
    <tr><th scope="row">Úmrtie z akejkoľvek príčiny</th><td>326 (61,7 %)</td><td>313 (60,2 %)</td></tr>
    <tr><th scope="row">Upravený pomer hazardov mortality</th><td colspan="2">HR 1,02; 95 % IS 0,86–1,21; p = 0,78</td></tr>
  </tbody>
</table>
</div>

<p>Protokol postupnej redukcie <strong>neznížil celkovú mortalitu</strong>. Medzi ramenami neboli zjavné rozdiely v nežiaducich udalostiach. Interval spoľahlivosti mortality však zahŕňa možný 14 % relatívny prínos aj 21 % relatívne zvýšenie rizika. Štúdia preto nedokazuje úplnú rovnocennosť ani bezrizikovosť oboch postupov.</p>

<h2>Negatívny výsledok nie je dôkazom ekvivalencie</h2>

<p>RETREAT-FRAIL bola štúdia superiority s primárnou otázkou, či redukcia zníži mortalitu. Nebola navrhnutá ako noninferioritná štúdia s vopred stanovenou hranicou prijateľného zhoršenia. Formulácia „nezistil sa štatisticky významný rozdiel“ preto neznamená „postupy sú dokázateľne rovnako bezpečné“.</p>

<p>Rovnako nesprávne by bolo štúdiu interpretovať ako dôkaz škodlivosti depreskripcie: bodový odhad HR 1,02 bol blízko neutrálnej hodnoty a nežiaduce udalosti sa zjavne nelíšili. Najpresnejší záver je užší: v tejto veľmi starej, krehkej a inštitucionalizovanej populácii postupná redukcia počtu antihypertenzív znížila liekovú záťaž a mierne zvýšila systolický tlak, ale nepreukázala zníženie celkovej mortality.</p>

<h2>Na koho sa výsledok vzťahuje a na koho nie</h2>

<p>Krehkosť je stav zníženej fyziologickej rezervy a zvýšenej zraniteľnosti voči záťaži. Nie je synonymom chronologického veku, multimorbidity ani pobytu v zariadení. Posudzujú sa najmä mobilita, sebestačnosť, svalová sila, výživa, kognitívne funkcie, pády a schopnosť zotaviť sa po akútnom ochorení.</p>

<p>Výsledky RETREAT-FRAIL nemožno automaticky preniesť na:</p>

<ul>
  <li>funkčne zdatných ľudí vo veku nad 80 rokov,</li>
  <li>pacientov užívajúcich iba jedno antihypertenzívum,</li>
  <li>pacientov so systolickým tlakom ≥ 130 mmHg,</li>
  <li>mladších pacientov s krehkosťou,</li>
  <li>dialyzovaných pacientov ani osoby po transplantácii obličky,</li>
  <li>pacientov v akútnej obehovej nestabilite.</li>
</ul>

<p>Odporúčania ESC z roku 2024 zdôrazňujú, že dobre tolerovanú liečbu netreba u veľmi starého alebo krehkého pacienta automaticky rušiť. Pri progresii krehkosti, poklese tlaku, symptomatickej ortostatickej hypotenzii alebo obmedzenej očakávanej dĺžke života však môže byť potrebná individualizácia a depreskripcia. Cieľ 120–129/70–79 mmHg sa na stredne až ťažko krehkých pacientov nemusí dať bezpečne zovšeobecniť.</p>

<h2>Hodnota 130 mmHg nie je automatický prah na vysadenie</h2>

<p>Systolický tlak pod 130 mmHg bol vstupným kritériom štúdie, nie univerzálnou terapeutickou hranicou. Jednorazové meranie nestačí. Pred zmenou liečby treba posúdiť:</p>

<ul>
  <li>opakovateľnosť hodnôt a správnosť techniky merania,</li>
  <li>tlak a pulz po postavení, ak je vyšetrenie bezpečné,</li>
  <li>závraty, presynkopy, synkopy, pády, únavu a zhoršenie mobility,</li>
  <li>denný profil tlaku alebo domáce či ambulantné monitorovanie, ak je uskutočniteľné,</li>
  <li>príjem tekutín, hmotnosť a objemový stav,</li>
  <li>nedávne zmeny liekov a súbežné lieky zhoršujúce ortostatickú toleranciu,</li>
  <li>funkciu obličiek, sodík a draslík podľa konkrétnej liečby a klinického stavu.</li>
</ul>

<p>Nízky tlak môže byť dôsledkom nadmernej liečby, ale aj dehydratácie, malnutrície, úbytku hmotnosti, infekcie, krvácania, srdcového zlyhávania, autonómnej dysfunkcie alebo pokročilého systémového ochorenia. Asociácia nízkeho tlaku s mortalitou v observačných štúdiách preto sama osebe nedokazuje škodlivosť antihypertenzív; významnú úlohu môže mať reverzná kauzalita.</p>

<h2>Pred redukciou treba poznať všetky indikácie</h2>

<p>Liek znižujúci tlak nemusí byť predpísaný iba na hypertenziu. Odstránenie „antihypertenzíva“ môže súčasne znamenať vysadenie prognostickej alebo symptomatickej liečby iného ochorenia.</p>

<div class="table-responsive" role="region" aria-label="Indikácie, ktoré treba preveriť pred redukciou antihypertenzív" tabindex="0">
<table>
  <thead><tr><th scope="col">Lieková skupina</th><th scope="col">Čo treba preveriť</th><th scope="col">Osobitné riziko pri úprave</th></tr></thead>
  <tbody>
    <tr><th scope="row">ACE inhibítor alebo sartán</th><td>Srdcové zlyhávanie, albuminurická CKD, stav po infarkte</td><td>Kreatinín, draslík, objemový stav</td></tr>
    <tr><th scope="row">Betablokátor</th><td>Srdcové zlyhávanie, angína, fibrilácia predsiení, stav po infarkte</td><td>Rebound tachykardia alebo ischémia pri náhlom vysadení</td></tr>
    <tr><th scope="row">Diuretikum</th><td>Kongescia a riziko jej návratu</td><td>Opuchy, dýchavica, hmotnosť, sodík a draslík</td></tr>
    <tr><th scope="row">Antagonista mineralokortikoidových receptorov</th><td>Srdcové zlyhávanie, primárny aldosteronizmus, ďalšia kardiorenálna indikácia</td><td>Hyperkaliémia a zmena funkcie obličiek</td></tr>
    <tr><th scope="row">Centrálne pôsobiaci liek</th><td>Aktuálna potreba a tolerancia</td><td>Rebound hypertenzia pri náhlom vysadení</td></tr>
    <tr><th scope="row">Alfablokátor</th><td>Aj urologická indikácia</td><td>Ortostatická hypotenzia a pády</td></tr>
  </tbody>
</table>
</div>

<h2>Nefrologický pohľad: tlak, perfúzia a kongescia</h2>

<p>Pri chronickej chorobe obličiek treba vyvažovať dlhodobú nefroprotekciu s aktuálnou toleranciou liečby. Hypovolémia, hypotenzia a akútne ochorenie môžu znížiť perfúzny tlak obličiek. Riziko akútneho poškodenia obličiek zvyšuje najmä kombinácia diuretika, blokátora renínovo-angiotenzínového systému a nesteroidového antiflogistika v období dehydratácie alebo hemodynamickej nestability.</p>

<p>Na druhej strane, redukcia diuretika u pacienta s kongesciou môže zhoršiť venózne preťaženie a funkciu obličiek. <strong>Nízky tlak nie je automatickým dôvodom na podanie tekutín ani na vysadenie diuretika.</strong> Rozhodujú klinické známky objemového stavu, perfúzia, diuréza, hmotnosť, dýchavica, opuchy, kreatinín a elektrolyty.</p>

<p>RETREAT-FRAIL nehodnotil zachovanie nefroprotekcie po vysadení konkrétnej liekovej skupiny. Nie je preto podkladom na rutinné vysadenie blokády renínovo-angiotenzínového systému u albuminurickej CKD ani na znižovanie liečby srdcového zlyhávania iba podľa jedného merania tlaku.</p>

<h2>Ako viesť riadenú depreskripciu</h2>

<ol>
  <li><strong>Stanoviť konkrétny cieľ.</strong> Napríklad zmiernenie ortostatických ťažkostí, prevencia pádov, korekcia hypovolémie alebo zníženie liekovej záťaže.</li>
  <li><strong>Preskúmať celý liekový režim.</strong> Vrátane psychofarmák, nitrátov, liekov na prostatu, analgetík a voľnopredajných prípravkov.</li>
  <li><strong>Vybrať liek podľa aktuálnej indikácie a rizika.</strong> Prednosť má liek bez presvedčivej pretrvávajúcej indikácie alebo s pravdepodobným podielom na ťažkostiach. Univerzálne poradie neexistuje.</li>
  <li><strong>Ak nejde o urgentný stav, meniť jednu zložku naraz.</strong> Betablokátory a centrálne pôsobiace sympatolytiká sa spravidla redukujú postupne.</li>
  <li><strong>Vopred určiť monitorovanie a podmienky návratu.</strong> Kontrolovať tlak, pulz, symptómy, pády, kongesciu a podľa lieku funkciu obličiek a elektrolyty.</li>
  <li><strong>Výsledok znovu vyhodnotiť.</strong> Opätovné nasadenie lieku pri návrate indikácie alebo nežiaducom vzostupe tlaku je správna súčasť reverzibilného procesu, nie jeho zlyhanie.</li>
</ol>

<p>Predchádzajúca štúdia OPTIMISE ukázala, že u vybraných ambulantných pacientov vo veku najmenej 80 rokov možno po odstránení jedného lieku krátkodobo zachovať systolický tlak pod 150 mmHg. Išlo však o menej krehkú populáciu vybranú všeobecným lekárom a iba 12-týždňové primárne sledovanie. OPTIMISE a RETREAT-FRAIL sa preto dopĺňajú, ale nie sú vzájomne zameniteľné.</p>

<h2>Kedy treba konať bezodkladne</h2>

<p>Synkopa, hypotenzia so známkami hypoperfúzie, oligúria, bolesť na hrudníku, nová neurologická symptomatológia, závažná bradykardia alebo rýchlo sa zhoršujúca dýchavica vyžadujú bezodkladné klinické posúdenie. Vtedy nejde o rutinnú dlhodobú depreskripciu, ale o diagnostiku a liečbu potenciálne akútneho stavu.</p>

<h2>Záver</h2>

<p>RETREAT-FRAIL nepreukázal, že postupná redukcia antihypertenzív znižuje mortalitu, ani nedokázal úplnú rovnocennosť oboch postupov. Ukázal však, že v protokolom sledovanej skupine veľmi starých krehkých obyvateľov zariadení dlhodobej starostlivosti bolo možné znížiť počet liekov za cenu priemerného zvýšenia systolického tlaku približne o 4 mmHg bez zjavného rozdielu v nežiaducich udalostiach.</p>

<p>Najvhodnejším kandidátom na prehodnotenie liečby je krehký pacient s opakovane nízkym alebo zle tolerovaným tlakom, viacerými liekmi a nepriaznivým pomerom očakávaného prínosu a záťaže. Rozhodnutie musí rešpektovať ďalšie indikácie, objemový stav, funkciu obličiek, ciele pacienta a reálnu možnosť následného monitorovania.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>Benetos A, et al.; RETREAT-FRAIL Study Group. Reduction of Antihypertensive Treatment in Nursing Home Residents. <em>N Engl J Med.</em> 2025;393:1990–2000. DOI: <a href="https://doi.org/10.1056/NEJMoa2508157" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2508157</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40879421/" target="_blank" rel="noopener noreferrer">PubMed PMID 40879421</a>.</em></small></p>
<p><small><em>McManus RJ, et al. Effect of Antihypertensive Medication Reduction vs Usual Care on Short-term Blood Pressure Control in Patients With Hypertension Aged 80 Years and Older: The OPTIMISE Randomized Clinical Trial. <em>JAMA.</em> 2020;323:2039–2051. <a href="https://pubmed.ncbi.nlm.nih.gov/32453368/" target="_blank" rel="noopener noreferrer">PubMed PMID 32453368</a>.</em></small></p>
<p><small><em>McEvoy JW, et al. 2024 ESC Guidelines for the management of elevated blood pressure and hypertension. <em>Eur Heart J.</em> 2024;45:3912–4018. <a href="https://academic.oup.com/eurheartj/article/45/38/3912/7741010" target="_blank" rel="noopener noreferrer">plné odporúčanie ESC</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_znizenie-antihypertenziv-krehky-senior-retreat-frail_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
