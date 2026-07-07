<?php
/**
 * add_meduza-hojenie-ran-bez-jaziev-regenerativna-medicina_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): Clytia hemisphaerica ako
 * jednoduchý model epitelového hojenia, úloha bazálnej membrány a opatrné
 * implikácie pre regeneratívnu medicínu a pacientov so zhoršeným hojením rán.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_meduza-hojenie-ran-bez-jaziev-regenerativna-medicina_article.php"
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
    'title'        => 'Medúza, ktorá hojí rany bez jaziev: čo môže jednoduchý model naučiť regeneratívnu medicínu',
    'slug'         => 'meduza-hojenie-ran-bez-jaziev-regenerativna-medicina',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia na Clytia hemisphaerica ukazuje, že bazálna membrána môže riadiť voľbu medzi lamelipódiami, aktomyozínovou kontrakciou a kolektívnou migráciou pri epitelovom hojení.',
    'content'      => <<<'HTML'
<p>Hojenie rán patrí k základným biologickým procesom mnohobunkových organizmov. U cicavcov je však mimoriadne vrstvené: do opravy tkaniva vstupuje hemostáza, zápalová a imunitná odpoveď, angiogenéza, fibroblasty, prestavba extracelulárnej matrix, riziko infekcie a napokon aj tvorba jazvy. Práve preto je ťažké rozlíšiť, ktoré mechanizmy sú pre epitelovú opravu základné a ktoré sú až súčasťou komplexnej cicavčej odpovede.</p>

<p>Nová štúdia publikovaná v časopise <em>Molecular Biology of the Cell</em> využila drobnú priehľadnú medúzu <em>Clytia hemisphaerica</em> ako model epitelového hojenia. Tento organizmus dokáže uzatvárať malé poranenia v priebehu minút a väčšie poranenia približne do jednej hodiny, bez krvácania, chrasty a fibrotickej jazvy typickej pre cicavčie tkanivá.</p>

<p>Pre biomedicínu je zaujímavé najmä to, že nejde o úplne exotický mechanizmus vzdialený človeku. Základné prvky pozorované pri hojení v <em>Clytia hemisphaerica</em> – lamelipódiá, aktomyozínový kontrakčný aparát, kolektívna migrácia buniek a úloha bazálnej membrány – patria k všeobecným mechanizmom epitelovej biológie. Hodnota modelu preto nespočíva v priamom návode na liečbu ľudských rán, ale v možnosti sledovať základnú bunkovú mechaniku bez prekrytia cievnou a zápalovou odpoveďou cicavcov.</p>

<h2>Prečo práve <em>Clytia hemisphaerica</em></h2>

<p><em>Clytia hemisphaerica</em> je drobný, priehľadný hydrozoán. Medúzové štádium má veľkosť malej mince a jednoduchá stavba povrchového epitelu umožňuje pozorovať živé bunky v reálnom čase. Pri poranení tak možno priamo sledovať, ako sa bunky na okraji defektu rozhodujú medzi plazením po podklade, kontrakciou okraja rany a zapojením širšieho bunkového listu.</p>

<p>Model má niekoľko zásadných výhod:</p>

<ul>
  <li>povrch tvorí jednoduchá vrstva veľkých epitelových buniek,</li>
  <li>organizmus nemá cievny systém, ktorý by prekrýval primárnu mechaniku uzáveru rany,</li>
  <li>chýba mu zápalová fáza porovnateľná s cicavčím hojením,</li>
  <li>oprava prebieha rýchlo a dá sa sledovať mikroskopicky,</li>
  <li>epitelové bunky a bazálna membrána sú funkčne porovnateľné s inými živočíšnymi systémami.</li>
</ul>

<p>Práve redukcia biologického „šumu“ je vedecky cenná. V ľudskej rane je zápal nevyhnutný na obranu pred infekciou a odstránenie poškodeného materiálu, ale zároveň výrazne ovplyvňuje fibrotickú prestavbu. V <em>Clytia</em> možno pozorovať epitelovú odpoveď v podobe, ktorá je jednoduchšia a mechanicky čitateľnejšia.</p>

<h2>Hojenie bez jazvy nie je zázračná regenerácia</h2>

<p>Zistenia z medúzy nemožno priamo preniesť na chirurgické, traumatické alebo chronické rany u človeka. Ľudská koža je viacvrstvová, vaskularizovaná, imunologicky aktívna a vystavená mikrobiálnej kontaminácii. Navyše, pevné uzavretie hlbšej rany si u cicavcov vyžaduje granulačné tkanivo, kolagénovú prestavbu a kontrakciu rany, čo prirodzene zvyšuje riziko jazvenia.</p>

<p>Význam štúdie je iný. <em>Clytia</em> ukazuje základný rozhodovací model epitelových buniek: kedy bunka využije lamelipódiá a plazí sa po odhalenej bazálnej membráne, kedy sa aktivuje aktomyozínový „sťahovací“ mechanizmus a kedy je potrebná koordinovaná migrácia celého bunkového listu.</p>

<p>Takýto model môže byť dôležitý pre výskum chronických rán, tkanivového inžinierstva, biomateriálov a regeneratívnej medicíny. Neposkytuje hotovú terapiu, ale spresňuje otázku: ako podporiť epitelovú obnovu a zároveň nevyvolať nadmernú fibrózu.</p>

<h2>Tri mechanizmy epitelového uzáveru</h2>

<p>Autori analyzovali hojenie naprieč rôznymi typmi a veľkosťami defektov. Výsledkom je zjednotený model, podľa ktorého sa tri mechanizmy kombinujú v predvídateľnom poradí a s významnou mierou redundancie.</p>

<h3>1. Lamelipodiálne plazenie buniek</h3>

<p>Pri menších ranách bunky na okraji defektu vytvárajú <strong>lamelipódiá</strong>. Ide o aktínom bohaté výbežky bunkovej membrány, ktoré sa správajú ako pohyblivé prieskumné štruktúry. Posúvajú sa po odhalenej bazálnej membráne a ťahajú za sebou bunkové telo.</p>

<p>Takto sa epitelové bunky dokážu rýchlo presunúť cez poranenú oblasť a prekryť defekt. Kým je bazálna membrána dostupná, lamelipódiá majú po čom migrovať a mechanizmus plazenia dominuje.</p>

<h3>2. Aktomyozínová kontrakcia</h3>

<p>Druhým mechanizmom je vytvorenie <strong>aktomyozínového kábla</strong> na okraji rany. Tento kábel sa po aktivácii stiahne podobne ako sťahovacia šnúrka. V anglickej literatúre sa pre tento jav často používa označenie <em>purse-string mechanism</em>.</p>

<p>Kontrakcia pomáha pritiahnuť okraje rany k sebe. Zároveň môže preklenúť miesta, kde je bazálna membrána poškodená alebo prekrytá bunkovým detritom, a napomáhať vytlačeniu poškodeného materiálu z defektu.</p>

<h3>3. Kolektívna migrácia epitelového listu</h3>

<p>Ak je rana príliš veľká na to, aby ju preklenuli samotné okrajové bunky, aktivuje sa širší proces. Do pohybu sa zapája celý epitelový list: bunky na okraji aj bunky za nimi koordinovane migrujú smerom do defektu.</p>

<p>Keď sa protiľahlé bunkové fronty stretnú, uzáver pokračuje rovnakým finálnym mechanizmom: lamelipódiá prekryjú dostupnú bazálnu membránu, následne ustúpia a aktivuje sa kontrakcia aktomyozínového kábla.</p>

<h2>Bazálna membrána ako rozhodovací signál</h2>

<p>Najdôležitejším nálezom štúdie je úloha <strong>bazálnej membrány</strong>. Bazálna membrána je špecializovaná bielkovinová vrstva pod epitelom. Poskytuje bunkám podklad, orientáciu a signály potrebné pre migráciu.</p>

<p>Autori ukázali, že dostupnosť bazálnej membrány významne rozhoduje o výbere mechanizmu hojenia. Ak je bazálna membrána odhalená a dostupná, bunky po nej vysúvajú lamelipódiá a postupujú do rany. Ak sa lamelipódiá stretnú alebo už nemajú ďalšiu voľnú bazálnu membránu, aktivuje sa kontrakcia aktomyozínového kábla. Ak je bazálna membrána poškodená alebo prekrytá detritom, lamelipódiá nemôžu pokračovať a kontrakčný mechanizmus pomáha defekt uzavrieť aj napriek poškodeniu podkladu.</p>

<p>Zjednodušene povedané: bazálna membrána nefunguje iba ako pasívna podložka. Je to informačné rozhranie, podľa ktorého bunka rozpoznáva, či má ďalej migrovať, zastaviť sa, kontrahovať alebo zapojiť širší kolektívny pohyb.</p>

<h2>Mikrorany v jednej bunke</h2>

<p>Mimoriadne zaujímavé bolo pozorovanie takzvaných mikrorán. Išlo o drobné defekty, ktoré prechádzali dokonca vnútrom jednej bunky. Takéto mikropoškodenia sa uzatvárali približne za <strong>3 až 5 minút</strong>.</p>

<p>Aj v tomto prípade sa objavili lamelipódiá a aktínové štruktúry. Bunky pritom dokázali rozlišovať medzi vlastnými výbežkami a výbežkami susedných buniek. Lamelipódiá pochádzajúce z tej istej bunky sa vedeli spojiť, zatiaľ čo výbežky zo susedných buniek zostávali oddelené a obnovovali bunkové hranice.</p>

<p>Pre bunkovú biológiu je to dôležitý poznatok. Naznačuje, že aj pri akútnej oprave poškodenia sa zachováva schopnosť rozlišovať „vlastné“ a „nevlastné“ bunkové rozhrania. Oprava teda nie je chaotické zalepenie defektu, ale koordinovaný proces s presnou priestorovou kontrolou.</p>

<h2>Prečo sa rana nezjazví</h2>

<p>Hojenie v <em>Clytia hemisphaerica</em> pripomína skôr embryonálne hojenie: je rýchle, čisto epitelové a bez fibrotickej jazvy. Dôvodom nie je jednoduchá „superschopnosť“, ale odlišný biologický kontext. Medúza nemá kapilárnu sieť, cicavčiu zápalovú fázu ani fibroblastmi sprostredkovanú kolagénovú prestavbu, ktorá pri ľudskom hlbokom poranení vytvára jazvové tkanivo.</p>

<p>Pre ľudskú medicínu je práve toto najväčšia výzva. Zápal nemožno jednoducho vypnúť, pretože je potrebný na kontrolu infekcie, odstránenie poškodeného materiálu a spustenie ďalších fáz hojenia. Zároveň však nadmerná alebo dlhodobá zápalová aktivácia prispieva k fibróze, poruche reepitelizácie a chronifikácii rán.</p>

<p>Budúce terapeutické stratégie preto pravdepodobne nebudú založené na napodobnení medúzy v doslovnom zmysle. Realistickejšia je presná modulácia zápalu, podpora reepitelizácie, obnova kvalitnej extracelulárnej matrix a vývoj biomateriálov, ktoré bunkám poskytnú signály podobné fyziologickej bazálnej membráne.</p>

<h2>Možný význam pre nefrológiu</h2>

<p>Táto práca neponúka okamžitý liek na jazvy ani na chronické rany. Ponúka však lepšie pochopenie základných pravidiel epitelovej opravy. To je nepriamo dôležité aj pre nefrológiu, najmä pri pacientoch s chronickou chorobou obličiek, diabetom a pokročilým vaskulárnym poškodením.</p>

<p>U týchto pacientov sa často stretávame so zhoršeným hojením rán, vyšším rizikom infekcií, malnutríciou, chronickým zápalom, poruchami mikrocirkulácie a dysreguláciou imunity. Pri dialyzovaných pacientoch sú klinicky významné aj problémy s hojením operačných rán, cievnych prístupov, defektov dolných končatín a kožných lézií.</p>

<p>Potenciálny význam základného výskumu epitelovej opravy môže byť v budúcnosti najmä v týchto oblastiach:</p>

<ul>
  <li>hojenie chronických rán a diabetických defektov,</li>
  <li>pooperačné hojenie u pacientov s vysokým rizikom komplikácií,</li>
  <li>popáleninová a rekonštrukčná medicína,</li>
  <li>vývoj biomateriálov napodobňujúcich bazálnu membránu,</li>
  <li>tkanivové inžinierstvo a regeneratívna medicína,</li>
  <li>výskum integrity epitelu v koži, čreve, slizniciach a orgánových modeloch.</li>
</ul>

<p>Pre klinika je dôležité zostať opatrný: cesta od jednoduchého modelu k liečbe človeka je dlhá. Napriek tomu môže byť práve takýto model užitočný, pretože odhaľuje elementárne pravidlá, ktoré sú v cicavčej rane zakryté komplexnosťou zápalu, ciev a jazvovej prestavby.</p>

<h2>Odborná opatrnosť pri interpretácii</h2>

<p>Popularizačný titulok o medúze, ktorá hojí rany bez jaziev, je atraktívny, ale treba ho čítať presne. <em>Clytia hemisphaerica</em> je výborný model na sledovanie základnej bunkovej mechaniky, nie priamy terapeutický návod na liečbu ľudských rán.</p>

<p>Rozdiely oproti človeku sú zásadné:</p>

<ul>
  <li>ľudská koža je viacvrstvová a vaskularizovaná,</li>
  <li>rany krvácajú a aktivujú koaguláciu,</li>
  <li>hojenie výrazne ovplyvňuje vrodená aj adaptívna imunita,</li>
  <li>infekcia je zásadné klinické riziko,</li>
  <li>fibroblasty a kolagénová prestavba sú nevyhnutnou súčasťou opravy hlbších rán,</li>
  <li>jazva je často cena za rýchle a mechanicky pevné uzavretie defektu.</li>
</ul>

<p>Bolo by preto nepresné tvrdiť, že výskum medúzy v krátkom čase odstráni jazvy u ľudí. Presnejšie je povedať, že ukazuje evolučne staré a konzervované mechanizmy epitelovej opravy, ktoré môžu pomôcť pochopiť, ako tkanivá rozhodujú medzi migráciou, kontrakciou a regeneráciou.</p>

<h2>Záver</h2>

<p><em>Clytia hemisphaerica</em> ukazuje, že epitelové tkanivo má elegantný a rýchly systém opravy poškodenia. Podľa dostupnosti bazálnej membrány bunky volia medzi lamelipodiálnym pohybom, aktomyozínovou kontrakciou a kolektívnou migráciou. Tento rozhodovací model umožňuje uzatvárať drobné aj väčšie poranenia rýchlo, koordinovane a bez fibrotického jazvenia.</p>

<p>Pre medicínu je najcennejšie pochopenie základných pravidiel. Ak sa podarí lepšie objasniť, ako epitelové bunky čítajú signály bazálnej membrány a ako koordinujú pohyb s kontrakciou, môže to v budúcnosti pomôcť pri vývoji nových prístupov k hojeniu rán, regenerácii tkanív a biomateriálom pre pacientov s vysokým rizikom porúch hojenia.</p>

<hr>

<p><em><strong>Zdroj:</strong> Malamy JE, Sassaman M, Mony MP. The basement membrane determines the choice of wound healing mechanism across wound scales in the basal eukaryote <em>Clytia hemisphaerica</em>. <em>Molecular Biology of the Cell</em>. 2026;37(7):ar60. doi:10.1091/mbc.E26-02-0094. <a href="https://doi.org/10.1091/mbc.E26-02-0094" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42126955/" target="_blank" rel="noopener noreferrer">PubMed PMID: 42126955</a>. Spracované aj podľa tlačovej správy MBL/EurekAlert a popularizačného textu ZME Science „This Jellyfish Can Heal Wounds in Minutes Without Scars and Scientists Think They’ve Found Its Secret“ (1. júla 2026): <a href="https://www.eurekalert.org/news-releases/1134284" target="_blank" rel="noopener noreferrer">EurekAlert</a>; <a href="https://www.zmescience.com/science/news-science/jellyfish-heals-wounds-without-scars/" target="_blank" rel="noopener noreferrer">ZME Science</a>.</em></p>
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
                error_log('add_meduza_hojenie newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_meduza_hojenie pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_meduza_hojenie pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_meduza_hojenie migration error: ' . $e->getMessage());
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
