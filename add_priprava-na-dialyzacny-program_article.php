<?php
/**
 * add_priprava-na-dialyzacny-program_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o
 * príprave na zaradenie do dialyzačného programu (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_priprava-na-dialyzacny-program_article.php"
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
    'title'        => 'Príprava na zaradenie do dialyzačného programu',
    'slug'         => 'priprava-na-dialyzacny-program',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kedy je dialýza potrebná, ako sa vyberá medzi hemodialýzou a peritoneálnou dialýzou, prečo treba myslieť na cievny prístup vopred a v čom pomáha poradňa pred dialýzou.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/medimpax.webp" alt="Nefrologická ambulancia a dialyzačné stredisko Medimpax v Bratislave-Dúbravke" loading="lazy" decoding="async">
  <figcaption>Nefrologická ambulancia a dialyzačné stredisko Medimpax, Bratislava-Dúbravka.</figcaption>
</figure>

<p>Ak vaše obličky postupne strácajú funkciu, lekár s vami môže začať hovoriť o príprave na dialýzu.
Dobrá správa je, že keď sa pripravíte <strong>s predstihom</strong>, prechod na dialýzu býva
oveľa pokojnejší. V tomto článku zhrnieme, čo vás čaká a ako sa pripraviť.</p>

<h2>Kedy je dialýza potrebná</h2>

<p>Dialýza prichádza na rad pri pokročilom chronickom ochorení obličiek, keď už nedokážu
dostatočne čistiť krv a odvádzať prebytočnú vodu. Presný čas určí lekár podľa vašich
laboratórnych výsledkov a príznakov — nie podľa jediného čísla, ale podľa celkového stavu.</p>

<h2>Výber metódy: hemodialýza alebo peritoneálna dialýza</h2>

<p>Existujú dve hlavné metódy a obe sú plnohodnotné. Voľba závisí od vášho zdravotného stavu,
životného štýlu aj preferencií:</p>
<ul>
  <li><strong>Hemodialýza (HD)</strong> — krv sa čistí cez prístroj, spravidla v stredisku
      trikrát týždenne.</li>
  <li><strong>Peritoneálna dialýza (PD)</strong> — prebieha doma cez brušnú dutinu; môže byť
      ručná (CAPD) alebo automatizovaná počas spánku (APD).</li>
</ul>
<p>O výhodách a vhodnosti jednotlivých metód sa porozprávajte s nefrológom — pomôže vám vybrať,
čo najlepšie sadne vášmu životu.</p>

<h2>Cievny prístup a PD katéter — myslite vopred</h2>

<p>Aby dialýza fungovala, treba si vopred pripraviť prístup:</p>
<ul>
  <li>pri hemodialýze najčastejšie <strong>arteriovenóznu fistulu</strong>, ktorá potrebuje čas,
      aby „dozrela" — preto sa zakladá s predstihom;</li>
  <li>pri peritoneálnej dialýze <strong>PD katéter</strong> v bruchu.</li>
</ul>
<p>Včasné plánovanie prístupu je jedným z najdôležitejších krokov hladkého štartu dialýzy.</p>

<h2>Poradňa pred dialýzou</h2>

<p>V nefrologickej ambulancii funguje <strong>poradňa pre prípravu na zaradenie do dialyzačného
programu</strong>. Pomôže vám zorientovať sa vo voľbe metódy, vysvetlí priebeh liečby, naplánuje
cievny prístup a sprevádza vás pri rozhodovaní — aby ste do dialýzy vstupovali informovane
a bez zbytočného stresu.</p>

<h2>Čo si pripraviť</h2>
<ul>
  <li>otázky, ktoré vás zaujímajú (pokojne si ich vopred zapíšte);</li>
  <li>zoznam liekov a prípadných alergií;</li>
  <li>informácie o vašom doterajšom priebehu ochorenia obličiek;</li>
  <li>podporu blízkej osoby — môže ísť s vami a pomôcť zapamätať si informácie.</li>
</ul>

<h2>Kde sa pripraviť a liečiť</h2>

<p>Preventívnu a klinickú nefrológiu, poradňu pred dialýzou aj samotnú dialyzačnú liečbu
(hemodialýza, hemodiafiltrácia aj peritoneálna dialýza) poskytuje
<strong>Dialyzačné stredisko a nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke.
Viac nájdete na stránke <a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odborné lekárske vyšetrenie ani
konzultáciu. O vhodnosti a načasovaní dialýzy aj o výbere metódy vždy rozhoduje ošetrujúci lekár.</em></p>
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
                error_log('add_priprava_dialyzacny_program newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_priprava_dialyzacny_program pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_priprava_dialyzacny_program pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_priprava_dialyzacny_program migration error: ' . $e->getMessage());
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
