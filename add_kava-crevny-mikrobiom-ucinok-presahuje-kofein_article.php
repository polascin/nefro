<?php
/**
 * add_kava-crevny-mikrobiom-ucinok-presahuje-kofein_article.php
 * ============================================================================
 * Odborný článok: káva, črevný mikrobióm a klinický význam nových poznatkov.
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kava-crevny-mikrobiom-ucinok-presahuje-kofein_article.php"
 */

// Ochrana - len admin alebo CLI
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
    'title'        => 'Káva a črevný mikrobióm: účinok presahuje kofeín',
    'slug'         => 'kava-crevny-mikrobiom-ucinok-presahuje-kofein',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Káva ovplyvňuje črevnú motilitu, mikrobiálne zloženie aj metabolity, často nezávisle od kofeínu. Klinický význam týchto zmien však zatiaľ zostáva neistý.',
    'content'      => <<<'HTML'
<p>Káva patrí medzi najčastejšie konzumované nápoje na svete. Pacienti ju spájajú najmä s povzbudením, nutkaním na stolicu alebo diuretickým účinkom. Takéto vysvetlenie však redukuje komplexný nápoj na jedinú molekulu – kofeín. Novšie práce ukazujú, že káva môže ovplyvňovať črevnú motilitu, zloženie mikrobioty aj mikrobiálne metabolity prostredníctvom viacerých nekofeínových zložiek.</p>

<p>Zdrojový článok Medscape sumarizuje výskum polyfenolov, chlorogénových kyselín, rozpustnej vlákniny a melanoidínov vznikajúcich pri pražení. Dôležitý signál predstavuje skutočnosť, že časť pozorovaných účinkov sa objavila aj pri bezkofeínovej káve. To však ešte neznamená, že káva je prebiotikum, liečba dysbiózy alebo univerzálne prospešná intervencia.</p>

<h2>Káva nepôsobí iba cez kofeín</h2>

<p>Nutkanie na stolicu po káve sa tradične vysvetľuje gastrokolickým reflexom a stimuláciou motoriky hrubého čreva. Klinické údaje po brušných operáciách podporujú aj úlohu nekofeínových zložiek. Metaanalýza trinástich štúdií s 1 246 pacientmi ukázala skorší návrat črevnej funkcie a nižší výskyt pooperačného ileu po káve; výsledky sa významne nelíšili medzi kofeínovou a bezkofeínovou kávou. Istota dôkazov bola nízka až stredná a tento postup patrí do pooperačného protokolu, nie do samostatnej liečby pacienta.</p>

<p>Káva je chemicky zložitá zmes. Okrem kofeínu obsahuje chlorogénové kyseliny a ďalšie fenolové zlúčeniny, trigonelín a produkty praženia vrátane melanoidínov. Časť týchto látok sa nevstrebe v tenkom čreve, dostáva sa do hrubého čreva a stáva sa substrátom pre mikrobiálny metabolizmus. Preto sa biologický účinok kávy nemusí zhodovať s účinkom izolovaného kofeínu.</p>

<h2>Výrazná asociácia s jednou baktériou</h2>

<p>Multikohortová štúdia publikovaná v roku 2024 v časopise <em>Nature Microbiology</em> analyzovala podrobné stravovacie a metagenomické údaje od 22 867 účastníkov zo Spojených štátov a Spojeného kráľovstva a výsledky porovnala s verejnými údajmi z desiatok tisíc ďalších vzoriek. Spomedzi sledovaných potravín mala káva mimoriadne reprodukovateľnú súvislosť s črevným mikrobiálnym profilom.</p>

<p>Najsilnejšia asociácia sa týkala baktérie <em>Lawsonibacter asaccharolyticus</em>. U konzumentov kávy bola častejšia a relatívne hojnejšia než u ľudí, ktorí kávu nepili. Súvislosť sa pozorovala aj pri bezkofeínovej káve. V laboratórnej kultúre navyše kofeínová aj bezkofeínová káva podporovali rast tejto baktérie.</p>

