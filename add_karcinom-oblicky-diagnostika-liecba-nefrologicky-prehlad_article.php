<?php
/** Odborne overený nefrologický prehľad diagnostiky a liečby RCC. */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nové trendy v diagnostike a liečbe karcinómu obličky: nefrologicky orientovaný prehľad',
    'slug'         => 'karcinom-oblicky-diagnostika-liecba-nefrologicky-prehlad',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Diagnostika RCC, zachovanie funkcie obličiek, adjuvantný pembrolizumab a belzutifan. Overené dôkazy a praktický nefrologický postup pri renálnej toxicite protinádorovej liečby.',
    'content'      => <<<'HTML'
<figure>
<img src="img/karcinom-oblicky-nefrologicky-prehlad.png" alt="Ilustračný rez obličkou s ložiskom nádoru v jej vonkajšej časti" width="1590" height="989" loading="lazy" decoding="async">
<figcaption>Schematická ilustrácia karcinómu obličky. Nejde o diagnostický snímok ani o zobrazenie konkrétneho pacienta.</figcaption>
</figure>

<p>Karcinóm z obličkových buniek (renal cell carcinoma, RCC) zahŕňa biologicky odlišné nádory. Pre nefrológa je podstatné nielen rozpoznať renálnu toxicitu protinádorovej liečby, ale aj pomôcť zachovať funkčný parenchým pri operácii a zabezpečiť bezpečné zobrazovacie vyšetrenia. Najväčšiu zmenu priniesli kombinácie inhibítorov imunitných kontrolných bodov (ICI) s cielenou liečbou, adjuvantný pembrolizumab a inhibícia hypoxiou indukovateľného faktora 2 alfa (HIF-2α). Tento prehľad rozvíja tému slovenského článku v časopise <em>Onkológia</em> a opiera praktické závery o odporúčania a primárne štúdie. [1–3]</p>

<h2>Diagnostika: zobrazovanie, biopsia a biologická charakteristika</h2>
<p>Základom určenia rozsahu ochorenia je viacfázové kontrastné CT brucha a podľa rizika CT hrudníka. Pri náhodne zachytenom nádore cT1a možno vyšetrenie hrudníka individuálne vynechať. Magnetická rezonancia pomáha najmä pri posúdení žilového nádorového trombu alebo nejasného nálezu; doplnkom môže byť ultrazvuk s kontrastnou látkou. FDG-PET/CT ani scintigrafia kostí nie sú rutinnými vyšetreniami pri prvotnom určovaní štádia RCC. [2]</p>

<p><strong>Chronická choroba obličiek (CKD) samo osebe nie je dôvodom na odmietnutie potrebného kontrastného CT.</strong> Treba odlíšiť akútne poškodenie obličiek (AKI) časovo súvisiace s kontrastom od poškodenia skutočne spôsobeného kontrastnou látkou. Pri AKI alebo odhadovanej glomerulovej filtrácii (eGFR) &lt; 30 ml/min/1,73 m², teda &lt; 0,50 ml/s/1,73 m², sa u nedialyzovaných pacientov zvažuje intravenózna profylaxia izotonickým fyziologickým roztokom, ak nie je kontraindikovaná napríklad pre riziko objemového preťaženia. Pri eGFR 30–44 ml/min/1,73 m² je postup individuálny podľa ďalších rizík. Rozhodnutie má zohľadniť aj následky odkladu diagnózy. [4]</p>

<p>Biopsia nádorového ložiska má zmysel vtedy, keď jej výsledok môže zmeniť liečbu. Pred abláciou a pred systémovou liečbou bez predchádzajúceho histologického overenia sa odporúča odber tkaniva; pri aktívnom sledovaní sa používa u vybraných pacientov. Pred plánovanou operáciou nie je nevyhnutná pri každom presvedčivom náleze. <strong>Biopsia nádoru a biopsia nenádorového parenchýmu pri podozrení na liekovú nefrotoxicitu odpovedajú na odlišné otázky.</strong> Genetické vyšetrenie je dôležité najmä pri diagnóze vo veku ≤ 46 rokov, obojstranných či mnohopočetných nádoroch alebo rodinnej záťaži. [2]</p>

