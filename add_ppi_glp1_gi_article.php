<?php
/**
 * add_ppi_glp1_gi_article.php
 * Pridanie článku o súbežnom užívaní PPI a GLP-1 agonistov a gastrointestinálnych nežiaducich účinkoch
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
    'title'        => 'Súbežné užívanie inhibítorov protónovej pumpy (PPI) a agonistov GLP-1 môže zvyšovať gastrointestinálne nežiadúce účinky',
    'slug'         => 'subezne-uzivanie-ppi-a-glp-1-gastrointestinalne-neziaduce-ucinky',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Analýza reálnych dát (TriNetX) prezentovaná na SGIM 2026 ukazuje, že pacienti užívajúci GLP-1 agonistu aj PPI súčasne mali viac než dvojnásobne vyššiu pravdepodobnosť gastrointestinálnych nežiaducich účinkov. Výsledky sú asociáciou, nie dôkazom kauzality, no poukazujú na potrebu systematického prehodnotenia indikácie PPI u pacientov na GLP-1.',
    'content'      => <<<'HTML'
<p>Ak užívate liek z triedy GLP-1 agonistov (napr. pri diabetes 2. typu alebo obezite) a zároveň máte nasadené PPI (na reflux, pálenie záhy alebo „žalúdočnú ochranu"), možno vás zaujíma, či tieto lieky nemôžu v kombinácii zhoršovať tráviace ťažkosti. Nová analýza z výskumnej siete TriNetX naznačuje, že áno — a čísla sú pomerne výrazné.</p>

<h2>Čo ukázala nová analýza (TriNetX, SGIM 2026)</h2>

<p>Podľa informácií z Medscape ide o výsledky prezentované na konferencii SGIM 2026, založené na analýze dát z výskumnej siete TriNetX za dlhšie obdobie.</p>

<p>Hlavné zistenia:</p>

<ul>
  <li>Pacienti, ktorí užívali <strong>GLP-1 agonistu aj PPI súčasne</strong>, mali <strong>viac než dvojnásobne vyššiu pravdepodobnosť</strong> výskytu nežiaducich účinkov v hornej časti tráviaceho traktu oproti skupine užívajúcej iba GLP-1 (RR 2,37; 95 % IS 2,30–2,44; <em>p</em> &lt; 0,001).</li>
  <li><strong>Nevoľnosť a vracanie</strong>: približne <strong>1,8×</strong> častejšie (RR 1,81; 95 % IS 1,75–1,88; <em>p</em> &lt; 0,001).</li>
  <li><strong>Tráviace ťažkosti (indigestion)</strong>: približne <strong>3,5×</strong> častejšie (RR 3,50; 95 % IS 3,28–3,75; <em>p</em> &lt; 0,001).</li>
  <li>Častejšie sa uvádzali aj komplikácie, napríklad <strong>akútna pankreatitída</strong> a <strong>žlčníkové kamene</strong> (uvádzané ako zvýšené riziko; priame príčiny sa z dát nedajú jednoznačne uzavrieť).</li>
  <li>Zaznamenali sa tiež rozdiely v nižších častiach tráviaceho traktu: <strong>hnačka, zápcha</strong> a <strong>spomalenie črevnej peristaltiky</strong>.</li>
  <li>Pacienti v kombinácii liekov mali podľa analýzy aj <strong>vyššiu potrebu vyšetrení</strong> typu horná endoskopia.</li>
</ul>

<p>Dôležitý kontext: išlo o porovnanie skupín v reálnych dátach. Čísla popisujú asociáciu, nie priamy dôkaz, že PPI konkrétne „spôsobuje" zhoršenie pri GLP-1.</p>

<h2>Prečo treba byť opatrný v interpretácii</h2>

<p>V článku zaznelo viacero dôvodov na opatrnosť:</p>

<ul>
  <li>Dátam z tejto siete chýbajú detaily o tom, <strong>prečo</strong> bol PPI nasadený (napr. či pacient mal už predtým reflux, dyspepsiu, vredové ochorenie alebo príznaky z tráviaceho traktu).</li>
  <li>Nejde o úplne homogénne skupiny — môžu sa líšiť aj typom GLP-1 lieku a tým, či pacient mal tráviace ťažkosti už pred začiatkom GLP-1.</li>
  <li>GLP-1 samotné často spôsobujú gastrointestinálne príznaky (nevoľnosť, vracanie, spomalené vyprázdňovanie žalúdka), ktoré sa môžu klinicky podobať na refluxové ochorenia.</li>
</ul>

<p>Jednoducho povedané: štúdia dáva signál, že kombinácia sa v praxi spája s vyšším výskytom ťažkostí, ale neumožňuje definitívne tvrdiť kauzalitu.</p>

<h2>Čo to znamená prakticky pre pacienta</h2>

<p>Ak máte GLP-1 agonistu a PPI a objavili sa alebo sa zhoršili tráviace príznaky (pálenie záhy, nevoľnosť, vracanie, bolesti brucha, výrazná zápcha, príznaky zhoršeného trávenia), je rozumné:</p>

<ol>
  <li><strong>Nezvyšovať lieky „na vlastnú päsť"</strong> a nemeniť režim bez dohody s lekárom.</li>
  <li><strong>Prekonzultovať, či PPI potrebujete</strong> a v akej dĺžke. V článku sa spomína tendencia k „depreskribovaniu" PPI, keď to klinicky dáva zmysel.</li>
  <li>Ak by príznaky pretrvávali alebo boli výrazné, lekár môže zvážiť ďalší postup, vrátane toho, že symptomatológia pri GLP-1 môže vyžadovať úpravu liečby alebo ďalšie vyšetrenie.</li>
</ol>

<p>Z nefrologického hľadiska má pri výrazných gastrointestinálnych ťažkostiach význam aj prevencia dehydratácie. Opakované zvracanie alebo výrazná hnačka môže nepriamo zvyšovať riziko zhoršenia hydratácie a následne aj renálnych parametrov, najmä u rizikových pacientov (napr. s chronickým ochorením obličiek). Toto nie je priamy záver štúdie — ide o bežnú klinickú opatrnosť pri takýchto symptómoch.</p>

<h2>Odporúčanie pre klinickú prax</h2>

<p>Ako to z článku vyplýva:</p>

<ul>
  <li>Uvažovať o <strong>systematickom zhodnotení indikácie PPI</strong> u pacientov na GLP-1, najmä ak sa objavili nové alebo zhoršené gastrointestinálne symptómy.</li>
  <li>Nepracovať s automatizmom, že PPI je „bezpečné" bez kontroly dĺžky terapie — treba priebežne vyhodnocovať potrebu pokračovania.</li>
  <li>Zároveň však nie je vhodné vyvolať strach tak, že by sa potrebná liečba refluxu úplne odmietala. Ak má pacient pálenie záhy a klinické dôvody pre terapiu, liečba sa má <strong>individualizovať</strong>.</li>
</ul>

<h2>Zhrnutie</h2>

<p>Reálne dáta naznačujú, že <strong>pacienti na GLP-1 spolu s PPI</strong> majú častejšie gastrointestinálne nežiadúce účinky a vyššiu potrebu vyšetrení. Ide o asociáciu s metodickými limitmi, preto je kľúčové individualizované prehodnotenie liečby a indikácie PPI — nie plošné vysadenie, ale informovaný rozhovor s lekárom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape – „Concurrent Proton Pump Inhibitor, GLP-1 Use Linked to Increases in GI Events". <a href="https://www.medscape.com/viewarticle/concurrent-proton-pump-inhibitor-glp-1-use-linked-increases-2026a1000f38" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

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
                error_log('add_ppi_glp1_gi_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_ppi_glp1_gi_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: Súbežné užívanie PPI a GLP-1 – GI nežiaduce účinky\n";
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
      <title>Migrácia – Súbežné užívanie PPI a GLP-1</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Súbežné užívanie PPI a GLP-1</h2>

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
