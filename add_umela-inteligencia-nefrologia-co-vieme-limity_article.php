<?php
/**
 * add_umela-inteligencia-nefrologia-co-vieme-limity_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_umela-inteligencia-nefrologia-co-vieme-limity_article.php"
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
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Umelá inteligencia v nefrológii: čo už vieme, kde sú limity a kam to smeruje',
    'slug'         => 'umela-inteligencia-nefrologia-co-vieme-limity',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad praktického využitia umelej inteligencie a strojového učenia v nefrológii: skoré zachytenie AKI, odhad progresie CKD, predikcia dialýznych udalostí, podpora transplantácie a automatizácia patológie — spolu s limitmi ako bias, kvalita dát, „black box“, bezpečnosť a etika. Podľa prehľadového článku na PMC.',
    'content'      => <<<'HTML'
<h2>Úvod: prečo je nefrológia pre AI prirodzené pole</h2>

<p>Umelá inteligencia (AI) sa v medicíne rozširuje naprieč odbormi, no nefrológia podľa dostupných prehľadov doteraz zaostávala v adopcii a praktickej integrácii. Dôvod je praktický: nefrológia pracuje s veľkým množstvom štruktúrovaných dát, ktoré sú zároveň matematicky „čitateľné“. Navyše v klinickej praxi ide často o rozhodovania v časovom tlaku (napríklad skoré zachytenie AKI) a o riziká s jasnými parametrami (progresia CKD, komplikácie, dialyzačné udalosti).</p>

<p>Cieľom AI v zdravotníctve nemá byť nahradiť nefrológa. Skôr má rozšíriť jeho schopnosti: spracovať viac dát, rýchlejšie identifikovať riziká a pomôcť pri tvorbe presnejších a včasnejších postupov.</p>

<h2>Základné pojmy: AI, ML a deep learning (a prečo na tom záleží)</h2>

<p>Pre klinika je užitočné vedieť, že AI je zastrešujúci pojem a najčastejšou praktickou „motorovou časťou“ v medicíne je strojové učenie (machine learning, ML).</p>

<p>ML sa dá zjednodušene deliť na:</p>

<ul>
  <li><strong>učenie s učiteľom</strong> (supervised learning, učenie s označenými výsledkami): model sa trénuje na dátach, kde vopred vieme, čo je „správny“ výstup,</li>
  <li><strong>učenie bez učiteľa</strong> (unsupervised learning, učenie bez označení): hľadá vzťahy a vzorce v dátach bez vopred nastavenej úlohy,</li>
  <li><strong>učenie posilňovaním</strong> (reinforcement learning): model sa „učí“ cez odmeny a penalizácie, čo v medicíne naráža na etické limity (experimentovanie v reálnom čase zvyčajne nie je možné, preto sa pracuje skôr s retrospektívnymi dátami).</li>
</ul>

<p>V praxi sa spomína aj rozdiel oproti tradičným štatistickým skórovacím systémom: ML dokáže flexibilne prispôsobiť váhy jednotlivých premenných a generovať výstupy bez priameho ľudského zásahu v kroku rozhodovania.</p>

<h2>Kľúčový koncept klinickej rozhodovacej podpory: životný cyklus AI</h2>

<p>AI určená na klinické rozhodovanie typicky prechádza cyklom: tréning na dátach, validácia, nasadenie do klinického procesu a následné priebežné hodnotenie. Dôležité je, že reálny výkon neurčuje len „presnosť“ na testovacej vzorke, ale aj to, ako model reaguje na zmeny populácie, praxe alebo zberu dát.</p>

<hr>

<h2>Kde má AI v nefrológii najväčší potenciál</h2>

<h3>1) Akútne poškodenie obličiek (AKI): skoré zachytenie a predikcia</h3>

<p>AKI je heterogénny syndróm s rôznymi mechanizmami, ktoré sa nakoniec môžu „zlievať“ do spoločného klinického výsledku (napríklad zvýšenie kreatinínu a/alebo zníženie diurézy). Práve táto rôznorodosť robí skoré predikcie náročnými.</p>

<p>AI a ML sa využívajú na:</p>

<ul>
  <li><strong>predikciu AKI</strong> (napr. v pooperačnom období),</li>
  <li><strong>podporu klinického rozhodovania</strong> (clinical decision support),</li>
  <li><strong>analýzu fenotypov</strong> pomocou prístupov bez učiteľa, napríklad pri AKI spojenom so sepsou.</li>
</ul>

<p>Konkrétne príklady zo zdroja:</p>

<ul>
  <li>v retrospektívnej analýze <strong>2 010 pacientov</strong> po cievnych a hrudných výkonoch (vrátane srdcovej chirurgie) na predikciu pooperačného AKI vyšlo, že <strong>extreme gradient boosting</strong> prekonal tradičné modely,</li>
  <li>v rozsiahlej dátovej práci s <strong>703 782 pacientmi</strong> model predikoval AKI s vysokou schopnosťou zachytiť prípady, ktoré následne vyžadovali dialýzu, pričom upozornenie mohlo prísť <strong>až 48 hodín pred dialýzou</strong>. Zároveň sa uvádza aj problém s vyššou mierou falošne pozitívnych predikcií a otázka prenositeľnosti výsledkov (model bol trénovaný na populácii s prevahou mužov),</li>
  <li>štúdie klinickej rozhodovacej podpory ukazujú zmiešané výsledky: niektoré pozorovali skrátenie hospitalizácie a mierny pokles mortality, no v randomizovanej štúdii so <strong>6 030 pacientmi</strong> nebol pri AKI preukázaný prínos push notifikácií/alertov v EHR ani pre dĺžku hospitalizácie, ani pre mortalitu.</li>
</ul>

<p>Praktický význam: AI môže pomôcť identifikovať nielen samotné AKI, ale aj pacientov s vyšším rizikom, aby sa spustil včasný intervenčný plán. Dôraz sa kladie aj na možnosti <strong>NLP</strong> (spracovanie textu v klinických poznámkach), ktoré dokážu vyťažiť informácie z dokumentácie nad rámec izolovaných laboratórnych hodnôt.</p>

<h3>2) Chronická choroba obličiek (CKD): skoré rozpoznanie a odhad progresie</h3>

<p>CKD ostáva v praxi poddiagnostikovaná a podhlásená, čiastočne aj pre nedostatok nákladovo efektívnych skríningových postupov a pre variabilitu v odosielaní na nefrológiu (odlišné prahy a vzory podľa GFR).</p>

<p>AI môže pomôcť najmä pri:</p>

<ul>
  <li><strong>detekcii CKD v raných fázach</strong>,</li>
  <li><strong>odhade rizika progresie</strong> (napríklad pri diabetickej chorobe obličiek),</li>
  <li><strong>predikcii komplikácií</strong> u diabetikov.</li>
</ul>

<p>Zo zdroja:</p>

<ul>
  <li>model založený na logistickej regresii predpovedal progresiu diabetickej nefropatie s približne <strong>71 % presnosťou</strong> s využitím albuminúrie a biomarkerov (vrátane napr. močových L-type fatty acid-binding proteínov a sérového TNF-α),</li>
  <li>prístupy typu random forest sa používajú aj na detekciu retinopatie, neuropatie a nefropatie s uvádzanou presnosťou okolo <strong>0,838</strong>,</li>
  <li>spomína sa aj skríning vysokého rizika <strong>Fabryho choroby</strong> pomocou kombinácie fenotypových signálov a klinických charakteristík,</li>
  <li>uvádza sa viac modelov pre progresiu CKD vrátane systému s patentovaným prístupom (pulzové dáta) s uvádzanými C-štatistikami v horizontoch 1, 2 a 5 rokov (približne 0,84, 0,81 a 0,79),</li>
  <li>jeden komerčný model spomínaný v texte (KidneyIntelX) využíva plazmatické biomarkery, širokú paletu laboratórnych hodnôt, diagnózy, lieky a vitálne funkcie merané v troch časových bodoch; výkon sa udáva ako <strong>C-štatistika ~0,77</strong> a zdroj opisuje aj integráciu do EHR v rámci konkrétneho systému (Mount Sinai) a následnú ekonomickú analýzu s hypotézou úspory nákladov z menšieho počtu neplánovaných začatí dialýzy („crash starts“) a z pomalšej progresie DKD.</li>
</ul>

<p>Pointa pre klinika: AI môže podporiť včasné odoslanie na nefrológiu a umožniť cielenejšie rozvrstvenie rizika, čo je v súlade s posunom smerom k „value-based care“.</p>

<h3>3) Dialýza: predikcia udalostí a podpora výkonu</h3>

<p>Dialýza je v časti krajín vysoko štandardizovaná, najmä v centre. To znamená, že vzniká veľa dát vhodných pre ML: predpisy (čas liečby, ultrafiltrácia, prietok dialyzátu), lieky podané počas dialýzy a ďalšie parametre v digitálnej forme.</p>

<p>Najčastejšie smerovania AI v dialýze podľa textu:</p>

<ul>
  <li><strong>NLP nad EHR</strong>: identifikácia príznakov (napr. únava, bolesť, nauzea alebo vracanie) a porovnanie výstupu s kódovaním podľa klasifikácií,</li>
  <li><strong>predikcia intradialyzačnej hypotenzie</strong> pomocou rekurentných neurónových sietí a modelov, ktoré sa porovnávajú s logistickou regresiou a boosting prístupmi,</li>
  <li><strong>predikcia hospitalizácie</strong> u ambulantných hemodialyzovaných pacientov s následnou intervenciou interdisciplinárnym tímom,</li>
  <li><strong>odhad mortality</strong> napríklad cez Coxov model so súborom klinických parametrov (vek, kreatinín, draslík, hemoglobín, albumín, diabetes, Kt/V a ďalšie).</li>
</ul>

<p>Zaujímavé je, že hoci dialýza prináša vhodné dáta, AI sa zatiaľ rutinne nepoužíva široko (s výnimkami, napríklad v oblasti anémie). Zdroj dáva do popredia dôvody ako regulácia, ochrana súkromia a náročnosť integrácie do každodenného procesu.</p>

<h3>4) Transplantácia obličky: alokácia, párovanie darcu a príjemcu, patológia</h3>

<p>Transplantácia je „multidimenzionálna“ medicínska oblasť. AI sa v texte spomína naprieč:</p>

<ul>
  <li>alokáciou orgánov,</li>
  <li>imunosupresívnou liečbou,</li>
  <li>zobrazovaním a hodnotením patológie štepu,</li>
  <li>párovaním darcu a príjemcu (donor-recipient matching).</li>
</ul>

<p>Konkrétne príklady z článku:</p>

<ul>
  <li>existuje predikčný systém „iBox“ na odhad dlhodobého rizika zlyhania štepu, ktorý v uvedenom porovnaní predpovedal lepšie než nefrológovia a bol tiež externe validovaný v štúdiách v USA a Európe,</li>
  <li>pri alokácii a spravodlivosti zdroj spomína koncepty a rámce, ktoré sa snažia riešiť nerovnosti v prístupe k transplantáciám. Ako príklad sa uvádza aj kontinuálne bodové priraďovanie pri alokácii pľúc s možným dopadom ako „primer“ pre iné orgány,</li>
  <li>párovanie darcu a príjemcu: uvádza sa online nástroj na rozhodovanie o prijatí alebo odmietnutí „marginálnych“ ponúk na základe očakávaného posttransplantačného prežívania a indexu Kidney Donor Profile Index,</li>
  <li>okrem obličiek sa v texte spomína aj použitie modelov prežívania v kontexte transplantácie pečene u diabetikov a vplyv diabetu na mortalitu.</li>
</ul>

<h3>5) Zobrazovanie a patológia: automatizácia „tvrdej“ diagnostiky</h3>

<p>V texte sa spomína aj AI v oblasti:</p>

<ul>
  <li>automatického hodnotenia glomerulárnych lézií pri lupusovej nefritíde cez hlboké konvolučné neurónové siete (CNN),</li>
  <li>klasifikácie ochorení cez viacúlohové prístupy (multitask učenie s CNN),</li>
  <li>rozlišovania benígnych a malígnych lézií na rutinnom MR zobrazení cez architektúry typu ResNet v ensemble prístupe,</li>
  <li>segmentácie objemov pri ADPKD pomocou algoritmov, ktoré sa porovnávajú s medzipozorovateľskou variabilitou.</li>
</ul>

<p>Klinicky je to dôležité v tom, že ide o oblasti s vysokým podielom subjektívnej interpretácie. AI môže pomôcť spraviť hodnotenie konzistentnejším, ak je validované a nasadené bezpečným spôsobom.</p>

<hr>

<h2>Najväčšie prekážky implementácie AI v medicíne</h2>

<h3>Bias a nerovnosti v dátach</h3>

<p>AI môže preberať skreslenia už na úrovni zberu a spracovania dát. Zdroj explicitne uvádza príklady ako rozdiely v praxi pri výpočtoch GFR s rasovými úpravami a možný dopad na včasné zachytenie a starostlivosť u černošských pacientov.</p>

<h3>Kvalita dát: heterogenita, chýbajúce údaje, rozdiely medzi EHR platformami</h3>

<p>V medicínskych dátach často chýbajú podstatné hodnoty, údaje bývajú neštandardizované a rozptýlené naprieč dokumentáciou a EHR systémami. Výsledkom môže byť slabšia generalizácia a zhoršené fungovanie modelu v skupinách, ktoré boli podreprezentované.</p>

<p>Zdroj spomína aj praktický smer: integráciu AI do EHR tak, aby sa dáta zbierali konzistentnejšie v reálnom čase a spracovali sa ešte pred vstupom do modelu.</p>

<h3>„Black box“ a transparentnosť</h3>

<p>Ak model nevysvetlí, ako dospel k rozhodnutiu, vzniká problém dôvery. V medicíne to nie je len akademická nevýhoda. Keď ide o rozhodovanie o rizikách či liečbe, transparentnosť je kľúčová.</p>

<h3>Bezpečnosť: zmeny v realite menia distribúciu</h3>

<p>Model trénovaný na jednej „distribúcii“ dát môže zlyhávať vtedy, keď sa zmenia podmienky v praxi (distribution shift). Zdroj uvádza, že sa to dá čiastočne zmierniť trénovaním na viacerých distribúciách a naučením modelu, ako reagovať v situáciách mimo tréningového rozsahu.</p>

<h3>Zodpovednosť a etika</h3>

<p>V texte sa spomína regulácia v USA cez rámce pre AI ako softvér v role medicínskeho zariadenia (v odkaze na FDA) a zároveň etické otázky: kto nesie zodpovednosť za škodu, transparentnosť, férovosť algoritmu a súkromie dát. Otvára sa aj téma, že AI môže vstupovať do rozhodnutí mimo kliniky, napríklad pri schvaľovaní liečby poisťovňami, čo môže komplikovať nezávislé klinické rozhodovanie a účasť pacienta.</p>

<hr>

<h2>Budúcnosť ML v nefrológii: tréning, validácia a „evidence“ z reálneho sveta</h2>

<p>Zdroj zdôrazňuje, že AI je v nefrológii stále nedostatočne využívaná a potrebuje viac validácií. Zároveň si všíma význam vzdelávania: väčšina tréningu klinikov v EHR pokrýva základné zaznamenávanie, nie porozumenie životnému cyklu dát (čo sa zbiera, ako sa to normalizuje, čo model „vidí“).</p>

<p>Pri posune k value-based care môže AI fungovať ako „force multiplier“: ušetriť čas pri dokumentácii, znížiť administratívnu záťaž a umožniť viac času na priamu starostlivosť.</p>

<p>V oblasti klinických štúdií sa spomína využitie ML na generovanie reálnej evidencie z real-world dát, prípadne syntetické kontrolné ramená a zrýchlenie procesov cez automatizované vyhodnocovanie obrázkov a skenov.</p>

<h2>Záver</h2>

<p>AI má potenciál výrazne zmeniť nefrologickú starostlivosť: skoré odhalenie AKI, presnejší odhad progresie CKD, podporu dialyzačných rozhodnutí, pomoc v transplantácii a automatizáciu časti diagnostiky v patológii a zobrazovaní. Zároveň však platí, že integrácia do klinickej praxe nie je len otázkou „či to funguje“. Musia byť vyriešené bezpečnosť, férovosť, transparentnosť, zodpovednosť a ochrana súkromia. Najväčšiu praktickú výhodu budú mať tí, ktorí dokážu AI rozumne používať tak, aby zvyšovala kvalitu práce nefrológa, nie aby nahrádzala úsudkovú zložku medicíny.</p>

<hr>

<p><em><strong>Zdroj:</strong> Prehľadový (recenzný) článok na PMC. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11719832/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
