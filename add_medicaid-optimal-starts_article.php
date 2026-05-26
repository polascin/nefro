<?php
/**
 * add_medicaid-optimal-starts_article.php
 * Vkladá článok o rozšírení Medicaidu a „optimal starts" pri incidenčnom zlyhaní obličiek.
 */

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
    'title'        => 'Rozšírenie Medicaidu a „optimálne začatie" liečby pri incidenčnom zlyhaní obličiek: výsledky observačnej kohortovej analýzy (2008–2019)',
    'slug'         => 'medicaid-a-optimalne-zacatie-pri-incidencnom-zlyhani-obliciek',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-26',
    'is_top'       => 0,
    'excerpt'      => 'Observačná kohortová analýza z US Renal Data System (2008–2019) porovnávala „optimal starts" pri incidenčnom zlyhaní obličiek v štátoch USA s expanziou Medicaidu oproti štátom bez nej. Do roku 2019 bol upravený rozdiel v podiele optimal starts o 3,9 % vyšší v expanzných štátoch, pričom hlavným prispievateľom bola domáca dialýza.',
    'content'      => <<<'HTML'
<h2>Prečo sa to rieši</h2>

<p>U časti pacientov so zlyhaním obličiek nejde len o to, akú liečbu dostanú, ale aj o to, <strong>ako a v akom čase sa začne</strong>. Prakticky dôležité sú najmä kroky v období pred dialýzou, ktoré môžu zlepšiť priebeh liečby. V tomto kontexte sa v štúdii hodnotí, či <strong>rozšírenie Medicaidu</strong> (Medicaid expansion) v štátoch USA súvisí s rastom podielu pacientov, ktorí dosiahnu tzv. <strong>„optimal starts"</strong> pri incidenčnom zlyhaní obličiek.</p>

<h2>Definícia „optimal start"</h2>

<p>Autori definovali <strong>„optimal start"</strong> ako splnenie aspoň jednej z týchto možností, ktoré predpokladajú priaznivejší vstup do liečby:</p>
<ul>
  <li><strong>preemptívna transplantácia obličky</strong>, alebo</li>
  <li><strong>začatie domácej dialýzy</strong> (home dialysis), alebo</li>
  <li><strong>začatie hemodialýzy v dialyzačnom stredisku s arteriovenóznym prístupom</strong> (in-center hemodialysis s AV prístupom)</li>
</ul>

<p>Ide teda o kombináciu ukazovateľov kvality predstartovej fázy a pripravenosti pacienta na dlhodobejšiu liečbu.</p>

<h2>Dizajn štúdie a populácia</h2>

<p>Štúdia bola <strong>observačná</strong> a využila <strong>ročné kohorty</strong> z <strong>US Renal Data System</strong> v období <strong>2008 až 2019</strong>.</p>

<ul>
  <li><strong>Populácia:</strong> dospelí vo veku <strong>26 až 64 rokov</strong> s <strong>incidenčným zlyhaním obličiek vyžadujúcim liečbu</strong></li>
  <li><strong>Expozícia:</strong> bydlisko v štáte, ktorý <strong>rozšíril Medicaid</strong> alebo nerozšíril od <strong>1. januára 2014</strong></li>
  <li><strong>Analytický prístup:</strong> analýza prerušenej časovej série (interrupted time-series) so zameraním na porovnanie zmien trendov <strong>pred a po roku 2014</strong> (teda nie iba jednorazové porovnanie v čase)</li>
  <li><strong>Veľkosť súborov:</strong>
    <ul>
      <li><strong>323 807</strong> pacientov zo štátov s expanziou Medicaid</li>
      <li><strong>271 725</strong> pacientov zo štátov bez expanzie</li>
    </ul>
  </li>
  <li><strong>Časové okno:</strong> ukončenie sledovania v roku 2019 bolo zvolené tak, aby sa minimalizovali vplyvy pandémie COVID-19</li>
  <li><strong>Rozšírenie:</strong> týkalo sa <strong>DC a 24 štátov</strong>, zatiaľ čo <strong>17 štátov Medicaid nerozšírilo</strong> a niektoré „intermediate" štáty boli z analýz vyňaté</li>
</ul>

<h2>Kľúčové výsledky</h2>

<h3>1) Po roku 2014 sa začal trend rozchádzať</h3>

<p>Autori pozorovali, že <strong>pred expanziou Medicaidu</strong> sa „optimal starts" v štátoch s expanziou aj bez nej vyvíjali <strong>podobným smerom</strong>.</p>

<p>Po roku 2014 však došlo k divergencii:</p>
<ul>
  <li>rozdiel v <strong>upravenom (adjusted)</strong> podiele „optimal starts" sa po roku 2014 <strong>zvyšoval</strong></li>
  <li>do roku 2019 mali štáty s expanziou v upravenej analýze približne <strong>o 3,9 % vyšší podiel</strong> pacientov s „optimal starts" oproti štátom bez expanzie</li>
  <li>trendová zmena bola štatisticky významná (<strong>P = 0,02</strong>), čo podporuje interpretáciu, že ide skôr o odlišnú zmenu vývoja v čase než o náhodný rozdiel medzi skupinami</li>
</ul>

<h3>2) Najväčší príspevok mala domáca dialýza</h3>

