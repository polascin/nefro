<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Koľko v noci snívate? REM spánok a riziko 83 ochorení',
    'slug' => 'rem-spanok-riziko-83-ochoreni-uk-biobank',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Analýza 95 559 účastníkov UK Biobank spája vyšší podiel REM spánku s nižším rizikom 83 diagnóz. Po dvojročnom odstupe však zostáva významných len asi 60 % nálezov.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/rem-spanok-riziko-83-ochoreni-uk-biobank.webp" type="image/webp">
    <img src="img/rem-spanok-riziko-83-ochoreni-uk-biobank.png" alt="Polopriesvitna hlava spiaceho cloveka v profile, zo svietiaceho mozgu stupaju svetelne stuhy smerom k nejasnym obrysom srdca a obliciek" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o snímku konkrétneho pacienta ani o zobrazenie reálneho vyšetrenia. Architektúra spánku sa v klinickej praxi hodnotí polysomnografiou, nie zobrazením.</figcaption>
</figure>

<p>Spánok sa v prevencii najčastejšie hodnotí jedným číslom: koľko hodín človek spí. Rozsiahla analýza britskej kohorty UK Biobank, uverejnená v septembri 2026 v časopise <em>PLOS Medicine</em>, posúva otázku inam. Ukazuje, že aj vnútorná stavba noci, teda podiel REM spánku, hĺbka spánku, fragmentácia a pravidelnosť režimu, súvisí s neskorším výskytom chorôb naprieč orgánovými systémami.</p>

<p>Ide o pozorovaciu prácu. Nedokazuje príčinnú súvislosť a jej vlastní autori uvádzajú obmedzenia, ktoré výrazne menia to, ako sa majú čísla čítať. Najdôležitejšie z nich v popularizačných prevzatiach spravidla zaniká: po dvojročnom odstupe medzi meraním spánku a započítaním diagnóz zostalo štatisticky významných iba približne 60 % nálezov. Práve tento údaj rozhoduje o tom, či ide o výpoveď o prevencii, alebo skôr o výpoveď o skrytej, ešte nediagnostikovanej chorobe.</p>

<h2>Čo bolo merané a na kom</h2>

<p>Autori využili údaje z UK Biobank, prospektívnej kohorty 502 129 osôb vo veku 40 až 69 rokov naverbovaných v rokoch 2006 až 2010. Medzi 1. júnom 2013 a 23. decembrom 2015 bola podskupina 236 519 účastníkov vyzvaná, aby sedem dní nosila akcelerometer na zápästí; použiteľné údaje vrátilo 103 611 osôb. Po vyradení záznamov, ktoré neprešli kontrolou kvality alebo mali nadmerný čas bez nosenia, zostalo do analýzy <strong>95 559 účastníkov</strong>.</p>

<p>Záznamy zrýchlenia spracoval algoritmus hlbokého učenia SleepNet, trénovaný na viac než 1 100 nociach súbežnej laboratórnej polysomnografie a akcelerometrie. Z nich bolo odvodených šesť ukazovateľov: celkové trvanie spánku, trvanie REM spánku, trvanie NREM spánku (ľahký spánok ako súčet N1 a N2, hlboký spánok ako N3), bdenie po zaspaní (WASO) a nepravidelnosť spánku, definovaná ako smerodajná odchýlka dennej dĺžky spánku.</p>

<p>Výstupom boli novovzniknuté hospitalizačné diagnózy z elektronických zdravotných záznamov, kódované podľa MKCH-10 a mapované systémom PheCODE Map X. Z 2 050 fenotypov zostalo po vyradení nešpecifických kategórií a tých s menej než 20 prípadmi <strong>1 049 dobre definovaných fenotypov</strong>. Sledovanie začínalo dňom prvého nosenia akcelerometra a trvalo do prvej diagnózy, úmrtia alebo 1. apríla 2024, s mediánom 8,9 roka. Prípady vzniknuté do šiestich mesiacov po meraní boli vylúčené.</p>

