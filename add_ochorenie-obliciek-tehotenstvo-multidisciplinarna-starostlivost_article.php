<?php
/**
 * add_ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): ochorenie obličiek
 * v tehotenstve, rizikové zhodnotenie a multidisciplinárna starostlivosť.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost_article.php"
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
    'title'        => 'Ochorenie obličiek v tehotenstve: včasné rizikové zhodnotenie a multidisciplinárna starostlivosť',
    'slug'         => 'ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tehotenstvo pri ochorení obličiek vyžaduje plánovanie ešte pred koncepciou, úpravu rizikových liekov, správnu interpretáciu renálnych parametrov a úzku spoluprácu nefrológa s materno-fetálnym tímom.',
    'content'      => <<<'HTML'
<p>Tehotenstvo u ženy s ochorením obličiek patrí medzi klinicky náročné situácie. Nejde iba o graviditu s pridruženou diagnózou. Ide o dynamický stav, v ktorom sa fyziologické zmeny tehotenstva prekrývajú s chronickým alebo akútnym poškodením obličiek, hypertenziou, proteinúriou, imunologickou aktivitou ochorenia, rizikom preeklampsie a možnými komplikáciami pre plod.</p>

<p>Pre nefrológa je táto téma praktická a každodenná. Chronická choroba obličiek (CKD) môže znižovať fertilitu, zvyšovať riziko komplikácií v tehotenstve a u časti pacientok urýchliť pokles renálnej funkcie. Na druhej strane správne načasovanie gravidity, predkoncepčné poradenstvo, úprava liečby a koordinovaná starostlivosť s perinatológom môžu výsledky významne zlepšiť.</p>

<p>Prehľadový článok v <em>Journal of Nephrology</em> zdôrazňuje potrebu „bridging care“, teda premostenia medzi nefrológiou, gynekológiou, materno-fetálnou medicínou a ďalšími odbormi. V praxi to znamená, že starostlivosť nemá začínať až pri pozitívnom tehotenskom teste, ale už pri rozhovore o reprodukčných plánoch ženy s ochorením obličiek.</p>

<h2>Prečo je tehotenstvo pri ochorení obličiek rizikové</h2>

<p>Tehotenstvo predstavuje pre obličky fyziologickú záťaž. Zvyšuje sa renálny prietok plazmy aj glomerulárna filtrácia, mení sa objem tekutín, cievna reaktivita a hemodynamika. U zdravej ženy ide o adaptáciu na metabolické nároky gravidity. U pacientky s ochorením obličiek však môže byť renálna rezerva obmedzená.</p>

<p>CKD sa podľa zdrojového článku vyskytuje približne pri 3 až 4 % tehotenstiev a je spojená s vyšším rizikom preeklampsie, predčasného pôrodu, intrauterinnej rastovej reštrikcie, zhoršenia proteinúrie, progresie renálnej dysfunkcie a potreby intenzívnejšieho sledovania matky aj plodu.</p>

<p>Riziko nie je rovnaké u všetkých pacientok. Závisí najmä od štádia CKD, východiskovej proteinúrie, kontroly krvného tlaku, základnej diagnózy, diabetu, systémového ochorenia, predchádzajúcich tehotenských komplikácií a stability ochorenia pred koncepciou.</p>

<h2>Fertilita klesá s poklesom funkcie obličiek</h2>

<p>Jedným z dôležitých bodov review je, že fertilita sa zhoršuje s poklesom renálnej funkcie. Pri pokročilej CKD a najmä pri zlyhaní obličiek je tehotenstvo menej časté. Dôvodom sú hormonálne poruchy, anovulácia, menštruačné nepravidelnosti, uremické prostredie, metabolické zmeny a celkové zhoršenie zdravotného stavu.</p>

<p>To však neznamená, že gravidita nie je možná. Ak nastane u pacientky so zlyhaním obličiek, ide o vysoko rizikovú situáciu. Vyžaduje intenzívnu dialyzačnú stratégiu, časté monitorovanie, dôsledné hodnotenie objemu, tlaku, anémie, výživy a rastu plodu a jasné rozdelenie zodpovednosti medzi tímami.</p>

<h2>Predkoncepčné zhodnotenie je kľúčové</h2>

<p>Pri CKD je najdôležitejším krokom predkoncepčné poradenstvo. Pacientka by mala ešte pred otehotnením vedieť, aké riziká súvisia s jej aktuálnym štádiom ochorenia, proteinúriou, krvným tlakom, histologickou alebo klinickou diagnózou a užívanou liečbou.</p>

<p>Najvyššie riziko majú najmä pacientky s pokročilou CKD, významnou proteinúriou, nedostatočne kontrolovanou hypertenziou, aktívnym glomerulovým ochorením, lupusovou nefritídou, diabetickou chorobou obličiek, anamnézou preeklampsie alebo predčasného pôrodu a rýchlou progresiou ochorenia pred plánovanou graviditou.</p>

<p>Prakticky má predkoncepčné zhodnotenie odpovedať na štyri otázky: či je ochorenie stabilné, či je krvný tlak bezpečne kontrolovaný, či je liečba kompatibilná s tehotenstvom a aký plán monitorovania bude potrebný po otehotnení.</p>

<h2>Renálne parametre sa v gravidite interpretujú inak</h2>

<p>V tehotenstve treba renálne parametre hodnotiť opatrne. Bežné rovnice na odhad glomerulárnej filtrácie nie sú v gravidite spoľahlivé. V praxi sa preto viac opierame o sérový kreatinín, jeho dynamiku, proteinúriu, krvný tlak, klinický stav a porovnanie s predtehotenským východiskom.</p>

<p>Aj mierne zvýšený kreatinín, ktorý by mimo gravidity pôsobil nenápadne, môže byť v tehotenstve významný. Rovnako proteinúria vyžaduje kontext: iný význam má stabilná známa proteinúria pri CKD a iný náhly nárast proteinúrie spolu so zhoršením tlaku, trombocytopéniou alebo poruchou rastu plodu.</p>

<p>Preto je užitočné mať pred graviditou zaznamenané východiskové hodnoty kreatinínu, proteinúrie, krvného tlaku a aktivity základného ochorenia. Bez nich sa počas tehotenstva ťažšie rozlišuje fyziologická adaptácia, progresia CKD, relaps glomerulopatie a preeklampsia.</p>

<h2>Akútne poškodenie obličiek v tehotenstve</h2>

<p>Akútne poškodenie obličiek (AKI) počas gravidity má rôzne príčiny podľa fázy tehotenstva. V prvom trimestri môže súvisieť napríklad s ťažkou hyperemesis gravidarum, dehydratáciou alebo septickými komplikáciami.</p>

<p>V neskorších fázach tehotenstva sa dostávajú do popredia preeklampsia, eklampsia, HELLP syndróm, trombotické mikroangiopatie, krvácanie, sepsa, obštrukčné príčiny a komplikácie pôrodu. Klinická diferenciálna diagnostika môže byť zložitá, pretože hypertenzia, proteinúria, trombocytopénia, zvýšené pečeňové enzýmy a zhoršenie renálnej funkcie sa môžu pri viacerých diagnózach prekrývať.</p>

<p>Od správneho rozlíšenia závisí liečba aj načasovanie pôrodu. Nefrológ má v týchto situáciách dôležitú úlohu pri interpretácii renálneho nálezu, diferenciálnej diagnostike trombotických mikroangiopatií a hodnotení, či ide o primárne obličkový proces, placentárnu komplikáciu alebo systémové ochorenie.</p>

<h2>Glomerulové ochorenia v gravidite</h2>

<p>Osobitnú pozornosť si vyžadujú pacientky s relapsujúcimi alebo imunitne sprostredkovanými glomerulopatiami. Zdrojový článok pripomína najmä lupusovú nefritídu, fokálne segmentálnu glomerulosklerózu a IgA nefropatiu.</p>

<p>Pri týchto ochoreniach treba rozlišovať aktivitu základnej choroby, fyziologické a hemodynamické zmeny gravidity, nárast proteinúrie, vznik preeklampsie, liekovú toxicitu a infekčné komplikácie. Klinický obraz môže byť podobný, ale liečebné dôsledky sú odlišné.</p>

<p>Pri lupusovej nefritíde je vhodné plánovať graviditu v období stabilnej remisie. Aktívne ochorenie pred koncepciou alebo v skorom tehotenstve významne zvyšuje riziko komplikácií. Potrebná je spolupráca nefrológa, reumatológa alebo imunológa a materno-fetálneho špecialistu.</p>

<h2>Imunosupresia a lieky: plánovať vopred</h2>

<p>Jednou z najcitlivejších oblastí je farmakoterapia. Niektoré lieky používané v nefrológii sú v tehotenstve kontraindikované alebo nevhodné. Iné možno použiť, ale vyžadujú skúsenosť, jasnú indikáciu a dôsledné monitorovanie.</p>

<p>Pred plánovanou graviditou treba včas prehodnotiť antihypertenzíva, blokátory systému renín-angiotenzín-aldosterón, niektoré imunosupresíva, statíny a ďalšie lieky s potenciálnym rizikom pre plod. Nestačí vysadiť rizikový liek až po pozitívnom tehotenskom teste. Pri viacerých prípravkoch je potrebná bezpečnejšia alternatíva už pred koncepciou.</p>

<p>Cieľom nie je podliečiť matku zo strachu pred liekmi. Cieľom je udržať ochorenie pod kontrolou liečbou, ktorá je primerane bezpečná pre matku aj plod. Neliečený relaps glomerulopatie, ťažká hypertenzia alebo vysoká aktivita systémového ochorenia môžu byť pre graviditu nebezpečnejšie než správne zvolená liečba.</p>

<h2>Tehotenstvo pri zlyhaní obličiek a dialýze</h2>

<p>Tehotenstvo u pacientok so zlyhaním obličiek je menej časté, ale možné. Výsledky sa v posledných rokoch zlepšili najmä vďaka intenzívnejším dialyzačným protokolom a koordinovanej starostlivosti.</p>

<p>Základnou myšlienkou je znížiť uremickú záťaž a udržiavať čo najstabilnejšie vnútorné prostredie. To si vyžaduje častejšiu alebo dlhšiu dialýzu, prísne sledovanie objemu, krvného tlaku, anémie, minerálového metabolizmu, výživy a rastu plodu.</p>

<p>Takáto gravidita má byť vedená v centre so skúsenosťami s vysoko rizikovým tehotenstvom a nefrologickou starostlivosťou. Dôležitý je aj realistický rozhovor s pacientkou o rizikách, očakávaniach, záťaži intenzívnej dialýzy a možnostiach pôrodu.</p>

<h2>Preeklampsia ako diagnostická výzva</h2>

<p>Preeklampsia je jednou z najzávažnejších komplikácií tehotenstva pri CKD. Problém je, že pacientky s CKD môžu mať hypertenziu a proteinúriu už pred graviditou. Diagnóza preeklampsie preto nemusí byť priamočiara.</p>

<p>Kľúčové je sledovať zmenu oproti východiskovému stavu. Klinicky významné môže byť nové alebo zhoršujúce sa zvýšenie krvného tlaku, náhly nárast proteinúrie, zhoršenie renálnych funkcií, trombocytopénia, zvýšené pečeňové enzýmy, neurologické príznaky alebo porucha rastu plodu.</p>

<p>V nejasných prípadoch môže pomôcť spolupráca s perinatológom a podľa lokálnych možností aj angiogénne biomarkery. Výsledok však musí byť vždy interpretovaný v klinickom kontexte a v porovnaní s predchádzajúcim stavom pacientky.</p>

<h2>Multidisciplinárna starostlivosť nie je formalita</h2>

<p>Hlavné posolstvo článku je jednoduché: úspešná starostlivosť o tehotnú pacientku s ochorením obličiek vyžaduje multidisciplinárny prístup. Nestačí, aby nefrológ občas skontroloval kreatinín a gynekológ samostatne sledoval graviditu.</p>

<p>Potrebný je spoločný plán, ktorý zahŕňa predkoncepčné poradenstvo, zhodnotenie rizika, úpravu liekov ešte pred počatím, plán monitorovania počas tehotenstva, jasný postup pri zhoršení tlaku, proteinúrie alebo renálnych funkcií, plán pôrodu a popôrodné sledovanie.</p>

<p>Rovnako dôležitá je edukácia pacientky. Žena má vedieť, ktoré príznaky hlásiť, ako často bude sledovaná, ktoré lieky nesmie meniť bez konzultácie a prečo je popôrodné nefrologické sledovanie dôležité aj vtedy, keď sa pôrodom akútna tehotenská komplikácia zdanlivo skončí.</p>

<h2>Popôrodné obdobie netreba podceňovať</h2>

<p>Po pôrode môže dôjsť k zhoršeniu krvného tlaku, perzistencii alebo nárastu proteinúrie, aktivácii glomerulového ochorenia alebo pretrvávaniu renálnej dysfunkcie. Zároveň sa mení farmakoterapia podľa dojčenia, rizika relapsu a aktuálneho stavu pacientky.</p>

<p>Popôrodná kontrola preto nemá byť iba administratívnym uzavretím gravidity. Má zhodnotiť tlak, kreatinín, proteinúriu, liečbu, plán ďalšieho sledovania a prípadné kardiovaskulárne a renálne riziko do budúcnosti. Pre pacientky po preeklampsii alebo AKI môže byť tehotenstvo prvým signálom dlhodobej vaskulárnej alebo renálnej vulnerability.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<p>Pri žene vo fertilnom veku s CKD by mala byť otázka tehotenstva súčasťou bežnej starostlivosti. Nefrológ by sa mal aktívne pýtať na reprodukčné plány a nečakať, kým pacientka otehotnie neplánovane pri nevhodnej liečbe.</p>

<ol>
  <li><strong>Zistiť reprodukčný plán.</strong> Ak pacientka graviditu plánuje, treba začať predkoncepčné poradenstvo.</li>
  <li><strong>Stanoviť riziko.</strong> Hodnotí sa štádium CKD, kreatinín, proteinúria, krvný tlak, diagnóza, komorbidity a predchádzajúce tehotenské komplikácie.</li>
  <li><strong>Prehodnotiť lieky.</strong> Osobitne antihypertenzíva, RAAS blokátory, imunosupresíva, statíny a lieky s teratogénnym potenciálom.</li>
  <li><strong>Stabilizovať ochorenie.</strong> Pri aktívnej glomerulonefritíde alebo lupusovej nefritíde je vhodné tehotenstvo odložiť do remisie.</li>
  <li><strong>Nastaviť spoločný plán sledovania.</strong> Pacientka, nefrológ a perinatológ musia vedieť, čo sa sleduje, ako často a pri akých zmenách sa mení postup.</li>
  <li><strong>Nepodceniť šestonedelie a ďalšie mesiace.</strong> Po pôrode treba kontrolovať tlak, renálne funkcie, proteinúriu a bezpečnosť liečby vzhľadom na dojčenie.</li>
</ol>

<h2>Záver</h2>

<p>Ochorenie obličiek v tehotenstve je spojené so zvýšeným rizikom komplikácií pre matku aj plod. Riziko závisí od štádia CKD, proteinúrie, krvného tlaku, základnej diagnózy, aktivity ochorenia a komorbidít. Akútne poškodenie obličiek v gravidite má rôzne príčiny podľa trimestra a vyžaduje rýchlu diferenciálnu diagnostiku.</p>

<p>Najdôležitejším klinickým posolstvom je potreba včasného plánovania. Predkoncepčné poradenstvo, úprava liečby, správna interpretácia renálnych parametrov počas gravidity a úzka spolupráca nefrológa s materno-fetálnym špecialistom môžu významne zlepšiť výsledky.</p>

<p>Pre nefrologickú prax platí jednoduché pravidlo: u ženy s ochorením obličiek treba o tehotenstve hovoriť skôr, než nastane.</p>

<hr>

<p><em><strong>Zdroj:</strong> Alotaibi ME, Ankawi G. Bridging care: multidisciplinary approaches to kidney disease in pregnancy. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajaf082. doi:10.1093/joneph/aajaf082. PMID: 42360196. <a href="https://academic.oup.com/joneph/advance-article-abstract/doi/10.1093/joneph/aajaf082/8718958" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360196/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_oblicky_tehotenstvo newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_oblicky_tehotenstvo pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_oblicky_tehotenstvo pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_oblicky_tehotenstvo migration error: ' . $e->getMessage());
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
