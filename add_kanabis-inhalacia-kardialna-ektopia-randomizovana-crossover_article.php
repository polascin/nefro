<?php
/**
 * add_kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover_article.php
 * Odborný článok: akútny vplyv inhalovaného kanabisu na kardiálnu ektopiu
 * (štúdia MARY-JANE, JACC 2026; NCT06021613).
 *
 * Pôvodní autori spracovanej práce sú uvedení v source_authors.php.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Inhalovaný kanabis a kardiálna ektopia: čo prináša randomizovaná krížená štúdia (a prečo z toho zatiaľ nevzniká odporúčanie „liečiť“ arytmie)',
    'slug'         => 'kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Randomizovaná krížená štúdia MARY-JANE u 108 pravidelných užívateľov inhalovaného kanabisu ukázala približne 9 % menej dennej kardiálnej ektopie. Výsledok nemení prax a nedokazuje, že kanabis lieči arytmie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>V randomizovanej kríženej štúdii MARY-JANE mali pravidelní užívatelia inhalovaného kanabisu v dňoch s pridelenou inhaláciou približne o 9 % menej denných extra sťahov srdca ako v dňoch s pridelenou abstinenciou. Za poklesom stáli predčasné predsieňové extrasystoly; komorové extrasystoly, kroky, dĺžka spánku ani glukóza sa významne nezmenili. Ide o akútny, náhradný ukazovateľ v mladom súbore bez známej arytmie — nie o výskyt fibrilácie predsiení, hospitalizácie či úmrtia. Štúdia nemení prax a nedokazuje, že kanabis arytmie lieči, ani že je kardiovaskulárne bezpečný.</em></p>

<p>Tento text je slovenské spracovanie primárnej práce Eliasa a spol. v časopise <em>Journal of the American College of Cardiology</em> (<em>JACC</em>), publikovanej online 30. júla 2026. Čísla sú overené proti otvorenému abstraktu, záznamu PubMed (PMID 42584385), registru Crossref a záznamu ClinicalTrials.gov <a href="https://clinicaltrials.gov/study/NCT06021613" target="_blank" rel="noopener noreferrer">NCT06021613</a>. Plný text za paywallom sme neotvárali; kde abstrakt údaj neuvádza, výslovne to povieme.</p>

<h2>Čo znamená kardiálna ektopia</h2>

<p><strong>Kardiálna ektopia</strong> (z angl. <em>cardiac ectopy</em>) označuje extra sťahy srdca, ktoré nevznikajú v sínusovom uzle. V tejto štúdii ide o súčet:</p>

<ul>
  <li><strong>predčasných predsieňových extrasystol</strong> (PAC, z angl. <em>premature atrial contractions</em>) — extra sťahy začínajúce v predsieni,</li>
  <li><strong>predčasných komorových extrasystol</strong> (PVC, z angl. <em>premature ventricular contractions</em>) — extra sťahy začínajúce v komore.</li>
</ul>

<p>Ojedinelé extrasystoly sú u dospelých bežné. Častejšie PAC sa v kohortových prácach spájajú s neskorším vznikom fibrilácie predsiení; vyššia záťaž PVC sa spája s rizikom srdcového zlyhávania. To z ektopie robí <strong>náhradný (proxy) ukazovateľ</strong>, nie klinický výsledok, podľa ktorého by sa malo meniť liečebné rozhodnutie.</p>

<p>Observačné práce o kanabise a srdci sú rozporuplné. Niektoré spájajú užívanie s vyšším rizikom fibrilácie predsiení a iných kardiovaskulárnych príhod, iné sú nejednoznačné. Vedecké stanovisko American Heart Association z roku 2020 preto kanabis z hľadiska srdca a ciev nepokladá za neškodný. Randomizovaný akútny pokus s objektívnym EKG práve preto dával zmysel — a vyšiel proti pôvodnej hypotéze autorov.</p>

<h2>Dizajn štúdie MARY-JANE</h2>

<p>MARY-JANE je skratka z angl. <em>Marijuana and Acute Risk of Arrhythmia – Joint Abstinence and Exposure</em>. Primárna publikácia ju opisuje ako prospektívnu randomizovanú kríženú (crossover) štúdiu: ten istý účastník strieda dni s inhaláciou a dni s abstinenciou, takže slúži ako vlastná kontrola. Sledovanie trvalo 14 dní. Pridelenie dňa (inhalovať, alebo abstinovať) dostávali účastníci textovou správou.</p>

<p>Podľa registra ClinicalTrials.gov išlo o dizajn s dvojdennými blokmi (začať dňom s kanabisom, alebo dňom bez neho). Účastníci mali v dňoch s inštrukciou konzumovať kanabis <strong>fajčiť alebo vapovať aspoň raz</strong>. Kanabis si obstarávali sami; štúdia teda nepodávala štandardizovaný produkt s určeným obsahom tetrahydrokanabinolu (THC). Sledovanie prebiehalo na Kalifornskej univerzite v San Franciscu (UCSF).</p>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdie MARY-JANE" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj (otvorený abstrakt a NCT06021613)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Súbor v publikácii</th>
      <td>108 dospelých pravidelne fajčiacich alebo vapujúcich kanabis, bez anamnézy srdcových arytmií</td>
    </tr>
    <tr>
      <th scope="row">Priemerný vek</th>
      <td>32 ± 10 rokov</td>
    </tr>
    <tr>
      <th scope="row">Pohlavie a etnicita</th>
      <td>59 % ženy; 37 % osôb nehispánskeho belošského pôvodu</td>
    </tr>
    <tr>
      <th scope="row">Dni v analýze</th>
      <td>713 dní randomizovaných k inhalácii, 616 dní k abstinencii</td>
    </tr>
    <tr>
      <th scope="row">Trvanie</th>
      <td>14 dní; centrum UCSF (San Francisco)</td>
    </tr>
    <tr>
      <th scope="row">Primárny ukazovateľ</th>
      <td>denná kardiálna ektopia (PAC + PVC) z náplasťového EKG monitora Zio</td>
    </tr>
    <tr>
      <th scope="row">Ďalšie merania</th>
      <td>priemerná glukóza (kontinuálny monitor), počet krokov, dĺžka spánku</td>
    </tr>
    <tr>
      <th scope="row">Adherencia</th>
      <td>časovo označené stlačenie tlačidla na náplasti Zio pri užití, denné dotazníky, v podskupine hmotnostná spektrometria slín</td>
    </tr>
    <tr>
      <th scope="row">Register</th>
      <td>NCT06021613; plánovaný nábor 100, skutočný nábor 108</td>
    </tr>
  </tbody>
</table>
</div>

<p>Zaradenie podľa registra: vek aspoň 21 rokov, inhalovaný kanabis v uplynulom mesiaci a aspoň v štyroch rôznych dňoch toho istého týždňa v uplynulom roku, ochota striedať konzumáciu a abstinenciu podľa inštrukcií (najviac dva po sebe nasledujúce dni v danom režime), vlastný kanabis a miesto, kde inhalácia nie je v rozpore s právom.</p>

<p>Vylúčení boli podľa registra okrem iného tehotné ženy, osoby s medicínskym dôvodom vyhnúť sa kanabisu, osoby na antiarytmikách, s anamnézou fibrilácie predsiení alebo srdcového zlyhávania, s vrodenou srdcovou chybou, s implantabilným kardioverterom-defibrilátorom alebo kardiostimulátorom, po predchádzajúcej srdcovej ablácii a osoby na inzulíne. Súbor teda nie je obrazom typického pacienta s chronickou chorobou obličiek (CKD), dialýzou ani s už známou arytmiou.</p>

<h2>Hlavné výsledky</h2>

<p>Adherencia k randomizácii bola podľa abstraktu <strong>nedokonalá, ale vcelku v súlade s pridelením</strong>. Závery štúdie označujú adherenciu za strednú.</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky štúdie MARY-JANE podľa otvoreného abstraktu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Inhalácia oproti abstinencii</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Denná ektopia (PAC + PVC)</th>
      <td>pomer sadzieb (RR) 0,91 (95 % interval spoľahlivosti [IS] 0,85–0,98), P = 0,02; relatívne zníženie približne 9 %</td>
    </tr>
    <tr>
      <th scope="row">Predčasné predsieňové extrasystoly (PAC)</th>
      <td>RR 0,90 (95 % IS 0,82–0,97), P = 0,012; relatívne zníženie približne 10 %</td>
    </tr>
    <tr>
      <th scope="row">Predčasné komorové extrasystoly (PVC)</th>
      <td>bez štatisticky významnej zmeny; otvorený abstrakt neuvádza RR ani P</td>
    </tr>
    <tr>
      <th scope="row">Jedna inhalácia (dávkový gradient)</th>
      <td>RR 0,98 (95 % IS 0,97–0,99), P = 0,043; približne 2 % menej ektopie na jednu inhaláciu</td>
    </tr>
    <tr>
      <th scope="row">Kroky, dĺžka spánku, glukóza</th>
      <td>bez významného rozdielu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Účinok je štatisticky významný, ale <strong>veľkosťou skromný</strong> a viazaný na PAC. Komorová zložka ektopie sa podľa abstraktu nezmenila. Abstrakt neuvádza medián denného počtu extrasystol; v mladom súbore bez známej arytmie treba počítať s nízkou východiskovou záťažou, takže relatívnych 9 % môže v absolútnych číslach znamenať málo extra sťahov za deň.</p>

<p>Obsah THC, podiel CBD, značka produktu ani pomer fajčenia a vapovania v otvorenom abstrakte nie sú. Heterogénna expozícia je teda súčasťou pragmatického dizajnu, nie presne dávkovaného farmakologického pokusu.</p>

<h2>Čo z toho nevyplýva</h2>

<p>Autori v záveroch sami uvádzajú, že interpretáciu kauzálneho mechanizmu obmedzujú <strong>možné abstinenčné (odvykacie) účinky, stredná adherencia a kointervencia</strong>. To nie je drobná poznámka pod čiarou. U navyknutých užívateľov môže deň bez kanabisu ektopiu zvýšiť abstinenciou, nie deň s kanabisom ju znížiť priaznivým účinkom na myokard. Kointervencia znamená, že s inhaláciou sa môžu meniť aj iné správania (kofeín, alkohol, spánok, aktivita), ktoré abstrakt ako významne odlišné v priemere neukázal, ale ktoré mechanizmus predsa len môžu zahmlievať.</p>

<p>Štúdia <strong>nebola navrhnutá na hodnotenie výskytu fibrilácie predsiení</strong>, hospitalizácie, srdcového zlyhávania ani úmrtia. Nemerala dlhodobú bezpečnosť, endotelovú funkciu, ischémiu, pľúcne následky inhalácie ani závislosť. Neodpovedá na otázku, či má niekto začať kanabis užívať, pokračovať v ňom, alebo ho vysadiť pre arytmiu.</p>

<p><strong>Z výsledku preto nevzniká odporúčanie „liečiť“ extrasystoly či fibriláciu predsiení kanabisom.</strong> Nevzniká ani dôkaz, že inhalovaný kanabis je pre srdce bezpečný. Akútny pokles náhradného ukazovateľa v selektovanej, relatívne mladej populácii navyknutých užívateľov nemožno preklopiť do klinickej indikačnej vety.</p>

<h2>Čo z toho plynie pri CKD a dialýze</h2>

<p>Pacienti s CKD a najmä s dialýzou majú vysoké kardiovaskulárne riziko, častejšiu fibriláciu predsiení, objemové a elektrolytové výkyvy a často pokročilý vek. MARY-JANE takúto populáciu neskúmala: priemerný vek 32 rokov, bez známej arytmie, bez antiarytmík, bez srdcového zlyhávania a bez inzulínu. <strong>Výsledky sa na CKD a dialýzu extrapolovať nedajú.</strong></p>

<p>V ambulancii a na dialyzačnej sále má zmysel pýtať sa na užívanie kanabisu <strong>bez odsudzovania</strong> — rovnako ako na alkohol, tabak a iné inhalované látky. Dôvodom nie je moralizovanie, ale kardiovaskulárne riziko, možné liekové interakcie (polyfarmácia, imunosupresia po transplantácii obličky), sedácia, kolísanie krvného tlaku a adherencia k liečbe. Otázka v anamnéze nie je súhlas s fajčením ako liečbou.</p>

<p>Inhalácia dymu či výparov ostáva expozíciou dýchacích ciest a cievneho endotelu. Táto štúdia to nevyvracia. <strong>Kanabis sa ako antiarytmikum, nefroprotektívum ani „bezpečnejšia náhrada“ inej liečby predpisovať nemá.</strong></p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>MARY-JANE je užitočný akútny experiment: v dňoch s randomizovanou inhaláciou mali navyknutí užívatelia o niečo menej dennej ektopie, predovšetkým PAC, bez významnej zmeny PVC, krokov, spánku a glukózy. Nález je v rozpore s pôvodnou hypotézou a s časťou observačnej literatúry, preto si zaslúži pozornosť — ako podnet na mechanizmus, nie ako návod na liečbu.</p>

<p><strong>Prax sa nemení.</strong> Extra sťahy srdca tu nie sú klinickým cieľom liečby kanabisom. Pacientovi s extrasystolami, fibriláciou predsiení, CKD alebo dialýzou treba povedať pravý opak marketingového skratkovitého výkladu: táto štúdia nedokazuje, že má kanabis inhalovať, aby si „liečil“ arytmiu, a nedokazuje, že je to pre srdce bezpečné.</p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita">Pohybová aktivita pri fibrilácii predsiení: nižšie riziko cievnej mozgovej príhody a úmrtia</a> — observačný vzťah pohybu a prognózy, nie náhrada antikoagulácie.</li>
  <li><a href="article.php?slug=wearables-dialyza-nefrologia-dokazy-a-limity">Nositeľné senzory v nefrológii a dialýze</a> — čo z náplasťového a hodinkového EKG obstojí pri zlyhaní obličiek.</li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Elias A, Montenegro GC, Oo HH, Peña IJ, Lowe DA, Lee C, Tang J, Lynch KL, Lim L, Maamou M, Nguyen N, Springer ML, Marcus GM.</strong> <em>Acute Effects of Cannabis Inhalation on Cardiac Ectopy, Physical Activity, Sleep, and Glucose.</em> J Am Coll Cardiol. Publikované online 30. júla 2026. doi: 10.1016/j.jacc.2026.07.014. PMID: 42584385. <a href="https://www.jacc.org/doi/10.1016/j.jacc.2026.07.014" target="_blank" rel="noopener noreferrer">JACC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42584385/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1016/j.jacc.2026.07.014" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>University of California, San Francisco.</strong> <em>The MARY-JANE Cannabis and Heart Rhythm Trial.</em> ClinicalTrials.gov NCT06021613. <a href="https://clinicaltrials.gov/study/NCT06021613" target="_blank" rel="noopener noreferrer">Záznam registra</a>.</li>
  <li><strong>University of California – San Francisco.</strong> <em>Unexpected findings add new insight on cannabis and heart health.</em> EurekAlert, 12. augusta 2026. Verejná tlačová správa k primárnej štúdii. <a href="https://www.eurekalert.org/news-releases/1139724" target="_blank" rel="noopener noreferrer">EurekAlert</a>.</li>
  <li><strong>Page RL 2nd, Allen LA, Kloner RA, et al.</strong> <em>Medical Marijuana, Recreational Cannabis, and Cardiovascular Health: A Scientific Statement From the American Heart Association.</em> Circulation. 2020;142(10):e131–e152. doi: 10.1161/CIR.0000000000000883. <a href="https://doi.org/10.1161/CIR.0000000000000883" target="_blank" rel="noopener noreferrer">Stanovisko AHA</a>.</li>
  <li><strong>Medscape Professional Network.</strong> <em>Cannabis Inhalation Linked to Less Cardiac Ectopy in Randomized Trial.</em> 2026. Sekundárne spracovanie; individuálny novinár nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. <a href="https://www.medscape.com/viewarticle/cannabis-inhalation-linked-less-cardiac-ectopy-randomized-2026a1000tb7" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Článok sumarizuje otvorené údaje randomizovanej kríženej štúdie a verejný register. Nie je návodom na užívanie kanabisu, na zmenu antiarytmickej liečby ani na odklad kardio- alebo nefroprotektívnej starostlivosti.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kanabis-inhalacia-kardialna-ektopia-randomizovana-crossover_article',
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