<p>Molekulárna diagnostika spresňuje klasifikáciu niektorých nádorov a pomáha rozpoznať dedičné syndrómy. Nemožno ju však stotožniť s rutinným testom, ktorý spoľahlivo vyberie najúčinnejšiu systémovú liečbu pre každého pacienta. Expresia PD-L1 sa pri RCC bežne nepoužíva na výber pacientov pre štandardné imunoterapeutické kombinácie. Génové podpisy a ďalšie prediktívne biomarkery zostávajú predmetom validácie. Prognostický ukazovateľ odhaduje priebeh ochorenia; prediktívny ukazovateľ má predpovedať rozdiel v účinku konkrétnej liečby. [2, 3]</p>

<h2>Lokalizované ochorenie: zachovať funkciu bez straty onkologickej bezpečnosti</h2>
<p>EAU odporúča parciálnu nefrektómiu pri nádoroch T1. Pri väčších nádoroch, solitárnej obličke alebo CKD sa jej uskutočniteľnosť posudzuje individuálne. Nefrológ má pred výkonom zhodnotiť funkciu obličiek, albuminúriu, tlak krvi a komorbidity. Aktívne sledovanie s plánovanými kontrolami je možnosťou pri vybraných malých nádoroch; neznamená pasívne ponechanie pacienta bez kontrol. U pacientov nevhodných na operáciu možno zvažovať abláciu alebo stereotaktickú rádioterapiu podľa charakteru nádoru a skúseností centra. [2, 3]</p>

<h2>Adjuvantný pembrolizumab: konkrétna indikácia a merateľný prínos</h2>
<p>Adjuvantná liečba sa netýka automaticky každého operovaného RCC. Štúdia KEYNOTE-564 zahŕňala nádory so svetlobunkovou zložkou po kompletnej resekcii, s vyšším rizikom recidívy: pT2 s vysokým stupňom malignity 4 alebo sarkomatoidnými znakmi, pT3, pT4, postihnutie uzlín alebo vybrané prípady po úplnom odstránení metastáz bez známok zostávajúceho ochorenia (M1 NED). Presné kombinácie štádia, uzlín a metastáz sa musia overiť podľa kritérií štúdie. [5, 6]</p>

<p>V randomizovanej štúdii s 994 účastníkmi sa pembrolizumab podával približne jeden rok. Päťročná analýza publikovaná v roku 2026 pri mediáne sledovania 70 mesiacov uviedla celkové prežívanie 87,7 % oproti 82,3 % pri placebe; pomer rizík úmrtia (HR) bol 0,66 s 95 % intervalom spoľahlivosti 0,48–0,90. Odhadované päťročné prežívanie bez ochorenia bolo 60,9 % oproti 52,2 %. Ide o výsledky konkrétnej vybranej populácie, nie o záruku individuálneho prínosu. [5]</p>

<p>Rozhodovanie musí zahrnúť toxicitu aj možnosť, že samotná operácia už pacienta vyliečila. V analýze z roku 2024 sa nežiaduce udalosti stupňa 3 alebo 4 súvisiace s liečbou vyskytli u 18,6 % pacientov pri pembrolizumabe a u 1,2 % pri placebe. Štúdia vylučovala pacientov s anamnézou dialýzy aj príjemcov transplantovaných orgánov. Jej výsledky preto nemožno na tieto skupiny priamo preniesť. [6, 7]</p>

<p>Prínos pembrolizumabu nemožno považovať za spoločný účinok všetkých ICI ani za dôkaz prospešnosti adjuvantných inhibítorov tyrozínkináz (TKI). EAU adjuvantný sunitinib neodporúča. Výber liečby patrí do multidisciplinárneho rozhodovania. [2]</p>

<h2>Pokročilé RCC: kombinácie podľa histológie a rizika</h2>
<p>Pri metastatickom svetlobunkovom RCC patria medzi základné možnosti prvej línie pembrolizumab s axitinibom, pembrolizumab s lenvatinibom a nivolumab s kabozantinibom. Kombinácia nivolumabu s ipilimumabom má pevné postavenie najmä pri strednom a nepriaznivom riziku podľa International Metastatic RCC Database Consortium (IMDC). Rozhodujú aj predchádzajúca adjuvantná liečba, rýchlosť progresie, komorbidity a dostupnosť liekov. Tieto závery sa nemajú bez rozlíšenia prenášať na nesvetlobunkové podtypy. [2, 3]</p>

