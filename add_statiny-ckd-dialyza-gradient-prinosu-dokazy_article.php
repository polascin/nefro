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
    'title' => 'Prečo prínos statínov klesá s pokročilosťou CKD: SHARP, 4D a AURORA',
    'slug' => 'statiny-ckd-dialyza-gradient-prinosu-dokazy',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Randomizované dôkazy pri CKD nie sú jednoliate. Pri nedialyzovanej CKD znižuje liečba aterosklerotické príhody o 17 %, v dialýze dve veľké štúdie zlyhali. Prečo a čo z toho vyplýva pre prax.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/statiny-ckd-dialyza-gradient-prinosu-dokazy.webp" type="image/webp">
    <img src="img/statiny-ckd-dialyza-gradient-prinosu-dokazy.png" alt="Poloschematický rez tepnou, ktorá sa smerom doprava zužuje a plní aterogénnymi časticami, pod ňou klesajúce stĺpce znázorňujúce ubúdajúci prínos liečby" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie skutočné dáta. Aterogénna záťaž s pokročilosťou obličkového ochorenia rastie, preukázaný prínos liečby znižujúcej LDL však klesá.</figcaption>
</figure>

<p>Pri chronickom ochorení obličiek platí zdanlivo paradoxný vzťah: čím pokročilejšie je obličkové ochorenie, tým vyššie je kardiovaskulárne riziko – a tým slabší je doložený prínos liečby znižujúcej LDL cholesterol. Tento gradient nie je štatistickou náhodou. Vysvetľuje ho zmena podielu aterosklerotických príhod na celkovej kardiovaskulárnej mortalite, a práve on je dôvodom, prečo sa odporúčanie KDIGO v otázke dialyzovaných pacientov líši od intuitívneho očakávania.</p>

<p>Tento text nie je ďalším prehľadom cieľových hodnôt – tým sa venujú samostatné články uvedené na konci. Sústredí sa na to, čo randomizované štúdie pri CKD skutočne ukázali a prečo sa ich výsledky tak výrazne rozchádzajú.</p>

<h2>Tri štúdie, tri odpovede</h2>

<div class="table-responsive" role="region" aria-label="Randomizované štúdie liečby znižujúcej LDL cholesterol pri chronickom ochorení obličiek a v dialýze" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Štúdia</th><th scope="col">Populácia</th><th scope="col">Intervencia</th><th scope="col">Hlavný výsledok</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">SHARP (2011)</th><td>CKD vrátane dialyzovaných; 4 650 vs 4 620 účastníkov</td><td>Simvastatín 20 mg + ezetimib 10 mg</td><td>Veľké aterosklerotické príhody 526 (11,3 %) vs 619 (13,4 %); RR 0,83; 95 % IS 0,74 – 0,94; p = 0,0021</td></tr>
    <tr><th scope="row">4D (2005)</th><td>Diabetes 2. typu na hemodialýze</td><td>Atorvastatín 20 mg</td><td>Primárny zložený ukazovateľ RR 0,92; 95 % IS 0,77 – 1,10; p = 0,37</td></tr>
    <tr><th scope="row">AURORA (2009)</th><td>Hemodialyzovaní pacienti</td><td>Rosuvastatín 10 mg</td><td>Primárny ukazovateľ HR 0,96; 95 % IS 0,84 – 1,11; p = 0,59</td></tr>
  </tbody>
</table>
</div>

<p>Štúdia SHARP dosiahla počas mediánu sledovania 4,9 roka aj významné zníženie nehemoragickej cievnej mozgovej príhody (131 [2,8 %] vs 174 [3,8 %]; RR 0,75; 95 % IS 0,60 – 0,94; p = 0,01) a arteriálnych revaskularizácií (284 [6,1 %] vs 352 [7,6 %]; RR 0,79; 95 % IS 0,68 – 0,93; p = 0,0036). Bez štatisticky významného rozdielu zostala koronárna choroba srdca (213 [4,6 %] vs 230 [5,0 %]; RR 0,92; 95 % IS 0,76 – 1,11; p = 0,37). Nepreukázal sa nadbytok hepatitídy, žlčových kameňov ani nádorových ochorení.</p>

