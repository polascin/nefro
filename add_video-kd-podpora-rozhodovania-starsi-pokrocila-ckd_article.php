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
    'title' => 'Video podpora rozhodovania a plánovanie starostlivosti vopred u starších pacientov s pokročilou chronickou chorobou obličiek: štúdia VIDEO-KD',
    'slug' => 'video-kd-podpora-rozhodovania-starsi-pokrocila-ckd',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Štúdia VIDEO-KD u 453 starších pacientov s eGFR najviac 30 ml/min/1,73 m² zvýšila dokumentáciu plánovania starostlivosti vopred o 16,6 percentuálneho bodu. Či sa podľa nej aj liečilo, nemerala.',
    'content' => <<<'HTML'
<p>Starší človek s pokročilou chronickou chorobou obličiek (CKD) skôr či neskôr stojí pred voľbou, či pri zlyhaní obličiek začať dialýzu, alebo zostať pri podpornej starostlivosti bez nej. Rozhodnutie mení každodenný život. V ambulancii pritom často chýba súvislý záznam o tom, že sa o voľbe vôbec hovorilo.</p>

<p>Randomizovaná štúdia VIDEO-KD skúšala, či dvanásťminútová video pomôcka o troch možnostiach liečby spolu s vyhlásením, ktoré pacient nahrá alebo napíše sám, zvýši podiel ľudí s dokumentovaným plánovaním starostlivosti vopred. U 453 pacientov vo veku najmenej 65 rokov, s odhadovanou glomerulovou filtráciou (eGFR) najviac 30 ml/min/1,73 m<sup>2</sup>, taký záznam do 12 mesiacov alebo do úmrtia vznikol u 129 z 228 ľudí v intervenčnej skupine (56,6 %) a u 90 z 225 v kontrolnej skupine (40,0 %). Rozdiel 16,6 percentuálneho bodu je štatisticky významný (95 % interval spoľahlivosti od 7,5 do 25,7; P &lt; 0,001). Štúdia nemerala, či sa podľa tohto záznamu aj liečilo.<sup>1</sup></p>

<figure>
  <picture>
    <source srcset="img/video-kd-podpora-rozhodovania-starsi-pokrocila-ckd.webp" type="image/webp">
    <img src="img/video-kd-podpora-rozhodovania-starsi-pokrocila-ckd.png" alt="Polopriesvitná oblička v tme: ľavá polovica v chladnom svetle s náznakom dialyzačného okruhu, pravá v teplom jantárovom svetle, medzi nimi tenká svetelná clona" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zdravotníckej pomôcky. Znázorňuje voľbu medzi dialýzou a podpornou starostlivosťou bez dialýzy.</figcaption>
</figure>

<h2>Ako bola štúdia postavená a koho zaradila</h2>

<p>Išlo o multicentrickú štúdiu s dvoma paralelnými skupinami v 12 ambulanciách v Spojených štátoch, z toho v 11 nefrologických a v jednej všeobecnej. Nábor prebiehal od júna 2021 do marca 2025 a sledovanie trvalo 12 mesiacov. Údaje sa analyzovali v apríli 2026. Priradenie bolo 1 : 1, v permutovaných blokoch podľa pracoviska, s utajením poradia v systéme REDCap. Hodnotitelia výsledkov skupinu nepoznali. Účastníci zaslepení neboli.<sup>1</sup></p>

<p>Pokročilá CKD znamenala eGFR najviac 30 ml/min/1,73 m<sup>2</sup>. Rovnicu, ktorou sa filtrácia počítala, práca neuvádza. Vylúčení boli pacienti na dialýze, po transplantácii obličky a tí, ktorí už mali lekársky príkaz k rozsahu život zachraňujúcej liečby. Vylúčení boli aj ľudia neschopní informovaného súhlasu, s iným hovorovým jazykom než angličtina alebo španielčina a s kognitívnou poruchou, ktorá by účasť znemožnila.</p>

<p>Z 8 077 pacientov vytipovaných z dokumentácie ošetrujúci lekári vyradili 727 a spôsobilých ostalo 7 350. Po kognitívnom skríningu a overení, že uchádzač rozumie súhlasu, bolo oslovených a naďalej spôsobilých 2 000. Súhlas dalo 456 ľudí. Troch autori po súhlase vyradili, dôvod práca neudáva. Do analýzy vstúpilo 453 pacientov, 228 do intervencie a 225 do kontroly.</p>

