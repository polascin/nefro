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
    'title'        => 'Finerenón pri CKD a diabete 1. typu: čo skutočne znamená schválenie FDA',
    'slug'         => 'finerenon-dm1-ckd-fda-fine-one',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'FDA rozšírila indikáciu finerenónu na dospelých s CKD a diabetom 1. typu. Základom je pokles albuminúrie v FINE-ONE, nie priamy dôkaz prevencie zlyhania obličiek.',
    'content'      => <<<'HTML'
<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) rozšíril v septembri 2026 indikáciu finerenónu (Kerendia) na dospelých s chronickou chorobou obličiek (CKD) asociovanou s diabetes mellitus 1. typu. Presná formulácia je podstatná: liek je v USA indikovaný na <strong>zníženie pomeru albumínu ku kreatinínu v moči (UACR), od ktorého sa očakáva zníženie rizika trvalého poklesu eGFR a terminálneho zlyhania obličiek</strong>. Štúdia FINE-ONE priamo preukázala pokles albuminúrie, nie zníženie počtu prípadov zlyhania obličiek, kardiovaskulárnych príhod alebo úmrtí. [1–3]</p>

<h2>Regulačné rozhodnutie nie je dôkazom všetkých klinických výsledkov</h2>
<p>Aktuálny americký predpisový text odlišuje tri indikácie finerenónu. Pri CKD a diabete 2. typu uvádza zníženie rizika renálnych a kardiovaskulárnych príhod na základe výsledkov FIDELIO-DKD a FIGARO-DKD. Pri CKD a diabete 1. typu je indikácia postavená na znížení UACR a na očakávanom renálnom prínose odvodenom z celkového súboru dôkazov. FDA využila výsledky FINE-ONE spolu s klinickými údajmi pri diabete 2. typu, v ktorých bola zmena albuminúrie spojená s renálnymi výsledkami. [1]</p>
<p>Toto regulačné odvodenie je významné, ale nesmie sa preformulovať na tvrdenie, že FINE-ONE preukázala prevenciu terminálneho zlyhania obličiek. Štúdia trvala šesť mesiacov, mala 242 účastníkov a na takýto klinický výsledok nebola navrhnutá ani štatisticky dimenzovaná. UACR je prognosticky dôležitý biomarker a v tomto programe registračný preklenovací ukazovateľ; zostáva však náhradným ukazovateľom. [1–3]</p>

<h2>Koho zahŕňala FINE-ONE</h2>
<p>FINE-ONE bola multicentrická, randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia 3. fázy. Zaradila dospelých s diabetom 1. typu a CKD, ktorí mali eGFR 25 až menej ako 90 ml/min/1,73 m², UACR 200 až menej ako 5 000 mg/g a HbA1c pod 10 %. Účastníci dostávali inzulín a stabilnú dávku inhibítora ACE alebo blokátora receptorov angiotenzínu II. Vstupná koncentrácia draslíka musela byť najviac 4,8 mmol/l. [1, 2]</p>
<p>Pacienti užívajúci inhibítor SGLT2 alebo agonistu receptora GLP-1 boli zo štúdie vylúčení. Výsledok preto neposkytuje priamy dôkaz o účinnosti ani bezpečnosti súbežnej liečby týmito liekmi pri diabete 1. typu a rozhodovanie nemožno prenášať zo situácie pri diabete 2. typu. [1]</p>

<h2>Primárny výsledok: tri percentá, tri odlišné významy</h2>
<p>Primárnym ukazovateľom bola zmena logaritmicky transformovaného UACR vyjadrená ako pomer k východiskovej hodnote a spriemerovaná z meraní v treťom a šiestom mesiaci. Priemerný účinok finerenónu oproti placebu predstavoval <strong>o 25 % väčšie zníženie UACR</strong> (pomer geometrických priemerov 0,75; 95 % interval spoľahlivosti 0,65 až 0,87; p &lt; 0,001). [2]</p>
<ul>
<li>V ramene s finerenónom klesol UACR za šesť mesiacov o 34 % oproti východiskovej hodnote.</li>
<li>V ramene s placebom klesol za rovnaký čas o 12 %.</li>
<li>Placebom korigovaný rozdiel bol 25 %, pretože sa počítal ako pomer geometrických priemerov, nie jednoduchým odčítaním 34 mínus 12.</li>
</ul>
<p>Americký predpisový text uvádza aj časové odhady: oproti placebu bol UACR nižší o 22 % v treťom a o 28 % v šiestom mesiaci. Tieto čísla sa nevylučujú s primárnym 25 % výsledkom; opisujú jednotlivé návštevy, zatiaľ čo primárna analýza ich spriemerovala. [1]</p>

