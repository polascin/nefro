<?php
/**
 * add_lubovnik-bodkovany-depresia-interakcie-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): ľubovník bodkovaný pri
 * depresii, interakcie a praktický nefrologický pohľad.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_lubovnik-bodkovany-depresia-interakcie-nefrologia_article.php"
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
    'title'        => 'Ľubovník bodkovaný pri depresii: kedy o ňom uvažovať a kedy v nefrológii radšej nie',
    'slug'         => 'lubovnik-bodkovany-depresia-interakcie-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ľubovník bodkovaný môže mať miesto pri miernej až stredne ťažkej depresii, ale len pri štandardizovanom prípravku a po dôslednej kontrole interakcií. V nefrológii je kritický najmä transplantovaný pacient, polyfarmácia a kombinácia so serotonergnými liekmi.',
    'content'      => <<<'HTML'
<p>Ľubovník bodkovaný (<em>Hypericum perforatum</em>, St. John’s wort) sa v ambulancii často objaví nenápadne: pacient ho uvedie ako „čaj na nervy“, „prírodné antidepresívum“ alebo doplnok, ktorý „nemôže škodiť“. Práve toto je problém. Pri ľubovníku nie je najväčším rizikom samotná bylinková povesť, ale to, že ide o biologicky aktívnu látku s klinicky významnými liekovými interakciami.</p>

<p>Medscape v aktuálnom prehľade zdôrazňuje dve paralelné skutočnosti: pri vhodne vybraných dospelých s miernou až stredne ťažkou depresiou môže mať štandardizovaný prípravok racionálne miesto, no rozhodujúce je, aby nešlo o neštandardizovaný doplnok s nejasným obsahom účinných látok. V nefrologickej praxi sa k tomu pridáva tretia podmienka: pred akýmkoľvek odporúčaním musí prebehnúť poctivá revízia medikácie.</p>

<h2>Kde môže mať ľubovník miesto</h2>

<p>Najrozumnejší priestor na úvahu je dospelý pacient s jasne rozpoznanou miernou až stredne ťažkou depresívnou symptomatológiou, bez suicidálneho rizika, psychotických príznakov alebo podozrenia na bipolárnu poruchu. Aj vtedy však nejde o „univerzálne prírodné antidepresívum“, ale o možnosť, ktorú treba zasadiť do diagnostického a liekového kontextu.</p>

<p>Dôkazy pre účinnosť sú nerovnomerné. Niektoré metaanalýzy a klinické skúšania podporujú účinok štandardizovaných extraktov pri miernej až stredne ťažkej depresii a naznačujú tolerabilitu porovnateľnú alebo priaznivejšiu než pri niektorých konvenčných antidepresívach. Iné štúdie však nepreukázali presvedčivý rozdiel oproti placebu. Praktický záver preto znie: ak sa o ľubovníku uvažuje, nemá nahrádzať psychiatrické zhodnotenie pri závažnejšom stave ani odkladať štandardnú liečbu.</p>

<h2>Nie je jedno, aký prípravok pacient užíva</h2>

<p>Veľká časť pozitívnych dát sa týka štandardizovaných extraktov. To nie je detail, ale jadro problému. Obsah hyperforínu, hypericínu a ďalších zložiek sa môže medzi prípravkami výrazne líšiť. Čaj, olej alebo voľnopredajný doplnok s nejasným zložením preto nemožno automaticky považovať za ekvivalent liekovo regulovaného štandardizovaného prípravku.</p>

<p>Z klinického hľadiska to má dve následky:</p>

<ul>
  <li>účinnosť nemožno bezpečne prenášať z jednej formy prípravku na inú,</li>
  <li>interakčný potenciál môže byť nepredvídateľný, najmä pri prípravkoch s vyšším alebo nejasným obsahom hyperforínu.</li>
</ul>

<h2>Mechanizmus účinku a mechanizmus rizika</h2>

<p>Za antidepresívnym účinkom sa najčastejšie spomína hyperforín, ktorý môže ovplyvňovať monoamínové systémy vrátane serotonínu, noradrenalínu a dopamínu. Diskutujú sa aj ďalšie mechanizmy, napríklad vplyv na TRPC6 kanály, no pre ambulantnú prax je dôležitejší druhý mechanizmus: ľubovník indukuje liekové transportéry a metabolické enzýmy, najmä CYP3A4 a P-glykoproteín.</p>

<p>Výsledkom môže byť pokles koncentrácie liekov, pri ktorých je stabilná expozícia rozhodujúca. Pri niektorých kombináciách to znamená „len“ slabší účinok, pri iných reálne riziko zlyhania liečby, akútnej rejekcie alebo neplánovaného tehotenstva.</p>

<h2>Kedy ľubovník radšej neodporúčať</h2>

<p>Ľubovník nie je vhodná voľba, ak je potrebné štandardné psychiatrické vedenie alebo rýchla intervencia. V praxi by som ho nepovažoval za vhodnú možnosť najmä pri týchto situáciách:</p>

<ul>
  <li>ťažká depresia, akútna suicidálna ideácia alebo sebapoškodzovanie,</li>
  <li>psychotické príznaky, mánia alebo podozrenie na bipolárnu poruchu,</li>
  <li>nejasná diagnóza alebo rýchlo sa zhoršujúci stav,</li>
  <li>tehotenstvo, dojčenie alebo pediatrická populácia bez špecializovaného vedenia,</li>
  <li>súbežné užívanie antidepresív alebo iných serotonergných liekov bez jasného odborného plánu,</li>
  <li>transplantácia orgánu alebo liečba imunosupresívami s úzkym terapeutickým oknom.</li>
</ul>

<h2>Najväčší nefrologický problém: interakcie</h2>

<p>Pri CKD samotnej nie je hlavná otázka „renálna dávka ľubovníka“, ale interakčný profil. Pacienti s chronickým ochorením obličiek majú často polyfarmáciu, vyššie kardiovaskulárne riziko, antikoagulačnú liečbu, analgetiká, antidepresíva a po transplantácii aj imunosupresíva. Preto je ľubovník v nefrológii prakticky vždy signál na kontrolu celého liekového zoznamu.</p>

<h3>Transplantovaný pacient</h3>

<p>Najdôležitejšia červená vlajka je transplantácia. Ľubovník môže znižovať koncentrácie cyklosporínu a takrolimu; opísané boli aj prípady akútnej rejekcie. Rovnaký princíp opatrnosti treba uplatniť pri ďalších úzko terapeutických imunosupresívach závislých od CYP3A4 alebo P-glykoproteínu.</p>

<p>Dôležité je myslieť aj na opačný smer: po vysadení ľubovníka sa indukčný účinok postupne vytráca a hladiny dotknutých liekov môžu stúpať. Pri takrolime, cyklosporíne alebo podobne citlivých liekoch preto nestačí len povedať „vysaďte to“; treba koordinovať terapeutické monitorovanie hladín.</p>

<h3>Hormonálna antikoncepcia</h3>

<p>Ľubovník môže znižovať expozíciu steroidným hormónom. Klinicky sa to môže prejaviť intermenštruačným krvácaním a zlyhaním antikoncepcie. U pacientky vo fertilnom veku preto treba aktívne položiť otázku na hormonálnu antikoncepciu, pretože pacientka ju nemusí spontánne zaradiť medzi „lieky“.</p>

<h3>Serotonergné kombinácie</h3>

<p>Ľubovník sa nemá bez jasného odborného vedenia kombinovať s liekmi, ktoré zvyšujú serotonergnú aktivitu. Prakticky ide najmä o SSRI, SNRI, MAOI, niektoré tricyklické antidepresíva, triptány, tramadol, linezolid, dextrometorfán a ďalšie serotonergné látky. Rizikom je serotonínový syndróm, ktorý môže začať agitovanosťou, hnačkou, tachykardiou, hypertenziou, tremorom, hypertermiou alebo poruchou vedomia.</p>

<h3>Antikoagulanciá, antivirotiká, onkologická liečba a ďalšie lieky</h3>

<p>Osobitnú opatrnosť vyžadujú warfarín, priame perorálne antikoagulanciá závislé od P-glykoproteínu alebo CYP3A4, digoxín, niektoré statíny, antiepileptiká, antiretrovirotiká a viaceré onkologické lieky. Pri polyfarmácii nie je bezpečné kontrolovať len „najpravdepodobnejšiu“ interakciu; rozumný postup je systematická lieková revízia vrátane doplnkov výživy a čajov.</p>

<h2>Nežiaduce účinky</h2>

<p>Štandardizované prípravky bývajú v štúdiách často dobre tolerované, ale nežiaduce účinky existujú. Najčastejšie sa uvádzajú gastrointestinálne ťažkosti, nauzea, sucho v ústach, únava alebo ospalosť, nepokoj, bolesť hlavy, závraty a kožné reakcie. Fotosenzitivita sa pri bežných antidepresívnych dávkach javí ako menej častá, no nemožno ju ignorovať, najmä pri svetlom fototype, vyšších dávkach, kombinácii s fotosenzibilizujúcimi liekmi alebo výraznej expozícii slnku.</p>

<h2>Praktický checklist pre nefrologickú ambulanciu</h2>

<ol>
  <li><strong>Pýtajme sa aktívne.</strong> Pacient často neoznámi ľubovník ako liek. Pomáha formulácia: „Užívate aj bylinky, čaje, doplnky alebo prírodné prípravky na náladu a spánok?“</li>
  <li><strong>Zapíšme presný prípravok.</strong> Názov, forma, dávka, frekvencia, dátum začatia a dôvod užívania sú klinicky relevantné údaje.</li>
  <li><strong>Skontrolujme rizikové lieky.</strong> Imunosupresíva, antikoagulanciá, antidepresíva, analgetiká so serotonergným účinkom, hormonálna antikoncepcia, antiepileptiká, digoxín, antivirotiká a onkologická liečba majú prednosť.</li>
  <li><strong>Pri transplantácii konajme promptne a koordinovane.</strong> Kontakt s transplantačným centrom alebo lekárom zodpovedným za imunosupresiu je vhodnejší než izolované ambulantné odporúčanie.</li>
  <li><strong>Pri depresii zhodnoťme závažnosť.</strong> Suicidálne myšlienky, psychóza, mánia alebo nejasná diagnóza sú dôvodom na štandardné psychiatrické riešenie, nie na skúšanie doplnku.</li>
  <li><strong>Ak sa o ľubovníku uvažuje, iba po kontrole interakcií.</strong> Vhodný je len štandardizovaný prípravok a jasný plán sledovania účinku, tolerancie a bezpečnosti.</li>
</ol>

<h2>Zhrnutie</h2>

<p>Ľubovník bodkovaný môže byť u vybraných dospelých s miernou až stredne ťažkou depresiou racionálnou možnosťou, ak ide o štandardizovaný prípravok a ak sa neprehliadnu kontraindikácie. V nefrológii je však jeho použitie bezpečné iba vtedy, keď sa najprv urobí dôsledná kontrola interakcií. Transplantovaný pacient, pacient na antikoagulácii, pacient s hormonálnou antikoncepciou alebo pacient užívajúci serotonergné lieky nie je priestor na improvizáciu.</p>

<p>Praktická veta pre ambulanciu znie: ľubovník nie je „neškodná bylinka“, ale liekovo aktívny prípravok, ktorý môže znížiť účinnosť kriticky dôležitej liečby.</p>

<hr>

<p><em><strong>Zdroj:</strong> <em>Medscape</em>, „When Should St. John’s Wort Be Considered for Depression?“ (2026). <a href="https://www.medscape.com/viewarticle/when-should-st-johns-wort-be-considered-depression-2026a1000mjd" target="_blank" rel="noopener noreferrer">Link na zdroj</a>. Odborná kontrola bola doplnená podľa prehľadov <a href="https://www.nccih.nih.gov/health/st-johns-wort-and-depression-in-depth" target="_blank" rel="noopener noreferrer">NCCIH</a> a <a href="https://www.mskcc.org/cancer-care/integrative-medicine/herbs/st-john-wort" target="_blank" rel="noopener noreferrer">Memorial Sloan Kettering Cancer Center</a> o účinnosti, bezpečnosti a liekových interakciách ľubovníka.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_lubovnik newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_lubovnik pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_lubovnik pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_lubovnik migration error: ' . $e->getMessage());
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
