<?php
/**
 * add_TEMPLATE_article.php
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
    'title'        => 'Rituximab pri IgA nefropatii: štúdia RITA nepotvrdila prínos k podpornej liečbe',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'rituximab-iga-nefropatia-rita',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Rituximab v štúdii RITA nepriniesol dodatočné zníženie proteinúrie ani preukázanú ochranu filtrácie. Výsledok spresňuje, čo pri IgA nefropatii možno očakávať od zásahu proti CD20.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/rituximab-iga-nefropatia-rita.webp" target="_blank" rel="noopener noreferrer"><img src="img/rituximab-iga-nefropatia-rita.webp" alt="Konceptuálna ilustrácia glomerulu a rozdielnych buniek imunitného systému" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, histologický preparát ani zobrazenie preukázaného účinku lieku.</figcaption></figure>
<p>Pridanie rituximabu k optimalizovanej inhibícii renínovo-angiotenzínového systému v štúdii RITA nepreukázalo dodatočný účinok na proteinúriu ani zachovanie funkcie obličiek pri IgA nefropatii. Výsledok je významný aj v období rozvoja nových imunologicky zameraných liekov: samotné zapojenie B-lymfocytov do patogenézy ešte nezaručuje, že ich deplécia protilátkou proti CD20 ovplyvní klinický priebeh choroby. [1]</p>
<h2>Čo skúmala RITA</h2>
<p>Multicentrická randomizovaná štúdia zaradila 106 dospelých v desiatich čínskych centrách. Všetci mali biopticky potvrdenú IgA nefropatiu, proteinúriu nad 1 g za 24 hodín napriek najmenej trom mesiacom inhibície renínovo-angiotenzínového systému a krvný tlak pod 130/80 mmHg. Po 53 účastníkov bolo pridelených k rituximabu spolu s touto liečbou alebo k samotnej inhibícii systému. Kontrolná skupina nedostávala placebo. [1]</p>
<p>Primárnym ukazovateľom bola zmena 24-hodinovej proteinúrie po 12 mesiacoch. Sekundárne sa hodnotili aj eGFR, koncentrácia IgA1 s deficitom galaktózy (Gd-IgA1), podiel pacientov s poklesom proteinúrie aspoň o polovicu a závažné obličkové udalosti. Explorácia zahŕňala údaje do 24. mesiaca. [1]</p>
<h2>Proteinúria: bez dodatočného účinku</h2>
<p>Upravený pomer geometrických priemerov pre primárne hodnotenie proteinúrie bol 1,05, s 95 % intervalom spoľahlivosti od 0,80 do 1,36. Medián zmeny proteinúrie dosiahol −0,21 g/deň pri rituximabe a −0,26 g/deň v kontrolnej skupine. Pokles proteinúrie najmenej o 50 % sa zaznamenal u 15,1 % oproti 20,8 % účastníkov. Výsledky teda nepreukázali dodatočný antiproteinurický prínos rituximabu. [1]</p>
<p>Upravený priemerný rozdiel v eGFR bol 3,80 ml/min/1,73 m², s 95 % intervalom od −0,47 do 8,06. Interval zahŕňa nulu; nejde o preukázané zlepšenie filtrácie. Rovnako sa nepreukázal rozdiel v Gd-IgA1: upravený pomer geometrických priemerov bol 1,04, s intervalom od 0,87 do 1,24. Analýzy zahŕňajúce údaje do 24 mesiacov boli s hlavným výsledkom konzistentné. [1]</p>
<p>Počas 12-mesačného obdobia sa nevyskytol pokles eGFR najmenej o 50 %, zdvojnásobenie kreatinínu ani terminálne zlyhanie obličiek. Nulový počet týchto udalostí v malom a krátko sledovanom súbore však neumožňuje posúdiť dlhodobú ochranu pred zlyhaním obličiek. Podobný výskyt nežiaducich udalostí medzi skupinami zase nie je dôkazom bezpečnostnej rovnocennosti. [1]</p>
<h2>Výsledok nadväzuje na staršiu randomizovanú štúdiu</h2>
<p>Lafayette a spoluautori v staršej otvorenej randomizovanej štúdii sledovali 34 dospelých s biopticky potvrdenou IgA nefropatiou, proteinúriou a zníženou funkciou obličiek. Rituximab účinne znížil počet B-lymfocytov, ale počas jedného roka nezlepšil proteinúriu ani funkciu obličiek oproti podpornej liečbe. Neznížil ani koncentrácie Gd-IgA1 a protilátok proti Gd-IgA1. RITA preto neprináša izolovaný negatívny nález, ale rozširuje predchádzajúcu randomizovanú skúsenosť. [2]</p>
<p>Biologická interpretácia je užšia než tvrdenie, že imunologická liečba pri IgA nefropatii nefunguje. Deplécia buniek nesúcich CD20 nemusí dostatočne zasiahnuť bunkové zdroje patogénneho IgA1 a príslušných autoprotilátok. Zachovanie ich koncentrácií je s týmto vysvetlením zlučiteľné. Samotná RITA však priamo nedokazuje, ktorá bunková populácia udržiava chorobu u konkrétneho pacienta. Zistenie preto podporuje mechanistickú hypotézu, nie definitívne určenie zdroja patogénnych protilátok. [1, 2]</p>
<h2>Prečo nemožno ignorovať odlišné klinické fenotypy</h2>
<p>Novšia retrospektívna štúdia pri IgA nefropatii s polmesiačikmi porovnávala 16 pacientov liečených rituximabom a kortikosteroidmi s ôsmimi pacientmi liečenými kortikosteroidným režimom. Opísala väčší pokles proteinúrie pri kombinácii s rituximabom. Malý nerandomizovaný súbor, odlišný histologický a klinický fenotyp a súbežné kortikosteroidy však nedovoľujú pripísať rozdiel samotnému rituximabu ani ním vyvrátiť výsledok RITA. [3]</p>
<p>Táto odlišnosť zároveň bráni opačnému zjednodušeniu: negatívnu RITA nemožno automaticky preniesť na každý rýchlo progredujúci či inak výnimočný priebeh IgA nefropatie. Údaje treba vzťahovať na populáciu a porovnanie, ktoré štúdia skutočne skúmala. Náznaky z malých kohort sú dôvodom na ďalší výskum, nie rovnocennou náhradou randomizovaného dôkazu.</p>
<h2>Dôsledok pre prax a limity</h2>
<p>Pre dospelých s pretrvávajúcou proteinúriou napriek stabilnej inhibícii renínovo-angiotenzínového systému RITA neposkytuje oporu pre rutinné pridanie rituximabu s cieľom znížiť proteinúriu alebo zachovať eGFR. Nejde o dôkaz rovnocennosti stratégií ani o vyhodnotenie všetkých možných imunologických zásahov. Význam výsledku je v konkrétnom testovanom mechanizme a populácii. [1, 2]</p>
<p>Prenositeľnosť obmedzuje výlučne ázijská populácia, veľkosť súboru a relatívne krátke sledovanie. Pri spracovaní boli overené úplné abstrakty a bibliografické záznamy troch citovaných prác. Plný text RITA a jej suplement neboli dostupné na kontrolu; preto sa neuvádzajú neoverené dávkovacie schémy ani podrobnosti súbežnej liečby.</p>

<hr>
<p><em>Odborný text je určený zdravotníckym pracovníkom. Klinické rozhodnutie vyžaduje posúdenie konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Yan Ouyang, Hong Ren, Weiming Wang, Na Liu, Beiyan Bao, Hua Li, Xiaoling Xiong, Jian Li, Duolao Wang, Qinjie Weng, Chaohui Wang, Jingyuan Xie, Nan Chen. Rituximab in IgA Nephropathy: The RITA Multicenter Randomized Trial. Am J Kidney Dis. 2026. Elektronická publikácia pred zaradením do čísla. <a href="https://doi.org/10.1053/j.ajkd.2026.07.017" target="_blank" rel="noopener noreferrer">DOI 10.1053/j.ajkd.2026.07.017</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42998785/" target="_blank" rel="noopener noreferrer">PubMed 42998785</a></em></small></li>
<li><small><em>Richard A Lafayette, Pietro A Canetta, Brad H Rovin, Gerald B Appel, Jan Novak, Karl A Nath, Sanjeev Sethi, James A Tumlin, Kshama Mehta, Marie Hogan, Stephen Erickson, Bruce A Julian, Nelson Leung, Felicity T Enders, Rhubell Brown, Barbora Knoppova, Stacy Hall, Fernando C Fervenza. A Randomized, Controlled Trial of Rituximab in IgA Nephropathy with Proteinuria and Renal Dysfunction. J Am Soc Nephrol. 2017;28(4):1306 až 1313. <a href="https://doi.org/10.1681/ASN.2016060640" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.2016060640</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/27821627/" target="_blank" rel="noopener noreferrer">PubMed 27821627</a></em></small></li>
<li><small><em>Gian Marco Berti, Francesco Tondolo, Anna Iandolo, Gisella Vischini, Daniele Vetrano, Edoardo Tringali, Olga Baraldi, Benedetta Fabbrizio, Stefano Chillotti, Gianandrea Pasquinelli, Gaetano La Manna, Federica Maritati. Rituximab-Based Therapy in IgA Nephropathy With Crescents: A Comparative Study. Clin Ther. 2026. Elektronická publikácia pred zaradením do čísla. <a href="https://doi.org/10.1016/j.clinthera.2026.08.009" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.clinthera.2026.08.009</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42697788/" target="_blank" rel="noopener noreferrer">PubMed 42697788</a></em></small></li>
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
    'log_prefix' => 'add_rituximab-iga-nefropatia-rita_article',
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
