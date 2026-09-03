<?php
/**
 * add_inhibitor-jak1-upadacitinib-tazka-alopecia-areata-faza-3_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: inhibítor JAK1 upadacitinib pri ťažkej alopécii areata
 * (fáza 3, UP-AA1 a UP-AA2). Autor projektu: MUDr. Ľubomír Polaščín.
 * Slovenské spracovanie KONKRÉTNEHO zdroja (Mostaghimi et al., JAMA Dermatol.
 * 2026, PMID 42584887) → autori doplnení do source_authors.php.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Inhibítor JAK1 upadacitinib pri ťažkej alopécii areata: čo prinášajú nové štúdie fázy 3 a ako správne čítať mediálne tvrdenia',
    'slug'         => 'inhibitor-jak1-upadacitinib-tazka-alopecia-areata-faza-3',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V štúdiách UP-AA1 a UP-AA2 dosiahlo SALT ≤ 20 v 24. týždni 45 až 55 % pacientov na upadacitinibe oproti 1,5 až 3,4 % na placebe. Mediálny údaj o úplnej obnove u 23 % súhrn JAMA nepotvrdzuje.',
    'content'      => <<<'HTML'
<p>Alopécia areata je chronické, systémové, imunitne sprostredkované ochorenie s nezjazvujúcou stratou vlasov. Ťažká forma, definovaná skóre Severity of Alopecia Tool (SALT) ≥ 50, výrazne zasahuje vzhľad, kvalitu života a psychické zdravie. Systémových možností je málo: v čase prípravy rukopisu štúdií UP-AA autori uvádzajú, že pre dospievajúcich bol schválený len ritlecitinib, a že časť pacientov na dostupnú liečbu neodpovie. Dve paralelné randomizované štúdie fázy 3, publikované 12. augusta 2026 v <em>JAMA Dermatology</em>, hodnotili perorálny selektívny inhibítor Janusovej kinázy 1 (JAK1) upadacitinib u dospelých a dospievajúcich s ťažkou alopéciou areata.</p>

<p>Spracovanie vychádza zo súhrnu primárnej práce, z otvorených bibliografických záznamov (PubMed, Crossref) a z verejných regulačných textov. Plný text v <em>JAMA Dermatology</em> je za predplatným; čísla, ktoré súhrn neuvádza, sa v tomto článku nedomýšľajú. Práve preto treba oddeliť to, čo štúdia meria ako primárny cieľ, od toho, čo médiá označujú ako „úplnú obnovu vlasov“.</p>

<h2>Čo SALT meria a prečo SALT ≤ 20 nie je SALT 0</h2>

<p>SALT je globálne skóre rozsahu a hustoty straty vlasov na vlasovej pokožke. Štyri pohľady (ľavá a pravá strana po 18 %, temeno 40 %, zátylok 24 %) sa sčítajú do maxima 100. <strong>SALT 0</strong> znamená úplné pokrytie vlasovej pokožky vlasmi. <strong>SALT 100</strong> znamená úplnú stratu. Primárny cieľ UP-AA1 a UP-AA2 nebol SALT 0, ale <strong>SALT ≤ 20 v 24. týždni</strong>, teda najviac 20 % plochy vlasovej pokožky bez vlasov, čo zodpovedá aspoň 80 % pokrytiu. To je klinicky významný prah, nie však „úplná obnova“.</p>

<div class="table-responsive" role="region" aria-label="Význam vybraných prahov skóre SALT" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Prah</th>
      <th scope="col">Význam</th>
      <th scope="col">Úloha v UP-AA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">SALT ≥ 50</th>
      <td>ťažká alopécia areata (vstupný znak)</td>
      <td>kritérium zaradenia</td>
    </tr>
    <tr>
      <th scope="row">SALT ≤ 20</th>
      <td>najviac 20 % straty, teda ≥ 80 % pokrytie vlasovej pokožky</td>
      <td>primárny, multiplicitou kontrolovaný cieľ v 24. týždni</td>
    </tr>
    <tr>
      <th scope="row">SALT ≤ 10</th>
      <td>≥ 90 % pokrytie vlasovej pokožky</td>
      <td>multiplicitou kontrolovaný sekundárny cieľ</td>
    </tr>
    <tr>
      <th scope="row">SALT 0</th>
      <td>úplné pokrytie vlasovej pokožky (kompletné znovurastenie na skalpe)</td>
      <td>multiplicitou kontrolovaný sekundárny cieľ v 24. týždni</td>
    </tr>
  </tbody>
</table>
</div>

<p>Autori v súhrne výslovne zaraďujú SALT 0 medzi sekundárne ciele. To je dôležité: program cieľ hodnotil a podľa otvorených sekundárnych správ ho aj splnil voči placebu, ale <strong>súhrn JAMA percentá ani menovatele pre SALT 0 neuvádza</strong>. Mediálne stotožnenie primárneho výsledku s „úplnou obnovou“ je preto vecne nesprávne.</p>

<h2>Dizajn UP-AA1 a UP-AA2</h2>

<p>Išlo o dva paralelné, identicky koncipované, globálne, randomizované, dvojito zaslepené, placebom kontrolované programy fázy 3. Zaraďovanie prebiehalo od októbra 2023 do júla 2025, analýza dát od júla do októbra 2025. Oba mali 24-týždňové placebom kontrolované obdobie A a 28-týždňové zaslepené predĺženie (obdobie B).</p>

<div class="table-responsive" role="region" aria-label="Základné parametre štúdií UP-AA1 a UP-AA2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj zo súhrnu JAMA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Dizajn</th>
      <td>2 paralelné replikované RCT fázy 3, dvojito zaslepené, placebom kontrolované</td>
    </tr>
    <tr>
      <th scope="row">Populácia</th>
      <td>dospievajúci a dospelí vo veku 12 až &lt; 64 rokov s ťažkou alopéciou areata (SALT ≥ 50)</td>
    </tr>
    <tr>
      <th scope="row">Randomizácia</th>
      <td>2 : 2 : 1 na upadacitinib 15 mg, upadacitinib 30 mg alebo zodpovedajúce placebo, raz denne</td>
    </tr>
    <tr>
      <th scope="row">Rozsah</th>
      <td>1 399 randomizovaných; UP-AA1: 676, UP-AA2: 723</td>
    </tr>
    <tr>
      <th scope="row">Ramená (UP-AA1 / UP-AA2)</th>
      <td>15 mg: 270 / 289; 30 mg: 271 / 289; placebo: 135 / 145</td>
    </tr>
    <tr>
      <th scope="row">Východiskové SALT</th>
      <td>priemer 83,9 (SD 18,9)</td>
    </tr>
    <tr>
      <th scope="row">Vek a pohlavie</th>
      <td>priemer 36 rokov (rozpätie 12–64); 826 žien (59,0 %)</td>
    </tr>
    <tr>
      <th scope="row">Primárny cieľ</th>
      <td>SALT ≤ 20 v 24. týždni (kontrola multiplicity)</td>
    </tr>
    <tr>
      <th scope="row">Registrácia</th>
      <td>ClinicalTrials.gov <a href="https://clinicaltrials.gov/study/NCT06012240" target="_blank" rel="noopener noreferrer">NCT06012240</a></td>
    </tr>
  </tbody>
</table>
</div>

<p>Vekové kritérium v metódach je 12 až &lt; 64 rokov; vo výsledkoch autori uvádzajú rozpätie 12–64. Ide o bežný rozdiel medzi protokolovým zápisom a popisnou štatistikou, nie o druhú populáciu.</p>

<h2>Účinnosť: primárny cieľ v 24. týždni</h2>

<p>Podiel pacientov so SALT ≤ 20 bol v oboch štúdiách významne vyšší pri oboch dávkach upadacitinibu než pri placebe:</p>

<div class="table-responsive" role="region" aria-label="Primárny cieľ SALT najviac 20 v 24. týždni v štúdiách UP-AA1 a UP-AA2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Upadacitinib 15 mg</th>
      <th scope="col">Upadacitinib 30 mg</th>
      <th scope="col">Placebo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">UP-AA1</th>
      <td>45,2 % (122/270)</td>
      <td>55,0 % (149/271)</td>
      <td>1,5 % (2/135)</td>
    </tr>
    <tr>
      <th scope="row">UP-AA2</th>
      <td>44,6 % (129/289)</td>
      <td>54,3 % (157/289)</td>
      <td>3,4 % (5/145)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiel voči placebu je veľký a v oboch nezávislých súboroch takmer zhodný. To je silný argument pre účinok lieku, nie pre tvrdenie, že polovica pacientov má „úplne obnovené vlasy“. Primárny prah pripúšťa až pätinu vlasovej pokožky bez vlasov.</p>

<p>Medzi multiplicitou kontrolované sekundárne ciele patrili okrem SALT 0 a SALT ≤ 10 aj zlepšenie obočia a mihalníc podľa klinických hodnotení, dosiahnutie SALT ≤ 20 už v 4., 8. a 12. týždni, pacientom hlásený globálny dojem zmeny alopécie areata a ochoreniu špecifické ukazovatele kvality života v 24. týždni. Súhrn JAMA konštatuje, že primárny cieľ bol splnený; jednotlivé percentá týchto sekundárnych cieľov v otvorenom abstrakte nie sú.</p>

<h2>Mediálne tvrdenie o „23 %“ a úplnej obnove</h2>

<p>Slovenské spravodajstvo (Nextech, 3. septembra 2026) opísalo upadacitinib ako liek, ktorý „preukázal schopnosť aj úplne obnoviť rast vlasov“, a v kľúčových zisteniach uviedlo, že „až 23 % pacientov s najvyššou dennou dávkou dosiahlo úplnú obnovu strateného vlasového porastu“. Ako zdroj označilo popularizačný text na Interesting Engineering, ktorý však percento 23 neuvádza: hovorí len, že časť účastníkov dosiahla úplné alebo takmer úplné znovurastenie.</p>

<p>Overenie voči primárnemu súhrnu:</p>

<ul>
  <li>SALT 0 <strong>bol</strong> vopred zaradený, multiplicitou kontrolovaný sekundárny cieľ v 24. týždni.</li>
  <li>Otvorené súhrny a tlačové správy výrobcu uvádzajú, že tento cieľ bol splnený pri oboch dávkach voči placebu, bez uverejnenia percenta a menovateľa.</li>
  <li><strong>Číslo 23 % sme v súhrne JAMA, v PubMed zázname, v Crossref abstrakte, v ClinicalTrials.gov ani v otvorených tlačových správach AbbVie k UP-AA nenašli.</strong> Preto ho tu neuverejňujeme.</li>
</ul>

<p>Na verejnej stránke Európskej liekovej agentúry (EMA) k lieku Rinvoq sa pri ťažkej alopécii areata opakujú práve údaje o aspoň 80 % pokrytí vlasovej pokožky (približne 45 až 55 % verzus 1 až 3 % pri placebe). Údaj okolo 23 % sa na tej istej prehľadovej stránke objavuje v <strong>inej indikácii</strong> – pri nonsegmentálnom vitiligu a zlepšení pigmentácie tváre, nie pri SALT 0. To je praktická ukážka, prečo sa čísla z registračného prehľadu s viacerými indikáciami nemajú prenášať medzi diagnózami.</p>

<p>Klinicky zmysluplná formulácia je teda: upadacitinib v 24. týždni výrazne zvýšil podiel pacientov so SALT ≤ 20; úplné pokrytie vlasovej pokožky (SALT 0) bolo hodnotené ako sekundárny cieľ a podľa otvorených zdrojov bolo voči placebu štatisticky významné, ale <strong>presný podiel z publikovaného súhrnu nie je známy</strong>. Hovoriť o „úplnej obnove u 23 %“ ako o overenom výsledku fázy 3 nie je v súlade s dostupným primárnym textom.</p>

<h2>Bezpečnosť</h2>

<p>Bezpečnostný profil oboch dávok bol podľa autorov podobný u dospelých aj dospievajúcich a zhodný s už schválenými indikáciami; nové bezpečnostné signály súhrn neidentifikoval. To nie je tvrdenie o „úplnej bezpečnosti“ ani o tom, že nežiaduce účinky sa redukujú na prechodné akné.</p>

<p>Nežiaduce udalosti vzniknuté počas liečby, ktoré hlásilo viac ako 5 % pacientov v ktoromkoľvek ramene, boli:</p>

<ul>
  <li>infekcia horných dýchacích ciest,</li>
  <li>akné,</li>
  <li>zvýšenie kreatínkinázy v krvi,</li>
  <li>nazofaryngitída.</li>
</ul>

<p>Závažné nežiaduce udalosti vzniknuté počas liečby v oboch štúdiách spolu:</p>

<div class="table-responsive" role="region" aria-label="Závažné nežiaduce udalosti vzniknuté počas liečby v UP-AA1 a UP-AA2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Rameno</th>
      <th scope="col">Počet / podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Upadacitinib 15 mg</th>
      <td>9 (1,6 %)</td>
    </tr>
    <tr>
      <th scope="row">Upadacitinib 30 mg</th>
      <td>13 (2,3 %)</td>
    </tr>
    <tr>
      <th scope="row">Placebo</th>
      <td>1 (0,4 %)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Súhrn neuvádza menovatele týchto percent osobitne; pri spočítaní ramien (559 pri 15 mg, 560 pri 30 mg, 280 pri placebe) sa uverejnené podiely zhodujú. Závažné udalosti teda neboli časté, ale pri aktívnej liečbe ich bolo viac než pri placebe. Inhibítory JAK ako skupina nesú známe riziká závažných infekcií, venózneho tromboembolizmu, závažných kardiovaskulárnych príhod a malignít; EMA pre ne stanovila obmedzenia najmä u osôb vo veku 65 rokov a viac, pri kardiovaskulárnom riziku, u dlhodobých fajčiarov a pri zvýšenom riziku nádoru. Tieto triedové opatrenia platia aj vtedy, keď konkrétna štúdia v alopécii areata nové signály nenašla.</p>

<h2>Regulačný stav: EÚ nie je to isté ako FDA ani ako úhrada na Slovensku</h2>

<p>Upadacitinib (Rinvoq) nie je v týchto štúdiách skúšaný ako nefrologická indikácia. Na stránke EMA je ťažká alopécia areata uvedená medzi terapeutickými indikáciami lieku; prehľad agentúry opisuje práve tieto dve štúdie s 1 399 účastníkmi. Verejné oznámenia výrobcu datujú rozhodnutie Európskej komisie na 29. júl 2026 pre dospelých a dospievajúcich od 12 rokov s ťažkou alopéciou areata, v dávkach 15 mg a 30 mg raz denne. Centrálne povolenie platí v celej EÚ, teda aj na Slovensku; <strong>dostupnosť v ambulancii, úhrada zdravotnou poisťovňou a miesto v terapeutickom poradí sú však samostatné vnútroštátne rozhodnutia</strong> a z tejto štúdie nevyplývajú.</p>

<p>V otvorených zdrojoch sme v čase spracovania (september 2026) nenašli schválenú indikáciu alopécie areata zo strany amerického FDA; liek tam má iné imunologické indikácie. Článok preto nemá implikovať, že ide o celosvetovo rovnako označený liek na alopéciu areata, ani že ho možno na Slovensku predpisovať mimo platného SPC, indikačných obmedzení a pravidiel úhrady.</p>

<h2>Čo z toho plynie pre nefrológa</h2>

<p>Alopécia areata nie je ochorenie obličiek a upadacitinib nie je liekom na chronickú chorobu obličiek (CKD). Systémový inhibítor JAK1 však môže prísť do nefrologickej ambulancie ako komedikácia dermatologického alebo reumatologického pacienta, alebo ako otázka dávkovania pri zníženej glomerulárnej filtrácii.</p>

<ul>
  <li><strong>Infekcie.</strong> Najčastejšie hlásené udalosti v UP-AA zahŕňali infekcie dýchacích ciest. Pacient s CKD má vyššie infekčné riziko; febrilná infekcia navyše zvyšuje riziko dehydratácie a akútneho zhoršenia funkcie obličiek.</li>
  <li><strong>Laboratórne odchýlky.</strong> Zvýšenie kreatínkinázy patrilo medzi časté nálezy. Interpretácia svalových enzýmov a krvného obrazu patrí k bežnému monitorovaniu podľa SPC, nie k „kozmetickej“ nežiaducej udalosti.</li>
  <li><strong>Dávkovanie pri CKD.</strong> Podľa otvoreného európskeho plánu riadenia rizík a SPC nie je pri miernej a stredne ťažkej poruche funkcie obličiek úprava dávky potrebná. Pri ťažkej poruche (eGFR 15 až &lt; 30 ml/min/1,73 m²) je pre alopéciu areata v týchto dokumentoch uvedená odporúčaná dávka 15 mg raz denne. Použitie pri terminálnom zlyhaní obličiek (eGFR &lt; 15 ml/min/1,73 m²) nebolo študované a neodporúča sa. Presné dávky treba vždy overiť v aktuálnom SPC a v miestnych pravidlách; <strong>tento článok dávkovanie neskúša ani nenahrádza SPC</strong>.</li>
  <li><strong>Interakcie.</strong> Upadacitinib sa metabolizuje cez CYP3A4; silné inhibítory a induktory menia expozíciu. To je relevantné pri bežnej polyfarmácii pacienta s CKD.</li>
</ul>

<p>Rozhodnutie o nasadení pri ťažkej alopécii areata patrí dermatológovi skúsenému v systémovej imunomodulácii, s očkovaním, skríningom infekcií a laboratórnym dohľadom podľa SPC. Nefrológ do tohto rozhodnutia vstupuje predovšetkým hodnotením eGFR, infekčného rizika, hydratácie a liekových interakcií.</p>

<h2>Limity</h2>

<ul>
  <li>Primárny horizont je 24 týždňov; 28-týždňové predĺženie súhrn číselne nerozoberá a dlhodobá udržateľnosť aj bezpečnosť sa ešte skúmajú.</li>
  <li>Súhrn neuvádza percentá SALT 0, SALT ≤ 10, obočia, mihalníc ani kvality života. Tieto ciele preto nemožno z otvoreného textu kvantifikovať.</li>
  <li>Priemerné východiskové SALT 83,9 opisuje ťažko postihnutú populáciu; výsledky sa nedajú automaticky preniesť na ľahšiu chorobu.</li>
  <li>Horná veková hranica protokolu vylučuje starších pacientov, teda práve skupinu, pre ktorú EMA pri inhibítoroch JAK stanovila prísnejšie podmienky použitia.</li>
  <li>Štúdie nesledovali obličkové cieľové ukazovatele.</li>
</ul>

<h2>Záver</h2>

<p>Upadacitinib 15 mg a 30 mg raz denne v dvoch veľkých štúdiách fázy 3 výrazne zvýšil podiel dospelých a dospievajúcich s ťažkou alopéciou areata, ktorí v 24. týždni dosiahli SALT ≤ 20, oproti takmer nulovej odpovedi pri placebe. Bezpečnostný obraz bol v súlade s triedou a so schválenými indikáciami, so závažnými udalosťami v ráde jednotiek percent. Primárnym cieľom nebola úplná obnova vlasov. Mediálne číslo 23 % pre SALT 0 sa v otvorenom primárnom súhrne nepotvrdilo, a preto sa tu neuvádza. V EÚ je ťažká alopécia areata medzi indikáciami Rinvoqu; to neznamená automatickú úhradu ani to, že ide o nefrologický liek. Pri pacientovi s CKD treba dávku, infekčné riziko a interakcie riadiť podľa aktuálneho SPC, nie podľa spravodajského titulku.</p>

<hr>

<p><em><strong>Zdroj:</strong> Mostaghimi A, Gooderham MJ, Lynde C, et al. Upadacitinib for Severe Alopecia Areata in Adults and Adolescents: Two Phase 3 UP-AA Randomized Clinical Trials. <em>JAMA Dermatol</em>. Published online August 12, 2026. doi:<a href="https://doi.org/10.1001/jamadermatol.2026.2853" target="_blank" rel="noopener noreferrer">10.1001/jamadermatol.2026.2853</a> (PMID <a href="https://pubmed.ncbi.nlm.nih.gov/42584887/" target="_blank" rel="noopener noreferrer">42584887</a>; ClinicalTrials.gov NCT06012240). Mediálny príklad nesprávneho stotožnenia SALT ≤ 20 s úplnou obnovou: Nextech, 3. 9. 2026, <a href="https://www.nextech.sk/a/Liek-na-reumu-preukazal-schopnost-aj-uplne-obnovit-rast-vlasov" target="_blank" rel="noopener noreferrer">Liek na reumu preukázal schopnosť aj úplne obnoviť rast vlasov</a>. Regulačný prehľad: <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/rinvoq" target="_blank" rel="noopener noreferrer">EMA EPAR Rinvoq</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_inhibitor-jak1-upadacitinib-tazka-alopecia-areata-faza-3_article',
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
