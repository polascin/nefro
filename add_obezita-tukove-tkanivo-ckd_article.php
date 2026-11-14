<?php

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
    'title'        => 'Obezita, dysfunkcia tukového tkaniva a riziko pre srdce a obličky',
    'slug'         => 'obezita-tukove-tkanivo-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Nadbytok tukového tkaniva zvyšuje obehovú záťaž. Jeho metabolická dysfunkcia prispieva k inzulínovej rezistencii a zápalu. Čo ukázali skúšania pri obezite a pri CKD?',
    'content'      => <<<'HTML'
<figure><img src="img/obezita-tukove-tkanivo-ckd.webp" alt="Meracia páska pred anatomickými modelmi srdca a obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie.</figcaption></figure>

<p>Pri obezite záleží na množstve tukového tkaniva, jeho rozložení aj metabolickej aktivite. Stanovisko Obesity Medicine Association (OMA), o ktorom informovala Megan Brooksová v Medscape, rozlišuje mechanickú a obehovú záťaž pri nadbytku tuku od dôsledkov dysfunkcie tukového tkaniva. Oba mechanizmy sa často prekrývajú. Stanovisko ich používa na vysvetlenie komplikácií obezity a neponúka osobitné liečebné algoritmy pre každý z nich [1, 2].</p>

<h2>Nadbytok tuku a obehová záťaž</h2>
<p>Pri obezite môžu vyššie metabolické nároky súvisieť s väčším objemom cirkulujúcej krvi a vyšším srdcovým výdajom. Dlhodobá objemová a tlaková záťaž prispieva k remodelácii ľavej komory a poruche jej plnenia. Je to jeden z mechanizmov srdcového zlyhávania so zachovanou ejekčnou frakciou (HFpEF). K ďalším patrí obštrukčné spánkové apnoe, ku ktorému môže prispievať tukové tkanivo v okolí horných dýchacích ciest [2].</p>
<p>V nefrológii má význam súvislosť medzi viscerálnou obezitou a hypertenziou. OMA opisuje tlak tuku v okolí obličiek a aktiváciu systému renín-angiotenzín-aldosterón ako možné súčasti mechanizmu retencie sodíka a zvýšenia krvného tlaku. Ide o vysvetlenie na úrovni fyziológie. Zo samotného množstva tuku v okolí obličky sa nedá určiť príčina hypertenzie u jednotlivca [2].</p>

<h2>Dysfunkcia tukového tkaniva</h2>
<p>Dysfunkčné tukové tkanivo môže uvoľňovať viac voľných mastných kyselín a zápalových mediátorov a meniť tvorbu adipokínov. Tieto deje súvisia s inzulínovou rezistenciou, dyslipidémiou a chronickým zápalom. OMA používa pojem adiposopatia na označenie tejto metabolickej, endokrinnej a imunitnej dysfunkcie. Epikardiálne tukové tkanivo je príkladom, pri ktorom sa mechanizmy môžu stretnúť. Jeho objem môže ovplyvniť plnenie srdca a jeho metabolická aktivita môže pôsobiť na priľahlý myokard a koronárne cievy [2].</p>

<h2>Tri skúšania odpovedali na rozdielne otázky</h2>
<p>V štúdii SELECT u dospelých s nadváhou alebo obezitou a preukázaným kardiovaskulárnym ochorením bez diabetu sa pri semaglutide v dávke 2,4 mg týždenne vyskytlo kardiovaskulárne úmrtie, nefatálny infarkt alebo nefatálna cievna mozgová príhoda u 6,5 % účastníkov oproti 8,0 % pri placebe. Pomer hazardov bol 0,80 (95 % interval spoľahlivosti od 0,72 do 0,90) pri priemernom sledovaní 39,8 mesiaca. Pre nežiaduce účinky natrvalo ukončilo skúšanú liečbu 16,6 % účastníkov pri semaglutide a 8,2 % pri placebe [3].</p>
<p>Pri HFpEF spojenom s obezitou skúšanie STEP-HFpEF ukázalo zlepšenie príznakov a telesného fungovania pri semaglutide. Priemerná zmena hmotnosti po 52 týždňoch bola −13,3 % oproti −2,6 % pri placebe. V štúdii SUMMIT sa pri tirzepatide vyskytlo kardiovaskulárne úmrtie alebo zhoršenie srdcového zlyhávania u 9,9 % účastníkov oproti 15,3 % pri placebe (pomer hazardov 0,62, 95 % interval spoľahlivosti od 0,41 do 0,95). Rozdiel v zloženom ukazovateli súvisel najmä s menším počtom príhod zhoršenia srdcového zlyhávania. Samostatný pokles kardiovaskulárnej úmrtnosti sa nepreukázal [4, 5].</p>

