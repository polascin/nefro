<?php
/**
 * add_manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost_article.php
 * Odborný článok o 20 % manitole pri intradialyzačnej hypotenzii:
 * osmotický mechanizmus, dôkazový základ a bezpečnostné hranice.
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
    'title'        => '20 % manitol pri intradialyzačnej hypotenzii: mechanizmus, dôkazy a bezpečnostné hranice',
    'slug'         => 'manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Osmotické zdôvodnenie manitolu pri hemodialýze je presvedčivé, dôkazový základ nie. Pilotná randomizovaná štúdia nepreukázala menší pokles tlaku a slovenské SPC uvádza rozvinutú anúriu medzi kontraindikáciami.',
    'content'      => <<<'HTML'
<figure><a href="img/manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost.webp" rel="noopener noreferrer" target="_blank"><img src="img/manitol-20-intradialyzacna-hypotenzia-dokazy-bezpecnost.webp" alt="Infúzny vak s hypertonickým roztokom nad strmo klesajúcou krivkou systolického tlaku pri hemodialýze; kvapka vychýli krivku len nepatrne, v pozadí dialyzačný okruh" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická vizualizácia. Osmotický zásah do padajúceho tlaku je fyziologicky zmysluplný – veľkosť vychýlenia krivky je však presne to, čo zostáva nepreukázané.</figcaption></figure>

<p>Manitol sa pri hemodialýze desaťročia používal s cieľom zmierniť rýchle osmotické zmeny a zlepšiť hemodynamickú toleranciu výkonu. Fyziologické zdôvodnenie však nie je totožné s preukázanou klinickou účinnosťou. Pilotná dvojito zaslepená randomizovaná štúdia u pacientov začínajúcich hemodialýzu nepreukázala štatisticky významné zmenšenie poklesu systolického krvného tlaku. Nižší výskyt hypotenzných epizód predstavoval zaujímavý, ale neistý výsledok sekundárneho hodnotenia.</p>

<p>K tomu pristupuje okolnosť, ktorá sa v diskusii o manitole často obchádza: slovenské súhrny charakteristických vlastností lieku uvádzajú <strong>rozvinutú anúriu</strong> a <strong>závažné prekrvenie pľúc alebo pľúcny edém</strong> medzi kontraindikáciami. Údaje preto nepodporujú automatické zaradenie 20 % manitolu do rutinnej liečby intradialyzačnej hypotenzie.</p>

<h2>Intradialyzačná hypotenzia nie je iba dôsledkom odstraňovania tekutiny</h2>

<p>Intradialyzačná hypotenzia (IDH) vzniká pri nepomere medzi nárokmi dialyzačného výkonu a schopnosťou organizmu udržať primeraný cirkulujúci objem, srdcový výdaj a cievny tonus. Ultrafiltrácia môže odstraňovať tekutinu rýchlejšie, než sa intravaskulárny objem dopĺňa z interstícia. Výsledok však ovplyvňujú aj funkcia srdca, autonómna regulácia, lieky, tepelné podmienky, splanchnické presuny krvi a zmeny koncentrácie osmoticky aktívnych látok. [3]</p>

<p>Udávaná prevalencia IDH sa pohybuje približne od 8 do 40 % a tento rozptyl nie je iba dôsledkom odlišných populácií – vo veľkej miere ho spôsobujú nejednotné definície. [3] Súvisiacim témam sa venujú samostatné články o <a href="article.php?slug=rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia">monitorovaní relatívneho objemu krvi</a> a o <a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">stanovení suchej váhy</a>.</p>

<h3>Definícia rozhoduje o tom, čo štúdia vlastne merala</h3>

<p>Samotný pokles systolického tlaku o najmenej 20 mmHg nemusí znamenať symptomatickú hypotenziu ani potrebu zásahu. Pokles zo 170 na 145 mmHg nie je klinicky rovnocenný poklesu zo 105 na 80 mmHg.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie definícií intradialyzačnej hypotenzie v odporúčaniach" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Zdroj definície</th>
      <th scope="col">Kritérium krvného tlaku</th>
      <th scope="col">Vyžaduje príznaky alebo zásah?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">KDOQI 2005</th>
      <td>Pokles systolického tlaku ≥ 20 mmHg alebo stredného tlaku ≥ 10 mmHg</td>
      <td>Áno – príznaky</td>
    </tr>
    <tr>
      <th scope="row">EBPG 2007</th>
      <td>Pokles systolického tlaku ≥ 20 mmHg alebo stredného tlaku ≥ 10 mmHg</td>
      <td>Áno – príznaky aj zásah</td>
    </tr>
    <tr>
      <th scope="row">UK Renal Association 2011</th>
      <td>Akýkoľvek pokles</td>
      <td>Áno – okamžitý zásah</td>
    </tr>
    <tr>
      <th scope="row">Japonská spoločnosť pre dialyzačnú liečbu 2012</th>
      <td>Pokles systolického tlaku ≥ 30 mmHg</td>
      <td>Áno – príznaky</td>
    </tr>
    <tr>
      <th scope="row">Veľké epidemiologické kohorty</th>
      <td>Najnižšia hodnota systolického tlaku pod 90 alebo 100 mmHg</td>
      <td>Nie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiel nie je formálny. Pri porovnaní definícií v kohortách HEMO a veľkej dialyzačnej organizácie mala najsilnejší vzťah k mortalite <strong>absolútna najnižšia hodnota</strong> systolického tlaku – pod 90 mmHg u pacientov s predialyzačným tlakom pod 160 mmHg a pod 100 mmHg u pacientov s vyšším predialyzačným tlakom. Definície založené na príznakoch, na zásahu alebo na samotnom poklese tlaku počas výkonu s mortalitou spojené neboli. [3]</p>

<p>Táto okolnosť je kľúčová pri hodnotení manitolu. V hlavnej randomizovanej štúdii bola IDH definovaná poklesom systolického tlaku o najmenej 20 mmHg oproti hodnote pred dialýzou. Definícia nevyžadovala príznaky ani terapeutickú intervenciu a autori výslovne uvádzajú, že čas vzniku intradialyzačných príznakov sa nezaznamenával, takže symptomatické a asymptomatické epizódy nebolo možné oddeliť. [1]</p>

<h2>Ako môže manitol ovplyvniť toleranciu dialýzy</h2>

<p>Dvadsaťpercentný roztok obsahuje 200 mg manitolu v 1 ml, teda 20 g v 100 ml. Pri molárnej hmotnosti 182,2 g/mol zodpovedá teoretickej osmolarite približne 1 100 mOsm/l.</p>

<p>Treba rozlišovať dva pojmy: <strong>osmolarita</strong> vyjadruje množstvo osmoticky aktívnych častíc na liter roztoku, kým <strong>osmolalita</strong> ich vyjadruje na kilogram rozpúšťadla. Pri charakteristike infúzneho roztoku sa spravidla uvádza osmolarita, pri laboratórnom hodnotení plazmy osmolalita.</p>

<p>Manitol sa za bežných podmienok distribuuje prevažne v extracelulárnom priestore a cez bunkové membrány prechádza obmedzene. Zvýšením extracelulárnej osmolality môže presúvať vodu z buniek do extracelulárneho priestoru a prechodne podporiť intravaskulárny objem.</p>

<p>Nie je však presné opisovať ho ako látku, ktorá zostáva výlučne v cievach a dlhodobo „nasáva“ vodu z interstícia. <strong>Manitol nie je koloid.</strong> Distribuuje sa aj do intersticiálnej tekutiny a jeho účinok na plnenie cievneho riečiska závisí od času, koncentrácie, kapilárnych pomerov a súbežnej ultrafiltrácie.</p>

<p>Druhým predpokladaným mechanizmom je zmiernenie rýchleho poklesu extracelulárnej osmolality pri odstraňovaní močoviny a ďalších malých molekúl. Hoci močovina v ustálenom stave nie je významným účinným osmolom naprieč väčšinou bunkových membrán, pri rýchlom dialyzačnom odstraňovaní môžu dočasne vznikať koncentračné gradienty medzi kompartmentmi a voda sa presúva z extracelulárneho do intracelulárneho priestoru. [1, 3] Práve tento mechanizmus bol východiskom klinického skúšania manitolu pri začatí hemodialýzy.</p>

<p>Ide o biologicky prijateľné vysvetlenie možného účinku, nie o dôkaz, že manitol spoľahlivo upraví každú hypotenznú epizódu.</p>

<h2>Čo ukazujú klinické štúdie</h2>

<h3>Observačné údaje: podnet na výskum, nie potvrdenie účinnosti</h3>

<p>Práca Mc Causlanda a spoluautorov z roku 2012 zahrnula 102 po sebe idúcich pacientov vyžadujúcich začatie náhrady funkcie obličiek v dvoch veľkých fakultných nemocniciach. Rutinné podávanie manitolu sa medzi pracoviskami líšilo podľa inštitucionálnych protokolov, čo umožnilo skúmať ho ako hlavnú expozíciu. [2]</p>

<p>V upravených modeloch sa podávanie manitolu spájalo s približne 5,4 mmHg vyššou najnižšou hodnotou systolického tlaku, s asi 25 % menším poklesom tlaku a s približne polovičnou šancou hypotenznej príhody (pomer šancí 0,50; 95 % interval spoľahlivosti od 0,29 do 0,83). Účinok sa nemenil podľa prítomnosti diabetu ani podľa toho, či išlo o akútne alebo chronické ochorenie obličiek. [2, 3]</p>

<p>Keďže nešlo o randomizované porovnanie, výsledok mohli ovplyvniť rozdiely medzi pacientmi, pracoviskami a dialyzačnými predpismi. Takáto štúdia podporuje hypotézu, ale nepreukazuje príčinný účinok lieku. Následná randomizovaná štúdia tej istej skupiny mala túto neistotu zmenšiť.</p>

<h3>Randomizovaná štúdia: primárny výsledok nebol štatisticky významný</h3>

<p>Dvojito zaslepená, placebom kontrolovaná jednocentrová pilotná štúdia (ClinicalTrials.gov NCT01520207) zaradila medzi augustom 2012 a marcom 2016 celkovo 52 pacientov pri začatí hemodialýzy pre akútne poškodenie obličiek alebo progresiu chronickej choroby obličiek. Priemerný vek bol 56 ± 16 rokov, polovicu tvorili ženy, 46 % malo diabetes mellitus a 87 % začínalo dialýzu pre progresiu CKD. Hodnotili sa prvé tri dialyzačné výkony, spolu 156 procedúr. [1]</p>

<div class="table-responsive" role="region" aria-label="Usporiadanie a výsledky randomizovanej štúdie hypertonického manitolu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Výsledok alebo charakteristika</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Skúšaná intervencia</th>
      <td>20 % manitol v dávke 0,25 g/kg/h, najviac 75 g na dialyzačný výkon</td>
    </tr>
    <tr>
      <th scope="row">Kontrolná intervencia</th>
      <td>Objemovo porovnateľné podanie 0,9 % roztoku NaCl (375 ml)</td>
    </tr>
    <tr>
      <th scope="row">Načasovanie</th>
      <td>Infúzia sa ukončovala 30 minút pred koncom dialýzy</td>
    </tr>
    <tr>
      <th scope="row">Primárny výsledok</th>
      <td>Priemerný pokles systolického tlaku 15 ± 11 mmHg pri manitole oproti 19 ± 16 mmHg pri placebe; p = 0,3</td>
    </tr>
    <tr>
      <th scope="row">Primárny výsledok – modelový odhad</th>
      <td>O 3,9 mmHg menší pokles (p = 0,3); po úprave o predialyzačný tlak a dusík močoviny o 4,3 mmHg (p = 0,3)</td>
    </tr>
    <tr>
      <th scope="row">Sekundárny výsledok</th>
      <td>IDH pri 19 zo 75 výkonov s manitolom (25 %) a pri 35 z 81 výkonov s placebom (43 %); jednoduché porovnanie p = 0,02</td>
    </tr>
    <tr>
      <th scope="row">Zohľadnenie opakovaných výkonov u jedného pacienta</th>
      <td>Pomer šancí 0,38; 95 % IS 0,14 až 1,00; p = 0,05</td>
    </tr>
    <tr>
      <th scope="row">Po úprave o predialyzačný tlak a dusík močoviny</th>
      <td>Pomer šancí 0,39; 95 % IS 0,12 až 1,24; p = 0,1</td>
    </tr>
    <tr>
      <th scope="row">Opakované epizódy u jedného pacienta</th>
      <td>Pomer šancí 0,41; 95 % IS 0,15 až 1,13; p = 0,08</td>
    </tr>
  </tbody>
</table>
</div>

<p>Primárny výsledok teda <strong>nepreukázal štatisticky významný rozdiel</strong>. To nie je dôkaz úplnej neúčinnosti, ale ani potvrdenie prínosu.</p>

<p>Pri sekundárnom výsledku bol počet výkonov s IDH nižší v skupine s manitolom. Jednoduché porovnanie podielov dosiahlo p = 0,02, avšak analýza zohľadňujúca závislosť opakovaných meraní u toho istého pacienta poskytla hraničný výsledok p = 0,05. Pri ďalšej úprave o predialyzačný systolický tlak a koncentráciu dusíka močoviny v sére už výsledok konvenčnú hranicu štatistickej významnosti nedosiahol. [1]</p>

<p>Rozdiel medzi týmito analýzami je podstatný. Tri dialýzy jedného pacienta nie sú tri úplne nezávislé pozorovania. Výsledok preto nemožno zjednodušiť na tvrdenie, že manitol „preukázateľne znižuje IDH o viac než polovicu“. Pomer šancí navyše nie je totožný s pomerom rizík – pri výskyte udalostí okolo 25 až 43 % sa obe miery rozchádzajú podstatne.</p>

<h3>Štúdia bola na svoj primárny cieľ výrazne poddimenzovaná</h3>

<p>Veľkosť súboru bola plánovaná tak, aby zachytila rozdiel v poklese systolického tlaku o 11 mmHg. Pozorovaný rozdiel bol však približne trikrát menší. Autori sami prepočítali, že na preukázanie rozdielu takejto veľkosti by bolo potrebných približne <strong>194 účastníkov v každej skupine</strong>, teda zhruba osemnásobok zaradeného súboru. [1]</p>

<p>Negatívny primárny výsledok preto nepreukazuje neúčinnosť – preukazuje, že na túto otázku štúdia nemala dostatočnú výpovednú silu. To je argument pre väčšiu multicentrickú štúdiu, nie pre zmenu klinickej praxe v ktoromkoľvek smere.</p>

<h3>Biomarkery a nežiaduce udalosti</h3>

<p>Väčšina účastníkov mala už pred prvou dialýzou výrazne zvýšené koncentrácie vysokosenzitívneho troponínu T (medián 79 ng/l) a NT-proBNP (medián 5 136 pg/ml). Medzi prvým a tretím výkonom sa zmeny týchto ukazovateľov podľa randomizácie nelíšili, čo autori hodnotia ako upokojujúci signál vo vzťahu k obávanému objemovému preťaženiu. [1]</p>

<p>Exploratívne stanovenia biomarkerov poškodenia obličiek v moči a plazme boli dostupné len u podskupiny 32 posledných zaradených pacientov, neboli upravené o viacnásobné testovanie a nepriniesli konzistentný signál. Nežiaduce udalosti sa vyskytli u 17 pacientov v skupine s manitolom (68 %) a u 18 pacientov v skupine s placebom (66,7 %); najčastejšie išlo o hypertenziu nad 180 mmHg a nevoľnosť. [1]</p>

<h3>Čo zo štúdie nemožno odvodiť</h3>

<p>Výsledky nepreukazujú:</p>

<ul>
  <li>účinnosť bolusu manitolu pri už vzniknutej symptomatickej IDH;</li>
  <li>prínos dlhodobej profylaxie pri udržiavacej hemodialýze;</li>
  <li>zníženie mortality, hospitalizácií alebo klinicky významného orgánového poškodenia;</li>
  <li>bezpečnosť opakovaného podávania u všetkých anurických alebo objemovo preťažených pacientov;</li>
  <li>optimálnu dávku a načasovanie pre bežnú dialyzačnú prax.</li>
</ul>

<p>Zo štúdie boli vylúčení pacienti so závažným objemovým preťažením, s predialyzačnou koncentráciou sodíka pod 130 mmol/l, s infarktom myokardu, cievnou mozgovou príhodou alebo záchvatom v posledných siedmich dňoch, s nestabilnou komorovou arytmiou, s nestabilnou angínou, po transplantácii srdca a pacienti užívajúci vazopresory alebo midodrín. [1] Podobná frekvencia nežiaducich udalostí medzi skupinami preto neoprávňuje vyhlásiť manitol za všeobecne bezpečný pre rizikovú dialyzačnú populáciu – práve najrizikovejší pacienti v súbore neboli.</p>

<p>Štúdia tiež nemerala koncentrácie manitolu ani intradialyzačnú osmolalitu plazmy, takže skutočne dodaná osmotická dávka zostáva nepriamym odhadom. [1]</p>

<h2>Dávkovanie: výskumný režim nie je univerzálny protokol</h2>

<p>V klinických prehľadoch a lokálnych postupoch sa možno stretnúť s rôznymi dávkami manitolu. Bez konkrétneho zdroja však nemožno tvrdiť, že 50 až 100 ml 20 % roztoku predstavuje overenú štandardnú dávku na liečbu IDH.</p>

<p>Dôležité je aj správne prepočítanie:</p>

<ul>
  <li>50 ml 20 % roztoku obsahuje 10 g manitolu;</li>
  <li>100 ml obsahuje 20 g;</li>
  <li>dávka 0,25 až 0,5 g/kg zodpovedá pri hmotnosti 70 kg množstvu 17,5 až 35 g, teda 87,5 až 175 ml 20 % roztoku.</li>
</ul>

<p>Tieto rozsahy nie sú vzájomne ekvivalentné.</p>

<p>Randomizovaná štúdia používala <strong>0,25 g/kg za hodinu</strong>, nie jednorazovú dávku 0,25 g/kg. Išlo o infúzny výskumný režim počas prvých troch hemodialýz, s maximom 75 g na výkon a ukončením infúzie 30 minút pred koncom procedúry. Tento režim nemožno bez ďalšieho preniesť na rýchly záchranný bolus. [1]</p>

<p>Manitol má molekulovú hmotnosť 182 daltonov a je dobre dialyzovateľný. Jeho výsledná koncentrácia preto závisí od dávky, rýchlosti podávania, zvyškovej funkcie obličiek a dialyzačného klírensu. Ukončenie infúzie pred koncom výkonu malo v štúdii umožniť ďalšie odstránenie cirkulujúceho manitolu; podporuje to aj podobná poexpozičná osmolalita plazmy v oboch skupinách. [1] Neznamená to však, že existuje univerzálne overené pravidlo podávať ho v prvej alebo strednej tretine každej dialýzy.</p>

<h2>Čo o manitole hovorí registračná dokumentácia</h2>

<p>Pri lieku, ktorý sa v nefrologickej praxi zvažuje mimo schválenej indikácie, je obsah súhrnu charakteristických vlastností lieku (SPC) rovnako podstatný ako publikované štúdie. Pri prípravkoch 20 % manitolu registrovaných na Slovensku sa medzi <strong>kontraindikáciami</strong> uvádzajú okrem iného:</p>

<ul>
  <li>precitlivenosť na liečivo alebo na pomocné látky;</li>
  <li>existujúca hyperosmolarita plazmy;</li>
  <li>závažná dehydratácia;</li>
  <li><strong>rozvinutá anúria</strong>;</li>
  <li>závažné zlyhávanie srdca;</li>
  <li><strong>závažné prekrvenie pľúc alebo pľúcny edém</strong>;</li>
  <li>aktívne intrakraniálne krvácanie okrem stavu po kraniotómii a porucha hematoencefalickej bariéry;</li>
  <li>chýbajúca odpoveď na testovaciu dávku;</li>
  <li>progredujúca porucha funkcie obličiek po začatí podávania manitolu vrátane narastajúcej oligúrie a azotémie. [6]</li>
</ul>

<p>Tento zoznam má pre dialyzačnú prax priamy dosah. Značná časť pacientov na udržiavacej hemodialýze je anurická a nezriedka aj objemovo preťažená. U takého pacienta nejde len o použitie mimo schválenej indikácie, ale o podanie napriek výslovne uvedenej kontraindikácii. To je kvalitatívne iná situácia a vyžaduje individuálne odôvodnené a zdokumentované lekárske rozhodnutie.</p>

<p>Dokumentácia ďalej vyžaduje pozorné sledovanie výdaja moču, bilancie tekutín, centrálneho venózneho tlaku a elektrolytov, ako aj sledovanie rozdielov v osmolarite séra spolu s funkciou obličiek. Pri poklese výdaja moču počas infúzie sa má podávanie zastaviť a náhla expanzia mimobunkovej tekutiny môže viesť k náhlemu kongestívnemu zlyhávaniu srdca. Odporúčané denné dávky pri schválených indikáciách sú 250 až 1 000 ml 20 % roztoku, teda 50 až 200 g manitolu. [6]</p>

<p>Konkrétnu dávku, spôsob podania a podmienky prípadného použitia musí určovať individuálne lekárske rozhodnutie, príslušný režim pracoviska a aktuálne SPC použitého prípravku. Lokálny protokol sám osebe nenahrádza posúdenie kontraindikácií ani odborných a právnych náležitostí použitia mimo schválenej indikácie.</p>

<h2>Bezpečnostné hranice</h2>

<h3>Hyperosmolalita a objemové preťaženie</h3>

<p>Pri výrazne zníženej funkcii obličiek je renálne vylučovanie manitolu obmedzené. Dialýza síce umožňuje jeho odstránenie, ale automaticky nevylučuje akumuláciu pri opakovaných dávkach alebo pri nedostatočnej eliminácii.</p>

<p>Presun vody do extracelulárneho priestoru môže zhoršiť kongesciu a vyvolať alebo zhoršiť pľúcny edém. Priaznivý osmotický účinok predpokladaný pri hypotenzii sa tak u iného pacienta môže stať mechanizmom poškodenia. Anúriu preto nemožno uvádzať iba ako neurčitý dôvod na „opatrnosť“ – v registračnej dokumentácii je uvedená ako kontraindikácia. [6]</p>

<h3>Osmotická nefróza a osmolálny rozdiel</h3>

<p>Vysoké kumulatívne dávky manitolu môžu samy vyvolať akútne poškodenie obličiek. Histologickým korelátom je takzvaná osmotická nefróza – vakuolizácia buniek proximálnych tubulov. Riziko je zvýšené práve u pacientov s už existujúcou poruchou funkcie obličiek. Pri sledovaní kumulatívnej expozície sa osvedčilo meranie <strong>osmolálneho rozdielu</strong>, teda rozdielu medzi meranou a vypočítanou osmolalitou, ktorý odráža prítomnosť nemeraného osmolu v plazme. [5]</p>

<p>U pacienta s pretrvávajúcou zvyškovou funkciou obličiek je táto úvaha relevantná aj preto, že zachovanie reziduálnej diurézy je samostatným prognostickým faktorom a IDH jeho stratu urýchľuje. [3] Súvisiacu problematiku rozoberá článok o <a href="article.php?slug=inkrementalna-hemodialyza-rezidualna-funkcia-obliciek">inkrementálnej hemodialýze a reziduálnej funkcii obličiek</a>.</p>

<h3>Hyponatriémia a ďalšie elektrolytové zmeny</h3>

<p>Osmotický presun vody z buniek môže znižovať koncentráciu sodíka v extracelulárnej tekutine. Pri zvýšenej osmolalite ide o <strong>hypertonickú, translokačnú hyponatriémiu</strong>, nie nevyhnutne o deficit sodíka a nie o laboratórnu pseudohyponatriémiu.</p>

<p>Pri hodnotení treba zohľadniť koncentráciu sodíka, glukózu, meranú osmolalitu, objemový stav a časový vzťah k podaniu manitolu. Samotná nízka koncentrácia sodíka bez tohto kontextu môže viesť k nesprávnej interpretácii. Registračná dokumentácia osobitne upozorňuje, že hyponatriémia môže viesť k bolesti hlavy, nevoľnosti, záchvatom, letargii, kóme, opuchu mozgu a smrti. [6]</p>

<h3>Monitorovanie a manipulácia s roztokom</h3>

<p>Ak sa o manitole individuálne uvažuje, bezpečnostné hodnotenie má zahŕňať najmä krvný tlak, klinické známky perfúzie a kongescie, bilanciu tekutín, elektrolyty a podľa situácie meranú osmolalitu. Pri opakovanom podávaní je dôležité posúdiť možnú akumuláciu.</p>

<p>Koncentrovaný manitol pri nízkych teplotách kryštalizuje. Roztok s viditeľnými časticami sa nesmie podať. Podľa dokumentácie sa kryštáliky rozpúšťajú zahriatím roztoku až do 37 °C, pred podaním sa roztok ochladí na 37 °C a <strong>súprava na podávanie má obsahovať filter</strong>. [6] Všeobecný pokyn „zohriať na telesnú teplotu“ teda nie je dostatočný a požiadavka na filter sa v praxi neraz prehliada.</p>

<h2>IDH a dialyzačný dysekvilibračný syndróm treba odlišovať</h2>

<p>IDH a dialyzačný dysekvilibračný syndróm môžu súvisieť s osmotickými zmenami, ale nejde o totožné komplikácie.</p>

<p>Pri dysekvilibračnom syndróme dominujú neurologické prejavy spojené s rýchlymi zmenami medzi krvou a centrálnym nervovým systémom. Pri IDH je rozhodujúca hemodynamická nestabilita a riziko nedostatočnej orgánovej perfúzie. Obe komplikácie sa môžu vyskytnúť súčasne, ale každá vyžaduje vlastné klinické posúdenie. Podrobnejšie sa téme venuje článok <a href="article.php?slug=dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy">Dialyzačný dysekvilibračný syndróm</a>.</p>

<p>Fyziologické zdôvodnenie manitolu pri osmotických zmenách ani jeho historické použitie pri dysekvilibračných príznakoch nepreukazujú účinnosť pri akútnej IDH. U pacienta s vysokým rizikom dysekvilibrácie nemožno manitolom nahrádzať opatrne zvolený úvodný dialyzačný predpis – v citovanej štúdii práve toto odstupňovanie, teda postupný vzostup prietoku krvi z 200 na 400 ml/min a predĺženie výkonu z dvoch na 3,5 až 4 hodiny, tvorilo základ protokolu v oboch skupinách. [1] Randomizovaná štúdia z roku 2019 nebola dôkazom prevencie závažného neurologického dysekvilibračného syndrómu.</p>

<h2>Čo má pri IDH pevnejší dôkazový základ ako manitol</h2>

<p>Neistý prínos manitolu neznamená, že ktorýkoľvek iný hypertonický roztok je automaticky vhodnou prvou voľbou. Pri porovnaní dostupných možností vychádza poradie priorít pomerne jednoznačne – a najlepšie podložené zásahy sú zároveň tie najlacnejšie.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie opatrení pri opakovanej intradialyzačnej hypotenzii podľa sily dôkazov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Opatrenie</th>
      <th scope="col">Dôkazový základ</th>
      <th scope="col">Poznámka k bezpečnosti</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Chladnejší dialyzát (35 až 36 °C)</th>
      <td>Metaanalýza 26 štúdií so 484 pacientmi: zníženie výskytu IDH o 70 % (95 % IS 49 až 89) a vzostup intradialyzačného tlaku o 12 mmHg (95 % IS 8 až 16) bez zhoršenia adekvátnosti dialýzy</td>
      <td>Prvá voľba podľa EBPG; bez nákladov, limitom je tolerancia chladu</td>
    </tr>
    <tr>
      <th scope="row">Zníženie rýchlosti ultrafiltrácie pod 10 ml/h/kg</th>
      <td>Konzistentné observačné údaje; v registri DOPPS pomer šancí 1,30 pre IDH pri rýchlosti nad 10 ml/h/kg</td>
      <td>Vyžaduje dlhší alebo častejší výkon</td>
    </tr>
    <tr>
      <th scope="row">Biofeedback podľa relatívneho objemu krvi</th>
      <td>Metaanalýza 8 štúdií: pomer rizík 0,61 (95 % IS 0,44 až 0,86)</td>
      <td>Vplyv na mortalitu nie je doložený</td>
    </tr>
    <tr>
      <th scope="row">Intermitentná pneumatická kompresia dolných končatín</th>
      <td>Randomizovaná skrížená štúdia: IDH u 24 % oproti 43 % pri kontrole (p = 0,014)</td>
      <td>Malý súbor, vyžaduje potvrdenie</td>
    </tr>
    <tr>
      <th scope="row">20 % manitol</th>
      <td>Jedna pilotná randomizovaná štúdia s negatívnym primárnym výsledkom; sekundárny výsledok na hranici významnosti</td>
      <td>Rozvinutá anúria a pľúcny edém sú kontraindikácie podľa SPC [6]</td>
    </tr>
    <tr>
      <th scope="row">Sodíkové profilovanie</th>
      <td>Zníženie počtu epizód pri stupňovitom profile</td>
      <td><strong>Bezpečnostný signál:</strong> v kohorte DOPPS (10 250 pacientov) vyššia celková (HR 1,36) aj kardiovaskulárna mortalita (HR 1,34); EBPG neodporúča</td>
    </tr>
    <tr>
      <th scope="row">Midodrín</th>
      <td>Metaanalýza 10 štúdií (117 pacientov): vyššia najnižšia hodnota systolického tlaku o 13,3 mmHg (95 % IS 8,6 až 18,0)</td>
      <td><strong>Bezpečnostný signál:</strong> v retrospektívnej štúdii (1 046 oproti 2 037 pacientom) vyšší pomer incidencie mortality 1,37 (95 % IS 1,15 až 1,62)</td>
    </tr>
    <tr>
      <th scope="row">L-karnitín</th>
      <td>Metaanalýza z roku 2008 prínos nepotvrdila; novšie údaje sú nejednotné</td>
      <td>Perorálne podávanie zvyšuje tvorbu TMAO</td>
    </tr>
  </tbody>
</table>
</div>

<p>Údaje v tabuľke vychádzajú z prehľadu Kanbaya a spoluautorov. [3] Doplňujúci kontext ponúkajú články o <a href="article.php?slug=injekcny-l-karnitin-tmao-hemodialyza">injekčnom L-karnitíne a TMAO</a> a o <a href="article.php?slug=dennik-semafor-objemovy-manazment-hemodialyza-rct">objemovom manažmente pri hemodialýze</a>.</p>

<h2>Postup pri akútnej a opakovanej IDH</h2>

<p>Pri symptomatickej hypotenzii je potrebné bezodkladne zhodnotiť pacienta, obmedziť alebo zastaviť ultrafiltráciu a hľadať príčinu. Európske odporúčania z roku 2007 uvádzajú postupnosť: zastaviť ultrafiltráciu, zvážiť Trendelenburgovu polohu, pri pretrvávaní podať izotonický roztok NaCl a pri ďalšej neodpovedi zvážiť koloidný roztok. [3]</p>

<p>Polohu v ľahu s prípadným zdvihnutím dolných končatín však treba voliť podľa tolerancie a respiračného stavu. Trendelenburgova poloha nemá byť automatickým krokom u každého pacienta, najmä pri dyspnoe alebo kongescii.</p>

<p>Pri predpokladanom poklese intravaskulárneho objemu sa používa opatrné podanie izotonického roztoku NaCl s priebežným prehodnotením odpovede. Objem tekutiny nemožno oddeliť od aktuálneho klinického stavu a každý podaný objem sa premietne do ďalšej ultrafiltračnej záťaže. Tento rámec nie je náhradou lokálneho urgentného postupu.</p>

<p>Pretrvávajúca alebo neobvykle závažná hypotenzia vyžaduje pátranie aj po iných príčinách, napríklad po arytmii, akútnej ischémii myokardu, krvácaní, infekcii alebo reakcii súvisiacej s dialyzačným okruhom. Podávanie ďalších bolusov nesmie odložiť diagnostiku závažného stavu.</p>

<p>Pri opakovanej IDH má prednosť revízia cieľovej hmotnosti, rýchlosti ultrafiltrácie, dĺžky výkonu, medzidialyzačných hmotnostných prírastkov, teploty dialyzátu a medikácie. Zníženie ultrafiltračnej záťaže môže vyžadovať dlhší alebo častejší výkon. Pri obmedzovaní medzidialyzačných prírastkov je rozhodujúce obmedzenie príjmu sodíka, nie samotné obmedzenie tekutín – bez neho smäd znemožní akúkoľvek snahu o nižší príjem. [3]</p>

<p>Hypertonický NaCl, hypertonická glukóza, albumín a midodrín nie sú navzájom zameniteľné alternatívy:</p>

<ul>
  <li>hypertonický NaCl prináša sodíkovú záťaž a môže zvyšovať smäd a medzidialyzačné prírastky;</li>
  <li>hypertonická glukóza môže vyvolať hyperglykémiu;</li>
  <li>albumín nemožno automaticky považovať za lepší objemový expandér pre každého pacienta;</li>
  <li>midodrín zvyšuje najnižšiu hodnotu systolického tlaku, observačné údaje však priniesli bezpečnostný signál vyššej mortality a hospitalizácií, preto sa rutinné použitie bez prospektívneho potvrdenia neodporúča; [3]</li>
  <li>sodíkové profilovanie môže viesť k pozitívnej sodíkovej bilancii a v kohorte DOPPS sa spájalo s vyššou mortalitou. [3]</li>
</ul>

<p>Každá z týchto možností vyžaduje samostatné zhodnotenie indikácie, dôkazov a bezpečnosti.</p>

<h2>Klinický záver</h2>

<p>Dvadsaťpercentný manitol má pri hemodialýze fyziologicky zdôvodniteľný osmotický účinok, ale dôkazy o jeho klinickom prínose pri IDH zostávajú obmedzené. Najdôležitejšia randomizovaná štúdia nepreukázala významné zlepšenie primárneho výsledku, bola na túto otázku výrazne poddimenzovaná a poskytla iba neistý signál nižšieho výskytu hypotenzných epizód pri začatí dialyzačnej liečby. Ani jedna z dostupných štúdií nehodnotila vplyv na objemové preťaženie ani na dlhodobé výsledky. [3]</p>

<p>Nie je preto primerané prezentovať manitol ako štandardnú záchrannú liečbu po neúspechu fyziologického roztoku ani ako rutinnú profylaxiu pri udržiavacej hemodialýze. Prípadné použitie je individuálnym odborným rozhodnutím s osobitným posúdením osmotického mechanizmu, objemového stavu, možnosti eliminácie a podmienok uvedených v aktuálnom SPC – vrátane skutočnosti, že rozvinutá anúria je v ňom uvedená ako kontraindikácia.</p>

<p>Rozhodujúcim klinickým princípom zostáva odstránenie príčiny hemodynamickej nestability a úprava dialyzačného predpisu, nie opakované kompenzovanie zle tolerovaného výkonu hypertonickými infúziami. Opatrenia s najpevnejším dôkazovým základom – chladnejší dialyzát, nižšia rýchlosť ultrafiltrácie a obmedzenie príjmu sodíka – sú zároveň tie, ktoré nestoja takmer nič.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<p><em>1. Mc Causland FR, Claggett B, Sabbisetti VS, Jarolim P, Waikar SS. Hypertonic Mannitol for the Prevention of Intradialytic Hypotension: A Randomized Controlled Trial. American Journal of Kidney Diseases. 2019;74(4):483–490. <a href="https://doi.org/10.1053/j.ajkd.2019.03.415" target="_blank" rel="noopener noreferrer">DOI: 10.1053/j.ajkd.2019.03.415</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/31040088/" target="_blank" rel="noopener noreferrer">PubMed, PMID 31040088</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6756938/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text v PubMed Central</a>.</em></p>

<p><em>2. Mc Causland FR, Prior LM, Heher E, Waikar SS. Preservation of Blood Pressure Stability with Hypertonic Mannitol during Hemodialysis Initiation. American Journal of Nephrology. 2012;36(2):168–174. <a href="https://doi.org/10.1159/000341273" target="_blank" rel="noopener noreferrer">DOI: 10.1159/000341273</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/22846598/" target="_blank" rel="noopener noreferrer">PubMed, PMID 22846598</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3779621/" target="_blank" rel="noopener noreferrer">PubMed Central</a>.</em></p>

<p><em>3. Kanbay M, Ertuglu LA, Afsar B, Ozdogan E, Siriopol D, Covic A, Basile C, Ortiz A. An update review of intradialytic hypotension: concept, risk factors, clinical implications and management. Clinical Kidney Journal. 2020;13(6):981–993. <a href="https://doi.org/10.1093/ckj/sfaa078" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ckj/sfaa078</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/33391741/" target="_blank" rel="noopener noreferrer">PubMed, PMID 33391741</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7769545/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>4. Habas E, Rayani A, Habas A, Farfar K, Habas E, Alarbi K, Habas A, Errayes E, Alfitori G. Intradialytic Hypotension Pathophysiology and Therapy Update: Review and Update. Blood Pressure. 2025;34(1):1–18. <a href="https://doi.org/10.1080/08037051.2025.2469260" target="_blank" rel="noopener noreferrer">DOI: 10.1080/08037051.2025.2469260</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/40013364/" target="_blank" rel="noopener noreferrer">PubMed, PMID 40013364</a>.</em></p>

<p><em>5. Visweswaran P, Massin EK, DuBose TD Jr. Mannitol-induced acute renal failure. Journal of the American Society of Nephrology. 1997;8(6):1028–1033. <a href="https://doi.org/10.1681/ASN.V861028" target="_blank" rel="noopener noreferrer">DOI: 10.1681/ASN.V861028</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/9189872/" target="_blank" rel="noopener noreferrer">PubMed, PMID 9189872</a>.</em></p>

<p><em>6. Súhrn charakteristických vlastností lieku Mannitol Fresenius Kabi 20 % infúzny roztok, časti 4.1 až 4.4 a 6.6. Údaje o kontraindikáciách, monitorovaní, dávkovaní a manipulácii s roztokom boli overené v znení dostupnom na slovenských liekových databázach (<a href="https://www.adc.sk/databazy/produkty/spc/mannitol-fresenius-kabi-20-869901.html" target="_blank" rel="noopener noreferrer">ADC.sk</a>). Pred použitím je potrebné overiť aktuálne platné znenie SPC konkrétneho prípravku.</em></p>

<p><em>Bibliografické údaje zdrojov č. 1 až 5 boli overené cez PubMed, vrátane plných textov zdrojov č. 1 a 3 v PubMed Central.</em></p>
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
                error_log('add_manitol_idh newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_manitol_idh pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_manitol_idh pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_manitol_idh migration error: ' . $e->getMessage());
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
