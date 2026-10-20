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
    'title' => 'Očkovanie proti pneumokokom pri chronickej chorobe obličiek a na dialýze: čo platí v roku 2026',
    'slug' => 'pneumokokove-ockovanie-ckd-dialyza',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Pri ESRD je riziko invazívneho pneumokokového ochorenia 3,7-násobné. ACIP radí zlyhanie obličiek medzi imunokompromitujúce stavy, čo skracuje interval PCV15 → PPSV23 na 8 týždňov.',
    'content' => <<<'HTML'
<p>Pneumokokové ochorenia patria k tým komplikáciám, ktoré v nefrologickej ambulancii ľahko zapadnú medzi dôležitejšie starosti. Pritom ide o jedno z mála infekčných rizík, ktoré vieme ovplyvniť vopred, lacno a bez zásahu do ostatnej liečby.</p>

<p>Problém nie je v tom, že by odporúčania chýbali. Problém je, že sa menia, že americké a slovenské pravidlá nie sú totožné, a že očkovaciu anamnézu pacienta spravidla nikto systematicky nesleduje. Tento text zhŕňa, čo dnes platí, a kde presne pri obličkovom pacientovi vznikajú rozdiely oproti bežnej populácii.</p>

<figure>
  <picture>
    <source srcset="img/pneumokokove-ockovanie-ckd-dialyza.webp" type="image/webp">
    <img src="img/pneumokokove-ockovanie-ckd-dialyza.png" alt="Priesvitná sklenená oblička obklopená neúplnou tyrkysovou ochrannou mriežkou, cez ktorej medzery prenikajú tmavočervené párové bakteriálne útvary" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie mikroskopický nález ani snímka konkrétneho pacienta. Znázorňuje oslabenú a rýchlejšie slabnúcu protilátkovú ochranu pri chronickej chorobe obličiek.</figcaption>
</figure>

<h2>Prečo je obličkový pacient iný</h2>

<p>Pneumokokové ochorenia sa delia na neinvazívne formy, pri ktorých sa <em>Streptococcus pneumoniae</em> izoluje z nesterilných miest alebo ide o nebakteriemickú komunitnú pneumóniu, a na <strong>invazívne pneumokokové ochorenie (IPD)</strong>, pri ktorom sa pôvodca izoluje z normálne sterilnej lokality — najmä z krvi alebo z mozgovomiechového moku. IPD má podstatne horšiu prognózu, a práve na jeho prevenciu sa očkovanie zameriava.</p>

<p>Mieru rizika pri chorobe obličiek vyčíslila kohorta Kaiser Permanente Northern California, ktorú cituje aj odporúčanie ACIP:</p>

<div class="table-responsive" role="region" aria-label="Riziko invazívneho pneumokokového ochorenia podľa funkcie obličiek" tabindex="0">
<table>
  <thead><tr><th scope="col">Skupina</th><th scope="col">Relatívne riziko IPD</th></tr></thead>
  <tbody>
    <tr><th scope="row">CKD 3. alebo 4. štádia (GF 15–59 ml/min)</th><td>1,2-násobné</td></tr>
    <tr><th scope="row">ESRD (GF pod 15 ml/min alebo dialýza)</th><td>3,7-násobné</td></tr>
  </tbody>
</table>
</div>

<p>Prehľad belgických a holandských autorov uvádza, že pacienti s CKD majú oproti bežnej populácii zvýšenú chorobnosť a úmrtnosť na pneumokokové ochorenie, pri dialyzovaných až desaťnásobne.</p>

<p>K vyššiemu riziku sa pridáva slabšia odpoveď na očkovanie. Porovnanie imunogenicity PPSV23 u dospelých s CKD a u zdravých ukázalo významne nižšiu imunitnú odpoveď pri CKD. U detí a mladých dospelých s CKD bol po PPSV23 opísaný rýchly pokles hladín protilátok.</p>

<p>Pri dialyzovaných pacientoch je rýchly pokles koncentrácie protilátok dobre známy a má <strong>dve príčiny naraz</strong>: narušenú adaptívnu imunitu a postupné odstraňovanie časti sérových protilátok samotnou dialýzou. Druhý mechanizmus sa pri plánovaní očkovania často prehliada, hoci vysvetľuje, prečo sa dialyzovaný pacient nespráva ako „bežný chronický pacient“.</p>

