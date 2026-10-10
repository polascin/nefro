<?php

/**
 * CKM syndrom ako mitochondrialna systemova porucha.
 * Odborne spracovanie prehladu Nature Reviews Nephrology z 24. 9. 2026.
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
    'title'        => 'CKM syndróm ako mitochondriálna systémová porucha: zápal, energetika a orgánové prepojenia',
    'slug'         => 'ckm-syndrom-mitochondrie-zapal-organy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Srdce, obličky, tukové tkanivo a pečeň prepája obojsmerná metabolická komunikácia. Mitochondriálna dysfunkcia môže CKM syndróm zosilňovať, zatiaľ však nie je samostatným klinickým cieľom.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Kardiovaskulárno-obličkovo-metabolický syndróm nie je iba súbehom obezity, diabetu, chronickej choroby obličiek a kardiovaskulárneho ochorenia. Nový mechanistický prehľad ho interpretuje ako poruchu prepojeného systému, v ktorom zlyhanie mitochondriálnej homeostázy, zápal a orgánová komunikácia vytvárajú zosilňujúce slučky. Tento pohľad je biologicky presvedčivý, ale jeho klinické hranice treba pomenovať rovnako dôrazne ako jeho potenciál.</em></p>

<figure class="article-figure">
  <a href="img/ckm-syndrom-mitochondrie-zapal-organy.png" target="_blank" rel="noopener noreferrer">
    <img src="img/ckm-syndrom-mitochondrie-zapal-organy.webp" alt="Schematické prepojenie srdca, obličiek a mitochondriálnej homeostázy pri CKM syndróme" width="1586" height="992" loading="lazy">
  </a>
  <figcaption>CKM syndróm ako obojsmerne prepojený systém srdca, obličiek a metabolických orgánov, v ktorom mitochondriálny stres podporuje zápal a ďalšie poškodenie. Ilustrácia je schematická, nie diagnostický algoritmus.</figcaption>
</figure>

<p>Oficiálny rámec American Heart Association (AHA) definuje CKM syndróm ako systémovú poruchu vyplývajúcu z interakcií medzi metabolickými rizikovými faktormi, chronickou chorobou obličiek a kardiovaskulárnym systémom. Zahŕňa celé kontinuum od neprítomnosti rizikových faktorov až po klinicky manifestné kardiovaskulárne ochorenie. Mitochondriálny model tento klinický rámec nenahrádza. Vysvetľuje, <strong>ako sa poškodenie v jednotlivých orgánoch môže navzájom zosilňovať</strong>.</p>

<h2>Čo znamená „mitochondriálna systémová porucha“</h2>

<p>Mitochondrie nie sú iba zdrojom adenozíntrifosfátu (ATP). Súčasne regulujú oxidáciu mastných kyselín, redoxnú rovnováhu, metabolickú flexibilitu, bunkovú signalizáciu, apoptózu, vrodenú imunitu a odpoveď na stres. Ich homeostáza závisí od primeranej biogenézy, dynamiky siete, kontroly kvality a odstraňovania poškodených mitochondrií mitofágiou.</p>

<p>Pri CKM fenotypoch sa v experimentálnych modeloch a ľudských tkanivových štúdiách opisujú poruchy oxidačnej fosforylácie, zmeny výberu energetického substrátu, nadbytok reaktívnych foriem kyslíka, narušenú mitochondriálnu dynamiku a nedostatočnú kontrolu kvality. Dôkazy však nie sú vo všetkých orgánoch a štádiách rovnako silné. Preto je presnejšie hovoriť o <strong>spoločnom patobiologickom uzle a pracovnom modeli</strong>, nie o dokázanej jedinej príčine CKM syndrómu.</p>

<h2>Zosilňujúca slučka: energetický stres, oxidačné poškodenie a zápal</h2>

<p>Ak mitochondrie nedokážu pružne prispôsobiť tvorbu energie ponuke substrátov a potrebe bunky, vzniká metabolická neflexibilita. Pri prebytku mastných kyselín a glukózy sa hromadia lipotoxické medziprodukty a rastie redoxné zaťaženie. Reaktívne formy kyslíka môžu poškodzovať lipidy, proteíny aj nukleové kyseliny; zároveň aktivujú zápalové a profibrotické dráhy.</p>

<p>Vzťah je obojsmerný. Cytokíny, neurohumorálna aktivácia a tkanivová hypoxia ďalej zhoršujú mitochondriálnu funkciu. Poškodená mitochondriálna DNA alebo RNA môže pôsobiť ako signál nebezpečenstva a aktivovať vrodenú imunitu. Tak vzniká slučka:</p>

<ol>
  <li>metabolické alebo hemodynamické preťaženie naruší mitochondriálnu homeostázu;</li>
  <li>rastie tvorba reaktívnych foriem kyslíka a uvoľňovanie stresových signálov;</li>
  <li>aktivuje sa zápal, endotelová dysfunkcia a fibrotická odpoveď;</li>
  <li>poškodenie tkaniva znižuje jeho energetickú účinnosť a slučku ďalej posilňuje.</li>
</ol>

<p>Tento model neznamená, že každý pacient má merateľný „mitochondriálny deficit“ alebo že bežné stanovenie zápalového markera dokáže určiť aktivitu CKM syndrómu. Ide o mechanistickú interpretáciu populačných, tkanivových a experimentálnych dôkazov.</p>

<h2>Oblička: energeticky náročný orgán s malou rezervou</h2>

<p>Proximálny tubulus potrebuje veľké množstvo ATP na spätné vstrebávanie filtrovaných látok a dominantne využíva oxidáciu mastných kyselín. Pri hypoxii, diabetickom metabolickom prostredí, zápale alebo toxickom poškodení môže zlyhať mitochondriálna energetika tubulárnych buniek. Následkom sú porucha transportu, bunkové poškodenie, maladaptívna reparácia a podpora intersticiálnej fibrózy.</p>

<p>Glomeruly majú odlišnú energetickú biológiu. V podocytoch a endotelových bunkách môže mitochondriálny stres prispieť k poruche cytoskeletu, bariérovej funkcie a signalizácie, ale jednotlivé renálne bunkové populácie nemožno zhrnúť jedným univerzálnym mechanizmom. Aj preto zatiaľ neexistuje validovaný mitochondriálny biomarker, ktorý by v ambulancii nahradil eGFR, pomer albumínu ku kreatinínu v moči (uACR) alebo etiologickú diagnostiku.</p>

<h2>Srdce a cievy: strata metabolickej flexibility</h2>

<p>Zdravý myokard dokáže meniť pomer oxidácie mastných kyselín, glukózy, ketolátok a ďalších substrátov podľa aktuálnej potreby. Pri obezite, diabete, ischémii a srdcovom zlyhávaní sa táto flexibilita mení. Energetická neefektívnosť, oxidačný stres, porucha vápnikovej homeostázy a zmenená mitochondriálna dynamika môžu podporovať hypertrofiu, fibrózu a kontraktilnú dysfunkciu.</p>

<p>V cievach sa metabolický a oxidačný stres prepája so zníženou biologickou dostupnosťou oxidu dusnatého, endotelovou dysfunkciou, zápalom a artériovou tuhosťou. Tieto procesy zvyšujú záťaž srdca a zároveň zhoršujú perfúziu obličiek, čím sa kardiorenálna slučka uzatvára.</p>

<h2>Tukové tkanivo a pečeň nie sú iba „pozadie“</h2>

<p>Dysfunkčné viscerálne tukové tkanivo uvoľňuje voľné mastné kyseliny a mení profil adipokínov a cytokínov. To podporuje inzulínovú rezistenciu, ektopické ukladanie lipidov a zápal v iných orgánoch. Samotné adipocyty pritom pri obezite vykazujú zmeny mitochondriálnej biogenézy a dynamiky.</p>

<p>Metabolická dysfunkcia spojená so steatotickým ochorením pečene (MASLD) sa pri CKM syndróme vyskytuje často. Pečeň mení tok lipidov a glukózy aj produkciu cirkulujúcich signálov, preto môže systémové metabolické a zápalové zaťaženie zosilňovať. Asociácia však sama osebe nedokazuje, že hepatálna mitochondriálna dysfunkcia je u každého pacienta primárnym spúšťačom.</p>

<h2>RAAS: dôležitý zosilňovač, nie jediný spoločný mechanizmus</h2>

<p>Aktivácia renín-angiotenzín-aldosterónového systému (RAAS) podporuje vazokonstrikciu, retenciu sodíka, oxidačný stres, zápal a fibrózu. Angiotenzín II a mineralokortikoidná signalizácia sa v experimentálnych modeloch prepájajú aj s mitochondriálnou tvorbou reaktívnych foriem kyslíka. RAAS je preto významnou súčasťou CKM patofyziológie, no nie je jedinou osou a jeho aktivitu nemožno odvodiť zo samotnej prítomnosti CKM syndrómu.</p>

<p>Klinický prínos inhibítorov ACE, sartanov a antagonistov mineralokortikoidových receptorov vyplýva z konkrétnych indikácií a výsledkov klinických štúdií. Nemožno ho interpretovať ako dôkaz, že blokáda RAAS „opravuje mitochondrie“ alebo lieči celý CKM syndróm jedným mechanizmom.</p>

<h2>Orgány spolu komunikujú na diaľku</h2>

<p>Medziorgánová komunikácia prebieha prostredníctvom hemodynamiky, autonómneho nervového systému, hormónov, cytokínov, metabolitov, uremických toxínov a extracelulárnych vezikúl. Diskutované signály zahŕňajú napríklad GDF15, FGF21, sukcinát, ceramidy a urát. Ich biologická úloha je predmetom intenzívneho výskumu, ale väčšina z nich <strong>nie je štandardným biomarkerom na diagnostiku alebo určenie štádia CKM syndrómu</strong>.</p>

<p>Rovnaká opatrnosť platí pre priamy prenos mitochondrií medzi bunkami. Experimentálne údaje ukazujú, že bunky môžu mitochondrie alebo ich zložky uvoľňovať a prijímať, no klinický význam tohto javu a jeho využiteľnosť v liečbe CKM syndrómu zatiaľ nie sú stanovené.</p>

<h2>Čo z toho dnes vyplýva pre nefrológa</h2>

<p>Mitochondriálny model mení spôsob uvažovania, nie základný diagnostický panel. V bežnej praxi zostávajú prioritou:</p>

<ul>
  <li>súčasné hodnotenie eGFR a uACR, ich trendu a príčiny chronickej choroby obličiek;</li>
  <li>tlak krvi, glykemický stav, lipidový profil, fajčenie, telesná kompozícia a obvod pása;</li>
  <li>príznaky a riziko srdcového zlyhávania, aterosklerotického ochorenia a fibrilácie predsiení;</li>
  <li>primerané hodnotenie MASLD a ďalších pridružených ochorení;</li>
  <li>orgánovo protektívna liečba podľa overených indikácií, funkcie obličiek, kaliémie, tolerancie a preferencií pacienta.</li>
</ul>

<p>Blokátory RAAS, inhibítory SGLT2, agonisty receptora GLP-1 a nesteroidné antagonisty mineralokortikoidových receptorov môžu priaznivo ovplyvniť viacero zložiek CKM kontinua. Pri niektorých z nich sa diskutujú aj účinky na bunkovú energetiku a mitochondriálnu homeostázu. Klinické rozhodnutie však musí stáť na preukázanom vplyve na renálne a kardiovaskulárne výsledky, nie na samotnej mechanistickej hodnovernosti.</p>

<h2>Čo zatiaľ do rutiny nepatrí</h2>

<ul>
  <li><strong>„Mitochondriálny panel“:</strong> validovaný panel na diagnostiku, určenie štádia alebo výber liečby CKM syndrómu zatiaľ nie je k dispozícii.</li>
  <li><strong>Hs-CRP, IL-6 alebo adipokíny ako samostatné rozhodovacie testy:</strong> môžu niesť prognostickú informáciu, ale nenahrádzajú štandardné klinické parametre a pre väčšinu pacientov nemenia liečbu.</li>
  <li><strong>Urát ako univerzálny cieľ CKM liečby:</strong> hyperurikémia je markerom rizika a pri dne má jasný klinický význam; samotné zníženie urátu bez inej indikácie nemožno prezentovať ako dokázanú liečbu CKM syndrómu alebo prevenciu progresie CKD.</li>
  <li><strong>Mitochondriálne transplantácie a priame mitochondriálne liečivá:</strong> ide o experimentálne alebo skúmané prístupy bez preukázanej rutinnej účinnosti pri CKM syndróme.</li>
</ul>

<h2>Najdôležitejšia hranica interpretácie</h2>

<p>Prehľad v <em>Nature Reviews Nephrology</em> je syntézou mechanistických dôkazov, nie randomizovanou klinickou štúdiou ani odporúčaním na nový skríning. Formulácia „CKM syndróm ako mitochondriálna systémová porucha“ je produktívna hypotéza, ktorá prepája poškodenie srdca, obličiek, tukového tkaniva a pečene. Neznamená však, že mitochondriálna dysfunkcia bola dokázaná ako jediný prvotný mechanizmus, že ju vieme v rutine spoľahlivo zmerať alebo že jej priame ovplyvnenie už zlepšuje tvrdé klinické výsledky.</p>

<p>Autori preto medzi výskumné priority zaraďujú validáciu biomarkerov, lepšie preukázanie kauzality u ľudí a klinické skúšania intervencií zameraných priamo alebo nepriamo na mitochondriálnu homeostázu. To je presne hranica medzi presvedčivou biológiou a medicínou pripravenou na každodenné použitie.</p>

<h2>Záver</h2>

<p>CKM syndróm možno chápať ako sieť zosilňujúcich sa porúch, v ktorej energetický stres, oxidačné poškodenie, zápal, neurohumorálna aktivácia a orgánová komunikácia prepájajú srdce, obličky, tukové tkanivo a pečeň. Mitochondrie sú v tejto sieti významným uzlom, nie však jediným vysvetlením ani zatiaľ samostatným klinickým cieľom.</p>

<p>Pre nefrologickú prax z toho vyplýva najmä potreba integrovaného hodnotenia rizika a včasnej orgánovo protektívnej liečby. Experimentálne biomarkery a mitochondriálne intervencie majú zostať jasne označené ako výskumné, kým ich prínos nepotvrdia validačné a intervenčné štúdie.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4, skríning a liečba podľa usmernenia AHA/ACC/ADA/ASN 2026</a>.</li>
  <li><a href="article.php?slug=ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia">CKM syndróm ako jeden rámec pre nefrologickú ambulanciu</a>.</li>
  <li><a href="article.php?slug=zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky">Zápal ako terapeutický cieľ pri CKD</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Shen Li, E. Dale Abel, Zoltan Arany, Joseph A. Baur, Liming Pei, Katalin Susztak.</strong> <em>Cardiovascular–kidney–metabolic syndrome as a mitochondrial systems disorder.</em> Nature Reviews Nephrology. Publikované online 24. septembra 2026. doi: 10.1038/s41581-026-01127-4. <a href="https://doi.org/10.1038/s41581-026-01127-4" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Chiadi E. Ndumele, Janani Rangaswami, et al.</strong> <em>Cardiovascular-Kidney-Metabolic Health: A Presidential Advisory From the American Heart Association.</em> Circulation. 2023;148:1606–1635. doi: 10.1161/CIR.0000000000001184. <a href="https://doi.org/10.1161/CIR.0000000000001184" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Chiadi E. Ndumele, Ian J. Neeland, Katherine R. Tuttle, et al.</strong> <em>A Synopsis of the Evidence for the Science and Clinical Management of Cardiovascular-Kidney-Metabolic (CKM) Syndrome: A Scientific Statement From the American Heart Association.</em> Circulation. 2023;148:1636–1664. doi: 10.1161/CIR.0000000000001186. <a href="https://pubmed.ncbi.nlm.nih.gov/37807920/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1161/CIR.0000000000001186" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Pratima Bhargava, Rick G. Schnellmann.</strong> <em>Mitochondrial energetics in the kidney.</em> Nature Reviews Nephrology. 2017;13:629–646. doi: 10.1038/nrneph.2017.107. <a href="https://pubmed.ncbi.nlm.nih.gov/28804120/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1038/nrneph.2017.107" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Gary D. Lopaschuk, Qutuba G. Karwi, Rong Tian, Adam R. Wende, E. Dale Abel.</strong> <em>Cardiac Energy Metabolism in Heart Failure.</em> Circulation Research. 2021;128:1487–1513. doi: 10.1161/CIRCRESAHA.121.318241. <a href="https://pubmed.ncbi.nlm.nih.gov/33983836/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1161/CIRCRESAHA.121.318241" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Text je odborným spracovaním prehľadu Li a kol. z roku 2026 a oficiálneho klinického rámca AHA. Mechanistické tvrdenia vychádzajú prevažne z kombinácie experimentálnych, translačných a observačných údajov. Nie sú prezentované ako dôkaz, že priame mitochondriálne intervencie už zlepšujú klinické výsledky pri CKM syndróme. Bibliografické údaje a všetkých šesť autorov hlavného zdroja boli overené v metaúdajoch vydavateľa a registri Crossref; práca v čase prípravy ešte nemala záznam v PubMed.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckm-syndrom-mitochondrie-zapal-organy_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
      <link rel="stylesheet" href="index.css?v=20260509-1&amp;cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>
          <?php if (!empty($errors)): ?>
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
