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
    'title' => 'Urolitiáza na urgentnom príjme: CT pribúda, ultrasonografia ustupuje',
    'slug' => 'urolitiaza-urgentny-prijem-ct-ultrasonografia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Americká analýza zaznamenala rast CT pri urolitiáze zo 73,8 % na 89,8 %. Výsledok opisuje prax, nepreukazuje však, že by všetky vyšetrenia boli potrebné, ani že boli nevhodné.',
    'content' => <<<'HTML'
<p>Pri návštevách amerických urgentných príjmov s diagnózou močových kameňov sa počítačová tomografia používala čoraz častejšie. V rozsiahlej analýze elektronických zdravotných záznamov vzrástol podiel návštev s CT vyšetrením zo 73,8 % v roku 2016 na 89,8 % v roku 2024. Zaznamenané použitie ultrasonografie sa v rovnakom období znížilo z 5,8 % na 3,8 %. [1]</p>

<p>Tieto čísla ukazujú výraznú prevahu CT, samy osebe však nehovoria, koľko vyšetrení bolo potrebných alebo zbytočných. Štúdia neporovnávala diagnostické stratégie a neposudzovala primeranosť jednotlivých indikácií. Otvára preto praktickejšiu otázku: kedy CT skutočne mení rozhodnutie, kedy možno začať ultrasonografiou a ako pritom neprehliadnuť rizikovú obštrukciu alebo inú závažnú príčinu bolesti.</p>

<figure>
  <picture>
    <source srcset="img/urolitiaza-urgentny-prijem-ct-ultrasonografia.webp" type="image/webp">
    <img src="img/urolitiaza-urgentny-prijem-ct-ultrasonografia.png" alt="Pacient s bolesťou v boku a ilustračným zobrazením obličky, ureterálneho konkrementu, CT a ultrasonografie" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Voľba zobrazovacej metódy pri podozrení na urolitiázu závisí od klinického scenára, diagnostickej neistoty a rizika komplikácií. Ilustračné zobrazenie.</figcaption>
</figure>

<h2>Čo výskumníci skutočne sledovali</h2>

<p>Grace V. Riley a spoluautori analyzovali údaje platformy Epic Cosmos od januára 2016 do decembra 2024. Súbor zahŕňal 248 564 812 návštev dospelých na urgentných príjmoch, z ktorých 2 762 879, teda 1,11 %, bolo spojených s príslušným diagnostickým kódom močových kameňov. Výsledky publikovali v časopise <em>The Journal of Emergency Medicine</em>. [1]</p>

<p>Jednotkou analýzy bola <strong>návšteva urgentného príjmu, nie jedinečný pacient</strong>. Človek s opakovanými kolikami mohol prispieť viacerými návštevami. Veľkosť súboru preto nemožno opisovať ako počet rôznych pacientov.</p>

<p>Hoci autori v názve používajú označenie <em>nephrolithiasis</em>, zaradili kódy pre konkrement obličky, močovodu, súčasný výskyt v obličke a močovode aj bližšie neurčený močový konkrement. Pri opise celej skúmanej skupiny je preto presnejšie hovoriť o urolitiáze. Výskumníci hodnotili zobrazovacie vyšetrenia, hospitalizácie, kultivácie moču, podanie a predpisovanie liekov aj urologické výkony. Išlo o prierezovú observačnú analýzu zaznamenanej starostlivosti, nie o skúšku účinnosti konkrétneho postupu.</p>

<h2>CT sa stalo takmer rutinnou súčasťou vyšetrenia</h2>

