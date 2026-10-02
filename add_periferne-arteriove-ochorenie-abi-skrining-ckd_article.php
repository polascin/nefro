<?php
/**
 * add_periferne-arteriove-ochorenie-abi-skrining-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: periférne arteriové ochorenie (PAD) z pohľadu
 * nefrológa — globálna záťaž, prečo sa diagnóza oneskoruje, ABI ako skríningový
 * nástroj a predovšetkým to, prečo konvenčný prah ABI < 0,9 pri CKD nestačí
 * (U-krivka v kohorte CRIC, mediálna kalcifikácia, úloha prstovo-ramenného
 * indexu).
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie viacerých zdrojov
 * (Lancet Global Health 2026, Chen 2016 JAHA — CRIC, Hazique 2025 Crit Pathw
 * Cardiol) — nie preklad jedného zdrojového článku, preto sa do
 * source_authors.php nedopĺňajú pôvodní autori.
 *
 * Číselné údaje overené proti abstraktom v PubMede (PMID 42480579, 27247339,
 * 40397761) a proti zverejnenému abstraktu Lancet Global Health 2026.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH.
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
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Periférne arteriové ochorenie pri CKD: prečo prah ABI pod 0,9 nestačí',
    'slug'         => 'periferne-arteriove-ochorenie-abi-skrining-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Periférne arteriové ochorenie malo v roku 2023 globálne 316,54 milióna ľudí nad 25 rokov. Pri chronickej chorobe obličiek je však jeho najpoužívanejší skríningový test zradný v oboch smeroch: v kohorte CRIC mali zvýšené riziko aj pacienti s ABI 0,9 až 1,0 — teda s hodnotou, ktorú konvenčné kritériá označujú za normálnu — a rovnako tí s ABI nad 1,4. Prehľad toho, ako skrínovať a čím ABI doplniť.',
    'content'      => <<<'HTML'
<figure><a href="img/periferne-arteriove-ochorenie-abi-ckd.webp" rel="noopener noreferrer" target="_blank"><img src="img/periferne-arteriove-ochorenie-abi-ckd.webp" alt="Predkolenie a noha zobrazené ako priesvitné tmavé sklo; vnútri svietia tepny, ktoré smerom k členku a chodidlu postupne blednú a hasnú, pričom ich obaľujú tuhé bledé kalcifikované prstence držiace cievu otvorenú aj tam, kde už neprechádza svetlo" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie zobrazovací nález konkrétneho pacienta. Obraz zachytáva podstatu problému pri CKD: mediálna kalcifikácia drží cievu tuho otvorenú aj tam, kde perfúzia dávno chýba — a práve preto môže manžeta nameraný tlak nadhodnotiť a ABI vyjsť falošne upokojivo.</figcaption></figure>

<p>Periférne arteriové ochorenie (PAD, v slovenčine aj ischemická choroba dolných končatín) má jednu nepríjemnú vlastnosť: dlho nebolí tak, aby pacienta priviedlo k lekárovi, a keď konečne zabolí, býva už pokročilé. V nefrologickej ambulancii k tomu pristupuje druhá komplikácia — <strong>najpoužívanejší skríningový test je práve u našich pacientov najmenej spoľahlivý</strong>.</p>

<p>Tento článok nie je prehľadom cievnej chirurgie. Sústreďuje sa na tri otázky, ktoré má nefrológ reálne v rukách: koho skrínovať, ako čítať výsledok u pacienta s CKD, a kedy ABI nestačí.</p>

<h2>Rozsah problému</h2>

<p>Systematický prehľad s modelovaním publikovaný v <em>The Lancet Global Health</em> (2026) spracoval <strong>157 prác z 37 krajín a vyše 9,7 milióna účastníkov</strong>. Globálna prevalencia PAD u osôb vo veku <strong>25 rokov a viac</strong> bola v roku 2023 <strong>6,58 % (95 % IS 4,83 – 9,02)</strong>, čo zodpovedá <strong>316,54 milióna</strong> postihnutých (232,34 – 433,78 milióna).</p>

<p>Dva údaje z tej istej práce stoja za zapamätanie:</p>

<ul>
  <li><strong>Prevalencia rastie s vekom plynulo</strong> — od 4,31 % vo veku 25 až 29 rokov po 22,09 % vo veku 90 až 99 rokov, s podobným priebehom u oboch pohlaví. Predstava, že ide o chorobu výhradne starých ľudí, teda neplatí; už v štvrtej dekáde je prevalencia nezanedbateľná.</li>
  <li><strong>Krajiny s nízkym a stredným príjmom nesú vyše troch štvrtín všetkých prípadov</strong> (239,35 milióna), hoci ich prevalencia je nižšia — rozhoduje veľkosť populácie.</li>
</ul>

<h2>Prečo včasné zachytenie dáva zmysel</h2>

<p>PAD nie je len problém končatiny. Je to <strong>ukazovateľ celkovej aterotrombotickej záťaže</strong> — pacient s PAD má zvýšené riziko infarktu myokardu, cievnej mozgovej príhody a kardiovaskulárneho úmrtia. Včasné zachytenie preto nie je len o záchrane končatiny, ale predovšetkým o tom, že sa začne cielená liečba aterosklerózy:</p>

<ul>
  <li>antiagregačná a hypolipidemická liečba podľa platných odporúčaní,</li>
  <li>kontrola krvného tlaku a diabetu,</li>
  <li><strong>ukončenie fajčenia</strong> — pri PAD má najväčší účinok zo všetkých režimových opatrení,</li>
  <li>supervidovaný tréning chôdze, ktorý má pri klaudikáciách dobrý dôkazový základ,</li>
  <li>a včasné odoslanie k cievnemu tímu pri progresii.</li>
</ul>

<p>U pacienta s CKD k tomu pristupuje funkčný rozmer: aj mierne obmedzená perfúzia zhoršuje toleranciu chôdze, prispieva ku krehkosti a zvyšuje riziko pádov — a u dialyzovaného pacienta aj riziko komplikácií hojenia.</p>

<h2>ABI: jednoduchý test s komplikovanou interpretáciou</h2>

<p><strong>Členkovo-ramenný index (ABI)</strong> porovnáva systolický tlak nameraný na členku so systolickým tlakom na ramene. Je neinvazívny, nebolestivý, lacný a vykonateľný v ambulancii. Konvenčný prah <strong>ABI pod 0,9</strong> svedčí pre zúženie alebo uzáver tepien panvy či dolných končatín.</p>

<p>Problém je, že tento prah bol odvodený v populáciách, ktoré nemali chronickú chorobu obličiek.</p>

<h3>Prečo je ABI pri CKD zradný</h3>

<p>Pri CKD je výrazne častejšia <strong>mediálna arteriálna kalcifikácia</strong> (Mönckebergova skleróza). Tá nezužuje lúmen, ale robí stenu tepny tuhou a <strong>nestlačiteľnou</strong>. Manžeta ju potom nedokáže uzavrieť pri skutočnom systolickom tlaku, nameraný tlak na členku je falošne vysoký a ABI vyjde <strong>falošne normálne alebo falošne vysoké</strong> — aj u pacienta s kriticky zníženou perfúziou.</p>

<p>Dôsledok je klinicky zákerný: <strong>normálne ABI u pacienta s CKD nevylučuje PAD</strong>. Falošná istota je tu nebezpečnejšia než chýbajúci výsledok.</p>

<h3>Čo o tom hovorí kohorta CRIC</h3>

<p>Najdôležitejšie dáta pochádzajú zo štúdie <em>Chronic Renal Insufficiency Cohort</em> (CRIC), publikované v <em>Journal of the American Heart Association</em> (2016). Zahrnula <strong>3627 účastníkov s CKD bez klinicky zjavného PAD</strong> na začiatku, ABI meralo podľa štandardného protokolu a kardiovaskulárne príhody sa overovali zo zdravotnej dokumentácie.</p>

<p>Výsledkom bola <strong>U-krivka</strong>: najnižšie riziko mali účastníci s ABI <strong>1,0 až menej než 1,4</strong>, a riziko stúpalo na oboch stranách.</p>

<div class="table-responsive" role="region" aria-label="Riziko podľa hodnoty ABI u pacientov s CKD v kohorte CRIC" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">ABI</th><th scope="col">PAD</th><th scope="col">Infarkt myokardu</th><th scope="col">Zložený KV ukazovateľ</th><th scope="col">Úmrtie z akejkoľvek príčiny</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">&lt; 0,9</th><td><strong>5,78</strong> (3,57 – 9,35)</td><td>1,67 (1,23 – 2,29)</td><td>1,51 (1,27 – 1,79)</td><td>1,55 (1,28 – 1,89)</td></tr>
    <tr><th scope="row">0,9 – &lt; 1,0 <em>(„normálne“ podľa konvencie)</em></th><td><strong>2,76</strong> (1,56 – 4,88)</td><td><strong>1,85</strong> (1,33 – 2,57)</td><td>1,39 (1,15 – 1,68)</td><td>1,36 (1,10 – 1,69)</td></tr>
    <tr><th scope="row">1,0 – &lt; 1,4</th><td colspan="4">referenčná kategória — najnižšie riziko</td></tr>
    <tr><th scope="row">≥ 1,4</th><td><strong>4,85</strong> (2,05 – 11,50)</td><td>2,08 (1,10 – 3,93)</td><td>1,23 (0,82 – 1,84) — nevýznamné</td><td>1,00 (0,62 – 1,62) — nevýznamné</td></tr>
  </tbody>
</table>
<p><em>Chen J a kol., J Am Heart Assoc 2016;5(6):e003339. Údaje sú pomery rizík (95 % IS) upravené na viaceré premenné, oproti referenčnej kategórii ABI 1,0 – &lt; 1,4.</em></p>
</div>

<p>Z tejto tabuľky plynie nález, ktorý mení prax:</p>

<blockquote>
<p>Pacienti s ABI <strong>0,9 až 1,0</strong> — teda s hodnotou, ktorú konvenčné kritériá označujú za <em>normálnu</em> — mali v kohorte CRIC <strong>takmer trojnásobné riziko rozvoja PAD</strong> a dokonca <em>vyššie</em> upravené riziko infarktu myokardu než skupina s ABI pod 0,9.</p>
</blockquote>

<p>Autori z toho vyvodzujú, že pri CKD by sa mali ďalej hodnotiť hraničné hodnoty <strong>ABI pod 1,0 alebo ≥ 1,4</strong> pre diagnózu PAD a <strong>ABI pod 1,0</strong> pre stratifikáciu kardiovaskulárneho rizika. Pre ambulantnú prax to znamená jediné: <strong>hodnotu 0,95 u pacienta s CKD nemožno odškrtnúť ako „v norme“.</strong></p>

<h3>A čo mortalita</h3>

<p>Aktualizovaný systematický prehľad s metaanalýzou (<em>Critical Pathways in Cardiology</em>, 2025) zahrnul <strong>10 kohortových štúdií a 13 378 účastníkov</strong> s CKD vrátane hemodialyzovaných:</p>

<div class="table-responsive" role="region" aria-label="Abnormálne ABI a mortalita pri CKD podľa metaanalýzy 2025" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">ABI</th><th scope="col">Kardiovaskulárna mortalita</th><th scope="col">Celková mortalita</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Nízke (&lt; 0,9)</th><td>2,23 (1,75 – 2,83)</td><td>1,78 (1,55 – 2,05)</td></tr>
    <tr><th scope="row">Vysoké (≥ 1,3)</th><td><strong>2,77</strong> (1,74 – 4,41)</td><td>1,49 (1,09 – 2,02)</td></tr>
    <tr><th scope="row">Akékoľvek abnormálne</th><td>2,34 (1,93 – 2,85)</td><td>1,74 (1,54 – 1,96)</td></tr>
  </tbody>
</table>
<p><em>Hazique M a kol., Crit Pathw Cardiol 2025;24(3):e0396. Za normálne sa v tejto analýze považovali hodnoty 0,9 – 1,3. Riziko bolo vyššie u hemodialyzovaných než u nedialyzovaných pacientov s CKD.</em></p>
</div>

<p>Pozoruhodné je, že <strong>vysoké ABI predpovedalo kardiovaskulárnu mortalitu silnejšie než nízke</strong>. Nestlačiteľná tepna teda nie je len technický artefakt, ktorý vyšetrenie znehodnocuje — je to <em>samostatný prognostický signál</em> o rozsahu cievnej kalcifikácie. V bežnej praxi sa pritom hodnota 1,45 často odloží ako „nemerateľné“ a nikam nevedie.</p>

<h2>Čím ABI doplniť</h2>

<p>Keď je ABI pri CKD nejasné, hraničné alebo falošne vysoké, pomáhajú postupy, ktoré kalcifikácia ovplyvňuje menej:</p>

<ul>
  <li><strong>Prstovo-ramenný index (TBI)</strong> — digitálne tepny podliehajú mediálnej kalcifikácii podstatne menej, takže TBI je pri nestlačiteľných členkových tepnách spoľahlivejší. Bežne používaný prah abnormality je <strong>pod 0,70</strong>.</li>
  <li><strong>Tvar dopplerovskej krivky a segmentálne tlaky</strong> — monofázický signál svedčí pre významnú proximálnu obštrukciu aj pri „normálnom“ ABI.</li>
  <li><strong>Duplexná sonografia</strong> na lokalizáciu a kvantifikáciu lézie.</li>
  <li><strong>Pozor na kontrastné vyšetrenia.</strong> CT angiografia aj klasická angiografia znamenajú u pacienta s CKD expozíciu jódovej kontrastnej látke. Indikáciu treba vážiť a koordinovať s cievnym tímom — nie ju automaticky objednať pri každom nejasnom ABI.</li>
</ul>

<h2>Koho skrínovať v nefrologickej ambulancii</h2>

<p>Plošný skríning všetkých pacientov s CKD nemá dôkazový podklad. Cielený prístup má zmysel u pacientov s:</p>

<ul>
  <li><strong>diabetom</strong> — kombinácia diabetu a CKD je pre mediálnu kalcifikáciu aj pre PAD najrizikovejšia,</li>
  <li>anamnézou fajčenia,</li>
  <li>známym kardiovaskulárnym ochorením alebo cievnym postihnutím v inom povodí,</li>
  <li>klaudikáciami alebo atypickými záťažovými ťažkosťami dolných končatín,</li>
  <li>ranou, ulceráciou alebo poruchou hojenia na nohe,</li>
  <li>vyšším vekom a krehkosťou, kde aj mierna porucha prekrvenia zhoršuje chôdzu a zvyšuje riziko pádov,</li>
  <li><strong>pred zaradením do transplantačného programu</strong> a <strong>pred plánovaním cievneho prístupu</strong>, kde je stav periférneho riečiska priamo relevantný.</li>
</ul>

<h2>Praktický postup</h2>

<ol>
  <li><strong>Klinické vyšetrenie.</strong> Anamnéza klaudikácií a zmeny tolerancie chôdze, pohmat periférnych pulzov, teplota a farba kože, trofické zmeny, ulcerácie. U diabetika s neuropatiou môžu klaudikácie <em>chýbať</em> napriek významnej ischémii — absencia príznakov nič nevylučuje.</li>
  <li><strong>ABI</strong> za štandardizovaných podmienok.</li>
  <li><strong>Interpretácia s poistkou pre CKD:</strong>
    <ul>
      <li><strong>pod 0,9</strong> — PAD pravdepodobné, pokračovať v diagnostike;</li>
      <li><strong>0,9 až 1,0</strong> — <em>nie je to norma</em>; podľa dát CRIC ide o skupinu so zvýšeným rizikom, ktorá si zaslúži klinickú pozornosť a agresívnu kontrolu rizikových faktorov;</li>
      <li><strong>1,0 až 1,4</strong> — najnižšie riziko, ale pri jasnej klinike treba doplniť ďalšie vyšetrenie;</li>
      <li><strong>≥ 1,4</strong> — nestlačiteľné tepny; ABI je nehodnotiteľné pre diagnózu, ale <strong>je samo o sebe prognosticky nepriaznivým nálezom</strong>. Doplniť TBI a dopplerovskú krivku.</li>
    </ul>
  </li>
  <li><strong>Liečba rizikových faktorov sa začína bez ohľadu na to</strong>, či sa PAD potvrdí zobrazovaním — abnormálne ABI je samostatnou indikáciou na intenzívnu kardiovaskulárnu prevenciu.</li>
  <li><strong>Odoslanie k cievnemu tímu</strong> pri potvrdenom PAD so symptómami, pri non-hojacej sa rane, pokojovej bolesti alebo známkach kriticky ohrozenej končatiny — tam ide o urgentnú konzultáciu, nie o plánované vyšetrenie.</li>
</ol>

<h2>Čo tieto dáta nehovoria</h2>

<ul>
  <li><strong>Neexistuje randomizovaná štúdia, ktorá by preukázala, že skríning ABI u pacientov s CKD zlepšuje výsledky.</strong> Všetko, čo máme, je prognostická asociácia plus biologicky vierohodná úvaha, že skoršie rozpoznanie umožní skoršiu liečbu.</li>
  <li><strong>Prahy pre CKD nie sú formálne prijaté.</strong> Autori kohorty CRIC odporúčajú prahy pod 1,0 a ≥ 1,4 <em>ďalej hodnotiť</em> — nie ich okamžite zaviesť. Článok ich preto uvádza ako dôvod na opatrnosť pri interpretácii, nie ako nové kritérium.</li>
  <li><strong>Metaanalýza z roku 2025 pracovala s inou hranicou vysokého ABI (≥ 1,3) než kohorta CRIC (≥ 1,4)</strong>, čo ilustruje, že ani v literatúre nie je zhoda.</li>
</ul>

<h2>Záver</h2>

<p>Periférne arteriové ochorenie je pri chronickej chorobe obličiek časté, prognosticky závažné a ľahko prehliadnuteľné. Jeho najdostupnejší skríningový test je u tejto populácie zároveň najmenej spoľahlivý — a zlyháva <strong>v smere, ktorý upokojuje</strong>.</p>

<p>Praktický záver je preto jednoduchý a dá sa zhrnúť do jednej vety: <strong>u pacienta s CKD čítajte ABI ako kontinuálnu premennú s rizikom na oboch koncoch, nie ako test s jedným prahom — a nikdy nezamieňajte normálny výsledok za vylúčenie choroby.</strong></p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Zhou J, Liu X, Shan S a kol. <em>Global, regional, and national prevalence of peripheral arterial disease in 2023: an updated systematic review and modelling study.</em> Lancet Glob Health 2026;14(9):103983. <a href="https://doi.org/10.1016/j.langlo.2026.103983" target="_blank" rel="noopener noreferrer">doi:10.1016/j.langlo.2026.103983</a> (PMID 42480579).</li>
  <li>Chen J, Mohler ER, Garimella PS a kol. <em>Ankle Brachial Index and Subsequent Cardiovascular Disease Risk in Patients With Chronic Kidney Disease</em> (kohorta CRIC). J Am Heart Assoc 2016;5(6):e003339. <a href="https://doi.org/10.1161/JAHA.116.003339" target="_blank" rel="noopener noreferrer">doi:10.1161/JAHA.116.003339</a> (PMID 27247339).</li>
  <li>Hazique M, Surana A, Patel KN a kol. <em>Abnormal Ankle-Brachial Index and Risk of Cardiovascular and all-cause mortality in Patients With Chronic Kidney Disease: An Updated Systematic Review and Meta-analysis.</em> Crit Pathw Cardiol 2025;24(3):e0396. <a href="https://doi.org/10.1097/HPC.0000000000000396" target="_blank" rel="noopener noreferrer">doi:10.1097/HPC.0000000000000396</a> (PMID 40397761).</li>
</ol>

<p><em>Bibliografické údaje všetkých citovaných prác boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza platné odporúčania odborných spoločností pre diagnostiku a liečbu periférneho arteriového ochorenia ani individuálne klinické rozhodnutie.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_periferne-arteriove-ochorenie-abi-skrining-ckd_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

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
