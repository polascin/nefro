<?php
/**
 * Odborný článok: Oblička na čipe a obličkové organoidy — úloha mechanických síl.
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
    'title'        => 'Oblička na čipe a obličkové organoidy: mechanické sily otvárajú nové možnosti výskumu ochorení obličiek',
    'slug'         => 'oblicka-na-cipe-organoidy-mechanicke-sily',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Mikrofluidné modely a organoidy z indukovaných pluripotentných kmeňových buniek umožňujú oddeliť mechanické účinky od biochemických. Celý orgán zatiaľ nenahrádzajú a regulačné využitie si žiada validáciu.',
    'content'      => <<<'HTML'
<p>Modely obličky na čipe a obličkové organoidy odvodené z indukovaných pluripotentných kmeňových buniek (iPSC) sú rýchlo sa rozvíjajúce experimentálne platformy. Umožňujú skúmať ľudské obličkové bunky v prostredí, ktoré je fyziologicky relevantnejšie než bežná statická kultúra — s kontrolovaným prietokom, tlakovými pomermi, mechanickým napätím, zložením extracelulárnej matrix a vzájomným pôsobením viacerých bunkových populácií.</p>

<p>Prehľadová práca publikovaná v <em>Journal of the American Society of Nephrology</em> zhŕňa, ako tieto systémy prispievajú k modelovaniu nefrotoxicity, vývoja obličiek a patofyziológie. Jej ťažiskovým argumentom je práve mechanika: zvieracie modely síce umožňujú skúmať ochorenie na úrovni celého organizmu, <strong>neumožňujú však oddeliť biomechanické účinky od biochemických</strong> — a práve to je pri ochoreniach obličiek podstatné.</p>

<p>Tieto technológie zatiaľ nereprodukujú funkciu celého ľudského orgánu. Ich využitie v regulačnom rozhodovaní si vyžaduje štandardizáciu, nezávislú validáciu a porovnanie s klinickými údajmi.</p>

<h2>Prečo doterajšie modely nestačia</h2>

<p>Poznatky o fyziológii a patofyziológii obličiek tradične pochádzajú zo zvieracích modelov, z dvojrozmerných bunkových kultúr a z analýzy ľudských vzoriek. Každý prístup má zásadné obmedzenia.</p>

<p><strong>Zvieracie modely</strong> umožňujú skúmať ochorenie v celom organizme, ale medzidruhové rozdiely v expresii transportérov, metabolizme liekov, imunite, hemodynamike a architektúre nefrónu znižujú prenositeľnosť na človeka. Zvierací model preto nemusí spoľahlivo predpovedať ľudskú nefrotoxicitu ani terapeutickú odpoveď.</p>

<p><strong>Statické bunkové kultúry</strong> sú dostupnejšie a lepšie reprodukovateľné, bunky v nich však často strácajú polaritu, diferencovaný fenotyp a fyziologickú expresiu transportných proteínov. Chýba prietok, mechanické namáhanie, priestorová organizácia tkaniva a komunikácia medzi epitelom, endotelom, interstíciom a imunitnými bunkami.</p>

<p>Oblička pritom nie je iba súbor buniek reagujúcich na rozpustené molekuly. Je to <strong>mechanicky aktívny orgán</strong> vystavený prietoku, hydrostatickému tlaku, pulzáciám, šmykovému napätiu, deformácii membrán a zmenám tuhosti extracelulárnej matrix. Tieto podnety ovplyvňujú bunkovú diferenciáciu, cytoskelet, funkciu primárnych cílií, transport látok, zápalovú signalizáciu aj fibrogenézu.</p>

<h2>Čo je oblička na čipe</h2>

<p>Oblička na čipe — presnejšie obličkový mikrofyziologický systém — je mikrofluidné zariadenie s jednou alebo viacerými populáciami obličkových buniek. Bunky sa pestujú v priestorovo definovaných kanáloch alebo komorách, cez ktoré možno regulovane viesť médium. Priepustná membrána alebo trojrozmerná matrix môže oddeľovať epitelovú a endotelovú časť.</p>

<p>Konštrukcia závisí od toho, ktorú časť nefrónu má systém napodobniť. Existujú modely glomerulárnej filtračnej bariéry, proximálneho tubulu, distálneho nefrónu aj zberného systému; niektoré platformy spájajú viacero kompartmentov alebo ich integrujú s modelmi pečene či srdca.</p>

<p><strong>Pojem „oblička na čipe“ môže navodzovať predstavu miniatúrnej funkčnej obličky. Taká interpretácia by bola nepresná.</strong> Väčšina systémov reprodukuje iba vybrané bunkové, bariérové, transportné alebo mechanické vlastnosti určitej časti obličky.</p>

<h2>Mechanické sily ako biologický signál</h2>

<p>Hlavným prínosom mikrofluidných modelov je práve možnosť oddeliť mechanické účinky od biochemických.</p>

<h3>Šmykové napätie vyvolané prietokom</h3>

<p>Tubulárny epitel je neustále vystavený prietoku ultrafiltrátu. Šmykové napätie ovplyvňuje polaritu buniek, usporiadanie cytoskeletu, diferenciáciu mikroklkov, funkciu primárnych cílií a expresiu transportérov. Statická kultúra tento podnet neposkytuje.</p>

<p>Pri vhodne nastavenom prietoku možno dosiahnuť fenotyp bližší ľudskému tubulárnemu epitelu. Neznamená to však, že vyšší prietok je automaticky fyziologickejší — výsledok závisí od rozmerov kanála, viskozity média, geometrie zariadenia a od skutočného šmykového napätia pôsobiaceho na bunkový povrch.</p>

<h3>Tlak a mechanická deformácia</h3>

<p>Glomerulárne bunky sú vystavené transkapilárnemu tlaku a cyklickým mechanickým silám. Nadmerné namáhanie môže ovplyvniť cytoskelet podocytov, štrbinovú membránu a priepustnosť filtračnej bariéry. Mikrofluidné zariadenia umožňujú tieto parametre meniť kontrolovanejšie než zvierací model, v ktorom sa mechanické a humorálne účinky spravidla nedajú spoľahlivo oddeliť.</p>

<p>Meranie permeability v glomerulárnom čipe však <strong>nemožno stotožňovať s meraním glomerulovej filtrácie celého orgánu</strong>. Ide o model čiastkovej bariérovej funkcie, nie o ekvivalent klinicky stanovenej filtrácie.</p>

<h3>Tuhosť extracelulárnej matrix</h3>

<p>Zmeny mechanických vlastností interstícia sprevádzajú zápal, starnutie a fibrózu. Tuhšia matrix môže sama podporovať profibrotickú signalizáciu a meniť diferenciáciu buniek. Bioinžinierske systémy umožňujú zisťovať, či je pozorovaná odpoveď dôsledkom biochemických mediátorov, mechanického prostredia alebo ich kombinácie.</p>

<h2>Obličkové organoidy</h2>

<p>Obličkové organoidy sú trojrozmerné štruktúry vytvorené diferenciáciou pluripotentných kmeňových buniek. Indukované pluripotentné kmeňové bunky možno pripraviť z buniek konkrétneho človeka, čo umožňuje modelovať geneticky podmienené ochorenia v individuálnom genetickom kontexte.</p>

<p>Organoidy môžu obsahovať bunky pripomínajúce podocyty, proximálny a distálny tubulárny epitel a intersticiálne bunky; niektoré protokoly modelujú aj štruktúry súvisiace s ureterovým púčikom a vetvením zberného systému. Podľa autorov organoidy vykazujú selektívny transport, toxikologické odpovede a štrukturálnu stabilitu počas mesiacov kultivácie.</p>

<p>Nejde však o anatomicky kompletnú miniatúrnu obličku. Organoidy spravidla pripomínajú skôr vývojovo nezrelé fetálne tkanivo než dospelý orgán. Môžu obsahovať nežiaduce bunkové populácie a často im chýba dostatočne vyvinuté cievne riečisko, fyziologický odtok tekutiny a dlhodobé prepojenie segmentov nefrónu.</p>

<p><strong>Ani zachovanie štruktúry počas mesiacov samo osebe nepreukazuje funkčnú zrelosť.</strong> Morfologická stabilita, expresia markerov a schopnosť selektívneho transportu sú rozdielne charakteristiky a treba ich hodnotiť samostatne.</p>

<h2>Spojenie organoidu s mikrofluidným systémom</h2>

<p>Organoid na čipe spája priestorovú komplexnosť organoidu s kontrolovaným prietokom a mechanickým prostredím mikrofluidného zariadenia. Perfúzia môže zlepšiť prísun kyslíka a živín, znížiť centrálnu hypoxiu a podporiť funkčné dozrievanie niektorých buniek.</p>

<p>Autori uvádzajú ako ďalšie smery biotlač, vytváranie perfundovateľných cievnych sietí, spoločnú kultiváciu s endotelovými alebo imunitnými bunkami a prepájanie viacerých orgánových modelov. Viacorgánové systémy môžu byť užitočné napríklad pri skúmaní metabolizmu liečiva v pečeni a následnej expozície obličiek jeho metabolitom.</p>

<p>Takéto platformy však výrazne zvyšujú technickú zložitosť. Čím je systém komplexnejší, tým ťažšie sa štandardizuje, reprodukuje a interpretuje. Biologická podobnosť s človekom preto musí byť vyvažovaná dostatočnou analytickou kontrolou.</p>

<h2>Hodnotenie nefrotoxicity</h2>

<p>Najperspektívnejšou oblasťou použitia je predklinické hodnotenie nefrotoxických účinkov liečiv a chemických látok. Vhodne navrhnutý model môže sledovať:</p>

<ul>
  <li>integritu epitelovej alebo glomerulárnej bariéry,</li>
  <li>transport a reabsorpciu vybraných látok,</li>
  <li>bunkovú životaschopnosť a mitochondriálnu funkciu,</li>
  <li>expresiu transportérov a biomarkerov poškodenia,</li>
  <li>zápalovú a profibrotickú odpoveď,</li>
  <li>časový priebeh poškodenia a zotavenia po ukončení expozície.</li>
</ul>

<p>Výhodou môže byť testovanie pri koncentráciách zodpovedajúcich voľnej systémovej expozícii alebo predpokladanej tubulárnej koncentrácii liečiva. Aj tu je však namieste opatrnosť: skutočnú expozíciu ovplyvňuje väzba na plazmatické bielkoviny, metabolizmus, sekrécia, reabsorpcia a intrarenálne koncentrovanie. Koncentrácia pridaná do média preto nemusí zodpovedať expozícii buniek v ľudskej obličke.</p>

<p>Výsledky môže skresliť aj <strong>absorpcia lipofilných látok do polymérov</strong> používaných pri výrobe čipov. Bez merania skutočnej koncentrácie v perfuzáte a v jednotlivých častiach zariadenia môže byť vzťah dávky a účinku interpretovaný nesprávne.</p>

<h2>Personalizované modelovanie ochorení</h2>

<p>Spojenie pacientskych iPSC s organoidmi a mikrofluidnými zariadeniami umožňuje vytvárať modely nesúce konkrétny genetický variant. Úprava genómu môže vytvoriť izogénnu kontrolu, pri ktorej sa chorobný a korigovaný model líšia iba skúmaným variantom.</p>

<p>Prístup môže pomôcť objasniť patogenitu zriedkavých variantov, mechanizmy dedičných nefropatií a potenciálnu odpoveď na liečbu. Zatiaľ však nemožno predpokladať, že odpoveď organoidu spoľahlivo predpovie klinickú odpoveď konkrétneho pacienta — na taký záver by boli potrebné prospektívne validačné štúdie porovnávajúce výsledky modelu so skutočným klinickým priebehom.</p>

<h2>Strojové učenie a klinické databázy</h2>

<p>Kombinácia obrazových údajov, transkriptomiky, proteomiky a funkčných meraní vytvára veľké množstvo dát vhodných na analýzu metódami strojového učenia. Algoritmy môžu identifikovať vzorce bunkovej odpovede, ktoré pri bežnom hodnotení nie sú zrejmé. Autori tento smer výslovne uvádzajú ako jednu z ciest k vyššej translačnej relevantnosti, spolu s využitím verejne dostupných klinických databáz a validáciou priamo na čipe.</p>

<p><strong>Strojové učenie však nevyrieši nedostatočnú kvalitu vstupného modelu.</strong> Ak čip alebo organoid nereprodukuje rozhodujúcu časť ľudskej patofyziológie, sofistikovanejšia analýza túto biologickú neplatnosť neodstráni.</p>

<h2>Regulačný kontext</h2>

<p>Zákon FDA Modernization Act 2.0 odstránil výlučné legislatívne uprednostnenie tradičných zvieracích testov a otvoril priestor pre alternatívne metódy. V apríli 2025 americký Úrad pre kontrolu potravín a liečiv (FDA) predstavil plán postupného obmedzovania požiadaviek na testovanie na zvieratách, najmä pri monoklonálnych protilátkach a vybraných ďalších liekoch. Medzi podporované prístupy zaradil ľudské organoidy, orgány na čipe, výpočtové modely a údaje z reálneho klinického prostredia.</p>

<p>Vývoj <strong>neznamená</strong> všeobecné zrušenie predklinického testovania na zvieratách ani automatické regulačné prijatie každého organoidového alebo čipového modelu. Každý prístup musí preukázať analytickú spoľahlivosť, biologickú relevantnosť a vhodnosť na konkrétny účel použitia. Model validovaný na predpovedanie proximálnej tubulárnej toxicity nemusí byť vhodný na hodnotenie glomerulárneho poškodenia, imunotoxicity ani systémových hemodynamických účinkov.</p>

<h2>Prekážky klinického a regulačného využitia</h2>

<div class="table-responsive" role="region" aria-label="Hlavné obmedzenia súčasných obličkových modelov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Obmedzenie</th>
      <th scope="col">Podstata problému</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nezrelosť buniek</th>
      <td>Najmä organoidy vykazujú vývojovo nezrelý fenotyp bližší fetálnemu tkanivu</td>
    </tr>
    <tr>
      <th scope="row">Nedostatočná vaskularizácia</th>
      <td>Bez funkčného endotelu a perfúzie nemožno úplne modelovať glomerulárne ani intersticiálne procesy</td>
    </tr>
    <tr>
      <th scope="row">Variabilita medzi dávkami</th>
      <td>Rozdiely v diferenciácii kmeňových buniek menia bunkové zloženie aj funkciu</td>
    </tr>
    <tr>
      <th scope="row">Chýbajúca imunita a systémové vplyvy</th>
      <td>Väčšina modelov nereprodukuje vrodenú a adaptívnu imunitu, neurohumorálnu reguláciu ani hemodynamiku organizmu</td>
    </tr>
    <tr>
      <th scope="row">Materiálové artefakty</th>
      <td>Povrchové vlastnosti zariadenia, absorpcia liečiv do polymérov a tvorba bubliniek ovplyvňujú výsledok</td>
    </tr>
    <tr>
      <th scope="row">Chýbajúce štandardy</th>
      <td>Potrebné sú harmonizované protokoly, referenčné látky, kontrolné materiály a vopred určené kritériá prijateľnosti</td>
    </tr>
    <tr>
      <th scope="row">Priepustnosť a náklady</th>
      <td>Komplexné systémy zatiaľ nie sú vhodné na rutinné testovanie veľkého počtu zlúčenín</td>
    </tr>
    <tr>
      <th scope="row">Neúplná klinická validácia</th>
      <td>Predikčná hodnota musí byť overená na látkach s doloženou ľudskou nefrotoxicitou aj na látkach pre človeka bezpečných</td>
    </tr>
  </tbody>
</table>
</div>

<p>Autori sami označujú zrelosť, škálovateľnosť a vaskularizáciu za tri hlavné obmedzenia, ktoré majú bioinžinierske prístupy riešiť.</p>

<h2>Čo z prehľadovej práce nemožno uzavrieť</h2>

<p>Ide o <strong>odborný prehľad</strong>, nie o randomizovanú štúdiu, diagnostickú validačnú štúdiu ani systematickú metaanalýzu. Presvedčivo opisuje biologický a technologický potenciál platforiem, neposkytuje však dôkaz, že tieto modely už dokážu samostatne nahradiť zvieracie štúdie alebo predpovedať klinické poškodenie obličiek s presne stanovenou citlivosťou a špecificitou.</p>

<p>Tvrdenia o modelovaní glomerulovej filtrácie a tubulárnej reabsorpcie treba chápať ako reprodukciu vybraných funkčných dejov v konkrétnom experimentálnom systéme — nie ako rekonštrukciu celkovej filtračnej, endokrinnej, metabolickej a homeostatickej funkcie obličiek.</p>

<p>Rovnako treba odlišovať <em>biologickú vierohodnosť</em> od <em>regulačnej validácie</em>. Model môže mať fyziologicky presvedčivú architektúru, ale bez reprodukovateľnosti medzi laboratóriami a bez porovnania s klinickými výsledkami ešte nemusí byť vhodný na rozhodovanie o bezpečnosti lieku.</p>

<p>Za povšimnutie stojí aj to, že autori v závere zdôrazňujú interdisciplinárnu spoluprácu inžinierov, biológov a lekárov-vedcov ako <em>podmienku</em> translácie. Ide teda o formuláciu výskumného programu, nie o oznámenie hotového nástroja.</p>

<h2>Význam pre klinickú nefrológiu</h2>

<p>Oblička na čipe ani obličkový organoid dnes nemenia štandardnú diagnostiku ani liečbu pacienta. Ich bezprostredný význam spočíva v predklinickom výskume, objasňovaní mechanizmov ochorení a vývoji liekov.</p>

<p>Dlhodobo môžu prispieť k skoršiemu rozpoznaniu nefrotoxických zlúčenín, presnejšiemu výberu kandidátnych liečiv a lepšiemu modelovaniu genetických ochorení. Najrealistickejším smerom nie je okamžité nahradenie všetkých existujúcich modelov, ale ich účelová kombinácia: údaje z čipov a organoidov sa budú musieť integrovať s farmakokinetickým modelovaním, klinickými databázami, ľudskými biologickými vzorkami a podľa potreby aj so zvieracími štúdiami.</p>

<p>Rozhodujúce nebude, ktorý model je technologicky najpôsobivejší, ale ktorý poskytne reprodukovateľnú a klinicky správnu odpoveď na presne definovanú otázku.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=synteticke-wnt-organizatory-oblickove-organoidy">Syntetické Wnt-sekretujúce organizátory zlepšujú priestorové usporiadanie ľudských obličkových organoidov</a></li>
  <li><a href="article.php?slug=xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca">Xenotransplantácia obličky z geneticky upraveného prasaťa: funkčný štep ešte neznamená imunologický pokoj</a></li>
  <li><a href="article.php?slug=uran-a-oblicky-nefrotoxicita-radiacne-poskodenie-kovy">Urán a obličky: chemická nefrotoxicita, radiačné poškodenie a riziká environmentálnych kovov</a></li>
  <li><a href="article.php?slug=meduza-hojenie-ran-bez-jaziev-regenerativna-medicina">Medúza, ktorá hojí rany bez jaziev: čo môže jednoduchý model naučiť regeneratívnu medicínu</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Daily A, Anandakrishnan N, Haydak J, Himmelfarb J, Azeloglu EU. Kidney-on-Chip and Organoid Models: Harnessing Mechanical Forces for Translational Kidney Biology. Journal of the American Society of Nephrology. 2026. doi: 10.1681/ASN.0000001272. PMID 42709582. <a href="https://pubmed.ncbi.nlm.nih.gov/42709582/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj; odborný prehľad, v čase spracovania publikácia pred zaradením do čísla.</em></small></li>
  <li><small><em>Musah S, Bhattacharya R, Himmelfarb J. Kidney Disease Modeling with Organoids and Organs-on-Chips. Annual Review of Biomedical Engineering. 2024;26(1):383–414. doi: 10.1146/annurev-bioeng-072623-044010. PMID 38424088. <a href="https://pubmed.ncbi.nlm.nih.gov/38424088/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11479997/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. FDA Announces Plan to Phase Out Animal Testing Requirement for Monoclonal Antibodies and Other Drugs. Tlačová správa, 10. apríla 2025. Inštitucionálny autor. <a href="https://www.fda.gov/news-events/press-announcements/fda-announces-plan-phase-out-animal-testing-requirement-monoclonal-antibodies-and-other-drugs" target="_blank" rel="noopener noreferrer">FDA</a>.</em></small></li>
  <li><small><em>U.S. Food and Drug Administration. Roadmap to Reducing Animal Testing in Preclinical Safety Studies. 2025. Inštitucionálny autor. <a href="https://www.fda.gov/files/newsroom/published/roadmap_to_reducing_animal_testing_in_preclinical_safety_studies.pdf" target="_blank" rel="noopener noreferrer">plný text (PDF)</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_oblicka-na-cipe-organoidy-mechanicke-sily_article',
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
