<?php
/**
 * add_mierne-obmedzenie-bielkovin-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o miernej proteínovej reštrikcii pri CKD
 * (retrospektívna kohortová štúdia, JAMA Network Open).
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
    'title'        => 'Mierne obmedzenie bielkovín môže pri chronickej chorobe obličiek zlepšiť prognózu',
    'slug'         => 'mierne-obmedzenie-bielkovin-ckd-prognoza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Retrospektívna kohortová štúdia v JAMA Network Open: mierne obmedzenie príjmu bielkovín pod 1,0 g/kg/deň pri CKD v štádiu III–IV bolo spojené s 23 % nižším rizikom nepriaznivých výsledkov a 35 % nižším rizikom dialýzy.',
    'content'      => <<<'HTML'
<p>Diétne odporúčania pri chronickej chorobe obličiek patria medzi najdiskutovanejšie oblasti nefrologickej starostlivosti. Osobitne citlivou témou je príjem bielkovín. Na jednej strane môže nadmerný príjem bielkovín zvyšovať glomerulárnu hyperfiltráciu a urýchľovať progresiu ochorenia obličiek. Na druhej strane príliš prísna restrikcia môže viesť k podvýžive, úbytku svalovej hmoty a horším klinickým výsledkom.</p>

<p>Nová retrospektívna kohortová štúdia publikovaná v časopise <em>JAMA Network Open</em> naznačuje, že <strong>mierne obmedzenie príjmu bielkovín u pacientov s chronickou chorobou obličiek v štádiu III a IV môže byť spojené s lepšími klinickými výsledkami</strong>, najmä s nižším rizikom začatia dialyzačnej liečby.</p>

<h2>Čo štúdia sledovala</h2>

<p>Výskumníci hodnotili dospelých pacientov s nedialyzovanou chronickou chorobou obličiek v štádiu III a IV. Do analýzy bolo zahrnutých <strong>1441 pacientov</strong>, priemerný vek bol 67,2 roka a ženy tvorili 35,2 % sledovaného súboru.</p>

<p>Zo štúdie boli vylúčení pacienti s odhadovanou glomerulovou filtráciou nad 60 alebo pod 15 ml/min/1,73 m², pacienti liečení dialýzou a pacienti po transplantácii obličky.</p>

<p>Príjem bielkovín nebol hodnotený iba podľa diétneho dotazníka. Vedci ho odhadovali objektívnejšie, pomocou <strong>24-hodinového vylučovania dusíka močom</strong>, následne prepočítaného na upravenú telesnú hmotnosť. Takto vypočítaný normalizovaný denný príjem bielkovín sa označuje ako nDPI.</p>

<p>Medián vstupnej hodnoty nDPI bol <strong>1,18 g/kg/deň</strong>.</p>

<p>Pacienti boli rozdelení do dvoch skupín:</p>

<ul>
  <li><strong>nižší príjem bielkovín:</strong> nDPI pod 1,0 g/kg/deň,</li>
  <li><strong>vyšší príjem bielkovín:</strong> nDPI 1,0 g/kg/deň alebo viac.</li>
</ul>

<p>Po štatistickom párovaní podľa propensity skóre bola analyzovaná porovnateľnejšia skupina <strong>530 pacientov</strong>, teda 265 pacientov v každej skupine.</p>

<h2>Hlavný sledovaný výsledok</h2>

<p>Primárnym výsledkom bol zložený ukazovateľ, ktorý zahŕňal prvý výskyt jednej z týchto udalostí:</p>

<ul>
  <li>pokles odhadovanej glomerulovej filtrácie najmenej o 50 %, potvrdený po minimálne 28 dňoch,</li>
  <li>začatie dialyzačnej liečby,</li>
  <li>úmrtie z akejkoľvek príčiny.</li>
</ul>

<p>Maximálna dĺžka sledovania bola až 15 rokov, medián sledovania dosiahol 67 mesiacov.</p>

<h2>Nižší príjem bielkovín bol spojený s nižším rizikom nepriaznivého výsledku</h2>

<p>V párovanej kohorte bol nižší príjem bielkovín spojený s <strong>23 % nižším rizikom zloženého nepriaznivého výsledku</strong> v porovnaní s vyšším príjmom bielkovín.</p>

<p>Hazard ratio bolo 0,77, s 95 % intervalom spoľahlivosti 0,62 až 0,97.</p>

<p>Najvýraznejší rozdiel sa týkal začatia dialýzy. Pacienti s nižším príjmom bielkovín mali <strong>35 % nižšie riziko začatia dialyzačnej liečby</strong>. Hazard ratio bolo 0,65, s 95 % intervalom spoľahlivosti 0,42 až 0,99.</p>

<p>Aj po úprave na vek, pohlavie, diabetes mellitus, BMI, vstupnú eGFR, sérový albumín a pomer albumínu ku kreatinínu v moči zostal nižší príjem bielkovín spojený so štatisticky významne nižším rizikom zloženého výsledku.</p>

<h2>Funkcia obličiek klesala v oboch skupinách</h2>

<p>Odhadovaná glomerulová filtrácia počas sledovania klesala v oboch skupinách. V skupine s nižším príjmom bielkovín bol pokles numericky pomalší, hoci hlavným klinicky významným rozdielom zostalo najmä nižšie riziko začatia dialýzy.</p>

<p>Z praktického hľadiska je dôležité, že nižší príjem bielkovín nebol spojený so zhoršením štandardných nutričných ukazovateľov. Medzi skupinami sa nepozorovali významné rozdiely v sledovaných parametroch výživového stavu.</p>

<h2>Prečo je tento výsledok dôležitý</h2>

<p>V klinickej praxi sa odporúčania týkajúce sa príjmu bielkovín často realizujú nedôsledne. Dôvodom je neistota, obava z malnutrície, rozdielna adherencia pacientov a niekedy aj nedostatok špecializovaného nutričného poradenstva.</p>

<p>Táto štúdia naznačuje, že nemusí ísť o extrémne prísnu diétu. Už <strong>mierne zníženie príjmu bielkovín pod 1,0 g/kg/deň</strong> môže byť spojené s priaznivejším priebehom ochorenia u pacientov s CKD v štádiu III a IV.</p>

<p>Autori štúdie uvádzajú, že mierna proteínová reštrikcia, dokonca aj nad tradične odporúčanými prahmi, môže v bežnej klinickej praxi poskytovať renálnu ochranu bez zhoršenia nutričného stavu.</p>

<h2>Nie je to výzva na svojvoľné obmedzovanie stravy</h2>

<p>Výsledky treba interpretovať opatrne. Štúdia bola retrospektívna, preto nemôže jednoznačne dokázať príčinnú súvislosť. Môže byť ovplyvnená výberovým skreslením a faktormi, ktoré nebolo možné úplne zohľadniť.</p>

<p>Chýbali tiež podrobné údaje o konkrétnych diétnych odporúčaniach, intenzite nutričného poradenstva, dlhodobej adherencii pacientov a o zdrojoch bielkovín, teda o podiele živočíšnych a rastlinných bielkovín.</p>

<p>Preto nemožno výsledok zjednodušiť na univerzálne odporúčanie, že každý pacient s chronickou chorobou obličiek má automaticky výrazne obmedziť bielkoviny. Pri pacientovi s CKD treba vždy zohľadniť vek, štádium ochorenia, albuminúriu, komorbidity, telesnú hmotnosť, svalovú hmotu, riziko malnutrície a celkový klinický stav.</p>

<h2>Praktický záver pre nefrologickú starostlivosť</h2>

<p>Štúdia podporuje racionálny a individualizovaný prístup k príjmu bielkovín pri chronickej chorobe obličiek. U pacientov s nedialyzovanou CKD v štádiu III a IV môže byť mierne obmedzenie príjmu bielkovín pod 1,0 g/kg/deň spojené s nižším rizikom nepriaznivých klinických výsledkov, najmä s nižšou pravdepodobnosťou začatia dialýzy.</p>

<p>Kľúčové však je, aby išlo o <strong>kontrolovanú diétnu intervenciu</strong>, nie o neodborné hladovanie alebo neprimerané obmedzovanie stravy. Ideálne má byť súčasťou nefrologickej starostlivosti aj nutričné hodnotenie a diétne poradenstvo, zvlášť u starších pacientov a u pacientov s rizikom proteinovo-energetickej malnutrície.</p>

<p>Mierna proteínová reštrikcia môže byť užitočným nástrojom, ale len vtedy, ak je správne indikovaná, pravidelne kontrolovaná a prispôsobená konkrétnemu pacientovi.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „Modest Protein Restriction Tied to Better Outcomes in CKD". <a href="https://www.medscape.com/viewarticle/modest-protein-restriction-tied-better-outcomes-ckd-2026a1000i3l" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