<p>Štatisticky išlo o fenomovo širokú asociačnú analýzu (PheWAS) s Coxovou regresiou, úpravou na demografické, životné a environmentálne premenné (okrem iného index deprivácie, vzdelanie, BMI, fajčenie, alkohol, pohybová aktivita, jemné prachové častice PM<sub>2,5</sub> a nočná hladina hluku), s korekciou na mnohonásobné testovanie najprv metódou miery falošných objavov a následne prísnejším Bonferroniho prahom. Pomery hazardov sa vzťahujú na rozdiel medzi 25. a 75. percentilom daného ukazovateľa, teda na jedno medzikvartilové rozpätie.</p>

<h2>REM spánok: 83 diagnóz a jedno veľmi podozrivé číslo</h2>

<p>Vyššie trvanie REM spánku, konkrétne rozdiel o jedno medzikvartilové rozpätie (<strong>47,6 minúty</strong>), bolo spojené s nižším rizikom 83 novovzniknutých ochorení v 12 kategóriách.</p>

<div class="table-responsive" role="region" aria-label="Asociácie REM spánku s vybranými diagnózami" tabindex="0">
<table>
  <thead><tr><th scope="col">Diagnóza</th><th scope="col">HR na +47,6 min REM</th><th scope="col">95 % interval spoľahlivosti</th></tr></thead>
  <tbody>
    <tr><th scope="row">Parkinsonizmus</th><td>0,20</td><td>0,11–0,39</td></tr>
    <tr><th scope="row">Skleróza multiplex</th><td>0,48</td><td>0,36–0,64</td></tr>
    <tr><th scope="row">Demencie</th><td>0,54</td><td>0,47–0,62</td></tr>
    <tr><th scope="row">Alzheimerova choroba</th><td>0,69</td><td>0,57–0,81</td></tr>
    <tr><th scope="row">Srdcové zlyhávanie</th><td>0,74</td><td>0,68–0,80</td></tr>
    <tr><th scope="row">Hypotenzia</th><td>0,79</td><td>0,74–0,85</td></tr>
    <tr><th scope="row">Fibrilácia predsiení</th><td>0,83</td><td>0,79–0,86</td></tr>
    <tr><th scope="row">Ischemická choroba srdca</th><td>0,87</td><td>0,83–0,92</td></tr>
  </tbody>
</table>
</div>

<p>Práve tu treba spomaliť. Pomer hazardov 0,20 pre parkinsonizmus znamená o 80 % nižšie riziko pri rozdiele necelých 48 minút REM spánku za noc. Žiadna známa farmakologická ani režimová intervencia v neurológii takýto účinok nedosahuje. Keď observačná štúdia vyprodukuje efekt tejto veľkosti, prvou hypotézou nemá byť ochranný mechanizmus, ale obrátená príčinnosť.</p>

<p>Existuje pre ňu konkrétne a dobre doložené vysvetlenie. Porucha správania v REM spánku predchádza synukleinopatiám, teda Parkinsonovej chorobe a demencii s Lewyho telieskami, často o mnoho rokov. Jej podstatou je strata svalovej atónie počas REM fázy, teda práve pohyb v čase, keď má telo nehybne ležať. Algoritmus, ktorý fázy spánku odhaduje výlučne z pohybu zápästia, tento pohyb nevyhnutne klasifikuje ako bdenie alebo ako plytký spánok. Osoba v prodróme parkinsonizmu tak dostane zdanlivo nízke „REM“ nie preto, že by jej chýbal REM spánok, ale preto, že ho nástroj v jej prípade nedokáže rozpoznať. Analogická úvaha platí pre demencie, kde je rozpad architektúry spánku známou súčasťou predklinickej fázy.</p>

<p>Ide o hypotézu, nie o doložený fakt. Nálezy pri kardiovaskulárnych diagnózach s pomermi hazardov medzi 0,74 a 0,87 sú biologicky prijateľnejšie a konzistentné s doterajšou literatúrou. Čísla v rozpätí 0,20 až 0,54 pri neurodegeneratívnych a neuroimunitných diagnózach si však vyžadujú osobitnú opatrnosť a bez overenia polysomnografiou ich nemožno brať ako údaj o preventívnom potenciáli.</p>

