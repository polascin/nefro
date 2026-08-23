<?php
/**
 * add_uhlikova-stopa-hemodialyzy-meranie-znizovanie-emisii_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o meraní a znižovaní uhlíkovej stopy hemodialýzy.
 * Pôvodní autori zdrojovej štúdie sú evidovaní aj v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Uhlíková stopa hemodialýzy: meranie, praktické opatrenia a hranice znižovania emisií',
    'slug'         => 'uhlikova-stopa-hemodialyzy-meranie-znizovanie-emisii',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 21:47:26',
    'is_top'       => 0,
    'excerpt'      => 'Pilotná štúdia piatich nemeckých stredísk odhadla priemernú stopu hemodialýzy na 3,72 t CO₂e na pacienta za rok. Ukazuje, čo možno zmeniť hneď a prečo klinická bezpečnosť musí zostať nadradená úspore emisií.',
    'content'      => <<<'HTML'
<p>Hemodialýza je život zachraňujúca liečba, zároveň však spotrebúva veľké množstvo elektriny, tepla a vody, vyžaduje pravidelnú dopravu a používa množstvo jednorazových pomôcok. Znižovanie jej environmentálnej záťaže preto patrí do moderného riadenia kvality. Ekologický ukazovateľ však nesmie stáť proti bezpečnosti pacienta: zmyslom merania je odhaliť zbytočnú spotrebu a emisie, nie obmedziť účinnú liečbu.</p>

<p><strong>Uhlíková stopa</strong> vyjadruje emisie rôznych skleníkových plynov po prepočte na ekvivalent oxidu uhličitého (CO₂e). Pri dialýze ju možno uvádzať napríklad v tonách CO₂e na pacienta za rok alebo v kilogramoch CO₂e na jedno liečebné sedenie. Výsledok má význam iba vtedy, ak je jasné, ktoré zdroje emisií výpočet zahŕňa, aké emisné faktory používa a aký je menovateľ.</p>

<p>Originálna pilotná štúdia publikovaná v časopise <em>Nephrology Dialysis Transplantation</em> hodnotila webový kalkulátor Nemeckej nefrologickej spoločnosti (DGfN) a údaje z piatich nemeckých hemodialyzačných stredísk. Nešlo o randomizovanú štúdiu, kontrolovaný intervenčný projekt ani úplné posudzovanie životného cyklu (LCA). Jej najväčšou hodnotou je praktická ukážka, ako možno v jednom centre vytvoriť východiskovú inventúru, nájsť hlavné zdroje emisií a sledovať ich v čase.</p>

<h2>Klimatické ciele treba pomenovať presne</h2>

<p>Zdrojová práca spája projekt s medzinárodnou dekarbonizáciou, jednotlivé politické a vedecké rámce však nie sú totožné. <a href="https://www.ipcc.ch/report/ar6/wg3/resources/press/press-release/" target="_blank" rel="noopener noreferrer">IPCC</a> pri trajektóriách obmedzenia otepľovania na 1,5 °C uvádza približne 43-percentné zníženie globálnych emisií skleníkových plynov do roku 2030 oproti roku 2019 a globálnu čistú nulu CO₂ začiatkom 50. rokov tohto storočia. Klimatická neutralita do roku 2045 je <a href="https://www.bundesregierung.de/breg-en/service/archive/climate-change-act-2021-1936846" target="_blank" rel="noopener noreferrer">národným cieľom Nemecka</a>; Európska únia má v <a href="https://climate.ec.europa.eu/eu-action/european-climate-law_en" target="_blank" rel="noopener noreferrer">európskom právnom rámci</a> cieľ znížiť čisté emisie najmenej o 55 % do roku 2030 oproti roku 1990 a dosiahnuť klimatickú neutralitu do roku 2050. Rok 2045 teda nie je univerzálnym termínom IPCC.</p>

<h2>Ako kalkulátor a pilotné centrá pracovali</h2>

<p>Prevádzkovatelia zadávali údaje o spotrebe a činnosti strediska do webového kalkulátora. Jedno centrum poskytlo údaje za roky 2015–2017 a po časovej medzere za roky 2021–2023; ďalšie štyri centrá sa zapojili v rokoch 2021–2023. Porovnanie všetkých piatich centier v posledných troch rokoch tak tvorilo 15 centro-rokov. Nešlo o súvislé deväťročné sledovanie každej prevádzky.</p>

<p>Výpočet zahŕňal štyri hlavné skupiny:</p>

<ul>
  <li><strong>dopravu pacientov a personálu</strong> podľa vzdialenosti, spôsobu prepravy a typu pohonu;</li>
  <li><strong>spotrebný materiál a odpad</strong>, prevažne prepočítané podľa hmotnosti;</li>
  <li><strong>elektrinu, vykurovanie a vodu</strong> vrátane systému reverznej osmózy (RO) na prípravu dialyzačnej vody;</li>
  <li><strong>ostatnú prevádzku</strong>, napríklad pranie, čistenie, informačné technológie a intradialyzačné občerstvenie.</li>
</ul>

<p>Kalkulátor vychádza z princípov GHG Protocol a pracuje s priamymi aj nepriamymi emisiami, použitá systémová hranica však nebola úplná. Nezahŕňala dopravu spotrebného materiálu, výstavbu budov, výrobu dialyzačných prístrojov ani výrobu a dopravu liekov. Hmotnostné prepočty jednorazových pomôcok navyše nedokážu plne rozlíšiť materiál, sterilizáciu, miesto výroby a konkrétny spôsob likvidácie. Výsledok je preto presnejšie chápať ako <strong>prevádzkovú uhlíkovú inventúru so stanovenou hranicou</strong>, nie ako úplnú stopu celej liečby „od kolísky po hrob“.</p>

<h2>Aká bola nameraná uhlíková stopa</h2>

<p>Priemer za všetky dostupné obdobia predstavoval <strong>3,72 ± 0,44 t CO₂e na pacienta za rok</strong>. V roku 2023 sa celková hodnota jednotlivých centier pohybovala od 3,22 do 4,15 t CO₂e na pacienta za rok. Výroba spotrebného materiálu a spracovanie odpadu tvorili približne 40 % celku; významný podiel mali aj energie, vykurovanie, voda a doprava.</p>

<div class="table-responsive" role="region" aria-label="Aká bola nameraná uhlíková stopa" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">2021<br>t CO₂e/pacienta/rok</th>
      <th scope="col">2023<br>t CO₂e/pacienta/rok</th>
      <th scope="col">Relatívna zmena</th>
      <th scope="col">p</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Doprava</td>
      <td>0,77 ± 0,27</td>
      <td>0,76 ± 0,28</td>
      <td>−0,74 %</td>
      <td>0,46</td>
    </tr>
    <tr>
      <td>Spotrebný materiál a odpad</td>
      <td>1,45 ± 0,13</td>
      <td>1,40 ± 0,11</td>
      <td>−3,31 %</td>
      <td>0,36</td>
    </tr>
    <tr>
      <td>Elektrina, vykurovanie a voda</td>
      <td>1,48 ± 0,56</td>
      <td>1,17 ± 0,44</td>
      <td>−20,5 %</td>
      <td>0,01</td>
    </tr>
    <tr>
      <td>Ostatná prevádzka</td>
      <td>0,22</td>
      <td>0,22</td>
      <td>−1,36 %</td>
      <td>0,49</td>
    </tr>
    <tr>
      <td><strong>Celkom</strong></td>
      <td><strong>3,91 ± 0,60</strong></td>
      <td><strong>3,56 ± 0,35</strong></td>
      <td><strong>−9,10 ± 5,01 %</strong></td>
      <td><strong>0,04</strong></td>
    </tr>
  </tbody>
</table>
</div>

<p>Pokles celkovej stopy medzi rokmi 2021 a 2023 bol teda 0,356 ± 0,257 t CO₂e na pacienta za rok. Rozdiel sa koncentroval najmä v kategórii energie, vykurovania a vody. Keďže neexistovali kontrolné centrá a súčasne sa mohli meniť počasie, energetický mix, stavebná prevádzka, počet výkonov či obsadenosť, <strong>9,1-percentný pokles nemožno kauzálne pripísať jednej intervencii ani jednoduchému súčtu opatrení</strong>. Presné je povedať, že pokles bol časovo spojený s prevádzkovými zmenami.</p>

<p>Autori porovnali dialyzačnú stopu s nemeckými emisiami na obyvateľa a uviedli približne 40-percentný prírastok. Ide iba o ilustráciu rádu veľkosti. Národný údaj a inventúra dialyzačného centra majú odlišné systémové hranice a pri jednoduchom sčítaní môže dôjsť k dvojitému započítaniu časti zdravotníctva.</p>

<h2>Prietok dialyzátu: úspora vody, nie univerzálny predpis</h2>

<p>V pilotných centrách znížili prednastavený <strong>prietok dialyzátu (Qd)</strong> z 500 na 350 mL/min u 50–80 % individuálne vybraných pacientov. Lekár zohľadňoval požadovanú dialyzačnú dávku, prietok krvi, reziduálnu funkciu obličiek, telesnú veľkosť a klinický stav. Priemerná spotreba vody v systéme RO klesla o 14 %. Kombinovaná uhlíková stopa elektriny a vody sa znížila z 1,02 ± 0,31 na 0,86 ± 0,26 t CO₂e na pacienta za rok, tento rozdiel však nedosiahol štatistickú významnosť (p = 0,07).</p>

<p>Krátke laboratórne porovnanie pochádzalo iba z jedného centra a zahŕňalo štyri týždne pred zmenou a štyri týždne po nej. Fosfát sa zmenil z 1,80 na 1,77 mmol/L, draslík z 5,29 na 5,70 mmol/L a bikarbonát z 20,3 na 19,9 mmol/L; rozdiely neboli štatisticky významné. Malá nekontrolovaná analýza však neposkytla komplexné údaje o spKt/V alebo eKt/V, URR, odstraňovaní stredných molekúl, hospitalizáciách ani dlhodobej bezpečnosti. Neštatisticky významný numerický vzostup draslíka navyše nemožno zamieňať za dôkaz neprítomnosti rizika.</p>

<p>Zníženie Qd na 350 mL/min preto možno <strong>zvážiť u individuálne vybraných pacientov</strong>, ak sa zachová predpísaná dialyzačná dávka. Po zmene treba overiť dodanú dávku a metabolickú bezpečnosť – primeranosť podľa spKt/V alebo eKt/V a URR, koncentrácie draslíka, fosfátu a bikarbonátu, objemový stav, krvný tlak, symptómy a toleranciu. Rozhodnutie musí zohľadniť Qb, vlastnosti dialyzátora, dĺžku a frekvenciu liečby, telesnú veľkosť, reziduálnu funkciu obličiek a prípadnú hemodiafiltráciu. Qd sa nemá znižovať automaticky ani výlučne z environmentálnych dôvodov.</p>

<h2>Fotovoltika, občerstvenie a doprava: čo sa naozaj hodnotilo</h2>

<h3>Fotovoltika</h3>

<p>V jednom centre nainštalovali v marci 2016 fotovoltický systém s výkonom 88 kWp a koncom roka 2023 ho rozšírili na 112 kWp. Odhad uhlíkovej stopy elektriny klesol z 0,84 t CO₂e na pacienta v roku 2015 na približne 0,63 t v ďalších hodnotených obdobiach, teda o 22 ± 3,57 %. Toto číslo sa týka <strong>elektrickej zložky jedného centra</strong>, nie celej uhlíkovej stopy všetkých prevádzok. Porovnanie bolo časové a bez kontroly; výsledok závisí od lokálneho elektrického mixu, orientácie a plochy strechy, počasia, profilu spotreby aj spôsobu započítania životného cyklu panelov.</p>

<p>Autori odhadli, že približne 400 m² strechy a výkon okolo 100 kW by za slnečného dňa mohli pokrývať dennú spotrebu 30–40 dialyzačných miest, najmä od apríla do októbra. Ide o technický potenciál, ktorý treba v každom centre prepočítať, nie o univerzálne dosiahnutú energetickú sebestačnosť.</p>

<h3>Intradialyzačné občerstvenie</h3>

<p>Jedno centrum nahradilo pečivo s údeninou alebo syrom ovocím, zeleninou a tvarohom. Pomocou emisných faktorov potravín autori <strong>modelovali</strong> pokles stopy kategórie stravovania z 0,19 na 0,09 t CO₂e na pacienta za rok, teda o 53 %. Na úrovni celého centra to zodpovedalo približne 2,6–3 %. Štúdia netestovala kompletnú „Planetary Health Diet“ a nehodnotila kardiovaskulárne, metabolické ani nutričné výsledky.</p>

<p>Občerstvenie s nižšou uhlíkovou stopou má byť individualizované. U dialyzovaných pacientov treba chrániť príjem energie a bielkovín a sledovať proteínovo-energetické chradnutie, draslík, fosfor, sodík, diabetes a tráviacu toleranciu. Univerzálna náhrada občerstvenia ovocím nemusí byť vhodná pri hyperkaliémii; rozhodnutie má podporiť renálny nutričný terapeut.</p>

<h3>Doprava</h3>

<p>V jednom centre bola skupinová preprava dvoch až troch pacientov pred pandémiou spojená s odhadom 0,61 ± 0,01 t CO₂e na pacienta za rok oproti 0,64 ± 0,01 t pri prevažne individuálnej preprave počas pandémie (p = 0,03). Rozdiel je malý a obdobia sa líšili aj okolnosťami pandémie. Optimalizácia trás, bezpečná skupinová preprava a nízkoemisné vozidlá môžu pomôcť, nesmú však zhoršiť dostupnosť, čas cesty, pohodlie ani infekčnú bezpečnosť krehkých pacientov.</p>

<h2>Model zníženia o 38,7 %: hypotéza, nie nameraný výsledok</h2>

<p>Autori zostavili „najlepší možný“ scenár z čiastkových pozorovaní, výsledku najlepšieho centra, literatúry a modelových predpokladov. Zo základnej hodnoty 3,86 t CO₂e na pacienta za rok odhadli pokles na 2,38 t, teda o 1,47 t alebo 38,7 %.</p>

<div class="table-responsive" role="region" aria-label="Model zníženia o 38,7 %: hypotéza, nie nameraný výsledok" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Modelované opatrenie</th>
      <th scope="col">Odhad úspory<br>t CO₂e/pacienta/rok</th>
      <th scope="col">Podiel zo základu</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Elektrifikácia dopravy pacientov</td><td>0,20</td><td>5,2 %</td></tr>
    <tr><td>50 % nízkoemisnej dopravy personálu</td><td>0,07</td><td>1,8 %</td></tr>
    <tr><td>Úprava teploty dialyzátu</td><td>0,011</td><td>0,28 %</td></tr>
    <tr><td>Fotovoltika</td><td>0,21</td><td>5,4 %</td></tr>
    <tr><td>Individualizácia Qd</td><td>0,16</td><td>4,2 %</td></tr>
    <tr><td>Občerstvenie s nižšou stopou</td><td>0,10</td><td>2,6 %</td></tr>
    <tr><td>Modelovaný 40 % podiel APD</td><td>0,66</td><td>17,1 %</td></tr>
    <tr><td>Modelovaná inkrementálna HD</td><td>0,062</td><td>1,6 %</td></tr>
  </tbody>
</table>
</div>

<p>Scenár nie je predpoveďou ani dôkazom, že každé centrum môže dosiahnuť rovnaký výsledok. Pri jednoduchom sčítaní sa môžu úspory prekrývať: po prechode časti pacientov na domácu modalitu sa na nich už neuplatní úspora dopravy, Qd ani prevádzky strediskovej HD a fixná spotreba budovy neklesá lineárne, kým sa skutočne nezníži kapacita alebo počet zmien.</p>

<h2>Peritoneálna a inkrementálna dialýza: klinická vhodnosť je rozhodujúca</h2>

<p>Model predpokladal prechod 40 % pacientov na automatizovanú peritoneálnu dialýzu (APD) a porovnal nemeckú hodnotu pre strediskovú HD s údajom 2,2 t CO₂e pre APD prevzatým z iného systému. Pilotné centrá vlastné údaje o domácej dialýze nezbierali. Porovnávacie LCA ukazujú, že domáce modality môžu mať v mnohých podmienkach nižšiu stopu, najmä pre menšiu dopravu, výsledok však závisí od elektrického mixu, cykléra, množstva vakov, plastov, logistiky roztokov, odpadu, asistencie a lokálnych hraníc výpočtu. APD môže mať vyššiu stopu než kontinuálna ambulantná peritoneálna dialýza a v niektorých systémoch aj než domáca HD.</p>

<p>Voľba modality má zostať spoločným rozhodnutím založeným na medicínskej vhodnosti, preferenciách pacienta, očakávanej kvalite života, domácom a sociálnom zázemí, schopnosti vykonávať liečbu a potrebe asistencie. Environmentálny profil je doplnkovým, nie rozhodujúcim kritériom. Praktickým a pacientsky orientovaným aspektom tejto témy sa venuje aj článok <a href="https://nefro.polascin.net/article.php?slug=udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia">Udržateľná peritoneálna dialýza</a>.</p>

<p>Pri inkrementálnej HD model predpokladal liečbu dvakrát týždenne u 50 % incidentných pacientov počas prvých šiestich mesiacov a u 10 % pacientov počas dvoch rokov. Nešlo o klinicky overený podiel vhodných pacientov a vypočítaná úspora predstavovala iba 1,6 % celku. Režim dvakrát týždenne možno zvažovať len pri dostatočnej reziduálnej funkcii a diuréze, stabilnom objemovom stave, kontrolovanom draslíku, fosfáte a acidobázickej rovnováhe, primeranej výžive a spoľahlivom sledovaní. Vyžaduje pravidelné meranie reziduálnej funkcie, posúdenie celkovej dialyzačnej dávky a včasné zvýšenie frekvencie. Nemá sa zavádzať ako environmentálny štandard, pretože nevhodný výber môže viesť k hyperkaliémii, preťaženiu objemom a nedostatočnej dialýze.</p>

<h2>Čo môže dialyzačné stredisko urobiť prakticky</h2>

<ol>
  <li><strong>Určiť hranicu a východiskový rok.</strong> Vopred stanoviť, či sa hodnotí scope 1, 2 a ktoré položky scope 3, aké emisné faktory a ich verzia sa použijú a či sa výsledok uvádza na výkon, pacienta alebo pacientorok.</li>
  <li><strong>Zbierať údaje aspoň 12 mesiacov.</strong> Zaznamenať elektrinu v kWh, palivo alebo teplo, vstupnú vodu a vodu pre RO, počet pacientov a výkonov, modality, dopravu podľa kilometrov a spôsobu prepravy, materiály a jednotlivé prúdy odpadu, pranie, čistenie, stravovanie a IT.</li>
  <li><strong>Nájsť lokálne „horúce miesta“.</strong> Výsledok jedného nemeckého centra nemožno preniesť na Slovensko bez prepočtu; rozhodujú lokálny energetický mix, budova, dodávatelia, doprava a pravidlá odpadového hospodárstva.</li>
  <li><strong>Začať opatreniami bez ohrozenia liečby.</strong> Patria sem samostatné meranie spotreby, regulácia kúrenia a chladenia, údržba RO a kontrola únikov, energeticky účinné zariadenia, obnoviteľná elektrina, optimalizácia trás, správne triedenie odpadu a obstarávanie podľa overených údajov o životnom cykle.</li>
  <li><strong>Vodu z RO využívať iba bezpečne.</strong> Možné využitie odpadového prúdu na technické účely musí rešpektovať hygienické, infekčné, stavebné a miestne právne požiadavky; nemožno ho zamieňať s vodou určenou na dialýzu.</li>
  <li><strong>Klinické zmeny riadiť ako zmenu kvality.</strong> Každá úprava Qd, teploty, dĺžky alebo frekvencie liečby potrebuje schválený protokol, informovanie pacienta a vyvažovacie ukazovatele: dodanú dávku, elektrolyty, symptómy, krvný tlak a objem, výživu, infekcie, hospitalizácie a skúsenosť pacienta.</li>
  <li><strong>Premerať výsledok a zverejniť neistotu.</strong> Porovnávať iba obdobia s rovnakou hranicou a faktormi, vysvetliť zmeny objemu výkonov či budovy a zabrániť dvojitému započítaniu úspor.</li>
</ol>

<h2>Dodávateľský reťazec, odpad a prevencia</h2>

<p>Veľká časť emisií zdravotníctva vzniká mimo samotného zariadenia. <a href="https://www.who.int/publications/b/81844" target="_blank" rel="noopener noreferrer">WHO</a> uvádza pre dodávateľské reťazce zdravotníctva rádovo 60–80 % emisií, nejde však o výsledok týchto piatich dialyzačných centier. Od výrobcov a dodávateľov má zmysel požadovať produktové LCA alebo environmentálne vyhlásenia, údaje o výrobe a logistike, menej obalov, spätný odber a nižšiu materiálovú náročnosť. Centrálna príprava koncentrátov môže obmedziť dopravu vody a ťažkých kanistrov, nie ju úplne odstrániť.</p>

<p>Nie všetok dialyzačný odpad je infekčný alebo nebezpečný a nie každý sa likviduje spaľovaním. Správne triedenie znižuje množstvo klinického odpadu, ale recyklácia alebo opakovane použiteľné riešenia musia rešpektovať infekčnú bezpečnosť, sledovateľnosť a miestne predpisy. Označenie „biologicky odbúrateľný“ samo osebe nezaručuje nižší celoživotný vplyv.</p>

<p>Včasná diagnostika a účinné spomalenie progresie chronickej choroby obličiek a preemptívna transplantácia u vhodných pacientov môžu spolu s klinickým prínosom znížiť aj dlhodobú environmentálnu záťaž. Z pôvodnej práce však nemožno odvodiť, že transplantácia je univerzálne „najzelenším“ riešením: časť argumentu vychádzala z extrapolácie iných transplantačných výkonov a výsledok závisí od krajiny a hraníc LCA. Indikácia transplantácie zostáva medicínska a pacientsky orientovaná. Dialýza ani iná život zachraňujúca liečba nesmie byť odkladaná alebo obmedzovaná pre uhlíkovú stopu.</p>

<h2>Záver</h2>

<p>Pilotné údaje z piatich nemeckých centier ukazujú, že systematické meranie dokáže odhaliť hlavné zdroje emisií strediskovej hemodialýzy a podporiť ich postupné znižovanie. Celková stopa dosahovala v priemere 3,72 t CO₂e na pacienta za rok a medzi rokmi 2021 a 2023 klesla o 9,1 %, prevažne v kategórii energie, vykurovania a vody. Nekontrolovaný dizajn však nedovoľuje tento pokles jednoznačne pripísať jednotlivým opatreniam.</p>

<p>Najbezpečnejšou stratégiou je kombinovať kvalitnú lokálnu inventúru s prevádzkovými opatreniami bez negatívneho vplyvu na liečbu, dekarbonizáciou energie a dopravy, zodpovedným obstarávaním a spoluprácou s priemyslom. Individualizácia Qd, domáce modality a inkrementálna HD môžu u vhodne vybraných pacientov prispieť k úspore zdrojov, ale vyžadujú rovnakú klinickú obozretnosť ako každý iný zásah do dialyzačného predpisu. Bezpečnosť pacienta, účinnosť liečby, kvalita života a rovný prístup zostávajú nadradené environmentálnym ukazovateľom.</p>

<hr>

<p><em><strong>Zdroj – originálna štúdia:</strong> Beige J, Knöller S, Pachmann M, Sommer F, Barth HP, Masanneck M, Kleophas W, Schaffron R, Stracke S, deGroot K, Weinmann-Menke J, Boedecker-Lips SC, Vanholder R. A website calculator to benchmark the carbon footprint of haemodialysis. <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1294–1303. Publikované online 20. januára 2026. <a href="https://academic.oup.com/ndt/article/41/7/1294/8431415" target="_blank" rel="noopener noreferrer">Oxford Academic – plný otvorený text</a>. doi: <a href="https://doi.org/10.1093/ndt/gfaf263" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfaf263</a>. PMID 41556564: <a href="https://pubmed.ncbi.nlm.nih.gov/41556564/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://europepmc.org/article/MED/41556564" target="_blank" rel="noopener noreferrer">Europe PMC</a>. <a href="https://academic.oup.com/ndt/article-pdf/41/7/1294/66473913/gfaf263.pdf" target="_blank" rel="noopener noreferrer">Oxford Academic – PDF</a>. <a href="https://greentecdialysis.com/de/co2-rechner/" target="_blank" rel="noopener noreferrer">Webový kalkulátor</a>.</em></p>

<p><em><strong>Všetci autori zdrojovej štúdie:</strong> Joachim Beige; Susi Knöller; Martin Pachmann; Falk Sommer; Hans Peter Barth; Michael Masanneck; Werner Kleophas; Roman Schaffron; Sylvia Stracke; Kirsten deGroot; Julia Weinmann-Menke; Simone Cosima Boedecker-Lips; Raymond Vanholder.</em></p>

<p><em><strong>Financovanie zdroja:</strong> Vývoj kalkulátora podporili DGfN, Kuratorium für Dialyse und Nierentransplantation, DaVita, B. Braun, Diaverum a PHV Dialysepartner. Autori uviedli aj podporu projektu KitNewCare z programu Horizon Europe (HORIZON-HLTH-2023-CARE-04-03, grant 101137054).</em></p>

<p><em><strong>Konflikty záujmov zdroja:</strong> Falk Sommer je zakladateľom a Hans Peter Barth zamestnancom spoločnosti Greentec Dialysis, ktorá kalkulátor vyvinula. Raymond Vanholder uviedol poradenské vzťahy so spoločnosťami AstraZeneca, GSK, Fresenius Kabi, Novartis, Baxter, Nipro, Fresenius Medical Care a Nextkidney. Joachim Beige, Werner Kleophas, Susi Knöller, Sylvia Stracke, Simone Cosima Boedecker-Lips a Julia Weinmann-Menke uviedli honoráre od rôznych farmaceutických alebo dialyzačných spoločností. Viacerí autori pôsobia v pracovnej skupine DGfN pre klímu a životné prostredie.</em></p>

<p><em><strong>Vybrané doplňujúce zdroje použité pri vecnej kontrole:</strong> <a href="https://ghgprotocol.org/sites/default/files/2022-12/Intro_GHGP_Tech.pdf" target="_blank" rel="noopener noreferrer">GHG Protocol – vymedzenie scope 1–3</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11229034/" target="_blank" rel="noopener noreferrer">systematický prehľad prietoku dialyzátu a primeranosti HD</a>, doi: <a href="https://doi.org/10.1093/ckj/sfae163" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfae163</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38671537/" target="_blank" rel="noopener noreferrer">austrálske porovnanie environmentálnej záťaže peritoneálnej dialýzy</a>, doi: <a href="https://doi.org/10.1681/ASN.0000000000000361" target="_blank" rel="noopener noreferrer">10.1681/ASN.0000000000000361</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40602678/" target="_blank" rel="noopener noreferrer">porovnávacie LCA dialyzačných modalít</a>, doi: <a href="https://doi.org/10.1053/j.ajkd.2025.04.019" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2025.04.019</a>; <a href="https://guidelines.ukkidney.org/haemodialysis/" target="_blank" rel="noopener noreferrer">UK Kidney Association – hemodialýza vrátane inkrementálneho režimu</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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

        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
