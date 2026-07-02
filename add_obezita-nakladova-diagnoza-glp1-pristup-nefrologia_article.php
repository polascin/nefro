<?php
/**
 * add_obezita-nakladova-diagnoza-glp1-pristup-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_obezita-nakladova-diagnoza-glp1-pristup-nefrologia_article.php"
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
    'title'        => 'Obezita ako zdravotnícka „nákladová“ diagnóza: čo znamená pre prístup k GLP-1 liečbe a nepriamo aj pre nefrológiu',
    'slug'         => 'obezita-nakladova-diagnoza-glp1-pristup-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Amy Faith Ho na Medscape rozoberá dilemu, či má Medicare platiť za obezitu ako za prevenciu (liekmi GLP-1), alebo naďalej za jej neskoršie následky. Model BALANCE a dočasný program GLP-1 Bridge ukazujú, prečo je nestabilná dostupnosť liečby aj nefrologickým problémom — dotýka sa CKD a kardiometabolického rizika.',
    'content'      => <<<'HTML'
<p>Obezita sa v systémoch zdravotnej starostlivosti čoraz častejšie posudzuje aj cez optiku nákladov — nielen ako klinická diagnóza, ale ako položka, ktorá generuje ďalšie a ďalšie výdavky. Článok na Medscape od Amy Faith Ho (MD, MPH) rozoberá dilemu, či má systém platiť za obezitu ako za prevenciu (drahými liekmi zo skupiny GLP-1), alebo bude aj naďalej hradiť najmä jej neskoršie následky. Hoci ide o americkú zdravotnú politiku (Medicare a Medicaid), otázka má priamy dosah aj na nefrológiu.</p>

<h2>Prečo by sa nefrológ mal zaujímať</h2>

<p>Obezita nie je len „metabolický problém“. Je to dlhodobý spúšťač hypertenzie, diabetu 2. typu, dyslipidémie, spánkového apnoe a systémového zápalu. V nefrológii sa tieto súvislosti neskôr často prejavia rýchlejšou progresiou chronického ochorenia obličiek (CKD), vyšším kardiovaskulárnym rizikom a väčším počtom pacientov na dialýze. Rozhodnutia o úhrade a dostupnosti účinnej liečby preto nie sú iba otázkou „zdravotníckej politiky“, ale reálnymi klinickými premennými.</p>

<p>Autorka sa venuje dileme, či Medicare bude aj v budúcnosti platiť za obezitu ako za prevenciu, alebo bude naďalej hradiť predovšetkým to, na čo sa obezita neskôr pretaví. Kľúčovým bodom je plán BALANCE a následné zmeny okolo tzv. programu Medicare GLP-1 Bridge.</p>

<h2>Prevencia verzus manažment neskorších následkov</h2>

<p>Článok opisuje model BALANCE ako snahu presunúť logiku systému od platenia „za chorobu až následne“ k plateniu „za prevenciu“ prostredníctvom drahých liekov (GLP-1). Model bol podľa textu koncipovaný tak, aby sa terapeutický liek kombinoval so sprievodnou behaviorálnou podporou, pričom časť implementácie mala prebiehať postupne — najprv v programe Medicaid a potom v Medicare.</p>

<p>Pred spustením v Medicare však došlo k posunu: dočasný program Bridge sa predĺžil a trvalé riešenie zostalo nejasné. Z praktického hľadiska to znamená, že časový horizont dostupnosti liekov je pre časť pacientov kratší a neistý.</p>

<h2>Medicare GLP-1 Bridge: čo je podstatné pre prax (a pre pacienta)</h2>

<p>Text pracuje s myšlienkou, že počas „mostíkového“ (bridge) obdobia môžu niektorí poistenci s obezitou ako kvalifikačnou diagnózou získať vybrané lieky zo skupiny GLP-1 za zníženú mesačnú úhradu. Autorka zároveň zdôrazňuje, že ide o provizórny režim s obmedzenou dobou platnosti a že po jeho skončení sa zásadná otázka skôr odkladá, než rieši.</p>

<p>Pre nefrológa je z toho relevantné najmä toto:</p>

<ul>
  <li>liečba obezity (GLP-1) môže byť pre CKD a kardiometabolické riziko nepriamo „časovo citlivá“,</li>
  <li>ak je dostupnosť nestabilná, zhoršuje sa adherencia aj dlhodobý prínos,</li>
  <li>v praxi potom často narážame na to, že pacient liečbu začne, no následne nastane prekážka v jej pokračovaní.</li>
</ul>

<p>Pri rozhodovaní o konkrétnom pacientovi sa preto oplatí mať pripravený plán: zdokumentovať indikáciu a očakávaný prínos pre kardiometabolický profil aj renálne riziko a včas riešiť administratívne i logistické prekážky.</p>

<h2>„Zaplatiť teraz, alebo zaplatiť neskôr“ nie je slogan, ale predikcia klinickej reality</h2>

<p>Autorka stavia argumentáciu na jednoduchom kompromise: buď systém investuje do liečby obezity teraz, alebo zaplatí neskôr — za infarkt, zlyhanie srdca, dialýzu, endoprotézy a ďalšie nákladné následky.</p>

<p>V texte sú uvedené aj odhady úspor a dodatočných nákladov v horizonte niekoľkých rokov (z rôznych inštitúcií). Berme ich ako orientačné čísla, pretože skutočné výsledky závisia od:</p>

<ul>
  <li>reálnej miery adherencie,</li>
  <li>podielu pacientov, ktorí liek dostanú a udržia dlhodobo,</li>
  <li>štruktúry populácie (komorbidity, štádiá CKD, diabetes),</li>
  <li>a od toho, ako presne sa v modeloch definujú „kompenzácie“ (offsety) nákladov.</li>
</ul>

<h2>Čo by mali odborníci komunikovať pacientom aj systému</h2>

<p>Z článku pre mňa vychádzajú tri jasné body:</p>

<ol>
  <li><strong>Obezita je chronické ochorenie s merateľným rizikom pre obličky.</strong> Pacientovi to zrozumiteľne vysvetlime ako „investíciu do budúcnosti obličiek“, nie iba do hmotnosti.</li>
  <li><strong>Neistota úhrady je klinický problém, nie administratívna drobnosť.</strong> Pri pacientoch s CKD, diabetom a vysokým kardiovaskulárnym rizikom môže nestabilný prístup zhoršiť dlhodobé výsledky.</li>
  <li><strong>Ak má pacient prístup k liečbe, kľúčové je myslieť na kontinuitu.</strong> Aj keď článok rieši zdravotnú politiku, prakticky to znamená včas plánovať pokračovanie liečby, sledovať toleranciu a metabolické parametre a dokumentovať odpoveď.</li>
</ol>

<h2>Poznámka na záver</h2>

<p>Ide o politicko-zdravotnícky materiál, ktorý sa môže meniť. Pri riešení konkrétnej dostupnosti pre pacienta v danom období odporúčam overiť aktuálne podmienky v primárnych zdrojoch (CMS a príslušné dokumenty k úhrade).</p>

<hr>

<p><em><strong>Zdroj:</strong> Amy Faith Ho, <em>Obesity Dilemma: Pay Now or Pay for What It Becomes Later</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/obesity-dilemma-pay-now-or-pay-what-it-becomes-later-2026a1000lo1" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
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

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
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