<h2>Hlboký a ľahký spánok idú proti sebe</h2>

<p>Vyššie trvanie hlbokého spánku N3 (medzikvartilové rozpätie 47,5 minúty) bolo spojené s nižším rizikom iba <strong>siedmich</strong> ochorení v piatich kategóriách: diabetes mellitus 2. typu (HR 0,89; 95 % IS 0,85–0,93), veľká depresívna porucha (HR 0,86; 0,82–0,91), spánkové apnoe (HR 0,78; 0,71–0,86) a Parkinsonova choroba (HR 0,70; 0,62–0,80).</p>

<p>Podstatný je údaj, ktorý sa pri prevzatiach spravidla vynecháva, hoci mení výklad: <strong>ľahký spánok (N1 a N2) sa správal opačne</strong>. Dlhšie trvanie ľahkého spánku bolo spojené s vyšším rizikom veľkej depresívnej poruchy (HR 1,31; 95 % IS 1,25–1,36), ale zároveň s nižším rizikom srdcového zlyhávania (HR 0,86; 0,81–0,92) a celulitídy (HR 0,83; 0,78–0,89).</p>

<p>Tieto protichodné smery pri jednej a tej istej expozícii oslabujú jednoduchý výklad „hlbší a snovejší spánok je lepší“. Pravdepodobnejšie ide o prerozdeľovanie času medzi fázami v rámci rovnako dlhej noci: predĺženie jednej fázy nevyhnutne skracuje inú, takže odhady nie sú navzájom nezávislé. Tvrdenie o príčinnom prínose konkrétnej fázy preto z tohto dizajnu vyvodiť nemožno.</p>

<h2>Fragmentácia a nepravidelnosť: menej diagnóz, ale konzistentný smer</h2>

<p>Vyššie bdenie po zaspaní (WASO; medzikvartilové rozpätie 43,6 minúty) bolo spojené so zvýšeným rizikom šiestich ochorení, najvýraznejšie závislosti od psychoaktívnych látok (HR 1,33; 95 % IS 1,16–1,52), abúzu alkoholu (HR 1,22; 1,13–1,32) a osteoartrózy (HR 1,05; 1,03–1,08).</p>

<p>Vyššia nepravidelnosť spánku (medzikvartilové rozpätie 93,0 minúty) bola spojená so zvýšeným rizikom troch ochorení: veľkej depresívnej poruchy (HR 1,26; 95 % IS 1,18–1,34), úzkosti a úzkostných porúch (HR 1,23; 1,16–1,31) a bolesti brucha (HR 1,13; 1,07–1,19).</p>

<p>Obe skupiny nálezov sú sústredené v psychiatrických a bolestivých diagnózach, teda presne tam, kde je obojsmerný vzťah so spánkom najsilnejší. Fragmentovaný a nepravidelný spánok je pri depresii, úzkosti, závislosti a chronickej bolesti súčasťou klinického obrazu, nie iba rizikovým faktorom pred ním. Tieto asociácie preto patria k tým, pri ktorých je obrátená príčinnosť najpravdepodobnejšia.</p>

<h2>Dĺžka spánku: nelineárny vzťah a okno 6 až 8 hodín</h2>

<p>Dlhšie celkové trvanie spánku (medzikvartilové rozpätie 83,9 minúty) bolo vo všeobecnosti spojené s nižším rizikom 50 stavov, najmä endokrinných: proteínovo-energetická malnutrícia (HR 0,53; 95 % IS 0,41–0,69), acidóza (HR 0,74; 0,66–0,82) a diabetes mellitus 2. typu (HR 0,89; 0,86–0,93).</p>

