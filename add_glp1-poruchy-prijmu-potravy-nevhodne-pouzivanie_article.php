<?php
/**
 * add_glp1-poruchy-prijmu-potravy-nevhodne-pouzivanie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-poruchy-prijmu-potravy-nevhodne-pouzivanie_article.php"
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
    'title'        => 'GLP-1 a poruchy príjmu potravy: rastúce obavy z nevhodného používania a ako im predchádzať',
    'slug'         => 'glp1-poruchy-prijmu-potravy-nevhodne-pouzivanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dostupnosť agonistov GLP-1 zjednodušila prístup k liečbe, no priniesla aj riziko nevhodných žiadostí. Ako rozpoznať poruchy príjmu potravy v anamnéze a prečo musí skríning a jasne stanovený cieľ liečby predchádzať predpisu.',
    'content'      => <<<'HTML'
<p>V posledných rokoch sa dostupnosť agonistov GLP-1 receptorov výrazne zjednodušila. Perorálne prípravky a rýchly prístup cez telemedicínske siete zvyšujú pravdepodobnosť, že o tieto lieky požiadajú aj ľudia mimo okruhu pacientov, pre ktorých sú určené. Medzi odborníkmi sa opakovane objavujú obavy, že časť žiadostí o GLP-1 môže súvisieť s nedostatočným zhodnotením porúch príjmu potravy alebo so skrytou anamnézou, ktorá sa pri „rýchlych“ predpisoch neodhalí.</p>

<p>Nasledujúci prehľad zhŕňa, na čo upozorňujú klinici, a ponúka praktický rámec, ako k indikácii GLP-1 pristupovať obozretne.</p>

<h2>Prečo sa o tom diskutuje</h2>

<p>Agonisty GLP-1 receptorov sú schválené pre pacientov s diabetom mellitus 2. typu a pre vybrané kategórie pacientov s obezitou alebo nadváhou so sprievodnými komorbiditami. Pribúdajú však predpisy pre ľudí, ktorí tieto typické indikácie nespĺňajú. Podľa analýzy trendov v retailových lekárňach sa podiel takýchto predpisov zvýšil zo 4,5 % v roku 2018 na 17 % v roku 2023.</p>

<p>Obavy nie sú iba teoretické. Odborníci zdôrazňujú najmä tri okruhy problémov:</p>

<ol>
  <li><strong>Dopyt „kvôli vzhľadu“ alebo „ešte trochu“</strong>, hoci pacient už má hmotnosť v pásme, kde ďalšie znižovanie neprináša medicínsky prínos.</li>
  <li><strong>Nedostatočná identifikácia porúch príjmu potravy</strong> alebo ich rizikových vzorcov, ktoré môžu byť pre pacienta citlivé a v ním uvádzanej anamnéze nemusia byť spomenuté.</li>
  <li><strong>Riziko škôd pri nevhodne stanovenom cieli chudnutia</strong> – napríklad nadmerná redukcia hmotnosti či strata svalovej hmoty; v citovanej literatúre sa spomína aj pankreatitída.</li>
</ol>

<h2>Kde hľadať varovné signály v anamnéze</h2>

<p>V praxi sa ukazuje, že pri posudzovaní vhodnosti GLP-1 nestačí hodnotiť len index telesnej hmotnosti (BMI) a „cieľovú hmotnosť“. Kľúčové je cielene sa pýtať na vzorce správania okolo jedla a na vnímanie vlastného tela.</p>

<p>Ako varovné signály sa opakovane uvádzajú napríklad:</p>

<ul>
  <li>túžba schudnúť aj po <strong>dosiahnutí zdravej cieľovej hmotnosti</strong> („len ešte kúsok“),</li>
  <li>snaha dosiahnuť <strong>výlučne estetický cieľ</strong>,</li>
  <li>nepriznaná alebo skrytá anamnéza poruchy príjmu potravy, prípadne <strong>neochota hovoriť o minulých epizódach</strong>,</li>
  <li>epizódy <strong>prejedania sa, purgatívneho správania (vracanie, preháňadlá) alebo reštrikcie</strong> a rigidné „pravidlá“ okolo jedla,</li>
  <li>výrazný strach z priberania a pretrvávajúce mentálne zaujatie jedlom (v anglickej literatúre označované ako „food noise“),</li>
  <li>požiadavka na <strong>rýchlu redukciu</strong> bez zjavnej medicínskej potreby.</li>
</ul>

<p>Niektorí klinici považujú za praktické viesť rozhovor tak, aby sa ťažisko prenieslo z kozmetického cieľa na otázku metabolického zdravia a celkovej prevencie. Skúsenosť naznačuje, že takéto prerámcovanie cieľa dokáže u časti pacientov znížiť tlak na to, aby „len schudli“.</p>

<h2>Skríning: čo má zmysel a ako ho robiť</h2>

<p>Viacerí lekári pred predpísaním GLP-1 vyžadujú vyšetrenie porúch príjmu potravy alebo aspoň posúdenie ich rizika.</p>

<h3>1. Systematická anamnéza pri každom začiatku liečby</h3>

<p>Podľa jedného z opísaných prístupov lekár zisťuje napríklad to, či pacient zažíval <strong>stratu kontroly pri jedení</strong> a či mal v minulosti <strong>poruchu príjmu potravy</strong>. Pri pozitívnej odpovedi sa dopĺňa validovaný skríning.</p>

<h3>2. Využitie skríningových nástrojov (napríklad BEDS-7)</h3>

<p>Z konkrétnych nástrojov sa uvádza dotazník <strong>Binge Eating Disorder Screener-7 (BEDS-7)</strong>; ďalšie nástroje sú dostupné prostredníctvom organizácie National Eating Disorders Association.</p>

<p>Zároveň platí, že hoci sa časť lekárov opiera o formálne nástroje, veľký význam má aj „realistická klinická reč“ – podrobná anamnéza celoživotných vzorcov správania a obáv týkajúcich sa vnímania vlastného tela.</p>

<h3>3. Rozhovor o nutričnej realite pri potlačení chuti do jedla</h3>

<p>Ak sa liečba GLP-1 už začne, treba počítať s praktickým problémom: potlačenie chuti do jedla môže pacientovi s rizikovým správaním sťažiť príjem <strong>dostatočného množstva bielkovín</strong>, a tým prispieť k strate svalovej hmoty. Preto sa odporúča aktívna nutričná edukácia a podľa kontextu pacienta aj zapojenie psychológa či dietológa.</p>

<h2>Kedy byť obzvlášť opatrný</h2>

<p>Nevhodné používanie sa podľa skúseností lekárov objavuje častejšie v niektorých skupinách. Z klinickej praxe vyplýva najmä:</p>

<ul>
  <li><strong>ženy v strednom veku</strong>, ktoré už schudli a chcú znížiť hmotnosť ešte o „posledných pár kilogramov“,</li>
  <li>pacienti s <strong>už preukázanou anamnézou poruchy príjmu potravy</strong> alebo s výraznými prejavmi rizikového správania,</li>
  <li>situácie, v ktorých sa u pacienta už prejavuje <strong>strata svalovej hmoty</strong>, klesajúca kostná denzita alebo komplikácie.</li>
</ul>

<p>Ilustruje to konkrétny príklad: pacientka s anamnézou poruchy príjmu potravy GLP-1 nedostala, ale bola vedená k vedeniu potravinového denníka. Spoločná revízia denníka umožnila riešiť kvalitu výživy a vysvetliť, prečo môže pri potlačení chuti do jedla vzniknúť problém so zachovaním svalovej hmoty.</p>

<h2>Nejednoznačnosť dôkazov a rozdiel medzi indikáciou a zneužitím</h2>

<p>V téme je prítomná dôležitá nuansa. Niektoré štúdie môžu naznačovať potenciálny prínos semaglutidu pri psychogénnom prejedaní (binge eating disorder). Klinická skúsenosť časti autorov však vedie k opatrnosti a k interpretácii, že problémom nemusí byť samotný mechanizmus účinku lieku, ale spôsob, akým sa liečba používa – u koho sa indikuje a aký cieľ sleduje.</p>

<p>Jedna z opísaných skúseností zdôrazňuje, že pri nevhodnom nastavení liečby alebo u pacientov, ktorí v skutočnosti primárne zápasia s psychiatrickým ochorením, môže dôjsť k nadmernej redukcii hmotnosti a k pokračovaniu liečby dlhšie, než sa klinicky považuje za primerané.</p>

<p>Prakticky to znamená, že <strong>skríning a jasne definovaný cieľ liečby</strong> musia predchádzať predpisu.</p>

<h2>Odporúčania pre klinickú prax</h2>

<p>Na základe uvedeného možno sformulovať praktický rámec:</p>

<ol>
  <li><strong>Pred predpisom GLP-1 vykonajte cielený diagnostický rozhovor</strong> so zameraním na poruchy príjmu potravy, stratu kontroly pri jedení a telesno-estetické ciele.</li>
  <li><strong>Pri podozrení na poruchu použite skríning</strong> (napríklad BEDS-7) a zvážte konzultáciu s odborníkmi na duševné zdravie alebo poruchy príjmu potravy.</li>
  <li><strong>Cieľ liečby stanovte ako metabolické zdravie, nie estetické „číslo“.</strong> Ak pacient žiada výraznú zmenu vzhľadu bez medicínskeho dôvodu, je rozumné presunúť diskusiu na výživu, svalovú hmotu a prevenciu.</li>
  <li><strong>Pri riziku malnutrície a straty svalstva</strong> riešte príjem bielkovín, nutričnú kvalitu a frekvenciu kontrol. V niektorých prípadoch pomáha aj potravinový denník.</li>
  <li><strong>Buďte opatrní pri telemedicínskom „skratkovom“ predpise.</strong> Časť odborníkov volá po tom, aby sa aspoň na začiatku a pri kontrolách robilo posúdenie osobne.</li>
</ol>

<h2>Záver</h2>

<p>Vyššia dostupnosť GLP-1 priniesla nielen lepší prístup k liečbe obezity, ale aj priestor pre nevhodné požiadavky. Kľúčom k zníženiu rizika je systematický skríning porúch príjmu potravy, jasné stanovenie cieľa liečby, edukácia o nutričných dôsledkoch a v rizikových situáciách včasné zapojenie psychologickej podpory.</p>

<p>Ak zvažujete GLP-1 u pacienta s hraničnou indikáciou, je férové pamätať, že „túžba schudnúť“ nie vždy znamená medicínsku potrebu. Môže ísť o psychiatricky podmienený vzorec správania, ktorý si vyžaduje iný liečebný plán.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Medical News, <em>Are GLP-1s Increasing Eating Disorder Risk?</em> (2026). <a href="https://www.medscape.com/viewarticle/are-glp-1s-increasing-eating-disorder-risk-2026a1000koq" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
