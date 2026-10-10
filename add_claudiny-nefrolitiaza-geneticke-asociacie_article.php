<?php

/**
 * Odborný článok o asociáciách variantov génov klaudínov s nefrolitiázou.
 * Slovenské spracovanie pôvodnej asociačnej štúdie Liuovej a spoluautorov
 * (Clinical Kidney Journal 2026), doplnené o klinický kontext genetického
 * vyšetrenia pri nefrolitiáze.
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
    'title'        => 'Klaudíny a nefrolitiáza: nové genetické asociácie a ich klinický význam',
    'slug'         => 'claudiny-nefrolitiaza-geneticke-asociacie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Varianty génov klaudínov rozširujú genetickú mapu nefrolitiázy. Silné asociácie vzácnych variantov CLDN16 sú však založené na niekoľkých nositeľoch a zatiaľ nemenia rutinnú prax.',
    'content'      => <<<'HTML'
<figure><a href="img/claudiny-nefrolitiaza-geneticke-asociacie.webp" target="_blank" rel="noopener noreferrer"><img src="img/claudiny-nefrolitiaza-geneticke-asociacie.webp" alt="Poloschematický rez obličkou s konkrementmi a zväčšeným tesným spojením dvoch tubulárnych buniek, cez ktoré prechádzajú ióny vápnika a horčíka" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna: genetická variabilita klaudínov môže meniť paracelulárny transport iónov a ovplyvniť náchylnosť na tvorbu konkrementov. Obrázok neznázorňuje dokázaný mechanizmus konkrétneho variantu ani individuálnu prognózu.</figcaption></figure>

<p>Genetická predispozícia k nefrolitiáze zahŕňa zriedkavé monogénové ochorenia aj početné varianty s menším účinkom na riziko tvorby konkrementov. Medzi týmito skupinami však nemusí existovať ostrá hranica. Gény zodpovedné za závažné dedičné tubulopatie môžu obsahovať aj varianty, ktoré ovplyvňujú náchylnosť na nefrolitiázu bez rozvoja úplného syndrómu.</p>

<p>Štúdia Iris Y. Liuovej a spoluautorov publikovaná v časopise <em>Clinical Kidney Journal</em> skúmala túto možnosť v rodine génov kódujúcich klaudíny. Analýza 415 237 účastníkov UK Biobank identifikovala nové asociácie medzi genetickými variantmi a nefrolitiázou vrátane vzácnych heterozygotných variantov génu <em>CLDN16</em>. Výsledky rozširujú poznatky o genetickej predispozícii, zatiaľ však neposkytujú podklad na plošný genetický skríning ani na liečbu riadenú konkrétnym klaudínovým variantom. [1]</p>

<h2>Klaudíny regulujú transport medzi bunkami nefrónu</h2>

<p>Klaudíny sú transmembránové bielkoviny tesných medzibunkových spojení. Podieľajú sa na vytváraní bariér a selektívnych paracelulárnych transportných ciest. V obličkách preto ovplyvňujú pohyb iónov medzi epitelovými bunkami, nielen transport cez bunkovú membránu.</p>

<p>Zloženie klaudínov sa medzi úsekmi nefrónu líši. Klaudín 2 sa uplatňuje najmä v proximálnom tubule. Klaudíny 10, 14, 16 a 19 majú významné funkcie v hrubom vzostupnom ramienku Henleho slučky, ktoré je dôležité pre hospodárenie so sodíkom, vápnikom a horčíkom. Klaudíny 16 a 19 funkčne interagujú a spoluvytvárajú podmienky potrebné na paracelulárnu reabsorpciu dvojmocných katiónov. [1]</p>

<p>Bialelické patogénne varianty v génoch <em>CLDN16</em> alebo <em>CLDN19</em> spôsobujú familiárnu hypomagneziémiu s hyperkalciúriou a nefrokalcinózou (FHHNC), autozómovo recesívne ochorenie s rizikom progresívneho poškodenia obličiek. Pri variantoch <em>CLDN19</em> sa môžu pridružiť závažné očné prejavy.</p>

<p><strong>Nefrokalcinóza a nefrolitiáza nie sú synonymá.</strong> Nefrokalcinóza znamená ukladanie vápenatých solí v obličkovom parenchýme, kým nefrolitiáza označuje prítomnosť konkrementov v obličke alebo močových cestách. Môžu sa vyskytovať súčasne, nemožno ich však zamieňať.</p>

<h2>Čo výskumníci analyzovali</h2>

<p>Hlavná analýza zahŕňala nepríbuzných účastníkov európskeho genetického pôvodu:</p>
<ul>
  <li>9 009 osôb s evidovanou nefrolitiázou,</li>
  <li>406 228 kontrol,</li>
  <li>spolu 415 237 účastníkov.</li>
</ul>

<p>Prípady boli identifikované prostredníctvom diagnostických a výkonových kódov. Kontrolnú skupinu teda tvorili osoby bez takto zaznamenanej nefrolitiázy, nie osoby s celoživotne spoľahlivo vylúčenou tvorbou konkrementov. Takáto klasifikácia môže prehliadnuť epizódy ošetrené mimo nemocnice alebo klinicky nemé konkrementy.</p>

<p>Autori skúmali všetkých 24 ľudských génov rodiny <em>CLDN</em>. Kombinovali sekvenovanie exómu s imputovanými genotypovými údajmi, pri ktorých sa časť variantov štatisticky odvodzuje z nameraných genotypov a referenčných populácií. Hodnotili jednotlivé varianty, súhrnnú záťaž variantov v génoch a asociácie s ďalšími klinickými či laboratórnymi znakmi. [1]</p>

<p>Pre interpretáciu je podstatné, že išlo o cielenú asociačnú štúdiu jednej génovej rodiny. Štatistická významnosť po korekcii v rámci tejto analýzy nie je automaticky totožná s dosiahnutím konvenčnej hranice významnosti celogenómovej asociačnej štúdie.</p>

<h2>Najvýraznejšie nálezy v géne CLDN16</h2>

<p>Pozornosť vzbudili dva vzácne varianty meniace aminokyselinovú sekvenciu klaudínu 16.</p>

<div class="table-responsive" role="region" aria-label="Asociácie dvoch vzácnych variantov génu CLDN16 s nefrolitiázou" tabindex="0">
<table>
  <thead><tr><th scope="col">Variant</th><th scope="col">Identifikátor</th><th scope="col">Pomer šancí</th><th scope="col">Nositelia medzi prípadmi a kontrolami</th></tr></thead>
  <tbody>
    <tr><th scope="row"><em>CLDN16</em> p.Gly57Arg</th><td>rs747654138</td><td>42,2</td><td>4 z 9 009 a 5 z 406 208</td></tr>
    <tr><th scope="row"><em>CLDN16</em> p.Arg146His</th><td>rs772241737</td><td>60,5</td><td>2 z 9 009 a 1 z 406 213</td></tr>
  </tbody>
</table>
</div>

<p>Pre p.Gly57Arg autori uvádzajú <em>P</em> = 9,5 × 10<sup>−8</sup>. Asociácia pretrvala aj pri 1 000 permutáciách s empirickou hodnotou <em>P</em> = 0,009. Pri variante p.Arg146His bola hodnota <em>P</em> = 8,12 × 10<sup>−4</sup>. Mierne odlišné počty kontrol pri jednotlivých variantoch vyplývajú z dostupnosti kvalitného genotypu pre daný variant. [1]</p>

<p><strong>Vysoké pomery šancí treba posudzovať spolu s veľmi malým počtom nositeľov.</strong> Odhad založený na troch nositeľoch je mimoriadne neistý a jeho veľkosť môže podstatne zmeniť jediný ďalší prípad alebo kontrola. Navyše ide o pomer šancí, nie o absolútne ani celoživotné riziko.</p>

<p>Štúdia predovšetkým podporuje hypotézu, že niektoré heterozygotné varianty <em>CLDN16</em> môžu ovplyvňovať náchylnosť na nefrolitiázu aj bez bialelického genotypu spôsobujúceho FHHNC. Veľkosť účinku, penetrancia a reprodukovateľnosť však vyžadujú potvrdenie v nezávislých súboroch.</p>

<h2>CLDN19: miernejšia asociácia a minerálový metabolizmus</h2>

<p>Pri variante <em>CLDN19</em> p.Arg200Gln (rs116804195) autori potvrdili už opísanú asociáciu s nefrolitiázou: pomer šancí 1,23, 95 % interval spoľahlivosti 1,10 až 1,37 a <em>P</em> = 2,6 × 10<sup>−4</sup>. Variant bol zároveň asociovaný s nižšou koncentráciou fosfátov v sére a vyššou aktivitou alkalickej fosfatázy. [1]</p>

<p>Tieto výsledky podporujú možnú súvislosť so širšou reguláciou minerálového metabolizmu. Samy osebe však nedokazujú renálne straty fosfátov, osteomaláciu ani konkrétny mechanizmus tvorby konkrementov. Štatisticky významná priemerná zmena laboratórneho ukazovateľa nemusí znamenať klinicky významnú poruchu u jednotlivého nositeľa.</p>

<p>Pri súhrnnom teste variantov génu <em>CLDN19</em> asociácia po odstránení p.Arg200Gln zanikla. Génový výsledok teda zrejme odrážal najmä tento konkrétny variant, nie všeobecný účinok všetkých hodnotených variantov génu.</p>

<h2>Ďalšie lokusy rozširujú výskumnú mapu nefrolitiázy</h2>

<p>Exómová analýza priniesla 43 nových významných asociácií kódujúcich variantov. V imputovaných údajoch autori identifikovali 16 nezávislých asociovaných variantov, z ktorých 13 označili za nové. Signály sa nachádzali aj v oblastiach génov <em>CLDN2</em>, <em>CLDN10</em>, <em>CLDN11</em>, <em>CLDN18</em> a v oblasti <em>CLDN22–CLDN24</em>; potvrdila sa aj známa asociácia s <em>CLDN14</em>. [1]</p>

<p>Tieto výsledky nemožno vykladať ako objav rovnakého počtu nových príčin monogénovej nefrolitiázy. Niektoré varianty ležia mimo kódujúcich oblastí a môžu ovplyvňovať reguláciu génovej expresie; iné môžu iba označovať oblasť vo väzbovej nerovnováhe so skutočným kauzálnym variantom. <strong>Blízkosť variantu ku génu nepreukazuje, že práve tento gén sprostredkúva jeho účinok.</strong></p>

<p>Pri variante v blízkosti <em>CLDN11</em> sa napríklad zistila súvislosť s expresiou génu v tkanive tibiálneho nervu. Takýto nález môže pomôcť formulovať mechanistickú hypotézu, nie je však priamym dôkazom rovnakého regulačného účinku v obličke.</p>

<h2>Hranice dôkazov</h2>

<h3>Externá replikácia kľúčových vzácnych variantov chýba</h3>
<p>Významné výsledky autori preverovali aj u 7 140 účastníkov juhoázijského a 7 278 účastníkov afrického genetického pôvodu, stále však v rámci UK Biobank. Pri známom variante <em>CLDN14</em> zaznamenali v skupine afrického pôvodu nominálne významný výsledok s rovnakým smerom účinku. Nemožno z toho vyvodiť, že sa všetky nové asociácie potvrdili vo všetkých populačných skupinách.</p>

<h3>Chýbajú rozhodujúce metabolické údaje</h3>
<p>UK Biobank nemala k dispozícii 24-hodinové vylučovanie vápnika a fosfátov močom. Štúdia preto nedokáže priamo preukázať, že konkrétny variant zvyšuje riziko prostredníctvom hyperkalciúrie alebo zmenenej fosfatúrie. Výsledky nemožno bez ďalších údajov priradiť ku konkrétnemu chemickému zloženiu konkrementov.</p>

<h3>Funkčný účinok zostáva pri mnohých variantoch hypotézou</h3>
<p>Predikcia škodlivosti, poloha zmenenej aminokyseliny alebo biologická vierohodnosť nenahrádzajú funkčný experiment. Potrebné je overiť lokalizáciu bielkoviny, interakcie klaudínov a výsledný transport iónov.</p>

<h3>Veľká kohorta neodstraňuje problém malých počtov</h3>
<p>Aj v súbore presahujúcom 400-tisíc účastníkov môže konkrétny vzácny variant niesť iba niekoľko osôb. Pri takýchto výsledkoch hrozí nestabilný odhad účinku a jeho nadhodnotenie pri prvom objave. Podobne asociácie s ďalšími diagnózami treba pri širokých intervaloch spoľahlivosti chápať ako podnet na ďalší výskum, nie ako nový potvrdený klinický syndróm.</p>

<h2>Čo sa dá využiť v nefrologickej praxi</h2>

<p>Štúdia podporuje dôsledné zvažovanie genetickej etiológie pri neobvyklom alebo závažnom priebehu nefrolitiázy. Sama však nevytvára nový klinický algoritmus.</p>

<p>Naratívny prehľad Geraghtyho a spoluautorov odporúča zvažovať panelové genetické vyšetrenie u detí, dospelých mladších ako 25 rokov a starších pacientov s charakteristikami vysokorizikového ochorenia, vždy v rámci širšieho metabolického vyšetrenia. Ide o odporúčanie autorov prehľadu, nie o výsledok intervenčnej štúdie ani automaticky záväzný univerzálny štandard. [2]</p>

<p>Klinické podozrenie na dedičnú tubulopatiu zvyšuje najmä kombinácia skorého začiatku, opakovanej alebo obojstrannej tvorby konkrementov, nefrokalcinózy, rodinnej záťaže, chronickej choroby obličiek a nevysvetlenej poruchy minerálového metabolizmu. Pri podozrení na FHHNC má osobitný význam spoločné hodnotenie magneziémie, kalciúrie, funkcie obličiek a zobrazovacieho nálezu. Genetika nenahrádza analýzu konkrementu ani metabolické vyšetrenie; dopĺňa ich.</p>

<h3>Heterozygotný nález nie je diagnózou FHHNC</h3>
<p>Pri interpretácii výsledku treba odlíšiť:</p>
<ol>
  <li>bialelický patogénny genotyp zodpovedajúci recesívnemu ochoreniu,</li>
  <li>heterozygotné nosičstvo patogénneho variantu,</li>
  <li>variant asociovaný s náchylnosťou na nefrolitiázu,</li>
  <li>variant neistého klinického významu.</li>
</ol>

<p>Tieto kategórie nie sú zameniteľné. Nová populačná asociácia sama osebe neoprávňuje prekvalifikovať každý heterozygotný variant na príčinu ochorenia. Pri príbuzných pacienta s molekulárne potvrdenou FHHNC má genetické poradenstvo význam pre vysvetlenie dedičnosti a reprodukčného rizika. Nová štúdia pridáva otázku možnej náchylnosti nositeľov na nefrolitiázu, neurčuje však optimálny rozsah ani interval ich sledovania.</p>

<h3>Liečba sa zatiaľ neriadi identifikovaným klaudínovým variantom</h3>
<p>Štúdia netestovala preventívnu ani farmakologickú intervenciu. Nepreukázala, že by konkrétny variant predpovedal odpoveď na tiazid, alkalický citrát alebo suplementáciu horčíka. Liečba musí vychádzať z klinického a metabolického fenotypu, zloženia konkrementu, funkcie obličiek a individuálnych rizík, nie iba z genetického výsledku.</p>

<h2>Význam pre ďalší výskum</h2>

<p>Najdôležitejším prínosom práce je podpora predstavy kontinua medzi závažnou recesívnou tubulopatiou a geneticky podmienenou náchylnosťou na bežnú nefrolitiázu. Na klinické využitie nových asociácií sú potrebné nezávislé kohorty, rodinné štúdie, metabolická charakterizácia nositeľov a funkčné experimenty. Rozhodujúce bude určiť absolútne riziko, penetranciu a pridanú hodnotu genetického vyšetrenia oproti bežnému klinickému hodnoteniu.</p>

<p>Pre nefrológa je preto výsledok predovšetkým dôvodom na presnejšie etiologické uvažovanie. Nie je dôvodom označiť každého nositeľa klaudínového variantu za pacienta s monogénovým ochorením.</p>

<hr>
<p><small><em><strong>Literatúra</strong></em></small></p>
<ol>
  <li><small><em>Liu IY, Haverfield J, MacKenzie E, et al. Novel associations of Claudin gene variants with kidney stone disease. <span>Clinical Kidney Journal</span>. 2026;19(10):sfag237. DOI: <a href="https://doi.org/10.1093/ckj/sfag237" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag237</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42824688/" target="_blank" rel="noopener noreferrer">42824688</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13627830/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></li>
  <li><small><em>Geraghty R, Lovegrove C, Howles S, Sayer JA. Role of Genetic Testing in Kidney Stone Disease: A Narrative Review. <span>Current Urology Reports</span>. 2024;25(12):311–323. DOI: <a href="https://doi.org/10.1007/s11934-024-01225-5" target="_blank" rel="noopener noreferrer">10.1007/s11934-024-01225-5</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/39096463/" target="_blank" rel="noopener noreferrer">39096463</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_claudiny-nefrolitiaza-geneticke-asociacie_article',
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
