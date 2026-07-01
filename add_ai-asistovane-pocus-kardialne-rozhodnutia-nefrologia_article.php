<?php
/**
 * add_ai-asistovane-pocus-kardialne-rozhodnutia-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): AI-asistované POCUS ako
 * zrýchlenie kardiálnych rozhodnutí u NPs/PAs a možné dopady pre nefrológiu.
 * Slovenské spracovanie zdroja (Medscape Medical News).
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ai-asistovane-pocus-kardialne-rozhodnutia-nefrologia_article.php"
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
    'title'        => 'AI-asistované POCUS ako zrýchlenie kardiálnych rozhodnutí u NPs a PAs, a čo to môže znamenať aj pre nefrológiu',
    'slug'         => 'ai-asistovane-pocus-kardialne-rozhodnutia-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'AI-asistovaný point-of-care ultrazvuk (POCUS) ako triážny nástroj pre rýchlejšie kardiálne rozhodnutia mimo echolaboratórií — a čo z toho môže vyplynúť pre nefrológiu pri dýchavičnosti, edémoch a kardiorenálnom syndróme.',
    'content'      => <<<'HTML'
<p>Pacient s dýchavičnosťou, edémom dolných končatín a únavou často smeruje k otázke, či ide
o srdcové zlyhávanie, významnú chlopňovú patológiu, alebo problém mimo srdca. V praxi je však
častým úzkym hrdlom dostupnosť echokardiografie. Podľa Medscape článku môže byť echokardiogram
dostupný až o hodiny, niekedy aj neskôr (dni), čo komplikuje včasné triedenie a rozhodovanie.</p>

<p>Téma, ktorá sa rieši v najnovšom Medscape spracovaní, je využitie AI-asistovaného
point-of-care ultrazvuku (POCUS) na pracoviskách, kde potrebujete rýchlu orientačnú informáciu
o srdcovej funkcii a štrukturálnych/chlopňových nálezoch.</p>

<h2>Prečo práve POCUS a prečo k tomu pribudla AI vrstva</h2>
<p>Článok popisuje, že pre pokročilých praktikov (nurse practitioners, physician assistants) je
POCUS užitočný najmä v situáciách ako urgentná starostlivosť, hospital medicine, ambulancie
a dlhodobá starostlivosť. Kľúčový problém ale nie je len „nasnímať" obraz. Najväčšie oneskorenie
vzniká pri interpretácii, keď:</p>
<ul>
  <li>jemné chlopňové abnormality a hodnotenie srdcovej funkcie často vyžadujú špecializovaný dohľad,</li>
  <li>kvantitatívne merania a spoľahlivé závery potrebujú čas alebo experta,</li>
  <li>vznikajú praktické dopady na tok pacientov a načasovanie liečby.</li>
</ul>
<p>AI-asistované POCUS má byť podľa článku spôsob, ako skrátiť cestu od vyšetrenia k akčným
informáciám pri lôžku. Riešenie je prezentované ako „triážny" nástroj, nie náhrada formálnej
echokardiografie.</p>

<h2>Ako to má vyzerať v klinickej rutine</h2>
<p>Podľa textu „cloud-based" platforma analyzuje fokálne (špecificky zamerané) srdcové
ultrazvukové obrazy a poskytuje:</p>
<ul>
  <li>automatizované merania,</li>
  <li>diagnostické odporúčania súvisiace so štrukturálnym ochorením srdca, chlopňovými
      abnormalitami a srdcovým zlyhávaním,</li>
  <li>štruktúrované výstupy podporujúce klinický workflow.</li>
</ul>
<p>Z pohľadu rozhodovania ide o otázky, ktoré treba zodpovedať skôr:</p>
<ul>
  <li>Je potrebné urgentné kardiologické vyšetrenie?</li>
  <li>Sú prítomné známky srdcového zlyhávania?</li>
  <li>Je pravdepodobná významná chlopňová patológia?</li>
  <li>Môže pacient zostať v komunite, alebo je potrebná eskalácia starostlivosti?</li>
</ul>
<p>Článok výslovne zdôrazňuje, že cieľom nie je nahradiť detailné vyšetrenia, ktoré v plnom
rozsahu robia kardiológovia.</p>

<h2>Znižovanie bariéry učenia: od akvizície k spoľahlivej interpretácii</h2>
<p>Jedna obava pri ultrazvuku býva technická zručnosť potrebná na kvalitnú akvizíciu. V článku
je popísané, že pokroky v AI-asistovanom vedení môžu znižovať bariéru pri získavaní obrazov.</p>
<p>Konkrétne na Sheba Medical Center sa podľa textu časť fokálnych vyšetrení robí aj vyškolený
personál, pričom niekoľko dní zahŕňa teoretickú výučbu a následne supervíziu počas snímania.
V praxi sa má čas na vyšetrenie pohybovať v rádoch minút (článok uvádza, že to môže byť aj
približne 2 minúty).</p>
<p>Zároveň však text jasne pomenúva, že pre APPs aj tak zostáva najväčšou výzvou rýchla,
spoľahlivá interpretácia, ktorá podporí rozhodovanie.</p>

<h2>Kontext v kardiovaskulárnej krajine: nie je to jediný hráč</h2>
<p>Medscape článok uvádza, že AISAP je súčasťou rastúceho spektra AI nástrojov pre ultrazvuk
a kardiálne zobrazovanie, pričom rôzne firmy sa zameriavajú buď na:</p>
<ul>
  <li>hardvér a point-of-care akvizíciu,</li>
  <li>AI analýzu echokardiografických dát,</li>
  <li>AI-guided získavanie obrazov pre neexpertov,</li>
  <li>alternatívne prístupy (napríklad AI-enhanced digitálne stethoskopy a analýza srdcových zvukov).</li>
</ul>
<p>Spoločný cieľ je rozširovať prístup ku kardiovaskulárnemu posúdeniu mimo tradičných
echokardiografických laboratórií a špecializovaných pracovísk.</p>

<h2>Prečo by to mohlo zaujímať nefrológa (praktická rovina)</h2>
<p>U nefrologickej praxe, najmä pri dialyzovaných a pacientov s kardiorenálnym syndrómom, sa
dýchavičnosť, edémy a kolísanie objemového statusu často prelínajú s kardiálnou patológiou.
Ak má byť AI-asistované POCUS skutočne spoľahlivé ako triážny nástroj, môže to teoreticky:</p>
<ul>
  <li>pomôcť rýchlejšie odlíšiť „pravdepodobné kardiálne zlyhávanie" vs. iné príčiny dýchavice,</li>
  <li>urýchliť eskaláciu na echokardiografiu, keď je to potrebné,</li>
  <li>podporiť rýchlejšie rozhodnutia o následnom postupe (napr. hospitalizácia vs. ambulantný plán).</li>
</ul>
<p>Toto je však skôr praktická úvaha z logiky workflow, nie dôkaz špecificky pre nefrológiu.
Na nefrologickom pracovisku je rozumné zavádzať takéto nástroje s lokálnymi protokolmi, audítom
kvality a jasnými pravidlami, kedy musí nasledovať formálna echokardiografia.</p>

<h2>Dôležitá poznámka k záujmom</h2>
<p>V texte sa uvádza, že Robert Klempfner je co-founder a medical director AISAP, a teda má
finančný vzťah ku spoločnosti. Tamar Kupfer nemá disclosure.</p>

<hr>

<p><em><strong>Zdroj:</strong> Tamar Kupfer, „AI-Assisted POCUS Helps NPs, PAs Make Faster Cardiac Calls",
<em>Medscape Medical News</em> (2026).
<a href="https://www.medscape.com/viewarticle/how-ai-assisted-pocus-helping-nps-and-pas-make-faster-2026a1000m1m" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
                error_log('add_ai_pocus newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_ai_pocus pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_ai_pocus pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_ai_pocus migration error: ' . $e->getMessage());
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