<p>Z toho vyplýva opačný záver, než aký sa niekedy robí: slabšia odpoveď nie je dôvod na odklad očkovania, ale dôvod očkovať skôr — ideálne v predialyzačnom období, keď je imunitná odpoveď ešte lepšia.</p>

<h2>Aké vakcíny sa používajú</h2>

<p>U dospelých sa dnes používajú dva typy prípravkov:</p>

<ul>
  <li><strong>Konjugované vakcíny (PCV)</strong> — PCV15, PCV20 a PCV21; historicky PCV13. Konjugácia polysacharidu na nosičovú bielkovinu vedie k T-dependentnej odpovedi, teda k imunologickej pamäti a k funkčným opsonizujúcim protilátkam.</li>
  <li><strong>Polysacharidová vakcína (PPSV23)</strong> — pokrýva 23 sérotypov, odpoveď je však T-nezávislá, bez spoľahlivej pamäťovej zložky. Jej miesto je dnes najmä v sekvenčných schémach po konjugovanej vakcíne.</li>
</ul>

<h2>Čo sa v odporúčaniach ACIP zmenilo</h2>

<p>Odporúčanie ACIP z roku 2023 stanovilo rámec pre dospelých od 19 rokov. <strong>23. októbra 2024 ACIP rámec zmenil</strong>: jedna dávka konjugovanej vakcíny sa odporúča všetkým dospelým od 50 rokov, ktorí ešte PCV nedostali. Predtým bola veková hranica 65 rokov.</p>

<p>Pre nefrológiu je dôležité, že <strong>odporúčania pre dospelých vo veku 19–49 rokov s rizikovými stavmi sa touto zmenou nezmenili</strong>. Rovnako sa nezmenili pravidlá pre pacientov očkovaných PCV13. Zmena teda neznamená, že mladší obličkový pacient môže čakať do päťdesiatky — práve naopak, patrí do rizikovej skupiny bez ohľadu na vek.</p>

<h2>Detail, ktorý sa v praxi najčastejšie minie: do ktorej kategórie patrí obličkový pacient</h2>

<p>ACIP delí rizikové stavy na chronické ochorenia a na imunokompromitujúce stavy. <strong>Chronické zlyhanie obličiek a nefrotický syndróm sú zaradené medzi imunokompromitujúce stavy</strong> — a to aj napriek tomu, že by sa za imunokompromitujúce nemuseli považovať. Dôvodom je zhoda v odporúčanom postupe. Autori to v texte uvádzajú výslovne.</p>

<p>Toto zaradenie má priamy praktický dôsledok pri sekvenčnej schéme:</p>

<div class="table-responsive" role="region" aria-label="Minimálny interval medzi PCV15 a PPSV23 podľa kategórie rizika" tabindex="0">
<table>
  <thead><tr><th scope="col">Kategória</th><th scope="col">Minimálny interval PCV15 → PPSV23</th></tr></thead>
  <tbody>
    <tr><th scope="row">Imunokompromitujúci stav (vrátane zlyhania obličiek a nefrotického syndrómu), únik mozgovomiechového moku, kochleárny implantát</th><td>≥ 8 týždňov</td></tr>
    <tr><th scope="row">Chronické ochorenie bez týchto stavov</th><td>≥ 1 rok</td></tr>
  </tbody>
</table>
</div>

<p>Skrátenie na osem týždňov nie je formalita. Jeho zmyslom je skrátiť obdobie, počas ktorého je pacient so zvýšeným rizikom nechránený proti sérotypom, ktoré obsahuje iba PPSV23. Ak sa obličkový pacient omylom zaradí medzi „bežné chronické ochorenia“, zostane bez tejto ochrany o takmer rok dlhšie.</p>

<h3>Praktické schémy podľa doterajšieho očkovania</h3>

<p>Pre dospelého vo veku 19–64 rokov so zlyhaním obličiek alebo nefrotickým syndrómom platí podľa ACIP 2023:</p>

