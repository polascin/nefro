<?php

/**
 * add_rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia_article.php
 * Kontinualne monitorovanie relativneho objemu krvi a predikcia IDH
 * (Aniort a spol., Clin Kidney J 2026;19(4):sfag052, doi 10.1093/ckj/sfag052).
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
    'title'        => 'Kontinuálne monitorovanie relatívneho objemu krvi môže predpovedať intradialyzačnú hypotenziu',
    'slug'         => 'rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pokles relatívneho objemu krvi predpovedal hypotenziu s AUC 0,77 pri validácii podľa procedúr — ale iba 0,62 pri nových pacientoch. Rozdiel medzi týmito dvoma číslami je celý príbeh tejto štúdie.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Model, ktorý pozná predchádzajúce dialýzy toho istého pacienta, funguje dobre. Ten istý model u pacienta, ktorého nikdy nevidel, funguje sotva lepšie než náhoda. To nie je chyba štúdie — je to jej najužitočnejšie zistenie.</em></p>

<p>Intradialyzačná hypotenzia patrí medzi najčastejšie komplikácie hemodialýzy. Francúzska prospektívna multicentrická štúdia ukázala, že pokles relatívneho objemu krvi (RBV) počas dialýzy súvisí s výskytom hypotenzie a môže pomôcť predpovedať hypotenznú príhodu v nasledujúcich 10 až 60 minútach.</p>

<p>Najlepšiu prediktívnu výkonnosť nemala samotná hodnota RBV, ale model kombinujúci RBV, jeho časovú zmenu, aktuálny systolický krvný tlak, pokles tlaku od začiatku dialýzy a srdcovú frekvenciu. Výsledky sú sľubné, pochádzajú však z malého, vysoko rizikového súboru bez nezávislej externej validácie. <strong>Štúdia zatiaľ nepreukazuje, že použitie modelu znižuje výskyt hypotenzie, hospitalizácie, poškodenie orgánov alebo mortalitu.</strong></p>

<h2>Prečo vzniká intradialyzačná hypotenzia</h2>

<p>Ultrafiltrácia odstraňuje tekutinu priamo z intravaskulárneho priestoru. Strata plazmatického objemu sa za fyziologických okolností kompenzuje presunom tekutiny z interstícia do cievneho riečiska — plazmatickým dopĺňaním. Ak rýchlosť ultrafiltrácie prekročí kapacitu plazmatického dopĺňania, klesá objem cirkulujúcej krvi a srdcový výdaj.</p>

<p>Stabilita krvného tlaku potom závisí od zvýšenia srdcovej frekvencie a kontraktility, periférnej vazokonstrikcie, mobilizácie krvi z kapacitných ciev, zachovanej autonómnej regulácie a primeraného plazmatického dopĺňania.</p>

<p>Hypotenzia preto nevzniká iba v dôsledku zníženia objemu krvi. Význam majú aj systolická a diastolická dysfunkcia, poruchy rytmu, autonómna neuropatia, nízky cievny tonus, príjem potravy počas dialýzy, zloženie a teplota dialyzačného roztoku, antihypertenzná liečba a individuálna hemodynamická odpoveď. <strong>Rovnaký pokles RBV môže byť u jedného pacienta dobre tolerovaný a u iného viesť k závažnej hypotenzii</strong> — a práve táto veta predurčuje výsledky celej štúdie.</p>

<h2>Klinické dôsledky intradialyzačnej hypotenzie</h2>

<p>Akútne sa hypotenzia môže prejaviť slabosťou, závratom, nauzeou, vracaním, svalovými kŕčmi, bolesťou na hrudníku, poruchou vedomia alebo synkopou. Nie každá hypotenzná príhoda je však symptomatická.</p>

<p>Opakovaná hemodynamická nestabilita sa spája s prechodnou ischémiou myokardu a jeho omráčením, progresívnou poruchou funkcie ľavej komory, cerebrálnou hypoperfúziou a kognitívnym poškodením, mezenterickou ischémiou, stratou reziduálnej funkcie obličiek, trombózou cievneho prístupu a vyšším rizikom hospitalizácie a úmrtia.</p>

<p>Väčšina týchto vzťahov pochádza z observačných štúdií. Intradialyzačná hypotenzia môže byť príčinou poškodenia, ale súčasne aj ukazovateľom vyššej chorobnosti a obmedzenej kardiovaskulárnej rezervy.</p>

<h2>Čo vyjadruje relatívny objem krvi</h2>

<p>Monitory objemu krvi odhadujú zmenu intravaskulárneho objemu <strong>nepriamo</strong>, najčastejšie pomocou kontinuálneho merania hematokritu. Pri predpoklade približne stabilnej masy cirkulujúcich erytrocytov vedie odstránenie plazmatickej vody k hemokoncentrácii. Relatívny objem krvi možno vyjadriť približne ako podiel vstupného hematokritu a hematokritu v danom čase vynásobený stom; RBV 90 % teda zodpovedá približne 10-percentnému poklesu objemu krvi oproti začiatku procedúry.</p>

<p>Nejde o priame meranie absolútneho objemu krvi ani o spoľahlivé samostatné stanovenie hydratácie. Výsledok môžu ovplyvniť poloha pacienta, recirkulácia v cievnom prístupe, ultrafiltrácia a plazmatické dopĺňanie, zmeny distribúcie erytrocytov, podávanie infúzií, príjem potravy a technické vlastnosti monitora. RBV preto treba interpretovať ako <strong>dynamický nepriamy ukazovateľ</strong>, nie ako presnú mieru absolútnej hypovolémie.</p>

<h2>Usporiadanie štúdie</h2>

<p>Prospektívna observačná štúdia sa uskutočnila v piatich francúzskych dialyzačných centrách. Zaradení boli dospelí pacienti liečení hemodialýzou alebo online hemodiafiltráciou trikrát týždenne najmenej tri mesiace, ktorí mali <strong>najmenej dve epizódy intradialyzačnej hypotenzie počas predchádzajúceho mesiaca</strong>. Nešlo teda o prierez celej dialyzovanej populácie, ale o zámerný výber pacientov s vysokým rizikom opakovanej hypotenzie.</p>

<p>Analyzovaných bolo <strong>56 pacientov a 459 dialyzačných procedúr</strong>, spravidla deväť po sebe nasledujúcich procedúr na pacienta.</p>

<h3>Definícia intradialyzačnej hypotenzie</h3>

<p>Hypotenzia bola definovaná súčasným splnením dvoch kritérií: systolický krvný tlak pod 90 mm Hg <strong>a</strong> pokles systolického tlaku najmenej o 20 mm Hg oproti prvej hodnote zaznamenanej počas procedúry.</p>

<p>Definícia nevyžadovala prítomnosť príznakov ani terapeutický zásah. Nie je preto správne označovať všetky zaznamenané príhody za <em>symptomatickú</em> intradialyzačnú hypotenziu. (V metodickej časti elektronickej verzie primárnej publikácie sa nachádza formulácia „pokles o menej než 20 mm Hg“, ktorá odporuje abstraktu aj klinickej logike; ide takmer určite o typografickú chybu — abstrakt uvádza konzistentne pokles <strong>najmenej</strong> o 20 mm Hg.)</p>

<h3>Výskyt hypotenzie</h3>

<p>Intradialyzačná hypotenzia sa vyskytla pri <strong>29,7 % procedúr</strong>. Tento údaj je na hornej hranici bežne uvádzaného rozpätia a nemožno ho extrapolovať na všetkých hemodialyzovaných pacientov — štúdia zámerne skúmala populáciu obohatenú o pacientov s častou hemodynamickou nestabilitou.</p>

<h2>Pokles RBV a aktuálne riziko hypotenzie</h2>

<p>V generalizovanom lineárnom zmiešanom modeli bol každý pokles RBV o jeden percentuálny bod spojený s približne <strong>5-percentným zvýšením šance</strong> na súčasný výskyt hypotenzie (OR 1,05; p &lt; 0,001).</p>

<p>Ide o zvýšenie šance, nie priamo rizika. A predovšetkým: hodnotila sa asociácia s hypotenziou <strong>v rovnakom časovom bode</strong>. Tento výsledok sám osebe nepreukazuje schopnosť predpovedať budúcu príhodu.</p>

<h2>Tri trajektórie relatívneho objemu krvi</h2>

<p>Autori pomocou nekontrolovaného klastrovania rozdelili dialyzačné procedúry do troch skupín podľa tvaru krivky RBV. Prvý a tretí klaster (s výskytom hypotenzie 33,2 % a 30,9 %) boli spojené do skupiny s vyšším rizikom; druhý klaster (18,8 %) predstavoval skupinu s nižším rizikom.</p>

<p>Procedúry vo vysokorizikových klastroch mali v porovnaní s nízkorizikovým klastrom nižší konečný RBV, väčší ultrafiltračný objem, skorší výskyt hypotenzie a väčší rozdiel medzi predpísanou a bioimpedančne odhadnutou suchou hmotnosťou.</p>

<p>Klastre aj ich označenie ako vysokorizikové však <strong>vznikli z rovnakého súboru</strong>, v ktorom sa následne hodnotila ich asociácia s hypotenziou. Bez validácie v nezávislom súbore nemožno vylúčiť nadhodnotenie výsledku.</p>

<h2>Dynamický prah RBV</h2>

<p>Autori odvodili časovo premenlivý prah RBV: v každom časovom bode vybrali hodnotu, ktorá najlepšie oddeľovala nízkorizikové a vysokorizikové trajektórie, a výslednú krivku vyhladili. Približne po 150 minútach dialýzy zodpovedal prah hodnote okolo 90 %, teda približne 10-percentnému poklesu objemu krvi; prah však nebol počas procedúry lineárny ani konštantný.</p>

<p>Pokles RBV pod dynamický prah bol <strong>v rovnakom čase</strong> spojený s viac než dvojnásobnou šancou na hypotenziu (OR 2,37; p &lt; 0,001).</p>

<p>Tento výsledok treba dôsledne odlíšiť od predikcie budúcej hypotenzie. V modeli hodnotiacom výskyt hypotenzie počas nasledujúcich 10 až 60 minút bolo prekročenie prahu spojené s <strong>miernejším</strong> zvýšením šance. Nie je teda presné tvrdiť, že pokles pod prah viac než zdvojnásobil riziko hypotenzie v nasledujúcich 10 až 60 minútach — hodnota 2,37 sa vzťahovala na súčasnú asociáciu.</p>

<h2>Predikcia hypotenzie a význam individuálnych rozdielov</h2>

<p>Tu leží jadro celej práce. Výkonnosť modelu závisela od toho, ako sa rozdelili tréningové a testovacie údaje:</p>

<div class="table-responsive" role="region" aria-label="Prediktívna výkonnosť modelov podľa spôsobu validácie" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Model a spôsob validácie</th>
        <th scope="col">AUC</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Iba RBV, validácia podľa procedúr</th><td>0,77</td></tr>
      <tr><th scope="row">Iba RBV, validácia podľa pacientov</th><td><strong>0,62</strong></td></tr>
      <tr><th scope="row">Zmiešaný model s ďalšími premennými, podľa pacientov</th><td>0,85</td></tr>
      <tr><th scope="row">XGBoost s ďalšími premennými, podľa pacientov</th><td>0,86</td></tr>
    </tbody>
  </table>
</div>

<p>Pri rozdelení podľa procedúr mohol tréningový súbor obsahovať predchádzajúce dialýzy tých istých pacientov — model teda čiastočne rozpoznával <strong>individuálny profil známeho pacienta</strong>, nie univerzálnu zákonitosť. Keď sa súbory rozdelili podľa pacientov, výkonnosť samotného RBV klesla na AUC 0,62, teda na úroveň sotva použiteľnú.</p>

<p>Po doplnení ďalších priebežne meraných premenných — časovej derivácie RBV, aktuálneho systolického tlaku, jeho poklesu oproti začiatku procedúry a srdcovej frekvencie — sa výkonnosť u nových pacientov výrazne zlepšila (AUC 0,85 a 0,86). Rozdiel medzi klasickým zmiešaným modelom a algoritmom strojového učenia bol pritom <strong>zanedbateľný</strong>: komplexnejší algoritmus tu neprináša prevahu.</p>

<p>Časť prediktívnej výkonnosti navyše pochádzala z aktuálneho krvného tlaku a jeho už prebiehajúceho poklesu. Model preto nemusí predpovedať celkom neočakávanú hypotenziu — môže zachytávať jej <strong>počiatočnú hemodynamickú fázu</strong>.</p>

<h2>Hydratácia a suchá hmotnosť</h2>

<p>V nízkorizikovom klastri sa predpísaná suchá hmotnosť približne zhodovala s bioimpedančným odhadom. Vo vysokorizikových klastroch bola predpísaná suchá hmotnosť v priemere približne o 0,9 kg <strong>nižšia</strong> než hodnota odvodená pomocou monitora telesného zloženia.</p>

<p>To môže znamenať, že niektorí pacienti boli vedení k nižšej cieľovej hmotnosti, než zodpovedalo bioimpedančnému odhadu normohydratácie — výraznejší pokles RBV tak mohol súvisieť s pokusom odstrániť viac tekutiny, než bolo hemodynamicky tolerovateľné. Bioimpedančne stanovená normohydratácia však nie je absolútnym referenčným štandardom a treba ju posudzovať spolu s klinickým vyšetrením, krvným tlakom, reziduálnou diurézou, echokardiografickým nálezom a toleranciou ultrafiltrácie.</p>

<h2>Čo štúdia nepreukázala</h2>

<p>Štúdia nepreukázala, že používanie dynamického prahu RBV znižuje počet hypotenzných príhod, umožňuje bezpečne automatizovať ultrafiltráciu, znižuje poškodenie myokardu alebo mozgu, chráni reziduálnu funkciu obličiek, znižuje počet hospitalizácií, predlžuje prežívanie alebo je bezpečnejšie než štandardné klinické riadenie dialýzy.</p>

<p><strong>Model údaje iba vyhodnocoval</strong> — podľa jeho výstupov sa počas štúdie ultrafiltrácia automaticky ani protokolovo neupravovala.</p>

<h2>Prečo nestačí iba znížiť ultrafiltračnú rýchlosť</h2>

<p>Ak sa pri každom poklese RBV ultrafiltrácia iba zníži alebo zastaví bez úpravy celkového liečebného plánu, pacient nemusí dosiahnuť primeranú euvolémiu. Dôsledkom môže byť chronické objemové preťaženie, hypertenzia a srdcové zlyhávanie — teda výmena akútneho problému za chronický.</p>

<p>Primeraná reakcia môže zahŕňať prehodnotenie cieľovej hmotnosti, obmedzenie interdialyzačného príjmu sodíka a tekutín, predĺženie procedúry, zvýšenie frekvencie dialýz, individualizáciu ultrafiltračného profilu, použitie chladnejšieho dialyzačného roztoku, prehodnotenie antihypertenznej liečby a diagnostiku srdcového alebo autonómneho ochorenia.</p>

<h2>Metodologické obmedzenia</h2>

<ul>
  <li><strong>Malý počet pacientov:</strong> iba 56 osôb. Väčší počet procedúr nemôže nahradiť malý počet nezávislých pacientov, pretože opakované procedúry toho istého pacienta sú navzájom korelované.</li>
  <li><strong>Výber vysoko rizikovej populácie:</strong> všetci pacienti mali pred zaradením opakovanú hypotenziu; model nemusí mať rovnakú výkonnosť v bežnej dialyzovanej populácii.</li>
  <li><strong>Bez nezávislej externej validácie:</strong> prahy, klastre aj modely vznikli a boli hodnotené v rovnakom súbore. Rozdelenie na tréningové a testovacie údaje je interná, nie externá validácia.</li>
  <li><strong>Riziko úniku informácií medzi procedúrami</strong> pri validácii podľa procedúr — rozdiel AUC 0,77 oproti 0,62 túto obavu priamo kvantifikuje.</li>
  <li><strong>Odvodenie prahu z klastrov:</strong> dynamický prah nebol odvodený z nezávislého klinického výsledku, ale optimalizovaný na rozlíšenie klastrov vzniknutých z tých istých údajov.</li>
  <li><strong>Technické obmedzenia RBV:</strong> recirkulácia v cievnom prístupe, zmena polohy, technická chyba, infúzia alebo náhle zmeny distribúcie krvi.</li>
  <li><strong>Neštandardizovaná dialyzačná preskripcia:</strong> zloženie roztoku, membrána, prietoky, antikoagulácia a stanovenie suchej hmotnosti zostali v kompetencii ošetrujúceho nefrológa — to zvyšuje klinickú realistickosť, ale pridáva mätúce premenné.</li>
  <li><strong>Vzťahy k výrobcovi:</strong> dvaja spoluautori sú zamestnancami spoločnosti Fresenius Medical Care (francúzska pobočka a globálny výskum a vývoj), ďalší autori deklarujú prednáškové alebo konzultačné vzťahy.</li>
</ul>

<h2>Klinický význam</h2>

<p>Kontinuálny priebeh RBV prináša viac informácií než izolovaná hodnota na konci dialýzy. Najväčší potenciál má pravdepodobne <strong>pri opakovaných procedúrach toho istého pacienta</strong>, keď možno porovnávať individuálne trajektórie, ultrafiltráciu, krvný tlak a predchádzajúcu toleranciu liečby. Paradoxne je to práve to, čo štúdia ukázala najpresvedčivejšie — a zároveň to, čo skúsený dialyzačný tím robí aj bez algoritmu.</p>

<p>RBV nemožno používať ako jediný signál na automatické znižovanie ultrafiltrácie. Rozhodovanie musí zahŕňať aktuálny krvný tlak a jeho trend, srdcovú frekvenciu, príznaky, objemový stav, cieľovú hmotnosť, srdcovú funkciu a potrebu dosiahnuť primeranú dlhodobú kontrolu hydratácie.</p>

<p>Pred klinickým zavedením modelu je potrebná prospektívna validácia v nezávislých centrách, validácia pri rôznych dialyzačných prístrojoch a populáciách, randomizovaná intervenčná štúdia, hodnotenie falošných poplachov a pracovného zaťaženia personálu a dôkaz, že zásah podľa modelu znižuje klinicky významné príhody <strong>bez zvýšenia objemového preťaženia</strong>.</p>

<h2>Záver</h2>

<p>Kontinuálny pokles relatívneho objemu krvi bol v prospektívnej francúzskej štúdii významne spojený s intradialyzačnou hypotenziou. Dynamické hodnotenie RBV umožnilo identifikovať procedúry s vyšším rizikom a v kombinácii s krvným tlakom, jeho vývojom a srdcovou frekvenciou dosiahlo dobrú internú prediktívnu výkonnosť (AUC 0,85 – 0,86).</p>

<p>Samotný RBV však nebol dostatočne spoľahlivým prediktorom pri nových pacientoch (AUC 0,62). Výsledky zatiaľ predstavujú <strong>vývoj a internú validáciu predikčného modelu, nie dôkaz klinického prínosu</strong> automatizovaného riadenia ultrafiltrácie.</p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">Stanovenie suchej hmotnosti pri hemodialýze</a> — kľúčová premenná tejto štúdie.</li>
  <li><a href="article.php?slug=umela-inteligencia-sucha-hmotnost-hemodialyza">Umelá inteligencia a určovanie suchej hmotnosti</a>.</li>
  <li><a href="article.php?slug=dennik-semafor-objemovy-manazment-hemodialyza-rct">Denník semafor a objemový manažment</a> — jednoduchšia cesta k tomu istému cieľu.</li>
  <li><a href="article.php?slug=krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza">Kŕče kostrového svalstva pri dialýze</a> — príbuzný intradialyzačný symptóm.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Julien Aniort, Thomas Bachelet, Pascal Seris, Thibault Dolley-Hitze, Marc Bouiller, Camilia Beji, Valerie Batel, Bruno Pereira, David Attaf, Pascal Kopperschmidt, Anne-Elisabeth Heng, Bernard Canaud.</strong> <em>Continuous monitoring of relative blood volume allows real-time assessment of intradialytic hypotension risk.</em> Clinical Kidney Journal. 2026;19(4):sfag052. <a href="https://doi.org/10.1093/ckj/sfag052" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42027896/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13100653/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Jennifer E. Flythe, Tara I. Chang, Martin P. Gallagher, Elizabeth Lindley, Magdalena Madero, Pantelis A. Sarafidis, Mark L. Unruh, Angela Yee-Moon Wang, Daniel E. Weiner, Michael Cheung, Michel Jadoul, Wolfgang C. Winkelmayer a spol.</strong> <em>Blood pressure and volume management in dialysis: conclusions from a Kidney Disease: Improving Global Outcomes (KDIGO) Controversies Conference.</em> Kidney International. 2020;97(5):861–876. <a href="https://doi.org/10.1016/j.kint.2020.01.046" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>ClinicalTrials.gov, U.S. National Library of Medicine.</strong> <em>Prediction of Risk of Hypotension in Hemodialysis (IMHOTEP), NCT03350308.</em> Zadávateľ CHU Clermont-Ferrand. <a href="https://clinicaltrials.gov/study/NCT03350308" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Číselné údaje — 56 pacientov a 459 dialyzačných procedúr, definícia hypotenzie ako systolický tlak pod 90 mm Hg so súčasným poklesom najmenej o 20 mm Hg, výskyt hypotenzie pri 29,7 % procedúr, OR 1,05 na každý percentuálny bod poklesu RBV, OR 2,37 pri prekročení dynamického prahu, AUC 0,77 pri validácii podľa procedúr a 0,62 pri validácii podľa pacientov, AUC 0,85 pre zmiešaný model a 0,86 pre XGBoost po doplnení ďalších premenných — boli overené proti štruktúrovanému abstraktu v zázname PubMed. Príslušnosť dvoch spoluautorov k spoločnosti Fresenius Medical Care bola overená v afiliáciách. Hodnoty uvádzané s tromi desatinnými miestami (OR 1,053 s intervalom 1,037 – 1,069), rozdelenie klastrov (33,2 / 18,8 / 30,9 %), OR 2,58 pre vysokorizikové klastre, OR 1,68 pre predikciu na 10 až 60 minút, senzitivity a špecificity, rozdiel suchej hmotnosti 0,9 kg a priemerné parametre procedúr pochádzajú z plného textu a <strong>neboli nezávisle overené</strong>. Bibliografia bola overená cez Crossref a PubMed; v citácii konsenzu KDIGO boli <strong>opravené mená troch autorov</strong> — na deviatom až jedenástom mieste sú Daniel E. Weiner, Michael Cheung a Michel Jadoul, nie Matthew R. Weir, James B. Wetmore a Caroline M. Wilkie (tí sú medzi ďalšími z 55 účastníkov). Rozbor rozdielu medzi validáciou podľa procedúr a podľa pacientov, upozornenie na odlíšenie súčasnej asociácie od predikcie a poznámka o výmene akútneho problému za chronický sú <strong>vlastným odborným hodnotením</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rbv-monitorovanie-intradialyzacna-hypotenzia-predikcia_article',
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
