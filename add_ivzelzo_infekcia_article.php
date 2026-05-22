<?php
/**
 * add_ivzelzo_infekcia_article.php
 * Pridanie článku o IV železe počas akútnej infekcie (TriNetX / Blood 2026)
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Dáta článkov ──────────────────────────────────────────────────────────────

$articles = [];

// ── Článok: IV železo počas akútnej infekcie ──────────────────────────────────
$articles[] = [
    'title'        => 'IV železo počas akútnej infekcie: reálne dáta proti strachu z „zhoršenia infekcie"',
    'slug'         => 'iv-zelzo-pocas-akutnej-infekcie-realne-data',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-22',
    'is_top'       => 0,
    'excerpt'      => 'Dlhé roky sa opakovalo pravidlo: ak má pacient akútnu infekciu, IV železo radšej nedávať. Nová retrospektívna real-world štúdia (TriNetX) publikovaná v Blood prináša signál, že IV železo podané počas akútnej infekcie nespôsobuje zhoršenie infekcie a môže byť spojené s lepšími výsledkami.',
    'content'      => <<<'HTML'
<p>Dlhé roky sa opakovalo pravidlo: ak má pacient akútnu infekciu, IV železo radšej nedávať. Dôvod bol intuitívny a „logický", no klinicky problematický: železo je potrebné aj pre patogény, a preto sa dalo očakávať zhoršenie infekcie. V praxi však často narážame na opačný problém: u hospitalizovaných pacientov s deficitom železa a anémiou býva anémia zhoršujúca toleranciu infekcie, regeneráciu, funkčný stav aj potrebu transfúzií.</p>

<p>Nová retrospektívna „real-world" štúdia (TriNetX) publikovaná v <em>Blood</em> prináša signál, že IV železo podané počas akútnej infekcie nespôsobuje zhoršenie infekcie a môže byť spojené s lepšími výsledkami.</p>

<h2>Prečo bola táto otázka dôležitá aj pre nefrológiu</h2>

<p>V nefrologickej starostlivosti (CKD, hemodialýza, akútne hospitalizácie) sa deficit železa často prekryje s infekciou. Vtedy vzniká dilema:</p>

<ul>
  <li>anémia zhoršuje priebeh a hospitalizačné výsledky,</li>
  <li>ale obavy z rizika infekčného „flare" po podaní železa sú stále silné,</li>
  <li>navyše nie každému sa dá bezpečne a rýchlo pomôcť perorálnym železom.</li>
</ul>

<p>Štúdia sa teda netvárila ako teória, ale chcela zodpovedať praktickú otázku: čo sa deje s pacientmi, keď IV železo reálne podávame počas akútnej infekcie?</p>

<h2>Čo štúdia robila (dizajn a cieľ)</h2>

<p>Ide o retrospektívnu kohortovú štúdiu v reálnej praxi využívajúcu sieť TriNetX (obdobie rokov 2000 až jún 2025). Cieľom bolo zhodnotiť bezpečnosť a účinnosť IV železa u hospitalizovaných dospelých s anémiou z nedostatku železa (IDA) počas akútnej infekcie, s dôrazom na:</p>

<ul>
  <li>infekčné a „hard" klinické outcome,</li>
  <li>hospitalizačné využitie (napr. dĺžka hospitalizácie),</li>
  <li>potrebu transfúzií,</li>
  <li>hematologické výsledky (napr. obnova hemoglobínu).</li>
</ul>

<h2>Hlavné výsledky: IV železo bez signálu zhoršenia infekcie</h2>

<p>Zhrnutie z dostupných materiálov k štúdii je konzistentné v jednom bode: IV železo podané pri akútnej infekcii <strong>sa nespojilo so zhoršením infekcie</strong>.</p>

<p>Štúdia navyše uvádza, že IV železo bolo asociované s lepšími výsledkami, konkrétne najmä:</p>

<ul>
  <li><strong>lepšou obnovou hemoglobínu</strong> po liečbe,</li>
  <li><strong>bez nárastu dĺžky hospitalizácie</strong>,</li>
  <li><strong>menším výskytom dní, keď pacient dostával transfúzie</strong> (teda menej transfúznej záťaže),</li>
  <li>a v širšom hodnotení tiež so <strong>zlepšením klinických outcome</strong> vrátane prežívania.</li>
</ul>

<p><em>Poznámka k presnosti: v dostupných materiáloch nie sú uvedené konkrétne percentá a absolútne rozdiely. Pri publikovaní detailov je vhodné pozrieť primárny článok alebo tabuľky v práci, ak chcete uvádzať čísla do praxe.</em></p>

<h2>Čo si z toho zobrať pre prax nefrológa</h2>

<p>Ak ste doteraz zvažovali „nechať pacienta prežiť infekciu a až potom riešiť deficit železa", táto štúdia podporuje realistickejší prístup: u hospitalizovaných pacientov s IDA a akútnou infekciou môže byť IV železo rozumné, pretože:</p>

<ol>
  <li><strong>nevidíme jasný signál, že by infekciu zhoršovalo</strong>,</li>
  <li><strong>hemoglobín ide nahor</strong>,</li>
  <li><strong>transfúzie môžu byť menej potrebné</strong>.</li>
</ol>

<p>V praxi to pre vás znamená prehodnotiť miestne zvyky a indikačné bariéry. Dôležité však je držať sa klinickej logiky: nepozeráme len na „vhodnosť počas infekcie", ale aj na to, či má pacient reálny deficit železa, či nejde o situáciu s iným dominantným zdrojom anémie (napr. výrazná supresia kostnej drene alebo iná etiológia).</p>

<h2>Limity: je to retrospektíva, nie randomizácia</h2>

<p>Pri každej retrospektívnej analýze je potrebné mať na pamäti, že ide o asociácie, nie o kauzalitu. Aj keď použitie veľkej databázy a metód porovnania znižuje skreslenie, stále existuje možnosť, že pacienti, ktorým IV železo dali, boli v niektorých ohľadoch „iní" (napr. dostupnosť liečby, závažnosť anémie, lokálne postupy, časovanie intervencie).</p>

<p>Napriek tomu ide o typ dôkazov, ktorý v klinike často rozhoduje: real-world data, ktoré priamo adresujú problém, na ktorý sa v praxi naráža každý týždeň.</p>

<h2>Take-home správa na 30 sekúnd</h2>

<p>U hospitalizovaných dospelých s anémiou z nedostatku železa pri akútnej infekcii sa IV železo v reálnej praxi <strong>nespojilo so zhoršením infekcie</strong> a bolo asociované s <strong>lepšou hematologickou odpoveďou</strong> a <strong>menšou transfúznou záťažou</strong>, bez zjavného zhoršenia hospitalizačného využitia. Stále platí, že ide o retrospektívne dáta a detaily treba overiť v primárnej publikácii, ale praktický odkaz je jasný: obavy z „urýchlenia infekcie" nemusia byť dôvodom na systematické odkladanie IV železa.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Education (CME/CE) aktivita k publikácii v <em>Blood</em>: „A Retrospective, Real-World Study of IV Iron Use to Treat Iron Deficiency Anemia During Acute Infection". <a href="https://www.medscape.org/viewarticle/retrospective-real-world-study-iv-iron-use-treat-iron-2026a1000ft1?page=1&src=wnl_tpal_260522_mscpedu&uac=36841CV&impID=8365073" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted = 0;
$skipped  = 0;
$errors   = [];

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
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_ivzelzo_infekcia_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku IV železo počas akútnej infekcie\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    // ── HTML výstup pre webový prístup ──────────────────────────────────
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia – IV železo počas akútnej infekcie</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – IV železo počas akútnej infekcie</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
          </div>

          <p>Vstavané články:</p>
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
