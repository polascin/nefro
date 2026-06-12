<?php
/**
 * add_geneticke-testovanie-obliciek-zriedkavo_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o nízkej miere genetického testovania
 * pri chronickej chorobe obličiek (prieskum NKF 2026).
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Genetické testovanie pri ochoreniach obličiek sa stále ponúka príliš zriedkavo',
    'slug'         => 'geneticke-testovanie-obliciek-zriedkavo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Nový prieskum z NKF 2026: hoci 20–30 % chronických ochorení obličiek môže mať genetický základ, len s každým piatym indikovaným pacientom lekár o genetickom testovaní vôbec hovoril.',
    'content'      => <<<'HTML'
<p>Genetické príčiny chronickej choroby obličiek sú častejšie, než sa v bežnej klinickej praxi predpokladá. Napriek tomu sa o genetickom testovaní a genetickom poradenstve s pacientmi hovorí len zriedka, dokonca aj v situáciách, keď by takéto vyšetrenie bolo podľa odporúčaní opodstatnené.</p>

<p>Na tento problém upozorňuje nový prieskum prezentovaný na <strong>National Kidney Foundation 2026 Spring Clinical Meetings</strong>. Podľa údajov zverejnených na portáli Medscape iba približne <strong>jeden z piatich pacientov s chronickou chorobou obličiek</strong>, u ktorých bolo genetické testovanie indikované, uviedol, že s ním zdravotnícky pracovník o tejto možnosti vôbec hovoril.</p>

<h2>Genetická príčina nemusí byť zriedkavosťou</h2>

<p>Autori pripomínajú, že <strong>20 až 30 % prípadov chronickej choroby obličiek môže mať genetický základ</strong>. V praxi však tieto príčiny často zostávajú nerozpoznané alebo nie sú dôsledne vyšetrené.</p>

<p>Chronická choroba obličiek sa zvyčajne diagnostikuje podľa zníženej odhadovanej glomerulovej filtrácie, prítomnosti bielkoviny alebo krvi v moči, prípadne podľa zobrazovacích vyšetrení. Genetické testovanie nie je rutinnou súčasťou nefrologickej starostlivosti a vo väčšine prípadov nie je potrebné na samotné potvrdenie diagnózy ochorenia obličiek. Môže však vysvetliť, prečo ochorenie vzniklo, aký má biologický mechanizmus a aké dôsledky môže mať pre liečbu pacienta aj pre jeho rodinu.</p>

<h2>Čo ukázal prieskum medzi pacientmi</h2>

<p>Prieskum bol zaslaný koncom roka 2024 členom pacientskej organizácie National Kidney Foundation, ktorí sami uviedli, že majú ochorenie obličiek. Odpovedalo <strong>1168 pacientov zo 49 štátov USA</strong>.</p>

<p>Z nich malo <strong>717 pacientov</strong>, teda 61,4 %, aspoň jednu indikáciu na genetické testovanie. Medzi takéto indikácie patrili napríklad:</p>

<ul>
  <li>rodinný výskyt ochorenia obličiek,</li>
  <li>mimorenálne prejavy ochorenia,</li>
  <li>diagnóza, pri ktorej sa genetické testovanie odporúča,</li>
  <li>chronická choroba obličiek alebo zlyhanie obličiek nejasnej príčiny pred 50. rokom života.</li>
</ul>

<p>Medzi pacientmi s aspoň jednou indikáciou malo 65,1 % pozitívnu rodinnú anamnézu ochorenia obličiek, 64,7 % malo klinickú diagnózu, pri ktorej existuje odporúčanie na genetické testovanie, a 27,3 % malo mimorenálne prejavy.</p>

<p>Napriek tomu bola komunikácia o genetickom testovaní nízka. Zo všetkých respondentov s ochorením obličiek uviedlo diskusiu s lekárom o genetickom testovaní alebo genetickom poradenstve:</p>

<ul>
  <li>11 % pacientov bez indikácie,</li>
  <li>16 % pacientov s jednou indikáciou,</li>
  <li>25 % pacientov s dvomi indikáciami,</li>
  <li>29 % pacientov s tromi indikáciami.</li>
</ul>

<p>Aj pri troch a viacerých indikáciách teda zostala pravdepodobnosť, že lekár s pacientom túto tému otvorí, pod hranicou 30 %.</p>

<p>Samotné genetické testovanie absolvovalo len <strong>8,6 % všetkých respondentov</strong>.</p>

<h2>Prečo na genetickej diagnóze záleží</h2>

<p>Genetická diagnóza môže mať priamy praktický význam. Nejde iba o pomenovanie príčiny ochorenia. V niektorých prípadoch môže zmeniť liečebné rozhodnutia, zabrániť použitiu nevhodných liekov, upozorniť na riziko rekurencie ochorenia po transplantácii alebo pomôcť pri vyšetrení príbuzných.</p>

<p>Ako príklady sa uvádzajú ochorenia, pri ktorých môže mať genetické potvrdenie zásadný terapeutický význam:</p>

<h3>Fabryho choroba</h3>

<p>Ide o ochorenie, ktoré sa môže prehliadnuť alebo diagnostikovať neskoro. Genetické potvrdenie diagnózy môže umožniť cielenú liečbu vrátane enzýmovej substitučnej terapie.</p>

<h3>Primárna hyperoxalúria 1. typu</h3>

<p>Včasné rozpoznanie umožňuje použiť špecifickú liečbu, napríklad lumasiran, a môže ovplyvniť stratégiu starostlivosti o pacienta s rizikom progresie ochorenia obličiek.</p>

<h3>Primárny deficit koenzýmu Q10</h3>

<p>Pri včasnej diagnostike môže byť klinicky významné podávanie vysokých dávok koenzýmu Q10, ktoré môže pomôcť zachovať funkciu obličiek.</p>

<p>Genetické testovanie môže byť dôležité aj pri transplantácii obličky. Ak pacient zlyhal z nejasnej príčiny, ktorá sa neskôr ukáže ako genetická, môže byť rizikové prijať obličku od príbuzného darcu bez adekvátneho genetického zhodnotenia. Príbuzný darca môže niesť rovnakú genetickú predispozíciu a môže byť sám ohrozený budúcim ochorením obličiek.</p>

<h2>Bariéry v praxi</h2>

<p>Dôvody nízkej miery genetického testovania nie sú úplne jasné, ale pravdepodobne ide o kombináciu viacerých faktorov. Medzi najčastejšie bariéry patria:</p>

<ul>
  <li>nedostatočná istota lekárov pri komunikácii o genetike,</li>
  <li>obavy z ceny vyšetrenia,</li>
  <li>nerovnaký prístup ku genetickému testovaniu,</li>
  <li>nedostatočné povedomie pacientov, že takáto možnosť existuje,</li>
  <li>rýchly vývoj odboru, ktorý si vyžaduje priebežné vzdelávanie.</li>
</ul>

<p>Podľa odborníkov je potrebné, aby sa genetika viac začlenila do výučby medicíny, rezidentských programov aj ďalšieho vzdelávania lekárov. Nefrológia sa v tomto smere rýchlo mení a genetická diagnostika sa postupne stáva praktickým nástrojom personalizovanej medicíny.</p>

<h2>Nie každý pacient potrebuje genetické testovanie</h2>

<p>Dôležité je zdôrazniť, že genetické testovanie nie je potrebné u každého pacienta s chronickou chorobou obličiek. Má však význam tam, kde existujú klinické znaky, rodinná anamnéza, nejasná etiológia ochorenia, skorý nástup choroby alebo mimorenálne prejavy.</p>

<p>Správne indikované genetické vyšetrenie môže priniesť odpovede, ktoré majú význam pre pacienta, jeho liečbu, príbuzných aj transplantačné plánovanie.</p>

<h2>Praktický záver pre nefrologickú starostlivosť</h2>

<p>Výsledky prieskumu ukazujú jasný nepomer medzi tým, koľko pacientov má indikáciu na genetické testovanie, a tým, s koľkými sa o tejto možnosti reálne diskutuje. Ak má 20 až 30 % chronických ochorení obličiek genetický podklad, genetická diagnostika by nemala zostať okrajovou témou.</p>

<p>Pre klinickú prax z toho vyplýva jednoduchý záver: pri chronickej chorobe obličiek nejasnej etiológie, pri skorom nástupe ochorenia, pozitívnej rodinnej anamnéze, mimorenálnych prejavoch alebo pred plánovaním príbuzenskej transplantácie má byť otázka genetického testovania aktívne zvážená.</p>

<p>Nie ako rutinný automatizmus, ale ako cielený nástroj presnejšej diagnostiky a bezpečnejšej, personalizovanej starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Genetic Testing for Kidney Disease Often Not Discussed". <a href="https://www.medscape.com/viewarticle/genetic-testing-kidney-disease-often-not-discussed-2026a1000hf6" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
