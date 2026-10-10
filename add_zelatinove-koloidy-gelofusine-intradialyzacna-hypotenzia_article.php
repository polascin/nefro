<?php
/**
 * add_zelatinove-koloidy-gelofusine-intradialyzacna-hypotenzia_article.php
 * Odborný článok o želatínových koloidoch (Gelofusine) pri intradialyzačnej
 * hypotenzii: fyzikálne vlastnosti, dôkazový základ a bezpečnostné hranice.
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
    'title'        => 'Želatínové koloidy pri intradialyzačnej hypotenzii: možnosti a hranice použitia',
    'slug'         => 'zelatinove-koloidy-gelofusine-intradialyzacna-hypotenzia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Želatína neostáva v cievach: 17 až 31 % podanej dávky prechádza do interstícia a pomer kryštaloid ku koloidu je len 1,4. V jedinej štúdii pri dialyzačnej hypotenzii zlepšila tlak u 2 z 10 pacientov, albumín u 6.',
    'content'      => <<<'HTML'
<figure><a href="img/zelatinove-koloidy-gelofusine-intradialyzacna-hypotenzia.webp" rel="noopener noreferrer" target="_blank"><img src="img/zelatinove-koloidy-gelofusine-intradialyzacna-hypotenzia.webp" alt="Koloidné častice unikajú cez stenu kapiláry do interstícia, v pozadí varovný červený záblesk – koloid v cievach nezostáva" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Predstava koloidu, ktorý zostáva v cievnom riečisku, je pri želatíne nepresná: podstatná časť podanej dávky prechádza do intersticiálneho priestoru.</figcaption></figure>

<p>Gelofusine je infúzny roztok modifikovanej želatíny používaný na náhradu objemu plazmy. Pri intradialyzačnej hypotenzii (IDH) sa niekedy zvažuje ako objemová podpora. Z fyzikálnych vlastností koloidu však nemožno automaticky odvodiť lepšiu klinickú účinnosť, menšiu celkovú tekutinovú záťaž ani priaznivejšiu bezpečnosť oproti izotonickému kryštaloidu.</p>

<p>Dostupné údaje hovoria skôr opačne. Metaanalýza 60 štúdií zistila, že 17 až 31 % podanej želatíny sa zachytáva mimo cievneho riečiska, že priemerný pomer potrebného objemu kryštaloidu ku koloidu je len 1,4 a že riziko anafylaxie je približne trojnásobné. V jedinej dohľadanej štúdii u pacientov s refraktérnou dialyzačnou hypotenziou zlepšila 4 % želatína systolický tlak u 2 z 10 pacientov, zatiaľ čo 20 % albumín u šiestich. Rozhodujúce preto zostáva rozpoznanie príčiny hypotenzie, posúdenie objemového stavu a úprava ultrafiltrácie.</p>

<p>Tento text nadväzuje na články o <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitole</a>, o <a href="article.php?slug=midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost">midodríne</a> a o <a href="article.php?slug=intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol">prevencii a ošetrovateľskom manažmente IDH</a>.</p>

<h2>Čo je Gelofusine a kam patrí</h2>

<p>Gelofusine je koloidný roztok obsahujúci 4 % sukcinylovanej želatíny, teda 40 g modifikovanej želatíny v jednom litri, spolu so 7,01 g chloridu sodného. Priemerná molekulová hmotnosť je približne 26 500 daltonov. Označuje sa ako syntetický koloid alebo náhrada objemu plazmy. Želatínová zložka má živočíšny pôvod a následne sa chemicky modifikuje; pojem „syntetický“ preto neznamená, že ide o látku bez živočíšneho pôvodu. [3]</p>

<p>Dôležitý je elektrolytový nosič: roztok obsahuje <strong>154 mmol/l sodíka a 120 mmol/l chloridov</strong>, teda sodíkovú záťaž porovnateľnú s 0,9 % roztokom NaCl. Teoretická osmolarita je 274 mosm/l. [3] Predstava, že koloid šetrí pacienta pred sodíkom, teda neobstojí: na mililiter prináša rovnako sodíka ako fyziologický roztok.</p>

<p>Koloidné roztoky nie sú jednotnou farmakologickou skupinou z hľadiska bezpečnosti a klinických výsledkov. Želatíny, ľudský albumín, dextrány a hydroxyetylškroby sa odlišujú pôvodom, štruktúrou, distribúciou, elimináciou aj nežiaducimi účinkami. Výsledky získané s jedným roztokom nemožno automaticky prenášať na ostatné.</p>

<p>Ani rôzne želatínové prípravky nie sú úplne zameniteľné. Líšia sa chemickou modifikáciou želatíny a zložením elektrolytového nosiča. Praktický rozdiel: <strong>Gelofusine vápnik neobsahuje</strong>, kým staršie prípravky na báze polygelínu áno – a práve obsah vápnika je rozhodujúci pri súbežnej citrátovej antikoagulácii. Zloženie konkrétneho prípravku preto treba overiť, nie predpokladať. [3]</p>

<h2>Prečo môže objemová podpora zvýšiť krvný tlak</h2>

<p>Pri ultrafiltrácii sa z krvného obehu odstraňuje plazmatická voda. Jej úbytok sa priebežne kompenzuje presunom tekutiny z interstícia do cievneho riečiska. Ak odstraňovanie tekutiny prebieha rýchlejšie než dopĺňanie intravaskulárneho objemu, môže klesnúť venózny návrat a srdcový výdaj.</p>

<p>Podanie tekutiny môže tento nepomer dočasne zmierniť. Koloidné molekuly zároveň prispievajú ku koloidno-osmotickému tlaku a môžu podporovať zotrvanie vody v intravaskulárnom priestore.</p>

<h3>Koloid však v cievach nezostáva</h3>

<p>Práve tu sa fyzikálna úvaha rozchádza s údajmi. Systematický prehľad a metaanalýza Moellerovej a spoluautorov zistili, že <strong>17 až 31 % podanej želatíny sa zachytáva extravaskulárne</strong>. Priemerný pomer objemu kryštaloidu k objemu koloidu potrebného na dosiahnutie rovnakého hemodynamického cieľa bol pritom len <strong>1,4</strong> – nie tri ku jednej, ako sa niekedy predpokladá. [1]</p>

<p>Z toho vyplývajú dva praktické závery. Po prvé, úspora objemu oproti kryštaloidu je malá a pri sodíkovej záťaži 154 mmol/l sa takmer celkom stráca. Po druhé, podstatná časť podanej želatíny skončí v interstíciu, odkiaľ sa pri ďalšej ultrafiltrácii odstraňuje pomaly.</p>

<p>Účinok navyše závisí od priepustnosti kapilár, funkcie srdca, východiskového objemového stavu a pokračujúcej ultrafiltrácie. Zo zloženia roztoku preto nemožno vypočítať univerzálny pomer, v ktorom nahradí kryštaloid u každého dialyzovaného pacienta.</p>

<p>Rovnako nie je správne tvrdiť, že želatína musí zvyšovať krvný tlak rýchlejšie než 0,9 % roztok NaCl. Bezprostredná odpoveď závisí aj od rýchlosti podania a príčiny hypotenzie, nielen od typu roztoku – a rýchle podanie je pri želatíne práve to, čo registračná dokumentácia pri začatí infúzie neodporúča.</p>

<h2>Hypotenzia nie je synonymom hypovolémie</h2>

<p>IDH môže vzniknúť pri relatívnom nedostatku intravaskulárneho objemu, ale aj pri nedostatočnej vazokonstrikčnej odpovedi, arytmii, ischémii myokardu alebo inom akútnom stave.</p>

<p>Pacient môže byť súčasne celkovo objemovo preťažený a mať počas ultrafiltrácie nedostatočne naplnené cievne riečisko. Naopak, nízky krvný tlak nemusí znamenať, že ďalšia tekutina bude prospešná. Komplikuje to aj zistenie, že súvislosť medzi poklesom tlaku a príznakmi je slabá. [4]</p>

<p>Pred podaním objemovej náhrady preto treba posúdiť:</p>

<ul>
  <li>priebeh tlaku, pulz a klinické príznaky;</li>
  <li>doterajší objem a rýchlosť ultrafiltrácie;</li>
  <li>známky zhoršenej perfúzie aj kongescie;</li>
  <li>možnosť arytmie, krvácania, infekcie alebo reakcie súvisiacej s dialýzou.</li>
</ul>

<p>Nedostatočná odpoveď na prvú objemovú intervenciu nemá automaticky viesť k opakovaným bolusom alebo k zmene kryštaloidu na koloid. Môže signalizovať, že príčina hypotenzie nie je primárne objemová.</p>

<h2>Aké je miesto želatíny pri IDH</h2>

<p>Pri akútnej symptomatickej IDH má prednosť bezodkladné zhodnotenie pacienta a obmedzenie alebo zastavenie ultrafiltrácie. Polohovanie a prípadná tekutinová podpora sa prispôsobujú klinickému stavu, najmä prítomnosti dyspnoe a pľúcnej kongescie.</p>

<p>Ak je potrebná objemová podpora, 0,9 % roztok NaCl predstavuje bežnú úvodnú možnosť. Ani jeho podanie však nemá byť mechanické alebo neobmedzené.</p>

<p>Želatínu nemožno zaradiť do univerzálneho algoritmu ako povinný „druhý krok“ po neúčinnosti fyziologického roztoku. Európske odporúčania síce pripúšťajú zvážiť koloidný roztok pri neodpovedi na izotonický kryštaloid, nejde však o automatický krok a od ich vydania pribudli údaje o bezpečnosti želatín. [4] Prípadné použitie musí vychádzať z individuálneho posúdenia očakávaného prínosu a rizík, z aktuálneho SPC a z postupu pracoviska.</p>

<p>Dávkovanie v rozsahu 100 až 250 ml nemožno bez konkrétneho overeného zdroja označiť za štandardnú dávku pri IDH. Registračná dokumentácia uvádza pre dospelých úvodný rozsah 500 až 1 000 ml pri schválených indikáciách, ktorými sú hypovolémia a šok, prevencia hypotenzie počas anestézie a náhrada objemu pri mimotelovom obehu. Liečba IDH medzi nimi uvedená nie je. [3]</p>

<h2>Čo možno povedať o dôkazoch</h2>

<h3>Jediná dohľadaná štúdia pri dialyzačnej hypotenzii</h3>

<p>Pilotná prospektívna skrížená štúdia Rostokera a spoluautorov z roku 2011 hodnotila rutinné infúzie 200 ml 20 % albumínu oproti 200 ml 4 % želatíny u desiatich pacientov s refraktérnou intradialyzačnou hypotenziou, ktorí nereagovali na bežné preventívne opatrenia. Sledovanie trvalo 20 týždňov. [2]</p>

<div class="table-responsive" role="region" aria-label="Výsledky skríženej štúdie albumínu a želatíny pri refraktérnej dialyzačnej hypotenzii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">20 % albumín</th>
      <th scope="col">4 % želatína</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Zlepšenie systolického tlaku</th>
      <td>u 6 z 10 pacientov</td>
      <td>u 2 z 10 pacientov</td>
    </tr>
    <tr>
      <th scope="row">Zlepšenie diastolického tlaku</th>
      <td>u 4 z 10 pacientov</td>
      <td>u 1 z 10 pacientov</td>
    </tr>
    <tr>
      <th scope="row">Iónová dialyzancia na konci výkonu</th>
      <td>zlepšená</td>
      <td>bez zmeny</td>
    </tr>
    <tr>
      <th scope="row">Kt/V a pokles relatívneho objemu krvi</th>
      <td colspan="2">stabilné počas celej štúdie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Autori uzatvárajú, že systematické podávanie koloidov zlepšuje hemodynamické ukazovatele u väčšiny pacientov náchylných na dialyzačnú hypotenziu, a že na potvrdenie týchto predbežných výsledkov sú potrebné prospektívne kontrolované štúdie. [2] Nadväzujúca práca tých istých autorov opísala priaznivý vplyv na mikrozápalový stav a oxidačný stres, pričom výraznejší pokles lipidových peroxidov sa pozoroval iba v období s albumínom. [5]</p>

<p>Pre tému tohto článku sú však podstatné tri obmedzenia. Štúdia mala desať účastníkov. Išlo o <strong>preventívne, rutinné podávanie</strong>, nie o liečbu vzniknutej hypotenznej epizódy. A v rámci nej <strong>želatína vychádza horšie než albumín</strong>, nie lepšie než kryštaloid – kryštaloidné rameno štúdia vôbec nemala.</p>

<h3>Ako čítať porovnávacie štúdie koloidov</h3>

<p>Pri posudzovaní porovnávacej štúdie treba zodpovedať tieto otázky:</p>

<div class="table-responsive" role="region" aria-label="Otázky, ktoré treba zodpovedať pri hodnotení štúdií koloidov pri dialyzačnej hypotenzii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Otázka</th>
      <th scope="col">Prečo je dôležitá</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Išlo o liečbu vzniknutej IDH alebo o prevenciu?</th>
      <td>Preventívne výsledky nepotvrdzujú účinnosť záchranného bolusu.</td>
    </tr>
    <tr>
      <th scope="row">Aká populácia bola sledovaná?</th>
      <td>Výsledky u hospitalizovaných pacientov nemožno bez ďalšieho preniesť na stabilnú ambulantnú hemodialýzu.</td>
    </tr>
    <tr>
      <th scope="row">Aký roztok a koncentrácia sa použili?</th>
      <td>Izoonkotický a hyperonkotický albumín nie sú rovnakou intervenciou; želatína nie je zameniteľná s albumínom.</td>
    </tr>
    <tr>
      <th scope="row">Bola prítomná hypoalbuminémia?</th>
      <td>Môže meniť fyziologické východiská aj výber pacientov.</td>
    </tr>
    <tr>
      <th scope="row">Čo bolo výsledným ukazovateľom?</th>
      <td>Vyšší tlak nie je totožný s lepšou toleranciou výkonu alebo prognózou.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Bez zohľadnenia týchto rozdielov je tvrdenie, že koloidy, albumín, hypertonický NaCl a fyziologický roztok sú „približne rovnocenné“, príliš široké. Rovnako neopodstatnené je všeobecné tvrdenie o nadradenosti koloidov.</p>

<p>Hypoalbuminémia sama osebe nie je automatickou indikáciou albumínu. Rozhodnutie závisí od klinickej situácie, príčiny nízkej koncentrácie albumínu a cieľa intervencie.</p>

<h2>Hlavné bezpečnostné riziká</h2>

<h3>Čo zistila metaanalýza bezpečnosti želatín</h3>

<p>Prehľad Moellerovej a spoluautorov zahrnul 60 štúdií, z toho 30 randomizovaných kontrolovaných, 8 nerandomizovaných a 22 zvieracích. Porovnával želatínu s kryštaloidom alebo albumínom pri liečbe hypovolémie. [1]</p>

<div class="table-responsive" role="region" aria-label="Riziká podania želatíny oproti kryštaloidu alebo albumínu podľa metaanalýzy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Výsledok</th>
      <th scope="col">Pomer rizík (95 % interval spoľahlivosti)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Anafylaxia</th>
      <td><strong>3,01 (1,27 až 7,14)</strong> – štatisticky významné</td>
    </tr>
    <tr>
      <th scope="row">Akútne poškodenie obličiek</th>
      <td>1,35 (0,58 až 3,14)</td>
    </tr>
    <tr>
      <th scope="row">Mortalita</th>
      <td>1,15 (0,96 až 1,38)</td>
    </tr>
    <tr>
      <th scope="row">Potreba alogénnej transfúzie</th>
      <td>1,10 (0,86 až 1,41)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kvalitne vykonané nerandomizované štúdie navyše zaznamenali vyššiu nemocničnú mortalitu a vyšší výskyt akútneho poškodenia obličiek alebo potreby náhrady funkcie obličiek v obdobiach, keď sa želatína používala. Autori uzatvárajú, že želatínové roztoky zvyšujú riziko anafylaxie a môžu byť škodlivé zvýšením mortality, obličkového zlyhania a krvácania, pravdepodobne v dôsledku extravaskulárneho zachytávania a narušenia koagulácie. Pokiaľ dobre navrhnuté randomizované štúdie nepreukážu bezpečnosť želatín, odporúčajú pred ich použitím varovať, pretože sú dostupné lacnejšie a bezpečnejšie alternatívy. [1]</p>

<p>Tieto údaje pochádzajú z intenzivistickej a perioperačnej medicíny, nie z dialyzačných pracovísk, a nemožno ich mechanicky preniesť na jednorazový bolus počas hemodialýzy. Ide však o najrozsiahlejšie dostupné bezpečnostné hodnotenie tejto skupiny roztokov a nemožno ho pri rozhodovaní obísť.</p>

<h3>Reakcie z precitlivenosti a anafylaxia</h3>

<p>Želatínové roztoky môžu vyvolať závažnú reakciu z precitlivenosti vrátane anafylaxie. Pojem „anafylaktoidná reakcia“ je v súčasnom klinickom texte menej vhodný, ak nie je mechanizmus reakcie spoľahlivo určený. Anafylaxia sa nerozpoznáva ani nelieči podľa toho, či bol vopred preukázaný mechanizmus sprostredkovaný IgE.</p>

<p>Reakcia nemusí mať výrazné kožné prejavy. Nová hypotenzia, bronchospazmus alebo náhle zhoršenie stavu počas infúzie sa nesmú automaticky pripísať samotnej dialýze.</p>

<p>Alergia na mäso cicavcov nie je len dôvodom na zvýšenú pozornosť. Protilátky triedy IgE proti galaktóze-α-1,3-galaktóze (α-gal) reagujú aj so želatínami cicavčieho pôvodu a opísaná je anafylaxia na sukcinylovanú želatínu u pacientky s alergiou na mäso. [6] Registračná dokumentácia Gelofusine preto uvádza <strong>precitlivenosť na α-gal a známu alergiu na červené mäso priamo medzi kontraindikáciami</strong>. [3] Cielená anamnéza predchádzajúcich reakcií na želatínu a alergie na mäso je teda povinnou súčasťou rozvahy, nie voliteľným doplnkom.</p>

<p>Dokumentácia zároveň vyžaduje <strong>podať prvých 20 ml pomaly</strong>, aby bolo možné včas zachytiť alergickú reakciu. [3] Táto požiadavka je sama osebe argumentom proti predstave želatíny ako rýchleho záchranného bolusu pri náhlej hypotenzii.</p>

<p>Pri podozrení na anafylaxiu treba podávanie okamžite prerušiť a začať urgentnú liečbu podľa platného postupu. Dostupnosť adrenalínu a pripravenosť personálu sú podstatnejšie než neurčitá formulácia „pripraviť antianafylaktický postup“.</p>

<h3>Objemové preťaženie</h3>

<p>Koloid môže zhoršiť kongesciu rovnako ako iná nevhodne indikovaná objemová náhrada. Registračná dokumentácia uvádza <strong>hypervolémiu, hyperhydratáciu a akútne kongestívne zlyhávanie srdca medzi kontraindikáciami</strong> a vyžaduje opatrnosť pri insuficiencii pravej či ľavej komory, hypertenzii a pľúcnom edéme. [3]</p>

<p>Problém je rovnaký ako pri <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitole</a> a <a href="article.php?slug=midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost">midodríne</a>: stav, ktorý je u dialyzovaného pacienta častý, je v dokumentácii uvedený ako kontraindikácia. Nejde teda len o použitie mimo schválenej indikácie.</p>

<p>Menší podaný objem automaticky neznamená menšie hemodynamické riziko. Dôležitá je výsledná zmena intravaskulárneho objemu a schopnosť srdca tento objem zvládnuť.</p>

<h3>Hemodilúcia a hemostáza</h3>

<p>Objemová náhrada môže znižovať koncentráciu hemoglobínu a koagulačných faktorov hemodilúciou. Dokumentácia výslovne uvádza, že relatívne veľké dávky spôsobujú dilúciu koagulačných faktorov, a maximálnu dennú dávku viaže na stupeň hemodilúcie: hematokrit nemá klesnúť pod 25 %, u starších a kriticky chorých pod 30 %. [3] Metaanalýza medzi možnými mechanizmami poškodenia uvádza aj narušenie koagulácie. [1]</p>

<p>Pri posudzovaní krvácavého rizika treba zohľadniť podaný objem, východiskovú poruchu hemostázy a dialyzačnú antikoaguláciu. Formulácia „mierne ovplyvnenie hemostázy“ je príliš paušálna; klinický význam nemožno stanoviť bez kontextu.</p>

<h3>Eliminácia pri zlyhaní obličiek</h3>

<p>Želatínové roztoky obsahujú molekuly rôznej veľkosti. Údaj o priemernej molekulovej hmotnosti 26 500 daltonov nie je dostatočný na určenie ich správania pri hemodialýze.</p>

<p>Dialyzačné odstraňovanie závisí od vlastností membrány, distribúcie veľkosti molekúl a ďalších fyzikálno-chemických charakteristík. Bez konkrétnych údajov nemožno tvrdiť, že sa želatína pri bežnej hemodialýze klinicky významne odstráni. Registračná dokumentácia odporúča pri závažnej poruche funkcie obličiek opatrnosť. [3]</p>

<p>Rovnako nemožno iba z anúrie odvodiť presný rozsah a dôsledky akumulácie. Rozhodujúce sú farmakokinetické údaje a upozornenia konkrétneho prípravku.</p>

<h2>Podanú tekutinu netreba odstrániť za každú cenu</h2>

<p>Každú infúziu treba zaznamenať do bilancie. Z toho však nevyplýva povinnosť odstrániť celý podaný objem ešte počas toho istého výkonu.</p>

<p>Ak tekutina upravila klinicky významný pokles intravaskulárneho objemu, okamžité zvýšenie ultrafiltrácie môže obnoviť ten istý problém. Následný postup musí zohľadniť toleranciu pacienta, zostávajúci čas výkonu, kongesciu a primeranosť pôvodne stanovenej cieľovej hmotnosti.</p>

<p>Pri želatíne pribúda ďalšia úvaha: ak sa 17 až 31 % podanej dávky zachytáva extravaskulárne, časť podaného objemu nie je ultrafiltráciou okamžite dostupná. [1] Snaha „dohnať“ bilanciu počas toho istého výkonu preto môže viesť k opakovanej hypotenzii.</p>

<p>Možnosťou môže byť zníženie cieľa ultrafiltrácie, predĺženie výkonu alebo zmena plánu ďalšej dialýzy. Prioritou je bezpečná perfúzia, nie dosiahnutie pôvodného objemového cieľa za každú cenu.</p>

<h2>Prevencia má väčší význam než opakované záchranné infúzie</h2>

<p>Opakovaná potreba objemových náhrad je podnetom na prehodnotenie dialyzačného predpisu. Treba posúdiť cieľovú hmotnosť, medzidialyzačné hmotnostné prírastky, rýchlosť ultrafiltrácie, dĺžku výkonov a kardiovaskulárne príčiny nestability.</p>

<p>Podľa individuálnej tolerancie možno upraviť teplotu dialyzátu – toto opatrenie má spomedzi všetkých možností najpevnejší dôkazový základ. Sodíkové profilovanie nie je univerzálnou preventívnou odpoveďou: môže viesť k pozitívnej sodíkovej bilancii, smädu a vyšším medzidialyzačným prírastkom a v registri DOPPS sa spájalo s vyššou mortalitou. Ani midodrín nenahrádza úpravu nadmernej ultrafiltračnej záťaže. [4]</p>

<p>Želatínu preto nie je vhodné charakterizovať ako roztok určený predovšetkým pre „rizikovejších pacientov“. Práve u nich môže byť riziko preťaženia, alergickej reakcie alebo nesprávne rozpoznanej príčiny hypotenzie vyššie – a práve u nich dokumentácia uvádza kongestívne zlyhávanie srdca medzi kontraindikáciami.</p>

<h2>Klinický záver</h2>

<p>Želatínové koloidy môžu byť predmetom individuálneho rozhodovania o objemovej podpore, ale ich koloidné vlastnosti nepredstavujú dôkaz nadradenosti pri intradialyzačnej hypotenzii. Údaje hovoria skôr opačne: podstatná časť dávky opúšťa cievne riečisko, úspora objemu oproti kryštaloidu je malá, sodíková záťaž je rovnaká ako pri fyziologickom roztoku a riziko anafylaxie je zvýšené.</p>

<p>Želatínu preto nemožno odporučiť ako automatickú záchrannú náhradu po neúčinnosti fyziologického roztoku. Požiadavka podať prvých 20 ml pomaly je navyše v priamom rozpore s predstavou rýchleho záchranného bolusu.</p>

<p>Základom postupu zostáva rozpoznanie príčiny hypotenzie, prerušenie neprimeranej ultrafiltrácie a opatrná, priebežne prehodnocovaná liečba. Pri opakovaných epizódach má prednosť úprava dialyzačnej stratégie pred opakovaným podávaním objemových náhrad.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<p><em>1. Moeller C, Fleischmann C, Thomas-Rueddel D, Vlasakov V, Rochwerg B, Theurer P, Gattinoni L, Reinhart K, Hartog CS. How safe is gelatin? A systematic review and meta-analysis of gelatin-containing plasma expanders vs crystalloids and albumin. Journal of Critical Care. 2016;35:75–83. <a href="https://doi.org/10.1016/j.jcrc.2016.04.011" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.jcrc.2016.04.011</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/27481739/" target="_blank" rel="noopener noreferrer">PubMed, PMID 27481739</a>.</em></p>

<p><em>2. Rostoker G, Griuncelli M, Loridon C, Bourlet T, Illouz E, Benmaadi A. A pilot study of routine colloid infusion in hypotension-prone dialysis patients unresponsive to preventive measures. Journal of Nephrology. 2011;24(2):208–217. <a href="https://doi.org/10.5301/jn.2011.6367" target="_blank" rel="noopener noreferrer">DOI: 10.5301/jn.2011.6367</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/21360469/" target="_blank" rel="noopener noreferrer">PubMed, PMID 21360469</a>.</em></p>

<p><em>3. Súhrn charakteristických vlastností lieku Gelofusine 40 mg/ml + 7,01 mg/ml infúzny roztok (B. Braun Melsungen AG), časti 4.1 až 4.4 a 6.1. Údaje o zložení, indikáciách, kontraindikáciách, dávkovaní a upozorneniach boli overené v znení dostupnom na liekových databázach (<a href="https://www.adc.sk/databazy/produkty/pil/b-braun-gelofusine-510698.html" target="_blank" rel="noopener noreferrer">ADC.sk</a>). Pred použitím je potrebné overiť aktuálne platné znenie SPC konkrétneho prípravku.</em></p>

<p><em>4. Kanbay M, Ertuglu LA, Afsar B, Ozdogan E, Siriopol D, Covic A, Basile C, Ortiz A. An update review of intradialytic hypotension: concept, risk factors, clinical implications and management. Clinical Kidney Journal. 2020;13(6):981–993. <a href="https://doi.org/10.1093/ckj/sfaa078" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ckj/sfaa078</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33391741/" target="_blank" rel="noopener noreferrer">PubMed, PMID 33391741</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7769545/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>5. Rostoker G, Griuncelli M, Loridon C, Bourlet T, Illouz E, Benmaadi A. Modulation of oxidative stress and microinflammatory status by colloids in refractory dialytic hypotension. BMC Nephrology. 2011;12:58. <a href="https://doi.org/10.1186/1471-2369-12-58" target="_blank" rel="noopener noreferrer">DOI: 10.1186/1471-2369-12-58</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/22013952/" target="_blank" rel="noopener noreferrer">PubMed, PMID 22013952</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3231981/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>6. Uyttebroek A, Sabato V, Bridts CH, De Clerck LS, Ebo DG. Anaphylaxis to succinylated gelatin in a patient with a meat allergy: galactose-α(1,3)-galactose (α-gal) as antigenic determinant. Journal of Clinical Anesthesia. 2014;26(7):574–576. <a href="https://doi.org/10.1016/j.jclinane.2014.04.014" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.jclinane.2014.04.014</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/25439422/" target="_blank" rel="noopener noreferrer">PubMed, PMID 25439422</a>.</em></p>

<p><em>Bibliografické údaje zdrojov č. 1, 2 a 4 až 6 boli overené cez PubMed vrátane plných textov v PubMed Central.</em></p>
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
        error_log('add_zelatina_idh migration error: ' . $e->getMessage());
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
