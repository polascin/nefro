<?php
/**
 * add_mrna-vakciny-funguju-sirsie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o širšom mechanizme účinku mRNA vakcín.
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'mRNA vakcíny zrejme fungujú širšie, než sme si doteraz mysleli',
    'slug'         => 'mrna-vakciny-funguju-sirsie-nez-sme-mysleli',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Nové experimentálne práce naznačujú, že mRNA vakcíny aktivujú imunitu širšie, než sa predpokladalo — okrem dendritických buniek sa zapájajú aj svalové bunky a mechanizmy cross-presentation a cross-dressing.',
    'content'      => <<<'HTML'
<p>Vedci dlhé roky predpokladali, že kľúčom účinku mRNA vakcín je ich vstup do dendritických buniek. Tieto bunky patria medzi hlavné „prezentátory" antigénu a dokážu účinne aktivovať T-lymfocyty. Nové experimentálne práce však naznačujú, že tento mechanizmus je zrejme širší a biologicky pestrejší.</p>

<p>Podľa článku publikovaného na Medscape, ktorý vychádza najmä zo štúdie v časopise <em>Nature Biotechnology</em>, môže mRNA vyvolať imunitnú odpoveď aj vtedy, keď sa jej expresia odohráva v bunkách, ktoré tradične nepovažujeme za imunitné. Významnú úlohu môžu mať napríklad svalové bunky.</p>

<h2>Prečo sú svalové bunky zaujímavé</h2>

<p>V experimentoch na myšiach vedci cielene vypínali expresiu mRNA v rôznych typoch buniek. Keď bola expresia vypnutá v svalových bunkách, T-bunková odpoveď sa znížila. To naznačuje, že svalové bunky sa na imunitnej odpovedi po mRNA vakcinácii môžu podieľať viac, než sa predpokladalo.</p>

<p>Naopak, keď bola expresia vypnutá v pečeňových bunkách, T-bunková odpoveď sa zvýšila. To môže znamenať, že pečeňové bunky v tomto kontexte skôr tlmia imunitnú aktiváciu. Vypnutie expresie v dendritických bunkách neodstránilo T-bunkovú aktiváciu, hoci pri niektorých antigénoch znížilo počet cytotoxických T-lymfocytov.</p>

<p>Dôležité je, že tieto výsledky neznamenajú, že dendritické bunky nie sú dôležité. Skôr ukazujú, že mRNA nemusí nutne vstúpiť priamo do dendritickej bunky, aby sa spustila imunitná odpoveď.</p>

<h2>Priama prezentácia, cross-presentation a cross-dressing</h2>

<p>Tradičný model predpokladal, že mRNA vstúpi do dendritickej bunky, tá podľa nej vytvorí antigén a následne ho prezentuje T-lymfocytom. Novšie údaje však naznačujú, že paralelne môžu prebiehať aj iné mechanizmy.</p>

<p>Jedným z nich je <strong>cross-presentation</strong>, pri ktorej dendritická bunka zachytí antigén vytvorený inou bunkou, spracuje ho a následne ho prezentuje imunitnému systému.</p>

<p>Ďalším mechanizmom je <strong>cross-dressing</strong>. Pri ňom neimunitná bunka, napríklad svalová bunka, spracuje antigén a naloží ho na vlastné MHC molekuly. Dendritická bunka potom môže tieto už pripravené komplexy prevziať a ukázať ich T-lymfocytom.</p>

<p>Podľa výskumníkov je pravdepodobné, že pri mRNA vakcínach neprebieha iba jeden mechanizmus. Skôr ide o kombináciu priamej prezentácie, cross-presentation a cross-dressingu. Inými slovami, imunitný systém využíva viacero ciest naraz.</p>

<h2>Prečo je to dôležité pre budúcu medicínu</h2>

<p>Lepšie pochopenie fungovania mRNA nie je len akademická otázka. Má praktický význam pre vývoj vakcín a liečebných postupov.</p>

<p>Pri onkologických mRNA vakcínach je cieľom čo najsilnejšie aktivovať cytotoxické CD8+ T-lymfocyty, ktoré dokážu rozpoznávať a ničiť nádorové bunky. Pri mRNA terapiách genetických ochorení je situácia opačná. Tam môže byť žiaduce imunitnú reakciu skôr potlačiť, aby organizmus nezničil bunky, ktoré majú byť liečebne upravené.</p>

<p>Ak teda budeme presnejšie vedieť, ktoré bunky mRNA prijímajú, ako spracúvajú antigén a akým spôsobom aktivujú T-lymfocyty, môže to viesť k cielenejším, účinnejším a bezpečnejším mRNA liečivám.</p>

<h2>Rozšírený pohľad na mRNA technológie</h2>

<p>Výskumy publikované v <em>Nature Biotechnology</em>, <em>Nature</em> a <em>Nature Communications</em> spoločne ukazujú, že spracovanie a prezentácia antigénov pri mRNA vakcínach je zložitejšia, než sa pôvodne predpokladalo. Nejde iba o jednoduchú cestu „mRNA vstúpi do dendritickej bunky a tá aktivuje imunitu".</p>

<p>mRNA platforma sa javí ako flexibilnejší biologický nástroj. Dokáže zapojiť rôzne typy buniek a rôzne mechanizmy imunitnej prezentácie. Práve táto variabilita môže byť jedným z dôvodov, prečo má mRNA technológia potenciál nielen vo vakcinológii, ale aj v onkológii, imunoterapii a liečbe genetických ochorení.</p>

<p>Zároveň treba dodať, že ide prevažne o experimentálne poznatky, najmä z myších modelov. Ich priamy klinický význam u ľudí bude potrebné ďalej overovať. Napriek tomu ide o dôležitý posun v chápaní jednej z najvýznamnejších biomedicínskych technológií súčasnosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „mRNA Works Differently Than We Thought and That's Good". <a href="https://www.medscape.com/viewarticle/mrna-works-differently-than-we-thought-and-s-good-2026a1000gzv" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
