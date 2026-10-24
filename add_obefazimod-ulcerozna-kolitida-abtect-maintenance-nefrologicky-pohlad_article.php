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
    'title' => 'Obefazimod pri ulceróznej kolitíde: čo znamenajú čísla z ABTECT a čo z toho má nefrológ',
    'slug' => 'obefazimod-ulcerozna-kolitida-abtect-maintenance-nefrologicky-pohlad',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Udržiavacie výsledky programu ABTECT vyzerajú mimoriadne priaznivo. Dizajn randomizovaného vysadenia liečby však mení to, ako sa má rozdiel oproti placebu čítať.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/obefazimod-ulcerozna-kolitida-abtect-maintenance-nefrologicky-pohlad.webp" type="image/webp">
    <img src="img/obefazimod-ulcerozna-kolitida-abtect-maintenance-nefrologicky-pohlad.png" alt="Polopriesvitny segment hrubeho creva v tme, sliznica prechadza z rozjatreneho cerveneho zapalu do pokojnej zelenej zhojenej vystelky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna slizničného hojenia pri ulceróznej kolitíde. Nejde o endoskopický nález ani o zobrazenie konkrétneho pacienta.</figcaption>
</figure>

<p>Na kongrese UEG Week 2026 v Barcelone boli 20. októbra prezentované udržiavacie výsledky programu ABTECT s obefazimodom, perorálnou molekulou, ktorá zvyšuje expresiu mikroRNA-124. Prezentované čísla pôsobia mimoriadne priaznivo: klinická remisia v 44. týždni u 51,3 % pacientov pri dávke 50 mg oproti 10,4 % pri placebe, a účinnosť zachovaná aj u pacientov, ktorí predtým zlyhali na štyroch a viacerých pokročilých liečbach.</p>

<p>Dizajn, ktorý tieto čísla vyprodukoval, je však randomizované vysadenie liečby u obohatenej populácie. To mení ich význam natoľko, že rozdiel oproti placebu nemožno čítať ako obvyklý rozdiel oproti placebu. Pre nefrológa má téma navyše konkrétnu, nie len všeobecnú relevanciu: ulcerózna kolitída má doložené obličkové prejavy a jeden z jej základných liekov je doloženou príčinou chronickej tubulointersticiálnej nefritídy.</p>

<h2>Čo je obefazimod</h2>

<p>Obefazimod (ABX464) je skúšaná perorálna malá molekula podávaná raz denne. Jej mechanizmom je selektívne zvýšenie expresie mikroRNA-124, regulačného prvku zápalových dráh zahŕňajúcich Th17 lymfocyty a makrofágy.</p>

<p>Predklinické a translačné práce ukázali, že obefazimod zvyšuje mikroRNA-124 v imunitných bunkách a tkanivách a že tento vzostup sprevádza pokles prozápalových cytokínov a chemokínov. Ide teda o moduláciu zápalovej odpovede na úrovni regulačného prvku, nie o blokádu jedného cytokínu alebo jednej adhéznej dráhy. Práve odlišnosť mechanizmu je dôvod, prečo liek vzbudzuje pozornosť u pacientov, ktorí vyčerpali existujúce triedy.</p>

<h2>Dizajn programu ABTECT a prečo na ňom záleží</h2>

<p>Do randomizovanej, dvojito zaslepenej, placebom kontrolovanej indukčnej časti bolo zaradených 1 272 pacientov so stredne ťažkou až ťažkou ulceróznou kolitídou, ktorí mali nedostatočnú odpoveď, stratu odpovede alebo neznášanlivosť aspoň jednej predchádzajúcej liečby, bez hornej hranice počtu. Pacienti boli priradení v pomere 2 : 1 : 1 k obefazimodu 50 mg, obefazimodu 25 mg alebo placebu raz denne na osem týždňov.</p>

<p>Do 44-týždňovej udržiavacej časti vstúpilo <strong>580 pacientov, ktorí na obefazimod v indukcii odpovedali</strong>. Títo boli znovu randomizovaní na obefazimod 25 mg, obefazimod 50 mg alebo placebo.</p>

<p>Toto je kľúčový bod celej analýzy. Nejde o porovnanie lieku s placebom u neselektovaných pacientov. Ide o <strong>randomizované vysadenie liečby</strong> u ľudí, ktorí na ňu preukázateľne reagovali. Pacient priradený do placebového ramena nedostáva placebo namiesto liečby; dostáva ho namiesto účinnej liečby, ktorú mu práve odobrali.</p>

