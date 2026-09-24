<?php
/**
 * Odborny prehlad ketaminom asociovanej uropatie u deti a adolescentov.
 */

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
    'title'        => 'Ketamínom asociovaná uropatia u detí a adolescentov: diagnostika a manažment',
    'slug'         => 'ketaminom-asociovana-uropatia-deti-adolescenti',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-09-24 12:00:00',
    'is_top'       => 0,
    'excerpt'      => 'Ketamínom asociovaná uropatia môže u mladých užívateľov viesť od dráždivých symptómov dolných močových ciest ku kontrahovanému močovému mechúru, obštrukcii močovodov a sekundárnemu poškodeniu obličiek.',
    'content'      => <<<'HTML'
<p><strong>Ketamínom asociovaná uropatia (KAU)</strong> je závažný syndróm poškodenia močového mechúra a horných močových ciest, ktorý sa najčastejšie opisuje pri opakovanom neterapeutickom užívaní ketamínu. U detí a adolescentov ide o osobitne citlivú problematiku: príznaky môžu byť bagatelizované, užívanie drogy zatajené a obštrukčné poškodenie obličiek sa môže rozvinúť ešte pred stanovením diagnózy.</p>
<p>Dostupné dôkazy pozostávajú najmä z retrospektívnych kohort, kazuistík, mechanistických experimentov a konsenzuálnych odporúčaní. Preto treba odlišovať dobre opísané klinické prejavy od hypotéz o mechanizme a od liečebných postupov, ktorých účinnosť nebola potvrdená randomizovanými štúdiami.</p>

<h2>Prečo je problém dôležitý v pediatrii</h2>
<p>Najväčšia publikovaná skúsenosť s KAU pochádza zo súborov adolescentov a mladých dospelých, najmä z oblastí s rozšíreným rekreačným užívaním ketamínu. Kohorta 318 teenagerov a mladých dospelých bola vyšetrená v rámci multidisciplinárnej „one-stop“ kliniky, čo podporuje význam systematického urologického a adiktologického vyšetrenia. Novšie britské údaje upozorňujú aj na vznik špecializovanej služby pre pacientov mladších ako 16 rokov; skoré observačné údaje však nemožno automaticky zovšeobecniť na všetkých adolescentov.</p>
<p>V klinickej praxi sa na KAU má myslieť pri nevysvetlenej frekvencii močenia, urgencii, dyzúrii alebo panvovej bolesti, predovšetkým ak sú symptómy sprevádzané opakovanými negatívnymi kultiváciami moču, hematuriou, zníženou kapacitou močového mechúra alebo hydronefrózou. Neodsudzujúci rozhovor v súkromí je nevyhnutný. Pri maloletom pacientovi treba postupovať podľa miestnych pravidiel ochrany dieťaťa, dôvernosti a zapojenia zákonného zástupcu.</p>

<h2>Klinický obraz</h2>
<p>Typickým počiatočným obrazom sú symptómy dolných močových ciest:</p>
<ul>
<li>zvýšená frekvencia močenia a urgencia,</li>
<li>dyzúria a suprapubická alebo panvová bolesť,</li>
<li>noktúria a urgentná inkontinencia,</li>
<li>makroskopická alebo mikroskopická hematúria,</li>
<li>opakované „infekcie“ bez presvedčivého mikrobiologického nálezu.</li>
</ul>
<p>Pri progresii sa môže vytvoriť kontrahovaný, málo poddajný močový mechúr. Vysoké intravezikálne tlaky a zápalové zmeny v oblasti ureterovezikálnych junkcií môžu viesť k vezikoureterálnemu refluxu, obštrukcii, hydronefróze a poklesu funkcie obličiek. V pôvodnej kohorte 59 pacientov malo 30 (51 %) jednostrannú alebo obojstrannú hydronefrózu, štyria mali nález suspektný z papilárnej nekrózy a ôsmi mali zvýšený sérový kreatinín. Tieto čísla opisujú vybraných pacientov odoslaných na urologické pracovisko, nie prevalenciu v bežnej populácii.</p>
<p>Alarmujúcimi nálezmi sú oligúria, vzostup kreatinínu, hyperkaliémia, horúčka so systémovou zápalovou odpoveďou, makrohematúria s retenciou, silná bolesť v boku alebo bilaterálna hydronefróza. Vyžadujú urgentné urologické a nefrologické posúdenie.</p>

