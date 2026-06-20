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
    'title'        => 'Klug entscheiden v nefrológii: ktoré laboratórne vyšetrenia sú naozaj potrebné?',
    'slug'         => 'klug-entscheiden-nefrologia-laboratorne-vysetrenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Iniciatíva Klug entscheiden (DGIM) v nefrológii: ktoré laboratórne vyšetrenia naozaj menia manažment pacienta. Pozitívne odporúčania (kreatinín/eGFR, ACR, parametre CKD-MBD) aj to, čomu sa pri CKD vyhnúť.',
    'content'      => <<<'HTML'
<p>Iniciatíva <strong>„Klug entscheiden“</strong> (v preklade „rozumne sa rozhodovať“) – vedená spoločnosťou DGIM (Nemecká spoločnosť pre vnútorné lekárstvo) spolu s odbornými spoločnosťami – sa zameriava na to, aby sa v medicíne nerobil zbytočný „laboratórny skríning“ bez jasného klinického dôvodu, ale zároveň sa neprehliadli vyšetrenia, ktoré reálne menia manažment pacienta. V nefrológii je jadrom prístupu skoré zachytenie ochorenia a stratifikácia rizika pri CKD pomocou jednoduchých krvných a močových testov a vybraných parametrov minerálovo-kostného metabolizmu.</p>

<h2>1) Pre koho to platí (praktický rámec)</h2>

<p>Odporúčania sa viažu najmä na <strong>rizikových pacientov</strong> a na <strong>CKD (chronické ochorenie obličiek) od určitej úrovne eGFR</strong>, kde má laboratórium priamy vplyv na:</p>
<ul>
  <li>pravdepodobnosť orgánového poškodenia,</li>
  <li>kardiorenálne riziko,</li>
  <li>plán ďalšej diagnostiky alebo nefrologickej konzultácie.</li>
</ul>

<h2>2) Laboratóriá, ktoré „majú zmysel“: pozitívne odporúčania (P1 až P5)</h2>

<h3>P1. Skoré zachytenie: kreatinín + močový status v sledovaní rizikových pacientov</h3>

<p>Pri <strong>priebežných kontrolách</strong> u pacientov so zvýšeným kardiovaskulárnym a renálnym rizikom sa odporúča, aby súčasťou boli:</p>
<ul>
  <li><strong>stanovenie kreatinínu</strong> (z neho sa počíta eGFR),</li>
  <li><strong>močový status</strong> (orientačný záchyt abnormalít v moči).</li>
</ul>

<p>Špecifické schémy sledovania (napríklad intervaly) sa viažu na rizikovú skupinu; typicky ide o periodické kontroly (v dokumente sa uvádza interval raz za 1 – 2 roky pri rizikových skupinách).</p>

<h3>P2. Stratifikácia rizika pri CKD: eGFR + kvantifikácia proteinúrie/albuminúrie</h3>

<p>Ak ide o <strong>CKD s eGFR &lt; 60 ml/min/1,73 m²</strong>, odporúča sa popri eGFR aj:</p>
<ul>
  <li><strong>kvantitatívne stanovenie proteinúrie/albuminúrie</strong>, napríklad ako <strong>albumín-kreatinínový pomer (ACR)</strong> v spontánnom alebo zbernom moči.</li>
</ul>

<p>Dôvod je jednoduchý: samotná eGFR nemusí vysvetliť riziko. <strong>Rozsah albuminúrie/proteinúrie</strong> významne dopĺňa prognostiku (kardiorenálne výsledky aj priebeh ochorenia).</p>

<h3>P3. Minerálovo-kostný metabolizmus pri pokročilejšej CKD: Ca, P, iPTH, 25-OH vitamín D</h3>

<p>Pri <strong>CKD a eGFR &lt; 45 ml/min/1,73 m²</strong> sa odporúča aspoň raz doplniť a pri patologických nálezoch následne sledovať:</p>
<ul>
  <li><strong>sérové kalcium (Ca)</strong>,</li>
  <li><strong>sérový fosfor (P)</strong>,</li>
  <li><strong>intaktný PTH (iPTH)</strong>,</li>
  <li><strong>25-OH vitamín D3</strong>.</li>
