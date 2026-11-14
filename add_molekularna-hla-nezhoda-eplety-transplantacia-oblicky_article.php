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
    'title'        => 'Molekulárna nezhoda HLA pri transplantácii obličky',
    'slug'         => 'molekularna-hla-nezhoda-eplety-transplantacia-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Eplety spresňujú odhad rizika vzniku darcovsky špecifických protilátok. Ich prínos pre alokáciu obličiek ešte treba overiť.',
    'content'      => <<<'HTML'
<figure><img src="img/molekularna-hla-nezhoda-eplety-transplantacia-oblicky.webp" alt="Schematické molekulárne povrchy so zvýraznenými oblasťami pri zobrazení obličky" width="1600" height="1000" loading="lazy" decoding="async"><figcaption>Ilustrácia vytvorená pomocou umelej inteligencie. Molekulárne povrchy sú schematické.</figcaption></figure>

<p>Dve ponuky obličky s rovnakým počtom nezhodných antigénov HLA sa môžu líšiť v tom, aké molekulárne rozdiely bude imunitný systém príjemcu rozpoznávať. Naratívny prehľad Bezstarosti a spoluautorov v <i>Kidney International</i> opisuje, ako tieto rozdiely spresniť. Kohortové štúdie podporujú ich prognostický význam, najmä pri HLA-DQ. Otvorenou otázkou zostáva, či použitie molekulárneho skóre pri alokácii zlepší výsledky transplantácií pri zachovaní spravodlivého prístupu k nim [1, 2, 3, 4, 5].</p>

<h2>Kompatibilita a molekulárna nezhoda</h2>
<p>Pred transplantáciou pomáha anamnéza senzibilizácie, vyšetrenie protilátok proti HLA a krížová skúška posúdiť, či je konkrétny darca pre príjemcu imunologicky prijateľný. Darcovsky špecifické protilátky proti HLA (DSA) môžu byť prítomné už pred transplantáciou. Molekulárna nezhoda medzi darcom a príjemcom pomáha skúmať aj inú otázku, a to pravdepodobnosť vzniku nových darcovsky špecifických protilátok (dnDSA) po transplantácii. Nízke skóre molekulárnej nezhody nemôže nahradiť vyšetrenie existujúcich protilátok ani krížovú skúšku [1, 2, 3].</p>

<p>Eplet je malá priestorová konfigurácia povrchových aminokyselinových zvyškov na molekule HLA. Môže tvoriť časť širšieho epitopu, ktorý rozpoznáva protilátka. HLAMatchmaker porovnáva eplety darcu a príjemcu. Ďalšie nástroje hodnotia rozdiely v povrchových aminokyselinách alebo predpovedajú, ktoré peptidy z darcovských HLA môžu molekuly HLA II. triedy príjemcu prezentovať pomocným T-lymfocytom, ako pri PIRCHE-II. Skóre preto zachytávajú odlišné vlastnosti a ich hodnoty nemajú spoločnú stupnicu. Pri vysokom rozlíšení HLA typizácie možno molekulárne rozdiely priradiť presnejšie. Ak sa alely odhadujú z typizácie s nižším rozlíšením, neistota odhadu vstupuje aj do skóre [1, 3–5].</p>

<h2>Čo ukázali kohorty príjemcov obličky</h2>
<p>Wiebe a spoluautori hodnotili 664 príjemcov. Pri rozlišovaní medzi pacientmi s následným vznikom dnDSA a bez neho bolo v ich kohorte skóre epletovej nezhody jednotlivých molekúl HLA-DR a HLA-DQ presnejšie než počet celých nezhodných antigénov HLA-DR/DQ. Plocha pod ROC krivkou bola 0,84 oproti 0,54. Tieto hodnoty opisujú rozlišovaciu schopnosť v skúmanej kohorte. Samy neudávajú absolútne riziko pre konkrétneho pacienta ani prínos zmeny liečby podľa skóre [2].</p>

