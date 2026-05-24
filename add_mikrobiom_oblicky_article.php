<?php
/**
 * add_mikrobiom_oblicky_article.php
 * Pridanie článku o mikrobiome čreva a zdraví obličiek (komentár k štúdii Lin et al., PMID 42020064)
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
    'title'        => 'Mikrobiom čreva a zdravie obličiek: čo prináša najväčšia doterajšia štúdia',
    'slug'         => 'mikrobiom-creva-a-zdravie-obliciek-najvacsia-doterajsia-studia',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Vzťah medzi črevným mikrobiomom a zdravím obličiek sa opakovane ukazuje ako významný. Nová prierezová štúdia – najväčšia doteraz – spája veľký súbor účastníkov, shotgun metagenomiku a sérovú metabolomiku, čo výrazne posúva kvalitu dôkazov v tejto oblasti.',
    'content'      => <<<'HTML'
<p>Vzťah medzi črevným mikrobiomom a zdravím obličiek sa v posledných rokoch opakovane ukazuje ako významný. Stále však ide často skôr o asociácie než o jasné príčiny, a preto je dôležité, čo presne prináša nová práca a aké má obmedzenia.</p>

<p>V komentári publikovanom v roku 2026 autori prezentujú výsledky najväčšej doteraz známej prierezovej (cross-sectional) štúdie skúmajúcej mikrobiom čreva a zdravie obličiek. Táto veľká štúdia podľa textu priniesla viaceré metodické posuny, ktoré zvyšujú kvalitu zistení: použitie veľmi rozsiahleho súboru účastníkov, prístup typu „discovery a validation", shotgun metagenomiku a integráciu údajov so sérovou metabolomikou.</p>

<h2>Prečo je to dôležité</h2>

<p>Komplexnosť vzťahu črevo–obličky súvisí s tým, že mikroorganizmy v čreve môžu ovplyvňovať metabolity, zápalové procesy a metabolickú rovnováhu. V praxi to znamená, že samotné zloženie mikrobiomu nemusí stačiť na pochopenie toho, čo sa v tele deje. Práve preto je významné, že štúdia spája viac úrovní údajov:</p>

<ul>
  <li><strong>shotgun metagenomika</strong> prináša detailnejší pohľad na genetický obsah mikrobiomu,</li>
  <li><strong>sérová metabolomika</strong> pridáva informáciu o tom, ako sa tieto biologické rozdiely môžu prejavovať v metabolickom profile človeka,</li>
  <li><strong>discovery a validation prístup</strong> pomáha overiť, že nálezy nie sú len náhodné v jednom súbore.</li>
</ul>

<p>Podľa komentára ide o „významný pokrok", pretože štúdia kombinuje veľkosť vzorky a viacúrovňovú analýzu spôsobom, ktorý posúva túto oblasť vpred.</p>

<h2>Hlavné obmedzenie: prierezová štúdia neukazuje časovú príčinu</h2>

<p>Zároveň je kľúčové, že ide o <strong>prierezový dizajn</strong>. To znamená, že zloženie mikrobiomu a stav súvisiaci s obličkami sa meria v rovnakom čase. Aj keď sa nájdu súvislosti, z takýchto dát sa nedá spoľahlivo určiť:</p>

<ul>
  <li>či zmena mikrobiomu vznikla ako dôsledok problémov s obličkami,</li>
  <li>alebo či mikrobiom skutočne predchádza zhoršovaniu funkcie obličiek,</li>
  <li>prípadne či ide o obojsmerný vzťah sprostredkovaný ďalšími faktormi.</li>
</ul>

<p>Autori preto výslovne zdôrazňujú potrebu štúdií so <strong>sledovaním v čase (prospektívny dizajn)</strong>, aby sa identifikovali „skutočné časové vzťahy" medzi mikrobiomom a zdravím obličiek.</p>

<h2>Ako si to preložiť do klinického pohľadu</h2>

<p>Pri dnešnej úrovni dôkazov je praktické uvažovať takto:</p>

<ol>
  <li><strong>Mikrobiom čreva je potenciálne relevantný</strong> pre zdravie obličiek a existujú presnejšie dôkazy, že nejde o úplne okrajovú hypotézu.</li>
  <li><strong>Zatiaľ však nemožno hovoriť o priamej kauzalite</strong> iba na základe prierezových údajov.</li>
  <li>Pre klinickú prax to znamená, že mikrobiom je skôr oblasťou výskumu a budovania rizikových modelov, nie istotou priameho liečebného pravidla „jedna intervencia, jeden efekt".</li>
</ol>

<p>Inými slovami: táto štúdia posilňuje biologickú aj analytickú dôveryhodnosť súvislosti, ale stále nám chýba ten rozhodujúci krok k pochopeniu príčiny v čase.</p>

<h2>Kam by mala smerovať ďalšia výskumná práca</h2>

<p>Podľa komentára je najdôležitejšie spraviť ďalší kvalitatívny posun: navrhnúť štúdie tak, aby bolo možné hodnotiť, či zmeny mikrobiomu predchádzajú zhoršeniu zdravotného stavu obličiek. V praxi to typicky znamená prospektívne kohorty a longitudinálne merania, prípadne dizajny, ktoré lepšie zachytia smerovanie vzťahu.</p>

<h2>Záver</h2>

<p>Najväčšia doterajšia prierezová štúdia o mikrobiome a zdraví obličiek prináša metodicky silné výsledky: veľký súbor, discovery a validation prístup, shotgun metagenomiku a prepojenie so sérovou metabolomikou. Je to dôležitý krok vpred. Zároveň však kvôli prierezovému dizajnu stále nevieme jednoznačne, čo je príčina a čo dôsledok. Budúcnosť patrí prospektívnym štúdiám, ktoré odhalia časové vzťahy.</p>

<hr>

<p><em><strong>Zdroj:</strong> PubMed, komentár k štúdii Lin et al. (PMID 42020064). <a href="https://pubmed.ncbi.nlm.nih.gov/42020064/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

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
                error_log('add_mikrobiom_oblicky_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_mikrobiom_oblicky_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: Mikrobiom čreva a zdravie obličiek\n";
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
      <title>Migrácia – Mikrobiom čreva a zdravie obličiek</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Mikrobiom čreva a zdravie obličiek</h2>

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
