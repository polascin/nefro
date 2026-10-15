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
    'title' => 'Multimorbidita a rozpor medzi eGFR z kreatinínu a z cystatínu C',
    'slug' => 'multimorbidita-discordancia-egfr-kreatinin-cystatin-c',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Analýza UK Biobank ukazuje, že s počtom dlhodobých ochorení prudko rastie rozpor medzi eGFRcr a eGFRcys. Pätnásť percent účastníkov sa po prepočte presunulo do pokročilejšieho štádia CKD.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/multimorbidita-discordancia-egfr-kreatinin-cystatin-c.webp" type="image/webp">
    <img src="img/multimorbidita-discordancia-egfr-kreatinin-cystatin-c.png" alt="Poloschematický graf: dve svetelné krivky sa rozchádzajú, klin medzi nimi sa rozširuje s pribúdajúcimi dlhodobými ochoreniami; spodná krivka prekračuje hranicu štádia" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie skutočné dáta. Čím viac dlhodobých ochorení pacient má, tým väčší je rozpor medzi oboma odhadmi – a tým častejšie sa mení zaradenie do štádia CKD.</figcaption>
</figure>

<p>Odhadovaná glomerulárna filtrácia je najpoužívanejším číslom v nefrológii. Takmer vždy ju počítame zo sérového kreatinínu, hoci vieme, že jeho koncentráciu okrem filtrácie určuje aj svalová hmota, príjem bielkovín, tubulárna sekrécia a niektoré lieky. Cystatín C týmto vplyvom nepodlieha, zato ho ovplyvňuje zápal, funkcia štítnej žľazy, tuková hmota a glukokortikoidy.</p>

<p>Keď oba odhady u toho istého človeka dajú výrazne odlišný výsledok, hovoríme o <strong>rozpore eGFR</strong> (eGFR discordance). Nejde o laboratórnu kuriozitu: ak je eGFRcys podstatne nižšia než eGFRcr, spája sa to s horšou prognózou. Nová analýza z UK Biobank kvantifikuje, u koho sa tento rozpor vyskytuje najčastejšie, a odpoveď je prakticky použiteľná – rozhoduje počet dlhodobých ochorení.</p>

<h2>Dizajn analýzy</h2>

<p>Pracovalo sa s údajmi viac než 400 000 účastníkov UK Biobank. Obe hodnoty eGFR sa počítali rovnicami European Kidney Function Consortium (EKFC), čo je metodicky podstatné: použitie jednej rovnicovej rodiny pre kreatinín aj cystatín C odstraňuje časť rozdielu, ktorý by inak vznikol len odlišnou kalibráciou vzorcov.</p>

<p><strong>Veľký negatívny rozdiel eGFR</strong> bol definovaný ako eGFRcys nižšia o viac než 30 % oproti eGFRcr, teda (eGFRcys − eGFRcr) / eGFRcr &lt; −30 %.</p>

<p>Dlhodobé ochorenia boli <strong>samohlásené</strong> a sčítavali sa celkovo aj podľa typu – kardiometabolické, nekardiometabolické a zmiešané duševné a telesné. Multimorbidita znamenala dve a viac dlhodobých ochorení akéhokoľvek typu. Logistické regresné modely boli upravené na vek, pohlavie, index telesnej hmotnosti, fajčiarsky status a ochorenie štítnej žľazy.</p>

<h2>Výsledky</h2>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky analýzy rozporu eGFR v UK Biobank" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Zistenie</th><th scope="col">Hodnota</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Multimorbidita v celej kohorte</th><td>33 %</td></tr>
    <tr><th scope="row">Multimorbidita u osôb s veľkým negatívnym rozdielom eGFR</th><td>63 %</td></tr>
    <tr><th scope="row">Preradenie do pokročilejšieho štádia CKD po prepočte podľa eGFRcys</th><td>15 % kohorty</td></tr>
    <tr><th scope="row">Veľký negatívny rozdiel pri 4 a viac dlhodobých ochoreniach oproti žiadnemu</th><td>upravený OR 4,64 (95 % IS 4,13 – 5,21)</td></tr>
  </tbody>
</table>
</div>

<p>Frekvencia preradenia do pokročilejšieho štádia CKD <strong>progresívne stúpala s počtom dlhodobých ochorení</strong>. Nejde teda o prahový jav, ale o plynulý gradient: čím viac pridružených ochorení, tým vyššia pravdepodobnosť, že kreatinín nadhodnocuje funkciu obličiek.</p>

