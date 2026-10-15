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
    'title' => 'Hojenie sliznice pri zápalových ochoreniach čriev nestačí – a čo z toho vyplýva pre nefrológiu',
    'slug' => 'ibd-hojenie-sliznice-renalne-prejavy',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Endoskopická remisia pri IBD nezaručuje návrat kvality života a nechráni pred renálnymi prejavmi. Prehľad konceptu liečiteľných vlastností a praktických dôsledkov pre nefrologickú ambulanciu.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/ibd-hojenie-sliznice-renalne-prejavy.webp" type="image/webp">
    <img src="img/ibd-hojenie-sliznice-renalne-prejavy.png" alt="Poloschematická črevná kľučka prechádza zo zapáleného červeného úseku do zahojeného modrozeleného, nad ktorým pretrvávajú rozptýlené častice; v pozadí obrys obličky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta. Zahojená sliznica nemusí znamenať, že ťažkosti aj renálne riziko zmizli.</figcaption>
</figure>

<p>Liečba zápalových ochorení čriev sa za posledné dve desaťročia posunula od riadenia podľa príznakov k stratégii „treat-to-target“, v ktorej je cieľom endoskopické a čoraz častejšie aj histologické zahojenie sliznice. Posun bol opodstatnený: príznaky korelujú s aktivitou zápalu len čiastočne a poškodenie môže postupovať aj vtedy, keď sa pacient cíti lepšie.</p>

<p>Prax však ukázala hranicu tohto prístupu. Časť pacientov s dosiahnutou endoskopickou remisiou a normálnym fekálnym kalprotektínom naďalej trpí únavou, bolesťou brucha, poruchami spánku a úzkosťou. Tento nesúlad medzi zahojením tkaniva a stavom pacienta sa označuje ako <strong>medzera v remisii</strong> (remission gap). Pre nefrológa je téma relevantná z dvoch strán: renálne prejavy IBD súvisia s aktivitou ochorenia, a zároveň sa môžu skrývať za príznakmi, ktoré celý tím pripisuje čreva.</p>

<h2>Prečo samotné hojenie sliznice nestačí</h2>

<p>Koncept liečiteľných vlastností (treatable traits) pôvodne vznikol v roku 2016 pre chronické respiračné ochorenia. Prvé systematické prenesenie tohto modelu na IBD publikoval v júli 2026 v časopise <em>eClinicalMedicine</em> tím z Hospital das Clínicas Lekárskej fakulty Univerzity v São Paule a z University of Manitoba IBD Clinical and Research Centre.</p>

<p>Model rozdeľuje modifikovateľné mechanizmy, ktoré môžu pretrvávať aj po utíšení črevného zápalu, do troch domén:</p>

<div class="table-responsive" role="region" aria-label="Tri domény liečiteľných vlastností pri zápalových ochoreniach čriev" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Doména</th><th scope="col">Čo zahŕňa</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Gastrointestinálna a vnútorná</th><td>Reziduálny zápal, fibrostenotické komplikácie, poruchy motility, malabsorpcia</td></tr>
    <tr><th scope="row">Extraintestinálna a komorbidná</th><td>Mimočrevné prejavy, systémové komplikácie vrátane renálnych, pridružené ochorenia</td></tr>
    <tr><th scope="row">Psychologická a behaviorálna</th><td>Depresívne a úzkostné príznaky, poruchy spánku, strach z jedenia, psychosociálne faktory</td></tr>
  </tbody>
</table>
</div>

<p>Autori výslovne uvádzajú, že ide o <strong>koncepčný rámec, nie o primárne údaje</strong>, a že na jeho overenie sú potrebné prospektívne štúdie. Model stavia na posune, ktorý priniesla iniciatíva STRIDE-II: terapeutické ciele sa rozšírili smerom k hlbokej a trvalej remisii vrátane ukazovateľov kvality života, ako je dotazník IBDQ.</p>

<p>Podľa odborného spravodajstva k tejto práci pretrvávajú funkčné príznaky približne u <strong>tretiny pacientov v endoskopickej remisii</strong>. Vysvetlenia sa prekrývajú: reziduálny zápal, neurozápal a poruchy interakcie čreva a mozgu v zmysle terminológie Rome V. Opisovaná je aj senzitizácia črevných nociceptívnych aferentných vlákien s aktiváciou mastocytov a zvýšenou expresiou receptorov TRPV1 a TRPA1 v sliznici, pri ktorej bolesť vyvolávajú fyziologické podnety, napríklad distenzia alebo samotné jedenie.</p>

