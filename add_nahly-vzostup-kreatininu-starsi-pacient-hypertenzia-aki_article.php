<?php
/**
 * Odborný článok: Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou.
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

$articles = [];

$articles[] = [
    'title'        => 'Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup',
    'slug'         => 'nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Náhly vzostup kreatinínu u seniora vyžaduje potvrdenie dynamiky, zhodnotenie diurézy, objemového stavu, liekov, močového nálezu a vylúčenie obštrukcie aj urgentných komplikácií.',
    'content'      => <<<'HTML'
<p>Náhly vzostup sérového kreatinínu, napríklad z 90 na 160 µmol/l u približne 80-ročného pacienta, je klinicky významný nález. Ak vznikol počas predchádzajúcich siedmich dní, hodnota sa zvýšila na 1,78-násobok východiskovej koncentrácie a spĺňa kreatinínové kritérium akútneho poškodenia obličiek (<em>acute kidney injury</em>, AKI) 1. stupňa podľa KDIGO. Ak časový priebeh nie je známy, samotná koncentrácia 160 µmol/l AKI nedokazuje. Môže ísť o akútnu zmenu, akútne poškodenie na podklade chronickej choroby obličiek (CKD), doteraz nepoznanú CKD alebo zriedkavejšie o vzostup kreatinínu bez skutočného poklesu glomerulovej filtrácie.</p>

<p>Vyšší vek, hypertenzia, ateroskleróza, srdcové zlyhávanie, CKD, krehkosť a polyfarmácia zvyšujú riziko AKI. Nie je však správne automaticky pripísať každý vzostup kreatinínu „hypertenznej nefropatii“ alebo veku. Diagnostika musí určiť časový priebeh, závažnosť, bezprostredné komplikácie a pravdepodobnú príčinu.</p>

<h2>Kedy ide o akútne poškodenie obličiek</h2>

<p>Podľa finálneho odporúčania KDIGO sa AKI diagnostikuje pri splnení aspoň jedného z troch kritérií: vzostup sérového kreatinínu o najmenej 26,5 µmol/l počas 48 hodín, vzostup na najmenej 1,5-násobok východiskovej hodnoty počas predchádzajúcich siedmich dní alebo pokles diurézy pod 0,5 ml/kg/h počas najmenej šiestich hodín. Aktuálna verzia NICE NG148 používa rovnaký klinický rámec.</p>

<div class="table-responsive" role="region" aria-label="Klasifikácia akútneho poškodenia obličiek podľa KDIGO" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Stupeň AKI</th>
      <th scope="col">Sérový kreatinín</th>
      <th scope="col">Diuréza</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1. stupeň</th>
      <td>1,5- až 1,9-násobok východiskovej hodnoty alebo vzostup o ≥ 26,5 µmol/l</td>
      <td>&lt; 0,5 ml/kg/h počas 6 až 12 hodín</td>
    </tr>
    <tr>
      <th scope="row">2. stupeň</th>
      <td>2,0- až 2,9-násobok východiskovej hodnoty</td>
      <td>&lt; 0,5 ml/kg/h počas ≥ 12 hodín</td>
    </tr>
    <tr>
      <th scope="row">3. stupeň</th>
      <td>≥ 3-násobok východiskovej hodnoty, akútny vzostup na ≥ 353,6 µmol/l alebo začatie náhrady funkcie obličiek</td>
      <td>&lt; 0,3 ml/kg/h počas ≥ 24 hodín alebo anúria počas ≥ 12 hodín</td>
    </tr>
  </tbody>
</table>
</div>

<p>Vzostup z 90 na 160 µmol/l teda pri splnení časového kritéria zodpovedá AKI 1. stupňa podľa kreatinínu. Celkový stupeň však môže byť vyšší podľa diurézy. Kreatinín za dynamickou zmenou filtrácie zaostáva a jeho koncentráciu ovplyvňuje svalová hmota, katabolizmus, strava, hydratácia aj niektoré lieky. Rovnice eGFR predpokladajú približne ustálenú koncentráciu kreatinínu, preto môže byť automaticky vypočítaná eGFR počas rýchlej zmeny zavádzajúca.</p>

<h2>Najprv potvrdiť, že ide o skutočnú a akútnu zmenu</h2>

<p>Prvým krokom je vyhľadať predchádzajúce laboratórne výsledky a zopakovať odber v intervale primeranom klinickej naliehavosti. Treba overiť identitu vzorky, hemolýzu a okolnosti odberu. Ak výsledok nezodpovedá klinickému obrazu, do diferenciálnej diagnostiky patrí aj takzvané pseudo-AKI. Trimethoprim, cimetidín, cobicistat, dolutegravir a niektoré ďalšie lieky môžu zvýšiť kreatinín inhibíciou jeho tubulárnej sekrécie bez porovnateľného poklesu skutočnej GFR. Pomôcť môže časová súvislosť s novým liekom, močový nález, diuréza, urea, cystatín C alebo pri rozhodujúcej neistote meraná GFR. Ani cystatín C však nie je bez nezávislých determinantov a výsledok sa musí interpretovať klinicky.</p>

<p>Naopak, normálna diuréza AKI nevylučuje. Neoligurické AKI je časté a pacient môže naďalej močiť aj pri významnom poklese filtrácie. Závažnosť sa preto nesmie posudzovať iba podľa objemu moču ani iba podľa jednej koncentrácie kreatinínu.</p>

<h2>Najpravdepodobnejšie skupiny príčin</h2>

<h3>Znížená perfúzia obličiek</h3>

<p>Prerenálny mechanizmus vzniká pri znížení účinnej perfúzie obličiek bez počiatočného štrukturálneho poškodenia. U seniora môže byť objemová deplécia nenápadná. Príčinou môže byť nízky príjem tekutín, vracanie, hnačka, horúčka, krvácanie, polyúria alebo príliš intenzívna diuretická liečba. Znížený efektívny arteriálny objem môže byť prítomný aj pri srdcovom zlyhávaní, cirhóze alebo systémovej vazodilatácii pri sepse, hoci pacient môže mať súčasne edémy.</p>

<p>Dlhodobá hypertenzia sama osebe neurčuje príčinu aktuálneho zhoršenia. Môže však sprevádzať cievne zmeny a nižšiu renálnu rezervu, takže pokles tlaku, interkurentná choroba alebo kombinácia viacerých liekov môže vyvolať výraznejší funkčný pokles filtrácie.</p>

<h3>Lieky a renálna hemodynamika</h3>

<p>Lieková anamnéza musí zahŕňať predpísané, voľnopredajné aj rastlinné prípravky a presné časovanie zmien dávok. Osobitne treba preveriť nesteroidové protizápalové lieky (NSAID), diuretiká, inhibítory angiotenzín konvertujúceho enzýmu (ACE inhibítory), blokátory receptorov angiotenzínu II (sartany), aminoglykozidy, vankomycín, inhibítory protónovej pumpy, kalcineurínové inhibítory, antivirotiká a protinádorovú liečbu.</p>

<p>ACE inhibítory a sartany znižujú intraglomerulový tlak dilatáciou eferentnej arterioly. Tento mechanizmus je súčasťou ich dlhodobého kardiorenálneho prínosu a lieky nemožno všeobecne označiť za nefrotoxické. Pri objemovej deplécii, hypotenzii, závažnom srdcovom zlyhávaní alebo hemodynamicky významnej obojstrannej stenóze renálnych artérií však môžu prispieť k prudšiemu poklesu GFR. NSAID tlmia prostaglandínmi sprostredkovanú aferentnú vazodilatáciu. Riziková je najmä kombinácia NSAID, diuretika a ACE inhibítora alebo sartanu počas dehydratácie či akútneho ochorenia.</p>

<p>Vzostup kreatinínu po začatí alebo zvýšení dávky ACE inhibítora či sartanu neznamená automaticky trvalé ukončenie liečby ani automaticky nepotvrdzuje stenózu renálnych artérií. KDIGO 2024 odporúča skontrolovať tlak, kreatinín a draslík počas dvoch až štyroch týždňov po začatí alebo zvýšení dávky a pri vzostupe kreatinínu nad 30 % pátrať po AKI, objemovej deplécii, NSAID, nadmernej diuréze a podľa kontextu po stenóze renálnych artérií. Dočasné prerušenie môže byť potrebné pri hemodynamickej nestabilite, symptomatickej hypotenzii alebo nekontrolovanej hyperkaliémii, ale má byť spojené s plánom opätovného posúdenia a obnovenia indikovaných liekov.</p>

<p>Pri jódovej kontrastnej látke treba používať pojem kontrastom asociované AKI a nepredpokladať automaticky príčinnú súvislosť. Riziko intravenózneho kontrastu sa historicky nadhodnocovalo; NICE v aktualizácii z roku 2024 uvádza malé, ale zvýšené riziko najmä pri eGFR &lt; 30 ml/min/1,73 m<sup>2</sup>. Klinicky potrebné urgentné kontrastné vyšetrenie sa nemá odkladať, ak by odklad predstavoval významnejšie riziko.</p>

<h3>Obštrukcia odtoku moču</h3>

<p>Postrenálnu príčinu treba u staršieho pacienta aktívne zvažovať. U muža môže ísť o retenciu pri benígnej hyperplázii alebo karcinóme prostaty, striktúru uretry či neurogénny močový mechúr. U oboch pohlaví prichádza do úvahy urolitiáza, nádor, retroperitoneálna fibróza alebo dysfunkcia močového mechúra. Významná obštrukcia môže byť bez bolesti a bez úplnej anúrie; pacient môže močiť malé objemy pri preplnenom mechúre.</p>

<p>Výrazný vzostup kreatinínu pri dvoch funkčných obličkách zvyčajne vyžaduje obojstrannú obštrukciu, obštrukciu solitárnej obličky alebo súčasnú významnú CKD. Pri podozrení je praktický bladder scan s určením postmikčného rezidua a ultrasonografia obličiek a močových ciest.</p>

<h3>Parenchýmové a cievne príčiny</h3>

<p>Pretrvávajúca hypoperfúzia, sepsa, operácia, toxická expozícia, rabdomyolýza alebo hemolýza môžu viesť k akútnemu tubulárnemu poškodeniu. Pojem „akútna tubulárna nekróza“ sa nemá používať automaticky, pretože klinický syndróm nemusí znamenať histologicky preukázanú nekrózu.</p>

<p>Akútna intersticiálna nefritída býva často lieková. Horúčka, exantém a eozinofília môžu chýbať, preto ich neprítomnosť diagnózu nevylučuje. Pri hematúrii, novej alebo výraznej proteinúrii, dysmorfných erytrocytoch, erytrocytových valcoch, rýchlej progresii alebo systémových prejavoch treba urgentne myslieť na glomerulonefritídu či vaskulitídu. Podľa klinického obrazu sa dopĺňajú ANCA, anti-GBM protilátky, komplement, ANA, anti-dsDNA, sérológia infekcií a vyšetrenie monoklonálnej gamapatie; neselektívny „imunologický panel“ bez klinickej hypotézy však nie je vhodný.</p>

<p>Cievna diferenciálna diagnostika zahŕňa renovaskulárne ochorenie, trombózu alebo embóliu renálnej artérie, cholesterolovú ateroembolizáciu, trombotickú mikroangiopatiu a hypertenznú emergenciu. Podozrenie na významnú stenózu renálnych artérií rastie pri opakovanom náhlom pľúcnom edéme, rezistentnej hypertenzii, asymetrii obličiek, rozsiahlej ateroskleróze alebo výraznom poklese GFR po blokáde systému renín-angiotenzín. Samotná hypertenzia na diagnózu nestačí.</p>

<h2>Praktický diagnostický postup</h2>

<ol>
  <li><strong>Potvrdiť dynamiku:</strong> vyhľadať predchádzajúci kreatinín, určiť čas zmeny, zopakovať odber a zaznamenať diurézu.</li>
  <li><strong>Hneď vyhodnotiť závažnosť:</strong> tlak, pulz, saturáciu, stav vedomia, draslík, acidobázickú rovnováhu, známky pľúcneho edému, sepsy a uremických komplikácií.</li>
  <li><strong>Posúdiť objemový stav a perfúziu:</strong> príjem a straty tekutín, ortostatické príznaky, jugulárnu náplň, edémy, kongesciu a známky krvácania. Žiadny jednotlivý fyzikálny znak objemový stav spoľahlivo neurčí.</li>
  <li><strong>Urobiť úplnú liekovú rekonciliáciu:</strong> názov, dávka, dátum začatia alebo zmeny, NSAID zo samoliečby, nedávny kontrast a potenciálne nefrotoxické kombinácie.</li>
  <li><strong>Vyšetriť moč:</strong> testovací prúžok na krv, bielkovinu, leukocyty, nitrity a glukózu, následne močový sediment, pomer albumínu ku kreatinínu alebo bielkoviny ku kreatinínu a kultiváciu podľa indikácie.</li>
  <li><strong>Vylúčiť retenciu a obštrukciu:</strong> cielená anamnéza dolných močových príznakov, palpácia mechúra, bladder scan a ultrasonografia podľa rizika. Pri neobjasnenej príčine AKI alebo riziku obštrukcie NICE odporúča ultrazvuk do 24 hodín; pri podozrení na pyonefrózu do šiestich hodín.</li>
  <li><strong>Doplniť cielené testy:</strong> krvný obraz, urea, sodík, draslík, chloridy, bikarbonát, vápnik a podľa situácie CRP, laktát, hemokultúry, kreatínkináza, hemolytické parametre, imunologické vyšetrenia alebo paraproteín.</li>
</ol>

<h3>FeNa a FeUrea sú iba pomocné údaje</h3>

<p>Frakčná exkrécia sodíka (FeNa) pod 1 % môže podporiť hypoperfúzny mechanizmus a vyššia hodnota tubulárne poškodenie, ale prahy nie sú diagnózou. Metaanalýza 19 štúdií ukázala, že FeNa je najprínosnejšia u oligurických pacientov bez CKD a bez diuretík; pri CKD alebo diuretickej liečbe jej špecificita výrazne klesá. Výsledok ovplyvňuje aj sepsa, glomerulárne ochorenie, skorá obštrukcia, kontrast a časovanie odberu.</p>

<p>FeUrea sa tradične používa pri diuretikách, ale nemožno ju považovať za spoľahlivú náhradu FeNa. Systematický prehľad z roku 2026 zistil iba strednú diagnostickú presnosť, výraznú heterogenitu a celkovo nízku istotu dôkazov. Obe frakčné exkrécie sa majú interpretovať spolu s anamnézou, sedimentom, hemodynamikou a vývojom po liečbe.</p>

<h2>Liečba sa riadi príčinou a klinickým stavom</h2>

<p>Pri hypovolémii sa podáva primeraná objemová náhrada izotonickým kryštaloidom s opakovaným prehodnotením odpovede. U pacienta so srdcovým zlyhávaním alebo kongesciou môže nekritická infúzna liečba zhoršiť pľúcny edém, preto sa tekutiny nemajú podávať iba na základe zvýšeného kreatinínu. Diuretiká neliečia samotné AKI; majú miesto pri klinicky významnom objemovom preťažení.</p>

<p>Potenciálne nefrotoxické a hemodynamicky rizikové lieky treba individuálne prehodnotiť. Paušálne vysadenie všetkých antihypertenzív nie je bezpečný algoritmus. Rozhoduje tlak, perfúzia, kongescia, kaliémia, príčina AKI a kardiovaskulárna indikácia. Dávky ostatných liekov sa upravujú podľa aktuálnej a dynamicky sa meniacej funkcie obličiek; statická eGFR môže počas AKI dávkovanie skresľovať.</p>

<p>Pri retencii je prioritou bezpečná derivácia moču a riešenie príčiny. Pri podozrení na glomerulonefritídu, vaskulitídu, intersticiálnu nefritídu, myelómovú nefropatiu, trombotickú mikroangiopatiu alebo inú liečiteľnú parenchýmovú príčinu je potrebná skorá nefrologická konzultácia a niekedy biopsia obličky.</p>

<h2>Kedy konať urgentne</h2>

<p>O potrebe urgentnej hospitalizácie alebo náhrady funkcie obličiek nerozhoduje izolované číslo kreatinínu. Bezodkladné nemocničné vyšetrenie vyžaduje najmä anúria, výrazná alebo progresívna oligúria, hemodynamická nestabilita, závažná hyperkaliémia, významná metabolická acidóza, pľúcny edém, refraktérne objemové preťaženie, uremická encefalopatia alebo perikarditída, sepsa, rýchla progresia či podozrenie na infikovanú alebo úplnú obštrukciu.</p>

<p>Podľa NICE sa má nefrológ kontaktovať okamžite pri indikácii náhrady funkcie obličiek a čo najskôr, najneskôr do 24 hodín, pri AKI 3. stupňa, nejasnej príčine, nedostatočnej odpovedi na liečbu, komplikáciách, transplantovanej obličke, východiskovej CKD G4 až G5 alebo podozrení na ochorenie vyžadujúce špecializovanú liečbu.</p>

<h2>Čo si z prípadu odniesť</h2>

<ul>
  <li>Vzostup kreatinínu z 90 na 160 µmol/l je pri vývoji do siedmich dní AKI 1. stupňa podľa kreatinínového kritéria, nie však automaticky pri neznámom časovom priebehu.</li>
  <li>U staršieho pacienta je častý súbeh objemovej deplécie, akútneho ochorenia, diuretika, blokády systému renín-angiotenzín a NSAID zo samoliečby.</li>
  <li>Normálna diuréza nevylučuje AKI a samotný kreatinín neurčuje potrebu dialýzy.</li>
  <li>Močový nález a včasné vylúčenie obštrukcie môžu zásadne zmeniť diagnostický smer.</li>
  <li>FeNa ani FeUrea nenahrádzajú klinické hodnotenie.</li>
  <li>Po stabilizácii treba zdokumentovať príčinu, skontrolovať zotavenie funkcie obličiek a obnoviť indikovanú dlhodobú kardiorenálnu liečbu, ak pominuli dôvody jej prerušenia.</li>
</ul>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradnú liečbu obličiek pri AKI</a></li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba CKD v roku 2026: vrstvená nefroprotekcia a sledovanie po AKI</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group. KDIGO Clinical Practice Guideline for Acute Kidney Injury. Kidney International Supplements. 2012;2(1):1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">Finálne odporúčanie KDIGO 2012</a>. Aktualizácia KDIGO 2026 bola v čase spracovania článku iba <a href="https://kdigo.org/guidelines/acute-kidney-injury/" target="_blank" rel="noopener noreferrer">návrhom na verejné pripomienkovanie</a>, nie finálnym odporúčaním.</em></small></li>
  <li><small><em>National Institute for Health and Care Excellence. Acute kidney injury: prevention, detection and management. NICE guideline NG148. Posledná aktualizácia 16. októbra 2024. <a href="https://www.nice.org.uk/guidance/ng148/chapter/Recommendations" target="_blank" rel="noopener noreferrer">Odporúčania NICE</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">plný text KDIGO</a>.</em></small></li>
  <li><small><em>Mercado MG, Smith DK, Guard EL. Acute Kidney Injury: Diagnosis and Management. American Family Physician. 2019;100(11):687–694. PMID 31790176. <a href="https://pubmed.ncbi.nlm.nih.gov/31790176/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.aafp.org/pubs/afp/issues/2019/1201/p687.html" target="_blank" rel="noopener noreferrer">plný text</a>.</em></small></li>
  <li><small><em>Ronco C, Bellomo R, Kellum JA. Acute kidney injury. The Lancet. 2019;394(10212):1949–1964. doi: 10.1016/S0140-6736(19)32563-2. PMID 31777389. <a href="https://pubmed.ncbi.nlm.nih.gov/31777389/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Abdelhafez M, Nayfeh T, Atieh A, a spol. Diagnostic Performance of Fractional Excretion of Sodium for the Differential Diagnosis of Acute Kidney Injury: A Systematic Review and Meta-Analysis. Clinical Journal of the American Society of Nephrology. 2022;17(6):785–797. doi: 10.2215/CJN.14561121. PMID 35545442. <a href="https://pubmed.ncbi.nlm.nih.gov/35545442/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Pan HC, Jiang ZH, Chen HY, a spol. Assessing the utility of fractional excretion of urea in distinguishing intrinsic and prerenal acute kidney injury in hospitalised patients: a systematic review and meta-analysis. BMJ Open. 2026;16(1):e100875. doi: 10.1136/bmjopen-2025-100875. PMID 41535079. <a href="https://pubmed.ncbi.nlm.nih.gov/41535079/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Davenport MS, Perazella MA, Yee J, a spol. Use of Intravenous Iodinated Contrast Media in Patients with Kidney Disease: Consensus Statements from the American College of Radiology and the National Kidney Foundation. Radiology. 2020;294(3):660–668. doi: 10.1148/radiol.2019192094. PMID 31961246. <a href="https://pubmed.ncbi.nlm.nih.gov/31961246/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Jiang R, Huang Y, Mao H, Wu B. Overview of pseudo-acute kidney injury. Renal Failure. 2026;48(1):2650028. doi: 10.1080/0886022X.2026.2650028. PMID 41981729. <a href="https://pubmed.ncbi.nlm.nih.gov/41981729/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki_article',
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
