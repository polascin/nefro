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
    'title'        => 'Finerenón pri FSGS: pomalší pokles filtrácie v podskupine FIND-CKD',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'finerenon-fsgs-find-ckd-podskupina',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Vopred špecifikovaná analýza FIND-CKD ukazuje pomalší pokles eGFR a nižšiu proteinúriu pri FSGS. Zníženie rizika zlyhania obličiek však samostatne nepotvrdila.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/finerenon-fsgs-find-ckd-podskupina.webp" target="_blank" rel="noopener noreferrer"><img src="img/finerenon-fsgs-find-ckd-podskupina.webp" alt="Poloschematická oblička so zväčšeným glomerulom a ohraničenou oblasťou sklerózy" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, histologický preparát ani zobrazenie preukázaného účinku lieku.</figcaption></figure>
<p>Finerenón vo vopred špecifikovanej podskupine pacientov s fokálnou segmentálnou glomerulosklerózou (FSGS) spomalil pokles odhadovanej glomerulovej filtrácie (eGFR) a znížil proteinúriu. Rozdiel v celkovom sklone eGFR oproti placebu dosiahol 1,3 ml/min/1,73 m² za rok. Ide o povzbudivý výsledok, jeho klinický dosah však treba ohraničiť: analýza samostatne nepreukázala zníženie rizika kombinovaného obličkového ukazovateľa a nepredstavuje novú registračnú indikáciu. [1, 3]</p>
<h2>Koho analýza zahŕňala</h2>
<p>FIND-CKD bola randomizovaná štúdia u 1 584 dospelých s chronickou chorobou obličiek (CKD) bez diabetu, liečených stabilnou inhibíciou renínovo-angiotenzínového systému. Účastníci dostávali finerenón v dávke 10 alebo 20 mg denne alebo placebo. Vstupné kritériá kombinovali eGFR a pomer albumínu ku kreatinínu v moči (UACR): pri eGFR od 25 do menej než 60 ml/min/1,73 m² bol prípustný UACR od 200 do menej než 500 mg/g, pri eGFR od 25 do menej než 90 ml/min/1,73 m² UACR od 500 do 3 500 mg/g. Dávkovanie opisuje protokol, nie odporúčanie pre liečbu FSGS. [1]</p>
<p>Podskupina FSGS mala 215 účastníkov: 108 s primárnou a 107 so sekundárnou formou. Priemerná vstupná eGFR bola 45 ml/min/1,73 m², smerodajná odchýlka 17. Medián pomeru celkových bielkovín ku kreatinínu v moči (UPCR) bol 1 427 mg/g; prvý a tretí kvartil dosahovali 947 a 2 120 mg/g. Bioptické potvrdenie diagnózy malo 167 účastníkov, teda 78 %. Albuminúria použitá pri zaradení a proteinúria hodnotená pomocou UPCR preto nie sú zameniteľné údaje. [1]</p>
<h2>Filtrácia a proteinúria: dva priaznivé výsledky</h2>
<p>Primárnym ukazovateľom celej štúdie bol celkový sklon eGFR od začiatku do 32. mesiaca. V podskupine FSGS bol rozdiel medzi finerenónom a placebom 1,3 ml/min/1,73 m² za rok v prospech finerenónu, s 95 % intervalom spoľahlivosti od 0,5 do 2,2 a p = 0,002. Tento údaj znamená pomalší priemerný pokles filtrácie; nemožno ho preložiť ako každoročné zvýšenie eGFR o 1,3 jednotky. U biopticky potvrdenej FSGS bol rozdiel 1,4 ml/min/1,73 m² za rok. [1]</p>
<p>Analýza nezistila rozdielnosť účinku medzi primárnou a sekundárnou FSGS, p pre interakciu bolo 0,84. To podporuje konzistentnosť pozorovania, ale nedokazuje totožný účinok pri všetkých mechanizmoch podocytového poškodenia. Jednotlivé podskupiny sú na takéto rozlíšenie malé. [1]</p>
<p>V 12. mesiaci bol UPCR pri finerenóne nižší oproti placebu o 41 %, s 95 % intervalom spoľahlivosti od 26 do 53 %. Pomer šancí na dosiahnutie UPCR pod 700 mg/g bol 6,8, s intervalom od 3,0 do 17,2. Pomer šancí nevyjadruje násobok pravdepodobnosti úspechu a nemožno ho tak komunikovať. Zmena proteinúrie bola exploračným ukazovateľom. [1]</p>
<h2>Čo zatiaľ nie je potvrdené</h2>
<p>Kombinovaný obličkový ukazovateľ zahŕňal trvalý pokles eGFR najmenej o 57 % alebo zlyhanie obličiek. Pomer hazardov pri finerenóne oproti placebu bol 0,58, ale 95 % interval spoľahlivosti od 0,30 do 1,15 zahŕňal aj neprítomnosť účinku. Výsledok preto nemožno prezentovať ako preukázané 42 % zníženie rizika. Nejde ani o dôkaz neúčinnosti; odhad je nepresný. [1]</p>
<p>V celej FIND-CKD bol rozdiel v sklone eGFR 0,7 ml/min/1,73 m² za rok a kombinovaný obličkový alebo kardiovaskulárny ukazovateľ dosiahol pomer hazardov 0,77, s 95 % intervalom od 0,60 do 0,99. Samostatný obličkový ukazovateľ mal aj v celom súbore interval zahŕňajúci jednotku: pomer hazardov 0,78, interval od 0,60 do 1,01. Celkové výsledky dávajú podskupine kontext, nenahrádzajú však samostatnú štúdiu pri FSGS. [2]</p>
<p>Proteomická analýza bola dodatočná, post hoc a exploračná. Zmeny markerov fibrózy a zápalu sú podkladom mechanistickej hypotézy, nie histologickým dôkazom ústupu glomerulosklerózy ani potvrdením obnovy filtračnej bariéry. [1]</p>
<h2>Hyperkaliémia vyžaduje rovnakú pozornosť</h2>
<p>Nežiaduce udalosti súvisiace s hyperkaliémiou sa v podskupine FSGS zaznamenali u 15 účastníkov s finerenónom (15 %) a 23 s placebom (20 %). Z tohto numerického rozdielu nemožno vyvodzovať ochranu pred hyperkaliémiou. V celej FIND-CKD bola hyperkaliémia častejšia pri finerenóne: 17,0 % oproti 13,3 %. Pre hyperkaliémiu prerušilo skúšanú liečbu 1,5 % oproti 0,1 % účastníkov. Tieto údaje spolu s požiadavkami súhrnu charakteristických vlastností lieku podporujú dôsledné sledovanie kaliémie a funkcie obličiek. [1, 2, 3]</p>
<h2>Význam pre nefrologickú prax a hranice dôkazov</h2>
<p>Aktuálne dostupné európske znenie súhrnu charakteristických vlastností lieku uvádza albuminurickú CKD spojenú s diabetom 2. typu a symptomatické chronické srdcové zlyhávanie s ejekčnou frakciou ľavej komory najmenej 40 %. Samotná FSGS v indikáciách uvedená nie je. Výsledok podskupiny preto nemožno zamieňať so schválením finerenónu pre FSGS ani s odporúčaním nahradiť liečbu vychádzajúcu z jej príčiny. [3]</p>
<p>Analýza rozširuje dôkazy o možnosti ovplyvniť progresiu proteinurickej CKD. Jej limity tvoria veľkosť podskupiny, neúplné bioptické potvrdenie a rozdielna etiológia FSGS. Pri tomto spracovaní boli overené úplné abstrakty a bibliografické záznamy oboch publikácií a aktuálny európsky súhrn charakteristických vlastností lieku. Plný text podskupinovej práce ani jej suplement neboli dostupné na kontrolu; podrobnosti nezahrnuté v overených zdrojoch sa preto neuvádzajú.</p>

