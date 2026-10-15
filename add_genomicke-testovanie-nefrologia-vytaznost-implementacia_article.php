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
    'title' => 'Genomické testovanie v nefrológii: výťažnosť, interpretácia a bezpečné zavedenie',
    'slug' => 'genomicke-testovanie-nefrologia-vytaznost-implementacia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Exómové sekvenovanie odhalí monogénnu príčinu u necelých 10 % dospelých s CKD, pri vrodených a cystických ochoreniach u takmer štvrtiny. Kedy testovať, aký test zvoliť a ako výsledok interpretovať.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/genomicke-testovanie-nefrologia-vytaznost-implementacia.webp" type="image/webp">
    <img src="img/genomicke-testovanie-nefrologia-vytaznost-implementacia.png" alt="Poloschematická scéna: z dvojzávitnice vychádza prúd variantov, ktorý sa cez lievik interpretácie zužuje na jedno jasné ložisko v obličke" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Zo stoviek nájdených variantov sa cez interpretáciu v kontexte fenotypu stane nanajvýš jedna molekulárna diagnóza.</figcaption>
</figure>

<p>Genetické príčiny ochorení obličiek sú v dospelej nefrológii podhodnotené. Časť pacientov s chronickým ochorením obličiek nejasnej etiológie má monogénnu príčinu, ktorá by zmenila prognózu, výber liečby, prípravu na transplantáciu aj starostlivosť o príbuzných. Sekvenovanie je dnes dostupné a redakčný komentár v <em>CJASN</em> z októbra 2026 otvára otázku jeho zavedenia do bežnej nefrologickej praxe – takzvaného mainstreamingu, pri ktorom test indikuje a výsledok komunikuje nefrológ, nie klinický genetik.</p>

<p>Pred takýmto krokom treba vedieť tri veci: komu test prinesie najviac, aký test zvoliť a čo sa stane s nálezom, ktorý nie je jednoznačný.</p>

<h2>Aká je skutočná výťažnosť</h2>

<p>Najcitovanejším podkladom zostáva exómové sekvenovanie v dvoch kohortách s celkovo 3 315 pacientmi s chronickým ochorením obličiek. Z nich bolo 3 037 (91,6 %) starších než 21 rokov a 1 179 (35,6 %) nebolo európskeho pôvodu.</p>

<div class="table-responsive" role="region" aria-label="Diagnostická výťažnosť exómového sekvenovania pri chronickom ochorení obličiek" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Skupina</th><th scope="col">Diagnostický variant</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Celá kohorta</th><td>307 z 3 315 (9,3 %)</td></tr>
    <tr><th scope="row">Vrodené alebo cystické ochorenie obličiek</th><td>127 z 531 (23,9 %)</td></tr>
    <tr><th scope="row">Nefropatia neznámeho pôvodu</th><td>48 z 281 (17,1 %)</td></tr>
    <tr><th scope="row">Medicínsky významný sekundárny nález</th><td>34 z 2 187 hodnotených (1,6 %)</td></tr>
  </tbody>
</table>
</div>

<p>Diagnostické varianty zahŕňali 66 rôznych monogénnych porúch, pričom <strong>39 z nich (59 %) sa našlo len u jediného pacienta</strong>. Toto číslo hovorí o genetickej heterogenite viac než samotná výťažnosť: úzky panel orientovaný na „časté“ gény by väčšinu z nich minul.</p>

<p>Sekundárne nálezy sa týkali porúch nesúvisiacich s nefropatiou, ktoré by však viedli k odoslaniu k inému špecialistovi a ovplyvnili aj nefrologický manažment. Podiel 1,6 % znamená približne jeden takýto nález na 60 testovaných – to nie je zriedkavosť, ktorú by sa dalo pri informovanom súhlase obísť mlčaním.</p>

<h2>Koho testovať</h2>

<p>Výťažnosť nie je rovnomerná. Predtestová pravdepodobnosť monogénnej príčiny rastie pri:</p>

<ul>
  <li>mladšom veku vzniku ochorenia,</li>
  <li>rodinnej anamnéze chronického ochorenia obličiek alebo zlyhania obličiek,</li>
  <li>vrodených alebo cystických ochoreniach obličiek,</li>
  <li>nefropatii neznámeho pôvodu,</li>
  <li>extrarenálnych prejavoch naznačujúcich syndróm (sluch, zrak, srdce, pečeň, skelet),</li>
  <li>steroid-rezistentnom nefrotickom syndróme,</li>
  <li>nesúlade medzi klinickým obrazom a histologickým nálezom.</li>
