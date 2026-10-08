<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Diuretiká v nových štúdiách: účinnejšia dekongescia nie je automaticky lepšia prognóza',
    'slug' => 'diuretika-nove-studie-dekongescia-prognoza',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Nové štúdie spresňujú prínos acetazolamidu, tiazidov, torasemidu a spironolaktónu. Väčšia diuréza či rýchlejšia dekongescia samy osebe nezaručujú lepšiu prognózu.',
    'content' => <<<'HTML'
<p>Diuretiká zostávajú základom liečby kongescie pri srdcovom zlyhávaní a viaceré majú významné miesto aj v terapii artériovej hypertenzie. Novšie štúdie však pripomínajú, že väčší objem moču, pokles telesnej hmotnosti, úspešná dekongescia a dlhodobý klinický výsledok nie sú zameniteľné ukazovatele.</p>

<p>Z nefrologického hľadiska je rovnako dôležité správne interpretovať zmenu kreatinínu. Jeho prechodný vzostup počas účinnej dekongescie nemusí znamenať štruktúrne poškodenie obličiek, nemožno ho však automaticky označiť za neškodný. Rozhoduje klinický kontext, trend a sprievodné známky perfúzie, objemového stavu a orgánového poškodenia.</p>

<figure>
  <picture>
    <source srcset="img/diuretika-nove-studie-dekongescia-prognoza.webp" type="image/webp">
    <img src="img/diuretika-nove-studie-dekongescia-prognoza.png" alt="Prepojenie srdca, obličky a nefrónu pri sekvenčnej diuretickej liečbe a rovnováhe medzi dekongesciou a renálnou bezpečnosťou" width="1600" height="1000" loading="lazy">
  </picture>
  <figcaption>Diuretická odpoveď vzniká na viacerých úrovniach nefrónu. Intenzívnejšia blokáda môže zlepšiť dekongesciu, zároveň však zvyšuje nároky na sledovanie funkcie obličiek, elektrolytov a hemodynamiky.</figcaption>
</figure>

<h2>Rozličné lieky odpovedajú na rozličné klinické otázky</h2>

<p>Slučkové diuretiká inhibujú kotransportér Na<sup>+</sup>/K<sup>+</sup>/2Cl<sup>−</sup> v hrubom vzostupnom ramienku Henleho slučky. Tiazidy a tiazidom podobné diuretiká blokujú kotransportér Na<sup>+</sup>/Cl<sup>−</sup> v distálnom stočenom kanáliku. Acetazolamid inhibuje karboanhydrázu a znižuje proximálnu reabsorpciu hydrogénuhličitanu a sodíka. Antagonisty mineralokortikoidových receptorov blokujú účinok aldosterónu; ich prognostický význam v niektorých fenotypoch srdcového zlyhávania nemožno redukovať na relatívne slabý natriuretický účinok.</p>

<p>Výsledok štúdie akútnej dekongescie preto nemožno mechanicky preniesť na dlhodobú liečbu hypertenzie. Rovnako nemožno výsledok jednej molekuly v jednej kategórii srdcového zlyhávania považovať za hodnotenie celej liekovej skupiny vo všetkých indikáciách.</p>

<h2>ADVOR: lepšia skorá dekongescia bez preukázanej prognostickej výhody</h2>

<p>V randomizovanej, dvojito zaslepenej štúdii ADVOR bolo 519 hospitalizovaných pacientov s akútne dekompenzovaným srdcovým zlyhávaním, klinickými známkami objemového preťaženia a zvýšenou koncentráciou natriuretických peptidov zaradených na intravenózny acetazolamid 500 mg raz denne alebo placebo. Obe ramená dostávali štandardizovaný intravenózny slučkový diuretický režim.</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky štúdie ADVOR" tabindex="0">
<table>
  <thead><tr><th scope="col">Výsledok</th><th scope="col">Acetazolamid</th><th scope="col">Placebo</th><th scope="col">Odhad účinku</th></tr></thead>
  <tbody>
    <tr><th scope="row">Úspešná dekongescia do 3 dní</th><td>42,2 %</td><td>30,5 %</td><td>RR 1,46; 95 % IS 1,17–1,82</td></tr>
    <tr><th scope="row">Úmrtie alebo rehospitalizácia pre srdcové zlyhávanie do 3 mesiacov</th><td>29,7 %</td><td>27,8 %</td><td>HR 1,07; 95 % IS 0,78–1,48</td></tr>
  </tbody>
</table>
</div>

<p>Acetazolamid zvýšil aj kumulatívnu diurézu a natriurézu. Štúdia však <strong>preukázala účinnejšiu skorú dekongesciu, nie pokles mortality alebo rehospitalizácií</strong>. Neutrálna hodnota sekundárneho klinického ukazovateľa navyše nedokazuje ekvivalenciu oboch stratégií, pretože interval spoľahlivosti pripúšťa klinicky relevantný prínos aj riziko.</p>

