<?php
/**
 * Odborne a jazykovo revidovaný článok o gentamycínovej vestibulotoxicite.
 *
 * Text je syntézou viacerých odborných zdrojov a odporúčaní. Nejde o
 * spracovanie jednej publikácie, preto sa autori citovaných prác
 * nepridávajú do source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Gentamycínová vestibulotoxicita: rozpoznanie, diagnostika a manažment',
    'slug'         => 'gentamycinova-vestibulotoxicita-ckd-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Gentamycín môže poškodiť vestibulárny systém aj bez poruchy sluchu. U pacientov s chronickou chorobou obličiek a u dialyzovaných pacientov sú kľúčové kumulatívna expozícia, včasná diagnostika a rehabilitácia.',
    'content'      => <<<'HTML'
<p><strong>Gentamycín môže poškodiť periférny vestibulárny systém a vyvolať závažnú, niekedy trvalú obojstrannú poruchu rovnováhy.</strong> Nemusí ju sprevádzať strata sluchu, tinnitus ani typické rotačné vertigo. Varovnými príznakmi sú najmä novovzniknutá neistota pri chôdzi, zhoršenie stability v tme alebo na nerovnom povrchu a oscilopsia – ilúzia rozmazávania, poskakovania alebo pohybu zrakového obrazu pri chôdzi či pohybe hlavy.</p>

<p>U pacientov s chronickou chorobou obličiek (CKD) a u dialyzovaných pacientov treba riziko posudzovať podľa dávkovacieho režimu, správne načasovaných sérových koncentrácií, trvania liečby a kumulatívnej dávky. Jednotlivá koncentrácia v cieľovom rozmedzí toxicitu nevylučuje. Pri podozrení je potrebné bezodkladne prehodnotiť ďalšie podávanie gentamycínu, objektivizovať vestibulárny deficit, predchádzať pádom a začať individuálne vedenú vestibulárnu rehabilitáciu.</p>

<h2>Gentamycín nie je iba nefrotoxický a kochleotoxický</h2>

<p>Aminoglykozidová toxicita sa v klinickej praxi často spája najmä s poškodením obličiek a stratou sluchu. Gentamycín má však výrazný vestibulotoxický potenciál. Pri pomaly vznikajúcej, približne symetrickej obojstrannej strate vestibulárnej funkcie nemusí byť prítomné výrazné rotačné vertigo ani spontánny nystagmus.</p>

<p>V retrospektívnom súbore Ishiyamovej a spoluautorov malo všetkých <strong>35 pacientov</strong> s gentamycínovou ototoxicitou poruchu rovnováhy a 33 z 35 oscilopsiu. Iba päť pacientov udávalo vertigo a iba traja si všimli zhoršenie sluchu. Pätnásť z 35 pacientov malo v čase podávania gentamycínu zlyhanie obličiek. Neprítomnosť poruchy sluchu teda nevylučuje závažnú gentamycínovú vestibulotoxicitu. <a href="#odborny-zdroj-1">[1]</a></p>

<h2>Ako sa vestibulotoxicita prejavuje</h2>

<p>Typickým klinickým obrazom je obojstranná vestibulárna hypofunkcia. Pacient môže opisovať:</p>

<ul>
  <li>neistotu alebo pocit „plávania“ pri chôdzi,</li>
  <li>zhoršenie stability v tme a na nerovnom povrchu,</li>
  <li>oscilopsiu pri chôdzi alebo pohybe hlavy,</li>
  <li>ťažkosti pri rýchlom otočení hlavy, na schodoch alebo v rušnom vizuálnom prostredí,</li>
  <li>pády alebo situácie, pri ktorých pacient takmer spadne,</li>
  <li>výraznú závislosť od zrakovej kontroly pri pohybe.</li>
</ul>

<p>Pacient môže byť pri sedení alebo ležaní v pokoji takmer bez príznakov. Tento súbor ťažkostí je typický pre bilaterálnu vestibulopatiu; samotné príznaky však diagnózu nepotvrdzujú. Konsenzuálne diagnostické kritériá Bárány Society vyžadujú aj objektívne preukázanie obojstranne zníženej alebo chýbajúcej funkcie vestibulo-okulárneho reflexu (VOR) a vylúčenie inej diagnózy, ktorá ťažkosti vysvetľuje lepšie. <a href="#odborny-zdroj-2">[2]</a></p>

<h2>Prečo porucha funkcie obličiek zvyšuje riziko</h2>

<p>Gentamycín sa vylučuje prevažne nezmenený glomerulárnou filtráciou. Pri poklese funkcie obličiek sa predlžuje jeho eliminačný polčas a rastie riziko akumulácie. SmPC uvádza ako významné rizikové faktory ototoxicity predexistujúcu poruchu funkcie obličiek alebo poškodenie VIII. hlavového nervu; riziko rastie s celkovou a dennou dávkou a pri súbežnom podávaní ďalších ototoxických látok. Vyšší vek je zároveň dôvodom zvýšenej opatrnosti a intenzívnejšieho monitorovania, najmä pre zmeny renálnej eliminácie. <a href="#odborny-zdroj-3">[3]</a></p>

<h3>Terapeutické monitorovanie musí rešpektovať dávkovací režim</h3>

<p>Cieľové koncentrácie nemožno prenášať medzi rozdielnymi režimami. Nasledujúce hodnoty sú prevzaté z citovaného SmPC Gentamicin B. Braun; <strong>1 µg/ml zodpovedá 1 mg/l</strong>.</p>

<div class="table-responsive" role="region" aria-label="Koncentrácie gentamycínu podľa dávkovacieho režimu v citovanom SmPC" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Dávkovací režim</th>
      <th scope="col">Koncentrácia podľa SmPC</th>
      <th scope="col">Dôležitá interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Dvakrát denne</th>
      <td>Minimálna koncentrácia pred ďalšou dávkou ≤ 2 mg/l</td>
      <td>Odber musí byť správne načasovaný tesne pred nasledujúcou dávkou.</td>
    </tr>
    <tr>
      <th scope="row">Raz denne</th>
      <td>Minimálna koncentrácia pred ďalšou dávkou ≤ 1 mg/l</td>
      <td>SmPC neodporúča režim raz denne pri závažnom zlyhávaní obličiek.</td>
    </tr>
    <tr>
      <th scope="row">Konvenčné viacnásobné denné dávkovanie</th>
      <td>Maximálna koncentrácia po podaní nemá prekročiť 10–12 mg/l</td>
      <td>Táto hranica neplatí pre režim raz denne; pri ňom SmPC uvádza terapeutické maximálne koncentrácie 20–30 mg/l.</td>
    </tr>
  </tbody>
</table>
</div>

<p>U pacienta so závažnou poruchou funkcie obličiek alebo na dialýze sa dávka, interval, čas odberu aj interpretácia koncentrácie musia individualizovať podľa indikácie, dialyzačnej modality a príslušného protokolu terapeutického monitorovania. SmPC zároveň odporúča monitorovať renálnu, sluchovú aj vestibulárnu funkciu, vyhýbať sa predĺženej liečbe a, ak je to možné, obmedziť jej trvanie na 7 až 10 dní. <a href="#odborny-zdroj-3">[3]</a></p>

<p>Uvedené koncentrácie nie sú absolútnou hranicou bezpečnosti. Gentamycínová vestibulotoxicita bola opísaná aj pri odporúčaných dávkach a sérových koncentráciách. Pri opakovanej liečbe a u rizikových pacientov zostáva terapeutické monitorovanie nevyhnutné, ani ono však nedokáže spoľahlivo predpovedať individuálnu vestibulárnu náchylnosť. <a href="#odborny-zdroj-5">[5]</a></p>

<h2>Samotná minimálna koncentrácia nevystihuje kumulatívnu expozíciu</h2>

<p>V historickej retrospektívnej štúdii 23 pacientov na dlhodobej hemodialýze liečených gentamycínom vznikli u siedmich známky vestibulárnej dysfunkcie. Skupiny s toxicitou a bez toxicity sa významne líšili vekom, celkovou dávkou v mg/kg a dĺžkou liečby, nie však priemernými maximálnymi a minimálnymi koncentráciami. Regresná analýza naznačila výrazný nárast rizika pri kumulatívnej dávke približne <strong>17,5 mg/kg</strong>. <a href="#odborny-zdroj-4">[4]</a></p>

<p>Hodnota 17,5 mg/kg <strong>nie je univerzálny toxický prah</strong>. Ide o výsledok malej kohorty z roku 1978 pri vtedajšom dávkovaní a nemožno ho mechanicky preniesť na každého pacienta. Štúdia však ukazuje, že minimálnu koncentráciu treba posudzovať spolu s trvaním liečby a celkovou kumulatívnou dávkou.</p>

<h2>Ako rýchlo môže toxicita vzniknúť</h2>

<p>Neexistuje univerzálne obdobie ani dávka, po ktorých sa vestibulotoxicita objaví. Riziko rastie s opakovanou a kumulatívnou expozíciou, no individuálna náchylnosť je výrazne variabilná.</p>

<p>Chattertonová a spoluautori prospektívne merali zisk VOR pomocou videoimpulzného testu hlavy pred jednorazovou dávkou gentamycínu pri urologickom výkone a po nej. V malej štúdii sa nepreukázala štatisticky významná zmena priemerného horizontálneho zisku VOR. Druhé meranie však absolvovalo iba 24 zo 48 a tretie 17 zo 48 zaradených pacientov. Výsledok preto nevylučuje zriedkavú individuálnu toxicitu a neumožňuje priamo kvantifikovať rozdiel medzi jednorazovou a opakovanou expozíciou. <a href="#odborny-zdroj-6">[6]</a></p>

<h2>Genetická predispozícia sa týka najmä straty sluchu</h2>

<p>Varianty mitochondriálneho génu <strong>MT-RNR1</strong> sú spojené so zvýšeným rizikom aminoglykozidmi indukovanej straty sluchu. Klinické odporúčanie CPIC sa zameriava najmä na varianty:</p>

<ul>
  <li>m.1555A&gt;G,</li>
  <li>m.1494C&gt;T,</li>
  <li>m.1095T&gt;C.</li>
</ul>

<p>Pre prvé dva varianty je úroveň dôkazu vysoká, pre m.1095T&gt;C stredná. CPIC dôrazne odporúča vyhnúť sa aminoglykozidom u nositeľov variantu spojeného so zvýšeným rizikom, okrem situácie, keď závažnosť infekcie a nedostupnosť bezpečnej alebo účinnej alternatívy prevážia zvýšené riziko trvalej straty sluchu. Toto odporúčanie sa týka predovšetkým kochleárneho poškodenia; nepredstavuje dôkaz rovnako silnej genetickej predispozície k vestibulotoxicite. <a href="#odborny-zdroj-7">[7]</a></p>

<h2>Diagnostika: normálny audiogram vestibulotoxicitu nevylučuje</h2>

<p>Základom je časová súvislosť medzi expozíciou gentamycínu a novými ťažkosťami spolu s objektívnym vestibulárnym vyšetrením. Audiometria je dôležitá, ale relatívne zachovaný sluch nevylučuje ťažkú obojstrannú stratu vestibulárnej funkcie.</p>

<h3>Klinický impulzný test hlavy a vHIT</h3>

<p>Klinický impulzný test hlavy (HIT) vykonaný pri lôžku môže odhaliť korekčné sakády pri vestibulárnej hypofunkcii. Weber a spoluautori ukázali, že väčšina pacientov s čiastočnou aj úplnou obojstrannou gentamycínovou vestibulárnou stratou mala veľké zjavné korekčné sakády. <a href="#odborny-zdroj-8">[8]</a></p>

<p>Videoimpulzný test hlavy (vHIT) kvantifikuje vysokofrekvenčnú funkciu VOR a predstavuje jedno z objektívnych vyšetrení používaných pri podozrení na bilaterálnu vestibulopatiu. Jedným z alternatívnych laboratórnych kritérií Bárány Society je horizontálny zisk VOR <strong>&lt; 0,6 na oboch stranách</strong>. <a href="#odborny-zdroj-2">[2]</a></p>

<h3>Kalorické a rotačné vyšetrenie</h3>

<p>Kalorické vestibulárne vyšetrenie hodnotí najmä nízkofrekvenčnú odpoveď horizontálnych polkruhovitých kanálikov. Jedným z alternatívnych laboratórnych kritérií bilaterálnej vestibulopatie je súčet maximálnych rýchlostí pomalej fázy nystagmu pri teplej a studenej stimulácii <strong>&lt; 6°/s na každej strane</strong>. Rotačné vyšetrenie hodnotí inú frekvenčnú oblasť VOR a môže poskytnúť ďalší objektívny doklad jeho obojstrannej poruchy; výsledok treba hodnotiť spolu s klinickým syndrómom a ostatnými diagnostickými kritériami. <a href="#odborny-zdroj-2">[2]</a></p>

<h3>Doplnkové vyšetrenia</h3>

<p>Cervikálne a okulárne vestibulárne evokované myogénne potenciály (cVEMP a oVEMP) poskytujú informácie o otolitových orgánoch. Dynamická zraková ostrosť zachytáva funkčný dôsledok poruchy VOR. Tieto vyšetrenia môžu diagnostiku doplniť, nie sú však základnými kritériami definitívnej bilaterálnej vestibulopatie. <a href="#odborny-zdroj-2">[2]</a></p>

<h2>Praktický postup pri podozrení</h2>

<ol>
  <li><strong>Myslieť na gentamycín aj bez straty sluchu alebo rotačného vertiga.</strong></li>
  <li><strong>Bezodkladne prehodnotiť ďalšie podávanie.</strong> Ak to klinická a mikrobiologická situácia umožňuje, ukončiť podávanie gentamycínu alebo ho nahradiť účinnou a podľa možnosti neototoxickou alternatívou.</li>
  <li>Overiť presné dávkovanie, čas poslednej dávky, interval, správnosť načasovania sérových odberov, trvanie liečby a kumulatívnu dávku v mg/kg.</li>
  <li>Zohľadniť funkciu obličiek, dialyzačnú modalitu, predchádzajúcu liečbu aminoglykozidmi a súbežné nefrotoxické alebo ototoxické lieky.</li>
  <li>Vykonať klinický HIT a čo najskôr objektivizovať vestibulárnu funkciu, spravidla pomocou vHIT a podľa dostupnosti kalorického alebo rotačného vyšetrenia.</li>
  <li>Doplniť audiometriu; normálny audiometrický nález nepovažovať za dôkaz neprítomnosti vestibulotoxicity.</li>
  <li>Začať cielenú vestibulárnu rehabilitáciu a aktívnu prevenciu pádov.</li>
  <li>Do zdravotnej dokumentácie zaznamenať konkrétny liek, časovú súvislosť, dennú a kumulatívnu dávku, sérové koncentrácie a objektívny vestibulárny nález.</li>
  <li>Pri budúcich infekciách aminoglykozidy použiť iba po starostlivom zvážení prínosu a rizika, ak nie je vhodná alternatíva.</li>
</ol>

<p>Hemodialýza odstraňuje časť cirkulujúceho gentamycínu, preto môže byť relevantná pri akumulácii alebo predávkovaní. Rozhodnutie však vyžaduje individuálne farmakokinetické a nefrologické posúdenie. Zníženie sérovej koncentrácie <strong>neobnoví už poškodenú periférnu vestibulárnu funkciu</strong>. <a href="#odborny-zdroj-3">[3]</a></p>

<h2>Nie je k dispozícii antidotum ani regeneračná liečba</h2>

<p>Nie je k dispozícii antidotum ani farmakologická liečba s preukázanou schopnosťou obnoviť už stratenú periférnu vestibulárnu funkciu. Po závažnom poškodení môže deficit pretrvávať. Funkčné zlepšenie závisí najmä od centrálnej adaptácie a kompenzačného využívania zrakových a somatosenzorických podnetov. <a href="#odborny-zdroj-10">[10]</a> <a href="#odborny-zdroj-11">[11]</a></p>

<h2>N-acetylcysteín: kochleárna prevencia nie je liečbou vestibulárnej straty</h2>

<p>N-acetylcysteín (NAC) je antioxidant a prekurzor glutatiónu. Feldman a spoluautori náhodne zaradili 53 hemodialyzovaných pacientov, ktorí dostávali gentamycín pre infekciu spojenú s dialyzačným katétrom, do skupiny so samotným gentamycínom alebo do skupiny s gentamycínom a NAC <strong>600 mg perorálne dvakrát denne</strong>. Protokol dokončilo 40 pacientov a priemerná dĺžka liečby bola takmer 15 dní. V skupine s NAC bola audiometricky definovaná ototoxicita menej častá. Štúdia však hodnotila sluch pomocou čistotónovej audiometrie, nie vestibulárnu funkciu. <a href="#odborny-zdroj-9">[9]</a></p>

<p>ISPD v odporúčaniach z roku 2022 navrhuje (stupeň <strong>2B</strong>) zvážiť doplnkové perorálne podávanie NAC na prevenciu aminoglykozidovej ototoxicity u pacientov s peritoneálnou dialýzou, ktorí aminoglykozid potrebujú. Podkladom sú malé randomizované štúdie hodnotiace sluchové prahy; ani jedna nehodnotila vestibulárnu funkciu. Toto odporúčanie nemožno zovšeobecniť na prevenciu gentamycínovej vestibulotoxicity ani na liečbu už vzniknutej vestibulárnej straty. <a href="#odborny-zdroj-10">[10]</a></p>

<h2>Vestibulárna rehabilitácia je základom aktívnej liečby</h2>

<p>Aktualizované klinické odporúčanie vydané Academy of Neurologic Physical Therapy uvádza silné dôkazy v prospech cielenej vestibulárnej rehabilitácie pri periférnej jednostrannej aj obojstrannej vestibulárnej hypofunkcii. Dôkazy zahŕňajú rôzne príčiny hypofunkcie, nie výlučne gentamycínovú vestibulotoxicitu. Rehabilitácia neobnovuje zničené receptory; zlepšuje stabilizáciu pohľadu, posturálnu kontrolu a funkciu prostredníctvom adaptácie, habituácie a substitučných stratégií. <a href="#odborny-zdroj-11">[11]</a></p>

<h3>Stabilizácia pohľadu</h3>

<p>Jedným zo základných cvičení je <strong>VOR × 1</strong>: pacient fixuje pohľad na nepohyblivý cieľ a súčasne vykonáva horizontálne alebo vertikálne pohyby hlavy. Fyzioterapeut musí zvoliť náročnosť, rýchlosť a rozsah podľa objektívneho nálezu, príznakov a rizika pádu.</p>

<p>Pri obojstrannej vestibulárnej hypofunkcii odporúčanie uvádza ako orientačný domáci režim cvičení stabilizácie pohľadu <strong>3- až 5-krát denne, spolu 20 až 40 minút denne približne 5 až 7 týždňov</strong>. Dôkazy o presnom dávkovaní sú slabšie než dôkazy o účinnosti samotnej rehabilitácie, preto program nemožno predpisovať mechanicky. <a href="#odborny-zdroj-11">[11]</a></p>

<h3>Tréning rovnováhy a chôdze</h3>

<p>Statický a dynamický tréning rovnováhy sa pri obojstrannej hypofunkcii odporúča minimálne 6 až 9 týždňov, pričom toto trvanie vychádza z expertného názoru. Program môže zahŕňať zúženie opornej bázy, státie na rôznych povrchoch, pohyb hlavy pri chôdzi, zmeny smeru, schody a úlohy s dvojitou motorickou alebo kognitívnou záťažou. Cvičenia so zatvorenými očami alebo vo výrazne zníženej viditeľnosti sa pri ťažkej strate majú vykonávať iba pod dohľadom alebo so spoľahlivým zabezpečením proti pádu. <a href="#odborny-zdroj-11">[11]</a></p>

<p>Izolované vôľové sakády ani plynulé sledovacie pohyby očí bez pohybu hlavy sa neodporúčajú ako samostatná liečba poruchy stabilizácie pohľadu. Cvičenia zamerané na stabilizáciu pohľadu majú zahŕňať pohyb hlavy, aby zapájali vestibulo-okulárny reflex. <a href="#odborny-zdroj-11">[11]</a></p>

<h2>Vestibulárne supresíva spravidla problém neriešia</h2>

<p>Pri chronickej obojstrannej vestibulárnej hypofunkcii nie je základným problémom nadmerná vestibulárna aktivita, ale jej nedostatok. Dlhodobé podávanie sedatívnych vestibulárnych supresív môže sťažovať kompenzáciu, zhoršovať bdelosť a zvyšovať riziko pádov, preto ho treba individuálne prehodnotiť. Tieto lieky ani iná nešpecifická symptomatická liečba nenahrádzajú cielenú vestibulárnu rehabilitáciu. <a href="#odborny-zdroj-11">[11]</a></p>

<h2>Prevencia pádov</h2>

<p>Riziko je vyššie najmä v tme, na nerovnom povrchu, pri rýchlom otočení, na schodoch a v kúpeľni. Praktické opatrenia zahŕňajú:</p>

<ul>
  <li>dobré nočné osvetlenie a odstránenie prekážok v domácnosti,</li>
  <li>bezpečnostné madlá a protišmykové úpravy,</li>
  <li>individuálne zvolenú oporu pri chôdzi,</li>
  <li>fyzioterapeutické hodnotenie rizika pádu,</li>
  <li>korekciu zraku a vhodnú obuv,</li>
  <li>revíziu liekov zhoršujúcich rovnováhu alebo bdelosť.</li>
</ul>

<h2>Prognóza</h2>

<p>Pri závažnej obojstrannej gentamycínovej vestibulotoxicite nemusí dôjsť k normalizácii periférnej vestibulárnej funkcie. Klinický stav sa však môže počas týždňov až mesiacov zlepšovať vďaka centrálnej kompenzácii a rehabilitácii. Výsledok ovplyvňujú vek, periférna neuropatia, porucha zraku, svalová slabosť, cerebelárne alebo iné neurologické ochorenie, kognitívne poškodenie a adherencia k rehabilitácii.</p>

<p>Ishiyamová a spoluautori upozornili, že pacienti s predexistujúcou periférnou neuropatiou kompenzovali gentamycínovú vestibulárnu stratu horšie. U dialyzovaného pacienta s diabetickou alebo uremickou polyneuropatiou a poruchou zraku preto môžu byť funkčné dôsledky mimoriadne závažné. <a href="#odborny-zdroj-1">[1]</a></p>

<h2>Čo si z toho odniesť</h2>

<ul>
  <li><strong>Nová neistota pri chôdzi, zhoršenie v tme a oscilopsia sú varovné príznaky</strong> aj bez straty sluchu či vertiga.</li>
  <li><strong>Jednotlivá „terapeutická“ koncentrácia nevylučuje toxicitu.</strong> Hodnotiť treba dávkovací režim, čas odberu, trvanie a kumulatívnu dávku.</li>
  <li><strong>Pri podozrení treba bezodkladne prehodnotiť ďalšiu expozíciu</strong> a, ak je to z hľadiska infekcie bezpečné, ukončiť podávanie gentamycínu alebo ho nahradiť účinnou a podľa možnosti neototoxickou alternatívou.</li>
  <li><strong>Normálny audiogram nestačí.</strong> Potrebné je objektívne vestibulárne vyšetrenie.</li>
  <li><strong>NAC má obmedzené údaje o prevencii audiometricky zistenej kochleárnej ototoxicity, nie o obnove vestibulárnej funkcie.</strong></li>
  <li><strong>Základom funkčnej liečby je individuálne vedená vestibulárna rehabilitácia a prevencia pádov.</strong></li>
</ul>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ambulantna-parenteralna-antimikrobialna-liecba-opat">Ambulantná parenterálna antimikrobiálna liečba: bezpečná alternatíva hospitalizácie iba pri správnom výbere pacienta</a></li>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Klinický súbor:</strong> Ishiyama G, Ishiyama A, Kerber K, Baloh RW. Gentamicin ototoxicity: clinical features and the effect on the human vestibulo-ocular reflex. <em>Acta Otolaryngol.</em> 2006;126(10):1057–1061. doi: <a href="https://doi.org/10.1080/00016480600606673" target="_blank" rel="noopener noreferrer">10.1080/00016480600606673</a>. PMID 16923710. <a href="https://pubmed.ncbi.nlm.nih.gov/16923710/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Diagnostický konsenzus:</strong> Strupp M, Kim JS, Murofushi T, et al. Bilateral vestibulopathy: Diagnostic criteria. Consensus document of the Classification Committee of the Bárány Society. <em>J Vestib Res.</em> 2017;27(4):177–189. doi: <a href="https://doi.org/10.3233/VES-170619" target="_blank" rel="noopener noreferrer">10.3233/VES-170619</a>. PMID 29081426, PMCID PMC9249284. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9249284/" target="_blank" rel="noopener noreferrer">Plný text</a>. Erratum: <em>J Vestib Res.</em> 2023;33(1):87, doi: <a href="https://doi.org/10.3233/VES-229002" target="_blank" rel="noopener noreferrer">10.3233/VES-229002</a>, PMID 36336950.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. Liekové informácie:</strong> Gentamicin B. Braun 1 mg/ml a 3 mg/ml infúzny roztok. Súhrn charakteristických vlastností lieku, revízia 05/2024. <a href="https://www.sukl.sk/gentamicin-b.-braun-3-mg-ml-infuzny-roztok-80181" target="_blank" rel="noopener noreferrer">ŠÚKL</a>. Paralelne overené v britskom <a href="https://www.medicines.org.uk/emc/product/15154/smpc" target="_blank" rel="noopener noreferrer">SmPC</a>. Prístup 24. augusta 2026.</em></small></p>

<p id="odborny-zdroj-4"><small><em><strong>4. Hemodialyzačná kohorta:</strong> Gailiunas P Jr, Dominguez-Moreno M, Lazarus M, et al. Vestibular toxicity of gentamicin. Incidence in patients receiving long-term hemodialysis therapy. <em>Arch Intern Med.</em> 1978;138(11):1621–1624. doi: <a href="https://doi.org/10.1001/archinte.138.11.1621" target="_blank" rel="noopener noreferrer">10.1001/archinte.138.11.1621</a>. PMID 309753. <a href="https://pubmed.ncbi.nlm.nih.gov/309753/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-5"><small><em><strong>5. Dávka a sérové koncentrácie:</strong> Halmagyi GM, Fattore CM, Curthoys IS, Wade S. Gentamicin vestibulotoxicity. <em>Otolaryngol Head Neck Surg.</em> 1994;111(5):571–574. doi: <a href="https://doi.org/10.1177/019459989411100506" target="_blank" rel="noopener noreferrer">10.1177/019459989411100506</a>. PMID 7970794. <a href="https://pubmed.ncbi.nlm.nih.gov/7970794/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-6"><small><em><strong>6. Prospektívna štúdia jednorazovej dávky:</strong> Chatterton S, Wang C, Satyan H, et al. A Prospective Study on the Vestibular Toxicity of Gentamicin in a Clinical Setting. <em>Otol Neurotol.</em> 2022;43(9):e1029–e1033. doi: <a href="https://doi.org/10.1097/MAO.0000000000003663" target="_blank" rel="noopener noreferrer">10.1097/MAO.0000000000003663</a>. PMID 36026605. <a href="https://pubmed.ncbi.nlm.nih.gov/36026605/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-7"><small><em><strong>7. Farmakogenetické odporúčanie:</strong> McDermott JH, Wolf J, Hoshitsuki K, et al. Clinical Pharmacogenetics Implementation Consortium Guideline for the Use of Aminoglycosides Based on MT-RNR1 Genotype. <em>Clin Pharmacol Ther.</em> 2022;111(2):366–372. doi: <a href="https://doi.org/10.1002/cpt.2309" target="_blank" rel="noopener noreferrer">10.1002/cpt.2309</a>. PMID 34032273, PMCID PMC8613315. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8613315/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-8"><small><em><strong>8. Impulzný test hlavy:</strong> Weber KP, Aw ST, Todd MJ, et al. Horizontal head impulse test detects gentamicin vestibulotoxicity. <em>Neurology.</em> 2009;72(16):1417–1424. doi: <a href="https://doi.org/10.1212/WNL.0b013e3181a18652" target="_blank" rel="noopener noreferrer">10.1212/WNL.0b013e3181a18652</a>. PMID 19380701. <a href="https://pubmed.ncbi.nlm.nih.gov/19380701/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-9"><small><em><strong>9. Randomizovaná štúdia NAC pri hemodialýze:</strong> Feldman L, Efrati S, Eviatar E, et al. Gentamicin-induced ototoxicity in hemodialysis patients is ameliorated by N-acetylcysteine. <em>Kidney Int.</em> 2007;72(3):359–363. doi: <a href="https://doi.org/10.1038/sj.ki.5002295" target="_blank" rel="noopener noreferrer">10.1038/sj.ki.5002295</a>. PMID 17457375. <a href="https://pubmed.ncbi.nlm.nih.gov/17457375/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-10"><small><em><strong>10. Odporúčania pre peritoneálnu dialýzu:</strong> Li PKT, Chow KM, Cho Y, et al. ISPD peritonitis guideline recommendations: 2022 update on prevention and treatment. <em>Perit Dial Int.</em> 2022;42(2):110–153. doi: <a href="https://doi.org/10.1177/08968608221080586" target="_blank" rel="noopener noreferrer">10.1177/08968608221080586</a>. PMID 35264029. <a href="https://journals.sagepub.com/doi/10.1177/08968608221080586" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-11"><small><em><strong>11. Klinické odporúčanie pre rehabilitáciu:</strong> Hall CD, Herdman SJ, Whitney SL, et al. Vestibular Rehabilitation for Peripheral Vestibular Hypofunction: An Updated Clinical Practice Guideline From the Academy of Neurologic Physical Therapy of the American Physical Therapy Association. <em>J Neurol Phys Ther.</em> 2022;46(2):118–177. doi: <a href="https://doi.org/10.1097/NPT.0000000000000382" target="_blank" rel="noopener noreferrer">10.1097/NPT.0000000000000382</a>. PMID 34864777, PMCID PMC8920012. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8920012/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Doplňujúci komentár k NAC:</strong> Tepel M. N-Acetylcysteine in the prevention of ototoxicity. <em>Kidney Int.</em> 2007;72(3):231–232. doi: <a href="https://doi.org/10.1038/sj.ki.5002299" target="_blank" rel="noopener noreferrer">10.1038/sj.ki.5002299</a>. PMID 17653228. <a href="https://pubmed.ncbi.nlm.nih.gov/17653228/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, diagnostické prahy, liekové informácie a znenie odporúčaní boli overené 24. augusta 2026. Hodnota 17,5 mg/kg pochádza z malej historickej hemodialyzačnej kohorty a nie je univerzálnym toxickým prahom. Cieľová sérová koncentrácia nevylučuje vestibulotoxicitu. Údaje o NAC sa týkajú najmä prevencie audiometricky hodnotenej kochleárnej ototoxicity, nie obnovy už stratenej vestibulárnej funkcie.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie. Dávkovanie a terapeutické monitorovanie gentamycínu, ako aj rozhodnutie o prerušení alebo zmene antibiotickej liečby, musia vychádzať z miesta a závažnosti infekcie, mikrobiologického nálezu a citlivosti, funkcie obličiek, dialyzačného režimu, farmakokinetiky a platných lokálnych odporúčaní pre antibiotickú liečbu.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_gentamycinova_vestibulotoxicita',
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
