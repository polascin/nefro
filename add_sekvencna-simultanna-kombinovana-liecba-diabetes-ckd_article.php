<?php

/**
 * add_sekvencna-simultanna-kombinovana-liecba-diabetes-ckd_article.php
 * Odborný článok: sekvenčné verzus simultánne začatie kombinovanej kardiorenálnej
 * liečby pri diabete 2. typu a CKD. Východisko: diskusia z ADA 2026 (Medscape),
 * tvrdenia overené podľa primárnych publikácií.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Sekvenčne, alebo naraz? Ako začať kombinovanú kardiorenálnu liečbu pri diabete 2. typu a chronickej chorobe obličiek',
    'slug'         => 'sekvencna-simultanna-kombinovana-liecba-diabetes-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Postupne pridávať lieky, alebo začať viacerými naraz? Priamo na túto otázku odpovedá zatiaľ jediná randomizovaná štúdia — CONFIDENCE. Ostatné argumenty pochádzajú z diabetológie a ich prenos na obličkové ukazovatele má hranice.',
    'content'      => <<<'HTML'
<p>Pri diabete 2. typu s chronickou chorobou obličiek (CKD) dnes máme štyri triedy liekov s dokázaným kardiorenálnym prínosom: blokátor systému renín-angiotenzín, inhibítor SGLT2, nesteroidový antagonista mineralokortikoidového receptora a agonistu receptora GLP-1. Otázka už nie je, či ich kombinovať, ale <strong>ako začať</strong> — postupne, s odstupom medzi jednotlivými liekmi, alebo viacerými naraz. Diskusia na kongrese ADA 2026 postavila proti sebe obidva prístupy. Pri kritickom čítaní argumentov je však potrebné rozlíšiť, ktoré z nich pochádzajú z priamych dôkazov a ktoré z analógie.</p>

<h2>O čo v spore vlastne ide</h2>

<p>Argumenty na obidve strany sú racionálne a navzájom sa nevylučujú:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Argumenty pre sekvenčné a pre simultánne začatie kombinovanej liečby" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Prístup</th>
        <th scope="col">Čo hovorí v jeho prospech</th>
        <th scope="col">Čo je jeho cenou</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Sekvenčné začatie</th>
        <td>Umožňuje priradiť odpoveď aj nežiaducu udalosť ku konkrétnemu lieku. Dovoľuje individualizovať výber podľa albuminúrie, eGFR, komorbidít a rizika. Zjednodušuje monitorovanie.</td>
        <td>Odďaľuje nasadenie zvyšných liekov. Každý krok je príležitosť, aby sa liečba zastavila na polceste — v praxi častý dôvod, prečo pacient nikdy nedostane úplnú kombináciu.</td>
      </tr>
      <tr>
        <th scope="row">Simultánne začatie</th>
        <td>Skracuje čas do plnej nefroprotekcie. Znižuje riziko terapeutickej zotrvačnosti. Umožňuje využiť aditívny účinok od začiatku.</td>
        <td>Sťažuje priradenie nežiaducej udalosti ku konkrétnemu lieku. Zvyšuje liečebnú záťaž naraz. Vyžaduje dôslednejšie vstupné monitorovanie kália a funkcie obličiek.</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Priamy dôkaz: CONFIDENCE</h2>

<p>Zo štúdií citovaných v diskusii odpovedá na položenú otázku <strong>priamo iba jedna</strong>. Štúdia CONFIDENCE randomizovala účastníkov s CKD (eGFR 30 – 90 ml/min/1,73 m²), albuminúriou (pomer albumínu ku kreatinínu v moči 100 – 5 000 mg/g) a diabetom 2. typu, ktorí už užívali blokátor systému renín-angiotenzín, v pomere 1 : 1 : 1 na finerenón, empagliflozín alebo ich kombináciu. Primárnym ukazovateľom bola relatívna zmena pomeru albumínu ku kreatinínu v moči od začiatku do 180. dňa.</p>

<ul>
  <li>Kombinácia znížila albuminúriu <strong>o 29 % viac než samotný finerenón</strong> (pomer najmenších štvorcov 0,71; 95 % IS 0,61 – 0,82; p &lt; 0,001).</li>
  <li>Kombinácia znížila albuminúriu <strong>o 32 % viac než samotný empagliflozín</strong> (0,68; 95 % IS 0,59 – 0,79; p &lt; 0,001).</li>
  <li>Symptomatická hypotenzia, akútne poškodenie obličiek a hyperkaliémia vedúca k ukončeniu liečby boli podľa autorov zriedkavé.</li>
</ul>

<p>Vopred plánovaná analýza podľa kategórií rizika KDIGO priniesla dva prakticky užitočné doplnky. Prínos kombinácie bol konzistentný naprieč celým spektrom predpokladaného rizika progresie. Hyperkaliémia bola pri kombinácii <strong>častejšia</strong>, no <strong>včasný pokles eGFR o viac než 30 % do 30 dní bol menej častý u pacientov s vyšším rizikom podľa KDIGO</strong> než u pacientov s nižším rizikom. To je v protiklade s bežnou obavou, že práve najrizikovejší pacienti simultánne začatie „neunesú“.</p>

<p><strong>Hranica dôkazu:</strong> CONFIDENCE je štúdia fázy 2 s trvaním 180 dní a s <strong>náhradným ukazovateľom</strong> — albuminúriou. Nepreukázala spomalenie progresie CKD, zníženie rizika zlyhania obličiek ani zníženie počtu kardiovaskulárnych príhod. Albuminúria je uznávaný prediktor, ale zníženie albuminúrie nie je totožné so zlepšením tvrdého obličkového ukazovateľa.</p>

<h2>Argumenty prevzaté z diabetológie a ich hranice</h2>

<p>Zvyšné tri argumenty, ktoré v diskusii zaznievajú v prospech simultánneho začatia, pochádzajú z liečby hyperglykémie, nie z nefroprotekcie. To ich nerobí bezcennými, ale mení váhu, ktorú im možno priradiť.</p>

<h3>VERIFY: o glykemickej trvácnosti, nie o obličkách</h3>

<p>Štúdia VERIFY zaradila 2 001 pacientov s <strong>novodiagnostikovaným</strong> diabetom 2. typu a HbA1c 6,5 – 7,5 %. Porovnala včasnú kombináciu vildagliptínu s metformínom oproti postupnému začatiu metformínom. Výskyt počiatočného zlyhania liečby bol <strong>43,6 % pri včasnej kombinácii oproti 62,1 % pri monoterapii</strong> (pomer rizík 0,51; 95 % IS 0,45 – 0,58; p &lt; 0,0001).</p>

<p>Pri prenose tohto výsledku treba byť presný v tom, čo znamená „zlyhanie liečby“: <strong>HbA1c ≥ 7,0 % pri dvoch po sebe nasledujúcich návštevách</strong>. Ide teda o stratu glykemickej kontroly, nie o intoleranciu, neadherenciu ani o obličkový ukazovateľ. VERIFY nie je štúdia u pacientov s CKD a netýka sa liekov, o ktorých rozhodujeme pri nefroprotekcii. Podporuje všeobecný princíp „skoršia kombinácia vydrží dlhšie“, nie konkrétne odporúčanie pre kardiorenálnu liečbu.</p>

<h3>TRIPLE-AXEL: malá otvorená štúdia s dôležitou nástrahou v porovnávacom ramene</h3>

<p>Štúdia TRIPLE-AXEL randomizovala <strong>105 pacientov</strong> s doteraz neliečeným diabetom 2. typu (HbA1c ≥ 8 % a &lt; 11 %) na úvodnú trojkombináciu (metformín, dapagliflozín, saxagliptín) alebo na postupné pridávanie. Primárny ukazovateľ — dosiahnutie HbA1c pod 6,5 % bez hypoglykémie, bez vzostupu hmotnosti o ≥ 5 % a bez ukončenia liečby pre nežiaduci účinok v 104. týždni — dosiahlo <strong>39,0 % oproti 17,1 %</strong> (rozdiel rizika 22,0; 95 % IS 3,0 – 40,8; p = 0,027).</p>

<p>Pri čítaní tohto výsledku sú podstatné tri okolnosti. Po prvé, samotné zníženie HbA1c bolo v oboch ramenách <strong>porovnateľné</strong> (−2,56 % oproti −2,75 %); rozdiel v zloženom ukazovateli teda nevznikol z lepšej glykemickej kontroly. Po druhé, v ramene s postupným pridávaním nasledoval po metformíne <strong>glimepirid</strong>, teda derivát sulfonylurey — trieda so známym rizikom hypoglykémie a vzostupu hmotnosti. Zložený ukazovateľ tak do značnej miery odráža voľbu porovnávacieho lieku, nie výhodu simultánneho začatia ako princípu. Po tretie, ide o otvorenú štúdiu so 105 účastníkmi a bez obličkových ukazovateľov.</p>

<h3>Metabolická pamäť: koncept z DCCT/EDIC</h3>

<p>Argument o „metabolickej pamäti“ vychádza z dlhodobého sledovania štúdie DCCT/EDIC pri diabete <strong>1. typu</strong>, kde sa prínos včasnej intenzívnej glykemickej kontroly prejavoval aj po rokoch, keď sa HbA1c medzi skupinami vyrovnal. Ide o dobre doložený koncept, no týka sa glykémie pri diabete 1. typu. Prenos na otázku, či začať finerenón a inhibítor SGLT2 naraz alebo s odstupom, je analógia, nie dôkaz.</p>

<h2>Praktický rámec pre ambulanciu</h2>

<p>Z dostupných dôkazov vyplýva rámec, ktorý nie je ani „vždy naraz“, ani „vždy postupne“:</p>

<ol>
  <li><strong>Zotrvačnosť je väčší nepriateľ než rýchlosť.</strong> Pacient, ktorý po roku užíva len blokátor systému renín-angiotenzín, je bežnejší problém než pacient s nežiaducim účinkom kombinácie. Obidve strany diskusie sa zhodujú, že čakať bez dôvodu nemožno.</li>
  <li><strong>Simultánne začatie je odôvodnené, keď je zvládnuté monitorovanie.</strong> Predpokladom je vstupné kálium v bezpečnom pásme, známa hodnota eGFR a dohodnutá kontrola s odberom o dva až štyri týždne.</li>
  <li><strong>Postupné začatie má zmysel tam, kde je priradenie nežiaducej udalosti kľúčové</strong> — pri hraničnej kaliémii, nestabilnej komorbidite, výraznej polyfarmácii alebo pri pacientovi, u ktorého by jedna zle znášaná zmena ohrozila dôveru v celú liečbu.</li>
  <li><strong>Včasný pokles eGFR treba očakávať a vopred vysvetliť.</strong> Pri liekoch zasahujúcich do glomerulovej hemodynamiky ide o predvídateľnú adaptačnú zmenu, ktorá nie je dôvodom na ukončenie liečby. Rozhodujúce je, či sa hodnota stabilizuje — nie samotný fakt, že klesla. Prah, pri ktorom treba liečbu prehodnotiť, sa určuje individuálne, nie podľa jednej univerzálnej hranice.</li>
  <li><strong>Poradie nie je ľubovoľné.</strong> Ak sa volí postupný prístup, blokáda systému renín-angiotenzín a inhibítor SGLT2 sú najlepšie doložené a mali by byť prvé; nesteroidový antagonista mineralokortikoidového receptora sa pridáva pri pretrvávajúcej albuminúrii a bezpečnej kaliémii.</li>
</ol>

<h2>Čo zostáva nezodpovedané</h2>

<p>Neexistuje randomizovaná štúdia, ktorá by porovnala <strong>simultánne verzus postupné</strong> začatie plnej kardiorenálnej kombinácie s <strong>tvrdými obličkovými ukazovateľmi</strong>. CONFIDENCE preukázala väčší účinok kombinácie na albuminúriu, no neporovnávala postupnosť nasadenia v čase, a jej ukazovateľ je náhradný. Kým takáto štúdia nebude k dispozícii, ide o rozhodovanie na základe klinického úsudku podopretého náhradnými ukazovateľmi a analógiami — a to treba pacientovi aj kolegom vedieť takto pomenovať.</p>

<h2>Záver</h2>

<p>Spor o sekvenčné verzus simultánne začatie je v skutočnosti sporom o to, koľko istoty potrebujeme pred konaním. Priamy dôkaz existuje pre <strong>súčasné nasadenie finerenónu a empagliflozínu</strong>, a je priaznivý — ale ide o zníženie albuminúrie v štúdii fázy 2. Argumenty prevzaté z diabetológie (VERIFY, TRIPLE-AXEL, DCCT/EDIC) hovoria o glykemickej kontrole a na obličkové ukazovatele sa prenášajú len ako analógia. Najlepšie podložené odporúčanie je preto skromnejšie, než by sa z diskusie mohlo zdať: nečakať zbytočne, začínať tak, ako to bezpečnostný profil konkrétneho pacienta dovoľuje, a monitorovať dôsledne bez ohľadu na zvolený postup.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinačná liečba CKD: štyri piliere a hranice dôkazov</a></li>
  <li><a href="article.php?slug=finerenon-empagliflozin-confidence-albuminuria-krvny-tlak">Finerenón a empagliflozín v štúdii CONFIDENCE: albuminúria a krvný tlak</a></li>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia blokády RAAS a MRA pri hyperkaliémii, CKD a srdcovom zlyhávaní</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=finerenon-zakladna-liecba-ckd-glomerularne-ochorenia">Finerenón ako základná liečba pri CKD a glomerulových ochoreniach</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Východiskový materiál:</strong> Medscape. Sequential or Simultaneous Therapy in CKD — Which Approach Is Best? Diskusia z kongresu ADA 2026 Scientific Sessions; menovaní diskutujúci Ian de Boer a Amy Mottl. Východiskový materiál; všetky odborné tvrdenia a číselné údaje boli overené podľa primárnych publikácií uvedených nižšie.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. CONFIDENCE:</strong> Agarwal R, Green JB, Heerspink HJL, Mann JFE, McGill JB, Mottl AK, Rosenstock J, Rossing P, Vaduganathan M, Brinker M, Edfors R, Li N, Scheerer MF, Scott C, Nangaku M; CONFIDENCE Investigators. Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2025;393(6):533–543. doi: <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2410659</a>. PMID 40470996. <a href="https://pubmed.ncbi.nlm.nih.gov/40470996/" target="_blank" rel="noopener noreferrer">PubMed</a>. Registrácia: <a href="https://clinicaltrials.gov/study/NCT05254002" target="_blank" rel="noopener noreferrer">NCT05254002</a>.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. CONFIDENCE, analýza podľa rizika KDIGO:</strong> Vaduganathan M, Green JB, Heerspink HJL, Kim SG, Mann JFE, McGill JB, Mottl A, Nangaku M, Rosenstock J, Rossing P, Li L, Li N, Rohwedder K, Scott C, Agarwal R. Simultaneous initiation of finerenone and empagliflozin across the spectrum of kidney risk in the CONFIDENCE trial. <em>Nephrology Dialysis Transplantation</em>. 2026;41(1):161–170. doi: <a href="https://doi.org/10.1093/ndt/gfaf160" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfaf160</a>. PMID 40886054. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12722168/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-4"><small><em><strong>4. VERIFY:</strong> Matthews DR, Paldánius PM, Proot P, Chiang Y, Stumvoll M, Del Prato S; VERIFY study group. Glycaemic durability of an early combination therapy with vildagliptin and metformin versus sequential metformin monotherapy in newly diagnosed type 2 diabetes (VERIFY): a 5-year, multicentre, randomised, double-blind trial. <em>Lancet</em>. 2019;394(10208):1519–1529. doi: <a href="https://doi.org/10.1016/S0140-6736(19)32131-2" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(19)32131-2</a>. PMID 31542292. <a href="https://pubmed.ncbi.nlm.nih.gov/31542292/" target="_blank" rel="noopener noreferrer">PubMed</a>. Registrácia: NCT01528254.</em></small></p>

<p id="odborny-zdroj-5"><small><em><strong>5. TRIPLE-AXEL:</strong> Kim NH, Moon JS, Lee YH, Cho HC, Kwak SH, Lim S, Moon MK, Kim DL, Kim TH, Ko E, Lee J, Kim SG. Efficacy and tolerability of initial triple combination therapy with metformin, dapagliflozin and saxagliptin compared with stepwise add-on therapy in drug-naïve patients with type 2 diabetes (TRIPLE-AXEL study): A multicentre, randomized, 104-week, open-label, active-controlled trial. <em>Diabetes, Obesity and Metabolism</em>. 2024;26(9):3642–3652. doi: <a href="https://doi.org/10.1111/dom.15705" target="_blank" rel="noopener noreferrer">10.1111/dom.15705</a>. PMID 38853720. <a href="https://pubmed.ncbi.nlm.nih.gov/38853720/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-6"><small><em><strong>6. DCCT/EDIC:</strong> Nathan DM. Realising the long-term promise of insulin therapy: the DCCT/EDIC study. <em>Diabetologia</em>. 2021;64(5):1049–1058. doi: <a href="https://doi.org/10.1007/s00125-021-05397-4" target="_blank" rel="noopener noreferrer">10.1007/s00125-021-05397-4</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, autorské zoznamy, veľkosti súborov, definície ukazovateľov a všetky číselné výsledky boli overené 28. augusta 2026 cez PubMed a Crossref zo štruktúrovaných abstraktov primárnych publikácií. Zaradenie štúdií VERIFY, TRIPLE-AXEL a DCCT/EDIC medzi nepriame dôkazy, upozornenie na derivát sulfonylurey v porovnávacom ramene štúdie TRIPLE-AXEL a na náhradný charakter ukazovateľa štúdie CONFIDENCE nie sú prevzaté od diskutujúcich; ide o hodnotenie doplnené pri spracovaní.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani platné odporúčania. Pri začatí kombinovanej liečby treba rešpektovať kontraindikácie, sledovať koncentráciu draslíka a funkciu obličiek a postupovať podľa aktuálnej informácie o lieku.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    // Publikované v dávke šiestich článkov naraz — newsletterové avízo sa zámerne
    // neposiela, aby odberatelia nedostali šesť samostatných e-mailov v tej istej chvíli.
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sekvencna_simultanna_kombinovana_liecba',
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
