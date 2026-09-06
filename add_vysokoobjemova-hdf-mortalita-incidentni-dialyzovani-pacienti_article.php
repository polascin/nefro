<?php

/**
 * add_vysokoobjemova-hdf-mortalita-incidentni-dialyzovani-pacienti_article.php
 * Vysokoobjemova HDF a mortalita incidentnych dialyzovanych pacientov
 * (Zhang a spol., CJASN 2026;21(7):1198-1206, doi 10.2215/CJN.0000001063).
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
    'title'        => 'Vysokoobjemová hemodiafiltrácia a mortalita nových dialyzovaných pacientov: presvedčivá asociácia, nie dôkaz kauzality',
    'slug'         => 'vysokoobjemova-hdf-mortalita-incidentni-dialyzovani-pacienti',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kohorta 18 515 incidentných dialyzovaných pacientov spája online hemodiafiltráciu s o 20 % nižšou celkovou a o 29 % nižšou kardiovaskulárnou mortalitou. Prečo tlačová správa uvádza 28 % a prečo ide o inú štúdiu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Vysokoobjemová hemodiafiltrácia má randomizovaný dôkaz prínosu u prevalentných pacientov. Nová kohorta prináša chýbajúci diel: čo sa deje v prvých dvoch rokoch po začatí dialýzy. Výsledok je priaznivý a konzistentný — a zároveň je príkladom toho, ako sa to isté číslo dá v tlačovej správe a v publikácii vzťahovať na dve rôzne veci.</em></p>

<p>Online hemodiafiltrácia (HDF) kombinuje difúzny transport klasickej hemodialýzy s konvektívnym transportom. V porovnaní s konvenčnou vysokoprietokovou hemodialýzou preto účinnejšie odstraňuje širšie spektrum uremických látok vrátane stredne veľkých molekúl.</p>

<p>Nové údaje z klinickej praxe spájajú vysokoobjemovú hemodiafiltráciu so znížením celkovej aj kardiovaskulárnej mortality. Najväčšiu pozornosť si zasluhuje zistenie, že priaznivá asociácia sa pozorovala už u pacientov, ktorí dialyzačnú liečbu iba nedávno začali — teda v období, ktoré doterajšie štúdie pokrývali najslabšie.</p>

<p>Napriek priaznivým výsledkom treba dôsledne rozlišovať medzi randomizovaným dôkazom a observačnou asociáciou. Výber dialyzačnej modality nie je v bežnej praxi náhodný a môže súvisieť s prognózou pacienta nezávisle od samotnej hemodiafiltrácie.</p>

<h2>Čo ukázala medzinárodná kohortová štúdia</h2>

<p>Retrospektívna medzinárodná štúdia analyzovala údaje z registra EuCliD spoločnosti Fresenius Medical Care. Zahŕňala <strong>18 515 dospelých incidentných dialyzovaných pacientov</strong>, ktorí začali náhradu funkcie obličiek v rokoch 2019 až 2022 v centrách NephroCare v Európe, na Blízkom východe a v Afrike.</p>

<p>Za incidentných sa považovali pacienti s trvaním dialyzačnej liečby kratším ako tri mesiace. Podľa prevažujúcej modality počas prvého roka boli rozdelení na:</p>

<ul>
  <li><strong>10 149 pacientov</strong> liečených konvenčnou hemodialýzou,</li>
  <li><strong>8 366 pacientov</strong> liečených online hemodiafiltráciou.</li>
</ul>

<p>Na zaradenie do príslušnej skupiny musel pacient absolvovať danou modalitou najmenej <strong>75 % dialyzačných procedúr</strong>. Hemodiafiltrácia sa vykonávala výlučne v postdilučnom režime — predilučná HDF bola vyraďovacím kritériom — s priemerným konvekčným objemom <strong>24,9 litra na procedúru</strong> (medián 25,1 l; medzikvartilové rozpätie 23,1 – 27,2 l). Ide teda skutočne o vysokoobjemovú HDF v zmysle prahu 23 l na procedúru, ktorý používajú randomizované štúdie.</p>

<p>Medián sledovania bol <strong>15,7 mesiaca</strong> (medzikvartilové rozpätie 6,4 – 24,0 mesiaca), sledovanie bolo zámerne ohraničené dvoma rokmi.</p>

<h2>Celková mortalita</h2>

<p>Hrubá incidencia úmrtí dosahovala:</p>

<ul>
  <li><strong>11,7 úmrtia na 100 osoborokov</strong> pri hemodiafiltrácii,</li>
  <li><strong>15,6 úmrtia na 100 osoborokov</strong> pri hemodialýze.</li>
</ul>

<p>Po vyvážení známych vstupných charakteristík vážením inverznou pravdepodobnosťou liečby (IPTW) bola hemodiafiltrácia spojená s o 20 % nižším relatívnym rizikom úmrtia: <strong>HR 0,80 (95 % IS 0,75–0,86)</strong>.</p>

<p>Dodatočná korekcia na vek a typ cievneho prístupu priniesla mierne konzervatívnejší výsledok: <strong>HR 0,82 (95 % IS 0,77–0,88)</strong>. Pri prístupe približujúcom sa analýze podľa pôvodného liečebného zámeru bola asociácia ešte slabšia, ale stále priaznivá: <strong>HR 0,88 (95 % IS 0,82–0,95)</strong>.</p>

<p>Tento zostupný rad je poučný sám osebe. Čím prísnejšie sa analýza bráni skresleniu, tým menší je odhadovaný efekt. Rozdiel medzi HR 0,80 a HR 0,88 nie je detail — je to miera toho, koľko z pozorovaného prínosu môže pochádzať z metodiky a nie z liečby.</p>

<h2>Kardiovaskulárna mortalita</h2>

<p>Kardiovaskulárna mortalita dosahovala:</p>

<ul>
  <li><strong>4,1 úmrtia na 100 osoborokov</strong> pri hemodiafiltrácii,</li>
  <li><strong>6,7 úmrtia na 100 osoborokov</strong> pri hemodialýze.</li>
</ul>

<p>Po štatistickej korekcii bola hemodiafiltrácia spojená s o 29 % nižším relatívnym rizikom kardiovaskulárneho úmrtia: <strong>HR 0,71 (95 % IS 0,63–0,80)</strong>. Príčina úmrtia bola dokumentovaná pri 93,4 % úmrtí, čo je na register neobvykle dobrá úplnosť.</p>

<p>Priaznivá asociácia sa pozorovala vo väčšine analyzovaných podskupín. <strong>U pacientov s diabetom však výsledok pre kardiovaskulárnu mortalitu nedosiahol štatistickú významnosť.</strong> To nepreukazuje neprítomnosť účinku pri diabete — znamená to, že údaje v tejto podskupine neposkytli dostatočne presvedčivý dôkaz. Podskupinové analýzy majú spravidla nižšiu silu a nemajú sa čítať ako samostatné štúdie.</p>

<h2>Tlačová správa hovorí o 28 %. Ide o inú štúdiu</h2>

<p>Tlačová správa spoločnosti Fresenius Medical Care z 27. augusta 2026 uvádza <strong>28 % nižšie relatívne riziko celkovej mortality</strong>, pričom pri konvekčných objemoch nad 23 litrov na procedúru hovorí až o 33 %. Publikovaná kohorta incidentných pacientov pritom uvádza 20 %.</p>

<p>Tieto čísla si neprotirečia — <strong>pochádzajú z dvoch odlišných prác</strong>. Údaj 28 % zodpovedá HR 0,72 z emulácie cieľovej štúdie publikovanej v <em>Journal of the American Society of Nephrology</em> (Strippoli a spol.), ktorá analyzovala inú populáciu, iné obdobie a inú definíciu expozície:</p>

<div class="table-responsive" role="region" aria-label="Porovnanie dvoch registrových štúdií hemodiafiltrácie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Parameter</th>
        <th scope="col">CJASN (Zhang a spol.)</th>
        <th scope="col">JASN (Strippoli a spol.)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Populácia</th>
        <td>Incidentní (dialýza &lt; 3 mesiace)</td>
        <td>Sledovanie začína 91. deň po začatí dialýzy</td>
      </tr>
      <tr>
        <th scope="row">Obdobie</th>
        <td>2019 – 2022</td>
        <td>2014 – 2019</td>
      </tr>
      <tr>
        <th scope="row">Región</th>
        <td>NephroCare, Európa, Blízky východ a Afrika</td>
        <td>Osem európskych krajín</td>
      </tr>
      <tr>
        <th scope="row">Počet pacientov</th>
        <td>18 515</td>
        <td>19 539 (vážená pseudopopulácia 19 758)</td>
      </tr>
      <tr>
        <th scope="row">Definícia expozície</th>
        <td>≥ 75 % procedúr počas 1. roka</td>
        <td>≥ 90 % procedúr (trvalá stratégia)</td>
      </tr>
      <tr>
        <th scope="row">Metóda</th>
        <td>Coxov model + IPTW</td>
        <td>Emulácia cieľovej štúdie, transplantácia ako konkurujúca udalosť</td>
      </tr>
      <tr>
        <th scope="row">Medián sledovania</th>
        <td>15,7 mesiaca</td>
        <td>16 mesiacov</td>
      </tr>
      <tr>
        <th scope="row">Celková mortalita</th>
        <td><strong>HR 0,80</strong> (0,75–0,86)</td>
        <td><strong>HR 0,72</strong> (0,67–0,77)</td>
      </tr>
      <tr>
        <th scope="row">Absolútny rozdiel</th>
        <td>Hrubý rozdiel 3,9 úmrtia na 100 osoborokov</td>
        <td>20,6 % oproti 22,3 % za 2 roky = 1,7 percentuálneho bodu</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Údaj o absolútnom rozdiele v štúdii JASN si zaslúži komentár. Relatívne riziko kleslo o 28 %, ale absolútny rozdiel v kumulatívnej incidencii úmrtia po dvoch rokoch predstavoval iba 1,7 percentuálneho bodu. Tento zdanlivý nesúlad vzniká tým, že kumulatívna incidencia bola počítaná so <strong>zohľadnením transplantácie obličky ako konkurujúcej udalosti</strong>, čo rozdiely medzi ramenami stláča. Ide o užitočnú pripomienku, že relatívne a absolútne miery účinku nie sú zameniteľné a že pacientovi je zrozumiteľnejšia tá druhá.</p>

<p>Pre odbornú interpretáciu preto platí jednoduché pravidlo: <strong>u novo dialyzovaného pacienta je relevantný odhad z incidentnej kohorty, teda 20 %</strong>. Údaj 28 % sa vzťahuje na pacientov s dlhším dialyzačným vekom a na trvalú expozíciu definovanú prísnejšie.</p>

<h2>Ako to zapadá do randomizovaných dôkazov</h2>

<p>Registrové analýzy nestoja osamotene. Existuje randomizovaný dôkaz, s ktorým treba nové zistenia porovnať:</p>

<div class="table-responsive" role="region" aria-label="Randomizované štúdie vysokoobjemovej hemodiafiltrácie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štúdia</th>
        <th scope="col">Počet pacientov</th>
        <th scope="col">Konvekčný objem</th>
        <th scope="col">Celková mortalita</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">CONVINCE (2023)</th>
        <td>1 360 (683 HDF / 677 HD)</td>
        <td>priemerne 25,3 l na procedúru</td>
        <td>17,3 % oproti 21,9 %; HR 0,77 (95 % IS 0,65–0,93)</td>
      </tr>
      <tr>
        <th scope="row">ESHOL (2013)</th>
        <td>906</td>
        <td>vysokoefektívna postdilučná HDF</td>
        <td>zníženie celkovej mortality oproti hemodialýze</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Randomizovaná štúdia CONVINCE zaradila pacientov, ktorí už boli aspoň tri mesiace na vysokoprietokovej hemodialýze a boli považovaní za vhodných na dosiahnutie konvekčného objemu aspoň 23 l. Aj tu teda ide o <strong>prevalentnú, vopred vyselektovanú populáciu</strong>. Práve preto je nová kohorta doplnkom, nie duplikátom: pýta sa na obdobie, ktoré randomizované štúdie nepokrývajú.</p>

<p>Zároveň je upokojujúce, že odhad z incidentnej kohorty (HR 0,80) leží veľmi blízko randomizovaného odhadu z CONVINCE (HR 0,77). Zhoda observačného a randomizovaného výsledku síce kauzalitu nedokazuje, ale výrazne znižuje pravdepodobnosť, že celý pozorovaný rozdiel je artefaktom výberu pacientov.</p>

<h2>Biologická vierohodnosť</h2>

<p>Hemodiafiltrácia zvyšuje odstraňovanie stredne veľkých uremických molekúl, ktoré sa pri samotnej difúznej hemodialýze eliminujú menej účinne. Medzi potenciálne relevantné mechanizmy patria:</p>

<ul>
  <li>účinnejšie odstraňovanie beta-2-mikroglobulínu a ďalších stredných molekúl,</li>
  <li>zníženie expozície niektorým prozápalovým a proaterogénnym látkam,</li>
  <li>možné zlepšenie endotelovej funkcie,</li>
  <li>lepšia hemodynamická tolerancia u časti pacientov,</li>
  <li>priaznivejšia kontrola uremického vnútorného prostredia.</li>
</ul>

<p>Biologická vierohodnosť však nenahrádza klinický dôkaz. Štúdia priamo nepreukázala, ktorý mechanizmus zodpovedá za pozorovaný rozdiel v mortalite, a ani nemerala koncentrácie stredných molekúl.</p>

<h2>Silné stránky štúdie</h2>

<ul>
  <li>veľký počet incidentných pacientov, ktorí sú v literatúre podreprezentovaní,</li>
  <li>medzinárodný multicentrický charakter,</li>
  <li>údaje z bežnej klinickej praxe, nie z vybraného skúšajúceho centra,</li>
  <li>presné údaje o jednotlivých dialyzačných procedúrach vrátane skutočne dosiahnutého konvekčného objemu,</li>
  <li>priemerný konvekčný objem zodpovedajúci vysokoobjemovej HDF,</li>
  <li>korekcia na demografické, klinické a dialyzačné charakteristiky,</li>
  <li>viacero analýz citlivosti so zhodným smerom výsledku,</li>
  <li>dostupnosť príčiny úmrtia pri 93,4 % úmrtí.</li>
</ul>

<p>Dôležité je aj zameranie na prvé dva roky dialyzačnej liečby, keď je riziko úmrtia mimoriadne vysoké a keď má akékoľvek zlepšenie najväčší absolútny dosah.</p>

<h2>Zásadné metodologické obmedzenia</h2>

<h3>Observačný dizajn</h3>

<p>Pacienti neboli randomizovaní. O pridelení modality rozhodovala klinická prax, dostupnosť technológie, charakteristika centra, cievny prístup a zdravotný stav pacienta. Ani pokročilé štatistické metódy nedokážu odstrániť vplyv nemeraných faktorov — a schopnosť pacienta tolerovať vysoký konvekčný objem je presne takým faktorom.</p>

<h3>Rozdiely pred štatistickou korekciou</h3>

<p>Skupiny sa pred vážením líšili spôsobom, ktorý sám osebe predpovedá prognózu:</p>

<div class="table-responsive" role="region" aria-label="Vstupné rozdiely medzi skupinami pred vážením" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Charakteristika</th>
        <th scope="col">Hemodialýza</th>
        <th scope="col">Hemodiafiltrácia</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Vek (roky)</th>
        <td>64,5 ± 14,5</td>
        <td>62,0 ± 15,1</td>
      </tr>
      <tr>
        <th scope="row">Arteriovenózna fistula</th>
        <td>28 %</td>
        <td>40 %</td>
      </tr>
      <tr>
        <th scope="row">Diabetes</th>
        <td>38 %</td>
        <td>34 %</td>
      </tr>
      <tr>
        <th scope="row">Muži</th>
        <td>54 %</td>
        <td>58 %</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Rozdiel v type cievneho prístupu je najvýrečnejší. Fistula u 40 % oproti 28 % neznamená len lepší prístup — je ukazovateľom <strong>plánovaného, včas pripraveného začiatku dialýzy</strong>, teda pacienta, ktorý bol vopred v nefrologickej starostlivosti. Práve preto autori doplnili analýzu korigovanú aj na cievny prístup; reziduálne skreslenie však nemožno vylúčiť ani po nej.</p>

<h3>Podmienenie modality budúcou liečbou</h3>

<p>Pacient bol klasifikovaný podľa modality použitej najmenej pri 75 % procedúr počas prvého roka. Takýto postup používa informáciu získanú <em>po</em> začiatku sledovania. Aby pacient mohol byť zaradený do skupiny HDF, musel dostatočne dlho žiť — čo môže vytvoriť časové (nesmrteľné obdobie) alebo selekčné skreslenie.</p>

<p>Autori preto vykonali aj analýzu podľa modality na konci vstupného obdobia. Poskytla konzervatívnejší výsledok (HR 0,88), ktorý podporil smer asociácie, ale súčasne ukázal, že jej veľkosť závisí od analytického postupu.</p>

<h3>Vylúčenie najnestabilnejších pacientov</h3>

<p>Vylúčení boli pacienti, ktorí počas 30-dňového vstupného obdobia zomreli, podstúpili transplantáciu alebo boli inak vyradení. Vylúčení boli aj pacienti s priemerným online meraným Kt/V pod 1,2, ako aj krajiny s jedinou dostupnou modalitou.</p>

<p>Analyzovaná populácia teda predstavuje <strong>relatívne stabilných incidentných pacientov s primeranou dialyzačnou dávkou</strong>. Výsledky nemožno bez výhrad preniesť na klinicky nestabilných pacientov s najvyšším skorým rizikom — teda práve na tých, ktorí v prvých mesiacoch dialýzy umierajú najčastejšie.</p>

<h3>Obmedzená prenositeľnosť</h3>

<p>Analyzovaná populácia pochádzala výlučne zo siete jedného poskytovateľa dialyzačnej starostlivosti. Zastúpenie diabetu, používanie fistuly, krvné prietoky a ďalšie charakteristiky sa líšia od severoamerických populácií, kde je podiel katétrov vyšší a podiel diabetu väčší.</p>

<h3>Konflikt záujmov</h3>

<p>Údaje pochádzali zo siete Fresenius Medical Care a viacerí autori sú s touto organizáciou spojení; deklarované externé financovanie štúdie bolo nulové. Táto skutočnosť výsledky automaticky nespochybňuje, ale zvyšuje význam nezávislej replikácie mimo siete výrobcu.</p>

<h2>Fakt, asociácia, hypotéza a neistota</h2>

<p><strong>Preukázaný fakt:</strong> V analyzovanej kohorte bola mortalita pacientov liečených hemodiafiltráciou nižšia než mortalita pacientov liečených hemodialýzou.</p>

<p><strong>Korigovaná asociácia:</strong> Po štatistickom vyvážení bola hemodiafiltrácia spojená s o 20 % nižším rizikom celkového úmrtia a o 29 % nižším rizikom kardiovaskulárneho úmrtia; pri prísnejšej definícii expozície klesol odhad na 12 %.</p>

<p><strong>Biologická hypotéza:</strong> Priaznivé výsledky môžu súvisieť s lepším odstraňovaním stredne veľkých uremických látok a s následným ovplyvnením zápalu, endotelovej dysfunkcie a kardiovaskulárneho rizika.</p>

<p><strong>Pretrvávajúca neistota:</strong> Observačná štúdia nepreukazuje, že celý rozdiel v mortalite zapríčinila samotná hemodiafiltrácia. Časť rozdielu môže odrážať to, že vysoký konvekčný objem dokážu bezpečne dosiahnuť práve stabilnejší pacienti v lepšie vybavených centrách.</p>

<h2>Praktické dôsledky</h2>

<p>Výsledky podporujú skoré zvažovanie postdilučnej vysokoobjemovej hemodiafiltrácie u vhodných pacientov, ak pracovisko dokáže zabezpečiť:</p>

<ul>
  <li>kvalitnú upravenú vodu a ultračistý dialyzačný roztok,</li>
  <li>dostatočný krvný prietok a funkčný cievny prístup,</li>
  <li>primeraný čas dialyzačnej procedúry,</li>
  <li>bezpečné dosahovanie konvekčného objemu nad 23 litrov na procedúru,</li>
  <li>pravidelné sledovanie dialyzačnej dávky a znášanlivosti,</li>
  <li>individualizáciu podľa hemodynamiky, reziduálnej funkcie obličiek a cieľov pacienta.</li>
</ul>

<p>Výsledky <strong>nepodporujú</strong> mechanické uprednostnenie vysokého konvekčného objemu za cenu intradialyzačnej nestability, nadmernej ultrafiltrácie alebo skrátenia času liečby. Kvalitná hemodialýza zostáva vhodnou modalitou tam, kde vysokoobjemovú hemodiafiltráciu nemožno bezpečne alebo technicky zabezpečiť.</p>

<p>Praktickým odkazom pre nefrologickú ambulanciu je aj to, čo štúdia ukázala nepriamo: rozdiel v podiele fistúl medzi skupinami pripomína, že <strong>včasná príprava cievneho prístupu</strong> je predpokladom nielen dobrej dialýzy, ale aj možnosti vôbec ponúknuť vysokoobjemovú HDF.</p>

<h2>Záver</h2>

<p>Medzinárodná kohortová štúdia incidentných dialyzovaných pacientov ukázala konzistentnú asociáciu vysokoobjemovej online hemodiafiltrácie s nižšou celkovou a kardiovaskulárnou mortalitou. Odhad je blízky randomizovanému výsledku štúdie CONVINCE, čo posilňuje jeho vierohodnosť.</p>

<p>Najpresnejšia formulácia však znie, že vysokoobjemová hemodiafiltrácia <strong>bola spojená s nižšou mortalitou</strong>. Observačný dizajn nedovoľuje tvrdiť, že ju jednoznačne znížila — a rozpätie odhadov od HR 0,80 po HR 0,88 podľa použitej metódy ukazuje, kde presne leží hranica našej istoty. Potvrdenie veľkosti kauzálneho účinku osobitne u incidentných pacientov si vyžaduje randomizovanú klinickú štúdiu.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=online-hemodiafiltracia-davkovana-liecba-odporucania-sin">Online hemodiafiltrácia ako dávkovaná liečba</a> — odporúčania Talianskej nefrologickej spoločnosti.</li>
  <li><a href="article.php?slug=online-hemodiafiltracia-mco-dialyzatory-stredne-molekuly">Online HDF a MCO dialyzátory</a> — dve cesty k odstraňovaniu stredných molekúl.</li>
  <li><a href="article.php?slug=nacasovanie-cievneho-pristupu-avf-avg-pred-hemodialyzou">Načasovanie cievneho prístupu pred hemodialýzou</a> — predpoklad bezpečného vysokého konvekčného objemu.</li>
  <li><a href="article.php?slug=improvizovana-hemodialyza-kvalita-vody-dialyzacneho-roztoku">Kvalita vody a dialyzačného roztoku</a> — technická podmienka HDF.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Yan Zhang, Anke Winter, Linda H. Ficociello, Smriti Arya, Stefano Stuard, Len A. Usvyat, Kamyar Kalantar-Zadeh.</strong> <em>Hemodialysis Modality and Mortality Outcomes among Incident Dialysis Patients: An International Cohort Study Comparing High-Volume Hemodiafiltration and Hemodialysis.</em> Clinical Journal of the American Society of Nephrology. 2026;21(7):1198–1206. <a href="https://doi.org/10.2215/CJN.0000001063" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42133950/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13379127/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Giovanni F. M. Strippoli, Giovanni Tripepi, Bernard Canaud, Stefano Stuard, Franklin W. Maddux, Len A. Usvyat, Paola Carioni, Matteo Savoia, Germaine Wong, Carmine Zoccali.</strong> <em>Hemodiafiltration versus High-flux Hemodialysis and Risk of Mortality: A Multinational Target Trial Emulation.</em> Journal of the American Society of Nephrology. 2026 (online pred tlačou). <a href="https://doi.org/10.1681/ASN.0000001225" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42593876/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Peter J. Blankestijn, Robin W. M. Vernooij, Carinna Hockham, Giovanni F. M. Strippoli, Bernard Canaud a spol. (CONVINCE).</strong> <em>Effect of Hemodiafiltration or Hemodialysis on Mortality in Kidney Failure.</em> New England Journal of Medicine. 2023;389(8):700–709. <a href="https://doi.org/10.1056/NEJMoa2304820" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Francisco Maduell, Francesc Moreso, Mercedes Pons, Rosa Ramos, Josep Mora-Macià a spol. (ESHOL).</strong> <em>High-Efficiency Postdilution Online Hemodiafiltration Reduces All-Cause Mortality in Hemodialysis Patients.</em> Journal of the American Society of Nephrology. 2013;24(3):487–497. <a href="https://doi.org/10.1681/ASN.2012080875" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Fresenius Medical Care.</strong> <em>Fresenius Medical Care Announces Publication of a Multinational Real-World Evidence Study Associating High-Volume Hemodiafiltration with Lower Mortality Risk Than Conventional Hemodialysis.</em> Firemná tlačová správa, 27. augusta 2026. <a href="https://freseniusmedicalcare.com/en/media/newsroom/multinational-real-world-evidence-study-associating-high-volume-hemodiafiltration-with-lower-mortality-risk-than-conventional-hemodialysis/" target="_blank" rel="noopener noreferrer">Tlačová správa</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje pripísané incidentnej kohorte — 18 515 pacientov (10 149 hemodialýza, 8 366 hemodiafiltrácia), roky 2019 – 2022, prah 75 % procedúr, konvekčný objem 24,9 l (medián 25,1; MKR 23,1 – 27,2), medián sledovania 15,7 mesiaca (MKR 6,4 – 24,0), 11,7 oproti 15,6 a 4,1 oproti 6,7 úmrtia na 100 osoborokov, HR 0,80 (0,75–0,86), HR 0,82 (0,77–0,88), HR 0,88 (0,82–0,95), HR 0,71 (0,63–0,80), 93,4 % úmrtí so známou príčinou, vstupné rozdiely vo veku (64,5 ± 14,5 oproti 62,0 ± 15,1), fistule (28 % oproti 40 %), diabete (38 % oproti 34 %) a pohlaví (54 % oproti 58 % mužov), ako aj vyraďovacie kritériá vrátane predilučnej HDF a Kt/V pod 1,2 — boli overené proti abstraktu v zázname PubMed a plnému textu v PMC. Údaje o štúdii JASN (19 539 pacientov, vážená pseudopopulácia 19 758, osem krajín, 2014 – 2019, prah 90 %, HR 0,72 [0,67–0,77], kumulatívna incidencia 20,6 % oproti 22,3 %) pochádzajú z jej záznamu v PubMed; údaje o CONVINCE (1 360 pacientov, 25,3 l, 17,3 % oproti 21,9 %, HR 0,77 [0,65–0,93]) rovnako. Bibliografia bola overená cez Crossref a PubMed. <strong>Upozornenie na rozdiel oproti pôvodnému spracovaniu:</strong> údaj 28 % z tlačovej správy nie je alternatívnym odhadom tej istej analýzy — vzťahuje sa na inú, samostatne publikovanú prácu, ktorá bola pre potreby tohto článku dohľadaná a odcitovaná. Porovnanie oboch štúdií, prepojenie na randomizované dôkazy a metodologické komentáre sú <strong>vlastným odborným hodnotením</strong>, nie závermi pôvodných autorov.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vysokoobjemova-hdf-mortalita-incidentni-dialyzovani-pacienti_article',
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
