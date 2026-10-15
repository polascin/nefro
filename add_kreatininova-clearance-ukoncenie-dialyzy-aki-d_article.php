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
    'title' => 'Kreatinínová clearance pri ukončovaní dialýzy po akútnom poškodení obličiek',
    'slug' => 'kreatininova-clearance-ukoncenie-dialyzy-aki-d',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Doplnková analýza štúdie LIBERATE-D ukazuje, že kreatinínová clearance z časovaného zberu moču predpovedá dialyzačnú nezávislosť lepšie než diuréza aj eGFR. Aj pri 5–10 ml/min zostala takmer polovica pacientov týždeň bez dialýzy.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/kreatininova-clearance-ukoncenie-dialyzy-aki-d.webp" type="image/webp">
    <img src="img/kreatininova-clearance-ukoncenie-dialyzy-aki-d.png" alt="Poloschematická scéna: dialyzačný okruh sa rozpadá na častice, zatiaľ čo stúpajúca svetelná krivka kreatinínovej clearance smeruje k obličke" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani výrobku. Krivka znázorňuje obnovu exkrečnej schopnosti obličiek, pri ktorej sa plánovaná dialýza stáva zbytočnou.</figcaption>
</figure>

<p>Rozhodnutie o ukončení dialýzy pri akútnom poškodení obličiek vyžadujúcom dialýzu (AKI-D) patrí k najčastejším a zároveň najmenej podloženým rozhodnutiam v nefrológii. Diuréza aj odhadovaná glomerulárna filtrácia sa používajú desaťročia, ale prahové hodnoty, o ktoré sa opierame, pochádzajú zväčša z kohort kriticky chorých pacientov na jednotkách intenzívnej starostlivosti. Práve u nich je riziko úmrtia také vysoké, že samotná otázka „kedy prestať dialyzovať“ ustupuje do pozadia.</p>

<p>Doplnková analýza randomizovanej štúdie LIBERATE-D sa pozrela na inú fázu priebehu – na obdobie, keď kritická choroba ustúpila a pacient je hemodynamicky stabilný. V tejto fáze mala kreatinínová clearance z časovaného zberu moču zreteľne lepšiu rozlišovaciu schopnosť než diuréza aj než eGFR. Podstatná časť pacientov nepotrebovala dialýzu ani pri hodnotách, ktoré by sme bežne považovali za jednoznačnú indikáciu na jej pokračovanie.</p>

<h2>Odkiaľ údaje pochádzajú</h2>

<p>LIBERATE-D bola multicentrická, nezaslepená randomizovaná štúdia superiority, ktorá v rokoch 2020 až 2025 na štyroch pracoviskách v USA zaradila 221 pacientov s AKI-D. Podmienkou zaradenia bola východisková eGFR nad 15 ml/min/1,73 m², už začatá náhrada funkcie obličiek, hemodynamická stabilita a plánovaná intermitentná hemodialýza. V intervenčnom ramene sa dialýza vykonávala <strong>len pri splnení vopred definovaných metabolických alebo klinických indikácií</strong>, v kontrolnom ramene trikrát týždenne až do dosiahnutia kritérií diurézy alebo kreatinínovej clearance.</p>

<p>Konzervatívna stratégia viedla k obnove funkcie obličiek pri prepustení u 70 zo 109 pacientov (64 %) oproti 55 zo 109 (50 %) pri obvyklom režime (rozdiel 13,8 %; 95 % interval spoľahlivosti 0,8–26,8 %; p = 0,04). Po vopred špecifikovanej adjustácii však výsledok stratil štatistickú významnosť (OR 1,56; 95 % IS 0,86–2,84; p = 0,15), preto samotní autori odporúčajú overenie na väčšej populácii.</p>

<p>Doplnková analýza, ktorej sa venuje tento článok, pracovala <strong>iba s intervenčným ramenom</strong>. Hodnotilo sa 147 časovaných zberov moču od 85 pacientov s AKI-D. Zbery prebiehali podľa protokolu a ich výsledky boli zaslepené voči ošetrujúcim lekárom – tí teda rozhodovali o dialýze podľa vopred definovaných indikácií, nie podľa nameranej clearance. Práve toto zaslepenie je metodicky kľúčové: bez neho by meranie samo ovplyvnilo výsledok, ktorý má predpovedať.</p>

<p>V čase prvého zberu už 64 % pacientov nebolo na jednotke intenzívnej starostlivosti. Išlo teda o populáciu v ústupe kritickej choroby, bez potreby vazopresorov či mechanickej ventilácie.</p>

