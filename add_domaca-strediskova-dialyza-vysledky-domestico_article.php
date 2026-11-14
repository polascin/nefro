<?php
// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Domáca a stredisková dialýza v kohorte DOMESTICO',
    'slug'         => 'domaca-strediskova-dialyza-vysledky-domestico',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Čo ukázalo porovnanie kvality života, hospitalizácií a mortality pri domácej dialýze a strediskovej hemodialýze v kohorte DOMESTICO?',
    'content'      => <<<'HTML'
<figure><a href="img/domaca-strediskova-dialyza-vysledky-domestico.webp" target="_blank" rel="noopener noreferrer"><img src="img/domaca-strediskova-dialyza-vysledky-domestico.webp" alt="Domáce a strediskové prostredie pri dialýze" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Domáce a strediskové prostredie pri dialýze. Ilustračný obrázok.</figcaption></figure>
<p>V holandsko-belgickej kohorte DOMESTICO sa počas prvých troch rokov po začatí dialýzy nepreukázal rozdiel v kvalite života, záťaži príznakmi ani v riziku prvej hospitalizácie medzi domácou dialýzou a strediskovou hemodialýzou. V domácej skupine však výrazne prevažovala peritoneálna dialýza. Výsledok o mortalite po troch rokoch sa menil podľa použitej analýzy. [1]</p>
<h2>Koho porovnali</h2>
<p>Do multicentrickej observačnej štúdie zaradili 2 110 pacientov začínajúcich dialýzu. Doma začínalo 542 pacientov, z toho 536 na peritoneálnej dialýze a šesť na domácej hemodialýze. Strediskovú hemodialýzu začalo 1 568 pacientov. Autori usporiadali analýzu podľa vopred vymedzeného porovnania, ktoré by skúšali v hypotetickej randomizovanej štúdii, a použili marginálne štrukturálne modely. Štatistická úprava vyvažuje merané rozdiely, ale neodstraňuje vplyv neúplne zachytených faktorov, napríklad krehkosti alebo dostupnosti pomoci doma. [1]</p>
<h2>Kvalita života, hospitalizácia a mortalita</h2>
<p>Primárne ukazovatele vychádzali z hodnotenia kvality života súvisiacej so zdravím a dialyzačných príznakov samotnými pacientmi. V ich priebehu sa významný rozdiel nezistil. Podobne dopadlo porovnanie prvej hospitalizácie. Chýbajúce dotazníky pribúdali a z analýzy hospitalizácií vylúčili pacientov bez údajov pre predčasné ukončenie sledovania v prvých troch mesiacoch. To mohlo ovplyvniť odhad hospitalizácií. [1]</p>
<p>V prvých dvoch rokoch sa rozdiel v celkovej mortalite nepreukázal. V hlavnej analýze po troch rokoch bol pomer hazardov úmrtia pri domácej dialýze oproti strediskovej hemodialýze 1,77 (95 % interval spoľahlivosti 1,08 až 2,92). Analýzy citlivosti tento výsledok nepotvrdili. Odhad preto nestačí na záver o vyššej mortalite pri domácej dialýze. Štúdia zároveň nebola skúškou rovnocennosti. [1]</p>
<h2>Ako výsledok využiť pri voľbe modality</h2>
<p>Pri poradenstve možno výsledok použiť najmä pri rozhovore o peritoneálnej dialýze a strediskovej hemodialýze. Šesť pacientov, ktorí začínali domácu hemodialýzu, neposkytuje dostatočný podklad na samostatný záver o tejto modalite. Pri voľbe liečby má význam prebrať s pacientom a jeho blízkymi, koľko pomoci je doma dostupnej, čo preňho znamená dochádzanie do strediska a ako sa jednotlivé možnosti dajú zladiť s jeho každodenným životom. [1]</p>
<hr><h2>Zdroje</h2><ol>
<li><small><em>Esmee Driehuis, Thomas S. van Lieshout, Anna A. Bonenkamp, Anita van Eck van der Sluijs, Roemer J. Janse, Emiel W. G. de Bruin, Marc A. G. J. ten Dam, Marc H. Hemmelder, Karen Prantl, Frans J. van Ittersum, Marianne C. Verhaar, Friedo W. Dekker, Brigit C. van Jaarsveld, Alferso C. Abrahams, the DOMESTICO study group. The effect of home versus in-centre dialysis on patient-reported and clinical outcomes: a target trial emulation study. Clin Kidney J. Online 27. októbra 2026. sfag385. <a href="https://doi.org/10.1093/ckj/sfag385" target="_blank" rel="noopener noreferrer">DOI a plný text</a>.</em></small></li>
<li><small><em>Medscape News UK. Home and In-Centre Dialysis Show Comparable Outcomes. 5. novembra 2026. <a href="https://www.medscape.com/viewarticle/home-and-centre-dialysis-show-comparable-outcomes-2026a10015rj" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li></ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_domaca-strediskova-dialyza-vysledky-domestico_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
