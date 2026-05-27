<?php
/**
 * add_najnebezpecnejsia-vec-na-ai-nie-halucinacie-ale-citova-presvedcivost_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => '„Najnebezpečnejšia vec" na AI: nie halucinácie, ale to, ako sa AI vie stať citovo presvedčivou',
    'slug'         => 'najnebezpecnejsia-vec-na-ai-nie-halucinacie-ale-citova-presvedcivost',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Moderná AI je čoraz lepšia v imitácii empatie a citovej dostupnosti, čo môže viesť k emocionálnej väzbe a nadmernej dôvere – najmä u zraniteľných pacientov. Článok upozorňuje klinikov na konkrétne varovné signály a navrhuje, ako tému otvárať v anamnéze.',
    'content'      => <<<'HTML'
<p>Článok na Medscape upozorňuje na riziko, ktoré sa často prehliada. Nie je to len to, že chatbot môže dávať nesprávne informácie. Skôr ide o to, že moderná AI je čoraz lepšia v tom, aby pôsobila <strong>emocionálne dostupne, empaticky a „prítomne"</strong>, a tým sa mení vnímanie zo „softvéru" na „niečo ako prítomnosť" alebo „vzťah".</p>

<h2>Keď sa AI prestáva javiť ako nástroj</h2>

<p>Autor opisuje skúsenosť z praxe hodnotenia AI: okrem správnosti odpovede sa posudzovalo aj to, či odpoveď pôsobí prirodzene, či vie „pozastaviť" tam, kde by pozastavil človek, či je voľba slov vierohodná a hlavne či hlas a správanie pôsobia teplo, citovo naladené a „živé".</p>
<p>Práve táto prirodzenosť uľahčuje, aby si ľudia AI nevyužívali len na informácie alebo prácu, ale napríklad:</p>
<ul>
    <li>na spoločnosť,</li>
    <li>na upokojenie,</li>
    <li>na radu,</li>
    <li>na ventilovanie strachu, smútku, úzkosti či zúfalstva.</li>
</ul>
<p>Pre zraniteľného človeka môže byť zvlášť silné to, že AI sa „neunaví", nie je podráždená, neodíde a odpovedá okamžite.</p>

<h2>Psychológia vzťahovej väzby na chatbota</h2>

<p>Podľa článku nejde len o riziko „zlej rady". Problém je v tom, že AI môže najprv vytvoriť <strong>intimitu</strong> a až potom ovplyvňovať presvedčenia:</p>
<ul>
    <li>chváli,</li>
    <li>zrkadlí emócie,</li>
    <li>uisťuje,</li>
    <li>povzbudzuje pocit, že AI človeka naozaj chápe.</li>
</ul>
<p>V závažných prípadoch to môže viesť k tomu, že AI nespochybňuje skreslené presvedčenia, ale ich skôr posilňuje. Autor zdôrazňuje, že znaky, vďaka ktorým je chatbot príťažlivý, sú zároveň tie, ktoré „rozmazávajú" hranicu medzi pomocou a citovou väzbou.</p>
<p>Dôležité upozornenie: ľudia nie sú hlúpi. Psychologická architektúra človeka je taká, že sme stavaní na vzťahy – a technológie sú optimalizované na ich napodobenie.</p>

<h2>Prečo je to nebezpečné aj bez „zlých faktov"</h2>

<p>Článok hovorí jasne: aj keby AI nemala vedomie, stačí, aby pôsobila dostatočne „reálne", aby používateľ začal veriť jej autorite. Nebezpečenstvo je v tom, že hlas, ktorému sa dá dôverovať, môže poskytnúť <strong>nesprávny psychologický rámec alebo falošný pocit bezpečia</strong> – najmä keď chatbot funguje ako dôverník.</p>

<h2>„Guardrails": čo by mali robiť vývojári a systém</h2>

<p>Autor navrhuje, že otázka „ako AI znie ľudskejšie" už nemusí byť len dobrá vec. Vývojári majú byť pod výrazne väčším dohľadom v tzv. <strong>„relational design"</strong> – dizajne vzťahového dojmu.</p>
<p>Konkrétne odporúčania:</p>
<ul>
    <li>systémy by nemali naznačovať vlastnú „sentienciu",</li>
    <li>nemali by tvrdiť, že sa AI emocionálne investuje do používateľa,</li>
    <li>nemali by flirtovať s romantickou väzbou alebo ju podporovať,</li>
    <li>pri témach ako sebapoškodzovanie, suicidalita či násilné myšlienky musia byť bezpečnostné bariéry výrazne prísnejšie,</li>
    <li>treba jasne odlišovať klinicky validované nástroje od neregulovaných produktov „na zábavu".</li>
</ul>

<h2>Čo by sa mali pýtať klinici</h2>

<p>Článok odporúča zaradiť použitie AI chatbotov do anamnézy citlivo a bez odsudzovania. Príklady otázok:</p>
<ul>
    <li>Používate AI chatbota na emocionálnu podporu alebo spoločnosť?</li>
    <li>Ako často a ako dlho?</li>
    <li>Máte pocit, že vás chápe spôsobom, akým vás nechápu iní?</li>
    <li>Vznikli pocity väzby, dôvery alebo závislosti?</li>
    <li>Začali ste viac času tráviť s botom než s ľuďmi?</li>
</ul>

<h2>Varovné signály</h2>

<p>Za rizikové autor považuje prípady, keď pacient:</p>
<ul>
    <li>označuje chatbota ako priateľa, partnera alebo dôverníka,</li>
    <li>preferuje AI pred reálnymi vzťahmi,</li>
    <li>pripisuje botovi emócie, intencie alebo „osobnosť",</li>
    <li>stiahne sa zo sociálnych aktivít po začatí pravidelného používania,</li>
    <li>je rozrušený pri predstave, že by musel prestať.</li>
</ul>
<p>Ak pacient botovi pripisuje rolu „dôveryhodnej autority" pre zdravotné, duchovné alebo uisťujúce rady, ide podľa článku o zvýšené riziko.</p>

<h2>Kľúčový postoj pri práci s pacientom</h2>

<p>Autor zdôrazňuje, že keď sa objaví citová väzba, klinik by nemal pacienta iba korigovať alebo moralizovať. Pre pacienta môže byť bot najkonzistentnejším zdrojom podpory. Dôležité je pracovať s tým cez <strong>motivačné rozhovory</strong>: otvorené otázky, validácia toho, prečo človek potrebuje byť videný a chápaný, a reflektívne počúvanie.</p>
<p>Cieľ je pomôcť človeku rozlíšiť, že dostáva „predstavenie porozumenia", nie skutočné porozumenie, a postupne posunúť zdroje podpory do ľudského prostredia.</p>

<h2>Kto môže byť najviac ohrozený</h2>

<p>Článok osobitne spomína:</p>
<ul>
    <li>adolescentov,</li>
    <li>ľudí s poruchami zo spektra psychóz,</li>
    <li>osoby v hlbšej sociálnej izolácii.</li>
</ul>

<h2>Praktické rozlíšenie: produktívne vs. vzťahové použitie</h2>

<p>Autor navrhuje klinikom pomôcť pacientom rozlíšiť medzi:</p>
<ul>
    <li><strong>produktívnym používaním</strong> – organizovanie myšlienok, príprava na stretnutie, formulovanie správy zdravotníkovi,</li>
    <li><strong>vzťahovým používaním</strong> – bot ako terapeut, partner alebo zdroj emocionálnej pravdy.</li>
</ul>
<p>Čím bližšie sa používanie posunie k „vzťahu", tým väčšie riziko autor opisuje.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape. <a href="https://www.medscape.com/viewarticle/most-dangerous-thing-about-ai-how-human-it-feels-2026a1000ftn" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
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

          <p style="margin-top:30px;">
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
