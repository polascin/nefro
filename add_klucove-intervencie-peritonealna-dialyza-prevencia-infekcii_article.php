<?php
/**
 * add_klucove-intervencie-peritonealna-dialyza-prevencia-infekcii_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o prevencii infekcií v peritoneálnej
 * dialýze (na motívy podcastu ASN „Core Interventions for Peritoneal Dialysis“).
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
    'title'        => 'Kľúčové intervencie v peritoneálnej dialýze: prevencia infekcií ako spoločná zodpovednosť tímu',
    'slug'         => 'klucove-intervencie-peritonealna-dialyza-prevencia-infekcii',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Podcast American Society of Nephrology s Dr. Jeffreym Perlom o prevencii infekčných komplikácií pri peritoneálnej dialýze — peritonitídy aj infekcií katétra. Kľúčom je tímová spolupráca, edukácia pacienta, sledovanie trendov a kultúra kvality v každodennej starostlivosti.',
    'content'      => <<<'HTML'
<p>Peritoneálna dialýza patrí medzi dôležité formy náhrady funkcie obličiek. Pacientovi poskytuje väčšiu mieru samostatnosti, často umožňuje domácu liečbu a môže priaznivo ovplyvniť kvalitu života. Jej úspech však nestojí iba na technickom zvládnutí výkonu. Jedným z rozhodujúcich faktorov je prevencia infekcií.</p>

<p>Podcast American Society of Nephrology s názvom <strong>Core Interventions for Peritoneal Dialysis</strong> sa venuje práve tejto téme. Hosťom je <strong>Dr. Jeffrey Perl</strong>, ktorý spolu s moderátorom <strong>Dr. Tusharom Choprom</strong> diskutuje o stratégiách na znižovanie infekčných komplikácií pri peritoneálnej dialýze, o medzerách v klinickej praxi, trendoch infekcií a možnostiach zlepšenia prostredníctvom spolupráce a tímovej starostlivosti.</p>

<h2>Infekcie ako kľúčová komplikácia peritoneálnej dialýzy</h2>

<p>Infekčné komplikácie patria medzi najzávažnejšie problémy peritoneálnej dialýzy. Môžu viesť k hospitalizácii, zlyhaniu metódy, prechodu pacienta na hemodialýzu a v závažných prípadoch aj k ohrozeniu života. Najčastejšie sa v tejto súvislosti hovorí o peritonitíde, infekcii v mieste výstupu katétra a tunelovej infekcii.</p>

<p>Prevencia preto nemôže byť doplnkovou aktivitou. Musí byť základnou súčasťou programu peritoneálnej dialýzy. Zahŕňa správnu edukáciu pacienta, kvalitné zavedenie a ošetrovanie katétra, dodržiavanie aseptickej techniky, pravidelné preškoľovanie, sledovanie infekčných epizód a rýchlu reakciu na vzniknuté problémy.</p>

<h2>Medzery v praxi</h2>

<p>Podcast upozorňuje aj na rozdiely medzi odporúčaniami a každodennou klinickou realitou. V praxi sa môžu objavovať odchýlky v edukácii pacientov, v kontrole techniky výmen, v dokumentácii infekcií alebo v následnom hodnotení príčin infekčných epizód.</p>

<p>Problémom nemusí byť iba nedostatok vedomostí. Často ide o nejednotnosť postupov, rozdielnu kvalitu tímovej komunikácie alebo nedostatočné využívanie dostupných dát. Ak sa infekcia iba prelieči, ale neanalyzuje sa jej príčina, zvyšuje sa riziko opakovania rovnakej chyby.</p>

<h2>Význam trendov a spätnej väzby</h2>

<p>Sledovanie trendov infekcií má pre program peritoneálnej dialýzy praktický význam. Nestačí vedieť, že infekcie vznikajú. Dôležité je poznať ich frekvenciu, typ, pôvodcov, súvislosť s konkrétnymi postupmi a výsledok liečby.</p>

<p>Ak tím pravidelne vyhodnocuje vlastné dáta, vie lepšie identifikovať slabé miesta. Môže ísť napríklad o potrebu zmeniť edukačný proces, zlepšiť hygienické postupy, posilniť domácu podporu pacienta alebo upraviť systém kontrol. Dáta tak nie sú administratívnou záťažou, ale nástrojom zlepšovania kvality.</p>

<h2>Tímová starostlivosť ako základ úspechu</h2>

<p>Jedným z hlavných posolstiev diskusie je význam spolupráce. Prevencia infekcií nie je úlohou jedného lekára ani jednej sestry. Vyžaduje koordinovaný tímový prístup, v ktorom má svoje miesto nefrológ, dialyzačná sestra, chirurg alebo intervenčný špecialista, mikrobiológ, pacient a jeho rodina.</p>

<p>Pacient je pritom aktívnym členom tímu. Keďže peritoneálna dialýza často prebieha v domácom prostredí, kvalita edukácie a dôvera medzi pacientom a zdravotníckym tímom sú zásadné. Pacient musí vedieť nielen to, čo má robiť, ale aj prečo to robí a kedy má vyhľadať pomoc.</p>

<h2>Priestor na zlepšenie</h2>

<p>Podcast zdôrazňuje, že v prevencii infekcií stále existuje priestor na pokrok. Ten môže vzniknúť lepšou štandardizáciou postupov, systematickým auditom infekcií, dôslednejšou edukáciou, podporou pacientov a výmenou skúseností medzi pracoviskami.</p>

<p>Peritoneálna dialýza je efektívna metóda, ale jej bezpečnosť závisí od detailov. Každý krok, od výberu pacienta cez zavedenie katétra až po domáce výmeny, môže ovplyvniť riziko infekcie. Práve preto majú „core interventions“, teda základné intervencie, rozhodujúci význam.</p>

<h2>Záver</h2>

<p>Prevencia infekcií pri peritoneálnej dialýze nie je jednorazové školenie ani formálna súčasť dokumentácie. Je to kontinuálny proces, ktorý si vyžaduje kvalitný tím, aktívneho pacienta, sledovanie výsledkov a ochotu meniť prax podľa reálnych dát.</p>

<p>Diskusia s Dr. Jeffreym Perlom pripomína, že zlepšenie výsledkov v peritoneálnej dialýze nevzniká iba novými technológiami. Rovnako dôležité sú dôslednosť, spolupráca a kultúra kvality v každodennej starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> American Society of Nephrology, „Core Interventions for Peritoneal Dialysis“ (hosť: Jeffrey Perl, MD). <a href="https://www.asn-online.org/media/podcast.aspx?ID=650" target="_blank" rel="noopener noreferrer">asn-online.org</a></em></p>
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
