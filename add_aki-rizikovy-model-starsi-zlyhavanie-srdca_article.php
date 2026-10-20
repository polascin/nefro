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
    'title' => 'Riziko akútneho poškodenia obličiek u starších hospitalizovaných pacientov so zlyhávaním srdca: model z údajov pri prijatí',
    'slug' => 'aki-rizikovy-model-starsi-zlyhavanie-srdca',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Čínska jednocentrová kohorta 7 076 seniorov so zlyhávaním srdca priniesla model AKI z ôsmich údajov dostupných do 24 hodín od prijatia. AUC 0,804, ale len vnútorná validácia.',
    'content' => <<<'HTML'
<p>Akútne poškodenie obličiek (AKI) patrí medzi najčastejšie komplikácie hospitalizácie pri zlyhávaní srdca. Zhoršuje prognózu, predlžuje pobyt v nemocnici a zužuje liečebné možnosti práve vtedy, keď ich pacient potrebuje najviac. U seniora sa k tomu pridáva nižšia funkčná rezerva obličiek, takže aj mierny hemodynamický podnet, infekcia alebo zmena objemového stavu môže viesť k poklesu glomerulovej filtrácie.</p>

<p>Praktická otázka preto znie, či sa dá ohrozený pacient rozpoznať skôr, než sa kreatinín pohne. Práca kolektívu Liu a spoluautorov z Všeobecnej nemocnice Severného vojenského veliteľstva v Šen-jangu sa o to pokúsila na kohorte 7 076 hospitalizovaných seniorov so zlyhávaním srdca a použila výhradne údaje dostupné do 24 hodín od prijatia.</p>

<figure>
  <picture>
    <source srcset="img/aki-rizikovy-model-starsi-zlyhavanie-srdca.webp" type="image/webp">
    <img src="img/aki-rizikovy-model-starsi-zlyhavanie-srdca.png" alt="Polopriesvitné srdce vľavo a oblička vpravo spojené svetelným prúdom, ktorý z tmavočervenej prechádza do chladnej tyrkysovej a pri obličke slabne" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zobrazovacie vyšetrenie. Znázorňuje slabnúcu obličkovú perfúziu pri zlyhávaní srdca a vrstvenie rizika pri prijatí.</figcaption>
</figure>

<h2>Ako bolo AKI definované</h2>

<p>Autori použili kritériá KDIGO z roku 2012. AKI bolo prítomné, ak bola splnená aspoň jedna z podmienok:</p>

<ol>
  <li>vzostup sérového kreatinínu o viac než 26,5 µmol/l v priebehu 48 hodín,</li>
  <li>vzostup sérového kreatinínu najmenej na 1,5-násobok východiskovej hodnoty v priebehu 7 dní,</li>
  <li>diuréza nižšia než 0,5 ml/kg/h počas viac než 6 hodín.</li>
</ol>

<p>Za východiskovú hodnotu kreatinínu a močoviny sa považovala hodnota pri prijatí. Nulovým časom predikcie bolo prijatie do nemocnice. Zlyhávanie srdca potvrdil kardiológ podľa diagnostických kritérií ESC z roku 2023.</p>

<h2>Kto bol zaradený a kto nie</h2>

<p>Išlo o retrospektívnu jednocentrovú kohortu za obdobie od 1. januára 2019 do 31. decembra 2023. Vstupné kritériá boli zlyhávanie srdca počas hospitalizácie (akútne aj chronické), vek najmenej 65 rokov, pobyt najmenej 48 hodín a úplné údaje.</p>

<p>Vylúčení boli pacienti s terminálnym zlyhaním obličiek, po transplantácii obličky a liečení dialýzou, ďalej pacienti s AKI prítomným už pri prijatí, pacienti s kontrastom navodenou nefropatiou po intervenčnom výkone a pacienti s anamnézou zhubného nádoru. Vylúčení boli aj všetci s chýbajúcou hodnotou ktorejkoľvek premennej alebo sledovaného ukazovateľa; imputácia sa nerobila. Z pôvodných 7 842 pacientov tak do analýzy vstúpilo 7 076.</p>

<p>AKI vzniklo počas hospitalizácie u 796 pacientov, teda u 11,2 %. Táto hodnota je pre pochopenie celej práce kľúčová a vraciame sa k nej pri kalibrácii aj pri klinickej užitočnosti.</p>

