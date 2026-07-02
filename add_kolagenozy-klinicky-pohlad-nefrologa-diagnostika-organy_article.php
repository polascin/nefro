<?php
/**
 * add_TEMPLATE_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre vkladanie nového článku.
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   4. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE OBSAH:
 *   • title    – čistý text, bez HTML; zobrazí sa ako <h1> na stránke článku
 *   • slug     – len [a-z0-9-], max 80 znakov; musí byť unikátny v DB
 *                Diakritika → ASCII: á→a, č→c, š→s, ž→z, ľ→l, ô→o, ú→u …
 *   • excerpt  – 1–2 vety (max ~300 znakov), čistý text; zobrazuje sa v zozname
 *   • content  – HTML; NESMIE začínať <h2> zhodným s titulom (duplikát)
 *                Nadpisy sekcií → <h2>…</h2>
 *                Zoznam        → <ul>/<ol> + <li>
 *                Tučné         → <strong>, kurzíva → <em>
 *                Externé linky → <a href="…" target="_blank" rel="noopener noreferrer">
 *                Záver (zdroj) → <hr><p><em>Zdroj: …</em></p>
 *   • is_top   – 0 = bežný článok, 1 = odporúčaný (zobrazí sa vo featured sekcii)
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
    'title'        => 'Kolagenózy: praktický klinický pohľad nefrológa na diagnostiku, orgánové riziko a rozhodovanie o liečbe',
    'slug'         => 'kolagenozy-klinicky-pohlad-nefrologa-diagnostika-organy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Klinický pohľad nefrológa na kolagenózy: diagnostika ako posúdenie orgánového rizika (obličky, svaly), autoprotilátky ako smerovník a rozhodovanie o liečbe podľa rizika pre orgány.',
    'content'      => <<<'HTML'
<p>Pri kolagenózach sa v praxi často naráža na dve veci: diagnóza nie je „jednovstupová“ a priebeh vie byť orgánovo rizikový skôr, než sa klinický obraz jasne „zafarbí“ do jednej konkrétnej nozologickej jednotky. Už to, ako si reumatológ systematicky mapuje symptómy, laboratóriá, zobrazenie a funkciu orgánov, je podstatou diagnostického úspechu.</p>

<p>Streamed Up v kontexte RheumaLive pre Kollagenosen 2026 vystihuje, že ide o oblasť s výraznými <strong>diagnostickými aj terapeutickými výzvami</strong> naprieč rôznymi formami ochorení. Nižšie to zhrniem „operačne“, teda tak, aby sa to dalo použiť pri každodennom uvažovaní na ambulancii aj na internom oddelení.</p>

<h2>1) Diagnostika nie je pomenovanie. Diagnostika je posúdenie rizika pre orgány</h2>

<p>Kľúčový rozdiel medzi bežným nešpecifickým príznakom a kolagenózou je, že kolagenóza sa môže prejavovať rôzne a často sa mení v čase. Preto sa postup opiera o:</p>
<ul>
  <li>anamnézu a fyzikálne vyšetrenie zamerané na typické symptómy,</li>
  <li>laboratóriá doplnené o vyšetrenie funkcie postihnutých orgánov,</li>
  <li>zobrazovanie (napríklad ultrazvuk, RTG),</li>
  <li>a podľa potreby aj mikroskopické vyšetrenie tkaniva z biopsie, ak to zmení diagnostiku alebo terapiu.</li>
</ul>

<p>V tejto logike „správna diagnóza“ nie je cieľ, ale prostriedok. Cieľom je včas zachytiť, či už nejde o orgánové poškodenie a aký je potrebný stupeň urgentnosti.</p>

<h2>2) Najdôležitejšie „orgánové okná“ v každodennej práci</h2>

<h3>A) Obličky: ako spoznať prebiehajúcu nefritídu</h3>

<p>Pri systémovom lupus erythematosus treba v praxi počítať s možnosťou obličkového postihnutia. Rheuma-Liga uvádza, že zápal v tomto kontexte možno zachytiť vyšetrením moču a medzi prvé viditeľné varovania patria napríklad opuchy členkov pre zadržiavanie tekutín. Ak sa moč „pení“, môže to byť signál vysokého obsahu bielkovín a pacient by mal byť vyšetrený lekárom.</p>

<p>Praktické posolstvo: pri kolagenóze nepodceňuj moč ani zmeny hydratácie a edémy, lebo práve nefritída môže byť rozhodujúca pre prognózu.</p>

<h3>B) Svaly: keď dominuje slabosť, mysli na myozitídové spektrum</h3>

<p>Ak dominuje svalová slabosť, Rheuma-Liga spomína, že príčinou môže byť polymyozitída alebo dermatomyozitída. Typicky sa v laboratóriách hľadajú zvýšené svalové enzýmy. K diagnostike pomáha ultrazvuk svalov, včasné informácie môže priniesť aj MRI a v prípade potreby sa používa aj elektromyografia. Definitívny dôkaz zápalových procesov vo svale môže poskytnúť biopsia.</p>

<p>Praktické posolstvo: pri svalovej slabosti sa neopieraj iba o subjektívny dojem a jeden odber. Kombinuj kliniku, enzýmy a zobrazovanie a zisti, či ide o zápalové postihnutie s potenciálom odpovedať na imunosupresiu.</p>

<h2>3) Autoprotilátky: silný smerovník, nie náhrada kliniky</h2>

<p>Autoprotilátky môžu diagnózu výrazne urýchliť. Rheuma-Liga uvádza, že antinukleárne protilátky (ANA) sú pri kolagenózach typicky prítomné a bližšie určenie typu protilátok pomáha rozlíšiť jednotlivé kolagenózy.</p>

<p>Konkrétne príklady (ako rámec myslenia):</p>
<ul>
  <li>pri aktívnom systémovom lupus erythematosus sa môžu v krvi zisťovať protilátky proti dsDNA (anti-dsDNA),</li>
  <li>pri Sjögrenovom syndróme sa nájdu iné podskupiny ANA, napríklad anti-Ro a anti-La.</li>
</ul>

<p>Praktické posolstvo: ak protilátky „nesedia“ k fenotypu, neber výsledok ako hotovú diagnózu ani ako hotové vylúčenie. Je to signál, ktorý treba prepojiť s orgánovou klinikou a dynamikou.</p>

<h2>4) Terapeutická logika: liečiť podľa rizika orgánov, nie podľa subjektívneho dojmu</h2>

<p>Streamed Up zdôrazňuje, že pri Kollagenosen 2026 existujú diagnostické aj terapeutické výzvy. To v klinickom jazyku znamená, že liečba sa nedá nastaviť správne bez toho, aby si mal pod kontrolou:</p>
<ul>
  <li>čo je aktívne (zápalová aktivita),</li>
  <li>kde je aktívne (ktorý orgán je ohrozený),</li>
  <li>a aké je riziko rýchlej progresie.</li>
</ul>

<p>Inými slovami: rozdiel medzi „pacient má príznaky“ a „pacient má aktívne orgánové ohrozenie“ mení rýchlosť a intenzitu rozhodovania.</p>

<h2>5) Praktický algoritmus uvažovania v piatich krokoch (nejde o jediný možný postup)</h2>

<ol>
  <li><strong>Zmapuj fenotyp:</strong> symptómy a fyzikálne nálezy.</li>
  <li><strong>Zhodnoť orgány:</strong> moč, funkcie, svalová slabosť, dýchacie prejavy, neurologické znaky – podľa domény.</li>
  <li><strong>Doplň laboratóriá a zobrazovanie:</strong> cielene (nie všeobecne „čo vyjde“).</li>
  <li><strong>Interpretuj protilátky v kontexte:</strong> ANA a špecifické protilátky sú smerovník, nie rozsudok.</li>
  <li><strong>Ak otáznik mení manažment, zintenzívni diagnostiku:</strong> vrátane zvažovania mikroskopického vyšetrenia, ak je to naozaj rozhodujúce.</li>
</ol>

<h2>6) Záver</h2>

<p>Kolagenózy sú diagnosticky náročné práve preto, že sa prejavujú rôznorodo a často sa mení pomer medzi systémovými symptómami a orgánovým rizikom. Prakticky najviac pomáha orgánový prístup: kombinácia kliniky s funkciami orgánov, cielené laboratórne a zobrazovacie vyšetrenia a interpretácia autoprotilátok v kontexte pacienta. Keďže v tejto oblasti sú reálne diagnostické aj terapeutické výzvy, manažment treba viesť tak, aby chránil orgány včas.</p>

<hr>

<p><em><strong>Zdroj (podujatie):</strong> streamed-up.com, „Kollagenosen 2026“ (RheumaLive, 2026). <a href="https://streamed-up.com/live/kollagenosen-2026" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Zdroj (diagnostika kolagenóz):</strong> Rheuma-Liga, „Kollagenosen“. <a href="https://www.rheuma-liga.de/rheuma/krankheitsbilder/kollagenosen" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
