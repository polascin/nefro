<?php
/**
 * add_TEMPLATE_popular_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre POPULARIZAČNÝ článok (sekcia „Pre pacientov“ → populars.php).
 * Určené pre poučených pacientov a verejnosť — jednoduchý jazyk, obrázky.
 *
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. Obrázky nahraj do priečinka  img/  (commitni ich tiež)
 *   4. git add + git commit  →  deploy hook automaticky nahrá súbory na server
 *   5. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE POPULARIZAČNÝ OBSAH:
 *   • Jazyk    – jednoduchý, priateľský, bez odborného žargónu. Skratky (CKD, eGFR)
 *                vždy raz vysvetli ľudskou rečou. Krátke vety, „vykajte“ čitateľovi.
 *   • title    – čistý text, bez HTML; zrozumiteľný aj laikovi
 *   • slug     – len [a-z0-9-], max 80 znakov, unikátny. Diakritika → ASCII.
 *   • excerpt  – 1–2 vety, čo sa čitateľ dozvie; zobrazí sa na karte v sekcii
 *   • content  – HTML; NEZAČÍNAJ <h2> zhodným s titulom (duplikát)
 *                Obrázok → <figure><img src="img/<subor>.png" alt="popis" loading="lazy">
 *                          <figcaption>Popis obrázka</figcaption></figure>
 *                PRVÝ <img> v obsahu sa automaticky použije ako náhľad karty.
 *                Vždy vyplň zmysluplný alt text (prístupnosť + SEO).
 *                Nadpisy sekcií → <h2>; zoznam → <ul>/<ol> + <li>
 *   • category – 'popularne' (nastavené automaticky nižšie — needituj)
 *   • is_top   – 0 = bežný, 1 = odporúčaný (zobrazí sa s odznakom navrchu sekcie)
 *   • author   – autor projektu (predvolene 'MUDr. Ľubomír Polaščín').
 *
 *   ⚠ PÔVODNÍ AUTORI ZDROJA (widget „Zúčastnení autori“ + filter ?autor=):
 *      Pole `author` je VŽDY len autor projektu, preto sa pôvodní autori
 *      zdrojového článku k autorom NEpridajú automaticky. Ak je článok
 *      slovenským spracovaním KONKRÉTNEHO zdrojového článku, doplň jeho
 *      pôvodných autorov do  source_authors.php  (mapa slug → [mená]) — tá je
 *      autoritatívna a zobrazí ich vo widgete aj vo filtri. Mená len z otvorených
 *      bibliografických API (Crossref/PubMed) či verejných správ — NIE z paywallu.
 *      Bez mapy funguje len fallback: prvý autor z presnej značky „Zdroj:“ v obsahu.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať popularizačný článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => '',                    // ← VYPLNIŤ: napr. 'Čo sú obličky a prečo sú také dôležité'
    'slug'         => '',                    // ← VYPLNIŤ: napr. 'co-su-oblicky-preco-dolezite'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť odporúčaný navrchu sekcie
    'excerpt'      => '',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<!-- ← VYPLNIŤ: nahraď tento komentár skutočným HTML obsahom článku -->
<!-- POZOR: nezačínaj <h2> zhodným s titulom — ten sa generuje automaticky -->

<figure>
  <!-- alt POVINNE vyplň: čo je na obrázku vidieť (nie „obrázok“/„foto“).
       Prázdne alt="" nechaj len pri čisto dekoratívnom obrázku + aria-hidden="true". -->
  <img src="img/.png" alt="← VYPLNIŤ: popis obrázka" loading="lazy" decoding="async">
  <figcaption>Popis hlavného obrázka.</figcaption>
</figure>

<p>Úvodný odsek jednoduchým jazykom…</p>

<h2>Prvá sekcia</h2>

<p>Text sekcie zrozumiteľne pre laika…</p>

<hr>

<p><em><strong>Zdroj / ďalšie čítanie:</strong> <a href="" target="_blank" rel="noopener noreferrer">Názov zdroja</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'popularne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_TEMPLATE_popular_article',
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
    echo "Migrácia popularizačného článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
      <title>Migrácia popularizačného článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia popularizačného článku</h2>

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
            <a href="populars.php" class="btn-primary">← Späť na sekciu Pre pacientov</a>
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
