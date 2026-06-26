<?php
/**
 * add_ema-zrusenie-povolenia-tavneos-avacopan-anca-vaskulitida_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: EMA odporučila zrušenie povolenia pre Tavneos (avacopan).
 * Autor projektu: MUDr. Ľubomír Polaščín. Slovenské spracovanie JEDNÉHO zdroja
 * (Medscape, autor Rob Hicks) → jeho meno je doplnené do source_authors.php.
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
    'title'        => 'Nové dáta spochybnili účinnosť: EMA odporučila zrušenie povolenia pre Tavneos (avacopan) v EÚ — čo to znamená pre ANCA-vaskulitídu aj nefrológiu',
    'slug'         => 'ema-zrusenie-povolenia-tavneos-avacopan-anca-vaskulitida',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'EMA odporučila zrušiť povolenie pre Tavneos (avacopan): po opätovnom preskúmaní dát zo štúdie ADVOCATE už jeho prínosy nie sú preukázateľne vyššie než riziká. Pre nefrológiu to pri GPA/MPA s renálnym postihnutím znamená nezačínať nových pacientov, aktuálne liečených previesť na alternatívu a sledovať funkciu pečene.',
    'content'      => <<<'HTML'
<p>Európska agentúra pre lieky (EMA) odporučila Európskej komisii zrušiť povolenie na uvedenie na trh pre <strong>Tavneos (avacopan)</strong> v Európskej únii. Dôvodom nie je zmena mechanizmu účinku ako takého, ale to, že podľa EMA sa pôvodné rozhodnutie o účinnosti lieku opieralo o údaje z kľúčovej štúdie <strong>ADVOCATE</strong>, pri ktorej boli identifikované závažné problémy z hľadiska integrity dát a súladu s princípmi <strong>správnej klinickej praxe</strong>. EMA preto uzavrela, že <strong>prínosy už nie sú preukázateľne vyššie než riziká</strong>.</p>

<p>Pre klinickú prax to má priamy vplyv na liečbu <strong>granulomatózy s polyangiitídou (GPA)</strong> a <strong>mikroskopickej polyangiitídy (MPA)</strong>, vrátane pacientov s postihnutím obličiek; tieto ochorenia totiž patria medzi najčastejšie príčiny rýchlo progredujúceho zlyhania obličiek.</p>

<h2>Prečo je zrušenie povolenia závažné</h2>

<p>Tavneos sa používa u dospelých so závažnou, aktívnou GPA alebo MPA a je súčasťou <strong>kombinovanej liečby</strong>, ktorá zahŕňa aj iné imunosupresíva (v praxi typicky <strong>rituximab alebo cyklofosfamid</strong>) a <strong>redukciu kortikosteroidnej záťaže</strong>.</p>

<p>V štúdii ADVOCATE bolo hodnotených <strong>331 pacientov</strong> s GPA/MPA, ktorým sa počas <strong>52 týždňov</strong> podával <strong>avacopan</strong> alebo placebo, pričom obe ramená dostávali popri štandardnej liečbe aj <strong>kortikosteroidy počas 20 týždňov</strong>. Na základe týchto dát sa avacopan hodnotil ako prinajmenšom porovnateľne účinný ako 20-týždňové podávanie vysokých dávok kortikosteroidov pri dosahovaní remisie, s lepšími výsledkami pri udržaní dlhodobej remisie.</p>

<p>EMA však po opätovnom preskúmaní dát konštatovala, že štúdia bola realizovaná <strong>v rozpore s princípmi správnej klinickej praxe</strong> a že údaje dodané v čase posudzovania žiadosti boli <strong>„nesprávne a zavádzajúce“</strong>. Preto sa tieto výsledky už nedajú považovať za spoľahlivý dôkaz účinnosti.</p>

<h2>Praktické rozhodnutia: čo odporúčanie EMA znamená v praxi</h2>

<p>Z odporúčania EMA vyplýva, že:</p>

<ul>
  <li><strong>noví pacienti sa už nemajú začínať liečiť</strong> Tavneosom,</li>
  <li><strong>pacienti, ktorí Tavneos už užívajú</strong>, majú byť <strong>prevedení na vhodnú alternatívnu liečbu</strong>.</li>
</ul>

<p>Dôležité je aj to, že Tavneos je spojený so zvýšeným rizikom <strong>liekmi vyvolaného poškodenia pečene</strong> a zriedkavého <strong>syndrómu miznúcich žlčovodov</strong> (vanishing bile duct syndrome, VBDS). EMA preto odporúča <strong>pozorne sledovať funkciu pečene</strong> až do trvalého ukončenia liečby. Pri podozrení na VBDS sa má liek <strong>okamžite vysadiť</strong>.</p>

<p>Súčasne treba mať na pamäti, že odporúčanie EMA je len jedným z krokov: konečné, právne záväzné rozhodnutie pre všetky členské štáty vydá <strong>Európska komisia</strong>, ak odporúčanie EMA potvrdí.</p>

<h2>Nefrologický kontext: prečo je to relevantné práve pre obličky</h2>

<p>GPA/MPA sú systémové nekrotizujúce vaskulitídy spojené s protilátkami proti cytoplazmatickým antigénom neutrofilov (ANCA). <strong>Renálne postihnutie</strong> je v klinickom obraze časté a zásadné, lebo často rozhoduje o potrebe urgentnej hospitalizácie či dialýzy a o dlhodobej prognóze.</p>

<p>Aj keď sa článok venuje hodnoteniu lieku primárne z pohľadu regulačných dôkazov, pre nefrológa sú dôležité tieto praktické roviny:</p>

<h3>1) Zmysluplnosť stratégie šetriacej kortikosteroidy sa stáva neistou</h3>

<p>Avacopan ako antagonista receptora C5a smeruje k zníženiu zápalovej aktivity ciev. V klinickej praxi však často platí, že veľká časť prínosu liečby spočívala v kombinácii s režimami, ktoré umožňujú <strong>obmedziť expozíciu kortikosteroidom</strong>.</p>

<p>Ak sa účinnosť doložená štúdiou ADVOCATE už nepovažuje za spoľahlivú, je potrebné prehodnotiť, aký kompromis medzi kontrolou vaskulitídy a minimalizáciou steroidnej toxicity je v konkrétnej situácii pre pacienta optimálny.</p>

<h3>2) Zmena liečby musí ísť ruka v ruke s bezpečnostným sledovaním pečene</h3>

<p>Pri pacientoch s nefrologickými diagnózami je bežné, že sa súčasne rieši viac orgánových systémov naraz. Ak sa Tavneos ukončuje alebo nahrádza, treba zároveň zabezpečiť:</p>

<ul>
  <li>cielene sledovať pečeňové testy počas prechodu,</li>
  <li>byť pozorný na klinické a laboratórne známky VBDS,</li>
  <li>koordinovať plán s multidisciplinárnym tímom (nefrológ, reumatológ/hematológ, podľa potreby hepatológ).</li>
</ul>

<h3>3) Prechod na alternatívy môže byť časovo kritický</h3>

<p>Pri systémových vaskulitídach platí, že „čakanie“ na nové rozhodnutia môže ovplyvniť chorobnú aktivitu. Preto odporúčanie EMA — <strong>nezačínať liečbu u nových pacientov</strong> a už liečených <strong>previesť na alternatívnu liečbu</strong> — znamená, že lokálne protokoly by mali mať pripravený mechanizmus rýchlej zmeny terapie.</p>

<h2>Ako to komunikovať pacientovi (praktická formulácia)</h2>

<p>Pacientovi je vhodné zrozumiteľne vysvetliť, že:</p>

<ul>
  <li>EMA odporučila zrušenie povolenia,</li>
  <li>nejde o „bežné kolísanie účinnosti“, ale o závažné pochybnosti o dôkazoch, ktoré v minulosti podporovali registráciu,</li>
  <li>preto sa liečba bude nahrádzať inou štandardnou liečebnou schémou,</li>
  <li>počas prechodu sa bude sledovať bezpečnosť, najmä funkcia pečene.</li>
</ul>

<p>Je vhodné zdôrazniť, že konkrétny postup závisí od aktuálnej chorobnej aktivity, stavu obličiek a komorbidít, nie od všeobecného odporúčania pre populáciu.</p>

<h2>Záver</h2>

<p>Odporúčanie EMA na zrušenie povolenia na uvedenie na trh pre <strong>Tavneos (avacopan)</strong> je regulačne aj klinicky významná udalosť. EMA uzatvára, že dôkazy z kľúčovej štúdie ADVOCATE už nemožno považovať za spoľahlivé pre problémy s integritou dát a porušenie zásad správnej klinickej praxe, a preto prínosy lieku nie sú preukázateľne vyššie než riziká.</p>

<p>Pre nefrológiu je to dôležité najmä u pacientov s <strong>GPA/MPA s postihnutím obličiek</strong>, u ktorých zmena liečebnej stratégie môže ovplyvniť kontrolu zápalu, potrebu intenzívnej starostlivosti aj bezpečnostné riziká. V praxi by sa mali okamžite riešiť dve veci: <strong>nezačínať liečbu u nových pacientov</strong> a <strong>systematicky prehodnotiť liečbu aktuálne liečených</strong>, vrátane <strong>sledovania funkcie pečene</strong> až do definitívneho ukončenia liečby.</p>

<hr>

<p><em><strong>Zdroj:</strong> Rob Hicks, „New Data Lead to Decision to Revoke Autoimmune Disease Drug“, <em>Medscape</em> (2026). <a href="https://www.medscape.com/viewarticle/new-data-lead-decision-revoke-autoimmune-disease-drug-2026a1000lut" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Poznámka:</strong> Tento článok má vzdelávací a osvetový charakter a nenahrádza individuálne klinické rozhodovanie ošetrujúceho tímu ani aktuálne stanoviská regulačných orgánov.</em></p>
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
