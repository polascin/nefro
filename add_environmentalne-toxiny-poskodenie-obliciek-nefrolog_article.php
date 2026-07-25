<?php
/**
 * add_environmentalne-toxiny-poskodenie-obliciek-nefrolog_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = 'odborne'): Environmentálne toxíny a poškodenie
 * obličiek — praktický rámec pre nefrológa (olovo, kadmium, ortuť, arzén, urán,
 * PFAS, mikroplasty, bisfenol A, melamín, glyoxylová kyselina, pesticídy).
 * Slovenské odborné spracovanie. Hlavný zdroj: Strasma, Jayasundara, Anand,
 * AJKD (2026). Pôvodní autori v source_authors.php.
 * ════════════════════════════════════════════════════════════════════════════
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
    'title'        => 'Environmentálne toxíny a poškodenie obličiek: čo by mal cielene zisťovať nefrológ',
    'slug'         => 'environmentalne-toxiny-poskodenie-obliciek-nefrolog',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický rámec pre nefrológa: kedy pri nevysvetlenej tubulopatii, kryštálovej nefropatii či neprimerane rýchlom poklese eGFR cielene pátrať po environmentálnej a pracovnej expozícii. A prečo zvýšená hladina chemickej látky sama osebe nie je dôkazom príčiny CKD.',
    'content'      => <<<'HTML'
<h2>Úvod</h2>

<p>Obličky sú voči environmentálnym toxínom mimoriadne zraniteľné. Dostáva sa k nim veľká časť minútového srdcového výdaja, filtrujú značný objem plazmy a prostredníctvom tubulárnej sekrécie a reabsorpcie koncentrujú viaceré chemické látky. Niektoré toxíny sa navyše v organizme kumulujú alebo sa z neho eliminujú veľmi pomaly.</p>

<p>Expozícia olovu, kadmiu, ortuti, arzénu, priemyselným chemikáliám, pesticídom a vybraným kozmetickým prípravkom môže viesť k akútnemu poškodeniu obličiek, proximálnej tubulopatii, Fanconiho syndrómu, glomerulovému ochoreniu, nefrolitiáze alebo chronickej tubulointersticiálnej nefritíde. Pri mnohých moderných kontaminantoch však máme zatiaľ prevažne experimentálne alebo prierezové epidemiologické údaje, ktoré neumožňujú bezpečne potvrdiť príčinnú súvislosť.</p>

<p>Prehľad Anny Strasmovej, Nishada Jayasundaru a Shuchi Anandovej v časopise <em>American Journal of Kidney Diseases</em> ponúka praktický rámec na rozpoznávanie environmentálne podmienených ochorení obličiek. Jeho hlavná klinická hodnota spočíva v pripomenutí, že pracovná a environmentálna anamnéza má byť súčasťou vyšetrenia pacienta s nevysvetlenou tubulopatiou, proteinúriou alebo neprimerane rýchlym poklesom eGFR.</p>

<h2>Metodika zdrojového článku</h2>

<p>Publikácia je klinicky orientovaný naratívny prehľad. Nie je systematickým prehľadom ani metaanalýzou. Autori sa zamerali najmä na:</p>

<ul>
  <li>geogénne kontaminanty, predovšetkým olovo, kadmium, ortuť, arzén a urán,</li>
  <li>priemyselné a spotrebiteľské chemikálie,</li>
  <li>perfluórované a polyfluórované alkylové látky, PFAS,</li>
  <li>bisfenol A a ďalšie fenoly,</li>
  <li>mikroplasty,</li>
  <li>melamín,</li>
  <li>prípravky na vyrovnávanie vlasov,</li>
  <li>pesticídy a herbicídy,</li>
  <li>praktické odobratie expozičnej anamnézy.</li>
</ul>

<p>Keďže nejde o systematické hodnotenie všetkých dostupných dôkazov, jednotlivé odporúčania treba posudzovať podľa kvality podkladových štúdií. Silné toxikologické dôkazy existujú najmä pri olove, kadmiu, ortuti a pri niektorých akútnych intoxikáciách. Pri PFAS, bisfenole A, mikroplastoch a chronickej expozícii pesticídom je klinická kauzalita podstatne menej istá.</p>

<h2>Mechanizmy poškodenia obličiek</h2>

<p>Environmentálne toxíny môžu poškodzovať obličky viacerými mechanizmami:</p>

<ul>
  <li>akumuláciou v proximálnych tubuloch,</li>
  <li>oxidačným stresom a mitochondriálnou dysfunkciou,</li>
  <li>poruchou membránových transportérov,</li>
  <li>poškodením endotelových buniek a renálnej mikrocirkulácie,</li>
  <li>aktiváciou zápalových a fibrotických dráh,</li>
  <li>imunologicky sprostredkovaným glomerulovým poškodením,</li>
  <li>precipitáciou kryštálov v tubuloch,</li>
  <li>nepriamym zhoršením hypertenzie, diabetu a kardiovaskulárneho rizika.</li>
</ul>

<p>Typickým prejavom poškodenia proximálneho tubulu je nízkomolekulová proteinúria, normoglykemická glykozúria, fosfatúria, urikozúria, aminoacidúria a proximálna renálna tubulárna acidóza. Pri rozsiahlejšom poškodení vzniká úplný Fanconiho syndróm.</p>

<p>Chronická expozícia môže viesť k tubulárnej atrofii, intersticiálnej fibróze a progresívnemu poklesu GFR. Bežný močový sediment pritom môže zostať relatívne chudobný.</p>

<h2>Olovo: historický toxín, ktorý nezmizol</h2>

<h3>Zdroje expozície</h3>

<p>Napriek zákazu olovnatého benzínu zostáva olovo klinicky relevantným nefrotoxínom. Expozícia môže súvisieť s:</p>

<ul>
  <li>výrobou a recykláciou akumulátorov,</li>
  <li>zváraním, hutníctvom a stavebníctvom,</li>
  <li>starými nátermi a rekonštrukciami budov,</li>
  <li>olovenými vodovodnými rozvodmi,</li>
  <li>glazovanou keramikou,</li>
  <li>strelnicami a spracovaním oloveného streliva,</li>
  <li>nelegálne vyrábaným alkoholom,</li>
  <li>kontaminovaným korením,</li>
  <li>niektorými tradičnými liekmi a doplnkami.</li>
</ul>

<h3>Renálne prejavy</h3>

<p>Akútna intoxikácia môže vyvolať proximálnu tubulopatiu, niekedy s Fanconiho fenotypom. Chronická expozícia sa spája s tubulointersticiálnou nefritídou, hypertenziou, hyperurikémiou a dnou. V tubulárnych bunkách sa môžu objaviť charakteristické intranukleárne inklúzie.</p>

<p>Systémové prejavy zahŕňajú anémiu, bolesti brucha, periférnu neuropatiu, kognitívne poruchy a pri vyššej expozícii sivomodré sfarbenie gingiválneho okraja.</p>

<h3>Interpretácia koncentrácie olova</h3>

<p>Koncentrácia olova v krvi odráža najmä nedávnu expozíciu a čiastočne mobilizáciu zo skeletu, v ktorom je uložená väčšina telesnej zásoby. Jednorazová hodnota preto nemusí spoľahlivo vystihnúť dlhodobú expozíciu.</p>

<p>Hodnota 5 µg/dl u dospelého sa nemá interpretovať ako hranica absolútnej bezpečnosti. Pri olove nemožno stanoviť koncentráciu, pri ktorej by bolo úplne vylúčené zdravotné riziko. Rozhodnutie o ďalšom postupe musí vychádzať z intenzity expozície, klinického obrazu, trendu koncentrácií a príslušných toxikologických odporúčaní.</p>

<h3>Chelatačná liečba</h3>

<p>Chelatácia kalcium-dinátrium-EDTA sa nemá používať ako rutinná nefroprotektívna liečba pri nízkej expozícii olovu. Dôkazy o spomalení CKD pochádzajú prevažne z menšieho počtu štúdií jednej výskumnej skupiny a ich všeobecná prenositeľnosť je obmedzená.</p>

<p>EDTA môže sama poškodiť obličky. Mobilizačné testy a chelatácia preto patria do rúk klinického toxikológa. Základným opatrením je identifikácia a odstránenie zdroja expozície.</p>

<h2>Kadmium: tubulopatia, fajčenie a poškodenie kostí</h2>

<p>Kadmium sa nachádza v tabakovom dyme, priemyselných emisiách, akumulátoroch, pigmentoch, elektronickom odpade a potravinách pestovaných v kontaminovanej pôde. Tabak akumuluje kadmium, preto má fajčenie významný podiel na celkovej expozícii.</p>

<p>Kadmium sa viaže na metalotioneín, filtruje sa v glomeruloch a následne sa vychytáva proximálnymi tubulmi. Dlhodobá akumulácia môže vyvolať:</p>

<ul>
  <li>nízkomolekulovú proteinúriu,</li>
  <li>fosfatúriu a hyperkalciúriu,</li>
  <li>Fanconiho syndróm,</li>
  <li>osteomaláciu a bolesti kostí,</li>
  <li>nefrolitiázu,</li>
  <li>pokles eGFR.</li>
</ul>

<p>Historickým príkladom je choroba itai-itai v Japonsku, pri ktorej kontaminácia ryžových polí kadmiom spôsobila kombináciu tubulopatie a závažného kostného ochorenia.</p>

<p>Interpretácia kadmia v moči nie je jednoduchá. Zvýšená koncentrácia môže odrážať dlhodobú telesnú záťaž, ale pri už existujúcom tubulárnom poškodení sa môže meniť aj v dôsledku porušenej manipulácie s kadmiom a metalotioneínom. Výsledok preto treba posudzovať spolu s ukazovateľmi proximálnej tubulopatie.</p>

<h2>Ortuť: glomerulové aj tubulointersticiálne poškodenie</h2>

<p>Zdroje ortuti zahŕňajú profesionálnu expozíciu pri ťažbe zlata, priemyselné prevádzky, kontaminované ryby, niektoré tradičné lieky a neregulované kozmetické prípravky na zosvetľovanie pokožky.</p>

<p>Toxický profil závisí od chemickej formy ortuti. Organická metylortuť z rýb má najmä neurotoxický účinok. Elementárna a anorganická ortuť sa výraznejšie spájajú s poškodením obličiek.</p>

<p>Renálne prejavy môžu zahŕňať:</p>

<ul>
  <li>membranóznu nefropatiu,</li>
  <li>minimálne zmeny glomerulov,</li>
  <li>nefrotický syndróm,</li>
  <li>proximálnu tubulopatiu,</li>
  <li>akútnu alebo chronickú tubulointersticiálnu nefritídu.</li>
</ul>

<p>Pri sekundárnej membranóznej nefropatii súvisiacej s ortuťou môže byť imunohistologický a sérologický obraz odlišný od primárnej PLA2R-asociovanej membranóznej nefropatie. Základom liečby je ukončenie expozície. O chelatácii a prípadnej imunosupresii treba rozhodovať individuálne v spolupráci s toxikológom a nefrológom.</p>

<h2>Arzén: dôležitá je chemická forma</h2>

<p>Chronická expozícia anorganickému arzénu môže pochádzať z kontaminovanej podzemnej vody, priemyslu, pesticídov, tradičných prípravkov alebo potravín pestovaných v kontaminovaných oblastiach.</p>

<p>Prejavy zahŕňajú hyperpigmentácie a keratózy dlaní a chodidiel, polyneuropatiu a zvýšené riziko niektorých malignít. Renálne asociácie zahŕňajú proteinúriu a proximálnu tubulopatiu, dôkazy o samostatnom príčinnom vzťahu k incidencii CKD však nie sú konzistentné.</p>

<p>Celková koncentrácia arzénu v moči môže byť výrazne zvýšená po konzumácii morských plodov, ktoré obsahujú prevažne menej toxické organické formy arzénu. Pred vyšetrením je preto potrebné dodržať laboratórne pokyny, prípadne vykonať špeciáciu arzénu. Bez nej môže vzniknúť falošná diagnóza toxickej expozície anorganickému arzénu.</p>

<h2>Urán, oxid kremičitý a ďalšie geogénne látky</h2>

<p>Urán môže poškodzovať proximálne tubuly, predovšetkým pri vyššej chemickej expozícii. Epidemiologické údaje o jeho vplyve na eGFR sú však nejednotné. Je potrebné odlišovať chemickú toxicitu uránu od rizika ionizujúceho žiarenia.</p>

<p>Oxid kremičitý, fluoridy a vanád sa skúmajú ako možné faktory CKD neznámej etiológie. Ich samostatný kauzálny význam nebol spoľahlivo potvrdený. Pri ochoreniach poľnohospodárskych pracovníkov sa pravdepodobne uplatňuje kombinácia tepelného stresu, opakovanej dehydratácie, fyzickej záťaže, sociálnych podmienok a viacerých chemických expozícií.</p>

<h2>PFAS: epidemiologická asociácia nie je dôkaz kauzality</h2>

<p>PFAS sú rozsiahla skupina perzistentných priemyselných chemikálií používaných v nepriľnavých povrchoch, vodeodolných materiáloch, obaloch potravín a hasiacich penách. Nachádzajú sa vo vode, pôde, potravinách a ľudskej krvi.</p>

<p>Niektoré observačné štúdie spájajú vyššie koncentrácie PFAS s nižším eGFR. Interpretácia je však problematická. Obličky sa podieľajú na eliminácii PFAS, takže nižšia GFR môže sama viesť k vyššej sérovej koncentrácii. Ide o formu reverznej kauzality.</p>

<p>Experimentálne štúdie naznačujú oxidačný stres a poškodenie tubulárnych buniek, no klinicky použiteľný diagnostický prah PFAS pre poškodenie obličiek neexistuje. U jednotlivca preto nemožno z izolovanej koncentrácie PFAS potvrdiť, že látka spôsobila CKD.</p>

<h2>Mikroplasty: prítomnosť v obličke nie je dôkazom nefrotoxicity</h2>

<p>Mikroplasty boli identifikované v rôznych ľudských tkanivách, moči a v niektorých štúdiách aj v obličkovom tkanive. Zvieracie modely opisujú oxidačný stres, zápal a poruchy lipidového metabolizmu.</p>

<p>Zistenie častíc v tkanive však samo osebe nepreukazuje klinicky významné poškodenie obličiek. Zatiaľ chýbajú kvalitné prospektívne štúdie spájajúce presne meranú expozíciu mikroplastom s incidenciou CKD, poklesom eGFR alebo albuminúriou. Klinické testovanie mikroplastov preto nemá štandardizované miesto v nefrologickej praxi.</p>

<h2>Bisfenol A a fenoly</h2>

<p>Bisfenol A sa používa pri výrobe plastov a živíc. Experimentálne práce poukazujú na oxidačný stres, zápal a apoptózu tubulárnych buniek. Epidemiologické štúdie zaznamenali asociáciu medzi vyššou expozíciou a albuminúriou.</p>

<p>Aj tu je problémom krátky biologický polčas, kolísanie koncentrácií a možná reverzná kauzalita. Jednorazové meranie v moči nemusí vystihovať dlhodobú expozíciu a nie je použiteľné na stanovenie etiológie CKD u konkrétneho pacienta.</p>

<p>Fenolové chemické peelingy môžu pri rozsiahlej aplikácii vyvolať systémovú toxicitu. Pri nevysvetlenom AKI treba preto zisťovať aj nedávne kozmetické procedúry.</p>

<h2>Melamín a kryštálová nefropatia</h2>

<p>Melamín môže spolu s kyselinou kyanurovou vytvárať zle rozpustné kryštály, ktoré vedú k obštrukcii tubulov, zápalu, nefrolitiáze a AKI. Významná masová expozícia nastala v roku 2008 po kontaminácii dojčenskej výživy v Číne.</p>

<p>Pri podozrení na melamínovú toxicitu je dôležitá informácia o kontaminovanej potrave alebo profesionálnej expozícii. Dôkazy o tom, že nízka bežná environmentálna expozícia spôsobuje CKD v populácii, zatiaľ nie sú presvedčivé.</p>

<h2>Prípravky na chemické vyrovnávanie vlasov: dôležité terminologické spresnenie</h2>

<p>Zdrojový článok uvádza v súvislosti s akútnou oxalátovou nefropatiou „glykolovú kyselinu“. Novšie klinické a experimentálne práce však identifikujú ako rozhodujúcu zložku najmä <strong>kyselinu glyoxylovú</strong>, ktorá sa môže po transdermálnej absorpcii metabolizovať na oxalát.</p>

<p>Po aplikácii prípravku sa môžu v priebehu hodín objaviť nauzea, vracanie, bolesti brucha alebo chrbta a prudký vzostup kreatinínu. Biopsia môže preukázať intratubulárne kryštály kalciumoxalátu, najlepšie viditeľné v polarizovanom svetle.</p>

<p>Pojmy kyselina glykolová a kyselina glyoxylová nie sú synonymá. Z klinického hľadiska je preto vhodné zisťovať konkrétne zloženie použitého prípravku, nie iba všeobecnú informáciu o vlasovej kozmetike.</p>

<h2>Pesticídy a CKD neznámej etiológie</h2>

<p>Akútne otravy paraquatom, glyfosátovými prípravkami a ďalšími pesticídmi môžu spôsobiť AKI. Pri paraquate sa uplatňuje intenzívny oxidačný stres, mitochondriálne poškodenie a apoptóza tubulárnych buniek. Glyfosátové formulácie môžu poškodiť obličky priamo aj nepriamo prostredníctvom hypotenzie, metabolickej acidózy a systémovej toxicity.</p>

<p>Pri chronickej expozícii sú dôkazy menej jednoznačné. Štúdie poľnohospodárskych pracovníkov sú komplikované súčasným pôsobením viacerých pesticídov, tepla, dehydratácie, infekcií, prašnosti a sociálnych faktorov. Označiť pesticídy za jedinú príčinu CKD neznámej etiológie by preto bolo neprimerané.</p>

<p>Dôležitý je aj fakt, že toxicitu nemusí určovať iba deklarovaná účinná látka. Rozpúšťadlá a povrchovo aktívne látky vo formulácii môžu významne meniť absorpciu a toxický účinok.</p>

<h2>Kedy myslieť na environmentálne podmienené ochorenie obličiek</h2>

<p>Cielená expozičná anamnéza je vhodná najmä pri:</p>

<ul>
  <li>nevysvetlenej proximálnej tubulopatii,</li>
  <li>normoglykemickej glykozúrii,</li>
  <li>hypofosfatémii alebo neobjasnenej fosfatúrii,</li>
  <li>nízkomolekulovej proteinúrii,</li>
  <li>hyperurikémii a dne s tubulointersticiálnym poškodením,</li>
  <li>nevysvetlenom nefrotickom syndróme,</li>
  <li>kryštálovej nefropatii,</li>
  <li>neprimerane rýchlom poklese eGFR,</li>
  <li>CKD bez obvyklej etiológie,</li>
  <li>podobnom ochorení u spolupracovníkov alebo členov domácnosti,</li>
  <li>náhlom AKI po kozmetickom alebo alternatívnom zákroku.</li>
</ul>

<h2>Praktická expozičná anamnéza</h2>

<p>Pacienta sa treba konkrétne opýtať na:</p>

<h3>Zamestnanie</h3>

<p>Aktuálne aj predchádzajúce povolania, prácu s batériami, kovmi, pigmentmi, keramikou, elektronikou, pesticídmi, rozpúšťadlami, hasiacimi penami a odpadom.</p>

<h3>Domáce a voľnočasové expozície</h3>

<p>Rekonštrukcie starých budov, strelnice, výrobu keramiky, zváranie, prácu so starými automobilmi, olovené strelivo a glazované nádoby.</p>

<h3>Vodu a potraviny</h3>

<p>Zdroj pitnej vody, vlastnú studňu, konzumáciu veľkých dravých rýb, nelegálneho alkoholu, tradičnej keramiky, dovážaného korenia a potravín z kontaminovaných oblastí.</p>

<h3>Lieky, doplnky a kozmetiku</h3>

<p>Tradičné lieky, necertifikované výživové doplnky, prípravky na zosvetľovanie kože, chemické peelingy a prípravky na vyrovnávanie vlasov.</p>

<h3>Časovú súvislosť</h3>

<p>Začiatok expozície, jej trvanie, používanie ochranných pomôcok, akútne nehody a výskyt podobných ťažkostí u ďalších osôb.</p>

<h2>Laboratórne a histologické hodnotenie</h2>

<p>Základné vyšetrenie môže zahŕňať:</p>

<ul>
  <li>kreatinín, eGFR a močovinu,</li>
  <li>sodík, draslík, chloridy a bikarbonát,</li>
  <li>vápnik, fosfor, horčík a kyselinu močovú,</li>
  <li>krvný obraz,</li>
  <li>močový sediment,</li>
  <li>pomer albumín/kreatinín a proteín/kreatinín v moči,</li>
  <li>vyšetrenie normoglykemickej glykozúrie,</li>
  <li>frakčné exkrécie elektrolytov,</li>
  <li>podľa dostupnosti β2-mikroglobulín alebo iné markery proximálnej tubulopatie.</li>
</ul>

<p>Toxikologické vyšetrenia sa majú voliť podľa konkrétnej anamnézy. Neindikované rozsiahle „panely ťažkých kovov“ prinášajú riziko náhodných a nesprávne interpretovaných nálezov.</p>

<p>Pri podozrení na kryštálovú nefropatiu má význam vyšetrenie močového sedimentu a biopsie v polarizovanom svetle. Biopsia môže odhaliť tubulointersticiálne poškodenie, glomerulopatiu, kryštály alebo inklúzie, ale zriedka sama identifikuje konkrétny toxín bez podpornej anamnézy a analytického dôkazu.</p>

<h2>Liečba</h2>

<p>Základom liečby chronickej environmentálnej nefrotoxicity je:</p>

<ol>
  <li>identifikácia zdroja,</li>
  <li>okamžité prerušenie alebo maximálne obmedzenie expozície,</li>
  <li>pracovné a hygienické opatrenia,</li>
  <li>liečba AKI a elektrolytových porúch,</li>
  <li>kontrola krvného tlaku a albuminúrie,</li>
  <li>nefroprotektívna liečba podľa bežných indikácií,</li>
  <li>konzultácia s klinickým toxikológom alebo pracovným lekárom.</li>
</ol>

<p>Chelatačná liečba je vhodná iba pri vybraných intoxikáciách. Nevhodná chelatácia môže vyvolať hypokalciémiu, poškodenie obličiek alebo redistribúciu toxínu. Komerčné provokačné testy po podaní chelátora bez jasnej indikácie nemožno považovať za spoľahlivú diagnostiku chronickej intoxikácie.</p>

<h2>Nefrologická interpretácia dôkazov</h2>

<p>Environmentálna nefrológia má závažný metodický problém: koncentrácia chemickej látky v krvi alebo moči môže byť príčinou ochorenia, ale aj následkom zníženej GFR alebo zmenenej tubulárnej manipulácie.</p>

<p>Prierezová asociácia medzi vyššou koncentráciou látky a nižším eGFR preto nepreukazuje kauzalitu. Dôveryhodnejšie hodnotenie vyžaduje:</p>

<ul>
  <li>prospektívny dizajn,</li>
  <li>opakované merania expozície,</li>
  <li>biologicky prijateľný mechanizmus,</li>
  <li>vzťah medzi dávkou a účinkom,</li>
  <li>konzistentnosť medzi populáciami,</li>
  <li>histologickú alebo experimentálnu podporu,</li>
  <li>zlepšenie po odstránení expozície,</li>
  <li>vylúčenie reverznej kauzality a reziduálneho skreslenia.</li>
</ul>

<p>Pri posudzovaní jednotlivého pacienta je najsilnejšia kombinácia presvedčivej expozície, kompatibilného klinického fenotypu, časovej súvislosti a objektívneho analytického alebo histologického dôkazu.</p>

<h2>Limity súčasných poznatkov</h2>

<p>Najdôležitejšie limity zahŕňajú:</p>

<ul>
  <li>nedostatok toxikologických údajov pre tisíce používaných chemikálií,</li>
  <li>súčasnú expozíciu viacerým látkam,</li>
  <li>rozdiely medzi akútnou a celoživotnou expozíciou,</li>
  <li>nepresnosť jednorazových krvných a močových meraní,</li>
  <li>spätné ovplyvnenie koncentrácie toxínu poklesom GFR,</li>
  <li>nedostatok prospektívnych populačných štúdií,</li>
  <li>obmedzenú prenositeľnosť zvieracích experimentov na človeka,</li>
  <li>sociálne a pracovné faktory spojené s expozíciou,</li>
  <li>nedostatok validovaných diagnostických prahov.</li>
</ul>

<p>Zvlášť opatrne treba interpretovať tvrdenia o mikroplastoch, PFAS a nízkych dávkach spotrebiteľských chemikálií. Pri týchto látkach je biologické podozrenie oprávnené, ale individuálnu príčinu CKD väčšinou nemožno spoľahlivo dokázať.</p>

<h2>Záver</h2>

<p>Environmentálne a pracovné expozície sú pravdepodobne podceňovanou súčasťou etiológie ochorení obličiek. Najsilnejšie dôkazy o nefrotoxicite existujú pri olove, kadmiu, ortuti a niektorých akútnych intoxikáciách. Pri PFAS, bisfenole A, mikroplastoch a chronickej pesticídovej expozícii zostáva rozsah klinického rizika neistý.</p>

<p>Nefrológ by mal cielene odoberať expozičnú anamnézu pri nevysvetlenej tubulopatii, kryštálovej nefropatii, proteinúrii, nefrotickom syndróme alebo neprimerane rýchlom poklese eGFR. Diagnózu nemožno založiť iba na náhodne zvýšenej koncentrácii chemickej látky. Potrebná je súvislosť medzi expozíciou, biologickým mechanizmom, klinickým fenotypom a objektívnym dôkazom poškodenia.</p>

<p>Najdôležitejšou liečbou zostáva odstránenie expozície. Chelatácia a ďalšie špecifické postupy patria do rúk skúseného toxikológa a nefrológa.</p>

<h2>Zdroje</h2>

<h3>Hlavný zdroj</h3>

<p>Anna Strasma, Nishad Jayasundara, Shuchi Anand. <em>Environmental Threats to Kidney Health: A Clinician’s Guide to Modern Exposures.</em> American Journal of Kidney Diseases. Publikované online 30. marca 2026. DOI: 10.1053/j.ajkd.2025.11.017. <a href="https://www.ajkd.org/article/S0272-6386(26)00823-1/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></p>

<h3>Doplnkové odborné zdroje</h3>

<p>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International (2024); 105(4S): S117–S314. DOI: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">kdigo.org</a></p>

<p>World Health Organization. <em>Preventing Disease Through Healthy Environments: A Global Assessment of the Burden of Disease From Environmental Risks.</em> Ženeva: WHO; 2016. <a href="https://www.who.int/publications/i/item/9789241565196" target="_blank" rel="noopener noreferrer">who.int</a></p>

<p>Agence nationale de sécurité sanitaire de l’alimentation, de l’environnement et du travail (ANSES). <em>Opinion on the Renal Toxicity of Glyoxylic Acid in Hair-Straightening Products.</em> 2024. <a href="https://www.anses.fr/en/content/alert-confirmed-glyoxylic-acid-hair-straightening-products" target="_blank" rel="noopener noreferrer">anses.fr</a></p>

<p>Centers for Disease Control and Prevention, National Institute for Occupational Safety and Health (NIOSH). <em>Lead in the Workplace.</em> <a href="https://www.cdc.gov/niosh/lead/about/index.html" target="_blank" rel="noopener noreferrer">cdc.gov</a></p>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
