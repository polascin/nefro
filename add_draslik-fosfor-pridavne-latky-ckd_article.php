<?php
/**
 * add_draslik-fosfor-pridavne-latky-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * ŠABLÓNA pre vkladanie nového článku.
 * Postup:
 *   1. Skopíruj tento súbor ako  add_<slug>_article.php
 *   2. Vyplň všetky sekcie označené  ← VYPLNIŤ
 *   3. git add + git commit  →  deploy hook automaticky nahrá súbor na server
 *   4. Spusti cez SSH:
 *      ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *          uid58858@shell.r1.websupport.sk \
 *          "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * PRAVIDLÁ PRE OBSAH:
 *   • title    – čistý text, bez HTML; zobrazí sa ako <h1> na stránke článku
 *   • slug     – len [a-z0-9-], max 80 znakov; musí byť unikátny v DB
 *                Diakritika → ASCII: á→a, č→c, š→s, ž→z, ľ→l, ô→o, ú→u …
 *   • excerpt  – 1–2 vety (max ~300 znakov), čistý text; zobrazuje sa v zozname
 *   • content  – HTML; NESMIE začínať <h2> zhodným s titulom (duplikát)
 *                Nadpisy sekcií → <h2>…</h2>
 *                Zoznam        → <ul>/<ol> + <li>
 *                Tučné         → <strong>, kurzíva → <em>
 *                Externé linky → <a href="…" target="_blank" rel="noopener noreferrer">
 *                Tabuľka       → <th scope="col"> v <thead>, <th scope="row">
 *                                v <tbody>; CELÚ <table> obaľ do
 *                                <div class="table-responsive" role="region"
 *                                     aria-label="…" tabindex="0">
 *                                (bez wrapperu široká tabuľka rozbije mobil)
 *                Záver (zdroj) → <hr><p><em>Zdroj: …</em></p>
 *   • is_top   – 0 = bežný článok, 1 = odporúčaný (zobrazí sa vo featured sekcii)
 *   • author   – autor projektu (predvolene 'MUDr. Ľubomír Polaščín').
 *
 *   ⚠ PÔVODNÍ AUTORI ZDROJA (widget „Zúčastnení autori“ + filter ?autor=):
 *      Pole `author` je VŽDY len autor projektu, preto sa pôvodní autori
 *      zdrojového článku k autorom NEpridajú automaticky. Ak je článok
 *      slovenským spracovaním KONKRÉTNEHO zdrojového článku, doplň jeho
 *      pôvodných autorov do  source_authors.php  (mapa slug → [mená]) — tá je
 *      autoritatívna a zobrazí ich vo widgete aj vo filtri.
 *      • Mená zháňaj len z otvorených bibliografických API (Crossref/PubMed/
 *        eutils) alebo verejných tlačových správ — NIE obchádzaním paywallu.
 *      • Notácia „Meno Priezvisko“ (kvôli agregácii naprieč článkami).
 *      • Bez mapy funguje len obmedzený fallback: prvý autor z „Zdroj:“ v obsahu
 *        (značka musí byť presne „Zdroj:“, nie zoznam „Zdroje“).
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
    'title'        => 'Draslík a fosfor v prídavných látkach: ako upraviť stravu pri CKD bez zbytočných zákazov',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'draslik-fosfor-pridavne-latky-ckd',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Prídavné látky môžu zvýšiť príjem draslíka a fosforu. Ako vyberať potraviny podľa individuálneho rizika a prečo sú pevné percentá vstrebávania draslíka sporné.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/draslik-fosfor-pridavne-latky-ckd.webp" target="_blank" rel="noopener noreferrer"><img src="img/draslik-fosfor-pridavne-latky-ckd.webp" alt="Symbolická ilustrácia obličky, balenej potraviny a prídavných minerálnych látok" width="1586" height="992" loading="lazy" decoding="async"></a><figcaption>Symbolická ilustrácia vytvorená s podporou umelej inteligencie. Zobrazuje súvislosť medzi zložením potravín a starostlivosťou o obličky; nejde o konkrétny výrobok ani o znázornenie mechanizmu poškodenia.</figcaption></figure>
<p>Pri úprave stravy človeka s chronickou chorobou obličiek (CKD) nestačí sledovať prirodzený obsah draslíka a fosforu v potravinách. Významným, pritom ťažko vyčísliteľným zdrojom môžu byť prídavné látky používané pri výrobe. Cielená výmena niektorých výrobkov môže znížiť minerálnu záťaž bez toho, aby sa jedálny lístok zbytočne ochudobnil o bielkoviny, vlákninu a energiu. Draslík a fosfor však vyžadujú odlišné klinické uvažovanie. [2,3]</p>
<p>Podnetom je prehľad Annabel Biruete a Csabu P. Kovesdyho <em>Potassium and Phosphorus Food Additives in Chronic Kidney Disease: An Emerging Nutritional Challenge</em>, publikovaný online 13. novembra 2026. Jeho bibliografické údaje sú overené, ale dostupný záznam neobsahuje abstrakt a plný text nebol prístupný. Tento článok preto predstavuje samostatný tematický prehľad založený na ďalších overených zdrojoch, najmä na usmernení Americkej nefrologickej spoločnosti (ASN), odporúčaniach KDIGO a klinických štúdiách. Novému prehľadu nepripisuje neoverené závery. [1]</p>
<h2>Prídavná látka nie je jednotná kategória rizika</h2>
<p>Zlúčeniny draslíka a fosforu sa používajú na úpravu chuti, kyslosti, konzistencie, väzby vody a trvanlivosti. Niektoré nahrádzajú sodné soli, iné slúžia ako emulgátory, stabilizátory alebo kypriace látky. Fosforečnany draselné dodávajú oba prvky súčasne. Ich príspevok závisí od konkrétnej zlúčeniny, použitého množstva, veľkosti porcie a frekvencie konzumácie. Samotná prítomnosť názvu v zozname zložiek preto nevyjadruje prijatú dávku. [2,6]</p>
<p>ASN upozorňuje najmä na chlorid draselný, fosforečnany draselné, citráty draselné a laktát draselný. Naopak, sorban draselný a acesulfám K podľa dostupných údajov zvyčajne prispievajú k celkovému obsahu draslíka vo výrobku málo. Plošné odmietanie každej zložky s označením „draselný“ by preto mohlo viesť k neprimeraným obmedzeniam. Označenie výrobku ako výrobku so zníženým obsahom sodíka zároveň nevylučuje významný prídavok draslíka. [2]</p>
<h2>Draslík: rozhoduje riziko hyperkaliémie</h2>
<p>Koncentrácia draslíka v sére nie je jednoduchým odrazom jeho denného príjmu. Ovplyvňujú ju vylučovacia schopnosť obličiek, presuny medzi bunkami a extracelulárnym priestorom, acidobázický stav, glykémia, črevná pasáž a lieky. Pri hodnotení hyperkaliémie treba súčasne posúdiť zápchu, metabolickú acidózu, nekontrolovanú hyperglykémiu aj liečbu ovplyvňujúcu vylučovanie draslíka. Nutričná intervencia je súčasťou tohto postupu, nie jeho náhradou. [2,3]</p>
<p>KDIGO 2024 v praktickom bode 3.11.5.2 odporúča pacientom s CKD G3 až G5, ktorí majú hyperkaliémiu v anamnéze alebo prechádzajú obdobím zvýšeného rizika, obmedziť potraviny bohaté na biologicky dostupný draslík, napríklad niektoré priemyselne spracované výrobky. Ide o individualizované usmernenie. Neznamená automatický zákaz ovocia, zeleniny a strukovín u každého pacienta s CKD. KDIGO súčasne podporuje pestrú stravu s vyšším podielom rastlinných potravín a menším zastúpením vysoko priemyselne spracovaných potravín. [3]</p>
<p>Osobitnú pozornosť si zaslúžia náhrady kuchynskej soli obsahujúce chlorid draselný. Ich kardiovaskulárny prínos v skúmaných populáciách nemožno bez výhrad preniesť na pacientov s pokročilou CKD a vysokým rizikom hyperkaliémie, ktorí bývali z príslušných štúdií vylúčení. Pri normokaliémii a nízkom riziku má podľa ASN prednosť celková kvalita stravy; pri hyperkaliémii alebo zvýšenom riziku je namieste podrobnejšia kontrola konkrétnych výrobkov a porcií. [2]</p>
<h2>Percentá vstrebávania draslíka si vyžadujú opatrnosť</h2>
<p>V literatúre sa opakujú odhady nižšej biologickej dostupnosti draslíka z rastlinných potravín a takmer úplnej dostupnosti z prídavných látok. Už ASN upozorňuje, že rozdiely medzi zdrojmi sú lepšie doložené pri fosfore než pri draslíku. Nový prehľad Kelly Picard, Melanie Griffiths a Susan Martin túto neistotu ďalej spresňuje. [2,5]</p>
<p>Autorky zahrnuli 26 prác a poukázali na nedostatočnosť odhadu vstrebávania podľa 24-hodinového vylučovania draslíka močom. Podľa abstraktu bilančné štúdie naznačovali biologickú dostupnosť približne 88 až 94 % bez ohľadu na zdroj. Často uvádzané hodnoty 50 až 60 % pre ovocie a zeleninu, 70 až 90 % pre živočíšne potraviny a 100 % pre prídavné látky preto nemožno prezentovať ako spoľahlivo preukázané univerzálne konštanty. Ani nový interval však nie je presným koeficientom pre každého pacienta s CKD. [5]</p>
<p>Táto metodologická výhrada neruší potrebu obmedziť vysokú dávku draslíka u rizikového pacienta. Mení zdôvodnenie: dôležitá je skutočná dávka, skladba celého jedla, reakcia organizmu a schopnosť draslík vylúčiť. Tabuľkové percento samo osebe bezpečnosť porcie neurčuje. [2,3,5]</p>
<h2>Fosfor: menej prídavných fosforečnanov bez straty výživovej hodnoty</h2>
<p>Pri fosfore je rozdiel medzi chemickými formami a potravinovými zdrojmi lepšie podložený. Anorganické fosforečnany používané ako prídavné látky bývajú dostupnejšie na vstrebávanie než fosfor prirodzene viazaný v potravinách. Pri výbere stravy preto záleží aj na pôvode fosforu, nielen na jeho celkovom tabuľkovom obsahu. Cielené nahradenie výrobku s prídavnými fosforečnanmi podobným výrobkom bez nich môže zachovať príjem bielkovín a energie. [2]</p>
<p>Priamy klinický podklad poskytuje klastrovo randomizovaná štúdia Catherine Sullivan a spoluautorov v 14 hemodialyzačných strediskách. Zahŕňala 279 pacientov so vstupnou koncentráciou fosforu v sére nad 5,5 mg/dl. Edukáciu o vyhýbaní sa prídavným fosforečnanom dostalo 145 pacientov, 134 pokračovalo v bežnej starostlivosti. Po troch mesiacoch bol pokles koncentrácie v intervenčnej skupine o 0,6 mg/dl väčší; rozdiel zmien predstavoval −0,6 mg/dl s 95 % intervalom spoľahlivosti od −1,0 do −0,1 mg/dl. Ide približne o 0,19 mmol/l, po prepočte koeficientom 0,323. [4]</p>
<p>Výsledok podporuje praktický význam edukácie, ale týka sa náhradného laboratórneho ukazovateľa u hemodialyzovaných pacientov s hyperfosfatémiou. Nedokazuje zníženie mortality ani rovnaký účinok v skorých štádiách CKD. Normálna koncentrácia fosforu v sére navyše nevylučuje zvýšenú záťaž, pretože sa na jej udržaní podieľajú kompenzačné hormonálne mechanizmy. To je dôvod na hodnotenie celého klinického kontextu, nie na neprimeranú reštrikciu u každého pacienta. [2,4]</p>
<h2>Ako viesť rozhovor o konkrétnych potravinách</h2>
<p>Užitočným začiatkom je krátky záznam obvyklej stravy doplnený fotografiami obalov. Zoznam zložiek môže odhaliť chlorid draselný, fosforečnany či iné relevantné zlúčeniny, zvyčajne však neumožní vypočítať množstvo prvku pridaného pri výrobe. Americké údaje o označovaní potravín nemožno automaticky prenášať na slovenské obaly. Rozhoduje zloženie konkrétneho výrobku a dostupné údaje výrobcu. [2,6]</p>
<p>Pri fosfore je vhodné začať často konzumovanými výrobkami s jasne uvedenými fosforečnanmi: niektorými mäsovými výrobkami, tavenými syrmi, hotovými jedlami, pekárenskými výrobkami a nápojmi. Nie každý výrobok v danej skupine ich obsahuje. Ani označenie „rastlinný“ nezaručuje neprítomnosť prídavných látok. Hľadanie časti slova „fosf“ je praktickou pomôckou, ale nezachytí všetky zlúčeniny obsahujúce fosfor. [2,6]</p>
<p>Nefrológ a nutričný terapeut by mali vybrať niekoľko uskutočniteľných zmien podľa laboratórnych výsledkov, nutričného stavu, finančných možností a návykov pacienta. Zmysluplná intervencia zachová dostatok energie a primeraný príjem bielkovín, sleduje vývoj kaliémie a parametrov minerálového metabolizmu a podľa výsledkov sa upraví. U transplantovaných pacientov treba osobitne zohľadniť lieky zvyšujúce kaliémiu a možnú hypofosfatémiu; rovnaká reštrikcia pre všetkých by bola nesprávna. [2,3]</p>
<h2>Hranice dôkazov a klinický význam</h2>
<p>Usmernenie ASN kombinuje publikované dôkazy s odborným konsenzom. Údaje o zložení výrobkov sú neúplné, medzi trhmi sa líšia a pri draslíku zostáva neisté aj meranie biologickej dostupnosti. Najpresvedčivejší praktický postup preto spája kontrolu konkrétneho jedálneho lístka s individuálnym rizikom a následným laboratórnym sledovaním. Obmedzovanie prídavných látok má zlepšiť bezpečnosť a kvalitu stravy, nie vytvoriť ďalší všeobecný zoznam zakázaných potravín. [2,3,5]</p>
<hr><p><small>Text je určený zdravotníckym pracovníkom. Výživové odporúčania treba prispôsobiť funkcii obličiek, liečbe, laboratórnym výsledkom a nutričnému stavu konkrétneho pacienta.</small></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Annabel Biruete, Csaba P Kovesdy. Potassium and Phosphorus Food Additives in Chronic Kidney Disease: An Emerging Nutritional Challenge. Seminars in nephrology. 2026 Nov 13; článok 151753. <a href="https://doi.org/10.1016/j.semnephrol.2026.151753" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43026094/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://www.sciencedirect.com/science/article/pii/S0270929526000720" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Annabel Biruete, Cheryl Anderson, Amélie Bernier-Jean, Catherine M Clase, Deborah Clegg, Deidra C Crews, Michelle Denburg, Kathleen M Hill Gallant, Orlando M Gutierrez, Joachim H Ix, Melody Kienholz, Kelly Lambert, Soo-Yeun Lee, Scott E Liebman, Christina L Nelms, Biff F Palmer, Farzana Perwad, Kelly Picard, David E St-Jules, Andrew S Terker, Jaime Uribarri, Csaba P Kovesdy, ASN Kidney Health Guidance Workgroup on Food Additives. ASN Kidney Health Guidance on Potassium and Phosphorus Food Additives. Journal of the American Society of Nephrology : JASN. 2025 Nov 01;36(11):2244-2258. <a href="https://doi.org/10.1681/ASN.0000000873" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40965988/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12591684/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney international. 2024 Apr;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></li>
<li><small><em>Catherine Sullivan, Srilekha S Sayre, Janeen B Leon, Rhoderick Machekano, Thomas E Love, David Porter, Marquisha Marbury, Ashwini R Sehgal. Effect of food additives on hyperphosphatemia among patients with end-stage renal disease: a randomized controlled trial. JAMA. 2009 Feb 11;301(6):629-35. <a href="https://doi.org/10.1001/jama.2009.96" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/19211470/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kelly Picard, Melanie Griffiths, Susan Martin. Potassium Bioavailability: Re-examining the Evidence. Journal of renal nutrition : the official journal of the Council on Renal Nutrition of the National Kidney Foundation. 2026 Nov 02; online pred zaradením do čísla. <a href="https://doi.org/10.1053/j.jrn.2026.10.014" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42971336/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Cordelia Running, Reina L Mauer, Lurvin I Ventura Caballero, Lisa J Mauer. Potassium and Phosphorus Food Additives: Why and Where to Find Them in Foods. Seminars in nephrology. 2026 Oct 08; článok 151730. <a href="https://doi.org/10.1016/j.semnephrol.2026.151730" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42850175/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>
<p><small><em>Rozsah overenia: pri východiskovom prehľade [1] boli dostupné bibliografické údaje, nie abstrakt ani plný text. Usmernenie ASN [2] a odporúčania KDIGO [3] boli overené v plnom texte; práce [4], [5] a [6] v rozsahu dostupných abstraktov a bibliografických záznamov. Klinická syntéza a slovenské spracovanie predstavujú vlastný redakčný prínos.</em></small></p>
<h3>Súvisiace články</h3>
<ul><li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri CKD: edukovať, nie strašiť</a></li><li><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Hyperkaliémia, blokáda RAAS a viazače draslíka</a></li></ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_draslik-fosfor-pridavne-latky-ckd_article',
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