<h3>Chybná interpretácia, ktorej sa treba vyhnúť</h3>

<p>Ak pacient dosiahne zahojenie sliznice, ale ťažkosti pretrvávajú, nejde automaticky o zlyhanie liečby a dôvod na prechod na ďalšiu biologickú líniu. Pred eskaláciou treba overiť mechanizmus: štrukturálnu komplikáciu, spomalené vyprázdňovanie žalúdka po predchádzajúcom poškodení, viscerálnu a neuropatickú hypersenzitivitu alebo prekrytie s inou diagnózou. Predčasná zmena liečby vyčerpá terapeutické možnosti bez toho, aby riešila skutočnú príčinu.</p>

<h2>Čo o cieľoch liečby hovoria dôkazy</h2>

<p>Endoskopia zostáva referenčným štandardom hodnotenia zahojenia sliznice a častejšie endoskopické kontroly sa spájajú s vyššou pravdepodobnosťou dosiahnutia tohto cieľa. Slizničná biopsia umožňuje zachytiť pretrvávajúcu histologickú aktivitu, ale inkrementálny klinický prínos dosiahnutia histologického zahojenia zatiaľ nie je stanovený. Magnetická rezonančná enterografia má vysokú citlivosť pre hojenie ulcerácií v endoskopicky neprístupných úsekoch, prítomnosť slizničných lézií však na jej základe nemožno spoľahlivo vylúčiť.</p>

<p>Systematický prehľad o stratégii „treat-to-target“ pripomína dôležitý metodický fakt: <strong>chýbajú prospektívne získané dôkazy, ktoré by zahojenie sliznice validovali ako liečebný cieľ.</strong> Dostupné údaje naznačujú, že cielenie na zápal namiesto na príznaky môže byť v niektorých podmienkach nákladovo efektívne. Randomizovaná štúdia CALM ukázala, že tesná kontrola – teda rozhodovanie o liečbe podľa pravidelného sledovania zápalových biomarkerov – zlepšuje endoskopické aj klinické výsledky.</p>

<h2>Renálne prejavy IBD: čísla a ich správne čítanie</h2>

<p>Zápalové ochorenia čriev sú systémové. Mimočrevné prejavy postihujú najčastejšie kĺby, kožu a oči, zriedkavejšie pečeň, pľúca alebo pankreas, a významne znižujú kvalitu života. Niektoré z nich – periférna artritída, aftózne ulcerácie, episkleritída, erythema nodosum – sú viazané na aktivitu črevného zápalu a ustupujú po jeho zvládnutí. Iné, napríklad uveitída alebo ankylozujúca spondylitída, prebiehajú nezávisle.</p>

<p>Najcitovanejším zdrojom o renálnom postihnutí v biologickej ére je retrospektívna kohorta z Istanbulu, ktorá počas 16 rokov sledovala 1 874 dospelých pacientov s IBD (1 055 s ulceróznou kolitídou, 819 s Crohnovou chorobou).</p>

<div class="table-responsive" role="region" aria-label="Výskyt renálnych prejavov podľa typu zápalového ochorenia čriev" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Skupina</th><th scope="col">Počet pacientov</th><th scope="col">Renálne prejavy</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Celá kohorta</th><td>1 874</td><td>105 (5,6 %)</td></tr>
    <tr><th scope="row">Crohnova choroba</th><td>819</td><td>55 (6,7 %)</td></tr>
    <tr><th scope="row">Ulcerózna kolitída</th><td>1 055</td><td>50 (4,7 %)</td></tr>
  </tbody>
</table>
</div>

<p>Najčastejším renálnym prejavom bola v oboch skupinách <strong>nefrolitiáza</strong>. Zásadný detail, ktorý sa pri citovaní tejto práce často stráca: súvislosť renálnych prejavov s aktivitou ochorenia a s anamnézou chirurgickej resekcie sa potvrdila <strong>len u Crohnovej choroby</strong>. U ulceróznej kolitídy sa takýto vzťah nenašiel. Tvrdenie, že renálne prejavy sú pri IBD všeobecne viazané na aktivitu zápalu, teda zjednodušuje.</p>

<p>Mechanizmy nefrolitiázy pri Crohnovej chorobe sú pritom dobre vysvetliteľné: malabsorpcia tukov pri postihnutí alebo resekcii terminálneho ilea vedie k viazaniu vápnika na mastné kyseliny, k zvýšenému vstrebávaniu voľného oxalátu v hrubom čreve a k enterickej hyperoxalúrii. Pridružuje sa dehydratácia pri hnačkách, nízky objem moču a strata bikarbonátu s nízkym pH moču, čo podporuje tvorbu urátových konkrementov.</p>