<p>Výsledok podporuje krátkodobé pridanie acetazolamidu u vhodne vybraných hospitalizovaných pacientov s pretrvávajúcou kongesciou. Nie je dôkazom pre jeho rutinné dlhodobé podávanie ani univerzálnym dávkovacím návodom bez zohľadnenia funkcie obličiek, acidobázického stavu, elektrolytov, krvného tlaku a kontraindikácií.</p>

<h2>Renálna analýza ADVOR: kreatinín stúpal častejšie, prognóza nie</h2>

<p>Vopred špecifikovaná analýza ADVOR definovala zhoršenie funkcie obličiek ako vzostup kreatinínu najmenej o 0,3 mg/dl počas liečby. Vyskytlo sa pri acetazolamide častejšie než pri placebe, 40,5 % oproti 18,9 % (p &lt; 0,001). Po troch mesiacoch sa koncentrácia kreatinínu medzi ramenami nelíšila (p = 0,565) a tento prechodný vzostup nebol spojený s vyšším výskytom hospitalizácie pre srdcové zlyhávanie alebo mortality. Úspešná dekongescia pri prepustení bola naopak spojená s lepšími výsledkami bez ohľadu na vznik tejto laboratórnej udalosti.</p>

<p>Nejde o dôkaz, že vzostup kreatinínu je vždy benígny. Štúdia hodnotila konkrétnu populáciu, časové okno a definíciu udalosti. V praxi treba rozlišovať hemokoncentráciu a hemodynamickú zmenu filtrácie pri úspešnej dekongescii od hypovolémie, hypotenzie, pokračujúcej oligúrie, liekovej toxicity, obštrukcie alebo skutočného poškodenia parenchýmu.</p>

<h2>CLOROTIC: sekvenčná blokáda zvyšuje účinok aj renálne riziko</h2>

<p>V štúdii CLOROTIC bolo 230 pacientov s akútnym srdcovým zlyhávaním randomizovaných na perorálny hydrochlorotiazid alebo placebo pridané k intravenóznemu furosemidu. Po 72 hodinách bol pokles telesnej hmotnosti väčší pri hydrochlorotiazide: 2,3 kg oproti 1,5 kg; upravený odhad rozdielu bol 1,14 kg (95 % IS 0,42–1,84; p = 0,002). Dvadsaťštyrihodinová diuréza bola vyššia, ale rozdiel v pacientom hodnotenej dýchavici nebol štatisticky významný.</p>

<p>Cenou za intenzívnejšiu odpoveď bol častejší výskyt zhoršenia funkcie obličiek, 46,5 % oproti 17,2 % (p &lt; 0,001). Štúdia nepreukázala rozdiel v mortalite ani rehospitalizáciách. Fyziologickým podkladom je sekvenčná blokáda nefrónu: inhibícia distálnej reabsorpcie obmedzí kompenzačné spätné vstrebávanie sodíka po podaní slučkového diuretika.</p>

<p>ADVOR a CLOROTIC neboli vzájomným porovnaním acetazolamidu a hydrochlorotiazidu. Rozdiely medzi samostatnými štúdiami neumožňujú vyhlásiť jednu stratégiu za všeobecne účinnejšiu alebo bezpečnejšiu.</p>

<h2>Torasemid verzus furosemid: farmakokinetika nie je prognóza</h2>

<p>Pragmatická randomizovaná štúdia TRANSFORM-HF zaradila 2 859 pacientov prepustených po hospitalizácii pre srdcové zlyhávanie. Úmrtie z akejkoľvek príčiny nastalo u 26,1 % pacientov v stratégii s torasemidom a u 26,2 % v stratégii s furosemidom (HR 1,02; 95 % IS 0,89–1,18). Kombinácia úmrtia alebo hospitalizácie počas 12 mesiacov sa tiež významne nelíšila (HR 0,92; 95 % IS 0,83–1,02).</p>

<p>Predvídateľnejšia biologická dostupnosť torasemidu tak sama osebe neviedla k mortalitnej výhode. Výber medzi liekmi môže naďalej závisieť od individuálnej odpovede, absorpcie, adherencie, dávkovacieho režimu a dostupnosti, nie však od očakávanej prognostickej superiority.</p>

