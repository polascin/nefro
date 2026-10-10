<?php
/**
 * add_midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost_article.php
 * Odborný článok o midodríne pri intradialyzačnej hypotenzii:
 * mechanizmus, dôkazový základ, dávkovo závislý bezpečnostný signál a SPC.
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
    'title'        => 'Midodrín pri intradialyzačnej hypotenzii: účinok, dôkazy a bezpečnosť',
    'slug'         => 'midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Midodrín spoľahlivo zvyšuje krvný tlak pri dialýze, prínos pre pacienta však doložený nie je. V kórejskej kohorte so 71 540 pacientmi bol signál vyššej mortality dávkovo závislý – pri nízkej expozícii chýbal úplne.',
    'content'      => <<<'HTML'
<figure><a href="img/midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost.webp" rel="noopener noreferrer" target="_blank"><img src="img/midodrin-intradialyzacna-hypotenzia-ucinok-dokazy-bezpecnost.webp" alt="Zužujúca sa arteriola vľavo dvíha stĺpec tlaku, zatiaľ čo kapilárne riečisko vpravo tmavne – vzostup tlaku bez obnovenia perfúzie" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Vazokonstrikcia zdvihne tlak na manometri. Či sa zároveň obnoví perfúzia tkaniva za zúžením, je samostatná otázka – a práve tá zostáva nezodpovedaná.</figcaption></figure>

<p>Midodrín je perorálne podávaný proliek, ktorého aktívny metabolit desglymidodrín stimuluje α₁-adrenergné receptory a zvyšuje cievny tonus. Schválené použitie sa podľa konkrétneho prípravku a krajiny týka predovšetkým ťažkej ortostatickej hypotenzie pri dysfunkcii autonómneho nervového systému. V dialyzačnej praxi sa používa aj mimo schválenej indikácie na prevenciu opakovanej intradialyzačnej hypotenzie.</p>

<p>Menšie štúdie podporujú jeho krátkodobý účinok na krvný tlak, spoľahlivý dôkaz priaznivého vplyvu na hospitalizácie, kardiovaskulárne príhody alebo prežívanie však chýba. Veľké observačné súbory naopak priniesli bezpečnostný signál. Novšie údaje ukazujú, že tento signál je <strong>dávkovo závislý</strong>, čo mení praktické vyznenie celej témy.</p>

<h2>Mechanizmus účinku a jeho klinické hranice</h2>

<p>Desglymidodrín aktivuje α₁-adrenergné receptory v arteriolách a žilách. Arteriolárna vazokonstrikcia zvyšuje systémovú cievnu rezistenciu. Venokonstrikcia znižuje kapacitu žilového riečiska, obmedzuje hromadenie krvi v periférnych žilách a môže podporovať venózny návrat. Výsledkom je zvýšenie krvného tlaku.</p>

<p>Midodrín však nenahrádza chýbajúci intravaskulárny objem. Ak ultrafiltrácia odstraňuje tekutinu rýchlejšie, než sa cievne riečisko dopĺňa z interstícia, samotná vazokonstrikcia nemusí obnoviť primeraný srdcový výdaj ani tkanivovú perfúziu. Zvýšenie tlaku preto nie je automatickým dôkazom odstránenia príčiny IDH.</p>

<p>Autori kórejskej kohortovej štúdie tento problém formulujú presne: ak pokles intravaskulárneho objemu pri oneskorenom plnení ciev počas dialýzy prevýši prírastok venózneho návratu vyvolaný midodrínom, výsledná vazokonstrikcia môže tkanivovú perfúziu a srdcový výdaj ďalej <em>znížiť</em>, hoci nameraný tlak stúpne. [3]</p>

<p>Tento rozdiel je dôležitý najmä pri srdcovom zlyhávaní, závažnej ateroskleróze alebo výraznom poklese intravaskulárneho objemu. Nejde o dôkaz, že midodrín u každého takéhoto pacienta škodí, ale o dôvod nehodnotiť jeho účinnosť iba podľa číselnej hodnoty tlaku. Doplnkovou úvahou je, že krátkodobo pôsobiace látky môžu zvyšovať variabilitu krvného tlaku, ktorá je sama prediktorom mortality u dialyzovaných pacientov. [3]</p>

<p>Účinok je prevažne periférny. Obmedzený prienik cez hematoencefalickú bariéru však nie je vhodné prekladať absolútnym tvrdením, že liek „nemá centrálne účinky“. Midodrín nemá priamy β-adrenergný stimulačný účinok na srdce; pri vzostupe tlaku sa môže objaviť reflexná bradykardia.</p>

<h2>Farmakokinetika významná pri hemodialýze</h2>

<p>Po perorálnom podaní sa midodrín vstrebáva a premieňa na aktívny desglymidodrín. Podľa registračnej dokumentácie sa vrcholová plazmatická koncentrácia aktívneho metabolitu dosahuje približne za jednu hodinu a jeho polčas je okolo troch hodín. Počas 24 hodín sa približne 40 až 60 % dávky vylúči vo forme aktívneho metabolitu. [5]</p>

<p>Desglymidodrín sa teda významne eliminuje obličkami. Pri závažnej poruche ich funkcie môže byť expozícia predĺžená, zatiaľ čo hemodialýza umožňuje jeho odstránenie – dokumentácia výslovne uvádza, že aktívny metabolit je dialyzovateľný a jeho polčas je približne tri hodiny. [5] Dialyzovateľnosť preto nevylučuje riziko zvýšenej expozície mimo dialyzačného výkonu.</p>

<p>Koncentrácia liečiva, maximálny tlakový účinok a trvanie klinickej odpovede však nie sú totožné veličiny. Pre klinické použitie z toho vyplýva:</p>

<ul>
  <li>rovnaká dávka nemusí mať rovnaký účinok počas dialýzy a v medzidialyzačnom období;</li>
  <li>podanie pred výkonom musí zohľadňovať aj prípadné oneskorenie jeho začiatku;</li>
  <li>opakovaná dávka počas výkonu nemá byť automatickou reakciou na nižší tlak;</li>
  <li>bezpečnosť treba hodnotiť aj po skončení dialýzy, najmä pri odpočinku v ľahu.</li>
</ul>

<h2>Ortostatická hypotenzia a IDH nie sú rovnakou indikáciou</h2>

<p>Ortostatická hypotenzia je pokles krvného tlaku po zaujatí vzpriamenej polohy. Môže súvisieť s autonómnou dysfunkciou pri neurodegeneratívnych ochoreniach alebo s diabetickou autonómnou neuropatiou. Samotná Parkinsonova choroba či diabetes mellitus však nie sú automatickou indikáciou midodrínu.</p>

<p>Pri intradialyzačnej hypotenzii (IDH) vzniká hemodynamická nestabilita počas dialyzačného výkonu. Podieľať sa na nej môžu ultrafiltrácia, nedostatočné dopĺňanie intravaskulárneho objemu, porucha autonómnej regulácie, srdcové ochorenie a ďalšie faktory. Dôkazy získané pri ortostatickej hypotenzii sa preto nedajú priamo preniesť na dialyzovaných pacientov. Podrobnejšie sa mechanizmom IDH venuje článok o <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitole pri intradialyzačnej hypotenzii</a>.</p>

<h3>Kontraindikácia nie je to isté ako použitie mimo indikácie</h3>

<p>Použitie midodrínu pri IDH treba posudzovať v dvoch samostatných rovinách:</p>

<ol>
  <li><strong>Schválená indikácia:</strong> liečba ani prevencia IDH v registračnej dokumentácii spravidla uvedená nie je. Schválenou indikáciou je ťažká ortostatická hypotenzia pri dysfunkcii autonómneho nervového systému, keď boli vylúčené korigovateľné príčiny. [5]</li>
  <li><strong>Kontraindikácie:</strong> európske aj slovenské znenia dokumentácie uvádzajú medzi kontraindikáciami <strong>akútne ochorenie obličiek</strong> a <strong>závažnú renálnu insuficienciu</strong>. Britská dokumentácia ju kvantifikuje ako klírens kreatinínu pod 30 ml/min a zároveň vyžaduje veľkú opatrnosť pri klírense medzi 30 a 90 ml/min. [5, 6]</li>
</ol>

<p>To je podstatný rozdiel oproti bežnej predstave o použití „off label“. U pacienta na udržiavacej hemodialýze nejde len o podanie mimo schválenej indikácie, ale o podanie napriek výslovne uvedenej kontraindikácii. Lokálny dialyzačný protokol tento rozdiel neodstraňuje a nenahrádza individuálne odôvodnené a zdokumentované lekárske rozhodnutie.</p>

<p>Rovnakú štruktúru problému má aj <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">20 % manitol</a>, pri ktorom slovenské SPC uvádza rozvinutú anúriu medzi kontraindikáciami. Ide o opakujúci sa problém farmakoterapie IDH, nie o ojedinelú zvláštnosť jedného lieku.</p>

<h2>Čo ukazujú klinické dôkazy</h2>

<h3>Menšie štúdie podporujú krátkodobý tlakový účinok</h3>

<p>Systematický prehľad Sumy Prakashovej, Amita X. Garga, A. Paula Heidenheima a Andrewa A. Housea z roku 2004 zhrnul malé štúdie midodrínu pri dialýzou vyvolanej hypotenzii. Z 37 získaných plných textov splnilo kritériá deväť štúdií, k nim pribudla jedna nepublikovaná práca. Dávkovacie režimy sa pohybovali od 2,5 do 10 mg podaných 15 až 30 minút pred dialýzou. [1]</p>

<div class="table-responsive" role="region" aria-label="Výsledky systematického prehľadu midodrínu pri dialýzou vyvolanej hypotenzii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Rozdiel oproti kontrole</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Systolický tlak po dialýze</th>
      <td>Vyšší o 12,4 mmHg (95 % IS 7,5 až 17,7)</td>
    </tr>
    <tr>
      <th scope="row">Diastolický tlak po dialýze</th>
      <td>Vyšší o 7,3 mmHg (95 % IS 3,7 až 10,9)</td>
    </tr>
    <tr>
      <th scope="row">Najnižší systolický tlak počas výkonu</th>
      <td>Vyšší o 13,3 mmHg (95 % IS 8,6 až 18,0)</td>
    </tr>
    <tr>
      <th scope="row">Najnižší diastolický tlak počas výkonu</th>
      <td>Vyšší o 5,9 mmHg (95 % IS 2,7 až 9,1)</td>
    </tr>
    <tr>
      <th scope="row">Zlepšenie príznakov</th>
      <td>Uvádzané v 6 z 10 štúdií</td>
    </tr>
    <tr>
      <th scope="row">Závažné nežiaduce účinky pripísané midodrínu</th>
      <td>Neuvádzané v žiadnej zo štúdií</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tlakový účinok je teda pomerne konzistentný a nie malý. Obmedzenia tejto dôkazovej základne sú však podstatné: malé súbory, krátke sledovanie, rozdielne usporiadanie štúdií a nejednotné hodnotenie hypotenzie. Autori sami uzatvárajú, že záver treba prijímať opatrne vzhľadom na kvalitu a veľkosť zahrnutých štúdií. [1]</p>

<p>Ani názov prehľadu, podľa ktorého sa midodrín javí ako bezpečný a účinný, preto nemožno považovať za potvrdenie bezpečnosti. Malé a krátke štúdie majú obmedzenú schopnosť zachytiť zriedkavé alebo oneskorené nežiaduce výsledky – a práve tie sa neskôr objavili vo veľkých kohortách.</p>

<h3>Observačné údaje: hemodynamický prínos sa v reálnej praxi nepotvrdil</h3>

<p>Práca Brunelliho a spoluautorov z roku 2018 porovnala 1 046 pacientov s predpisom midodrínu a 2 037 párovaných kontrol v dialyzačných centrách v USA v období júl 2015 až september 2016. Používanie midodrínu sa spájalo s vyšším pomerom incidencie úmrtia (upravený pomer 1,37; 95 % IS 1,15 až 1,62), hospitalizácií z akejkoľvek príčiny (1,31; 1,19 až 1,43) a kardiovaskulárnych hospitalizácií (1,41; 1,17 až 1,71). [2]</p>

<p>Dôležitejší než samotné čísla je však hemodynamický nález, ktorý sa pri citovaní tejto práce často vynecháva. Počas sledovania mali pacienti užívajúci midodrín skôr <strong>nižší</strong> predialyzačný systolický tlak, <strong>nižšiu</strong> najnižšiu hodnotu systolického tlaku, <strong>väčší</strong> pokles tlaku počas dialýzy a <strong>vyšší</strong> podiel výkonov komplikovaných IDH. [2]</p>

<p>Autori z toho vyvodzujú, že pozorované súvislosti nezodpovedajú silnému priaznivému účinku midodrínu ani na klinické, ani na hemodynamické výsledky. Pri interpretácii treba zohľadniť, že všetci autori pôsobili vo výskumných štruktúrach veľkého poskytovateľa dialyzačnej starostlivosti a že ide o retrospektívnu analýzu, v ktorej nemožno vylúčiť reziduálne skreslenie. [2]</p>

<h3>Kórejská kohorta: signál je dávkovo závislý</h3>

<p>Retrospektívna štúdia Jeona a spoluautorov publikovaná v roku 2025 analyzovala 71 540 pacientov na udržiavacej hemodialýze z kórejského programu hodnotenia kvality dialýzy a z údajov zdravotného poistenia. Midodrín malo predpísaný približne 9,6 % pacientov. Po párovaní podľa propensity skóre v pomere 1 : 3 sa porovnávalo 6 887 pacientov s predpisom a 20 305 pacientov bez predpisu; medián sledovania presahoval štyri roky. [3]</p>

<p>Odhadované päťročné prežívanie bolo 58,0 % v skupine s midodrínom a 62,6 % v skupine bez neho (p &lt; 0,001). Upravený pomer rizík celkovej mortality dosiahol 1,17 (95 % IS 1,13 až 1,22). Rozdiel v kombinovanom kardiovaskulárnom ukazovateli nebol štatisticky významný (upravený pomer rizík 0,99; 95 % IS 0,92 až 1,06). [3]</p>

<p>Rozhodujúce je však rozdelenie podľa expozície. Za používateľa sa považoval pacient s aspoň jednou predpísanou tabletou počas šesťmesačného obdobia; skupina s nižšou expozíciou mala predpísaných menej než 30 tabliet, skupina s vyššou expozíciou 30 a viac tabliet za šesť mesiacov.</p>

<div class="table-responsive" role="region" aria-label="Mortalita podľa expozície midodrínu v kórejskej kohorte po párovaní" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina</th>
      <th scope="col">Päťročné prežívanie</th>
      <th scope="col">Upravený pomer rizík mortality</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Bez predpisu (referencia)</th>
      <td>62,6 %</td>
      <td>1,00</td>
    </tr>
    <tr>
      <th scope="row">Nižšia expozícia (menej než 30 tabliet za 6 mesiacov)</th>
      <td>63,2 %</td>
      <td>0,99 (95 % IS 0,93 až 1,05) – <strong>bez signifikantného rozdielu</strong></td>
    </tr>
    <tr>
      <th scope="row">Vyššia expozícia (30 a viac tabliet za 6 mesiacov)</th>
      <td>55,3 %</td>
      <td>1,27 (95 % IS 1,21 až 1,33)</td>
    </tr>
    <tr>
      <th scope="row">Vyššia oproti nižšej expozícii</th>
      <td>—</td>
      <td>1,28 (95 % IS 1,19 až 1,38)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Toto zistenie je pre prax zásadné. Celý mortalitný signál pochádza zo skupiny s častým dávkovaním. Pri nízkej expozícii sa prežívanie od skupiny bez predpisu nelíšilo vôbec – päťročné prežívanie bolo dokonca číselne o niečo vyššie. Údaj teda nehovorí „midodrín je nebezpečný“, ale skôr: <strong>potreba častého dávkovania je varovným znamením.</strong></p>

<p>Autori ten istý záver formulujú ako výzvu aktívne vyhľadávať a liečiť komorbidity a rizikové faktory IDH u pacientov, ktorí midodrín potrebujú, osobitne pri častom podávaní. [3]</p>

<h3>Prečo nemožno hovoriť o príčinnej súvislosti</h3>

<p>Interpretáciu obmedzuje predovšetkým <strong>skreslenie indikáciou</strong>, respektíve skreslenie závažnosťou: pacienti dostávajúci midodrín majú spravidla závažnejšiu hypotenziu, výraznejšiu autonómnu dysfunkciu alebo horší celkový zdravotný stav. Ani párovanie podľa propensity skóre nedokáže odstrániť rozdiely v charakteristikách, ktoré neboli spoľahlivo zaznamenané.</p>

<p>V kórejskej štúdii boli tieto limity pomenované otvorene. Súbor údajov neobsahoval klinické údaje o IDH a pre IDH neexistuje kód MKCH-10, takže frekvenciu ani závažnosť hypotenzných epizód nebolo možné zachytiť. Autori preto použili náhradný ukazovateľ – predpis najmenej 500 ml fyziologického roztoku za šesť mesiacov – a súvislosť s mortalitou pretrvávala v oboch podskupinách. Nebolo tiež možné zistiť, či sa u sledovaných pacientov primerane uplatňovali ostatné opatrenia na prevenciu IDH. [3]</p>

<p>Ďalším kontextom je výrazná variabilita používania. V kórejskej kohorte dostávalo midodrín približne 10 % pacientov, v americkom prieskume z roku 2005 ho na proaktívne riešenie IDH používalo okolo 30 % oslovených pracovísk, zatiaľ čo americká práca z roku 2018 uvádza len 0,3 % pacientov. Americký regulačný úrad v roku 2010 dokonca navrhol zrušiť registráciu midodrínu pre nedostatočné poregistračné údaje o účinnosti; návrh bol po nesúhlase odbornej verejnosti stiahnutý. [3]</p>

<p>Výsledky teda odôvodňujú obozretnosť, cielený výber pacientov a ďalší výskum. Neodôvodňujú ani tvrdenie, že midodrín preukázateľne zvyšuje mortalitu, ani opačné tvrdenie, že jeho dlhodobá bezpečnosť je potvrdená.</p>

<h2>Miesto midodrínu v prevencii IDH</h2>

<p>Midodrín možno individuálne zvažovať pri opakovanej symptomatickej IDH, ak sa napriek úprave dialyzačných podmienok nedarí dosiahnuť prijateľnú toleranciu výkonu a ak použitie umožňuje posúdenie konkrétneho prípravku a pacienta.</p>

<p>Pred farmakologickým zásahom má prednosť revízia:</p>

<ul>
  <li>cieľovej hmotnosti a aktuálneho objemového stavu;</li>
  <li>rýchlosti ultrafiltrácie a medzidialyzačných hmotnostných prírastkov, predovšetkým cez obmedzenie príjmu sodíka;</li>
  <li>dĺžky a frekvencie dialyzačných výkonov;</li>
  <li>teploty dialyzátu podľa tolerancie pacienta;</li>
  <li>medikácie, srdcovej funkcie a možnej autonómnej dysfunkcie.</li>
</ul>

<p>Toto poradie nie je formálne. Chladnejší dialyzát má v metaanalýzach podstatne pevnejší dôkazový základ než midodrín a navyše je bez nákladov; podrobné porovnanie opatrení podľa sily dôkazov obsahuje <a href="article.php?slug=manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost">článok o manitole</a>. Praktické nástroje na objemovú stránku rozoberajú články o <a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">stanovení suchej váhy</a>, o <a href="article.php?slug=rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia">monitorovaní relatívneho objemu krvi</a> a o <a href="article.php?slug=dennik-semafor-objemovy-manazment-hemodialyza-rct">objemovom manažmente pri hemodialýze</a>.</p>

<p>Antihypertenzíva sa nemajú automaticky vynechávať pred každou dialýzou. Rozhodnutie má vychádzať z konkrétneho lieku, jeho indikácie, farmakokinetiky a priebehu krvného tlaku. V kórejskej kohorte mala približne polovica pacientov užívajúcich midodrín súčasne predpísané antihypertenzívum a práve táto kombinácia vykazovala najvyšší trend kardiovaskulárneho rizika. [3]</p>

<p>V publikovanej praxi sa pri IDH opisujú perorálne dávky približne <strong>2,5 až 10 mg podané 15 až 30 minút pred výkonom</strong>. Ide o opis používaných režimov v zahrnutých štúdiách, nie o univerzálne dávkovacie odporúčanie. Začiatočná dávka, prípadná titrácia a načasovanie musia rešpektovať individuálne riziká a dokumentáciu konkrétneho prípravku. [1]</p>

<p>Rutinné pridávanie druhej dávky počas dialýzy nemá dostatočne pevný dôkazový základ. Pred jej zvažovaním treba posúdiť príčinu hypotenzie, predchádzajúcu dávku, pulz, aktuálny tlak a zostávajúci čas výkonu. Pri pohľade na dávkovo závislý mortalitný signál je eskalácia frekvencie dávok práve tým postupom, ktorý si vyžaduje najväčšiu zdržanlivosť.</p>

<p><strong>Perorálny midodrín nie je náhradou bezodkladného postupu pri akútnej symptomatickej IDH.</strong> Pri náhlej hypotenzii treba zhodnotiť pacienta, obmedziť alebo zastaviť ultrafiltráciu a podľa klinického stavu upraviť objemovú podporu. Súčasne treba myslieť na arytmiu, ischémiu, krvácanie, infekciu alebo komplikáciu dialyzačného výkonu.</p>

<h2>Bezpečnosť: hlavné riziká a monitorovanie</h2>

<h3>Hypertenzia v ľahu</h3>

<p>Najvýznamnejším rizikom je výrazné zvýšenie krvného tlaku v ľahu. Americká lieková informácia naň upozorňuje osobitným zvýrazneným varovaním. Hypertenzia sa môže objaviť aj v sede. Registračná dokumentácia odporúča pravidelné meranie tlaku, poučenie pacienta, aby bezodkladne hlásil palpitácie, bolesť na hrudníku, bolesť hlavy alebo rozmazané videnie, a <strong>ukončenie liečby pri tlaku nad 180/100 mmHg</strong> alebo pri jeho výraznom kolísaní. [5]</p>

<p>Pri ortostatickej hypotenzii sa dávky plánujú na denný čas, keď pacient potrebuje byť vo vzpriamenej polohe; večerné podávanie sa obmedzuje podľa príslušného SPC. Tieto zásady však nemožno mechanicky preniesť na dialyzovaného pacienta v polohovateľnom kresle.</p>

<p>Pokyn „po užití sa neleží“ je príliš absolútny. Pri symptomatickej hypotenzii môže byť poloha v ľahu potrebná. Treba rozlišovať medzi plánovaným odpočinkom v úplne vodorovnej polohe pri už účinnom lieku a polohovaním počas akútnej hemodynamickej príhody.</p>

<h3>Bradykardia a interakcie</h3>

<p>Reflexná bradykardia môže byť klinicky významná, najmä pri súbežnom užívaní betablokátorov, srdcových glykozidov alebo iných liekov spomaľujúcich srdcovú frekvenciu. Závrat, presynkopa alebo synkopa počas liečby preto nemusia znamenať potrebu ďalšej dávky vazokonstriktora. Vyžadujú aj kontrolu pulzu a podľa situácie EKG.</p>

<p>Ďalšie sympatomimetiká a vazokonstrikčné prípravky môžu zvyšovať riziko hypertenzie. Súčasťou liekovej anamnézy majú byť aj voľnopredajné prípravky proti nádche.</p>

<h3>Urologické a ďalšie nežiaduce účinky</h3>

<p>Stimulácia α₁-receptorov môže sťažiť močenie alebo vyvolať retenciu moču; hyperplázia prostaty so zvýšenou tvorbou reziduálneho moču patrí medzi kontraindikácie. Ďalšie známe nežiaduce účinky zahŕňajú piloerekciu, svrbenie najmä vo vlasatej časti hlavy, parestézie a pocit chladu. [5, 6]</p>

<p>Pri ischemickej chorobe srdca alebo periférnom artériovom ochorení je potrebné osobitné zhodnotenie pomeru prínosu a rizika; závažné obliterujúce a spastické cievne ochorenia sú kontraindikáciou. Bolesť na hrudníku, nové ischemické príznaky končatín alebo výrazná bolesť brucha vyžadujú bezodkladné klinické vyšetrenie, nie iba úpravu cieľovej hodnoty tlaku. [6]</p>

<h3>Kontraindikácie treba viazať na konkrétny prípravok</h3>

<p>Zoznamy kontraindikácií sa medzi dokumentáciami líšia. Slovenské a európske znenia uvádzajú precitlivenosť na liečivo, závažné obliterujúce a spastické cievne ochorenia, akútne ochorenie obličiek, závažné poškodenie obličiek a hyperpláziu prostaty so zvýšenou tvorbou reziduálneho moču. [6] Britská dokumentácia dopĺňa akútnu nefritídu a kvantifikuje renálnu hranicu klírensom kreatinínu pod 30 ml/min. [5] Americká dokumentácia uvádza aj závažné organické ochorenie srdca, retenciu moču, feochromocytóm a tyreotoxikózu.</p>

<p>Glaukóm s uzavretým uhlom preto nemožno bez uvedenia konkrétneho SPC prezentovať ako univerzálnu kontraindikáciu všetkých prípravkov s midodrínom. Pred použitím je potrebné overiť aktuálne platné znenie SPC konkrétneho prípravku dostupného na pracovisku.</p>

<h2>Ako hodnotiť, či liečba pacientovi prospieva</h2>

<p>Úspech liečby by sa nemal definovať iba zvýšením najnižšieho systolického tlaku. Práve to je totiž jediný ukazovateľ, pri ktorom je dôkaz jednoznačný – a zároveň ten, ktorý sa v observačných údajoch nepremietol do lepších výsledkov pre pacienta.</p>

<p>Klinicky relevantné je, či sa znižuje počet symptomatických epizód, potreba záchranných intervencií a počet predčasne ukončených výkonov, pričom nevzniká hypertenzia, bradykardia alebo ischemické príznaky.</p>

<div class="table-responsive" role="region" aria-label="Ukazovatele na sledovanie pri individuálnom terapeutickom pokuse s midodrínom" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">Čo hodnotiť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Tolerancia výkonu</th>
      <td>Príznaky, prerušenia ultrafiltrácie, potreba záchranných tekutín</td>
    </tr>
    <tr>
      <th scope="row">Krvný tlak</th>
      <td>Priebeh počas dialýzy, hodnoty po výkone, podľa situácie aj tlak v ľahu; pozor na variabilitu, nielen na priemer</td>
    </tr>
    <tr>
      <th scope="row">Srdcová frekvencia</th>
      <td>Bradykardia, arytmia a ich súvislosť s príznakmi</td>
    </tr>
    <tr>
      <th scope="row">Primeranosť dialýzy</th>
      <td>Dokončenie plánovaného výkonu a dosiahnutie primeraného objemového cieľa</td>
    </tr>
    <tr>
      <th scope="row">Expozícia lieku</th>
      <td>Počet dávok za obdobie – narastajúca frekvencia je dôvodom na prehodnotenie, nie na ďalšiu eskaláciu</td>
    </tr>
    <tr>
      <th scope="row">Bezpečnosť</th>
      <td>Hypertenzia, ischemické príznaky, retencia moču a ďalšie nežiaduce účinky</td>
    </tr>
  </tbody>
</table>
</div>

<p>Ak nie je zrejmý klinický prínos alebo sa dávky postupne zvyšujú bez prehodnotenia príčin IDH, treba znovu posúdiť celú liečebnú stratégiu.</p>

<h2>Klinický záver</h2>

<p>Midodrín je možnosťou individuálnej farmakologickej podpory u vybraných pacientov s opakovanou IDH, nie univerzálnym riešením zlej tolerancie ultrafiltrácie. Dôkazy podporujú predovšetkým krátkodobý účinok na krvný tlak, ktorý je konzistentný a nie malý. Dlhodobý prínos pre pacienta však zostáva nedoložený a veľké observačné súbory priniesli signál vyššej mortality.</p>

<p>Tento signál treba čítať presne: v kórejskej kohorte bol <strong>dávkovo závislý</strong> a pri nízkej expozícii úplne chýbal. Rozumným praktickým záverom preto nie je plošné odmietnutie midodrínu, ale pravidlo, že narastajúca potreba dávok je indikáciou na prehodnotenie dialyzačného predpisu a kardiovaskulárneho stavu, nie na ďalšiu eskaláciu liečby.</p>

<p>Bezpečné rozhodovanie vyžaduje rozlíšenie indikácie a kontraindikácií – vrátane toho, že závažná renálna insuficiencia je v registračnej dokumentácii uvedená ako kontraindikácia –, kontrolu aktuálneho SPC, optimalizáciu dialyzačného predpisu a hodnotenie klinického prínosu nad rámec samotného krvného tlaku.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<p><em>1. Prakash S, Garg AX, Heidenheim AP, House AA. Midodrine appears to be safe and effective for dialysis-induced hypotension: a systematic review. Nephrology Dialysis Transplantation. 2004;19(10):2553–2558. <a href="https://doi.org/10.1093/ndt/gfh420" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ndt/gfh420</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/15280522/" target="_blank" rel="noopener noreferrer">PubMed, PMID 15280522</a>.</em></p>

<p><em>2. Brunelli SM, Cohen DE, Marlowe G, Van Wyck D. The Impact of Midodrine on Outcomes in Patients with Intradialytic Hypotension. American Journal of Nephrology. 2018;48(5):381–388. <a href="https://doi.org/10.1159/000494806" target="_blank" rel="noopener noreferrer">DOI: 10.1159/000494806</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/30423552/" target="_blank" rel="noopener noreferrer">PubMed, PMID 30423552</a>.</em></p>

<p><em>3. Jeon J, Lim YJ, Kim BY, Choi JY, Do JY, Lee JE, Kang SH. Midodrine and clinical outcomes in patients on maintenance hemodialysis. Scientific Reports. 2025;15(1):23600. <a href="https://doi.org/10.1038/s41598-025-08029-8" target="_blank" rel="noopener noreferrer">DOI: 10.1038/s41598-025-08029-8</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40604215/" target="_blank" rel="noopener noreferrer">PubMed, PMID 40604215</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12222820/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>4. Kanbay M, Ertuglu LA, Afsar B, Ozdogan E, Siriopol D, Covic A, Basile C, Ortiz A. An update review of intradialytic hypotension: concept, risk factors, clinical implications and management. Clinical Kidney Journal. 2020;13(6):981–993. <a href="https://doi.org/10.1093/ckj/sfaa078" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ckj/sfaa078</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33391741/" target="_blank" rel="noopener noreferrer">PubMed, PMID 33391741</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7769545/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>5. Summary of Product Characteristics: Midodrine 5 mg Tablets, časti 4.1, 4.3, 4.4 a 5.2. Electronic Medicines Compendium, Spojené kráľovstvo. <a href="https://www.medicines.org.uk/emc/product/12496/smpc" target="_blank" rel="noopener noreferrer">Znenie SmPC na emc</a>. Nejde o slovenské SPC; slúži ako kvantifikované európske znenie renálnych kontraindikácií a farmakokinetiky.</em></p>

<p><em>6. Súhrn charakteristických vlastností lieku GUTRON 2,5 mg tablety (midodríniumchlorid), časti 4.1 až 4.4. Údaje o kontraindikáciách boli overené v znení dostupnom na slovenských liekových databázach (<a href="https://www.adc.sk/databazy/produkty/spc/gutron-2-5-mg-678924.html" target="_blank" rel="noopener noreferrer">ADC.sk</a>). Pred použitím je potrebné overiť aktuálne platné znenie SPC konkrétneho prípravku.</em></p>

<p><em>Bibliografické údaje zdrojov č. 1 až 4 boli overené cez PubMed, vrátane plných textov zdrojov č. 3 a 4 v PubMed Central.</em></p>
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
                error_log('add_midodrin_idh newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_midodrin_idh pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_midodrin_idh pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_midodrin_idh migration error: ' . $e->getMessage());
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
