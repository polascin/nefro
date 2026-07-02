<?php
/**
 * add_ckm-syndrom-prva-multidisciplinarna-smernica-2026_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ckm-syndrom-prva-multidisciplinarna-smernica-2026_article.php"
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
    'title'        => 'Nová multidisciplinárna CKM stratégia (AHA/ACC/ADA/ASN, 2026): prvá smernica pre kardiovaskulárno-obličkovo-metabolický syndróm',
    'slug'         => 'ckm-syndrom-prva-multidisciplinarna-smernica-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'AHA, ACC, ADA a ASN spoločne zverejnili prvú multidisciplinárnu smernicu pre kardiovaskulárno-obličkovo-metabolický (CKM) syndróm. Nahrádza rámec z roku 2013 a rozširuje ho do koncepcie, že obezita, diabetes 2. typu, CKD a kardiovaskulárne ochorenia tvoria jeden kontinuálny syndróm — s obličkou ako centrálnou súčasťou.',
    'content'      => <<<'HTML'
<p>Dňa 9. júna 2026 organizácie AHA, ACC, ADA a ASN spoločne zverejnili prvú multidisciplinárnu smernicu zameranú na kardiovaskulárno-obličkovo-metabolický syndróm (<em>cardiovascular-kidney-metabolic</em>, CKM). Dokument pôvodný rámec z roku 2013 podľa formulácie autorov „uzatvára, nahrádza a rozširuje“ — predovšetkým ho však posúva do koncepcie, že <strong>obezita, diabetes 2. typu, chronické ochorenie obličiek (CKD) a kardiovaskulárne ochorenia sú prepojené ako jeden kontinuálny syndróm</strong>.</p>

<h2>Čo je nové v praxi</h2>

<h3>1) Štandardizovaná klasifikácia štádií CKM (0 až 4)</h3>

<p>Smernica zavádza <strong>klasifikáciu štádií CKM od 0 do 4</strong>. Cieľom je identifikovať pacientov skôr, voliť terapie podľa <strong>absolútneho kardiovaskulárneho rizika</strong> a hodnotiť cielené intervencie aj z hľadiska spomalenia či regresie progresie do CKD a kardiovaskulárneho ochorenia (CVD).</p>

<h3>2) Riziko kvantifikovať jednotným nástrojom: PREVENT</h3>

<p>Pre pacientov v štádiách CKM 0 až 3 sa odporúča používať rovnice <strong>PREVENT</strong> na odhad <strong>10- a 30-ročného</strong> rizika aterosklerotického kardiovaskulárneho ochorenia (ASCVD), srdcového zlyhania a celkového kardiovaskulárneho rizika. Výstup z tohto výpočtu má pomôcť určiť intenzitu preventívnej liečby.</p>

<h3>3) Rutinné vyhľadávanie CKD: eGFR + UACR</h3>

<p>Pri skríningu sa majú pravidelne používať:</p>

<ul>
  <li><strong>eGFR</strong> — odhadovaná glomerulárna filtrácia (filtračná funkcia obličiek),</li>
  <li><strong>UACR</strong> — pomer albumín/kreatinín v moči (marker renálneho aj kardiovaskulárneho rizika).</li>
</ul>

<p>Nejde teda o postup „diagnóza CKD až dodatočne“, ale o aktívne vyhľadávanie a včasnú stratifikáciu rizika.</p>

<h3>4) Inhibítory SGLT2 a liečba na báze GLP-1 ako kľúčové CKM terapie</h3>

<p>Dôraz sa kladie na terapie, ktoré majú súčasne <strong>kardiovaskulárny aj renálny benefit</strong> — nielen glykemickú kontrolu. Explicitne sa uvádzajú:</p>

<ul>
  <li><strong>inhibítory SGLT2</strong>,</li>
  <li><strong>terapie na báze GLP-1</strong>.</li>
</ul>

<h3>5) Interdisciplinárny manažment a koordinátor starostlivosti</h3>

<p>Smernica odporúča koordinovaný prístup naprieč špecializáciami (všeobecný lekár, kardiológ, nefrológ, diabetológ) a zavádza princíp, že má existovať <strong>zodpovedná kontaktná osoba</strong> alebo koordinátor starostlivosti, aby sa terapie skutočne implementovali konzistentne.</p>

<h3>6) Obezita nie je doplnok, ale základ</h3>

<p>Pacient sa má hodnotiť nielen podľa BMI, ale aj podľa <strong>obvodu pása</strong>. Liečba vychádza z toho, že nadmerné množstvo tukového tkaniva je hlavným hnacím mechanizmom progresie CKM syndrómu. U vhodných pacientov sa zvažujú aj <strong>lieky proti obezite</strong> a <strong>metabolická (bariatrická) chirurgia</strong>.</p>

<h3>7) Sociálne determinanty zdravia ako súčasť klinickej praxe</h3>

<p>Zmyslom nie je len „spomenúť“ sociálne faktory, ale <strong>systematicky ich zisťovať</strong> a riešiť prekážky ako:</p>

<ul>
  <li>nedostatočná dostupnosť potravín,</li>
  <li>bariéry v prístupe k liečbe,</li>
  <li>nestabilné bývanie,</li>
  <li>doprava,</li>
  <li>a ďalšie socioekonomické obmedzenia.</li>
</ul>

<h2>Desať odporúčaní v skratke</h2>

<p>Smernica sa točí najmä okolo týchto okruhov:</p>

<ul>
  <li>rutinná klasifikácia štádií CKM,</li>
  <li>kvantifikácia kardiovaskulárneho rizika pomocou nástroja PREVENT,</li>
  <li>pravidelný skríning CKM rizík (vrátane cieľových stavov ako pre-heart failure, MASLD a obštrukčné spánkové apnoe — OSA),</li>
  <li>zahrnutie sociálnych determinantov zdravia do manažmentu,</li>
  <li>interdisciplinárna starostlivosť,</li>
  <li>obezita ako základná liečebná os,</li>
  <li>diabetologická liečba s preferenciou CKM benefitov (inhibítory SGLT2, GLP-1),</li>
  <li>aktívne identifikovanie a liečba CKD (eGFR + UACR, blokáda RAAS, inhibítory SGLT2 a pri pretrvávajúcej albuminúrii aj ďalšie triedy ako nesteroidové antagonisty mineralokortikoidných receptorov (nsMRA) alebo GLP-1 podľa kontextu),</li>
  <li>u pacientov s už prítomným ASCVD intenzívny CKM manažment,</li>
  <li>pri srdcovom zlyhaní integrácia CKM prospešných terapií podľa fenotypu (inhibítory SGLT2, inhibítory RAAS, MRA, GLP-1 podľa vhodnosti).</li>
</ul>

<h2>Prepojenie s nefrológiou a dialyzačnou realitou</h2>

<p>V prenose do nefrologickej praxe smernica posúva uvažovanie od „oblička je dôsledok“ k „oblička je centrálna súčasť syndrómu“:</p>

<ul>
  <li>albuminúria a eGFR sa majú používať rutinne,</li>
  <li>liečba sa má voliť podľa renálneho aj kardiovaskulárneho dosahu,</li>
  <li>a konať sa má už v preventívnej fáze, nie až pri zjavnej progresii.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> MedCentral (súhrnný článok o vydaní smernice AHA/ACC/ADA/ASN, 2026): „AHA, ACC Issue First-Ever Multi-Society CKM Guidance“. <a href="https://www.medcentral.com/guidelines/aha-acc-issue-first-ever-multi-society-ckm-guidance" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