<p>Analýza obmedzených kubických splajnov naprieč všetkými 1 049 fenotypmi ukázala štatisticky významný nelineárny vzťah pri <strong>86 fenotypoch</strong>. Pri 69 z nich ležalo minimum rizika v pásme 6 až 8 hodín. Pri 12 fenotypoch bolo minimum medzi 4 a 6 hodinami a pri 5 pri hornej hranici skúmaného rozsahu, čo samo osebe naznačuje, že pásmo 6 až 8 hodín nie je univerzálnym optimom pre každú diagnózu.</p>

<div class="table-responsive" role="region" aria-label="Dĺžka spánku s najnižším rizikom pre vybrané diagnózy" tabindex="0">
<table>
  <thead><tr><th scope="col">Diagnóza</th><th scope="col">Dĺžka spánku s najnižším rizikom</th></tr></thead>
  <tbody>
    <tr><th scope="row">Veľká depresívna porucha</th><td>6,57 hodiny</td></tr>
    <tr><th scope="row">Chronická choroba obličiek</th><td>7,10 hodiny</td></tr>
    <tr><th scope="row">Bolesť brucha</th><td>7,24 hodiny</td></tr>
    <tr><th scope="row">Bakteriálne infekcie</th><td>7,24 hodiny</td></tr>
    <tr><th scope="row">Anémia</th><td>7,34 hodiny</td></tr>
    <tr><th scope="row">Diabetes mellitus 2. typu</th><td>7,34 hodiny</td></tr>
    <tr><th scope="row">Chronická obštrukčná choroba pľúc</th><td>7,38 hodiny</td></tr>
    <tr><th scope="row">Hypotenzia</th><td>7,43 hodiny</td></tr>
    <tr><th scope="row">Demencie</th><td>7,53 hodiny</td></tr>
  </tbody>
</table>
</div>

<p>V kategorizovanej analýze s referenčnou skupinou 6 až 8 hodín bola najzraniteľnejšia skupina s extrémne krátkym spánkom. Osoby spiace menej než päť hodín tvorili <strong>37 zo 41</strong> zistených významných nepriaznivých asociácií. Po Bonferroniho korekcii zostalo pri spánku kratšom než šesť hodín významných 24 asociácií vrátane srdcového zlyhávania (HR 1,30; 95 % IS 1,16–1,45), diabetu 2. typu (HR 1,18; 1,09–1,27) a chronickej obštrukčnej choroby pľúc.</p>

<p>Skupina spiaca 6 až 8 hodín mala zároveň najvyšší podiel REM spánku (0,222 ± 0,081), nižšiu nepravidelnosť a nižší podiel WASO než krátko spiaci. Tento nález je vnútorne konzistentný, ale aj tautologický: priaznivejšia architektúra a priaznivejšie zdravotné výsledky môžu mať spoločnú príčinu v celkovom zdravotnom stave účastníka.</p>

<p>Presnosť na dve desatinné miesta pri minime rizika, napríklad 7,10 hodiny pri chronickej chorobe obličiek, je štatistickým artefaktom splajnovej krivky, nie klinickým cieľom. Rozdiel medzi 7,10 a 7,53 hodiny nie je nič, čo by malo v ambulancii zaznieť ako odporúčanie.</p>

<h2>Čo z toho platí v nefrológii</h2>

<p>Chronická choroba obličiek sa v tejto analýze objavuje len raz, medzi 69 fenotypmi s minimom rizika v pásme 6 až 8 hodín. Nepatrí medzi 83 diagnóz asociovaných s REM spánkom ani medzi sedem diagnóz asociovaných s hlbokým spánkom. Z práce samotnej teda pre nefrológiu nevyplýva nič, čo by presahovalo všeobecné odporúčanie primeranej dĺžky spánku.</p>

