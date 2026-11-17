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
    'title'        => 'Cyklosilikát sodno-zirkoničitý pri CKD a HFrEF: podpora titrácie liečby v štúdii LIFT',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'szc-titracia-raasi-ckd-hfref-lift',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Malá randomizovaná štúdia ukázala, že SZC uľahčuje dosiahnutie cieľových dávok inhibítorov RAAS. Klinický prínos a dlhodobá bezpečnosť však vyžadujú samostatné hodnotenie.',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/szc-titracia-raasi-ckd-hfref-lift.webp" target="_blank" rel="noopener noreferrer"><img src="img/szc-titracia-raasi-ckd-hfref-lift.webp" alt="Poloschematické prepojenie obličky a srdca s motívom regulácie draslíka" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna. Nejde o snímku konkrétneho pacienta, histologický preparát ani zobrazenie preukázaného účinku lieku.</figcaption></figure>
<p>Cyklosilikát sodno-zirkoničitý (SZC) v štúdii LIFT zvýšil podiel pacientov, ktorí dosiahli cieľovú dávku inhibície renínovo-angiotenzínovo-aldosterónového systému (RAAS) bez vzostupu kaliémie na 5,6 mmol/l alebo viac. Výsledok je prakticky dôležitý pre pacientov so srdcovým zlyhávaním so zníženou ejekčnou frakciou (HFrEF) a chronickou chorobou obličiek (CKD). Štúdia však sledovala predovšetkým uskutočniteľnosť titrácie liečby, nie jej dlhodobý vplyv na prežívanie. [1]</p>
<h2>Populácia s významným obličkovým rizikom</h2>
<p>Dvojito zaslepená, placebom kontrolovaná štúdia v jednom centre randomizovala 112 pacientov: 53 dostávalo SZC a 59 placebo. Priemerný vek bol 73 rokov a priemerná eGFR 35 ml/min/1,73 m². Zaradenie vyžadovalo HFrEF s ejekčnou frakciou najviac 40 %, CKD s eGFR pod 60 ml/min/1,73 m² a záznam kaliémie od 5,0 do 5,5 mmol/l počas troch mesiacov pred skríningom. Neznamená to, že každý mal takúto kaliémiu aj pri randomizácii. [1]</p>
<p>Hoci názov populácie zahŕňa CKD G3 až G5, v kategórii G5 boli iba dvaja účastníci, obaja v skupine SZC. V G4 bolo 37 účastníkov. Závery pre G5 sú preto veľmi neisté a výsledok nemožno bez ďalších údajov prenášať na dialyzovaných pacientov. Pôvodný protokol plánoval nábor 130 účastníkov; konečný súbor bol menší. [1, 2]</p>
<h2>Titrácia s kontrolou každé dva týždne</h2>
<p>Liečba sa zvyšovala v dvojtýždňových intervaloch podľa klinickej tolerancie a laboratórnych výsledkov. Cieľ sa týkal antagonistu mineralokortikoidového receptora a jedného z liekov inhibujúcich renínovo-angiotenzínový systém: inhibítora ACE, sartanu alebo kombinovaného inhibítora angiotenzínového receptora a neprilyzínu. Nešlo o súčasné podávanie všetkých týchto skupín. Kontroly zahŕňali tlak, príznaky, elektrolyty a kreatinín. Maximálne sledovanie trvalo 14 týždňov. [1]</p>
<p>Prínos viazača draslíka preto nemožno oddeliť od organizácie starostlivosti. Výsledok nehovorí, že samotné pridanie SZC umožňuje bezpečne zvyšovať liečbu bez častých kontrol. Intenzita sledovania bola jednou z podmienok skúšaného postupu a zároveň limitom jeho prenosu do bežnej ambulancie. [1]</p>
<h2>Výsledok treba uvádzať so správnym menovateľom</h2>
<p>V analýze podľa protokolu dosiahlo cieľovú dávku bez kaliémie najmenej 5,6 mmol/l 24 zo 43 účastníkov so SZC (56 %) a 15 z 53 s placebom (28 %), p = 0,006. Tieto percentá nepatria všetkým 112 randomizovaným pacientom. Štúdiu nedokončilo 10 z 53 účastníkov so SZC a 6 z 59 s placebom. [1]</p>
<p>Analýza podľa pôvodného pridelenia k liečbe zahŕňala všetkých 112 účastníkov. Uvádzaný pomer šancí bol 3,16, s 95 % intervalom spoľahlivosti od 1,35 do 7,39 a p = 0,008. Hodnota p = 0,007 patrí príslušnému testu primárneho výsledku v analýze podľa pôvodného pridelenia. Pomer šancí 3,16 nie je trojnásobnou pravdepodobnosťou úspechu. Analýzy s chýbajúcimi pozorovaniami navyše závisia od zvolených štatistických predpokladov. [1]</p>
<p>Primárny výsledok je kombináciou dosiahnutej dávky a laboratórnej tolerancie. Jeho zlepšenie nemožno premenovať na preukázané zníženie mortality, hospitalizácií pre srdcové zlyhávanie alebo progresie CKD. Autori sami uvádzajú potrebu väčšej a dlhšej štúdie na klinické výsledky. [1]</p>
<h2>REALIZE-K podporuje titráciu, ale pripomína bezpečnostnú neistotu</h2>
<p>Ďalšia randomizovaná štúdia, REALIZE-K, hodnotila pokračovanie SZC oproti jeho nahradeniu placebom po úvodnej fáze optimalizácie spironolaktónu. Medzi 203 randomizovanými účastníkmi dosiahlo priaznivú odpoveď 71 % so SZC a 36 % s placebom. Odpoveď znamenala normokaliémiu pri spironolaktóne najmenej 25 mg denne bez záchrannej liečby hyperkaliémie. Dizajn, prah kaliémie aj cieľová dávka sa od LIFT líšili; percentá preto nie sú priamym porovnaním účinnosti. [3]</p>
<p>V REALIZE-K sa zároveň kombinácia kardiovaskulárneho úmrtia alebo zhoršenia srdcového zlyhávania vyskytla u 11 účastníkov so SZC a troch s placebom, teda u 11 % oproti 3 %. Išlo o exploračný výsledok a štúdia nemala dostatočnú štatistickú silu na definitívne hodnotenie klinických udalostí. Tento signál nepreukazuje kauzalitu, ale nemožno ho vynechať z vyváženého posúdenia lieku u pacientov so srdcovým zlyhávaním. [3]</p>
<h2>Sodík, edémy a sledovanie pacienta</h2>
<p>Neprítomnosť štatisticky významného rozdielu v nežiaducich udalostiach v malej LIFT nie je dôkazom rovnakej bezpečnosti. Podľa európskeho súhrnu charakteristických vlastností lieku obsahuje 5 g SZC približne 400 mg sodíka a 10 g približne 800 mg. Obsah sodíka v prípravku však nie je priamym meraním jeho individuálne vstrebanej alebo zadržanej dávky. U pacienta so srdcovým zlyhávaním treba sledovať najmä zhoršenie dýchavice, edémy a rýchly vzostup hmotnosti. [1, 4]</p>
<p>Štúdia teda podporuje SZC ako nástroj na udržanie a titráciu potrebnej liečby vo vybranej populácii pod intenzívnym dohľadom. O výbere viazača rozhoduje popri kaliémii aj objemový stav, tolerancia, súbežná medikácia a možnosť kontrol. Nemožno z nej odvodiť všeobecnú povinnosť maximalizovať dávku za každú cenu.</p>
<p>Overený bol dostupný plný text LIFT vrátane hlavných tabuliek, jej publikovaný protokol v rozsahu abstraktu, úplný abstrakt REALIZE-K a aktuálny európsky súhrn charakteristických vlastností lieku. Samostatný suplement LIFT nebol celý skontrolovaný; tvrdenia z neho, ktoré neboli reprodukované v hlavnom texte, sa nepreberajú. LIFT financoval externý výskumný grant spoločnosti AstraZeneca, čo je relevantné pri hodnotení celého dôkazového súboru. [1]</p>
<h2>Súvisiaci článok</h2><p><a href="article.php?slug=hyperkaliemia-raasi-mra-viazace-draslika-sodik">Hyperkaliémia, inhibítory RAAS a sodíková záťaž viazačov draslíka</a></p>
<hr>
<p><em>Odborný text je určený zdravotníckym pracovníkom. Klinické rozhodnutie vyžaduje posúdenie konkrétneho pacienta.</em></p>
<h2>Literatúra</h2>
<ol>
<li><small><em>Debasish Banerjee, Mahrukh Ali, Ella Tumelty, Daniel Murphy, Hilary Warrens, Simran Parmar, Thomas McNally, Tony Lopez, Sharirose Abat, Riny Paul, Sabba Hussain, Souradip Mookerjee, Isaac Chung, Irina Chis Ster, Lisa Anderson. Rapid Renin Angiotensin Aldosterone System inhibitor optimisation in patients with chronic kidney disease and heart failure with reduced ejection fraction using potassium binder: a randomised, double-blinded, placebo-controlled trial. Nat Commun. 2026;17(1). <a href="https://doi.org/10.1038/s41467-026-78377-0" target="_blank" rel="noopener noreferrer">DOI 10.1038/s41467-026-78377-0</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/43015282/" target="_blank" rel="noopener noreferrer">PubMed 43015282</a></em></small></li>
<li><small><em>Daniel Murphy, Irina Chis Ster, Juan-Carlos Kaski, Lisa Anderson, Debasish Banerjee. The LIFT trial: study protocol for a double-blind, randomised, placebo-controlled trial of K+-binder Lokelma for maximisation of RAAS inhibition in CKD patients with heart failure. BMC Nephrol. 2021;22(1):254. <a href="https://doi.org/10.1186/s12882-021-02439-2" target="_blank" rel="noopener noreferrer">DOI 10.1186/s12882-021-02439-2</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/34229607/" target="_blank" rel="noopener noreferrer">PubMed 34229607</a></em></small></li>
<li><small><em>Mikhail N Kosiborod, David Z I Cherney, Akshay S Desai, Jeffrey M Testani, Subodh Verma, Khaja Chinnakondepalli, David Dolling, Shachi Patel, Magnus Dahl, James M Eudicone, Lovisa Friberg, Mario Ouwens, Murillo O Antunes, Kim A Connelly, Vagner Madrini, Luca Kuthi, Anuradha Lala, Miguel Lorenzo, Patrícia O Guimarães, Marta Cobo Marcos, Béla Merkely, Julio Nuñez, Iain Squire, Jan Václavík, Jerzy Wranicz, Mark C Petrie. Sodium Zirconium Cyclosilicate for Management of Hyperkalemia During Spironolactone Optimization in Patients With Heart Failure. J Am Coll Cardiol. 2025;85(10):971. <a href="https://doi.org/10.1016/j.jacc.2024.11.014" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.jacc.2024.11.014</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39566872/" target="_blank" rel="noopener noreferrer">PubMed 39566872</a></em></small></li>
<li><small><em>European Medicines Agency. Lokelma: Summary of product characteristics, oddiely 2, 4.4 a 4.8. Znenie dostupné pri kontrole 17. 11. 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/lokelma-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Oficiálny súhrn charakteristických vlastností lieku</a>.</em></small></li>
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
    'log_prefix' => 'add_szc-titracia-raasi-ckd-hfref-lift_article',
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
