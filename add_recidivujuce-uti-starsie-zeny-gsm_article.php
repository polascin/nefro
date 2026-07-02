<?php
/**
 * add_recidivujuce-uti-starsie-zeny-gsm_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): recidivujúce UTI u starších
 * žien a urogenitálny syndróm menopauzy (GSM) — diagnostika, antibiotiká,
 * prevencia bez nich. Slovenské spracovanie zdroja (Medscape InDiscussion
 * podcast). Pôvodní autori v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_recidivujuce-uti-starsie-zeny-gsm_article.php"
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
    'title'        => 'Opakované infekcie močových ciest u starších žien a prepojenie s urogenitálnym syndrómom menopauzy (GSM): diagnostika, antibiotiká a prevencia bez nich',
    'slug'         => 'recidivujuce-uti-starsie-zeny-gsm',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prístup k recidivujúcim infekciám močových ciest u starších žien: kedy potvrdiť infekciu a kedy nie, prečo pozitívny nález automaticky neznamená antibiotiká, a prevencia bez antibiotík — vrátane kľúčovej úlohy lokálnych vaginálnych estrogénov pri urogenitálnom syndróme menopauzy (GSM).',
    'content'      => <<<'HTML'
<p>Opakované infekcie močových ciest (recurrent UTI) sú u starších žien časté a klinicky náročné.
Problém nie je len v tom, že je potrebné „potvrdiť infekciu“, ale aj v tom, že časť ťažkostí
napodobňuje infekciu bez toho, aby išlo o aktívnu bakteriálnu cystitídu. Z toho vyplýva riziko
zbytočnej antibiotickej liečby, ktorá má nepriaznivé dôsledky pre pacientku aj pre antimikrobiálnu
rezistenciu.</p>

<p>V tomto podcastovom rozhovore na Medscape (InDiscussion) sa moderátorka rozpráva s urologickou
expertkou Dr. Melissou R. Kaufmanovou o praktickom prístupe k diagnostike a manažmentu recidivujúcich
UTI u starších žien, s dôrazom na úlohu urogenitálneho syndrómu menopauzy (GSM) a na možnosti prevencie
bez antibiotík.</p>

<h2>1) Ako pristupovať k žene s recidivujúcimi UTI</h2>
<p>Podľa rozhovoru je prvým krokom cielene zamerať anamnézu na symptómy a kontext. Dôležité sú najmä:</p>
<ul>
  <li>predchádzajúce urologické a gynekologické zákroky,</li>
  <li>východiskové symptómy z dolných močových ciest,</li>
  <li>črevné ťažkosti ako možný zavádzajúci faktor (confounder),</li>
  <li>vzťah symptómov k spúšťačom a k predošlej liečbe.</li>
</ul>
<p>V diagnostike je podľa expertky kľúčový aj gynekologický (pelvický) vyšetrovací prvok, lebo môže
odhaliť alternatívne príčiny alebo prispievajúce faktory, ako sú vaginálna atrofia pri GSM, uretrálne
divertikulum alebo prolaps panvových orgánov.</p>

<h2>2) Diagnostická logika: kedy myslieť na UTI a kedy nie</h2>
<p>Rozhovor zdôrazňuje, že pri podozrení na akútnu cystitídu má <strong>negatívny výsledok moču</strong>
(bez nitritov a bez leukocytov v moči) významnú negatívnu prediktívnu hodnotu, takže môže pomôcť
infekciu skôr vylúčiť.</p>
<p>Zároveň sa rieši, že pri vzorkách zo stredného prúdu moču („clean catch“) je kontaminácia častá,
čo môže viesť k zbytočnej antibiotickej liečbe. Pri nejasnosti rozhovor odporúča zvážiť
<strong>katetrizačný odber</strong> pre presnejšie posúdenie.</p>
<p>Pri hodnotení močového nálezu sa uvádza význam pyúrie, konkrétne <strong>viac ako 5 leukocytov/HPF</strong>
pri mikroskopii, a pozornosť na rozdiel medzi:</p>
<ul>
  <li>bakteriálnou cystitídou a</li>
  <li>stavmi, ktoré môžu UTI napodobňovať (intersticiálna cystitída, syndróm bolestivého mechúra,
      myofasciálne panvové ťažkosti, hyperaktívny močový mechúr).</li>
</ul>

<h2>3) Prečo antibiotiká pri „pozitívnom náleze“ nie sú automaticky správne</h2>
<p>Jednou z hlavných myšlienok rozhovoru je, že aj pozitívny nález v moči (napr. nitrity + leukocyty)
nemusí znamenať klinicky relevantnú infekciu. Podľa expertky môže ísť aj o bežnú komenzálnu prítomnosť
baktérií v prostredí dolných močových ciest.</p>
<p>Zároveň sa rieši, že starší pacienti môžu mať zmenené vnímanie symptómov, takže ani „zjavná“
baktériúria nemusí korelovať s klinickým obrazom dyzúrie.</p>

<h2>4) Nadužívanie antibiotík treba riešiť systémovo: urobióm, stewardship a nadmerná diagnostika</h2>
<p>Rozhovor dáva do súvisu urobióm (mikrobióm močových ciest) a riziko systémovej dysbiózy pri častom
podávaní antibiotík. Cieľom nie je len „vyhnúť sa <em>C. difficile</em>", ale mať širší pohľad na vplyv
antibiotík na mikrobiotu vrátane možných dlhodobých následkov.</p>
<p>Prakticky sa to prejaví tak, že podľa rozhovoru nie je podporený prístup „len to predĺžim, rozšírim
spektrum alebo zvýšim dávku" pri recidívach, pokiaľ na to nie sú dôkazy. Ide práve o ten typ manažmentu,
ktorý môže zvyšovať selekčný tlak a zhoršovať rezistenciu.</p>

<h2>5) Prevencia recidivujúcich UTI bez (automatického) antibiotika</h2>
<p>Pri prevencii recidivujúcich UTI sa v rozhovore zdôrazňujú možnosti, ktoré sú súčasťou aktuálneho
smerovania odporúčaní (guidelines) pre recidivujúce UTI.</p>

<h3>Hydratácia</h3>
<p>Jedným z krokov s najnižším rizikom a prakticky odporúčaných je <strong>príjem tekutín približne
1,5 litra vody denne</strong>, čo môže pomôcť znížiť riziko infekcie.</p>

<h3>Brusnice a D-manóza</h3>
<p>Rozhovor vysvetľuje mechanizmus väzby <em>E. coli</em> na bunky cez fimbrie a manózové receptory.
D-manóza a proantokyanidíny z brusníc majú teoreticky obmedzovať schopnosť baktérií viazať sa
a kolonizovať.</p>

<h3>Metenamín hippurát</h3>
<p>Odporúčaný je aj <strong>metenamín hippurát</strong>, ktorý sa v kyslom prostredí mení na
bakteriostatickú zlúčeninu (formaldehyd + amoniak). V praxi sa často kombinuje s vitamínom C, aby sa
podporila kyslosť moču.</p>

<h3>Lokálne vaginálne estrogény pri GSM</h3>
<p>Najdôležitejším preventívnym pilierom je v tomto rozhovore <strong>lokálny nízkodávkový vaginálny
estrogén</strong> u žien s GSM. Rozhovor opisuje GSM ako spektrum zmien pri poklese estrogénov
a androgénov, s vplyvom na:</p>
<ul>
  <li>vaginálnu sliznicu (atrofia, znížená vlhkosť, krehkosť),</li>
  <li>pH a mikroprostredie,</li>
  <li>a v dôsledku toho aj vyššiu náchylnosť na recidivujúce UTI.</li>
</ul>
<p>Vysvetlenie je postavené na strate ochranných laktobacilov pri hypoestrogénnom stave, čo umožní
premnoženie patogénov a ich prístup do močových ciest.</p>

<h2>6) Nefrologický pohľad: prečo by nás to malo zaujímať</h2>
<p>Aj keď podcast rieši primárne urologickú a gynekologickú perspektívu, nefrologicky je to relevantné
z dvoch dôvodov:</p>
<ol>
  <li>U starších pacientov s CKD často opakovane vznikajú epizódy symptómov „podobných UTI“, kde
      rozhodnutie antibiotiká verzus neinfekčný stav býva zásadné.</li>
  <li>Pacienti s CKD môžu byť zraniteľnejší voči nežiaducim účinkom antibiotík, polyfarmácii a zmenám
      nutričného alebo mikrobiómového prostredia.</li>
</ol>
<p>Pri nefrologickej starostlivosti preto dáva zmysel prepojiť urologické odporúčania s nefrologickým
princípom rozvážnosti: potvrdiť infekciu čo najpresnejšie podľa kliniky a výsledkov moču a pri
recidívach aktívne riešiť prispievajúce stavy, najmä GSM, aby sa antibiotiká nemuseli používať „len
zo zvyku".</p>

<hr>

<p><em><strong>Zdroj:</strong> Anne Lenore Ackerman, Melissa R. Kaufman, „Recurrent UTIs in Older Women
and Association With Genitourinary Syndrome of Menopause (GSM)", <em>Medscape InDiscussion: UTI
podcast</em> (2026).
<a href="https://www.medscape.com/ca8/p04/podcast-uti-s1-ep2-2026a1000hdf" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_uti_gsm newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_uti_gsm pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_uti_gsm pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_uti_gsm migration error: ' . $e->getMessage());
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