<p>Desaťpercentná remisia v placebovom ramene preto nemeria „prirodzený priebeh ulceróznej kolitídy na placebe“. Meria, koľko pacientov zostane v remisii po vysadení lieku, ktorý im zaberal. Rozdiel oproti placebu je pri takomto dizajne systematicky väčší než pri klasickom paralelnom porovnaní a nie je priamo porovnateľný s indukčnými štúdiami iných liekov. Dizajn je legitímny a v gastroenterológii bežný, výsledok sa však musí interpretovať ako dôkaz <em>udržania</em> odpovede, nie ako dôkaz veľkosti účinku u pacienta, ktorý liek ešte nikdy nedostal.</p>

<h2>Výsledky podľa predchádzajúcej expozície pokročilej liečbe</h2>

<p>Pacienti boli rozdelení podľa toho, či mali predchádzajúcu nedostatočnú odpoveď na pokročilú liečbu, teda na biologiká, inhibítory JAK alebo modulátory receptora S1P, bez hornej hranice počtu. Takýchto pacientov bolo 238 (41 %), zvyšných 342 (59 %) pokročilú liečbu predtým nedostalo.</p>

<div class="table-responsive" role="region" aria-label="Výsledky v 44. týždni udržiavacej liečby podľa predchádzajúcej expozície pokročilej liečbe" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ v 44. týždni</th><th scope="col">25 mg</th><th scope="col">50 mg</th><th scope="col">Placebo</th></tr></thead>
  <tbody>
    <tr><th scope="row">Klinická remisia, po zlyhaní pokročilej liečby</th><td>34,2 %</td><td>42,2 %</td><td>6,9 %</td></tr>
    <tr><th scope="row">Klinická remisia, bez predchádzajúcej pokročilej liečby</th><td>61,5 %</td><td>59,0 %</td><td>12,5 %</td></tr>
    <tr><th scope="row">Endoskopické zlepšenie, po zlyhaní pokročilej liečby</th><td>38,2 %</td><td>53,3 %</td><td>8,3 %</td></tr>
    <tr><th scope="row">Endoskopická remisia (Mayo subskóre 0), po zlyhaní</th><td>23,7 %</td><td>38,9 %</td><td>5,6 %</td></tr>
    <tr><th scope="row">Histologicko-endoskopické zlepšenie, po zlyhaní</th><td>34,2 %</td><td>48,9 %</td><td>6,9 %</td></tr>
    <tr><th scope="row">Endoskopická remisia, bez predchádzajúcej pokročilej liečby</th><td>53,0 %</td><td>55,2 %</td><td>12,5 %</td></tr>
  </tbody>
</table>
</div>

<p>Celková populácia dosiahla primárny ukazovateľ: klinická remisia v 44. týždni bola 51,3 % pri 50 mg, 50,8 % pri 25 mg a 10,4 % pri placebe.</p>

<p>V skupine po zlyhaní pokročilej liečby boli rozdiely oproti placebu 28,0 percentuálneho bodu pri 25 mg a 33,1 percentuálneho bodu pri 50 mg. Všetky uvádzané hodnoty p sú <strong>nominálne</strong>, teda bez korekcie na mnohonásobné testovanie v rámci podskupín. Formálne ide o generovanie hypotéz, nie o potvrdené podskupinové závery.</p>

<p>Vzorec, ktorý z tabuľky vystupuje, má klinickú logiku. U pacientov bez predchádzajúcej pokročilej liečby sú obe dávky rovnocenné. U ťažšie liečiteľných pacientov po zlyhaní pokročilej liečby je vyššia dávka číselne lepšia pri každom ukazovateli, a rozdiel medzi dávkami je najväčší práve pri prísnejších endoskopických a histologických ukazovateľoch. Prezentujúci autor to pripísal tomu, že ide o ťažšie liečiteľnú populáciu. Ide však o číselný rozdiel v rámci podskupín, nie o formálne preukázanú prevahu vyššej dávky.</p>

<h2>Účinnosť po viacnásobnom zlyhaní</h2>

<p>U pacientov, ktorí neodpovedali na štyri a viac pokročilých liečb, dosiahlo klinickú remisiu 27,3 % pri 25 mg a 33,3 % pri 50 mg, oproti nikomu v placebovom ramene. Pri predchádzajúcom zlyhaní inhibítora JAK to bolo 28,6 % a 33,3 % oproti 0 %.</p>