<div class="table-responsive" role="region" aria-label="Zmeny vo vyšetreniach, hospitalizáciách a liečbe urolitiázy" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Rok 2016</th><th scope="col">Rok 2024</th></tr></thead>
  <tbody>
    <tr><th scope="row">Návštevy s CT vyšetrením</th><td>73,79 %</td><td>89,83 %</td></tr>
    <tr><th scope="row">Návštevy s ultrasonografiou</th><td>5,78 %</td><td>3,80 %</td></tr>
    <tr><th scope="row">Návštevy ukončené hospitalizáciou</th><td>8,85 %</td><td>12,65 %</td></tr>
    <tr><th scope="row">Podanie opioidov počas návštevy</th><td>61,50 %</td><td>49,70 %</td></tr>
    <tr><th scope="row">Cystoskopia so zavedením ureterálneho stentu</th><td>2,96 %</td><td>6,81 %</td></tr>
  </tbody>
</table>
</div>

<p>Percentá sa vzťahujú na návštevy s príslušnou diagnózou v danom roku. Jednotlivé vyšetrenia a výkony sa mohli pri tej istej návšteve kombinovať. Štúdia neurčovala ani ich časové poradie, preto nevieme, koľkokrát sa CT vykonalo priamo a koľkokrát až po ultrasonografii. [1]</p>

<p>Pri oboch zobrazovacích metódach bol časový trend štatisticky významný (p &lt; 0,001). Pri miliónoch návštev však nízka hodnota p neodpovedá na otázku klinickej primeranosti. Tá vyžaduje informácie o konkrétnom pacientovi, priebehu ťažkostí a dôvode vyšetrenia.</p>

<h2>Označenie „CT“ zahŕňalo aj kontrastné vyšetrenia</h2>

<p>Do kategórie CT autori zahrnuli CT brucha a panvy bez kontrastnej látky, s kontrastnou látkou aj kombinované vyšetrenie bez kontrastnej látky a následne s jej podaním. Výsledných takmer 90 % preto nemožno interpretovať ako podiel návštev so štandardizovaným nízkodávkovým natívnym CT pri podozrení na močový kameň. [1]</p>

<p>Niektoré vyšetrenia mohli riešiť inú diagnostickú otázku a konkrement sa mohol zachytiť súčasne alebo náhodne. Databáza neposkytovala konkrétne radiačné dávky. Z rastúceho podielu CT možno usudzovať na častejšie využívanie tejto metódy, bez údajov o protokoloch, dávkach a opakovaných vyšetreniach však nemožno vyčísliť zmenu radiačnej záťaže jednotlivých pacientov.</p>

<p>Radiačnú expozíciu treba odlišovať od podania jódovej kontrastnej látky. Natívne CT kontrastnú látku nevyžaduje a táto štúdia neposudzovala poškodenie obličiek súvisiace s jej podaním.</p>

<h2>Nízke využitie ultrasonografie treba interpretovať opatrne</h2>

<p>Autori použili výkonové kódy kompletného a limitovaného retroperitoneálneho ultrasonografického vyšetrenia. Neuvádzajú samostatnú validáciu úplnosti záznamov ultrasonografie vykonanej ošetrujúcim lekárom pri lôžku, označovanej ako POCUS. [1]</p>

<p>Možné nedostatočné zachytenie takýchto vyšetrení je preto metodická otázka, nie preukázané vysvetlenie nízkych percent. Nemožno tvrdiť, že sa všetky nezaznamenané vyšetrenia uskutočnili, ale ani stotožniť chýbajúci výkonový kód s istotou, že ultrasonografia nebola vykonaná. Údaje neukazujú ani jej dostupnosť mimo bežného pracovného času, skúsenosť vyšetrujúceho či kvalitu nálezu.</p>

<h2>Výber podľa diagnózy mohol zvýhodniť CT</h2>

<p>Do analýzy vstúpili návštevy s kódom urolitiázy, nie všetci pacienti s bolesťou v boku alebo s podozrením na renálnu koliku. Pacient s konkrementom potvrdeným na CT pravdepodobnejšie dostane konkrétny diagnostický kód. Pri klinickom vyšetrení bez definitívneho zobrazenia môže zostať v dokumentácii iba bolesť brucha alebo boku.</p>

