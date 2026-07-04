<?php
/**
 * add_cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao_article.php"
 * ════════════════════════════════════════════════════════════════════════════
 *
 * Pôvodní autori: článok je PÔVODNÁ SYNTÉZA z viacerých overených zdrojov
 * (PubMed/Crossref — autori a DOI overené pri tvorbe), nie spracovanie JEDNÉHO
 * zdrojového článku — preto ostáva pod autorom projektu a do source_authors.php
 * sa NEpridáva (v súlade s pravidlom v tom súbore). Všetky zdroje sú uvedené
 * s autormi a DOI v sekcii „Zdroje“ na konci obsahu.
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
    'title'        => 'Doplnky s cholínom a L-karnitínom pri diabetickej nefropatii: kedy môže TMAO vytvoriť začarovaný kruh',
    'slug'         => 'cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Doplnky s cholínom a L-karnitínom sú prekurzormi TMAO — urémického metabolitu, ktorý sa spája so zápalom, fibrózou a poškodením ciev aj obličiek. Mechanistické, preklinické a observačné dáta dávajú dôvod na opatrnosť pri suplementácii najmä u diabetikov s CKD, hoci kauzálny dôkaz zhoršenia tvrdých renálnych ukazovateľov zatiaľ chýba.',
    'content'      => <<<'HTML'
<p>U pacientov s diabetes mellitus 2. typu sa črevný mikrobióm čoraz viac chápe ako samostatný „metabolický orgán“, ktorý ovplyvňuje zápal, cievny endotel aj celkový metabolizmus. Jedným z mediátorov, ktorý sa opakovane spája s kardiometabolickým a renálnym rizikom, je <strong>trimetylamín-N-oxid (TMAO)</strong>. Klinicky zaujímavý je najmä praktický problém: <strong>doplnenie prekurzorov TMAO</strong> — predovšetkým <strong>cholínu</strong> a <strong>L-karnitínu</strong> — môže u niektorých pacientov zvýšiť jeho tvorbu na osi črevo – pečeň – cievy – obličky. Tento mechanistický rámec je podkladom hypotézy, že suplementácia môže nepriaznivo vplývať na progresiu <strong>diabetickej choroby obličiek</strong>.</p>

<p>Treba to však povedať férovo: v humánnej medicíne zatiaľ nie je etablovaný konsenzus, že by suplementácia cholínu alebo L-karnitínu v širokých populáciách diabetikov jednoznačne a kauzálne zhoršovala tvrdé renálne ukazovatele. Ide skôr o kombináciu <strong>mechanistických</strong>, <strong>preklinických</strong> a <strong>observačných</strong> dát, ktorá dáva klinicky rozumný dôvod na opatrnosť, najmä u pacientov s už prítomnou chronickou obličkovou chorobou (CKD).</p>

<h2>Mechanizmus: od cholínu a karnitínu k TMAO a poškodeniu obličiek</h2>

<h3>1. Premena v čreve a pečeni</h3>

<p>Prekurzory ako cholín, betaín a L-karnitín metabolizujú črevné baktérie na <strong>trimetylamín (TMA)</strong>. TMA sa následne v pečeni oxiduje — dominantne enzýmom flavín-obsahujúcej monooxygenázy 3 (FMO3) — na <strong>TMAO</strong>. Keďže prvý krok je podmienený činnosťou mikrobiómu, výsledná „citlivosť“ jednotlivca závisí od zloženia jeho črevnej flóry: pri rovnakom príjme prekurzorov môžu mať dvaja pacienti rozdielnu tvorbu TMAO.</p>

<h3>2. TMAO ako spúšťač zápalu cez NLRP3 inflamazóm</h3>

<p>V preklinických modeloch zvýšený TMAO podporuje aktiváciu zápalových dráh, najmä <strong>NLRP3 inflamazómu</strong>, čo vedie k tvorbe prozápalových cytokínov (napríklad IL-1β a IL-18). Tento mechanizmus je relevantný aj pre diabetické mikroprostredie obličiek, kde je pôda pre zápalovú odpoveď už pripravená. V klinickom jazyku: ak TMAO zosilní zápalový program v tubulárnom a intersticiálnom priestore, zvyšuje sa pravdepodobnosť progresie tubulointersticiálneho poškodenia.</p>

<h3>3. Fibróza cez os TGF-β/Smad3</h3>

<p>Chronický zápal typicky prechádza do remodelácie tkaniva. TMAO sa spája s aktiváciou profibrotickej signalizácie <strong>TGF-β/Smad3</strong>, ktorá podporuje nadmerné ukladanie kolagénu a rozvoj <strong>tubulointersticiálnej fibrózy</strong> — práve tá je pre progresiu CKD klinicky rozhodujúca. V zvieracích modeloch viedla chronická dietna expozícia cholínu a TMAO priamo k progresívnej tubulointersticiálnej fibróze a k poklesu funkcie obličiek.</p>

<h3>4. Endotelová dysfunkcia a strata mikrocirkulácie</h3>

<p>Diabetici majú cievny endotel poškodený už z podstaty ochorenia (mikroangiopatia, oxidačný stres, glykácia). TMAO môže endotelovú dysfunkciu ďalej zhoršovať, čo sa v obličkách prejaví ako zhoršenie perfúzie glomerulov a tým aj ďalší pokles funkcie.</p>

<h3>5. Znížené vylučovanie pri CKD vytvára kumulatívny efekt</h3>

<p>TMAO sa za fyziologických okolností vylučuje prevažne obličkami (glomerulárnou filtráciou). Pri CKD sa táto vylučovacia „brzda“ oslabuje, TMAO sa hromadí a jeho biologický signál pôsobí dlhšie. Merania to potvrdzujú: hladiny TMAO sú u pacientov s CKD výrazne vyššie než u ľudí so zachovanou funkciou obličiek. Vzniká tak potenciálny <strong>začarovaný kruh</strong> — zhoršená funkcia obličiek zvyšuje hladinu TMAO a vyšší TMAO môže prispievať k ďalšiemu poškodeniu obličiek.</p>

<h2>Kde je to klinicky najcitlivejšie: diabetik s CKD</h2>

<p>V observačných štúdiách u ľudí s diabetom 2. typu a CKD nachádzame vyššie hladiny TMAO než u diabetikov so zachovanou funkciou obličiek a tieto hladiny korelujú s horšími ukazovateľmi — napríklad s nižšou odhadovanou glomerulárnou filtráciou (eGFR) a s prítomnosťou albuminúrie či proteinúrie. Časť prác opisuje aj súvislosť medzi TMAO a markermi systémového zápalu a endotelovej dysfunkcie práve v populácii diabetikov s pokročilou CKD.</p>

<p>Dôležitá interpretačná poznámka pre prax: korelácia nie je dôkazom príčinnosti. V kombinácii s vierohodným mechanizmom však vytvára rozumný dôvod na klinickú opatrnosť pri predpisovaní doplnkov, ktoré sú prekurzormi TMAO.</p>

<h2>Čo hovoria priame dáta o suplementácii</h2>

<p>Najpresvedčivejší praktický argument prináša pozorovanie, že samotné dopĺňanie L-karnitínu dokáže hladinu TMAO reálne zvýšiť. V pilotnej štúdii u starších žien šesťmesačná suplementácia L-karnitínu niekoľkonásobne zvýšila hladinu TMAO v porovnaní s východiskovým stavom, pričom tréning ani suplementácia inej aminokyseliny takýto efekt nemali. Ide síce o malú štúdiu mimo nefrologickej populácie, no jasne ukazuje, že prekurzor podaný ako doplnok sa v tele skutočne premieta do vyššej tvorby TMAO.</p>

<h2>Praktické odporúčanie pre nefrologickú ambulanciu</h2>

<p>Ak sa v ambulancii rieši, či pacientovi ponechať alebo zaradiť doplnok s cholínom alebo L-karnitínom, odporúčam rozhodovať v troch krokoch.</p>

<h3>Krok 1: riziková vrstva podľa štádia CKD</h3>

<p>Čím nižšia je eGFR a čím vyššia je albuminúria, tým biologicky relevantnejšie sa javí riziko kumulácie TMAO. Pri pokročilej CKD by som suplementáciu prekurzormi TMAO považoval za zbytočné riziko, pokiaľ nie je jasne preukázaný benefit.</p>

<h3>Krok 2: dôvod suplementácie a očakávaný prínos</h3>

<p>Typické dôvody — únava, „fitness“ účely, podpora chudnutia či „metabolická energia“ — sú často založené skôr na všeobecnom marketingu doplnkov než na renálnej indikácii. Ak prínos nie je jasný, pri CKD je ťažké obhájiť vystavenie pacienta mechanizmu, ktorý môže zhoršovať zápal a fibrózu.</p>

<h3>Krok 3: kontrola liekov a metabolického profilu</h3>

<p>Do rozhodovania patrí aj prehľad ostatnej liečby:</p>

<ul>
  <li>liečba diabetu (napríklad SGLT2 inhibítory, agonisty GLP-1 receptora, metformín podľa hodnoty eGFR),</li>
  <li>liečba hypertenzie a proteinúrie (ACE inhibítory alebo sartany, prípadne ďalšia cielená liečba podľa štádia),</li>
  <li>celkový kardiovaskulárny plán.</li>
</ul>

<p>V praxi: ak pacient už dostáva nefroprotektívnu liečbu, doplnok na osi cholín/karnitín – TMAO môže byť práve ten malý dodatočný faktor, ktorý zvyšuje zápalové pozadie bez jasného protichodného prínosu.</p>

<h2>Ako to komunikovať pacientovi (bez paniky, ale jasne)</h2>

<p>Navrhovaná formulácia: „Niektoré doplnky, ktoré obsahujú cholín alebo L-karnitín, môžu u časti ľudí zvýšiť tvorbu látky nazývanej TMAO. Tá sa spája so zápalom a s poškodením ciev aj obličiek, preto u diabetikov s obličkovou chorobou tieto doplnky bez jasného dôvodu neodporúčame.“</p>

<h2>Čo zatiaľ nevieme (limitácie)</h2>

<p>Uvedený rámec je prevažne mechanistický a preklinický, doplnený observačnými dátami. Zostáva niekoľko otvorených otázok, ktoré treba držať na pamäti:</p>

<ul>
  <li>Korelácia medzi TMAO a horšou funkciou obličiek <strong>nie je dôkazom kauzality</strong>; vyššie hladiny TMAO môžu byť z veľkej časti len <strong>dôsledkom</strong> zníženej exkrécie, nie jej príčinou.</li>
  <li>Nie všetky klinické dáta sú jednotné. V prospektívnej kohorte pacientov so stredne ťažkou až pokročilou CKD sa po zohľadnení zavádzajúcich faktorov ukázalo, že vyššie hladiny TMAO boli vysvetlené zhoršenou funkciou obličiek a <strong>neboli nezávislým prediktorom</strong> kardiovaskulárnych ani renálnych výsledkov; nezávislým rizikovým faktorom bol v tejto práci skôr betaín. Autori uzatvárajú, že TMAO nemusí byť vhodným terapeutickým cieľom u pacientov s už rozvinutou CKD.</li>
  <li>Chýbajú veľké randomizované štúdie, ktoré by priamo testovali, či obmedzenie prekurzorov TMAO alebo samotného TMAO zlepšuje tvrdé renálne ukazovatele u diabetikov.</li>
</ul>

<p>Preto je namieste primeraná opatrnosť, nie kategorické zákazy. Neexistuje dôvod strašiť pacientov TMAO z bežnej stravy; ide o rozvážne rozhodovanie pri <strong>doplnkoch výživy</strong>, ktoré cielene zvyšujú príjem prekurzorov.</p>

<h2>Záver</h2>

<p>Mechanistický a preklinický rámec naznačuje, že doplnky cholínu a L-karnitínu môžu u pacientov s diabetickou nefropatiou podporiť dráhu <strong>črevný mikrobióm → TMAO → zápal (NLRP3) → fibróza (TGF-β/Smad3) → endotelová dysfunkcia</strong>, pričom CKD zhoršuje elimináciu TMAO a môže vytvoriť kumulatívny efekt. Kľúčové je preto v praxi nastaviť opatrnosť pri suplementácii najmä u pacientov s nižšou eGFR a prítomnou albuminúriou — a zároveň korektne priznať, že priamy kauzálny dôkaz na tvrdých renálnych ukazovateľoch zatiaľ chýba.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Tang WHW, Wang Z, Kennedy DJ, Wu Y, Buffa JA, Agatisa-Boyle B, Li XS, Levison BS, Hazen SL. <em>Gut microbiota-dependent trimethylamine N-oxide (TMAO) pathway contributes to both development of renal insufficiency and mortality risk in chronic kidney disease.</em> Circ Res (2015). <a href="https://doi.org/10.1161/CIRCRESAHA.116.305360" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Su JQ, Wu XQ, Wang Q, Xie BY, Xiao CY, Su HY, Tang JX, Yao CW. <em>The microbial metabolite trimethylamine N-oxide and the kidney diseases.</em> Front Cell Infect Microbiol (2025). <a href="https://doi.org/10.3389/fcimb.2025.1488264" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Lei Y, Xiong G, Lei D, Wu H, Peng X, Chen L, Fang Q, Wu Y, Wu Y, Li X, Li Y. <em>Gut microbiota-derived TMAO drives the kidney-bone-vascular axis in chronic kidney disease complications.</em> Ren Fail (2025). <a href="https://doi.org/10.1080/0886022X.2025.2575434" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Wang S, Ni Y, Zhou S, Peng H, Cao Y, Zhu Y, Gong J, Lu Q, Han Z, Lin Y, Wang Y. <em>Effects of choline metabolite-trimethylamine N-oxide on immunometabolism in inflammatory bowel disease.</em> Front Immunol (2025). <a href="https://doi.org/10.3389/fimmu.2025.1591151" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Bordoni L, Sawicka AK, Szarmach A, Winklewski PJ, Olek RA, Gabbianelli R. <em>A Pilot Study on the Effects of l-Carnitine and Trimethylamine-N-Oxide on Platelet Mitochondrial DNA Methylation and CVD Biomarkers in Aged Women.</em> Int J Mol Sci (2020). <a href="https://doi.org/10.3390/ijms21031047" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Fogelman AM. <em>TMAO is both a biomarker and a renal toxin.</em> Circ Res (2015). <a href="https://doi.org/10.1161/CIRCRESAHA.114.305680" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Al-Obaide MAI, Singh R, Datta P, Rewers-Felkins KA, Salguero MV, Al-Obaidi I, Kottapalli KR, Vasylyeva TL. <em>Gut Microbiota-Dependent Trimethylamine-N-oxide and Serum Biomarkers in Patients with T2DM and Advanced CKD.</em> J Clin Med (2017). <a href="https://doi.org/10.3390/jcm6090086" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Kalagi NA, Thota RN, Stojanovski E, Alburikan KA, Garg ML. <em>Plasma Trimethylamine N-Oxide Levels Are Associated with Poor Kidney Function in People with Type 2 Diabetes.</em> Nutrients (2023). <a href="https://doi.org/10.3390/nu15040812" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Zeng Y, Guo M, Fang X, Teng F, Tan X, Li X, Wang M, Long Y, Xu Y. <em>Gut Microbiota-Derived Trimethylamine N-Oxide and Kidney Function: A Systematic Review and Meta-Analysis.</em> Adv Nutr (2021). <a href="https://doi.org/10.1093/advances/nmab010" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Obeid R, Awwad H, Heine GH, Emrich IE, Fliser D, Zawada AM, Geisel J. <em>Plasma Concentrations of Trimethylamine-N-Oxide, Choline, and Betaine in Patients With Moderate to Advanced Chronic Kidney Disease and Their Relation to Cardiovascular and Renal Outcomes.</em> J Ren Nutr (2024). <a href="https://doi.org/10.1053/j.jrn.2024.03.009" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em>Zdroje boli dohľadané a overené cez PubMed a Crossref (autori a DOI). Zdroj identifikátorov: <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
