<?php
/**
 * add_nutcracker-syndrom-lava-renalna-vena-diagnostika-liecba_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: syndróm luskáčika (nutcracker syndrome) —
 * symptomatické stlačenie ľavej renálnej vény. Odlíšenie od nutcracker
 * fenoménu, patofyziológia, nefrologická diferenciálna diagnostika (vrátane
 * prekryvu s IgA nefropatiou), diagnostické prahy a ich neistota, prehľad
 * liečebných možností vrátane výsledkov systematického prehľadu 2025
 * a Delphi konsenzu 2025.
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie viacerých zdrojov
 * (Mačionienė 2026 Clin Kidney J, Sarikaya 2025 Ann Vasc Surg, Ananthan 2017
 * EJVES, Kolber 2021 Cardiovasc Diagn Ther, Kurklinsky 2010 Mayo Clin Proc) —
 * nie preklad jedného zdrojového článku, preto sa do source_authors.php
 * nedopĺňajú pôvodní autori.
 *
 * Číselné údaje overené proti plnému textu prehľadu Clin Kidney J 2026
 * (PMC13156603) a abstraktom v PubMede (PMID 42111894, 40816484, 28356209,
 * 34815965, 20511485).
 * Postup: git commit (SFTP deploy) → spustenie cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Syndróm luskáčika (nutcracker): kedy stlačenie ľavej renálnej vény naozaj vysvetľuje hematúriu',
    'slug'         => 'nutcracker-syndrom-lava-renalna-vena-diagnostika-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Stlačenie ľavej renálnej vény sa na CT nájde u desiatok percent zdravých darcov obličky – syndróm z toho má zlomok z nich. Prehľad toho, čím sa nutcracker syndróm líši od nutcracker fenoménu, prečo môže napodobňovať aj sprevádzať IgA nefropatiu, aké diagnostické prahy existujú (a prečo ani jeden nie je konsenzuálny) a ako dopadli jednotlivé liečebné postupy v systematickom prehľade z roku 2025.',
    'content'      => <<<'HTML'
<figure><a href="img/nutcracker-syndrom-lava-renalna-vena.webp" rel="noopener noreferrer" target="_blank"><img src="img/nutcracker-syndrom-lava-renalna-vena.webp" alt="Modrá žila stlačená takmer naplocho v čeľustiach luskáčika tvoreného dvoma tepnami; za miestom stlačenia sa žila vydúva pod tlakom a uniká z nej prúd červených krviniek smerom k priesvitne svietiacej obličke" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie anatomický atlas ani záznam konkrétneho pacienta (strany sú zrkadlovo obrátené oproti anatomickej orientácii). Podstata syndrómu je v obraze celá: žila zovretá medzi dvoma tepnami, pretlak za miestom zovretia a erytrocyty, ktoré sa cez prasknuté fornixové venuly dostanú do zberného systému.</figcaption></figure>

<p>Máloktorá diagnóza ilustruje rozdiel medzi <em>nálezom</em> a <em>chorobou</em> tak dobre ako syndróm luskáčika. Stlačenie ľavej renálnej vény je na modernom CT bežný nález – a u väčšiny ľudí, ktorí ho majú, nespôsobuje nič. U malej menšiny je príčinou hematúrie, ktorá roky uniká vysvetleniu, bolesti v ľavom boku, ortostatickej proteinúrie alebo chronickej panvovej bolesti.</p>

<p>Nefrológ sa k tejto diagnóze dostáva najčastejšie oklukou: ako k možnému vysvetleniu hematúrie po tom, čo urologické a glomerulové vyšetrenie vyšlo naprázdno. Práve v tejto situácii je riziko omylu najväčšie, a to v oboch smeroch – syndróm možno prehliadnuť, ale aj mu prisúdiť príznaky, ktoré spôsobuje niečo iné.</p>

<h2>Dva pojmy, ktoré nie sú zameniteľné</h2>

<div class="table-responsive" role="region" aria-label="Rozdiel medzi nutcracker fenoménom a nutcracker syndrómom" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Pojem</th><th scope="col">Čo znamená</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Nutcracker fenomén (NCP)</th><td>Tá istá anatomická kompresia ľavej renálnej vény, ale <strong>bez príznakov</strong>. Je to rádiologický nález, nie diagnóza.</td></tr>
    <tr><th scope="row">Nutcracker syndróm (NCS)</th><td><strong>Symptomatické</strong> stlačenie ľavej renálnej vény – anatomický nález <em>plus</em> klinický obraz, ktorý mu zodpovedá a ktorý nevysvetľuje nič iné.</td></tr>
  </tbody>
</table>
</div>

<p>Rozlíšenie má praktický význam. Prevalenčné údaje ukazujú, aký veľký je rozdiel medzi oboma pojmami:</p>

<ul>
  <li>V kohorte <strong>324 asymptomatických kandidátov na darcovstvo obličky</strong> vyšetrených CT angiografiou malo <strong>30,5 %</strong> aortomezenterický uhol pod 41°, <strong>15,3 %</strong> takzvaný „beak sign“ – ale kritérium výrazného pomeru priemerov (≥ 4,9) spĺňalo len <strong>0,7 %</strong>.</li>
  <li>V inej sérii 99 potenciálnych darcov malo <strong>23 %</strong> na CT angiografii 50 až 70 % stenózu ľavej renálnej vény.</li>
  <li>V kórejskej kohorte pacientov odoslaných na nefrologické vyšetrenie a hodnotených dopplerovskou sonografiou bol nutcracker <em>fenomén</em> diagnostikovaný asi u <strong>30 %</strong> a <em>syndróm</em> asi u <strong>15 %</strong>.</li>
</ul>

<p>V nefrologickej ambulancii teda môže ísť o podstatne častejšiu diagnózu, než naznačuje označenie „zriedkavé ochorenie“ – v zdravej populácii je však samotný nález takmer bezvýznamný. <strong>Rádiologický nález kompresie nikdy nestačí na diagnózu.</strong></p>

<h2>Anatómia a čísla, ktoré za tým stoja</h2>

<p>Asi <strong>85 až 90 %</strong> prípadov predstavuje <strong>predná (anteriórna)</strong> forma: ľavá renálna véna je zovretá v normálnej polohe medzi brušnou aortou a arteria mesenterica superior. Menej častá <strong>zadná (posteriórna)</strong> forma vzniká pri retroaortálnom priebehu vény, ktorá je potom stlačená medzi aortou a chrbticou. Zriedkavo je kompresívnou štruktúrou aberantná pravá renálna artéria – a v niektorých populáciách môže byť podľa novších prác dokonca častejšia než klasický mezenterický variant.</p>

<div class="table-responsive" role="region" aria-label="Aortomezenterický uhol a vzdialenosť: normálne hodnoty a hodnoty spojené s kompresiou" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Parameter</th><th scope="col">U zdravých dospelých</th><th scope="col">Hodnoty spojené s významnou kompresiou</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Aortomezenterický uhol</th><td>38° – 65° (na CT/MR angiografii sa uvádza aj 45° – 90°)</td><td>pod 25° – 35°</td></tr>
    <tr><th scope="row">Aortomezenterická vzdialenosť</th><td>4 – 18 mm</td><td>≤ 3 – 5 mm</td></tr>
    <tr><th scope="row">Tlakový gradient ľavá renálna véna – dolná dutá žila</th><td>&lt; 1 mmHg</td><td>u symptomatických spravidla ≥ 3 mmHg (často 4 – 15 mmHg)</td></tr>
  </tbody>
</table>
<p><em>Podľa prehľadu Mačionienė a kol., Clinical Kidney Journal 2026. Pozor: ide o orientačné hodnoty – konsenzus o hraničných hodnotách neexistuje.</em></p>
</div>

<p>Zúženie aortomezenterického priestoru je pravdepodobnejšie u osôb, ktoré sú <strong>veľmi štíhle</strong> (málo retroperitoneálneho a mezenterického tuku), majú <strong>výraznú driekovú lordózu</strong>, <strong>nízko uloženú ľavú obličku</strong> (renálna ptóza), alebo prekonali <strong>rýchly rast v adolescencii, tehotenstvo či výrazný úbytok hmotnosti</strong>. V praxi je tento zoznam užitočný: ak sa niektorý z faktorov nájde v anamnéze mladej štíhlej pacientky s nevysvetlenou hematúriou, pravdepodobnosť diagnózy podstatne stúpa.</p>

<h3>Prečo vznikajú príznaky</h3>

<p>Vysoký tlak v renálnom venóznom riečisku sa šíri späť do drobných ciev vnútri obličky, hoci arteriálne zásobenie zostáva normálne. Vzniká kongescia, znížená efektívna perfúzia a stav <strong>relatívnej renálnej ischémie</strong>. Výpočtové simulácie prúdenia ukazujú, že čím tesnejšia je kompresia, tým rýchlejšie krv preteká zúžením – s turbulenciou, vysokým šmykovým napätím na stenu a výrazným vzostupom tlaku pred prekážkou.</p>

<p>Prečo väčšina ľudí s rovnakým anatomickým nálezom nemá ťažkosti, vysvetľujú kolaterály: <strong>dobre vyvinuté kolaterálne žily tlak na obličku čiastočne odľahčia</strong>. To je aj dôvod, prečo závažnosť príznakov zle koreluje s tým, ako dramaticky kompresia vyzerá na obrázku.</p>

<h2>Klinický obraz: čo hľadať</h2>

<ul>
  <li><strong>Hematúria</strong> (v sériách 13 % až 100 % pacientov) vzniká, keď pretlak rozšíri drobné venuly okolo renálnych fornixov, až prasknú do zberného systému. Býva mikroskopická, ale môže byť aj makroskopická. Pri cystoskopii krváca <strong>len ľavý ureter</strong> a erytrocyty majú <strong>normálny tvar</strong> (neglomerulová, izomorfná hematúria).</li>
  <li><strong>Bolesť v ľavom boku</strong> – tupá, spôsobená akútnym napätím renálneho puzdra a kongesciou parenchýmu. U adolescentov a dospelých býva dominantnou ťažkosťou. <em>Atypická pravostranná</em> bolesť je možná pri krížovom plnení cez lumbálne alebo renolumbálne kolaterály.</li>
  <li><strong>Ortostatická proteinúria.</strong> V stoji sa aortomezenterický uhol zúži (gravitácia ťahá črevá nadol), tlak v ľavej renálnej véne prudko stúpne. Pretlak dráždi renálne baroreceptory a chemoreceptory, lokálne sa uvoľní noradrenalín a angiotenzín II, nastane prevažne eferentná arteriolárna vazokonstrikcia, prechodný vzostup glomerulového kapilárneho tlaku a <strong>reverzibilné narušenie filtračnej bariéry</strong>. Oba ortostatické príznaky sa typicky zlepšia alebo vymiznú po ľahnutí.</li>
  <li><strong>Varikokéla u mužov</strong> – v 20 až 40 % prípadov NCS, ľavostranná. Pri recidivujúcej alebo atypickej varikokéle má stlačenie ľavej renálnej vény patriť do úvahy, najmä ak ju sprevádza hematúria alebo bolesť boku. Zriedkavo je varikokéla jediným prejavom.</li>
  <li><strong>Syndróm panvovej kongescie u žien</strong> – retrográdny prenos tlaku do ľavej ovariálnej vény vedie k panvovým varixom a chronickej panvovej bolesti, často s dyspareuniou, dysmenoreou a posturálnym kolísaním ťažkostí.</li>
  <li><strong>Sekundárna hypertenzia</strong> – zriedkavý, ale dôležitý prejav. V <strong>5 až 15 %</strong> prípadov oblička zareaguje na zníženú perfúziu uvoľnením renínu a aktiváciou systému renín-angiotenzín; pridáva sa sympatiková aktivácia. Výsledkom môže byť skutočná, niekedy posturálna alebo rezistentná hypertenzia.</li>
</ul>

<h2>Nefrologická pasca: prekryv s IgA nefropatiou</h2>

<p>Toto je bod, ktorý sa v cievne orientovaných prehľadoch zvykne stratiť, a pre nefrológa je pritom najdôležitejší. <strong>Proteinúria a hematúria sú zároveň typickými prejavmi IgA nefropatie</strong>, najčastejšej primárnej glomerulopatie – takže obe jednotky sa navzájom napodobňujú.</p>

<p>Situáciu ďalej komplikuje to, že publikované kazuistiky opisujú <strong>súčasný výskyt</strong> IgA nefropatie a nutcracker syndrómu, pričom v niektorých prípadoch hematúria ustúpila až po výkone, ktorý odstránil kompresiu vény. Z toho plynie praktický záver, ktorý ide proti bežnému uvažovaniu:</p>

<p><strong>Biopsiou potvrdená IgA nefropatia nutcracker syndróm nevylučuje.</strong> Ak proteinúria alebo hematúria u pacienta s dokázanou IgA nefropatiou neodpovedá tak, ako by mala – najmä ak má ortostatický charakter, je prísne jednostranná alebo sprevádzaná ľavostrannou bolesťou boku – stojí za to na kompresiu ľavej renálnej vény pomyslieť. Širší kontext IgA nefropatie rozoberá <a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">článok o algoritme podľa KDIGO 2025</a>.</p>

<p>Rovnako platí opačný smer: pri podozrení na nutcracker treba <em>najprv</em> vylúčiť glomerulové príčiny. Nález <strong>dysmorfných erytrocytov, erytrocytových valcov, poklesu eGFR alebo neortostatickej pretrvávajúcej proteinúrie</strong> svedčí pre glomerulovú etiológiu – a syndróm luskáčika ju nevysvetlí. Praktický postup pri hematúrii rozoberá <a href="article.php?slug=vysetrenie-hematurie-nefrologicka-prax-algoritmus">samostatný článok o vyšetrení hematúrie</a>.</p>

<h2>Diagnostika: postupnosť, nie jeden test</h2>

<p>Diagnóza stojí na stupňovitom postupe: <strong>klinické podozrenie trvajúce viac než 6 mesiacov</strong>, vylúčenie iných príčin a až potom zobrazovanie.</p>

<h3>1) Dopplerovská sonografia – prvá voľba, nikdy nie jediná</h3>

<p>Je neinvazívna, dostupná a umožňuje merať rýchlosť prietoku. Udávaná <strong>senzitivita 69 až 90 %</strong>, <strong>špecificita 89 až 100 %</strong>. Diagnostickým kritériom je <strong>pomer vrcholovej systolickej rýchlosti ≥ 4,2 až 5,0</strong> medzi aortomezenterickým a hilovým úsekom ľavej renálnej vény.</p>

<p>Obmedzenie je zásadné: <strong>výsledok závisí od polohy pacienta a od techniky vyšetrenia</strong> a samotný nutcracker fenomén je dynamický – mení sa s polohou tela a dýchaním. Dopplerovská sonografia sa preto <strong>nesmie použiť ako jediný diagnostický test</strong>.</p>

<h3>2) CT a MR angiografia</h3>

<p>Umožňujú posúdiť miesto a rozsah kompresie, kolaterály a anatomické súvislosti, a sú nevyhnutné pri plánovaní výkonu. MR angiografia je porovnateľná s CT pri hodnotení aortomezenterického uhla, ale jej využitie limituje cena a dĺžka vyšetrenia; výhodou je absencia ionizujúceho žiarenia, čo je relevantné u mladých pacientov. Normálny uhol sa uvádza 45° až 90°, <strong>konsenzus, že hodnoty pod 30° diagnózu definitívne potvrdzujú, však neexistuje</strong>.</p>

<h3>3) Venografia s tlakovým gradientom a intravaskulárny ultrazvuk</h3>

<p>Niektorí autori ich považujú za zlatý štandard, ale ani tu nie je zhoda. Kontrastná venografia sa robí s meraním renokaválneho gradientu pri spätnom ťahu katétra:</p>

<ul>
  <li>gradient <strong>≥ 1 mmHg</strong> diagnózu <em>podporuje</em>,</li>
  <li>časť autorov používa prah <strong>≥ 2 mmHg</strong>, iní <strong>≥ 3 mmHg</strong>,</li>
  <li><strong>normálne hodnoty diagnózu nevylučujú</strong> – výsledok ovplyvňuje poloha pacienta, hydratácia aj rozvoj kolaterál.</li>
</ul>

<p><strong>Intravaskulárny ultrazvuk</strong> má pri diagnostike NCS špecificitu <strong>90 %</strong> oproti <strong>62 %</strong> pri kontrastnej venografii a umožňuje posúdiť závažnosť stenózy.</p>

<p>Najnovší pokus o štandardizáciu – <strong>Delphi konsenzus z roku 2025</strong> – zhodu na jedinej zlatej metóde ani na hraničných hodnotách <em>nedosiahol</em>. Zhodol sa len na postupe: pri podozrení má úvodné vyšetrenie zahŕňať <strong>jednu prierezovú a jednu funkčnú zobrazovaciu modalitu</strong>, a pri pozitívnom výsledku nasleduje venografia s meraním gradientu a intravaskulárny ultrazvuk.</p>

<h2>Prognóza: čo sa dá a čo sa nedá sľúbiť</h2>

<p>Prirodzený priebeh nie je dobre známy, pretože kvalitné dlhodobé štúdie chýbajú. Čo sa dá povedať:</p>

<ul>
  <li><strong>U detí a adolescentov</strong> môže ísť o prechodný jav. S rastom telesnej hmoty a prírastkom mezenterického a retroperitoneálneho tuku sa aortomezenterický uhol rozšíri a kompresia zmierni – to odôvodňuje konzervatívny postup aspoň jeden až dva roky.</li>
  <li><strong>U dospelých</strong> je priebeh premenlivejší a často chronický, s predispozíciou k trombóze ľavej renálnej vény a k postupnému zhoršovaniu renálnej funkcie.</li>
  <li><strong>Skutočné zlyhanie obličiek v dôsledku samotného nutcracker syndrómu je mimoriadne zriedkavé</strong>, ak nie je prítomný iný problém. Opísané sú však masívna hematúria vyžadujúca transfúziu, významná proteinúria a neplodnosť v dôsledku varikokély alebo panvovej kongescie.</li>
  <li>Život ohrozujúce následky sú zriedkavé, ale <strong>zhoršenie kvality života môže byť výrazné</strong> – a práve to býva v praxi dôvodom intervencie.</li>
</ul>

<h2>Liečba: od konzervatívneho postupu po výkon</h2>

<p><strong>Anatomická kompresia sama o sebe nie je indikáciou na liečbu.</strong> Rozhoduje závažnosť príznakov, dopad na hemoglobín a proteinúriu, vývoj v čase, vek a pravdepodobnosť spontánneho zlepšenia.</p>

<h3>Konzervatívny postup</h3>

<p>Je prvou voľbou najmä u osôb <strong>mladších než 18 rokov</strong>, pri dobre tolerovaných, miernych alebo nešpecifických príznakoch a u pacientov, ktorí nespĺňajú dostatočné diagnostické kritériá. Cieľom je rozšírenie aortomezenterického uhla – najčastejšie priberaním a prírastkom viscerálneho tuku – alebo rozvoj venóznych kolaterál.</p>

<p>Z liekov sa uvádzajú <strong>inhibítory systému renín-angiotenzín-aldosterón</strong> (na kontrolu artériovej hypertenzie a na zníženie ortostatickej proteinúrie) a <strong>kyselina acetylsalicylová</strong> (na zlepšenie renálnej perfúzie). U mnohých detí a mladých dospelých ortostatická proteinúria pri liečbe ACE-inhibítorom alebo sartanom úplne ustúpi.</p>

<h3>Intervencia: čo pre ktorý výkon hovoria čísla</h3>

<p>Systematický prehľad publikovaný v roku 2025 (<em>Annals of Vascular Surgery</em>) zahrnul <strong>24 štúdií a 578 pacientov</strong> a porovnal udávané miery ústupu príznakov:</p>

<div class="table-responsive" role="region" aria-label="Ústup príznakov a potreba reintervencie podľa liečebného postupu pri nutcracker syndróme" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Postup</th><th scope="col">Počet pacientov</th><th scope="col">Ústup príznakov</th><th scope="col">Reintervencia</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Transpozícia ľavej renálnej vény</th><td>74</td><td><strong>92 %</strong> (87 – 100 %)</td><td>28,5 % – najvyššia zo všetkých</td></tr>
    <tr><th scope="row">Extravaskulárny stent</th><td>132</td><td><strong>80 %</strong> (71 – 100 %)</td><td>neuvádzaná</td></tr>
    <tr><th scope="row">Endovaskulárny stent</th><td>170</td><td><strong>76 %</strong> (50 – 100 %)</td><td>11,3 %</td></tr>
    <tr><th scope="row">Renálna autotransplantácia</th><td>137</td><td><strong>69 %</strong></td><td>7,2 %</td></tr>
    <tr><th scope="row">Transpozícia ľavej gonadálnej vény</th><td>31</td><td><strong>61 %</strong></td><td>neuvádzaná</td></tr>
    <tr><th scope="row">Konzervatívny postup</th><td>32</td><td><strong>52 %</strong> (28,5 – 76,2 %)</td><td>–</td></tr>
  </tbody>
</table>
<p><em>Sarikaya S a kol., Ann Vasc Surg 2025;121:406–421. Po extravaskulárnom stentovaní sa aortomezenterický uhol zvýšil z 20,6° na 44,5° (p &lt; 0,001). Pozor na zásadné obmedzenie: ide o súhrn observačných sérií bez randomizácie, s odlišným výberom pacientov a krátkym sledovaním – čísla <strong>nie sú</strong> priamo porovnateľné medzi riadkami.</em></p>
</div>

<p>Zo samostatného <strong>Delphi konsenzu 2025</strong> vyplýva, že odborníci považujú <strong>chirurgickú liečbu za nadradenú endovaskulárnej</strong> – hlavným dôvodom je <strong>riziko migrácie stentu</strong>. Pre nutcracker syndróm totiž nie je navrhnutý žiadny špecializovaný stent; používajú sa stenty určené na iné indikácie, čo prináša riziko migrácie (opísané sú posuny až do dolnej dutej žily či pravej predsiene), embolizácie, restenózy a trombózy.</p>

<p>Štandardom otvorenej chirurgie je <strong>transpozícia ľavej renálnej vény</strong> – jej preloženie distálnejšie na dolnú dutú žilu. <strong>Renálna autotransplantácia</strong> je rezervovaná pre refraktérne prípady po predchádzajúcich neúspešných výkonoch; <strong>nefrektómia</strong> je až poslednou možnosťou pri pretrvávajúcej hematúrii napriek opakovaným intervenciám. Pri výraznom gonadálnom postihnutí môže mať zmysel cielená <strong>embolizácia gonadálnych žíl</strong> – riešenie samotnej kompresie renálnej vény totiž panvové ťažkosti nemusí odstrániť.</p>

<h2>Praktický postup pre nefrologickú ambulanciu</h2>

<ol>
  <li><strong>Vzbudenie podozrenia.</strong> Hematúria alebo ortostatická proteinúria, typicky u mladšieho, štíhleho pacienta, s ľavostrannými alebo panvovými prejavmi, trvajúce viac než 6 mesiacov.</li>
  <li><strong>Vylúčenie bežných príčin.</strong> Infekcia, urolitiáza, nádor, malformácia – a glomerulové ochorenia: sediment moču, dysmorfné erytrocyty, valce, trend eGFR, kvantifikácia proteinúrie vrátane ortostatického testu.</li>
  <li><strong>Dopplerovská sonografia</strong> za štandardizovaných podmienok, s vedomím, že ide o skríning, nie o potvrdenie.</li>
  <li><strong>Prierezové zobrazenie</strong> (CT alebo MR angiografia) na posúdenie anatómie a kolaterál.</li>
  <li><strong>Pri nejasnosti alebo pred intervenciou</strong> venografia s meraním renokaválneho gradientu a intravaskulárny ultrazvuk.</li>
  <li><strong>Multidisciplinárne rozhodnutie.</strong> Nefrológia, rádiológia, cievna chirurgia a urológia. Prehľad z roku 2026 to formuluje priamo: povedomie o NCS v bežnej nefrologickej praxi je obmedzené, pretože väčšina dát pochádza z cievnych a rádiologických sérií, nie z nefrologických kohort.</li>
</ol>

<h2>Čo stále nevieme</h2>

<p>Pri tejto diagnóze zostáva veľa otvorených otázok:</p>

<ul>
  <li><strong>Validované diagnostické kritériá neexistujú.</strong> Chýbajú hodnoty upravené podľa veku aj fyziologicky zmysluplné hraničné hodnoty. Delphi konsenzus z roku 2025 zhodu na nich nedosiahol.</li>
  <li><strong>Skutočná prevalencia a prirodzený priebeh sú neisté</strong>, pretože väčšina údajov pochádza z malých heterogénnych sérií.</li>
  <li><strong>Nekonzistentné používanie pojmov</strong> „fenomén“ a „syndróm“ v literatúre komplikuje porovnávanie výsledkov.</li>
  <li><strong>Izolovaný rádiologický nález kompresie nemôže spoľahlivo viesť k invazívnej liečbe</strong> – a zároveň neexistujú porovnávacie štúdie, ktoré by jednotlivé postupy postavili proti sebe pri rovnakých indikáciách.</li>
</ul>

<h2>Záver</h2>

<p>Syndróm luskáčika je diagnóza, pri ktorej je rozhodnutie „liečiť, alebo neliečiť“ ťažšie než samotné zobrazenie. Kompresia ľavej renálnej vény je častá, syndróm z nej je zriedkavý, a hranica medzi nimi nie je definovaná žiadnym konsenzuálnym číslom – ani uhlom, ani pomerom rýchlostí, ani tlakovým gradientom.</p>

<p>Praktické vodidlo preto nie je rádiologické, ale klinické: <strong>diagnóza stojí na zhode príznakov s anatómiou a hemodynamikou po tom, čo sa vylúčilo všetko ostatné</strong> – a pri pretrvávajúcej hematúrii alebo proteinúrii treba myslieť aj na možnosť, že nutcracker a glomerulové ochorenie existujú u toho istého pacienta súčasne.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Mačionienė E, Kerpauskienė A, Žakauskienė U, Vitkauskaitė M, Girčius R, Miglinas M. <em>Nutcracker syndrome in 2026: a nephrologist-oriented diagnosis and management.</em> Clin Kidney J 2026;19(5):sfag124. <a href="https://doi.org/10.1093/ckj/sfag124" target="_blank" rel="noopener noreferrer">doi:10.1093/ckj/sfag124</a> (PMID 42111894). <em>Hlavný zdroj patofyziológie, prevalenčných údajov, diagnostických prahov a prekryvu s IgA nefropatiou.</em></li>
  <li>Sarikaya S, Altas O, Ozgur MM a kol. <em>Contemporary Management of Nutcracker Syndrome: A Systematic Review.</em> Ann Vasc Surg 2025;121:406–421. <a href="https://doi.org/10.1016/j.avsg.2025.07.043" target="_blank" rel="noopener noreferrer">doi:10.1016/j.avsg.2025.07.043</a> (PMID 40816484).</li>
  <li>Ananthan K, Onida S, Davies AH. <em>Nutcracker Syndrome: An Update on Current Diagnostic Criteria and Management Guidelines.</em> Eur J Vasc Endovasc Surg 2017;53(6):886–894. <a href="https://doi.org/10.1016/j.ejvs.2017.02.015" target="_blank" rel="noopener noreferrer">doi:10.1016/j.ejvs.2017.02.015</a> (PMID 28356209).</li>
  <li>Kolber MK, Cui Z, Chen CK, Habibollahi P, Kalva SP. <em>Nutcracker syndrome: diagnosis and therapy.</em> Cardiovasc Diagn Ther 2021;11(5):1140–1149. <a href="https://doi.org/10.21037/cdt-20-160" target="_blank" rel="noopener noreferrer">doi:10.21037/cdt-20-160</a> (PMID 34815965).</li>
  <li>Kurklinsky AK, Rooke TW. <em>Nutcracker phenomenon and nutcracker syndrome.</em> Mayo Clin Proc 2010;85(6):552–559. <a href="https://doi.org/10.4065/mcp.2009.0586" target="_blank" rel="noopener noreferrer">doi:10.4065/mcp.2009.0586</a> (PMID 20511485).</li>
  <li>Kim SH. <em>The role of Doppler ultrasonography in the detection and management of nutcracker syndrome.</em> Ultrasonography 2025;44(1):31–41. <a href="https://doi.org/10.14366/usg.24168" target="_blank" rel="noopener noreferrer">doi:10.14366/usg.24168</a> (PMID 39710849).</li>
</ol>

<p><em>Bibliografické údaje všetkých citovaných prác boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza individuálne klinické rozhodnutie ani multidisciplinárne posúdenie pred invazívnym výkonom.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_nutcracker-syndrom-lava-renalna-vena-diagnostika-liecba_article',
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