<h2>Východiskové hodnoty: nízke, ako sa očakávalo</h2>

<p>Medián kreatinínovej clearance bol 7,1 ml/min (medzikvartilové rozpätie 3,1–15,9 ml/min), medián diurézy 930 ml/deň (medzikvartilové rozpätie 471–1 786 ml/deň). Dialýza bola v priebehu siedmich dní po zbere potrebná v 49 % prípadov.</p>

<h2>Rozlišovacia schopnosť jednotlivých ukazovateľov</h2>

<div class="table-responsive" role="region" aria-label="Rozlišovacia schopnosť ukazovateľov pre potrebu dialýzy v nasledujúcich siedmich dňoch" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Ukazovateľ</th><th scope="col">Plocha pod krivkou (AUC)</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kreatinínová clearance</th><td>0,84</td></tr>
    <tr><th scope="row">Priemer kreatinínovej a ureovej clearance</th><td>0,84</td></tr>
    <tr><th scope="row">Ureová clearance</th><td>0,82</td></tr>
    <tr><th scope="row">Diuréza</th><td>0,78</td></tr>
    <tr><th scope="row">eGFR zo sérového kreatinínu</th><td>0,67</td></tr>
  </tbody>
</table>
</div>

<p>Kreatinínová clearance mala signifikantne vyššiu rozlišovaciu schopnosť než diuréza. eGFR bola signifikantne horšia než kreatinínová clearance aj než diuréza. Doplnenie ureovej clearance ku kreatinínovej clearance prognostickú výpovednú hodnotu <strong>nezlepšilo</strong> – meranie močoviny navyše teda nemá praktické opodstatnenie.</p>

<p>Šanca na potrebu dialýzy klesala o 18 % na každý 1 ml/min kreatinínovej clearance a o 9 % na každých ďalších 100 ml diurézy.</p>

<h2>Podiel pacientov bez dialýzy podľa prahových hodnôt</h2>

<div class="table-responsive" role="region" aria-label="Podiel zberov, po ktorých pacient nepotreboval dialýzu nasledujúcich sedem dní" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Pásmo</th><th scope="col">Bez dialýzy nasledujúcich 7 dní</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Kreatinínová clearance &gt; 20 ml/min</th><td>96 %</td></tr>
    <tr><th scope="row">Kreatinínová clearance 10–20 ml/min</th><td>81 % (22 z 27)</td></tr>
    <tr><th scope="row">Kreatinínová clearance 5 – &lt; 10 ml/min</th><td>44 % (19 z 43)</td></tr>
    <tr><th scope="row">Diuréza &gt; 1 000 ml/deň</th><td>73 %</td></tr>
    <tr><th scope="row">Diuréza 200–499 ml/deň</th><td>28 %</td></tr>
  </tbody>
</table>
</div>

<p>Najvýraznejší je stredný riadok. Kreatinínová clearance 10–20 ml/min zodpovedá ťažkej poruche funkcie obličiek, napriek tomu štyria z piatich pacientov v tomto pásme dialýzu ďalší týždeň nepotrebovali. Dokonca aj v pásme 5 – &lt; 10 ml/min, ktoré by v chronickom kontexte zodpovedalo CKD 5. štádia, zostalo bez dialýzy 44 % pacientov.</p>

<h2>Opätovná potreba dialýzy</h2>

<p>Zo 75 pacientov, ktorí po zbere sedem dní dialýzu nepotrebovali, ju počas tej istej hospitalizácie potrebovali znovu iba <strong>dvaja</strong>, a to s mediánom 14 dní. V oboch prípadoch bola kreatinínová clearance vyššia než 8 ml/min a diuréza vyššia než 1 000 ml/deň. Taká konštelácia skôr zodpovedá novej epizóde akútneho poškodenia obličiek než zlyhaniu pôvodného zotavenia.</p>

<h2>Prečo kreatinínová clearance prekonáva diurézu aj eGFR</h2>

<p>Dôvod nie je štatistický, ale fyziologický. Diuréza môže zostať zdanlivo zachovaná aj pri veľmi nízkej glomerulárnej filtrácii, pretože poškodené tubuly nedokážu vodu spätne vstrebávať. Objem moču potom hovorí viac o tubulárnej funkcii než o exkrečnej kapacite. Pacient s diurézou 1 200 ml denne a clearance 4 ml/min vyzerá na prvý pohľad lepšie, než aký v skutočnosti je.</p>