<div class="table-responsive" role="region" aria-label="Schémy očkovania podľa doterajšej očkovacej anamnézy" tabindex="0">
<table>
  <thead><tr><th scope="col">Doteraz podané</th><th scope="col">Ak je dostupná PCV20 alebo PCV21</th><th scope="col">Ak je dostupná PCV15 a PPSV23</th></tr></thead>
  <tbody>
    <tr><th scope="row">Nič alebo neznáme</th><td>1 dávka PCV20</td><td>1 dávka PCV15, potom PPSV23 po ≥ 8 týždňoch</td></tr>
    <tr><th scope="row">Iba PPSV23</th><td>1 dávka PCV20 po ≥ 1 roku od poslednej PPSV23</td><td>1 dávka PCV15 po ≥ 1 roku od poslednej PPSV23</td></tr>
    <tr><th scope="row">Iba PCV13</th><td>1 dávka PCV20 po ≥ 1 roku od PCV13</td><td>PPSV23 po ≥ 8 týždňoch od PCV13, druhá PPSV23 po ≥ 5 rokoch od prvej</td></tr>
    <tr><th scope="row">PCV13 a 1 dávka PPSV23</th><td>1 dávka PCV20 po ≥ 5 rokoch od poslednej dávky</td><td>PPSV23 po ≥ 8 týždňoch od PCV13 a ≥ 5 rokoch od poslednej PPSV23</td></tr>
  </tbody>
</table>
</div>

<p>Dve pravidlá platia naprieč schémami: ak pacient dostal <strong>iba PPSV23</strong>, má doplniť konjugovanú vakcínu s odstupom ≥ 1 rok od poslednej dávky PPSV23. Ak dostal <strong>iba PCV13</strong>, sériu dokončí buď PCV20, alebo PPSV23. Pri použití PCV20 alebo PCV21 ako úvodnej vakcíny u pacienta bez predchádzajúceho očkovania sa PPSV23 už nedopĺňa — séria je kompletná.</p>

<h2>Čo platí na Slovensku</h2>

<p>Americké odporúčania sú podrobnejšie, slovenská prax sa však riadi vlastným predpisom. Vyhláška Ministerstva zdravotníctva SR č. 585/2008 Z. z. v § 9 ods. 2 upravuje odporúčané očkovanie osôb vystavených zvýšenému nebezpečenstvu vybraných nákaz. Očkovanie proti pneumokokovým invazívnym infekciám sa podľa nej vykonáva u dispenzarizovaných osôb <strong>bez ohľadu na vek</strong> so závažnými chronickými ochoreniami dýchacích ciest, srdcovo-cievneho systému, s metabolickými, renálnymi a imunitnými poruchami.</p>

<p>Príloha č. 3 vyhlášky vymedzuje príslušné renálne diagnózy kódmi N04 (nefrotický syndróm) a N18–N19 (zlyhanie obličiek). Vyhláška bola naposledy novelizovaná vyhláškou č. 128/2025 Z. z. s účinnosťou od 1. júna 2025.</p>

<p>Formulácia „bez ohľadu na vek“ je kľúčová: dispenzarizovaný pacient s N18 spĺňa podmienku aj v tridsiatke. Konkrétna dostupnosť a úhrada jednotlivých prípravkov sa však mení, preto si pred indikáciou overte aktuálny kategorizačný zoznam a súhrn charakteristických vlastností lieku.</p>

<h2>Koľko pacientov v skutočnosti očkovanie dostane</h2>

<p>Ako to vyzerá v reálnej praxi, ukázala prospektívna prierezová štúdia zo špecializovaného nefrologického centra v severnej Indii. Sledovala 132 dospelých, ktorí začínali hemodialýzu (priemerný vek 52,6 roka, 72,7 % mužov):</p>

<ul>
  <li>pneumokokovú aj chrípkovú vakcínu dostalo 37 pacientov (28,0 %),</li>
  <li>očkovanie proti hepatitíde B dokončilo 63 pacientov (47,7 %),</li>
  <li><strong>73 pacientov (55,3 %) nebolo zaočkovaných vôbec.</strong></li>
</ul>

<p>Najsilnejším prediktorom zaočkovania bola predchádzajúca nefrologická konzultácia: pneumokokovú vakcínu dostalo 47,1 % pacientov s predchádzajúcou konzultáciou oproti 7,8 % bez nej (p &lt; 0,001). Zaočkovaní pacienti mali zároveň častejšie vytvorenú arteriovenóznu fistulu a častejšie boli posúdení na transplantáciu.</p>

<p>Ide o jedno pracovisko v inom zdravotníckom systéme, takže absolútne čísla na slovenskú prax prenášať nemožno. Smer je však jednoznačný a zhoduje sa s každodennou skúsenosťou: <strong>očkovanie sa neurobí samo</strong>. Bez štruktúrovanej predialyzačnej starostlivosti, ktorá očkovanie zaradí medzi svoje úlohy, zostáva väčšina pacientov nezaočkovaná.</p>

