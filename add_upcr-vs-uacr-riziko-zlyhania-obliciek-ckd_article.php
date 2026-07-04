<?php
/**
 * add_upcr-vs-uacr-riziko-zlyhania-obliciek-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_upcr-vs-uacr-riziko-zlyhania-obliciek-ckd_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * Pôvodní autori: zdrojom je novinársky materiál portálu ReachMD, ktorý
 * v dostupnom texte NEUVÁDZA zoznam autorov. Preto článok ostáva len pod
 * autorom projektu a do source_authors.php sa žiadna mapa nedopĺňa (v súlade
 * s pravidlom v tom súbore — mená len z overených bibliografických zdrojov).
 * Ak sa autori doplnia, pridaj slug → mená do source_authors.php.
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
    'title'        => 'Bielkovina v moči verzus albumín pri hodnotení rizika zlyhania obličiek pri CKD: má UPCR rovnakú výpovednú hodnotu ako UACR?',
    'slug'         => 'upcr-vs-uacr-riziko-zlyhania-obliciek-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prospektívna observačná analýza japonských pred-dialyzačných pacientov s CKD ukazuje, že 30 % pokles UPCR aj UACR sa spája s nižším rizikom zlyhania obličiek (KFRT) a oba markery majú podobnú prognostickú výkonnosť. Pri pokročilej CKD (eGFR pod 15) je však spoľahlivejší UACR.',
    'content'      => <<<'HTML'
<p>Pri stratifikácii rizika progresie chronickej obličkovej choroby (CKD) sa v ambulantnej praxi bežne používa <strong>albuminúria vyjadrená ako UACR</strong> (pomer albumín/kreatinín v moči). Alternatívou alebo doplnkom je <strong>celková proteinúria vyjadrená ako UPCR</strong> (pomer proteín/kreatinín v moči). Na prvý pohľad by sa mohlo zdať, že ide o takmer zameniteľné ukazovatele. V skutočnosti však UPCR a UACR nie sú totožné: UPCR zachytáva aj nealbumínové zložky proteinúrie (napríklad bielkoviny tubulárneho pôvodu či iné proteíny než albumín), pričom podiel albumínu na celkovej proteinúrii môže s klesajúcou funkciou obličiek postupne klesať.</p>

<p>Práve na túto otázku sa zameriava materiál publikovaný na portáli ReachMD: skúma, či <strong>UPCR dokáže vystihnúť riziko zlyhania obličiek vyžadujúceho náhradu funkcie obličiek (KFRT)</strong> rovnako dobre ako UACR a či je táto výpovedná hodnota konzistentná naprieč jednotlivými štádiami CKD.</p>

<h2>Čo ukázala prospektívna observačná analýza</h2>

<p>Ide o prospektívnu observačnú analýzu japonských pacientov s pred-dialyzačnou CKD. Hlavným sledovaným ukazovateľom (endpointom) bolo <strong>KFRT</strong>, teda zlyhanie obličiek vyžadujúce náhradu funkcie — začatie hemodialýzy, peritoneálnej dialýzy alebo transplantáciu obličky.</p>

<h3>1. Pokles UPCR aj UACR o 30 % súvisel s nižším rizikom KFRT</h3>

<p>V kohorte s prekrývajúcimi sa meraniami (hodnotili sa zmeny v priebehu rokov) boli <strong>30 % pokles UPCR</strong> aj <strong>30 % pokles UACR</strong> spojené s <strong>nižším následným rizikom KFRT</strong>. Uvádzané pomery rizík (hazard ratio, HR) boli:</p>

<ul>
  <li>pre <strong>30 % pokles UPCR</strong>: HR 0,52 (95 % CI 0,38 až 0,71);</li>
  <li>pre <strong>30 % pokles UACR</strong>: HR 0,58 (95 % CI 0,41 až 0,82).</li>
</ul>

<h3>2. Prognostickú hodnotu mal aj pokles UPCR za jeden rok</h3>

<p>Samostatne sa hodnotil aj <strong>30 % pokles UPCR za jeden rok</strong>. Aj v tomto prípade bola asociácia s nižším rizikom KFRT významná: HR 0,56 (95 % CI 0,43 až 0,73) v skupine 831 pacientov.</p>

<h3>3. UPCR a UACR mali podobnú diskrimináciu aj kalibráciu</h3>

<p>Modely založené na UPCR aj na UACR mali porovnateľnú <strong>diskriminačnú schopnosť</strong> (Harrellov C-index bol približne rovnaký) a celkovo <strong>dobrú kalibráciu</strong>.</p>

<h3>4. Dôležitá výnimka: pri eGFR pod 15 ml/min/1,73 m² bola asociácia UPCR slabšia</h3>

<p>V skupine s <strong>eGFR pod 15 ml/min/1,73 m²</strong> bola asociácia UPCR s KFRT <strong>slabšia</strong> než asociácia UACR. Autori to vysvetľujú <strong>nižším podielom albumínu na celkovej proteinúrii</strong> pri pokročilejšom zlyhávaní obličiek. Zároveň sa uvádza, že odhady boli neisté u pacientov s veľmi nízkou východiskovou hodnotou UACR (napríklad pod 30 mg/g kreatinínu).</p>

<h2>Ako to preniesť do nefrologickej praxe</h2>

<p>Tieto zistenia zmenšujú praktický rozdiel medzi UPCR a UACR, no zároveň jasne ukazujú, že oba ukazovatele majú svoje limity.</p>

<h3>Praktické zhrnutie</h3>

<ol>
  <li>Ak sledujete riziko progresie CKD dynamicky, <strong>30 % pokles UPCR alebo UACR v priebehu jedného až dvoch rokov je signálom lepšej prognózy</strong>.</li>
  <li>V bežných štádiách CKD môže byť UPCR v tomto type kohorty <strong>približne rovnocenným náhradným markerom</strong>.</li>
  <li>Pri pokročilej CKD (eGFR pod 15) je rozumnejšie <strong>uprednostniť UACR</strong>, pretože UPCR môže zachytávať viac nealbumínových zložiek, ktoré nemusia niesť rovnaké prognostické posolstvo ako samotný albumín.</li>
</ol>

<h3>Ako to využiť pri rozhodovaní a v komunikácii s pacientom</h3>

<ul>
  <li>Ak u pacienta po optimalizácii nefroprotektívnej liečby (ACE inhibítory alebo sartany a ďalšie lieky podľa jeho profilu) klesá proteinúria či albuminúria, ide o objektívny podklad na posúdenie rizika.</li>
  <li>V pokročilých štádiách CKD nemožno UPCR považovať za plnohodnotnú náhradu UACR bez zohľadnenia kontextu — najmä ak sa mení zloženie proteinúrie.</li>
</ul>

<h2>Limity, ktoré treba mať na pamäti</h2>

<ul>
  <li>Ide o <strong>observačnú</strong> analýzu, nie o randomizovanú liečebnú štúdiu, takže nejde o priamy dôkaz kauzality.</li>
  <li>UPCR ako náhradný marker nemusí univerzálne nahrádzať UACR v každom fenotype CKD a v každej populácii. Autori v závere zdôrazňujú, že ide skôr o <strong>porovnateľnosť v rámci tejto kohorty</strong> než o všeobecnú náhradu použiteľnú za akýchkoľvek podmienok.</li>
</ul>

<h2>Záver</h2>

<p>U pacientov s pred-dialyzačnou CKD sa <strong>30 % pokles UPCR</strong> spája s nižším rizikom KFRT a modely založené na UPCR aj na UACR majú celkovo podobnú prognostickú výkonnosť. Najväčší rozdiel sa javí pri <strong>eGFR pod 15 ml/min/1,73 m²</strong>, kde UPCR stráca časť „albumínového“ signálu — a preto je v pokročilých štádiách rozumnejšie opierať sa viac o <strong>UACR</strong>.</p>

<hr>

<p><em><strong>Zdroj:</strong> ReachMD, <em>Urinary Protein vs Albumin for Assessing Kidney Failure Risk in CKD</em>. <a href="https://reachmd.com/news/urinary-protein-vs-albumin-for-assessing-kidney-failure-risk-in-ckd/2487645/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