</ul>

<p>Odporúčania KDIGO z konferencie Controversies venovanej genetike pri CKD odporúčajú zvážiť genetické testovanie aj u kandidátov na transplantáciu a u ich potenciálnych žijúcich darcov, kde výsledok priamo mení rozhodovanie.</p>

<h2>Aký test zvoliť</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie typov genomických testov používaných v nefrológii" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Test</th><th scope="col">Kedy je vhodný</th><th scope="col">Hlavné obmedzenie</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Cielený panel génov</th><td>Úzka diferenciálna diagnóza, špecifický fenotyp</td><td>Falošne negatívny výsledok, ak kauzálny gén nie je v paneli</td></tr>
    <tr><th scope="row">Exómové sekvenovanie</th><td>Nejasná etiológia, syndrómový alebo atypický obraz</td><td>Nepokrýva nekódujúce oblasti; slabšia detekcia variantov počtu kópií</td></tr>
    <tr><th scope="row">Celogenómové sekvenovanie</th><td>Negatívny exóm pri pretrvávajúcom podozrení</td><td>Náročná analýza, viac variantov neznámeho významu, obmedzená dostupnosť</td></tr>
    <tr><th scope="row">Chromozómová mikročipová analýza</th><td>Podozrenie na väčšie štrukturálne zmeny, CAKUT, syndrómové obrazy</td><td>Nezachytí bodové varianty</td></tr>
    <tr><th scope="row">Cielená analýza známeho rodinného variantu</th><td>Kaskádové testovanie príbuzných</td><td>Platí len pre už identifikovaný variant</td></tr>
  </tbody>
</table>
</div>

<p>Posledný riadok je v praxi najčastejšie opomínaný. Ak je v rodine známy kauzálny variant, nemá zmysel u príbuzného robiť široký test – ten len vygeneruje varianty neznámeho významu a sekundárne nálezy, s ktorými bude treba niečo robiť.</p>

<h2>Čo výsledok mení</h2>

<ol>
  <li><strong>Prognóza a plánovanie.</strong> Pri mnohých monogénnych nefropatiách variant hovorí o pravdepodobnosti progresie a o očakávaných komplikáciách.</li>
  <li><strong>Voľba liečby.</strong> Fenotyp, ktorý pôsobí ako imunitne sprostredkovaný, môže byť geneticky podmienený. Pri geneticky podmienenej fokálnej segmentálnej glomeruloskleróze alebo steroid-rezistentnom nefrotickom syndróme genetická diagnóza umožňuje <em>neúčinnú imunosupresiu ukončiť</em>, nie pridať ďalšiu.</li>
  <li><strong>Transplantácia a darcovstvo.</strong> Genetický nález mení riziko recidívy v štepe a priamo ovplyvňuje posúdenie príbuzného žijúceho darcu.</li>
  <li><strong>Rodina.</strong> Kaskádové testovanie zachytí rizikových príbuzných pred vznikom nezvratného poškodenia.</li>
  <li><strong>Koniec diagnostickej odysey.</strong> Samotné pomenovanie príčiny má pre pacienta hodnotu, aj keď liečbu nemení.</li>
</ol>

<h2>Interpretácia je ťažšia než sekvenovanie</h2>

<p>Samotné nájdenie variantu nie je diagnóza. Varianty sa podľa štandardov ACMG a AMP z roku 2015 zaraďujú do piatich tried: patogénny, pravdepodobne patogénny, variant neznámeho významu, pravdepodobne benígny a benígny. Zaradenie musí zohľadniť typ variantu a predpokladaný mechanizmus, zhodu s fenotypom pacienta, populačnú frekvenciu, funkčné dôkazy a publikovanú literatúru.</p>

<p>Tri praktické dôsledky:</p>

