<?php
/**
 * Odborny clanok: zavaznost CKD a prognoza pacientov prijatych na JIS (populacna studia z Ontaria).
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_zavaznost-ckd-prognoza-jis-populacna-studia_article.php"
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
    'title'        => 'Závažnosť chronickej choroby obličiek a prognóza pacientov prijatých na jednotku intenzívnej starostlivosti',
    'slug'         => 'zavaznost-ckd-prognoza-jis-populacna-studia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kanadská populačná štúdia s vyše 531 000 pacientmi ukázala stupňovitý nárast mortality, potreby náhrady funkcie obličiek aj dlhodobej dialyzačnej závislosti podľa závažnosti CKD. Prekvapením je nižšia upravená mortalita dialyzovaných než pacientov s nedialyzovaným štádiom G5.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Rozsiahla retrospektívna kohortová štúdia z kanadskej provincie Ontário ukázala, že s klesajúcou východiskovou glomerulovou filtráciou stúpali pravdepodobnosť úmrtia, potreba akútnej náhrady funkcie obličiek aj riziko pretrvávajúcej dialyzačnej závislosti. Výsledky pomáhajú pri odhade prognózy a v komunikácii s pacientom a rodinou, ale neumožňujú záver, že samotná chronická choroba obličiek pozorované výsledky kauzálne spôsobila.</em></p>

<h2>Prečo je téma dôležitá</h2>

<p>Chronická choroba obličiek (CKD) je u pacientov prijímaných na jednotky intenzívnej starostlivosti (JIS) neúmerne častá a predstavuje významný prognostický ukazovateľ. Doteraz však bolo málo jasné, ako presne sa prognóza mení naprieč jednotlivými stupňami závažnosti — a najmä, ako si stoja pacienti s nedialyzovaným 5. štádiom v porovnaní s pacientmi na udržiavacej dialýze.</p>

<p>Osobitnú opatrnosť si vyžaduje prekvapujúce zistenie tejto štúdie: pacienti liečení udržiavacou dialýzou mali <strong>nižšiu</strong> upravenú mortalitu než pacienti s nedialyzovaným štádiom G5.</p>

<h2>Dizajn a populácia štúdie</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre populačnej štúdie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>populačná retrospektívna kohortová štúdia</td></tr>
    <tr><th scope="row">Miesto</th><td>provincia Ontário, Kanada</td></tr>
    <tr><th scope="row">Obdobie</th><td>1. november 2008 až 28. február 2021</td></tr>
    <tr><th scope="row">Populácia</th><td>531 090 konsekutívnych dospelých (18 rokov a viac) prijatých na JIS</td></tr>
    <tr><th scope="row">Podmienka zaradenia</th><td>dostupný ambulantný sérový kreatinín 7 až 365 dní pred prijatím</td></tr>
    <tr><th scope="row">Expozícia</th><td>závažnosť CKD podľa východiskovej eGFR (kategórie KDIGO)</td></tr>
    <tr><th scope="row">Hlavné výsledky</th><td>mortalita na JIS, nemocničná a 90-dňová; začatie náhrady funkcie obličiek na JIS a závislosť od nej po 90 dňoch</td></tr>
    <tr><th scope="row">Štatistická analýza</th><td>23. júl 2025 až 16. apríl 2026</td></tr>
  </tbody>
</table>
</div>

<p>Priemerný vek bol 67 rokov (smerodajná odchýlka 15) a muži tvorili 57 % súboru.</p>

<div class="table-responsive" role="region" aria-label="Rozdelenie pacientov podľa východiskovej funkcie obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Východisková funkcia obličiek</th>
      <th scope="col">Podiel pacientov</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Bez CKD</th><td>eGFR najmenej 60 ml/min/1,73 m²</td><td>75 %</td></tr>
    <tr><th scope="row">G3a</th><td>eGFR 45 až 59 ml/min/1,73 m²</td><td>12 %</td></tr>
    <tr><th scope="row">G3b</th><td>eGFR 30 až 44 ml/min/1,73 m²</td><td>7 %</td></tr>
    <tr><th scope="row">G4</th><td>eGFR 15 až 29 ml/min/1,73 m²</td><td>3 %</td></tr>
    <tr><th scope="row">Nedialyzované G5</th><td>eGFR pod 15 ml/min/1,73 m²</td><td>1 %</td></tr>
    <tr><th scope="row">Udržiavacia dialýza</th><td>predchádzajúca chronická dialyzačná liečba</td><td>2 %</td></tr>
  </tbody>
</table>
</div>

<h2>Chronická choroba obličiek bola prítomná u štvrtiny pacientov</h2>

<p>Každý štvrtý pacient prijatý na JIS mal eGFR pod 60 ml/min/1,73 m² alebo bol liečený udržiavacou dialýzou. Ide o podstatne vyšší podiel než v bežnej dospelej populácii.</p>

<p>Takáto nadmerná reprezentácia je biologicky aj klinicky pravdepodobná. Pacienti s chronickou chorobou obličiek majú častejšie diabetes mellitus, kardiovaskulárne ochorenia, infekcie, poruchy vnútorného prostredia, anémiu, objemové preťaženie a vyššiu liekovú záťaž. Súčasne majú nižšiu funkčnú rezervu obličiek a vyššie riziko akútneho poškodenia obličiek pri sepse, hypotenzii, chirurgickom výkone alebo expozícii nefrotoxickým faktorom.</p>

<h2>Stupňovitý nárast 90-dňovej mortality</h2>

<div class="table-responsive" role="region" aria-label="Upravený pomer šancí 90-dňovej mortality podľa závažnosti CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Upravený pomer šancí</th>
      <th scope="col">95 % interval spoľahlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">G3a</th><td>1,14</td><td>1,11 až 1,17</td></tr>
    <tr><th scope="row">G3b</th><td>1,38</td><td>1,34 až 1,42</td></tr>
    <tr><th scope="row">G4</th><td>1,95</td><td>1,87 až 2,03</td></tr>
    <tr><th scope="row">Nedialyzované G5</th><td>2,32</td><td>2,14 až 2,52</td></tr>
    <tr><th scope="row">Udržiavacia dialýza</th><td>1,92</td><td>1,82 až 2,04</td></tr>
  </tbody>
</table>
</div>

<p>Referenčnou skupinou boli pacienti s eGFR najmenej 60 ml/min/1,73 m². Výsledky ukazujú konzistentný gradient rizika: aj mierne až stredne závažné zníženie eGFR bolo spojené s vyššou mortalitou, pričom najsilnejšia asociácia sa zistila pri nedialyzovanom štádiu G5.</p>

<p>Pomer šancí však nie je totožný s relatívnym rizikom. Ak je výsledok častý — a mortalita kriticky chorých pacientov častá je —, pomer šancí veľkosť relatívneho rizika opticky nadhodnocuje. Na klinickú interpretáciu sú preto potrebné aj absolútne riziká, ktoré publikovaný abstrakt neuvádza.</p>

<h2>Výrazný nárast potreby akútnej náhrady funkcie obličiek</h2>

<div class="table-responsive" role="region" aria-label="Upravený pomer šancí začatia náhrady funkcie obličiek na JIS" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Upravený pomer šancí začatia KRT</th>
      <th scope="col">95 % interval spoľahlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">G3a</th><td>1,79</td><td>1,68 až 1,90</td></tr>
    <tr><th scope="row">G3b</th><td>3,02</td><td>2,83 až 3,22</td></tr>
    <tr><th scope="row">G4</th><td>6,71</td><td>6,23 až 7,22</td></tr>
    <tr><th scope="row">Nedialyzované G5</th><td>32,00</td><td>29,07 až 35,22</td></tr>
  </tbody>
</table>
</div>

<p>Súvislosť je veľmi výrazná, ale výsledok nemožno interpretovať výlučne ako rozdiel vo výskyte závažného akútneho poškodenia obličiek. O začatí náhrady funkcie obličiek (KRT) rozhoduje kombinácia klinického stavu, východiskovej funkcie obličiek, hyperkaliémie, acidózy, objemového preťaženia, oligúrie, komplikácií urémie a odpovede na konzervatívnu liečbu.</p>

<p>Pacient s eGFR pod 15 ml/min/1,73 m² môže dosiahnuť indikáciu na dialýzu už pri menšom akútnom poklese funkcie než pacient s normálnou obličkovou rezervou. Časť pozorovaného gradientu preto vyplýva aj z rozdielnej vzdialenosti od klinického prahu na začatie liečby. Pri nedialyzovanom štádiu G5 sa navyše mohlo v časti prípadov ísť skôr o <em>plánovaný začiatok chronickej dialýzy urýchlený akútnym ochorením</em> než o klasické akútne poškodenie obličiek.</p>

<h2>Dĺžka hospitalizácie</h2>

<p>Dĺžka pobytu sa hodnotila pomocou upravených pomerov rizika s konkurenčným rizikom úmrtia. Hodnoty pod 1 znamenajú dlhšiu hospitalizáciu (nižšiu „šancu“ byť prepustený v danom čase):</p>

<div class="table-responsive" role="region" aria-label="Dĺžka hospitalizácie podľa závažnosti CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória</th>
      <th scope="col">Upravený pomer rizika prepustenia</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">G3a</th><td>0,94</td></tr>
    <tr><th scope="row">G3b</th><td>0,87</td></tr>
    <tr><th scope="row">G4</th><td>0,77</td></tr>
    <tr><th scope="row">Nedialyzované G5</th><td>0,65</td></tr>
    <tr><th scope="row">Udržiavacia dialýza</th><td>0,71</td></tr>
  </tbody>
</table>
</div>

<p>Gradient je opäť zreteľný a zodpovedá vyššej záťaži intenzívnej aj následnej starostlivosti u pacientov s pokročilejšou chorobou obličiek.</p>

<h2>Dialyzačná závislosť po 90 dňoch</h2>

<p>Spomedzi pacientov, u ktorých bola počas intenzívnej starostlivosti začatá náhrada funkcie obličiek <strong>a ktorí prežili do 90. dňa</strong>, zostávalo od nej závislých:</p>

<div class="table-responsive" role="region" aria-label="Dialyzačná závislosť po 90 dňoch podľa východiskovej závažnosti CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Východisková kategória</th>
      <th scope="col">Závislosť od KRT po 90 dňoch</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Bez CKD</th><td>7,2 %</td></tr>
    <tr><th scope="row">G3a</th><td>14,2 %</td></tr>
    <tr><th scope="row">G3b</th><td>22,5 %</td></tr>
    <tr><th scope="row">G4</th><td>50,3 %</td></tr>
    <tr><th scope="row">Predtým nedialyzované G5</th><td>83,8 %</td></tr>
  </tbody>
</table>
</div>

<p>Výsledok podporuje biologicky pravdepodobný predpoklad, že pravdepodobnosť zotavenia obličiek po kritickom ochorení závisí od východiskovej funkčnej rezervy.</p>

<p>Podmienka prežitia do 90. dňa je pri interpretácii kľúčová a treba ju čítať dvoma smermi. Na jednej strane vhodne odstraňuje konkurenčné riziko úmrtia — pacient, ktorý zomrie, sa nemôže zaradiť medzi osoby s pretrvávajúcou dialyzačnou závislosťou. Na druhej strane ide o výber na základe udalosti, ktorá nastala po expozícii, takže porovnávané skupiny prežívajúcich už nemusia byť porovnateľné. Pri pokročilej CKD navyše prežíva menšia časť pacientov, a práve tí najkrehkejší z prežívajúcich môžu mať najnižšiu šancu na obnovu funkcie.</p>

<p>Nie je tiež isté, či každá dialýza pokračujúca po 90 dňoch predstavovala nezvratné zlyhanie obličiek. Obnova funkcie môže u niektorých pacientov nastať aj neskôr.</p>

<div class="pdf-avoid-break">
<h2>Prečo mali dialyzovaní pacienti nižšiu mortalitu než pacienti s nedialyzovaným štádiom G5?</h2>

<p>Pacienti liečení udržiavacou dialýzou mali nižšiu upravenú šancu 90-dňovej mortality (1,92) než pacienti s nedialyzovaným štádiom G5 (2,32). Tento výsledok nemožno interpretovať ako dôkaz, že dialýza chráni kriticky chorých pacientov pred úmrtím.</p>

<p>Možné vysvetlenia zahŕňajú:</p>

<ol>
  <li><strong>Selekciu prežívajúcich pacientov.</strong> Pacienti na udržiavacej dialýze už prežili obdobie terminálneho zlyhania obličiek, prípravu cievneho prístupu a začiatok dialyzačnej liečby.</li>
  <li><strong>Rozdielnu multimorbiditu a krehkosť.</strong> V nedialyzovanej skupine G5 mohli byť pacienti, u ktorých sa dialýza nezačala pre vysokú krehkosť, pokročilé nádorové ochorenie, demenciu alebo konzervatívne zvolený cieľ starostlivosti.</li>
  <li><strong>Zavedenú nefrologickú starostlivosť.</strong> Dialyzovaní pacienti majú pravidelný kontakt so zdravotníckym systémom, známu „suchú hmotnosť“, funkčný cievny prístup a vopred stanovený spôsob riešenia hyperkaliémie, acidózy alebo objemového preťaženia.</li>
  <li><strong>Odlišné prahy prijatia na JIS.</strong> Indikácie na intenzívnu starostlivosť sa mohli medzi skupinami líšiť.</li>
  <li><strong>Reziduálne konfundujúce faktory.</strong> Ani rozsiahla štatistická adjustácia nedokáže odstrániť všetky rozdiely medzi nerandomizovanými skupinami.</li>
</ol>

<p>Výsledok preto treba chápať ako epidemiologickú asociáciu, nie ako terapeutický účinok dialýzy. Zároveň je to užitočné pripomenutie, že skupina „nedialyzované G5“ nie je homogénna — zahŕňa pacientov pred plánovaným začiatkom dialýzy aj pacientov v konzervatívnom manažmente zlyhania obličiek.</p>
</div>

<h2>Metodologické silné stránky</h2>

<p>Štúdia zahŕňala viac než pol milióna pacientov z univerzálneho zdravotníckeho systému a dlhé obdobie sledovania. Populačný dizajn znižuje riziko, že by výsledky odrážali iba skúsenosť jedného terciárneho pracoviska.</p>

<ul>
  <li>rozdelenie podľa viacerých kategórií závažnosti,</li>
  <li>oddelené hodnotenie nedialyzovaného štádia G5 a udržiavacej dialýzy,</li>
  <li>posúdenie mortality na JIS, nemocničnej aj 90-dňovej,</li>
  <li>hodnotenie začatia KRT aj následnej dialyzačnej závislosti,</li>
  <li>hodnotenie dĺžky hospitalizácie s konkurenčným rizikom úmrtia,</li>
  <li>konsekutívne zaraďovanie pacientov.</li>
</ul>

<p><strong>Adjustácia bola nadpriemerne dôkladná.</strong> Modely zohľadňovali vek, pohlavie, vidiecke bydlisko, príjmový kvintil obvodu, komorbidity (koronárnu chorobu, infarkt myokardu, diabetes, hypertenziu, srdcové zlyhávanie, arytmie, cievnu mozgovú príhodu, chronickú chorobu pečene, CHOCHP, HIV, nádorové ochorenie a poruchu z užívania alkoholu), využívanie zdravotnej starostlivosti v predchádzajúcom roku, podávanie vazopresorov a umelú pľúcnu ventiláciu pri prijatí, závažnosť stavu podľa skóre Multiple Organ Dysfunction Score, sepsu a ťažkú sepsu vrátane septického šoku.</p>

<p>Za obzvlášť premyslené považujem, že autori zo skóre MODS <strong>odpočítali obličkovú zložku</strong>. Ak by ju ponechali, časť skúmaného vplyvu obličiek by sa štatisticky „vysvetlila“ samotnou expozíciou a účinok by sa umelo zmenšil.</p>

<p>Veľkosť súboru priniesla presné odhady s úzkymi intervalmi spoľahlivosti. Štatistická presnosť však sama osebe neodstraňuje systematické skreslenie.</p>

<h2>Zásadné obmedzenia štúdie</h2>

<h3>Klasifikácia CKD podľa jediného kreatinínu</h3>

<p>Chronická choroba obličiek je definovaná abnormalitou štruktúry alebo funkcie obličiek pretrvávajúcou najmenej tri mesiace. Použitie posledného dostupného ambulantného kreatinínu túto podmienku nemuselo potvrdiť.</p>

<p>Presnejšie by preto bolo hovoriť o <em>kategóriách východiskovej eGFR</em>, nie vo všetkých prípadoch o spoľahlivo potvrdených štádiách CKD.</p>

<h3>Chýbala albuminúria</h3>

<p>Klasifikácia KDIGO používa kombináciu príčiny ochorenia, kategórie eGFR a albuminúrie. Pacient s eGFR nad 60 ml/min/1,73 m² a významnou albuminúriou môže mať CKD a zvýšené riziko, hoci bol v tejto analýze zaradený medzi pacientov bez CKD. Referenčná skupina teda pravdepodobne obsahuje časť pacientov so skutočnou chorobou obličiek, čo veľkosť pozorovaných rozdielov skôr podhodnocuje.</p>

<h3>Dlhý interval medzi meraním kreatinínu a prijatím</h3>

<p>Posledné meranie mohlo pochádzať až z obdobia jedného roka pred prijatím. Funkcia obličiek sa medzitým mohla zhoršiť alebo zlepšiť. Najmä pri pokročilej CKD, ktorá progreduje rýchlejšie, môže byť takýto časový odstup klinicky významný.</p>

<h3>Vylúčenie pacientov bez ambulantného kreatinínu</h3>

<p>Požiadavka dostupného predchádzajúceho merania mohla viesť k selekčnému skresleniu. Pacienti s meraným kreatinínom majú spravidla viac komorbidít a častejší kontakt so zdravotníctvom než osoby bez laboratórnych vyšetrení.</p>

<h3>Nezachytené akútne poškodenie obličiek pri prijatí</h3>

<p>Akútne poškodenie obličiek prítomné pri prijatí je významným nezávislým prognostickým faktorom. Hoci modely zohľadňovali celkovú závažnosť stavu, vazopresory, ventiláciu a sepsu, presné oddelenie vplyvu chronickej choroby od akútneho inzultu by vyžadovalo aj časové a závažnostné zaradenie AKI.</p>

<h3>Reziduálne konfundujúce faktory</h3>

<p>Napriek rozsiahlej adjustácii administratívne a laboratórne databázy nemusia zachytiť:</p>

<ul>
  <li>krehkosť a funkčný stav pred prijatím,</li>
  <li>výživový stav,</li>
  <li>rozhodnutia o nezahájení alebo ukončení KRT,</li>
  <li>limity resuscitácie a ciele starostlivosti,</li>
  <li>konzervatívny manažment zlyhania obličiek,</li>
  <li>preferencie pacienta,</li>
  <li>indikáciu a modalitu dialýzy.</li>
</ul>

<p>Práve tieto premenné sú pri rozdiele medzi nedialyzovaným G5 a udržiavacou dialýzou najpodozrivejšie.</p>

<h3>Časová heterogenita</h3>

<p>Obdobie rokov 2008 až 2021 zahŕňa zmeny v diagnostike AKI, načasovaní KRT, používaní kontinuálnych metód, intenzívnej medicíne aj v konzervatívnej liečbe pokročilej CKD. Súhrnný výsledok nemusí presne odrážať súčasnú prax.</p>

<div class="pdf-avoid-break">
<h2>Hĺbková vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o štúdii" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Štvrtina pacientov na JIS mala CKD</td><td><strong>Podporené použitou klasifikáciou</strong></td><td>Nie všetci pacienti spĺňali formálnu definíciu CKD potvrdenú trvaním najmenej tri mesiace</td></tr>
    <tr><td>Závažnejšia CKD predpovedá vyššiu mortalitu</td><td><strong>Potvrdená prognostická asociácia</strong></td><td>Observačný dizajn nepreukazuje kauzalitu; „predpovedá“ tu znamená štatistickú asociáciu</td></tr>
    <tr><td>Závažnosť CKD zvyšuje potrebu KRT</td><td><strong>Silná asociácia</strong></td><td>Výsledok ovplyvňuje aj nižšia východisková rezerva a klinický prah začatia KRT</td></tr>
    <tr><td>Vyššie štádium CKD znižuje pravdepodobnosť zotavenia obličiek</td><td><strong>Podporené</strong></td><td>Analýza zahŕňa len pacientov, ktorí prežili 90 dní, čo je výber po expozícii; možné je aj neskoršie zotavenie</td></tr>
    <tr><td>Udržiavacia dialýza znižuje mortalitu</td><td><strong>Nepreukázané</strong></td><td>Dialyzovaní mali nižšiu upravenú mortalitu než skupina G5 bez dialýzy, ale nejde o dôkaz ochranného účinku</td></tr>
    <tr><td>Pokročilejšia CKD predlžuje hospitalizáciu</td><td><strong>Potvrdené</strong></td><td>Pomer rizika prepustenia klesal z 0,94 pri G3a na 0,65 pri nedialyzovanom G5</td></tr>
    <tr><td>Výsledky možno použiť pri rozhodovaní o obmedzení intenzívnej liečby</td><td><strong>Nie samostatne</strong></td><td>Štádium CKD nesmie byť jediným kritériom; potrebné sú klinický stav, reverzibilita, krehkosť, prognóza a preferencie pacienta</td></tr>
    <tr><td>eGFR najmenej 60 ml/min/1,73 m² vylučuje CKD</td><td><strong>Nesprávne</strong></td><td>CKD môže byť prítomná pri albuminúrii, štrukturálnej abnormalite alebo inom markeri poškodenia aj pri zachovanej eGFR</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Klinické dôsledky</h2>

<p>Východisková eGFR je dôležitou súčasťou prognostického hodnotenia kriticky chorého pacienta. Pri pokročilej CKD treba už pri prijatí posúdiť:</p>

<ul>
  <li>predchádzajúci priebeh eGFR a albuminúrie,</li>
  <li>reverzibilitu akútneho poškodenia,</li>
  <li>diurézu a objemový stav,</li>
  <li>sérový draslík a acidobázickú rovnováhu,</li>
  <li>expozíciu nefrotoxickým faktorom,</li>
  <li>predchádzajúce nefrologické rozhodnutia vrátane plánu prípravy na KRT,</li>
  <li>cievny prístup a vhodnú modalitu KRT,</li>
  <li>celkovú prognózu, krehkosť a preferencie pacienta.</li>
</ul>

<p>Údaj o 83,8 % dialyzačnej závislosti po 90 dňoch u pacientov s predchádzajúcim nedialyzovaným štádiom G5 má konkrétne komunikačné využitie: ak sa u takého pacienta na JIS začne dialýza, je poctivé s ním a s rodinou hovoriť o tom, že návrat k liečbe bez dialýzy je málo pravdepodobný.</p>

<p><strong>Samotné štádium CKD nemá byť dôvodom na odmietnutie prijatia na jednotku intenzívnej starostlivosti ani na jednostranné obmedzenie liečby.</strong> Prognostické údaje majú podporovať individualizované rozhodovanie, nie ho nahrádzať.</p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Rozsiahla populačná štúdia potvrdila silnú a stupňovitú asociáciu medzi nižšou východiskovou eGFR a nepriaznivými výsledkami po prijatí na jednotku intenzívnej starostlivosti. So závažnosťou obličkovej dysfunkcie narastali 90-dňová mortalita, potreba akútnej náhrady funkcie obličiek, dĺžka hospitalizácie aj riziko pretrvávajúcej dialyzačnej závislosti.</p>

<p>Najvyššie riziko mortality sa zistilo pri nedialyzovanom štádiu G5. Nižšia mortalita pacientov na udržiavacej dialýze v porovnaní s touto skupinou pravdepodobne odráža selekciu pacientov, rozdielnu komorbiditu a organizáciu starostlivosti, nie ochranný účinok dialýzy.</p>

<p>Výsledky sú klinicky dôležité, ale nemožno ich používať ako izolovaný nástroj na rozhodovanie o primeranosti intenzívnej liečby. Potrebné je spoločné hodnotenie chronickej funkcie obličiek, akútneho ochorenia, krehkosti, reverzibility, celkovej prognózy a cieľov pacienta.</p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradnú liečbu obličiek (KRT) pri akútnom poškodení obličiek (AKI)</a></li>
  <li><a href="article.php?slug=estop-aki-strojove-ucenie-vcasna-konzultacia-nefrologa">ESTOP-AKI: algoritmus riziko rozpoznal, včasná konzultácia nefrológa však výsledky nezlepšila</a></li>
  <li><a href="article.php?slug=dapagliflozin-kardiochirurgia-aki-mercuri-2">Dapagliflozín pred kardiochirurgickou operáciou znížil výskyt akútneho poškodenia obličiek</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
  <li><a href="article.php?slug=neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt">Keď pacient nechce hovoriť o svojich hodnotách: skrytá prekážka spoločného rozhodovania o dialýze</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>El Wadia H, Beauregard N, Silver SA, Wald R, Akbari A, Fremont D, Ramsay T, Knoll GA, Clark EG, Hundemer GL.</strong> <em>Severity of Chronic Kidney Disease and Outcomes After Admission to the Intensive Care Unit.</em> JAMA Netw Open. 2026;9(6):e2620192. doi: 10.1001/jamanetworkopen.2026.20192. <a href="https://doi.org/10.1001/jamanetworkopen.2026.20192" target="_blank" rel="noopener noreferrer">Primárna publikácia (voľne dostupná)</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42348209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Acute Kidney Injury Work Group.</strong> <em>KDIGO Clinical Practice Guideline for Acute Kidney Injury.</em> Kidney Int Suppl. 2012;2(1):1–138. doi: 10.1038/kisup.2012.1. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/acute-kidney-injury/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Hoste EAJ, Bagshaw SM, Bellomo R, Cely CM, Colman R, Cruz DN, Edipidis K, Forni LG, Gomersall CD, Govil D, Honoré PM, Joannes-Boyau O, Joannidis M, Korhonen AM, Lavrentieva A, Mehta RL, Palevsky P, Roessler E, Ronco C, Uchino S, Vazquez JA, Vidal Andrade E, Webb S, Kellum JA.</strong> <em>Epidemiology of acute kidney injury in critically ill patients: the multinational AKI-EPI study.</em> Intensive Care Med. 2015;41(8):1411–1423. doi: 10.1007/s00134-015-3934-7. <a href="https://doi.org/10.1007/s00134-015-3934-7" target="_blank" rel="noopener noreferrer">Multinárodná epidemiologická štúdia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26162677/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Does CKD Severity Predict Adverse ICU Outcomes?</em> Medscape, 2026. Sekundárny spravodajský zdroj použitý ako východisko, nie ako hlavný dôkaz; individuálny autor nie je v sprístupnenej verzii uvedený. <a href="https://www.medscape.com/viewarticle/does-ckd-severity-predict-adverse-icu-outcomes-2026a1000rz9" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Údaje o dizajne, období, veľkosti súboru, rozdelení podľa kategórií eGFR, o pomeroch šancí začatia KRT a o podieloch dialyzačnej závislosti po 90 dňoch boli overené proti abstraktu publikácie (PubMed, PMID 42348209). Pomery šancí 90-dňovej mortality pre kategórie G3a, G3b a G4, hodnoty dĺžky hospitalizácie a úplný zoznam premenných zahrnutých do modelov boli doplnené z voľne dostupného plného textu v JAMA Network Open. Autorský zoznam bol overený cez PubMed — prvou autorkou je Hajar El Wadia, Gregory L. Hundemer je posledným (seniorným) autorom; mená neboli dopĺňané odhadom. Absolútne riziká mortality podľa jednotlivých kategórií abstrakt neuvádza a v texte sa preto neuvádzajú.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Prognostické údaje z observačnej štúdie nepreukazujú príčinný vzťah a nemajú slúžiť ako samostatné kritérium pri rozhodovaní o prijatí na jednotku intenzívnej starostlivosti, o začatí náhrady funkcie obličiek ani o obmedzení liečby. Rozhodovanie má vychádzať z klinického stavu, reverzibility, krehkosti, celkovej prognózy a hodnôt a preferencií pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_zavaznost-ckd-prognoza-jis-populacna-studia_article',
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
