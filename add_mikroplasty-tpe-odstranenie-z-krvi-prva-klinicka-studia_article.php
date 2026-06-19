<?php
/**
 * add_mikroplasty-tpe-odstranenie-z-krvi-prva-klinicka-studia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE -> idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_mikroplasty-tpe-odstranenie-z-krvi-prva-klinicka-studia_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// -- Data clanku ---------------------------------------------------------------

$articles = [];

$articles[] = [
  'title'        => 'Môžeme z tela odstrániť mikroplasty? Čo naznačuje prvá klinická štúdia o terapeutickej plazmovej výmene',
    'slug'         => 'mikroplasty-tpe-odstranenie-z-krvi-prva-klinicka-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prvá klinická štúdia ukazuje, že terapeutická plazmová výmena môže znížiť merateľnú koncentráciu mikroplastov v krvi, najmä pri vyššom zaťažení. Zatiaľ však ide predovšetkým o dôkaz mechanizmu, nie o dôkaz klinického benefitu.',
    'content'      => <<<'HTML'
<p>Mikroplasty a nanoplasty už nie sú iba témou ekológie. Ich prítomnosť v biologických tekutinách otvára praktickú klinickú otázku: <strong>má zníženie cirkulujúcich častíc v krvi reálny zdravotný význam</strong>?</p>

<p>Medscape zverejnil sumár štúdie, ktorá predstavuje dôležitý míľnik: <strong>terapeutická plazmová výmena (TPE) dokázala znížiť množstvo merateľných mikroplastov v krvi</strong>. Zároveň však ide predovšetkým o dôkaz mechanizmu, nie o preukázanie klinického prínosu pre pacienta.</p>

<h2>Čo presne štúdia hodnotila</h2>

<p>Autori analyzovali <strong>174 procedúr TPE u 114 pacientov</strong>. Hodnotený bol vzťah medzi procedúrou a koncentráciou mikroplastov meranou testom <strong>PlasticTox</strong>, vždy bezprostredne <strong>pred a po výkone</strong>.</p>

<p>Ciele boli dva:</p>

<ol>
  <li>overiť, či sa mikroplasty separujú do plazmovej frakcie, a sú teda teoreticky odstrániteľné cez TPE,</li>
  <li>zistiť, či TPE vedie k merateľnému poklesu cirkulujúcich častíc.</li>
</ol>

<h2>Hlavný výsledok: pokles pri vysokom zaťažení, nejednotný efekt pri nižších hodnotách</h2>

<p>Pri vyššom východiskovom zaťažení (v kategórii približne <strong>≥ 20/100 µl</strong>) došlo po TPE k výraznému poklesu mikroplastov, v časti prípadov o viac ako polovicu.</p>

<p>Pri nižších východiskových hodnotách bol obraz nejednotný:</p>

<ul>
  <li>v niektorých intervaloch nebol pokles štatisticky jednoznačný,</li>
  <li>pri ešte nižších hladinách sa po TPE pozoroval aj signifikantný nárast nameraných hodnôt.</li>
</ul>

<p>Odborné komentáre naznačujú, že časť častíc sa počas TPE odstráni, no iná časť sa môže počas procesu pridávať. Ako možný mechanizmus sa uvádza kontaminácia materiálmi použitými pri manipulácii s krvou, vrátane ohrevu krvi a kontaktu s jednorazovými plastovými komponentmi.</p>

<h2>Najdôležitejšia otvorená otázka: znamená to klinický benefit?</h2>

<p>Kľúčová nezodpovedaná otázka je, či pokles merateľných mikroplastov v krvi vedie aj k poklesu chorobnosti alebo iných klinických rizík.</p>

<h3>1) Krv môže byť iba prechodný kompartment</h3>
<p>Zníženie v krvi nemusí znamenať rovnaký efekt v tkanivách. Častice sa môžu medzi kompartmentmi presúvať a krvný signál môže byť iba prechodný.</p>

<h3>2) Tkanivový burden sa hodnotí ťažšie</h3>
<p>To, čo meria krvný test, nemusí korelovať s tým, čo je dlhodobo uložené v orgánoch, kde môže byť biologický dopad väčší.</p>

<h3>3) Trvanie účinku zostáva nejasné</h3>
<p>Hoci autori uvádzajú aj kontrolné meranie po 30 dňoch, pre straty pacientov pri sledovaní nebolo možné urobiť robustný záver o dlhodobom efekte.</p>

<h3>4) Problém nanoplastov</h3>
<p>Podľa článku test PlasticTox nezachytí kompletne spektrum menších častíc, najmä časť nanoplastov, ktoré môžu byť biologicky aktívnejšie a ľahšie prechádzať biologickými bariérami.</p>

<h2>Relevancia pre nefrológiu</h2>

<p>Pre nefrológiu je téma dôležitá skôr konceptuálne ako terapeuticky. TPE je metóda, ktorú nefrológia pozná, no tento výsledok <strong>sa nemá interpretovať ako odporúčanie na rutinné „liečenie mikroplastov“</strong>, a to ani u pacientov s pokročilým postihnutím obličiek alebo na dialýze.</p>

<p>Správna interpretácia dát je nasledovná:</p>

<ul>
  <li>existuje mechanistický signál, že časť častíc je možné z cirkulácie odstrániť,</li>
  <li>zároveň však procesné detaily môžu výsledok ovplyvniť alebo čiastočne neutralizovať,</li>
  <li>klinický prospech zatiaľ nie je preukázaný.</li>
</ul>

<h2>Riziká a praktické limity TPE</h2>

<p>TPE je invazívny výkon s vlastnými rizikami: cievny prístup, hemodynamická záťaž a komplikácie súvisiace s náhradou plazmy. Aj pri mechanistickom úspechu preto platí, že metóda musí byť hodnotená primárne podľa klinických koncových ukazovateľov, nie iba podľa laboratórneho poklesu markerov.</p>

<h2>Kam sa vývoj pravdepodobne posunie</h2>

<p>Ďalší výskum bude musieť zlepšiť analytiku a charakterizáciu častíc (napr. Ramanova spektroskopia, laserom riadená infračervená spektroskopia, GC-MS, elektrónová mikroskopia) a prepojiť meranie s klinickými dôsledkami.</p>

<p>V článku sa spomína aj plánovaná rozsiahla iniciatíva STOMP (2026), ktorej cieľom je posunúť meranie, charakterizáciu aj stratégie odstraňovania mikroplastov na reprodukovateľnú vedeckú úroveň.</p>

<h2>Zhrnutie pre prax bez prehnaných nádejí</h2>

<ul>
  <li><strong>TPE môže znížiť cirkulujúce mikroplasty</strong>, najmä pri vyššom východiskovom zaťažení.</li>
  <li>Efekt <strong>nie je konzistentný vo všetkých pásmach vstupných hodnôt</strong> a môže byť ovplyvnený kontamináciou počas procedúry.</li>
  <li>Zatiaľ <strong>chýba dôkaz klinického benefitu</strong> vo forme lepších tvrdých alebo pacientsky relevantných výsledkov.</li>
  <li>Pred akoukoľvek klinickou implementáciou bude nutné preukázať vzťah medzi poklesom markerov, tkanivovým burdenom a reálnym zdravotným prínosom.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Medscape: "Now We Can Remove Microplastics From the Body. Does It Help?" <a href="https://www.medscape.com/viewarticle/now-we-can-remove-microplastics-body-does-it-help-2026a1000k7f" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// -- Vkladanie do databazy -----------------------------------------------------

$inserted = 0;
$skipped = 0;
$errors = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri clanku "' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "----------------------------------------------\n";
    echo 'Migracia clanku: ' . ($articles[0]['title']) . "\n";
    echo "----------------------------------------------\n";
    echo "Vysledok: $inserted z $total clankov bolo vlozenych.\n";
    echo "Preskoceni (slug uz existuje): $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "----------------------------------------------\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migracia clanku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migracia clanku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Vysledok:</strong> <?= $inserted ?> z <?= $total ?> clankov bolo vlozenych. <?= $skipped ?> preskocenych (slug uz existuje).</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty aviz zaradenych: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="index.php" class="btn-primary">← Spat na hlavnu stranku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Sprava clankov</a>
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
