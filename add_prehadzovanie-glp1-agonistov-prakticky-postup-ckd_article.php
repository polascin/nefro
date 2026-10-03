<?php
/**
 * add_prehadzovanie-glp1-agonistov-prakticky-postup-ckd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: prechod medzi agonistami GLP-1 receptorov
 * (switching) — načasovanie, titrácia, prečo neexistuje prepočet dávok,
 * manažment rizika hypoglykémie a nefrologická bezpečnosť (objemová deplécia,
 * AKI, rozdiel medzi humánnymi a exendínovými analógmi).
 *
 * Autor projektu: MUDr. Ľubomír Polaščín. Odborné zhrnutie viacerých zdrojov
 * (Almandoz 2020 Clin Diabetes, Perkovic 2024 NEJM — FLOW, Leehey 2021
 * Kidney Med) — nie preklad jedného zdrojového článku, preto sa do
 * source_authors.php nedopĺňajú pôvodní autori.
 *
 * Číselné údaje overené proti plnému textu Clin Diabetes 2020 (PMC7566932)
 * a abstraktom v PubMede (PMID 33132510, 38785209, 33851124).
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
    'title'        => 'Prechod medzi agonistami GLP-1: načasovanie, titrácia a nefrologické poistky',
    'slug'         => 'prehadzovanie-glp1-agonistov-prakticky-postup-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dávky agonistov GLP-1 receptorov sa medzi sebou neprepočítavajú — líšia sa štruktúrou, polčasom aj účinnosťou. Prehľad toho, kedy nový liek začať hneď a kedy až po odznení príznakov, prečo môže glykémia po prepnutí prechodne stúpnuť, kde sa líšia humánne a exendínové analógy pri CKD a aký monitoring patrí k pacientovi s chorobou obličiek po zmene liečby.',
    'content'      => <<<'HTML'
<figure><a href="img/prehadzovanie-glp1-agonistov-ckd.webp" rel="noopener noreferrer" target="_blank"><img src="img/prehadzovanie-glp1-agonistov-ckd.webp" alt="Dve svietiace injekčné perá položené ako úzke mosty cez tmavú priepasť sa nestretávajú — medzi nimi zostáva medzera, nad ktorou stojí drobná ľudská silueta; v hĺbke priepasti presvitajú dve svietiace obličky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie klinický záznam ani zobrazenie konkrétneho prípravku. Prechod medzi dvoma agonistami GLP-1 nie je administratívna výmena receptu — rozhoduje sa v medzere medzi nimi. A pri chronickej chorobe obličiek je pád z tej medzery hlbší.</figcaption></figure>

<p>Prechod medzi agonistami receptora pre glukagónu podobný peptid 1 (GLP-1 RA) je v ambulantnej praxi čoraz bežnejší — kvôli dostupnosti, úhrade, znášanlivosti, nedostatočnej odpovedi alebo potrebe kardioprotekcie. Nejde o okrajový jav: podľa údajov z lekární až <strong>štvrtina pacientov</strong> po prvom roku liečby prechádza z pôvodného GLP-1 RA na iné liečivo znižujúce glykémiu.</p>

<p>Napriek tomu je priamych štúdií o <em>prepínaní</em> medzi týmito liečivami málo; dostupné praktické odporúčania sa opierajú prevažne o farmakologické vlastnosti jednotlivých prípravkov, o štúdie priameho porovnania a o klinickú skúsenosť autorov. Tento článok zhŕňa, čo sa dá z týchto zdrojov povedať spoľahlivo — a dopĺňa to, čo v diabetologicky orientovaných textoch chýba: <strong>nefrologickú poistku</strong>.</p>

<h2>Prečo sa dávky neprepočítavajú</h2>

<p>Najčastejšou chybou pri prepínaní je hľadanie „ekvivalentnej dávky“. Taká neexistuje. Jednotlivé GLP-1 RA sa líšia štruktúrou, molekulovou hmotnosťou, farmakológiou, účinnosťou aj bezpečnostným profilom.</p>

<div class="table-responsive" role="region" aria-label="Kľúčové vlastnosti dostupných agonistov GLP-1 receptorov" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Liečivo</th><th scope="col">Pôvod</th><th scope="col">Polčas</th><th scope="col">Frekvencia</th><th scope="col">Podmienky podania</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Exenatid</th><td>zvierací (exendín)</td><td>2,4 h</td><td>2× denne</td><td>do 1 hodiny pred dvoma hlavnými jedlami</td></tr>
    <tr><th scope="row">Lixisenatid</th><td>zvierací (exendín)</td><td>asi 3 h</td><td>1× denne</td><td>do 1 hodiny pred prvým jedlom dňa</td></tr>
    <tr><th scope="row">Liraglutid</th><td>humánny analóg</td><td>asi 13 h</td><td>1× denne</td><td>kedykoľvek počas dňa</td></tr>
    <tr><th scope="row">Exenatid s predĺženým uvoľňovaním</th><td>zvierací (exendín)</td><td>7 – 14 dní</td><td>1× týždenne</td><td>kedykoľvek, s jedlom aj bez</td></tr>
    <tr><th scope="row">Dulaglutid</th><td>humánny analóg</td><td>asi 5 dní</td><td>1× týždenne</td><td>kedykoľvek, s jedlom aj bez</td></tr>
    <tr><th scope="row">Semaglutid subkutánne</th><td>humánny analóg</td><td>asi 7 dní</td><td>1× týždenne</td><td>kedykoľvek, s jedlom aj bez</td></tr>
    <tr><th scope="row">Semaglutid perorálne</th><td>humánny analóg</td><td>asi 7 dní</td><td>1× denne</td><td>nalačno, max. 120 ml vody, ≥ 30 min pred jedlom, nápojom aj inými liekmi</td></tr>
  </tbody>
</table>
<p><em>Podľa Almandoz JP a kol., Clinical Diabetes 2020;38(4):390–402. Dostupnosť jednotlivých prípravkov a ich schválené indikácie sa medzi krajinami líšia — vždy overte v aktuálnom SPC.</em></p>
</div>

<p>Rozdiely nie sú kozmetické. V štúdiách priameho porovnania bol subkutánny semaglutid 1,0 mg týždenne v znížení HbA1c aj hmotnosti <strong>lepší</strong> než liraglutid 1,2 mg denne, exenatid 2 mg týždenne aj dulaglutid 1,5 mg týždenne. Naopak liraglutid 1,8 mg denne bol porovnateľný s dulaglutidom 1,5 mg týždenne a lepší než exenatid 2 mg týždenne — <strong>frekvencia podávania teda nie je jediným určujúcim faktorom účinnosti</strong>. Pre nefrológa je ešte podstatnejší rozdiel v kardiovaskulárnych výsledkoch: prínos preukázali liraglutid, dulaglutid a subkutánny semaglutid, zatiaľ čo pri lixisenatide a týždennom exenatide sa významné zlepšenie nepreukázalo.</p>

<h2>Načasovanie: kedy začať nový liek</h2>

<p>Toto je v praxi najčastejšie nedorozumenie. Odpoveď nie je jedna — závisí od toho, <em>prečo</em> sa prepína.</p>

<div class="table-responsive" role="region" aria-label="Načasovanie prechodu medzi agonistami GLP-1 receptorov podľa situácie" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Situácia</th><th scope="col">Kedy začať nový liek</th><th scope="col">V akej dávke</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Denný → týždenný, pacient toleruje maximálnu dávku</th><td><strong>Deň po poslednej dávke</strong> denného prípravku</td><td>Dulaglutid 1,5 mg alebo exenatid 2 mg rovno v maximálnej dávke; semaglutid radšej cez medzistupeň 0,5 mg týždenne počas 4 týždňov</td></tr>
    <tr><th scope="row">Týždenný → týždenný, pacient toleruje maximálnu dávku</th><td><strong>Týždeň po poslednej dávke</strong>, v ten istý deň v týždni</td><td>Dulaglutid 1,5 mg alebo exenatid 2 mg v maximálnej dávke; semaglutid cez 0,5 mg týždenne</td></tr>
    <tr><th scope="row">Prepínanie <em>pre gastrointestinálnu neznášanlivosť</em> alebo pri netolerovaní maximálnej dávky</th><td><strong>Pôvodný liek zastaviť a počkať, kým príznaky neodznejú</strong></td><td>Začať <strong>najnižšou</strong> dávkou nového prípravku a zvážiť aj nižšiu udržiavaciu dávku</td></tr>
    <tr><th scope="row">Subkutánny semaglutid 0,5 mg týždenne → perorálny semaglutid</th><td>1 až 7 dní po poslednej injekcii</td><td>7 mg alebo 14 mg denne</td></tr>
    <tr><th scope="row">Perorálny semaglutid 14 mg denne → subkutánny</th><td>Deň po poslednej perorálnej dávke</td><td>0,5 mg týždenne</td></tr>
  </tbody>
</table>
<p><em>Podľa Almandoz 2020. Odporúčania pre injekčné prípravky sa opierajú prevažne o klinickú skúsenosť autorov, odporúčania pre perorálny semaglutid o údaje v preskripčných informáciách.</em></p>
</div>

<p>Z toho plynie jednoduché pravidlo, ktoré sa dá povedať pacientovi aj sestre: <strong>ak sa prepína kvôli dostupnosti alebo účinnosti, medzera v liečbe nie je potrebná. Ak sa prepína kvôli nežiaducim účinkom, medzera je naopak nutná — a nový liek sa začína od začiatku.</strong></p>

<h2>Skôr než sa prepne: čo prejsť</h2>

<ol>
  <li><strong>Overte, že pacient je stále vhodným kandidátom na GLP-1 RA vôbec.</strong> Vrátane osobnej a rodinnej anamnézy <strong>mnohopočetnej endokrinnej neoplázie 2. typu</strong> a <strong>medulárneho karcinómu štítnej žľazy</strong>.</li>
  <li><strong>Zhodnoťte gastrointestinálne príznaky</strong> — nevoľnosť, vracanie, dyspepsiu, zmenu vyprázdňovania.</li>
  <li><strong>Vyčerpajte opatrenia skôr, než prepnete.</strong> Pred zmenou prípravku pre gastrointestinálnu neznášanlivosť je rozumné overiť, či pacient skutočne užíva predpísanú dávku (zníženie dávky nevoľnosť často odstráni), či dodržiava diétne odporúčania (menšie porcie, vyhýbanie sa tučným jedlám) a či neprispievajú iné lieky — <strong>metformín a akarbóza môžu príznaky zhoršovať</strong> a dočasné vysadenie metformínu môže problém vyriešiť bez zmeny GLP-1 RA.</li>
</ol>

<h2>Prechodné zhoršenie glykémie: očakávaný jav, nie zlyhanie</h2>

<p>Pri prechode z krátkodobo pôsobiaceho na dlhodobo pôsobiaci prípravok môže nastať <strong>malý prechodný vzostup glykémie nalačno</strong>. Modelovanie expozície a odpovede tiež naznačuje, že pri prechode z dulaglutidu 1,5 mg alebo liraglutidu 1,2 až 1,8 mg na <em>úvodnú</em> dávku semaglutidu 0,25 mg týždenne môže HbA1c spočiatku stúpnuť — s tým, že po tomto prechodnom zhoršení nasleduje ďalšie zlepšenie nad rámec pôvodnej liečby.</p>

<p>Prakticky to znamená dve veci. Po prvé, <strong>pacienta na to treba pripraviť</strong>, najmä ak si sám meria glykémie — inak zmenu vyhodnotí ako zlyhanie a liečbu vysadí. Po druhé, <strong>úvodnú dávku nového prípravku možno prispôsobiť</strong>, aby sa tento efekt zmiernil; práve preto sa pri dobre tolerovanej maximálnej dávke odporúča nezačínať od najnižšieho stupňa.</p>

<h3>Hypoglykémia: kde skutočne hrozí</h3>

<p>Riziko hypoglykémie je pri všetkých GLP-1 RA nízke a žiadne priame porovnanie nepreukázalo výhodu jedného prípravku nad druhým. Nebezpečná je však <strong>súbežná liečba inzulínom alebo derivátmi sulfonylmočoviny</strong> — keď nový, účinnejší GLP-1 RA začne pôsobiť, dávky týchto liekov môžu byť zrazu priveľké. Pri prepnutí na účinnejší prípravok preto treba mať pripravený plán na <strong>zníženie alebo dočasné prerušenie</strong> inzulínu či sulfonylmočoviny a zabezpečiť častejšie sledovanie glykémií v prvých týždňoch a po každom zvýšení dávky.</p>

<h2>Nefrologická časť: kde sa to môže pokaziť</h2>

<p>Diabetologické texty o prepínaní GLP-1 RA sa renálnej bezpečnosti venujú okrajovo. Pri pacientovi s chronickou chorobou obličiek pritom práve tu leží najväčšie riziko.</p>

<h3>1) Nie všetky GLP-1 RA sú pri CKD rovnaké</h3>

<p>Rozšírená predstava, že „GLP-1 RA nemajú renálne obmedzenie“, je pravdivá len <strong>čiastočne</strong>. Odporúčania, ktoré umožňujú GLP-1 RA použiť v prvej línii vtedy, keď znížená renálna funkcia vylučuje metformín, sa výslovne týkajú <strong>len humánnych analógov</strong> (liraglutid, dulaglutid, semaglutid). Liečivá odvodené od exendínu (exenatid, lixisenatid) sa z obehu odstraňujú prevažne obličkami a ich použitie je pri pokročilejšej renálnej insuficiencii obmedzené.</p>

<p><strong>Toto je najčastejšia pasca pri prepínaní u pacienta s CKD</strong> — zámena v rámci „tej istej skupiny“ môže znamenať prechod na liečivo, ktoré je pri danom eGFR nevhodné. Konkrétne hranice overte v SPC príslušného prípravku; princíp je, že <em>exendínové</em> analógy vyžadujú renálnu pozornosť, humánne analógy spravidla nie.</p>

<h3>2) Hlavné riziko nie je liek, ale objem</h3>

<p>V kazuistickej sérii publikovanej v <em>Kidney Medicine</em> (2021) sa u dvoch pacientov s chronickou chorobou obličiek na podklade diabetickej nefropatie po nasadení semaglutidu rýchlo zhoršila renálna funkcia a stúpla proteinúria. U jedného z nich biopsia ukázala pokročilú difúznu a nodulárnu glomerulosklerózu sprevádzanú <strong>intersticiálnym lymfoplazmocytárnym a eozinofilným infiltrátom a známkami akútneho tubulárneho poškodenia</strong>.</p>

<p>Autori z toho vyvodzujú záver, ktorý je priamo prevediteľný do praxe a ktorý platí pre celú skupinu:</p>

<blockquote>
<p>Väčšina nepriaznivých renálnych udalostí nastala u pacientov, ktorí mali <strong>gastrointestinálne nežiaduce príznaky</strong>. U takých pacientov treba vyšetriť laboratórne parametre a pri akútnom zhoršení renálnej funkcie liečivo vysadiť. Pri stredne ťažkej až ťažkej CKD je namieste opatrnosť pre obmedzenú renálnu rezervu.</p>
</blockquote>

<p>Mechanizmus je nezáživný, ale dôležitý: <strong>nevoľnosť, vracanie a hnačka vedú k zníženému príjmu tekutín a k objemovej deplécii</strong>. U pacienta, ktorý súčasne užíva diuretikum a blokádu systému renín-angiotenzín-aldosterón, sa z toho rýchlo stane akútne poškodenie obličiek. Pri prepnutí na účinnejší prípravok — alebo pri retitrácii po prestávke — sa gastrointestinálne príznaky typicky <em>vrátia</em>, takže okno rizika sa otvára znova.</p>

<h3>3) Pre koho to platí dvojnásobne</h3>

<p>Riziko nie je rovnomerné. Zvýšenú pozornosť si zaslúžia pacienti s:</p>

<ul>
  <li>eGFR pod 45 ml/min/1,73 m² a najmä CKD G4 a vyššie,</li>
  <li>súbežnou liečbou diuretikom, ACE-inhibítorom alebo sartanom, prípadne inhibítorom SGLT2,</li>
  <li>krehkosťou, vyšším vekom a nízkou telesnou hmotnosťou,</li>
  <li>anamnézou predchádzajúceho AKI.</li>
</ul>

<h3>4) Spomalené vyprázdňovanie žalúdka a ostatné lieky</h3>

<p>Všetky GLP-1 RA spomaľujú vyprázdňovanie žalúdka, čo môže ovplyvniť vstrebávanie perorálnych liekov. Vo väčšine prípadov to nie je klinicky významné, ale <strong>opatrnosť je namieste pri liečivách s úzkym terapeutickým oknom</strong> — menovite pri <strong>levotyroxíne a warfaríne</strong>. Pri exenatide podávanom spolu s warfarínom bolo opísané zvýšené riziko krvácania. V nefrologickej populácii s polyfarmáciou je to reálna úvaha, nie teoretická — širší kontext dáva článok <a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">o CKD ako samostatnom faktore polyfarmácie</a>.</p>

<h2>Prečo to celé stojí za námahu: FLOW</h2>

<p>Opatrnosť uvedená vyššie neznamená zdržanlivosť v indikácii. Štúdia <strong>FLOW</strong> (<em>New England Journal of Medicine</em>, 2024) zaradila <strong>3533 pacientov</strong> s diabetom 2. typu a chronickou chorobou obličiek (eGFR 50 – 75 ml/min/1,73 m² s UACR 300 – 5000, alebo eGFR 25 – &lt; 50 s UACR 100 – 5000) a randomizovala ich na subkutánny semaglutid 1,0 mg týždenne alebo placebo. Pri mediáne sledovania 3,4 roka — štúdia bola predčasne ukončená na odporúčanie po prednastavenej priebežnej analýze:</p>

<ul>
  <li><strong>Primárny ukazovateľ</strong> (zlyhanie obličiek, pokles eGFR o ≥ 50 % alebo úmrtie z renálnej či kardiovaskulárnej príčiny) bol o <strong>24 % nižší</strong> — 331 oproti 410 prvým udalostiam; pomer rizík 0,76 (95 % IS 0,66 – 0,88); p = 0,0003.</li>
  <li><strong>Renálne zložky</strong> samostatne: pomer rizík 0,79 (95 % IS 0,66 – 0,94).</li>
  <li><strong>Kardiovaskulárne úmrtie</strong>: pomer rizík 0,71 (95 % IS 0,56 – 0,89).</li>
  <li><strong>Ročný sklon eGFR</strong> bol miernejší o 1,16 ml/min/1,73 m² (p &lt; 0,001).</li>
  <li><strong>Veľké kardiovaskulárne príhody</strong> o 18 % nižšie (0,82; 0,68 – 0,98), <strong>úmrtie z akejkoľvek príčiny</strong> o 20 % nižšie (0,80; 0,67 – 0,95).</li>
  <li><strong>Závažné nežiaduce udalosti boli menej časté</strong> v semaglutidovej vetve: 49,6 % oproti 53,8 %.</li>
</ul>

<p>Posledný bod stojí za zdôraznenie. Rešpekt k riziku objemovej deplécie neznamená, že liečivo je u pacienta s CKD nebezpečné — v randomizovanom porovnaní bol celkový bezpečnostný profil <em>priaznivejší</em> než pri placebe. Riziko sa sústreďuje do úzkych okien: <strong>začiatok liečby, každé zvýšenie dávky, prepnutie prípravku a interkurentné ochorenie.</strong> Širší prehľad renálnych prínosov tejto skupiny rozoberá <a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">samostatný článok</a>.</p>

<h2>Praktický postup pri prepnutí u pacienta s CKD</h2>

<ol>
  <li><strong>Pred zmenou:</strong> skontrolujte eGFR a či je <em>cieľový</em> prípravok pri tejto renálnej funkcii vhodný (exendínové verzus humánne analógy). Zdokumentujte východiskový kreatinín, ionogram, krvný tlak a hmotnosť.</li>
  <li><strong>Zvoľte načasovanie</strong> podľa tabuľky vyššie — bez medzery pri dobre tolerovanej maximálnej dávke, s medzerou a od najnižšej dávky pri neznášanlivosti.</li>
  <li><strong>Pripravte plán pre inzulín a sulfonylmočovinu</strong>, ak ich pacient užíva, vrátane prahov na zníženie dávky.</li>
  <li><strong>Dajte pacientovi „pravidlo chorého dňa“</strong>: pri výraznej nevoľnosti, opakovanom vracaní, dlhšie trvajúcej hnačke alebo zjavne zníženom príjme tekutín sa má ozvať a dočasne prerušiť diuretikum, blokádu RAAS a inhibítor SGLT2 podľa dohodnutého plánu — a dať si skontrolovať kreatinín a ionogram.</li>
  <li><strong>Kontrola do 2 až 3 mesiacov</strong> od prepnutia: primeranosť titrácie, nežiaduce účinky, potreba úpravy ostatných liekov a dosiahnutie terapeutických cieľov. Pri gastrointestinálnych príznakoch, poklese hmotnosti alebo hypotenzii skôr.</li>
</ol>

<p>Dve poznámky k očakávaniam, ktoré šetria zbytočné zmeny liečby: titrácia subkutánneho semaglutidu na 1 mg môže trvať <strong>3 mesiace</strong>, takže maximálny glykemický prínos sa nemusí prejaviť skôr než <strong>6 mesiacov</strong> po prepnutí; úbytok hmotnosti podľa klinickej skúsenosti autorov zvyčajne pokračuje <strong>9 až 12 mesiacov</strong>. Zároveň platí, že výrazná zmena hmotnosti si môže vyžiadať úpravu antihypertenzív aj substitúcie hormónov štítnej žľazy.</p>

<h2>Čo z toho platí a čo je názor</h2>

<p>Poctivosť si žiada rozlíšenie, ktoré sa v prehľadových článkoch často stráca:</p>

<ul>
  <li><strong>Údaje o porovnateľnej účinnosti</strong> jednotlivých prípravkov pochádzajú z randomizovaných štúdií priameho porovnania — sú pevné, ale štúdie sa líšili dávkami aj súbežnou liečbou.</li>
  <li><strong>Konkrétne odporúčania pre prepínanie</strong> sú z veľkej časti <em>názorom autorov</em> opretým o klinickú skúsenosť. Priamych štúdií prepínania je málo a autori túto medzeru sami priznávajú.</li>
  <li><strong>Údaje o renálnom poškodení</strong> pri GLP-1 RA pochádzajú z kazuistík a postmarketingových hlásení — nie z randomizovaných dát. Oproti nim stojí randomizovaná FLOW s priaznivým bezpečnostným profilom. Správna syntéza nie je „liek škodí obličkám“, ale <strong>„objemová deplécia škodí obličkám a tento liek ju môže vyvolať“</strong>.</li>
</ul>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Almandoz JP, Lingvay I, Morales J, Campos C. <em>Switching Between Glucagon-Like Peptide-1 Receptor Agonists: Rationale and Practical Guidance.</em> Clin Diabetes 2020;38(4):390–402. <a href="https://doi.org/10.2337/cd19-0100" target="_blank" rel="noopener noreferrer">doi:10.2337/cd19-0100</a> (PMID 33132510).</li>
  <li>Perkovic V, Tuttle KR, Rossing P a kol. <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes</em> (štúdia FLOW). N Engl J Med 2024;391(2):109–121. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa2403347</a> (PMID 38785209).</li>
  <li>Leehey DJ, Rahman MA, Borys E, Picken MM, Clise CE. <em>Acute Kidney Injury Associated With Semaglutide.</em> Kidney Med 2021;3(2):282–285. <a href="https://doi.org/10.1016/j.xkme.2020.10.008" target="_blank" rel="noopener noreferrer">doi:10.1016/j.xkme.2020.10.008</a> (PMID 33851124).</li>
</ol>

<p><em>Bibliografické údaje všetkých citovaných prác boli overené v databáze PubMed.</em></p>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a nenahrádza platné súhrny charakteristických vlastností liečiva. Dostupnosť prípravkov, schválené indikácie a renálne obmedzenia sa medzi krajinami líšia — vždy overte v aktuálnom SPC.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_prehadzovanie-glp1-agonistov-prakticky-postup-ckd_article',
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