<h2>Možné mechanizmy poškodenia</h2>
<p>Ketamín a jeho metabolity sa vylučujú močom a pri opakovanom užívaní môžu poškodzovať urotel. Predpokladá sa narušenie ochrannej bariéry, oxidačný stres, zápal a následná remodelácia steny močového mechúra. Experimentálne štúdie s norketamínom a zvieracími modelmi podporujú biologickú plausibilitu priameho toxického účinku, ale ich výsledky nemožno bezprostredne preložiť na dávku, riziko alebo liečbu u detí.</p>
<p>Chronický zápal môže viesť k fibróze, strate elasticity a zníženiu compliance močového mechúra. Histologický obraz často pripomína chronickú intersticiálnu cystitídu, nejde však o dôkaz, že KAU a intersticiálna cystitída sú totožné ochorenia. Pri ťažkom postihnutí sa pridáva mechanická alebo funkčná obštrukcia horných močových ciest. KAU môže byť spojená aj s poškodením žlčových ciest a pečene, preto má byť anamnéza a laboratórne vyšetrenie širšie než iba urologické.</p>

<h2>Diagnostický postup</h2>
<h3>Anamnéza a fyzikálne vyšetrenie</h3>
<p>Treba sa pýtať na ketamín priamo, neutrálne a opakovane, vrátane frekvencie, trvania, odhadovanej dávky, spôsobu aplikácie a súbežného užívania iných látok. Samotný negatívny toxikologický skríning KAU nevylučuje, pretože časové okno detekcie a používané panely sú obmedzené. Zaznamenať treba mikčný denník, bolesť, epizódy hematúrie, predchádzajúce antibiotiká a sexuálne prenosné infekcie podľa klinickej situácie.</p>
<h3>Laboratórne vyšetrenia</h3>
<ul>
<li>močový sediment a kultivácia pred antibiotickou liečbou,</li>
<li>sérový kreatinín s odhadom eGFR, močovina, ióny a bikarbonát,</li>
<li>albuminúria alebo proteinúria podľa renálneho nálezu,</li>
<li>krvný obraz a zápalové parametre pri podozrení na komplikáciu,</li>
<li>pečeňové testy pri dlhodobom alebo intenzívnom užívaní.</li>
</ul>
<p>Negatívna kultivácia pri výrazných urologických symptómoch je dôležitá informácia, nie dôvod na opakované empirické antibiotické kúry bez ďalšieho vyšetrenia.</p>
<h3>Zobrazovanie a funkčné vyšetrenie</h3>
<p>Ultrasonografia obličiek a močového mechúra je vhodná ako prvé zobrazovacie vyšetrenie. Posudzuje hrúbku steny, orientačnú kapacitu, postmikčné reziduum a prítomnosť hydronefrózy. Pri podozrení na komplikovanú obštrukciu alebo inom nejasnom náleze sa podľa klinickej otázky zvažuje magnetická rezonancia alebo CT; radiačnú záťaž treba u detí minimalizovať.</p>
<p>Urodynamické vyšetrenie môže preukázať detruzorovú hyperaktivitu, zvýšenú senzitivitu, zníženú compliance a nízku kapacitu. Cystoskopia patrí do starostlivosti urológa, najmä pri hematúrii, ťažkých alebo pretrvávajúcich symptómoch a pri plánovaní intervencie. Môže ukázať erytém, petechie, ulcerácie, krvácanie a kontrahovaný močový mechúr. Biopsia sa indikuje selektívne, nie rutinne u každého pacienta; zvažuje sa najmä pri atypickom obraze alebo potrebe vylúčiť inú patológiu.</p>

