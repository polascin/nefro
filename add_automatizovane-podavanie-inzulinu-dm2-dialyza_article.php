<?php
/**
 * add_automatizovane-podavanie-inzulinu-dm2-dialyza_article.php
 * Odborný článok o automatizovanom podavaní inzulínu pri diabete 2. typu
 * a jeho nefrologických súvislostiach vrátane dialyzovaných pacientov.
 * Spracovanie správy Medscape Medical News zo 16. 10. 2026 (Miriam E. Tucker).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Automatizované podávanie inzulínu pri diabete 2. typu: čo z toho platí pre pacienta na dialýze',
    'slug'         => 'automatizovane-podavanie-inzulinu-dm2-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Metaanalýza devätich randomizovaných štúdií, randomizovaná štúdia priamo u dialyzovaných a dva nové systémy povolené FDA – vážené proti krátkemu trvaniu a náhradným ukazovateľom.',
    'content'      => <<<'HTML'
<figure><a href="img/automatizovane-podavanie-inzulinu-dm2-dialyza.webp" rel="noopener noreferrer" target="_blank"><img src="img/automatizovane-podavanie-inzulinu-dm2-dialyza.webp" alt="Jantárová stuha svetla je vľavo prudko rozkmitaná a smerom doprava sa vyhladzuje do pokojného pásu, ktorý prechádza polopriesvitnou sklenou obličkou" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie záznam konkrétneho pacienta ani zobrazenie konkrétneho zariadenia. Zmyslom automatizovaného podávania inzulínu nie je nižší priemer glykémie, ale užšie rozpätie – a práve to je u dialyzovaného pacienta najťažšie dosiahnuteľné.</figcaption></figure>

<p>Automatizované podávanie inzulínu (automated insulin delivery, AID) spája kontinuálne monitorovanie glukózy (CGM) s algoritmom, ktorý priebežne upravuje dodávku inzulínu z pumpy. Trieda vyrástla pri diabete 1. typu; za posledné dva roky sa však regulačne aj dôkazovo presúva k diabetu 2. typu (DM2) liečenému inzulínom.</p>

<p>Pre nefrológiu to nie je okrajová téma. Pacient s pokročilou chronickou chorobou obličiek alebo na dialýze patrí medzi tých, u ktorých je glykemická kontrola najťažšia a najrizikovejšia zároveň: klírens inzulínu je znížený, glykovaný hemoglobín (HbA1c) je nespoľahlivý a hypoglykémia býva častá a nerozpoznaná. Existuje navyše randomizovaná štúdia vykonaná priamo v dialyzovanej populácii, ktorá v sekundárnych zhrnutiach spravidla zanikne.</p>

<p>Tento text zhŕňa, čo o AID pri DM2 vieme z metaanalýzy randomizovaných štúdií, čo priniesli najnovšie regulačné rozhodnutia, a čo z toho platí špecificky pre pacienta s obličkovým ochorením.</p>

<h2>Čo AID je a aké režimy sa rozlišujú</h2>

<p>Systém má tri časti: senzor kontinuálne meriaci glukózu v podkoží, inzulínovú pumpu a riadiaci algoritmus, ktorý zo senzorových hodnôt počíta dodávku inzulínu. Podľa miery automatizácie sa rozlišujú:</p>

<ul>
  <li><strong>Hybridná uzavretá slučka (hybrid closed-loop, HCL)</strong> – algoritmus riadi bazálnu dodávku a korekcie, pacient však musí hlásiť jedlo a podávať prandiálne bolusy.</li>
  <li><strong>Plne uzavretá slučka (fully closed-loop, FCL)</strong> – systém reaguje aj na postprandiálny vzostup bez toho, aby pacient jedlo zadával.</li>
</ul>

<p>Rozdiel je pre nefrológiu podstatný. U staršieho dialyzovaného pacienta s nepravidelným príjmom, s dňami na dialýze a mimo nej a často so zníženou schopnosťou odhadovať sacharidy je spoľahlivé zadávanie jedál práve tým článkom, ktorý zlyháva – a plne automatizovaný režim ho obchádza.</p>

<h2>Dôkazová základňa pri DM2: čo hovorí metaanalýza</h2>

<p>Systematický prehľad a metaanalýza publikovaná v <em>Diabetes, Obesity and Metabolism</em> (vyhľadávanie do 1. júla 2025, protokol PROSPERO CRD420251083874) zahrnula <strong>deväť randomizovaných štúdií a 714 dospelých s DM2</strong>, ktoré porovnávali AID s inou liečbou znižujúcou glykémiu a uvádzali podiel času v cieľovom rozmedzí 3,9–10,0 mmol/l (70–180 mg/dl).</p>

<div class="table-responsive" role="region" aria-label="Výsledky metaanalýzy automatizovaného podávania inzulínu pri diabete 2. typu" tabindex="0">
<table>
<caption>Hlavné výsledky metaanalýzy deviatich randomizovaných štúdií (714 dospelých s DM2). MD = rozdiel priemerov oproti kontrole.</caption>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">Účinok AID oproti kontrole</th><th scope="col">Istota dôkazu</th></tr>
</thead>
<tbody>
<tr><th scope="row">Čas v cieľovom rozmedzí (3,9–10,0 mmol/l)</th><td>MD +18,43 % (95 % IS 12,40 až 24,46)</td><td>nízka</td></tr>
<tr><th scope="row">HbA1c</th><td>MD −1,02 % (95 % IS −1,71 až −0,32)</td><td>stredná</td></tr>
<tr><th scope="row">Čas nad cieľovým rozmedzím &gt; 13,9 mmol/l</th><td>MD −7,81 % (95 % IS −14,18 až −1,44)</td><td>—</td></tr>
<tr><th scope="row">Čas pod cieľovým rozmedzím (&lt; 3,9 mmol/l)</th><td>bez rozdielu</td><td>stredná</td></tr>
<tr><th scope="row">Čas pod 3,0 mmol/l a variačný koeficient</th><td>bez rozdielu</td><td>—</td></tr>
<tr><th scope="row">Telesná hmotnosť</th><td>MD +1,58 kg (95 % IS 0,75 až 2,40)</td><td>len dve štúdie</td></tr>
<tr><th scope="row">Závažné nežiaduce udalosti vrátane ťažkej hypoglykémie</th><td>zriedkavé</td><td>—</td></tr>
<tr><th scope="row">Diabetická ketoacidóza</th><td>nehlásená ani raz</td><td>—</td></tr>
</tbody>
</table>
</div>

<p>Dva body si zaslúžia zdôraznenie, lebo v populárnych zhrnutiach vypadávajú.</p>

<p><strong>Prvý: prírastok hmotnosti.</strong> AID viedlo k miernemu, ale štatisticky významnému nárastu telesnej hmotnosti o 1,58 kg – a to napriek porovnateľnej celkovej dennej dávke inzulínu. V populácii, kde sa súčasne vedie boj o kardiometabolické riziko a kde sa súbežne zvažujú inhibítory SGLT2 či agonisty receptora GLP-1, to nie je zanedbateľný údaj. Zistenie však stojí len na dvoch štúdiách.</p>

<p><strong>Druhý: istota dôkazu je nízka až stredná.</strong> Zaradené štúdie trvali od troch dní po tri mesiace, štyri prebehli za hospitalizácie a šesť z deviatich použilo prototypové, nie komerčné systémy. Hovoríme teda o krátkodobom náhradnom ukazovateli – čase v rozmedzí – nie o preukázanom vplyve na komplikácie.</p>

<h2>Nefrologické jadro: randomizovaná štúdia u dialyzovaných</h2>

<p>Dve zo zaradených štúdií zahŕňali pacientov s terminálnym zlyhaním obličiek na dialýze. Jedna z nich bola na túto populáciu priamo zameraná a stojí za samostatné uvedenie.</p>

<p>Boughton a kol. v otvorenej randomizovanej prekríženej štúdii v dvoch centrách (Cambridge a Bern) zaradili <strong>26 dospelých s DM2 vyžadujúcich dialýzu</strong> – 17 mužov a 9 žien, priemerný vek 68 ± 11 rokov, trvanie diabetu 20 ± 10 rokov. Každý účastník absolvoval dve <strong>20-dňové obdobia neobmedzeného bežného života</strong>: cambridgeský plne uzavretý systém s rýchlo pôsobiacim inzulínom aspartom verzus štandardná inzulínová liečba so zaslepeným senzorom.</p>

<ul>
  <li>Podiel času v cieľovom rozmedzí 5,6–10,0 mmol/l (hlavný ukazovateľ): <strong>52,8 ± 12,5 % pri uzavretej slučke verzus 37,7 ± 20,5 % pri štandardnej liečbe</strong>; rozdiel 15,1 percentuálneho bodu (95 % IS 8,0–22,2; P &lt; 0,001).</li>
  <li>Priemerná glykémia: 10,1 ± 1,3 verzus 11,6 ± 2,8 mmol/l (P = 0,003).</li>
  <li>Čas v hypoglykémii pod 3,9 mmol/l: medián 0,1 % (0,0–0,4) verzus 0,2 % (0,0–0,9); P = 0,040 – teda <strong>menej hypoglykémie, nie viac</strong>.</li>
  <li>Jedna ťažká hypoglykémia nastala v období uzavretej slučky, ale nie počas jej prevádzky; v kontrolnom období žiadna.</li>
</ul>

<p>Všimnime si šírku smerodajnej odchýlky v kontrolnej skupine (20,5 %). Pri štandardnej liečbe sa dialyzovaní pacienti v čase v rozmedzí extrémne líšia – a práve túto nepredvídateľnosť automatizácia zužuje. Ide o najpresvedčivejší dôkaz, aký v tejto populácii máme; zároveň však o <strong>26 pacientov a 20 dní</strong>, čo je príliš málo na akýkoľvek záver o dlhodobej bezpečnosti alebo o komplikáciách.</p>

<h3>Prečo je dialyzovaný pacient iný</h3>

<ul>
  <li><strong>Znížený klírens inzulínu.</strong> Oblička sa podieľa na odbúravaní inzulínu; pri pokročilej chronickej chorobe obličiek sa účinok podanej dávky predlžuje a potreba inzulínu klesá. Rovnaká dávka, ktorá bola roky bezpečná, sa môže stať nadbytočnou.</li>
  <li><strong>Striedanie dní na dialýze a mimo nej.</strong> Príjem potravy, fyzická aktivita aj samotná procedúra menia glykémiu v cykle, ktorý sa opakuje týždeň čo týždeň. Fixný bazálny režim ho nedokáže sledovať; algoritmus áno.</li>
  <li><strong>Glukóza v dialyzačnom roztoku</strong> a odstraňovanie glukózy počas procedúry posúvajú glykémiu oboma smermi, s typickým poklesom počas a po dialýze.</li>
  <li><strong>HbA1c klame.</strong> Skrátené prežívanie erytrocytov, anémia, liečba látkami stimulujúcimi erytropoézu a prípadné krvné straty posúvajú HbA1c nadol a podhodnocujú skutočnú záťaž hyperglykémiou. Preto má v tejto populácii <strong>čas v cieľovom rozmedzí z CGM väčšiu výpovednú hodnotu než HbA1c</strong> – a to je argument pre CGM nezávislý od toho, či sa k nemu pridá automatizácia.</li>
  <li><strong>Nerozpoznaná hypoglykémia.</strong> Autonómna neuropatia a dlhé trvanie diabetu tlmia varovné príznaky; nočné hypoglykémie bez senzora zostanú neodhalené.</li>
</ul>

<h2>Regulačný stav: čo je k dispozícii</h2>

<p>Americká FDA povolila <strong>26. augusta 2024</strong> prvé zariadenie umožňujúce automatizované dávkovanie inzulínu u dospelých s DM2 – technológiu SmartAdjust spoločnosti Insulet, posúdenú na základe údajov od 289 účastníkov sledovaných 13 týždňov; v klinických údajoch neboli hlásené komplikácie ani závažné nežiaduce udalosti súvisiace s technológiou.</p>

<p>V októbri 2026 pribudol systém <strong>twiist</strong> (Sequel Med Tech), povolený pre dospelých od 18 rokov s DM2 liečeným inzulínom. Podľa správy Medscape:</p>

<ul>
  <li>systém priebežne upravuje bazálnu dodávku, má zásobník na 300 jednotiek a mení sa každé tri dni;</li>
  <li>je kompatibilný so senzormi Abbott FreeStyle Libre 3 Plus a Senseonics Eversense 365, <strong>nie však so systémami Dexcom</strong>;</li>
  <li>pivotná multicentrická štúdia zahŕňala <strong>307 dospelých</strong> s DM2 liečeným inzulínom; po 13 týždňoch klesol priemerný HbA1c z 8,1 % na 7,4 % (P &lt; 0,001) a čas v rozmedzí stúpol zo 57 % na 73 % (P &lt; 0,001), bez hlásenej ťažkej hypoglykémie. Najväčšie zlepšenie dosiahli pacienti so vstupným HbA1c ≥ 9 %;</li>
  <li>pre DM1 od veku 6 rokov bol systém povolený už v roku 2024.</li>
</ul>

<p>Tvrdenie výrobcu, že proprietárna technológia iiSure odhalí upchatie „až deväťkrát rýchlejšie než iné systémy AID“, pochádza z vyhlásenia spoločnosti a nie je nezávisle overené – treba ho čítať ako marketingový údaj, nie ako zistenie z recenzovanej práce.</p>

<p>Pre DM2 sú tak v USA dostupné štyri systémy: Omnipod 5, algoritmus Tandem Control-IQ+, MiniMed 780G a twiist. <strong>Pozor na prenos do slovenských podmienok:</strong> povolenie FDA nie je registráciou v Európskej únii a nehovorí nič o úhrade. Dostupnosť a indikačné obmedzenia u nás treba overiť podľa platného zoznamu zdravotníckych pomôcok a podmienok zdravotných poisťovní.</p>

<h2>Čo z toho pre prax</h2>

<ol>
  <li><strong>CGM pred AID.</strong> U dialyzovaného pacienta s inzulínom je prvým krokom kontinuálny monitoring, nie automatizácia. Sám osebe rieši najväčší problém – neviditeľnosť hypoglykémie a nespoľahlivosť HbA1c.</li>
  <li><strong>Cieľové hodnoty prispôsobte, nie prevezmite.</strong> Štandardné rozmedzie 3,9–10,0 mmol/l a cieľ 70 % času v ňom boli odvodené pre inú populáciu. U staršieho, krehkého dialyzovaného pacienta má prednosť vyhýbanie sa hypoglykémii pred dosiahnutím cieľa – uvoľnenejšie dolné hranice sú opodstatnené.</li>
  <li><strong>Pri poklese filtrácie očakávajte pokles potreby inzulínu.</strong> Algoritmus sa prispôsobí, ale len v rozsahu, ktorý mu nastavenia umožnia; východiskové parametre treba pri zmene renálnej funkcie revidovať.</li>
  <li><strong>Overujte senzor pri nesúlade.</strong> CGM meria glukózu v medzibunkovej tekutine s oneskorením oproti krvi. Ak klinický obraz nezodpovedá hodnote, platí meranie glukomerom. V urémii a pri rýchlych zmenách objemu je rozdiel väčší než za bežných okolností.</li>
  <li><strong>Edukácia sa nedá preskočiť.</strong> Výmena spotrebného materiálu, reakcia na alarmy, rozpoznanie upchatia, postup pri výpadku systému – u pacienta, ktorý trávi tri poldni v týždni na dialýze, musí byť tento plán vopred písomne dohodnutý so strediskom.</li>
  <li><strong>Sledujte hmotnosť.</strong> Mierny prírastok je v metaanalýze doložený; u pacienta so súčasným kardiometabolickým rizikom to patrí do rozvahy.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Krátke trvanie.</strong> Zaradené štúdie trvali dni až tri mesiace. O vplyve na progresiu chronickej choroby obličiek, hospitalizácie, kardiovaskulárnu mortalitu či komplikácie diabetu nevieme nič.</li>
  <li><strong>Náhradný ukazovateľ.</strong> Čas v cieľovom rozmedzí je presvedčivý fyziologický ukazovateľ, ale nie klinický výsledok. Istota dôkazu bola pre hlavný ukazovateľ hodnotená ako nízka.</li>
  <li><strong>Heterogenita.</strong> Prototypové aj komerčné systémy, rôzne senzory, nemocničné aj ambulantné prostredie, rôzne komparátory – súhrnný odhad treba brať ako orientačný.</li>
  <li><strong>Dialyzovaná populácia stojí na jednej malej štúdii.</strong> Dvadsaťšesť pacientov, dvadsať dní, plne uzavretý prototypový systém. Preniesť tento výsledok na komerčné hybridné systémy nie je samozrejmé.</li>
  <li><strong>Peritoneálna dialýza nie je pokrytá vôbec.</strong> Glukózová nálož z dialyzačného roztoku je pri nej zásadným činiteľom a údaje o AID v tomto prostredí chýbajú.</li>
  <li><strong>Prírastok hmotnosti stojí na dvoch štúdiách</strong> a nemusí platiť pre každý systém.</li>
</ul>

<hr>

<p><em>Text je určený zdravotníckym pracovníkom. Nenahrádza odborné posúdenie konkrétneho prípadu ani návod na použitie konkrétnej pomôcky. Uvádzané povolenia americkej FDA nie sú registráciou v Európskej únii; o dostupnosti, indikácii a úhrade rozhodujú platné slovenské predpisy a podmienky zdravotných poisťovní.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Di Molfetta S, Di Gioia L, Caruso I, Caporusso M, Perrini S, Natalicchio A, Laviola L, Giorgino F. Efficacy and Safety of Automated Insulin Delivery in People With Type 2 Diabetes: A Systematic Review and Meta-Analysis. <em>Diabetes Obes Metab.</em> 2026;28(6):5091–5100. doi: <a href="https://doi.org/10.1111/dom.70708" target="_blank" rel="noopener noreferrer">10.1111/dom.70708</a>. PMID: 41889265, PMC13146134.</li>
  <li>Boughton CK, Tripyla A, Hartnell S, Daly A, Herzig D, Wilinska ME, Czerlau C, Fry A, Bally L, Hovorka R. Fully automated closed-loop glucose control compared with standard insulin therapy in adults with type 2 diabetes requiring dialysis: an open-label, randomized crossover trial. <em>Nat Med.</em> 2021;27(8):1471–1476. doi: <a href="https://doi.org/10.1038/s41591-021-01453-z" target="_blank" rel="noopener noreferrer">10.1038/s41591-021-01453-z</a>. PMID: 34349267, PMC8363503. NCT04025775.</li>
  <li>Bally L, Thabit H, Hartnell S, et al. Closed-Loop Insulin Delivery for Glycemic Control in Noncritical Care. <em>N Engl J Med.</em> 2018;379(6):547–556. doi: <a href="https://doi.org/10.1056/NEJMoa1805233" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1805233</a>.</li>
  <li>Tucker ME. Automated Insulin Delivery in T2D: Latest System FDA Cleared. <em>Medscape Medical News</em>, 16. októbra 2026. <a href="https://www.medscape.com/viewarticle/automated-insulin-delivery-t2d-latest-system-fda-cleared-2026a100132k" target="_blank" rel="noopener noreferrer">medscape.com</a>.</li>
  <li>U.S. Food and Drug Administration. <em>FDA Clears First Device to Enable Automated Insulin Dosing in Individuals With Type 2 Diabetes.</em> Tlačová správa, 26. augusta 2024. <a href="https://www.fda.gov/news-events/press-announcements/fda-clears-first-device-enable-automated-insulin-dosing-individuals-type-2-diabetes" target="_blank" rel="noopener noreferrer">fda.gov</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Číselné údaje z metaanalýzy a z dialyzačnej štúdie pochádzajú zo štruktúrovaných abstraktov a plného znenia v PMC; bibliografické údaje všetkých citácií boli overené cez PubMed a Crossref k 17. októbru 2026. Dátum a obsah rozhodnutia FDA z roku 2024 boli overené priamo v tlačovej správe agentúry.</p>

<p>Oproti bežným sekundárnym zhrnutiam tejto témy tu boli doplnené alebo opravené štyri veci. Metaanalýza zahŕňa <strong>deväť štúdií a 714 dospelých</strong>, pričom veľkosť účinku na čas v rozmedzí je +18,43 percentuálneho bodu – vágne „zlepšenie“ nahrádza konkrétne číslo s intervalom spoľahlivosti a hodnotením istoty dôkazu. Doplnený je <strong>prírastok hmotnosti o 1,58 kg</strong>, ktorý sa v prehľadoch tejto témy takmer nikdy neuvádza, hoci je pre kardiometabolickú rozvahu podstatný. Konštatovanie, že „dve štúdie zahŕňali dialyzovaných“, je rozvinuté na skutočný obsah tej z nich, ktorá bola na dialyzovanú populáciu priamo zameraná, aj s jej číslami a obmedzeniami. A napokon je doplnená nefrologická fyziológia, ktorá robí z tejto populácie osobitný prípad – znížený klírens inzulínu, cyklus dialyzačných a nedialyzačných dní a nespoľahlivosť HbA1c, pre ktorú má čas v cieľovom rozmedzí vyššiu výpovednú hodnotu než samotný HbA1c. Tvrdenie výrobcu o deväťnásobne rýchlejšej detekcii upchatia je označené ako neoverený marketingový údaj.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu">Kontinuálne monitorovanie glukózy pri diabete 2. typu bez inzulínu</a></li>
  <li><a href="article.php?slug=stitna-zlaza-diabetes-oblicky-hba1c-glykemia">Štítna žľaza, diabetes a obličky: HbA1c verzus skutočná glykémia</a></li>
  <li><a href="article.php?slug=cas-v-cielovom-rozmedzi-hba1c-tlak-renalne-vysledky-accord">Čas v cieľovom rozmedzí HbA1c a tlaku a renálne výsledky (ACCORD)</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">CKD pri diabete: skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=diabeticka-choroba-obliciek-bez-zahad">Diabetická choroba obličiek bez záhad</a></li>
  <li><a href="article.php?slug=pecenovo-cieleny-inzulin-hdv-hypoglykemia-dm1">Pečeňovo cielený inzulín a hypoglykémia</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_aid_dm2_dialyza_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_aid_dm2_dialyza_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_aid_dm2_dialyza_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_aid_dm2_dialyza_2026 migration error: ' . $e->getMessage());
    }
}

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
