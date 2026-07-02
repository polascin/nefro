<?php
/**
 * add_ked-sa-citime-chori-co-medicina-prehliada-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Keď sa cítime chorí — choroba (disease) vs chorobnosť (illness)
 * a jej význam pre nefrológiu.
 * Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie JEDNÉHO zdroja
 * (Medscape, autor Arya Anthony Kamyab) → jeho meno je doplnené do source_authors.php.
 * Kniha Ch. D. Warda je len odkazovaný zdroj v článku, nie autor zdroja.
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
    'title'        => 'Keď sa cítime chorí: čo medicína prehliada a prečo na tom záleží aj v nefrológii',
    'slug'         => 'ked-sa-citime-chori-co-medicina-prehliada-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Medicína vie spoľahlivo pomenovať chorobu (disease), no často prehliada chorobnosť (illness) — subjektívnu skúsenosť, že „nie som sám sebou“. Tento rozdiel nie je v nefrológii filozofiou, ale každodenným rozhodovacím rámcom: prežívanie pacienta je relevantný klinický signál aj vtedy, keď laboratórne hodnoty zostávajú stabilné.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>Medicína je v praxi veľmi úspešná pri identifikovaní toho, „čo je zle“ v tele. Dokáže pomenovať poruchy funkcie orgánov, vysvetliť nálezy a zvoliť liečbu podľa biologického mechanizmu. Zároveň však existuje druhá vrstva, ktorú je len ťažko možné zachytiť vyšetreniami. Ide o <strong>chorobnosť (illness)</strong>, teda skúsenosť, že nie som „svoj“, že moje bežné fungovanie sa narušilo a svet okolo mňa sa začal správať inak.</p>

<p>Tento rozdiel medzi <strong>chorobou (disease)</strong> a <strong>chorobnosťou (illness)</strong> je jadrom myšlienky článku — medicína niekedy „nevidí“ to, čo pacient vníma ako skutočne dôležité: prežívanie nepohody, neistotu, stratu rutiny, zmenený vzťah k telu a vplyv na život.</p>

<h2>Choroba nie je to isté ako chorobnosť</h2>

<p>Často sa pracuje s predstavou, že „ak sa to nedá dokázať nálezom, tak to nie je skutočné“. Článok však zdôrazňuje opak: <strong>chorobnosť je skúsenosť</strong>, nie iba súbor merateľných abnormalít. Keď ľudia povedia „som chorý“, zvyčajne nemajú na mysli iba patológiu. Opisujú narušenie bežného života: zmeny v rutine, v schopnostiach, v pocite bezpečia do budúcnosti, v kvalite vzťahov a v tom, ako vnímajú sami seba.</p>

<p>Z toho vyplýva prakticky dôležitý záver: aj keď choroba a chorobnosť často idú spolu, <strong>ani jedna nie je úplne závislá od druhej</strong>. Existujú situácie, keď človek trpí a vyšetrenia nedokážu poskytnúť jasné vysvetlenie; a naopak, existujú nálezy, ktoré síce zodpovedajú „chorobnému“ obrazu, ale pacientovo prežívanie nemusí zodpovedať tej istej intenzite.</p>

<h2>Kedy „chorobnosť“ prichádza: skôr, než ju zachytí diagnostika</h2>

<p>V článku sa zdôrazňuje perspektíva, že človek často vie, že niečo „nie je v poriadku“, <strong>skôr ako sa začne vyšetrovací proces</strong>. Rozpoznanie sa rodí z prežívania, z nášho vzťahu k vlastnému telu, z očakávania zdravia a z toho, ako daná kultúra interpretuje príznaky.</p>

<p>V praxi to mení aj otázku „kedy je pacient vlastne chorý?“. Ak diagnóza príde až neskôr, znamená to, že pacient už určitý čas žije v stave, ktorý sa pre medicínu stáva „informáciou na prácu“ až dodatočne. Pacient sa však medzičasom adaptuje, stráca istotu a prežíva nepohodu, ktorá nemusí mať okamžité biologické potvrdenie.</p>

<h2>Diagnóza pomáha, ale môže aj zjednodušovať</h2>

<p>Diagnostické označenie je užitočné. Dáva spoločný jazyk, umožňuje koordinovať starostlivosť a niekedy nasmerovať liečbu. Zároveň však článok upozorňuje na riziko: previesť komplexnú skúsenosť na jedinú klinickú kategóriu znamená <strong>odfiltrovať variabilitu a hĺbku prežívania</strong>.</p>

<p>To je v nefrológii obzvlášť citlivé. Pacient s chronickým ochorením obličiek (aj počas dialýzy) často neprežíva iba „ochorenie obličiek“ ako diagnózu. Prežíva kombináciu obmedzení, únavy, kolísania príznakov, vplyvu liečby na organizmus, psychickej záťaže, ale aj zmeny v tom, čo preňho znamená každodennosť. Jedna diagnostická nálepka nikdy nevystihne celé „nie som sám sebou“.</p>

<h2>Čo to mení v nefrologickej praxi</h2>

<p>Ak prijmeme, že chorobnosť je skúsenosť, a nie iba merateľná odchýlka, vynára sa pre nefrológiu niekoľko praktických dôsledkov.</p>

<h3>1) Pacientov opis nie je len „anamnéza na doplnenie“</h3>

<p>Keď pacient opíše, že sa „necíti sám sebou“, že trpí, že ho niečo brzdí viac, než by naznačovali čísla, je to klinicky relevantné. Nemusí to automaticky znamenať, že všetko je „psychosomatické“ alebo „nevysvetliteľné“. Skôr to znamená, že v diagnostickom myslení treba aktívne hľadať súvislosti aj v tom, čo sa nedá zachytiť jediným parametrom.</p>

<h3>2) Absencia jednoznačných nálezov neznižuje realitu utrpenia</h3>

<p>Článok explicitne upozorňuje na paradox: človek prežíva výraznú nepohodu, no vyšetrenia nemusia poskytnúť „dôkaz“. To samo osebe neumenšuje realitu utrpenia. V nefrológii to môže znamenať, že aj pri relatívne stabilných laboratórnych hodnotách pacient prežíva výrazné funkčné obmedzenie, ktoré treba brať vážne a cielene riešiť — symptomaticky, rehabilitáciou, úpravou režimu či liečby, prípadne zhodnotením faktorov, ktoré sa nedajú zúžiť na jediný laboratórny nález (napríklad kvalita spánku, tolerancia liečby, funkčné schopnosti).</p>

<h3>3) „Čo diagnóza vysvetlí“ a „čo diagnóza zakryje“ treba vedieť rozlíšiť</h3>

<p>Diagnóza má osvetliť časť obrazu, no zmysluplná komunikácia a manažment by mali zároveň počítať s tým, že nemusí pokryť všetko, čo pacient prežíva.</p>

<p>Pre klinickú prax to znamená, že je užitočné cielene sa pýtať na vplyv ochorenia na život: čo je pre pacienta dnes najťažšie, čo sa zmenilo, ako liečba ovplyvňuje jeho fungovanie a aké „bariéry“ sa objavili.</p>

<h3>4) Prehodnotiť, kam smerujú rozhovory</h3>

<p>Ak sa v rozhovore príliš skoro presunie ťažisko len na čísla, pacientovo prežívanie môže zostať nepomenované. Článok uzatvára, že výzvou pre lekárov nie je odmietanie medicínskych vysvetlení, ale <strong>uznanie ich hraníc</strong>. V praxi to znamená vyvážiť:</p>

<ul>
  <li>objektívne merania,</li>
  <li>a zároveň pozornosť voči tomu, čo pacient prežíva ako chorobnosť.</li>
</ul>

<h2>Záver</h2>

<p>Medicína je vynikajúca v identifikovaní choroby. No ak chceme skutočne pomôcť človeku, nestačí iba pomenovať „čo je zle v tele“. Potrebujeme rozumieť aj tomu, ako sa chorobnosť rodí, ako sa komunikuje a ako diagnózy môžu niečo vysvetliť, ale aj niečo prehliadnuť. V nefrológii to nie je filozofická téma, ale každodenný klinický rozhodovací rámec: kvalita starostlivosti sa často zlepšuje práve vtedy, keď pacientovo „nie som sám sebou“ berieme ako relevantný klinický signál, nie ako vedľajší šum.</p>

<p><em><strong>Poznámka:</strong> Tento článok má vzdelávací a osvetový charakter a nenahrádza individuálne klinické rozhodovanie ošetrujúceho tímu.</em></p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li>Arya Anthony Kamyab. „What Medicine Misses When You Feel Ill“ (o rozdiele medzi <em>disease</em> a <em>illness</em>). <em>Medscape</em>, 2026. <a href="https://www.medscape.com/viewarticle/what-medicine-misses-when-you-feel-ill-2026a1000l1r" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</li>
  <li>Christopher D. Ward. <em>Between Sickness and Health: The Landscape of Illness and Wellness</em>. 1. vydanie. Routledge, 2020. <a href="https://www.routledge.com/Between-Sickness-and-Health-The-Landscape-of-Illness-and-Wellness/Ward/p/book/9781138592872" target="_blank" rel="noopener noreferrer">Informácie o knihe</a>.</li>
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
