<?php
/**
 * add_5-kritickych-chyb-manazment-ckm-syndromu-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_5-kritickych-chyb-manazment-ckm-syndromu-nefrologia_article.php"
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
    'title'        => '5 kritických chýb v manažmente CKM syndrómu a praktické kroky pre nefrológiu',
    'slug'         => '5-kritickych-chyb-manazment-ckm-syndromu-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Päť typických chýb v manažmente kardiovaskulárno-renálno-metabolického (CKM) syndrómu podľa Medscape — od vynechania skríningu uACR cez ignorovanie štádia 0 až po pasivitu pri úhradách. Praktické kroky, ako CKM premeniť z konceptu na rutinu v nefrologickej praxi.',
    'content'      => <<<'HTML'
<h2>Prečo sa o CKM hovorí častejšie</h2>

<p>Kardiovaskulárno-renálno-metabolický (CKM) syndróm predstavuje rámec, ktorý má pomôcť prepojiť tri často „oddelené“ oblasti starostlivosti: kardiovaskulárne riziko, metabolické faktory a obličkové poškodenie. Článok na Medscape zdôrazňuje, že aj keď sa CKM rýchlo presadzuje a existujú naň prvé odporúčania, bežná prax naráža na staré zvyky a fragmentované myslenie.</p>

<p>V článku sa spomína päť typických chýb, ktoré môžu viesť k tomu, že sa u pacientov s rizikom CKM mešká diagnostika aj intervencia.</p>

<h2>Chyba č. 1: Vynechanie testu uACR</h2>

<p>Pomer albumínu ku kreatinínu v moči (uACR) je základný prediktor rizika a skríning albuminúrie je podľa nových odporúčaní indikovaný u pacientov s hypertriglyceridémiou, hypertenziou, metabolickým syndrómom alebo s diabetom 2. typu.</p>

<p>Praktický problém, na ktorý autor článku upozorňuje, je „nízka frekvencia“ vykonávania testu uACR: analýzy ukazujú, že veľká časť pacientov z rizikových skupín test uACR nedostala. Z nefrologického pohľadu je to dôležité najmä preto, že rastúce hodnoty uACR sú kontinuálne spojené s rizikom progresie chronického ochorenia obličiek a s kardiovaskulárnou mortalitou, pričom riziko sa môže objavovať aj pri relatívne nízkych hodnotách.</p>

<p><strong>Čo robiť v ambulancii a na oddelení:</strong> Nastaviť pracovné postupy tak, aby systém automaticky ponúkal uACR v rizikových situáciách CKM. Ak v elektronickej zdravotnej dokumentácii nie je „laboratórny panel CKM“ alebo štandardizovaný postup, je praktické požiadať o jeho doplnenie. Automatizácia znižuje pravdepodobnosť, že sa test pri zaneprázdnenosti „preklikne“.</p>

<h2>Chyba č. 2: Ignorovanie štádia 0</h2>

<p>Článok pracuje so stupňovaním CKM od štádia 0 po štádium 4. Štádium 0 zahŕňa dospelých bez identifikovaných rizikových faktorov CKM.</p>

<p>Podstatné je, že „bez rizikových faktorov“ neznamená „bez budúceho rizika“. Čím skôr sa začnú preventívne opatrenia a edukácia, tým väčší je priestor na intervenciu skôr, než pacient prejde do vyšších štádií, kde sa kumuluje kardiovaskulárne aj renálne riziko.</p>

<p><strong>Čo robiť:</strong> Pri mladších pacientoch (najmä ak sú riziká ešte nenápadné) zaradiť preventívne prvky podľa AHA „Life’s Essential 8“ a komunikáciu o CKM ako súčasť edukácie. V praxi ide o to, aby nefrologicky relevantné riziká boli zachytené včas a aby sa pacientovi nastavila „dráha“ prevencie.</p>

<h2>Chyba č. 3: Návrat k izolovanému (silo) prístupu</h2>

<p>Článok na Medscape stavia do kontrastu „starý svet“ silného oddelenia diagnóz a „nový svet“ CKM ako jednotnej mentálnej mapy. Vďaka tomu sa dá jednoduchšie predpisovať liečba s viacerými účinkami.</p>

<p>Autori spomínajú, že rámec CKM má umožniť predpisovať terapiu s viacerými cieľmi (multitarget), ktorá súčasne rieši kardiovaskulárne, metabolické aj renálne riziko (napríklad liekové triedy ako agonisty GLP-1 receptorov alebo inhibítory SGLT2). Cieľom nie je len „nový názov“, ale aj zmena spôsobu, ako sú poskytovatelia ochotní kombinovať intervencie.</p>

<p><strong>Čo robiť:</strong> V bežnej praxi si z odporúčaní vytvoriť vlastný zoznam „prvých úvah“. Článok odporúča začať pri vhodných pacientoch úvahou o agonistoch GLP-1 receptorov a/alebo inhibítoroch SGLT2 a zvažovať aj ďalšie liečebné postupy cielené na riziko.</p>

<h2>Chyba č. 4: Predpoklad, že pacient si GLP-1 nemôže dovoliť</h2>

<p>Jedna z častých bariér nie je klinická, ale logistická a systémová. Článok priamo pomenúva, že časť lekárov vníma lieky GLP-1 ako „nedostupné“, a nie ako realistickú voľbu pre konkrétneho pacienta.</p>

<p><strong>Čo robiť:</strong> Držať GLP-1 v zozname možností a aktívne hľadať dostupné zľavové programy a cesty, ktoré umožnia liečbu začať. V praxi to znamená aj to, že pacientovi sa neopakuje len odmietavá veta, ale že sa podniknú kroky smerom k získaniu dostupnej liečby.</p>

<h2>Chyba č. 5: Nechať sa zastaviť zamietnutím poistného krytia</h2>

<p>Indikácie aj podmienky úhrad sa môžu meniť. Článok upozorňuje, že ak je žiadosť zamietnutá, riešenie nemusí byť „koniec“. Niekedy môže k schváleniu viesť zmena prístupu, iné (viackritériové, „multi-kondičné“) zdôvodnenie alebo odlišné posúdenie ochorenia.</p>

<p><strong>Čo robiť:</strong> Sledovať, pri ktorých kombináciách diagnóz a pacientskych profiloch poisťovňa (plán) kryje liečbu, a pri zamietnutí sa nebáť znova overiť podmienky. Praktický apel: pýtať sa poisťovne či poskytovateľa krytia, či je možné získať liek pre konkrétneho pacienta, a neuzatvárať to po prvom zamietnutí.</p>

<h2>Zhrnutie pre nefrologickú prax</h2>

<p>Ak sa má CKM syndróm premeniť z konceptu do rutiny, rozhodujúce je prepojiť pracovné postupy (najmä skríning uACR), načasovanie intervencií (vrátane štádia 0) a mentálny model starostlivosti (od izolovaného prístupu „diagnóza za diagnózou“ ku kombinovanej, rizikovo riadenej terapii). V systéme, kde môžu byť prekážky v dostupnosti liečby, je dôležitá aj aktívna práca s úhradovými podmienkami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Lisa O’Mary, <em>5 Critical Mistakes Doctors Make in Managing CKM</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/5-critical-mistakes-doctors-make-managing-ckm-2026a1000keb" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
