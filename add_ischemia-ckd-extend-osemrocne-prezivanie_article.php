<?php
/**
 * add_TEMPLATE_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre vkladanie nového článku.
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   4. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE OBSAH:
 *   • title    – čistý text, bez HTML; zobrazí sa ako <h1> na stránke článku
 *   • slug     – len [a-z0-9-], max 80 znakov; musí byť unikátny v DB
 *                Diakritika → ASCII: á→a, č→c, š→s, ž→z, ľ→l, ô→o, ú→u …
 *   • excerpt  – 1–2 vety (max ~300 znakov), čistý text; zobrazuje sa v zozname
 *   • content  – HTML; NESMIE začínať <h2> zhodným s titulom (duplikát)
 *                Nadpisy sekcií → <h2>…</h2>
 *                Zoznam        → <ul>/<ol> + <li>
 *                Tučné         → <strong>, kurzíva → <em>
 *                Externé linky → <a href="…" target="_blank" rel="noopener noreferrer">
 *                Tabuľka       → <th scope="col"> v <thead>, <th scope="row">
 *                                v <tbody>; CELÚ <table> obaľ do
 *                                <div class="table-responsive" role="region"
 *                                     aria-label="…" tabindex="0">
 *                                (bez wrapperu široká tabuľka rozbije mobil)
 *                Záver (zdroj) → <hr><p><em>Zdroj: …</em></p>
 *   • is_top   – 0 = bežný článok, 1 = odporúčaný (zobrazí sa vo featured sekcii)
 *   • author   – autor projektu (predvolene 'MUDr. Ľubomír Polaščín').
 *
 *   ⚠ PÔVODNÍ AUTORI ZDROJA (widget „Zúčastnení autori“ + filter ?autor=):
 *      Pole `author` je VŽDY len autor projektu, preto sa pôvodní autori
 *      zdrojového článku k autorom NEpridajú automaticky. Ak je článok
 *      slovenským spracovaním KONKRÉTNEHO zdrojového článku, doplň jeho
 *      pôvodných autorov do  source_authors.php  (mapa slug → [mená]) — tá je
 *      autoritatívna a zobrazí ich vo widgete aj vo filtri.
 *      • Mená zháňaj len z otvorených bibliografických API (Crossref/PubMed/
 *        eutils) alebo verejných tlačových správ — NIE obchádzaním paywallu.
 *      • Notácia „Meno Priezvisko“ (kvôli agregácii naprieč článkami).
 *      • Bez mapy funguje len obmedzený fallback: prvý autor z „Zdroj:“ v obsahu
 *        (značka musí byť presne „Zdroj:“, nie zoznam „Zdroje“).
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
    'title'        => 'ISCHEMIA-CKD po ôsmich rokoch: úvodná invazívna stratégia nepreukázala prínos pre prežívanie',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'ischemia-ckd-extend-osemrocne-prezivanie',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Osemročné sledovanie ISCHEMIA-CKD nepotvrdilo zníženie mortality pri úvodnej invazívnej stratégii. Výsledok sa týka stabilnej koronárnej choroby, nie akútneho koronárneho syndrómu.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/ischemia-ckd-extend-osemrocne-prezivanie.webp" target="_blank" rel="noopener noreferrer"><img src="img/ischemia-ckd-extend-osemrocne-prezivanie.webp" alt="Ilustračné prepojenie srdca a obličky pri porovnávaní dlhodobých liečebných stratégií" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, histologický preparát ani zobrazenie preukázaného účinku lieku.</figcaption></figure>
<p>U pacientov so stabilnou koronárnou chorobou, pokročilou chronickou chorobou obličiek (CKD) a aspoň stredne závažnou ischémiou nepreukázala úvodná invazívna stratégia výhodu v prežívaní ani pri mediáne sledovania osem rokov. Predĺžené sledovanie ISCHEMIA-CKD EXTEND tak neprinieslo dôkaz neskorého mortalitného prínosu, ktorý by zmenil hlavné posolstvo pôvodnej štúdie. Konzervatívna stratégia pritom znamenala aktívnu liečbu podľa odporúčaní s možnosťou invazívneho výkonu pri jej zlyhaní. [1, 2]</p>
<h2>Čo sa porovnávalo</h2>
<p>Pôvodná randomizovaná štúdia zaradila 777 pacientov s pokročilou CKD a stredne závažnou alebo závažnou ischémiou pri záťažovom vyšetrení. Do úvodnej invazívnej stratégie bolo pridelených 388 a do konzervatívnej 389 účastníkov. Invazívna vetva zahŕňala koronarografiu a podľa nálezu a uskutočniteľnosti revaskularizáciu spolu s medikamentóznou liečbou. V konzervatívnej vetve sa začínalo medikamentóznou liečbou; koronarografia a revaskularizácia boli vyhradené pre prípady, keď táto liečba nestačila. Nešlo teda o porovnanie revaskularizácie u každého pacienta s jej úplným zákazom. [1, 2]</p>
<p>Po skončení aktívnej fázy štúdie pokračovalo zisťovanie vitálneho stavu kontaktovaním účastníkov, kontrolou zdravotnej dokumentácie a centrálnych registrov úmrtí. Primárnym ukazovateľom predĺženého sledovania bola celková mortalita, sekundárnymi úmrtnosť podľa príčiny vrátane kardiovaskulárnej a nekardiovaskulárnej mortality. Medzi preživšími bol vitálny stav zachytený u 95 %. [1]</p>
<h2>Vysoká mortalita, bez preukázanej výhody invazívneho začiatku</h2>
<p>Počas sledovania zomrelo 429 účastníkov, teda 55 % randomizovaného súboru. Odhadovaná kumulatívna celková mortalita po ôsmich rokoch dosiahla 57,4 % pri invazívnej a 56,8 % pri konzervatívnej stratégii. Upravený pomer hazardov bol 1,05, s 95 % intervalom spoľahlivosti od 0,87 do 1,28. Kardiovaskulárna mortalita bola 40,3 % oproti 38,4 %, s upraveným pomerom hazardov 1,06 a intervalom od 0,84 do 1,34. [1]</p>
<p>Podiel 429 úmrtí zo 777 účastníkov a osemročné kumulatívne odhady nepredstavujú tú istú veličinu. Kumulatívne odhady zohľadňujú čas do udalosti a cenzorovanie. Rozdiel medzi nimi preto nie je aritmetickou nezrovnalosťou. Ani intervaly spoľahlivosti neumožňujú vyhlásiť stratégie za rovnocenné: štúdia nepreukázala mortalitnú výhodu invazívnej stratégie, ale nebola skúškou ekvivalencie. [1]</p>
<h2>Čo už ukázala pôvodná štúdia</h2>
<p>Pri mediáne pôvodného sledovania 2,2 roka bol odhadovaný trojročný výskyt úmrtia alebo nefatálneho infarktu myokardu 36,4 % pri invazívnej a 36,7 % pri konzervatívnej stratégii. Upravený pomer hazardov bol 1,01, s 95 % intervalom od 0,79 do 1,29. Invazívna stratégia bola spojená s vyšším výskytom cievnej mozgovej príhody, pomer hazardov 3,76 s intervalom od 1,52 do 9,32, a kombinácie úmrtia alebo začatia dialýzy, pomer hazardov 1,48 s intervalom od 1,04 do 2,11. Tieto výsledky patria k pôvodnej fáze, nie k novému osemročnému hodnoteniu. [2]</p>
<p>Predĺžené sledovanie odpovedá predovšetkým na otázku prežívania. Nemožno z neho odvodiť osemročnú rovnosť výskytu infarktu, hospitalizácií, angíny alebo kvality života, pretože takto široký súbor nefatálnych výsledkov predĺžená fáza nesledovala. Hodnotí dlhodobý dôsledok pôvodného pridelenia k stratégii, nie nemennú expozíciu jednému postupu počas všetkých ôsmich rokov. [1]</p>
<h2>Príprava na transplantáciu obličky</h2>
<p>Samostatná post hoc analýza pôvodnej ISCHEMIA-CKD zahŕňala 194 účastníkov zaradených na čakaciu listinu na transplantáciu. Pre úmrtie alebo nefatálny infarkt bol pri invazívnej oproti konzervatívnej stratégii upravený pomer hazardov 0,91, s 95 % intervalom od 0,54 do 1,54. Interakcia podľa zaradenia na čakaciu listinu nebola významná, p = 0,68. Ani táto analýza nepodporila rutinnú koronarografiu alebo revaskularizáciu iba pre zaradenie stabilného pacienta na čakaciu listinu. Široký interval však vyžaduje opatrnosť pri individuálnom rozhodovaní. [3]</p>
<p>Tento záver nemožno rozšíriť na odmietnutie kardiologického vyšetrenia či vyhľadávania konkrétnej klinickej indikácie. Rovnako sa výsledky stabilnej koronárnej choroby nemajú prenášať na akútny koronárny syndróm alebo na situáciu, keď napriek liečbe pretrvávajú neprijateľné symptómy. Už samotná konzervatívna stratégia štúdie ponechávala pri zlyhaní liečby priestor invazívnemu postupu. [1, 2]</p>
<h2>Hranice interpretácie</h2>
<p>Pre ambulantné rozhodovanie je podstatné, že ani dlhé sledovanie nepreukázalo prínos rutinného invazívneho začiatku pre mortalitu skúmanej populácie. O indikácii výkonu preto nemožno rozhodovať iba podľa prítomnosti CKD a pozitívneho ischemického testu bez zohľadnenia klinického stavu. Toto je interpretácia výsledkov skúšanej stratégie, nie univerzálny zákaz revaskularizácie.</p>
<p>Pri spracovaní boli overené úplné abstrakty a bibliografické záznamy predĺženého sledovania, pôvodnej randomizovanej štúdie a transplantačnej podskupiny. Plný text EXTEND ani jeho suplement neboli dostupné na kontrolu. Podrobnosti následných výkonov a zmien liečby, ktoré z týchto podkladov nemožno overiť, sa neuvádzajú.</p>

<hr>
<p><em>Odborný text je určený zdravotníckym pracovníkom. Klinické rozhodnutie vyžaduje posúdenie konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Sripal Bangalore, David J Maron, Rebecca Anthopolos, Harmony R Reynolds, Yifan Xu, Michelle Chang, Stephanie Boumakis, Jose Lopez-Sendon, Roxy Senior, Shaun G Goodman, Sean M O&#x27;Brien, Jerome L Fleg, Judith S Hochman, ISCHEMIA-CKD EXTEND Research Group. Long-Term Survival After Initial Invasive or Conservative Management of Stable Coronary Disease in Patients With Advanced Chronic Kidney Disease: ISCHEMIA-CKD EXTEND. Circulation. 2026. Elektronická publikácia pred zaradením do čísla. <a href="https://doi.org/10.1161/CIRCULATIONAHA.126.083858" target="_blank" rel="noopener noreferrer">DOI 10.1161/CIRCULATIONAHA.126.083858</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42998238/" target="_blank" rel="noopener noreferrer">PubMed 42998238</a></em></small></li>
<li><small><em>Sripal Bangalore, David J Maron, Sean M O&#x27;Brien, Jerome L Fleg, Evgeny I Kretov, Carlo Briguori, Upendra Kaul, Harmony R Reynolds, Tomasz Mazurek, Mandeep S Sidhu, Jeffrey S Berger, Roy O Mathew, Olga Bockeria, Samuel Broderick, Radoslaw Pracon, Charles A Herzog, Zhen Huang, Gregg W Stone, William E Boden, Jonathan D Newman, Ziad A Ali, Daniel B Mark, John A Spertus, Karen P Alexander, Bernard R Chaitman, Glenn M Chertow, Judith S Hochman, ISCHEMIA-CKD Research Group. Management of Coronary Disease in Patients with Advanced Kidney Disease. N Engl J Med. 2020;382(17):1608. <a href="https://doi.org/10.1056/NEJMoa1915925" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa1915925</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32227756/" target="_blank" rel="noopener noreferrer">PubMed 32227756</a></em></small></li>
<li><small><em>Charles A Herzog, Mengistu A Simegn, Yifan Xu, Salvatore P Costa, Roy O Mathew, Mohammad C El-Hajjar, Sanjeev Gulati, Rafael A Maldonado, Eric Daugas, Magdelena Madero, Jerome L Fleg, Rebecca Anthopolos, Gregg W Stone, Mandeep S Sidhu, David J Maron, Judith S Hochman, Sripal Bangalore. Kidney Transplant List Status and Outcomes in the ISCHEMIA-CKD Trial. J Am Coll Cardiol. 2021;78(4):348. <a href="https://doi.org/10.1016/j.jacc.2021.05.001" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.jacc.2021.05.001</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33989711/" target="_blank" rel="noopener noreferrer">PubMed 33989711</a></em></small></li>
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
    'log_prefix' => 'add_ischemia-ckd-extend-osemrocne-prezivanie_article',
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
