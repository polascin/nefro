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
    'title' => 'eOČR v nefrologickej praxi: kompetencie, dokumentácia a najčastejšie chyby',
    'slug' => 'eocr-nefrologicka-prax-kompetencie-dokumentacia-chyby',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Elektronická OČR zjednodušuje potvrdzovanie potreby starostlivosti, nezakladá však automaticky nárok na ošetrovné. Prehľad kompetencií nefrológa, úskalí spätného vystavenia a pravidiel dokumentácie.',
    'content' => <<<'HTML'
<p>Elektronická OČR (eOČR) predstavuje od 1. augusta 2026 ďalší krok v digitalizácii potvrdzovania dočasnej práceneschopnosti a potreby starostlivosti v systéme eZdravie. Pre lekára zjednodušuje komunikáciu s inštitúciami, no v praxi odhaľuje časté nepochopenie hraníc medzi medicínskym potvrdením a sociálnym zabezpečením. Lekár potvrdzuje výlučne existenciu zdravotného stavu vyžadujúceho celodenné ošetrovanie na strane pacienta, sám nerozhoduje o priznaní ani výplate peňažnej dávky ošetrovného.</p>

<p>V nefrologickej praxi prináša eOČR špecifické situácie. Nefrológ lieči pacientov po akútnych dekompenzáciách, hospitalizovaných chorých s ťažkým renálnym zlyhaním, ale aj stabilných chronicky dialyzovaných pacientov či ľudí v terminálnych štádiách ochorenia. Zvládnutie správneho zaradenia prípadu (krátkodobá starostlivosť, dlhodobá starostlivosť po hospitalizácii alebo paliatívny režim) chráni pracovisko pred zbytočnými spormi a rodine pacienta šetrí čas pri uplatňovaní nárokov. [1,2]</p>

<figure>
  <picture>
    <source srcset="img/eocr-nefrologicka-prax-kompetencie-dokumentacia-chyby.webp" type="image/webp">
    <img src="img/eocr-nefrologicka-prax-kompetencie-dokumentacia-chyby.png" alt="Ilustračné schematické zobrazenie obličky prepojenej s digitálnou zdravotnou dokumentáciou a systémom elektronickej OČR" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Elektronická OČR zaznamenáva medicínsku potrebu starostlivosti o pacienta v eZdraví. Ošetrujúca osoba si peňažnú dávku uplatňuje v Sociálnej poisťovni samostatne. Ilustračné zobrazenie.</figcaption>
</figure>

<p>Text vychádza z oficiálnych metodických odpovedí Národného centra zdravotníckych informácií (NCZI) aktualizovaných k 5. októbru 2026 a usmernení Sociálnej poisťovne. Zohľadňuje právny rámec zákona č. 461/2003 Z. z. o sociálnom poistení a zákona č. 576/2004 Z. z. o zdravotnej starostlivosti. Nejde o záväzný právny komentár, ale o praktického sprievodcu pre klinickú prax lekára. [1–5]</p>

<h2>Lekár potvrdzuje potrebu starostlivosti, nerozhoduje o dávke</h2>

<p>eOČR je služba eZdravia určená na elektronické zaznamenávanie vzniku, zmien, storna a ukončenia potreby ošetrovania alebo starostlivosti. Záznam sa vystavuje na ošetrovanú osobu, teda na pacienta, ktorého zdravotný stav si celodennú pomoc vyžaduje. [1]</p>

<p>Osoba, ktorá starostlivosť poskytuje, sa v zázname eOČR podľa NCZI vôbec neeviduje. Lekár preto v systéme neurčuje, ktorý rodinný príslušník bude poberať dávku, ani neposudzuje jeho poistné vzťahy. Skúmanie podmienok nemocenského poistenia (napríklad trvanie poistenia najmenej 270 dní v posledných dvoch rokoch či absencia nedoplatkov u samostatne zárobkovo činnej osoby) patrí výlučne Sociálnej poisťovni.</p>

<p>Vystavenie eOČR nie je automatickým podaním žiadosti o dávku ošetrovné. Ošetrujúca osoba si nárok uplatňuje samostatne. Sociálna poisťovňa umožňuje elektronické podanie cez svoj portál eSlužieb (elektronický účet poistenca) alebo listinnú žiadosť doručenú poštou či osobne. Po prijatí žiadosti si poisťovňa údaje o potvrdenej potrebe starostlivosti vyžiada z eZdravia automatizovane. [1,2]</p>

