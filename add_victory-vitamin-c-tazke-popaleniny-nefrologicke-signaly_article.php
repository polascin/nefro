<?php
/**
 * add_victory-vitamin-c-tazke-popaleniny-nefrologicke-signaly_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: VICTORY trial — vysokodávkovaný IV vitamín C pri ťažkých
 * popáleninách (neúčinný, možno škodlivý) s nefrologicky dôležitými signálmi.
 * Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie KONKRÉTNEHO
 * zdroja (VICTORY RCT, JAMA 2026 / súhrn ReachMD) → autori doplnení do
 * source_authors.php.
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
    'title'        => 'VICTORY: vysokodávkovaný intravenózny vitamín C nezlepšuje výsledky pri ťažkých popáleninách a môže byť škodlivý — s nefrologicky dôležitými signálmi',
    'slug'         => 'victory-vitamin-c-tazke-popaleniny-nefrologicke-signaly',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia fázy 3 VICTORY (n = 238): vysokodávkovaný IV vitamín C pri ťažkých popáleninách neprináša benefit a zvyšuje 28-dňovú aj nemocničnú mortalitu — s dôležitými nefrologickými signálmi (AKI, vyššia potreba KRT).',
    'content'      => <<<'HTML'
<p>Vysokodávkovaný intravenózny vitamín C (HD IV vitamín C) sa v intenzívnej medicíne a v popáleninovej starostlivosti skúmal ako potenciálny modulátor zápalovej odpovede a oxidačného stresu. V praxi však existuje aj „tiché“ nefrologické riziko: vitamín C sa metabolizuje na oxalát, takže pri zhoršenej renálnej funkcii, rizikovej hydratácii a u kriticky chorých pacientov sa tradične diskutovala možnosť zvýšeného výskytu oxalátovej nefropatie a zhoršenia akútneho poškodenia obličiek (AKI). Doteraz slabé alebo nekonzistentné dôkazy vyústili do veľkej randomizovanej štúdie VICTORY.</p>

<h2>Kto sú autori zdrojovej štúdie?</h2>

<p>Štúdia VICTORY bola publikovaná v časopise <em>JAMA</em> (2026). Medzi hlavných autorov patria <strong>Christian Stoppe, Aileen Hill, Leopoldo C. Cancio, Andrew G. Day, Kaitlin A. Pruskowski</strong> a <strong>Alexis F. Turgeon</strong>; posledným (senior) autorom je <strong>Daren K. Heyland</strong>. Štúdia je registrovaná v registri ClinicalTrials.gov pod identifikátorom <a href="https://clinicaltrials.gov/study/NCT04138394" target="_blank" rel="noopener noreferrer">NCT04138394</a>.</p>

<h2>Štúdia VICTORY: dizajn a populácia</h2>

<p>VICTORY bola <strong>medzinárodná multicentrická randomizovaná, dvojito zaslepená a placebom kontrolovaná štúdia fázy 3</strong> realizovaná v <strong>24 popáleninových centrách</strong> v Severnej, Strednej a Južnej Amerike, v Európe a v Ázii. Pacientov zaraďovali od 18. augusta 2020 do 12. septembra 2025.</p>

<p>Do štúdie boli zaradení dospelí (≥ 18 rokov) s:</p>

<ul>
  <li><strong>hlbokými popáleninami 2. a/alebo 3. stupňa</strong>,</li>
  <li><strong>rozsahom najmenej 20 % celkovej plochy tela</strong>,</li>
  <li>potrebou <strong>kožných transplantátov</strong>.</li>
</ul>

<p>Randomizácia prebehla v pomere 1 : 1:</p>

<ul>
  <li><strong>vitamín C</strong>: <strong>50 mg/kg intravenózne každých 6 hodín počas 96 hodín</strong>,</li>
  <li><strong>placebo</strong>: zodpovedajúce placebo.</li>
</ul>

<p>Celkovo bolo zaradených <strong>238 pacientov</strong> (priemerný vek 48,9 roka; 79 % mužov; priemerný rozsah popálenín 37,0 % povrchu tela) — <strong>120</strong> do ramena s vitamínom C a <strong>118</strong> do ramena s placebom.</p>

<p><strong>Primárny cieľ</strong> bol kompozitný:</p>

<ul>
  <li><strong>úmrtie do 28 dní</strong> a</li>
  <li><strong>pretrvávajúca dysfunkcia orgánov</strong> definovaná závislosťou od:
    <ul>
      <li>umelej pľúcnej ventilácie,</li>
      <li>dialýzy, resp. náhrady funkcie obličiek (KRT),</li>
      <li>vazopresorov alebo inotropík v 28. deň.</li>
    </ul>
  </li>
</ul>

<h2>Výsledky: primárny cieľ sa nezlepšil, mortalita bola vyššia</h2>

<p><strong>Primárny kompozitný výsledok</strong> sa nepotvrdil ako prospešný: vyskytol sa u <strong>49 pacientov (40,8 %)</strong> v ramene s vitamínom C oproti <strong>35 pacientom (29,7 %)</strong> v ramene s placebom — upravený rizikový pomer (RR) <strong>1,28</strong> (95 % CI <strong>0,99 – 1,65</strong>; p = <strong>0,06</strong>). Štúdia tým <strong>prekročila vopred stanovený prah futility/škodlivosti</strong> a po prvej priebežnej (interim) analýze sa <strong>predčasne zastavila</strong>. Predčasné zastavenie znižuje presnosť odhadov, no v tomto prípade bol signál škodlivosti už klinicky relevantný.</p>

<p><strong>Čas do prepustenia z nemocnice živého do 90 dní</strong> sa nezlepšil (upravený subdistribučný pomer rizík <strong>0,85</strong>; 95 % CI <strong>0,62 – 1,16</strong>; p = <strong>0,31</strong>).</p>

<p><strong>28-dňová mortalita</strong> bola vyššia v ramene s vitamínom C:</p>

<ul>
  <li>vitamín C: <strong>15,0 %</strong>,</li>
  <li>placebo: <strong>7,6 %</strong>,</li>
  <li>upravený RR <strong>1,96</strong> (95 % CI <strong>1,32 – 2,90</strong>; p = <strong>0,001</strong>).</li>
</ul>

<p>Vyššia bola aj <strong>nemocničná mortalita</strong>:</p>

<ul>
  <li>vitamín C <strong>23,3 %</strong> vs placebo <strong>16,1 %</strong>,</li>
  <li>upravený RR <strong>1,44</strong> (95 % CI <strong>1,03 – 2,00</strong>; p = <strong>0,03</strong>).</li>
</ul>

<p><strong>Dni bez pretrvávajúcej dysfunkcie orgánov</strong> vyzneli priaznivejšie pre placebo (medián <strong>12,5 dňa</strong> v ramene s vitamínom C oproti <strong>19,5 dňa</strong> v ramene s placebom; rozdiel mediánov <strong>−7,0 dňa</strong>; 95 % CI <strong>−17,0 až 4,0</strong>).</p>

<h2>Nefrologicky dôležité bezpečnostné signály</h2>

<p>Vysokodávkovaný IV vitamín C bol v štúdii spojený s viacerými parametrami, ktoré sú pre nefrológa relevantné najmä pri kritickom stave po popáleninách:</p>

<ul>
  <li><strong>akútne poškodenie obličiek (AKI)</strong>: <strong>15,0 %</strong> vs <strong>11,0 %</strong>,</li>
  <li><strong>iniciácia KRT</strong>: <strong>10,8 %</strong> vs <strong>5,9 %</strong>,</li>
  <li><strong>hypoglykémia</strong>: <strong>6</strong> vs <strong>3</strong> pacienti.</li>
</ul>

<p>Dôležité je, že výskyt niektorých špecifických komplikácií bol v oboch ramenách bez signifikantného rozdielu:</p>

<ul>
  <li><strong>nové oxalátové obličkové kamene</strong>: neboli hlásené,</li>
  <li><strong>závažná hemolýza</strong>: nebola hlásená,</li>
  <li><strong>závažné poruchy acidobázickej rovnováhy alebo elektrolytov</strong>: neboli hlásené,</li>
  <li><strong>refraktérna hypoglykémia</strong>: nebola hlásená.</li>
</ul>

<p>Štúdia však zároveň uvádza, že <strong>nebola dimenzovaná na zachytenie zriedkavých nežiaducich udalostí</strong> (riziká spojené s oxalátovou nefropatiou sa typicky považujú za „nízkofrekvenčné, ale s vysokou závažnosťou“ — <em>low frequency, high concern</em>), takže „negatívny“ záchyt v rámci štúdie automaticky neznamená absenciu rizika.</p>

<h2>Klinické implikácie pre nefrológiu v popáleninovej starostlivosti</h2>

<p>Na základe týchto výsledkov je ťažké obhájiť rutinné podávanie vysokodávkovaného intravenózneho vitamínu C pri ťažkých popáleninách mimo kontextu klinického skúšania. Prakticky to znamená:</p>

<ol>
  <li><strong>V nefrologickej rovine</strong> uprednostniť stratégie s preukázaným vplyvom na perfúziu, prevenciu AKI, včasnú identifikáciu obličkového stresu a racionálne načasovanie KRT — a neinvestovať do intervencie so signálom škodlivosti.</li>
  <li>Ak by sa vitamín C aj napriek tomu používal (napr. lokálne protokoly alebo výnimky), je nefrologicky rozumné dôsledne monitorovať:
    <ul>
      <li>trend kreatinínu, diurézu a potrebu KRT,</li>
      <li>glykémiu (hlásená bola hypoglykémia),</li>
      <li>elektrolyty a acidobázickú rovnováhu,</li>
      <li>klinické známky hemolýzy,</li>
      <li>a zvážiť individuálne riziko (najmä výrazne zníženú renálnu funkciu, rizikovú hydratáciu a faktory podporujúce oxalátovú záťaž).</li>
    </ul>
  </li>
  <li><strong>Rizikové signály komunikovať</strong> multidisciplinárne (intenzivista, popáleninový tím, nefrológ), pretože nejde o „jemnú“ metabolickú diskusiu, ale o štúdiou podložený signál vyššej mortality v aktívnom ramene.</li>
</ol>

<h2>Zhrnutie v jednej vete</h2>

<p>Štúdia VICTORY ukázala, že <strong>vysokodávkovaný intravenózny vitamín C neprináša benefit</strong> a je spojený s <strong>vyššou 28-dňovou aj nemocničnou mortalitou</strong>, pričom súčasne pozorované nefrologické signály (AKI a vyššia potreba KRT) nie sú zanedbateľné.</p>

<hr>

<p><em><strong>Zdroj:</strong> Stoppe C, Hill A, Cancio LC, et al. High-Dose Intravenous Vitamin C and Mortality and Organ Dysfunction in Severe Burn Injury: The VICTORY Randomized Clinical Trial. <em>JAMA</em> (2026). <a href="https://doi.org/10.1001/jama.2026.10616" target="_blank" rel="noopener noreferrer">doi:10.1001/jama.2026.10616</a> (ClinicalTrials.gov NCT04138394). Spracované aj podľa súhrnu na portáli ReachMD „High-Dose Intravenous Vitamin C Fails To Improve Burn Outcomes“: <a href="https://reachmd.com/news/high-dose-intravenous-vitamin-c-fails-to-improve-burn-outcomes/2487460/" target="_blank" rel="noopener noreferrer">reachmd.com</a>.</em></p>
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
