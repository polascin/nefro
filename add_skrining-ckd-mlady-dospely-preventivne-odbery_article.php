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
    'title' => 'Preventívne odbery u mladého dospelého: kedy má skríning chorôb obličiek zmysel',
    'slug' => 'skrining-ckd-mlady-dospely-preventivne-odbery',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'V bežnom preventívnom paneli pre zdravého mladého dospelého chýba jediný test, ktorý u neho poškodenie obličiek odhalí. A práve u neho ho väčšinou netreba objednávať.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/skrining-ckd-mlady-dospely-preventivne-odbery.webp" type="image/webp">
    <img src="img/skrining-ckd-mlady-dospely-preventivne-odbery.png" alt="Jedina podsvietena skumavka s mocom v tme, z ktorej stupa svetelny obrys obliciek, okolo nej neosvetlene prazdne skumavky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o snímku reálneho laboratórneho vyšetrenia. Pri mladom dospelom rozhoduje jeden cielene zvolený test viac než rozsiahly panel.</figcaption>
</figure>

<p>Dvadsaťtriročná žena príde na preventívnu prehliadku. Nemá chronické ochorenie, neužíva lieky okrem naproxénu raz za mesiac na migrénu, beháva štyrikrát do týždňa a za pol roka schudla sedem kilogramov. Povie vetu, ktorú pozná každá ambulancia: „Päť rokov som nebola na prehliadke. Môžete mi dať spraviť nejaké testy, aby som vedela, že je všetko v poriadku?“</p>

<p>Tento scenár opísal v októbri 2026 Charles P. Vega v komentári pre Medscape Family Medicine a priložil aj svoj obvyklý panel. Z nefrologického hľadiska je na jeho zozname zaujímavejšie to, čo na ňom nie je, než to, čo na ňom je. Zároveň však platí, že najjednoduchšia nefrologická odpoveď („veď jej doplňte UACR“) je v tomto konkrétnom prípade s najväčšou pravdepodobnosťou nesprávna. Tento článok vysvetľuje prečo a kedy sa odpoveď mení.</p>

<h2>Čo bolo na pôvodnom zozname</h2>

<p>Autor pre takúto pacientku štandardne objednáva krvný obraz, nalačno odobraný komplexný metabolický panel, nalačno lipidy, jednorazové stanovenie lipoproteínu(a), skríning na kvapavku a chlamýdie, HIV, protilátky proti vírusu hepatitídy C a sérologický panel hepatitídy B. Výslovne neobjednáva štítnu žľazu, tehotenský test, apolipoproteín B ani vysokocitlivý C-reaktívny proteín.</p>

<p>Každá z týchto položiek má svoje odôvodnenie v preventívnych odporúčaniach, kardiovaskulárnom alebo infektologickom. Obličky v tomto uvažovaní nefigurujú vôbec. Vstupujú doň len mimochodom.</p>

<h2>Kde je v tom paneli oblička</h2>

<p>Komplexný metabolický panel obsahuje kreatinín, takže odhad glomerulárnej filtrácie z neho vypadne akoby mimochodom, bez toho, aby ho niekto cielene indikoval. Čo na paneli chýba, je pomer albumínu ku kreatinínu v moči (UACR).</p>

<p>Tento rozdiel nie je formálny. U dvadsaťtriročnej ženy bez komorbidít bude odhadnutá glomerulárna filtrácia takmer s istotou nad 90 ml/min/1,73 m². Normálna hodnota tu nevylučuje prakticky nič: glomerulárna filtrácia klesá až vtedy, keď je stratená podstatná časť funkčnej rezervy, a v rannom štádiu poškodenia býva dokonca zvýšená. Jediný ukazovateľ, ktorý pri normálnej filtrácii dokáže poškodenie obličiek odhaliť, je albuminúria. Doplnkovo urinárny sediment, ktorý pri mikroskopickej hematúrii v tomto veku otvára úplne inú diferenciálnu diagnostiku, predovšetkým IgA nefropatiu a ochorenie tenkých bazálnych membrán.</p>

