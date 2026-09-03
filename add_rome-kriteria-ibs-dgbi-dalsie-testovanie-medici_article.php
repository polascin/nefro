<?php

/**
 * add_rome-kriteria-ibs-dgbi-dalsie-testovanie-medici_article.php
 * Odborný článok: kritériá Rome pri DGBI / IBS a diagnostická zdržanlivosť.
 * Spracovaný zdroj: Linares M, Grimaldi C, Palma N, et al.
 * Neurogastroenterol Motil. 2026;38(5):e70335 (PMID 42087489).
 *
 * Pôvodní autori spracovanej práce sú uvedení v source_authors.php.
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
    'title'        => 'Kritériá Rome pri poruchách interakcie črevo–mozog (DGBI) a kedy „ďalej testovať“ pri IBS: poučenie zo štúdie na medikoch',
    'slug'         => 'rome-kriteria-ibs-dgbi-dalsie-testovanie-medici',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'U 238 medikov v Latinskej Amerike znalosť kritérií Rome nestačila na diagnostickú zdržanlivosť pri IBS bez varovných príznakov. Pozitívna diagnóza DGBI nie je diagnóza vylúčením.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Kritériá Rome umožňujú stanoviť syndróm dráždivého čreva ako pozitívnu, symptómovú diagnózu, ak chýbajú varovné príznaky. Multicentrická štúdia na medikoch v Latinskej Amerike ukázala, že samotná znalosť týchto kritérií nestačí na racionálne testovanie. Pre nefrológiu je to poučné tam, kde sú gastrointestinálne ťažkosti časté a nešpecifické.</em></p>

<p>Funkčné gastrointestinálne ťažkosti – najmä syndróm dráždivého čreva (IBS) – sa v praxi ešte stále často uzatvárajú až po „vylúčení všetkého ostatného“. Takýto postup predlžuje cestu k liečbe, zvyšuje úzkosť pacienta a zbytočne zaťažuje diagnostiku. Kritériá Rome tento model zámerne otáčajú: pri typickom obraze a absencii varovných príznakov má ísť o <strong>pozitívnu klinickú diagnózu</strong>, nie o diagnózu vylúčením.</p>

<p>To neznamená, že kritériá Rome „zakazujú“ vyšetrenia. Umožňujú stanoviť diagnózu na základe symptómov a cieliť ďalšie testovanie podľa varovných príznakov a fenotypu. Rozdiel je v tom, či laboratórium, zobrazovanie a endoskopia slúžia ako <em>cielený krok</em>, alebo ako <em>rituál vylučovania</em> – teda preto, lebo diagnóza bez nich „neplatí“.</p>

<p>V nefrologicky ladenej praxi je toto rozlíšenie užitočné skromne, ale prakticky. Pacienti s chronickou chorobou obličiek (CKD) a multimorbiditou majú časté nešpecifické gastrointestinálne ťažkosti. Riziko diagnostickej eskalácie bez jasných alarmov je v bežnej praxi vysoké – a rovnako nebezpečné je bagatelizovať skutočný varovný príznak, napríklad anémiu z nedostatku železa, ako „iba CKD“.</p>

<h2>Čo sú DGBI a čo znamenajú kritériá Rome</h2>

<p><strong>Poruchy interakcie črevo–mozog</strong> (DGBI, z angl. <em>disorders of gut–brain interaction</em>) sú chronické alebo recidivujúce gastrointestinálne ťažkosti, pri ktorých ide o ľubovoľnú kombináciu poruchy motility, viscerálnej hypersenzitivity, zmien slizničnej a imunitnej funkcie, mikrobioty a/alebo spracovania signálov v centrálnom nervovom systéme. Medzi najznámejšie DGBI patria IBS, funkčná dyspepsia a chronická zápcha. Starší pojem „funkčné gastrointestinálne poruchy“ v aktuálnom rámci Rome Foundation ustupuje označeniu DGBI.</p>

<p>Kritériá Rome sú medzinárodný konsenzus <a href="https://theromefoundation.org/" target="_blank" rel="noopener noreferrer">Rome Foundation</a>. Štúdia, o ktorú sa tento článok opiera, používala vinety podľa <strong>Rome IV</strong> (2016). Rámec <strong>Rome V</strong> (2026) pripravilo podľa nadácie viac než 140 odborníkov z 27 krajín; pri IBS vracia do kritérií aj diskomfort popri bolesti a znižuje prah frekvencie na tri dni v mesiaci namiesto týždenného pravidla Rome IV. Tento údaj o počte expertov patrí k Rome V, nie k starším edíciám.</p>

<p>Rome IV pri IBS vyžaduje rekurentnú bolesť brucha v priemere aspoň jeden deň v týždni za posledné tri mesiace, spojenú s dvoma alebo viacerými z týchto znakov: súvis s defekáciou, zmena frekvencie stolice, zmena formy stolice. Príznaky majú trvať aspoň šesť mesiacov pred diagnózou. Rome V oddeľuje aj <em>klinické</em> a <em>výskumné</em> kritériá: v praxi má ísť o použiteľný úsudok, vo výskume o prísnejšiu reprodukovateľnosť.</p>

<p>Cieľom je posun od čisto „diagnosis of exclusion“ k pozitívnej diagnóze. Randomizovaná štúdia Begtrupovej a spolupracovníkov už v roku 2013 ukázala, že pozitívna diagnostická stratégia pri IBS nie je horšia ako stratégia vylučovania. To však nie je dôkaz, že žiadne cielené testy netreba – ide o to, nebudovať diagnózu na nekonečnom došetrení.</p>

<h2>Štúdia na medikoch: znalosť nestačí na zdržanlivosť</h2>

<p>Linares a spolupracovníci v <em>Neurogastroenterology &amp; Motility</em> (máj 2026) uverejnili multicentrickú prierezovú štúdiu <em>Knowledge Does Not Translate Into Diagnostic Restraint</em>. Zúčastnilo sa jej <strong>238 medikov v klinických ročníkoch</strong> (po aspoň jednom roku stáží) zo <strong>45 univerzít v 14 krajinách Latinskej Ameriky</strong>. Priemerný vek bol 24,3 roka (SD 4,1), ženy tvorili 63,4 %. Išlo o dobrovoľný anonymný výber, nie o náhodný vzoriek; zber prebiehal od januára do marca 2026, teda ešte pred zverejnením Rome V.</p>

<p>Nástroj mal päť oblastí: demografické údaje, výučbu DGBI, teoretické znalosti kritérií Rome, zaradenie varovných príznakov a klinické uvažovanie na postupných vinietách. Dospelá vineta opisovala <strong>28-ročnú ženu spĺňajúcu Rome IV pre IBS bez varovných príznakov</strong>. Potom sa tá istá kazuistika predložila v troch etapách: úvod; vyššia intenzita bolesti bez nových alarmov; kontrola po dvoch týždňoch s normálnymi laboratórnymi výsledkami. Nakoniec sa rovnaký obraz preložil do 7-ročného dieťaťa.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Hlavné výsledky štúdie o diagnostickej zdržanlivosti pri IBS u medikov" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Výsledok</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Špecifická výučba DGBI</th>
        <td>74 % (176/238)</td>
      </tr>
      <tr>
        <th scope="row">Počuli o kritériách Rome</th>
        <td>69 % (165/238)</td>
      </tr>
      <tr>
        <th scope="row">IBS správne definovali ako pozitívnu diagnózu, nie ako diagnózu vylúčením</th>
        <td>46 %</td>
      </tr>
      <tr>
        <th scope="row">Dospelú vinetu hodnotili ako pravdepodobne funkčnú</th>
        <td>76 %</td>
      </tr>
      <tr>
        <th scope="row">Aj tak objednali úvodné diagnostické testy</th>
        <td>70 %</td>
      </tr>
      <tr>
        <th scope="row">Eskalácia testov pri silnejšej bolesti bez nových alarmov</th>
        <td>61 %</td>
      </tr>
      <tr>
        <th scope="row">Ďalšie testy aj po normálnych laboratórnych výsledkoch</th>
        <td>53 %</td>
      </tr>
      <tr>
        <th scope="row">Úvodné testy pri vysokých oproti nižším teoretickým znalostiam</th>
        <td>68 % oproti 83 % (p = 0,010)</td>
      </tr>
      <tr>
        <th scope="row">Vysoký zložený klinický výkon</th>
        <td>15 %</td>
      </tr>
      <tr>
        <th scope="row">Vysoké znalosti, ale slabé klinické uvažovanie</th>
        <td>21 %</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Najčastejšie požadované vyšetrenia zahŕňali krvný obraz, zápalové markery, celiakálnu sérológiu, fekálny kalprotektín, železo, ultrasonografiu brucha, CT aj kolonoskopiu. Po normálnych laboratórnych výsledkoch ostávali v hre najmä kolonoskopia a CT. „Vysoké diagnostické nadužívanie“ (testovanie v aspoň dvoch etapách vinety) malo 66 % účastníkov.</p>

<p>Pri pediatrickej vinete bez varovných príznakov označilo 46 % medikov obraz za nepravdepodobne funkčný. Testovanie ostalo vysoké. To len posilňuje záver autorov: vylučovací reflex sa formuje už v pregraduálnej príprave, nielen v praxi špecialistov.</p>

<p>Obmedzenia sú zrejmé a treba ich povedať nahlas. Išlo o vinety, nie o pozorované ambulancie; o jeden IBS obraz, nie o celé spektrum DGBI; o dobrovoľný výber v latinskoamerických školách. Prenos do slovenského pregraduálneho vzdelávania preto nie je automatický – vzorec „viem kritériá, ale aj tak testujem“ je však dostatočne všeobecný na to, aby stál za pozornosť.</p>

<h2>Varovné príznaky: čo študenti mýlili</h2>

<p>V nástroji štúdie boli varovné príznaky zvolené vopred podľa Rome IV a súčasných odporúčaní pre IBS: <strong>gastrointestinálne krvácanie, neúmyselný úbytok hmotnosti, porucha rastu, recidivujúca horúčka, nočná hnačka a rodinná anamnéza zápalových chorôb čreva (IBD)</strong>. Ako nealarmové boli zadané typické funkčné znaky, napríklad bolesť brucha s úľavou po stolici, a normálne laboratórium pri inak Rome-konzistentnom obraze.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Zaradenie varovných a nevarovných príznakov medikmi v štúdii" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Príznak</th>
        <th scope="col">V nástroji štúdie</th>
        <th scope="col">Zaradenie medikmi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Neúmyselný úbytok hmotnosti</th>
        <td>varovný</td>
        <td>správne 90 %</td>
      </tr>
      <tr>
        <th scope="row">Viditeľné rektálne krvácanie</th>
        <td>varovný</td>
        <td>správne 85 %</td>
      </tr>
      <tr>
        <th scope="row">Porucha rastu</th>
        <td>varovný</td>
        <td>správne 76 %</td>
      </tr>
      <tr>
        <th scope="row">Rodinná anamnéza IBD</th>
        <td>varovný</td>
        <td>správne 70 %</td>
      </tr>
      <tr>
        <th scope="row">Recidivujúca horúčka</th>
        <td>varovný</td>
        <td>správne 69 %</td>
      </tr>
      <tr>
        <th scope="row">Nočná hnačka</th>
        <td>varovný</td>
        <td>správne len 45 %</td>
      </tr>
      <tr>
        <th scope="row">Bolesť brucha s úľavou po stolici</th>
        <td>nie je varovný</td>
        <td>30 % ho nesprávne označilo za alarm</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Približne tretina respondentov nesprávne zaradila aspoň jeden definičný funkčný príznak ako varovný. To je klinicky dôležité: ak sa typický znak IBS prečíta ako alarm, spustí sa vylučovacia kaskáda aj tam, kde Rome IV žiada pozitívnu diagnózu. V bežných odporúčaniach sa k štúdiovému zoznamu zvyčajne pridávajú aj <strong>anémiu, neskorší vek vzniku ťažkostí a rodinnú anamnézu kolorektálneho karcinómu</strong>. Tieto položky štúdia ako samostatné položky nástroja neuvádzala; v ambulancii ich však treba hľadať.</p>

<h2>Kedy má zmysel testovať ďalej</h2>

<p>Tu treba oddeliť dva plány, ktoré sa v sekundárnych textoch často zlejú. Štúdia na medikoch hodnotila <em>akékoľvek</em> objednanie testu vo vinete bez alarmov ako odklon od diagnostickej zdržanlivosti – vrátane krvného obrazu a kalprotektínu. Odporúčanie ACG z roku 2021 však pri IBS s hnačkou <strong>cieľené</strong> neinvazívne testy naopak navrhuje. Poučenie teda nie je „nerobiť nič“, ale „nerobiť z IBS diagnózu vylúčením a neeskalovať po už normálnych výsledkoch“.</p>

<p>Nasledujúci prehľad treba čítať ako orientáciu podľa ACG 2021 a verejných materiálov Rome Foundation, <strong>prispôsobenú miestnej praxi</strong>. Nie je to zoznam vyšetrení „vždy a pre každého“.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Cielené vyšetrenia pri podozrení na IBS podľa fenotypu a varovných príznakov" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Situácia</th>
        <th scope="col">Čo zvážiť</th>
        <th scope="col">Čo nie je automaticky indikované</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Typický IBS bez varovných príznakov</th>
        <td>Pozitívna klinická diagnóza; pri hnačkovom fenotype celiakálna sérológia a fekálny kalprotektín, podľa kontextu aj KO a CRP</td>
        <td>Paušálne CT, „kompletné vylúčenie“ a opakované testy bez novej indície</td>
      </tr>
      <tr>
        <th scope="row">Kalprotektín pozitívny pri hnačke</th>
        <td>Došetrenie v smere IBD, zvyčajne kolonoskopia</td>
        <td>Ignorovanie nálezu len preto, že „ide o IBS“</td>
      </tr>
      <tr>
        <th scope="row">Varovné príznaky (krvácanie, úbytok hmotnosti, nočná hnačka, horúčka, závažná rodinná anamnéza, anémia)</th>
        <td>Cielené laboratórium a endoskopia podľa nálezu</td>
        <td>Uzatvorenie IBS pred došetrením alarmu</td>
      </tr>
      <tr>
        <th scope="row">Vek skríningu kolorektálneho karcinómu bez predchádzajúceho vyšetrenia</th>
        <td>Kolonoskopia alebo iný validovaný skríning podľa aktuálnej miestnej praxe</td>
        <td>Rutinná kolonoskopia u mladších bez alarmov. ACG 2021 ju neodporúča pod 45 rokov; v slovenskom organizovanom skríningu je hranica zvyčajne 50 rokov</td>
      </tr>
      <tr>
        <th scope="row">Normálne laboratórium, žiadne nové alarmy, len silnejšie symptómy</th>
        <td>Revízia diagnózy DGBI, liečba, sledovanie</td>
        <td>Eskalácia na CT alebo kolonoskopiu „pre istotu“ – presne tento vzorec štúdia zachytila u 53 % medikov</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Inými slovami: kritériá Rome <strong>neumožňujú vyhnúť sa všetkému došetreniu</strong>. Umožňujú stanoviť pozitívnu diagnózu a testovať cielené, nie plošne. Znalosť kritérií sama o sebe racionálne testovanie negarantuje.</p>

<h2>Čo z toho plynie pre vzdelávanie – a pre nefrológiu</h2>

<p>Autori štúdie to formulujú presne: rozpor medzi princípmi Rome a aplikovaným uvažovaním vzniká už počas pregraduálnej prípravy. Teoretická znalosť súvisí s nižším úvodným testovaním, ale nadužívanie ostáva časté aj u tých, ktorí kritériá ovládajú. Didaktická hodina nestačí. Slubnejší signál dávala kazuistická výučba. Vzdelávanie by malo učiť odlíšiť varovný príznak od definičného znaku IBS, pomenovať pozitívnu diagnózu nahlas a skúšať nielen úplný diferenciál, ale aj primeranú zdržanlivosť.</p>

<p>Pre nefrológiu z toho nevyplýva, že by sme IBS diagnostikovali namiesto gastroenterológa. Vyplýva skromnejší záver. Gastrointestinálne ťažkosti pri CKD sú časté: uremická nauzea, zápcha pri obmedzení tekutín a fosfátových viazačoch, hnačka pri niektorých viazačoch, gastroparéza pri diabete, polyfarmácia. Ak obraz spĺňa DGBI a chýbajú alarmy, má zmysel neeskalovať CT a endoskopiu len preto, že pacient „už aj tak veľa chorôb má“. Ak je však prítomná anémia z nedostatku železa, krvácanie, neúmyselný úbytok hmotnosti alebo nočná hnačka, CKD tieto alarmy nevysvetľuje a došetrenie sa nedeleguje na „funkčnú“ nálepku.</p>

<div class="pdf-avoid-break">
<h2>Praktické zhrnutie</h2>

<ul>
  <li>DGBI vrátane IBS sú určené na <strong>pozitívnu, symptómovú diagnózu</strong> podľa kritérií Rome, nie na nekonečné vylučovanie.</li>
  <li>Znalosť kritérií <strong>nestačí</strong>: v štúdii testovalo úvodne 70 % medikov aj pri Rome IV–konzistentnom IBS bez alarmov a 53 % pokračovalo po normálnom laboratóriu.</li>
  <li>Varovné príznaky treba hľadať aktívne; nočná hnačka a zámena funkčného príznaku za alarm sú časté chyby.</li>
  <li>Cielené testy (najmä pri hnačkovom fenotype) ostávajú namieste; zobrazovanie a kolonoskopia bez indície nie.</li>
  <li>Pri CKD platí tá istá logika – s osobitnou pozornosťou voči anémii a krvácaniu, ktoré sa nesmú schovať za základné ochorenie obličiek.</li>
</ul>
</div>

<div class="pdf-avoid-break">
<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=neceliakalna-citlivost-psenica-gluten-fruktany">Neceliakálna citlivosť na pšenicu</a> – kedy hnačkový fenotyp nie je IBS a prečo celiakálna sérológia patrí pred elimináciu gluténu.</li>
  <li><a href="article.php?slug=occam-hickam-diagnosticke-uvazovanie-nefrologia">Occam alebo Hickam?</a> – ako tlak na rýchlu a „úspornú“ diagnózu mení klinické uvažovanie v nefrológii.</li>
  <li><a href="article.php?slug=strava-a-zdravie-creva-myty-influencerov-ckd">Strava a zdravie čreva</a> – kde končí užitočná práca s črevom a kde začína nediagnostikovaná organická choroba.</li>
</ul>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Linares M, Grimaldi C, Palma N, Vintimilla B, Candal S, Estrella D, Saps M. Knowledge Does Not Translate Into Diagnostic Restraint: Application of Rome-Based IBS Diagnosis Among Medical Students in Latin America. <em>Neurogastroenterology &amp; Motility</em>. 2026;38(5):e70335. doi: <a href="https://doi.org/10.1111/nmo.70335" target="_blank" rel="noopener noreferrer">10.1111/nmo.70335</a>. PMID 42087489, PMCID PMC13145304. <a href="https://pubmed.ncbi.nlm.nih.gov/42087489/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC13145304/" target="_blank" rel="noopener noreferrer">plný text (OA)</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam (7 mien, PubMed <code>AuthorList CompleteYN=Y</code>), veľkosť súboru, percentá a p-hodnota boli overené 3. septembra 2026 cez PubMed eutils, Crossref a otvorený plný text v Europe PMC (CC BY). Medscape správa je sekundárny žurnalistický zdroj; paywall sme neobchádzali. Autori Rome Foundation do mapy zdrojových autorov nepatria – sú citovaným rámcom, nie autormi spracovanej práce. Časť o cielenom testovaní vychádza z abstraktu ACG 2021 a verejných stránok Rome Foundation, nie zo študentskej vinety. Nefrologický most je vlastným odborným spracovaním; spracovaná štúdia obličkové ukazovatele nesledovala.</em></small></p>

<ol>
  <li><strong>Linares M, Grimaldi C, Palma N, et al.</strong> <em>Knowledge Does Not Translate Into Diagnostic Restraint: Application of Rome-Based IBS Diagnosis Among Medical Students in Latin America.</em> Neurogastroenterol Motil. 2026;38(5):e70335. <a href="https://pubmed.ncbi.nlm.nih.gov/42087489/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape.</strong> <em>Rome Criteria for IBS: When Is Further Testing Needed?</em> 2026. Sekundárne spravodajské spracovanie; individuálny autor nie je vo verejne dostupnom zobrazení spoľahlivo uvedený. <a href="https://www.medscape.com/viewarticle/rome-criteria-irritable-bowel-syndrome-when-further-testing-2026a1000sxo" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>Rome Foundation.</strong> <em>Rome V: A Global Framework for Disorders of Gut–Brain Interaction.</em> <a href="https://theromefoundation.org/rome-v-a-global-framework-for-disorders-of-gut-brain-interaction/" target="_blank" rel="noopener noreferrer">theromefoundation.org</a>.</li>
  <li><strong>Rome Foundation.</strong> <em>Rome IV Criteria.</em> <a href="https://theromefoundation.org/rome-iv/rome-iv-criteria/" target="_blank" rel="noopener noreferrer">theromefoundation.org</a>.</li>
  <li><strong>Lacy BE, Pimentel M, Brenner DM, et al.</strong> <em>ACG Clinical Guideline: Management of Irritable Bowel Syndrome.</em> Am J Gastroenterol. 2021;116(1):17–44. doi: 10.14309/ajg.0000000000001036. <a href="https://pubmed.ncbi.nlm.nih.gov/33315591/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Begtrup LM, Engsbro AL, Kjeldsen J, et al.</strong> <em>A Positive Diagnostic Strategy Is Noninferior to Exclusion Testing in Irritable Bowel Syndrome: A Randomized Controlled Trial.</em> Clin Gastroenterol Hepatol. 2013;11(8):956–962.e1. doi: 10.1016/j.cgh.2013.02.024. <a href="https://pubmed.ncbi.nlm.nih.gov/23357491/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Sperber AD, Bangdiwala SI, Drossman DA, et al.</strong> <em>Worldwide Prevalence and Burden of Disorders of Gut–Brain Interaction in Adults.</em> Gastroenterology. 2021;160(1):99–114.e3. doi: 10.1053/j.gastro.2020.04.014. <a href="https://pubmed.ncbi.nlm.nih.gov/32294476/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rome-kriteria-ibs-dgbi-dalsie-testovanie-medici_article',
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
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
