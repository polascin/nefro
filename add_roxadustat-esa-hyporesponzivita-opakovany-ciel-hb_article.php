<?php
/**
 * add_roxadustat-esa-hyporesponzivita-opakovany-ciel-hb_article.php
 * Odborný článok o roxadustate pri hyporesponzivite na ESA počas hemodialýzy.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Roxadustat pri hyporesponzivite na ESA: častejšie opakované dosiahnutie Hb, nie nižšia variabilita',
    'slug'         => 'roxadustat-esa-hyporesponzivita-opakovany-ciel-hb',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Sekundárna analýza spájala roxadustat s častejším opakovaným dosiahnutím Hb ≥10 g/dl pri hyporesponzivite na ESA, nie však s preukázateľne nižšou variabilitou Hb.',
    'content'      => <<<'HTML'
<p>Hyporesponzivita na erytropoézu stimulujúce látky (ESA) je pri udržiavacej hemodialýze klinickým signálom, nie samostatnou diagnózou. Môže sprevádzať deficit železa, zápal, chronické straty krvi, nedostatočnú dialýzu, malnutríciu, hyperparatyreózu, hematologické ochorenie alebo iný korigovateľný problém. Zvyšovanie dávky ESA bez hľadania príčiny môže zvýšiť liekovú záťaž bez primeraného hematologického účinku.</p>

<p>Demir a spoluautori publikovali sekundárnu analýzu multicentrickej retrospektívnej kohorty, v ktorej porovnali roxadustat s pokračovaním ESA u hemodialyzovaných pacientov s hyporesponzívnou anémiou. Roxadustat bol spojený s vyššou upravenou pravdepodobnosťou opakovaného dosiahnutia hemoglobínu (Hb) ≥10 g/dl, ale nepreukázal štatisticky významné zníženie medzimesačnej variability Hb.</p>

<p>Práca je klinicky podnetná, no nie je randomizovaným dôkazom superiority. Jej výsledok treba čítať spolu s odporúčaniami KDIGO 2026, ktoré naďalej uprednostňujú ESA pred inhibítormi prolylhydroxylázy hypoxiou indukovateľného faktora (HIF-PHI) ako liečbu prvej voľby po odstránení korigovateľných príčin anémie.</p>

<h2>Čo znamená hyporesponzivita na ESA</h2>

<p>Hyporesponzivita znamená nedostatočný vzostup alebo udržanie Hb napriek primeranej liečbe ESA. Neexistuje jediná definícia vhodná pre každú situáciu; dôležité sú absolútna dávka, hmotnostne korigovaná dávka, predchádzajúca odpoveď, trend Hb a klinický kontext.</p>

<p>Pred označením pacienta za hyporesponzívneho treba overiť správnosť podávania ESA a systematicky hľadať liečiteľné príčiny. Vysoká potreba ESA môže byť markerom závažnosti ochorenia a zápalu, preto sama osebe nepreukazuje, že nepriaznivé výsledky spôsobuje liek.</p>

<h2>Ako pôsobí roxadustat</h2>

<p>Roxadustat je perorálny HIF-PHI. Stabilizáciou HIF aktivuje odpoveď podobnú fyziologickej reakcii na hypoxiu: zvyšuje endogénnu tvorbu erytropoetínu, ovplyvňuje expresiu génov súvisiacich s erytropoézou a zlepšuje dostupnosť železa okrem iného znížením hepcidínu.</p>

<p>Mechanizmus sa odlišuje od podania exogénneho ESA a môže byť zaujímavý pri funkčnom deficite železa alebo zápalovej záťaži. Biologická odlišnosť však automaticky neznamená lepšiu klinickú bezpečnosť alebo lepšie výsledky. Dlhodobé porovnávacie údaje sú menej rozsiahle než pri ESA.</p>

<h2>Čo presne analyzovala štúdia</h2>

<p>Do sekundárnej analýzy bolo zaradených 108 dospelých na udržiavacej hemodialýze s kompletnými mesačnými hodnotami Hb počas šiestich mesiacov. Roxadustat dostávalo 78 pacientov a 30 pokračovalo v liečbe ESA. Výber liečby nebol randomizovaný.</p>

<p>Autori definovali „sustained target achievement“ ako Hb ≥10 g/dl aspoň v troch zo šiestich sledovaných mesiacov. Tieto mesiace nemuseli nasledovať bezprostredne po sebe. Výsledok je preto presnejšie chápať ako opakované dosiahnutie prahovej hodnoty, nie ako nepretržite stabilný Hb.</p>

<p>Variabilitu Hb hodnotili viacerými ukazovateľmi: vnútroindividuálnou štandardnou odchýlkou, variačným koeficientom, rozsahom hodnôt, priemernou absolútnou mesačnou zmenou a maximálnou absolútnou zmenou.</p>

<div class="table-responsive" role="region" aria-label="Výsledky sekundárnej analýzy roxadustatu pri hyporesponzivite na ESA" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výsledok</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Hb ≥10 g/dl aspoň v 3 zo 6 mesiacov</td>
      <td>52 zo 108 pacientov; roxadustat oproti ESA: upravený OR 4,44 (95 % CI 1,24–15,84; p = 0,022)</td>
      <td>Asociácia po štatistickej úprave; široký interval spoľahlivosti vyjadruje značnú neistotu veľkosti účinku</td>
    </tr>
    <tr>
      <td>Východiskový Hb</td>
      <td>Upravený OR 2,95 na každý vzostup Hb o 1 g/dl (95 % CI 1,57–5,55; p &lt;0,001)</td>
      <td>Počiatočná závažnosť anémie bola silným prediktorom dosiahnutia prahu</td>
    </tr>
    <tr>
      <td>Hb ≥10 g/dl v 6. mesiaci</td>
      <td>50,0 % pri roxadustate a 33,3 % pri pokračovaní ESA</td>
      <td>Opisný výsledok jedného časového bodu; sám osebe nedokazuje kauzálnu superioritu</td>
    </tr>
    <tr>
      <td>Medzimesačná variabilita Hb</td>
      <td>Ukazovatele boli pri roxadustate numericky nižšie, rozdiely však neboli štatisticky významné</td>
      <td>Štúdia nepreukázala stabilnejší Hb v čase</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Prečo je dôležitá pôvodná kohorta</h2>

<p>Táto práca je sekundárnou analýzou už publikovanej retrospektívnej kohorty. V pôvodnom súbore mali pacienti, ktorí prešli na roxadustat, nižší východiskový Hb než skupina pokračujúca v ESA. Po úprave na východiskový Hb v pôvodnej analýze liečebná skupina nebola nezávisle spojená s konečným Hb.</p>

<p>Nová analýza používa iný výsledok a regresný model, ale neodstraňuje nerandomizovaný výber liečby, rozdiely medzi skupinami ani reziduálne skreslenie. Upravený OR 4,44 preto nemožno preložiť ako štvornásobný kauzálny účinok roxadustatu.</p>

<h2>Čo hovoria KDIGO 2026 a EMA</h2>

<p>KDIGO 2026 po odstránení korigovateľných príčin anémie navrhuje ESA namiesto HIF-PHI ako liečbu prvej voľby (odporúčanie 2D). Pacient s hyporesponzivitou môže po individuálnom zvážení podstúpiť skúšobnú liečbu HIF-PHI, ale samotné odporúčanie výslovne hodnotí dôkazy pre túto situáciu ako slabé.</p>

<p>KDIGO zároveň uvádza, že ESA a HIF-PHI sa nemajú kombinovať. Pri HIF-PHI odporúča používať najnižšiu účinnú dávku, kontrolovať Hb 2–4 týždne po začatí alebo zmene dávky a potom každé štyri týždne. Pri roxadustate odporúča počas prvých troch mesiacov periodicky sledovať funkciu štítnej žľazy a liečbu prerušiť pri nedostatočnej erytropoetickej odpovedi podľa odporúčaného časového rámca.</p>

<p>Evrenzo je v Európskej únii autorizované na liečbu symptomatickej anémie spojenej s CKD u dospelých. Podľa EMA sa dávka upravuje na Hb 10–12 g/dl a stabilný pacient na ESA sa nemá meniť na roxadustat bez klinického odôvodnenia a očakávaného prínosu. Európska autorizácia však sama osebe neurčuje úhradu ani dostupnosť na Slovensku; tie treba overiť podľa aktuálnej kategorizácie a miestnych pravidiel.</p>

<h2>Bezpečnosť nemožno odvodiť z tejto analýzy</h2>

<p>Malý retrospektívny súbor a šesťmesačné sledovanie nemajú silu spoľahlivo porovnať zriedkavejšie alebo dlhodobé nežiaduce udalosti. Z výsledku preto nemožno vyvodiť nižšie riziko transfúzií, hospitalizácií, kardiovaskulárnych príhod, trombózy cievneho prístupu ani mortality.</p>

<p>Medzi významné známe riziká roxadustatu podľa EMA patria hypertenzia, hyperkaliémia, periférne opuchy a trombóza dialyzačného cievneho prístupu. Výber pacienta musí zohľadniť kardiovaskulárne a tromboembolické riziko, malignitu, krvný tlak, liekové interakcie a ďalšie upozornenia v aktuálnom súhrne charakteristických vlastností lieku.</p>

<h2>Praktický postup pri nedostatočnej odpovedi na ESA</h2>

<ol>
  <li><strong>Potvrdiť trend a expozíciu:</strong> skontrolovať opakované hodnoty Hb, dávku a spôsob podania ESA, adherenciu a časový priebeh.</li>
  <li><strong>Vyšetriť železo a krvné straty:</strong> feritín, saturáciu transferínu, krvácanie z cievneho prístupu, gastrointestinálne a iné chronické straty.</li>
  <li><strong>Hľadať zápal a nedostatočnú dialýzu:</strong> infekciu, chronický zápal, adekvátnosť dialýzy, stav cievneho prístupu a recirkuláciu podľa klinickej situácie.</li>
  <li><strong>Posúdiť ďalšie príčiny:</strong> malnutríciu, vitamín B12, folát, hyperparatyreózu, hemolýzu, hematologické ochorenie, lieky a malignitu.</li>
  <li><strong>Liečbu individualizovať:</strong> po korekcii príčin zvoliť ESA, HIF-PHI alebo transfúziu spolu s pacientom.</li>
</ol>

<h2>Limity štúdie</h2>

<ul>
  <li>retrospektívny, nerandomizovaný dizajn a riziko skreslenia výberom liečby,</li>
  <li>iba 108 pacientov, z toho 30 v porovnávacej skupine ESA,</li>
  <li>definícia opakovaného cieľa nevyžadovala tri po sebe nasledujúce mesiace,</li>
  <li>široký interval spoľahlivosti hlavného odhadu,</li>
  <li>krátke šesťmesačné sledovanie bez dostatočného hodnotenia klinickej bezpečnosti,</li>
  <li>nepreukázaný rozdiel v žiadnom z hodnotených ukazovateľov variability Hb.</li>
</ul>

<h2>Záver</h2>

<p>V sekundárnej retrospektívnej analýze bol roxadustat spojený s vyššou upravenou pravdepodobnosťou, že hemodialyzovaný pacient s hyporesponzivitou na ESA dosiahne Hb ≥10 g/dl aspoň v troch zo šiestich mesiacov. Štúdia však nepreukázala štatisticky významne nižšiu medzimesačnú variabilitu Hb ani lepšie klinické výsledky.</p>

<p>Najpraktickejším záverom nie je automatický prechod z ESA na roxadustat. Rozhodujúce zostáva dôsledné hľadanie príčiny hyporesponzivity, rešpektovanie preferencie ESA ako prvej voľby podľa KDIGO 2026 a individuálne zváženie skúšobnej liečby HIF-PHI u vhodne vybraného pacienta.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Demir M, Ozturk I, Aktar M, et al. Roxadustat Versus ESA Therapy for Sustained Hemoglobin Response in ESA-Hyporesponsive Hemodialysis Patients. <em>Hemodialysis International</em>. Publikované online 14. júla 2026. DOI: 10.1111/hdi.70116. <a href="https://pubmed.ncbi.nlm.nih.gov/42446261/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1111/hdi.70116" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Pôvodná kohorta:</strong> Ozturk I, et al. Roxadustat for Erythropoiesis-Stimulating Agent Hyporesponsive Anemia in Hemodialysis: Multicenter Retrospective Analysis. <em>Medicina</em>. 2026. <a href="https://pubmed.ncbi.nlm.nih.gov/41901542/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Odporúčania:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in Chronic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2026/01/KDIGO-2026-Anemia-in-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></p>

<p><em><strong>Regulačný kontext:</strong> European Medicines Agency. Evrenzo (roxadustat). <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/evrenzo" target="_blank" rel="noopener noreferrer">EMA</a>.</em></p>
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
                error_log('add_roxadustat_hyporesponzivita newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_roxadustat_hyporesponzivita pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_roxadustat_hyporesponzivita pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_roxadustat_hyporesponzivita migration error: ' . $e->getMessage());
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
