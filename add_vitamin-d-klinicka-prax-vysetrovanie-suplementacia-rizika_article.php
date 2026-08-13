<?php

/**
 * Vitamín D v klinickej praxi so zameraním na indikácie vyšetrenia,
 * preventívnu suplementáciu, CKD-MBD a bezpečnosť liečby.
 *
 * Pôvodní autori kľúčového spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Vitamín D v klinickej praxi: koho vyšetrovať, komu ho podávať a kedy môže liečba škodiť',
    'slug'         => 'vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vitamín D nemožno riadiť jediným laboratórnym prahom. Článok oddeľuje populačnú prevenciu od liečby deficitu a CKD-MBD a vysvetľuje, kedy testovať, koho suplementovať a ako predísť hyperkalciémii.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Koncentrácia 25(OH)D nie je diagnóza sama osebe a vyššia dávka nie je automaticky účinnejšia. Bezpečné rozhodovanie sa začína otázkou, prečo vitamín D vyšetrujeme alebo podávame: či ide o zabezpečenie nutričného príjmu, liečbu preukázaného deficitu, prevenciu v osobitnej skupine alebo manažment minerálovej a kostnej poruchy pri chronickej chorobe obličiek.</em></p>

<p>Vitamín D je nevyhnutný pre absorpciu vápnika, homeostázu vápnika a fosfátov, mineralizáciu kostí a fyziologickú reguláciu prištítnych teliesok. Receptor pre vitamín D sa nachádza aj v mnohých ďalších tkanivách a experimentálne údaje podporujú jeho úlohu v imunite, bunkovej diferenciácii či metabolizme. Biologická vierohodnosť však sama osebe nedokazuje, že suplementácia predchádza infekciám, nádorovým ochoreniam, kardiovaskulárnym príhodám, diabetu alebo chronickej chorobe obličiek.</p>

<h2>Čo meriame a čo jednotlivé formy znamenajú</h2>

<p>Vitamín D<sub>3</sub>, cholekalciferol, vzniká v koži pôsobením ultrafialového žiarenia B a nachádza sa aj v niektorých potravinách a doplnkoch. Vitamín D<sub>2</sub>, ergokalciferol, pochádza najmä z húb alebo z UV ožiareného ergosterolu v kvasinkách. Obe formy sa môžu použiť ako zdroj vitamínu D, hoci cholekalciferol spravidla zvyšuje a udržiava koncentráciu 25(OH)D účinnejšie.</p>

<p>V pečeni sa vitamín D hydroxyluje na <strong>25-hydroxyvitamín D, 25(OH)D alebo kalcidiol</strong>. Je to hlavný cirkulujúci metabolit a štandardný ukazovateľ zásobenia organizmu. V obličkách sa prostredníctvom 1α-hydroxylázy tvorí <strong>1,25-dihydroxyvitamín D, 1,25(OH)<sub>2</sub>D alebo kalcitriol</strong>. Túto premenu regulujú parathormón, fibroblastový rastový faktor 23, vápnik, fosfáty a funkcia obličiek. Lokálna aktivácia prebieha aj v niektorých extrarenálnych tkanivách.</p>

<p>Najdôležitejšie praktické rozlíšenie je preto jednoduché: 25(OH)D informuje najmä o dostupnosti substrátu, zatiaľ čo kalcitriol je aktívny hormón. Koncentrácia 25(OH)D sama nevyjadruje celú aktivitu osi vitamín D – vápnik – fosfáty – PTH.</p>

<h2>Najprv treba určiť, o akú klinickú otázku ide</h2>

<p>Odporúčanie Endocrine Society z roku 2024 je zamerané na <strong>prevenciu ochorení u osôb bez inej stanovenej indikácie</strong> na liečbu alebo vyšetrovanie. Empirickú suplementáciu definuje ako príjem nad referenčný nutričný príjem bez predchádzajúceho stanovenia 25(OH)D. Nejde o univerzálny návod na diagnostiku a liečbu osteomalácie, rachitídy, hypokalciémie, osteoporózy, hypoparatyreózy, malabsorpcie ani CKD-MBD.</p>

<p>Následná oprava odporúčania spresnila dve dôležité formulácie. Zdravým dospelým mladším ako 75 rokov sa neodporúča empirická suplementácia <strong>nad referenčný nutričný príjem</strong> na prevenciu ochorení. Nejde teda o zákaz vitamínu D v strave alebo o popretie bežnej nutričnej potreby. Odporúčanie z roku 2024 zároveň nahrádza staršie odporúčanie Endocrine Society z roku 2011; pôvodné prahy sa nemajú automaticky prenášať do populačnej prevencie.</p>

<h2>Rutinný skríning zdravých ľudí nemá preukázaný prínos</h2>

<p>Endocrine Society navrhuje nevykonávať rutinné stanovenie 25(OH)D u zdravých asymptomatických dospelých. Rovnaký záver platí pre inak zdravých dospelých s obezitou alebo tmavšou pigmentáciou kože, ak nemajú ďalšiu klinickú indikáciu. Dôvodom nie je tvrdenie, že veľmi nízka koncentrácia nemá význam, ale chýbajúci dôkaz, že populačný skríning a následná liečba podľa laboratórneho prahu zlepšujú klinické výsledky.</p>

<p>Koncentráciu 25(OH)D ovplyvňujú ročné obdobie, zemepisná poloha, pobyt na slnku, pigmentácia kože, telesné zloženie, príjem vitamínu D, zápal, strata väzbových proteínov, ochorenia pečene a obličiek aj použitá analytická metóda. Pri obezite môže nižšia hodnota súvisieť najmä s väčším distribučným objemom a odlišnou distribúciou vitamínu rozpustného v tukoch. Samotný výsledok preto nemožno interpretovať bez klinického kontextu.</p>

<h2>Kedy má stanovenie 25(OH)D klinický význam</h2>

<p>Odporúčanie pre populačnú prevenciu nevymenúva všetky chorobné indikácie. V klinickej praxi je vyšetrenie primerané najmä vtedy, keď výsledok môže zmeniť diagnostiku, dávku alebo bezpečnostné monitorovanie. Medzi typické situácie patria:</p>

<ul>
  <li>rachitída, osteomalácia alebo klinické podozrenie na poruchu mineralizácie,</li>
  <li>hypokalciémia, nevysvetlená hypofosfatémia alebo sekundárna hyperparatyreóza,</li>
  <li>závažná malabsorpcia, bariatrická operácia alebo výrazná malnutrícia,</li>
  <li>vybrané metabolické ochorenia kostí a opakované nízkoenergetické zlomeniny, ak výsledok ovplyvní liečbu,</li>
  <li>ochorenie alebo liečba, ktoré významne menia absorpciu či metabolizmus vitamínu D,</li>
  <li>chronická choroba obličiek, ak sa výsledok použije v celkovom hodnotení CKD-MBD,</li>
  <li>kontrola liečby preukázaného deficitu pri riziku nedostatočnej odpovede, malabsorpcie alebo toxicity.</li>
</ul>

<p>Testovanie nemá byť automatickým doplnkom preventívneho laboratórneho panelu. Pred jeho objednaním má lekár vedieť, aké rozhodnutie zmení nízky, hraničný alebo vysoký výsledok.</p>

<h2>Neexistuje jeden univerzálny cieľ pre všetkých</h2>

<p>Endocrine Society už pri zdravých osobách nepresadzuje cieľ 25(OH)D aspoň 30&nbsp;ng/ml, teda 75&nbsp;nmol/l. Klinické štúdie neurčili jednu koncentráciu, ktorá by maximalizovala všetky kostné aj extraskeletálne výsledky. To však neznamená, že celé koncentračné spektrum je biologicky rovnocenné.</p>

<p>Výbor pre výživu a potraviny (Food and Nutrition Board) amerických National Academies of Sciences, Engineering, and Medicine používa pre zdravú populáciu ako orientačný rámec hodnotu pod 12&nbsp;ng/ml, teda pod 30&nbsp;nmol/l, pri ktorej rastie riziko deficitu, a hodnotu aspoň 20&nbsp;ng/ml, teda 50&nbsp;nmol/l, ktorá je dostatočná pre väčšinu zdravých ľudí. Tieto hranice nie sú ostrými diagnostickými čiarami, univerzálnym liečebným cieľom ani cieľom pre CKD-MBD. Rozličné odborné autority a laboratóriá môžu používať odlišné kategórie.</p>

<p>Prepočet jednotiek je <strong>1&nbsp;ng/ml = 2,5&nbsp;nmol/l</strong>. Výsledok treba hodnotiť spolu s klinickým obrazom, vápnikom, fosfátmi, PTH, alkalickou fosfatázou, funkciou obličiek, nutričným stavom, absorpciou a užívanými prípravkami. Pri akútnom ochorení alebo výraznom zápale môže byť interpretácia jednorazovej hodnoty obzvlášť neistá.</p>

<h2>1,25(OH)<sub>2</sub>D nie je testom zásob vitamínu D</h2>

<p>Vyšetrovanie kalcitriolu nie je vhodné na bežné posudzovanie zásob vitamínu D. Jeho koncentrácia je tesne regulovaná a pri nutričnom deficite môže zostať normálna alebo sa zvýšiť v dôsledku stimulácie PTH. Klesať môže až pri ťažkom deficite alebo pri poruche tvorby, napríklad v pokročilej CKD.</p>

<p>Stanovenie 1,25(OH)<sub>2</sub>D patrí do cielenej diferenciálnej diagnostiky, napríklad pri podozrení na poruchu 1α-hydroxylácie, extrarenálnu tvorbu kalcitriolu pri granulomatóznom ochorení alebo lymfóme, niektoré dedičné poruchy metabolizmu fosfátov a vitamínu D či vybranú nevysvetlenú hyperkalciémiu. Ani v týchto situáciách nenahrádza súbežné vyšetrenie 25(OH)D a ostatných parametrov minerálového metabolizmu.</p>

<h2>Komu sa navrhuje empirická suplementácia</h2>

<p>Odporúčania Endocrine Society sú prevažne podmienené a optimálna dávka pre jednotlivé preventívne indikácie zostáva neistá. Výsledky štúdií preto nemožno premeniť na pravidlo „jedna dávka pre každého“.</p>

<h3>Deti a dospievajúci vo veku 1 až 18 rokov</h3>

<p>Panel navrhuje empirickú suplementáciu na prevenciu nutričnej rachitídy a pre možnosť zníženia rizika infekcií dýchacích ciest. Istota dôkazov pre jednotlivé výsledky nie je rovnaká a presná optimálna dávka nebola určená. Dojčatá mladšie ako jeden rok majú samostatné zavedené pediatrické odporúčania, ktoré odporúčanie z roku 2024 nenahrádza.</p>

<h3>Tehotné ženy</h3>

<p>Panel navrhuje empirickú suplementáciu pre možný priaznivý vplyv na riziko preeklampsie, vnútromaternicového úmrtia, predčasného pôrodu, narodenia dieťaťa malého vzhľadom na gestačný vek a novorodeneckej mortality. Štúdie používali rozdielne denné aj týždenné režimy a nepodporujú svojvoľné vysoké dávky. Rutinné testovanie 25(OH)D u inak zdravých tehotných žien sa nenavrhuje.</p>

<h3>Osoby vo veku 75 rokov a viac</h3>

<p>Empirická suplementácia sa navrhuje pre možný mierny pokles mortality. Ide o podmienené odporúčanie, nie o dôkaz výrazného predĺženia života. Denný ekvivalent dávok v analyzovaných štúdiách sa pohyboval od 400 do 3&nbsp;333&nbsp;IU a vážený priemer bol približne 900&nbsp;IU. Tento priemer opisuje štúdie, nie individuálne predpísanú cieľovú dávku.</p>

<h3>Dospelí s vysokorizikovým prediabetom</h3>

<p>Vitamín D možno zvážiť ako doplnok, nie náhradu intenzívnych režimových opatrení. Metaanalýza individuálnych údajov z troch randomizovaných štúdií zistila približne 15-percentné relatívne zníženie rizika progresie do diabetu a absolútne zníženie o 3,3 percentuálneho bodu počas troch rokov. Výsledok sa týka osôb s prediabetom, nie zdravej normoglykemickej populácie, a štúdie neumožňujú stanoviť jednu optimálnu dávku ani cieľovú koncentráciu.</p>

<h2>Zdraví dospelí mladší ako 75 rokov</h2>

<p>U zdravých dospelých mladších ako 75 rokov sa neodporúča empirická suplementácia nad referenčný nutričný príjem iba na prevenciu kardiovaskulárnych, nádorových, metabolických alebo renálnych ochorení. Veľká štúdia VITAL nepreukázala pri dávke 2&nbsp;000&nbsp;IU cholekalciferolu denne nižší výskyt invazívnych nádorov ani závažných kardiovaskulárnych príhod oproti placebu.</p>

<p>Treba rozlišovať medzi:</p>

<ul>
  <li>zabezpečením primeraného nutričného príjmu podľa veku a miestnych odporúčaní,</li>
  <li>liečbou preukázaného deficitu alebo konkrétneho ochorenia,</li>
  <li>empirickým podávaním dávok nad nutričnú potrebu na všeobecnú prevenciu nesúvisiacich chronických chorôb.</li>
</ul>

<p>Nedostatočnú oporu v klinických dôkazoch má predovšetkým tretí postup. Záver nemožno obrátiť na tvrdenie, že liečba skutočného deficitu je zbytočná.</p>

<h2>Denné dávkovanie je spravidla vhodnejšie než veľké bolusy</h2>

<p>U netehotných osôb vo veku 50 rokov a viac, ktoré majú indikáciu na suplementáciu alebo liečbu, Endocrine Society navrhuje nižšie denné dávky namiesto vysokých dávok podávaných v dlhších intervaloch. Odporúčanie je podmienené a nevylučuje každý týždenný či mesačný režim. Upozorňuje však, že pohodlnejší bolus nemusí znamenať lepší klinický výsledok.</p>

<p>V randomizovanej štúdii u 2&nbsp;256 komunitne žijúcich žien vo veku najmenej 70 rokov zvýšila jednorazová ročná dávka 500&nbsp;000&nbsp;IU cholekalciferolu výskyt pádov aj zlomenín. Tento výsledok nemožno prenášať na každý nedenný režim, jednoznačne však vyvracia predstavu, že čím vyššia jednorazová dávka, tým väčší úžitok.</p>

<p>Konkrétny liečebný režim musí zohľadniť závažnosť deficitu, vek, absorpciu, schopnosť dodržiavať liečbu, telesné zloženie, funkciu pečene a obličiek, riziko hyperkalciémie a použitý prípravok. Krátkodobá liečebná dávka pod odborným dohľadom nie je to isté ako dlhodobé nekontrolované užívanie rovnakej dávky.</p>

<h2>Vitamín D pri chronickej chorobe obličiek</h2>

<p>Pri CKD sa s poklesom funkčnej masy obličiek znižuje schopnosť tvoriť kalcitriol, stúpa FGF23, mení sa fosfátová bilancia a môže sa rozvíjať sekundárna hyperparatyreóza. Koncentrácia 25(OH)D pritom informuje najmä o zásobe substrátu, nie priamo o tvorbe kalcitriolu ani o celom fenotype CKD-MBD.</p>

<p>KDIGO navrhuje, že u pacientov s CKD G3a až G5D možno stanovenie 25(OH)D zvážiť a opakovanie riadiť východiskovou hodnotou a terapeutickými zásahmi. Deficit alebo nedostatočnosť možno korigovať postupmi používanými v bežnej populácii. Rozhodovanie však má vychádzať z trendov a zo spoločného hodnotenia:</p>

<ul>
  <li>vápnika a fosfátov,</li>
  <li>PTH a alkalickej fosfatázy,</li>
  <li>25(OH)D, ak výsledok ovplyvní manažment,</li>
  <li>funkcie obličiek, liečby a klinických známok kostnej choroby.</li>
</ul>

<p>Jednorazovo zvýšený PTH nie je automatickou indikáciou kalcitriolu. Pri progresívnom alebo pretrvávajúcom vzostupe treba najprv hľadať upraviteľné faktory, najmä hyperfosfatémiu, hypokalciémiu, vysoký príjem fosfátov a deficit vitamínu D.</p>

<h3>Nutričný vitamín D nie je zameniteľný s aktívnym vitamínom D</h3>

<p>Cholekalciferol a ergokalciferol dopĺňajú substrát. Kalcitriol a analógy receptora pre vitamín D pôsobia priamo, účinnejšie tlmia PTH, ale zároveň zvyšujú riziko hyperkalciémie a hyperfosfatémie. U dospelých s CKD G3a až G5 bez dialýzy sa kalcitriol ani analógy vitamínu D nemajú používať rutinne. KDIGO považuje za rozumné rezervovať ich najmä pre CKD G4 až G5 so závažnou a progresívnou sekundárnou hyperparatyreózou.</p>

<p>U dialyzovaných pacientov vyžadujúcich zníženie PTH možno podľa klinickej situácie použiť kalcimimetikum, kalcitriol, analóg vitamínu D alebo ich kombináciu. Výber sa má riadiť trendmi PTH, vápnika a fosfátov, súbežnou liečbou a rizikom nežiaducich účinkov. Nadmerná supresia PTH môže podporovať adynamickú kostnú chorobu.</p>

<h2>Vitamín D nie je preukázaná univerzálna renoprotektívna liečba</h2>

<p>Nízke koncentrácie 25(OH)D sa v observačných štúdiách spájajú s albuminúriou, rýchlejším poklesom glomerulovej filtrácie a vyššou mortalitou. Asociáciu však môžu vysvetľovať alebo zosilňovať zápal, obezita, nižšia fyzická aktivita, proteinúria, malnutrícia a samotná závažnosť ochorenia.</p>

<p>V štúdii VITAL-DKD u 1&nbsp;312 dospelých s diabetom 2. typu neviedlo podávanie 2&nbsp;000&nbsp;IU vitamínu D<sub>3</sub> denne počas piatich rokov k významnému zachovaniu eGFR oproti placebu. Rutinnú suplementáciu preto nemožno prezentovať ako renoprotektívnu liečbu porovnateľnú s kontrolou krvného tlaku, blokádou systému renín – angiotenzín, inhibítormi SGLT2 alebo účinnou liečbou diabetu.</p>

<p>Pri CKD má vitamín D jasné miesto v korekcii deficitu a v individualizovanom manažmente CKD-MBD. To je odlišný terapeutický cieľ od všeobecnej prevencie progresie CKD.</p>

<h2>Kedy môže liečba škodiť</h2>

<p>Vitamín D je rozpustný v tukoch a pri nadmernom príjme doplnkov môže vyvolať intoxikáciu. Hlavným mechanizmom je hyperkalciémia, často sprevádzaná hyperkalciúriou. Klinické prejavy zahŕňajú:</p>

<ul>
  <li>nechutenstvo, nauzeu, vracanie a zápchu,</li>
  <li>svalovú slabosť, únavu a neuropsychiatrické poruchy,</li>
  <li>polyúriu, polydipsiu a dehydratáciu,</li>
  <li>nefrolitiázu, nefrokalcinózu alebo akútne poškodenie obličiek,</li>
  <li>poruchy rytmu a kalcifikáciu mäkkých tkanív pri ťažkej intoxikácii.</li>
</ul>

<p>Horná tolerovateľná hranica dlhodobého príjmu pre zdravého dospelého podľa uvedeného výboru je 4&nbsp;000&nbsp;IU denne. Nie je to hranica, pod ktorou je každý režim bezpečný, ani zákaz krátkodobej vyššej liečebnej dávky pod dohľadom. Toxicita sa typicky spája s veľmi vysokou koncentráciou 25(OH)D, často nad 150&nbsp;ng/ml, teda 375&nbsp;nmol/l, ale klinické rozhodovanie sa má riadiť najmä hyperkalciémiou, dávkou, trvaním a individuálnou náchylnosťou.</p>

<p>Zvýšenú opatrnosť vyžadujú granulomatózne ochorenia a niektoré lymfómy s extrarenálnou tvorbou kalcitriolu, primárna hyperparatyreóza, poruchy degradácie vitamínu D, nefrolitiáza, súbežné vysoké dávky vápnika, liečba tiazidmi a pokročilá CKD. Pri CKD je riziková najmä nekontrolovaná kombinácia cholekalciferolu, kalcitriolu alebo analógov vitamínu D a kalciových viazačov fosfátov.</p>

<p>Praktickou príčinou predávkovania býva súbeh viacerých prípravkov: pacient môže osobitne užívať vitamín D, multivitamín, kombináciu s vápnikom aj liek na predpis. Kontrola musí preto zahŕňať celkovú dávku zo všetkých zdrojov, nie iba jeden produkt.</p>

<h2>Pobyt na slnku nie je presne dávkovateľná liečba</h2>

<p>Kožná syntéza závisí od zemepisnej šírky, ročného obdobia, denného času, veku, pigmentácie kože, oblečenia, oblačnosti a ďalších faktorov. Nemožno stanoviť univerzálny čas expozície, ktorý by každému zabezpečil rovnakú tvorbu vitamínu D bez zvýšenia rizika poškodenia kože.</p>

<p>Odporúčanie nechráneného opaľovania alebo solária ako liečby deficitu nie je vhodné. UV žiarenie je karcinogénne a nadmerné slnenie nevedie k typickej intoxikácii vitamínom D, no zvyšuje dermatologické riziko. Ak je suplementácia indikovaná, perorálne podanie je presnejšie kontrolovateľné.</p>

<h2>Praktický rozhodovací postup</h2>

<ol>
  <li><strong>Definujte cieľ.</strong> Ide o bežný nutričný príjem, prevenciu v osobitnej skupine, diagnostiku deficitu alebo liečbu CKD-MBD?</li>
  <li><strong>Netestujte bez následného rozhodnutia.</strong> U zdravého asymptomatického človeka výsledok často nezmení postup.</li>
  <li><strong>Pri podozrení na ochorenie vyšetrite kontext.</strong> Hodnoťte vápnik, fosfáty, PTH, alkalickú fosfatázu, funkciu obličiek, absorpciu a lieky.</li>
  <li><strong>Nezamieňajte metabolity.</strong> Na posúdenie zásob používajte 25(OH)D; 1,25(OH)<sub>2</sub>D patrí do cielenej diagnostiky.</li>
  <li><strong>Skontrolujte všetky zdroje dávky.</strong> Započítajte multivitamíny, kombinácie s vápnikom aj lieky na predpis.</li>
  <li><strong>Uprednostnite primeraný režim.</strong> Veľké bolusy nemajú automatickú výhodu a môžu byť škodlivé.</li>
  <li><strong>Pri CKD sledujte trendy.</strong> Izolovaná hodnota 25(OH)D alebo PTH nestačí na rozhodnutie o aktívnom vitamíne D.</li>
  <li><strong>Monitorujte rizikových pacientov.</strong> Frekvenciu kontrol prispôsobte dávke, komorbiditám, renálnej funkcii, vápniku, fosfátom a odpovedi na liečbu.</li>
</ol>

<h2>Záver</h2>

<p>Vitamín D zostáva nenahraditeľnou súčasťou kostného a minerálového metabolizmu, ale jeho široké biologické pôsobenie nie je dôkazom univerzálneho preventívneho účinku. U zdravých asymptomatických dospelých sa rutinný skríning 25(OH)D neodporúča a dávky nad referenčný nutričný príjem nemajú slúžiť ako všeobecná prevencia chronických ochorení.</p>

<p>Empirická suplementácia má podľa Endocrine Society najlepšie odôvodnenie u detí a dospievajúcich vo veku 1 až 18 rokov, počas tehotenstva, vo veku 75 rokov a viac a ako doplnok režimových opatrení pri vysokorizikovom prediabete. Všetky tieto odporúčania treba čítať s vedomím neistoty optimálnej dávky.</p>

<p>Pri chronickej chorobe obličiek treba dôsledne rozlišovať medzi dopĺňaním nutričného vitamínu D a liečbou kalcitriolom alebo jeho analógmi. Rozhodovanie má vychádzať z trendov celého súboru parametrov CKD-MBD a z rizika hyperkalciémie, nie z jedinej hodnoty 25(OH)D.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=perzistujuca-hyperparatyreoza-po-transplantacii-oblicky">Perzistujúca hyperparatyreóza po transplantácii obličky</a></li>
  <li><a href="article.php?slug=klug-entscheiden-nefrologia-laboratorne-vysetrenia">Klug entscheiden v nefrológii: ktoré laboratórne vyšetrenia sú naozaj potrebné?</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Marie B. Demay, Anastassios G. Pittas, Daniel D. Bikle, Dima L. Diab, Mairead E. Kiely, Marise Lazaretti-Castro, Paul Lips, Deborah M. Mitchell, M. Hassan Murad, Shelley Powers, Sudhaker D. Rao, Robert Scragg, John A. Tayek, Amy M. Valent, Judith M. E. Walsh, Christopher R. McCartney.</strong> <em>Vitamin D for the Prevention of Disease: An Endocrine Society Clinical Practice Guideline.</em> The Journal of Clinical Endocrinology &amp; Metabolism. 2024;109(8):1907–1947. doi: 10.1210/clinem/dgae290. <a href="https://doi.org/10.1210/clinem/dgae290" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38828931/" target="_blank" rel="noopener noreferrer">PubMed</a>. Oprava a spresnenie: doi 10.1210/clinem/dgae854. <a href="https://doi.org/10.1210/clinem/dgae854" target="_blank" rel="noopener noreferrer">Correction</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD-MBD Update Work Group.</strong> <em>KDIGO 2017 Clinical Practice Guideline Update for the Diagnosis, Evaluation, Prevention, and Treatment of Chronic Kidney Disease–Mineral and Bone Disorder.</em> Kidney International Supplements. 2017;7:1–59. doi: 10.1016/j.kisu.2017.04.001. <a href="https://kdigo.org/guidelines/ckd-mbd/" target="_blank" rel="noopener noreferrer">KDIGO</a>. <a href="https://doi.org/10.1016/j.kisu.2017.04.001" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>JoAnn E. Manson et al.</strong> <em>Vitamin D Supplements and Prevention of Cancer and Cardiovascular Disease.</em> The New England Journal of Medicine. 2019;380(1):33–44. doi: 10.1056/NEJMoa1809944. <a href="https://doi.org/10.1056/NEJMoa1809944" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/30415629/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Ian H. de Boer et al.</strong> <em>Effect of Vitamin D and Omega-3 Fatty Acid Supplementation on Kidney Function in Patients With Type 2 Diabetes: A Randomized Clinical Trial.</em> JAMA. 2019;322(19):1899–1909. doi: 10.1001/jama.2019.17380. <a href="https://doi.org/10.1001/jama.2019.17380" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31703120/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Anastassios G. Pittas, Tetsuya Kawahara, Rolf Jorde, Bess Dawson-Hughes, Ellen M. Vickery, Edith Angellotti, Jason Nelson, Thomas A. Trikalinos, Ethan M. Balk.</strong> <em>Vitamin D and Risk for Type 2 Diabetes in People With Prediabetes: A Systematic Review and Individual Participant Data Meta-analysis of 3 Randomized Clinical Trials.</em> Annals of Internal Medicine. 2023;176(3):355–363. doi: 10.7326/M22-3018. <a href="https://doi.org/10.7326/M22-3018" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36745886/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kerrie M. Sanders, Amanda L. Stuart, Elizabeth J. Williamson, Julie A. Simpson, Mark A. Kotowicz, Doris Young, Geoffrey C. Nicholson.</strong> <em>Annual High-Dose Oral Vitamin D and Falls and Fractures in Older Women: A Randomized Controlled Trial.</em> JAMA. 2010;303(18):1815–1822. doi: 10.1001/jama.2010.594. <a href="https://doi.org/10.1001/jama.2010.594" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/20460620/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>National Institutes of Health, Office of Dietary Supplements.</strong> <em>Vitamin D: Fact Sheet for Health Professionals.</em> <a href="https://ods.od.nih.gov/factsheets/VitaminD-HealthProfessional/" target="_blank" rel="noopener noreferrer">NIH ODS</a>.</li>
  <li><strong>Medscape Reference Editorial Staff.</strong> <em>Rapid Review Quiz: Vitamin D.</em> Medscape Reference. 2026. <a href="https://reference.medscape.com/viewarticle/rapid-review-quiz-vitamin-d-2026a1000opw" target="_blank" rel="noopener noreferrer">Zdrojový kvíz</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Kľúčovým spracovaným zdrojom je opravená online verzia odporúčania Endocrine Society z roku 2024; jej bibliografické údaje a autorstvo boli overené cez Crossref a PubMed. Materiál Medscape slúžil ako tematický podnet, nie ako jediný podklad klinických tvrdení, a pri kontrole odmietal automatizovaný prístup. Odporúčania treba uplatňovať podľa individuálnej indikácie, miestnych preventívnych programov, schválených informácií o lieku a aktuálnych odborných usmernení pre konkrétne ochorenie.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika_article',
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
