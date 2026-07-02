<?php
/**
 * add_retatrutid-ubytok-hmotnosti-metabolicke-benefity_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o trojitom agonistovi retatrutide
 * (štúdie TRANSCEND-T2D-1 a TRIUMPH-1, ADA 2026 / The Lancet, na motívy Medscape).
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
    'title'        => 'Retatrutid prináša výrazný úbytok hmotnosti aj metabolické benefity. Nové dáta však treba čítať opatrne',
    'slug'         => 'retatrutid-ubytok-hmotnosti-metabolicke-benefity',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Trojitý agonista receptorov GLP-1, GIP a glukagónu retatrutid priniesol v štúdiách TRANSCEND-T2D-1 a TRIUMPH-1 výrazný úbytok hmotnosti (až 30 %), lepšiu kompenzáciu diabetu 2. typu aj priaznivé kardiometabolické zmeny. Sľubné dáta však treba čítať opatrne — ide o liek vo vývoji.',
    'content'      => <<<'HTML'
<p>Experimentálny liek <strong>retatrutid</strong> priniesol v nových klinických štúdiách výrazný úbytok hmotnosti, zlepšenie kompenzácie diabetu 2. typu a priaznivé zmeny viacerých kardiometabolických rizikových faktorov. Údaje boli prezentované na vedeckom kongrese <strong>American Diabetes Association 2026</strong> v New Orleans. Výsledky štúdie TRANSCEND-T2D-1 boli zároveň publikované v časopise <strong>The Lancet</strong>.</p>

<p>Retatrutid je skúšaný liek zo skupiny terapií s inkretínovým účinkom. Je to <strong>trojitý agonista receptorov GLP-1, GIP a glukagónu</strong>. Práve kombinácia týchto mechanizmov má potenciál ovplyvniť nielen glykémiu, ale aj telesnú hmotnosť, energetický výdaj a metabolické parametre. Liek však zostáva v štádiu klinického skúšania a jeho miesto v klinickej praxi bude závisieť od ďalších dát, regulačného posúdenia, bezpečnosti a dostupnosti.</p>

<h2>Výsledky u pacientov s diabetom 2. typu</h2>

<p>V štúdii <strong>TRANSCEND-T2D-1</strong> bolo sledovaných 537 pacientov s nedostatočne kontrolovaným diabetom 2. typu. Vstupná hodnota HbA1c bola v rozmedzí 7,0 až 9,5 %. Účastníci mali BMI aspoň 23 kg/m² a boli randomizovaní na retatrutid v dávkach 4 mg, 9 mg alebo 12 mg, prípadne na placebo.</p>

<p>Po 40 týždňoch sa HbA1c znížil:</p>

<ul>
  <li>o <strong>1,69 %</strong> pri dávke 4 mg,</li>
  <li>o <strong>1,86 %</strong> pri dávke 9 mg,</li>
  <li>o <strong>1,94 %</strong> pri dávke 12 mg,</li>
  <li>oproti <strong>0,81 %</strong> pri placebe.</li>
</ul>

<p>Okrem lepšej glykemickej kontroly došlo aj k výraznému poklesu telesnej hmotnosti. Pri najvyššej dávke 12 mg bol priemerný úbytok hmotnosti <strong>15,3 %</strong>, zatiaľ čo pri placebe len <strong>2,6 %</strong>. V absolútnom vyjadrení to pri najvyššej dávke zodpovedalo približne 16,6 kg (asi 36,6 libry).</p>

<p>Vedúci výskumník štúdie Harpreet Singh Bajaj označil tento rozsah redukcie hmotnosti u ľudí s diabetom 2. typu za mimoriadny, keďže pacienti s diabetom zvyčajne chudnú menej ako ľudia bez diabetu.</p>

<h2>Výsledky u ľudí s obezitou bez diabetu</h2>

<p>Ďalšie údaje pochádzajú zo štúdie <strong>TRIUMPH-1</strong>, ktorá zahŕňala 2 339 dospelých s obezitou. Účastníci boli rozdelení do skupín s retatrutidom v dávkach 4 mg, 9 mg a 12 mg alebo s placebom.</p>

<p>Po 80 týždňoch dosiahli pacienti užívajúci najvyššiu dávku 12 mg priemerný pokles hmotnosti <strong>28,3 %</strong> (približne 31,8 kg, asi 70 libier). Pri dávke 9 mg bol priemerný úbytok približne 26 % telesnej hmotnosti.</p>

<p>V predĺžení štúdie na 104 týždňov sa úbytok hmotnosti pohyboval od <strong>19,2 %</strong> pri dávke 4 mg až po <strong>30,3 %</strong> pri dávke 12 mg (približne 38,6 kg, asi 85 libier). Viac ako štvrtina účastníkov stratila aspoň 35 % telesnej hmotnosti.</p>

<p>Takéto hodnoty sú pri farmakoterapii obezity neobvykle vysoké. Neznamená to však automaticky, že maximálne chudnutie je vhodným cieľom pre každého pacienta.</p>

<h2>Vplyv na osteoartrózu a spánkové apnoe</h2>

<p>Štúdia TRIUMPH-1 zahŕňala aj dve vnorené analýzy. Jedna sledovala pacientov s osteoartrózou kolena a druhá pacientov so stredne ťažkým až ťažkým obštrukčným spánkovým apnoe.</p>

<p>Pri osteoartróze kolena retatrutid znížil skóre bolesti podľa indexu WOMAC až o <strong>73,1 %</strong>. Pri spánkovom apnoe znížil index apnoe-hypopnoe (AHI) až o <strong>60,6 %</strong>. Tieto výsledky podporujú myšlienku, že liečba obezity môže ovplyvniť aj jej pridružené komplikácie, nielen samotnú telesnú hmotnosť.</p>

<h2>Kardiometabolické benefity</h2>

<p>V oboch štúdiách sa pozorovali priaznivé zmeny rizikových faktorov.</p>

<p>V štúdii TRIUMPH-1 bol retatrutid spojený so znížením:</p>

<ul>
  <li>triglyceridov až o <strong>41,0 %</strong>,</li>
  <li>non-HDL cholesterolu až o <strong>24,2 %</strong>,</li>
  <li>systolického tlaku až o <strong>12,3 mm Hg</strong>,</li>
  <li>obvodu pása až o <strong>24,1 cm</strong>.</li>
</ul>

<p>V štúdii TRANSCEND-T2D-1 sa zaznamenalo zníženie:</p>

<ul>
  <li>triglyceridov až o <strong>39,6 %</strong>,</li>
  <li>non-HDL cholesterolu až o <strong>19,8 %</strong>,</li>
  <li>systolického tlaku až o <strong>6,4 mm Hg</strong>,</li>
  <li>obvodu pása až o <strong>12,4 cm</strong>.</li>
</ul>

<p>Tieto údaje sú klinicky zaujímavé, pretože obezita, diabetes 2. typu, dyslipidémia, hypertenzia a viscerálna adipozita sa často vzájomne posilňujú.</p>

<h2>Nežiaduce účinky a nový signál infekcií močových ciest</h2>

<p>Profil nežiaducich účinkov bol podobný ako pri iných inkretínových liekoch. Najčastejšie sa objavovali gastrointestinálne ťažkosti, najmä nauzea, hnačka a zápcha. Väčšina bola mierna až stredne závažná a počas liečby ustúpila.</p>

<p>Novým bezpečnostným signálom boli <strong>infekcie močových ciest</strong>. V štúdii TRIUMPH-1 sa vyskytli u 7,5 až 8,8 % pacientov liečených retatrutidom oproti 5,3 % pri placebe. V štúdii TRANSCEND-T2D-1 bol výskyt 0,7 až 2,9 % oproti 0 % pri placebe. Podľa výskumníkov zatiaľ nie je jasné, či ide o náhodný nález, dôsledok hydratácie, zmien diurézy alebo iný mechanizmus.</p>

<p>Prerušenie liečby pre nežiaduce účinky bolo dávkovo závislé. V štúdii TRIUMPH-1 liečbu ukončilo 4,1 % pacientov pri dávke 4 mg, 6,9 % pri dávke 9 mg a 11,3 % pri dávke 12 mg, oproti 4,9 % pri placebe.</p>

<h2>Nie je všetko iba o maximálnom chudnutí</h2>

<p>Výsledky sú pôsobivé, ale odborníci upozorňujú na potrebu opatrnosti. Rýchly a veľmi výrazný pokles hmotnosti môže mať aj riziká. Otázkou zostáva, u koho je takáto intenzita liečby vhodná, ako dlho má liečba trvať, ako zabezpečiť udržanie účinku a ako sledovať možné nežiaduce následky.</p>

<p>Endokrinologička Alice Y. Y. Cheng upozornila, že väčší úbytok hmotnosti nemusí byť vždy lepší, potrebný ani správny pre každého pacienta. Kľúčovou otázkou podľa nej nie je iba samotné chudnutie, ale <strong>prínos pre zdravie</strong>.</p>

<p>To je podstatná poznámka. Pri liečbe obezity by cieľom nemalo byť číslo na váhe izolované od klinického kontextu. Dôležité sú metabolické výsledky, funkčný stav, kvalita života, tolerancia liečby, bezpečnosť a dostupnosť.</p>

<h2>Záver</h2>

<p>Retatrutid predstavuje jednu z najsľubnejších experimentálnych terapií v oblasti obezity a diabetu 2. typu. Dáta ukazujú výrazný úbytok hmotnosti, zlepšenie HbA1c, priaznivý vplyv na lipidy, krvný tlak, obvod pása a potenciálne aj na komplikácie obezity, ako sú osteoartróza kolena a obštrukčné spánkové apnoe.</p>

<p>Zároveň však platí, že ide o liek vo vývoji. Potrebné sú ďalšie údaje o dlhodobej bezpečnosti, udržateľnosti účinku, výbere vhodných pacientov a reálnej dostupnosti. Retatrutid môže byť silným nástrojom, ale jeho hodnota sa bude merať nie iba kilogramami, ale najmä tým, či pacientom prinesie bezpečný a udržateľný zdravotný prínos.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Retatrutide Data Show Dramatic Weight Loss, Other Benefits“. <a href="https://www.medscape.com/viewarticle/retatrutide-data-show-dramatic-weight-loss-other-benefits-2026a1000iz0" target="_blank" rel="noopener noreferrer">medscape.com</a></em></p>
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
        } else {
            $skipped++;
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
