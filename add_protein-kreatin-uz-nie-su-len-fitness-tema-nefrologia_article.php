<?php
/**
 * add_protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia_article.php"
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
    'title'        => 'Proteín a kreatín už nie sú výhradne „fitness téma“ a čo z toho plynie pre nefrológiu',
    'slug'         => 'protein-kreatin-uz-nie-su-len-fitness-tema-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Proteín a kreatín sa z okrajovej „fitness témy“ presunuli do bežných rozhovorov v ambulancii. Medscape zhŕňa päť praktických otázok o bezpečnosti, dávkovaní a výbere. Pre nefrológiu je kľúčové inak odpovedať pacientovi bez ochorenia obličiek a inak pacientovi s CKD (vrátane opatrnej interpretácie kreatinínu).',
    'content'      => <<<'HTML'
<h2>Prečo sa to dnes týka takmer každého pacienta</h2>

<p>Medicína sa v posledných rokoch stretáva s novou realitou: doplnky výživy, ktoré boli kedysi doménou športu, sa stali súčasťou bežných rozhovorov v ambulancii. V praxi to znamená, že lekár sa čoraz častejšie pýta na dve otázky naraz: „Je to bezpečné?“ a „Ako to správne dávkovať?“</p>

<p>Z hľadiska nefrológie je kľúčové, že najčastejšie obavy pacientov sa sústreďujú na to, či vyšší príjem bielkovín „nezničí“ obličky a či kreatín nie je rizikový. Medscape v tomto kontexte zdôrazňuje, že diskusia o proteíne a kreatíne musí prejsť z roviny „sú to doplnky?“ do roviny „ako ich zasadiť do cielenej výživovej stratégie?“.</p>

<h2>Ako sa proteín a kreatín líšia (a prečo je to praktické)</h2>

<p>Autori rámcujú proteín ako stavebnú zložku (svaly, hormóny, obnova), teda ako nutričnú podporu pre regeneráciu a udržiavanie štíhlej telesnej hmoty.</p>

<p>Kreatín je naopak substrát pre rýchly energetický výkon, takže jeho praktický význam sa viaže najmä na silu a výkon. Medscape zároveň spomína rastúci záujem o možné kognitívne alebo neuroprotektívne využitie, pričom dôkazy sa ešte vyvíjajú.</p>

<h2>Otázka 1: Je vyšší príjem bielkovín alebo kreatínu nebezpečný pre obličky?</h2>

<p>Medscape uvádza, že „obava o obličky“ často stojí na historickom predpoklade, že vysokobielkovinová diéta poškodzuje obličky u zdravých jedincov. Tento koncept sa však v ďalších prácach opakovane spochybnil.</p>

<p>Dôležitý praktický záver pre ambulanciu je, že informáciu treba podávať diferencovane. Na otázku rizika sa totiž nedá odpovedať jednou vetou pre všetkých: pacient bez ochorenia obličiek potrebuje inú odpoveď než pacient s chronickým ochorením obličiek.</p>

<p>Ak sa pacient pýta na bezpečnosť, odporúčanie v duchu článku smeruje k tomu, že proteín sa dá zaradiť ako výživová stratégia a že kreatín má veľmi priaznivý bezpečnostný profil v kontexte športovej výživy.</p>

<h2>Otázka 2: Koľko proteínu sa odporúča a ako sa mení situácia pri GLP-1?</h2>

<p>V článku zaznieva odporúčací rámec, ktorý sa u dospelých opiera o približne <strong>1,2 až 1,6 g proteínu na kilogram telesnej hmotnosti denne</strong>.</p>

<p>Medscape opisuje aj konkrétnejšie „počítanie“ cez príklady (napr. pri 82 kg približne 100 až 130 g denne).</p>

<p>Pri liečbe GLP-1 sa však mení praktická realita: pacienti majú znížený apetít a často klesá aj príjem potravy vrátane bielkovín. V článku sa preto uvádza, že v praxi sa často mieri na <strong>nižší denný cieľ okolo 1 až 1,2 g/kg/deň</strong>, pričom zachovanie svalovej hmoty sa dosahuje najmä kombináciou bielkovín a odporového tréningu (proteín je „druhý v poradí“ za tréningom).</p>

<h2>Otázka 3: Aký proteín a ktorý kreatín vybrať</h2>

<p>Pre kreatín je odpoveď v článku relatívne jednoduchá: preferovať <strong>kreatín monohydrát</strong> a produkty od etablovaných výrobcov s <strong>nezávislým testovaním treťou stranou (third-party)</strong>.</p>

<p>Pri proteíne je výber zložitejší. Medscape zdôrazňuje princíp: „najlepší proteín je ten, ktorý pacient toleruje, dokáže pravidelne používať a ktorý zapadá do jeho stravovania a cieľov“.</p>

<p>Z hľadiska kvality sa v článku spomína, že srvátkový izolát (whey) je zvyčajne veľmi „praktický“ (leucín, stráviteľnosť). Pri vegánskych režimoch sa uvádza, že rastlinné (plant-based) zmesi môžu fungovať podobne, ak obsahujú leucín a sú zostavené tak, aby podporovali stimuláciu syntézy svalových bielkovín.</p>

<h2>Otázka 4: Koľko proteínu naraz a je „viac“ plytvanie?</h2>

<p>Medscape rozlišuje dve roviny:</p>

<ol>
  <li>Koľko proteínu stačí na maximálnu stimuláciu syntézy bielkovín.</li>
  <li>Či sú vyššie dávky v jednom jedle bez efektu.</li>
</ol>

<p>Podľa článku vyššie jednorazové množstvá nie sú automaticky „plytvaním“. Celkový denný príjem a kvalita proteínu majú dôležitejšiu úlohu než to, či je proteín rozdelený do jedného alebo viacerých jedál.</p>

<p>Pre orientáciu pri cieľoch stimulácie článok uvádza rámec, že približne 20 g v jednom jedle býva dostatočných pre mladších dospelých, okolo 30 g pre starších a vyššie hodnoty (napr. 40 g) môžu syntézu maximalizovať pre väčšinu ľudí.</p>

<h2>Otázka 5: Majú zmysel doplnky bez tréningu?</h2>

<p>V článku zaznieva, že v určitých prípadoch áno — najmä ak pacient nedokáže pokryť potrebu bielkovín jedlom (menší apetít, starší vek, vynechávanie raňajok, obmedzenia v príjme).</p>

<p>Zároveň však Medscape uzatvára, že pre väčšinu ľudí majú proteínové a kreatínové doplnky najväčší benefit práve v kontexte stratégie zameranej na posilňovanie a udržiavanie svalovej hmoty. Kreatín môže mať širší význam pri záujme o kognitívne benefity, ale aj tam treba počítať s tým, že dôkazy nie sú „finálne“.</p>

<h2>Praktické nefrologické poznámky (ako to pretaviť do ambulantnej praxe)</h2>

<p>Tento článok na Medscape je orientovaný skôr na všeobecné otázky pacientov a na klinickú komunikáciu. Pri nefrológii je však užitočné pretaviť jeho posolstvo do bezpečnej praxe:</p>

<ul>
  <li><strong>U pacientov s normálnou funkciou obličiek</strong> sa obava z proteínu často podáva tak, akoby bola univerzálna. Článok naznačuje, že tento strach je historicky prehnaný a opakovane spochybnený.</li>
  <li><strong>U pacientov s chronickým ochorením obličiek</strong> nie je rozumné preberať „jednu dávku pre všetkých“. V praxi treba zohľadniť štádium, trend eGFR, albuminúriu, metabolický profil a toleranciu stravy.</li>
  <li>Pri <strong>kreatíne</strong> treba mať na pamäti, že aj keď má v športovej výžive priaznivý bezpečnostný profil, v populácii s CKD môže byť potrebné sledovať laboratórne ukazovatele a interpretovať zmeny kreatinínu opatrne (aby sa nezamieňali príčiny zmeny hodnoty).</li>
</ul>

<p>Ak teda pacient príde s otázkou „koľko a je to bezpečné?“, dobrá odpoveď nie je len „áno“ alebo „nie“, ale krátky rámec: <strong>cieľ, dávka, kontext ochorenia obličiek a následné monitorovanie</strong>.</p>

<h2>Zhrnutie pre nefrologickú prax</h2>

<p>Medscape posúva proteín a kreatín z pozície okrajových doplnkov do bežnej zdravotnej komunikácie. Pre nefrológiu z toho vyplýva, že v ambulancii treba:</p>

<ol>
  <li>jasne rozlíšiť otázky pre osoby bez ochorenia obličiek a pre osoby s CKD,</li>
  <li>ponúknuť pacientovi dávkovací rámec v kontexte cieľa (udržanie svalovej hmoty, GLP-1, apetít),</li>
  <li>u kreatínu preferovať overenú formu a pri CKD nastaviť opatrné sledovanie.</li>
</ol>

<hr>

<p><em><strong>Zdroj:</strong> Lou Schuler, <em>Protein and Creatine Supplements Are No Longer Niche</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/protein-and-creatine-supplements-are-no-longer-niche-2026a1000kqn" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
