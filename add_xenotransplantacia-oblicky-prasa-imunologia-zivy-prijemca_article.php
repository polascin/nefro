<?php
/**
 * add_xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): Xenotransplantácia obličky z geneticky
 * upraveného prasaťa — imunologické poznatky z prvého živého príjemcu (62-ročný
 * muž, Massachusetts General Hospital, 2024; prasa so 69 genomickými úpravami).
 * Slovenské odborné spracovanie s dôrazom na T-bunkovú rejekciu, pretrvávajúcu
 * vrodenú imunitu a nefrologické súvislosti. Východiskový zdroj: Tang & Lakkis,
 * komentár v AJKD (2026); primárna analyzovaná štúdia: Ribas a kol., Nature
 * Medicine (2026). Pôvodní autori zdroja sú v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca_article.php"
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
    'title'        => 'Xenotransplantácia obličky z geneticky upraveného prasaťa: funkčný štep ešte neznamená imunologický pokoj',
    'slug'         => 'xenotransplantacia-oblicky-prasa-imunologia-zivy-prijemca',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prvý živý príjemca obličky z prasaťa so 69 genetickými úpravami: xenoštep poskytol klinicky významnú funkciu, no ani intenzívna imunosupresia nezabránila včasnej T-bunkovej rejekcii ani pretrvávajúcej aktivácii vrodenej imunity. Čo z toho vyplýva pre nefrológiu.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>Nedostatok darcovských obličiek zostáva jedným z hlavných limitov transplantačnej medicíny. Mnohí pacienti so zlyhaním obličiek sa transplantácie nedočkajú alebo sa počas čakania stanú pre výkon nevhodnými. Xenotransplantácia obličky z geneticky upraveného prasaťa preto predstavuje potenciálny spôsob, ako v budúcnosti rozšíriť dostupnosť orgánov.</p>

<p>Komentár publikovaný v časopise <em>American Journal of Kidney Diseases</em> analyzuje imunologické poznatky získané pri prvom živom príjemcovi geneticky upravenej prasacej obličky. Prípad ukázal, že xenoštep môže poskytovať klinicky významnú funkciu. Súčasne však odhalil intenzívnu T-bunkovú a vrodenú imunitnú odpoveď napriek rozsiahlym genetickým úpravám darcu a mimoriadne intenzívnej imunosupresii.</p>

<p>Nejde o dôkaz pripravenosti xenotransplantácie na rutinnú klinickú prax. Ide o detailne analyzovaný prípad jedného pacienta, ktorý pomohol presnejšie identifikovať pretrvávajúce imunologické bariéry.</p>

<h2>Klinický prípad</h2>

<p>Príjemcom bol 62-ročný muž so zlyhaním obličiek, diabetes mellitus 2. typu a závažným kardiovaskulárnym ochorením. V roku 2018 podstúpil transplantáciu obličky od zomretého darcu. Po zlyhaní aloštepu, spojenom s BK vírusovou infekciou a rekurenciou diabetickej nefropatie, sa v roku 2023 vrátil k dialyzačnej liečbe.</p>

<p>Opakované komplikácie cievneho prístupu významne zhoršovali jeho kvalitu života. Pravdepodobnosť získania ďalšieho ľudského orgánu bola nízka, zatiaľ čo riziko úmrtia alebo straty spôsobilosti na transplantáciu bolo vysoké.</p>

<p>V roku 2024 mu bola transplantovaná oblička z yucatánskeho miniatúrneho prasaťa s 69 genomickými úpravami. Ich cieľom bolo:</p>

<ul>
  <li>odstrániť hlavné prasacie sacharidové antigény rozpoznávané ľudskými protilátkami,</li>
  <li>vložiť ľudské gény regulujúce komplement, koaguláciu, zápal a interakciu imunitných buniek,</li>
  <li>inaktivovať sekvencie prasacích endogénnych retrovírusov,</li>
  <li>zlepšiť imunologickú a fyziologickú kompatibilitu orgánu s človekom.</li>
</ul>

<p>Genetické úpravy zahŕňali vyradenie génov <em>GGTA1</em>, <em>CMAH</em> a <em>B4GALNT2</em> a vloženie siedmich ľudských transgénov: <em>TNFAIP3</em>, <em>HMOX1</em>, <em>CD47</em>, <em>CD46</em>, <em>CD55</em>, <em>THBD</em> a <em>PROCR</em>. Ďalšie úpravy boli zamerané na inaktiváciu prasacích endogénnych retrovírusov.</p>

<p>Takéto zásahy znižujú niektoré známe bariéry, ale nevytvárajú imunologicky „neviditeľný“ orgán. Rovnako nemožno tvrdiť, že úplne odstraňujú riziko prenosu všetkých zoonotických infekcií.</p>

<h2>Imunosupresívna liečba</h2>

<p>Indukčná liečba zahŕňala:</p>

<ul>
  <li>antitymocytový globulín,</li>
  <li>rituximab,</li>
  <li>tegoprubart, monoklonovú protilátku proti CD154,</li>
  <li>ravulizumab, inhibítor zložky komplementu C5.</li>
</ul>

<p>Udržiavacia liečba pozostávala z takrolimu, kyseliny mykofenolovej, glukokortikoidov a pokračujúceho podávania tegoprubartu.</p>

<p>Blokáda interakcie CD40 a CD154 má v xenotransplantácii mimoriadny význam. Tlmí aktiváciu T-lymfocytov, pomoc B-lymfocytom, izotypový presmyk imunoglobulínov a vznik protilátok namierených proti darcovi. Tegoprubart však zatiaľ nie je štandardnou imunosupresívnou liečbou po transplantácii obličky a v tomto prípade bol použitý výskumne.</p>

<h2>Metodika imunologického hodnotenia</h2>

<p>Primárna práca publikovaná v časopise <em>Nature Medicine</em> kombinovala viacero analytických metód:</p>

<ul>
  <li>jednobunkové a hromadné transkriptomické analýzy,</li>
  <li>sérovú proteomiku,</li>
  <li>necielenú metabolomiku,</li>
  <li>prietokovú cytometriu,</li>
  <li>histopatologické a molekulové vyšetrenie biopsií,</li>
  <li>multiplexnú imunofluorescenciu,</li>
  <li>stanovenie protilátok viažucich sa na prasacie bunky,</li>
  <li>meranie ľudskej a prasacej bezbunkovej DNA.</li>
</ul>

<p>Vzorky krvi sa odoberali pred transplantáciou a opakovane počas 51 dní. Biopsie xenoštepu boli vyšetrené na 8. a 34. pooperačný deň a následne post mortem.</p>

<p>Metodika poskytla podrobný časový obraz imunitnej odpovede, ale všetky údaje pochádzali z jediného príjemcu. Štatistické porovnania preto nemajú rovnakú výpovednú hodnotu ako výsledky kohortovej štúdie.</p>

<h2>Akútna T-bunkami sprostredkovaná rejekcia</h2>

<p>Na 8. pooperačný deň biopsia ukázala závažnú T-bunkami sprostredkovanú rejekciu klasifikovanú ako Banff 2A. Nenašli sa presvedčivé známky trombotickej mikroangiopatie ani jednoznačnej protilátkami sprostredkovanej rejekcie.</p>

<p>Rejekcia sa liečila pulzmi metylprednizolónu, ďalšími dávkami antitymocytového globulínu, tocilizumabom proti receptoru interleukínu 6 a pegcetacoplanom, ktorý inhibuje C3 a C3b. Zároveň sa zvýšila intenzita udržiavacej imunosupresie. Funkcia štepu sa po liečbe zlepšila.</p>

<p>Hodnotenie podľa Banffovej klasifikácie je klinicky užitočné, ale treba upozorniť, že táto klasifikácia bola vytvorená pre ľudské aloštepy. Jej diagnostické prahy a prognostický význam nie sú pri prasacích xenoštepoch úplne validované.</p>

<h2>Periférna krv neodhalila celý obraz</h2>

<p>Po intenzívnej liečbe nastala výrazná deplécia cirkulujúcich T- a B-lymfocytov. To však neznamenalo úplné potlačenie imunitnej reakcie v tkanivách.</p>

<p>V regionálnych lymfatických uzlinách pretrvávali cytotoxické CD8+ T-lymfocyty. Tieto bunky môžu expandovať, migrovať do štepu a pokračovať v jeho poškodzovaní aj vtedy, keď je ich počet v periférnej krvi nízky.</p>

<p>Výsledok má zásadný praktický význam. Monitorovanie periférnych lymfocytov nemusí spoľahlivo odrážať aktivitu imunity v lymfatickom tkanive a priamo v xenoštepe. Budúce stratégie budú musieť kombinovať:</p>

<ul>
  <li>funkčné ukazovatele štepu,</li>
  <li>proteinúriu,</li>
  <li>cirkulujúce biomarkery poškodenia,</li>
  <li>zobrazovacie alebo molekulové metódy,</li>
  <li>biopsiu pri podozrení na rejekciu.</li>
</ul>

<h2>Vrodená imunita zostala aktívna</h2>

<p>Po potlačení adaptívnej imunity pretrvávali známky aktivácie NK buniek, monocytov a makrofágov. V krvi aj v štepe sa zistili zápalové transkripčné a proteomické signály. Zvýšená bola produkcia interleukínov 6 a 8 monocytmi, signalizácia interferónov typu I a odpoveď sprostredkovaná interleukínom 1. Zaznamenané boli aj metabolické zmeny vrátane zvýšenia L-kynurenínu.</p>

<p>Tieto výsledky podporujú predpoklad, že vrodená imunita môže udržiavať poškodenie xenoštepu aj po rozsiahlej blokáde T- a B-bunkovej odpovede.</p>

<p>Makrofágy s fenotypovými znakmi M2 nemožno automaticky považovať za neškodné reparačné bunky. Môžu sa podieľať na remodelácii extracelulárnej matrix, pretrvávajúcom nízkostupňovom zápale a fibróze.</p>

<p>Na 34. deň biopsia preukázala intersticiálnu fibrózu a tubulárnu atrofiu približne v 30 % kortikálnej oblasti. Ide o znepokojujúci nález, ale z jedného krátkodobo sledovaného prípadu nemožno určiť, do akej miery išlo o dôsledok rejekcie, ischemicko-reperfúzneho poškodenia, liekovej toxicity, fyziologickej nekompatibility alebo kombinácie viacerých mechanizmov.</p>

<h2>Protilátková odpoveď bola menej výrazná</h2>

<p>V cirkulácii sa nezistila nápadná tvorba protilátok proti prasacím bunkám. K potlačeniu humorálnej odpovede pravdepodobne prispeli:</p>

<ul>
  <li>odstránenie troch hlavných prasacích xenoantigénov,</li>
  <li>deplécia B-lymfocytov rituximabom,</li>
  <li>blokáda CD154 tegoprubartom,</li>
  <li>intenzívna kombinovaná imunosupresia.</li>
</ul>

<p>Biopsie však vykazovali meniacu sa glomerulárnu depozíciu IgG, IgA, C3 a terminálneho komplexu komplementu C5b-9. Tento nález bol sprevádzaný albuminúriou. Je preto možné, že boli prítomné nízke hladiny cirkulujúcich protilátok, ktoré použitá metóda krížovej skúšky (crossmatch) na prasacích bunkách nezachytila.</p>

<p>Neprítomnosť výraznej cirkulujúcej protilátkovej odpovede teda nemožno zamieňať s úplnou neprítomnosťou humorálneho poškodenia. Rovnako nemožno z jedného prípadu uzavrieť, že protilátkami sprostredkovaná rejekcia prestala byť hlavnou prekážkou xenotransplantácie.</p>

<h2>Funkcia štepu a úmrtie príjemcu</h2>

<p>Xenoštep poskytoval klinicky významnú renálnu podporu. Pacient však zomrel na 52. pooperačný deň po náhlej kardiálnej príhode.</p>

<p>Pitva odhalila zväčšené srdce, rozsiahlu koronárnu aterosklerózu a fibrózu ľavej komory bez dôkazu akútneho infarktu myokardu. Za pravdepodobnú príčinu smrti sa považovala malígna arytmia.</p>

<p>Priama príčinná súvislosť medzi úmrtím a rejekciou xenoštepu nebola preukázaná. Rovnako však nemožno bezpečne vylúčiť, že systémový zápal, metabolická záťaž, intenzívna imunosupresia alebo pooperačné zmeny prispeli k destabilizácii vysoko rizikového kardiovaskulárneho pacienta.</p>

<p>Komentár správne upozorňuje, že systémový zápal môže podporovať kardiovaskulárne príhody. V tomto prípade však ide o biologicky prijateľnú hypotézu, nie o dokázaný mechanizmus úmrtia. Navyše nebola uvedená ani základná časová dynamika C-reaktívneho proteínu, ktorá by klinickú interpretáciu zápalu doplnila.</p>

<h2>Porovnanie s experimentmi u zomretých príjemcov</h2>

<p>Predchádzajúce experimenty s prasacími obličkami u príjemcov s potvrdenou smrťou mozgu ukázali technickú uskutočniteľnosť a krátkodobú funkciu štepu. Ich imunologická interpretácia je však obmedzená.</p>

<p>Smrť mozgu, kritické ochorenie, umelá ventilácia a podpora vitálnych funkcií zásadne menia zápalové a imunitné mechanizmy. Neprítomnosť výraznej bunkovej rejekcie v takomto modeli preto nemožno priamo preniesť na živého príjemcu.</p>

<p>V jednom z dlhších experimentov u zomretého príjemcu dominovala progresívna humorálna odpoveď s expanziou plazmablastov, NK buniek a dendritických buniek. Na 33. deň sa rozvinula protilátkami sprostredkovaná rejekcia a neskôr zmiešaná humorálna a bunková rejekcia.</p>

<p>Pri živom príjemcovi dominovala najskôr T-bunková rejekcia a následne pretrvávajúca aktivácia monocytov a makrofágov. Rozdiel mohol súvisieť s použitými genetickými úpravami, stavom príjemcu a odlišnou imunosupresiou, najmä s podávaním tegoprubartu.</p>

<p>Spoločným zistením je, že zachovaná funkcia xenoštepu neznamená neprítomnosť aktívneho imunologického poškodenia.</p>

<h2>Praktický význam pre nefrológov</h2>

<p>Ak xenotransplantácia vstúpi do kontrolovaných klinických skúšaní, transplantológovia a nefrológovia budú musieť riešiť problémy presahujúce štandardnú alotransplantáciu.</p>

<h3>Výber príjemcov</h3>

<p>Prvými kandidátmi budú pravdepodobne pacienti s veľmi nízkou pravdepodobnosťou získania ľudského orgánu, vysokým rizikom dialyzačných komplikácií a dostatočnou rezervou na zvládnutie intenzívnej imunosupresie.</p>

<p>Rozhodovanie musí zahŕňať kardiovaskulárne riziko, infekčné riziko, malignity, adherenciu, psychosociálnu spôsobilosť a schopnosť dlhodobého epidemiologického monitorovania.</p>

<h3>Sledovanie funkcie xenoštepu</h3>

<p>Okrem kreatinínu, eGFR a diurézy bude potrebné dôsledne sledovať:</p>

<ul>
  <li>albuminúriu a proteinúriu,</li>
  <li>močový sediment,</li>
  <li>elektrolyty a acidobázickú rovnováhu,</li>
  <li>sodíkovú a vodnú homeostázu,</li>
  <li>krvný tlak,</li>
  <li>poruchy koagulácie a známky trombotickej mikroangiopatie,</li>
  <li>infekčné komplikácie vrátane potenciálnych zoonóz,</li>
  <li>molekulové biomarkery poškodenia a bezbunkovú prasaciu DNA.</li>
</ul>

<p>Rovnice na výpočet eGFR vytvorené pre ľudské obličky nemusia mať pri prasacom xenoštepe rovnakú presnosť a biologickú interpretáciu. Na presnejšie hodnotenie filtračnej funkcie môžu byť potrebné metódy meranej GFR.</p>

<h3>Cielená liečba rejekcie</h3>

<p>Ďalší vývoj pravdepodobne nebude založený iba na zvyšovaní celkovej imunosupresívnej záťaže. Potrebné bude cielene zasiahnuť:</p>

<ul>
  <li>kostimulačné dráhy T-lymfocytov,</li>
  <li>tvorbu protilátok,</li>
  <li>aktiváciu komplementu,</li>
  <li>NK bunky,</li>
  <li>monocyty a makrofágy,</li>
  <li>zápalovo-koagulačné prepojenia.</li>
</ul>

<p>Takáto liečba však môže priniesť závažné infekčné, hematologické a onkologické riziká. Bezpečnosť nemožno odvodiť z krátkeho sledovania jediného pacienta.</p>

<h2>Limity dôkazov</h2>

<p>Najdôležitejším limitom je počet príjemcov: išlo o jediného pacienta bez kontrolnej skupiny. Z toho vyplývajú ďalšie obmedzenia:</p>

<ul>
  <li>nemožno odhadnúť pravdepodobnosť ani spektrum rejekcie,</li>
  <li>nemožno určiť dlhodobé prežívanie xenoštepu,</li>
  <li>nemožno spoľahlivo rozlíšiť účinok jednotlivých zložiek imunosupresie,</li>
  <li>nemožno vyhodnotiť dlhodobé infekčné a zoonotické riziko,</li>
  <li>nemožno stanoviť optimálnu kombináciu genetických úprav,</li>
  <li>nemožno posúdiť kvalitu života ani porovnať výsledky s dialýzou alebo ľudskou transplantáciou,</li>
  <li>multiomické asociácie nemožno považovať za dôkaz príčinnej súvislosti.</li>
</ul>

<p>Komentovaný článok v AJKD je odborný redakčný komentár, nie pôvodná štúdia. Jeho kritické závery sú primerané, niektoré úvahy o systémovom zápale a príčine úmrtia však zostávajú hypotetické.</p>

<h2>Záver</h2>

<p>Transplantácia geneticky upravenej prasacej obličky živému človeku preukázala, že xenoštep môže krátkodobo poskytovať klinicky významnú renálnu funkciu. Súčasne však ukázala, že ani 69 genomických úprav a intenzívna kombinovaná imunosupresia nezabránili závažnej T-bunkami sprostredkovanej rejekcii a pretrvávajúcej aktivácii vrodenej imunity.</p>

<p>Najdôležitejším poznatkom je, že dobrá funkcia xenoštepu nevylučuje pokračujúce imunologické poškodenie. Xenotransplantácia obličky preto zostáva experimentálnou liečbou vhodnou výlučne pre prísne kontrolované klinické protokoly. Pred širším použitím bude potrebné preukázať prijateľné dlhodobé prežívanie štepu aj príjemcu, zvládnuteľné infekčné riziko, fyziologickú kompatibilitu a bezpečnejšiu cielenú imunosupresiu.</p>

<h2>Zdroje</h2>

<h3>Východiskový odborný komentár</h3>

<p>Zhouqi Tang, Fadi G. Lakkis. <em>Pig Kidney Xenotransplantation: Immune Insights From a Landmark Human Case.</em> American Journal of Kidney Diseases. Publikované online 18. júna 2026. DOI: 10.1053/j.ajkd.2026.05.005. <a href="https://www.ajkd.org/article/S0272-6386(26)00966-2/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></p>

<h3>Primárna analyzovaná štúdia</h3>

<p>Guilherme T. Ribas, André F. Cunha, Jonathan P. Avila, Alessia Giarraputo, Leela Morena, Karina Lima, Rodrigo B. Gassen, Jia-Yun Chen, Jia-Ren Lin, Sandro Santagata, Claire T. Avillach, Birgitta A. Ryback, Martin S. Lindner, Sivan Bercovici, Ivy A. Rosales, Tatsuo Kawai, Helder I. Nakaya, Robert B. Colvin, Thiago J. Borges, Leonardo V. Riella. <em>Immune profiling in a living human recipient of a gene-edited pig kidney.</em> Nature Medicine (2026); 32(1): 270–280. DOI: 10.1038/s41591-025-04053-3. <a href="https://www.nature.com/articles/s41591-025-04053-3" target="_blank" rel="noopener noreferrer">nature.com</a></p>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