<h2>eGFR: krátkodobý pokles bol po vysadení prevažne reverzibilný</h2>
<p>Po šiestich mesiacoch sa eGFR zmenila o −5,6 ml/min/1,73 m² pri finerenóne a o −2,7 ml/min/1,73 m² pri placebe. Rozdiel bol −2,9 ml/min/1,73 m² (95 % interval spoľahlivosti −5,1 až −0,7). Počas vymývacieho obdobia sa hodnoty približovali k východiskovým, čo podporuje hemodynamickú zložku zmeny. [2]</p>
<p>Jednotlivý pokles eGFR preto nemožno automaticky označiť za progresiu CKD, no nemožno ho ani ignorovať. Treba posúdiť objemový stav, tlak, interkurentné ochorenie, súbežné lieky a dynamiku kreatinínu a draslíka. FINE-ONE neposkytuje dlhodobú krivku eGFR ani dôkaz spomalenia zlyhania obličiek počas rokov.</p>

<h2>Hyperkaliémia je hlavné bezpečnostné riziko</h2>
<p>Hyperkaliémia sa vyskytla u 10,1 % účastníkov s finerenónom a u 3,3 % s placebom. Dvaja účastníci liečení finerenónom, teda 1,7 %, liečbu pre hyperkaliémiu natrvalo ukončili. Krátke trvanie a prísne vstupné kritériá znamenajú, že reálne riziko môže byť u pacientov s nižšou eGFR, vyšším východiskovým draslíkom alebo ďalšími liekmi zvyšujúcimi kaliémiu odlišné. [2]</p>
<p>Finerenón je substrát CYP3A4. Súbežné podávanie so silnými inhibítormi CYP3A4 je podľa amerického predpisového textu kontraindikované. Opatrnosť a prípadne častejšie kontroly si vyžadujú aj ďalšie lieky zvyšujúce koncentráciu finerenónu alebo sérový draslík. [1]</p>

<div class="pdf-keep-together">
<h2>Americké dávkovanie pri CKD s diabetom 1. typu</h2>
<p>Nasledujúce údaje opisujú <strong>americký predpisový text</strong>, nie európske alebo slovenské preskripčné pravidlá: [1]</p>
<ul>
<li>pred začatím sa meria eGFR a sérový draslík; liečba sa nezačína pri draslíku nad 5,0 mmol/l,</li>
<li>pri eGFR najmenej 60 ml/min/1,73 m² je úvodná dávka 20 mg raz denne,</li>
<li>pri eGFR 25 až menej ako 60 ml/min/1,73 m² je úvodná dávka 10 mg raz denne,</li>
<li>pri eGFR pod 25 ml/min/1,73 m² sa začatie neodporúča,</li>
<li>cieľová dávka pri CKD asociovanej s diabetom 1. alebo 2. typu je 20 mg raz denne,</li>
<li>draslík sa kontroluje po štyroch týždňoch od začatia a po každej zmene dávky, potom periodicky podľa rizika.</li>
</ul>
</div>
<p>Pri draslíku nad 5,5 mmol/l sa má liečba prerušiť a podľa hodnoty draslíka neskôr obnoviť v dávke 10 mg. Ak eGFR pri zvažovanej titrácii klesla o viac ako 30 % oproti predchádzajúcemu meraniu, americký predpisový text odporúča ponechať 10 mg. Tieto pravidlá treba vždy overiť v aktuálnom dokumente platnom pre danú krajinu a konkrétnu indikáciu. [1]</p>