<div class="table-responsive" role="region" aria-label="Čo jednotlivé vyšetrenia u mladého dospelého skutočne zachytia" tabindex="0">
<table>
  <thead><tr><th scope="col">Vyšetrenie</th><th scope="col">Čo zachytí</th><th scope="col">Výpovedná hodnota u zdravej 23-ročnej</th></tr></thead>
  <tbody>
    <tr><th scope="row">Kreatinín a eGFR</th><td>Zníženú filtráciu</td><td>Nízka. Normálny výsledok nevylučuje poškodenie obličiek</td></tr>
    <tr><th scope="row">UACR</th><td>Glomerulárne poškodenie pri normálnej filtrácii</td><td>Jediný test s reálnou citlivosťou, ale pri nízkom riziku nízka predikčná hodnota pozitívneho výsledku</td></tr>
    <tr><th scope="row">Močový sediment</th><td>Hematúriu, leukocytúriu, valce</td><td>Užitočný pri cielenom podozrení, nie plošne</td></tr>
    <tr><th scope="row">Prúžkový test na bielkovinu</th><td>Hrubú proteinúriu</td><td>Nedostatočne citlivý na kategóriu A2</td></tr>
    <tr><th scope="row">Opakovane zmeraný krvný tlak</th><td>Najčastejší upraviteľný rizikový faktor</td><td>Najvyššia zo všetkého uvedeného, a stojí nula eur</td></tr>
  </tbody>
</table>
</div>

<h2>Koho KDIGO považuje za rizikového</h2>

<p>Odporúčanie KDIGO 2024 pre hodnotenie a manažment chronickej choroby obličiek formuluje detekciu v praktickom bode 1.1.1.1 takto: testovať osoby s rizikom chronickej choroby obličiek a osoby s týmto ochorením, a to súčasne stanovením albumínu v moči aj posúdením glomerulárnej filtrácie.</p>

<p>Je namieste upozorniť, že ide o <em>praktický bod</em>, nie o odstupňované odporúčanie. Odstupňované odporúčanie 1.1.2.1 (sila 1B) sa týka niečoho iného: u dospelých s rizikom chronickej choroby obličiek sa má filtrácia odhadovať z kreatinínu, a ak je dostupný cystatín C, z kombinácie oboch. Predlohy, ktoré uvádzajú „KDIGO odporúča testovať rizikových“ ako odstupňované odporúčanie, posilňujú silu dôkazu nad rámec toho, čo dokument skutočne uvádza.</p>

<p>Kľúčové slovo je „s rizikom“. KDIGO plošný skríning celej populácie neodporúča. Medzi klasické rizikové konštelácie patrí diabetes mellitus, artériová hypertenzia, kardiovaskulárne ochorenie, srdcové zlyhávanie, prekonané akútne poškodenie obličiek, rodinná anamnéza ochorenia obličiek, štrukturálna anomália močových ciest, systémové ochorenie s obličkovým postihnutím a dlhodobá expozícia nefrotoxickým liekom.</p>

<p>Pacientka zo scenára nespĺňa ani jedno z týchto kritérií. Má index telesnej hmotnosti 28 a obvod pása 92 cm, otca s hypertenziou a starú matku z otcovej strany s cievnou mozgovou príhodou vo veku 66 rokov. To je kardiometabolický rizikový profil, nie nefrologický rizikový profil, a rozdiel medzi nimi je podstatný.</p>

<h2>Čo o tom hovorí zdravotná ekonomika</h2>

<p>Najpriaznivejšia moderná analýza skríningu albuminúrie pochádza z Markovovho modelu publikovaného v <em>Annals of Internal Medicine</em> v roku 2023. Po započítaní účinku inhibítorov SGLT2, ktoré prirodzený priebeh chronickej choroby obličiek skutočne menia, vyšiel jednorazový skríning vo veku 55 rokov s pomerom prírastkovej nákladovej efektívnosti 86 300 USD na získaný rok života s upravenou kvalitou. Skríning raz za desať rokov vo vekovom rozmedzí 35 až 75 rokov stál menej než 100 000 USD na takýto rok.</p>

<p>Pre náš scenár je rozhodujúce, že <strong>najnižší modelovaný vek bol 35 rokov</strong>. Ani analýza, ktorá sa argumentačne snaží skríning rozšíriť čo najširšie, nezahŕňa dvadsaťtriročných. Model bol navyše americký a jeho prahy nákladovej efektívnosti nemožno prenášať do slovenských podmienok bez samostatnej úvahy.</p>

