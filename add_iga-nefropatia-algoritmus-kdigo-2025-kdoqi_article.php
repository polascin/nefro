<?php
/**
 * add_iga-nefropatia-algoritmus-kdigo-2025-kdoqi_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_iga-nefropatia-algoritmus-kdigo-2025-kdoqi_article.php"
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
    'title'        => 'Praktická príloha: Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025 s ohľadom na KDOQI US Commentary',
    'slug'         => 'iga-nefropatia-algoritmus-kdigo-2025-kdoqi',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Jednostranový praktický algoritmus manažmentu IgA nefropatie podľa KDIGO 2025 a KDOQI US Commentary: kedy myslieť na biopsiu, ako nastaviť riziko, aké sú základné renoprotektívne kroky a ako sa rozhodovať medzi Nefeconom a systémovými kortikoidmi.',
    'content'      => <<<'HTML'
<p>Tento algoritmus je upravený do podoby stručnej praktickej prílohy na jednu stranu A4. Zmysel je jednoduchý: správne rozpoznať podozrenie na IgA nefropatiu, potvrdiť diagnózu biopsiou, odhadnúť riziko progresie a zvoliť liečbu, ktorá cieli na mechanizmy ochorenia a na spomalenie straty funkcie obličiek.</p>

<h2>0) Keď uvažovať o ďalšom kroku</h2>

<ul>
  <li>☐ Podozrenie na IgAN: perzistujúca hematuria a/alebo proteinúria u dospelého, po vylúčení bežných alternatívnych príčin.</li>
  <li>☐ Zásadné pravidlo: diagnózu IgAN potvrdzuje <strong>biopsia obličky</strong>.</li>
</ul>

<h2>1) Kedy poslať pacienta na biopsiu</h2>

<ul>
  <li>☐ Zvážiť biopsiu, ak dospelý má <strong>proteinúriu ≥ 0,5 g/deň</strong> alebo ekvivalent.</li>
  <li>☐ Biopsiu nepovažovať za „voliteľnú“, ak výsledok zásadne zmení liečbu a nie sú kontraindikácie.</li>
  <li>☐ Do dokumentácie uviesť: hematuriu a proteinúriu s kvantifikáciou, vylúčenie významnej alternatívy príčiny, eGFR a komorbidity relevantné pre riziko biopsie.</li>
</ul>

<h2>2) Po biopsii: ako nastaviť riziko a cieľ liečby</h2>

<ul>
  <li>☐ Po potvrdení IgAN určiť rizikovosť najmä podľa <strong>eGFR</strong> a <strong>proteinúrie</strong>; histologické parametre využiť podľa Oxford klasifikácie.</li>
  <li>☐ Cieľ liečby: znížiť proteinúriu čo najskôr a čo najviac, prakticky minimálne <strong>&lt; 0,5 g/deň</strong>, ideálne <strong>&lt; 0,3 g/deň</strong>, ak je to dosiahnuteľné.</li>
  <li>☐ Súčasne sledovať spomalenie poklesu eGFR, tlak krvi a kardiovaskulárne riziká.</li>
</ul>

<h2>3) Základ pre všetkých</h2>

<ul>
  <li>☐ Sodík <strong>&lt; 2 g/deň</strong>.</li>
  <li>☐ Zanechať fajčenie aj vaping.</li>
  <li>☐ Kontrola hmotnosti a aeróbna aktivita podľa tolerancie.</li>
  <li>☐ Cieľ tlaku krvi približne <strong>≤ 120/70 mm Hg</strong>, podľa individuálnej tolerancie.</li>
  <li>☐ Ak je indikovaná a tolerovaná, použiť <strong>blokádu RAS</strong> (ACEi/ARB).</li>
  <li>☐ Zvážiť <strong>SGLT2 inhibíciu</strong>, ak je pre pacienta indikovaná a realizovateľná.</li>
  <li>☐ Po týchto krokoch re-evaluovať proteinúriu trendom, nie jednorazovou hodnotou.</li>
</ul>

<h2>4) Ktorých pacientov liečiť cielenejšie</h2>

<ul>
  <li>☐ Špecifickú liečbu zvažovať pri vyššom riziku progresie, najmä pri pretrvávajúcej proteinúrii napriek základnej renoprotekcii.</li>
  <li>☐ Pri rozhodovaní zohľadniť eGFR, proteinúriu, histológiu, komorbidity a dostupnosť liečby.</li>
</ul>

<h2>5) Voľba špecifickej liečby</h2>

<h3>A) Ak je dostupný Nefecon</h3>

<ul>
  <li>☐ Zvážiť <strong>9-mesačný cyklus</strong> u rizikových pacientov podľa KDIGO.</li>
  <li>☐ Pacientovi vysvetliť, že hodnotí sa najmä dlhodobejší trend eGFR a proteinúrie, nie iba krátkodobá zmena po začiatku liečby.</li>
  <li>☐ Po vysadení môže pretrvávať len čiastočný „legacy effect“ na proteinúriu.</li>
</ul>

<h3>B) Ak Nefecon nie je dostupný</h3>

<ul>
  <li>☐ Zvážiť režim so <strong>zníženou dávkou systémových glukokortikoidov</strong> a s profylaxiou podľa rizika a lokálnych pravidiel.</li>
  <li>☐ Myslieť na infekčné riziko, gastroprotekciu a ochranu kostí podľa kontextu.</li>
  <li>☐ Pri voľbe liečby zohľadniť diabetes, latentné infekcie, stav kostí a dostupnosť lieku.</li>
</ul>

<h2>6) Monitorovanie liečby</h2>

<ul>
  <li>☐ Sledovať <strong>proteinúriu</strong> ako hlavný ukazovateľ účinku.</li>
  <li>☐ Sledovať <strong>eGFR</strong> a tlak krvi.</li>
  <li>☐ Pri kortikoidoch sledovať bezpečnostné parametre podľa rizika a zvoleného režimu.</li>
  <li>☐ Pri nečakanom alebo nekompatibilnom priebehu prehodnotiť adherenciu, základnú liečbu a diferenciálnu diagnostiku.</li>
</ul>

<h2>7) Praktická veta do dokumentácie</h2>

<p><em>„Pacient s IgA nefropatiou: diagnóza potvrdená biopsiou. Zavedené základné renoprotektívne opatrenia a ciele tlaku krvi. Pri riziku progresie zvolená cielenejšia liečba (Nefecon, ak je dostupný; inak znížené systémové steroidy s profylaxiou). Účinok hodnotím najmä podľa trendu proteinúrie a eGFR.“</em></p>

<hr>

<p><em><strong>Zdroj:</strong> KDOQI US Commentary on the KDIGO 2025 Clinical Practice Guideline for IgA Nephropathy and IgA Vasculitis (AJKD, full text). <a href="https://www.ajkd.org/article/S0272-6386(26)00842-5/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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