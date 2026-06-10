<?php
/**
 * add_potravinove-aditiva-farbiva-konzervanty-chronicke-ochorenia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_potravinove-aditiva-farbiva-konzervanty-chronicke-ochorenia_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Potravinové aditíva pod drobnohľadom: nové dáta spájajú farbivá a konzervanty s vyšším rizikom chronických ochorení',
    'slug'         => 'potravinove-aditiva-farbiva-konzervanty-chronicke-ochorenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nové epidemiologické údaje z francúzskej kohorty NutriNet-Santé spájajú vysoký príjem niektorých potravinových farbív a konzervantov s vyšším rizikom diabetu 2. typu, rakoviny, hypertenzie a kardiovaskulárnych ochorení. Ide o observačné dáta, nie o dôkaz kauzality.',
    'content'      => <<<'HTML'
<p>Potravinové aditíva sú bežnou súčasťou priemyselne spracovaných a najmä ultraprocesovaných potravín. Farbivá, konzervanty, antioxidanty a ďalšie látky pomáhajú zlepšiť vzhľad, trvanlivosť, chuť alebo technologické vlastnosti výrobkov. Nové epidemiologické údaje z francúzskej kohorty NutriNet-Santé však znovu otvárajú otázku, či ich dlhodobá konzumácia vo vysokých množstvách nemôže súvisieť so zvýšeným rizikom diabetu 2. typu, nádorových ochorení, hypertenzie a kardiovaskulárnych chorôb.</p>

<p>Nejde o dôkaz, že konkrétne aditívum priamo spôsobuje konkrétne ochorenie. Ide o observačné dáta. Napriek tomu sú výsledky dôležité, pretože sa týkajú látok, ktorým je vystavená veľká časť populácie.</p>

<p>Podľa databázy Open Food Facts malo v roku 2024 viac ako 139 000 potravinových a nápojových produktov aspoň jedno farbivo zo skupiny E100 až E199. Viac ako 700 000 produktov obsahovalo aspoň jeden konzervant zo skupiny E200 až E399. Expozícia teda nie je okrajová.</p>

<h2>Čo skúmali francúzski vedci</h2>

<p>Výsledky pochádzajú z kohorty NutriNet-Santé, veľkej prospektívnej webovej štúdie spustenej vo Francúzsku v roku 2009. Jej cieľom je sledovať vzťah medzi výživou, životným štýlom a zdravím.</p>

<p>Účastníci opakovane vypĺňali 24-hodinové stravovacie záznamy vrátane konkrétnych značiek komerčných výrobkov. Expozícia aditívam sa následne hodnotila pomocou viacerých databáz zloženia potravín a doplnkových laboratórnych analýz potravinových matríc.</p>

<p>Vedci identifikovali 37 farbív a 58 konzervantov. Do hlavných analýz zaradili tie, ktoré konzumovalo aspoň 10 % účastníkov: 10 farbív a 17 konzervantov.</p>

<p>Výhodou štúdie je veľkosť populácie, dlhé sledovanie a podrobný zber údajov o strave. Slabinou zostáva observačný charakter. Ani dôkladné štatistické úpravy nedokážu úplne vylúčiť zvyškové skreslenie.</p>

<h2>Farbivá a riziko diabetu 2. typu</h2>

<p>Jedna zo štúdií hodnotila súvislosť medzi príjmom potravinových farbív a vznikom diabetu 2. typu u 108 723 účastníkov sledovaných v rokoch 2009 až 2023.</p>

<p>Účastníci s najvyšším príjmom farbív mali o 38 % vyššie riziko diabetu 2. typu než osoby s najnižšou expozíciou.</p>

<p>Výsledky pre vybrané skupiny a látky:</p>

<ul>
  <li>celkové farbivá: HR 1,38; 95 % CI 1,17 až 1,63,</li>
  <li>karamelové farbivá: HR 1,43; 95 % CI 1,21 až 1,67,</li>
  <li>karotenoidy E160: HR 1,39; 95 % CI 1,19 až 1,62,</li>
  <li>beta-karotén E160a: HR 1,44; 95 % CI 1,23 až 1,68,</li>
  <li>obyčajný karamel E150a: HR 1,46; 95 % CI 1,26 až 1,70,</li>
  <li>kurkumín E100: HR 1,49; 95 % CI 1,29 až 1,73,</li>
  <li>antokyány E163: HR 1,40; 95 % CI 1,17 až 1,68.</li>
</ul>

<p>Tieto látky sa často nachádzajú v ultraprocesovaných potravinách. Preto je dôležité nehovoriť iba o jednej „éčkovej“ látke izolovane. Často ide o súčasť širšieho stravovacieho vzorca s vyšším podielom priemyselne spracovaných výrobkov.</p>

<h2>Farbivá a riziko rakoviny</h2>

<p>Druhá štúdia sledovala 105 260 dospelých v rokoch 2009 až 2023 a hodnotila vzťah medzi potravinovými farbivami a výskytom nádorových ochorení. Počas sledovania bolo zaznamenaných 4226 nových prípadov rakoviny, z toho 1208 prípadov karcinómu prsníka, 508 karcinómov prostaty a 352 kolorektálnych karcinómov.</p>

<p>Vysoký príjem farbív bol spojený:</p>

<ul>
  <li>so 14 % vyšším rizikom celkovej rakoviny,</li>
  <li>s 21 % vyšším rizikom karcinómu prsníka,</li>
  <li>s 32 % vyšším rizikom postmenopauzálneho karcinómu prsníka.</li>
</ul>

<p>Pri jednotlivých aditívach sa ukázali tieto asociácie:</p>

<ul>
  <li>beta-karotén E160a: 16 % vyššie riziko celkovej rakoviny a 41 % vyššie riziko karcinómu prsníka,</li>
  <li>obyčajný karamel E150a: 15 % vyššie riziko celkovej rakoviny.</li>
</ul>

<p>Aj tu treba byť presný. Tieto výsledky neznamenajú, že beta-karotén v mrkve alebo prirodzene farebná strava sú problémom. Hodnotená bola expozícia prídavným látkam v potravinárskych výrobkoch, nie prirodzený príjem živín z nespracovaných potravín.</p>

<h2>Konzervanty, hypertenzia a kardiovaskulárne ochorenia</h2>

<p>Tretia štúdia sa zamerala na konzervanty. Zahŕňala 112 395 účastníkov sledovaných v rokoch 2009 až 2024.</p>

<p>Najvyšší príjem konzervantov bol spojený s vyšším rizikom hypertenzie:</p>

<ul>
  <li>celkové konzervanty: HR 1,24; 95 % CI 1,16 až 1,34,</li>
  <li>neantioxidačné konzervanty: HR 1,29; 95 % CI 1,20 až 1,39,</li>
  <li>antioxidačné konzervanty: HR 1,22; 95 % CI 1,13 až 1,31.</li>
</ul>

<p>Neantioxidačné konzervanty boli zároveň spojené so 16 % vyšším rizikom kardiovaskulárneho ochorenia.</p>

<p>Pri individuálnych konzervantoch sa uvádzali tieto asociácie:</p>

<ul>
  <li>sorban draselný E202: 39 % vyššie riziko hypertenzie,</li>
  <li>kyselina citrónová E330: 25 % vyššie riziko hypertenzie,</li>
  <li>kyselina askorbová E300: 15 % vyššie riziko kardiovaskulárneho ochorenia.</li>
</ul>

<p>Tieto výsledky môžu na prvý pohľad prekvapiť, najmä pri látkach ako kyselina citrónová alebo kyselina askorbová. Interpretácia však musí byť opatrná. V kontexte tejto štúdie ide o potravinárske aditíva v priemyselných výrobkoch, nie o jednoduchý záver, že citrón alebo vitamín C sú škodlivé.</p>

<h2>Asociácia nie je kauzalita</h2>

<p>Najdôležitejším metodologickým bodom je, že ide o observačné štúdie. Autori upravovali analýzy o mnoho potenciálnych rušivých faktorov, vrátane sociodemografických charakteristík, fajčenia, alkoholu, fyzickej aktivity a celkovej kvality stravy.</p>

<p>To zvyšuje dôveryhodnosť výsledkov, ale nevylučuje všetky alternatívne vysvetlenia.</p>

<p>Možné problémy pri interpretácii:</p>

<ul>
  <li>ľudia s vyšším príjmom aditív môžu mať celkovo odlišný životný štýl,</li>
  <li>aditíva môžu byť markerom vyššej konzumácie ultraprocesovaných potravín,</li>
  <li>presné stanovenie expozície aditívam je zložité,</li>
  <li>zloženie potravín sa v čase mení,</li>
  <li>časť rizika môže súvisieť s celou potravinovou matricou, nie s jednou látkou.</li>
</ul>

<p>Preto by bolo nepresné tvrdiť, že „éčka spôsobujú rakovinu“ alebo že „konzervanty spôsobujú hypertenziu“. Presnejšie je povedať, že vyššia expozícia vybraným farbivám a konzervantom bola v tejto veľkej kohorte spojená s vyšším rizikom niektorých chronických ochorení.</p>

<h2>Čo z toho vyplýva pre pacienta</h2>

<p>Praktický odkaz nie je panika, ale zníženie zbytočnej expozície. Väčšina ľudí nepotrebuje riešiť jednotlivé E-kódy izolovane. Rozumnejšie je obmedziť pravidelnú konzumáciu ultraprocesovaných potravín a uprednostniť jednoduchšie, menej priemyselne upravené potraviny.</p>

<p>V praxi to znamená:</p>

<ul>
  <li>častejšie voliť základné potraviny,</li>
  <li>variť z čerstvých alebo minimálne spracovaných surovín,</li>
  <li>čítať zloženie pri výrobkoch, ktoré sa konzumujú často,</li>
  <li>nepreceňovať marketingové označenia typu „fit“, „light“ alebo „bez cukru“,</li>
  <li>vnímať dlhý zoznam aditív ako signál vyššej technologickej úpravy výrobku.</li>
</ul>

<p>Nie každý výrobok s aditívom je automaticky nebezpečný. Problémom je skôr dlhodobý vysoký príjem mnohých aditív v rámci stravy postavenej na ultraprocesovaných potravinách.</p>

<h2>Čo by mali urobiť regulačné autority</h2>

<p>Autori štúdií upozorňujú, že vzhľadom na široké používanie aditív sú epidemiologické dáta o ich vzťahu k chronickým chorobám stále obmedzené. Nové výsledky podľa nich podporujú potrebu opätovného hodnotenia bezpečnosti vybraných prídavných látok zdravotníckymi a potravinovými autoritami.</p>

<p>To neznamená okamžitý zákaz všetkých spomínaných látok. Znamená to potrebu presnejšieho hodnotenia dlhodobej expozície, kombinácií aditív a účinkov v reálnych stravovacích vzorcoch.</p>

<h2>Praktický záver</h2>

<p>Tri nové analýzy z kohorty NutriNet-Santé naznačujú, že vysoký príjem niektorých potravinových farbív a konzervantov je spojený s vyšším rizikom diabetu 2. typu, celkovej rakoviny, karcinómu prsníka, hypertenzie a kardiovaskulárnych ochorení.</p>

<p>Dôkaz kauzality zatiaľ nemáme. Signál je však dostatočne relevantný na to, aby podporil jednoduché a rozumné odporúčanie: obmedzovať zbytočné aditíva, znižovať podiel ultraprocesovaných potravín a uprednostňovať minimálne spracovanú stravu.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Food Additives: New Evidence Raising Safety Questions</em> (2026). <a href="https://www.medscape.com/viewarticle/food-additives-new-evidence-raising-safety-questions-2026a1000ib2" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
