<?php
/**
 * add_telitacicept-iga-nefropatia-teligan-faza-3-interim_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Telitacicept v IgA nefropatii — interim analýza fázy 3
 * (TELIGAN). Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie
 * KONKRÉTNEHO zdroja (TELIGAN, NEJM 2026 / súhrn ReachMD) → autori doplnení
 * do source_authors.php.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Telitacicept v IgA nefropatii: interim analýza fázy 3 (TELIGAN) ukazuje výrazné zníženie proteinúrie pri vyššom výskyte nežiaducich udalostí',
    'slug'         => 'telitacicept-iga-nefropatia-teligan-faza-3-interim',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Interim analýza fázy 3 TELIGAN (n = 318): telitacicept znížil 24-hodinovú proteinúriu o 58,9 % vs 8,8 % pri placebe (relatívne −55 %; p < 0,001) a eGFR klesalo menej; nežiaducich udalostí bolo viac, závažných AE menej.',
    'content'      => <<<'HTML'
<p>IgA nefropatia (IgAN) patrí medzi najčastejšie primárne glomerulárne ochorenia vedúce k chronickému zlyhaniu obličiek. Kľúčovou biologickou osou jej patogenézy je okrem iného dysregulácia B buniek a signálnej dráhy sprostredkovanej faktorom aktivujúcim B bunky (BAFF, <em>B-cell activating factor</em>) a ligandom indukujúcim proliferáciu (APRIL, <em>a proliferation-inducing ligand</em>). Telitacicept je fúzny proteín, ktorý cieli a neutralizuje BAFF aj APRIL, a preto predstavuje racionálnu terapeutickú stratégiu pre IgAN.</p>

<h2>Autori zdrojovej štúdie</h2>

<p>Zdrojom je interim analýza štúdie <strong>TELIGAN</strong> publikovaná v časopise <em>New England Journal of Medicine</em> (2026). Kľúčovými autormi sú <strong>Jicheng Lv, Lijun Liu, Wenxiang Wang, Xinyue Wang, Qing Zuraw, Vlado Perkovic, Jianmin Fang</strong> a <strong>Hong Zhang</strong> v mene <strong>TELIGAN Investigators</strong>. Štúdia je registrovaná v registri ClinicalTrials.gov pod identifikátorom <a href="https://clinicaltrials.gov/study/NCT05799287" target="_blank" rel="noopener noreferrer">NCT05799287</a> (financovaná spoločnosťou RemeGen).</p>

<h2>Dizajn štúdie TELIGAN a populácia</h2>

<p>Išlo o <strong>multicentrickú, dvojito zaslepenú, randomizovanú a placebom kontrolovanú štúdiu fázy 3</strong>. Zaradení boli dospelí s <strong>biopticky potvrdenou IgA nefropatiou</strong> a <strong>perzistujúcou proteinúriou najmenej 1,0 g denne</strong> napriek primeranej podpornej liečbe.</p>

<ul>
  <li>randomizácia v pomere 1 : 1,</li>
  <li>intervencia: <strong>telitacicept 240 mg subkutánne raz týždenne</strong>,</li>
  <li>kontrola: zodpovedajúce placebo,</li>
  <li>celkovo <strong>318 pacientov</strong> (159 v každom ramene),</li>
  <li>hodnotenie v interim bode: <strong>po 39 týždňoch</strong>.</li>
</ul>

<p>Primárny cieľ bol zameraný na <strong>geometrický priemer pomeru 24-hodinovej proteinúrie</strong> — pomeru bielkovín ku kreatinínu v moči (UPCR) — v 39. týždni vzhľadom na východiskovú hodnotu. Bezpečnosť sa hodnotila súbežne.</p>

<h2>Výsledky účinnosti (39. týždeň)</h2>

<h3>Proteinúria</h3>

<p>Telitacicept v interim analýze viedol k výrazne väčšiemu poklesu proteinúrie než placebo:</p>

<ul>
  <li>zmena 24-hodinového UPCR:
    <ul>
      <li><strong>telitacicept: −58,9 %</strong>,</li>
      <li><strong>placebo: −8,8 %</strong>;</li>
    </ul>
  </li>
  <li>relatívny rozdiel medzi ramenami (pomer geometrických priemerov redukcií): <strong>−55,0 %</strong> (95 % CI <strong>−61,3 až −47,6</strong>; p < 0,001) v prospech aktívnej liečby.</li>
</ul>

<h3>Funkcia obličiek</h3>

<p>Z pohľadu nefrologicky významného „tvrdého" cieľa je dôležité, že v 39. týždni bol signál priaznivejší pre telitacicept:</p>

<ul>
  <li>zmena odhadovanej glomerulárnej filtrácie (eGFR) od východiskovej hodnoty:
    <ul>
      <li><strong>telitacicept: −1,0 %</strong> (95 % CI <strong>−3,2 až 1,2</strong>),</li>
      <li><strong>placebo: −7,7 %</strong> (95 % CI <strong>−9,9 až −5,4</strong>).</li>
    </ul>
  </li>
</ul>

<p>V praxi to treba interpretovať opatrne: ide o interim bod a eGFR sa zvyčajne mení pomalšie, preto jej zmeny v kratšom horizonte nemusia automaticky znamenať dlhodobý renoprotektívny efekt.</p>

<h2>Bezpečnosť</h2>

<p>Bezpečnostné údaje sú pri imunomodulačných terapiách v IgAN zásadné.</p>

<ul>
  <li>výskyt nežiaducich udalostí (akéhokoľvek typu): <strong>89,3 %</strong> (telitacicept) vs <strong>78,6 %</strong> (placebo),</li>
  <li>závažné nežiaduce udalosti: <strong>2,5 %</strong> (telitacicept) vs <strong>8,2 %</strong> (placebo),</li>
  <li>pri telitacicepte neboli hlásené <strong>neočakávané bezpečnostné nálezy</strong>.</li>
</ul>

<p>Klinicky to znamená, že telitacicept zjavne prináša vyššiu celkovú mieru nežiaducich udalostí, ale závažné udalosti sa v interim dátach javia ako menej časté než pri placebe. Pri takejto interpretácii je dôležité sledovať, ako sa bezpečnosť prejaví v pokračujúcej časti štúdie a či sa rozdiely udržia v dlhšom horizonte.</p>

<h2>Nefrologická interpretácia: čo tieto dáta znamenajú v praxi</h2>

<ol>
  <li><strong>Silný antiproteinurický efekt:</strong> pokles proteinúrie o takmer 59 % oproti 8,8 % pri placebe je veľký a klinicky relevantný. Proteinúria je pri IgAN etablovaný marker rizika progresie a jej zníženie sa často spája s lepšími renálnymi výsledkami.</li>
  <li><strong>Signál na eGFR:</strong> menší pokles eGFR v ramene s telitaciceptom je povzbudivý, ide však o interim hodnotenie.</li>
  <li><strong>Bezpečnosť vyžaduje dlhšie sledovanie:</strong> vyšší výskyt nežiaducich udalostí je prakticky dôležitý pre rozhodovanie o pomere prínosu a rizika, najmä ak by sa liek nasadzoval aj mimo úzko vybraných rizikových skupín.</li>
  <li><strong>Imunomodulácia mení imunitné prostredie:</strong> pri terapiách cieliacich BAFF/APRIL je biologicky očakávané zvýšenie rizík spojených s imunomoduláciou, hoci interim dáta neočakávané signály neukázali.</li>
</ol>

<h2>Limity interim analýzy</h2>

<ul>
  <li>ide o <strong>vopred špecifikovanú priebežnú (interim) analýzu</strong>, takže veľkosť efektu sa pri ďalšom sledovaní ešte môže zmeniť;</li>
  <li>primárny efekt stojí na <strong>náhradnom (surrogátnom) ukazovateli</strong> (proteinúria) — hoci ide o veľmi užitočný marker, pre pacienta v praxi býva rozhodujúce, či sa efekt v čase premietne do tvrdých klinických cieľov.</li>
</ul>

<h2>Záver</h2>

<p>Pri vysokorizikovej IgA nefropatii s perzistujúcou proteinúriou <strong>telitacicept v 39-týždňovej interim analýze významne znížil proteinúriu</strong> oproti placebu a zároveň ukázal <strong>menší pokles eGFR</strong>. V bezpečnosti bola pozorovaná vyššia frekvencia nežiaducich udalostí, zatiaľ čo závažné udalosti boli v interim analýze menej časté, bez neočakávaných bezpečnostných signálov. Pri zavádzaní do praxe bude kľúčové, aby pokračujúce výsledky potvrdili trvanie účinku a dlhodobú renálnu bezpečnosť.</p>

<hr>

<p><em><strong>Zdroj:</strong> Lv J, Liu L, Wang W, et al.; TELIGAN Investigators. Telitacicept for IgA Nephropathy — Interim Analysis of a Phase 3 Trial. <em>N Engl J Med</em>. 2026;394(19):1916–1924. <a href="https://doi.org/10.1056/NEJMoa2514415" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2514415</a> (TELIGAN, ClinicalTrials.gov NCT05799287). Spracované aj podľa súhrnu na portáli ReachMD „Telitacicept Interim Phase 3 Trial in IgA Nephropathy": <a href="https://reachmd.com/news/telitacicept-iga-nephropathy/2487417/" target="_blank" rel="noopener noreferrer">reachmd.com</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše existujúci článok (regenerácia).
// Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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
