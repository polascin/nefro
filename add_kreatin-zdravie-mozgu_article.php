<?php
/**
 * add_kreatin-zdravie-mozgu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): kreatín a zdravie mozgu —
 * čo hovoria dôkazy + nefrologická poznámka. Slovenské spracovanie zdroja
 * (Medscape Medical News). Pôvodný autor v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kreatin-zdravie-mozgu_article.php"
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
    'title'        => 'Kreatín a zdravie mozgu: stojí to za skúsenie, alebo je to len ďalší doplnok?',
    'slug'         => 'kreatin-zdravie-mozgu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kreatín sa z oblasti športu presúva aj do neurologickej debaty (kognícia, nálada, spánok). Dôkazy sú zatiaľ variabilné a skôr krátkodobé, pre demenciu nepevné. Prehľad Medscape doplnený o praktickú nefrologickú poznámku: pozor na interpretáciu kreatinínu a opatrnosť pri CKD.',
    'content'      => <<<'HTML'
<p>Pacienti často prídu s otázkou „čo by som mohol zlepšiť pri zhoršenej pozornosti, únave, spánku
alebo myslení?". V posledných rokoch sa kreatín presúva z oblasti športu aj do neurologickej debaty,
najmä preto, že sa objavujú dáta o jeho možnom vplyve na kogníciu, náladu a spánok. Medscape článok
zároveň zdôrazňuje, že dôkazy pre demenciu zatiaľ nie sú pevné a bezpečnostné otázky nie sú úplne
uzavreté.</p>

<h2>Čo je kreatín a prečo vôbec „robí mozgu"</h2>
<p>Kreatín je endogénna látka: tvorí sa v pečeni a obličkách a jeho prekurzory sa získavajú aj
z potravy. Väčšina kreatínu sa nachádza vo svaloch ako fosfokreatín, kde slúži na rýchle dopĺňanie
ATP počas záťaže.</p>
<p>Keď sa začalo uvažovať o kreatíne v mozgu, dôvod je aj biologický: kreatín sa tvorí v mozgu
a v sietnici procesom zahŕňajúcim enzým guanidinoacetát-metyltransferázu, ktorý je výrazne
exprimovaný v gliových bunkách. Záujem sa opiera aj o pozorovanie, že porucha transportéra kreatínu
(CRT; gén SLC6A8) vedie k výrazným neurologickým prejavom, pričom mechanizmus dysfunkcie ešte nie je
úplne objasnený a špecifická liečba deficiencie CRT v praxi neexistuje.</p>

<h2>Aké je aktuálne klinické skúšanie u zdravých ľudí</h2>
<p>Medscape sumarizuje, že existuje viacero malých štúdií, ktoré podporujú myšlienku, že kreatín
môže zlepšovať niektoré aspekty nálady, kognície a spánku u zdravých dospelých. Účinky sú však
variabilné a skôr nekonzistentné.</p>
<p>Článok spomína aj konkrétnu štúdiu z roku 2026: u 29 spánkovo deprivovaných dospelých viedol
kreatín monohydrát (0,2 g/kg) až k približne 12 % zmierneniu zhoršenia kognitívnych schopností
vyvolaného nedostatkom spánku. Dôležité je, že ide o krátkodobý kontext a neznamená to automaticky
„prevenciu demencie".</p>

<h2>Kreatín pri neurologických ochoreniach: čo sa už skúšalo</h2>
<p>Medscape uvádza, že kreatín má potenciál aj ako prídavná (adjunktná) liečba v niektorých stavoch,
no dôkazy sú zatiaľ obmedzené:</p>
<ul>
  <li><strong>Traumatické poranenie mozgu a otras mozgu (concussion):</strong> prehľadový článok
      z roku 2022 v časopise <em>Nutrients</em> naznačuje možný prínos pri niektorých príznakoch.</li>
  <li><strong>Alzheimerova choroba:</strong> malé pilotné jednoramenné skúšanie (n = 20) používalo
      20 g/deň kreatín monohydrátu počas 8 týždňov. Pozorovalo sa zvýšenie celkového kreatínu v mozgu
      a mierne zlepšenia v kognitívnych testoch.</li>
</ul>
<p>Z hľadiska kvality dôkazov sú to zatiaľ skôr signály než definitívne odpovede.</p>

<h2>Je kreatín bezpečný a aké sú limity dôkazov</h2>
<p>Článok je opatrný: aj keď sa kreatín ako doplnok v súvislosti s cvičením a budovaním svalov zdá
byť relatívne bezpečný, bezpečnostné obavy „nie sú úplne vyriešené". Zároveň spomína, že nie sú jasne
stanovené štandardné dávky a chýbajú pevne dané výživové odporúčania pre tento konkrétny účel
(zdravie mozgu).</p>
<p>Takisto platí, že kľúčová výhoda, o ktorej článok hovorí, je skôr v <strong>krátkodobých</strong>
účinkoch, nie v dlhodobom „ochrannom" vplyve na mozog.</p>

<h2>Praktická rovina: ako k tomu pristupovať u pacienta</h2>
<p>Medscape v kontexte zdravých ľudí aj ľudí s kognitívnymi ťažkosťami pripúšťa, že vyskúšať kreatín
môže dávať zmysel, ale s realistickým očakávaním: ide o doplnok s možným, no nie garantovaným
krátkodobým účinkom. Praktický princíp je, aby si človek sám vyhodnotil, či mu kreatín reálne pomáha
v kognícii, nálade alebo spánku.</p>

<h2>Poznámky z nefrologickej praxe (opatrne a prakticky)</h2>
<p>Ide o doplnok, ktorý sa v ambulancii často rieši aj u pacientov s CKD. Keďže sa článok zameriava
najmä na neurologické aspekty, nefrologická interpretácia musí byť opatrná:</p>
<ul>
  <li>Kreatín sa v tele mení na kreatinín, takže môže <strong>skomplikovať interpretáciu
      kreatinínu</strong> v laboratórnych výsledkoch (najmä pri vysokej dávke alebo ak sa funkcia
      obličiek sleduje „len podľa kreatinínu").</li>
  <li>U pacientov s pokročilou CKD býva bezpečnostný profil doplnkov (najmä vo vyšších dávkach) menej
      jasný. V praxi preto dáva zmysel postupovať konzervatívne: pred nasadením sa poradiť, nastaviť
      monitoring a vyhnúť sa „empirickému" zvyšovaniu dávky bez opodstatnenia.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Heidi Moawad, „Is Creatine Supplementation for Brain Health Worth
a Try?", <em>Medscape Medical News</em> (2026).
<a href="https://www.medscape.com/viewarticle/creatine-supplementation-brain-health-worth-try-2026a1000kuz" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_kreatin newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_kreatin pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_kreatin pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_kreatin migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