<p>Pri príslušníkoch silových zložiek (policajti, profesionálni vojaci, hasiči, colníci) dávku vypláca príslušný rezortný orgán podľa zákona č. 328/2002 Z. z. o sociálnom zabezpečení policajtov a vojakov. Pacientovi ani jeho rodine preto nestačí povedať, že „OČR je v počítači“. Potrebujú jasnú informáciu, že o samotnú peňažnú dávku musia požiadať sami.</p>

<h2>Kedy a ako môže eOČR vystaviť nefrológ</h2>

<p>V nefrologickej praxi prichádzajú do úvahy tri odlišné situácie s presne vymedzenými pravidlami.</p>

<div class="table-responsive" role="region" aria-label="Prehľad kompetencií nefrológa pri vystavovaní elektronickej OČR" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klinická situácia</th>
      <th scope="col">Podmienky a postup podľa NCZI</th>
      <th scope="col">Kompetencia a význam pre nefrológa</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Krátkodobá eOČR</th>
      <td>Náhle zhoršenie zdravotného stavu vyžadujúce celodenné ošetrovanie. Vystavuje všeobecný lekár alebo lekár so špecializáciou pre pacientov starších ako 18 rokov.</td>
      <td>Ambulantný aj nemocničný nefrológ môže vystaviť eOČR dospelému pacientovi priamo v rámci svojho odborného vyšetrenia.</td>
    </tr>
    <tr>
      <th scope="row">Dlhodobá eOČR po hospitalizácii</th>
      <td>Hospitalizácia trvala aspoň 5 po sebe nasledujúcich kalendárnych dní a predpokladá sa domáca starostlivosť najmenej ďalších 30 dní. Vystavuje určený lekár ústavného zariadenia najneskôr v deň prepustenia.</td>
      <td>Vystavuje ústavný nefrológ ako určený lekár zariadenia. Ambulantný nefrológ ju nemôže dodatočne založiť namiesto nemocnice. Následné vedenie preberá všeobecný lekár.</td>
    </tr>
    <tr>
      <th scope="row">Dlhodobá eOČR pri paliatívnej starostlivosti</th>
      <td>Pacient v terminálnom štádiu ochorenia. Nevyžaduje sa predchádzajúca hospitalizácia. Medzi oprávnenými odbormi je výslovne uvedená nefrológia.</td>
      <td>Oprávnenie viazané na terminálny stav pacienta, nie na samotnú diagnózu renálneho ochorenia. Nefrológ potvrdzuje potrebu paliatívnej domácej starostlivosti.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri krátkodobej eOČR uvádza NCZI formuláciu „pre osoby staršie ako 18 rokov“. Pre detských pacientov vystavuje krátkodobú eOČR primárne všeobecný lekár pre deti a dorast. Pri hraničných vekových situáciách sa treba riadiť presným znením účinného predpisu, nie voľnou interpretáciou informačného letáku. [1,4]</p>

<h2>Dlhodobá eOČR po hospitalizácii a predpoklad domácej starostlivosti</h2>

<p>Podľa NCZI možno dlhodobú eOČR po hospitalizácii vystaviť iba pri súčasnom splnení dvoch podmienok: ústavná liečba trvala najmenej päť po sebe nasledujúcich kalendárnych dní (vrátane dňa prijatia a prepustenia) a zároveň sa predpokladá potreba domácej celodennej starostlivosti najmenej ďalších 30 kalendárnych dní. [1,4]</p>

<p>Nestačí teda samotný päťdňový pobyt v nemocnici. Rovnako nestačí závažná diagnóza bez reálneho posúdenia funkčného deficitu po prepustení.</p>

<p>Záznam vystavuje určený nemocničný lekár najneskôr v deň prepustenia pacienta. Dátum platnosti eOČR musí zodpovedať dňu ukončenia hospitalizácie. Ďalšie sledovanie, potvrdzovanie trvania a ukončenie prípadu potom preberá všeobecný lekár pacienta. Pôvodný elektronický prípad pokračuje pod rovnakým identifikátorom, nový záznam sa nevytvára. [1]</p>