<p>Odhadovaná glomerulárna filtrácia zo sérového kreatinínu zlyháva z iného dôvodu. Rovnice na jej výpočet predpokladajú ustálený stav, ktorý pri AKI neexistuje. Sérová koncentrácia kreatinínu je výsledkom tvorby, distribučného objemu a exkrécie, pričom pri rýchlych zmenách funkcie zaostáva za skutočnosťou o desiatky hodín. Modelovanie kinetiky kreatinínu ukázalo, že 24 hodín po 90 % poklese clearance kreatinínu stúpne sérový kreatinín o 246 % pri normálnej východiskovej funkcii, ale len o 47 % pri CKD 4. štádia. Pri intermitentnej hemodialýze sa k tomu pridáva ešte extrakorporálna eliminácia, ktorá sérovú hodnotu ďalej skresľuje.</p>

<p>Časovaný zber moču túto nejednoznačnosť obchádza. Meria, koľko kreatinínu oblička v danom okne skutočne vylúčila.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Údaje neodôvodňujú zavedenie jednej univerzálnej prahovej hodnoty. Podporujú skôr zmenu logiky rozhodovania:</p>

<ol>
  <li><strong>Potvrdiť, že kritická fáza ustúpila.</strong> Bez vazopresorov, bez mechanickej ventilácie, hemodynamicky stabilný pacient. Mimo týchto podmienok výsledky neplatia.</li>
  <li><strong>Vykonať časovaný zber moču</strong> podľa miestneho protokolu a vypočítať kreatinínovú clearance. Ureovú clearance netreba dopĺňať.</li>
  <li><strong>Vyhodnotiť clearance v klinickom kontexte,</strong> nie izolovane. Diuréza zostáva doplnkovou informáciou, nie hlavným kritériom.</li>
  <li><strong>Ukončiť plánovanú dialýzu a prejsť na režim riadený indikáciami.</strong> Pri clearance 10–20 ml/min je pravdepodobnosť, že pacient týždeň dialýzu nepotrebuje, približne 80 %.</li>
  <li><strong>Zabezpečiť denné prehodnotenie.</strong> V pásme 5 – &lt; 10 ml/min je dialýza v priebehu týždňa potrebná v 56 % prípadov. Ukončenie je tu obhájiteľné iba vtedy, ak je zároveň zabezpečená rýchla reeskalácia pri splnení indikácií.</li>
</ol>

<p>Ide teda o posun od profylaktického pokračovania k postupu riadenému indikáciami. Nie o jednorazový príkaz „ukončiť“, ale o režim, v ktorom sa dialýza podá vtedy, keď je na ňu dôvod.</p>

<h2>Súlad s odporúčaniami KDIGO</h2>

<p>Odporúčanie KDIGO pre akútne poškodenie obličiek z roku 2012 uvádza, že náhradu funkcie obličiek treba ukončiť vtedy, keď už nie je potrebná – buď preto, že sa vnútorná funkcia obličiek obnovila natoľko, že pokrýva potreby pacienta, alebo preto, že liečba už nezodpovedá cieľom starostlivosti. KDIGO zároveň neuvádza konkrétnu prahovú hodnotu clearance. Analýza LIBERATE-D do tohto rámca zapadá ako spôsob, ako obsah formulácie „obnovená natoľko, že pokrýva potreby pacienta“ kvantifikovať v konkrétnom časovom okne.</p>

<h2>Limity</h2>

<ul>
  <li><strong>Doplnková analýza jedného ramena.</strong> Nejde o randomizované porovnanie stratégií ukončovania dialýzy, ale o pozorovanie prediktívnej hodnoty v rámci jednej intervenčnej skupiny.</li>
  <li><strong>Úzko vybraná populácia.</strong> Hemodynamicky stabilní pacienti s intermitentnou hemodialýzou a východiskovou eGFR nad 15 ml/min/1,73 m². Výsledky sa <em>nedajú</em> preniesť na kriticky chorých, na pacientov na kontinuálnej náhrade funkcie obličiek ani na pokročilú CKD pred vznikom AKI.</li>
  <li><strong>Jednotka analýzy je zber, nie pacient.</strong> Od 85 pacientov pochádza 147 zberov, takže údaje nie sú navzájom nezávislé.</li>
  <li><strong>Sedemdňový ukazovateľ.</strong> Hovorí o najbližšom manažmente, nie o trvalom zotavení obličiek. Dlhodobý osud funkcie obličiek táto analýza nehodnotí.</li>
  <li><strong>Malé čísla v krajných pásmach.</strong> Napríklad pásmo 10–20 ml/min stojí na 27 zberoch; interval spoľahlivosti okolo uvedených 81 % je preto široký.</li>
  <li><strong>Praktické bariéry.</strong> Časovaný zber moču vyžaduje spoľahlivý katéter alebo disciplinovaný zber, čo na bežnom oddelení nie je samozrejmosť.</li>
