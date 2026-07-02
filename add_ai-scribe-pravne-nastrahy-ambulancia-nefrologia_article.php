<?php
/**
 * add_ai-scribe-pravne-nastrahy-ambulancia-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ai-scribe-pravne-nastrahy-ambulancia-nefrologia_article.php"
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
    'title'        => 'Právne nástrahy pri používaní AI scribov v ambulancii a čo z toho plynie pre nefrologickú prax',
    'slug'         => 'ai-scribe-pravne-nastrahy-ambulancia-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ericka L. Adler na Medscape zhŕňa právne riziká AI scribov v ambulancii: súlad dodávateľa s ochranou dát, preukázateľný súhlas pacienta a zodpovednosť lekára za presnosť záznamu. V nefrológii to platí dvojnásobne — dokumentácia ovplyvňuje dlhodobé rozhodovanie aj bezpečnosť liečby.',
    'content'      => <<<'HTML'
<p>AI scriby (nástroje na automatický prepis a tvorbu zdravotnej dokumentácie pomocou umelej inteligencie) sa dnes používajú preto, aby znížili administratívnu záťaž a zrýchlili zápis priamo počas vyšetrenia. V nefrológii býva dokumentácia obzvlášť časovo náročná — chronické ochorenie, liečba, dávkovanie, laboratórne trendy, záznamy z dialyzačnej či pred-dialyzačnej fázy. To robí z AI scribov praktický nástroj, no zároveň oblasť s právnymi rizikami, na ktoré sa sústreďuje článok z Medscape.</p>

<h2>1) Zvoľte riešenie pripravené na zdravotnícke dáta, nie „len“ na nahrávanie</h2>

<p>Podľa zdroja nejde o to kúpiť hotový nástroj a jednoducho začať nahrávať rozhovory. Základom je mať jasno v tom:</p>

<ul>
  <li>kde sa informácie ukladajú,</li>
  <li>kto na strane dodávateľa má k záznamom prístup,</li>
  <li>ako dlho sa záznamy uchovávajú.</li>
</ul>

<p>Nie je to detail pre IT oddelenie, ale jadro compliance (súladu s predpismi). Ak sa pri modeli uchovávania alebo prístupu nedá reálne vysvetliť, ako je chránené súkromie pacienta, právne riziko sa zvyšuje hneď od začiatku implementácie.</p>

<h2>2) Pacienta informujte a súhlas získajte tak, aby bol preukázateľný</h2>

<p>Zdroj zdôrazňuje, že pacientovi treba vopred jasne vysvetliť, prečo AI scribe používate, ako zlepší priebeh vyšetrenia a ako prispeje k dokumentácii. Dôležitá je aj praktická stránka: pacient musí mať možnosť súhlasiť alebo odmietnuť.</p>

<p>Kritickým bodom je zdokumentovanie súhlasu v zdravotnej dokumentácii. Článok upozorňuje na prípady, keď pacienti tvrdili, že boli nahrávaní bez súhlasu. Aj keď záznam v dokumentácii môže neskôr pôsobiť, že súhlas prebehol, právny problém nastáva vtedy, ak v skutočnosti udelený nebol.</p>

<p>Pre prax z toho vyplýva jediné — zaviesť interný proces, aby súhlas bol:</p>

<ul>
  <li>udelený správnym spôsobom (v súlade s miestnymi pravidlami),</li>
  <li>zaznamenaný spoľahlivo a konzistentne,</li>
  <li>a pri prípadnej kontrole spätne obhájiteľný.</li>
</ul>

<h2>3) Lekár zostáva zodpovedný za správnosť záznamu aj pri AI scribovi</h2>

<p>AI scribe má pomáhať, no zodpovednosti nezbavuje. Zdroj výslovne upozorňuje, že AI niekedy „halucinuje“ — teda vytvára nepodložené alebo nepresné informácie.</p>

<p>V nefrológii je tento problém obzvlášť citlivý, pretože dokumentácia nesie zásadné klinické rozhodnutia:</p>

<ul>
  <li>presné dávky liekov a zmeny liečby,</li>
  <li>parametre ako kreatinín/eGFR, proteinúria, elektrolyty,</li>
  <li>plán sledovania a výsledky vyšetrení,</li>
  <li>ako aj záznamy o dialyzačnej liečbe či o predpisovaní nefroprotektívnych postupov.</li>
</ul>

<p>Praktické minimum, ktoré si z článku možno odniesť: po každom vyšetrení treba prekontrolovať nielen to, „či bol súhlas“, ale aj celý medicínsky obsah záznamu.</p>

<h2>4) Ochrana ambulancie: zmluvy, interné politiky a kontrola dodávateľa</h2>

<p>Zdroj odporúča riešiť implementáciu s právnikom — najmä kvôli zmluvám s dodávateľom a kvôli tomu, aby ambulancia mala vhodné interné politiky. Z hľadiska rizika je podstatné, aby:</p>

<ul>
  <li>zmluva jasne upravovala zber, uchovávanie a prístup k záznamom,</li>
  <li>interné procesy riešili súhlas aj kontrolu záznamu,</li>
  <li>personál vedel, ako postupovať v situáciách, keď výstup AI nedáva zmysel alebo je nepresný.</li>
</ul>

<p>A ešte jedna vec z článku: v závere je nutné dodržať pravidlá týkajúce sa nahrávania interakcií a uchovávania záznamov v súlade s právnymi predpismi (zdroj to uvádza ako potrebu zosúladenia so „štátnymi a federálnymi zákonmi“ a s HIPAA v kontexte USA).</p>

<h2>5) Čo by som v nefrologickej ambulancii nastavil ako „bezpečné minimum“</h2>

<p>Ak chcete AI scribe zaviesť tak, aby sa nestal zdrojom problémov, v duchu toho, čo zdroj zdôrazňuje, odporúčam mať:</p>

<ol>
  <li>schválený proces výberu dodávateľa (ukladanie, prístup, retenčná doba),</li>
  <li>presný scenár na informovanie pacienta a štandardný postup na získanie súhlasu,</li>
  <li>povinnú kontrolu výstupu lekárom pred finálnym uložením,</li>
  <li>pravidlo, že ak záznam z AI nie je stopercentne overiteľný oproti tomu, čo počas vyšetrenia reálne prebehlo, nejde do dokumentácie bez opravy.</li>
</ol>

<h2>Záver</h2>

<p>AI scribe môže byť praktický, no právne riziká sa v článku z Medscape sústreďujú na tri reálne body: <strong>compliance dodávateľa</strong>, <strong>preukázateľný súhlas pacienta</strong> a <strong>zodpovednosť lekára za presnosť záznamu</strong>. V nefrológii to platí dvojnásobne, pretože dokumentácia ovplyvňuje dlhodobé rozhodovanie aj bezpečnosť liečby.</p>

<hr>

<p><em><strong>Zdroj:</strong> Ericka L. Adler, <em>Avoid These Legal Pitfalls When Using AI Scribes</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/avoid-these-legal-pitfalls-when-using-ai-scribes-2026a1000lp6" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