<p>V štúdii 4D atorvastatín neovplyvnil primárny ukazovateľ, znížil nominálne všetky srdcové príhody dohromady (RR 0,82; 95 % IS 0,68 – 0,99; p = 0,03), ale <strong>relatívne riziko fatálnej cievnej mozgovej príhody bolo v ramene s atorvastatínom 2,03</strong> (95 % IS 1,05 – 3,93; p = 0,04). Ide o nález z mnohonásobného testovania a nepotvrdil sa v ďalších štúdiách, pri rozhodovaní ho však nemožno ignorovať.</p>

<p>V štúdii AURORA rosuvastatín znížil LDL cholesterol o 43 % z priemernej východiskovej hodnoty 2,6 mmol/l, no počas mediánu sledovania 3,8 roka neovplyvnil primárny ukazovateľ ani celkovú mortalitu (HR 0,96; 95 % IS 0,86 – 1,07; p = 0,51).</p>

<h2>Prečo dialýza výsledok mení</h2>

<p>Rozdiel nespočíva v tom, že by statín v dialýze „neúčinkoval“. LDL cholesterol klesal v oboch dialyzačných štúdiách podľa očakávania. Vysvetlenia sú iné:</p>

<ul>
  <li><strong>Zmena spektra kardiovaskulárnych príhod.</strong> U dialyzovaných pacientov tvoria veľkú časť kardiovaskulárnych úmrtí náhla srdcová smrť, arytmie a zlyhanie srdca – teda udalosti, ktoré nie sú primárne aterotrombotické a na zníženie LDL neodpovedajú.</li>
  <li><strong>Mediálna kalcifikácia namiesto aterómu.</strong> Cievne postihnutie pri pokročilej CKD má odlišnú patológiu: kalcifikácia médie, zvýšená tuhosť tepien, porucha metabolizmu kostí a minerálov.</li>
  <li><strong>Konkurenčné riziko úmrtia.</strong> Pri vysokej celkovej mortalite sa dlhodobý prínos preventívnej liečby nestihne prejaviť.</li>
  <li><strong>Neskoré nasadenie.</strong> Ateroskleróza je dôsledkom kumulatívnej expozície. Začať liečbu v okamihu, keď je proces desaťročia rozbehnutý, prináša menej než začať skôr.</li>
</ul>

<p>Štúdia SHARP tento výklad podporuje aj tým, že zaradila prevažne nedialyzovaných pacientov a prínos bol zreteľný práve pri aterosklerotických ukazovateľoch, nie pri celkovej kardiovaskulárnej mortalite.</p>

<h2>Dve odlišné logiky odporúčaní</h2>

<p>Z toho vyplýva najčastejší zdroj nedorozumenia pri lôžku pacienta – dve odporúčania hovoria odlišným jazykom.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie prístupu KDIGO a ESC/EAS k liečbe dyslipidémie pri CKD" tabindex="0">
<table>
  <thead>
    <tr><th scope="col"></th><th scope="col">KDIGO (lipidy pri CKD)</th><th scope="col">ESC/EAS (dyslipidémie)</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Logika</th><td>Liečba podľa rizikovej skupiny</td><td>Liečba podľa cieľovej hodnoty LDL</td></tr>
    <tr><th scope="row">Opakované meranie lipidov</th><td>Spravidla nie je potrebné</td><td>Áno, na kontrolu dosiahnutia cieľa</td></tr>
    <tr><th scope="row">Eskalácia pri nedosiahnutí cieľa</th><td>Neodporúča sa iba pre nedosiahnutú hodnotu</td><td>Odporúča sa doplniť ezetimib, prípadne inhibítor PCSK9</td></tr>
    <tr><th scope="row">Dialyzovaný pacient</th><td>Nezačínať statín u väčšiny prevalentných pacientov</td><td>Nezačínať pri absencii aterosklerotického ochorenia</td></tr>
  </tbody>
</table>
</div>

<p>Prístup KDIGO sa v literatúre označuje ako „fire and forget“ – nasadiť účinný režim v indikovanej skupine a ďalej netitrovať podľa čísla. Prístup ESC/EAS je „treat to target“. Obidva vychádzajú z tých istých štúdií; líšia sa v tom, nakoľko dôverujú prenosnosti vzťahu medzi dosiahnutým LDL a klinickým prínosom do populácie CKD.</p>

