<?php
/**
 * Odborný článok: Dialyzačná modalita a prežívanie u pacientov vo veku 80 rokov a viac.
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
    'title'        => 'Dialyzačná modalita a prežívanie u pacientov vo veku 80 rokov a viac: rozhoduje skôr priebeh liečby než jej úvodná voľba',
    'slug'         => 'dialyzacna-modalita-prezivanie-oktogenari-pd-hd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V katalánskom registri 4205 pacientov vo veku 80 rokov a viac sa päťročné prežívanie podľa úvodnej modality nelíšilo. Prechod z peritoneálnej dialýzy na hemodialýzu bol spojený s vyššou mortalitou, najskôr ako marker zhoršenia stavu.',
    'content'      => <<<'HTML'
<p>Pacienti vo veku 80 rokov a viac tvoria rýchlo rastúcu časť dialyzovanej populácie, porovnávacích údajov o prežívaní podľa dialyzačnej modality je však v tejto vekovej skupine málo. Populačná kohortová štúdia z Katalánskeho obličkového registra (<em>Registre de Malalts Renals de Catalunya</em>, RMRC), publikovaná v <em>Clinical Kidney Journal</em>, sa preto zamerala práve na nich.</p>

<p>Hlavný výsledok je dvojaký. Po štatistickej úprave <strong>sa päťročné prežívanie nelíšilo</strong> podľa toho, či pacient začal hemodialýzou (HD) alebo peritoneálnou dialýzou (PD). Prechod z peritoneálnej dialýzy na hemodialýzu však bol nezávisle spojený s vyššou mortalitou: pomer hazardu 1,46 (95 % interval spoľahlivosti 1,02 – 2,08; P = 0,038).</p>

<p>Autori samotný prechod nepovažujú za priamu príčinu. Najpravdepodobnejšie ide o marker klinického zhoršenia, technického zlyhania metódy alebo straty vhodnosti pre peritoneálnu dialýzu. Súčasne však výslovne uvádzajú, že vlastný proces prechodu — hospitalizácia, zavedenie cievneho prístupu, hemodynamická záťaž, zápalová reakcia a nestabilita u krehkého pacienta — môže k horšiemu výsledku prispieť. Rozlíšiť, či je prechod iba znakom zraniteľnosti, sprostredkovateľom rizika, alebo obojím, observačná štúdia neumožňuje.</p>

<h2>Voľba modality u veľmi starých pacientov</h2>

<p>Voľba medzi hemodialýzou a peritoneálnou dialýzou sa nemá zakladať na veku. Rozhodujúce sú funkčný stav a krehkosť, kognitívne schopnosti, komorbidity, mobilita a sebestačnosť, stav cievneho riečiska, reziduálna funkcia obličiek, podpora rodiny alebo opatrovateľov, bytové a hygienické podmienky, dostupnosť domácej zdravotnej starostlivosti, preferencie pacienta a očakávaná kvalita života.</p>

<p>Peritoneálna dialýza môže u vhodných pacientov umožniť domácu liečbu, lepšie zachovanie hemodynamickej stability a reziduálnej diurézy, menšiu závislosť od pravidelnej dopravy do strediska a väčšiu samostatnosť. Vyžaduje však schopnosť liečbu vykonávať, alebo spoľahlivú pomoc inej osoby; asistovaná peritoneálna dialýza je v niektorých systémoch práve pre túto skupinu zavedenou možnosťou.</p>

<p>Hemodialýza poskytuje liečbu pod pravidelným dohľadom personálu, prináša však cestovanie, časovú záťaž, opakované hemodynamické zmeny a potrebu cievneho prístupu. U krehkých pacientov býva problémom intradialyzačná hypotenzia, postdialyzačná únava a dlhé zotavovanie po procedúre.</p>

<h2>Usporiadanie štúdie</h2>

<p>Retrospektívna observačná kohortová štúdia vychádzala z Katalánskeho obličkového registra a zahrnula všetkých pacientov vo veku 80 rokov a viac, ktorí začali dialýzu od 1. januára 2000 do 31. decembra 2022.</p>

<p>V Katalánsku začalo v tomto období dialýzu celkovo 24 652 pacientov; 4256 z nich (17,2 %) bolo vo veku 80 rokov a viac. Vylúčení boli pacienti, ktorí už dostávali náhradu funkcie obličiek mimo Katalánska, u ktorých došlo k skorému obnoveniu funkcie obličiek, a tí, ktorí prešli z hemodialýzy na peritoneálnu dialýzu počas prvých 90 dní (n = 9). Posledné kritérium je metodologicky odôvodnené: takéto prípady spravidla zodpovedajú urgentne začatej hemodialýze s plánovaným prechodom na peritoneálnu dialýzu po stabilizácii, nie skutočnej zmene modality.</p>

<p>Konečná kohorta zahrnula <strong>4205 pacientov</strong>:</p>

<ul>
  <li>3966 (94,3 %) začalo a zostalo na hemodialýze,</li>
  <li>176 (4,2 %) bolo liečených výlučne peritoneálnou dialýzou,</li>
  <li>63 (1,5 %) začalo peritoneálnou dialýzou a neskôr prešlo na hemodialýzu.</li>
</ul>

<p>Priemerný vek bol 83,2 roka (smerodajná odchýlka 2,7) v skupine s hemodialýzou a 83,1 roka (2,6) v skupine s peritoneálnou dialýzou. Ženy tvorili 38,7 %, respektíve 32,6 %. Medián sledovania bol v oboch skupinách tri roky (medzikvartilové rozpätie 1 – 6).</p>

<p>Primárnym výsledkom bolo celkové prežívanie od začatia dialýzy do úmrtia alebo konca sledovania. Transplantácia obličky sa hodnotila ako cenzorujúca udalosť.</p>

<h3>Kľúčový metodologický prvok: prechod ako časovo závislá premenná</h3>

<p>Toto je najdôležitejšia metodologická vlastnosť práce a odlišuje ju od väčšiny starších porovnaní. Prechod z peritoneálnej dialýzy na hemodialýzu <strong>nebol</strong> riešený ako tretia vstupná skupina ani ako konkurenčná udalosť, ale bol modelovaný ako <strong>časovo závislá premenná</strong> v Coxovom modeli. Pacient tak prispieval osobočasom do stavu „peritoneálna dialýza“ až do dňa prechodu a od toho dňa do stavu „hemodialýza“.</p>

<p>Práve tento postup bráni skresleniu takzvaným nesmrteľným časom (<em>immortal time bias</em>). Ak by sa pacienti, ktorí niekedy prešli na hemodialýzu, jednoducho porovnali s tými, ktorí neprešli, čas pred prechodom by sa nesprávne priradil hemodialýze — a keďže pacient musel dovtedy prežiť, výsledok by bol systematicky skreslený v jej prospech.</p>

<p>Na zníženie vstupných rozdielov medzi skupinami sa použilo <strong>párovanie podľa propenzitného skóre v pomere 1 : 3</strong>, do ktorého vstupovali vek, pohlavie, komorbidity, funkčný stav, obdobie začatia dialýzy, zdravotný región bydliska a sociálne premenné. Vyvážiť sa podarilo dobre (štandardizované rozdiely priemerov pod 0,1). Do párovanej analýzy vstúpilo <strong>637 pacientov na hemodialýze a 213 na peritoneálnej dialýze</strong>. Viacrozmerný model bol následne upravený o vek, pohlavie, obdobie začatia dialýzy, spôsob prezentácie zlyhania obličiek, funkčný stav, diabetes a kardiovaskulárnu komorbiditu.</p>

<p>Z párovania boli pre chýbajúce hodnoty vylúčení 525 pacienti na hemodialýze (13,2 %) a 25 na peritoneálnej dialýze (10,5 %). Porovnanie prežívania pacientov s chýbajúcimi údajmi a bez nich nepreukázalo významné rozdiely, preto autori zvolili analýzu úplných prípadov bez viacnásobnej imputácie.</p>

<h2>Prečo sa výsledok mení podľa použitej metódy</h2>

<p>Táto štúdia je názornou ukážkou toho, ako zvolená analýza mení záver:</p>

<div class="table-responsive" role="region" aria-label="Porovnanie výsledkov podľa použitej analytickej metódy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Analýza</th>
      <th scope="col">Súbor</th>
      <th scope="col">Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Kaplanova a Meierova krivka podľa úvodnej modality</th>
      <td>Nepárovaná kohorta</td>
      <td>Bez rozdielu (log-rank P = 0,999)</td>
    </tr>
    <tr>
      <th scope="row">Kaplanova a Meierova krivka podľa úvodnej modality</th>
      <td>Párovaná kohorta</td>
      <td>Zdanlivo horšie prežívanie pri peritoneálnej dialýze (log-rank P = 0,008)</td>
    </tr>
    <tr>
      <th scope="row">Kaplanova a Meierova krivka podľa skutočnej trajektórie (HD, PD, PD → HD)</th>
      <td>Párovaná kohorta</td>
      <td>Bez významného rozdielu po piatich rokoch (log-rank P = 0,092)</td>
    </tr>
    <tr>
      <th scope="row">Coxov model s prechodom ako časovo závislou premennou</th>
      <td>Párovaná kohorta</td>
      <td>Peritoneálna dialýza bez prechodu nie je významne spojená s mortalitou; prechod na hemodialýzu áno</td>
    </tr>
  </tbody>
</table>
</div>

<p>Zdanlivo horšie prežívanie pri peritoneálnej dialýze v párovanej kohorte teda <strong>zmizlo</strong>, keď sa do modelu správne zahrnula zmena modality v čase. Autori z toho vyvodzujú, že rozdiely medzi modalitami pozorované v starších prácach mohli byť do značnej miery dôsledkom vstupného výberu pacientov a analytických postupov, ktoré zmenu liečby v priebehu sledovania nezohľadňovali.</p>

<h2>Výsledky viacrozmerného modelu</h2>

<div class="table-responsive" role="region" aria-label="Coxov model päťročného rizika úmrtia v párovanej kohorte" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Premenná</th>
      <th scope="col">Pomer hazardu</th>
      <th scope="col">95 % interval spoľahlivosti</th>
      <th scope="col">Hodnota P</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Prechod z PD na HD</th>
      <td>1,46</td>
      <td>1,02 – 2,08</td>
      <td>0,038</td>
    </tr>
    <tr>
      <th scope="row">PD bez prechodu (verzus HD)</th>
      <td>1,19</td>
      <td>0,95 – 1,48</td>
      <td>0,120</td>
    </tr>
    <tr>
      <th scope="row">Začatie liečby v období 2000 – 2007</th>
      <td>1,37</td>
      <td>1,08 – 1,73</td>
      <td>0,007</td>
    </tr>
    <tr>
      <th scope="row">Začatie liečby v období 2008 – 2015</th>
      <td>1,14</td>
      <td>0,93 – 1,39</td>
      <td>0,180</td>
    </tr>
    <tr>
      <th scope="row">Muž (verzus žena)</th>
      <td>1,16</td>
      <td>0,96 – 1,40</td>
      <td>0,117</td>
    </tr>
    <tr>
      <th scope="row">Vek (na každý rok)</th>
      <td>1,06</td>
      <td>1,03 – 1,10</td>
      <td>&lt; 0,001</td>
    </tr>
  </tbody>
</table>
<p><small>Referenčnou kategóriou pre modalitu je hemodialýza, pre obdobie roky 2016 – 2022.</small></p>
</div>

<p>Dolná hranica intervalu spoľahlivosti pre prechod z peritoneálnej dialýzy na hemodialýzu je 1,02. Výsledok je teda štatisticky významný len tesne a bodový odhad 1,46 treba brať ako stred pomerne širokého rozpätia, nie ako presné číslo.</p>

<p>Vyšší vek pri začatí náhrady funkcie obličiek bol spojený s vyššou mortalitou (pomer hazardu 1,06 na každý ďalší rok). Tento údaj nemožno jednoducho previesť na individuálnu prognózu — ide o výstup štatistického modelu, ktorý predpokladá rovnaký relatívny účinok naprieč celým vekovým rozsahom.</p>

<p>Pacienti, ktorí začali liečbu v rokoch 2000 až 2007, mali vyššie riziko úmrtia než tí liečení v rokoch 2016 až 2022. Môže ísť o dôsledok zlepšenia dialyzačnej starostlivosti, lepšej kontroly komorbidít a všeobecného vývoja medicíny, ale aj o zmenu vo výbere pacientov, v registrácii údajov a v organizácii zdravotnej starostlivosti.</p>

<h2>Kto a prečo prechádzal na hemodialýzu</h2>

<p>Zo 63 pacientov, ktorí prešli z peritoneálnej dialýzy na hemodialýzu, bol medián času stráveného na peritoneálnej dialýze <strong>461 dní</strong> (medzikvartilové rozpätie 144 – 944). Načasovanie prechodu teda bolo veľmi premenlivé.</p>

<p>U 56 pacientov bol známy dôvod prechodu:</p>

<div class="table-responsive" role="region" aria-label="Dôvody prechodu z peritoneálnej dialýzy na hemodialýzu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Dôvod prechodu</th>
      <th scope="col">Počet</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Strata funkcie peritoneálnej membrány</th>
      <td>17</td>
      <td>30,4 %</td>
    </tr>
    <tr>
      <th scope="row">Závažné interkurentné ochorenie alebo veľká komplikácia</th>
      <td>17</td>
      <td>30,4 %</td>
    </tr>
    <tr>
      <th scope="row">Peritoneálna infekcia (peritonitída, infekcia tunela)</th>
      <td>13</td>
      <td>23,2 %</td>
    </tr>
    <tr>
      <th scope="row">Preferencia pacienta</th>
      <td>9</td>
      <td>16,1 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Táto skladba dôvodov podporuje interpretáciu autorov. Strata funkcie membrány, akútne interkurentné ochorenie aj infekcia sú uznávanými prejavmi klinickej nestability u starších pacientov na peritoneálnej dialýze. Prechod je teda spravidla <em>dôsledkom</em> vyvíjajúcej sa zraniteľnosti, nie predvídateľnou udalosťou danou už pri začatí dialýzy.</p>

<p>Ide o učebnicový príklad skreslenia indikáciou: dôvod na zmenu liečby je sám osebe spojený s horšou prognózou.</p>

<h2>Ako robustný je výsledok</h2>

<p>Autori doplnili analýzu citlivosti metódou E-hodnoty. Tá udáva, akú silnú väzbu by musel mať nezmeraný zmätočný faktor súčasne s expozíciou aj s výsledkom, aby pozorovanú asociáciu úplne vysvetlil.</p>

<ul>
  <li>Pre porovnanie peritoneálnej dialýzy bez prechodu s výlučnou hemodialýzou by bol potrebný faktor s relatívnym rizikom najmenej <strong>1,72</strong>.</li>
  <li>Pre porovnanie prechodu z peritoneálnej dialýzy na hemodialýzu s výlučnou hemodialýzou najmenej <strong>2,02</strong>.</li>
</ul>

<p>Ide o pomerne vysoké hodnoty, čo robustnosť zistení podporuje. E-hodnotu však treba interpretovať opatrne: uvažuje o jedinom hypotetickom nezmeranom faktore a nezohľadňuje súhrnný účinok viacerých vzájomne prepojených premenných. Práve v geriatrickej dialyzačnej populácii môžu krehkosť, kognitívne poruchy, nutričný stav, dostupnosť opatrovateľa a funkčná závislosť pôsobiť súčasne na voľbu modality aj na riziko úmrtia.</p>

<h2>Obmedzenia štúdie</h2>

<h3>Observačný dizajn a nezachytené premenné</h3>

<p>Pacienti neboli randomizovaní ani k úvodnej modalite, ani k prechodu. Register nezachytáva krehkosť, kognitívny a nutričný stav ani primeranosť domácej podpory — teda práve tie faktory, ktoré môžu ovplyvniť voľbu modality aj výsledok. Reziduálne skreslenie preto nemožno vylúčiť.</p>

<h3>Malý počet pacientov po prechode</h3>

<p>Prechod absolvovalo iba 63 pacientov z celej kohorty (57 v párovanej podskupine). Presnosť odhadu v tejto podskupine je preto obmedzená, čo sa odráža v širokom intervale spoľahlivosti.</p>

<h3>Neanalyzované trvanie peritoneálnej dialýzy pred prechodom</h3>

<p>Autori výslovne uvádzajú, že dĺžku liečby peritoneálnou dialýzou pred prechodom explicitne nemodelovali, hoci môže výsledok ovplyvniť. Prechod po štyroch mesiacoch a prechod po troch rokoch nemusia mať rovnaký význam.</p>

<h3>Cenzorovanie a nezohľadnené konkurenčné udalosti</h3>

<p>Transplantácia obličky bola cenzorujúcou udalosťou. V tejto vekovej skupine bol počet transplantácií očakávane nízky (na čakacej listine bolo definitívne vylúčených približne 84 % pacientov). Iné klinicky významné konkurenčné udalosti — ukončenie dialýzy alebo prechod na konzervatívny postup — sa však explicitne nemodelovali, čo môže odhady prežívania ovplyvniť.</p>

<h3>Vylúčenie skorých prechodov z hemodialýzy na peritoneálnu dialýzu</h3>

<p>Vylúčenie pacientov, ktorí prešli z hemodialýzy na peritoneálnu dialýzu do 90 dní, je metodologicky odôvodnené, ale samo osebe môže zaviesť výberové skreslenie. Ide spravidla o urgentne začatú dialýzu s odlišnými klinickými charakteristikami.</p>

<h3>Chýbajúce údaje na úrovni stredísk</h3>

<p>Autori nemali údaje o jednotlivých dialyzačných strediskách, a preto nemohli zohľadniť rozdiely v klinickej praxi. To je významné najmä pri peritoneálnej dialýze, kde sa organizácia programu, tréning pacienta a podporné štruktúry medzi centrami môžu podstatne líšiť a môžu ovplyvniť udržateľnosť metódy aj výsledky.</p>

<h3>Prenositeľnosť</h3>

<p>Ide o údaje z jedného regiónu s vlastnou organizáciou dialyzačnej starostlivosti a dostupnosťou zdrojov. Autori upozorňujú, že prípadná výhoda štruktúrovanej starostlivosti v stredisku závisí od usporiadania zdravotného systému a nemá sa zovšeobecňovať bez zohľadnenia miestneho kontextu.</p>

<h2>Čo štúdia preukázala a čo nie</h2>

<p>Štúdia preukázala:</p>

<ul>
  <li>úvodná modalita nebola po úprave nezávisle spojená s rozdielom v päťročnom prežívaní;</li>
  <li>peritoneálna dialýza bez prechodu nebola významne spojená s mortalitou oproti hemodialýze;</li>
  <li>prechod z peritoneálnej dialýzy na hemodialýzu bol spojený s vyššou mortalitou;</li>
  <li>vyšší vek pri začatí dialýzy a začatie liečby v rokoch 2000 až 2007 boli spojené s horším výsledkom;</li>
  <li>dôvody prechodu boli heterogénne a vo väčšine prípadov zodpovedali klinickej nestabilite alebo technickému zlyhaniu metódy.</li>
</ul>

<p>Štúdia nepreukázala:</p>

<ul>
  <li>že hemodialýza po prechode mortalitu <em>spôsobuje</em> — kauzálny podiel prechodu a podiel zhoršenia stavu, ktoré k nemu viedlo, nemožno oddeliť;</li>
  <li>že obe modality poskytujú rovnakú kvalitu života alebo symptomatickú záťaž — tieto ukazovatele sa nehodnotili;</li>
  <li>že jedna modalita je optimálna pre všetkých pacientov vo veku 80 rokov a viac;</li>
  <li>že prechod na hemodialýzu treba odkladať aj pri zlyhaní peritoneálnej dialýzy;</li>
  <li>čokoľvek o porovnaní dialýzy s konzervatívnym postupom — register zahŕňa iba pacientov, ktorí dialýzu začali;</li>
  <li>že vek sám osebe je dostatočným dôvodom na výber alebo odmietnutie určitej modality.</li>
</ul>

<h2>Klinický význam</h2>

<p>Hlavné posolstvo práce nie je o výbere modality na začiatku, ale o <strong>dynamickom vedení liečby</strong>. Voľba modality má byť súčasťou spoločného rozhodovania a priebežne sa prehodnocovať, nie chápať ako jednorazové a nemenné rozhodnutie.</p>

<p>Pred začatím dialýzy je vhodné posúdiť krehkosť a rýchlosť funkčného poklesu, kognitívne schopnosti, schopnosť zvládať liečbu doma, dostupnosť pomoci, výživu a svalovú hmotu, riziko infekcií, stav cievneho riečiska, reziduálnu diurézu, symptomatickú záťaž, očakávanú kvalitu života a možnosti konzervatívnej liečby bez dialýzy.</p>

<p>Pri peritoneálnej dialýze u veľmi starého pacienta z výsledkov vyplývajú tri praktické dôsledky:</p>

<ol>
  <li><strong>Plánovať možné zlyhanie metódy vopred.</strong> Včasná príprava cievneho prístupu, edukácia pacienta a rodiny a zachovanie funkčnej mobility uľahčia bezpečný prechod, ak bude potrebný.</li>
  <li><strong>Sledovať udržateľnosť metódy, nie iba jej adekvátnosť.</strong> Funkcia peritoneálnej membrány, opakované infekcie a interkurentné ochorenia sú hlavnými dôvodmi prechodu; ich včasné rozpoznanie môže zmeniť načasovanie a plánovanosť zmeny.</li>
  <li><strong>Neplánovaný prechod považovať za rizikový moment.</strong> Štruktúrované sledovanie a včasný zásah môžu podľa autorov zmierniť nadmernú mortalitu spojenú s neskorými a neplánovanými zmenami modality.</li>
</ol>

<p>Prechod na hemodialýzu pri závažnom zhoršení stavu nie je terapeutickým zlyhaním. Často je to primeraná a nevyhnutná reakcia na zlyhanie peritoneálnej metódy alebo na zmenu potrieb pacienta. Výsledky štúdie nie sú dôvodom na jeho odkladanie.</p>

<h2>Úloha konzervatívnej liečby</h2>

<p>U niektorých veľmi starých a výrazne krehkých pacientov môže byť primeranou alternatívou konzervatívny postup bez začatia dialýzy. Jeho cieľom nie je „neliečiť“, ale aktívne kontrolovať príznaky, objemový stav, metabolické poruchy, anémiu, bolesť, nauzeu a psychosociálne potreby.</p>

<p>Táto štúdia na uvedenú otázku odpovedať nemôže. Register zahŕňa iba pacientov, ktorí dialýzu začali, a explicitný prechod na konzervatívnu starostlivosť bol v kohorte veľmi zriedkavý (štyri prípady). Autori sami volajú po štúdiách porovnávajúcich dialyzačné modality s konzervatívnym postupom, ktoré by zahŕňali kvalitu života, symptomatickú záťaž a ukazovatele spojené s krehkosťou.</p>

<p>Rozhodnutie musí rešpektovať vôľu pacienta a má sa robiť včas, kým je pacient schopný vyjadriť svoje hodnoty a preferencie.</p>

<h2>Záver</h2>

<p>V populačnej kohorte 4205 pacientov vo veku 80 rokov a viac z Katalánskeho obličkového registra nebola úvodná voľba hemodialýzy alebo peritoneálnej dialýzy po úprave spojená s rozdielom v prežívaní. Prechod z peritoneálnej dialýzy na hemodialýzu bol spojený s vyššou mortalitou (pomer hazardu 1,46; 95 % interval spoľahlivosti 1,02 – 2,08), pričom najpravdepodobnejším vysvetlením je zhoršenie zdravotného stavu, ktoré k prechodu viedlo; príspevok samotného procesu zmeny však nemožno vylúčiť.</p>

<p>Silnou stránkou práce je modelovanie modality ako časovo závislej expozície, ktoré bráni skresleniu nesmrteľným časom. Práve vďaka nemu sa ukázalo, že zdanlivo horšie prežívanie pri peritoneálnej dialýze v jednoduchej analýze bolo artefaktom metódy.</p>

<p>Výsledky nepodporujú výber dialyzačnej modality podľa veku. Podporujú individualizované rozhodovanie, pravidelné hodnotenie krehkosti a funkčného stavu, včasné plánovanie možného prechodu medzi modalitami a otvorenú diskusiu o dialyzačnej aj konzervatívnej liečbe.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze: multicentrická validácia škály klinickej krehkosti</a></li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy: čo ukázala poľská kohorta</a></li>
  <li><a href="article.php?slug=predikcia-vhodnosti-peritonealnej-dialyzy-validacia">Predikcia vhodnosti peritoneálnej dialýzy: model, ktorý potrebuje validáciu a jasnú prírastkovú hodnotu</a></li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Toapanta N, Azancot MA, Comas J, Ramos N, León-Román J, Patricio-Liébana M, Sánchez Olaya J, Alvarez T, Tatis E, Nuñez S, Padron N, Bedoya H, Zamora I, Tort J, Bestard O, Moreso F, Soler MJ. Dialysis modality and survival in octogenarians: real-world population-based cohort study. Clinical Kidney Journal. 2026;19(8):sfag233. doi: 10.1093/ckj/sfag233. PMID 42564550. <a href="https://pubmed.ncbi.nlm.nih.gov/42564550/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13444172/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>. Hlavný spracovaný zdroj.</em></small></li>
  <li><small><em>VanderWeele TJ, Ding P. Sensitivity Analysis in Observational Research: Introducing the E-Value. Annals of Internal Medicine. 2017;167(4):268–274. doi: 10.7326/M16-2607. PMID 28693043. <a href="https://pubmed.ncbi.nlm.nih.gov/28693043/" target="_blank" rel="noopener noreferrer">PubMed</a>. Metóda použitá v analýze citlivosti.</em></small></li>
  <li><small><em>Couchoud C, Labeeuw M, Moranne O, Allot V, Esnault V, Frimat L, Stengel B; French Renal Epidemiology and Information Network (REIN) registry. A clinical score to predict 6-month prognosis in elderly patients starting dialysis for end-stage renal disease. Nephrology Dialysis Transplantation. 2009;24(5):1553–1561. doi: 10.1093/ndt/gfn698. PMID 19096087. <a href="https://pubmed.ncbi.nlm.nih.gov/19096087/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Giuliani A, Sgarabotto L, Manani SM, Tantillo I, Ronco C, Zanella M. Assisted peritoneal dialysis: strategies and outcomes. Renal Replacement Therapy. 2022;8(1):2. doi: 10.1186/s41100-021-00390-4. PMID 35035998. <a href="https://pubmed.ncbi.nlm.nih.gov/35035998/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Puri A, Lloyd AM, Bello AK, Tonelli M, Campbell SM, Tennankore K, Davison SN, Thompson S. Frailty Assessment Tools in Chronic Kidney Disease: A Systematic Review and Meta-analysis. Kidney Medicine. 2025;7(3):100960. doi: 10.1016/j.xkme.2024.100960. PMID 39980935. <a href="https://pubmed.ncbi.nlm.nih.gov/39980935/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Zoccali C, Kanbay M, Wiecek A, Mallamaci F. When KDIGO Meets Frailty: Rethinking Chronic Kidney Disease Targets in Adults Aged 80 Years and Older. American Journal of Nephrology. 2026:1–10. doi: 10.1159/000551636. PMID 41871208. <a href="https://pubmed.ncbi.nlm.nih.gov/41871208/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Switching Dialysis Modalities Ups Mortality in Older Adults. Medscape Medical News, 2026 (redakčné spracovanie primárnej štúdie; autor v dostupnej verzii neuvedený). <a href="https://www.medscape.com/viewarticle/switching-dialysis-modalities-ups-mortality-older-adults-2026a1000x7u" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dialyzacna-modalita-prezivanie-oktogenari-pd-hd_article',
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
