<?php
/**
 * add_glp1-ischemicka-opticka-neuropatia-naion_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-ischemicka-opticka-neuropatia-naion_article.php"
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
    'title'        => 'GLP-1 lieky a ischemická optická neuropatia: signál, ktorý treba sledovať, nie panika',
    'slug'         => 'glp1-ischemicka-opticka-neuropatia-naion',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Diskutuje sa o možnej súvislosti medzi agonistami GLP-1 receptorov a neartériitickou prednou ischemickou optickou neuropatiou (NAION). Dostupné dáta sú observačné a nepreukazujú kauzalitu — namieste je informovaná ostražitosť, nie panika.',
    'content'      => <<<'HTML'
<p>Agonisty GLP-1 receptorov sa čoraz širšie používajú pri liečbe diabetu 2. typu a obezity. S rastúcim počtom pacientov sa prirodzene objavuje aj väčšia pozornosť voči zriedkavým nežiaducim účinkom. Jedným z diskutovaných bezpečnostných signálov je možná súvislosť medzi liekmi zo skupiny GLP-1 a neartériitickou prednou ischemickou optickou neuropatiou, známou ako NAION.</p>

<p>NAION je akútne ischemické poškodenie prednej časti zrakového nervu. Môže viesť k náhlej strate zraku, najčastejšie na jednom oku. Aktuálne dostupné údaje však nepreukazujú jasný kauzálny vzťah medzi GLP-1 liečbou a NAION. Ide najmä o observačné štúdie, farmakovigilančné dáta a kazuistiky.</p>

<p>Pre klinickú prax je dôležitý vyvážený postoj: pacienta netreba strašiť, ale náhle poruchy zraku treba brať vážne.</p>

<h2>Čo je NAION</h2>

<p>Neartériitická predná ischemická optická neuropatia je najčastejšou akútnou optickou neuropatiou u dospelých nad 50 rokov. Vzniká pri zhoršenom prekrvení prednej časti zrakového nervu, čo vedie k ischemickému poškodeniu.</p>

<p>Typický obraz je:</p>

<ul>
  <li>náhla, nebolestivá strata zraku,</li>
  <li>najčastejšie jednostranné postihnutie,</li>
  <li>rozmazané alebo stmavnuté videnie,</li>
  <li>výpadky zorného poľa,</li>
  <li>často zistené po prebudení.</li>
</ul>

<p>Pretože poškodenie zraku môže byť trvalé, každá náhla zmena videnia má byť považovaná za urgentný stav. Pacient nemá čakať, či sa stav „sám upraví“.</p>

<p>Výskyt NAION sa odhaduje približne na 2 až 10 prípadov na 100 000 osôb ročne. Riziko rastie s vekom a s prítomnosťou vaskulárnych rizikových faktorov.</p>

<h2>Prečo sa diskutuje práve o GLP-1 liekoch</h2>

<p>Záujem o túto tému vzrástol po publikovaní observačných štúdií a kazuistík, ktoré naznačili možnú asociáciu medzi GLP-1 liekmi a výskytom NAION.</p>

<p>Treba však zdôrazniť rozdiel medzi asociáciou a príčinou. To, že sa jav vyskytol u pacienta užívajúceho konkrétny liek, ešte neznamená, že liek bol príčinou. Pacienti užívajúci GLP-1 agonisty majú často diabetes, hypertenziu, obezitu, obštrukčné spánkové apnoe alebo iné cievne rizikové faktory. Práve tie sú zároveň známymi rizikovými faktormi NAION.</p>

<p>Inými slovami, môže ísť o prekrytie rizikových populácií.</p>

<h2>Rizikové faktory sa výrazne prekrývajú</h2>

<p>Medzi tradičné rizikové faktory NAION patria:</p>

<ul>
  <li>diabetes mellitus,</li>
  <li>arteriálna hypertenzia,</li>
  <li>obštrukčné spánkové apnoe,</li>
  <li>vyšší vek,</li>
  <li>vaskulárne ochorenia,</li>
  <li>anatomicky „preplnený“ terč zrakového nervu,</li>
  <li>pravdepodobne aj nočná hypotenzia u predisponovaných pacientov.</li>
</ul>

<p>Tieto faktory sú časté práve u pacientov liečených GLP-1 agonistami. Preto je ťažké odlíšiť, či prípadná NAION súvisí s liekom, so základným metabolickým a vaskulárnym rizikom, alebo s kombináciou viacerých faktorov.</p>

<h2>Možné mechanizmy sú zatiaľ hypotetické</h2>

<p>Niektorí odborníci uvažujú, že rýchle metabolické zmeny počas liečby by teoreticky mohli prispieť k zhoršeniu perfúzie zrakového nervu u citlivých pacientov.</p>

<p>Diskutované mechanizmy zahŕňajú:</p>

<ul>
  <li>rýchlu korekciu glykémie,</li>
  <li>zmeny krvného tlaku,</li>
  <li>zmeny hydratácie a objemového stavu,</li>
  <li>nočný pokles krvného tlaku,</li>
  <li>zhoršenú perfúziu zrakového nervu u predisponovaných osôb.</li>
</ul>

<p>Tieto mechanizmy sú biologicky možné, ale zatiaľ nie sú presvedčivo dokázané. Preto by bolo nesprávne tvrdiť, že GLP-1 lieky jednoznačne spôsobujú NAION.</p>

<h2>Otázka dávky a semaglutidu</h2>

<p>V diskusiách sa často spomína semaglutid. Niektoré analýzy hlásení nežiaducich účinkov naznačili častejší výskyt ischemickej optickej neuropatie pri produktoch so semaglutidom, pričom silnejší signál sa uvádzal pri lieku Wegovy.</p>

<p>Jedným z možných vysvetlení je dávka. Wegovy obsahuje vyššiu dávku semaglutidu používanú pri liečbe obezity, zatiaľ čo Ozempic sa používa pri diabete v iných dávkovacích schémach. Vyššia dávka môže teoreticky viesť k výraznejším metabolickým, objemovým alebo tlakovo-regulačným zmenám.</p>

<p>Aj tu však platí, že farmakovigilančné signály nedokazujú kauzalitu. Hlásenia nežiaducich účinkov sú užitočné na zachytenie možného problému, ale samy osebe nestačia na definitívne závery.</p>

<h2>Dôkazy sú zatiaľ observačné</h2>

<p>Dostupné údaje pochádzajú najmä z observačných štúdií, retrospektívnych analýz, farmakovigilančných databáz a kazuistík. Takéto dáta môžu upozorniť na možný bezpečnostný signál, ale majú viacero obmedzení.</p>

<p>Nedokážu spoľahlivo vylúčiť:</p>

<ul>
  <li>confounding by indication,</li>
  <li>vplyv základného diabetu alebo obezity,</li>
  <li>rozdiely v sledovaní pacientov,</li>
  <li>selektívne hlásenie nežiaducich účinkov,</li>
  <li>vyššiu pravdepodobnosť zachytenia udalostí pri mediálne známych liekoch.</li>
</ul>

<p>Keďže GLP-1 agonisty užívajú milióny pacientov, aj veľmi zriedkavé udalosti sa začnú objavovať častejšie v absolútnych počtoch. To samo osebe ešte neznamená, že riziko je vysoké.</p>

<h2>Ako o tom hovoriť s pacientom</h2>

<p>Pacienta netreba zbytočne vystrašiť. GLP-1 liečba má u správne indikovaných pacientov významné prínosy: zlepšenie glykemickej kontroly, redukciu hmotnosti a pri niektorých liekoch aj preukázané kardiovaskulárne a metabolické benefity.</p>

<p>Rozumná informácia pre pacienta môže znieť:</p>

<blockquote><p>„Pri týchto liekoch sa sleduje veľmi zriedkavý možný súvis s poruchou prekrvenia zrakového nervu. Nie je dokázané, že liek je príčinou. Ak by ste však mali náhle rozmazané videnie, stmavnutie obrazu alebo výpadok zorného poľa, najmä na jednom oku, treba okamžite vyhľadať lekára.“</p></blockquote>

<p>Takáto formulácia je presná, nebagatelizuje problém a zároveň nevyvoláva zbytočnú paniku.</p>

<h2>Praktický postup pre klinika</h2>

<p>Pri pacientoch liečených GLP-1 agonistami má zmysel venovať pozornosť najmä tým, ktorí majú vyššie vaskulárne riziko.</p>

<p>Prakticky je vhodné:</p>

<ul>
  <li>pýtať sa na nové poruchy videnia,</li>
  <li>upozorniť pacienta na príznaky vyžadujúce urgentné vyšetrenie,</li>
  <li>zohľadniť prítomnosť diabetu, hypertenzie a spánkového apnoe,</li>
  <li>vyhnúť sa príliš rýchlej alebo neprimerane agresívnej metabolickej korekcii u rizikových pacientov, ak to klinická situácia umožňuje,</li>
  <li>pri náhlej poruche zraku liečbu individuálne prehodnotiť a pacienta odoslať na urgentné oftalmologické vyšetrenie.</li>
</ul>

<p>Nie je dôvod rutinne vysadzovať GLP-1 agonisty len na základe obavy z NAION. Je však dôvod byť pozorný.</p>

<h2>Praktický záver</h2>

<p>Možná súvislosť medzi GLP-1 receptorovými agonistami a NAION je bezpečnostný signál, ktorý si zaslúži ďalšie skúmanie. Zatiaľ však ide o observačné údaje a kazuistiky, nie o dôkaz kauzálneho vzťahu.</p>

<p>Absolútne riziko sa javí ako malé. Prínosy GLP-1 liečby u vhodne indikovaných pacientov zostávajú významné. Najlepším prístupom preto nie je panika ani ignorovanie, ale informovaná ostražitosť.</p>

<p>Náhla, nebolestivá porucha videnia, výpadok zorného poľa alebo stmavnutie videnia na jednom oku má byť vždy riešené urgentne, bez ohľadu na to, či pacient užíva GLP-1 liek alebo nie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>GLP-1 Drugs and Ischemic Optic Neuropathy: What to Know</em> (2026). <a href="https://www.medscape.com/viewarticle/glp-1-drugs-and-ischemic-optic-neuropathy-what-know-2026a1000j2b" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
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