<h2>Postup pri výbere premenných</h2>

<p>Súbor bol náhodne rozdelený na tréningovú (4 954 pacientov) a validačnú časť (2 122 pacientov) v pomere 7 : 3. Validačná časť slúžila výlučne na hodnotenie výkonnosti a nevstupovala do výberu premenných, trénovania ani ladenia modelu.</p>

<p>Východiskom bolo 43 kandidátskych premenných vybraných podľa literatúry a klinickej skúsenosti. Z nich bolo v jednorozmernej analýze významných 38. Nasledovala regresia LASSO s desaťnásobnou krížovou validáciou; autori ponechali premenné, ktorých absolútna hodnota štandardizovaného regresného koeficientu presiahla 20 % — ide o empirický prah, ktorý si stanovili sami, nie o predvolený výstup algoritmu. Takto vybraných osem premenných vstúpilo do viacrozmernej logistickej regresie. Súbežne sa porovnávalo trinásť postupov strojového učenia.</p>

<p>Dôležitý metodický detail: všetky premenné boli obmedzené na údaje získané do 24 hodín od prijatia a pred vznikom AKI. Laboratórne hodnoty pochádzali z prvého odberu po prijatí, lieky sa zaznamenávali iba ako chronická liečba užívaná pred prijatím. Tým sa vylúčilo, aby sa do modelu dostal ukazovateľ už ovplyvnený prebiehajúcim AKI.</p>

<h2>Osem nezávislých prediktorov</h2>

<p>Vo viacrozmernej logistickej regresii boli nezávislými rizikovými faktormi vzniku AKI počas hospitalizácie:</p>

<ul>
  <li>chronické užívanie diuretík pred prijatím,</li>
  <li>artériová hypertenzia,</li>
  <li>diabetes mellitus,</li>
  <li>chlopňová chyba srdca,</li>
  <li>chronická obštrukčná choroba pľúc (CHOCHP),</li>
  <li>chronická choroba obličiek (CKD),</li>
  <li>cystatín C pri prijatí.</li>
</ul>

<p>Ôsmou premennou bola ejekčná frakcia ľavej komory, ktorá v modeli vystupovala ako ochranný faktor: čím vyššia, tým nižšie riziko AKI.</p>

<p>Model teda ukazuje asociácie, nie príčinné vzťahy. Platí to najmä pre diuretiká. Chronické užívanie diuretika pred prijatím je predovšetkým znakom klinického fenotypu — opakovanej kongescie, pokročilejšieho ochorenia a väčšej komorbidity — a nie dôkazom, že samotné diuretikum poškodilo obličky. Autori zároveň upozorňujú na možné reziduálne zavádzajúce pôsobenie súbežnej liečby, ktoré ich údaje nedokázali rozlíšiť.</p>

<h2>Výkonnosť modelu</h2>

<p>Spomedzi trinástich porovnávaných postupov dopadla vo validačnej časti najlepšie klasická logistická regresia.</p>

<div class="table-responsive" role="region" aria-label="Výkonnosť logistického modelu vo validačnej časti" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Tréningová časť</th><th scope="col">Validačná časť</th></tr></thead>
  <tbody>
    <tr><th scope="row">AUC</th><td>1,000 (95 % IS 1,000–1,000)</td><td>0,804 (95 % IS 0,777–0,830)</td></tr>
    <tr><th scope="row">Hosmerov–Lemeshowov test</th><td>p = 0,561</td><td>p = 0,605</td></tr>
    <tr><th scope="row">Sklon kalibračnej priamky</th><td>0,896</td><td>0,835</td></tr>
    <tr><th scope="row">Brierovo skóre</th><td>0,078</td><td>0,082</td></tr>
  </tbody>
</table>
</div>

<p>Úsek kalibračnej priamky vo validačnej časti bol 0,013. Kalibráciu teda možno označiť za prijateľnú, nie však za výbornú: krivka mala mierne schodovitý priebeh a v pásme nízkych predpovedaných pravdepodobností riziko skôr nadhodnocovala. Autori to pripisujú nízkemu výskytu príhod (11,2 %) a z neho vyplývajúcej nerovnováhe tried, pri ktorej je v jednotlivých pásmach pravdepodobnosti málo pozitívnych udalostí a pozorovaná miera príhod je nestabilná.</p>

