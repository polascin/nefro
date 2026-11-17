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
    'title' => 'Umelá inteligencia vo výučbe medicíny: mapa kurikula a simulovaný pacient',
    'slug' => 'ai-mapovanie-kurikula-simulovany-pacient-vzdelavanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt' => 'Dve novembrové štúdie ukazujú, kde môže AI v medicínskom vzdelávaní pomôcť: pri mapovaní kurikula a pri nácviku rozhovoru s pacientom. Dôkaz o lepšom učení zatiaľ chýba.',
    'content'      => <<<'HTML'
<figure><a href="img/ai-mapovanie-kurikula-simulovany-pacient-vzdelavanie.webp" rel="noopener noreferrer" target="_blank"><img src="img/ai-mapovanie-kurikula-simulovany-pacient-vzdelavanie.webp" alt="Ilustračná scéna: sieť prepojených uzlov učiva a štylizovaná oblička na tmavom pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna k téme umelej inteligencie v medicínskom vzdelávaní. Nejde o snímku konkrétneho pacienta, učebne ani softvéru.</figcaption></figure>

<p>V polovici novembra 2026 vyšli dve práce, ktoré ukazujú, kde môže umelá inteligencia (AI) vo výučbe medicíny pomôcť už dnes a kde sa jej prínos zatiaľ len odhaduje. Prvá opisuje, ako lekárska fakulta Texas A&amp;M prebudovala správu kurikula na relačnú databázu s AI agentom. Druhá skúšala, či má študent s AI simulovaným pacientom pracovať sám, alebo v skupine pod vedením pedagóga.</p>

<p>Obe štúdie sú malé a ani jedna nemeria, či sa študenti naučili viac. Pre toho, kto pripravuje výučbu nefrológie, sú napriek tomu užitočné: prvá ponúka overiteľný model organizácie učiva, druhá prakticky použiteľný formát simulácie. Kontrolované štúdie s AI pacientmi, ktoré vyšli v posledných mesiacoch, pomáhajú odhadnúť, čo od takejto simulácie čakať.</p>

<h2>Mapa kurikula ako relačná databáza</h2>

<p>Badeau a spolupracovníci z Naresh K. Vashisht College of Medicine opísali rámec, ktorý fakulta zaviedla v akademickom roku 2025/2026 [1]. Nahradil každoročné ručne skladané prehľady v tabuľkovom procesore. Učebné ciele jednotlivých výučbových jednotiek sa každý rok zozbierajú a jazykový model k nim navrhne väzby na programové ciele a ciele predmetu, kódy obsahového rámca skúšky USMLE, kľúčové slová AAMC a úroveň podľa Bloomovej taxonómie. Návrhy overuje odborný tím a až overené záznamy sa uložia do relačnej databázy (Airtable). Vyučujúci v nej môžu vyhľadávať, ale nie zapisovať. Druhý AI agent cez API z databázy na požiadanie zostavuje prehľady rozsahu a nadväznosti učiva, duplicít, medzier a súladu so skúškovými požiadavkami. Rámec pokrýva všetkých 16 predklinických predmetov a všetky klinické stáže. Na navrhovanie značiek autori použili model Claude Sonnet 5 cez API.</p>

<p>Prínos ilustrujú konkrétne výstupy. Porovnanie dvoch predklinických predmetov našlo za niekoľko minút 50 párov zhodných učebných cieľov v troch patologických doménach. Analýza súladu so skúškou USMLE Step 1 naprieč 16 predmetmi ukázala, že patológia tvorí 42 % obsahu, kým fakulta si stanovila cieľ 45 až 55 %. Autori uvádzajú, že tento deficit opisne zodpovedal výsledkom študentov fakulty, formálne to však netestovali. V klinických stážach bolo zdokumentovaných 24 z 25 programových cieľov (96 %); jeden cieľ nemal v žiadnej stáži zodpovedajúci učebný cieľ, a táto medzera dovtedy nebola sledovaná.</p>

<h3>Ako presne AI učebné ciele zaradila</h3>

