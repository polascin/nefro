<?php
/**
 * add_kdigo-ckm-syndrom-oblicka-v-strede_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie: Levin et al. (Kidney International, 2026) + KDIGO konferencne spravy.
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

$articles = [];

$articles[] = [
    'title'        => 'Oblička v strede pozornosti: ako odporúčania KDIGO prepájajú kardiovaskulárno-obličkovo-metabolický syndróm',
    'slug'         => 'kdigo-ckm-syndrom-oblicka-v-strede',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad v Kidney International ukazuje, že KDIGO už dnes ponúka ucelený rámec pre manažment kardiovaskulárno-obličkovo-metabolického syndrómu. Nejde o jednu smernicu, ale o sieť odporúčaní a konferenčných správ, v ktorých stojí oblička v strede – nie na okraji.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) už dávno nie je izolovaným nefrologickým problémom. Úzko súvisí s obezitou, diabetom 2. typu, artériovou hypertenziou, dyslipidémiou a kardiovaskulárnym ochorením. V roku 2023 tieto väzby Americká kardiologická asociácia (AHA) formálne pomenovala jednotným pojmom <strong>kardiovaskulárno-obličkovo-metabolický syndróm</strong> (cardiovascular-kidney-metabolic, CKM). Koncept zdôrazňuje, že prevencia a liečba jedného orgánového postihnutia si vyžaduje súčasné zohľadnenie ostatných zložiek.</p>

<p>Prehľadová práca Levina a kolektívu, publikovaná v roku 2026 v časopise <em>Kidney International</em>, ukazuje, že organizácia KDIGO už dnes poskytuje pre túto oblasť ucelený a dôkazmi podložený rámec. Nejde o jedinú „CKM smernicu“. Ide o sieť dokumentov, ktoré sa navzájom dopĺňajú a na ochorenie sa pozerajú optikou obličky.</p>

<h2>Z čoho sa rámec KDIGO skladá</h2>

<p>Autori rozlišujú tri typy dokumentov, čo je pri citovaní podstatné – nemajú rovnakú metodickú váhu:</p>

<div class="table-responsive" role="region" aria-label="Dokumenty KDIGO relevantné pre CKM syndróm" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Typ dokumentu</th>
      <th scope="col">Oblasť</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Klinické odporúčanie</th>
      <td>CKD (2024), krvný tlak (2021), diabetes pri CKD (2022), lipidy (2013)</td>
      <td>Gradované odporúčania so systematickým hodnotením dôkazov</td>
    </tr>
    <tr>
      <th scope="row">Pripravované odporúčanie</th>
      <td>Srdcové zlyhávanie pri CKD</td>
      <td>V čase publikácie prehľadu ešte nevydané</td>
    </tr>
    <tr>
      <th scope="row">Správa z konferencie (controversies conference)</th>
      <td>Obezita a CKD; srdcové zlyhávanie a CKD; prevencia CKD</td>
      <td>Konsenzuálne zhrnutie a výskumné priority, <strong>nie</strong> gradované odporúčania</td>
    </tr>
  </tbody>
</table>
</div>

<p>Toto rozlíšenie má praktický dopad: závery konferencií formulujú smer a otvorené otázky, nie záväzné odporúčania so stupňom dôkazu. Citovať ich ako „odporúčanie KDIGO“ by bolo nepresné.</p>

<h2>Prečo je CKD v strede CKM syndrómu</h2>

<p>CKD zvyšuje riziko progresie do zlyhania obličiek, kardiovaskulárnych príhod, hospitalizácie aj úmrtia. Riziko rastie už v skorých štádiách a nie je dané iba odhadovanou glomerulovou filtráciou (eGFR), ale aj <strong>albuminúriou</strong>, ktorá je silným a nezávislým markerom poškodenia obličiek i kardiovaskulárneho rizika.</p>

<p>CKD pritom nie je definovaná iba zníženou eGFR. Diagnóza sa opiera o prítomnosť štrukturálneho alebo funkčného poškodenia obličiek, jeho trvanie <strong>najmenej 3 mesiace</strong> a klasifikáciu podľa <strong>príčiny, G kategórie eGFR a A kategórie albuminúrie</strong>.</p>

<p>V praxi to znamená, že u rizikového pacienta nestačí vyšetriť kreatinín. Základom je kombinácia eGFR, <strong>pomeru albumín/kreatinín v moči (UACR)</strong> a posúdenia príčiny ochorenia. Samotný kreatinín bez albuminúrie prehliadne značnú časť pacientov s CKD kategórie A2 alebo A3 pri zachovanej filtrácii.</p>

<h2>Štyri prakticky najdôležitejšie body prehľadu</h2>

<h3>1. Skorý záchyt rozhoduje</h3>

<p>Mnohí pacienti sú v začiatkoch asymptomatickí. CKD sa má preto aktívne vyhľadávať u rizikových skupín – pri diabete, hypertenzii, obezite, srdcovom zlyhávaní, aterosklerotickom kardiovaskulárnom ochorení a pri rodinnej anamnéze ochorenia obličiek.</p>

<h3>2. Albuminúria sa nesmie podceňovať</h3>

<p>Albuminúria zlepšuje diagnostiku CKD, spresňuje prognózu, pomáha pri stratifikácii rizika a – na rozdiel od veku či pohlavia – je terapeuticky ovplyvniteľná. Ak je nález náhodný alebo nečakaný, vyšetrenie sa má zopakovať na potvrdenie, že ide o pretrvávajúcu abnormalitu.</p>

<h3>3. Presnejšie hodnotenie GFR má mať prioritu</h3>

<p>U dospelých s rizikom CKD sa odporúča použiť <strong>eGFR z kreatinínu</strong> a tam, kde je to dostupné a klinicky užitočné, doplniť <strong>kombinovaný odhad z kreatinínu a cystatínu C (eGFRcr-cys)</strong>. To je dôležité najmä v situáciách, keď je kreatinínový odhad menej spoľahlivý – pri extrémoch svalovej hmoty, pri sarkopénii, u starších a krehkých pacientov alebo pred nasadením liečby s úzkym terapeutickým oknom.</p>

<h3>4. Rizikové kalkulačky patria do rutinnej starostlivosti</h3>

<p>U pacientov s CKD G3–G5 sa odporúča používať validované predikčné modely na odhad rizika zlyhania obličiek. Pomáhajú pri plánovaní frekvencie sledovania, načasovaní odoslania k nefrológovi, edukácii pacienta a pri príprave na náhradu funkcie obličiek. Posúvajú starostlivosť od statického zaradenia do štádia k dynamickému odhadu individuálneho rizika.</p>

<h2>Liečba naprieč komponentmi CKM syndrómu</h2>

<h3>Životný štýl</h3>

<p>Základom zostáva fyzická aktivita primeranej intenzity <strong>aspoň 150 minút týždenne</strong>, nefajčenie, obmedzenie nadmerného príjmu soli, primeraný príjem bielkovín a redukcia hmotnosti pri obezite. Pri CKD sa uvádza približne <strong>sodík pod 2 g/deň</strong> a <strong>bielkoviny okolo 0,8 g/kg/deň</strong> u vhodných skupín pacientov.</p>

<p>Tieto čísla treba individualizovať podľa výživového stavu, veku, komorbidít a rizika malnutrície. U krehkého pacienta s nízkym príjmom energie môže reštrikcia bielkovín napáchať viac škody než osohu.</p>

<h3>Kontrola krvného tlaku</h3>

<p>U dospelých s CKD bez dialýzy sa odporúča cieľový <strong>systolický tlak pod 120 mmHg</strong>, ak sa meria štandardizovane a pacient ho toleruje. Ide o silné odporúčanie, nie však o univerzálny cieľ pre každého.</p>

<p>Podmienka štandardizovaného merania nie je formalita – cieľ pod 120 mmHg sa vzťahuje na hodnoty získané správnou technikou, nie na bežné ambulantné meranie v zhone. Opatrnosť je namieste pri pokročilej CKD, u krehkých pacientov, pri ortostatickej hypotenzii, vo veľmi vysokom veku a pri zvýšenom riziku pádov.</p>

<h3>Blokáda systému renín–angiotenzín</h3>

<p>ACE inhibítory alebo sartany zostávajú základom pri CKD s albuminúriou, pri CKD s hypertenziou a pri diabete s albuminúriou. Podstatné je titrovať na maximálnu tolerovanú dávku, vyhnúť sa kombinácii ACE inhibítora, sartanu a priameho inhibítora renínu a aktívne riešiť hyperkaliémiu tak, aby sa liečba nemusela zbytočne prerušovať.</p>

<h3>SGLT2 inhibítory</h3>

<p>SGLT2 inhibítory dnes patria k najdôležitejším liekom pri CKD s diabetom a čoraz viac aj bez diabetu. Ich prínos presahuje kontrolu glykémie – spomaľujú progresiu CKD, znižujú kardiovaskulárne riziko a znižujú počet hospitalizácií pre srdcové zlyhávanie. Indikáciu a rozmedzie eGFR treba posudzovať podľa konkrétnej molekuly a platnej informácie o lieku.</p>

<h3>Agonisty receptora GLP-1</h3>

<p>Agonisty receptora GLP-1 majú rastúcu úlohu pri diabetickej CKD, obezite, zvýšenom kardiovaskulárnom riziku a pri potrebe ďalšej kontroly glykémie a hmotnosti. Novšie údaje potvrdzujú priaznivý vplyv na obličkové aj kardiovaskulárne výsledky u vybraných pacientov s obezitou, a to aj bez diabetu.</p>

<h3>Nesteroidové antagonisty mineralokortikoidového receptora</h3>

<p>U pacientov s diabetom 2. typu, CKD a pretrvávajúcou albuminúriou napriek blokáde systému renín–angiotenzín má miesto <strong>finerenón</strong> alebo iný nesteroidový antagonista mineralokortikoidového receptora (nsMRA) s preukázaným prínosom, ak sú splnené bezpečnostné podmienky – predovšetkým kontrola kália.</p>

<h3>Statíny</h3>

<p>Pacienti s CKD sú vo všeobecnosti vysoko kardiovaskulárne rizikoví. Statín alebo kombinácia statínu s ezetimibom sa odporúča najmä vo veku <strong>50 rokov a viac</strong> pri CKD bez dialýzy a u mladších pacientov so špecifickými rizikovými faktormi.</p>

<h3>Antiagregácia a antikoagulácia</h3>

<p>Kyselina acetylsalicylová má miesto najmä v sekundárnej prevencii u pacientov s preukázaným ischemickým kardiovaskulárnym ochorením. Pri fibrilácii predsiení sa u vhodných pacientov s CKD G1–G4 uprednostňujú priame perorálne antikoagulanciá pred warfarínom.</p>

<h2>Obezita a CKD: príčinná aj zosilňujúca väzba</h2>

<p>Obezita nie je len sprievodným faktorom. V paradigme CKM býva spúšťačom patologických dejov – glomerulárnej hyperfiltrácie, zápalu, inzulínovej rezistencie a tubulointersticiálneho aj cievneho poškodenia.</p>

<p>Zo záverov konferencie KDIGO o obezite a CKD (Október 2024) vyplýva niekoľko prakticky dôležitých bodov:</p>

<ul>
  <li>Najvyššie riziko vzniku CKD nesie <strong>dlhotrvajúca obezita so skorým začiatkom</strong> a dlhá kumulatívna expozícia – nie iba aktuálna hodnota BMI.</li>
  <li>Základom manažmentu zostáva úprava stravy, pohybová aktivita a súvisiace návyky; tieto stratégie však často zlyhávajú pri dosahovaní alebo udržaní úbytku hmotnosti, a to z mnohých dôvodov.</li>
  <li>Farmakoterapia vrátane agonistov receptora GLP-1 je účinná pri redukcii hmotnosti a má preukázaný renoprotektívny aj kardiovaskulárny prínos.</li>
  <li>Metabolická a bariatrická chirurgia preukázala prínos v znižovaní komplikácií súvisiacich s obezitou.</li>
  <li>Voľba stratégie sa mení podľa veku a komorbidít – a v čase.</li>
  <li>Komunikácia má byť vedená <strong>nehodnotiacim jazykom bez stigmatizácie</strong>, s cieľmi stanovenými spolu s pacientom a zameranými na postupné, dosiahnuteľné zmeny.</li>
</ul>

<p>Posledný bod nie je kozmetický. Stigmatizujúca komunikácia je sama osebe prekážkou úspešnej liečby obezity.</p>

<h2>Srdcové zlyhávanie a CKD</h2>

<p>Srdcové zlyhávanie je pri CKD veľmi časté a obe ochorenia sa navzájom zhoršujú. Diagnostika býva ťažšia, pretože sa príznaky prekrývajú a interpretácia natriuretických peptidov aj sérového kreatinínu je pri CKD zložitejšia. Zo záverov konferencie KDIGO o obličkách a srdcovom zlyhávaní (marec 2024) stoja za zdôraznenie tri body:</p>

<ul>
  <li><strong>Mierny pokles funkcie obličiek po nasadení odporúčanej liečby srdcového zlyhávania spravidla nevyžaduje jej vysadenie.</strong> Takýto pokles býva hemodynamický a nie je spojený s horšími výsledkami. Toto je v praxi najčastejší dôvod zbytočného prerušenia prospešnej liečby.</li>
  <li>SGLT2 inhibítory, blokátory systému renín–angiotenzín–aldosterón a novšie molekuly ako finerenón či agonisty receptora GLP-1 môžu byť prospešné v oboch populáciách, <strong>dôkazy pri pokročilej CKD však zostávajú obmedzené</strong>.</li>
  <li>Chýbajú diagnostické prahy pre srdcové zlyhávanie špecifické pre CKD a spresnená definícia akútneho poškodenia obličiek v kontexte srdcového zlyhávania.</li>
</ul>

<p>Praktickým dôsledkom je potreba úzkej spolupráce nefrológa a kardiológa – a spoločnej dohody o tom, aký pokles eGFR je ešte akceptovateľný.</p>

<h2>Praktický odkaz pre klinickú prax</h2>

<p>Hlavné posolstvo je jednoduché: <strong>CKD má byť aktívne vyhľadávaná, presne klasifikovaná a liečená ako centrálny uzol CKM syndrómu.</strong> V každodennej praxi to znamená:</p>

<ol>
  <li>myslieť na CKD už v primárnej starostlivosti,</li>
  <li>vyšetrovať eGFR <em>aj</em> albuminúriu, nie iba kreatinín,</li>
  <li>neodkladať potvrdenie diagnózy pri podozrení na CKD,</li>
  <li>individualizovať liečbu podľa kategórie G, kategórie A a celkového klinického rizika,</li>
  <li>zapojiť multidisciplinárny tím,</li>
  <li>cieliť súčasne na zníženie renálneho, kardiovaskulárneho aj metabolického rizika.</li>
</ol>

<h2>Čo prehľad nerieši</h2>

<p>Ide o prehľadovú prácu, nie o systematickú syntézu s vlastnou metaanalýzou. Zhŕňa a prepája existujúce dokumenty KDIGO, pričom časť z nich sú závery konferencií bez gradovaných odporúčaní. Odporúčanie o lipidoch pochádza z roku 2013 a od jeho vydania sa terapeutické možnosti podstatne rozšírili. Odporúčanie pre srdcové zlyhávanie pri CKD v čase publikácie ešte neexistovalo. Prehľad preto treba čítať ako mapu dostupného rámca, nie ako zdroj nových dôkazov.</p>

<h2>Záver</h2>

<p>Prehľad Levina a kolektívu presvedčivo ukazuje, že KDIGO už dnes poskytuje praktický a dôkazmi podložený rámec pre manažment ľudí s CKM syndrómom. Najdôležitejšie princípy sú skorá diagnostika, presná klasifikácia CKD, dôraz na albuminúriu, integrovaná kontrola tlaku, glykémie, lipidov, hmotnosti a fajčenia, využitie liekov s preukázaným renálnym aj kardiovaskulárnym prínosom a multidisciplinárna spolupráca.</p>

<p>Pre nefrológiu je to zároveň príležitosť ukázať, že oblička nie je na okraji kardiometabolickej medicíny, ale priamo v jej strede.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=acc-aha-ckm-syndrom-prve-odporucanie">CKM syndróm: prvé odporúčanie ACC/AHA</a></li>
  <li><a href="article.php?slug=5-kritickych-chyb-manazment-ckm-syndromu-nefrologia">Päť kritických chýb v manažmente CKM syndrómu</a></li>
  <li><a href="article.php?slug=kdigo-2024-od-stadii-ckd-k-personalizovanemu-odhadu-rizika">KDIGO 2024: od štádií CKD k personalizovanému odhadu rizika</a></li>
  <li><a href="article.php?slug=cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax">Cieľový systolický tlak pod 120 mmHg pri CKD v reálnej praxi</a></li>
  <li><a href="article.php?slug=obezita-a-oblicky">Obezita a obličky</a></li>
</ul>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Levin A, Bansal N, de Boer IH, Grams ME, Jadoul M, ter Maaten JM, Mustafa RA, Rossing P, Cheung M, King JM, Earley A, Stevens PE. The kidney in the middle: Kidney Disease: Improving Global Outcomes (KDIGO) guidelines address multiple key components of cardiovascular-kidney-metabolic syndrome. <em>Kidney International</em>. 2026;110(3):570–582. doi:10.1016/j.kint.2026.03.031. PMID 42191113. <a href="https://doi.org/10.1016/j.kint.2026.03.031" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42191113/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Ďalšie zdroje:</strong></em></p>

<ol>
  <li><small><em>Ndumele CE, Neeland IJ, Tuttle KR, a kol. A Synopsis of the Evidence for the Science and Clinical Management of Cardiovascular-Kidney-Metabolic (CKM) Syndrome: A Scientific Statement From the American Heart Association. <em>Circulation</em>. 2023;148(20):1636–1664. doi:10.1161/CIR.0000000000001186. PMID 37807920. <a href="https://doi.org/10.1161/CIR.0000000000001186" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37807920/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Furth SL, Colhoun HM, Kanbay M, a kol. The relationship between obesity and chronic kidney disease: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney International</em>. 2026;109(3):442–464. doi:10.1016/j.kint.2025.09.019. PMID 41176308. <a href="https://doi.org/10.1016/j.kint.2025.09.019" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41176308/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Lam CSP, Bozkurt B, Cherney DZI, a kol. Kidney disease and heart failure: recent advances and current challenges: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference. <em>Kidney International</em>. 2026;109(6):1095–1113. doi:10.1016/j.kint.2025.10.011. PMID 41791738. <a href="https://doi.org/10.1016/j.kint.2025.10.011" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41791738/" target="_blank" rel="noopener noreferrer">PubMed</a>. Súbežne publikované v <em>JACC: Heart Failure</em>. 2026;14(4):102943. doi:10.1016/j.jchf.2026.102943. PMID 41793402.</em></small></li>
  <li><small><em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
  <li><small><em>KDIGO 2021 Clinical Practice Guideline for the Management of Blood Pressure in Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/blood-pressure-in-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
  <li><small><em>KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
  <li><small><em>KDIGO Clinical Practice Guideline for Lipid Management in Chronic Kidney Disease (2013). <a href="https://kdigo.org/guidelines/lipids-in-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
</ol>

<p><small>Bibliografické údaje boli overené v databáze PubMed 17. septembra 2026. Text je odborným informačným materiálom a nenahrádza individuálne klinické rozhodnutie ani platné znenie citovaných odporúčaní.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kdigo_ckm_syndrom_oblicka_v_strede',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