<h2>Čo to znamená pre slovenskú a európsku prax</h2>
<p><strong>Schválenie FDA nie je automaticky schválením v Európskej únii ani na Slovensku.</strong> K 24. septembru 2026 Európska lieková agentúra uvádza renálnu indikáciu Kerendie pre dospelých s CKD, albuminúriou a diabetom 2. typu. Európska produktová informácia zatiaľ neuvádza CKD asociovanú s diabetom 1. typu. Použitie v tejto populácii je preto v EÚ mimo schválenej renálnej indikácie, pokiaľ sa regulačný stav nezmení. [4]</p>
<p>Americké rozhodnutie mení dôkazový a regulačný kontext, ale nemení potrebu potvrdiť CKD, kvantifikovať UACR, optimalizovať glykémiu a tlak, použiť tolerovanú blokádu renín-angiotenzínového systému a kontrolovať draslík. Pri rozhodovaní treba zohľadniť dostupnosť, úhradu, kontraindikácie a aktuálny slovenský súhrn charakteristických vlastností lieku.</p>

<h2>Praktický záver</h2>
<p>FINE-ONE priniesla presvedčivý krátkodobý dôkaz zníženia albuminúrie a definovala bezpečnostný profil finerenónu pri CKD a diabete 1. typu. FDA na tomto výsledku a na extrapolácii údajov z diabetu 2. typu založila novú americkú indikáciu. Pre klinickú komunikáciu je presné hovoriť, že finerenón <strong>znižuje UACR a na tomto základe sa očakáva renálny prínos</strong>. Dlhodobé zníženie rizika zlyhania obličiek alebo kardiovaskulárnych príhod pri diabete 1. typu zatiaľ priamo preukázané nebolo.</p>
<p><small><em>Rozsah overenia: výsledky a úplný autorský zoznam FINE-ONE boli overené v publikácii New England Journal of Medicine a bibliografických záznamoch PubMed. Indikácia, dávkovanie a monitorovanie boli overené v aktuálnom americkom predpisovom texte Kerendie; európsky regulačný stav v aktuálnej produktovej informácii EMA. Stav overenia: 24. september 2026.</em></small></p>

<div class="pdf-keep-together">
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>U.S. Prescribing Information: Kerendia (finerenone), revised September 2026. <a href="https://labeling.bayerhealthcare.com/html/products/pi/Kerendia_PI.pdf" target="_blank" rel="noopener noreferrer">Aktuálny americký predpisový text</a>.</em></small></li>
<li><small><em>Heerspink HJL, Birkenfeld AL, Cherney DZI, Colhoun HM, Groop PH, Ji L, Jongs N, Mathieu C, Pratley RE, Rosas SE, Rossing P, Skyler JS, Tuttle KR, Lawatscheck R, Brinker M, Scheerer MF, Russell J, Schloemer P, McGill JB; FINE-ONE Investigators. Finerenone in Type 1 Diabetes and Chronic Kidney Disease. N Engl J Med. 2026;394(10):947–957. <a href="https://doi.org/10.1056/NEJMoa2512854" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41780000/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Heerspink HJL, Birkenfeld AL, Cherney DZI, et al. Rationale and design of a randomised phase III registration trial investigating finerenone in participants with type 1 diabetes and chronic kidney disease: The FINE-ONE trial. Diabetes Res Clin Pract. 2023;204:110908. <a href="https://pubmed.ncbi.nlm.nih.gov/37805000/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>European Medicines Agency. Kerendia: EPAR and product information. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">Aktuálna európska indikácia</a>.</em></small></li>
<li><small><em>Bayer. U.S. FDA approves finerenone for new indication in patients with chronic kidney disease associated with type 1 diabetes. 17 September 2026. <a href="https://www.bayer.com/media/en-us/us-fda-approves-finerenone-for-new-indication-in-patients-with-chronic-kidney-disease-associated-with-type-1-diabetes/" target="_blank" rel="noopener noreferrer">Oznámenie o schválení</a>.</em></small></li>
</ol>
</div>
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
    'log_prefix' => 'add_finerenon-dm1-ckd-fda-fine-one_article',
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