<p>Ďalšie modely zaostali: náhodný les dosiahol AUC 0,788, naivný Bayesov klasifikátor 0,751, model čiastočných najmenších štvorcov 0,744. Žiadny model nebol najlepší vo všetkých ukazovateľoch. Najvyššiu citlivosť (0,231) aj Youdenov index (0,200) mal model čiastočných najmenších štvorcov, najvyššiu špecificitu (0,988) a pozitívnu prediktívnu hodnotu (0,582) Bayesov klasifikátor — ten však pri citlivosti 0,142 označoval za negatívnu väčšinu prípadov. Nízka citlivosť všetkých modelov je priamym dôsledkom nerovnováhy tried.</p>

<h2>Prečo je rozdiel medzi AUC 1,000 a 0,804 podstatný</h2>

<p>V tréningovej časti dosiahlo dvanásť z trinástich modelov AUC najmenej 0,998 a logistický model presne 1,000. To nie je znak kvality, ale takmer isté preučenie alebo úplná separácia údajov. Autori to v texte otvorene priznávajú a výslovne upozorňujú, že výsledok z tréningovej časti sa nemá preceňovať. Pokles na 0,804 pri nezávislom hodnotení je pravdivejším odhadom; aj tak však ide o odhad z rovnakého zdrojového súboru, iba inak rozdeleného.</p>

<h2>Klinická užitočnosť závisí od zvoleného prahu</h2>

<p>Analýza rozhodovacích kriviek ukázala, že vo validačnej časti bol čistý prínos modelu kladný len pri prahoch rizika približne do 0,28; nad touto hodnotou klesol pod nulu. Autori z toho vyvodzujú jednoznačný záver, ktorý stojí za zopakovanie: <strong>model sa nemá používať ako nástroj včasného skríningu, ale nanajvýš ako kandidát na vrstvenie rizika</strong>, ktorý pomôže vybrať pacientov vhodných na cielené preventívne opatrenia.</p>

<p>Rovnaký mechanizmus — nízky výskyt príhod a nadhodnocovanie rizika v dolnom pásme pravdepodobností — vysvetľuje aj schodovitú kalibračnú krivku, aj záporný čistý prínos pri vyšších prahoch.</p>

<h2>Nomogram a bodové skóre</h2>

<p>Pre praktické použitie autori previedli regresné koeficienty na nomogram a na celočíselné bodové skóre. Cystatín C rozdelili podľa referenčného rozsahu a zaužívaných deliacich bodov do troch pásiem (pod 1,0 mg/l; 1,0–1,5 mg/l; najmenej 1,5 mg/l) s hodnotením 0, 4 a 7 bodov. Ejekčnú frakciu rozdelili podľa odporúčaní ESC z roku 2021 na pásma pod 40 %, 40–49 % a najmenej 50 %, pričom hodnota pod 40 % znamená 7 bodov. Vyšší súčet zodpovedá vyššiemu riziku.</p>

<h2>Prečo práve tieto premenné dávajú zmysel</h2>

<p>CKD a vyšší cystatín C pri prijatí vyjadrujú zníženú funkčnú rezervu obličiek. Cystatín C má oproti kreatinínu u seniora výhodu v tom, že ho neovplyvňuje svalová hmota, ktorá v tejto populácii systematicky klesá, a preto vernejšie odráža skutočnú glomerulovú filtráciu.</p>

<p>Nižšia ejekčná frakcia znamená nižší minútový objem, horšiu perfúziu obličiek a súbežne venóznu kongesciu s obličkovým edémom — teda oba hlavné hemodynamické mechanizmy kardiorenálneho zhoršenia naraz. Chlopňová chyba pôsobí podobne: aortálna stenóza zvyšuje následné zaťaženie (afterload) ľavej komory a znižuje minútový objem, mitrálna regurgitácia zvyšuje objemové zaťaženie a venózny tlak.</p>

<p>Hypertenzia, diabetes a CHOCHP sú opakujúce sa prvky rizikových profilov seniorov. Pri CHOCHP autori upozorňujú na úlohu systémového zápalu, pľúcnej hypertenzie a hyperkapnie.</p>

