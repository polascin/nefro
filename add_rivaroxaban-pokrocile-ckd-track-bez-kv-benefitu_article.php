<?php
/**
 * add_rivaroxaban-pokrocile-ckd-track-bez-kv-benefitu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_rivaroxaban-pokrocile-ckd-track-bez-kv-benefitu_article.php"
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
    'title'        => 'Nízka dávka rivaroxabanu pri pokročilom CKD nepriniesla kardiovaskulárny benefit',
    'slug'         => 'rivaroxaban-pokrocile-ckd-track-bez-kv-benefitu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia TRACK ukázala, že nízkodávkovaný rivaroxaban 2,5 mg dvakrát denne neznížil výskyt veľkých kardiovaskulárnych príhod u pacientov s pokročilým CKD ani u dialyzovaných, no zvýšil riziko závažného krvácania. Pokročilé CKD nie je len ďalší rizikový faktor — je to samostatný klinický kontext.',
    'content'      => <<<'HTML'
<p>Pacienti s pokročilým chronickým ochorením obličiek majú vysoké kardiovaskulárne riziko. Zároveň však majú aj vysoké riziko krvácania. Práve táto kombinácia robí preventívnu antikoagulačnú liečbu mimoriadne citlivou témou. Výsledky štúdie TRACK ukazujú, že dôkazy z bežnej kardiologickej populácie nemožno automaticky prenášať na pacientov s pokročilým CKD alebo na dialyzovaných pacientov.</p>

<p>V štúdii TRACK nízka dávka rivaroxabanu 2,5 mg dvakrát denne neznížila výskyt veľkých kardiovaskulárnych príhod u pacientov s CKD 4. až 5. štádia alebo so zlyhaním obličiek vyžadujúcim dialýzu. Naopak, liečba bola spojená s vyšším rizikom závažného krvácania.</p>

<p>Ide o dôležitý výsledok. Nie preto, že by definitívne uzatváral otázku antikoagulačnej liečby u pacientov s pokročilým CKD, ale preto, že upozorňuje na potrebu samostatných dát pre túto populáciu.</p>

<h2>Čo skúmala štúdia TRACK</h2>

<p>TRACK bola veľká randomizovaná štúdia publikovaná v časopise <em>JAMA</em> a prezentovaná na kongrese European Renal Association v Glasgowe.</p>

<p>Do štúdie boli zaradení dospelí pacienti s pokročilým chronickým ochorením obličiek, teda s odhadovanou glomerulárnou filtráciou ≤ 29 ml/min/1,73 m², alebo pacienti so zlyhaním obličiek závislí od dialýzy. Zároveň išlo o osoby so zvýšeným kardiovaskulárnym rizikom. Riziko bolo definované prítomnosťou ischemickej choroby srdca, periférneho artériového ochorenia, diabetu, anamnézy nehemoragickej a nelakunárnej cievnej mozgovej príhody alebo vekom 65 rokov a viac.</p>

<p>Pacienti boli randomizovaní na rivaroxaban 2,5 mg dvakrát denne alebo placebo. Primárny kombinovaný cieľ zahŕňal kardiovaskulárne úmrtie, nefatálny infarkt myokardu, cievnu mozgovú príhodu alebo príhodu súvisiacu s periférnym artériovým ochorením.</p>

<h2>Výsledok: bez kardiovaskulárneho prínosu</h2>

<p>Po mediáne sledovania 1,7 roka sa primárny kombinovaný cieľ vyskytol u 22,6 % pacientov v skupine s rivaroxabanom a u 20,7 % pacientov v placebovej skupine.</p>

<p>Hazard ratio bolo 1,09, s 95 % intervalom spoľahlivosti 0,87 až 1,36 a hodnotou <em>P</em> = 0,46. To znamená, že štúdia nepreukázala zníženie rizika veľkých kardiovaskulárnych príhod pri podávaní nízkodávkovaného rivaroxabanu.</p>

<p>Nezistil sa ani priaznivý rozdiel v sekundárnych cieľoch vrátane celkovej mortality. Úmrtie z akejkoľvek príčiny sa vyskytlo u 25,6 % pacientov liečených rivaroxabanom a u 23,0 % pacientov v placebovej skupine.</p>

<p>Výsledok je klinicky významný, pretože rivaroxaban v nízkej dávke priniesol prínos v iných populáciách s vysokým kardiovaskulárnym rizikom. V štúdiách COMPASS a VOYAGER PAD kombinácia nízkodávkovaného rivaroxabanu s aspirínom znížila ischemické príhody u pacientov s koronárnym alebo periférnym artériovým ochorením. TRACK však ukazuje, že pacienti s pokročilým CKD nie sú jednoducho „rovnakí pacienti s vyšším rizikom“.</p>

<h2>Krvácanie bolo častejšie</h2>

<p>Najväčším praktickým problémom bol nárast závažného krvácania. V skupine s rivaroxabanom sa veľké krvácanie vyskytlo u 8,8 % pacientov, zatiaľ čo v placebovej skupine u 6,0 % pacientov.</p>

<p>To zodpovedalo približne 1,7 dodatočnej udalosti na 100 osoborokov. Hazard ratio bolo 1,51, 95 % interval spoľahlivosti 1,02 až 2,22 a <em>P</em> = 0,04.</p>

<p>Zaujímavý bol aj vekový rozdiel. U pacientov vo veku 65 rokov a viac bolo krvácanie pri rivaroxabane výraznejšie zvýšené než u mladších pacientov. V staršej skupine sa veľké krvácanie vyskytlo u 10 % pacientov liečených rivaroxabanom oproti 5,6 % pri placebe. U mladších pacientov bol rozdiel menší, 7,3 % oproti 6,4 %.</p>

<p>Tento nález podporuje opatrnosť najmä u starších pacientov s pokročilým CKD, kde sa často kumuluje viac rizikových faktorov krvácania.</p>

<h2>Prečo nestačí extrapolovať dáta z kardiológie</h2>

<p>Pacienti s pokročilým CKD boli z veľkých kardiovaskulárnych štúdií často systematicky vylučovaní. V praxi sa potom niekedy používali výsledky zo všeobecných kardiologických populácií ako základ pre rozhodovanie aj u pacientov so závažným poškodením funkcie obličiek.</p>

<p>To je slabé miesto. Patofyziológia aterotrombózy, krvácania, vaskulárnej kalcifikácie, zápalu, urémie, porúch trombocytov a farmakokinetiky liekov je pri pokročilom CKD odlišná. Rivaroxaban sa navyše čiastočne eliminuje obličkami, takže bezpečnosť dávkovania pri pokročilom CKD nemusí byť porovnateľná s populáciou bez závažného renálneho poškodenia.</p>

<p>Vyjadrenie autorov štúdie smeruje k tomu, že rozhodovanie o antikoagulačnej liečbe u týchto pacientov má vychádzať z absolútneho rizika, nie z automatického prenášania dôkazov z iných kohort.</p>

<h2>Čo štúdia neznamená</h2>

<p>TRACK neznamená, že antikoagulácia nemá miesto u pacientov s pokročilým CKD. To by bola nesprávna interpretácia.</p>

<p>Výsledky sa týkajú preventívneho použitia nízkodávkovaného rivaroxabanu na zníženie kardiovaskulárneho rizika u pacientov s pokročilým CKD alebo dialyzačným zlyhaním obličiek. Netýkajú sa automaticky pacientov, ktorí majú jasnú indikáciu na antikoagulačnú liečbu, napríklad prevenciu cievnej mozgovej príhody pri fibrilácii predsiení alebo liečbu venózneho tromboembolizmu.</p>

<p>Na toto upozornili aj autori sprievodného editorialu v <em>JAMA</em>. Podľa nich štúdia nezatvára dvere antikoagulácii v tejto populácii, ale skôr ukazuje, že treba klásť presnejšie otázky: ktorí pacienti môžu profitovať, aká stratégia je bezpečnejšia a či existujú podskupiny s priaznivejším pomerom prínosu a rizika.</p>

<h2>Limity štúdie</h2>

<p>Štúdia TRACK bola ukončená predčasne. Namiesto plánovaných 1900 pacientov zaradila 1458 pacientov v 90 centrách v 12 krajinách. To znižuje štatistickú silu na zachytenie menšieho prínosu alebo rozdielov v podskupinách.</p>

<p>Ďalším limitom bolo, že takmer tretina pacientov v skupine s rivaroxabanom predčasne a natrvalo ukončila liečbu, najčastejšie pre preferenciu pacienta alebo bezpečnostné dôvody. To mohlo oslabiť schopnosť štúdie zachytiť prípadný liečebný signál.</p>

<p>Otázkou zostáva aj heterogenita v užívaní aspirínu. V štúdii COMPASS samotný rivaroxaban nepreukázal benefit, zatiaľ čo kombinácia rivaroxabanu s aspirínom áno. V TRACK užívala aspirín na začiatku iba približne polovica pacientov. Subanalýzy síce neukázali jasný rozdiel podľa bazálneho užívania aspirínu, ale testovanie tejto interakcie malo obmedzenú silu.</p>

<h2>Praktický odkaz pre klinickú prax</h2>

<p>U pacientov s pokročilým CKD alebo dialyzačným zlyhaním obličiek nemožno nízkodávkovaný rivaroxaban používať ako jednoduchú preventívnu stratégiu na zníženie kardiovaskulárnych príhod len preto, že fungoval v iných vysokorizikových populáciách.</p>

<p>V štúdii TRACK nepriniesol kardiovaskulárny benefit a zvýšil riziko závažného krvácania. Klinické rozhodovanie preto musí byť individuálne, s dôrazom na absolútne riziko ischemických príhod, riziko krvácania, vek, dialyzačný stav, komorbidity, súbežnú antiagregačnú liečbu a konkrétnu indikáciu antikoagulácie.</p>

<p>Najdôležitejší záver je jednoduchý: pokročilé CKD nie je len ďalší rizikový faktor. Je to samostatný klinický kontext, v ktorom treba mať vlastné dôkazy.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Direct Oral Anticoagulant Flops for Prevention in Advanced CKD</em> (2026). <a href="https://www.medscape.com/viewarticle/direct-oral-anticoagulant-flops-prevention-advanced-ckd-2026a1000itm" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
