<?php
/**
 * add_anemia-ckd-dialyza-ambulancia-checklist_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_anemia-ckd-dialyza-ambulancia-checklist_article.php"
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
    'title'        => 'Checklist do praxe: Anémia pri CKD pre dialýzu aj ambulanciu',
    'slug'         => 'anemia-ckd-dialyza-ambulancia-checklist',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dva krátke checklisty pre anémiu pri CKD: verzia pre dialýzu (HD/PD) a verzia pre ambulanciu (non-HD). Obsahujú diagnostiku, hranice pre železo, FCM a fosfát, ESA/HIF-PHI, monitoring aj dokumentáciu pre audit.',
    'content'      => <<<'HTML'
<p>Tento článok je pripravený ako dvojica praktických checklistov na rýchle použitie v ambulancii aj na dialýze. Zmysel je rovnaký v oboch prostrediach: potvrdiť anémiu, zhodnotiť železo, rozlíšiť korigovateľné príčiny a potom bezpečne rozhodnúť o liečbe.</p>

<h2>Checklist do praxe A4: Anémia pri CKD pre dialýzu (HD/PD)</h2>

<p><strong>Záznam pacienta:</strong> [PACIENT] | <strong>Dátum:</strong> [DD.MM.RRRR] | <strong>Skupina:</strong> CKD G5D | <strong>Dialýza:</strong> HD/PD</p>
<p><strong>Lekár:</strong> [MENO/IDENT] | <strong>Cieľ:</strong> init / úprava / monitoring</p>

<h3>1) Potvrdenie a rýchle zhodnotenie</h3>
<ul>
  <li>☐ <strong>Hb</strong> a trend (dátumy): ____________</li>
  <li>☐ <strong>CBC</strong> (MCV, RDW) + <strong>retikulocyty</strong>: ____________</li>
  <li>☐ Symptómy a tolerancia záťaže: ____________</li>
  <li>☐ Zápal, infekcia, krvácanie, nutričný pokles: áno/nie + poznámka ____________</li>
  <li>☐ Ak výsledky nesedia s CKD anémiou, plán doplnenia diagnostiky: ____________</li>
</ul>

<h3>2) Železo ako priorita</h3>
<ul>
  <li>☐ <strong>Ferritín (ng/ml):</strong> ________</li>
  <li>☐ <strong>TSAT (%):</strong> ________</li>
  <li>☐ Kontext zápalu alebo iných faktorov ovplyvňujúcich indexy: ____________</li>
</ul>

<h3>3) Rozhodnutie o IV železe</h3>
<ul>
  <li>☐ Pri <strong>ferritín ≤ 500</strong> a <strong>TSAT ≤ 30</strong> zvážiť / indikovať IV železo: áno/nie</li>
  <li>☐ Stop sign: <strong>ferritín &gt; 700</strong> alebo <strong>TSAT ≥ 40</strong> → rutinné železo zadržať / neeskalovať: áno/nie</li>
  <li>☐ Typ IV železa a dávkovací plán: ____________</li>
  <li>☐ Plán kontrolných laboratórií: ____________</li>
</ul>

<h3>4) FCM a fosfát</h3>
<ul>
  <li>☐ Použitý prípravok: FCM / iné: ____________</li>
  <li>☐ Ak FCM, plán kontroly <strong>fosfátu</strong> podľa lokálneho protokolu a kliniky: áno/nie</li>
  <li>☐ Príznaky po podaní: slabosť, bolesti kostí, iné ____________</li>
  <li>☐ Ak sa objavia, okamžitá kontrola fosfátu a úprava plánu: áno/nie</li>
</ul>

<h3>5) ESA alebo HIF-PHI</h3>
<ul>
  <li>☐ Korektibilné príčiny vyriešené, najmä deficit železa: áno/nie</li>
  <li>☐ Zdieľané rozhodovanie s pacientom: áno/nie</li>
  <li>☐ Pri CKD G5D zvážiť ESA typicky pri <strong>Hb približne ≤ 9,0 až 10,0 g/dl</strong>: áno/nie</li>
  <li>☐ Pri udržiavaní držať Hb <strong>pod hornou hranicou ~11,5 g/dl</strong>: ____________</li>
  <li>☐ Voľba: ESA / HIF-PHI / zatiaľ nie + dôvod: ____________</li>
</ul>

<h3>6) Monitoring</h3>
<ul>
  <li>☐ Kontrola <strong>Hb, ferritín, TSAT</strong></li>
  <li>☐ Interval: <strong>1 až 3 mesiace</strong> (G5HD) alebo podľa lokálneho dialyzačného protokolu (G5PD)</li>
  <li>☐ Re-evaluácia pri zmene kliniky: infekcia, hospitalizácia, krvácanie, rýchly pokles Hb: áno/nie</li>
  <li>☐ Návrh ďalšej kontroly: [DD.MM.RRRR]</li>
</ul>

<h3>7) Dokumentácia pre audit</h3>
<ul>
  <li>☐ Dôvod, prečo železo áno/nie, vrátane prahov: ____________</li>
  <li>☐ Dôvod, prečo ESA/HIF-PHI áno/nie: ____________</li>
  <li>☐ Ak FCM, ako riešiš fosfát: ____________</li>
</ul>

<hr>

<h2>Checklist do praxe A4: Anémia pri CKD pre ambulanciu (non-HD)</h2>

<p><strong>Záznam pacienta:</strong> [PACIENT] | <strong>Dátum:</strong> [DD.MM.RRRR] | <strong>Skupina:</strong> CKD G__ (bez HD)</p>
<p><strong>Lekár:</strong> [MENO/IDENT] | <strong>Cieľ:</strong> init / úprava / monitoring</p>

<h3>1) Potvrdenie anémie a zhodnotenie rizík</h3>
<ul>
  <li>☐ <strong>Hb</strong> a trend (dátumy): ____________</li>
  <li>☐ <strong>CBC</strong> (MCV, RDW) + <strong>retikulocyty</strong>: ____________</li>
  <li>☐ Symptómy: únava, dyspnoe, intolerancia záťaže a funkčný dopad: ____________</li>
  <li>☐ Klinicky: infekcia/zápal, krvácanie, nutričné zhoršenie: áno/nie + poznámka ____________</li>
  <li>☐ Ak výsledky nesedia s CKD anémiou, plán doplnenia diagnostiky: ____________</li>
</ul>

<h3>2) Železo: panel a interpretácia</h3>
<ul>
  <li>☐ <strong>Ferritín (ng/ml):</strong> ________</li>
  <li>☐ <strong>TSAT (%):</strong> ________</li>
  <li>☐ Kontext zápalu: ____________</li>
</ul>

<h3>3) Rozhodnutie o železe</h3>
<ul>
  <li>☐ Preferovaný spôsob: perorálne / IV: ____________</li>
  <li>☐ Odôvodnenie: tolerancia, rýchlosť korekcie, dostupnosť/cena, laboratórny obraz: ____________</li>
  <li>☐ Pri iniciácii IV železa zohľadniť benefity a riziká: ____________</li>
</ul>

<h3>4) FCM a hypofosfatémia</h3>
<ul>
  <li>☐ Použitý prípravok (ak IV): FCM / iné: ____________</li>
  <li>☐ Ak IV zahŕňa FCM, plán kontrol <strong>fosfátu</strong> podľa rizika pacienta a režimu: ____________</li>
  <li>☐ Ak vzniknú príznaky kompatibilné s hypofosfatémiou, okamžitá kontrola fosfátu a úprava plánu: áno/nie</li>
</ul>

<h3>5) ESA alebo HIF-PHI</h3>
<ul>
  <li>☐ Korektibilné príčiny vyriešené, najmä deficit železa: áno/nie</li>
  <li>☐ Zdieľané rozhodovanie s pacientom: áno/nie</li>
  <li>☐ Zohľadnené riziká a benefit vrátane transfúzií: áno/nie</li>
  <li>☐ Iniciácia ESA v CKD bez dialýzy podľa symptómov, trendu Hb a rizík, nie len podľa čísla: ____________</li>
  <li>☐ Pri udržiavaní držať Hb <strong>pod hornou hranicou ~11,5 g/dl</strong>: ____________</li>
</ul>

<h3>6) Monitoring</h3>
<ul>
  <li>☐ Kontrola <strong>Hb, ferritín, TSAT</strong> každé <strong>3 mesiace</strong> alebo skôr pri zmene stavu: áno/nie</li>
  <li>☐ Návrh ďalšej kontroly: [DD.MM.RRRR]</li>
  <li>☐ Ak perorálne železo nefunguje alebo je netolerované do 1 až 3 mesiacov, prehodnotiť IV: áno/nie</li>
</ul>

<h3>7) Dokumentácia pre audit</h3>
<ul>
  <li>☐ Čo bolo vyšetrené a aké hodnoty: ____________</li>
  <li>☐ Prečo bola zvolená cesta železa a aké prahy/argumenty: ____________</li>
  <li>☐ Prečo ESA/HIF-PHI áno/nie: ____________</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> KDIGO 2026 a KDOQI US Commentary on the Management of Anemia in CKD. <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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