<ul>
  <li><strong>Variant neznámeho významu nie je „slabý pozitívny nález“.</strong> Nemá viesť k zmene liečby ani k oznámeniu diagnózy rodine.</li>
  <li><strong>Zaradenie sa v čase mení.</strong> Časť variantov neznámeho významu bude preklasifikovaná oboma smermi; vyžaduje to mechanizmus opätovného posúdenia, nie jednorazový záver.</li>
  <li><strong>Bez presného fenotypu je interpretácia slabšia.</strong> Laboratórium hodnotí variant voči tomu, čo mu klinik napíše. Nepresný klinický popis znižuje výťažnosť.</li>
</ul>

<h2>Sekundárne nálezy a informovaný súhlas</h2>

<p>Americká spoločnosť pre lekársku genetiku vydáva zoznam génov, ktoré sa pri exómovom a genómovom sekvenovaní odporúča hlásiť ako sekundárne nálezy aj vtedy, keď nesúvisia s dôvodom testovania; aktuálna verzia ACMG SF v3.2 pochádza z roku 2023. Ide o gény s medicínsky uskutočniteľným dôsledkom – nádorové predispozičné syndrómy, kardiomyopatie, poruchy srdcového rytmu, familiárna hypercholesterolémia.</p>

<p>Pacient musí pred testom vedieť, čo sa bude a čo sa nebude hlásiť, a mať možnosť sekundárne nálezy odmietnuť. Predtestové poradenstvo má nastaviť tri očakávania: výsledok nemusí priniesť diagnózu, môže priniesť nejednoznačný nález a môže odhaliť niečo úplne iné.</p>

<h2>Návrh zavedenia do nefrologickej ambulancie</h2>

<ol>
  <li><strong>Štandardizovať genetickú časť anamnézy.</strong> Rodinný výskyt ochorenia obličiek a zlyhania obličiek, vek vzniku, konsangvinita, extrarenálne prejavy.</li>
  <li><strong>Stanoviť kritériá pre výber testu.</strong> Kedy panel, kedy exóm, kedy mikročip, kedy cielená analýza rodinného variantu.</li>
  <li><strong>Formulovať konkrétnu klinickú otázku.</strong> Nie „genetika obličiek“, ale čo presne sa má potvrdiť alebo vylúčiť a čo sa od výsledku očakáva.</li>
  <li><strong>Zabezpečiť interpretáciu v kontexte fenotypu</strong> a dohodnúť cestu späť k laboratóriu pri nejasnom náleze.</li>
  <li><strong>Pripraviť postup pre všetky tri možné výsledky</strong> – pozitívny, negatívny aj nejednoznačný – vrátane plánu kaskádového testovania.</li>
  <li><strong>Mať dostupné genetické poradenstvo</strong> a dokumentovať, čo bolo s pacientom dohodnuté pred testom.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Hlavný zdroj výťažnosti je z roku 2019.</strong> Kohorty boli vybrané na akademických pracoviskách; výťažnosť v bežnej ambulancii bude s veľkou pravdepodobnosťou nižšia.</li>
  <li><strong>Výťažnosť závisí od výberu pacientov.</strong> Hodnota 9,3 % platí pre uvedené kohorty, nie pre nefrologickú populáciu ako celok.</li>
  <li><strong>Technické limity pretrvávajú.</strong> Exóm spoľahlivo nezachytí varianty počtu kópií, hlboko intronické varianty, repetície ani oblasti so zlou mapovateľnosťou.</li>
  <li><strong>Dôkaz o klinickom prínose mainstreamingu chýba.</strong> Redakčný komentár sám formuluje priority pre hodnotenie – teda otázky, ktoré zatiaľ zodpovedané nie sú.</li>
  <li><strong>Chýbajú dáta o nákladovej efektívnosti v slovenských podmienkach</strong> a úhradový rámec genomických testov v nefrológii nie je ustálený.</li>
  <li><strong>Nerovnomerné zastúpenie populácií v referenčných databázach</strong> zvyšuje podiel variantov neznámeho významu u pacientov neeurópskeho pôvodu.</li>
</ul>

<h2>Záver</h2>