<h2>Liečba a sledovanie</h2>
<h3>Abstinencia je základ</h3>
<p>Úplné ukončenie neterapeutického užívania ketamínu je najdôležitejším modifikovateľným zásahom. Pacientovi treba ponúknuť adiktologickú a psychiatrickú pomoc, posúdenie komorbidít, podporu rodiny podľa vhodnosti a plán bezpečného sledovania. Zlepšenie po abstinencii je možné, najmä v skorších štádiách, ale pretrvávajúca fibróza a obštrukcia môžu byť ireverzibilné. Opätovné užívanie znižuje šancu na stabilizáciu a môže viesť k recidíve symptómov.</p>
<h3>Symptomatická a orgánovo chrániaca liečba</h3>
<p>Liečba bolesti, urgencie a ďalších symptómov má byť individualizovaná a vedená odborníkmi so skúsenosťou s detskou urológiou. Nesteroidové antiflogistiká sa nemajú používať automaticky pri riziku akútneho poškodenia obličiek, dehydratácii alebo už zníženej funkcii obličiek. Anticholinergiká, beta-3 agonisty, neuromodulačné postupy a intravezikálne liečby môžu mať miesto podľa fenotypu, veku, registrácie a lokálnych odporúčaní, no dôkazy špecifické pre KAU sú obmedzené.</p>
<p>Pentosan polysulfát, hydrodistenzia, botulotoxín a koagulácia ulcerácií boli opísané v malých sériách alebo protokoloch pre vybrané prípady. Nemožno tvrdiť, že niektorý z týchto postupov je univerzálne účinný, ani ich používať ako náhradu abstinencie. Pri hydronefróze, obštrukcii alebo zhoršení renálnej funkcie je prioritou rýchla dekompresia močových ciest podľa urologického nálezu.</p>
<h3>Chirurgické možnosti</h3>
<p>Augmentačná cystoplastika, derivácia moču alebo iný rekonštrukčný výkon sa zvažujú iba pri ťažkom, funkčne devastujúcom a na konzervatívnu liečbu nereagujúcom postihnutí. Rozhodnutie vyžaduje skúsené urologické pracovisko, dlhodobé sledovanie a realistické posúdenie abstinencie. Rekonštrukcia nerieši pokračujúce užívanie ketamínu ani adiktologické riziko.</p>

<h2>Praktický algoritmus pre nefrológa a urológa</h2>
<ol>
<li>Pri nevysvetlených LUTS, panvovej bolesti, hematúrii alebo hydronefróze sa cielene opýtať na ketamín a iné látky.</li>
<li>Vylúčiť infekciu a zhodnotiť kreatinín, eGFR, ióny, močový nález a postmikčné reziduum.</li>
<li>Pri alarmujúcich nálezoch zabezpečiť urgentnú urologickú dekompresiu a nefrologické posúdenie.</li>
<li>Pri stabilnom stave doplniť ultrasonografiu, podľa potreby urodynamiku a cystoskopiu.</li>
<li>Začať multidisciplinárnu liečbu zameranú na abstinenciu, bolesť, funkciu mechúra a renálnu ochranu.</li>
<li>Naplánovať kontrolu symptómov, mikčného denníka, renálnej funkcie a zobrazovacieho nálezu; interval určiť podľa závažnosti.</li>
</ol>

