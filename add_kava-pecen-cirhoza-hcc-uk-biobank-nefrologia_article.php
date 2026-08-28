<?php

/**
 * add_kava-pecen-cirhoza-hcc-uk-biobank-nefrologia_article.php
 * Odborný článok: príjem kávy a pečeňové ukazovatele v UK Biobank.
 * Spracovaný zdroj: Kim HS, Rezaee-Zavareh MS, Wang Y, et al.
 * Clin Gastroenterol Hepatol. 2026. doi 10.1016/j.cgh.2026.04.035 (PMID 42385787).
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
    'title'        => 'Káva a pečeň v UK Biobank: nižšie riziko cirhózy a hepatocelulárneho karcinómu a čo z toho platí pre pacienta s chorobou obličiek',
    'slug'         => 'kava-pecen-cirhoza-hcc-uk-biobank-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'U 354 957 účastníkov sa vyšší príjem kávy spájal s nižším rizikom cirhózy, hepatocelulárneho karcinómu aj úmrtia z pečeňovej príčiny. Pri chorobe obličiek rozhoduje skôr to, čo je v šálke okrem kávy.',
    'content'      => <<<'HTML'
<p>Súvislosť medzi pitím kávy a zdravím pečene je opakovane opisovaná, väčšinou však na základe jedného typu údajov. Analýza z kohorty UK Biobank je zaujímavá tým, že spája tri vrstvy naraz: klinické ukazovatele, zobrazovacie markery z magnetickej rezonancie a proteomický profil. Výsledok je konzistentný naprieč všetkými tromi — čo posilňuje biologickú vierohodnosť, no nemení observačnú povahu zistenia.</p>

<h2>Dizajn</h2>

<p>Analyzovaných bolo <strong>354 957 účastníkov</strong> UK Biobank bez cirhózy a bez hepatocelulárneho karcinómu na začiatku sledovania. Príjem kávy, jej typ (s kofeínom alebo bez neho) a prísady (cukor alebo sladidlá) sa zisťovali dotazníkom. Výskyt cirhózy, hepatocelulárneho karcinómu a úmrtia z pečeňovej príčiny sa zisťoval z prepojených registrov. V podskupine <strong>28 961</strong> účastníkov sa magnetickou rezonanciou hodnotil obsah tuku v pečeni, obsah železa a fibrozápalový marker (na železo korigovaný čas T1); u <strong>44 633</strong> účastníkov sa robil proteomický profil metódou Olink. Modely boli upravené na demografické, behaviorálne, metabolické a genetické premenné.</p>

<h2>Výsledky</h2>

<p>Počas mediánu sledovania <strong>13 rokov</strong> sa pozoroval odstupňovaný vzťah medzi príjmom kávy a pečeňovými ukazovateľmi. Pre skupinu s príjmom <strong>≥ 5 šálok denne</strong> oproti referenčnej skupine:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Riziko pečeňových ukazovateľov pri príjme aspoň piatich šálok kávy denne" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Pomer rizík (HR)</th>
        <th scope="col">95 % IS</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Cirhóza</th>
        <td>0,68</td>
        <td>0,58 – 0,79</td>
      </tr>
      <tr>
        <th scope="row">Hepatocelulárny karcinóm</th>
        <td>0,53</td>
        <td>0,34 – 0,83</td>
      </tr>
      <tr>
        <th scope="row">Úmrtie z pečeňovej príčiny</th>
        <td>0,58</td>
        <td>0,45 – 0,74</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Vyšší príjem kávy sa spájal aj s nižším obsahom tuku a železa v pečeni a s nižšou mierou fibrozápalu. Proteomická analýza ukázala konzistentný obraz: vyššie hladiny bielkovín spojených s hepatocelulárnou syntézou a komplementom a nižšie hladiny markerov fibrogenézy a aktivácie makrofágov.</p>

<h3>Kofeín zrejme nie je celý príbeh</h3>

<p>Asociácie boli <strong>podobné pri káve s kofeínom aj bez kofeínu</strong>. To posúva pozornosť od kofeínu k ďalším zložkám kávy — polyfenolom, kyseline chlorogénovej, diterpénom. Rovnaké pozorovanie sa objavuje aj v prácach o vplyve kávy na črevný mikrobióm.</p>

<h3>Cukor a sladidlá: presnejšie znenie, než sa zvyčajne uvádza</h3>

<p>Tento bod býva v sekundárnych spracovaniach posunutý. Podľa práce ochranné asociácie <strong>pretrvávali aj u tých, ktorí si kávu sladili</strong> cukrom alebo umelými sladidlami; používanie prísad však súviselo s <strong>mierne vyšším</strong> na železo korigovaným časom T1, teda s nepriaznivejším fibrozápalovým markerom. Nie je teda správne tvrdiť, že prisladenie prínos ruší — presnejšie je, že prisladená káva vychádza v jednom zobrazovacom ukazovateli o niečo horšie.</p>

<h2>Ako výsledok čítať</h2>

<p>Ide o prospektívnu observačnú analýzu s expozíciou zistenou dotazníkom. Platia pre ňu obvyklé výhrady: nepresnosť samovykazovania, zvyškové zavádzajúce faktory a možnosť obrátenej príčinnosti — ľudia s ťažkosťami môžu pitie kávy obmedziť skôr, než sa ochorenie diagnostikuje. Zhoda naprieč klinickými, zobrazovacími a proteomickými údajmi je silným argumentom pre biologickú vierohodnosť, ale všetky tri vrstvy pochádzajú z tej istej kohorty a zdieľajú tie isté zdroje skreslenia.</p>

<p>Za zmienku stojí, že autori v závere odporúčajú „miernu nesladenú kávu ako jednoduchú stratégiu prevencie ochorenia pečene“. Ide o odporúčanie formulované silnejšie, než observačný dizajn unesie — podobne ako v mnohých nutričných epidemiologických prácach. Vzhľadom na to, že káva je lacná, dostupná a pri bežnom príjme bezpečná, je cena prípadného omylu nízka; formulácia „spojené s nižším rizikom“ však zostáva presnejšia než „chráni“.</p>

<p>Účastníci UK Biobank sú prevažne európskeho pôvodu a zdravší než bežná populácia, čo obmedzuje prenositeľnosť.</p>

<h2>Nefrologický kontext: prečo to nie je iba hepatologická téma</h2>

<p>Priama súvislosť s obličkami z tejto práce nevyplýva — nesledovala obličkové ukazovatele. Relevantná je nepriamo, cez dve cesty:</p>

<ul>
  <li><strong>Steatotické ochorenie pečene spojené s metabolickou dysfunkciou (MASLD)</strong> zdieľa s CKD rizikové faktory aj patofyziológiu a jeho prítomnosť sa spája s vyšším rizikom progresie choroby obličiek. Čokoľvek, čo zaťaženie pečene znižuje, je preto v kardiometabolickom manažmente pacienta s CKD relevantné.</li>
  <li><strong>Pacienti s pokročilou CKD sa lekára na kávu pýtajú často</strong> — a odpoveď býva zbytočne reštriktívna.</li>
</ul>

<h3>Čo pri CKD pri káve skutočne zvážiť</h3>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Praktické hľadiská pri konzumácii kávy u pacienta s chronickou chorobou obličiek" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Hľadisko</th>
        <th scope="col">Praktická poznámka</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Draslík</th>
        <td>Samotná káva obsahuje draslík v miernom množstve, pri vysokom počte šálok denne sa však príspevok sčítava. Pri hyperkaliémii má zmysel počet šálok zohľadniť, nie kávu plošne zakázať.</td>
      </tr>
      <tr>
        <th scope="row">Mlieko a smotanové prípravky</th>
        <td>Väčší problém než káva samotná: prinášajú fosfor aj draslík. Bielidlá do kávy môžu obsahovať fosforečnanové aditíva s vysokou vstrebateľnosťou.</td>
      </tr>
      <tr>
        <th scope="row">Príjem tekutín</th>
        <td>U dialyzovaného pacienta s obmedzeným príjmom tekutín sa káva započítava do denného objemu.</td>
      </tr>
      <tr>
        <th scope="row">Krvný tlak</th>
        <td>Kofeín môže prechodne zvýšiť krvný tlak. Pri meraní tlaku v ambulancii aj doma treba dodržať odstup od poslednej šálky.</td>
      </tr>
      <tr>
        <th scope="row">Prisladzovanie</th>
        <td>Pri metabolickom riziku je nesladená káva rozumnejšia voľba — aj podľa uvedenej práce, aj z hľadiska celkového príjmu cukru.</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Záver</h2>

<p>V rozsiahlej prospektívnej kohorte sa vyšší príjem kávy spájal s nižším rizikom cirhózy, hepatocelulárneho karcinómu aj úmrtia z pečeňovej príčiny, s odstupňovaným vzťahom a s konzistentnými zobrazovacími a proteomickými nálezmi. Podobný obraz pri káve s kofeínom aj bez neho naznačuje, že rozhodujúcou zložkou nemusí byť kofeín. Pre nefrologickú prax z toho nevyplýva nový liečebný postup, ale užitočná odpoveď na častú otázku pacienta: káva pri chorobe obličiek spravidla nie je problém — problémom býva to, čo si do nej pridáva, a pri pokročilej chorobe celkový objem.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kava-crevny-mikrobiom-ucinok-presahuje-kofein">Káva a črevný mikrobióm: účinok presahuje kofeín</a></li>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">MASLD: diagnostika a fibróza v nefrologickej praxi</a></li>
  <li><a href="article.php?slug=vyzivove-odporucania-usa-2025-2030-masld-ckd">Výživové odporúčania 2025 – 2030 z pohľadu MASLD a CKD</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri CKD: edukovať, nie strašiť</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Kim HS, Rezaee-Zavareh MS, Wang Y, Attia AM, Kwak M, Burm S, Celtik D, Legaspi D, Khattab O, Kim N, Mengistu BM, Larios KN, Kim DS, Ayoub W, Kuo A, Martin P, Vipani A, Wang Y, Liangpunsakul S, Li D, Lu SC, Pandol S, Yang JD. Coffee Consumption and Improved Liver Outcomes: Clinical, Imaging, and Proteomic Evidence From the UK Biobank. <em>Clinical Gastroenterology and Hepatology</em>. Publikované online 1. júla 2026. doi: <a href="https://doi.org/10.1016/j.cgh.2026.04.035" target="_blank" rel="noopener noreferrer">10.1016/j.cgh.2026.04.035</a>. PMID 42385787, PMCID PMC13505578. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13505578/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam (23 mien), veľkosti kohorty a podskupín, dĺžka sledovania aj všetky uvedené pomery rizík boli overené 28. augusta 2026 cez PubMed zo štruktúrovaného abstraktu spracovanej práce. Číselné hodnoty pre rozdiely v obsahu tuku a železa v pečeni a pre pomer šancí pri prísadách nie sú v abstrakte uvedené, preto sa v článku neuvádzajú; opisujú sa len smery zmien. Praktické poznámky pre pacientov s CKD nie sú prevzaté od autorov — spracovaná práca obličkové ukazovatele nesledovala.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani manažment príčiny ochorenia pečene. Odporúčania týkajúce sa príjmu tekutín, draslíka a fosforu treba prispôsobiť štádiu chronickej choroby obličiek a aktuálnym laboratórnym hodnotám.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    // Publikované v dávke viacerých článkov naraz — newsletterové avízo sa zámerne
    // neposiela, aby odberatelia nedostali viacero samostatných e-mailov naraz.
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kava_pecen_cirhoza_hcc_uk_biobank',
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