<p>Genomické testovanie v nefrológii nie je experiment. U pacientov s chronickým ochorením obličiek nejasnej etiológie, s pozitívnou rodinnou anamnézou a so syndrómovým alebo atypickým fenotypom prináša molekulárnu diagnózu dostatočne často na to, aby bolo indikované. Jeho hodnota však nevzniká v sekvenátore, ale v tom, čo sa deje pred testom a po ňom: v správnom výbere pacienta, v presnom fenotype, v interpretácii variantu a v tom, či má pacient zabezpečené poradenstvo pre nález, ktorý neočakával.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odborné odporúčania. Indikáciu a interpretáciu genetického testovania vykonáva príslušný špecialista.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Vela Parada XF. Mainstream Genomic Testing in Nephrology: Evidence and Priorities for Evaluation. <em>Clin J Am Soc Nephrol.</em> 2026 Oct 9 (online pred tlačou). DOI: <a href="https://doi.org/10.2215/CJN.0000001255" target="_blank" rel="noopener noreferrer">10.2215/CJN.0000001255</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42853623/" target="_blank" rel="noopener noreferrer">PubMed PMID 42853623</a>.</small></li>
  <li><small>Groopman EE, Marasa M, Cameron-Christie S, Petrovski S, Aggarwal VS, Milo-Rasouly H, Li Y, Zhang J, et al. Diagnostic Utility of Exome Sequencing for Kidney Disease. <em>N Engl J Med.</em> 2019;380(2):142–151. DOI: <a href="https://doi.org/10.1056/NEJMoa1806891" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1806891</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/30586318/" target="_blank" rel="noopener noreferrer">PubMed PMID 30586318</a>.</small></li>
  <li><small>Köttgen A, Cornec-Le Gall E, Halbritter J, Kiryluk K, Mallett AJ, Parekh RS, Milo Rasouly H, Sampson MG, et al. Genetics in chronic kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney Int.</em> 2022;101(6):1126–1141. DOI: <a href="https://doi.org/10.1016/j.kint.2022.03.019" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2022.03.019</a>.</small></li>
  <li><small>Aron AW, Dahl NK. Clinical Genetic Testing in Nephrology: Core Curriculum 2024. <em>Am J Kidney Dis.</em> 2024;84(5):632–645. DOI: <a href="https://doi.org/10.1053/j.ajkd.2024.05.011" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2024.05.011</a>.</small></li>
  <li><small>Richards S, Aziz N, Bale S, Bick D, Das S, Gastier-Foster J, Grody WW, Hegde M, Lyon E, Spector E, Voelkerding K, Rehm HL. Standards and guidelines for the interpretation of sequence variants: a joint consensus recommendation of the American College of Medical Genetics and Genomics and the Association for Molecular Pathology. <em>Genet Med.</em> 2015;17(5):405–424. DOI: <a href="https://doi.org/10.1038/gim.2015.30" target="_blank" rel="noopener noreferrer">10.1038/gim.2015.30</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25741868/" target="_blank" rel="noopener noreferrer">PubMed PMID 25741868</a>.</small></li>
  <li><small>Miller DT, Lee K, Abul-Husn NS, Amendola LM, Brothers K, Chung WK, Gollob MH, Gordon AS, et al. ACMG SF v3.2 list for reporting of secondary findings in clinical exome and genome sequencing: A policy statement of the American College of Medical Genetics and Genomics (ACMG). <em>Genet Med.</em> 2023;25(8):100866. DOI: <a href="https://doi.org/10.1016/j.gim.2023.100866" target="_blank" rel="noopener noreferrer">10.1016/j.gim.2023.100866</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Predloha uvádzala viaceré zdroje bez autorov a bez úplných bibliografických údajov; všetky boli dohľadané a overené cez PubMed eutils a Crossref vrátane ročníka, čísla a strán. Údaj o výťažnosti 9,3 % a o 1,6 % sekundárnych nálezov bol potvrdený priamo v štruktúrovanom abstrakte primárnej práce a doplnený o rozpis podľa klinických kategórií, ktorý v predlohe chýbal. Doplnený bol aj údaj, že 39 z 66 zistených monogénnych porúch sa vyskytlo len u jediného pacienta – ten je pre výber typu testu rozhodujúci. Autor projektu doplnil tabuľku porovnania testov, kapitolu o sekundárnych nálezoch s odkazom na ACMG SF v3.2, odporúčanie KDIGO ku kandidátom na transplantáciu a žijúcim darcom a rozbor limitov.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=claudiny-nefrolitiaza-geneticke-asociacie">Klaudíny a nefrolitiáza: genetické asociácie</a></li>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba CKD 2026: vrstvená nefroprotekcia</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_genomicke-testovanie-nefrologia-vytaznost-implementacia_article',
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
