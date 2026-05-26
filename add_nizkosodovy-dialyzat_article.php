<?php
/**
 * add_nizkosodovy-dialyzat_article.php
 * Vkladá článok o nízkosodíkovom dialyzáte a sodíku v tkanivách (crossover štúdia).
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
    'title'        => 'Nízkosodíkový dialyzát a sodík v tkanivách: čo ukázala randomizovaná crossover štúdia',
    'slug'         => 'nizkosodikovy-dialyzat-a-sodik-v-tkanivach-randomizovana-crossover-studia',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-26',
    'is_top'       => 0,
    'excerpt'      => 'Randomizovaná crossover štúdia hodnotila vplyv nízkosodíkového dialyzátu (132 mEq/L sodíka) oproti vyššiosodíkovému (138 mEq/L) na tkanivový sodík (koža, sval) meraný pomocou ²³Na MRI. Celkové rozdiely neboli štatisticky významné, no upravené analýzy ukázali asociáciu s poklesom sodíka v koži a zdôraznili úlohu ultrafiltrácie.',
    'content'      => <<<'HTML'
<p>V udržiavacej hemodialýze sa dlho rieši otázka, či úprava koncentrácie sodíka v dialyzáte dokáže ovplyvniť sodík prítomný priamo v tkanivách. Zmysel tejto otázky je praktický: ak by sa podarilo znížiť „tkanivový" sodík, mohlo by to potenciálne súvisieť s klinickými prejavmi, ako je napríklad kožná hydratácia či systémový zápal. Nová randomizovaná crossover štúdia sa preto zamerala presne na rozdiely v sodíku medzi nízkosodíkovým a vyšším sodíkovým dialyzátom.</p>

<h2>Dizajn štúdie</h2>

<p>Štúdia mala randomizovaný crossover charakter. Pacientom v udržiavacej hemodialýze bol podávaný <strong>nízkosodíkový dialyzát: 132 mEq/L</strong> alebo <strong>vyššiosodíkový dialyzát: 138 mEq/L</strong>. Každé liečebné obdobie trvalo <strong>4 týždne</strong>. Tkanivový sodík sa hodnotil pomocou <strong><sup>23</sup>Na magnetickej rezonančnej tomografie (MRI)</strong> na konci každého obdobia. V randomizácii bolo zapojených <strong>28 účastníkov</strong>, pričom <strong>23 z nich poskytlo údaje pre crossover analýzu</strong> (obe fázy).</p>

<p>Sledovali sa dva „tkanivové kompartmenty":</p>
<ul>
  <li><strong>sodík v koži</strong></li>
  <li><strong>sodík vo svale</strong></li>
</ul>

<h2>Hlavné výsledky: celkové rozdiely neboli štatisticky významné</h2>

<p>Keď autori porovnali obdobie s vyšším sodíkovým dialyzátom ako referenciu, odhadli rozdiely pri nízkosodíkovom dialyzáte:</p>
<ul>
  <li>v <strong>svale</strong> bol odhadnutý rozdiel <strong>−0,8</strong> (tendencia k nižšiemu sodíku), štatistická významnosť však vyšla nepresvedčivo: <strong>p = 0,27</strong></li>
  <li>v <strong>koži</strong> bol odhadnutý rozdiel <strong>−1,5</strong>, opäť trend k nižším hodnotám, ale so skôr hraničným výsledkom: <strong>p = 0,09</strong></li>
</ul>

<p>Zjednodušene: <strong>neboli zistené štatisticky významné celkové rozdiely v sodíku v koži ani vo svaloch</strong>, aj keď oba kompartmenty pri nízkosodíkovom dialyzáte skôr klesali.</p>

<h2>Čo ukázali upravené analýzy: koža vs. sval sa „rozdvojili"</h2>

<p>Keď sa analýzy upravili o východiskové hodnoty tkanivového sodíka a <strong>rýchlosť ultrafiltrácie</strong>, obraz sa oddelil medzi kožou a svalom:</p>
<ul>
  <li><strong>Nízkosodíkový dialyzát bol spojený s poklesom sodíka v koži</strong>, ale</li>
  <li><strong>nebolo preukázané spojenie s poklesom sodíka vo svaloch</strong> v upravených modeloch.</li>
</ul>

<p>Zároveň sa ukázal výrazný faktor mimo dialyzátovej koncentrácie: <strong>vyššia rýchlosť ultrafiltrácie bola štatisticky významne spojená s nižším sodíkom v oboch kompartmentoch</strong> (v koži aj v svale). Výsledky naznačujú, že pri tkanivovom sodíku môže byť významná nielen koncentrácia sodíka v dialyzáte, ale aj to, <strong>ako intenzívne prebieha odstraňovanie tekutiny (ultrafiltrácia)</strong>.</p>

<h2>Zápalové a nutričné biomarkery: bez zjavného rozdielu</h2>

<p>Autori sledovali aj systémové ukazovatele – <strong>hsCRP (high-sensitivity C-reactive protein)</strong> a <strong>prealbumín</strong>. Medzi obdobím s nízkosodíkovým a vyšším sodíkovým dialyzátom <strong>nevykázali štatisticky významné rozdiely</strong>. To podporuje interpretáciu, že zmena dialyzátovej koncentrácie sama o sebe nemusela vyvolať jasný systémový efekt, aspoň v rámci daného časového horizontu štúdie.</p>

<h2>Bezpečnosť</h2>

<p>V období oboch dialyzačných režimov <strong>nebol hlásený žiadny závažný nežiaduci účinok súvisiaci so štúdiou</strong>. Bezpečnostný profil bol v oboch fázach podobný.</p>

<h2>Ako si to interpretovať pre prax</h2>

<p>Táto štúdia prináša tri prakticky zaujímavé posolstvá:</p>
<ol>
  <li><strong>Celkový efekt nízkosodíkového dialyzátu na tkanivový sodík</strong> (koža aj svaly) <strong>nebol štatisticky jednoznačný</strong> v primárnom porovnaní.</li>
  <li><strong>Po úprave na východiskové hodnoty a ultrafiltráciu</strong> sa ukázala <strong>aspoň čiastočná súvislosť</strong> s poklesom <strong>kožného</strong> sodíka.</li>
  <li><strong>Ultrafiltrácia</strong> sa javí ako faktor, ktorý môže ovplyvniť tkanivový sodík vo viac než jednom kompartmentu – to posúva pozornosť od samotného dialyzátu k celkovému nastaveniu liečby.</li>
</ol>

<p>Autori sami uvádzajú, že na definitívne zhodnotenie účinkov a najmä klinických dopadov budú potrebné <strong>väčšie štúdie</strong>.</p>

<h2>Obmedzenia</h2>

<ul>
  <li>Ide o <strong>crossover dizajn</strong>, čo je výhoda z hľadiska kontroly mätúcich faktorov, ale výsledky sú stále limitované počtom analyzovaných účastníkov (<strong>23 s údajmi pre obidve fázy</strong>).</li>
  <li>Hodnotila sa <strong>zmena sodíka v tkanive</strong>, ale štúdia neposkytuje dôkazy o tom, že by sa to priamo premietlo do konkrétnych klinických koncových bodov.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> ReachMD – <a href="https://reachmd.com/news/low-sodium-dialysate-trial-links-treatment-to-tissue-sodium-shifts/2487158/" target="_blank" rel="noopener noreferrer">Low-Sodium Dialysate Trial Links Treatment to Tissue Sodium Shifts</a>.</em></p>
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
