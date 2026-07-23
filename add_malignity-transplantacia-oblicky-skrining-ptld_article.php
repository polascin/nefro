<?php
/**
 * add_malignity-transplantacia-oblicky-skrining-ptld_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_malignity-transplantacia-oblicky-skrining-ptld_article.php"
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
    'title'        => 'Malignity a transplantácia obličky: čo by mal vedieť nefrológ (Core Curriculum 2026)',
    'slug'         => 'malignity-transplantacia-oblicky-skrining-ptld',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dlhodobá imunosupresia po transplantácii obličky zvyšuje riziko viacerých nádorov — najmä nemelanómových kožných karcinómov, lymfoproliferácií viazaných na EBV (PTLD) a vybraných solídnych nádorov. Praktický prehľad skríningu, prevencie a manažmentu podľa Core Curriculum 2026 (AJKD), vrátane ambulantného checklistu pre kandidátov aj príjemcov transplantátu.',
    'content'      => <<<'HTML'
<p>Transplantácia obličky je najefektívnejšia liečba pokročilého chronického ochorenia obličiek, no zároveň ide o stav s dlhodobou imunosupresiou. Tá zvyšuje riziko viacerých nádorov, špecificky nemelanómových kožných karcinómov, lymfoproliferácií súvisiacich s vírusmi (najmä EBV) a niektorých solídnych nádorov. V roku 2026 prinieslo AJKD Core Curriculum, ktoré zhŕňa, ako prakticky pristupovať k skríningu, prevencii a manažmentu nádorových komplikácií u kandidátov a príjemcov transplantátu.</p>

<h2>1) Prečo je onkologické riziko po transplantácii vyššie</h2>

<p>Kombinácia dlhodobej imunosupresie a častejších chronických komorbidít vedie k:</p>

<ul>
  <li>zníženému imunitnému dohľadu,</li>
  <li>vyššiemu riziku infekcií onkogénnymi vírusmi,</li>
  <li>vyššiemu výskytu viacerých malignít (vrátane kožných a lymfoproliferatívnych).</li>
</ul>

<p>V prehľade sa uvádza, že príjemcovia obličkového transplantátu majú približne <strong>2- až 4-násobne vyššie riziko rakoviny</strong> než všeobecná populácia a nádorové ochorenie je <strong>druhou najčastejšou príčinou úmrtia</strong> — za infekciami a kardiovaskulárnymi ochoreniami.</p>

<h2>2) Skríning rakoviny pred transplantáciou a po nej: viac rizika, ale aj viac pascí</h2>

<p>Core Curriculum zdôrazňuje, že skríning u kandidátov má primárne zmysel identifikovať „skrytú“ malignitu ešte pred začiatkom imunosupresie. Väčšina odporúčaní sa však v praxi opiera o skríningové schémy všeobecnej populácie (prsník, krčok maternice, kolorektum, pľúca).</p>

<p>Zároveň sa opakovane pripomína rovnováha:</p>

<ul>
  <li>skorší záchyt môže teoreticky zlepšiť výsledky,</li>
  <li>no u príjemcov transplantátu (KTR) pribúdajú konkurenčné riziká (infekcie, kardiovaskulárne udalosti),</li>
  <li>hrozí nadmerné vyšetrovanie, úzkosť, nadmerná diagnostika (overdiagnosis) a nadmerná liečba (overtreatment).</li>
</ul>

<h3>Praktické rámce skríningu (ako ich opisuje prehľad)</h3>

<ul>
  <li><strong>Prostata:</strong> odporúčania zostávajú skôr v intenciách všeobecných guidelineov, keďže benefit a dopad na mortalitu nie sú úplne jednoznačné a nadmerný skríning môže byť bariérou pri zaraďovaní na čakaciu listinu.</li>
  <li><strong>Koža:</strong> tu ide skôr o „posilnený“ (enhanced) prístup než len o štandard.</li>
  <li><strong>Renálny karcinóm (RCC) a urotel:</strong> pri rizikových skupinách sa zvažuje ultrazvuk a/alebo cytológia moču v intervaloch uvedených v prehľade (často sa uvádza 1 až 3 roky pred transplantáciou; konkrétne frekvencie sa medzi guidelinemi líšia; spomína sa aj nesúhlas s rutinným ročným ultrazvukom po transplantácii v stanovisku EAU).</li>
  <li><strong>Krčok maternice (cervix):</strong> prehľad zdôrazňuje, že väčšina odporúčaní po transplantácii smeruje k častejšiemu skríningu oproti všeobecnej populácii (v článku sa spomína približovanie k frekvencii odporúčanej pri HIV).</li>
</ul>

<p><strong>Kľúčový odkaz:</strong> skríning má byť <strong>individualizovaný podľa rizika, komorbidít a očakávanej dĺžky života</strong>, nie mechanicky „všetko a vždy“.</p>

<h2>3) Onkogénne vírusy a očkovanie: prevencia, ktorú treba načasovať</h2>

<p>V prehľade sa vírusy spájajú so zvýšeným výskytom viacerých nádorov (napr. EBV pri lymfoproliferáciách, HPV pri anogenitálnych nádoroch a časti nádorov hlavy a krku, HBV pri hepatocelulárnom karcinóme). Očkovanie má byť preventívnou stratégiou, nie až „dolepovaním“ po transplantácii.</p>

<p>Dôležité praktické body:</p>

<ul>
  <li><strong>Očkovať treba ideálne ešte v predtransplantačnej fáze</strong>, kým imunosupresia neoslabí odpoveď na vakcínu.</li>
  <li>Ak sa očkuje <strong>po transplantácii</strong>, prehľad odporúča počkať <strong>minimálne 3 mesiace po transplantácii</strong>.</li>
  <li><strong>Živým vakcínam sa treba u pacientov na imunosupresii vyhnúť.</strong></li>
</ul>

<p><em>(Konkrétne vakcíny a schémy sú podrobne rozpracované v samostatnom prehľade pre CKD a transplantovaných; tento článok tu rámuje najmä princíp načasovania a bezpečnosti.)</em></p>

<h2>4) Kožné nádory: najčastejšia malignita po transplantácii</h2>

<p>Kožné nádory sú po transplantácii solídnych orgánov dominantné, pričom sa v článku uvádza výrazne vyššia kumulatívna incidencia nemelanómových kožných karcinómov v porovnaní so všeobecnou populáciou.</p>

<p>Pre prax sú najdôležitejšie tri veci:</p>

<ol>
  <li><strong>Prevencia UV žiarenia:</strong> účinné používanie opaľovacích krémov (v texte sa spomína SPF 30+ a vyššie) a režim ochrany pred UV.</li>
  <li><strong>Pravidelná dermatologická kontrola:</strong> každoročné celotelové vyšetrenie kože vrátane oblastí ako ústna dutina a genito-análna oblasť.</li>
  <li><strong>Režim imunosupresie:</strong> v prehľade sa výslovne uvádza, že <strong>azatioprín urýchľuje karcinogenézu nemelanómových kožných nádorov</strong> cez mechanizmy poškodenia DNA a jej opravy po UV. Pri recidívach sa preto často pristupuje k zníženiu imunosupresie a k prerušeniu antimetabolitov (mykofenolát/azatioprín) alebo ku <strong>konverzii na inhibítory mTOR</strong> (sirolimus/everolimus) — pričom treba zvážiť potenciálne zvýšené riziko kardiovaskulárnej mortality.</li>
</ol>

<p>V kapitole sa riešia aj špecifiká melanómu a zriedkavej, no agresívnej Merkelovej bunkovej rakoviny (MCC), vrátane princípu, že pri MCC je základom redukcia imunosupresie a pri liečbe sa zohľadňuje pomer rizika a prínosu imunoterapie.</p>

<h2>5) PTLD: EBV, skríning, diagnostika a prvá línia liečby</h2>

<p>Posttransplantačné lymfoproliferatívne poruchy (PTLD) sú spektrom abnormalít viazaných na imunosupresiu, často poháňaných EBV. V článku sa uvádza:</p>

<ul>
  <li>vyššie riziko u EBV-séronegatívnych príjemcov,</li>
  <li>časová dynamika: EBV virémia typicky vzniká približne medzi 2. a 4. mesiacom po transplantácii,</li>
  <li>diagnosticky aj prognosticky je dôležité rozlíšiť typ PTLD podľa klasifikácie WHO 2022.</li>
</ul>

<h3>Monitorovanie EBV PCR (ako je popísané)</h3>

<p>U EBV-séronegatívneho príjemcu sa odporúča surveillance EBV PCR:</p>

<ul>
  <li>každých <strong>7 až 14 dní</strong> počas prvého mesiaca,</li>
  <li>následne každých <strong>28 dní</strong> do konca prvých 6 mesiacov,</li>
  <li>potom každé <strong>3 až 6 mesiacov</strong> do 1 roka, pokiaľ je pacient avirémický.</li>
</ul>

<p>Pri príznakoch pripomínajúcich infekčnú mononukleózu alebo pri podozrení na PTLD sa testovanie spravidla rozšíri aj nad rámec rutiny.</p>

<h3>Diagnostika PTLD</h3>

<p>Článok zdôrazňuje, že nestačí „len vylúčiť infekciu“. Diagnostika má obsahovať:</p>

<ul>
  <li>laboratórne vyšetrenia (napr. diferenciálny krvný obraz, LDH),</li>
  <li>zobrazovanie (CT hrudníka/brucha/panvy podľa protokolu),</li>
  <li>a najmä <strong>biopsiu</strong> s histologickým potvrdením. Kľúčová je odporúčaná detekcia EBV (in situ hybridizácia EBER).</li>
</ul>

<h3>Prvá línia manažmentu</h3>

<ul>
  <li><strong>Minimalizácia imunosupresie</strong> (vrátane vysadenia antimetabolitov) je prvým krokom, najmä pri EBV-asociovaných a polymorfných formách, kde redukcia imunosupresie často pomáha dostať chorobu pod kontrolu.</li>
  <li>Pri monomorfných formách a najmä pri agresívnych variantoch (napr. Burkittov lymfóm) sa uvádza, že samotná redukcia imunosupresie nemusí stačiť a nesmie nahradiť onkologickú liečbu.</li>
  <li>Pri diagnóze PTLD sa zdôrazňuje urgentná spolupráca s hematológom/onkológom. Ako sa v článku píše, inhibítory mTOR sa spomínajú, ale bez klinického dôkazu, že by zlepšili výsledky oproti kalcineurínovým inhibítorom v kontexte PTLD.</li>
</ul>

<h2>6) Záverečné zhrnutie pre nefrologickú komunitu</h2>

<p>Tento Core Curriculum nastavuje praktický rámec takto:</p>

<ul>
  <li>väčšina skríningov sa opiera o všeobecnú populáciu, ale s dôrazom na „high-yield“ oblasti (koža, vírusom indukované malignity, vybrané uroonkologické situácie),</li>
  <li>skríning aj liečbu treba individualizovať podľa rizika, očakávanej dĺžky života a cieľov pacienta,</li>
  <li>prevencia a bezpečné očkovanie majú veľký význam, najmä s ohľadom na načasovanie voči imunosupresii,</li>
  <li>na PTLD treba myslieť včas, robiť monitorovanie EBV v rizikových skupinách a držať sa diagnostickej logiky smerujúcej k biopsii.</li>
</ul>

<hr>

<h2>Ambulantný checklist: malignity u dospelých kandidátov a príjemcov transplantátu</h2>

<p><em>Použite ako rýchly „check“ v ambulancii. Pri konkrétnych intervaloch, vakcínach a frekvenciách skríningu vždy dolaďte podľa miestnych a produktových odporúčaní.</em></p>

<h3>Pred transplantáciou (pri plánovaní)</h3>

<ul>
  <li>Skontroluj očkovania a doplň ich — <strong>potrebné očkovania realizuj ešte pred imunosupresiou</strong> (živým vakcínam sa podľa režimu vyhýbaj).</li>
  <li>Aktualizuj <strong>bežný skríning malignít</strong> podľa veku a rizík pacienta (nerob nič „mechanicky“ bez individualizácie).</li>
  <li>Zhodnoť <strong>riziká kožných nádorov</strong>: dlhodobé slnenie/soláriá, anamnéza kožných nádorov, fototyp.</li>
  <li>Pri plánovaní zváž <strong>uroonkologické situácie</strong> (najmä podľa anamnézy) a dohodni, čo a ako často sa má sledovať.</li>
</ul>

<h3>Po transplantácii (v prvých mesiacoch a dlhodobo)</h3>

<ul>
  <li>Nastav <strong>dermatologickú kontrolu</strong> (minimálne pravidelné celotelové vyšetrenie kože) a reálne rieš <strong>UV prevenciu</strong>.</li>
  <li>Sleduj infekčno-nádorové riziká: u <strong>EBV-séronegatívnych</strong> zváž/naplánuj <strong>surveillance EBV PCR</strong> (podľa lokálneho protokolu, typicky častejšie v prvom období).</li>
  <li>Vyrieš „červené vlajky“ PTLD: nejasná horúčka, lymfadenopatia, <strong>pokles celkového výkonnostného stavu</strong>, B-symptómy, rýchle zväčšovanie uzlín alebo orgánových nálezov.</li>
  <li>Pri podozrení na PTLD postupuj diagnostickou logikou smerom k <strong>biopsii</strong> a urgentne zapoj hematológa/onkológa.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD): „Malignancy and Kidney Transplant: Core Curriculum 2026“ (2026). <a href="https://www.ajkd.org/article/S0272-6386(26)00764-X/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
