<?php
/**
 * add_papilarna-nekroza-napodobnujuca-kamen_article.php
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
    'title'        => 'Papilárna nekróza napodobňujúca kameň: odlúčená papila ako príčina obštrukcie',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'papilarna-nekroza-napodobnujuca-kamen',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Odlúčená nekrotická papila môže spôsobiť koliku, hematúriu a obštrukciu močovodu. Ako nález rozpoznať a prečo má infikovaná obštrukcia prednosť pred definitívnym objasnením.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/papilarna-nekroza-napodobnujuca-kamen.webp" target="_blank" rel="noopener noreferrer"><img src="img/papilarna-nekroza-napodobnujuca-kamen.webp" alt="Poloschematický rez obličkou s poškodenou papilou a odlúčeným tkanivom v kalichu" width="1586" height="992" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna vytvorená s podporou umelej inteligencie: poškodenie obličkovej papily a odlúčenie tkaniva do dutého systému. Nejde o snímku konkrétneho pacienta.</figcaption></figure>
<p>Pri renálnej kolike, hematúrii a obštrukcii močovodu býva prvou pracovnou diagnózou konkrement. Prekážku však môže vytvoriť aj odlúčená nekrotická obličková papila. Takýto nález spája poškodenie obličkového parenchýmu s poruchou odtoku moču a pri pridruženej infekcii vyžaduje rýchle urologické riešenie. Rozpoznanie príčiny obštrukcie má význam aj pre ďalšie vyšetrenie a prevenciu opakovania. [2,3]</p>
<p>Podnetom na tento prehľad je kazuistika <em>Papillary Necrosis Masquerading as a Stone</em>, ktorú Parthiban Palanivel, Deepak Dubey a Mahesha Vankalakunti publikovali online v časopise <em>Kidney International</em> 14. novembra 2026. Overený bibliografický záznam neobsahuje abstrakt a plný text nebol dostupný. Nasledujúci článok preto rozoberá tému na základe ďalších overených zdrojov; nereprodukuje neoverené klinické podrobnosti tejto novej kazuistiky. [1]</p>
<h2>Od poškodenia papily k obštrukcii močovodu</h2>
<p>Papilárna nekróza označuje nekrózu obličkových papíl s viacerými možnými príčinami. Dreň a papily sú náchylné na ischemické poškodenie pre osobitosti svojho cievneho zásobenia a hypertonické prostredie. Medzi známe súvislosti patria diabetes mellitus, pyelonefritída, nadmerné užívanie analgetík, kosáčikovitá choroba a obštrukčná uropatia; opísané sú aj tuberkulóza a trombóza obličkovej žily. Prítomnosť rizikového faktora však diagnózu sama nepotvrdzuje. [2]</p>
<p>Nekrotická papila môže zostať na pôvodnom mieste alebo sa odlúčiť do kalichovo-panvičkového systému. Ak fragment prenikne do močovodu a zablokuje odtok moču, vzniká postrenálna zložka poškodenia obličky. Klinicky sa môže prejaviť kolikou, hematúriou, hydronefrózou alebo infekciou. Obštrukcia tak môže byť príčinou aj následkom papilárnej nekrózy. [2,3]</p>
<p>Pri hodnotení liekovej anamnézy treba cielene zisťovať aj voľnopredajné nesteroidové protizápalové lieky. Leung, Cisu a Grob opísali dospelého pacienta s obojstrannou obštrukciou pri papilárnej nekróze v súvislosti s chronickým užívaním týchto liekov a s rýchlou úpravou funkcie obličiek po zavedení stentov. Ide o doklad možnej komplikácie, nie o odhad jej výskytu ani o dôkaz, že každé akútne poškodenie obličiek pri užívaní týchto liekov predstavuje papilárnu nekrózu. [4]</p>
<h2>Čo môže objasniť zobrazovacie vyšetrenie</h2>
<p>Pri podozrení na konkrement má význam ultrasonografia a podľa klinickej situácie natívna počítačová tomografia (CT). Odporúčania Európskej urologickej asociácie uvádzajú natívnu CT na potvrdenie diagnózy pri akútnej bolesti v boku po úvodnom ultrasonografickom vyšetrení. Horúčka, solitárna oblička alebo neistá diagnóza sú dôvodom na bezodkladné zobrazovacie vyšetrenie. [5]</p>
<p>Pre papilárnu nekrózu môžu byť informatívne najmä vylučovacie fázy kontrastného vyšetrenia. Opísané sú štrbiny v dreni vyplnené kontrastnou látkou, nesýtiace sa tkanivo obkolesené vylúčenou kontrastnou látkou a kalcifikácie. Pri odlúčení papily možno zistiť defekt náplne v panvičke alebo močovode a hydronefrózu. Aj odlúčené tkanivo môže obsahovať kalcifikácie, preto nemožno rozlišovanie zúžiť na jednoduché pravidlo „kalcifikácia znamená kameň“. [2]</p>
<p>Defekt náplne zostáva opisom obrazu, nie histologickou diagnózou. Dagrosa, Ghali a Gormley zdokumentovali odlúčenú papilu v distálnom močovode s okolitou zápalovou reakciou, ktorá pri zobrazovaní napodobnila nádor močového mechúra. Tento prípad rozširuje diferenciálnu diagnostiku, neoprávňuje však považovať podozrivý nádorový nález za neškodný bez ďalšieho objasnenia. [6]</p>
<h2>Endoskopia a histológia pri nejasnom náleze</h2>
<p>V kazuistike autorov Pan, Luo, Zhu a Ye mala pacientka s diabetom, horúčkou, hematúriou a hydronefrózou po úvodnej drenáži na CT urografii viacero defektov náplne. Ureteroskopia ukázala belavé, mäkké, drobivé fragmenty bez zjavného cievneho zásobenia a papily v rôznych štádiách odlučovania. Odstránené tkanivo histologicky zodpovedalo infarktovaným papilám so zápalovým exsudátom. [3]</p>
<p>V tomto prípade endoskopia umožnila priamo posúdiť nález, odstrániť nekrotické tkanivo a získať materiál na histológiu. Z jedného prípadu však nemožno vyvodiť diagnostickú presnosť opísaného vzhľadu ani požiadavku na ureteroskopiu u každého pacienta s podozrením na papilárnu nekrózu. Rozhodnutie sa musí opierať o priebeh ochorenia, prítomnosť obštrukcie a potrebu vylúčiť inú príčinu. [3]</p>
<h2>Infikovaná obštrukcia má prednosť pred definitívnym objasnením</h2>
<p>Pri obštrukcii s infekciou nestačí sústrediť sa na pomenovanie prekážky. Odporúčania EAU pre sepsu pri obštruujúcom konkremente požadujú urgentnú dekompresiu zavedením ureterálneho stentu alebo perkutánnou nefrostómiou, okamžité začatie antibiotickej liečby a kultivačné vyšetrenie moču aj krvi. Definitívne riešenie konkrementu sa odkladá do zvládnutia sepsy. Tieto odporúčania sa týkajú urolitiázy; nie sú samostatným odporúčaním pre papilárnu nekrózu. Potrebu urgentnej drenáže infikovanej obličky pri obštrukcii nekrotickým tkanivom však priamo ilustruje aj kazuistika Pan a spoluautorov. [3,5]</p>
<p>Po obnovení odtoku moču zostáva potrebné objasniť príčinu nekrózy a liečiť pridružené ochorenie. V opísanej kazuistike zahŕňala liečba popri drenáži a antibiotikách aj úpravu kompenzácie diabetu. Pri podozrení na liekové poškodenie treba zhodnotiť konkrétnu expozíciu a ďalšie možné mechanizmy poškodenia obličiek. [3,4]</p>
<h2>Čo možno z dostupných dôkazov vyvodiť</h2>
<p>Kazuistiky preukazujú, že odlúčená papila môže spôsobiť obštrukciu a diagnostické ťažkosti. Neurčujú, ako často sa to deje, ani ktorý diagnostický či liečebný postup je najlepší pre všetkých pacientov. Praktickým dôsledkom je zaradiť papilárnu nekrózu do diferenciálnej diagnostiky najmä vtedy, keď klinický priebeh a zobrazovací nález nezodpovedajú predpokladanému konkrementu. Pri infekcii a obštrukcii sa pritom nesmie oddialiť potrebná drenáž len preto, že pôvod prekážky ešte nie je definitívne objasnený. [2,3,5,6]</p>
<hr>
<p><small><em>Text je určený zdravotníckym pracovníkom. Ide o tematický odborný prehľad, nie o úplné spracovanie neprístupného plného textu kazuistiky z roku 2026. Bibliografické údaje a abstrakty boli overené v PubMed; dostupný bol plný text práce Pan a spoluautorov a príslušné časti odporúčaní EAU 2026. Pri prácach Jung, Leung a Dagrosa bol overený abstrakt. Klinické údaje jednotlivých prípadov sa navzájom nezamieňajú.</em></small></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Parthiban Palanivel, Deepak Dubey, Mahesha Vankalakunti. Papillary Necrosis Masquerading as a Stone. Kidney International. Publikované online 14. 11. 2026. PII S0085-2538(26)00934-8. Ročník a strany zatiaľ nepridelené v overenom zázname. <a href="https://doi.org/10.1016/j.kint.2026.10.027" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.kint.2026.10.027</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/43033965/" target="_blank" rel="noopener noreferrer">PubMed: 43033965</a>. <a href="https://www.kidney-international.org/article/S0085-2538(26)00934-8/fulltext" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Dae Chul Jung, Seung Hyup Kim, Sung Il Jung, Sung Il Hwang, Sun Ho Kim. Renal papillary necrosis: review and comparison of findings at multi-detector row CT and intravenous urography. RadioGraphics. 2006;26(6):1827-1836. <a href="https://doi.org/10.1148/rg.266065039" target="_blank" rel="noopener noreferrer">DOI a vydavateľ: 10.1148/rg.266065039</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/17102053/" target="_blank" rel="noopener noreferrer">PubMed: 17102053</a>.</em></small></li>
<li><small><em>Hong-Hong Pan, Yi-Jia Luo, Qing-Guo Zhu, Lie-Fu Ye. Renal papillary necrosis with urinary tract obstruction: A case report. World Journal of Clinical Cases. 2022;10(16):5400-5405. <a href="https://doi.org/10.12998/wjcc.v10.i16.5400" target="_blank" rel="noopener noreferrer">DOI: 10.12998/wjcc.v10.i16.5400</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35812662/" target="_blank" rel="noopener noreferrer">PubMed: 35812662</a>. <a href="https://www.wjgnet.com/2307-8960/full/v10/i16/5400.htm" target="_blank" rel="noopener noreferrer">Plný text u vydavateľa</a>.</em></small></li>
<li><small><em>Shannon J Leung, Theodore Cisu, Baruch M Grob. Bilateral Ureteral Obstruction Secondary to Papillary Necrosis From Non-Steroidal Anti-Inflammatory Drug Use in an Adult Patient. Cureus. 2021;13(8):e16926. <a href="https://doi.org/10.7759/cureus.16926" target="_blank" rel="noopener noreferrer">DOI a vydavateľ: 10.7759/cureus.16926</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/34513497/" target="_blank" rel="noopener noreferrer">PubMed: 34513497</a>.</em></small></li>
<li><small><em>A. Skolarikos, N.F. Davis, G. Gambaro, R. Geraghty, H. Jung, G.M. Kamphuis, M. Lardas, A. Neisius, A. Petřík, B. Somani, T. Tailly, L. Tzelves. Spolupracovníci odporúčaní: S. Croghan, F. Esperto, R. Lombardo, I. Manolitsis. Guidelines Office: R. Shepherd. EAU Guidelines on Urolithiasis. Aktualizácia marec 2026. EAU Guidelines Office, Arnhem, 2026. Kapitoly 3.3.1 a 3.4.2. <a href="https://uroweb.org/guidelines/urolithiasis/chapter/guidelines" target="_blank" rel="noopener noreferrer">Odporúčania EAU</a>. <a href="https://d56bochluxqnz.cloudfront.net/documents/full-guideline/EAU-Guidelines-on-Urolithiasis-2026.pdf" target="_blank" rel="noopener noreferrer">Úplné PDF a autorský zoznam</a>. Dokument nemá v overenom zdroji pridelené DOI ani PMID.</em></small></li>
<li><small><em>Lawrence M Dagrosa, Fady Ghali, Elizabeth Ann Gormley. Renal Papillary Necrosis Appearing as Bladder Cancer on Imaging. Journal of Endourology Case Reports. 2016;2(1):27-29. <a href="https://doi.org/10.1089/cren.2016.0011" target="_blank" rel="noopener noreferrer">DOI a vydavateľ: 10.1089/cren.2016.0011</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/27579408/" target="_blank" rel="noopener noreferrer">PubMed: 27579408</a>.</em></small></li>
</ol>

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
    'log_prefix' => 'add_papilarna-nekroza-napodobnujuca-kamen_article',
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
