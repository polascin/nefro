<?php
/**
 * add_crevne-helmintozy-nefrologia-strongyloidoza-imunosupresia_article.php
 * Odborný článok o črevných helmintózach v nefrologickej praxi: diferenciálna
 * diagnostika, strongyloidóza pred imunosupresiou a pri transplantácii obličky,
 * liečba podľa CDC a bezpečnostné súvislosti pri zníženej funkcii obličiek.
 * Slovenské spracovanie prehľadu Medscape doplnené o vlastné nefrologické
 * rozšírenie a o primárne zdroje (CDC, AJTMH, Emerging Infectious Diseases).
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Črevné helmintózy v nefrologickej praxi: diagnostika, strongyloidóza a riziká imunosupresie',
    'slug'         => 'crevne-helmintozy-nefrologia-strongyloidoza-imunosupresia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Strongyloides stercoralis prežíva v organizme desaťročia a po nasadení kortikoidov môže prejsť do hyperinfekcie. Negatívna sérológia darcu infekciu nevylučuje: opísané sú dva prípady prenosu na príjemcov obličky.',
    'content'      => <<<'HTML'
<figure><a href="img/crevne-helmintozy-nefrologia-strongyloidoza.webp" rel="noopener noreferrer" target="_blank"><img src="img/crevne-helmintozy-nefrologia-strongyloidoza.webp" alt="Priesvitný trup v tme: v čreve svieti chladné tyrkysové ohnisko, tenké larválne dráhy stúpajú jantárovou farbou k pľúcam a vpravo sa šíri červená žiara" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie snímka konkrétneho pacienta. Zobrazuje princíp autoinfekcie a migrácie lariev <em>Strongyloides stercoralis</em> z čreva do pľúc a ďalej do organizmu – dej, ktorý sa pri potlačenej imunite môže zmeniť na hyperinfekciu.</figcaption></figure>

<p>Črevné helmintózy tvoria rôznorodú skupinu infekcií parazitickými červami. Ich klinický význam nespočíva iba v tráviacich ťažkostiach: podieľajú sa na sideropenickej anémii, malnutrícii a stratách tekutín a niektoré vyvolávajú závažné mimočrevné komplikácie. V nefrológii si osobitnú pozornosť zaslúži strongyloidóza. Dlhodobo nenápadná infekcia sa po nasadení kortikosteroidov alebo inej imunosupresívnej liečby môže v priebehu dní zmeniť na život ohrozujúce ochorenie.</p>

<p>Pri hodnotení rizika rozhoduje epidemiologická anamnéza, biologický cyklus konkrétneho parazita a stav imunity. Jednorazové negatívne parazitologické vyšetrenie stolice ani neprítomnosť eozinofílie infekciu nevylučujú – a pri transplantácii obličky nestačí ani negatívna sérológia darcu.</p>

<h2>Nie každý „červ“ je črevný helmint</h2>

<p>Medzi helminty patria hlístovce (nematódy), pásomnice (cestódy) a motolice (trematódy). Ich spôsob prenosu, lokalizácia v organizme aj citlivosť na liečbu sa zásadne líšia. Označenie „črevné parazity“ je širšie, pretože zahŕňa aj prvoky, ktoré helmintmi nie sú.</p>

<p>Od helmintóz treba odlíšiť myiázu, teda napadnutie tkanív larvami múch. Larvy druhu <em>Cochliomyia hominivorax</em>, ktoré v obrazovom prehľade uvádza aj východiskový zdroj tohto článku, nie sú črevné helminty: ide o larválne štádium muchy bzučivky, pôvodcu tkanivovej myiázy. Na rozdiel od lariev, ktoré sa živia odumretým tkanivom, požierajú živé tkanivo, merajú 6,5 až 17 mm a spôsobujú rýchlo progredujúce, bolestivé a zapáchajúce rany. Liečba spočíva v <strong>odstránení lariev a ošetrení rany</strong>, prípadne v antibiotiku na prevenciu sekundárnej stafylokokovej či streptokokovej infekcie – nie v režime určenom na črevné helmintózy. [1]</p>

<p>Zaradenie tejto témy do obrazového prehľadu parazitov preto nemožno chápať ako taxonomické zaradenie medzi črevné červy. Rozlíšenie má priamy praktický dôsledok: pri myiáze by podanie antihelmintika len oddialilo jediný účinný zákrok.</p>

<h2>Klinické prejavy treba spájať s konkrétnym pôvodcom</h2>

<p>Jednotlivé infekcie nemožno diagnostikovať podľa nešpecifickej bolesti brucha ani podľa samotného nálezu eozinofílie. Rozhoduje kombinácia expozície, životného cyklu parazita a cielene zvoleného vyšetrenia.</p>

<div class="table-responsive" role="region" aria-label="Prehľad najčastejších črevných helmintóz, ich klinických súvislostí a diagnostických upozornení" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Infekcia alebo skupina</th>
      <th scope="col">Typické klinické súvislosti</th>
      <th scope="col">Diagnostické upozornenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Enterobióza (<em>Enterobius vermicularis</em>)</th>
      <td>Najčastejší črevný parazit v mnohých krajinách; približne tretina infikovaných je bez príznakov. Dominuje nočné svrbenie v perianálnej oblasti.</td>
      <td>Vhodný je perianálny odber lepiacou páskou ráno pred umytím a defekáciou, nie vyšetrenie stolice. Liečbu treba zopakovať o dva týždne; recidívy sa uvádzajú až v 90 %.</td>
    </tr>
    <tr>
      <th scope="row">Askarióza (<em>Ascaris lumbricoides</em>)</th>
      <td>Najrozšírenejšia helmintóza na svete, odhadom 800 miliónov infikovaných. Väčšina priebehov je nenápadná; pri väčšej parazitárnej záťaži hrozí obštrukcia čreva alebo migrácia do žlčových ciest.</td>
      <td>Výpovedná hodnota vyšetrenia stolice závisí od fázy infekcie. Počas aktívnej pľúcnej fázy (Löfflerov syndróm) sa antihelmintikum nepodáva – hynúce larvy môžu vyvolať pneumonitídu.</td>
    </tr>
    <tr>
      <th scope="row">Infekcie machovcami (<em>Ancylostoma duodenale</em>, <em>Necator americanus</em>)</th>
      <td>Odhadom 576 až 740 miliónov infikovaných a popredná príčina sideropenickej anémie v rozvojových krajinách. Krv sa stráca priamo z mukóznych kapilár.</td>
      <td>Infekcia pretrváva roky (<em>A. duodenale</em> 1 až 3 roky, <em>N. americanus</em> 3 až 10 rokov). Anémiu u pacienta s expozíciou nemožno automaticky pripísať chronickej chorobe obličiek.</td>
    </tr>
    <tr>
      <th scope="row">Trichurióza (<em>Trichuris trichiura</em>)</th>
      <td>Pri intenzívnej infekcii hnačka, krvné straty a anémia.</td>
      <td>Klinická závažnosť súvisí s intenzitou infekcie, nie so samotnou pozitivitou nálezu.</td>
    </tr>
    <tr>
      <th scope="row">Strongyloidóza (<em>Strongyloides stercoralis</em>)</th>
      <td>Tráviace, kožné alebo respiračné prejavy; možná dlhoročná asymptomatická infekcia udržiavaná autoinfekciou.</td>
      <td>V stolici sa hľadajú <strong>larvy, nie vajíčka</strong>. Bežné jednorazové vyšetrenie stolice infekciu spoľahlivo nevylučuje.</td>
    </tr>
    <tr>
      <th scope="row">Črevná tenióza (<em>Taenia</em> spp.)</th>
      <td>Často mierne príznaky alebo odchod článkov pásomnice.</td>
      <td>Treba dôsledne odlíšiť črevnú infekciu od cysticerkózy (pozri nižšie).</td>
    </tr>
    <tr>
      <th scope="row">Difylobotrióza (<em>Diphyllobothrium</em> spp.)</th>
      <td>Pásomnica viaže veľké množstvo vitamínu B<sub>12</sub> a môže vyvolať megaloblastovú anémiu.</td>
      <td>Pri makrocytovej anémii s expozíciou surovým sladkovodným rybám patrí do diferenciálnej diagnostiky vedľa deficitu B<sub>12</sub> z iných príčin.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Drobná, ale často opakovaná nepresnosť: dospelé mrle (<em>E. vermicularis</em>) sídlia prevažne v céku a priľahlom hrubom čreve, nie v tenkom čreve; gravidné samice migrujú na perianálnu kožu, kde kladú vajíčka, typicky v noci. Práve z toho vyplýva zmysel perianálneho odberu – a aj to, prečo sa parazit niekedy nachádza v apendixe.</p>

<h3>Tenióza a cysticerkóza nie sú dve pomenovania tej istej choroby</h3>

<p>Pri <em>Taenia solium</em> je zámena mechanizmu prenosu klinicky zásadná. <strong>Črevná tenióza</strong> vzniká po požití životaschopných cysticerkov v nedostatočne tepelne upravenom bravčovom mäse; človek je definitívnym hostiteľom a nosí dospelú pásomnicu. <strong>Cysticerkóza</strong> vzniká po požití vajíčok <em>T. solium</em> fekálno-orálnou cestou; človek je vtedy medzihostiteľom a larvy sa usádzajú v tkanivách vrátane centrálneho nervového systému (neurocysticerkóza). Liečebný prístup sa preto líši: pri črevnej infekcii praziquantel, pri neurocysticerkóze individualizovaný postup podľa počtu, lokalizácie a životaschopnosti lézií. [1]</p>

<h2>Prečo je strongyloidóza dôležitá pre nefrológa</h2>

<p><em>Strongyloides stercoralis</em> dokáže prostredníctvom autoinfekcie pretrvávať v organizme mnoho rokov až desaťročí. Relevantný preto môže byť aj <strong>dávny</strong> pobyt v endemickej oblasti, nielen nedávna cesta – vrátane vojenskej služby, pracovného pobytu či detstva stráveného v trópoch alebo subtrópoch.</p>

<p>Pri <strong>hyperinfekčnom syndróme</strong> dochádza k výraznému zvýšeniu počtu lariev a k zosilneniu migrácie v rámci obvyklého životného cyklu, teda predovšetkým v čreve a pľúcach. <strong>Diseminovaná strongyloidóza</strong> znamená šírenie lariev aj do orgánov mimo tejto obvyklej migračnej dráhy. Oba stavy sú závažné a bývajú sprevádzané bakteriémiou či sepsou gramnegatívnymi črevnými baktériami, ktoré larvy prenášajú cez črevnú stenu.</p>

<p>CDC odporúča zvažovať testovanie na strongyloidózu najmä u osôb: [2]</p>

<ul>
  <li>pred začatím kortikosteroidnej alebo inej imunosupresívnej liečby,</li>
  <li>pred transplantáciou orgánu alebo po nej,</li>
  <li>s infekciou HTLV-1,</li>
  <li>s hematologickou malignitou,</li>
  <li>s pretrvávajúcou nevysvetlenou eozinofíliou,</li>
  <li>s anamnézou pobytu v endemickej oblasti.</li>
</ul>

<p>V nefrologickej praxi sa tieto okolnosti týkajú predovšetkým pacientov pripravovaných na transplantáciu obličky a pacientov pred imunosupresívnou liečbou glomerulárnych ochorení či systémových vaskulitíd. Samotná prítomnosť chronickej choroby obličiek však nie je dôvodom automaticky predpokladať helmintózu ani preventívne podávať antiparazitikum.</p>

<h3>Prenos darcovským orgánom: negatívna sérológia darcu nestačí</h3>

<p>V kazuistickom oznámení uverejnenom v januári 2026 v <em>Emerging Infectious Diseases</em> autori opisujú <strong>dva prípady darcom prenesenej strongyloidózy u príjemcov obličky</strong>. Sérologické vyšetrenie vzoriek darcu bolo pôvodne negatívne; prenos potvrdilo až retrospektívne testovanie. [3]</p>

<p>Oznámenie má tri praktické dôsledky. Po prvé, sérologický skríning darcu má obmedzenú citlivosť a jeho negatívny výsledok nie je dôkazom neprítomnosti infekcie. Po druhé, u darcov s epidemiologickým rizikom je namieste cielený protokol, nie rutinný jednotný postup. Po tretie, po transplantácii má zmysel aktívne sledovanie príjemcu vrátane pozornosti na nevysvetlenú eozinofíliu a na respiračné prejavy pripomínajúce Löfflerov syndróm – teda práve v období, keď imunosupresia hyperinfekciu umožňuje.</p>

<h2>Diagnostika: čo môže uniknúť rutinnému vyšetreniu</h2>

<h3>Epidemiologická anamnéza</h3>

<p>Treba cielene zisťovať krajiny pobytu počas celého života, životné a hygienické podmienky, kontakt nechránenej kože s potenciálne kontaminovanou pôdou a konzumáciu nedostatočne tepelne upravených potravín. Otázka „boli ste v poslednom čase v zahraničí?“ je pri strongyloidóze nedostatočná – rozhodujúci môže byť pobyt spred desaťročí.</p>

<h3>Eozinofília</h3>

<p>Eozinofília môže podporiť podozrenie na helmintózu, nie je však dostatočne citlivá ani špecifická. Jej neprítomnosť nevylučuje strongyloidózu, zvlášť pri závažnom priebehu alebo počas kortikosteroidnej liečby, ktorá počet eozinofilov potláča. Naopak, eozinofília môže mať liekovú, alergickú, hematologickú alebo inú príčinu; v nefrológii patrí do diferenciálnej diagnostiky aj akútna intersticiálna nefritída a cholesterolová embolizácia.</p>

<h3>Vyšetrenie stolice a sérológia</h3>

<p>Výber vyšetrenia musí vychádzať z predpokladaného pôvodcu. Pri strongyloidóze sa v stolici hľadajú <strong>larvy</strong>, nie vajíčka – rutinné vyšetrenie na vajíčka a parazity preto infekciu systematicky podhodnocuje. Citlivosť zvyšuje opakovaný odber a použitie vhodných koncentračných alebo kultivačných metód podľa možností laboratória.</p>

<p>Sérologické vyšetrenie je užitočné pri skríningu, výsledok však treba interpretovať v klinickom kontexte. Protilátky nemusia spoľahlivo odlíšiť aktuálnu infekciu od prekonanej a pri imunosupresii môže byť protilátková odpoveď oslabená – čo zároveň vysvetľuje falošne negatívne nálezy u darcov aj u imunokompromitovaných príjemcov. [3]</p>

<p>Európske odporúčania pre neendemické krajiny (Requena-Méndez a spoluautori) považujú skríning osôb s rizikom expozície za vhodný ešte pred vznikom komplikácií a <strong>u imunosuprimovaných pacientov ho označujú za povinný</strong>. Argumentujú dostupnosťou jednoduchej diagnostickej technológie a existenciou všeobecne akceptovanej liečby s vysokou účinnosťou. [4] Konkrétny diagnostický postup pred imunosupresiou je vhodné dohodnúť s infektológom a parazitologickým laboratóriom.</p>

<h2>Liečba strongyloidózy podľa CDC</h2>

<div class="table-responsive" role="region" aria-label="Dávkovanie antiparazitickej liečby strongyloidózy podľa CDC" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klinická situácia</th>
      <th scope="col">Liek a dávkovanie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nekomplikovaná akútna alebo chronická strongyloidóza – prvá voľba</th>
      <td><strong>Ivermektín 200 µg/kg perorálne raz denne počas 1 až 2 dní</strong></td>
    </tr>
    <tr>
      <th scope="row">Nekomplikovaná infekcia – alternatíva</th>
      <td><strong>Albendazol 400 mg perorálne dvakrát denne počas 7 dní</strong></td>
    </tr>
    <tr>
      <th scope="row">Hyperinfekčný syndróm alebo diseminovaná infekcia</th>
      <td><strong>Ivermektín 200 µg/kg denne</strong>, pokiaľ vyšetrenia stolice a/alebo spúta nezostanú negatívne počas dvoch týždňov; súčasne znížiť alebo prerušiť imunosupresiu, ak je to klinicky možné</td>
    </tr>
    <tr>
      <th scope="row">Kontrola po liečbe</th>
      <td>Pri pôvodne pozitívnom náleze a pretrvávajúcich príznakoch kontrolné vyšetrenie stolice o 2 až 4 týždne po liečbe</td>
    </tr>
  </tbody>
</table>
</div>

<p>Uvedené dávkovanie zodpovedá aktuálnemu klinickému odporúčaniu CDC. [2] Závažný priebeh vyžaduje hospitalizáciu a spoluprácu infektológa, intenzivistu a nefrológa. Ileus alebo malabsorpcia môžu narušiť vstrebávanie a tým aj účinnosť perorálneho podania; neštandardné spôsoby podania opisované pri kritických stavoch nemožno považovať za rutinnú ambulantnú alternatívu.</p>

<p>Pred ivermektínom treba zhodnotiť riziko súbežnej infekcie <em>Loa loa</em> podľa geografickej anamnézy – CDC uvádza potvrdenú alebo suspektnú loázu medzi kontraindikáciami spolu s hmotnosťou pod 15 kg a graviditou či dojčením. Pri albendazole sa uvádza precitlivenosť na benzimidazoly, vyhnutie sa podaniu v prvom trimestri gravidity a opatrnosť počas dojčenia. [2]</p>

<h2>Nefrologické súvislosti a bezpečnosť liečby</h2>

<h3>Akútne poškodenie obličiek</h3>

<p>Hnačka, vracanie a znížený príjem tekutín môžu viesť k hypovolémii a k akútnemu poškodeniu obličiek. Pri sepse sprevádzajúcej hyperinfekciu je poškodenie obličiek spravidla multifaktoriálne. Tekutinová liečba musí zohľadňovať diurézu, stav hydratácie, srdcovú funkciu a prípadnú potrebu náhrady funkcie obličiek.</p>

<h3>Anémia</h3>

<p>Pri anémii treba odlíšiť renálnu zložku od nedostatku železa a od krvných strát. Epidemiologicky pravdepodobná infekcia machovcami môže byť jednou z príčin sideropénie, nie však univerzálnym vysvetlením anémie u dialyzovaného pacienta. Pri makrocytóze treba zvážiť aj difylobotriózu. Pred eskaláciou liečby erytropoézu stimulujúcimi látkami má zmysel vylúčiť odstrániteľnú príčinu strát.</p>

<h3>Dávkovanie antiparazitík pri zníženej funkcii obličiek</h3>

<p>Dávkovacie pravidlá nemožno prenášať medzi jednotlivými antiparazitikami. Pri ivermektíne je z farmakokinetického hľadiska podstatné, že sa metabolizuje v pečeni prevažne cestou CYP3A4 a že sa liečivo aj jeho metabolity vylučujú takmer výlučne stolicou – <strong>močom sa vylúči menej než 1 % podanej dávky</strong>. [5] Výrazná zmena expozície pri zníženej funkcii obličiek sa preto neočakáva, formálne farmakokinetické štúdie u pacientov s pokročilou chronickou chorobou obličiek alebo na dialýze však chýbajú.</p>

<p>Pozornosť si vyžadujú liekové interakcie. Ivermektín je substrátom CYP3A4 a zároveň substrátom P-glykoproteínu, čo je pri transplantovaných pacientoch relevantné: kalcineurínové inhibítory sa metabolizujú tou istou enzýmovou cestou a cyklosporín pôsobí ako inhibítor P-glykoproteínu. Klinicky významná interakcia nie je dobre zdokumentovaná, pri súbežnom podávaní je však namieste sledovanie hladín imunosupresíva aj klinickej tolerancie. Po transplantácii môže hnačka alebo porucha vstrebávania sama osebe zmeniť expozíciu imunosupresívam.</p>

<p>Dostupnosť a registrované indikácie konkrétnych prípravkov na Slovensku treba pri predpisovaní overiť v aktuálnej databáze ŠÚKL. Medzinárodné klinické odporúčanie samo osebe nepotvrdzuje miestnu registráciu ani dostupnosť lieku.</p>

<h2>Ako postupovať pred imunosupresiou</h2>

<p>Praktický postup začína zhodnotením epidemiologického rizika a príznakov. Pri relevantnej expozícii treba myslieť na strongyloidózu <strong>aj bez eozinofílie</strong> a zabezpečiť primerané vyšetrenie ešte pred začatím liečby, ak to klinická situácia umožňuje.</p>

<ol>
  <li>Zisti celoživotnú geografickú anamnézu pacienta, nielen cesty za posledný rok.</li>
  <li>Pri relevantnej expozícii indikuj sérológiu a opakované cielené vyšetrenie stolice na larvy, nie rutinné vyšetrenie na vajíčka a parazity.</li>
  <li>Výsledky interpretuj s vedomím, že negatívny nález infekciu nevylučuje, zvlášť pri už prebiehajúcej imunosupresii.</li>
  <li>Pri plánovanej transplantácii zohľadni aj epidemiologické riziko darcu a po výkone sleduj príjemcu. [3]</li>
  <li>O preventívnej liečbe pri vysokom riziku a nejednoznačnej diagnostike rozhodni po konzultácii s infektológom.</li>
</ol>

<p>Ak je imunosupresia neodkladná, diagnostika nesmie nekriticky oddialiť život zachraňujúcu liečbu. Súčasne však treba bezodkladne konzultovať infektológa a individuálne rozhodnúť o potrebe predbežnej antiparazitárnej liečby.</p>

<p>Najdôležitejším rizikom, ktorému sa dá predísť, nie je prehliadnutie miernych tráviacich ťažkostí, ale <strong>podanie imunosupresie pacientovi s nerozpoznanou strongyloidózou</strong>.</p>

<h2>Limity</h2>

<p>Článok zhŕňa odporúčané postupy, nie výsledky randomizovaných štúdií. Dôkazová základňa pre skríning strongyloidózy v neendemických krajinách sa opiera prevažne o systematické prehľady a konsenzus expertov; samotní autori európskych odporúčaní upozorňujú, že na posúdenie nákladovej efektívnosti plošného skríningu migrantov sú potrebné ďalšie štúdie. [4] Údaje o darcom prenesenej strongyloidóze pochádzajú z dvoch kazuistík, ktoré dokumentujú možnosť prenosu, nie jeho frekvenciu. [3] Epidemiologické čísla o rozšírení jednotlivých helmintóz sú odhady s veľkým rozptylom.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<p><em>1. Grimm L. You've Got Worms! Common Intestinal Macroparasites. Medscape Reference, 2. októbra 2026. Recenzent Russell W. Steele, redaktor Michael Langberg. <a href="https://reference.medscape.com/p11/youve-got-worms-common-intestinal-macroparasites-2026a1000zge" target="_blank" rel="noopener noreferrer">Pôvodný obrazový prehľad</a>. Autorstvo, recenzia a dátum publikácie boli overené priamo na zdrojovej stránke.</em></p>

<p><em>2. Centers for Disease Control and Prevention. Clinical Care of Strongyloides. Inštitucionálny autor. <a href="https://www.cdc.gov/strongyloides/hcp/clinical-care/index.html" target="_blank" rel="noopener noreferrer">Klinické odporúčania CDC</a>. Dávkovanie ivermektínu a albendazolu, rizikové skupiny, kontraindikácie aj načasovanie kontrolného vyšetrenia stolice boli overené v pôvodnom znení.</em></p>

<p><em>3. Kohan R, Gil-Campesino H, García Rodríguez IO, Lara M. Donor Screening Failure for Strongyloides stercoralis in Solid Organ Transplantation. Emerging Infectious Diseases. 2026;32(1):153–155. <a href="https://doi.org/10.3201/eid3201.251483" target="_blank" rel="noopener noreferrer">DOI: 10.3201/eid3201.251483</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/41544241/" target="_blank" rel="noopener noreferrer">PubMed, PMID 41544241</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12870113/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>4. Requena-Méndez A, Buonfrate D, Gomez-Junyent J, Zammarchi L, Bisoffi Z, Muñoz J. Evidence-Based Guidelines for Screening and Management of Strongyloidiasis in Non-Endemic Countries. The American Journal of Tropical Medicine and Hygiene. 2017;97(3):645–652. <a href="https://doi.org/10.4269/ajtmh.16-0923" target="_blank" rel="noopener noreferrer">DOI: 10.4269/ajtmh.16-0923</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/28749768/" target="_blank" rel="noopener noreferrer">PubMed, PMID 28749768</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5590585/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>5. Informácie o lieku Stromectol (ivermektín), schválené znenie FDA, časti Klinická farmakológia a Liekové interakcie. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2022/050742s030lbl.pdf" target="_blank" rel="noopener noreferrer">Plné znenie na stránkach FDA</a>. Údaj o vylúčení menej než 1 % dávky močom a o metabolizme cestou CYP3A4 bol overený v pôvodnom dokumente.</em></p>

<p><em><strong>Poznámka k dôkazom.</strong> Bibliografické údaje zdrojov č. 3 a 4 vrátane úplného autorského zoznamu, ročníka, čísla a strán boli overené cez PubMed; plné texty oboch prác sú voľne dostupné v PubMed Central. Odporúčania CDC a znenie informácií o lieku Stromectol boli načítané priamo z pôvodných stránok. Nefrologické rozšírenie zdrojového prehľadu – kapitoly o darcovskom prenose, o akútnom poškodení obličiek, o diferenciálnej diagnostike anémie a o dávkovaní pri zníženej funkcii obličiek – je vlastným odborným spracovaním autora projektu, nie súčasťou východiskového zdroja.</em></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Transplantácia obličky: zaradenie do programu</a></li>
  <li><a href="article.php?slug=ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie">Očkovanie pri chronickej chorobe obličiek a transplantácii: vakcíny a načasovanie</a></li>
  <li><a href="article.php?slug=anca-vaskulitida-renalne-postihnutie-standardy-liecby-2026">ANCA-asociovaná vaskulitída s renálnym postihnutím: štandardy liečby</a></li>
  <li><a href="article.php?slug=ttv-biomarker-imunosupresia-transplantacia-oblicky">Torque teno vírus ako biomarker miery imunosupresie po transplantácii obličky</a></li>
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
                error_log('add_zelatina_idh newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_zelatina_idh pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_zelatina_idh pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_crevne_helmintozy migration error: ' . $e->getMessage());
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