<p>Z nefrologického hľadiska treba rozlišovať toxicitu jednotlivých zložiek. ICI môžu vyvolať imunitne podmienenú tubulointersticiálnu nefritídu, zriedkavejšie glomerulové ochorenie. Pri liekoch inhibujúcich signalizáciu vaskulárneho endotelového rastového faktora (VEGF) treba sledovať najmä hypertenziu a proteinúriu; hnačka a nedostatočný príjem tekutín môžu prispieť k hypovolémii. Napríklad súhrn charakteristických vlastností kabozantinibu vyžaduje pravidelné kontroly tlaku a proteinúrie a pri nefrotickom syndróme ukončenie liečby. [8, 9]</p>

<p><strong>Úprava dávky nie je rovnaká pre všetky protinádorové lieky.</strong> Pri pembrolizumabe sa redukcia dávky neodporúča; toxicita sa rieši prerušením alebo ukončením podávania a príslušnou liečbou nežiaducej reakcie. Pri TKI môže byť redukcia dávky súčasťou postupu, ale pravidlá sú liekovo špecifické. Kabozantinib sa pri závažnej poruche funkcie obličiek neodporúča pre nedostatok údajov. [9, 10]</p>

<h2>Belzutifan: inhibícia HIF-2α, anémia a hypoxia</h2>
<p>Belzutifan blokuje HIF-2α, transkripčný faktor zapojený do rastu svetlobunkových nádorov pri poruche dráhy VHL. V jednoramennej štúdii fázy II pri von Hippelovej-Lindauovej chorobe dosiahla v pôvodnej analýze objektívna odpoveď RCC 49 % (95 % interval spoľahlivosti 36–62 %). Štúdia zahŕňala pacientov bez metastáz a bez potreby okamžitej operácie; nejde o randomizované porovnanie s chirurgickou liečbou. [11]</p>

<p>V randomizovanej štúdii LITESPARK-005 u 746 predliečených pacientov s pokročilým svetlobunkovým RCC mal belzutifan oproti everolimu prínos v prežívaní bez progresie a v objektívnej odpovedi, ktorá dosiahla 21,9 % oproti 3,5 %. Publikovaná analýza z roku 2024 však nepreukázala štatisticky významné zlepšenie celkového prežívania (HR 0,88; 95 % interval spoľahlivosti 0,73–1,07). Preto ju nemožno citovať ako dôkaz predĺženia celkového prežívania. [12]</p>

<p>Aktuálna európska indikácia pri pokročilom svetlobunkovom RCC sa týka progresie po najmenej dvoch líniách zahŕňajúcich inhibítor PD-(L)1 a najmenej dve terapie zacielené na VEGF. Samostatná indikácia sa týka vybraných lokalizovaných nádorov pri VHL chorobe, keď lokálne postupy nie sú vhodné. Registrácia v EÚ sama osebe neurčuje úhradu na Slovensku. [13]</p>

<p>Pre nefrológa sú charakteristickými rizikami <strong>anémia a hypoxia</strong>, nie iba neurčito pomenovaná metabolická toxicita. Pred liečbou a počas nej treba kontrolovať hemoglobín a saturáciu kyslíka. Podľa európskeho súhrnu charakteristických vlastností sa pri renálnej insuficiencii vrátane konečného štádia nevyžaduje úprava dávky; toto farmakokinetické odporúčanie však nenahrádza klinické sledovanie a neznamená neprítomnosť toxicity. [13]</p>

<h2>Praktický nefrologický postup počas liečby</h2>
<h3>Vstupné vyšetrenie a plán kontrol</h3>
<p>Praktický plán má vychádzať z konkrétneho režimu a východiskového rizika: zaznamenať kreatinín a eGFR, tlak krvi, elektrolyty, močový nález a kvantifikáciu albuminúrie alebo proteinúrie. Pri TKI zaradiť pravidelné kontroly tlaku a moču; pri belzutifane aj hemoglobínu a saturácie. Frekvenciu kontrol dohodnúť s onkológom podľa cyklov, príznakov a stability funkcie obličiek. Ide o klinickú syntézu uvedených odporúčaní, nie o univerzálny interval vhodný pre každý liek. [8–10, 13, 14]</p>