<p>Samotní autori upozorňujú, že takto vytvorený súbor môže nadmerne zastupovať návštevy s CT. [1] Podiel 89,8 % preto nie je totožný s pravdepodobnosťou CT u každého človeka s prvotným podozrením na močový kameň. Ani rast podielu návštev s urolitiázou približne z 1,0 % na 1,2 % nedokazuje rovnaký rast populačnej incidencie. Chýba stabilný populačný menovateľ a rozlíšenie nových ochorení od recidív a opakovaných návštev.</p>

<h2>Viac hospitalizácií neznamená automaticky závažnejšie ochorenie</h2>

<p>Podiel návštev ukončených hospitalizáciou vzrástol z 8,85 % na 12,65 %. Častejšie sa zaznamenávalo aj zavedenie ureterálneho stentu. Vývoj môže súvisieť so zmenou závažnosti prípadov, pridruženými ochoreniami, dostupnosťou ambulantnej starostlivosti alebo prahom pre prijatie. Štúdia neumožňuje určiť, ktorá príčina prevažovala. [1]</p>

<p>Databáza Epic Cosmos sa počas sledovania rozširovala. Pribúdanie pracovísk mohlo zmeniť nielen počet návštev, ale aj zastúpenie pacientov a miestne postupy. Časovo stratifikované pomery šancí oproti návštevám bez urolitiázy neboli multivariabilne upravenými odhadmi zohľadňujúcimi kompletný klinický profil. Z výsledkov preto nemožno uzavrieť, že rast CT spôsobil rast hospitalizácií alebo že častejšie prijímanie zlepšilo prognózu.</p>

<h2>Analgézia: menej opioidov, nejasný menovateľ pri prepustení</h2>

<p>Podanie opioidov počas návštevy kleslo zo 61,5 % na 49,7 %. Ketorolak bol zaznamenaný pri 61,6 % návštev za celé obdobie. Údaje opisujú predpisové zvyklosti v USA; nepreukazujú vhodnosť konkrétneho lieku pre každého pacienta ani účinnosť určitého programu na obmedzenie opioidov. [1]</p>

<p>Pri liekoch zaznamenaných pri prepustení je v prílohe 6 nesúlad. Tabuľka uvádza počet prepustených návštev, ale publikované percentá zodpovedajú celkovému počtu návštev s urolitiázou. V roku 2016 napríklad 13 429 opioidových predpisov predstavuje 8,8 % zo všetkých 152 597 návštev, nie z 139 091 prepustených návštev. Bez vysvetlenia autorov preto nie je presné tvrdiť, že „8,8 % prepustených pacientov dostalo opioid“, ani vytvárať vlastné opravené odhady.</p>

<h2>Odporúčania nie sú jednotným príkazom „ultrasonografia ako prvá“</h2>

<p>Európska urologická asociácia odporúča pri urolitiáze ultrasonografiu ako primárny zobrazovací nástroj a následné natívne CT na potvrdenie diagnózy pri akútnej bolesti v boku. Okamžité zobrazenie odporúča pri horúčke, solitárnej obličke alebo neistote diagnózy. Uvádza tiež, že obštrukcia s infekciou močových ciest alebo anúriou je urologickou urgentnou situáciou vyžadujúcou bezodkladnú dekompresiu. [2]</p>

<p>Americké kritériá ACR naopak považujú natívne CT za zvyčajne vhodné úvodné vyšetrenie dospelého s akútnou bolesťou v boku a podozrením na kameň bez predchádzajúcej anamnézy urolitiázy. V gravidite odporúčajú ako úvodnú metódu ultrasonografiu. [3] Rozdiel nemožno zúžiť na tvrdenie, že jedna odborná spoločnosť má pravdu a druhá nie: odporúčania vychádzajú z rozdielne formulovaných scenárov, váženia diagnostickej výťažnosti a radiačnej záťaže.</p>

