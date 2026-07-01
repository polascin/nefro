<?php
/**
 * add_ako-prebieha-hemodialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o tom,
 * ako prebieha hemodialýza (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ako-prebieha-hemodialyza_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Ako prebieha hemodialýza: čo môžete čakať',
    'slug'         => 'ako-prebieha-hemodialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Krok za krokom vysvetľujeme, ako vyzerá jedno hemodialyzačné sedenie, ako často sa opakuje, čo je cievny prístup a ako sa môžete po dialýze cítiť.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/medimpax.png" alt="Dialyzačné stredisko Medimpax v Bratislave-Dúbravke" loading="lazy" decoding="async">
  <figcaption>Dialyzačné stredisko Medimpax, Na vrátkach 2/A, Bratislava-Dúbravka.</figcaption>
</figure>

<p>Ak vám lekár oznámil, že budete potrebovať hemodialýzu, je prirodzené mať otázky a obavy.
V tomto článku jednoduchým jazykom vysvetlíme, ako jedno dialyzačné sedenie prebieha — aby ste
vedeli, čo čakať.</p>

<h2>Čo je hemodialýza</h2>

<p>Keď obličky nedokážu dostatočne čistiť krv, túto úlohu preberá <strong>dialyzačný prístroj</strong>.
Vaša krv počas liečby plynie cez špeciálny filter (dialyzátor), ktorý z nej odstraňuje odpadové
látky a prebytočnú vodu, a očistená sa vracia späť do tela. Ide o bezpečnú a zaužívanú liečbu.</p>

<h2>Ako vyzerá jedno sedenie</h2>

<ol>
  <li><strong>Príchod a odváženie.</strong> Na začiatku vás odvážia — podľa hmotnosti sa určí,
      koľko vody treba počas dialýzy odobrať.</li>
  <li><strong>Napojenie.</strong> Sestra vás napojí na prístroj cez váš cievny prístup (viď nižšie).</li>
  <li><strong>Samotná dialýza.</strong> Liečba trvá spravidla <strong>4 až 5 hodín</strong>. Počas nej
      pohodlne sedíte alebo ležíte — môžete čítať, sledovať obrazovku, oddychovať či spať.</li>
  <li><strong>Sledovanie.</strong> Personál priebežne kontroluje váš krvný tlak a chod prístroja.</li>
  <li><strong>Odpojenie a kontrola.</strong> Na záver vás odpoja, ošetria prístup a znova odvážia.</li>
</ol>

<h2>Ako často a ako dlho</h2>

<p>Najčastejšie sa hemodialýza robí <strong>trikrát týždenne</strong>. Presný režim (dĺžku a frekvenciu)
vám určí lekár podľa vášho stavu. Časť pacientov môže byť vhodná aj na
<strong>hemodiafiltráciu (HDF)</strong>, ktorá z krvi odstráni viac odpadových látok.</p>

<h2>Cievny prístup</h2>

<p>Aby mohla krv prúdiť do prístroja a späť, potrebujete tzv. cievny prístup:</p>
<ul>
  <li><strong>Arteriovenózna fistula</strong> — spojenie tepny a žily, zvyčajne na predlaktí;
      je najtrvácnejšia voľba a vytvára sa s predstihom.</li>
  <li><strong>Cievny graft</strong> — umelé spojenie, ak fistula nie je možná.</li>
  <li><strong>Dialyzačný katéter</strong> — používa sa najmä dočasne alebo keď treba začať rýchlo.</li>
</ul>

<h2>Ako sa môžete cítiť</h2>

<p>Väčšina ľudí dialýzu dobre znáša. Niekedy sa môže objaviť únava alebo pokles krvného tlaku
počas liečby — preto je dôležité dodržiavať odporúčania o príjme tekutín a soli a hlásiť personálu,
ak sa necítite dobre. Po čase sa stáva dialýza súčasťou rutiny.</p>

<h2>Praktické tipy</h2>
<ul>
  <li>Noste pohodlné oblečenie s prístupom k miestu cievneho prístupu.</li>
  <li>Dodržiavajte odporúčaný pitný režim a stravu.</li>
  <li>Berte si lieky podľa pokynov a noste si ich zoznam.</li>
  <li>Pýtajte sa — personál vám rád vysvetlí všetko, čo vás zaujíma.</li>
</ul>

<h2>Kde poskytujeme hemodialýzu</h2>

<p>Hemodialýzu aj hemodiafiltráciu poskytuje <strong>Dialyzačné stredisko a nefrologická ambulancia
Medimpax</strong> v Bratislave-Dúbravke (Na vrátkach 2/A). Viac o stredisku a vybavení nájdete na
stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O vašej liečbe vždy rozhoduje ošetrujúci lekár.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, category, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, 'popularne', :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt),
        category = 'popularne', is_top = VALUES(is_top)"
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
                error_log('add_ako_prebieha_hemodialyza newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_ako_prebieha_hemodialyza pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_ako_prebieha_hemodialyza pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_ako_prebieha_hemodialyza migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia popularizačného článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
      <title>Migrácia popularizačného článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia popularizačného článku</h2>

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
            <a href="populars.php" class="btn-primary">← Späť na sekciu Pre pacientov</a>
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