<h3>Vzostup kreatinínu pri ICI: hľadať príčinu</h3>
<p>V medzinárodnej observačnej kohorte 429 pacientov s AKI pripisovaným ICI bol medián nástupu 16 týždňov. Tubulointersticiálna nefritída bola prítomná v 125 zo 151 biopsií (82,7 %). Tento podiel sa týka biopsiovaných pacientov, nie všetkých liečených ICI, a štúdia nevyjadruje populačnú incidenciu nefrotoxicity. Samotná časová súvislosť preto diagnózu nepotvrdzuje. [15]</p>

<ol>
<li><strong>Overiť zmenu a závažnosť:</strong> porovnať kreatinín s východiskom, zhodnotiť diurézu, hydratáciu, tlak, infekciu, obštrukciu a súbežné lieky. Vyšetriť močový sediment a kvantifikovať proteinúriu. Normálny močový nález nevylučuje tubulointersticiálnu nefritídu. [8, 14]</li>
<li><strong>Koordinovať ďalšiu dávku ICI:</strong> podľa SITC sa pri AKI liečba dočasne pozastavuje počas objasnenia príčiny. Pri kreatiníne ≥ 2-násobku východiskovej hodnoty alebo významnej proteinúrii je potrebné urýchlené nefrologické vyšetrenie; konzultácia je vhodná aj pri pretrvávajúcom či zhoršujúcom sa miernejšom AKI. [8]</li>
<li><strong>Zvážiť biopsiu parenchýmu:</strong> najmä pri nejasnej príčine, konkurenčnom vysvetlení AKI, aktívnom sedimente alebo výraznej proteinúrii. Rozhodnutie musí zohľadniť riziko výkonu a naliehavosť liečby. Pri imunitne podmienenej nefritíde sú základom liečby glukokortikoidy; dávku a postup vysadzovania určuje závažnosť a spoločné rozhodnutie nefrológa s onkológom. [8, 14]</li>
</ol>

<p>Pred opätovným podaním ICI treba individuálne posúdiť obnovu funkcie obličiek, onkologický prínos a riziko recidívy. V uvedenej kohorte sa opakované AKI objavilo u 20 zo 121 opätovne liečených pacientov (16,5 %); ide o vybranú observačnú skupinu. U príjemcu transplantovanej obličky navyše hrozí rejekcia štepu, čo si vyžaduje rozhodovanie spolu s transplantačným centrom. [8, 14, 15]</p>

<h2>Záver pre prax</h2>
<p>Nefrologická starostlivosť pri RCC začína už pred operáciou a pokračuje počas systémovej liečby. Praktickým cieľom je spojiť onkologický prínos so zachovaním funkcie obličiek: správne vybrať zobrazovanie, podporiť vhodný nefróny šetriaci postup, rozpoznať mechanizmus toxicity a včas koordinovať liečbu. Adjuvantný pembrolizumab má dôkaz prínosu vo vymedzenej populácii; belzutifan rozširuje možnosti liečby, ale prináša osobitné nároky na sledovanie anémie a hypoxie.</p>

