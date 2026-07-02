<?php
/**
 * add_era-2026-post-kongres-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): post-kongresová analýza ERA
 * 2026 — ako preniesť highlights (CKD, dialýza, transplantácia, KV riziko) do
 * praxe. Slovenské spracovanie zdroja (STREAMED UP / NephroLive video).
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_era-2026-post-kongres-nefrologia_article.php"
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
    'title'        => 'Post-kongresová analýza ERA 2026 pre nefrológiu: ako preniesť „highlights“ do praxe pri CKD, dialýze, transplantácii a kardiovaskulárnom riziku',
    'slug'         => 'era-2026-post-kongres-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Post-kongresový rámec ERA 2026 pre nefrológiu: ako preniesť highlights v oblasti CKD, dialýzy, transplantácie a kardiovaskulárneho rizika do každodenného rozhodovania — praktické „check“ body pre ambulanciu, dialýzu aj sledovanie po transplantácii.',
    'content'      => <<<'HTML'
<p>Často sa stáva, že po veľkých odborných kongresoch (ERA) máme pocit „bolo toho veľa“, no v ambulancii
potrebujeme rýchlo určiť, čo z toho má praktický dosah. Tento post-kongresový materiál uvádza highlights
so zameraním na <strong>manažment kardiovaskulárneho rizika, transplantáciu, dialýzu a chronické ochorenie
obličiek (CKD)</strong>. To je dobrý rámec na tvorbu vlastného „post-kongresového“ protokolu pre
nefrologickú prax.</p>

<p>Nižšie rozoberám, ako by mal vyzerať prenos týchto tém do každodenného rozhodovania. Materiál je
zámerne rámcový: konkrétne štúdie, dávky a presné odporúčania si treba overiť priamo v zázname z kongresu
— tu sa sústredím na to, ako highlights preniesť do praxe.</p>

<h2>1) Kardiovaskulárne riziko pri CKD: z „renálneho rizika“ sa stáva CKM prístup</h2>
<p>Pri CKD je kardiovaskulárne riziko často dominantné a rozhodnutia nie sú len o eGFR. V post-kongresovom
duchu je užitočné zadefinovať si v praxi tri veci:</p>
<ol>
  <li><strong>Ktorý pacient je „KV dominantný“?</strong> Nielen podľa diagnózy, ale aj podľa klinických
      znakov (anamnéza KV príhod, krvný tlak, albuminúria, priebeh ochorenia, metabolické faktory).</li>
  <li><strong>Čo je cieľ a ako ho budem sledovať?</strong> Aj keď sa ciele medzi pracoviskami líšia,
      dôležité je, aby sa nefrológ nestratil v reťazci meraní a liekov a mal vlastnú logiku sledovania
      (follow-upu).</li>
  <li><strong>Kde je rozhodovanie najčastejšie „rozbité“ medzi odbormi?</strong> Typicky ide o koordináciu
      medzi nefrológiou, diabetológiou a kardiológiou, aby pacient nemal paralelné, ale nekonzistentné
      plány.</li>
</ol>
<p>Prakticky: v ambulancii je dobré vytvoriť „CKD-KV check“ pre každú kontrolu, ktorý sa neopiera len
o laboratóriá, ale aj o komorbiditu a rizikový profil.</p>

<h2>2) Transplantácia: od jednotlivých príhod k systému sledovania a prevencie</h2>
<p>V oblasti transplantácie býva najväčší prínos kongresových highlightov v dvoch typoch tém:</p>
<ul>
  <li><strong>monitorovanie</strong> (čo a ako často, čo je „varovný signál“),</li>
  <li><strong>prevencia</strong> (infekcie, metabolické komplikácie, dlhodobé riziko funkcie štepu).</li>
</ul>
<p>Post-kongresový prístup by preto mal viesť k jednoduchým zmenám protokolu, napríklad:</p>
<ul>
  <li>spresnenie, čo presne sa hodnotí pri zhoršení (neuspokojiť sa len s „trendom“ kreatinínu),</li>
  <li>jasné „rozhodovacie body“, kedy eskalovať (pacient, laboratóriá, zobrazovanie, biopsia alebo iná
      diagnostika podľa lokálneho algoritmu).</li>
</ul>

<h2>3) Dialýza: kvalita liečby nie je len dávka, ale aj výsledok a bezpečnosť</h2>
<p>Pri dialýze často chceme „čo najviac“ parametrov, no klinicky rozhodujú:</p>
<ul>
  <li><strong>stabilita pacienta</strong> (interdialytické ťažkosti, hypotenzné epizódy, tolerancia),</li>
  <li><strong>bezpečnosť a riziká</strong> (infekcie, vaskulárny prístup, elektrolytové výkyvy),</li>
  <li><strong>dlhodobé ciele</strong> (hospitalizácie, nutričný stav, anémia, minerálovo-kostný
      metabolizmus).</li>
</ul>
<p>Ak sa highlights z ERA v týchto oblastiach potvrdzujú, post-kongresovo odporúčam prepracovať protokol
na dialyzačnom lôžku tak, aby:</p>
<ul>
  <li>bolo jasné, ktoré parametre sú „actionable“ (vyžadujú zásah),</li>
  <li>bolo jasné, čo je prvá línia úpravy (a čo nie),</li>
  <li>a aby dialyzačný tím a nefrologický tím komunikovali v tej istej logike.</li>
</ul>

<h2>4) CKD: ako zabrániť tomu, aby sa sledovanie zmenilo na samoúčelné meranie</h2>
<p>Pri CKD je najčastejšia chyba „meriam všetko, ale neviem, čo to mení“. Post-kongresová disciplína by
mala viesť k otázkam:</p>
<ul>
  <li>Ktoré výsledky sú pre mňa signálom na zmenu terapie?</li>
  <li>Kedy opakujem vyšetrenie a s akým cieľom?</li>
  <li>Čo robím, keď sa cieľ nedarí (a nielen „čakám na ďalšiu kontrolu“)?</li>
</ul>
<p>Práve tu má nefrológ najväčší vplyv: v pretavení dát do rozhodovania.</p>

<hr>

<p><em><strong>Zdroj:</strong> „Post-Kongress: ERA 2026“, <em>STREAMED UP / NephroLive</em> (2026).
<a href="https://streamed-up.com/video/post-kongress-era-2026" target="_blank" rel="noopener noreferrer">Link na zdroj (video)</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_era2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_era2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_era2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_era2026 migration error: ' . $e->getMessage());
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
