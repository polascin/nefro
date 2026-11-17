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
    'title'        => 'Druhé antihypertenzívum pri CKD: priaznivá asociácia tiazidov nie je univerzálnym poradím liekov',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'druhe-antihypertenzivum-ckd-tiazid-observacna-studia',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Analýza 150 369 pacientov s CKD spája pridanie tiazidu s priaznivejšími výsledkami. Observačný dizajn však nedokazuje jeho nadradenosť pri všetkých klinických indikáciách.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/druhe-antihypertenzivum-ckd-tiazid-observacna-studia.webp" target="_blank" rel="noopener noreferrer"><img src="img/druhe-antihypertenzivum-ckd-tiazid-observacna-studia.webp" alt="Oblička, tlakomer a symbolické možnosti antihypertenzívnej liečby vo vyváženej kompozícii" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, histologický preparát ani zobrazenie preukázaného účinku lieku.</figcaption></figure>
<p>Pri potrebe pridať druhé antihypertenzívum k inhibítoru ACE alebo sartanu býva rozhodovanie podstatne zložitejšie než výber lieku podľa jednej tabuľky. Veľká analýza údajov Veterans Health Administration spája pridanie tiazidového diuretika s priaznivejšími kardiovaskulárnymi a obličkovými výsledkami než pridanie blokátora kalciových kanálov, betablokátora alebo slučkového diuretika. Je to relevantný observačný výsledok, nie dôkaz univerzálnej nadradenosti tiazidov. [1]</p>
<h2>Ako vznikol porovnávaný súbor</h2>
<p>Autori napodobnili usporiadanie cieľovej klinickej štúdie pomocou národných ambulantných údajov z obdobia od 1. januára 2010 do 31. decembra 2016. Zaradili 150 369 dospelých s nedialyzovanou CKD kategórií G1 až G5, ktorí užívali inhibítor ACE alebo blokátor angiotenzínového receptora a začali užívať druhú triedu antihypertenzíva. Takáto emulácia cieľovej štúdie pomáha presnejšie formulovať porovnanie, ale nevytvára náhodné pridelenie liečby. [1]</p>
<p>Tiazid dostalo 45 836 pacientov, slučkové diuretikum 17 589, blokátor kalciových kanálov 33 172 a betablokátor 53 772. Medián sledovania bol 1 282 dní, prvý a tretí kvartil 621 a 1 979 dní. Analýzy zohľadňovali klinicky významné charakteristiky, no samotné štatistické upravenie nemôže zaručiť odstránenie všetkých rozdielov medzi liečenými skupinami. [1]</p>
<h2>Čo znamenali sledované výsledky</h2>
<p>Kardiovaskulárny kombinovaný ukazovateľ zahŕňal fatálny alebo nefatálny infarkt myokardu alebo cievnu mozgovú príhodu, hospitalizáciu pre srdcové zlyhávanie a koronárnu revaskularizáciu. Obličkový kombinovaný ukazovateľ zahŕňal začatie dialýzy, transplantáciu obličky alebo trvalé zdvojnásobenie kreatinínu. Výsledky preto nemožno skracovať na samotnú mortalitu či samotné zlyhanie obličiek. [1]</p>
<div class="table-responsive" role="region" aria-label="Upravené pomery hazardov oproti tiazidovým diuretikám" tabindex="0"><table><thead><tr><th scope="col">Pridaná lieková skupina</th><th scope="col">Kardiovaskulárny ukazovateľ, aHR (95 % IS)</th><th scope="col">Obličkový ukazovateľ, aHR (95 % IS)</th></tr></thead><tbody><tr><th scope="row">Blokátor kalciových kanálov</th><td>1,18 (1,15 až 1,22)</td><td>1,42 (1,33 až 1,52)</td></tr><tr><th scope="row">Betablokátor</th><td>1,63 (1,58 až 1,67)</td><td>1,13 (1,06 až 1,21)</td></tr><tr><th scope="row">Slučkové diuretikum</th><td>1,97 (1,90 až 2,04)</td><td>1,98 (1,83 až 2,15)</td></tr></tbody></table></div>
<p>Referenčnou skupinou boli tiazidové diuretiká. aHR označuje upravený pomer hazardov a IS interval spoľahlivosti. Ide o pomery okamžitých rizík v čase, nie o absolútne rozdiely pravdepodobností udalosti. Bez príslušných absolútnych rizík a časového horizontu z nich nemožno odvodiť počet pacientov potrebných na liečbu. [1]</p>
<h2>Skreslenie indikáciou zostáva rozhodujúcim limitom</h2>
<p>Pacienti so slučkovými diuretikami mali častejšie pokročilejšiu CKD alebo srdcové zlyhávanie. Už pred začatím druhého lieku teda nešlo o vzájomne zameniteľné populácie. Vyššie riziko udalostí môže čiastočne odrážať ochorenie, pre ktoré bol liek predpísaný, nie poškodenie vyvolané liekom. Naproti tomu pacienti s tiazidmi a blokátormi kalciových kanálov mali najvyšší vstupný krvný tlak. [1]</p>
<p>Zvyškové skreslenie môže pretrvať aj pri rozsiahlej úprave o zaznamenané premenné, najmä ak nie je dostatočne zachytená závažnosť kongescie, dôvod nasadenia lieku alebo ďalšie rozdiely v zdravotnom stave. Toto je metodická hranica observačného porovnania, nie dôkaz, že všetky zistené rozdiely sú skreslením. Údaje veteránskeho zdravotného systému navyše nemusia reprezentovať celú slovenskú nefrologickú populáciu.</p>
<h2>Čo pridáva randomizovaná štúdia CLICK</h2>
<p>Randomizovaná štúdia CLICK poskytuje odlišný, užší typ dôkazu. U 160 pacientov s CKD G4 a nedostatočne kontrolovanou hypertenziou znížil chlórtalidón priemerný 24-hodinový systolický tlak za 12 týždňov oproti placebu o 10,5 mmHg, s 95 % intervalom spoľahlivosti od −14,6 do −6,4 mmHg. Priemerná vstupná eGFR bola 23,2 ml/min/1,73 m² a 60 % účastníkov už dostávalo slučkové diuretikum. [2]</p>
<p>CLICK preto vyvracia predstavu, že tiazidom podobné diuretiká pri pokročilej CKD nemôžu účinne znižovať tlak. Neoverovala však ich dlhodobú nadradenosť nad ostatnými triedami v kardiovaskulárnych či obličkových udalostiach. Pri chlórtalidóne boli častejšie hypokaliémia, reverzibilné zvýšenie kreatinínu, hyperglykémia, závraty a hyperurikémia. Účinnosť pri nízkej eGFR tak nemožno oddeliť od potreby monitorovania. [2]</p>
<h2>Výber lieku zostáva klinickým rozhodnutím</h2>
<p>Odborný prehľad ERA opisuje dlhodobo pôsobiace dihydropyridínové blokátory kalciových kanálov a diuretiká ako rozumné možnosti druhej a tretej línie pri CKD. Nová observačná práca prináša argument na opätovné zváženie tiazidu u vhodného pacienta, nenahrádza však posúdenie konkrétnej indikácie a tolerancie. [3]</p>
<p>Pri kongescii nemožno iba na základe pomeru hazardov z tejto kohorty zameniť potrebné slučkové diuretikum za tiazid. Rovnako nemožno odstrániť betablokátor, ak má samostatnú kardiologickú indikáciu. Takéto zmeny by boli záverom presahujúcim porovnávanú observačnú otázku. Klinicky užitočné je rozlišovať liek pridávaný predovšetkým na zníženie tlaku od lieku potrebného pre ďalšie ochorenie.</p>
<p>Overené boli úplné abstrakty a bibliografické záznamy novej kohortovej analýzy, CLICK a odborného prehľadu ERA. Plný text novej analýzy ani jej suplement neboli dostupné na kontrolu. Bez nich sa neuvádza neoverený úplný zoznam upravovaných premenných, jednotlivé dávky ani podrobnosti analýz citlivosti. Hlavný záver zostáva primeraný dostupným dôkazom: priaznivá asociácia podporuje ďalšie skúmanie a uvážený výber tiazidu, nie všeobecný liekový rebríček.</p>

