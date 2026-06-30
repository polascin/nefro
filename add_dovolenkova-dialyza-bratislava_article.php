<?php
/**
 * add_dovolenkova-dialyza-bratislava_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * DRAFT popularizačného článku (sekcia „Pre pacientov" → populars.php) o
 * dovolenkovej / hosťovskej dialýze v Bratislave (podpora strediska Medimpax).
 *
 * ⚠ NEPUBLIKOVANÉ AUTOMATICKY. Spustenie tohto skriptu článok ZVEREJNÍ,
 *   vygeneruje PDF a ROZOŠLE newsletter avízo odberateľom. Najprv si obsah
 *   skontrolujte (je pod menom MUDr. Ľubomír Polaščín) a až potom spustite:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_dovolenkova-dialyza-bratislava_article.php"
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
    'title'        => 'Dovolenka na dialýze: ako si zariadiť hosťovskú dialýzu v Bratislave',
    'slug'         => 'dovolenkova-dialyza-bratislava',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Cestujete a potrebujete dialýzu mimo domáceho strediska? Vysvetľujeme, čo je hosťovská (dovolenková) dialýza, ako si ju vopred zariadiť a čo si pripraviť.',
    'content'      => <<<'HTML'
<figure>
  <img src="img/impax.png" alt="Dialyzačné stredisko Medimpax v Bratislave-Dúbravke, kde je možná hosťovská dialýza" loading="lazy" decoding="async">
  <figcaption>Dialyzačné stredisko Medimpax, Na vrátkach 2/A, Bratislava-Dúbravka.</figcaption>
</figure>

<p>Dialýza nemusí znamenať koniec cestovania. Ak ste v pravidelnom hemodialyzačnom programe,
môžete absolvovať liečbu aj počas dovolenky alebo pracovnej cesty — v inom stredisku, než je to
vaše domovské. Hovorí sa tomu <strong>hosťovská</strong> alebo <strong>dovolenková dialýza</strong>.
V tomto článku zrozumiteľne vysvetlíme, ako si ju zariadiť.</p>

<h2>Čo je hosťovská (dovolenková) dialýza</h2>

<p>Je to bežná dialyzačná liečba (hemodialýza alebo hemodiafiltrácia), ktorú absolvujete
v stredisku v mieste vášho pobytu namiesto domovského pracoviska. Pokračujete vo svojom
zaužívanom režime — spravidla trikrát týždenne — len na inom mieste. Dôležité je dohodnúť sa
<strong>vopred</strong>, pretože každé stredisko má obmedzený počet voľných miest.</p>

<h2>Ako si ju zariadiť — krok za krokom</h2>

<ol>
  <li><strong>Ozvite sa s dostatočným predstihom.</strong> Ideálne niekoľko týždňov pred cestou —
      kapacita býva obmedzená, najmä v letných mesiacoch.</li>
  <li><strong>Dohodnite termíny.</strong> So strediskom si potvrďte konkrétne dni a časy dialýz
      počas vášho pobytu.</li>
  <li><strong>Zabezpečte zdravotnú dokumentáciu.</strong> Vaše domovské stredisko pripraví výpis
      s dialyzačným predpisom a aktuálnymi výsledkami (viď zoznam nižšie).</li>
  <li><strong>Overte si úhradu.</strong> Pri poistencoch slovenských zdravotných poisťovní je liečba
      hradená; pri zahraničných pacientoch sa vopred informujte o spôsobe úhrady a potrebných
      dokladoch (napr. európsky preukaz poistenca).</li>
  <li><strong>Doneste si lieky.</strong> Na celý pobyt si pripravte svoju obvyklú medikáciu.</li>
</ol>

<h2>Čo si pripraviť a priniesť</h2>

<ul>
  <li>výpis z dokumentácie s <strong>dialyzačným predpisom</strong> (dĺžka a frekvencia dialýz,
      typ dialyzátora, antikoagulácia, suchá hmotnosť);</li>
  <li>aktuálne <strong>laboratórne výsledky</strong> a sérologický status (HBV, HCV, HIV);</li>
  <li>informácie o vašom <strong>cievnom prístupe</strong> (fistula, graft alebo katéter);</li>
  <li>zoznam <strong>liekov</strong> a prípadných alergií;</li>
  <li>preukaz poistenca (pri zahraničných pacientoch aj doklad o poistení).</li>
</ul>

<h2>Hosťovská dialýza v Bratislave</h2>

<p>Ak smerujete do Bratislavy, hosťovskú hemodialýzu aj hemodiafiltráciu poskytuje
<strong>Dialyzačné stredisko a nefrologická ambulancia Medimpax</strong> v Bratislave-Dúbravke
(Na vrátkach 2/A). Vybavenie po dohode závisí od voľnej kapacity, preto sa ozvite vopred.</p>

<ul>
  <li>Dialyzačná sála: <a href="tel:+421947900202">0947 900 202</a></li>
  <li>Nefrologická ambulancia: <a href="tel:+421940609480">0940 609 480</a></li>
  <li>E-mail: <a href="mailto:medimpax@impax.sk">medimpax@impax.sk</a></li>
</ul>

<p>Viac o stredisku, službách a vybavení nájdete na stránke
<a href="dialyza-bratislava.php">Dialyzačné stredisko Bratislava</a>.</p>

<hr>

<p><em>Tento článok má informatívny charakter a nenahrádza odporúčania vášho ošetrujúceho lekára.
O vhodnosti a podmienkach hosťovskej dialýzy vždy rozhoduje lekár v spolupráci s vaším domovským
strediskom.</em></p>
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
                error_log('add_dovolenkova_dialyza newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_dovolenkova_dialyza pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_dovolenkova_dialyza pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_dovolenkova_dialyza migration error: ' . $e->getMessage());
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