<hr>
<h2>Zdroje</h2>
<p><small><em>Odborné podklady a liekové informácie overené 27. septembra 2026.</em></small></p>
<ol>
<li id="zdroj-1"><small><em>Tomčová Z. Nové trendy v diagnostike a liečbe karcinómu obličky. Onkológia. 2026; číslo 3. Tematický podklad: <a href="https://www.solen.sk/sk/casopisy/onkologia/nove-trendy-v-diagnostike-a-liecbe-karcinomu-oblicky" target="_blank" rel="noopener noreferrer">verejný abstrakt SOLEN</a>.</em></small></li>
<li id="zdroj-2"><small><em>European Association of Urology. EAU Guidelines on Renal Cell Carcinoma, 2026: <a href="https://uroweb.org/guidelines/renal-cell-carcinoma/chapter/diagnostic-evaluation" target="_blank" rel="noopener noreferrer">diagnostika</a>, <a href="https://uroweb.org/guidelines/renal-cell-carcinoma/chapter/prognostic-factors" target="_blank" rel="noopener noreferrer">prognostické faktory</a>, <a href="https://uroweb.org/guidelines/renal-cell-carcinoma/chapter/disease-management" target="_blank" rel="noopener noreferrer">liečba</a>.</em></small></li>
<li id="zdroj-3"><small><em>Powles T et al. Renal cell carcinoma: ESMO Clinical Practice Guideline for diagnosis, treatment and follow-up. Ann Oncol. 2024. <a href="https://pubmed.ncbi.nlm.nih.gov/38788900/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li id="zdroj-4"><small><em>Davenport MS et al. Use of Intravenous Iodinated Contrast Media in Patients With Kidney Disease: Consensus Statements from the American College of Radiology and the National Kidney Foundation. Kidney Med. 2020. <a href="https://pubmed.ncbi.nlm.nih.gov/33015613/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li id="zdroj-5"><small><em>Haas NB et al. Adjuvant pembrolizumab for the treatment of clear cell renal cell carcinoma: five-year results from the phase III KEYNOTE-564 study. Ann Oncol. 2026; online 26. augusta. <a href="https://pubmed.ncbi.nlm.nih.gov/42648402/" target="_blank" rel="noopener noreferrer">PubMed</a>. DOI: 10.1016/j.annonc.2026.08.006.</em></small></li>
<li id="zdroj-6"><small><em>ClinicalTrials.gov. KEYNOTE-564: registračný záznam, vstupné a vylučovacie kritériá. <a href="https://clinicaltrials.gov/study/NCT03142334" target="_blank" rel="noopener noreferrer">NCT03142334</a>.</em></small></li>
<li id="zdroj-7"><small><em>Choueiri TK et al. Overall Survival with Adjuvant Pembrolizumab in Renal-Cell Carcinoma. N Engl J Med. 2024. <a href="https://pubmed.ncbi.nlm.nih.gov/38631003/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li id="zdroj-8"><small><em>Brahmer JR et al. Society for Immunotherapy of Cancer (SITC) clinical practice guideline on immune checkpoint inhibitor-related adverse events. J Immunother Cancer. 2021;9:e002435. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8237720/" target="_blank" rel="noopener noreferrer">Plný text</a>, najmä kapitola o renálnej toxicite.</em></small></li>
<li id="zdroj-9"><small><em>European Medicines Agency. Cabometyx (kabozantinib): <a href="https://www.ema.europa.eu/en/documents/product-information/cabometyx-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">súhrn charakteristických vlastností lieku</a>, časti 4.2 a 4.4.</em></small></li>
<li id="zdroj-10"><small><em>European Medicines Agency. Keytruda (pembrolizumab): <a href="https://www.ema.europa.eu/en/documents/product-information/keytruda-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">súhrn charakteristických vlastností lieku</a>, časti 4.2 a 4.4.</em></small></li>
<li id="zdroj-11"><small><em>Jonasch E et al. Belzutifan for Renal Cell Carcinoma in von Hippel-Lindau Disease. N Engl J Med. 2021. <a href="https://pubmed.ncbi.nlm.nih.gov/34818478/" target="_blank" rel="noopener noreferrer">PubMed</a>; kritériá štúdie: <a href="https://clinicaltrials.gov/study/NCT03401788" target="_blank" rel="noopener noreferrer">NCT03401788</a>.</em></small></li>
<li id="zdroj-12"><small><em>Choueiri TK et al. Belzutifan versus Everolimus for Advanced Renal-Cell Carcinoma. N Engl J Med. 2024. <a href="https://pubmed.ncbi.nlm.nih.gov/39167807/" target="_blank" rel="noopener noreferrer">PubMed</a>; registračný záznam: <a href="https://clinicaltrials.gov/study/NCT04195750" target="_blank" rel="noopener noreferrer">NCT04195750</a>.</em></small></li>
<li id="zdroj-13"><small><em>European Medicines Agency. Welireg (belzutifan): <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/welireg" target="_blank" rel="noopener noreferrer">európske indikácie</a> a <a href="https://www.ema.europa.eu/en/documents/product-information/welireg-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">súhrn charakteristických vlastností lieku</a>, aktualizácia 13. januára 2026.</em></small></li>
<li id="zdroj-14"><small><em>Herrmann SM et al. Diagnosis and management of immune checkpoint inhibitor-associated nephrotoxicity: a position statement from the American Society of Onco-nephrology. Kidney Int. 2025;107:21–32. <a href="https://pubmed.ncbi.nlm.nih.gov/39455026/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li id="zdroj-15"><small><em>Gupta S et al. Acute kidney injury in patients treated with immune checkpoint inhibitors. J Immunother Cancer. 2021;9:e003467. <a href="https://pubmed.ncbi.nlm.nih.gov/34625513/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_karcinom-oblicky-diagnostika-liecba-nefrologicky-prehlad_article',
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
?>