<p>Relevantnejší dôkazový základ prichádza odinakiaľ. V štúdii CRIC (Chronic Renal Insufficiency Cohort) bolo 431 pacientov s chronickou chorobou obličiek, priemerným vekom 60 rokov a priemernou eGFR 38 ml/min/1,73 m², sledovaných päť až sedem dní zápästnou aktigrafiou. Po medián piatich rokov sledovania bola väčšia fragmentácia spánku spojená s vyšším rizikom zlyhania obličiek (HR 1,04 na každé zvýšenie fragmentácie o 1 percentuálny bod; 95 % IS 1,01–1,07). Kratšie trvanie spánku aj väčšia fragmentácia boli spojené s rýchlejším poklesom eGFR (−1,12 ml/min/1,73 m² za rok na každú hodinu menej, respektíve −0,18 na každé 1 % fragmentácie) a so strmším nárastom proteinúrie. Subjektívne hodnotená denná spavosť bola spojená s vyšším rizikom úmrtia z akejkoľvek príčiny.</p>

<p>Obraz však nie je jednotný. Japonská kohorta NAGALA so 7 752 mužmi a 6 722 ženami zistila pri výskyte chronickej choroby obličiek opačný vzorec: u žien žiadnu súvislosť s dĺžkou spánku a u mužov <em>najnižšie</em> riziko v skupine spiacej menej než šesť hodín (HR 0,54; 95 % IS 0,45–0,64 oproti referenčnému pásmu 7 až 8 hodín). Autori sami tento výsledok označili za prekvapivý. Nech je jeho vysvetlenie akékoľvek, ukazuje, že vzťah medzi dĺžkou spánku a vznikom chronickej choroby obličiek nie je v literatúre vyriešený a nemá sa prezentovať ako ustálený.</p>

<p>Pre klinickú prax z toho plynie striedmy záver. Spánok u pacienta s chronickou chorobou obličiek stojí za cielenú otázku, ale nie preto, že by sa predlžovaním REM fázy dali chrániť obličky. Dôvod je priamočiarejší: v tejto populácii sú vysoko prevalentné a liečiteľné stavy, ktoré spánok rozbíjajú, a práve tie ovplyvňujú kvalitu života aj kardiovaskulárne riziko.</p>

<ul>
  <li><strong>Obštrukčné a centrálne spánkové apnoe</strong>, ktorých prevalencia rastie s poklesom eGFR a s previsom tekutín, najmä pri nočnom presune tekutiny z dolných končatín.</li>
  <li><strong>Syndróm nepokojných nôh a periodické pohyby končatín v spánku</strong>, časté pri pokročilej urémii a pri deficite železa.</li>
  <li><strong>Uremický pruritus</strong> a bolesť, ktoré fragmentujú noc.</li>
  <li><strong>Nespavosť</strong>, pri ktorej je liečbou prvej voľby kognitívno-behaviorálna terapia, nie hypnotiká, ktorých dávkovanie a vylučovanie sú pri zníženej funkcii obličiek navyše komplikované.</li>
  <li><strong>Režim dialýzy</strong>, teda ranné zmeny, intradialyzačná spavosť a nepravidelnosť spánkového režimu v dňoch s procedúrou a bez nej.</li>
</ul>

<p>Toto sú zásahy s doloženým prínosom pre pacienta. Odhad podielu REM fázy z hodiniek medzi ne nepatrí.</p>

<h2>Limity, ktoré rozhodujú o interpretácii</h2>

<p>Autori uvádzajú osem obmedzení. Tri z nich majú takú váhu, že bez nich sú výsledky čitateľné nesprávne.</p>

<p><strong>Obrátená príčinnosť.</strong> Po zavedení dvojročného odstupu medzi meraním spánku a započítaním diagnóz zostalo významných iba približne <strong>60 %</strong> nálezov. Zvyšných zhruba 40 % teda s veľkou pravdepodobnosťou odráža prodromálne alebo subklinické štádium choroby, ktoré spánok narušilo ešte pred stanovením diagnózy. Toto je v pozorovacej epidemiológii spánku pravidlo, nie výnimka, a dotýka sa predovšetkým neurodegeneratívnych a psychiatrických nálezov.</p>