<h2>Kde dôkazy končia</h2>

<p>Pri odporúčaní očkovania je poctivé priznať hranice dôkazov. Prehľad k pneumokokovej vakcinácii pri CKD konštatuje, že:</p>

<ul>
  <li>ochranná hodnota protilátok vyvolaných očkovaním v populácii CKD nie je spoľahlivo doložená,</li>
  <li>údaje o klinických výsledkoch, teda o skutočnom znížení chorobnosti a úmrtnosti pri CKD, <strong>chýbajú</strong>,</li>
  <li>u dialyzovaných existuje iba epidemiologická korelácia medzi stavom zaočkovanosti a mierne nižšou celkovou úmrtnosťou — a korelácia nie je príčinnosť,</li>
  <li><strong>pre preočkovanie po piatich rokoch v dialyzovanej populácii neexistujú dobré údaje.</strong></li>
</ul>

<p>Posledný bod stojí za zdôraznenie, pretože sa v starších textoch rutinne uvádzal opačne. Autori prehľadu zároveň uzatvárajú, že kým lepšie dôkazy nebudú k dispozícii, očkovanie proti pneumokokom treba presadzovať u všetkých pacientov s CKD, a to čo najskôr v priebehu ochorenia. Rozdiel medzi „robíme to, lebo je to rozumné pri nízkom riziku“ a „robíme to, lebo je dokázané, že to znižuje úmrtnosť“ má byť v komunikácii s pacientom priznaný.</p>

<h2>Odporúčaný postup v ambulancii a v dialyzačnom stredisku</h2>

<ol>
  <li><strong>Identifikujte rizikového pacienta.</strong> CKD 4.–5. štádia, ESRD, dialyzovaní, nefrotický syndróm, po transplantácii, imunosupresívna liečba. Pridružene aj diabetes, fajčenie, chronické ochorenie srdca, pečene a pľúc, asplénia, únik mozgovomiechového moku, kochleárny implantát.</li>
  <li><strong>Zistite očkovaciu anamnézu.</strong> Ktorý typ konjugovanej vakcíny, či a kedy PPSV23. Pri neznámej anamnéze postupujte ako pri pacientovi bez predchádzajúceho očkovania.</li>
  <li><strong>Zvoľte schému.</strong> Podľa dostupného prípravku a podľa toho, čo pacient už dostal; pri zlyhaní obličiek použite kratší, osemtýždňový interval.</li>
  <li><strong>Očkujte skoro.</strong> Predialyzačné obdobie je imunologicky výhodnejšie než obdobie po začatí dialýzy.</li>
  <li><strong>Myslite dopredu na transplantáciu.</strong> Po transplantácii obličky sú živé vakcíny kontraindikované. Celú vakcinačnú stratégiu vrátane živých vakcín preto riešte pred zaradením na čakaciu listinu, nie po nej.</li>
  <li><strong>Zapíšte to.</strong> Dátum, prípravok, šarža. Bez záznamu sa o rok nedá rozhodnúť o ďalšej dávke a pacient skončí buď nezaočkovaný, alebo zaočkovaný zbytočne.</li>
</ol>

<h2>Záver</h2>

<p>Pri chronickej chorobe obličiek sa stretávajú dva nepriaznivé faktory: vyššie riziko invazívneho pneumokokového ochorenia — pri ESRD 3,7-násobné — a horšia, rýchlejšie slabnúca odpoveď na očkovanie, ktorú u dialyzovaných zhoršuje aj odstraňovanie protilátok samotnou procedúrou.</p>

<p>Z praktických detailov sú najdôležitejšie tri. ACIP radí zlyhanie obličiek a nefrotický syndróm medzi imunokompromitujúce stavy, čo skracuje interval PCV15 → PPSV23 na osem týždňov. Slovenská vyhláška č. 585/2008 Z. z. zaraďuje diagnózy N04 a N18–N19 medzi indikácie bez ohľadu na vek. A rutinné preočkovanie PPSV23 po piatich rokoch u dialyzovaných dobré dôkazy nemá.</p>

<p>Najväčšou rezervou však nie je výber schémy, ale to, že sa očkovanie vôbec nezačne. Zaradenie kontroly očkovacej anamnézy do predialyzačnej starostlivosti je lacnejšie a účinnejšie než akékoľvek doladenie intervalov.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
</ul>

