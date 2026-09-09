<?php
/**
 * Odborný článok: Porucha čuchu u hemodialyzovaných pacientov, jej väzba na kogníciu a albumín.
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
    'title'        => 'Porucha čuchu u hemodialyzovaných pacientov: častý, ale prehliadaný ukazovateľ celkovej chorobnosti',
    'slug'         => 'porucha-cuchu-hemodialyza-kognicia-albumin',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V tureckej prospektívnej štúdii malo poruchu identifikácie pachov 91 % hemodialyzovaných pacientov. Lepší čuch súvisel s vyššou kogníciou a albumínom, nie s dialyzačnou primeranosťou Kt/V.',
    'content'      => <<<'HTML'
<p>Porucha čuchu patrí medzi najmenej sledované komplikácie chronickej choroby obličiek (CKD). U pacientov na pravidelnej hemodialýze (HD) môže znižovať pôžitok z jedla, meniť výber potravín, prispievať k nechutenstvu a zhoršovať kvalitu života. Potenciálne súvisí aj s kognitívnou poruchou, zápalom, nutričným stavom a celkovou záťažou ochorenia.</p>

<p>Prospektívna observačná štúdia z Ankary, publikovaná v <em>Journal of Nephrology</em>, porovnala schopnosť identifikovať pachy u 100 hemodialyzovaných pacientov a 52 zdravých kontrolných osôb. U časti pacientov sa vyšetrenie zopakovalo približne po roku.</p>

<p>Výsledky ukázali výrazne horšiu identifikáciu pachov u dialyzovaných pacientov — poruchu malo <strong>91 %</strong> z nich. Lepšia čuchová výkonnosť súvisela s vyšším kognitívnym skóre a vyššou koncentráciou sérového albumínu. Súvislosť s dialyzačnou primeranosťou vyjadrenou pomocou Kt/V sa nepreukázala.</p>

<p>Zásadný je práve tento kontrast: porucha čuchu sa v tejto kohorte javí skôr ako <strong>odraz celkovej chorobnosti a zraniteľnosti pacienta než ako dôsledok nedostatočnej dialyzačnej dávky</strong>.</p>

<h2>Usporiadanie štúdie</h2>

<p>Do prospektívnej observačnej štúdie bolo zaradených 100 pacientov na udržiavacej hemodialýze najmenej tri mesiace a 52 zdravých kontrolných osôb bez známeho chronického systémového ochorenia a bez pravidelnej farmakoterapie. Skupiny boli porovnateľné podľa veku a zastúpenia pohlaví.</p>

<p>Vylúčení boli pacienti s aktívnym ochorením nosa alebo prinosových dutín, nedávnou infekciou horných dýchacích ciest, závažným neurologickým alebo psychiatrickým ochorením a osoby užívajúce lieky, ktoré môžu ovplyvniť čuch.</p>

<p>Vyšetrenia dialyzovaných pacientov sa robili <strong>pred hemodialýzou v strede týždňa</strong>. Toto zjednotenie je metodicky dôležité — obmedzuje variabilitu z rozdielnej dĺžky medzidialyzačného intervalu aj z bezprostredného účinku samotnej procedúry, ktorý staršie práce opísali ako významný.</p>

<h3>Ako sa čuch meral</h3>

<p>Autori použili identifikačnú časť testu Sniffin' Sticks: pri každom pachu účastník vyberal jednu zo štyroch možností a výsledok sa vyjadril ako percento správne identifikovaných pachov. Kategórie boli normosmia od 80 %, hyposmia 50 až 79 % a anosmia pod 50 %.</p>

<p>Tieto hranice boli vytvorené na opisné účely v rámci štúdie a nemožno ich považovať za univerzálne diagnostické kritériá.</p>

<p><strong>Podstatné obmedzenie:</strong> úplné vyšetrenie testom Sniffin' Sticks zahŕňa tri zložky — prah vnímania pachu, rozlišovanie pachov a identifikáciu (súhrnne skóre TDI). Táto štúdia merala <em>iba identifikáciu</em>. Práve tá je pritom najviac závislá od pamäti, pozornosti, jazyka, kultúrnej známosti pachov a kognitívneho stavu. Výsledok teda nevystihuje celú čuchovú funkciu a čiastočne meria aj kogníciu — čo treba mať na pamäti pri interpretácii hlavného nálezu.</p>

<h2>Základné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Identifikácia pachov u hemodialyzovaných pacientov a kontrolných osôb" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Hemodialýza (n = 100)</th>
      <th scope="col">Kontroly (n = 52)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Priemerné skóre identifikácie</th>
      <td>60,6 %</td>
      <td>76,1 %</td>
    </tr>
    <tr>
      <th scope="row">Normosmia</th>
      <td>9 %</td>
      <td>55,8 %</td>
    </tr>
    <tr>
      <th scope="row">Hyposmia</th>
      <td>74 %</td>
      <td>40,4 %</td>
    </tr>
    <tr>
      <th scope="row">Anosmia</th>
      <td>17 %</td>
      <td>3,8 %</td>
    </tr>
  </tbody>
</table>
<p><small>Rozdiel v priemernom skóre aj v rozdelení kategórií bol štatisticky významný (P &lt; 0,001).</small></p>
</div>

<p>Hodnota 91 % (súčet hyposmie a anosmie) závisí od definícií použitých autormi a nemožno ju bez ďalšej validácie brať ako presný odhad prevalencie klinicky diagnostikovanej čuchovej poruchy. Rád veličiny je však konzistentný s inými prácami: v talianskej prierezovej štúdii malo poruchu čuchu 75,5 % hemodialyzovaných a 93,3 % pacientov na peritoneálnej dialýze.</p>

<p>Pozoruhodné je, že aj <strong>44,2 % zdravých kontrolných osôb</strong> bolo zaradených ako hyposmické alebo anosmické. To nie je nutne chyba: v bežnej populácii má poruchu čuchu vyše 50 % ľudí vo veku 65 až 80 rokov a približne 75 % ľudí nad 80 rokov. Pri strednom veku okolo 57 rokov je 44 % stále vysoké číslo, ktoré skôr naznačuje prísne kategorizačné hranice alebo obmedzenú kultúrnu rozpoznateľnosť použitých pachov. Klinicky to znamená, že rozdiel medzi skupinami je dôveryhodnejší než absolútna prevalencia.</p>

<h2>Súvislosť s kognitívnymi funkciami</h2>

<p>V mnohorozmernom modeli zostala vyššia kognitívna výkonnosť nezávisle spojená s lepším čuchovým skóre (β = 0,42; P = 0,001).</p>

<p>Asociácia má niekoľko možných vysvetlení. Identifikácia pachu vyžaduje nielen zachované periférne čuchové dráhy, ale aj pozornosť, vybavenie z pamäti, sémantické spracovanie a výber správnej odpovede. Horší výsledok preto nemusí znamenať izolované poškodenie čuchového epitelu.</p>

<p>Čuchová porucha tak môže byť markerom centrálneho neurologického postihnutia, cievneho poškodenia, kognitívnej zraniteľnosti alebo celkovej záťaže uremického ochorenia. Štúdia však neumožňuje určiť smer ani príčinnosť tohto vzťahu — a pri meraní samotnej identifikácie sa časť asociácie môže vysvetliť aj tým, že oba testy sčasti merajú to isté.</p>

<h2>Súvislosť so sérovým albumínom</h2>

<p>Po úprave o vek, pohlavie a kognitívne skóre zostal vyšší albumín nezávisle spojený s lepšou identifikáciou pachov (β = 0,29; P = 0,015).</p>

<p>Tento výsledok neznamená, že nízky albumín poruchu čuchu spôsobuje. Sérový albumín je u hemodialyzovaných pacientov ovplyvnený zápalom, komorbiditami, stratami bielkovín, hydratáciou, funkciou pečene a distribučným objemom. <strong>Nie je čistým ukazovateľom príjmu bielkovín ani samostatným markerom malnutrície.</strong></p>

<p>Možné sú oba smery vzťahu: horší čuch môže znižovať pôžitok z jedla a príjem potravy, alebo celková chorobnosť, zápal a proteínovo-energetické chradnutie môžu súčasne znižovať albumín aj čuchovú výkonnosť. Štúdia neobsahovala komplexné nutričné hodnotenie, preto mechanizmus overiť nemohla.</p>

<h2>Vývoj počas jedného roka</h2>

<p>Opakované vyšetrenie po približne roku absolvovalo 60 zo 100 pacientov. Na úrovni celej skupiny sa nepreukázal významný priemerný pokles, výsledky jednotlivých pacientov sa však výrazne líšili. Najsilnejším nezávislým prediktorom následnej zmeny bola <strong>východisková čuchová výkonnosť</strong> (β = 0,012; P = 0,006), zatiaľ čo Kt/V s vývojom čuchu spojené nebolo.</p>

<p>Interpretácia východiskového skóre ako prediktora si vyžaduje opatrnosť. Takýto vzťah môže sčasti odrážať matematickú väzbu medzi východiskovou hodnotou a zmenovým skóre, stropový a podlahový efekt alebo regresiu k priemeru. Z publikovaného opisu nemožno odvodiť klinicky použiteľný prah na predpoveď individuálnej progresie.</p>

<p>Zásadné je, že 40 pacientov sledovanie nedokončilo — okrem prechodu do iného centra a odmietnutia išlo aj o interkurentné ochorenia, hospitalizácie, transplantácie a úmrtia. Vzniká tak riziko výberového skreslenia: pacienti s horšou prognózou, kogníciou a pravdepodobne aj čuchom v analýze zmeny chýbajú. Záver „bez významného priemerného zhoršenia“ sa preto týka predovšetkým tých, ktorí boli schopní kontrolné vyšetrenie absolvovať.</p>

<h2>Dialyzačná primeranosť a čuch</h2>

<p>Kt/V nebolo spojené s východiskovou ani s longitudinálnou čuchovou výkonnosťou. Výsledok nepodporuje jednoduchú predstavu, že vyššia dávka dialýzy automaticky znamená lepší čuch. Nemožno z neho však vyvodiť, že odstraňovanie uremických toxínov je bez významu.</p>

<p>Kt/V vyjadruje predovšetkým klírens močoviny. Nevystihuje klírens stredne veľkých molekúl, kumulatívnu expozíciu uremickým toxínom, reziduálnu funkciu obličiek, zápal, hemodynamickú toleranciu dialýzy, opakované osmotické zmeny, cerebrálnu hypoperfúziu ani nutričný stav.</p>

<p>Dôkazy z iných prác sú navyše nejednotné. Talianska prierezová štúdia našla negatívnu koreláciu skóre TDI so sérovou močovinou (β = −0,03; P &lt; 0,001) a hraničný pozitívny vzťah ku Kt/V (β = 0,01; P = 0,054). Staršie práce z rokov 1987 a 1989 opísali <em>zhoršenie</em> čuchu bezprostredne po dialýze napriek poklesu uremických toxínov, zatiaľ čo švajčiarska práca z roku 2011 zaznamenala hodinu po dialýze naopak zlepšenie identifikácie o 14,5 %. Systematický prehľad hodnotí istotu dôkazov o vplyve dialýzy na čuch ako <strong>veľmi nízku</strong>.</p>

<h2>Možné mechanizmy</h2>

<p>Patogenéza je pravdepodobne multifaktoriálna. Uvažuje sa o uremickej neurotoxicite, chronickom zápale a oxidačnom strese, poškodení čuchového epitelu, bulbu aj centrálneho spracovania pachov, poruche hematoencefalickej bariéry, cerebrovaskulárnom ochorení, cievnej kalcifikácii a endotelovej dysfunkcii so znížením mozgového prietoku, kognitívnej poruche, autonómnej dysfunkcii, nedostatku mikronutrientov, diabete, liekových účinkoch, opakovaných hemodynamických a osmotických zmenách počas dialýzy, chronickom sinonazálnom ochorení a fajčení.</p>

<p>Zdrojová štúdia viaceré príčiny vylučovala už pri výbere pacientov, konkrétny mechanizmus však určiť nedokázala — ani to, či porucha vznikla pred začatím dialýzy alebo až počas nej.</p>

<h2>Prečo na to myslieť: pacienti o poruche nevedia</h2>

<p>Najdôležitejší praktický argument pre aktívne hľadanie je nízke povedomie pacientov. Podľa prehľadovej literatúry si <strong>menej než 25 % ľudí s poruchou čuchu svoj stav uvedomuje, kým nie sú formálne otestovaní</strong>. V talianskej štúdii dialyzovaných pacientov subjektívne sebahodnotenie s objektívnym skóre TDI vôbec nekorelovalo (P = 0,293).</p>

<p>Spoliehať sa na to, že pacient poruchu čuchu spontánne nahlási, teda nefunguje.</p>

<h3>Nutričný stav</h3>

<p>Porucha čuchu môže znižovať intenzitu vnímania arómy, pôžitok z jedla a chuť do jedla. Môže podporovať jednostranný výber výrazne sladkých alebo slaných potravín, čo je problematické pri hypertenzii, objemovom preťažení, diabete a CKD. Súvislosť s malnutríciou však zostáva prevažne observačná — nie je dokázané, že liečba čuchovej poruchy znižuje výskyt proteínovo-energetického chradnutia, hospitalizácií alebo mortality.</p>

<h3>Bezpečnosť</h3>

<p>Výrazná hyposmia alebo anosmia znižuje schopnosť rozpoznať dym a požiar, únik plynu, pokazené potraviny a chemické látky. Pacienta so závažnou poruchou treba poučiť o používaní detektorov dymu a plynu, o kontrole dátumu spotreby a o opatrnosti pri skladovaní potravín. Ide o jednoduché opatrenie s potenciálne veľkým dosahom.</p>

<h3>Kognitívna porucha</h3>

<p>Postupné zhoršenie identifikácie pachov môže byť dôvodom na orientačné posúdenie kognitívnych funkcií. Čuchový test však nemožno používať ako samostatný skríning demencie — výsledok ovplyvňuje vzdelanie, jazyk, kultúrna známosť pachov, depresia, zrak, sluch aj schopnosť porozumieť pokynom.</p>

<h2>Možnosti liečby</h2>

<p>Systematický prehľad z roku 2025 identifikoval iba osem intervenčných a observačných štúdií so 469 pacientmi s CKD, publikovaných v rokoch 1987 až 2023. Išlo o tri prípadovo-kontrolné, tri prierezové štúdie, jednu randomizovanú štúdiu a jednu pilotnú štúdiu. Autori istotu dôkazov formálne ohodnotili metódou GRADE:</p>

<div class="table-responsive" role="region" aria-label="Istota dôkazov podľa GRADE pre jednotlivé intervencie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Intervencia</th>
      <th scope="col">Počet štúdií (účastníkov)</th>
      <th scope="col">Istota dôkazov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Čuchový tréning</th>
      <td>1 (19)</td>
      <td>stredná</td>
    </tr>
    <tr>
      <th scope="row">Kurkumín</th>
      <td>1 (20)</td>
      <td>nízka</td>
    </tr>
    <tr>
      <th scope="row">Transplantácia obličky</th>
      <td>2 (78)</td>
      <td>nízka</td>
    </tr>
    <tr>
      <th scope="row">Intranazálny teofylín</th>
      <td>1 (7)</td>
      <td>veľmi nízka</td>
    </tr>
    <tr>
      <th scope="row">Dialýza (HD alebo PD)</th>
      <td>6 (245)</td>
      <td>veľmi nízka</td>
    </tr>
  </tbody>
</table>
</div>

<h3>Čuchový tréning</h3>

<p>Ide o najsľubnejšiu nefarmakologickú možnosť a jedinú s hodnotením strednej istoty. V randomizovanej štúdii z Iránu pacienti počas 12 týždňov vdychovali <strong>štyri známe pachy — levanduľu, citrón, škoricu a eukalyptus — vždy 20 sekúnd, dvakrát denne</strong>. Objektívne skóre identifikácie sa zlepšilo z 15,3 na 18,8 bodu (P = 0,001), dotazník ťažkostí z 19,0 na 12,2 bodu (P = 0,003) a sebahodnotenie zo 6,8 na 8,2 bodu (P = 0,027). Normosmiu dosiahlo <strong>36,8 % pacientov</strong> oproti nikomu na začiatku.</p>

<p>Postup je lacný, neinvazívny a bezpečný. Napriek tomu ide o jedinú štúdiu s 19 pacientmi v tréningovej vetve, takže čuchový tréning zatiaľ nemožno označiť za štandardnú nefrologickú liečbu s preukázaným vplyvom na výživu alebo klinické výsledky.</p>

<h3>Kurkumín</h3>

<p>V tej istej randomizovanej štúdii kurkumín v dávke 500 mg dvakrát denne počas 12 týždňov zlepšil dotazníkové a sebahodnotiace skóre (P = 0,045, resp. 0,047), <strong>objektívne skóre identifikácie sa však významne nezlepšilo</strong> (P = 0,066). Normosmiu dosiahlo 20 % pacientov. Čuchový tréning bol účinnejší.</p>

<h3>Intranazálny teofylín</h3>

<p>V nekontrolovanej pilotnej štúdii so siedmimi pacientmi zlepšilo podávanie 20 mg denne do každej nosovej dierky počas šiestich týždňov identifikáciu pachov u piatich z nich (71 %), pričom traja sa posunuli o jednu kategóriu. Liečba bola dobre tolerovaná bez nežiaducich udalostí. Takýto dôkaz s istotou hodnotenou ako veľmi nízka nestačí na rutinné používanie.</p>

<h3>Zinok a ďalšie doplnky</h3>

<p>Zinok sa nemá podávať iba na základe poruchy čuchu alebo chuti bez posúdenia jeho deficitu a rizík dlhodobej suplementácie. Ďalšie postupy skúšané pri iných príčinách čuchovej poruchy — lokálne kortikosteroidy, vitamín A, omega-3 mastné kyseliny, podanie plazmy bohatej na doštičky alebo akupunktúra — neboli u pacientov s CKD priamo skúmané.</p>

<h3>Transplantácia obličky</h3>

<p>Observačné práce naznačujú najúplnejšie zotavenie čuchu práve po transplantácii: skóre TDI dosahovalo 31,6 oproti 32,3 u zdravých kontrol a poruchu malo len 34 % príjemcov oproti viac než 75 % dialyzovaných pacientov. Transplantácia však nie je liečbou anosmie a nemožno ju indikovať pre senzorickú poruchu — zlepšenie čuchu je sprievodným dôsledkom obnovenej funkcie obličiek.</p>

<h2>Praktický postup v dialyzačnom centre</h2>

<p>Na poruchu čuchu je vhodné cielene myslieť pri nevysvetliteľnom nechutenstve, úbytku hmotnosti, nízkom príjme potravy, poklese albumínu, kognitívnej zmene alebo sťažnostiach na zmenenú chuť jedla.</p>

<ol>
  <li>Zistiť čas vzniku a dynamiku ťažkostí.</li>
  <li>Odlíšiť poruchu čuchu od poruchy chuti.</li>
  <li>Zvážiť nedávnu infekciu vrátane ochorenia COVID-19.</li>
  <li>Vyšetriť ochorenia nosa a prinosových dutín.</li>
  <li>Posúdiť neurologické ochorenia a kognitívne funkcie.</li>
  <li>Zohľadniť fajčenie a pracovné expozície.</li>
  <li>Skontrolovať lieky.</li>
  <li>Vykonať nutričný skríning a posúdiť zápal a objemový stav.</li>
  <li>Poučiť pacienta o bezpečnostných opatreniach.</li>
  <li>Odoslať na otorinolaryngologické alebo neurologické vyšetrenie podľa klinického obrazu.</li>
</ol>

<p>Náhle vzniknutá anosmia, jednostranné príznaky, neurologický deficit, krvácanie z nosa alebo príznaky expanzívneho procesu vyžadujú osobitnú diagnostickú pozornosť.</p>

<h2>Kritické zhodnotenie zdrojovej štúdie</h2>

<h3>Silné stránky</h3>

<p>Prospektívny dizajn, zdravá kontrolná skupina porovnateľná podľa veku a pohlavia, štandardizované psychofyzikálne testovanie, jednotné načasovanie vyšetrenia pred hemodialýzou, jednoročné sledovanie časti pacientov a zohľadnenie východiskového skóre pri analýze zmeny.</p>

<h3>Obmedzenia</h3>

<ul>
  <li>jednocentrový a exploračný charakter,</li>
  <li>opakované vyšetrenie absolvovalo iba 60 % pacientov, s možným skreslením prežívaním a stratou chorších pacientov,</li>
  <li>hodnotená bola iba identifikácia pachov, nie prah a rozlišovanie,</li>
  <li>opisné, nie validované hranice normosmie, hyposmie a anosmie,</li>
  <li>chýbajúce komplexné nutričné hodnotenie,</li>
  <li>chýbajúca skupina pacientov v skorších štádiách CKD,</li>
  <li>obmedzené meranie dialyzačnej expozície iba pomocou Kt/V,</li>
  <li>malý počet pacientov bez čuchovej dysfunkcie, ktorý limituje porovnania,</li>
  <li>viacnásobné štatistické porovnávania,</li>
  <li>možnosť reziduálneho skreslenia nezmeranými faktormi.</li>
</ul>

<h3>Asociácia nie je príčinnosť</h3>

<p>Štúdia nepreukázala, že nízky albumín spôsobuje poruchu čuchu, že porucha čuchu spôsobuje malnutríciu, že kognitívna porucha je príčinou horšieho čuchu, že zvýšenie Kt/V nemôže čuch zlepšiť ani že porucha čuchu predpovedá mortalitu. Preukázala asociácie v konkrétnej skupine klinicky stabilných hemodialyzovaných pacientov.</p>

<h2>Záver</h2>

<p>Porucha identifikácie pachov bola u hemodialyzovaných pacientov podstatne častejšia než u zdravých kontrolných osôb — podľa kategórií použitých autormi ju malo 91 % pacientov oproti 44 % kontrol. Lepšia čuchová výkonnosť súvisela s vyšším kognitívnym skóre a vyšším albumínom, nie s Kt/V. Počas roka sa na úrovni skupiny nepreukázal významný priemerný pokles, individuálne trajektórie však boli veľmi rozdielne.</p>

<p>Čuchová dysfunkcia sa tak javí ako prejav celkovej chorobnosti a zraniteľnosti pacienta, nie ako izolovaný následok nedostatočnej dialyzačnej dávky. Pri nechutenstve, chudnutí, nízkom albumíne alebo kognitívnych ťažkostiach má zmysel na ňu cielene myslieť — najmä preto, že pacienti si ju sami spravidla neuvedomia.</p>

<p>Zatiaľ však chýbajú dôkazy, že rutinný skríning alebo špecifická liečba zlepšujú výživu, kvalitu života, hospitalizácie alebo mortalitu. Z dostupných možností má najlepšie hodnotenie istoty dôkazov čuchový tréning — lacná a bezpečná intervencia, ktorú možno u vhodného pacienta ponúknuť, no zatiaľ na podklade jedinej malej randomizovanej štúdie.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy, cievne poškodenie a klinické dôsledky</a></li>
  <li><a href="article.php?slug=indoxyl-sulfat-kognitivne-zhorsenie-ckd">Indoxyl sulfát a kognitívne zhoršenie pri chronickej chorobe obličiek: čo vieme z derivátov tryptofánu</a></li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR</a></li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Yıldırım S, Turgay G, Bal AZ, Tutal E, Sezer S. Olfactory dysfunction in hemodialysis patients: baseline differences and longitudinal changes compared with healthy controls. Journal of Nephrology. 2026. doi: 10.1093/joneph/aajag186. PMID 42687747. <a href="https://pubmed.ncbi.nlm.nih.gov/42687747/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj; v čase spracovania publikácia pred zaradením do čísla.</em></small></li>
  <li><small><em>Iravani K, Fereydoonnezhad T, Doostkam A, Malekmakan L. Therapeutic strategies for olfactory impairment in patients with chronic kidney disease: a systematic review. BMC Nephrology. 2025;26(1):658. doi: 10.1186/s12882-025-04569-3. PMID 41272496. PROSPERO CRD42025638124. <a href="https://pubmed.ncbi.nlm.nih.gov/41272496/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12639697/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>. Zdroj údajov o liečbe, hodnotenia GRADE a porovnávacích čísel z jednotlivých zaradených prác.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_porucha-cuchu-hemodialyza-kognicia-albumin_article',
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