<p>Praktický kompromis, ktorý funguje: <strong>v indikovanej skupine nasadiť statín alebo kombináciu so ezetimibom a neeskalovať iba kvôli číslu</strong>, pri súčasnom aterosklerotickom kardiovaskulárnom ochorení však postupovať podľa cieľovej logiky, pretože tam je dôkazová základňa pre intenzívnejšie znižovanie LDL najsilnejšia.</p>

<h2>Čo s pacientom, ktorý statín už užíva a začína dialýzu</h2>

<p>Odporúčanie nezačínať statín u prevalentných hemodialyzovaných pacientov <strong>nie je pokynom vysadiť liečbu tým, ktorí ju už užívajú.</strong> Randomizovaný dôkaz pre vysadenie neexistuje; štúdie 4D a AURORA testovali <em>začatie</em> liečby, nie jej ukončenie. Pri pacientovi so zavedenou liečbou a s aterosklerotickým ochorením v anamnéze je rozumnejšie pokračovať a prehodnotiť liečbu podľa tolerancie, interakcií, celkovej prognózy a cieľov starostlivosti.</p>

<h2>Statíny a proteinúria</h2>

<p>Štúdia PLANET I porovnávala renálne účinky atorvastatínu a rosuvastatínu u pacientov s diabetom a proteinúriou v 147 centrách v jedenástich krajinách. Dôležité je správne pochopenie zistenia: nejde o dôkaz nefrotoxicity statínov ako skupiny, ale o upozornenie, že <strong>vysoké dávky rosuvastatínu môžu nepriaznivo ovplyvniť renálne ukazovatele u pacientov s významnou proteinúriou</strong>. Praktickým záverom je používať najnižšiu účinnú dávku, eskalovať nie iba podľa lipidov, a pri výraznej proteinúrii sledovať popri lipidoch aj funkciu obličiek.</p>

<h2>Nestatínová liečba pri CKD</h2>

<ul>
  <li><strong>Ezetimib</strong> má pri CKD najlepšie postavenie, pretože bol súčasťou intervencie v štúdii SHARP – tá teda testovala kombináciu, nie samotný statín.</li>
  <li><strong>Inhibítory PCSK9</strong> znižujú LDL výrazne a analýzy podľa funkcie obličiek nenaznačujú odlišný bezpečnostný profil. Randomizovaná štúdia s tvrdými ukazovateľmi špecificky pri pokročilej CKD alebo v dialýze však chýba.</li>
  <li><strong>Inklisiran</strong> bol hodnotený aj u pacientov s poruchou funkcie obličiek v analýze štúdií ORION-7 a ORION-1; farmakokinetika, účinnosť a bezpečnosť sa naprieč stupňami renálnej poruchy zásadne nelíšili. Ide o farmakologickú, nie výsledkovú štúdiu; pacienti v dialýze zaradení neboli.</li>
  <li><strong>Bempedoová kyselina</strong> preukázala kardiovaskulárny prínos u pacientov s intoleranciou statínov v štúdii CLEAR Outcomes; vopred stanovená analýza podľa prítomnosti diabetu potvrdila zníženie zloženého ukazovateľa a nepreukázala zvýšenie rizika nového diabetu. Pri CKD treba sledovať kreatinín a kyselinu močovú.</li>
  <li><strong>Fibráty</strong> majú pri zníženej funkcii obličiek obmedzené miesto pre bezpečnostné dôvody a pre nejednoznačný kardiovaskulárny prínos v tejto populácii.</li>
</ul>

<h2>Limity</h2>