</ul>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani súhrn charakteristických vlastností lieku. O ukončení dialýzy rozhoduje ošetrujúci lekár podľa celkového stavu konkrétneho pacienta.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>McCoy I, Liu KD, Siew E, Tuot DS, Vijayan A, Kwong YD, Umemoto GM, Birkelo BC, Neuhaus J, Zhuo H, Hsu CY. Dialysis Discontinuation Rates at Low Levels of Kidney Function in Patients with Acute Kidney Injury on Intermittent Hemodialysis. <em>J Am Soc Nephrol.</em> 2026 Aug 25 (online pred tlačou). DOI: <a href="https://doi.org/10.1681/ASN.0000001245" target="_blank" rel="noopener noreferrer">10.1681/ASN.0000001245</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42640730/" target="_blank" rel="noopener noreferrer">PubMed PMID 42640730</a>.</small></li>
  <li><small>Liu KD, Siew ED, Tuot DS, Vijayan A, Matzumura Umemoto G, Birkelo BC, Lee BJ, Kwong YD, McCoy IE, Delucchi K, Zhuo H, Hsu CY. A Conservative Dialysis Strategy and Kidney Function Recovery in Dialysis-Requiring Acute Kidney Injury: The Liberation From Acute Dialysis (LIBERATE-D) Randomized Clinical Trial. <em>JAMA.</em> 2026;335(4):326–335. DOI: <a href="https://doi.org/10.1001/jama.2025.21530" target="_blank" rel="noopener noreferrer">10.1001/jama.2025.21530</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41201895/" target="_blank" rel="noopener noreferrer">PubMed PMID 41201895</a>.</small></li>
  <li><small>Waikar SS, Bonventre JV. Creatinine kinetics and the definition of acute kidney injury. <em>J Am Soc Nephrol.</em> 2009;20(3):672–679. DOI: <a href="https://doi.org/10.1681/ASN.2008070669" target="_blank" rel="noopener noreferrer">10.1681/ASN.2008070669</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/19244578/" target="_blank" rel="noopener noreferrer">PubMed PMID 19244578</a>.</small></li>
  <li><small>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group. KDIGO Clinical Practice Guideline for Acute Kidney Injury. <em>Kidney Int Suppl.</em> 2012;2(1):1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">plné znenie odporúčania (PDF)</a>.</small></li>
  <li><small>Melville NA. Creatinine Clearance Can Guide Dialysis Discontinuation After AKI in Stable Patients. <em>Medscape Medical News</em>, 13. októbra 2026. <a href="https://www.medscape.com/viewarticle/creatinine-clearance-can-guide-dialysis-discontinuation-2026a10012bh" target="_blank" rel="noopener noreferrer">dostupné online</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Autorský zoznam, DOI a PMID oboch prác tímu LIBERATE-D boli overené cez Crossref a PubMed eutils. Číselné údaje z doplnkovej analýzy (AUC, pásma clearance, počty pacientov) pochádzajú zo štruktúrovaného abstraktu primárnej práce a z odborného spravodajstva Medscape, ktoré uvádza aj údaje nedostupné v abstrakte (AUC pre eGFR a ureovú clearance, pásmo &gt; 20 ml/min, pomer šancí, opätovná potreba dialýzy). Plný text v <em>JASN</em> je prístupný len za poplatok, preto údaje nad rámec abstraktu nebolo možné overiť priamo v primárnom zdroji; sú uvedené s vedomím tohto obmedzenia. Kontext hlavnej štúdie LIBERATE-D, kinetiku kreatinínu a znenie odporúčania KDIGO doplnil autor projektu nad rámec zdrojového textu; rovnako aj rozbor limitov a fyziologické vysvetlenie rozdielu medzi clearance, diurézou a eGFR.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradu funkcie obličiek pri akútnom poškodení obličiek</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba CKD 2026: vrstvená nefroprotekcia po akútnom poškodení obličiek</a></li>
  <li><a href="article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek">Inkrementálna hemodialýza a reziduálna funkcia obličiek</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kreatininova-clearance-ukoncenie-dialyzy-aki-d_article',
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