<p>Priemerný vek bol 78,8 roka (smerodajná odchýlka 6,4) a žien bolo 190 (41,9 %). Rasu a etnicitu uviedli účastníci sami. Bielej rasy bolo 375 (82,8 %), čiernej 38 (8,4 %), inej alebo zmiešanej 21 (4,6 %), ázijskej 8 (1,8 %), amerických Indiánov alebo pôvodných obyvateľov Aljašky 5 (1,1 %) a pôvodných obyvateľov Havaja alebo iných tichomorských ostrovov 3 (0,7 %). Rasa chýbala u troch ľudí. Hispánsky alebo latinskoamerický pôvod uviedlo 35 ľudí (7,7 %). Ide o etnicitu, ktorá sa s rasou prekrýva, nie o ďalšiu rasovú kategóriu. V kontrolnej skupine bolo viac ľudí čiernej rasy (25 z 225, teda 11,1 %) než v intervenčnej (13 z 228, teda 5,7 %). Nábor bol sústredený. Z Massachusetts General Hospital, ktorá do štúdie prispela nefrologickou aj všeobecnou ambulanciou, pochádzalo 117 pacientov (25,8 %), z Geisinger Health System 75 (16,6 %) a z University of Pennsylvania jeden.</p>

<p>Šestnásť ľudí súhlas odvolalo, po osem v každej skupine, a 72 sledovanie v 12. mesiaci nedokončilo (33 v intervencii, 39 v kontrole). Do 12. mesiaca zomrelo 27 ľudí (11 a 16). Primárny ukazovateľ tieto straty neoslabil: dokumentácia sa dohľadala u všetkých zaradených. Mortalita sama ukazovateľom nebola.</p>

<h2>Čo intervenčná skupina absolvovala</h2>

<p>Účastníci v intervencii si najprv pozreli dvanásťminútové video. Autori ho označujú ako certifikovanú pomôcku na podporu rozhodovania. Bolo v angličtine a v španielčine, jazykom približne na úrovni piateho ročníka americkej základnej školy. Najprv hovorilo o cieľoch a hodnotách, potom o troch cestách, keď sa CKD blíži k zlyhaniu obličiek: o hemodialýze, o peritoneálnej dialýze a o konzervatívnom manažmente, teda o aktívnej podpornej starostlivosti bez dialýzy. Obraz má dokumentárny charakter, nie podobu kreslenej schémy. Video prešlo opakovanými úpravami s ľuďmi s chorobou obličiek a stojí na modeli spoločného rozhodovania. Pacient dostal odkaz, aby si ho mohol pozrieť znova, aj doma.</p>

<p>Hneď po videu vzniklo pacientovo vlastné vyhlásenie o hodnotách a o tom, akú liečbu by chcel. V štúdii sa označuje ako ViDEC. Formu si človek vybral sám: videonahrávku, zvukovú nahrávku alebo text. Vyhlásenie dostal on aj jeho ošetrujúci lekár a dalo sa kedykoľvek nahrať znova. Pacienta sprevádzali vyškolené sestry a sociálni pracovníci.</p>

<p>Kontrolná skupina dostala obvyklú starostlivosť, bez tejto video pomôcky a bez štruktúrovaného vyhlásenia. Ostatná liečba obmedzená nebola.</p>

<p>Vyhlásenie dokončilo 207 z 228 ľudí (90,8 %): videonahrávku 107 (46,9 %), zvuk 42 (18,4 %) a text 58 (25,4 %). Všetky formy odmietlo 21 ľudí (9,2 %). Aspoň raz ho znova nahralo 36 účastníkov. Z tých, ktorí vyhlásenie dokončili a odpovedali na krátky dotazník (161 z 207), ho 109 (67,7 %) považovalo za užitočné, 128 (79,5 %) za ľahko zvládnuteľné a 114 (70,8 %) by ho odporučilo ďalším. Pozretie videa bolo veľmi alebo skôr prijateľné pre 199 z 224 respondentov (88,8 %). Odkaz na domáce pozretie použilo 208 účastníkov. Nežiaduce udalosti štúdia nehlásila.</p>

<h2>Čo sa počítalo ako výsledok</h2>