<p>V kohorte Seneva a spoluautorov vznikli dnDSA u 43 z 926 príjemcov (4,6 %). Súvislosť s počtom nezhodných epletov s potvrdenou reaktivitou protilátok vyplývala najmä z rozdielov v HLA-DQ. Autori pri HLA-DQ nenašli prah, pod ktorým by sa dnDSA nevyskytovali. V multicentrickej analýze 3 003 príjemcov sa navyše imunitná odpoveď líšila podľa konkrétnej kombinácie a smeru nezhody medzi darcom a príjemcom aj pri podobných kvantitatívnych skóre. Rovnaký súčet rozdielov tak môže zahŕňať imunologicky odlišné kombinácie [3, 4].</p>

<h2>Čo by musela preukázať zmena alokácie</h2>
<p>Prognostické skóre možno hodnotiť v už transplantovanej kohorte, ale zmena pravidiel alokácie ovplyvní aj to, kto a kedy sa k transplantácii dostane. Americká simulácia Mankowského a spoluautorov na údajoch o 5 193 osobách ukázala, že dostupnosť dobre zhodných darcov v populáciách s odlišnou frekvenciou alel závisela od toho, ktoré molekuly a akú definíciu zhody model uprednostnil. Simulácia poskytuje podklad na porovnanie pravidiel. Účinok na čakaciu dobu, transplantovateľnosť vysoko senzibilizovaných pacientov alebo prežívanie štepu v slovenskom systéme z nej nemožno priamo odvodiť [5].</p>

<p>Pred zavedením skóre do alokácie by bolo potrebné overiť jeho pridanú hodnotu pri zachovaní ostatných výberových kritérií, reprodukovateľnosť výpočtu a dostupnosť typizácie v čase ponuky orgánu. Prospektívne hodnotenie by malo sledovať výsledky transplantácií aj dosah na čakateľov, najmä podľa miery senzibilizácie a dostupnosti vhodného darcu. Rovnaká opatrnosť platí pri úprave imunosupresie alebo sledovania podľa jediného skóre [1, 2, 3, 4, 5].</p>

<h2>Slovenské pravidlá výberu príjemcu</h2>
<p>Článok VI odborného usmernenia MZ SR č. S20426-2023-OZS z 5. septembra 2023 upravuje výber príjemcu obličky od mŕtveho darcu. Medzi kritériami uvádza zhodu krvnej skupiny bez ohľadu na Rh faktor, negatívnu krížovú skúšku, stupeň zhody v antigénoch HLA a stupeň imunizácie. Ďalšie kritériá sa týkajú vekového rozdielu medzi darcom a príjemcom, doby čakania, prednostného poradia detí a naliehavosti transplantácie. V publikovanom znení medzi kritériami nie je skóre epletovej nezhody [6].</p>