<p><strong>Presnosť odhadu fáz spánku.</strong> SleepNet dosiahol pri klasifikácii REM, NREM a bdenia skóre F1 iba <strong>0,49</strong> (SD 0,10). Oproti polysomnografii mal systematický rozdiel 48,2 minúty pri celkovom trvaní spánku, −17,1 minúty pri REM, 31,1 minúty pri NREM a 9,2 % pri efektivite spánku. Toto číslo treba položiť vedľa expozičného kontrastu: medzikvartilové rozpätie REM spánku bolo 47,6 minúty, teda celý rozdiel medzi „málo“ a „veľa“ REM je rádovo rovnaký ako systematická chyba merania celkovej dĺžky spánku a približne trojnásobok systematickej chyby v REM. Autori oprávnene argumentujú, že takáto chyba je nediferencovaná voči budúcim diagnózam a poradie relatívnych rizík zachováva. Absolútne hodnoty a najmä prevod na minúty za noc však z nej spoľahlivo odvodiť nemožno. Ide o odhady z pohybu, nie o fázy spánku v zmysle polysomnografie.</p>

<p><strong>Výber kohorty a výstupov.</strong> UK Biobank má známe skreslenie zdravého dobrovoľníka: účastníci sú prevažne osoby európskeho pôvodu s vyšším socioekonomickým postavením než bežná populácia. Diagnózy pochádzali výlučne z hospitalizačných záznamov, bez ambulantnej a primárnej starostlivosti, čo podhodnocuje výskyt ľahších stavov a posúva zastúpenie fenotypov smerom k závažnejším formám.</p>

<p>K tomu pristupujú ďalšie obmedzenia, ktoré autori uvádzajú: spánok sa meral iba sedem dní, takže dlhodobé kolísanie zostalo nezachytené; sprievodné premenné boli zisťované v priemere 5,7 roka pred meraním spánku; a úprava na sezónnosť vychádzala len z mesiaca nosenia prístroja, bez zohľadnenia presnej dĺžky dňa.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Práca je metodicky úctyhodná a jej hlavným prínosom je šírka: systematicky mapuje súvislosti naprieč 1 049 fenotypmi a vytvára podklad pre cielené hypotézy. Nie je podkladom pre intervenciu a autori to ani netvrdia.</p>

<p>Pre ambulanciu z nej vyplývajú tri veci. Primeraná a pravidelná dĺžka spánku, u väčšiny dospelých v pásme 6 až 8 hodín, zostáva rozumným preventívnym cieľom, pričom najjasnejší signál rizika je pri spánku kratšom než päť až šesť hodín. Stabilita režimu a celistvosť noci stoja za pozornosť rovnako ako počet hodín. A nápadne narušený spánok, najmä nový alebo rýchlo sa zhoršujúci, má viesť k hľadaniu príčiny, nie k uisteniu: môže ísť o spánkové apnoe, syndróm nepokojných nôh, depresiu, bolesť, nežiaduci účinok lieku alebo o prvý prejav ochorenia, ktoré sa inak ešte neprihlásilo.</p>

<p>Čo z nej nevyplýva: že si možno nasnívať ochranu pred demenciou, a že údaj o REM fáze z nositeľného zariadenia má dnes klinickú výpovednú hodnotu pre jednotlivého pacienta.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom a informovaným čitateľom. Nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania. Citované pomery hazardov pochádzajú z pozorovacej štúdie a nevyjadrujú príčinný účinok. Pri podozrení na poruchu spánku je namieste konzultácia s lekárom a podľa indikácie polysomnografické vyšetrenie.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Luo Jingsong, Liu Ruiyi, Yin Jie, Cao Wangnan, Sun Shengzhi, Chen Rui. Accelerometer-derived real-world sleep stages and risk of incident diseases: A UK Biobank cohort study and phenome-wide association analysis. <em>PLOS Medicine.</em> 2026;23(9):e1005213. DOI: <a href="https://doi.org/10.1371/journal.pmed.1005213" target="_blank" rel="noopener noreferrer">10.1371/journal.pmed.1005213</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42752434/" target="_blank" rel="noopener noreferrer">PubMed PMID 42752434</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13585268/" target="_blank" rel="noopener noreferrer">PMC13585268</a>, voľný plný text.</em></small></p>

