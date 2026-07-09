<?php
/**
 * add_swam-technika-tromboza-hemodialyzacneho-pristupu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): SWAM technika pri trombóze
 * hemodialyzačného prístupu a praktické súvislosti pre nefrologickú prax.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_swam-technika-tromboza-hemodialyzacneho-pristupu_article.php"
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
    'title'        => 'SWAM technika pri trombóze hemodialyzačného prístupu: nová možnosť mechanickej trombektómie',
    'slug'         => 'swam-technika-tromboza-hemodialyzacneho-pristupu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'SWAM kombinuje veľkolúmenovú aspiráciu so separátorom trombu pri trombóze AV fistúl, graftov a katétrov. Sľubná technika, zatiaľ však nie univerzálny štandard.',
    'content'      => <<<'HTML'
<p>Trombóza cievneho prístupu patrí medzi najčastejšie a klinicky najzávažnejšie príčiny zlyhania hemodialyzačného prístupu. Pre pacienta znamená okamžité riziko prerušenia dialyzačnej liečby, potrebu urgentného riešenia, zavedenie dočasného alebo tunelizovaného centrálneho venózneho katétra a vyššie riziko infekčných, trombotických aj hospitalizačných komplikácií.</p>

<p>Článok publikovaný v časopise <em>Hemodialysis International</em> predstavuje techniku <strong>SWAM</strong>, teda <strong>Separator With Aspirator for Mechanical Thrombectomy</strong>, ako novú endovaskulárnu možnosť mechanickej trombektómie hemodialyzačných prístupov. Ide o technický opis a prvé klinické skúsenosti s použitím veľkolúmenového aspiračného katétra v kombinácii so separátorom, ktorý mechanicky narúša intraluminálny trombus a pomáha udržať priechodnosť aspiračného systému.</p>

<h2>Prečo je trombóza prístupu zásadný problém</h2>

<p>Funkčný cievny prístup je pre pacienta v chronickej hemodialýze prakticky životne dôležitý. Trombóza arteriovenóznej fistuly, arteriovenózneho graftu alebo centrálneho venózneho katétra vedie k okamžitej strate použiteľnosti prístupu. Klinicky sa môže prejaviť stratou víru a šelestu nad fistulou, nemožnosťou kanylácie, zníženým prietokom, vysokými venóznymi tlakmi počas dialýzy alebo úplným zlyhaním dialyzačnej procedúry.</p>

<p>Najčastejším podkladom trombózy býva stenóza vo venóznom odtokovom segmente, v oblasti anastomózy, v graftovom segmente alebo v centrálnom venóznom riečisku. Samotné odstránenie trombu preto nestačí, ak sa súčasne neidentifikuje a nerieši hemodynamicky významná stenóza. Úspešná liečba musí obnoviť priechodnosť prístupu a zároveň odstrániť alebo aspoň zmierniť príčinu, ktorá k trombóze viedla.</p>

<h2>Chirurgické a endovaskulárne možnosti</h2>

<p>Trombózu dialyzačného prístupu možno riešiť chirurgicky alebo endovaskulárne. Chirurgická trombektómia má stále svoje miesto, najmä pri anatomicky nevhodných léziách, pri niektorých typoch prístupov, pri opakovanom zlyhaní endovaskulárneho postupu alebo tam, kde je potrebná súčasná chirurgická revízia.</p>

<p>Endovaskulárne riešenia sa však v praxi používajú čoraz častejšie. Ich výhodou je minimálna invazivita, možnosť okamžitej angiografickej diagnostiky stenózy, kombinácia trombektómie s angioplastikou a často aj rýchly návrat prístupu do používania. Práve do tejto skupiny postupov patrí aj technika SWAM.</p>

<h2>Čo je SWAM technika</h2>

<p>SWAM je skratka pre <strong>Separator With Aspirator for Mechanical Thrombectomy</strong>. Podstatou metódy je kombinácia dvoch mechanizmov:</p>

<ol>
  <li><strong>veľkolúmenového aspiračného katétra</strong>, ktorý vytvára negatívny tlak a odstraňuje trombotický materiál,</li>
  <li><strong>separátora</strong>, ktorý mechanicky rozrušuje intraluminálny trombus a pomáha predchádzať upchatiu katétra počas aspirácie.</li>
</ol>

<p>Autori opisujú použitie tejto techniky pri trombóze arteriovenóznej fistuly, arteriovenózneho graftu aj centrálneho venózneho katétra. Cieľom je zvýšiť efektivitu odstránenia trombotického materiálu, skrátiť procedurálny čas a obnoviť funkčnosť prístupu.</p>

<p>Technika je koncepčne zaujímavá tým, že trombus nerieši iba pasívnou aspiráciou. Separátor ho mechanicky uvoľňuje alebo fragmentuje, čím umožňuje jeho účinnejšie nasatie cez katéter. Súčasne môže udržiavať priechodnosť aspiračného systému, čo je prakticky významné najmä pri objemnejšom alebo organizovanejšom trombe.</p>

<h2>Akútna a chronická trombóza</h2>

<p>Podľa publikovaných skúseností dosiahla SWAM technika priaznivý efekt najmä pri <strong>akútnom trombe</strong>. To je klinicky logické: čerstvý trombus býva mäkší, menej organizovaný a lepšie odstrániteľný aspiráciou alebo mechanickou fragmentáciou.</p>

<p>Pri <strong>chronickom trombe</strong> bol efekt prítomný len do určitej miery. Táto formulácia je dôležitá. Chronický trombus býva pevnejší, adherentnejší a často spojený s výraznejšou stenózou, fibrotickou prestavbou alebo dlhšie trvajúcou dysfunkciou prístupu. V takýchto situáciách môže byť potrebná kombinácia viacerých techník, opakované intervencie alebo chirurgické riešenie.</p>

<p>Z praktického hľadiska to potvrdzuje, že čas je pri trombóze dialyzačného prístupu rozhodujúci. Čím skôr sa trombóza diagnostikuje a rieši, tým vyššia je šanca na úspešnú rekanalizáciu a zachovanie prístupu.</p>

<h2>Význam pre arteriovenóznu fistulu</h2>

<p>Arteriovenózna fistula je preferovaný dlhodobý prístup na hemodialýzu, ale jej trombóza môže byť technicky náročná. Pri natívnej fistule je dôležité šetrné zaobchádzanie so stenotickými a aneuryzmatickými segmentmi, zachovanie použiteľnej kanylačnej zóny a minimalizácia poškodenia cievnej steny.</p>

<p>SWAM technika môže byť zaujímavá najmä tam, kde je potrebné odstrániť intraluminálny trombus bez nadmernej traumatizácie prístupu. Napriek tomu treba zdôrazniť, že úspech závisí od anatómie fistuly, lokalizácie trombu, prítomnosti stenózy, veku trombu a skúsenosti intervenčného pracoviska.</p>

<h2>Význam pre arteriovenózny graft</h2>

<p>Arteriovenózne grafty majú vyššie riziko trombózy než natívne fistuly. Často ide o trombózu na podklade stenózy venóznej anastomózy alebo výtokového segmentu. Pri grafte je mechanická trombektómia bežnou súčasťou endovaskulárneho manažmentu.</p>

<p>V tejto oblasti môže SWAM priniesť praktický benefit, ak skracuje výkon a zvyšuje účinnosť odstránenia trombu. Pri graftoch je však rovnako nevyhnutné následne riešiť stenózu, najčastejšie balónikovou angioplastikou, prípadne ďalším endovaskulárnym postupom podľa lokálneho nálezu.</p>

<h2>Význam pri centrálnych venóznych katétroch</h2>

<p>Autori uvádzajú aj použitie pri centrálnych venóznych katétroch. Trombóza alebo trombotická dysfunkcia katétra je častým problémom u dialyzovaných pacientov, najmä ak je katéter používaný dlhodobo. Klinicky sa prejavuje nedostatočnými prietokmi, opakovanými alarmami počas dialýzy, nutnosťou reverzného napojenia ramien alebo nemožnosťou dosiahnuť adekvátnu dialyzačnú dávku.</p>

<p>Pri katétroch je však potrebné odlíšiť intraluminálnu trombózu, fibrínový obal, malpozíciu katétra, centrálnu venóznu stenózu a infekčné komplikácie. Mechanická trombektómia môže byť užitočná len vo vybraných situáciách. Pri podozrení na infekciu katétra nemožno problém redukovať na mechanickú obštrukciu.</p>

<h2>Praktické nefrologické súvislosti</h2>

<p>Pre nefrológa je najdôležitejšie včas rozpoznať dysfunkciu prístupu. Trombóze často predchádzajú varovné príznaky: zhoršené prietoky, vyššie venózne tlaky, predlžujúce sa krvácanie po vytiahnutí ihiel, zmeny pulzácie alebo oslabenie víru. Tieto signály by nemali byť bagatelizované.</p>

<p>Pri podozrení na trombózu alebo významnú stenózu je vhodné urýchlene zabezpečiť ultrazvukové alebo intervenčné vyšetrenie. Každé zdržanie môže znižovať šancu na záchranu prístupu. Ak sa prístup nepodarí obnoviť, pacient často končí so zavedením dočasného alebo tunelizovaného centrálneho venózneho katétra, čo zvyšuje riziko infekcie, centrálnej venóznej stenózy a ďalších komplikácií.</p>

<p>SWAM technika preto nie je iba technickým detailom intervenčnej rádiológie, angiológie alebo cievnej chirurgie. Ak sa jej účinnosť a bezpečnosť potvrdia vo väčších súboroch, môže mať priamy vplyv na zachovanie dialyzačného prístupu, kontinuitu liečby a kvalitu života pacienta.</p>

<h2>Silné stránky opísanej techniky</h2>

<p>Hlavnou prednosťou SWAM techniky je mechanicky jednoduchý koncept. Kombinuje aspiráciu veľkolúmenovým katétrom s aktívnym narušovaním trombu. To môže byť výhodné pri objemnejšom trombotickom materiáli, pri riziku upchávania katétra a pri potrebe rýchleho obnovenia prietoku.</p>

<p>Ďalším potenciálnym prínosom je skrátenie procedurálneho času. Kratší výkon môže znamenať nižšiu záťaž pre pacienta, menšiu spotrebu kontrastnej látky, nižšiu radiačnú záťaž a efektívnejšie využitie intervenčného pracoviska. Tieto prínosy však treba potvrdiť v porovnávacích štúdiách.</p>

<h2>Limity publikovaného zdroja</h2>

<p>Publikovaný článok opisuje novú techniku a skúsenosti s jej použitím, nejde však o veľkú randomizovanú klinickú štúdiu. Z dostupných údajov preto nemožno vyvodiť definitívne závery o nadradenosti SWAM techniky nad inými metódami trombektómie.</p>

<p>Nie sú k dispozícii dostatočné údaje o dlhodobej primárnej a sekundárnej priechodnosti prístupov, miere reintervencií, komplikáciách, nákladoch, porovnaní s existujúcimi mechanickými alebo farmakomechanickými technikami a výsledkoch v rôznych typoch prístupov. Rovnako nie je jasné, do akej miery možno výsledky preniesť na pracoviská s odlišným technickým vybavením a skúsenosťami.</p>

<p>Pre klinickú prax je preto rozumné chápať SWAM ako sľubnú technickú možnosť, nie ako nový univerzálny štandard.</p>

<h2>Čo by mali ukázať ďalšie štúdie</h2>

<p>Na objektívne posúdenie prínosu SWAM techniky budú potrebné väčšie prospektívne štúdie. Mali by hodnotiť najmä:</p>

<ul>
  <li>technickú úspešnosť rekanalizácie,</li>
  <li>klinickú úspešnosť s možnosťou opätovného použitia prístupu na dialýzu,</li>
  <li>30-dňovú, 3-mesačnú, 6-mesačnú a 12-mesačnú priechodnosť,</li>
  <li>potrebu opakovaných intervencií,</li>
  <li>výskyt embolických, krvácavých a infekčných komplikácií,</li>
  <li>rozdiely medzi fistulami, graftmi a katétrami,</li>
  <li>nákladovú efektivitu v porovnaní s inými metódami.</li>
</ul>

<p>Až takéto údaje umožnia určiť, či SWAM technika bude mať miesto len v špecifických prípadoch, alebo sa môže stať širšie používanou metódou pri záchrane trombotizovaných hemodialyzačných prístupov.</p>

<h2>Záver</h2>

<p>SWAM technika predstavuje nový endovaskulárny prístup k mechanickej trombektómii hemodialyzačných prístupov. Kombinácia veľkolúmenovej aspirácie a mechanického separátora trombu môže zlepšiť efektivitu odstránenia trombotického materiálu a skrátiť trvanie výkonu. Podľa publikovaných skúseností sa javí najúčinnejšia pri akútnom trombe, s určitým prínosom aj pri chronickejšom trombotickom materiáli.</p>

<p>Pre nefrologickú prax je hlavné posolstvo jasné: trombóza dialyzačného prístupu si vyžaduje rýchlu diagnostiku, včasnú intervenciu a úzku spoluprácu nefrológa, intervenčného rádiológa, angiologického pracoviska a cievneho chirurga. SWAM môže byť ďalším nástrojom na záchranu prístupu, jeho definitívne miesto však musia potvrdiť väčšie a metodicky silnejšie štúdie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Li L, Zhang Z, Wang H, Zhu M, Wang K, Liu Z. Utility of the SWAM (Separator With Aspirator for Mechanical Thrombectomy) Device in Managing Hemodialysis Access Thrombosis. <em>Hemodialysis International</em>. Publikované online 5. júla 2026. DOI: <a href="https://doi.org/10.1111/hdi.70111" target="_blank" rel="noopener noreferrer">10.1111/hdi.70111</a>. PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/42402675/" target="_blank" rel="noopener noreferrer">42402675</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
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
