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

$articles = [[
    'title' => 'Naltrexón s bupropiónom pri obezite a chronickej chorobe obličiek',
    'slug' => 'naltrexon-bupropion-obezita-ckd',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Naltrexón s bupropiónom v štúdii COR-I znížil hmotnosť viac ako placebo. Pri chronickej chorobe obličiek výber ovplyvňujú funkcia obličiek, krvný tlak a potreba opioidov.',
    'content' => <<<'HTML'
<p>V randomizovanej štúdii COR-I viedol naltrexón s bupropiónom k väčšiemu úbytku hmotnosti ako placebo. Štúdia však vylúčila ľudí s ochorením obličiek. Pri chronickej chorobe obličiek (CKD, z angl. <em>chronic kidney disease</em>) treba očakávaný účinok na hmotnosť posudzovať spolu s funkciou obličiek, krvným tlakom, potrebou opioidov a neistotou dlhodobej kardiovaskulárnej bezpečnosti.</p>

<figure class="article-figure">
    <img src="img/naltrexon-bupropion-obezita-ckd.jpg" alt="Neoznačená tableta položená na digitálnej váhe s vypnutým displejom." width="1600" height="1000" loading="lazy">
</figure>

<h2>Čo ukázala štúdia COR-I</h2>
<p>Bupropión tlmí spätné vychytávanie noradrenalínu a dopamínu. Naltrexón je antagonista opioidových receptorov. Pracovná hypotéza autorov predpokladá, že bupropión stimuluje proopiomelanokortínové neuróny v hypotalame a naltrexón tlmí ich opioidmi sprostredkovanú spätnú inhibíciu. Úloha okruhov odmeny je ďalším možným vysvetlením. Štúdia merala zmenu hmotnosti a kauzálny podiel týchto mechanizmov neurčovala. [1, 2]</p>

<p>Do dvojito zaslepenej štúdie fázy 3 randomizovali 1 742 dospelých s obezitou alebo s nadhmotnosťou a kontrolovanou artériovou hypertenziou či dyslipidémiou. Všetky skupiny dostali odporúčania k strave a pohybu. V 56. týždni bol v primárnej analýze priemerný pokles hmotnosti pri kombinácii 32 mg naltrexónu a 360 mg bupropiónu denne 6,1 % oproti 1,3 % pri placebe (p &lt; 0,0001). Aspoň 5 % východiskovej hmotnosti stratilo 226 zo 471 účastníkov (48 %) pri kombinácii a 84 z 511 (16 %) pri placebe. Nauzea sa v bezpečnostnej populácii vyskytla u 29,8 % pri uvedenej dávke kombinácie a u 5,3 % pri placebe. [1]</p>

<p>Liečbu dokončilo 870 účastníkov (50 %). Primárna analýza zahŕňala len účastníkov s meraním hmotnosti pred liečbou a aspoň jedným meraním počas nej. Pri chýbajúcej hodnote v 56. týždni prevzala posledné dostupné meranie počas liečby. V analýze citlivosti, ktorá pri chýbajúcom meraní použila východiskovú hmotnosť, bol pokles 4,0 % pri kombinácii a 0,9 % pri placebe. Výsledný odhad teda závisel aj od spôsobu, akým výskumníci naložili s chýbajúcimi meraniami. Štúdia vylúčila ľudí s diabetom a ochorením obličiek a financovala ju spoločnosť Orexigen Therapeutics. [1]</p>

<h2>Funkcia obličiek, krvný tlak a opioidy</h2>
<p>V slovenskom súhrne charakteristických vlastností lieku (SPC) Mysimba je kombinácia kontraindikovaná pri terminálnom zlyhaní obličiek aj pri nekontrolovanej artériovej hypertenzii. Pri stredne závažnej alebo závažnej poruche funkcie obličiek je maximálna dávka jedna tableta ráno a jedna večer. Pri miernej poruche funkcie obličiek sa dávka z tohto dôvodu neznižuje. SPC uvádza, že pred liečbou treba u osôb so zvýšeným rizikom poruchy funkcie obličiek stanoviť odhadovanú glomerulovú filtráciu (eGFR). Krvný tlak a pulz sa kontrolujú pred liečbou aj počas nej. Tieto podmienky upravujú bezpečné používanie lieku. Účinnosť pri CKD zostáva menej preskúmaná, ako uvádza aj odborné usmernenie Americkej nefrologickej spoločnosti (ASN). [2, 3]</p>

<p>Pri medikačnej anamnéze záleží na opioidoch užívaných pravidelne aj príležitostne. Naltrexón môže oslabiť účinok opioidových analgetík. Ak je potrebné ich plánované krátkodobé podanie, napríklad pri operácii, SPC uvádza prerušenie kombinácie najmenej 3 dni pred podaním opioidu. Plán analgézie treba v takom prípade zladiť s anestéziológom alebo s lekárom, ktorý má opioid podať. [2]</p>

<h2>Čo vieme o dlhodobej bezpečnosti</h2>
<p>V štúdii LIGHT skúmali závažné kardiovaskulárne príhody u pacientov so zvýšeným kardiovaskulárnym rizikom. Po tom, ako sponzor zverejnil dôverné priebežné výsledky, štúdiu predčasne ukončili. Autori preto nemohli spoľahlivo vyhodnotiť bezpečnosť podľa vopred stanovenej hranice noninferiority. Retrospektívna kohortová štúdia neskôr pri porovnaní s lorcaserínom nezistila štatisticky významný rozdiel v závažných kardiovaskulárnych príhodách. Výsledok však závisí od voľby komparátora aj od predpokladu, že merané premenné dostatočne zachytili rozdiely medzi skupinami. Randomizovaná štúdia INFORMUS k dátumu publikácie nemala v registri výsledky. [4, 5, 6]</p>

<p>Podľa aktuálneho SPC sa liečba ukončuje, ak pacient po 16 týždňoch neschudol aspoň o 5 % východiskovej hmotnosti. Po roku platí rovnaká hranica pre udržaný úbytok. Ak sa zvažuje pokračovanie, účinok na hmotnosť a vývoj kardiovaskulárneho rizika sa vyhodnocujú každý rok. Kardiovaskulárne riziko pri liečbe dlhšej ako jeden rok zostáva neúplne objasnené. [2]</p>

<h2>Hmotnosť a výsledky dôležité pre nefrológa</h2>
<p>V sieťovej metaanalýze bol odhadovaný úbytok hmotnosti väčší pri semaglutide a tirzepatide ako pri naltrexóne s bupropiónom. Časť porovnaní bola nepriama a výsledky sa týkali obezity u dospelých všeobecne. Správa z konferencie Kidney Disease: Improving Global Outcomes (KDIGO) a usmernenie ASN pri výbere liečby zohľadňujú aj sprievodné ochorenia a kvalitu dôkazov pre jednotlivé skupiny pacientov s CKD. [3, 7, 8]</p>

<p>Rozdiel v dôkazoch je viditeľný pri semaglutide, agonistovi receptora pre glukagónu podobný peptid 1 (GLP-1). V štúdii FLOW sa u pacientov s diabetom 2. typu a albuminurickou CKD pri semaglutide menej často vyskytla príhoda z kombinovaného ukazovateľa zahŕňajúci zlyhanie obličiek, pokles eGFR najmenej o 50 % alebo úmrtie z obličkovej či kardiovaskulárnej príčiny (pomer hazardov 0,76, 95 % interval spoľahlivosti od 0,66 do 0,88). Pre naltrexón s bupropiónom údaje o poklese hmotnosti takýto obličkový prínos nedokladajú. V ambulancii preto záleží na tom, či je cieľom zníženie hmotnosti, ovplyvnenie rizika progresie CKD, alebo oboje. [1, 3, 8, 9]</p>

<p>Námetom bol verejný program odborného webinára medLIVE Adipositas, ktorého partnerom bola spoločnosť Goodlife Endocrinologie B.V. Záznam je dostupný po prihlásení. Prehľad vychádza z nižšie uvedených publikácií a registračnej dokumentácie. [10]</p>

<hr>
<h2>Zdroje</h2>
<ol>
    <li><small><em>Frank L Greenway, Ken Fujioka, Raymond A Plodkowski, Sunder Mudaliar, Maria Guttadauria, Janelle Erickson, Dennis D Kim, Eduardo Dunayevich, COR-I Study Group. Effect of naltrexone plus bupropion on weight loss in overweight and obese adults (COR-I): a multicentre, randomised, double-blind, placebo-controlled, phase 3 trial. Lancet. 2010;376(9741):595 až 605. <a href="https://doi.org/10.1016/S0140-6736(10)60888-4" target="_blank" rel="noopener noreferrer">DOI 10.1016/S0140-6736(10)60888-4</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/20673995/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://linkinghub.elsevier.com/retrieve/pii/S0140673610608884" target="_blank" rel="noopener noreferrer">Vydavateľ</a>; <a href="https://s3.ap-southeast-2.amazonaws.com/nzdoctor.files/production/public/2021-07/COR-I%20greenway-fujioka-lancet-2010.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
    <li><small><em>Európska agentúra pre lieky. Mysimba. Súhrn charakteristických vlastností lieku, časti 4.1 až 4.5 a 5.1 až 5.2. <a href="https://www.ema.europa.eu/sk/documents/product-information/mysimba-epar-product-information_sk.pdf" target="_blank" rel="noopener noreferrer">Slovenské znenie</a>.</em></small></li>
    <li><small><em>T Alp Ikizler, Holly J Kramer, Srinivasan Beddhu, Alex R Chang, Allon N Friedman, Meera N Harhay, Elizabeth Yakes Jimenez, Brandon Kistler, Aleksandra Kukla, Kristin Larson, LindaMarie U Lavenburg, Sankar Dass Navaneethan, John Ortiz, Rocio I Pereira, David B Sarwer, Philip R Schauer, Evan M Zeitler, ASN Kidney Health Guidance Workgroup on Obesity and Kidney Diseases. ASN Kidney Health Guidance on the Management of Obesity in Persons Living with Kidney Diseases. J Am Soc Nephrol. 2024;35(11):1574 až 1588. <a href="https://doi.org/10.1681/ASN.0000000512" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.0000000512</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39292519/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ovid.com/jnls/jasn/fulltext/10.1681/asn.0000000512~asn-kidney-health-guidance-on-the-management-of-obesity-in" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
    <li><small><em>Steven E Nissen, Kathy E Wolski, Lisa Prcela, Thomas Wadden, John B Buse, George Bakris, Alfonso Perez, Steven R Smith. Effect of Naltrexone-Bupropion on Major Adverse Cardiovascular Events in Overweight and Obese Patients With Cardiovascular Risk Factors: A Randomized Clinical Trial. JAMA. 2016;315(10):990 až 1004. <a href="https://doi.org/10.1001/jama.2016.1558" target="_blank" rel="noopener noreferrer">DOI 10.1001/jama.2016.1558</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26954408/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://jamanetwork.com/journals/jama/fullarticle/2499275" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
    <li><small><em>Michael Kyle, Dustin Burns, Catherine Rogers Murray, Heather Watson, Jeff Swaney, Samuel Spevack, Megan Leonhard, Michael Simon, Emma Moynihan, Kate L Lapane, Shirley V Wang, Craig L Longo, Mary E Ritchey, David D Dore. Cardiovascular safety of fixed-dose extended-release naltrexone/bupropion in clinical practice. Obes Pillars. 2025;13:100169. <a href="https://doi.org/10.1016/j.obpill.2025.100169" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.obpill.2025.100169</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40104005/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://linkinghub.elsevier.com/retrieve/pii/S2667368125000130" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
    <li><small><em>Currax Pharmaceuticals LLC. INFORMUS. Registračný záznam randomizovanej štúdie fázy 4. <a href="https://clinicaltrials.gov/study/NCT06098079" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov, NCT06098079</a>.</em></small></li>
    <li><small><em>Barbara McGowan, Andreea Ciudin, Jennifer L Baker, Luca Busetto, Dror Dicker, Gema Frühbeck, Gijs H Goossens, Matteo Monami, Paolo Sbraccia, Borja Martinez-Tellez, Euan Woodward, Volkan Yumuk. A systematic review and meta-analysis of the efficacy and safety of pharmacological treatments for obesity in adults. Nat Med. 2025;31(10):3317 až 3329. <a href="https://doi.org/10.1038/s41591-025-03978-z" target="_blank" rel="noopener noreferrer">DOI 10.1038/s41591-025-03978-z</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41039116/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.nature.com/articles/s41591-025-03978-z" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
    <li><small><em>Susan L Furth, Helen M Colhoun, Mehmet Kanbay, Aleksandra Kukla, Lee-Ling Lim, Helen L MacLaughlin, Sankar D Navaneethan, Rukshana Shroff, Peter Stenvinkel, Michael Cheung, Jennifer M King, Morgan E Grams, Michel Jadoul, Peter Rossing, Conference Participants. The relationship between obesity and chronic kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. Kidney Int. 2026;109(3):442 až 464. <a href="https://doi.org/10.1016/j.kint.2025.09.019" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2025.09.019</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41176308/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://linkinghub.elsevier.com/retrieve/pii/S0085253825007744" target="_blank" rel="noopener noreferrer">Vydavateľ</a>; <a href="https://kdigo.org/wp-content/uploads/2026/02/KDIGO-2026-Obesity-in-CKD-Controversies-Conference-Report.pdf" target="_blank" rel="noopener noreferrer">Plný text KDIGO</a>.</em></small></li>
    <li><small><em>Vlado Perkovic, Katherine R Tuttle, Peter Rossing, Kenneth W Mahaffey, Johannes F E Mann, George Bakris, Florian M M Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley, FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. N Engl J Med. 2024;391(2):109 až 121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa2403347</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
    <li><small><em>Arya M Sharma (vedecké vedenie), Ruth Hanßen, Karsten Behle, Matthias Blüher (prednášajúci). Jenseits der Inkretine: Neue Wege in der medikamentösen Adipositastherapie. STREAMED UP, medLIVE Adipositas, 2026. <a href="https://streamed-up.com/video/jenseits-der-inkretine-neue-wege-in-der-medikamentoesen-adipositastherapie" target="_blank" rel="noopener noreferrer">Stránka webinára</a>.</em></small></li>
</ol>
HTML,
]];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_naltrexon-bupropion-obezita-ckd_article',
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
