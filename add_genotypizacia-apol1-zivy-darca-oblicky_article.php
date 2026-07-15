<?php
/**
 * add_genotypizacia-apol1-zivy-darca-oblicky_article.php
 * Odborný článok o genotypizácii APOL1 pri živom darovaní obličky.
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
    'title'        => 'Genotypizácia APOL1 pri živom darovaní obličky: presnejšia stratifikácia, nie automatické vylúčenie',
    'slug'         => 'genotypizacia-apol1-zivy-darca-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia s mediánom sledovania 18,5 roka spája dve rizikové alely APOL1 s nižšou funkciou obličiek po darovaní. Čo výsledok znamená pre výber, súhlas a sledovanie darcu.',
    'content'      => <<<'HTML'
<p>Darovanie obličky od živého darcu prináša príjemcovi významný klinický prínos, zároveň však zaväzuje transplantačný tím čo najpresnejšie posúdiť celoživotné zdravotné riziko zdravého človeka, ktorý z darovania nemá medicínsky prospech. Osobitne citlivou otázkou je dlhodobé renálne riziko u osôb s nedávnym africkým genetickým pôvodom, u ktorých sa častejšie vyskytujú rizikové varianty génu <strong>APOL1</strong>.</p>

<p>Americká retrospektívna kohortová štúdia Living Donor Extended Time Outcomes (LETO), publikovaná v <em>JAMA Internal Medicine</em>, zistila, že darcovia s dvoma rizikovými alelami APOL1 mali takmer dve desaťročia po darovaní viac než dvojnásobné neupravené relatívne riziko eGFR &lt;45 ml/min/1,73 m<sup>2</sup> oproti darcom s nulou alebo jednou rizikovou alelou. Po zohľadnení eGFR pred darovaním sa však odhad znížil a štatistická významnosť sa stratila.</p>

<p>Výsledok preto podporuje <strong>geneticky presnejšiu stratifikáciu a informovaný dialóg</strong>, nie automatické vylúčenie kandidáta. Zároveň pripomína, že genotypizácia nemôže nahradiť dôkladné klinické vyšetrenie ani presne vyčísliť individuálne riziko zlyhania obličiek po nefrektómii.</p>

<h2>Čo je APOL1 a koho sa rizikové varianty týkajú</h2>

<p>Gén <strong>APOL1</strong> kóduje apolipoproteín L1, súčasť vrodenej obrany proti niektorým africkým trypanozómam. Rizikové haplotypy G1 a G2 vznikli a rozšírili sa najmä v populáciách zo západnej a strednej subsaharskej Afriky, pravdepodobne pre selekčnú výhodu proti trypanozomálnej infekcii. V dôsledku migrácie a genetického miešania sa môžu vyskytovať aj u ľudí, ktorí sa identifikujú ako Afroameričania, Afrokaribčania, Afrolatinoameričania alebo patria k ďalším populáciám s nedávnym africkým pôvodom.</p>

<p>Vysokorizikový genotyp sa v klinických štúdiách najčastejšie definuje prítomnosťou <strong>dvoch rizikových alel</strong>:</p>

<ul>
  <li>G1/G1,</li>
  <li>G1/G2,</li>
  <li>G2/G2.</li>
</ul>

<p>Nula alebo jedna riziková alela sa v tomto recesívnom modeli označuje ako nízkorizikový genotyp. Neznamená to však nulové celoživotné riziko CKD. Rovnako ani dve rizikové alely nie sú diagnózou a nevedú nevyhnutne k ochoreniu. Penetrancia je neúplná a klinický fenotyp pravdepodobne ovplyvňujú ďalšie genetické modifikátory a takzvané druhé zásahy, napríklad vírusové infekcie alebo výrazná aktivácia interferónových dráh.</p>

<p>Vysokorizikový genotyp je spojený najmä so spektrom APOL1-asociovaných nefropatií, ku ktorým patria fokálna segmentálna glomeruloskleróza, kolabujúca glomerulopatia, HIV-asociovaná nefropatia a časť ochorení v minulosti označovaných ako hypertenzná nefroskleróza. Nemožno ho však bez ďalších dôkazov považovať za vysvetlenie každej CKD u človeka afrického pôvodu.</p>

<h2>Rasa, pôvod a genotyp nie sú synonymá</h2>

<p>Štúdia pracovala s americkými registračnými kategóriami <em>Black</em> a <em>White</em>. Tieto sociálne a administratívne kategórie nemožno stotožniť s konkrétnym genetickým pôvodom. Nie každý človek zaradený ako Black nesie rizikovú alelu APOL1 a rizikový genotyp sa môže vyskytnúť aj u človeka, ktorého vzhľad alebo úradná kategória by k testovaniu neviedli.</p>

<p>KDIGO preto odporúča používať presnú terminológiu a neprehlbovať zámeny medzi rasou, etnicitou, pôvodom a genotypom. Pri rozhodovaní o ponuke testu je biologicky informatívnejší nedávny pôvod zo subsaharskej Afriky alebo populácie s vysokým podielom takéhoto pôvodu než samotná farba kože či administratívne zaradenie.</p>

<h2>Ako bola štúdia LETO navrhnutá</h2>

<p>Výskumníci vychádzali z údajov Scientific Registry of Transplant Recipients o živých darcoch obličky v USA, ktorí darovali od januára 2000 do decembra 2008. Po aktualizácii kontaktných údajov pozvali na účasť darcov registrovaných ako Black alebo White. Domáce výskumné návštevy sa uskutočnili od marca 2020 do marca 2024 a finálna analýza prebiehala do februára 2026.</p>

<div class="table-responsive" role="region" aria-label="Základné charakteristiky kohorty LETO" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Ukazovateľ</th>
      <th>Darcovia v kategórii Black</th>
      <th>Darcovia v kategórii White</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Počet účastníkov</td>
      <td>445</td>
      <td>208</td>
    </tr>
    <tr>
      <td>Priemerný vek pri darovaní</td>
      <td>38 rokov</td>
      <td>44 rokov</td>
    </tr>
    <tr>
      <td>Podiel žien</td>
      <td>66 %</td>
      <td>68 %</td>
    </tr>
    <tr>
      <td>Vysokorizikový genotyp APOL1</td>
      <td>68 z 445 (15,3 %)</td>
      <td>Nebol predmetom hlavného porovnania</td>
    </tr>
  </tbody>
</table>
</div>

<p>Medián intervalu medzi darovaním a domácou návštevou bol <strong>18,5 roka</strong> (medzikvartilové rozpätie 16,9–20,5 roka). Primárnym výsledkom bola kreatinínová eGFR &lt;45 ml/min/1,73 m<sup>2</sup> pri tejto návšteve. Medzi ďalšie výsledky patrili eGFR &lt;60 ml/min/1,73 m<sup>2</sup>, UACR ≥30 mg/g alebo ≥300 mg/g a artériová hypertenzia.</p>

<p>Primárny výsledok je klinicky relevantným prahom zodpovedajúcim kategórii G3b, ale v tejto štúdii išlo o <strong>jedno meranie</strong>. Nie je preto totožný s potvrdenou CKD G3b, ktorá vyžaduje pretrvávanie abnormality najmenej tri mesiace, a už vôbec nie so zlyhaním obličiek.</p>

<h2>Hlavné výsledky</h2>

<p>eGFR &lt;45 ml/min/1,73 m<sup>2</sup> malo 46 zo všetkých 653 účastníkov (7,0 %). Medzi 445 darcami v kategórii Black sa tento výsledok vyskytol u 7,6 %. Rozdiel podľa genotypu bol výrazný:</p>

<div class="table-responsive" role="region" aria-label="Hlavný výsledok podľa genotypu APOL1" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Analýza primárneho výsledku</th>
      <th>Výsledok</th>
      <th>Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>eGFR &lt;45: vysokorizikový verzus nízkorizikový genotyp</td>
      <td>14,7 % verzus 6,4 %</td>
      <td>Absolútny rozdiel 8,3 percentuálneho bodu</td>
    </tr>
    <tr>
      <td>Neupravený relatívny rozdiel</td>
      <td>RR 2,31; 95 % IS 1,16–4,61; p = 0,02</td>
      <td>Štatisticky významná asociácia</td>
    </tr>
    <tr>
      <td>Po úprave na eGFR pred darovaním</td>
      <td>RR 1,91; 95 % IS 0,90–4,03; p = 0,09</td>
      <td>Bodový odhad zostal zvýšený, interval však zahŕňal hodnotu 1, teda hodnotu bez rozdielu relatívnych rizík</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri sekundárnom výsledku eGFR &lt;60 ml/min/1,73 m<sup>2</sup> zostala podľa sprievodného redakčného komentára asociácia významná aj po zohľadnení eGFR pred darovaním (RR 1,50; 95 % IS 1,18–1,90). Vysokorizikový genotyp bol spojený aj s vyšším výskytom výraznej albuminúrie. Tieto sekundárne nálezy podporujú biologickú konzistentnosť signálu, nesmú však zatieniť neistotu primárnej upravenej analýzy.</p>

<p>Zlyhanie obličiek sa rozvinulo u troch darcov v kategórii Black, pričom jeden mal vysokorizikový genotyp. Takýto malý počet udalostí neumožňuje spoľahlivo odhadnúť genotypovo špecifické riziko zlyhania obličiek po darovaní.</p>

<h2>Čo znamená oslabenie asociácie po úprave</h2>

<p>Darcovia s vysokorizikovým genotypom mali už pred darovaním mierne odlišné ukazovatele funkcie obličiek. Po zahrnutí východiskovej eGFR pred darovaním do modelu kleslo relatívne riziko z 2,31 na 1,91 a 95 % interval spoľahlivosti zahŕňal hodnotu 1. To nie je dôkaz neprítomnosti rizika, výsledok však už nespĺňal konvenčnú hranicu štatistickej významnosti.</p>

<p>Možné vysvetlenia zahŕňajú skutočný vplyv východiskovej renálnej rezervy, čiastočné zachytenie skorého fenotypu APOL1, malý počet udalostí aj nedostatočnú štatistickú silu. Observačný dizajn nedokáže rozhodnúť, či je eGFR pred darovaním mätúcim faktorom, medzičlánkom biologického procesu alebo kombináciou oboch. Praktický odkaz je však jasný: <strong>genotyp treba vždy interpretovať spolu s presne zmeraným fenotypom pred darovaním</strong>.</p>

<h2>Čo štúdia nepreukázala</h2>

<ul>
  <li>Nešlo o randomizovanú štúdiu a asociácia sama osebe nepreukazuje kauzalitu.</li>
  <li>Jednorazové záverečné meranie neumožňuje presne opísať trajektóriu eGFR ani potvrdiť chronicitu u každého účastníka.</li>
  <li>Bez porovnateľnej skupiny ľudí s rovnakým genotypom, ktorí obličku nedarovali, nemožno oddeliť prirodzené riziko APOL1 od rizika pripísateľného nefrektómii.</li>
  <li>Účasť po približne dvoch desaťročiach mohla byť ovplyvnená nedostupnosťou, úmrtím alebo ochotou bývalých darcov zúčastniť sa, teda selekčným skreslením a efektom prežívajúcich.</li>
  <li>Vysokorizikový genotyp malo iba 68 darcov a prípadov zlyhania obličiek bolo veľmi málo.</li>
  <li>Výsledky americkej kohorty nemožno bez ďalšieho preniesť na všetky populácie, transplantačné programy ani jednotlivcov.</li>
</ul>

<h2>Od výsledku štúdie k odporúčaniu</h2>

<p>Autori LETO na základe veľkosti pozorovaného rozdielu navrhujú genotypizáciu všetkých amerických kandidátov na živé darovanie, ktorí sa identifikujú ako Black. Tento záver je legitímnou interpretáciou autorov, ale zatiaľ nie je univerzálnym medzinárodným štandardom.</p>

<p>Odporúčanie KDIGO pre živých darcov z roku 2017 uvádza, že genotypizáciu APOL1 <strong>možno ponúknuť</strong> kandidátom so subsaharským africkým pôvodom. Kandidát má dostať informáciu, že dve rizikové alely zvyšujú celoživotné riziko zlyhania obličiek, presné individuálne riziko po darovaní však nemožno spoľahlivo vyčísliť.</p>

<p>Konsenzus KDIGO o APOL1 z roku 2025 zdôrazňuje, že pri populačnom rutinnom skríningu stále chýba dostatok dôkazov. Individuálne testovanie má zmysel, ak:</p>

<ul>
  <li>je prítomný nedávny africký pôvod alebo iná populácia s vyššou prevalenciou rizikových variantov,</li>
  <li>výsledok môže zmeniť hodnotenie pomeru rizika a prínosu alebo intenzitu sledovania,</li>
  <li>je dostupné kvalifikované poradenstvo pred testom aj po ňom,</li>
  <li>kandidát dobrovoľne poskytne informovaný súhlas a test preňho nepredstavuje neprijateľnú ujmu.</li>
</ul>

<p>Rozdiel medzi „ponúknuť test“ a „automaticky testovať“ je eticky podstatný. Kandidát musí mať právo test prijať aj odmietnuť bez neprimeraného tlaku od príjemcu, rodiny alebo transplantačného tímu.</p>

<h2>Praktický postup pri kandidátovi na darovanie</h2>

<p>APOL1 je iba jedna vrstva komplexného hodnotenia. Pred rozhodnutím treba posúdiť najmä:</p>

<ul>
  <li>vek kandidáta a dĺžku budúceho obdobia rizika,</li>
  <li>eGFR a pri hraničnom alebo nejasnom výsledku potvrdenie GFR vhodnou metódou,</li>
  <li>UACR, močový sediment a opakovanie abnormálnych nálezov,</li>
  <li>krvný tlak vrátane ambulantného monitorovania pri nejasnej alebo variabilnej hypertenzii,</li>
  <li>BMI, glykémiu, diabetes, fajčenie a ďalšie metabolické riziká,</li>
  <li>rodinnú anamnézu CKD alebo zlyhania obličiek a príčinu ochorenia príjemcu, najmä pri biologicky príbuznej dvojici,</li>
  <li>psychosociálnu situáciu, dobrovoľnosť rozhodnutia a reálnu dostupnosť dlhodobého sledovania.</li>
</ul>

<p>Vysokorizikový genotyp nie je sám osebe synonymom zákazu darovania. U mladého kandidáta s hraničnou eGFR, albuminúriou, hypertenziou alebo výraznou rodinnou záťažou však môže posunúť celkové riziko nad hranicu prijateľnú pre konkrétny program alebo pre samotného kandidáta. Naopak, nízkorizikový genotyp môže odstrániť jednu z neistôt, ale nevymaže ostatné rizikové faktory.</p>

<h2>Genetické poradenstvo nie je formalita</h2>

<p>Pred testom treba vysvetliť jeho možný výsledok, neistú penetranciu a limity predikcie. Súčasťou rozhovoru majú byť aj možné dôsledky pre biologických príbuzných, súkromie genetických údajov, psychická záťaž, prípadné poistné alebo pracovnoprávne dôsledky podľa miestnej legislatívy a možnosť neočakávaného odhalenia rodinných vzťahov.</p>

<p>Po teste musí nasledovať interpretácia výsledku v klinickom kontexte. Oznámenie „máte rizikový gén“ bez vysvetlenia neúplnej penetrancie môže viesť k fatalizmu a stigmatizácii. Rovnako nebezpečné je označiť človeka s nulou alebo jednou rizikovou alelou za „bez rizika“. Rozhodnutie má byť zdokumentované ako spoločné a informované, nie ako izolovaný verdikt laboratória.</p>

<h2>Sledovanie po darovaní</h2>

<p>KDIGO odporúča každému živému darcovi individualizovaný plán následnej starostlivosti a najmenej raz ročne:</p>

<ul>
  <li>meranie krvného tlaku a BMI,</li>
  <li>stanovenie sérového kreatinínu s výpočtom eGFR,</li>
  <li>vyšetrenie albuminúrie,</li>
  <li>podporu zdravého životného štýlu vrátane pohybu, racionálnej výživy a nefajčenia,</li>
  <li>zhodnotenie psychosociálneho zdravia a celkovej pohody.</li>
</ul>

<p>Štúdia LETO neposkytuje validovaný harmonogram intenzívnejších kontrol podľa APOL1. Pri vysokorizikovom genotype je však rozumné zabezpečiť spoľahlivé celoživotné nefrologické sledovanie a nízky prah pre opakovanie meraní pri vzostupe tlaku, poklese eGFR alebo vzniku albuminúrie. V slovenskom prostredí musí konečné rozhodnutie vychádzať z národných a európskych transplantačných postupov, možností genetického poradenstva a individuálneho posúdenia transplantačným centrom.</p>

<h2>Záver</h2>

<p>V kohorte amerických živých darcov bol vysokorizikový genotyp APOL1 spojený s viac než dvojnásobným neupraveným rizikom eGFR &lt;45 ml/min/1,73 m<sup>2</sup> približne 18,5 roka po darovaní. Po zohľadnení východiskovej eGFR pred darovaním zostal bodový odhad zvýšený, no asociácia už nebola štatisticky významná. Pre zlyhanie obličiek bolo udalostí príliš málo na spoľahlivú kvantifikáciu rizika.</p>

<p>Genotypizácia APOL1 môže zlepšiť informovaný súhlas a nahradiť nepresnú rasovú kategorizáciu konkrétnejšou biologickou informáciou. Výsledok však musí zostať súčasťou holistického hodnotenia veku, funkcie obličiek, albuminúrie, krvného tlaku, metabolického a rodinného rizika. Presnejšia medicína tu nemá znamenať menej darcov, ale spravodlivejšie a transparentnejšie rozhodovanie o riziku.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Hsu C-Y, Gao Y, Freedman BI, Lunn MR, Muiru AN, Schnitzler MA, Divers J, Mannon RB, Palmer ND, Karger AB, Lentine KL, Park M; APOLLO Consortium. Apolipoprotein L1 Gene Genotype and Kidney Outcomes After Living Kidney Donation. <em>JAMA Internal Medicine</em>. Publikované online 22. júna 2026. DOI: 10.1001/jamainternmed.2026.0996. <a href="https://doi.org/10.1001/jamainternmed.2026.0996" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42329639/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Odporúčania a kontext:</strong> <a href="https://kdigo.org/wp-content/uploads/2017/07/2017-KDIGO-LD-GL.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2017 Clinical Practice Guideline on the Evaluation and Care of Living Kidney Donors</a> · <a href="https://kdigo.org/wp-content/uploads/2025/08/KDIGO-2025-APOL1-Kidney-Disease-Conference-Report.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2025 APOL1 Kidney Disease Conference Report</a> · Sharif A. APOL1 and Black Kidney Donors—Reducing Risk or Opportunity? <em>JAMA Internal Medicine</em>. 2026. <a href="https://doi.org/10.1001/jamainternmed.2026.1004" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://www.ucsf.edu/news/2026/06/432151/genetic-test-ranks-risk-black-people-hoping-donate-kidney" target="_blank" rel="noopener noreferrer">UCSF: zhrnutie štúdie</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_apol1_donor newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_apol1_donor pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_apol1_donor pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_apol1_donor migration error: ' . $e->getMessage());
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
