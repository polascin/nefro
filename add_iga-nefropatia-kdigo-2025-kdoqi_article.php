<?php
/**
 * add_iga-nefropatia-kdigo-2025-kdoqi_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_iga-nefropatia-kdigo-2025-kdoqi_article.php"
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
    'title'        => 'IgA nefropatia podľa KDIGO 2025 a KDOQI US Commentary: od biopsie po cielenejšiu liečbu',
    'slug'         => 'iga-nefropatia-kdigo-2025-kdoqi',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prehľad manažmentu IgA nefropatie podľa KDIGO 2025 a KDOQI US Commentary: biopsia ako základ diagnózy, prognostická stratifikácia podľa eGFR a proteinúrie, nefarmakologické opatrenia, Nefecon, systémové kortikoidy a bezpečnostné body pre prax.',
    'content'      => <<<'HTML'
<p>IgA nefropatia (IgAN) je heterogénne imunitne podmienené ochorenie s variabilným klinickým priebehom. Praktický prínos KDIGO 2025 spočíva v tom, že posúva manažment smerom k včasnému rozpoznaniu rizikových pacientov a k liečbe zameranej na hlavné mechanizmy ochorenia. KDOQI US Commentary zároveň spresňuje, ako tieto odporúčania implementovať v každodennej klinickej praxi.</p>

<h2>1) Diagnóza IgAN: kľúčová je biopsia</h2>

<p>KDOQI commentary súhlasí s tým, že <strong>IgAN možno potvrdiť iba obličkovou biopsiou</strong>. Neexistujú validované sérové ani močové biomarkery, ktoré by diagnózu spoľahlivo nahradili.</p>

<h3>Kedy uvažovať o biopsii</h3>

<p>KDIGO odporúča biopsiu zvážiť u dospelých s <strong>proteinúriou ≥ 0,5 g/deň</strong> alebo ekvivalentom, ak IgAN prichádza do úvahy a biopsia nie je kontraindikovaná.</p>

<h3>Po potvrdení diagnózy</h3>

<p>Po potvrdení IgAN sa má zhodnotiť aj možné <strong>sekundárne pozadie</strong> a pri primárnej IgAN sa má určiť <strong>MEST-C skóre</strong> podľa revidovanej Oxford klasifikácie.</p>

<h2>2) Prognóza: riziko sa dá kvantifikovať, odpoveď na liečbu nie</h2>

<p>KDIGO aj KDOQI zdôrazňujú, že pri IgAN nie sú validované prognostické biomarkery v krvi ani v moči. Prognóza sa preto opiera najmä o:</p>

<ul>
  <li><strong>eGFR</strong>,</li>
  <li><strong>proteinúriu</strong>.</li>
</ul>

<h3>IgAN prediction tools</h3>

<p>Medzinárodné predikčné nástroje majú význam na <strong>rizikovú stratifikáciu</strong> a môžu podporiť zdieľané rozhodovanie s pacientom. KDOQI však upozorňuje, že tieto nástroje <strong>nemajú slúžiť na výber konkrétneho lieku</strong> ani na predikciu, kto na ktorú liečbu zareaguje. Neodporúčajú sa ani pre atypické fenotypy, ktoré neboli v pôvodných kohortách dostatočne zastúpené, napríklad pri akútnej nefritickej prezentácii, nefrotickom syndróme alebo rýchlo progredujúcej glomerulonefritíde.</p>

<h2>3) Cieľ liečby: spomaliť pokles eGFR a stlačiť proteinúriu dole</h2>

<p>KDIGO nastavuje cieľ liečby tak, aby sa rýchlosť poklesu eGFR približovala fyziologickému tempu pre väčšinu dospelých, teda približne <strong>&lt; 1 ml/min/rok</strong>. Najpraktickejším skorým markerom odpovede zostáva proteinúria, ktorá má byť minimálne <strong>&lt; 0,5 g/deň</strong> a ideálne <strong>&lt; 0,3 g/deň</strong>.</p>

<p>KDOQI zároveň pripomína, že u pacientov s pokročilým jazvením nemusí byť tento cieľ realisticky dosiahnuteľný a bude treba kombinovať farmakologické aj nefarmakologické postupy.</p>

<h2>4) Základ liečby rizikových pacientov: zásah do viacerých mechanizmov naraz</h2>

<p>KDOQI commentary podporuje mechanistický rámec KDIGO: u väčšiny rizikových pacientov má manažment súčasne:</p>

<ol>
  <li>obmedziť tvorbu IgA-obsahujúcich imunitných komplexov a glomerulárne poškodenie s nimi spojené,</li>
  <li>manažovať dôsledky straty nefrónov, pravdepodobne celoživotne.</li>
</ol>

<p>Praktický dôraz je na kombinácii liekov pôsobiacich na viacero článkov patofyziológie, nie iba na izolované znižovanie proteinúrie bez adresovania mechanizmov ochorenia.</p>

<h2>5) Praktické nefarmakologické a podporné kroky</h2>

<p>KDIGO praxové body sú konkrétne a v komentári sa zdôrazňuje, že nejde o „doplnky“, ale o reálne terapeutické zásahy:</p>

<ul>
  <li><strong>zníženie príjmu sodíka</strong> pod 2 g/deň,</li>
  <li><strong>ukončenie fajčenia a vapingu</strong>,</li>
  <li><strong>kontrola hmotnosti</strong> a vhodná aeróbna aktivita,</li>
  <li><strong>cieľ tlaku krvi ≤ 120/70 mm Hg</strong>,</li>
  <li><strong>blokáda RAS</strong> (ACEi/ARB) a podľa situácie aj stratégia na zníženie hyperfiltrácie,</li>
  <li>zváženie <strong>SGLT2 inhibítora</strong> ako súčasti renoprotektívneho rámca,</li>
  <li>komplexná kardiovaskulárna prevencia podľa lokálnych odporúčaní,</li>
  <li>v ideálnom prípade zváženie <strong>klinickej skúšky</strong>, ak je dostupná.</li>
</ul>

<h2>6) IgAN špecifická terapia: Nefecon ako preferovaná možnosť, ak je dostupný</h2>

<p>KDIGO odporúča <strong>9-mesačnú kúru Nefeconu</strong> u pacientov v riziku progresie, typicky v skupine 2B.</p>

<h3>Čo treba vedieť pred začiatkom Nefeconu</h3>

<p>KDOQI commentary podporuje princíp odporúčania, ale pripomína praktické limity:</p>

<ul>
  <li>odpoveď nemusí byť dlhodobá po ukončení liečby,</li>
  <li>údaje o opakovaných cykloch sú stále obmedzené,</li>
  <li>dostupnosť a schválenie sa medzi krajinami líšia.</li>
</ul>

<h3>Bezpečnosť a systémový tieň lokálneho steroidu</h3>

<p>Aj keď je Nefecon koncipovaný ako lokálny kortikosteroid s menšou systémovou expozíciou, KDOQI upozorňuje, že treba počítať s limitovanou absorpciou a klinicky významnými nežiaducimi účinkami. V štúdii boli závažné nežiaduce udalosti počas 9-mesačnej liečby častejšie v aktívnej skupine a častejšie bolo aj ukončenie liečby pre nežiaduce udalosti. V úvode liečby sa môže objaviť aj fenomén <strong>reverse dip</strong> na eGFR.</p>

<p>V praxi je preto dôležité pacientovi vysvetliť, že krátkodobé zmeny proteinúrie alebo eGFR ešte neznamenajú neúspech či úspech liečby.</p>

<h2>7) Ak Nefecon nie je dostupný: znížená dávka systémových kortikoidov s profylaxiou</h2>

<p>V prostredí bez Nefeconu KDOQI podporuje KDIGO odporúčanie použiť <strong>6 až 9 mesiacov zníženej dávky systémového glukokortikoidu</strong> s vhodnou profylaxiou.</p>

<h3>Odporúčaný režim methylprednizolónu</h3>

<ul>
  <li><strong>0,4 mg/kg/deň</strong>, maximálne <strong>32 mg/deň</strong>, počas <strong>2 mesiacov</strong>,</li>
  <li>potom tapering o <strong>4 mg/deň každý mesiac</strong>,</li>
  <li>celková dĺžka liečby <strong>6 až 9 mesiacov</strong>.</li>
</ul>

<h3>Povinná bezpečnostná vrstva</h3>

<p>Liečba má byť sprevádzaná:</p>

<ul>
  <li><strong>antimykotickou profylaxiou</strong> proti <em>Pneumocystis jirovecii</em>,</li>
  <li><strong>antivírusovou profylaxiou</strong> u nosičov HBsAg,</li>
  <li><strong>gastroprotekciou</strong> a <strong>ochranou kostí</strong> podľa lokálnych odporúčaní.</li>
</ul>

<h3>Pacienti s vyšším rizikom toxicity kortikoidov</h3>

<p>KDOQI upozorňuje na zvýšenú obozretnosť najmä pri týchto faktoroch:</p>

<ul>
  <li>eGFR &lt; 30 ml/min/1,73 m²,</li>
  <li>diabetes alebo prediabetes,</li>
  <li>obezita,</li>
  <li>latentné infekcie, napríklad vírusové hepatitídy alebo tuberkulóza,</li>
  <li>aktívna peptická ulcerácia,</li>
  <li>nekontrolované psychiatrické ochorenie,</li>
  <li>osteoporóza,</li>
  <li>katarakta.</li>
</ul>

<h2>Záver pre prax</h2>

<p>V manažmente IgAN sa ťažisko presúva na tri body: správnu diagnostiku, včasné rizikové zhodnotenie a liečbu zameranú na mechanizmy ochorenia. Bez biopsie sa diagnóza potvrdiť nedá, proteinúria ≥ 0,5 g/deň nie je banálna a cieľom je spomaliť pokles eGFR. Nefecon je preferovaným 9-mesačným zásahom, ak je dostupný; pri nedostupnosti sa zvažujú znížené dávky systémových kortikoidov s profylaxiou.</p>

<hr>

<p><em><strong>Zdroj:</strong> KDOQI US Commentary on the KDIGO 2025 Clinical Practice Guideline for IgA Nephropathy and IgA Vasculitis (AJKD, full text). <a href="https://www.ajkd.org/article/S0272-6386(26)00842-5/fulltext?dgcid=raven_jbs_etoc_email" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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