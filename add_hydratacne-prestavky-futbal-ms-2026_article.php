<?php
/**
 * add_hydratacne-prestavky-futbal-ms-2026_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: hydratačné prestávky vo futbale a medicína horúčavy.
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_hydratacne-prestavky-futbal-ms-2026_article.php"
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

$articles = [];

$articles[] = [
    'title'        => 'Hydratačné prestávky vo futbale: marketingový zásah alebo medicínska nevyhnutnosť?',
    'slug'         => 'hydratacne-prestavky-futbal-ms-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'FIFA na MS 2026 zaviedla trojminútové hydratačné prestávky v každom polčase. Pri horúčave nejde len o komfort, ale o prevenciu hypertermie, dehydratácie, hyponatriémie a AKI.',
    'content'      => <<<'HTML'
<p>FIFA na majstrovstvách sveta vo futbale 2026 zaviedla trojminútové hydratačné prestávky uprostred každého polčasu. Na prvý pohľad ide o organizačný detail, ktorý prerušuje plynulosť hry a prirodzene vyvoláva otázky o taktike, televíznom priestore a komerčnom využití. Z medicínskeho hľadiska však nejde o kozmetickú úpravu pravidiel. Pri kombinácii tepla, vlhkosti, slnečného žiarenia, cestovania a vysokej intenzity výkonu ide o racionálne preventívne opatrenie.</p>

<p>Oficiálne pravidlo FIFA stanovuje prestávku v každom zápase bez ohľadu na konkrétne počasie alebo typ štadióna. Hra sa prerušuje približne v 22. minúte prvého polčasu a v 67. minúte zápasu, teda uprostred druhého polčasu. Prestávka trvá tri minúty „od hvizdu po hvizd“ a čas sa pripočítava k nadstaveniu. Tento jednotný prístup má zabezpečiť rovnaké podmienky pre všetky tímy, ale jeho zdravotný význam je najväčší práve v horúcom a vlhkom prostredí.</p>

<h2>Prečo je turnaj 2026 medicínsky náročnejší</h2>

<p>Majstrovstvá sveta 2026 sa hrajú v Kanade, Mexiku a Spojených štátoch amerických. Hostiteľské mestá sú rozložené na veľkej geografickej ploche a jednotlivé zápasy sa môžu líšiť teplotou, vlhkosťou, nadmorskou výškou, znečistením ovzdušia, alergénmi aj cestovnou záťažou.</p>

<p>Prehľad v časopise <em>Sports Medicine</em> upozorňuje, že tento turnaj predstavuje mimoriadnu kombináciu environmentálnych faktorov. Historické hodnoty indexu WBGT v čase turnaja sa v hostiteľských mestách pohybujú od približne 18,8 °C do 29,4 °C, pričom maximá môžu dosahovať približne 21 °C až 35 °C. Štrnásť zo šestnástich hostiteľských miest máva v júni a júli dni, ktoré presahujú 28 °C WBGT.</p>

<p>WBGT, teda <em>wet-bulb globe temperature</em>, je pre šport praktickejší ukazovateľ než samotná teplota vzduchu. Zohľadňuje teplotu, vlhkosť, sálavé teplo zo slnka a prúdenie vzduchu. Preto lepšie odráža skutočnú tepelnú záťaž organizmu.</p>

<h2>Čo sa deje pri výkone v horúčave</h2>

<p>Pri intenzívnom futbalovom výkone vzniká veľké množstvo metabolického tepla. Organizmus sa ho snaží odvádzať potením a zvýšeným prietokom krvi cez kožu. Tieto mechanizmy však majú svoje limity. Pri vysokej vlhkosti sa pot horšie odparuje. Pri silnom slnečnom žiarení a vysokej teplote okolia sa znižuje schopnosť tela odovzdávať teplo do prostredia.</p>

<p>Dôsledkom môže byť:</p>

<ul>
  <li>pokles výkonnosti,</li>
  <li>zhoršenie koordinácie a rozhodovania,</li>
  <li>svalové kŕče,</li>
  <li>dehydratácia,</li>
  <li>vyčerpanie z tepla,</li>
  <li>hypertermia,</li>
  <li>námahový úpal,</li>
  <li>porucha vedomia,</li>
  <li>v krajnom prípade život ohrozujúci stav.</li>
</ul>

<p>Strata tekutín zodpovedajúca približne 2 % telesnej hmotnosti už môže zhoršiť výkon, presnosť pohybu a schopnosť rýchlo reagovať. Pri ďalšom zhoršovaní hydratácie rastie kardiovaskulárna záťaž a zvyšuje sa riziko kolapsu.</p>

<h2>Dehydratácia nie je jediný problém</h2>

<p>V populárnej diskusii sa často používa jednoduchá rovnica: horúčava znamená dehydratáciu a riešením je piť viac vody. Medicínsky je situácia zložitejšia. Športovec môže byť ohrozený nielen nedostatkom tekutín, ale aj nevhodnou hydratáciou.</p>

<p>Pri výkone v horúčave treba myslieť najmä na:</p>

<ul>
  <li>dehydratáciu,</li>
  <li>hypertermiu,</li>
  <li>hyponatriémiu spojenú s výkonom,</li>
  <li>poruchu termoregulácie,</li>
  <li>kolaps z tepla,</li>
  <li>rabdomyolýzu,</li>
  <li>akútne poškodenie obličiek.</li>
</ul>

<p>Hyponatriémia vzniká vtedy, keď príjem voľnej vody neprimerane prevýši straty sodíka a schopnosť organizmu vodu vylúčiť. U športovcov sa môže prejaviť bolesťou hlavy, nauzeou, zmätenosťou, kŕčmi a pri ťažkých formách edémom mozgu. Dobrá prevencia preto nie je bezhlavé pitie veľkého množstva vody, ale plánovaná hydratácia podľa podmienok, trvania záťaže, potenia, telesnej hmotnosti, aklimatizácie a dostupnosti elektrolytov.</p>

<h2>Nefrologický pohľad: akútne poškodenie obličiek</h2>

<p>Z pohľadu nefrológa je dôležité, že extrémny výkon v horúčave môže viesť k akútnemu poškodeniu obličiek aj u inak zdravého človeka. Mechanizmy sú viaceré a často sa kombinujú.</p>

<p>Pri dehydratácii klesá efektívny cirkulujúci objem a znižuje sa renálna perfúzia. Aktivuje sa sympatikus a renín-angiotenzín-aldosterónový systém. Ak sa pridá hypertermia, vysoká intenzita výkonu a svalové poškodenie, môže vzniknúť rabdomyolýza s myoglobinúriou. Myoglobín následne poškodzuje tubuly, najmä pri hypovolémii a acidóze.</p>

<p>Profesionálni hráči majú kvalitný medicínsky dohľad, monitorovanie a individualizovanú prípravu. Riziko preto nie je rovnaké ako u rekreačného športovca bez dozoru. Nie je však nulové. Práve extrémna intenzita výkonu, tlak na výsledok a opakované zápasy v krátkom čase môžu preťažiť kompenzačné mechanizmy.</p>

<h2>Čo reálne umožní trojminútová prestávka</h2>

<p>Hydratačná prestávka nie je iba okamih na vypitie vody. Z medicínskeho hľadiska dáva tímu krátke okno na zníženie tepelnej a kardiovaskulárnej záťaže, doplnenie tekutín, použitie chladiacich postupov a rýchle klinické zhodnotenie hráčov.</p>

<p>Počas prestávky možno:</p>

<ul>
  <li>doplniť tekutiny,</li>
  <li>podať nápoj s elektrolytmi podľa individuálnej potreby,</li>
  <li>použiť chladené uteráky, ľadové obklady alebo iné chladiace postupy,</li>
  <li>posúdiť známky prehriatia, únavy alebo dezorientácie,</li>
  <li>skontrolovať hráča po predchádzajúcom kontakte alebo kŕčoch,</li>
  <li>krátko upraviť záťaž a taktické pokyny.</li>
</ul>

<p>Niektorí odborníci upozorňujú, že tri minúty môžu byť pri vysokej tepelnej záťaži málo, najmä ak má prestávka slúžiť nielen na pitie, ale aj na efektívne ochladenie. To je legitímna odborná diskusia. Otázka teda neznie, či prestávky majú medicínsky zmysel, ale či sú v konkrétnych podmienkach dostatočne dlhé a správne využité.</p>

<h2>Môžu prestávky hráčom uškodiť?</h2>

<p>Argument, že krátke prerušenie hry naruší rytmus hráča, má športovo-taktický význam. Medicínsky je však slabší než argument bezpečnosti. Pri rastúcej tepelnej záťaži je riziko pokračovania v intenzívnom výkone väčšie než riziko krátkej kontrolovanej prestávky.</p>

<p>Teoretický problém by vznikol vtedy, ak by hráč počas prestávky naraz vypil neprimerane veľké množstvo čistej vody bez elektrolytov, alebo ak by sa chladenie použilo nesystematicky. V profesionálnom tíme je toto riziko nízke, pretože hydratáciu a chladenie riadi športový lekár, fyziológ a kondičný tím.</p>

<h2>Aklimatizácia je viac než prestávka</h2>

<p>Hydratačná prestávka je iba jedna vrstva prevencie. Kľúčová je aklimatizácia na teplo. Opakovaná kontrolovaná expozícia tepelnému stresu vedie k skoršiemu nástupu potenia, efektívnejšiemu odvodu tepla, nižšej tepovej frekvencii pri rovnakej záťaži a lepšiemu udržaniu plazmatického objemu.</p>

<p>Tímy hrajúce v rôznych klimatických podmienkach a nadmorských výškach musia plánovať prípravu veľmi presne. Nestačí prísť na zápas kondične pripravený. Organizmus musí byť pripravený na konkrétne prostredie, v ktorom sa bude hrať.</p>

<h2>Nadmorská výška, cestovanie a ďalšie faktory</h2>

<p>Environmentálne riziko MS 2026 nevytvára iba horúčava. Zápasy v Guadalajare a Mexico City prebiehajú v nadmorskej výške približne 1566 m a 2240 m. Takéto podmienky môžu ovplyvniť ventiláciu, hydratáciu, výkon pri opakovaných šprintoch a regeneráciu.</p>

<p>Do celkovej záťaže sa pridáva cestovanie, časové posuny, únava, rozdielne klimatické prostredie, sezónne alergény a kvalita ovzdušia. Tieto faktory môžu samostatne znížiť výkonnosť, ale najväčší problém vzniká pri ich kumulácii.</p>

<h2>Ponaučenie mimo profesionálneho futbalu</h2>

<p>Hoci sa diskusia začala pri MS 2026, jej posolstvo je širšie. Platí pre amatérsky šport, školské turnaje, behy, cyklistiku, prácu v exteriéri aj rekreačnú aktivitu počas horúčav.</p>

<p>Najrizikovejší nemusí byť profesionálny športovec s lekárskym tímom. Často je to človek bez medicínskeho dohľadu, ktorý podcení teplo, nerozpozná príznaky prehriatia a snaží sa „vydržať“. Riziko je vyššie u detí, seniorov, pacientov s hypertenziou, diabetom, chronickou chorobou obličiek, srdcovým zlyhávaním a u ľudí užívajúcich diuretiká, inhibítory RAAS, betablokátory, anticholinergiká alebo nesteroidové antiflogistiká.</p>

<h2>Praktické odporúčania pre šport v horúčave</h2>

<p>Pri výkone vo vysokých teplotách má zmysel:</p>

<ul>
  <li>sledovať nielen teplotu vzduchu, ale aj vlhkosť, slnečné žiarenie a vietor,</li>
  <li>brať do úvahy WBGT, ak je dostupný,</li>
  <li>obmedziť intenzitu záťaže pri vysokej tepelnej záťaži,</li>
  <li>plánovať prestávky, tieň a chladenie,</li>
  <li>piť primerane, nie nadmerne,</li>
  <li>pri dlhšej záťaži dopĺňať sodík podľa podmienok a potenia,</li>
  <li>vyhýbať sa alkoholu a zbytočne diuretickým nápojom pred výkonom,</li>
  <li>neignorovať bolesť hlavy, zimnicu, dezorientáciu, kŕče, závrat alebo nauzeu,</li>
  <li>pri podozrení na námahový úpal okamžite prerušiť výkon a začať intenzívne chladenie,</li>
  <li>u rizikových osôb zvážiť konzultáciu s lekárom pred záťažou v horúčave.</li>
</ul>

<h2>Limity zdrojov</h2>

<p>Zdrojový článok Medscape má publicisticko-edukačný charakter a vychádza najmä z rozhovoru s odborníkom. Nejde o pôvodnú klinickú štúdiu. Jeho hlavné tvrdenia však zodpovedajú oficiálnej komunikácii FIFA a podporuje ich otvorený prehľad v časopise <em>Sports Medicine</em>, ktorý analyzuje environmentálne riziká MS 2026.</p>

<p>V dostupnom zobrazení článku Medscape nebol spoľahlivo uvedený samostatný autor článku. Preto ho neuvádzam ako pôvodného autora a ani nepriraďujem citovaného odborníka k autorom zdrojového textu.</p>

<h2>Záver</h2>

<p>Hydratačné prestávky na MS 2026 majú jasný medicínsky zmysel. Áno, môžu ovplyvniť rytmus hry a dávajú trénerom krátke taktické okno. To však neznamená, že sú iba marketingovým zásahom. Pri očakávanej kombinácii tepla, vlhkosti, slnečného žiarenia, nadmorskej výšky a cestovnej záťaže sú rozumnou súčasťou ochrany zdravia hráčov.</p>

<p>Z nefrologického pohľadu je dôležité vnímať výkon v horúčave ako situáciu s potenciálnym rizikom akútneho poškodenia obličiek, najmä pri hypovolémii, rabdomyolýze alebo nevhodnej hydratácii. Prestávky, aklimatizácia, chladenie a individuálne riadená hydratácia nie sú prejavom slabosti športovca. Sú súčasťou modernej medicíny výkonu.</p>

<hr>

<p><em><strong>Zdroje:</strong> FIFA. Players to benefit from hydration breaks at FIFA World Cup 2026™. Publikované 7. decembra 2025. <a href="https://inside.fifa.com/organisation/news/hydration-breaks-world-cup-2026-player-welfare" target="_blank" rel="noopener noreferrer">inside.fifa.com</a>. Esh CJ, Carter S, Bougault V, et al. The 2026 Men’s FIFA Football World Cup: Evidence-Based Guidelines to Protect Player Health and Performance from Environmental Challenges. <em>Sports Medicine</em>. 2026;56:1337–1361. DOI: <a href="https://doi.org/10.1007/s40279-026-02398-4" target="_blank" rel="noopener noreferrer">10.1007/s40279-026-02398-4</a>. Medscape. New Hydration Breaks in Soccer: A Real Necessity? 2026. <a href="https://www.medscape.com/viewarticle/new-hydration-breaks-soccer-real-necessity-2026a1000mzj" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