<p>Primárnym ukazovateľom bola akákoľvek dokumentácia plánovania starostlivosti vopred v elektronickej zdravotnej dokumentácii do 12 mesiacov od zaradenia alebo do úmrtia, podľa toho, čo nastalo skôr. Patrí sem rozhovor o cieľoch starostlivosti, obmedzenie život zachraňujúcej liečby, paliatívna starostlivosť, hospic, určenie osoby, ktorá má rozhodovať namiesto pacienta, aj diskusia o možnostiach liečby. Softvér ClinicalRegex najprv označil úseky ambulantných textov. Zaslepení pracovníci ich potom posúdili.</p>

<p>Vopred určené sekundárne ukazovatele boli dokumentovaná diskusia o možnostiach liečby zlyhania obličiek, jednotlivé zložky plánovania vopred, vyslovená preferencia liečby, vedomosť o možnostiach a istota rozhodnutia. Analýza rešpektovala pôvodné zaradenie. Rozdiely podielov sú neupravené. Hodnoty P pri dokumentácii pochádzajú z logistickej regresie upravenej na pracovisko. Pri sekundárnych ukazovateľoch ich nemožno brať ako potvrdenie účinku, lebo chýba úprava na viacnásobné testovanie. Rozdelenie preferencií sa porovnávalo Fisherovým exaktným testom.</p>

<p>Pôvodný výpočet počítal so 600 účastníkmi a so štatistickou silou nad 90 % zachytiť rozdiel 13,2 percentuálneho bodu. Keď bola známa polovica výsledkov, zaslepená priebežná analýza viedla k schváleniu nižšieho cieľa, 450 účastníkov, so silou 80 % pri predpokladanej miere dokumentácie v kontrole 46 %. Skutočná miera v kontrole bola 40,0 %.</p>

<h2>Čo sa v dokumentácii zmenilo a čo nie</h2>

<p>Do 12 mesiacov mala dokumentáciu plánovania vopred väčšia časť intervenčnej skupiny. Z neupraveného rozdielu 16,6 percentuálneho bodu vychádza orientačný počet: aby pribudol jeden taký záznam, treba intervencii vystaviť približne 6 pacientov, s hranicami približne od 4 do 13. Je to dopočet z rozdielu podielov za horizont 12 mesiacov. Nehovorí, koľko ľudí treba liečiť, aby sa predišlo úmrtiu alebo hospitalizácii.</p>

<div class="table-responsive" role="region" aria-label="Dokumentácia plánovania starostlivosti vopred do 12 mesiacov alebo do úmrtia" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Intervencia (n = 228)</th>
      <th scope="col">Kontrola (n = 225)</th>
      <th scope="col">Rozdiel podielov v percentuálnych bodoch (95 % interval spoľahlivosti)</th>
      <th scope="col">P</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Plánovanie starostlivosti vopred, súhrnne</th>
      <td>129 (56,6 %)</td>
      <td>90 (40,0 %)</td>
      <td>16,6 (od 7,5 do 25,7)</td>
      <td>&lt; 0,001</td>
    </tr>
    <tr>
      <th scope="row">Diskusia o možnostiach liečby zlyhania obličiek</th>
      <td>105 (46,1 %)</td>
      <td>71 (31,6 %)</td>
      <td>14,5 (od 5,6 do 23,4)</td>
      <td>0,001</td>
    </tr>
    <tr>
      <th scope="row">Rozhovor o cieľoch starostlivosti</th>
      <td>42 (18,4 %)</td>
      <td>29 (12,9 %)</td>
      <td>5,5 (od −1,1 do 12,2)</td>
      <td>0,10</td>
    </tr>
    <tr>
      <th scope="row">Obmedzenie resuscitácie</th>
      <td>17 (7,5 %)</td>
      <td>7 (3,1 %)</td>
      <td>4,3 (od −0,05 do 13,6)</td>
      <td>0,04</td>
    </tr>
    <tr>
      <th scope="row">Hospic</th>
      <td>8 (3,5 %)</td>
      <td>2 (0,9 %)</td>
      <td>2,6 (od −6,6 do 11,8)</td>
      <td>0,08</td>
    </tr>
    <tr>
      <th scope="row">Paliatívna starostlivosť</th>
      <td>9 (3,9 %)</td>
      <td>11 (4,9 %)</td>
      <td>−0,9 (od −10,1 do 8,3)</td>
      <td>0,57</td>
    </tr>
    <tr>
      <th scope="row">Zástupca pre rozhodovanie</th>
      <td>16 (7,0 %)</td>
      <td>17 (7,6 %)</td>
      <td>−0,5 (od −9,7 do 8,8)</td>
      <td>0,78</td>
    </tr>
    <tr>
      <th scope="row">Konzervatívny manažment zlyhania obličiek</th>
      <td>23 (10,1 %)</td>
      <td>25 (11,1 %)</td>
      <td>−1,0 (od −10,2 do 8,3)</td>
      <td>0,81</td>
    </tr>
    <tr>
      <th scope="row">Časovo obmedzená skúška dialýzy</th>
      <td>0 (0 %)</td>
      <td>2 (0,9 %)</td>
      <td>−0,9 (od −10,1 do 8,3)</td>
      <td>0,12</td>
    </tr>
  </tbody>