<h2>Záver</h2>
<p>Ketamínom asociovaná uropatia môže u mladých ľudí spôsobiť rýchlo progresívne poškodenie dolných aj horných močových ciest. Najdôležitejšie je na diagnózu myslieť, pýtať sa bez stigmatizácie, včas zachytiť hydronefrózu a pokles funkcie obličiek a zabezpečiť trvalú abstinenciu s adiktologickou podporou. Presné percentá, mechanistické modely a jednotlivé intervencie treba interpretovať v kontexte obmedzenej kvality dôkazov a vybraných kohort.</p>
<p><small><em>Redakčné overenie k 24. septembru 2026: bibliografické údaje boli kontrolované cez PubMed eUtils a Europe PMC. Článok je odborným syntetickým prehľadom a nenahrádza individuálne diagnostické ani terapeutické rozhodnutie.</em></small></p>

<div class="pdf-keep-together"><hr><h2>Zdroje</h2><ol>
<li><small><em>Chu PSK, Ma WK, Wong SCW, et al. The destruction of the lower urinary tract by ketamine abuse: a new syndrome? BJU Int. 2008;102(11):1616–1622. doi:10.1111/j.1464-410X.2008.07920.x; <a href="https://pubmed.ncbi.nlm.nih.gov/18680495/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Tam YH, Ng CF, Pang KKY, et al. One-stop clinic for ketamine-associated uropathy: report on service delivery model, patients' characteristics and non-invasive investigations at baseline by a cross-sectional study in a prospective cohort of 318 teenagers and young adults. BJU Int. 2014;114(5):754–760. doi:10.1111/bju.12675; <a href="https://pubmed.ncbi.nlm.nih.gov/24552244/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Belal M, Downey A, Doherty R, et al. British Association of Urological Surgeons Consensus statements on the management of ketamine uropathy. BJU Int. 2024;134(2):148–154. doi:10.1111/bju.16404; <a href="https://pubmed.ncbi.nlm.nih.gov/38778743/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Bourillon A, Cornu JN, Hervé F, et al. Management of ketamine cystitis: National guidelines from the French Association of Urology (CUROPF/CTMH). Fr J Urol. 2024;34(14):102754. doi:10.1016/j.fjurol.2024.102754; <a href="https://pubmed.ncbi.nlm.nih.gov/39368630/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Abdelrahman A, Belal M. Rare but relevant: Ketamine-induced cystitis – an in-depth review for addiction medicine. Addiction. 2025;120(8):1689–1693. doi:10.1111/add.70052; <a href="https://pubmed.ncbi.nlm.nih.gov/40181691/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Zheng Z, Li Z, Yuan J, et al. Ketamine-associated upper urinary tract dysfunction: What we know from current literature. Asian J Urol. 2025;12(1):33–42. doi:10.1016/j.ajur.2024.05.004; <a href="https://pubmed.ncbi.nlm.nih.gov/39990075/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kulkarni S, Visa A, Isaac M, et al. Paediatric Ketamine Bladder Case Report: A Burgeoning Problem in the Paediatric Population. Case Rep Pediatr. 2026;2026:2254453. doi:10.1155/crpe/2254453; <a href="https://pubmed.ncbi.nlm.nih.gov/42682967/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Goss N, Corbett HJ, Brewster L, et al. Who are the children and young people attending the UK's first ketamine-induced uropathy clinic for under 16s?: an early insight into sociodemographic features. Arch Dis Child. 2026. doi:10.1136/archdischild-2026-330727; <a href="https://pubmed.ncbi.nlm.nih.gov/42772857/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Wong GL, Tam YH, Ng CF, et al. Liver injury is common among chronic abusers of ketamine. Clin Gastroenterol Hepatol. 2014;12(10):1759–1762.e1. doi:10.1016/j.cgh.2014.01.041; <a href="https://pubmed.ncbi.nlm.nih.gov/24534547/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol></div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ketaminom-asociovana-uropatia-deti-adolescenti_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\nMigrácia článku: {$articles[0]['title']}\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny): $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $error) {
        echo "Chyba: $error\n";
    }
} else {
    echo '<p>Článok bol spracovaný: ' . htmlspecialchars($articles[0]['title']) . '.</p>';
}
