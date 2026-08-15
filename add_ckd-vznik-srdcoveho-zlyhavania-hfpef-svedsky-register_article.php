<?php

/**
 * add_ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register_article.php
 * CKD a vznik srdcoveho zlyhavania naprieč spektrom ejekcnej frakcie - svedsky register.
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
    'title'        => 'Chronická choroba obličiek a vznik srdcového zlyhávania: najsilnejšia väzba smeruje k HFpEF',
    'slug'         => 'ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Švédsky register srdcového zlyhávania so 103 696 osobami ukazuje, že chronická choroba obličiek súvisí so všetkými fenotypmi srdcového zlyhávania, najsilnejšie však so zachovanou ejekčnou frakciou. Väzba sa zvýrazňuje s poklesom eGFR — dizajn štúdie však vyžaduje opatrné čítanie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Chronická choroba obličiek a srdcové zlyhávanie sa vyskytujú spoločne tak často, že sa ich vzťah považuje za samozrejmý. Analýza švédskeho registra však ukazuje niečo špecifickejšie: väzba nie je rovnako silná pre všetky fenotypy srdcového zlyhávania. Najvýraznejšia je pri zachovanej ejekčnej frakcii a zvýrazňuje sa s pokročilosťou renálnej dysfunkcie.</em></p>

<p>Srdcové zlyhávanie nie je jednotné ochorenie. Podľa ejekčnej frakcie ľavej komory sa delí na tri fenotypy, ktoré sa líšia dominantnými mechanizmami, pridruženými ochoreniami, prognózou aj silou dôkazov pre jednotlivé liečivá:</p>

<ul>
  <li><strong>HFrEF</strong> — znížená ejekčná frakcia pod 40 %,</li>
  <li><strong>HFmrEF</strong> — mierne znížená ejekčná frakcia 40 až 49 %,</li>
  <li><strong>HFpEF</strong> — zachovaná ejekčná frakcia najmenej 50 %.</li>
</ul>

<p>Samotná ejekčná frakcia pritom diagnózu neurčuje. Najmä pri HFpEF sa vyžadujú príznaky alebo prejavy srdcového zlyhávania spolu s dôkazom zvýšených plniacich tlakov, štruktúrneho ochorenia srdca alebo iných relevantných funkčných odchýlok.</p>

<h2>Čo štúdia urobila</h2>

<p>Valeria Valente a spolupracovníci z Karolinska Institutet analyzovali údaje zo Swedish Heart Failure Registry. Išlo o retrospektívnu štúdiu prípadov a kontrol:</p>

<ul>
  <li>zaradení boli pacienti s <strong>prvou diagnózou srdcového zlyhávania</strong> v rokoch <strong>2005 až 2021</strong>;</li>
  <li>ku každému pacientovi bola priradená jedna kontrola bez srdcového zlyhávania, párovaná podľa <strong>pohlavia, roku narodenia a okresu</strong>;</li>
  <li>analyzovaných bolo <strong>51 848 pacientov a 51 848 kontrol</strong>;</li>
  <li>zastúpenie fenotypov: <strong>20 % HFpEF, 23 % HFmrEF, 57 % HFrEF</strong>.</li>
</ul>

<p>Kľúčové pre správne čítanie výsledkov je, že chronická choroba obličiek bola definovaná <strong>dvoma rôznymi spôsobmi a v dvoch rôznych súboroch</strong>:</p>

<ol>
  <li>podľa <strong>kódov MKCH-10</strong> — a to <em>u pacientov aj u kontrol</em>;</li>
  <li>podľa <strong>eGFR pod 60 ml/min/1,73 m²</strong> — ale <em>iba u pacientov so srdcovým zlyhávaním</em>.</li>
</ol>

<p>V analýzach založených na eGFR bola renálna funkcia ďalej členená podľa kategórií KDIGO: G2 (60–89), G3a (45–59), G3b (30–44), G4 (15–29) a G5 (pod 15 ml/min/1,73 m²), pričom G2 slúžila ako referencia.</p>

<h2>Hlavné výsledky</h2>

<p>Pri definícii kódmi MKCH-10 bola chronická choroba obličiek spojená približne s <strong>dvojnásobne vyššou pravdepodobnosťou srdcového zlyhávania</strong> oproti kontrolám bez neho. Sila väzby sa však medzi fenotypmi výrazne líšila:</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Fenotyp</th><th scope="col">Pomer šancí oproti osobám bez srdcového zlyhávania</th></tr>
  </thead>
  <tbody>
    <tr><td><strong>HFpEF</strong></td><td><strong>2,46</strong></td></tr>
    <tr><td>HFrEF</td><td>1,52</td></tr>
    <tr><td>HFmrEF</td><td>1,30</td></tr>
  </tbody>
</table>
</div>

<p>Rozdiel medzi fenotypmi bol štatisticky významný (P pre interakciu = 0,001).</p>

<p>Analýza podľa kategórií KDIGO ukázala odstupňovaný obraz:</p>

<ul>
  <li><strong>G3b až G5</strong> boli oproti referenčnej G2 častejšie spojené s HFpEF než s HFrEF;</li>
  <li><strong>G3a</strong> mala s HFpEF a HFrEF <strong>podobnú</strong> väzbu;</li>
  <li><strong>G3a a G3b</strong> boli s HFmrEF spojené <strong>menej</strong> často než s HFrEF.</li>
</ul>

<p>Autori uzatvárajú, že chronická choroba obličiek bola nezávisle spojená s novovzniknutým srdcovým zlyhávaním — pri stredne ťažkej až pokročilej renálnej dysfunkcii najmä s HFpEF, pri miernej renálnej dysfunkcii s HFpEF aj HFrEF.</p>

<h2>Dve čísla, ktoré sa nesmú zamieňať</h2>

<p>Práca uvádza aj údaj, že pri definícii podľa eGFR bola chronická choroba obličiek spojená s <strong>o 8 % vyššou pravdepodobnosťou HFpEF oproti HFrEF</strong>. Toto číslo pôsobí oproti pomeru šancí 2,46 nenápadne a je namieste vysvetliť, prečo sa tak výrazne líši.</p>

<p>Nejde totiž o ten istý typ porovnania:</p>

<ul>
  <li><strong>Pomer šancí 2,46</strong> porovnáva pacientov s HFpEF s <em>osobami bez srdcového zlyhávania</em>. Odpovedá na otázku, či je chronická choroba obličiek spojená so vznikom tohto fenotypu.</li>
  <li><strong>Hodnota 8 %</strong> porovnáva <em>vnútri súboru pacientov so srdcovým zlyhávaním</em>, ktorý fenotyp je pri zníženej eGFR pravdepodobnejší. Kontrolná skupina do nej vôbec nevstupuje — eGFR nebola u kontrol k dispozícii.</li>
</ul>

<p>Prvé číslo teda hovorí o riziku vzniku ochorenia, druhé o rozložení fenotypov medzi tými, ktorí ho už majú. Zamieňať ich by znamenalo tvrdiť buď, že vplyv obličiek je zanedbateľný, alebo že je dramatický — pričom ani jedno z toho z dát nevyplýva.</p>

<h2>Ako čítať pomer šancí</h2>

<p>Pomer šancí 2,46 neznamená, že srdcové zlyhávanie vzniklo u 246 % pacientov, ani že chronická choroba obličiek zvýšila absolútne riziko o 146 percentuálnych bodov. Vyjadruje pomer šancí na prítomnosť chronickej choroby obličiek medzi pacientmi s daným fenotypom a kontrolami po zohľadnení premenných v modeli.</p>

<p>Pomer šancí nemožno bez ďalších údajov zamieňať za relatívne riziko ani za incidenciu. Keďže ide o štúdiu prípadov a kontrol, z publikovaných hodnôt nemožno vypočítať absolútnu pravdepodobnosť vzniku srdcového zlyhávania u konkrétneho pacienta.</p>

<h2>Prečo práve HFpEF</h2>

<p>Výrazná väzba medzi pokročilou renálnou dysfunkciou a HFpEF je biologicky vierohodná. Štúdia ju však <strong>nedokázala mechanisticky</strong> — nasledujúce vysvetlenia sú kontextom, nie jej zisteniami.</p>

<h3>Chronický systémový zápal a mikrovaskulárna dysfunkcia</h3>

<p>Retencia uremických solútov, oxidačný stres, endotelová dysfunkcia a zápal nízkeho stupňa môžu podporovať mikrovaskulárnu dysfunkciu, hypertrofiu kardiomyocytov, intersticiálnu fibrózu a zvýšenú tuhosť myokardu. Práve tento reťazec sa považuje za jadro patofyziológie HFpEF.</p>

<h3>Tlakové a objemové zaťaženie</h3>

<p>Artériová hypertenzia, retencia sodíka, expanzia extracelulárneho objemu a zvýšená arteriálna tuhosť zvyšujú záťaž ľavej komory a môžu viesť ku koncentrickej hypertrofii, poruche relaxácie a vzostupu plniacich tlakov.</p>

<h3>Anémia a poruchy metabolizmu železa</h3>

<p>Renálna anémia a deficit železa zvyšujú hemodynamické aj metabolické zaťaženie srdca. Ich vzťah k srdcovému zlyhávaniu je zložitejší, než by zodpovedalo samotnej koncentrácii hemoglobínu.</p>

<h3>Porucha minerálového a kostného metabolizmu</h3>

<p>Hyperfosfatémia, zvýšené koncentrácie parathormónu a fibroblastového rastového faktora 23, deficit aktívneho vitamínu D a vaskulárna kalcifikácia môžu prispievať k hypertrofii ľavej komory a k arteriálnej tuhosti.</p>

<h3>Spoločné komorbidity</h3>

<p>Chronická choroba obličiek aj HFpEF sa spájajú s vyšším vekom, obezitou, diabetom, hypertenziou, fibriláciou predsiení a metabolickým syndrómom. Časť pozorovanej väzby preto môže odrážať spoločné rizikové prostredie, nie priamy vplyv obličiek.</p>

<h2>Terminologická poznámka: kedy ide o CKD</h2>

<p>Kategorizácia podľa eGFR sa v praxi často zamieňa za diagnózu. Platí pritom:</p>

<ul>
  <li><strong>eGFR 60 až 89 ml/min/1,73 m² sama osebe nie je chronickou chorobou obličiek.</strong> Kategória G2 predstavuje CKD len pri súčasnej prítomnosti ďalšieho markera poškodenia — albuminúrie, patologického močového sedimentu, štruktúrnej odchýlky, histologicky preukázaného poškodenia alebo stavu po transplantácii obličky.</li>
  <li><strong>Ani jednorazová eGFR pod 60 ml/min/1,73 m² diagnózu nepotvrdzuje.</strong> Chronickosť sa preukazuje trvaním odchýlky najmenej tri mesiace, ak nie je chronický charakter zrejmý z iných údajov.</li>
</ul>

<p>Označenia „mierna“ alebo „pokročilá“ CKD založené len na jednej hodnote eGFR preto treba čítať opatrne. V registrových analýzach ide o pragmatickú, nie diagnostickú kategorizáciu.</p>

<h2>Metodické obmedzenia</h2>

<h3>Asociácia nie je kauzalita</h3>

<p>Retrospektívna observačná štúdia preukazuje súvislosť, nie príčinu. Ani rozsiahla úprava o zmätočné faktory neodstráni tie, ktoré neboli merané alebo boli zachytené nepresne.</p>

<h3>Diferenciálne zachytenie diagnózy</h3>

<p>Toto je pri danom dizajne pravdepodobne najzávažnejšia výhrada. Chronická choroba obličiek bola u kontrol identifikovaná <strong>kódmi MKCH-10</strong>, teda len vtedy, ak ju niekto zaznamenal. Osoby, u ktorých sa neskôr rozvinie srdcové zlyhávanie, majú spravidla <strong>viac kontaktov so zdravotnou starostlivosťou</strong> a viac vyšetrení — a teda vyššiu pravdepodobnosť, že im bude CKD vôbec diagnostikovaná a zakódovaná.</p>

<p>Časť pozorovaného rozdielu tak môže odrážať <strong>rozdiel v intenzite vyšetrovania</strong>, nie v skutočnej prevalencii ochorenia. Toto skreslenie pôsobí v smere nadhodnotenia pomerov šancí. Nevysvetľuje však samo osebe rozdiel <em>medzi fenotypmi</em>, ktorý je hlavným zistením práce — pacienti s HFpEF, HFmrEF a HFrEF sú zo systémového hľadiska porovnateľne sledovaní.</p>

<h3>Chýbajúca albuminúria</h3>

<p>Renálna stratifikácia stojí na eGFR. Albuminúria je pritom nezávislým renálnym aj kardiovaskulárnym rizikovým faktorom a jej neprítomnosť v modeli obmedzuje úplnosť hodnotenia — najmä preto, že práve albuminúria býva včasnejším ukazovateľom mikrovaskulárneho poškodenia, ktoré sa s HFpEF mechanisticky spája.</p>

<h3>Možná obrátená príčinnosť</h3>

<p>Ak sa eGFR stanovovala v čase diagnózy srdcového zlyhávania, mohla byť ovplyvnená venóznou kongesciou, zníženou perfúziou obličiek, diuretickou liečbou alebo akútnym kardiorenálnym syndrómom. Časť „renálnej dysfunkcie“ tak nemusela byť stabilným chronickým stavom predchádzajúcim srdcovému zlyhávaniu.</p>

<h3>Selekcia registra a historické obdobie</h3>

<p>Register nemusí zachytiť všetkých pacientov v populácii; zaradenie závisí od miesta diagnostiky, dostupnosti echokardiografie a organizácie starostlivosti. Údaje navyše pokrývajú roky 2005 až 2021, počas ktorých sa diagnostika aj liečba oboch ochorení podstatne zmenili — najmä zavedením inhibítorov SGLT2 a nesteroidných antagonistov mineralokortikoidových receptorov.</p>

<h3>Obmedzená prenositeľnosť</h3>

<p>Výsledky zo švédskeho systému nemožno bez výhrad preniesť na populácie s odlišnou demografiou, prevalenciou komorbidít, etnickým zložením a dostupnosťou starostlivosti.</p>

<h2>Čo z toho vyplýva pre nefrologickú prax</h2>

<p>Výsledky nepodporujú stanovovanie diagnózy srdcového zlyhávania len na základe poklesu eGFR. Zdôrazňujú však, že pacient s chronickou chorobou obličiek — najmä v štádiách G3b až G5 — má byť aktívne hodnotený aj kardiologicky, a že hľadaným fenotypom bude častejšie HFpEF než HFrEF.</p>

<p>To je klinicky nepríjemné zistenie, pretože HFpEF sa diagnostikuje ťažšie. Nemá nápadne zníženú ejekčnú frakciu, jeho príznaky — dýchavičnosť, znížená tolerancia záťaže, edémy — sa u pacienta s pokročilou CKD ľahko pripíšu samotnému obličkovému ochoreniu alebo previsu objemu, a echokardiografický nález býva nenápadný.</p>

<p>Sledovanie má preto zahŕňať:</p>

<ul>
  <li>tlak krvi a objemový stav;</li>
  <li>eGFR a jej vývoj v čase;</li>
  <li>albuminúriu;</li>
  <li>glykémiu a lipidový profil;</li>
  <li>anémiu a stav zásob železa;</li>
  <li>cielené otázky na námahovú dýchavičnosť, ortopnoe a toleranciu záťaže;</li>
  <li>periférne edémy a ďalšie známky kongescie;</li>
  <li>elektrokardiogram a echokardiografiu podľa klinickej indikácie.</li>
</ul>

<p>Pri nevysvetlenej dýchavičnosti pomáha stanovenie BNP alebo NT-proBNP. U pacientov s chronickou chorobou obličiek sú však koncentrácie natriuretických peptidov zvýšené aj bez akútnej dekompenzácie — výsledok treba interpretovať v kontexte eGFR, srdcového rytmu, veku, telesnej hmotnosti, klinického obrazu a najmä <strong>dynamiky hodnôt u toho istého pacienta</strong>.</p>

<h2>Prevencia</h2>

<p>Prevencia srdcového zlyhávania pri chronickej chorobe obličiek je nevyhnutne multifaktoriálna. Podľa individuálneho profilu zahŕňa dôslednú liečbu hypertenzie, obmedzenie nadmerného príjmu sodíka, liečbu diabetu a obezity, nefajčenie a pravidelnú primeranú pohybovú aktivitu, blokádu systému renín-angiotenzín pri príslušnej indikácii, inhibítor SGLT2 u vhodných pacientov, liečbu dyslipidémie, včasné rozpoznanie a liečbu kongescie a individuálny manažment anémie a deficitu železa.</p>

<p>Inhibítory SGLT2 sú najzreteľnejším prepojením medzi nefroprotekciou a prevenciou srdcového zlyhávania — v štúdii DAPA-CKD dapagliflozín znížil riziko progresie chronickej choroby obličiek aj kardiovaskulárnych príhod vrátane hospitalizácií pre srdcové zlyhávanie. Indikácia závisí od konkrétneho liečiva, eGFR, albuminúrie, prítomnosti diabetu a srdcového zlyhávania a od platných registračných podmienok.</p>

<p>Pokročilejšia chronická choroba obličiek zvyšuje riziko hyperkaliémie, hypotenzie, objemovej deplécie a akútneho poškodenia obličiek — sama osebe však <strong>neodôvodňuje automatické vysadenie</strong> liečiv s preukázaným kardiorenálnym prínosom.</p>

<h2>Záver</h2>

<p>Chronická choroba obličiek bola v tejto rozsiahlej registrovej analýze nezávisle spojená so všetkými fenotypmi novovzniknutého srdcového zlyhávania, najsilnejšie však s HFpEF — a väzba sa zvýrazňovala s poklesom eGFR. Nález dobre zapadá do modelu, v ktorom sa na vzniku HFpEF podieľajú tlakové a objemové preťaženie, zápal, endotelová a mikrovaskulárna dysfunkcia, hypertrofia a fibróza myokardu, anémia a spoločné metabolické komorbidity.</p>

<p>Štúdia však nedokazuje priamu príčinnosť a neumožňuje odhadnúť individuálne absolútne riziko. Klinickým posolstvom preto nie je označiť každého pacienta so zníženou eGFR za pacienta s preklinickým srdcovým zlyhávaním. Je ním niečo praktickejšie: u pacienta s pokročilou chronickou chorobou obličiek a dýchavičnosťou <strong>nestačí uspokojiť sa s normálnou ejekčnou frakciou</strong>. Práve v tejto skupine je HFpEF najpravdepodobnejším a zároveň najľahšie prehliadnuteľným fenotypom.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4, skríning a liečba</a> — rámec kardiovaskulárno-obličkovo-metabolického rizika.</li>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia liečby RAASi a MRA pri CKD a srdcovom zlyhávaní</a>.</li>
  <li><a href="article.php?slug=kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas">Kazuistika: hyperkaliémia pri CKD a srdcovom zlyhávaní</a>.</li>
  <li><a href="article.php?slug=anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi">Anémia pri CKD — praktický algoritmus</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Valeria Valente, Lina Benson, Carin Corovic Cabrera, Raffaele Scorza, Felix Lindberg, Ida Haugen Löfman, Michael Melin, Lars H. Lund, Giulia Ferrannini, Gianluigi Savarese.</strong> <em>Association between chronic kidney disease and heart failure across the ejection fraction spectrum: a retrospective case-control study from the Swedish Heart Failure Registry.</em> ESC Heart Failure. 2026;13(4):xvag196. doi: 10.1093/eschf/xvag196. <a href="https://pubmed.ncbi.nlm.nih.gov/42471242/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/eschf/xvag196" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Hiddo J. L. Heerspink, Bergur V. Stefánsson, Ricardo Correa-Rotter, Glenn M. Chertow, Tom Greene, Fan-Fan Hou, Johannes F. E. Mann, John J. V. McMurray, Magnus Lindberg, Peter Rossing, C. David Sjöström, Roberto D. Toto, Anna-Maria Langkilde, David C. Wheeler; DAPA-CKD Trial Committees and Investigators.</strong> <em>Dapagliflozin in Patients with Chronic Kidney Disease.</em> New England Journal of Medicine. 2020;383(15):1436–1446. doi: 10.1056/NEJMoa2024816. <a href="https://pubmed.ncbi.nlm.nih.gov/32970396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>How Declining Renal Health Shapes Heart Failure.</em> 2026. <a href="https://www.medscape.com/viewarticle/how-declining-renal-health-shapes-heart-failure-2026a1000paq" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a <strong>kompletné autorstvo</strong> primárnej štúdie boli overené v Europe PMC (ESC Heart Failure 2026;13(4):xvag196, PMID 42471242). Proti doslovnému zneniu abstraktu boli overené aj tieto údaje: obdobie 2005 – 2021, párovanie 1 : 1 podľa pohlavia, roku narodenia a okresu, 51 848 pacientov a 51 848 kontrol, zastúpenie fenotypov 20 % HFpEF / 23 % HFmrEF / 57 % HFrEF, obidve definície CKD vrátane toho, že definícia podľa eGFR sa vzťahovala <strong>len na pacientov so srdcovým zlyhávaním</strong>, kategórie KDIGO G2 – G5, pomery šancí 2,46 (HFpEF), 1,30 (HFmrEF) a 1,52 (HFrEF), hodnota <strong>P pre interakciu = 0,001</strong>, údaj o 8 % vyššej pravdepodobnosti HFpEF oproti HFrEF pri definícii podľa eGFR a odstupňovanie podľa kategórií KDIGO. Plný text práce nebol sprístupnený, preto <strong>intervaly spoľahlivosti pre jednotlivé fenotypy, celkový pomer šancí, medián veku ani podiel mužov nie sú v tomto článku uvádzané</strong> — v abstrakte sa nenachádzajú a hodnoty kolujúce v sekundárnom spravodajstve som nemohol overiť. Výklad rozdielu medzi porovnaním voči kontrolám a porovnaním vnútri súboru pacientov, poznámka o diferenciálnom zachytení diagnózy kódmi MKCH-10, terminologická časť o kritériách CKD, patofyziologické vysvetlenia a praktické odporúčania sú <strong>vlastným odborným spracovaním</strong>, nie zisteniami štúdie.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register_article',
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