<p>Z analýzy vyplýva, že väčšinu rastúceho rozdielu medzi skupinami vysvetľoval najmä sektor:</p>
<ul>
  <li><strong>domáca dialýza</strong> (home dialysis), ktorej podiel v štátoch s expanziou po roku 2014 rástol <strong>rýchlejšie</strong> (o <strong>0,29 % ročne</strong> viac než v neexpanzných štátoch)</li>
</ul>

<p>Naopak:</p>
<ul>
  <li><strong>preemptívna transplantácia</strong> zostávala dlhodobo vyššia v štátoch s expanziou, ale nevykazovala porovnateľne výrazný <strong>„post-2014" zlom trendu</strong> ako domáca dialýza</li>
  <li>aj <strong>hemodialýza v centre s AV prístupom</strong> sa relatívne zvyšovala, no bez podobného zlomového efektu po roku 2014</li>
</ul>

<p>Inými slovami, ak sa rozdiel „zapne", deje sa to najmä cez <strong>dynamiku domácej dialýzy</strong>.</p>

<h3>3) Menila sa poistná dostupnosť a rástla predstartová starostlivosť</h3>

<p>Štúdia sledovala aj ukazovatele, ktoré slúžili ako <strong>sprostredkujúce proxy pre politiku a prístup</strong>:</p>
<ul>
  <li><strong>Medicaid coverage</strong> v expanzných štátoch stúpla o <strong>1,97 % ročne viac</strong></li>
  <li><strong>podiely nepoistených (uninsured)</strong> klesli o <strong>1,04 % ročne viac</strong></li>
</ul>

<p>Pokiaľ ide o predstartovú nefrologickú starostlivosť:</p>
<ul>
  <li>predstartová starostlivosť u nefrológov sa počas štúdie v expanzných štátoch zlepšovala výraznejšie,</li>
  <li>no nezdá sa, že by sa práve po roku 2014 tento trend <strong>ďalej zrýchlil</strong> (skôr ide o dlhšie prebiehajúce zlepšovanie než o bezprostredný „akcelerátor" po zmene politiky)</li>
</ul>

<p>Dôležité je, že samostatná analýza incidencie neposkytla podporu pre vysvetlenie, že „optimal starts" by sa zvýšili iba preto, že by narastal celkový počet liečených prípadov.</p>

<h2>Interpretácia v klinickom kontexte</h2>

<p>Výsledok možno interpretovať tak, že rozšírenie poistného krytia súvisí s tým, ako pacienti vstupujú do liečby pri incidenčnom zlyhaní obličiek. V štúdii sa to najmä viaže na:</p>
<ul>
  <li>väčšiu schopnosť využívať <strong>domácu dialýzu v správnom čase</strong>,</li>
  <li>a celkovo priaznivejšie plánovanie alebo pripravenosť na liečbu.</li>
</ul>

<p>Treba však povedať na rovinu: ide o <strong>observačnú asociáciu</strong>. Štúdia sama uvádza, že neexistuje garancia kauzality, pretože môžu pôsobiť aj ďalšie faktory na úrovni štátov (napríklad iné zdravotnícke programy, organizácia nefrologickej siete, regionálne postupy či rozdiely v poskytovateľoch).</p>

<h2>Limity, ktoré znižujú istotu záverov</h2>

<p>Pri tomto type analýz je rozumné rátať s týmito limitmi:</p>
<ul>
  <li>riziko <strong>nezmeraných mätúcich faktorov (unmeasured confounding)</strong> na úrovni štátov a zdravotníckych systémov</li>
  <li>nemožnosť úplne vylúčiť vplyv <strong>iných súbežných intervencií</strong> mimo Medicaidu</li>
  <li>štúdia neskúmala klinické výsledky po začatí liečby (napríklad mortalitu alebo komplikácie v nadväznosti na „optimal start")</li>
  <li>pozorovania sa týkali vekovej skupiny <strong>26 až 64 rokov</strong> a sledovanie bolo ukončené pred pandémiou, aby sa obmedzil jej vplyv</li>
</ul>

<h2>Praktický význam</h2>

<p>Pre klinickú prax a organizáciu nefrologickej starostlivosti majú výsledky význam najmä ako signál, že:</p>
<ul>
  <li>zmena dostupnosti poistného krytia môže súvisieť s tým, či pacienti dostanú šancu na <strong>kvalitnejší vstup</strong> do liečby,</li>
  <li>a že medzi „optimal starts" sú ukazovatele, ktoré sa menia najvýraznejšie v situáciách, keď sa menia podmienky prístupu, konkrétne cez <strong>domácu dialýzu</strong>.</li>
</ul>

<p>Ak sa tento trend potvrdí v ďalších štúdiách s presnejšou kauzálnou identifikáciou, mohlo by to posilniť argument, že zdravotné krytie a bariéry prístupu sú súčasťou stratégie <strong>„timely preparation"</strong> pre dialyzačnú liečbu.</p>

<hr>

<p><em><strong>Zdroj:</strong> ReachMD – <a href="https://reachmd.com/news/medicaid-expansion-and-optimal-starts-for-incident-kidney-failure/2487058/" target="_blank" rel="noopener noreferrer">Medicaid Expansion and Optimal Starts for Incident Kidney Failure</a>.</em></p>
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
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
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

          <p style="margin-top:30px;">
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
