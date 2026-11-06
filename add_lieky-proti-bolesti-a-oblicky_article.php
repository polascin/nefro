<?php

/** Pacientsky článok. Pri publikovaní sa avíza nezaraďujú do fronty. */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [[
    'title' => 'Lieky proti bolesti a obličky: čo si overiť pred prvou tabletou',
    'slug' => 'lieky-proti-bolesti-a-oblicky',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Aj liek bez receptu môže poškodiť obličky. Ako sa líši ibuprofén od paracetamolu, kedy môže pomôcť gél a čo si overiť v lekárni, najmä pri chorobe obličiek.',
    'content' => <<<'HTML'
<figure>
  <img src="img/lieky-proti-bolesti-a-oblicky.webp" alt="Tyrkysový model obličky vedľa blistra s tabletami" width="1586" height="992" loading="lazy" decoding="async">
  <figcaption>Ilustračná scéna s modelom obličky. Nezobrazuje konkrétny liek ani poškodenie orgánu.</figcaption>
</figure>

<p><strong>Ak máte chorobu obličiek, ibuprofén, diklofenak ani naproxén si na bolesť nenasadzujte bez porady s lekárom alebo lekárnikom.</strong> To, že sa liek predáva bez receptu, ešte neznamená, že je vhodný aj pre vás. Rozhoduje účinná látka, dávka, stav obličiek aj ostatné lieky. Bolesť však nemusíte znášať bez pomoci: vhodnú liečbu možno prispôsobiť jej príčine aj vášmu zdravotnému stavu. <sup><a href="#zdroj-1">1</a>, <a href="#zdroj-2">2</a></sup></p>

<h2>Prečo si pri ibuproféne dať pozor</h2>
<p>Ibuprofén, diklofenak a naproxén patria medzi <strong>nesteroidné protizápalové lieky</strong>, označované skratkou NSAID. Tlmia bolesť a zápal, ale môžu znížiť prietok krvi obličkami. Následkom môže byť náhle zhoršenie ich činnosti, teda akútne poškodenie obličiek. Riziko je vyššie pri už poškodenej funkcii obličiek. <sup><a href="#zdroj-2">2</a></sup></p>
<p>Pri chronickej chorobe obličiek nie je vhodné užívať tieto lieky pravidelne na vlastnú päsť. Neznamená to absolútny zákaz za každých okolností: nefrológ môže po zvážení prínosu a rizika zvoliť aj krátkodobú protizápalovú liečbu s kontrolami. Ani silnejší liek na predpis nie je automaticky bezpečnejšou náhradou. <sup><a href="#zdroj-1">1</a></sup></p>

<h2>Najprv skontrolujte, čo už užívate</h2>
<p>Osobitnú opatrnosť si vyžaduje pridanie protizápalového lieku k liečbe vysokého tlaku alebo srdcového zlyhávania. Týka sa to najmä ACE inhibítorov a sartanov, teda skupín liekov používaných aj na ochranu obličiek, a diuretík, liekov podporujúcich vylučovanie vody a soli močom. <strong>Predpísanú liečbu svojvoľne nevysádzajte.</strong> Pred kúpou lieku proti bolesti ukážte lekárnikovi celý zoznam svojich liekov. <sup><a href="#zdroj-2">2</a>, <a href="#zdroj-3">3</a></sup></p>
<p>Skontrolujte aj prípravky na prechladnutie. Môžu už obsahovať liečivo proti bolesti. Dva obaly s rôznymi obchodnými názvami môžu znamenať tú istú účinnú látku a nechcenú dvojnásobnú dávku. Ibuprofén nekombinujte s ďalším protizápalovým liekom bez pokynu lekára. <sup><a href="#zdroj-4">4</a></sup></p>

<figure>
  <img src="img/lieky-proti-bolesti-konzultacia.webp" alt="Ruky pacienta a zdravotníka pri spoločnej kontrole balení liekov" width="1586" height="992" loading="lazy" decoding="async">
  <figcaption>Ilustračná konzultácia. Pri výbere lieku pomôže úplný zoznam liečby vrátane prípravkov bez receptu.</figcaption>
</figure>

<h2>Paracetamol: často vhodná možnosť, ale so správnym dávkovaním</h2>
<p>Pri bežnej bolesti alebo horúčke býva paracetamol pre človeka s chorobou obličiek vhodnejšou možnosťou než protizápalové tablety. Aj jeho použitie si však overte podľa svojho zdravotného stavu. <sup><a href="#zdroj-5">5</a></sup> Pri zníženej funkcii obličiek môže byť potrebné <strong>predĺžiť odstup medzi dávkami</strong>. Slovenský súhrn charakteristických vlastností lieku PARALEN 500 to výslovne uvádza. Preto tu neuvádzame jednu dávkovaciu schému pre všetkých. <sup><a href="#zdroj-6">6</a></sup></p>
<p>Dodržte dávkovanie konkrétneho prípravku a pokyny lekára. Sčítajte paracetamol zo všetkých súčasne užívaných liekov. Predávkovanie môže vážne poškodiť pečeň; počas liečby nepite alkohol. Ak máte chorobu pečene alebo potrebujete paracetamol opakovane, poraďte sa s lekárom. <sup><a href="#zdroj-6">6</a></sup></p>

<h2>Gél na kĺb nie je to isté ako tableta</h2>
<p>Pri bolesti ohraničenej na jeden kĺb môže prichádzať do úvahy lokálna liečba. Z diklofenakového gélu sa do krvi dostáva menej liečiva než z tabliet, preto je riziko pre obličky nižšie. Neznamená to nulové riziko ani možnosť natierať veľké plochy či prekračovať odporúčané množstvo. Pri chorobe obličiek a po transplantácii si vhodnosť gélu overte u svojho zdravotníckeho tímu. <sup><a href="#zdroj-2">2</a>, <a href="#zdroj-5">5</a></sup></p>

<figure>
  <img src="img/lieky-proti-bolesti-lokalna-liecba.webp" alt="Neoznačená tuba s gélom pri kolene dospelého človeka" width="1586" height="992" loading="lazy" decoding="async">
  <figcaption>Ilustračná scéna lokálnej liečby. Množstvo gélu aj dĺžka používania sa riadia konkrétnym prípravkom.</figcaption>
</figure>

<h2>Vraciate alebo máte hnačku? Nepokračujte v samoliečbe naslepo</h2>
<p>Strata tekutín a nízky krvný tlak môžu vyvolať akútne poškodenie obličiek. Ak opakovane vraciate, máte hnačku alebo nedokážete prijímať tekutiny, spojte sa s lekárom, najmä ak už chorobu obličiek máte. Môže byť potrebné upraviť liečbu a skontrolovať krv. <sup><a href="#zdroj-7">7</a></sup> O dočasnom prerušení predpísaných liekov sa dohodnite s lekárom vrátane toho, kedy ich znovu začať užívať. <sup><a href="#zdroj-1">1</a></sup></p>
<p>Ak chodíte na dialýzu alebo máte určené obmedzenie tekutín, riaďte sa individuálnym plánom. Nesnažte sa situáciu riešiť vypitím veľkého množstva vody; pri pokročilej chorobe obličiek môže byť potrebné príjem tekutín obmedzovať. <sup><a href="#zdroj-8">8</a></sup></p>

<h2>Kedy vyhľadať pomoc bez odkladu</h2>
<p><strong>Výrazne menej moču než zvyčajne, nové opuchy, opakované vracanie, nezvyčajná ospalosť alebo zmätenosť si vyžadujú rýchle lekárske posúdenie.</strong> Náhle poškodenie obličiek však môže prebiehať aj bez nápadných príznakov; odhalí ho vyšetrenie krvi. <sup><a href="#zdroj-7">7</a></sup></p>
<p>Pri silnej dýchavici, bolesti na hrudníku alebo poruche vedomia volajte <a href="https://emergency-ba.sk/pre-verejnost/kedy-a-ako-volat-zachranku/" target="_blank" rel="noopener noreferrer">155 alebo 112</a>. Vracanie krvi či čierna dechtovitá stolica počas užívania protizápalového lieku tiež vyžadujú okamžitú pomoc. Pri podozrení na predávkovanie paracetamolom vyhľadajte pomoc ihneď, aj keď sa zatiaľ cítite dobre. <sup><a href="#zdroj-4">4</a>, <a href="#zdroj-6">6</a></sup></p>

<h2>Čo povedať v lekárni</h2>
<p>Stačí začať konkrétne: „Mám chorobu obličiek. Toto sú moje lieky. Čo môžem užiť na túto bolesť a ako dlho?“ Povedzte, kde a odkedy vás bolí, čo ste už užili a či chodíte na dialýzu alebo máte transplantovanú obličku. Ak máte aktuálnu lekársku správu, vezmite ju so sebou. Zoznam liekov udržiavajte aktuálny vrátane výživových doplnkov. <sup><a href="#zdroj-3">3</a></sup></p>
<p>Ak sa bolesť vracia alebo vám bráni v bežnom živote, objednajte sa na vyšetrenie. Cieľom je zistiť jej príčinu a dohodnúť liečbu, ktorá vám pomôže bez zbytočného rizika.</p>

<hr>
<p><small><em>Článok je určený dospelým pacientom a verejnosti. Nenahrádza vyšetrenie ani individuálne odporúčanie lekára. Dávkovanie liekov u detí a v tehotenstve si vyžaduje osobitné posúdenie.</em></small></p>
<h2>Zdroje a ďalšie čítanie</h2>
<p><small><em>Odborné a jazykové spracovanie: MUDr. Ľubomír Polaščín. Zdroje overené 6. novembra 2026. Ide o pôvodný pacientsky prehľad vychádzajúci z nasledujúcich odporúčaní a liekových informácií.</em></small></p>
<ol>
  <li id="zdroj-1"><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117 až S314. Kapitola 4. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>; <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li id="zdroj-2"><small><em>National Kidney Foundation. <a href="https://www.kidney.org/kidney-topics/pain-medicines-and-kidney-disease" target="_blank" rel="noopener noreferrer">Pain Medicines and Kidney Disease</a>. Aktualizované 21. februára 2025.</em></small></li>
  <li id="zdroj-3"><small><em>National Institute of Diabetes and Digestive and Kidney Diseases (NIDDK). <a href="https://www.niddk.nih.gov/health-information/kidney-disease/chronic-kidney-disease-ckd/managing" target="_blank" rel="noopener noreferrer">Managing Chronic Kidney Disease</a>. Časť o bezpečnom užívaní liekov.</em></small></li>
  <li id="zdroj-4"><small><em>MedlinePlus, U.S. National Library of Medicine. <a href="https://medlineplus.gov/druginfo/meds/a682159.html" target="_blank" rel="noopener noreferrer">Ibuprofen</a>. Informácie o liečive.</em></small></li>
  <li id="zdroj-5"><small><em>Kidney Care UK. <a href="https://kidneycareuk.org/kidney-disease-information/treatments/medication-for-kidney-disease/patient-info-pain-medication-for-people-with-chronic-kidney-disease/" target="_blank" rel="noopener noreferrer">Pain medication for people with chronic kidney disease</a>.</em></small></li>
  <li id="zdroj-6"><small><em>PARALEN 500. Súhrn charakteristických vlastností lieku, verzia so zmenou 2025/00429-ZIB. Dokument zverejnený Štátnym ústavom pre kontrolu liečiv. <a href="https://www.sukl.sk/hlavna-stranka/slovenska-verzia/pomocne-stranky/save-dokument?dok_id=867869&amp;dok_sec=d09384e743d48b8a31d27d0a0ddbccbb&amp;page_id=637" target="_blank" rel="noopener noreferrer">Dokument ŠÚKL</a>. Časti 4.2, 4.4 a 4.9.</em></small></li>
  <li id="zdroj-7"><small><em>National Health Service (NHS). <a href="https://www.nhs.uk/conditions/acute-kidney-injury/" target="_blank" rel="noopener noreferrer">Acute kidney injury (AKI)</a>. Odborná kontrola 11. marca 2026.</em></small></li>
  <li id="zdroj-8"><small><em>National Institute of Diabetes and Digestive and Kidney Diseases (NIDDK). <a href="https://www.niddk.nih.gov/health-information/kidney-disease/chronic-kidney-disease-ckd/eating-nutrition" target="_blank" rel="noopener noreferrer">Healthy Eating for Adults with Chronic Kidney Disease</a>. Časť o tekutinách.</em></small></li>
</ol>
HTML,
]];

$result = upsertArticles($pdo, $articles, 'popularne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_lieky-proti-bolesti-a-oblicky_article',
]);

if (php_sapi_name() === 'cli') {
    echo 'Vložených: ' . $result['inserted'] . "\n";
    echo 'Aktualizovaných: ' . $result['updated'] . "\n";
    echo 'Bez zmeny: ' . $result['skipped'] . "\n";
    echo 'Zaradených do fronty avíz: ' . $result['queued'] . "\n";
    foreach ($result['errors'] as $error) {
        fwrite(STDERR, $error . "\n");
    }
    exit($result['errors'] === [] ? 0 : 1);
}
