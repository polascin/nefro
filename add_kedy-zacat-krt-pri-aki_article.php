<?php
/**
 * add_kedy-zacat-krt-pri-aki_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kedy-zacat-krt-pri-aki_article.php"
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
    'title'        => 'Kedy začať náhradnú liečbu obličiek (KRT) pri akútnom poškodení obličiek (AKI)',
    'slug'         => 'kedy-zacat-krt-pri-aki',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kedy nasadiť náhradnú liečbu obličiek pri závažnom AKI: urgentné vs. relatívne indikácie, furosemidový stress test, biomarkery a hlavne to, čo ukázali randomizované skúšania ELAIN, AKIKI, IDEAL-ICU, STARRT-AKI a AKIKI-2 — bez urgentnej komplikácie okamžité spustenie KRT spravidla neprináša benefit, no priveľký odklad nie je bezpečný.',
    'content'      => <<<'HTML'
<h2>Úvod: čo KRT vie a čo nie</h2>

<p>Náhradná liečba obličiek (KRT) je súčasťou modernej intenzívnej starostlivosti pri závažnom AKI. Ide o kontinuálne, prerušované alebo hybridné techniky a v niektorých situáciách aj o akútnu peritoneálnu dialýzu. Dôležité je uvedomiť si, že KRT v prvom rade odstraňuje prebytočnú tekutinu, koriguje vybrané elektrolytové a metabolické poruchy a pomáha udržiavať acidobázickú rovnováhu. Neobnovuje však vnútorné funkcie obličiek (napríklad reabsorpciu aminokyselín, produkciu erytropoetínu či aktiváciu vitamínu D).</p>

<h2>Indikácie: urgentné vs. „relatívne“</h2>

<p>Rozhodovanie o začiatku KRT je prakticky najlepšie rámcovať podľa toho, či ide o <strong>urgentnú (naliehavú)</strong> potrebu, alebo o <strong>relatívnu</strong> situáciu, v ktorej sa KRT zvažuje skôr na základe rizika zhoršenia.</p>

<h3>Urgentné indikácie (KRT zväčša treba začať, keď je stav refraktérny na liečbu)</h3>

<p>Za urgentné sa považujú stavy, pri ktorých hrozí rýchle poškodenie mimoobličkových orgánov a KRT je typicky súčasťou „záchranného“ kroku, napríklad:</p>

<ul>
  <li><strong>ťažká metabolická acidóza refraktérna na liečbu</strong>,</li>
  <li><strong>pľúcny edém</strong>,</li>
  <li><strong>uremické komplikácie</strong> (napr. perikarditída, encefalopatia, krvácanie),</li>
  <li><strong>ťažká hyperkaliémia refraktérna na liečbu</strong>,</li>
  <li><strong>neutíšiteľné preťaženie tekutinou spojené s dysfunkciou orgánov</strong>,</li>
  <li><strong>intoxikácia dialyzovateľným toxínom alebo liečivom</strong>.</li>
</ul>

<h3>Relatívne indikácie (viac neistoty, menej presných prahov)</h3>

<p>Relatívne indikácie sa často spájajú s:</p>

<ul>
  <li><strong>progresiou alebo perzistenciou AKI</strong> (napr. výrazný vzostup kreatinínu a/alebo výrazná oligúria),</li>
  <li><strong>zhoršovaním mimoobličkových orgánov spôsobeným AKI</strong>,</li>
  <li><strong>nepriaznivým trendom kritického stavu</strong>.</li>
</ul>

<p>Problém je, že kreatinín ani diuréza samy osebe spoľahlivo neodlišujú pacientov, ktorí budú potrebovať KRT urgentne, od tých, ktorí sa bez KRT zlepšia. Prispieva k tomu aj fakt, že mechanizmy toxického poškodenia pri AKI nie sú úplne identifikované, a preto neexistuje jediný „dokonalý“ biomarker alebo test, ktorý by presne predpovedal, koho treba eskalovať na KRT v konkrétnom čase.</p>

<h2>Ako predvídať, že pacient bude KRT potrebovať</h2>

<p>Okrem hodnotenia „indikácie na začatie“ sa skúma aj koncept, že KRT sa začína v momente, keď obličky už <strong>nezvládajú metabolické a tekutinové požiadavky</strong> kriticky chorého pacienta. Prakticky sa tým snažíme lepšie odhadnúť „dopyt“ a „kapacitu“ počas dynamického vývoja choroby.</p>

<h3>Furosemidový „stress test“ na odhad rizika progresie</h3>

<p>Jedným z praktických bedside prístupov je <strong>furosemidový stress test</strong>, ktorý skúša zachovanú funkciu tubulov. Základ je v tom, že furosemid sa dostáva do tubulárneho lumena aktívnou sekréciou transportérmi a následne tlmí absorpciu chloridu v hrubej vzostupnej časti Henleho kľučky. V štúdii sa používa jednorazová i.v. dávka (líši sa podľa predchádzajúcej expozície kľučkovým diuretikám) a sleduje sa odpoveď diurézy. Výsledkom pozitívneho testu je typicky diuréza vyššia ako určitý prah v krátkom časovom okne, čo naznačuje zachovanú tubulárnu odpoveď. V pilotných dátach sa ukázalo, že test dokáže vybrať pacientov s vyšším rizikom KRT, hoci nejde o stopercentnú predikciu.</p>

<h3>Biomarkery: zaujímavé, ale zatiaľ nie ako rozhodovací „rozhodca“</h3>

<p>Viaceré biomarkery sú asociované s tým, či pacient nakoniec dostane KRT, no kvalita dôkazov nepodporuje ich rutinné použitie ako jediný základ na začatie alebo zadržanie KRT. Jedným z uvedených príkladov sú kombinácie a skóre založené na tubulárnom poškodení a perzistencii AKI, no celkovo sú limitujúce rozdielne cut-off hodnoty, variabilné meranie a konfúzia zo strany komorbidít.</p>

<h2>Kľúčová otázka: kedy KRT začať</h2>

<p>Jadro sporu je, či má zmysel <strong>predčasné (preemptívne) začatie</strong> KRT u pacientov so závažným AKI bez urgentných komplikácií, alebo či je bezpečnejšie a prospešnejšie <strong>systematicky odkladať</strong>, pričom KRT sa nasadí až pri rozvoji refraktérnych komplikácií alebo výraznej progresii.</p>

<p>Predčasné začatie môže intuitívne znieť logicky (ovplyvnenie tekutín, acidobázickej rovnováhy a hypotetická eliminácia toxínov), ale klinické randomizované skúšania ukázali, že bez naliehavých dôvodov to typicky neprináša jasný klinicky významný benefit.</p>

<h2>Výsledky randomizovaných skúšaní: čo ukázali ELAIN, AKIKI, IDEAL-ICU a STARRT-AKI</h2>

<p>Pre lepšiu orientáciu je dobré sledovať rozdiely medzi „early“ a „delayed/standard“ stratégiou, ale spoločný záver je v princípe konzistentný: <strong>ak nie je urgentný dôvod, okamžité spustenie KRT spravidla nezlepší dôležité výsledky</strong>.</p>

<h3>ELAIN (2016): skorší benefit v jednej štúdii</h3>

<p>ELAIN bolo jednocentrické skúšanie, v ktorom skoré KRT (do 8 hodín) viedlo k nižšej 90-dňovej mortalite oproti oneskoreniu do progresie (napr. štádium 3). Upozorňuje sa však aj na obmedzenie typu fragility index.</p>

<h3>AKIKI (2016): bez rozdielu v mortalite</h3>

<p>V AKIKI boli pacienti v „early“ ramene liečení skôr podľa kritérií štádia 3, zatiaľ čo v „delayed“ ramene sa KRT začalo až pri perzistencii oligúrie, vzostupe urey alebo inej akútnej urgentnej komplikácii. Primárny výsledok (60-dňová mortalita) sa medzi ramenami nelíšil.</p>

<h3>IDEAL-ICU: v septickom šoku bez jasného rozdielu</h3>

<p>IDEAL-ICU porovnávalo stratégie pri štádiu 3 AKI komplikovanom septickým šokom. Aj tu sa 90-dňová mortalita medzi skupinami nelíšila.</p>

<h3>STARRT-AKI: akcelerované vs. štandardné, tiež bez benefitov v prežívaní</h3>

<p>STARRT-AKI bolo veľké multicentrické skúšanie v 15 krajinách. Akcelerované rameno znamenalo začatie KRT do 12 hodín od splnenia eligibility, zatiaľ čo v štandardnom ramene boli odporúčania skôr odkladať, ak sa komplikácie dali zvládnuť bez KRT. V celkových výsledkoch nebol rozdiel v mortalite, pričom v akcelerovanom ramene bolo viac pacientov, ktorí dostali KRT, a častejšie sa objavili niektoré nežiaduce udalosti (napr. hypotenzia súvisiaca s KRT a hypofosfatémia).</p>

<h2>AKIKI-2 a otázka „ako dlho môžem ešte čakať“</h2>

<p>Zostáva otázka, či existuje bezpečný limit odkladu pri perzistujúcom AKI v štádiu 3. V AKIKI-2 sa skúšalo ďalšie odkladanie u pacientov s perzistenciou AKI po 3 dňoch bez medzizáchvatových urgentných indikácií. Primárny výsledok typu KRT-free days sa medzi ramenami významne nelíšil, no v prešpecifikovaných analýzach sa objavil signál vyššej 60-dňovej mortality pri „veľmi oneskorenej“ stratégii, preto sa s príliš dlhým odkladom nedá narábať bez rizika.</p>

<h2>Implementácia do praxe: štandardizácia a klinická realita</h2>

<p>V reálnej praxi pomáha štandardizovať spúšťače iniciácie KRT (napr. pH pod určitú hodnotu, hyperkaliémia nad určitý prah, intoxikácia dialyzovateľným toxínom, ťažký edém, výrazne znížená diuréza a/alebo uremické príznaky). Štandardizované stratégie v observačno-intervenčných schémach môžu znížiť variabilitu a zároveň zmysluplne skrátiť pobyt v ICU, pričom v prostrediach s ťažko reverzibilným prognostickým rámcom môže byť KRT použitá menej často v porovnaní so stratégiami bez takéhoto rámca.</p>

<h2>Kam smeruje ďalší výskum</h2>

<p>Ďalšou cestou je identifikovať podtypy AKI, ktoré budú mať vyššie riziko perzistencie, progresie do CKD alebo budú vyžadovať KRT. Pomáha tomu kombinovanie klinického úsudku s testami ako furosemidový stress test, markermi perzistencie tubulárneho poškodenia, technológiami merania GFR a potenciálne aj digitálnymi nástrojmi a umelou inteligenciou. Cieľom je lepšie odlíšiť pacientov, u ktorých KRT skutočne nevyhnutná je, od tých, u ktorých môže byť bez zhoršenia odložená alebo sa jej úplne vyhneme.</p>

<h2>Dôležitý etický a praktický rozmer: futilita a časovo obmedzený „trial“</h2>

<p>Článok tiež zdôrazňuje, že rozhodnutie o KRT sa nemá robiť izolovane. Má sa zvažovať v kontexte ďalšej podpory orgánov a aj s ohľadom na preferencie pacienta a celkové ciele starostlivosti. V situáciách neistoty alebo nízkej pravdepodobnosti významného zlepšenia môže byť možnosťou časovo obmedzený pokus o KRT s dohodnutými cieľmi, termínom revízie a jasnými kritériami pre pokračovanie alebo ukončenie.</p>

<h2>Praktický záver</h2>

<p>Najlepšia syntéza dôkazov z randomizovaných skúšaní je tá, že <strong>okamžité spustenie KRT bez urgentnej AKI-komplikácie typicky neprináša zmysluplné zlepšenie klinických výsledkov</strong>. Zároveň však treba jasne vedieť, kedy odklad už nie je bezpečný, pretože perzistujúce AKI môže viesť k urémii, acidóze a preťaženiu tekutinou.</p>

<hr>

<p><em><strong>Zdroj:</strong> Ostermann M, Bagshaw SM et al. (prehľadový článok) — indikácie a načasovanie KRT pri AKI, PMC. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10101614/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
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
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
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
