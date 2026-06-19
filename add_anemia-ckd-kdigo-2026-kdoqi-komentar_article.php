<?php
/**
 * add_anemia-ckd-kdigo-2026-kdoqi-komentar_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_anemia-ckd-kdigo-2026-kdoqi-komentar_article.php"
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
    'title'        => 'Anémia pri CKD podľa KDIGO 2026: čo prináša KDOQI US Commentary do praxe',
    'slug'         => 'anemia-ckd-kdigo-2026-kdoqi-komentar',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'KDOQI komentár ku KDIGO 2026 ponúka praktickú „logiku v krokoch“ pri manažmente anémie v CKD: dôkladnú diagnostiku (CBC, retikulocyty, ferritín, TSAT), aktívne hľadanie reverzibilných príčin a manažment deficitu železa s dôrazom na bezpečnostné hranice a riziko hypofosfatémie pri FCM. Pri ESA a HIF-PHI sa posilňuje zdieľané rozhodovanie a dôraz na riziká, nie len na číslo Hb.',
    'content'      => <<<'HTML'
<p>Anémia je u pacientov s chronickým ochorením obličiek (CKD) veľmi častá a spojená so zvýšeným rizikom morbidity a mortality. KDOQI zvolalo pracovnú skupinu, ktorá revidovala KDIGO 2026 klinickú smernicu pre manažment anémie v CKD a pripravila komentár k odporúčaniam a praktickým bodom, vrátane poznámok k implementácii v klinickej praxi.</p>

<p>V tomto článku zhrniem praktické jadro odporúčaní z pohľadu nefrológie: ako nastaviť diagnostiku, kedy a ako liečiť deficit železa, a ako pristupovať k ESA (erytropoézu stimulujúcim látkam) a HIF-PHI (inhibítory HIF-prolyl hydroxylázy).</p>

<h2>1) Diagnostika: anémia nie je len hemoglobín</h2>

<p>KDIGO/KDOQI zdôrazňujú, že u ľudí s CKD treba:</p>

<ul>
  <li><strong>testovať anémiu pri odoslaní</strong>, pravidelne počas sledovania a pri podozrení na anémiu podľa symptómov,</li>
  <li>a robiť základný panel <strong>CBC (krvný obraz)</strong>, <strong>retikulocyty (retikulocytový produkčný index)</strong>, <strong>ferritín</strong> a <strong>TSAT (transferrin saturation)</strong>.</li>
</ul>

<p>Ak úvodné testy neodhalia príčinu, KDOQI odporúča zvážiť rozšírený panel podľa klinickej situácie, napríklad:</p>

<ul>
  <li>náter periférnej krvi, hemolýzu (haptoglobín, LDH), zápal (CRP),</li>
  <li>nutričné príčiny (B12, folát),</li>
  <li>pečeňové testy,</li>
  <li>vybrané hematologické príčiny (serum protein electrophoresis s imunofixáciou, free light chains, močové Bence-Jones proteíny),</li>
  <li>endokrinné a iné príčiny (TSH, PTH),</li>
  <li>a v prípade podozrenia aj <strong>vyšetrenie okultného krvácania</strong>.</li>
</ul>

<p>Prakticky dôležité je, že KDOQI explicitne rieši aj situáciu, keď je <strong>ferritín &lt; 45 ng/ml</strong> alebo <strong>mikrocytóza (MCV &lt; 80 fl)</strong> a príčina deficitu železa je nejasná. Vtedy treba cielene pátrať po zdroji krvácania a podľa kontextu riešiť vyšetrenie cez gastroenterológa, gynekológa alebo urológa.</p>

<p><strong>Klinická pointa:</strong> okrem nízkeho ferritínu sa v komentári zdôrazňuje užitočnosť aj <strong>nízkeho TSAT (&lt; 20 %)</strong> ako spúšťača vyšetrenia krvácania, pričom TSAT sa nemá interpretovať izolovane.</p>

<h2>2) Železo: najprv deficit, až potom cielene „vyššie Hb“</h2>

<h3>Kľúčová logika</h3>

<p>Odporúčania stavajú na tom, že <strong>liečba anémie v CKD má začínať riešením korigovateľných príčin, najmä deficitu železa</strong>. Železo sa pritom netýka len hemoglobínu, ale aj širších biologických funkcií.</p>

<h3>2.1 Kedy začať železo u HD pacientov (CKD G5HD)</h3>

<p>Pre hemodialýzu platí návrh začať liečbu železom pri:</p>

<ul>
  <li><strong>ferritín ≤ 500 ng/ml</strong> a zároveň <strong>TSAT ≤ 30 %</strong>.</li>
</ul>

<p>A pri začatí liečby železom v tejto skupine KDOQI/KDIGO preferuje:</p>

<ul>
  <li><strong>intravenózne železo</strong> pred perorálnym.</li>
</ul>

<p>Dôvod je praktický aj z výsledkov štúdií: IV aplikácia je efektívnejšia a jednoduchšia na manažment v dialyzačnej realite. Komentár navyše upozorňuje na špecifiká <strong>ferric citrate</strong> (môže byť indikovaný ako fosfátový viazač pri dialýze, ale zároveň sa vstrebáva v miere, ktorá ovplyvní železné parametre). Ak sa používa len ako viazač fosfátu, treba počítať s tým, že <strong>železné indexy môžu stúpať</strong>, a manažment IV železa tomu prispôsobiť.</p>

<h3>2.2 „Proaktívne“ IV železo a hranice bezpečnosti</h3>

<p>KDOQI súhlasí s proaktívnym prístupom k IV železu, pričom upozorňuje na kontext dôkazov, najmä PIVOTAL trial. Komentár zdôrazňuje, že bezpečnostný horný limit v proaktívnej vysoko dávkovej vetve PIVOTAL bol:</p>

<ul>
  <li><strong>ferritín &gt; 700 ng/ml</strong> alebo <strong>TSAT ≥ 40 %</strong>.</li>
</ul>

<p>Prakticky to podporuje použitie odporúčania, že je rozumné <strong>železo dočasne zadržať</strong>, ak je:</p>

<ul>
  <li><strong>ferritín &gt; 700 ng/ml</strong>, alebo</li>
  <li><strong>TSAT ≥ 40 %</strong>.</li>
</ul>

<p>Komentár však zároveň upozorňuje na problém generalizácie formulácie „pre všetkých s CKD“. Podľa dostupných údajov je racionálne opierať sa o tieto hranice hlavne pri HD (CKD G5HD), zatiaľ čo pre peritoneálnu dialýzu a non-dialysis CKD sú bezpečnostné dáta pri vyšších hodnotách limitované.</p>

<h3>2.3 Non-HD CKD a perorálne vs IV železo</h3>

<p>U pacientov s CKD, ktorí nie sú na hemodialýze (vrátane peritoneálnej dialýzy), KDIGO/KDOQI navrhuje začať železo podľa kombinácie ferritínu a TSAT, s konkrétnymi prahmi pre ferritín:</p>

<ul>
  <li><strong>ferritín &lt; 100 ng/ml</strong> a <strong>TSAT &lt; 40 %</strong>, alebo</li>
  <li><strong>ferritín ≥ 100 ng/ml a &lt; 300 ng/ml</strong> a <strong>TSAT &lt; 25 %</strong>.</li>
</ul>

<p>Pri iniciácii železa mimo HD sa rozhodovanie ponecháva na voľbu podľa:</p>

<ul>
  <li>preferencií pacienta,</li>
  <li>stupňa anémie a deficitu,</li>
  <li>relatívnej účinnosti, tolerancie, dostupnosti a ceny.</li>
</ul>

<h3>2.4 Ako často kontrolovať železo</h3>

<p>KDOQI/KDIGO uvádza:</p>

<ul>
  <li>pri CKD bez dialýzy a CKD G5PD: <strong>Hb, ferritín a TSAT každé 3 mesiace</strong>,</li>
  <li>pri CKD G5HD: <strong>každých 1 až 3 mesiace</strong>,</li>
  <li>a v niektorých situáciách aj častejšie (odkaz na tabuľku v KDIGO).</li>
</ul>

<p>Ak optimálny perorálny režim po <strong>1 až 3 mesiacoch</strong> nestačí alebo je zle tolerovaný, odporúčanie je prejsť na <strong>intravenózne železo</strong>. Pri systémovej infekcii sa tiež pripúšťa dočasné pozastavenie železa.</p>

<h2>3) Pozor na hypofosfatémiu: ferric carboxymaltose (FCM) a riadenie rizika</h2>

<p>Prakticky kritický bod komentára sa týka toho, že pri niektorých novších IV prípravkoch (najmä <strong>ferric carboxymaltose, FCM</strong>, ale aj ďalšie uvedené v texte) môže vzniknúť hypofosfatémia, sprostredkovaná mechanizmom cez <strong>FGF23</strong>.</p>

<p>Komentár uvádza, že FCM je spojené s najvyšším výskytom a najdlhším trvaním hypofosfatémie v porovnaní s inými formuláciami. Rovnako sa zdôrazňuje, že u pacientov s už prítomným sekundárnym hyperparatyreoidizmom alebo u tých, ktorí majú rizikové faktory (napríklad lieky spojené s hypofosfatémiou), môže byť riziko vyššie.</p>

<p><strong>Praktický postup v texte:</strong></p>

<ul>
  <li>u pacientov so zhoršujúcou sa únavou, bolesťami kostí alebo slabosťou počas alebo po FCM treba myslieť na hypofosfatémiu a <strong>promptne zmerať fosfát</strong>,</li>
  <li>pri opakovaných dávkach FCM merať fosfát aj pred ďalšími dávkami,</li>
  <li>pri zistení hypofosfatémie doplniť fosfát podľa potreby a zvážiť zmenu na inú IV formuláciu.</li>
</ul>

<h2>4) ESA a HIF-PHI: najprv príčiny, potom rozhodovanie spolu s pacientom</h2>

<h3>4.1 Kedy sa vôbec rozhodovať o ESA/HIF-PHI</h3>

<p>Kľúčový princíp je, že rozhodnutie o ESA alebo HIF-PHI sa má robiť <strong>v rámci zdieľaného rozhodovania</strong> s ohľadom na:</p>

<ul>
  <li>symptómy,</li>
  <li>potenciálne riziko transfúzií RBC,</li>
  <li>a riziko nežiaducich účinkov (komentár uvádza napríklad cievnu mozgovú príhodu, kardiovaskulárne udalosti a rakovinu).</li>
</ul>

<p>A pred nasadením ESA alebo HIF-PHI sa majú riešiť všetky korigovateľné príčiny, vrátane deficitu železa.</p>

<h3>4.2 ESA ako prvá voľba vs HIF-PHI</h3>

<p>Komentár podporuje odporúčanie KDIGO, že po riešení korigovateľných príčin je vhodné používať <strong>ESA ako prvú líniu</strong> namiesto HIF-PHI. HIF-PHI sa majú vyhýbať u pacientov so zvýšeným rizikom nežiaducich udalostí (v texte odkaz na tabuľku v KDIGO).</p>

<h3>4.3 Kedy začať ESA a kam cieliť Hb</h3>

<p>Pre CKD G5D (HD alebo peritoneálna dialýza) sa navrhuje začať ESA pri:</p>

<ul>
  <li><strong>Hb ≤ 9,0 až 10,0 g/dl</strong> (≤ 90 až 100 g/l).</li>
</ul>

<p>Pri CKD bez dialýzy sa iniciácia robí podľa symptómov, očakávaných benefitov vyššieho Hb a rizík spojených s transfúziami alebo ESA.</p>

<p>Pri udržiavaní liečby ESA je cieľom:</p>

<ul>
  <li><strong>Hb pod 11,5 g/dl (115 g/l)</strong> (v texte sa spomína aj US limit 11,0 g/dl).</li>
</ul>

<h2>5) Praktická titulná stratégia pre ambulanciu alebo dialýzu</h2>

<p>Ak by som to mal zredukovať na pracovný rámec podľa komentára KDIGO/KDOQI:</p>

<ol>
  <li><strong>Potvrď anémiu</strong> a vyhodnoť panel s CBC, retikulocytmi, ferritínom a TSAT.</li>
  <li><strong>Hľadaj príčinu.</strong> V CKD je deficit železa častý, ale ak výsledky nesedia, rozšír diagnostiku vrátane posúdenia krvácania.</li>
  <li><strong>Lieč deficit železa podľa dialýzy a prahov</strong>, preferuj IV železo pri HD a individualizuj spôsob mimo HD.</li>
  <li><strong>Monitoruj a drž sa bezpečnostných limitov</strong> najmä pri HD (ferritín &gt; 700 alebo TSAT ≥ 40).</li>
  <li>Pri FCM zohľadni <strong>hypofosfatémiu</strong> a aktívne sleduj fosfát pri príznakoch aj pri opakovaných dávkach.</li>
  <li>Až potom zvaž <strong>ESA/HIF-PHI</strong> v kontexte rizík, benefitu a preferencií pacienta. ESA udržuj tak, aby cieľ Hb neprekračoval odporúčané horné hranice.</li>
</ol>

<h2>Záver</h2>

<p>KDOQI Commentary ku KDIGO 2026 prináša jasnejšiu „logiku v krokoch“: dôkladná diagnostika s CBC/retikulocyty/ferritín/TSAT, aktívne hľadanie reverzibilných príčin a najmä manažment deficitu železa s dôrazom na bezpečnostné hranice a špecifiká jednotlivých IV prípravkov (najmä riziko hypofosfatémie pri FCM). Pri ESA/HIF-PHI sa posilňuje zdieľané rozhodovanie a dôraz na riziká, nie len na číslo Hb.</p>

<hr>

<p><em><strong>Zdroj:</strong> KDOQI US Commentary on the KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in CKD (AJKD, full text). <a href="https://www.ajkd.org/article/S0272-6386(26)00841-3/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