</ul>

<p>Cieľom je zachytiť poruchy v rámci CKD-MBD (minerálová a kostná porucha pri CKD) včas, keď ešte vieme cielene ovplyvniť ďalší vývoj a znížiť riziká spojené s kostným a kardiovaskulárnym poškodením.</p>

<h3>P4. Laboratórium ako súčasť rozhodovania o kontraste: racionálne zvažovanie rizika</h3>

<p>Táto časť je síce „nefrologická“, ale nie je čisto o laboratóriách. Podstatou je, že pri <strong>vyššom stupni poruchy funkcie obličiek (CKD 4 – 5; eGFR &lt; 30 ml/min/1,73 m²)</strong> treba zvážiť diagnostický prínos kontrastného vyšetrenia oproti potenciálnym rizikám tak, aby nevznikalo <strong>systematické poddiagnostikovanie</strong>.</p>

<p>V praxi to súvisí s tým, že laboratórium (eGFR) je potrebné skôr ako vstup do rozhodnutia, nie ako „automatický reflex“ pred každým vyšetrením.</p>

<h3>P5. Prevencia infekcií cez pravidelnú kontrolu očkovania</h3>

<p>Opäť ide skôr o organizačno-preventívnu rovinu, ale pre nefrológiu je to dôležité: pri CKD a/alebo imunosupresii sa má pravidelne kontrolovať očkovací status. Nejde o laboratórne hodnoty, ale často sa rieši v rámci tej istej nefrologickej starostlivosti.</p>

<h2>3) Čomu sa vyhnúť (negatívne odporúčania) a čo to znamená pre „zmysluplné laboratórium“</h2>

<p>V dokumente sú aj negatívne odporúčania, ktoré nepovedia „aké laboratóriá robiť“, ale pomáhajú pochopiť logiku iniciatívy:</p>
<ul>
  <li><strong>Nevytvárať zbytočný režim zvýšeného príjmu tekutín len preto, aby sa „zlepšila funkcia obličiek“</strong> (žiadna automatická vysoká perorálna hydratácia na „prepláchnutie“).</li>
  <li><strong>Neplytvať klinickým časom ani nezaťažovať obličky diuretikami a tekutinami s cieľom „zabrzdiť“ alebo „zvrátiť“ akútne poškodenie</strong>, ak na to nie je jasná indikácia.</li>
  <li><strong>Lieky používať „šetriaco“</strong> – napríklad sa neodporúča pravidelné podávanie NSAID (nesteroidové antiflogistiká) u pacientov s hypertenziou alebo CKD.</li>
</ul>

<p>Pre laboratórnu prax z toho plynie jednoduchý princíp: keď liečbu neriadi jasná indikácia, ani laboratórne vyšetrenia sa nemajú robiť plošne bez očakávaného vplyvu na rozhodnutie.</p>

<h2>4) Praktické zhrnutie pre ambulanciu nefrológa</h2>

<p>Ak chceš zostaviť úsporný („lean“) nefrologický laboratórny balík v súlade s myšlienkou Klug entscheiden, typicky budeš vychádzať z týchto jadier:</p>
<ul>
  <li><strong>kreatinín → eGFR</strong> + <strong>močový status</strong> pri sledovaní rizikových pacientov,</li>
  <li>pri <strong>CKD &lt; 60</strong>: <strong>eGFR + kvantifikácia ACR/proteinúrie</strong>,</li>
  <li>pri <strong>CKD &lt; 45</strong>: <strong>Ca, fosfor, iPTH, 25-OH vitamín D3</strong>.</li>
</ul>

<p>Zvyšok má byť naviazaný na symptómy, riziko a konkrétnu klinickú otázku.</p>

<hr>

<p><em><strong>Zdroj:</strong> Klug-entscheiden-Empfehlungen in der Nephrologie (DGIM, s podporou DGfN), <em>Internist</em> 2017; publikované aj ako PDF odporúčaní. <a href="https://www.klug-entscheiden.com/fileadmin/user_upload/PDF/30KEE_in_der_Nephrologie.pdf" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