<p>Na overenie zaradenia traja nezávislí garanti predmetov naslepo zakódovali vzorku 30 učebných cieľov. Zhoda troch hodnotiteľov a databázy (Fleissovo κ) bola na úrovni presného kódu podstatná, κ = 0,67 (95 % IS 0,55 až 0,78), a na úrovni širšej domény takmer úplná, κ = 0,94 (95 % IS 0,88 až 1,00). Za priemerom sa skrýva rozdiel medzi hodnotiteľmi: dvaja sa medzi sebou aj s databázou zhodovali tesne (κ 0,82 až 0,89 pri presnom kóde), tretí výrazne menej (κ 0,47 až 0,55). Väčšina nezhôd sa týkala obsahu na rozhraní dvoch susedných kategórií, nie chyby databázy. Jednu položku, pri ktorej sa databáza odlišovala od všetkých troch hodnotiteľov, autori opravili.</p>

<p>Validácia prebehla až dodatočne. Pri prvom nasadení sa nezaznamenávalo, koľko návrhov AI tím prijal a koľko opravil, a úspora práce sa formálne nemerala. Štúdia teda ukazuje, že takýto systém sa dá zaviesť a dáva zmysluplné prehľady. Neukazuje, že by zlepšil výsledky študentov.</p>

<h2>Simulovaný pacient: samostatne, v skupine, alebo oboje</h2>

<p>Tischkau a spolupracovníci zo Southern Illinois University School of Medicine porovnali dva spôsoby práce s rovnakým AI simulovaným pacientom v prvom ročníku [2]. Platforma vyvinutá na fakulte kombinuje jazykový model s hlasovou konverzáciou a avatarom. Zo 72 oslovených študentov sa zapojilo 19 (26 %). Sedem z nich viedlo rozhovor spoločne v učebni pod vedením pedagóga, pacient sa premietal na veľkú obrazovku. Dvanásť ďalších riešilo rovnaký prípad samostatne vlastným tempom, o dva týždne neskôr.</p>

<p>Všetci študenti rozhovor dokončili a vyplnili dotazníky pred ním aj po ňom. Žiadne stretnutie sa pre technickú poruchu neukončilo, študenti však opisovali opakované technické výpadky, ktoré rozhovor prerušili. Skupinové stretnutie trvalo približne 35 minút, samostatné rozhovory s mediánom 31 minút (17 až 83). Zmeny v dotazníku boli malé a nepresné. Najväčší posun, nárast pocitu psychologického bezpečia v samostatnej kohorte (Wilcoxonovo r = 0,62), bol významný len pred korekciou na viacnásobné porovnania (p = 0,026; po korekcii p = 0,20). Medzi kohortami sa nezistil významný rozdiel. Položka o motivácii pripravovať sa na výučbu klesla v oboch kohortách o jeden bod mediánu.</p>

<p>Najčastejšie preferovaným formátom bol hybrid „najprv samostatne, potom v skupine“: zvolilo ho 7 z 12 študentov (58 %). Otázku na preferenciu však dostala iba samostatná kohorta. Kohorty neboli randomizované a líšili sa termínom, verziou platformy, prostredím aj prítomnosťou spolužiakov. Použitý dotazník zatiaľ nebol psychometricky validovaný. Jeden z autorov je uvedený ako pôvodca prihlášky patentu na prvky použitej technológie; štatistické analýzy preto podľa autorov pripravil nezávisle iný spoluautor. Výsledok je teda dôkazom uskutočniteľnosti a prijateľnosti, nie účinnosti.</p>

<h2>Čo ukazujú kontrolované štúdie</h2>

<p>Na otázku, či AI pacient zlepšuje skutočný komunikačný výkon, odpovedajú presnejšie tri randomizované štúdie. Ich výsledky sa navzájom nevylučujú, ale zreteľne ukazujú, aký veľký rozdiel je medzi sebahodnotením a objektívnym meraním.</p>

