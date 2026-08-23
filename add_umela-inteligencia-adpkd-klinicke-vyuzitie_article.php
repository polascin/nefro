<?php
/**
 * add_umela-inteligencia-adpkd-klinicke-vyuzitie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript pre odborný článok o klinických aplikáciách
 * umelej inteligencie pri ADPKD. Pôvodní autori zdroja sú evidovaní aj
 * v source_authors.php.
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
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Umelá inteligencia pri ADPKD: súčasné možnosti a hranice klinického využitia',
    'slug'         => 'umela-inteligencia-adpkd-klinicke-vyuzitie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 19:10:16',
    'is_top'       => 0,
    'excerpt'      => 'Umelá inteligencia môže pri ADPKD automatizovať meranie celkového objemu obličiek. Kde už prináša klinický úžitok, čo zostáva výskumné a prečo nenahrádza odbornú interpretáciu?',
    'content'      => <<<'HTML'
<p><strong>Autozómovo dominantná polycystická choroba obličiek (ADPKD)</strong> je najčastejším monogénovým ochorením obličiek spojeným so zlyhaním obličiek. Jej priebeh je veľmi variabilný: u niektorých pacientov zostáva funkcia obličiek dlho stabilná, u iných ochorenie progreduje rýchlo. Odhad individuálneho rizika je preto rozhodujúci pre intenzitu sledovania, výber pacientov vhodných na liečbu tolvaptánom aj plánovanie dlhodobej starostlivosti.</p>

<p>Prehľadový článok publikovaný v časopise <em>Nephrology Dialysis Transplantation</em> sumarizuje, ako môže umelá inteligencia (AI) podporiť zobrazovaciu analýzu, prognostickú stratifikáciu, interpretáciu genetických nálezov a klinický výskum pri ADPKD. Najbližšie k reálnemu klinickému využitiu je automatizované meranie celkového objemu obličiek (TKV). Ostatné aplikácie zostávajú prevažne vo fáze vývoja a validácie.</p>

<h2>Prečo pri ADPKD nestačí sledovať iba eGFR</h2>

<p>Odhadovaná glomerulová filtrácia (eGFR) môže v skorších štádiách ADPKD zostať relatívne zachovaná napriek pokračujúcemu rastu cýst a zväčšovaniu obličiek. Významným prognostickým ukazovateľom je preto <strong>celkový objem obličiek indexovaný na výšku pacienta (htTKV)</strong>, hodnotený vo vzťahu k veku.</p>

<p>Na tomto princípe je založená Mayo Imaging Classification (MIC). Pri typickej morfológii ADPKD rozdeľuje pacientov do podtried 1A až 1E podľa predpokladanej rýchlosti rastu obličiek. Vyššie podtriedy sú spojené s vyšším rizikom budúceho poklesu funkcie obličiek. Usmernenie KDIGO 2025 odporúča MIC na predikciu poklesu funkcie obličiek a odhad času do ich zlyhania. Podtriedy 1C–1E patria medzi kritériá rýchlej progresie pri zvažovaní tolvaptánu.</p>

<p>MIC však nemožno používať mechanicky. Prognostickú hodnotu má pri typickom zobrazovacom obraze, teda v triede 1. Ak je známy patogénny variant v inom géne než <em>PKD1</em> alebo <em>PKD2</em>, MIC sa na prognózu nemá používať; genetické potvrdenie <em>PKD1</em> alebo <em>PKD2</em> však nie je podmienkou jej použitia. Najmä podtrieda 1C môže zahŕňať pacientov s rozdielnym skutočným rizikom. Rozhodovanie o liečbe preto musí zohľadniť aj vek, eGFR, jej doterajší vývoj, genotyp, rodinnú anamnézu, komorbidity, kontraindikácie a preferencie pacienta.</p>

<h2>Automatická segmentácia obličiek: najzrelšia aplikácia AI</h2>

<p>Presné meranie TKV vyžaduje segmentáciu obličiek na snímkach magnetickej rezonancie (MR) alebo počítačovej tomografie (CT). Manuálna segmentácia je časovo náročná a závisí od skúseností hodnotiaceho. Jednoduchšie geometrické odhady sú rýchlejšie, ale pri nepravidelnom tvare polycystických obličiek môžu byť menej presné.</p>

<p>Modely hlbokého učenia dokážu obličky na jednotlivých rezoch automaticky ohraničiť, spojiť segmentácie do trojrozmerného objemu a vypočítať TKV. V štúdiách dosahujú vysokú zhodu s expertnou segmentáciou a podstatne skracujú čas analýzy. Výhodou je aj lepšia reprodukovateľnosť pri opakovaných meraniach.</p>

<p>Nie všetky algoritmy však pracujú rovnako spoľahlivo. Výkon môže zhoršiť odlišný zobrazovací protokol, technická kvalita snímok, veľmi veľké alebo atypicky tvarované obličky, exofytické cysty, predchádzajúci výkon či súbežná patológia. Klinické nasadenie preto vyžaduje externú validáciu, kontrolu kvality a možnosť opravy výsledku rádiológom alebo iným skúseným odborníkom. Automaticky vypočítanú hodnotu bez vizuálnej kontroly nemožno považovať za neomylnú.</p>

<h2>Predikcia poklesu funkcie obličiek</h2>

<p>Strojové učenie môže v jednom modeli kombinovať zobrazovacie údaje, vek, pohlavie, krvný tlak, laboratórne výsledky, genotyp a doterajší vývoj eGFR. Cieľom je presnejšie odhadnúť, u koho bude ochorenie progredovať rýchlo a kedy môže dôjsť k zlyhaniu obličiek.</p>

<p>Takéto modely sú sľubné, ale zatiaľ nenahrádzajú overené prognostické nástroje, akými sú MIC, doterajšie ročné tempo poklesu eGFR alebo skóre PROPKD. Výsledok dosiahnutý v jednej výskumnej kohorte nemusí byť prenosný na inú populáciu. Rozdiely v genetickom zložení, veku, štádiu ochorenia, zobrazovacích protokoloch a dostupnosti údajov môžu presnosť modelu podstatne zmeniť.</p>

<p>Klinicky validovaný model umožňujúci spoľahlivo predpovedať individuálnu odpoveď na tolvaptán zatiaľ nie je súčasťou štandardnej starostlivosti. Prognózu prirodzeného priebehu ochorenia a predikciu odpovede konkrétneho pacienta na liečbu treba dôsledne odlišovať.</p>

<h2>Genetické nálezy: pomoc pri interpretácii, nie automatický verdikt</h2>

<p>Väčšinu prípadov ADPKD spôsobujú patogénne varianty v génoch <em>PKD1</em> a <em>PKD2</em>. S fenotypom polycystického ochorenia obličiek sa spájajú aj menej časté gény, napríklad <em>ALG5</em>, <em>ALG9</em>, <em>DNAJB11</em>, <em>GANAB</em>, <em>IFT140</em> a <em>NEK8</em>. Ochorenia spojené s týmito génmi nemusia mať rovnaký zobrazovací obraz ani prognózu ako klasická ADPKD spôsobená variantmi <em>PKD1</em> alebo <em>PKD2</em>.</p>

<p>Algoritmy môžu pomáhať pri vyhľadávaní a prioritizácii variantov, odhade ich funkčného významu a skúmaní vzťahov medzi genotypom a fenotypom. Nemali by však samostatne určovať patogenitu variantu. Konečná interpretácia musí vychádzať zo štandardizovaných klasifikačných kritérií, klinického fenotypu, rodinnej segregácie a odborného genetického posúdenia. Osobitnú opatrnosť si vyžadujú varianty neistého významu.</p>

<h2>Opakované zobrazovanie a klinické štúdie</h2>

<p>AI môže uľahčiť porovnávanie opakovaných MR alebo CT vyšetrení, presnejšie zosúladiť snímky a kvantifikovať zmenu TKV. To je atraktívne najmä vo výskume, kde sa hodnotí účinok liečby na rast obličiek. Automatizácia môže znížiť prácnosť merania, obmedziť variabilitu medzi hodnotiteľmi a umožniť spracovanie väčších súborov údajov.</p>

<p>V bežnej ambulantnej praxi však pravidelné opakovanie TKV v krátkych intervaloch nie je samo osebe zavedeným spôsobom hodnotenia individuálnej odpovede na liečbu. Zmena objemu môže byť v krátkom čase malá a porovnanie ovplyvňuje technika vyšetrenia aj chyba merania. AI túto chybu môže zmenšiť, ale neodstraňuje biologickú variabilitu ani potrebu sledovať eGFR, krvný tlak, toleranciu liečby a ďalšie klinické ukazovatele.</p>

<p>Pri klinických štúdiách môže AI podporiť výber pacientov s očakávanou rýchlou progresiou, štandardizovať zobrazovacie koncové ukazovatele a pomáhať pri hľadaní vzorcov spojených s účinnosťou alebo bezpečnosťou liečby. Tieto možnosti sú však prevažne podporné a výskumné; kvalitu randomizácie, definíciu výsledkov ani nezávislé klinické hodnotenie nenahrádzajú. Ak je model vytvorený na nereprezentatívnom súbore údajov, môže pri výbere účastníkov systematicky znevýhodniť skupiny, ktoré boli vo vývojových údajoch zastúpené nedostatočne.</p>

<h2>Čo musí byť vyriešené pred širším zavedením</h2>

<p>Prvou podmienkou je <strong>externá validácia</strong>. Model trénovaný v jednom centre musí preukázať spoľahlivosť aj pri iných prístrojoch, protokoloch a demograficky rozmanitých populáciách. Druhou je <strong>transparentnosť</strong>: používateľ má vedieť, pre aký účel bol nástroj vytvorený, na akých údajoch bol overený a v ktorých situáciách môže zlyhať.</p>

<p>Ďalšími témami sú ochrana zobrazovacích a genetických údajov, interoperabilita so zdravotníckymi systémami, priebežné sledovanie výkonu po nasadení, regulačná zodpovednosť a jasné rozdelenie kompetencií medzi algoritmom a zdravotníkom. Pri genetických údajoch musí byť zrozumiteľne určený účel ich spracovania, pravidlá prístupu a rozsah informovania pacienta, pretože nález môže mať význam aj pre jeho biologických príbuzných. Pri každej aktualizácii modelu treba opätovne preveriť, či sa jeho výkon alebo bezpečnosť nezhoršili.</p>

<p>Najväčším rizikom nie je iba technická chyba, ale falošný pocit presnosti. Pravdepodobnostná predikcia môže pôsobiť autoritatívne, hoci vychádza z neúplných údajov alebo z populácie, ktorá sa od konkrétneho pacienta podstatne líši. Ak zdravotník automatizovanému výstupu prisúdi väčšiu váhu než protichodným klinickým údajom, vzniká automatizačné skreslenie.</p>

<h2>Praktický význam pre nefrológa</h2>

<p>Pri ADPKD je AI užitočná predovšetkým tam, kde automatizuje časovo náročnú a opakovateľnú úlohu. Najlepším príkladom je segmentácia obličiek a výpočet TKV. Výstup však musí byť technicky overiteľný a správne zasadený do klinického kontextu.</p>

<p>Pri používaní takýchto nástrojov sú dôležité tri zásady:</p>

<ol>
  <li><strong>Výstup treba technicky overiť.</strong> Automaticky vypočítaný TKV nemožno prijať bez kontroly kvality snímok a správnosti segmentácie.</li>
  <li><strong>Predikcia nenahrádza klinické rozhodovanie.</strong> Treba overiť, či má pacient typickú morfológiu vhodnú na použitie MIC. Pri zvažovaní tolvaptánu nestačí samotná podtrieda; potrebné je posúdiť celkové riziko progresie, funkciu obličiek, kontraindikácie a pomer očakávaného prínosu a záťaže liečby.</li>
  <li><strong>Pacient má zostať účastníkom rozhodovania.</strong> Mal by rozumieť účelu nástroja, neistote výsledku aj tomu, ako výstup AI ovplyvňuje odporúčaný postup.</li>
</ol>

<h2>Záver</h2>

<p>Najpresvedčivejšou súčasnou aplikáciou umelej inteligencie pri ADPKD je automatizované meranie celkového objemu obličiek. Môže sprístupniť presnejšiu zobrazovaciu prognostiku väčšiemu počtu pacientov a zlepšiť reprodukovateľnosť meraní. Kombinovanie zobrazovacích, klinických a genetických údajov otvára cestu k individualizovanejším prognostickým modelom, ich dodatočný prognostický prínos však musí byť potvrdený v nezávislých populáciách.</p>

<p>AI nenahrádza nefrológa, rádiológa ani klinického genetika. Je nástrojom na podporu rozhodovania, ktorého význam závisí od kvality vstupných údajov, vhodnosti modelu a odbornej interpretácie. Pri správnom použití môže znížiť technické bariéry a spresniť starostlivosť; pri nekritickom použití môže iba dodať neistému odhadu presvedčivejší vzhľad.</p>

<hr>

<p><em><strong>Zdroj:</strong> Ebrahimi N, Cheungpasitporn W, Chebib FT, Borghol AH, Ghozloujeh ZG, Norouzi S, Abdipour A. Clinical applications of artificial intelligence in autosomal dominant polycystic kidney disease. Nephrology Dialysis Transplantation. 2026;41(7):1204–1213. Publikované online 27. januára 2026. <a href="https://academic.oup.com/ndt/article-abstract/41/7/1204/8442256" target="_blank" rel="noopener noreferrer">Oxford Academic</a>. doi: <a href="https://doi.org/10.1093/ndt/gfag010" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag010</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41591418/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Autori zdrojového článku:</strong> Niloufar Ebrahimi; Wisit Cheungpasitporn; Fouad T. Chebib; Abdul Hamid Borghol; Zohreh Gholizadeh Ghozloujeh; Sayna Norouzi; Amir Abdipour.</em></p>

<p><em><strong>Doplňujúci odborný zdroj:</strong> KDIGO 2025 Clinical Practice Guideline for the Evaluation, Management, and Treatment of Autosomal Dominant Polycystic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2025/01/KDIGO-2025-ADPKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plné znenie usmernenia</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
