<?php
/**
 * add_ttv-biomarker-imunosupresia-transplantacia-oblicky_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ttv-biomarker-imunosupresia-transplantacia-oblicky_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Biomarkerom riadené znižovanie imunosupresie po transplantácii obličky: TTV ako meradlo imunitnej aktivity',
    'slug'         => 'ttv-biomarker-imunosupresia-transplantacia-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Randomizovaná štúdia fázy II (TTVguideIT) testovala, či možno bezpečne individualizovať imunosupresiu po transplantácii obličky pomocou biomarkera Torque teno vírus (TTV). U stabilných nízkorizikových príjemcov nebolo TTV-riadené dávkovanie takrolimu horšie než štandard — a viedlo k nižším dávkam.',
    'content'      => <<<'HTML'
<p>Lekárska univerzita vo Viedni (MedUni Wien) informuje o klinickom skúšaní, v ktorom medzinárodný tím otestoval, či možno bezpečne individualizovať imunosupresiu po transplantácii obličky pomocou biomarkera <strong>Torque teno vírus (TTV)</strong>.</p>

<p>Cieľ je praktický: pri klasickom prístupe sa dávka imunosupresie riadi najmä <strong>cieľovými hladinami liekov v krvi</strong> (napr. takrolimu). Tieto hodnoty však nemusia presne odrážať, ako silno je daný pacient imunologicky tlmený. TTV má slúžiť ako nepriamy ukazovateľ aktivity imunitného systému.</p>

<h2>Čo presne testovali</h2>

<p>Išlo o <strong>randomizovanú kontrolovanú štúdiu fázy II (TTVguideIT)</strong>. Do štúdie bolo zaradených:</p>

<ul>
  <li><strong>260 dospelých</strong> stabilných príjemcov transplantátu,</li>
  <li>v <strong>13 akademických centrách</strong> v Európe,</li>
  <li>pacienti boli zaradení v čase približne <strong>4 mesiace po transplantácii</strong>.</li>
</ul>

<p>Porovnávali sa dva prístupy:</p>

<ul>
  <li><strong>TTV-riadené</strong> dávkovanie <strong>takrolimu</strong>,</li>
  <li><strong>štandardné</strong> dávkovanie podľa konvenčných cieľových hladín.</li>
</ul>

<h2>Populácia, v ktorej výsledok platí</h2>

<p>Tento prístup sa vzťahuje primárne na pacientov:</p>

<ul>
  <li><strong>stabilných</strong>,</li>
  <li>s <strong>nízkym imunologickým aj infekčným rizikom</strong>,</li>
  <li>v období približne <strong>prvého roka po transplantácii</strong>.</li>
</ul>

<h2>Hlavné výsledky</h2>

<p>Primárny kombinovaný cieľ tvorili <strong>infekcie, rejekcia, strata štepu alebo úmrtie</strong>.</p>

<ul>
  <li>v skupine riadenej TTV sa tento cieľový ukazovateľ vyskytol u <strong>35 %</strong> pacientov,</li>
  <li>v kontrolnej skupine u <strong>38 %</strong> pacientov,</li>
  <li>štúdia tým splnila cieľ <strong>noninferiority</strong> (nie horšieho výsledku) — TTV-riadené dávkovanie teda nebolo horšie než štandard.</li>
</ul>

<p>Výskyt rejekcií v protokolových biopsiách po 12 mesiacoch bol v oboch skupinách <strong>porovnateľný</strong>.</p>

<p>Zároveň:</p>

<ul>
  <li>pacienti v TTV-riadenej skupine mali <strong>nižšie hladiny takrolimu</strong> a dostávali <strong>nižšie denné dávky</strong>,</li>
  <li>štatisticky významné zníženie infekcií sa v tejto štúdii nepreukázalo, no výsledky naznačujú, že v nízkorizikových skupinách možno imunosupresiu nastaviť <strong>miernejšie</strong> bez zhoršenia bezpečnosti štepu.</li>
</ul>

<h2>Prečo je TTV zaujímavé v praxi</h2>

<p>TTV:</p>

<ul>
  <li>je <strong>prítomný u veľkej časti populácie</strong>,</li>
  <li>priamo „nevypovedá“ o chorobe, ale umožňuje usudzovať o <strong>aktivite imunitného systému</strong>,</li>
  <li>má potenciál byť <strong>štandardizovaný, nákladovo efektívny a pomerne jednoducho merateľný</strong>,</li>
  <li>do budúcnosti by mohol viesť k cielenejšej personalizácii imunosupresie.</li>
</ul>

<h2>Praktické ponaučenie pre nefrologickú prax</h2>

<p>Nejde o hotový algoritmus pre každého pacienta, ale o jasný smer:</p>

<ul>
  <li>u nízkorizikových, stabilných príjemcov transplantátu sa javí ako možné <strong>znižovať takrolimus</strong> podľa biomarkera,</li>
  <li>pričom (aspoň v prvom roku) nedochádza k nárastu rejekcií,</li>
  <li>čo teoreticky otvára priestor na „personalizované minimum“ imunosupresie.</li>
</ul>

<p>Ak sa TTV bude do praxe zavádzať, bude kľúčové presne definovať:</p>

<ul>
  <li>pre koho je tento prístup vhodný (rizikový profil),</li>
  <li>v ktorom období po transplantácii dáva zmysel,</li>
  <li>a ako sa bude riešiť prípadný prechod do vyššieho rizika (imunologické zhoršenie alebo infekcie).</li>
</ul>

<h2>Čo zostáva nejasné</h2>

<p>Štúdia sa týka konkrétneho obdobia a konkrétnej skupiny pacientov. Ďalší výskum už prebieha — vo Francúzsku pokračuje nadväzujúca (follow-up) štúdia pre pacientov <strong>od druhého roka po transplantácii</strong>, keďže prínos TTV-riadeného dávkovania v neskorších fázach treba ešte overiť.</p>

<hr>

<p><em><strong>Zdroj:</strong> MedUni Wien (8. jún 2026): „Biomarker-Guided Immunosuppression Following Kidney Transplantation Successfully Tested“. <a href="https://www.meduniwien.ac.at/web/en/about-us/news/2026/news-in-june-2026/biomarker-guided-immunosuppression-following-kidney-transplantation-successfully-tested/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
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
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
