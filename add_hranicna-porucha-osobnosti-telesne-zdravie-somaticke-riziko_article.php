<?php
/**
 * Odborny clanok: hranicna porucha osobnosti a telesne zdravie.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_hranicna-porucha-osobnosti-telesne-zdravie-somaticke-riziko_article.php"
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
    'title'        => 'Hraničná porucha osobnosti a telesné zdravie: vyššiu chorobnosť nemožno vysvetliť iba psychikou',
    'slug'         => 'hranicna-porucha-osobnosti-telesne-zdravie-somaticke-riziko',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Populačná kohorta z Hongkongu spája hraničnú poruchu osobnosti s 5,65-násobným rizikom úmrtia a stratou 13 rokov života. Prehľad somatických rizík, diagnostického zatienenia a nefrologických súvislostí.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Ľudia s hraničnou poruchou osobnosti majú zvýšené riziko predčasného úmrtia, kardiometabolických ochorení, chronickej bolesti, závislostí a nedostatočne diagnostikovaných telesných chorôb. Väčšina dostupných údajov je však observačná a nedokazuje, že samotná porucha priamo vyvoláva konkrétne somatické ochorenie. Rozdiel medzi „je to spojené“ a „je to spôsobené“ tu má priame klinické dôsledky.</em></p>

<h2>O akej poruche hovoríme</h2>

<p>Hraničná porucha osobnosti, označovaná aj skratkou BPD z anglického <em>borderline personality disorder</em>, je závažná duševná porucha charakterizovaná nestabilitou emócií, medziľudských vzťahov, sebaobrazu a správania. Časté sú impulzivita, sebapoškodzovanie, suicidálne správanie, intenzívny strach z opustenia a výrazná citlivosť na medziľudský stres.</p>

<p>Menej pozornosti sa venuje skutočnosti, že títo pacienti majú častejšie aj telesné ochorenia a kratšiu očakávanú dĺžku života. Dôvodom nie je jediný mechanizmus. Uplatňuje sa kombinácia sociálneho znevýhodnenia, fajčenia a ďalších závislostí, nepravidelnej životosprávy, obezity, nežiaducich účinkov liekov, úrazov, sebapoškodzovania, nedostatočného využívania preventívnej starostlivosti a pravdepodobne aj biologických následkov dlhodobého stresu.</p>

<h3>Poznámka k terminológii a klasifikácii</h3>

<p>Kategoriálna diagnóza hraničnej poruchy osobnosti pochádza z klasifikácií DSM a MKCH-10. <strong>MKCH-11 kategoriálne typy porúch osobnosti ruší</strong> a nahrádza ich jednou diagnózou poruchy osobnosti klasifikovanou podľa závažnosti, s možnosťou pripojiť kvalifikátor hraničného vzorca.</p>

<p>Prakticky to znamená dvoje. Po prvé, staršia literatúra aj väčšina citovaných štúdií pracuje s kategoriálnym poňatím, takže výsledky nemožno automaticky prekladať do novej klasifikácie. Po druhé, pri postupnom prechode na MKCH-11 bude potrebné dávať pozor, aby zmena kódovania neviedla k strate klinickej informácie o závažnosti a rizikách konkrétneho pacienta.</p>

<h2>Diagnostické zatienenie</h2>

<p>Diagnostické zatienenie znamená, že zdravotník pripíše telesné príznaky už známej psychiatrickej diagnóze bez primeraného somatického vyšetrenia. Bolesť na hrudníku môže byť automaticky označená za úzkosť, brušná bolesť za somatizáciu, dýchavica za panický záchvat a únava za depresiu.</p>

<p>Psychický pôvod ťažkostí je možný, ale možno o ňom uvažovať až po primeranom zhodnotení organických príčin. Diagnóza BPD nevylučuje akútny koronárny syndróm, pľúcnu embóliu, infekciu, anémiu, endokrinné ochorenie, intoxikáciu ani akútne poškodenie obličiek.</p>

<p>Na druhej strane nie je správne vytvárať opačný extrém a každému pacientovi robiť neobmedzené množstvo vyšetrení. Klinické rozhodnutie má vychádzať z príznakov, anamnézy, fyzikálneho nálezu a pravdepodobnosti konkrétneho ochorenia, nie z pozitívneho alebo negatívneho postoja k psychiatrickej diagnóze.</p>

<p>Stigmatizujúce označenia ako „manipulatívny“, „dramatický“ alebo „ťažký pacient“ narúšajú terapeutický vzťah a znižujú kvalitu starostlivosti. Správanie, ktoré zdravotník vníma ako problematické, môže byť prejavom emočnej dysregulácie, strachu, traumy, intoxikácie, abstinenčného syndrómu, bolesti alebo predchádzajúcej negatívnej skúsenosti so zdravotníctvom.</p>

<h2>Predčasná úmrtnosť je reálny, ale heterogénny problém</h2>

<p>Dlhodobé kohortové štúdie potvrdzujú, že BPD je spojená s vyššou celkovou mortalitou. Významnú časť tvoria samovraždy, predávkovania, úrazy a iné vonkajšie príčiny, ale zvýšená je aj mortalita na telesné ochorenia.</p>

<p>Doteraz najrozsiahlejšie dáta priniesla populačná kohortová štúdia z Hongkongu publikovaná v marci 2026. Vychádzala z databázy verejného zdravotníctva a zahŕňala <strong>3 092 ľudí s prvýkrát zaznamenanou diagnózou BPD</strong> v rokoch 2006 až 2021 a <strong>902 927 porovnávacích osôb</strong> z primárnej starostlivosti bez evidovanej duševnej poruchy.</p>

<div class="table-responsive" role="region" aria-label="Riziko úmrtia pri hraničnej poruche osobnosti podľa hongkonskej kohorty" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Pomer rizík (95 % interval spoľahlivosti)</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Úmrtie zo všetkých príčin</td><td>5,65 (4,83 až 6,61)</td></tr>
    <tr><td>Úmrtie z prirodzených príčin</td><td>2,02 (1,56 až 2,62)</td></tr>
    <tr><td>Úmrtie z vonkajších príčin</td><td>30,35 (23,52 až 39,17)</td></tr>
  </tbody>
</table>
</div>

<p>Odhadovaný nadmerný počet stratených rokov života bol <strong>13,01 roka</strong> (9,35 až 15,52). Samovraždy a kardiovaskulárne ochorenia boli hlavnými prispievateľmi. Vonkajšie príčiny tvorili 40,4 % úmrtí a prirodzené príčiny 37,3 %, čo dobre ilustruje, že problém nemožno redukovať iba na suicidálne správanie.</p>

<p>Zo somatických diagnóz mala najvyššie riziko <strong>epilepsia s pomerom rizík 7,58</strong> (5,33 až 10,79). Pri ostatných telesných ochoreniach sa pomery rizík pohybovali približne v jedno- až trojnásobnom rozpätí oproti porovnávacej skupine.</p>

<h3>Dva nálezy, ktoré sa v sekundárnych zhrnutiach strácajú</h3>

<p>Štúdia priniesla dve zistenia, ktoré menia interpretáciu:</p>

<ul>
  <li><strong>Rozdiel podľa pohlavia.</strong> Asociácie medzi BPD a telesnými ochoreniami sa u mužov spravidla stali štatisticky nevýznamnými, kým u žien zostali významne zvýšené. Aj riziko celkovej mortality spojené s BPD bolo vyššie u žien než u mužov.</li>
  <li><strong>Rozdiel podľa veku pri diagnóze.</strong> Významné asociácie s telesnými ochoreniami sa pozorovali prevažne u ľudí s diagnózou stanovenou v mladšom veku.</li>
</ul>

<p>Tieto rozdiely naznačujú, že nejde o jednotný biologický efekt poruchy, ale o interakciu s dĺžkou expozície, rizikovým správaním a spôsobom, akým sa diagnóza v zdravotnom systéme vôbec zaznamená.</p>

<p>Výsledok zároveň neznamená, že každý človek s BPD bude žiť o 13 rokov kratšie. Ide o populačný priemer z konkrétneho zdravotného systému. Ovplyvňuje ho závažnosť poruchy, komorbidity, sociálna situácia, dostupnosť liečby, fajčenie, užívanie psychoaktívnych látok a spôsob identifikácie diagnóz v zdravotných záznamoch. Rôzne publikované odhady skrátenia života sa preto medzi populáciami líšia a žiadny z nich nie je biologickou konštantou.</p>

<h2>Kardiovaskulárne riziko</h2>

<p>Viaceré observačné štúdie našli pri BPD alebo pri výraznejších hraničných osobnostných črtách častejší výskyt hypertenzie, obezity, diabetu a kardiovaskulárnych ochorení hlásených samotnými pacientmi. Nie všetky štúdie však potvrdili asociáciu po dôslednom zohľadnení depresie, socioekonomického postavenia, liekov a rizikového správania.</p>

<p>Často citované 23-ročné sledovanie v rámci Baltimore Epidemiologic Catchment Area Study zistilo, že poruchy osobnosti klastra B aj ich dimenzionálne črty predpovedali vznik kardiovaskulárneho ochorenia; pri kardiovaskulárnej mortalite bola udávaná približne šesťnásobne vyššia pravdepodobnosť.</p>

<p>Tento výsledok však treba čítať opatrne z troch dôvodov:</p>

<ol>
  <li>vyšetrených bolo iba <strong>244 účastníkov</strong> komunitnej vzorky, takže počet udalostí bol malý a intervaly spoľahlivosti široké,</li>
  <li>klaster B okrem BPD zahŕňa aj antisociálnu, histriónsku a narcistickú poruchu osobnosti, takže výsledok nemožno bez výhrad prisúdiť samotnej BPD,</li>
  <li>poruchy osobnosti sa hodnotili podľa DSM-III v roku 1981, teda podľa dnes už prekonaných kritérií.</li>
</ol>

<h3>Možné vysvetlenia</h3>

<p>Najpresvedčivejšie sú behaviorálne a sociálne mechanizmy:</p>

<ul>
  <li>fajčenie a iné závislosti,</li>
  <li>obezita a nevhodná strava,</li>
  <li>nedostatok pravidelnej pohybovej aktivity,</li>
  <li>narušený spánok,</li>
  <li>slabšia účasť na preventívnych prehliadkach,</li>
  <li>nepravidelné užívanie predpísaných liekov,</li>
  <li>sociálna izolácia, nezamestnanosť a ekonomické znevýhodnenie,</li>
  <li>metabolické nežiaduce účinky psychofarmák.</li>
</ul>

<p>Uvažuje sa aj o aktivácii sympatikového nervového systému, zmenách osi hypotalamus – hypofýza – nadobličky, autonómnej dysregulácii a systémovom zápale. Tieto mechanizmy sú biologicky prijateľné, ale nie sú dostatočným dôkazom, že emočná dysregulácia priamo spôsobuje aterosklerózu alebo infarkt myokardu.</p>

<p>Koncentrácie kortizolu a zápalových markerov sa medzi štúdiami líšia. Výsledky ovplyvňujú trauma, depresia, posttraumatická stresová porucha, obezita, fajčenie, spánok, lieky a fáza ochorenia. Formulácia, že opakované emócie „poškodzujú srdce“, je preto neprimerane zjednodušená.</p>

<h2>Metabolický syndróm a diabetes</h2>

<p>Metabolický syndróm zahŕňa kombináciu centrálnej obezity, poruchy metabolizmu glukózy, hypertenzie, zvýšených triacylglycerolov a nízkej koncentrácie HDL cholesterolu. Niektoré klinické súbory zaznamenali pri BPD jeho vyššiu prevalenciu než v porovnávacej populácii.</p>

<p>Tieto výsledky majú významné obmedzenia:</p>

<ol>
  <li>často išlo o prierezové štúdie, ktoré neumožňujú určiť časovú ani príčinnú súvislosť,</li>
  <li>hospitalizovaní psychiatrickí pacienti nereprezentujú všetkých ľudí s BPD,</li>
  <li>významnými konfundujúcimi faktormi sú depresia, antipsychotiká, fajčenie, socioekonomické postavenie a fyzická aktivita,</li>
  <li>definície metabolického syndrómu sa medzi štúdiami líšia.</li>
</ol>

<p>Poučný je príklad komunitnej štúdie 1 295 dospelých v strednom veku, v ktorej sa kardiometabolické riziko meralo prístrojovo a laboratórne, nie dotazníkom. Hraničné osobnostné črty zostali spojené s agregovaným kardiometabolickým rizikom aj po zohľadnení depresívnych symptómov; po doplnení socioekonomických ukazovateľov sa však asociácia oslabila presne na hranicu štatistickej významnosti. Štúdia navyše nehodnotila klinicky diagnostikovanú BPD, ale dimenzionálne osobnostné črty.</p>

<p>Takýto výsledok podporuje potrebu metabolického monitorovania. Nepodporuje tvrdenie, že BPD nezávisle spôsobuje metabolický syndróm; skôr ukazuje, ako veľkú časť asociácie môže vysvetľovať sociálne znevýhodnenie.</p>

<h2>Psychofarmaká a metabolické komplikácie</h2>

<p>Jadrom liečby BPD je štruktúrovaná psychoterapia. Nie je registrovaný liek, ktorý by liečil samotnú BPD ako celok. Farmakoterapia môže byť indikovaná pri súbežnej depresii, bipolárnej poruche, psychóze, úzkostnej poruche, ADHD alebo inej konkrétnej diagnóze, prípadne krátkodobo na vybraný cieľový symptóm.</p>

<p>Dlhodobá polyfarmácia bez jasne určenej cieľovej diagnózy a bez pravidelného hodnotenia účinku prináša viac škody než úžitku. Odporúčanie NICE je v tomto bode dlhodobo jednoznačné a aktualizované odporúčanie Americkej psychiatrickej asociácie z roku 2024 stavia psychoterapiu do centra liečby.</p>

<p>Najvyššie metabolické riziko spomedzi bežne používaných antipsychotík majú olanzapín a klozapín. Kvetiapín takisto zvyšuje hmotnosť a zhoršuje lipidový a glukózový metabolizmus, hoci priemerné riziko býva nižšie. Metabolické účinky sa môžu objaviť aj bez výrazného nárastu telesnej hmotnosti.</p>

<p>Pri antipsychotickej liečbe treba monitorovať:</p>

<ul>
  <li>telesnú hmotnosť a index telesnej hmotnosti,</li>
  <li>obvod pása,</li>
  <li>krvný tlak,</li>
  <li>glykémiu nalačno alebo HbA1c,</li>
  <li>lipidový profil,</li>
  <li>pohybovú aktivitu a stravovanie.</li>
</ul>

<p>Frekvencia kontrol má závisieť od použitého lieku, východiskového rizika a dynamiky zmien. Abnormálny výsledok sa nemá pripisovať iba „životnému štýlu“ pacienta. Treba zvážiť zmenu lieku, nefarmakologickú intervenciu a štandardnú liečbu diabetu, hypertenzie alebo dyslipidémie.</p>

<h2>Fajčenie, alkohol a ďalšie psychoaktívne látky</h2>

<p>Poruchy užívania návykových látok sú pri BPD časté. Fajčenie, nadmerná konzumácia alkoholu, stimulanty, opioidy a sedatíva môžu významne prispievať ku kardiovaskulárnemu riziku, infekciám, úrazom, predávkovaniu, dehydratácii a poškodeniu obličiek.</p>

<p>Údaje o mnohonásobne vyššej prevalencii závislosti od nikotínu pri BPD pochádzajú z epidemiologických porovnaní v konkrétnych národných populáciách, najmä amerických. Konkrétne násobky preto nemožno považovať za univerzálnu hodnotu pre všetky krajiny a vekové skupiny; smer asociácie je však konzistentný.</p>

<p>Liečba závislosti by mala byť integrovaná s liečbou BPD. Samotné odporúčanie „prestaňte fajčiť“ bez podpory, farmakoterapie závislosti a práce s emočnými spúšťačmi má obmedzenú účinnosť.</p>

<h2>Chronická bolesť</h2>

<p>BPD sa v klinických štúdiách spája s častejšou chronickou bolesťou, bolesťami chrbtice, bolesťami hlavy, artritídou a fibromyalgiou. Udávaná prevalencia je veľmi variabilná a horné odhady pochádzajú z vybraných psychiatrických alebo algeziologických pracovísk. Neplatia pre bežnú populáciu ani pre ambulanciu praktického lekára.</p>

<p>Výsledky ovplyvňuje:</p>

<ul>
  <li>výber psychiatrickej alebo algeziologickej populácie,</li>
  <li>spôsob diagnostiky BPD,</li>
  <li>definícia chronickej bolesti,</li>
  <li>súbežná depresia a posttraumatická stresová porucha,</li>
  <li>trauma v detstve,</li>
  <li>užívanie opioidov a ďalších látok,</li>
  <li>selektívne odosielanie závažnejších pacientov do špecializovaných centier.</li>
</ul>

<p>Emočná a telesná bolesť využívajú čiastočne sa prekrývajúce nervové siete. Z toho však nevyplýva, že bolesť pacienta s BPD je „iba psychická“. Fibromyalgia je komplexná porucha nociceptívneho spracovania, nie jednoducho prejav BPD ani ochorenie bez biologického podkladu.</p>

<p>Každý nový alebo zmenený bolestivý stav vyžaduje primeranú diferenciálnu diagnostiku. Psychoterapia môže zlepšiť zvládanie bolesti, emočnú reguláciu a funkčnosť, ale nenahrádza liečbu zápalového, neurologického, onkologického ani iného somatického ochorenia.</p>

<h2>Nefrologické súvislosti</h2>

<p>Priama súvislosť medzi BPD a chronickou chorobou obličiek nie je preskúmaná natoľko, aby bolo možné označiť BPD za nezávislý renálny rizikový faktor. Viaceré sprievodné okolnosti však môžu poškodenie obličiek podporovať.</p>

<h3>Metabolické a kardiovaskulárne riziko</h3>

<p>Obezita, diabetes, hypertenzia, fajčenie a dyslipidémia sú spoločnými rizikovými faktormi kardiovaskulárnych ochorení aj chronickej choroby obličiek. Ak sú u pacientov s BPD častejšie alebo horšie liečené, môžu nepriamo zvyšovať renálne riziko.</p>

<p>Skríning funkcie obličiek má vychádzať zo všeobecných rizikových faktorov. Pri diabete, hypertenzii, kardiovaskulárnom ochorení alebo inej indikácii treba hodnotiť nielen sérový kreatinín a eGFR, ale aj pomer albumínu ku kreatinínu v moči.</p>

<h3>Akútne poškodenie obličiek</h3>

<p>Riziko môžu zvyšovať:</p>

<ul>
  <li>intoxikácie a predávkovania,</li>
  <li>rabdomyolýza po intoxikácii, kŕčoch alebo dlhšej imobilizácii,</li>
  <li>vracanie, hnačka a nedostatočný príjem tekutín,</li>
  <li>kombinácia dehydratácie, diuretika, blokátora systému renín-angiotenzín a nesteroidového protizápalového lieku,</li>
  <li>užívanie stimulantov,</li>
  <li>hypotenzia, sepsa alebo hypertermia.</li>
</ul>

<p>Pri intoxikácii alebo poruche vedomia treba podľa klinického obrazu vyšetriť kreatinín, elektrolyty, acidobázickú rovnováhu, kreatínkinázu a močový nález.</p>

<h3>Analgetiká</h3>

<p>Chronická bolesť môže viesť k častému užívaniu nesteroidových protizápalových liekov. Tie môžu zhoršovať krvný tlak, vyvolať retenciu sodíka, hyperkaliémiu, akútne poškodenie obličiek a pri dlhodobej expozícii prispieť k chronickému tubulointersticiálnemu poškodeniu. Cielene sa treba pýtať aj na voľnopredajné prípravky.</p>

<p>Opioidy zvyšujú riziko závislosti a predávkovania. Pri zníženej funkcii obličiek sa niektoré opioidy alebo ich aktívne metabolity kumulujú. Výber analgetika preto musí zohľadniť eGFR, interakcie, suicidálne riziko a anamnézu závislosti. Pri vysokom riziku predávkovania má zmysel obmedziť množstvo vydané na jeden predpis.</p>

<h3>Psychofarmaká pri chronickej chorobe obličiek</h3>

<p>Mnohé psychofarmaká vyžadujú pri zníženej funkcii obličiek úpravu dávky alebo zvýšenú opatrnosť. Platí to napríklad pre gabapentín, pregabalín a ďalšie lieky eliminované prevažne obličkami.</p>

<p>Lítium nie je štandardnou liečbou BPD. Ak je indikované pre súbežnú bipolárnu poruchu, vyžaduje pravidelné monitorovanie koncentrácie lítia, funkcie obličiek, sodíka, vápnika a funkcie štítnej žľazy. Dehydratácia, nesteroidové protizápalové lieky, inhibítory ACE, sartany a tiazidové diuretiká môžu zvýšiť koncentráciu lítia a vyvolať toxicitu. Pri poruche s impulzivitou a suicidálnym rizikom treba osobitne zvážiť aj úzke terapeutické rozpätie lítia.</p>

<h3>Dialýza a transplantácia</h3>

<p>Emočná dysregulácia, trauma alebo predchádzajúce negatívne skúsenosti môžu komplikovať komunikáciu, ale diagnóza BPD sama osebe neznamená neschopnosť spolupracovať a nemá automaticky vylučovať pacienta z transplantačného programu.</p>

<p>Posudzovať treba individuálne:</p>

<ul>
  <li>schopnosť porozumieť liečbe,</li>
  <li>aktuálne suicidálne riziko,</li>
  <li>aktívnu závislosť,</li>
  <li>adherenciu a dôvody jej porúch,</li>
  <li>dostupnú sociálnu podporu,</li>
  <li>možnosť psychiatrickej a psychoterapeutickej stabilizácie.</li>
</ul>

<p>Jednotný liečebný plán a konzistentná komunikácia celého tímu sú spravidla účinnejšie než represívne alebo moralizujúce postupy. Nejednotnosť tímu býva pri tejto skupine pacientov sama osebe zdrojom eskalácie.</p>

<h2>Psychoterapia a telesné výsledky</h2>

<p>Medzi psychoterapie s dôkazmi účinnosti pri BPD patria dialekticko-behaviorálna terapia, liečba založená na mentalizácii, schématerapia a niektoré ďalšie štruktúrované prístupy. Znižujú sebapoškodzovanie, suicidálne správanie a závažnosť symptómov a zlepšujú psychosociálne fungovanie.</p>

<p>Malé fyziologické štúdie naznačili, že dialekticko-behaviorálna terapia môže ovplyvniť pokojovú srdcovú frekvenciu alebo autonómnu reguláciu. Zatiaľ však nie je dokázané, že psychoterapia BPD znižuje výskyt infarktu myokardu, cievnej mozgovej príhody, diabetu, chronickej choroby obličiek ani celkovú somatickú mortalitu.</p>

<p>Tvrdenie, že účinná psychoterapia môže zlepšiť telesné zdravie, je rozumná hypotéza. Pravdepodobné sprostredkujúce mechanizmy zahŕňajú obmedzenie fajčenia a užívania látok, lepšiu adherenciu, pravidelnejšiu životosprávu, zníženie sebapoškodzovania a lepšie využívanie zdravotnej starostlivosti. Priamy orgánový ochranný účinok však preukázaný nebol a zmena fyziologického markera nie je dôkazom prevencie orgánovej príhody.</p>

<h2>Ako čítať čísla v tejto oblasti</h2>

<p>Literatúra o telesnom zdraví pri BPD má opakujúce sa metodické slabiny, ktoré treba mať na pamäti pri každom prevzatom údaji:</p>

<ul>
  <li>veľká časť dôkazov pochádza z <strong>observačných</strong> štúdií a asociácie sa v sekundárnych zhrnutiach často formulujú kauzálne,</li>
  <li>niektoré často citované výsledky sa týkajú <strong>celého klastra B</strong> porúch osobnosti, nie výhradne BPD,</li>
  <li>číselné odhady pochádzajú z <strong>heterogénnych populácií</strong> a rôznych zdravotných systémov, takže ich nemožno prenášať ako univerzálne konštanty,</li>
  <li>hodnoty prevalencie z <strong>terciárnych centier</strong> systematicky nadhodnocujú bežnú prax,</li>
  <li>mechanizmy s kortizolom, cytokínmi a autonómnou dysreguláciou sú biologicky možné, ale nie dokázané,</li>
  <li>regulačný stav liekov a legislatívne iniciatívy zo Spojených štátov sa nedajú automaticky preniesť na slovenské podmienky.</li>
</ul>

<p>Nič z toho neznižuje závažnosť problému. Znamená to len, že argument pre lepšiu somatickú starostlivosť netreba stavať na nadhodnotených číslach — samotné overené populačné dáta sú dosť presvedčivé.</p>

<h2>Praktický prístup k somatickému zdraviu</h2>

<p>Pacient s BPD nepotrebuje osobitný súbor laboratórnych testov iba na základe psychiatrickej diagnózy. Potrebuje rovnako kvalitnú preventívnu a diagnostickú starostlivosť ako každý iný pacient, pričom treba aktívne zohľadniť častejšie rizikové faktory.</p>

<p>Primerané hodnotenie môže podľa veku, symptómov a liečby zahŕňať:</p>

<ul>
  <li>krvný tlak, hmotnosť, index telesnej hmotnosti a podľa potreby obvod pása,</li>
  <li>fajčenie, alkohol a ďalšie psychoaktívne látky,</li>
  <li>glykémiu alebo HbA1c a lipidový profil,</li>
  <li>liekovú anamnézu vrátane voľnopredajných analgetík,</li>
  <li>kreatinín, eGFR, elektrolyty a albuminúriu pri renálnych rizikách,</li>
  <li>hodnotenie výživy, pohybu a spánku,</li>
  <li>suicidálne riziko a riziko predávkovania,</li>
  <li>preventívne onkologické vyšetrenia a očkovanie podľa všeobecných odporúčaní.</li>
</ul>

<p>Vzhľadom na nálezy hongkonskej kohorty si osobitnú pozornosť zaslúžia ženy a pacienti s diagnózou stanovenou v mladom veku, u ktorých bola asociácia s telesnými ochoreniami najvýraznejšia.</p>

<p>Výsledky treba vysvetľovať vecne a bez moralizovania. Obezita, fajčenie alebo nepravidelné užívanie liekov nie sú dôvodom na odmietnutie starostlivosti.</p>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly o telesnom zdraví pri hraničnej poruche osobnosti a ich spresnenie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Ľudia s BPD majú skrátenú očakávanú dĺžku života</td><td>Potvrdené</td><td>Veľkosť rozdielu závisí od populácie a metodiky; hongkonská kohorta odhadla 13,01 strateného roka.</td></tr>
    <tr><td>Skrátenie života je konštantné a presahuje 14 rokov</td><td>Nesprávne</td><td>Ide o populačné priemery z konkrétnych systémov, nie o biologickú konštantu.</td></tr>
    <tr><td>Vyššia mortalita je takmer výlučne dôsledkom samovrážd</td><td>Nesprávne</td><td>Vonkajšie príčiny tvorili 40,4 % úmrtí, prirodzené príčiny 37,3 %.</td></tr>
    <tr><td>Riziko telesných ochorení je pri BPD rovnaké u mužov aj u žien</td><td>Nesprávne</td><td>V hongkonskej kohorte zostali asociácie významné najmä u žien.</td></tr>
    <tr><td>BPD je spojená s vyššou kardiovaskulárnou mortalitou</td><td>Pravdepodobné</td><td>Časť dôkazov sa týka celého klastra B, pochádza z malých vzoriek a je observačná.</td></tr>
    <tr><td>Emočná dysregulácia priamo spôsobuje aterosklerózu</td><td>Nedokázané</td><td>Ide o biologicky prijateľnú hypotézu, nie o preukázaný mechanizmus.</td></tr>
    <tr><td>Kortizol a cytokíny vysvetľujú metabolické komplikácie</td><td>Hypotéza</td><td>Výsledky významne ovplyvňujú komorbidity, lieky a životný štýl.</td></tr>
    <tr><td>Sociálne znevýhodnenie je pri kardiometabolickom riziku okrajové</td><td>Nesprávne</td><td>Po zohľadnení socioekonomických ukazovateľov asociácia klesla na hranicu významnosti.</td></tr>
    <tr><td>Na BPD existuje registrovaná farmakoterapia</td><td>Nesprávne</td><td>Lieky sa používajú na komorbidity alebo vybrané cieľové symptómy; jadrom liečby je psychoterapia.</td></tr>
    <tr><td>Kvetiapín a olanzapín môžu zhoršovať metabolické zdravie</td><td>Potvrdené</td><td>Riziko je najvýraznejšie pri olanzapíne a klozapíne.</td></tr>
    <tr><td>Vysoké odhady prevalencie bolesti platia pre bežnú populáciu s BPD</td><td>Nesprávne</td><td>Horné odhady pochádzajú z vybraných psychiatrických a algeziologických pracovísk.</td></tr>
    <tr><td>BPD a fibromyalgia sú úzko kauzálne prepojené</td><td>Nepodporené</td><td>Asociácia je možná, kauzalita preukázaná nebola.</td></tr>
    <tr><td>Psychoterapia BPD znižuje telesnú chorobnosť a mortalitu</td><td>Zatiaľ nedokázané</td><td>Zmena fyziologického markera nie je dôkazom prevencie orgánovej príhody.</td></tr>
    <tr><td>BPD je nezávislý rizikový faktor chronickej choroby obličiek</td><td>Nedokázané</td><td>Renálne riziko sprostredkúvajú najmä komorbidity, intoxikácie a lieky.</td></tr>
    <tr><td>Diagnóza BPD je dôvodom na vylúčenie z transplantačného programu</td><td>Nesprávne</td><td>Posudzuje sa individuálna schopnosť spolupráce, riziko a možnosť stabilizácie.</td></tr>
    <tr><td>Pacienti s BPD potrebujú dôslednú somatickú prevenciu</td><td>Klinicky opodstatnené</td><td>Rovnaký štandard ako u iných pacientov, s cieleným zohľadnením rizikových faktorov.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Hraničná porucha osobnosti je spojená nielen so suicidálnym rizikom a psychosociálnym utrpením, ale aj s vyššou telesnou chorobnosťou a predčasnou mortalitou. Dôkazy sú najsilnejšie pre celkovú mortalitu, závislosti, rizikové správanie a nepriaznivý kardiometabolický profil. Slabšie sú dôkazy o priamych biologických mechanizmoch, o kauzálnom vzťahu ku konkrétnym somatickým ochoreniam a o orgánovom prínose psychoterapie.</p>

<p>Najdôležitejším praktickým opatrením je predchádzať diagnostickému zatieneniu. Telesné príznaky pacienta s BPD treba vyšetriť podľa rovnakých klinických zásad ako u každého iného človeka. Súčasne treba cielene monitorovať liekové komplikácie, metabolické riziko, závislosti, chronickú bolesť, sebapoškodzovanie a faktory poškodenia obličiek.</p>

<p><strong>Zvýšená somatická chorobnosť pri tejto diagnóze je z veľkej časti dôsledkom modifikovateľných okolností — fajčenia, závislostí, sociálneho znevýhodnenia, nežiaducich účinkov liekov a horšieho prístupu k starostlivosti. Práve to je dôvod na aktívnu intervenciu, nie na rezignáciu.</strong></p>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Nam Chan JK, Yin Li RC, Man Wong CS, Mahboobani VR, Ku KM, Chang WC.</strong> <em>Association of Borderline Personality Disorder with Physical Diseases and Mortality: A 16-Year Population-Based Electronic Health-Record Cohort Study in Hong Kong.</em> Psychother Psychosom. 2026 Mar 17:1–11. doi: 10.1159/000551534. <a href="https://doi.org/10.1159/000551534" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41843727/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Barber TA, Ringwald WR, Wright AGC, Manuck SB.</strong> <em>Borderline personality disorder traits associate with midlife cardiometabolic risk.</em> Personal Disord. 2020;11(2):151–156. doi: 10.1037/per0000373. <a href="https://doi.org/10.1037/per0000373" target="_blank" rel="noopener noreferrer">Komunitná štúdia s prístrojovým meraním rizika</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7047517/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Lee HB, Bienvenu OJ, Cho SJ, Ramsey CM, Bandeen-Roche K, Eaton WW, Nestadt G.</strong> <em>Personality disorders and traits as predictors of incident cardiovascular disease: findings from the 23-year follow-up of the Baltimore ECA study.</em> Psychosomatics. 2010;51(4):289–296. doi: 10.1176/appi.psy.51.4.289. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4086910/" target="_blank" rel="noopener noreferrer">Sledovanie Baltimore ECA</a>.</li>
  <li><strong>Dixon-Gordon KL, Whalen DJ, Layden BK, Chapman AL.</strong> <em>A Systematic Review of Personality Disorders and Health Outcomes.</em> Can Psychol. 2015;56(2):168–190. doi: 10.1037/cap0000024. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4597592/" target="_blank" rel="noopener noreferrer">Systematický prehľad</a>.</li>
  <li><strong>El-Gabalawy R, Katz LY, Sareen J.</strong> <em>Comorbidity and associated severity of borderline personality disorder and physical health conditions in a nationally representative sample.</em> Psychosom Med. 2010;72(7):641–647. doi: 10.1097/PSY.0b013e3181e10c7b. <a href="https://doi.org/10.1097/PSY.0b013e3181e10c7b" target="_blank" rel="noopener noreferrer">Reprezentatívna populačná vzorka</a>.</li>
  <li><strong>Frankenburg FR, Zanarini MC.</strong> <em>Obesity and obesity-related illnesses in borderline patients.</em> J Pers Disord. 2006;20(1):71–80. doi: 10.1521/pedi.2006.20.1.71. <a href="https://doi.org/10.1521/pedi.2006.20.1.71" target="_blank" rel="noopener noreferrer">Obezita pri BPD</a>.</li>
  <li><strong>Keepers GA, Fochtmann LJ, Anzia JM, a spol.</strong> <em>The American Psychiatric Association Practice Guideline for the Treatment of Patients With Borderline Personality Disorder.</em> Am J Psychiatry. 2024;181(11):1024–1028. doi: 10.1176/appi.ajp.24181010. Prvá aktualizácia od roku 2001. <a href="https://doi.org/10.1176/appi.ajp.24181010" target="_blank" rel="noopener noreferrer">Odporúčanie APA 2024</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Borderline personality disorder: recognition and management. Clinical guideline CG78.</em> Publikované 28. januára 2009, naposledy revidované 30. júla 2024. Inštitucionálne autorstvo. <a href="https://www.nice.org.uk/guidance/cg78" target="_blank" rel="noopener noreferrer">Odporúčanie NICE</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
  <li><strong>Zhang R.</strong> <em>The Hidden Health Risks of Borderline Personality Disorder.</em> Medscape, 2026. Odborný komentár jedného autora, nie systematický prehľad; slúžil ako podnet na tému. <a href="https://www.medscape.com/viewarticle/hidden-health-risks-borderline-personality-disorder-2026a1000ql0" target="_blank" rel="noopener noreferrer">Sekundárne spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Článok je nezávislou syntézou primárnych štúdií a platných odporúčaní. Číselné údaje boli overené proti primárnym publikáciám, nie proti sekundárnym zhrnutiam.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Väčšina uvádzaných súvislostí pochádza z observačných štúdií a vyjadruje asociáciu, nie príčinu. Diagnostika, indikácie liekov, ich dávkovanie pri zníženej funkcii obličiek a monitorovanie sa musia riadiť aktuálnym súhrnom charakteristických vlastností lieku a klinickým stavom konkrétneho pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_hranicna-porucha-osobnosti-telesne-zdravie-somaticke-riziko_article',
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
