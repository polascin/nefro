<?php

/**
 * add_estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa_article.php
 * ESTOP-AKI - strojove ucenie predpovedalo riziko AKI, vcasna konzultacia vysledky nezlepsila.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila',
    'slug'         => 'estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Randomizovaná štúdia vybrala modelom strojového učenia 180 hospitalizovaných pacientov s vysokým rizikom akútneho poškodenia obličiek. Včasná nefrologická konzultácia nezmenila kreatinín ani incidenciu AKI — a odporúčania sa realizovali len v 41 % prípadov.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Modely strojového učenia dokážu upozorniť na hroziace akútne poškodenie obličiek hodiny až dni pred vzostupom kreatinínu. Randomizovaná štúdia ESTOP-AKI však ukázala, že samotné upozornenie spolu so včasnou konzultáciou nefrológa výsledky nezlepšilo. Najzaujímavejšie nie je, že štúdia vyšla negatívne — ale kde presne sa reťazec pretrhol.</em></p>

<p>Predikcia akútneho poškodenia obličiek (AKI) patrí k najúspešnejším aplikáciám strojového učenia v nemocničnej medicíne. Model tej istej pracovnej skupiny bol v roku 2020 validovaný na takmer pol milióne hospitalizácií v troch zdravotníckych systémoch a dosahoval plochu pod krivkou ROC <strong>0,85 až 0,86</strong> pre predpoveď AKI druhého alebo vyššieho štádia v nasledujúcich 48 hodinách. Nástup dokázal signalizovať približne <strong>27 až 39 hodín</strong> pred zdvojnásobením sérového kreatinínu.</p>

<p>To je na prediktívny model v klinickej medicíne veľmi dobrý výkon. Otvorenou zostávala druhá otázka — či sa dá takto získaný čas premeniť na lepší výsledok pre pacienta.</p>

<h2>Ako bola štúdia postavená</h2>

<p>Randomizovaná klinická štúdia ESTOP-AKI pod vedením Matthewa M. Churpeka a Jaya L. Koynera zaradila <strong>180 hospitalizovaných pacientov</strong>, ktorí pri zaradení <em>nemali</em> AKI definované vzostupom sérového kreatinínu, ale elektronický model ich označil za osoby so zvýšeným rizikom rozvoja AKI druhého alebo vyššieho štádia.</p>

<ul>
  <li>medián veku <strong>62,5 roka</strong>, <strong>56,7 % mužov</strong>;</li>
  <li><strong>89 pacientov</strong> dostalo štruktúrovanú včasnú konzultáciu nefrológa;</li>
  <li><strong>91 pacientov</strong> pokračovalo v štandardnej starostlivosti, pri ktorej sa nefrológ prizval len na žiadosť ošetrujúceho tímu.</li>
</ul>

<p>Konzultáciu vykonal nefrológ osobným vyšetrením pacienta. Odporúčania sa týkali objemového stavu a renálnej perfúzie, tlaku krvi, výberu a dávkovania liekov, potenciálne nefrotoxických expozícií, podávania tekutín a diuretík, elektrolytových a acidobázických porúch, nutričných potrieb a potreby ďalších vyšetrení.</p>

<p>Nešlo teda o jednu štandardizovanú liečbu, ale o individuálne zostavený súbor odporúčaní. To zodpovedá klinickej realite, no zároveň znemožňuje určiť, ktorá zložka mohla byť účinná — a či vôbec niektorá.</p>

<h2>Výsledky</h2>

<p>Primárnym ukazovateľom bola maximálna zmena sérového kreatinínu počas siedmich dní. Rozdiel bol malý a nevýznamný — vzostup o <strong>0,04 mg/dl</strong> pri včasnej konzultácii oproti poklesu o <strong>0,03 mg/dl</strong> pri štandardnej starostlivosti (P = 0,30).</p>

<p>Výber populácie pritom fungoval: AKI ktoréhokoľvek štádia vzniklo počas siedmich dní u <strong>70 pacientov, teda u 38,9 %</strong> celej kohorty. Model teda skutočne vybral vysokorizikový súbor.</p>

<table>
  <thead>
    <tr><th>Ukazovateľ</th><th>Včasná konzultácia</th><th>Štandardná starostlivosť</th><th>P</th></tr>
  </thead>
  <tbody>
    <tr><td>AKI 1. alebo vyššieho štádia</td><td>42 %</td><td>36 %</td><td>0,47</td></tr>
    <tr><td>AKI 2. alebo vyššieho štádia</td><td>19 %</td><td>13 %</td><td>0,28</td></tr>
    <tr><td>Mortalita do 90 dní</td><td>14,8 %</td><td>18,7 %</td><td>0,62</td></tr>
    <tr><td>Rehospitalizácia do 90 dní</td><td>34,1 %</td><td>44,4 %</td><td>0,21</td></tr>
  </tbody>
</table>

<p>Číselne bola incidencia AKI vyššia v intervenčnej skupine, zatiaľ čo mortalita a rehospitalizácie boli nižšie. Ani jeden z týchto rozdielov nebol štatisticky významný a pri súbore 180 pacientov ide o hodnoty plne zlučiteľné s náhodou. <strong>Nemožno z nich vyvodiť, že konzultácia AKI zvyšovala, ani že znižovala mortalitu.</strong> Štúdia nemala silu na posúdenie tvrdých ukazovateľov.</p>

<h2>Kľúčový nález: odporúčania sa často nerealizovali</h2>

<p>Najinformatívnejším výsledkom nie je primárny ukazovateľ, ale údaj o adherencii. Odporúčania nefrológa boli dodržané:</p>

<ul>
  <li>v <strong>41 %</strong> prípadov v skupine so včasnou konzultáciou,</li>
  <li>v <strong>68 %</strong> prípadov v skupine so štandardnou starostlivosťou.</li>
</ul>

<p>Intervencia, ktorá sa realizuje menej než v polovici prípadov, nemá ako preukázať účinok — aj keby bola sama osebe správna. Štúdia teda netestovala „účinnosť včasnej nefrologickej starostlivosti“, ale <strong>účinnosť ponuky včasnej nefrologickej starostlivosti v reálnom nemocničnom prostredí</strong>. To je legitímna a klinicky relevantná otázka, no je to iná otázka.</p>

<p>Porovnanie oboch mier adherencie si zároveň žiada opatrnosť. <strong>Randomizovaní boli pacienti, nie jednotlivé odporúčania.</strong> V skupine so štandardnou starostlivosťou sa nefrológ prizýval vtedy, keď o to ošetrujúci tím sám požiadal — teda spravidla pri zjavnejšom probléme, s menším počtom odporúčaní a s väčšou vnímanou naliehavosťou. Vyššia adherencia v kontrolnej skupine preto neznamená, že tam bola starostlivosť organizovaná lepšie. Porovnávajú sa dve odlišné klinické situácie.</p>

<h2>Prečo sa včasné odporúčania nedodržiavali</h2>

<p>Vysvetlenia sú hypotetické, ale klinicky zrozumiteľné:</p>

<ul>
  <li><strong>Chýbal viditeľný prejav poškodenia.</strong> Pacient ešte nemal vzostup kreatinínu. Algoritmické upozornenie pôsobí nevyhnutne menej naliehavo než manifestné AKI.</li>
  <li><strong>Odporúčaní bolo veľa naraz.</strong> Ak konzultácia prinesie rozsiahly zoznam, najdôležitejšie opatrenia sa v ňom stratia.</li>
  <li><strong>Konkurenčné klinické ciele.</strong> Odporúčanie zvýšiť perfúzny tlak alebo upraviť diuretickú liečbu môže kolidovať s liečbou srdcového zlyhávania alebo šoku. Potenciálne nefrotoxický liek býva zároveň nenahraditeľný pri liečbe infekcie alebo nádoru.</li>
  <li><strong>Neistý prínos pred vznikom AKI.</strong> Nie je doložené, že každé preventívne vysadenie lieku alebo úprava dávky ešte pred vzostupom kreatinínu zlepší výsledok.</li>
</ul>

<h2>Model predpovedal riziko, nie liečiteľný mechanizmus</h2>

<p>Toto je podľa mňa jadro celého nálezu. Model s plochou pod krivkou ROC 0,86 dobre rozlišuje medzi pacientmi s vyšším a nižším rizikom. Z toho však nevyplýva, že je toto riziko <strong>modifikovateľné</strong>.</p>

<p>Prediktívny model označí pacienta za vysokorizikového pre kombináciu veku, závažnosti základného ochorenia, chronickej choroby obličiek, malignity, hemodynamickej nestability a laboratórnych odchýlok. Väčšinu týchto faktorov nefrologická konzultácia zmeniť nemôže. Vysoké skóre pritom môže rovnako dobre označovať pacienta, ktorého AKI je odvrátiteľné vysadením nefrotoxického lieku, ako aj pacienta, ktorého AKI je nevyhnutným dôsledkom septického šoku.</p>

<p>Rovnaké predpovedané riziko teda môže vzniknúť pri hypovolémii, venóznej kongescii, sepse, hypotenzii, liekovej toxicite, obštrukcii močových ciest alebo kardiorenálnom syndróme. <strong>Univerzálna konzultácia nemôže viesť k univerzálne účinnej intervencii</strong>, pretože účinná intervencia je pri každom z týchto mechanizmov iná — a pri niektorých neexistuje.</p>

<p>Pre prevenciu je preto dôležitejšie rozpoznať <em>reverzibilné</em> riziko než vypočítať vysokú pravdepodobnosť AKI.</p>

<h2>Obmedzenia kreatinínu ako primárneho ukazovateľa</h2>

<p>Sérový kreatinín je základným diagnostickým markerom AKI, ale ako primárny ukazovateľ preventívnej štúdie má slabiny. Stúpa oneskorene za poklesom glomerulárnej filtrácie, závisí od svalovej hmoty, mení sa pri objemovej expanzii aj deplécii, môže byť ovplyvnený liekmi inhibujúcimi tubulárnu sekréciu, nehovorí nič o mechanizme poškodenia a jeho krátkodobá zmena nemusí zodpovedať dlhodobej prognóze.</p>

<p>Budúce štúdie by preto mali okrem maximálnej zmeny kreatinínu hodnotiť aj perzistujúce AKI, potrebu náhrady funkcie obličiek, závažné nežiaduce renálne príhody, trvalý pokles eGFR, funkciu obličiek po prepustení a bezpečnostné dôsledky samotných preventívnych zásahov.</p>

<p>Osobitne stojí za zmienku, že neprítomnosť kreatinínového AKI pri zaradení nevylučovala <em>žiadne</em> akútne poškodenie. Nevylučovala AKI podľa diurézy, veľmi skoré štruktúrne poškodenie ani subklinické poškodenie zachytiteľné biomarkermi. Presnejšie je preto povedať, že pacienti nemali <strong>AKI definované sérovým kreatinínom</strong>.</p>

<h2>Čo zostáva základom prevencie AKI</h2>

<p>Negatívny výsledok štúdie nespochybňuje opatrenia, ktoré vychádzajú z rozpoznaného reverzibilného mechanizmu:</p>

<ol>
  <li><strong>Hemodynamická stabilizácia.</strong> Hypotenziu a nedostatočnú orgánovú perfúziu korigovať podľa príčiny, nie paušálne.</li>
  <li><strong>Presné hodnotenie objemového stavu.</strong> Oligúria ani vzostup kreatinínu automaticky neznamenajú potrebu tekutín — pacient môže byť hypovolemický, normovolemický aj kongestívny. Pri kongescii nadmerná tekutinová liečba stav zhoršuje.</li>
  <li><strong>Revízia liekov, nie automatické vysadenie.</strong> Renálne riziko treba porovnať s prínosom liečby základného ochorenia.</li>
  <li><strong>Úprava dávkovania podľa funkcie obličiek</strong> tak, aby sa predišlo akumulácii bez zbytočného poddávkovania.</li>
  <li><strong>Racionálne používanie kontrastných látok.</strong> Obava z AKI nesmie viesť k odkladu nevyhnutnej diagnostiky alebo život zachraňujúceho výkonu.</li>
  <li><strong>Sledovanie trendu kreatinínu a diurézy</strong> namiesto izolovaných hodnôt.</li>
  <li><strong>Cielené vylúčenie obštrukcie</strong> podľa anamnézy a klinického podozrenia.</li>
</ol>

<h2>Ako by mal vyzerať lepší systém</h2>

<p>Z výsledkov vyplýva pomerne konkrétny smer. Budúci nástroj by nemal len oznámiť, že pacient je rizikový, ale pomôcť určiť, <strong>ktorý faktor riziko vytvára, či je modifikovateľný, ktorá intervencia má prioritu, kto ju vykoná, dokedy, či sa naozaj uskutočnila a s akým účinkom</strong>.</p>

<p>Prakticky môže byť účinnejší stručný a prioritizovaný podnet než rozsiahla konzultácia s desiatkami odporúčaní. Perspektívne sú najmä automatizovaná identifikácia konkrétnych nefrotoxických kombinácií, farmaceutická revízia medikácie, protokoly pre hypotenzných a septických pacientov, cielené balíky starostlivosti, automatická kontrola realizácie odporúčaní a opakované prehodnotenie rizika podľa vývoja stavu.</p>

<h2>Limity</h2>

<ul>
  <li>Ide o <strong>jednu akademickú inštitúciu</strong> a relatívne malý súbor 180 pacientov.</li>
  <li>Intervencia nebola a ani nemohla byť <strong>zaslepená</strong>.</li>
  <li><strong>Nízka adherencia</strong> zásadne oslabuje výpoveď o účinnosti samotnej konzultácie.</li>
  <li>Konzultácia obsahovala <strong>heterogénne zásahy</strong>, takže nemožno určiť, čo bolo testované.</li>
  <li>Kontrolná skupina mohla dostať nefrologickú konzultáciu na žiadosť tímu, čo rozdiel medzi ramenami zmenšuje.</li>
  <li>Primárny ukazovateľ bol <strong>krátkodobý a kreatinínový</strong>.</li>
  <li>Štúdia nemala silu na posúdenie mortality, potreby dialýzy ani dlhodobej funkcie obličiek.</li>
  <li>Výsledky nemusia platiť pre nemocnice s inou organizáciou starostlivosti.</li>
</ul>

<p>Negatívny výsledok preto nemožno zovšeobecniť na všetky prediktívne modely, všetky formy včasnej nefrologickej intervencie ani na všetky nemocničné populácie.</p>

<h2>Záver</h2>

<p>ESTOP-AKI prináša realistický a užitočný výsledok: algoritmus dokáže spoľahlivo upozorniť na rizikového pacienta, ale <strong>upozornenie samo osebe obličky nechráni</strong>. Ani včasná konzultácia nefrológa nemusí zmeniť výsledok, ak riziko nie je modifikovateľné, ak odporúčania nie sú prioritizované a ak sa v praxi nerealizujú.</p>

<p>Bolo by chybou čítať štúdiu ako zlyhanie umelej inteligencie alebo ako dôkaz zbytočnosti včasnej nefrologickej starostlivosti. Model svoju úlohu splnil — takmer 40 % vybraných pacientov skutočne dostalo AKI. Zlyhal <strong>prenos predikcie do konkrétneho, včas vykonaného a účinného zásahu</strong>.</p>

<p>To je zároveň všeobecnejšie poučenie pre celú oblasť klinickej podpory rozhodovania: presnosť modelu je nutnou, nie postačujúcou podmienkou. Nástroj, ktorý identifikuje riziko bez toho, aby ukázal, čo s ním robiť a či sa to urobilo, pridáva do už tak preťaženého prostredia ďalšie upozornenie — a upozornenia bez jasného nasledujúceho kroku sa v nemocnici prehliadajú spoľahlivo.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii</a> — čo vieme a kde sú limity.</li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Vrstvená nefroprotekcia po prekonanom AKI</a>.</li>
  <li><a href="article.php?slug=predikcia-vhodnosti-peritonealnej-dialyzy-validacia">Predikcia vhodnosti peritoneálnej dialýzy</a> — validácia a prírastková hodnota prediktívnych modelov.</li>
  <li><a href="article.php?slug=renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek">Renálna funkčná rezerva</a> — poškodenie obličiek pri normálnej eGFR.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Matthew M. Churpek, Aiman Fatima, Olasunkanmi Anjorin, Ananya Saravanan, Benjamin S. Ko, Samantha Gunning, Megan L. Prochaska, Tipu S. Puri, Anna L. Zisman, Dana P. Edelson, Mihai C. Giurcanu, Jay L. Koyner; Electronic Signal to Prevent Acute Kidney Injury (ESTOP-AKI) Investigative Team.</strong> <em>Early Nephrology Consultation and Acute Kidney Injury in Hospitalized Patients: A Randomized Clinical Trial.</em> JAMA Network Open. 2026;9(7):e2622554. doi: 10.1001/jamanetworkopen.2026.22554. <a href="https://pubmed.ncbi.nlm.nih.gov/42430171/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1001/jamanetworkopen.2026.22554" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://clinicaltrials.gov/study/NCT03590028" target="_blank" rel="noopener noreferrer">NCT03590028</a>.</li>
  <li><strong>Matthew M. Churpek, Kyle A. Carey, Dana P. Edelson, Tripti Singh, Brad C. Astor, Emily R. Gilbert, Christopher Winslow, Nirav Shah, Majid Afshar, Jay L. Koyner.</strong> <em>Internal and External Validation of a Machine Learning Risk Score for Acute Kidney Injury.</em> JAMA Network Open. 2020;3(8):e2012892. doi: 10.1001/jamanetworkopen.2020.12892. <a href="https://pubmed.ncbi.nlm.nih.gov/32780123/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group.</strong> <em>KDIGO Clinical Practice Guideline for Acute Kidney Injury.</em> Kidney International Supplements. 2012;2(1):1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">KDIGO (PDF)</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Early AKI Prevention Tool Flags Risk, but Compliance Low.</em> 2026. <a href="https://www.medscape.com/viewarticle/early-acute-kidney-injury-prevention-tool-flags-risk-2026a1000qao" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a kompletné autorstvo oboch prác Churpeka a spolupracovníkov boli overené v Europe PMC. Proti zneniu abstraktu štúdie ESTOP-AKI boli overené tieto údaje: 180 randomizovaných pacientov, medián veku 62,5 roka, 56,7 % mužov, rozdelenie 89 a 91 pacientov, zmena kreatinínu 0,04 oproti −0,03 mg/dl (P = 0,30), AKI 1.+ štádia 42 % oproti 36 % (P = 0,47), AKI 2.+ štádia 19 % oproti 13 % (P = 0,28), adherencia 41 % oproti 68 %, mortalita do 90 dní 14,8 % oproti 18,7 % (P = 0,62) a rehospitalizácie 34,1 % oproti 44,4 % (P = 0,21). Údaj o 70 pacientoch (38,9 %) s AKI je dopočítaný z uvedených podielov a zodpovedá im. Údaje o validačnej štúdii z roku 2020 (495 971 hospitalizácií, plocha pod krivkou ROC 0,85 – 0,86 pre AKI 2.+ štádia, predstih 27 – 39 hodín) boli overené samostatne. <strong>Neuvádzam</strong> obdobie náboru, presné počty konzultácií a odporúčaní ani etnické zloženie súboru — tieto údaje sa v abstrakte nenachádzajú a nebolo možné ich overiť; jednocentrický charakter štúdie vyplýva z afiliácií autorov a z veľkosti súboru, nie z overeného znenia. Výklad rozdielu medzi predikciou a modifikovateľnosťou rizika, poznámka o tom, že odporúčania neboli randomizované, a praktické zásady prevencie AKI sú <strong>vlastným odborným spracovaním</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa_article',
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
