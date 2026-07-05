<?php
/**
 * add_extremne-horucavy-podcenovanie-zdravotnych-rizik-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Extrémne horúčavy a podceňovanie zdravotných rizík (nefrológia).
 * Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie jedného zdroja
 * (Medscape). Menovaní ľudia v zdroji sú odborníci CITOVANÍ v texte (interviewovaní),
 * nie bylinoví autori → source_authors.php sa nedopĺňa (pozri pravidlo v ňom).
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Extrémne horúčavy a podceňovanie zdravotných rizík: čo to znamená aj pre nefrológiu',
    'slug'         => 'extremne-horucavy-podcenovanie-zdravotnych-rizik-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Extrémne horúčavy zasahujú viac orgánových systémov naraz a ich dôsledky sa často podceňujú, lebo sa zriedka uvádzajú ako priama príčina ochorenia. Pre nefrológiu je kľúčové, že teplo ľahšie spúšťa dehydratáciu, elektrolytové poruchy a krehkú obehovú rovnováhu — najmä u pacientov s ochorením obličiek a pri liečbe diuretikami.',
    'content'      => <<<'HTML'
<p>Extrémne teploty už nie sú len „letná nepríjemnosť“. Nové údaje podľa prehľadu Medscape ukazujú, že horúčavy výrazne zasahujú viac orgánových systémov naraz a sú spojené s vyššou chorobnosťou aj s vyšším počtom hospitalizácií. Zdôrazňuje sa aj to, že presný dosah sa často ťažko meria, lebo horúčavy nebývajú v záznamoch uvádzané ako priama príčina ochorenia či úmrtia, a preto sa používajú štatistické modely.</p>

<p>Článok predstavuje horúčavy ako významné environmentálne zdravotné riziko, ktoré narastá spolu s frekvenciou a dĺžkou horúčavových epizód.</p>

<h2>Prečo je riziko „podceňované“</h2>

<p>Horúčavy sa v praxi zriedkavo označujú ako jediná príčina diagnózy. Ich dosah sa preto odhaduje nepriamo. Ako príklad sa uvádza, že Inštitút Roberta Kocha odhadol približne 2 500 úmrtí v Nemecku v roku 2025, ktoré možno pripísať horúčavám, pričom ide o modelovaný odhad.</p>

<p>Okrem úmrtnosti sa v prácach objavujú aj ukazovatele chorobnosti. Po jednom dni s teplotami nad 30 °C sa uvádza nárast hlásení práceneschopnosti o 3,5 %, po piatich po sebe nasledujúcich dňoch bol nárast vyšší a po siedmich dňoch dosiahol 10,8 %.</p>

<h2>Mechanizmy: prečo horúčavy poškodzujú orgány</h2>

<p>Prehľad zdôrazňuje, že horúčavy zaťažujú kardiovaskulárny, dýchací aj nervový systém a zároveň zvyšujú riziká spojené s dehydratáciou.</p>

<p>Kľúčové mechanizmy, ktoré článok opisuje:</p>

<ul>
  <li><strong>Kardiovaskulárna záťaž:</strong> pri rozšírení ciev klesá krvný tlak a srdce musí pracovať intenzívnejšie. U ľudí s pridruženými ochoreniami to zvyšuje riziko angíny pektoris, infarktu myokardu, srdcového zlyhávania a arytmií.</li>
  <li><strong>Dehydratácia a poruchy elektrolytov:</strong> nadmerné potenie a strata tekutín môžu viesť k dehydratácii a elektrolytovým odchýlkam, čím sa zvyšuje riziko obehového kolapsu a trombózy.</li>
  <li><strong>Súbeh faktorov:</strong> horúčavy často prebiehajú súčasne so zvýšenou koncentráciou ozónu a tuhých častíc, čo môže zhoršovať respiračné ochorenia vrátane CHOCHP a astmy.</li>
  <li><strong>Lieky ako zosilňujúci faktor:</strong> spomínajú sa najmä diuretiká a betablokátory, ktoré môžu obehovú stabilitu a hydratáciu ešte zhoršiť.</li>
</ul>

<h3>Osobitne zraniteľné skupiny</h3>

<p>Za najviac postihnutú skupinu článok uvádza starších ľudí. Riziko zvyšuje aj nízky socioekonomický status, poruchy užívania návykových látok, obmedzená mobilita, pľúcne a kardiovaskulárne ochorenia, geriatrické psychiatrické stavy a užívanie sedatív.</p>

<h2>Mozog, nervový systém a psychika</h2>

<p>Horúčavy môžu ovplyvniť nervový systém viacerými mechanizmami. V texte sa uvádza napríklad oxidačný stres, zápalové zmeny a porucha hematoencefalickej bariéry. Zvyšuje sa riziko cievnej mozgovej príhody, môžu sa zhoršovať príznaky pri Parkinsonovej chorobe a roztrúsenej skleróze a existujú dôkazy, že teplo môže vyvolávať záchvaty alebo zhoršovať priebeh epilepsie či migrény. Pri demencii sa uvádza súvislosť s vyšším počtom hospitalizácií a úmrtí.</p>

<p>Článok zároveň spomína aj psychické dôsledky: zníženú schopnosť sústrediť sa, horší spánok, podráždenosť a v niektorých prípadoch agresívne správanie.</p>

<h2>Prečo je horúčava relevantná aj v nefrológii</h2>

<p>V prehľade je jasne uvedené, že <strong>ľudia s ochorením obličiek</strong> patria medzi obzvlášť zraniteľných pacientov. Toto tvrdenie sa opiera o mechanizmy, ktoré sú v nefrológii klinicky dobre známe:</p>

<ol>
  <li><strong>Dehydratácia a pokles perfúzie.</strong> Pri strate tekutín a rozkolísaní cirkulácie sa môže zhoršiť perfúzia obličiek a rastie riziko akútneho zhoršenia obličkových funkcií. Článok to priamo neoznačuje ako „AKI pri horúčavách“, ale opisuje dehydratáciu a elektrolytové poruchy ako rizikové faktory, ktoré môžu u pacientov s chronickým ochorením obličiek rýchlejšie viesť ku klinickému zhoršeniu.</li>
  <li><strong>Elektrolytové poruchy.</strong> Horúčavy môžu zvyšovať riziko porúch elektrolytov. U nefrologických pacientov je fyziologická rezerva často menšia, a preto je o to dôležitejšie zamerať sa na včasné rozpoznanie prejavov a skorú úpravu režimu.</li>
  <li><strong>Lieky a ich „teplotná“ stránka.</strong> Diuretiká sú v texte explicitne spomenuté. Prakticky to znamená, že počas horúčav sa pacient môže ľahšie dostať do situácie, v ktorej je obehová rovnováha krehká: na jednej strane potreba kontroly retencie tekutín, na druhej strane riziko hypovolémie z dehydratácie. Pri nefrologických diagnózach sa preto liečebný režim počas horúčav nesmie upravovať paušálne, ale vyžaduje individuálne posúdenie ošetrujúcim tímom.</li>
</ol>

<h2>Čo by mali riešiť ambulancie a oddelenia (prakticky)</h2>

<p>Keďže článok zdôrazňuje rastúce zdravotné bremeno a potrebu adaptačných opatrení, dá sa z neho odvodiť viacero praktických odporúčaní. V nefrológii ich možno rozčleniť do troch rovín: prevencia, včasné rozpoznanie a systémová pripravenosť.</p>

<ul>
  <li><strong>Prevencia pred horúčavou:</strong> identifikovať pacientov s ochorením obličiek, ktorí majú vyššie riziko dekompenzácie pri tepelnej záťaži, a pripraviť im jednoduchý režimový plán (príjem tekutín, sledovanie subjektívnych príznakov, kedy kontaktovať lekára).</li>
  <li><strong>Včasné rozpoznanie:</strong> zhoršenie stavu hydratácie, slabosť, závraty, zmeny v močení, zhoršenie stavu pri známom chronickom ochorení obličiek, prípadne dekompenzáciu pridružených ochorení treba vnímať ako potenciálne časové okno na intervenciu.</li>
  <li><strong>Systémová úroveň:</strong> článok uvádza, že do konca roka 2024 malo iba 20 nemeckých obcí (z viacerých tisíc) vypracovaný akčný plán ochrany zdravia počas horúčav (tzv. heat-health action plan). Zároveň sa spomína povinnosť takéto plány vypracovať a pravidelne aktualizovať výstražné systémy aj akčné plány. Pre nefrologické zariadenia to znamená mať pripravené postupy pre rizikové skupiny, zabezpečenú dostupnosť podpory a včasnú komunikáciu pri výstrahách.</li>
</ul>

<h2>Deti, gravidita a dlhodobá záťaž</h2>

<p>Hoci nejde primárne o nefrologickú tému, článok uvádza dôležité informácie: deti sú citlivejšie, lebo ich termoregulácia sa ešte vyvíja a sú viac odkázané na starostlivosť iných. V súvislosti s graviditou sa uvádza, že horúčava môže viesť k dehydratácii a kardiovaskulárnej záťaži; viaceré štúdie navyše spájajú tepelný stres s predčasným pôrodom.</p>

<h2>Záver</h2>

<p>Extrémne horúčavy sa podľa zdroja menia na trvalú zdravotnú hrozbu, ktorá zasahuje srdce, pľúca, obličky aj mozog. Pre nefrológiu je kľúčové vnímať horúčavu ako situáciu, v ktorej sa ľahšie aktivujú mechanizmy dehydratácie a elektrolytových porúch a v ktorej môžu niektoré lieky riziko ešte zosilniť. Klinicky to znamená včasnú prevenciu, jasné pravidlo „kedy kontaktovať lekára“ a pripravenosť na rýchlu reakciu pri výstrahách.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, článok „Extreme Heat: Are Health Risks Being Underestimated?“. <a href="https://www.medscape.com/viewarticle/extreme-heat-are-health-risks-being-underestimated-2026a1000ldr" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em>Odborníci citovaní v pôvodnom článku: Alexandra Schneider, Martin Röösli, Veronika Huber, Kilian Rapp, Ameli Breuer, Sebastian Karl, Marie Standl, Dirk Holzinger, Petra Arck, Anke Diemert, Clemens Becker, Kerstin Kammerer.</em></p>

<p><em><strong>Poznámka:</strong> Tento článok má vzdelávací a osvetový charakter a nenahrádza individuálne klinické rozhodovanie ošetrujúceho tímu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše existujúci článok (regenerácia).
// Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
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
