<?php
/**
 * add_kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Kazuisticky: Ako zvládnuť hyperkaliémiu pri CKD a srdcovom zlyhávaní tak, aby sme neznižovali účinnú liečbu',
    'slug'         => 'kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Hyperkaliémia je najčastejší dôvod prerušenia inhibície RAAS u pacientov s CKD a srdcovým zlyhávaním, hoci liečba podľa odporúčaní (GDMT) zlepšuje prognózu. Namiesto vysadenia liečby možno použiť lieky viažuce draslík – patiromer a SZC však nie sú navzájom zameniteľné.',
    'content'      => <<<'HTML'
<figure><a href="img/kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas.webp" rel="noopener noreferrer" target="_blank"><img src="img/kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas.webp" alt="Draslíkové častice odvádzané bokom viazačom, zatiaľ čo hlavný liečebný lúč k srdcu a obličke zostáva v plnej sile" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Draslík sa dá riešiť samostatne – účinnú liečbu tak nie je nutné oslabiť.</figcaption></figure>

<p>V praxi narážame stále na ten istý problém: pacient má chronickú chorobu obličiek a zároveň srdcové zlyhávanie, je kandidátom na inhibíciu RAAS (ACEi/ARB) a často aj na MRA (napr. spironolaktón). Hyperkaliémia však vyvoláva obavy, lekári liečbu obmedzujú alebo prerušujú a pacient tak prichádza o liečbu, ktorá zlepšuje prognózu.</p>

<p>Tento článok vychádza zo vzdelávacej aktivity „Case-Based Approach: Managing Hyperkalemia in Patients With CKD and Heart Failure“ a jej hlavné myšlienky prenáša do praktického kazuistického rámca.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Kazuistika na začiatok: 45-ročná žena s CKD 3b a HFrEF (NYHA II)</h2>

<p>Aktivita začína prípadom 45-ročnej ženy s CKD 3b, eGFR &lt; 40 ml/min, proteinúriou a súbežným srdcovým zlyhávaním NYHA II. Pacientka prichádza s veľkou obavou: „Mám CKD aj srdce. A keď mi stúpne draslík, čo potom?“</p>

<p>Podstatou kazuistiky je, že obava z hyperkaliémie vedie k nedostatočnej liečbe. Aktivita zdôrazňuje, že inhibítory RAAS sú základom znižovania kardiorenálneho rizika, no hyperkaliémia často bráni ich optimálnemu nasadeniu či udržaniu.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Kľúčová zmena v uvažovaní: hyperkaliémia nemá automaticky zastaviť inhibíciu RAAS</h2>

<p>Podľa aktivity odporúčania KDIGO 2024 jasne hovoria, že hyperkaliémia by sama osebe nemala byť dôvodom na ukončenie inhibície RAAS. Logika je jednoduchá a klinicky dôležitá:</p>

<ol>
  <li><strong>GDMT (guideline-directed medical therapy) zlepšuje morbiditu aj mortalitu</strong>,</li>
  <li><strong>hyperkaliémiu treba riešiť aktívne</strong>, nie ústupom zo základnej kardioprotektívnej liečby,</li>
  <li>praktický postup je <strong>udržať RAAS/MRA</strong> a k tomu pridať <strong>liečbu viažucu draslík</strong> (a tam, kde to má zmysel, aj diuretiká na podporu exkrécie draslíka).<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ol>

<p>Hyperkaliémia tak prestáva byť „dôvodom liečbu zastaviť“ a stáva sa „dôvodom doplniť správny nástroj“.</p>

<h2>Problémom je aj poddiagnostikovanie a nedostatočná eskalácia liečby</h2>

<p>Jedným z hlavných argumentov aktivity opretých o dáta je register CARE-HK v populácii s HFrEF a často pokročilejšou CKD (napr. CKD 3b, eGFR &lt; 40). Kazuistická časť z neho vyvodzuje, že:</p>

<ul>
  <li><strong>RAASi alebo MRA neboli adekvátne využité u zhruba jednej tretiny</strong> pacientov,</li>
  <li><strong>obavy z hyperkaliémie</strong> sú podľa autorov hlavným dôvodom,</li>
  <li>hyperkaliemické epizódy sa ukazujú ako <strong>rekurentné</strong> a zároveň sa pozoruje <strong>nízke používanie liekov viažucich draslík</strong>,</li>
  <li>s poklesom funkcie obličiek ďalej klesá optimalizácia GDMT a v pokročilých štádiách je podiel pacientov na odporúčanej liečbe alarmujúco nízky.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Záver kazuistiky je teda dvojaký: nejde len o to, čo urobiť pri jednej epizóde, ale aj o to, ako zabrániť, aby sa pacient dostal do začarovaného kruhu nedostatočnej liečby.</p>

<h2>Lieky viažuce draslík: mechanizmy nie sú rovnaké, preto sa líšia aj bezpečnostné signály</h2>

<p>Aktivita prakticky porovnáva dve moderné látky viažuce draslík: <strong>patiromer</strong> a <strong>sodium zirconium cyclosilicate (SZC)</strong>.</p>

<h3>Rozdiel v mechanizme a jeho možný klinický význam</h3>

<ul>
  <li><strong>Patiromer</strong>: výmena draslíka za vápnik (calcium–potassium exchange).</li>
  <li><strong>SZC</strong>: výmena draslíka za sodík (sodium–potassium exchange). V aktivite sa uvádza, že pri porovnateľných dávkach môže byť sodíkové zaťaženie klinicky relevantnou protihodnotou.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Z toho vyplýva klinicky relevantná otázka: ak SZC prináša viac sodíka, môže to u niektorých pacientov zhoršiť retenciu tekutín a vyvolať alebo zhoršiť srdcové zlyhávanie.</p>

<h3>Bezpečnostné signály pre SZC (edém, zhoršenie HF)</h3>

<p>Aktivita uvádza, že v menších randomizovaných štúdiách aj v súhrnných (pooled) analýzach sa pri SZC v populácii s neobjasneným alebo už prítomným HF objavoval signál pre zhoršenie srdcového zlyhávania a edémové udalosti, čo sa premietlo aj do regulačných aktualizácií.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Údaje zo štúdií: REALIZE-K (SZC) vs. DIAMOND (patiromer)</h2>

<h3>REALIZE-K (SZC) pri spironolaktóne</h3>

<p>V štúdii REALIZE-K sa SZC používal u pacientov, ktorí mali pokračovať v liečbe spironolaktónom napriek riziku hyperkaliémie. Aktivita zdôrazňuje, že sa pozorovali bezpečnostné udalosti spojené so srdcovým zlyhávaním a ich dôsledkom bol vyšší počet závažných nežiaducich príhod (serious adverse events) pre srdcové zlyhávanie.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h3>DIAMOND (patiromer) a natriuretický profil</h3>

<p>Na porovnanie sa uvádza štúdia DIAMOND: pri patiromeri sa v subanalýze zaznamenal postupný pokles NT-proBNP, ktorý zodpovedá očakávanému účinku dobre vedenej neurohormonálnej liečby u pacientov s HFrEF.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<p>Praktický význam: ak pacient potrebuje MRA aj inhibítor RAAS, výber lieku viažuceho draslík môže ovplyvniť nielen draslík, ale aj kardiovaskulárnu toleranciu a bezpečnosť.</p>

<h2>Čo si odniesť do praxe</h2>

<ul>
  <li><strong>RAAS blokádu neukončovať len kvôli hyperkaliémii</strong>, ak sa dá pokračovať s podporou liečby viažucej draslík.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
  <li><strong>Obavy z hyperkaliémie prekonať</strong> správnou liečbou a monitorovaním, aby pacient GDMT skutočne dostal a udržal.</li>
  <li><strong>Multidisciplinárna spolupráca</strong> (kardiológ, nefrológ, internista) je pri výbere vhodného lieku viažuceho draslík kľúčová, lebo bezpečnostné signály a mechanizmy nie sú rovnaké.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Medtelligence CE na ReachMD, „Case-Based Approach: Managing Hyperkalemia in Patients With CKD and Heart Failure“. <a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">Zdroj aktivity</a>.</em></p>
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
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