<p>Zaradenie na čakaciu listinu a výber príjemcu pre konkrétnu obličku sú samostatné kroky. Články VII a IX a prílohy č. 1 a 2 upravujú vyšetrenia a posudzovanie spôsobilosti pred zaradením aj počas čakania. Článok IX uvádza vyšetrenie protilátok proti HLA metódou Luminex a pri pozitívnom výsledku určenie ich špecifickosti. Národná transplantačná organizácia toto usmernenie uvádza vo svojom prehľade predpisov. Molekulárna nezhoda v súčasnosti pomáha najmä spresňovať výskumné otázky o riziku nad rámec antigénovej zhody [1, 6, 7].</p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Suzanne Bezstarosti, Aleksandar Senev, Anna B Morris, Sebastiaan Heidt. Alloimmune risk stratification for kidney transplantation. Kidney Int. Publikované online 29. októbra 2026. <a href="https://doi.org/10.1016/j.kint.2026.07.039" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2026.07.039</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42957129/" target="_blank" rel="noopener noreferrer">PubMed 42957129</a></em></small></li>
<li><small><em>Chris Wiebe, Vasilis Kosmoliaptsis, Denise Pochinco, Ian W Gibson, Julie Ho, Patricia E Birk, Aviva Goldberg, Martin Karpinski, Jamie Shaw, David N Rush, Peter W Nickerson. HLA-DR/DQ molecular mismatch: A prognostic biomarker for primary alloimmunity. Am J Transplant. 2019;19(6):1708-1719. <a href="https://doi.org/10.1111/ajt.15177" target="_blank" rel="noopener noreferrer">DOI 10.1111/ajt.15177</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30414349/" target="_blank" rel="noopener noreferrer">PubMed 30414349</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6563434/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Aleksandar Senev, Maarten Coemans, Evelyne Lerut, Vicky Van Sandt, Johan Kerkhofs, Liesbeth Daniëls, Marleen Vanden Driessche, Veerle Compernolle, Ben Sprangers, Elisabet Van Loon, Jasper Callemeyn, Frans Claas, Anat R Tambur, Geert Verbeke, Dirk Kuypers, Marie-Paule Emonds, Maarten Naesens. Eplet Mismatch Load and De Novo Occurrence of Donor-Specific Anti-HLA Antibodies, Rejection, and Graft Failure after Kidney Transplantation: An Observational Cohort Study. J Am Soc Nephrol. 2020;31(9):2193-2204. <a href="https://doi.org/10.1681/ASN.2020010019" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.2020010019</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/32764139/" target="_blank" rel="noopener noreferrer">PubMed 32764139</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7461684/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Dennis A J Van Den Broek, Akansha Agrawal, Marta Crespo, Marie-Paule Emonds, Sebastiaan Heidt, Danny van der Helm, Tobias L Lenz, Maria Meneghini, Eduard Palou, Dolores Redondo Pachón, Dave L Roelen, Aleksandar Senev, Maarten Naesens, Aiko P J de Vries, Anat R Tambur. A multicenter kidney transplantation study identifies hierarchy and directionality of HLA-DQ alloimmune responses. Nat Commun. 2026;17:9918. <a href="https://doi.org/10.1038/s41467-026-76912-7" target="_blank" rel="noopener noreferrer">DOI 10.1038/s41467-026-76912-7</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42749717/" target="_blank" rel="noopener noreferrer">PubMed 42749717</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13582852/" target="_blank" rel="noopener noreferrer">Plný text</a></em></small></li>
<li><small><em>Michal A Mankowski, Loren Gragert, Brendan Keating, Bonnie E Lonze, Dorry L Segev, Robert Montgomery, Sommer E Gentry, Massimo Mangiola. Balancing equity and human leukocyte antigen matching in deceased-donor kidney allocation with eplet mismatch. Am J Transplant. 2025;25(6):1226-1234. <a href="https://doi.org/10.1016/j.ajt.2024.11.030" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.ajt.2024.11.030</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39631566/" target="_blank" rel="noopener noreferrer">PubMed 39631566</a></em></small></li>
<li><small><em>Ministerstvo zdravotníctva Slovenskej republiky. Odborné usmernenie č. S20426-2023-OZS z 5. septembra 2023 o alokácii orgánov, výbere príjemcu a zaraďovaní na čakaciu listinu. Vestník MZ SR 2023, čiastka 31 až 41, položka 33. <a href="https://www.health.gov.sk/Zdroje?%2FSources%2Fdokumenty%2Fvestniky_mz_sr%2F2023%2Fvestnik-2023-31-41.pdf=" target="_blank" rel="noopener noreferrer">Vestník MZ SR</a></em></small></li>
<li><small><em>Národná transplantačná organizácia. <a href="https://www.nto.sk/legislativa/" target="_blank" rel="noopener noreferrer">Prehľad predpisov pre transplantácie</a></em></small></li>
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
    'log_prefix' => 'add_molekularna_hla_nezhoda',
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
