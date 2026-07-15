<?php
/**
 * add_dennik-semafor-objemovy-manazment-hemodialyza-rct_article.php
 * Odborný článok o denníku „semafor“ pri riadení tekutín počas hemodialýzy.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Denník „semafor“ pri hemodialýze: lepšie krátkodobé riadenie tekutín v malej RCT',
    'slug'         => 'dennik-semafor-objemovy-manazment-hemodialyza-rct',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V 12-týždňovej randomizovanej štúdii s 80 hemodialyzovanými pacientmi denník „semafor“ zlepšil vedomosti a dodržiavanie odporúčaní a priaznivo ovplyvnil krátkodobé ukazovatele riadenia tekutín.',
    'content'      => <<<'HTML'
<p>Riadenie objemu tekutín pri udržiavacej hemodialýze je rovnováha medzi dvoma rizikami. Pretrvávajúce objemové preťaženie podporuje hypertenziu, dýchavicu, pľúcnu kongesciu a srdcové zlyhávanie. Príliš rýchle alebo nadmerné odstránenie tekutiny môže viesť k intradialytickej hypotenzii, kŕčom a orgánovej hypoperfúzii.</p>

<p>Li a spoluautori skúmali jednoduchý denník založený na princípe dopravného semaforu, ktorý spájal sebamonitorovanie, spätnú väzbu a odbornú edukáciu. V malej 12-týždňovej randomizovanej štúdii bol tento postup spojený s lepšími vedomosťami, postojmi a návykmi, vyššou mierou dodržiavania odporúčaní a priaznivejšími krátkodobými klinickými ukazovateľmi než bežná edukácia.</p>

<p>Výsledok je povzbudivý, ale nepreukazuje dlhodobý prínos pre hospitalizácie, kardiovaskulárne príhody alebo prežívanie. Publikovaný abstrakt navyše neuvádza presné farebné prahy ani úplný obsah denníka, preto z neho nemožno zostaviť univerzálny „semafor“ vhodný pre každého pacienta.</p>

<h2>Objemový stav nevzniká iba počas dialýzy</h2>

<p>Potrebnú ultrafiltráciu ovplyvňuje príjem sodíka a tekutín medzi procedúrami, reziduálna diuréza, dĺžka medzidialyzačného intervalu, predpísaný čas dialýzy, hyperglykémia, srdcové zlyhávanie a aktuálna cieľová hmotnosť. Vyšší medzidialyzačný prírastok hmotnosti často znamená väčší objem, ktorý treba odstrániť v obmedzenom čase, a tým aj vyššiu ultrafiltračnú rýchlosť.</p>

<p>Cieľová alebo „suchá“ hmotnosť pritom nie je navždy platné číslo. Mení sa s výživou, svalovou a tukovou hmotou, zápalom, reziduálnou diurézou a srdcovou funkciou. Denník môže zachytiť správanie a symptómy, ale nenahrádza <a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">klinické a objektívne hodnotenie cieľovej hmotnosti</a>.</p>

<h2>Ako bola štúdia usporiadaná</h2>

<p>Do randomizovanej kontrolovanej štúdie bolo zaradených 80 pacientov na udržiavacej hemodialýze. Pomocou tabuľky náhodných čísel ich rozdelili na intervenčnú a kontrolnú skupinu po 40 osobách. Intervencia trvala 12 týždňov.</p>

<p>Kontrolná skupina dostávala rutinnú hemodialyzačnú liečbu a bežnú edukáciu o riadení objemu tekutín v dialyzačnom stredisku. Intervenčná skupina navyše používala denník „semafor“, ktorý kombinoval sebamonitorovanie so spätnou väzbou a odbornou edukáciou.</p>

<p>Autori porovnávali skóre vedomostí, postojov a praktických návykov, mieru dodržiavania odporúčaní, medzidialyzačný prírastok hmotnosti (IDWG), ultrafiltračnú rýchlosť (UFR), krvný tlak a akútne komplikácie počas dialýzy.</p>

<h2>Čo sa po 12 týždňoch zlepšilo</h2>

<div class="table-responsive" role="region" aria-label="Výsledky štúdie denníka semafor po 12 týždňoch" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Denník „semafor“</th>
      <th scope="col">Kontrola</th>
      <th scope="col">Čo možno vyvodiť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Vedomosti</td>
      <td>9 bodov [IQR 8–10]</td>
      <td>7 bodov [IQR 6–8]</td>
      <td>Vyššie skóre v intervenčnej skupine</td>
    </tr>
    <tr>
      <td>Postoje</td>
      <td>9,2 bodu [IQR 8,5–10,0]</td>
      <td>7,0 bodu [IQR 6,1–8,2]</td>
      <td>Vyššie skóre v intervenčnej skupine</td>
    </tr>
    <tr>
      <td>Praktické návyky</td>
      <td>22,9 ± 1,62 bodu</td>
      <td>18,7 ± 1,01 bodu</td>
      <td>Vyššie skóre v intervenčnej skupine</td>
    </tr>
    <tr>
      <td>Dodržiavanie odporúčaní</td>
      <td>95 %</td>
      <td>75 %</td>
      <td>Rozdiel 20 percentuálnych bodov</td>
    </tr>
    <tr>
      <td>IDWG a UFR</td>
      <td colspan="2">V intervenčnej skupine boli nižšie (p &lt; 0,05)</td>
      <td>Abstrakt neposkytuje hodnoty, rozdiely ani intervaly spoľahlivosti</td>
    </tr>
    <tr>
      <td>Krvný tlak</td>
      <td colspan="2">Kontrola bola v intervenčnej skupine priaznivejšia (p &lt; 0,05)</td>
      <td>Abstrakt neuvádza konkrétny tlak ani definíciu kontroly</td>
    </tr>
    <tr>
      <td>Hypotenzia a kŕče počas dialýzy</td>
      <td colspan="2">V intervenčnej skupine sa vyskytovali menej často (p &lt; 0,05)</td>
      <td>Abstrakt neuvádza počty udalostí ani absolútny rozdiel</td>
    </tr>
  </tbody>
</table>
</div>

<p>Všetky uvedené rozdiely boli štatisticky významné pri p &lt; 0,05. Samotná hodnota p však nevyjadruje veľkosť ani klinickú dôležitosť účinku. Pri IDWG, UFR, krvnom tlaku a komplikáciách nemožno bez čísel z abstraktu posúdiť absolútny prínos.</p>

<h2>Prečo môže jednoduchý denník fungovať</h2>

<p>Jednorazová rada „menej piť“ nevysvetľuje vzťah medzi sodíkom, smädom, prírastkom hmotnosti, potrebnou ultrafiltráciou a príznakmi. Denník môže premeniť abstraktné odporúčanie na opakovaný cyklus: pacient si údaj všimne, zaznamená ho, dostane zrozumiteľnú spätnú väzbu a pri ďalšej dialýze ho preberie s tímom.</p>

<p>Farebná kategorizácia môže znížiť kognitívnu záťaž a zjednodušiť rozhodovanie. Táto štúdia však nepreukázala, že účinok bol spôsobený práve farbami. Mohla sa na ňom podieľať častejšia pozornosť, spätná väzba, kontakt s personálom alebo celkovo intenzívnejšia edukácia.</p>

<h2>Ako princíp bezpečne preniesť do praxe</h2>

<p>Lokálny nástroj má pripraviť dialyzačný tím spolu s pacientom. Farebné zóny, ciele a reakcie musia vychádzať z cieľovej hmotnosti, reziduálnej diurézy, dĺžky dialýzy, komorbidít a predpísaného režimu. Publikovaný abstrakt neoprávňuje prevziať jeden pevný limit tekutín, IDWG alebo UFR pre všetkých.</p>

<p>Užitočný záznam môže obsahovať:</p>

<ul>
  <li>hmotnosť pred dialýzou a po nej a dĺžku medzidialyzačného intervalu,</li>
  <li>predpísanú cieľovú hmotnosť a jej zmeny vykonané tímom,</li>
  <li>dýchavicu, ortopnoe, opuchy, smäd a výraznú postdialyzačnú únavu,</li>
  <li>hypotenziu, závraty, kŕče alebo predčasné ukončenie procedúry,</li>
  <li>príjem sodíka a situácie, ktoré zvyšujú smäd,</li>
  <li>domáci krvný tlak, ak je meraný validovaným prístrojom správnou technikou,</li>
  <li>zmeny reziduálnej diurézy a mimoriadne straty pri horúčke, vracaní alebo hnačke.</li>
</ul>

<p>Denník nesmie viesť k svojvoľnej zmene cieľovej hmotnosti, ultrafiltrácie, liekov ani príjmu tekutín. Nová dýchavica v pokoji, bolesť na hrudníku, porucha vedomia alebo závažná hypotenzia sú dôvodom na bezodkladné klinické riešenie, nie na čakanie na ďalšie vyhodnotenie denníka.</p>

<h2>Súlad s odporúčaniami pre hemodialýzu</h2>

<p>Odporúčanie UK Kidney Association kladie dôraz na multidisciplinárne hodnotenie tekutín so zapojením pacienta a na zrozumiteľné pojmy, napríklad cieľová hmotnosť, prírastok tekutín a objemové preťaženie. Pri nejasnom klinickom obraze navrhuje doplniť validované objektívne meranie, napríklad bioimpedanciu.</p>

<p>Odporúčanie zároveň zdôrazňuje vyhýbanie sa nadmernej UFR: znížením prírastkov, postupným dosahovaním cieľovej hmotnosti alebo podľa potreby úpravou dialyzačného režimu. Denník môže podporiť prvú časť tohto procesu, ale nenahrádza rozhodnutie o dĺžke a frekvencii dialýzy ani opakované posúdenie objemového stavu.</p>

<h2>Limity štúdie</h2>

<ul>
  <li>iba 80 pacientov a 12 týždňov sledovania,</li>
  <li>intervenciu nebolo možné zaslepiť a nie je jasné, či boli zaslepení hodnotitelia,</li>
  <li>abstrakt neopisuje utajenie randomizačného poradia, úplný obsah denníka ani jeho farebné prahy,</li>
  <li>časť výsledkov vychádzala zo skóre vedomostí, postojov, návykov a dodržiavania odporúčaní,</li>
  <li>pri viacerých klinických výsledkoch chýbajú v abstrakte veľkosti účinku a intervaly spoľahlivosti,</li>
  <li>viacnásobné porovnávania zvyšujú riziko náhodne významného výsledku,</li>
  <li>neboli hodnotené dlhodobé hospitalizácie, kardiovaskulárne príhody, reziduálna funkcia obličiek ani mortalita.</li>
</ul>

<h2>Záver</h2>

<p>V malej randomizovanej štúdii zlepšil denník „semafor“ počas 12 týždňov vedomosti, postoje, praktické návyky a mieru dodržiavania odporúčaní. Intervenčná skupina mala aj priaznivejšie IDWG, UFR, kontrolu krvného tlaku a menej intradialytickej hypotenzie a kŕčov, hoci abstrakt pri týchto ukazovateľoch neuvádza veľkosť účinku.</p>

<p>Ide o sľubný edukačný doplnok, nie o hotový univerzálny protokol. Pred širším prijatím potrebuje presnejší opis intervencie, replikáciu vo väčších a dlhších štúdiách a hodnotenie objektívneho objemového stavu aj klinicky významných výsledkov.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Li A, Zhang D, Zhou L, Lu W. Efficacy of a Traffic Light Diary in Volume Management for Patients Undergoing Maintenance Hemodialysis: A Randomized Controlled Study. <em>Hemodialysis International</em>. Publikované online 14. júla 2026. DOI: 10.1111/hdi.70114. <a href="https://pubmed.ncbi.nlm.nih.gov/42444580/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1111/hdi.70114" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Odporúčanie:</strong> UK Kidney Association. Clinical Practice Guideline: Haemodialysis, časť Fluid in haemodialysis. <a href="https://guidelines.ukkidney.org/haemodialysis/rationale-for-clinical-practice-guidelines/fluid-in-haemodialysis/" target="_blank" rel="noopener noreferrer">UK Kidney Association</a>.</em></p>
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
                error_log('add_dennik_semafor newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_dennik_semafor pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_dennik_semafor pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_dennik_semafor migration error: ' . $e->getMessage());
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