</table>
</div>

<p>Primárny ukazovateľ je súhrnný a diskusia o možnostiach liečby je zároveň jeho súčasťou. Práve táto diskusia nesie väčšinu rozdielu, 14,5 percentuálneho bodu. Samotný rozhovor o cieľoch starostlivosti významný rozdiel neukázal. Dokumentácia konzervatívneho manažmentu bola v oboch skupinách prakticky rovnaká, približne u desatiny pacientov, a interval spoľahlivosti rozdielu leží široko na oboch stranách nuly.</p>

<p>Z ďalších zložiek autori osobitne uvádzajú obmedzenie resuscitácie, 17 oproti 7. Neupravený interval spoľahlivosti siaha od −0,05 do 13,6 percentuálneho bodu, teda tesne zahŕňa nulu, kým hodnota P upravená na pracovisko je 0,04. Pri malých počtoch a pri teste bez korekcie na ostatné porovnania z toho nevyplýva, že intervencia mení rozhodnutia o resuscitácii. Paliatívna starostlivosť, hospic, zástupca pre rozhodovanie ani časovo obmedzená skúška dialýzy sa medzi skupinami nelíšili. Hospic bol v dokumentácii zriedkavý, 8 oproti 2, a interval je pri takých počtoch príliš široký.</p>

<h2>Preferencie a vedomosti v deň zaradenia</h2>

<p>Preferencie sa merali inak než dokumentácia. Všetci odpovedali pri zaradení. Intervenčná skupina odpovedala ešte raz hneď po videu, v ten istý deň. Kontrolná skupina sa znova nepýtala. Porovnanie po videu je preto porovnanie so vstupným stavom kontroly, nie s druhým meraním v tom istom čase. Ako dlho preferencia vydrží, štúdia nesledovala.</p>

<p>Pri zaradení bolo nerozhodnutých 90 z 227 ľudí v intervencii (39,6 %) a 92 z 223 v kontrole (41,3 %). Hemodialýzu vtedy uviedlo 43 z 227 (18,9 %) a 42 z 223 (18,8 %). Jeden človek v intervencii a dvaja v kontrole preferenciu nevyjadrili. Vstupný podiel konzervatívneho manažmentu v intervenčnej skupine práca neuvádza.</p>

<div class="table-responsive" role="region" aria-label="Preferencia liečby zlyhania obličiek hneď po videu a pri zaradení v kontrole" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Preferencia</th>
      <th scope="col">Intervencia hneď po videu (n = 227)</th>
      <th scope="col">Kontrola pri zaradení (n = 223)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nerozhodnutí</th>
      <td>30 (13,2 %)</td>
      <td>92 (41,3 %)</td>
    </tr>
    <tr>
      <th scope="row">Konzervatívny manažment zlyhania obličiek</th>
      <td>115 (50,7 %)</td>
      <td>71 (31,8 %)</td>
    </tr>
    <tr>
      <th scope="row">Peritoneálna dialýza</th>
      <td>37 (16,3 %)</td>
      <td>18 (8,1 %)</td>
    </tr>
    <tr>
      <th scope="row">Hemodialýza</th>
      <td>45 (19,8 %)</td>
      <td>42 (18,8 %)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Po videu ostalo nerozhodnutých 30 z 227 (13,2 %). Hemodialýzu naďalej uvádzalo 45 z 227 (19,8 %), teda prakticky rovnaký podiel ako pred videom aj ako v kontrole. Vyšší bol podiel konzervatívneho manažmentu: 115 z 227 (50,7 %) oproti 71 z 223 (31,8 %) v kontrole pri zaradení, rozdiel 18,8 percentuálneho bodu (95 % interval spoľahlivosti od 9,9 do 27,7). Vyšší bol aj podiel peritoneálnej dialýzy: 37 z 227 (16,3 %) oproti 18 z 223 (8,1 %), rozdiel 8,2 percentuálneho bodu (od 2,2 do 14,4). Celkové rozdelenie preferencií sa líšilo (P &lt; 0,001). Autori z toho čítajú, že video ľudí od hemodialýzy neodvádzalo. Klesol podiel nerozhodnutých. Tomu zodpovedá aj absolútny počet tých, ktorí hemodialýzu uviedli: 43 pred videom a 45 po ňom.</p>