<h2>Prečo rozpor vzniká</h2>

<p>Smer rozporu je informatívny. Veľký negatívny rozdiel – teda nižšia eGFRcys – vzniká najčastejšie v dvoch konšteláciách:</p>

<ul>
  <li><strong>Kreatinín nadhodnocuje funkciu obličiek.</strong> Pri sarkopénii, kachexii, imobilite, cirhóze, amputácii alebo nízkom príjme bielkovín je tvorba kreatinínu znížená. Sérová hodnota vyzerá priaznivo, hoci filtrácia je nízka. Multimorbidný starší pacient do tejto skupiny spadá typicky.</li>
  <li><strong>Cystatín C podhodnocuje funkciu obličiek.</strong> Pri systémovom zápale, obezite, hypertyreóze alebo liečbe glukokortikoidmi sa jeho tvorba zvyšuje nezávisle od filtrácie.</li>
</ul>

<p>Pri multimorbidite pôsobia oba mechanizmy naraz a v rovnakom smere, čo vysvetľuje viac než štvornásobnú šancu veľkého rozporu. Dôležité je, že <strong>analýza nevie určiť, ktorý z oboch odhadov je bližšie k skutočnej meranej filtrácii</strong>. Vie len to, že sa rozchádzajú.</p>

<p>Literatúra k tomu dodáva prognostický rozmer: nižšia eGFRcys oproti eGFRcr sa spája s krehkosťou a s vyšším rizikom nepriaznivých udalostí. Rozpor teda nie je len technický šum, ale nesie klinickú informáciu sám osebe.</p>

<h2>Čo z toho pre prax</h2>

<ol>
  <li><strong>Pri multimorbidnom pacientovi nepovažovať eGFRcr za hotovú odpoveď.</strong> Platí to najmä pri štyroch a viacerých dlhodobých ochoreniach.</li>
  <li><strong>Cystatín C doplniť vtedy, keď na presnom zaradení záleží.</strong> Hranica CKD 3b/4, rozhodnutie o odoslaní k nefrológovi, príprava na náhradu funkcie obličiek, hodnotenie rizika progresie.</li>
  <li><strong>Cystatín C doplniť aj pri zjavnej nezhode medzi klinikou a laboratórnym nálezom.</strong> Výrazná sarkopénia, strata hmotnosti, imobilita, cirhóza, stav po amputácii.</li>
  <li><strong>Rozhodujúci je vplyv na dávkovanie liekov.</strong> Pri priamych perorálnych antikoagulanciách, antibiotikách, gabapentinoidoch, metformíne a cytostatikách môže nadhodnotená eGFR viesť k predávkovaniu u krehkého pacienta. KDIGO 2024 odporúča pri dávkovaní liekov s úzkym terapeutickým oknom používať neindexovanú eGFR v ml/min, nie hodnotu prepočítanú na 1,73 m².</li>
  <li><strong>Rozpor interpretovať, nie automaticky uprednostniť nižšiu hodnotu.</strong> Pri aktívnom zápale alebo liečbe glukokortikoidmi je nižšia eGFRcys pravdepodobne skreslená smerom nadol.</li>
  <li><strong>Pri pretrvávajúcej neistote zvážiť meranú clearance.</strong> Zber moču alebo exogénny marker zostávajú referenčnou metódou, keď rozhodnutie nesmie stáť na odhade.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Dlhodobé ochorenia boli samohlásené.</strong> Nejde o overené diagnózy z dokumentácie, čo prináša informačné skreslenie oboma smermi.</li>
  <li><strong>UK Biobank nie je bežná klinická populácia.</strong> Účastníci sú zdravší a sociálne-ekonomicky vybranejší než priemer; absolútne podiely sa nedajú preniesť na nefrologickú ambulanciu.</li>
  <li><strong>Chýba referenčná meraná glomerulárna filtrácia.</strong> Bez nej nemožno určiť, ktorý odhad je presnejší; práca hodnotí zhodu, nie správnosť.</li>
  <li><strong>Ide o asociáciu, nie o príčinnosť.</strong> Prierezový dizajn neumožňuje tvrdiť, že multimorbidita rozpor spôsobuje.</li>
  <li><strong>Práca nehodnotí klinický prínos doplnenia cystatínu C.</strong> Záver o jeho testovaní je logickým dôsledkom zistenia, nie overeným výsledkom intervenčnej štúdie.</li>
  <li><strong>Dostupnosť a cena.</strong> Cystatín C nie je v slovenskej praxi bežne dostupný vo všetkých laboratóriách; cielené použitie vo vybraných situáciách je preto realistickejšie než plošné.</li>
