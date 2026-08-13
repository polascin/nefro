<?php
/**
 * Odborne a jazykovo revidovaný článok o bolesti v driekovej oblasti a ischiase.
 *
 * Text je syntézou inštitucionálnych odporúčaní a overenej odbornej literatúry.
 * Nejde o spracovanie jednej publikácie s osobným autorstvom, preto sa autori
 * citovaných prác nepridávajú do source_authors.php.
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
    'title'        => 'Bolesť v driekovej oblasti a ischias: diagnostika, liečba a bezpečnosť analgetík pri CKD',
    'slug'         => 'bolest-driekovej-oblasti-ischias-diagnostika-liecba-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Bolesť v driekovej oblasti spravidla nevyžaduje okamžité MRI. Praktický algoritmus odlišuje urgentné príčiny, ischias a bezpečnú liečbu pri CKD.',
    'content'      => <<<'HTML'
<p>Bolesť v driekovej oblasti patrí medzi najčastejšie príčiny obmedzenia pohyblivosti, pracovnej neschopnosti a užívania analgetík. Vo väčšine prípadov ide o nešpecifickú muskuloskeletálnu bolesť s priaznivým prirodzeným priebehom. Menšia časť pacientov má radikulárny syndróm alebo konkrétne ochorenie, pri ktorom treba diagnostiku a liečbu zásadne zmeniť.</p>

<p>Správny prvý krok preto nie je automatické zobrazenie chrbtice ani kombinovanie viacerých liekov. Rozhodujúce je vylúčiť časovo kritickú príčinu, klasifikovať klinický syndróm, posúdiť prognostické faktory a vybrať intervencie s primeraným pomerom prínosu a rizika. Pri chronickej chorobe obličiek (CKD) treba navyše pred každým analgetickým plánom zohľadniť funkciu obličiek, objemový stav, súbežnú liečbu a riziko kumulácie liekov alebo ich metabolitov.</p>

<h2>Jedna lokalizácia, viac klinických syndrómov</h2>

<p>Pre praktické rozhodovanie je užitočné rozlíšiť tri skupiny: nešpecifickú bolesť v driekovej oblasti, radikulárnu bolesť alebo radikulopatiu a bolesť spôsobenú špecifickým ochorením.</p>

<h3>Nešpecifická bolesť v driekovej oblasti</h3>

<p>Pri nešpecifickej bolesti nemožno bežným klinickým vyšetrením spoľahlivo určiť jedinú anatomickú štruktúru ako príčinu ťažkostí. Bolesť môže súvisieť s medzistavcovými platničkami, drobnými kĺbmi, väzmi, svalmi aj so zmeneným spracovaním bolesti. Označenie <em>nešpecifická</em> neznamená, že bolesť nie je reálna alebo klinicky významná.</p>

<h3>Radikulárna bolesť, radikulopatia a ischias</h3>

<p>Ischias je klinické označenie bolesti vyžarujúcej z driekovej alebo gluteálnej oblasti do dolnej končatiny v distribúcii nervového koreňa. Radikulárna bolesť môže byť prítomná bez objektívneho neurologického výpadku. Radikulopatia znamená poruchu funkcie koreňa, ktorú podporuje motorický, senzorický alebo reflexný deficit.</p>

<p>Najčastejšou príčinou býva hernia medzistavcovej platničky alebo degeneratívne zúženie priestoru pre nervový koreň. Samotná protrúzia či hernia na magnetickej rezonancii však kauzalitu nepotvrdzuje. Nález musí zodpovedať strane, úrovni a klinickej distribúcii príznakov.</p>

<h3>Špecifická alebo prenesená bolesť</h3>

<p>Cielené vyšetrenie vyžaduje podozrenie na vertebrálnu fraktúru, infekciu, malignitu, zápalovú spondyloartritídu, syndróm caudae equinae, aneuryzmu brušnej aorty alebo inú cievnu, retroperitoneálnu, panvovú, renálnu či urologickú príčinu.</p>

<h2>Anamnéza a vyšetrenie určujú ďalší postup</h2>

<p>Treba zhodnotiť začiatok a trvanie ťažkostí, distribúciu bolesti, vzťah k pohybu a polohe, neurologické príznaky, úraz, osteoporózu, infekčné a nádorové riziká, imunosupresiu, lieky a celkové prejavy ochorenia. Neurologické vyšetrenie zahŕňa svalovú silu, citlivosť a reflexy; podľa klinickej situácie aj napínacie testy nervových koreňov. Pozitívny Lasègueov test podporuje dráždenie koreňov L5 alebo S1, ale neurčuje jeho anatomickú príčinu.</p>

<p>Takzvané červené vlajky nie sú samostatným diagnostickým testom. Mnohé jednotlivé príznaky, napríklad nočná bolesť alebo vyšší vek, majú nízku špecificitu. Ich význam rastie pri relevantnej kombinácii, vysokej intenzite, progresii a rizikovom kontexte. Závažnú diagnózu nemožno vylúčiť iba preto, že chýba jedna typická červená vlajka.</p>

<div class="pdf-keep-together">
  <h2>Stavy, pri ktorých rozhoduje čas</h2>
  <h3>Syndróm caudae equinae</h3>
  <p>Urgentné nemocničné posúdenie vyžaduje najmä nová retencia moču alebo inkontinencia, strata citlivosti v sedlovej oblasti, nová porucha análneho zvierača alebo sexuálnej funkcie, obojstranný ischias a závažný alebo progresívny motorický deficit. Pri dôvodnom podozrení je potrebná urgentná magnetická rezonancia a bezodkladné spinálne chirurgické posúdenie. Neprítomnosť jedného príznaku ani zachované spontánne močenie nevylučujú skorú fázu syndrómu.</p>
</div>

<h3>Infekcia chrbtice</h3>

<p>Na natívnu vertebrálnu osteomyelitídu, spondylodiscitídu alebo epidurálny absces treba myslieť pri novej alebo zhoršujúcej sa bolesti chrbtice s horúčkou, zvýšeným CRP alebo sedimentáciou, bakterémiou, infekčnou endokarditídou alebo neurologickým deficitom. Horúčka nemusí byť prítomná.</p>

<p>Riziko zvyšujú hemodialýza, intravaskulárny katéter, imunosupresia, intravenózne užívanie drog a nedávny invazívny výkon. U pacienta s novou lokalizovanou bolesťou po nedávnej bakterémii spôsobenej <em>Staphylococcus aureus</em> treba infekciu chrbtice cielene vylúčiť. IDSA pri podozrení odporúča hemokultúry, CRP alebo sedimentáciu a MRI chrbtice.</p>

<h3>Malignita, fraktúra a cievna príčina</h3>

<p>Podozrenie na malignitu zvyšuje najmä predchádzajúce nádorové ochorenie spolu s novou progresívnou bolesťou, nevysvetleným chudnutím, systémovými príznakmi alebo neurologickým deficitom. Vertebrálnu fraktúru treba zvažovať po závažnejšom úraze, pri osteoporóze, dlhodobej liečbe glukokortikoidmi alebo po malej traume u človeka s oslabenou kosťou. Pri CKD G4 až G5D môže riziko fragilnej zlomeniny zvyšovať CKD-MBD.</p>

<p>Náhla intenzívna bolesť chrbta alebo brucha s hypotenziou, pulzujúcou rezistenciou, ischémiou končatiny alebo nevysvetleným poklesom hemoglobínu vyžaduje okamžité posúdenie cievnej či retroperitoneálnej príčiny. Analgetická odpoveď závažné ochorenie nevylučuje.</p>

<h2>Kedy môže bolesť pochádzať z obličiek alebo močových ciest</h2>

<p>Bolesť pri renálnej alebo urologickej príčine býva častejšie v boku alebo v kostovertebrálnom uhle než v strednej driekovej oblasti, lokalizácia však nie je absolútna. Poklepová citlivosť sama osebe nerozlišuje pyelonefritídu, obštrukciu ani muskuloskeletálnu bolesť.</p>

<ul>
  <li><strong>Urolitiáza:</strong> typická je náhla kolikovitá bolesť s vyžarovaním do slabiny, nauzeou alebo vracaním; neprítomnosť hematúrie kameň nevylučuje.</li>
  <li><strong>Pyelonefritída:</strong> bolesť v boku môže sprevádzať horúčka, zimnica, dysúria, polakizúria a celková alterácia. U starších alebo imunokompromitovaných ľudí môže byť obraz neúplný.</li>
  <li><strong>Obštrukcia:</strong> obojstranná obštrukcia alebo obštrukcia solitárnej obličky môže spôsobiť akútne poškodenie obličiek aj bez výraznej bolesti. Oligúria, anúria alebo rast kreatinínu vyžadujú urgentné vyšetrenie.</li>
  <li><strong>Ďalšie príčiny:</strong> renálny infarkt, krvácanie alebo infekcia cysty, nádor a spontánne retroperitoneálne krvácanie, najmä pri antikoagulačnej liečbe.</li>
</ul>

<p>Ak klinika smeruje k močovým cestám, treba voliť laboratórne a zobrazovacie vyšetrenia podľa tejto diferenciálnej diagnózy. Odporúčanie nerobiť rutinne MRI chrbtice neznamená odkladať ultrasonografiu, CT alebo cievne vyšetrenie pri inom dôvodnom podozrení.</p>

<h2>Zobrazovanie iba vtedy, keď môže zmeniť postup</h2>

<p>NICE neodporúča rutinné zobrazovanie nekomplikovanej bolesti v driekovej oblasti ani ischiasu v nešpecializovanej starostlivosti. V špecializovanom prostredí sa má zvažovať iba vtedy, keď výsledok pravdepodobne zmení liečbu.</p>

<p>Okamžité alebo urgentné zobrazenie je odôvodnené pri podozrení na syndróm caudae equinae, infekciu, malignitu, fraktúru alebo iný časovo kritický stav. MRI je spravidla preferovanou metódou pri neurologickom útlaku, infekcii a malignite; konkrétny protokol a použitie kontrastnej látky závisia od klinickej otázky.</p>

<p class="pdf-avoid-break">Pri podozrení na fraktúru alebo na ochorenie mimo chrbtice môže byť vhodný iný zobrazovací algoritmus.</p>

<p>Pri pretrvávajúcich alebo progredujúcich príznakoch po približne šiestich týždňoch primeranej liečby odporúča ACR MRI najmä vtedy, keď je pacient kandidátom na operáciu alebo intervenčný výkon a výsledok ovplyvní ďalší postup. Šesť týždňov nie je čakacia lehota pri červených vlajkách.</p>

<p>Degenerácia platničiek, protrúzie a artróza drobných kĺbov sú časté aj u ľudí bez príznakov. Pred vyšetrením je preto vhodné vysvetliť, akú otázku má zobrazenie zodpovedať a ako sa podľa možných výsledkov zmení liečba.</p>

<h2>Základom liečby je aktívny prístup</h2>

<p>Pacient má dostať zrozumiteľné vysvetlenie pravdepodobnej diagnózy, priaznivého priebehu väčšiny nešpecifických epizód a príznakov, pri ktorých sa má vrátiť skôr. Odporúča sa podľa tolerancie pokračovať v bežných aktivitách, vyhnúť sa dlhodobému pokoju na lôžku a postupne obnovovať pohyb aj pracovnú záťaž.</p>

<p>Cvičebný program sa má prispôsobiť funkčnému stavu, preferenciám, komorbiditám a pravdepodobnosti dlhodobej adherencie. Neexistuje jediný univerzálne najlepší druh cvičenia. Pri pokročilej CKD, dialýze, krehkosti, kardiovaskulárnom ochorení alebo renálnej osteodystrofii treba upraviť intenzitu a riziko pádov či zlomenín.</p>

<p>Manipulácia, mobilizácia alebo mäkké techniky môžu niektorým pacientom krátkodobo pomôcť, podľa NICE však majú byť iba súčasťou programu zahŕňajúceho cvičenie. Trakcia, bedrové pásy, korzety, ortopedické vložky a kolísková obuv sa na rutinnú liečbu neodporúčajú.</p>

<h3>Prečo sa odporúčania o akupunktúre a psychologickej liečbe líšia</h3>

<p>NICE neodporúča akupunktúru pri bolesti v driekovej oblasti ani ischiase. WHO ju medzi podmienečne použiteľné postupy zaraďuje, jeho odporúčanie sa však týka chronickej primárnej bolesti u dospelých v primárnej a komunitnej starostlivosti, nie akútnej bolesti ani špecifických príčin. Rozdiel preto nemožno zredukovať na jednoduché tvrdenie, že jedna smernica má pravdu a druhá nie.</p>

<p>NICE 29. júla 2026 stiahlo odporúčania o psychologickej terapii a kombinovaných fyzicko-psychologických programoch bez okamžitej náhrady. Toto rozhodnutie nie je dôkazom škodlivosti psychologických intervencií a neruší význam psychosociálnych faktorov, depresie, spánku, obáv z pohybu ani spoločného rozhodovania. WHO pri chronickej primárnej bolesti naďalej používa biopsychosociálny a individualizovaný rámec.</p>

<h2>Lieky sú doplnkom, nie jadrom dlhodobej liečby</h2>

<p>Farmakoterapia má mať vopred definovaný cieľ, časové ohraničenie a plán prehodnotenia. Treba overiť všetky voľnopredajné a kombinované prípravky, pretože pacient nemusí považovať ibuprofén, diklofenak alebo paracetamol v prípravku proti prechladnutiu za analgetickú liečbu.</p>

<h3>Nesteroidové protizápalové lieky</h3>

<p>Pri nešpecifickej bolesti možno perorálny nesteroidový protizápalový liek (NSAID) u vhodne vybraného pacienta krátkodobo zvážiť. Pri ischiase NICE upozorňuje na obmedzené dôkazy o prínose a reálne riziko poškodenia. Ak sa NSAID použije, má ísť o najnižšiu účinnú dávku na najkratší potrebný čas po zhodnotení gastrointestinálneho, kardiovaskulárneho, hepatálneho a renálneho rizika.</p>

<p>NSAID znižujú syntézu prostaglandínov a môžu obmedziť prostaglandínmi sprostredkovaný prietok krvi obličkou. Následkom môže byť pokles glomerulovej filtrácie, retencia sodíka, edémy, vzostup krvného tlaku, hyperkaliémia, zhoršenie srdcového zlyhávania, akútna intersticiálna nefritída alebo nefrotický syndróm.</p>

<p>Riziko rastie pri CKD, vyššom veku, objemovej deplécii, vracaní alebo hnačke, sepse, srdcovom zlyhávaní, cirhóze a pri súbežnom užívaní diuretika alebo blokátora systému renín-angiotenzín. Kombinácia NSAID, diuretika a inhibítora ACE alebo blokátora receptorov angiotenzínu vytvára osobitne rizikové podmienky pre hemodynamické AKI.</p>

<p class="pdf-avoid-break">Pri aktívnom AKI, objemovej deplécii, hyperkaliémii, dekompenzovanom srdcovom zlyhávaní alebo pokročilej nestabilnej CKD sa systémovým NSAID treba spravidla vyhnúť. Ani pri stabilnej CKD s nižším individuálnym rizikom nemožno rozhodnutie založiť iba na jedinom prahu eGFR.</p>

<p class="pdf-avoid-break">KDIGO upozorňuje na škodlivosť nekontrolovaného chronického užívania, zároveň však pripúšťa, že starostlivo indikované NSAID pod dohľadom môžu byť v niektorých situáciách menej rizikové než opioidy.</p>

<p class="pdf-avoid-break">Ak očakávaný prínos preváži, treba zvážiť východiskovú a skorú kontrolu kreatinínu alebo eGFR, draslíka, krvného tlaku a hydratácie podľa individuálneho rizika.</p>

<p>Inhibítor protónovej pumpy môže znížiť niektoré gastrointestinálne komplikácie, ale nechráni obličky ani kardiovaskulárny systém. Ani lokálny NSAID nie je úplne bez systémovej absorpcie; jeho riziko je spravidla nižšie, nie nulové.</p>

<h3>Paracetamol</h3>

<p>NICE neodporúča paracetamol ako samostatnú rutinnú liečbu bolesti v driekovej oblasti pre obmedzenú účinnosť. Nejde však o absolútny zákaz. Pri CKD má paracetamol v odporúčaných dávkach spravidla priaznivejší renálny bezpečnostný profil než systémové NSAID, jeho očakávaný analgetický účinok však býva skromný.</p>

<p>Dávku treba prispôsobiť ochoreniu pečene, konzumácii alkoholu, podvýžive a súbežným liekom. Osobitne treba skontrolovať kombinované prípravky, aby nedošlo k neúmyselnému prekročeniu celkovej dennej dávky.</p>

<h3>Opioidy</h3>

<p>NICE neodporúča opioidy pri chronickej bolesti v driekovej oblasti ani pri chronickom ischiase. Pri akútnej bolesti v driekovej oblasti možno slabý opioid zvážiť iba vtedy, keď je NSAID kontraindikovaný, netolerovaný alebo neúčinný, a ani vtedy nemá ísť o rutinnú či dlhodobú liečbu. Pre akútny ischias chýba presvedčivý dôkaz podporujúci rutinné použitie.</p>

<p>Pri CKD sa farmakokinetika jednotlivých opioidov výrazne líši. Morfín a kodeín vytvárajú aktívne metabolity vylučované obličkami, ktoré sa môžu kumulovať a zvyšovať riziko sedácie, neurotoxicity a respiračného útlmu. Výber konkrétneho opioidu, dávky a intervalu preto musí zohľadniť eGFR, dialyzačnú liečbu, krehkosť, interakcie a riziko pádu. Označenie niektorého opioidu za všeobecne „bezpečný pri CKD“ by bolo zavádzajúce.</p>

<h3>Gabapentinoidy, kortikosteroidy a benzodiazepíny</h3>

<p>Gabapentín, pregabalín, iné antiepileptiká, perorálne glukokortikoidy a benzodiazepíny sa pri ischiase nemajú rutinne používať, pretože celkový prínos nebol presvedčivo preukázaný a liečba prináša poškodenia. Gabapentín aj pregabalín sa vylučujú prevažne obličkami. Pri inej oprávnenej indikácii vyžadujú úpravu dávky podľa funkcie obličiek; kumulácia môže viesť k výraznej sedácii, ataxii, myoklóniám alebo encefalopatii.</p>

<p>Kombinácia gabapentinoidu s opioidom alebo iným tlmivým liekom zvyšuje riziko respiračného útlmu. Dlhodobo užívané opioidy, benzodiazepíny ani gabapentinoidy sa nemajú náhle vysadiť bez individuálneho plánu postupného znižovania.</p>

<p>NICE neodporúča SSRI, SNRI ani tricyklické antidepresíva na liečbu samotnej nešpecifickej bolesti v driekovej oblasti. Toto odporúčanie sa nevzťahuje na samostatnú indikáciu, napríklad depresívnu poruchu alebo inú neuropatickú bolesť.</p>

<h2>Kedy zvažovať invazívny alebo chirurgický postup</h2>

<p>Epidurálnu injekciu lokálneho anestetika a glukokortikoidu možno podľa NICE zvážiť pri akútnom a závažnom ischiase. Očakávaný prínos býva prevažne krátkodobý. Epidurálne injekcie sa neodporúčajú pri neurogénnej klaudikácii spôsobenej centrálnou stenózou spinálneho kanála a spinálne injekcie sa nemajú používať na nešpecifickú bolesť v driekovej oblasti.</p>

<p>Rádiofrekvenčná denervácia je možnosťou iba pri starostlivo vybranej chronickej lokalizovanej bolesti po zlyhaní konzervatívnej liečby a po pozitívnej odpovedi na diagnostický blok mediálnej vetvy. Ani pozitívny blok nie je dokonalým potvrdením zdroja bolesti alebo zárukou dlhodobého úspechu.</p>

<p>Spinálnu dekompresiu možno zvážiť, keď neoperačná liečba nezlepšila bolesť alebo funkciu a zobrazovací nález zodpovedá ischiasu. Samotná hernia disku na MRI nie je indikáciou operácie. BMI, fajčenie ani psychická záťaž nemajú byť automatickou prekážkou odoslania na chirurgické posúdenie, hoci môžu meniť perioperačné riziko a výsledok.</p>

<div class="pdf-keep-together">
  <h2>Praktický ambulantný algoritmus</h2>
  <p>Postup možno zhrnúť do siedmich nadväzujúcich krokov:</p>
</div>

<ol>
  <li><strong>Najprv vyhľadať časovo kritický stav:</strong> syndróm caudae equinae, progresívny deficit, infekciu, malignitu, fraktúru, cievnu alebo inú viscerálnu príčinu.</li>
  <li><strong>Klasifikovať syndróm:</strong> nešpecifická bolesť, radikulárna bolesť, radikulopatia, neurogénna klaudikácia alebo prenesená bolesť.</li>
  <li><strong>Pri renálnych a urologických príznakoch zmeniť diagnostickú vetvu:</strong> moč, krvný obraz, kreatinín, zápalové parametre a vhodné zobrazenie podľa podozrenia.</li>
  <li><strong>Zobrazovať iba s konkrétnou otázkou:</strong> urgentne pri červených vlajkách, inak najmä vtedy, keď výsledok zmení liečbu alebo rozhodnutie o výkone.</li>
  <li><strong>Začať aktívny plán:</strong> edukácia, primeraná aktivita, postupný návrat k záťaži a individualizované cvičenie.</li>
  <li><strong>Pred liekom skontrolovať riziká:</strong> eGFR, AKI, hydratáciu, draslík, krvný tlak, srdcové a pečeňové ochorenie, antikoagulanciá, diuretiká, blokátory systému renín-angiotenzín a ďalšie tlmivé lieky.</li>
  <li><strong>Určiť termín prehodnotenia:</strong> nový deficit, porucha zvieračov, horúčka, chudnutie, zmena charakteru bolesti alebo celkové zhoršenie vyžadujú skoršie opakované vyšetrenie.</li>
</ol>

<h2>Záver</h2>

<p>Väčšina epizód bolesti v driekovej oblasti nevyžaduje okamžité MRI, pokoj na lôžku ani kombináciu viacerých analgetík. Kvalitná starostlivosť stojí na klinickej klasifikácii, včasnom rozpoznaní závažnej príčiny, udržaní aktivity a priebežnom prehodnocovaní.</p>

<p>Pri ischiase nie sú gabapentinoidy, perorálne kortikosteroidy, benzodiazepíny ani dlhodobé opioidy primeranou rutinnou liečbou. Pri CKD treba NSAID posudzovať individuálne: nekontrolované chronické užívanie je rizikové, no paušálne nahradenie opioidom nemusí byť bezpečnejšie. Rozumný plán spája reálny očakávaný prínos, najnižšiu potrebnú expozíciu, úpravu dávok podľa funkcie obličiek a cielené monitorovanie.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a></li>
  <li><a href="article.php?slug=usg-obliciek-mocovych-ciest-brucha">Ako prebieha USG vyšetrenie obličiek, močových ciest a brucha</a></li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Integrácia paliatívnej starostlivosti do nefrológie u krehkých starších pacientov</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Low back pain and sciatica in over 16s: assessment and management.</em> NICE Guideline NG59. Publikované 30. novembra 2016, naposledy aktualizované 29. júla 2026. <a href="https://www.nice.org.uk/guidance/ng59" target="_blank" rel="noopener noreferrer">NICE NG59</a>. <a href="https://www.nice.org.uk/guidance/ng59/chapter/Recommendations" target="_blank" rel="noopener noreferrer">Aktuálne odporúčania</a>. <a href="https://www.nice.org.uk/guidance/ng59/chapter/Update-information" target="_blank" rel="noopener noreferrer">História aktualizácií</a>.</li>
  <li><strong>World Health Organization.</strong> <em>WHO guideline for non-surgical management of chronic primary low back pain in adults in primary and community care settings.</em> Geneva: WHO; 2023. ISBN 978-92-4-008178-9. <a href="https://www.who.int/publications/i/item/9789240081789" target="_blank" rel="noopener noreferrer">WHO</a>.</li>
  <li><strong>American College of Radiology.</strong> <em>ACR Appropriateness Criteria: Low Back Pain.</em> Revidované 2021. <a href="https://acsearch.acr.org/docs/69483/Narrative/" target="_blank" rel="noopener noreferrer">ACR</a>.</li>
  <li><strong>Elie F. Berbari, Souha S. Kanj, Todd J. Kowalski et al.</strong> <em>2015 Infectious Diseases Society of America Clinical Practice Guidelines for the Diagnosis and Treatment of Native Vertebral Osteomyelitis in Adults.</em> Clinical Infectious Diseases. 2015;61(6):e26–e46. doi: 10.1093/cid/civ482. <a href="https://doi.org/10.1093/cid/civ482" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://www.idsociety.org/practice-guideline/vertebral-osteomyelitis/" target="_blank" rel="noopener noreferrer">IDSA</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plné odporúčanie</a>.</li>
  <li><strong>Amir Qaseem, Timothy J. Wilt, Robert M. McLean, Mary Ann Forciea; Clinical Guidelines Committee of the American College of Physicians.</strong> <em>Noninvasive Treatments for Acute, Subacute, and Chronic Low Back Pain: A Clinical Practice Guideline From the American College of Physicians.</em> Annals of Internal Medicine. 2017;166(7):514–530. doi: 10.7326/M16-2367. <a href="https://doi.org/10.7326/M16-2367" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28192789/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Roger Chou, Rongwei Fu, John A. Carrino, Richard A. Deyo.</strong> <em>Imaging strategies for low-back pain: systematic review and meta-analysis.</em> The Lancet. 2009;373(9662):463–472. doi: 10.1016/S0140-6736(09)60172-0. <a href="https://doi.org/10.1016/S0140-6736(09)60172-0" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/19200918/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Amanda M. Hall, Kris Aubrey-Bassler, Bradley Thorne, Chris G. Maher.</strong> <em>Do not routinely offer imaging for uncomplicated low back pain.</em> BMJ. 2021;372:n291. doi: 10.1136/bmj.n291. <a href="https://doi.org/10.1136/bmj.n291" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8023332/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Sylwester Drożdżal, Kacper Lechowicz, Bartosz Szostak et al.</strong> <em>Kidney damage from nonsteroidal anti-inflammatory drugs: myth or truth? Review of selected literature.</em> Pharmacology Research &amp; Perspectives. 2021;9(4):e00817. doi: 10.1002/prp2.817. <a href="https://doi.org/10.1002/prp2.817" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8313037/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Lyrica (pregabalin): EPAR and product information.</em> <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/lyrica" target="_blank" rel="noopener noreferrer">EMA</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>Neurontin, Gralise, Horizant (gabapentin) and Lyrica, Lyrica CR (pregabalin): Drug Safety Communication – Serious Breathing Problems.</em> 19. december 2019. <a href="https://www.fda.gov/safety/medical-product-safety-information/neurontin-gralise-horizant-gabapentin-and-lyrica-lyrica-cr-pregabalin-drug-safety-communication" target="_blank" rel="noopener noreferrer">FDA Drug Safety Communication</a>.</li>
  <li><strong>Medscape Reference Editorial Staff.</strong> <em>Low back pain and sciatica in over 16s: assessment and management.</em> Sekundárne redakčné spracovanie, ktoré nenahrádza aktuálny text NICE NG59. <a href="https://reference.medscape.com/cc2/p10/low-back-pain-and-sciatica-over-16s-assessment-and-2022a100123r" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom a aktuálnosti:</strong> Hlavným klinickým východiskom je aktuálna verzia NICE NG59, overená 13. augusta 2026. Jednotlivé odporúčania v NG59 vznikli v rôznych obdobiach; zmena z 29. júla 2026 sa týkala stiahnutia odporúčaní o psychologickej terapii a kombinovaných fyzicko-psychologických programoch. WHO sa vzťahuje iba na chronickú primárnu bolesť v driekovej oblasti. Farmakoterapiu treba pri konkrétnom pacientovi overiť podľa aktuálneho súhrnu charakteristických vlastností lieku, funkcie obličiek a miestnych odborných usmernení.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_bolest-driekovej-oblasti-ischias-diagnostika-liecba-ckd_article',
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
