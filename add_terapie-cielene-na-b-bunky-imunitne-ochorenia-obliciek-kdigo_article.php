<?php
/**
 * add_terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Terapie cielené na B bunky pri imunitne sprostredkovaných
 * ochoreniach obličiek (KDIGO Controversies Conference).
 * Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie JEDNÉHO zdroja
 * (Floege et al., Kidney International 2026) → menovaní autori sú doplnení do
 * source_authors.php (mená overené cez Crossref, DOI 10.1016/j.kint.2026.02.029).
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Terapie cielené na B bunky pri imunitne sprostredkovaných ochoreniach obličiek: čo ukazuje konferencia KDIGO Controversies',
    'slug'         => 'terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Konferencia KDIGO Controversies ukazuje, že cielenie na B bunky pri imunitne sprostredkovaných ochoreniach obličiek nie je jedna stratégia, ale súbor diferencovaných prístupov. Účinnosť aj bezpečnosť závisia od diagnózy a od toho, ako hlboko a akým mechanizmom sa zasiahne B bunková os — od anti-CD20 cez inhibíciu BAFF/APRIL až po terapiu CAR T bunkami.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>KDIGO (Kidney Disease: Improving Global Outcomes) zorganizovalo v júni 2025 v meste Panama City konferenciu typu „Controversies“ venovanú terapiám, ktoré sa zameriavajú na B bunky pri imunitne sprostredkovaných ochoreniach obličiek. Cieľom bolo zhodnotiť dostupné dôkazy, upozorniť na kontroverzie a identifikovať zásadné medzery v poznatkoch tak, aby sa tieto stratégie dali v praxi využívať cielene a bezpečne.</p>

<p>Problematika B buniek nie je jednotná. Pri rôznych diagnózach môžu dominovať odlišné B bunkové procesy (tvorba protilátok, prežívanie B a plazmatických buniek, interakcie s ďalšími zložkami imunity) a klinická odpoveď môže závisieť od toho, akú „časť“ B bunkovej osi terapie skutočne zasiahnu.</p>

<p>Konferencii spolupredsedali <strong>Jürgen Floege</strong> a <strong>Brad Rovin</strong>.</p>

<h2>Prečo je cielenie na B bunky zmysluplné, ale nie jednoduché</h2>

<p>Podľa konferenčnej správy sa terapie, ktoré B bunky depletujú alebo modulujú, už používajú alebo sa intenzívne skúmajú naprieč viacerými glomerulárnymi ochoreniami. Zároveň však platí, že účinnosť aj bezpečnosť sa medzi diagnózami výrazne líšia.</p>

<p>Kľúčové kontroverzie, ktoré konferencia zdôrazňuje, sú najmä tieto:</p>

<ol>
  <li><strong>Čo presne znamená „dostatočne hlboká“ deplécia B buniek</strong> a či rozhoduje rozsah deplécie, miesto jej dosiahnutia (periféria verzus lymfatické tkanivá), alebo oboje.</li>
  <li><strong>Aká je optimálna intenzita a trvanie liečby</strong> pre konkrétny fenotyp a ochorenie.</li>
  <li><strong>Aký je reálny pomer prínosu a rizika</strong>, najmä pri pokročilých bunkových terapiách.</li>
  <li>Ako odlíšiť pacientov, u ktorých sa očakáva klinicky významná a trvalá remisia, od tých, ktorí potrebujú ďalšiu eskaláciu.</li>
</ol>

<h2>Hlavné zistenia podľa diagnózy</h2>

<h3>1) IgA nefropatia (IgAN)</h3>

<p>Pri IgA nefropatii podľa správy konferencie <strong>anti-CD20</strong> terapia (rituximab) vykazuje <strong>obmedzenú účinnosť</strong>. Naopak, lepší signál prinášajú zásahy do dráh prežívania B buniek, najmä inhibícia <strong>BAFF (B cell activating factor)</strong> a <strong>APRIL (a proliferation-inducing ligand)</strong>, prípadne prístupy cielené na plazmatické bunky.</p>

<p>Praktický význam má aj poznatok, že pri terapiách zameraných na prežívanie B buniek existuje potenciál návratu aktivujúcich mechanizmov po ukončení liečby. Preto sa v správe opakovane vracia otázka, či pri vybraných fenotypoch treba udržiavať účinnejšiu supresiu dlhšie.</p>

<p>Z pohľadu klinických cieľov konferencia naznačuje, že ak sa dosiahne optimálna rýchlosť poklesu eGFR, ďalšia kombinácia alebo eskalácia nemusí byť automaticky potrebná. Naopak, pri pretrvávajúcom zhoršovaní môže byť na mieste ďalší diagnostický a terapeutický krok.</p>

<h3>2) Membranózna nefropatia (MN)</h3>

<p>Pri membranóznej nefropatii sa anti-CD20 protilátky posunuli do <strong>prvej línie liečby</strong>. Správa zdôrazňuje, že <strong>samotná anti-CD20 monoterapia</strong> v mnohých prípadoch umožní aspoň <strong>čiastočnú remisiu do približne 18 mesiacov</strong>.</p>

<p>Konferencia zároveň diskutuje o rozdieloch medzi jednotlivými anti-CD20 molekulami. Obinutuzumab, opísaný ako účinnejší anti-CD20 protilátkový režim než rituximab, sa využíva najmä pri refraktérnych prípadoch, pričom zostáva otvorené, či má jasnú výhodu z hľadiska rýchlosti, úplnosti a trvania odpovede.</p>

<h3>3) Steroid-dependentný nefrotický syndróm</h3>

<p>Pri steroid-dependentnom nefrotickom syndróme rituximab podľa správy <strong>účinne predchádza relapsom</strong>, pričom prínos sa uvádza najmä u detí. Zároveň sa zdôrazňuje, že prínosy môžu byť <strong>prechodné</strong>.</p>

<h3>4) Lupusová nefritída (LN)</h3>

<p>Pri lupusovej nefritíde konferencia konštatuje, že „novšie“ prístupy prinášajú sľubnejšie výsledky než skoršie anti-CD20 prístupy.</p>

<p>V správe sa uvádza:</p>

<ul>
  <li><strong>obinutuzumab</strong> ako intenzívnejší anti-CD20 režim,</li>
  <li>a najmä <strong>terapia CAR T bunkami</strong>, ktorá zavádza koncept dlhšej remisie, prípadne obdobia bez aktivity ochorenia.</li>
</ul>

<p>Konferencia zároveň poukazuje na to, že interpretácia tohto stavu je sporná, keďže „vyliečenie“ môže byť niekedy príliš silné tvrdenie a vyžaduje presné definovanie podľa merateľných imunologických a klinických kritérií.</p>

<h3>5) ANCA-asociovaná vaskulitída (AAV)</h3>

<p>Pri AAV správa uvádza, že rituximab má overenú účinnosť pri <strong>indukčnej aj udržiavacej</strong> liečbe. Zároveň sa v oblasti pokročilých terapií uvádzajú prebiehajúce klinické skúšania prístupov s CAR T bunkami.</p>

<h2>Bezpečnosť: rozdielna „cena“ podľa intenzity liečby</h2>

<p>Z konferencie zaznieva jasné praktické posolstvo: bezpečnostný profil terapií cielených na B bunky nie je jednotný.</p>

<ul>
  <li><strong>Konvenčné anti-CD20</strong> režimy sa opisujú ako režimy s <strong>priaznivejším bezpečnostným profilom</strong>.</li>
  <li><strong>Terapie CAR T bunkami</strong> vyžadujú <strong>opatrný výber pacientov</strong>, pretože nesú riziko závažných nežiaducich udalostí vrátane <strong>syndrómu uvoľnenia cytokínov</strong> (cytokine release syndrome, CRS).</li>
</ul>

<p>To má priame dôsledky pre prax: pri zvažovaní pokročilých terapií nestačí samotná účinnosť. Musí byť jasné, pre koho je prínos realistický a aké monitorovanie a podporné opatrenia sú dostupné.</p>

<h2>Čo je podľa konferencie najväčšia výskumná medzera</h2>

<p>Správa konferencie formuluje viacero konkrétnych výskumných potrieb. Ako najdôležitejšie sa opakovane objavujú:</p>

<ul>
  <li><strong>Validácia biomarkerov</strong>, ktoré pomôžu predpovedať odpoveď a umožnia neinvazívne sledovanie.</li>
  <li><strong>Objektívne merania</strong> na identifikáciu pacientov, u ktorých má eskalácia smerom k hlbšej B bunkovej modulácii alebo deplécii včas zmysel, a pacientov, ktorí už dosiahli stav podobný „imunitnému resetu“.</li>
  <li><strong>„Tekutá“ biopsia obličky</strong> (liquid kidney biopsy) ako spôsob hodnotenia odpovede bez nutnosti odberu tkaniva.</li>
  <li>Opakované biopsie a nové diagnostické techniky na identifikáciu okamihu, keď zápal v obličke stráca reverzibilitu a prechádza do fibrózy, a následne zhodnotenie, ako B bunková deplécia ovplyvňuje profibrotické dráhy.</li>
  <li>Zohľadnenie genetických predispozícií a dejov, ktoré sú riadené inými dráhami, napríklad interferónovou dráhou pri niektorých prejavoch SLE.</li>
  <li>Špecifické zhodnotenie odpovedí pri rôznych klinických formách AAV, napríklad pri vaskulitických verzus granulomatóznych prejavoch.</li>
</ul>

<h2>Klinické zhrnutie pre nefrológa</h2>

<p>Z praktického hľadiska konferencia neponúka „jedno univerzálne pravidlo“, ale skôr rámec, ktorý sa dá použiť pri rozhodovaní:</p>

<ul>
  <li>Pri niektorých diagnózach prevažuje snaha zasiahnuť <strong>prežívanie a aktivitu B buniek alebo plazmatických buniek</strong> (napríklad pri IgA nefropatii), pričom samotná deplécia pomocou anti-CD20 nemusí stačiť.</li>
  <li>Pri iných diagnózach (napríklad pri membranóznej nefropatii) predstavuje anti-CD20 terapia už v súčasnosti <strong>pevný klinický základ</strong>.</li>
  <li>Pri lupusovej nefritíde sa otvára priestor pre intenzívnejšie zásahy vrátane prístupov s CAR T bunkami, no to súčasne zvyšuje nároky na bezpečnosť a výber pacienta.</li>
</ul>

<p>Ak sa tieto princípy prenesú do praxe, rozhodovanie sa musí opierať o diagnózu, fenotyp, očakávanú biológiu odpovede a dostupné bezpečnostné kapacity.</p>

<h2>Záver</h2>

<p>Konferencia KDIGO Controversies ukazuje, že cielenie na B bunky je už dnes súbor diferencovaných stratégií, nie jedna terapeutická myšlienka. Účinnosť aj bezpečnosť závisia od konkrétneho ochorenia a od toho, ako hlboko a akým mechanizmom sa B bunková os modifikuje.</p>

<p>Najbližší krok smerom k lepšej praxi bude podľa správy postavený na troch pilieroch: biomarkerová stratifikácia; objektívne merania odpovede a načasovanie eskalácie; a bezpečná implementácia pokročilých bunkových terapií s prísnym výberom pacientov.</p>

<p><em><strong>Poznámka k zodpovednosti:</strong> Text je odborným zhrnutím konferenčnej správy a dostupných informácií z uvedených zdrojov. Nejde o individuálne medicínske odporúčanie.</em></p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li>Floege J, Ayoub I, Brix SR, Campbell KN, Furie R, Nachman PH, Tang SCW, Tomas NM, Vivarelli M, Cheung M, King JM, Grams ME, Jadoul M, Rovin BH; for Conference Participants. Targeting B cells in immune-mediated kidney diseases: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney International</em>. 2026 (open access). <a href="https://doi.org/10.1016/j.kint.2026.02.029" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2026.02.029</a>.</li>
  <li>KDIGO. KDIGO Controversies Conference: B-Cell (Therapies Targeting B Cells in Immune-Mediated Kidney Diseases). <a href="https://kdigo.org/conferences/b-cell/" target="_blank" rel="noopener noreferrer">kdigo.org/conferences/b-cell</a>.</li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše existujúci článok (regenerácia).
// Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
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