<hr>
<p><em>Odborný text je určený zdravotníckym pracovníkom. Klinické rozhodnutie vyžaduje posúdenie konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>L Parker Gregg, Aaron Perkins, Hui Yang, Christine Vu, Vijay Nambi, Wolfgang C Winkelmayer, S Susan Hedayati, Sankar D Navaneethan, Carlos A Alvarez. Association of Second Anti-hypertensive Agent with Outcomes in People with CKD on ACEi/ARB Therapy. J Am Soc Nephrol. 2026. Elektronická publikácia pred zaradením do čísla. <a href="https://doi.org/10.1681/ASN.0000001313" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.0000001313</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43024400/" target="_blank" rel="noopener noreferrer">PubMed 43024400</a></em></small></li>
<li><small><em>Rajiv Agarwal, Arjun D Sinha, Andrew E Cramer, Mary Balmes-Fenwick, Jazmyn H Dickinson, Fangqian Ouyang, Wanzhu Tu. Chlorthalidone for Hypertension in Advanced Chronic Kidney Disease. N Engl J Med. 2021;385(27):2507. <a href="https://doi.org/10.1056/NEJMoa2110730" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2110730</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/34739197/" target="_blank" rel="noopener noreferrer">PubMed 34739197</a></em></small></li>
<li><small><em>Panagiotis I Georgianos, Rajiv Agarwal. Hypertension in chronic kidney disease-treatment standard 2023. Nephrol Dial Transplant. 2023;38(12):2694. <a href="https://doi.org/10.1093/ndt/gfad118" target="_blank" rel="noopener noreferrer">DOI 10.1093/ndt/gfad118</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37355779/" target="_blank" rel="noopener noreferrer">PubMed 37355779</a></em></small></li>
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
    'log_prefix' => 'add_druhe-antihypertenzivum-ckd-tiazid-observacna-studia_article',
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