<p>Vstupná vedomosť nebola v skupinách rovnaká. Aspoň nejakú vedomosť o dialýze uviedlo pri zaradení 167 z 228 ľudí v intervencii (73,2 %) a 144 z 225 v kontrole (64,0 %), o konzervatívnom manažmente 108 (47,4 %) a 86 (38,2 %). Po videu, medzi 226 respondentmi intervencie, to bolo 195 (86,3 %) pri dialýze a 175 (77,4 %) pri konzervatívnom manažmente. Vnútri intervenčnej skupiny teda vedomosť o dialýze stúpla o 13,1 percentuálneho bodu a o konzervatívnom manažmente o 30,0. Istotu rozhodnutia uviedlo pri zaradení 133 z 228 (58,3 %) a 123 z 225 (54,7 %), po videu 159 z 227 (70,0 %). Vnútri skupiny je to nárast o 11,7 percentuálneho bodu. Autori z toho usudzujú, že neistota pri tejto voľbe nie je len medzera v informáciách.</p>

<h2>Čo z toho ambulancia môže a nemôže vziať</h2>

<p>Použiteľný je sled krokov. Najprv rovnaké vysvetlenie troch ciest, vrátane podpornej starostlivosti bez dialýzy. Potom vlastné slová pacienta, nie len políčko v dotazníku. A napokon záznam, ktorý má ošetrujúci lekár k dispozícii skôr, než sa voľba stane naliehavou pri akútnom zhoršení. V štúdii tento sled zvýšil dokumentáciu a v deň zaradenia znížil podiel nerozhodnutých. Rozhodnutie nefrológa nenahrádza. Intervenciu viedli sestry a sociálni pracovníci.</p>

<p>Prenos na slovenské ambulancie naráža na jazyk, na zloženie súboru a na to, čo sa nemeralo. Video bolo po anglicky a po španielsky. Súbor bol prevažne bielej rasy. Najmenej bakalársky titul uviedlo 222 z 453 ľudí (49,0 %) a nábor išiel najmä z akademických pracovísk. Slovenská verzia by musela vzniknúť nanovo. Ani potom by nárast záznamu v dokumentácii neznamenal, že zvolená liečba je pre daného človeka lepšia.</p>

<p>Dve zistenia sa rozišli a práve ich rozdiel je pre prax dôležitý. Hneď po videu uviedla konzervatívny manažment ako svoju voľbu polovica intervenčnej skupiny. V dokumentácii za 12 mesiacov sa konzervatívny manažment objavil približne u desatiny pacientov v oboch skupinách. Podiel vyslovenej preferencie a podiel neskoršieho záznamu sa výrazne líšia. Autori nezistili, či lekár vyhlásenie otvoril a či sa podľa neho pri začatí dialýzy postupovalo. Starostlivosť v súlade s cieľmi pacienta štúdia nehodnotila.</p>

<h2>Limity</h2>

