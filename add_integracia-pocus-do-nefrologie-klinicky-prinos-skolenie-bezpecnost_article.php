<?php
/**
 * add_integracia-pocus-do-nefrologie-klinicky-prinos-skolenie-bezpecnost_article.php
 * Odborný článok: Integrácia point-of-care ultrasonografie (POCUS) do nefrológie: klinický prínos, výcvik a bezpečné používanie
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
    'title'        => 'Integrácia point-of-care ultrasonografie (POCUS) do nefrológie: klinický prínos, výcvik a bezpečné používanie',
    'slug'         => 'integracia-pocus-do-nefrologie-klinicky-prinos-skolenie-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Point-of-care ultrasonografia (POCUS) sa stáva kľúčovým doplnkom fyzikálneho vyšetrenia v nefrológii pri hodnotení hemodynamickej kongescie, akútneho poškodenia obličiek a porúch dialyzačného prístupu. Prehľad rozoberá diagnostickú nadradenosť multiorgánového POCUS oproti klasickej auskultácii a opuchom (LUST, VExUS), delenie na základné a pokročilé dopplerovské aplikácie a medzinárodné certifikačné štandardy IAPN (2024) a ASDIN.',
    'content'      => <<<'HTML'
<h2>Úvod: Ultrasonografia pri lôžku ako piaty pilier fyzikálneho vyšetrenia v nefrológii</h2>
<p>Ultrasonografia v mieste poskytovania zdravotnej starostlivosti (<em>point-of-care ultrasonography</em>, <strong>POCUS</strong>, označovaná aj ako cielená insonácia pri lôžku pacienta) prešla v poslednom desaťročí výraznou transformáciou: z úzko špecializovaného nástroja urgentnej medicíny a pomôcky pri kanylácii centrálnych žíl sa stala pevnou súčasťou diagnostického uvažovania internistov a nefrológov.<sup>1,2</sup> V nefrologickej praxi naráža lekár denne na opakujúcu sa klinickú dilemu: spoľahlivo posúdiť hemodynamický a tekutinový stav pacienta, včas odlíšiť príčiny dýchavice alebo akútneho zhoršenia funkcie obličiek a bez zbytočného časového sklzu rozhodnúť, či pacient potrebuje tekutinovú resuscitáciu, diuretickú dekongeciu, úpravu suchej hmotnosti pri hemodialýze alebo odblokovanie odtoku moču.<sup>1,2</sup></p>

<p>Zásadným východiskom bezpečného používania POCUS je jasné vymedzenie jeho účelu: POCUS predstavuje limitované, na konkrétnu klinickú otázku zamerané ultrazvukové vyšetrenie vykonávané a bezprostredne interpretované ošetrujúcim lekárom pri lôžku pacienta. Nie je náhradou komplexného, referenčného ultrazvukového vyšetrenia realizovaného na pracovisku rádiológie alebo kardiológie, ktorého cieľom je úplné a systematické zmapovanie celej anatomickej oblasti.<sup>1,2</sup></p>

<figure class="article-figure">
  <img src="img/integracia-pocus-do-nefrologie-klinicky-prinos-skolenie-bezpecnost.png" alt="Umelecká 3D vizualizácia point-of-care ultrasonografie (POCUS) obličky, dolnej dutej žily a akustických línií pri lôžku pacienta" width="1600" height="1000" loading="lazy">
  <figcaption><strong>Obrázok 1.</strong> Koncepčná vizualizácia multiorgánovej point-of-care ultrasonografie (POCUS) v nefrológii: súčasné posúdenie morfológie obličky, venózneho návratu v dolnej dutej žile, dopplerovských prietokových profilov a akustických reverberačných artefaktov pri hodnotení hemodynamickej kongescie.</figcaption>
</figure>

<h2>Prečo konvenčné fyzikálne vyšetrenie v nefrológii často nestačí</h2>

<h3>1. Nízka senzitivita klasických klinických znakov kongescie</h3>
<p>Tradičné fyzikálne znaky objemového preťaženia, akými sú auskultačné krepitácie nad pľúcnymi bázami alebo predkolenné opuchy, môžu byť u nefrologických pacientov klamlivo negatívne aj pri pokročilej intersticiálnej pľúcnej alebo systémovej venóznej kongescii.<sup>1,2</sup> Presvedčivý kvantitatívny dôkaz priniesla podštúdia projektu <strong>LUST</strong> (Torino a spolupracovníci, <em>Clinical Journal of the American Society of Nephrology</em>, 2016), ktorá porovnala <strong>1 106 pred- a postdialyzačných ultrazvukových vyšetrení pľúc</strong> u 79 hemodialyzovaných pacientov so štandardizovanou auskultáciou pľúc a hodnotením periférnych opuchov:<sup>3</sup></p>
<ul>
  <li>Auskultačné chrôpky vysvetľovali iba <strong>12 % variancie</strong> a periférne opuchy len <strong>4 % variancie</strong> skutočnej závažnosti pľúcnej kongescie určenej počtom ultrazvukových B-línií (hodnoty koeficientu zhody κ sa pohybovali medzi 0,00 a 0,16).<sup>3</sup></li>
  <li>Diskriminačná schopnosť pľúcnej auskultácie pre záchyt miernej, stredne ťažkej a ťažkej pľúcnej kongescie bola nízka (plocha pod ROC krivkou [AUC] 0,61; 0,65 a 0,68) a pri periférnych opuchoch ešte slabšia (AUC ≤ 0,56).<sup>3</sup></li>
</ul>

<p>V nadväzujúcej multicentrickej randomizovanej štúdii <strong>LUST</strong> (Zoccali a spolupracovníci, <em>Kidney International</em>, 2021; <em>N</em> = 367 hemodialyzovaných pacientov s vysokým kardiovaskulárnym rizikom) viedla titrácia ultrafiltrácie podľa pľúcneho ultrazvuku počas priemerného sledovania 1,49 roka k častejšiemu ústupu pľúcnej kongescie (<strong>78 % vs. 56 %</strong>). Hoci primárny zložený ukazovateľ (úmrtie, nefatálny infarkt myokardu, <em>de novo</em> dekompenzované srdcové zlyhávanie) sa medzi ramenami štatisticky nelíšil (HR 0,88; 95 % CI 0,63 až 1,24), <em>post-hoc</em> analýza preukázala významné zníženie rizika opakovaných epizód dekompenzovaného srdcového zlyhávania (HR 0,37; 95 % CI 0,15 až 0,93) a kardiovaskulárnych príhod (HR 0,63; 95 % CI 0,41 až 0,97), pričom v súvisiacich štúdiách došlo aj k lepšej kontrole ambulantného tlaku krvi a poklesu výskytu intradialyzačnej hypotenzie.<sup>2,4</sup></p>

<h3>2. Skrátenie diagnostického času a individualizácia hemodynamickej liečby</h3>
<p>Ak nefrológ pri lôžku pacienta v priebehu niekoľkých minút zhodnotí obličky, močový mechúr, pľúca, srdce a systémové žily, odstraňuje časovú a organizačnú bariéru medzi klinickým podozrením a cieleným terapeutickým zásahom.<sup>1,2</sup> Pri kardiorenálnom syndróme 1. typu preukázala randomizovaná kontrolovaná štúdia Islas-Rodríguezovej a spolupracovníkov (2024; <em>N</em> = 140), že riadenie dekongecie pomocou dopplerovského protokolu venóznej kongescie (VExUS) viac než dvojnásobne zvýšilo pravdepodobnosť dosiahnutia účinnej dekongecie (pomer šancí [OR] <strong>2,6</strong>; 95 % CI 1,9 až 3,0; <em>p</em> = 0,01) a poklesu koncentrácie nátriuretického peptidu BNP o viac než 30 % (OR <strong>2,4</strong>; 95 % CI 1,3 až 4,1; <em>p</em> = 0,01).<sup>2,5</sup> Podobne u pacientov s cirhózou pečene a akútnym poškodením obličiek dokáže POCUS odhaliť skrytú kardiálnu dysfunkciu alebo venóznu kongesciu u chorých pôvodne nesprávne klasifikovaných ako hepatorenálny syndróm.<sup>2</sup></p>

<h2>Rozsah praxe v nefrológii: základné verzus pokročilé aplikácie POCUS</h2>
<p>Medzinárodná aliancia pre POCUS v nefrológii (<em>International Alliance for POCUS in Nephrology</em>, <strong>IAPN</strong>) vo svojom konsenzuálnom stanovisku publikovanom v časopise <em>Clinical Kidney Journal</em> (Koratala a spolupracovníci, 2024) rozdelila diagnostické sonografické aplikácie v nefrológii podľa technickej náročnosti na <strong>základné</strong> (využívajúce zobrazenie v stupňoch sivej [B-mód] a farebný Doppler) a <strong>pokročilé</strong> (vyžadujúce spektrálny pulzný alebo kontinuálny Doppler a tkanivový Doppler).<sup>2</sup></p>

<div class="table-responsive">
  <table class="article-table">
    <thead>
      <tr>
        <th>Úroveň a oblasť vyšetrenia</th>
        <th>Technická modalita</th>
        <th>Cielené klinické otázky a jadrové kompetencie nefrológa</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Základný POCUS:</strong> Obličky, štep a močový mechúr</td>
        <td>B-mód, farebný Doppler</td>
        <td>Dĺžka obličiek, hrúbka a echogenicita kôry/parenchýmu; hydronefróza, hydroureter, cysty, konkrementy; perinefrické kolekcie a prekrvenie anastomózy štepu; výpočet objemu mechúra, retencia moču, malpozícia balónika Foleyho katétra, odlíšenie panvového ascitu od moču.<sup>1,2</sup></td>
      </tr>
      <tr>
        <td><strong>Základný POCUS:</strong> Pľúcna ultrasonografia (LUS)</td>
        <td>B-mód, M-mód</td>
        <td>Fyzikálny vznik artefaktov (A-línie pri prevzdušnenom parenchýme vs. vertikálne B-línie pri intersticiálnom edéme); odlíšenie kardiogénnych a pneumogénnych B-línií; pleurálny výpotok (príznak hrudnej chrbtice, <em>spine sign</em>), subpleurálne konsolidácie, posun pleury (<em>pleural sliding</em>) a vylúčenie pneumotoraxu.<sup>1,2</sup></td>
      </tr>
      <tr>
        <td><strong>Základný POCUS:</strong> Vnútorná jugulárna žila (IJV)</td>
        <td>B-mód</td>
        <td>Zobrazenie v dlhej a krátkej osi, lokalizácia bodu kolapsu (<em>meniscus/collapse point</em>) a odhad centrálneho venózneho tlaku s využitím reálnej hĺbky pravej predsiene z FoCUS namiesto fixného predpokladu 5 cm; zmeny priemeru pri dýchaní a Valsalvovom manévri.<sup>2</sup></td>
      </tr>
      <tr>
        <td><strong>Základný POCUS:</strong> Cielená echokardiografia (FoCUS)</td>
        <td>B-mód, M-mód, farebný Doppler</td>
        <td>Základné projekcie (parasternálna dlhá a krátka os, apikálna 4- a 5-dutinová, subxifoidálna 4-dutinová, dolná dutá žila [IVC]); perikardiálny výpotok a kolaps oddielov, orientačný odhad ejekčnej frakcie ĽK, funkcia a veľkosť PK, hrubé chlopňové chyby farebným Dopplerom, odhad tlaku v pravej predsieni (RAP) z IVC.<sup>1,2</sup></td>
      </tr>
      <tr>
        <td><strong>Základný POCUS:</strong> Dialyzačný prístup a iné</td>
        <td>B-mód, farebný Doppler</td>
        <td>AV fistula/štep: trombóza, pseudoaneuryzma, hematóm, hrubé známky stenózy, navigovaná kanylácia; peritoneálny katéter a manžeta (infekcia tunela, perikatétrový absces); 3-bodový kompresný test na hlbokú žilovú trombózu (DVT), voľná tekutina (ascites).<sup>2</sup></td>
      </tr>
      <tr>
        <td><strong>Pokročilý POCUS:</strong> Venózna kongescia (VExUS a eVExUS)</td>
        <td>Spektrálny pulzný Doppler</td>
        <td>Hodnotenie kriviek pečeňových žíl (vlny S, V, D, A; vplyv arytmií a trikuspidálnej regurgitácie), pulzatility portálnej žily (pozor na cirhózu a mladých športovcov) a intrarenálnych interlobárnych ciev (zmena kontinuálneho toku na bifázický až monofázický v diastole pri vzostupe RAP); rozšírený eVExUS (IJV, femorálna žila, horná dutá žila).<sup>2</sup></td>
      </tr>
      <tr>
        <td><strong>Pokročilý POCUS:</strong> Dopplerovská echokardiografia a prietok AV prístupom</td>
        <td>Spektrálny a tkanivový Doppler (TDI)</td>
        <td>Integrál rýchlosti a času vo výtokovom trakte ĽK a PK (LVOT VTI, RVOT VTI) a výpočet srdcového vývrhu; systolický tlak v pľúcnici (PASP); mitrálny vtok (pomer E/A) a tkanivový Doppler anulu (e′, S′, pomer E/e′); meranie prietoku v prívodnej artérii AV prístupu s korekciou uhla.<sup>2</sup></td>
      </tr>
    </tbody>
  </table>
</div>

<h3>Čo prekračuje rámec nefrologického POCUS</h3>
<p>Stanovisko IAPN (2024) výslovne upozorňuje, že niektoré vyšetrenia presahujú zmysel a časový rámec vyšetrenia pri lôžku a patria do rúk špecializovaných zobrazovacích pracovísk: komplexné hodnotenie stenózy renálnej artérie (nad rámec zachytenia krivky <em>parvus-tardus</em> alebo výraznej stranovej asymetrie rezistivného indexu), podrobné predoperačné mapovanie ciev pred vytvorením AV prístupu, komplexná spektrálna dopplerovská kvantifikácia stenóz AV fistuly, kontrastná ultrasonografia (CEUS), transezofageálna echokardiografia či detailná kvantifikácia chlopňových chýb pred kardiochirurgickým výkonom.<sup>2</sup></p>

<h2>Vzdelávanie, hodnotenie kompetencie a certifikačné štandardy</h2>

<h3>Prečo krátky kurz nestačí a ako definovať kompetenciu</h3>
<p>Jednorazové workshopy zvyšujú teoretické vedomosti a sebadôveru účastníkov, avšak bez následného dlhodobého supervidovaného tréningu dochádza k rýchlemu poklesu praktických zručností.<sup>1,2</sup> Štúdie opakovane potvrdzujú, že subjektívna sebadôvera lekára pri skenovaní nekoreluje spoľahlivo s objektívnou kompetenciou.<sup>2</sup> V súlade s definíciou Amerického kolégia urgentných lekárov (ACEP) a stanoviskom IAPN stojí kompetencia v POCUS na <strong>troch neoddeliteľných pilieroch</strong>:<sup>1,2</sup></p>
<ol>
  <li><strong>Získanie adekvátneho obrazu (akvizícia):</strong> správna indikácia vyšetrenia, výber sondy (konvexná, fázová kardiálna, lineárna), optimalizácia zisku (<em>gain</em>), hĺbky a ohniska, zvládnutie štandardizovaných pohybov sondy (posun [<em>slide</em>], vejárové nakláňanie [<em>fan/tilt</em>], kývanie [<em>rock</em>], rotácia, kompresia) a dezinfekcia.</li>
  <li><strong>Správna interpretácia:</strong> odlíšenie normálnej anatómie, anatomických variácií a patologických nálezov, pochopenie užitočných aj rušivých akustických artefaktov a rozpoznanie technicky nehodnotiteľného záznamu.</li>
  <li><strong>Klinická integrácia:</strong> zasadenie nálezu do kontextu anamnézy, fyzikálneho vyšetrenia a laboratórnych výsledkov, rozhodnutie o ďalšom postupe a včasná indikácia konziliárneho zobrazovacieho vyšetrenia.</li>
</ol>

<h3>Kvantitatívne požiadavky na certifikáciu a prípravy workshopov</h3>
<p>Pre organizáciu praktických nefrologických kurzov POCUS odporúča IAPN pomer školiteľov a účastníkov pri praktickom skenovaní <strong>1 : 2 až 1 : 3</strong> (maximálne <strong>1 : 4</strong> pri 30-minútových rotáciách) a udeľovanie len „osvedčenia o absolvovaní kurzu“ (<em>certificate of completion</em>), nie certifikátu plnej klinickej kompetencie.<sup>2</sup></p>

<p>Pre udelenie inštitucionálnych oprávnení (<em>credentialing and privileging</em>) podporuje IAPN v nadväznosti na prácu Romera-Gonzáleza a spolupracovníkov (2024) a štandardy Americkej spoločnosti pre diagnostickú a intervenčnú nefrológiu (ASDIN, revízia 2024) aj politiku Americkej lekárskej asociácie (AMA H-230.960, podľa ktorej si každá medicínska odbornosť definuje vlastné kompetenčné kritériá pre ultrasonografiu) tieto minimálne číselné prahy:<sup>2,6–8</sup></p>
<ul>
  <li><strong>Certifikácia pre základný POCUS (B-mód a farebný Doppler):</strong> minimálne <strong>6 hodín didaktickej výučby</strong>, najmenej <strong>30 minút praktického nácviku pod priamym dohľadom na každú sonografickú aplikáciu</strong> (napr. 30 min pre obličky, 30 min pre pľúca, 30 min pre základné kardiálne projekcie) a zdokumentovanie najmenej <strong>25 technicky adekvátnych a expertom skontrolovaných vyšetrení pre každú aplikáciu</strong>.<sup>2,6</sup></li>
  <li><strong>Certifikácia pre pokročilý POCUS (spektrálny a tkanivový Doppler):</strong> ďalších minimálne <strong>6 hodín didaktickej výučby</strong>, najmenej <strong>60 minút praktického nácviku pod priamym dohľadom na každú aplikáciu</strong> a zdokumentovanie najmenej <strong>50 adekvátnych vyšetrení pre každú pokročilú aplikáciu</strong>.<sup>2,6</sup></li>
</ul>

<h2>Prístrojové vybavenie, umelá inteligencia, archivácia a metodológia výskumu</h2>

<h3>Vozíkové systémy verzus vreckové sondy a úloha AI</h3>
<p>Dostupnosť vreckových (<em>handheld</em>) ultrazvukových sond výrazne uľahčila zavedenie POCUS na dialyzačných strediskách a v ambulanciách. Nefrologické pracoviská však musia zohľadniť, že lacnejšie vreckové prístroje majú nižšie priestorové a kontrastné rozlíšenie, menšiu zobrazovaciu plochu tabletu alebo telefónu a často neponúkajú plnohodnotný spektrálny ani tkanivový Doppler potrebný pre pokročilú hemodynamiku (VExUS, LVOT VTI, E/e′).<sup>1,2</sup> Optimálnym riešením pre výučbové pracoviská je preto kombinácia pojazdných (<em>cart-based</em>) systémov s vysokou kvalitou obrazu a vreckových sond pre mobilnú prax.<sup>2</sup></p>

<p>Sľubným smerom sú nástroje <strong>umelej inteligencie (AI)</strong> integrované priamo do ultrazvukových systémov, ktoré pomáhajú pri navádzaní sondy, automatickom počítaní B-línií, meraní priemeru dolnej dutej žily, odhade ejekčnej frakcie ĽK či automatickom výpočte LVOT VTI a pomeru E/e′.<sup>2</sup> IAPN však varuje pred nekritickým spoliehaním sa na automatické výpočty AI v situáciách, keď je samotný východiskový obraz technicky nekvalitný alebo šikmo skosený.<sup>2</sup></p>

<h3>Archivácia obrazov, ochrana údajov a dizajn klinických štúdií</h3>
<p>Každý bezpečný program POCUS vyžaduje infraštruktúru na <strong>archiváciu obrazov</strong> v nemocničnom systéme (PACS/EMR). Archivácia umožňuje priebežnú kontrolu kvality a spätnú väzbu pre školencov, zabraňuje zbytočnému opakovaniu toho istého vyšetrenia viacerými špecialistami, slúži ako medicínsko-právna dokumentácia a umožňuje vykazovanie výkonov.<sup>1,2</sup> Pri zdieľaní edukačných prípadov na odborných platformách je nevyhnutná prísna deidentifikácia všetkých osobných údajov pacienta.<sup>2</sup></p>

<p>Napokon, v klinickom výskume POCUS treba pamätať na to, že zobrazovacia metóda sama osebe neznižuje mortalitu: klinický výsledok pacienta sa zlepší len vtedy, ak vyšetrenie vykoná preukázateľne kompetentný operátor, nehodnotí sa izolovaný parameter vytrhnutý z kontextu celého hemodynamického okruhu (napr. samotný priemer IVC bez kardiálneho a venózneho Dopplera) a na sonografický nález je priamo naviazaný racionálny terapeutický protokol.<sup>1,2</sup></p>

<h2>Záver</h2>
<p>Integrácia multiorgánového POCUS do nefrológie podstatne spresňuje diagnostiku hemodynamických a objemových porúch, urýchľuje odhalenie obštrukčných, pľúcnych, kardiálnych a cievnych komplikácií a prehlbuje patofyziologické uvažovanie pri lôžku pacienta. Aby sa tento potenciál premietol do vyššej bezpečnosti pacientov, musí byť zavedenie POCUS podložené štruktúrovaným longitudinálnym výcvikom (s minimom 25 supervidovaných vyšetrení pre základné a 50 pre pokročilé dopplerovské aplikácie), systematickou archiváciou obrazov, priebežným auditom kvality a rešpektovaním hraníc voči konziliárnej rádiologickej a kardiologickej diagnostike.<sup>1,2,6–8</sup></p>

<h2>Literatúra</h2>
<ol class="references-list">
  <li>Koratala A, Reisinger N. POCUS for Nephrologists: Basic Principles and a General Approach. <em>Kidney360</em>. 2021;2(10):1660–1668. DOI: <a href="https://doi.org/10.34067/KID.0002482021" target="_blank" rel="noopener">10.34067/KID.0002482021</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/35372985/" target="_blank" rel="noopener">35372985</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8785785/" target="_blank" rel="noopener">PMC8785785</a>.</li>
  <li>Koratala A, Argaiz ER, Romero-González G, Reisinger N, Anwar S, Beaubien-Souligny W, Bhasin-Chhabra B, Diniz H, Vaca Gallardo M, Graterol Torres F, Husain-Syed F, Hanko J, Jaberi A, Kazory A, Raina R, Ronco C, Salgado OJ, Sethi SK, Villavicencio-Cerón V, Yadla M, Gomes Bastos M. Point-of-care ultrasound training in nephrology: a position statement by the International Alliance for POCUS in Nephrology. <em>Clinical Kidney Journal</em>. 2024;17(11):sfae245. DOI: <a href="https://doi.org/10.1093/ckj/sfae245" target="_blank" rel="noopener">10.1093/ckj/sfae245</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/39502372/" target="_blank" rel="noopener">39502372</a>. PMCID: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11536759/" target="_blank" rel="noopener">PMC11536759</a>.</li>
  <li>Torino C, Gargani L, Sicari R, Letachowicz K, Ekart R, Fliser D, Covic A, Siamopoulos K, Stavroulopoulos A, Massy ZA, Fiaccadori E, Caiazza A, Bachelet T, Slotki I, Martinez-Castelao A, Coudert-Krier MJ, Rossignol P, Gueler F, Hannedouche T, Panichi V, Wiecek A, Pontoriero G, Sarafidis P, Klinger M, Hojs R, Seiler-Mussler S, Lizzi F, Siriopol D, Balafa O, Shavit L, Tripepi R, Mallamaci F, Tripepi G, Picano E, London GM, Zoccali C. The Agreement between Auscultation and Lung Ultrasound in Hemodialysis Patients: The LUST Study. <em>Clinical Journal of the American Society of Nephrology</em>. 2016;11(11):2005–2011. DOI: <a href="https://doi.org/10.2215/CJN.03890416" target="_blank" rel="noopener">10.2215/CJN.03890416</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/27660305/" target="_blank" rel="noopener">27660305</a>.</li>
  <li>Zoccali C, Torino C, Mallamaci F, Sarafidis P, Papagianni A, Ekart R, Hojs R, Klinger M, Letachowicz K, Fliser D, Seiler-Mußler S, Lizzi F, Wiecek A, Miskiewicz A, Siamopoulos K, Balafa O, Slotki I, Shavit L, Stavroulopoulos A, Covic A, Siriopol D, Massy ZA, Seidowsky A, Battaglia Y, Martinez-Castelao A, Polo-Torcal C, Coudert-Krier MJ, Rossignol P, Fiaccadori E, Regolisti G, Hannedouche T, Bachelet T, Jager KJ, Dekker FW, Tripepi R, Tripepi G, Gargani L, Sicari R, Picano E, London GM. A randomized multicenter trial on a lung ultrasound-guided treatment strategy in patients on chronic hemodialysis with high cardiovascular risk. <em>Kidney International</em>. 2021;100(6):1325–1333. DOI: <a href="https://doi.org/10.1016/j.kint.2021.07.024" target="_blank" rel="noopener">10.1016/j.kint.2021.07.024</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/34418415/" target="_blank" rel="noopener">34418415</a>.</li>
  <li>Islas-Rodríguez JP, Miranda-Aquino T, Romero-González G, Hernández-Del Rio J, Camacho-Guerrero JR, Covarrubias-Villa S, Ivey-Miranda JB, Chávez-Íñiguez JS. Effect on Kidney Function Recovery Guiding Decongestion with VExUS in Patients with Cardiorenal Syndrome 1: A Randomized Control Trial. <em>Cardiorenal Medicine</em>. 2024;14(1):1–11. DOI: <a href="https://doi.org/10.1159/000535641" target="_blank" rel="noopener">10.1159/000535641</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38061346/" target="_blank" rel="noopener">38061346</a>.</li>
  <li>Romero-González G, Argaiz ER, Koratala A, González DA, Vives M, Juega J, Soler-Majoral J, Graterol F, Perezpayá I, Rodriguez-Chitiva N, Lorenzo-Ferris I, Narvaez C, Manrique J, Morales E, Rivera-Gorrín M, Ibeas J, Bover J, Sánchez E, de Sequera P. Towards standardization of POCUS training in Nephrology: the time is NOW. <em>Nefrología (English Edition)</em>. 2024;44(1):5–9. DOI: <a href="https://doi.org/10.1016/j.nefroe.2024.02.005" target="_blank" rel="noopener">10.1016/j.nefroe.2024.02.005</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/38429147/" target="_blank" rel="noopener">38429147</a>.</li>
  <li>American Medical Association (AMA). <em>Privileging for Ultrasound Imaging, Policy H-230.960</em>. Chicago (IL): American Medical Association House of Delegates; 2023. Dostupné z: <a href="https://policysearch.ama-assn.org/policyfinder/detail/Ultrasoundimaging?uri=%2FAMADoc%2FHOD.xml-0-1591.xml" target="_blank" rel="noopener">https://policysearch.ama-assn.org/policyfinder/detail/Ultrasoundimaging?uri=%2FAMADoc%2FHOD.xml-0-1591.xml</a></li>
  <li>American Society of Diagnostic and Interventional Nephrology (ASDIN). <em>Basic Point of Care Ultrasound (POCUS) Certification Requirements (Revised August 1, 2024)</em>. Clinton (MS): ASDIN; 2024. Dostupné z: <a href="https://cdn.ymaws.com/www.asdin.org/resource/resmgr/ultrasound/ASDINPOCUSCertRevised_080124.pdf" target="_blank" rel="noopener">https://cdn.ymaws.com/www.asdin.org/resource/resmgr/ultrasound/ASDINPOCUSCertRevised_080124.pdf</a></li>
</ol>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_integracia-pocus-do-nefrologie-klinicky-prinos-skolenie-bezpecnost_article',
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
?>