<h2>Lieková nefrotoxicita: 5-aminosalicyláty</h2>

<p>Pri každom zhoršení funkcie obličiek u pacienta s IBD treba zvážiť časovú väzbu na liečbu. Systematický prehľad o 5-aminosalicylátoch zistil, že v štúdiách s pravidelným meraním sérového kreatinínu alebo kreatinínovej clearance je nefrotoxicita <strong>výnimočná – priemerne 0,26 % na pacientorok</strong>. Z kazuistík vyplýva, že najčastejšou formou je intersticiálna nefritída s nešpecifickými príznakmi, ktorá sa preto môže mesiace prehliadať. Postihnutie sa objavuje najčastejšie v prvých 12 mesiacoch liečby, ale popísané sú aj prejavy po viacerých rokoch. Neprítomnosť jasného vzťahu k dávke svedčí skôr pre idiosynkratický než dávkovo závislý mechanizmus; nefrotoxický potenciál mesalazínu a sulfasalazínu sa zdá byť podobný.</p>

<p>Praktický dôsledok: pri vzniku renálnej insuficiencie u pacienta liečeného mesalazínom treba liek vysadiť. Ak sérový kreatinín neklesne, je namieste zvážiť biopsiu obličky.</p>

<h2>Praktický rámec pre nefrologickú ambulanciu</h2>

<ol>
  <li><strong>Zistiť fenotyp a aktivitu IBD.</strong> Pri Crohnovej chorobe, najmä po resekcii ilea, je riziko nefrolitiázy vyššie a viaže sa na aktivitu ochorenia.</li>
  <li><strong>Rozlíšiť typ renálneho problému.</strong> Kolikovitá bolesť s hematúriou smeruje k urolitiáze; proteinúria s hematúriou ku glomerulárnej patológii; nenápadný vzostup kreatinínu s časovou väzbou na liečbu k tubulointersticiálnej nefritíde; dlhotrvajúca nekontrolovaná zápalová aktivita s nefrotickou proteinúriou k sekundárnej amyloidóze AA.</li>
  <li><strong>Overiť liekovú anamnézu v čase.</strong> Začiatok liečby, zmena dávky, presný časový vzťah ku zhoršeniu funkcie obličiek.</li>
  <li><strong>Nezamieňať stabilné laboratórne hodnoty za neprítomnosť procesu.</strong> Logika medzery v remisii platí aj v nefrológii: normálny kreatinín nevylučuje prebiehajúce poškodenie.</li>
  <li><strong>Pri pretrvávajúcich ťažkostiach hľadať mechanizmus, nie automaticky eskalovať.</strong> To platí pre gastroenterologickú aj nefrologickú časť liečby.</li>
  <li><strong>Koordinovať sa s gastroenterológom.</strong> Rozhodnutie o imunosupresii, o vysadení aminosalicylátu aj o načasovaní biopsie má spoločné dôsledky.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Model liečiteľných vlastností nie je overený v praxi.</strong> Autori ho explicitne označujú za koncepčný rámec bez primárnych údajov; prospektívna validácia chýba.</li>
  <li><strong>Zahojenie sliznice nie je prospektívne validovaný cieľ.</strong> Napriek svojej rozšírenosti stojí na pozorovacích dátach a post hoc analýzach.</li>
  <li><strong>Kohorta renálnych prejavov je retrospektívna a jednocentrová.</strong> Výskyt 5,6 % platí pre terciárne pracovisko v Istanbule a nemusí byť prenositeľný; súvislosť s aktivitou ochorenia sa preukázala iba pri Crohnovej chorobe.</li>
  <li><strong>Prehľad o aminosalicylátoch je z roku 2007.</strong> Novšie liečebné schémy a biologická liečba v ňom nie sú zachytené.</li>
  <li><strong>Renálne prejavy nie sú hlavnou témou zdrojového rámca.</strong> Prepojenie medzery v remisii s nefrologickou praxou je interpretácia, nie publikovaný záver.</li>