<p>V nefrológii sa táto situácia týka najmä pacientov s výraznou stratou sebestačnosti po ťažkom priebehu akútneho poškodenia obličiek, urosepse, kardiorenálnej dekompenzácii či po rozsiahlych cievnych a urologických rekonštrukciách. Rozhodujúci nie je samotný názov diagnózy, ale objektívne preukázaná neschopnosť samostatnej existencie v domácom prostredí.</p>

<p>Z praktického hľadiska nemožno očakávať, že ak nemocnica dlhodobú eOČR pri prepustení nevystaví, ambulantný nefrológ ju dodatočne založí. Ambulantný špecialista nemá zákonnú kompetenciu otvárať dlhodobú eOČR viazanú na hospitalizáciu. Rodinu je preto potrebné upozorniť na vyriešenie tejto náležitosti ešte pred opustením oddelenia.</p>

<h2>Paliatívny režim verzus bežná chronická choroba obličiek a dialýza</h2>

<p>Nefrológia patrí medzi špecializačné odbory, ktoré môžu vystaviť dlhodobú eOČR v režime paliatívnej starostlivosti bez podmienky predchádzajúcej hospitalizácie. Tento inštitút však nemožno zovšeobecňovať na každého nefrologického pacienta. [1,2]</p>

<p>Sociálna poisťovňa definuje paliatívny prípad pre účely ošetrovného ako stav pacienta v terminálnom štádiu ochorenia alebo v štádiu ochorenia na konci života. Tento administratívny a posudkový rámec je podstatne užší než moderný koncept renálnej podpornej starostlivosti (kidney supportive care). Podporná starostlivosť podľa medzinárodných odporúčaní KDIGO začína podstatne skôr, zameriava sa na manažment symptómov, plánovanie budúcej starostlivosti a kvalitu života popri aktívnej liečbe. Administratívna paliatívna eOČR sa však viaže na pokročilé terminálne zlyhávanie s nepriaznivou krátkodobou prognózou. [2,6]</p>

<p>Samotná skutočnosť, že pacient podstupuje hemodialýzu alebo má chronickú chorobu obličiek štádia G4 či G5, neznamená automatické splnenie podmienok paliatívnej eOČR. Diagnostický kód N18.5 (terminálne zlyhanie obličiek) je biochemickou a nefrologickou kategóriou, nie dôkazom prebiehajúcej terminálnej agónie či bezprostredného konca života. Pacient na udržiavacej dialýze, ktorý je mimo dialyzačných procedúr mobilný a schopný sebaobsluhy, nespĺňa kritériá celodennej paliatívnej opatery.</p>

<p>Paliatívna eOČR je v nefrológii opodstatnená pri:</p>

<ul>
  <li>pacientoch s pokročilým zlyhaním obličiek na konzervatívnom postupe bez dialýzy (komplexný konzervatívny manažment), kde narastá uremická kachexia a funkčný úpadok,</li>
  <li>ukončení dialyzačnej liečby po spoločnom rozhodnutí lekára, pacienta a rodiny s prechodom na čisto symptomatickú liečbu,</li>
  <li>dialyzovaných pacientoch so súbežným diseminovaným onkologickým ochorením, pokročilou demenciou či refraktérnym kardiálnym zlyhaním v záverečnej fáze života.</li>
</ul>

<h2>Medicínska potreba starostlivosti verzus podporná doba výplaty dávky</h2>

<p>Trvanie medicínsky odôvodnenej potreby ošetrovania a zákonné obdobie poskytovania peňažnej dávky ošetrovné nie sú totožné kategórie. [1,2]</p>

<p>Sociálna poisťovňa vypláca dávku ošetrovné po obmedzený čas: pri krátkodobom ošetrovaní najviac 14 kalendárnych dní, pri dlhodobom ošetrovaní najviac 90 kalendárnych dní. Počas dlhodobého ošetrovania sa navyše ošetrujúce osoby môžu striedať (spravidla najskôr po 30 dňoch) prostredníctvom formulára v Sociálnej poisťovni bez nutnosti zakladania nového medicínskeho prípadu lekárom. [2,4]</p>

