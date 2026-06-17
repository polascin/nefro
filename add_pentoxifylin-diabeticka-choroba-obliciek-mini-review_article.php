<?php
/**
 * add_pentoxifylin-diabeticka-choroba-obliciek-mini-review_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_pentoxifylin-diabeticka-choroba-obliciek-mini-review_article.php"
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
    'title'        => 'Pentoxifylín v diabetickej chorobe obličiek: má dnes ešte miesto? (mini review AJKD)',
    'slug'         => 'pentoxifylin-diabeticka-choroba-obliciek-mini-review',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pentoxifylín (PTX) ako „re-purposed“ liek v diabetickej chorobe obličiek: biologické zdôvodnenie cez zápalové dráhy existuje, klinické signály sú najmä na úrovni albuminúrie/proteinúrie a poklesu eGFR, no dôkazy na tvrdé konce (ESKD, mortalita) zatiaľ chýbajú. Prehľad podľa mini review AJKD vrátane štúdií PREDIAN a prebiehajúcej VA PTXRx.',
    'content'      => <<<'HTML'
<p>Diabetická choroba obličiek (DKD, dnes často aj CKD spojené s diabetes mellitus 2. typu) ostáva aj napriek moderným „základným pilierom“ liečby významnou príčinou progresie do terminálneho zlyhania obličiek. Popri blokáde RAAS, inhibítoroch SGLT2, nesteroidných antagonistoch mineralokortikoidových receptorov a agonistoch GLP-1 sa skúšajú doplnkové cesty, najmä cez zápalové a oxidačné mechanizmy.</p>

<p>Tento článok AJKD sa venuje otázke, či má pentoxifylín (PTX) rolu v DKD ako „re-purposed“ liek, teda starší liek s potenciálne novým využitím.</p>

<h2>1) Prečo sa o pentoxifylíne v DKD vôbec uvažuje</h2>

<p>DKD nie je iba „hemodynamická“ glomerulopatia. V mechanizmoch progresie sa opakovane objavuje úloha zápalu: proinflamačné cytokíny (napr. TNF-α, IL-1, IL-6), oxidačný stres a signály vedúce k poškodeniu tubulointersticia a k fibróze. Intersticiálne makrofágy a cytokínové profily sa spájajú so zhoršovaním proteinúrie aj s poklesom funkcie.</p>

<p>PTX sa navrhuje práve ako protizápalová a antiproteinurická doplnková stratégia.</p>

<h2>2) Mechanizmus účinku PTX, ktorý dáva biologický zmysel</h2>

<p>PTX je nešpecifický inhibítor fosfodiesteráz, najmä PDE3 a PDE4, čo vedie k zvýšeniu intracelulárneho cAMP. Následná aktivácia PKA má tlmiť tvorbu zápalových cytokínov (IL-1, IL-6, TNF-α) a cez moduláciu signálnych dráh (vrátane osi NF-κB) nepriamo ovplyvňovať aj oxidačný stres a fibrózu.</p>

<h2>3) Čo ukazujú klinické dáta: väčšinou „surrogáty“, nie tvrdé konce</h2>

<p>V článku sa zdôrazňuje, že podporné štúdie boli často malé, krátke a primárne používali zástupné (surrogátne) ukazovatele: zníženie proteinúrie, zmeny eGFR, prípadne albuminúriu. Väčšina skúšaní nemala dostatočnú metodológiu na tvrdenie o dlhodobom klinickom benefite (ESKD alebo mortalita) a niektoré štúdie mali metodologické limity.</p>

<h3>Silnejšie zázemie: PREDIAN</h3>

<p>Najkonkrétnejšie je v texte rozobratá štúdia PREDIAN: PTX pridaný k blokáde RAAS znížil proteinúriu, znížil aj močové markery zápalu (TNF-α) a spomalil pokles eGFR. Zároveň sa zdôrazňuje, že:</p>

<ul>
  <li>rozdiel v poklese eGFR bol signifikantný,</li>
  <li>závažné nežiaduce udalosti neboli častejšie,</li>
  <li>častejšie boli najmä gastrointestinálne symptómy (dvojnásobný výskyt oproti placebu),</li>
  <li>štúdia však nebola dimenzovaná na „tvrdé“ výsledky ako ESKD a mortalita.</li>
</ul>

<h3>Pripravovaná odpoveď na otázku „funguje to klinicky“</h3>

<p>Relevantná je aj prebiehajúca pragmatická štúdia VA PTXRx (NCT03625648). Je randomizovaná, placebom kontrolovaná a jej cieľom je čas do ESKD alebo smrti. Ide o veľký, multicentrický pokus navrhnutý tak, aby odpovedal presne na to, čo nám dnes pri PTX chýba.</p>

<h2>4) Čo hovoria metaanalýzy</h2>

<p>Metaanalýzy naznačujú, že PTX môže znižovať albuminúriu/proteinúriu a priaznivo vplývať na niektoré renálne zástupné ukazovatele, a to bez signálu závažných nežiaducich účinkov. Článok však správne upozorňuje na typické riziká metaanalýz malých, rôznorodých a metodologicky slabších štúdií. Preto samotné metaanalýzy nie sú dostatočným dôvodom na zmenu praxe bez veľkej randomizovanej štúdie s tvrdými koncovými bodmi.</p>

<h2>5) Praktický záver pre nefrológa</h2>

<p>Z pohľadu prekladu do ambulantnej praxe (podľa toho, čo článok argumentuje) je PTX zatiaľ skôr kandidátom na doplnkovú terapiu než rutinným štandardom:</p>

<ul>
  <li><strong>biologické zdôvodnenie existuje</strong> (zápal a cytokínové osi),</li>
  <li><strong>klinické signály</strong> sú najčastejšie v oblasti albuminúrie/proteinúrie a rýchlosti poklesu eGFR,</li>
  <li><strong>chýbajú dôkazy o „tvrdom“ klinickom benefite</strong> v zmysle ESKD alebo mortality, kým sa neukážu výsledky veľkej štúdie.</li>
</ul>

<p>Ak sú pacienti už na moderných pilieroch liečby DKD, otázka PTX sa v praxi zužuje na: „máme legitímny dôvod pridávať ďalšiu liečbu mimo silných odporúčaní?“ Tento článok naznačuje, že odpoveď bude závisieť od preukázania benefitu v prebiehajúcej veľkej pragmatickej randomizovanej štúdii.</p>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD): „Is There a Role for Pentoxifylline in Diabetic Kidney Disease? A Mini Review“ (publikované online 20. marca 2026). <a href="https://www.ajkd.org/article/S0272-6386(26)00753-5/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
