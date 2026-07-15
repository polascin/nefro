<?php
/**
 * add_semaglutid-ckd-porovnanie-glp1-realna-prax_article.php
 * Odborný článok o porovnaní obličkových výsledkov agonistov receptora GLP-1.
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
    'title'        => 'Semaglutid a riziko chronickej choroby obličiek pri diabete 2. typu: porovnanie agonistov receptora GLP-1 v reálnej praxi',
    'slug'         => 'semaglutid-ckd-porovnanie-glp1-realna-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Observačné porovnanie štyroch agonistov receptora GLP-1 nezistilo rozdiel v primárnom obličkovom ukazovateli. Priaznivé asociácie semaglutidu sa týkali sekundárneho ukazovateľa zahŕňajúceho úmrtie.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) patrí medzi najzávažnejšie komplikácie diabetu 2. typu. Agonisty receptora glukagónu podobného peptidu 1 (GLP-1) sa v posledných rokoch etablovali ako lieky, ktoré znižujú glykémiu, podporujú redukciu telesnej hmotnosti a pri vybraných prípravkoch znižujú kardiovaskulárne aj obličkové riziko.</p>

<p>Randomizovaná štúdia FLOW preukázala obličkový prínos semaglutidu oproti placebu u pacientov s diabetom 2. typu a už prítomnou CKD. Neodpovedala však na inú klinicky dôležitú otázku: <strong>líšia sa obličkové výsledky medzi jednotlivými agonistami receptora GLP-1?</strong> Priame randomizované porovnanie jednotlivých prípravkov s obličkovými ukazovateľmi zatiaľ chýba.</p>

<p>Neumiller a spoluautori sa túto medzeru pokúsili zúžiť observačnou štúdiou publikovanou v časopise <em>American Journal of Kidney Diseases</em>. Pomocou emulácie cieľovej klinickej štúdie porovnali začatie liečby dulaglutidom, exenatidom, liraglutidom alebo semaglutidom u dospelých s diabetom 2. typu a stredným kardiovaskulárnym rizikom.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>Autori využili údaje z databázy OptumLabs Data Warehouse a úplný súbor administratívnych údajov Medicare fee-for-service v Spojených štátoch. Zaradili dospelých vo veku ≥21 rokov, ktorí od 1. januára 2019 do 31. decembra 2021 novozahájili liečbu jedným zo štyroch skúmaných agonistov receptora GLP-1.</p>

<p>Išlo o retrospektívnu observačnú štúdiu s rámcom <strong>emulácie cieľovej klinickej štúdie</strong>. Tento postup vopred formuluje podmienky hypotetického randomizovaného skúšania a potom ich čo najvernejšie napodobní v dostupných údajoch. Rozdiely medzi liečenými skupinami autori vyvažovali vážením podľa inverznej pravdepodobnosti liečby (IPTW); skóre pravdepodobnosti odhadli pomocou ansámblovej metódy SuperLearner. Analýza času do udalosti vychádzala z princípu intention-to-treat a z Coxových modelov príčinovo špecifického rizika s IPTW.</p>

<p>Takýto dizajn môže obmedziť merané skreslenie, <strong>nemôže však z observačných údajov vytvoriť randomizovanú štúdiu</strong>. Nezmerané alebo nepresne zaznamenané rozdiely medzi pacientmi môžu výsledok ovplyvniť aj po štatistickom vyvážení.</p>

<h2>Čo presne sa hodnotilo</h2>

<p>Primárny kompozitný ukazovateľ zahŕňal novozaznamenané diagnostické kódy CKD v štádiu G3 alebo G4 a zlyhanie obličiek, ktoré zahŕňalo CKD G5 alebo náhradu funkcie obličiek. Sekundárny kompozitný ukazovateľ obsahoval rovnaké udalosti a navyše úmrtie z akejkoľvek príčiny. Jednotlivé zložky oboch ukazovateľov autori hodnotili aj samostatne.</p>

<p>Toto vymedzenie je podstatné pre interpretáciu. Nešlo o laboratórne potvrdený vznik CKD podľa opakovaných meraní eGFR a albuminúrie ani o porovnanie sklonu eGFR. Štúdia hodnotila udalosti zachytené administratívnymi kódmi.</p>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky porovnania agonistov receptora GLP-1" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Porovnanie</th>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výsledok</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Dulaglutid, exenatid, liraglutid a semaglutid</td>
      <td>Primárny obličkový kompozit</td>
      <td>Bez štatisticky významného rozdielu</td>
      <td>Štúdia nepreukázala nadradenosť žiadneho zo štyroch liekov v primárnom ukazovateli</td>
    </tr>
    <tr>
      <td>Semaglutid oproti dulaglutidu</td>
      <td>Sekundárny kompozitný ukazovateľ vrátane úmrtia</td>
      <td>HR 0,92; 95 % CI 0,87–0,97</td>
      <td>O 8 % nižšie relatívne riziko</td>
    </tr>
    <tr>
      <td>Semaglutid oproti exenatidu</td>
      <td>Sekundárny kompozitný ukazovateľ vrátane úmrtia</td>
      <td>HR 0,88; 95 % CI 0,79–0,99</td>
      <td>O 12 % nižšie relatívne riziko</td>
    </tr>
    <tr>
      <td>Semaglutid oproti dulaglutidu</td>
      <td>Úmrtie z akejkoľvek príčiny</td>
      <td>HR 0,81; 95 % CI 0,70–0,93</td>
      <td>O 19 % nižšie relatívne riziko</td>
    </tr>
  </tbody>
</table>
</div>

<p>Najdôležitejším výsledkom je <strong>neprítomnosť štatisticky významného rozdielu v primárnom obličkovom kompozite</strong>. Priaznivé asociácie semaglutidu sa objavili až v sekundárnom ukazovateli, ktorý už zahŕňal aj celkovú mortalitu. V dostupnom abstrakte nebola uvedená priaznivá asociácia sekundárneho ukazovateľa semaglutidu oproti liraglutidu.</p>

<p>Hodnoty 8 %, 12 % a 19 % vyjadrujú relatívne rozdiely v riziku v čase, nie absolútny počet odvrátených udalostí. Bez absolútnych rizík a časového horizontu ich nemožno previesť na počet pacientov potrebných na liečbu.</p>

<h2>Čo výsledok dokazuje a čo nie</h2>

<p>Štúdia naznačuje, že začatie liečby semaglutidom môže byť v skúmanej populácii spojené s priaznivejším celkovým klinickým výsledkom než začatie liečby dulaglutidom alebo exenatidom. Sekundárny kompozitný ukazovateľ však spája obličkové udalosti s úmrtím. Keďže primárny obličkový ukazovateľ sa medzi liekmi nelíšil, sekundárny výsledok nemožno interpretovať ako dôkaz silnejšieho priameho nefroprotektívneho účinku semaglutidu.</p>

<p>Výsledok tiež nevytvára spoľahlivé poradie celej triedy. Neodôvodňuje tvrdenie, že semaglutid u každého pacienta spomaľuje pokles eGFR viac než dulaglutid, exenatid alebo liraglutid. Na takýto záver by bolo potrebné randomizované priame porovnanie s laboratórne definovanými obličkovými ukazovateľmi a dostatočne dlhým sledovaním.</p>

<h2>Najdôležitejšie limity</h2>

<ul>
  <li><strong>Administratívne kódy namiesto laboratórnych údajov:</strong> chýbali sériové hodnoty eGFR, kreatinínu a UACR. Nový diagnostický kód nemusí znamenať skutočný nový vznik CKD a môže odrážať rozdielnu intenzitu vyšetrenia alebo kódovania.</li>
  <li><strong>Chýbajúce klinické charakteristiky:</strong> databázy neobsahovali HbA1c, telesnú hmotnosť ani spoľahlivú informáciu o dôvode voľby konkrétneho lieku.</li>
  <li><strong>Reziduálne skreslenie:</strong> pacienti liečení semaglutidom sa mohli od ostatných skupín líšiť vlastnosťami, ktoré nebolo možné zmerať alebo vyvážiť.</li>
  <li><strong>Vyzdvihnutie lieku neznamená adherenciu:</strong> nový vydaný liek nepotvrdzuje jeho dlhodobé užívanie; analýza podľa pôvodne začatej liečby tento rozdiel úplne nezachytí.</li>
  <li><strong>Obmedzená prenositeľnosť:</strong> išlo o administratívne údaje zo Spojených štátov a o pacientov so stredným kardiovaskulárnym rizikom. Výsledok sa nemá automaticky prenášať na populácie s iným rizikom, pokročilou CKD ani na odlišné systémy zdravotnej starostlivosti.</li>
</ul>

<h2>Ako výsledok zapadá do štúdie FLOW</h2>

<p>FLOW bola randomizovaná, placebom kontrolovaná štúdia u 3 533 pacientov s diabetom 2. typu a CKD definovanou pomocou eGFR a UACR. Subkutánny semaglutid v dávke 1,0 mg raz týždenne znížil riziko primárneho kompozitného ukazovateľa závažných obličkových príhod alebo úmrtia z obličkových či kardiovaskulárnych príčin o 24 % oproti placebu (HR 0,76; 95 % CI 0,66–0,88). Priaznivý bol aj výsledok kompozitu pozostávajúceho iba z obličkových zložiek (HR 0,79; 95 % CI 0,66–0,94).</p>

<p>FLOW teda poskytuje randomizovaný dôkaz, že semaglutid má obličkový prínos vo vymedzenej populácii s už prítomnou CKD. Neumillerova analýza skúma inú otázku: porovnanie jednotlivých agonistov receptora GLP-1 pri prevencii novozaznamenanej CKD alebo zlyhania obličiek v reálnej praxi. <strong>Dôkaz semaglutidu oproti placebu nemožno zameniť za dôkaz jeho nadradenosti oproti iným účinným látkam tej istej triedy.</strong></p>

<h2>Praktický význam pre nefrologickú ambulanciu</h2>

<p>Pri výbere agonistu receptora GLP-1 treba zohľadniť celok dôkazov, nie jedinú observačnú analýzu. Rozhodujú najmä registrovaná indikácia, prítomnosť CKD a aterosklerotického kardiovaskulárneho ochorenia, potreba zníženia glykémie a hmotnosti, eGFR, gastrointestinálna tolerancia, krehkosť a nutričný stav, preferovaný spôsob podávania, adherencia, dostupnosť a úhrada.</p>

<p>U pacienta s diabetom 2. typu a CKD agonista receptora GLP-1 nenahrádza ostatné liečebné piliere. Podľa individuálnej indikácie a tolerancie sa nefroprotekcia vrství z optimalizácie krvného tlaku, inhibítora ACE alebo blokátora receptora AT1 pre angiotenzín II pri albuminúrii, inhibítora SGLT2, finerenónu u vhodných pacientov a komplexnej kontroly kardiovaskulárnych rizikových faktorov.</p>

<p>Po začatí liečby má zmysel sledovať eGFR, UACR, krvný tlak, glykémiu, telesnú hmotnosť, objemový stav a toleranciu. Výrazná nauzea, vracanie alebo hnačka môžu viesť k hypovolémii a akútnemu poškodeniu obličiek, najmä pri súbežnej liečbe diuretikom, inhibítorom systému renín-angiotenzín alebo inhibítorom SGLT2. Pacient má dostať jasné pokyny, kedy kontaktovať lekára a ako postupovať počas akútneho ochorenia; dočasné úpravy liečby musia byť individualizované.</p>

<h2>Záver</h2>

<p>Observačné porovnanie dulaglutidu, exenatidu, liraglutidu a semaglutidu nepreukázalo rozdiel v primárnom obličkovom kompozitnom ukazovateli. Semaglutid bol spojený s nižším rizikom sekundárneho kompozitu zahŕňajúceho úmrtie oproti dulaglutidu a exenatidu a s nižšou celkovou mortalitou oproti dulaglutidu.</p>

<p>Ide o klinicky zaujímavý signál, nie o definitívny dôkaz nadradenosti v rámci triedy. Voľbu konkrétneho agonistu receptora GLP-1 možno o tieto údaje oprieť len spolu s randomizovanými štúdiami, charakteristikami pacienta, bezpečnosťou a dostupnosťou liečby. Na spoľahlivé poradie jednotlivých liekov podľa obličkového účinku sú potrebné priame randomizované porovnania.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Neumiller JJ, Deng Y, Swarna KS, Polley EC, Herrin J, Galindo RJ, Umpierrez GE, Ross JS, Mickelson MM, Dryden K, Tuttle KR, McCoy RG. Comparison of Specific Glucagon-Like Peptide-1 Receptor Agonists on Kidney Outcomes Among Patients With Type 2 Diabetes. <em>American Journal of Kidney Diseases</em>. Publikované online 16. júna 2026. DOI: 10.1053/j.ajkd.2026.04.007. <a href="https://pubmed.ncbi.nlm.nih.gov/42302979/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1053/j.ajkd.2026.04.007" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Redakčný komentár:</strong> Reaves AC, Sarnak MJ. Best in Class? The Comparative Effectiveness of Glucagon-Like Peptide 1 Receptor Agonists in Preventing Incident CKD Stage 3 or Higher. <em>American Journal of Kidney Diseases</em>. Publikované online 10. júla 2026. DOI: 10.1053/j.ajkd.2026.07.001. <a href="https://pubmed.ncbi.nlm.nih.gov/42431574/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1053/j.ajkd.2026.07.001" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Randomizovaný kontext:</strong> Perkovic V, Tuttle KR, Rossing P, et al. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2024;391:109–121. DOI: 10.1056/NEJMoa2403347. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Odporúčania:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></p>
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
                error_log('add_semaglutide_glp1_comparison newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_semaglutide_glp1_comparison pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_semaglutide_glp1_comparison pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_semaglutide_glp1_comparison migration error: ' . $e->getMessage());
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
