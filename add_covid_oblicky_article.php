<?php
/**
 * add_covid_oblicky_article.php
 * Pridanie článku o dopade COVID-19 na zdravie obličiek a sledovaní rizikových pacientov
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'COVID-19 a zdravie obličiek: aký dopad môže mať infekcia a koho sledovať',
    'slug'         => 'covid-19-a-zdravie-obliciek-dopad-infekcie-sledovanie',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Podľa štúdie na viac než 3 miliónoch pacientov mali ľudia po COVID-19 vyššie riziko akútneho poškodenia obličiek, vzniku alebo zhoršenia CKD a progresie k zlyhaniu obličiek v porovnaní s obdobím po chrípke. Nefrológ vysvetľuje, kto je najviac ohrozený, kedy sa môžu komplikácie objaviť a prečo je dôležité myslieť na obličky aj po prekonaní infekcie.',
    'content'      => <<<'HTML'
<p>Pandémia COVID-19 mohla u mnohých ľudí vyvolať „krízový" nárast problémov s obličkami. Podľa štúdie na viac než 3 miliónoch pacientov publikovanej v časopise <em>Communications Medicine</em> mali ľudia po COVID-19 vyššie riziko viacerých komplikácií v porovnaní s obdobím po chrípke: akútne poškodenie obličiek (AKI), vznik alebo zhoršenie chronického ochorenia obličiek (CKD) a tiež vyššie riziko progresie k zlyhaniu obličiek.</p>

<p>Tento článok prináša praktickejšie pohľady v podobe Q&amp;A, kde nefrológ vysvetľuje, kto je najviac ohrozený, ako rýchlo sa môžu objaviť komplikácie a prečo je dôležité na obličky myslieť aj po „prekonaní" infekcie.</p>

<h2>Pre koho je riziko najvyššie</h2>

<p>Najväčší podiel komplikácií sa týka pacientov so závažným priebehom COVID-19, ale riziko nie je obmedzené len na túto skupinu. O problémoch s obličkami môže hovoriť aj to, že sa AKI v údajoch spomína najmä v prvých šiestich mesiacoch po infekcii SARS-CoV-2.</p>

<p>CKD býva často bezpríznakové: podľa článku sa až u veľkej časti pacientov neprejaví „viditeľne", kým nie je zachytená nálezom v bežných laboratórnych testoch. Typicky sa pritom pri CKD môžu odhaliť napríklad diabetická nefropatia, obezitná glomerulopatia alebo poškodenie obličiek pri hypertenzii.</p>

<h2>Aké ochorenia obličiek môže COVID-19 spustiť alebo zhoršiť</h2>

<p>Infekcia nerobí vždy jednu jedinú diagnózu. Spektrum je široké: od akútneho poškodenia obličkových kanálikov až po rôzne zápalové a imunitne sprostredkované glomerulové ochorenia. Časť prípadov sa môže prejaviť agresívnejšími formami glomerulárneho poškodenia.</p>

<p>Článok zároveň zdôrazňuje, že častejšie ide o situácie, keď má človek už určitú zraniteľnosť alebo predispozíciu, a infekcia pôsobí ako spúšťač. Ako príklad spomína zvýšenú náchylnosť pri niektorých genetických variantoch (APOL1) a súvis s tzv. COVID-19-asociovanou nefropatiou.</p>

<h2>Kedy sa môžu objaviť problémy po infekcii</h2>

<p>Načasovanie nie je rovnaké u všetkých. U niektorých pacientov sa prejavy môžu objaviť skoro, u iných sa imunitná odpoveď môže „ťahať" v čase a klinické problémy sa môžu rozvinúť v priebehu týždňov až mesiacov. V časti prípadov môže dôjsť aj k úplnému návratu funkcie, keď imunitná aktivita utíchne.</p>

<h2>Kto by mal byť cielenejšie sledovaný</h2>

<p>Článok odporúča, aby klinici zostali pozorní aj pri anamnéze COVID-19. Prakticky sa uvádza sledovanie močového nálezu:</p>

<ul>
  <li><strong>spot močový pomer albumín/kreatinín (UACR)</strong>, ktorý zachytí aj subtílnejšiu mikroalbuminúriu,</li>
  <li>a popri tom detailná anamnéza a fyzikálne vyšetrenie, vrátane sledovania nového alebo zhoršujúceho sa tlaku krvi, diabetu a aj jemného, pretrvávajúceho poklesu funkcie obličiek v bežných kontrolných laboratórnych testoch.</li>
</ul>

<p>Dôležitý je aj rodinný výskyt ochorení obličiek, kde môže byť na mieste úvaha o genetickom posúdení v selektovaných situáciách.</p>

<h2>Prečo je skoré nefrologické vyšetrenie také podstatné</h2>

<p>Ak sa problém zachytí včas, môže to znamenať rozdiel medzi „manažovateľnou" chronickou situáciou a progresiou k zlyhaniu obličiek. Článok zdôrazňuje, že liečebné možnosti sa v posledných rokoch výrazne rozšírili a skorý kontakt s nefrológom môže pacientovi zabezpečiť prístup k terapiám, k liečbe komplikácií a v niektorých diagnózach aj k intervenciám, ktoré menia dlhodobé výsledky.</p>

<h2>Nestačí len štandardná podporná liečba</h2>

<p>Základ v manažmente CKD tvoria aj tradičné skupiny liekov (RAAS inhibítory, SGLT2 inhibítory, GLP-1 agonisty a MRA), ale článok upozorňuje, že rozhodujúce je aj pochopenie príčiny CKD. Ak je etiológia nejasná, má byť nižší prah na doplnenie vyšetrení, vrátane úvahy o biopsii obličiek, najmä ak je prítomná významná proteinúria a nie je jasná diabetická genéza.</p>

<h2>Ako dlho sledovať pacientov s komplikáciami po COVID-19</h2>

<p>Kľúčová je kontinuita starostlivosti. Ide o dlhodobé ochorenie a výsledky môžu byť lepšie, keď pacient zostáva v pravidelnom, dlhodobo vedenom režime: kontrolné odbery, adherencia k liekom, úpravy životného štýlu.</p>

<p>Dôležitý je aj kardiovaskulárny aspekt, pretože fyzická kondícia a celkové zdravie často významne ovplyvňujú priebeh CKD.</p>

<h2>Vplyv aktuálnych variantov COVID-19</h2>

<p>Článok uvádza, že súčasné kmene zvyčajne nevedú k takému rozsiahlemu renálnemu poškodzovaniu ako niektoré skoršie varianty počas vrcholu pandémie. Dopad sa zdá byť vo všeobecnosti miernejší, podobne ako sa mení správanie vírusov v čase. Napriek tomu vzhľadom na veľký počet infekcií na populácii aj malé zvýšenie individuálneho rizika môže znamenať reálne zdravotné zaťaženie, najmä u ľudí s chronickými ochoreniami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Infectious Disease Advisor (Renal and Urology News) – „COVID-19 and Kidney Health Effects". <a href="https://www.infectiousdiseaseadvisor.com/features/covid19-and-kidney-health-effects/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Upozornenie:</strong> Tento článok bol osobne spracovaný aj s pomocou rozličných nástrojov tzv. umelej inteligencie (AI).</em></p>
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
                error_log('add_covid_oblicky_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_covid_oblicky_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: COVID-19 a zdravie obličiek\n";
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
      <title>Migrácia – COVID-19 a zdravie obličiek</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – COVID-19 a zdravie obličiek</h2>

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

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