<ul>
  <li><strong>Štúdia SHARP netestovala samotný statín.</strong> Intervenciou bola kombinácia simvastatínu s ezetimibom, takže podiel jednotlivých zložiek na účinku nemožno oddeliť.</li>
  <li><strong>Štúdie 4D a AURORA boli negatívne, nie noninferioritné.</strong> Nedokazujú, že liečba v dialýze neúčinkuje; dokazujú, že v danom usporiadaní sa prínos nepreukázal.</li>
  <li><strong>Nález o fatálnej cievnej mozgovej príhode v štúdii 4D</strong> pochádza z mnohonásobného testovania sekundárnych ukazovateľov a nebol replikovaný.</li>
  <li><strong>Dôkazy sú staré 15 až 20 rokov.</strong> Súbežná liečba sa odvtedy výrazne zmenila – inhibítory SGLT2, agonisty GLP-1, nesteroidné antagonisty mineralokortikoidných receptorov. Výsledky dnešnej dialyzačnej populácie môžu vyzerať inak.</li>
  <li><strong>Pre nestatínovú liečbu pri pokročilej CKD chýbajú výsledkové štúdie.</strong> Dostupné sú analýzy podskupín a farmakologické štúdie.</li>
  <li><strong>Transplantovaní pacienti sú samostatná skupina</strong> s osobitným rizikom interakcií medzi statínmi a kalcineurínovými inhibítormi; tomuto článku sa vymykajú.</li>
</ul>

<h2>Záver</h2>

<p>Prínos liečby znižujúcej LDL cholesterol pri chronickom ochorení obličiek nie je rovnomerný. U nedialyzovaných pacientov je doložený a klinicky významný – kombinácia simvastatínu s ezetimibom znížila veľké aterosklerotické príhody o 17 %. V dialyzačnej populácii dve veľké randomizované štúdie prínos nepreukázali, a to nie preto, že by LDL neklesal, ale preto, že sa mení samotná povaha kardiovaskulárneho rizika.</p>

