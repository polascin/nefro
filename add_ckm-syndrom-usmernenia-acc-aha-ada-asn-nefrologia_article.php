<?php
/**
 * add_ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): nové usmernenia pre CKM syndróm
 * (ACC/AHA/ADA/ASN) a čo znamenajú pre nefrologickú prax. Slovenské spracovanie
 * zdroja (Medscape Reference / JACC). Pôvodní autori v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia_article.php"
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
    'title'        => 'CKM syndróm konečne ako „jeden rámec": čo znamenajú nové ACC/AHA/ADA/ASN usmernenia pre nefrologickú prax',
    'slug'         => 'ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nové usmernenia ACC/AHA/ADA/ASN zavádzajú kardiovaskulárno-obličkovo-metabolický (CKM) syndróm ako jeden rámec. Čo to znamená pre nefrologickú prax: prepojiť renálne, kardiovaskulárne a metabolické riziko do spoločného postupu detekcie, hodnotenia, manažmentu a sledovania.',
    'content'      => <<<'HTML'
<p>Chronické ochorenie obličiek (CKD) zriedka existuje izolovane. U väčšiny pacientov sa prelína
s diabetom, metabolickými rizikami, obezitou, dyslipidémiou a kardiovaskulárnym ochorením. V praxi
potom vzniká typický problém: každý odbor rieši „svoje" diagnózy, ale pacientovo riziko je spoločné
a rastie naprieč orgánmi.</p>

<p>Nové usmernenia pre <strong>kardiovaskulárno-obličkovo-metabolický (cardiovascular-kidney-metabolic,
CKM) syndróm</strong> majú ambíciu tento prístup prepojiť. Ide o to, že CKD sa už neberie iba ako
renálny koniec reťazca, ale ako súčasť širšieho kardiovaskulárno-metabolického obrazu.</p>

<h2>Čo je cieľom CKM usmernení</h2>
<p>Podľa spracovania na Medscape sú publikované dve súvisiace časti:</p>
<ol>
  <li><strong>„Guideline-at-a-glance" v JACC</strong> (pre rýchlu orientáciu) pre CKM syndróm.</li>
  <li><strong>Komplexné usmernenie AHA/ACC/ADA/ASN</strong> pre prevenciu, detekciu, vyhodnotenie
      a manažment CKM syndrómu.</li>
</ol>
<p>Usmernenia sú významné aj tým, že ide o <strong>nový, explicitný rámec</strong> pre CKM syndróm
(teda nejde len o ďalšiu sumarizáciu jednotlivých diagnóz riešených izolovane v samostatných odboroch).</p>

<h2>Ako to môže vyzerať v nefrologickej ambulancii (prakticky)</h2>
<p>Nefrológ často stojí pred otázkou, ako prepojiť:</p>
<ul>
  <li>renálne riziko (pokles eGFR, albuminúria, progresia),</li>
  <li>kardiovaskulárne riziko (KV príhody, hospitalizácie, zlyhávanie srdca),</li>
  <li>metabolické riziko (diabetes, obezita, dyslipidémia).</li>
</ul>
<p>CKM prístup v zásade podporuje pracovný model, v ktorom sa u pacienta mapa rizika nebuduje oddelene,
ale naraz. Prakticky to môže znamenať:</p>
<ul>
  <li>mať pri každej významnej návšteve „spoločný cieľ" (CKD nie je len cieľová hodnota eGFR, ale aj
      rizikový marker pre kardiovaskulárnu a metabolickú os),</li>
  <li>pri hodnotení pacienta zvažovať, či ide skôr o „čisto renálny problém", alebo o CKM obraz
      s dominantnou kardiometabolickou zložkou,</li>
  <li>plánovať následné kroky v tom istom logickom slede (detekcia a triedenie rizika → hodnotenie →
      manažment a sledovanie).</li>
</ul>

<h2>Prečo je CKM rámec pre nefrológa dôležitý</h2>
<ol>
  <li><strong>Prevencia progresie je často aj prevenciou KV príhod.</strong> Ak sa sústredíte len na
      renálny cieľový ukazovateľ (endpoint), môžete prehliadnuť dominantnú zložku rizika.</li>
  <li><strong>Liečba je komplexná a interdisciplinárna.</strong> CKM rámec prirodzene vytvára priestor
      na koordináciu cieľov s diabetológom a kardiológom.</li>
  <li><strong>Zmysel dávajú „spoločné" ukazovatele.</strong> Nielen eGFR, ale aj rizikové profily,
      albuminúria, krvný tlak, metabolické parametre a celkové kardiovaskulárne riziko.</li>
</ol>

<h2>Čo si z usmernení odniesť ako „nefrologický pracovný postup"</h2>
<p>Keďže ide o CKM usmernenia zamerané na prevenciu, detekciu, vyhodnotenie a manažment, užitočné je
premeniť ich do vlastného interného postupu. Ten si môžete nastaviť napríklad takto:</p>
<ul>
  <li><strong>Detekcia:</strong> u každého pacienta s CKD aktívne pátrať po dominantnej
      kardiometabolickej osi (nielen podľa diagnóz, ale aj podľa rizikového profilu).</li>
  <li><strong>Vyhodnotenie:</strong> zjednotiť dokumentované ciele tak, aby nefrológ riešil renálny aj
      kardiovaskulárny rozmer v prepojenom pláne.</li>
  <li><strong>Manažment a sledovanie:</strong> plánovať kontroly tak, aby sledovali progresiu aj
      rizikové faktory naprieč osami, nie iba laboratórny trend eGFR.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Chiadi E. Ndumele, Fatima Rodriguez, Gurusher S. Panjrath a kol.,
„Cardiovascular-Kidney-Metabolic (CKM) Guidelines (ACC/ADA/AHA/ASN)", <em>JACC</em> (2026); spracované
v <em>Medscape Reference</em>.
<a href="https://reference.medscape.com/cc2/p10/cardiovascular-kidney-metabolic-ckm-guidelines-acc-ada-2026a1000jfz" target="_blank" rel="noopener noreferrer">Medscape</a> ·
<a href="https://doi.org/10.1016/j.jacc.2026.05.008" target="_blank" rel="noopener noreferrer">JACC – guideline-at-a-glance</a> ·
<a href="https://doi.org/10.1016/j.jacc.2026.03.056" target="_blank" rel="noopener noreferrer">JACC – komplexné usmernenie</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_ckm_guidelines newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_ckm_guidelines pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_ckm_guidelines pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_ckm_guidelines migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
