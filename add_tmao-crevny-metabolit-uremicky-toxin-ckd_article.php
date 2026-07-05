<?php
/**
 * add_tmao-crevny-metabolit-uremicky-toxin-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_tmao-crevny-metabolit-uremicky-toxin-ckd_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * Pôvodní autori: článok je PÔVODNÁ SYNTÉZA z viacerých overených zdrojov
 * (PubMed/Crossref, autori a DOI overené pri tvorbe), nie spracovanie JEDNÉHO
 * zdrojového článku — preto ostáva pod autorom projektu a do source_authors.php
 * sa NEpridáva (v súlade s pravidlom v tom súbore). Všetky zdroje sú uvedené
 * s autormi a DOI v sekcii „Zdroje“ na konci obsahu.
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
    'title'        => 'Trimetylamín-N-oxid (TMAO): črevný metabolit ako urémický toxín pri chronickej obličkovej chorobe',
    'slug'         => 'tmao-crevny-metabolit-uremicky-toxin-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'TMAO je metabolit cholínu a karnitínu, ktorý tvorí črevný mikrobióm a vylučujú obličky. Pri chronickej obličkovej chorobe sa hromadí ako urémický toxín a spája sa s progresiou CKD aj s vyšším kardiovaskulárnym rizikom — prehľad mechanizmov, prognostického významu a výživových možností.',
    'content'      => <<<'HTML'
<p>Trimetylamín-N-oxid (TMAO) je malá, biologicky aktívna molekula, ktorá vzniká z bežných zložiek potravy činnosťou črevného mikrobiómu a následnou premenou v pečeni. V posledných rokoch sa dostala do centra pozornosti nefrológie aj kardiológie, pretože sa hromadí pri zhoršujúcej sa funkcii obličiek a spája sa s progresiou chronickej obličkovej choroby (CKD) i s vyšším kardiovaskulárnym rizikom. Tento článok zhŕňa, odkiaľ sa TMAO berie, prečo sa pri CKD hromadí, akými mechanizmami škodí a čo z aktuálnych poznatkov reálne vyplýva pre klinickú prax.</p>

<h2>Odkiaľ sa TMAO berie</h2>

<p>Vznik TMAO je viackrokový proces na osi črevo – pečeň – oblička:</p>

<ul>
  <li><strong>Prekurzory z potravy.</strong> Hlavnými zdrojmi sú cholín, L-karnitín a betaín — nachádzajú sa najmä v červenom mäse, vaječnom žĺtku, mliečnych výrobkoch a rybách.</li>
  <li><strong>Premena v čreve.</strong> Črevné baktérie tieto prekurzory metabolizujú na trimetylamín (TMA).</li>
  <li><strong>Oxidácia v pečeni.</strong> TMA sa v pečeni pomocou enzýmu flavín-obsahujúcej monooxygenázy 3 (FMO3) oxiduje na TMAO.</li>
  <li><strong>Vylučovanie obličkami.</strong> Vzniknutý TMAO sa za fyziologických okolností vylučuje prevažne obličkami.</li>
</ul>

<p>Práve posledný krok je pre nefrológiu kľúčový: keďže hlavnou cestou eliminácie TMAO sú obličky, akékoľvek zníženie glomerulárnej filtrácie sa priamo premieta do jeho hladín v krvi.</p>

<h2>Prečo sa TMAO pri chronickej obličkovej chorobe hromadí</h2>

<p>Na zvýšených hladinách TMAO pri CKD sa podieľajú dva mechanizmy, ktoré sa navzájom posilňujú:</p>

<ul>
  <li><strong>Znížená exkrécia.</strong> S poklesom funkcie obličiek klesá klírens TMAO, takže sa kumuluje v obehu — preto sa zaraďuje medzi tzv. urémické toxíny.</li>
  <li><strong>Črevná dysbióza.</strong> CKD je sprevádzaná zmenou zloženia črevného mikrobiómu (dysbiózou) a narušením črevnej bariéry. To posúva metabolizmus smerom k vyššej tvorbe prekurzorov urémických toxínov vrátane TMA a následne TMAO.</li>
</ul>

<p>Tento obojsmerný vzťah sa označuje ako <strong>os črevo – oblička</strong> (gut–kidney axis): zhoršená funkcia obličiek mení črevné prostredie a naopak — dysbiotický mikrobióm produkuje viac toxínov, ktoré ďalej urýchľujú poškodenie obličiek. TMAO je jedným z metabolitov, ktoré túto slučku názorne ilustrujú, popri lepšie preskúmaných toxínoch, akými sú indoxylsulfát a p-krezylsulfát.</p>

<h2>Akými mechanizmami TMAO škodí</h2>

<p>TMAO nie je len pasívnym ukazovateľom — v experimentálnych aj klinických prácach sa spája s viacerými škodlivými účinkami na obličky i na kardiovaskulárny systém:</p>

<ul>
  <li><strong>Obličky:</strong> podpora renálnej fibrózy, poškodenie tubulárnych buniek, prozápalové a profibrotické pôsobenie a oxidačný stres, ktoré prispievajú k progresii CKD.</li>
  <li><strong>Cievy:</strong> proaterogénny účinok, urýchľovanie aterosklerózy a podiel na cievnej kalcifikácii, ktorá zvyšuje tuhosť ciev.</li>
  <li><strong>Srdce:</strong> myokardiálna fibróza a nepriaznivé pôsobenie na srdcový sval.</li>
</ul>

<p>Spoločným menovateľom týchto mechanizmov sú zápal a oxidačný stres — dva procesy, ktoré sú pri CKD chronicky aktivované a ktoré TMAO ešte zosilňuje.</p>

<h2>TMAO ako prognostický ukazovateľ</h2>

<p>Klinický význam TMAO dokresľujú pozorovania, že jeho plazmatické hladiny sú u pacientov s CKD zvýšené a že vyššie hladiny sa spájajú s horšou prognózou — vrátane celkovej mortality a kardiovaskulárnych príhod. TMAO sa tak skúma nielen ako možný pôvodca poškodenia, ale aj ako biomarker rizika.</p>

<p>Treba však zdôrazniť, že väčšina týchto dôkazov má povahu asociácií a mechanistických štúdií. Priamy príčinný podiel TMAO a presné cesty jeho pôsobenia sa stále overujú, preto je namieste opatrná interpretácia.</p>

<h2>Súvislosť s kardiorenálnym syndrómom</h2>

<p>TMAO predstavuje jeden z mostíkov medzi ochorením obličiek a srdca. Pri srdcovom zlyhávaní vedie kongescia splanchnickej oblasti a opuch črevnej steny k narušeniu črevnej bariéry, zvýšenej translokácii baktérií a systémovému zápalu. Súčasne dysbióza a znížený obličkový klírens dvíhajú hladiny TMAO. Tento obojsmerný vzťah medzi srdcovým zlyhávaním a CKD sprostredkovaný črevným mikrobiómom sa navrhuje ako možný terapeutický cieľ pri kardiorenálnom syndróme.</p>

<h2>Diéta a možnosti ovplyvnenia</h2>

<p>Keďže TMAO vzniká z konkrétnych zložiek potravy, do popredia sa dostáva otázka výživy:</p>

<ul>
  <li><strong>Prekurzory v strave.</strong> Cholín a L-karnitín z červeného mäsa a vajec zvyšujú tvorbu TMAO. Poučná je štúdia, v ktorej šesťmesačné podávanie L-karnitínu výrazne zvýšilo hladiny TMAO u starších žien — pripomienka, že aj bežne používané doplnky výživy môžu ovplyvniť tvorbu tohto metabolitu.</li>
  <li><strong>Mierne obmedzenie bielkovín.</strong> U nedialyzovaných pacientov s CKD sa odporúča mierne obmedzenie príjmu bielkovín; okrem ochrany funkcie obličiek znižuje aj tvorbu urémických toxínov z aminokyselín v čreve.</li>
  <li><strong>Ryby ako dvojsečná zbraň.</strong> Ryby sú cenným zdrojom omega-3 mastných kyselín, no zároveň sú významným zdrojom TMAO. Vplyv stravy bohatej na ryby na hladiny TMAO a na kardiovaskulárne výsledky u pacientov s CKD zatiaľ nie je jednoznačne doriešený.</li>
  <li><strong>Modulácia mikrobiómu a inhibícia tvorby.</strong> Experimentálne sa skúma zníženie tvorby TMAO ovplyvnením črevného mikrobiómu či inhibítormi (napríklad 3,3-dimetyl-1-butanol, DMB). Ako doplnkový nefarmakologický prístup k priaznivému ovplyvneniu mikrobiómu sa navrhuje aj pravidelná fyzická aktivita.</li>
</ul>

<p>Napriek množstvu navrhovaných postupov zatiaľ <strong>žiadna z metód nepreukázala účinnosť na tvrdých, na pacienta orientovaných cieľových ukazovateľoch</strong>. To je dôvod na triezvy optimizmus: smer je racionálny, no presvedčivé klinické dôkazy o benefite zatiaľ chýbajú.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Z pohľadu nefrologickej ambulancie možno súčasné poznatky zhrnúť takto:</p>

<ol>
  <li>TMAO je urémický toxín, ktorého hladiny stúpajú s poklesom funkcie obličiek a ktorý sa spája s vyšším kardiovaskulárnym rizikom aj s progresiou CKD.</li>
  <li>Jeho tvorba je ovplyvniteľná stravou — najmä príjmom prekurzorov z červeného mäsa, vajec a doplnkov s karnitínom.</li>
  <li>Cielené „proti-TMAO“ intervencie zatiaľ nie sú súčasťou štandardnej starostlivosti, pretože chýbajú dôkazy o benefite na klinicky tvrdých ukazovateľoch.</li>
  <li>V praxi preto ostávajú kľúčové osvedčené opatrenia — primeraná úprava príjmu bielkovín u nedialyzovaných pacientov, vyvážený jedálniček a komplexná kontrola kardiovaskulárneho rizika — do ktorých téma TMAO zapadá ako doplnkový, no zatiaľ nie samostatne cieliteľný faktor.</li>
</ol>

<h2>Záver</h2>

<p>Trimetylamín-N-oxid je názorným príkladom toho, ako spolu komunikujú črevný mikrobióm a obličky. Ako metabolit cholínu a karnitínu, ktorý vylučujú obličky, sa pri CKD hromadí a prostredníctvom zápalu, oxidačného stresu, fibrózy a cievnych zmien prispieva k obličkovému aj kardiovaskulárnemu poškodeniu. Zostáva sľubným prognostickým biomarkerom a racionálnym terapeutickým cieľom — jeho klinické využitie však musí ešte potvrdiť ďalší výskum. Do tej doby je najrozumnejším prístupom starostlivá výživa a dôsledná kontrola kardiovaskulárneho rizika.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Wang S, Ni Y, Zhou S, Peng H, Cao Y, Zhu Y, Gong J, Lu Q, Han Z, Lin Y, Wang Y. <em>Effects of choline metabolite-trimethylamine N-oxide on immunometabolism in inflammatory bowel disease.</em> Front Immunol (2025). <a href="https://doi.org/10.3389/fimmu.2025.1591151" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Bordoni L, Sawicka AK, Szarmach A, Winklewski PJ, Olek RA, Gabbianelli R. <em>A Pilot Study on the Effects of l-Carnitine and Trimethylamine-N-Oxide on Platelet Mitochondrial DNA Methylation and CVD Biomarkers in Aged Women.</em> Int J Mol Sci (2020). <a href="https://doi.org/10.3390/ijms21031047" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Lim YJ, Sidor NA, Tonial NC, Che A, Urquhart BL. <em>Uremic Toxins in the Progression of Chronic Kidney Disease and Cardiovascular Disease: Mechanisms and Therapeutic Targets.</em> Toxins (Basel) (2021). <a href="https://doi.org/10.3390/toxins13020142" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Tang WHW, Kitai T, Hazen SL. <em>Gut Microbiota in Cardiovascular Health and Disease.</em> Circ Res (2017). <a href="https://doi.org/10.1161/CIRCRESAHA.117.309715" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Tang WHW, Li DY, Hazen SL. <em>Dietary metabolism, the gut microbiome, and heart failure.</em> Nat Rev Cardiol (2019). <a href="https://doi.org/10.1038/s41569-018-0108-7" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Taguchi K, Fukami K, Elias BC, Brooks CR. <em>Dysbiosis-Related Advanced Glycation Endproducts and Trimethylamine N-Oxide in Chronic Kidney Disease.</em> Toxins (Basel) (2021). <a href="https://doi.org/10.3390/toxins13050361" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Li DY, Tang WHW. <em>Contributory Role of Gut Microbiota and Their Metabolites Toward Cardiovascular Complications in Chronic Kidney Disease.</em> Semin Nephrol (2018). <a href="https://doi.org/10.1016/j.semnephrol.2018.01.008" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Moraes C, Fouque D, Amaral ACF, Mafra D. <em>Trimethylamine N-Oxide From Gut Microbiota in Chronic Kidney Disease Patients: Focus on Diet.</em> J Ren Nutr (2015). <a href="https://doi.org/10.1053/j.jrn.2015.06.004" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Filipska I, Winiarska A, Knysak M, Stompór T. <em>Contribution of Gut Microbiota-Derived Uremic Toxins to the Cardiovascular System Mineralization.</em> Toxins (Basel) (2021). <a href="https://doi.org/10.3390/toxins13040274" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Mafra D, Kemp JA, Leal VO, Cardozo L, Borges NA, Alvarenga L, Teixeira KTR, Stenvinkel P. <em>Consumption of Fish in Chronic Kidney Disease — A Matter of Depth.</em> Mol Nutr Food Res (2023). <a href="https://doi.org/10.1002/mnfr.202200859" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em>Zdroje boli dohľadané a overené cez PubMed (autori a DOI). Zdroj identifikátorov: <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