<p>Lekár nesmie eOČR ukončiť len preto, že uplynulo 14 alebo 90 dní výplaty peňažnej dávky, ak zdravotný stav pacienta osobnú a celodennú starostlivosť naďalej vyžaduje. eOČR zostáva pre ošetrujúceho rodinného príslušníka dôležitým dokladom voči zamestnávateľovi ako ospravedlnená prekážka v práci (hoci už bez nároku na nemocenskú dávku). Rovnako sa po uplynutí podpornej doby nevystavuje nový prípad eOČR, pokiaľ nedošlo k zmene diagnózy alebo k novému medicínskemu dôvodu po reálnom prerušení starostlivosti. [1]</p>

<h2>Požiadavky na zdravotnú dokumentáciu: prečo pacient potrebuje osobnú a celodennú pomoc</h2>

<p>Konkrétna diagnóza ani medicínske odôvodnenie sa podľa pravidiel NCZI neuvádzajú v zázname eOČR odosielanom zamestnávateľovi. Zostávajú však v zdravotnej dokumentácii pacienta a v elektronickej zdravotnej knižke v eZdraví. [1]</p>

<p>Neprítomnosť diagnózy na administratívnom výstupe neznižuje nároky na kvalitu klinického zápisu v ambulantnom dekurze či prepúšťacej správe. Pri kontrole zo strany posudkového lekára Sociálnej poisťovne musí záznam preukázať:</p>

<ul>
  <li>aké konkrétne ochorenie a funkčné poškodenie bolo vyšetrením zistené,</li>
  <li>prečo stav pacienta vyžaduje osobnú a celodennú pomoc inej osoby (deficit mobility, riziko pádu, poruchy kognície, neschopnosť samostatného príjmu stravy, liekov či vykonania hygieny),</li>
  <li>od ktorého dňa táto potreba preukázateľne trvá,</li>
  <li>aký je predpokladaný vývoj stavu a kedy sa uskutoční kontrolné prehodnotenie.</li>
</ul>

<p>V nefrológii treba dôsledne odlíšiť potrebu sprievodu na vyšetrenie alebo na dialýzu od celodenného ošetrovania. Samotná preprava na dialyzačné stredisko trikrát do týždňa je dôvodom na potvrdenie o sprevádzaní rodinného príslušníka k lekárovi (priepustka s náhradou mzdy podľa § 141 Zákonníka práce), nie na vystavenie OČR. Na OČR vzniká nárok vtedy, ak je pacient medzi dialýzami alebo po nich imobilný, dezorientovaný, vyžaduje kŕmenie, polohovanie či dohľad pri ošetrovaní cievneho prístupu a liečbe.</p>

<h2>Riziká spätného vystavenia: akceptácia v praxi verzus zákonný rámec</h2>

<p>Jednou z najcitlivejších oblastí metodiky NCZI je spätné potvrdzovanie eOČR. NCZI uvádza, že Sociálna poisťovňa v praxi akceptuje eOČR vystavenú najviac tri pracovné dni spätne, ak lekár v elektronickej zdravotnej dokumentácii uvedie medicínske odôvodnenie tohto termínu. [1]</p>

<p>Zároveň však NCZI otvorene konštatuje, že takýto postup sa odlišuje od striktného znenia súčasnej právnej úpravy a pripravuje sa legislatívne zosúladenie. Zákon č. 576/2004 Z. z. aj zákon č. 461/2003 Z. z. primárne predpokladajú potvrdenie odo dňa zistenia potreby ošetrovania pri reálnom vyšetrení pacienta. [1,4,5]</p>

<p>Technická možnosť potvrdiť upozornenie v ambulantnom softvéri nezakladá automatické zákonné oprávnenie pre lekára. Odôvodnenie v dekurze je nevyhnutné, no pri dôslednej revíznej kontrole neodstraňuje rozpor so zákonom, ak lekár potvrdil stav spätne len na základe telefonátu či dodatočnej žiadosti príbuzného bez predošlého kontaktu s pacientom.</p>

<p>Osobitnú situáciu predstavuje objektívny technický výpadok eZdravia. Ak lekár pacienta v daný deň riadne vyšetril, zdokumentoval potrebu starostlivosti v lokálnom nemocničnom alebo ambulantnom systéme a eOČR odoslal do centrálneho systému dodatočne po odstránení výpadku, nejde o neoprávnené spätné posúdenie, ale o oneskorený prenos dát z objektívnych príčin.</p>

<h2>Manažment prípadu: kontrola, pokračovanie a ukončenie</h2>