<hr>
<p><em>Odborný text je určený zdravotníckym pracovníkom. Klinické rozhodnutie vyžaduje posúdenie konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Hiddo J L Heerspink, Brendon L Neuen, Rajiv Agarwal, David Z I Cherney, Carolyn S P Lam, Katherine R Tuttle, Christoph Wanner, Pantelis Sarafidis, Glenn M Chertow, Tim Friede, Jonathan Barratt, Jürgen Floege, Alfredo Chew-Wong, Vladimir Dobronravov, Susanne B Nicholas, Hirokazu Okada, David Packham, Pablo E Pergola, Marijn M Speeckaert, Shuifu Tang, Niels Jongs, J David Smeijer, Carolina Aldworth, Mario Berger, Meike Brinker, Rania Dayoub, Marina Yael Finkelsztein, Aidan MacNamara, Patrick Schloemer, Vlado Perkovic, FIND-CKD Investigators. Finerenone in Patients with Focal Segmental Glomerulosclerosis. J Am Soc Nephrol. 2026. Elektronická publikácia pred zaradením do čísla. <a href="https://doi.org/10.1681/ASN.0000001333" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.0000001333</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43034991/" target="_blank" rel="noopener noreferrer">PubMed 43034991</a></em></small></li>
<li><small><em>Hiddo J L Heerspink, Brendon L Neuen, Rajiv Agarwal, David Z I Cherney, Carolyn S P Lam, Katherine R Tuttle, Christoph Wanner, Pantelis Sarafidis, Niels Jongs, J David Smeijer, Meike Brinker, Nicole Rethemeier, Patrick Schloemer, Paula Vesterinen, David Goldsbury, Sara Dizayee, Jon W Mares, Vlado Perkovic, FIND-CKD Investigators. Finerenone in Persons with Chronic Kidney Disease without Diabetes. N Engl J Med. 2026;395(6):533 až 545. <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2604625</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42246672/" target="_blank" rel="noopener noreferrer">PubMed 42246672</a></em></small></li>
<li><small><em>European Medicines Agency. Kerendia: Summary of product characteristics, oddiely 4.1, 4.2 a 4.4. Znenie dostupné pri kontrole 17. 11. 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/kerendia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Oficiálny súhrn charakteristických vlastností lieku</a>.</em></small></li>
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
    'log_prefix' => 'add_finerenon-fsgs-find-ckd-podskupina_article',
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
