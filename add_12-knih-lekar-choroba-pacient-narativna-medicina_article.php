<?php
/**
 * add_12-knih-lekar-choroba-pacient-narativna-medicina_article.php
 * Idempotentny UPSERT odborneho clanku o literature a narativnej medicine.
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

// Data clanku

$articles = [];

$articles[] = [
    'title'        => 'Dvanásť kníh, ktoré môžu lekárovi pomôcť lepšie rozumieť chorobe, pacientovi aj sebe',
    'slug'         => '12-knih-lekar-choroba-pacient-narativna-medicina',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dvanásť diel o bolesti, smrti, vede, transplantácii a profesijnej identite. Kriticky hodnotený výber ukazuje, čo môže literatúra priniesť lekárovi a kde sa končí jej dôkazná hodnota.',
    'content'      => <<<'HTML'
<p>Medicína sa nedá redukovať na diagnostické algoritmy, laboratórne hodnoty a terapeutické odporúčania. Lekár pracuje aj s neistotou, utrpením, nádejou, stratou, vzťahmi a etickými konfliktmi. Odborné časopisy poskytujú vedecké poznatky; literatúra môže sprostredkovať skúsenosť choroby spôsobom, ktorý štatistika zachytáva iba čiastočne.</p>

<p><strong>Čítanie beletrie ani medicínsko-historickej literatúry samo osebe nezaručuje lepšiu klinickú prax.</strong> Systematicky vedená naratívna medicína však môže podporovať sebareflexiu, vnímanie perspektívy pacienta a niektoré komunikačné či empatické zručnosti. Dôkazy sú heterogénne a výsledky vzdelávacích intervencií nemožno automaticky prenášať na rekreačné čítanie bez pedagogického vedenia.</p>

<p>Nasledujúci výber vychádza z dvanástich titulov, ktoré pre <em>Medscape</em> zostavil publicista Ted Spiker na základe odporúčaní ľudí prepájajúcich medicínu a literatúru. Nejde o vedecký rebríček ani o povinný kánon. Je to pozvanie premýšľať o bolesti, smrti, vedeckej dôveryhodnosti, transplantácii, profesijnej identite a vzťahu medzi lekárom a pacientom.</p>

<h2>Čo o naratívnej medicíne skutočne vieme</h2>

<p>Naratívna medicína rozvíja schopnosť rozpoznať, prijať, interpretovať a primerane zohľadniť príbeh chorého človeka. V praxi môže zahŕňať pozorné čítanie, reflexívne písanie, diskusiu o literárnom alebo výtvarnom diele a spracovanie klinickej skúsenosti.</p>

<p>Systematické prehľady ponúkajú opatrne povzbudivé, nie definitívne závery. Prehľad 36 publikácií z roku 2019 našiel merateľné zmeny najmä v účasti, postojoch, vedomostiach a zručnostiach, no nie jednoznačný dôkaz trvalej zmeny správania alebo interakcie s pacientmi. Kritický prehľad z roku 2026 zahrnul 17 štúdií umelecky orientovaného vzdelávania s 835 účastníkmi; iba štyri hodnotili naratívnu medicínu a vysoká heterogenita znemožnila metaanalýzu. Autori preto odporúčajú skôr lokálne, facilitované programy s realistickými očakávaniami než silné všeobecné tvrdenia.</p>

<p>Presné posolstvo teda znie: <strong>literatúra vytvára príležitosť na rozvoj naratívnej a etickej citlivosti, ale samotné prečítanie románu nie je dokázanou intervenciou na zlepšenie klinických výsledkov.</strong></p>

<h2>1. Alphonse Daudet: <em>In the Land of Pain</em></h2>

<p>Francúzsky spisovateľ Alphonse Daudet zachytil v útržkovitých poznámkach vlastnú skúsenosť s chronickou, postupne devastujúcou bolesťou pri neskorom neurologickom postihnutí spôsobenom syfilisom. Text neponúka klinický opis choroby podľa dnešných diagnostických kritérií. Jeho silou je jazyk pacienta, ktorý sa pokúša pomenovať neznesiteľnú, premenlivú a navonok často neviditeľnú skúsenosť.</p>

<p>Pre lekára je to pripomienka, že intenzitu bolesti nemožno spoľahlivo odvodiť od výrazu tváre alebo správania. Medicínsky názov symptómu zároveň nevystihuje jeho dosah na identitu, rodinu, čas ani schopnosť plánovať. Daudetove zápisky sú literárne spracovaným osobným svedectvom, nie klinickou dokumentáciou ani presnou rekonštrukciou prirodzeného priebehu neurosyfilisu.</p>

<h2>2. Christian Wiman: <em>Zero at the Bone</em></h2>

<p>Christian Wiman spája poéziu, esejistiku, literárnu kritiku, teológiu a autobiografiu. Jeho písanie formovala aj skúsenosť so vzácnou hematologickou malignitou. Kniha sa zaoberá zúfalstvom, vierou, utrpením, blízkosťou a možnosťou nájsť zmysel bez lacného optimizmu.</p>

<p>Pre klinika môže byť podnetná tým, že chorobu nepredstavuje iba ako biologickú poruchu, ale aj ako narušenie identity a životnej kontinuity. Pacientove duchovné alebo náboženské otázky nemusia byť príznakom ani problémom, ktorý má lekár vyriešiť. Môžu byť súčasťou spôsobu, akým človek znáša neistotu a konečnosť.</p>

<h2>3. Lindsey Fitzharris: <em>The Butchering Art</em></h2>

<p>Historická monografia sleduje premenu chirurgie v 19. storočí a úsilie Josepha Listera zaviesť antiseptické postupy. Lister, nadväzujúc na rozvoj mikrobiálnej teórie, začal v roku 1865 systematicky používať antisepsu. Znižovanie pooperačných infekcií potom zásadne rozšírilo možnosti chirurgie.</p>

<p>Historický obraz si vyžaduje spresnenie: Lister nebol jediným pôvodcom modernej prevencie infekcií a zmena bola postupná. Verejná demonštrácia éterovej anestézie sa uskutočnila už v roku 1846, teda pred hlavnou etapou jeho antiseptickej práce. Kniha najmä ukazuje, že účinný postup sa nestáva štandardom iba existenciou dôkazu. Rozhoduje aj vysvetlenie mechanizmu, dôvera, uskutočniteľnosť a zmena každodennej klinickej kultúry.</p>

<h2>4. Richard Harris: <em>Rigor Mortis</em></h2>

<p>Richard Harris analyzuje krízu reprodukovateľnosti v biomedicínskom výskume: nedostatočnú kontrolu experimentov, malé súbory, selektívne publikovanie, tlak na atraktívne výsledky a problémy pri prenose predklinických zistení do klinickej medicíny.</p>

<p>Kniha nedokazuje, že biomedicínske poznanie je ako celok nespoľahlivé. Poukazuje na mechanizmy, ktoré zvyšujú pravdepodobnosť falošne pozitívnych alebo nereprodukovateľných výsledkov. Pre nefrológa je dôležité rozlišovať biologickú plausibilitu, experimentálny výsledok, observačnú asociáciu a dôkaz klinického prínosu. Zlepšenie biomarkera alebo laboratórnej hodnoty nemusí znamenať nižšiu mortalitu, menej hospitalizácií ani lepšiu kvalitu života.</p>

<h2>5. Theodore G. Obenchain: <em>Genius Belabored</em></h2>

<p>Kniha približuje život Ignáca Fülöpa Semmelweisa. V pôrodníckej klinike vo Viedni rozpoznal súvislosť medzi vysokou mortalitou na horúčku šestonedieľok a prenosom materiálu z pitevne rukami lekárov a študentov. Po zavedení dezinfekcie rúk chlórovaným vápnom úmrtnosť výrazne klesla.</p>

<p>Populárny obraz osamelého génia, ktorého všetci súčasníci bezdôvodne odmietali, je však zjednodušený. Prijatie záverov komplikovala absencia dnešnej mikrobiológie, dobový vedecký rámec, komunikácia aj inštitucionálne pomery. Opatrnosť si vyžaduje aj spätné diagnostikovanie príčiny Semmelweisovho telesného a duševného úpadku. Obenchain presadzuje jednu z hypotéz, no historické podklady neumožňujú spoľahlivú definitívnu diagnózu.</p>

<h2>6. Erica Buist: <em>This Party’s Dead</em></h2>

<p>Autorka navštívila sviatky a rituály spojené so smrťou v Mexiku, Nepále, na Sicílii, v Thajsku, Madagaskare, Japonsku a Indonézii. Prostredníctvom reportáže skúma, ako rôzne spoločenstvá uchovávajú pamiatku zosnulých a začleňujú smrť do verejného a rodinného života.</p>

<p>Kniha nie je systematickým antropologickým výskumom a žiadnu kultúru nemožno redukovať na jeden rituál. Jej prínos je v narušení predstavy, že existuje jediný správny spôsob smútenia. Pre nefrológiu je to relevantné pri konzervatívnej liečbe zlyhania obličiek, ukončovaní dialýzy a paliatívnej starostlivosti. Kultúrna citlivosť pritom neznamená pripisovať pacientovi názory podľa pôvodu; rozhodujú jeho vlastné hodnoty a preferencie.</p>

<h2>7. Lewis Thomas: <em>The Lives of a Cell</em></h2>

<p>Lekár a vedecký esejista Lewis Thomas uvažuje o bunkovej biológii, mikroorganizmoch, ekológii, jazyku a vzájomnej závislosti živých systémov. Mnohé z textov pôvodne vychádzali v časopise <em>The New England Journal of Medicine</em>.</p>

<p>Eseje sú literárne a filozofické. Niektoré biologické poznatky sa od prvého vydania v roku 1974 zmenili, preto kniha nie je aktuálnym odborným zdrojom. Jej trvalá hodnota spočíva v prepájaní vedeckého pozorovania s úžasom, pochybnosťou a vedomím zložitosti. Je to užitočná protiváha ilúzii, že presný mechanizmus automaticky znamená úplné porozumenie živému systému.</p>

<h2>8. Anupam B. Jena a Christopher Worsham: <em>Random Acts of Medicine</em></h2>

<p>Autori využívajú prirodzené experimenty a rozsiahle databázy na skúmanie menej zjavných vplyvov na zdravotnú starostlivosť. Rozoberajú napríklad narušenie dopravy počas maratónov, rozdiely súvisiace s kalendárnym vekom detí či to, ako okolnosti a načasovanie vplývajú na rozhodnutia a výsledky.</p>

<p>Prirodzený experiment však nie je automaticky bezchybný ani rovnocenný randomizovanej štúdii. Platnosť záveru závisí od kvality dát, vierohodnosti identifikačnej stratégie, kontroly skreslení a reprodukovateľnosti. Jednotlivé populačné zistenia sa navyše nemajú používať na hodnotenie konkrétneho lekára alebo pacienta.</p>

<h2>9. Michael Cunningham: <em>The Hours</em></h2>

<p>Román prepája osudy troch žien v rôznych obdobiach. Jednou z postáv je Virginia Woolfová; životy ďalších dvoch sa rozvíjajú v dialógu s jej románom <em>Mrs Dalloway</em>. Dielo sa zaoberá depresiou, smrťou, identitou, starostlivosťou a napätím medzi vonkajšou rolou a vnútorným životom.</p>

<p>Klinickým podnetom je pripomenutie, že stručný zdravotný záznam zachytáva iba malú časť pacientovej reality. Človek s chronickou chorobou obličiek nie je súborom diagnóz, hodnôt eGFR, albuminúrie a liekov. Jeho rozhodnutia ovplyvňujú vzťahy, povinnosti, strach, únava a predstava o prijateľnom živote. Román pritom nemožno používať ako diagnostickú kazuistiku duševnej poruchy.</p>

<h2>10. Kazuo Ishiguro: <em>Never Let Me Go</em></h2>

<p>Dystopický román opisuje ľudí vychovávaných ako budúcich darcov orgánov. Nejde o realistický obraz transplantačnej medicíny, ale o skúmanie spoločnosti, ktorá jednej skupine prizná nižšiu morálnu hodnotu a jej telá podriadi potrebám iných.</p>

<p>Kniha otvára otázky telesnej autonómie, informovaného súhlasu, spravodlivosti a inštrumentalizácie človeka. Analógie so skutočnými čakacími listinami či nerovnosťou prístupu sú interpretačné, nie doslovné. Reálna transplantačná medicína je založená na právnej regulácii, ochrane darcu a pravidlách alokácie, hoci praktické otázky spravodlivosti zostávajú aktuálne.</p>

<h2>11. Kazuo Ishiguro: <em>The Remains of the Day</em></h2>

<p>Hlavný hrdina zasvätí život dokonalej službe, lojalite a profesijnej zdržanlivosti. Postupne si uvedomuje osobnú cenu oddanosti inštitúcii a vlastnej predstave dôstojnosti.</p>

<p>Román možno čítať ako obraz profesijného sebazaprenia, hoci nebol napísaný ako dielo o syndróme vyhorenia. Vyhorenie je pracovný fenomén spojený s chronickým stresom, nie synonymum oddanosti práci alebo ľútosti nad nenaplneným životom. Bibliograficky treba rozlišovať dve ocenenia: <strong>román získal Bookerovu cenu v roku 1989; Nobelovu cenu za literatúru získal Kazuo Ishiguro v roku 2017.</strong></p>

<h2>12. George Eliot: <em>Middlemarch</em></h2>

<p>Román zachytáva spoločenský život anglického provinčného mesta vrátane úsilia mladého lekára Tertiusa Lydgata zavádzať modernejšie medicínske postupy. Jeho ambície narážajú na ekonomické záujmy, spoločenské väzby, profesionálnu rivalitu aj vlastné rozhodnutia.</p>

<p><em>Middlemarch</em> nie je dokumentárnou analýzou zdravotníctva. Presvedčivo však ukazuje, že inovácie nevstupujú do neutrálneho prostredia. Ich prijatie ovplyvňujú moc, financovanie, reputácia, komunikácia a dôvera. Tento konflikt zostáva aktuálny pri reorganizácii starostlivosti, zavádzaní nových technológií aj presadzovaní postupov založených na dôkazoch.</p>

<h2>Osobitný význam pre nefrológiu</h2>

<p>Nefrológia je založená na dlhodobých terapeutických vzťahoch. Pacienti často prechádzajú postupným poklesom funkcie obličiek, zložitým rozhodovaním o náhrade funkcie obličiek, opakovanými hospitalizáciami a zásadnými zmenami každodenného života. Naratívna kompetencia môže pomôcť pri rozhovore o:</p>

<ul>
  <li>voľbe medzi domácou liečbou, strediskovou dialýzou, transplantáciou a konzervatívnym postupom,</li>
  <li>reálnom zaťažení pacienta dialyzačným režimom,</li>
  <li>adherencii, ktorá nemusí byť iba otázkou disciplíny,</li>
  <li>únave, bolesti, prurite a kognitívnych ťažkostiach,</li>
  <li>strate zamestnania, autonómie a sociálnych rolí,</li>
  <li>neistote spojenej s transplantáciou a možným zlyhaním štepu,</li>
  <li>cieľoch liečby pri krehkosti, multimorbidite a obmedzenej prognóze,</li>
  <li>ukončení dialýzy a starostlivosti na konci života.</li>
</ul>

<p>Pozorné počúvanie nenahrádza odborné rozhodovanie. Môže však odhaliť, že medicínsky uskutočniteľná liečba nezodpovedá pacientovým cieľom alebo že zdanlivá nonadherencia vzniká pre finančné, psychologické, kognitívne či organizačné prekážky.</p>

<h2>Ako tieto knihy čítať</h2>

<p>Najväčší prínos nemusí priniesť počet titulov, ale spôsob čítania. Pri každej knihe si možno položiť tri otázky:</p>

<ol>
  <li>Čo postava alebo autor prežíva, ale nedokáže priamo pomenovať?</li>
  <li>Ktoré moje klinické predpoklady text spochybňuje?</li>
  <li>Čo by sa v podobnej situácii malo zmeniť v komunikácii alebo organizácii starostlivosti?</li>
</ol>

<p>Literárne dielo nie je klinickým odporúčaním ani epidemiologickým dôkazom. Môže však byť bezpečným priestorom na premýšľanie o situáciách, ktorých etickú a emocionálnu zložitosť odborný text zachytáva iba čiastočne.</p>

<h2>Záver</h2>

<p>Dvanásť kníh ponúka pohľad na medicínu cez bolesť, dejiny chirurgie, vedeckú reprodukovateľnosť, smrť, transplantáciu, profesijnú identitu a vnútorný život pacienta. Ich hodnota nespočíva v terapeutických návodoch, ale v kultivovaní pozornosti, kritického myslenia a schopnosti vnímať človeka aj mimo diagnózy.</p>

<p><strong>Literatúra sama z nikoho neurobí lepšieho lekára.</strong> Môže však vytvoriť podmienky, aby sa lekár presnejšie pýtal, pozornejšie počúval a kritickejšie premýšľal o vede, pacientovi aj vlastnej profesijnej úlohe.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Spiker T. 12 Books That Will Inspire You to Be a Better Doctor. Medscape. 27. júla 2026. <a href="https://www.medscape.com/viewarticle/12-books-will-inspire-you-be-better-doctor-2026a1000pdm" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></li>
  <li><small><em>Milota MM, van Thiel GJMW, van Delden JJM. Narrative Medicine as a Medical Education Tool: A Systematic Review. Medical Teacher. 2019;41(7):802–810. DOI: 10.1080/0142159X.2019.1584274. <a href="https://pubmed.ncbi.nlm.nih.gov/30983460/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Mojarrad S, Khojasteh L, Soori A. Arts-Based Empathy Education in Healthcare: A Critical Systematic Review of Pedagogical Mechanisms and Evidence Gaps. BMJ Open. 2026;16:e110509. DOI: 10.1136/bmjopen-2025-110509. <a href="https://pubmed.ncbi.nlm.nih.gov/42014151/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Charon R. Narrative Medicine: A Model for Empathy, Reflection, Profession, and Trust. JAMA. 2001;286(15):1897–1902. DOI: 10.1001/jama.286.15.1897. <a href="https://pubmed.ncbi.nlm.nih.gov/11597295/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Loy M, Kowalsky R. Narrative Medicine: The Power of Shared Stories to Enhance Inclusive Clinical Care, Clinician Well-Being, and Medical Education. The Permanente Journal. 2024;28:23.116. DOI: 10.7812/TPP/23.116. <a href="https://doi.org/10.7812/TPP/23.116" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
  <li><small><em>Royal College of Surgeons of England. Joseph Lister in the Archives: The Father of Antiseptic Surgery. <a href="https://www.rcseng.ac.uk/library-and-publications/library/blog/lister-in-the-archives-the-father-of-antiseptic-surgery/" target="_blank" rel="noopener noreferrer">RCS England</a>.</em></small></li>
  <li><small><em>World Health Organization. Historical Perspective on Hand Hygiene in Health Care. WHO Guidelines on Hand Hygiene in Health Care. <a href="https://www.ncbi.nlm.nih.gov/books/NBK144018/" target="_blank" rel="noopener noreferrer">NCBI Bookshelf</a>.</em></small></li>
  <li><small><em>Daudet A. In the Land of Pain. Preklad a poznámky: Julian Barnes. Vintage. <a href="https://www.penguinrandomhouse.com/books/36970/in-the-land-of-pain-by-alphonse-daudet-edited-and-translated-by-julian-barnes/" target="_blank" rel="noopener noreferrer">Penguin Random House</a>.</em></small></li>
  <li><small><em>Wiman C. Zero at the Bone: Fifty Entries Against Despair. Farrar, Straus and Giroux; 2023. <a href="https://us.macmillan.com/books/9780374603458/zeroatthebone/" target="_blank" rel="noopener noreferrer">Macmillan</a>.</em></small></li>
  <li><small><em>Fitzharris L. The Butchering Art: Joseph Lister’s Quest to Transform the Grisly World of Victorian Medicine. Scientific American/Farrar, Straus and Giroux; 2017. <a href="https://us.macmillan.com/books/9780374715489/thebutcheringart/" target="_blank" rel="noopener noreferrer">Macmillan</a>.</em></small></li>
  <li><small><em>Harris R. Rigor Mortis: How Sloppy Science Creates Worthless Cures, Crushes Hope, and Wastes Billions. Basic Books; 2017. <a href="https://www.hachettebookgroup.com/titles/richard-harris/rigor-mortis/9781541644144/" target="_blank" rel="noopener noreferrer">Hachette Book Group</a>.</em></small></li>
  <li><small><em>Obenchain TG. Genius Belabored: Childbed Fever and the Tragic Life of Ignaz Semmelweis. University of Alabama Press; 2016. <a href="https://www.uapress.ua.edu/9780817390457/genius-belabored/" target="_blank" rel="noopener noreferrer">University of Alabama Press</a>.</em></small></li>
  <li><small><em>Buist E. This Party’s Dead: Grief, Joy and Spilled Rum at the World’s Death Festivals. Unbound; 2021. <a href="https://www.theportobellobookshop.com/9781783529544" target="_blank" rel="noopener noreferrer">Katalóg knihy</a>.</em></small></li>
  <li><small><em>Thomas L. The Lives of a Cell: Notes of a Biology Watcher. Viking Press; 1974. <a href="https://www.penguinrandomhouse.com/books/535043/the-lives-of-a-cell-by-lewis-thomas/" target="_blank" rel="noopener noreferrer">Penguin Random House</a>.</em></small></li>
  <li><small><em>Jena AB, Worsham C. Random Acts of Medicine: The Hidden Forces That Sway Doctors, Impact Patients, and Shape Our Health. Doubleday; 2023. <a href="https://www.penguinrandomhouse.com/books/708150/random-acts-of-medicine-by-anupam-b-jena-md-phd-and-christopher-worsham-md/" target="_blank" rel="noopener noreferrer">Penguin Random House</a>.</em></small></li>
  <li><small><em>Cunningham M. The Hours. Farrar, Straus and Giroux; 1998. <a href="https://us.macmillan.com/books/9781429957946/thehours/" target="_blank" rel="noopener noreferrer">Macmillan</a>.</em></small></li>
  <li><small><em>Ishiguro K. Never Let Me Go. Faber and Faber; 2005. <a href="https://www.faber.co.uk/product/9780571369157-never-let-me-go/" target="_blank" rel="noopener noreferrer">Faber</a>.</em></small></li>
  <li><small><em>Ishiguro K. The Remains of the Day. Faber and Faber; 1989. <a href="https://www.faber.co.uk/product/9780571322732-the-remains-of-the-day/" target="_blank" rel="noopener noreferrer">Faber</a>; <a href="https://thebookerprizes.com/the-booker-library/prize-years/1989" target="_blank" rel="noopener noreferrer">Booker Prize 1989</a>; <a href="https://www.nobelprize.org/prizes/literature/2017/summary/" target="_blank" rel="noopener noreferrer">Nobelova cena 2017</a>.</em></small></li>
  <li><small><em>Eliot G. Middlemarch: A Study of Provincial Life. William Blackwood and Sons; 1871–1872. <a href="https://www.gutenberg.org/ebooks/145" target="_blank" rel="noopener noreferrer">Project Gutenberg</a>.</em></small></li>
</ol>

<hr>

<p><em>Tento text má vzdelávací charakter a je určený zdravotníckym pracovníkom. Literárne diela ani tento komentár nenahrádzajú klinické odporúčania, individuálne odborné posúdenie alebo systematické medicínske vzdelávanie.</em></p>
HTML,
];

// Vkladanie do databazy

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
    echo "Migracia clanku: " . $articles[0]['title'] . "\n";
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