<p>Ide o presvedčivý dôkaz interakcie medzi konkrétnou potravinou a konkrétnym mikroorganizmom, nie však o dôkaz zdravotného prínosu. Biologická úloha <em>L. asaccharolyticus</em> u človeka nie je dostatočne objasnená. Vyššie relatívne zastúpenie baktérie samo osebe neznamená zdravší mikrobióm a z výsledku nemožno odvodiť terapeutickú dávku ani vhodný typ kávy.</p>

<h2>Polyfenoly, melanoidíny a metabolity</h2>

<p>Chlorogénové kyseliny a ich metabolity patria medzi najčastejšie skúmané nekofeínové zložky kávy. Črevné baktérie ich premieňajú na menšie fenolové zlúčeniny, ktoré sa môžu vstrebávať a vstupovať do metabolických a zápalových dráh. Melanoidíny môžu byť čiastočne fermentované podobne ako vláknina.</p>

<p>To vytvára biologicky vierohodný mechanizmus, ktorým môže káva selektívne meniť mikrobiálne spoločenstvo a metabolóm. Zatiaľ však nevieme, ktoré zmeny sú príčinne prospešné, neutrálne alebo iba označujú konzumáciu kávy. Pojmy „modulácia mikrobiómu“ a „zdravší mikrobióm“ preto nemožno používať ako synonymá.</p>

<h2>Štúdia osi mikrobiota – črevo – mozog</h2>

<p>Štúdia publikovaná v roku 2026 v <em>Nature Communications</em> skúmala 62 zdravých dospelých vo veku 30 až 50 rokov. Polovicu tvorili ľudia, ktorí kávu nepili, a polovicu pravidelní konzumenti troch až piatich šálok denne. U pravidelných konzumentov nasledovalo dvojtýždňové vysadenie kávy a následné trojtýždňové opätovné zavedenie kofeínovej alebo bezkofeínovej instantnej kávy.</p>

<p>Medzi konzumentmi a nekonzumentmi sa líšilo zloženie mikrobioty, najmä zastúpenie zástupcov rodov <em>Cryptobacterium</em> a <em>Eggerthella</em>. Rozdiely sa našli aj vo fekálnych metabolitoch vrátane kyseliny indol-3-propiónovej, indol-3-karboxaldehydu a kyseliny γ-aminomaslovej (GABA). Časť metabolických zmien sa po vysadení kávy menila a po jej opätovnom zavedení sa objavila znovu; niektoré skoré zmeny nezáviseli od prítomnosti kofeínu.</p>

<p>Behaviorálne výsledky neukázali jednoduchý obraz „káva zlepšuje mozog“. Pri východiskovom porovnaní mali konzumenti vyššiu impulzivitu a emočnú reaktivitu, zatiaľ čo nekonzumenti dosiahli lepší výsledok v pamäťovej úlohe. Krátkodobé zmeny nálady alebo stresu po opätovnom zavedení kávy nemožno zamieňať za liečbu kognitívnej či psychickej poruchy.</p>

<h2>Čo vieme o refluxe, obstipácii a IBD</h2>

<p>Účinok kávy na gastrointestinálne príznaky je individuálny. Metaanalýza štyridsiatich štúdií so 122 074 účastníkmi z roku 2026 našla u konzumentov kávy malú asociáciu s častejším gastroezofágovým refluxom (OR 1,18), ale s vysokou heterogenitou a neistým klinickým významom. Súvislosť s Barrettovým pažerákom sa nepotvrdila. Výsledok nepodporuje univerzálny zákaz kávy; podporuje skúšobné obmedzenie u pacienta, ktorý opakovane pozoruje časovú súvislosť so symptómami.</p>

<p>Údaje o obstipácii sú rozporné. Jedna prierezová analýza NHANES z roku 2025 nenašla celkovú súvislosť medzi príjmom kofeínu a obstipáciou definovanou frekvenciou ani konzistenciou stolice. Iná analýza toho istého populačného zdroja opísala nelineárny vzťah, pri ktorom bola vyššia expozícia nad určitým bodom spojená s miernym nárastom rizika. Prierezový dizajn, údaje zo stravovacieho dotazníka a rozdielne modelovanie neumožňujú odporúčať kofeín na liečbu ani prevenciu obstipácie.</p>