<p>Za pozornosť stojí aj to, čo sa medzi nezávislé prediktory nedostalo. Klasifikácia NYHA ani NT-proBNP nemali v tejto populácii nezávislú predikčnú hodnotu. Pri NYHA ide o subjektívny ukazovateľ symptómov, zatiaľ čo ejekčná frakcia priamo odráža čerpaciu funkciu a perfúzny tlak. Pri NT-proBNP sú východiskové hodnoty u dekompenzovaného pacienta so zlyhávaním srdca natoľko vysoké, že ich rozlišovacia schopnosť pre ďalšie komplikácie klesá. Nezávislým prediktorom nebola ani arytmia; vzťah medzi arytmiou a AKI je obojsmerný a nová fibrilácia predsiení býva skôr následkom AKI než jeho spúšťačom.</p>

<h2>Čo o cystatíne C hovorí širšia literatúra</h2>

<p>Postavenie cystatínu C ako ukazovateľa rizika, nie iba funkcie obličiek, podporujú aj staršie práce. Dalboni a spoluautori sledovali 234 kriticky chorých pacientov starších než 60 rokov prijatých na jednotku intenzívnej starostlivosti bez AKI a s normálnym vstupným kreatinínom. AKI podľa kritérií AKIN sa rozvinulo u 45 z nich (19 %).</p>

<p>Výsledok bol dvojaký. Vstupná hodnota cystatínu C <em>nepredpovedala</em> vznik AKI (1,05 ± 0,48 oproti 0,94 ± 0,36 mg/l; p = 0,1). Bola však nezávislým prediktorom úmrtia po zohľadnení veku, pohlavia, skóre APACHE II, sepsy, použitia vazopresorov, dĺžky pobytu a albumínu, s pomerom rizika 6,16 (95 % IS 1,46–26,00; p = 0,01). Samotné AKI s úmrtím v tejto kohorte spojené nebolo. Plocha pod krivkou pre predpoveď úmrtia bola pre cystatín C 0,67 (p = 0,03), pre výskyt AKI 0,47 (p = 0,6).</p>

<p>Interpretovať to treba opatrne. Súbor bol malý, interval spoľahlivosti pomeru rizika mimoriadne široký a zistenie, že AKI nesúvisí s úmrtnosťou, odporuje väčšine literatúry — autori to pripisujú tomu, že zaradenie podľa normálneho vstupného kreatinínu v tejto vekovej skupine nerozdelilo pacientov správne. Napriek tomu údaje podporujú výklad, že zvýšený cystatín C odráža aj zápal a celkovú závažnosť stavu, nielen glomerulovú filtráciu. V modeli Liu a spoluautorov preto nemusí ísť o čisto obličkový ukazovateľ.</p>

<h2>Limity, ktoré určujú silu dôkazu</h2>

<ol>
  <li><strong>Jedno pracovisko, retrospektívny zber.</strong> Zloženie pacientov môže byť špecifické, výberové skreslenie nemožno vylúčiť.</li>
  <li><strong>Iba vnútorná validácia.</strong> Validačná časť pochádza z náhodného rozdelenia toho istého súboru. Nezávislá externá validácia chýba.</li>
  <li><strong>Zjavné preučenie v tréningovej časti.</strong> AUC 1,000 obmedzuje dôveru v prenositeľnosť výsledku.</li>
  <li><strong>Vylúčené skupiny.</strong> Model nemožno použiť u dialyzovaných, po transplantácii, pri AKI prítomnom už pri prijatí ani pri kontrastom navodenej nefropatii.</li>
  <li><strong>Vylúčenie neúplných záznamov bez imputácie.</strong> Autori pripúšťajú, že to mohlo zaviesť výberové skreslenie.</li>
  <li><strong>Asociácie, nie príčiny.</strong> Model neurčuje, čo AKI spôsobilo, a nemožno z neho odvodzovať liečebné zásahy.</li>
  <li><strong>Prahová závislosť.</strong> Mimo pásma nízkych prahov rizika čistý prínos mizne.</li>
</ol>

<h2>Čo z toho plynie pre prax</h2>

<p>Model nie je hotový nástroj na rutinné nasadenie a sami autori to konštatujú. Jeho hodnota je inde: potvrdzuje, že u seniora so zlyhávaním srdca sa dá už pri prijatí zostaviť zmysluplný rizikový profil z bežne dostupných údajov, bez ďalších vyšetrení.</p>