<div class="table-responsive" role="region" aria-label="Randomizované štúdie s AI simulovaným pacientom" tabindex="0">
<table>
<thead>
<tr><th scope="col">Štúdia</th><th scope="col">Porovnanie</th><th scope="col">Hlavný výsledok</th></tr>
</thead>
<tbody>
<tr><th scope="row">Tyrrell a spol., 2025 [4]</th><td>Jedno AI stretnutie s hlasovým rozpoznávaním vs. jedno stretnutie s hercom; 378 študentov, 2 britské fakulty, krížový dizajn</td><td>Sebahodnotenie sa zlepšilo pri oboch, pri AI o 0,36 bodu menej na 10-bodovej škále (95 % IS 0,13 až 0,60; p = 0,04); nižšia spokojnosť (8,09 vs. 9,21); náklady 33,48 vs. 61,75 libry na študenta</td></tr>
<tr><th scope="row">Haut a spol., 2026 [5]</th><td>Tri moduly s virtuálnym pacientom SOPHIE (30 min) vs. čítanie textu v rovnakom rozsahu; 51 študentov a klinikov</td><td>Väčšie zlepšenie komunikácie pri rozhovore o závažnom ochorení podľa zaslepených hodnotiteľov (celkové skóre β = 0,09; 95 % IS 0,04 až 0,14; p = 0,001)</td></tr>
<tr><th scope="row">Wang a spol., 2026 [3]</th><td>Chatbot SimPatient počas celého akademického roka vs. bežná výučba; 50 študentov, nezaslepené</td><td>Výkon v OSCE rástol v oboch skupinách; v AI skupine opisne viac, rozdiel nebol štatisticky významný</td></tr>
</tbody>
</table>
</div>

<p>Najsilnejší pozitívny výsledok (SOPHIE) vznikol pri porovnaní s pasívnym čítaním a meral sa hneď po krátkom tréningu. Pri porovnaní so živým hercom mal AI formát v sebahodnotení mierne horší výsledok, bol však lacnejší. Celoročná štúdia s objektívnym hodnotením v OSCE nezistila významný rozdiel. Nevýznamný rozdiel pritom neznamená, že sú oba postupy rovnocenné: štúdia na to nemala dizajn ani veľkosť.</p>

<h2>Čo z toho môže použiť nefrologická výučba</h2>

<p>Nasledujúce body sú redakčná interpretácia, nie výsledok uvedených štúdií. Ani jedna z nich neskúmala nefrologickú výučbu.</p>

<p><strong>Mapa nefrologického učiva.</strong> Model z Texasu sa dá preniesť aj na menší rozsah, napríklad na kurz nefrológie alebo atestačnú prípravu. Každá výučbová jednotka by mala mať konkrétny učebný cieľ, úroveň podľa Bloomovej taxonómie, kompetenciu, na ktorú nadväzuje, odporúčané zdroje, súvisiace testové otázky či simulácie a väzby na predchádzajúce a nasledujúce témy. AI môže navrhovať značky a hľadať chýbajúce alebo opakované témy, napríklad či sa acidobázická rovnováha preberá vo fyziológii, vnútornom lekárstve aj nefrológii na rovnakej úrovni. Každé zaradenie by však mal potvrdiť odborník a jeho presnosť by sa mala priebežne sledovať, nie až dodatočne. Vhodnou architektúrou je databáza s overenými záznamami, nad ktorou model len vyhľadáva a zhŕňa, nie voľné generovanie odpovedí z pamäte modelu.</p>

<p><strong>Simulácia v troch krokoch.</strong> Z druhej štúdie možno odvodiť formát, ktorý študenti preferovali a ktorý zodpovedá aj bežnej praxi simulačnej výučby: samostatný rozhovor študenta s AI pacientom, potom spätná väzba podľa vopred určenej hodnotiacej schémy a nakoniec spoločný rozbor rozhodnutí, chýb a alternatív s pedagógom. Vhodné sú situácie, v ktorých sa študent musí pýtať a vysvetľovať: prvé vyšetrenie pacienta s akútnym poškodením obličiek, hyperkaliémia u pacienta liečeného dialýzou, podozrenie na glomerulonefritídu, vysvetlenie potreby dialýzy, rozhovor o obmedzení tekutín a o adherencii či rozhovor o konzervatívnej liečbe bez dialýzy.</p>

