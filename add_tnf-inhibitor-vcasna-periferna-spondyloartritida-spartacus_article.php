<?php
/**
 * add_tnf-inhibitor-vcasna-periferna-spondyloartritida-spartacus_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_tnf-inhibitor-vcasna-periferna-spondyloartritida-spartacus_article.php"
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Včasné podanie TNF inhibítora pri periférnej spondyloartritíde prinieslo vyššiu remisiu než postupné pridávanie csDMARD',
    'slug'         => 'tnf-inhibitor-vcasna-periferna-spondyloartritida-spartacus',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia fázy 3 SPARTACUS ukázala, že u pacientov s včasnou aktívnou periférnou spondyloartritídou viedlo okamžité nasadenie golimumabu k vyššej miere klinickej remisie po 24 týždňoch (60 %) než postupná stratégia s metotrexátom (33 %).',
    'content'      => <<<'HTML'
<p>Pri včasnej periférnej spondyloartritíde môže byť rozhodujúce, ako rýchlo sa podarí potlačiť zápal. Výsledky fázy 3 štúdie SPARTACUS naznačujú, že okamžité nasadenie TNF inhibítora môže viesť k vyššej miere klinickej remisie než štandardný postup s konvenčným syntetickým chorobu modifikujúcim liekom, konkrétne metotrexátom.</p>

<p>V štúdii dosiahlo klinickú remisiu po 24 týždňoch 60 % pacientov liečených golimumabom, zatiaľ čo v skupine s postupnou liečbou metotrexátom to bolo 33 %. Rozdiel bol štatisticky významný. Klinická remisia bola definovaná prísne: ako úplná neprítomnosť artritídy, daktylitídy alebo entezitídy pri klinickom vyšetrení.</p>

<p>Výsledky boli prezentované na výročnom kongrese EULAR 2026 a poukazujú na možnú „terapeutickú príležitosť“ v skorom štádiu ochorenia.</p>

<h2>Prečo je periférna spondyloartritída problém</h2>

<p>Periférna spondyloartritída je zápalové reumatické ochorenie, pri ktorom dominujú prejavy mimo chrbtice. Typicky ide o artritídu periférnych kĺbov, entezitídu alebo daktylitídu. Pacienti môžu mať výrazne opuchnuté kĺby, bolesti úponov šliach a funkčné obmedzenie.</p>

<p>Napriek tomu je dôkazová základňa pre liečbu periférnej spondyloartritídy slabšia než pri axiálnej spondyloartritíde alebo psoriatickej artritíde. Podľa investigátorov štúdie neexistuje dostatok údajov o účinnosti metotrexátu pri periférnej spondyloartritíde, hoci sa v bežnej praxi používa. Zároveň nie sú TNF inhibítory špecificky schválené pre túto diagnózu regulačnými autoritami ako FDA alebo EMA.</p>

<p>Bežný postup je preto konzervatívny: najprv nesteroidové antiflogistiká, následne csDMARD, napríklad metotrexát alebo sulfasalazín, a biologická liečba sa ponecháva pre refraktérne prípady.</p>

<p>Štúdia SPARTACUS testovala, či by skoršia intenzívnejšia liečba nemohla priniesť lepší výsledok.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>SPARTACUS bola randomizovaná klinická štúdia fázy 3. Cieľom bolo zistiť, či možno u pacientov s novodiagnostikovanou, včasnou a aktívnou periférnou spondyloartritídou dosiahnuť dlhodobú remisiu bez liekov pomocou včasnej indukčnej liečby TNF inhibítorom alebo štandardnou postupnou stratégiou s csDMARD.</p>

<p>Do štúdie bolo zaradených 97 pacientov, ktorí spĺňali klasifikačné kritériá ASAS pre periférnu spondyloartritídu a mali príznaky kratšie než jeden rok.</p>

<p>Na zaradenie bola potrebná prítomnosť artritídy, entezitídy alebo daktylitídy a aspoň jeden ďalší znak spondyloartritídy.</p>

<p>Charakteristika pacientov na začiatku:</p>

<ul>
  <li>97 % malo artritídu,</li>
  <li>68 % malo entezitídu,</li>
  <li>34 % malo daktylitídu,</li>
  <li>priemerný vek bol 39 rokov,</li>
  <li>60 % tvorili muži,</li>
  <li>45 % bolo HLA-B27 pozitívnych,</li>
  <li>51 % malo anamnézu psoriázy,</li>
  <li>priemerné trvanie príznakov bolo 5,9 mesiaca.</li>
</ul>

<p>Pacienti boli rozdelení do dvoch liečebných stratégií. Prvá skupina dostávala golimumab 50 mg subkutánne každé 4 týždne. Druhá skupina dostávala metotrexát perorálne v úvodnej dávke 15 mg týždenne, s navýšením na 20 mg týždenne po 4 týždňoch, ak bol liek tolerovaný.</p>

<p>Ak pacienti po 12 týždňoch nedosiahli remisiu a ich ťažkosti neboli dostatočne kontrolované, mohol byť do liečby pridaný sulfasalazín v dávke 2 g denne.</p>

<h2>Golimumab dosiahol vyššiu mieru remisie</h2>

<p>Po 24 týždňoch bola klinická remisia významne častejšia v skupine s okamžitým podaním TNF inhibítora.</p>

<p>Výsledky:</p>

<ul>
  <li>60 % pri golimumabe,</li>
  <li>33 % pri postupnej stratégii s metotrexátom,</li>
  <li>odds ratio 3,1,</li>
  <li><em>P</em> = 0,006.</li>
</ul>

<p>Udržaná klinická remisia po 24 týždňoch bola takisto častejšia pri TNF inhibítore:</p>

<ul>
  <li>42 % pri golimumabe,</li>
  <li>18 % pri csDMARD stratégii,</li>
  <li><em>P</em> = 0,006.</li>
</ul>

<p>Tento rozdiel podporuje hypotézu, že včasné potlačenie zápalu môže byť pri periférnej spondyloartritíde klinicky výhodné.</p>

<h2>Zlepšili sa aj jednotlivé prejavy ochorenia</h2>

<p>Pacienti liečení golimumabom mali vyššiu pravdepodobnosť ústupu artritídy, entezitídy aj daktylitídy. Rozdiely medzi skupinami boli viditeľné už od 8. týždňa a pretrvávali do 24. týždňa.</p>

<p>Podobný trend sa pozoroval aj pri hodnotení aktivity ochorenia pomocou skóre DAPSA a ASDAS-CRP. V oboch ukazovateľoch boli poklesy výraznejšie pri TNF inhibítore než pri metotrexáte.</p>

<p>Zaujímavé je, že CRP sa znížilo v oboch skupinách približne podobne. Vstupne bolo zvýšené, s priemerom okolo 25 mg/l, a pri oboch liečebných stratégiách kleslo približne na 5 mg/l.</p>

<p>To naznačuje, že metotrexát nebol neúčinný. Aj on mal merateľný efekt, len klinická odpoveď bola pri okamžitom podaní TNF inhibítora výraznejšia.</p>

<h2>Metotrexát napriek tomu nie je bez významu</h2>

<p>Jedným z dôležitých odkazov štúdie je, že metotrexát v periférnej spondyloartritíde zrejme „niečo robí“. Podľa investigátora Philippa Carrona je to prvý dôkaz, že metotrexát má pri tejto diagnóze účinok, čo je povzbudivé, keďže sa používa v každodennej praxi.</p>

<p>To je prakticky dôležité. Výsledky neznamenajú, že metotrexát treba opustiť. Skôr ukazujú, že ak je cieľom rýchla a hlboká remisia pri včasnej aktívnej periférnej spondyloartritíde, TNF inhibítor môže byť účinnejšou indukčnou stratégiou.</p>

<p>Zároveň bolo menej pacientov v skupine s golimumabom, ktorí potrebovali záchranné pridanie sulfasalazínu po 12 týždňoch:</p>

<ul>
  <li>8,3 % pri golimumabe,</li>
  <li>28,6 % pri metotrexáte,</li>
  <li><em>P</em> = 0,02.</li>
</ul>

<h2>Bez výrazného bezpečnostného signálu v prvých 24 týždňoch</h2>

<p>Počas prvých 24 týždňov neboli v štúdii zaznamenané nové významné bezpečnostné signály. V skupine s TNF inhibítorom sa vyskytla jedna závažná nežiaduca udalosť: chrípkové príznaky vyžadujúce hospitalizáciu. Inak neboli hlásené závažné nežiaduce udalosti v žiadnej zo skupín.</p>

<p>Pri interpretácii bezpečnosti však treba byť opatrný. Štúdia mala 97 pacientov a sledovanie v tejto analýze trvalo 24 týždňov. Takýto rozsah je užitočný na zachytenie častých problémov, ale nestačí na definitívne hodnotenie zriedkavých alebo dlhodobých rizík.</p>

<h2>Čo to znamená pre klinickú prax</h2>

<p>Výsledky podporujú myšlienku skoršej intenzívnej liečby pri včasnej periférnej spondyloartritíde. Ak sa podarí ochorenie zachytiť v prvých mesiacoch, môže existovať okno príležitosti, v ktorom agresívnejšie potlačenie zápalu zlepší šancu na remisiu a možno aj na prevenciu štrukturálneho poškodenia.</p>

<p>To je dôležité najmä preto, že periférna spondyloartritída môže viesť k chronickej bolesti, poškodeniu kĺbov, strate funkcie a zhoršeniu kvality života.</p>

<p>Zároveň však treba držať interpretáciu pri zemi. SPARTACUS ukazuje superioritu okamžitého TNF inhibítora oproti metotrexátovej step-up stratégii v 24. týždni, ale neodpovedá ešte definitívne na otázku dlhodobej remisie bez liekov, rádiografickej progresie ani optimálnej ekonomickej stratégie.</p>

<h2>Praktický záver</h2>

<p>Štúdia SPARTACUS ukázala, že u pacientov s včasnou aktívnou periférnou spondyloartritídou viedla okamžitá liečba golimumabom k vyššej miere klinickej remisie po 24 týždňoch než postupná stratégia s metotrexátom.</p>

<p>Najdôležitejšie posolstvá sú tri:</p>

<ul>
  <li>včasná diagnostika periférnej spondyloartritídy má praktický význam,</li>
  <li>skoré podanie TNF inhibítora môže priniesť vyššiu šancu na remisiu,</li>
  <li>metotrexát pravdepodobne nie je neúčinný, ale jeho efekt bol v tejto štúdii slabší než pri golimumabe.</li>
</ul>

<p>Pre klinickú prax to otvára otázku, či by časť pacientov s včasnou, aktívnou a klinicky výraznou periférnou spondyloartritídou nemala byť liečená biologicky skôr, než ako to umožňuje tradičný postupný model.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>TNF Inhibitor Use in Early Peripheral Spondyloarthritis</em> (2026). <a href="https://www.medscape.com/viewarticle/tnf-inhibitor-use-early-peripheral-spondyloarthritis-2026a1000j74" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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

    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