<p>Sú to zaujímavé čísla, ale treba ich čítať opatrne z troch dôvodov naraz. Podskupiny sú malé a s rastúcim počtom predchádzajúcich línií sa zmenšujú. Nulová hodnota v placebovom ramene je pri malom počte pacientov štatisticky krehká a robí relatívny rozdiel opticky dramatickejším, než je. A predovšetkým: aj títo pacienti museli najprv na obefazimod odpovedať v indukcii, inak by sa do udržiavacej fázy nedostali. Údaj teda nehovorí, aká časť pacientov po štyroch zlyhaniach bude na obefazimod reagovať, ale aká časť tých, ktorí už reagovali, si odpoveď udrží.</p>

<h2>Bezpečnosť</h2>

<div class="table-responsive" role="region" aria-label="Bezpečnostné údaje udržiavacej fázy" tabindex="0">
<table>
  <thead><tr><th scope="col">Udalosť</th><th scope="col">Placebo</th><th scope="col">25 mg</th><th scope="col">50 mg</th></tr></thead>
  <tbody>
    <tr><th scope="row">Nežiaduca udalosť vzniknutá počas liečby</th><td>50,0 %</td><td>58,0 %</td><td>71,8 %</td></tr>
    <tr><th scope="row">Ukončenie liečby pre nežiaducu udalosť</th><td>6,8 %</td><td>2,6 %</td><td>4,6 %</td></tr>
  </tbody>
</table>
</div>

<p>Závažné nežiaduce udalosti vzniknuté počas liečby boli zriedkavé: jedna u pacienta na placebe a žiadna u pacientov na obefazimode. Výskyt závažných alebo ťažkých infekcií a oportúnnych infekcií bol nízky vo všetkých ramenách.</p>

<p>Pri dávke 50 mg boli hlásené po jednom prípade karcinómu prsníka a karcinómu prostaty a malý počet nemelanómových kožných nádorov. Pri 44-týždňovom sledovaní a tomto počte pacientov z toho nemožno vyvodiť nič o onkologickom riziku v oboch smeroch; ide o údaj, ktorý sa má sledovať v dlhodobých predĺženiach, nie o signál ani o uistenie.</p>

<p>Číselne vyšší výskyt nežiaducich udalostí pri 50 mg je protiváhou číselne lepšej účinnosti tej istej dávky. Pomer prínosu a rizika medzi dávkami tak zostáva otvorený a bude sa pravdepodobne líšiť podľa toho, ako ťažko liečiteľný pacient je.</p>

<h2>Nefrologický pohľad: v čom je ulcerózna kolitída obličkovou témou</h2>

<p>Súvislosť nie je hypotetická. V tureckej kohorte 1 874 pacientov s nešpecifickým zápalovým ochorením čreva, z toho 1 055 s ulceróznou kolitídou a 819 s Crohnovou chorobou, sa obličkové prejavy vyskytli u 105 pacientov, teda u <strong>5,6 %</strong>. Pri Crohnovej chorobe to bolo 6,7 % a pri ulceróznej kolitíde 4,7 %. Najčastejším prejavom pri oboch diagnózach bola nefrolitiáza a výskyt obličkových prejavov súvisel s aktivitou črevného ochorenia.</p>

<p>Okrem nefrolitiázy sa opisujú tubulointersticiálna nefritída, glomerulonefritídy vrátane IgA nefropatie v rámci konceptu osi črevo a oblička, a sekundárna amyloidóza typu AA pri dlhodobo nekontrolovanom zápale.</p>

<p>Práve tu sa dá vysloviť nepriamy argument v prospech účinnej udržiavacej liečby: ak obličkové prejavy súvisia s aktivitou ochorenia, dlhodobá hlboká remisia by mala ich výskyt znižovať. Ide však o úvahu, nie o dôkaz. Program ABTECT žiadne obličkové ukazovatele nesledoval a o nefroprotektívnom účinku obefazimodu nemožno povedať nič.</p>

<h2>Konkrétnejšia nefrologická súvislosť: 5-aminosalicyláty</h2>

<p>Oveľa priamejší obličkový dosah má samotná základná liečba ulceróznej kolitídy. Informácie o lieku pri prípravkoch s obsahom mesalazínu uvádzajú riziko poškodenia obličiek vrátane nefropatie minimálnych zmien, akútnej aj chronickej intersticiálnej nefritídy a zriedkavo zlyhania obličiek.</p>

