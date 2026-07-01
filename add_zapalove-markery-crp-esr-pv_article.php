<?php
/**
 * add_zapalove-markery-crp-esr-pv_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): interpretácia zápalových
 * markerov (CRP, ESR, plazmatická viskozita) v primárnej starostlivosti.
 * Slovenské spracovanie zdroja (Medscape Reference – Primary Care Hack).
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_zapalove-markery-crp-esr-pv_article.php"
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
    'title'        => 'Ako interpretovať zápalové markery v primárnej starostlivosti: CRP, ESR a plazmatická viskozita (PV) v praxi',
    'slug'         => 'zapalove-markery-crp-esr-pv',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktické čítanie zápalových markerov v ambulancii: CRP (rýchly, ale nešpecifický), ESR (pomalšia, ovplyvnená „fyzikou krvi") a plazmatická viskozita (PV). Všetky sú citlivé, no nízko špecifické — výsledok treba interpretovať v kontexte, nie izolovane.',
    'content'      => <<<'HTML'
<p>Zápalové markery sa v bežnej ambulantnej praxi používajú často, no niekedy sa s nimi robí jedna
z dvoch chýb: buď sa berú ako „diagnóza sama o sebe", alebo sa interpretujú bez kontextu klinického
obrazu. Medscape „Primary Care Hack" sa zameriava najmä na praktické čítanie výsledkov <strong>CRP</strong>,
<strong>ESR</strong> a <strong>plazmatickej viskozity (PV)</strong> ako markerov zápalu a infekcie.</p>

<h2>CRP (C-reaktívny proteín): rýchly indikátor, ale málo špecifický</h2>
<p>CRP je proteín produkovaný pečeňou v reakcii na zápalové cytokíny. Je to <strong>marker akútnej
fázy</strong>, ktorý stúpa relatívne rýchlo (v priebehu približne <strong>6 až 10 hodín</strong>) pri
infekcii, zápale alebo aj pri malignite.</p>
<p>Praktické prahy a interpretácia:</p>
<ul>
  <li><strong>&lt; 5 mg/l</strong> je bežná referenčná hodnota u dospelých.</li>
  <li><strong>CRP &gt; 10 mg/l</strong> (t. j. <strong>&gt; 1,0 mg/dl</strong>) „takmer vždy" indikuje
      prítomnosť akútneho ochorenia, typicky infekcie alebo iného zápalového procesu.</li>
  <li>CRP má kratší biologický polčas (uvádza sa približne <strong>19 hodín</strong>), takže ak sa
      spúšťač vyrieši, hodnoty sa normalizujú <strong>v priebehu dní</strong>.</li>
</ul>
<p>Klinicky užitočné je, že CRP sa dá použiť aj na <strong>rýchle posúdenie a monitorovanie odpovede na
liečbu</strong>, napríklad pri respiračnej alebo urologickej sepse.</p>
<p>Poznámka k interpretácii:</p>
<ul>
  <li>CRP je síce užitočné na detekciu bakteriálnej infekcie, no zostáva <strong>nešpecifické</strong>.</li>
  <li>„Mierne" zvýšenia CRP sa môžu objaviť aj pri stavoch ako <strong>obezita, gravidita, depresia,
      diabetes a kardiovaskulárne ochorenie</strong>.</li>
  <li>Pri neistote sa odporúča interpretovať CRP spolu s <strong>feritínom</strong>, pretože feritín je
      tiež reaktant akútnej fázy. Ak sú zvýšené oba, ide skôr o zápal než o čisté „preťaženie železom".</li>
</ul>

<h2>ESR (sedimentácia erytrocytov): pomalšia, ovplyvnená „fyzikou krvi"</h2>
<p>ESR meria rýchlosť poklesu erytrocytov v štandardizovanej skúmavke. Závisí od toho, do akej miery
erytrocyty tvoria tzv. rouleaux (zhluky), čo urýchľujú proteíny akútnej fázy pri infekcii, zápale alebo
malignite.</p>
<p>Kľúčové praktické body z Medscape:</p>
<ul>
  <li>ESR nemá univerzálne štandardné „normy": normálne hodnoty sa menia s <strong>vekom a pohlavím</strong>
      a výsledok závisí od metódy v konkrétnom laboratóriu.</li>
  <li>Ako orientačné pravidlo pre hornú hranicu normy (ULN) sa uvádza:
    <ul>
      <li><strong>ženy: (vek + 10) ÷ 2</strong></li>
      <li><strong>muži: vek ÷ 2</strong></li>
    </ul>
  </li>
  <li>ESR <strong>&gt; 100 mm/h</strong> má podľa textu vysokú prediktívnu hodnotu: uvádza sa
      <strong>97 %</strong> pre prítomnosť základného ochorenia.</li>
</ul>
<p>Dynamika: ESR typicky stúpa v priebehu <strong>24 až 48 hodín</strong> a normalizuje sa
<strong>pomaly</strong>, často až <strong>v priebehu týždňov</strong>.</p>
<p>Špecifickosť a „kedy myslieť na významnú príčinu":</p>
<ul>
  <li>ESR je menej citlivé aj menej špecifické než CRP.</li>
  <li>Pri vysokej ESR sa spomína najmä súvis s diagnózami ako <strong>malignita</strong> (napr.
      mnohopočetný myelóm, lymfóm, metastatické nádory aj karcinómy) a <strong>GCA</strong>
      (obrovskobunková arteritída, arteriitis temporalis).</li>
</ul>
<p>Interferencie: ESR ovplyvňuje okrem veku aj <strong>pohlavie a hematokrit</strong> (napr. anémia
alebo polycytémia), tehotenstvo, životný štýl (alkohol, fajčenie, pravidelné cvičenie), lieky a aj
oneskorenie pri analýze vzorky.</p>

<h2>PV (plazmatická viskozita): podobná ESR, ale technicky náročnejšia</h2>
<p>PV hodnotí „hrúbku" plazmy, ktorá súvisí hlavne s koncentráciou plazmatických proteínov (najmä
fibrinogénu a niektorých imunoglobulínov). Preto môže stúpať pri infekcii, zápale a niektorých
malignitách.</p>
<p>Medscape uvádza:</p>
<ul>
  <li>normálny interval pre dospelých <strong>1,50 až 1,72 mPa·s</strong>,</li>
  <li>hraničný (ekvivalentný) výsledok <strong>1,72 až 1,80 mPa·s</strong> (s odporúčaním zvážiť
      opakovanie),</li>
  <li>zvýšený výsledok <strong>&gt; 1,80 mPa·s</strong>.</li>
</ul>
<p>Dôležité praktické vlastnosti:</p>
<ul>
  <li>PV vo všeobecnosti „rastie" podobne ako ESR,</li>
  <li>je však uvedené, že je <strong>spoľahlivejším markerom</strong> než ESR,</li>
  <li>zároveň je technicky náročnejšia a nákladnejšia, preto ju veľa laboratórií rutinne neponúka.</li>
</ul>

<h2>Spoločný záver: CRP, ESR a PV majú vysokú citlivosť, ale nízku špecifickosť</h2>
<p>V texte sa priamo zdôrazňuje, že <strong>CRP, ESR aj PV sú citlivé, ale nízko špecifické</strong> pre
infekciu a zápal. Praktický dôsledok je jednoduchý: výsledok treba vždy interpretovať spolu so
symptómami, vyšetrením a ďalšími testami, nie izolovane.</p>

<hr>

<p><em><strong>Zdroj:</strong> „Interpreting Inflammatory Marker Tests in Primary Care (Primary Care
Hack)" — časť k CRP, ESR a PV, <em>Medscape Reference</em> (2026).
<a href="https://reference.medscape.com/cc2/p10/interpreting-inflammatory-marker-primary-care-hack-2026a1000j8k" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_zapalove_markery newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_zapalove_markery pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_zapalove_markery pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_zapalove_markery migration error: ' . $e->getMessage());
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
