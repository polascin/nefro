<?php
/**
 * add_farmakologicka-liecba-obezity-pokrocile-ckd-dialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_farmakologicka-liecba-obezity-pokrocile-ckd-dialyza_article.php"
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
    'title'        => 'Farmakologická liečba obezity u pacientov s pokročilým CKD a na dialýze: praktické dávkovanie, dialyzačné špecifiká a bezpečnosť',
    'slug'         => 'farmakologicka-liecba-obezity-pokrocile-ckd-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prehľad farmakoterapie obezity pri pokročilom CKD a na dialýze: dávkovanie a dialyzačné špecifiká naltrexónu, topiramátu, bupropiónu, orlistatu a agonistov GLP-1 (vrátane tirzepatidu) a bezpečnostné upozornenia.',
    'content'      => <<<'HTML'
<p>Obezita je v nefrológii špecifická tým, že zhoršuje metabolické a kardiovaskulárne riziká a súčasne komplikuje manažment chronického ochorenia obličiek (CKD). Pri pokročilom CKD, a najmä u pacientov na dialýze, je farmakoterapia zaujímavá ako jedna z možných „odbočiek“ na ceste k lepšej kondícii a potenciálne aj k lepšej spôsobilosti na transplantáciu. Praktickým problémom však býva, že mnohé lieky sa vylučujú obličkami alebo ich farmakokinetiku menia zmeny glomerulárnej filtrácie (GFR) a dialyzačné parametre.</p>

<p>Nasledujúci prehľad zhŕňa kľúčové praktické body z dostupného fulltextového materiálu (najmä sekciu venovanú liekom na redukciu hmotnosti), so zameraním na:</p>

<ul>
  <li>čo je významné pri <strong>GFR &lt; 30 ml/min/1,73 m²</strong>,</li>
  <li>čo mení <strong>dialýza</strong> (odstránenie lieku),</li>
  <li>ako nastaviť <strong>titráciu a dávkovanie</strong>,</li>
  <li>na čo myslieť pri <strong>nežiaducich účinkoch a kontraindikáciách</strong>.</li>
</ul>

<h2>Všeobecné princípy pri liečbe obezity u CKD a ESKD</h2>

<p>Pri pokročilom CKD je rozumné pri každom lieku uvažovať o troch rovinách:</p>

<ol>
  <li><strong>Eliminácia:</strong> je liek prevažne metabolizovaný v pečeni a obličky účinne „obchádza“, alebo je významne závislý od renálnej exkrécie?</li>
  <li><strong>Dialýza:</strong> je liek alebo jeho aktívne metabolity odstrániteľné dialýzou, a ak áno, v akej miere?</li>
  <li><strong>Titračný režim a bezpečnostné riziká:</strong> aké sú najčastejšie gastrointestinálne ťažkosti, riziká pre centrálny nervový systém, metabolická acidóza, riziko pankreatitídy či riziká špecifické pre endokrinné nádory?</li>
</ol>

<p>Materiál sa k týmto bodom pri jednotlivých liekoch vyjadruje veľmi konkrétne. Skratkou ESKD sa označuje terminálne (konečné) štádium zlyhania obličiek.</p>

<h2>Naltrexón (v kombinácii) a špecifiká pri CKD a ESKD</h2>

<p>Perorálny naltrexón je charakterizovaný takto:</p>

<ul>
  <li><strong>metabolizmus v pečeni</strong>,</li>
  <li><strong>exkrécia obličkami</strong>,</li>
  <li><strong>dialýzou sa neodstraňuje</strong>.</li>
</ul>

<p><strong>Dávkovanie:</strong></p>

<ul>
  <li>udržiavacia liečba: <strong>16 mg dvakrát denne v kombinácii so 180 mg bupropiónu</strong>,</li>
  <li>začiatok: <strong>12,5 mg/deň</strong>, opatrne titrovať na <strong>25 mg/deň</strong>, prípadne v dvoch denných dávkach.</li>
</ul>

<p><strong>Nežiaduce účinky:</strong> nauzea, vracanie, hnačka, úzkosť.</p>

<p><strong>Kľúčová bezpečnostná poznámka:</strong> pred začatím musí byť pacient <strong>bez opioidov 7 až 10 dní</strong> – inak hrozí vyvolanie abstinenčných (odvykacích) prejavov.</p>

<p>Praktická implikácia pre nefrológiu: pri ESKD netreba riešiť „doplnkovú dávku po dialýze“, pretože liek sa dialýzou neodstraňuje.</p>

<h2>Topiramát: dialýza skracuje expozíciu, po dialýze môže byť potrebná doplňujúca dávka</h2>

<p>Perorálny topiramát má jasne opísanú renálnu závislosť:</p>

<ul>
  <li>približne <strong>60 až 70 % sa vylučuje močom</strong>,</li>
  <li><strong>clearance je približne polovičná pri GFR &lt; 30 ml/min</strong>,</li>
  <li><strong>dialýza odstráni približne 50 %</strong> dávky, preto sa <strong>dávka má podať po dialýze</strong>.</li>
</ul>

<p><strong>Dávkovanie:</strong></p>

<ul>
  <li>monoterapia – udržiavanie: <strong>50 až 100 mg denne</strong>, počiatočne: <strong>25 mg každý druhý deň</strong>; udržiavanie v režime s obmedzením: <strong>50 mg každý druhý deň</strong>,</li>
  <li>uvádza sa aj použitie mimo schválených indikácií (off-label), napríklad pri migréne a epilepsii, a mimo schválených indikácií aj na redukciu hmotnosti.</li>
</ul>

<p><strong>Nežiaduce účinky a riziká:</strong> parestézie, kognitívne ťažkosti, psychiatrické účinky a metabolická acidóza.</p>

<p><strong>Kontraindikácie a varovania:</strong> glaukóm, obličkové kamene.</p>

<p>Praktická implikácia: u dialyzovaných pacientov je topiramát „dialyzačne citlivý“, takže načasovanie dávky (a potreba doplnenia po dialýze) je súčasťou bezpečného režimu.</p>

<h2>Bupropión: úprava dávky pri GFR &lt; 30 ml/min</h2>

<p>Perorálny bupropión inhibuje spätné vychytávanie noradrenalínu a dopamínu. Z hľadiska obličiek je dôležité, že:</p>

<ul>
  <li>primárne sa metabolizuje v pečeni cez <strong>CYP2B6</strong> na aktívne metabolity,</li>
  <li><strong>renálna clearance má významnú úlohu</strong> pri exkrécii metabolitov,</li>
  <li>preto sa pri <strong>GFR &lt; 30 ml/min/1,73 m²</strong> odporúčajú <strong>úpravy dávky</strong> a začatie liečby nižšími dávkami.</li>
</ul>

<p><strong>Dávkovanie:</strong></p>

<ul>
  <li>forma s okamžitým uvoľňovaním (IR) – začiatok: <strong>75 mg 1× denne</strong>,</li>
  <li>forma s predĺženým uvoľňovaním (ER) – začiatok: <strong>150 mg každý druhý deň</strong> alebo <strong>1× denne</strong>.</li>
</ul>

<p><strong>Nežiaduce účinky:</strong> nespavosť, bolesť hlavy, sucho v ústach, nauzea, agitácia alebo úzkosť.</p>

<p><strong>Kľúčové bezpečnostné varovania:</strong></p>

<ul>
  <li>záchvatové poruchy alebo riziko záchvatov,</li>
  <li>ťažké poškodenie pečene,</li>
  <li>ťažké elektrolytové poruchy.</li>
</ul>

<p>Praktická implikácia: pri CKD a ESKD je bupropión použiteľný, ale treba cielene „začať nízko a titrovať pomaly“ (low and go slow) a sledovať riziká pre centrálny nervový systém a elektrolyty.</p>

<h2>Orlistat: lokálny mechanizmus, minimálna renálna záťaž, bez úpravy pri ESKD</h2>

<p>Perorálny orlistat pôsobí ako inhibítor pankreatických a žalúdočných lipáz. Jeho farmakokinetika je pri CKD výhodná:</p>

<ul>
  <li>približne <strong>97 % sa vylúči stolicou nezmenené</strong>,</li>
  <li>renálna exkrécia je minimálna (približne <strong>2 % metabolitov</strong>),</li>
  <li>preto <strong>nie je potrebná úprava dávky</strong> a liek je <strong>bezpečný pri ESKD</strong>.</li>
</ul>

<p><strong>Dávkovanie:</strong> <strong>60 až 120 mg 3× denne</strong> s jedlami obsahujúcimi tuk.</p>

<p><strong>Nežiaduce účinky a riziká:</strong></p>

<ul>
  <li>znížená absorpcia vitamínov rozpustných v tukoch,</li>
  <li>steatorea, mastné stolice, plynatosť, urgentné nutkanie na stolicu,</li>
  <li>chronická malabsorpcia, cholestáza,</li>
  <li>riziko <strong>oxalátovej nefropatie</strong>.</li>
</ul>

<p>Praktická implikácia: orlistat je pri CKD farmakologicky často „bezpečný“, ale klinicky treba myslieť na gastrointestinálnu toleranciu a prípadnú potrebu sledovania výživového stavu.</p>

<h2>Agonisty GLP-1: výhoda nezávislosti od obličiek v eliminačnej ceste</h2>

<p>Pri skupine agonistov GLP-1 receptorov (a príbuzných látkach) materiál zdôrazňuje spoločný rys:</p>

<ul>
  <li><strong>metabolizmus proteolýzou</strong>,</li>
  <li><strong>bez závislosti od obličiek</strong> pri eliminácii.</li>
</ul>

<p>To je v dialyzačnej praxi zásadné, pretože to znižuje obavy z akumulácie v dôsledku zníženej renálnej clearance.</p>

<h3>Liraglutid</h3>

<p><strong>Dávkovanie a titrácia:</strong> postupné navyšovanie na <strong>3,0 mg/deň</strong> na redukciu hmotnosti; pri dialýze sa odporúča <strong>obozretne začať a monitorovať gastrointestinálnu toleranciu</strong> (údaje pri dialýze sú obmedzené).</p>

<p><strong>Nežiaduce účinky:</strong> nauzea, vracanie, pankreatitída, cholelitiáza.</p>

<p><strong>Kontraindikácie a varovania:</strong> medulárny karcinóm štítnej žľazy, mnohopočetná endokrinná neoplázia 2. typu (MEN2).</p>

<h3>Semaglutid</h3>

<p><strong>Dávkovanie:</strong> postupné navyšovanie na <strong>2,4 mg/týždeň</strong> na redukciu hmotnosti; pri dialýze sa <strong>odporúčajú nižšie dávky</strong> (obmedzené dáta). Uvádzaný titračný rámec: postupné navyšovanie na <strong>2 až 2,4 mg/týždeň</strong>, ak sa znáša.</p>

<p><strong>Nežiaduce účinky:</strong> nauzea, vracanie, hnačka, zriedkavo pankreatitída, zhoršenie diabetickej retinopatie.</p>

<p><strong>Kontraindikácie a varovania:</strong> medulárny karcinóm štítnej žľazy, MEN2.</p>

<h3>Tirzepatid</h3>

<p>Tirzepatid je duálny agonista GIP/GLP-1:</p>

<ul>
  <li><strong>metabolizmus proteolýzou</strong>,</li>
  <li><strong>bez závislosti od obličiek</strong> pri eliminácii.</li>
</ul>

<p><strong>Dávkovanie:</strong> postupné navyšovanie na maximum <strong>15 mg/týždeň</strong>; pre ESKD nie je špecifické schválenie, preto sa uvádza praktický rámec <strong>začať 2,5 mg/týždeň a titrovať podľa tolerancie</strong>.</p>

<p><strong>Nežiaduce účinky:</strong> nauzea, vracanie, hnačka, zápcha, zriedkavo pankreatitída, cholelitiáza.</p>

<p><strong>Kontraindikácie a varovania:</strong> medulárny karcinóm štítnej žľazy, MEN2.</p>

<p><strong>Bezpečnostná pointa:</strong> tirzepatid nie je špecificky schválený pre ESKD a bezpečnostné údaje sú obmedzené.</p>

<p>Praktická implikácia: z eliminačnej logiky je táto skupina výhodná, no pri tirzepatide – a v materiáli aj pri ostatných látkach typu GLP-1 – ostáva pri dialýze medzera v dôkazoch, naznačená formuláciami o obmedzených údajoch.</p>

<h2>Praktický kontrolný zoznam pred začiatkom liečby</h2>

<ol>
  <li><strong>Aké je GFR?</strong> Pri GFR &lt; 30 ml/min/1,73 m² materiál explicitne upozorňuje na úpravu bupropiónu a zníženú clearance topiramátu.</li>
  <li><strong>Je pacient na dialýze?</strong> Topiramát: dialýza odstráni približne 50 %, po dialýze dávku doplniť. Naltrexón: dialýzou sa neodstraňuje.</li>
  <li><strong>Je prítomné riziko záchvatov alebo porúch elektrolytov?</strong> Pri bupropióne je to priamo uvedené ako varovanie.</li>
  <li><strong>Existuje riziko endokrinných nádorov (MEN2, medulárny karcinóm štítnej žľazy)?</strong> Pri agonistoch GLP-1 a tirzepatide je to v materiáli uvedené.</li>
  <li><strong>Ako pacient znáša gastrointestinálne nežiaduce účinky?</strong> Pri liraglutide a semaglutide sa pri dialýze priamo spomína opatrnosť.</li>
  <li><strong>Pri orlistate</strong> myslieť na vitamíny rozpustné v tukoch, steatoreu a riziko oxalátovej nefropatie.</li>
</ol>

<h2>Záver</h2>

<p>Z dostupného fulltextového materiálu vyplýva pomerne praktický obraz:</p>

<ul>
  <li><strong>topiramát</strong> je renálne limitovaný a dialýza mu skracuje expozíciu (pravdepodobne doplnenie dávky po dialýze),</li>
  <li><strong>naltrexón</strong> sa dialýzou neodstraňuje (nevyžaduje dialyzačnú „kompenzáciu“),</li>
  <li><strong>bupropión</strong> si pri GFR &lt; 30 ml/min/1,73 m² vyžaduje opatrnosť v dávkovaní,</li>
  <li><strong>orlistat</strong> je z hľadiska obličiek výhodný, ale klinicky dominujú gastrointestinálne a výživové otázky,</li>
  <li><strong>agonisty GLP-1 a tirzepatid</strong> majú eliminačnú výhodu (proteolýza, bez renálnej závislosti), no materiál zároveň upozorňuje na obmedzené dáta pri dialýze, najmä pri tirzepatide.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD), 2026 (plný text). <a href="https://www.ajkd.org/article/S0272-6386(26)00825-5/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