<p>Dátum predpokladaného trvania eOČR predstavuje termín, ku ktorému má lekár zdravotný stav pacienta prehodnotiť. Uplynutie tohto dátumu samo osebe prípad v eZdraví automaticky neuzatvára. [1]</p>

<p>Ak medicínska potreba celodennej opatery pretrváva, ošetrujúci lekár pred vypršaním lehoty aktualizuje existujúci záznam novým termínom predpokladaného trvania. Ak dôvody na starostlivosť pominuli, lekár zapíše ukončenie eOČR. Nový prípad sa nevytvára ani vtedy, ak pacienta preberá iný lekár (napríklad prepustenie z nefrologického oddelenia k všeobecnému lekárovi). [1]</p>

<p>Ak sa pacient na plánovanú kontrolu bez predchádzajúcej dohody a ospravedlnenia nedostaví, NCZI stanovuje, že pôvodný dátum predpokladaného trvania sa považuje za deň ukončenia potreby starostlivosti a lekár má eOČR k tomuto dňu v systéme ukončiť. Ak sa pacient vopred dohodne na posune kontroly, nový termín sa musí v systéme zadať ešte pred uplynutím pôvodného dátumu. [1]</p>

<h2>Prechodné obdobie, technické výpadky a papierové odpisy</h2>

<p>Služba eOČR bola spustená 1. augusta 2026. Prechodné obdobie trvá do 31. januára 2027 a povinné používanie pre všetkých poskytovateľov zdravotnej starostlivosti sa začína 1. februára 2027. [1]</p>

<p>Počas prechodného obdobia je prípustný aj listinný postup s klasickými papierovými tlačivami. Nie je však prípustné svojvoľne prepínať formu v rámci jedného otvoreného prípadu. Ak bol prípad založený elektronicky, má sa elektronicky viesť aj ukončiť. Ak nemocnica prepúšťa pacienta a vie, že jeho všeobecný lekár zatiaľ eOČR nepodporuje, NCZI odporúča zvoliť listinný postup už pri vzniku prípadu, aby nevznikla administratívna prekážka pri pokračovaní opatery. [1]</p>

<p>Od pôvodne papierového formulára treba odlíšiť papierový odpis elektronického záznamu. Lekár ho môže vytlačiť na požiadanie pacienta alebo ošetrujúcej osoby (napríklad pre zamestnávateľa alebo iné inštitúcie). Pri technickom výpadku na strane lekára trvajúcom dlhšie ako tri kalendárne dni sa vystavuje náhradný listinný doklad s povinnosťou bezodkladne doplniť elektronický záznam do eZdravia po obnovení prevádzky. [1]</p>

<h2>Najčastejšie chyby v praxi a odporúčania pre nefrologické pracoviská</h2>

<p>Pri rutinnej prevádzke nefrologických ambulancií a oddelení pomáha dodržiavanie niekoľkých zásad predísť administratívnym zlyhaniam:</p>

<ul>
  <li><strong>Vystavenie na príbuzného namiesto pacienta:</strong> eOČR sa vystavuje zásadne na rodné číslo ošetrovaného pacienta. Meno ošetrujúceho rodinného príslušníka lekár do eZdravia nezadáva.</li>
  <li><strong>Zabudnutie na eOČR pri prepustení z nemocnice:</strong> Dlhodobú eOČR po hospitalizácii môže vystaviť len nemocničný lekár najneskôr v deň prepustenia. Ambulantný nefrológ ani všeobecný lekár ju nemôžu po prepustení platne nahradiť.</li>
  <li><strong>Zámena sprevádzania s ošetrovaním:</strong> Samotná preprava na dialyzačné stredisko nezakladá nárok na OČR. Indikáciou je neschopnosť samostatného fungovania v domácom prostredí.</li>
  <li><strong>Paušálne vykazovanie dialýzy ako paliatívneho stavu:</strong> Diagnóza zlyhania obličiek sama osebe neodôvodňuje paliatívnu eOČR. Paliatívny režim je vyhradený pre terminálne štádiá ochorenia.</li>
  <li><strong>Predčasné ukončenie po 14 alebo 90 dňoch:</strong> Vyčerpanie podpornej doby výplaty dávky v Sociálnej poisťovni nie je medicínskym dôvodom na ukončenie eOČR, ak potreba starostlivosti trvá.</li>
  <li><strong>Spätné vystavovanie bez kontaktu s pacientom:</strong> Spoliehanie sa na trojdňovú systémovú toleranciu bez vyšetrenia pacienta vystavuje pracovisko riziku neuznania potvrdenia pri revízii.</li>
