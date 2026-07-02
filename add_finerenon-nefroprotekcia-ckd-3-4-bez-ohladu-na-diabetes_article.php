<?php
/**
 * add_finerenon-nefroprotekcia-ckd-3-4-bez-ohladu-na-diabetes_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_finerenon-nefroprotekcia-ckd-3-4-bez-ohladu-na-diabetes_article.php"
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
    'title'        => 'Finerenón: nefroprotektívny účinok aj pri CKD 3–4 bez ohľadu na diabetes',
    'slug'         => 'finerenon-nefroprotekcia-ckd-3-4-bez-ohladu-na-diabetes',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prospektívne hodnotenie u 180 ambulantných pacientov s CKD 3.–4. štádia a významnou albuminúriou naznačuje nefroprotektívny prínos finerenónu nezávisle od prítomnosti diabetu, bez nárastu hyperkaliémie. Ide o malú reálnu kohortu — preto skôr signál a smer než definitívny dôkaz.',
    'content'      => <<<'HTML'
<p>Portál Physicians Weekly opisuje výsledky štúdie, v ktorej <strong>finerenón</strong> dokázal <strong>spomaliť progresiu chronického ochorenia obličiek (CKD)</strong> u pacientov v <strong>3.–4. štádiu</strong> s <strong>eGFR 20 až 60 ml/min</strong> a <strong>stredne ťažkou až ťažkou albuminúriou</strong>, a to <strong>nezávisle od prítomnosti diabetu</strong>. Text zdôrazňuje aj bezpečnostný aspekt: nárast <strong>hyperkaliémie</strong> sa nepozoroval.</p>

<h2>Kto bol v štúdii</h2>

<p>Išlo o prospektívne hodnotenie u <strong>180 ambulantných pacientov</strong> v Iraku (CKD 3.–4. štádia; eGFR <strong>20–60 ml/min</strong>; <strong>UACR &gt; 30 mg/g</strong>):</p>

<ul>
  <li>pri vstupnom hodnotení malo <strong>78 % pacientov diabetes</strong>,</li>
  <li><strong>36 %</strong> malo eGFR v pásme <strong>20 až 25 ml/min</strong>.</li>
</ul>

<h2>Hlavné výsledky (po 1 roku)</h2>

<p>V skupine ako celku:</p>

<ul>
  <li><strong>eGFR sa zlepšila</strong>: z približne <strong>32 ± 10</strong> na <strong>47 ± 15 ml/min</strong>,</li>
  <li><strong>UACR sa znížila</strong>: z približne <strong>542 ± 400</strong> na <strong>180 ± 170 mg/g</strong>.</li>
</ul>

<h2>Analýza podskupín</h2>

<h3>Pacienti bez diabetu</h3>

<ul>
  <li>eGFR: z približne <strong>33 ± 10</strong> na <strong>50 ± 16 ml/min</strong>,</li>
  <li>UACR: z približne <strong>592 ± 431</strong> na <strong>203 ± 197 mg/g</strong>.</li>
</ul>

<h3>Pacienti s eGFR 20 až 25 ml/min</h3>

<ul>
  <li>eGFR: z približne <strong>21 ± 2</strong> na <strong>36 ± 8 ml/min</strong> po roku,</li>
  <li>UACR: z približne <strong>602 ± 380</strong> na <strong>209 ± 152 mg/g</strong>.</li>
</ul>

<h2>Bezpečnosť: draslík</h2>

<p>Článok priamo uvádza, že <strong>finerenón nezvyšoval hladinu sérového draslíka</strong>. Aj v podskupine s eGFR <strong>20–25 ml/min</strong> boli priemerné hodnoty draslíka približne <strong>4,8 ± 0,7 mmol/l na začiatku</strong> a <strong>4,8 ± 0,6 mmol/l po 1 roku</strong>.</p>

<h2>Praktické ponaučenie</h2>

<p>Tento zdroj prakticky podporuje myšlienku, že u vybraných pacientov s <strong>CKD 3.–4. štádia a významnou albuminúriou</strong> môže mať finerenón <strong>nefroprotektívny prínos aj bez diabetu</strong>. Zároveň však ide o reálnu populáciu (ambulantní pacienti, v texte zjavne v kontexte mimo schválenej indikácie), čo treba do praxe preložiť takto:</p>

<ul>
  <li>relevantní sú pacienti s albuminúriou (UACR &gt; 30 mg/g) a eGFR v príslušnom rozmedzí,</li>
  <li>a zároveň treba dodržať realistickú klinickú logiku monitorovania draslíka (aj keď v tejto kohorte hyperkaliémia nebola problémom).</li>
</ul>

<h2>Dôležitá opatrnosť pri interpretácii</h2>

<p>Text je správou o štúdii a neuvádza všetky detaily (dizajn, presné parametre a štatistické testy). Pozoruhodné je najmä <em>zlepšenie</em> eGFR, ktoré je pri tejto liekovej triede netypické a samo osebe si vyžaduje opatrnú interpretáciu. Preto k záverom pristupujme ako k <strong>signálu</strong> a smeru — praktickú pointu si zaslúžia, ale pred nasadením u konkrétneho pacienta treba držať lokálne odporúčania a bezpečnostné monitorovanie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Physicians Weekly: „Finerenone Effective for Stage 3-4 Kidney Disease Regardless of Diabetes Status“. <a href="https://www.physiciansweekly.com/post/finerenone-effective-for-stage-3-4-kidney-disease-regardless-of-diabetes-status/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
