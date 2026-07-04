<?php
/**
 * add_injekcny-l-karnitin-tmao-hemodialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_injekcny-l-karnitin-tmao-hemodialyza_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * Pôvodní autori: článok je PÔVODNÁ SYNTÉZA z viacerých overených zdrojov
 * (PubMed/Crossref — autori a DOI overené pri tvorbe), nie spracovanie JEDNÉHO
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
    'title'        => 'Zabráni injekčný L-karnitín tvorbe TMAO? Čo naozaj hovoria dáta',
    'slug'         => 'injekcny-l-karnitin-tmao-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Medzi nefrológmi koluje úvaha, že keď perorálny L-karnitín zvyšuje TMAO, stačí ho podať injekčne (i.v.) po dialýze a problém zmizne. Mechanisticky je to podložené, no slovo „zabráni“ je nadhodnotené: parenterálna cesta mikrobiálnu tvorbu TMAO výrazne tlmí, no neruší ju úplne — a dôkaz o zlepšení tvrdých kardiovaskulárnych výsledkov u ľudí zatiaľ chýba.',
    'content'      => <<<'HTML'
<p>Medzi nefrológmi koluje elegantná úvaha: keďže perorálny L-karnitín zvyšuje hladinu TMAO, stačí ho podať injekčne (intravenózne, i.v.) po dialýze a problém s TMAO zmizne. Mechanisticky je táto úvaha reálne podložená, no slovo <strong>„zabráni“</strong> je nadhodnotené. Injekčná cesta produkciu TMAO výrazne tlmí, no neruší ju úplne — a klinický dosah na tvrdé kardiovaskulárne výsledky zostáva nepreukázaný.</p>

<p>Článok nadväzuje na širší rámec dráhy, ktorú približujeme v texte o <a href="article.php?slug=tmao-crevny-metabolit-uremicky-toxin-ckd">TMAO ako uremickom toxíne pri CKD</a>, a na tému <a href="article.php?slug=cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao">doplnkov s cholínom a L-karnitínom pri diabetickej nefropatii</a>. Tu sa sústredíme na jednu praktickú otázku — na cestu podania.</p>

<h2>Ako vzniká TMAO z karnitínu</h2>

<p>TMAO nevzniká z karnitínu priamo. Rozhodujúci krok je obligátne mikrobiálny:</p>

<ol>
  <li>Črevná mikrobiota premení L-karnitín na <strong>trimetylamín (TMA)</strong>.</li>
  <li>TMA sa vstrebe do krvi a v pečeni ho enzým FMO3 oxiduje na <strong>trimetylamín-N-oxid (TMAO)</strong>.</li>
</ol>

<p>Kľúčový dôkaz priniesli Koeth a kol. (Nature Medicine 2013): potvrdili obligátnu úlohu črevnej mikrobioty pri tvorbe TMAO z prijatého L-karnitínu u ľudí. U bezmikróbnych (germ-free) myší a u ľudí po podaní antibiotík sa TMAO z karnitínu prakticky netvorí; omnivori navyše produkujú po požití karnitínu viac TMAO než vegáni a vegetariáni, a to práve mechanizmom závislým od mikrobioty. Preto záleží na ceste podania: <strong>parenterálne (i.v.) podanie obchádza luminálnu mikrobiotu</strong>, takže z rovnakej dávky vznikne podstatne menej TMAO než pri perorálnej ceste.</p>

<p>Pre dialyzovaných je to obzvlášť dôležité. Perorálna suplementácia L-karnitínu u hemodialyzovaných síce zvýši plazmatickú koncentráciu karnitínu na normálne hodnoty, no zároveň podstatne zvýši aj hladinu TMAO. Perorálny karnitín teda rieši deficit, ale cenu zaň platí vzostupom TMAO.</p>

<h2>Prečo „zabráni“ nie je správne slovo</h2>

<p>Tri okolnosti bránia tomu, aby sme injekčný L-karnitín prezentovali ako úplnú prevenciu TMAO.</p>

<p><strong>Nie je to nula, len menej.</strong> Karnitín podlieha enterohepatálnej cirkulácii a časť sa vylučuje do čreva, kde ju mikrobiota môže spracovať na TMA. Parenterálna cesta tvorbu TMAO výrazne redukuje, no mechanizmus úplne neobchádza.</p>

<p><strong>U dialyzovaných určuje hladinu TMAO predovšetkým obličková eliminácia.</strong> TMAO je uremický retenčný solút. U pacientov s CKD/ESRD je výrazne zvýšený predovšetkým preto, že sa nevylučuje — dialýza ho čiastočne odstráni, no medzi procedúrami sa jeho hladina opäť zvyšuje (rebound). Voľba cesty podania karnitínu túto východiskovú hladinu zásadne nezmení.</p>

<p><strong>„Nepriaznivé pôsobenie“ nie je u ľudí dokázané tvrdými klinickými dátami.</strong> Asociácia TMAO s aterosklerózou a s veľkými nežiaducimi kardiovaskulárnymi príhodami (MACE) je silná a mechanisticky podložená (potlačenie reverzného transportu cholesterolu, zvýšená expresia receptorov CD36/SRA, tvorba penových buniek). Koeth a kol. ukázali, že vysoká hladina karnitínu predpovedá kardiovaskulárne riziko len pri súčasne vysokom TMAO. Ide však o asociačné a mechanistické dáta — intervenčný dôkaz, že samotné zníženie TMAO zlepší tvrdé kardiovaskulárne výsledky u ľudí, zatiaľ chýba.</p>

<h2>Prečo karnitín u dialyzovaných vôbec riešime</h2>

<p>Podľa prehľadu Kljajić a kol. (Journal of Clinical Medicine 2025) je deficit karnitínu u hemodialyzovaných častý a kombinuje prvky primárneho aj sekundárneho deficitu: hemodialýza odstraňuje viac voľného než esterifikovaného karnitínu, zdravé obličky reabsorbujú viac než 90 % filtrovanej nálože a podieľajú sa na jeho syntéze — obe funkcie pri ESRD chýbajú. Pridáva sa malnutrícia, strata do dialyzátu a katabolizmus.</p>

<p>Deficit sa spája s anémiou rezistentnou na liečbu ESA, hypotenziou počas hemodialýzy, svalovými kŕčmi, dyslipidémiou a chronickým zápalom. Dôkazy o benefite suplementácie sú však zmiešané: časť štúdií opísala pokles CRP a zníženie potreby erytropoetínu, iné nezistili žiadny efekt; výsledky pre kŕče, glykémiu a kardiálnu funkciu zostávajú nekonzistentné.</p>

<h2>Dávkovanie a klinické usmernenia</h2>

<table>
  <thead>
    <tr><th scope="col">Parameter</th><th scope="col">Údaj</th></tr>
  </thead>
  <tbody>
    <tr><td>i.v. levokarnitín (HD)</td><td>10–20 mg/kg i.v. po každej HD procedúre (typicky 3× týždenne)</td></tr>
    <tr><td>Bežná klinická dávka</td><td>1 g i.v. po každej HD, resp. 20 mg/kg 3× týždenne</td></tr>
    <tr><td>Perorálne podanie</td><td>500–1000 mg/deň (dávka pre ESRD nie je pevne stanovená)</td></tr>
    <tr><td>Podmienka úhrady (US/ESRD)</td><td>minimálne 3 mesiace na dialýze + definovaná indikácia</td></tr>
  </tbody>
</table>

<p>Zdroje dávkovania: <a href="https://kidneyfoundation.cachefly.net/professionals/KDOQI/guidelines_nutrition/nut_appx10a.html" target="_blank" rel="noopener noreferrer">KDOQI, Appendix X</a>, <a href="https://www.cms.gov/medicare-coverage-database/view/ncacal-decision-memo.aspx?proposed=N&amp;ncaid=44" target="_blank" rel="noopener noreferrer">CMS NCD pre ESRD</a> a <a href="https://www.mdpi.com/2077-0383/14/14/5052" target="_blank" rel="noopener noreferrer">Kljajić a kol. (JCM 2025)</a>.</p>

<p><strong>Bezpečnostná poznámka:</strong> vysokodávkový perorálny karnitín (3 g/deň) v jednej malej štúdii paradoxne zvýšil triacylglyceroly a agregáciu trombocytov — argument proti prístupu „čím viac, tým lepšie“.</p>

<h2>Záver</h2>

<p>Ak je cieľom korigovať deficit karnitínu u dialyzovaného pacienta a zároveň minimalizovať prírastok TMAO, injekčné (i.v.) podanie po dialýze je jednoznačne racionálnejšia voľba než perorálne podanie. Formuláciu „injekčné podanie zabráni tvorbe TMAO a jeho nepriaznivému pôsobeniu“ však treba nahradiť presnejšou: <strong>i.v. podanie výrazne znižuje mikrobiálnu tvorbu TMAO oproti perorálnemu podaniu, avšak s neistým, zatiaľ nepreukázaným dosahom na tvrdé kardiovaskulárne výsledky.</strong></p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Koeth RA, Wang Z, Levison BS, Buffa JA, Org E, Sheehy BT, Britt EB, Fu X, Wu Y, Li L, Smith JD, DiDonato JA, Chen J, Li H, Wu GD, Lewis JD, Warrier M, Brown JM, Krauss RM, Tang WHW, Bushman FD, Lusis AJ, Hazen SL. <em>Intestinal microbiota metabolism of L-carnitine, a nutrient in red meat, promotes atherosclerosis.</em> Nat Med (2013);19(5):576–585. <a href="https://doi.org/10.1038/nm.3145" target="_blank" rel="noopener noreferrer">DOI</a>. Prístupný prehľad: <a href="https://www.natap.org/2017/HIV/050217_04.htm" target="_blank" rel="noopener noreferrer">NATAP</a>.</li>
  <li>Kljajić M, Katalinić L, Krajina L, Kovačić A, Kovačić M, Bašić-Jukić N. <em>Carnitine Supplementation in Chronic Hemodialysis Patients — A Literature Review.</em> J Clin Med (2025);14(14):5052. <a href="https://doi.org/10.3390/jcm14145052" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>NKF KDOQI. <em>Potential Uses for L-Carnitine (Appendix X).</em> <a href="https://kidneyfoundation.cachefly.net/professionals/KDOQI/guidelines_nutrition/nut_appx10a.html" target="_blank" rel="noopener noreferrer">KDOQI</a>.</li>
  <li>CMS. <em>Levocarnitine for ESRD (CAG-00077N).</em> <a href="https://www.cms.gov/medicare-coverage-database/view/ncacal-decision-memo.aspx?proposed=N&amp;ncaid=44" target="_blank" rel="noopener noreferrer">CMS NCD</a>.</li>
  <li>Tufts University / Cleveland Clinic. <em>Research ties gut microbial TMAO pathway to chronic kidney disease.</em> <a href="https://now.tufts.edu/2024/04/11/research-ties-gut-microbial-tmao-pathway-chronic-kidney-disease" target="_blank" rel="noopener noreferrer">Tufts Now (2024)</a>.</li>
</ol>

<p><em>Zdroje boli dohľadané a overené cez PubMed a Crossref (autori a DOI). Zdroj identifikátorov: <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