</ul>

<h2>Klinické posolstvo</h2>

<p>Elektronická OČR zjednodušuje tok dát medzi poskytovateľom zdravotnej starostlivosti a Sociálnou poisťovňou, nezbavuje však lekára zodpovednosti za vecnú správnosť medicínskeho posúdenia. Kľúčom k bezproblémovému priebehu je odlíšenie medicínskeho záznamu od žiadosti o dávku, včasné vystavenie dlhodobej eOČR pred prepustením z nemocnice a presná dokumentácia funkčného deficitu pacienta v ambulantnom dekurze.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Národné centrum zdravotníckych informácií. FAQs eOČR: najčastejšie otázky a odpovede k elektronickej službe potvrdzovania potreby ošetrovania alebo starostlivosti. Aktualizácia: 5. októbra 2026. <a href="https://www.ezdravotnictvo.sk/sk/sluzby-eocr/-/display/hmPBXU92eCek/content/id/4595030" target="_blank" rel="noopener noreferrer">Oficiálna metodická stránka eZdravie</a>. Prístup: 8. októbra 2026.</em></small></p>
<p><small><em>[2] Sociálna poisťovňa. Ako požiadať o ošetrovné. Postupy pre krátkodobé a dlhodobé ošetrovné vrátane elektronického potvrdenia potreby starostlivosti v eZdraví. <a href="https://www.socpoist.sk/osetrovne" target="_blank" rel="noopener noreferrer">Oficiálny portál Sociálnej poisťovne</a>. Prístup: 8. októbra 2026.</em></small></p>
<p><small><em>[3] Národné centrum zdravotníckych informácií. Informačný newsletter k eOČR: prehľad pravidiel a najčastejších otázok k nasadeniu služby od 1. augusta 2026. <a href="https://nczisk.ecomailapp.cz/public/show/194362/249/8d8d3cfde33072c3f1734c2a7cccf0ba" target="_blank" rel="noopener noreferrer">Informačný materiál NCZI</a>. Prístup: 8. októbra 2026.</em></small></p>
<p><small><em>[4] Národná rada Slovenskej republiky. Zákon č. 461/2003 Z. z. o sociálnom poistení v znení neskorších predpisov (§ 39 až § 43a). <a href="https://www.slov-lex.sk/pravne-predpisy/SK/ZZ/2003/461/" target="_blank" rel="noopener noreferrer">Právny predpis na Slov-Lex</a>.</em></small></p>
<p><small><em>[5] Národná rada Slovenskej republiky. Zákon č. 576/2004 Z. z. o zdravotnej starostlivosti, službách súvisiacich s poskytovaním zdravotnej starostlivosti a o zmene a doplnení niektorých zákonov v znení neskorších predpisov. <a href="https://www.slov-lex.sk/pravne-predpisy/SK/ZZ/2004/576/" target="_blank" rel="noopener noreferrer">Právny predpis na Slov-Lex</a>.</em></small></p>
<p><small><em>[6] Sara N. Davison, et al. Executive summary of the KDIGO Controversies Conference on Supportive Care in Chronic Kidney Disease: developing a roadmap to improving palliative care. <em>Kidney International.</em> 2015;88(3):447–459. DOI: <a href="https://doi.org/10.1038/ki.2015.110" target="_blank" rel="noopener noreferrer">10.1038/ki.2015.110</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25923985/" target="_blank" rel="noopener noreferrer">PubMed PMID 25923985</a>.</em></small></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii: nástroje s nízkym prahom pre krehkých a starších pacientov</a></li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze: multicentrická validácia škály klinickej krehkosti</a></li>
  <li><a href="article.php?slug=ai-scribe-pravne-nastrahy-ambulancia-nefrologia">Právne nástrahy pri používaní AI scribov v ambulancii a čo z toho plynie pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=skor-nez-pacienta-oznacime-nespolupracujuceho">Skôr než pacienta označíme za nespolupracujúceho</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_eocr-nefrologicka-prax-kompetencie-dokumentacia-chyby_article',
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