<p>Veľká observačná analýza 328 640 párovaných poistencov Medicare následne zaznamenala pri torasemide mierne nižší výskyt kombinovaného ukazovateľa mortality a príhod súvisiacich so srdcovým zlyhávaním (HR 0,97; 95 % IS 0,95–0,99), ale vyšší výskyt akútneho poškodenia obličiek (HR 1,12; 95 % IS 1,10–1,15). Ani dôsledné párovanie nedokáže vylúčiť reziduálne zmätenie indikáciou. Tieto údaje sú bezpečnostným signálom, nie dôkazom kauzality ani dôvodom na plošnú zámenu lieku.</p>

<h2>Chlórtalidón a hydrochlorotiazid: bez preukázanej nefroprotekčnej superiority</h2>

<p>V sekundárnej analýze pragmatickej Diuretic Comparison Project sa primárny renálny kombinovaný ukazovateľ vyskytol u 369 z 6 118 pacientov liečených chlórtalidónom (6,0 %) a u 396 zo 6 147 pacientov liečených hydrochlorotiazidom (6,4 %); HR 0,94 (95 % IS 0,81–1,08; p = 0,37). Chlórtalidón teda nepreukázal prevahu v prevencii renálnych výsledkov. V hlavnej analýze štúdie bola hypokaliémia častejšia pri chlórtalidóne, 6,0 % oproti 4,4 %.</p>

<p>Záver neznamená, že lieky majú za všetkých okolností rovnaký antihypertenzný účinok ani že chlórtalidón nemá miesto v liečbe hypertenzie. Pri výbere treba zohľadniť trvanie účinku, krvný tlak, funkciu obličiek, elektrolyty, toleranciu a súbežnú liečbu; rovnaký počet miligramov nepredstavuje ekvivalentnú dávku.</p>

<h2>SPIRIT-HF: dôležitý, ale zatiaľ predbežný výsledok</h2>

<p>Štúdia SPIRIT-HF zahŕňala 730 pacientov so srdcovým zlyhávaním so zachovanou alebo mierne zníženou ejekčnou frakciou. Podľa oficiálnej správy ACC bol po 24 mesiacoch primárny kombinovaný ukazovateľ hospitalizácie pre srdcové zlyhávanie a kardiovaskulárneho úmrtia 12,7 udalosti na 100 pacientorokov pri spironolaktóne a 10,8 pri placebe; rozdiel nebol štatisticky významný. Pri spironolaktóne sa častejšie vyskytovali hospitalizácie, hypotenzia, renálne udalosti a hyperkaliémia.</p>

<p>Interpretáciu výrazne obmedzuje predčasné ukončovanie študijnej liečby, zásah pandémie COVID-19 a nedostatočná štatistická sila. Výsledok bol prezentovaný na ACC.26; k dátumu prípravy článku nejde o plne publikovanú recenzovanú štúdiu. Nemožno ho preniesť na srdcové zlyhávanie so zníženou ejekčnou frakciou ani na iné indikácie spironolaktónu či na všetky antagonisty mineralokortikoidových receptorov.</p>

<h2>Ako interpretovať vzostup kreatinínu počas dekongescie</h2>

<div class="table-responsive" role="region" aria-label="Klinické hodnotenie zmeny kreatinínu počas dekongescie" tabindex="0">
<table>
  <thead><tr><th scope="col">Oblasť</th><th scope="col">Otázka pri lôžku pacienta</th></tr></thead>
  <tbody>
    <tr><th scope="row">Kongescia</th><td>Ustupujú opuchy, dýchavica, ascites a známky venózneho preťaženia?</td></tr>
    <tr><th scope="row">Perfúzia</th><td>Je tlak a periférna perfúzia stabilná, bez ortostatických ťažkostí či známok šoku?</td></tr>
    <tr><th scope="row">Diuréza</th><td>Je odpoveď primeraná, alebo vzniká oligúria napriek pretrvávajúcej kongescii?</td></tr>
    <tr><th scope="row">Trend</th><td>Ide o malý stabilizovaný posun, alebo o pokračujúce zhoršovanie kreatinínu a močoviny?</td></tr>
    <tr><th scope="row">Vnútorné prostredie</th><td>Vzniká závažná porucha sodíka, draslíka, magnézia alebo acidobázickej rovnováhy?</td></tr>
    <tr><th scope="row">Alternatívna príčina</th><td>Je prítomná infekcia, krvácanie, obštrukcia, nefrotoxická alebo hemodynamicky riziková súbežná liečba?</td></tr>
  </tbody>
</table>
</div>

<p>Pri akútnej zmene kreatinínu treba navyše eGFR interpretovať opatrne, pretože bežné rovnice predpokladajú približne ustálenú tvorbu a koncentráciu kreatinínu. Rozhodnutie pokračovať, znížiť alebo prerušiť diuretickú liečbu preto nemá stáť na jedinom laboratórnom výsledku.</p>

<h2>Bezpečnejší postup pri kombinovaní diuretík</h2>