<p>Podobne vyznieva editoriál v <em>Clinical Kidney Journal</em> komentujúci systematický prehľad nákladovej efektívnosti: skríning vo vysokorizikových populáciách je nákladovo efektívny, pre celopopulačný skríning sú dôkazy obmedzené. Autori zároveň uvádzajú tri dôvody, prečo sa bilancia bude zlepšovať: doterajšie modely nezapočítavali prevenciu kardiovaskulárnych príhod, nezohľadňovali nové lieky a nepočítali s domácim odberom.</p>

<h2>USPSTF: odporúčanie je zastarané</h2>

<p>Odporúčanie americkej Preventive Services Task Force z roku 2012 uzavrelo, že dôkazy sú nedostatočné na vyváženie prínosov a škôd skríningu chronickej choroby obličiek u asymptomatických dospelých. Stránka tohto odporúčania je dnes označená ako neaktuálna, s poznámkou, že téma sa aktualizuje a že pôvodný prehľad z roku 2012 môže obsahovať zastarané informácie.</p>

<p>Interpretovať to ako argument proti skríningu by bolo nesprávne. Ide o výslovné priznanie, že stanovisko je zastarané a nové zatiaľ neexistuje. V takej situácii sa klinická prax opiera o stratifikáciu rizika a o aktuálne nefrologické odporúčania, nie o pätnásť rokov starý dokument stiahnutý z obehu jeho vlastným vydavateľom.</p>

<h2>Takže u tejto pacientky</h2>

<p>Vyšetrenie, ktoré má u nej najvyššiu výpovednú hodnotu, nie je laboratórne. Je to riadne odmeraný a zdokumentovaný krvný tlak, ideálne opakovane a mimo ambulancie. Otec s hypertenziou, index telesnej hmotnosti 28 a centrálna distribúcia tuku robia z nej kandidátku na skoré zachytenie hypertenzie, a hypertenzia je presne tá udalosť, ktorá ju o niekoľko rokov preklasifikuje do skupiny, kde UACR indikovaný je.</p>

<p>Pridať UACR k panelu je lacné a je obhájiteľné ako jednorazová východisková hodnota, ak sa pacientka a lekár dohodnú. Nie je to však vyšetrenie podložené odporúčaniami ani ekonomickým modelovaním pre túto vekovú skupinu a pri nízkej predtestovej pravdepodobnosti bude väčšina pozitívnych výsledkov falošne pozitívna.</p>

<p>Odpoveď sa mení, ak je prítomná ktorákoľvek z týchto okolností:</p>

<ul>
  <li>opakovane zvýšený krvný tlak alebo hodnoty v pásme vysokého normálu,</li>
  <li>novo zistený diabetes alebo prediabetes,</li>
  <li>prekonané akútne poškodenie obličiek v akomkoľvek kontexte, vrátane ťažkej dehydratácie, rabdomyolýzy či sepsy,</li>
  <li>rodinná anamnéza ochorenia obličiek, najmä polycystickej choroby, Alportovho syndrómu alebo dialýzy v mladom veku u príbuzného,</li>
  <li>systémové ochorenie s možným obličkovým postihnutím alebo kožné a kĺbové prejavy budiace podozrenie naň,</li>
  <li>dlhodobé alebo pravidelné užívanie nesteroidových antiflogistík, najmä v kombinácii s dehydratáciou pri vytrvalostnom športe,</li>
  <li>plánovaná gravidita, kde východisková hodnota tlaku a albuminúrie má samostatnú prognostickú hodnotu.</li>
</ul>

<p>Posledný bod si pri tejto pacientke zaslúži pozornosť. Naproxén raz mesačne pri migréne je zanedbateľná expozícia. Naproxén užitý pred dlhším behom v horúčave už zanedbateľný nie je a stojí za jednu vetu v rozhovore.</p>

<h2>Ak moč predsa vyšetríte: predanalytické pasce</h2>

<p>Pri pacientke, ktorá behá štyrikrát do týždňa a má nepravidelný menštruačný cyklus po zavedení progesterónového implantátu, je riziko falošne pozitívneho nálezu výrazne vyššie než priemerné. Albuminúria je biologicky premenlivá a na jej hodnotu vplýva celý rad prechodných stavov.</p>