</ul>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani súhrn charakteristických vlastností lieku.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Graciolli Facanali CB, Carvalho CRF, Facanali MR Jr, Sobrado CW Jr, Bernstein CN. Treatable traits in inflammatory bowel disease: a conceptual framework for personalized care. <em>eClinicalMedicine.</em> 2026;97:104058. DOI: <a href="https://doi.org/10.1016/j.eclinm.2026.104058" target="_blank" rel="noopener noreferrer">10.1016/j.eclinm.2026.104058</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42473537/" target="_blank" rel="noopener noreferrer">PubMed PMID 42473537</a>.</small></li>
  <li><small>Dulai PS, Levesque BG, Feagan BG, D'Haens G, Sandborn WJ. Assessment of mucosal healing in inflammatory bowel disease: review. <em>Gastrointest Endosc.</em> 2015;82(2):246–255. DOI: <a href="https://doi.org/10.1016/j.gie.2015.03.1974" target="_blank" rel="noopener noreferrer">10.1016/j.gie.2015.03.1974</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/26005012/" target="_blank" rel="noopener noreferrer">PubMed PMID 26005012</a>.</small></li>
  <li><small>Colombel JF, D'haens G, Lee WJ, Petersson J, Panaccione R. Outcomes and Strategies to Support a Treat-to-target Approach in Inflammatory Bowel Disease: A Systematic Review. <em>J Crohns Colitis.</em> 2020;14(2):254–266. DOI: <a href="https://doi.org/10.1093/ecco-jcc/jjz131" target="_blank" rel="noopener noreferrer">10.1093/ecco-jcc/jjz131</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31403666/" target="_blank" rel="noopener noreferrer">PubMed PMID 31403666</a>.</small></li>
  <li><small>Dincer MT, Dincer ZT, Bakkaloglu OK, Yalin SF, Trabulus S, Celik AF, Seyahi N, Altiparmak MR. Renal Manifestations in Inflammatory Bowel Disease: A Cohort Study During the Biologic Era. <em>Med Sci Monit.</em> 2022;28:e936497. DOI: <a href="https://doi.org/10.12659/MSM.936497" target="_blank" rel="noopener noreferrer">10.12659/MSM.936497</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/35791280/" target="_blank" rel="noopener noreferrer">PubMed PMID 35791280</a>.</small></li>
  <li><small>Vavricka SR, Schoepfer A, Scharl M, Lakatos PL, Navarini A, Rogler G. Extraintestinal Manifestations of Inflammatory Bowel Disease. <em>Inflamm Bowel Dis.</em> 2015;21(8):1982–1992. DOI: <a href="https://doi.org/10.1097/MIB.0000000000000392" target="_blank" rel="noopener noreferrer">10.1097/MIB.0000000000000392</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/26154136/" target="_blank" rel="noopener noreferrer">PubMed PMID 26154136</a>.</small></li>
  <li><small>Gisbert JP, González-Lama Y, Maté J. 5-Aminosalicylates and renal function in inflammatory bowel disease: a systematic review. <em>Inflamm Bowel Dis.</em> 2007;13(5):629–638. DOI: <a href="https://doi.org/10.1002/ibd.20099" target="_blank" rel="noopener noreferrer">10.1002/ibd.20099</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/17243140/" target="_blank" rel="noopener noreferrer">PubMed PMID 17243140</a>.</small></li>
  <li><small>Barros D. Inflammatory Bowel Disease: Is Mucosal Healing Enough? <em>Medscape Medical News</em>, 9. októbra 2026. <a href="https://www.medscape.com/viewarticle/inflammatory-bowel-disease-mucosal-healing-enough-2026a10011vi" target="_blank" rel="noopener noreferrer">dostupné online</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Všetky bibliografické údaje boli overené cez PubMed eutils, Crossref a prevodník PMCID. V predlohe boli opravené tri vecné nepresnosti: koncepčný rámec liečiteľných vlastností nebol vôbec citovaný ako primárny zdroj (doplnené, vrátane upozornenia autorov, že nejde o primárne údaje); tvrdenie o väzbe renálnych prejavov na aktivitu IBD bolo zovšeobecnené, hoci sa preukázalo len pri Crohnovej chorobe; a tvrdenie o tubulointersticiálnom poškodení pri aminosalicylátoch bolo bez číselného podkladu. Autor projektu doplnil mechanizmus enterickej hyperoxalúrie, údaje zo štúdie CALM a iniciatívy STRIDE-II, rozbor limitov a praktický ambulantný rámec.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=crevne-helmintozy-nefrologia-strongyloidoza-imunosupresia">Črevné helmintózy v nefrológii: strongyloidóza a imunosupresia</a></li>
  <li><a href="article.php?slug=claudiny-nefrolitiaza-geneticke-asociacie">Klaudíny a nefrolitiáza: genetické asociácie</a></li>
  <li><a href="article.php?slug=zapalove-markery-crp-esr-pv">Zápalové markery: CRP, sedimentácia a viskozita plazmy</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ibd-hojenie-sliznice-renalne-prejavy_article',
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
