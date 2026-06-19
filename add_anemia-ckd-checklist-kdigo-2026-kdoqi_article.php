<?php
/**
 * add_anemia-ckd-checklist-kdigo-2026-kdoqi_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_anemia-ckd-checklist-kdigo-2026-kdoqi_article.php"
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
    'title'        => 'Checklist do praxe: Anémia pri CKD podľa KDIGO 2026 a KDOQI US Commentary',
    'slug'         => 'anemia-ckd-checklist-kdigo-2026-kdoqi',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický checklist pre anémiu pri CKD podľa KDIGO 2026 a KDOQI US Commentary: potvrdenie anémie, základný laboratórny panel, hľadanie korektibilnej príčiny, rozhodovanie o železe, opatrnosť pri ferric carboxymaltose, ESA/HIF-PHI a auditovateľná dokumentácia.',
    'content'      => <<<'HTML'
<p>Tento checklist zhŕňa praktický postup pri anémii u pacientov s CKD podľa KDIGO 2026 a KDOQI US Commentary. Cieľ je jednoduchý: najprv potvrdiť anémiu, potom nájsť a korigovať príčinu, následne cielene riešiť železo a až potom zvažovať ESA alebo HIF-PHI.</p>

<h2>1) Potvrdenie a základné zhodnotenie</h2>

<ul>
  <li><strong>Potvrdiť anémiu:</strong> sledovať Hb a jeho trend, vrátane dátumu predchádzajúcich hodnôt.</li>
  <li><strong>Základný krvný obraz:</strong> CBC s Hb, MCV a RDW.</li>
  <li><strong>Retikulocyty:</strong> posúdiť produkčnú odpoveď kostnej drene.</li>
  <li><strong>Klinika:</strong> zhodnotiť únavu, dyspnoe a toleranciu záťaže.</li>
  <li><strong>Rýchly klinický screening:</strong> myslieť na infekciu, zápal, krvácanie a nutričný stav.</li>
</ul>

<p>Ak výsledky a klinika nesedia s typickou CKD anémiou, netreba sa uspokojiť s jedným vysvetlením. V praxi je dôležité myslieť aj na iné príčiny vrátane zápalu, krvácania a ďalších hematologických alebo nutričných faktorov.</p>

<h2>2) Železo: laboratórny profil</h2>

<ul>
  <li><strong>Ferritín</strong> ako základný ukazovateľ zásob železa.</li>
  <li><strong>TSAT</strong> ako ukazovateľ dostupnosti železa pre erytropoézu.</li>
  <li><strong>Interpretácia v kontexte zápalu:</strong> hodnoty čítať spolu s klinikou a zápalovým stavom, nie izolovane.</li>
</ul>

<h2>3) Hľadanie korektibilnej príčiny</h2>

<ul>
  <li>Ak obraz nesedí s CKD anémiou, uvažovať aj o <strong>nutričných príčinách</strong>.</li>
  <li>Podľa kliniky myslieť na <strong>hemolýzu</strong> a ďalšie hematologické príčiny.</li>
  <li>Pri podozrení na krvácanie plánovať vyšetrenie zdroja podľa lokálnych možností a odborných väzieb.</li>
</ul>

<p>Praktická pointa: anémia v CKD je často multifaktoriálna. Ak sa zameriame len na jedno číslo, ľahko prehliadneme korektibilnú príčinu, ktorú by bolo možné riešiť jednoduchšie než ESA eskaláciou.</p>

<h2>4) Rozhodnutie o železe</h2>

<h3>Hemodialýza (CKD G5HD)</h3>

<ul>
  <li>Pri kombinácii <strong>ferritín ≤ 500 ng/ml</strong> a <strong>TSAT ≤ 30 %</strong> je racionálne začať <strong>IV železo</strong>.</li>
  <li>Pri liečbe železom mať jasný <strong>stop sign</strong> pre bezpečnosť.</li>
  <li><strong>Rutinné železo zadržať</strong>, ak je <strong>ferritín &gt; 700 ng/ml</strong> alebo <strong>TSAT ≥ 40 %</strong>.</li>
</ul>

<h3>Non-HD CKD</h3>

<ul>
  <li>Zvoliť perorálne alebo IV železo podľa kombinácie ferritínu a TSAT.</li>
  <li>Voľbu individualizovať podľa kliniky, tolerancie, rýchlosti potreby korekcie a kontextu zápalu.</li>
</ul>

<h2>5) Špeciálne: ferric carboxymaltose a fosfát</h2>

<ul>
  <li>Pri použití <strong>ferric carboxymaltose (FCM)</strong> zvažovať monitoring <strong>fosfátu</strong>, najmä u rizikových pacientov alebo pri nových symptómoch.</li>
  <li>Ak sa objavia príznaky kompatibilné s hypofosfatémiou, doplniť <strong>fosfát</strong> a upraviť ďalší postup.</li>
</ul>

<p>Pri opakovaných dávkach je praktické mať fosfát v pláne sledovania vopred, nie až po rozvoji príznakov.</p>

<h2>6) Rozhodnutie o ESA a HIF-PHI</h2>

<ul>
  <li>Pred nasadením ESA alebo HIF-PHI treba mať riešené korektibilné príčiny, najmä deficit železa.</li>
  <li>Rozhodnutie má byť <strong>zdieľané s pacientom</strong> a má zohľadniť benefit, riziká aj riziko transfúzie.</li>
  <li>Pri CKD G5D sa ESA typicky zvažuje pri <strong>Hb približne ≤ 9,0 až 10,0 g/dl</strong> podľa symptómov a trendu.</li>
  <li>Pri udržiavaní liečby držať Hb <strong>pod hornou hranicou približne 11,5 g/dl</strong>.</li>
</ul>

<p>V tomto bode je podstatné nehodnotiť len samotnú laboratórnu hodnotu, ale aj symptómy, komorbidity a bezpečnostný profil terapie.</p>

<h2>7) Monitoring a intervaly</h2>

<ul>
  <li><strong>Hb, ferritín, TSAT</strong> kontrolovať pravidelne podľa typu CKD.</li>
  <li>Pri CKD bez dialýzy a CKD G5PD: <strong>každé 3 mesiace</strong>.</li>
  <li>Pri CKD G5HD: <strong>každých 1 až 3 mesiace</strong>.</li>
  <li>Pri zmene klinického stavu plán revidovať, najmä pri infekcii, krvácaní, hospitalizácii alebo zhoršení výživy.</li>
</ul>

<h2>8) Dokumentácia pre spätný audit</h2>

<ul>
  <li>Zapísať aktuálne hodnoty: Hb, ferritín, TSAT a podľa potreby aj retikulocyty.</li>
  <li>Uviesť interpretáciu a dôvod zvoleného postupu.</li>
  <li>Dokumentovať hranice a odôvodnenie pri začatí alebo zadržaní železa.</li>
  <li>Uviesť cieľ Hb a plán monitorovania.</li>
  <li>Ak sa použilo FCM, zapísať dôvod voľby a plán sledovania fosfátu, najmä pri opakovaných dávkach.</li>
</ul>

<h2>Záver</h2>

<p>Checklistový prístup je v anémii pri CKD najpraktickejší: najprv potvrdiť problém, potom hľadať korektibilnú príčinu, následne nastaviť železo s jasnými hranicami bezpečnosti a až potom zvažovať ESA alebo HIF-PHI. Takýto postup je čitateľný, auditovateľný a v praxi menej náchylný na chybné skratky.</p>

<hr>

<p><em><strong>Zdroj:</strong> KDIGO 2026 klinická smernica pre manažment anémie v CKD a KDOQI US Commentary. <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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