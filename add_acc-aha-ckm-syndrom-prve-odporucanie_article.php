<?php
/**
 * add_acc-aha-ckm-syndrom-prve-odporucanie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_acc-aha-ckm-syndrom-prve-odporucanie_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

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
    'title'        => 'ACC/AHA vydali prvé odporúčanie pre kardiovaskulárno-renálno-metabolický syndróm',
    'slug'         => 'acc-aha-ckm-syndrom-prve-odporucanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Americká kardiologická spoločnosť a Americká asociácia srdca vydali prvé spoločné odporúčanie pre kardiovaskulárno-renálno-metabolický (CKM) syndróm. Nový rámec prepája obezitu, metabolické poruchy, chronickú chorobu obličiek a kardiovaskulárne ochorenia do jedného kontinuálneho modelu rizika a starostlivosti so štyrmi štádiami.',
    'content'      => <<<'HTML'
<p>Americká kardiologická spoločnosť a Americká asociácia srdca vydali prvé spoločné odporúčanie zamerané na <strong>kardiovaskulárno-renálno-metabolický syndróm</strong>, označovaný ako <strong>CKM syndróm</strong>. Ide o nový koncepčný rámec, ktorý prepája obezitu, metabolické poruchy, chronickú chorobu obličiek a kardiovaskulárne ochorenia do jedného kontinuálneho modelu rizika a starostlivosti.</p>

<p>Odporúčanie vzniklo v spolupráci viacerých odborných spoločností vrátane American Diabetes Association, Obesity Association a American Society of Nephrology. Nahrádza staršie odporúčanie AHA/ACC z roku 2013 pre manažment nadváhy a obezity u dospelých.</p>

<h2>Obezita ako centrálny faktor multiorgánového poškodenia</h2>

<p>Nové odporúčanie posúva pohľad na obezitu. Už nejde iba o jeden z rizikových faktorov kardiovaskulárnych ochorení, ale o <strong>ústredný patofyziologický motor multiorgánovej progresie</strong>.</p>

<p>Autori zdôrazňujú, že nadbytočné a dysfunkčné tukové tkanivo vedie k rozvoju metabolických rizikových faktorov, chronickej choroby obličiek, subklinického kardiovaskulárneho poškodenia a napokon ku klinicky manifestnému kardiovaskulárnemu ochoreniu. Cieľom je preto zachytiť pacientov skôr, ešte pred vznikom ireverzibilných orgánových následkov.</p>

<h2>Štádiá CKM syndrómu</h2>

<p>Odporúčanie zavádza štvorstupňový model CKM syndrómu.</p>

<p><strong>Štádium 1</strong> zahŕňa pacientov s nadváhou, obezitou alebo prediabetom bez ďalších metabolických rizikových faktorov, ochorenia obličiek alebo kardiovaskulárneho ochorenia.</p>

<p><strong>Štádium 2</strong> zahŕňa prítomnosť aspoň jedného metabolického rizikového faktora, napríklad hypertenzie, hypertriglyceridémie, diabetu 2. typu alebo metabolického syndrómu, prípadne stredne až vysoko rizikovej chronickej choroby obličiek, ale bez zjavného kardiovaskulárneho ochorenia.</p>

<p><strong>Štádium 3</strong> predstavuje subklinické kardiovaskulárne ochorenie spolu s CKM rizikovými faktormi, 10-ročné kardiovaskulárne riziko podľa PREVENT-CVD najmenej 20 %, alebo veľmi vysoké riziko ochorenia obličiek podľa kritérií KDIGO.</p>

<p><strong>Štádium 4</strong> zahŕňa už diagnostikované kardiovaskulárne ochorenie, napríklad ischemickú chorobu srdca, srdcové zlyhávanie, cievnu mozgovú príhodu, periférne artériové ochorenie alebo fibriláciu predsiení, spolu s nadváhou, obezitou, metabolickými rizikovými faktormi alebo ochorením obličiek.</p>

<h2>Liečba: od životného štýlu po GLP-1 a SGLT2 inhibítory</h2>

<p>Manažment má byť odstupňovaný podľa štádia ochorenia. V skorších štádiách sa kladie dôraz na intenzívnu úpravu životného štýlu, redukciu hmotnosti, farmakoterapiu obezity a u vybraných pacientov aj na metabolickú a bariatrickú chirurgiu.</p>

<p>Významnou novinkou je, že odporúčanie po prvý raz zahŕňa <strong>GLP-1 receptorové agonisty</strong> pre vybraných pacientov s obezitou, diabetom 2. typu a ďalšími kardiovaskulárnymi rizikovými faktormi s cieľom znížiť riziko kardiálnych príhod.</p>

<p>U pacientov s diabetom 2. typu a CKM syndrómom v štádiu 2 alebo 3 sa ako prah pre začatie liečby GLP-1 terapiou, SGLT2 inhibítormi alebo ich kombináciou uvádza 10-ročné riziko PREVENT-CVD najmenej 7,5 %.</p>

<h2>Potreba koordinovanej starostlivosti</h2>

<p>Kľúčovou časťou odporúčania je odmietnutie izolovaného, odborovo rozdrobeného prístupu. Pacienti s CKM syndrómom často prechádzajú medzi diabetológom, nefrológom, kardiológom, obezitológom a všeobecným lekárom, čo môže viesť k nejednotnej a oneskorenej liečbe.</p>

<p>Odporúčanie preto zdôrazňuje potrebu interdisciplinárnych modelov starostlivosti a určenia koordinátora, ktorý bude sledovať riziko, implementáciu odporúčanej liečby a kontinuitu starostlivosti.</p>

<p>Autori sprievodného editoriálu však upozorňujú, že implementácia nebude jednoduchá. Mnohé zdravotné systémy nemajú dostatočnú infraštruktúru na integrovanú CKM starostlivosť, prístup k liekom proti obezite je nerovnomerný a úhradové mechanizmy často podporujú skôr epizodickú než dlhodobú preventívnu starostlivosť.</p>

<h2>Praktický význam</h2>

<p>Hlavný prínos nového odporúčania nespočíva iba v jednotlivých terapeutických odporúčaniach, ale v zmene myslenia. Kardiovaskulárne, metabolické a renálne riziko sa nemá posudzovať oddelene. CKM syndróm predstavuje jeden prepojený klinický proces, ktorý sa začína často už nadváhou, obezitou alebo prediabetom a môže končiť závažným kardiovaskulárnym ochorením a predčasnou mortalitou.</p>

<p>Pre klinickú prax to znamená potrebu skoršej identifikácie rizikových pacientov, dôslednejšej liečby obezity, aktívneho manažmentu diabetu a chronickej choroby obličiek a lepšej koordinácie medzi odbornosťami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>ACC/AHA Release First-Ever Guideline on CKM Syndrome</em> (2026). <a href="https://www.medscape.com/viewarticle/acc-aha-release-first-ever-guideline-ckm-syndrome-2026a1000jbs" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
