<?php
/**
 * add_povysenecky-ton-medicina-jednoduchy-jazyk_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o povýšeneckej komunikácii v medicíne
 * a hranici medzi zrozumiteľnosťou a infantilizáciou (Medscape).
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
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Povýšenecký tón v medicíne: keď jednoduchý jazyk prestáva byť rešpektujúci',
    'slug'         => 'povysenecky-ton-medicina-jednoduchy-jazyk',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Zrozumiteľná komunikácia nie je to isté ako infantilizácia. Článok na Medscape upozorňuje, že prehnane zjednodušený alebo povýšenecký jazyk vrátane „elderspeak“ môže pacienta podceniť a narušiť dôveru.',
    'content'      => <<<'HTML'
<p>Komunikácia medzi lekárom a pacientom patrí medzi najdôležitejšie časti medicíny. Správne vysvetlenie diagnózy, liečby a ďalšieho postupu môže rozhodnúť o tom, či pacient porozumie svojmu stavu, bude spolupracovať a bude sa cítiť bezpečne. Zároveň však platí, že komunikácia nie je iba o jednoduchosti. Je aj o dôstojnosti, rešpekte a citlivom odhade konkrétneho človeka.</p>

<p>Na tento problém upozorňuje článok Aryu Anthonyho Kamyaba publikovaný na portáli Medscape. Autor kriticky opisuje jav, ktorý mnohí pacienti poznajú z vlastnej skúsenosti: lekár síce hovorí zrozumiteľne, ale zároveň tak zjednodušene, že pacient má pocit, akoby sa s ním hovorilo ako s dieťaťom.</p>

<h2>Jednoduchý jazyk je potrebný, ale nie univerzálny</h2>

<p>Medicína dlhodobo učí lekárov, aby sa vyhýbali odbornému žargónu. Tento prístup má dobrý dôvod. Pacient, ktorý nerozumie tomu, čo mu lekár hovorí, nemusí správne pochopiť diagnózu, odporúčania ani prepúšťacie pokyny. To môže mať priamy dopad na bezpečnosť liečby.</p>

<p>Odborné termíny môžu byť navyše zavádzajúce. Slovo „chronický“ znamená v medicíne dlhodobý alebo pretrvávajúci, kým pacient ho môže chápať ako „ťažký“ alebo „vážny“. Preto má zmysel hovoriť pomaly, jasne, overovať porozumenie a nepoužívať odborný jazyk tam, kde nie je potrebný.</p>

<p>Problém vzniká vtedy, keď sa z rozumného odporúčania stane nemenné pravidlo. Nie každý pacient potrebuje rovnaké vysvetlenie. Nie každý pacient chce rovnakú mieru detailu. A nie každý pacient vníma extrémne zjednodušenie ako pomoc.</p>

<h2>Rozdiel medzi zdravotnou gramotnosťou a inteligenciou</h2>

<p>Dôležité je rozlišovať medzi zdravotnou gramotnosťou a inteligenciou. Človek môže byť vysoko vzdelaný, analytický a schopný chápať zložité súvislosti, ale nemusí poznať medicínsku terminológiu.</p>

<p>Ak lekár povie pacientovi, že má „parestézie“, pacient nemusí vedieť, čo tento pojem znamená. Ak však povie, že ide o „mravčenie alebo brnenie súvisiace s nervami“, informácia je zrozumiteľná bez toho, aby bola detinská. To je presne rozdiel medzi jasným vysvetlením a zbytočným zjednodušovaním.</p>

<p>Zrozumiteľnosť neznamená infantilizáciu. Pacientovi možno vysvetliť aj náročnú diagnózu dospelým, rešpektujúcim jazykom.</p>

<h2>Keď sa pacient cíti podceňovaný</h2>

<p>Autor článku upozorňuje, že na internetových fórach a v komentároch možno nájsť veľa skúseností vzdelaných, artikulovaných ľudí, ktorí opisujú, že s nimi zdravotníci hovorili ako s malými deťmi. Ako príklad uvádza situáciu, v ktorej lekár vysvetľoval chemoterapiu ako liečbu „nezbedných buniek“.</p>

<p>Takéto vyjadrenie môže byť myslené dobre, ale u dospelého pacienta môže pôsobiť ponižujúco. Pacient nemusí odísť z ambulancie s pocitom bezpečia, ale s pocitom, že jeho schopnosť chápať bola podcenená.</p>

<p>A to je dôležitý bod. Komunikačný štýl lekára neovplyvňuje len porozumenie informáciám. Ovplyvňuje aj dôveru, ochotu pýtať sa, spoluprácu a celkový vzťah pacienta k zdravotníckemu systému.</p>

<h2>Problém „jednoduchosti za každú cenu“</h2>

<p>V posledných rokoch sa v medicíne silno zdôrazňuje potreba humanizovať zdravotnú starostlivosť. Často sa predpokladá, že cestou k tomu je jednoduchý jazyk. V zásade je to správne. Medicína nesmie byť neprístupná, odmeraná a uzavretá za odbornými pojmami.</p>

<p>Lenže aj dobrý princíp sa dá prehnať. Ak sa každý odborný výraz považuje za chybu a ak sa lekár bojí použiť bežné slová s mierne odborným významom, komunikácia sa môže stať neprirodzenou. Autor spomína, že počas štúdia medicíny dostával spätnú väzbu, podľa ktorej sa mal vyhýbať aj slovám ako „vyžarovať“ pri opise bolesti. Otázkou je, či takéto slovo naozaj väčšinu pacientov mätie.</p>

<p>Cieľom nemá byť sterilný jazyk zbavený každého odborného odtieňa. Cieľom má byť porozumenie.</p>

<h2>Elderspeak: špecifický problém pri starších pacientoch</h2>

<p>Osobitnou formou nevhodnej komunikácie je takzvaný <strong>elderspeak</strong>. Ide o spôsob hovorenia so staršími ľuďmi, ktorý pripomína detskú reč alebo neprimerané zjednodušovanie.</p>

<p>Môže sa prejaviť používaním zdrobnenín, oslovení ako „zlatíčko“ alebo „miláčik“, zvýšenou hlasitosťou bez dôvodu, príliš krátkymi vetami alebo používaním plurálu tam, kde nie je namieste. Typický príklad je otázka: „Už sme pripravení ísť na vyšetrenie?“</p>

<p>Takáto reč býva často myslená láskavo. Z pohľadu pacienta však môže pôsobiť falošne, povýšenecky alebo ponižujúco. Štúdie dokonca ukazujú, že elderspeak môže zvyšovať odpor voči starostlivosti a zhoršovať spoluprácu s liečbou.</p>

<h2>Rešpektujúca komunikácia musí byť prispôsobená človeku</h2>

<p>Najlepší lekári podľa autora nehovoria so všetkými pacientmi rovnako. Sledujú reakcie pacienta, jeho otázky, slovník, neistotu, mieru záujmu a podľa toho upravujú spôsob vysvetľovania.</p>

<p>Niekedy môže byť najlepšou otázkou hneď na začiatku: „Čo by ste dnes chceli vedieť?“ Alebo: „Chcete stručné vysvetlenie, alebo podrobnejšie prejsť možnosti liečby?“ Takýto prístup rešpektuje pacienta ako dospelého partnera.</p>

<p>Pacient nemusí poznať medicínu. To však neznamená, že je neschopný chápať súvislosti. Úlohou lekára je preložiť odbornú informáciu do jazyka, ktorému pacient rozumie, nie znížiť úroveň rozhovoru na karikatúru jednoduchosti.</p>

<h2>Praktický záver pre klinickú prax</h2>

<p>Vyhýbanie sa medicínskemu žargónu je správne. Zrozumiteľná komunikácia znižuje riziko nedorozumení a zvyšuje bezpečnosť liečby. Nemala by sa však zamieňať s infantilizáciou pacienta.</p>

<p>Lekárska komunikácia má byť jasná, presná a primeraná konkrétnemu človeku. Niekedy treba vysvetľovať veľmi jednoducho. Inokedy je vhodné použiť odborný pojem a hneď ho vysvetliť. Najdôležitejšie je sledovať pacienta, overovať porozumenie a zachovať rešpekt.</p>

<p>Jednoduchý jazyk je dobrý nástroj. Ak sa používa mechanicky a bez citlivosti, môže sa stať problémom. Pacient nemá z ambulancie odchádzať s pocitom, že ho lekár zahltil odbornými výrazmi. Ale nemá odchádzať ani s pocitom, že s ním hovorili ako s dieťaťom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Patronising Doctor Culture Is a Problem“. <a href="https://www.medscape.com/viewarticle/patronising-doctor-culture-problem-2026a1000gpm" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
