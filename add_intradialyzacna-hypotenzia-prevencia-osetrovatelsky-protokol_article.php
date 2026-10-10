<?php
/**
 * add_intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol_article.php
 * Odborný článok o prevencii intradialyzačnej hypotenzie, ošetrovateľskom
 * manažmente a zásadách bezpečného protokolu na dialyzačnom pracovisku.
 * Pôvodný článok projektu – nemá jeden konkrétny spracovaný zdroj.
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
    'title'        => 'Intradialyzačná hypotenzia: prevencia, ošetrovateľský manažment a bezpečný protokol',
    'slug'         => 'intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dobrý protokol pri intradialyzačnej hypotenzii urýchľuje reakciu, nenahrádza klinické posúdenie a nemení každú epizódu na automatický sled infúzií. Súvislosť medzi poklesom tlaku a príznakmi je totiž slabá.',
    'content'      => <<<'HTML'
<figure><a href="img/intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol.webp" rel="noopener noreferrer" target="_blank"><img src="img/intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol.webp" alt="Ruka sestry už otáča ovládanie ultrafiltrácie, zatiaľ čo krivka tlaku na monitore sa začína len prelamovať nadol" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Rozhodujúci okamih nastáva skôr, než sa hodnota na monitore stane alarmujúcou. Dobrý protokol tento okamih podporuje, zlý ho odkladá na ďalšie plánované meranie.</figcaption></figure>

<p>Intradialyzačná hypotenzia (IDH) patrí medzi významné komplikácie hemodialýzy. Môže viesť k nevoľnosti, svalovým kŕčom, poruche vedomia, predčasnému ukončeniu výkonu a nedostatočnému prekrveniu orgánov. Ošetrovateľský protokol má pomôcť včas rozpoznať zhoršovanie stavu, vykonať bezprostredné bezpečnostné opatrenia a privolať lekára. Nemá však nahrádzať klinické posúdenie ani meniť každú hypotenznú epizódu na automatický sled infúzií.</p>

<p>Bezpečný postup spája predialyzačné zhodnotenie rizika, priebežné sledovanie pacienta, primeranú akútnu intervenciu a následnú revíziu dialyzačného predpisu. Rovnako dôležitá je dokumentácia príznakov, zásahov a odpovede na liečbu.</p>

<p>Tento text nadväzuje na články venované konkrétnym liekom používaným pri IDH – <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitolu</a> a <a href="article.php?slug=midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost">midodrínu</a> – a sústreďuje sa na to, čo im má v praxi predchádzať.</p>

<h2>Kedy ide o klinicky významnú hypotenziu</h2>

<p>Jednotná definícia IDH sa nepoužíva. Historická definícia KDOQI vychádza z poklesu systolického krvného tlaku najmenej o 20 mmHg alebo stredného arteriálneho tlaku najmenej o 10 mmHg, spojeného s príznakmi. Novšie prehľady dopĺňajú podmienku, že pokles vedie k orgánovej ischémii a vyžaduje protiopatrenia, napríklad zníženie ultrafiltrácie alebo infúziu fyziologického roztoku. Iné definície zohľadňujú najnižší dosiahnutý tlak alebo potrebu terapeutického zásahu. Rozdiely medzi definíciami vysvetľujú časť rozdielov v uvádzanej frekvencii IDH, ktorá sa pohybuje približne od 5 do 40 %. [1]</p>

<p>Pre klinickú prax sú podstatné tri údaje: <strong>absolútna hodnota tlaku, veľkosť a rýchlosť jeho poklesu a stav pacienta</strong>. Pokles systolického tlaku zo 170 na 145 mmHg nie je rovnakou situáciou ako pokles zo 105 na 80 mmHg.</p>

<h3>Súvislosť medzi tlakom a príznakmi je slabá</h3>

<p>Pre tvorbu protokolu je to najdôležitejšie zistenie – a zároveň najčastejšie prehliadané. Korelácia medzi zmenami krvného tlaku a klinickými príznakmi je <strong>slabá</strong>. Niektorí pacienti vykazujú známky intravaskulárnej hypovolémie <em>bez</em> toho, aby pokles tlaku splnil ktorúkoľvek číselnú definíciu. Pri výraznej kompenzačnej odpovedi sa môže objaviť dokonca paradoxný vzostup tlaku. [1]</p>

<p>Analýza Flytheovej a spoluautorov porovnala bežne používané definície IDH v kohorte 1 409 pacientov zo štúdie HEMO a 10 392 pacientov veľkej dialyzačnej organizácie. S mortalitou najsilnejšie súvisel <strong>absolútny najnižší systolický tlak pod 90 mmHg</strong>, a to celkovo aj v podskupinách s predialyzačným tlakom pod 120 a 120 až 159 mmHg; pri predialyzačnom tlaku 160 mmHg a viac to bola hranica pod 100 mmHg. Definície, ktoré vychádzali z príznakov, z vykonaných zásahov alebo zo samotného poklesu tlaku počas výkonu, s mortalitou spojené neboli. Pridanie kritéria príznakov či intervencie k hodnote najnižšieho tlaku súvislosť nijako nezosilnilo. [2]</p>

<p>Systolický tlak pod 90 mmHg je teda významným varovným nálezom. Nie je však jediným spúšťačom intervencie. Pacient s chronickou hypertenziou môže mať príznaky nedostatočnej perfúzie aj pri vyššom tlaku. Naopak, neprítomnosť príznakov nezaručuje, že výrazný pokles tlaku je neškodný – aj nenápadné asymptomatické poklesy sa spájajú s orgánovou ischémiou. [1]</p>

<p>Protokol preto nemá vyžadovať súčasné splnenie všetkých číselných kritérií pred začatím pomoci. Porucha vedomia, bolesť na hrudníku alebo známky obehového zlyhávania vyžadujú okamžitú reakciu bez čakania na ďalšie plánované meranie.</p>

<h2>Pred dialýzou: riziko treba hodnotiť v súvislostiach</h2>

<h3>Cieľová hmotnosť a aktuálny objemový stav</h3>

<p>Cieľová hmotnosť je klinický odhad, ktorý sa môže meniť po hospitalizácii, infekcii, zmene výživového stavu alebo úbytku svalovej hmoty. Nie je to nemenná hodnota, ktorú treba dosiahnuť pri každom výkone za každú cenu. Nesprávne stanovená alebo nezohľadnená zmena cieľovej hmotnosti patrí medzi uznávané príčiny IDH. [1]</p>

<p>Pred dialýzou treba zhodnotiť predialyzačnú hmotnosť, krvný tlak, pulz, príznaky kongescie a možné straty tekutín. Osobitnú pozornosť vyžadujú hnačka, vracanie, horúčka, krvácanie a znížený príjem potravy či tekutín. Celkové objemové preťaženie pritom nevylučuje vznik nedostatočného intravaskulárneho naplnenia počas ultrafiltrácie – rozpor medzi celkovým obsahom soli a vody v tele a centrálnymi plniacimi tlakmi môže byť značný. [1]</p>

<p>Metódy objektivizácie objemového stavu existujú, ale každá má svoje obmedzenia: bioimpedančná spektroskopia môže pri hypoalbuminémii mylne naznačovať odstrániteľnú tekutinu, ultrazvukové hodnotenie B-línií sa medzi platformami líši presnosťou a interpretáciou, monitorovanie objemu krvi a ultrazvuk dolnej dutej žily sa v ambulantnej dialyzačnej praxi rutinne nepoužívajú. [1] Podrobnejšie sa im venujú články o <a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">stanovení suchej váhy</a> a o <a href="article.php?slug=rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia">monitorovaní relatívneho objemu krvi</a>.</p>

<h3>Medzidialyzačný hmotnostný prírastok</h3>

<p>Medzidialyzačný hmotnostný prírastok (IDWG) sa vypočíta ako rozdiel medzi aktuálnou predialyzačnou hmotnosťou a hmotnosťou po predchádzajúcej dialýze.</p>

<p>Ak sa vyjadruje percentuálne, protokol musí uviesť použitú referenčnú hmotnosť. Hodnota nad 4 % môže slúžiť ako lokálny upozorňovací prah, nemožno ju však považovať za univerzálnu hranicu bezpečnosti ani za samostatnú diagnózu objemového preťaženia.</p>

<p><strong>IDWG nie je totožný s plánovaným objemom ultrafiltrácie.</strong> Ten závisí aj od rozdielu voči aktuálnej cieľovej hmotnosti a od očakávanej bilancie počas výkonu. Pri obmedzovaní prírastkov je rozhodujúce obmedzenie príjmu sodíka, nie samotné obmedzenie tekutín – bez neho smäd znemožní akúkoľvek snahu o nižší príjem.</p>

<h3>Rýchlosť ultrafiltrácie</h3>

<p>Priemerná rýchlosť ultrafiltrácie prepočítaná na hmotnosť sa vyjadruje ako podiel objemu ultrafiltrácie (v ml) a súčinu referenčnej hmotnosti (v kg) a času výkonu (v hodinách):</p>

<p><strong>UFR [ml/kg/h] = objem ultrafiltrácie [ml] ÷ (referenčná hmotnosť [kg] × čas [h])</strong></p>

<p>Príklad: ultrafiltrácia 2 800 ml u pacienta s referenčnou hmotnosťou 70 kg počas 4 hodín zodpovedá 2 800 ÷ (70 × 4) = 10 ml/kg/h.</p>

<p>Pri porovnávaní údajov treba používať jednotnú referenčnú hmotnosť a rozlišovať plánovanú, skutočne dosiahnutú a okamžitú rýchlosť ultrafiltrácie.</p>

<p>Hodnota nad 13 ml/kg/h je známy rizikový ukazovateľ z observačných štúdií, <strong>nie hranica, pod ktorou je ultrafiltrácia automaticky bezpečná</strong>. Riziko začína narastať už nad 10 ml/kg/h. Hypotenzia môže vzniknúť aj pri podstatne nižšej rýchlosti, najmä pri diabete, srdcovom ochorení, autonómnej dysfunkcii alebo pomalom dopĺňaní plazmatického objemu. [1]</p>

<p>Upozornenie na vysokú UFR má viesť k prehodnoteniu objemového cieľa a dĺžky výkonu. Samotné obmedzenie ultrafiltrácie bez ďalšieho plánu môže zanechať pacienta dlhodobo preťaženého tekutinou.</p>

<h3>Ďalšie rizikové faktory, ktoré patria do predialyzačného zhodnotenia</h3>

<div class="table-responsive" role="region" aria-label="Rizikové faktory intradialyzačnej hypotenzie a ich mechanizmus" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Faktor</th>
      <th scope="col">Mechanizmus</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Rýchly pokles osmolality</th>
      <td>Rýchle odstránenie močoviny vytvára prechodné osmotické gradienty a voda sa presúva z cievneho riečiska do buniek a interstícia; riziko je vyššie pri vyššej predialyzačnej osmolalite a kratšom výkone</td>
    </tr>
    <tr>
      <th scope="row">Srdcové ochorenie</th>
      <td>Nízka ejekčná frakcia, diastolická dysfunkcia, chlopňové chyby a arytmie znižujú srdcový výdaj; opakovaná IDH navyše spôsobuje omráčenie myokardu</td>
    </tr>
    <tr>
      <th scope="row">Autonómna dysfunkcia</th>
      <td>Tlmí sympatikovú odpoveď na pokles objemu, najmä pri diabete a paraproteinémiách</td>
    </tr>
    <tr>
      <th scope="row">Cievne kalcifikácie a tuhosť tepien</th>
      <td>Nedostatočná cievna odpoveď na zmeny objemu</td>
    </tr>
    <tr>
      <th scope="row">Jedlo počas výkonu</th>
      <td>Splanchnická sekvestrácia a vazodilatácia; menej výrazné pri jedlách s vyšším obsahom bielkovín</td>
    </tr>
    <tr>
      <th scope="row">Teplota dialyzátu a prostredia</th>
      <td>Teplota 37 °C a viac znižuje periférnu cievnu rezistenciu a presúva objem do rozšírených kožných ciev</td>
    </tr>
    <tr>
      <th scope="row">Prekorigovanie acidózy</th>
      <td>Veľký prísun bikarbonátu môže prispieť k poklesu tlaku; prekrýva sa s akútnym poklesom ionizovaného vápnika a kŕčmi dolných končatín</td>
    </tr>
    <tr>
      <th scope="row">Sarkopénia a telesné zloženie</th>
      <td>Nižší podiel svalovej hmoty znamená menší pohotovostný rezervoár vody</td>
    </tr>
  </tbody>
</table>
</div>

<p>Prehľad vychádza z práce Hamrahiana a spoluautorov. [1] Prepojenie kŕčov s elektrolytovými zmenami rozoberá samostatný článok o <a href="article.php?slug=krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza">kŕčoch kostrového svalstva pri dialýze</a>.</p>

<h3>Lieky, dialyzát a predchádzajúca tolerancia</h3>

<p>Pred výkonom je vhodné zaznamenať:</p>

<ul>
  <li>predchádzajúce epizódy IDH a ich časový priebeh;</li>
  <li>aktuálne užité antihypertenzíva a ďalšie hemodynamicky významné lieky;</li>
  <li>predpísané koncentrácie sodíka a vápnika v dialyzáte a jeho teplotu;</li>
  <li>plánovaný čas výkonu, objem ultrafiltrácie a prietok krvi mimotelovým okruhom;</li>
  <li>nové ochorenie, hospitalizáciu alebo zmenu klinického stavu.</li>
</ul>

<p>Antihypertenzíva sa nemajú automaticky vynechávať pred každou dialýzou. Rozhodnutie závisí od lieku, jeho indikácie, farmakokinetiky a priebehu tlaku. Problém spôsobujú predovšetkým liečivá, ktoré sa dialýzou neodstraňujú a boli užité pred výkonom; v takom prípade sa zvažuje presun dávky na večer. Osobitnú pozornosť si zasluhujú lieky s negatívnym chronotropným účinkom a alfa-blokátory, ktoré narúšajú kompenzačné mechanizmy, a to výraznejšie pri acidóze. Úlohou kontrolného zoznamu je overiť individuálny plán, nie zaviesť plošné vysadzovanie liečby. [1]</p>

<h2>Monitorovanie počas výkonu</h2>

<p>Meranie krvného tlaku každých 30 minút u stabilného pacienta a každých 15 minút u rizikového pacienta možno použiť ako organizačný rámec pracoviska. Tieto intervaly však nemožno prezentovať ako univerzálne optimálne intervaly pre všetkých pacientov.</p>

<p>Pri nových príznakoch sa tlak meria bezodkladne. Po intervencii sa kontroluje v krátkych intervaloch podľa závažnosti stavu, nie až pri ďalšom plánovanom meraní.</p>

<p>Sledovať treba aj:</p>

<ul>
  <li>pulz a prípadnú nepravidelnosť rytmu;</li>
  <li>vedomie, komunikáciu, bledosť a potenie;</li>
  <li>nevoľnosť, zívanie, slabosť, kŕče alebo závrat;</li>
  <li>dyspnoe, bolesť na hrudníku a bolesť brucha;</li>
  <li>cievny prístup, možné krvácanie a stav mimotelového okruhu.</li>
</ul>

<p>Správna veľkosť manžety a vhodná poloha končatiny sú základom spoľahlivého merania. Neočakávanú hodnotu treba overiť, ale kontrola merania nesmie odložiť pomoc pacientovi so zjavnou obehovou nestabilitou. Manžeta sa nemá rutinne prikladať na končatinu s arteriovenóznou fistulou alebo cievnou protézou.</p>

<p>Keďže súvislosť medzi číslom a príznakmi je slabá, subjektívne hodnotenie pacienta nie je doplnkom monitorovania, ale jeho rovnocennou súčasťou. [1]</p>

<h2>Akútna epizóda: najprv pacient, potom úprava predpisu</h2>

<h3>Bezprostredné opatrenia</h3>

<p>Pri symptomatickej alebo závažnej hypotenzii sa bezodkladne zastaví ultrafiltrácia, privolá pomoc podľa závažnosti stavu a zhodnotia sa základné životné funkcie. Súčasne treba preveriť krvácanie, cievny prístup a mimotelový okruh.</p>

<p>Pacienta možno uložiť do vodorovnej polohy s prípadným zdvihnutím dolných končatín, ak to toleruje. Strmá Trendelenburgova poloha nemá byť povinným krokom u každého pacienta. Pri dyspnoe, pľúcnom edéme alebo riziku aspirácie musí polohovanie rešpektovať respiračný stav.</p>

<p>Pri nereagujúcom pacientovi s neprítomným alebo abnormálnym dýchaním má prednosť aktivácia resuscitačného postupu. Bežný algoritmus IDH vtedy nestačí.</p>

<h3>Cieľom je zvládnuť epizódu bez ukončenia výkonu</h3>

<p>Prvoradým cieľom akútneho zásahu je odstrániť príznaky a nepohodu pacienta a zároveň <strong>sa vyhnúť predčasnému ukončeniu dialýzy</strong>. Je to podstatné preto, aby sa dosiahla primeraná očista a aby pacient neodchádzal z pracoviska objemovo preťažený alebo nad svojou cieľovou hmotnosťou. [1]</p>

<p>Tento cieľ stojí proti intuitívnemu riešeniu „radšej výkon ukončiť“. Predčasné ukončenie je totiž samo o sebe nepriaznivým výsledkom: vedie k nedostatočnému odstráneniu tekutiny aj uremických látok a dlhšiemu zotaveniu po dialýze. [1]</p>

<h3>Tekutinová podpora podľa klinického stavu</h3>

<p>Ak je pravdepodobnou príčinou pokles intravaskulárneho objemu, bežnou úvodnou možnosťou je opatrné podanie 0,9 % roztoku NaCl podľa schváleného postupu pracoviska alebo ordinácie lekára, s bezprostredným prehodnotením účinku. [1]</p>

<p>Protokol má určiť povolený objem jednotlivého bolusu, podmienky opakovania a okamih povinného lekárskeho prehodnotenia. Nemá povoľovať neobmedzené opakovanie infúzií bez zhodnotenia kongescie a príčiny hypotenzie.</p>

<p>Nedostatočná odpoveď na fyziologický roztok neznamená automatickú indikáciu albumínu, želatíny, manitolu alebo hypertonického NaCl. Môže upozorňovať na inú príčinu obehovej nestability. Tieto roztoky nepatria do univerzálneho eskalačného poradia – pri <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitole</a> napríklad randomizovaná štúdia nepreukázala menší pokles tlaku a registračná dokumentácia uvádza rozvinutú anúriu medzi kontraindikáciami.</p>

<h3>Zmeny dialyzátu nie sú prvým automatickým zásahom</h3>

<p>Zníženie teploty dialyzátu má v metaanalýzach najpevnejší dôkazový základ spomedzi preventívnych opatrení a patrí do dialyzačného predpisu rizikového pacienta. Zmeny koncentrácie sodíka alebo vápnika však ovplyvňujú elektrolytovú bilanciu a nemajú sa vykonávať mechanicky pri každej hypotenznej epizóde. Rutinné sodíkové profilovanie sa navyše v observačných údajoch spájalo s vyššou mortalitou. [3]</p>

<p>Úprava dialyzátu nesmie predchádzať zhodnoteniu pacienta ani odložiť zastavenie ultrafiltrácie. Musí vychádzať z ordinácie alebo z vopred schváleného postupu s jasne stanovenými kompetenciami.</p>

<p>Rovnako treba rozlišovať ultrafiltráciu a prietok krvi okruhom. <strong>Zníženie prietoku krvi nie je synonymom zastavenia odstraňovania tekutiny.</strong></p>

<h2>Kedy treba lekára privolať okamžite</h2>

<p>Bezodkladné lekárske zhodnotenie, prípadne aktiváciu urgentnej pomoci, vyžadujú najmä:</p>

<ul>
  <li>strata alebo nová porucha vedomia, kŕče či ložiskový neurologický príznak;</li>
  <li>bolesť na hrudníku, závažné dyspnoe alebo nová hypoxémia;</li>
  <li>výrazná bradykardia, tachykardia alebo podozrenie na závažnú arytmiu;</li>
  <li>známky šoku alebo pretrvávajúca hypotenzia napriek úvodným opatreniam;</li>
  <li>aktívne krvácanie alebo porucha cievneho prístupu so stratou krvi;</li>
  <li>podozrenie na anafylaxiu, hemolýzu, vzduchovú embóliu alebo inú závažnú komplikáciu výkonu;</li>
  <li>nová výrazná bolesť brucha, najmä pri neprimeranom klinickom náleze.</li>
</ul>

<p>Pri týchto stavoch sa nečaká na dokončenie celého kontrolného zoznamu. Postup pri manipulácii s okruhom a prípadnom návrate krvi musí rešpektovať podozrenie na konkrétnu komplikáciu. Rutinný návrat krvi nemusí byť pri niektorých udalostiach bezpečný.</p>

<h2>Po stabilizácii: neobnovovať ultrafiltráciu automaticky</h2>

<p>Ústup príznakov a vzostup tlaku ešte neznamenajú, že možno pokračovať pôvodnou rýchlosťou ultrafiltrácie.</p>

<p>Pred obnovením treba zhodnotiť pravdepodobnú príčinu epizódy, objem podaných tekutín, doterajšiu ultrafiltráciu, zostávajúci čas a známky kongescie. Výsledkom môže byť nižší objemový cieľ, pomalšia ultrafiltrácia, dlhší výkon alebo zmena plánu nasledujúcej dialýzy.</p>

<p>Podanú tekutinu treba zahrnúť do bilancie, <strong>nie nevyhnutne odstrániť ešte počas toho istého výkonu</strong>. Zvýšenie UFR s cieľom „dohnať“ prerušenie môže vyvolať opakovanú hypotenziu.</p>

<p>Pred odchodom sa hodnotia tlak, pulz, príznaky a tolerancia posadenia či postavenia podľa mobility pacienta. Pretrvávajúca nestabilita vyžaduje lekárske rozhodnutie o ďalšom postupe. Samotné dosiahnutie jednej prijateľnej hodnoty tlaku nie je dostatočným kritériom bezpečného odchodu.</p>

<h2>Dokumentácia, ktorá umožňuje zlepšiť ďalšiu liečbu</h2>

<p>Záznam nemá obsahovať iba formuláciu „hypotenzia, podaný fyziologický roztok“. Užitočný záznam zachytáva časový priebeh:</p>

<div class="table-responsive" role="region" aria-label="Odporúčaný obsah záznamu o epizóde intradialyzačnej hypotenzie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">Údaje na zaznamenanie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Začiatok epizódy</th>
      <td>Čas od začatia dialýzy, tlak, pulz, príznaky, vedomie</td>
    </tr>
    <tr>
      <th scope="row">Dialyzačné podmienky</th>
      <td>Aktuálna rýchlosť ultrafiltrácie, doterajší objem ultrafiltrácie, relevantné nastavenia</td>
    </tr>
    <tr>
      <th scope="row">Intervencie</th>
      <td>Čas zastavenia ultrafiltrácie, polohovanie, podané roztoky a lieky</td>
    </tr>
    <tr>
      <th scope="row">Odpoveď</th>
      <td>Opakované hodnoty tlaku a pulzu, zmena príznakov</td>
    </tr>
    <tr>
      <th scope="row">Eskalácia</th>
      <td>Čas kontaktovania lekára, ordinácie a ďalšie vyšetrenia</td>
    </tr>
    <tr>
      <th scope="row">Dokončenie výkonu</th>
      <td>Skutočný čas dialýzy, dosiahnutá ultrafiltrácia, podané tekutiny</td>
    </tr>
    <tr>
      <th scope="row">Následný plán</th>
      <td>Zmena predpisu, poučenie pacienta, potreba kontroly</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri výpočte čistej bilancie sa nemá zamieňať objem ultrafiltrácie zobrazený prístrojom s celkovou zmenou tekutinovej bilancie pacienta. Započítať treba relevantné infúzie, príjem tekutín a ďalšie vstupy či výstupy.</p>

<p>Dôsledný záznam má aj výhľadový význam. Modely strojového učenia predpovedajú IDH práve z premenných, ktoré sa pri výkone bežne zaznamenávajú – z predialyzačného systolického tlaku, priemerného systolického tlaku počas predchádzajúceho výkonu, cieľovej rýchlosti ultrafiltrácie a z výskytu IDH pri predchádzajúcej dialýze. [1] Kvalita dokumentácie tak nie je len administratívnou záležitosťou; je podmienkou toho, aby sa dala využiť.</p>

<h2>Zavedenie protokolu a priebežný audit</h2>

<p>Ošetrovateľský protokol musí jasne rozlišovať samostatné bezpečnostné opatrenia, výkony podľa vopred schváleného postupu a intervencie vyžadujúce individuálnu ordináciu. Schválenie musí zodpovedať pravidlám poskytovateľa a kompetenciám pracovníkov.</p>

<p>Pred zavedením je vhodné preveriť dokument modelovými situáciami: bežná IDH, hypotenzia s pľúcnym edémom, krvácanie z prístupu, anafylaxia a porucha vedomia. Kontroluje sa, či text neodkladá privolanie pomoci a či nevedie k nevhodným automatickým zásahom.</p>

<p>Audit má sledovať nielen počet hypotenzných epizód, ale aj potrebu záchranných tekutín, predčasné ukončenia výkonov, urgentné preklady, následnú kongesciu a opakované neplnenie objemového cieľa. <strong>Zníženie počtu IDH za cenu chronického objemového preťaženia nie je úspechom.</strong></p>

<p>Princíp opakovaného zlepšovania spočíva v cykle <strong>záznam, analýza príčiny, úprava postupu, nové hodnotenie a ďalšia revízia</strong>. Každá zmena musí mať dátum, verziu, zodpovednú osobu a schválenie. Nejde o automatické prepisovanie klinických pokynov bez odbornej kontroly.</p>

<p>Dôležitá je aj použiteľnosť dokumentu. Dve strany A4 nie sú samy osebe ukazovateľom kvality. Čitateľné písmo, neporušené tabuľky, dostatok priestoru na zápis a dobre viditeľné kritériá urgentnej eskalácie majú prednosť pred formálnym obmedzením počtu strán.</p>

<h2>Klinický záver</h2>

<p>Bezpečný manažment IDH sa neopiera o jedinú hranicu krvného tlaku ani o pevné poradie infúznych roztokov. Základom je včasné rozpoznanie zhoršenia stavu, zastavenie neprimeranej ultrafiltrácie, primeraná podpora obehu a rozpoznanie príčin, ktoré presahujú bežnú dialyzačnú hypovolémiu.</p>

<p>Pri tvorbe protokolu treba mať na pamäti dve zistenia, ktoré idú proti intuícii. Po prvé, súvislosť medzi poklesom tlaku a príznakmi je slabá, takže číselné kritérium nesmie byť podmienkou pomoci. Po druhé, cieľom nie je výkon ukončiť, ale zvládnuť epizódu tak, aby pacient neodchádzal objemovo preťažený.</p>

<p>Kvalitný ošetrovateľský protokol podporuje rýchlu reakciu a spoluprácu s lekárom. Jeho konečným cieľom nie je iba upraviť tlak počas jednej epizódy, ale zlepšiť bezpečnosť a toleranciu nasledujúcich výkonov. Trvalé riešenie opakovanej IDH je v dialyzačnom predpise – v obmedzení medzidialyzačných prírastkov, predĺžení času výkonu, znížení rýchlosti ultrafiltrácie a individualizácii predpisu podľa objemového stavu. [1]</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza lokálny protokol pracoviska, individuálne klinické rozhodnutie ani platné predpisy o kompetenciách zdravotníckych pracovníkov.</em></p>

<h2>Literatúra</h2>

<p><em>1. Hamrahian SM, Vilayet S, Herberth J, Fülöp T. Prevention of Intradialytic Hypotension in Hemodialysis Patients: Current Challenges and Future Prospects. International Journal of Nephrology and Renovascular Disease. 2023;16:173–181. <a href="https://doi.org/10.2147/IJNRD.S245621" target="_blank" rel="noopener noreferrer">DOI: 10.2147/IJNRD.S245621</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/37547077/" target="_blank" rel="noopener noreferrer">PubMed, PMID 37547077</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10404053/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>2. Flythe JE, Xue H, Lynch KE, Curhan GC, Brunelli SM. Association of Mortality Risk with Various Definitions of Intradialytic Hypotension. Journal of the American Society of Nephrology. 2015;26(3):724–734. <a href="https://doi.org/10.1681/ASN.2014020222" target="_blank" rel="noopener noreferrer">DOI: 10.1681/ASN.2014020222</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/25270068/" target="_blank" rel="noopener noreferrer">PubMed, PMID 25270068</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4341481/" target="_blank" rel="noopener noreferrer">PubMed Central</a>.</em></p>

<p><em>3. Kanbay M, Ertuglu LA, Afsar B, Ozdogan E, Siriopol D, Covic A, Basile C, Ortiz A. An update review of intradialytic hypotension: concept, risk factors, clinical implications and management. Clinical Kidney Journal. 2020;13(6):981–993. <a href="https://doi.org/10.1093/ckj/sfaa078" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ckj/sfaa078</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33391741/" target="_blank" rel="noopener noreferrer">PubMed, PMID 33391741</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7769545/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>Bibliografické údaje všetkých zdrojov boli overené cez PubMed vrátane plných textov v PubMed Central.</em></p>
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
                error_log('add_idh_protokol newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_idh_protokol pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_idh_protokol pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_idh_protokol migration error: ' . $e->getMessage());
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