<p>Rovnako nemožno tvrdiť, že viac než päť šálok kávy denne urýchľuje progresiu Crohnovej choroby. Overená populačná štúdia z roku 2025 nenašla štatisticky významnú súvislosť príjmu kofeínu s IBD; ochorenie bolo navyše hodnotené podľa údajov od samotných účastníkov a počet prípadov bol malý. Káva môže u niektorých pacientov zhoršiť hnačku, urgenciu alebo bolesti, ale symptomatická intolerancia nie je dôkazom zhoršenia črevného zápalu.</p>

<h2>Nefrologický a internistický pohľad</h2>

<p>Pre pacienta s CKD nie je káva automaticky zakázaná. V kontrolovanej štúdii u pravidelných konzumentov nenarušilo bežné množstvo kávy hydratáciu v porovnaní s rovnakým objemom vody. Káva sa však započítava do denného príjmu tekutín, čo je podstatné pri dialýze, srdcovom zlyhávaní alebo inom režime s obmedzením tekutín.</p>

<p>Kofeín môže akútne a prechodne zvýšiť krvný tlak, najmä u nepravidelných konzumentov alebo pri vyššej dávke. Pri palpitáciách, nekontrolovanej hypertenzii, tremore, úzkosti či nespavosti má zmysel znížiť dávku, upraviť čas pitia alebo skúsiť bezkofeínovú kávu. Tolerancia kofeínu aj jeho množstvo v jednej porcii sa výrazne líšia podľa prípravy a veľkosti nápoja.</p>

<p>Pri pokročilej CKD bývajú dôležitejšie prídavky než samotná čierna káva. Mlieko, smotana, kávové krémy, sirupy a niektoré rastlinné nápoje môžu zvýšiť príjem draslíka, fosforu, cukru a energie; obsah sa medzi výrobkami výrazne líši. Veľké kávové nápoje zároveň predstavujú nezanedbateľný objem tekutiny.</p>

<p>Káva nie je nefroprotektívna ani mikrobiomovo cielená liečba. Nenahrádza kontrolu krvného tlaku a diabetu, blokádu systému renín – angiotenzín, inhibítory SGLT2 ani ďalšie postupy s preukázaným renálnym prínosom. Mikrobiómové štúdie navyše neboli vykonané u pacientov s pokročilou CKD, v dialyzačnom programe ani po transplantácii, preto ich nemožno priamo prenášať do týchto populácií.</p>

<h2>Praktická komunikácia s pacientom</h2>

<ul>
  <li>Zistiť druh kávy, veľkosť porcie, počet porcií, čas pitia a všetky prídavky; samotný počet „šálok“ je nepresný.</li>
  <li>Pri dobrej tolerancii nie je dôvod kávu paušálne zakazovať iba pre diagnózu CKD.</li>
  <li>Pri refluxe, hnačke, urgencii, palpitáciách alebo nespavosti skúsiť nižšiu dávku, skorší čas pitia alebo bezkofeínovú alternatívu a sledovať príznaky.</li>
  <li>Pri obmedzení tekutín započítať celý objem nápoja; pri hyperkaliémii alebo hyperfosfatémii skontrolovať najmä zloženie prídavkov.</li>
  <li>Neodporúčať zvyšovanie spotreby kávy s cieľom „liečiť mikrobióm“, obstipáciu, náladu alebo kogníciu.</li>
  <li>Pacientovi s aktívnym gastrointestinálnym ochorením odporúčanie individualizovať podľa symptómov a liečebného plánu.</li>
</ul>

<h2>Limity dostupných dôkazov</h2>

<p>Štúdia <em>L. asaccharolyticus</em> mala mimoriadne veľký a reprodukovateľný populačný súbor, zostáva však prevažne observačná; laboratórna stimulácia rastu baktérie nedokazuje klinický účinok u človeka. Štúdia osi mikrobiota – črevo – mozog zahŕňala iba 62 zdravých dospelých, mala krátku intervenčnú fázu a nevylučuje rozdiely medzi pravidelnými konzumentmi a celoživotnými nekonzumentmi. Financoval ju Institute for Scientific Information on Coffee, čo je potrebné uviesť pri hodnotení možného konfliktu záujmov.</p>

