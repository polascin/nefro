<?php
/**
 * add_antitromboticka-liecba-faktor-xi-bezpecnejsia-prevencia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_antitromboticka-liecba-faktor-xi-bezpecnejsia-prevencia_article.php"
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
    'title'        => 'Nové prístupy v antitrombotickej liečbe: od „dobrých“ a „zlých“ zrazenín k bezpečnejšej prevencii',
    'slug'         => 'antitromboticka-liecba-faktor-xi-bezpecnejsia-prevencia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Moderná antitrombotická liečba sa posúva od plošného zvyšovania intenzity, ktoré zvyšuje krvácanie, k cielenejšiemu zásahu do trombózy pri zachovaní hemostázy. Najväčšie očakávania sa viažu na inhibítory faktora XI (asundexián, milvexián) v sekundárnej prevencii cievnej mozgovej príhody aj pri fibrilácii predsiení.',
    'content'      => <<<'HTML'
<p>Antitrombotická liečba dlhodobo naráža na ten istý kompromis: čím účinnejšie potláčame tvorbu zrazenín, tým vyššie je riziko krvácania. Nasledujúci prehľad vychádza z odborného stretnutia venovaného moderným trendom v prevencii tromboembolických príhod. V centre diskusie stáli dve veľké témy — ako zlepšiť sekundárnu prevenciu cievnej mozgovej príhody najmä u pacientov bez fibrilácie predsiení a ako zvládnuť situácie, v ktorých sa v praxi stretáva potreba antikoagulácie pri fibrilácii predsiení s potrebou protidoštičkovej liečby po koronárnych výkonoch, pričom riziko krvácania výrazne limituje dlhodobú kombinovanú terapiu.</p>

<h2>Keď nerozhoduje fibrilácia predsiení, no riziko zrazenín treba aj tak liečiť</h2>

<p>Pri cievnej mozgovej príhode (CMP) treba najprv jednoznačne určiť typ príhody — ischemická verzus hemoragická — a mechanizmus jej vzniku. Z pohľadu klinickej praxe z toho vyplýva:</p>

<ul>
  <li>pri <strong>fibrilácii predsiení (FP)</strong> je kľúčová antikoagulačná liečba,</li>
  <li>pri <strong>nekardioembolickej</strong> príhode je dlhodobým základom <strong>protidoštičková (antiagregačná) liečba</strong>,</li>
  <li>skúšania s antikoagulanciami pri nekardioembolických príhodách v minulosti narážali na problém <strong>tolerability</strong> — riziko krvácania bolo z hľadiska bezpečnosti príliš vysoké.</li>
</ul>

<p>Typickú frustráciu ilustruje modelový pacient, ktorému príhoda recidivuje napriek protidoštičkovej liečbe. Hľadá sa riešenie, ktoré by znížilo riziko recidívy bez toho, aby výrazne zvýšilo riziko závažného krvácania.</p>

<h3>Faktor XI ako potenciálne „špecifickejší“ cieľ</h3>

<p>Práve preto sa veľa očakáva od <strong>inhibítorov faktora XI</strong>. Logika je nasledovná:</p>

<ul>
  <li>zrazenina vzniká súhrou <strong>aktivácie krvných doštičiek</strong> a následnej <strong>tvorby trombínu</strong>,</li>
  <li>protidoštičkové lieky zasahujú prevažne do časti súvisiacej s doštičkami,</li>
  <li>ak sa centrálna koagulačná dráha potláča plošne, ako pri niektorých klasických antikoagulanciách, znižuje sa zrážanlivosť aj tam, kde je potrebná na hojenie ciev, a preto rastie riziko krvácania,</li>
  <li>faktor XI sa prezentuje ako cieľ s výraznejšou väzbou na „škodlivú“ patologickú trombózu, ale s menším dosahom na mechanizmy potrebné pri reparácii cievnej steny.</li>
</ul>

<p>Prvé pozitívne údaje z 3. fázy v sekundárnej prevencii CMP — konkrétne štúdia s <strong>asundexiánom</strong> (OCEANIC-STROKE) — ukázali výrazné zníženie recidív, pričom sa nepozorovalo nadmerné zvýšenie krvácania vrátane krvácania do mozgu. Ďalšie výsledky sa očakávajú aj pri <strong>milvexiáne</strong> (LIBREXIA-STROKE).</p>

<h2>Fibrilácia predsiení + PCI + krvácanie: prečo je kombinovaná liečba taký problém</h2>

<p>Druhý modelový scenár spája viac rizík naraz:</p>

<ul>
  <li><strong>fibriláciu predsiení</strong>, ktorá vyžaduje antikoaguláciu,</li>
  <li><strong>stent po infarkte myokardu bez elevácie ST (NSTEMI)</strong>, ktorý typicky vyžaduje protidoštičkovú liečbu,</li>
  <li>a následne <strong>krvácanie z tráviaceho traktu</strong> (na podklade divertikulového ochorenia).</li>
</ul>

<p>V súlade s reálnou praxou platí, že tieto liečby možno kombinovať, no len na <strong>obmedzený čas</strong>, pretože riziko krvácania s dĺžkou kombinácie rastie.</p>

<h3>Ako vyzerá zásada deeskalácie</h3>

<p>Keď je potrebná antikoagulácia aj protidoštičková liečba zároveň, cieľom je:</p>

<ol>
  <li>krátkodobo nasadiť <strong>intenzívnejší režim</strong>, a potom</li>
  <li><strong>rýchlo deeskalovať</strong>, aby pacient dlhodobo nezostával vystavený neúmerne vysokému riziku krvácania.</li>
</ol>

<p>Všeobecný rámec, ktorý zaznel:</p>

<ul>
  <li>približne <strong>1 mesiac trojkombinácie</strong> (antikoagulancium + kyselina acetylsalicylová + inhibítor P2Y12; ako bezpečnejšia voľba do trojkombinácie sa najčastejšie uvádza <strong>klopidogrel</strong>),</li>
  <li>následne prechod na <strong>dvojkombináciu</strong> na ďalšie obdobie (v príklade približne 5 mesiacov),</li>
  <li>a napokon často návrat k <strong>samotnému perorálnemu antikoagulanciu (DOAC)</strong> — približne po 6 mesiacoch alebo neskôr — podľa ischemického aj krvácavého profilu pacienta.</li>
</ul>

<h3>Prečo sa v praxi často nedeeskaluje</h3>

<p>Najsilnejšia praktická výhrada smeruje k roztrieštenosti starostlivosti medzi jednotlivými odbornosťami:</p>

<ul>
  <li>intervenčný kardiológ sa prirodzene sústreďuje na riziko trombózy stentu a často nechce byť ten, kto protidoštičkovú liečbu skráti,</li>
  <li>lekár, ktorý vedie liečbu fibrilácie predsiení, rieši predovšetkým antikoaguláciu,</li>
  <li>žiadny zo špecialistov nechce prevziať zodpovednosť za včasné ukončenie protidoštičkovej liečby, a tak sa deeskalácia premešká.</li>
</ul>

<p>Práve preto niektorí pacienti zostávajú na <strong>príliš dlhej kombinácii</strong> troch liekov, čo zvyšuje výskyt krvácavých komplikácií.</p>

<h2>Krvácanie z tráviaceho traktu: ako postupovať, keď treba udržať antikoaguláciu</h2>

<p>V modelovom prípade sa po krvácaní pristúpilo k dočasnému prerušeniu rivaroxabanu, kým sa krvácanie nezastavilo, a po krátkom čase sa liečba obnovila. Dôležitý je dvojstupňový pohľad:</p>

<ul>
  <li><strong>konkrétny zdroj v tráviacom trakte</strong> môže byť spúšťačom (v príklade divertikulové ochorenie), ale</li>
  <li>u pacientov na antitrombotickej liečbe treba myslieť aj na <strong>ďalšie príčiny</strong> vrátane skrytých diagnóz (napríklad onkologické ochorenie) — neuspokojiť sa s prvým vysvetlením.</li>
</ul>

<h2>Inhibítory faktora XI pri fibrilácii predsiení: prečo nie všetky štúdie dopadli rovnako</h2>

<p>Pri perorálnych antikoagulanciách (DOAC) sa mechanizmy líšia len v detailoch, no celkovo pôsobia podobným smerom. Pri inhibícii faktora XI však môžu byť rozhodujúce:</p>

<ul>
  <li><strong>konkrétny liek</strong> (malá molekula verzus monoklonová protilátka),</li>
  <li><strong>dávka a sila zásahu</strong>,</li>
  <li>a najmä <strong>cieľová populácia</strong> a klinický kontext.</li>
</ul>

<p>Prebieha veľká štúdia s <strong>milvexiánom</strong> pri fibrilácii predsiení (LIBREXIA-AF), ktorá ho porovnáva s aktuálnym štandardom (komparátorom je apixabán) s cieľom preukázať lepšiu bezpečnosť pri zachovaní účinnosti. Treba dodať, že v čase prípravy tohto materiálu neboli dostupné niektoré najnovšie dáta, ktoré môžu interpretáciu vývoja v tejto oblasti ešte zmeniť.</p>

<h2>Ablácia a uzáver uška ľavej predsiene: znižujú riziko, no nie u každého na nulu</h2>

<p>Pri fibrilácii predsiení môžu <strong>katétrová ablácia</strong> alebo <strong>uzáver uška ľavej predsiene</strong> znížiť riziko cievnej mozgovej príhody. Často však zostáva <strong>reziduálne riziko</strong>:</p>

<ul>
  <li>u nízkorizikových pacientov môže byť rozumné liečbu obmedziť,</li>
  <li>u vysokorizikových pacientov môže byť riziko aj po výkone stále príliš vysoké.</li>
</ul>

<p>Z tejto logiky vyplýva význam bezpečnejšieho antikoagulancia: ak by nová liečba výrazne znížila riziko krvácania, mohla by posunúť hranicu, za ktorou pacient z antikoagulácie ešte profituje.</p>

<h2>Zhrnutie</h2>

<p>Smerovanie sa posúva od plošného zvyšovania intenzity, ktoré zvyšuje krvácanie, k stratégii, ktorá cieli trombózu účinnejšie a zároveň <strong>minimalizuje zásah do hemostázy</strong>. Najväčšie očakávania sa viažu na <strong>inhibítory faktora XI</strong> (asundexián, milvexián) v sekundárnej prevencii cievnej mozgovej príhody aj pri fibrilácii predsiení — predovšetkým u pacientov, u ktorých má kombinovaná terapia len krátke okno tolerability.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>New Pathways in Antithrombotic Therapy</em> (2026). <a href="https://www.medscape.org/viewarticle/new-pathways-antithrombotic-therapy-2026a1000gtd" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
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