<p><strong>Objektívne hodnotenie.</strong> Ak má simulácia nahradiť časť práce s hercami alebo pacientmi, nestačí, že sa po nej študent cíti istejšie. Výkon treba overiť zaslepeným hodnotením nahrávky alebo stanicou OSCE. V registri ClinicalTrials.gov je od októbra 2026 zaregistrovaná štúdia, ktorá v nefrologickej stáži porovnáva spätnú väzbu generovanú AI, pravidlami riadenú individualizovanú spätnú väzbu a skupinu bez spätnej väzby [6]. Jej výsledky zatiaľ nie sú k dispozícii.</p>

<h2>Ochrana údajov a závislosť od dodávateľa</h2>

<p>Do verejne dostupných AI služieb nepatria údaje skutočných pacientov, ani v „anonymizovanej“ podobe, ktorú možno pri zriedkavých diagnózach spätne priradiť. Simulačné prípady treba písať ako vymyslené. Hlasové nahrávky študentov sú osobné údaje, preto musí byť vopred jasné, kde sa spracúvajú, ako dlho sa uchovávajú a kto k nim má prístup; pri fakultnom nasadení to patrí do zmluvy s dodávateľom a do posúdenia podľa nariadenia (EÚ) 2016/679 (GDPR). Systém postavený na jednom externom modeli je od neho závislý: zmena modelu alebo cenových podmienok môže zmeniť správanie celého nástroja, preto má zmysel uchovávať overené dáta oddelene od modelu, ktorý nad nimi pracuje.</p>

<h2>Limity</h2>

<ul>
<li>Štúdia mapovania kurikula je implementačná, bez kontrolnej skupiny; validácia zaradenia prebehla dodatočne na 30 položkách s tromi hodnotiteľmi a úspora času sa nemerala [1].</li>
<li>Rámec je postavený na americkom kurikule a obsahovom rámci USMLE; jeho prenos do slovenského prostredia by vyžadoval vlastnú kódovaciu schému.</li>
<li>Štúdia formátov AI pacienta mala 19 účastníkov, jeden prípad, nerandomizované kohorty s viacerými mätúcimi faktormi a nevalidovaný dotazník; preferencia formátu pochádza od 12 študentov [2].</li>
<li>Kontrolované štúdie AI pacientov používajú rôzne platformy, populácie a výsledné ukazovatele, preto ich výsledky nemožno priamo spájať [3 až 5].</li>
<li>Žiadna z citovaných štúdií neskúmala výučbu nefrológie ani dopad na starostlivosť o pacientov.</li>
</ul>

<p><strong>Záver.</strong> Najbližšie k praktickému využitiu je AI podporované mapovanie kurikula, za podmienky, že každé zaradenie overí odborník a presnosť sa priebežne meria. Pri AI pacientoch sa ako rozumný postup javí samostatná práca, objektívne hodnotenie a ľudský rozbor; dôkaz, že takýto tréning zlepšuje komunikáciu s reálnymi pacientmi, zatiaľ chýba.</p>

<hr>