<p>Črevný mikrobióm je vysoko individuálny a ovplyvňuje ho strava, lieky, antibiotiká, fajčenie, geografické prostredie aj množstvo ďalších faktorov. Zmena relatívneho zastúpenia baktérie alebo koncentrácie metabolitu preto nie je automaticky klinickým výsledkom. V súčasnosti neexistuje validovaný mikrobiomový test, podľa ktorého by mal internista alebo nefrológ pacientovi predpisovať konkrétny druh či dávku kávy.</p>

<h2>Záver</h2>

<p>Účinok kávy na črevo presahuje kofeín. Kofeínová aj bezkofeínová káva môžu ovplyvniť motilitu, mikrobiálne zloženie a metabolity, pričom najsilnejšie reprodukovanou asociáciou je vyššie zastúpenie <em>Lawsonibacter asaccharolyticus</em> u konzumentov kávy. Klinický význam týchto zmien však zatiaľ nepoznáme.</p>

<p>Pre internistu a nefrológa z toho vyplýva striedmy záver: kávu netreba idealizovať ani paušálne zakazovať. Pri dobrej tolerancii môže zostať súčasťou bežného režimu, no odporúčanie sa má riadiť krvným tlakom, spánkom, gastrointestinálnymi príznakmi, tekutinovou bilanciou a zložením nápoja – nie prísľubom „opravy“ mikrobiómu.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> <em>Coffee and the Gut: What’s Brewing in the Microbiome?</em> Medscape, júl 2026. Autor článku nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. Článok bol podľa Medscape preložený zo zdroja <em>El Médico Interactivo</em> na platforme Univadis. <a href="https://www.medscape.com/viewarticle/coffee-and-gut-whats-brewing-microbiome-2026a1000mlo" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<p><em><strong>Doplňujúce zdroje:</strong> Manghi P et al. <em>Coffee consumption is associated with intestinal Lawsonibacter asaccharolyticus abundance and prevalence across multiple cohorts</em>. Nature Microbiology. 2024;9:3120–3134. <a href="https://doi.org/10.1038/s41564-024-01858-9" target="_blank" rel="noopener noreferrer">doi:10.1038/s41564-024-01858-9</a>. Boscaini S et al. <em>Habitual coffee intake shapes the gut microbiome and modifies host physiology and cognition</em>. Nature Communications. 2026;17:3439. <a href="https://doi.org/10.1038/s41467-026-71264-8" target="_blank" rel="noopener noreferrer">doi:10.1038/s41467-026-71264-8</a>. Watanabe J et al. <em>Effect of Postoperative Coffee Consumption on Postoperative Ileus after Abdominal Surgery</em>. Nutrients. 2021;13:4394. <a href="https://doi.org/10.3390/nu13124394" target="_blank" rel="noopener noreferrer">doi:10.3390/nu13124394</a>. Muftah M et al. <em>Association of Coffee Intake With Risk of Gastroesophageal Reflux Disease and Complications</em>. Clinical and Translational Gastroenterology. 2026;17:e00996. <a href="https://doi.org/10.14309/ctg.0000000000000996" target="_blank" rel="noopener noreferrer">doi:10.14309/ctg.0000000000000996</a>. Li Y et al. <em>Association Between Caffeine Intake and Stool Frequency- or Consistency-Defined Constipation</em>. Journal of Neurogastroenterology and Motility. 2025;31:256–266. <a href="https://doi.org/10.5056/jnm23181" target="_blank" rel="noopener noreferrer">doi:10.5056/jnm23181</a>. Yang X et al. <em>Association Between Caffeine Intake and Bowel Habits and Inflammatory Bowel Disease</em>. Journal of Multidisciplinary Healthcare. 2025;18:3717–3726. <a href="https://doi.org/10.2147/JMDH.S512855" target="_blank" rel="noopener noreferrer">doi:10.2147/JMDH.S512855</a>. Killer SC et al. <em>No evidence of dehydration with moderate daily coffee intake</em>. PLoS ONE. 2014;9:e84154. <a href="https://doi.org/10.1371/journal.pone.0084154" target="_blank" rel="noopener noreferrer">doi:10.1371/journal.pone.0084154</a>.</em></p>
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