<ol>
  <li><strong>Potvrdiť pretrvávajúcu kongesciu.</strong> Nízka diuréza bez kongescie nie je sama osebe indikáciou na ďalšie diuretikum.</li>
  <li><strong>Optimalizovať základný režim.</strong> Overiť dávku a cestu podania slučkového diuretika, adherenciu, príjem sodíka a lieky oslabujúce odpoveď, najmä nesteroidové antiflogistiká.</li>
  <li><strong>Zvoliť doplnkový mechanizmus podľa fenotypu.</strong> Sekvenčná blokáda má byť cielená a časovo prehodnocovaná, nie automatické vrstvenie liekov.</li>
  <li><strong>Sledovať účinok aj bezpečnosť.</strong> Hodnotiť bilanciu tekutín, hmotnosť, klinické známky kongescie a hypovolémie, tlak, diurézu, kreatinín, močovinu, sodík, draslík a podľa situácie magnézium a acidobázický stav.</li>
  <li><strong>Po dekongescii liečbu deeskalovať.</strong> Režim účinný počas akútnej hospitalizácie nemusí byť vhodný na dlhodobú ambulantnú liečbu.</li>
</ol>

<h2>Záver</h2>

<p>Nové údaje nepodporujú jediné „najlepšie“ diuretikum. Acetazolamid aj hydrochlorotiazid môžu zosilniť skorú dekongesciu, no za cenu častejších laboratórnych zmien funkcie obličiek a bez preukázanej prognostickej výhody. Torasemid nepreukázal mortalitnú prevahu nad furosemidom, chlórtalidón nebol nefroprotektívne lepší než hydrochlorotiazid a výsledok SPIRIT-HF zostáva limitovaný a predbežný.</p>

<p>Najrozumnejším cieľom preto nie je maximalizovať diurézu, ale dosiahnuť klinicky primeranú dekongesciu pri zachovaní perfúzie a kontrolovateľnom riziku. Zmenu kreatinínu treba posudzovať v tomto kontexte, nie izolovane.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>Mullens W, et al. Acetazolamide in Acute Decompensated Heart Failure with Volume Overload. <em>N Engl J Med.</em> 2022;387:1185–1195. <a href="https://pubmed.ncbi.nlm.nih.gov/36027559/" target="_blank" rel="noopener noreferrer">PubMed PMID 36027559</a>.</em></small></p>
<p><small><em>Meekers E, et al. Renal function and decongestion with acetazolamide in acute decompensated heart failure: the ADVOR trial. <em>Eur Heart J.</em> 2023;44:3672–3682. <a href="https://pubmed.ncbi.nlm.nih.gov/37623428/" target="_blank" rel="noopener noreferrer">PubMed PMID 37623428</a>.</em></small></p>
<p><small><em>Trullàs JC, et al. Combining loop with thiazide diuretics for decompensated heart failure: the CLOROTIC trial. <em>Eur Heart J.</em> 2023;44:411–421. <a href="https://pubmed.ncbi.nlm.nih.gov/36423214/" target="_blank" rel="noopener noreferrer">PubMed PMID 36423214</a>.</em></small></p>
<p><small><em>Mentz RJ, et al. Effect of Torsemide vs Furosemide After Discharge on All-Cause Mortality in Patients Hospitalized With Heart Failure: The TRANSFORM-HF Randomized Clinical Trial. <em>JAMA.</em> 2023;329:214–223. <a href="https://pubmed.ncbi.nlm.nih.gov/36648467/" target="_blank" rel="noopener noreferrer">PubMed PMID 36648467</a>.</em></small></p>
<p><small><em>Mentias A, et al. Comparative Effectiveness and Safety of Torsemide Versus Furosemide in Older Adults With Heart Failure. <em>J Am Coll Cardiol.</em> 2025. <a href="https://pubmed.ncbi.nlm.nih.gov/40130803/" target="_blank" rel="noopener noreferrer">PubMed PMID 40130803</a>.</em></small></p>
<p><small><em>Ishani A, et al. Chlorthalidone vs Hydrochlorothiazide and Kidney Outcomes in Patients With Hypertension: A Secondary Analysis of a Randomized Clinical Trial. <em>JAMA Netw Open.</em> 2024;7:e2442052. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11632543/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>
<p><small><em>American College of Cardiology. Study Finds No Significant Benefit of Spironolactone in HFpEF or HFmrEF. Tlačová správa k štúdii SPIRIT-HF, 29. marca 2026. <a href="https://www.acc.org/about-acc/press-releases/2026/03/29/14/57/study-finds-no-significant-benefit-of-spironolactone-in-hfpef-or-hfmref" target="_blank" rel="noopener noreferrer">ACC.26</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_diuretika-nove-studie-dekongescia-prognoza_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
