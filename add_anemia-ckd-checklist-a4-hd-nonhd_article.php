<?php
/**
 * add_anemia-ckd-checklist-a4-hd-nonhd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_anemia-ckd-checklist-a4-hd-nonhd_article.php"
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
    'title'        => 'Checklist do praxe (1 strana A4): Anémia pri CKD (HD aj non-HD)',
    'slug'         => 'anemia-ckd-checklist-a4-hd-nonhd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Jednostranový checklist pre anémiu pri CKD: potvrdenie anémie, základné laboratórium, rozhodnutie o železe podľa skupiny, opatrnosť pri ferric carboxymaltose, ESA/HIF-PHI, intervaly monitorovania a dokumentácia pre audit.',
    'content'      => <<<'HTML'
<p>Tento checklist je určený na rýchle použitie v ambulancii aj na dialýze. Zmysel je praktický: potvrdiť anémiu, vyhodnotiť železo, rozhodnúť o liečbe podľa skupiny pacienta a mať jasne zapísané, prečo bol zvolený konkrétny postup.</p>

<h2>1) Potvrdenie anémie a rýchle zhodnotenie</h2>

<ul>
  <li>☐ <strong>Hb</strong> a trend v čase (dátum, predchádzajúce hodnoty)</li>
  <li>☐ <strong>CBC</strong> s MCV a RDW + <strong>retikulocyty</strong></li>
  <li>☐ Symptómy a tolerancia záťaže: únava, dyspnoe, iné</li>
  <li>☐ Rýchle zhodnotenie príčiny: zápal/infekcia, krvácanie, výživa (klinicky)</li>
  <li>☐ Ak obraz nesedí s CKD anémiou, doplniť plán ďalšej diagnostiky</li>
</ul>

<h2>2) Železo: laboratórny profil</h2>

<ul>
  <li>☐ <strong>Ferritín</strong> (ng/ml): ________</li>
  <li>☐ <strong>TSAT</strong> (%): ________</li>
  <li>☐ Interpretácia v kontexte zápalu, ak je relevantný</li>
</ul>

<h2>3) Voľba liečby železom podľa skupiny</h2>

<h3>A) CKD G5HD (hemodialýza)</h3>

<ul>
  <li>☐ Pri <strong>ferritín ≤ 500 ng/ml</strong> a <strong>TSAT ≤ 30 %</strong> začať <strong>IV železo</strong></li>
  <li>☐ Stop sign pre bezpečnosť: zadržať rutinné železo, ak <strong>ferritín &gt; 700 ng/ml</strong> alebo <strong>TSAT ≥ 40 %</strong></li>
  <li>☐ Typ IV železa a dávkovací plán: ____________________</li>
</ul>

<h3>B) CKD bez HD / PD</h3>

<ul>
  <li>☐ Zvoliť perorálne vs IV železo podľa ferritínu, TSAT, tolerancie, dostupnosti a potreby rýchlej korekcie</li>
  <li>☐ Pri zahájení IV železa zvážiť riziká, najmä pri FCM</li>
</ul>

<h2>4) Špeciálne: FCM a fosfát</h2>

<ul>
  <li>☐ Použitý prípravok: FCM / iné: ____________________</li>
  <li>☐ Ak FCM: plán monitorovania <strong>fosfátu</strong>, hlavne u rizikových pacientov alebo pri nových symptómoch</li>
  <li>☐ Príznaky po podaní: slabosť, bolesti kostí, iné ____________________</li>
  <li>☐ Fosfát: dátum/kedy kontrolovať ____________________</li>
</ul>

<h2>5) Rozhodnutie o ESA alebo HIF-PHI</h2>

<ul>
  <li>☐ Pred nasadením sú riešené korektibilné príčiny, najmä deficit železa</li>
  <li>☐ Zdieľané rozhodovanie s pacientom: benefit vs riziká vrátane transfúzie</li>
  <li>☐ Typ terapie: ESA / HIF-PHI / zatiaľ nie</li>
  <li>☐ Pri CKD G5D zvážiť ESA typicky pri <strong>Hb ~ ≤ 9,0 až 10,0 g/dl</strong> podľa symptómov a trendu</li>
  <li>☐ Pri udržiavaní držať <strong>Hb pod hornou hranicou ~ 11,5 g/dl</strong></li>
</ul>

<h2>6) Monitoring a kontrolné intervaly</h2>

<ul>
  <li>☐ Kontrola <strong>Hb, ferritín, TSAT</strong></li>
  <li>☐ Non-HD a CKD G5PD: <strong>každé 3 mesiace</strong></li>
  <li>☐ CKD G5HD: <strong>každých 1 až 3 mesiace</strong></li>
  <li>☐ Re-evaluácia pri zmene kliniky: infekcia, hospitalizácia, krvácanie, rýchly pokles Hb</li>
  <li>☐ Návrh ďalšej kontroly: [DD.MM.RRRR]</li>
</ul>

<h2>7) Dokumentácia pre audit</h2>

<ul>
  <li>☐ Zapísať aktuálne hodnoty (Hb, ferritín, TSAT ± retikulocyty), interpretáciu a dôvod zvoleného postupu</li>
  <li>☐ Zapísať hranice a odôvodnenie pri začatí alebo zadržaní železa</li>
  <li>☐ Zapísať cieľ Hb a plán monitorovania</li>
  <li>☐ Ak sa zvolil FCM, zapísať dôvod a plán sledovania fosfátu pri opakovaných dávkach</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> KDIGO 2026 a KDOQI US Commentary on the Management of Anemia in CKD. <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
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