<p>Prehľad v <em>Advances in Chronic Kidney Disease</em> túto problematiku zhŕňa prakticky. Chronická intersticiálna nefritída pri liečbe mesalazínom je zriedkavá, ale jej obraz je zákerný: pacienti sa typicky prezentujú <strong>asymptomatickým poklesom glomerulárnej filtrácie bez pyúrie, kožných prejavov a eozinofílie</strong>, teda bez znakov, ktoré sprevádzajú akútnu intersticiálnu nefritídu. Po vysadení lieku sa funkcia obličiek zvyčajne zlepšuje. Ak sa však stav neodhalí, dlhšia expozícia môže viesť k nezvratnému zlyhaniu obličiek a do terminálneho štádia. Presvedčivé dôkazy o účinnosti kortikosteroidov v tejto indikácii neexistujú. Autori odporúčajú pravidelné sledovanie sérového kreatinínu, najmä v prvých rokoch liečby.</p>

<p>Pre nefrológa z toho plynie zreteľný praktický záver, ktorý s obefazimodom priamo nesúvisí, ale rámcuje celú tému. U pacienta s ulceróznou kolitídou a nevysvetleným poklesom glomerulárnej filtrácie patrí mesalazín medzi prvé podozrivé, aj keď je močový nález nemý. A naopak: pacient s ulceróznou kolitídou na dlhodobej liečbe 5-aminosalicylátmi potrebuje kontroly kreatinínu, nie preto, že je to zvykom, ale preto, že táto konkrétna nefrotoxicita sa inak než laboratórne neprejaví.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Obefazimod zatiaľ nemá registráciu a prezentované údaje neprešli recenzným konaním. Ide o konferenčnú prezentáciu sponzorovanú výrobcom, s podskupinovými analýzami bez korekcie na mnohonásobné testovanie. Zaradenie do liečebných algoritmov si vyžaduje publikáciu plných výsledkov v recenzovanom časopise.</p>

<p>Pri tejto rezerve zostáva, že udržiavacia liečba obefazimodom udržala klinickú, endoskopickú aj histologicko-endoskopickú odpoveď počas 44 týždňov vrátane pacientov po zlyhaní viacerých mechanisticky odlišných tried, a že bezpečnostný profil v tomto časovom horizonte nepriniesol neočakávané nálezy. Pre populáciu s ulceróznou kolitídou odolnou voči viacerým liekom je to vecne dobrá správa.</p>

<p>Pre nefrologickú ambulanciu z toho priamo nevyplýva nič nové v liečbe. Vyplýva z toho však pripomienka, že u pacienta s ulceróznou kolitídou treba sledovať kreatinín a močový nález, poznať riziko mesalazínovej intersticiálnej nefritídy a pri obličkových prejavoch úzko spolupracovať s gastroenterológom. Pri každej novej udržiavacej liečbe je rozumné mať východiskovú hodnotu kreatinínu a odhadnutej glomerulárnej filtrácie, aj keď pre daný liek nefrotoxický signál neexistuje. Bez východiskovej hodnoty sa neskorší pokles nedá interpretovať.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Obefazimod je skúšaný liek bez registrácie; uvádzané údaje pochádzajú z konferenčnej prezentácie, ktorá neprešla recenzným konaním, a nepredstavujú podklad na liečebné rozhodnutie. Text nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania a súhrny charakteristických vlastností liekov.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. McCall Becky. Obefazimod Effective in Ulcerative Colitis After Prior Treatment Failures. <em>Medscape Medical News</em>, 22. októbra 2026. Prezentoval Silvio Danese na UEG Week 2026, Barcelona, 20. októbra 2026. Štúdiu sponzorovala spoločnosť Abivax. <a href="https://www.medscape.com/viewarticle/obefazimod-effective-ulcerative-colitis-after-prior-2026a10013vb" target="_blank" rel="noopener noreferrer">Celá správa</a>.</em></small></p>

<p><small><em>2. ABTECT-Maintenance: A Study to Evaluate the Efficacy and Safety of Obefazimod in Participants With Moderately to Severely Active Ulcerative Colitis. ClinicalTrials.gov, <a href="https://clinicaltrials.gov/study/NCT05535946" target="_blank" rel="noopener noreferrer">NCT05535946</a>.</em></small></p>

