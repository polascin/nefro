<?php
/**
 * add_anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi_article.php"
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
    'title'        => 'Anémia pri CKD 2026 prakticky: algoritmus od diagnostiky po ESA a HIF-PHI podľa KDOQI US Commentary',
    'slug'         => 'anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický algoritmus manažmentu anémie pri CKD podľa KDOQI US Commentary ku KDIGO 2026: potvrdenie anémie, hľadanie korektibilných príčin, racionálne dopĺňanie železa s jasnými hranicami, opatrnosť pri ferric carboxymaltose a zdieľané rozhodovanie pri ESA/HIF-PHI.',
    'content'      => <<<'HTML'
<p>Anémia pri chronickom ochorení obličiek (CKD) nie je len problém „nízkeho Hb“. Zmysluplný postup začína potvrdením anémie a hľadaním jej príčiny, pokračuje cieleným doplnením železa a až potom sa rozhoduje o ESA alebo HIF-PHI tak, aby sa minimalizovalo riziko aj počet zbytočných transfúzií.</p>

<p>Nižšie je praktická verzia komentára k odporúčaniam KDIGO 2026, upravená do podoby, ktorá sa dá použiť v ambulancii aj na dialýze ako krok za krokom vedený postup.</p>

<h2>1) Kedy začať a čo vyšetriť hneď</h2>

<h3>Vstupný bod</h3>

<p>Anémiu u pacientov s CKD vyšetruj pri:</p>

<ul>
  <li>zhoršení tolerancie záťaže, únave alebo dyspnoe,</li>
  <li>poklese hemoglobínu v sledovaní,</li>
  <li>zmene klinického stavu, napríklad pri infekcii, krvácaní alebo zhoršení nutričného stavu.</li>
</ul>

<h3>Povinný základný panel</h3>

<p>V praxi zvyčajne stačí:</p>

<ul>
  <li><strong>CBC</strong> (Hb, MCV, RDW a ďalšie parametre),</li>
  <li><strong>retikulocyty</strong>,</li>
  <li><strong>ferritín</strong>,</li>
  <li><strong>TSAT</strong>,</li>
  <li>podľa klinického kontextu aj zápal alebo infekcia, hemolýza, nutričné faktory a prípadne skríning krvácania.</li>
</ul>

<p>Dôležitá myšlienka komentára je jednoduchá: manažment anémie v CKD je tímová práca zameraná na príčinu. Ak železo nedáva zmysel, netreba ho opakovane podávať ani nasadzovať ESA bez jasnej logiky.</p>

<h2>2) Železo: kedy riešiť deficit a kedy ho dočasne nechať tak</h2>

<h3>2.1 CKD G5HD: preferencia intravenózneho železa</h3>

<p>U pacientov na hemodialýze je praktickým cieľom rýchla korekcia deficitu, pretože perorálne železo býva menej účinné a horšie manažovateľné. Komentár podporuje proaktívnejší intravenózny prístup, pričom ako praktický spúšťač uvádza kombináciu:</p>

<ul>
  <li><strong>ferritín ≤ 500 ng/ml</strong> a <strong>TSAT ≤ 30 %</strong>.</li>
</ul>

<p>Ak má pacient na HD nízky TSAT a nie je výrazne „nasýtený“ železom, je racionálne siahnuť po IV železe namiesto čakania na efekt ESA.</p>

<h3>2.2 Bezpečnostný stop sign pri vysokých hodnotách</h3>

<p>Veľmi praktický bod komentára je hranica, pri ktorej je rozumné železo dočasne zadržať. Rutinné podávanie železa sa odporúča prerušiť, ak je:</p>

<ul>
  <li><strong>ferritín &gt; 700 ng/ml</strong> alebo</li>
  <li><strong>TSAT ≥ 40 %</strong>.</li>
</ul>

<p>Táto brzda pomáha predísť situácii, keď sa železo podáva opakovane len preto, že anémia pretrváva, bez toho, aby bol jasne zhodnotený celý obraz pacienta.</p>

<h3>2.3 Non-HD CKD: individualizácia podľa ferritínu a TSAT</h3>

<p>Mimo hemodialýzy sa rozhodovanie opiera o ferritín a TSAT. IV aj perorálne železo môžu mať miesto, no výber závisí od:</p>

<ul>
  <li>tolerancie a dostupnosti,</li>
  <li>rýchlosti potreby korekcie,</li>
  <li>toho, či je deficit skôr absolútny alebo maskovaný zápalom.</li>
</ul>

<p>V tejto skupine je dôležité myslieť aj na iné príčiny anémie, ak výsledky nepasujú iba na CKD a deficit železa.</p>

<h2>3) Špecifické upozornenie pre ferric carboxymaltose: hypofosfatémia</h2>

<p>Tento bod v každodennej praxi skutočne mení rozhodovanie. Komentár upozorňuje, že najvýraznejšie riziko hypofosfatémie sa spája s <strong>ferric carboxymaltose (FCM)</strong>.</p>

<p>Prakticky to znamená:</p>

<ul>
  <li>ak sa po IV železe objaví nevysvetlená slabosť, bolesti kostí alebo iné nejasné ťažkosti, myslieť aj na <strong>fosfát</strong>,</li>
  <li>pri opakovaných dávkach u rizikových pacientov zaradiť fosfát do monitorovania,</li>
  <li>pri potvrdení hypofosfatémie riešiť korekciu fosfátu a prehodnotiť typ IV železa.</li>
</ul>

<h2>4) ESA a HIF-PHI: najprv príčina, potom cieľ Hb</h2>

<h3>4.1 Spoločný princíp</h3>

<p>ESA aj HIF-PHI majú zmysel až vtedy, keď:</p>

<ul>
  <li>je anémia skutočne CKD-dependentná,</li>
  <li>sú riešené korektibilné príčiny, najmä deficit železa,</li>
  <li>a rozhodnutie je zdieľané s pacientom s ohľadom na prínosy a riziká vrátane rizika transfúzií.</li>
</ul>

<p>Hb nie je jediné rozhodovacie kritérium. Rozhoduje aj symptomatika, komorbidity a bezpečnostný profil liečby.</p>

<h3>4.2 Kedy typicky začať ESA</h3>

<p>Pre CKD G5D komentár uvádza praktickú iniciáciu pri:</p>

<ul>
  <li><strong>Hb približne ≤ 9,0 až 10,0 g/dl</strong>.</li>
</ul>

<h3>4.3 Kam cieliť pri udržiavaní</h3>

<p>Pri udržiavacej liečbe sa odporúča držať <strong>Hb pod hornou hranicou približne 11,5 g/dl</strong>.</p>

<p>Ak Hb rastie príliš vysoko, ESA treba upraviť a zároveň znovu skontrolovať, či sa neprehliadla iná príčina anémie.</p>

<h3>4.4 ESA verzus HIF-PHI</h3>

<p>Po riešení korektibilných príčin je ESA spravidla prvou líniou a HIF-PHI sa volia opatrnejšie podľa rizík a klinickej situácie.</p>

<h2>5) Rýchly praktický algoritmus na jednu stranu</h2>

<ol>
  <li><strong>Potvrď anémiu</strong> pomocou Hb, retikulocytov a základného obrazu s MCV/RDW.</li>
  <li><strong>Ferritín a TSAT</strong> sú vodiace parametre.</li>
  <li><strong>Hľadaj korektibilné príčiny</strong>, najmä deficit železa, zápal, krvácanie a podľa kontextu aj iné hematologické alebo nutričné príčiny.</li>
  <li><strong>Železo:</strong> pri HD je racionálne IV železo pri ferritíne ≤ 500 a TSAT ≤ 30; rutinné železo zadržať pri ferritíne &gt; 700 alebo TSAT ≥ 40.</li>
  <li><strong>FCM používaj opatrne</strong> a pri príznakoch alebo opakovanom podávaní sleduj fosfát.</li>
  <li><strong>Až potom ESA alebo HIF-PHI</strong>, vždy v zdieľanom rozhodovaní.</li>
  <li><strong>Hb drž pod hornou hranicou približne 11,5 g/dl</strong> a dávkovanie upravuj podľa trendu a symptómov.</li>
</ol>

<h2>Záver</h2>

<p>Praktická verzia komentára sa dá zhrnúť jednou vetou: pri anémii v CKD nerob nič naslepo. Najprv diagnostika a príčiny, potom cielené železo s jasnými bezpečnostnými hranicami a až následne ESA alebo HIF-PHI v cieli, ktorý minimalizuje riziko.</p>

<hr>

<p><em><strong>Zdroj:</strong> KDOQI US Commentary on the KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in CKD (American Journal of Kidney Diseases, full text). <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
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