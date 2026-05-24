<?php
/**
 * add_fibroza_biomarker_article.php
 * Pridanie článku o neinvazívnom biomarkerovom teste na detekciu fibrózy obličiek z moču
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Molekulárne zobrazovanie z moču: nový biomarker test, ktorý môže zachytiť skorú fibrózu obličiek',
    'slug'         => 'molekularne-zobrazovanie-z-mocu-novy-biomarker-test-fibroza-obliciek',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Vedci vyvinuli nový neinvazívny biomarkerový test, ktorý dokáže zo vzorky moču zachytiť fibrózu obličiek a rozlíšiť mierne a závažnejšie formy ochorenia. V malej kohorte 35 účastníkov dosiahol 84% senzitivitu a 94% špecificitu, pričom bežné ukazovatele ako eGFR alebo kreatinín túto diferenciáciu neumožňovali.',
    'content'      => <<<'HTML'
<p>Vedci vyvinuli nový typ biomarkerového testu, ktorý dokáže <strong>neinvazívne</strong> zistiť <strong>fibrózu obličiek</strong> (tvorbu jazvového tkaniva) zo <strong>vzorky moču</strong>. Štúdia publikovaná v <em>Science Translational Medicine</em> uvádza, že test dokáže pomerne presne rozlíšiť <strong>mierne</strong> a <strong>závažnejšie</strong> formy ochorenia. Dnes pritom ešte nie je v klinickej praxi dostupná metóda, ktorá by podobnú mieru detailu poskytovala spoľahlivo a opakovateľne.</p>

<h2>Prečo je fibróza obličiek dôležitá</h2>

<p>Chronické ochorenie obličiek je spojené s progresívnym zhoršovaním funkcie. Jedným z kľúčových mechanizmov je <strong>fibróza</strong>, čiže nadmerná tvorba jazvového tkaniva v obličkách. Ak sa zachytí včas, môže to pomôcť pri cielenej liečbe a lepšom manažmente pacienta.</p>

<p>Autori zdôrazňujú, že <strong>včasná diagnostika</strong> je dôležitá, lebo sa ňou dá potenciálne predísť nezvratnému poškodeniu.</p>

<h2>Limity dnešnej diagnostiky</h2>

<p>Súčasné prístupy majú viacero slabín:</p>

<ul>
  <li><strong>Biopsia</strong> sa považuje za „zlatý štandard", no je <strong>invazívna</strong>, môže trpieť <strong>výberovou chybou</strong> (vzorka nemusí reprezentovať celý rozsah postihnutia) a tiež existuje <strong>variabilita medzi hodnotiteľmi</strong>.</li>
  <li><strong>Krvné biomarkery</strong> síce môžu byť užitočné, ale podľa článku často nevedia jednoznačne odlíšiť <strong>fibrózu obličiek</strong> od iných stavov alebo fibrózy v iných orgánoch.</li>
</ul>

<h2>Čo je nové: biomarkery TG2 a LysAld aktivované v reportéri</h2>

<p>Výskumný tím identifikoval <strong>dva biomarkery špecifické pre fibrózu obličiek</strong>:</p>

<ul>
  <li><strong>transglutamináza 2 (TG2)</strong>,</li>
  <li>jej substrát <strong>lysyl oxidase–derived allysine (LysAld)</strong>.</li>
</ul>

<p>Oba signály sa majú zvyšovať počas tvorby fibrotického tkaniva.</p>

<p>Autori následne vyvinuli <strong>fluorescenčný (svetelne merateľný) reportér</strong>, ktorý sa viaže na LysAld v obličkách a následne ho TG2 „aktivuje" tak, že sa <strong>rozsvieti fluorescencia</strong>. Čím vyššie sú hladiny biomarkerov (a teda pravdepodobne aj pokročilejšia fibróza), tým silnejší má byť signál.</p>

<h2>Výsledky v malej skupine: lepšia diagnostika než bežné ukazovatele</h2>

<p>V malej kohorte <strong>35 účastníkov</strong> test dokázal:</p>

<ul>
  <li>odlíšiť pacientov s fibrózou obličiek od zdravých kontrol s <strong>84% senzitivitou</strong> a <strong>94% špecificitou</strong>,</li>
  <li>rozlíšiť <strong>mierne vs. závažné prípady</strong> fibrózy, pričom to bolo potvrdené aj histologickým hodnotením.</li>
</ul>

<p>Zaujímavé je, že bežné klinické merania ako <strong>eGFR (glomerulárna filtrácia)</strong>, <strong>kreatinín</strong> a <strong>urea (BUN)</strong> podľa článku nedokázali triediť pacientov podľa závažnosti fibrózy.</p>

<h2>Čo ďalej: potreba väčších a časovo sledovaných štúdií</h2>

<p>Článok upozorňuje, že budú potrebné <strong>rozsiahlejšie štúdie</strong>, aby sa potvrdilo použitie testu ako diagnostického aj prognostického nástroja. Autori zároveň naznačujú potenciál monitorovania progresie ochorenia v čase a hodnotenia odpovede na liečbu.</p>

<p>Zároveň zdôrazňujú, že ide najskôr o <strong>novú doplnkovú metódu</strong> a nie o samostatnú náhradu existujúcich štandardov. V budúcnosti by sa mohla kombinovať s ďalšími biomarkermi, aby sa zvýšila klinická využiteľnosť.</p>

<h2>Záver</h2>

<p>Tento reportérový biomarkerový prístup z moču predstavuje sľubnú cestu k <strong>neinvazívnej detekcii skoršej fibrózy obličiek</strong>. V tejto publikácii test preukázal dobrú schopnosť rozlíšiť aj <strong>mierny vs. závažný</strong> priebeh, zatiaľ však ide o výsledky na relatívne malej skupine. Dôležité bude, či obstojí vo veľkých populáciách a ako presne bude fungovať pri dlhodobom sledovaní.</p>

<hr>

<p><em><strong>Zdroj:</strong> Inside Precision Medicine – „Molecular Imaging Could Detect Early Kidney Fibrosis". <a href="https://www.insideprecisionmedicine.com/topics/molecular-dx/molecular-imaging-could-detect-early-kidney-fibrosis/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Upozornenie:</strong> Tento článok bol osobne spracovaný aj s pomocou rozličných nástrojov tzv. umelej inteligencie (AI).</em></p>
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
                error_log('add_fibroza_biomarker_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_fibroza_biomarker_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: Molekulárne zobrazovanie z moču – fibróza obličiek\n";
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
      <title>Migrácia – Molekulárne zobrazovanie z moču: fibróza obličiek</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Molekulárne zobrazovanie z moču: fibróza obličiek</h2>

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

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
