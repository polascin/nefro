<?php
/**
 * Odborne a jazykovo revidovaný článok o zástave obehu počas hemodialýzy.
 * Spracovanie komentára z CodeBlue (Galen Centre) s vecnou korekciou podľa
 * odporúčaní ERC 2021/2025. Pôvodní autori zdroja sú v source_authors.php.
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
    'title'        => 'Zástava obehu počas hemodialýzy: mimotelový okruh, katétrový zámok a tichá záťaž dialyzačných sestier',
    'slug'         => 'zastava-obehu-pocas-hemodialyzy-mimotelovy-okruh',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Resuscitácia na dialyzačnej sále má vlastné pravidlá. Európske odporúčania žiadajú krv z mimotelového okruhu vrátiť, nie ju opustiť – a hyperkaliémia nie je jediná príčina, na ktorú treba myslieť.',
    'content'      => <<<'HTML'
<p>Dialyzačná sála pôsobí na prvý pohľad pokojne: pacienti v polohovateľných kreslách, tichý chod prístrojov, sestra prechádzajúca od monitora k monitoru. Za týmto obrazom sa však skrýva prostredie s vysokou akútnosťou. Zástava obehu počas hemodialýzy nie je bežná resuscitácia – popri pacientovi treba súčasne zvládnuť mimotelový okruh, cievny prístup aj prístroj pripojený k elektrickej sieti.</p>

<p>Komentár dvoch vysokoškolských učiteliek ošetrovateľstva z Malajzie tento problém pomenúva presne v rovine personálnej a organizačnej záťaže. Časť jeho klinických odporúčaní sa však rozchádza s platnými európskymi usmerneniami. Práve preto stojí za to prejsť jednotlivé tvrdenia po jednom – nie ako polemiku, ale ako podklad pre miestny protokol.</p>

<h2>Čo pôvodný text tvrdí</h2>

<ul>
  <li>Štandardné algoritmy rozšírenej neodkladnej resuscitácie na dialyzačnej sále nestačia; sestra musí naraz zvládnuť pacienta, cievny prístup aj prístroj.</li>
  <li>Krvnú pumpu treba okamžite zastaviť a krv v mimotelovom okruhu <em>opustiť</em>, pretože zdržanie kompresií pre návrat malého objemu krvi škodí.</li>
  <li>Pred podaním liekov cez tunelizovaný centrálny venózny katéter treba aspirovať obidve ramená, inak sa do obehu dostane veľký bolus heparínu.</li>
  <li>Najpravdepodobnejším spúšťačom zástavy v populácii s terminálnym zlyhaním obličiek je ťažká hyperkaliémia.</li>
  <li>Zvrat hyperkaliémie vyžaduje presnú a rýchlu kombináciu vápnika, inzulínu, glukózy a hydrogénuhličitanu sodného.</li>
  <li>Zákon Act 586 a jeho kontrolný orgán vyžadujú od súkromných stredísk podiel sestier so špecializáciou v nefrologickom ošetrovateľstve a auditované vozíky s pohotovostným vybavením vrátane defibrilátora.</li>
  <li>Po obnovení spontánneho obehu je pacient kriticky nestabilný a obličky nedokážu vylúčiť podané resuscitačné lieky.</li>
</ul>

<h2>Prvý a najdôležitejší rozpor: krv v mimotelovom okruhu</h2>

<p>Odporúčania Európskej resuscitačnej rady (ERC) pre zástavu obehu za osobitných okolností obsahujú od roku 2021 samostatnú časť venovanú dialyzačnému pracovisku a v aktualizácii z roku 2025 ju zachovávajú takmer bez zmeny. Znenie je jednoznačné: <strong>zastaviť dialýzu a vrátiť pacientovi objem jeho krvi spolu s bolusom tekutiny</strong>, odpojiť ho od prístroja (ak prístroj nie je certifikovaný ako odolný voči defibrilácii), dávať pozor na mokré povrchy, ponechať cievny prístup otvorený a použiť ho na podávanie liekov.</p>

<p>Odporúčanie „krv opustiť“ teda nie je to, čo hovorí súčasné európske usmernenie. Dôvod je fyziologický: pacient je v okamihu zástavy spravidla po niekoľkých hodinách ultrafiltrácie, teda v stave relatívnej hypovolémie. Mimotelový okruh pritom obsahuje rádovo 200 ml krvi (podľa typu setu a dialyzátora približne 150–300 ml). Tento objem nie je zanedbateľný a jeho návrat pôsobí rovnakým smerom ako odporúčaný bolus tekutiny.</p>

<p>Obava pôvodného textu je napriek tomu oprávnená – len vedie k inému záveru. Návrat krvi <strong>nesmie</strong> oddialiť kompresie hrudníka ani defibriláciu. Riešením nie je vzdať sa objemu, ale rozdeliť úlohy: jeden člen tímu vedie resuscitáciu, druhý – vyškolený na obsluhu prístroja – paralelne ukončuje dialýzu a vracia krv. Presne to ERC formuluje pokynom prideliť obsluhu prístroja vyškolenej osobe. Ak takáto osoba k dispozícii nie je, prednosť majú vždy kompresie a výboj.</p>

<h2>Katétrový zámok: riziko, ktoré sa dá vyčísliť</h2>

<p>Upozornenie na heparínový zámok patrí k najcennejším častiam pôvodného textu a je vecne správne. Tunelizované dialyzačné katétre sa medzi sedeniami plnia uzamykacím roztokom, ktorý má zabrániť trombóze. Pri nefrakcionovanom heparíne sa v praxi používajú koncentrácie v rozpätí <strong>1 000 – 10 000 U/ml</strong> a plniaci objem jedného ramena býva približne 1,3–2,0 ml. Obsah jedného ramena teda predstavuje rádovo 1 300 až 20 000 jednotiek heparínu – množstvo, ktoré po podaní do centrálnej žily nie je nevinné.</p>

<p>Správny postup preto je odsať uzamykací roztok (spravidla plniaci objem ramena s malou rezervou) a až potom katéter použiť. V praxi to trvá sekundy a nie je dôvod tento krok vynechávať. Zároveň platí, že ide o úkon, ktorý sa vykonáva súbežne s kompresiami, nie namiesto nich.</p>

<p>Niekoľko doplnení, ktoré pôvodný text neuvádza:</p>

<ul>
  <li>Ak je pacient v okamihu zástavy <strong>napichnutý na fistule alebo grafte</strong>, tento prístup je okamžite použiteľný na podanie liekov a odsávanie zámku odpadá.</li>
  <li>Časť stredísk už nepoužíva vysoko koncentrovaný heparín, ale <strong>citrátový zámok</strong> (najčastejšie 4 %). Riziko systémovej antikoagulácie je pri ňom nižšie, ale rovnaký princíp – najprv odsať, potom podávať – platí aj tu.</li>
  <li>Ak sa zámok nepodarí odsať (napríklad pre nasatie steny cievy), stále je bezpečnejšie použiť periférnu kanylu alebo intraoseálny prístup než tlačiť neurčitý objem zámku do obehu.</li>
</ul>

<h2>Elektrická bezpečnosť a defibrilácia</h2>

<p>Dialyzačný prístroj je zdravotnícka elektrická technika pripojená k sieti a k pacientovi cez vodivý stĺpec krvi a dialyzačného roztoku. ERC preto žiada pacienta pred výbojom od prístroja odpojiť, ak prístroj nie je certifikovaný ako odolný voči defibrilácii, a upozorňuje na mokré povrchy – rozliaty dialyzačný roztok pod nohami zachraňujúceho nie je len technická poznámka.</p>

<p>To všetko sa dá zvládnuť bez straty času len vtedy, ak je postup nacvičený. Simulačný tréning, ktorý sa zastaví pri pokyne „začni kompresie“, ale nezahŕňa samotný prístroj, na dialyzačnej sále nestačí.</p>

<h2>Hyperkaliémia: pravdepodobná príčina, no nie dokázane najčastejšia</h2>

<p>Tvrdenie, že hyperkaliémia je „najpravdepodobnejším spúšťačom“ zástavy pri dialýze, je klinicky pochopiteľné, ale dostupné údaje ho v takejto podobe nepotvrdzujú.</p>

<p>Štúdia <em>Monitoring in Dialysis</em> implantovala 66 pacientom na udržiavacej hemodialýze slučkové záznamníky a sledovala ich šesť mesiacov. U 44 pacientov zaznamenala 1 678 klinicky významných arytmických príhod, z toho <strong>1 461 bradyarytmií, 14 epizód asystólie a jedinú epizódu zotrvalej komorovej tachykardie</strong>. Terminálny rytmus u dialyzovaných pacientov teda zďaleka nie je len obraz hyperkaliemickej komorovej fibrilácie, ako sa často predpokladá.</p>

<p>Prípadovo-kontrolná analýza 502 náhlych zástav obehu vzniknutých priamo v dialyzačných strediskách oproti 1 632 kontrolám udáva výskyt <strong>4,5 zástavy na 100 000 dialyzačných procedúr</strong> a identifikuje ako rizikové faktory expozíciu dialyzačnému roztoku s draslíkom pod 2 mmol/l, roztok s nízkym obsahom vápnika a vyšší ultrafiltračný objem. Ide teda o rizikové faktory na strane <em>preskripcie dialýzy</em>, nie iba na strane pacientovej diétnej spolupráce.</p>

<p>Samostatnou kapitolou je načasovanie. V americkej kohorte s 32 065 pacientmi na trikrát týždennom režime bola úmrtnosť v prvý deň po dlhom medzidialyzačnom intervale <strong>22,1 oproti 18,0 úmrtia na 100 pacientorokov</strong> v ostatné dni. Pondelok, respektíve utorok teda nie je len organizačná zvláštnosť rozpisu.</p>

<p>V diferenciálnej diagnostike zástavy na dialyzačnej sále preto popri hyperkaliémii patria aj intradialytická hypotenzia s ťažkou hypovolémiou, arytmia na podklade štrukturálneho ochorenia srdca, akútny koronárny syndróm, vzduchová embólia, hemolýza pri chybe dialyzačného roztoku alebo jeho prehriatí, anafylaktoidná reakcia na dialyzátor a krvácanie z cievneho prístupu. Hypokaliémia po agresívnej korekcii je pritom rovnako reálna hrozba ako hyperkaliémia pred ňou.</p>

<h2>Ak je príčinou hyperkaliémia: čo presne podať</h2>

<p>Smer, ktorý pôvodný text naznačuje, je správny, formulácia o „presnom koktaile“ však zastiera dôležité rozdiely v úlohe jednotlivých liekov. Pri zástave obehu s podozrením na ťažkú hyperkaliémiu ERC odporúča:</p>

<div class="table-responsive" role="region" aria-label="Liečba hyperkaliemickej zástavy obehu podľa odporúčaní ERC" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Krok</th>
      <th scope="col">Dávka</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Potvrdiť hyperkaliémiu</th>
      <td>Analyzátor krvných plynov pri lôžku</td>
      <td>Čakanie na centrálne laboratórium počas resuscitácie nemá zmysel.</td>
    </tr>
    <tr>
      <th scope="row">Stabilizovať myokard</th>
      <td>10 ml 10 % chloridu vápenatého i. v. rýchlym bolusom</td>
      <td>Alternatívne 30 ml 10 % glukonátu vápenatého. Pri refraktérnej alebo dlhotrvajúcej zástave zvážiť opakovanie.</td>
    </tr>
    <tr>
      <th scope="row">Presunúť draslík do buniek</th>
      <td>10 j. rozpustného inzulínu s 25 g glukózy i. v.</td>
      <td>Nástup účinku je v desiatkach minút – nejde o okamžite život zachraňujúci krok. Po obnovení obehu sledovať glykémiu a podávať 10 % glukózu.</td>
    </tr>
    <tr>
      <th scope="row">Hydrogénuhličitan sodný</th>
      <td>50 mmol i. v.</td>
      <td>V algoritme zástavy áno; mimo zástavy je jeho úloha oveľa spornejšia a riadi sa acidobázickým stavom.</td>
    </tr>
    <tr>
      <th scope="row">Odstrániť draslík z tela</th>
      <td>Dialýza</td>
      <td>Jediná definitívna liečba. Pri refraktérnej hyperkaliemickej zástave sa zvažuje aj počas resuscitácie – vyžaduje skúsený tím a vybavenie.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Dôležité rozlíšenie: inhalačný salbutamol (10–20 mg v nebulizácii) a perorálne viažuce látky, napríklad cyklosilikát zirkoničito-sodný, patria k pacientovi <strong>so zachovaným obehom</strong>. Počas zástavy sa nebulizácia ani perorálne podanie uskutočniť nedajú.</p>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola kľúčových tvrdení pôvodného komentára o resuscitácii počas hemodialýzy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Resuscitácia počas hemodialýzy si vyžaduje nadstavbu nad štandardný algoritmus</th>
      <td>Potvrdené</td>
      <td>ERC má pre dialyzačné pracovisko samostatný súbor odporúčaní od roku 2021.</td>
    </tr>
    <tr>
      <th scope="row">Krv v mimotelovom okruhu treba opustiť</th>
      <td>Nesprávne</td>
      <td>ERC 2021 aj 2025 žiadajú dialýzu zastaviť a objem krvi pacientovi vrátiť spolu s bolusom tekutiny. Návrat však nesmie oddialiť kompresie ani defibriláciu – preto sa prideľuje samostatná obsluha prístroja.</td>
    </tr>
    <tr>
      <th scope="row">Pred podaním liekov cez tunelizovaný katéter treba odsať uzamykací roztok</th>
      <td>Potvrdené</td>
      <td>Pri koncentrácii 1 000–10 000 U/ml a plniacom objeme 1,3–2,0 ml na rameno ide rádovo o 1 300–20 000 jednotiek heparínu.</td>
    </tr>
    <tr>
      <th scope="row">Hyperkaliémia je najpravdepodobnejší spúšťač zástavy pri terminálnom zlyhaní obličiek</th>
      <td>Neisté</td>
      <td>Kontinuálne monitorovanie ukazuje prevahu bradyarytmií a asystólie nad komorovými arytmiami. Hyperkaliémia je dôležitá a odstrániteľná príčina, nie však doložene najčastejšia.</td>
    </tr>
    <tr>
      <th scope="row">Vápnik, inzulín s glukózou a hydrogénuhličitan pri hyperkaliemickej zástave</th>
      <td>Potvrdené s výhradou</td>
      <td>Zodpovedá algoritmu ERC, ale nejde o rovnocenné zložky „koktailu“: vápnik pôsobí okamžite, inzulín s glukózou v desiatkach minút, definitívnym riešením je dialýza.</td>
    </tr>
    <tr>
      <th scope="row">Regulátor vyžaduje kvalifikovaný personál a auditované pohotovostné vybavenie</th>
      <td>Čiastočne overiteľné</td>
      <td>Samotný text zákona z roku 1998 takéto detaily neobsahuje; vyplývajú z licenčných a akreditačných štandardov pre dialyzačné strediská (kvalifikácia vedúcej sestry, minimálne pol roka nefrologickej praxe u ošetrujúceho personálu). Konkrétny percentuálny podiel sa z verejne dostupného znenia potvrdiť nedá.</td>
    </tr>
    <tr>
      <th scope="row">Obličky nedokážu vylúčiť podané resuscitačné lieky</th>
      <td>Nepresné</td>
      <td>Adrenalín sa odbúrava enzymaticky (COMT a MAO), amiodarón prevažne v pečeni. Skutočným problémom po obnovení obehu je príčina zástavy, objemový a elektrolytový stav, glykémia po inzulíne a potreba pokračovať v eliminačnej liečbe.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Po obnovení spontánneho obehu</h2>

<p>Samostatné dialyzačné stredisko nie je pracovisko intenzívnej starostlivosti a pôvodný text má pravdu, že po obnovení obehu sa ťažisko problému presúva na dopravu a na kapacitu prijímajúceho zariadenia. Klinicky pritom v prvých hodinách rozhodujú štyri veci:</p>

<ol>
  <li><strong>Príčina.</strong> Ak sa zástava vysvetlila hyperkaliémiou, treba doriešiť jej zdroj a naplánovať ďalšiu eliminačnú liečbu. Ak nie, prioritou je kardiologické a zobrazovacie došetrenie.</li>
  <li><strong>Objem a elektrolyty.</strong> Pacient je po ultrafiltrácii, po bolusoch tekutín aj po vápniku a hydrogénuhličitane – kaliémiu, kalcémiu, natrémiu a acidobázický stav treba kontrolovať opakovane.</li>
  <li><strong>Glykémia.</strong> Po podaní inzulínu hrozí oneskorená hypoglykémia; pri anúrii pretrváva účinok inzulínu dlhšie než u pacienta so zachovanou funkciou obličiek.</li>
  <li><strong>Pokračovanie eliminačnej liečby.</strong> ERC výslovne uvádza, že dialýza môže byť potrebná už vo včasnom poresuscitačnom období. Práve tu vzniká tlak na lôžka intenzívnej starostlivosti a na kontinuálne metódy.</li>
</ol>

<h2>Čo z toho vyplýva pre dialyzačné stredisko</h2>

<ol>
  <li><strong>Písomný protokol ako nadstavba nad rozšírenou neodkladnou resuscitáciou.</strong> Musí odpovedať na otázku „čo robím s okruhom a s prístrojom“, nie iba „ako stláčam hrudník“.</li>
  <li><strong>Rozdelené úlohy.</strong> Vedúci resuscitácie, obsluha prístroja a osoba pre lieky a cievny prístup. Bez rozdelenia úloh sa návrat krvi a odsatie zámku nevyhnutne menia na zdržanie.</li>
  <li><strong>Nacvičená manipulácia s katétrom.</strong> Odsatie uzamykacieho roztoku má byť reflex, nie rozhodnutie.</li>
  <li><strong>Dostupnosť analyzátora krvných plynov</strong> alebo iného rýchleho stanovenia kaliémie priamo na pracovisku.</li>
  <li><strong>Kontrola preskripcie dialýzy ako prevencia.</strong> Draslík v dialyzačnom roztoku pod 2 mmol/l, nízky obsah vápnika v roztoku a vysoká ultrafiltračná rýchlosť sú modifikovateľné rizikové faktory.</li>
  <li><strong>Zvýšená pozornosť po dlhom medzidialyzačnom intervale</strong> vrátane predialyzačného posúdenia pacienta a rozvahy o rýchlosti korekcie.</li>
  <li><strong>Dohodnutá cesta prevozu.</strong> Kto volá, kam, s akým očakávaným časom a kto zabezpečí pokračovanie eliminačnej liečby.</li>
  <li><strong>Rozbor po udalosti.</strong> Krátky štruktúrovaný rozbor v tíme má na zvládnutie ďalšej príhody väčší vplyv než ktorékoľvek školenie mimo pracoviska.</li>
</ol>

<h2>Personálna záťaž nie je vedľajšia téma</h2>

<p>Jadro pôvodného komentára – že špecializované dialyzačné sestry nesú v ambulantnom prostredí zodpovednosť na úrovni intenzívnej starostlivosti a že odliv kvalifikovaného personálu ohrozuje bezpečnosť – zostáva platné aj po korekcii klinických detailov. Regulačná požiadavka na kvalifikáciu a na pohotovostné vybavenie je z hľadiska bezpečnosti pacienta správna, sama osebe však personál nevytvorí. Zvládnutie zástavy obehu pri dialýze stojí na troch veciach naraz: na znalosti aktuálneho odporúčania, na nacvičenej manipulácii s technikou a na dostatočnom počte ľudí na sále v okamihu, keď na tom záleží.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť</a></li>
  <li><a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">Stanovenie suchej váhy (EDW) pri hemodialýze: klinický odhad, BCM, BVM a POCUS</a></li>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Zaini NH, Che Seman NH. The Silent Burden Of Renal Nurses: Managing Life And Death In Private Dialysis Centres. <em>CodeBlue</em> (Galen Centre for Health and Social Policy). August 2026. <a href="https://codeblue.galencentre.org/2026/08/the-silent-burden-of-renal-nurses-managing-life-and-death-in-private-dialysis-centres/" target="_blank" rel="noopener noreferrer">CodeBlue</a>.</em></small></p>

<p><small><em><strong>Resuscitačné odporúčanie:</strong> Lott C, Truhlář A, Alfonzo A, et al. European Resuscitation Council Guidelines 2021: Cardiac arrest in special circumstances. <em>Resuscitation</em>. 2021;161:152–219. doi: 10.1016/j.resuscitation.2021.02.011. <a href="https://pubmed.ncbi.nlm.nih.gov/33773826/" target="_blank" rel="noopener noreferrer">PubMed</a>. Aktualizácia: European Resuscitation Council Guidelines 2025: Special Circumstances in Resuscitation. <a href="https://www.resus.org.uk/professional-library/2025-resuscitation-guidelines/special-circumstances-guidelines" target="_blank" rel="noopener noreferrer">Resuscitation Council UK</a>.</em></small></p>

<p><small><em><strong>Arytmie pri hemodialýze:</strong> Roy-Chaudhury P, Tumlin JA, Koplan BA, et al. Primary outcomes of the Monitoring in Dialysis Study indicate that clinically significant arrhythmias are common in hemodialysis patients and related to dialytic cycle. <em>Kidney International</em>. 2018;93(4):941–951. doi: 10.1016/j.kint.2017.11.019. <a href="https://pubmed.ncbi.nlm.nih.gov/29395340/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Modifikovateľné rizikové faktory:</strong> Pun PH, Lehrich RW, Honeycutt EF, Herzog CA, Middleton JP. Modifiable risk factors associated with sudden cardiac arrest within hemodialysis clinics. <em>Kidney International</em>. 2011;79(2):218–227. doi: 10.1038/ki.2010.315. <a href="https://pubmed.ncbi.nlm.nih.gov/20811332/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Dlhý medzidialyzačný interval:</strong> Foley RN, Gilbertson DT, Murray T, Collins AJ. Long interdialytic interval and mortality among patients receiving hemodialysis. <em>New England Journal of Medicine</em>. 2011;365(12):1099–1107. doi: 10.1056/NEJMoa1103313. <a href="https://pubmed.ncbi.nlm.nih.gov/21992122/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Urgentné stavy pri hemodialýze:</strong> Greenberg KI, Choi MJ. Hemodialysis Emergencies: Core Curriculum 2021. <em>American Journal of Kidney Diseases</em>. 2021;77(5):796–809. doi: 10.1053/j.ajkd.2020.11.024. <a href="https://pubmed.ncbi.nlm.nih.gov/33771393/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Cievny prístup a uzamykacie roztoky:</strong> Lok CE, Huber TS, Lee T, et al. KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update. <em>American Journal of Kidney Diseases</em>. 2020;75(4 Suppl 2):S1–S164. doi: 10.1053/j.ajkd.2019.12.001. <a href="https://pubmed.ncbi.nlm.nih.gov/32778223/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Znenie odporúčaní ERC pre dialyzačné pracovisko, bibliografické údaje citovaných štúdií aj text pôvodného komentára boli overené 23. augusta 2026. Uvedené dávky sú prevzaté z platného európskeho algoritmu a nenahrádzajú miestny resuscitačný protokol ani individuálne klinické rozhodnutie.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_zastava_obehu_pocas_hemodialyzy',
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
