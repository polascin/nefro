<?php

/**
 * add_empagliflozin-adpkd-pilotna-studia_article.php
 * Pilotna RCT empagliflozinu pri ADPKD (Seliger et al., JASN, online 24. 10. 2026).
 *
 * enqueue_newsletter je zamerne false: aviza sa pri tomto clanku neposielaju.
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
    'title'        => 'Empagliflozín pri autozómovo dominantnej polycystickej chorobe obličiek: pilotná randomizovaná štúdia',
    'slug'         => 'empagliflozin-adpkd-pilotna-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Empagliflozín 25 mg denne bol 12 mesiacov znášaný, objem obličiek však rástol rýchlejšie: 10,5 % oproti 5,1 % za rok. Rozdiel v chronickom sklone eGFR štúdia nepreukázala.',
    'content'      => <<<'HTML'
<figure><a href="img/empagliflozin-adpkd-pilotna-studia.webp" rel="noopener noreferrer" target="_blank"><img src="img/empagliflozin-adpkd-pilotna-studia.webp" alt="Priesvitná polycystická oblička v tme, väčšie cysty v nej žiaria medeným svetlom" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani zobrazenie lieku. Medené svetlo v cystách je obraz otázky štúdie: či liečba, od ktorej sa pri inej chronickej chorobe obličiek čaká spomalenie poklesu filtrácie, pri autozómovo dominantnej polycystickej chorobe obličiek nezrýchli rast obličky.</figcaption></figure>

<p class="article-dek"><em>Dvanásťmesačná placebom kontrolovaná štúdia u 50 dospelých s autozómovo dominantnou polycystickou chorobou obličiek a vysokým rizikom progresie skúšala empagliflozín 25 mg raz denne. Plnú dávku skúšaného lieku znášalo 96 % ľudí v každej skupine. Celkový objem obličiek korigovaný na telesnú výšku rástol pri empagliflozíne o 10,5 % za rok a pri placebe o 5,1 % za rok.</em></p>

<p>Inhibítory kotransportéra sodíka a glukózy 2 (SGLT2) spomaľujú progresiu chronickej choroby obličiek pri diabete aj bez neho a znižujú kardiovaskulárne riziko. Ľudia s autozómovo dominantnou polycystickou chorobou obličiek (ADPKD) do veľkých štúdií tejto skupiny neboli zaraďovaní. Pri ADPKD sa okrem odhadovanej glomerulovej filtrácie (eGFR) sleduje rast obličiek. Objem je ukazovateľ aktivity cystického procesu a zároveň náhradný ukazovateľ, nie zlyhanie obličiek. Otázka pred štúdiou preto znela, či je empagliflozín v tejto chorobe znášaný a či rast obličiek nezrýchli.<sup>1</sup></p>

<h2>Koho štúdia skutočne sledovala</h2>

<p>Stephen L. Seliger a spolupracovníci publikovali 24. októbra 2026 v <em>Journal of the American Society of Nephrology</em> pilotnú randomizovanú štúdiu uskutočniteľnosti. Päťdesiat dospelých vo veku od 18 do 55 rokov s ADPKD a vysokým rizikom progresie, bez tolvaptanu, dostávalo 12 mesiacov empagliflozín 25 mg raz denne alebo placebo v pomere 1:1. Primárnymi ukazovateľmi boli bezpečnosť a znášanlivosť. Sekundárne boli zmena celkového objemu obličiek korigovaného na telesnú výšku, akútny a chronický sklon eGFR a zmeny rýchlosti aortálnej pulzovej vlny, plazmatického copeptínu, molekuly poškodenia obličiek 1 (KIM-1) v moči a pacientom udávaného skóre ADPKD Impact Scale, ktoré abstrakt označuje ako ADPKD Impact Score.<sup>1</sup></p>

<p>Abstrakt udáva priemerný vek 42 ± 7 rokov a priemernú eGFR 70 ± 17 ml/min/1,73 m<sup>2</sup>. Abstrakt nevysvetľuje, čo symbol ± pri týchto vstupných údajoch znamená. Register štúdie NCT05510115, ktorý práca sama uvádza, spresňuje podmienky, ktoré abstrakt zhŕňa slovami „vysoké riziko progresie“. Išlo o zobrazovaciu triedu Mayo 1C, 1D alebo 1E, eGFR od 30 do 90 ml/min/1,73 m<sup>2</sup> a stabilnú funkciu obličiek v predchádzajúcich troch mesiacoch. Diagnóza ADPKD mala spĺňať upravené kritériá Peiho a Ravina. Vylúčení boli ľudia so známym diabetom, s glykémiou nalačno nad 120 mg/dl (6,7 mmol/l), s HbA1c najmenej 6,5 %, so srdcovým zlyhávaním so zníženou ejekčnou frakciou, s aktuálnou liečbou kľučkovým diuretikom, s aktuálnou infekciou močových ciest a so systolickým tlakom v sede pod 100 alebo nad 160 mm Hg. Zlyhávanie so zachovanou ejekčnou frakciou register medzi vylučovacími podmienkami neuvádza.<sup>1,2</sup></p>

<p>Podľa toho istého registra ide o štúdiu fázy 2, zaslepenú pre účastníka, ošetrujúci personál, skúšajúceho aj hodnotiteľa výsledkov. eGFR sa počítala z kreatinínu revidovanou rovnicou CKD-EPI bez rasového koeficientu. Objem obličiek sa meral magnetickou rezonanciou na začiatku, po troch mesiacoch a po 12 mesiacoch. Zadávateľom je University of Colorado v Denveri, spolupracujúcimi inštitúciami University of Maryland a National Institute of Diabetes and Digestive and Kidney Diseases. Metadáta publikácie uvádzajú podporu z grantu NIDDK 1R01 DK131755-01A1, od Polycystic Kidney Disease Foundation, Zarpet Family Foundation Funds, z NIH/NCATS Colorado CTSA UM1 TR004399 a z klinických pracovísk University of Maryland.<sup>1,2</sup></p>

<h2>Znášanlivosť a nežiaduce udalosti</h2>

<p>Plnú dávku skúšaného lieku znášalo 96 % účastníkov v skupine s empagliflozínom aj v skupine s placebom. Register definuje znášanlivosť ako podiel ľudí, ktorí užívali 25 mg denne a zároveň odpovedali, že by takú dávku zniesli dlhodobo. Abstrakt tieto dve zložky nerozpisuje a udáva len súhrnné 96 % v každej skupine. Počet nežiaducich udalostí bol medzi skupinami podobný. Infekcia močových ciest sa vyskytla u dvoch ľudí pri empagliflozíne a u nikoho pri placebe. Akútne poškodenie obličiek sa vyskytlo u jedného človeka v skupine s placebom, nie pri empagliflozíne.<sup>1,2</sup></p>

<p>To je opis 12 mesiacov u 50 ľudí, nie dôkaz rovnakej bezpečnosti. Dve infekcie močových ciest zodpovedajú obave z glykozúrie, na odhad rozdielu rizika však nestačia. Abstrakt neuvádza, koľko ľudí štúdiu dokončilo, ani závažnosť jednotlivých udalostí.</p>

<h2>Objem obličiek rástol rýchlejšie</h2>

<p>Medzi sekundárnymi ukazovateľmi sa skupiny rozišli v raste obličiek. Anualizovaná zmena celkového objemu korigovaného na telesnú výšku bola 10,5 % za rok pri empagliflozíne (95 % interval spoľahlivosti od 8,2 do 12,7) a 5,1 % za rok pri placebe (95 % interval spoľahlivosti od 3,0 do 7,3; <em>P</em> = 0,001). Intervaly sa neprekrývajú. Abstrakt udáva jednu ročnú zmenu. Samostatné číslo po troch mesiacoch, hoci sa objem podľa registra meral aj vtedy, v ňom nie je.<sup>1,2</sup></p>

<div class="table-responsive" role="region" aria-label="Hlavné číselné výsledky pilotnej štúdie empagliflozínu pri ADPKD" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Empagliflozín 25 mg</th>
        <th scope="col">Placebo</th>
        <th scope="col"><em>P</em></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Objem obličiek korigovaný na telesnú výšku</th>
        <td>10,5 % za rok (95 % IS od 8,2 do 12,7)</td>
        <td>5,1 % za rok (95 % IS od 3,0 do 7,3)</td>
        <td>0,001</td>
      </tr>
      <tr>
        <th scope="row">Zmena eGFR za 1. mesiac</th>
        <td>−6,2 ml/min/1,73 m<sup>2</sup></td>
        <td>0,1 ml/min/1,73 m<sup>2</sup></td>
        <td>0,01</td>
      </tr>
      <tr>
        <th scope="row">Sklon eGFR od 1. do 12. mesiaca</th>
        <td>−0,77 ± 1,44 ml/min/1,73 m<sup>2</sup> za rok</td>
        <td>−2,87 ± 1,96 ml/min/1,73 m<sup>2</sup> za rok</td>
        <td>0,4</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Pri ADPKD je rast objemu zaužívaný ukazovateľ priebehu. V štúdii TEMPO 3:4 bol ročný rast celkového objemu obličiek primárnym ukazovateľom: 2,8 % za rok pri tolvaptane (95 % interval spoľahlivosti od 2,5 do 3,1) a 5,5 % za rok pri placebe (od 5,1 do 6,0) počas troch rokov.<sup>3</sup> Placebo v novej štúdii (5,1 % za rok) leží blízko placeba v TEMPO. Empagliflozín oproti vlastnému placebu objem zvýšil, tolvaptan oproti vlastnému placebu rast spomalil. Porovnanie je len orientačné. TEMPO merala celkový objem, Seligerova štúdia objem korigovaný na telesnú výšku. Líšia sa trvanie, vekové a funkčné prahy aj to, že do novej štúdie tolvaptan vstupovať nesmel. Priame porovnanie liekov z týchto dvoch prác nevyplýva.</p>

<p>Rýchlejší rast objemu ešte nehovorí, či pribudla cystická tekutina, parenchým, alebo oboje. Štúdia to neoddeľuje. Zlyhanie obličiek, náhrada funkcie a úmrtie v abstrakte nie sú. Objem bol sekundárny ukazovateľ pilotnej štúdie, nie vec, na ktorú bola dimenzovaná.</p>

<h2>eGFR klesla akútne a potom sa sklony nerozišli</h2>

<p>Za prvý mesiac klesla eGFR pri empagliflozíne o 6,2 ml/min/1,73 m<sup>2</sup> a pri placebe sa zmenila o 0,1 ml/min/1,73 m<sup>2</sup> (<em>P</em> = 0,01). Od 1. do 12. mesiaca abstrakt udáva sklon −0,77 ± 1,44 ml/min/1,73 m<sup>2</sup> za rok pri empagliflozíne a −2,87 ± 1,96 pri placebe (<em>P</em> = 0,4). Symbol ± ani tu nevysvetľuje. Bodové odhady idú smerom pomalšieho poklesu pri empagliflozíne, rozptyl okolo nich je voči rozdielu veľký. Výsledok nehovorí, že sklony sú rovnaké. Hovorí, že štúdia rozdiel nepreukázala a že nevylučuje ani pomalší, ani rýchlejší ďalší pokles, než v skupine s placebom.<sup>1</sup></p>

<p>Akútny pokles a neskorší sklon sú dva rôzne údaje. Prvý je zmena do konca prvého mesiaca. Druhý je rýchlosť zmeny až potom, stále počas užívania lieku. Štúdia liek nevysadila, takže z nej nevyplýva, že by sa pokles po ukončení vrátil. V iných populáciách sa takýto skorý pokles eGFR po inhibítore SGLT2 vysvetľuje zúžením aferentnej arterioly cez tubuloglomerulovú spätnú väzbu a býva po vysadení reverzibilný. Ten opis pochádza z prác pri diabete a inej chronickej chorobe obličiek, nie z ADPKD.<sup>4</sup></p>

<p>V rýchlosti aortálnej pulzovej vlny, v copeptíne, v KIM-1 v moči ani v skóre ADPKD Impact Scale abstrakt rozdiel medzi skupinami nezistil.<sup>1</sup> Copeptín je tu dôležitý preto, že mlčí. Obava, prečo by inhibítor SGLT2 mohol podporiť rast cýst, stojí na osmotickej diuréze a vyššom uvoľnení vazopresínu. KDIGO ju takto formuluje v odôvodnení odporúčania a dodáva, že pokusy na potkanoch a myšiach dopadli nejednotne.<sup>5</sup> Ak by sa objem v tejto štúdii zväčšoval práve cez vazopresín, čakal by sa rozdiel v copeptíne. Nebol tam. To mechanizmus nevylučuje. Ukazuje len, že nameraný náhradný ukazovateľ vazopresínu ho za 12 mesiacov nepodoprel. Rozdiel nebol ani pri KIM-1 v moči, takže abstrakt neprináša ani znak väčšieho tubulárneho poškodenia v skupine s empagliflozínom.</p>

<h2>Čo z toho urobiť pri rozhodovaní</h2>

<p>KDIGO v usmernení pre ADPKD z roku 2025 má praktický bod 4.7.1: inhibítory SGLT2 sa nemajú používať na spomalenie poklesu eGFR u ľudí s ADPKD. V bode 3.1.4 píše, že liečba diabetu má byť pri ADPKD rovnaká ako pri inej chronickej chorobe obličiek, s možnou výnimkou, že inhibítory SGLT2 sa zatiaľ neodporúčajú. Pracovná skupina vtedy za jediné potenciálne odôvodnenie podania považovala srdcové zlyhávanie. Ako prebiehajúcu štúdiu, ktorá má otázku bezpečnosti a účinku zodpovedať, usmernenie menuje práve NCT05510115.<sup>5</sup> Táto publikácia je jej výsledok. Chýbajúci dôkaz o spomalení progresie nenahrádza. Pridáva údaj o znášanlivosti a o rýchlejšom raste objemu.</p>

<p>Americké označenie Jardiance v znení na DailyMed z 2. februára 2026 neodporúča empagliflozín na liečbu chronickej choroby obličiek u ľudí s polycystickou chorobou obličiek a uvádza, že v tejto populácii sa účinnosť neočakáva. V opise štúdie EMPA-KIDNEY v tom istom označení je polycystická choroba medzi vylúčenými stavmi a použitá dávka je 10 mg.<sup>6</sup> Európsky súhrn charakteristických vlastností Jardiance, súbor EMA z 27. januára 2026, vetu o polycystickej chorobe neobsahuje. Pre chronickú chorobu obličiek v ňom platí 10 mg raz denne. Dávka 25 mg je v ňom vyhradená prísnejšej kontrole glykémie pri eGFR najmenej 60 ml/min/1,73 m<sup>2</sup>, nie indikácii chronickej choroby obličiek.<sup>7</sup> Štúdia teda skúšala vyššiu dávku, než je dávka registrovaná na chronickú chorobu obličiek, a skúšala ju u ľudí bez diabetu.</p>

<p>Pre prax z toho vyplývajú tri ohraničené veci. Rutinné nasadenie empagliflozínu pri ADPKD s očakávaním rovnakého ochranného účinku na funkciu obličiek ako pri inej chronickej chorobe obličiek tieto dáta nepodkladajú. Ak sa liek zvažuje pre srdcové zlyhávanie, táto štúdia zlyhávanie so zníženou ejekčnou frakciou vylúčila a o zachovanej ejekčnej frakcii nehovorí. Rýchlejší rast objemu ostáva súčasťou rozhovoru aj vtedy. Kombináciu s tolvaptanom štúdia neskúšala, lebo tolvaptan bol vylučovacou podmienkou. Ak pacient inhibítor SGLT2 už užíva, samotná eGFR po prvom mesiaci rast cýst neodhalí. Ako často objem merať, abstrakt nepredpisuje.</p>

<h2>Limity</h2>

<p>Plný text práce v <em>Journal of the American Society of Nephrology</em> nebol voľne dostupný. Všetky výsledkové čísla v tomto článku sú zo štruktúrovaného abstraktu. Vstupné kritériá, zaslepenie, rovnica pre eGFR, termíny magnetickej rezonancie, definícia znášanlivosti a inštitúcie sú z registra NCT05510115, nie z tabuliek plného textu. Abstrakt a register sa v dávke, trvaní, veku, počte 50 účastníkov a v tom, že išlo o bezpečnosť, zhodujú. Či plný text niektoré kritérium upravil, overiť nešlo.</p>

<p>Štúdia mala 50 ľudí a trvala 12 mesiacov. Nebola dimenzovaná na zlyhanie obličiek, náhradu funkcie ani úmrtie. Objem bol sekundárny ukazovateľ. Neprítomnosť rozdielu v chronickom sklone eGFR, v copeptíne, v KIM-1 a v dotazníku nie je dôkaz, že rozdiel neexistuje. Chýba údaj o počte ľudí, ktorí štúdiu dokončili, o pohlaví, o tlaku krvi a o vstupnom objeme obličiek. Abstrakt neuvádza, či symbol ± znamená smerodajnú odchýlku alebo štandardnú chybu. Ročník, číslo a strany časopis v čase overenia ešte nemal.</p>

<h2>Záver</h2>

<p>U dospelých s ADPKD, vysokým rizikom progresie a bez tolvaptanu bol empagliflozín 25 mg raz denne počas 12 mesiacov znášaný podobne ako placebo. Za prvý mesiac priniesol očakávaný akútny pokles eGFR. Ďalší sklon eGFR sa od placeba štatisticky nelíšil. Objem obličiek korigovaný na telesnú výšku rástol o 10,5 % za rok oproti 5,1 % pri placebe. Kým nebude väčšia štúdia s klinickými ukazovateľmi a s dávkou, ktorá zodpovedá registrácii, nie je dôvod považovať empagliflozín pri ADPKD za liečbu spomaľujúcu chorobu. Rýchlejší rast objemu je dôvod nechať doterajšiu zdržanlivosť platiť.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza súhrn charakteristických vlastností lieku, platné odporúčania ani individuálne klinické rozhodnutie. Dávka 25 mg v štúdii nie je dávka registrovaná na chronickú chorobu obličiek.</em></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=vasopresin-nezavisla-cesta-regulacie-vody-adpkd">Od vazopresínu nezávislá regulácia vody a jej možný význam pri liečbe ADPKD</a></li>
  <li><a href="article.php?slug=sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky">Inhibítory SGLT2 nie sú zameniteľné: rozdiely v schválených indikáciách</a></li>
  <li><a href="article.php?slug=umela-inteligencia-adpkd-klinicke-vyuzitie">Umelá inteligencia pri ADPKD: možnosti a hranice klinického využitia</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li id="ref-seliger-2026"><strong>Stephen L. Seliger, Berenice Gitomer, Zhiying You, Wei Wang, Anna Ostrow, Emily Andrews, Charalett Diggs, Diana George, Miranda West, Kristen L. Nowak, Terry Watnick, Michel Chonchol.</strong> <em>Empagliflozin Therapy in Autosomal Dominant Polycystic Kidney Disease: A Feasibility Randomized Controlled Trial.</em> Journal of the American Society of Nephrology. Zverejnené online 24. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. <a href="https://doi.org/10.1681/ASN.0000001271" target="_blank" rel="noopener noreferrer">DOI 10.1681/ASN.0000001271</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42925875/" target="_blank" rel="noopener noreferrer">PubMed 42925875</a>.</li>
  <li id="ref-nct05510115"><strong>ClinicalTrials.gov.</strong> <em>Feasibility of Study of Empagliflozin in Patients With Autosomal Dominant Polycystic Kidney Disease, NCT05510115.</em> University of Colorado, Denver. Vstupné a vylučovacie kritériá, zaslepenie, rovnica CKD-EPI, termíny magnetickej rezonancie a definícia znášanlivosti. <a href="https://clinicaltrials.gov/study/NCT05510115" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
  <li id="ref-tempo-2012"><strong>Vicente E. Torres, Arlene B. Chapman, Olivier Devuyst, Ron T. Gansevoort, Jared J. Grantham, Eiji Higashihara, Ronald D. Perrone, Holly B. Krasa, John Ouyang, Frank S. Czerwiec, TEMPO 3:4 Trial Investigators.</strong> <em>Tolvaptan in Patients with Autosomal Dominant Polycystic Kidney Disease.</em> The New England Journal of Medicine. 2012, ročník 367, číslo 25, strany 2407 až 2418. <a href="https://doi.org/10.1056/NEJMoa1205511" target="_blank" rel="noopener noreferrer">DOI 10.1056/NEJMoa1205511</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/23121377/" target="_blank" rel="noopener noreferrer">PubMed 23121377</a>.</li>
  <li id="ref-heerspink-2021"><strong>Hiddo J. L. Heerspink, David Z. I. Cherney.</strong> <em>Clinical Implications of an Acute Dip in eGFR after SGLT2 Inhibitor Initiation.</em> Clinical Journal of the American Society of Nephrology. 2021, ročník 16, číslo 8, strany 1278 až 1280. <a href="https://doi.org/10.2215/CJN.02480221" target="_blank" rel="noopener noreferrer">DOI 10.2215/CJN.02480221</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33879500/" target="_blank" rel="noopener noreferrer">PubMed 33879500</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8455037/" target="_blank" rel="noopener noreferrer">PMC8455037</a>.</li>
  <li id="ref-kdigo-2025"><strong>Olivier Devuyst, Curie Ahn, Thijs R.M. Barten, Godela Brosnahan, Melissa A. Cadnapaphornchai, Arlene B. Chapman, Emilie Cornec-Le Gall, Joost P.H. Drenth, Ron T. Gansevoort, Peter C. Harris, Tess Harris, Shigeo Horie, Max C. Liebau, Michele Liew, Andrew J. Mallett, Changlin Mei, Djalila Mekahli, Dwight Odland, Albert C.M. Ong, Luiz F. Onuchic, York P-C Pei, Ronald D. Perrone, Gopala K. Rangan, Brian Rayner, Roser Torra, Reem Mustafa, Vicente E. Torres.</strong> <em>KDIGO 2025 Clinical Practice Guideline for the Evaluation, Management, and Treatment of Autosomal Dominant Polycystic Kidney Disease (ADPKD).</em> Kidney International. 2025, ročník 107, číslo 2, strany S1 až S239. Praktické body 3.1.4 a 4.7.1. <a href="https://doi.org/10.1016/j.kint.2024.07.009" target="_blank" rel="noopener noreferrer">DOI 10.1016/j.kint.2024.07.009</a>. <a href="https://kdigo.org/wp-content/uploads/2025/01/KDIGO-2025-ADPKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO, plný text</a>.</li>
  <li id="ref-fda-jardiance"><strong>Boehringer Ingelheim Pharmaceuticals.</strong> <em>Jardiance (empagliflozin) tablets, for oral use. Prescribing information.</em> DailyMed, setid faf3dd6a-9cd0-39c2-0d2e-232cb3f67565, dátum zverejnenia 2. februára 2026. Obmedzenie použitia pri polycystickej chorobe obličiek a opis vylúčenia tejto choroby zo štúdie EMPA-KIDNEY s dávkou 10 mg. <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=faf3dd6a-9cd0-39c2-0d2e-232cb3f67565" target="_blank" rel="noopener noreferrer">DailyMed</a>.</li>
  <li id="ref-ema-jardiance"><strong>European Medicines Agency, Committee for Medicinal Products for Human Use.</strong> <em>Jardiance, INN-empagliflozin. Summary of product characteristics.</em> Súbor EPAR s dátumom 27. januára 2026. Časť 4.2: pri chronickej chorobe obličiek 10 mg raz denne, 25 mg len na prísnejšiu kontrolu glykémie. Text súboru slovo polycystic neobsahuje. <a href="https://www.ema.europa.eu/en/documents/product-information/jardiance-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA, súhrn charakteristických vlastností</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom.</strong> Abstrakt Seligerovej štúdie bol načítaný z PubMed (efetch, PMID 42925875) vrátane kľúčových viet. Dvanásť autorov, dátum online zverejnenia 24. októbra 2026, absencia ročníka a strán a zoznam poskytovateľov podpory boli porovnané s Crossref. Plný text JASN Unpaywall označil ako uzavretý a legálne dostupná verzia sa nenašla, takže tabuľky, straty zo sledovania a presná definícia symbolu ± overené nie sú. Register NCT05510115 bol načítaný z ClinicalTrials.gov API 28. októbra 2026. Usmernenie KDIGO 2025 bolo čítané v PDF na kdigo.org, praktické body 3.1.4 a 4.7.1 a odsek, ktorý menuje NCT05510115. Autori usmernenia sú z Crossref v uvedenom poradí. Komentár Heerspinka a Cherneyho bol čítaný v plnom texte na PMC. Čísla TEMPO 3:4 sú z abstraktu PubMed, autori a strany z Crossref, skupinové autorstvo z PubMed. Označenie Jardiance bolo čítané v XML na DailyMed (Boehringer, 2. februára 2026), časti o obmedzení použitia a o štúdii EMPA-KIDNEY. Európsky súhrn bol stiahnutý ako PDF EMA a v texte prehľadaný: časť 4.2 udáva dávky, slovo polycystic v súbore nie je. Slovenský text na stránke ŠÚKL som osobitne neotváral. Vlastné je oddelenie akútneho poklesu eGFR od neskoršieho sklonu, upozornenie, že ticho copeptínu mechanizmus nepotvrdzuje, a odmietnutie preniesť renoprotektívny účinok z inej chronickej choroby obličiek na ADPKD.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_empagliflozin-adpkd-pilotna-studia_article',
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
