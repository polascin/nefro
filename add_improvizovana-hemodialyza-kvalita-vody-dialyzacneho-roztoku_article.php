<?php
/**
 * Odborne a jazykovo revidovaný článok o improvizovanej domácej hemodialýze
 * a o tom, prečo je kvalita dialyzačnej vody a roztoku neprekročiteľnou
 * bezpečnostnou hranicou. Zdrojový mediálny príbeh nemá menovaného autora,
 * preto sa do source_authors.php nedopĺňa.
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
    'title'        => 'Improvizovaná domáca hemodialýza: prečo prežitie jedného človeka nie je dôkazom bezpečnosti',
    'slug'         => 'improvizovana-hemodialyza-kvalita-vody-dialyzacneho-roztoku',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Príbeh muža, ktorý si po vyčerpaní úspor zostrojil vlastný dialyzačný prístroj, obieha internet znova. Ukazuje reálnu nerovnosť v prístupe k liečbe – a zároveň to, čo v improvizácii chýba: kontrolu kvality vody a dialyzačného roztoku.',
    'content'      => <<<'HTML'
<p>Príbeh čínskeho pacienta, ktorý si po finančnom vyčerpaní rodiny zostrojil vlastnú hemodialyzačnú zostavu a prežil na nej trinásť rokov, sa v posledných týždňoch znova šíri po sociálnych sieťach. Stojí za to hneď na úvod uviesť jednu vec, ktorú nová vlna zdieľaní vynecháva: <strong>nejde o novú udalosť</strong>. Prípad opísali čínske médiá v januári 2013 a dnešné príspevky sú jeho recykláciou bez akéhokoľvek nového klinického údaja.</p>

<p>Príbeh má napriek tomu dve legitímne roviny. Prvou je nerovnosť v prístupe k liečbe, ktorá človeka dotlačí k improvizácii. Druhou je otázka, ktorú si nefrológ položí okamžite: čo presne v takejto zostave chýba a prečo to nemožno nahradiť šikovnosťou.</p>

<h2>Čo je z príbehu overiteľné</h2>

<p>Podľa dobových správ čínskych médií bola pacientovi diagnostikovaná urémia v roku 1993, v jeho 21 rokoch, počas posledného ročníka vysokoškolského štúdia. Šesť rokov absolvoval približne trinásť dialýz mesačne, čo vyčerpalo úspory rodiny s mesačným príjmom pod 1 500 jüanov pri cene okolo 400 jüanov za sedenie. Od roku 1996 experimentoval s vlastným riešením: kúpil použité krvné čerpadlo cez internet, dialyzačné súpravy získal cez známeho a dialyzátor stál približne 100 jüanov. Jedno sedenie ho vraj stálo okolo 60 jüanov, teda približne osminu nemocničnej ceny. Pri výkone mu asistovala matka.</p>

<p>Rovnaké správy citujú aj stanovisko nefrológa: takýto postup ľahko vedie k infekciám a nemá sa napodobňovať. Zdravotné poistenie v tom čase pokrývalo viac než 90 % nákladov na hemodialýzu – teda hlavný dôvod improvizácie sa medzičasom zmenil.</p>

<h2>Čo z príbehu overiť nemožno</h2>

<p>Z medicínskeho hľadiska je zoznam chýbajúcich údajov dlhší než zoznam dostupných:</p>

<ul>
  <li>nie je známe zloženie ani spôsob prípravy dialyzačného roztoku,</li>
  <li>nie sú dostupné žiadne mikrobiologické ani endotoxínové merania vody či roztoku,</li>
  <li>chýbajú laboratórne výsledky, záznamy o hospitalizáciách, o infekciách krvného riečiska a o účinnosti dialýzy,</li>
  <li>nie je zdokumentovaný režim antikoagulácie, kontrola ultrafiltrácie ani teplota a vodivosť roztoku,</li>
  <li>neexistuje nezávislé klinické overenie ničoho z uvedeného.</li>
</ul>

<p>Príbeh preto nie je dôkazom o metóde. Je svedectvom o jednom človeku, ktorý prežil – a prežitie jednotlivca nehovorí nič o pravdepodobnosti, s akou by prežili ďalší.</p>

<h2>Prečo je „len voda“ najväčší problém</h2>

<p>Pri bežnom sedení s prietokom dialyzačného roztoku 500 ml/min a trvaním štyri hodiny prejde okolo membrány približne <strong>120 litrov roztoku</strong>. Pacient je od tohto objemu oddelený jedinou vrstvou – dialyzačnou membránou. Práve preto nie je kvalita vody v dialýze technická podrobnosť, ale bezpečnostný základ celej metódy.</p>

<p>Medzinárodné normy radu ISO 23500 určujú limity, ktoré improvizovaná príprava nemá ako splniť ani ako overiť:</p>

<div class="table-responsive" role="region" aria-label="Limity mikrobiologickej a endotoxínovej čistoty dialyzačnej vody a roztoku" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kvapalina</th>
      <th scope="col">Počet mikroorganizmov</th>
      <th scope="col">Endotoxíny</th>
      <th scope="col">Poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Dialyzačná voda</th>
      <td>&lt; 100 KTJ/ml</td>
      <td>&lt; 0,25 EU/ml</td>
      <td>Zásahová úroveň býva na polovici limitu (50 KTJ/ml, 0,125 EU/ml).</td>
    </tr>
    <tr>
      <th scope="row">Štandardný dialyzačný roztok</th>
      <td>&lt; 100 KTJ/ml</td>
      <td>&lt; 0,5 EU/ml</td>
      <td>Platí pre roztok pripravený z vody a koncentrátu.</td>
    </tr>
    <tr>
      <th scope="row">Ultračistý dialyzačný roztok</th>
      <td>&lt; 0,1 KTJ/ml</td>
      <td>&lt; 0,03 EU/ml</td>
      <td>Vyžaduje ultrafilter zaradený za prípravou roztoku.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Na okraj patrí aj upozornenie na staršie číselné údaje, ktoré stále kolujú: hranica 2 EU/ml pochádza z prekonaného amerického štandardu a <strong>dnešný limit pre dialyzačnú vodu je 0,25 EU/ml</strong>, teda osemkrát prísnejší. Pri citovaní limitov sa oplatí overiť, z ktorého vydania normy pochádzajú.</p>

<p>Mikrobiológia pritom nie je jediná téma. Úprava vody musí odstrániť aj chemické kontaminanty – reverzná osmóza, zmäkčovanie a filtre s aktívnym uhlím nie sú zbytočná zložitosť. Historicky práve ich zlyhanie viedlo k hromadným poškodeniam pacientov: encefalopatii pri hliníku, hemolýze pri chloramínoch a k otravám pri fluoridoch. Domáca „prečistená voda“ bez pravidelného merania týchto parametrov nie je bezpečnostne porovnateľná s ničím z toho.</p>

<h2>Zloženie roztoku nie je tri soli</h2>

<p>Predstava, že dialyzačný roztok vznikne zmiešaním chloridu sodného, chloridu draselného a hydrogénuhličitanu sodného, je nebezpečné zjednodušenie. Roztok musí mať súčasne správnu koncentráciu sodíka (spravidla 135–140 mmol/l), draslíka (najčastejšie 2–3 mmol/l), vápnika (1,25–1,50 mmol/l), horčíka, hydrogénuhličitanu (približne 30–35 mmol/l) a pufrujúcej zložky, pričom všetky sa ovplyvňujú navzájom.</p>

<p>Dôsledky chýb sú okamžité a merateľné v minútach, nie v mesiacoch:</p>

<ul>
  <li><strong>Príliš nízky sodík</strong> vedie k hypoosmolarite, intravaskulárnej hemolýze a mozgovému edému; príliš vysoký k hypernatriémii a smädu s objemovým preťažením.</li>
  <li><strong>Chybná koncentrácia draslíka</strong> spôsobí buď hyperkaliémiu, alebo naopak prudkú hypokaliémiu – obe sú arytmogénne a obe môžu skončiť zástavou obehu.</li>
  <li><strong>Nesprávny vápnik</strong> mení kontraktilitu myokardu, krvný tlak aj parathormónovú os.</li>
  <li><strong>Chyba v pufri</strong> vyvolá metabolickú acidózu alebo alkalózu s poruchou vedomia a arytmiami.</li>
</ul>

<p>V riadenej prevádzke tieto chyby zachytáva kontinuálne meranie vodivosti s automatickým zastavením prietoku. Bez neho je jedinou kontrolou to, že pacient začne mať ťažkosti.</p>

<h2>Čo ešte prístroj zabezpečuje popri „filtrácii krvi“</h2>

<ol>
  <li><strong>Detektor vzduchu</strong> s uzáverom venóznej linky – vzduchová embólia je pri mimotelovom obehu bezprostredne smrteľná komplikácia.</li>
  <li><strong>Detektor úniku krvi</strong> do dialyzačného roztoku pri prasknutí membrány.</li>
  <li><strong>Kontrola teploty</strong> – roztok nad približne 42 °C spôsobuje hemolýzu.</li>
  <li><strong>Meranie vodivosti</strong> ako nepretržitá kontrola zloženia roztoku.</li>
  <li><strong>Objemovo riadená ultrafiltrácia</strong> – bez nej nemožno spoľahlivo určiť, koľko tekutiny sa odobralo.</li>
  <li><strong>Tlakové alarmy</strong> arteriálnej a venóznej linky, ktoré zachytia vypadnutie ihly alebo trombózu.</li>
  <li><strong>Validovaná dezinfekcia okruhu</strong> medzi sedeniami.</li>
</ol>

<p>Toto všetko sú vrstvy, ktoré zachytávajú chybu skôr, než sa prejaví na pacientovi. Improvizovaná zostava ich nemá – a to je jadro rozdielu, nie samotné „filtrovanie krvi“.</p>

<h2>Opakované použitie jednorazových súprav</h2>

<p>Opakované použitie hadicových setov určených na jedno použitie je samostatná kapitola. Materiál po expozícii krvi a dezinfekcii mení vlastnosti, zvyšky bielkovín tvoria biofilm a bez validovaného postupu spracovania nemožno preukázať ani sterilitu, ani mechanickú neporušenosť. Aj tam, kde sa opakované použitie dialyzátorov v minulosti robilo v riadenom režime, išlo o proces s testovaním objemu vlákien, kontrolou zvyškového dezinfekčného prostriedku a dokumentáciou – nie o opláchnutie a odloženie.</p>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o improvizovanej domácej hemodialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Muž si zostrojil funkčnú domácu hemodialyzačnú zostavu a prežil na nej roky</th>
      <td>Doložené len mediálne</td>
      <td>Opísané dobovými čínskymi médiami v roku 2013. Nejde o klinicky zdokumentovaný prípad a nie je k dispozícii žiadny objektívny parameter liečby.</td>
    </tr>
    <tr>
      <th scope="row">Ide o aktuálnu udalosť</th>
      <td>Nesprávne</td>
      <td>Príbeh je z januára 2013 a v roku 2026 sa iba recykluje bez nových údajov.</td>
    </tr>
    <tr>
      <th scope="row">Dôležitá je hlavne dialyzačná membrána, zvyšok prístroja je drahý prepych</th>
      <td>Nesprávne</td>
      <td>Membrána zabezpečuje výmenu látok. Bezpečnosť zabezpečujú detektory vzduchu a úniku krvi, kontrola teploty, vodivosti, tlakov a objemovo riadená ultrafiltrácia.</td>
    </tr>
    <tr>
      <th scope="row">Stačí „prečistená voda“</th>
      <td>Nesprávne</td>
      <td>Bez merania mikroorganizmov a endotoxínov nie je splnenie limitov overiteľné. Pri prietoku 500 ml/min prejde za sedenie okolo 120 litrov roztoku.</td>
    </tr>
    <tr>
      <th scope="row">Limit endotoxínov v dialyzačnej vode je 2 EU/ml</th>
      <td>Prekonané</td>
      <td>Ide o starší americký štandard. Podľa noriem radu ISO 23500 je limit pre dialyzačnú vodu 0,25 EU/ml a pre ultračistý roztok 0,03 EU/ml.</td>
    </tr>
    <tr>
      <th scope="row">Chybná koncentrácia roztoku je nepríjemná, ale zvládnuteľná</th>
      <td>Nesprávne</td>
      <td>Odchýlka sodíka vedie k hemolýze a edému mozgu, odchýlka draslíka k arytmii až k zástave obehu. Prejav je v minútach.</td>
    </tr>
    <tr>
      <th scope="row">Prežitie jedného pacienta dokazuje, že metóda je použiteľná</th>
      <td>Nesprávne</td>
      <td>Ide o výber podľa prežitia. Osudy tých, ktorí podobný postup neprežili, sa do správ nedostanú.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo si z toho vziať pre prax</h2>

<p>Skutočným poučením nie je technika, ale prístup k liečbe. Ak sa pacient dostane do bodu, keď zvažuje improvizáciu, zlyhalo niečo pred tým: financovanie, doprava, dostupnosť miesta v programe alebo informovanosť o možnostiach.</p>

<ol>
  <li><strong>Aktívne sa pýtať na finančnú a dopravnú záťaž liečby.</strong> Pacient ju spontánne často nepriznáva a rieši ju vynechávaním sedení skôr, než ju vysloví.</li>
  <li><strong>Vynechané sedenia brať ako varovný signál</strong>, nie ako nedisciplinovanosť. Za nimi býva doprava, práca, náklady alebo strach.</li>
  <li><strong>Ponúknuť domácu liečbu tam, kde je vhodná</strong> – peritoneálnu dialýzu alebo domácu hemodialýzu v riadenom programe so zaškolením, technickým servisom a kontrolou kvality vody. To je legitímna cesta k liečbe doma, na rozdiel od improvizácie.</li>
  <li><strong>Nemoralizovať pri rozhovore o „alternatívach“ z internetu.</strong> Vysvetlenie, že rozdiel nie je vo filtri, ale v ochranných vrstvách a v kvalite roztoku, funguje lepšie než odsúdenie.</li>
  <li><strong>Riešiť sociálnu situáciu ako súčasť liečebného plánu</strong>, nie ako doplnok mimo odbornej starostlivosti.</li>
</ol>

<h2>Záver</h2>

<p>Bezpečná domáca hemodialýza existuje a pre časť pacientov je lepšou voľbou než dochádzanie do strediska. Podmienkou však nie je odvaha ani technická zručnosť, ale program, ktorý zabezpečí kvalitu vody a dialyzačného roztoku, funkčné bezpečnostné prvky prístroja, zaškolenie a pravidelné kontroly. Príbeh z roku 2013 nie je návodom. Je pripomienkou, čo sa stane, keď je dialýza dostupná len tomu, kto na ňu má.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=domaca-dialyza-100-pacientov-treningovy-model">Sto pacientov na domácej dialýze: model tréningu a domáceho monitorovania liečby</a></li>
  <li><a href="article.php?slug=infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum">Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť</a></li>
  <li><a href="article.php?slug=zastava-obehu-pocas-hemodialyzy-mimotelovy-okruh">Zástava obehu počas hemodialýzy: mimotelový okruh, katétrový zámok a tichá záťaž dialyzačných sestier</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný mediálny zdroj:</strong> Homemade dialysis machine sustains Jiangsu man for 13 years. <em>Global Times</em>. 21. januára 2013. <a href="https://www.globaltimes.cn/content/755447.shtml" target="_blank" rel="noopener noreferrer">Global Times</a>. Living by his own hand. <em>China Daily</em>. 22. januára 2013. <a href="https://www.chinadaily.com.cn/life/2013-01/22/content_16152514.htm" target="_blank" rel="noopener noreferrer">China Daily</a>. Obe správy sú redakčné, bez menovaného autora.</em></small></p>

<p><small><em><strong>Kvalita vody a dialyzačného roztoku – norma:</strong> ISO 23500-1 až 23500-5: Preparation and quality management of fluids for haemodialysis and related therapies. Medzinárodná organizácia pre normalizáciu; aktuálne vydanie 2024. <a href="https://www.iso.org/standard/84368.html" target="_blank" rel="noopener noreferrer">ISO</a>.</em></small></p>

<p><small><em><strong>Odborné usmernenie:</strong> Hoenich NA, Mactier R, Morgan I, Boyle G, Croft D, Rylance P, Thompson C. Guideline on water treatment systems, dialysis water and dialysis fluid quality for haemodialysis and related therapies. <em>UK Kidney Association</em>, verzia 12, 2016. <a href="https://www.ukkidney.org/health-professionals/guidelines/guideline-water-treatment-systems-dialysis-water-and-dialysis-fluid" target="_blank" rel="noopener noreferrer">UK Kidney Association</a>.</em></small></p>

<p><small><em><strong>Urgentné stavy pri hemodialýze:</strong> Greenberg KI, Choi MJ. Hemodialysis Emergencies: Core Curriculum 2021. <em>American Journal of Kidney Diseases</em>. 2021;77(5):796–809. doi: 10.1053/j.ajkd.2020.11.024. <a href="https://pubmed.ncbi.nlm.nih.gov/33771393/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Údaje o pôvodnom prípade pochádzajú z dobových správ z januára 2013 a nie sú klinicky doložené; limity kvality vody a dialyzačného roztoku boli overené podľa aktuálneho radu noriem ISO 23500 dňa 23. augusta 2026. Text nie je a nesmie byť použitý ako návod na prípravu dialyzačného roztoku ani na zostavenie dialyzačného okruhu.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_improvizovana_hemodialyza',
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