<h2>Poznámka k dôkazom</h2>

<p>Článok je odborným spracovaním odporúčaní ACIP (MMWR 2023 a aktualizácia z roku 2024), prehľadu k pneumokokovej vakcinácii pri CKD a jednej prierezovej štúdie o zaočkovanosti pri začatí hemodialýzy; doplnený je o platný slovenský predpis. Všetky číselné údaje (relatívne riziko IPD 1,2 a 3,7, minimálne intervaly 8 týždňov a 1 rok, schémy podľa očkovacej anamnézy, podiely zaočkovanosti 28,0 %, 47,7 % a 55,3 %) boli overené proti plnému textu odporúčania ACIP v PubMed Central a proti abstraktom citovaných prác. Bibliografické údaje boli overené cez PubMed. Oproti pôvodnému podkladu sme opravili zastaraný rámec z roku 2023 na stav po aktualizácii z 23. októbra 2024, spresnili zaradenie zlyhania obličiek medzi imunokompromitujúce stavy aj s dôsledkom pre interval, doplnili slovenskú právnu úpravu, a uviedli na pravú mieru tvrdenie o rutinnom preočkovaní PPSV23 po piatich rokoch, pre ktoré v dialyzovanej populácii dobré údaje neexistujú.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Kobayashi M, Pilishvili T, Farrar JL, Leidner AJ, Gierke R, Prasad N, Moro P, Campos-Outcalt D, Morgan RL, Long SS, Poehling KA, Cohen AL. Pneumococcal Vaccine for Adults Aged ≥19 Years: Recommendations of the Advisory Committee on Immunization Practices, United States, 2023. <em>MMWR Recommendations and Reports.</em> 2023;72(3):1–39. doi: 10.15585/mmwr.rr7203a1. PMID 37669242. <a href="https://pubmed.ncbi.nlm.nih.gov/37669242/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10495181/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
  <li><small><em>Kobayashi M, Leidner AJ, Gierke R, Xing W, Accorsi E, Moro P, Kamboj M, Kuchel GA, Schechter R, Loehr J, Cohen AL. Expanded Recommendations for Use of Pneumococcal Conjugate Vaccines Among Adults Aged ≥50 Years: Recommendations of the Advisory Committee on Immunization Practices — United States, 2024. <em>MMWR Morbidity and Mortality Weekly Report.</em> 2025;74(1):1–8. doi: 10.15585/mmwr.mm7401a1. PMID 39773952. <a href="https://pubmed.ncbi.nlm.nih.gov/39773952/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Vandecasteele SJ, Ombelet S, Blumental S, Peetermans WE. The ABC of pneumococcal infections and vaccination in patients with chronic kidney disease. <em>Clinical Kidney Journal.</em> 2015;8(3):318–324. doi: 10.1093/ckj/sfv030. PMID 26034594. <a href="https://pubmed.ncbi.nlm.nih.gov/26034594/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4440476/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
  <li><small><em>Puri S, Thakur AN, Meshram HS, Bhagat C, Modasia B, Batheja V, Mathur RP. Vaccination gaps in incident hemodialysis patients: An opportunity for preventive nephrology, a prospective, cross-sectional study. <em>World Journal of Nephrology.</em> 2026;15(1):114748. doi: 10.5527/wjn.v15.i1.114748. PMID 41884249. <a href="https://pubmed.ncbi.nlm.nih.gov/41884249/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Vyhláška Ministerstva zdravotníctva Slovenskej republiky č. 585/2008 Z. z., ktorou sa ustanovujú podrobnosti o prevencii a kontrole prenosných ochorení, § 9 ods. 2 a príloha č. 3; v znení vyhlášky č. 128/2025 Z. z. účinnej od 1. júna 2025. <a href="https://www.slov-lex.sk/pravne-predpisy/SK/ZZ/2008/585/" target="_blank" rel="noopener noreferrer">znenie predpisu na Slov-Lex</a>.</em></small></li>
  <li><small><em>Centers for Disease Control and Prevention. Pneumococcal Vaccine Recommendations. Aktualizované 25. februára 2026. <a href="https://www.cdc.gov/pneumococcal/hcp/vaccine-recommendations/index.html" target="_blank" rel="noopener noreferrer">odporúčania CDC</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_pneumokokove-ockovanie-ckd-dialyza_article',
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
