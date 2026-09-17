<?php
/**
 * add_finerenon-hypertenzna-nefropatia-bez-diabetu-find-ckd_article.php
 * Idempotentný publikačný skript odborného článku.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Finerenón pri hypertenznej nefropatii bez diabetu: čo prináša analýza FIND-CKD?',
    'slug'         => 'finerenon-hypertenzna-nefropatia-bez-diabetu-find-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prespecifikovaná analýza FIND-CKD naznačuje renálny prínos finerenónu aj pri nediabetickej CKD pripísanej hypertenznej nefropatii. Výsledok je klinicky podnetný, no nepreukazuje účinok nezávislý od tlaku ani sám osebe nemení európsku indikáciu.',
    'content'      => <<<'HTML'
<p><strong>Prespecifikovaná podskupinová analýza štúdie FIND-CKD</strong> prináša randomizované údaje osobitne pre pacientov s <strong>nediabetickou chronickou chorobou obličiek (CKD) pripísanou hypertenznej nefropatii</strong>. Finerenón v tejto skupine spomalil celkový sklon odhadovanej glomerulovej filtrácie (eGFR) a znížil výskyt kompozitného obličkovo-kardiovaskulárneho ukazovateľa oproti placebu. Výsledky sú sľubné, ale treba ich čítať v kontexte podskupinovej analýzy, vybranej albuminurickej populácie, mierneho poklesu krvného tlaku a súčasnej európskej registrácie lieku.</p>

<h2>Najdôležitejší odkaz</h2>

<ul>
  <li>Zo všetkých 1 584 účastníkov FIND-CKD malo 459 (29,0 %) skúšajúcim uvedenú diagnózu hypertenznej nefropatie; 234 dostávalo finerenón a 225 placebo.</li>
  <li>Celkový ročný sklon eGFR bol −3,17 oproti −3,82 mL/min/1,73 m²; rozdiel medzi skupinami predstavoval 0,65 mL/min/1,73 m² za rok (95 % interval spoľahlivosti [IS] 0,02 až 1,29; p = 0,044).</li>
  <li>Kompozitný ukazovateľ sa vyskytol u 12,0 % oproti 18,7 % účastníkov (pomer rizík [HR] 0,61; 95 % IS 0,38 až 0,99; p = 0,045).</li>
  <li>Po šiestich mesiacoch bol systolický tlak oproti placebu nižší o 3,5 mmHg a UACR o 33 %.</li>
  <li>Hyperkaliémia bola častejšia pri finerenóne (17,1 % oproti 9,8 %), hoci ukončenie skúšanej liečby pre hyperkaliémiu bolo zriedkavé (1,3 % oproti 0 %).</li>
  <li>Ide o prespecifikovanú podskupinu, nie o samostatnú štúdiu navrhnutú výlučne pre hypertenznú nefropatiu. Výsledok preto podporuje hypotézu a klinické uvažovanie, ale neumožňuje nekritickú generalizáciu.</li>
</ul>

<h2>Čo bolo v štúdii FIND-CKD testované</h2>

<p>FIND-CKD bola medzinárodná, dvojito zaslepená, placebom kontrolovaná štúdia 3. fázy. Zaradila dospelých s albuminurickou CKD bez diabetu, ktorí už užívali stabilnú maximálnu tolerovanú dávku inhibítora angiotenzín konvertujúceho enzýmu (ACE inhibítora) alebo blokátora receptora angiotenzínu II (ARB). Účastníci boli randomizovaní na finerenón v dávke 10 alebo 20 mg denne podľa eGFR, prípadne na placebo.</p>

<div class="table-responsive" role="region" aria-label="Kľúčové vstupné kritériá štúdie FIND-CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">Kritérium</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Funkcia obličiek a albuminúria</th>
      <td>eGFR ≥ 25 až &lt; 60 mL/min/1,73 m² pri UACR ≥ 200 až &lt; 500 mg/g alebo eGFR ≥ 25 až &lt; 90 mL/min/1,73 m² pri UACR ≥ 500 až ≤ 3 500 mg/g</td>
    </tr>
    <tr>
      <th scope="row">Diabetes</th>
      <td>Diabetes nebol prítomný; pri skríningu sa vyžadoval HbA1c &lt; 6,5 %</td>
    </tr>
    <tr>
      <th scope="row">Základná liečba</th>
      <td>Stabilná maximálna tolerovaná dávka ACE inhibítora alebo ARB najmenej štyri týždne</td>
    </tr>
    <tr>
      <th scope="row">Krvný tlak a draslík</th>
      <td>Systolický tlak &lt; 160 mmHg, diastolický tlak &lt; 100 mmHg a sérový draslík ≤ 4,8 mmol/L pri skríningu</td>
    </tr>
    <tr>
      <th scope="row">Primárny ukazovateľ</th>
      <td>Celkový sklon eGFR, teda priemerná ročná zmena eGFR od východiskovej hodnoty počas sledovania</td>
    </tr>
  </tbody>
</table>
</div>

<p>V celej štúdii finerenón spomalil celkový pokles eGFR: −3,3 oproti −4,0 mL/min/1,73 m² za rok, s rozdielom 0,7 mL/min/1,73 m² za rok (95 % IS 0,3 až 1,1; p &lt; 0,001). Hierarchicky testovaný kompozitný obličkovo-kardiovaskulárny ukazovateľ bol tiež priaznivejší (HR 0,77; 95 % IS 0,60 až 0,99; p = 0,04). Štúdiu financovala a sponzorovala spoločnosť Bayer.</p>

<h2>Kto tvoril podskupinu s hypertenznou nefropatiou</h2>

<p>Etiológiu CKD uviedol skúšajúci; nešlo o centrálne potvrdenú histopatologickú diagnózu. Z 1 584 účastníkov bolo 459 zaradených do kategórie hypertenznej nefropatie. Ich priemerný krvný tlak bol 134/80 mmHg, priemerná eGFR 44 mL/min/1,73 m² a medián UACR 797 mg/g (1. kvartil 566; 3. kvartil 1 247 mg/g). Išlo teda prevažne o populáciu s <strong>výraznou albuminúriou a vysokým rizikom progresie</strong>, nie o reprezentatívny prierez všetkými pacientmi s hypertenziou a CKD.</p>

<p>Označenie „hypertenzná nefropatia“ je v klinickej praxi často diagnózou založenou na pravdepodobnosti a vylúčení iných príčin. Pri výraznej albuminúrii môže zahŕňať zmiešanú hypertenzno-ischemickú chorobu, nerozpoznané primárne ochorenie obličiek alebo viacero súbežných mechanizmov. Analýza preto najpresnejšie vypovedá o pacientoch, ktorých skúšajúci <em>klasifikovali</em> ako hypertenznú nefropatiu.</p>

<h2>Výsledky podskupiny v kontexte celej štúdie</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie výsledkov celej štúdie FIND-CKD a podskupiny hypertenznej nefropatie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Výsledok</th>
      <th scope="col">Celá štúdia FIND-CKD</th>
      <th scope="col">Hypertenzná nefropatia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Počet účastníkov</th>
      <td>1 584</td>
      <td>459</td>
    </tr>
    <tr>
      <th scope="row">Rozdiel celkového sklonu eGFR</th>
      <td>0,7 mL/min/1,73 m² za rok (95 % IS 0,3 až 1,1)</td>
      <td>0,65 mL/min/1,73 m² za rok (95 % IS 0,02 až 1,29)</td>
    </tr>
    <tr>
      <th scope="row">Kompozitný ukazovateľ</th>
      <td>HR 0,77 (95 % IS 0,60 až 0,99)</td>
      <td>12,0 % oproti 18,7 %; HR 0,61 (95 % IS 0,38 až 0,99)</td>
    </tr>
    <tr>
      <th scope="row">Hyperkaliémia</th>
      <td>17,0 % oproti 13,3 %</td>
      <td>17,1 % oproti 9,8 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kompozitný ukazovateľ zahŕňal pretrvávajúci pokles eGFR najmenej o 57 %, zlyhanie obličiek, hospitalizáciu pre srdcové zlyhávanie alebo kardiovaskulárne úmrtie. Hrubý rozdiel pozorovaných podielov 6,7 percentuálneho bodu nemožno automaticky premeniť na spoľahlivé „číslo potrebné liečiť“: na taký výpočet by bol potrebný vopred určený časový horizont a príslušný odhad udalostí pri zohľadnení času sledovania.</p>

<p>Rovnako nemožno rozdiel sklonov eGFR jednoducho prepočítať na počet rokov do dialýzy. Sklon eGFR je užitočný výskumný ukazovateľ progresie CKD, ale budúci priebeh nemusí byť lineárny a individuálnu prognózu ovplyvňuje východisková eGFR, albuminúria, akútne udalosti aj konkurujúce riziko úmrtia.</p>

<h2>Je účinok nezávislý od zníženia tlaku?</h2>

<p>Po šiestich mesiacoch znížil finerenón systolický tlak oproti placebu o 3,5 mmHg a UACR o 33 %. Autori nezistili dôkaz, že by sa liečebný účinok líšil podľa východiskového systolického tlaku: hodnota p pre interakciu bola 0,96 pri sklone eGFR a 0,91 pri kompozitnom ukazovateli.</p>

<p>To však <strong>nie je dôkaz mechanistickej nezávislosti od krvného tlaku</strong>. Interakcia podľa východiskovej hodnoty odpovedá na inú otázku než mediácia zmenou tlaku počas liečby. Pozorovaný renálny prínos môže súvisieť s viacerými hemodynamickými aj nehemodynamickými účinkami blokády mineralokortikoidového receptora. Z týchto údajov nemožno určiť, aký podiel účinku sprostredkovalo zníženie tlaku, albuminúrie alebo iné mechanizmy.</p>

<h2>Ako silný je dôkaz z podskupiny</h2>

<p>Analýza bola prespecifikovaná a liečba bola randomizovaná, čo sú dôležité metodologické prednosti. Napriek tomu nejde o novú randomizovanú štúdiu navrhnutú a štatisticky dimenzovanú výlučne pre hypertenznú nefropatiu. Intervaly spoľahlivosti oboch hlavných odhadov sa približujú k nulovému účinku a nominálne hodnoty p sú tesne pod hranicou 0,05. Verejne dostupný abstrakt podskupinovej práce neuvádza, či a ako bola pri týchto výsledkoch kontrolovaná multiplicita.</p>

<p>Pri interpretácii podskupín je rozhodujúce, či sa účinok medzi podskupinami štatisticky líši, nie to, či je výsledok v jednej podskupine „významný“ a v druhej nie. Publikovaný abstrakt uvádza interakcie podľa východiskového systolického tlaku, ale neuvádza test interakcie medzi hypertenznou nefropatiou a ostatnými etiológiami. Nemožno preto tvrdiť, že je finerenón pri hypertenznej nefropatii účinnejší než pri iných príčinách nediabetickej CKD.</p>

<h2>Bezpečnosť a prenos do praxe</h2>

<p>Hyperkaliémia zostáva predvídateľným rizikom liečby nesteroidným antagonistom mineralokortikoidového receptora. V podskupine sa vyskytla u 17,1 % pacientov liečených finerenónom a u 9,8 % pacientov užívajúcich placebo; liečba sa pre ňu ukončila u 1,3 % oproti 0 %. Nízky počet ukončení je priaznivý, ale treba ho vnímať v podmienkach klinickej štúdie s výberom pacientov a protokolovým monitorovaním.</p>

<p>Podľa aktuálnych európskych informácií o lieku sa pri indikácii CKD finerenón nezačína pri sérovom draslíku nad 5,0 mmol/L ani pri eGFR pod 25 mL/min/1,73 m². Draslík a eGFR sa majú skontrolovať štyri týždne po začatí, opätovnom začatí alebo zvýšení dávky a následne pravidelne. Pri hodnotách draslíka nad 4,8 do 5,0 mmol/L možno začatie zvážiť len s dodatočným monitorovaním. Konkrétne dávkovanie, liekové interakcie a kontraindikácie treba vždy overiť v aktuálnom súhrne charakteristických vlastností lieku.</p>

<h2>Čo výsledky podporujú a čo ešte nie</h2>

<div class="table-responsive" role="region" aria-label="Praktická interpretácia výsledkov analýzy FIND-CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Podporené údajmi</th>
      <th scope="col">Z údajov nemožno vyvodiť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Finerenón pridaný k ACE inhibítoru alebo ARB spomalil pokles eGFR vo vybranej albuminurickej populácii bez diabetu.</td>
      <td>Že rovnaký účinok platí pri UACR pod 200 mg/g, eGFR pod 25 mL/min/1,73 m² alebo pri nekontrolovanej hypertenzii.</td>
    </tr>
    <tr>
      <td>Smer a veľkosť účinku v podskupine s hypertenznou nefropatiou boli klinicky priaznivé.</td>
      <td>Že diagnóza bola histologicky potvrdená alebo že finerenón účinkuje pri tejto etiológii lepšie než pri iných etiológiách.</td>
    </tr>
    <tr>
      <td>Finerenón znížil aj UACR a mierne systolický tlak.</td>
      <td>Že renálny účinok bol dokázateľne nezávislý od zmeny tlaku alebo že liek nahrádza štandardnú antihypertenznú liečbu.</td>
    </tr>
    <tr>
      <td>Pri protokolovom monitorovaní viedla hyperkaliémia k ukončeniu liečby len zriedkavo.</td>
      <td>Že monitorovanie draslíka možno v bežnej praxi obmedziť.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Súčasná európska indikácia a odporúčania</h2>

<p>K septembru 2026 je finerenón v Európskej únii schválený na liečbu CKD s albuminúriou spojenej s diabetom 2. typu u dospelých a samostatne na liečbu symptomatického chronického srdcového zlyhávania s ejekčnou frakciou ľavej komory ≥ 40 %. <strong>Nediabetická CKD pripísaná hypertenznej nefropatii sama osebe zatiaľ nie je európskou indikáciou.</strong> Pacient môže, samozrejme, spĺňať inú platnú indikáciu, napríklad pre srdcové zlyhávanie.</p>

<p>Usmernenie Európskej kardiologickej spoločnosti z roku 2026 odporúča finerenón pri CKD spojenej s diabetom 2. typu a albuminúriou; výsledok FIND-CKD ešte nepredstavuje všeobecné odporúčanie pre nediabetickú hypertenznú nefropatiu. Rozhodnutie mimo schválenej indikácie musí byť individuálne, transparentne zdôvodnené, opreté o úplné regulačné informácie a oddelené od otázky národnej úhrady.</p>

<h2>Čo je rozumné urobiť dnes</h2>

<ol>
  <li><strong>Overiť fenotyp a etiológiu CKD.</strong> Výrazná albuminúria si zaslúži zhodnotenie alternatívnych alebo súbežných príčin, nie automatické označenie „hypertenzná nefropatia“.</li>
  <li><strong>Optimalizovať štandardnú liečbu.</strong> FIND-CKD testovala finerenón na podklade maximálnej tolerovanej blokády renín-angiotenzínového systému. Výsledky nenahrádzajú kontrolu tlaku, režimové opatrenia ani ostatnú liečbu s preukázaným prínosom.</li>
  <li><strong>Zohľadniť modernú vrstvenú liečbu.</strong> Na začiatku FIND-CKD užívalo inhibítor SGLT2 len 16,9 % celej populácie. Veľkosť dodatočného prínosu finerenónu u pacienta už liečeného plne vrstvenou súčasnou terapiou preto nie je presne určená.</li>
  <li><strong>Posúdiť riziko hyperkaliémie.</strong> Rozhodovanie musí zahŕňať eGFR, draslík, súbežné lieky, akútne ochorenia a možnosť spoľahlivých kontrol.</li>
  <li><strong>Oddeliť dôkaz od registrácie.</strong> Pozitívna štúdia a schválená indikácia nie sú totožné. Pred predpisom treba skontrolovať aktuálny európsky aj slovenský regulačný a úhradový stav.</li>
</ol>

<h2>Záver</h2>

<p>Analýza FIND-CKD rozširuje dôkaz, že blokáda mineralokortikoidového receptora finerenónom môže chrániť obličky aj bez diabetu. U pacientov s CKD pripísanou hypertenznej nefropatii, výraznou albuminúriou a optimalizovanou liečbou ACE inhibítorom alebo ARB bol účinok na sklon eGFR aj kompozitný klinický ukazovateľ priaznivý. Najpoctivejší záver však znie: ide o prespecifikovaný, klinicky dôležitý podskupinový signál konzistentný s hlavným výsledkom štúdie, nie o dôkaz pre každého pacienta s hypertenziou a CKD ani o automatickú zmenu európskej indikácie.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=finerenon-zakladna-liecba-ckd-glomerularne-ochorenia">Finerenón: potenciál ako základná liečba pri CKD aj bez diabetu a pri glomerulárnych ochoreniach</a></li>
  <li><a href="article.php?slug=nediabeticka-ckd-nehemodynamicke-mechanizmy-nsmra-finerenon">Nediabetická CKD: nehemodynamické mechanizmy a miesto finerenónu</a></li>
  <li><a href="article.php?slug=finerenon-empagliflozin-confidence-albuminuria-krvny-tlak">Finerenón a empagliflozín v štúdii CONFIDENCE</a></li>
  <li><a href="article.php?slug=cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax">Cieľový systolický tlak 120 mmHg pri CKD: odporúčanie KDIGO a reálna prax</a></li>
</ul>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Heerspink HJL, Beernink JM, Agarwal R, et al. Finerenone in hypertensive non-diabetic chronic kidney disease: a FIND-CKD subgroup analysis. <em>European Heart Journal</em>. Publikované online 30. augusta 2026; ehag729. <a href="https://doi.org/10.1093/eurheartj/ehag729" target="_blank" rel="noopener noreferrer">doi:10.1093/eurheartj/ehag729</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42669052/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li>Heerspink HJL, Agarwal R, Cherney DZI, et al. Finerenone in Nondiabetic Chronic Kidney Disease. <em>New England Journal of Medicine</em>. 2026;395:533–545. <a href="https://doi.org/10.1056/NEJMoa2604625" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2604625</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42246672/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li>Heerspink HJL, Agarwal R, Cherney DZI, et al. Design and baseline characteristics of the Finerenone, in addition to standard of care, on the progression of kidney disease in patients with non-diabetic chronic kidney disease trial. <em>Nephrology Dialysis Transplantation</em>. 2025;40(2):308–319. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11852274/" target="_blank" rel="noopener noreferrer">Otvorený plný text</a>.</li>
  <li>ClinicalTrials.gov. A Trial to Learn How Well Finerenone Works and How Safe it is in Adult Participants With Non-diabetic Chronic Kidney Disease (FIND-CKD), NCT05047263. <a href="https://clinicaltrials.gov/study/NCT05047263" target="_blank" rel="noopener noreferrer">Záznam štúdie</a>.</li>
  <li>European Medicines Agency. Kerendia: EPAR a aktuálne informácie o lieku. Aktualizované 7. mája 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kerendia" target="_blank" rel="noopener noreferrer">EMA</a>; <a href="https://www.ema.europa.eu/en/documents/product-information/kerendia-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">informácie o lieku</a>.</li>
  <li>European Society of Cardiology. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease. <a href="https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/cvd-chronic-kidney-disease/" target="_blank" rel="noopener noreferrer">Oficiálne usmernenie</a>.</li>
  <li>KDIGO. 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Oficiálna stránka</a>.</li>
  <li>Bayer. Finerenone slowed kidney function decline and reduced kidney-cardiovascular risk versus placebo in patients with hypertensive nephropathy. Tlačová správa, 30. augusta 2026. <a href="https://www.bayer.com/media/en-us/finerenone-slowed-kidney-function-decline-and-reduced-kidney-cardiovascular-risk-versus-placebo-in-patients-with-hypertensive-nephropathy/" target="_blank" rel="noopener noreferrer">Tlačová správa s absolútnymi počtami a podielmi</a>.</li>
</ol>

<p><small>Stav regulačných údajov a odporúčaní overený 13. septembra 2026. Text je odborným informačným materiálom a nenahrádza individuálne klinické rozhodnutie ani aktuálny súhrn charakteristických vlastností lieku.</small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_finerenon_hypertenzna_nefropatia_find_ckd_article',
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
