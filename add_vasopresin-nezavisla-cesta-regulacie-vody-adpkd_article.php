<?php
/**
 * add_vasopresin-nezavisla-cesta-regulacie-vody-adpkd_article.php
 * Odborný článok — nová, od vazopresínu nezávislá cesta regulácie vody v obličkách
 * a jej význam pre liečbu ADPKD (spracovanie JCI 2026, DOI 10.1172/JCI197021).
 * Idempotentný UPSERT (INSERT … ON DUPLICATE KEY UPDATE).
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
    'title'        => 'Nová, od vazopresínu nezávislá cesta regulácie vody v obličkách a jej význam pre liečbu ADPKD',
    'slug'         => 'vasopresin-nezavisla-cesta-regulacie-vody-adpkd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Objav dráhy urát – AMPK – AQP2 v zberných kanálikoch odhaľuje, ako oblička vstrebáva vodu nezávisle od vazopresínu. Sľubuje zmiernenie akvaretickej záťaže tolvaptanu pri ADPKD a lepšiu toleranciu liečby.',
    'content'      => <<<'HTML'
<p>Autozomálne dominantná polycystická choroba obličiek (ADPKD) patrí k ochoreniam, kde je jedným z hlavných cieľov liečby obmedziť rast cýst — to sa však darí len za cenu nežiaducich účinkov. Nový translačný poznatok tímu z Mayo Clinic opisuje doplnkový, od vazopresínu nezávislý mechanizmus, ktorým oblička reguluje spätné vstrebávanie vody. V budúcnosti by mohol zmierniť akvaretickú záťaž liečby tolvaptanom a zlepšiť tak jej toleranciu.</p>

<h2>Prečo je to dôležité pre nefrológov</h2>

<p>Tolvaptan (antagonista V2 receptorov pre vazopresín) spomaľuje progresiu ADPKD, no zároveň zvyšuje diurézu — ide o takzvaný akvaretický efekt. V praxi to často znamená výraznú polyúriu a nočné močenie (noktúriu), čo znižuje toleranciu liečby aj adherenciu k nej.</p>

<p>Nové zistenia tímu z Mayo Clinic opisujú doplnkový mechanizmus, ktorým oblička reguluje spätné vstrebávanie vody nezávisle od klasickej osi V2 receptor – cAMP – AQP2. Táto „záložná“ cesta by v budúcnosti mohla zmierniť akvaretickú záťaž pri zachovaní priaznivého účinku tolvaptanu.</p>

<h2>Čo našli: urát ako vnútrobunkový signál v zberných kanálikoch</h2>

<p>Kľúčom k objavu bol výskum účinkov staršieho lieku probenecidu (dnes používaného najmä pri dne a hyperurikémii). Výskumníci očakávali, že tento liek bude proces ochorenia zhoršovať — v experimentálnych modeloch sa však ukázal opak. Probenecid podľa výsledkov znižoval rast cýst a zároveň upravoval vodné hospodárstvo tak, že výrazne tlmil nárast objemu moču vyvolaný tolvaptanom.</p>

<p>Mechanizmus možno zhrnúť takto:</p>

<ul>
  <li>V zberných kanálikoch zvýšenie vnútrobunkovej koncentrácie urátu ovplyvňuje presun (trafficking) vodného kanála <strong>AQP2</strong> (akvaporín-2).</li>
  <li>Toto zvýšenie vnútrobunkového urátu je dôsledkom zmien jeho transportu:
    <ul>
      <li><strong>GLUT9b</strong> zvyšuje jeho apikálny (luminálny) príjem,</li>
      <li><strong>ABCG2</strong> znižuje jeho apikálny výdaj (eflux).</li>
    </ul>
  </li>
  <li>Nasleduje signálna kaskáda, v ktorej sa uplatňuje fosfodiesteráza <strong>PDE4</strong>, pokles <strong>cAMP</strong> a aktivácia <strong>AMPK</strong>, čo vedie k hromadeniu AQP2 na apikálnej membráne.</li>
  <li>Výsledok: spätné vstrebávanie vody sa zvyšuje mechanizmom, ktorý stojí v protiklade ku klasickej regulácii cez <strong>V2R</strong> (vazopresín).</li>
</ul>

<p>Podstatné pre klinickú úvahu: v predklinických modeloch sa tak podľa autorov podarilo „oddeliť“ útlm rastu cýst od dávku limitujúceho akvaretického účinku antagonizmu V2R.</p>

<h2>Čo to znamená pre pacientov: probenecid ako „adjuvans“ k tolvaptanu</h2>

<p>Mayo Clinic v materiáli pre verejnosť uvádza aj presah do klinickej roviny: v malej štúdii fázy 2 u pacientov s ADPKD liečených tolvaptanom probenecid znížil:</p>

<ul>
  <li>priemerný objem moču približne o <strong>30 %</strong>,</li>
  <li>frekvenciu nočného močenia z „niekoľkokrát za noc“ približne na <strong>jedenkrát</strong>,</li>
  <li>pričom väčšina pacientov uvádzala zlepšenie kvality života.</li>
</ul>

<p>Autori zároveň zdôrazňujú, že nejde o definitívne riešenie. Probenecid je starý liek, nepôsobí cielene iba na túto dráhu a nie je súčasťou bežných liečebných schém ADPKD. Skôr ho využívajú ako východisko pri návrhu cielenejších terapií.</p>

<h2>Praktický dopad do nefrologickej praxe (čo sledovať, ako uvažovať)</h2>

<p>Tento objav je zatiaľ predovšetkým mechanisticky podloženým translačným poznatkom, nie štandardom odporúčaným do rutinnej klinickej praxe. Napriek tomu dáva veľmi konkrétny smer úvahám o manažmente ADPKD:</p>

<ol>
  <li>
    <strong>Adherencia k tolvaptanu nie je len otázka účinku, ale aj kvality života.</strong>
    Ak sa zmierni akvaretická záťaž bez straty anticystického prínosu, môže to v klinickej praxi znamenať vyššiu udržateľnosť liečby.
  </li>
  <li>
    <strong>Zmysel má rozlišovať dve veci:</strong>
    <ul>
      <li>schopnosť spomaliť cystickú progresiu,</li>
      <li>oproti tolerovateľnosti akvaretického účinku.</li>
    </ul>
    Táto práca sa zameriava práve na druhú z nich.
  </li>
  <li>
    <strong>Čo by sa v budúcnosti mohlo stať merateľným cieľom.</strong>
    Popri tradičných parametroch ochorenia (funkcia obličiek, prírastok objemu obličiek, rizikové fenotypy) bude dôležité sledovať aj:
    <ul>
      <li>objem moču a nočnú diurézu ako klinicky relevantnú záťaž,</li>
      <li>zmeny hydratácie a symptomatiku,</li>
      <li>a, samozrejme, bezpečnosť zvoleného zásahu.</li>
    </ul>
  </li>
  <li>
    <strong>Poznámka k bezpečnosti.</strong>
    Probenecid ovplyvňuje hospodárenie s kyselinou močovou a vstupuje do viacerých liekových interakcií. Preto bez jasných protokolov a schválených indikácií nemá zmysel uvažovať o jeho „off-label“ pridaní k tolvaptanu.
  </li>
</ol>

<h2>Zhrnutie jednou vetou</h2>

<p>Objav dráhy urát – AMPK – AQP2 v zberných kanálikoch predstavuje potenciálnu cestu, ako zmierniť akvaretickú záťaž tolvaptanu pri ADPKD a zlepšiť tak toleranciu liečby aj adherenciu; jej klinický prínos je však zatiaľ predmetom ďalšieho výskumu.</p>

<hr>

<p><em><strong>Zdroj:</strong> Hadla M, Mardirossian JM, Bichet DG, Borghol AH, Abboud G, Ghanem A, Chini EN, Harris PC, Torres VE, Alper SL, Vallon V, Chebib FT. <em>GLUT9b- and ABCG2-mediated collecting duct urate transport uncover a vasopressin-independent mechanism of renal water reabsorption.</em> J Clin Invest. 2026. DOI: 10.1172/JCI197021. <a href="https://www.jci.org/articles/view/197021" target="_blank" rel="noopener noreferrer">jci.org/articles/view/197021</a>.</em></p>

<p><em>Popularizačný materiál: Mayo Clinic News Network. <em>Researchers identify new kidney pathway with help from 1940s-era drug, may improve polycystic kidney disease treatment.</em> <a href="https://newsnetwork.mayoclinic.org/discussion/researchers-identify-new-kidney-pathway-with-help-from-1940s-era-drug-may-improve-polycystic-kidney-disease-treatment/" target="_blank" rel="noopener noreferrer">newsnetwork.mayoclinic.org</a>.</em></p>
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
