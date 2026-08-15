<?php
/**
 * Odborny clanok: myosteatoza pri hemodialyze - CT ukazovatele kvality svalstva.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_myosteatoza-hemodialyza-ct-kvalita-svalstva_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Myosteatóza pri hemodialýze: CT ukazovatele kvality svalstva sú sľubné, zatiaľ však nenahrádzajú funkčné vyšetrenie',
    'slug'         => 'myosteatoza-hemodialyza-ct-kvalita-svalstva',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Japonská štúdia u 114 hemodialyzovaných pacientov spája CT ukazovatele tukovej infiltrácie svalstva so silou stisku ruky. Prierezový dizajn a chýbajúca externá validácia však bránia rutinnému použitiu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Tuková infiltrácia kostrového svalstva môže byť spojená so zníženou svalovou silou aj vtedy, keď celková svalová plocha ešte nie je výrazne redukovaná. Nová štúdia u 114 pacientov na udržiavacej hemodialýze ukázala súvislosť medzi CT ukazovateľmi myosteatózy a silou stisku ruky. Prierezový dizajn, malý počet účastníkov a chýbajúca externá validácia však neumožňujú zaviesť tieto ukazovatele ako samostatné diagnostické testy.</em></p>

<h2>Prečo nestačí merať množstvo svalstva</h2>

<p>Sarkopénia a proteínovo-energetické chradnutie patria medzi závažné komplikácie chronickej choroby obličiek. U pacientov liečených hemodialýzou sa na poškodení svalstva podieľajú starnutie, nízka pohybová aktivita, chronický zápal, metabolická acidóza, inzulínová rezistencia, uremické toxíny, hormonálne zmeny, nedostatočný príjem energie a bielkovín, opakované hospitalizácie a dialyzačný katabolizmus.</p>

<p>Samotné množstvo svalovej hmoty však nevystihuje celý problém. Sval môže mať zachovaný objem, ale zhoršenú kvalitu, zvýšenú tukovú infiltráciu a nízku funkčnú výkonnosť. Jedným z prejavov zhoršenej svalovej kvality je <strong>myosteatóza</strong>, teda zvýšené ukladanie tuku v kostrovom svalstve a medzi jednotlivými svalovými skupinami.</p>

<h2>Čo je myosteatóza</h2>

<p>Myosteatóza nie je jednotný histologický ani zobrazovací jav. Zahŕňa viacero foriem abnormálneho ukladania lipidov:</p>

<ul>
  <li>tuk medzi jednotlivými svalovými skupinami,</li>
  <li>tuk medzi svalovými vláknami,</li>
  <li>lipidy uložené vo svalových bunkách,</li>
  <li>prestavbu svalstva sprevádzanú fibrózou, edémom alebo zmenou svalových vlákien.</li>
</ul>

<p>Na bežnej počítačovej tomografii nemožno tieto zložky priamo a spoľahlivo oddeliť. CT poskytuje nepriamy obraz svalového zloženia prostredníctvom röntgenovej denzity vyjadrenej v Hounsfieldových jednotkách. Sval s vyšším obsahom tuku má spravidla nižšiu priemernú denzitu. Medzisvalové tukové tkanivo možno segmentovať osobitne podľa anatomickej polohy a denzitných hraníc.</p>

<p>Myosteatóza sa nesmie zamieňať s:</p>

<ul>
  <li><strong>nízkou svalovou hmotou</strong>, ktorá vyjadruje zmenšenie množstva svalstva,</li>
  <li><strong>sarkopéniou</strong>, pri ktorej má podľa súčasných konsenzov rozhodujúci význam nízka svalová sila,</li>
  <li><strong>obezitou</strong>, ktorá sa vzťahuje na nadmerné množstvo telesného tuku,</li>
  <li><strong>proteínovo-energetickým chradnutím</strong>, ktoré zahŕňa širší komplex nutričných, metabolických a zápalových abnormalít pri chronickej chorobe obličiek.</li>
</ul>

<p>Pacient môže mať myosteatózu bez výrazného zníženia svalovej plochy. Rovnako môže mať súčasne obezitu, nízku svalovú silu a relatívne zachované množstvo svalstva.</p>

<h2>Prečo môže byť sval pri hemodialýze kvalitatívne poškodený</h2>

<p>Svalová slabosť pri pokročilej chronickej chorobe obličiek nie je iba dôsledkom zmenšenia svalov. Kvalitu svalstva môžu zhoršovať chronický systémový zápal, metabolická acidóza, uremická mitochondriálna dysfunkcia, inzulínová rezistencia, porucha oxidácie mastných kyselín, intramuskulárne ukladanie lipidov, fyzická nečinnosť, diabetická neuropatia, periférne artériové ochorenie, deficit vitamínu D, anémia, srdcové zlyhávanie, opakované infekcie a hospitalizácie aj lieky spojené s myopatiou alebo sedáciou.</p>

<p>Úbytok svalovej sily môže byť nepomerne väčší než úbytok samotnej svalovej hmoty. Tento jav vysvetľuje, prečo meranie svalovej plochy alebo beztukovej hmoty nemusí dostatočne predpovedať mobilitu a fyzickú výkonnosť.</p>

<h2>Ako možno myosteatózu hodnotiť pomocou CT</h2>

<p>Najčastejšie sa analyzuje priečny rez na úrovni tretieho driekového stavca, označovanej ako L3. V tejto oblasti možno segmentovať brušné a paraspinálne svaly a vypočítať niekoľko parametrov.</p>

<div class="table-responsive" role="region" aria-label="Ukazovatele myosteatózy hodnotené na úrovni tretieho driekového stavca" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výpočet</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Priemerná denzita kostrového svalstva</td>
      <td>priemer v Hounsfieldových jednotkách</td>
      <td>nižšia hodnota naznačuje vyšší obsah tuku alebo inú zmenu zloženia tkaniva</td>
    </tr>
    <tr>
      <td>Podiel svalstva s normálnou denzitou</td>
      <td>plocha normálne denzitného svalstva delená celkovou plochou brušných svalov, v percentách</td>
      <td>vyšší podiel by mal predstavovať priaznivejšiu kvalitu svalstva</td>
    </tr>
    <tr>
      <td>Index nízkodenzitného svalstva</td>
      <td>plocha nízkodenzitného svalstva delená druhou mocninou telesnej výšky</td>
      <td>vyššia hodnota naznačuje viac tkaniva s nepriaznivou denzitou</td>
    </tr>
    <tr>
      <td>Podiel medzisvalového tukového tkaniva</td>
      <td>plocha medzisvalového tuku delená celkovou plochou brušných svalov, v percentách</td>
      <td>vyššia hodnota predstavuje väčší relatívny podiel tuku medzi svalovými štruktúrami</td>
    </tr>
  </tbody>
</table>
</div>

<p>Denzita nie je čistým meraním tuku. Ovplyvniť ju môžu aj edém, fibróza, technické parametre CT, použitie kontrastnej látky a segmentačný protokol. Interpretácia indexu nízkodenzitného svalstva je navyše zložitejšia, pretože absolútna plocha súvisí aj s celkovou telesnou veľkosťou a množstvom svalov.</p>

<h2>Ako bola štúdia vykonaná</h2>

<p>Yajima a Arao z Matsunami General Hospital v japonskej prefektúre Gifu zaradili <strong>114 pacientov na udržiavacej hemodialýze</strong>, ktorí absolvovali CT vyšetrenie a meranie sily stisku ruky.</p>

<p>Na úrovni L3 sa hodnotila priemerná denzita kostrového svalstva, celková plocha brušných svalov, plocha svalstva s normálnou denzitou, plocha svalstva s nízkou denzitou a plocha medzisvalového tukového tkaniva. Z nich autori vypočítali tri nové ukazovatele uvedené v tabuľke vyššie. Ich vzťah k svalovej sile posudzovali korelačnými analýzami, regresnými modelmi a C-štatistikou.</p>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Namerané hodnoty ukazovateľov myosteatózy v skúmanom súbore" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Hodnota</th>
      <th scope="col">Korelácia s priemernou denzitou svalstva</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Priemerná denzita kostrového svalstva</td><td>34,4 ± 9,0 HU</td><td>—</td></tr>
    <tr><td>Podiel svalstva s normálnou denzitou</td><td>58,2 ± 17,0 %</td><td>r = 0,987</td></tr>
    <tr><td>Index nízkodenzitného svalstva</td><td>14,3 ± 5,7 cm²/m²</td><td>r = 0,853</td></tr>
    <tr><td>Podiel medzisvalového tuku</td><td>7,2 % (medzikvartilové rozpätie 3,9 až 12,8 %)</td><td>r = 0,843 po logaritmickej transformácii</td></tr>
  </tbody>
</table>
</div>

<p>Všetky korelácie dosiahli P &lt; 0,0001.</p>

<h3>Takmer dokonalá korelácia nie je dôkazom kvality</h3>

<p>Hodnota r = 0,987 sama osebe nesvedčí o vysokej diagnostickej presnosti. Podiel svalstva s normálnou denzitou je matematicky odvodený z tých istých segmentovaných CT údajov ako priemerná denzita svalstva. Vysoká korelácia preto do značnej miery vyplýva zo spoločnej konštrukcie oboch ukazovateľov.</p>

<p>Nové indexy nemusia predstavovať nezávislú biologickú informáciu. Môžu byť predovšetkým alternatívnym matematickým vyjadrením rovnakého zobrazovacieho fenoménu.</p>

<h3>Súvislosť so silou stisku ruky</h3>

<p>Priemerná svalová denzita aj všetky tri nové ukazovatele boli v mnohorozmerných analýzach nezávisle spojené so silou stisku ruky. Vyšší podiel normálne denzitného svalstva súvisel s vyššou svalovou silou, zatiaľ čo vyšší podiel medzisvalového tuku a väčšia plocha nízkodenzitného svalstva súviseli s nižšou silou.</p>

<p>Štandardizované regresné koeficienty boli 0,305 pre svalovú denzitu, 0,297 pre podiel normálne denzitného svalstva a −0,321 pre podiel medzisvalového tuku. Pri indexe nízkodenzitného svalstva je v abstrakte uvedená hodnota −310. Vzhľadom na rozsah ostatných koeficientov ide takmer isto o chýbajúcu desatinnú čiarku pri hodnote približne −0,310, no bez korekcie vydavateľa nemožno opravenú hodnotu považovať za oficiálne potvrdenú.</p>

<h3>Diagnostická výkonnosť bola rovnaká</h3>

<p>Po úprave na vek a pohlavie mala priemerná svalová denzita C-štatistiku 0,810. Výsledky nových ukazovateľov boli prakticky totožné a rozdiely neboli štatisticky významné.</p>

<div class="table-responsive" role="region" aria-label="Diskriminačná schopnosť jednotlivých ukazovateľov pre nízku silu stisku ruky" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">C-štatistika</th>
      <th scope="col">P oproti svalovej denzite</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Priemerná svalová denzita</td><td>0,810</td><td>—</td></tr>
    <tr><td>Podiel normálne denzitného svalstva</td><td>0,809</td><td>0,84</td></tr>
    <tr><td>Index nízkodenzitného svalstva</td><td>0,810</td><td>0,98</td></tr>
    <tr><td>Podiel medzisvalového tuku</td><td>0,810</td><td>0,97</td></tr>
  </tbody>
</table>
</div>

<p>C-štatistika približne 0,81 predstavuje primeranú diskriminačnú schopnosť v analyzovanom súbore. Neznamená však 81-percentnú presnosť ani 81-percentnú pravdepodobnosť správnej diagnózy u konkrétneho pacienta. Vyjadruje pravdepodobnosť, že model priradí vyššie rizikové skóre náhodne vybranému pacientovi s nízkou silou stisku než pacientovi bez nej.</p>

<p>Keďže hodnotenie prebehlo v tom istom súbore, v ktorom sa skúmali vzťahy a pravdepodobne aj hranice ukazovateľov, výsledok môže byť optimistický. Potrebná je externá validácia.</p>

<h3>Jeden rozdiel v prospech nových indexov</h3>

<p>Bolo by nepresné uzavrieť, že nové ukazovatele nepriniesli oproti svalovej denzite vôbec nič. V modeloch rizika nízkej sily stisku ruky sa objavil rozdiel:</p>

<ul>
  <li>vzostup podielu normálne denzitného svalstva bol nezávisle spojený s <strong>nižším</strong> rizikom nízkej sily stisku, kým samotná priemerná svalová denzita nie,</li>
  <li>vzostup podielu medzisvalového tuku bol nezávisle spojený s <strong>vyšším</strong> rizikom nízkej sily stisku, kým index nízkodenzitného svalstva nie.</li>
</ul>

<p>Presnejšia formulácia teda znie: pri <em>diskriminácii</em> boli všetky ukazovatele rovnocenné, ale pri <em>nezávislej asociácii</em> s rizikom nízkej sily obstáli dva nové indexy tam, kde ich porovnávacie ukazovatele neobstáli.</p>

<p>Aj tento nález však treba čítať opatrne. Pri 114 pacientoch a silne korelovaných premenných je rozdiel typu „jeden ukazovateľ zostal významný a druhý nie“ krehký. Nejde o dôkaz prevahy, ale o hypotézu na overenie vo väčšom a nezávislom súbore.</p>

<h2>Čo výsledky skutočne dokazujú</h2>

<p>Štúdia dokazuje, že vo vybranej skupine pacientov na hemodialýze existovala prierezová asociácia medzi CT charakteristikami svalstva a silou stisku ruky.</p>

<p>Nedokazuje, že:</p>

<ul>
  <li>myosteatóza priamo spôsobila svalovú slabosť,</li>
  <li>CT ukazovatele predpovedajú pády, hospitalizácie alebo mortalitu,</li>
  <li>zmena indexov v čase odzrkadľuje účinok liečby,</li>
  <li>zníženie myosteatózy zlepší klinické výsledky,</li>
  <li>prahové hodnoty možno preniesť na iné dialyzačné populácie,</li>
  <li>CT môže nahradiť meranie svalovej sily a fyzickej výkonnosti.</li>
</ul>

<p>Záver autorov, že ukazovatele sú „klinicky prijateľné“, je silnejší, než umožňujú údaje z jednej prierezovej štúdie. Klinickú použiteľnosť treba potvrdiť reprodukovateľnosťou, štandardizáciou, externou validáciou a preukázaním pridanej hodnoty nad jednoduchšími testami.</p>

<h2>Myosteatóza nie je totožná so sarkopéniou</h2>

<p>Podľa konsenzu EWGSOP2 je nízka svalová sila základným znakom pravdepodobnej sarkopénie. Diagnóza sa potvrdzuje zistením nízkeho množstva alebo zhoršenej kvality svalstva a jej závažnosť sa určuje podľa fyzickej výkonnosti.</p>

<p>CT môže poskytnúť informáciu o množstve a kvalite svalstva, ale nehodnotí silu, nehodnotí schopnosť chôdze ani vstávania, neodhaľuje všetky neurologické alebo kĺbové príčiny slabosti a neposkytuje samostatnú diagnózu sarkopénie.</p>

<p>Nízka sila stisku ruky môže byť ovplyvnená aj:</p>

<ul>
  <li>artrózou a bolesťou ruky,</li>
  <li>syndrómom karpálneho tunela,</li>
  <li>diabetickou alebo uremickou neuropatiou,</li>
  <li>cievnou mozgovou príhodou,</li>
  <li>arteriovenóznou fistulou,</li>
  <li>poruchou prekrvenia končatiny,</li>
  <li>dominantnou rukou,</li>
  <li>motiváciou a schopnosťou porozumieť pokynom.</li>
</ul>

<p>U hemodialyzovaných pacientov je mimoriadne dôležité štandardizovať, na ktorej končatine, v akej polohe a v akom časovom vzťahu k dialýze sa sila stisku merala.</p>

<h2>Technické obmedzenia CT ukazovateľov</h2>

<h3>CT protokol a rekonštrukcia obrazu</h3>

<p>Hounsfieldove jednotky môžu byť ovplyvnené napätím a prúdom röntgenky, hrúbkou rezu, rekonštrukčným algoritmom, použitím iteratívnej rekonštrukcie, typom a kalibráciou prístroja, podaním kontrastnej látky, časovaním kontrastnej fázy a rozsahom artefaktov.</p>

<p>Prahová hodnota získaná na jednom prístroji preto nemusí byť bez validácie vhodná pre iné pracovisko.</p>

<h3>Kontrastná látka</h3>

<p>Intravenózna kontrastná látka mení denzitu svalstva. Ak boli v jednej analýze kombinované natívne a kontrastné vyšetrenia alebo rôzne kontrastné fázy, výsledky môžu byť systematicky skreslené. Na longitudinálne sledovanie treba porovnávať čo najpodobnejšie protokoly.</p>

<h3>Segmentačné hranice</h3>

<p>Rozdelenie na svalstvo s normálnou a nízkou denzitou závisí od zvolených intervalov Hounsfieldových jednotiek, ktoré sa medzi štúdiami líšia. Výsledky ovplyvňuje aj ručná či automatizovaná segmentácia, zahrnutie alebo vylúčenie konkrétnych svalov, oprava nesprávne označených oblastí, skúsenosť hodnotiteľa a softvérový algoritmus.</p>

<p>Bez údajov o zhode medzi hodnotiteľmi a v rámci jedného hodnotiteľa nemožno posúdiť, ako reprodukovateľné vypočítané indexy sú.</p>

<h3>Jediný rez na úrovni L3</h3>

<p>Svalová plocha na úrovni L3 koreluje s celkovým množstvom kostrového svalstva, nie je však jeho priamym meraním. Lokálne zmeny v oblasti trupu nemusia presne odrážať kvalitu svalov dolných končatín, ktoré sú rozhodujúce pre chôdzu, vstávanie a pády.</p>

<h3>Hydratácia</h3>

<p>CT je menej citlivé na hydratáciu než bioimpedančná analýza alebo duálna röntgenová absorpciometria, ani ono však nie je od objemového stavu úplne nezávislé. Intersticiálny edém môže znižovať denzitu tkaniva a imitovať nepriaznivú zmenu svalového zloženia.</p>

<p>Pri hemodialýze preto záleží na tom, či bolo CT aj funkčné vyšetrenie vykonané pred dialýzou, po nej alebo v nedialyzačný deň.</p>

<h2>Prečo sa CT nemá používať ako rutinný skríning</h2>

<p>CT vyšetrenie predstavuje radiačnú záťaž a nemá sa indikovať iba na zistenie myosteatózy, ak výsledok pravdepodobne nezmení liečbu.</p>

<p>Rozumnejším prístupom je <strong>oportunistické hodnotenie</strong> už existujúceho CT brucha vykonaného z inej klinickej indikácie. Takto možno získať informácie o svalovej ploche, denzite a viscerálnom tuku bez dodatočného ožiarenia.</p>

<p>Ani pri oportunistickom hodnotení však nie je vhodné automaticky označiť pacienta za sarkopenického. Nález má viesť k priamemu posúdeniu svalovej sily, mobility, fyzickej výkonnosti, výživového stavu, hydratácie a reverzibilných príčin svalovej slabosti.</p>

<h2>Praktické vyšetrenie pacienta na hemodialýze</h2>

<h3>1. Klinický skríning</h3>

<p>Pozornosť si vyžadujú najmä nechcený úbytok hmotnosti, zhoršenie chôdze, ťažkosti pri vstávaní zo stoličky, opakované pády, zníženie sebestačnosti, nízky príjem potravy, opakované hospitalizácie, dlhodobá fyzická nečinnosť a prítomnosť diabetu, neuropatie či periférneho artériového ochorenia.</p>

<p>Dotazník SARC-F možno použiť ako jednoduchý skríning, ale jeho nízka citlivosť znamená, že negatívny výsledok sarkopéniu nevylučuje.</p>

<h3>2. Meranie svalovej sily</h3>

<p>Silu stisku ruky treba merať štandardizovaným dynamometrom. Vhodné je zaznamenať použitý prístroj, dominantnú končatinu, prítomnosť fistuly alebo cievneho katétra, polohu pacienta, počet pokusov, časovanie voči dialýze a prípadnú bolesť či neurologické obmedzenie. Alternatívou alebo doplnkom je test piatich postavení zo stoličky.</p>

<h3>3. Fyzická výkonnosť</h3>

<p>Použiť možno rýchlosť chôdze, batériu SPPB, teda Short Physical Performance Battery, test Timed Up and Go alebo šesťminútový test chôdze.</p>

<p>Nízka výkonnosť nie je špecifická pre svalové ochorenie. Treba zohľadniť srdcové zlyhávanie, anémiu, pľúcne ochorenie, neuropatiu, artrózu, hypotenziu a periférne artériové ochorenie.</p>

<h3>4. Množstvo a kvalita svalstva</h3>

<p>Podľa dostupnosti možno využiť bioimpedančnú analýzu, duálnu röntgenovú absorpciometriu, ultrasonografiu svalov alebo oportunistickú analýzu existujúceho CT či magnetickej rezonancie.</p>

<p>Každá metóda má vlastné obmedzenia. Bioimpedanciu a absorpciometriu významne ovplyvňuje hydratácia, ultrasonografia závisí od skúsenosti vyšetrujúceho a CT nie je vhodné na rutinné opakované vyšetrenia.</p>

<h3>5. Nutričné a metabolické hodnotenie</h3>

<p>Treba posúdiť príjem energie a bielkovín, zápal a infekciu, metabolickú acidózu, dialyzačnú adekvátnosť, diabetes, objemový stav, anémiu, depresiu, chronickú bolesť, stav chrupu a prehĺtania, ako aj lieky spojené s myopatiou, anorexiou alebo sedáciou.</p>

<p>Sérový albumín je významný prognostický marker, nie je však samostatným meradlom príjmu bielkovín ani svalovej hmoty. Ovplyvňujú ho zápal, hydratácia, pečeňová syntéza a straty bielkovín.</p>

<h2>Možnosti intervencie</h2>

<p>Zistenie myosteatózy samo osebe neurčuje konkrétnu liečbu. Intervencia má vychádzať z funkčného a nutričného hodnotenia.</p>

<h3>Pohybová intervencia</h3>

<p>Progresívny odporový tréning môže zlepšiť svalovú silu a fyzickú výkonnosť. Podľa stavu pacienta možno kombinovať silový tréning, aeróbnu aktivitu, tréning rovnováhy, funkčné cvičenia vstávania a chôdze aj intradialyzačné cvičenie.</p>

<p>Program musí zohľadňovať kardiovaskulárne riziko, riziko pádov, neuropatiu, stav cievneho prístupu a fyzickú rezervu pacienta. Nie je pritom dokázané, že zlepšenie CT denzity svalstva je nevyhnutným sprostredkovateľom klinického prínosu.</p>

<h3>Výživová intervencia</h3>

<p>Nutričný plán má byť individualizovaný a má zohľadniť spontánny príjem potravy, energetické potreby, dialyzačné straty aminokyselín, diabetes, hyperkaliémiu a hyperfosfatémiu, objemový stav, zápal a katabolizmus aj súbežnú obezitu.</p>

<p>Samotné zvýšenie príjmu bielkovín nemusí viesť k tvorbe funkčného svalstva, ak pretrváva nedostatočný energetický príjem, acidóza, zápal alebo úplná fyzická nečinnosť.</p>

<h3>Liečba reverzibilných príčin</h3>

<p>Súčasťou postupu má byť optimalizácia dialyzačnej liečby, acidobázickej rovnováhy, anémie, diabetu, hydratácie, srdcového zlyhávania, chronickej infekcie a zápalu, ako aj bolesti, spánku a depresie.</p>

<p>Pre myosteatózu pri hemodialýze zatiaľ neexistuje špecifický registrovaný liek s preukázaným prínosom na klinické výsledky.</p>

<h2>Metodologické zhodnotenie štúdie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>zameranie na klinicky významnú kvalitu svalstva, nielen na jeho plochu,</li>
  <li>použitie anatomicky štandardizovanej úrovne L3,</li>
  <li>priame porovnanie viacerých CT parametrov medzi sebou,</li>
  <li>súčasné funkčné meranie sily stisku ruky,</li>
  <li>vyhodnotenie diskriminačnej schopnosti pomocou C-štatistiky,</li>
  <li>deklarovaná neprítomnosť relevantných finančných a nefinančných konfliktov záujmov.</li>
</ul>

<h3>Hlavné obmedzenia</h3>

<ol>
  <li><strong>Prierezový dizajn.</strong> Nemožno určiť časovú následnosť ani kauzalitu.</li>
  <li><strong>Malý súbor.</strong> Počet 114 pacientov obmedzuje presnosť regresných aj diagnostických modelov.</li>
  <li><strong>Jednocentrové japonské hodnotenie.</strong> Výsledky nemusia byť prenosné na iné etnické, antropometrické a dialyzačné populácie. V japonskej populácii sa navyše používajú prahové hodnoty AWGS, nie európske hranice EWGSOP2, čo sťažuje priame prevzatie výsledkov do slovenskej praxe.</li>
  <li><strong>Chýbajúca externá validácia.</strong> C-štatistiky boli získané v tom istom súbore.</li>
  <li><strong>Silná matematická závislosť ukazovateľov.</strong> Nové indexy sú odvodené z rovnakých segmentovaných údajov ako priemerná svalová denzita.</li>
  <li><strong>Bez zlepšenia diskriminácie.</strong> Žiadny nový ukazovateľ nemal vyššiu C-štatistiku; rozdiel sa objavil len v modeloch rizika a je pri tejto veľkosti súboru krehký.</li>
  <li><strong>Nejasná klinická pridaná hodnota.</strong> Nie je preukázané, že indexy zlepšujú rozhodovanie nad rámec veku, pohlavia, svalovej sily a bežného nutričného hodnotenia.</li>
  <li><strong>Chýbajú longitudinálne výsledky.</strong> Nehodnotili sa pády, hospitalizácie, strata sebestačnosti ani mortalita.</li>
  <li><strong>Možné reziduálne konfundujúce faktory.</strong> Diabetes, neuropatia, zápal, fyzická aktivita, hydratácia a komorbidity môžu ovplyvňovať CT nález aj silu stisku.</li>
  <li><strong>Pravdepodobná chyba v abstrakte.</strong> Regresný koeficient uvedený ako −310 vyžaduje vydavateľské objasnenie.</li>
  <li><strong>Obmedzená dostupnosť metodických údajov.</strong> Bez úplného textu nemožno podrobne overiť CT protokol, denzitné hranice, reprodukovateľnosť segmentácie, definíciu nízkej svalovej sily a úplnú špecifikáciu modelov.</li>
</ol>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly pri hodnotení myosteatózy a ich odborné spresnenie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Myosteatóza vyjadruje zhoršenú kvalitu svalstva</td><td>Primerané zjednodušenie</td><td>Ide o heterogénne ukladanie tuku a zmeny zloženia tkaniva, nie o jednotný jav.</td></tr>
    <tr><td>Nižšia CT denzita svalstva znamená vyšší obsah tuku</td><td>Vo všeobecnosti áno</td><td>Denzitu ovplyvňujú aj edém, fibróza, kontrastná látka a technika vyšetrenia.</td></tr>
    <tr><td>Nové CT indexy súviseli so silou stisku ruky</td><td>Potvrdené</td><td>Platí pre skúmaný súbor 114 japonských pacientov.</td></tr>
    <tr><td>Nové indexy mali lepšiu diskriminačnú schopnosť</td><td>Nesprávne</td><td>C-štatistiky boli prakticky totožné (0,809 až 0,810).</td></tr>
    <tr><td>Nové indexy nepriniesli oproti denzite vôbec nič</td><td>Nepresné</td><td>V modeloch rizika obstáli podiel normálne denzitného svalstva a podiel medzisvalového tuku tam, kde ich porovnávacie ukazovatele nie.</td></tr>
    <tr><td>Korelácia r = 0,987 dokazuje nezávislú biologickú informáciu</td><td>Nesprávne</td><td>Odráža najmä matematickú závislosť ukazovateľov odvodených z rovnakých dát.</td></tr>
    <tr><td>C-štatistika 0,81 znamená 81-percentnú diagnostickú presnosť</td><td>Nesprávne</td><td>Vyjadruje pravdepodobnosť správneho poradia dvojice pacientov, nie presnosť diagnózy.</td></tr>
    <tr><td>CT indexy môžu samostatne diagnostikovať sarkopéniu</td><td>Nesprávne</td><td>CT nehodnotí svalovú silu, ktorá je podľa konsenzov rozhodujúca.</td></tr>
    <tr><td>CT pri L3 možno použiť na oportunistické hodnotenie svalstva</td><td>Podporené</td><td>Platí, ak už bolo vyšetrenie klinicky indikované z iného dôvodu.</td></tr>
    <tr><td>CT je vhodné vykonávať rutinne na skríning myosteatózy</td><td>Nesprávne</td><td>Radiačná záťaž bez preukázaného vplyvu na rozhodovanie.</td></tr>
    <tr><td>Výsledky možno priamo preniesť na všetkých dialyzovaných pacientov</td><td>Nesprávne</td><td>Ide o jednocentrovú japonskú kohortu bez externej validácie.</td></tr>
    <tr><td>Myosteatóza zvyšuje mortalitu pri hemodialýze</td><td>Neskúmané</td><td>Táto štúdia nehodnotila žiadny klinický výsledok v čase.</td></tr>
    <tr><td>Zníženie myosteatózy zlepší prognózu</td><td>Nedokázané</td><td>Biologicky možná, zatiaľ však neoverená hypotéza.</td></tr>
    <tr><td>Hodnota β = −310 je klinicky vierohodná</td><td>Nesprávne</td><td>Pravdepodobne ide o chýbajúcu desatinnú čiarku pri hodnote −0,310.</td></tr>
    <tr><td>Ukazovatele sú pripravené na rutinné klinické používanie</td><td>Predčasný záver</td><td>Chýba štandardizácia, reprodukovateľnosť aj externá validácia.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Praktický záver</h2>

<p>CT analýza myosteatózy prináša dôležitý pohľad na kvalitu kostrového svalstva u pacientov na hemodialýze. Vyšší podiel svalstva s normálnou denzitou súvisel s lepšou silou stisku ruky, zatiaľ čo väčší podiel nízkodenzitného svalstva a medzisvalového tuku súvisel so svalovou slabosťou.</p>

<p>Nové indexy neposkytli lepšiu diskriminačnú schopnosť než jednoduchšia priemerná svalová denzita, hoci v modeloch rizika obstáli o niečo konzistentnejšie. Ich veľmi silná vzájomná korelácia naznačuje, že vyjadrujú prevažne rovnakú zobrazovaciu informáciu.</p>

<p><strong>V klinickej praxi má najväčší význam oportunistické vyhodnotenie už existujúceho CT. Podozrivý nález má viesť k štandardizovanému meraniu svalovej sily, mobility, nutričného stavu a reverzibilných príčin svalovej dysfunkcie. CT sa nemá indikovať iba na skríning myosteatózy a jeho výsledok sa nemá zamieňať za samostatnú diagnózu sarkopénie.</strong></p>
</div>

<h2>Súvisiaci článok</h2>

<ul>
  <li><a href="article.php?slug=sarkopenia-peritonealna-dialyza-modifikovany-kreatininovy-index">Sarkopénia pri peritoneálnej dialýze: prečo modifikovaný kreatinínový index nestačí</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Yajima T, Arao M.</strong> <em>Associations between novel myosteatosis indices measured by computed tomography and muscle strength in patients undergoing hemodialysis.</em> J Nephrol. Publikované online 14. augusta 2026. doi: 10.1093/joneph/aajag146. Jednocentrová prierezová štúdia u 114 hemodialyzovaných pacientov. <a href="https://doi.org/10.1093/joneph/aajag146" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42599101/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Cruz-Jentoft AJ, Bahat G, Bauer J, a spol.</strong> <em>Sarcopenia: revised European consensus on definition and diagnosis.</em> Age Ageing. 2019;48(1):16–31. doi: 10.1093/ageing/afy169. <a href="https://doi.org/10.1093/ageing/afy169" target="_blank" rel="noopener noreferrer">Konsenzus EWGSOP2</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6322506/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Chen LK, Woo J, Assantachai P, a spol.</strong> <em>Asian Working Group for Sarcopenia: 2019 Consensus Update on Sarcopenia Diagnosis and Treatment.</em> J Am Med Dir Assoc. 2020;21(3):300–307.e2. doi: 10.1016/j.jamda.2019.12.012. <a href="https://doi.org/10.1016/j.jamda.2019.12.012" target="_blank" rel="noopener noreferrer">Konsenzus AWGS</a>.</li>
  <li><strong>Goodpaster BH, Carlson CL, Visser M, a spol.</strong> <em>Attenuation of skeletal muscle and strength in the elderly: The Health ABC Study.</em> J Appl Physiol. 2001;90(6):2157–2165. doi: 10.1152/jappl.2001.90.6.2157. Východisková práca o vzťahu svalovej denzity a sily. <a href="https://doi.org/10.1152/jappl.2001.90.6.2157" target="_blank" rel="noopener noreferrer">Štúdia Health ABC</a>.</li>
  <li><strong>Fouque D, Kalantar-Zadeh K, Kopple J, a spol.</strong> <em>A proposed nomenclature and diagnostic criteria for protein-energy wasting in acute and chronic kidney disease.</em> Kidney Int. 2008;73(4):391–398. doi: 10.1038/sj.ki.5002585. <a href="https://doi.org/10.1038/sj.ki.5002585" target="_blank" rel="noopener noreferrer">Definícia proteínovo-energetického chradnutia</a>.</li>
  <li><strong>Ikizler TA, Burrowes JD, Byham-Gray LD, a spol.</strong> <em>KDOQI Clinical Practice Guideline for Nutrition in CKD: 2020 Update.</em> Am J Kidney Dis. 2020;76(3 Suppl 1):S1–S107. doi: 10.1053/j.ajkd.2020.05.006. <a href="https://doi.org/10.1053/j.ajkd.2020.05.006" target="_blank" rel="noopener noreferrer">Odporúčanie KDOQI</a>.</li>
  <li><strong>Malmstrom TK, Morley JE.</strong> <em>SARC-F: a simple questionnaire to rapidly diagnose sarcopenia.</em> J Am Med Dir Assoc. 2013;14(8):531–532. doi: 10.1016/j.jamda.2013.05.018. <a href="https://doi.org/10.1016/j.jamda.2013.05.018" target="_blank" rel="noopener noreferrer">Pôvodný opis dotazníka</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Všetky číselné údaje boli overené proti abstraktu primárnej publikácie. Časopis Journal of Nephrology vydáva pre Taliansku nefrologickú spoločnosť Oxford University Press, preto má identifikátor DOI predponu 10.1093. Autormi štúdie sú Takahiro Yajima a Maiko Arao, ktorí deklarovali, že nemajú relevantné finančné ani nefinančné konflikty záujmov.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Ide o prierezovú jednocentrovú štúdiu bez externej validácie. Prahové hodnoty odvodené z japonskej populácie vyžadujú samostatné overenie pred použitím v inom prostredí. Zobrazovacie nálezy nemajú nahrádzať funkčné a nutričné vyšetrenie pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_myosteatoza-hemodialyza-ct-kvalita-svalstva_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
