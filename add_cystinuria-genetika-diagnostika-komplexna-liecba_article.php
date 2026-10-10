<?php

/**
 * Odborný článok o cystínurii: patofyziológia, genetická diagnostika,
 * metabolická prevencia, tiolové lieky, urologická liečba a sledovanie.
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
    'title'        => 'Cystínuria: klinický obraz, genetická diagnostika a komplexná liečba',
    'slug'         => 'cystinuria-genetika-diagnostika-komplexna-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Cystínuria vyžaduje celoživotnú kombináciu vysokej diurézy, obmedzenia sodíka, riadenej alkalizácie a podľa aktivity ochorenia aj tiolovej liečby. Genotyp pomáha rodine, no liečbu určuje fenotyp.',
    'content'      => <<<'HTML'
<figure><a href="img/cystinuria-genetika-diagnostika-komplexna-liecba.webp" target="_blank" rel="noopener noreferrer"><img src="img/cystinuria-genetika-diagnostika-komplexna-liecba.webp" alt="Poloschematická oblička s cystínovým konkrementom a hexagonálnymi kryštálmi, prepojená so zväčšeným transportérom aminokyselín v proximálnom tubule a DNA" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna: porucha transportu cystínu v proximálnom tubule vedie k jeho nadmernému vylučovaniu, kryštalizácii a tvorbe konkrementov. Obrázok neznázorňuje konkrétneho pacienta ani presnú molekulovú štruktúru transportéra.</figcaption></figure>

<p>Cystínuria je dedičná porucha transportu aminokyselín, ktorá predisponuje k opakovanej tvorbe cystínových konkrementov. Často sa prejaví v prvých dvoch desaťročiach života, diagnóza v dospelosti však nie je výnimočná. Klinická závažnosť siaha od izolovaného zvýšeného vylučovania cystínu po opakovanú obojstrannú nefrolitiázu, obštrukcie, infekcie a chronickú chorobu obličiek.</p>

<p>Základom liečby je dostatočný objem moču, obmedzenie nadmerného príjmu sodíka a živočíšnych bielkovín a riadená alkalizácia moču. Pri pretrvávajúcej aktivite ochorenia sa pridáva liek viažuci cystín, prednostne tiopronín. <strong>Genetický výsledok objasňuje mechanizmus a dedičnosť, sám osebe však neurčuje farmakoterapiu.</strong> [1–3]</p>

<h2>Transportná porucha a vznik konkrementov</h2>

<p>V proximálnom tubule sa spätne vstrebáva väčšina prefiltrovaného cystínu a dvojzásaditých aminokyselín – lyzínu, arginínu a ornitínu. Pri cystínurii je narušený heterodimérny transportný komplex tvorený podjednotkami rBAT a b<sup>0,+</sup>AT1, ktoré kódujú gény <em>SLC3A1</em> a <em>SLC7A9</em>. Porucha sa týka aj črevného epitelu, klinickým problémom je však najmä nadmerné množstvo cystínu v moči. [2]</p>

<p>Cystín tvoria dve molekuly cysteínu spojené disulfidovou väzbou. V moči je málo rozpustný, najmä pri fyziologickom a kyslom pH. Riziko kryštalizácie závisí od denného vylučovania cystínu, objemu a pH moču, ďalšieho močového profilu a účinku prípadnej tiolovej liečby. Ostatné dotknuté aminokyseliny sú rozpustnejšie a porovnateľnú litiázu spravidla nespôsobujú.</p>

<p>Praktický cieľ, koncentrácia cystínu pod približne 250 mg/l (asi 1 mmol/l), nie je univerzálnou hranicou pri každom pH. Rozpustnosť cystínu sa s rastúcim pH výrazne zvyšuje. [1]</p>

<h3>Cystínuria nie je cystinóza</h3>
<p>Cystinóza je odlišné lyzozómové ochorenie, ktoré môže vyvolať Fanconiho syndróm a systémové poškodenie. Cysteamín používaný pri cystinóze nie je štandardnou liečbou cystínurie. Rozdiel nie je len terminologický: obe ochorenia majú odlišnú patofyziológiu, klinický obraz aj liečbu.</p>

<h2>Genetické formy a klinická interpretácia</h2>

<div class="table-responsive" role="region" aria-label="Genetické formy cystínurie a ich interpretácia" tabindex="0">
<table>
  <thead><tr><th scope="col">Forma</th><th scope="col">Molekulový nález</th><th scope="col">Interpretácia</th></tr></thead>
  <tbody>
    <tr><th scope="row">AA</th><td>Bialelické patogénne varianty <em>SLC3A1</em></td><td>Autozómovo recesívna cystínuria</td></tr>
    <tr><th scope="row">BB</th><td>Bialelické patogénne varianty <em>SLC7A9</em></td><td>Autozómovo recesívna cystínuria</td></tr>
    <tr><th scope="row">AB</th><td>Patogénny variant v každom z oboch génov</td><td>Zriedkavá digénová forma; nutné posúdenie patogenity a segregácie</td></tr>
    <tr><th scope="row">B0</th><td>Heterozygotný patogénny variant <em>SLC7A9</em></td><td>Často zvýšené vylučovanie aminokyselín; litiáza má redukovanú penetranciu</td></tr>
    <tr><th scope="row">A0</th><td>Heterozygotný patogénny variant <em>SLC3A1</em></td><td>Riziko sa nepredpokladá paušálne; dominantný fenotyp je doložený najmä pri špecifickej duplikácii exónov 5–9</td></tr>
  </tbody>
</table>
</div>

<p>Pri klasickej cystínurii dominuje autozómovo recesívna dedičnosť. Heterozygoti pre <em>SLC7A9</em> mávajú zvýšené vylučovanie cystínu a dvojzásaditých aminokyselín, ale nefrolitiázu rozvinie iba časť z nich. GeneReviews uvádza pri heterozygotných variantoch <em>SLC7A9</em> litiázu približne u 2–18 % osôb; presné riziko závisí od variantu a ďalších faktorov. [2]</p>

<p>Historické typy I, II a III vychádzali z močového fenotypu príbuzných a nemožno ich mechanicky stotožniť s dnešnou molekulovou klasifikáciou. <strong>Genotyp nie je spoľahlivým samostatným prediktorom závažnosti.</strong> Rozhodujúca je aktivita litiázy, močový profil, funkcia obličiek a tolerancia liečby.</p>

<h2>Klinický obraz a urgentné situácie</h2>

<p>Podozrenie zvyšuje skorý začiatok, opakované alebo obojstranné konkrementy, veľké či odliatkové konkrementy a rodinný výskyt. Prejavom môže byť renálna kolika, hematúria, odchod konkrementov, nauzea a vracanie, infekcia močových ciest, hydronefróza alebo akútne poškodenie obličiek pri obštrukcii. U detí môžu dominovať nešpecifické bolesti brucha, nepokoj alebo infekcie močových ciest.</p>

<p>Dlhodobé riziko chronickej choroby obličiek súvisí najmä s opakovanou obštrukciou, infekciami, vysokou záťažou konkrementmi a kumuláciou urologických intervencií. GeneReviews uvádza CKD približne u 20–25 % osôb s recesívnou cystínuriou, nie každý pacient však progreduje do zlyhania obličiek. [2]</p>

<p><strong>Horúčka pri obštrukcii močových ciest je urgentný stav.</strong> Infikovaný obštruovaný systém vyžaduje antibiotickú liečbu a bezodkladnú drenáž. Pokus o samotnú alkalizáciu alebo rozpúšťanie konkrementu je v tejto situácii nebezpečný.</p>

<h2>Diagnostika</h2>

<h3>Analýza konkrementu a močový sediment</h3>
<p>Dostupný konkrement sa má vyšetriť infračervenou spektroskopiou alebo röntgenovou difrakciou; makroskopický vzhľad ani semikvantitatívny chemický test nestačia. Ani pri známej cystínurii nemusí byť každý nový konkrement cystínový. Nadmerná alkalizácia môže podporiť tvorbu kalciumfosfátových konkrementov. [2]</p>

<p>Ploché hexagonálne kryštály cystínu sú vysoko charakteristické, ich neprítomnosť však diagnózu nevylučuje. Cyanidovo-nitroprusidový test môže slúžiť na skríning, pozitívny výsledok musí viesť ku kvantitatívnemu vyšetreniu.</p>

<h3>Kvantifikácia a zobrazovanie</h3>
<p>U dospelého je vhodný 24-hodinový zber moču s vyšetrením cystínu, objemu, pH, sodíka a kreatinínu; podľa situácie sa dopĺňa celý profil rizikových faktorov litiázy. Treba odlišovať denné vylučovanie cystínu, jeho koncentráciu a presýtenie moču. Pri dostatočnej diuréze môže byť koncentrácia priaznivá aj pri vysokom dennom vylučovaní.</p>

<p>Ultrasonografia je vhodná na opakované sledovanie bez žiarenia. Pri akútnej situácii alebo nejasnom náleze sa používa nízkodávkové CT bez kontrastnej látky. Cystínové konkrementy nie sú úplne rádiolucentné, na natívnej snímke však môžu byť menej nápadné než kalciové.</p>

<h2>Úloha genetického vyšetrenia</h2>

<p>Genetický test nie je podmienkou na začatie liečby jednoznačne potvrdenej cystínovej litiázy. Je však užitočný pri veľmi skorom začiatku, atypickom alebo nejasnom biochemickom náleze, rodinnom a reprodukčnom poradenstve, interpretácii heterozygotného nálezu a podozrení na širšiu syndrómovú diagnózu.</p>

<p>Vyšetrenie <em>SLC3A1</em> a <em>SLC7A9</em> má zahŕňať sekvenčnú analýzu aj metódu schopnú zachytiť relevantné delécie a duplikácie. Pri neúplných údajoch alebo širšom fenotype je vhodný panel génov dedičnej nefrolitiázy. <strong>Variant neistého významu sám osebe diagnózu nepotvrdzuje.</strong> Jeden nájdený variant nevylučuje druhý variant nezachytený použitou metódou. [2]</p>

<p>Súrodenci pacienta majú byť vyšetrení aj bez príznakov. Skríning môže zahŕňať aminokyseliny v moči, ultrasonografiu a pri známych rodinných variantoch cielené genetické vyšetrenie. [2,3]</p>

<h2>Liečba sa riadi aktivitou ochorenia</h2>

<p>Pri zvýšenom vylučovaní cystínu bez konkrementov sa postup individualizuje podľa koncentrácie cystínu, pH a objemu moču, veku a rodinnej anamnézy. Samotné heterozygotné nosičstvo automaticky neznamená indikáciu tiopronínu.</p>

<p>Pri potvrdenej cystínovej litiáze je potrebná kombinácia hydratácie, úpravy stravy a spravidla alkalizácie. Recidíva alebo rast konkrementov napriek týmto opatreniam je dôvodom na pridanie tiolového lieku. Obštrukcia, infekcia, pokles funkcie obličiek alebo veľké konkrementy vyžadujú súbežnú urologickú liečbu.</p>

<h3>Hydratácia: rozhoduje objem moču</h3>
<p>U dospelých je cieľom <strong>24-hodinový objem moču nad 3 litre</strong>, ak to klinický stav umožňuje. Potrebný príjem tekutín je vyšší a závisí od potenia, prostredia a extrarenálnych strát. Tekutiny sa rozdeľujú počas celého dňa vrátane večera; nočná koncentrácia moču je významným problémom. EAU uvádza u detí cieľ približne 1,5 l/m<sup>2</sup> telesného povrchu denne. [3]</p>

<p>Pri srdcovom zlyhávaní, oligúrii alebo pokročilej CKD sa vysoký príjem tekutín nesmie predpisovať mechanicky.</p>

<h3>Strava: menej sodíka, nie podvýživa</h3>
<p>EAU odporúča neprekračovať približne 2 g sodíka denne, teda asi 5 g kuchynskej soli. Vyšší príjem sodíka zvyšuje vylučovanie cystínu. Dôkazy o poklese cystinúrie sú presvedčivejšie než priame dôkazy o znížení klinických recidív. [1,3]</p>

<p>Obmedzuje sa najmä nadmerný príjem živočíšnych bielkovín a vysokobielkovinové diéty. Metionín je prekurzorom cysteínu a živočíšne bielkoviny zvyšujú kyselinovú záťaž. GeneReviews uvádza u dospelých orientačne 0,8–1 g bielkovín/kg/deň, vždy s ohľadom na výživu, vek a funkciu obličiek. U detí reštrikcia nesmie ohroziť rast. [2]</p>

<h2>Alkalizácia moču: prečo sa ciele líšia</h2>

<p>Prednostne sa používa citrát draselný, prípadne hydrogénuhličitan draselný, s titráciou podľa opakovaného merania pH čerstvého moču. Odporúčania nie sú úplne jednotné:</p>
<ul>
  <li>americký konsenzus z roku 2020 uvádza cieľ pH 7,0–7,5,</li>
  <li>aktuálna EAU kapitola odporúča pH nad 7,5,</li>
  <li>GeneReviews uvádza cieľ 7,5–8,0. [1–3]</li>
</ul>

<p>Rozdiel odráža vyvažovanie rastúcej rozpustnosti cystínu a rizika kalciumfosfátovej kryštalizácie. Praktický cieľ sa preto volí podľa aktivity ochorenia, zloženia konkrementov a celého močového profilu. Pri pokuse o rozpúšťanie potvrdeného cystínového konkrementu môže byť potrebné vyššie pH, vždy s monitorovaním.</p>

<p>Pri draselných soliach sa sleduje kaliémia a funkcia obličiek, zvlášť pri CKD, ACE inhibítoroch, sartanoch alebo antagonistoch mineralokortikoidových receptorov. Hydrogénuhličitan sodný je možnou alternatívou, jeho sodíková záťaž však môže zvýšiť cystinúriu a zhoršiť hypertenziu alebo edémy.</p>

<h2>Tiopronín a D-penicilamín</h2>

<p>Tiolové lieky štiepia disulfidovú väzbu cystínu a vytvárajú rozpustnejšie zmiešané disulfidy. Neopravujú transportér a ich účinok nemožno opisovať iba ako zníženie celkového vylučovania cystínu.</p>

<p><strong>Tiopronín je spravidla preferovaný</strong> pre lepšiu toleranciu oproti D-penicilamínu. EAU odporúča jeho pridanie pri vylučovaní cystínu nad 3 mmol/deň alebo pri recidívach napriek ostatným opatreniam; uvádza rozsah 250–2 000 mg/deň. Americký konsenzus často začína u dospelých dávkou 600–900 mg/deň. Dávka sa musí riadiť konkrétnym prípravkom, účinkom a toleranciou. [1,3]</p>

<p>Tiopronín môže vyvolať proteinúriu vrátane nefrotického syndrómu a membranóznej nefropatie. Proteinúria sa vyšetruje pred liečbou a počas nej; nová významná proteinúria vyžaduje bezodkladné prehodnotenie lieku.</p>

<p>D-penicilamín je alternatívou pri nedostupnosti alebo nevhodnosti tiopronínu. Vyžaduje sledovanie pre cytopénie, proteinúriu a glomerulárne poškodenie, hepatotoxicitu, kožné a slizničné reakcie, autoimunitné komplikácie a gastrointestinálnu intoleranciu. Zohľadňuje sa aj riziko nedostatku pyridoxínu; suplementácia má byť súčasťou odborného plánu, nie nekontrolovaným dlhodobým užívaním vysokých dávok.</p>

<h3>Meranie počas tiolovej liečby</h3>
<p>Niektoré laboratórne metódy neodlíšia voľný cystín od liekových komplexov, a preto môžu viesť k nesprávnej titrácii. Treba poznať použitú metódu. Kapacita moču rozpúšťať cystín (<em>cystine capacity</em>) je pozitívna pri nenasýtenom moči a negatívna pri presýtení. Konsenzus uvádza ako praktický cieľ pozitívnu hodnotu, často nad 50 mg/l, ide však o ukazovateľ založený na obmedzených údajoch. Rozhodujúci zostáva aj zobrazovací vývoj. [1]</p>

<h2>Kaptopril a ostatné ACE inhibítory</h2>

<p>Kaptopril má voľnú sulfhydrylovú skupinu a môže tvoriť rozpustnejší zmiešaný disulfid s cysteínom. Tento účinok nesúvisí s blokádou renínovo-angiotenzínového systému. U dospelých sa však pri tolerovaných dávkach reprodukovateľne nepreukázalo zníženie tvorby cystínových konkrementov; konsenzus ho preto <strong>neodporúča na rutinnú anticystínovú liečbu</strong>. [1]</p>

<p>Kaptopril možno použiť ako antihypertenzívum pri štandardnej indikácii. Ostatné ACE inhibítory, napríklad enalapril, ramipril, perindopril alebo lisinopril, nemajú kaptoprilový tiolový mechanizmus a nie sú náhradou tiopronínu. Ani prítomnosť síry v štruktúre iného lieku sama osebe nedokazuje klinický anticystínový účinok.</p>

<p>Pri súčasnej alkalizácii draselnými soľami treba pozorne sledovať kaliémiu a funkciu obličiek. Riziko akútneho poškodenia obličiek rastie pri dehydratácii a užívaní nesteroidových antiflogistík; ACE inhibítory sú kontraindikované v gravidite.</p>

<h2>Urologická liečba a chemolýza</h2>

<p>Cystínové konkrementy bývajú odolnejšie voči extrakorporálnej litotrypsii rázovými vlnami. Podľa veľkosti, lokalizácie a anatómie sa používa ureterorenoskopia s laserovou litotrypsiou alebo perkutánna nefrolitotómia.</p>

<p>Pri vhodne vybranom pacientovi možno skúsiť rozpúšťanie potvrdeného cystínového konkrementu alkalizáciou, prípadne spolu s tiolovým liekom. Účinok je pomalý a variabilný. Chemolýza nenahrádza urgentnú drenáž pri infekcii alebo závažnej obštrukcii. Ani úplné odstránenie konkrementov nevylieči transportnú poruchu; prevencia musí pokračovať.</p>

<h2>Dlhodobé sledovanie</h2>

<p>Po zmene režimu alebo farmakoterapie sa moč kontroluje približne o 1–2 mesiace. Po stabilizácii sa interval individualizuje; GeneReviews odporúča 24-hodinový moč každé 3–6 mesiacov do stabilizácie a následne každých 6–12 mesiacov. Ultrasonografické sledovanie obličiek a močových ciest sa plánuje približne každých 6–12 mesiacov, pri aktívnom ochorení skôr. [2]</p>

<p>Sledujú sa objem a pH moču, cystín s prihliadnutím na metódu, funkcia obličiek, elektrolyty, krvný tlak, proteinúria alebo albuminúria a podľa lieku krvný obraz či pečeňové testy. Rovnako dôležitá je uskutočniteľnosť plánu: prístup k vode a toalete, počet tabliet, tolerancia alkalizácie, pracovné podmienky a nočný režim.</p>

<h2>Nové prístupy a hranice dôkazov</h2>

<p>Skúmajú sa inhibítory rastu cystínových kryštálov, génová liečba, látky ovplyvňujúce objem moču a kyselina alfa-lipoová. Randomizovaná štúdia NCT02910531 s 50 účastníkmi bola ukončená v decembri 2024 a výsledky boli v registri zverejnené v apríli 2026. Register uvádza recidívu u 16 z 25 účastníkov pri kyseline alfa-lipoovej a u 23 z 25 pri placebe, neposkytuje však v zázname inferenčnú štatistiku potrebnú na definitívny klinický záver. Bez recenzovanej publikácie a začlenenia do odporúčaní nemožno túto intervenciu považovať za štandardnú liečbu. [4]</p>

<p>Pri cystínurii všeobecne prevažujú menšie observačné štúdie a expertný konsenzus. Liečba môže byť klinicky nevyhnutná aj pri obmedzenej istote dôkazov, slabo doložené postupy však nemožno stavať na rovnakú úroveň ako hydratácia, alkalizácia a etablované tiolové lieky.</p>

<h2>Záver</h2>

<p>Liečba cystínurie sa riadi najmä klinickou aktivitou a močovým profilom, nie samotným genetickým typom. Základom je dostatočná diuréza, primerané obmedzenie sodíka a živočíšnych bielkovín, riadená alkalizácia a pri nedostatočnom účinku tiopronín alebo D-penicilamín. Genetická diagnostika má najväčšiu hodnotu pri objasnení nejasného fenotypu, rodinného rizika a reprodukčného poradenstva.</p>

<hr>
<p><small><em><strong>Literatúra</strong></em></small></p>
<ol>
  <li><small><em>Eisner BH, Goldfarb DS, Baum MA, et al. Evaluation and Medical Management of Patients with Cystine Nephrolithiasis: A Consensus Statement. <span>Journal of Endourology</span>. 2020;34(11):1103–1110. DOI: <a href="https://doi.org/10.1089/end.2019.0703" target="_blank" rel="noopener noreferrer">10.1089/end.2019.0703</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/32066273/" target="_blank" rel="noopener noreferrer">32066273</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7869875/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></li>
  <li><small><em>Spasiano A, Halbritter J, Ferraro PM. Cystinuria. GeneReviews®. Vytvorené 20. novembra 2025. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/41264765/" target="_blank" rel="noopener noreferrer">41264765</a>. <a href="https://www.ncbi.nlm.nih.gov/books/NBK619248/" target="_blank" rel="noopener noreferrer">NCBI Bookshelf</a>.</em></small></li>
  <li><small><em>European Association of Urology. EAU Guidelines on Urolithiasis: Metabolic Evaluation and Recurrence Prevention – Cystine stones. <a href="https://uroweb.org/guidelines/urolithiasis/chapter/metabolic-evaluation-and-recurrence-prevention" target="_blank" rel="noopener noreferrer">Aktuálna oficiálna kapitola</a>. Prístup 8. októbra 2026.</em></small></li>
  <li><small><em>ClinicalTrials.gov. Lipoic Acid Supplement for Cystine Stone (NCT02910531). <a href="https://clinicaltrials.gov/study/NCT02910531" target="_blank" rel="noopener noreferrer">Záznam štúdie a výsledky</a>. Stav a výsledky overené 8. októbra 2026.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cystinuria-genetika-diagnostika-komplexna-liecba_article',
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
