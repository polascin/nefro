<?php
/**
 * Odborny clanok: digitalne zdravotnictvo a riziko prehlbovania nerovnosti (WHO scoping review) a nefrologia.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_digitalne-zdravotnictvo-nerovnosti-who-nefrologia_article.php"
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
    'title'        => 'Digitálne zdravotníctvo môže nerovnosti aj prehĺbiť: čo hovorí dôkazová báza a čo z nej plynie pre nefrologickú prax',
    'slug'         => 'digitalne-zdravotnictvo-nerovnosti-who-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad WHO pre európsky región zistil systematicky vyššie využívanie digitálnych zdravotníckych technológií u ľudí s vyšším vzdelaním, príjmom, v mestách a u mladších. Ak sa rovnosť prístupu nemeria, digitálne nástroje môžu rozdiely v zdraví zväčšiť.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Digitálne technológie sa často predstavujú ako cesta k spravodlivejšiemu prístupu k zdravotnej starostlivosti. Prehľadová správa Regionálneho úradu WHO pre Európu však ukazuje, že ich využívanie je systematicky vyššie práve u skupín, ktoré sú aj inak zvýhodnené. Ak sa nerovnosť v prístupe, používaní a zapojení nesleduje a nemeria, digitálny manažment môže rozdiely v zdraví zväčšiť namiesto toho, aby ich zmenšil.</em></p>

<h2>Prečo sa o rovnosti v digitálnom zdravotníctve vedie spor</h2>

<p>Digitálne zdravotnícke technológie sa v nefrológii dotýkajú takmer všetkého: telemedicínskych konzultácií, pacientskych portálov, domáceho merania krvného tlaku a hmotnosti, edukácie cez aplikácie, triáže pri zhoršení stavu, pripomienok na kontroly aj algoritmických nástrojov na predikciu rizika.</p>

<p>Ak tieto nástroje fungujú, môžu zlepšiť včasnosť intervencií pri chronickej chorobe obličiek. Ak však nie sú použiteľné pre znevýhodnených pacientov, zväčšia rozdiel medzi tými, ktorí starostlivosť dostávajú, a tými, ktorí ju potrebujú najviac.</p>

<p>Tento jav má svoje meno. Britský lekár Julian Tudor Hart ho v roku 1971 opísal ako <strong>zákon obrátenej starostlivosti</strong>: dostupnosť dobrej zdravotnej starostlivosti má tendenciu byť nepriamo úmerná potrebe obyvateľstva, ktoré ju potrebuje. Práve na tento pojem nadväzuje aj redakčný komentár publikovaný v roku 2026 v <em>NEJM AI</em>, ktorý ho aplikuje na geografické rozdiely v prístupe k zdravotníckym technológiám.</p>

<h2>Kľúčový rámec: prístup, používanie a zapojenie</h2>

<p>Najlepšie zadefinovaným podkladom je prehľadová správa Regionálneho úradu WHO pre Európu z roku 2022. Jej autori zámerne oddelili dva rôzne rámce, ktoré sa v diskusii často zamieňajú:</p>

<div class="table-responsive" role="region" aria-label="Dva rámce použité v prehľade WHO" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Rámec</th>
      <th scope="col">Čo obsahuje</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Tri dimenzie digitálneho zdravia</th>
      <td><strong>prístup</strong> (technológia, internet, zariadenia, infraštruktúra), <strong>používanie</strong> (schopnosť nástroj reálne používať, digitálna gramotnosť) a <strong>zapojenie</strong> (miera a kvalita interakcie s digitálnou službou)</td>
    </tr>
    <tr>
      <th scope="row">Desať domén rovnosti podľa PROGRESS Plus</th>
      <td>miesto bydliska; rasa, etnicita, kultúra a jazyk; zamestnanie; rod a pohlavie; náboženstvo; vzdelanie; socioekonomický status; sociálny kapitál; plus vek, zdravotné postihnutie alebo komplexné potreby (napríklad bezdomovectvo alebo užívanie návykových látok)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Toto rozlíšenie je dôležité. Služba môže byť formálne dostupná všetkým, a napriek tomu ju z praktického hľadiska obídu práve skupiny s najväčšou potrebou — buď preto, že nemajú zariadenie a pripojenie, alebo preto, že ho nedokážu použiť, alebo preto, že sa do interakcie nezapoja.</p>

<h2>Čo prehľad WHO zistil</h2>

<p>Prehľad identifikoval <strong>22 relevantných kvantitatívnych a zmiešaných prehľadových prác a metaanalýz</strong> publikovaných v období od roku 2016 do mája 2022. Nešlo teda o primárne štúdie, ale o prehľady prehľadov.</p>

<p>Konzistentný dôkaz o <em>vyššom</em> využívaní digitálnych zdravotníckych technológií sa našiel:</p>

<ul>
  <li>v mestských oblastiach v porovnaní s vidieckymi,</li>
  <li>u osôb belošského pôvodu a u hovoriacich väčšinovým jazykom v porovnaní s etnickými menšinami a osobami s jazykovou bariérou,</li>
  <li>u ľudí s vyšším vzdelaním,</li>
  <li>u ľudí s vyšším ekonomickým statusom,</li>
  <li>u mladších v porovnaní so staršími dospelými.</li>
</ul>

<p>Lepší prístup mali aj osoby bez zdravotného postihnutia alebo bez komplexných zdravotných potrieb.</p>

<p>Ide teda o systematický vzorec, nie o náhodné rozdiely. Skupiny s najväčšou zdravotnou potrebou — starší ľudia, marginalizované skupiny, osoby so zdravotným postihnutím — majú najmenšiu pravdepodobnosť prístupu k digitálnym platformám.</p>

<div class="pdf-avoid-break">
<h3>Digitálne technológie však vidieckym komunitám aj pomáhajú</h3>

<p>Obraz nie je jednostranný. WHO zároveň uvádza, že prístup k zdravotnej starostlivosti sprostredkovaný digitálnou technológiou <strong>priniesol vidieckym komunitám priaznivé zdravotné výsledky</strong>. Problémom nie je samotná technológia, ale bariéry jej prijatia a používania.</p>

<p>Na vidieku sa nevýhody kumulujú: nedostatočná infraštruktúra, nedostupné alebo drahé pripojenie a zariadenia a slabšie digitálne zručnosti súvisiace s nižším príjmom alebo vzdelaním. Najčastejšie uvádzanou prekážkou bol práve prístup k technológii a pripojeniu.</p>
</div>

<h3>Digitálna gramotnosť ako hlavný faktor používania</h3>

<p>Zatiaľ čo prístup rozhoduje o tom, či sa človek k službe vôbec dostane, digitálna gramotnosť rozhoduje o tom, či ju dokáže využiť. WHO ju označuje za kľúčový faktor rozdielov v používaní a zapojení.</p>

<p>Podstatné je, že rovnosť v digitálnom zdraví je funkciou <em>vzájomného pôsobenia</em> viacerých sociálnych a demografických faktorov. Tento priesečníkový pohľad však podľa WHO uviedli iba <strong>dva z 22</strong> zahrnutých prehľadov. Starší pacient s nízkym príjmom, žijúci na vidieku a s jazykovou bariérou nie je súčtom štyroch nevýhod — je v kvalitatívne inej situácii.</p>

<h3>Prístupu sa venovalo najmenej prác</h3>

<p>Len málo prehľadov skúmalo prístup ako základnú príčinu nerovností, a tie, ktoré sa mu venovali, sa spravidla obmedzili na technológiu a pripojenie podľa miesta bydliska. Bariéry vyplývajúce z kombinácie so zdravotným stavom, krehkosťou alebo jazykom zostali málo preskúmané.</p>

<h2>Regionálne rozdiely a algoritmické nástroje</h2>

<p>Ak implementácia umelej inteligencie nezohľadní regionálne rozdiely, riziko je zhoršenie existujúcich nerovností. V praxi sa to týka:</p>

<ul>
  <li>dostupnosti infraštruktúry a zdrojov v jednotlivých regiónoch,</li>
  <li>prenositeľnosti modelov trénovaných na mestských alebo univerzitných dátach do vidieckeho prostredia,</li>
  <li>chybnej interpretácie nízkeho využívania zdravotnej starostlivosti — ktoré môže odrážať bariéry prístupu — ako „nízkej potreby“.</li>
</ul>

<p>Posledný bod je pre nefrológiu najzávažnejší. Ak model rizika progresie CKD alebo model potreby nefrologickej konzultácie vychádza z historických dát, v ktorých znevýhodnení pacienti mali menej vyšetrení, menej meraní albuminúrie a neskoršie odoslanie k špecialistovi, môže sa naučiť, že títo pacienti „potrebujú menej“. Model tak zakonzervuje nerovnosť a zároveň jej dodá zdanie objektivity.</p>

<h2>Prečo rovnosť často zostáva iba deklaráciou</h2>

<p>Rovnosť sa objavuje v národných digitálnych stratégiách, ale v regulácii a hodnotení sa spravidla dáva prednosť ochrane súkromia, bezpečnosti a zodpovednosti. Zapojenie zraniteľných skupín do návrhu a testovania býva slabšie.</p>

<p>WHO explicitne uvádza, že chýbajú štandardizované prístupy, ktoré by systematicky merali rozdiely v dopade digitálnych riešení naprieč skupinami. Bez merania nemožno rovnosť riadiť.</p>

<p>Výnimkou, ktorú WHO uvádza ako príklad dobrej praxe, je rámec dôkazových štandardov pre digitálne zdravotnícke technológie britského National Institute for Health and Care Excellence (NICE). Obsahuje 21 štandardov v oblastiach návrhu, hodnoty, výkonu a nasadenia; rovnosť je jedným z nich. Ak technológia tvrdí, že rieši nerovnosť v zdraví alebo starostlivosti, musí to doložiť dôkazom. Štandardy zahŕňajú aj opatrenia prijaté pri návrhu technológie na zmiernenie algoritmickej zaujatosti, ktorá by mohla viesť k nerovnakému dopadu na rôzne skupiny používateľov.</p>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o rovnosti v digitálnom zdravotníctve" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Digitálne technológie majú potenciál zlepšiť prístup k starostlivosti</td><td><strong>Čiastočne potvrdené</strong></td><td>WHO uvádza priaznivé zdravotné výsledky u vidieckych komunít; potenciál je však podmienený odstránením bariér prijatia</td></tr>
    <tr><td>Nerovnosti v digitálnom zdraví pretrvávajú</td><td><strong>Potvrdené</strong></td><td>Konzistentne vyššie využívanie v mestách, u vzdelanejších, ekonomicky silnejších, mladších a u väčšinovej jazykovej skupiny</td></tr>
    <tr><td>Hlavnými bariérami sú prístup k technológii, nízka digitálna gramotnosť a návrh služby bez ohľadu na rôznorodosť populácie</td><td><strong>Potvrdené</strong></td><td>WHO označuje digitálnu gramotnosť za kľúčový faktor a odporúča inkluzívny a participatívny návrh</td></tr>
    <tr><td>Pri umelej inteligencii treba hodnotiť rovnosť, reprezentatívnosť dát a algoritmickú zaujatosť</td><td><strong>Podporené ako potreba do budúcna</strong></td><td>Problém je najmä v chýbajúcich hodnotiacich štandardoch, nie v tom, že by riziká neexistovali; rámec NICE už algoritmickú zaujatosť zahŕňa</td></tr>
    <tr><td>Nesprávne zohľadnenie regionálnych rozdielov môže nerovnosti zhoršiť</td><td><strong>Podporené</strong></td><td>Tréningové dáta môžu odrážať bariéry prístupu a model ich interpretuje ako nižšiu potrebu</td></tr>
    <tr><td>Väčšina dôkazov pochádza z USA</td><td><strong>Nepresné</strong></td><td>WHO uvádza, že väčšina dôkazov pochádza <em>mimo</em> európskeho regiónu; európske dôkazy pochádzajú takmer výlučne z vysokopríjmových krajín západnej Európy</td></tr>
    <tr><td>Prehľad hodnotil kvalitu zahrnutých prác</td><td><strong>Nie</strong></td><td>Pri metodike prehľadu typu <em>scoping review</em> sa hodnotenie metodologickej robustnosti nevykonáva</td></tr>
    <tr><td>Zistenia možno priamo preniesť do slovenskej praxe</td><td><strong>Opatrne</strong></td><td>WHO sama uvádza obmedzenú prenositeľnosť na krajiny regiónu s nižším a stredným príjmom</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Metodologické zhodnotenie prehľadu WHO</h2>

<h3>Silné stránky</h3>

<ul>
  <li>ide o jeden z najkomplexnejších prehľadov rovnosti v digitálnom zdraví,</li>
  <li>jasný a zavedený rámec PROGRESS Plus s desiatimi doménami,</li>
  <li>systematické spracovanie naprieč tromi dimenziami digitálneho zdravia,</li>
  <li>použitá definícia digitálneho zdravia podľa WHO vrátane umelej inteligencie, veľkých dát a robotiky,</li>
  <li>zverejnená stratégia vyhľadávania a charakteristiky zahrnutých prehľadov,</li>
  <li>otvorená dostupnosť pod licenciou Creative Commons.</li>
</ul>

<h3>Obmedzenia uvádzané samotnými autormi</h3>

<ol>
  <li><strong>Bez hodnotenia kvality.</strong> Prehľad typu <em>scoping review</em> nehodnotí metodologickú robustnosť zahrnutých prác. Z 22 prehľadov ich kritické hodnotenie vykonalo 12 a celková kvalita štúdií sa v nich označovala za <strong>nízku</strong>.</li>
  <li><strong>Metodologické slabiny primárnych prác.</strong> Uvádzali sa chýbajúce zaslepenie, malé súbory, nezohľadnenie všetkých konfundujúcich faktorov, nízka účasť a — čo je osobitne poučné — <em>zaraďovanie iba účastníkov, ktorí už mali prístup k digitálnym technológiám</em>. Štúdia postavená takto z princípu nemôže vidieť tých, ktorých sa vylúčenie týka najviac.</li>
  <li><strong>Iba anglicky publikované kvantitatívne práce.</strong> Identifikovali sa dva prehľady v iných jazykoch, ani jeden nesplnil kritériá zaradenia.</li>
  <li><strong>Kvalitatívna literatúra mimo rozsahu.</strong> Práve tá pritom nesie väčšinu kontextových informácií o bariérach a facilitátoroch.</li>
  <li><strong>Obmedzená prenositeľnosť v rámci regiónu.</strong> Väčšina dôkazov pochádza mimo európskeho regiónu a európske dôkazy takmer výlučne z vysokopríjmových krajín západnej Európy. WHO výslovne uvádza, že použiteľnosť pre krajiny regiónu s nižším a stredným príjmom je pravdepodobne obmedzená.</li>
  <li><strong>Chýbajúci priesečníkový pohľad.</strong> Takmer všetky zahrnuté prehľady ho postrádali; interagujúce faktory spomenuli iba dva.</li>
  <li><strong>Heterogenita definícií.</strong> Pojem digitálne zdravie zahŕňa veľmi rôznorodé intervencie od asistívnych technológií po webové platformy a monitorovacie systémy.</li>
  <li><strong>Vek dôkazov.</strong> Vyhľadávanie sa uzavrelo v máji 2022. Prehľad tak predchádza rozšíreniu generatívnej umelej inteligencie v klinickej praxi a jeho zistenia o algoritmických nástrojoch treba dopĺňať novšími prácami.</li>
</ol>

<h2>Nefrologické súvislosti</h2>

<p>Pri chronickej chorobe obličiek, v predtransplantačnej aj potransplantačnej starostlivosti a pri dialýze digitálne nástroje zasahujú do:</p>

<ul>
  <li>edukácie (diéta, príjem tekutín, riziká liekov, príprava na náhradu funkcie obličiek),</li>
  <li>monitorovania (domáce meranie krvného tlaku, telesná hmotnosť, sprostredkované sledovanie laboratórnych ukazovateľov),</li>
  <li>adherencie (lieky, očkovanie, kontrolné termíny),</li>
  <li>komunikácie pri zhoršení stavu (triáž, sledovanie symptómov),</li>
  <li>domácich metód dialýzy, ktoré na diaľkovom dohľade priamo stoja.</li>
</ul>

<p>Práve pri domácej dialýze je napätie najviditeľnejšie: metóda ponúka väčšiu autonómiu, ale predpokladá zariadenie, pripojenie, zručnosti a podporné zázemie. Bez nich sa z ponuky autonómie stáva ďalšie kritérium výberu, ktoré znevýhodnených pacientov vylúči.</p>

<div class="pdf-avoid-break">
<h3>Čo z toho vyplýva pre prax</h3>

<p>Posun od konštatovania „digitálne to máme“ k overeniu „digitálne to funguje aj pre zraniteľných pacientov“ znamená prakticky toto:</p>

<ol>
  <li><strong>Merať rozdiely v prístupe, používaní a zapojení</strong> medzi skupinami pacientov (vek, vzdelanie, jazyk, dostupnosť internetu, zdravotné postihnutie), nie iba celkovú mieru využívania.</li>
  <li><strong>Navrhovať a testovať s reálnymi pacientmi</strong> vrátane tých, ktorí majú bariéry — nie iba s tými, ktorí sa do testovania sami prihlásia.</li>
  <li><strong>Zachovať alternatívne cesty</strong> — telefonickú a osobnú komunikáciu, papierovú edukáciu — a nepenalizovať pacienta za to, že digitálny kanál nevyužil.</li>
  <li><strong>Nepovažovať nevyužitie digitálnej služby za nezáujem.</strong> Môže ísť o nedostupnosť, nie o preferenciu.</li>
  <li><strong>Postupovať opatrne pri algoritmických nástrojoch</strong>, najmä ak sú trénované na historických dátach odrážajúcich bariéry prístupu, a vyžadovať údaje o výkone modelu v jednotlivých podskupinách.</li>
  <li><strong>Zapojiť sestry, sociálnu prácu a rodinu</strong> ako podporu pri používaní technológie; WHO uvádza, že rodinní príslušníci majú pri starších vidieckych pacientoch podpornú úlohu.</li>
</ol>
</div>

<h2>Praktický záver</h2>

<p>Dôkazová báza podporuje záver, že digitálne zdravotníctvo môže nerovnosti zmenšiť aj zväčšiť — podľa toho, či sa rovnosť berie ako merateľný cieľ, alebo len ako deklarácia. Prehľad WHO konzistentne ukazuje, že prístup k digitálnym riešeniam a ich používanie sú systematicky vyššie u skupín s lepšou digitálnou a socioekonomickou pozíciou.</p>

<p>Pre nefrológiu z toho vyplýva, že pri zavádzaní digitálnych nástrojov pri chronickej chorobe obličiek treba rovnosť plánovať a sledovať rovnako dôsledne ako klinický prínos. Inak riskujeme, že digitálny manažment prispeje k rastu rozdielov v zdraví práve v skupine pacientov, ktorá je už teraz najzraniteľnejšia.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo už vieme, kde sú limity a kam to smeruje</a></li>
  <li><a href="article.php?slug=ai-nefrologia-hands-on-primer-klinicka-integracia">AI v nefrológii v praxi: čo prináša „Hands-On Primer“ pre klinické myslenie a bezpečnú integráciu</a></li>
  <li><a href="article.php?slug=pacient-diagnoza-ai-nefrologicka-ambulancia">Keď pacient prichádza s diagnózou od AI: čo to mení v nefrologickej ambulancii</a></li>
  <li><a href="article.php?slug=domaca-hemodialyza-kdigo-vychodna-azia-ramec-rozvoja">Domáca hemodialýza: väčšia autonómia pacienta nestačí bez fungujúceho systému</a></li>
  <li><a href="article.php?slug=rodove-rozdiely-dialyza-transplantacia-era-usrds">Rodové rozdiely v dialýze a transplantácii: Európa vs USA podľa ERA Registry a USRDS</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>WHO Regional Office for Europe</strong> (hlavní autori Diana Bright, Katherine Woolley, Fiona Morgan, Toby Ayres, Kirsty Little, Alisha Davies; odborné vedenie Clayton Hamilton a David Novillo Ortiz). <em>Equity within digital health technology within the WHO European Region: a scoping review.</em> Kodaň: WHO Regional Office for Europe; 2022. WHO/EURO:2022-6810-46576-67595. Licencia CC BY-NC-SA 3.0 IGO. <a href="https://iris.who.int/server/api/core/bitstreams/c0b312f6-4877-4d2a-aa66-769e84625226/content" target="_blank" rel="noopener noreferrer">Plný text (PDF)</a>.</li>
  <li><strong>Hwang YM, Rice BT, Hernandez-Boussard T.</strong> <em>The Inverse Care Law in the Age of AI — Geographic Disparities in Health Care Technology Access.</em> NEJM AI. 2026;3(4). doi: 10.1056/AIp2600103. <a href="https://doi.org/10.1056/AIp2600103" target="_blank" rel="noopener noreferrer">Komentár v NEJM AI</a>.</li>
  <li><strong>National Institute for Health and Care Excellence (NICE).</strong> <em>Evidence standards framework for digital health technologies — how to meet the standards.</em> Inštitucionálne autorstvo. Rámec 21 štandardov zahŕňajúci rovnosť a zmiernenie algoritmickej zaujatosti. <a href="https://www.nice.org.uk/corporate/ecd7/chapter/how-to-meet-the-standards" target="_blank" rel="noopener noreferrer">Dôkazové štandardy NICE</a>.</li>
  <li><strong>Medscape Professional Network.</strong> <em>Digital health innovation widening equity gap.</em> Medscape, 2026. Sekundárny zdroj použitý ako východisko, nie ako hlavný dôkaz; v sprístupnenej verzii sa ako autor uvádza Eugenio Santoro. <a href="https://www.medscape.com/viewarticle/digital-health-innovation-widening-equity-gap-2026a1000sk7" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Všetky vecné tvrdenia pripisované prehľadu WHO — počet 22 zahrnutých prehľadových prác a metaanalýz, obdobie 2016 až máj 2022, tri dimenzie digitálneho zdravia, desať domén rámca PROGRESS Plus, zoznam skupín s vyšším využívaním, údaj o dvoch z 22 prehľadov s priesečníkovým pohľadom, hodnotenie kvality v 12 z 22 prehľadov, popis rámca NICE s 21 štandardmi aj celý zoznam obmedzení — boli overené priamo proti plnému textu správy (výkonný súhrn a kapitola Discussion). Bibliografické údaje komentára v NEJM AI vrátane úplného názvu a autorstva boli overené cez Crossref. Údaj o autorstve spravodajského spracovania Medscape sa pre obmedzený prístup nepodarilo nezávisle overiť a uvádza sa s výhradou. Odkaz na zákon obrátenej starostlivosti (Julian Tudor Hart, 1971) je doplnený ako kontext k názvu komentára v NEJM AI.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Prehľad typu „scoping review“ mapuje rozsah a charakter dôkazov, nehodnotí účinnosť intervencií a nevykonáva hodnotenie kvality zahrnutých prác. Zistenia preto nemožno chápať ako kvantitatívny odhad veľkosti nerovností, ale ako opis ich smeru a konzistentnosti. Vyhľadávanie sa uzavrelo v máji 2022, čo treba pri hodnotení súčasných nástrojov umelej inteligencie zohľadniť.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_digitalne-zdravotnictvo-nerovnosti-who-nefrologia_article',
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
