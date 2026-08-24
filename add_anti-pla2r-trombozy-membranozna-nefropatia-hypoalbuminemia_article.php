<?php
/**
 * Odborne a jazykovo revidovaný článok o hladine anti-PLA2R a riziku trombózy
 * pri membranóznej nefropatii s ťažkou hypoalbuminémiou. Spracovaná práca
 * J Nephrol 2026, doi 10.1093/joneph/aajag121; autori v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Anti-PLA2R a riziko trombózy pri membranóznej nefropatii: protilátka ako možný doplnok k albumínu',
    'slug'         => 'anti-pla2r-trombozy-membranozna-nefropatia-hypoalbuminemia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pri ťažkej hypoalbuminémii sa vyššie hladiny anti-PLA2R spájali s vyšším rizikom trombózy aj po úprave na albumín a vek. Odhad však stojí na najviac desiatich príhodách a nemožno ho extrapolovať na bežné titre.',
    'content'      => <<<'HTML'
<p>Membranózna nefropatia patrí k tým glomerulopatiám, kde trombóza nie je zriedkavou komplikáciou, ale očakávaným rizikom. Rozhodovanie o profylaxii pritom stojí prakticky na jedinom ukazovateli – na koncentrácii sérového albumínu – a na odhade rizika krvácania. Otázka, či existuje aj marker <em>aktivity ochorenia</em>, ktorý by riziko spresnil, je preto legitímna.</p>

<p>Retrospektívna kohortová štúdia publikovaná v auguste 2026 na ňu odpovedá opatrne kladne: pri ťažkej hypoalbuminémii sa vyššie hladiny protilátok proti receptoru pre fosfolipázu A2 (anti-PLA2R) spájali s vyšším rizikom trombotických komplikácií. Váha tohto zistenia sa však dá pochopiť až vtedy, keď sa pozrieme, na koľkých príhodách stojí.</p>

<h2>Východisko: albumín a rozhodovanie o profylaxii</h2>

<p>Klasickým podkladom je združená inceptná kohorta 898 pacientov s bioptický potvrdenou membranóznou nefropatiou, v ktorej malo aspoň jednu žilovú tromboembolickú príhodu <strong>65 osôb (7,2 %)</strong>, väčšinou do dvoch rokov od prvého klinického vyšetrenia. Riziko bolo nepriamo úmerné koncentrácii albumínu.</p>

<p>Na tento nález nadviazal rozhodovací Markovov model, ktorý postavil zabránené tromboembolické príhody proti závažným krvácaniam. Pomer prínosu a rizika stúpal s hĺbkou hypoalbuminémie: od približne <strong>4,5 : 1</strong> pri albumíne pod 3 g/dl po <strong>13,1 : 1</strong> pri albumíne pod 2 g/dl u pacientov s nízkym rizikom krvácania. Odporúčania KDIGO 2021 pre glomerulárne ochorenia z tejto logiky vychádzajú a profylaktickú antikoaguláciu viažu na hĺbku hypoalbuminémie spolu s individuálnym rizikom krvácania.</p>

<h2>Čo priniesla nová kohorta</h2>

<p>Zaradených bolo <strong>67 osôb</strong> s membranóznou nefropatiou a sérovým albumínom pod 2,5 g/dl (25 g/l). Ide teda presne o pásmo, kde má profylaxia podľa modelu najvyšší očakávaný prínos.</p>

<div class="table-responsive" role="region" aria-label="Charakteristika kohorty a výskyt trombotických príhod podľa tromboprofylaxie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Hodnota</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Medián sérového kreatinínu</th>
      <td>1,2 mg/dl (medzikvartilové rozpätie 0,9–1,6)</td>
    </tr>
    <tr>
      <th scope="row">Medián pomeru bielkovín ku kreatinínu v moči</th>
      <td>11,9 g/g (8,5–16,5)</td>
    </tr>
    <tr>
      <th scope="row">Medián najnižšieho sérového albumínu</th>
      <td>1,9 g/dl (1,6–2,2)</td>
    </tr>
    <tr>
      <th scope="row">Bez tromboprofylaxie</th>
      <td>24 osôb (36 %) – incidencia 0,11 na osoborok</td>
    </tr>
    <tr>
      <th scope="row">Len antiagregačná liečba</th>
      <td>20 osôb (30 %) – incidencia 0,10 na osoborok</td>
    </tr>
    <tr>
      <th scope="row">Antikoagulačná profylaxia</th>
      <td>23 osôb (34 %) – incidencia 0,02 na osoborok</td>
    </tr>
    <tr>
      <th scope="row">Trombotické príhody spolu</th>
      <td>11 osôb (16 %)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Hlavný výsledok: v podskupine s anti-PLA2R pozitívnou membranóznou nefropatiou, ktorá nedostávala antikoagulačnú profylaxiu, bola vyššia hladina protilátky spojená s vyšším rizikom trombotických komplikácií – <strong>upravený pomer rizík 1,51 na každých 10 RU/ml (95 % IS 1,10–2,09; p = 0,012)</strong> po úprave na najnižší albumín a vek.</p>

<h2>Ako tento pomer rizík čítať</h2>

<ol>
  <li><strong>Nie je to hodnota na extrapoláciu.</strong> Vyjadrenie „na 10 RU/ml“ predpokladá exponenciálny vzťah v celom rozsahu titrov. Bežné hodnoty v praxi sa pohybujú v stovkách RU/ml; naivné umocnenie by pri 100 RU/ml dalo takmer šesťdesiatnásobné riziko, čo je zjavne nezmyselné. Či bola linearita testovaná alebo či sa modelovala transformovaná hodnota, z dostupného abstraktu nevyplýva.</li>
  <li><strong>Počet príhod je veľmi malý.</strong> V celej kohorte ich bolo jedenásť. Keďže antikoagulačná skupina má nenulovú incidenciu, aspoň jedna príhoda padla mimo modelu; po ďalšom zúžení na anti-PLA2R pozitívnych zostáva v modeli najviac desať udalostí – a pravdepodobne menej. Coxov model s dvoma kovariátmi je pri takom počte na hranici interpretovateľnosti a odhad je nestabilný.</li>
  <li><strong>Podskupina je definovaná dodatočne dvoma vlastnosťami naraz</strong> (pozitivita protilátky a neužívanie antikoagulácie). Abstrakt neuvádza ani neupravený pomer rizík, ani výsledok v celej kohorte, ani žiadny údaj pre anti-PLA2R negatívnu chorobu. Bez nich nemožno vylúčiť, že sa referuje najsilnejší z viacerých skúmaných rezov.</li>
  <li><strong>Nezohľadnená imunosupresia.</strong> Rituximab, cyklofosfamid ani kalcineurínové inhibítory sa v abstrakte nespomínajú. Pritom imunosupresia znižuje zároveň hladinu anti-PLA2R aj proteinúriu, a je teda silným spoločným determinantom expozície aj následku. Neupravenie na ňu môže asociáciu vytvoriť aj bez akéhokoľvek priameho vzťahu.</li>
</ol>

<h2>Prečo rozdiel 0,02 oproti 0,11 nie je dôkazom účinnosti antikoagulácie</h2>

<p>Päťnásobne nižšia incidencia v antikoagulovanej skupine vyzerá presvedčivo, no o profylaxii nerozhodoval žreb, ale ošetrujúci lekár. Antikoagulovaní mohli byť buď najrizikovejší pacienti (čo by prínos podhodnotilo), alebo naopak tí s najnižším rizikom krvácania (čo by ho nadhodnotilo). Práca navyše neuvádza počty príhod v jednotlivých skupinách, intervaly spoľahlivosti ani žiadne štatistické porovnanie medzi nimi. Formulácia typu „antikoagulácia znížila riziko päťnásobne“ by preto prekročila to, čo zdroj tvrdí.</p>

<p>Rovnako chýba druhá strana rovnice – <strong>krvácavé komplikácie profylaxie nie sú kvantifikované</strong>. Bez nich sa z tejto práce nedá odvodiť žiadne odporúčanie o liečbe.</p>

<h2>Čo štúdia neuvádza</h2>

<ul>
  <li>koľko pacientov bolo anti-PLA2R pozitívnych, teda akú veľkú podskupinu model vlastne opisuje,</li>
  <li>aké boli typy príhod – žilové oproti tepnovým, renálna vénová trombóza, pľúcna embólia,</li>
  <li>dĺžku sledovania (z uvádzaných incidenčných hustôt vyplýva najmenej sto osoborokov, teda priemerne aspoň rok a pol na pacienta),</li>
  <li>definíciu príhody, spôsob jej potvrdenia a zaobchádzanie s konkurujúcimi rizikami,</li>
  <li>metódu a hranicu pozitivity merania anti-PLA2R,</li>
  <li>vek, pohlavie ani podiel sekundárnej membranóznej nefropatie.</li>
</ul>

<p>Plný text je za platobnou stenou a nemá otvorenú verziu, takže autorské limity nemožno citovať. Výhrady uvedené v tomto texte sú preto odvodené z dizajnu opísaného v abstrakte, nie prevzaté od autorov. Označenie „multicentrická“ je navyše mierne nadnesené: podľa afiliácií ide o dve bostonské nemocnice jedného zdravotníckeho systému, prevažne o terciárne centrum pre vaskulitídy a glomerulonefritídy.</p>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o anti-PLA2R a riziku trombózy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Vyššie hladiny anti-PLA2R sa spájajú s vyšším rizikom trombózy</th>
      <td>Potvrdené ako asociácia</td>
      <td>Platí pre anti-PLA2R pozitívnu chorobu bez antikoagulačnej profylaxie, po úprave na najnižší albumín a vek.</td>
    </tr>
    <tr>
      <th scope="row">Riziko nie je len funkciou hypoalbuminémie</th>
      <td>Pravdepodobné</td>
      <td>Asociácia pretrvala po úprave na albumín, ale model mal najviac desať príhod a dve kovariáty.</td>
    </tr>
    <tr>
      <th scope="row">Antikoagulačná profylaxia znižuje výskyt trombózy</th>
      <td>Nedoložené touto prácou</td>
      <td>Nerandomizované porovnanie bez intervalov spoľahlivosti a bez štatistického testu; zmätenie indikáciou pôsobí v oboch smeroch.</td>
    </tr>
    <tr>
      <th scope="row">Hladinu protilátky možno použiť ako spúšťač antikoagulácie</th>
      <td>Nesprávne</td>
      <td>Neexistuje hraničná hodnota, nie je známy počet pozitívnych pacientov a krvácavé riziko nebolo kvantifikované.</td>
    </tr>
    <tr>
      <th scope="row">Pomer rizík 1,51 možno prepočítať na bežné titre</th>
      <td>Nesprávne</td>
      <td>Extrapolácia na stovky RU/ml dáva absurdné hodnoty; linearita vzťahu nie je doložená.</td>
    </tr>
    <tr>
      <th scope="row">Ide o multicentrickú štúdiu</th>
      <td>Nepresné</td>
      <td>Podľa afiliácií dve nemocnice jedného bostonského systému, prevažne terciárne referenčné pracovisko.</td>
    </tr>
    <tr>
      <th scope="row">Aktivita ochorenia môže súvisieť s trombogenézou</th>
      <td>Mechanisticky vierohodné</td>
      <td>Nefrotický syndróm vedie k stratám antitrombínu, k zvýšeniu fibrinogénu a k zmenám doštičkovej funkcie. Táto štúdia to však nemeria.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo z toho vyplýva pre prax</h2>

<ol>
  <li><strong>Rozhodovanie sa nemení.</strong> Naďalej stojí na hĺbke hypoalbuminémie, na individuálnom riziku krvácania a na klinickom kontexte podľa KDIGO 2021 – nie na titri protilátky.</li>
  <li><strong>Anti-PLA2R meriame aj tak.</strong> Pri diagnostike a sledovaní odpovede na liečbu je vyšetrenie súčasťou štandardnej starostlivosti, takže prípadná riziková stratifikácia by nepriniesla dodatočné náklady. Chýba jej však hranica aj prospektívne overenie.</li>
  <li><strong>Vysoký titer pri ťažkej hypoalbuminémii ber ako dôvod na pozornosť</strong>, nie ako indikáciu. Prakticky to znamená nižší prah pre zobrazovacie vyšetrenie pri podozrivých príznakoch a dôsledné poučenie pacienta.</li>
  <li><strong>Nezabúdať na obdobie najvyššieho rizika.</strong> Väčšina príhod v klasickej kohorte vznikla do dvoch rokov od prvého vyšetrenia – teda vtedy, keď je choroba najaktívnejšia a hypoalbuminémia najhlbšia.</li>
  <li><strong>Sledovať ďalší vývoj.</strong> Práca je zatiaľ vo forme predbežného článku bez ročníka a stránkovania, bez citačnej odozvy a bez nezávislej replikácie.</li>
</ol>

<h2>Záver</h2>

<p>Hypotéza, že imunologická aktivita membranóznej nefropatie prispieva k trombotickému riziku nad rámec samotnej hypoalbuminémie, je biologicky vierohodná a táto kohorta ju podporuje. Podpora je však krehká: jedenásť príhod celkovo, model postavený na podskupine, nezohľadnená imunosupresia a nekvantifikované krvácanie.</p>

<p>Správne prečítanie práce preto znie: <strong>ide o signál na prospektívne overenie, nie o nový rozhodovací parameter.</strong> Do času, kým sa objaví hranica overená v nezávislej kohorte a s vyčíslenou bezpečnosťou, zostáva albumín spolu s rizikom krvácania tým, podľa čoho o tromboprofylaxii rozhodujeme.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=cheatsheet-membranozna-nefropatia">Membranózna nefropatia — ťahák</a></li>
  <li><a href="article.php?slug=antitromboticka-liecba-faktor-xi-bezpecnejsia-prevencia">Nové prístupy v antitrombotickej liečbe: od „dobrých“ a „zlých“ zrazenín k bezpečnejšej prevencii</a></li>
  <li><a href="article.php?slug=perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza">Perzistujúca mikroskopická hematúria pri podocytopatiách: prognostický signál, nie terapeutický cieľ</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Al Jurdi A, El Mouhayyar C, Yatim K, Efe O, Muhsin SA, Riella LV, Zonozi R, Laliberte K, Niles JL, Jeyabalan A. Anti-PLA2R antibody levels are associated with thromboembolism risk in individuals with membranous nephropathy and hypoalbuminemia. <em>Journal of Nephrology</em>. Publikované online 14. augusta 2026 (predbežný článok, bez ročníka a stránkovania), e-lokátor aajag121. doi: 10.1093/joneph/aajag121. <a href="https://pubmed.ncbi.nlm.nih.gov/42598914/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Východisková kohorta:</strong> Lionaki S, Derebail VK, Hogan SL, Barbour S, Lee T, Hladunewich M, et al. Venous thromboembolism in patients with membranous nephropathy. <em>Clinical Journal of the American Society of Nephrology</em>. 2012;7(1):43–51. doi: 10.2215/CJN.04250511. <a href="https://pubmed.ncbi.nlm.nih.gov/22076873/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Rozhodovacia analýza profylaxie:</strong> Lee T, Biddle AK, Lionaki S, Derebail VK, Barbour SJ, Tannous S, et al. Personalized prophylactic anticoagulation decision analysis in patients with membranous nephropathy. <em>Kidney International</em>. 2014;85(6):1412–1420. doi: 10.1038/ki.2013.476. <a href="https://pubmed.ncbi.nlm.nih.gov/24336031/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Odporúčanie:</strong> Kidney Disease: Improving Global Outcomes Glomerular Diseases Work Group. KDIGO 2021 Clinical Practice Guideline for the Management of Glomerular Diseases. <em>Kidney International</em>. 2021;100(4S):S1–S276. doi: 10.1016/j.kint.2021.05.021. <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-Glomerular-Diseases-Guideline-2021-English.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam a všetky číselné výsledky spracovanej práce boli overené 23. augusta 2026 cez PubMed a Crossref z jej štruktúrovaného abstraktu. Plný text nemá otvorenú verziu, preto výhrady k dizajnu uvedené v tomto texte nie sú prevzaté od autorov, ale odvodené z dostupného opisu metodiky. Deklarovaný konflikt záujmov jedného zo spoluautorov (konzultačné a skúšateľské honoráre od spoločností ChemoCentryx a Alexion) je uvedený v bibliografickom zázname.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_anti_pla2r_trombozy_mn',
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