<p>Z toho vyplýva praktické pravidlo, ktoré nie je kompromisom, ale záverom z dôkazov: <strong>liečbu začať včas, kým je ochorenie obličiek ešte v skorších štádiách</strong>, a nespoliehať sa na to, že ju dobehneme v dialýze.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani súhrn charakteristických vlastností lieku.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Baigent C, Landray MJ, Reith C, Emberson J, Wheeler DC, Tomson C, Wanner C, Krane V, Cass A, Craig J, Neal B, et al.; SHARP Investigators. The effects of lowering LDL cholesterol with simvastatin plus ezetimibe in patients with chronic kidney disease (Study of Heart and Renal Protection): a randomised placebo-controlled trial. <em>Lancet.</em> 2011;377(9784):2181–2192. DOI: <a href="https://doi.org/10.1016/S0140-6736(11)60739-3" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(11)60739-3</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/21663949/" target="_blank" rel="noopener noreferrer">PubMed PMID 21663949</a>.</small></li>
  <li><small>Wanner C, Krane V, März W, Olschewski M, Mann JF, Ruf G, Ritz E; German Diabetes and Dialysis Study Investigators. Atorvastatin in patients with type 2 diabetes mellitus undergoing hemodialysis. <em>N Engl J Med.</em> 2005;353(3):238–248. DOI: <a href="https://doi.org/10.1056/NEJMoa043545" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa043545</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/16034009/" target="_blank" rel="noopener noreferrer">PubMed PMID 16034009</a>.</small></li>
  <li><small>Fellström BC, Jardine AG, Schmieder RE, Holdaas H, Bannister K, Beutler J, Chae DW, Chevaile A, Cobbe SM, Grönhagen-Riska C, et al.; AURORA Study Group. Rosuvastatin and cardiovascular events in patients undergoing hemodialysis. <em>N Engl J Med.</em> 2009;360(14):1395–1407. DOI: <a href="https://doi.org/10.1056/NEJMoa0810177" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa0810177</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/19332456/" target="_blank" rel="noopener noreferrer">PubMed PMID 19332456</a>.</small></li>
  <li><small>Wanner C, Tonelli M; Kidney Disease: Improving Global Outcomes Lipid Guideline Development Work Group Members. KDIGO Clinical Practice Guideline for Lipid Management in CKD: summary of recommendation statements and clinical approach to the patient. <em>Kidney Int.</em> 2014;85(6):1303–1309. DOI: <a href="https://doi.org/10.1038/ki.2014.31" target="_blank" rel="noopener noreferrer">10.1038/ki.2014.31</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/24552851/" target="_blank" rel="noopener noreferrer">PubMed PMID 24552851</a>.</small></li>
  <li><small>Mach F, Baigent C, Catapano AL, Koskinas KC, Casula M, Badimon L, Chapman MJ, De Backer GG, Delgado V, Ference BA, et al.; ESC Scientific Document Group. 2019 ESC/EAS Guidelines for the management of dyslipidaemias: lipid modification to reduce cardiovascular risk. <em>Eur Heart J.</em> 2020;41(1):111–188. DOI: <a href="https://doi.org/10.1093/eurheartj/ehz455" target="_blank" rel="noopener noreferrer">10.1093/eurheartj/ehz455</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31504418/" target="_blank" rel="noopener noreferrer">PubMed PMID 31504418</a>.</small></li>
  <li><small>de Zeeuw D, Anzalone DA, Cain VA, Cressman MD, Heerspink HJ, Molitoris BA, Monyak JT, Parving HH, Remuzzi G, Sowers JR, Vidt DG. Renal effects of atorvastatin and rosuvastatin in patients with diabetes who have progressive renal disease (PLANET I): a randomised clinical trial. <em>Lancet Diabetes Endocrinol.</em> 2015;3(3):181–190. DOI: <a href="https://doi.org/10.1016/S2213-8587(14)70246-3" target="_blank" rel="noopener noreferrer">10.1016/S2213-8587(14)70246-3</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25660356/" target="_blank" rel="noopener noreferrer">PubMed PMID 25660356</a>.</small></li>
  <li><small>Wright RS, Collins MG, Stoekenbroek RM, Robson R, Wijngaard PLJ, Landmesser U, Leiter LA, Kastelein JJP, Ray KK, Kallend D. Effects of Renal Impairment on the Pharmacokinetics, Efficacy, and Safety of Inclisiran: An Analysis of the ORION-7 and ORION-1 Studies. <em>Mayo Clin Proc.</em> 2020;95(1):77–89. DOI: <a href="https://doi.org/10.1016/j.mayocp.2019.08.021" target="_blank" rel="noopener noreferrer">10.1016/j.mayocp.2019.08.021</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31630870/" target="_blank" rel="noopener noreferrer">PubMed PMID 31630870</a>.</small></li>
  <li><small>Ray KK, Nicholls SJ, Li N, Louie MJ, Brennan D, Lincoff AM, Nissen SE; CLEAR Outcomes Committees and Investigators. Efficacy and safety of bempedoic acid among patients with and without diabetes: prespecified analysis of the CLEAR Outcomes randomised clinical trial. <em>Lancet Diabetes Endocrinol.</em> 2024;12(1):19–28. DOI: <a href="https://doi.org/10.1016/S2213-8587(23)00316-9" target="_blank" rel="noopener noreferrer">10.1016/S2213-8587(23)00316-9</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38061370/" target="_blank" rel="noopener noreferrer">PubMed PMID 38061370</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Predloha neuvádzala žiadnu z randomizovaných štúdií, o ktoré sa odporúčanie KDIGO pre dialyzovaných pacientov opiera; doplnené boli SHARP, 4D a PLANET I vrátane číselných výsledkov zo štruktúrovaných abstraktov, a doplnený bol aj úplný autorský zoznam a presná bibliografia ku všetkým zdrojom, ktoré predloha uvádzala neúplne. Keďže web už obsahuje tri články o cieľových hodnotách pri dyslipidémii, tento text sa zámerne sústreďuje na rozdiel v dôkazovej základni naprieč štádiami CKD a na vysvetlenie, prečo sú výsledky v dialyzačnej populácii negatívne. Autor projektu doplnil rozlíšenie medzi „nezačínať“ a „vysadiť“ liečbu, patofyziologické vysvetlenie gradientu prínosu a rozbor limitov. Všetky bibliografické údaje boli overené cez PubMed eutils a Crossref.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax">Dyslipidémia pri CKD podľa odporúčaní ACC/AHA 2026</a></li>
  <li><a href="article.php?slug=dyslipidemia-2026-kardiovaskularne-riziko-ldl-ciele-ckd">Dyslipidémia 2026: kardiovaskulárne riziko a cieľové hodnoty LDL</a></li>
  <li><a href="article.php?slug=neziaduce-ucinky-statinov-dokazy-nefrologia">Nežiaduce účinky statínov: čo hovoria dôkazy</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_statiny-ckd-dialyza-gradient-prinosu-dokazy_article',
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