<ol>
  <li><strong>Primárny ukazovateľ je procesný.</strong> Štúdia nemerala mortalitu ako cieľ, hospitalizácie, kvalitu života, skutočne začatú modalitu ani to, či prijatá starostlivosť zodpovedala tomu, čo pacient chcel. Poslednú analýzu si autori nechávajú na čas, keď bude viac úmrtí.</li>
  <li><strong>Záznam nehovorí o kvalite rozhovoru.</strong> Úplnosť dokumentácie sa nehodnotila.</li>
  <li><strong>Preferencie sú z jedného dňa.</strong> Ich trvanie nie je známe a kontrola nemá druhé meranie v tom istom čase. Časť rozdielu vo vedomostiach bola prítomná už pred videom.</li>
  <li><strong>Ostatné zložky dokumentácie prakticky nestúpli.</strong> Okrem diskusie o možnostiach liečby sú rozdiely malé, intervaly prechádzajú nulou a testy nemajú potvrdzujúcu váhu.</li>
  <li><strong>Súbor je úzky.</strong> Prevažujú ľudia bielej rasy, z akademických ambulancií, hovoriaci po anglicky alebo po španielsky. Podiel čiernej rasy bol 8,4 % a medzi skupinami nevyrovnaný. Pacienti, ktorí už mali príkaz k rozsahu život zachraňujúcej liečby, zaradení neboli. Jedno pracovisko zaradilo jediného pacienta.</li>
  <li><strong>Väzby autorov patria k čítaniu výsledku.</strong> Štúdiu zaplatil Národný inštitút pre starnutie grantom R01AG066892. Podľa vyhlásenia nezasahoval do návrhu, zberu, analýzy ani do rozhodnutia publikovať. Manžel alebo manželka prvého autora vedie spoločnosť ACP Decisions. Spoluautorka Aretha Delight Davisová je jej spoluzakladateľkou a generálnou riaditeľkou a zároveň uvádza grant, zamestnanie a členstvo v správnej rade nadácie Nous Foundation. Susan P. Y. Wongová je mimo tejto práce zamestnankyňou Fresenius Medical Care. Či spoločnosť ACP Decisions toto video vyrobila, práca výslovne neuvádza.</li>
</ol>

<h2>Záver</h2>

<p>U starších pacientov s eGFR najviac 30 ml/min/1,73 m<sup>2</sup> video o troch možnostiach liečby spolu s vlastným vyhlásením pacienta zvýšilo dokumentáciu plánovania starostlivosti vopred, predovšetkým záznam o diskusii možností, a v deň zaradenia znížilo podiel nerozhodnutých. Podiel tých, ktorí chceli hemodialýzu, sa nezmenil. Či sa podľa vyhlásenia neskôr aj postupovalo, štúdia nevie.</p>

<hr>
<p><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Nenahrádza rozhovor s konkrétnym pacientom ani rozhodnutie o začatí dialýzy alebo o podpornej starostlivosti bez nej.</em></p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Volandes AE, Lakin JR, Chang Y, Lindvall C, Quintiliani LM, Lundquist AL, Liu A, Kurella Tamura M, Unruh M, Wong SPY, Davis AD, Garde C, Henault L, Samarakoon U, Hanchate A, Mandel E, Green JA, Lawson K, Randa SN, Paasche-Orlow MK. Video Decision Support and Advance Care Planning in Older Adults With Advanced Kidney Disease: The VIDEO-KD Randomized Clinical Trial. <em>JAMA Internal Medicine.</em> Online 22. októbra 2026, ešte bez zaradenia do čísla, článok e265989. doi: 10.1001/jamainternmed.2026.5989. PMID 42911803. PMC13691914. ClinicalTrials.gov NCT04347629. <a href="https://doi.org/10.1001/jamainternmed.2026.5989" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42911803/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13691914/" target="_blank" rel="noopener noreferrer">plný text PMC</a>.</em></small></li>
</ol>

<h2>Poznámka k dôkazom</h2>

<p>Článok spracúva jednu randomizovanú štúdiu. Počty zaradených, znenie intervencie, dokumentácia, preferencie, vedomosti, dokončenie vyhlásení, štatistická sila a konflikty záujmov sú z plného textu v PubMed Central vrátane tabuliek 1 a 2. Abstrakt uvádza pri amerických Indiánoch alebo pôvodných obyvateľoch Aljašky počet 4, tabuľka 1 počet 5 (1,1 %). V článku je údaj z tabuľky. Úplný zoznam 20 autorov, DOI a PMID sú overené cez Crossref a PubMed. Sekundárna stránka s videom na JoVE sa nepoužila. Počet pacientov na jeden dokumentovaný záznam navyše je dopočítaný z rozdielu podielov 16,6 percentuálneho bodu. V pôvodnej práci nie je.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov</a></li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy: čo ukázala poľská kohorta</a></li>
  <li><a href="article.php?slug=rady-hemodialyza-starsi-pacienti-partneri-starostlivosti">Ako žiť s hemodialýzou: rady starších pacientov a ich partnerov starostlivosti</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_video-kd-podpora-rozhodovania-starsi-pokrocila-ckd_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
