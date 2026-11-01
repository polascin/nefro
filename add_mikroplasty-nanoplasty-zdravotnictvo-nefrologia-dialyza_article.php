<?php
/**
 * add_mikroplasty-nanoplasty-zdravotnictvo-nefrologia-dialyza_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: mikro- a nanoplasty v zdravotníctve s dôrazom na dialýzu.
 * Avíza do newslettera sa neposielajú (enqueue_newsletter => false).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_mikroplasty-nanoplasty-zdravotnictvo-nefrologia-dialyza_article.php"
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
    'title'        => 'Mikro- a nanoplasty v zdravotníctve: otázky pre nefrológiu a dialyzovaných pacientov',
    'slug'         => 'mikroplasty-nanoplasty-zdravotnictvo-nefrologia-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Mikroplasty sa nachádzajú v dialyzačných tekutinách aj v mimotelových okruhoch. Prehľad overených meraní, mechanizmov a toho, čo zatiaľ nemožno tvrdiť o klinickom dopade.',
    'content'      => <<<'HTML'
<figure><a href="img/mikroplasty-nanoplasty-zdravotnictvo-nefrologia-dialyza.webp" rel="noopener noreferrer" target="_blank"><img src="img/mikroplasty-nanoplasty-zdravotnictvo-nefrologia-dialyza.webp" alt="Polopriesvitná oblička a dialyzačný okruh s mikroplastovými časticami v tekutine na tmavom pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, zariadenia ani výrobku.</figcaption></figure>

<p>Mikroplasty a nanoplasty patria medzi perzistentné častice, ktoré sa v posledných rokoch čoraz častejšie skúmajú z hľadiska možného vplyvu na ľudské zdravie. Vznikajú fragmentáciou plastových materiálov alebo sa uvoľňujú pri výrobe a manipulácii. Klinický problém je konkrétny: zdravotníctvo spotrebúva veľké množstvo plastových pomôcok a jednorazových komponentov, ktoré sa môžu dostať do blízkosti biologických tekutín alebo s nimi priamo do kontaktu.</p>

<p>Cieľom tohto článku je zhrnúť poznatky relevantné pre nefrológiu, najmä pre pacientov liečených hemodialýzou a peritoneálnou dialýzou, a zároveň jasne oddeliť overenú expozíciu od mechanistickej vierohodnosti a od klinickej kauzality, ktorá zatiaľ chýba.</p>

<h2>Základné pojmy</h2>

<p>V štúdiách sa používajú rôzne pracovné definície. Najčastejšie sa mikroplasty označujú ako častice menšie než 5&nbsp;mm a nanoplasty ako častice s rozmermi pod 1&nbsp;µm.<sup>1</sup></p>

<p>Pre klinickú interpretáciu však nie je rozhodujúce len označenie veľkostnej triedy. Podstatné sú veľkostná frakcia, typ polyméru (napríklad polyvinylchlorid alebo polyetylén), tvar (vlákna, fragmenty, fólie), chemické prídavné látky a kontaminanty viazané na povrchu častíc, ako aj trvanie expozície a biologická dostupnosť.</p>

<h2>Ako môže zdravotníctvo prispievať k expozícii</h2>

<h3>Mechanické uvoľňovanie častíc z pomôcok</h3>

<p>Častice môžu vznikať alebo sa uvoľňovať z plastových komponentov pri mechanickom namáhaní, prietoku tekutiny, vibráciách a pôsobení tepla. V mimotelových okruhoch sa opisuje najmä uvoľňovanie z materiálov vystavených treniu a zmenám tlaku. Rozhodujúci je konkrétny konštrukčný materiál a spôsob prevádzky.<sup>2</sup></p>

<h3>Prenos častíc do krvného obehu</h3>

<p>Pri niektorých výkonoch sa biologická bariéra obchádza, a častice sa preto môžu dostať priamo do krvného riečiska. Pri kardiopulmonálnom bypase (CPB) in vitro simulácie ukázali, že okruhy produkujú merateľné množstvá mikroplastov do cirkulujúcej tekutiny.<sup>2</sup></p>

<h3>Dialýza ako osobitná situácia</h3>

<p>Dialýza je špecifická tým, že pacient je dlhodobo vystavený veľkým objemom dialyzačnej kvapaliny a že časť systému môže obsahovať plastové komponenty, obaly a skladovacie materiály. Pri absencii moču alebo pri obmedzenej renálnej eliminácii môže byť relevantná aj kumulácia častíc a ich prídavných látok, ak sa preukáže biologická absorpcia. Údaje však zatiaľ nepreukazujú jednoznačnú klinickú príčinnosť. Ide skôr o signál expozície a o biologicky vierohodné mechanizmy.</p>

<h2>Dôkazy pri mimotelových výkonoch: kardiopulmonálny bypass</h2>

<p>V in vitro štúdii, ktorá simulovala konvenčný CPB a minimálne invazívnu mimotelovú cirkuláciu (MiECC), autori kvantifikovali mikroplasty produkované počas behu okruhov a charakterizovali ich veľkosť, tvar a polymér. V oboch typoch okruhov sa mikroplasty generovali: konvenčný okruh produkoval v priemere 60,4&nbsp;±&nbsp;7,6 častíc na liter a hodinu, MiECC okruh 48,4&nbsp;±&nbsp;31,3 častíc na liter a hodinu.<sup>2</sup></p>

<p>Okrem množstva je dôležitá aj veľkostná charakteristika. Pri konvenčnom CPB boli mikroplastové častice významne dlhšie (v priemere 93,5&nbsp;±&nbsp;98,6&nbsp;µm) než pri MiECC (62,0&nbsp;±&nbsp;54,4&nbsp;µm).<sup>2</sup> Dominantné polyméry sa medzi okruhmi líšili: pri konvenčnom okruhu najmä polydimetylsiloxán a metakryláty, pri MiECC najmä polypropylén, polyetylén a polyamid.</p>

<p>Tento typ dôkazu nie je priamym dôkazom klinického dopadu na pacienta. Podporuje však tvrdenie, že zdravotnícke zariadenia môžu byť zdrojom plastových častíc v cirkulujúcich tekutinách, a otvára otázku, či a ako môžu mikroplasty ovplyvniť zápalovú odpoveď, oxidačný stres a endotelovú dysfunkciu.</p>

<h2>Dôkazy v nefrológii: mikroplasty v dialyzačných tekutinách</h2>

<h3>Dizajn štúdie</h3>

<p>Jedna z najrelevantnejších publikácií pre dialyzovaných pacientov systematicky kvantifikovala a charakterizovala mikroplasty v hemodialyzačných (HD) a peritoneálnych dialyzačných (PD) tekutinách.<sup>1</sup> Autori analyzovali vzorky z originálnych uzavretých obalov. Pri HD hodnotili čistotu roztokov samostatne, bez kontaktu s dialyzačným prístrojom a systémom úpravy vody. To umožňuje lepšie odlíšiť kontamináciu pochádzajúcu zo samotných roztokov, z výroby alebo z obalového materiálu.</p>

<h3>Koncentrácie a polymérne zloženie</h3>

<p>Mikroplasty boli detegované vo všetkých analyzovaných dialyzačných tekutinách. Priemerná koncentrácia bola v HD roztokoch 0,29&nbsp;±&nbsp;0,16 častíc na liter a v PD roztokoch 0,34&nbsp;±&nbsp;0,02 častíc na liter. Rozdiel v koncentrácii nebol štatisticky významný.<sup>1</sup></p>

<p>Rozdiel bol v charakteristikách častíc: mikroplasty v HD roztokoch mali významne väčší priemerný rozmer než v PD (1,31&nbsp;±&nbsp;0,98&nbsp;mm oproti 0,64&nbsp;±&nbsp;0,43&nbsp;mm).<sup>1</sup> Medzi dominantné polyméry patrili polyetylén (PE), polyvinylchlorid (PVC) a etylénvinylacetát (EVA). V časti identifikovaných častíc boli detegované aj prírodné celulózové materiály. V reálnych tekutinách teda môže byť detegovaná frakcia zmesou syntetických a prírodných častíc, čo si vyžaduje prísnu analytickú kontrolu a opatrnú interpretáciu.</p>

<h3>Odhad týždennej expozície</h3>

<p>Hoci sa priame koncentrácie v HD a PD roztokoch významne nelíšili, autori odhadli týždennú expozíciu podľa typických objemov dialyzačných výmen. V ich modelovaní zodpovedá vyššiemu týždennému objemu pri peritoneálnej dialýze vyšší odhadovaný počet častíc: približne 14,28&nbsp;±&nbsp;0,84 častíc za týždeň pri PD oproti 9,57&nbsp;±&nbsp;5,28 častíc za týždeň pri HD, teda zhruba o polovicu viac pri PD.<sup>1</sup></p>

<h3>Interpretácia pre prax</h3>

<p>Štúdia nepreukazuje, že mikroplasty spôsobujú konkrétne klinické výsledky u dialyzovaných pacientov. Poskytuje však dôkaz o expozícii v relevantnej populácii, a to priamo na úrovni dialyzačných tekutín, vrátane originálnych uzavretých prípravkov.<sup>1</sup> Pre nefrológiu je to zásadné: dialýza je časovo predĺžená a objemovo významná terapia, preto aj relatívne nízke koncentrácie môžu pri dlhodobom trvaní znamenať biologicky relevantnú kumulatívnu expozíciu.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie mikroplastov v HD a PD tekutinách podľa Kara a spol." tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Hemodialýza</th>
      <th scope="col">Peritoneálna dialýza</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Koncentrácia (častíc/l)</th>
      <td>0,29&nbsp;±&nbsp;0,16</td>
      <td>0,34&nbsp;±&nbsp;0,02</td>
    </tr>
    <tr>
      <th scope="row">Priemerný rozmer častíc</th>
      <td>1,31&nbsp;±&nbsp;0,98&nbsp;mm</td>
      <td>0,64&nbsp;±&nbsp;0,43&nbsp;mm</td>
    </tr>
    <tr>
      <th scope="row">Odhad týždennej expozície</th>
      <td>9,57&nbsp;±&nbsp;5,28 častíc/týždeň</td>
      <td>14,28&nbsp;±&nbsp;0,84 častíc/týždeň</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Potenciálne mechanizmy účinku</h2>

<p>V súčasnosti nemožno tvrdiť priamu príčinnú súvislosť s konkrétnou diagnózou u človeka. Mechanistické a predklinické zistenia však podporujú biologickú vierohodnosť, že mikroplasty a nanoplasty môžu zvyšovať oxidačný stres, podporovať zápalovú odpoveď, ovplyvňovať endotel a mikrocirkuláciu, prispievať k imunologickej aktivácii a pôsobiť nepriamo cez prídavné látky alebo cez kontaminanty naviazané na povrchu častíc.</p>

<p>V oblasti kardiovaskulárnej patológie sa v ľudských aterosklerotických plakoch zistili mikro- a nanoplasty. V prospektívnom sledovaní pacientov po karotickej endarterektómii bola prítomnosť týchto častíc v plaku spojená s vyšším rizikom kombinovaného ukazovateľa (infarkt myokardu, cievna mozgová príhoda alebo úmrtie z akejkoľvek príčiny): pomer rizík 4,53 (95&nbsp;% interval spoľahlivosti 2,00 až 10,27).<sup>3</sup> Ide o observačné spojenie. Samo osebe nepotvrdzuje kauzalitu a nevysvetľuje, či častice prispievajú k tvorbe plaku, alebo sú skôr markerom iných expozícií a rizikových faktorov.</p>

<h2>Klinické implikácie pre nefrológiu</h2>

<h3>Čo vieme a čo nie</h3>

<p><strong>Vieme:</strong> dialyzovaní pacienti sú vystavení mikroplastom v dialyzačných tekutinách, vrátane identifikácie typov polymérov, a to aj pri hodnotení originálnych uzavretých prípravkov.<sup>1</sup> Mimotelové okruhy dokážu produkovať mikroplasty v podmienkach in vitro simulácie a zároveň preukázať rozdiely v charakteristikách častíc.<sup>2</sup></p>

<p><strong>Nevieme, alebo vieme zatiaľ nedostatočne:</strong> či sa zistené mikroplasty významne absorbujú do systémového obehu; aký je klinický vplyv na progresiu chronickej choroby obličiek, zápalové ukazovatele, kardiovaskulárne výsledky alebo kvalitu života; ako sa expozícia mení medzi jednotlivými zariadeniami a pracovnými postupmi v praxi.</p>

<h3>Prečo je dialyzovaná populácia citlivá na kumulatívnu expozíciu</h3>

<p>Pacienti liečení dialýzou majú zvyčajne obmedzenú renálnu elimináciu, často chronický prozápalový stav a zvýšené kardiovaskulárne riziko. V takom kontexte môže aj subklinická biologická expozícia predstavovať relevantný príspevok k celkovému riziku. Túto hypotézu treba overiť v prospektívnych kohortách a v intervenčných štúdiách zameraných na zníženie uvoľňovania častíc, nie ju prijať ako hotový klinický záver.</p>

<h2>Praktický postup bez neoverených sľubov</h2>

<p>Dôkazy zatiaľ neumožňujú zaviesť univerzálne klinické opatrenie na úrovni jednotlivého pacienta ako štandard starostlivosti. Rozumný postup je:</p>

<ol>
  <li>minimalizovať zbytočnú expozíciu na úrovni procesov a materiálov,</li>
  <li>požadovať transparentné informácie o zložení a možnom uvoľňovaní častíc od dodávateľov,</li>
  <li>v dialyzačných strediskách hodnotiť kvalitu a bezpečnosť aj z pohľadu časticovej kontaminácie.</li>
</ol>

<p>Do budúcnosti dávajú zmysel zlepšenie filtrácie a úpravy vody, hodnotenie účinnosti bariér a filtrov proti frakciám mikro- a submikročastíc a prehodnotenie materiálov, obalov a manipulačných postupov, ktoré môžu byť zdrojom častíc už pri dodávke dialyzačného roztoku.<sup>1</sup></p>

<h2>Limity súčasných dôkazov</h2>

<ol>
  <li><strong>Kontaminácia a pozadie v laboratóriu.</strong> Merania musia mať kontrolné slepé vzorky a robustnú analytickú metodiku.</li>
  <li><strong>Prevod merania na klinický dopad.</strong> Často ide o in vitro podmienky alebo o detekciu v tekutinách, nie o priame meranie biologickej absorpcie a následných klinických výsledkov.</li>
  <li><strong>Heterogenita polymérov.</strong> Toxikologický význam môže závisieť od polyméru, prídavných látok a tvaru častíc.</li>
  <li><strong>Variabilita klinických protokolov.</strong> Typ zariadenia, dĺžka expozície, spôsob manipulácie a kvalita dialyzačných tekutín môžu v praxi výrazne meniť expozíciu.</li>
</ol>

<h2>Záver</h2>

<p>Súčasné poznatky podporujú záver, že mikroplasty môžu v zdravotníctve vznikať a uvoľňovať sa z plastových komponentov a že u dialyzovaných pacientov možno zistiť mikroplastovú kontamináciu priamo v dialyzačných tekutinách.<sup>1,2</sup> Klinický význam zostáva neistý, pretože chýbajú priame kauzálne dôkazy o tom, že tieto častice sú zodpovedné za konkrétne nefrologické alebo systémové diagnózy.</p>

<p>Pre nefrológiu je už teraz relevantné, že dialýza predstavuje dlhodobú a objemovo významnú expozíciu. Opodstatnené je pokračovať v meraniach expozície, v štandardizácii analytických postupov a v návrhu intervenčných štúdií zameraných na minimalizáciu uvoľňovania mikroplastov v dialyzačnom procese.</p>

<hr>

<p><em><strong>Upozornenie pre zdravotníckych pracovníkov:</strong> Text je odborným prehľadom publikovaných dôkazov. Nenahrádza posúdenie konkrétneho výrobku, dodávateľského reťazca ani regulačné požiadavky na dialyzačné roztoky a mimotelové okruhy.</em></p>

<h2>Literatúra</h2>

<ol>
  <li><small><em>Kara E, Konur K, Şentürk Koca Y, Aytan Ü. Unveiling hidden contaminants: a systematic quantification and characterization of microplastics in hemodialysis and peritoneal dialysis fluids. <em>BMC Nephrology</em>. 2025;26(1):359. doi: <a href="https://doi.org/10.1186/s12882-025-04281-2" target="_blank" rel="noopener noreferrer">10.1186/s12882-025-04281-2</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/40624606/" target="_blank" rel="noopener noreferrer">40624606</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12235760/" target="_blank" rel="noopener noreferrer">PMC12235760</a>.</em></small></li>
  <li><small><em>Green JL, Field DT, Bennett R, Jenner LC, Chapman EC, Sadofsky LR, Rotchell JM, Loubani M. Microplastics in cardiopulmonary bypass: quantification and characterization of particles across systems. <em>Interdisciplinary Cardiovascular and Thoracic Surgery</em>. 2025;40(6):ivaf080. doi: <a href="https://doi.org/10.1093/icvts/ivaf080" target="_blank" rel="noopener noreferrer">10.1093/icvts/ivaf080</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/40493894/" target="_blank" rel="noopener noreferrer">40493894</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12161987/" target="_blank" rel="noopener noreferrer">PMC12161987</a>.</em></small></li>
  <li><small><em>Marfella R, Prattichizzo F, Sardu C, Fulgenzi G, Graciotti L, Spadoni T, D’Onofrio N, Scisciola L, La Grotta R, Frigé C, Pellegrini V, Municinò M, Siniscalchi M, Spinetti F, Vigliotti G, Vecchione C, Carrizzo A, Accarino G, Squillante A, Spaziano G, Mirra D, Esposito R, Altieri S, Falco G, Fenti A, Galoppo S, Canzano S, Sasso FC, Matacchione G, Olivieri F, Ferraraccio F, Panarese I, Paolisso P, Barbato E, Lubritto C, Balestrieri ML, Mauro C, Caballero AE, Rajagopalan S, Ceriello A, D’Agostino B, Iovino P, Paolisso G. Microplastics and Nanoplastics in Atheromas and Cardiovascular Events. <em>New England Journal of Medicine</em>. 2024;390(10):900–910. doi: <a href="https://doi.org/10.1056/NEJMoa2309822" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2309822</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38446676/" target="_blank" rel="noopener noreferrer">38446676</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11009876/" target="_blank" rel="noopener noreferrer">PMC11009876</a>.</em></small></li>
</ol>

<p><small><em><strong>Poznámka k dôkazom:</strong> Autorské zoznamy, DOI, PMID, ročníky, čísla, strany a uvedené číselné výsledky boli overené 1.&nbsp;novembra 2026 cez Crossref a PubMed/PMC (PMID 40624606, 40493894, 38446676). Týždenné odhady expozície sú modelované z koncentrácie a typických objemov, nie priamym meraním absorpcie. V abstrakte Kara a spol. je pri týždennej expozícii uvedená jednotka „mp.&nbsp;L⁻¹“; podľa kontextu a výpočtu ide o odhadovaný počet častíc za týždeň. Vlastný prínos autora spočíva v nefrologickej interpretácii a v kalibrácii miery istoty, nie v nových empirických dátach.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=mikroplasty-tpe-odstranenie-z-krvi-prva-klinicka-studia">Môžeme z tela odstrániť mikroplasty? Čo naznačuje prvá klinická štúdia o terapeutickej plazmovej výmene</a></li>
  <li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek: čo by mal cielene zisťovať nefrológ</a></li>
  <li><a href="article.php?slug=komentar-program-47-kongres-snefs-2026">Nefrológia medzi pokrokom v liečbe a každodennou praxou: komentár k programu 47. kongresu SNEFS</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────
// Avíza sa neposielajú, pokiaľ používateľ v tej istej úlohe výslovne nepožiada.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_mikroplasty_nanoplasty_zdravotnictvo',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() !== 'cli') {
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
} else {
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
}
