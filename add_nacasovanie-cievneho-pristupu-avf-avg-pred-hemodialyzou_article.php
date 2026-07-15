<?php
/**
 * add_nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou_article.php
 * Odborný článok o načasovaní vytvorenia AVF a AVG pred začatím hemodialýzy.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Načasovanie cievneho prístupu pred hemodialýzou: AVF potrebuje väčší predstih než AVG',
    'slug'         => 'nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kórejská kohorta 24 713 pacientov spájala vytvorenie AVF menej než 3 mesiace a AVG menej než 1 mesiac pred hemodialýzou s horšími výsledkami; nejde však o univerzálny termín výkonu.',
    'content'      => <<<'HTML'
<p>Načasovanie cievneho prístupu pred začatím hemodialýzy je rozhodovanie pod neistotou. Neskorý výkon môže viesť k začatiu liečby cez centrálny venózny katéter, kým príliš skorý výkon vystavuje pacienta riziku operácie a komplikácií prístupu, ktorý napokon nemusí nikdy použiť.</p>

<p>Yoon a spoluautori analyzovali celoštátne kórejské údaje a ukázali, že asociácia medzi predstihom vytvorenia prístupu a výsledkami sa líši podľa jeho typu. Pri arteriovenóznej fistule (AVF) boli menej priaznivé výsledky spojené s vytvorením menej než tri mesiace pred hemodialýzou. Pri arteriovenóznom grafte (AVG; cievnej protéze) sa väčšina nepriaznivých asociácií sústreďovala do posledného mesiaca.</p>

<p>Štúdia podporuje včasné a individualizované plánovanie, nie pevný kalendárny predpis. Odhadovaný začiatok hemodialýzy nie je presný dátum a observačné pomery šancí či rizík nepreukazujú, že samotné skoršie vytvorenie prístupu spôsobilo lepší výsledok.</p>

<h2>Prečo AVF a AVG potrebujú rozdielny predstih</h2>

<p>Po chirurgickom spojení artérie a žily musí AVF dozrieť: odtoková žila sa remodeluje, zväčší sa jej priemer a prietok a vytvorí sa úsek vhodný na opakované kanylácie. Maturácia trvá týždne až mesiace a môže zlyhať. Plán preto musí ponechať čas na klinickú kontrolu, podľa potreby ultrazvuk a prípadnú chirurgickú alebo endovaskulárnu korekciu.</p>

<p>AVG používa syntetický alebo biologický cievny segment a zvyčajne sa dá kanylovať skôr. Štandardný AVG však potrebuje zahojenie okolitých tkanív; graft určený na skorú kanyláciu možno použiť skôr, keď to umožní hojenie rany. Rozdiel medzi AVF a AVG preto nie je iba v názve, ale v čase potrebnom na získanie použiteľného prístupu aj v profile komplikácií.</p>

<h2>Ako bola kohorta zostavená</h2>

<p>Autori použili databázu Korean National Health Insurance Service. Zaradili pacientov, ktorí začali hemodialýzu v roku 2013 a AVF alebo AVG im vytvorili ešte pred jej začatím. Celkovo analyzovali 24 713 osôb: 20 894 s AVF a 3 819 s AVG.</p>

<p>Interval od vytvorenia prístupu po začatie hemodialýzy rozdelili do šiestich kategórií: menej než 1 mesiac, 1 až menej než 3 mesiace, 3 až menej než 6 mesiacov, 6 až menej než 9 mesiacov, 9 až menej než 12 mesiacov a 12 až 24 mesiacov. Referenčnou kategóriou bolo 6 až menej než 9 mesiacov.</p>

<p>Hodnotili použitie katétra pri začatí hemodialýzy, stratu primárnej a sekundárnej priechodnosti prístupu a celkovú mortalitu. Výsledky analyzovali oddelene pre AVF a AVG.</p>

<div class="table-responsive" role="region" aria-label="Výsledky podľa typu a načasovania cievneho prístupu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Prístup a interval</th>
      <th scope="col">Výsledok oproti referencii 6 až &lt;9 mesiacov</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>AVF, &lt;1 mesiac</td>
      <td>Použitie katétra: OR 14,03; strata primárnej priechodnosti: HR 2,64; sekundárnej priechodnosti: HR 4,56; mortalita: HR 1,67</td>
      <td>Najvýraznejšie nepriaznivé asociácie pri AVF</td>
    </tr>
    <tr>
      <td>AVF, 1 až &lt;3 mesiace</td>
      <td>Použitie katétra: OR 1,85; strata primárnej priechodnosti: HR 1,16; sekundárnej priechodnosti: HR 1,12; mortalita: HR 1,25</td>
      <td>Aj tento kratší predstih bol spojený s menej priaznivými výsledkami</td>
    </tr>
    <tr>
      <td>AVG, &lt;1 mesiac</td>
      <td>Použitie katétra: OR 8,45; strata primárnej priechodnosti: HR 1,97; sekundárnej priechodnosti: HR 2,06; mortalita: HR 1,43</td>
      <td>Väčšina nepriaznivých asociácií pri AVG sa sústreďovala sem</td>
    </tr>
    <tr>
      <td>AVG, 1 až &lt;3 mesiace</td>
      <td>Vyššia strata primárnej priechodnosti; abstrakt neuvádza číselný odhad</td>
      <td>Ostatné výsledky nevykazovali rovnaký nepriaznivý vzorec ako interval &lt;1 mesiac</td>
    </tr>
  </tbody>
</table>
</div>

<p>OR je pomer šancí a HR pomer okamžitých rizík. OR 14,03 preto nie je správne označiť ako „14-násobné riziko“. Bez absolútnych počtov udalostí navyše nemožno z abstraktu vypočítať absolútny prínos skoršieho výkonu pre konkrétneho pacienta.</p>

<h2>Čo štúdia podporuje pri AVF</h2>

<p>Pri AVF boli oba intervaly kratšie než tri mesiace spojené s častejším použitím katétra, stratou priechodnosti aj úmrtím oproti referenčnej kategórii. Výsledok podporuje vytvorenie AVF s predstihom aspoň približne troch mesiacov, keď je budúca potreba hemodialýzy dostatočne pravdepodobná.</p>

<p>Trojmesačný interval však nie je biologická hranica ani záruka úspešnej maturácie. Niektorá AVF je použiteľná skôr, iná potrebuje dlhší čas alebo korekciu a časť fistúl nikdy nedozrie. Naopak, u pacienta s neistou progresiou, vysokým konkurenčným rizikom úmrtia alebo pravdepodobnou preemptívnou transplantáciou môže veľmi skorá operácia priniesť viac záťaže než úžitku.</p>

<h2>Čo štúdia podporuje pri AVG</h2>

<p>Pri AVG sa nepriaznivé asociácie pri väčšine výsledkov sústreďovali na vytvorenie v poslednom mesiaci pred hemodialýzou. To je zlučiteľné s kratším časom potrebným do použitia graftu, ale neznamená to, že každý AVG má byť vytvorený presne mesiac vopred.</p>

<p>AVG môže byť rozumnou súčasťou individuálneho plánu pri nevhodnej anatómii pre AVF, vysokej pravdepodobnosti zlyhania jej maturácie alebo kratšom očakávanom čase do dialýzy. Rozhoduje aj typ graftu, skúsenosť pracoviska, riziko infekcie a trombózy, predchádzajúce prístupy a preferencie pacienta.</p>

<h2>Nezamieňať vytvorenie prístupu s prvou kanyláciou</h2>

<p>Kórejská štúdia hodnotila čas od operácie po začatie hemodialýzy. Neurčovala najskorší bezpečný deň prvej kanylácie. Ide o dve súvisiace, ale odlišné otázky.</p>

<p>Európske odporúčanie pre dospelých uvádza, že klinicky vhodnú AVF možno kanylovať od štyroch týždňov po vytvorení, neodporúča kanyláciu pred dvoma týždňami a medzi druhým a štvrtým týždňom ju pripúšťa najmä vtedy, ak sa tým predíde katétru. Pri štandardnom AVG odporúča spravidla počkať aspoň dva týždne; AVG určený na skorú kanyláciu možno použiť po primeranom zahojení rany.</p>

<p>Novú AVF treba klinicky skontrolovať a pri pochybnosti doplniť ultrazvuk. Európske odporúčanie zdôrazňuje kontrolu maturácie približne o 4–6 týždňov, aby sa oneskorenie alebo zlyhanie rozpoznalo včas.</p>

<h2>Od kalendára k ESKD Life-Plan</h2>

<p>KDOQI 2019 opustilo univerzálnu stratégiu „fistula first“ v prospech individuálneho ESKD Life-Plan. Typ a poradie prístupov sa majú prispôsobiť očakávanej modalite, prognóze, anatómii, predchádzajúcim prístupom a cieľom pacienta. Plán zahŕňa aj transplantáciu, peritoneálnu dialýzu, konzervatívnu starostlivosť a následný prístup pre prípad zlyhania prvého.</p>

<p>Pri pokročilej CKD pomáha riziko zlyhania obličiek, trend eGFR a klinický priebeh. KDIGO 2024 uvádza dvojročné riziko zlyhania obličiek nad 40 % ako jeden z podkladov na edukáciu o modalite a prípravu cievneho prístupu. Prah nie je automatickým pokynom na operáciu; treba ho spojiť s rýchlosťou progresie, albuminúriou, komorbiditami a preferenciami pacienta.</p>

<p>Rozhodovanie má nadväzovať na včasnú <a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">predialyzačnú edukáciu a skutočnú voľbu modality</a>, nie začať až objednaním cievneho chirurga.</p>

<h2>Praktický postup</h2>

<ol>
  <li><strong>Pravidelne prehodnocovať prognózu:</strong> sledovať trend eGFR, riziko zlyhania obličiek, urémiu, objemový stav a metabolické komplikácie.</li>
  <li><strong>Najprv dohodnúť modalitu:</strong> prebrať transplantáciu, peritoneálnu dialýzu, hemodialýzu aj konzervatívnu starostlivosť.</li>
  <li><strong>Chrániť žily:</strong> periférne kanyly a periférne zavádzané centrálne katétre koordinovať s nefrológom.</li>
  <li><strong>Vybrať prístup podľa pacienta:</strong> klinicky posúdiť cievy a ultrazvukové mapovanie použiť podľa rizika, anatómie a lokálneho postupu.</li>
  <li><strong>Ponechať rezervu:</strong> pri AVF počítať s maturáciou a možnou korekciou; pri kratšom horizonte zvážiť vhodný AVG alebo inú premosťujúcu stratégiu.</li>
  <li><strong>Po výkone aktívne sledovať:</strong> kontrolovať ranu, šelest a vír, včas rozpoznať nematurujúcu AVF a kanylovať až po zhodnotení vhodnosti.</li>
</ol>

<h2>Limity štúdie</h2>

<ul>
  <li>retrospektívny observačný dizajn neumožňuje preukázať kauzalitu,</li>
  <li>administratívne údaje nemusia zachytiť cievnu anatómiu, dôvod voľby prístupu, naliehavosť štartu ani všetky intervencie,</li>
  <li>neskorý výkon môže byť markerom rýchlej progresie, akútneho zhoršenia, neskorého odoslania alebo vyššej chorobnosti,</li>
  <li>zaradení boli iba pacienti, ktorí začali hemodialýzu a mali prístup vytvorený vopred; výsledky nehodnotia ľudí s nepotrebným alebo nikdy nepoužitým prístupom,</li>
  <li>výsledky pacientov z Južnej Kórey, ktorí začali dialýzu v roku 2013, nemusia byť priamo prenosné na dnešné slovenské podmienky,</li>
  <li>abstrakt neposkytuje absolútne riziká ani podrobný výsledok každej časovej kategórie.</li>
</ul>

<h2>Záver</h2>

<p>V celoštátnej kórejskej kohorte bolo vytvorenie AVF menej než tri mesiace pred začatím hemodialýzy spojené s častejším použitím katétra, stratou priechodnosti a mortalitou. Pri AVG sa väčšina nepriaznivých asociácií sústreďovala na interval kratší než jeden mesiac.</p>

<p>Najprimeranejším záverom nie je „AVF presne tri mesiace a AVG presne mesiac vopred“. Potrebný je včasný, opakovane aktualizovaný ESKD Life-Plan, výber prístupu podľa konkrétneho pacienta a po operácii aktívne hodnotenie jeho pripravenosti na kanyláciu.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Yoon J, Shon K, Park HC, et al. Access Type-Specific Vascular Access Creation Timing in Incident Hemodialysis: A Nationwide Cohort Study. <em>American Journal of Nephrology</em>. Publikované online 14. júla 2026. DOI: 10.1159/000553533. <a href="https://karger.com/ajn/article-abstract/doi/10.1159/000553533/952474/Access-Type-Specific-Vascular-Access-Creation" target="_blank" rel="noopener noreferrer">Karger</a> · <a href="https://doi.org/10.1159/000553533" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>KDOQI:</strong> Lok CE, Huber TS, Lee T, et al. KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update. <em>American Journal of Kidney Diseases</em>. 2020;75(4 Suppl 2):S1–S164. <a href="https://pubmed.ncbi.nlm.nih.gov/32778223/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Európske odporúčanie:</strong> Gallieni M, Hollenbeck M, Inston N, et al. Clinical practice guideline on peri- and postoperative care of arteriovenous fistulas and grafts for haemodialysis in adults. <em>Nephrology Dialysis Transplantation</em>. 2019;34(Suppl 2):ii1–ii42. <a href="https://academic.oup.com/ndt/article/34/Supplement_2/ii1/5514502" target="_blank" rel="noopener noreferrer">Oxford Academic</a>.</em></p>

<p><em><strong>Prognostický kontext:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></p>
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
                error_log('add_nacasovanie_cievneho_pristupu newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_nacasovanie_cievneho_pristupu pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_nacasovanie_cievneho_pristupu pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_nacasovanie_cievneho_pristupu migration error: ' . $e->getMessage());
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