<p><small><em>Článok je určený zdravotníckym pracovníkom a pedagógom. Nenahrádza odborné posúdenie ani interné pravidlá fakulty či zdravotníckeho zariadenia pre používanie AI a ochranu osobných údajov.</em></small></p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Robert M. Badeau, Jennifer Laury, Danielle Dickey. An AI-Integrated Relational Curriculum Mapping Framework for Alignment and Transparency in Medical Education: Implementation Study. JMIR Medical Education. 2026;12:e107727.</em> <a target="_blank" rel="noopener noreferrer" href="https://mededu.jmir.org/2026/1/e107727">Vydavateľ</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.2196/107727">DOI</a> · <a target="_blank" rel="noopener noreferrer" href="https://pubmed.ncbi.nlm.nih.gov/43020473/">PubMed</a></small></li>
<li><small><em>Shelley Tischkau, James Lynch, Sean McGinity, Andrew Primous, Elijah Meldrim, Samantha Lynch, Richard Selinfreund. Feasibility of an AI-simulated patient encounter delivered in group and individual learning formats for first-year medical students: a two-cohort pilot study. BMC Medical Education. 2026, online 13. novembra 2026.</em> <a target="_blank" rel="noopener noreferrer" href="https://link.springer.com/article/10.1186/s12909-026-10812-8">Vydavateľ</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.1186/s12909-026-10812-8">DOI</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.21203/rs.3.rs-10627241/v1">Preprint (Research Square)</a></small></li>
<li><small><em>Xining Wang, Sandhya Duggal, Alun Hughes, Sayed Murad, Andrew O'Malley. Evaluating an AI-Powered Patient Simulator for Communication Skills Training: One-Year Randomized Controlled Trial. Journal of Medical Internet Research. 2026;28:e91886.</em> <a target="_blank" rel="noopener noreferrer" href="https://www.jmir.org/2026/1/e91886">Vydavateľ</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.2196/91886">DOI</a> · <a target="_blank" rel="noopener noreferrer" href="https://pubmed.ncbi.nlm.nih.gov/42987316/">PubMed</a></small></li>
<li><small><em>Edward G. Tyrrell, Sardip K. Sandhu, Kathryn Berry, Suzan F. Ghannam, Sarah A. Lewis, Daniel Crowfoot, Gurvinder Singh Sahota, Julie Carson, Emma E. Wilson, Jaspal Taggar. Web-Based AI-Driven Virtual Patient Simulator Versus Actor-Based Simulation for Teaching Consultation Skills: Multicenter Randomized Crossover Study. JMIR Formative Research. 2025;9:e71667.</em> <a target="_blank" rel="noopener noreferrer" href="https://formative.jmir.org/2025/1/e71667">Vydavateľ</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.2196/71667">DOI</a> · <a target="_blank" rel="noopener noreferrer" href="https://pubmed.ncbi.nlm.nih.gov/41264856/">PubMed</a> · <a target="_blank" rel="noopener noreferrer" href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12634008/">Plný text</a></small></li>
<li><small><em>Kurtis G. Haut, Masum Hasan, Thomas Carroll, Ronald M. Epstein, Taylan Sen, Ehsan Hoque. Effects of a Generative AI Virtual Patient on Serious Illness Communication Skills: Randomized Controlled Trial. JMIR Medical Education. 2026;12:e93034.</em> <a target="_blank" rel="noopener noreferrer" href="https://mededu.jmir.org/2026/1/e93034">Vydavateľ</a> · <a target="_blank" rel="noopener noreferrer" href="https://doi.org/10.2196/93034">DOI</a> · <a target="_blank" rel="noopener noreferrer" href="https://pubmed.ncbi.nlm.nih.gov/42902927/">PubMed</a> · <a target="_blank" rel="noopener noreferrer" href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13683997/">Plný text</a></small></li>
<li><small><em>AI-Generated and Rule-Based Individualized Feedback for Medical Students' Nephrology Learning. ClinicalTrials.gov, NCT07871526, registrácia 13. októbra 2026.</em> <a target="_blank" rel="noopener noreferrer" href="https://clinicaltrials.gov/study/NCT07871526">ClinicalTrials.gov</a></small></li>
</ol>

<p><small><em>Poznámka k dôkazom: bibliografické údaje prác 1, 3, 4 a 5 boli overené v PubMed, autorský zoznam práce 2 v Crossref a na stránke vydavateľa (PubMed ju v čase prípravy ešte neindexoval, číslo ročníka zatiaľ nebolo pridelené). Výsledky prác 1 a 2 vychádzajú zo štruktúrovaného abstraktu a z vybraných častí plného textu (metodika, výsledky validácie, limity, konflikt záujmov), výsledky prác 3 až 5 zo štruktúrovaných abstraktov v PubMed. Registrácia 6 bola overená len na úrovni identifikácie štúdie. Časť o využití v nefrologickej výučbe a o ochrane údajov je redakčná interpretácia autora.</em></small></p>

<h3>Súvisiace články</h3>
<ul>
<li><a href="article.php?slug=umela-inteligencia-nefrologicke-vzdelavanie-dokazy-hranice">Umelá inteligencia v nefrologickom vzdelávaní: možnosti, dôkazy a hranice</a></li>
<li><a href="article.php?slug=ai-nefrologicka-vyucba-kazuistika-hodnotenie">AI vo výučbe nefrológie: od kazuistiky k overeniu samostatných schopností</a></li>
</ul>
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
    'log_prefix' => 'add_ai-mapovanie-kurikula-simulovany-pacient-vzdelavanie_article',
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
