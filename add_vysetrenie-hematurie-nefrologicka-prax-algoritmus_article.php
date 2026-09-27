<?php
/**
 * Odborne a jazykovo revidovany clanok o vysetreni hematurie.
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
    'title'        => 'Vyšetrenie hematurie v nefrologickej praxi: potvrdenie, urgentné stavy a určenie zdroja',
    'slug'         => 'vysetrenie-hematurie-nefrologicka-prax-algoritmus',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický algoritmus od potvrdenia erytrocytov v moči cez urgentné situácie až po rozlíšenie glomerulárneho a urologického zdroja a správnu voľbu ďalších vyšetrení.',
    'content'      => <<<'HTML'
<figure><a href="img/vysetrenie-hematurie-nefrologicka-prax-algoritmus.webp" target="_blank" rel="noopener noreferrer"><img src="img/vysetrenie-hematurie-nefrologicka-prax-algoritmus.webp" alt="Poloschematické rozlíšenie glomerulárneho a urologického zdroja erytrocytov pri vyšetrení hematurie" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Hematúria je laboratórny znak, nie diagnóza: rovnaký nález v moči môže vzniknúť v glomerule aj kdekoľvek v močových cestách.</figcaption></figure>

<p><strong>Hematúria je častý nález, ale správny postup sa nezačína diagnózou.</strong> Začína sa potvrdením, že v moči sú skutočne erytrocyty, rozpoznaním stavov vyžadujúcich neodkladný zásah a až potom určením pravdepodobného zdroja krvácania. Pozitívny testovací prúžok, červený moč a mikroskopicky potvrdená hematúria nie sú synonymá.</p>

<p>Za mikrohematúriu sa podľa AUA/SUFU považuje nález <strong>≥ 3 erytrocytov v jednom zornom poli pri veľkom zväčšení (RBC/HPF)</strong> v správne odobratej vzorke. Samotná pozitivita prúžka na krv diagnózu nestanovuje; musí viesť k mikroskopickému vyšetreniu sedimentu.</p>

<h2>Najprv odlíšme tri rozdielne situácie</h2>

<div class="table-responsive" role="region" aria-label="Rozlíšenie príčin červeného alebo hem-pozitívneho moču" tabindex="0">
<table>
<thead><tr><th scope="col">Nález</th><th scope="col">Mikroskopia</th><th scope="col">Najpravdepodobnejšie vysvetlenie</th></tr></thead>
<tbody>
<tr><th scope="row">Pozitívny prúžok na krv</th><td>Erytrocyty prítomné</td><td>Hematúria</td></tr>
<tr><th scope="row">Pozitívny prúžok na krv</th><td>Erytrocyty chýbajú alebo ich je neprimerane málo</td><td>Hemoglobinúria alebo myoglobinúria; zohľadniť lýzu erytrocytov v zriedenom či alkalickom moči</td></tr>
<tr><th scope="row">Červený alebo hnedý moč</th><td>Prúžok na krv negatívny, erytrocyty chýbajú</td><td>Pigmentúria, napríklad po červenej repe, rifampicíne alebo fenazopyridíne</td></tr>
</tbody>
</table>
</div>

<p>Prúžok deteguje peroxidázovú aktivitu hemu, nie samotný erytrocyt. Výsledok môžu ovplyvniť aj preanalytické okolnosti; napríklad vysoký príjem vitamínu C môže viesť k falošne negatívnej reakcii. Pri rozpore medzi farbou moču, prúžkom a mikroskopiou treba nález zopakovať v čerstvej, správne odobratej vzorke.</p>

<h2>Kedy nečakať na ambulantný algoritmus</h2>

<p>Urgentné alebo nemocničné vyšetrenie je potrebné najmä pri:</p>
<ul>
<li>makroskopickej hematúrii so zrazeninami, retenciou moču alebo obštrukciou,</li>
<li>hemodynamickej nestabilite, symptomatickej anémii alebo zjavnom pokračujúcom krvácaní,</li>
<li>oligúrii či anúrii, rýchlom vzostupe kreatinínu alebo podozrení na rýchlo progredujúcu glomerulonefritídu,</li>
<li>horúčke alebo sepse pri súčasnej obštrukcii močových ciest,</li>
<li>traume alebo jedinej funkčnej obličke s podozrením na obštrukciu.</li>
</ul>

<p>Zrazeninová retencia môže vyžadovať okamžitú drenáž a urologickú intervenciu. Infikovaná obštrukcia horných močových ciest je urgentný stav; samotné antibiotikum bez spriechodnenia odtoku nemusí stačiť.</p>

<h2>Potvrdenie nálezu a základné vyšetrenie</h2>

<ol>
<li><strong>Správny odber:</strong> čistý stredný prúd moču, mimo menštruácie a bez zjavnej kontaminácie; pri pochybnostiach zvážiť katetrizovanú vzorku.</li>
<li><strong>Mikroskopia:</strong> počet RBC/HPF, morfológia erytrocytov, valce, leukocyty a kryštály. Vzorka má byť vyšetrená včas.</li>
<li><strong>Anamnéza:</strong> viditeľná krv, dysúria, koliková bolesť, infekcie, kamene, trauma, intenzívna fyzická záťaž, fajčenie, pracovné expozície, lieky, rodinná anamnéza ochorenia obličiek a uroteliálneho karcinómu.</li>
<li><strong>Objektívne a laboratórne vyšetrenie:</strong> krvný tlak, kreatinín s eGFR, krvný obraz podľa kliniky, kvantifikácia albuminúrie alebo proteinúrie pomocou UACR alebo PCR a kultivácia moču pri podozrení na infekciu.</li>
</ol>

<p>Ak sa hematúria pripísala infekcii močových ciest, treba po liečbe urobiť kontrolnú mikroskopiu. To isté platí po ústupe identifikovanej gynekologickej alebo inej nezhubnej príčiny. Pretrvávanie nálezu spúšťa rizikovo stratifikované vyšetrenie.</p>

<h2>Glomerulárny alebo neglomerulárny zdroj?</h2>

<div class="table-responsive" role="region" aria-label="Znaky glomerulárnej a neglomerulárnej hematúrie" tabindex="0">
<table>
<thead><tr><th scope="col">Znak</th><th scope="col">Skôr glomerulárny zdroj</th><th scope="col">Skôr neglomerulárny zdroj</th></tr></thead>
<tbody>
<tr><th scope="row">Sediment</th><td>Akanthocyty, výrazne dysmorfné erytrocyty, erytrocytové valce</td><td>Prevažne izomorfné erytrocyty, zrazeniny</td></tr>
<tr><th scope="row">Sprievodný nález</th><td>Albuminúria/proteinúria, hypertenzia, edémy, pokles eGFR</td><td>Dysúria, kolika, retencia, urologické symptómy</td></tr>
<tr><th scope="row">Typické okruhy príčin</th><td>IgA nefropatia, ochorenia podocytov a bazálnej membrány, vaskulitída, lupusová nefritída</td><td>Nádor, urolitiáza, infekcia, trauma, ochorenie prostaty</td></tr>
</tbody>
</table>
</div>

<p>Erytrocytové valce a akanthocyty sú silnými argumentmi pre glomerulárny pôvod, ale citlivosť morfológie erytrocytov závisí od spracovania vzorky a skúsenosti hodnotiteľa. Neprítomnosť dysmorfných erytrocytov preto glomerulárne ochorenie nevylučuje. Naopak, súčasná albuminúria, hypertenzia alebo znížená eGFR významne posúvajú pravdepodobnosť smerom k parenchýmovému ochoreniu obličiek.</p>

<h2>Riziková stratifikácia mikrohematúrie podľa AUA/SUFU 2025</h2>

<p>Po vylúčení prechodnej príčiny sa ďalší urologický postup odvíja od veku, pohlavia, intenzity hematúrie, fajčenia a ďalších rizikových faktorov uroteliálneho nádoru. Hranice nižšie sa vzťahujú na dospelých bez už známej vysvetľujúcej príčiny.</p>

<div class="table-responsive" role="region" aria-label="Rizikové kategórie mikrohematúrie podľa AUA a SUFU" tabindex="0">
<table>
<thead><tr><th scope="col">Kategória</th><th scope="col">Kritériá</th><th scope="col">Odporúčaný postup</th></tr></thead>
<tbody>
<tr><th scope="row">Nízke alebo zanedbateľné riziko</th><td>Musia byť splnené všetky: 3–10 RBC/HPF; žena &lt; 60 rokov alebo muž &lt; 40 rokov; nikdy nefajčil/a alebo &lt; 10 balíčkorokov; bez ďalších rizikových faktorov</td><td>Kontrolná analýza moču do 6 mesiacov, nie okamžitá cystoskopia ani zobrazovanie</td></tr>
<tr><th scope="row">Stredné riziko</th><td>Aspoň jedno: 11–25 RBC/HPF; pretrvávanie 3–25 RBC/HPF po pôvodne nízkom riziku; žena ≥ 60 rokov; muž 40–59 rokov; 10–30 balíčkorokov; ďalší rizikový faktor</td><td>Cystoskopia a ultrasonografia obličiek a močového mechúra</td></tr>
<tr><th scope="row">Vysoké riziko</th><td>Aspoň jeden vysoko rizikový znak: &gt; 25 RBC/HPF, anamnéza makroskopickej hematúrie, muž ≥ 60 rokov, &gt; 30 balíčkorokov alebo vysoko riziková expozícia; žena sa nesmie zaradiť do vysokého rizika iba podľa veku</td><td>Cystoskopia a axiálne zobrazenie horných močových ciest</td></tr>
</tbody>
</table>
</div>

<p>Pri vysokom riziku je preferovaná viacfázová CT urografia, ak nie je kontraindikovaná. Alternatívou je MR urografia; ak nemožno použiť ani jednu, možno kombinovať retrográdnu pyelografiu s neenhancovaným axiálnym zobrazením alebo ultrasonografiou. Voľba musí zohľadniť funkciu obličiek, predchádzajúcu reakciu na kontrastnú látku, radiačnú záťaž a lokálnu dostupnosť.</p>

<p>U informovaného pacienta so stredným rizikom, ktorý sa chce vyhnúť cystoskopii, aktualizácia z roku 2025 pripúšťa použitie cytológie alebo validovaného močového nádorového markeru ako pomôcky pri rozhodovaní o cystoskopii. Ultrasonografia sa však vykoná a pri pretrvávaní mikrohematúrie sa cystoskopia doplní. Markery nie sú rutinnou náhradou cystoskopie vo vysokom riziku.</p>

<h2>Nefrológia a urológia nie sú konkurenčné cesty</h2>

<p>Proteinúria, dysmorfné erytrocyty, valce, hypertenzia alebo znížená funkcia obličiek sú dôvodom na nefrologické vyšetrenie. <strong>Podozrenie na glomerulárne ochorenie však automaticky neruší rizikovo primerané urologické vyšetrenie.</strong> Parenchýmové ochorenie obličiek a urologická príčina môžu koexistovať.</p>

<p>Ďalší nefrologický postup sa riadi klinickým syndrómom: sérológia pri podozrení na systémové ochorenie, genetika pri dlhodobej glomerulárnej hematúrii s rodinnou anamnézou, poruchou sluchu alebo zraku a biopsia, ak výsledok môže zmeniť diagnózu, prognózu alebo liečbu. Pojem „tenká glomerulová bazálna membrána“ nemožno automaticky zamieňať s neškodným stavom; spektrum ochorení COL4A3, COL4A4 a COL4A5 je klinicky širšie.</p>

<h2>Časté pasce</h2>

<ul>
<li><strong>Antikoagulanciá a antiagreganciá:</strong> nemenia potrebu štandardného vyšetrenia. Môžu krvácanie zvýrazniť, ale nemajú sa prijať ako definitívne vysvetlenie.</li>
<li><strong>Fyzická záťaž:</strong> prechodná hematúria môže ustúpiť, no pretrvávajúci nález treba vyšetriť podľa rizika.</li>
<li><strong>Kosáčikovitá črta:</strong> môže súvisieť s hematúriou, ale diagnóza sa nesmie uzavrieť bez vylúčenia iných príčin. U mladého pacienta s nevysvetlenou hematúriou treba myslieť aj na zriedkavý, agresívny renálny medulárny karcinóm.</li>
<li><strong>„Negatívna“ ultrasonografia:</strong> neuzatvára vyšetrenie pacienta vo vysokom riziku a nenahrádza cystoskopiu.</li>
</ul>

<h2>Čo po negatívnom vyšetrení?</h2>

<p>Po kompletne negatívnom rizikovo primeranom vyšetrení sa o ďalšej analýze moču rozhoduje spoločne s pacientom. Ak je kontrolná analýza negatívna, sledovanie možno ukončiť. Pri pretrvávaní alebo recidíve mikrohematúrie sa zvažuje ďalšie vyšetrenie podľa celkového rizika. Nová makroskopická hematúria, nárast počtu erytrocytov alebo nové urologické symptómy sú dôvodom na opätovné vyšetrenie.</p>

<h2>Praktický algoritmus v jednej vete</h2>

<p><strong>Prúžok → mikroskopia → urgentné príznaky → prechodná príčina → sediment, UACR/PCR a eGFR → paralelné nefrologické posúdenie a rizikovo stratifikované urologické vyšetrenie.</strong> Najväčšou chybou nie je zvoliť „nesprávnu špecializáciu“, ale predčasne uzavrieť nález jediným vysvetlením.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Prochaska M, Reynolds LF, Zisman A. Approach to Hematuria: Core Curriculum 2026. <em>Am J Kidney Dis.</em> 2026;88(4):605–614. <a href="https://doi.org/10.1053/j.ajkd.2026.05.013" target="_blank" rel="noopener noreferrer">doi:10.1053/j.ajkd.2026.05.013</a>.</em></p>
<p><em><strong>Odporúčanie:</strong> American Urological Association, Society of Urodynamics, Female Pelvic Medicine &amp; Urogenital Reconstruction. <a href="https://www.auanet.org/documents/Guidelines/PDF/Microhematuria-Guideline.pdf" target="_blank" rel="noopener noreferrer">Microhematuria: AUA/SUFU Guideline (2020, amended 2025)</a>.</em></p>
<p><em><strong>Aktualizácia:</strong> Barocas DA, Lotan Y, Matulewicz RS, et al. Updates to Microhematuria: AUA/SUFU Guideline (2025). <em>J Urol.</em> 2025;213(5):547–557. <a href="https://doi.org/10.1097/JU.0000000000004490" target="_blank" rel="noopener noreferrer">doi:10.1097/JU.0000000000004490</a>.</em></p>

<p><small><em>Text je odborným prehľadom pre zdravotníckych pracovníkov. Konkrétny postup treba prispôsobiť klinickému stavu, dostupnosti vyšetrení a lokálnym odporúčaniam.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vysetrenie-hematurie-nefrologicka-prax-algoritmus_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
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
}
