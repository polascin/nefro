<?php
/**
 * add_aky-rastlinny-je-aktualny-smer-vyzivovych-odporucani-a-preco-to-ma-zmysel_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Aký „rastlinný" je aktuálny smer výživových odporúčaní a prečo to má zmysel',
    'slug'         => 'aky-rastlinny-je-aktualny-smer-vyzivovych-odporucani-a-preco-to-ma-zmysel',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Rozhovor s kardiológom Kimom Williamsom sa venuje tomu, ako sa výživové odporúčania pre zdravie srdca posúvajú smerom k „plant-forward" prístupu, prečo má rastlinná strava oporu v dôkazoch a čo to v praxi znamená pre pacientov.',
    'content'      => <<<'HTML'
<p>Výživové odporúčania sa v posledných rokoch menili a často si navzájom odporovali. V rozhovore pre Medscape sa na túto tému pozrie autoritatívny pohľad z kardiológie: ako majú ľudia čítať dietetické usmernenia, čo je na nich najsilnejšie podložené dôkazmi a prečo sa čoraz viac hovorí o prístupe „plant-forward" – teda viac rastlinných potravín, menej živočíšnych.</p>

<h2>AHA: dôraz na zdravie srdca cez rastlinnú stravu, vlákninu a mikrobióm</h2>

<p>Podľa doc. dr. Kima Williamsa (kardiológ, bývalý prezident ACC) je odporúčanie AHA v jadre dlhodobý trend, ktorý sa postupne opiera o narastajúci objem dát. Kľúčové argumenty sú:</p>
<ul>
    <li><strong>Substitučný efekt:</strong> keď pri rastlinnej strave nahrádzate potraviny, ktoré sú pre kardiovaskulárne riziko nepriaznivé, samotná zmena skladby stravy znižuje riziko.</li>
    <li><strong>Mikrobióm a zápal:</strong> vláknina z rastlinných potravín mení zloženie črevných baktérií a môže znižovať zápalové mechanizmy spájané s aterosklerózou a kardiometabolickými ochoreniami.</li>
    <li><strong>Konzistentnosť s klinickými dôkazmi:</strong> rozhovor spomína súvislosti s regresiou plaku (napr. pri liečbe znižujúcej LDL cholesterol) a argumentuje, že whole-food rastlinná strava má schopnosť zlepšovať rizikové faktory, ako sú lipidy aj zápal.</li>
</ul>
<p>Williams pripomenul aj historickú „cestu" odporúčaní AHA a ACC, pričom zdôraznil, že súčasné odporúčanie je podľa neho v súlade s tým, čo ukazujú dlhodobé dáta v oblasti výživy „ako lieku".</p>

<h2>Ako do toho vstupujú americké dietetické odporúčania a otázka „viac bielkovín"</h2>

<p>V rozhovore sa rieši rozpor medzi tým, čo ľudia počujú z federálnych dietetických odporúčaní, a tým, čo odporúča kardiologická komunita.</p>
<p>Zaznieva bežná otázka pacientov: „Nepotrebujem viac bielkovín?" Williams reaguje, že pre verejnosť je ťažké prejsť všetky štúdie, ale keď sa dá literatúra zmysluplne zhrnúť, obraz je opäť <strong>plant-forward</strong>.</p>
<p>Zároveň upozorňuje, že sa v USA menili dôrazy – napríklad na nasýtené tuky, cukry a rafinované obilniny. Podľa neho boli v niektorých obdobiach závery z finálnych odporúčaní menej konzistentné s tým, na čo upozorňovali odborné poradné skupiny. Williams spomína aj negatívne následky „dôrazu na živočíšne bielkoviny", pričom ako príklady uvádza <strong>chronické ochorenie obličiek</strong> a <strong>dnu</strong> ako klinické stavy, ktoré sa podľa neho viažu na vyššiu spotrebu živočíšnych bielkovín. (V rozhovore ide o interpretáciu a argumentáciu, nie o detailné rozobratie všetkých kauzálnych dôkazov.)</p>

<h2>Ultra-spracované potraviny: kde sa zhodujú obe prúdy</h2>

<p>Jedna z tém, ktoré v rozhovore výrazne vystupujú, je zhoda na tom, že <strong>ultra-spracované potraviny</strong> treba z jedálnička obmedziť, ideálne eliminovať.</p>
<p>Zároveň sa pridáva praktické odporúčanie, ako rozlišovať „zdanlivo zdravé" výrobky: aj keď existujú spracované potraviny, ktoré nemusia byť automaticky zlé, človek má byť selektívny. Williams navrhuje zjednodušený rámec – pozerať sa na parametre typu <strong>nasýtené tuky, sodík, cukry a vláknina</strong> a produkty s nepriaznivými hodnotami obmedziť.</p>
<p>Dôležité je aj rozlíšenie sacharidov na úrovni kvality:</p>
<ul>
    <li><strong>Celé potraviny a celozrnné obilniny</strong> sú konzistentne spájané s lepším zdravotným dopadom.</li>
    <li><strong>Rafinované zdroje</strong> (biela múka, biela ryža, biele cestoviny) je vhodné nahrádzať celozrnnými verziami.</li>
</ul>

<h2>„Food deserts" a praktická rovina: prístupnosť potravín a systémový problém</h2>

<p>Ďalšia téma je prístup k zdravým potravinám. O'Donoghue aj Williams tvrdia, že bez dostupnosti v lokalite a bez funkčného „potravinového prostredia" je ťažké očakávať, že ľudia budú robiť ideálne rozhodnutia.</p>
<p>Williams používa úmyselný slovný kontrast „food <em>desserts</em>" namiesto „food <em>deserts</em>" – pointa je, že:</p>
<ul>
    <li>zdravotnícky systém rieši choroby liekmi a procedúrami,</li>
    <li>potravinový systém však často funguje tak, aby predával to, čo sa kupuje,</li>
    <li>preto treba meniť aj podmienky – dostupnosť ovocia, zeleniny a celozrnných produktov v školách aj v komunitách.</li>
</ul>

<h2>Čo si z toho odniesť</h2>

<p>Rozhovor posúva jednu hlavnú myšlienku: moderné dietetické odporúčania pre zdravie srdca sa zbiehajú smerom k výžive, ktorá je „plant-forward", znižuje ultra-spracované potraviny a uprednostňuje vlákninu, celé potraviny a celozrnné sacharidy.</p>
<p>Zároveň uznáva, že bez reálnej dostupnosti zdravých potravín zostáva odporúčanie pre veľkú časť populácie len na papieri. Lekári majú venovať výžive viac pozornosti, no zároveň sa musia meniť aj systémové bariéry.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, rozhovor k výživovým smerniciam a „plant-forward" prístupu. <a href="https://www.medscape.com/viewarticle/how-plant-forward-are-recent-dietary-guidelines-2026a1000f5f" target="_blank" rel="noopener noreferrer">Kliknite sem</a>.</em></p>
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
