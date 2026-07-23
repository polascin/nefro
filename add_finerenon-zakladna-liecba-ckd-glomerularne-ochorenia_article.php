<?php
/**
 * add_finerenon-zakladna-liecba-ckd-glomerularne-ochorenia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_finerenon-zakladna-liecba-ckd-glomerularne-ochorenia_article.php"
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
    'title'        => 'Finerenón: potenciál ako základná liečba pri CKD aj bez diabetu a pri glomerulárnych ochoreniach',
    'slug'         => 'finerenon-zakladna-liecba-ckd-glomerularne-ochorenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Výsledky viacerých veľkých štúdií (FIND-CKD, analýza pre glomerulárne ochorenia v JAMA a súhrnná analýza v The Lancet) naznačujú, že finerenón spomaľuje progresiu CKD a znižuje kardiovaskulárne riziko aj bez diabetu — pri disciplinovanom monitorovaní draslíka.',
    'content'      => <<<'HTML'
<p>Portál ScienceDaily prináša zhrnutie výsledkov z viacerých veľkých štúdií, v ktorých <strong>finerenón</strong> spomaľoval zhoršovanie funkcie obličiek a znižoval aj kardiovaskulárne riziko. Prínosy sa pozorovali nielen u pacientov s diabetom, ale aj pri <strong>nediabetickom CKD</strong> a v skupinách s <strong>glomerulárnymi ochoreniami</strong>.</p>

<h2>Kľúčové štúdie a výsledky</h2>

<h3>1) FIND-CKD: nediabetické CKD</h3>

<p>V štúdii <strong>FIND-CKD</strong> (1 584 účastníkov, 24 krajín) finerenón pridaný k štandardnej liečbe:</p>

<ul>
  <li><strong>spomalil pokles funkcie obličiek</strong>,</li>
  <li>znížil kombinovaný cieľ (<strong>zlyhanie obličiek, progresia CKD, srdcové zlyhanie alebo kardiovaskulárne úmrtie</strong>) o <strong>23 %</strong> oproti štandardnej starostlivosti.</li>
</ul>

<h3>2) Analýza pre glomerulárne ochorenia (JAMA)</h3>

<p>U účastníkov s glomerulárnymi ochoreniami finerenón:</p>

<ul>
  <li>znížil riziko <strong>zlyhania obličiek alebo progresie CKD</strong> o <strong>26 %</strong> oproti placebu,</li>
  <li>po <strong>12 mesiacoch</strong> znížil <strong>albuminúriu o 42 %</strong>.</li>
</ul>

<h3>3) Súhrnná analýza naprieč diabetickým aj nediabetickým CKD (The Lancet)</h3>

<p>Súhrnná (pooled) analýza zahrnula <strong>14 574 účastníkov</strong> a finerenón v nej:</p>

<ul>
  <li>znížil riziko <strong>zlyhania obličiek alebo progresie CKD</strong> o <strong>24 %</strong>,</li>
  <li>znížil riziko <strong>hospitalizácie pre srdcové zlyhanie alebo kardiovaskulárneho úmrtia</strong> o <strong>20 %</strong>,</li>
  <li>znížil riziko <strong>úmrtia z akejkoľvek príčiny</strong> o <strong>12 %</strong>.</li>
</ul>

<p>Autori uvádzajú, že tieto prínosy boli konzistentné bez ohľadu na prítomnosť diabetu, typ ochorenia obličiek a mieru zníženia funkcie.</p>

<h2>Bezpečnosť (draslík)</h2>

<p>Finerenón bol vo všeobecnosti <strong>dobre tolerovaný</strong>, no <strong>hyperkaliémia</strong> sa vyskytovala častejšie než pri placebe. Ukončenie liečby ani hospitalizácie pre hyperkaliémiu sa však uvádzajú ako <strong>nečasté</strong>.</p>

<p>V praxi to znamená, že aj pri širšom uvažovaní o indikácii treba dodržiavať disciplinované monitorovanie draslíka a renálnych parametrov.</p>

<h2>Praktické ponaučenie</h2>

<p>Tento zdroj podporuje myšlienku, že finerenón by mohol byť relevantný ako pevnejší pilier liečby CKD aj u pacientov, ktorí:</p>

<ul>
  <li><strong>nemajú diabetes</strong>,</li>
  <li>patria k <strong>glomerulárnym</strong> fenotypom,</li>
  <li>a zároveň majú <strong>klinicky významný renálny rizikový profil</strong>, pri ktorom možno očakávať prínos aj na albuminúrii a klinických cieľových ukazovateľoch.</li>
</ul>

<p>Zároveň si zachovajme realistickú zdržanlivosť: ide o výsledky zhrnuté v populárno-vedeckom článku, nie o úplné protokoly a štatistické detaily v jednej tabuľke. Pre webový článok ich stačí uviesť ako „výsledky viacerých štúdií s konzistentným smerovaním“, no pri zavádzaní u konkrétnych pacientov je rozumné riadiť sa lokálnymi odporúčaniami a schémou monitorovania draslíka.</p>

<hr>

<p><em><strong>Zdroj:</strong> ScienceDaily (6. jún 2026): „Finerenone May Benefit Far More Patients…“. <a href="https://www.sciencedaily.com/releases/2026/06/260606075513.htm" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