<p>Multiodborový konsenzus urológov, urgentných lekárov a rádiológov hodnotil 29 modelových scenárov. CT odporučil v 7, ultrasonografiu v 9 a žiadne ďalšie zobrazenie v 13 scenároch; ak bolo CT potrebné, uprednostnil zníženú dávku. [4] Randomizovaná štúdia s 2 759 pacientmi navyše ukázala, že úvodná ultrasonografia znížila kumulatívnu radiačnú expozíciu bez zisteného nárastu závažných komplikácií s vysokým rizikom, návratov na urgentný príjem či hospitalizácií oproti úvodnému CT. Následné zobrazenie však bolo ponechané na klinickom rozhodnutí, takže nešlo o stratégiu „ultrasonografia a nikdy CT“. [5]</p>

<p>Rozumným cieľom preto nie je mechanicky maximalizovať jednu metódu, ale zvoliť vyšetrenie podľa klinického rizika a otázky, na ktorú má odpovedať. Pri typickej recidivujúcej kolike u stabilného pacienta môže byť primeraný iný postup než pri prvom ataku, horúčke, oligoanúrii, solitárnej obličke, zhoršení funkcie obličiek, nezvládnutej bolesti alebo nejasnej diagnóze.</p>

<h2>Čo štúdia dokázala a čo zostáva otvorené</h2>

<p>Analýza spoľahlivo opisuje výraznú prevahu zaznamenaného CT a časové zmeny v rámci skúmanej databázy. Jej veľkosť umožňuje presne opísať frekvencie, nenahrádza však podrobné klinické údaje.</p>

<ul>
  <li><strong>Neoverovala primeranosť:</strong> nepoznáme individuálnu indikáciu ani to, či výsledok zmenil manažment.</li>
  <li><strong>Neúplne charakterizovala zobrazovanie:</strong> chýbajú dávky, presné protokoly, poradie vyšetrení a validácia zachytenia POCUS.</li>
  <li><strong>Výber závisel od kódu diagnózy:</strong> môže zvýhodňovať prípady potvrdené zobrazovaním.</li>
  <li><strong>Zloženie databázy sa menilo:</strong> počas deviatich rokov pribúdali pracoviská aj záznamy.</li>
  <li><strong>Observačný dizajn nepreukazuje príčinnosť:</strong> trendy v CT, hospitalizáciách, opioidoch a výkonoch nemožno navzájom označiť za príčinu a následok.</li>
</ul>

<p>Autori neuviedli žiadne známe finančné ani osobné konflikty záujmov. Na metodických hraniciach analýzy to nič nemení. [1]</p>

<h2>Klinické posolstvo</h2>

<p>Americké údaje nepreukazujú, že takmer rutinné CT je optimálne, ani že ho možno bezpečne nahradiť ultrasonografiou u každého pacienta. Ukazujú veľký odstup medzi frekvenciou oboch zaznamenaných metód a potrebu hodnotiť zobrazovanie presnejšie než samotným počtom vyšetrení.</p>