<ul>
  <li><strong>Telesná záťaž.</strong> Intenzívne cvičenie vyvoláva prechodnú albuminúriu. Vzorka sa má odoberať s odstupom najmenej 24 hodín od väčšej záťaže.</li>
  <li><strong>Menštruačné krvácanie a vaginálny výtok.</strong> Kontaminácia vzorky skresľuje albuminúriu aj sediment. Pri nepravidelnom cykle treba na načasovanie myslieť aktívne.</li>
  <li><strong>Infekcia močových ciest a horúčka.</strong> Oba stavy prechodne zvyšujú albuminúriu.</li>
  <li><strong>Poloha tela.</strong> Ortostatická proteinúria je u mladých ľudí relatívne častá a benígna; prvá ranná vzorka ju odlíši.</li>
  <li><strong>Hydratácia a príjem bielkovín.</strong> Výrazná dehydratácia aj veľmi vysoký príjem bielkovín výsledok posúvajú.</li>
</ul>

<p>Z toho vyplýva praktické pravidlo: ak sa UACR objednáva, má to byť prvá ranná vzorka, nie po tréningu a nie počas menštruácie.</p>

<h2>Čo robiť, ak nález vyjde abnormálny</h2>

<p>KDIGO na to má samostatný praktický bod 1.1.1.2: po náhodnom zistení zvýšeného pomeru albumínu ku kreatinínu, hematúrie alebo zníženej odhadnutej glomerulárnej filtrácie treba testy zopakovať a prítomnosť chronickej choroby obličiek potvrdiť.</p>

<p>Ďalší praktický bod to dopĺňa ešte dôraznejšie: chronickosť sa nesmie predpokladať na základe jedinej abnormálnej hodnoty eGFR a UACR, pretože nález môže byť dôsledkom nedávneho akútneho poškodenia obličiek alebo akútneho ochorenia obličiek. Chronickosť znamená trvanie najmenej tri mesiace a dá sa doložiť aj spätne z predchádzajúcich meraní, zobrazovacích nálezov alebo anamnézy.</p>

<p>Zároveň platí tretí praktický bod, ktorý sa pri opatrnosti často prehliada: ak je chronická choroba obličiek pravdepodobná pre prítomnosť ďalších klinických ukazovateľov, treba zvážiť začatie liečby už pri prvom zistení zníženej filtrácie alebo zvýšeného UACR. Čakanie na formálne potvrdenie trojmesačného trvania nie je dôvodom odkladať liečbu u pacienta, u ktorého je diagnóza zrejmá.</p>

<p>U mladej ženy s izolovanou mikroskopickou hematúriou bez proteinúrie a s normálnou filtráciou je postup odlišný a patrí skôr do urologicko-nefrologickej rozvahy než do algoritmu chronickej choroby obličiek.</p>

<h2>Záver pre prax</h2>

<p>Pri zdravom mladom dospelom bez rizikových faktorov nie je plošný skríning chronickej choroby obličiek podložený. Najvyššiu hodnotu má riadne odmeraný krvný tlak a cielená anamnéza, nie rozsiahly panel.</p>

<p>Ak je však indikácia prítomná, platí, že sa testuje v dvoch rozmeroch naraz, teda glomerulárna filtrácia aj albuminúria, pretože u mladého človeka je normálna filtrácia pravidlom a albuminúria je jediný ukazovateľ, ktorý poškodenie odhalí včas. Abnormálny nález sa potvrdzuje opakovaním a hodnotí sa s vedomím predanalytických vplyvov, nie jedným odberom.</p>

<p>Ekonomické modelovanie dnes podporuje skríning albuminúrie od veku 35 rokov. Pre dvadsaťtriročných takýto podklad neexistuje, a pokiaľ nevznikne, je správnou odpoveďou na žiadosť o „kompletné odbery“ rozhovor o riziku, nie dlhší zoznam.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom a informovaným čitateľom. Nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania. Citovaná analýza nákladovej efektívnosti vychádza z amerických nákladových údajov a jej prahy nie sú prenosné do slovenského prostredia. Rozsah preventívnych vyšetrení sa riadi platnou slovenskou úpravou preventívnych prehliadok.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Vega Charles P. A Healthy Young Patient Wants Labs. What Do You Order? <em>Medscape Family Medicine</em>, 22. októbra 2026. <a href="https://www.medscape.com/viewarticle/healthy-young-patient-wants-labs-what-do-you-order-2026a10013by" target="_blank" rel="noopener noreferrer">Celý komentár</a>. Klinický scenár, z ktorého tento článok vychádza.</em></small></p>

