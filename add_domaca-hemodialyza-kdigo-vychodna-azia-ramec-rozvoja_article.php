<?php

/**
 * add_domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja_article.php
 * Domaca hemodialyza: sprava KDIGO z workshopu vo vychodnej Azii a co k tomu hovoria randomizovane data.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'Domáca hemodialýza: väčšia autonómia pacienta nestačí bez fungujúceho systému',
    'slug'         => 'domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nová správa KDIGO z pracovného stretnutia v japonskom Kawagoe navrhuje trojfázový rámec rozvoja domácej hemodialýzy. Randomizované údaje však ukazujú, že rozhodujúci nie je samotný presun dialýzy domov — a že intenzívnejšie režimy majú aj vlastné riziká.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Domáca hemodialýza dáva vybraným pacientom väčšiu kontrolu nad časom, miestom a často aj frekvenciou liečby. Nová správa organizácie KDIGO navrhuje, ako jej program bezpečne vybudovať vo východnej Ázii. Randomizované štúdie však ukazujú niečo, čo sa v diskusii o domácej dialýze ľahko stráca: klinický prínos neurčuje miesto liečby, ale predpis, podpora a bezpečnostné zázemie.</em></p>

<p>Domáca hemodialýza umožňuje pacientom s <a href="article.php?slug=co-je-dialyza">terminálnym zlyhaním obličiek</a> vykonávať liečbu vo vlastnom prostredí, spravidla častejšie alebo dlhšie, než dovoľuje rozvrh dialyzačného strediska. Jej dostupnosť napriek tomu zostáva v mnohých krajinách veľmi obmedzená.</p>

<p>Pracovný dokument organizácie Kidney Disease: Improving Global Outcomes (KDIGO), publikovaný v <em>Kidney International Reports</em>, analyzuje podmienky potrebné na zavedenie a rozšírenie domácej hemodialýzy v Hongkongu, Japonsku, Južnej Kórei a na Taiwane. Vychádza z jednodňového pracovného stretnutia, ktoré sa konalo v septembri 2025 v japonskom Kawagoe za účasti nefrológov, sestier, zástupcov odborných spoločností a samotných pacientov liečených domácou hemodialýzou.</p>

<h2>Čo tento dokument je a čo nie je</h2>

<p>Nejde o klinické odporúčanie založené na systematickom hodnotení dôkazov. Ide o <strong>konsenzuálnu správu z pracovného stretnutia</strong>, ktorá navrhuje organizačný a strategický rámec — teda „cestovnú mapu“ pre poskytovateľov, platiteľov a regulátorov.</p>

<p>Hlavnou hodnotou dokumentu preto nie je dokazovanie nadradenosti domácej hemodialýzy nad strediskovou. Je ňou pomenovanie podmienok, bez ktorých sa bezpečný a udržateľný program domácej liečby jednoducho nedá vybudovať. Túto distinkciu treba pri čítaní podobných dokumentov držať v hlave — implementačný rámec sa v druhotnom prerozprávaní ľahko zmení na tvrdenie o účinnosti.</p>

<h2>Domáca hemodialýza nie je jediná liečebná modalita</h2>

<p>Pojem domáca hemodialýza zahŕňa viacero režimov. Liečba môže prebiehať:</p>

<ul>
  <li>v konvenčnom režime približne trikrát týždenne,</li>
  <li>častejšie, v podobe krátkych denných procedúr,</li>
  <li>počas dlhších nočných procedúr,</li>
  <li>alebo podľa individualizovaného rozvrhu kombinujúceho frekvenciu a dĺžku dialýzy.</li>
</ul>

<p>Výsledky konkrétneho programu preto nemožno automaticky prenášať na všetky formy domácej hemodialýzy. Klinický účinok závisí nielen od miesta liečby, ale aj od celkového dialyzačného času, frekvencie procedúr, charakteru <a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">cievneho prístupu</a>, reziduálnej funkcie obličiek, adherencie pacienta a kvality podpory poskytovanej dialyzačným centrom.</p>

<p>Domáca hemodialýza sa zároveň nemá posudzovať izolovane od peritoneálnej dialýzy, transplantácie obličky a konzervatívnej liečby. Výber modality má vychádzať zo spoločného rozhodovania a z individuálnych klinických, funkčných a sociálnych okolností pacienta.</p>

<h2>Prečo zostáva jej využitie nízke</h2>

<p>Zastúpenie domácej hemodialýzy sa medzi krajinami východnej Ázie výrazne líši. Autori správy uvádzajú ako hlavné príčiny nízkeho využitia:</p>

<ul>
  <li>silnú zavedenú kultúru strediskovej hemodialýzy,</li>
  <li>infraštruktúru dialyzačnej starostlivosti postavenú na nemocniciach,</li>
  <li>regulačné prekážky,</li>
  <li>obmedzené znalosti domácej hemodialýzy medzi dialyzačnými lekármi a sestrami,</li>
  <li>nároky na priestorové, hygienické a technické vybavenie domácnosti,</li>
  <li>obavy pacientov zo samostatného vykonávania liečby.</li>
</ul>

<p>K tomu pristupujú prekážky, ktoré sú špecifické pre konkrétny zdravotnícky systém — najmä nastavenie úhrady, dostupnosť technického servisu a malý počet centier so skúsenosťou s domácim programom.</p>

<p>Ak úhrada zvýhodňuje strediskovú hemodialýzu, poskytovateľ nemá dostatočnú ekonomickú motiváciu investovať do domáceho programu. Pacient pritom môže znášať časť nákladov na vodu, elektrickú energiu, úpravu domácnosti alebo dopravu materiálu. <strong>Ani formálna dostupnosť modality preto neznamená jej reálnu dostupnosť.</strong></p>

<h2>Čo skutočne ukázali randomizované štúdie</h2>

<p>Toto je bod, v ktorom sa v popularizačných textoch o domácej dialýze najčastejšie chybuje. Randomizované údaje o intenzívnejšej hemodialýze pochádzajú prevažne z dvoch paralelných štúdií siete Frequent Hemodialysis Network (FHN) — a ich výsledky sa zásadne líšia.</p>

<h3>FHN Daily Trial — šesťkrát týždenne, ale v stredisku</h3>

<p>Štúdia randomizovala 245 pacientov na hemodialýzu šesťkrát týždenne (125 osôb) alebo trikrát týždenne (120 osôb) počas 12 mesiacov. Častejšia dialýza priniesla významný prínos v oboch spoločných primárnych ukazovateľoch: pomer rizík pre úmrtie alebo nárast hmotnosti ľavej komory bol 0,61 (95 % IS 0,46–0,82) a pre úmrtie alebo zhoršenie zložky telesného zdravia 0,70 (95 % IS 0,53–0,92).</p>

<p>Zásadná poznámka: <strong>táto štúdia prebiehala v dialyzačnom stredisku, nie doma.</strong> Ide teda o dôkaz o účinku vyššej frekvencie dialýzy, nie o dôkaz o prínose domáceho prostredia.</p>

<h3>FHN Nocturnal Trial — nočná domáca dialýza, negatívny výsledok</h3>

<p>Paralelná štúdia randomizovala 87 pacientov na konvenčnú hemodialýzu trikrát týždenne alebo na nočnú domácu hemodialýzu šesťkrát týždenne. Intenzívnejšie liečená skupina dosiahla 1,82-násobne vyšší priemerný týždenný stdKt/V<sub>urea</sub> a 2,45-násobne dlhší týždenný dialyzačný čas.</p>

<p>Napriek tomu autori <strong>nezistili významný účinok na ani jeden zo spoločných primárnych ukazovateľov</strong> (úmrtie alebo hmotnosť ľavej komory: pomer rizík 0,68; úmrtie alebo zložka telesného zdravia RAND: 0,91). Zlepšila sa kontrola hyperfosfatémie a hypertenzie, ostatné hlavné sekundárne ukazovatele nie. Zaznamenal sa trend k vyššiemu počtu príhod cievneho prístupu.</p>

<h3>Dlhodobé sledovanie nočnej štúdie</h3>

<p>Neskoršia analýza s mediánom sledovania 3,7 roka zaznamenala v skupine s nočnou domácou hemodialýzou 14 úmrtí oproti 5 úmrtiam v konvenčnej skupine; celkový pomer rizík úmrtia bol 3,88 (95 % IS 1,27–11,79; p = 0,01).</p>

<p>Tento výsledok <strong>netreba čítať ako dôkaz, že nočná domáca hemodialýza zabíja</strong>. Ide o malý súbor, veľmi nízky počet príhod, prekvapivo nízku mortalitu v kontrolnej skupine a široký interval spoľahlivosti. Je to však vážny signál, ktorý vyvracia predstavu, že intenzívnejšia liečba je automaticky bezpečnejšia, a ktorý sa v propagačných materiáloch o domácej dialýze spravidla neuvádza.</p>

<h3>ACTIVE Dialysis — predĺžené hodiny bez zlepšenia kvality života</h3>

<p>Štúdia ACTIVE randomizovala 200 pacientov zo strediskových aj domácich programov na predĺženú (≥ 24 hodín týždenne) alebo štandardnú dialýzu (cieľ 12–15 hodín, maximum 18) počas 12 mesiacov. Primárny ukazovateľ — zmena kvality života podľa dotazníka EQ-5D — sa medzi skupinami nelíšil (priemerný rozdiel 0,04; 95 % IS −0,03 až 0,11; p = 0,29).</p>

<p>Predĺžená dialýza viedla k nižšej fosfatémii a kaliémii, vyššiemu hemoglobínu a menšej potrebe antihypertenzív a viazačov fosfátov. Hmotnostný index ľavej komory sa v podštúdii (95 pacientov) medzi skupinami významne nelíšil.</p>

<p>Zhrnuté: <strong>intenzívnejšia dialýza spoľahlivo zlepšuje laboratórne a liekové ukazovatele, no jej vplyv na kvalitu života a tvrdé klinické ciele je nekonzistentný.</strong></p>

<h2>Prežívanie: čo hovoria observačné údaje</h2>

<p>Najčastejšie citovaným dokladom o lepšom prežívaní pri domácej hemodialýze je párovaná registrová analýza, ktorá porovnala 1873 pacientov na dennej domácej hemodialýze s 9365 párovanými pacientmi na strediskovej dialýze trikrát týždenne. Kumulatívna úmrtnosť bola 19,2 % oproti 21,7 %, čo zodpovedá o 13 % nižšiemu riziku úmrtia (pomer rizík 0,87; 95 % IS 0,78–0,97).</p>

<p>Ide o dôležitý, ale observačný nález. Pacienti vybraní na domácu hemodialýzu bývajú mladší, funkčne zdatnejší, motivovanejší a majú lepšiu sociálnu podporu. Aj po štatistickom zohľadnení známych rozdielov zostáva významné riziko selekčného skreslenia — párovanie dokáže vyrovnať len to, čo register meria.</p>

<p>Konsenzuálna konferencia KDIGO o domácej dialýze z roku 2023 to formulovala striedmo: klinické výsledky sú naprieč dialyzačnými modalitami <em>zväčša podobné</em>, a preto má byť voľba modality vedená predovšetkým preferenciou pacienta.</p>

<p>Primeraná formulácia teda znie: <strong>domáca hemodialýza môže vybraným pacientom zlepšiť autonómiu, flexibilitu a niektoré klinické ukazovatele, ale jej nezávislý vplyv na prežívanie nie je spoľahlivo dokázaný.</strong></p>

<h2>Riziká intenzívnejšej liečby</h2>

<p>Častejšia alebo nočná hemodialýza nie je bez rizika. Vyšší počet kanylácií zaťažuje cievny prístup: v štúdii FHN Daily boli intervencie na cievnom prístupe v skupine s častejšou dialýzou významne početnejšie (pomer rizík 1,71; 95 % IS 1,08–2,73), v nočnej štúdii sa pozoroval podobný trend. Pri nevhodne nastavenom predpise môže vzniknúť hypotenzia, porucha elektrolytovej rovnováhy, nadmerná strata fosfátov a ďalších látok či nedostatočný čas na regeneráciu pacienta.</p>

<p>Osobitnú pozornosť si vyžadujú:</p>

<ul>
  <li>infekcia a krvácanie z cievneho prístupu,</li>
  <li>vysunutie dialyzačnej ihly počas procedúry,</li>
  <li>vzduchová embólia,</li>
  <li>technické zlyhanie prístroja,</li>
  <li>porucha prívodu vody alebo elektrickej energie,</li>
  <li>nesprávna reakcia na alarm,</li>
  <li>oneskorené rozpoznanie klinického zhoršenia.</li>
</ul>

<p>Riziko vysunutia ihly a vzduchovej embólie je pri nočných režimoch zvýšené práve preto, že pacient spí. Bezpečnosť preto nemožno založiť iba na schopnosti pacienta obsluhovať prístroj. Potrebné sú štandardizované postupy, pravidelné preverovanie vedomostí, technický servis, nepretržite dostupná odborná pomoc a jasný plán pre mimoriadne situácie vrátane urgentného návratu do strediska.</p>

<h2>Záťaž pacienta a rodiny sa nesmie prehliadať</h2>

<p>Domáca liečba oslobodzuje pacienta od pevného rozvrhu dialyzačného strediska, súčasne však presúva časť práce a zodpovednosti do domácnosti. Pacient alebo jeho blízka osoba preberá úlohy, ktoré v stredisku vykonávajú zdravotnícki pracovníci.</p>

<p>S tým môže súvisieť:</p>

<ul>
  <li>únava z dlhodobej samoobsluhy,</li>
  <li>strach z komplikácií,</li>
  <li>narušenie súkromia domácnosti,</li>
  <li>napätie v partnerskom vzťahu,</li>
  <li>záťaž neformálneho opatrovateľa,</li>
  <li>postupná strata motivácie,</li>
  <li>návrat k strediskovej dialýze.</li>
</ul>

<p>Úspešnosť programu sa preto nemá hodnotiť iba počtom zaradených pacientov. Dôležité je aj dlhodobé zotrvanie v programe, bezpečnosť, kvalita života, skúsenosť rodiny a dôvody ukončenia domácej liečby.</p>

<p><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Spoločné rozhodovanie</a> nesmie nadobudnúť podobu presviedčania pacienta, aby si zvolil modalitu výhodnejšiu pre zdravotnícky systém. Pacient musí dostať vyvážené informácie o prínosoch, rizikách, praktických nárokoch a alternatívach.</p>

<h2>Trojfázový model rozvoja programu</h2>

<p>Odporúčania správy možno zhrnúť do troch nadväzujúcich etáp.</p>

<h3>1. Vytvorenie politických, finančných a regulačných podmienok</h3>

<p>Pred začatím programu treba určiť spôsob úhrady, zodpovednosť poskytovateľa, technické a hygienické normy, pravidlá distribúcie materiálu, systém kontroly kvality a požiadavky na odbornú spôsobilosť pracovníkov.</p>

<p>Ak tieto podmienky nie sú stanovené vopred, program zostáva závislý od jednotlivých nadšencov a po personálnej zmene môže zaniknúť.</p>

<h3>2. Pilotný program a vytvorenie odborného tímu</h3>

<p>Začiatok v podobe menšieho pilotného programu umožňuje odhaliť organizačné problémy bez nekontrolovaného rozširovania rizík. Centrum potrebuje lekárov, sestry, technikov, nutričných terapeutov a podľa potreby aj sociálnych pracovníkov či psychológov so skúsenosťami v domácej liečbe.</p>

<p>Partnerstvo so skúseným centrom môže skrátiť čas potrebný na zavedenie bezpečných pracovných postupov. Jednorazové školenie nestačí — potrebná je kontinuálna supervízia a pravidelná aktualizácia kompetencií.</p>

<h3>3. Riadené rozširovanie a priebežné zlepšovanie kvality</h3>

<p>Program sa má rozširovať až po vyhodnotení pilotnej fázy. Sledovať treba minimálne:</p>

<ul>
  <li>závažné nežiaduce udalosti,</li>
  <li>hospitalizácie,</li>
  <li>infekcie a komplikácie cievneho prístupu,</li>
  <li>technické incidenty,</li>
  <li>výsledky pravidelného preškoľovania,</li>
  <li>kvalitu života pacienta,</li>
  <li>záťaž neformálneho opatrovateľa,</li>
  <li>ukončenie domácej liečby a jeho príčiny,</li>
  <li>náklady z pohľadu zdravotníctva aj domácnosti.</li>
</ul>

<p><strong>Počet pacientov liečených doma nie je sám osebe dostatočným ukazovateľom kvality.</strong></p>

<h2>Kto môže byť vhodným kandidátom</h2>

<p>Vhodnosť nemožno redukovať na vek alebo technickú zručnosť. Posúdenie má zahŕňať:</p>

<ul>
  <li>klinickú stabilitu,</li>
  <li>schopnosť učiť sa a dodržiavať bezpečnostné postupy,</li>
  <li>manuálne a zrakové schopnosti,</li>
  <li>stav cievneho prístupu,</li>
  <li>psychickú pripravenosť,</li>
  <li>podmienky domácnosti,</li>
  <li>dostupnosť podpory,</li>
  <li>preferencie pacienta a jeho rodiny.</li>
</ul>

<p>Pokročilý vek, telesné postihnutie či mierne kognitívne obmedzenie nemusia predstavovať absolútnu kontraindikáciu, ak je k dispozícii asistovaná forma liečby. Naopak, samotná motivácia nestačí, ak nemožno zabezpečiť bezpečné technické podmienky.</p>

<p>Sociálne a ekonomické kritériá nesmú vytvárať diskriminačný systém, v ktorom je domáca hemodialýza dostupná iba pacientom s väčším bytom, dostatočným príjmom a neplateným rodinným opatrovateľom.</p>

<h2>Prenositeľnosť záverov do európskych podmienok</h2>

<p>Východoázijský rámec nemožno bez úprav preniesť do iných regiónov. Rozdiely v úhrade, dostupnosti ošetrovateľskej starostlivosti, bývaní, technických normách, cenách energií a organizácii dialyzačnej siete sú podstatné. Osobitne to platí pre argument o „kultúre strediskovej hemodialýzy“ — v Japonsku či na Taiwane má strediskový model inú historickú a spoločenskú váhu než v strednej Európe.</p>

<p>Všeobecne prenosné sú však štyri princípy:</p>

<ol>
  <li>Domáci program nemožno budovať bez stabilného financovania.</li>
  <li>Kvalita závisí od skúseného multidisciplinárneho tímu.</li>
  <li>Pacient potrebuje dlhodobú podporu, nie iba vstupné školenie.</li>
  <li>Rozšírenie modality má byť výsledkom informovanej voľby, nie administratívne stanoveného cieľa.</li>
</ol>

<p>Pre menšie krajiny by mohol byť realistický model niekoľkých regionálnych referenčných centier s centralizovaným tréningom, technickou podporou a jednotným registrom výsledkov — podobne, ako to opisuje <a href="article.php?slug=domaca-dialyza-100-pacientov-treningovy-model">skúsenosť barcelonského centra so stovkou pacientov na domácej dialýze</a>. Pred zavedením by však bolo potrebné analyzovať legislatívnu zodpovednosť, úhradu energií a úprav domácnosti, dostupnosť nepretržitej pomoci a organizáciu urgentného návratu do dialyzačného strediska.</p>

<h2>Sila dôkazov: čo je doložené a čo nie</h2>

<div class="table-responsive" role="region" aria-label="Sila dôkazov: čo je doložené a čo nie" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Tvrdenie</th><th scope="col">Stav dôkazov</th></tr>
  </thead>
  <tbody>
    <tr><td>Domáca hemodialýza zvyšuje flexibilitu a autonómiu</td><td>Dobre odôvodnené; individuálny prínos závisí od režimu a okolností pacienta</td></tr>
    <tr><td>Domáca hemodialýza zlepšuje kvalitu života</td><td>Nekonzistentné; štúdia ACTIVE nepreukázala rozdiel v EQ-5D pri predĺžených hodinách</td></tr>
    <tr><td>Častejšia dialýza zlepšuje kontrolu tlaku a fosfatémie</td><td>Podporené randomizovanými údajmi (FHN Daily aj Nocturnal, ACTIVE)</td></tr>
    <tr><td>Častejšia dialýza znižuje hmotnosť ľavej komory</td><td>Preukázané len pri <em>strediskovej</em> dialýze 6× týždenne; v domácej nočnej štúdii nie</td></tr>
    <tr><td>Domáca hemodialýza predlžuje prežívanie</td><td>Kauzálny účinok nie je dokázaný; registrové porovnania sú zaťažené selekčným skreslením</td></tr>
    <tr><td>Intenzívnejšie režimy sú vždy bezpečnejšie</td><td>Nesprávne; zvyšujú počet intervencií na cievnom prístupe a nesú vlastné riziká</td></tr>
    <tr><td>Hlavnou prekážkou je neochota pacientov</td><td>Zjednodušujúce; zásadné sú kultúra starostlivosti, úhrada, infraštruktúra a tréning</td></tr>
    <tr><td>Zvýšenie počtu domácich pacientov je dôkazom úspechu</td><td>Nedostatočné; treba hodnotiť bezpečnosť, zotrvanie, kvalitu života, rovnosť prístupu a náklady</td></tr>
    <tr><td>Správa KDIGO predstavuje klinické odporúčanie</td><td>Nie; ide o konsenzuálnu správu z pracovného stretnutia a implementačný rámec</td></tr>
  </tbody>
</table>
</div>

<h2>Záver</h2>

<p>Domáca hemodialýza môže rozšíriť možnosti liečby a priniesť väčšiu autonómiu pacientom, ktorí o ňu majú záujem a dokážu ju bezpečne vykonávať. Nie je však univerzálne vhodná ani automaticky nadradená strediskovej hemodialýze — a randomizované údaje to potvrdzujú zreteľnejšie, než sa obvykle pripúšťa.</p>

<p>Nová správa KDIGO správne zdôrazňuje, že rozhodujúcim problémom nie je dostupnosť technológie. Potrebný je celý systém zahŕňajúci financovanie, odborný tím, tréning, technickú podporu, zber výsledkov, ochranu pacienta a rešpektovanie jeho preferencií.</p>

<p>Rozvoj domácej hemodialýzy preto nemá byť súťažou o čo najvyšší počet domácich pacientov. Cieľom má byť bezpečný, spravodlivý a udržateľný prístup k širšiemu spektru liečebných možností — a poctivá informácia pacientovi o tom, čo mu domáca liečba dá a čo od neho bude vyžadovať.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=domaca-dialyza-100-pacientov-treningovy-model">Sto pacientov na domácej dialýze</a> — model tréningu a domáceho monitorovania.</li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba modality</a>.</li>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Spoločné rozhodovanie o náhrade funkcie obličiek</a> — keď pacient nechce zdieľať svoje hodnoty.</li>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Načasovanie cievneho prístupu pred hemodialýzou</a>.</li>
  <li><a href="article.php?slug=predikcia-vhodnosti-peritonealnej-dialyzy-validacia">Predikcia vhodnosti peritoneálnej dialýzy</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Ikuto Masakane, Paul N. Bennett, Chia-Ter Chao, Michael Cheung, Tsutomu Furuzono, Masaki Hara, Yung-Ho Hsu, Chiu-Ching Huang, Sayaka Ishigaki, Michel Jadoul, Eunjeong Kang, Seong Geun Kim, Kenichi Kokubo, Hirotaka Komaba, Huey-Liang Kuo, Ki Jeong Kwon, Vickie Kwong, Wai-Yan Lau, Titus Lau, Dong Hyung Lee, Philip Kam-Tao Li, Mark Marshall, Sandip Mitra, Kojiro Nagai, Tomonari Ogawa, Hyeong Cheon Park, Clara Poon, Naoko Tsuji, Joseph Wong, Po Kwan Wong, Sunny Wong, Hung-Lai Wu, Mei-Yi Wu, Kyung Don Yoo, Christopher T. Chan.</strong> <em>KDIGO Workshop Report on the Implementation and Expansion of Home Hemodialysis in East Asia: A Focus on Hong Kong, Japan, Korea, and Taiwan.</em> Kidney International Reports. 2026;11(8):106588. doi: 10.1016/j.ekir.2026.106588. <a href="https://doi.org/10.1016/j.ekir.2026.106588" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Jeffrey Perl, Edwina A. Brown, Christopher T. Chan, Cécile Couchoud, Simon J. Davies, Rümeyza Kazancioğlu, Scott Klarenbach, Adrian Liew, Daniel E. Weiner, Michael Cheung, Michel Jadoul, Wolfgang C. Winkelmayer, Martin E. Wilkie.</strong> <em>Home dialysis: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference.</em> Kidney International. 2023;103(5):842–858. doi: 10.1016/j.kint.2023.01.006. <a href="https://doi.org/10.1016/j.kint.2023.01.006" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>FHN Trial Group; Glenn M. Chertow, Nathan W. Levin, Gerald J. Beck, Thomas A. Depner, Paul W. Eggers, Jennifer J. Gassman, Irina Gorodetskaya, Tom Greene, Sam James, Brett Larive, Robert M. Lindsay, Ravindra L. Mehta, Brent Miller, Daniel B. Ornt, Sanjay Rajagopalan, Anjay Rastogi, Michael V. Rocco, Brigitte Schiller, Olga Sergeyeva, Gerald Schulman, George O. Ting, Mark L. Unruh, Robert A. Star, Alan S. Kliger.</strong> <em>In-center hemodialysis six times per week versus three times per week.</em> The New England Journal of Medicine. 2010;363(24):2287–2300. doi: 10.1056/NEJMoa1001593. <a href="https://doi.org/10.1056/NEJMoa1001593" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Michael V. Rocco, Robert S. Lockridge Jr., Gerald J. Beck, Paul W. Eggers, Jennifer J. Gassman, Tom Greene, Brett Larive, Christopher T. Chan, Glenn M. Chertow, Michael Copland, Christopher D. Hoy, Robert M. Lindsay, Nathan W. Levin, Daniel B. Ornt, Andreas Pierratos, Mary F. Pipkin, Sanjay Rajagopalan, John B. Stokes, Mark L. Unruh, Robert A. Star, Alan S. Kliger.</strong> <em>The effects of frequent nocturnal home hemodialysis: the Frequent Hemodialysis Network Nocturnal Trial.</em> Kidney International. 2011;80(10):1080–1091. doi: 10.1038/ki.2011.213. <a href="https://doi.org/10.1038/ki.2011.213" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Michael V. Rocco, John T. Daugirdas, Tom Greene, Robert S. Lockridge, Christopher T. Chan, Andreas Pierratos, Robert Lindsay, Brett Larive, Glenn M. Chertow, Gerald J. Beck, Paul W. Eggers, Alan S. Kliger; FHN Trial Group.</strong> <em>Long-term Effects of Frequent Nocturnal Hemodialysis on Mortality: The Frequent Hemodialysis Network (FHN) Nocturnal Trial.</em> American Journal of Kidney Diseases. 2015;66(3):459–468. doi: 10.1053/j.ajkd.2015.02.331. <a href="https://doi.org/10.1053/j.ajkd.2015.02.331" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Meg J. Jardine, Li Zuo, Nicholas A. Gray, Janak R. de Zoysa, Christopher T. Chan, Martin P. Gallagher, Helen Monaghan, Stuart M. Grieve, Rajesh Puranik, Hongli Lin, Josette M. Eris, Ling Zhang, Jinsheng Xu, Kirsten Howard, Serigne Lo, Alan Cass, Vlado Perkovic.</strong> <em>A Trial of Extending Hemodialysis Hours and Quality of Life (ACTIVE Dialysis).</em> Journal of the American Society of Nephrology. 2017;28(6):1898–1911. doi: 10.1681/ASN.2015111225. <a href="https://doi.org/10.1681/ASN.2015111225" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Eric D. Weinhandl, Jiannong Liu, David T. Gilbertson, Thomas J. Arneson, Allan J. Collins.</strong> <em>Survival in daily home hemodialysis and matched thrice-weekly in-center hemodialysis patients.</em> Journal of the American Society of Nephrology. 2012;23(5):895–904. doi: 10.1681/ASN.2011080761. <a href="https://doi.org/10.1681/ASN.2011080761" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Bessie A. Young, Christopher T. Chan, Christopher R. Blagg, Robert S. Lockridge Jr., Thomas A. Golper, Fredric O. Finkelstein, Rachel Shaffer, Rajnish Mehrotra; ASN Dialysis Advisory Group.</strong> <em>How to overcome barriers and establish a successful home HD program.</em> Clinical Journal of the American Society of Nephrology. 2012;7(12):2023–2032. doi: 10.2215/CJN.07080712. <a href="https://doi.org/10.2215/CJN.07080712" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a kompletné autorstvo všetkých ôsmich citovaných prác boli overené v Europe PMC a v databáze PubMed. Číselné údaje (pomery rizík, intervaly spoľahlivosti, veľkosti súborov, dĺžky sledovania) sú prevzaté priamo z abstraktov primárnych publikácií; plné texty za paywallom neboli dostupné, takže podrobnosti metodiky nebolo možné nezávisle preveriť. Popis pracovného stretnutia KDIGO — jednodňové stretnutie v septembri 2025 v japonskom Kawagoe a zoznam bariér využívania domácej hemodialýzy vo východnej Ázii — vychádza z abstraktu správy. Rozbor prenositeľnosti do európskych a slovenských podmienok, upozornenie na rozdiel medzi strediskovou a domácou intenzívnou dialýzou vo FHN štúdiách, tabuľka sily dôkazov a výhrady k selekčnému skresleniu registrových porovnaní sú <strong>vlastným odborným spracovaním</strong> opretým o citované práce.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja_article',
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