<p>Prakticky to znamená, že pri pacientovi s kombináciou CKD, zvýšeného cystatínu C, nízkej ejekčnej frakcie, chlopňovej chyby, diabetu, hypertenzie, CHOCHP a chronickej diuretickej liečby je namieste hustejšie sledovanie kreatinínu a diurézy, dôsledné posúdenie objemového stavu, opatrnosť pri zosilňovaní antihypertenzívnej liečby a pri dávkovaní diuretík, a prednostné zváženie liekov s kardiorenálnou ochranou tam, kde sú indikované. Naopak u pacienta s nízkym skóre je legitímne monitorovanie nezhusťovať.</p>

<h2>Záver</h2>

<p>Na kohorte 7 076 starších hospitalizovaných pacientov so zlyhávaním srdca bol zostavený a vnútorne validovaný logistický model rizika AKI z ôsmich údajov dostupných do 24 hodín od prijatia: diuretiká užívané pred prijatím, hypertenzia, diabetes, chlopňová chyba, CHOCHP, CKD, cystatín C pri prijatí a ejekčná frakcia ľavej komory. Vo validačnej časti dosiahol AUC 0,804 pri prijateľnej kalibrácii.</p>

<p>Prínos modelu je však prahovo závislý a dôkaz oslabuje jednocentrový retrospektívny dizajn so zjavným preučením v tréningovej časti. Pred akýmkoľvek rutinným použitím je nevyhnutná externá validácia v nezávislých kohortách a prospektívne overenie — presne tak, ako to formulujú samotní autori.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki">Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup</a></li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila</a></li>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie a CKD: závery KDIGO konferencie o obojsmernom zaťažení, GDMT a koordinovanej starostlivosti</a></li>
  <li><a href="article.php?slug=multimorbidita-discordancia-egfr-kreatinin-cystatin-c">Multimorbidita a rozpor medzi eGFR z kreatinínu a z cystatínu C</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
</ul>

<h2>Poznámka k dôkazom</h2>

<p>Článok je odborným spracovaním jednej primárnej publikácie, doplneným o jednu podpornú štúdiu k cystatínu C a o pôvodné odporúčanie KDIGO. Všetky číselné údaje (počty pacientov, výskyt AKI, AUC, Hosmerov–Lemeshowov test, sklon a úsek kalibračnej priamky, Brierovo skóre, prah rozhodovacej krivky, bodové hodnotenie) boli overené proti plnému textu primárnej práce v PubMed Central; autorské zoznamy a bibliografické údaje oboch citovaných článkov boli overené cez Crossref a PubMed. Doplnili sme údaje, ktoré v pôvodnom podklade chýbali (výskyt AKI 11,2 %, veľkosť tréningovej a validačnej časti, úplné kalibračné ukazovatele, nomogram a bodové skóre, úplné vylučovacie kritériá, nálezy k NYHA, NT-proBNP a arytmii), a spresnili sme výklad práce Dalboniho a spoluautorov, v ktorej cystatín C vznik AKI nepredpovedal.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Liu M, Qiu D, Qiu S, Huang W, Qi L, Zhou J, Gong X, Tao Y, Bai J, Cao N. Identification of Risk Factors and Prediction Models for Acute Kidney Injury in Hospitalized Elderly Patients with Heart Failure. <em>Clinical Interventions in Aging.</em> 2026;21:1–18. doi: 10.2147/CIA.S623634. PMID 42829622. <a href="https://pubmed.ncbi.nlm.nih.gov/42829622/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13633713/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group. KDIGO Clinical Practice Guideline for Acute Kidney Injury. <em>Kidney International Supplements.</em> 2012;2(1):1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">plný text KDIGO</a>.</em></small></li>
  <li><small><em>Dalboni MA, Beraldo DO, Quinto BMR, Blaya R, Narciso R, Oliveira M, Monte JCM, Durão MS, Cendoroglo M, Pavão OF, Batista MC. Cystatin C at Admission in the Intensive Care Unit Predicts Mortality among Elderly Patients. <em>ISRN Nephrology.</em> 2013;2013:673795. doi: 10.5402/2013/673795. PMID 24967238. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4045447/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_aki-rizikovy-model-starsi-zlyhavanie-srdca_article',
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
