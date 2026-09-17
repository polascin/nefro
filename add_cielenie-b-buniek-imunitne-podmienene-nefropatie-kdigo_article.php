<?php
/**
 * add_cielenie-b-buniek-imunitne-podmienene-nefropatie-kdigo_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie: Floege et al., KDIGO Controversies Conference
 * (Kidney International, 2026).
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
    'title'        => 'Cielenie B buniek pri imunitne podmienených nefropatiách: závery konferencie KDIGO a prečo „čím silnejšie, tým lepšie“ neplatí',
    'slug'         => 'cielenie-b-buniek-imunitne-podmienene-nefropatie-kdigo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dostupnosť, účinnosť aj bezpečnosť liečby cielenej na B bunky sa medzi glomerulovými ochoreniami podstatne líšia. Konferencia KDIGO ukazuje, že rozhodujúca nie je maximálna sila zásahu, ale správna hĺbka deplécie u správneho pacienta – a že chýbajúce biomarkery sú dnes hlavnou brzdou.',
    'content'      => <<<'HTML'
<p>Imunitne podmienené ochorenia obličiek sú často poháňané mechanizmami závislými od B buniek a protilátok. Paleta liečby, ktorá B bunky depletuje alebo hlbšie moduluje, sa preto v posledných rokoch výrazne rozšírila. Organizácia KDIGO usporiadala v <strong>júni 2025 v Paname</strong> konferenciu (controversies conference), ktorej cieľom bolo zhodnotiť dostupné dôkazy a pomenovať medzery v poznaní. Závery boli publikované v roku 2026 v časopise <em>Kidney International</em>.</p>

<p>Hlavné posolstvo dokumentu je triezve: <strong>dostupnosť, účinnosť aj bezpečnosť liečby cielenej na B bunky sa medzi jednotlivými glomerulovými ochoreniami podstatne líšia.</strong> Otázka preto neznie iba „liečiť B bunky, alebo nie“, ale aj akú hĺbku a šírku zásahu zvoliť, koho liečiť a ako bezpečne sledovať odpoveď.</p>

<h2>Prečo nestačí jeden prístup pre všetky diagnózy</h2>

<p>B bunky a plazmatické bunky sa podieľajú na tvorbe patologických protilátok, ale ovplyvňujú aj ďalšie časti imunitnej odpovede – prezentáciu antigénu, tvorbu cytokínov a regulačné dráhy. Biológia B buniek nie je jednorodá, a preto ani terapeutické zásahy nie sú naprieč glomerulovými ochoreniami rovnako účinné.</p>

<p>Dokument pracuje s niekoľkými rovinami zásahu:</p>

<div class="table-responsive" role="region" aria-label="Terapeutické ciele na B bunkách a plazmatických bunkách" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Cieľ</th>
      <th scope="col">Podstata zásahu</th>
      <th scope="col">Typický zástupca</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">BAFF a APRIL</th>
      <td>Modulácia prežívania a diferenciácie B buniek cez faktory prežívania</td>
      <td>Inhibítory BAFF/APRIL</td>
    </tr>
    <tr>
      <th scope="row">CD20</th>
      <td>Deplécia buniek exprimujúcich CD20 (nezasahuje plazmatické bunky)</td>
      <td>Rituximab, obinutuzumab</td>
    </tr>
    <tr>
      <th scope="row">CD38</th>
      <td>Zásah smerom k plazmatickému kompartmentu</td>
      <td>Protilátky anti-CD38</td>
    </tr>
    <tr>
      <th scope="row">CD19</th>
      <td>Hlbšia deplécia vrátane časti plazmablastov; potenciál imunologického „resetu“</td>
      <td>CAR T bunky proti CD19</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kľúčové je, že <strong>CD20 sa neexprimuje na plazmatických bunkách</strong>. Ak je zdrojom patologickej protilátky dlhoveká plazmatická bunka, samotná deplécia CD20 ju nemusí zasiahnuť. To vysvetľuje časť rozdielov v účinnosti medzi diagnózami.</p>

<h2>Čo vieme pri jednotlivých diagnózach</h2>

<h3>IgA nefropatia</h3>

<p>Pri IgA nefropatii má liečba anti-CD20 (rituximab) podľa dostupných dát <strong>obmedzenú účinnosť</strong>. Naproti tomu inhibítory faktorov prežívania <strong>BAFF</strong> (B cell activating factor) a <strong>APRIL</strong> (a proliferation-inducing ligand) a protilátky <strong>anti-CD38</strong> dokážu viesť k zníženiu proteinúrie a k spomaleniu poklesu eGFR.</p>

<p>Praktické dôsledky sú dva. Po prvé, periférna deplécia CD20 nemusí stačiť na zastavenie mechanizmov, ktoré pri IgA nefropatii prebiehajú inde – v slizničnom imunitnom systéme a v plazmatickom kompartmente. Po druhé, údaj o tom, koľko B buniek v periférnej krvi chýba, sám osebe nehovorí nič o tom, čo sa deje s biológiou ochorenia u konkrétneho pacienta.</p>

<h3>Membranózna nefropatia</h3>

<p>Pri membranóznej nefropatii sa protilátky <strong>anti-CD20 stali liečbou prvej línie</strong> pre väčšinu pacientov, ktorí potrebujú imunosupresiu. <strong>Väčšina pacientov dosiahne aspoň parciálnu remisiu do 18 mesiacov.</strong></p>

<p>Dokument zároveň upozorňuje na diferenciáciu podľa cieľových autoantigénov (najmä PLA2R a THSD7A) a na možnosť, že pri rôznom bunkovom zdroji protilátok bude účinok odlišný. Rozvíjajú sa aj ďalšie prístupy – intenzívnejšia deplécia CD20 alebo cielenie plazmatických populácií.</p>

<p>Práve pri membranóznej nefropatii dokument výslovne mierni nadšenie pre bunkovú terapiu CAR T. Ochorenie zvyčajne nie je rýchlo progresívne, chronická imunosupresia nie je vždy potrebná, populácia býva staršia a najnaliehavejšia nenaplnená potreba leží inde. Terapia CAR T sa tu preto rámcuje ako stratégia pre vybrané, ťažké situácie – nie ako ďalší logický krok.</p>

<h3>Podocytopatie: minimálne zmeny a fokálna segmentová glomeruloskleróza</h3>

<p>Pri <strong>steroid-dependentnom nefrotickom syndróme</strong> rituximab účinne <strong>predchádza relapsom</strong>, predovšetkým u detí. Zásadný je však dodatok, ktorý sa v zhrnutiach často vytráca: <strong>tento prínos je prechodný</strong>. Po návrate B buniek relapsy zvyčajne prichádzajú, čo z rituximabu robí nástroj na získanie času a zníženie kumulatívnej dávky steroidov, nie definitívne riešenie.</p>

<p>Dôkazy pre indukciu remisie pri prvom podaní nie sú v niektorých scenároch rovnako presvedčivé ako dôkazy pre prevenciu relapsov. Otvorenou biologickou otázkou zostáva, do akej miery sú podocytopatie riadené B bunkami a aká je úloha antipodocytových protilátok. Z toho vyplýva aj potreba biomarkerov, ktoré by pomohli určiť, či je ochorenie B-bunkovo podmienené a či má protilátková stratégia šancu zabrať.</p>

<h3>Lupusová nefritída</h3>

<p>Pri lupusovej nefritíde priniesli novšie prístupy – <strong>obinutuzumab</strong> a bunková terapia <strong>CAR T</strong> – sľubné výsledky. Terapia CAR T otvára možnosť, aby pacient bol <strong>dlhší čas bez aktivity ochorenia a súčasne bez liečby</strong>, čo je pri lupusovej nefritíde kvalitatívne nový cieľ.</p>

<p>Rozdiel medzi rituximabom a intenzívnejšou stratégiou anti-CD20 je pritom jedným z hlavných argumentov pre koncept „hĺbky deplécie“: rovnaký cieľový antigén, iná miera zásahu, iné výsledky.</p>

<h3>Glomerulonefritída asociovaná s ANCA</h3>

<p>Pri glomerulonefritíde asociovanej s ANCA sa rituximab osvedčil <strong>v indukčnej aj udržiavacej liečbe</strong>. Prebiehajúce skúšania skúmajú prístupy s CAR T bunkami.</p>

<p>Pre budúcnosť dokument otvorene pomenúva medzery: nie je jasné, ktoré modulačné prístupy budú rovnako účinné ako deplécia CD20, a chýba lepšia stratifikácia rizika relapsu vrátane sledovania imunologickej dynamiky po liečbe.</p>

<h2>Nie maximálna sila, ale správna hĺbka</h2>

<p>S pribúdajúcimi cieľmi (BAFF/APRIL, CD20, CD19, CD38) sa opakuje ten istý problém: <strong>nie je jasné, aký stupeň deplécie je optimálny</strong> pre konkrétnu diagnózu, konkrétnu aktivitu ochorenia a konkrétneho pacienta – a chýbajú validované biomarkery, ktoré by to riadili.</p>

<p>Dokument preto označuje <strong>validáciu biomarkerov na výber pacientov a na monitorovanie</strong> za kritickú výskumnú potrebu, spolu s optimalizáciou liečebných protokolov a určením optimálneho trvania liečby.</p>

<p>Prakticky to znamená, že dnes nevieme spoľahlivo odpovedať na otázky, ktoré pri lôžku vznikajú úplne bežne: kedy liečbu ukončiť, ako predpovedať relaps a či je návrat B buniek v periférnej krvi dostatočným vodidlom. Počet B buniek v krvi je dostupný, ale je to náhradný ukazovateľ – nie miera aktivity ochorenia v tkanive.</p>

<h2>Bezpečnosť: rozdiel medzi konvenčnou a hlbokou depléciou</h2>

<p>Bezpečnostné dôsledky sa líšia podľa intenzity zásahu. Dokument konštatuje, že <strong>konvenčná liečba anti-CD20 má priaznivý bezpečnostný profil</strong>, zatiaľ čo terapia CAR T si vyžaduje starostlivý výber pacientov pre riziko syndrómu z uvoľnenia cytokínov a ďalších závažných nežiaducich udalostí.</p>

<p>Toto rozlíšenie je dôležité aj pri komunikácii s pacientom: obavy z rituximabu sa nemajú prenášať z rizikového profilu bunkovej terapie.</p>

<p>Pri liečbe zameranej na B bunky treba počítať najmä s týmito rizikami:</p>

<ul>
  <li>vyššie riziko infekcií,</li>
  <li>prechodná neutropénia a trombocytopénia,</li>
  <li>hypogamaglobulinémia,</li>
  <li>znížená odpoveď na očkovanie,</li>
  <li>zriedkavo <strong>progresívna multifokálna leukoencefalopatia</strong> pri reaktivácii JC vírusu.</li>
</ul>

<p>Pri bunkovej terapii CAR T sa pridáva toxické spektrum známe z onkohematologických protokolov, predovšetkým <strong>syndróm z uvoľnenia cytokínov</strong> (CRS) a <strong>neurotoxicita spojená s efektorovými bunkami imunitného systému</strong> (ICANS).</p>

<p>Z toho vyplýva praktická príprava pred liečbou: posúdiť hladiny imunoglobulínov, monitorovať neutrofily a trombocyty, naplánovať očkovanie a preočkovanie v súlade s návratom B buniek – a pri urgentnej indikácii liečbu <strong>neodkladať</strong> len kvôli očkovaciemu oknu, ak je ohrozený orgán.</p>

<h2>Čo musí prísť, aby sa liečba dala personalizovať</h2>

<p>Výskumné priority nesmerujú len k ďalšiemu lieku, ale k infraštruktúre, ktorá umožní liečbu cieliť:</p>

<ul>
  <li>validované sérologické a histologické biomarkery na výber pacientov a na skoré zachytenie odpovede,</li>
  <li>metódy hodnotiace skutočnú hĺbku deplécie a návrat jednotlivých populácií,</li>
  <li>optimalizácia liečebných protokolov,</li>
  <li>určenie optimálneho trvania liečby a kritérií na jej ukončenie,</li>
  <li>dlhodobé bezpečnostné dáta.</li>
</ul>

<h2>Praktický odkaz pre nefrologickú prax</h2>

<ol>
  <li>Pri imunitne podmienených glomerulopatiách už nejde o nešpecifickú imunosupresiu, ale o <strong>cielený zásah do mechanizmov B buniek</strong>.</li>
  <li>Rozdielna účinnosť naprieč diagnózami ukazuje, že mechanizmus ochorenia nie je univerzálny. <strong>Rituximab nie je zameniteľná odpoveď na každú glomerulopatiu</strong> – pri IgA nefropatii má obmedzený prínos, pri membranóznej nefropatii je liečbou prvej línie.</li>
  <li>Pri steroid-dependentnom nefrotickom syndróme treba od začiatku počítať s <strong>prechodnosťou</strong> účinku a plánovať následný postup.</li>
  <li>Bezpečnostná príprava nie je voliteľná – imunoglobulíny, krvný obraz, očkovací stav a plán sledovania.</li>
  <li>Bunková terapia CAR T je zatiaľ nástrojom pre vybrané, ťažké situácie, nie ďalším stupňom eskalácie pre každého.</li>
</ol>

<h2>Limity dokumentu</h2>

<p>Ide o <strong>záver konferencie</strong>, nie o gradované klinické odporúčanie. Formuluje konsenzus a výskumné priority, nie záväzné postupy so stupňom dôkazu. Pri zavádzaní do praxe preto zostávajú smerodajné platné odporúčania KDIGO pre glomerulové ochorenia a pre lupusovú nefritídu, registračné indikácie jednotlivých liekov a dostupnosť liečby.</p>

<h2>Záver</h2>

<p>Konferencia KDIGO potvrdzuje, že liečba cielená na B bunky je pri imunitne podmienených nefropatiách reálnou a v niektorých diagnózach už štandardnou možnosťou. Zároveň však jasne pomenúva, že ďalší pokrok nezávisí od sily zásahu, ale od schopnosti určiť správnu hĺbku deplécie u správneho pacienta a spoľahlivo ju sledovať. Pokým nebudú validované biomarkery, zostane výber liečby do značnej miery empirický – a práve v tom spočíva najväčšia nenaplnená potreba tejto oblasti.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=iga-nefropatia-uloha-april-v-stvorzasahovom-modeli-patogeneze">Úloha APRIL v štvorzásahovom modeli patogenézy IgA nefropatie</a></li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept pri IgA nefropatii: interim analýza fázy 3</a></li>
  <li><a href="article.php?slug=anti-pla2r-trombozy-membranozna-nefropatia-hypoalbuminemia">Anti-PLA2R a riziko trombóz pri membranóznej nefropatii</a></li>
  <li><a href="article.php?slug=porovnanie-usmerneni-lupusova-nefritida-acr-eular-kdigo">Porovnanie usmernení pre lupusovú nefritídu: ACR, EULAR a KDIGO</a></li>
  <li><a href="article.php?slug=perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza">Perzistujúca mikroskopická hematúria pri podocytopatiách</a></li>
</ul>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Floege J, Ayoub I, Brix SR, Campbell KN, Furie R, Nachman PH, Tang SCW, Tomas NM, Vivarelli M, Cheung M, King JM, Grams ME, Jadoul M, Rovin BH; for Conference Participants. Targeting B cells in immune-mediated kidney diseases: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney International</em>. 2026;110(3):548–565. doi:10.1016/j.kint.2026.02.029. PMID 42034308. <a href="https://doi.org/10.1016/j.kint.2026.02.029" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42034308/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Súvisiace odporúčania KDIGO (kontext, nie zdroj konkrétnych čísel):</strong></em></p>

<ol>
  <li><small><em>KDIGO 2021 Clinical Practice Guideline for the Management of Glomerular Diseases. <a href="https://kdigo.org/guidelines/gd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
  <li><small><em>KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. <a href="https://kdigo.org/guidelines/lupus-nephritis/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
</ol>

<p><small>Bibliografické údaje boli overené v databáze PubMed 17. septembra 2026. Závery konferencie KDIGO nie sú gradovaným klinickým odporúčaním. Text nenahrádza individuálne klinické rozhodnutie, platné znenie odporúčaní ani schválenú informáciu o lieku.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cielenie_b_buniek_imunitne_nefropatie_kdigo',
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