<p><small><em>2. Stevens Paul E., Ahmed Sofia B., Carrero Juan Jesus, Foster Bethany a kolektív; Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group (27 autorov). KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International.</em> 2024;105(4S):S117–S314. DOI: <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.10.018</a>. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Voľne dostupný plný text</a>.</em></small></p>

<p><small><em>3. Cusick Marika M., Tisdale Rebecca L., Chertow Glenn M., Owens Douglas K., Goldhaber-Fiebert Jeremy D. Population-Wide Screening for Chronic Kidney Disease: A Cost-Effectiveness Analysis. <em>Annals of Internal Medicine.</em> 2023;176(6):788–797. DOI: <a href="https://doi.org/10.7326/M22-3228" target="_blank" rel="noopener noreferrer">10.7326/M22-3228</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37216661/" target="_blank" rel="noopener noreferrer">PubMed PMID 37216661</a>.</em></small></p>

<p><small><em>4. van Mil Dominique, Pouwels Xavier G. L. V., Heerspink Hiddo J. L., Gansevoort Ron T. Cost-effectiveness of screening for chronic kidney disease: existing evidence and knowledge gaps. <em>Clinical Kidney Journal.</em> 2024;17(1):sfad254. DOI: <a href="https://doi.org/10.1093/ckj/sfad254" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfad254</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38213490/" target="_blank" rel="noopener noreferrer">PubMed PMID 38213490</a>.</em></small></p>

<p><small><em>5. Moyer Virginia A.; U.S. Preventive Services Task Force. Screening for Chronic Kidney Disease: U.S. Preventive Services Task Force Recommendation Statement. <em>Annals of Internal Medicine.</em> 2012;157(8):567–570. DOI: <a href="https://doi.org/10.7326/0003-4819-157-8-201210160-00533" target="_blank" rel="noopener noreferrer">10.7326/0003-4819-157-8-201210160-00533</a>. Odporúčanie je dnes označené ako <a href="https://www.uspreventiveservicestaskforce.org/uspstf/recommendation/chronic-kidney-disease-ckd-screening" target="_blank" rel="noopener noreferrer">neaktuálne a v procese aktualizácie</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Znenie praktických bodov 1.1.1.1, 1.1.1.2, 1.1.3.2 a 1.1.3.3 a odstupňovaného odporúčania 1.1.2.1 bolo overené doslovne v plnom texte odporúčania KDIGO 2024 stiahnutom zo stránok KDIGO, nie v sekundárnych zhrnutiach. Bibliografické údaje odporúčania (ročník, číslo, strany, 27 autorov) boli overené v databáze Crossref. Čísla z analýzy nákladovej efektívnosti a vekové rozmedzie 35 až 75 rokov pochádzajú zo štruktúrovaného abstraktu v PubMed. Stav odporúčania USPSTF bol overený priamo na jeho stránke 24. 10. 2026. Meno autora východiskového komentára bolo overené v byline na verejne prístupnej stránke Medscape.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je nefrologický rozbor konkrétneho preventívneho panelu, upozornenie na to, že praktický bod KDIGO nie je odstupňované odporúčanie, porovnanie veku pacientky s najnižším vekom modelovaným v ekonomickej analýze, zoznam okolností, ktoré indikáciu menia, a prehľad predanalytických vplyvov na albuminúriu u fyzicky aktívnej mladej ženy. Tieto väzby nie sú obsiahnuté vo východiskovom komentári.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=longevity-normalne-vysledky-cielene-testovanie-ckd">Normálne výsledky a cielené testovanie pri chronickej chorobe obličiek</a></li>
  <li><a href="article.php?slug=uacr-upcr-prognosticka-informacia-ckd">UACR a UPCR: akú prognostickú informáciu nesú</a></li>
  <li><a href="article.php?slug=renalna-funkcna-rezerva-normalny-egfr-poskodenie-obliciek">Renálna funkčná rezerva: normálna eGFR a poškodenie obličiek</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_skrining-ckd-mlady-dospely-preventivne-odbery_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "────────────────────────────────────────────────────\n\n";
}
?>