<?php
/**
 * add_renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek_article.php
 * Odborný článok o renálnej funkčnej rezerve, kompenzačnej hyperfiltrácii
 * a limitoch interpretácie zachovaného eGFR.
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
    'title'        => 'Renálna funkčná rezerva: prečo normálny eGFR nevylučuje významné poškodenie obličiek',
    'slug'         => 'renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Zachovaný eGFR nevylučuje CKD ani chronické histologické poškodenie. Renálna funkčná rezerva a kompenzačná hyperfiltrácia vysvetľujú časť tohto nesúladu, ich testovanie však zatiaľ nie je rutinným nástrojom.',
    'content'      => <<<'HTML'
<p>Normálna koncentrácia kreatinínu ani zachovaný odhad glomerulovej filtrácie (eGFR) samy osebe nevylučujú ochorenie obličiek. Pacient môže mať albuminúriu, glomerulárnu hematúriu, štrukturálnu abnormalitu alebo chronické histologické zmeny, hoci celková glomerulová filtrácia zostáva v referenčnom rozmedzí.</p>

<p>Jedným z fyziologických vysvetlení je schopnosť zostávajúcich nefrónov zvýšiť svoju individuálnu filtráciu. Táto kompenzácia môže určitý čas udržiavať celkovú GFR, ale neposkytuje informáciu o počte funkčných nefrónov ani o rozsahu jazvenia. <strong>Normálny eGFR preto treba interpretovať spolu s markermi poškodenia obličiek a klinickým kontextom, nie ako samostatné potvrdenie zdravých obličiek.</strong></p>

<h2>Dve príbuzné, ale nie totožné koncepcie</h2>

<p>V diskusii o „renálnej rezerve“ sa často spájajú dve odlišné roviny: merateľná renálna funkčná rezerva a kompenzačná hyperfiltrácia pri zníženom počte nefrónov. Súvisia spolu, nemožno ich však používať ako synonymá.</p>

<div class="table-responsive" role="region" aria-label="Rozdiel medzi renálnou funkčnou rezervou a kompenzačnou hyperfiltráciou" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Koncepcia</th>
      <th scope="col">Čo znamená</th>
      <th scope="col">Hlavný klinický limit</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Renálna funkčná rezerva</td>
      <td>Rozdiel medzi bazálnou GFR a GFR dosiahnutou po kontrolovanom funkčnom stimule, napríklad po proteínovej záťaži alebo intravenóznom podaní aminokyselín</td>
      <td>Chýba jednotný protokol, referenčné rozmedzie aj validovaný prah pre rutinné rozhodovanie</td>
    </tr>
    <tr>
      <td>Kompenzačná hyperfiltrácia</td>
      <td>Zvýšenie filtrácie na úrovni jednotlivého zostávajúceho nefrónu po vrodenom alebo získanom znížení nefrónovej masy</td>
      <td>Celkový eGFR môže zostať normálny alebo byť znížený; bežné vyšetrenie neumožňuje priamo určiť filtráciu jedného nefrónu</td>
    </tr>
    <tr>
      <td>Glomerulové poškodenie</td>
      <td>Aktívne alebo chronické ochorenie prejavujúce sa napríklad albuminúriou, proteinúriou, glomerulárnou hematúriou alebo histologickými zmenami</td>
      <td>Jeho prítomnosť ani závažnosť nemožno spoľahlivo odvodiť iba z jednej hodnoty kreatinínu alebo eGFR</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Prečo môže celková GFR zostať zachovaná</h2>

<p>Celková GFR je výsledkom súčtu filtrácie všetkých fungujúcich nefrónov. Ak ich počet klesne, zostávajúce nefróny môžu zvýšiť prietok a filtráciu na jeden nefrón. V literatúre sa tento stav označuje ako <strong>relatívna glomerulová hyperfiltrácia</strong>: filtrácia jednotlivého nefrónu je zvýšená, hoci celková GFR môže byť normálna alebo dokonca znížená.</p>

<p>Krátkodobo ide o účinnú adaptáciu, ktorá pomáha zachovať exkréciu a homeostázu. Dlhodobo však zvýšený intraglomerulový tlak, zväčšovanie glomerulov, mechanické zaťaženie podocytov a vyšší tok bielkovín do tubulov môžu podporovať albuminúriu, podocytové poškodenie a glomerulosklerózu. Kompenzácia teda nemusí byť vždy neškodná, no jej dôsledky závisia od príčiny, intenzity a trvania záťaže, vrodeného počtu nefrónov aj získaných rizikových faktorov.</p>

<p>V zdrojovom rozhovore zaznieva orientačné tvrdenie, že výraznejšia maladaptácia nastáva po strate viac než polovice nefrónovej masy. <strong>Nejde o univerzálny klinický prah.</strong> Počet nefrónov sa medzi ľuďmi výrazne líši a vzťah medzi stratou nefrónov, celkovou GFR a progresiou ovplyvňujú vek, pôrodná hmotnosť, krvný tlak, obezita, diabetes, základné ochorenie aj rýchlosť poškodenia.</p>

<h2>Čo eGFR meria a čo z neho nemožno vyčítať</h2>

<p>eGFR je odhad celkovej glomerulovej filtrácie, nie priame meranie počtu nefrónov, ich rezervnej kapacity ani histologického poškodenia. Kreatinín navyše ovplyvňuje svalová hmota, príjem mäsa, katabolizmus, tubulárna sekrécia, objemový stav a niektoré lieky. Aj pri správnom výpočte zostáva eGFR odhadom s individuálnou neistotou.</p>

<p>To neznamená, že eGFR je „neskorý“ alebo málo hodnotný parameter v každej situácii. Je základom klasifikácie CKD, dávkovania mnohých liekov a sledovania priebehu ochorenia. Jeho limitom je, že <strong>zachovaná celková filtrácia nevylučuje súčasné poškodenie obličiek</strong> a izolovaná hodnota nevystihuje dynamiku ochorenia.</p>

<p>Ak presnosť odhadu ovplyvňuje zásadné klinické rozhodnutie a kreatinín môže byť skreslený, KDIGO odporúča podľa dostupnosti využiť kombinovaný odhad z kreatinínu a cystatínu C. Vo vybraných situáciách môže byť potrebné aj meranie GFR exogénnym filtračným markerom. Ani presne zmeraná celková GFR však sama osebe neurčí počet nefrónov alebo rozsah glomerulosklerózy.</p>

<h2>Normálny eGFR nevylučuje CKD</h2>

<p>Podľa KDIGO je CKD definovaná abnormalitou štruktúry alebo funkcie obličiek, ktorá trvá najmenej tri mesiace a má zdravotné dôsledky. Diagnózu preto možno stanoviť aj pri eGFR ≥60 ml/min/1,73 m<sup>2</sup>, ak je prítomný pretrvávajúci marker poškodenia obličiek, napríklad:</p>

<ul>
  <li>albuminúria s pomerom albumín/kreatinín v moči (UACR) ≥30 mg/g, teda ≥3 mg/mmol,</li>
  <li>abnormalita močového sedimentu alebo pretrvávajúca hematúria renálneho pôvodu,</li>
  <li>tubulárna elektrolytová alebo iná funkčná porucha,</li>
  <li>histologická abnormalita,</li>
  <li>štrukturálna abnormalita zistená zobrazovaním,</li>
  <li>anamnéza transplantácie obličky.</li>
</ul>

<p>Naopak, samotná kategória G1 alebo G2 bez ďalšieho markera poškodenia kritériá CKD nespĺňa. Tvrdenie, že „normálny eGFR nevylučuje poškodenie“, preto nemožno obrátiť na predpoklad, že každý človek s normálnym eGFR má skryté ochorenie.</p>

<h2>Glomerulové choroby: filtrácia je iba časť obrazu</h2>

<p>Pri IgA nefropatii, lupusovej nefritíde, fokálnej segmentálnej glomeruloskleróze a ďalších glomerulopatiách môže byť eGFR zachovaný napriek aktívnemu močovému nálezu alebo už prítomným chronickým zmenám. Proteinúria a hematúria boli aj dôvodom biopsie v klinických príkladoch oboch diskutujúcich.</p>

<p>Pretrvávajúca proteinúria môže byť markerom aj mediátorom progresie, ale hematúria si vyžaduje etiologické zhodnotenie. Nie každá hematúria je glomerulová a nie každý pozitívny testovací prúžok znamená chronické poškodenie. Nález treba potvrdiť, posúdiť močový sediment a podľa klinického kontextu vylúčiť prechodné, nefrologické aj urologické príčiny.</p>

<p>Biopsia obličky môže odhaliť aktivitu a chronicitu ochorenia, ktoré z eGFR nemožno určiť. Nie je však skríningovým testom pri každom izolovanom náleze. Indikácia závisí od rozsahu proteinúrie, charakteru sedimentu, trendu eGFR, systémových príznakov, sérologických výsledkov a od toho, či histologický výsledok môže zmeniť diagnózu, prognózu alebo liečbu.</p>

<h2>Ako sa renálna funkčná rezerva testuje</h2>

<p>Renálna funkčná rezerva sa najčastejšie vyjadruje ako absolútny alebo percentuálny vzostup GFR po funkčnom stimule oproti bazálnej hodnote. Používali sa najmä:</p>

<ul>
  <li>perorálna proteínová záťaž,</li>
  <li>intravenózne podanie aminokyselín,</li>
  <li>v niektorých výskumných protokoloch dopamín alebo kombinované stimuly.</li>
</ul>

<p>Spoľahlivé vyšetrenie vyžaduje presné bazálne aj stimulované meranie GFR, kontrolu diéty, hydratácie, času a ďalších hemodynamických vplyvov. Výsledok môžu ovplyvniť zvolený stimul, spôsob merania, vek, strava, tehotenstvo, diabetes, obezita, liečba aj predchádzajúca nefrektómia.</p>

<p>Zníženú alebo neprítomnú odpoveď nemožno jednoducho preložiť na konkrétny percentuálny úbytok nefrónov. Môže znamenať, že časť filtračnej kapacity je využitá už v pokoji, že schopnosť ďalšej vazodilatácie je obmedzená, alebo že výsledok ovplyvnila metodika. <strong>Testovanie renálnej funkčnej rezervy preto zatiaľ nie je štandardizovanou súčasťou bežnej nefrologickej ambulancie a nemá validovanú úlohu pri rutinnom výbere liečby.</strong></p>

<h2>Praktický postup pri zachovanom eGFR a podozrení na poškodenie</h2>

<ol>
  <li><strong>Potvrdiť nález a chronicitu:</strong> neočakávanú albuminúriu, hematúriu alebo zmenu eGFR zopakovať a interpretovať s ohľadom na akútne ochorenie, fyzickú záťaž, infekciu, menštruáciu a analytickú variabilitu.</li>
  <li><strong>Vyšetriť GFR aj albuminúriu:</strong> u rizikového pacienta nestačí iba kreatinín. Doplniť UACR, prípadne pomer proteín/kreatinín v moči a močový sediment.</li>
  <li><strong>Hodnotiť trend:</strong> séria výsledkov je informatívnejšia než jedna hodnota. Posudzovať vývoj eGFR, albuminúrie, krvného tlaku a klinických prejavov.</li>
  <li><strong>Spresniť filtráciu, ak na tom záleží:</strong> pri nesúlade s klinickým obrazom zvážiť eGFR z kreatinínu a cystatínu C alebo meranú GFR podľa dostupnosti a rozhodovacej potreby.</li>
  <li><strong>Určiť príčinu:</strong> využiť anamnézu, lieky, rodinnú záťaž, sérologické a zobrazovacie vyšetrenia; biopsiu indikovať vtedy, keď môže ovplyvniť ďalší postup.</li>
  <li><strong>Liečiť preukázané ochorenie a riziko:</strong> nefroprotektívnu alebo imunomodulačnú liečbu voliť podľa konkrétnej diagnózy, albuminúrie, krvného tlaku, diabetu a odporúčaní, nie podľa neštandardizovaného testu rezervy.</li>
</ol>

<h2>Čo zdroj dokazuje a čo nie</h2>

<p>Hlavným zdrojom je krátky sponzorovaný edukačný rozhovor, nie pôvodná klinická štúdia, systematický prehľad ani klinické odporúčanie. Poskytuje názorné vysvetlenie adaptačnej hyperfiltrácie a skúsenosť nefrológa a renálnej patologičky, neposkytuje však populačné údaje, validáciu diagnostického prahu ani dôkaz, že meranie renálnej funkčnej rezervy zlepšuje výsledky liečby.</p>

<p>Prepis obsahuje označenie „IgG nephropathy“. Keďže nejde o štandardné pomenovanie bežnej glomerulopatie a zo záznamu nemožno spoľahlivo určiť, či ide o prerieknutie alebo chybu transkripcie, nemožno ho automaticky nahradiť diagnózou IgA nefropatie. V tomto článku preto slúži rozhovor ako východisko ku koncepcii, zatiaľ čo klinické tvrdenia sú konfrontované s KDIGO a recenzovanou literatúrou.</p>

<h2>Záver</h2>

<p>Zachovaný eGFR nevylučuje CKD ani významné glomerulové alebo tubulointersticiálne poškodenie. Kompenzačné zvýšenie filtrácie zostávajúcich nefrónov môže prispieť k tomu, že celková GFR zostáva určitý čas normálna, hoci počet funkčných nefrónov klesol alebo ochorenie pokračuje.</p>

<p>Renálna funkčná rezerva je fyziologicky presvedčivý a výskumne zaujímavý koncept, jej testovanie však zatiaľ nemá štandardizovanú rutinnú úlohu. Pre klinickú prax zostáva rozhodujúce spoločné hodnotenie eGFR, albuminúrie alebo proteinúrie, močového sedimentu, krvného tlaku, trendu výsledkov a príčiny ochorenia. Pri podozrení na glomerulopatiu sa nemá čakať na pokles eGFR, ale zároveň sa nemá liečiť iba hypotetická „strata rezervy“ bez preukázaného klinického podkladu.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Radhakrishnan J, Herlitz LC. Expert Opinions on Renal Compensation and Renal Functional Reserve. ReachMD; 2026. Sponzorovaný edukačný odborný rozhovor. <a href="https://reachmd.com/programs/medical-industry-feature/renal-compensation-functional-reserve/39257/" target="_blank" rel="noopener noreferrer">Program a prepis</a>.</em></p>

<p><em><strong>Odporúčania:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></p>

<p><em><strong>Odborný kontext:</strong> Mueller TF, Luyckx VA. Potential Utility of Renal Functional Reserve Testing in Clinical Nephrology. <em>Current Opinion in Nephrology and Hypertension</em>. 2024;33(1):130–135. DOI: 10.1097/MNH.0000000000000930. <a href="https://pubmed.ncbi.nlm.nih.gov/37706475/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1097/MNH.0000000000000930" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Fyziologický prehľad:</strong> Armenta A, Madero M, Rodriguez-Iturbe B. Functional Reserve of the Kidney. <em>Clinical Journal of the American Society of Nephrology</em>. 2022;17(3):458–466. DOI: 10.2215/CJN.11070821. <a href="https://pubmed.ncbi.nlm.nih.gov/34759007/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.2215/CJN.11070821" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Hyperfiltrácia:</strong> Cortinovis M, Perico N, Ruggenenti P, Remuzzi A, Remuzzi G. Glomerular Hyperfiltration. <em>Nature Reviews Nephrology</em>. 2022;18(7):435–451. DOI: 10.1038/s41581-022-00559-y. <a href="https://pubmed.ncbi.nlm.nih.gov/35365815/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1038/s41581-022-00559-y" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>
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
                error_log('add_renal_functional_reserve newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_renal_functional_reserve pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_renal_functional_reserve pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_renal_functional_reserve migration error: ' . $e->getMessage());
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