</ul>

<h2>Záver</h2>

<p>Rozpor medzi eGFR z kreatinínu a z cystatínu C sa s počtom dlhodobých ochorení výrazne zväčšuje. U pacientov so štyrmi a viacerými pridruženými ochoreniami je veľký negatívny rozdiel viac než štyrikrát pravdepodobnejší a 15 % celej kohorty sa po prepočte podľa cystatínu C ocitlo v pokročilejšom štádiu CKD. Autori preto odporúčajú u multimorbidných pacientov zvážiť vyšetrenie cystatínu C popri kreatiníne, aby sa spresnil odhad funkcie obličiek a stratifikácia rizika. Práve u pacienta, ktorý je krehký a má veľa diagnóz, je samotný kreatinín najmenej spoľahlivý.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odborné odporúčania.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Mayne KJ, Walker H, Sullivan MK, Jani B, Welsh P, Liu Q, Pell JP, Ho FK, Mark PB, Lees JS. Association between multimorbidity and discordance between creatinine- and cystatin C-based eGFR. <em>Nephrol Dial Transplant.</em> 2026 Oct 10:gfag232 (online pred tlačou). DOI: <a href="https://doi.org/10.1093/ndt/gfag232" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag232</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42858001/" target="_blank" rel="noopener noreferrer">PubMed PMID 42858001</a>.</small></li>
  <li><small>Pottel H, Björk J, Rule AD, Ebert N, Eriksen BO, Dubourg L, Cavalier E, et al. Cystatin C-Based Equation to Estimate GFR without the Inclusion of Race and Sex. <em>N Engl J Med.</em> 2023;388(4):333–343. DOI: <a href="https://doi.org/10.1056/NEJMoa2203769" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2203769</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36720134/" target="_blank" rel="noopener noreferrer">PubMed PMID 36720134</a>.</small></li>
  <li><small>Pottel H, Björk J, Courbebaisse M, Couzi L, Ebert N, Eriksen BO, et al. Development and Validation of a Modified Full Age Spectrum Creatinine-Based Equation to Estimate Glomerular Filtration Rate: A Cross-sectional Analysis of Pooled Data. <em>Ann Intern Med.</em> 2021;174(2):183–191. DOI: <a href="https://doi.org/10.7326/M20-4366" target="_blank" rel="noopener noreferrer">10.7326/M20-4366</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33166224/" target="_blank" rel="noopener noreferrer">PubMed PMID 33166224</a>.</small></li>
  <li><small>Potok OA, Ix JH, Shlipak MG, Katz R, Hawfield AT, Rocco MV, Ambrosius WT, Cho ME, Pajewski NM, Rastogi A, Rifkin DE. The Difference Between Cystatin C- and Creatinine-Based Estimated GFR and Associations With Frailty and Adverse Outcomes: A Cohort Analysis of the Systolic Blood Pressure Intervention Trial (SPRINT). <em>Am J Kidney Dis.</em> 2020;76(6):765–774. DOI: <a href="https://doi.org/10.1053/j.ajkd.2020.05.017" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2020.05.017</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32682697/" target="_blank" rel="noopener noreferrer">PubMed PMID 32682697</a>.</small></li>
  <li><small>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney Int.</em> 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">plné znenie odporúčania (PDF)</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Všetky číselné údaje pochádzajú zo štruktúrovaného abstraktu primárnej práce a boli overené cez PubMed eutils; autorský zoznam, DOI a dátum publikácie boli nezávisle potvrdené cez Crossref. V predlohe chýbalo upozornenie, že analýza nedokáže určiť, ktorý z dvoch odhadov je bližšie k meranej filtrácii, a že rovnice EKFC boli použité pre oba markery. Autor projektu doplnil mechanizmy vzniku rozporu v oboch smeroch, prognostický kontext z kohorty SPRINT, odporúčanie KDIGO 2024 k dávkovaniu liekov podľa neindexovanej eGFR a rozšírený rozbor limitov.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=uacr-upcr-prognosticka-informacia-ckd">UACR a UPCR: akú prognostickú informáciu nesú pri CKD</a></li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Klinická krehkosť a mortalita v dialyzačnej populácii</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba CKD 2026: vrstvená nefroprotekcia</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_multimorbidita-discordancia-egfr-kreatinin-cystatin-c_article',
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
