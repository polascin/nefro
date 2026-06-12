<?php
/**
 * add_kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o prínose CGM u pacientov s diabetom
 * 2. typu bez inzulínu (štúdia CONNECT, ADA 2026, na motívy Medscape).
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
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Kontinuálne monitorovanie glukózy môže pomôcť aj pacientom s diabetom 2. typu bez inzulínu',
    'slug'         => 'kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia CONNECT (ADA 2026) ukazuje, že kontinuálne monitorovanie glukózy (CGM) výrazne zlepšuje glykémiu aj u dospelých s diabetom 2. typu, ktorí nepoužívajú inzulín — väčší pokles HbA1c, viac času v cieľovom rozmedzí a vyššia spokojnosť. Najviac profitujú pacienti s vysokým HbA1c.',
    'content'      => <<<'HTML'
<p>Kontinuálne monitorovanie glukózy, známe ako CGM, sa už roky považuje za štandardnú súčasť starostlivosti pri diabete 1. typu a pri diabete 2. typu liečenom inzulínom. Nové údaje zo štúdie CONNECT však ukazujú, že významný prínos môže mať aj u dospelých s diabetom 2. typu, ktorí inzulín nepoužívajú.</p>

<p>Výsledky boli prezentované na vedeckom kongrese <strong>American Diabetes Association 2026 Scientific Sessions</strong> v New Orleans. Podľa autorov štúdie môže CGM zlepšiť kontrolu hyperglykémie, pomôcť pacientom lepšie pochopiť vplyv stravy, pohybu a liekov na glykémiu a potenciálne znížiť riziko dlhodobých komplikácií diabetu.</p>

<h2>Prečo je táto otázka dôležitá</h2>

<p>U pacientov s diabetom 2. typu bez inzulínovej liečby sa CGM doteraz nepoužíva tak bežne ako u pacientov liečených inzulínom. Dôvodom je aj nedostatok veľkých randomizovaných štúdií, ktoré by jasne preukázali jeho prínos v tejto skupine.</p>

<p>Zároveň však veľká časť pacientov s diabetom 2. typu nedosahuje cieľové hodnoty glykémie ani napriek liečbe modernými liekmi, ako sú inhibítory SGLT2, agonisty receptora GLP-1 alebo iné antidiabetiká. Práve tu môže byť CGM praktickým nástrojom, ktorý nezasahuje len do liečby, ale aj do každodenného správania pacienta.</p>

<h2>Štúdia CONNECT</h2>

<p>Multicentrická štúdia <strong>CONNECT</strong> zahŕňala 283 dospelých pacientov s diabetom 2. typu, ktorí nepoužívali inzulín. Účastníci pochádzali z 22 ambulancií primárnej starostlivosti v Spojených štátoch.</p>

<p>Pacienti boli náhodne rozdelení do dvoch skupín:</p>

<ul>
  <li><strong>145 pacientov</strong> používalo CGM zariadenie Dexcom G7,</li>
  <li><strong>138 pacientov</strong> pokračovalo v bežnej starostlivosti so štandardným glukomerom.</li>
</ul>

<p>Obe skupiny pokračovali v predchádzajúcej antidiabetickej liečbe, dostali edukáciu o strave a pohybe a absolvovali pravidelné kontroly.</p>

<p>Priemerný vek pacientov bol 60 rokov. Medián trvania diabetu bol 10 rokov. Priemerná vstupná hodnota HbA1c bola 8,8 %, pričom 31 % pacientov malo HbA1c aspoň 9 %. Priemerný BMI bol 33 kg/m². Časť pacientov užívala modernú liečbu, konkrétne 37 % inhibítor SGLT2 a 40 % liečbu založenú na inkretínoch, napríklad agonistu receptora GLP-1.</p>

<h2>Výraznejšie zníženie HbA1c</h2>

<p>Po 26 týždňoch dosiahli pacienti používajúci CGM podstatne väčšie zlepšenie glykémie než pacienti v skupine bežnej starostlivosti.</p>

<p>HbA1c sa znížil:</p>

<ul>
  <li>o <strong>1,6 %</strong> v skupine s CGM,</li>
  <li>o <strong>0,7 %</strong> v skupine bežnej starostlivosti.</li>
</ul>

<p>Rozdiel medzi skupinami predstavoval <strong>0,9 %</strong> a bol štatisticky významný.</p>

<p>Najväčší prínos mali pacienti s najvyššou vstupnou hodnotou HbA1c. U pacientov s HbA1c pod 8 % bol rozdiel medzi CGM a bežnou starostlivosťou menší. Naopak, u pacientov s HbA1c aspoň 10 % klesol HbA1c o <strong>3,1 %</strong> pri CGM oproti <strong>1,2 %</strong> pri bežnej starostlivosti.</p>

<p>To je klinicky dôležité, pretože práve pacienti s najvýraznejšou hyperglykémiou majú najvyššie riziko vaskulárnych komplikácií.</p>

<h2>Viac času v cieľovom rozmedzí</h2>

<p>CGM neprináša iba informáciu o priemernej hodnote glykémie. Jeho výhodou je možnosť sledovať, koľko času pacient trávi v cieľovom glykemickom rozmedzí.</p>

<p>V štúdii sa hodnotilo rozmedzie <strong>70 až 180 mg/dl</strong> (3,9 až 10,0 mmol/l). Pacienti s CGM strávili v tomto cieľovom rozmedzí približne o <strong>5 hodín denne viac</strong> než pacienti v bežnej starostlivosti.</p>

<p>Čas v cieľovom rozmedzí sa v skupine s CGM zvýšil z 29 % na 62 %. V skupine bežnej starostlivosti stúpol z 31 % na 42 %. Rozdiel bol štatisticky významný.</p>

<h2>Prínos bez ohľadu na modernú farmakoterapiu</h2>

<p>Dôležitým zistením je, že prínos CGM sa pozoroval u pacientov užívajúcich aj neužívajúcich agonisty receptora GLP-1 a inhibítory SGLT2.</p>

<p>To naznačuje, že CGM nemá význam len ako doplnok pri nedostatočnej liečbe. Môže byť užitočné aj u pacientov, ktorí už dostávajú účinné moderné antidiabetiká, ale stále potrebujú lepšiu glykemickú kontrolu a spätnú väzbu v každodennom režime.</p>

<h2>Bezpečnosť a spokojnosť pacientov</h2>

<p>V štúdii neboli hlásené žiadne prípady ťažkej hypoglykémie ani v jednej skupine. Výskyt závažných nežiaducich udalostí nesúvisiacich s CGM bol podobný.</p>

<p>Pacienti používajúci CGM zároveň hlásili vyššiu spokojnosť s manažmentom diabetu a nižšiu mieru diabetického distresu. Tento aspekt je prakticky významný. Diabetes je vo veľkej miere ochorenie riadené samotným pacientom. Ak pacient lepšie vidí dôsledky svojich rozhodnutí, môže aktívnejšie upravovať stravu, pohyb a adherenciu k liečbe.</p>

<h2>Význam pre verejné zdravie</h2>

<p>Podľa odborníkov majú výsledky význam aj z pohľadu verejného zdravia. Pacienti s diabetom 2. typu bez inzulínu tvoria veľkú časť populácie s diabetom. V USA ide približne o tri štvrtiny dospelých s diabetom 2. typu, teda asi 20 miliónov ľudí.</p>

<p>Keďže CGM v tejto skupine často nie je hradené poisťovňami, nové dáta môžu podporiť diskusiu o širšej dostupnosti tejto technológie. Treba však dodať, že štúdia bola financovaná spoločnosťou Dexcom, výrobcom použitého CGM systému, čo je potrebné zohľadniť pri interpretácii výsledkov.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Výsledky štúdie CONNECT naznačujú, že CGM môže byť užitočné aj u pacientov s diabetom 2. typu, ktorí nepoužívajú inzulín, najmä ak majú zvýšené HbA1c napriek liečbe a režimovým odporúčaniam.</p>

<p>Najväčší praktický prínos možno očakávať u pacientov s výraznejšou hyperglykémiou, nízkym časom v cieľovom rozmedzí, neistotou v stravovacích návykoch alebo potrebou lepšej spätnej väzby o účinku liekov a životného štýlu.</p>

<p>CGM však nie je samoúčelný prístroj. Jeho hodnota vzniká až vtedy, keď pacient a zdravotnícky tím dokážu namerané údaje správne interpretovať a premietnuť ich do konkrétnych rozhodnutí.</p>

<h2>Záver</h2>

<p>Nové dáta zo štúdie CONNECT posúvajú diskusiu o CGM za hranice inzulínovej liečby. U pacientov s diabetom 2. typu bez inzulínu viedlo kontinuálne monitorovanie glukózy k výraznejšiemu poklesu HbA1c, predĺženiu času v cieľovom rozmedzí, vyššej spokojnosti s liečbou a nižšiemu diabetickému distresu.</p>

<p>Ak sa tieto výsledky potvrdia aj v ďalších štúdiách a v bežnej klinickej praxi, CGM sa môže stať dôležitým nástrojom individualizovanej starostlivosti o širšiu skupinu pacientov s diabetom 2. typu.</p>

<div class="info-box-blue">
<p><strong>Poznámka — prepočet jednotiek glukózy.</strong> Hodnota v mmol/l uvedená v zátvorke je prepočítaná z mg/dl a zaokrúhlená na jedno desatinné miesto. Pre glukózu v krvi platí:</p>
<ul>
  <li>mmol/l = mg/dl ÷ 18 (čiže mg/dl × 0,0555),</li>
  <li>mg/dl = mmol/l × 18.</li>
</ul>
</div>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „CGM Monitoring Benefits Extend to Non-Insulin-Using T2D“. <a href="https://www.medscape.com/viewarticle/cgm-monitoring-benefits-extend-non-insulin-using-t2d-2026a1000iz6" target="_blank" rel="noopener noreferrer">medscape.com</a></em></p>
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
