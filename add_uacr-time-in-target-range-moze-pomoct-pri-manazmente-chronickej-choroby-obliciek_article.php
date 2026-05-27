<?php
/**
 * add_uacr-time-in-target-range-moze-pomoct-pri-manazmente-chronickej-choroby-obliciek_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'UACR „time in target range" môže pomôcť pri manažmente chronickej choroby obličiek',
    'slug'         => 'uacr-time-in-target-range-moze-pomoct-pri-manazmente-chronickej-choroby-obliciek',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Nový výskum z kohorty All of Us ukázal, že percento času, za ktoré je UACR v cieľovom pásme (TTR), nezávisle predpovedá kardiovaskulárne výsledky u pacientov s CKD a mohol by doplniť existujúci manažment chronickej choroby obličiek.',
    'content'      => <<<'HTML'
<p>Nový výskum naznačuje, že ukazovateľ, ktorý meria, <strong>koľko času je hodnota UACR (albumín/kreatinín v moči) v cieľovom pásme</strong>, môže nezávisle predpovedať <strong>kardiovaskulárne výsledky</strong> u pacientov s chronickou chorobou obličiek (CKD) a mohol by byť praktickým doplnkom do manažmentu CKD.</p>

<h2>Prečo sa rieši „time in target range"</h2>

<p>Bežné prístupy hodnotenia dlhodobého UACR podľa článku nezohľadňujú dostatočne <strong>kolísanie hodnôt v čase</strong>. Autori preto navrhujú koncept <strong>TTR (time in target range)</strong> – percento času, za ktoré sa biomarker nachádza vo vopred určenom cieľovom intervale.</p>
<p>Ako príklad Medscape opisuje „trajektóriu" pacienta z dát elektronických zdravotných záznamov (EHR): ak je UACR <strong>dlhodobo konzistentne vysoký</strong>, ide o nepriaznivé zistenie, zatiaľ čo ak sa hodnota udržiava v pásme považovanom za „v norme", pacient je v „zelenej zóne" – v cieľovom rozmedzí.</p>

<h2>Dáta z kohorty „All of Us"</h2>

<p>Výskumníci analyzovali perspektívnu kohortu <strong>All of Us</strong> (849 000 dospelých v USA). Z nej vybrali <strong>306 645</strong> účastníkov, ktorí mali minimálne <strong>3 merania UACR</strong>.</p>
<p>V analyzovanej populácii bolo priemerne:</p>
<ul>
    <li>vek <strong>59 rokov</strong></li>
    <li><strong>62 %</strong> ženy</li>
    <li>diabetes <strong>8 %</strong></li>
    <li>hypertenzia <strong>22 %</strong></li>
    <li>CKD <strong>10 %</strong></li>
    <li>priemerné UACR <strong>117 mg/g</strong></li>
</ul>

<h2>Hlavné zistenia: TTR a kardiovaskulárne udalosti</h2>

<p>V multivariantnej analýze upravenej na demografiu, anamnézu, lieky a laboratórne parametre:</p>
<ul>
    <li><strong>TTR &lt; 30 mg/g</strong> bolo spojené so <strong>zníženým rizikom MACE</strong> (prvá udalosť: infarkt myokardu, mŕtvica alebo smrť) v CKD skupine.<br>
        P-hodnoty boli <strong>0,002</strong> pri tradičnom výpočte TTR a <strong>0,007</strong> pri výpočte podľa <strong>Rosendaalovej lineárnej interpolačnej metódy</strong> (vyvinutej pôvodne pre TTR pri perorálnej antikoagulácii). Podobný trend bol aj v skupine bez CKD (P = <strong>0,001</strong> pre obe metódy).</li>
    <li>Priemerná hodnota UACR sama o sebe v CKD skupine nemusela spoľahlivo zachytiť riziko (hazard ratio blízke 1,00).</li>
    <li><strong>Vyššia „adherencia" k cieľu UACR &lt; 30 mg/g</strong> predpovedala <strong>15 % až 18 % zníženie doživotného rizika MACE</strong>.</li>
</ul>

<h2>Čo je podľa článku ďalší krok</h2>

<p>Prezident NKF Kirk Campbell v komentári zdôrazňuje, že výsledky zaujímavo ukazujú vzťah albuminúrie a kardiovaskulárnych výsledkov, a že v praxi sa abnormalita v moči často „spája" s CKD stagingom aj s eGFR. Práve tento prístup by mohol priniesť viac definície do budúcich štúdií.</p>
<p>Článok zároveň naznačuje, že <strong>v krátkom časovom horizonte to pravdepodobne nezmení odporúčania</strong> – skôr ide o tému pre ďalší výskum. V budúcnosti by sa TTR mohol implementovať do EHR pre ľubovoľné laboratórne hodnoty s vopred daným cieľovým rozmedzím.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Medical News. <a href="https://www.medscape.com/viewarticle/time-target-range-metric-may-aid-ckd-management-2026a1000g2o" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
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

          <p style="margin-top:30px;">
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