<p><small><em>3. Apolit Cécile, Campos Noélie, Vautrin Audrey, Begon-Pescia Christina, Lapasset Laure, Scherrer Didier, Gineste Paul, Ehrlich Hartmut, Garcel Aude, Santo Julien, Tazi Jamal. ABX464 (Obefazimod) Upregulates miR-124 to Reduce Proinflammatory Markers in Inflammatory Bowel Diseases. <em>Clinical and Translational Gastroenterology.</em> 2023;14(4):e00560. DOI: <a href="https://doi.org/10.14309/ctg.0000000000000560" target="_blank" rel="noopener noreferrer">10.14309/ctg.0000000000000560</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10132720/" target="_blank" rel="noopener noreferrer">PMC10132720</a>, voľný plný text.</em></small></p>

<p><small><em>4. Dinçer Mevlüt Tamer, Toker Dinçer Zeynep, Bakkaloğlu Oğuz Kağan, Yalın Serkan Feyyaz, Trabulus Sinan, Çelik Aykut Ferhat, Seyahi Nurhan, Altıparmak Mehmet Rıza. Renal Manifestations in Inflammatory Bowel Disease: A Cohort Study During the Biologic Era. <em>Medical Science Monitor.</em> 2022;28:e936497. DOI: <a href="https://doi.org/10.12659/MSM.936497" target="_blank" rel="noopener noreferrer">10.12659/MSM.936497</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9272730/" target="_blank" rel="noopener noreferrer">PMC9272730</a>, voľný plný text.</em></small></p>

<p><small><em>5. Adiga Avinash, Goldfarb David S. The Association of Mesalamine With Kidney Disease. <em>Advances in Chronic Kidney Disease.</em> 2020;27(1):72–76. DOI: <a href="https://doi.org/10.1053/j.ackd.2019.09.002" target="_blank" rel="noopener noreferrer">10.1053/j.ackd.2019.09.002</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32147005/" target="_blank" rel="noopener noreferrer">PubMed PMID 32147005</a>.</em></small></p>

<p><small><em>6. de Sire Roberto, La Mantia Alessia, Bonacci Livio, Testa Anna, Guarino Alessia Dalila, Rispo Antonio, Nardone Olga Maria, Castiglione Fabiana. Inflammatory Bowel Diseases and Nephropathies: Exploring the Gut-Kidney Axis. <em>Life (Basel).</em> 2024;14(12):1541. DOI: <a href="https://doi.org/10.3390/life14121541" target="_blank" rel="noopener noreferrer">10.3390/life14121541</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11678131/" target="_blank" rel="noopener noreferrer">PMC11678131</a>, voľný plný text.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky číselné údaje o programe ABTECT boli prevzaté zo správy Medscape Medical News z kongresu UEG Week 2026 a ide teda o údaje z konferenčnej prezentácie, ktorá neprešla recenzným konaním. Meno autorky správy aj prezentujúceho autora, dátum prezentácie a sponzor boli overené priamo na verejne prístupnej stránke zdroja. Bibliografické údaje všetkých citovaných publikácií vrátane úplných autorských zoznamov boli overené v databáze Crossref a v PubMed; pri práci Apolit a kolektív bol pritom opravený ročník na 2023 (nie 2022, ako uvádzajú niektoré sekundárne zdroje). Údaje o výskyte obličkových prejavov pochádzajú z plného textu kohorty (PMC9272730), údaje o mesalazínovej nefrotoxicite zo štruktúrovaného abstraktu prehľadu v PubMed.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je rozbor dôsledkov dizajnu randomizovaného vysadenia liečby pre interpretáciu rozdielu oproti placebu, upozornenie na nominálnu povahu uvádzaných hodnôt p v podskupinách, a nahradenie všeobecnej úvahy o systémovom zápale konkrétnou nefrologickou väzbou cez mesalazínovú intersticiálnu nefritídu a doložený výskyt obličkových prejavov. Tieto súvislosti nie sú obsiahnuté vo východiskovej správe.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
  <li><a href="article.php?slug=oblickove-kamene-aua-2026-prevencia-liecba">Obličkové kamene: prevencia a liečba podľa AUA 2026</a></li>
  <li><a href="article.php?slug=rekurencia-glomerularnych-ochoreni-transplantacia-oblicky">Rekurencia glomerulárnych ochorení po transplantácii obličky</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_obefazimod-ulcerozna-kolitida-abtect-maintenance-nefrologicky-pohlad_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "────────────────────────────────────────────────────\n\n";
}
?>