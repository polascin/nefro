<?php

/**
 * add_liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki_article.php
 * Odborný článok o vrstvenej nefroprotekcii a sledovaní po AKI.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki_article.php"
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI',
    'slug'         => 'liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Moderná liečba CKD vrství blokádu RAS, inhibítory SGLT2, finerenón a agonisty GLP-1 podľa fenotypu. Rozhodujú albuminúria, eGFR, komorbidity, tolerancia a plán sledovania po AKI.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Moderná nefroprotekcia nie je univerzálna kombinácia štyroch liekov. Je to postupné vrstvenie terapií s preukázaným prínosom podľa príčiny CKD, kategórie eGFR a albuminúrie, pridružených ochorení, tolerancie a priorít pacienta.</em></p>

<p>Liečba chronickej choroby obličiek (CKD) sa za posledné roky zásadne zmenila. Popri blokáde renínovo-angiotenzínového systému (RAS) sú k dispozícii inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2), nesteroidný antagonista mineralokortikoidového receptora finerenón a agonisty receptora pre glukagónu podobný peptid 1 (GLP-1). Výzvou v roku 2026 už nie je iba dostupnosť účinnej liečby, ale najmä správny výber pacienta, bezpečné poradie jej nasadenia a dôsledné sledovanie.</p>

<p>Východiskom článku je expertná syntéza HCPLive z júla 2026. Keďže nejde o systematický prehľad ani klinické odporúčanie, jej praktické závery sú konfrontované s odporúčaniami KDIGO, registračnou indikáciou finerenónu v Európskej únii a s výsledkami rozhodujúcich randomizovaných štúdií.</p>

<h2>Najprv určiť príčinu a absolútne riziko</h2>

<p>Jedna hodnota eGFR nestačí. Dvaja pacienti s eGFR 50 ml/min/1,73 m² môžu mať úplne odlišnú prognózu: u jedného zostáva funkcia obličiek roky stabilná, u druhého rýchlo klesá. Hodnotenie má preto zahŕňať:</p>

<ul>
  <li>potvrdenie chronicity nálezu a určenie pravdepodobnej príčiny CKD,</li>
  <li>vývoj eGFR v čase, nie iba izolovanú hodnotu kreatinínu,</li>
  <li>pomer albumínu ku kreatinínu v moči (UACR) a podľa situácie kvantifikáciu celkovej proteinúrie,</li>
  <li>močový sediment, krvný tlak, sérový draslík, acidobázickú rovnováhu a objemový stav,</li>
  <li>diabetes, srdcové zlyhávanie, aterosklerotické kardiovaskulárne ochorenie, obezitu a ďalšie komorbidity,</li>
  <li>odhad rizika zlyhania obličiek validovaným nástrojom, napríklad KFRE pri CKD G3 až G5, ak je pre danú populáciu použiteľný.</li>
</ul>

<p>Pri nejasnej etiológii, atypickom priebehu, aktívnom močovom sedimente, výraznej proteinúrii, rodinnej záťaži alebo podozrení na monogénne ochorenie môže diagnózu a liečbu zmeniť biopsia obličky alebo cielené genetické vyšetrenie. Presná nefrológia preto neznamená „viac vyšetrení pre každého“, ale správne vyšetrenie u pacienta, u ktorého môže ovplyvniť rozhodovanie.</p>

<h2>Vrstvená liečba podľa fenotypu</h2>

<h3>1. Blokáda RAS zostáva základom pri albuminúrii</h3>

<p>Inhibítor angiotenzín konvertujúceho enzýmu (ACEi) alebo blokátor receptora angiotenzínu II (ARB) je základnou liečbou vhodných pacientov s albuminurickou CKD. KDIGO odporúča titráciu na najvyššiu schválenú tolerovanú dávku. Kombinácia ACEi s ARB ani ich kombinovanie s priamym inhibítorom renínu sa neodporúča, pretože zvyšuje riziko hypotenzie, hyperkaliémie a akútneho poškodenia obličiek bez zodpovedajúceho klinického prínosu.</p>

<p>Po nasadení alebo zvýšení dávky treba spravidla do 2 až 4 týždňov skontrolovať krvný tlak, kreatinín a draslík. Prechodný vzostup kreatinínu nemusí znamenať poškodenie obličiek; podľa KDIGO sa má pátrať po reverzibilnej príčine najmä vtedy, ak kreatinín do 4 týždňov stúpne o viac ako 30 %. Hyperkaliémiu je často možné manažovať bez automatického vysadenia liečby.</p>

<h3>2. Inhibítory SGLT2 majú široké, nie však neobmedzené použitie</h3>

<p>Dapagliflozín v štúdii DAPA-CKD a empagliflozín v štúdii EMPA-KIDNEY znížili riziko progresie CKD vo vymedzených populáciách s diabetom aj bez diabetu. KDIGO 2024 odporúča inhibítor SGLT2 dospelým s CKD a eGFR ≥ 20 ml/min/1,73 m², ak majú UACR ≥ 200 mg/g (≥ 20 mg/mmol), alebo ak majú srdcové zlyhávanie bez ohľadu na albuminúriu. Samostatné silné odporúčanie platí pre pacientov s diabetom 2. typu a CKD pri eGFR ≥ 20 ml/min/1,73 m². Pri eGFR 20 až 45 ml/min/1,73 m² a nižšej albuminúrii ide o slabšie odporúčanie.</p>

<p>Po začatí liečby sa môže objaviť reverzibilný počiatočný pokles eGFR, ktorý sám osebe zvyčajne nie je dôvodom na vysadenie. Treba zhodnotiť objemový stav a diuretickú liečbu a pacienta poučiť o genitálnych mykotických infekciách a zriedkavej euglykemickej ketoacidóze. Inhibítor SGLT2 je rozumné dočasne prerušiť pri dlhšom hladovaní, operácii alebo kritickom ochorení so zvýšeným rizikom ketózy.</p>

<h3>3. Finerenón: presne vymedzená dôkazová základňa</h3>

<p>Finerenón znížil v štúdiách FIDELIO-DKD a FIGARO-DKD riziko obličkových a kardiovaskulárnych príhod u pacientov s CKD spojenej s diabetom 2. typu. KDIGO 2024 ho navrhuje u dospelých s diabetom 2. typu, eGFR &gt; 25 ml/min/1,73 m², normálnou koncentráciou draslíka a pretrvávajúcou albuminúriou &gt; 30 mg/g (&gt; 3 mg/mmol) napriek maximálnej tolerovanej dávke ACEi alebo ARB. Európska registračná indikácia pre liečbu CKD je naďalej viazaná na diabetes 2. typu.</p>

<p>Výsledky štúdie CONFIDENCE podporujú skoré kombinovanie finerenónu s empagliflozínom u vybraných pacientov s diabetom 2. typu a albuminurickou CKD: po 180 dňoch bol pokles UACR väčší než pri každom lieku samostatne. Primárnym výsledkom však bol zástupný ukazovateľ, nie zlyhanie obličiek, kardiovaskulárna príhoda alebo mortalita. Štúdia preto nedokazuje dlhodobý klinický prínos súčasného začatia oboch liekov. Pri finerenóne je nevyhnutný výber pacienta podľa draslíka a pravidelné monitorovanie kaliémie.</p>

<p>Dôkazy o finerenóne pri CKD bez diabetu sa rozširujú, no v čase publikovania článku ešte nejde o všeobecný štandard pre každého pacienta s albuminúriou. KDIGO pripravuje cielenú aktualizáciu tejto oblasti.</p>

<h3>4. Agonisty GLP-1 podľa diabetického, obezitologického a kardiovaskulárneho profilu</h3>

<p>Agonisty GLP-1 už nemožno vnímať iba ako lieky znižujúce glykémiu. Pri diabete 2. typu majú významné kardiovaskulárne a metabolické účinky a štúdia FLOW preukázala pri semaglutide zníženie rizika závažných obličkových výsledkov u pacientov s diabetom 2. typu a CKD. KDIGO 2024 odporúča dlhodobo pôsobiaceho agonistu GLP-1 pri diabete 2. typu a CKD, ak sa individualizovaný glykemický cieľ nedarí dosiahnuť napriek metformínu a inhibítoru SGLT2 alebo ak pacient tieto lieky nemôže užívať; prednosť majú molekuly s preukázaným kardiovaskulárnym prínosom.</p>

<p>Prítomnosť obezity alebo aterosklerotického kardiovaskulárneho ochorenia môže rozhodnutie o liečbe ďalej podporiť. To však neznamená, že agonista GLP-1 je automatickou nefroprotektívnou liečbou každého pacienta s CKD bez ohľadu na diagnózu a schválenú indikáciu.</p>

<h2>Čo vieme a čo ešte iba predpokladáme</h2>

<p>Pre jednotlivé liekové triedy máme randomizované dôkazy o klinickom prínose v presne definovaných populáciách. Mnohé štúdie inhibítorov SGLT2 a finerenónu prebiehali na pozadí blokády RAS, čo podporuje vrstvenie liečby. Nemáme však jednu dlhodobú randomizovanú štúdiu, ktorá by preukázala zníženie zlyhania obličiek a mortality pri univerzálnej kombinácii ACEi alebo ARB, inhibítora SGLT2, finerenónu a agonistu GLP-1 u všetkých fenotypov CKD.</p>

<p>Pokles albuminúrie je priaznivý prognostický signál a užitočný výsledok štúdie, ale nie je totožný s priamym dôkazom ochrany pred zlyhaním obličiek. Klinické rozhodovanie má preto vychádzať z indikácie a výsledkov konkrétnej štúdie, nie iba z biologickej príťažlivosti kombinácie.</p>

<h2>Aldosterónová os: zavedená liečba a výskumné smery</h2>

<p>Steroidné antagonisty mineralokortikoidového receptora, najmä spironolaktón a eplerenón, majú jasné miesto pri vybraných formách srdcového zlyhávania, primárnom aldosteronizme a rezistentnej hypertenzii. Pri pokročilej CKD však rastie riziko hyperkaliémie. Finerenón má vlastnú dôkazovú základňu a nemožno ho považovať za zameniteľný so všetkými ostatnými antagonistami mineralokortikoidového receptora.</p>

<p>Inhibítory aldosterónsyntázy a ďalšie zásahy do aldosterónovej dráhy sú sľubným smerom výskumu. Kým nebudú k dispozícii presvedčivé výsledky klinických štúdií a regulačné rozhodnutia pre konkrétnu indikáciu, nepatria do štandardného algoritmu liečby CKD.</p>

<h2>AKI nekončí normalizáciou kreatinínu pri prepustení</h2>

<p>Akútne poškodenie obličiek (AKI) zvyšuje riziko ďalšej epizódy AKI, novovzniknutej alebo progredujúcej CKD, kardiovaskulárnych príhod a mortality. Aj zdanlivý návrat kreatinínu k východiskovej hodnote nemusí znamenať úplnú biologickú reparáciu. Prepúšťacia správa by preto mala jasne uviesť východiskovú, maximálnu a poslednú hodnotu kreatinínu, pravdepodobnú príčinu AKI, zmeny liekov a plán kontrol.</p>

<p>Načasovanie prvej kontroly sa má prispôsobiť závažnosti AKI, reziduálnej dysfunkcii, objemovému stavu, elektrolytovým poruchám a potrebe opätovne nasadiť liečbu. Rizikový pacient potrebuje kontrolu skôr než o tri mesiace. KDIGO odporúča najneskôr po troch mesiacoch zhodnotiť funkciu obličiek a markery poškodenia obličiek s cieľom posúdiť úpravu stavu, novovzniknutú CKD alebo zhoršenie už prítomnej CKD.</p>

<p>Praktické sledovanie po AKI zahŕňa podľa klinickej situácie:</p>

<ul>
  <li>kreatinín, eGFR, draslík a ďalšie relevantné elektrolyty,</li>
  <li>UACR po stabilizácii akútneho stavu, krvný tlak a objemový stav,</li>
  <li>liekovú rekonciliáciu vrátane dávok podľa funkcie obličiek a odstránenia zbytočných nefrotoxických liekov,</li>
  <li>plán bezpečného opätovného nasadenia liekov s prognostickým prínosom, ak indikácia trvá,</li>
  <li>poučenie o hydratácii primeranej klinickému stavu, varovných príznakoch a postupe pri interkurentnom ochorení.</li>
</ul>

<p>Prekonané AKI samo osebe nie je dôvodom natrvalo odobrať pacientovi blokádu RAS alebo inú prognosticky účinnú liečbu. Rozhoduje aktuálna indikácia, hemodynamická stabilita, funkcia obličiek, kaliémia a možnosť následného monitorovania.</p>

<h2>Praktický algoritmus pre ambulanciu</h2>

<ol>
  <li><strong>Potvrďte diagnózu a príčinu.</strong> Klasifikujte CKD podľa príčiny, kategórie eGFR a albuminúrie; zhodnoťte trend a absolútne riziko.</li>
  <li><strong>Optimalizujte základnú starostlivosť.</strong> Liečte krvný tlak, diabetes, dyslipidémiu, fajčenie, objemové preťaženie a ďalšie modifikovateľné riziká; primerane upravte dávky liekov.</li>
  <li><strong>Nasaďte ACEi alebo ARB pri zodpovedajúcej indikácii.</strong> Titrujte podľa tolerancie a kontrolujte kreatinín a draslík.</li>
  <li><strong>Pridajte inhibítor SGLT2, ak pacient spĺňa odporúčané kritériá.</strong> Vopred vysvetlite očakávaný pokles eGFR a pravidlá dočasného prerušenia.</li>
  <li><strong>Pri diabete 2. typu a pretrvávajúcej albuminúrii zvážte finerenón.</strong> Overte eGFR, kaliémiu, liekové interakcie a zabezpečte ďalšie kontroly draslíka.</li>
  <li><strong>Agonista GLP-1 vyberte podľa celého fenotypu.</strong> Zohľadnite glykemickú kontrolu, obezitu, kardiovaskulárne riziko, toleranciu a schválenú indikáciu.</li>
  <li><strong>Po každej zmene skontrolujte bezpečnosť a adherenciu.</strong> Nehodnoťte liečbu iba podľa jednej hodnoty eGFR; sledujte tlak, objemový stav, draslík, UACR a dlhodobý trend.</li>
  <li><strong>Po AKI vytvorte konkrétny plán.</strong> Určte termín kontroly, potrebné laboratórne vyšetrenia, správu liekov a zodpovedného lekára.</li>
</ol>

<h2>Záver</h2>

<p>Moderná liečba CKD je vrstvená, ale nie mechanická. Blokáda RAS, inhibítory SGLT2, finerenón a agonisty GLP-1 zasahujú rozdielne mechanizmy a môžu sa vhodne dopĺňať, no každý z nich má vlastnú cieľovú populáciu, dôkazovú základňu a bezpečnostné podmienky. Najväčší prínos preto nevzniká automatickým predpísaním všetkých dostupných liekov, ale presnou diagnostikou, včasným nasadením indikovaných terapií, monitorovaním tolerancie a spoločným rozhodovaním s pacientom.</p>

<p>Rovnakú pozornosť si zaslúži obdobie po AKI. Systematické následné sledovanie môže odhaliť novú alebo zhoršujúcu sa CKD, umožniť bezpečný návrat prognosticky účinnej liečby a znížiť riziko, že dôležitá epizóda poškodenia obličiek zostane bez ďalšej starostlivosti.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Garimella P, Richards M, Breeggemann M.</strong> <em>Where Are We Now? Treating Chronic Kidney Disease in 2026.</em> HCPLive. 30. júla 2026. <a href="https://www.hcplive.com/view/where-are-we-now-treating-chronic-kidney-disease-in-2026" target="_blank" rel="noopener noreferrer">Hlavný zdroj</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(Suppl 4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text odporúčania</a>.</li>
  <li><strong>Heerspink HJL, Stefánsson BV, Correa-Rotter R, et al.</strong> <em>Dapagliflozin in Patients with Chronic Kidney Disease.</em> New England Journal of Medicine. 2020;383:1436–1446. doi: 10.1056/NEJMoa2024816. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2024816" target="_blank" rel="noopener noreferrer">DAPA-CKD</a>.</li>
  <li><strong>The EMPA-KIDNEY Collaborative Group.</strong> <em>Empagliflozin in Patients with Chronic Kidney Disease.</em> New England Journal of Medicine. 2023;388:117–127. doi: 10.1056/NEJMoa2204233. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">EMPA-KIDNEY</a>.</li>
  <li><strong>Bakris GL, Agarwal R, Anker SD, et al.</strong> <em>Effect of Finerenone on Chronic Kidney Disease Outcomes in Type 2 Diabetes.</em> New England Journal of Medicine. 2020;383:2219–2229. doi: 10.1056/NEJMoa2025845. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">FIDELIO-DKD</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, et al.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391:109–121. doi: 10.1056/NEJMoa2403347. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">FLOW</a>.</li>
  <li><strong>Agarwal R, Green JB, Heerspink HJL, et al.</strong> <em>Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes.</em> New England Journal of Medicine. 2025;393:533–543. doi: 10.1056/NEJMoa2410659. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">CONFIDENCE</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Kerendia (finerenone): European public assessment report.</em> <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">Aktuálna európska indikácia a dokumentácia</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group.</strong> <em>KDIGO Clinical Practice Guideline for Acute Kidney Injury.</em> Kidney International Supplements. 2012;2:1–138. <a href="https://kdigo.org/wp-content/uploads/2017/04/KDIGO-AKI-GL-for-JSN_wm.pdf" target="_blank" rel="noopener noreferrer">Plný text odporúčania</a>.</li>
</ol>

<p><em><strong>Poznámka k aktuálnosti:</strong> KDIGO 2024 zostáva v čase publikovania platným globálnym štandardom pre CKD. KDIGO pripravuje cielenú aktualizáciu kapitoly o liečbe progresie CKD a návrh nového odporúčania pre AKI/AKD z marca 2026 je zatiaľ dokumentom na verejné pripomienkovanie, nie konečným usmernením.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki_article',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