<p><small><em>2. Yuan Hang, Plekhanova Tatiana, Walmsley Rosemary, Reynolds Amy C., Maddison Kathleen J., Bucan Maja, Gehrman Philip, Rowlands Alex, Ray David W., Bennett Derrick, McVeigh Joanne, Straker Leon, Eastwood Peter, Kyle Simon D., Doherty Aiden. Self-supervised learning of accelerometer data provides new insights for sleep and its association with mortality. <em>npj Digital Medicine.</em> 2024;7(1):86. DOI: <a href="https://doi.org/10.1038/s41746-024-01065-0" target="_blank" rel="noopener noreferrer">10.1038/s41746-024-01065-0</a>. Pôvodný opis a validácia algoritmu SleepNet.</em></small></p>

<p><small><em>3. Ricardo Ana C., Knutson Kristen, Chen Jinsong, Appel Lawrence J., Bazzano Lydia, Carmona-Powell Eunice, Cohan Janet, Kurella Tamura Manjula, Steigerwalt Susan, Thornton John Daryl, Weir Matthew, Turek Nicolas F., Rahman Mahboob, Van Cauter Eve, Lash James P. The Association of Sleep Duration and Quality with CKD Progression. <em>Journal of the American Society of Nephrology.</em> 2017;28(12):3708–3715. DOI: <a href="https://doi.org/10.1681/ASN.2016121288" target="_blank" rel="noopener noreferrer">10.1681/ASN.2016121288</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28912373/" target="_blank" rel="noopener noreferrer">PubMed PMID 28912373</a>.</em></small></p>

<p><small><em>4. Nakajima Hanako, Hashimoto Yoshitaka, Okamura Takuro, Obora Akihiro, Kojima Takao, Hamaguchi Masahide, Fukui Michiaki. Association between Sleep Duration and Incident Chronic Kidney Disease: A Population-Based Cohort Analysis of the NAGALA Study. <em>Kidney and Blood Pressure Research.</em> 2020;45(2):339–349. DOI: <a href="https://doi.org/10.1159/000504545" target="_blank" rel="noopener noreferrer">10.1159/000504545</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32131067/" target="_blank" rel="noopener noreferrer">PubMed PMID 32131067</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky číselné údaje o štúdii UK Biobank boli overené priamo v plnom texte primárnej práce (PMC13585268), nie v sekundárnych prevzatiach. Autorský zoznam, ročník, číslo, strany a DOI boli nezávisle overené v databáze Crossref a v PubMed. Údaje o algoritme SleepNet (skóre F1 0,49 a systematické rozdiely oproti polysomnografii) aj výsledok dvojročného odstupového testu (približne 60 % zachovaných nálezov) pochádzajú z metodickej a diskusnej časti primárnej práce. Nefrologické súvislosti boli doplnené z kohort CRIC a NAGALA, ktoré v primárnej štúdii citované nie sú.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je zaradenie čísel do klinického kontextu, upozornenie na protichodné správanie ľahkého spánku, kvantitatívne porovnanie expozičného kontrastu so systematickou chybou merania a hypotéza, že mimoriadne nízky pomer hazardov pri parkinsonizme môže odrážať nerozpoznanú poruchu správania v REM spánku pri odhade fáz z pohybu. Táto hypotéza nie je v primárnej práci uvedená a je formulovaná ako hypotéza, nie ako zistenie.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek, mozog a kognitívne poruchy</a></li>
  <li><a href="article.php?slug=indoxyl-sulfat-kognitivne-zhorsenie-ckd">Indoxylsulfát a kognitívne zhoršenie pri chronickej chorobe obličiek</a></li>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie pri chronickej chorobe obličiek</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rem-spanok-riziko-83-ochoreni-uk-biobank_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "────────────────────────────────────────────────────\n\n";
}
?>