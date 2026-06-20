<?php
/**
 * add_c3-glomerulopatia-c3g-liecba-inhibicia-komplementu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_c3-glomerulopatia-c3g-liecba-inhibicia-komplementu_article.php"
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
    'title'        => 'Komplement 3 glomerulopatia (C3G): štandard starostlivosti, nešpecifická terapia a cielená inhibícia komplementu',
    'slug'         => 'c3-glomerulopatia-c3g-liecba-inhibicia-komplementu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Liečba komplement 3 glomerulopatie (C3G) podľa KDIGO 2021: od podpornej terapie (ACEi/ARB, MMF) cez terminálnu blokádu komplementu po cielenú inhibíciu alternatívnej dráhy – iptakopan a pegcetakoplan.',
    'content'      => <<<'HTML'
<p>U pacientov s <strong>komplement 3 glomerulopatiou (C3G)</strong> sa dlhodobo ťažko vytvára jednotný „štandard starostlivosti“, a to najmä pre <strong>relatívne nedávne vyčlenenie diagnózy</strong> a <strong>nedostatok randomizovaných kontrolovaných štúdií</strong>. KDIGO 2021 preto svoje odporúčania stavia prevažne na <strong>klinickej skúsenosti a expertnom konsenze</strong>, pričom dôkazy často pochádzajú z <strong>retrospektívnych kohortových štúdií</strong>.</p>

<p>Zároveň sa ukazuje, že C3G nie je jedna homogénna jednotka. <strong>C3G spojená s monoklonálnymi imunoglobulínmi</strong> je odlišná situácia, v ktorej majú prednosť postupy <strong>cielené na klon</strong> (clone-targeted); tento prehľad sa však venuje najmä širšiemu rámcu liečby C3G bez tejto špecifickej klonovej cesty.</p>

<h2>Nešpecifická a podporná terapia (KDIGO 2021)</h2>

<p>KDIGO 2021 kladie pri C3G dôraz na <strong>nešpecifické podporné stratégie</strong> podľa závažnosti ochorenia.</p>

<h3>Inhibítor ACE alebo ARB pre všetkých</h3>

<p>Inhibítory ACE (ACEi), prípadne blokátory receptorov pre angiotenzín (ARB), sú odporúčané <strong>pre všetkých pacientov</strong>.</p>

<h3>Možný prínos inhibítorov SGLT2</h3>

<p>Predbežné analýzy naznačujú, že <strong>inhibítory SGLT2</strong> môžu pomôcť pri <strong>znížení proteinúrie</strong>.</p>

<h3>Statíny a kontrola lipidov</h3>

<p>Odporúčajú sa aj konzervatívne kardiometabolické opatrenia vrátane <strong>statínovej liečby</strong> na kontrolu cholesterolu a LDL.</p>

<h3>Kedy pridať imunosupresiu</h3>

<p>Pri <strong>stredne ťažkom až ťažkom priebehu</strong> (v texte definovanom ako <strong>proteinúria &gt; 1 g/deň</strong> a zároveň buď <strong>hematúria</strong>, alebo <strong>pokles funkcie počas aspoň 6 mesiacov</strong>) KDIGO 2021 uvádza, že je možné začať <strong>imunosupresiu</strong>:</p>

<ul>
  <li><strong>mykofenolát mofetil (MMF) v kombinácii s glukokortikoidmi (kortikosteroidmi)</strong>.</li>
</ul>

<h3>Účinnosť je variabilná</h3>

<p>Účinnosť nešpecifických terapií na zlepšenie prežívania obličiek je <strong>variabilná a spravidla obmedzená</strong>. Vybrané výsledky z retrospektívnych kohort:</p>

<ul>
  <li>V jednej retrospektívnej kohorte (C3 glomerulonefritída [C3GN], n = 56; membranoproliferatívna glomerulonefritída I. typu [MPGN typ I], n = 49; choroba hustých depozitov [DDD], n = 29) bolo <strong>ACEi/ARB spojené s lepším prežívaním obličiek</strong> v <strong>univariačnej analýze</strong> (P &lt; 0,0001), zatiaľ čo <strong>imunosupresívna liečba (IST)</strong> v tejto analýze zreteľný prínos nepreukázala.</li>
  <li>V retrospektívnej kohorte C3G (n = 60) bola pravdepodobnosť prežitia obličiek <strong>výrazne lepšia</strong> pri <strong>MMF + IST</strong> oproti inej IST aj oproti liečbe bez IST.</li>
  <li>Iné kohorty ukazujú, že rozdiely medzi režimami (napríklad MMF vs. iná liečba než MMF vs. ACEi/ARB) nemusia byť konzistentné.</li>
</ul>

<p>Z materiálu vyplýva dôležitý praktický paradox: hoci sa MMF odporúča v natívnych obličkách, <strong>väčšina transplantovaných pacientov dostáva MMF v rámci základnej imunosupresie</strong>, a napriek tomu <strong>potransplantačná recidíva C3G pretrváva</strong> – čo podporuje potrebu <strong>cielených terapií meniacich mechanizmus ochorenia</strong>.</p>

<h2>Terminálna inhibícia komplementu: ekulizumab</h2>

<p>Keďže pri C3G zohráva úlohu komplementový systém, KDIGO 2021 zahŕňa ako možnosť <strong>terminálnu blokádu komplementu</strong> pomocou <strong>ekulizumabu</strong> u vybraných pacientov.</p>

<h3>Mechanizmus</h3>

<p>Ekulizumab blokuje štiepenie <strong>C5</strong> na úrovni <strong>C5 konvertázy</strong>. Zároveň <strong>neovplyvňuje patologickú hyperaktiváciu alternatívnej dráhy vyššie v kaskáde (upstream)</strong>.</p>

<h3>Kedy sa ekulizumab zvažuje</h3>

<p>Odporúčanie je konzervatívne:</p>

<ul>
  <li>najmä pri <strong>progredujúcom ochorení</strong>, ktoré <strong>nereaguje</strong> na iné terapie (zhoršenie funkcie a/alebo proteinúrie),</li>
  <li>a potenciálne vtedy, keď existujú dôkazy <strong>terminálnej aktivácie dráhy</strong>.</li>
</ul>

<h3>Výsledky sú heterogénne</h3>

<p>Účinnosť ekulizumabu je <strong>veľmi variabilná</strong>. Príklady z textu (série prípadov a štúdie):</p>

<ul>
  <li>V niektorých súboroch sa pozorovalo <strong>zníženie kreatinínu a/alebo proteinúrie</strong> u časti pacientov, zatiaľ čo iní nemali laboratórny efekt, ale zaznamenali histopatologické zmeny.</li>
  <li>Pri potransplantačnej recidíve sa v niektorých prípadoch po počiatočnej odpovedi objavil <strong>relaps</strong> po vysadení lieku a neodpoveď po opätovnom nasadení.</li>
  <li>V združených údajoch (retrospektívne kohorty a série prípadov, spolu 122 pacientov) bol ekulizumab spojený s <strong>nižšou mierou zlyhania štepov (33 %)</strong> než plazmaferéza (42 %) alebo rituximab (81 %). Materiál však zdôrazňuje veľkú variabilitu naprieč štúdiami.</li>
</ul>

<h2>Inhibícia C5aR1: avakopan (ACCOLADE)</h2>

<p>Alternatívou v terminálnej zložke je <strong>avakopan</strong> (inhibítor receptora C5aR1). Materiál uvádza výsledky fázy 2:</p>

<ul>
  <li>štúdia <strong>ACCOLADE</strong> (randomizovaná, dvojito zaslepená, placebom kontrolovaná),</li>
  <li>primárny cieľový ukazovateľ (skóre aktivity) nebol splnený,</li>
  <li>ani sekundárne miery účinnosti – vrátane <strong>histologického indexu chronickosti pri C3 glomerulopatii</strong>, <strong>UPCR (pomer bielkovín ku kreatinínu v moči)</strong> a <strong>eGFR</strong> – sa medzi skupinami významne nelíšili.</li>
</ul>

<h2>Inhibícia alternatívnej dráhy: iptakopan a pegcetakoplan</h2>

<p>Materiál logicky prechádza od terminálnej blokády k terapiám, ktoré zasahujú jadro patogenézy – <strong>alternatívnu dráhu (AP)</strong>.</p>

<h3>Iptakopan (inhibítor faktora B)</h3>

<p>Iptakopan je <strong>perorálny</strong> selektívny inhibítor zameraný na <strong>faktor B</strong> (kľúčový uzol alternatívnej dráhy).</p>

<p><strong>Fáza 2:</strong></p>

<ul>
  <li>v otvorenej štúdii s natívnou C3G aj s potransplantačnou recidívou došlo k <strong>45 % zníženiu UPCR</strong> v natívnej kohorte (primárny cieľový ukazovateľ; P = 0,0003) a k zníženiu <strong>skóre depozitov C3</strong> v potransplantačnej kohorte (−2,5; P = 0,03),</li>
  <li>v 12-mesačnom rozšírení sa uvádza stabilizácia, prípadne zlepšenie markerov funkcie (UPCR a eGFR).</li>
</ul>

<p><strong>Fáza 3 (APPEAR-C3G):</strong></p>

<ul>
  <li>74 pacientov, randomizácia na iptakopan 200 mg 2× denne oproti placebu, následne otvorené pokračovanie (open-label),</li>
  <li>primárny cieľový ukazovateľ: <strong>35,1 % redukcia 24-hodinového UPCR</strong> oproti placebu po 6 mesiacoch (P = 0,0014),</li>
  <li>kompozitný renálny cieľový ukazovateľ (≥ 50 % redukcia UPCR a zároveň ≤ 15 % pokles eGFR) mal <strong>7-násobne vyššiu pravdepodobnosť (odds)</strong> v ramene s iptakopanom,</li>
  <li>zmena eGFR po 6 mesiacoch: <strong>+1,3 ml/min/1,73 m²</strong> pri iptakopane oproti <strong>−0,9 ml/min/1,73 m²</strong> pri placebe,</li>
  <li>biomarkerové zmeny konzistentné s inhibíciou komplementu: napríklad <strong>vzostup sérového C3 (o 185 %)</strong>, pokles <strong>plazmatického sC5b-9 (−65,1 %)</strong> a pokles <strong>močového sC5b-9/kreatinín (−77,3 %)</strong>,</li>
  <li>rýchly nástup: účinok na proteinúriu sa uvádza približne do <strong>2 týždňov</strong>.</li>
</ul>

<p><strong>Bezpečnosť:</strong> v štúdii APPEAR-C3G je uvedená <strong>1 závažná pneumokoková infekcia</strong> pri iptakopane, bez meningokokového ochorenia v rámci opísaných udalostí.</p>

<h3>Pegcetakoplan (inhibítor C3 a C3b)</h3>

<p>Pegcetakoplan je <strong>subkutánne podávaný</strong> inhibítor viažuci sa na <strong>C3 a C3b</strong>, ktorý selektívne inhibuje ich štiepenie. Liek je schválený úradom FDA pre C3G a primárnu imunokomplexovú membranoproliferatívnu glomerulonefritídu (IC-MPGN).</p>

<p><strong>Fáza 2 (DISCOVERY; C3G, n = 8):</strong> po 48 týždňoch približne <strong>51 % redukcia 24-hodinového UPCR</strong>.</p>

<p><strong>Fáza 2 (NOBLE; potransplantačná recidíva C3G alebo IC-MPGN):</strong> pegcetakoplan v kombinácii s podpornou liečbou v randomizovanom usporiadaní; uvádza sa <strong>54 % redukcia proteinúrie</strong>.</p>

<p><strong>Fáza 3 (VALIANT):</strong></p>

<ul>
  <li>96 pacientov s C3G,</li>
  <li>po 26 týždňoch: <strong>67,3 % priemerná redukcia UPCR</strong> pri pegcetakoplane oproti <strong>+3,2 %</strong> pri placebe (rozdiel 68,3 %; P &lt; 0,0001),</li>
  <li>stabilizácia eGFR: zmena <strong>−1,6 ml/min</strong> pri pegcetakoplane oproti <strong>−7,9 ml/min</strong> pri placebe (nominálne P = 0,0322),</li>
  <li>bezpečnosť: <strong>3 pacienti</strong> mali závažné infekcie, pričom <strong>žiadna sa nepripísala opuzdreným (enkapsulovaným) baktériám</strong>.</li>
</ul>

<h2>Čo z toho vyplýva: do praxe a limity</h2>

<p>Z textu vyplýva praktický model uvažovania:</p>

<ol>
  <li><strong>Začínať podpornou liečbou</strong> (ACEi/ARB, kontrola rizík, konzervatívne opatrenia) a podľa závažnosti zvažovať aj <strong>MMF s kortikosteroidmi</strong>.</li>
  <li>Keď je priebeh <strong>progredujúci</strong> a odpoveď na nešpecifickú liečbu nedostatočná, KDIGO 2021 otvára priestor pre <strong>cielenú komplementovú terapiu</strong>.</li>
  <li>Najdôležitejší mechanistický posun smeruje k liekom blokujúcim <strong>alternatívnu dráhu</strong> (iptakopan, pegcetakoplan), pri ktorých sú výsledky (najmä proteinúria) konzistentnejšie než pri viacerých nešpecifických režimoch.</li>
  <li>Pri výbere „kto má dostať čo“ však stále narážame na limit: materiál výslovne uvádza, že <strong>kritériá vymedzujúce podskupinu s jasným prínosom terminálnej blokády</strong> nie sú spoľahlivo identifikované.</li>
</ol>

<h2>Záver</h2>

<p>C3G je terapeuticky náročná a liečba sa tradične opierala o nešpecifické stratégie s variabilnou účinnosťou na renálne prežívanie. Súčasný vývoj smeruje k tomu, že cieľom už nie je len tlmiť zápal, ale <strong>zasiahnuť mechanizmus komplementovej aktivácie</strong>. Najmä lieky zamerané na alternatívnu dráhu (iptakopan, pegcetakoplan) prinášajú v štúdiách významné zníženie proteinúrie a stabilizáciu eGFR, pričom biomarkery podporujú biologickú konzistentnosť inhibície komplementu. Zároveň platí, že dlhodobé renálne výsledky a presné „indikácie pre konkrétneho pacienta“ pri jednotlivých komplementových cestách si budú vyžadovať ďalšie triedenie dôkazov.</p>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD), 2026 (plný text). <a href="https://www.ajkd.org/article/S0272-6386(26)00828-0/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
