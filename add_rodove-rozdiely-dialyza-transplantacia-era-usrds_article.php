<?php
/**
 * add_rodove-rozdiely-dialyza-transplantacia-era-usrds_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_rodove-rozdiely-dialyza-transplantacia-era-usrds_article.php"
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
    'title'        => 'Rodové rozdiely v dialýze a transplantácii: Európa vs USA podľa ERA Registry a USRDS',
    'slug'         => 'rodove-rozdiely-dialyza-transplantacia-era-usrds',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Porovnanie Európy a USA podľa ERA Registry a USRDS ukazuje výrazné rozdiely v incidencii a prevalencii KRT, v miere transplantácií aj v mortalite. Rozdiely medzi regiónmi sa zdajú byť nápadnejšie u žien než u mužov.',
    'content'      => <<<'HTML'
<p>Chronické zlyhávanie obličiek vedie k potrebe liečby obličkovej náhrady (KRT, <em>kidney replacement therapy</em>). V klinickej praxi však narážame na rozdiely medzi pohlaviami aj medzi krajinami, najmä v tom, kto sa na KRT dostane, aké sú šance na transplantáciu a aká je následná mortalita. Analýza publikovaná v <em>Nephrology Dialysis Transplantation</em> porovnáva Európu a USA práve v týchto parametroch a ukazuje, že rozdiely sú výraznejšie najmä u žien.</p>

<h2>Čo porovnávali</h2>

<p>Autori analyzovali dáta za rok <strong>2022</strong> z dvoch veľkých registrov:</p>

<ul>
  <li><strong>ERA Registry</strong> pre Európu,</li>
  <li><strong>USRDS</strong> pre USA.</li>
</ul>

<p>Sledovali štyri hlavné výstupy, vždy osobitne pre ženy a mužov:</p>

<ol>
  <li><strong>incidenciu KRT</strong>, teda koľko ľudí začalo KRT,</li>
  <li><strong>prevalenciu KRT</strong>, teda koľko ľudí bolo na KRT ku koncu roka,</li>
  <li><strong>mieru transplantácií</strong>,</li>
  <li><strong>mortalitu na KRT</strong>.</li>
</ol>

<h2>Hlavné výsledky</h2>

<h3>1) Incidencia KRT: USA výrazne vyššie, rozdiel väčší u žien</h3>

<p>V roku 2022 bola <strong>incidencia KRT v USA 388,7 na milión obyvateľov</strong>, kým v Európe <strong>146,2 na milión obyvateľov</strong>. To predstavuje približne <strong>2,7-násobný rozdiel</strong>.</p>

<p>Rozdiel bol ešte výraznejší u žien:</p>

<ul>
  <li><strong>ženy v USA</strong> mali incidenciu KRT <strong>3,2-krát vyššiu</strong> než ženy v Európe,</li>
  <li><strong>muži v USA</strong> mali incidenciu KRT <strong>2,4-krát vyššiu</strong> než muži v Európe.</li>
</ul>

<p>Podiel žien, ktoré iniciovali KRT, bol v Európe nižší:</p>

<ul>
  <li><strong>35 %</strong> iniciátorov v Európe,</li>
  <li><strong>41 %</strong> iniciátorov v USA.</li>
</ul>

<h3>2) Trendy 2013 až 2022: v Európe stabilita u žien, rast u mužov</h3>

<p>V Európe bola incidencia KRT u žien medzi rokmi 2013 a 2022 v podstate <strong>stabilná</strong> (+0,1 % ročne), zatiaľ čo u mužov <strong>stúpala</strong> (+1,1 % ročne).</p>

<p>V USA rástla incidencia KRT podobne u žien (+0,2 % ročne) aj u mužov (+0,3 % ročne).</p>

<h3>3) Prevalencia KRT: USA približne dvojnásobok Európy</h3>

<p>Ku dňu 31. 12. 2022 bola <strong>prevalencia KRT v USA 2444,2 na milión obyvateľov</strong>, zatiaľ čo v Európe <strong>1218,6 na milión obyvateľov</strong>, teda približne <strong>2-násobok</strong>.</p>

<p>Podľa pohlavia:</p>

<ul>
  <li>prevalencia u žien bola v USA <strong>2,2-krát vyššia</strong>,</li>
  <li>u mužov <strong>1,9-krát vyššia</strong>.</li>
</ul>

<p>Aj tu tvorili ženy v Európe menší podiel populácie na KRT:</p>

<ul>
  <li><strong>38 %</strong> v Európe,</li>
  <li><strong>41 %</strong> v USA.</li>
</ul>

<h3>4) Transplantácie: USA vyššie miery, podiel žien podobný</h3>

<p>Miera transplantácií bola v USA <strong>79,1 na milión obyvateľov</strong> a v Európe <strong>45,4 na milión obyvateľov</strong>, teda približne <strong>1,7-násobne vyššia</strong>.</p>

<p>Pri rozdelení podľa pohlavia:</p>

<ul>
  <li>u žien bola miera transplantácií v USA približne <strong>1,9-krát vyššia</strong>,</li>
  <li>u mužov <strong>1,7-krát vyššia</strong>.</li>
</ul>

<p>Podiel žien medzi príjemcami transplantácie bol v oboch regiónoch podobný:</p>

<ul>
  <li><strong>37 %</strong> v Európe,</li>
  <li><strong>39 %</strong> v USA.</li>
</ul>

<h3>5) Mortalita na KRT: USA vyššia, vzťah k pohlaviu sa líši podľa regiónu</h3>

<p>Celková mortalita na KRT bola v USA <strong>145,0 na 1000 paciento-rokov</strong>, zatiaľ čo v Európe <strong>100,5 na 1000 paciento-rokov</strong>, teda približne <strong>1,5-násobne vyššia</strong>.</p>

<p>Pri porovnaní pohlaví sa ukázal rozdielny vzorec podľa regiónu:</p>

<ul>
  <li><strong>v Európe</strong> mali ženy mortalitu <strong>93,7/1000 paciento-rokov</strong>, muži <strong>104,6/1000 paciento-rokov</strong>, teda ženy nižšiu,</li>
  <li><strong>v USA</strong> mali ženy mortalitu <strong>148,9/1000 paciento-rokov</strong>, muži <strong>142,2/1000 paciento-rokov</strong>, teda ženy vyššiu.</li>
</ul>

<h2>Ako si to preniesť do praxe</h2>

<p>Táto štúdia neidentifikuje jeden konkrétny biologický mechanizmus. Skôr dokumentuje rozdiely v poskytovaní a priebehu KRT medzi regiónmi a medzi ženami a mužmi. Pre klinickú prax z toho vyplýva niekoľko dôležitých otázok:</p>

<ol>
  <li><strong>Kto sa dostane na KRT a kedy?</strong> Nižší podiel žien medzi iniciátormi KRT v Európe môže odrážať rozdiely v dostupnosti, rozhodovaní, komorbiditách alebo v referovaní pacientov.</li>
  <li><strong>Aký je výsledok po začatí KRT?</strong> Vyššia mortalita v USA môže naznačovať rozdiely v komorbiditách, zložení populácie aj v samotnom procese liečby.</li>
  <li><strong>Prečo sa mortalita žien líši podľa regiónu?</strong> Tento nález podporuje hypotézu, že pohlavie pravdepodobne pôsobí cez viacero mechanizmov, ktoré nemusia byť rovnaké v rôznych zdravotníckych systémoch.</li>
</ol>

<p>V ambulantnej nefrológii sa to dá pretaviť do konkrétnych kontrolných bodov: včasné plánovanie KRT, dôsledná práca s komorbiditami a systematické sledovanie výsledkov liečby u oboch pohlaví.</p>

<h2>Limitácie, ktoré treba mať na pamäti</h2>

<p>Aj keď štúdia využíva veľké registre, porovnania naprieč kontinentmi sú vždy ovplyvnené rozdielmi v:</p>

<ul>
  <li>definíciách a kódovaní,</li>
  <li>dostupnosti a politike transplantácií,</li>
  <li>manažmente komorbidít,</li>
  <li>načasovaní prechodu do KRT.</li>
</ul>

<p>Výsledky je preto vhodnejšie chápať ako <strong>epidemiologický signál</strong>, nie ako priame kauzálne vysvetlenie.</p>

<h2>Záver</h2>

<p>V roku 2022 boli v USA vyššie incidencie aj prevalencie KRT, vyššia miera transplantácií a zároveň vyššia mortalita na KRT v porovnaní s Európou. Zaujímavé je, že rozdiely medzi regiónmi boli väčšie u žien a vzťah medzi pohlavím a mortalitou na KRT sa medzi Európou a USA líšil.</p>

<hr>

<p><em><strong>Zdroj:</strong> <em>Nephrology Dialysis Transplantation</em>, článok „Kidney replacement therapy for men and women according to the ERA Registry and the USRDS“. <a href="https://academic.oup.com/ndt/article/41/6/1082/8307507" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
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
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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