<p>Audit pracoviska by mal sledovať klinickú indikáciu, použitý protokol a dávku, opakované expozície aj to, či nález zmenil rozhodnutie. Najpraktickejším záverom nie je „menej CT za každú cenu“, ale <strong>správne zobrazenie pre správneho pacienta v správnom čase</strong>.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Grace V. Riley, Kevin G. Buell, Eric Moyer, Kyle Bernard, Evan J. Panken, Richard J. Fantus, Michael Gottlieb. Epidemiology of Nephrolithiasis Among United States Emergency Departments Over a Nine-Year Period. <em>The Journal of Emergency Medicine.</em> Publikované online 23. septembra 2026. DOI: <a href="https://doi.org/10.1016/j.jemermed.2026.09.009" target="_blank" rel="noopener noreferrer">10.1016/j.jemermed.2026.09.009</a>. <a href="https://www.jem-journal.com/article/S0736-4679%2826%2900271-4/fulltext" target="_blank" rel="noopener noreferrer">Plný text a prílohy</a>. Záznam v PubMed nebol k 8. októbru 2026 dohľadaný.</em></small></p>
<p><small><em>[2] Andreas Skolarikos, Robert Geraghty, Bhaskar Somani, Thomas Tailly, Helene Jung, Andreas Neisius, Ales Petřík, Guido M. Kamphuis, Niall Davis, Carla Bezuidenhout, Michael Lardas, Giovanni Gambaro, John A. Sayer, Riccardo Lombardo, Lazaros Tzelves. European Association of Urology Guidelines on Urolithiasis: A Summary of the 2025 Recommendations for Medical Management and Follow-up of Urinary Stones. <em>European Urology.</em> 2025;88(1):64–75. DOI: <a href="https://doi.org/10.1016/j.eururo.2025.03.011" target="_blank" rel="noopener noreferrer">10.1016/j.eururo.2025.03.011</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40268592/" target="_blank" rel="noopener noreferrer">PubMed PMID 40268592</a>. <a href="https://uroweb.org/guidelines/urolithiasis/chapter/guidelines" target="_blank" rel="noopener noreferrer">Aktuálne odporúčania EAU</a>.</em></small></p>
<p><small><em>[3] Expert Panel on Urological Imaging, Rajan T. Gupta, Kevin Kalisz, Gaurav Khatri, Melanie P. Caserta, Tara M. Catanzano, Silvia D. Chang, Alberto Diaz De Leon, John L. Gore, Refky Nicola, Anand M. Prabhakar, Stephen J. Savage, Kevin P. Shah, Venkateswar R. Surabhi, Myles T. Taffel, Jonathan H. Valente, Don C. Yoo, Paul Nikolaidis. ACR Appropriateness Criteria® Acute Onset Flank Pain-Suspicion of Stone Disease (Urolithiasis): 2023 Update. <em>Journal of the American College of Radiology.</em> 2024;21(5S):S229–S244. DOI: <a href="https://doi.org/10.1016/j.jacr.2023.08.020" target="_blank" rel="noopener noreferrer">10.1016/j.jacr.2023.08.020</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38040458/" target="_blank" rel="noopener noreferrer">PubMed PMID 38040458</a>.</em></small></p>
<p><small><em>[4] Christopher L. Moore, Christopher R. Carpenter, Marta L. Heilbrun, Kevin Klauer, Amy C. Krambeck, Courtney Moreno, Erick M. Remer, Charles Scales, Melissa M. Shaw, Kevan M. Sternberg. Imaging in Suspected Renal Colic: Systematic Review of the Literature and Multispecialty Consensus. <em>The Journal of Urology.</em> 2019;202(3):475–483. DOI: <a href="https://doi.org/10.1097/JU.0000000000000342" target="_blank" rel="noopener noreferrer">10.1097/JU.0000000000000342</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31412438/" target="_blank" rel="noopener noreferrer">PubMed PMID 31412438</a>.</em></small></p>
<p><small><em>[5] Rebecca Smith-Bindman, Chandra Aubin, John Bailitz, Rimon N. Bengiamin, Carlos A. Camargo Jr, Jill Corbo, Anthony J. Dean, Ruth B. Goldstein, Richard T. Griffey, Gregory D. Jay, Tarina L. Kang, Dana R. Kriesel, O. John Ma, Michael Mallin, William Manson, Joy Melnikow, Diana L. Miglioretti, Sara K. Miller, Lisa D. Mills, James R. Miner, Michelle Moghadassi, Vicki E. Noble, Gregory M. Press, Marshall L. Stoller, Victoria E. Valencia, Jessica Wang, Ralph C. Wang, Steven R. Cummings. Ultrasonography versus Computed Tomography for Suspected Nephrolithiasis. <em>The New England Journal of Medicine.</em> 2014;371(12):1100–1110. DOI: <a href="https://doi.org/10.1056/NEJMoa1404446" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1404446</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25229916/" target="_blank" rel="noopener noreferrer">PubMed PMID 25229916</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_urolitiaza-urgentny-prijem-ct-ultrasonografia_article',
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
