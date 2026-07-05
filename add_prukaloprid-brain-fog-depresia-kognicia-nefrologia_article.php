<?php
/**
 * add_prukaloprid-brain-fog-depresia-kognicia-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): prukaloprid, 5-HT4 agonizmus,
 * kognitívne príznaky pri remisii depresie a nefrologická bezpečnosť.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_prukaloprid-brain-fog-depresia-kognicia-nefrologia_article.php"
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
    'title'        => 'Prukaloprid a „brain fog“ po depresii: môže 5-HT4 agonizmus zlepšiť kogníciu?',
    'slug'         => 'prukaloprid-brain-fog-depresia-kognicia-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Malá randomizovaná štúdia naznačuje, že prukaloprid môže krátkodobo zlepšiť niektoré objektívne kognitívne výkony u osôb s remisiou rekurentnej depresie. Pri CKD je kľúčové dávkovanie podľa renálnej funkcie a opatrná interpretácia.',
    'content'      => <<<'HTML'
<p>Kognitívne ťažkosti patria medzi najčastejšie a zároveň najviac podceňované následky depresie. Pacienti ich opisujú ako „brain fog“, zhoršenú koncentráciu, pomalšie myslenie, slabšiu pracovnú pamäť, ťažšie vybavovanie slov alebo celkovú mentálnu únavu. Dôležité je, že tieto príznaky môžu pretrvávať aj po odznení depresívnej nálady.</p>

<p>Medscape upozornil na malú, dvojito zaslepenú, placebom kontrolovanú proof-of-concept štúdiu, podľa ktorej <strong>prukaloprid</strong>, selektívny agonista serotonínového <strong>5-HT4 receptora</strong>, zlepšil niektoré objektívne kognitívne výkony u osôb s remisiou rekurentnej depresívnej poruchy. Prukaloprid je pritom známy najmä ako prokinetikum schválené na liečbu chronickej zápchy. Nový výskum naznačuje, že jeho biologický účinok nemusí byť obmedzený iba na črevo.</p>

<p>Z nefrologického pohľadu nejde o výzvu začať liečiť „brain fog“ prukalopridom. Ide skôr o zaujímavý signál na rozhraní gastroenterológie, psychiatrie, neurobiológie a nefrologickej farmakoterapie. Pacienti s CKD často trpia zápchou, depresiou, únavou, polyfarmáciou a kognitívnymi ťažkosťami. Práve preto je potrebné rozlišovať medzi schválenou indikáciou, experimentálnym prokognitívnym signálom a bezpečným dávkovaním pri zníženej renálnej funkcii.</p>

<h2>Prečo práve 5-HT4 receptor?</h2>

<p>Prukaloprid je selektívny agonista 5-HT4 receptorov. V gastroenterológii sa používa pre prokinetický účinok, najmä pri chronickej idiopatickej zápche. Z neurobiologického hľadiska sú však 5-HT4 receptory zaujímavé aj preto, že sa podieľajú na procesoch učenia, pamäti a synaptickej plasticity.</p>

<p>Predklinické a skoršie humánne štúdie naznačili, že stimulácia 5-HT4 receptorov môže podporovať synaptickú plasticitu v hipokampe, zvyšovať uvoľňovanie acetylcholínu, modulovať glutamátergnú neurotransmisiu a zlepšovať niektoré zložky učenia a pamäti. To je klinicky zaujímavé najmä pri depresii, kde kognitívne príznaky často pretrvávajú aj po ústupe afektívnych symptómov.</p>

<p>Inými slovami: prukaloprid nie je antidepresívum v bežnom zmysle slova. Otázka znie skôr, či krátkodobá stimulácia 5-HT4 receptorov dokáže ovplyvniť kognitívne okruhy, ktoré zostávajú oslabené aj po remisii nálady.</p>

<h2>Kognícia pri depresii nie je len „zvyškový problém“</h2>

<p>Depresia sa tradične hodnotí najmä cez náladu, anhedóniu, spánok, energiu, chuť do jedla, psychomotorické tempo a suicidálne riziko. Kognitívne príznaky však významne ovplyvňujú pracovné fungovanie, sociálnu adaptáciu, adherenciu k liečbe aj riziko relapsu.</p>

<p>Podľa údajov citovaných v zdrojovom článku má kognitívne ťažkosti približne 80 % pacientov počas depresívnej epizódy. U časti pacientov pretrvávajú aj po klinickej remisii. Pacient teda už nemusí spĺňať kritériá aktívnej depresie, ale stále nemusí byť funkčne zotavený. Práve táto medzera medzi „remisiou symptómov“ a „návratom výkonu“ je klinicky dôležitá.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>Štúdia publikovaná v <em>Psychological Medicine</em> zaradila 50 dospelých vo veku 18 až 40 rokov, ktorí mali v minulosti aspoň dve epizódy depresie, ale aktuálne neboli depresívni a najmenej 6 mesiacov boli v remisii. Neužívali antidepresíva ani inú psychotropnú liečbu.</p>

<p>Účastníci boli randomizovaní na prukaloprid alebo placebo. Prukaloprid sa titroval z 1 mg na 2 mg denne a liečba trvala 7 až 10 dní. Po vylúčení jedného účastníka pre problémy s kvalitou dát zostalo v analýze 49 osôb.</p>

<p>Výskumníci hodnotili viacero typov kognície. Primárne išlo o takzvanú „cold cognition“, teda neemocionálne kognitívne funkcie, napríklad pamäť, pracovnú pamäť, pozornosť, rýchlosť spracovania a exekutívne funkcie. Sekundárne sa hodnotila aj „hot cognition“, teda spracovanie emočne nabitých podnetov.</p>

<h2>Čo prukaloprid zlepšil</h2>

<p>V porovnaní s placebom prukaloprid zlepšil výkon vo viacerých objektívnych kognitívnych úlohách. Najvýraznejšie signály sa týkali lepšieho okamžitého vybavovania slov v teste sluchovo-verbálneho učenia a rýchlejších reakčných časov v komplexnej úlohe pracovnej pamäti bez straty presnosti.</p>

<p>Štúdia zároveň ukázala lepšiu presnosť pri rozpoznávaní rýchlo prezentovaných výrazov tváre a celkové zlepšenie v kompozitnej analýze neemocionálnych kognitívnych úloh. Dôležité je, že zlepšenie nebolo vysvetlené iba východiskovou náladou alebo subjektívnymi kognitívnymi ťažkosťami. To podporuje hypotézu, že účinok môže byť priamo prokognitívny.</p>

<p>Treba však zdôrazniť slovo „môže“. Ide o krátkodobý objektívny testový signál, nie o dôkaz zlepšenia pracovného výkonu, štúdia, kvality života alebo dlhodobej funkčnej obnovy.</p>

<h2>Čo štúdia nepreukázala</h2>

<p>Výsledky sú zaujímavé, ale nemožno ich preceňovať. Štúdia bola malá, krátka a mala charakter proof-of-concept. Nešlo o rozsiahlu klinickú štúdiu, ktorá by dokazovala, že prukaloprid zlepšuje každodenné fungovanie pacientov po depresii.</p>

<p>Hlavné obmedzenia sú:</p>

<ul>
  <li>malý počet účastníkov,</li>
  <li>krátke trvanie liečby 7 až 10 dní,</li>
  <li>mladšia populácia do 40 rokov,</li>
  <li>prevažne vysoko vzdelaná vzorka,</li>
  <li>absencia požiadavky na klinicky významný kognitívny deficit pri zaradení,</li>
  <li>nejasnosť, či zlepšenie v testoch znamená reálne zlepšenie v práci, štúdiu alebo bežnom živote,</li>
  <li>možný vplyv očakávania účinku, hoci dizajn bol dvojito zaslepený.</li>
</ul>

<p>Z týchto dôvodov zatiaľ nemožno odporúčať prukaloprid ako štandardnú liečbu kognitívnych symptómov po depresii. Skôr ide o biologicky vierohodný smer ďalšieho výskumu.</p>

<h2>Prečo je to zaujímavé aj mimo psychiatrie</h2>

<p>Táto štúdia zapadá do širšieho trendu, v ktorom sa lieky pôvodne vyvinuté pre jednu oblasť medicíny skúmajú v úplne inom kontexte. Podobne ako inkretínové lieky prekročili hranice diabetológie a obezitológie, aj 5-HT4 agonizmus môže mať význam mimo gastroenterológie.</p>

<p>Ak sa potvrdí, že 5-HT4 agonizmus zlepšuje kognitívne funkcie, potenciálne by mohol byť relevantný aj pri iných stavoch, kde sú kognitívne príznaky podstatné. Zdrojový článok spomína napríklad psychotické poruchy. Do úvahy by mohli prichádzať aj ďalšie neuropsychiatrické stavy, ale zatiaľ ide o hypotézu, nie o klinické odporúčanie.</p>

<h2>Nefrologický pohľad: brain fog má u CKD veľa príčin</h2>

<p>Pre nefrológiu má táto téma nepriamy, ale praktický význam. Pacienti s chronickou chorobou obličiek často trpia kognitívnymi ťažkosťami, únavou, poruchami spánku, depresiou a polyfarmáciou. „Brain fog“ u nefrologického pacienta môže mať viacero príčin:</p>

<ul>
  <li>urémické toxíny,</li>
  <li>anémia,</li>
  <li>poruchy spánku,</li>
  <li>depresia a úzkosť,</li>
  <li>liekové nežiaduce účinky,</li>
  <li>zápal,</li>
  <li>kardiovaskulárne a cerebrovaskulárne riziko,</li>
  <li>dialyzačné výkyvy objemu, tlaku a osmolality,</li>
  <li>metabolické a elektrolytové poruchy.</li>
</ul>

<p>Preto by bolo nesprávne mechanicky prenášať výsledky tejto štúdie na pacientov s CKD alebo dialyzovaných pacientov. Mladý pacient v remisii depresie bez psychotropnej liečby a pacient s pokročilou CKD, anémiou, polyfarmáciou a poruchou spánku sú úplne odlišné klinické situácie.</p>

<h2>Prukaloprid sa však v nefrológii môže objaviť</h2>

<p>Prukaloprid môže byť pre nefrológa prakticky relevantný z iného dôvodu: chronická zápcha je pri CKD častá. Prispieva k nej obmedzenie tekutín, nízky príjem vlákniny, sedavý režim, viazače fosfátov, železo, opioidy, niektoré antihypertenzíva a samotné urémické prostredie.</p>

<p>Ak sa prukaloprid u pacienta s CKD používa v schválenej indikácii chronickej zápchy, treba myslieť na renálnu elimináciu. Podľa oficiálnych liekových informácií sa prukaloprid významne vylučuje obličkami. Pri miernom až stredne závažnom renálnom poškodení sa zvyčajne nevyžaduje úprava dávky, pri ťažkom renálnom poškodení sa odporúča znížená dávka 1 mg denne a pri terminálnom zlyhaní obličiek vyžadujúcom dialýzu sa použitie neodporúča alebo je kontraindikované podľa konkrétnej registrácie.</p>

<p>U nefrologického pacienta treba zvažovať najmä aktuálnu eGFR, riziko dehydratácie pri hnačke, kombináciu s diuretikami, celkovú krehkosť, polyfarmáciu, elektrolytové poruchy a rozdiel medzi liečbou zápchy a experimentálnym použitím na kogníciu.</p>

<h2>Čo z toho vyplýva pre klinickú prax</h2>

<p>Najsilnejším posolstvom článku nie je to, že liek na zápchu má byť predpisovaný na „brain fog“. Skôr ide o dôkaz, že kognitívne príznaky depresie majú biologicky uchopiteľné mechanizmy a môžu byť cieľom budúcej farmakologickej liečby.</p>

<p>Pre lekára je praktické najmä toto:</p>

<ul>
  <li>kognitívne ťažkosti pri depresii treba aktívne vyhľadávať, aj keď je nálada v remisii,</li>
  <li>subjektívne zotavenie pacienta nemusí znamenať plné funkčné zotavenie,</li>
  <li>5-HT4 receptor je perspektívny výskumný cieľ pre zlepšenie kognície,</li>
  <li>prukaloprid zatiaľ nemožno odporúčať na kognitívne príznaky mimo výskumného kontextu,</li>
  <li>u pacientov s CKD treba pri prukalopride rešpektovať renálnu elimináciu a dávkovanie podľa funkcie obličiek.</li>
</ul>

<h2>Záver</h2>

<p>Malá randomizovaná štúdia ukázala, že krátkodobé podávanie prukalopridu, selektívneho agonistu 5-HT4 receptorov, môže zlepšiť niektoré objektívne kognitívne parametre u osôb s remisiou rekurentnej depresie. Výsledky sú biologicky zaujímavé a klinicky sľubné, ale zatiaľ predbežné.</p>

<p>Pre nefrologickú prax je téma dôležitá najmä preto, že kognitívne ťažkosti, depresia, zápcha a polyfarmácia sa u pacientov s CKD často prekrývajú. Prukaloprid môže byť užitočný ako liek na chronickú zápchu, ale jeho použitie na zlepšenie kognície zostáva experimentálnou otázkou. Najrozumnejší záver je opatrný: 5-HT4 agonizmus je perspektívny smer výskumu kognitívnych príznakov depresie, ale na zmenu klinickej praxe sú potrebné väčšie, dlhšie a funkčne orientované štúdie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Anderson P. Can a Constipation Drug Clear Depression’s ‘Brain Fog’? <em>Medscape Medical News</em>. 22. júna 2026. <a href="https://www.medscape.com/viewarticle/can-constipation-drug-clear-depressions-brain-fog-2026a1000kz4" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<p><em><strong>Primárna štúdia:</strong> de Cates AN, Hamilton S, Guru A, Blandhol M, Colwell M, Cowen PJ, Simmons M, Jones B, Harmer CJ, Murphy SE. Pro-cognitive effects of 5-HT4 receptor agonism in individuals with remitted depression. <em>Psychological Medicine</em>. 2026;56:e178. doi:10.1017/S0033291726104450.</em></p>
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
                error_log('add_prukaloprid_brain_fog newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_prukaloprid_brain_fog pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_prukaloprid_brain_fog pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_prukaloprid_brain_fog migration error: ' . $e->getMessage());
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
