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
    'excerpt'      => 'Hyperkaliémia je najčastejší dôvod prerušenia RAAS inhibície u pacientov s CKD a srdcovým zlyhávaním, no GDMT liečba zlepšuje prognózu. Ako myslieť inak: draslík-viažuce lieky namiesto odstavenia liečby, a prečo patiromer a SZC nie sú navzájom zameniteľné.',
    'content'      => <<<'HTML'
<p>V praxi narážame na rovnaký problém znova a znova: pacient má chronické obličkové ochorenie a zároveň srdcové zlyhávanie, je kandidát na liečbu založenú na RAAS inhibícii (ACEi/ARB) a často aj MRA (napr. spironolaktón). Lenže. Hyperkaliémia naháňa strach, klinici liečbu obmedzujú alebo prerušujú a tým pacient prichádza o liečbu, ktorá zlepšuje prognózu.</p>

<p>Tento článok vychádza zo vzdelávacej aktivity „Case-Based Approach: Managing Hyperkalemia in Patients With CKD and Heart Failure“ a prekladá jej hlavné myšlienky do praktického, kazuistického rámca.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Kazuistika na začiatok: 45-ročná žena s CKD 3b a HFrEF (NYHA II)</h2>

<p>V aktivite sa začína prípadom 45-ročnej ženy s CKD 3b, eGFR &lt; 40 ml/min, proteinúriou a súbežným srdcovým zlyhávaním NYHA II. Pacientka prichádza s veľkou obavou: „Mám CKD aj srdce. A keď mi stúpne draslík, čo potom?“</p>

<p>Pointa kazuistiky je, že obava z hyperkaliémie vedie k podliečeniu. V aktivite sa zdôrazňuje, že RAAS inhibítory sú základ znižovania kardiorenálneho rizika, no hyperkaliémia často bráni ich optimálnemu nasadeniu či udržaniu.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Kľúčový prelom v myslení: hyperkaliémia nemá automaticky zastaviť RAAS liečbu</h2>

<p>V aktivite zaznieva, že pokyny (KDIGO 2024) majú jasný odkaz: hyperkaliémia by sama o sebe nemala byť dôvodom na ukončenie RAAS inhibície. Logika je jednoduchá a klinicky veľmi dôležitá:</p>

<ol>
  <li><strong>GDMT (guideline-directed medical therapy) zlepšuje morbiditu aj mortalitu</strong>,</li>
  <li><strong>k hyperkaliémii sa má pristúpiť aktívne</strong>, nie ústupom zo základnej kardioprotektívnej liečby,</li>
  <li>praktický postup je <strong>udržať RAAS/MRA</strong> a k tomu pridať <strong>liečbu viažucu draslík</strong> (plus tam, kde dáva zmysel, aj diuretiká na podporu exkrécie draslíka).<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ol>

<p>V tejto logike sa hyperkaliémia prestáva riešiť ako „dôvod stopnúť“, a začína sa riešiť ako „dôvod doplniť správny nástroj“.</p>

<h2>Prečo je problém aj v poddiagnostikovaní a nedostatočnej eskalácii liečby</h2>

<p>Jedným z „tvrdých“ argumentov v aktivite je register CARE-HK v populácii s HFrEF a častým pokročilejším CKD (napr. CKD 3b, eGFR &lt; 40). V kazuistickej časti sa interpretuje, že:</p>

<ul>
  <li><strong>RAASi alebo MRA neboli adekvátne využité u zhruba jednej tretiny</strong> pacientov,</li>
  <li><strong>obavy z hyperkaliémie</strong> sú podľa autorov hlavným dôvodom,</li>
  <li>hyperkaliemické epizódy sa ukazujú ako <strong>rekurentné</strong> a zároveň sa pozoruje <strong>nízke používanie draslík-viažucich liekov</strong>,</li>
  <li>s poklesom renálnych funkcií ďalej klesá optimalizácia GDMT a v pokročilých štádiách je podiel pacientov na odporúčanej liečbe alarmujúco nízky.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Kazuistický záver je teda dvojitý: nie je to len otázka „čo urobiť pri jednej epizóde“, ale aj „čo urobiť, aby sa pacient nedostal do začarovaného kruhu podliečenia“.</p>

<h2>Potassium bindery: mechanizmy nie sú rovnaké, preto sa líšia aj bezpečnostné signály</h2>

<p>Aktivita postavila praktické porovnanie dvoch moderných draslík-viažucich látok: <strong>patiromer</strong> a <strong>sodium zirconium cyclosilicate (SZC)</strong>.</p>

<h3>Rozdiel v mechanizme (a čo z toho môže byť klinicky)</h3>

<ul>
  <li><strong>Patiromer</strong>: výmena draslíka za vápnik (calcium–potassium exchange).</li>
  <li><strong>SZC</strong>: výmena draslíka za sodík (sodium–potassium exchange). V aktivite sa uvádza, že pri porovnateľných dávkach môže byť sodíkové zaťaženie klinicky relevantnou protihodnotou.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Z toho vyplýva klinicky relevantná otázka: ak SZC prináša viac sodíka, môže to u niektorých pacientov zhoršiť retenciu tekutín a vyvolať alebo zhoršiť srdcové zlyhávanie.</p>

<h3>Bezpečnostné signály pre SZC (edém, zhoršenie HF)</h3>

<p>Aktivita spomína, že v menších randomizovaných štúdiách aj v pooled analýzach sa pri SZC v populácii s neobjasneným alebo už prítomným HF objavoval signál pre zhoršenie srdcového zlyhávania a edémové udalosti, čo sa premietlo aj do regulačných aktualizácií.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Realita z trialov: REALIZE-K (SZC) vs. DIAMOND (patiromer)</h2>

<h3>REALIZE-K (SZC) pri spironolaktóne</h3>

<p>V REALIZE-K sa SZC používal v kontexte, kde mali pacienti udržať alebo pokračovať v liečbe spironolaktónom aj napriek riziku hyperkaliémie. V aktivite sa zdôrazňuje, že sa pozorovali bezpečnostné udalosti spojené so srdcovým zlyhávaním a viedlo to k zvýšeniu závažných nežiaducich príhod (serious adverse events) pre srdcové zlyhávanie.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h3>DIAMOND (patiromer) a natriuretický profil</h3>

<p>Ako kontrast sa spomína DIAMOND: pri patiromeri boli v subanalýze zaznamenané poklesy NT-proBNP v čase, ktoré sú konzistentné s očakávaným efektom pri dobre manažovanej neurohormonálnej liečbe u pacientov s HFrEF.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<p>Praktický význam: ak pacient potrebuje MRA a RAAS terapiu, výber draslík-viažucej liečby môže mať nielen vplyv na draslík, ale aj na kardiovaskulárnu toleranciu a bezpečnosť.</p>

<h2>Take-home message pre kliniku</h2>

<ul>
  <li><strong>RAAS blokádu neukončovať len kvôli hyperkaliémii</strong>, ak sa dá pokračovať s podporou liečby viažucej draslík.<sup><a href="https://reachmd.com/programs/cme/case-based-approach-managing-hyperkalemia-in-patients-with-ckd-and-heart-failure/37617/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
  <li><strong>Preklenúť strach z draslíka</strong> správnou liečbou a monitoringom, aby pacient reálne dostal a udržal GDMT.</li>
  <li><strong>Multidisciplinárna spolupráca</strong> (kardiológ, nefrológ, internista) je pri výbere vhodného binderu kľúčová, lebo bezpečnostné signály a mechanizmy nie sú rovnaké.</li>
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
