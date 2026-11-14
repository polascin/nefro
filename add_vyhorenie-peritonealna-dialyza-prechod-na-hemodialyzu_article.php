<?php
// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Vyhorenie pri peritoneálnej dialýze a prechod na hemodialýzu',
    'slug'         => 'vyhorenie-peritonealna-dialyza-prechod-na-hemodialyzu',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Taiwanská kohorta skúmala emočné vyčerpanie a úzkosť pri peritoneálnej dialýze. Čo zistila o prechode na hemodialýzu?',
    'content'      => <<<'HTML'
<figure><a href="img/vyhorenie-peritonealna-dialyza-prechod-na-hemodialyzu.webp" target="_blank" rel="noopener noreferrer"><img src="img/vyhorenie-peritonealna-dialyza-prechod-na-hemodialyzu.webp" alt="Každodenná záťaž pri domácej peritoneálnej dialýze" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Každodenná záťaž pri domácej peritoneálnej dialýze. Ilustračný obrázok.</figcaption></figure>
<p>Každodenná peritoneálna dialýza (PD) si vyžaduje čas, sústredenie a pravidelnú starostlivosť o peritoneálny katéter. V taiwanskej kohorte uviedla približne štvrtina respondentov emočné vyčerpanie. Vyššie skóre v dimenzii označenej v štúdii ako cynizmus súviselo s prechodom na hemodialýzu (HD). Výsledok upozorňuje na záťaž domácej liečby, no neobjasňuje príčiny jednotlivých prechodov. [1]</p>
<h2>Čo autori merali</h2>
<p>Do prospektívnej observačnej štúdie v National Taiwan University Hospital vstúpilo 183 pacientov na PD, ktorí vyplnili dotazníky Maslach Burnout Inventory a State-Trait Anxiety Inventory. Emočné vyčerpanie autori zaznamenali u 24,0 % pacientov a závažnú úzkosť podľa dotazníka u 19,7 %. Ide o dva samostatné dotazníkové výsledky. Podiel emočného vyčerpania sa nedá použiť ako prevalencia všetkých prejavov vyhorenia. Cynizmus v tomto kontexte označuje hodnotený rozmer odstupu od činnosti a jeho skóre treba interpretovať v kontexte záťaže liečby. [1]</p>
<h2>Prechod na hemodialýzu a mortalita</h2>
<p>V Coxovom modeli upravenom o vek a pohlavie bolo vysoké skóre cynizmu spojené s vyšším hazardom prechodu na HD (HR 3,47, 95 % interval spoľahlivosti 1,14 až 10,58, p = 0,029). Interval je široký a z pomeru hazardov nemožno odvodiť absolútnu pravdepodobnosť prechodu. Pri úmrtí z akejkoľvek príčiny bol upravený HR 3,80 (95 % interval spoľahlivosti 0,78 až 18,58, p = 0,099). Odhad mortality je nepresný a štatisticky významná asociácia sa nepreukázala. [1]</p>
<p>Úprava o vek a pohlavie ponecháva možnosť, že súvislosť ovplyvnili aj komorbidity, predchádzajúce komplikácie PD alebo dostupnosť pomoci doma. Jednocentrová kohorta neumožňuje určiť, či by intervencia znižujúca psychickú záťaž zmenila pravdepodobnosť prechodu na HD. Plný text sa nepodarilo získať. Abstrakt neuvádza počty udalostí, dĺžku sledovania ani spôsob zohľadnenia úmrtia ako konkurenčnej udalosti pri analýze prechodu na HD. [1]</p>
<h2>Ako o záťaži hovoriť pri kontrole PD</h2>
<p>Pri známkach vyčerpania má zmysel zistiť, ktorá časť liečby pacienta zaťažuje, ako zasahuje do spánku a bežného života a akú pomoc má doma. Odpovede môžu nasmerovať rozhovor o podpore alebo o zmene modality podľa zdravotného stavu a preferencií pacienta. Samotné skóre neposkytuje indikáciu na prechod na HD. Výsledok štúdie podporuje pozornosť venovanú záťaži liečby a ponecháva otvorenú otázku, ktoré formy podpory ovplyvnia zotrvanie na PD. [1]</p>
<hr>
<h2>Zdroj</h2>
<p><small><em>Yung-An Chen, Yi-Chih Lin, Yu-Hsiang Chou, Yi-Ting Chen, Shuei-Liong Lin. The clinical impact of burnout among peritoneal dialysis patients. Perit Dial Int. Online 4. novembra 2026. 8968608261502214. <a href="https://doi.org/10.1177/08968608261502214" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42982759/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vyhorenie-peritonealna-dialyza-prechod-na-hemodialyzu_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

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
