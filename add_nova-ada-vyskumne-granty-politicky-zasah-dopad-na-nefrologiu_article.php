<?php
/**
 * add_nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu_article.php"
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
    'title'        => 'Nová ADA ako impulz na reflexiu: výskumné granty, politický zásah a dopad na nefrológiu',
    'slug'         => 'nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Reflexia Irla B. Hirscha (MD) na Medscape kritizuje smerovanie ADA a spája ho so škrtmi vo financovaní výskumu (NIH) a s politizáciou vedy. Pre nefrológiu je odkaz jasný: stabilita výskumu je podmienkou, aby sa nové poznatky o diabetickej chorobe obličiek včas premenili na lepšiu starostlivosť.',
    'content'      => <<<'HTML'
<h2>Prečo je to relevantné pre nefrológiu</h2>

<p>Klinická nefrológia sa často diskutuje cez diagnózy, liečbu a komplikácie. To podstatné však býva aj „mimo ambulancie“: stabilita výskumného ekosystému, dostupnosť grantov a schopnosť vedeckej komunity rýchlo pretavovať výsledky do praxe. Diabetes mellitus, najmä jeho chronické mikrovaskulárne poškodenie, je pritom jedným z hlavných motorov chronického ochorenia obličiek.</p>

<p>Článok na Medscape („The New ADA: I Prefer the Old One“) nie je primárne odborná klinická kazuistika. Je to autorova reflexia a kritika smerovania American Diabetes Association (ADA) v kontexte jej rozhodnutí počas ADA Scientific Sessions. Pre nefrológa je zaujímavé najmä to, že autor spája konkrétne udalosti s širšou témou dopadov škrtov a politizácie výskumu na vývoj diabetologických a s nimi súvisiacich renálnych terapií.</p>

<h2>Čo autor v texte opisuje</h2>

<p>Autor Irl B. Hirsch (MD) opisuje svoje osobné stanovisko a udalosti spojené s ADA Scientific Sessions. V centre pozornosti sú podľa neho kroky vedenia ADA, ktoré vyústili do odobratia a zhabania identifikačných kariet viacerým účastníkom. Autor to spája s distribúciou editoriálu (úvodníka) z časopisu <em>Diabetes Care</em> a s tým, že editoriál mal podľa jeho názoru komunikovať dopady škrtov v oblasti výskumu (NIH) na diabetologický výskumný „pipeline“.</p>

<p>Autor zároveň rámcuje pozadie tým, že hlavným rečníkom (keynote) mal byť Jay Bhattacharya a následne bol nahradený Richardom Woychikom. Text obsahuje aj širšiu politickú rovinu okolo priorít a smerovania výskumu.</p>

<h2>Hlavná myšlienka: nejde len o jednorazovú konfliktnú situáciu</h2>

<p>Z nefrologického pohľadu je dôležité, že autor nepíše len o „jednom dni“ či o protokole podujatia. Jeho argument sa opiera o tézu, že zásahy do výskumu a grantového prostredia môžu mať dlhodobý efekt: spomalenie objavov, zníženie počtu projektov a posun priorít od základného a translačného výskumu ku krátkodobým alebo politicky „preferovaným“ smerom.</p>

<p>Pri chronických ochoreniach, ako je diabetes s renálnymi dôsledkami, sú práve dlhšie časové horizonty kľúčové. Výsledky z laboratória a klinických štúdií sa do praxe bežne dostávajú až s odstupom rokov.</p>

<h2>Prepojenie na diabetologickú a nefrologickú prax</h2>

<p>Aj keď text Medscape nie je primárne zameraný na nefrológiu, nefrologická komunita sa s dopadmi výskumného prostredia stretáva nepriamo:</p>

<ul>
  <li><strong>Diabetická choroba obličiek:</strong> pokrok v prevencii a liečbe CKD pri diabete stojí na výskume biomarkerov, mechanizmov progresie a na klinických skúšaniach.</li>
  <li><strong>Včasná intervencia a riziková stratifikácia:</strong> ak sa zníži objem výskumu, môžu sa spomaliť aj inovácie v tom, ako identifikovať pacientov s rýchlou progresiou.</li>
  <li><strong>Dostupnosť dôkazov pre klinické odporúčania:</strong> menej grantov môže znamenať menej kvalitných dát, čo sa môže prejaviť v neskoršom aktualizovaní odporúčaní.</li>
</ul>

<h2>Ako čítať tento typ textu bez rizika nadinterpretácie</h2>

<p>Treba povedať, že ide o autorovo osobné stanovisko a opis udalostí z jeho perspektívy. To znamená:</p>

<ol>
  <li>Nie všetky tvrdenia treba automaticky brať ako „hotové fakty“, ak nie sú podložené nezávislými záznamami alebo formálnymi dokumentmi.</li>
  <li>Ak má článok slúžiť ako podklad do odbornej diskusie, je vhodné doplniť ho o primárne zdroje (vyhlásenia organizátorov, stanoviská, oficiálne recenzie a verejne dostupné informácie).</li>
</ol>

<h2>Praktické ponaučenie pre klinickú komunitu</h2>

<p>Podľa autora je jadrom problému to, že organizácia by mala smerovať k vlastnej misii a k udržiavaniu priestoru pre vedeckú diskusiu. Pre nefrológiu to v praktickej rovine prináša otázku, ako udržať:</p>

<ul>
  <li><strong>stabilitu financovania výskumu</strong> na dlhé obdobia,</li>
  <li><strong>ochranu akademickej slobody</strong> a transparentnosť hodnotenia,</li>
  <li><strong>dôraz na misijnú podstatu</strong> odborných spoločností a časopisov.</li>
</ul>

<p>Ak sa tieto prvky oslabia, dopad sa časom prenesie aj do kvality dôkazov, ktoré používame v každodennej starostlivosti o pacientov s diabetickým aj nediabetickým poškodením obličiek.</p>

<h2>Záver</h2>

<p>Text z Medscape predstavuje kritickú reflexiu smerovania ADA a spája ju s väčším príbehom o tom, ako výskumné granty, politická klíma a rozhodnutia odborných organizácií môžu formovať budúcnosť diabetológie a nepriamo aj nefrológie. Pre nás je hlavná správa jednoduchá: stabilita výskumu nie je abstraktná téma, ale podmienka, aby sa nové poznatky dokázali včas premeniť na lepšiu starostlivosť o ľudí s chronickým ochorením obličiek.</p>

<h2>Poznámka k presnosti a overovaniu</h2>

<p>Tento článok je prehľad a komentár vychádzajúci zo zdroja Medscape. Pri konkrétnych konfliktných tvrdeniach (kto, kedy a prečo konal) je rozumné overiť detaily v primárnych materiáloch organizácie a v nezávislých prehľadoch.</p>

<hr>

<p><em><strong>Zdroj:</strong> Irl B. Hirsch, <em>The New ADA: I Prefer the Old One</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/new-ada-i-prefer-old-one-2026a1000l92" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