<h2>Čo z toho vyplýva pre nefrologickú ambulanciu</h2>
<p>Pri chronickej chorobe obličiek (CKD) poskytuje priamy dôkaz štúdia FLOW. U pacientov s diabetom 2. typu a albuminurickou CKD skúmala semaglutid v dávke 1 mg týždenne. Primárny ukazovateľ zahŕňal zlyhanie obličiek, trvalý pokles odhadovanej glomerulovej filtrácie aspoň o 50 % alebo úmrtie z obličkových či kardiovaskulárnych príčin. Prvá takáto udalosť nastala u 331 z 1 767 účastníkov pri semaglutide a u 410 z 1 766 pri placebe (pomer hazardov 0,76, 95 % interval spoľahlivosti od 0,66 do 0,88). Zložený ukazovateľ obmedzený na obličkové zložky mal pomer hazardov 0,79 (od 0,66 do 0,94). Výsledok FLOW sa vzťahuje na populáciu s diabetom a albuminúriou zastúpenú v skúšaní [6].</p>
<p>Randomizované skúšania hodnotili účinok konkrétneho lieku v určenej populácii. Ich výsledky nevyčísľujú, koľko z prínosu priniesol úbytok hmotnosti a koľko zmena metabolickej aktivity tukového tkaniva. Pri hodnotení pacienta môže obvod pása doplniť index telesnej hmotnosti. Pri opuchoch treba súčasne hodnotiť objemový stav, pretože zmena hmotnosti môže odrážať zmenu množstva tekutín. Liečba obezity má prebiehať súbežne s liečbou hypertenzie, dyslipidémie, diabetu a samotnej CKD podľa klinického stavu [2, 3, 6].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Megan Brooks. Fat Mass and Sick Fat: Two Obesity Pathways to CVD. Medscape. 29. októbra 2026. <a href="https://www.medscape.com/viewarticle/fat-mass-and-sick-fat-two-obesity-pathways-cvd-2026a100151u">Reportáž</a></em></small></li>
<li><small><em>Harold Edward Bays, Catherine Varney, Lydia Alexander, Jennifer Ng, Justin Tondt, Christopher Weber, Sandra Christensen, Karlijn Burridge, Carolynn Francavilla, Shagun Bindlish, Bharti Shetye, Marisa Censani. Obesity and Cardiovascular Disease: An Obesity Medicine Association (OMA) Clinical Practice Statement (CPS) 2026. Obes Pillars. 2026;20:100283. <a href="https://doi.org/10.1016/j.obpill.2026.100283">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42729919/">PubMed 42729919</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13564139/">Plný text</a></em></small></li>
<li><small><em>A Michael Lincoff, Kirstine Brown-Frandsen, Helen M Colhoun, John Deanfield, Scott S Emerson, Sille Esbjerg, Søren Hardt-Lindberg, G Kees Hovingh, Steven E Kahn, Robert F Kushner, Ildiko Lingvay, Tugce K Oral, Marie M Michelsen, Jorge Plutzky, Christoffer W Tornøe, Donna H Ryan, SELECT Trial Investigators. Semaglutide and Cardiovascular Outcomes in Obesity without Diabetes. N Engl J Med. 2023;389(24):2221-2232. <a href="https://doi.org/10.1056/NEJMoa2307563">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37952131/">PubMed 37952131</a></em></small></li>
<li><small><em>Mikhail N Kosiborod, Steen Z Abildstrøm, Barry A Borlaug, Javed Butler, Søren Rasmussen, Melanie Davies, G Kees Hovingh, Dalane W Kitzman, Marie L Lindegaard, Daniél V Møller, Sanjiv J Shah, Marianne B Treppendahl, Subodh Verma, Walter Abhayaratna, Fozia Z Ahmed, Vijay Chopra, Justin Ezekowitz, Michael Fu, Hiroshi Ito, Małgorzata Lelonek, Vojtech Melenovsky, Bela Merkely, Julio Núñez, Eduardo Perna, Morten Schou. Semaglutide in Patients with Heart Failure with Preserved Ejection Fraction and Obesity. N Engl J Med. 2023;389(12):1069-1084. <a href="https://doi.org/10.1056/NEJMoa2306963">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37622681/">PubMed 37622681</a></em></small></li>
<li><small><em>Milton Packer, Michael R Zile, Christopher M Kramer, Seth J Baum, Sheldon E Litwin, Venu Menon, Junbo Ge, Govinda J Weerakkody, Yang Ou, Mathijs C Bunck, Karla C Hurt, Masahiro Murakami, Barry A Borlaug, SUMMIT Trial Study Group. Tirzepatide for Heart Failure with Preserved Ejection Fraction and Obesity. N Engl J Med. 2025;392(5):427-437. <a href="https://doi.org/10.1056/NEJMoa2410027">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39555826/">PubMed 39555826</a></em></small></li>
<li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109-121. <a href="https://doi.org/10.1056/NEJMoa2403347">DOI</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/">PubMed 38785209</a></em></small></li>
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
    'log_prefix' => 'add_obezita_tukove_tkanivo_ckd',
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
