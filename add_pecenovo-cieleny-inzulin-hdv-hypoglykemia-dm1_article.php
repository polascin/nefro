<?php
/**
 * add_pecenovo-cieleny-inzulin-hdv-hypoglykemia-dm1_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_pecenovo-cieleny-inzulin-hdv-hypoglykemia-dm1_article.php"
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
    'title'        => 'Pečeňovo cielený inzulín: možná cesta k menšiemu riziku hypoglykémie pri diabete 1. typu',
    'slug'         => 'pecenovo-cieleny-inzulin-hdv-hypoglykemia-dm1',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia fázy 2b OPTI-2 naznačuje, že pečeňovo cielená formulácia rýchlo pôsobiaceho inzulínu (HDV-lispro) by mohla pri diabete 1. typu znížiť riziko hypoglykémie bez zhoršenia glykemickej kontroly. Ide o investigatívnu liečbu, ktorá potrebuje potvrdenie vo fáze 3.',
    'content'      => <<<'HTML'
<p>Hypoglykémia zostáva jedným z najväčších praktických problémov liečby diabetu 1. typu. Aj pri moderných inzulínoch, kontinuálnom monitorovaní glukózy a dôslednej edukácii pacient stále balansuje medzi hyperglykémiou a hypoglykémiou. Nové údaje zo štúdie fázy 2b naznačujú, že pečeňovo cielená formulácia rýchlo pôsobiaceho inzulínu by mohla toto riziko znížiť bez zhoršenia glykemickej kontroly.</p>

<p>Nejde ešte o liek pripravený na bežnú klinickú prax. Ide o investigatívnu liečbu, ktorá potrebuje potvrdenie vo fáze 3. Výsledky sú však klinicky zaujímavé, pretože sa nesnažia len o ďalšie znižovanie HbA1c, ale o bezpečnejšie dosahovanie glykemických cieľov.</p>

<h2>Prečo cieliť inzulín práve do pečene</h2>

<p>U človeka bez diabetu sa inzulín po uvoľnení z pankreasu dostáva najskôr portálnym obehom do pečene. Pečeň je preto prirodzene významným miestom inzulínového pôsobenia. Pri subkutánne podávanom inzulíne je však distribúcia iná. Inzulín sa najskôr dostáva do systémovej cirkulácie a pečeň nie je vystavená rovnakému fyziologickému inzulínovému signálu ako pri normálnej sekrécii.</p>

<p>Skúšaný prípravok HDV inzulín, teda hepatic-directed vesicle insulin, využíva špeciálnu fosfolipidovú matricu, ktorá sa viaže na krátkodobo pôsobiaci inzulín, napríklad lispro. Cieľom je nasmerovať väčšiu časť účinku inzulínu do pečene.</p>

<p>Mechanisticky to dáva zmysel. Ak je pečeň lepšie „inzulinizovaná“, môže efektívnejšie ukladať glukózu vo forme glykogénu. Tento glykogén potom môže byť dôležitý v období klesajúcej glykémie. Hypotéza je teda taká, že pečeňovo cielený inzulín môže znížiť riziko hypoglykémie tým, že podporí fyziologickejšie hospodárenie pečene s glukózou.</p>

<h2>Štúdia OPTI-2: čo sa testovalo</h2>

<p>Údaje pochádzajú z randomizovanej, dvojito zaslepenej štúdie fázy 2b OPTI-2, prezentovanej na vedeckom kongrese American Diabetes Association v roku 2026.</p>

<p>Do štúdie bolo zaradených 226 dospelých s diabetom 1. typu. Porovnávali sa dve stratégie:</p>

<ul>
  <li>HDV kombinovaný s inzulínom lispro,</li>
  <li>štandardný inzulín lispro.</li>
</ul>

<p>Všetci účastníci používali intenzifikovanú inzulínovú liečbu s bazálnym inzulínom degludek jedenkrát denne a všetci mali kontinuálne monitorovanie glukózy Dexcom G7.</p>

<p>Medián východiskového HbA1c bol približne 7,3 až 7,4 %. Štúdia mala 12-týždňovú fázu optimalizácie dávok a následne 13-týždňovú udržiavaciu fázu.</p>

<p>Primárny cieľ bol pomerne ambiciózny. Zahŕňal noninferioritu v HbA1c a zároveň lepšie výsledky v parametroch hypoglykémie, najmä pri nočnej hypoglykémii pod 54 mg/dl (3,0 mmol/l).</p>

<h2>Glykemická kontrola sa nezhoršila</h2>

<p>Z hľadiska HbA1c bol HDV-lispro noninferiórny voči štandardnému lispru. Po 12 týždňoch sa HbA1c znížil o 0,34 percentuálneho bodu pri HDV-lispro a o 0,42 pri štandardnom lispre. Rozdiel nebol štatisticky významný.</p>

<p>Po 25 týždňoch bol pokles HbA1c 0,31 percentuálneho bodu pri HDV-lispro a 0,38 pri štandardnom lispre. Aj tu išlo o malý, štatisticky nevýznamný rozdiel. Výsledky splnili požiadavku FDA na noninferioritu v HbA1c.</p>

<p>Prakticky to znamená, že pečeňovo cielený inzulín v tejto štúdii nezhoršil celkovú glykemickú kontrolu. To je dôležité, pretože zníženie hypoglykémie má klinickú hodnotu najmä vtedy, ak sa nedosiahne za cenu vyššej hyperglykémie.</p>

<h2>Menej hypoglykémií, najmä v udržiavacej fáze</h2>

<p>Počas fázy titrácie dávok síce väčšina parametrov kontinuálneho monitorovania glukózy favorizovala HDV-lispro, ale primárny cieľ tesne nedosiahol štatistickú superioritu.</p>

<p>Zaujímavejšie boli výsledky v udržiavacej fáze. HDV-lispro dosiahol štatisticky významne lepšie výsledky vo viacerých sekundárnych ukazovateľoch:</p>

<ul>
  <li>28 % zníženie 24-hodinových epizód hypoglykémie 2. stupňa pod 54 mg/dl (3,0 mmol/l),</li>
  <li>33 % zníženie denných epizód hypoglykémie 2. stupňa,</li>
  <li>28 % zníženie času stráveného pod 54 mg/dl (3,0 mmol/l) počas 24 hodín,</li>
  <li>32 % zníženie denného času pod 54 mg/dl (3,0 mmol/l),</li>
  <li>36 % zníženie predĺžených hypoglykemických epizód.</li>
</ul>

<p>Počas celej štúdie bola incidencia hypoglykémie 2. stupňa pri HDV-lispro o 25 % nižšia než pri štandardnom lispre.</p>

<p>Z klinického hľadiska je dôležitý aj údaj o ťažkej hypoglykémii. V skupine s HDV-lispro sa nevyskytla žiadna hypoglykémia 3. stupňa vyžadujúca pomoc inej osoby. V skupine so štandardným lisprom ich bolo päť. Tento rozdiel však tesne nedosiahol konvenčnú štatistickú významnosť.</p>

<h2>Bez významného bezpečnostného signálu, ale sledovanie pečene bude kľúčové</h2>

<p>Nežiaduce udalosti boli medzi skupinami podobné. V skupine HDV-lispro sa vyskytli u 53,6 % pacientov, pri štandardnom lispre u 50 %. Závažné liečbou súvisiace nežiaduce udalosti boli hlásené u jedného pacienta v skupine HDV-lispro a u ôsmich pacientov v skupine so štandardným lisprom.</p>

<p>Neboli hlásené úmrtia, prípady diabetickej ketoacidózy ani klinicky významné pečeňové bezpečnostné signály.</p>

<p>To je povzbudivé, ale treba zostať opatrný. Ak je mechanizmus účinku zameraný na pečeň, dlhodobejšia hepatálna bezpečnosť bude jednou z kľúčových otázok vo väčšej štúdii fázy 3. Malá až stredne veľká štúdia fázy 2 nemusí zachytiť zriedkavé alebo dlhodobé nežiaduce účinky.</p>

<h2>Čo tieto výsledky znamenajú pre prax</h2>

<p>Pre bežnú klinickú prax zatiaľ nič nemenia. HDV-lispro je investigatívny prípravok a jeho účinnosť a bezpečnosť musia byť potvrdené vo väčšej fáze 3.</p>

<p>Napriek tomu je smer vývoja veľmi dôležitý. V diabetológii sa dlho sústredíme na HbA1c, time in range a redukciu hyperglykémie. Pacienti s diabetom 1. typu však často nežijú len s vysokou glykémiou, ale aj so strachom z hypoglykémie. Tento strach ovplyvňuje dávkovanie inzulínu, fyzickú aktivitu, spánok, šoférovanie aj kvalitu života.</p>

<p>Kontinuálne monitorovanie glukózy je obrovský pokrok, ale samo osebe hypoglykémii vždy nezabráni. Upozorní na riziko, pomáha rozhodovať, ale nemení základnú farmakológiu inzulínu. Preto majú liečebné stratégie, ktoré by vedeli znížiť hypoglykémiu bez zhoršenia HbA1c, veľký potenciál.</p>

<h2>Praktický klinický záver</h2>

<p>Pečeňovo cielený HDV-lispro v štúdii fázy 2b zachoval glykemickú kontrolu porovnateľnú so štandardným lisprom a v udržiavacej fáze znížil viaceré parametre hypoglykémie merané kontinuálnym monitorovaním glukózy. Výsledky sú sľubné, ale zatiaľ predbežné.</p>

<p>Najrozumnejšia interpretácia je triezva: nejde o prelom potvrdený pre prax, ale o mechanisticky zaujímavý a klinicky relevantný koncept, ktorý si zaslúži veľkú štúdiu fázy 3. Ak sa účinok potvrdí, mohlo by ísť o významný krok k bezpečnejšej inzulínovej liečbe diabetu 1. typu.</p>

<div class="info-box-blue">
<p><strong>Poznámka — prepočet jednotiek glukózy.</strong> Hodnoty v mmol/l uvedené v zátvorkách sú prepočítané z mg/dl a zaokrúhlené na jedno desatinné miesto. Pre glukózu v krvi platí:</p>
<ul>
  <li>mmol/l = mg/dl ÷ 18 (čiže mg/dl × 0,0555),</li>
  <li>mg/dl = mmol/l × 18.</li>
</ul>
</div>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Liver-Directed Insulin: New Way to Reduce Hypoglycemia?</em> (2026). <a href="https://www.medscape.com/viewarticle/liver-directed-insulin-new-way-reduce-hypoglycemia-2026a1000j57" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
        // Newsletter avíza posielame LEN pri novom článku (rc === 1), nikdy pri update.
        $rc = $stmt->rowCount();
        if ($rc === 1) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } elseif ($rc === 2) {
            $updated++;
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
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
